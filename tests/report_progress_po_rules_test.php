<?php
define('BASEPATH', dirname(__DIR__) . '/system/');
require dirname(__DIR__) . '/application/modules/report_progress_po/libraries/Progress_po_rules.php';

function po_check($condition, $message)
{
    if (!$condition) { throw new RuntimeException($message); }
    echo "PASS: $message\n";
}
function po_near($actual, $expected, $message)
{
    po_check($actual !== null && abs($actual - $expected) < 0.005, $message);
}
$rules = new Progress_po_rules();
$po = array('no_po' => 'PO1', 'no_surat' => 'PO/2026/10/001', 'tanggal' => '2026-10-01',
    'id_suplier' => 'S1', 'supplier' => 'Supplier', 'matauang' => 'usd', 'loi' => 'Import',
    'nominal_kurs' => 16250, 'status' => '2', 'note' => 'Bahan baku');
$item = array('no_po' => 'PO1', 'id_dt_po' => 'ITEM1', 'qty' => 10, 'jumlahharga' => 10000,
    'diskon' => 0, 'namamaterial' => 'Barang', 'close_po' => 'N');
$receipt = array('id_dt_po' => 'ITEM1', 'id_dt_incoming' => 1, 'id_data' => 'IN1',
    'header_id' => 'IN1', 'id_incoming' => 'INC/1', 'tanggal' => '2026-11-01',
    'qty_recive' => 10, 'kurs' => 16250, 'matauang' => 'usd', 'pib' => 'PIB1');
$row = $rules->calculate($po, array($item), array($receipt));
po_near($row['total_idr'], 162500000, 'Excel example: USD 10000 at 16250');
po_check($row['status_code'] === 'lengkap', 'Full receipt is complete');
po_check($row['first_incoming'] === '2026-11-01', 'Incoming after PO period is retained');

$receipt['qty_recive'] = 4; $receipt['kurs'] = 16000;
$row = $rules->calculate($po, array($item), array($receipt));
po_near($row['received_idr'], 64000000, 'Partial receipt uses Incoming rate');
po_near($row['remaining_idr'], 97500000, 'Unreceived amount uses PO rate');
po_near($row['total_idr'], 161500000, 'Total reconciles received plus estimate');
po_near($row['progress'], 40, 'Partial progress is 40 percent');
po_check($row['status_code'] === 'parsial', 'Partial status');
$otherReceipt = $receipt; $otherReceipt['id_dt_incoming'] = 2; $otherReceipt['qty_recive'] = 6;
$otherReceipt['kurs'] = 17000; $otherReceipt['tanggal'] = '2026-11-02';
$row = $rules->calculate($po, array($item), array($receipt, $otherReceipt));
po_near($row['received_idr'], 166000000, 'Split receipts preserve each exchange rate');
po_check($row['first_incoming'] === '2026-11-01' && $row['last_incoming'] === '2026-11-02', 'Incoming date range');

$local = $po; $local['no_po'] = 'PO2'; $local['matauang'] = 'IDR'; $local['nominal_kurs'] = null;
$local['id_suplier'] = 'S2'; $local['supplier'] = 'Local'; $local['loi'] = 'Lokal';
$localItem = $item; $localItem['no_po'] = 'PO2'; $localItem['jumlahharga'] = 20000; $localItem['diskon'] = 10;
$localRow = $rules->calculate($local, array($localItem), array());
po_near($localRow['total_idr'], 18000, 'IDR uses net amount without exchange rate');
po_check($localRow['usd'] === 0.0 && $localRow['status_code'] === 'belum', 'Local PO has no USD amount');
$summary = $rules->summarize(array($row, $localRow), '2026-01-01', '2026-12-31');
po_near($summary['totals']['weighted_rate'], 16600, 'Weighted rate excludes IDR transactions');
po_check($summary['totals']['count_po'] === 2 && count($summary['monthly']) === 12, 'Summary counts PO and includes empty months');
po_near($summary['monthly'][9]['total_idr'], 166018000, 'Month groups by PO date, not Incoming date');
po_near(array_sum(array_column($summary['suppliers'], 'total_idr')), $summary['totals']['total_idr'], 'Supplier totals reconcile');

$secondItem = $item; $secondItem['id_dt_po'] = 'ITEM2'; $secondItem['jumlahharga'] = 30000;
$row = $rules->calculate($po, array($item, $secondItem), array($receipt));
po_near($row['progress'], 10, 'PO progress is weighted by item value');
po_check(count($row['items']) === 2, 'Items with identical names stay distinct');
$unrelated = $receipt; $unrelated['id_dt_po'] = 'OTHER_PO_ITEM';
$row = $rules->calculate($po, array($item), array($unrelated));
po_near($row['received_idr'], 0, 'Incoming belonging to another PO is not counted');

$item['close_po'] = 'Y';
$row = $rules->calculate($po, array($item), array($receipt));
po_check($row['closed'] && $row['status_code'] === 'parsial', 'Manual closure does not complete partial receipt');
$receipt['qty_recive'] = 12;
$row = $rules->calculate($po, array($item), array($receipt));
po_near($row['progress'], 100, 'Overreceipt progress is capped');
po_near($row['items'][0]['excess_qty'], 2, 'Overreceipt remains visible');
po_near($row['received_idr'], 160000000, 'Overreceipt does not inflate allocated PO value');

$receipt['kurs'] = null;
$row = $rules->calculate($po, array($item), array($receipt));
po_check($row['received_idr'] === null && $row['total_idr'] === null && count($row['issues']) > 0, 'Missing rate is unknown, not zero');
$summary = $rules->summarize(array($row), '2026-10-01', '2026-10-31');
po_check($summary['totals']['problem_count'] === 1 && $summary['totals']['weighted_rate'] === null, 'Unknown amounts flagged in summary');
$receipt['header_id'] = null;
$row = $rules->calculate($po, array($item), array($receipt));
po_check($row['status_code'] === 'bermasalah', 'Orphan Incoming cannot imply completion');
$item['qty'] = 0;
$row = $rules->calculate($po, array($item), array());
po_check($row['progress'] === null && $row['total_idr'] === null, 'Zero quantity does not divide by zero');
$empty = $rules->summarize(array(), '2026-10-01', '2026-10-31');
po_check($empty['totals']['count_po'] === 0 && $empty['totals']['weighted_rate'] === null, 'Empty summary is safe');

$filters = Progress_po_rules::filters(array(), '2026-10-26');
po_check($filters['start_date'] === '2026-01-01' && $filters['end_date'] === '2026-10-26', 'Year-to-date defaults');
foreach (array(array('start_date' => '2026-02-30'), array('start_date' => '2026-11-01', 'end_date' => '2026-10-01'), array('currency' => 'EUR'), array('status' => array())) as $bad) {
    try { Progress_po_rules::filters($bad, '2026-10-26'); throw new RuntimeException('Invalid filter accepted'); }
    catch (InvalidArgumentException $expected) { echo "PASS: Invalid filter rejected\n"; }
}
