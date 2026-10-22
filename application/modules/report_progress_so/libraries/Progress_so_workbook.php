<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Progress_so_workbook
{
    private function text($sheet, $cell, $value)
    {
        $sheet->setCellValueExplicit($cell, (string) $value, PHPExcel_Cell_DataType::TYPE_STRING);
    }

    private function date_text($date)
    {
        if (empty($date) || $date === '-' || $date === '0000-00-00') {
            return '-';
        }
        $ts = strtotime($date);
        return $ts ? date('d/m/Y', $ts) : (string)$date;
    }

    /**
     * Build the two-sheet Excel workbook
     */
    public function build($so_dataset, $deliv_dataset, $filters)
    {
        $book = new PHPExcel();
        $book->getProperties()->setTitle('Report Progress SO')
            ->setCreator('Waterco System')
            ->setLastModifiedBy('Waterco System');

        $period_label = 'Periode: ' . $this->date_text($filters['start_date']) . ' s/d ' . $this->date_text($filters['end_date']);
        $cust_label = 'Customer: ' . (!empty($filters['customer_name']) ? $filters['customer_name'] : 'Semua Customer');
        $sales_label = 'Sales: ' . (!empty($filters['sales_name']) ? $filters['sales_name'] : 'Semua Sales');
        $filter_info = $period_label . ' | ' . $cust_label . ' | ' . $sales_label;

        // ==========================================
        // SHEET 1: PROGRESS SALES ORDER (SO)
        // ==========================================
        $sheet1 = $book->getActiveSheet()->setTitle('Progress Sales Order');
        $sheet1->mergeCells('A1:M1')->setCellValue('A1', 'REPORT PROGRESS SALES ORDER (SO)');
        $sheet1->mergeCells('A2:M2')->setCellValue('A2', 'Melihat progress SO: value SO, invoice, outstanding SO, payment, dan outstanding piutang per SO');
        $sheet1->mergeCells('A3:M3')->setCellValue('A3', $filter_info);

        $headers1 = array(
            'No SO', 'Tanggal SO', 'Customer', 'Sales', 'Deskripsi',
            'Value SO', 'Invoice', 'Outstanding SO', 'Payment', 'Outstanding Piutang',
            '% Tertagih', '% Terbayar', 'Status'
        );
        $sheet1->fromArray($headers1, null, 'A5');

        $row = 6;
        $start_data_row1 = $row;
        foreach ($so_dataset['rows'] as $r) {
            $this->text($sheet1, 'A' . $row, $r['no_so']);
            $this->text($sheet1, 'B' . $row, $this->date_text($r['tanggal_so']));
            $this->text($sheet1, 'C' . $row, $r['customer']);
            $this->text($sheet1, 'D' . $row, $r['sales']);
            $this->text($sheet1, 'E' . $row, $r['deskripsi']);

            $sheet1->setCellValue('F' . $row, (float) $r['value_so']);
            $sheet1->setCellValue('G' . $row, (float) $r['invoice']);
            $sheet1->setCellValue('H' . $row, (float) $r['outstanding_so']);
            $sheet1->setCellValue('I' . $row, (float) $r['payment']);
            $sheet1->setCellValue('J' . $row, (float) $r['outstanding_piutang']);
            $sheet1->setCellValue('K' . $row, ((float) $r['persen_tertagih']) / 100);
            $sheet1->setCellValue('L' . $row, ((float) $r['persen_terbayar']) / 100);

            $this->text($sheet1, 'M' . $row, $r['status']);
            $row++;
        }

        $end_data_row1 = max($start_data_row1, $row - 1);

        // Sheet 1 Total Row
        $sheet1->setCellValue('A' . $row, 'TOTAL');
        $sheet1->mergeCells('A' . $row . ':E' . $row);
        $sheet1->getStyle('A' . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $sheet1->getStyle('A' . $row)->getFont()->setBold(true);

        if ($end_data_row1 >= $start_data_row1 && !empty($so_dataset['rows'])) {
            $sheet1->setCellValue('F' . $row, "=SUM(F{$start_data_row1}:F{$end_data_row1})");
            $sheet1->setCellValue('G' . $row, "=SUM(G{$start_data_row1}:G{$end_data_row1})");
            $sheet1->setCellValue('H' . $row, "=SUM(H{$start_data_row1}:H{$end_data_row1})");
            $sheet1->setCellValue('I' . $row, "=SUM(I{$start_data_row1}:I{$end_data_row1})");
            $sheet1->setCellValue('J' . $row, "=SUM(J{$start_data_row1}:J{$end_data_row1})");
            $sheet1->setCellValue('K' . $row, "=IF(F{$row}>0, G{$row}/F{$row}, 0)");
            $sheet1->setCellValue('L' . $row, "=IF(G{$row}>0, I{$row}/G{$row}, 0)");
        } else {
            $sheet1->setCellValue('F' . $row, 0);
            $sheet1->setCellValue('G' . $row, 0);
            $sheet1->setCellValue('H' . $row, 0);
            $sheet1->setCellValue('I' . $row, 0);
            $sheet1->setCellValue('J' . $row, 0);
            $sheet1->setCellValue('K' . $row, 0);
            $sheet1->setCellValue('L' . $row, 0);
        }

        // Formatting Sheet 1
        $sheet1->getStyle("F{$start_data_row1}:J{$row}")->getNumberFormat()->setFormatCode('#,##0');
        $sheet1->getStyle("K{$start_data_row1}:L{$row}")->getNumberFormat()->setFormatCode('0.0%');
        $sheet1->getStyle("B{$start_data_row1}:B{$row}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet1->getStyle("M{$start_data_row1}:M{$row}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet1->getStyle('A' . $row . ':M' . $row)->getFont()->setBold(true);
        $sheet1->getStyle('A' . $row . ':M' . $row)->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'EAEAEA')
        ));

        $widths1 = array(
            'A' => 22, 'B' => 14, 'C' => 30, 'D' => 24, 'E' => 35,
            'F' => 18, 'G' => 18, 'H' => 18, 'I' => 18, 'J' => 18,
            'K' => 14, 'L' => 14, 'M' => 18
        );
        foreach ($widths1 as $col => $w) {
            $sheet1->getColumnDimension($col)->setWidth($w);
        }
        $this->apply_sheet_styles($sheet1, 'M', $row, 'F6');


        // ==========================================
        // SHEET 2: STATUS PENGIRIMAN
        // ==========================================
        $sheet2 = $book->createSheet()->setTitle('Status Pengiriman');
        $sheet2->mergeCells('A1:L1')->setCellValue('A1', 'REPORT PROGRESS SO - STATUS PENGIRIMAN');
        $sheet2->mergeCells('A2:L2')->setCellValue('A2', 'Tujuan: Melihat status SO yang sudah terkirim dan belum terkirim');
        $sheet2->mergeCells('A3:L3')->setCellValue('A3', $filter_info);

        $headers2 = array(
            'No SO', 'Barang', 'Qty', 'Tanggal SO', 'Qty Kirim',
            'Outstanding', '% Terkirim', 'Status Kirim', 'Tanggal DO', 'NO DO',
            'Nama Customer', 'Account Handler'
        );
        $sheet2->fromArray($headers2, null, 'A5');

        $row2 = 6;
        $start_data_row2 = $row2;
        foreach ($deliv_dataset['rows'] as $dr) {
            $this->text($sheet2, 'A' . $row2, $dr['no_so']);
            $this->text($sheet2, 'B' . $row2, $dr['barang']);
            $sheet2->setCellValue('C' . $row2, (float) $dr['qty']);
            $this->text($sheet2, 'D' . $row2, $this->date_text($dr['tanggal_so']));
            $sheet2->setCellValue('E' . $row2, (float) $dr['qty_kirim']);
            $sheet2->setCellValue('F' . $row2, (float) $dr['outstanding']);
            $sheet2->setCellValue('G' . $row2, ((float) $dr['persen_terkirim']) / 100);
            $this->text($sheet2, 'H' . $row2, $dr['status_kirim']);
            $this->text($sheet2, 'I' . $row2, $this->date_text($dr['tanggal_do']));
            $this->text($sheet2, 'J' . $row2, $dr['no_do']);
            $this->text($sheet2, 'K' . $row2, $dr['nama_customer']);
            $this->text($sheet2, 'L' . $row2, $dr['account_handler']);
            $row2++;
        }

        $end_data_row2 = max($start_data_row2, $row2 - 1);

        // Sheet 2 Total Row
        $sheet2->setCellValue('A' . $row2, 'TOTAL');
        $sheet2->mergeCells('A' . $row2 . ':B' . $row2);
        $sheet2->getStyle('A' . $row2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $sheet2->getStyle('A' . $row2)->getFont()->setBold(true);

        if ($end_data_row2 >= $start_data_row2 && !empty($deliv_dataset['rows'])) {
            $sheet2->setCellValue('C' . $row2, $deliv_dataset['totals']['total_qty_so']);
            $sheet2->setCellValue('E' . $row2, "=SUM(E{$start_data_row2}:E{$end_data_row2})");
            $sheet2->setCellValue('F' . $row2, $deliv_dataset['totals']['total_outstanding']);
        } else {
            $sheet2->setCellValue('C' . $row2, 0);
            $sheet2->setCellValue('E' . $row2, 0);
            $sheet2->setCellValue('F' . $row2, 0);
        }

        // Formatting Sheet 2
        $sheet2->getStyle("C{$start_data_row2}:C{$row2}")->getNumberFormat()->setFormatCode('#,##0');
        $sheet2->getStyle("E{$start_data_row2}:F{$row2}")->getNumberFormat()->setFormatCode('#,##0');
        $sheet2->getStyle("G{$start_data_row2}:G{$row2}")->getNumberFormat()->setFormatCode('0.0%');
        $sheet2->getStyle("D{$start_data_row2}:D{$row2}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet2->getStyle("H{$start_data_row2}:J{$row2}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet2->getStyle('A' . $row2 . ':L' . $row2)->getFont()->setBold(true);
        $sheet2->getStyle('A' . $row2 . ':L' . $row2)->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'EAEAEA')
        ));

        $widths2 = array(
            'A' => 20, 'B' => 32, 'C' => 12, 'D' => 14, 'E' => 12,
            'F' => 14, 'G' => 14, 'H' => 18, 'I' => 14, 'J' => 22,
            'K' => 30, 'L' => 24
        );
        foreach ($widths2 as $col => $w) {
            $sheet2->getColumnDimension($col)->setWidth($w);
        }
        $this->apply_sheet_styles($sheet2, 'L', $row2, 'C6');

        // Set active sheet back to Sheet 1
        $book->setActiveSheetIndex(0);

        return $book;
    }

    private function apply_sheet_styles($sheet, $last_col, $last_row, $freeze_cell)
    {
        // Titles styling
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14)->setColor(new PHPExcel_Style_Color('1F536D'));
        $sheet->getStyle('A2')->getFont()->setItalic(true)->setSize(10)->setColor(new PHPExcel_Style_Color('555555'));
        $sheet->getStyle('A3')->getFont()->setSize(10)->setColor(new PHPExcel_Style_Color('333333'));

        // Table Header Styling
        $sheet->getStyle('A5:' . $last_col . '5')->applyFromArray(array(
            'font' => array('bold' => true, 'color' => array('rgb' => 'FFFFFF'), 'size' => 10),
            'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => '1F536D')),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'wrap' => true
            )
        ));
        $sheet->getRowDimension(5)->setRowHeight(28);

        // Table Borders
        $sheet->getStyle('A5:' . $last_col . $last_row)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        // Freeze Panes
        if (!empty($freeze_cell)) {
            $sheet->freezePane($freeze_cell);
        }

        // Print Setup
        $sheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE)
            ->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4)
            ->setFitToWidth(1)->setFitToHeight(0);
        $sheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 5);
    }
}
