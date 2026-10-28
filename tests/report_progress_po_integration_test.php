<?php
// Read-only integration test; uses the configured environment and never creates fixture transactions.
define('ENVIRONMENT', 'development');
define('BASEPATH', dirname(__DIR__) . '/system/');
define('APPPATH', dirname(__DIR__) . '/application/');
define('FCPATH', dirname(__DIR__) . '/');
$_SERVER['HTTP_HOST'] = 'localhost';
require BASEPATH . 'core/Common.php';
require APPPATH . 'config/database.php';
if (file_exists(APPPATH . 'config/development/database.php')) { require APPPATH . 'config/development/database.php'; }
require BASEPATH . 'database/DB.php';
require BASEPATH . 'core/Model.php';
require APPPATH . 'modules/report_progress_po/models/Report_progress_po_model.php';
require_once dirname(__DIR__) . '/application/libraries/PHPExcel.php';
if (!class_exists('ZipArchive')) { PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP); }
require APPPATH . 'modules/report_progress_po/libraries/Progress_po_workbook.php';
$connection = DB($active_group, true);
class Integration_progress_po_model extends Report_progress_po_model { public $db; }
$model = new Integration_progress_po_model(); $model->db = $connection;
function integration_check($condition, $message) {
    if (!$condition) { throw new RuntimeException($message); }
    echo "PASS: $message\n";
}
$filters = Progress_po_rules::filters(array('start_date' => '2000-01-01', 'end_date' => '2099-12-31'));
$started = microtime(true);
$data = $model->get_dataset($filters);
integration_check(isset($data['rows'], $data['totals'], $data['monthly'], $data['suppliers']), 'Live schema supports report dataset');
integration_check(count(array_unique(array_column($data['rows'], 'id'))) === count($data['rows']), 'One report row per PO');
$counts = $connection->query("SELECT COUNT(*) n FROM tr_purchase_order WHERE status IN ('2','3') AND UPPER(TRIM(matauang)) IN ('USD','IDR') AND tanggal BETWEEN '2000-01-01' AND '2099-12-31'")->row_array();
integration_check(count($data['rows']) === (int) $counts['n'], 'All approved/closed USD/IDR PO included');
$receiptCount = 0;
foreach ($data['rows'] as $row) {
    if (!in_array($row['currency'], array('USD', 'IDR'), true)) { throw new RuntimeException('Unsupported currency'); }
    foreach ($row['items'] as $item) { $receiptCount += count($item['receipts']); }
    if ($row['total_idr'] !== null) {
        if (abs($row['total_idr'] - $row['received_idr'] - $row['remaining_idr']) >= 0.01) { throw new RuntimeException('PO does not reconcile'); }
    }
}
$linkedCount = $connection->query("SELECT COUNT(*) n FROM dt_incoming d JOIN dt_trans_po p ON p.id_dt_po=d.id_dt_po JOIN tr_purchase_order h ON h.no_po=p.no_po WHERE h.status IN ('2','3') AND UPPER(TRIM(h.matauang)) IN ('USD','IDR') AND h.tanggal BETWEEN '2000-01-01' AND '2099-12-31'")->row_array();
integration_check($receiptCount === (int) $linkedCount['n'], 'Every linked Incoming detail counted exactly once');
foreach (array('monthly', 'suppliers') as $group) {
    integration_check(array_sum(array_column($data[$group], 'count_po')) === count($data['rows']), $group . ' counts reconcile');
    integration_check(abs(array_sum(array_column($data[$group], 'total_idr')) - $data['totals']['total_idr']) < 0.01, $group . ' values reconcile');
}
if ($data['rows']) {
    $first = $data['rows'][0];
    $searchFilters = $filters; $searchFilters['search'] = $first['number'];
    $searched = $model->get_dataset($searchFilters);
    integration_check(in_array($first['id'], array_column($searched['rows'], 'id'), true), 'PO search');
    $detail = $model->get_dataset($filters, $first['id']);
    integration_check(count($detail['rows']) === 1 && $detail['rows'][0] === $first, 'Detail shares list calculations');
    $localFilters = $filters; $localFilters['currency'] = 'IDR';
    $locals = $model->get_dataset($localFilters);
    integration_check($locals['totals']['usd'] === 0.0 && $locals['totals']['weighted_rate'] === null, 'Local filter excludes USD and weighted rate');
    $problemFilters = $filters; $problemFilters['status'] = 'bermasalah';
    $problems = $model->get_dataset($problemFilters);
    integration_check(count($problems['rows']) === $data['totals']['problem_count'], 'Problem filter includes monetary and relation issues');
}
integration_check(is_array($model->get_suppliers()), 'Supplier dropdown including historical records');
$exportData = $data;
if ($data['rows']) {
    $exportData['rows'] = array_fill(0, 501, $data['rows'][0]);
    $exportData['rows'][0]['number'] = '=HYPERLINK("unsafe")';
}
$book = (new Progress_po_workbook())->build($exportData, $filters);
integration_check($book->getSheetNames() === array('Ringkasan', 'Data PO'), 'Workbook has two expected sheets');
if ($data['rows']) {
    integration_check($book->getSheet(1)->getCell('B6')->getDataType() === 's', 'Formula-like PO text is exported literally');
    integration_check((int) $book->getSheet(1)->getHighestRow() === 506, 'Export exceeds 500 PO rows');
    integration_check($book->getSheet(1)->getCell('A6')->getDataType() === 'n', 'Excel dates are typed numeric dates');
}
$path = tempnam(sys_get_temp_dir(), 'progress-po-');
try {
    PHPExcel_IOFactory::createWriter($book, 'Excel2007')->save($path);
    $loaded = PHPExcel_IOFactory::load($path);
    integration_check($loaded->getSheetCount() === 2, 'XLSX serializes and can be reopened');
    $loaded->disconnectWorksheets();
} finally { unlink($path); $book->disconnectWorksheets(); }
echo 'PO: ' . count($data['rows']) . '; Incoming details: ' . $receiptCount . '; flagged PO: ' . $data['totals']['problem_count'] . '; seconds: ' . round(microtime(true) - $started, 2) . "\n";
$issueCounts = array();
foreach ($data['rows'] as $row) {
    foreach ($row['issues'] as $issue) {
        $reason = strpos($issue, ': ') !== false ? substr($issue, strpos($issue, ': ') + 2) : $issue;
        $issueCounts[$reason] = (isset($issueCounts[$reason]) ? $issueCounts[$reason] : 0) + 1;
    }
}
echo 'Issue categories: ' . json_encode($issueCounts) . "\n";
