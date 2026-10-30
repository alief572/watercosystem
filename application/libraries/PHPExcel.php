<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!class_exists('\\PhpOffice\\PhpSpreadsheet\\Spreadsheet', false)) {
    if (defined('FCPATH') && file_exists(FCPATH . 'vendor/autoload.php')) {
        require_once FCPATH . 'vendor/autoload.php';
    } elseif (defined('BASEPATH') && file_exists(dirname(BASEPATH) . '/vendor/autoload.php')) {
        require_once dirname(BASEPATH) . '/vendor/autoload.php';
    }
}

require_once APPPATH . 'libraries/Phpexcel_compat.php';
