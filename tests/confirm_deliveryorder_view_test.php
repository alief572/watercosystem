<?php
error_reporting(E_ALL);
function has_permission($permission) { return true; }
function base_url($path = '') { return '/' . ltrim($path, '/'); }
function set_value($field, $default = '') { return $default; }

class ConfirmDeliveryViewFixture
{
    public $uri;
    public function __construct() { $this->uri = $this; }
    public function segment($index) { return 'wt_delivery_order'; }
    public function render($data)
    {
        $headerso = array((object) array('no_do' => 'D2603588', 'no_spk' => 'SPK1',
            'id_customer' => 'CUSTOMER1', 'tgl_do' => '2026-11-16'));
        $getitemso = array();
        extract($data);
        ob_start();
        try {
            require dirname(__DIR__) . '/application/modules/wt_delivery_order/views/confirm_deliveryorder.php';
            return ob_get_contents();
        } finally { ob_end_clean(); }
    }
}

set_error_handler(function ($severity, $message, $file, $line) {
    if (error_reporting() & $severity) { throw new ErrorException($message, 0, $severity, $file, $line); }
    return false;
});
try {
    $view = new ConfirmDeliveryViewFixture();
    foreach (array('missing results' => array(), 'missing action' => array('results' => array()),
        'confirm mode' => array('results' => array('action' => 'confirm')),
        'view mode' => array('results' => array('action' => 'view'))) as $name => $data) {
        $html = $view->render($data);
        if (!preg_match('/<script[^>]*>(.*?)<\/script>/s', $html, $match)) { throw new RuntimeException('Missing script'); }
        if (strpos($match[1], '<') !== false) { throw new RuntimeException('HTML leaked into JavaScript'); }
        $disabled = strpos($match[1], '$("#data-form :input").prop("disabled", true);') !== false;
        if ($disabled !== ($name === 'view mode')) { throw new RuntimeException('Wrong form mode'); }
        if (strpos($match[1], 'SaveConfirmDeliveryOrder') === false) { throw new RuntimeException('Missing save handler'); }
        echo 'PASS: ' . $name . PHP_EOL;
    }
} finally { restore_error_handler(); }
