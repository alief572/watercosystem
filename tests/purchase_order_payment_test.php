<?php
// POP_TEST_DB=1 php -d extension=mysqli tests/purchase_order_payment_test.php
if (PHP_SAPI !== 'cli' || getenv('POP_TEST_DB') !== '1') exit("Set POP_TEST_DB=1 for local temporary-table tests.\n");
error_reporting(E_ALL);
set_error_handler(function ($level, $message, $file, $line) {
    if (error_reporting() & $level) throw new ErrorException($message, 0, $level, $file, $line);
    return false;
});
define('BASEPATH', dirname(__DIR__) . '/system/');
define('APPPATH', dirname(__DIR__) . '/application/');
define('FCPATH', dirname(__DIR__) . '/');
define('ENVIRONMENT', 'development');
class Admin_Controller { public $db, $auth, $input, $output, $Pr_model, $template, $session, $uri, $load; }
class BF_Model { public $db; }
function log_message($level, $message) { $GLOBALS['pop_logs'][] = $message; }
function pop_check($ok, $message) {
    if (!$ok) throw new RuntimeException($message);
    echo "PASS: $message\n";
}
function has_permission($permission) { return $GLOBALS['pop_permissions'][$permission] ?? false; }
function base_url($path = '') { return '/app/' . ltrim($path, '/'); }
function html_escape($value) { return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8'); }
class Pop_http_error extends RuntimeException {}
function show_error($message, $status) { throw new Pop_http_error($message, $status); }
class Pop_input {
    public $values = array(), $verb = 'post';
    function post($key = null) { return $key === null ? $this->values : ($this->values[$key] ?? null); }
    function get($key) { return $this->values[$key] ?? null; }
    function method() { return $this->verb; }
}
class Pop_auth {
    public $allowed = true;
    function restrict($permission) { if (!$this->allowed) throw new DomainException('Denied'); }
}
class Pop_output { function set_content_type($type) { return $this; } }
require BASEPATH . 'core/Common.php';
require BASEPATH . 'database/DB.php';
$db = array(); require APPPATH . 'config/development/database.php';
$config = $db['default'];
if (!in_array($config['hostname'], array('localhost','127.0.0.1','db'), true)) throw new RuntimeException('Refuse non-local database');
$config['hostname'] = '127.0.0.1'; $config['db_debug'] = false;
$connection = DB($config, true);
if (!$connection->conn_id) throw new RuntimeException('Local database unavailable');
function pop_sql($sql, $binds = array()) {
    global $connection;
    $result = $connection->query($sql, $binds);
    if (!$result) throw new RuntimeException('Test SQL failed: ' . $connection->error()['message']);
    return $result;
}
foreach (array('tr_purchase_order','tr_incoming','tr_po_payment','master_supplier') as $table) {
    $definition = array_values(pop_sql('SHOW CREATE TABLE `' . $table . '`')->row_array())[1];
    pop_sql(preg_replace('/^CREATE TABLE /', 'CREATE TEMPORARY TABLE ', $definition));
}
// Writes resolve only to connection-local shadow tables, discarded on disconnect.
pop_sql("SET SESSION sql_mode='STRICT_ALL_TABLES,NO_ENGINE_SUBSTITUTION'");
require APPPATH . 'modules/purchase_order_payment/models/Pr_model.php';
require APPPATH . 'modules/purchase_order_payment/controllers/Purchase_order_payment.php';
$model = (new ReflectionClass('Pr_model'))->newInstanceWithoutConstructor(); $model->db = $connection;
pop_check($model->generate_nopn('2025-12-31') === 'PB-25L00001', 'Payment number uses payment year and month');
$connection->insert('tr_po_payment', array('kd_pembayaran'=>'PB-25L00008'));
pop_check($model->generate_nopn('2025-12-31') === 'PB-25L00009', 'Payment number follows maximum suffix, not row count');
pop_sql('DELETE FROM tr_po_payment');
$controller = (new ReflectionClass('Purchase_order_payment'))->newInstanceWithoutConstructor();
$controller->db = $connection; $controller->Pr_model = $model;
$controller->auth = new Pop_auth(); $controller->input = new Pop_input(); $controller->output = new Pop_output();
$controller->session = new class {
    public $user = array('id_user'=>9);
    function userdata($key) { return $this->user; }
};
function pop_call($method) {
    global $controller;
    ob_start();
    try { $controller->$method(); $body = ob_get_contents(); } finally { ob_end_clean(); }
    $result = json_decode($body, true);
    pop_check(is_array($result), $method . ' returns JSON without warnings');
    return $result;
}
function pop_seed($id, $currency = 'idr', $amount = 100.55) {
    global $connection;
    $connection->insert('tr_purchase_order', array('no_po'=>'PO'.$id,'no_surat'=>'SURAT'.$id,'status'=>'2',
        'id_suplier'=>'S1','matauang'=>strtoupper($currency),'tanggal'=>'2026-11-01','subtotal'=>$amount,
        'total_bayar'=>null,'total_bayar_idr'=>null));
    $connection->insert('tr_incoming', array('id_data'=>$id,'id_incoming'=>'INC'.$id,'no_po'=>'PO'.$id,
        'tanggal'=>'2026-11-01','matauang'=>$currency,'hutang_kurs'=>$currency==='idr'?0:$amount,'hutang_idr'=>$currency==='idr'?$amount:$amount*15000,
        'kurs'=>$currency==='idr'?1:15000,'status_bayar'=>'OPN','status_jurnal'=>'CLS',
        'bayar_kurs'=>null,'bayar_idr'=>null));
}
function pop_post($id, $amount = '100.55') {
    global $controller;
    $controller->input->values = array('no_po'=>'PO'.$id,'id_data'=>$id,'id_incoming'=>'INC'.$id,
        'id_suplier'=>'S1','matauang'=>'idr','tanggal_request'=>'2026-11-13','tanggal_bayar'=>'2026-11-14',
        'total_bayar'=>$amount,'nominal_kurs'=>'1','bank'=>'1102-01-01','ket_bayar'=>"Quote ' <tag>");
}
function pop_snapshot() {
    return array(pop_sql('SELECT * FROM tr_incoming ORDER BY id')->result_array(),
        pop_sql('SELECT * FROM tr_po_payment ORDER BY id')->result_array(),
        pop_sql('SELECT * FROM tr_purchase_order ORDER BY no_po')->result_array());
}
$connection->insert('master_supplier', array('id_suplier'=>'S1','name_suplier'=>"Supplier ' <tag>"));
pop_seed('I1'); pop_post('I1');
pop_check(pop_call('SaveRequest')['status'] === 1, 'Valid IDR request accepted');
pop_check(pop_call('SaveApproval')['status'] === 1, 'Pending request approved');
$controller->input->values['total_bayar'] = '999999';
pop_check(pop_call('SavePembayaran')['status'] === 1, 'Payment uses approved amount instead of forged form amount');
$payment = pop_sql("SELECT * FROM tr_po_payment WHERE id_data='I1'")->row_array();
$incoming = pop_sql("SELECT * FROM tr_incoming WHERE id_data='I1'")->row_array();
$po = pop_sql("SELECT * FROM tr_purchase_order WHERE no_po='POI1'")->row_array();
pop_check(abs($payment['jumlah_pembayaran'] - 100.55) < .001 && $payment['tgl_pembayaran'] === '2026-11-14', 'Payment preserves fractional amount and date');
pop_check($payment['kd_bank'] === '1102-01-01' && (float)$payment['kurs_bayar'] === 1.0, 'Bank code and IDR rate stored correctly');
pop_check($incoming['status_bayar'] === 'CLS' && abs($incoming['bayar_idr'] - 100.55) < .001, 'Incoming closes and NULL accumulator increments');
pop_check(abs($po['total_bayar'] - 100.55) < .001 && abs($po['total_bayar_idr'] - 100.55) < .001, 'Both PO payment totals updated');
$before = pop_snapshot();
pop_check(pop_call('SavePembayaran')['status'] === 2 && pop_snapshot() === $before, 'Repeated payment leaves database unchanged');
pop_check(pop_call('SaveReject')['status'] === 2 && pop_snapshot() === $before, 'Paid Incoming cannot be rejected');

pop_seed('USD', 'usd', 100.75); pop_post('USD', '80.25');
$controller->input->values['nominal_kurs'] = '15,250.50';
pop_check(pop_call('SaveRequest')['status'] === 1, 'USD request accepts formatted exchange rate');
pop_check(pop_call('SaveApproval')['status'] === 1, 'USD request approved');
$controller->input->values['nominal_kurs'] = '15,300.25';
$controller->input->values['bank'] = '1102-01-06';
pop_check(pop_call('SavePembayaran')['status'] === 1, 'USD payment accepts actual rate');
$payment = pop_sql("SELECT * FROM tr_po_payment WHERE id_data='USD'")->row_array();
$incoming = pop_sql("SELECT * FROM tr_incoming WHERE id_data='USD'")->row_array();
pop_check(abs($payment['jumlah_pembayaran_idr'] - round(80.25 * 15300.25, 2)) < .001
    && abs($payment['selisih'] - round(100.75 * 15000 - 80.25 * 15300.25, 2)) < .001, 'USD conversion and difference computed from database debt');
pop_check($incoming['status_bayar'] === 'CLS', 'One payment closes Incoming even when request is below debt');

pop_seed('R1'); pop_post('R1');
foreach (array(array('tanggal_request'=>'2026-02-30'), array('total_bayar'=>'100.56'), array('total_bayar'=>'0'),
    array('total_bayar'=>'-1'), array('total_bayar'=>'1,2'), array('total_bayar'=>'0.001'), array('total_bayar'=>array()),
    array('no_po'=>'POI1'), array('id_data'=>"missing' OR 1=1"), array('id_data'=>array())) as $bad) {
    pop_post('R1'); $controller->input->values = array_replace($controller->input->values, $bad); $before = pop_snapshot();
    pop_check(pop_call('SaveRequest')['status'] === 2 && pop_snapshot() === $before, 'Invalid request leaves database unchanged');
}
pop_post('R1');
pop_check(pop_call('SavePembayaran')['status'] === 2, 'Unapproved payment rejected');
pop_check(pop_call('SaveApproval')['status'] === 2, 'Approval without request rejected');
pop_check(pop_call('SaveRequest')['status'] === 1, 'Valid request can follow validation errors');
$before = pop_snapshot();
pop_check(pop_call('SaveRequest')['status'] === 2 && pop_snapshot() === $before, 'Repeated request rejected');
pop_check(pop_call('SaveReject')['status'] === 1, 'Pending request can be rejected');
$rejected = pop_sql("SELECT * FROM tr_incoming WHERE id_data='R1'")->row_array();
pop_check($rejected['request_bayar'] === '0' && $rejected['approve_bayar'] === '0' && (float)$rejected['rencana_bayar_idr'] === 0.0, 'Reject restores requestable state');
pop_check(pop_call('SaveRequest')['status'] === 1 && pop_call('SaveApproval')['status'] === 1, 'Rejected request can repeat original approval flow');
foreach (array(array('bank'=>'invalid'), array('bank'=>array()), array('tanggal_bayar'=>'2026-02-30')) as $bad) {
    pop_post('R1'); $controller->input->values = array_replace($controller->input->values, $bad); $before = pop_snapshot();
    pop_check(pop_call('SavePembayaran')['status'] === 2 && pop_snapshot() === $before, 'Invalid payment leaves database unchanged');
}
pop_post('R1'); $controller->input->verb = 'get'; $before = pop_snapshot();
pop_check(pop_call('SavePembayaran')['status'] === 2 && pop_snapshot() === $before, 'GET cannot mutate payment');
$controller->input->verb = 'post'; $controller->session->user = null;
pop_check(pop_call('SavePembayaran')['status'] === 2 && pop_snapshot() === $before, 'Missing session cannot mutate payment');
$controller->session->user = array('id_user'=>9);
foreach (array('SaveRequest','SaveApproval','SaveReject','SavePembayaran','data_index','data_approval','data_payment') as $method) {
    $controller->auth->allowed = false;
    try { pop_call($method); throw new LogicException('Authorization bypass'); }
    catch (DomainException $e) { pop_check($e->getMessage() === 'Denied', $method . ' enforces existing View permission'); }
}
$controller->auth->allowed = true;

class Pop_fault_db {
    public $db_debug = true, $connection, $fail;
    function __construct($connection, $fail) { $this->connection = $connection; $this->fail = $fail; }
    function __call($method, $args) {
        if ($method === 'insert' && $this->fail === 'insert') return false;
        if ($method === 'update' && $this->fail === 'incoming') { $this->connection->reset_query(); return false; }
        if ($method === 'trans_begin' && $this->fail === 'begin') return false;
        if ($method === 'trans_commit' && $this->fail === 'commit') return false;
        if ($method === 'trans_status' && $this->fail === 'status') return false;
        if ($method === 'query' && str_starts_with($args[0], 'UPDATE tr_purchase_order') && $this->fail === 'po') return false;
        if ($method === 'query' && str_starts_with($args[0], 'UPDATE tr_purchase_order') && $this->fail === 'sql') {
            return $this->connection->query('UPDATE tr_purchase_order SET missing_test_column = 1');
        }
        if ($method === 'insert' && $this->fail === 'throw') throw new RuntimeException('Injected error');
        $result = call_user_func_array(array($this->connection, $method), $args);
        return $result === $this->connection ? $this : $result;
    }
}
foreach (array('begin','insert','po','sql','incoming','status','commit','throw') as $failure) {
    pop_post('R1'); $before = pop_snapshot(); $controller->db = new Pop_fault_db($connection, $failure);
    pop_check(pop_call('SavePembayaran')['status'] === 2 && pop_snapshot() === $before, 'Payment rollback on ' . $failure . ' failure');
    pop_check($controller->db->db_debug === true, 'Database debug restored after failure');
    pop_check((int)pop_sql("SELECT IS_FREE_LOCK('pop-number-2026-11') AS free")->row()->free === 1, 'Number lock released after failure');
}
$controller->db = $connection;
pop_post('R1'); pop_check(pop_call('SavePembayaran')['status'] === 1, 'Payment succeeds after rollback');

pop_seed('Q1'); pop_seed('Q2'); pop_seed('Q3');
pop_sql("UPDATE tr_incoming SET request_bayar='1', rencana_bayar_idr=50 WHERE id_data='Q2'");
pop_sql("UPDATE tr_incoming SET request_bayar='1', approve_bayar='1', rencana_bayar_idr=50 WHERE id_data='Q3'");
pop_seed('EXCLUDED'); pop_sql("UPDATE tr_incoming SET status_jurnal='OPN' WHERE id_data='EXCLUDED'");
$GLOBALS['pop_permissions'] = array('Purchase_Order.View'=>true, 'Purchase_Order.Manage'=>true);
foreach (array('data_index'=>'INCQ1','data_approval'=>'INCQ2','data_payment'=>'INCQ3') as $route=>$expected) {
    $controller->input->values = array('draw'=>'3','start'=>'0','length'=>'10');
    $result = pop_call($route);
    pop_check($result['draw'] === 3 && $result['recordsTotal'] === 1 && count($result['data']) === 1
        && $result['data'][0]['id_incoming'] === $expected, $route . ' preserves stage filter and counts');
    pop_check(str_contains($result['data'][0]['supplier'], '&lt;tag&gt;') && !str_contains($result['data'][0]['supplier'], '<tag>'), 'Supplier escaped for table HTML');
}
$GLOBALS['pop_permissions']['Purchase_Order.Manage'] = false;
$controller->input->values = array();
pop_check(pop_call('data_index')['data'][0]['action'] === '', 'Request action follows Manage permission');
pop_check(str_contains(pop_call('data_approval')['data'][0]['action'], 'approval_bayar'), 'Approval preserves existing View access');
pop_check(!str_contains(pop_call('data_payment')['data'][0]['action'], '/edit/')
    && str_contains(pop_call('data_payment')['data'][0]['action'], 'request_print'), 'View-only payment list retains print action');
foreach (array("'", '<tag>', '100.55', '100.55', '01-Nov-2026', 'SURATQ1') as $term) {
    $controller->input->values = array('search'=>array('value'=>$term)); $result = pop_call('data_index');
    pop_check($result['recordsFiltered'] === 1, 'Search supports literal ' . $term);
}
foreach (array('%','_','!', "' OR 1=1 --") as $term) {
    $controller->input->values = array('search'=>array('value'=>$term)); $result = pop_call('data_index');
    pop_check($result['recordsTotal'] === 1 && $result['recordsFiltered'] === 0, 'Search escapes special characters ' . $term);
}
for ($i=0; $i<105; $i++) pop_seed('PAGE'.str_pad($i, 3, '0', STR_PAD_LEFT), 'idr', $i+1);
$controller->input->values = array('length'=>'-1'); $result = pop_call('data_index');
pop_check(count($result['data']) === 100 && $result['recordsTotal'] === 106, 'Page size capped at 100');
$controller->input->values = array('start'=>10,'length'=>10,'order'=>array(array('column'=>6,'dir'=>'asc')));
$result = pop_call('data_index');
pop_check(count($result['data']) === 10 && $result['data'][0]['number'] === 11 && $result['data'][0]['hutang_idr'] === '11.00', 'Pagination and numeric sorting use database values');
foreach (array(array('draw'=>array()), array('start'=>-1), array('length'=>0), array('search'=>array('value'=>array())),
    array('search'=>array('value'=>str_repeat('x',256))), array('order'=>array(array('column'=>1,'dir'=>'asc; DROP TABLE tr_incoming')))) as $bad) {
    $controller->input->values = $bad; $result = pop_call('data_index');
    pop_check(isset($result['error']) && $result['data'] === array(), 'Invalid table request returns safe JSON error');
}

function pop_render($view, $data = array()) {
    extract($data);
    ob_start();
    try { include APPPATH . 'modules/purchase_order_payment/views/' . $view . '.php'; return ob_get_contents(); }
    finally { ob_end_clean(); }
}
$controller->template = new class {
    public $data = array();
    function set($key, $value) { $this->data[$key] = $value; }
    function title($title) {}
    function page_icon($icon) {}
    function render($view) { echo pop_render($view, $this->data); }
};
$controller->load = new class { function view($view, $data) { echo pop_render($view, $data); } };
$controller->uri = new class {
    public $segments = array(3=>'POQ3', 4=>'Q3');
    function segment($n) { return $this->segments[$n] ?? null; }
};
foreach (array('edit','approval_bayar','request_bayar','request_print','index','index_approval','index_payment') as $method) {
    ob_start();
    try { $controller->$method(); $html = ob_get_contents(); } finally { ob_end_clean(); }
    pop_check(!str_contains($html, "Supplier ' <tag>") && str_contains($html, $method === 'request_print' ? 'PO REQUEST PAYMENT' : 'purchase_order_payment.js'), $method . ' renders without warnings or raw supplier HTML');
    if (in_array($method, array('edit','approval_bayar'), true)) pop_check(str_contains($html, 'value="50.00"'), 'Approved amount retains two decimals in form');
    if (str_starts_with($method, 'index')) pop_check(substr_count($html, '<th>') === 8 && !str_contains($html, 'id="example1"'), 'Table has eight consistent columns and unique ID');
}
$controller->uri->segments[3] = 'POQ1';
foreach (array('edit','approval_bayar','request_bayar','request_print') as $method) {
    $before = pop_snapshot();
    try { $controller->$method(); throw new LogicException('Mismatched Incoming accepted'); }
    catch (Pop_http_error $e) { pop_check($e->getCode() === 404 && pop_snapshot() === $before, $method . ' rejects mismatched PO and Incoming'); }
}

$second = DB($config, true);
pop_seed('LOCK'); pop_post('LOCK');
pop_check(pop_call('SaveRequest')['status'] === 1 && pop_call('SaveApproval')['status'] === 1, 'Lock test request approved');
class Pop_lock_db extends Pop_fault_db {
    public $second, $probed = false, $blocked = false;
    function __call($method, $args) {
        if ($method === 'insert' && $args[0] === 'tr_po_payment') {
            $this->probed = true;
            $result = $this->second->query("SELECT GET_LOCK('pop-number-2026-11',0) AS locked");
            $this->blocked = (int)$result->row()->locked === 0;
        }
        return parent::__call($method, $args);
    }
}
$probe = new Pop_lock_db($connection, ''); $probe->second = $second; $controller->db = $probe;
pop_check(pop_call('SavePembayaran')['status'] === 1 && $probe->probed && $probe->blocked, 'Payment holds number lock against another connection until commit');
pop_check((int)$second->query("SELECT GET_LOCK('pop-number-2026-11',0) AS locked")->row()->locked === 1, 'Number lock available after commit');
$controller->db = $connection; pop_seed('BUSY'); pop_post('BUSY');
pop_check(pop_call('SaveRequest')['status'] === 1 && pop_call('SaveApproval')['status'] === 1, 'Contention test request approved');
$before = pop_snapshot();
pop_check(pop_call('SavePembayaran')['status'] === 2 && pop_snapshot() === $before, 'Concurrent lock owner causes safe payment timeout');
$second->query("SELECT RELEASE_LOCK('pop-number-2026-11')"); $second->close();
pop_check(pop_call('SavePembayaran')['status'] === 1, 'Payment retries safely after lock contention');
pop_seed('ATOMIC'); pop_post('ATOMIC');
foreach (array('SaveRequest','SaveApproval','SaveReject') as $method) {
    foreach (array('incoming','status','commit') as $failure) {
        $before = pop_snapshot(); $controller->db = new Pop_fault_db($connection, $failure);
        pop_check(pop_call($method)['status'] === 2 && pop_snapshot() === $before, $method . ' rolls back on ' . $failure);
    }
    $controller->db = $connection;
    if ($method === 'SaveRequest') pop_check(pop_call($method)['status'] === 1, 'Atomic test request created');
    if ($method === 'SaveApproval') {
        pop_check(pop_call($method)['status'] === 1, 'Atomic test request approved');
        pop_seed('REJECT'); pop_post('REJECT');
        pop_check(pop_call('SaveRequest')['status'] === 1, 'Atomic reject test request created');
    }
}
pop_seed('AMBIGUOUS'); pop_post('AMBIGUOUS');
pop_sql("INSERT INTO tr_incoming (id_data,no_po,status_bayar) VALUES ('AMBIGUOUS','OTHER_PO','OPN')");
$before = pop_snapshot();
pop_check(pop_call('SaveRequest')['status'] === 2 && pop_snapshot() === $before, 'Ambiguous Incoming ID cannot mutate any matching row');
pop_seed('BAD_REQUEST'); pop_post('BAD_REQUEST');
pop_sql("UPDATE tr_incoming SET request_bayar='1', rencana_bayar_idr=0 WHERE id_data='BAD_REQUEST'");
pop_check(pop_call('SaveReject')['status'] === 1, 'Reject can clear a legacy request with invalid amount');
pop_seed('CHANGED_DEBT'); pop_post('CHANGED_DEBT');
pop_check(pop_call('SaveRequest')['status'] === 1 && pop_call('SaveApproval')['status'] === 1, 'Debt change test approved');
pop_sql("UPDATE tr_incoming SET hutang_idr=1 WHERE id_data='CHANGED_DEBT'");
$before = pop_snapshot();
pop_check(pop_call('SavePembayaran')['status'] === 2 && pop_snapshot() === $before, 'Changed debt cannot cause overpayment after approval');
$connection->insert('tr_po_payment', array('kd_pembayaran'=>'PB-25L99999'));
try { $model->generate_nopn('2025-12-31'); throw new LogicException('Counter overflow accepted'); }
catch (DomainException $e) { pop_check(true, 'Payment counter overflow rejected'); }
