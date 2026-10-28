<?php
define('BASEPATH', dirname(__DIR__) . '/system/');
define('FCPATH', dirname(__DIR__) . '/');
define('__CLASS_HTML2PDF__', 'test');
class Admin_Controller { public $auth, $uri, $load, $Wt_delivery_order_model; }
class Do_print_fixture
{
    public $returnView = false;
    public function restrict($permission) {}
    public function segment($index) { return 'D2603530'; }
    public function get_where_in($key, $value, $table) { return array(); }
    public function cariDeliveryOrderDetail($id) { return array(); }
    public function view($name, $data, $return = false)
    {
        $this->returnView = $return;
        if ($return) return '<p>Delivery Order fixture</p>';
        echo '<p>Delivery Order fixture</p>';
    }
    public function SetDisplayMode($mode) {}
}
class HTML2PDF
{
    public $pdf;
    public static $html, $output;
    public function __construct() { $this->pdf = new Do_print_fixture(); }
    public function WriteHTML($html) { self::$html = $html; }
    public function Output($name, $mode) { self::$output = array($name, $mode); }
}
require FCPATH . 'application/modules/wt_delivery_order/controllers/Wt_delivery_order.php';
set_error_handler(function ($severity, $message, $file, $line) {
    throw new ErrorException($message, 0, $severity, $file, $line);
});
$controller = (new ReflectionClass('Wt_delivery_order'))->newInstanceWithoutConstructor();
$fixture = new Do_print_fixture();
$controller->auth = $controller->uri = $controller->load = $controller->Wt_delivery_order_model = $fixture;
foreach (array('printDO', 'printDOhistory') as $method) {
    foreach (array(false, true) as $outerBuffer) {
        if ($outerBuffer) { ob_start(); echo 'Caller buffer'; }
        $level = ob_get_level();
        $controller->$method('D2603530');
        if (ob_get_level() !== $level) throw new RuntimeException('Caller buffer level changed');
        if ($outerBuffer && ob_get_clean() !== 'Caller buffer') throw new RuntimeException('Caller buffer was modified');
        if (!$fixture->returnView || HTML2PDF::$html !== '<p>Delivery Order fixture</p>') {
            throw new RuntimeException('View must be returned as a string without emitting HTML');
        }
        if (HTML2PDF::$output !== array('DeliveryOrder.pdf', 'I')) throw new RuntimeException('PDF output contract changed');
        echo 'PASS: ' . $method . ($outerBuffer ? ' with caller buffer' : ' without output buffer') . PHP_EOL;
    }
}
