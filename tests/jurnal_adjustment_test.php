<?php
// JURNAL_ADJUSTMENT_TEST_DB=1: fixtures shadow operational tables on this connection only.
if (PHP_SAPI !== 'cli' || getenv('JURNAL_ADJUSTMENT_TEST_DB') !== '1') {
    exit("Set JURNAL_ADJUSTMENT_TEST_DB=1 to run isolated integration checks.\n");
}
error_reporting(E_ALL);
set_error_handler(function ($severity, $message, $file, $line) {
    if (error_reporting() & $severity) { throw new ErrorException($message, 0, $severity, $file, $line); }
    return false;
});
define('BASEPATH', dirname(__DIR__) . '/system/');
define('ENVIRONMENT', 'development');
define('DBERP', 'waterco_demo');
define('DBACC', 'gl_waterco');
require dirname(__DIR__) . '/application/config/development/database.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$config = $db['default'];
$connection = new mysqli($config['hostname'], $config['username'], $config['password'], $config['database'], (int)($config['port'] ?? 3306));
$connection->set_charset('utf8mb4');
$connection->query("SET SESSION sql_mode='STRICT_ALL_TABLES,NO_ENGINE_SUBSTITUTION'");
$tables = array(DBERP.'.adjustment_stock', DBERP.'.ms_costbook', DBERP.'.ms_costbook_backup', DBACC.'.javh', DBACC.'.jurnal', DBACC.'.pastibisa_tb_cabang', DBACC.'.coa_master');
foreach ($tables as $table) {
    $definition = $connection->query('SHOW CREATE TABLE '.$table)->fetch_row()[1];
    $definition = preg_replace('/^CREATE TABLE `[^`]+`/', 'CREATE TEMPORARY TABLE '.$table, $definition);
    if ($table !== DBACC.'.coa_master') { $definition = preg_replace('/ENGINE=\w+/', 'ENGINE=InnoDB', $definition); }
    $connection->query($definition);
}
function log_message($level, $message) {}
function is_php($version) { return version_compare(PHP_VERSION, $version, '>='); }
function html_escape($value) { return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
function has_permission($permission) { return !in_array($permission, $GLOBALS['denied'], true); }
require BASEPATH.'database/DB_driver.php';
require BASEPATH.'database/DB_query_builder.php';
class CI_DB extends CI_DB_query_builder {}
require BASEPATH.'database/drivers/mysqli/mysqli_driver.php';
class JournalTestDb extends CI_DB_mysqli_driver {
    public $failAt = '';
    public $failOccurrence = 1;
    public $matches = 0;
    public $failCommit = false;
    public $failBegin = false;
    protected function _execute($sql) {
        if ($this->failAt !== '' && strpos($sql, $this->failAt) === 0 && ++$this->matches === $this->failOccurrence) { throw new RuntimeException('Injected query failure'); }
        return parent::_execute($sql);
    }
    protected function _trans_begin() { return $this->failBegin ? false : parent::_trans_begin(); }
    protected function _trans_commit() { return $this->failCommit ? false : parent::_trans_commit(); }
}
require BASEPATH.'core/Model.php';
require dirname(__DIR__).'/application/core/BF_Model.php';
class MX_Controller {}
require dirname(__DIR__).'/application/core/Base_Controller.php';
require dirname(__DIR__).'/application/core/Admin_Controller.php';
class JournalTestInput {
    public $values = array(); public $verb = 'POST';
    public function post($key, $clean = false) { return $this->values[$key] ?? null; }
    public function get($key, $clean = false) { return $this->post($key); }
    public function method($upper = false) { return $upper ? $this->verb : strtolower($this->verb); }
}
class JournalTestSession {
    public $values = array();
    public function userdata($key) { return $this->values[$key] ?? null; }
    public function set_userdata($key, $value) { $this->values[$key] = $value; }
}
class JournalTestAuth {
    public function user_id() { return 'journal-test'; }
    public function restrict($permission) { if (!has_permission($permission)) { throw new DomainException('Denied', 403); } }
}
class JournalTestOutput {
    public function set_content_type($type) { return $this; }
    public function set_header($header) { return $this; }
}
class JournalTestLoad {
    public function view($name, $data) { extract($data); require dirname(__DIR__).'/application/modules/jurnal_adjustment/views/'.$name.'.php'; }
}
require dirname(__DIR__).'/application/modules/jurnal_adjustment/models/Jurnal_adjustment_model.php';
require dirname(__DIR__).'/application/modules/jurnal_adjustment/controllers/Jurnal_adjustment.php';
$checks = 0; $denied = array();
function journalCheck($condition, $message) {
    ++$GLOBALS['checks'];
    if (!$condition) { throw new RuntimeException($message); }
}
function journalReset() {
    global $connection, $tables, $model, $controller, $ciDb, $input, $session, $denied;
    foreach ($tables as $table) { $connection->query('DELETE FROM '.$table); }
    $connection->query("INSERT INTO adjustment_stock (id_transaksi,id_material,nama_material,adjustment,total_qty,tanggal_transaksi,status_jurnal,note) VALUES ('ADJ-TEST','ITEM','Barang','PLUS',3,CURDATE(),'OPN','Catatan')");
    $connection->query("INSERT INTO ms_costbook (id_category3,nilai_costbook) VALUES ('ITEM',10.25)");
    $connection->query("INSERT INTO gl_waterco.pastibisa_tb_cabang (nocab,subcab,nomorJC,lastupdate) VALUES ('101','A',100,CURDATE())");
    $connection->query("INSERT INTO gl_waterco.coa_master (no_perkiraan,nama,kdcab) VALUES ('1105-01-01','Persediaan','101-A'),('6201-01-51','Selisih','101-A')");
    $ciDb = new JournalTestDb(array('conn_id'=>$connection, 'database'=>DBERP, 'db_debug'=>false, 'char_set'=>'utf8mb4', 'save_queries'=>false));
    $model = (new ReflectionClass('Jurnal_adjustment_model'))->newInstanceWithoutConstructor(); $model->db = $ciDb;
    $input = new JournalTestInput(); $session = new JournalTestSession(); $denied = array();
    $controller = (new ReflectionClass('Jurnal_adjustment'))->newInstanceWithoutConstructor();
    foreach (array('db'=>$ciDb, 'input'=>$input, 'session'=>$session, 'auth'=>new JournalTestAuth(), 'load'=>new JournalTestLoad(), 'output'=>new JournalTestOutput(), 'Jurnal_adjustment_model'=>$model) as $key=>$value) { $controller->$key=$value; }
}
function journalCall($method) {
    ob_start();
    try { $GLOBALS['controller']->$method(); return ob_get_contents(); }
    finally { ob_end_clean(); }
}
function journalPreview() {
    global $input, $session;
    $input->verb='GET'; $input->values=array('id_transaksi'=>'ADJ-TEST');
    $html=journalCall('process_jurnal');
    $input->verb='POST';
    preg_match('/name="preview_token" value="([a-f0-9]+)"/', $html, $match);
    $input->values=array('id_transaksi'=>'ADJ-TEST','preview_token'=>$match[1] ?? '');
    return $html;
}
function journalSave() { return json_decode(journalCall('save_post_jurnal_adjustment'), true, 512, JSON_THROW_ON_ERROR); }
function journalSnapshot() {
    global $tables, $connection;
    $snapshot=array();
    foreach ($tables as $table) { $snapshot[$table]=$connection->query('SELECT * FROM '.$table)->fetch_all(MYSQLI_ASSOC); }
    return $snapshot;
}
function journalReject($code, $message) {
    global $ciDb;
    $before=journalSnapshot(); $result=journalSave();
    journalCheck($result['code']===$code && http_response_code()===$code, $message.' (response '.json_encode($result).')');
    journalCheck($before===journalSnapshot(), $message.': rejected posting changed database');
    $depth=new ReflectionProperty(CI_DB_driver::class, '_trans_depth');
    journalCheck($depth->getValue($ciDb)===0, $message.': transaction depth leaked');
}

journalReset(); journalPreview();
$connection->query("UPDATE adjustment_stock SET status_jurnal='CLS'");
$before=journalSnapshot(); $result=journalSave();
journalCheck($result['code']===409, 'Closed adjustment was posted again');
journalCheck($before===journalSnapshot(), 'Rejected posting changed database');

foreach (array('PLUS','MINUS') as $type) {
    journalReset(); $connection->query("UPDATE adjustment_stock SET adjustment='$type',status_jurnal=NULL");
    $html=journalPreview(); $snapshot=$session->values['jurnal_adjustment_preview']['snapshot'];
    $result=journalSave();
    journalCheck($result['code']===200 && $result['nomor']==='101-AJV'.date('y').'00101', 'Valid '.$type.' failed');
    $header=$connection->query('SELECT * FROM gl_waterco.javh')->fetch_all(MYSQLI_ASSOC);
    $detail=$connection->query('SELECT * FROM gl_waterco.jurnal ORDER BY no_perkiraan')->fetch_all(MYSQLI_ASSOC);
    journalCheck(count($header)===1 && count($detail)===2, 'Journal row count wrong');
    journalCheck((float)$header[0]['jml']===31.0 && (float)array_sum(array_column($detail,'debet'))===31.0 && (float)array_sum(array_column($detail,'kredit'))===31.0, 'Journal not balanced/rounded');
    journalCheck((float)$detail[0][$type==='PLUS' ? 'debet' : 'kredit']===31.0, 'Inventory side wrong');
    $source=$connection->query('SELECT * FROM adjustment_stock')->fetch_assoc();
    journalCheck($source['status_jurnal']==='CLS' && (float)$source['costbook']===10.25 && (float)$source['total_value']===31.0, 'Posting snapshot not saved');
    journalCheck(strpos($html, 'class="form-control form-control-sm"')!==false && strpos($html, 'class="bg-primary"')!==false && strpos($html, '>31<')!==false, 'Original modal layout or preview amount changed');
    journalReject(403, 'Consumed token replay');
    $before=journalSnapshot();
    try { $model->post_journal('ADJ-TEST', $snapshot, 'other-user'); throw new RuntimeException('Second session posted same adjustment'); }
    catch (DomainException $error) { journalCheck($error->getCode()===409, 'Second session rejection code wrong'); }
    journalCheck($before===journalSnapshot(), 'Second session changed journal');
}

foreach (array(
    "DELETE FROM ms_costbook",
    "UPDATE ms_costbook SET nilai_costbook=0",
    "UPDATE ms_costbook SET nilai_costbook=-1",
    "UPDATE ms_costbook SET nilai_costbook=NULL",
    "UPDATE ms_costbook SET nilai_costbook=0.01",
    "UPDATE ms_costbook SET nilai_costbook=9007199254740992",
    "INSERT INTO ms_costbook (id_category3,nilai_costbook) VALUES ('ITEM',10.25)",
    "DELETE FROM gl_waterco.coa_master WHERE no_perkiraan='6201-01-51'",
    "UPDATE gl_waterco.coa_master SET kdcab='102-A'",
    "INSERT INTO gl_waterco.coa_master (no_perkiraan,kdcab,bln) VALUES ('1105-01-01','101-A',1)",
    "UPDATE adjustment_stock SET adjustment='MUTASI'",
    "UPDATE adjustment_stock SET total_qty=0",
    "UPDATE adjustment_stock SET total_qty=-1",
    "UPDATE adjustment_stock SET total_qty=NULL",
    "UPDATE adjustment_stock SET adjustment=NULL",
    "UPDATE adjustment_stock SET tanggal_transaksi=NULL",
    "UPDATE adjustment_stock SET id_material=NULL",
    "UPDATE adjustment_stock SET tanggal_transaksi=DATE_ADD(CURDATE(),INTERVAL 1 DAY)",
    "DELETE FROM gl_waterco.pastibisa_tb_cabang",
    "INSERT INTO gl_waterco.pastibisa_tb_cabang (nocab,subcab,lastupdate) VALUES ('101','A',CURDATE())",
    "UPDATE gl_waterco.pastibisa_tb_cabang SET nomorJC=-1",
    "UPDATE gl_waterco.pastibisa_tb_cabang SET nomorJC=2147483647"
) as $sql) {
    journalReset(); journalPreview(); $connection->query($sql); journalReject(422, $sql);
}
foreach (array(
    "UPDATE adjustment_stock SET total_qty=4",
    "UPDATE ms_costbook SET nilai_costbook=11",
    "UPDATE gl_waterco.coa_master SET nama='Berubah'",
    "UPDATE adjustment_stock SET tanggal_transaksi=DATE_SUB(CURDATE(),INTERVAL 1 DAY)",
) as $sql) {
    journalReset(); journalPreview();
    $connection->query("INSERT INTO ms_costbook_backup (id_category3,nilai_costbook,tgl) VALUES ('ITEM',10.25,DATE_SUB(CURDATE(),INTERVAL 1 DAY))");
    $connection->query($sql); journalReject(409, 'Stale preview: '.$sql);
}
foreach (array(
    "INSERT INTO adjustment_stock (id_transaksi,adjustment,total_qty,tanggal_transaksi) VALUES ('ADJ-TEST','PLUS',3,CURDATE())",
    "INSERT INTO gl_waterco.jurnal (no_perkiraan,no_reff,nomor,debet,kredit) VALUES ('1105-01-01','ADJ-TEST','OLD',31,0)",
    "INSERT INTO gl_waterco.javh (nomor,tgl,jml,memo,keterangan) VALUES ('OLD',CURDATE(),31,'','Adjustment PLUS ADJ-TEST')",
    "INSERT INTO gl_waterco.javh (nomor,tgl,jml,memo) VALUES ('101-AJV".date('y')."00101',CURDATE(),31,'')",
    "INSERT INTO gl_waterco.jurnal (nomor,no_perkiraan) VALUES ('101-AJV".date('y')."00101','1105-01-01')"
) as $sql) { journalReset(); journalPreview(); $connection->query($sql); journalReject(409, $sql); }
journalReset(); journalPreview(); $connection->query('DELETE FROM adjustment_stock'); journalReject(404, 'Missing source');

foreach (array('UPDATE gl_waterco.pastibisa_tb_cabang', 'INSERT INTO gl_waterco.javh', 'INSERT INTO gl_waterco.jurnal', 'UPDATE waterco_demo.adjustment_stock') as $failAt) {
    foreach ($failAt==='INSERT INTO gl_waterco.jurnal' ? array(1,2) : array(1) as $occurrence) {
        journalReset(); journalPreview(); $ciDb->db_debug=true; $ciDb->failAt=$failAt; $ciDb->failOccurrence=$occurrence;
        journalReject(500, 'Injected failure '.$failAt.' #'.$occurrence);
        journalCheck($ciDb->db_debug===true, 'db_debug not restored');
    }
}
foreach (array('failCommit','failBegin') as $failure) {
    journalReset(); journalPreview(); $ciDb->$failure=true; journalReject(500, $failure);
}
foreach (array('gl_waterco.javh','gl_waterco.jurnal','gl_waterco.pastibisa_tb_cabang','waterco_demo.adjustment_stock') as $table) {
    journalReset(); journalPreview(); $connection->query('ALTER TABLE '.$table.' ENGINE=MyISAM');
    journalReject(503, 'MyISAM guard '.$table);
    $connection->query('ALTER TABLE '.$table.' ENGINE=InnoDB');
}

journalReset(); $connection->query("UPDATE adjustment_stock SET tanggal_transaksi=DATE_SUB(CURDATE(),INTERVAL 1 DAY)");
$connection->query("INSERT INTO ms_costbook_backup (id_category3,nilai_costbook,tgl) VALUES ('ITEM',9,DATE_SUB(CURDATE(),INTERVAL 1 DAY)),('ITEM',12.5,DATE_ADD(DATE_SUB(CURDATE(),INTERVAL 1 DAY),INTERVAL 12 HOUR)),('ITEM',99,CURDATE())");
journalPreview(); $result=journalSave();
journalCheck($result['code']===200 && (float)$connection->query('SELECT jml FROM gl_waterco.javh')->fetch_row()[0]===38.0, 'Historical costbook did not select latest same-day snapshot');
journalCheck($connection->query('SELECT tgl FROM gl_waterco.javh')->fetch_row()[0]===date('Y-m-d'), 'Posting date not today');
journalReset(); $connection->query("UPDATE adjustment_stock SET tanggal_transaksi=DATE_SUB(CURDATE(),INTERVAL 1 DAY)");
$connection->query("INSERT INTO ms_costbook_backup (id_category3,nilai_costbook,tgl) VALUES ('ITEM',9,DATE_SUB(CURDATE(),INTERVAL 2 DAY))");
journalCheck(json_decode(journalPreview(),true)['code']===422, 'Previous-day fallback accepted');
journalReset(); $connection->query("UPDATE adjustment_stock SET tanggal_transaksi=DATE_SUB(CURDATE(),INTERVAL 1 DAY)");
$connection->query("INSERT INTO ms_costbook_backup (id_category3,nilai_costbook,tgl) VALUES ('ITEM',9,DATE_SUB(CURDATE(),INTERVAL 1 DAY)),('ITEM',10,DATE_SUB(CURDATE(),INTERVAL 1 DAY))");
journalCheck(json_decode(journalPreview(),true)['code']===422, 'Ambiguous historical costbook accepted');

foreach (array('Jurnal_Adjustment.View','Jurnal_Adjustment.Manage') as $permission) {
    journalReset(); journalPreview(); $denied=array($permission); journalReject(403, 'Permission '.$permission);
    $input->verb='GET'; journalCheck(json_decode(journalCall('process_jurnal'),true)['code']===403, 'Preview permission missing');
    if ($permission==='Jurnal_Adjustment.View') { journalCheck(json_decode(journalCall('get_dataa_adjustment'),true)['code']===403, 'List permission missing'); }
}
journalReset(); journalPreview(); $input->verb='GET'; journalReject(405, 'GET posting');
journalReset(); journalPreview(); $input->values['preview_token']='wrong'; journalReject(403, 'Invalid token');
journalReset(); journalPreview(); $session->values=array(); journalReject(403, 'Other session token');
journalReset(); journalPreview(); $input->values['id_transaksi']=array('ADJ-TEST'); journalReject(403, 'Array ID token binding');
journalReset(); journalPreview(); $session->values['jurnal_adjustment_preview']['snapshot']['posting_date']='2000-01-01'; journalReject(409, 'Preview from previous posting date');
journalReset(); journalPreview(); $session->values=unserialize(serialize($session->values));
journalCheck(journalSave()['code']===200, 'Session serialization changed snapshot types');
journalReset(); $input->verb='GET';
foreach (array('',array('ADJ-TEST'),str_repeat('x',26),"bad\nID","\xff") as $badId) {
    $input->values=array('id_transaksi'=>$badId);
    journalCheck(json_decode(journalCall('process_jurnal'),true)['code']===422, 'Invalid preview ID accepted');
}

journalReset();
$connection->query("UPDATE adjustment_stock SET note='</textarea><img src=x onerror=alert(1)>',nama_material='<script>alert(1)</script>'");
$html=journalPreview();
journalCheck(strpos($html,'<img')===false && strpos($html,'<script>')===false && strpos($html,'&lt;img')!==false, 'Preview XSS');
$connection->query("INSERT INTO adjustment_stock (id_transaksi,adjustment,status_jurnal,tanggal_transaksi) VALUES ('MUT','MUTASI','OPN',CURDATE()),('CLOSED','PLUS','CLS',CURDATE()),('SECOND','MINUS',NULL,CURDATE())");
$input->verb='GET'; $input->values=array('start'=>0,'length'=>1,'draw'=>3,'search'=>array('value'=>''));
$list=json_decode(journalCall('get_dataa_adjustment'),true);
journalCheck($list['recordsTotal']===2 && $list['recordsFiltered']===2 && count($list['data'])===1 && $list['draw']===3, 'List counts or paging wrong');
$input->values['length']=-1; $input->values['search']['value']='ADJ-TEST';
$list=json_decode(journalCall('get_dataa_adjustment'),true);
journalCheck($list['recordsTotal']===2 && $list['recordsFiltered']===1 && count($list['data'])===1, 'Filtered counts contaminated');
journalCheck(strpos($list['data'][0]['keterangan'],'<img')===false, 'List XSS');
$input->values['search']['value']='%';
journalCheck(json_decode(journalCall('get_dataa_adjustment'),true)['recordsFiltered']===0, 'Search wildcard not escaped');
$denied=array('Jurnal_Adjustment.Manage'); $input->values['search']['value']='';
$list=json_decode(journalCall('get_dataa_adjustment'),true);
journalCheck($list['data'][0]['action']==='', 'Manage action exposed');
journalReset();
$connection->query("UPDATE adjustment_stock SET id_transaksi='A\" autofocus=\"x'");
$input->verb='GET'; $input->values=array('id_transaksi'=>'A" autofocus="x');
$html=journalCall('process_jurnal');
journalCheck(strpos($html,'value="A" autofocus=')===false && strpos($html,'&quot; autofocus=')!==false, 'ID attribute XSS');
$input->values=array('start'=>0,'length'=>10);
$list=json_decode(journalCall('get_dataa_adjustment'),true);
journalCheck(strpos($list['data'][0]['action'],'data-id_transaksi="A" autofocus=')===false, 'Action attribute XSS');
echo "jurnal_adjustment: $checks checks passed\n";
