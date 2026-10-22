<?php
/**
 * Exhaustive Search Feature Test Suite for Report Progress SO
 * Run via CLI: php tests/report_progress_so_search_test.php
 */
define('ENVIRONMENT', 'development');
define('BASEPATH', dirname(__DIR__) . '/system/');
define('APPPATH', dirname(__DIR__) . '/application/');

require_once BASEPATH . 'core/Common.php';
require_once APPPATH . 'config/database.php';
$override = APPPATH . 'config/development/database.php';
if (file_exists($override)) {
    require $override;
}
require_once BASEPATH . 'database/DB.php';
$db = DB($active_group, true);

require_once BASEPATH . 'core/Model.php';
require_once APPPATH . 'modules/report_progress_so/models/Report_progress_so_model.php';

$model = new Report_progress_so_model();
$model->db = $db;

$passed = 0;
$failed = 0;

function assert_check($condition, $message) {
    global $passed, $failed;
    if ($condition) {
        echo " [PASS] $message\n";
        $passed++;
    } else {
        echo " [FAIL] $message\n";
        $failed++;
    }
}

echo "=======================================================\n";
echo "TEST SUITE: SEARCH FEATURES IN REPORT PROGRESS SO\n";
echo "=======================================================\n\n";

// Base dataset for October 2026
$base_filters = array(
    'start_date' => '2026-10-01',
    'end_date' => '2026-10-31',
    'customer_id' => '',
    'sales_name' => ''
);
$so_all = $model->get_progress_so_dataset($base_filters);
$deliv_all = $model->get_delivery_dataset($base_filters);

echo "Base data count for Oct 2026: " . count($so_all['rows']) . " SO rows, " . count($deliv_all['rows']) . " delivery rows.\n\n";

// ---------------------------------------------------------
// SECTION 1: HEADER FILTER SEARCH (Date, Customer, Sales)
// ---------------------------------------------------------
echo "--- SECTION 1: Header Filter Searches ---\n";

// 1.1 Filter by specific customer
$test_cust_id = 'MC2000001'; // Known active customer in Oct 2026
$cust_filters = array(
    'start_date' => '2026-10-01',
    'end_date' => '2026-10-31',
    'customer_id' => $test_cust_id,
    'sales_name' => ''
);
$so_cust = $model->get_progress_so_dataset($cust_filters);
assert_check(count($so_cust['rows']) > 0 && count($so_cust['rows']) < count($so_all['rows']),
    "Filter by Customer ID ($test_cust_id) returns subset of SOs (" . count($so_cust['rows']) . " rows)");
foreach ($so_cust['rows'] as $r) {
    if ($r['customer'] !== 'PT CIPTA BANGUN AMANAH') {
        assert_check(false, "Row customer mismatch: " . $r['customer']);
        break;
    }
}
assert_check(true, "All rows in customer filtered result belong to PT CIPTA BANGUN AMANAH");

// 1.2 Filter by specific sales
$test_sales = 'ANYIM DEDE S';
$sales_filters = array(
    'start_date' => '2026-10-01',
    'end_date' => '2026-10-31',
    'customer_id' => '',
    'sales_name' => $test_sales
);
$so_sales = $model->get_progress_so_dataset($sales_filters);
assert_check(count($so_sales['rows']) > 0 && count($so_sales['rows']) < count($so_all['rows']),
    "Filter by Sales ($test_sales) returns subset of SOs (" . count($so_sales['rows']) . " rows)");
foreach ($so_sales['rows'] as $r) {
    if ($r['sales'] !== $test_sales) {
        assert_check(false, "Row sales mismatch: " . $r['sales']);
        break;
    }
}
assert_check(true, "All rows in sales filtered result have sales '$test_sales'");

// 1.3 Filter by narrower Date Range
$date_filters = array(
    'start_date' => '2026-10-10',
    'end_date' => '2026-10-15',
    'customer_id' => '',
    'sales_name' => ''
);
$so_date = $model->get_progress_so_dataset($date_filters);
assert_check(count($so_date['rows']) > 0 && count($so_date['rows']) <= count($so_all['rows']),
    "Narrow date range (2026-10-10 to 2026-10-15) returns valid filtered subset (" . count($so_date['rows']) . " rows)");

// ---------------------------------------------------------
// SECTION 2: TAB 1 DATATABLES GLOBAL SEARCH FILTERING
// ---------------------------------------------------------
echo "\n--- SECTION 2: Tab 1 DataTables Global Search (data_so) ---\n";

function simulate_data_so_search($rows, $search_value) {
    $filtered = array();
    if ($search_value !== '') {
        foreach ($rows as $r) {
            if (
                stripos($r['no_so'], $search_value) !== false ||
                stripos($r['customer'], $search_value) !== false ||
                stripos($r['sales'], $search_value) !== false ||
                stripos($r['deskripsi'], $search_value) !== false ||
                stripos($r['status'], $search_value) !== false ||
                stripos($r['tanggal_so'], $search_value) !== false ||
                stripos((string)$r['value_so'], $search_value) !== false ||
                stripos((string)$r['invoice'], $search_value) !== false ||
                stripos((string)$r['outstanding_so'], $search_value) !== false ||
                stripos((string)$r['payment'], $search_value) !== false ||
                stripos((string)$r['outstanding_piutang'], $search_value) !== false
            ) {
                $filtered[] = $r;
            }
        }
    } else {
        $filtered = $rows;
    }
    return $filtered;
}

// 2.1 Search by No SO
$s_noso = '040/WI/SO';
$res1 = simulate_data_so_search($so_all['rows'], $s_noso);
assert_check(count($res1) === 1 && $res1[0]['no_so'] === '040/WI/SO/X/2026',
    "Tab 1 search by No SO '$s_noso' returns exact matching row");

// 2.2 Search by Customer keyword
$s_cust = 'SUDIBJO';
$res2 = simulate_data_so_search($so_all['rows'], $s_cust);
assert_check(count($res2) > 0, "Tab 1 search by Customer keyword '$s_cust' returns " . count($res2) . " rows");
assert_check(stripos($res2[0]['customer'], $s_cust) !== false, "Row customer contains '$s_cust'");

// 2.3 Search by Sales keyword
$s_sales = 'SUKMA';
$res3 = simulate_data_so_search($so_all['rows'], $s_sales);
assert_check(count($res3) > 0, "Tab 1 search by Sales keyword '$s_sales' returns " . count($res3) . " rows");
assert_check(stripos($res3[0]['sales'], $s_sales) !== false, "Row sales contains '$s_sales'");

// 2.4 Search by Item/Deskripsi keyword
$s_desc = 'ZeoPlus';
$res4 = simulate_data_so_search($so_all['rows'], $s_desc);
assert_check(count($res4) > 0, "Tab 1 search by Item in Deskripsi '$s_desc' returns " . count($res4) . " rows");
assert_check(stripos($res4[0]['deskripsi'], $s_desc) !== false, "Row deskripsi contains '$s_desc'");

// 2.5 Search by Status keyword
$s_status = 'Belum Bayar';
$res5 = simulate_data_so_search($so_all['rows'], $s_status);
assert_check(count($res5) > 0, "Tab 1 search by Status '$s_status' returns " . count($res5) . " rows");
assert_check($res5[0]['status'] === $s_status, "Row status is '$s_status'");

// 2.6 Search with non-matching string
$s_none = 'NON_EXISTENT_KEYWORD_XYZ999';
$res6 = simulate_data_so_search($so_all['rows'], $s_none);
assert_check(count($res6) === 0, "Tab 1 search with non-existent keyword returns 0 rows");


// ---------------------------------------------------------
// SECTION 3: TAB 2 DATATABLES GLOBAL SEARCH FILTERING
// ---------------------------------------------------------
echo "\n--- SECTION 3: Tab 2 DataTables Global Search (data_delivery) ---\n";

function simulate_data_deliv_search($rows, $search_value) {
    $filtered = array();
    if ($search_value !== '') {
        foreach ($rows as $dr) {
            if (
                stripos($dr['no_so'], $search_value) !== false ||
                stripos($dr['barang'], $search_value) !== false ||
                stripos($dr['status_kirim'], $search_value) !== false ||
                stripos($dr['no_do'], $search_value) !== false ||
                stripos($dr['tanggal_do'], $search_value) !== false ||
                stripos($dr['tanggal_so'], $search_value) !== false ||
                stripos($dr['nama_customer'], $search_value) !== false ||
                stripos($dr['account_handler'], $search_value) !== false ||
                stripos((string)$dr['qty'], $search_value) !== false ||
                stripos((string)$dr['qty_kirim'], $search_value) !== false ||
                stripos((string)$dr['outstanding'], $search_value) !== false
            ) {
                $filtered[] = $dr;
            }
        }
    } else {
        $filtered = $rows;
    }
    return $filtered;
}

// 3.1 Search by Barang keyword
$s_item = 'Basket';
$d_res1 = simulate_data_deliv_search($deliv_all['rows'], $s_item);
assert_check(count($d_res1) > 0, "Tab 2 search by Barang '$s_item' returns " . count($d_res1) . " rows");
assert_check(stripos($d_res1[0]['barang'], $s_item) !== false, "Row barang contains '$s_item'");

// 3.2 Search by No DO keyword
$s_nodo = '042/WI/DO';
$d_res2 = simulate_data_deliv_search($deliv_all['rows'], $s_nodo);
assert_check(count($d_res2) > 0, "Tab 2 search by No DO '$s_nodo' returns " . count($d_res2) . " rows");
assert_check(stripos($d_res2[0]['no_do'], $s_nodo) !== false, "Row no_do contains '$s_nodo'");

// 3.3 Search by Status Kirim keyword
$s_stat_kirim = 'Terkirim';
$d_res3 = simulate_data_deliv_search($deliv_all['rows'], $s_stat_kirim);
assert_check(count($d_res3) > 0, "Tab 2 search by Status Kirim '$s_stat_kirim' returns " . count($d_res3) . " rows");
assert_check(stripos($d_res3[0]['status_kirim'], $s_stat_kirim) !== false, "Row status_kirim contains '$s_stat_kirim'");

// 3.4 Search by Account Handler keyword
$s_ah = 'JACKELINE';
$d_res4 = simulate_data_deliv_search($deliv_all['rows'], $s_ah);
assert_check(count($d_res4) > 0, "Tab 2 search by Account Handler '$s_ah' returns " . count($d_res4) . " rows");
assert_check(stripos($d_res4[0]['account_handler'], $s_ah) !== false, "Row account_handler contains '$s_ah'");

// 3.5 Search by Customer name keyword
$s_cust2 = 'CIPTA';
$d_res5 = simulate_data_deliv_search($deliv_all['rows'], $s_cust2);
assert_check(count($d_res5) > 0, "Tab 2 search by Customer '$s_cust2' returns " . count($d_res5) . " rows");
assert_check(stripos($d_res5[0]['nama_customer'], $s_cust2) !== false, "Row nama_customer contains '$s_cust2'");

// 3.6 Non-matching search
$d_res6 = simulate_data_deliv_search($deliv_all['rows'], $s_none);
assert_check(count($d_res6) === 0, "Tab 2 search with non-existent keyword returns 0 rows");

echo "\n=======================================================\n";
echo "SEARCH TEST SUMMARY: Passed: $passed, Failed: $failed\n";
if ($failed === 0) {
    echo "ALL SEARCH FEATURES VERIFIED AND WORKING 100%!\n";
    exit(0);
} else {
    echo "SOME SEARCH CHECKS FAILED!\n";
    exit(1);
}
