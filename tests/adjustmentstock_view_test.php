<?php
// Run: docker exec waterco_web85 php tests/adjustmentstock_view_test.php
if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }
error_reporting(E_ALL);

function base_url() { return '/'; }

class Adjustmentstock_view_fixture
{
    public $uri;
    public function segment($index) { return 'adjustmentstock'; }
    public function render($results)
    {
        ob_start();
        try {
            require dirname(__DIR__) . '/application/modules/adjustmentstock/views/Adjust.php';
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
        'idstock' => '123'
    ));
    $dom = new DOMDocument();
    $dom->loadHTML($html, LIBXML_NOERROR | LIBXML_NOWARNING);
    $xpath = new DOMXPath($dom);
    foreach (array(
        '//form[@id="data-form"]',
        '//input[@name="id_material" and @value="MAT001"]',
        '//input[@name="nama_material" and @value="Test Material"]',
        '//input[@name="id_stock" and @value="123"]',
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
} finally { restore_error_handler(); }
