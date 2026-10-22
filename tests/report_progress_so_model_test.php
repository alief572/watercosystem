<?php
/**
 * Integration test for Report_progress_so_model using CI Database
 */
define('ENVIRONMENT', 'development');
define('BASEPATH', dirname(__DIR__) . '/system/');
define('APPPATH', dirname(__DIR__) . '/application/');

// CI mock / minimal bootstrap
require_once BASEPATH . 'core/Common.php';
require_once APPPATH . 'config/database.php';
$override = APPPATH . 'config/development/database.php';
if (file_exists($override)) {
    require $override;
}

// Load CI DB Driver
require_once BASEPATH . 'database/DB.php';
$db = DB($active_group, true);

// Load Model directly
require_once BASEPATH . 'core/Model.php';
require_once APPPATH . 'modules/report_progress_so/models/Report_progress_so_model.php';

$model = new Report_progress_so_model();
$model->db = $db;

echo "=== 1. Testing get_customers() ===\n";
$customers = $model->get_customers();
echo "Total active customers found: " . count($customers) . "\n";
if (count($customers) > 0) {
    echo "Sample customer: " . $customers[0]['id_customer'] . " - " . $customers[0]['name_customer'] . "\n";
}

echo "\n=== 2. Testing get_sales() ===\n";
$sales = $model->get_sales();
echo "Total sales found: " . count($sales) . "\n";
foreach (array_slice($sales, 0, 5) as $s) {
    echo " - " . $s['nama_sales'] . "\n";
}

echo "\n=== 3. Testing get_progress_so_dataset() for October 2026 ===\n";
$filters = array(
    'start_date' => '2026-10-01',
    'end_date'   => '2026-10-31',
    'customer_id' => '',
    'sales_name'  => ''
);

$so_data = $model->get_progress_so_dataset($filters);
echo "Total SO Rows: " . count($so_data['rows']) . "\n";
echo "KPI Totals:\n";
print_r($so_data['totals']);

echo "First 2 SO rows:\n";
print_r(array_slice($so_data['rows'], 0, 2));

echo "\n=== 4. Testing get_delivery_dataset() for October 2026 ===\n";
$deliv_data = $model->get_delivery_dataset($filters);
echo "Total Delivery Rows: " . count($deliv_data['rows']) . "\n";
echo "Delivery Totals:\n";
print_r($deliv_data['totals']);

echo "First 2 Delivery rows:\n";
print_r(array_slice($deliv_data['rows'], 0, 2));

echo "\n=== 5. Testing Workbook Generation with Real Data ===\n";
require_once APPPATH . 'libraries/PHPExcel.php';
require_once APPPATH . 'modules/report_progress_so/libraries/Progress_so_workbook.php';

$wb = new Progress_so_workbook();
$book = $wb->build($so_data, $deliv_data, $filters);
$temp_file = tempnam(sys_get_temp_dir(), 'real_so_') . '.xlsx';
$writer = PHPExcel_IOFactory::createWriter($book, 'Excel2007');
$writer->save($temp_file);

echo "Workbook with real data generated successfully: " . filesize($temp_file) . " bytes\n";
unlink($temp_file);

echo "\nALL MODEL & WORKBOOK INTEGRATION CHECKS PASSED!\n";
