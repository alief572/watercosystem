<?php
if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }
define('BASEPATH', dirname(__DIR__) . '/system/');
class Admin_Controller { public $auth, $load, $input, $upload, $image_lib, $db, $stock_booking, $Wt_delivery_order_model; }
function log_message($level, $message) { $GLOBALS['saveLog'][] = $message; }
require dirname(__DIR__) . '/application/libraries/Stock_booking.php';
require dirname(__DIR__) . '/application/modules/wt_delivery_order/controllers/Wt_delivery_order.php';
set_error_handler(function ($severity, $message, $file, $line) {
    throw new ErrorException($message, 0, $severity, $file, $line);
});

class DoSaveResult
{
    private $rows;
    public function __construct($rows) { $this->rows = $rows; }
    public function row() { return $this->rows ? (object)$this->rows[0] : null; }
}
class DoSaveDb
{
    public $db_debug = true, $depth = 0, $writes = array(), $committed = false;
    public $missingCost = false, $zeroQty = false, $failInsert = false, $failCommit = false;
    public $soParams;
    private $ok = true;
    public function trans_begin() { ++$this->depth; return true; }
    public function trans_status() { return $this->ok; }
    public function trans_commit() {
        if ($this->failCommit) { return false; }
        $this->committed = --$this->depth === 0;
        return true;
    }
    public function trans_rollback() {
        if (!$this->depth) { return false; }
        --$this->depth;
        $this->writes = array();
        return true;
    }
    public function insert($table, $row) {
        if ($this->failInsert && $table === 'tr_delivery_order_detail') { $this->ok = false; return false; }
        $this->writes[$table][] = $row;
        return true;
    }
    public function query($sql, $params = array()) {
        if (strpos($sql, 'FROM ms_costbook') !== false) {
            return new DoSaveResult($this->missingCost ? array() : array(array('nilai_costbook' => 12.5)));
        }
        if (strpos($sql, 'FROM tr_sales_order_detail') !== false) {
            if (strpos($sql, 'sum(qty_so)') !== false) {
                return new DoSaveResult(array(array('qtyso' => $this->zeroQty ? 0 : 5)));
            }
            $this->soParams = $params;
            $field = strpos($sql, 'as qtyso') !== false ? 'qtyso' : 'costbook_so';
            return new DoSaveResult(array(array($field => 8.5)));
        }
        if (strpos($sql, 'UPDATE ') === 0) { $this->writes['updates'][] = array($sql, $params); return true; }
        throw new RuntimeException('Unexpected query: ' . $sql);
    }
}
class DoSaveStore extends Stock_booking_store
{
    public function __construct() {}
    public function ready() {}
    public function query($sql, $params = array()) {
        if (strpos($sql, 'GET_LOCK') !== false) { return array(array('acquired' => 1)); }
        if (strpos($sql, 'RELEASE_LOCK') !== false || strpos($sql, 'stock_booking_quarantine') !== false) { return array(); }
        if (strpos($sql, 'FROM tr_sales_order_detail') !== false) { return array(array('id_so_detail' => 1)); }
        if (strpos($sql, 'FROM tr_spk_delivery_detail') !== false) {
            return array(array('id_so_detail' => 1, 'no_so' => 'SO1', 'id_category3' => 'ITEM', 'qty_delivery' => 2, 'status_do' => '0'));
        }
        if (strpos($sql, 'FROM tr_delivery_order_detail') !== false) { return array(); }
        throw new RuntimeException('Unexpected stock query: ' . $sql);
    }
}
class DoSaveServices
{
    public $uploaded = false, $post;
    public function restrict($permission) {}
    public function library($name, $config = array()) {}
    public function user_id() { return 'save-test'; }
    public function post() { return $this->post; }
    public function initialize($config) {}
    public function resize() { return true; }
    public function do_upload($field) { return $this->uploaded; }
    public function data() { return array('file_name' => 'fixture.png', 'file_type' => 'image/png', 'file_size' => 1, 'is_image' => true); }
    public function display_errors($open = '', $close = '') { return 'Jenis file tidak diizinkan.'; }
    public function generate_code_Do() { return 'D2600001'; }
    public function BuatNomorDo($date) { return '001/WI/DO/XI/2026'; }
}

$checks = 0;
foreach (array('no upload', 'upload', 'unchecked row', 'missing cost', 'zero SO qty', 'failed upload', 'failed detail insert', 'failed commit') as $case) {
    $GLOBALS['saveLog'] = array();
    $controller = (new ReflectionClass('Wt_delivery_order'))->newInstanceWithoutConstructor();
    $services = new DoSaveServices();
    $db = new DoSaveDb();
    $services->post = array('tanggal' => '2026-11-17', 'id_customer' => 'C1', 'no_spk' => 'SPK1', 'no_invoice' => '', 'location' => '',
        'dt' => array(array('kirim' => 'on', 'id_so' => 1, 'id_spk' => 20, 'no_so' => 'SO1', 'no_spk' => 'SPK1', 'id_category3' => 'ITEM',
            'nama_produk' => 'Item', 'qty_delivery' => 2, 'schedule' => '2026-11-17', 'serial_number' => '', 'kartu_garansi' => '', 'id_planning_delivery' => 10)));
    $_FILES = array('upload_foto' => array('error' => UPLOAD_ERR_NO_FILE));
    if ($case === 'upload') { $services->uploaded = true; }
    if ($case === 'unchecked row') { $services->post['dt'][] = array('id_so' => 2); }
    if ($case === 'missing cost') { $db->missingCost = true; }
    if ($case === 'zero SO qty') { $db->zeroQty = true; }
    if ($case === 'failed upload') { $_FILES['upload_foto']['error'] = UPLOAD_ERR_OK; }
    if ($case === 'failed detail insert') { $db->failInsert = true; }
    if ($case === 'failed commit') { $db->failCommit = true; }
    $_POST = $services->post;
    $controller->auth = $controller->load = $controller->input = $controller->upload = $controller->image_lib = $controller->Wt_delivery_order_model = $services;
    $controller->db = $db;
    $booking = (new ReflectionClass('Stock_booking'))->newInstanceWithoutConstructor();
    (new ReflectionProperty('Stock_booking', 'ci'))->setValue($booking, $controller);
    (new ReflectionProperty('Stock_booking', 'store'))->setValue($booking, new DoSaveStore());
    $controller->stock_booking = $booking;
    ob_start();
    $controller->SaveDeliveryOrder();
    $response = json_decode(ob_get_clean(), true, 512, JSON_THROW_ON_ERROR);
    $success = in_array($case, array('no upload', 'upload', 'unchecked row'), true);
    if ($response['status'] !== ($success ? 1 : 0) || $db->committed !== $success || $db->depth !== 0 || !$db->db_debug) {
        throw new RuntimeException($case . ': incorrect save result ' . json_encode(array($response, $GLOBALS['saveLog'])));
    }
    if ($success) {
        $header = $db->writes['tr_delivery_order'][0];
        $detail = $db->writes['tr_delivery_order_detail'];
        if ($header['upload_foto'] !== ($services->uploaded ? 'fixture.png' : null) || count($detail) !== 1
            || $detail[0]['costbook_so'] !== 8.5 || $detail[0]['cost_book'] !== 12.5 || !in_array(1, $db->soParams, true)) {
            throw new RuntimeException($case . ': wrong upload/costbook/SO detail');
        }
    } elseif ($db->writes) { throw new RuntimeException($case . ': failed save retained changes'); }
    foreach ($GLOBALS['saveLog'] as $message) {
        if (strpos($message, 'ErrorException') !== false || strpos($message, 'DivisionByZeroError') !== false) {
            throw new RuntimeException($case . ': unhandled warning/error: ' . $message);
        }
    }
    ++$checks;
}
echo "PASS: $checks delivery order save cases (no database/files written)\n";
