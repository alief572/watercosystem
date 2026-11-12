<?php
// PR_TEST_DB=1 php -d extension=mysqli tests/purchase_request_integration_test.php
if (PHP_SAPI !== 'cli' || getenv('PR_TEST_DB') !== '1') exit("Set PR_TEST_DB=1 to run local temporary-table tests.\n");
ob_start(); require __DIR__ . '/purchase_request_test.php'; ob_end_clean();
define('APPPATH', dirname(__DIR__) . '/application/');
define('ENVIRONMENT', 'development');
require BASEPATH . 'core/Common.php';
require BASEPATH . 'database/DB.php';
$db = array();
require APPPATH . 'config/development/database.php';
$config = $db['default'];
if (!in_array($config['hostname'], array('localhost','127.0.0.1','db'), true)) throw new RuntimeException('Refuse non-local database');
$config['hostname'] = '127.0.0.1'; $config['db_debug'] = false;
$connection = DB($config, true);
if (!$connection->conn_id) throw new RuntimeException('Local database unavailable');
function pr_sql($sql, $binds = array()) {
    global $connection;
    $result = $connection->query($sql, $binds);
    if (!$result) throw new RuntimeException('Test query failed: ' . $connection->error()['message']);
    return $result;
}
$tables = array('tr_purchase_request','dt_trans_pr','ms_inventory_category3','master_supplier');
foreach ($tables as $table) {
    $definition = array_values(pr_sql('SHOW CREATE TABLE `' . $table . '`')->row_array())[1];
    pr_sql(preg_replace('/^CREATE TABLE /', 'CREATE TEMPORARY TABLE ', $definition));
}
// All application writes below resolve to connection-local shadow tables.
pr_sql("SET SESSION sql_mode='STRICT_ALL_TABLES,NO_ENGINE_SUBSTITUTION'");
pr_check($connection->insert('ms_inventory_category3', array('id_category3'=>'M1','nama'=>'Material','kode_barang'=>'K1','id_bentuk'=>'B1')), 'Seed isolated material');
pr_check($connection->insert('master_supplier', array('id_suplier'=>'S1','name_suplier'=>'Supplier')), 'Seed isolated supplier');
$controller->db = $connection; $controller->Pr_model->db = $connection;
function pr_real_post($date = '2026-11-12') {
    global $controller;
    $controller->input->values = array('tanggal'=>$date, 'requestor'=>'PR integration', 'dt'=>array(array('idmaterial'=>'M1','qty'=>'2','suplier'=>'S1','tanggal'=>'2026-12-01','keterangan'=>"Quote ' & <tag>")));
}
function pr_snapshot() {
    return array(pr_sql('SELECT * FROM tr_purchase_request ORDER BY no_pr')->result_array(), pr_sql('SELECT * FROM dt_trans_pr ORDER BY id_dt_pr')->result_array());
}
pr_real_post(); $created = pr_call('SaveNew');
pr_check($created['status'] === 1 && $created['code'] === 'P2600001', 'Actual CI/MySQL creates initial PR');
$first = $created['code'];
pr_check(pr_sql('SELECT no_surat FROM tr_purchase_request WHERE no_pr = ?', array($first))->row()->no_surat === 'PR202611-0001', 'Initial letter has existing format');
foreach (array('2025-01-01'=>'P2500002', '2025-01-02'=>'P2500003', '2027-01-01'=>'P2700004') as $date=>$expected) {
    pr_real_post($date); $created = pr_call('SaveNew');
    pr_check($created['status'] === 1 && $created['code'] === $expected, 'Backdated/year-change numbering: ' . $date);
}
pr_check(pr_sql('SELECT no_surat FROM tr_purchase_request WHERE no_pr = ?', array('P2500003'))->row()->no_surat === 'PR202501-0002', 'Monthly letter counter follows PR date');
$before = pr_snapshot();
pr_real_post(); $controller->input->values['dt'][] = array_replace($controller->input->values['dt'][0], array('keterangan'=>str_repeat('x',256)));
$result = pr_call('SaveNew');
pr_check($result['status'] === 0 && pr_snapshot() === $before, 'Real detail SQL failure rolls back header and earlier detail');
pr_real_post(); $controller->input->values['no_pr'] = $first;
$controller->input->values['dt'][0]['id_dt_pr'] = $first . '-1';
$controller->input->values['dt'][0]['idameter'] = '400';
$controller->input->values['dt'][] = array_replace($controller->input->values['dt'][0], array('id_dt_pr'=>'','qty'=>'3'));
$old = pr_sql('SELECT * FROM tr_purchase_request WHERE no_pr = ?', array($first))->row_array();
$result = pr_call('SaveEdit');
pr_check($result['status'] === 1, 'Real Waiting edit succeeds');
$current = pr_sql('SELECT * FROM tr_purchase_request WHERE no_pr = ?', array($first))->row_array();
foreach (array('no_pr','no_surat','created_on','created_by','status') as $field) pr_check($current[$field] === $old[$field], 'Stored identity preserved: ' . $field);
$ids = array_column(pr_sql('SELECT * FROM dt_trans_pr WHERE no_pr = ? ORDER BY id_dt_pr', array($first))->result_array(), 'id_dt_pr');
pr_check($ids === array($first.'-1',$first.'-2'), 'Existing detail ID preserved; new detail gets next ID');
$before = pr_snapshot(); $controller->input->values['requestor'] = 'Must rollback'; $controller->input->values['dt'][0]['keterangan'] = str_repeat('x',256);
$result = pr_call('SaveEdit');
pr_check($result['status'] === 0 && pr_snapshot() === $before, 'Real edit SQL failure restores original header/details');
$controller->input->values = array('id'=>$first); $result = pr_call('Approved');
pr_check($result['status'] === 1, 'Real approval succeeds');
$before = pr_snapshot(); $result = pr_call('Approved');
pr_check($result['status'] === 1 && pr_snapshot() === $before, 'Repeated approval leaves data unchanged');
pr_real_post(); $controller->input->values['no_pr'] = $first; $result = pr_call('SaveEdit');
pr_check($result['status'] === 0 && pr_snapshot() === $before, 'Approved PR cannot be reopened by direct edit');
$other = DB($config, true);
try {
    pr_check((int)$other->query("SELECT GET_LOCK('purchase_request_numbering', 0) AS acquired")->row()->acquired === 1, 'Second connection holds number lock');
    pr_real_post(); $result = pr_call('SaveNew');
    pr_check($result['status'] === 0 && pr_snapshot() === $before, 'Concurrent writer times out safely without partial data');
} finally {
    $other->query("SELECT RELEASE_LOCK('purchase_request_numbering')"); $other->close();
}
pr_real_post(); $result = pr_call('SaveNew');
pr_check($result['status'] === 1, 'Number lock reusable after timeout and rollback');
pr_check($connection->query("SELECT IS_FREE_LOCK('purchase_request_numbering') AS free")->row()->free == 1, 'Successful save releases number lock');
class Pr_read_fixture {
    public $results;
    function userdata($key) { return array(); }
    function page_icon($icon) {}
    function title($title) {}
    function set($key, $value) { $this->results = $value; }
    function render($view) {}
}
$reader = new Pr_read_fixture(); $controller->session = $reader; $controller->template = $reader;
pr_sql("DELETE FROM ms_inventory_category3 WHERE id_category3 = 'M1'");
pr_sql("DELETE FROM master_supplier WHERE id_suplier = 'S1'");
$controller->View($first);
pr_check(count($reader->results['detail']) === 2, 'Detail query retains rows after master material/supplier removal');
pr_check($reader->results['detail'][0]->nama === 'Material' && $reader->results['detail'][0]->name_suplier === 'S1', 'Detail query falls back to stored material and supplier ID');
$connection->close();
echo "Purchase request local integration checks passed; temporary tables discarded.\n";
