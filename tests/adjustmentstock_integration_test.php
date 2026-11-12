<?php
// Run with ADJUSTMENT_TEST_DB=1. Every fixture shadows its real table for this connection only.
if (PHP_SAPI !== 'cli' || getenv('ADJUSTMENT_TEST_DB') !== '1') {
    exit("Set ADJUSTMENT_TEST_DB=1 to run temporary-table integration tests.\n");
}
error_reporting(E_ALL);
set_error_handler(function ($severity, $message, $file, $line) {
    if (error_reporting() & $severity) { throw new ErrorException($message, 0, $severity, $file, $line); }
    return false;
});
define('BASEPATH', dirname(__DIR__) . '/system/');
define('ENVIRONMENT', 'development');
require dirname(__DIR__) . '/application/config/development/database.php';
require dirname(__DIR__) . '/application/libraries/Stock_booking_schema.php';
require dirname(__DIR__) . '/application/libraries/Stock_booking_store.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$config = $db['default'];
$connection = mysqli_init();
$connection->options(MYSQLI_OPT_CONNECT_TIMEOUT, 5);
$connection->real_connect($config['hostname'], $config['username'], $config['password'], $config['database'], (int)($config['port'] ?? 3306));
$connection->set_charset('utf8mb4');
$connection->query("SET SESSION sql_mode='STRICT_ALL_TABLES,NO_ENGINE_SUBSTITUTION'");
$tables = array('stock_material', 'stock_material_multigudang', 'kartu_stok', 'kartu_stok_multigudang', 'adjustment_stock', 'ms_inventory_category3', 'ms_gudang', 'ms_costbook', 'ms_costbook_backup');
foreach ($tables as $table) {
    $definition = $connection->query("SHOW CREATE TABLE $table")->fetch_row()[1];
    $connection->query(preg_replace('/^CREATE TABLE /', 'CREATE TEMPORARY TABLE ', $definition));
}
foreach (Stock_booking_schema::statements() as $sql) {
    $connection->query(str_replace('CREATE TABLE IF NOT EXISTS', 'CREATE TEMPORARY TABLE', $sql));
}
$store = new Stock_booking_store($connection, 'adjustment-test');
$store->query("INSERT INTO stock_booking_batches (batch_key,status,snapshot,max_legacy_detail,created_on) VALUES (?,'applied','{}',0,NOW())", array(str_repeat('a', 64)));
$store->query("INSERT INTO ms_gudang (id_gudang,nama_gudang) VALUES (1,'Utama'),(2,'Display'),(3,'Exdisplay'),(4,'Retur'),(5,'Konsinyasi')");
$store->query("INSERT INTO ms_inventory_category3 (id_category3,nama,deleted) VALUES ('ITEM','Barang asli',0)");
$store->query("INSERT INTO stock_material (id_stock,id_category3,id_gudang,qty,qty_book,qty_free,aktif,deleted,lotno) VALUES (1,'ITEM','1',20,5,15,'Y',0,'LOT-A')");
$store->query("INSERT INTO stock_material_multigudang (id_stock,id_category3,id_gudang,qty,qty_book,qty_free,aktif,deleted) VALUES (2,'ITEM','2',10,0,10,'Y',0)");
$store->query("INSERT INTO stock_booking_allocations (id_so_detail,stock_table,id_stock,qty_reserved,updated_on) VALUES (1,'stock_material',1,5,NOW())");
$checks = 0;
function adjustmentCheck($condition, $message) {
    global $checks;
    ++$checks;
    if (!$condition) { throw new RuntimeException($message); }
}
function adjustmentSnapshot() {
    global $store, $tables;
    $snapshot = array();
    foreach (array_merge($tables, array('stock_booking_operations')) as $table) {
        $snapshot[$table] = $store->query("SELECT * FROM $table");
    }
    return $snapshot;
}
function adjustmentPost($type = 'PLUS', $warehouse = '1', $qty = 2) {
    return array('request_key'=>bin2hex(random_bytes(16)), 'adjustment'=>$type, 'id_material'=>'ITEM',
        'id_stock'=>$warehouse === '1' ? '1' : '2', 'gudang'=>$warehouse, 'total_qty'=>$qty, 'note'=>'Koreksi tes');
}
function adjustmentApply($post, $mainOnly = true, $service = null) {
    global $store, $connection;
    static $sequence = 0;
    $connection->begin_transaction();
    try {
        ($service ?? $store)->adjustment($post, 'A' . date('ym') . str_pad(++$sequence, 5, '0', STR_PAD_LEFT), $mainOnly);
        $connection->commit();
    } catch (Throwable $error) { $connection->rollback(); throw $error; }
}
function adjustmentReject($post, $mainOnly = true, $service = null) {
    $before = adjustmentSnapshot();
    try { adjustmentApply($post, $mainOnly, $service); }
    catch (DomainException $error) {
        adjustmentCheck($before === adjustmentSnapshot(), 'Rejected input changed stock/history/operations');
        return;
    }
    throw new RuntimeException('Invalid adjustment accepted');
}
function adjustmentBalance($warehouse, $qty, $book, $free) {
    global $store;
    $row = $store->findStock('ITEM', $warehouse, $warehouse === '1' ? 'stock_material' : 'stock_material_multigudang');
    adjustmentCheck(array_map('intval', array_intersect_key($row, array_flip(array('qty','qty_book','qty_free')))) === array('qty'=>$qty,'qty_book'=>$book,'qty_free'=>$free), 'Incorrect balance for warehouse ' . $warehouse);
}

$first = adjustmentPost();
adjustmentApply($first); adjustmentApply(adjustmentPost()); adjustmentBalance('1', 24, 5, 19);
adjustmentReject($first);
$first['total_qty'] = 3; adjustmentReject($first);
$history = $store->query('SELECT * FROM adjustment_stock');
adjustmentCheck(count($history) === 2 && $history[0]['nama_material'] === 'Barang asli' && $history[0]['lotno'] === 'LOT-A', 'History did not use stored metadata');
foreach (array(null, '', 0, -1, '1.5', '1 OR 1=1', array(1), INF, '2147483648') as $qty) {
    adjustmentReject(adjustmentPost('MINUS', '1', $qty));
}
foreach (array('adjustment'=>'BAD', 'id_stock'=>'999', 'id_material'=>'OTHER', 'gudang'=>'2', 'note'=>' ', 'request_key'=>'bad') as $field=>$value) {
    $post = adjustmentPost(); $post[$field] = $value; adjustmentReject($post);
}
$post = adjustmentPost(); $post['note'] = str_repeat('x',256); adjustmentReject($post);
$post['note'] = "\xff"; adjustmentReject($post);
$store->query("UPDATE stock_material SET aktif='N' WHERE id_stock=1");
adjustmentReject(adjustmentPost());
$store->query("UPDATE stock_material SET aktif='Y',qty_free=999 WHERE id_stock=1");
adjustmentReject(adjustmentPost());
$store->query('UPDATE stock_material SET qty_free=qty-qty_book WHERE id_stock=1');
$store->query('UPDATE stock_material SET qty=2147483648,qty_free=2147483643 WHERE id_stock=1');
adjustmentReject(adjustmentPost());
$store->query('UPDATE stock_material SET qty=24,qty_free=19 WHERE id_stock=1');
adjustmentReject(adjustmentPost('MINUS', '1', 20));
adjustmentApply(adjustmentPost('MINUS', '1', 19)); adjustmentBalance('1', 5, 5, 0);
adjustmentApply(adjustmentPost('PLUS', '1', 10));
$post = adjustmentPost('MUTASI', '1', 3); $post['id_gudang_baru'] = '3';
adjustmentReject($post);
adjustmentApply($post, false); adjustmentBalance('1', 12, 5, 7); adjustmentBalance('3', 3, 0, 3);
$destination = $store->findStock('ITEM', '3', 'stock_material_multigudang');
adjustmentCheck($destination['lotno'] === 'LOT-A' && $destination['aktif'] === 'Y', 'New destination lost metadata');
$post = adjustmentPost('MUTASI', '3', 3); $post['id_stock'] = (string)$destination['id_stock']; $post['id_gudang_baru'] = '1';
adjustmentApply($post, false); adjustmentBalance('1', 15, 5, 10); adjustmentBalance('3', 0, 0, 0);
$post = adjustmentPost('MUTASI', '2', 2); $post['id_gudang_baru'] = '5';
adjustmentApply($post, false); adjustmentBalance('2', 8, 0, 8); adjustmentBalance('5', 2, 0, 2);
$post['id_gudang_baru'] = '2'; adjustmentReject($post, false);
$post['id_gudang_baru'] = '999'; adjustmentReject($post, false);
$post['id_gudang_baru'] = '4'; $post['total_qty'] = 9; adjustmentReject($post, false);
adjustmentApply(adjustmentPost('MINUS', '2', 2), false); adjustmentBalance('2', 6, 0, 6);
adjustmentApply(adjustmentPost('PLUS', '2', 2), false); adjustmentBalance('2', 8, 0, 8);

class FailingAdjustmentStore extends Stock_booking_store {
    public $failAt = 'INSERT INTO adjustment_stock';
    public function query($sql, $params = array()) {
        if (strpos($sql, $this->failAt) === 0) { throw new DomainException('Simulated failure'); }
        return parent::query($sql, $params);
    }
}
$failing = new FailingAdjustmentStore($connection, 'adjustment-test');
$post = adjustmentPost('MUTASI', '2', 2); $post['id_gudang_baru'] = '4';
adjustmentReject($post, false, $failing);
$failing->failAt = 'INSERT INTO kartu_stok_multigudang'; adjustmentReject($post, false, $failing);
adjustmentCheck(!$store->query("SELECT id_stock FROM stock_material_multigudang WHERE id_gudang='4'"), 'Rollback left destination stock');
$store->query('UPDATE stock_booking_control SET maintenance=1 WHERE id=1');
adjustmentReject(adjustmentPost());
$store->query('UPDATE stock_booking_control SET maintenance=0 WHERE id=1');
$store->query("INSERT INTO stock_booking_quarantine (stock_table,id_stock,id_category3,id_gudang,batch_key,status,target_booking,before_state,reason,created_on) VALUES ('stock_material',1,'ITEM','1',?,'active',5,'{}','test',NOW())", array(str_repeat('b',64)));
adjustmentReject(adjustmentPost());
$store->query('DELETE FROM stock_booking_quarantine');

function log_message($level, $message) {}
function is_php($version) { return version_compare(PHP_VERSION, $version, '>='); }
function html_escape($value) { return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
function base_url() { return '/'; }
function has_permission($permission) { return $permission === 'Adjustmentstock.View' || $GLOBALS['adjustmentWriteAllowed']; }
function show_error($message, $status = 500) { throw new DomainException($message, $status); }
function show_404() { throw new DomainException('Not found', 404); }
require BASEPATH . 'database/DB_driver.php';
require BASEPATH . 'database/DB_query_builder.php';
class CI_DB extends CI_DB_query_builder {}
require BASEPATH . 'database/drivers/mysqli/mysqli_driver.php';
$ciDb = new CI_DB_mysqli_driver(array('conn_id'=>$connection, 'db_debug'=>false, 'char_set'=>'utf8mb4', 'save_queries'=>false));
class AdjustmentInput {
    public $values = array();
    public $verb = 'POST';
    public function post($name = null) { return $name === null ? $this->values : ($this->values[$name] ?? null); }
    public function get($name) { return $this->post($name); }
    public function get_post($name) { return $this->post($name); }
    public function method($upper = false) { return $upper ? $this->verb : strtolower($this->verb); }
}
class AdjustmentAuth {
    public $denied = null;
    public function user_id() { return 'adjustment-test'; }
    public function restrict($permission) { if ($this->denied === $permission) { throw new DomainException('Denied'); } }
}
class AdjustmentSession {
    public $values = array();
    public function userdata($key) { return $this->values[$key] ?? null; }
    public function set_userdata($key, $value) { $this->values[$key] = $value; }
}
class AdjustmentLoad { public function library($name) {} }
class AdjustmentOutput { public function set_content_type($type) { return $this; } }
class AdjustmentTemplate {
    public $results;
    public $view;
    public function set($key, $value) { $this->results = $value; }
    public function title($title) {}
    public function page_icon($icon) {}
    public function render($view) { $this->view = $view; }
}
class AdjustmentUri {
    public $segments = array();
    public function segment($index) { return $this->segments[$index] ?? null; }
}
class BF_Model { public $db, $input; public function __construct() {} }
class Admin_Controller { public $db, $input, $auth, $load, $output, $Inventory_4_model, $stock_booking, $session, $uri, $template; }
$multi = in_array('--multi', $argv, true);
$module = $multi ? 'adjustmentstockmulti' : 'adjustmentstock';
$class = $multi ? 'Adjustmentstockmulti' : 'Adjustmentstock';
require dirname(__DIR__) . '/application/modules/' . $module . '/models/Inventory_4_model.php';
require dirname(__DIR__) . '/application/modules/' . $module . '/controllers/' . $class . '.php';
require dirname(__DIR__) . '/application/libraries/Stock_booking.php';
$input = new AdjustmentInput();
$auth = new AdjustmentAuth();
$session = new AdjustmentSession();
$adjustmentCi = (object)array('db'=>$ciDb, 'auth'=>$auth, 'session'=>$session);
function &get_instance() { global $adjustmentCi; return $adjustmentCi; }
$adapter = new Stock_booking();
$model = new Inventory_4_model(); $model->db = $ciDb; $model->input = $input;
$limitCode = 'A' . date('ym') . '99999';
$store->query('INSERT INTO adjustment_stock (id_transaksi,tanggal_transaksi) VALUES (?,CURDATE())', array($limitCode));
try { $model->generate_id(); throw new RuntimeException('Monthly adjustment counter wrapped'); }
catch (DomainException $error) { adjustmentCheck(true, 'Monthly counter limit rejected'); }
$store->query('DELETE FROM adjustment_stock WHERE id_transaksi=?', array($limitCode));
$controller = (new ReflectionClass($class))->newInstanceWithoutConstructor();
foreach (array('db'=>$ciDb, 'input'=>$input, 'auth'=>$auth, 'load'=>new AdjustmentLoad(), 'output'=>new AdjustmentOutput(),
    'Inventory_4_model'=>$model, 'stock_booking'=>$adapter, 'session'=>$session, 'uri'=>new AdjustmentUri(), 'template'=>new AdjustmentTemplate()) as $key=>$value) { $controller->$key = $value; }
function adjustmentControllerSave() {
    global $controller;
    ob_start();
    try { $controller->SavePlus(); return json_decode(ob_get_contents(), true, 512, JSON_THROW_ON_ERROR); }
    finally { ob_end_clean(); }
}
$origin = $multi ? '2' : '1';
$input->values = adjustmentPost('PLUS', $origin, 1);
$input->values['request_key'] = $adapter->adjustmentToken();
$input->values['nama_material'] = 'Nama palsu';
$before = adjustmentSnapshot();
$response = adjustmentControllerSave();
adjustmentCheck($response['status'] === 1 && preg_match('/^A[0-9]{9}$/D', $response['code']), 'Controller did not return clean successful JSON');
$depth = new ReflectionProperty(CI_DB_driver::class, '_trans_depth');
adjustmentCheck($depth->getValue($ciDb) === 0, 'Controller leaked transaction depth');
$row = $store->query('SELECT nama_material FROM adjustment_stock WHERE id_transaksi=?', array($response['code']));
adjustmentCheck(count($row) === 1 && $row[0]['nama_material'] === 'Barang asli', 'Controller trusted posted metadata');
$after = adjustmentSnapshot();
$response = adjustmentControllerSave();
adjustmentCheck($response['status'] === 0 && $after === adjustmentSnapshot(), 'Controller replay changed stored data');
$input->values['request_key'] = str_repeat('f',32);
adjustmentCheck(adjustmentControllerSave()['status'] === 0 && $after === adjustmentSnapshot(), 'Controller accepted token from another session');
$input->values['request_key'] = $adapter->adjustmentToken();
$input->values['total_qty'] = -2;
adjustmentCheck(adjustmentControllerSave()['status'] === 0 && $after === adjustmentSnapshot(), 'Controller accepted negative qty');
$input->verb = 'GET';
adjustmentCheck(adjustmentControllerSave()['status'] === 0 && $after === adjustmentSnapshot(), 'Controller GET changed stock');
$input->verb = 'POST';
$input->values = adjustmentPost('PLUS', $origin, 1);
$input->values['request_key'] = $adapter->adjustmentToken();
$adapterStore = new ReflectionProperty(Stock_booking::class, 'store');
$normalStore = $adapterStore->getValue($adapter);
$failing->failAt = 'INSERT INTO adjustment_stock';
$adapterStore->setValue($adapter, $failing);
$response = adjustmentControllerSave();
adjustmentCheck($response['status'] === 0 && $after === adjustmentSnapshot() && $depth->getValue($ciDb) === 0, 'Controller failure escaped rollback or leaked transaction state');
$adapterStore->setValue($adapter, $normalStore);
foreach (array('Adjustmentstock.Manage','Adjustmentstock.Add') as $permission) {
    $auth->denied = $permission;
    try { adjustmentControllerSave(); throw new RuntimeException('Unauthorized save accepted'); }
    catch (DomainException $error) { adjustmentCheck($after === adjustmentSnapshot(), 'Unauthorized save changed stock'); }
}
$auth->denied = 'Adjustmentstock.View';
foreach (array('AdjustNow','LotNumber','FormPlus','FormMinus','FormMutasi','AmbilDataMinus','AmbilDataMutasi','HitungJumlah') as $method) {
    try { $controller->$method('ITEM'); throw new RuntimeException('Unauthorized read accepted: ' . $method); }
    catch (DomainException $error) { adjustmentCheck($error->getMessage() === 'Denied', 'Read failed before permission check'); }
}
$auth->denied = null;
$controller->uri->segments = array(1=>$module,4=>$multi ? '2' : '1',5=>$origin);
$controller->AdjustNow('ITEM');
adjustmentCheck($controller->template->view === 'Adjust' && isset($session->values['adjustment_requests'][$controller->template->results['request_key']]), 'Adjustment form did not issue session token');
if ($multi) {
    $controller->MutasiNow('ITEM');
    adjustmentCheck($controller->template->view === 'CreateMutasi' && count($controller->template->results['gudang']) === 4, 'Mutasi form did not exclude source warehouse');
    foreach (array('index_display'=>'2','index_exdisplay'=>'3','index_retur'=>'4','index_konsinyasi'=>'5','index_mutasi'=>'1') as $method=>$warehouse) {
        $input->values = array('id_gudang'=>$warehouse);
        $controller->$method();
        foreach ($controller->template->results['history'] as $entry) {
            adjustmentCheck($entry->id_gudang === $warehouse || $entry->id_gudang_baru === $warehouse, 'History crossed warehouse filter');
        }
    }
} else {
    $input->values = array('draw'=>2,'start'=>0,'length'=>1,'search'=>array('value'=>'Koreksi tes'));
    ob_start(); $controller->get_data_adjustment_stock(); $historyResponse = json_decode(ob_get_clean(), true, 512, JSON_THROW_ON_ERROR);
    adjustmentCheck($historyResponse['draw'] === 2 && count($historyResponse['data']) === 1, 'History pagination failed');
    $input->values['search']['value'] = "' OR 1=1 --";
    ob_start(); $controller->get_data_adjustment_stock(); $historyResponse = json_decode(ob_get_clean(), true, 512, JSON_THROW_ON_ERROR);
    adjustmentCheck($historyResponse['recordsTotal'] > 0 && $historyResponse['recordsFiltered'] === 0 && !$historyResponse['data'], 'History search/counts are unsafe or incorrect');
}

$renderView = function ($file, $results) {
    ob_start();
    try { require $file; return ob_get_contents(); } finally { ob_end_clean(); }
};
$listViews = $multi ? array('index_display','index_exdisplay','index_retur','index_konsinyasi','index_mutasi') : array('index');
if ($multi) {
    foreach (array('mutasi','konsinyasi') as $view) {
        $controller->$view();
        $html = $renderView->call($controller, dirname(__DIR__) . '/application/modules/adjustmentstockmulti/views/' . $view . '.php', $controller->template->results);
        $dom = new DOMDocument(); $dom->loadHTML($html, LIBXML_NOERROR | LIBXML_NOWARNING); $xpath = new DOMXPath($dom);
        $expected = $view === 'mutasi' ? 5 : 1;
        adjustmentCheck($xpath->query('//select[@name="id_gudang"]/option[@value!=""]')->length === $expected, 'Warehouse chooser did not render expected warehouses');
    }
}
$record = (object)array('id_category3'=>'ITEM','id_stock'=>1,'id_gudang'=>'1','kode_barang'=>'TEST', 'nama'=>'<img src=x onerror=alert(1)>','qty'=>1,'qty_free'=>1);
$entry = (object)array('id_transaksi'=>'A1','tanggal_transaksi'=>date('Y-m-d'),'nama_material'=>$record->nama,'adjustment'=>'PLUS','nama_gudang'=>'Utama','note'=>'<script>alert(1)</script>','total_qty'=>1);
foreach (array(true, false) as $writeAllowed) {
    $GLOBALS['adjustmentWriteAllowed'] = $writeAllowed;
    foreach ($listViews as $view) {
        $html = $renderView->call($controller, dirname(__DIR__) . '/application/modules/' . $module . '/views/' . $view . '.php', array('stok'=>array($record), 'history'=>array($entry)));
        $dom = new DOMDocument(); $dom->loadHTML($html, LIBXML_NOERROR | LIBXML_NOWARNING); $xpath = new DOMXPath($dom);
        adjustmentCheck($xpath->query('//img')->length === 0 && strpos($html, '<script>alert(1)</script>') === false, 'List/history view failed HTML escaping');
        $header = $xpath->query('//table[@id="examplebb"]/thead/tr')->item(0);
        $body = $xpath->query('//table[@id="examplebb"]/tbody/tr')->item(0);
        adjustmentCheck($xpath->query('./th', $header)->length === $xpath->query('./td', $body)->length, 'Table columns mismatch for permission state');
    }
}

$lock = $store->query("SELECT GET_LOCK('waterco-stock-booking',15) acquired");
$second = new mysqli($config['hostname'], $config['username'], $config['password'], $config['database'], (int)($config['port'] ?? 3306));
try {
    adjustmentCheck((int)$lock[0]['acquired'] === 1 && (int)$second->query("SELECT GET_LOCK('waterco-stock-booking',0)")->fetch_row()[0] === 0, 'Concurrent connection entered stock critical section');
} finally { $second->close(); $store->query("SELECT RELEASE_LOCK('waterco-stock-booking')"); }

$store->query("INSERT INTO stock_material_multigudang (id_category3,id_gudang,qty,qty_book,qty_free,aktif,deleted) VALUES ('ITEM','2',1,0,1,'Y',0)");
adjustmentReject(adjustmentPost('MINUS','2',1), false);
echo "PASS: $checks $module integration checks using temporary tables only\n";
