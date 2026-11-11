<?php
// Run: docker exec waterco_web85 php tests/master_suplier_test.php
if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }
error_reporting(E_ALL);
$_SERVER['HTTP_HOST'] = 'localhost';
define('BASEPATH', dirname(__DIR__) . '/system/');
define('FCPATH', dirname(__DIR__) . '/');
define('APPPATH', dirname(__DIR__) . '/application/');
define('ENVIRONMENT', 'development');
function log_message($level, $message) {}
function show_error($message, $code = 500) { throw new RuntimeException((string) $message, $code); }
function show_404() { throw new RuntimeException('Not found', 404); }
function base_url($path = '') { return '/' . $path; }
function has_permission($permission) {
    global $fixture;
    return $fixture->allowed === null || in_array($permission, $fixture->allowed, true);
}
require BASEPATH . 'core/Common.php';
require BASEPATH . 'helpers/form_helper.php';
require BASEPATH . 'database/DB.php';
class BF_Model { public $db; public function __construct() {} }
class Admin_Controller { public $db, $auth, $input, $session, $template, $Suplier_model, $uri, $Inventory_2_model; }
require APPPATH . 'modules/master_suplier/models/Suplier_model.php';
require APPPATH . 'modules/master_suplier/controllers/Master_suplier.php';
class Supplier_fixture
{
    public $allowed = null, $permission, $results = array(), $uri;
    public function __construct() { $this->uri = $this; }
    public function restrict($permission) {
        $this->permission = $permission;
        if ($this->allowed !== null && !in_array($permission, $this->allowed, true)) { throw new RuntimeException('Denied', 403); }
    }
    public function user_id() { return 1; }
    public function userdata($key) { return array('id_user' => 1); }
    public function post($key = null) { return $key === null ? $_POST : ($_POST[$key] ?? null); }
    public function get($key) { return $_GET[$key] ?? null; }
    public function segment($index) { return 'master_suplier'; }
    public function title($text) {}
    public function page_icon($icon) {}
    public function set($key, $value) { $this->$key = $value; }
    public function render($view) {
        $results = $this->results;
        require APPPATH . 'modules/master_suplier/views/' . $view . '.php';
    }
}
function supplier_check($condition, $message) { if (!$condition) { throw new RuntimeException($message); } }
function supplier_call($method, $post = array(), $args = array()) {
    global $controller, $fixture;
    $_POST = $post; $fixture->results = array();
    ob_start();
    try { $controller->$method(...$args); return ob_get_contents(); }
    finally { ob_end_clean(); }
}
function supplier_json($method, $post, $expected = 1) {
    $json = json_decode(supplier_call($method, $post), true, 512, JSON_THROW_ON_ERROR);
    supplier_check(isset($json['status'], $json['pesan']) && $json['status'] === $expected, $method . ': unexpected response');
    return $json;
}
function supplier_post($location = 'local', $pics = 1) {
    $post = array_fill_keys(array('telephone', 'telephone_2', 'fax', 'international_prov', 'international_kota', 'zip_code', 'longitude', 'latitude', 'name_bank', 'no_rekening', 'nama_rekening', 'alamat_bank', 'swift_code', 'npwp', 'npwp_name', 'npwp_address'), '');
    $post += array('name_suplier' => 'Supplier test', 'id_category_supplier' => 'CS2600001', 'moq' => '1', 'email' => 'supplier@example.test', 'start_date' => '2026-11-11', 'id_prov' => '10', 'id_kota' => '101', 'id_negara' => 'ID', 'address_office' => 'Test address', 'activation' => 'aktif', 'payment_term' => 'LC', 'data1' => array());
    for ($i = 0; $i < $pics; $i++) { $post['data1'][] = array('name_pic' => 'PIC ' . $i, 'phone_pic' => '123', 'email_pic' => 'pic@example.test', 'position_pic' => 'Sales'); }
    return $post;
}
function supplier_seed($id = 'LS2600001', $location = 'local') {
    global $connection;
    $post = supplier_post($location, 0); unset($post['data1']);
    $post += array('id_suplier' => $id, 'suplier_location' => $location, 'deleted' => 0);
    supplier_check($connection->insert('master_supplier', $post), 'Seed supplier');
    return $post;
}
require APPPATH . 'config/development/database.php';
$config = $db['default'];
$sourceConfig = $config;
supplier_check($config['hostname'] === 'db' && $config['database'] === 'waterco_demo', 'Refuse non-local source');
$schema = 'waterco_demo_test_master_suplier';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$admin = new mysqli($config['hostname'], $config['username'], $config['password'], 'waterco_demo', (int) $config['port']);
// No IF NOT EXISTS: never reuse or delete an existing database.
$admin->query('CREATE DATABASE `' . $schema . '` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
$failed = 0; $passed = 0;
try {
    $tables = array('master_supplier', 'child_supplier_pic', 'child_supplier_category', 'provinsi', 'kota', 'negara', 'ms_inventory_category1', 'ms_inventory_type', 'ms_compotition', 'ms_dimensi');
    foreach ($tables as $table) { $admin->query("CREATE TABLE `$schema`.`$table` LIKE `waterco_demo`.`$table`"); }
    $config['database'] = $schema; $config['db_debug'] = false; $config['stricton'] = true;
    $connection = DB($config, true);
    supplier_check($connection->query('SELECT DATABASE() AS name')->row()->name === $schema, 'Refuse writes outside test schema');
    $model = new Suplier_model(); $model->db = $connection;
    $controller = (new ReflectionClass('Master_suplier'))->newInstanceWithoutConstructor();
    $fixture = new Supplier_fixture();
    $controller->db = $connection; $controller->Suplier_model = $model;
    foreach (array('auth', 'input', 'session', 'template', 'uri') as $property) { $controller->$property = $fixture; }
    set_error_handler(function ($severity, $message, $file, $line) {
        if (error_reporting() & $severity) { throw new ErrorException($message, 0, $severity, $file, $line); }
        return false;
    });
    function supplier_test($name, $run) {
        global $connection, $fixture, $tables, $failed, $passed, $argv;
        if (isset($argv[1]) && strpos($name, $argv[1]) === false) { return; }
        $fixture->allowed = null; $connection->reset_query();
        foreach ($tables as $table) { $connection->query('DELETE FROM `' . $table . '`'); }
        $connection->insert('child_supplier_category', array('id_category_supplier' => 'CS2600001', 'name_category_supplier' => 'Test category', 'supplier_code' => '', 'activation' => 'active'));
        $connection->insert('negara', array('id_negara' => 'ID', 'nm_negara' => 'Indonesia'));
        $connection->insert('provinsi', array('id_prov' => 10, 'id_negara' => 'ID', 'nama' => 'Test province'));
        $connection->insert('kota', array('id_kota' => 101, 'id_prov' => 10, 'nama_kota' => 'Test city'));
        try { $run(); $passed++; echo "PASS: $name\n"; }
        catch (Throwable $e) { $failed++; echo "FAIL: $name: " . $e->getMessage() . "\n"; }
        finally { while ($connection->trans_active()) { $connection->trans_rollback(); } }
    }
    foreach (array('index', 'addLocal', 'addInternational', 'addCategory') as $method) {
        supplier_test('render ' . $method, function () use ($method) { supplier_check(strlen(supplier_call($method)) > 0, 'Empty view'); });
    }
    foreach (array('EditLokal', 'viewLokal', 'EditInternasional', 'ViewInternasional', 'EditCategory', 'ViewCategory') as $method) {
        supplier_test('render ' . $method, function () use ($method) {
            supplier_seed();
            $id = strpos($method, 'Category') !== false ? 'CS2600001' : 'LS2600001';
            supplier_check(strlen(supplier_call($method, array(), array($id))) > 0, 'Empty view');
        });
        supplier_test('missing ID ' . $method, function () use ($method) {
            try { supplier_call($method, array(), array('missing')); throw new RuntimeException('Missing record accepted'); }
            catch (RuntimeException $e) { if ($e->getCode() !== 404) { throw $e; } }
        });
    }
    foreach (array('Local' => 'local', 'International' => 'international') as $suffix => $location) {
        foreach (array(0, 1, 2) as $count) {
            supplier_test("saveNew$suffix PIC=$count", function () use ($suffix, $location, $count) {
                global $connection;
                $post = supplier_post($location, $count);
                if ($count === 0) { unset($post['data1']); }
                supplier_json('saveNew' . $suffix, $post);
                supplier_check($connection->count_all('master_supplier') === 1 && $connection->count_all('child_supplier_pic') === $count, 'Supplier/PIC count mismatch');
            });
        }
        supplier_test("saveEdit$suffix replaces PIC and preserves audit", function () use ($suffix, $location) {
            global $connection;
            supplier_seed('LS2600001', $location);
            $connection->where('id_suplier', 'LS2600001')->update('master_supplier', array('created_on' => '2020-01-01 00:00:00', 'created_by' => 'original'));
            $connection->insert('child_supplier_pic', array('id_suplier' => 'LS2600001', 'name_pic' => 'old'));
            $post = supplier_post($location, 2); $post['id_suplier'] = 'LS2600001';
            supplier_json('saveEdit' . $suffix, $post);
            $row = $connection->get('master_supplier')->row();
            supplier_check($row->created_by === 'original' && $row->created_on === '2020-01-01 00:00:00.000000' && $row->modified_by === '1', 'Creation audit overwritten or modification audit missing');
            supplier_check($connection->count_all('child_supplier_pic') === 2, 'PIC replacement mismatch');
        });
        supplier_test("saveEdit$suffix removes all PIC", function () use ($suffix, $location) {
            global $connection;
            supplier_seed('LS2600001', $location);
            $connection->insert('child_supplier_pic', array('id_suplier' => 'LS2600001', 'name_pic' => 'old'));
            $post = supplier_post($location, 0); $post['id_suplier'] = 'LS2600001'; unset($post['data1']);
            supplier_json('saveEdit' . $suffix, $post);
            supplier_check($connection->count_all('child_supplier_pic') === 0, 'Old PIC retained');
        });
        foreach (array('New', 'Edit') as $action) {
            supplier_test("invalid input save$action$suffix", function () use ($action, $suffix) {
                global $connection;
                supplier_json('save' . $action . $suffix, array(), 0);
                supplier_check($connection->count_all('master_supplier') === 0, 'Invalid input wrote supplier');
            });
        }
    }
    supplier_test('category create edit delete', function () {
        global $connection;
        supplier_json('saveNewCategory', array('name_category_supplier' => 'New category', 'supplier_code' => ''));
        $id = $connection->order_by('id_category_supplier', 'desc')->get('child_supplier_category')->row()->id_category_supplier;
        supplier_json('saveEditCategory', array('id_category_supplier' => $id, 'name_category_supplier' => 'Edited', 'supplier_code' => ''));
        supplier_json('deleteCategory', array('id' => $id));
        supplier_check($connection->get_where('child_supplier_category', array('id_category_supplier' => $id))->row()->activation === 'inactive', 'Category was not soft deleted');
    });
    foreach (array('deletelokal' => 'local', 'deleteinternational' => 'international') as $method => $location) {
        supplier_test($method, function () use ($method, $location) {
            global $connection;
            supplier_seed('LS2600001', $location); supplier_json($method, array('id' => 'LS2600001'));
            supplier_check($connection->get('master_supplier')->row()->deleted === '1', 'Supplier was not soft deleted');
        });
    }
    supplier_test('getkota uses city ID and empty lookup', function () {
        $_GET = array('id_prov' => '10');
        supplier_check(strpos(supplier_call('getkota'), "value='101'") !== false, 'City option uses wrong ID');
        $_GET = array(); supplier_call('getkota');
    });
    supplier_test('model empty ID generators', function () {
        global $model, $connection;
        $connection->query('DELETE FROM child_supplier_category');
        foreach (array('generate_id' => 'LS', 'generate_idint' => 'IS', 'generate_Category' => 'CS') as $method => $prefix) {
            supplier_check($model->$method() === $prefix . date('y') . '00001', 'Incorrect first ID');
        }
    });
    supplier_test('model lists filter location deletion and null relations', function () {
        global $model, $connection;
        supplier_seed(); supplier_seed('IS2600001', 'international'); supplier_seed('LS2600002');
        $connection->where('id_suplier', 'LS2600002')->update('master_supplier', array('deleted' => 1));
        supplier_check(count($model->getlokal()) === 1 && count($model->getinternational()) === 1, 'Deleted or wrong location visible');
        $connection->where('id_suplier', 'LS2600001')->update('master_supplier', array('id_category_supplier' => null));
        supplier_check(count($model->getlokal()) === 1, 'Supplier disappears without category');
        supplier_check(count($model->carikota(10)) === 1 && count($model->carikota(999)) === 0, 'Incorrect city filter');
    });
    foreach (array('Local' => 'local', 'International' => 'international') as $suffix => $location) {
        foreach (array('New', 'Edit') as $action) {
            supplier_test("rollback save$action$suffix after PIC failure", function () use ($action, $suffix, $location) {
                global $connection;
                if ($action === 'Edit') {
                    supplier_seed('LS2600001', $location);
                    $connection->insert('child_supplier_pic', array('id_suplier' => 'LS2600001', 'name_pic' => 'Original PIC'));
                }
                $before = $connection->get('master_supplier')->result_array();
                $beforePics = $connection->get('child_supplier_pic')->result_array();
                $connection->query("CREATE TRIGGER supplier_pic_failure BEFORE INSERT ON child_supplier_pic FOR EACH ROW BEGIN IF NEW.name_pic='FAIL' THEN SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT='Test PIC failure'; END IF; END");
                $connection->db_debug = true;
                try {
                    $post = supplier_post($location, 2); $post['id_suplier'] = 'LS2600001';
                    $post['name_suplier'] = 'Changed'; $post['data1'][1]['name_pic'] = 'FAIL';
                    supplier_json('save' . $action . $suffix, $post, 0);
                    supplier_check($connection->get('master_supplier')->result_array() === $before, 'Supplier partially changed');
                    supplier_check($connection->get('child_supplier_pic')->result_array() === $beforePics, 'PIC partially changed');
                    supplier_check(!$connection->trans_active() && $connection->db_debug, 'Transaction/debug not restored');
                } finally { $connection->query('DROP TRIGGER supplier_pic_failure'); $connection->db_debug = false; }
            });
        }
        foreach (array('email' => 'bad-email', 'start_date' => '2026-02-30', 'moq' => '-1', 'activation' => 'invalid', 'name_suplier' => array('bad'), 'telephone' => '123456789012345678901', 'data1' => 'bad') as $field => $value) {
            supplier_test("invalid $field saveNew$suffix", function () use ($suffix, $location, $field, $value) {
                global $connection;
                $post = supplier_post($location); $post[$field] = $value;
                supplier_json('saveNew' . $suffix, $post, 0);
                supplier_check($connection->count_all('master_supplier') === 0, 'Invalid input was written');
            });
        }
        supplier_test("wrong location saveEdit$suffix", function () use ($suffix, $location) {
            supplier_seed('LS2600001', $location === 'local' ? 'international' : 'local');
            $post = supplier_post($location); $post['id_suplier'] = 'LS2600001';
            supplier_json('saveEdit' . $suffix, $post, 0);
        });
    }
    foreach (array('saveNewCategory', 'saveEditCategory', 'deleteCategory', 'deletelokal', 'deleteinternational') as $method) {
        supplier_test('invalid input ' . $method, function () use ($method) { supplier_json($method, array(), 0); });
    }
    foreach (array('deletelokal' => 'international', 'deleteinternational' => 'local') as $method => $location) {
        supplier_test('wrong location ' . $method, function () use ($method, $location) {
            supplier_seed('LS2600001', $location);
            supplier_json($method, array('id' => 'LS2600001'), 0);
        });
    }
    supplier_test('model populated ID generators and zero filter', function () {
        global $model;
        supplier_seed('LS2600042'); supplier_seed('IS2600012', 'international');
        supplier_check($model->generate_id() === 'LS' . date('y') . '00043', 'Local sequence');
        supplier_check($model->generate_idint() === 'IS' . date('y') . '00013', 'International sequence');
        supplier_check($model->generate_Category() === 'CS' . date('y') . '00002', 'Category sequence');
        supplier_check(count($model->get_data('master_supplier', 'deleted', 0)) === 2, 'Zero filter lost');
    });
    foreach (array('EditLokal', 'viewLokal', 'EditInternasional', 'ViewInternasional') as $method) {
        supplier_test('escape supplier and PIC ' . $method, function () use ($method) {
            global $connection;
            supplier_seed();
            $name = "O'Neil & <script>alert(1)</script>";
            $connection->where('id_suplier', 'LS2600001')->update('master_supplier', array('name_suplier' => $name));
            $connection->insert('child_supplier_pic', array('id_suplier' => 'LS2600001', 'name_pic' => $name));
            $html = supplier_call($method, array(), array('LS2600001'));
            supplier_check(strpos($html, '<script>alert(1)</script>') === false, 'Unescaped stored HTML');
            $dom = new DOMDocument(); $dom->loadHTML($html, LIBXML_NOERROR | LIBXML_NOWARNING);
            $xpath = new DOMXPath($dom);
            supplier_check($xpath->query('//input[@name="name_suplier"]')->item(0)->getAttribute('value') === $name, 'Supplier name corrupted');
            supplier_check($xpath->query('//input[@name="data1[1][name_pic]"]')->item(0)->getAttribute('value') === $name, 'PIC name corrupted');
        });
    }
    supplier_test('render nullable reference names and populated index', function () {
        global $connection;
        supplier_seed(); supplier_seed('IS2600001', 'international');
        $connection->where('id_category_supplier', 'CS2600001')->update('child_supplier_category', array('name_category_supplier' => null));
        foreach (array('index', 'addLocal', 'addInternational') as $method) { supplier_call($method); }
    });
    supplier_test('legacy inventory functions and model helpers', function () {
        global $connection, $model;
        $connection->insert('ms_inventory_type', array('id_type' => 'T1', 'nama' => 'Test type', 'deleted' => 0));
        supplier_json('saveNewinventoryold', array('inventory_1' => 'T1', 'nm_inventory' => 'Test inventory'));
        $id = $connection->get('ms_inventory_category1')->row()->id_category1;
        supplier_check(count($model->get_data_category1()) === 1 && $model->getById($id)['nama'] === 'Test inventory', 'Inventory model helpers');
        supplier_call('viewInventory', array('id' => $id));
        supplier_json('saveEditinventory', array('hd1' => array(1 => array('id_inventory' => $id, 'inventory_1' => 'T1', 'nm_inventory' => 'Edited inventory')), 'data1' => array(array('name_compotition' => 'Test composition')), 'data2' => array()));
        $comp = $connection->get('ms_compotition')->row()->id_compotition;
        supplier_json('saveEditinventory', array('hd1' => array(1 => array('id_inventory' => $id, 'inventory_1' => 'T1', 'nm_inventory' => 'Edited inventory')), 'data2' => array(array('id_compotition' => $comp, 'name_compotition' => 'Changed composition'))));
        supplier_json('delDetail', array('id' => $comp));
        supplier_check($connection->get('ms_compotition')->row()->deleted === '1', 'Legacy detail delete');
        $connection->insert('ms_dimensi', array('id_bentuk' => 'B1', 'nm_dimensi' => 'Test dimension', 'deleted' => 0));
        supplier_check(count($model->getDimensi('B1')) === 1 && count($model->getDimensi("B1' OR 1=1 -- ")) === 0, 'Dimension query must bind ID');
    });
    supplier_test('view-only index hides add buttons and preserves columns', function () {
        global $fixture;
        supplier_seed();
        $fixture->allowed = array('Master_Supplier.View');
        $html = supplier_call('index');
        foreach (array('add_local', 'add_international', 'add_category', 'edit_local', 'delete_local') as $class) {
            supplier_check(strpos($html, ' ' . $class . '"') === false, 'Unauthorized control: ' . $class);
        }
        $dom = new DOMDocument(); $dom->loadHTML($html, LIBXML_NOERROR | LIBXML_NOWARNING);
        $xpath = new DOMXPath($dom);
        foreach ($xpath->query('//table') as $table) {
            $cells = $xpath->query('./tbody/tr[1]/td', $table);
            if ($cells->length) { supplier_check($xpath->query('./thead/tr/th', $table)->length === $cells->length, 'Action column/header mismatch'); }
        }
    });
    supplier_test('invalid date with embedded null', function () {
        $post = supplier_post(); $post['start_date'] = "2026\0-1";
        supplier_json('saveNewLocal', $post, 0);
    });
    supplier_test('failed transaction start never writes supplier', function () use ($config) {
        global $controller, $connection;
        class Supplier_begin_failure extends CI_DB_mysqli_driver { public function trans_begin($test_mode = false) { return false; } }
        $failing = new Supplier_begin_failure($config); $failing->initialize();
        $controller->db = $failing;
        try {
            supplier_json('saveNewLocal', supplier_post(), 0);
            supplier_check($connection->count_all('master_supplier') === 0 && $connection->count_all('child_supplier_pic') === 0, 'Writes happened outside transaction');
        } finally { $controller->db = $connection; $failing->close(); }
    });
    supplier_test('read-only source schema and existing modal data', function () use ($sourceConfig) {
        global $connection, $controller, $model;
        $read = DB($sourceConfig, true);
        $read->query('SET SESSION TRANSACTION READ ONLY');
        $controller->db = $model->db = $read;
        try {
            foreach (array('index', 'addLocal', 'addInternational', 'addCategory') as $method) { supplier_call($method); }
            foreach (array('getlokal' => array('EditLokal', 'viewLokal'), 'getinternational' => array('EditInternasional', 'ViewInternasional')) as $getter => $methods) {
                $rows = $model->$getter();
                if ($rows) { foreach ($methods as $method) { supplier_call($method, array(), array($rows[0]->id_suplier)); } }
            }
            $categories = $model->get_data('child_supplier_category', 'activation', 'active');
            if ($categories) { foreach (array('EditCategory', 'ViewCategory') as $method) { supplier_call($method, array(), array($categories[0]->id_category_supplier)); } }
        } finally { $controller->db = $model->db = $connection; $read->close(); }
    });
    $permissions = array('index' => 'View', 'addLocal' => 'Add', 'addInternational' => 'Add', 'addCategory' => 'Add', 'EditLokal' => 'Manage', 'EditInternasional' => 'Manage', 'EditCategory' => 'Manage', 'viewLokal' => 'View', 'ViewInternasional' => 'View', 'ViewCategory' => 'View', 'saveNewLocal' => 'Add', 'saveNewInternational' => 'Add', 'saveNewCategory' => 'Add', 'saveEditLocal' => 'Manage', 'saveEditInternational' => 'Manage', 'saveEditCategory' => 'Manage', 'deletelokal' => 'Delete', 'deleteinternational' => 'Delete', 'deleteCategory' => 'Delete', 'getkota' => 'View');
    foreach ($permissions as $method => $permission) {
        supplier_test('permission ' . $method, function () use ($method, $permission) {
            global $fixture;
            $fixture->allowed = array();
            try { supplier_call($method, array(), array('missing')); throw new RuntimeException('Access allowed'); }
            catch (RuntimeException $e) { supplier_check($e->getCode() === 403, 'Expected access denial'); }
            supplier_check($fixture->permission === 'Master_Supplier.' . $permission, 'Wrong permission: ' . $fixture->permission);
        });
    }
    echo "$passed passed; $failed failed\n";
} finally {
    restore_error_handler();
    if (isset($connection)) { $connection->close(); }
    $admin->query('DROP DATABASE `' . $schema . '`');
    $admin->close();
}
exit($failed ? 1 : 0);
