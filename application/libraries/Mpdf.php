<?php
defined('BASEPATH') or defined('FCPATH') or exit('No direct script access allowed');

/**
 * Shim kompatibilitas mPDF 5.7 -> mPDF 8 (PHP 8.3).
 *
 * File ini DULU berisi bundled mPDF 5.7.1 (puluhan ribu baris, penuh `each()` &
 * pola PHP 5 yang fatal di PHP 8). Diganti dengan shim tipis yang meng-extend
 * mPDF 8.2.7 dari Composer (vendor/mpdf/mpdf) agar SEMUA pemanggilan lama tetap
 * jalan tanpa menyentuh puluhan controller:
 *
 *   $this->load->library('Mpdf');          // CI me-load file ini
 *   $mpdf = new mPDF();                     // argumen posisional gaya 5.7
 *   $mpdf = new mPDF('utf-8', 'A4', 'P');
 *   $mpdf = new mPDF('utf-8', array(216,279), 10,5,5,16,16,1,4,'P');
 *   $mpdf->SetImportUse();                  // no-op di mPDF 8 (import via FPDI otomatis)
 *   $mpdf->WriteHTML($html); $mpdf->Output();
 *
 * Kelas global `Mpdf` (PHP case-insensitive, jadi cocok dengan `new mPDF`)
 * meng-extend `\Mpdf\Mpdf` dan menerjemahkan argumen posisional 5.7 ke array
 * config mPDF 8.
 *
 * ponytail: translasi posisional->config menutup pola pemanggilan yang ADA di
 * repo saat ini (lihat inventaris Task 1.2). Jika nanti ada pola konstruktor
 * baru di luar daftar itu, tambahkan pemetaannya di sini.
 */
class Mpdf extends \Mpdf\Mpdf
{
    public function __construct(
        $mode = '',
        $format = '',
        $default_font_size = 0,
        $default_font = '',
        $mgl = null,
        $mgr = null,
        $mgt = null,
        $mgb = null,
        $mgh = null,
        $mgf = null,
        $orientation = ''
    ) {
        $config = array();

        if ($mode !== '' && $mode !== null) {
            $config['mode'] = $mode;
        }
        // format bisa string ('A4', 'A5-L') atau array ([216,279]); hanya kirim bila terisi.
        if ($format !== '' && $format !== null && $format !== array()) {
            $config['format'] = $format;
        }
        // Di mPDF 5.7 slot ke-3 adalah default_font_size, TAPI banyak controller
        // keliru mengirim orientation ('P'/'L') ke sini (mis. new mPDF('utf-8','A4','P')).
        // mPDF 5.7 memaafkan (non-numeric diabaikan); mPDF 8 ketat -> TypeError.
        // Jadi: numerik -> font size; 'P'/'L' -> perlakukan sebagai orientation.
        if (is_numeric($default_font_size) && $default_font_size > 0) {
            $config['default_font_size'] = $default_font_size + 0;
        } elseif (is_string($default_font_size)) {
            $o = strtoupper(trim($default_font_size));
            if (($o === 'P' || $o === 'L') && ($orientation === '' || $orientation === null)) {
                $orientation = $o;
            }
        }
        if ($default_font !== '' && $default_font !== null) {
            $config['default_font'] = $default_font;
        }
        if ($mgl !== null && $mgl !== '') {
            $config['margin_left'] = $mgl;
        }
        if ($mgr !== null && $mgr !== '') {
            $config['margin_right'] = $mgr;
        }
        if ($mgt !== null && $mgt !== '') {
            $config['margin_top'] = $mgt;
        }
        if ($mgb !== null && $mgb !== '') {
            $config['margin_bottom'] = $mgb;
        }
        if ($mgh !== null && $mgh !== '') {
            $config['margin_header'] = $mgh;
        }
        if ($mgf !== null && $mgf !== '') {
            $config['margin_footer'] = $mgf;
        }
        if ($orientation !== '' && $orientation !== null) {
            $config['orientation'] = $orientation;
        }

        // Direktori temp writable. mPDF 8 membuat subfolder di bawah tempDir dan mengecek
        // writable-nya; di volume mount (Docker Desktop Windows) is_writable() bisa bohong,
        // jadi kita uji TULIS NYATA ke subfolder '/mpdf' (meniru perilaku mPDF). Prioritas
        // APPPATH/cache/mpdf (baik untuk Apache production), fallback sys_get_temp_dir()/mpdf.
        if (!isset($config['tempDir'])) {
            $candidates = array();
            if (defined('APPPATH')) {
                $candidates[] = APPPATH . 'cache/mpdf';
            }
            $candidates[] = sys_get_temp_dir() . '/mpdf';
            foreach ($candidates as $tmp) {
                $sub = $tmp . '/mpdf'; // mPDF akan memakai subfolder ini
                @mkdir($sub, 0777, true);
                $probe = $sub . '/.wtest_' . getmypid();
                if (@file_put_contents($probe, 'x') !== false) {
                    @unlink($probe);
                    $config['tempDir'] = $tmp;
                    break;
                }
            }
        }

        parent::__construct($config);
    }

    /**
     * No-op: di mPDF 5.7 ini menyiapkan import template PDF. Di mPDF 8 impor PDF
     * (FPDI) sudah otomatis lewat setSourceFile()/importPage(), jadi tidak ada
     * padanan — dibuat no-op agar `$mpdf->SetImportUse()` warisan tidak fatal.
     */
    public function SetImportUse()
    {
        return $this;
    }
}
