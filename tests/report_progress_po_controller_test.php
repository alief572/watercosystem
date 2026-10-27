<?php
define('BASEPATH', dirname(__DIR__) . '/system/');
require dirname(__DIR__) . '/application/modules/report_progress_po/libraries/Progress_po_rules.php';
function site_url($path = '') { return 'http://localhost/' . $path; }
function base_url($path = '') { return site_url($path); }
function html_escape($value) { return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8'); }
function log_message($level, $message) {}
function controller_check($condition, $message) {
    if (!$condition) { throw new RuntimeException($message); }
    echo "PASS: $message\n";
}
class Po_auth {
    public $allowed = true;
    public $permission;
    public function restrict($permission, $redirect) {
        $this->permission = $permission;
        if (!$this->allowed) { throw new DomainException('Denied'); }
    }
}
class Po_load {
    public $calls = 0;
    public function model($name, $alias) { $this->calls++; }
    public function library($name, $config, $alias) { $this->calls++; }
}
class Po_template {
    public function title($title) {}
    public function page_icon($icon) {}
    public function render($view, $data) { extract($data); require dirname(__DIR__) . '/application/modules/report_progress_po/views/' . $view . '.php'; }
}
class Admin_Controller {
    public static $authFixture;
    public $auth, $load, $template, $input, $output, $report_model, $workbook;
    public function __construct() { $this->auth = self::$authFixture; $this->load = new Po_load(); $this->template = new Po_template(); }
}
require dirname(__DIR__) . '/application/modules/report_progress_po/controllers/Report_progress_po.php';
$auth = new Po_auth(); $auth->allowed = false; Admin_Controller::$authFixture = $auth;
try { new Report_progress_po(); throw new RuntimeException('Permission bypass'); }
catch (DomainException $expected) { echo "PASS: Unauthorized controller initialization is denied before model loading\n"; }
controller_check($auth->permission === 'Report_Progress_Po.View', 'Dedicated report permission covers every endpoint');
$auth->allowed = true; $controller = new Report_progress_po();
class Po_input {
    public $values = array();
    public function get($name) { return isset($this->values[$name]) ? $this->values[$name] : null; }
}
class Po_output {
    public $body, $status, $headers = array();
    public function set_status_header($status) { $this->status = $status; return $this; }
    public function set_content_type($type, $charset = null) { return $this; }
    public function set_header($header) { $this->headers[] = $header; return $this; }
    public function set_output($body) { $this->body = $body; return $this; }
    public function enable_profiler($enabled) { return $this; }
}
class Po_model {
    public $filters;
    public function get_suppliers() { return array(array('id_suplier' => 'S1', 'name_suplier' => '<script>unsafe</script>')); }
    public function get_dataset($filters, $id = null) {
        $this->filters = $filters;
        $rows = array();
        foreach (range(1, 3) as $number) {
            $rows[] = array('id' => 'P' . $number, 'number' => 'PO' . $number, 'date' => '2026-10-01',
                'supplier' => 'Supplier', 'native' => 100, 'total_idr' => 100, 'received_idr' => 0,
                'remaining_idr' => 100, 'progress' => 0, 'items' => array('private detail data'));
        }
        if ($id !== null) { $rows = array_values(array_filter($rows, function ($row) use ($id) { return $row['id'] === $id; })); }
        return array('rows' => $rows, 'records_total' => 3, 'totals' => array('count_po' => count($rows)),
            'monthly' => array(), 'suppliers' => array(), 'generated_at' => '2026-10-26 12:00:00');
    }
}
$controller->input = new Po_input(); $controller->output = new Po_output(); $controller->report_model = new Po_model();
$controller->input->values = array('start' => '1', 'length' => '1', 'draw' => '8', 'sort' => 'number', 'direction' => 'asc', 'search' => 'PO');
$controller->data_po(); $body = json_decode($controller->output->body, true);
controller_check($body['draw'] === 8 && count($body['data']) === 1 && $body['data'][0]['id'] === 'P2', 'Server pagination and ordering');
controller_check($body['recordsFiltered'] === 3 && $body['totals']['count_po'] === 3, 'Summary covers all filtered rows, not only current page');
controller_check(!isset($body['data'][0]['items']), 'List response omits full Incoming details');
controller_check($controller->report_model->filters['search'] === 'PO', 'Shared search passes to report model');
controller_check(in_array('Cache-Control: no-store', $controller->output->headers, true), 'Financial response is not cached');
foreach (array(array('sort' => 'DROP TABLE'), array('start' => array()), array('length' => '-1'), array('currency' => 'EUR')) as $bad) {
    $controller->input->values = $bad; $controller->data_po();
    controller_check($controller->output->status === 422 && isset(json_decode($controller->output->body, true)['error']), 'Malformed request rejected');
}
$controller->input->values = array('id' => 'P1'); $controller->detail();
controller_check(json_decode($controller->output->body, true)['id'] === 'P1', 'Detail endpoint returns correct internal PO');
$controller->input->values = array('id' => 'missing'); $controller->detail();
controller_check($controller->output->status === 404, 'Unknown PO returns 404');
$controller->input->values = array(); $controller->summary();
controller_check(!isset(json_decode($controller->output->body, true)['rows']), 'Summary endpoint omits item datasets');
class Sorted_po_model extends Po_model {
    public function get_dataset($filters, $id = null) {
        $data = parent::get_dataset($filters, $id);
        $amounts = array(2, 100, 30);
        foreach ($data['rows'] as $index => &$row) { $row['native'] = $amounts[$index]; }
        unset($row);
        return $data;
    }
}
$controller->report_model = new Sorted_po_model();
foreach (array('asc' => array('P1', 'P3', 'P2'), 'desc' => array('P2', 'P3', 'P1')) as $direction => $expected) {
    $controller->input->values = array('sort' => 'native', 'direction' => $direction);
    $controller->data_po(); $sorted = json_decode($controller->output->body, true);
    controller_check(array_column($sorted['data'], 'id') === $expected, 'Numeric PO sorting ' . $direction . ' works on PHP 5.6');
}
ob_start(); $controller->index(); $html = ob_get_clean();
controller_check(strpos($html, '&lt;script&gt;unsafe&lt;/script&gt;') !== false && strpos($html, '<script>unsafe</script>') === false, 'Supplier dropdown escapes stored HTML');
controller_check(strpos($html, 'id="po-filters"') !== false && strpos($html, 'id="po-detail"') !== false, 'Report page renders filters and detail dialog');

require_once dirname(__DIR__) . '/application/libraries/PHPExcel.php';
if (!class_exists('ZipArchive')) { PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP); }
require dirname(__DIR__) . '/application/modules/report_progress_po/libraries/Progress_po_workbook.php';
class Export_po_model extends Po_model {
    public function get_dataset($filters, $id = null) {
        $rules = new Progress_po_rules();
        $po = array('no_po' => 'P1', 'no_surat' => 'PO1', 'tanggal' => '2026-10-01',
            'id_suplier' => 'S1', 'supplier' => 'Supplier', 'matauang' => 'idr', 'loi' => 'Lokal',
            'nominal_kurs' => 1, 'status' => '2', 'note' => 'Barang');
        $rows = array($rules->calculate($po, array(array('id_dt_po' => 'I1', 'qty' => 1,
            'jumlahharga' => 100, 'diskon' => 0, 'close_po' => 'N', 'namamaterial' => 'Barang')), array()));
        return array_merge(array('rows' => $rows, 'generated_at' => '2026-10-26 12:00:00'), $rules->summarize($rows, $filters['start_date'], $filters['end_date']));
    }
}
$controller->report_model = new Export_po_model();
$controller->workbook = new Progress_po_workbook();
$controller->input->values = array('start_date' => '2026-10-01', 'end_date' => '2026-10-31');
$controller->export_excel();
controller_check(substr($controller->output->body, 0, 2) === 'PK', 'Export endpoint returns binary XLSX without appended HTML');
controller_check($controller->workbook->build((new Export_po_model())->get_dataset(array()), Progress_po_rules::filters(array())) instanceof PHPExcel, 'Export uses bundled PHPExcel without Composer');
controller_check(count(array_filter($controller->output->headers, function ($header) { return strpos($header, 'Content-Disposition: attachment; filename="Report_Progress_PO_2026-10-01_sd_2026-10-31.xlsx"') === 0; })) === 1, 'Download filename contains validated period');
$controller->input->values = array('start_date' => 'bad'); $controller->export_excel();
controller_check($controller->output->status === 422, 'Invalid export filter returns JSON before download headers');
