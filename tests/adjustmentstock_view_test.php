<?php
// Run: docker exec waterco_web85 php tests/adjustmentstock_view_test.php
if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }
error_reporting(E_ALL);

function base_url() { return '/'; }

class Adjustmentstock_view_fixture
{
    public $uri;
    public $module = 'adjustmentstock';
    public function segment($index) { return $this->module; }
    public function render($results, $view = 'Adjust')
    {
        ob_start();
        try {
            require dirname(__DIR__) . '/application/modules/' . $this->module . '/views/' . $view . '.php';
            return ob_get_contents();
        } finally { ob_end_clean(); }
    }
}

set_error_handler(function ($severity, $message, $file, $line) {
    if (error_reporting() & $severity) {
        throw new ErrorException($message, 0, $severity, $file, $line);
    }
    return false;
});

try {
    $view = new Adjustmentstock_view_fixture();
    $view->uri = $view;
    $html = $view->render(array(
        'inventory_3' => array((object) array('id_category3' => 'MAT001', 'nama' => 'Test Material')),
        'idstock' => '123',
        'request_key' => str_repeat('a', 32)
    ));
    $dom = new DOMDocument();
    $dom->loadHTML($html, LIBXML_NOERROR | LIBXML_NOWARNING);
    $xpath = new DOMXPath($dom);
    foreach (array(
        '//form[@id="data-form"]',
        '//input[@name="id_material" and @value="MAT001"]',
        '//input[@name="nama_material" and @value="Test Material"]',
        '//input[@name="id_stock" and @value="123"]',
        '//input[@name="request_key" and @value="aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa"]',
        '//input[@name="total_qty" and @min="1" and @step="1"]',
        '//select[@name="adjustment"]/option[@value="PLUS"]',
        '//select[@name="adjustment"]/option[@value="MINUS"]',
        '//input[@name="note"]',
        '//button[@id="simpan-plus"]'
    ) as $query) {
        if ($xpath->query($query)->length !== 1) {
            throw new RuntimeException('Missing adjustment form control: ' . $query);
        }
    }
    if (!str_ends_with(trim($html), '</script>')) {
        throw new RuntimeException('Adjustment view render interrupted');
    }
    echo "PASS: complete adjustment form renders without supplier data or PHP warnings\n";
    $view->module = 'adjustmentstockmulti';
    foreach (array('Adjust', 'CreateMutasi') as $form) {
        $payload = 'Material "><img src=x onerror=alert(1)>';
        $html = $view->render(array(
            'inventory_3'=>array((object)array('id_category3'=>'MAT001','nama'=>$payload)),
            'idstock'=>'123','idgudang'=>'2','request_key'=>str_repeat('b',32),
            'gudang'=>array((object)array('id_gudang'=>'5','nama_gudang'=>'<script>alert(1)</script>'))
        ), $form);
        $dom = new DOMDocument(); $dom->loadHTML($html, LIBXML_NOERROR | LIBXML_NOWARNING); $xpath = new DOMXPath($dom);
        if ($xpath->query('//img')->length !== 0 || $xpath->query('//script')->length !== 1
            || $xpath->query('//input[@name="nama_material"]')->item(0)->getAttribute('value') !== $payload
            || !str_ends_with(trim($html), '</script>')) {
            throw new RuntimeException($form . ' failed complete/safe rendering');
        }
        if ($form === 'CreateMutasi' && ($xpath->query('//select[@name="adjustment"]/option[@value="MUTASI"]')->length !== 1
            || $xpath->query('//select[@name="id_gudang_baru"]/option[@value="5"]')->length !== 1)) {
            throw new RuntimeException('Missing transfer controls');
        }
    }
    echo "PASS: multi adjustment and transfer forms render without supplier data and escape stored HTML\n";
} finally { restore_error_handler(); }
