<?php
// PRICE_LIST_TEST_DB=1 php -d extension=mysqli tests/product_costing_pricelist_test.php
if (PHP_SAPI !== 'cli' || getenv('PRICE_LIST_TEST_DB') !== '1') { exit("Set PRICE_LIST_TEST_DB=1 for isolated localhost checks.\n"); }
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
$connection = new mysqli('127.0.0.1', $config['username'], $config['password'], 'waterco_demo', 3306);
$connection->set_charset('utf8mb4');
$connection->query("SET SESSION sql_mode='STRICT_ALL_TABLES,NO_ENGINE_SUBSTITUTION'");
foreach (array('ms_product_pricelist','ms_product_pricelist_detail') as $table) {
    $ddl = $connection->query('SHOW CREATE TABLE ' . $table)->fetch_row()[1];
    if (strpos($ddl, 'ENGINE=InnoDB') === false) { throw new RuntimeException('Transactional table required: ' . $table); }
    $connection->query(preg_replace('/^CREATE TABLE /', 'CREATE TEMPORARY TABLE ', $ddl));
}
// All writes use connection-local shadow tables; operational data remains untouched.
function is_php($version) { return version_compare(PHP_VERSION, $version, '>='); }
function log_message($level, $message) { $GLOBALS['priceLogs'][] = $message; }
require BASEPATH . 'database/DB_driver.php';
require BASEPATH . 'database/DB_query_builder.php';
class CI_DB extends CI_DB_query_builder {}
require BASEPATH . 'database/drivers/mysqli/mysqli_driver.php';
class PriceTestDb extends CI_DB_mysqli_driver
{
    public $failAt = '', $failCommit = false, $failBegin = false, $throwQuery = false;
    protected function _execute($sql) {
        if ($this->failAt !== '' && strpos($sql, $this->failAt) === 0) {
            if ($this->throwQuery) { throw new RuntimeException('Injected query exception'); }
            return false;
        }
        return parent::_execute($sql);
    }
    protected function _trans_commit() { return $this->failCommit ? false : parent::_trans_commit(); }
    protected function _trans_begin() { return $this->failBegin ? false : parent::_trans_begin(); }
}
class Admin_Controller { public $db, $auth, $input; }
require dirname(__DIR__) . '/application/modules/ms_product_costing/controllers/Ms_product_costing.php';
class PriceTestServices
{
    public $values, $permission, $denied = false;
    public function post() { return $this->values; }
    public function user_id() { return 'price-test'; }
    public function restrict($permission) { $this->permission = $permission; if ($this->denied) { throw new DomainException('Denied'); } }
}
function priceCheck($ok, $message) { ++$GLOBALS['checks']; if (!$ok) { throw new RuntimeException($message); } }
function priceSnapshot() {
    $result = array();
    foreach (array('ms_product_pricelist','ms_product_pricelist_detail') as $table) { $result[$table] = $GLOBALS['connection']->query('SELECT * FROM ' . $table)->fetch_all(MYSQLI_ASSOC); }
    return $result;
}
function pricePost() {
    $post = array('id_product_pricelist'=>'77','inventory_1'=>'TYPE1','inventory_2'=>'CAT1','inventory_3'=>'CAT2',
        'inventory_4'=>'ITEM1','id_material'=>'FORM1','harga_beli'=>'1,000.25','total_price'=>'1,500.50','kurs'=>'15,000','total_price_rp'=>'22,507,500');
    foreach (array('bm','lc','oc','margin','dd','da','de','aj') as $index=>$suffix) {
        $post['dt'][1]['komponen_'.$suffix] = (string)($index+1);
        $post['dt'][1]['persentase_'.$suffix] = $suffix === 'aj' ? '-2.5' : '0';
        $post['dt'][1]['nilai_'.$suffix] = '1,200.50';
        $post['dt'][1]['nilai_'.$suffix.'_rp'] = '18,007,500';
        $post['dt'][1]['keterangan_'.$suffix] = "Supplier's note";
    }
    return $post;
}
function priceRun($post, $failure = '', $throw = false) {
    global $connection, $services, $testDb;
    $connection->query('DELETE FROM ms_product_pricelist_detail'); $connection->query('DELETE FROM ms_product_pricelist');
    $connection->query("INSERT INTO ms_product_pricelist(id_product_pricelist,nama_category2,harga_beli,total_pricelist,revisi) VALUES (77,'Keep category',10,20,3)");
    $connection->query("INSERT INTO ms_product_pricelist_detail(id_product_pricelist,nama_komponen,nilai_costing) VALUES (77,1,10)");
    $before = priceSnapshot(); $GLOBALS['priceLogs'] = array();
    $testDb = new PriceTestDb(array('conn_id'=>$connection,'database'=>'waterco_demo','db_debug'=>true,'char_set'=>'utf8mb4','save_queries'=>false));
    $testDb->failAt = $failure; $testDb->failCommit = $failure === 'commit'; $testDb->failBegin = $failure === 'begin'; $testDb->throwQuery = $throw;
    $services = new PriceTestServices(); $services->values = $post;
    $controller = (new ReflectionClass('Ms_product_costing'))->newInstanceWithoutConstructor();
    $controller->db = $testDb; $controller->auth = $controller->input = $services;
    $_POST = $post;
    ob_start();
    try { $controller->SaveEditPricelist(); $body = ob_get_contents(); } finally { ob_end_clean(); }
    $result = json_decode($body, true, 512, JSON_THROW_ON_ERROR);
    priceCheck($testDb->db_debug === true, 'Database debug flag not restored');
    priceCheck($services->permission === 'Formula.Manage', 'Edit must require Manage permission');
    if ($result['status'] === 0) { priceCheck(priceSnapshot() === $before, 'Rejected save changed old prices/details'); }
    foreach ($GLOBALS['priceLogs'] as $log) { if (strpos($log,'ErrorException') !== false || strpos($log,'Undefined constant') !== false) { throw new RuntimeException($log); } }
    return $result;
}
$checks = 0;
try {
    $result = priceRun(pricePost());
    priceCheck($result['status'] === 1 && (string)$result['code'] === '77', 'Valid edit failed');
    $saved = priceSnapshot(); $header = $saved['ms_product_pricelist'][0]; $details = $saved['ms_product_pricelist_detail'];
    priceCheck((float)$header['harga_beli'] === 1000.25 && (float)$header['harga_rupiah'] === 22507500.0, 'Formatted amounts not saved');
    priceCheck($header['nama_category2'] === 'Keep category' && (int)$header['revisi'] === 3, 'Edit cleared category/revision');
    priceCheck(count($details) === 8 && array_map('intval',array_column($details,'nama_komponen')) === range(1,8), 'Eight costing components not preserved');
    priceCheck((float)$details[7]['persentase'] === -2.5 && $details[0]['keterangan'] === "Supplier's note", 'Adjustment/notes changed');
    $post = pricePost(); $post['dt'] = array(array_intersect_key($post['dt'][1],array_flip(array('komponen_bm','persentase_bm','nilai_bm','nilai_bm_rp'))));
    priceCheck(priceRun($post)['status'] === 1 && count(priceSnapshot()['ms_product_pricelist_detail']) === 1, 'Sparse components/optional notes failed');
    foreach (array('UPDATE `ms_product_pricelist`','DELETE FROM `ms_product_pricelist_detail`','INSERT INTO `ms_product_pricelist_detail`','commit','begin') as $failure) {
        priceCheck(priceRun(pricePost(),$failure)['status'] === 0, 'Injected failure reported success: '.$failure);
    }
    priceCheck(priceRun(pricePost(),'INSERT INTO `ms_product_pricelist_detail`',true)['status'] === 0,'Thrown database error reported success');
    foreach (array('id_product_pricelist','harga_beli','kurs','dt') as $field) {
        $post = pricePost(); unset($post[$field]); priceCheck(priceRun($post)['status'] === 0,'Missing field accepted: '.$field);
    }
    foreach (array('1,23.45','NaN','INF',array(10),'-1') as $invalid) {
        $post=pricePost(); $post['harga_beli']=$invalid; priceCheck(priceRun($post)['status'] === 0,'Invalid price accepted');
    }
    $post=pricePost(); $post['id_product_pricelist']='999'; priceCheck(priceRun($post)['status'] === 0,'Unknown pricelist accepted');
    $post=pricePost(); $post['dt']=array(); priceCheck(priceRun($post)['status'] === 0,'Empty details accepted');
    $post=pricePost(); $post['dt'][]=$post['dt'][1]; priceCheck(priceRun($post)['status'] === 0,'Duplicate components accepted');
    $post=pricePost(); $post['dt'][1]['komponen_bm']='2'; priceCheck(priceRun($post)['status'] === 0,'Wrong component accepted');
    $post=pricePost(); $post['dt'][1]['nilai_lc']=array(1); priceCheck(priceRun($post)['status'] === 0,'Nested component amount accepted');
    echo "PASS: $checks Product Costing Price List checks (localhost temporary tables only)\n";
} finally { $connection->rollback(); $connection->close(); }
