<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Piutang_invoice_workbook
{
    private function text($sheet, $cell, $value)
    {
        $sheet->setCellValueExplicit($cell, (string) $value, PHPExcel_Cell_DataType::TYPE_STRING);
    }

    private function date_text($date)
    {
        return date('d M Y', strtotime($date));
    }

    public function build($report, $filters)
    {
        $book = new PHPExcel();
        $book->getProperties()->setTitle('Report Piutang per Invoice');
        $sheet = $book->getActiveSheet()->setTitle('Piutang Per Invoice');
        $sheet->mergeCells('A1:I1')->setCellValue('A1', 'REPORT PIUTANG PER INVOICE');
        $sheet->mergeCells('A2:I2')->setCellValue('A2', 'Per Tanggal: ' . $this->date_text($filters['tanggal']));
        $sheet->mergeCells('A3:I3');
        $this->text($sheet, 'A3', 'Customer: ' . ($filters['customer_id'] === '' ? 'Semua' : $filters['customer_id'])
            . ' | No Invoice: ' . ($filters['no_invoice'] === '' ? 'Semua' : $filters['no_invoice']));
        $sheet->fromArray(array('Customer', 'Tgl Invoice', 'No Invoice', 'Nilai Invoice', 'Kode Penerimaan', 'Tgl Bayar', 'Nilai Bayar', 'Total Bayar', 'Sisa Piutang'), null, 'A4');
        $row = 5;
        foreach ($report['invoices'] as $invoice) {
            $payments = $invoice['payments'] ? $invoice['payments'] : array(null);
            foreach ($payments as $index => $payment) {
                if ($index === 0) {
                    $this->text($sheet, 'A' . $row, $invoice['customer']);
                    $this->text($sheet, 'B' . $row, $this->date_text($invoice['tgl_invoice']));
                    $this->text($sheet, 'C' . $row, $invoice['no_surat']);
                    $sheet->setCellValue('D' . $row, $invoice['nilai_invoice']);
                }
                if ($payment !== null) {
                    $this->text($sheet, 'E' . $row, $payment['kd_pembayaran']);
                    $this->text($sheet, 'F' . $row, $this->date_text($payment['tgl_pembayaran']));
                    $sheet->setCellValue('G' . $row, $payment['nilai_bayar']);
                    $sheet->setCellValue('H' . $row, $payment['total_bayar']);
                    $sheet->setCellValue('I' . $row, $payment['sisa_piutang']);
                } else {
                    $sheet->setCellValue('I' . $row, $invoice['sisa_piutang']);
                }
                $row++;
            }
        }
        $sheet->mergeCells('A' . $row . ':H' . $row)->setCellValue('A' . $row, 'Total Piutang');
        $sheet->setCellValue('I' . $row, $report['total_piutang']);
        $sheet->getStyle('A' . $row . ':I' . $row)->getFont()->setBold(true);
        $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('D5:D' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('G5:I' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('D5:I' . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('E5:F' . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $sheet->mergeCells('A' . ($row + 2) . ':I' . ($row + 2));
        $sheet->setCellValue('A' . ($row + 2), 'Total tidak mencakup invoice pada sheet Perlu Verifikasi.');
        $sheet->mergeCells('A' . ($row + 3) . ':I' . ($row + 3));
        $sheet->setCellValue('A' . ($row + 3), 'Dihitung dari transaksi yang tersedia sekarang; perubahan transaksi dapat mengubah hasil tanggal lampau.');
        $sheet->getStyle('A' . ($row + 3))->getAlignment()->setWrapText(true);
        $sheet->getRowDimension($row + 3)->setRowHeight(30);
        $widths = array('A' => 38, 'B' => 16, 'C' => 25, 'D' => 19, 'E' => 23, 'F' => 16, 'G' => 19, 'H' => 19, 'I' => 19);
        foreach ($widths as $column => $width) {
            $sheet->getColumnDimension($column)->setWidth($width);
        }
        $this->style($sheet, 'I', $row);

        $verification = $book->createSheet()->setTitle('Perlu Verifikasi');
        $verification->mergeCells('A1:E1')->setCellValue('A1', 'DATA PERLU VERIFIKASI');
        $verification->mergeCells('A2:E2')->setCellValue('A2', 'Per Tanggal: ' . $this->date_text($filters['tanggal']));
        $verification->mergeCells('A3:E3')->setCellValue('A3', 'Data berikut tidak termasuk total piutang.');
        $verification->fromArray(array('Customer', 'No Invoice', 'Kode Internal Invoice', 'Kode Penerimaan', 'Alasan'), null, 'A4');
        $row = 5;
        foreach ($report['verification'] as $issue) {
            $columns = array('A' => 'customer', 'B' => 'no_surat', 'C' => 'no_invoice', 'D' => 'kd_pembayaran', 'E' => 'reason');
            foreach ($columns as $column => $field) {
                $this->text($verification, $column . $row, $issue[$field]);
            }
            $row++;
        }
        if ($row === 5) {
            $verification->setCellValue('A5', 'Tidak ada data perlu verifikasi.');
            $row++;
        }
        foreach (array('A' => 38, 'B' => 25, 'C' => 25, 'D' => 23, 'E' => 85) as $column => $width) {
            $verification->getColumnDimension($column)->setWidth($width);
        }
        $verification->getStyle('A5:E' . ($row - 1))->getAlignment()->setWrapText(true);
        $this->style($verification, 'E', $row - 1);
        $book->setActiveSheetIndex(0);
        return $book;
    }

    private function style($sheet, $last_column, $last_row)
    {
        $sheet->getStyle('A1:' . $last_column . '2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A4:' . $last_column . '4')->applyFromArray(array(
            'font' => array('bold' => true, 'color' => array('rgb' => 'FFFFFF')),
            'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => '1F536D')),
            'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
        ));
        $sheet->getStyle('A4:' . $last_column . $last_row)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sheet->freezePane('E5');
        $sheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE)->setFitToWidth(1)->setFitToHeight(0);
        $sheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 4);
    }
}
