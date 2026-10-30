<?php
defined('BASEPATH') or defined('FCPATH') or exit('No direct script access allowed');

/**
 * Libexcel — migrasi dari PHPExcel (abandoned, fatal di PHP 8) ke PhpSpreadsheet.
 *
 * Perubahan vs versi lama:
 *  - Tidak lagi `require .../third_party/PHPExcel.php` dan tidak `extends PHPExcel`
 *    (PhpSpreadsheet\Spreadsheet bukan base class yang dimaksudkan untuk di-extend;
 *    method di sini tidak butuh parent). Kelas berdiri sendiri.
 *  - PHPExcel                     -> PhpOffice\PhpSpreadsheet\Spreadsheet
 *  - PHPExcel_Style_Alignment     -> PhpOffice\PhpSpreadsheet\Style\Alignment
 *  - PHPExcel_Style_NumberFormat  -> PhpOffice\PhpSpreadsheet\Style\NumberFormat
 *  - PHPExcel_IOFactory::createWriter($o,'Excel5') -> IOFactory::createWriter($o,'Xls')
 *  API sheet/cell/style identik antara PHPExcel dan PhpSpreadsheet, jadi logika tetap.
 */

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class Libexcel
{
    public function bangunexcel($parameter)
    {
        $alphas = range("A", "Z");
        $objPHPExcel = new Spreadsheet();
        $sNAMESS = "";
        $sFILNAM = "export";
        foreach ($parameter as $key => $value) {
            ${$key} = $value;
        }
        if (!isset($col)) {
            echo "Definisi Kolom tidak ada!";
            die();
        } else {
            $jumlahKolom = count($col);
            if ($jumlahKolom == 0) {
                echo "Definisi Kolom tidak ada!";
                die();
            } else {
                if ($jumlahKolom > 26) {
                    $alphas = $this->createColumnsArray("c");
                }
            }
        }

        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle($sNAMESS);
        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(55);
        $loop = 1;
        $arrKolom = 0;
        foreach ($col as $colvalue) {
            foreach ($colvalue as $keycol => $valuecol) {
                ${$keycol} = $valuecol;
            }
            if (isset($nilai)) {
                if ($nilai != "") {
                    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$arrKolom] . "1", $nilai);
                }
            }
            if (isset($fontsize)) {
                if ($fontsize != 0) {
                    $objPHPExcel->getActiveSheet()->getStyle($alphas[$arrKolom] . "1")->getFont()->setSize($fontsize);
                }
            }
            if (isset($bold)) {
                if ($bold) {
                    $objPHPExcel->getActiveSheet()->getStyle($alphas[$arrKolom] . "1")->getFont()->setBold(true);
                }
            }
            $classvertical = Alignment::VERTICAL_CENTER;
            if (isset($valign)) {
                switch ($valign) {
                    case 'top':
                        $classvertical = Alignment::VERTICAL_TOP;
                        break;
                    case 'bottom':
                        $classvertical = Alignment::VERTICAL_BOTTOM;
                        break;
                }
            }
            $objPHPExcel->getActiveSheet()->getStyle($alphas[$arrKolom] . "1")->getAlignment()->setVertical($classvertical);

            $classhorizontal = Alignment::HORIZONTAL_LEFT;
            if (isset($halign)) {
                switch ($halign) {
                    case 'center':
                        $classhorizontal = Alignment::HORIZONTAL_CENTER;
                        break;
                    case 'right':
                        $classhorizontal = Alignment::HORIZONTAL_RIGHT;
                        break;
                }
            }
            $objPHPExcel->getActiveSheet()->getStyle($alphas[$arrKolom] . "1")->getAlignment()->setHorizontal($classhorizontal);
            $loop++;
            $arrKolom++;
        }
        if (isset($rsl)) {
            $nomor = 1;
            $rowloc = 2;
            foreach ($rsl as $key => $value) {
                $colloc = 0;
                $arrKolom = 0;
                foreach ($col as $colvalue) {
                    foreach ($colvalue as $keycol => $valuecol) {
                        $ketemu = false;
                        if ($keycol == "namanya") {
                            if ($valuecol == "nomor") {
                                $valueval = $nomor;
                            } else {
                                $valueval = $value->$valuecol;
                            }
                            $objPHPExcel->getActiveSheet()->setCellValue($alphas[$arrKolom] . $rowloc, $valueval);
                            $objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$arrKolom])->setAutoSize(true);
                            $ketemu = true;
                        }
                        if ($keycol == "format") {
                            switch ($valuecol) {
                                case 'datetime':
                                    $objPHPExcel->getActiveSheet()->getStyle($alphas[$arrKolom] . $rowloc)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
                                    break;
                                case 'angkakoma':
                                    $objPHPExcel->getActiveSheet()->getStyle($alphas[$arrKolom] . $rowloc)->getNumberFormat()->setFormatCode('_(#,##0.00_);_(\(#,##0.00\);_("-"??_);_(@_)');
                                    break;
                            }
                        }
                    }
                    $arrKolom++;
                }
                $rowloc++;
                $nomor++;
            }
        }

        header('Content-Type: application/vnd.ms-excel'); // mime type
        header('Content-Disposition: attachment;filename="' . $sFILNAM . '.xls"'); // nama file
        header('Cache-Control: max-age=0'); // no cache

        // Excel5 (PHPExcel) -> Xls (PhpSpreadsheet), tetap format .xls 2003.
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Xls');
        $objWriter->save('php://output');
    }

    function createColumnsArray($end_column, $first_letters = '')
    {
        $columns = array();
        $length = strlen($end_column);
        $letters = range('A', 'Z');

        foreach ($letters as $letter) {
            $column = $first_letters . $letter;
            $columns[] = $column;
            if ($column == strtoupper($end_column)) {
                return $columns;
            }
        }

        foreach ($columns as $column) {
            if (!in_array(strtoupper($end_column), $columns) && strlen($column) < $length) {
                $new_columns = $this->createColumnsArray(strtoupper($end_column), $column);
                $columns = array_merge($columns, $new_columns);
            }
        }

        return $columns;
    }
}
