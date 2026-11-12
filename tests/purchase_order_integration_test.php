<?php
// PO_TEST_DB=1 php -d extension=mysqli tests/purchase_order_integration_test.php
// Add PO_TEST_PDF=1 and extensions gd, mbstring, curl to exercise the PDF engine.
if (PHP_SAPI !== 'cli' || getenv('PO_TEST_DB') !== '1') exit("Set PO_TEST_DB=1 for local temporary-table tests.\n");
require __DIR__ . '/purchase_order_test.php';
define('APPPATH', dirname(__DIR__) . '/application/');
define('FCPATH', dirname(__DIR__) . '/');
define('ENVIRONMENT', 'development');
require BASEPATH . 'core/Common.php';
require BASEPATH . 'database/DB.php';
$db = array(); require APPPATH . 'config/development/database.php';
$config = $db['default'];
if (!in_array($config['hostname'], array('localhost','127.0.0.1','db'),true)) throw new RuntimeException('Refuse non-local database');
$config['hostname'] = '127.0.0.1'; $config['db_debug'] = false;
$connection = DB($config,true);
if (!$connection->conn_id) throw new RuntimeException('Local database unavailable');
function po_sql($sql, $binds = array()) {
    global $connection;
    $result = $connection->query($sql,$binds);
    if (!$result) throw new RuntimeException('Test SQL failed: ' . $connection->error()['message']);
    return $result;
}
$tables = array('tr_purchase_order','dt_trans_po','tr_purchase_request','dt_trans_pr','master_supplier',
    'ms_inventory_category3','matauang','ppn','tr_incoming','tr_po_payment','ms_product_pricelist','stock_material','negara','child_supplier_pic');
foreach ($tables as $table) {
    $definition = array_values(po_sql('SHOW CREATE TABLE `' . $table . '`')->row_array())[1];
    po_sql(preg_replace('/^CREATE TABLE /','CREATE TEMPORARY TABLE ',$definition));
}
// All writes resolve to connection-local shadow tables, discarded on disconnect.
po_sql("SET SESSION sql_mode='STRICT_ALL_TABLES,NO_ENGINE_SUBSTITUTION'");
foreach (array('S1','S2') as $id) $connection->insert('master_supplier',array('id_suplier'=>$id,'name_suplier'=>"Supplier ' <tag>"));
$connection->insert('matauang',array('kode'=>'IDR'));
$connection->insert('ppn',array('persen'=>11));
function po_seed($pr, $supplier = 'S1', $status = '2', $state = 'OPN') {
    global $connection;
    po_check($connection->insert('tr_purchase_request',array('no_pr'=>$pr,'no_surat'=>'PR-'.$pr,'status'=>$status,'status_po'=>$state,'tanggal'=>'2026-11-13')), 'Seed PR ' . $pr);
    po_check($connection->insert('dt_trans_pr',array('no_pr'=>$pr,'id_dt_pr'=>$pr.'-1','idmaterial'=>'M1',
        'nama_material'=>"Material ' <tag>",'kode_barang'=>'K1','suplier'=>$supplier,'tanggal'=>'2026-12-01','qty'=>10)), 'Seed detail ' . $pr);
}
function po_post($prs = array('PR1')) {
    global $controller;
    $details = array();
    foreach ($prs as $pr) $details[] = array('idpr'=>$pr.'-1','no_pr'=>$pr,'idmaterial'=>'M1','qty'=>'2','hargasatuan'=>'100',
        'ppn'=>'Y','nilai_ppn'=>'999999','jumlahharga'=>'999999','totalharga'=>'999999','description'=>"Quote ' & <tag>");
    $controller->input->values = array('tanggal'=>'2026-11-13','id_suplier'=>'S1','matauang'=>'IDR','loi'=>'Lokal',
        'nominal_kurs'=>'1','kirim'=>'25','term'=>'Cash','dt'=>$details,'subtotal'=>'999999','no_pr'=>'0');
}
function po_snapshot() {
    return array(po_sql('SELECT * FROM tr_purchase_order ORDER BY no_po')->result_array(),
        po_sql('SELECT * FROM dt_trans_po ORDER BY id_dt_po')->result_array(),
        po_sql('SELECT * FROM tr_purchase_request ORDER BY no_pr')->result_array());
}
class Po_fault_db {
    public $db_debug = false, $connection, $fail, $detailWrites = 0;
    function __construct($connection, $fail) { $this->connection=$connection; $this->fail=$fail; }
    function __call($method,$args) {
        if ($method === 'insert' && $args[0] === 'dt_trans_po' && $this->fail === 'detail_sql' && ++$this->detailWrites === 2) {
            return $this->connection->query('INSERT INTO dt_trans_po (missing_test_column) VALUES (1)');
        }
        if ($method === 'update' && $args[0] === 'dt_trans_po' && $this->fail === 'edit_sql') {
            $this->connection->reset_query();
            return $this->connection->query('UPDATE dt_trans_po SET missing_test_column=1');
        }
        if ($method === 'insert' && $this->fail === $args[0]) return false;
        if ($method === 'update' && $this->fail === $args[0]) { $this->connection->reset_query(); return false; }
        if ($method === 'trans_commit' && $this->fail === 'commit') return false;
        if ($method === 'trans_status' && $this->fail === 'status') return false;
        $result = call_user_func_array(array($this->connection,$method),$args);
        return $result === $this->connection ? $this : $result;
    }
}

$controller->db = $connection; $controller->Pr_model->db = $connection;
po_seed('PR1'); po_seed('PR2','S2'); po_post(array('PR1','PR2'));
$created = po_call('SaveNew');
po_check($created['status'] === 1, 'Create combines PRs with different reference suppliers');
$first = $created['code'];
$header = po_sql('SELECT * FROM tr_purchase_order WHERE no_po = ?',array($first))->row_array();
po_check($first === 'P2600001' && $header['no_surat'] === 'PO-001/MP/11/2026', 'Initial numbers keep format');
po_check($header['no_pr'] === 'PR1' && $header['id_suplier'] === 'S1', 'Scalar header PR and selected supplier preserved');
po_check((float)$header['total_barang'] === 400.0 && (float)$header['total_ppn'] === 44.0 && (float)$header['subtotal'] === 469.0, 'Server ignores forged totals and calculates tax plus shipping');
po_check($header['expect_tanggal'] === '2026-12-01', 'Expected date defaults from source PR');
po_check(count(po_sql("SELECT * FROM tr_purchase_request WHERE status_po='CLS'")->result()) === 2, 'Both source PRs close atomically');
$before = po_snapshot(); po_post(); $result = po_call('SaveNew');
po_check($result['status'] === 0 && po_snapshot() === $before, 'Stale second submission cannot reuse closed PR');
po_seed('PR3'); po_post(array('PR3'));
foreach (array(array('qty'=>'0'),array('qty'=>'-1'),array('qty'=>'1.5'),array('qty'=>'1,2'),array('idmaterial'=>'M2'),array('no_pr'=>'PR2'),array('ppn'=>'bad'),array('discount'=>'bad','diskon'=>'101')) as $bad) {
    $original = $controller->input->values;
    $controller->input->values['dt'][0] = array_replace($original['dt'][0],$bad); $before = po_snapshot();
    $result = po_call('SaveNew'); po_check($result['status'] === 0 && po_snapshot() === $before, 'Invalid detail leaves database unchanged');
    $controller->input->values = $original;
}
$controller->input->values['dt'][] = $controller->input->values['dt'][0]; $before = po_snapshot();
$result = po_call('SaveNew'); po_check($result['status'] === 0 && po_snapshot() === $before, 'Duplicate source detail rejected');
foreach (array(array('tanggal'=>'2026-02-30'),array('tanggal'=>array()),array('id_suplier'=>'missing'),array('matauang'=>'missing'),array('nominal_kurs'=>'0'),array('kirim'=>'-1'),array('dt'=>array())) as $bad) {
    po_post(array('PR3')); $controller->input->values=array_replace($controller->input->values,$bad); $before=po_snapshot();
    $result=po_call('SaveNew'); po_check($result['status']===0 && po_snapshot()===$before,'Invalid header leaves database unchanged');
}
po_seed('PR_BAD','S1','1'); po_post(array('PR_BAD')); $before=po_snapshot(); $result=po_call('SaveNew');
po_check($result['status']===0 && po_snapshot()===$before,'Unapproved PR rejected');
po_seed('PR4'); po_post(array('PR3','PR4'));
$controller->db = new Po_fault_db($connection,'detail_sql'); $before = po_snapshot();
$result = po_call('SaveNew'); po_check($result['status'] === 0 && po_snapshot() === $before, 'Real detail SQL error rolls back header and prior detail');
$controller->db=$connection;
po_post(array('PR3')); $controller->input->values['tanggal'] = '2025-01-01'; $result = po_call('SaveNew');
po_check($result['status'] === 1 && $result['code'] === 'P2500002', 'Backdated PO uses global numeric counter');
po_post(array('PR4')); $controller->input->values['tanggal'] = '2025-01-02'; $result = po_call('SaveNew');
po_check($result['status'] === 1 && $result['code'] === 'P2500003', 'Repeated backdating does not duplicate number');
po_check(po_sql('SELECT no_surat FROM tr_purchase_order WHERE no_po = ?',array($result['code']))->row()->no_surat === 'PO-002/MP/01/2025', 'Letter counter follows document month');
po_sql("UPDATE tr_purchase_order SET no_surat='PO-100/MP/11/2026' WHERE no_po=?",array($first));
po_seed('PR5'); po_post(array('PR5')); $result = po_call('SaveNew');
po_check($result['status'] === 1 && po_sql('SELECT no_surat FROM tr_purchase_order WHERE no_po = ?',array($result['code']))->row()->no_surat === 'PO-101/MP/11/2026', 'Actual SQL reads full three-digit letter counter');
// Update existing details in place; removal releases only PRs no longer used.
po_post(array('PR2')); $controller->input->values['no_po'] = $first; $controller->input->values['no_surat'] = 'tampered';
unset($controller->input->values['dt'][0]['ppn']);
$controller->input->values['dt'][0]['note'] = 'Changed';
po_sql('UPDATE ppn SET persen=12');
$result = po_call('SaveEdit'); po_check($result['status'] === 1, 'Legacy edit without detail ID or PPN choice works');
$stored = po_sql('SELECT * FROM dt_trans_po WHERE no_po = ?',array($first))->row_array();
po_check($stored['id_dt_po'] === $first.'-2' && (float)$stored['ppn'] === 22.0 && $stored['kode_barang'] === 'K1', 'Edit preserves detail identity, tax snapshot and product code');
$edited = po_sql('SELECT * FROM tr_purchase_order WHERE no_po = ?',array($first))->row_array();
foreach (array('created_on','created_by','status') as $field) po_check($edited[$field] === $header[$field], 'Edit preserves ' . $field);
po_check($edited['no_surat'] === 'PO-100/MP/11/2026', 'Edit ignores forged letter number');
po_check(po_sql("SELECT status_po FROM tr_purchase_request WHERE no_pr='PR1'")->row()->status_po === 'OPN', 'Removed PR reopens when no other PO refers to it');
$controller->input->values['dt'][0]['qty'] = 3; $result = po_call('SaveEdit');
po_check($result['status'] === 1 && (float)po_sql('SELECT total_ppn FROM tr_purchase_order WHERE no_po=?',array($first))->row()->total_ppn === 36.0, 'Changed quantity recalculates PPN with current master');
$controller->input->values['term']='Must rollback'; $controller->db=new Po_fault_db($connection,'edit_sql'); $before = po_snapshot();
$result = po_call('SaveEdit'); po_check($result['status'] === 0 && po_snapshot() === $before, 'Failed edit restores prior header, details and PR states');
$controller->db=$connection;
po_seed('PR6'); po_post(array('PR2','PR6')); $controller->input->values['no_po']=$first;
$result=po_call('SaveEdit');
$ids=array_column(po_sql('SELECT id_dt_po FROM dt_trans_po WHERE no_po=? ORDER BY id_dt_po',array($first))->result_array(),'id_dt_po');
po_check($result['status']===1 && $ids===array($first.'-2',$first.'-3'),'Edit preserves retained ID and allocates new ID beyond prior maximum');
po_post(array('PR2')); $controller->input->values['no_po'] = $first;
po_check($connection->insert('tr_po_payment',array('no_po'=>$first,'kd_pembayaran'=>'TEST1')), 'Seed payment reference'); $before = po_snapshot(); $result = po_call('SaveEdit');
po_check($result['status'] === 0 && po_snapshot() === $before, 'Payment reference blocks Waiting edit');
po_sql('DELETE FROM tr_po_payment WHERE no_po=?',array($first));
$connection->insert('tr_incoming',array('no_po'=>$first)); $before = po_snapshot(); $result = po_call('SaveEdit');
po_check($result['status'] === 0 && po_snapshot() === $before, 'Incoming reference blocks Waiting edit');
po_sql('DELETE FROM tr_incoming WHERE no_po=?',array($first));
foreach (array('tr_purchase_order','commit','status') as $fail) {
    $controller->input->values=array('id'=>$first); $before=po_snapshot(); $controller->db=new Po_fault_db($connection,$fail);
    $result=po_call('Approved'); po_check($result['status']===0 && po_snapshot()===$before,'Approval rollback: '.$fail);
}
$controller->db=$connection;
$controller->input->values = array('id'=>$first); $result = po_call('Approved');
po_check($result['status'] === 1, 'Waiting approval succeeds');
$before = po_snapshot(); $result = po_call('Approved');
po_check($result['status'] === 1 && po_snapshot() === $before, 'Repeated approval is idempotent');
po_post(array('PR2')); $controller->input->values['no_po'] = $first; $result = po_call('SaveEdit');
po_check($result['status'] === 0 && po_snapshot() === $before, 'Approval prevents stale edit from reopening PO');
foreach (array('missing','closed') as $state) {
    $controller->input->values = array('id'=>$state === 'missing' ? 'missing' : $first);
    if ($state === 'closed') po_sql("UPDATE tr_purchase_order SET status='3' WHERE no_po=?",array($first));
    $before = po_snapshot(); $result = po_call('Approved'); po_check($result['status'] === 0 && po_snapshot() === $before, 'Approval rejects ' . $state);
}
// Fault injection delegates every real write to the isolated connection.
foreach (array('tr_purchase_order','dt_trans_po','tr_purchase_request','commit','status') as $fail) {
    po_post(array('PR1')); $before = po_snapshot();
    $controller->db = new Po_fault_db($connection,$fail); $result = po_call('SaveNew');
    po_check($result['status'] === 0 && po_snapshot() === $before, 'Atomic rollback: ' . $fail);
    po_check(po_sql("SELECT IS_FREE_LOCK('purchase_order_numbering') AS free")->row()->free == 1, 'Number lock released after failure');
}
$controller->db = $connection;
$other = DB($config,true);
try {
    po_check($other->query("SELECT GET_LOCK('purchase_order_numbering',0) AS acquired")->row()->acquired == 1, 'Competing connection holds writer lock');
    po_post(array('PR1')); $before = po_snapshot(); $result = po_call('SaveNew');
    po_check($result['status'] === 0 && po_snapshot() === $before, 'Concurrent save times out without partial data');
} finally { $other->query("SELECT RELEASE_LOCK('purchase_order_numbering')"); $other->close(); }
po_post(array('PR1')); $result = po_call('SaveNew'); po_check($result['status'] === 1, 'Writer lock reusable after timeout');
po_seed('PR7'); po_post(array('PR7'));
$controller->input->values['kirim']='5';
$controller->input->values['dt'][0]=array_replace($controller->input->values['dt'][0],array('qty'=>'3','hargasatuan'=>'10.125','diskon'=>'10','pajak'=>'2'));
$result=po_call('SaveNew');
po_check($result['status']===1 && (float)po_sql('SELECT subtotal FROM tr_purchase_order WHERE no_po=?',array($result['code']))->row()->subtotal===38.0,'Server and JavaScript use same rounding, discount and item shipping formula');
foreach (array('poHeader','poDetails') as $method) {
    $reader = new ReflectionMethod('Purchase_order',$method);
    $rows = $reader->invoke($controller,$first);
    po_check(count($rows) === ($method === 'poHeader' ? 1 : 2), 'Read retains data without master material: ' . $method);
}
po_sql('DELETE FROM master_supplier');
$readHeader = (new ReflectionMethod('Purchase_order','poHeader'))->invoke($controller,$first);
po_check($readHeader[0]->name_suplier === 'S1', 'Missing supplier falls back to stored ID');
$controller->input->values = array('id_pr'=>array('PR2-1')); $response = po_call('getDateExp');
po_check($response['minimal'] === '2026-12-01', 'Expected date API returns earliest ISO date');
$controller->input->values = array('id_pr'=>array()); $response = po_call('getDateExp');
po_check($response['minimal'] === '', 'Empty date query avoids invalid date');
function html_escape($value) { return htmlspecialchars((string)$value,ENT_QUOTES,'UTF-8'); }
function base_url($path = '') { return '/' . ltrim($path,'/'); }
function has_permission($permission) { return strpos($permission,'.Manage') === false; }
class Po_view {
    public $db, $uri;
    function __construct($db) { $this->db=$db; $this->uri=new class { function segment($n) { return $n===1 ? 'purchase_order' : 'P2600001'; } }; }
    function render($file,$variables) {
        extract($variables); ob_start();
        try { include APPPATH . 'modules/purchase_order/views/' . $file; return ob_get_contents(); }
        finally { ob_end_clean(); }
    }
}
$view = new Po_view($connection);
$source = po_sql("SELECT * FROM dt_trans_pr WHERE no_pr='PR2'")->result();
$createHtml = $view->render('add_purchaseorder.php',array('results'=>array('supplier'=>array(),'matauang'=>array(),'getitemso'=>$source)));
po_check(strpos($createHtml,'&lt;tag&gt;') !== false && strpos($createHtml,'data-ppn-rate="12"') !== false, 'Create renders escaped missing-stock/missing-price rows without warnings');
$directHtml=$view->render('Add.php',array('results'=>array('supplier'=>array(),'matauang'=>array())));
po_check(strpos($directHtml,'data-po-direct="1"')!==false && strpos($directHtml,'name="kirim" value="0"')!==false,'Direct form keeps item shipping separate from header shipping');
$editHeader = (new ReflectionMethod('Purchase_order','poHeader'))->invoke($controller,$first);
$editRows = po_sql('SELECT * FROM dt_trans_po WHERE no_po=?',array($first))->result_array();
$editHtml = $view->render('Edit.php',array('results'=>array('head'=>$editHeader,'detail'=>$editRows,'supplier'=>array(),'matauang'=>array(),'comp'=>array())));
po_check(strpos($editHtml,'data-po-edit="1"') !== false && strpos($editHtml,'[id_dt_po]') !== false, 'Edit renders durable IDs and tax snapshot');
$readRows = (new ReflectionMethod('Purchase_order','poDetails'))->invoke($controller,$first);
$readHtml = $view->render('View.php',array('results'=>array('head'=>$editHeader,'detail'=>$readRows,'comp'=>array())));
po_check(strpos($readHtml,'&lt;tag&gt;') !== false, 'Detail escapes persisted special characters');
$editHeader[0]->matauang = 'EUR'; $editHeader[0]->negara = 'missing';
$printHtml = $view->render('print2.php',array('header'=>$editHeader,'detail'=>$readRows));
po_check(strpos($printHtml,'EUR') !== false && strpos($printHtml,'&lt;tag&gt;') !== false && strpos($printHtml,FCPATH.'assets/images/logo_waterco.png') !== false, 'Print tolerates missing master, PIC, country and third currency');
$emptyPrint = $view->render('print2.php',array('header'=>$editHeader,'detail'=>array()));
po_check(strpos($emptyPrint,'Grand Total') !== false, 'Empty-detail print avoids division by zero');
if (getenv('PO_TEST_PDF') === '1') {
    require FCPATH . 'assets/html2pdf/html2pdf/html2pdf.class.php';
    foreach (array($printHtml,$emptyPrint) as $html) {
        $pdf=new HTML2PDF('P','A4','en',true,'UTF-8',array(10,5,10,5));
        $pdf->WriteHTML($html);
        po_check(strncmp($pdf->Output('Purchase Order.pdf','S'),'%PDF-',5)===0,'Real PDF engine renders PO without browser');
    }
}

$listHtml = $view->render('index_pr.php',array('results'=>po_sql('SELECT * FROM tr_purchase_request')->result()));
po_check(strpos($listHtml,'Undefined') === false, 'Populated PR selection renders without undefined customer fields');
$indexRows = po_sql('SELECT *, id_suplier AS namesup FROM tr_purchase_order')->result();
$indexHtml = $view->render('index.php',array('results'=>$indexRows));
po_check(strpos($indexHtml,'<th>Action</th>') !== false, 'View-only list keeps Action header aligned');
po_sql('DELETE FROM ppn');
$controller->input->values=array('harga'=>'100');
try { (new ReflectionMethod('Purchase_order','poRate'))->invoke($controller); throw new LogicException('Missing tax master accepted'); }
catch (DomainException $expected) { po_check(true,'Missing PPN master fails explicitly'); }
po_check($connection->insert('master_supplier',array('id_suplier'=>'S1','name_suplier'=>'Supplier')),'Restore isolated supplier');
po_seed('PR8'); po_post(array('PR8')); $before=po_snapshot(); $result=po_call('SaveNew');
po_check($result['status']===0 && po_snapshot()===$before,'Taxable save rejects missing master without writes');
$controller->input->values['dt'][0]['ppn']='N'; $result=po_call('SaveNew');
po_check($result['status']===1,'Non-taxable save works without PPN master');
po_sql("UPDATE tr_purchase_request SET status_po='OPN' WHERE no_pr='PR8'");
$available=$controller->Pr_model->cariPurchaserequest();
po_check(!in_array('PR8',array_column($available,'no_pr'),true),'PR referenced by PO stays hidden even if legacy usage flag is wrong');
$controller->input->values=array(); $available=po_call('getPR');
po_check(strpos($available['option'],'PR8')===false,'PR API excludes used PR');
$controller->input->values=array('no_po'=>$first); $available=po_call('getPR');
po_check(strpos($available['option'],'PR2')!==false && strpos($available['option'],'PR6')!==false,'PR API includes all current PO associations for legacy edit');
// Server-side index checks run against the same isolated tables.
$beforeCount=(int)po_sql('SELECT COUNT(*) AS total FROM tr_purchase_order')->row()->total;
foreach (array('TABLE_A'=>'Alpha supplier','TABLE_Z'=>'Zeta supplier') as $id=>$name) po_check($connection->insert('master_supplier',array('id_suplier'=>$id,'name_suplier'=>$name)),'Seed table supplier');
foreach (array(
    array('P2600901','TABLE_ALPHA%_','2026-01-02','NO_MASTER_TABLE','1'),
    array('P2600902',"TABLE_BETA ' <tag>",'2026-02-01','TABLE_A','2'),
    array('P2600903','TABLE_GAMMA','2026-03-01','TABLE_Z','3'),
    array('P2600904','TABLE_DELTA','2026-04-01','TABLE_A','1')
) as $row) po_check($connection->insert('tr_purchase_order',array_combine(array('no_po','no_surat','tanggal','id_suplier','status'),$row)),'Seed index page row');
$page=$controller->Pr_model->getIndexData(array('length'=>'2'));
po_check($page['total']===$beforeCount+4 && $page['filtered']===$page['total'] && array_column($page['rows'],'no_po')===array('P2600904','P2600903'),'SQL default returns only first page in prior PO order');
$page=$controller->Pr_model->getIndexData(array('start'=>'2','length'=>'2'));
po_check(array_column($page['rows'],'no_po')===array('P2600902','P2600901'),'SQL offset returns second page');
foreach (array('%_'=>'P2600901',"' <tag>"=>'P2600902','02-Jan-2026'=>'P2600901','2026-01-02'=>'P2600901','NO_MASTER_TABLE'=>'P2600901') as $search=>$expected) {
    $page=$controller->Pr_model->getIndexData(array('search'=>array('value'=>$search)));
    po_check($page['filtered']===1 && $page['rows'][0]->no_po===$expected,'Literal server search: '.$search);
}
$page=$controller->Pr_model->getIndexData(array('search'=>array('value'=>"%' OR 1=1 --")));
po_check($page['filtered']===0 && !$page['rows'],'SQL-shaped search remains literal');
$sortCases=array(1=>array('P2600901','P2600902','P2600904','P2600903'),2=>array('P2600901','P2600902','P2600903','P2600904'),
    3=>array('P2600904','P2600902','P2600901','P2600903'),4=>array('P2600902','P2600903','P2600904','P2600901'));
foreach ($sortCases as $column=>$expected) {
    $page=$controller->Pr_model->getIndexData(array('search'=>array('value'=>'TABLE_'),'order'=>array(array('column'=>$column,'dir'=>'asc'))));
    po_check($page['filtered']===4 && array_column($page['rows'],'no_po')===$expected,'SQL sorts displayed column '.$column.' with stable tie-breaker');
}
$page=$controller->Pr_model->getIndexData(array('start'=>'9999','search'=>array('value'=>'TABLE_')));
po_check(!$page['rows'] && $page['filtered']===4,'Out-of-range page retains correct counts');
$waiting=(int)po_sql("SELECT COUNT(*) AS total FROM tr_purchase_order WHERE status='1'")->row()->total;
$page=$controller->Pr_model->getIndexData(array('search'=>array('value'=>'Waiting')));
po_check($page['filtered']===$waiting,'Status search uses displayed labels');
$controller->input->values=array('draw'=>'7','start'=>'1','length'=>'2','search'=>array('value'=>'TABLE_'));
$response=po_call('data_index');
po_check($response['draw']===7 && $response['recordsTotal']===$beforeCount+4 && $response['recordsFiltered']===4 && count($response['data'])===2 && $response['data'][0]['number']===2,'Real endpoint returns DataTables counts, draw and continuous row numbers');
$controller->input->values=array('search'=>array('value'=>"' <tag>")); $response=po_call('data_index');
po_check(strpos($response['data'][0]['no_surat'],'&lt;tag&gt;')!==false && strpos($response['data'][0]['action'],'Approve')===false,'Endpoint escapes legacy text and hides approval from View-only user');
$connection->close();
echo "Purchase order integration checks passed; temporary tables discarded.\n";
