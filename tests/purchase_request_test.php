<?php
// Run: php tests/purchase_request_test.php
error_reporting(E_ALL);
set_error_handler(function ($severity, $message, $file, $line) {
    if (error_reporting() & $severity) throw new ErrorException($message, 0, $severity, $file, $line);
    return false;
});
define('BASEPATH', dirname(__DIR__) . '/system/');
class Admin_Controller { public $auth, $input, $output, $db, $Pr_model, $session, $template; }
class BF_Model { public $db; }
function log_message($level, $message) {}
function pr_check($condition, $message) {
    if (!$condition) throw new RuntimeException($message);
    echo "PASS: $message\n";
}
class Pr_test_result {
    public $rows;
    function __construct($rows) { $this->rows = $rows; }
    function row() { return isset($this->rows[0]) ? (object)$this->rows[0] : null; }
    function row_array() { return $this->rows[0] ?? array(); }
    function result() { return array_map(function ($row) { return (object)$row; }, $this->rows); }
    function result_array() { return $this->rows; }
}
class Pr_test_db {
    public $db_debug = true, $headers = array(), $details = array(), $snapshot, $filters = array();
    public $lock = true, $locked = false, $fail = '', $queries = array(), $commits = 0;
    function query($sql, $binds = array()) {
        $this->queries[] = array($sql, $binds);
        if (strpos($sql, 'GET_LOCK') !== false) { $this->locked = $this->lock; $rows = array(array('acquired'=>(int)$this->lock)); }
        elseif (strpos($sql, 'RELEASE_LOCK') !== false) { $this->locked = false; $rows = array(array('released'=>1)); }
        elseif (strpos($sql, 'MAX(') !== false) {
            $values = array();
            foreach ($this->headers as $row) {
                if (strpos($sql, 'no_surat') !== false) {
                    if (isset($binds[0]) && substr($row['no_surat'], 0, strlen($binds[0])) !== $binds[0]) continue;
                    $values[] = (int)substr($row['no_surat'], 9);
                } else $values[] = (int)substr($row['no_pr'], 3);
            }
            $rows = array(array('max_id'=>$values ? max($values) : null));
        }
        elseif (strpos($sql, 'FROM tr_purchase_request') !== false) {
            $rows = array_values(array_filter($this->headers, function ($row) use ($binds) { return $row['no_pr'] === ($binds[0] ?? ''); }));
        }
        elseif (strpos($sql, 'FROM dt_trans_pr') !== false) {
            $rows = array_values(array_filter($this->details, function ($row) use ($binds) { return $row['no_pr'] === ($binds[0] ?? ''); }));
        }
        elseif (strpos($sql, 'FROM ms_inventory_category3') !== false) {
            $rows = ($binds[0] ?? '') === 'M1' ? array(array('id_category3'=>'M1','nama'=>'Material','kode_barang'=>'K1','id_bentuk'=>'B1')) : array();
        }
        elseif (strpos($sql, 'FROM master_supplier') !== false) $rows = ($binds[0] ?? '') === 'S1' ? array(array('id_suplier'=>'S1')) : array();
        else throw new RuntimeException('Unexpected query: ' . $sql);
        return new Pr_test_result($rows);
    }
    function trans_begin() { $this->snapshot = array($this->headers, $this->details); return true; }
    function trans_status() { return $this->fail !== 'status'; }
    function trans_commit() { if ($this->fail === 'commit') return false; $this->snapshot = null; ++$this->commits; return true; }
    function trans_rollback() { if ($this->snapshot !== null) list($this->headers, $this->details) = $this->snapshot; $this->snapshot = null; return true; }
    function where($field, $value) { $this->filters[$field] = $value; return $this; }
    function insert($table, $row) {
        if ($this->fail === $table) return false;
        if ($this->fail === 'throw' && $table === 'dt_trans_pr') throw new RuntimeException('SQL private data');
        if ($table === 'tr_purchase_request') $this->headers[] = $row;
        elseif ($table === 'dt_trans_pr') $this->details[] = $row;
        else throw new RuntimeException('Unexpected insert');
        return true;
    }
    function update($table, $values) {
        foreach ($this->headers as &$row) if ($row['no_pr'] === ($this->filters['no_pr'] ?? null)) $row = array_merge($row, $values);
        unset($row); $this->filters = array(); return $this->fail !== 'update';
    }
    function delete($table, $where) {
        $this->details = array_values(array_filter($this->details, function ($row) use ($where) { return $row['no_pr'] !== $where['no_pr']; }));
        return $this->fail !== 'delete';
    }
}
class Pr_test_auth {
    public $allowed = true, $permission;
    function restrict($permission) { $this->permission = $permission; if (!$this->allowed) throw new DomainException('Denied'); }
    function user_id() { return 9; }
}
class Pr_test_input {
    public $values;
    function post($key = null) { return $key === null ? $this->values : ($this->values[$key] ?? null); }
    function get($key) { return $this->values[$key] ?? null; }
}
class Pr_test_output {
    public $status = 200;
    function set_content_type($type) { return $this; }
    function set_status_header($status) { $this->status = $status; return $this; }
}
require dirname(__DIR__) . '/application/modules/purchase_request/models/Pr_model.php';
require dirname(__DIR__) . '/application/modules/purchase_request/controllers/Purchase_request.php';
$controller = (new ReflectionClass('Purchase_request'))->newInstanceWithoutConstructor();
$controller->auth = new Pr_test_auth(); $controller->input = new Pr_test_input(); $controller->output = new Pr_test_output();
$controller->Pr_model = (new ReflectionClass('Pr_model'))->newInstanceWithoutConstructor();
function pr_fixture() {
    global $controller;
    $controller->db = new Pr_test_db(); $controller->Pr_model->db = $controller->db;
    $controller->input->values = array('tanggal'=>'2026-11-12', 'requestor'=>'Requestor', 'dt'=>array(array('idmaterial'=>'M1','qty'=>'1,000.5','suplier'=>'S1','tanggal'=>'2026-11-13','keterangan'=>'Quote \' <tag>')));
    return $controller->db;
}
function pr_call($method) {
    global $controller;
    ob_start();
    try { $controller->$method(); $text = ob_get_contents(); } finally { ob_end_clean(); }
    $response = json_decode($text, true);
    pr_check(is_array($response), "$method returns JSON without warnings");
    return $response;
}
$db = pr_fixture(); $result = pr_call('SaveNew');
pr_check($result['status'] === 1 && count($db->headers) === 1 && count($db->details) === 1, 'Create saves header and detail');
pr_check($db->details[0]['qty'] == 1000.5 && $db->details[0]['kode_barang'] === 'K1', 'Numeric formatting and master product code handled');
pr_check(!$db->locked && $db->db_debug, 'Number lock released and database debug restored');
foreach (array('tr_purchase_request','dt_trans_pr','throw','commit','status') as $failure) {
    $db = pr_fixture(); $db->fail = $failure; $result = pr_call('SaveNew');
    pr_check($result['status'] === 0 && !$db->headers && !$db->details && !$db->locked && $db->db_debug, 'Create rollback: ' . $failure);
    pr_check(strpos($result['pesan'], 'SQL private data') === false, 'Internal database error stays private');
}
foreach (array(array('tanggal'=>'2026-02-30'), array('requestor'=>array()), array('dt'=>array()), array('dt'=>'bad'), array('dt'=>array(array('idmaterial'=>'missing'))), array('dt'=>array(array('idmaterial'=>'M1','qty'=>'1,2'))), array('dt'=>array(array('idmaterial'=>'M1','qty'=>'-1'))), array('dt'=>array(array('idmaterial'=>'M1','suplier'=>'missing')))) as $bad) {
    $db = pr_fixture();
    if (isset($bad['dt'][0]) && is_array($bad['dt'][0])) $bad['dt'][0] = array_replace($controller->input->values['dt'][0], $bad['dt'][0]);
    $controller->input->values = array_replace($controller->input->values, $bad); $result = pr_call('SaveNew');
    pr_check($result['status'] === 0 && !$db->headers && !$db->details, 'Invalid payload leaves no data');
}
$db = pr_fixture(); $db->lock = false; $result = pr_call('SaveNew');
pr_check($result['status'] === 0 && !$db->headers, 'Number lock timeout does not save');
$db = pr_fixture(); $controller->input->values['dt'][0]['qty'] = ''; unset($controller->input->values['dt'][0]['suplier']);
$result = pr_call('SaveNew');
pr_check($result['status'] === 1 && $db->details[0]['qty'] == 0, 'Planning fields may stay optional');
$original = array('no_pr'=>'P2600001','no_surat'=>'PR202611-0001','tanggal'=>'2026-11-12','requestor'=>'Old','status'=>'1','created_on'=>'2020-01-01 00:00:00','created_by'=>3);
foreach (array('1','2','other','missing') as $status) {
    $db = pr_fixture(); if ($status !== 'missing') $db->headers[] = array_replace($original, array('status'=>$status));
    $controller->input->values['no_pr'] = 'P2600001'; $controller->input->values['no_surat'] = 'tampered';
    $before = $db->headers; $result = pr_call('SaveEdit');
    if ($status === '1') {
        pr_check($result['status'] === 1 && $db->headers[0]['requestor'] === 'Requestor', 'Waiting PR stays editable');
        foreach (array('no_pr','no_surat','created_on','created_by','status') as $field) pr_check($db->headers[0][$field] === $original[$field], 'Edit preserves ' . $field);
    } else pr_check($result['status'] === 0 && $db->headers === $before && !$db->details, 'Edit rejects non-Waiting/missing PR');
}
foreach (array('delete','dt_trans_pr','throw','commit') as $failure) {
    $db = pr_fixture(); $db->headers[] = $original; $db->details[] = array('no_pr'=>'P2600001','id_dt_pr'=>'P2600001-7','qty'=>4);
    $before = array($db->headers, $db->details); $db->fail = $failure; $controller->input->values['no_pr'] = 'P2600001'; $result = pr_call('SaveEdit');
    pr_check($result['status'] === 0 && array($db->headers,$db->details) === $before, 'Edit restores original header/details: ' . $failure);
}
foreach (array('missing','1','2','other') as $status) {
    $db = pr_fixture(); if ($status !== 'missing') $db->headers[] = array_replace($original,array('status'=>$status));
    $controller->input->values = array('id'=>'P2600001'); $result = pr_call('Approved');
    pr_check($result['status'] === (int)in_array($status,array('1','2'),true), 'Approval checks stored status: ' . $status);
    if ($status === '1' || $status === '2') pr_check($db->headers[0]['status'] === '2', 'Approval transitions once');
    pr_check($controller->auth->permission === 'Purchase_Request.Delete', 'Approval permission unchanged');
}
$db = pr_fixture(); $db->headers[] = array('no_pr'=>'P2599990','no_surat'=>'PR202501-0001'); $db->headers[] = array('no_pr'=>'P2600001','no_surat'=>'PR202611-0001');
pr_check($controller->Pr_model->generate_code('2025-01-01') === 'P2599991', 'Global numeric counter survives backdating/year changes');
$db->headers[] = array('no_pr'=>'P2599999','no_surat'=>'PR202611-9999');
foreach (array('generate_code','BuatNomor') as $method) {
    try { $controller->Pr_model->$method('2026-11-12'); throw new LogicException('Overflow accepted'); }
    catch (DomainException $expected) { pr_check(true, 'Counter capacity checked: ' . $method); }
}
foreach (array('update','commit','status') as $failure) {
    $db = pr_fixture(); $db->headers[] = $original; $db->fail = $failure;
    $controller->input->values = array('id'=>$original['no_pr']); $before = $db->headers; $result = pr_call('Approved');
    pr_check($result['status'] === 0 && $db->headers === $before && $db->db_debug, 'Approval rollback: ' . $failure);
}
foreach (array('SaveNew'=>'Purchase_Request.Add','SaveEdit'=>'Purchase_Request.Add','Approved'=>'Purchase_Request.Delete') as $method=>$permission) {
    $db = pr_fixture(); $controller->auth->allowed = false;
    try { pr_call($method); throw new LogicException('Unauthorized request accepted'); }
    catch (DomainException $expected) { pr_check(!$db->queries && $controller->auth->permission === $permission, $method . ' keeps old permission and denies before queries'); }
    finally { $controller->auth->allowed = true; }
}
echo "Purchase request regression checks passed.\n";
