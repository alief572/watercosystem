<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class Progress_po_workbook
{
    private function row($sheet, $row, $values)
    {
        foreach (array_values($values) as $index => $value) {
            $cell = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($index + 1) . $row;
            if (is_string($value)) { $sheet->setCellValueExplicit($cell, $value, DataType::TYPE_STRING); }
            elseif ($value !== null) { $sheet->setCellValue($cell, $value); }
        }
    }

    private function date($sheet, $cell, $value)
    {
        if ($value) {
            $sheet->setCellValue($cell, Date::PHPToExcel(new DateTimeImmutable($value, new DateTimeZone('UTC'))));
            $sheet->getStyle($cell)->getNumberFormat()->setFormatCode('dd/mm/yyyy');
        }
    }

    private function header($sheet, $row, $labels)
    {
        $this->row($sheet, $row, $labels);
        $last = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(count($labels));
        $style = $sheet->getStyle('A' . $row . ':' . $last . $row);
        $style->getFont()->setBold(true)->getColor()->setARGB('FFFFFFFF');
        $style->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF365A6E');
    }

    public function build($data, $filters)
    {
        $book = new Spreadsheet();
        $book->getProperties()->setTitle('Report Progress PO')->setCreator('Waterco System');
        $book->getDefaultStyle()->getFont()->setName('Calibri')->setSize(11);
        $summary = $book->getActiveSheet()->setTitle('Ringkasan');
        $this->row($summary, 1, array('REPORT PROGRESS PO'));
        $this->row($summary, 2, array('Tanggal PO: ' . $filters['start_date'] . ' s/d ' . $filters['end_date']));
        $this->row($summary, 3, array('Supplier ID: ' . ($filters['supplier_id'] ?: 'Semua') . ' | Jenis: ' . ($filters['type'] ?: 'Semua')
            . ' | Mata uang: ' . ($filters['currency'] ?: 'USD dan IDR') . ' | Status: ' . ($filters['status'] ?: 'Semua')));
        $this->row($summary, 4, array('Pencarian: ' . ($filters['search'] ?: '-') . ' | Diambil: ' . $data['generated_at'] . ' WIB'));
        $this->row($summary, 5, array('Nilai barang setelah diskon, sebelum PPN/ongkir. Penerimaan sampai kondisi terbaru. Sisa memakai estimasi kurs PO.'));
        $this->row($summary, 6, array('Total menjumlahkan nilai yang dapat dihitung per kolom; sel kosong belum dapat dihitung. PO bermasalah: ' . $data['totals']['problem_count']));
        $metrics = array('Jumlah PO' => 'count_po', 'Nilai PO USD' => 'usd', 'Total nilai laporan IDR (termasuk estimasi)' => 'total_idr',
            'Diterima IDR' => 'received_idr', 'Sisa estimasi IDR' => 'remaining_idr', 'Kurs tertimbang USD (aktual + estimasi)' => 'weighted_rate', 'PO perlu diperiksa' => 'problem_count');
        $line = 8;
        foreach ($metrics as $label => $key) { $this->row($summary, $line++, array($label, $data['totals'][$key])); }
        $this->header($summary, 17, array('Bulan PO', 'Jumlah PO', 'USD', 'Total IDR', 'Diterima IDR', 'Sisa estimasi IDR', 'PO bermasalah'));
        $line = 18;
        foreach ($data['monthly'] as $month) {
            $this->row($summary, $line++, array($month['month'], $month['count_po'], $month['usd'], $month['total_idr'], $month['received_idr'], $month['remaining_idr'], $month['problem_count']));
        }
        $line += 2;
        $this->header($summary, $line++, array('Supplier', 'Jumlah PO', 'USD', 'Total IDR', 'Diterima IDR', 'Sisa estimasi IDR', '% total diketahui', 'PO bermasalah'));
        foreach ($data['suppliers'] as $supplier) {
            $this->row($summary, $line++, array($supplier['supplier'], $supplier['count_po'], $supplier['usd'], $supplier['total_idr'],
                $supplier['received_idr'], $supplier['remaining_idr'], $supplier['share'] / 100, $supplier['problem_count']));
            $summary->getStyle('G' . ($line - 1))->getNumberFormat()->setFormatCode('0.00%');
        }
        $summary->getColumnDimension('A')->setWidth(48);
        foreach (range('B', 'H') as $col) { $summary->getColumnDimension($col)->setWidth(23); }
        $summary->getStyle('B8:B14')->getNumberFormat()->setFormatCode('#,##0.00');
        $summary->getStyle('C18:F' . $line)->getNumberFormat()->setFormatCode('#,##0.00');
        $summary->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $summary->freezePane('B18');

        $sheet = $book->createSheet()->setTitle('Data PO');
        $this->row($sheet, 1, array('REPORT PROGRESS PO — DATA PO'));
        $this->row($sheet, 2, array('Tanggal PO: ' . $filters['start_date'] . ' s/d ' . $filters['end_date'] . ' | Diambil: ' . $data['generated_at'] . ' WIB'));
        $this->row($sheet, 3, array('Kurs efektif menggabungkan kurs Incoming dan estimasi kurs PO. Sel kosong perlu pemeriksaan. Rincian filter di sheet Ringkasan.'));
        $this->header($sheet, 5, array('Tanggal PO', 'No PO', 'Supplier', 'Incoming pertama', 'Incoming terakhir', 'Keterangan', 'Jenis', 'Mata uang',
            'Kurs PO', 'Kurs efektif', 'Nilai bersih mata uang asal', 'USD', 'Total laporan IDR', 'Diterima IDR', 'Sisa estimasi IDR', 'Progress', 'Status', 'Ditutup', 'Catatan data'));
        $line = 6;
        foreach ($data['rows'] as $po) {
            $this->row($sheet, $line, array(null, $po['number'], $po['supplier'], null, null, $po['description'], $po['type'], $po['currency'],
                $po['po_rate'], $po['effective_rate'], $po['native'], $po['usd'], $po['total_idr'], $po['received_idr'], $po['remaining_idr'],
                $po['progress'] === null ? null : $po['progress'] / 100, $po['status'], $po['closed'] ? 'Ya' : 'Tidak', implode('; ', $po['issues'])));
            $this->date($sheet, 'A' . $line, $po['date']);
            $this->date($sheet, 'D' . $line, $po['first_incoming']);
            $this->date($sheet, 'E' . $line, $po['last_incoming']);
            $line++;
        }
        if ($line > 6) {
            $sheet->getStyle('I6:O' . ($line - 1))->getNumberFormat()->setFormatCode('#,##0.00');
            $sheet->getStyle('P6:P' . ($line - 1))->getNumberFormat()->setFormatCode('0.00%');
        }
        $sheet->setAutoFilter('A5:S' . max(5, $line - 1));
        $sheet->freezePane('D6');
        foreach (range('A', 'S') as $col) { $sheet->getColumnDimension($col)->setWidth(23); }
        foreach (array('C', 'F', 'S') as $col) { $sheet->getColumnDimension($col)->setWidth(42); }
        $sheet->getStyle('A5:S' . max(5, $line - 1))->getAlignment()->setVertical('top')->setWrapText(true);
        $book->setActiveSheetIndex(0);
        return $book;
    }
}
