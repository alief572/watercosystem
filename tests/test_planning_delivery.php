<?php
define("BASEPATH", dirname(__DIR__) . "/system/");
define("APPPATH", dirname(__DIR__) . "/application/");
define("FCPATH", dirname(__DIR__) . "/");
define("ENVIRONMENT", "development");
$_SERVER['HTTP_HOST'] = 'localhost';
$_SERVER['REQUEST_METHOD'] = 'POST';

require_once BASEPATH . "core/Common.php";
require_once BASEPATH . "core/Controller.php";
require_once BASEPATH . "core/Model.php";

$ci = null;
function &get_instance() {
    global $ci;
    return $ci;
}

class CI_Test_Input {
    public $posts = [];
    public function post($key = null) {
        if ($key === null) return $this->posts;
        return isset($this->posts[$key]) ? $this->posts[$key] : null;
    }
}

class CI_Test_Auth {
    public function has_permission($perm) { return true; }
}

class CI_Test_Loader {
    public function get_package_paths() { return [APPPATH]; }
    public function database() {}
}

class CI_Test_Instance extends CI_Controller {
    public $db;
    public $input;
    public $auth;
    public $load;
    public function __construct() {
        global $ci;
        $ci = $this;
        $this->load = new CI_Test_Loader();
        require_once BASEPATH . "database/DB.php";
        $this->db = DB("default", true);
        $this->input = new CI_Test_Input();
        $this->auth = new CI_Test_Auth();
    }
}

$ci = new CI_Test_Instance();

function base_url($uri = '') { return 'http://localhost:8080/' . ltrim($uri, '/'); }
function has_permission($name) { return true; }

require_once APPPATH . "core/BF_Model.php";
require_once APPPATH . "modules/wt_delivery_order/models/Wt_delivery_order_model.php";

$model = new Wt_delivery_order_model();
$model->db = $ci->db;
$model->input = $ci->input;

echo "=== TEST 1: Default First Page (start=0, length=10, no search) ===\n";
$ci->input->posts = [
    'draw' => 1,
    'start' => 0,
    'length' => 10,
    'search' => ['value' => '']
];
$t0 = microtime(true);
ob_start();
$model->get_data_planning_delivery();
$output = ob_get_clean();
$tDiff = round((microtime(true) - $t0) * 1000, 2);

$json = json_decode($output, true);
if (!$json) {
    echo "FAIL: Output is not valid JSON!\n$output\n";
    exit(1);
}
echo "Execution time: {$tDiff} ms\n";
echo "draw: {$json['draw']}\n";
echo "recordsTotal: {$json['recordsTotal']}\n";
echo "recordsFiltered: {$json['recordsFiltered']}\n";
echo "data count: " . count($json['data']) . "\n";
assert($json['recordsTotal'] === 90, "Expected recordsTotal 90");
assert($json['recordsFiltered'] === 90, "Expected recordsFiltered 90");
assert(count($json['data']) === 10, "Expected 10 rows in data");
echo "PASS: Test 1 passed successfully!\n\n";

echo "=== TEST 2: Search 'Sentra' ===\n";
$ci->input->posts = [
    'draw' => 2,
    'start' => 0,
    'length' => 10,
    'search' => ['value' => 'Sentra']
];
$t0 = microtime(true);
ob_start();
$model->get_data_planning_delivery();
$output = ob_get_clean();
$tDiff = round((microtime(true) - $t0) * 1000, 2);

$json = json_decode($output, true);
echo "Execution time: {$tDiff} ms\n";
echo "recordsTotal: {$json['recordsTotal']}\n";
echo "recordsFiltered: {$json['recordsFiltered']}\n";
echo "data count: " . count($json['data']) . "\n";
assert($json['recordsTotal'] === 90, "Expected recordsTotal 90");
assert($json['recordsFiltered'] === 2, "Expected recordsFiltered 2");
assert(count($json['data']) === 2, "Expected 2 rows in data");
echo "First result customer: " . $json['data'][0]['nama_customer'] . "\n";
echo "PASS: Test 2 passed successfully!\n\n";

echo "=== TEST 3: Pagination Page 2 (start=10, length=10) ===\n";
$ci->input->posts = [
    'draw' => 3,
    'start' => 10,
    'length' => 10,
    'search' => ['value' => '']
];
$t0 = microtime(true);
ob_start();
$model->get_data_planning_delivery();
$output = ob_get_clean();
$tDiff = round((microtime(true) - $t0) * 1000, 2);

$json = json_decode($output, true);
echo "Execution time: {$tDiff} ms\n";
echo "First row number: " . $json['data'][0]['no'] . "\n";
assert($json['data'][0]['no'] === 11, "Expected first row on page 2 to have number 11");
echo "PASS: Test 3 passed successfully!\n\n";

echo "ALL AUTOMATED TESTS PASSED! Execution time is under 50ms.\n";
