<?php

/**
 * Shim kompatibilitas HTML2PDF 4.03 -> Spipu\Html2Pdf 5.3 (PHP 8.3).
 *
 * File ini DULU berisi HTML2PDF 4.03 + TCPDF 5.0.002 (fatal di PHP 8; sudah
 * bermasalah bahkan di PHP 5.6 belakangan — lihat log Agustus 2026). Diganti
 * dengan shim tipis agar SEMUA pemanggilan lama tetap jalan tanpa menyentuh
 * puluhan controller yang memakai:
 *
 *   require_once('./assets/html2pdf/html2pdf/html2pdf.class.php');
 *   $html2pdf = new HTML2PDF('P','A4','en',true,'UTF-8',array(0,0,0,0));
 *   $html2pdf->pdf->SetDisplayMode('fullpage');   // ->pdf public di Spipu juga
 *   $html2pdf->WriteHTML($html);                  // case-insensitive -> writeHTML
 *   $html2pdf->Output('file.pdf','I');            // -> output
 *
 * Signature konstruktor Spipu 5.3 identik urutannya dengan HTML2PDF 4.03
 * (orientation, format, lang, unicode, encoding, margins, [pdfa]), jadi tidak
 * perlu translasi argumen. Properti `->pdf` (objek MyPdf extends TCPDF) juga
 * public di Spipu, sehingga `->pdf->SetDisplayMode()` / `->setHeaderFont()` /
 * `->setFooterFont()` yang dipakai controller tetap valid.
 *
 * ponytail: shim murni subclass karena API-nya sudah sejajar. Kalau nanti ada
 * pemakaian method/properti TCPDF yang tak ada di MyPdf Spipu, tangani di sini.
 */

if (!defined('__CLASS_HTML2PDF__')) {

    define('__CLASS_HTML2PDF__', 'shim-spipu-5.3');

    // Pastikan autoload Composer tersedia (di jalur CI normal sudah aktif via
    // config composer_autoload; ini fallback bila file di-include lebih awal).
    if (!class_exists('\\Spipu\\Html2Pdf\\Html2Pdf')) {
        if (defined('FCPATH') && is_file(FCPATH . 'vendor/autoload.php')) {
            require_once FCPATH . 'vendor/autoload.php';
        } else {
            $autoload = dirname(__FILE__) . '/../../../vendor/autoload.php';
            if (is_file($autoload)) {
                require_once $autoload;
            }
        }
    }

    class HTML2PDF extends \Spipu\Html2Pdf\Html2Pdf
    {
        // Tidak ada override: konstruktor + ->pdf + writeHTML/output diwarisi
        // langsung dari Spipu dengan signature yang kompatibel.
    }
}
