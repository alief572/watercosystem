<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Progress_po_rules
{
    const LABELS = array('belum' => 'Belum Datang', 'parsial' => 'Sebagian Diterima',
        'lengkap' => 'Diterima Lengkap', 'bermasalah' => 'Periksa Data');

    public static function filters($input, $today = null)
    {
        $today = $today ?: (new DateTimeImmutable('now', new DateTimeZone('Asia/Jakarta')))->format('Y-m-d');
        $defaults = array('start_date' => substr($today, 0, 4) . '-01-01', 'end_date' => $today,
            'supplier_id' => '', 'type' => '', 'currency' => '', 'status' => '', 'search' => '');
        $filters = array();
        foreach ($defaults as $key => $default) {
            $value = isset($input[$key]) ? $input[$key] : $default;
            if (!is_scalar($value)) { throw new InvalidArgumentException('Filter tidak valid: ' . $key); }
            $filters[$key] = trim((string) $value);
        }
        foreach (array('start_date', 'end_date') as $key) {
            if (!preg_match('/^\d{4}-\d{2}-\d{2}$/D', $filters[$key])) {
                throw new InvalidArgumentException('Format tanggal harus YYYY-MM-DD.');
            }
            $date = DateTimeImmutable::createFromFormat('!Y-m-d', $filters[$key]);
            if (!$date || $date->format('Y-m-d') !== $filters[$key] || $filters[$key] < '2000-01-01' || $filters[$key] > '2099-12-31') {
                throw new InvalidArgumentException('Tanggal harus valid antara tahun 2000 dan 2099.');
            }
        }
        if ($filters['start_date'] > $filters['end_date']) { throw new InvalidArgumentException('Tanggal awal melebihi tanggal akhir.'); }
        foreach (array('type' => array('', 'Import', 'Lokal'), 'currency' => array('', 'USD', 'IDR'),
            'status' => array_merge(array(''), array_keys(self::LABELS))) as $key => $allowed) {
            if (!in_array($filters[$key], $allowed, true)) { throw new InvalidArgumentException('Pilihan filter tidak valid: ' . $key); }
        }
        if (strlen($filters['supplier_id']) > 255 || strlen($filters['search']) > 200) {
            throw new InvalidArgumentException('Filter pencarian terlalu panjang.');
        }
        return $filters;
    }

    private function number($value)
    {
        return is_numeric($value) && is_finite((float) $value) ? (float) $value : null;
    }

    private function date($value)
    {
        $value = (string) $value;
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/D', $value)) { return null; }
        $date = DateTimeImmutable::createFromFormat('!Y-m-d', $value);
        return $date && $date->format('Y-m-d') === $value && $value >= '2000-01-01' ? $value : null;
    }

    private function add($a, $b)
    {
        return $a === null || $b === null ? null : $a + $b;
    }

    public function calculate($po, $items, $receipts)
    {
        $currency = strtoupper(trim((string) $po['matauang']));
        $issues = array(); $details = array(); $dates = array();
        $native = 0.0; $receivedNative = 0.0; $receivedIdr = 0.0; $remainingIdr = 0.0;
        $hasReceipt = false; $complete = true; $quantityProblem = false;
        $closed = (string) $po['status'] === '3';
        $poRate = $currency === 'IDR' ? 1.0 : $this->number($po['nominal_kurs']);
        $byItem = array();
        foreach ($receipts as $receipt) { $byItem[$receipt['id_dt_po']][] = $receipt; }
        foreach ($items as $item) {
            $itemIssues = array();
            $qty = $this->number($item['qty']);
            $gross = $this->number($item['jumlahharga']);
            $discount = $this->number($item['diskon']);
            // Legacy rows without a discount represent an undiscounted PO item.
            if ($item['diskon'] === null || $item['diskon'] === '') { $discount = 0.0; }
            $validQty = $qty !== null && $qty > 0;
            $net = $gross !== null && $gross >= 0 && $discount !== null && $discount >= 0 && $discount <= 100
                ? $gross * (1 - $discount / 100) : null;
            if (!$validQty) { $itemIssues[] = 'Kuantitas PO tidak valid'; $quantityProblem = true; }
            if ($net === null) { $itemIssues[] = 'Nilai barang atau diskon tidak valid'; }
            $itemReceived = 0.0; $itemReceivedNative = $validQty ? 0.0 : null;
            $itemReceivedIdr = $validQty ? 0.0 : null; $allocated = 0.0; $history = array();
            $itemReceipts = isset($byItem[$item['id_dt_po']]) ? $byItem[$item['id_dt_po']] : array();
            usort($itemReceipts, function ($a, $b) {
                return strcmp((string) $a['tanggal'], (string) $b['tanggal']) ?: ((int) $a['id_dt_incoming'] <=> (int) $b['id_dt_incoming']);
            });
            foreach ($itemReceipts as $receipt) {
                $rq = $this->number($receipt['qty_recive']);
                $date = $this->date($receipt['tanggal']);
                $validReceipt = !empty($receipt['header_id']) && $rq !== null && $rq >= 0 && $date !== null;
                if (!$validReceipt) {
                    $itemIssues[] = 'Relasi, tanggal, atau kuantitas Incoming tidak valid';
                    $quantityProblem = true; $itemReceivedNative = null; $itemReceivedIdr = null;
                }
                $applied = $validReceipt && $validQty ? min($rq, max(0, $qty - $allocated)) : 0.0;
                if ($validReceipt) {
                    $itemReceived += $rq;
                    if ($rq > 0) { $dates[] = $date; $hasReceipt = true; }
                }
                $amount = $net !== null && $validQty && $validReceipt ? $net * $applied / $qty : null;
                $rate = $currency === 'IDR' ? 1.0 : $this->number($receipt['kurs']);
                $sameCurrency = strtoupper(trim((string) $receipt['matauang'])) === $currency;
                $idr = $amount === 0.0 ? 0.0 : ($amount !== null && $sameCurrency && $rate !== null && $rate > 0 ? $amount * $rate : null);
                if ($idr === null && $validReceipt) { $itemIssues[] = 'Kurs atau mata uang Incoming tidak valid'; }
                $itemReceivedNative = $this->add($itemReceivedNative, $amount);
                $itemReceivedIdr = $this->add($itemReceivedIdr, $idr);
                $allocated += $applied;
                $history[] = array('number' => $receipt['id_incoming'], 'date' => $date,
                    'pib' => $receipt['pib'], 'qty' => $rq, 'allocated_qty' => $applied,
                    'rate' => $rate, 'native' => $amount, 'idr' => $idr);
            }
            $remaining = $net !== null && $validQty && $itemReceivedNative !== null ? $net * max(0, $qty - $allocated) / $qty : null;
            $itemRemainingIdr = $remaining === 0.0 ? 0.0 : ($remaining !== null && $poRate !== null && $poRate > 0 ? $remaining * $poRate : null);
            if ($remaining !== null && $itemRemainingIdr === null) { $itemIssues[] = 'Kurs PO untuk estimasi belum tersedia'; }
            if (!$validQty || $itemReceived + 0.000001 < $qty) { $complete = false; }
            $closed = $closed || $item['close_po'] === 'Y';
            $native = $this->add($native, $net);
            $receivedNative = $this->add($receivedNative, $itemReceivedNative);
            $receivedIdr = $this->add($receivedIdr, $itemReceivedIdr);
            $remainingIdr = $this->add($remainingIdr, $itemRemainingIdr);
            foreach (array_unique($itemIssues) as $issue) { $issues[] = $item['id_dt_po'] . ': ' . $issue; }
            $details[] = array('id' => $item['id_dt_po'], 'name' => $item['namamaterial'],
                'qty' => $qty, 'received_qty' => $itemReceived, 'excess_qty' => $validQty ? max(0, $itemReceived - $qty) : null,
                'net' => $net, 'received_idr' => $itemReceivedIdr, 'remaining_idr' => $itemRemainingIdr,
                'issues' => array_values(array_unique($itemIssues)), 'receipts' => $history);
        }
        if (!$items) {
            $issues[] = 'PO tidak memiliki detail barang'; $quantityProblem = true;
            $native = $receivedNative = $receivedIdr = $remainingIdr = null;
        }
        $status = $quantityProblem ? 'bermasalah' : (!$hasReceipt ? 'belum' : ($complete ? 'lengkap' : 'parsial'));
        sort($dates);
        $total = $this->add($receivedIdr, $remainingIdr);
        $progress = !$quantityProblem && $native !== null && $native > 0 && $receivedNative !== null
            ? min(100, 100 * $receivedNative / $native) : null;
        if ($progress === null && !$quantityProblem && $native === 0.0) { $progress = $complete ? 100.0 : ($hasReceipt ? null : 0.0); }
        return array('id' => $po['no_po'], 'number' => $po['no_surat'] ?: $po['no_po'],
            'date' => $po['tanggal'], 'supplier_id' => $po['id_suplier'], 'supplier' => $po['supplier'] ?: $po['id_suplier'],
            'type' => $po['loi'], 'currency' => $currency, 'description' => $po['note'],
            'native' => $native, 'usd' => $currency === 'USD' ? $native : 0.0,
            'received_idr' => $receivedIdr, 'remaining_idr' => $remainingIdr, 'total_idr' => $total,
            'po_rate' => $poRate, 'effective_rate' => $currency === 'IDR' ? 1.0 : ($total !== null && $native > 0 ? $total / $native : null),
            'progress' => $progress, 'status_code' => $status, 'status' => self::LABELS[$status],
            'closed' => $closed, 'first_incoming' => $dates ? reset($dates) : null,
            'last_incoming' => $dates ? end($dates) : null, 'issues' => array_values(array_unique($issues)), 'items' => $details);
    }

    private function aggregate($rows)
    {
        $totals = array('count_po' => count($rows), 'usd' => 0.0, 'total_idr' => 0.0,
            'received_idr' => 0.0, 'remaining_idr' => 0.0, 'problem_count' => 0, 'weighted_rate' => null);
        $weightedUsd = 0.0; $weightedIdr = 0.0;
        foreach ($rows as $row) {
            foreach (array('usd', 'total_idr', 'received_idr', 'remaining_idr') as $field) {
                if ($row[$field] !== null) { $totals[$field] += $row[$field]; }
            }
            if ($row['issues']) { $totals['problem_count']++; }
            if ($row['currency'] === 'USD' && $row['total_idr'] !== null && $row['usd'] > 0) {
                $weightedUsd += $row['usd']; $weightedIdr += $row['total_idr'];
            }
        }
        $totals['weighted_rate'] = $weightedUsd > 0 ? $weightedIdr / $weightedUsd : null;
        return $totals;
    }

    public function summarize($rows, $start, $end)
    {
        $monthly = array(); $suppliers = array(); $byMonth = array(); $bySupplier = array();
        foreach ($rows as $row) {
            $byMonth[substr($row['date'], 0, 7)][] = $row;
            $bySupplier[$row['supplier_id']][] = $row;
        }
        $month = new DateTimeImmutable(substr($start, 0, 7) . '-01');
        while ($month->format('Y-m') <= substr($end, 0, 7)) {
            $key = $month->format('Y-m');
            $monthly[] = array_merge(array('month' => $key), $this->aggregate(isset($byMonth[$key]) ? $byMonth[$key] : array()));
            $month = $month->modify('+1 month');
        }
        $totals = $this->aggregate($rows);
        foreach ($bySupplier as $id => $supplierRows) {
            $sum = $this->aggregate($supplierRows);
            $suppliers[] = array_merge(array('id' => $id, 'supplier' => $supplierRows[0]['supplier'],
                'share' => $totals['total_idr'] > 0 ? 100 * $sum['total_idr'] / $totals['total_idr'] : 0.0), $sum);
        }
        usort($suppliers, function ($a, $b) { return $b['total_idr'] <=> $a['total_idr']; });
        return array('totals' => $totals, 'monthly' => $monthly, 'suppliers' => $suppliers);
    }
}
