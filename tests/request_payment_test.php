<?php
// PAYMENT_TEST_DB=1 php -d extension=mysqli tests/request_payment_test.php
if (PHP_SAPI !== 'cli' || getenv('PAYMENT_TEST_DB') !== '1') exit("Set PAYMENT_TEST_DB=1 for temporary-table tests.\n");
error_reporting(E_ALL);
set_error_handler(function ($level,$message,$file,$line) { if (error_reporting() & $level) throw new ErrorException($message,0,$level,$file,$line); return false; });
define('BASEPATH',dirname(__DIR__).'/system/'); define('APPPATH',dirname(__DIR__).'/application/'); define('FCPATH',dirname(__DIR__).'/'); define('ENVIRONMENT','development');
$_SERVER['HTTP_HOST']='localhost'; $_SERVER['SCRIPT_NAME']='/index.php';
class Admin_Controller { public $db,$auth,$input,$output,$Request_payment_model,$All_model,$template,$session,$uri,$load,$upload,$config; }
class BF_Model { public $db; }
function log_message($level,$message) { $GLOBALS['payment_logs'][]=$message; }
function simpan_aktifitas(...$args) { $GLOBALS['payment_audit'][]=$args; }
function html_escape($value) { return htmlspecialchars((string)$value,ENT_QUOTES,'UTF-8'); }
function base_url($path='') { return '/app/'.ltrim($path,'/'); }
function has_permission($permission) { return !in_array($permission,$GLOBALS['controller']->auth->denied,true); }
function check($ok,$message) { if (!$ok) throw new RuntimeException($message.'; '.end($GLOBALS['payment_logs'])); echo "PASS: $message\n"; }
class Payment_http_error extends RuntimeException {}
function show_error($message,$code=500) { throw new Payment_http_error($message,$code); }
require BASEPATH.'core/Common.php'; require BASEPATH.'database/DB.php';
$db=[]; require APPPATH.'config/development/database.php'; $config=$db['default'];
if (!in_array($config['hostname'],['localhost','127.0.0.1','db'],true)) throw new RuntimeException('Refuse remote database');
$config['hostname']='127.0.0.1'; $config['db_debug']=false; $connection=DB($config,true);
define('DBERP',$config['database']); define('DBACC','gl_waterco');
function sql($query,$binds=[]) { global $connection; $q=$connection->query($query,$binds); if (!$q) throw new RuntimeException($connection->error()['message']); return $q; }
function seed($table,$data) {
    global $connection;
    foreach (sql('SHOW COLUMNS FROM '.$table)->result_array() as $column) {
        if (!array_key_exists($column['Field'],$data) && $column['Null']==='NO' && $column['Default']===null && !str_contains($column['Extra'],'auto_increment')) {
            $data[$column['Field']]=preg_match('/int|double|decimal/',$column['Type']) ? 0 : (str_contains($column['Type'],'date') ? '2026-11-13' : '');
        }
    }
    if (!$connection->insert($table,$data)) throw new RuntimeException($connection->error()['message']);
}
foreach (['request_payment','payment_approve','payment_approve_details','jurnal','tr_expense','tr_expense_detail','tr_kasbon','tr_transport_req','tr_transport','tr_non_po_header','tr_non_po_detail','tr_pengajuan_rutin','tr_pengajuan_rutin_detail'] as $table) {
    $definition=array_values(sql('SHOW CREATE TABLE `'.$table.'`')->row_array())[1];
    sql(preg_replace('/^CREATE TABLE /','CREATE TEMPORARY TABLE ',$definition));
}
sql('CREATE TEMPORARY TABLE user_emp (id INT, username VARCHAR(100), nama_karyawan VARCHAR(150))');
foreach (['jurnal','japh','pastibisa_tb_cabang','master_oto_jurnal_detail'] as $table) {
    $definition=array_values(sql('SHOW CREATE TABLE '.DBACC.'.`'.$table.'`')->row_array())[1];
    sql(preg_replace('/^CREATE TABLE `[^`]+`/','CREATE TEMPORARY TABLE '.DBACC.'.`'.$table.'`',$definition));
}
sql("SET SESSION sql_mode='STRICT_ALL_TABLES,ONLY_FULL_GROUP_BY,NO_ENGINE_SUBSTITUTION'");
require APPPATH.'modules/request_payment/models/Request_payment_model.php'; require APPPATH.'modules/request_payment/controllers/Request_payment.php';
$controller=(new ReflectionClass('Request_payment'))->newInstanceWithoutConstructor();
$model=(new ReflectionClass('Request_payment_model'))->newInstanceWithoutConstructor(); $controller->db=$model->db=$connection; $controller->Request_payment_model=$model;
$controller->auth=new class { public $denied=[]; function restrict($permission) { if (in_array($permission,$this->denied,true)) throw new DomainException('Denied'); } function user_name() { return 'manager'; } };
$controller->input=new class { public $values=[],$verb='post'; function post($key=null) { return $key===null?$this->values:($this->values[$key]??null); } function get($key=null) { return $this->post($key); } function method() { return $this->verb; } };
$controller->output=new class { function set_content_type($type) { return $this; } function set_header($header) { return $this; } };
$controller->auth->denied=['Request_Payment.Manage'];
try { ob_start(); $controller->save_request(); ob_end_clean(); throw new LogicException('Request permission bypass'); }
catch (DomainException $e) { if (ob_get_level()) ob_end_clean(); check($e->getMessage()==='Denied','Request save requires Manage permission'); }
$controller->auth->denied=[];
$controller->session=new class { public $values=[]; function userdata($key) { return $this->values[$key]??null; } function set_userdata($key,$value) { $this->values[$key]=$value; } };
$controller->All_model=new class { function GetCoaCombo() { return ['0'=>'Select','C1'=>'Expense','C2'=>'Other','BANK'=>'Bank','TAX'=>'Tax','ADMIN'=>'Admin']; } };
function callPayment($method,...$args) {
    global $controller; ob_start();
    try { $controller->$method(...$args); $body=ob_get_contents(); } finally { ob_end_clean(); }
    $json=json_decode($body,true); check(is_array($json),$method.' returns JSON'); return $json;
}
function snapshotPayment() {
    $data=[]; foreach (['request_payment','payment_approve','payment_approve_details','tr_expense','tr_expense_detail','tr_kasbon','tr_transport_req','tr_transport','tr_non_po_header','tr_non_po_detail','tr_pengajuan_rutin_detail','jurnal'] as $t) $data[$t]=sql('SELECT * FROM '.$t.' ORDER BY id')->result_array(); return $data;
}
function requestPost($type,$id,$date='2026-11-13') {
    global $controller,$model;
    $row=$model->query('SELECT * FROM ('.$model->sourcesSql().') a WHERE a.tipe=? AND a.ids=?',[$type,$id])->row_array();
    $controller->input->values=['items'=>[['tipe'=>$type,'ids'=>(string)$id,'tanggal'=>$date,'version'=>$model->requestVersion($row)]]];
}
function approvalPost($type,$id,$details) {
    global $controller,$model;
    $controller->input->values=['tipe'=>$type,'id'=>(string)$id,'version'=>$model->source($type,(string)$id)['version'],'items'=>array_map(fn($id)=>['id'=>(string)$id],$details)];
}
sql("INSERT INTO tr_expense (id,no_doc,tgl_doc,nama,informasi,status,jumlah,add_ppn_nilai,add_pph_nilai) VALUES (1,'EXP1','2026-11-13','owner','Expense',1,300,0,0)");
foreach ([11=>100,12=>200] as $id=>$amount) sql("INSERT INTO tr_expense_detail (id,no_doc,tanggal,deskripsi,qty,harga,total_harga,expense,kasbon,coa,status) VALUES (?,'EXP1','2026-11-13','Item',1,?,?,?,0,'C1',0)",[$id,$amount,$amount,$amount]);
foreach (['get','post'] as $verb) {
    $controller->input->verb=$verb; $controller->input->values=[]; $before=snapshotPayment();
    check(callPayment('save_request')['save']===false && snapshotPayment()===$before,'Empty or GET request cannot change data');
}
requestPost('expense',1,'2026-02-31'); $before=snapshotPayment();
check(callPayment('save_request')['save']===false && snapshotPayment()===$before,'Invalid planned payment date rolls back');
requestPost('expense',1); $controller->input->values['items'][0]['jumlah']='999999';
check(callPayment('save_request')['save']===true,'Request accepts approved Expense');
$r=sql("SELECT * FROM request_payment WHERE tipe='expense'")->row_array();
check((float)$r['jumlah']===300.0 && (int)sql('SELECT status FROM tr_expense WHERE id=1')->row()->status===2,'Request uses source amount and updates source status');
$before=snapshotPayment(); check(callPayment('save_request')['save']===false && snapshotPayment()===$before,'Repeated request cannot duplicate data');
approvalPost('expense',1,[11,11]); $before=snapshotPayment();
check(callPayment('save_approval')['save']===false && snapshotPayment()===$before,'Duplicate approval details rejected');
approvalPost('expense',1,[999]); check(callPayment('save_approval')['save']===false && snapshotPayment()===$before,'Foreign detail rejected');
approvalPost('expense',1,[11]);
check(callPayment('save_approval')['save']===true,'First partial approval succeeds');
$p=sql('SELECT * FROM payment_approve')->row_array();
check($p['id']==='PAY202600001' && (float)$p['jumlah']===100.0 && (float)$p['nilai_request']===100.0,'Partial header holds only selected amount');
check((int)sql('SELECT status FROM request_payment WHERE id=?',[$r['id']])->row()->status===1,'Request stays partial while details remain');
approvalPost('expense',1,[12]); check(callPayment('save_approval')['save']===true,'Second partial approval creates another batch');
check(sql('SELECT COUNT(*) AS n FROM payment_approve')->row()->n==2 && sql('SELECT COUNT(*) AS n FROM payment_approve_details d LEFT JOIN payment_approve p ON p.id=d.payment_id WHERE p.id IS NULL')->row()->n==0,'Partial batches have distinct headers without orphan details');
check((int)sql('SELECT status FROM request_payment WHERE id=?',[$r['id']])->row()->status===2,'Final approval completes request');
approvalPost('expense',1,[12]); $before=snapshotPayment(); check(callPayment('save_approval')['save']===false && snapshotPayment()===$before,'Completed request rejects repeated approval');
function batchPayment($ids=null) {
    global $model,$controller;
    $ids=$ids ?? array_column(sql('SELECT id FROM payment_approve WHERE status=1 ORDER BY id')->result_array(),'id');
    $versions=[]; $sources=[]; $total=0;
    foreach ($ids as $id) { $p=$model->payment($id); $versions[$id]=$p['version']; $sources[$id]=$model->source($p['header']['tipe'],$p['header']['ids'])['version']; $total+=$model->money($p['header']['jumlah'],true); }
    $token=bin2hex(random_bytes(16)); $controller->session->values['payment_batches'][$token]=['owner'=>'manager','versions'=>$versions,'sources'=>$sources,'count'=>count($versions),'total'=>$model->amount($total),'admin'=>'0'];
    $controller->input->values=['batch_token'=>$token,'bank_coa'=>'BANK']; $_FILES=[]; return $token;
}
batchPayment(); $controller->input->values['edits']=['PAY202600001'=>['bank_admin'=>'bad']]; $before=snapshotPayment();
check(callPayment('save_payment')['save']===false && snapshotPayment()===$before,'Invalid admin cannot pay any batch row');
batchPayment();
check(callPayment('save_payment')['save']===true,'Payment processes both initial partial batches');
check(sql('SELECT COUNT(*) AS n FROM payment_approve WHERE status=2')->row()->n==2,'Payment marks only initial batches paid');
$totals=sql("SELECT nomor,SUM(debet) AS d,SUM(kredit) AS k FROM jurnal GROUP BY nomor ORDER BY nomor")->result_array();
check(count($totals)===2 && (float)$totals[0]['d']===100.0 && (float)$totals[1]['d']===200.0 && $totals[0]['d']===$totals[0]['k'],'Each partial journal contains only its own detail and balances');
$before=snapshotPayment(); check(callPayment('save_payment')['save']===false && snapshotPayment()===$before,'Successful batch token cannot be reused');
seed(DBACC.'.pastibisa_tb_cabang',['id'=>1,'nocab'=>'101','nobuk'=>0]);
function journalPost($number) {
    global $controller,$model;
    $j=$model->journal($number); $items=[];
    foreach ($model->journalGroups($j['rows']) as $g) $items[]=['id'=>$g['id'],'coa'=>$g['coa'],'keterangan'=>$g['keterangan'],'debet'=>$model->amount($g['debet']),'kredit'=>$model->amount($g['kredit'])];
    $controller->input->values=['nomor'=>$number,'version'=>$j['version'],'tanggal'=>'2026-11-13','items'=>$items];
}
journalPost($totals[0]['nomor']); $controller->input->values['items'][0]['debet']='1'; $before=snapshotPayment();
check(callPayment('jurnal_save')['save']===false && snapshotPayment()===$before,'Unbalanced accounting posting rejected');
journalPost($totals[0]['nomor']); check(callPayment('jurnal_save')['save']===true,'Balanced journal posts to accounting');
check(sql('SELECT COUNT(*) AS n FROM '.DBACC.'.japh')->row()->n==1 && sql('SELECT nobuk FROM '.DBACC.'.pastibisa_tb_cabang WHERE id=1')->row()->nobuk==1,'Posting creates one accounting header and increments counter once');
$before=snapshotPayment(); check(callPayment('jurnal_save')['save']===false && snapshotPayment()===$before,'Repeated posting cannot duplicate accounting');
foreach (['kasbon','nonpo','transportasi','admin'] as $menu) seed(DBACC.'.master_oto_jurnal_detail',['kode_master_jurnal'=>'BUK030','menu'=>$menu,'no_perkiraan'=>$menu==='admin'?'ADMIN':'C1']);
sql("INSERT INTO tr_kasbon (id,no_doc,tgl_doc,nama,keperluan,jumlah_kasbon,status,coa) VALUES (1,'KAS1','2026-11-13','owner','Kasbon',50,1,'C1')");
sql("INSERT INTO tr_transport_req (id,no_doc,tgl_doc,nama,jumlah_expense,status) VALUES (1,'TR1','2026-11-13','owner',60,1)");
sql("INSERT INTO tr_transport (id,no_doc,no_req,tgl_doc,nama,keperluan,jumlah_kasbon,status) VALUES (21,'DETAIL-TR','TR1','2026-11-13','owner','Trip',60,1)");
sql("INSERT INTO tr_non_po_header (id,no_doc,pic,tanggal_doc,nilai_request,info,status) VALUES (1,'NP1','owner','2026-11-13',70,'NonPO',3)");
seed('tr_non_po_detail',['id'=>31,'no_doc'=>'NP1','tgl_pr'=>'2026-11-13','deskripsi'=>'Item','nilai_satuan_request'=>70,'total_request'=>70,'status'=>'0']);
sql("INSERT INTO tr_pengajuan_rutin (id,no_doc,tanggal_doc,nilai_total,status,created_by) VALUES (1,'RT1','2026-11-13',170,1,'missing')");
foreach ([41=>80,42=>90] as $id=>$amount) seed('tr_pengajuan_rutin_detail',['id'=>$id,'no_doc'=>'RT1','nama'=>'Rutin','tanggal'=>'2026-11-13','nilai'=>$amount,'coa'=>'C1','id_payment'=>0,'status'=>'0']);
$sources=$model->listData('request',[]);
check($sources['total']===5 && count(array_filter($sources['rows'],fn($r)=>$r['tipe']==='periodik' && $r['nama']==='missing'))===2,'Union lists five sources including both routine details and missing creator fallback');
foreach (['kasbon'=>[1,1],'transportasi'=>[1,21],'nonpo'=>[1,31],'periodik'=>[41,41]] as $type=>$pair) {
    requestPost($type,$pair[0]); check(callPayment('save_request')['save']===true,$type.' request succeeds');
    approvalPost($type,$pair[0],[$pair[1]]); check(callPayment('save_approval')['save']===true,$type.' approval succeeds');
}
check(sql("SELECT status FROM request_payment WHERE tipe='expense'")->row()->status==2,'Same source ID in another type does not alter Expense request');
check(sql('SELECT id_payment FROM tr_pengajuan_rutin_detail WHERE id=41')->row()->id_payment>0 && sql('SELECT id_payment FROM tr_pengajuan_rutin_detail WHERE id=42')->row()->id_payment==0,'Routine request links exact detail, leaving sibling untouched');
batchPayment(); $controller->input->values['edits']=['PAY202600003'=>['bank_admin'=>'2.50']];
check(callPayment('save_payment')['save']===true,'All four non-Expense payment types and admin fee succeed');
check(sql("SELECT status FROM tr_transport WHERE id=21")->row()->status==3,'Transport payment updates detail matched through no_req');
$unbalanced=sql('SELECT nomor FROM jurnal GROUP BY nomor HAVING ABS(SUM(debet)-SUM(kredit))>0.001')->result_array();
check(!$unbalanced,'All payment types produce balanced journals');
sql("INSERT INTO tr_expense (id,no_doc,tgl_doc,nama,informasi,status,jumlah,add_ppn_nilai,add_ppn_coa,add_pph_nilai,add_pph_coa) VALUES (2,'NEG','2026-11-13','owner','Negative',1,-385,20,'TAX',5,'TAX')");
sql("INSERT INTO tr_expense_detail (id,no_doc,tanggal,deskripsi,qty,harga,total_harga,expense,kasbon,coa,status,id_kasbon) VALUES (51,'NEG','2026-11-13','Item',1,100,100,100,0,'C1',0,''),(52,'NEG','2026-11-13','Kasbon',1,0,0,0,500,'C2',0,'K1')");
requestPost('expense',2); check(callPayment('save_request')['save']===true,'Negative net Expense request allowed');
approvalPost('expense',2,[51]); $before=snapshotPayment();
check(callPayment('save_approval')['save']===false && snapshotPayment()===$before,'Tax/Kasbon Expense cannot approve partial details');
approvalPost('expense',2,[51,52]); check(callPayment('save_approval')['save']===true,'Full tax/Kasbon Expense approval preserves negative net');
$negative=sql("SELECT * FROM payment_approve WHERE no_doc='NEG'")->row_array();
check((float)$negative['jumlah']===-385.0 && (float)$negative['nilai_request']===-385.0,'Tax/Kasbon net stored consistently');
batchPayment(); check(callPayment('save_payment')['save']===true,'Negative net Expense payment succeeds');
$bank=sql("SELECT SUM(debet) AS d,SUM(kredit) AS k FROM jurnal WHERE no_reff='NEG' AND no_perkiraan='BANK'")->row();
check((float)$bank->d===385.0 && (float)$bank->k===0.0,'Negative payment puts bank entry on debit side');
sql("INSERT INTO tr_expense (id,no_doc,tgl_doc,nama,informasi,status,jumlah,add_ppn_nilai,add_pph_nilai) VALUES (3,'ZERO','2026-11-13','owner','Zero net',1,0,0,0)");
sql("INSERT INTO tr_expense_detail (id,no_doc,tanggal,deskripsi,qty,harga,total_harga,expense,kasbon,coa,status,id_kasbon) VALUES (61,'ZERO','2026-11-13','Item',1,100,100,100,0,'C1',0,''),(62,'ZERO','2026-11-13','Kasbon',1,0,0,0,100,'C2',0,'K1')");
requestPost('expense',3); check(callPayment('save_request')['save']===true,'Zero net Expense can be requested');
approvalPost('expense',3,[61,62]); check(callPayment('save_approval')['save']===true,'Zero net Expense can be approved');
batchPayment(); check(callPayment('save_payment')['save']===true,'Zero net Expense still creates balancing journal');
check((float)sql("SELECT SUM(debet) AS n FROM jurnal WHERE no_reff='ZERO'")->row()->n===100.0,'Zero bank movement does not skip source ledger entries');
class Payment_fault_db {
    public $connection,$fail,$calls=0,$db_debug=true,$locks=0,$active=false;
    function __construct($connection,$fail) { $this->connection=$connection; $this->fail=$fail; }
    function __call($method,$args) {
        if ($method==='trans_begin' && $this->fail==='begin') return false;
        if ($method==='trans_status' && $this->fail==='status') return false;
        if ($method==='trans_commit' && $this->fail==='commit') return false;
        if ($method==='trans_rollback' && $this->fail==='rollback') { $this->connection->trans_rollback(); return false; }
        if ($method==='query' && str_contains($args[0],'FOR UPDATE')) { if (!$this->active) throw new LogicException('Row lock outside transaction'); $this->locks++; }
        if ($method==='insert' && $args[0]==='jurnal' && in_array($this->fail,['journal','rollback'],true) && ++$this->calls===2) return false;
        if ($method==='update' && $args[0]==='jurnal' && $this->fail==='posting' && ++$this->calls===1) { $this->connection->reset_query(); throw new RuntimeException('Injected after MyISAM accounting header'); }
        $result=call_user_func_array([$this->connection,$method],$args);
        if ($method==='trans_begin' && $result) $this->active=true;
        if (in_array($method,['trans_commit','trans_rollback'],true) && $result) $this->active=false;
        return $result===$this->connection ? $this : $result;
    }
}
sql("INSERT INTO tr_expense (id,no_doc,tgl_doc,nama,informasi,status,jumlah,add_ppn_nilai,add_pph_nilai) VALUES (4,'FAIL','2026-11-13','owner','Failure',1,100,0,0)");
sql("INSERT INTO tr_expense_detail (id,no_doc,tanggal,deskripsi,qty,harga,total_harga,expense,kasbon,coa,status) VALUES (71,'FAIL','2026-11-13','Item',1,100,100,100,0,'C1',0)");
requestPost('expense',4); callPayment('save_request'); approvalPost('expense',4,[71]); callPayment('save_approval');
foreach (['begin','journal','status'] as $failure) {
    batchPayment(); $before=snapshotPayment(); $fault=new Payment_fault_db($connection,$failure); $controller->db=$model->db=$fault;
    check(callPayment('save_payment')['save']===false && snapshotPayment()===$before,'Failed '.$failure.' rolls back source and removes only new MyISAM journal');
    check($fault->db_debug===true,'DB debug restored after failure'); $controller->db=$model->db=$connection;
}
$pending=sql("SELECT id FROM payment_approve WHERE no_doc='FAIL'")->row()->id;
foreach (['commit','rollback'] as $failure) {
    batchPayment(); $fault=new Payment_fault_db($connection,$failure); $controller->db=$model->db=$fault;
    check(callPayment('save_payment')['save']===false,'Uncertain '.$failure.' returns failure'); $controller->db=$model->db=$connection;
    check(sql('SELECT COUNT(*) AS n FROM jurnal WHERE nomor=?',['BUK030'.$pending])->row()->n>0,'Uncertain '.$failure.' retains journal for reconciliation');
    batchPayment(); check(callPayment('save_payment')['save']===false,'Unreconciled reserved journal blocks automatic retry');
    sql('DELETE FROM jurnal WHERE nomor=?',['BUK030'.$pending]);
}
batchPayment(); check(callPayment('save_payment')['save']===true,'Retry succeeds after confirmed cleanup');
$number='BUK030'.$pending;
journalPost($number); $before=snapshotPayment(); $beforeGl=sql('SELECT * FROM '.DBACC.'.jurnal ORDER BY nomor,no_perkiraan')->result_array(); $beforeHeaders=sql('SELECT * FROM '.DBACC.'.japh ORDER BY nomor')->result_array();
$fault=new Payment_fault_db($connection,'posting'); $controller->db=$model->db=$fault;
check(callPayment('jurnal_save')['save']===false,'Injected posting failure reported'); $controller->db=$model->db=$connection;
check(snapshotPayment()===$before && sql('SELECT * FROM '.DBACC.'.jurnal ORDER BY nomor,no_perkiraan')->result_array()===$beforeGl && sql('SELECT * FROM '.DBACC.'.japh ORDER BY nomor')->result_array()===$beforeHeaders,'Posting failure restores source and compensates new MyISAM header');
requestPost('periodik',42); callPayment('save_request'); approvalPost('periodik',42,[42]); callPayment('save_approval');
$uploadPayment=sql("SELECT id FROM payment_approve WHERE ids='42' AND tipe='periodik'")->row()->id;
batchPayment(); sql("UPDATE payment_approve SET keterangan='Other editor' WHERE id=?",[$uploadPayment]); $before=snapshotPayment();
check(callPayment('save_payment')['save']===false && snapshotPayment()===$before,'Initial batch rejects changed header instead of silently paying updated data');
class Payment_upload {
    public $config,$last,$created=[];
    function initialize($config) { $this->config=$config; }
    function do_upload($key) {
        $this->last=$this->config['upload_path'].DIRECTORY_SEPARATOR.'payment-test-'.bin2hex(random_bytes(8)).'.png';
        file_put_contents($this->last,base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+jRZkAAAAASUVORK5CYII='));
        $this->created[]=$this->last; return true;
    }
    function data() { return ['full_path'=>$this->last]; }
    function display_errors(...$args) { return 'Invalid test MIME'; }
}
$controller->upload=new Payment_upload(); $controller->load=new class { function library($name) {} };
register_shutdown_function(function () use ($controller) {
    $root=realpath(FCPATH.'assets/expense');
    foreach ($controller->upload->created as $file) if (dirname($file)===$root && str_starts_with(basename($file),'payment-test-') && is_file($file)) unlink($file);
});
function paymentUpload($error=UPLOAD_ERR_OK) {
    global $uploadPayment,$controller;
    $controller->input->values['files']=[$uploadPayment];
    $_FILES['doc_file_'.$uploadPayment]=['name'=>'test.png','type'=>'image/png','tmp_name'=>'simulated-cli-transport','size'=>68,'error'=>$error];
}
batchPayment(); paymentUpload(UPLOAD_ERR_PARTIAL); $before=snapshotPayment();
check(callPayment('save_payment')['save']===false && snapshotPayment()===$before,'PHP partial upload aborts whole payment');
batchPayment(); paymentUpload(); $before=snapshotPayment(); $controller->db=$model->db=new Payment_fault_db($connection,'journal');
check(callPayment('save_payment')['save']===false && snapshotPayment()===$before && !is_file($controller->upload->last),'Payment failure removes new upload after confirmed rollback'); $controller->db=$model->db=$connection;
batchPayment(); paymentUpload();
$copy=sql('SELECT * FROM payment_approve WHERE id=?',[$uploadPayment])->row_array(); $copy['id']='PAY202699999'; $model->write('insert','payment_approve',$copy);
check(callPayment('save_payment')['save']===true,'Successful upload pays initial manifest');
check(sql("SELECT status FROM payment_approve WHERE id='PAY202699999'")->row()->status==1,'New pending payment after opening page stays outside initial manifest');
check(is_file($controller->upload->last) && $controller->upload->config['encrypt_name'] && $controller->upload->config['detect_mime'],'Payment upload uses encrypted filename and MIME detection');
sql("DELETE FROM payment_approve WHERE id='PAY202699999'");
sql("INSERT INTO tr_expense (id,no_doc,tgl_doc,nama,informasi,status,jumlah,add_ppn_nilai,add_ppn_coa,add_pph_nilai,add_pph_coa,created_by) VALUES (5,'CENTS','2026-11-13','Long beneficiary display name','Fractions',1,104.75,10.25,'TAX',5.50,'TAX','7')");
sql("INSERT INTO tr_expense_detail (id,no_doc,tanggal,deskripsi,qty,harga,total_harga,expense,kasbon,coa,status) VALUES (91,'CENTS','2026-11-13','Item',1,100,100,100,0,'C1',0)");
requestPost('expense',5); $controller->input->values['items']=json_encode($controller->input->values['items']);
check(callPayment('save_request')['save']===true,'JSON batch bypasses PHP max_input_vars without losing selected rows');
$controller->input->values=['search'=>['value'=>'CENTS']]; $fraction=callPayment('data_approval');
check((float)$fraction['data'][0]['nilai_request']===104.75,'Approval display uses authoritative cents instead of rounded legacy field');
approvalPost('expense',5,[91]); check(callPayment('save_approval')['save']===true,'Fractional Expense tax approval succeeds');
batchPayment(); sql('UPDATE tr_expense SET add_ppn_nilai=11.25,add_pph_nilai=6.50 WHERE id=5'); $before=snapshotPayment();
check(callPayment('save_payment')['save']===false && snapshotPayment()===$before,'Batch detects changed tax amounts even when net remains unchanged');
sql('UPDATE tr_expense SET add_ppn_nilai=10.25,add_pph_nilai=5.50 WHERE id=5'); batchPayment();
check(callPayment('save_payment')['save']===true,'Fractional Expense payment succeeds without losing cents');
$paid=sql("SELECT * FROM payment_approve WHERE no_doc='CENTS'")->row();
check((float)$paid->jumlah===104.75 && (float)$paid->bank_nilai===104.75 && (float)$paid->nilai_request===105.0,'Payment stores exact amount while respecting legacy integer precision');
check(sql("SELECT DISTINCT nocust FROM jurnal WHERE no_reff='CENTS'")->row()->nocust==='7','Long display name uses canonical source creator reference within nocust capacity');
sql("INSERT INTO tr_expense (id,no_doc,tgl_doc,nama,informasi,status,jumlah,add_ppn_nilai,add_pph_nilai) VALUES (6,'EQUAL','2026-11-13','owner','Equal rows',1,200,0,0)");
foreach ([81,82] as $id) sql("INSERT INTO tr_expense_detail (id,no_doc,tanggal,deskripsi,qty,harga,total_harga,expense,kasbon,coa,status) VALUES (?,'EQUAL','2026-11-13','Same',1,100,100,100,0,'C1',0)",[$id]);
requestPost('expense',6); callPayment('save_request');
foreach ([81,82] as $id) { approvalPost('expense',6,[$id]); callPayment('save_approval'); }
batchPayment(); check(callPayment('save_payment')['save']===true,'Identical source details across partial batches can be paid together');
check(sql("SELECT COUNT(*) AS n FROM tr_expense_detail WHERE no_doc='EQUAL' AND status=2")->row()->n==2,'Identical snapshot rows claim distinct source details');
sql("INSERT INTO tr_kasbon (id,no_doc,tgl_doc,nama,keperluan,jumlah_kasbon,status,coa) VALUES (3,'KAS3','2026-11-13','owner','Kasbon3',50,1,'C1')");
requestPost('kasbon',3); $before=snapshotPayment(); $controller->db=$model->db=new Payment_fault_db($connection,'status');
check(callPayment('save_request')['save']===false && snapshotPayment()===$before,'Failed request transaction restores source and request insert'); $controller->db=$model->db=$connection;
requestPost('kasbon',3); sql("UPDATE tr_kasbon SET jumlah_kasbon=60 WHERE id=3"); $before=snapshotPayment();
check(callPayment('save_request')['save']===false && snapshotPayment()===$before,'Request version rejects changed source amount');
foreach (['save_request'=>'Request_Payment.Manage','save_approval'=>'Request_Payment_Approval.Manage','save_payment'=>'Request_Payment.Manage','jurnal_save'=>'Request_Payment.Manage'] as $method=>$permission) {
    $controller->auth->denied=[$permission];
    try { callPayment($method); throw new LogicException('Manage bypass'); } catch (DomainException $e) { check($e->getMessage()==='Denied',$method.' enforces permission'); }
}
$controller->auth->denied=[];
foreach (['request','approval','payment','jurnal'] as $kind) {
    $controller->input->values=[];
    if ($kind==='payment') { batchPayment([]); $controller->auth->denied=['Request_Payment.Manage']; }
    $result=callPayment('data_'.$kind);
    check(isset($result['recordsTotal'],$result['recordsFiltered']) && !isset($result['error']),$kind.' table returns valid counts under ONLY_FULL_GROUP_BY');
    $controller->auth->denied=[];
}
for ($i=0;$i<105;$i++) $model->write('insert','request_payment',['no_doc'=>'PAGE'.str_pad((string)$i,3,'0',STR_PAD_LEFT),'tipe'=>'expense','ids'=>(string)(2000+$i),'status'=>0,'jumlah'=>100,'nilai_request'=>100,'tanggal'=>'2026-11-13']);
$controller->input->values=['length'=>-1]; $result=callPayment('data_approval');
check($result['recordsTotal']===105 && count($result['data'])===100,'Approval table caps all-length request at 100');
$controller->input->values=['length'=>10,'start'=>10,'order'=>[['column'=>1,'dir'=>'asc']]]; $page=callPayment('data_approval');
$controller->input->values['start']=0; $first=callPayment('data_approval');
check($page['data'][0]['no']===11 && !array_intersect(array_column($page['data'],'key'),array_column($first['data'],'key')),'Stable pages have consecutive row numbers and disjoint keys');
sql("UPDATE request_payment SET keperluan=? WHERE no_doc='PAGE000'",["Needle_%!' <tag>"]);
$controller->input->values=['search'=>['value'=>"Needle_%!'"]]; $result=callPayment('data_approval');
check($result['recordsFiltered']===1 && $result['data'][0]['keperluan']==="Needle_%!' <tag>",'Literal wildcard search returns raw text for safe client rendering');
foreach ([['draw'=>[]],['start'=>-1],['length'=>0],['search'=>['value'=>[]]],['order'=>[['column'=>1,'dir'=>'desc;DROP TABLE request_payment']]]] as $bad) {
    $controller->input->values=$bad; $result=callPayment('data_approval'); check(isset($result['error']) && $result['data']===[],'Invalid DataTables parameters return safe JSON');
}
function &get_instance() { return $GLOBALS['controller']; }
$controller->config=new class { function site_url($path) { return '/app/'.$path; } function item($name) { return $name==='charset'?'UTF-8':false; } };
require BASEPATH.'helpers/form_helper.php';
function renderPayment($view,$values) {
    global $controller;
    $render=function () use ($view,$values) { extract($values); include APPPATH.'modules/request_payment/views/'.$view.'.php'; };
    ob_start(); try { $render->call($controller); return ob_get_contents(); } finally { ob_end_clean(); }
}
$controller->template=new class {
    public $values=[],$view;
    function set($key,$value) { $this->values[$key]=$value; }
    function title($value) {} function page_icon($value) {}
    function render($view) { $this->view=$view; echo renderPayment($view,$this->values); }
};
function htmlPayment($method,...$args) {
    global $controller; ob_start();
    try { $controller->$method(...$args); return ob_get_contents(); }
    catch (Payment_http_error $e) { if ($e->getCode()===500) throw new RuntimeException(end($GLOBALS['payment_logs']),0,$e); throw $e; }
    finally { ob_end_clean(); }
}
$rendered=[];
foreach (['index'=>'request','list_approve'=>'approval','list_payment'=>'payment','payment_jurnal_list'=>'jurnal'] as $method=>$kind) {
    $html=htmlPayment($method); $rendered[]=$html;
    check(str_contains($html,'id="payment-table"') && str_contains($html,'data-kind="'.$kind.'"') && !str_contains($html,'basic.js'),$kind.' renders isolated empty server-side table');
}
check(count($controller->session->values['payment_batches'])<=20,'Session bounds tab manifest retention');
$token=array_key_last($controller->session->values['payment_batches']);
$controller->input->values=['batch_token'=>$token]; $result=callPayment('data_payment');
check($result['recordsTotal']===0 && $result['data']===[],'Empty initial payment manifest remains empty');
$controller->auth->denied=['Request_Payment.Manage']; $html=htmlPayment('index');
check(!str_contains($html,'type="submit"'),'View-only Request table hides Update');
$html=htmlPayment('view_jurnal',$number); $rendered[]=$html;
check(!str_contains($html,'<form') && !str_contains($html,'type="submit"') && str_contains($html,'readonly'),'Journal View cannot submit a posting');
$controller->auth->denied=[];
$html=htmlPayment('edit_jurnal',$number); $rendered[]=$html;
check(str_contains($html,'name="version"') && str_contains($html,'name="items[0][id]"'),'Journal Edit includes version and validated group identity');
try { htmlPayment('edit_jurnal',$totals[0]['nomor']); throw new LogicException('Posted edit opened'); }
catch (Payment_http_error $e) { check($e->getCode()===404,'Posted journal edit returns controlled 404'); }
sql("INSERT INTO tr_kasbon (id,no_doc,tgl_doc,nama,keperluan,jumlah_kasbon,status,coa) VALUES (2,'KAS2','2026-11-13','owner',?,50,1,'C1')",["Kasbon ' <tag>"]);
requestPost('kasbon',2); callPayment('save_request'); $controller->input->values=['type'=>'kasbon','id'=>'2'];
$html=htmlPayment('approval_payment'); $rendered[]=$html;
check(str_contains($html,'&lt;tag&gt;') && !str_contains($html,"Kasbon ' <tag>") && str_contains($html,'type="submit"'),'Approval form escapes source data and renders selectable details');
$controller->auth->denied=['Request_Payment_Approval.Manage']; $html=htmlPayment('approval_payment');
check(!str_contains($html,'type="submit"') && !str_contains($html,'type="checkbox"'),'Approval View permission cannot expose mutation controls');
$controller->auth->denied=[];
foreach ([['type'=>'bad','id'=>'1'],['type'=>'expense','id'=>'1 OR 1=1'],['type'=>'kasbon','id'=>'999']] as $bad) {
    $controller->input->values=$bad;
    try { htmlPayment('approval_payment'); throw new LogicException('Invalid source opened'); }
    catch (Payment_http_error $e) { check($e->getCode()===404,'Invalid approval source returns controlled 404'); }
}
foreach (['index'=>'Request_Payment.View','data_request'=>'Request_Payment.View','list_approve'=>'Request_Payment_Approval.View','data_approval'=>'Request_Payment_Approval.View','approval_payment'=>'Request_Payment_Approval.View','list_payment'=>'Request_Payment.View','data_payment'=>'Request_Payment.View','payment_jurnal_list'=>'Request_Payment.View','data_jurnal'=>'Request_Payment.View','view_jurnal'=>'Request_Payment.View','edit_jurnal'=>'Request_Payment.Manage','export_payment'=>'Request_Payment.View'] as $method=>$permission) {
    $controller->auth->denied=[$permission];
    try { htmlPayment($method,$number); throw new LogicException('View permission bypass'); }
    catch (DomainException $e) { check($e->getMessage()==='Denied',$method.' enforces read/edit permission'); }
}
$controller->auth->denied=[];
approvalPost('kasbon',2,[2]); callPayment('save_approval');
$export=sql("SELECT * FROM payment_approve WHERE no_doc='KAS2'")->row_array();
for ($i=0;$i<12;$i++) { $copy=$export; $copy['id']='PAY2099'.str_pad((string)$i,5,'0',STR_PAD_LEFT); $copy['no_doc']='EXPORT'.$i; $copy['nama']='=FORMULA <tag>'; $model->write('insert','payment_approve',$copy); }
$controller->input->values=['search'=>['value'=>'EXPORT'],'length'=>10]; $html=htmlPayment('export_payment');
check(substr_count($html,'<tr>')===13 && str_contains($html,'&#039;=FORMULA &lt;tag&gt;'),'Export includes all matching pages and neutralizes formulas/HTML');
require BASEPATH.'libraries/Upload.php';
$native=new CI_Upload(['allowed_types'=>'gif|jpg|png|jpeg|bmp|pdf|doc|docx|jfif']);
$native->file_ext='.png'; $native->file_temp=$controller->upload->last; $native->file_type='image/png';
check($native->is_allowed_filetype(),'Native MIME validation accepts actual image');
$native->file_temp=__FILE__; check(!$native->is_allowed_filetype(),'Native MIME validation rejects text disguised as image');
foreach (['save_request','save_approval','save_payment','jurnal_save'] as $method) {
    $controller->input->verb='get'; $before=snapshotPayment();
    check(callPayment($method)['save']===false && snapshotPayment()===$before,$method.' rejects GET without changing data');
}
$controller->input->verb='post';
$second=DB($config,true); $lock='request-payment:'.DBERP;
check((int)$second->query('SELECT GET_LOCK(?,0) AS acquired',[$lock])->row()->acquired===1,'Second connection can reserve payment serialization lock');
$controller->input->values=[]; $before=snapshotPayment();
check(callPayment('save_request')['save']===false && snapshotPayment()===$before,'Second connection prevents concurrent status and number mutation');
$second->query('SELECT RELEASE_LOCK(?)',[$lock]);
callPayment('save_request');
check((int)$second->query('SELECT GET_LOCK(?,0) AS acquired',[$lock])->row()->acquired===1,'Mutation releases named lock on validation failure');
$second->query('SELECT RELEASE_LOCK(?)',[$lock]); $second->close();
if (getenv('PAYMENT_RENDER_JSON')==='1') echo 'RENDER_JSON:'.json_encode($rendered)."\n";
