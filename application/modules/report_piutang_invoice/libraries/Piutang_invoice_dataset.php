<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/** Pure report calculation, shared by the HTML page and workbook. */
class Piutang_invoice_dataset
{
    public static function valid_date($value)
    {
        if (!is_string($value) || !preg_match('/^\d{4}-\d{2}-\d{2}$/D', $value)) {
            return false;
        }
        return checkdate((int) substr($value, 5, 2), (int) substr($value, 8, 2), (int) substr($value, 0, 4));
    }

    private function cancelled($row)
    {
        $flag = isset($row['is_cancel']) ? strtoupper(trim($row['is_cancel'])) : '';
        return in_array($flag, array('1', 'Y', 'YES', 'TRUE', 'CANCEL'), true)
            || (isset($row['status_bayar']) && strtoupper($row['status_bayar']) === 'CANCEL')
            || !empty($row['cancel_by'])
            || (!empty($row['cancel_date']) && substr($row['cancel_date'], 0, 10) !== '0000-00-00')
            || !empty($row['header_cancel_by'])
            || (!empty($row['cancel_on']) && substr($row['cancel_on'], 0, 10) !== '0000-00-00');
    }

    public function build($invoices, $details, $orphans, $tanggal)
    {
        if (!self::valid_date($tanggal)) {
            throw new InvalidArgumentException('Tanggal report tidak valid.');
        }
        $groups = array();
        foreach ($invoices as $invoice) {
            if (!empty($invoice['deleted_by']) || !self::valid_date($invoice['tgl_invoice'])
                || $invoice['tgl_invoice'] > $tanggal || empty($invoice['printed_on'])
                || !self::valid_date(substr($invoice['printed_on'], 0, 10))) {
                continue;
            }
            $invoice['nilai_invoice'] = round((float) $invoice['nilai_invoice'], 0, PHP_ROUND_HALF_UP);
            $invoice['payments'] = array();
            $invoice['issues'] = array();
            $groups[$invoice['no_invoice']] = $invoice;
        }
        foreach ($details as $detail) {
            $key = $detail['no_invoice'];
            if (!isset($groups[$key]) || $this->cancelled($detail)) {
                continue;
            }
            $reason = null;
            if (empty($detail['header_id'])) {
                $reason = 'Header penerimaan tidak ditemukan; tanggal bayar tidak dapat dipastikan.';
            } elseif (!self::valid_date($detail['tgl_pembayaran'])) {
                $reason = 'Tanggal bayar tidak valid.';
            }
            if ($reason !== null) {
                $groups[$key]['issues'][] = array(
                    'customer' => $groups[$key]['customer'],
                    'no_invoice' => $key,
                    'no_surat' => $groups[$key]['no_surat'],
                    'kd_pembayaran' => $detail['kd_pembayaran'],
                    'reason' => $reason
                );
                continue;
            }
            if ($detail['tgl_pembayaran'] > $tanggal) {
                continue;
            }
            $code = $detail['kd_pembayaran'];
            if (!isset($groups[$key]['payments'][$code])) {
                $groups[$key]['payments'][$code] = array(
                    'kd_pembayaran' => $code,
                    'tgl_pembayaran' => $detail['tgl_pembayaran'],
                    'nilai_bayar' => 0
                );
            }
            $groups[$key]['payments'][$code]['nilai_bayar'] += round((float) $detail['total_bayar_idr'], 0, PHP_ROUND_HALF_UP);
        }
        $result = array('invoices' => array(), 'verification' => array(), 'total_piutang' => 0, 'verification_invoice_count' => 0);
        foreach ($groups as $invoice) {
            if ($invoice['issues']) {
                $result['verification_invoice_count']++;
                $result['verification'] = array_merge($result['verification'], $invoice['issues']);
                continue;
            }
            $payments = array_values($invoice['payments']);
            usort($payments, array($this, 'compare_payments'));
            $running = 0;
            foreach ($payments as &$payment) {
                $running += $payment['nilai_bayar'];
                $payment['total_bayar'] = $running;
                $payment['sisa_piutang'] = $invoice['nilai_invoice'] - $running;
            }
            unset($payment);
            $invoice['total_bayar'] = $running;
            $invoice['sisa_piutang'] = $invoice['nilai_invoice'] - $running;
            if ($invoice['sisa_piutang'] <= 0) {
                continue;
            }
            unset($invoice['issues']);
            $invoice['payments'] = $payments;
            $result['total_piutang'] += $invoice['sisa_piutang'];
            $result['invoices'][] = $invoice;
        }
        usort($result['invoices'], array($this, 'compare_invoices'));
        foreach ($orphans as $orphan) {
            if ($this->cancelled($orphan)
                || (self::valid_date($orphan['tgl_pembayaran']) && $orphan['tgl_pembayaran'] > $tanggal)) {
                continue;
            }
            $result['verification'][] = array(
                'customer' => $orphan['customer'],
                'no_invoice' => $orphan['no_invoice'],
                'no_surat' => '',
                'kd_pembayaran' => $orphan['kd_pembayaran'],
                'reason' => 'Invoice tidak ditemukan untuk detail penerimaan ini.'
            );
        }
        $result['invoice_count'] = count($result['invoices']);
        return $result;
    }

    public function compare_payments($a, $b)
    {
        $date = strcmp($a['tgl_pembayaran'], $b['tgl_pembayaran']);
        return $date !== 0 ? $date : strcmp($a['kd_pembayaran'], $b['kd_pembayaran']);
    }

    public function compare_invoices($a, $b)
    {
        $date = strcmp($b['tgl_invoice'], $a['tgl_invoice']);
        if ($date !== 0) {
            return $date;
        }
        $customer = strcasecmp($a['customer'], $b['customer']);
        if ($customer !== 0) {
            return $customer;
        }
        $number = strcmp($a['no_surat'], $b['no_surat']);
        return $number !== 0 ? $number : strcmp($a['no_invoice'], $b['no_invoice']);
    }
}
