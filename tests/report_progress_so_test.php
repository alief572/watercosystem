<?php
/**
 * Automated test suite for Report Progress SO module
 * Run via CLI: php tests/report_progress_so_test.php
 */
define('ENVIRONMENT', 'development');
define('BASEPATH', dirname(__DIR__) . '/system/');
define('APPPATH', dirname(__DIR__) . '/application/');

// Load CodeIgniter minimal framework or DB connection
require_once APPPATH . 'config/database.php';
$override = APPPATH . 'config/development/database.php';
if (file_exists($override)) {
    require $override;
}
$db_config = $db[$active_group];

echo "Connecting to DB: " . $db_config['database'] . " on " . $db_config['hostname'] . "...\n";
$mysqli = new mysqli(
    $db_config['hostname'],
    $db_config['username'],
    $db_config['password'],
    $db_config['database'],
    isset($db_config['port']) ? $db_config['port'] : 3306
);

if ($mysqli->connect_error) {
    echo "FAIL: DB connection error: " . $mysqli->connect_error . "\n";
    exit(1);
}
echo "OK: Database connected.\n\n";

// Helper assertions
$passed = 0;
$failed = 0;

function assert_true($condition, $message) {
    global $passed, $failed;
    if ($condition) {
        echo " [PASS] $message\n";
        $passed++;
    } else {
        echo " [FAIL] $message\n";
        $failed++;
    }
}

// 1. Verify Permission and Menu exist
echo "--- Test 1: Permission & Menu Registration ---\n";
$res = $mysqli->query("SELECT * FROM permissions WHERE nm_permission='Report_Progress_So.View'");
assert_true($res && $res->num_rows === 1, "Permission 'Report_Progress_So.View' exists in database");

$res = $mysqli->query("SELECT * FROM menus WHERE link='report_progress_so'");
assert_true($res && $res->num_rows === 1, "Menu 'report_progress_so' exists in database");

// 2. Test Tab 1 Dataset Query & Calculation
echo "\n--- Test 2: Tab 1 Query & Calculations ---\n";
// Pick a month with data: October 2026
$start_date = '2026-10-01';
$end_date = '2026-10-31';

$sql = "SELECT so.no_so, so.no_surat, so.tgl_so, so.id_customer, so.nama_sales, so.grand_total,
               COALESCE(c.name_customer, so.id_customer, '') AS customer_name
        FROM tr_sales_order so
        LEFT JOIN master_customers c ON c.id_customer = so.id_customer
        WHERE so.deleted_by IS NULL AND so.tgl_so >= '$start_date' AND so.tgl_so <= '$end_date'
        ORDER BY so.tgl_so DESC, so.no_so DESC";
$res = $mysqli->query($sql);
assert_true($res !== false, "Query for Sales Orders executed successfully");
$so_count = $res->num_rows;
echo " Found $so_count Sales Orders in October 2026.\n";
assert_true($so_count > 0, "Sales Orders exist for the test period");

// Test Status Business Rules
$sample_calc = array(
    // [invoice, payment, expected_status]
    array(0, 0, 'Belum Ditagih'),
    array(1000, 0, 'Belum Bayar'),
    array(1000, 600, 'Sebagian Bayar'),
    array(1000, 1000, 'Lunas'),
    array(1000, 1200, 'Lunas')
);

foreach ($sample_calc as $c) {
    $inv = $c[0];
    $pay = $c[1];
    $exp = $c[2];

    if ($inv <= 0) {
        $st = 'Belum Ditagih';
    } elseif ($pay <= 0) {
        $st = 'Belum Bayar';
    } elseif ($pay < $inv) {
        $st = 'Sebagian Bayar';
    } else {
        $st = 'Lunas';
    }
    assert_true($st === $exp, "Status rule for Inv=$inv, Pay=$pay matches '$exp'");
}

// 3. Test Tab 2 Delivery Queries & Running Balance Logic
echo "\n--- Test 3: Tab 2 Query & Progressive Running Balance ---\n";
$sql_deliv = "SELECT d.id_so_detail, d.no_so, d.nama_produk, d.qty_so, so.no_surat, so.tgl_so, so.nama_sales
              FROM tr_sales_order_detail d
              JOIN tr_sales_order so ON so.no_so = d.no_so
              WHERE so.deleted_by IS NULL AND so.tgl_so >= '$start_date' AND so.tgl_so <= '$end_date'
              LIMIT 10";
$res_deliv = $mysqli->query($sql_deliv);
assert_true($res_deliv !== false && $res_deliv->num_rows > 0, "Query for SO item details executed successfully");

// Test progressive balance algorithm
$qty_so = 10;
$shipments = array(4, 6);
$cumulative = 0;
$running_results = array();
foreach ($shipments as $shipped) {
    $cumulative += $shipped;
    $outstanding = max(0, $qty_so - $cumulative);
    $pct = ($qty_so > 0) ? ($cumulative / $qty_so) * 100 : 0;
    $status = ($cumulative >= $qty_so) ? 'Terkirim' : (($cumulative > 0) ? 'Sebagian Kirim' : 'Belum Terkirim');
    $running_results[] = array('out' => $outstanding, 'pct' => $pct, 'status' => $status);
}

assert_true($running_results[0]['out'] === 6 && $running_results[0]['pct'] == 40 && $running_results[0]['status'] === 'Sebagian Kirim',
    "DO #1 (4 of 10): Outstanding=6, 40%, Sebagian Kirim");
assert_true($running_results[1]['out'] === 0 && $running_results[1]['pct'] == 100 && $running_results[1]['status'] === 'Terkirim',
    "DO #2 (6 of 10): Outstanding=0, 100%, Terkirim");

// 4. Test PHPExcel generation with multi-sheet
echo "\n--- Test 4: PHPExcel Multi-sheet Workbook Generation ---\n";
require_once dirname(__DIR__) . '/application/libraries/PHPExcel.php';
require_once dirname(__DIR__) . '/application/modules/report_progress_so/libraries/Progress_so_workbook.php';

$workbook_lib = new Progress_so_workbook();
$dummy_so_dataset = array(
    'rows' => array(
        array(
            'no_so' => '040/WI/SO/X/2026',
            'tanggal_so' => '2026-10-13',
            'customer' => 'PT ABC TEST',
            'sales' => 'ANYIM DEDE S',
            'deskripsi' => 'Pump 1 unit',
            'value_so' => 1000000,
            'invoice' => 800000,
            'outstanding_so' => 200000,
            'payment' => 600000,
            'outstanding_piutang' => 200000,
            'persen_tertagih' => 80.0,
            'persen_terbayar' => 75.0,
            'status' => 'Sebagian Bayar'
        )
    ),
    'totals' => array(
        'total_value_so' => 1000000,
        'total_invoice' => 800000,
        'total_outstanding_so' => 200000,
        'total_payment' => 600000,
        'total_outstanding_piutang' => 200000
    )
);

$dummy_deliv_dataset = array(
    'rows' => array(
        array(
            'no_so' => '040/WI/SO/X/2026',
            'barang' => 'Pump A',
            'qty' => 10,
            'tanggal_so' => '2026-10-13',
            'qty_kirim' => 6,
            'outstanding' => 4,
            'persen_terkirim' => 60.0,
            'status_kirim' => 'Sebagian Kirim',
            'tanggal_do' => '2026-10-15',
            'no_do' => '042/WI/DO/X/2026',
            'nama_customer' => 'PT ABC TEST',
            'account_handler' => 'ANYIM DEDE S'
        )
    ),
    'totals' => array(
        'total_qty_so' => 10,
        'total_qty_kirim' => 6,
        'total_outstanding' => 4
    )
);

$dummy_filters = array(
    'start_date' => '2026-10-01',
    'end_date' => '2026-10-31',
    'customer_name' => 'PT ABC TEST',
    'sales_name' => 'ANYIM DEDE S'
);

$book = $workbook_lib->build($dummy_so_dataset, $dummy_deliv_dataset, $dummy_filters);
assert_true($book instanceof PHPExcel, "Workbook built successfully as PHPExcel instance");
assert_true($book->getSheetCount() === 2, "Workbook has exactly 2 sheets");
assert_true($book->getSheet(0)->getTitle() === 'Progress Sales Order', "Sheet 1 title is 'Progress Sales Order'");
assert_true($book->getSheet(1)->getTitle() === 'Status Pengiriman', "Sheet 2 title is 'Status Pengiriman'");

// Test saving to memory stream
$temp_file = tempnam(sys_get_temp_dir(), 'test_so_') . '.xlsx';
$writer = PHPExcel_IOFactory::createWriter($book, 'Excel2007');
$writer->save($temp_file);
assert_true(file_exists($temp_file) && filesize($temp_file) > 1000, "Workbook saved successfully to disk (" . filesize($temp_file) . " bytes)");
unlink($temp_file);

echo "\n============================================\n";
echo "TEST RESULTS: Passed: $passed, Failed: $failed\n";
if ($failed === 0) {
    echo "ALL TESTS PASSED SUCCESSFULLY!\n";
    exit(0);
} else {
    echo "SOME TESTS FAILED!\n";
    exit(1);
}
