<?php
define('BASEPATH', dirname(__DIR__) . '/system/');
require dirname(__DIR__) . '/application/modules/report_progress_po/libraries/Progress_po_rules.php';
require dirname(__DIR__) . '/application/modules/report_progress_po/libraries/Progress_po_workbook.php';
if (!class_exists('ZipArchive')) { PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP); }

function workbook_check($condition, $message)
{
    if (!$condition) { throw new RuntimeException($message); }
    echo "PASS: $message\n";
}

$rules = new Progress_po_rules();
$filters = Progress_po_rules::filters(array('start_date' => '2026-10-01', 'end_date' => '2026-10-31'));
$po = array('no_po' => 'P1', 'no_surat' => '=HYPERLINK("unsafe")', 'tanggal' => '2026-10-01',
    'id_suplier' => 'S1', 'supplier' => 'Supplier', 'matauang' => 'USD', 'loi' => 'Import',
    'nominal_kurs' => 16250, 'status' => '2', 'note' => 'Barang');
$item = array('id_dt_po' => 'I1', 'qty' => 10, 'jumlahharga' => 10000,
    'diskon' => 0, 'close_po' => 'N', 'namamaterial' => 'Barang');
$row = $rules->calculate($po, array($item), array());
$rows = array_fill(0, 501, $row);
$data = array_merge(array('rows' => $rows, 'generated_at' => '2026-10-27 12:00:00'),
    $rules->summarize($rows, $filters['start_date'], $filters['end_date']));
$book = (new Progress_po_workbook())->build($data, $filters);
workbook_check($book instanceof PHPExcel, 'Workbook uses bundled PHPExcel without Composer');
workbook_check($book->getSheetNames() === array('Ringkasan', 'Data PO'), 'Both report sheets retained');
$sheet = $book->getSheet(1);
workbook_check((int) $sheet->getHighestRow() === 506, 'All 501 PO rows exported');
workbook_check($sheet->getCell('B6')->getDataType() === PHPExcel_Cell_DataType::TYPE_STRING
    && $sheet->getCell('B6')->getValue() === $po['no_surat'], 'Formula-like PO is literal text');
workbook_check($sheet->getCell('A6')->getDataType() === PHPExcel_Cell_DataType::TYPE_NUMERIC
    && $sheet->getStyle('A6')->getNumberFormat()->getFormatCode() === 'dd/mm/yyyy', 'Excel date remains numeric and formatted');
workbook_check(abs($sheet->getCell('M6')->getValue() - 162500000) < 0.01, 'IDR amount retained in correct column');
workbook_check($sheet->getCell('D6')->getValue() === null, 'Missing Incoming date remains blank');
$path = tempnam(sys_get_temp_dir(), 'progress-po-');
try {
    PHPExcel_IOFactory::createWriter($book, 'Excel2007')->save($path);
    $loaded = PHPExcel_IOFactory::load($path);
    workbook_check($loaded->getSheetCount() === 2 && (int) $loaded->getSheet(1)->getHighestRow() === 506,
        'XLSX serializes and reopens with all rows');
    workbook_check($loaded->getSheet(1)->getCell('B6')->getDataType() === PHPExcel_Cell_DataType::TYPE_STRING
        && $loaded->getSheet(1)->getCell('B6')->getValue() === $po['no_surat'], 'Literal PO text survives XLSX round trip');
    $loaded->disconnectWorksheets();
} finally {
    if (is_file($path)) { unlink($path); }
    $book->disconnectWorksheets();
}
