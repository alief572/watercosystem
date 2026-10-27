<?php
/** Isolated endpoint contract tests: no real sessions, grants or financial records. */
if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}
$root = dirname(__DIR__);
define('BASEPATH', $root . '/system/');
define('APPPATH', $root . '/application/');
define('ENVIRONMENT', 'development');
require $root . '/application/modules/report_piutang_invoice/libraries/Piutang_invoice_dataset.php';
function site_url($path = '') { return 'http://localhost/watercosystem/' . $path; }
function base_url($path = '') { return site_url($path); }
function html_escape($value) { return htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); }
function show_error($message, $code = 500) { throw new RuntimeException($message, $code); }
function check($condition, $message) { if (!$condition) { throw new RuntimeException($message); } }
class Report_fake_auth
{
    public $allowed = true;
    public $checked_permission;
    public function restrict($permission, $uri)
    {
        $this->checked_permission = $permission;
        if (!$this->allowed) { throw new RuntimeException('Denied', 403); }
    }
}
class Report_fake_input
{
    public $params = array();
    public $request_method = 'GET';
    public function get($key) { return isset($this->params[$key]) ? $this->params[$key] : null; }
    public function method($upper) { return $this->request_method; }
}
class Report_fake_model
{
    public $report;
    public $calls = 0;
    public $last_filters;
    public function dataset($filters) {
        $this->calls++;
        $this->last_filters = $filters;
        return $this->report;
    }
    public function customer_exists($id) { return $id === 'C1'; }
    public function customers() { return array(array('id_customer' => 'C1', 'name_customer' => '<script>customer</script>'), array('id_customer' => 'BLANK', 'name_customer' => '   ')); }
}
class Report_fake_template
{
    public $data;
    public function title($value) {}
    public function page_icon($value) {}
    public function render($view, $data) { $this->data = $data; }
}
class Report_fake_loader
{
    public function library($name) {}
    public function model($name, $alias) {}
}
class Report_fake_output
{
    public $json;
    public function set_content_type($type, $encoding) { return $this; }
    public function set_header($header) { return $this; }
    public function set_output($json) { $this->json = json_decode($json, true); return $this; }
}
class Admin_Controller
{
    public function __construct()
    {
        global $services;
        foreach ($services as $key => $value) { $this->$key = $value; }
    }
}
require $root . '/application/modules/report_piutang_invoice/controllers/Report_piutang_invoice.php';
$auth = new Report_fake_auth();
$input = new Report_fake_input();
$model = new Report_fake_model();
$template = new Report_fake_template();
$output = new Report_fake_output();
$services = array('auth' => $auth, 'input' => $input, 'report_model' => $model, 'template' => $template,
    'load' => new Report_fake_loader(), 'output' => $output, 'piutang_invoice_dataset' => new Piutang_invoice_dataset());
$invoices = array();
for ($i = 1; $i <= 26; $i++) {
    $invoices[] = array('no_invoice' => 'P' . $i, 'no_surat' => 'INV-' . $i, 'customer' => $i === 26 ? '<script>bad</script>' : 'Customer',
        'nilai_invoice' => 1000, 'tgl_invoice' => '2026-09-01', 'printed_on' => '2026-09-02 10:00:00', 'deleted_by' => null);
}
$details = array(
    array('no_invoice' => 'P26', 'kd_pembayaran' => 'PN-1', 'total_bayar_idr' => 100, 'tgl_pembayaran' => '2026-09-03', 'header_id' => 1),
    array('no_invoice' => 'P26', 'kd_pembayaran' => 'PN-2', 'total_bayar_idr' => 200, 'tgl_pembayaran' => '2026-09-04', 'header_id' => 2)
);
$model->report = (new Piutang_invoice_dataset())->build($invoices, $details, array(), '2026-09-28');
// Keep the invoice with two receipt rows at the page boundary.
$groups = $model->report['invoices'];
$last = array_shift($groups);
check($last['no_invoice'] === 'P26', 'Fixture ordering assumption failed');
$groups[] = $last;
$model->report['invoices'] = $groups;
$input->params = array('tanggal' => '2026-09-28', 'no_invoice' => '"><script>search</script>');
$controller = new Report_piutang_invoice();
$controller->index();
$data = $template->data;
check($model->calls === 0, 'Page must not preload the report rows');
extract($data);
ob_start();
require $root . '/application/modules/report_piutang_invoice/views/index.php';
$html = ob_get_clean();
check(strpos($html, '<script>customer</script>') === false && strpos($html, '&lt;script&gt;customer&lt;/script&gt;') !== false, 'Customer HTML not escaped');
check(strpos($html, '<script>search</script>') === false, 'Filter HTML not escaped');
check(strpos($html, 'value="BLANK"') === false, 'Blank customer option rendered');
check(strpos($html, '<select name="no_invoice"') !== false && strpos($html, 'id="piutang-table"') !== false, 'Missing invoice dropdown / DataTable');
$input->params = array('tanggal' => '2026-09-28', 'draw' => '7', 'start' => '25', 'length' => '25');
$controller->data();
check(count($output->json['data']) === 1 && count($output->json['data'][0]['payments']) === 2, 'Server pagination split an invoice group');
check($output->json['draw'] === 7 && $output->json['recordsTotal'] === 26 && $output->json['recordsFiltered'] === 26, 'DataTables protocol incorrect');
check($output->json['total_piutang'] === 25700, 'Whole-result total lost on page 2');
$input->params = array('tanggal' => '2026-09-28', 'draw' => '8', 'start' => '0', 'length' => '10', 'order' => array(array('column' => '8', 'dir' => 'asc')));
$controller->data();
check($output->json['data'][0]['no_invoice'] === 'P26', 'Server sorting failed');
$input->params = array('tanggal' => '2026-09-28', 'customer_id' => 'C1', 'no_invoice' => 'INV-1');
$controller->invoice_options();
check($model->last_filters['no_invoice'] === '' && $model->last_filters['customer_id'] === 'C1', 'Invoice options did not honor date/customer or ignored own selection incorrectly');
check(count($output->json['options']) === 26, 'Dropdown missing outstanding invoice options');
foreach (array(array('tanggal' => ''), array('tanggal' => '2026-02-30'), array('tanggal' => array('bad')),
    array('customer_id' => 'MISSING'), array('length' => '-1'), array('length' => '1000'), array('start' => array('bad')),
    array('draw' => '<script>'), array('order' => 'bad'), array('order' => array(array('column' => '4', 'dir' => 'asc')))) as $invalid) {
    $input->params = $invalid;
    try { $controller->data(); throw new RuntimeException('Invalid input accepted'); }
    catch (RuntimeException $error) { check($error->getCode() === 400, 'Expected validation HTTP 400'); }
}
$input->params = array('tanggal' => 'bad');
try { $controller->export_excel(); throw new RuntimeException('Invalid export accepted'); }
catch (RuntimeException $error) { check($error->getCode() === 400, 'Export validation missing'); }
$auth->allowed = false;
foreach (array('index', 'data', 'invoice_options', 'export_excel') as $endpoint) {
    try { $denied = new Report_piutang_invoice(); $denied->$endpoint(); throw new RuntimeException('Permission denied request accepted'); }
    catch (RuntimeException $error) { check($error->getCode() === 403, 'Expected permission denial'); }
}
check($auth->checked_permission === 'Report_Piutang_Invoice.View', 'Wrong permission guard');
$auth->allowed = true;
$input->request_method = 'POST';
try { new Report_piutang_invoice(); throw new RuntimeException('POST accepted'); }
catch (RuntimeException $error) { check($error->getCode() === 405, 'Expected GET-only rejection'); }
echo "PASS: all endpoint guards, validation, DataTables pagination/sorting/totals, invoice dropdown source and escaped HTML.\n";
if (in_array('--database', $argv, true)) {
    function log_message($level, $message) {}
    function is_php($version) { return version_compare(PHP_VERSION, $version, '>='); }
    class CI_Model {}
    require BASEPATH . 'database/DB.php';
    require APPPATH . 'config/database.php';
    require APPPATH . 'config/development/database.php';
    $settings = $db[$active_group];
    $settings['db_debug'] = false;
    $database = DB($settings, true);
    require APPPATH . 'modules/report_piutang_invoice/models/Report_piutang_invoice_model.php';
    $live_model = new Report_piutang_invoice_model();
    $live_model->db = $database;
    $live_model->load = new Report_fake_loader();
    $live_model->piutang_invoice_dataset = new Piutang_invoice_dataset();
    $services['report_model'] = $live_model;
    $input->request_method = 'GET';
    $input->params = array('tanggal' => '2026-09-28');
    $live_controller = new Report_piutang_invoice();
    $live_controller->invoice_options();
    $choices = $output->json['options'];
    check(count($choices) === 350, 'Live invoice dropdown does not match outstanding dataset');
    $input->params = array('tanggal' => '2026-09-28', 'draw' => '1', 'start' => '25', 'length' => '25');
    $live_controller->data();
    check(count($output->json['data']) === 25 && $output->json['recordsFiltered'] === 350 && $output->json['total_piutang'] === 5466754018, 'Live DataTables page/count/total incorrect');
    $input->params = array('tanggal' => '2026-09-28', 'draw' => '2', 'start' => '0', 'length' => '10', 'no_invoice' => $choices[0]['id']);
    $live_controller->data();
    check($output->json['recordsFiltered'] === 1 && $output->json['data'][0]['no_surat'] === $choices[0]['id'], 'Live invoice dropdown filter not exact');
    echo "PASS: live endpoint data, outstanding dropdown options, server pagination, counts, whole-result totals and exact invoice selection (SELECT only).\n";
}
