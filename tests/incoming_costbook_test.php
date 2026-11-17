<?php
// Uses a randomly named database on localhost; operational tables are read only for their schema.
if (PHP_SAPI !== 'cli' || getenv('INCOMING_COSTBOOK_TEST_DB') !== '1') { exit("Set INCOMING_COSTBOOK_TEST_DB=1 to run isolated checks.\n"); }
error_reporting(E_ALL);
set_error_handler(function ($level, $message, $file, $line) {
    if (error_reporting() & $level) { throw new ErrorException($message, 0, $level, $file, $line); }
    return false;
});
define('BASEPATH', dirname(__DIR__) . '/system/');
define('ENVIRONMENT', 'development');
require dirname(__DIR__) . '/application/config/database.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$config = $db['default'];
$connection = new mysqli('127.0.0.1', $config['username'], $config['password'], '', 3306);
$connection->set_charset('utf8mb4');
$connection->query("SET SESSION sql_mode='STRICT_ALL_TABLES,NO_ENGINE_SUBSTITUTION'");
$connection->query('SET SESSION innodb_lock_wait_timeout=10');
$worker = ($argv[1] ?? '') === '--worker';
$database = $worker ? ($argv[2] ?? '') : 'incoming_cost_test_' . bin2hex(random_bytes(6));
if (!preg_match('/^incoming_cost_test_[a-f0-9]{12}$/D', $database)) { throw new RuntimeException('Unsafe test database'); }
function log_message($level, $message) { $GLOBALS['testLogs'][] = $message; }
function is_php($version) { return version_compare(PHP_VERSION, $version, '>='); }
require BASEPATH . 'database/DB_driver.php';
require BASEPATH . 'database/DB_query_builder.php';
class CI_DB extends CI_DB_query_builder {}
require BASEPATH . 'database/drivers/mysqli/mysqli_driver.php';
class IncomingTestDb extends CI_DB_mysqli_driver
{
    public $failAt = '', $failCommit = false;
    protected function _execute($sql) {
        if ($this->failAt !== '' && strpos($sql, $this->failAt) !== false) { throw new RuntimeException('Injected database failure'); }
        return parent::_execute($sql);
    }
    protected function _trans_commit() { return $this->failCommit ? false : parent::_trans_commit(); }
}
class Admin_Controller { public $db, $input, $auth, $load, $session, $stock_booking, $Pr_model; }
require dirname(__DIR__) . '/application/libraries/Stock_booking.php';
require dirname(__DIR__) . '/application/libraries/Stock_booking_schema.php';
require dirname(__DIR__) . '/application/modules/incoming/controllers/Incoming.php';
require dirname(__DIR__) . '/application/modules/costbook/controllers/Costbook.php';
require dirname(__DIR__) . '/application/modules/inventory_4/controllers/Inventory_4.php';
require dirname(__DIR__) . '/scripts/repair_aquamatic_costbook.php';
class IncomingTestStore extends Stock_booking_store
{
    public function query($sql, $params = array()) {
        if (($GLOBALS['storeFail'] ?? '') !== '' && strpos($sql, $GLOBALS['storeFail']) === 0 && ++$GLOBALS['storeFailCount'] === ($GLOBALS['storeFailNth'] ?? 1)) { throw new RuntimeException('Injected stock failure'); }
        if (($GLOBALS['skipCostUpdate'] ?? false) && strpos($sql, 'UPDATE ms_costbook ') === 0) { return array(); }
        return parent::query($sql, $params);
    }
}
class IncomingTestServices
{
    public $values;
    public function post($key = null) { return $key === null ? $this->values : ($this->values[$key] ?? null); }
    public function restrict($permission) { if (in_array($permission, $GLOBALS['denied'] ?? array(), true)) { throw new DomainException('Denied'); } }
    public function user_id() { return 'incoming-test'; }
    public function library($name) {}
    public function BuatID($date) { return 'IC_TEST'; }
    public function BuatNomor($date) { return 'IC-TEST'; }
}
function incomingRun($class, $method, $post) {
    global $connection, $database, $testDb, $testStore;
    $GLOBALS['testLogs'] = array();
    $controller = (new ReflectionClass($class))->newInstanceWithoutConstructor();
    $services = new IncomingTestServices(); $services->values = $post;
    $controller->auth = $controller->input = $controller->load = $controller->session = $controller->Pr_model = $services;
    $testDb = new IncomingTestDb(array('conn_id'=>$connection,'database'=>$database,'db_debug'=>true,'char_set'=>'utf8mb4','save_queries'=>false));
    $testDb->failAt = $GLOBALS['dbFail'] ?? ''; $testDb->failCommit = $GLOBALS['commitFail'] ?? false;
    $controller->db = $testDb;
    $testStore = new IncomingTestStore($connection, 'incoming-test');
    $booking = (new ReflectionClass('Stock_booking'))->newInstanceWithoutConstructor();
    (new ReflectionProperty('Stock_booking', 'ci'))->setValue($booking, $controller);
    (new ReflectionProperty('Stock_booking', 'store'))->setValue($booking, $testStore);
    $controller->stock_booking = $booking;
    ob_start();
    try { $controller->$method(); $json = ob_get_contents(); } finally { ob_end_clean(); }
    $result = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
    foreach ($GLOBALS['testLogs'] as $log) { if (strpos($log, 'ErrorException') !== false) { throw new RuntimeException($log); } }
    return $result;
}
$tables = array('ms_inventory_category3','ms_costbook','ms_costbook_history','ms_product_pricelist','stock_material','stock_material_multigudang','kartu_stok','tr_incoming','dt_incoming','dt_incoming_po','dt_trans_po','tr_purchase_order','tr_delivery_order_detail','ppn');
$checks = 0;
function incomingCheck($ok, $message) { ++$GLOBALS['checks']; if (!$ok) { throw new RuntimeException($message); } }
function incomingRows($table) { return $GLOBALS['connection']->query('SELECT * FROM ' . $table)->fetch_all(MYSQLI_ASSOC); }
function incomingReset($qty = 10, $costs = array(100)) {
    global $connection, $tables;
    foreach (array_merge($tables, array('stock_booking_operations','stock_booking_control','stock_booking_batches','stock_booking_quarantine','stock_booking_allocations')) as $table) { $connection->query('DELETE FROM ' . $table); }
    $connection->query("INSERT INTO stock_booking_control VALUES (1,0,NOW())");
    $connection->query("INSERT INTO stock_booking_batches VALUES ('" . str_repeat('a',64) . "','applied','{}',0,NOW())");
    $connection->query("INSERT INTO ms_inventory_category3(id_category3,nama,deleted) VALUES ('LVL400001','Test item',0)");
    $connection->query("INSERT INTO stock_material(id_category3,id_gudang,qty,qty_book,qty_free,deleted) VALUES ('LVL400001','1',$qty,0,$qty,0)");
    foreach ($costs as $cost) { $connection->query("INSERT INTO ms_costbook(id_category3,nilai_costbook) VALUES ('LVL400001'," . ($cost === null ? 'NULL' : (float)$cost) . ")"); }
    $connection->query("INSERT INTO ppn(persen) VALUES (10)");
    $connection->query("INSERT INTO tr_purchase_order(no_po,id_suplier,hutang_usaha,hutang_usaha_idr) VALUES ('PO1','SUP1',0,0),('PO2','SUP1',0,0)");
    $connection->query("INSERT INTO dt_trans_po(id_dt_po,no_po,idmaterial,qty,qty_terima) VALUES ('PO1-1','PO1','LVL400001',10,0),('PO2-1','PO2','LVL400001',10,0)");
    $GLOBALS['storeFail'] = $GLOBALS['dbFail'] = ''; $GLOBALS['commitFail'] = $GLOBALS['skipCostUpdate'] = false; $GLOBALS['denied'] = array();
    $GLOBALS['storeFailCount'] = 0; $GLOBALS['storeFailNth'] = 1;
}
function incomingPost($price = 200) {
    return array('tanggal'=>'2026-11-17','matauang'=>'idr','id_suplier'=>'SUP1','pic'=>'Test','id_gudang'=>'1',
        'dt'=>array(array('nopo'=>'PO1','detail'=>array(array('id_material'=>'LVL400001','iddtpo'=>'PO1-1','qtyrecive'=>2,'hargasatuan'=>$price,'ppn'=>0)))));
}
function incomingSnapshot() {
    $result = array(); foreach (array_merge($GLOBALS['tables'], array('stock_booking_operations')) as $table) { $result[$table] = incomingRows($table); } return $result;
}
function incomingReject($post, $contains) {
    $before = incomingSnapshot(); $result = incomingRun('Incoming','SaveNew',$post);
    incomingCheck($result['status'] === 0 && strpos($result['pesan'], $contains) !== false, 'Unexpected rejection: ' . json_encode($result));
    incomingCheck(incomingSnapshot() === $before, 'Rejected Incoming retained data');
}
function aquamaticSeed() {
    global $connection;
    incomingReset();
    foreach (array('LVL41431','LVL41432') as $id) {
        $connection->query("INSERT INTO ms_inventory_category3(id_category3,nama,deleted) VALUES ('$id','Aquamatic fixture',0)");
        $connection->query("INSERT INTO stock_material(id_category3,id_gudang,qty,qty_book,qty_free,deleted) VALUES ('$id','1',3,0,3,0)");
        $connection->query("INSERT INTO dt_trans_po(id_dt_po,no_po,idmaterial,qty,qty_terima,hargasatuan) VALUES ('$id-PO','PO1','$id',4,4,10)");
        $connection->query("INSERT INTO dt_incoming(id_data,id_incoming,id_dt_po,id_material,qty_recive,harga_satuan_usd,harga_total_idr,kurs) VALUES ('AQUA','AQUA-IN','$id-PO','$id',4,10,80,2)");
        $connection->query("INSERT INTO kartu_stok(id_category3,id_gudang,qty,qty_akhir,qty_transaksi,transaksi,no_transaksi,harga_do,created_on) VALUES ('$id','1',0,4,4,'incoming','AQUA-IN',80,'2026-11-01 12:00:00'),('$id','1',4,3,1,'delivery order','AQUA-DO',0,'2026-11-02 12:00:00')");
        $connection->query("INSERT INTO tr_delivery_order_detail(no_do,id_category3,qty_do,cost_book) VALUES ('AQUA-DO','$id',1,NULL)");
    }
    $connection->query("INSERT INTO tr_incoming(id_data,id_incoming,tanggal,created_date,kurs,matauang) VALUES ('AQUA','AQUA-IN','2026-11-01','2026-11-01 12:00:00',2,'usd')");
}
function aquamaticReject($approved) {
    global $connection;
    $before=incomingSnapshot(); $connection->begin_transaction();
    try { aquamaticApply(new IncomingTestStore($connection,'repair-test'),$approved); throw new LogicException('Expected rejected repair'); }
    catch (DomainException $error) { $connection->rollback(); }
    catch (RuntimeException $error) { $connection->rollback(); }
    incomingCheck(incomingSnapshot() === $before,'Rejected repair retained changes');
}
if ($worker) {
    $connection->select_db($database);
    echo "READY\n"; flush();
    if (($argv[3] ?? '') === 'master') {
        echo json_encode(incomingRun('Costbook','saveAddCostbook',array('inventory_3'=>'LVL400001','costbook'=>100))), "\n";
    } else {
        $s = new Stock_booking_store($connection, 'race-test');
        $connection->query("SELECT GET_LOCK('waterco-stock-booking',15)");
        $connection->begin_transaction();
        try { $s->receiveIncoming('LVL400001',2,(float)$argv[4],$argv[3]); $connection->commit(); echo "OK\n"; }
        catch (Throwable $e) { $connection->rollback(); echo 'ERROR: ', $e->getMessage(), "\n"; }
        finally { $connection->query("SELECT RELEASE_LOCK('waterco-stock-booking')"); }
    }
    exit;
}
$created = false; $processes = array();
try {
    $connection->query('CREATE DATABASE ' . $database . ' CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci'); $created = true;
    $connection->select_db($database);
    foreach ($tables as $table) {
        $ddl = $connection->query('SHOW CREATE TABLE waterco_demo.' . $table)->fetch_row()[1];
        $connection->query(preg_replace('/ENGINE=\w+/', 'ENGINE=InnoDB', $ddl));
    }
    foreach (Stock_booking_schema::statements() as $sql) { $connection->query($sql); }
    incomingReset(); $result = incomingRun('Incoming','SaveNew',incomingPost());
    incomingCheck($result['status'] === 1, 'Normal Incoming failed: ' . json_encode($result));
    incomingCheck((float)incomingRows('ms_costbook')[0]['nilai_costbook'] === 116.67 && (int)incomingRows('stock_material')[0]['qty'] === 12, 'Incorrect weighted HPP/qty');
    incomingCheck((float)incomingRows('kartu_stok')[0]['cost_book'] === 116.67 && count(incomingRows('kartu_stok')) === 1, 'Stock card cost mismatch');
    incomingCheck((float)incomingRows('tr_incoming')[0]['total_barang'] === 400.0 && (float)incomingRows('tr_incoming')[0]['hutang_idr'] === 400.0, 'Header total counted twice');
    incomingReset(0,array()); incomingCheck(incomingRun('Incoming','SaveNew',incomingPost())['status'] === 1 && (float)incomingRows('ms_costbook')[0]['nilai_costbook'] === 200.0, 'Missing zero-stock master not initialized');
    incomingReset(0,array(0)); incomingCheck(incomingRun('Incoming','SaveNew',incomingPost())['status'] === 1 && (float)incomingRows('ms_costbook')[0]['nilai_costbook'] === 200.0, 'Initial zero costbook not updated');
    incomingReset(1,array()); incomingReject(incomingPost(), 'stok lama');
    foreach (array(null,-1,0) as $invalid) { incomingReset(10,array($invalid)); incomingReject(incomingPost(), $invalid === null || $invalid === -1 ? 'Nilai biaya' : 'HPP stok lama'); }
    incomingReset(10,array(100,200)); incomingReject(incomingPost(), 'ganda');
    incomingReset(); incomingCheck(incomingRun('Incoming','SaveNew',incomingPost(100))['status'] === 1 && (float)incomingRows('ms_costbook')[0]['nilai_costbook'] === 100.0, 'Unchanged HPP rejected');
    incomingReset(); $post = incomingPost(); $post['dt'][0]['detail'][] = $post['dt'][0]['detail'][0];
    incomingCheck(incomingRun('Incoming','SaveNew',$post)['status'] === 1 && (int)incomingRows('stock_material')[0]['qty'] === 14 && count(incomingRows('kartu_stok')) === 1, 'Repeated product not aggregated');
    incomingCheck((int)incomingRows('dt_trans_po')[0]['qty_terima'] === 4 && count(incomingRows('dt_incoming')) === 2, 'Repeated PO details lost');
    incomingReset(0,array()); $post = incomingPost(5); $post['matauang']='usd'; $post['kurs']=2; $post['dt'][0]['detail'][0]['ppn']=10;
    $second=$post['dt'][0]; $second['nopo']='PO2'; $second['detail'][0]['iddtpo']='PO2-1'; $post['dt'][]=$second;
    incomingCheck(incomingRun('Incoming','SaveNew',$post)['status'] === 1, 'Multiple PO receipt failed');
    foreach (incomingRows('tr_purchase_order') as $po) { incomingCheck((float)$po['hutang_usaha'] === 11.0 && (float)$po['hutang_usaha_idr'] === 22.0, 'PO debt/tax/rate incorrect'); }
    incomingCheck((float)incomingRows('tr_incoming')[0]['total_barang'] === 40.0 && (float)incomingRows('tr_incoming')[0]['total_ppn'] === 4.0 && (float)incomingRows('ms_costbook')[0]['nilai_costbook'] === 10.0, 'Currency/PPN entered HPP incorrectly');
    incomingCheck((float)incomingRows('tr_incoming')[0]['hutang_kurs'] === 22.0 && (float)incomingRows('tr_incoming')[0]['hutang_idr'] === 44.0,'Header currency debt differs from PO debt');
    incomingReset(); $post=incomingPost(); $post['dt'][0]['detail'][0]['qtyrecive']=11; incomingReject($post, 'sisa PO');
    incomingReset(); $post=incomingPost(); $post['dt'][0]['detail'][0]['qtyrecive']='1 OR 1=1'; incomingReject($post, 'Nilai biaya');
    incomingReset(); $post=incomingPost(); $post['id_suplier']='OTHER'; incomingReject($post, 'supplier');
    incomingReset(); $post=incomingPost(); $post['matauang']=array('idr'); incomingReject($post, 'header');
    incomingReset(); $post=incomingPost(); $post['dt'][0]['nopo']=array('PO1'); incomingReject($post, 'Referensi PO');
    incomingReset(); $post=incomingPost(); $post['dt'][0]['detail'][0]['iddtpo']=array('PO1-1'); incomingReject($post, 'detail');
    foreach (array('INSERT INTO `tr_incoming`','INSERT INTO `dt_incoming_po`','INSERT INTO `dt_incoming`','UPDATE `dt_trans_po`','UPDATE tr_purchase_order') as $fail) {
        incomingReset(); $GLOBALS['dbFail']=$fail; incomingReject(incomingPost(), 'Transaksi stok gagal');
    }
    foreach (array('UPDATE stock_material','INSERT INTO kartu_stok','UPDATE ms_costbook') as $fail) {
        incomingReset(); $GLOBALS['storeFail']=$fail; incomingReject(incomingPost(), 'Transaksi stok gagal');
    }
    incomingReset(0,array()); $GLOBALS['storeFail']='INSERT INTO ms_costbook'; incomingReject(incomingPost(), 'Transaksi stok gagal');
    incomingReset(); $GLOBALS['commitFail']=true; incomingReject(incomingPost(), 'Transaksi stok gagal');
    incomingReset(); $GLOBALS['skipCostUpdate']=true; incomingReject(incomingPost(), 'Transaksi stok gagal');
    incomingReset(); $id=incomingRows('ms_inventory_category3')[0]['id'];
    $post=array('id'=>$id,'id_category3'=>'LVL400001','id_type'=>'T1','id_category1'=>'C1','id_category2'=>'C2','nama'=>'Edited','maker'=>'Test','status'=>'aktif','kode_barang'=>'CODE','kode_mas'=>'M');
    incomingCheck(incomingRun('Inventory_4','saveInventory',$post)['status'] === 1 && count(incomingRows('ms_costbook')) === 1 && (float)incomingRows('ms_costbook')[0]['nilai_costbook'] === 100.0, 'Editing product reset/duplicated HPP');
    $post['id']=''; incomingCheck(incomingRun('Inventory_4','saveInventory',$post)['status'] === 1 && count(incomingRows('ms_costbook')) === 2, 'New product missing initial master');
    incomingReset(0,array()); incomingCheck(incomingRun('Costbook','saveAddCostbook',array('inventory_3'=>'LVL400001','costbook'=>'1,200.50'))['status'] === 1, 'Add costbook failed');
    incomingCheck(incomingRun('Costbook','saveAddCostbook',array('inventory_3'=>'LVL400001','costbook'=>100))['status'] === 0 && count(incomingRows('ms_costbook')) === 1, 'Duplicate master accepted');
    $id=incomingRows('ms_costbook')[0]['id']; incomingCheck(incomingRun('Costbook','saveEditCostbook',array('id'=>$id,'costbook'=>1200.5))['status'] === 1 && count(incomingRows('ms_costbook_history')) === 1, 'Unchanged master edit/history failed');
    incomingCheck(incomingRun('Costbook','save_check_costbook',array('check'=>array(0),'detail'=>array(array('id_category3'=>'LVL400001','costbook_report'=>200))))['status'] === 1 && (float)incomingRows('ms_costbook')[0]['nilai_costbook'] === 200.0,'Bulk costbook check failed');
    $before=incomingSnapshot(); incomingCheck(incomingRun('Costbook','save_check_costbook',array('check'=>array(0,0),'detail'=>array(array('id_category3'=>'LVL400001','costbook_report'=>100))))['status'] === 0 && incomingSnapshot() === $before,'Duplicate bulk costbook selection accepted');
    incomingCheck(incomingRun('Costbook','saveAddCostbook',array('inventory_3'=>'LVL400001','costbook'=>'1,2'))['status'] === 0,'Malformed amount accepted');
    incomingReset(); $testStore = new Stock_booking_store($connection,'test'); $connection->begin_transaction();
    incomingCheck($testStore->receiveIncoming('LVL400001',2,400,'RETRY') === true && $testStore->receiveIncoming('LVL400001',2,400,'RETRY') === false, 'Same reference not idempotent'); $connection->commit();
    foreach (array(false,true) as $masterRace) {
        incomingReset(0,array()); $connection->begin_transaction(); $connection->query("SELECT * FROM ms_inventory_category3 WHERE id_category3='LVL400001' FOR UPDATE");
        $processes=array();
        foreach (array(array('RACE1',200),array($masterRace?'master':'RACE2',400)) as $args) {
            $pipes=array(); $proc=proc_open(array(PHP_BINARY,'-n','-d','extension_dir='.ini_get('extension_dir'),'-d','extension=mysqli',__FILE__,'--worker',$database,$args[0],(string)$args[1]),array(0=>array('pipe','r'),1=>array('pipe','w'),2=>array('pipe','w')),$pipes);
            if (!is_resource($proc)) { throw new RuntimeException('Cannot start race worker'); }
            stream_set_timeout($pipes[1],20); incomingCheck(trim((string)fgets($pipes[1])) === 'READY','Race worker not ready');
            $processes[]=array($proc,$pipes);
        }
        $connection->commit();
        foreach ($processes as $process) {
            list($proc,$pipes)=$process; fclose($pipes[0]); $out=stream_get_contents($pipes[1]); $err=stream_get_contents($pipes[2]); fclose($pipes[1]); fclose($pipes[2]);
            incomingCheck(proc_close($proc) === 0 && $err === '' && strpos($out,'ERROR:') === false,'Race worker failed: '.$out.$err);
        }
        $processes=array(); incomingCheck(count(incomingRows('ms_costbook')) === 1 && (float)incomingRows('ms_costbook')[0]['nilai_costbook'] === ($masterRace?100.0:150.0),'Concurrent writers duplicated/lost HPP');
        incomingCheck((int)incomingRows('stock_material')[0]['qty'] === ($masterRace?2:4),'Concurrent incoming qty wrong');
    }
    aquamaticSeed(); $store=new IncomingTestStore($connection,'repair-test'); $before=incomingSnapshot();
    $preview=aquamaticPreview($store); $preview['actor']='repair-test';
    incomingCheck(incomingSnapshot() === $before && $preview['items']['LVL41431']['ready'] && $preview['items']['LVL41432']['proposed_costbook'] === 20.0,'Read-only repair preview/reconciliation failed');
    incomingCheck(count($preview['items']['LVL41431']['missing_hpp_do']) === 1,'Missing HPP DO not reported');
    $connection->begin_transaction(); $repair=aquamaticApply($store,$preview); $connection->commit();
    incomingCheck($repair['changed'] === array('LVL41431','LVL41432'),'Two verified costbooks not restored');
    $after=incomingSnapshot(); unset($before['ms_costbook'],$after['ms_costbook']); incomingCheck($before === $after,'Repair changed stock/PO/DO/history');
    $connection->begin_transaction(); $repair=aquamaticApply($store,$preview); $connection->commit(); incomingCheck($repair['changed'] === array(),'Repair rerun not idempotent');
    aquamaticSeed(); $preview=aquamaticPreview($store); $preview['actor']='repair-test';
    $changed=$preview; $changed['items']['LVL41431']['proposed_costbook']=1; aquamaticReject($changed);
    $changed=$preview; $changed['items']['LVL41431']['source_hash']=str_repeat('0',64); aquamaticReject($changed);
    $GLOBALS['storeFail']='INSERT INTO ms_costbook'; $GLOBALS['storeFailCount']=0; $GLOBALS['storeFailNth']=2; aquamaticReject($preview);
    $GLOBALS['storeFail']='';
    $connection->query("UPDATE stock_material SET qty=4,qty_free=4 WHERE id_category3='LVL41432'"); aquamaticReject($preview);
    aquamaticSeed(); $connection->query("UPDATE kartu_stok SET qty=1 WHERE id_category3='LVL41432' AND transaksi='incoming'");
    $preview=aquamaticPreview($store); $preview['actor']='repair-test'; incomingCheck(!$preview['items']['LVL41432']['ready'] && strpos($preview['items']['LVL41432']['reason'],'awal') !== false,'Unvalued opening stock accepted'); aquamaticReject($preview);
    aquamaticSeed(); $connection->query("UPDATE kartu_stok SET qty=1,qty_akhir=5 WHERE id_category3='LVL41432' AND transaksi='incoming'");
    $connection->query("UPDATE kartu_stok SET qty=5,qty_akhir=4 WHERE id_category3='LVL41432' AND transaksi='delivery order'");
    $connection->query("UPDATE stock_material SET qty=4,qty_free=4 WHERE id_category3='LVL41432'");
    $opening=array('LVL41432'=>array('qty'=>1,'costbook'=>10,'as_of'=>'2026-11-01','source'=>'Verified opening invoice fixture','verified_by'=>'finance-test'));
    $preview=aquamaticPreview($store,false,$opening); $preview['actor']='repair-test'; incomingCheck($preview['items']['LVL41432']['ready'] && $preview['items']['LVL41432']['proposed_costbook'] === 18.0,'Verified opening cost not included in weighted HPP');
    $connection->begin_transaction(); $repair=aquamaticApply($store,$preview); $connection->commit(); incomingCheck($repair['changed'] === array('LVL41431','LVL41432'),'Verified opening repair failed');
    $opening['LVL41432']['as_of']='2026-11-02'; incomingCheck(!aquamaticPreview($store,false,$opening)['items']['LVL41432']['ready'],'Wrong opening date accepted');
    aquamaticSeed(); $connection->query("UPDATE dt_incoming SET kurs=3 WHERE id_material='LVL41431'"); incomingCheck(!aquamaticPreview($store)['items']['LVL41431']['ready'],'Wrong source rate accepted');
    aquamaticSeed(); $connection->query("UPDATE dt_trans_po SET hargasatuan=11 WHERE idmaterial='LVL41431'"); incomingCheck(!aquamaticPreview($store)['items']['LVL41431']['ready'],'Wrong PO price accepted');
    aquamaticSeed(); $connection->query("UPDATE kartu_stok SET qty=2 WHERE id_category3='LVL41431' AND transaksi='delivery order'"); incomingCheck(!aquamaticPreview($store)['items']['LVL41431']['ready'],'Broken stock chain accepted');
    aquamaticSeed();
    $connection->query("UPDATE kartu_stok SET qty=5 WHERE transaksi='incoming' AND id_category3 IN ('LVL41431','LVL41432')");
    $preview=aquamaticPreview($store,false,array(),'latest-incoming'); $preview['actor']='repair-test';
    incomingCheck($preview['items']['LVL41431']['ready'] && $preview['items']['LVL41432']['proposed_costbook'] === 20.0,'Latest Incoming incorrectly requires opening HPP');
    $before=incomingSnapshot(); $connection->begin_transaction(); $repair=aquamaticApply($store,$preview); $connection->commit();
    incomingCheck(count($repair['changed']) === 2,'Latest Incoming masters not restored');
    $after=incomingSnapshot(); unset($before['ms_costbook'],$after['ms_costbook']); incomingCheck($before === $after,'Latest Incoming repair changed operational history');
    $connection->begin_transaction(); $repair=aquamaticApply($store,$preview); $connection->commit(); incomingCheck($repair['changed'] === array(),'Latest Incoming repeat not idempotent');
    aquamaticSeed();
    $connection->query("INSERT INTO tr_incoming(id_data,id_incoming,tanggal,created_date,kurs,matauang) VALUES ('EARLIER-ID','LATEST-IN','2026-11-03','2026-11-03 12:00:00',2,'usd')");
    foreach (array('LVL41431','LVL41432') as $id) {
        $connection->query("INSERT INTO dt_trans_po(id_dt_po,no_po,idmaterial,qty,hargasatuan) VALUES ('$id-NEW-PO','PO2','$id',10,30)");
        $connection->query("INSERT INTO dt_incoming(id_data,id_incoming,id_dt_po,id_material,qty_recive,harga_satuan_usd,harga_total_idr,kurs) VALUES ('EARLIER-ID','LATEST-IN','$id-NEW-PO','$id',2,30,120,2),('EARLIER-ID','LATEST-IN','$id-NEW-PO','$id',1,30,60,2)");
    }
    $preview=aquamaticPreview($store,false,array(),'latest-incoming'); $preview['actor']='repair-test';
    incomingCheck($preview['items']['LVL41431']['proposed_costbook'] === 60.0 && $preview['items']['LVL41431']['source_incoming']['qty'] === 3,'Latest date/multiple lines/FX unit price incorrect');
    $tampered=$preview; $tampered['basis']='reconstructed'; aquamaticReject($tampered);
    $connection->query("UPDATE tr_incoming SET tanggal='2026-11-03',created_date='2026-11-03 12:00:00' WHERE id_data='AQUA'");
    incomingCheck(!aquamaticPreview($store,false,array(),'latest-incoming')['items']['LVL41431']['ready'],'Ambiguous latest Incoming accepted');
    echo "PASS: $checks Incoming/costbook checks on isolated localhost database\n";
} finally {
    foreach ($processes as $process) { if (is_resource($process[0])) { proc_terminate($process[0]); proc_close($process[0]); } }
    $connection->rollback();
    if ($created) { $connection->query('DROP DATABASE ' . $database); }
}
