<?php
/** php tests/report_piutang_invoice_test.php [--database] */
if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}
$root = dirname(__DIR__);
define('BASEPATH', $root . '/system/');
define('APPPATH', $root . '/application/');
define('ENVIRONMENT', 'development');
require APPPATH . 'modules/report_piutang_invoice/libraries/Piutang_invoice_dataset.php';
require APPPATH . 'libraries/PHPExcel.php';
require APPPATH . 'modules/report_piutang_invoice/libraries/Piutang_invoice_workbook.php';
function expect($condition, $message)
{
    if (!$condition) {
        throw new RuntimeException($message);
    }
}
function invoice_fixture($key, $amount, $extra = array())
{
    return array_merge(array('no_invoice' => $key, 'no_surat' => 'INV-' . $key, 'customer' => 'Customer', 'nilai_invoice' => $amount,
        'tgl_invoice' => '2026-09-01', 'printed_on' => '2026-09-02 10:00:00', 'deleted_by' => null), $extra);
}
function payment_fixture($invoice, $code, $amount, $date = '2026-09-10', $extra = array())
{
    return array_merge(array('no_invoice' => $invoice, 'kd_pembayaran' => $code, 'total_bayar_idr' => $amount,
        'tgl_pembayaran' => $date, 'header_id' => 1), $extra);
}
$calculator = new Piutang_invoice_dataset();
$dated = $calculator->build(array(
    invoice_fixture('OLD', 1000, array('customer' => 'AAA', 'tgl_invoice' => '2026-08-01')),
    invoice_fixture('NEW', 1000, array('customer' => 'ZZZ', 'tgl_invoice' => '2026-09-28')),
    invoice_fixture('MID', 1000, array('customer' => 'BBB', 'tgl_invoice' => '2026-09-15'))
), array(), array(), '2026-09-28');
expect($dated['invoices'][0]['no_invoice'] === 'NEW' && $dated['invoices'][1]['no_invoice'] === 'MID'
    && $dated['invoices'][2]['no_invoice'] === 'OLD', 'Invoices must be newest first across customers');
$invoices = array(
    invoice_fixture('A', 1000), invoice_fixture('B', 1000), invoice_fixture('C', 1000),
    invoice_fixture('D', 1000), invoice_fixture('E', 1000), invoice_fixture('F', 1000),
    invoice_fixture('G', 1000), invoice_fixture('H', 1000), invoice_fixture('I', 100.49),
    invoice_fixture('DRAFT', 1000, array('printed_on' => null)),
    invoice_fixture('ZERO_PRINT', 1000, array('printed_on' => '0000-00-00 00:00:00')),
    invoice_fixture('DELETED', 1000, array('deleted_by' => '7')),
    invoice_fixture('FUTURE', 1000, array('tgl_invoice' => '2026-10-01')),
    invoice_fixture('PRE_2024', 1000, array('tgl_invoice' => '2023-12-31'))
);
$details = array(
    payment_fixture('B', 'PN-02', 100, '2026-09-28'),
    payment_fixture('B', 'PN-01', 100.49, '2026-08-01'),
    payment_fixture('B', 'PN-01', 100.50, '2026-08-01'),
    payment_fixture('B', 'PN-03', 699, '2026-09-29'),
    payment_fixture('C', 'PN-01', 1000), payment_fixture('D', 'PN-04', 1100),
    payment_fixture('E', 'PN-MISSING', 100, null, array('header_id' => null)),
    payment_fixture('F', 'PN-INVALID', 100, '2026-02-30'),
    payment_fixture('G', 'PN-CANCEL', 1000, '2026-09-10', array('status_bayar' => 'CANCEL')),
    payment_fixture('G', 'PN-CANCEL2', 1000, '2026-09-10', array('is_cancel' => 'Y')),
    payment_fixture('G', 'PN-CANCEL3', 1000, '2026-09-10', array('cancel_by' => '1')),
    payment_fixture('H', 'PN-01', 200, '2026-08-01', array('status_jurnal' => '0')),
    payment_fixture('I', 'PN-ROUND', 100)
);
$orphans = array(
    payment_fixture('MISSING', 'PN-ORPHAN', 100, '2026-09-01', array('customer' => 'Legacy')),
    payment_fixture('MISSING_OLD', 'PN-ORPHAN-OLD', 100, '2023-11-01', array('customer' => 'Pre2024Legacy'))
);
$report = $calculator->build($invoices, $details, $orphans, '2026-09-28');
$by_key = array();
foreach ($report['invoices'] as $invoice) {
    $by_key[$invoice['no_invoice']] = $invoice;
}
expect(array_keys($by_key) === array('A', 'B', 'G', 'H'), 'Eligibility, fully paid, overpaid or rounded balances incorrect');
expect(!isset($by_key['PRE_2024']), 'Pre-2024 invoice must be excluded');
expect($by_key['A']['payments'] === array(), 'Unpaid invoice must have no payment rows');
expect($by_key['B']['payments'][0]['nilai_bayar'] === 201.0, 'Round each allocation before combining');
expect($by_key['B']['payments'][1]['total_bayar'] === 301.0, 'Running total or inclusive cutoff incorrect');
expect($by_key['B']['sisa_piutang'] === 699.0, 'Historical outstanding incorrect');
expect($by_key['H']['sisa_piutang'] === 800.0, 'Multi invoice allocation / unapproved payment incorrect');
expect($report['total_piutang'] === 3499.0, 'Grand total counts invoice more than once');
expect($report['verification_invoice_count'] === 2 && count($report['verification']) === 3, 'Verification separation incorrect');
expect(!Piutang_invoice_dataset::valid_date('2026-02-30') && Piutang_invoice_dataset::valid_date('2024-02-29'), 'Date validation incorrect');
$now = $calculator->build($invoices, $details, array(), '2026-09-30');
foreach ($now['invoices'] as $invoice) {
    expect($invoice['no_invoice'] !== 'B', 'Invoice paid after historical cutoff must disappear when fully paid');
}
$filters = array('tanggal' => '2026-09-28', 'customer_id' => '', 'no_invoice' => '');
$report['invoices'][0]['customer'] = '=1+1 <script>test</script>';
$book = (new Piutang_invoice_workbook())->build($report, $filters);
expect($book->getActiveSheet()->getCell('A5')->getDataType() === PHPExcel_Cell_DataType::TYPE_STRING, 'Untrusted text interpreted as Excel formula');
expect($book->getActiveSheet()->getCell('D5')->getDataType() === PHPExcel_Cell_DataType::TYPE_NUMERIC, 'Amounts must be numeric cells');
expect($book->getSheetCount() === 2, 'Missing verification sheet');
$artifact = tempnam(sys_get_temp_dir(), 'piutang_');
PHPExcel_IOFactory::createWriter($book, 'Excel2007')->save($artifact);
$loaded = PHPExcel_IOFactory::load($artifact);
expect($loaded->getSheet(0)->getCell('A5')->getValue() === '=1+1 <script>test</script>', 'Workbook round trip corrupted text');
expect($loaded->getSheet(1)->getCell('D5')->getValue() === 'PN-MISSING', 'Workbook verification contents incorrect');
unlink($artifact);
$book->disconnectWorksheets();
$loaded->disconnectWorksheets();
echo "PASS: calculation, eligibility, dates, cancellation, grouping, rounding, verification and XLSX round trip.\n";

if (in_array('--database', $argv, true)) {
    // Use the real query builder and model, without booting login/session or writing fixtures.
    function log_message($level, $message) {}
    function is_php($version) { return version_compare(PHP_VERSION, $version, '>='); }
    function show_error($message) { throw new RuntimeException(is_array($message) ? implode(' ', $message) : $message); }
    class CI_Model {}
    class Report_test_loader { public function library($name) {} }
    require BASEPATH . 'database/DB.php';
    require APPPATH . 'config/database.php';
    require APPPATH . 'config/development/database.php';
    $settings = $db[$active_group];
    $settings['db_debug'] = false;
    $settings['save_queries'] = true;
    $database = DB($settings, true);
    if (!$database->conn_id) {
        throw new RuntimeException('Cannot connect to development database.');
    }
    require APPPATH . 'modules/report_piutang_invoice/models/Report_piutang_invoice_model.php';
    $model = new Report_piutang_invoice_model();
    $model->db = $database;
    $model->load = new Report_test_loader();
    $model->piutang_invoice_dataset = $calculator;
    $start = microtime(true);
    $live = $model->dataset($filters);
    echo 'Database baseline: ' . json_encode(array('invoice_count' => $live['invoice_count'], 'total_piutang' => $live['total_piutang'],
        'verification_invoice_count' => $live['verification_invoice_count'], 'verification_rows' => count($live['verification']),
        'queries' => count($database->queries), 'seconds' => round(microtime(true) - $start, 3))) . "\n";
    foreach ($database->queries as $sql) {
        expect((bool) preg_match('/^SELECT\b/i', ltrim($sql)), 'Integration check attempted a non-SELECT query');
    }
    // MySQL ROUND on DOUBLE uses platform-dependent tie rounding. Cast to exact DECIMAL
    // for an independent half-up reference matching the report's explicit rounding rule.
    $reference = $database->query("SELECT COUNT(*) invoice_count, SUM(ROUND(CAST(i.nilai_invoice AS DECIMAL(50,2)),0)-COALESCE(d.paid,0)) total_piutang
        FROM tr_invoice i
        LEFT JOIN (SELECT d.no_invoice, SUM(ROUND(d.total_bayar_idr,0)) paid
            FROM tr_invoice_payment_detail d JOIN tr_invoice_payment p ON p.kd_pembayaran=d.kd_pembayaran
            WHERE p.tgl_pembayaran<='2026-09-28' GROUP BY d.no_invoice) d ON d.no_invoice=i.no_invoice
        LEFT JOIN (SELECT d.no_invoice FROM tr_invoice_payment_detail d LEFT JOIN tr_invoice_payment p ON p.kd_pembayaran=d.kd_pembayaran
            WHERE p.id IS NULL GROUP BY d.no_invoice) bad ON bad.no_invoice=i.no_invoice
        WHERE i.deleted_by IS NULL AND i.printed_on>='1000-01-01 00:00:00' AND i.tgl_invoice>='2024-01-01' AND i.tgl_invoice<='2026-09-28'
        AND bad.no_invoice IS NULL AND ROUND(CAST(i.nilai_invoice AS DECIMAL(50,2)),0)-COALESCE(d.paid,0)>0")->row_array();
    expect($live['invoice_count'] === (int) $reference['invoice_count'] && $live['total_piutang'] === (float) $reference['total_piutang'], 'Report differs from independent DECIMAL SQL reference');
    expect($live['invoice_count'] === 47 && $live['total_piutang'] === 1235730545.0 && $live['verification_invoice_count'] === 0, 'Baseline changed; inspect source data before adjusting expected values');
    $live_book = (new Piutang_invoice_workbook())->build($live, $filters);
    $total_row = 5;
    foreach ($live['invoices'] as $invoice) {
        $total_row += max(1, count($invoice['payments']));
    }
    $live_file = tempnam(sys_get_temp_dir(), 'piutang_live_');
    PHPExcel_IOFactory::createWriter($live_book, 'Excel2007')->save($live_file);
    $live_loaded = PHPExcel_IOFactory::load($live_file);
    expect($live_loaded->getSheet(0)->getCell('I' . $total_row)->getValue() == $live['total_piutang'], 'Full Excel export total differs from dataset');
    expect((int) $live_loaded->getSheet(1)->getHighestRow() === 4 + count($live['verification']), 'Live verification export incomplete');
    foreach ($live['verification'] as $index => $issue) {
        expect($live_loaded->getSheet(1)->getCell('D' . (5 + $index))->getValue() === $issue['kd_pembayaran'], 'Live verification row differs from dataset');
    }
    unlink($live_file);
    $live_book->disconnectWorksheets();
    $live_loaded->disconnectWorksheets();
    $specific = $filters;
    $specific['no_invoice'] = $live['invoices'][0]['no_surat'];
    $specific['customer_id'] = $live['invoices'][0]['id_customer'];
    $filtered = $model->dataset($specific);
    expect($filtered['invoice_count'] >= 1, 'Customer and invoice filter failed');
    foreach ($filtered['invoices'] as $invoice) {
        expect($invoice['id_customer'] === $specific['customer_id'] && $invoice['no_surat'] === $specific['no_invoice'], 'Exact invoice filter leaked unrelated invoices');
    }
    foreach ($model->customers() as $customer) {
        expect(trim((string) $customer['name_customer']) !== '', 'Empty customer included in dropdown source');
    }
    $specific['no_invoice'] = "' OR 1=1 -- %_";
    expect($model->dataset($specific)['invoice_count'] === 0, 'Search escaping failed');
    echo "PASS: real model/query builder baseline, complete live XLSX, customer/search filters and read-only queries.\n";
}
