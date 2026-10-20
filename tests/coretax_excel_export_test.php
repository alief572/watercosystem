<?php
if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}

$root = dirname(__DIR__);
define('BASEPATH', $root . '/system/');
define('APPPATH', $root . '/application/');
date_default_timezone_set('Asia/Jakarta');

if (in_array('--export', $argv, true)) {
    class Admin_Controller {}
    class Coretax_fixture_model
    {
        public function get_export_coretax_data($invoices)
        {
            $data = array();
            foreach (array('2026-08-21', '2026-08-24 15:30:00', '2028-02-29', '2026-01-05') as $index => $date) {
                $data[] = array(
                    'header' => array(
                        'tgl_invoice' => $date, 'facility' => '', 'npwp' => '1234567890123456',
                        'npwp_name' => 'Test Customer', 'npwp_address' => 'Test Address',
                        'email' => '', 'no_surat' => 'TEST-' . ($index + 1), 'no_invoice' => 'INV-' . ($index + 1),
                        'total' => 1200, 'diskon' => 0, 'dpp' => 1100, 'nilai_ppn' => 132
                    ),
                    'details' => $index === 0 ? array(array(
                        'qty_invoice' => 2, 'harga_satuan' => 600, 'nilai_diskon' => 0,
                        'diskon' => 0, 'nama_produk' => 'Test Product'
                    )) : array()
                );
            }
            return $data;
        }
    }
    require APPPATH . 'modules/wt_invoicing/controllers/Wt_invoicing.php';
    $class = new ReflectionClass('Wt_invoicing');
    $controller = $class->newInstanceWithoutConstructor();
    $controller->Wt_invoicing_model = new Coretax_fixture_model();
    $method = $class->getMethod('_generate_coretax_spreadsheet');
    $method->setAccessible(true);
    $method->invoke($controller, array('TEST'), 'TEST-BATCH');
    exit;
}

require APPPATH . 'libraries/PHPExcel.php';
PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);
function check($condition, $message)
{
    if (!$condition) {
        throw new RuntimeException($message);
    }
}

$file = tempnam(sys_get_temp_dir(), 'coretax-test-');
try {
    // The download method exits after writing XLSX, so run it in a separate process.
    $command = escapeshellarg(PHP_BINARY) . ' ' . escapeshellarg(__FILE__) . ' --export > ' . escapeshellarg($file);
    exec($command, $output, $status);
    check($status === 0 && filesize($file) > 0, 'Export did not produce an XLSX file');
    $workbook = PHPExcel_IOFactory::load($file);
    check($workbook->getSheetNames() === array('Faktur', 'DetailFaktur'), 'Export sheet names changed');
    $faktur = $workbook->getSheetByName('Faktur');
    foreach (array(4 => '21/08/2026', 5 => '24/08/2026', 6 => '29/02/2028', 7 => '05/01/2026') as $row => $expected) {
        $cell = $faktur->getCell('B' . $row);
        check($cell->getDataType() === PHPExcel_Cell_DataType::TYPE_STRING,
            'Faktur!B' . $row . ' must be text, not an Excel serial number; got ' . $cell->getDataType());
        check($cell->getValue() === $expected, 'Incorrect invoice date at B' . $row);
        check($cell->getFormattedValue() === $expected, 'Incorrect visible invoice date at B' . $row);
        check($faktur->getCell('H' . $row)->getValue() === 'TEST-' . ($row - 3), 'Invoice reference changed');
    }
    check($faktur->getCell('A8')->getValue() === 'END', 'Missing END marker');
    check($faktur->getCell('C1')->getValue() === '0024144743056000', 'Seller identifier lost leading zeros');
    check($faktur->getCell('D4')->getValue() === '04', 'Transaction code lost leading zero');
    $detail = $workbook->getSheetByName('DetailFaktur');
    check($detail->getCell('D2')->getValue() === 'Test Product', 'Product detail missing');
    check($detail->getCell('G2')->getValue() == 2, 'Product quantity changed');
    check($detail->getCell('F2')->getDataType() === PHPExcel_Cell_DataType::TYPE_NUMERIC, 'Price must remain numeric');
    check($detail->getCell('D3')->getValue() === 'Penjualan Barang / Tagihan TEST-2', 'Invoice fallback detail changed');
    echo "PASS: exported XLSX dates are text with dd/mm/yyyy values; datetime, leap day, leading zeros, sheets and details verified.\n";
} finally {
    unlink($file);
}
