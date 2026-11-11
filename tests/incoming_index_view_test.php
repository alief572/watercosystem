<?php
// Run: docker exec waterco_web85 php tests/incoming_index_view_test.php
if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }
error_reporting(E_ALL);

function base_url($path = '') { return '/' . ltrim($path, '/'); }
function has_permission($permission) { return in_array($permission, $GLOBALS['incoming_permissions'], true); }
function render_incoming_index($results)
{
    ob_start();
    try {
        require dirname(__DIR__) . '/application/modules/incoming/views/index.php';
        return ob_get_contents();
    } finally { ob_end_clean(); }
}

$record = (object) array(
    'id_incoming' => 'IC-TEST', 'id_data' => 'IC_TEST', 'name_suplier' => 'Test Supplier',
    'tanggal' => '2026-11-11', 'pic' => 'Test PIC', 'keterangan' => 'Test incoming',
    'matauang' => 'USD', 'kurs' => '15000', 'hutang_kurs' => '100', 'rencana_bayar_idr' => '0'
);
$all = array('Purchase_Order.Add', 'Purchase_Order.Manage', 'Purchase_Order.View');
$cases = array(
    'empty list with Create' => array(array(), $all, null),
    'missing status without Create' => array(array(clone $record), array('Purchase_Order.Manage', 'Purchase_Order.View'), '-'),
    'missing status with all actions' => array(array(clone $record), $all, '-'),
    'existing status' => array(array((object) array_merge((array) $record, array('status' => 'OPN'))), $all, 'OPN'),
    'null status with View only' => array(array((object) array_merge((array) $record, array('status' => null))), array('Purchase_Order.View'), '-'),
    'zero status without actions' => array(array((object) array_merge((array) $record, array('status' => '0'))), array(), '0'),
    'freight already planned' => array(array((object) array_merge((array) $record, array('status' => '', 'rencana_bayar_idr' => '1'))), $all, '')
);

set_error_handler(function ($severity, $message, $file, $line) {
    if (error_reporting() & $severity) {
        throw new ErrorException($message, 0, $severity, $file, $line);
    }
    return false;
});
$failed = 0;
try {
    foreach ($cases as $name => $case) {
        try {
            list($results, $GLOBALS['incoming_permissions'], $expectedStatus) = $case;
            $html = render_incoming_index($results);
            $dom = new DOMDocument();
            $dom->loadHTML($html, LIBXML_NOERROR | LIBXML_NOWARNING);
            $xpath = new DOMXPath($dom);
            $rows = count($results);
            foreach (array(
                '//a[@title="Add"]' => (int) has_permission('Purchase_Order.Add'),
                '//a[@title="Add" and @href="/incoming/add"]' => (int) has_permission('Purchase_Order.Add'),
                '//table[@id="example1"]/tbody/tr' => $rows,
                '//table[@id="example1"]/tbody/tr/td[2][text()="IC-TEST"]' => $rows,
                '//a[@title="View" and @data-id_data="IC_TEST"]' => $rows * (int) has_permission('Purchase_Order.View'),
                '//a[@title="Print" and @href="/incoming/print_incoming_fix/IC_TEST"]' => $rows * (int) has_permission('Purchase_Order.Manage'),
                '//a[@title="Add Freight Cost" and @href="/incoming/biaya_logistik/IC_TEST"]' => $rows * (int) ($rows > 0 && has_permission('Purchase_Order.Manage') && $results[0]->rencana_bayar_idr === '0')
            ) as $query => $expectedCount) {
                if ($xpath->query($query)->length !== $expectedCount) {
                    throw new RuntimeException('Unexpected incoming controls: ' . $query);
                }
            }
            if ($rows && $xpath->evaluate('string(//table[@id="example1"]/tbody/tr/td[5])') !== $expectedStatus) {
                throw new RuntimeException('Unexpected incoming status');
            }
            if (!str_ends_with(trim($html), '</script>')) {
                throw new RuntimeException('Incoming view render interrupted');
            }
            echo 'PASS: ' . $name . PHP_EOL;
        } catch (Throwable $e) {
            $failed++;
            echo 'FAIL: ' . $name . ': ' . $e->getMessage() . PHP_EOL;
        }
    }
} finally { restore_error_handler(); }
echo count($cases) . ' cases; ' . $failed . ' failures' . PHP_EOL;
exit($failed ? 1 : 0);
