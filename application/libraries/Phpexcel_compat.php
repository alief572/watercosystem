<?php
defined('BASEPATH') or defined('FCPATH') or exit('No direct script access allowed');

/**
 * Lapisan kompatibilitas PHPExcel -> PhpSpreadsheet (PHP 8.3).
 *
 * PHPExcel (abandoned) memakai nama kelas bergaya underscore global
 * (PHPExcel, PHPExcel_IOFactory, PHPExcel_Style_*, dll). PhpSpreadsheet
 * memakai namespace. File ini membuat class_alias dari nama lama ke kelas
 * PhpSpreadsheet, sehingga kode `new PHPExcel()` / `PHPExcel_Style_Border::...`
 * yang masih tersebar tetap jalan tanpa menulis ulang seluruh controller.
 *
 * CATATAN yang TETAP harus diubah manual di tiap pemanggil (tidak tertutup alias):
 *  - Key array style 'allborders' -> 'allBorders' (string, bukan nama kelas).
 *  - Nama writer 'Excel5'  -> 'Xls', 'Excel2007' -> 'Xlsx' (string argumen).
 *
 * Dipakai via: $this->load->library('Phpexcel_compat');
 * (CI akan meng-include file ini; alias langsung aktif saat file dimuat.)
 *
 * ponytail: hanya alias simbol yang BENAR-BENAR dipakai repo (lihat inventaris
 * Task 2.3). Tambah baris alias baru bila muncul simbol PHPExcel_* lain.
 */
class Phpexcel_compat
{
    public function __construct()
    {
        self::register();
    }

    public static function register()
    {
        static $done = false;
        if ($done) {
            return;
        }
        $done = true;

        $map = array(
            'PHPExcel'                      => '\\PhpOffice\\PhpSpreadsheet\\Spreadsheet',
            'PHPExcel_IOFactory'            => '\\PhpOffice\\PhpSpreadsheet\\IOFactory',
            'PHPExcel_Style_Border'         => '\\PhpOffice\\PhpSpreadsheet\\Style\\Border',
            'PHPExcel_Style_Fill'           => '\\PhpOffice\\PhpSpreadsheet\\Style\\Fill',
            'PHPExcel_Style_Alignment'      => '\\PhpOffice\\PhpSpreadsheet\\Style\\Alignment',
            'PHPExcel_Style_NumberFormat'   => '\\PhpOffice\\PhpSpreadsheet\\Style\\NumberFormat',
            'PHPExcel_Style_Color'          => '\\PhpOffice\\PhpSpreadsheet\\Style\\Color',
            'PHPExcel_Style_Font'           => '\\PhpOffice\\PhpSpreadsheet\\Style\\Font',
            'PHPExcel_Cell_DataType'        => '\\PhpOffice\\PhpSpreadsheet\\Cell\\DataType',
            'PHPExcel_Cell'                 => '\\PhpOffice\\PhpSpreadsheet\\Cell\\Cell',
            'PHPExcel_Worksheet'            => '\\PhpOffice\\PhpSpreadsheet\\Worksheet\\Worksheet',
            'PHPExcel_Worksheet_PageSetup'  => '\\PhpOffice\\PhpSpreadsheet\\Worksheet\\PageSetup',
            'PHPExcel_Settings'             => '\\PhpOffice\\PhpSpreadsheet\\Settings',
            'PHPExcel_RichText'             => '\\PhpOffice\\PhpSpreadsheet\\RichText\\RichText',
            'PHPExcel_Shared_Date'          => '\\PhpOffice\\PhpSpreadsheet\\Shared\\Date',
        );

        foreach ($map as $old => $new) {
            if (!class_exists($old, false) && class_exists($new)) {
                class_alias($new, $old);
            }
        }
    }
}

// Daftarkan alias segera saat file ini dimuat (CI load->library meng-include file).
Phpexcel_compat::register();
