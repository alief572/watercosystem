<?php
// Run: docker exec waterco_web85 php tests/quotation_approval_view_test.php
if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }
error_reporting(E_ALL);
define('BASEPATH', dirname(__DIR__) . '/system/');
define('APPPATH', dirname(__DIR__) . '/application/');
define('FCPATH', dirname(__DIR__) . '/');
define('ENVIRONMENT', 'development');
$_SERVER['HTTP_HOST'] = 'localhost';
function log_message($level, $message) {}
function show_error($message, $code = 500) { throw new RuntimeException((string) $message, $code); }
function base_url($path = '') { return '/' . ltrim($path, '/'); }
function has_permission($permission) { return true; }
require BASEPATH . 'core/Common.php';
require BASEPATH . 'database/DB.php';
class BF_Model { public $db; public function __construct() {} }
require APPPATH . 'modules/wt_penawaran/models/Wt_penawaran_model.php';
class Quotation_approval_view
{
    public $db, $Wt_penawaran_model, $uri;
    public function segment($index) { return 'wt_penawaran'; }
    public function render($results) {
        ob_start();
        try {
            require APPPATH . 'modules/wt_penawaran/views/formprosesapproval.php';
            return ob_get_contents();
        } finally { ob_end_clean(); }
    }
}
function approval_check($condition, $message) { if (!$condition) { throw new RuntimeException($message); } }
require APPPATH . 'config/development/database.php';
$config = $db['default'];
approval_check($config['hostname'] === 'db' && $config['database'] === 'waterco_demo', 'Refuse non-local database');
$connection = DB($config, true);
$connection->query('SET SESSION TRANSACTION READ ONLY');
$model = new Wt_penawaran_model(); $model->db = $connection;
$view = new Quotation_approval_view(); $view->db = $connection; $view->Wt_penawaran_model = $model; $view->uri = $view;
$id = $argv[1] ?? 'P2200930';
$results = array(
    'header' => $model->get_data('tr_penawaran', 'no_penawaran', $id),
    'detail' => $model->get_data('tr_penawaran_detail', 'no_penawaran', $id),
    'customers' => $model->get_data('master_customers', 'deleted', '0'),
    'top' => $model->get_data('ms_top')
);
approval_check(count($results['header']) === 1, 'Quotation fixture not found');
set_error_handler(function ($severity, $message, $file, $line) {
    if (error_reporting() & $severity) { throw new ErrorException($message, 0, $severity, $file, $line); }
    return false;
});
$failed = 0; $passed = 0;
try {
    foreach (array('stored', 'stk', 'ind') as $status) {
        try {
            $data = $results; $data['header'] = array(clone $results['header'][0]);
            if ($status !== 'stored') { $data['header'][0]->order_status = $status; }
            $html = $view->render($data);
            $dom = new DOMDocument(); $dom->loadHTML($html, LIBXML_NOERROR | LIBXML_NOWARNING);
            $xpath = new DOMXPath($dom);
            $selected = $xpath->query('//select[@name="order_sts"]/option[@selected]');
            approval_check($selected->length === 1 && $selected->item(0)->getAttribute('value') === $data['header'][0]->order_status, 'Wrong order status selected');
            approval_check($xpath->query('//select[@name="status"]/option[@value="2"]')->length === 1, 'Approval controls missing');
            approval_check($xpath->query('//button[@id="simpan-com"]')->length === 1, 'Save button missing');
            approval_check($xpath->query('//tbody[@id="list_spk"]/tr')->length === count($results['detail']), 'Detail rows missing');
            approval_check(str_ends_with(trim($html), '</script>'), 'View render interrupted');
            $passed++; echo "PASS: complete approval view, status=$status\n";
        } catch (Throwable $e) { $failed++; echo "FAIL: approval status=$status: " . $e->getMessage() . "\n"; }
    }
    foreach (glob(APPPATH . 'modules/wt_penawaran/views/*.php') as $file) {
        foreach (token_get_all(file_get_contents($file)) as $token) {
            if (is_array($token) && $token[0] === T_STRING && in_array($token[1], array('stk', 'ind'), true)) {
                $failed++; echo 'FAIL: bare order-status constant in ' . basename($file) . ':' . $token[2] . "\n";
            }
        }
    }
    echo "$passed view cases passed; $failed failures\n";
} finally { restore_error_handler(); $connection->close(); }
exit($failed ? 1 : 0);
