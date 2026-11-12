<?php
// Run: php tests/purchase_order_test.php
error_reporting(E_ALL);
set_error_handler(function ($level, $message, $file, $line) {
    if (error_reporting() & $level) throw new ErrorException($message, 0, $level, $file, $line);
    return false;
});
define('BASEPATH', dirname(__DIR__) . '/system/');
class Admin_Controller { public $db, $auth, $input, $output, $Pr_model, $template, $session, $uri; }
class BF_Model { public $db; }
function log_message($level, $message) {}
function po_check($ok, $message) {
    if (!$ok) throw new RuntimeException($message);
    echo "PASS: $message\n";
}
class Po_result {
    public $rows;
    function __construct($rows) { $this->rows = $rows; }
    function row_array() { return $this->rows[0] ?? array(); }
    function row() { return isset($this->rows[0]) ? (object)$this->rows[0] : null; }
}
class Po_input {
    public $values = array();
    function post($key = null) { return $key === null ? $this->values : ($this->values[$key] ?? null); }
    function get($key) { return $this->values[$key] ?? null; }
}
class Po_auth {
    public $permission, $allowed = true;
    function restrict($permission) { $this->permission = $permission; if (!$this->allowed) throw new DomainException('Denied'); }
    function user_id() { return 9; }
}
class Po_output { function set_content_type($type) { return $this; } }
require dirname(__DIR__) . '/application/modules/purchase_order/models/Pr_model.php';
require dirname(__DIR__) . '/application/modules/purchase_order/controllers/Purchase_order.php';
$model = (new ReflectionClass('Pr_model'))->newInstanceWithoutConstructor();
$model->db = new class {
    public $number = null;
    function query($sql, $binds = array()) { return new Po_result(array(array('max_id'=>$this->number))); }
};
po_check($model->generate_code('2026-11-13') === 'P2600001', 'Empty counter starts at one without warning');
$model->db->number = 100;
po_check($model->BuatNomor('2026-11-13') === 'PO-101/MP/11/2026', 'Letter counter preserves hundreds');
$model->db->number = 99999;
try { $model->generate_code('2026-11-13'); throw new LogicException('Overflow accepted'); }
catch (DomainException $e) { po_check(true, 'Internal counter capacity enforced'); }
$model->db->number = 999;
try { $model->BuatNomor('2026-11-13'); throw new LogicException('Overflow accepted'); }
catch (DomainException $e) { po_check(true, 'Monthly counter capacity enforced'); }
$controller = (new ReflectionClass('Purchase_order'))->newInstanceWithoutConstructor();
$controller->auth = new Po_auth(); $controller->input = new Po_input(); $controller->output = new Po_output();
$controller->Pr_model = $model;
function po_call($method) {
    global $controller;
    ob_start();
    try { $controller->$method(); $body = ob_get_contents(); } finally { ob_end_clean(); }
    $result = json_decode($body, true);
    po_check(is_array($result), $method . ' returns JSON without warnings');
    return $result;
}
foreach (array('SaveNew'=>'Purchase_Order.Add','SaveEdit'=>'Purchase_Order.Add','Approved'=>'Purchase_Order.Delete') as $method=>$permission) {
    $controller->auth->allowed = false;
    try { po_call($method); throw new LogicException('Authorization bypass'); }
    catch (DomainException $e) { po_check($controller->auth->permission === $permission, $method . ' preserves permission'); }
}
$controller->auth->allowed = true;
