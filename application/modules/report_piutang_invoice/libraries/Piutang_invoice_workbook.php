<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

#[\AllowDynamicProperties]
class Piutang_invoice_workbook
{
    private function text($sheet, $cell, $value)
    {
        $sheet->setCellValueExplicit($cell, (string) $value, DataType::TYPE_STRING);
    }

    private function date_text($date)
    {
        if (empty($date) || $date === '-' || $date === '0000-00-00') {
            return '-';
        }
        $ts = strtotime((string) $date);
        return $ts ? date('d M Y', $ts) : (string) $date;
    }

    public function build($report, $filters)
    {
        $book = new Spreadsheet();
        $book->getProperties()->setTitle('Report Piutang per Invoice');
        $sheet = $book->getActiveSheet()->setTitle('Piutang Per Invoice');
        $sheet->mergeCells('A1:I1')->setCellValue('A1', 'REPORT PIUTANG PER INVOICE');
        $sheet->mergeCells('A2:I2')->setCellValue('A2', 'Per Tanggal: ' . $this->date_text($filters['tanggal'] ?? null));
        $sheet->mergeCells('A3:I3');
        $this->text($sheet, 'A3', 'Customer: ' . (empty($filters['customer_id']) ? 'Semua' : $filters['customer_id'])
            . ' | No Invoice: ' . (empty($filters['no_invoice']) ? 'Semua' : $filters['no_invoice']));
        $sheet->fromArray(array('Customer', 'Tgl Invoice', 'No Invoice', 'Nilai Invoice', 'Kode Penerimaan', 'Tgl Bayar', 'Nilai Bayar', 'Total Bayar', 'Sisa Piutang'), null, 'A4');
        $row = 5;
        $invoices = $report['invoices'] ?? [];
        foreach ($invoices as $invoice) {
            $payments = (!empty($invoice['payments'])) ? $invoice['payments'] : array(null);
            foreach ($payments as $index => $payment) {
                if ($index === 0) {
                    $this->text($sheet, 'A' . $row, $invoice['customer'] ?? '');
                    $this->text($sheet, 'B' . $row, $this->date_text($invoice['tgl_invoice'] ?? null));
                    $this->text($sheet, 'C' . $row, $invoice['no_surat'] ?? '');
                    $sheet->setCellValue('D' . $row, $invoice['nilai_invoice'] ?? 0);
                }
                if ($payment !== null) {
                    $this->text($sheet, 'E' . $row, $payment['kd_pembayaran'] ?? '');
                    $this->text($sheet, 'F' . $row, $this->date_text($payment['tgl_pembayaran'] ?? null));
                    $sheet->setCellValue('G' . $row, $payment['nilai_bayar'] ?? 0);
                    $sheet->setCellValue('H' . $row, $payment['total_bayar'] ?? 0);
                    $sheet->setCellValue('I' . $row, $payment['sisa_piutang'] ?? 0);
                } else {
                    $sheet->setCellValue('I' . $row, $invoice['sisa_piutang'] ?? 0);
                }
                $row++;
            }
        }
        $sheet->mergeCells('A' . $row . ':H' . $row)->setCellValue('A' . $row, 'Total Piutang');
        $sheet->setCellValue('I' . $row, $report['total_piutang'] ?? 0);
        $sheet->getStyle('A4:I4')->getFont()->setBold(true);
        $sheet->getStyle('A' . $row . ':I' . $row)->getFont()->setBold(true);
        $sheet->getStyle('D5:D' . $row)->getNumberFormat()->setFormatCode('#,##0.00');
        $sheet->getStyle('G5:I' . $row)->getNumberFormat()->setFormatCode('#,##0.00');
        foreach (range('A', 'I') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $verification = $report['verification'] ?? [];
        if (!empty($verification)) {
            $vSheet = $book->createSheet()->setTitle('Verifikasi');
            $vSheet->mergeCells('A1:C1')->setCellValue('A1', 'VERIFIKASI PIUTANG PER CUSTOMER');
            $vSheet->mergeCells('A2:C2')->setCellValue('A2', 'Per Tanggal: ' . $this->date_text($filters['tanggal'] ?? null));
            $vSheet->fromArray(array('Customer', 'Sisa Piutang Rekap', 'Sisa Piutang Invoice'), null, 'A4');
            $vRow = 5;
            foreach ($verification as $v) {
                $this->text($vSheet, 'A' . $vRow, $v['customer'] ?? '');
                $vSheet->setCellValue('B' . $vRow, $v['piutang_rekap'] ?? 0);
                $vSheet->setCellValue('C' . $vRow, $v['piutang_invoice'] ?? 0);
                $vRow++;
            }
            $vSheet->getStyle('A4:C4')->getFont()->setBold(true);
            $vSheet->getStyle('B5:C' . max(5, $vRow - 1))->getNumberFormat()->setFormatCode('#,##0.00');
            foreach (range('A', 'C') as $col) {
                $vSheet->getColumnDimension($col)->setAutoSize(true);
            }
        }

        $book->setActiveSheetIndex(0);
        return $book;
    }
}
