<?php
// Run: php tests/purchase_order_datatable_test.php
require __DIR__ . '/purchase_order_test.php';
function html_escape($value) { return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8'); }
function base_url($path = '') { return '/' . ltrim($path, '/'); }
function has_permission($permission) { return $GLOBALS['po_permissions'][$permission] ?? false; }
class Po_table_result extends Po_result {
    function result() { return array_map(function($row) { return (object)$row; }, $this->rows); }
}
class Po_table_db {
    public $queries = array(), $db_debug = true, $fail = false, $status = '1';
    function query($sql, $binds = array()) {
        $this->queries[] = array($sql,$binds);
        if ($this->fail) return false;
        if (strpos($sql,'COUNT(*)') !== false) return new Po_table_result(array(array('total'=>strpos($sql,'WHERE') !== false ? 1 : 3)));
        return new Po_table_result(array(array('no_po'=>"P26'<>1",'no_surat'=>"PO-' <script>",'tanggal'=>'2026-11-13','namesup'=>"Supplier <tag>",'status'=>$this->status)));
    }
}
$database = new Po_table_db(); $model->db = $database;
$data = $model->getIndexData(array());
po_check($data['total'] === 3 && $data['filtered'] === 3 && count($data['rows']) === 1, 'Unfiltered counts and page returned');
po_check(count($database->queries) === 2 && strpos($database->queries[1][0],'LIMIT 10 OFFSET 0') !== false, 'Default request fetches one bounded page');
$database->queries = array();
$data = $model->getIndexData(array('draw'=>'2','start'=>'10','length'=>'25','search'=>array('value'=>"50%_'"),'order'=>array(array('column'=>'3','dir'=>'asc'))));
$query = $database->queries[2];
po_check($data['draw'] === 2 && $data['start'] === 10 && $data['filtered'] === 1, 'DataTables draw, offset and filtered count preserved');
po_check(strpos($query[0],'ORDER BY COALESCE(b.name_suplier,a.id_suplier) ASC, a.no_po DESC LIMIT 25 OFFSET 10') !== false, 'Sorting uses whitelist and stable tie-breaker');
po_check(strpos($query[0],"50%_'") === false && $query[1][0] === "%50!%!_'%", 'Search is bound and LIKE wildcards stay literal');
foreach (array(-1,10000) as $length) {
    $database->queries = array(); $model->getIndexData(array('length'=>$length));
    po_check(strpos($database->queries[1][0],'LIMIT 100 OFFSET 0') !== false, 'Unbounded requests capped at 100 rows');
}
foreach (array(array('start'=>-1),array('start'=>array()),array('length'=>0),array('draw'=>'bad'),array('search'=>'bad'),array('search'=>array('value'=>array())),array('order'=>array(array('column'=>'3','dir'=>'desc; DROP TABLE x')))) as $bad) {
    $database->queries = array();
    try { $model->getIndexData($bad); throw new LogicException('Invalid request accepted'); }
    catch (DomainException $e) { po_check(!$database->queries,'Malformed DataTables request rejected before SQL'); }
}
$database->queries = array(); $model->getIndexData(array('order'=>array(array('column'=>'99','dir'=>'asc'))));
po_check(strpos($database->queries[1][0],'ORDER BY a.no_po DESC') !== false,'Unknown sort column uses default order');
$controller->db = $database; $controller->Pr_model = $model;
$controller->session = new class { function userdata($key) { return array(); } };
$controller->template = new class {
    public $view;
    function page_icon($value) {}
    function title($value) {}
    function render($view) { $this->view=$view; }
};
$database->queries = array(); $controller->index();
po_check(!$database->queries && $controller->template->view === 'index','Initial index renders shell without loading PO rows');
$controller->output = new class extends Po_output {
    public $status = 200;
    function set_status_header($status) { $this->status=$status; return $this; }
};
$controller->input->values = array('draw'=>'5','start'=>'10');
$GLOBALS['po_permissions'] = array('Purchase_Order.View'=>true,'Purchase_Order.Manage'=>true);
$result = po_call('data_index');
po_check($controller->auth->permission === 'Purchase_Order.View' && $result['draw'] === 5 && $result['data'][0]['number'] === 11,'Endpoint restricts View and numbers rows across pages');
$row = $result['data'][0];
po_check(strpos($row['supplier'],'<tag>') === false && strpos($row['no_surat'],'<script>') === false,'JSON display fields escape stored HTML');
po_check(strpos($row['action'],'PrintH2/P26%27%3C%3E1') !== false && strpos($row['action'],'Approve') !== false,'Print URL encoded and Waiting approval preserved');
foreach (array('2'=>'Approved','3'=>'Closed') as $status=>$label) {
    $database->status=(string)$status; $result=po_call('data_index');
    po_check(strpos($result['data'][0]['progress'],$label)!==false && strpos($result['data'][0]['action'],'Approve')===false,'Stored '.$label.' PO keeps Print without approval');
}
$database->status='1';
$GLOBALS['po_permissions']['Purchase_Order.Manage'] = false;
$result = po_call('data_index');
po_check(strpos($result['data'][0]['action'],'Approve') === false && strpos($result['data'][0]['action'],'PrintH2') !== false,'View-only user receives Print without approval');
$database->fail = true; $result = po_call('data_index');
po_check($controller->output->status === 500 && $result['data'] === array() && $database->db_debug,'Database failure returns safe JSON and restores debug setting');
$database->fail = false; $controller->auth->allowed = false; $database->queries = array();
try { po_call('data_index'); throw new LogicException('Endpoint authorization bypass'); }
catch (DomainException $e) { po_check(!$database->queries,'Unauthorized endpoint denied before database access'); }
$controller->auth->allowed=true; $controller->input->values=array('draw'=>'12','start'=>array());
$result=po_call('data_index');
po_check($controller->output->status===422 && $result['draw']===12 && $result['data']===array() && !$database->queries,'Invalid endpoint parameters return structured error without SQL');
echo "Purchase order server-side table checks passed.\n";
