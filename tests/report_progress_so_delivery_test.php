<?php
define('BASEPATH', dirname(__DIR__) . '/system/');
class CI_Model { public $db; public function __construct() {} }
require dirname(__DIR__) . '/application/modules/report_progress_so/models/Report_progress_so_model.php';

class Delivery_fixture_db
{
    public $items;
    public $deliveries;
    private $table;
    public function __construct($items, $deliveries) { $this->items = $items; $this->deliveries = $deliveries; }
    public function select($fields, $escape = null) { return $this; }
    public function from($table) { $this->table = $table; return $this; }
    public function join($table, $on, $type) { return $this; }
    public function where($field, $value = null, $escape = null) { return $this; }
    public function where_in($field, $values) { return $this; }
    public function order_by($field, $direction) { return $this; }
    public function get() { return $this; }
    public function result_array() { return $this->table === 'tr_sales_order_detail d' ? $this->items : $this->deliveries; }
}
function delivery_check($condition, $message)
{
    if (!$condition) { throw new RuntimeException($message); }
    echo "PASS: $message\n";
}
function delivery_dataset($items, $deliveries)
{
    $model = new Report_progress_so_model();
    $model->db = new Delivery_fixture_db($items, $deliveries);
    return $model->get_delivery_dataset(array());
}
$item = array('id_so_detail' => 'ITEM1', 'no_so' => 'SO1', 'no_surat_so' => '047/WI/SO/X/2026',
    'nama_produk' => 'Supatuf 150 MK2', 'qty_so' => 2, 'tgl_so' => '2026-10-15',
    'nama_sales' => 'Sales', 'customer_name' => 'Customer');
$shipment = array('id_so_detail' => 'ITEM1', 'no_do' => 'DO1', 'no_surat_do' => '049/WI/DO/X/2026',
    'qty_do' => 1, 'tgl_do' => '2026-10-15');
$data = delivery_dataset(array($item), array($shipment, $shipment));
delivery_check(count($data['rows']) === 1, 'Two delivery details produce one SO item row');
$row = $data['rows'][0];
delivery_check($row['qty'] == 2 && $row['qty_kirim'] == 2 && $row['outstanding'] == 0,
    'Screenshot case: ordered 2, shipped 2, outstanding 0');
delivery_check($row['persen_terkirim'] == 100 && $row['status_code'] === 'terkirim', 'Final progress is 100%, not 150%');
delivery_check($row['no_do'] === $shipment['no_surat_do'], 'Repeated DO number appears once without losing shipped quantity');
delivery_check($data['totals']['total_qty_so'] == 2 && $data['totals']['total_outstanding'] == 0, 'Totals count each SO item once');
$data = delivery_dataset(array($item), array($shipment));
delivery_check($data['rows'][0]['persen_terkirim'] == 50 && $data['rows'][0]['outstanding'] == 1, 'Partial delivery remains 50% with one outstanding');
$second = $shipment;
$second['no_do'] = 'DO2'; $second['no_surat_do'] = '050/WI/DO/X/2026'; $second['tgl_do'] = '2026-10-16';
$data = delivery_dataset(array($item), array($shipment, $second));
delivery_check(count($data['rows']) === 1 && strpos($data['rows'][0]['no_do'], '050/WI/DO/X/2026') !== false
    && strpos($data['rows'][0]['no_do'], '049/WI/DO/X/2026') !== false, 'Split shipments retain both DO references');
delivery_check($data['rows'][0]['tanggal_do'] === '2026-10-16', 'DO date is the latest shipment date');
$other = $item; $other['id_so_detail'] = 'ITEM2';
$data = delivery_dataset(array($item, $other), array($shipment, $second));
delivery_check(count($data['rows']) === 2 && $data['totals']['total_qty_so'] == 4
    && $data['totals']['total_outstanding'] == 2, 'Separate SO detail items with identical names remain separate');
$data = delivery_dataset(array($item), array());
delivery_check($data['rows'][0]['status_code'] === 'belum_terkirim' && $data['rows'][0]['outstanding'] == 2, 'Unshipped item stays visible');
$second['qty_do'] = 3;
$data = delivery_dataset(array($item), array($shipment, $second));
delivery_check($data['rows'][0]['qty_kirim'] == 4 && $data['rows'][0]['persen_terkirim'] == 100
    && $data['rows'][0]['outstanding'] == 0, 'Excess shipped quantity stays visible while completion is capped at 100%');
$data = delivery_dataset(array(), array());
delivery_check(count($data['rows']) === 0 && $data['totals']['total_qty_so'] == 0, 'Empty dataset has zero totals');

class Admin_Controller {}
function html_escape($value) { return htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); }
require dirname(__DIR__) . '/application/modules/report_progress_so/controllers/Report_progress_so.php';
class Delivery_input
{
    public $search = '047/WI/SO/X/2026';
    public function get_post($key) { return ''; }
    public function post($key) {
        $values = array('search' => array('value' => $this->search), 'start' => 0, 'length' => 25, 'draw' => 1);
        return isset($values[$key]) ? $values[$key] : null;
    }
}
class Delivery_output
{
    public $body;
    public function set_content_type($type, $charset) { return $this; }
    public function set_header($header) { return $this; }
    public function set_output($body) { $this->body = $body; return $this; }
}
$model = new Report_progress_so_model();
$other['no_surat_so'] = '048/WI/SO/X/2026';
$model->db = new Delivery_fixture_db(array($item, $other), array($shipment, $shipment));
$controller = (new ReflectionClass('Report_progress_so'))->newInstanceWithoutConstructor();
$controller->report_model = $model;
$controller->input = new Delivery_input();
$controller->output = new Delivery_output();
$controller->data_delivery();
$response = json_decode($controller->output->body, true);
delivery_check($response['recordsTotal'] === 2 && $response['recordsFiltered'] === 1, 'Endpoint search counts SO items instead of delivery details');
delivery_check($response['totals']['total_qty_so'] === '2' && $response['totals']['total_qty_kirim'] === '2'
    && $response['totals']['total_outstanding'] === '0', 'Search footer shows ordered 2, shipped 2, outstanding 0');
delivery_check($response['data'][0]['persen_terkirim'] === '100,0%', 'Endpoint formats final progress as 100%');
