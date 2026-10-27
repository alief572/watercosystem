<?php
define('BASEPATH', dirname(__DIR__) . '/system/');
define('FCPATH', dirname(__DIR__) . '/');
#[AllowDynamicProperties]
class Admin_Controller {}
class Quotation_update_captured extends RuntimeException {}
class Quotation_edit_auth
{
    public function restrict($permission) {}
    public function user_id() { return 1; }
}
class Quotation_edit_input
{
    public $values;
    public function post() { return $this->values; }
}
class Quotation_edit_database
{
    public $header;
    public function trans_begin() {}
    public function where($key, $value) { return $this; }
    public function update($table, $data)
    {
        if ($table !== 'tr_penawaran') throw new RuntimeException('Unexpected table');
        $this->header = array_merge($this->header, $data);
        throw new Quotation_update_captured();
    }
}
$module = isset($argv[1]) ? $argv[1] : 'wt_penawaran';
if (!in_array($module, array('wt_penawaran', 'wt_penawaran2'), true)) {
    throw new RuntimeException('Unknown module');
}
$path = FCPATH . 'application/modules/' . $module . '/controllers/Wt_penawaran.php';
require $path;
set_error_handler(function ($severity, $message, $file, $line) {
    throw new ErrorException($message, 0, $severity, $file, $line);
});
$controller = (new ReflectionClass('Wt_penawaran'))->newInstanceWithoutConstructor();
$controller->auth = new Quotation_edit_auth();
$controller->input = new Quotation_edit_input();
preg_match_all('/\$post\[\x27([^\x27]+)\x27\]/', file_get_contents($path), $keys);
$base = array_fill_keys($keys[1], '');
$base['no_penawaran'] = 'TEST-QUOTATION';
$base['email_customer'] = 'updated@example.test';
foreach (array('ind', 'stk') as $stored) {
    foreach (array('ind', 'stk', 'invalid', null) as $posted) {
        $controller->db = new Quotation_edit_database();
        $controller->db->header = array('order_status' => $stored);
        $values = $base;
        unset($values['order_sts']);
        if ($posted !== null) $values['order_sts'] = $posted;
        $controller->input->values = $values;
        try {
            $controller->SaveEditPenawaran();
            throw new RuntimeException('Header update was not reached');
        } catch (Quotation_update_captured $captured) {}
        if ($controller->db->header['order_status'] !== $stored) {
            throw new RuntimeException('Editing must preserve stored Order Status');
        }
        if ($controller->db->header['email_customer'] !== $base['email_customer']) {
            throw new RuntimeException('Other quotation fields must remain editable');
        }
    }
}
echo $module . ": 8 Order Status preservation cases passed\n";
