<?php

defined('BASEPATH') || exit('No direct script access allowed');
/**
 * @Author  : Suwito
 * @Email   : suwito.lt@gmail.com
 * @Date    : 2017-01-26 13:36:42
 * @Last Modified by    : Yunaz
 * @Last Modified time  : 2017-01-26 22:15:59
 */

/**
 * A simple helper method for checking menu items against the current class/controller.
 * This function copied from cibonfire
 * <code>
 *   <a href="<?php echo site_url(SITE_AREA . '/content'); ?>" <?php echo check_class(SITE_AREA . '/content'); ?> >
 *    Admin Home
 *  </a>.
 *
 * </code>
 *
 * @param string $item       the name of the class to check against
 * @param bool   $class_only If true, will only return 'active'. If false, will
 *                           return 'class="active"'.
 *
 * @return string either 'active'/'class="active"' or an empty string
 */
function get_supplier($id = false)
{
    $CI = &get_instance();
    $CI->db->where('id_supplier', $id);
    $result = $CI->db->get('supplier')->row();

    return $result->group_produk;
}
function getColsChar($colums){
	// Palleng by jester

	if($colums>26)
	{
		$modCols = floor($colums/26);
		$ExCols = $modCols*26;
		$totCols = $colums-$ExCols;

		if($totCols==0)
		{
			$modCols=$modCols-1;
			$totCols+=26;
		}

		$lets1 = getLetColsLetter($modCols);
		$lets2 = getLetColsLetter($totCols);
		return $letsi = $lets1.$lets2;
	}
	else
	{
		$lets = getLetColsLetter($colums);
		return $letsi = $lets;
	}
}
function getLetColsLetter($numbs){
// Palleng by jester
	switch($numbs){
		case 1:
		$Chars = 'A';
		break;
		case 2:
		$Chars = 'B';
		break;
		case 3:
		$Chars = 'C';
		break;
		case 4:
		$Chars = 'D';
		break;
		case 5:
		$Chars = 'E';
		break;
		case 6:
		$Chars = 'F';
		break;
		case 7:
		$Chars = 'G';
		break;
		case 8:
		$Chars = 'H';
		break;
		case 9:
		$Chars = 'I';
		break;
		case 10:
		$Chars = 'J';
		break;
		case 11:
		$Chars = 'K';
		break;
		case 12:
		$Chars = 'L';
		break;
		case 13:
		$Chars = 'M';
		break;
		case 14:
		$Chars = 'N';
		break;
		case 15:
		$Chars = 'O';
		break;
		case 16:
		$Chars = 'P';
		break;
		case 17:
		$Chars = 'Q';
		break;
		case 18:
		$Chars = 'R';
		break;
		case 19:
		$Chars = 'S';
		break;
		case 20:
		$Chars = 'T';
		break;
		case 21:
		$Chars = 'U';
		break;
		case 22:
		$Chars = 'V';
		break;
		case 23:
		$Chars = 'W';
		break;
		case 24:
		$Chars = 'X';
		break;
		case 25:
		$Chars = 'Y';
		break;
		case 26:
		$Chars = 'Z';
		break;
	}

	return $Chars;
}
function get_invoice($id = false)
{
    $CI = &get_instance();
    $CI->db->where('no_po', $id);
    $result = $CI->db->get('trans_po_invoice')->row();

    return $result->no_invoice;
}

function check_class($item = '', $class_only = false)
{
    if (strtolower(get_instance()->router->class) == strtolower($item)) {
        return $class_only ? 'active' : 'class="active"';
    }

    return '';
}

/**
 * A simple helper method for checking menu items against the current method
 * (controller action) (as far as the Router knows).
 *
 * @param string $item       The name of the method to check against. Can be an array of names.
 * @param bool   $class_only If true, will only return 'active'. If false, will return 'class="active"'.
 *
 * @return string either 'active'/'class="active"' or an empty string
 */
function check_method($item, $class_only = false)
{
    $items = is_array($item) ? $item : array($item);
    if (in_array(get_instance()->router->method, $items)) {
        return $class_only ? 'active' : 'class="active"';
    }

    return '';
}

/**
 * Check if the logged user has permission or not.
 *
 * @param string $permission_name
 *
 * @return bool True if has permission and false if not
 */
function has_permission($permission_name = '')
{
    $ci = &get_instance();

    $return = $ci->auth->has_permission($permission_name);

    return $return;
}

/**
 * @param string $kode_tambahan
 *
 * @return string generated code
 */
function gen_primary($kode_tambahan = '')
{
    $CI = &get_instance();

    $tahun = intval(date('Y'));
    $bulan = intval(date('m'));
    $hari = intval(date('d'));
    $jam = intval(date('H'));
    $menit = intval(date('i'));
    $detik = intval(date('s'));
    $temp_ip = ($CI->input->ip_address()) == '::1' ? '127.0.0.1' : $CI->input->ip_address();
    $temp_ip = explode('.', $temp_ip);
    $ipval = $temp_ip[0] + $temp_ip[1] + $temp_ip[2] + $temp_ip[3];

    $kode_rand = mt_rand(1, 1000) + $ipval;
    $letter1 = chr(mt_rand(65, 90));
    $letter2 = chr(mt_rand(65, 90));

    $kode_primary = $tahun.$bulan.$hari.$jam.$menit.$detik.$letter1.$kode_rand.$letter2;

    return $kode_tambahan.$kode_primary;
}

if (!function_exists('gen_idcustomer')) {
    function gen_idcustomer($kode_tambahan = '')
    {
        $CI = &get_instance();
        $CI->load->model('Customer/Customer_model');

        $query = $CI->Customer_model->generate_id($kode_tambahan);
        if (empty($query)) {
            return 'Error';
        } else {
            return $query;
        }
    }
}

if (!function_exists('gen_id_toko')) {
    function gen_id_toko($kode_tambahan = '')
    {
        $CI = &get_instance();
        $CI->load->model('Customer/Toko_model');

        $query = $CI->Toko_model->generate_id($kode_tambahan);
        if (empty($query)) {
            return 'Error';
        } else {
            return $query;
        }
    }
}

if (!function_exists('get_id_pnghn')) {
    function get_id_pnghn($kode_tambahan = '')
    {
        $CI = &get_instance();
        $CI->load->model('Customer/Penagihan_model');

        $query = $CI->Penagihan_model->generate_id($kode_tambahan);
        if (empty($query)) {
            return 'Error';
        } else {
            return $query;
        }
    }
}

if (!function_exists('get_id_pmbyr')) {
    function get_id_pmbyr($kode_tambahan = '')
    {
        $CI = &get_instance();
        $CI->load->model('Customer/Pembayaran_model');

        $query = $CI->Pembayaran_model->generate_id($kode_tambahan);
        if (empty($query)) {
            return 'Error';
        } else {
            return $query;
        }
    }
}

if (!function_exists('get_id_pic')) {
    function get_id_pic($kode_tambahan = '')
    {
        $CI = &get_instance();
        $CI->load->model('Customer/Pic_model');

        $query = $CI->Pic_model->generate_id($kode_tambahan);
        if (empty($query)) {
            return 'Error';
        } else {
            return $query;
        }
    }
}

if (!function_exists('gen_idsupplier')) {
    function gen_idsupplier($kode_tambahan = '')
    {
        $CI = &get_instance();
        $CI->load->model('Supplier/Supplier_model');

        $query = $CI->Supplier_model->generate_id($kode_tambahan);
        if (empty($query)) {
            return 'Error';
        } else {
            return $query;
        }
    }
}

if (!function_exists('simpan_aktifitas')) {
    function simpan_aktifitas($nm_hak_akses = '', $kode_universal = '', $keterangan = '', $jumlah = 0, $sql = '', $status = null)
    {
        $CI = &get_instance();

        $CI->load->model('aktifitas/aktifitas_model');

        $result = $CI->aktifitas_model->simpan_aktifitas($nm_hak_akses, $kode_universal, $keterangan, $jumlah, $sql, $status);

        return $result;
    }
}

/*
* $date_from is the date with format dd/mm/yyyy H:i:s / dd/mm/yyyy
*/
if (!function_exists('date_ymd')) {
    function date_ymd($date_from)
    {
        $error = false;
        if (strlen($date_from) <= 10) {
            list($dd, $mm, $yyyy) = explode('/', $date_from);

            if (!checkdate(intval($mm), intval($dd), intval($yyyy))) {
                $error = true;
            }
        } else {
            list($dd, $mm, $yyyy) = explode('/', $date_from);
            list($yyyy, $hhii) = explode(' ', $yyyy);

            if (!checkdate($mm, $dd, $yyyy)) {
                $error = true;
            }
        }

        if ($error) {
            return false;
        }

        if (strlen($date_from) <= 10) {
            $date_from = DateTime::createFromFormat('d/m/Y', $date_from);
            $date_from = $date_from->format('Y-m-d');
        } else {
            $date_from = DateTime::createFromFormat('d/m/Y H:i', $date_from);
            $date_from = $date_from->format('Y-m-d H:i');
        }

        return $date_from;
    }
}

if (!function_exists('simpan_alurkas')) {
    function simpan_alurkas($kode_accountKas = null, $ket = '', $total = null, $status = null, $nm_hak_akses = '')
    {
        $CI = &get_instance();

        $CI->load->model('kas/kas_model');

        $result = $CI->kas_model->simpan_alurKas($kode_accountKas, $ket, $total, $status, $nm_hak_akses);

        return $result;
    }
}

if (!function_exists('buatrp')) {
    function buatrp($angka)
    {
        $jadi = 'Rp '.number_format($angka, 0, ',', '.');

        return $jadi;
    }
}

if (!function_exists('formatnomor')) {
    function formatnomor($angka)
    {
        if ($angka) {
            $jadi = number_format($angka, 0, ',', '.');

            return $jadi;
        }
    }
}

if (!function_exists('separator')) {
    function separator($angka)
    {
        if ($angka) {
            $jadi = number_format($angka, 0, '.', '.');

            return $jadi;
        }
    }
}

if (!function_exists('ynz_terbilang_format')) {
    function ynz_terbilang_format($x)
    {
        $x = abs($x);
        $angka = array('', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas');
        $temp = '';
        if ($x < 12) {
            $temp = ' '.$angka[$x];
        } elseif ($x < 20) {
            $temp = ynz_terbilang_format($x - 10).' belas';
        } elseif ($x < 100) {
            $temp = ynz_terbilang_format($x / 10).' puluh'.ynz_terbilang_format($x % 10);
        } elseif ($x < 200) {
            $temp = ' seratus'.ynz_terbilang_format($x - 100);
        } elseif ($x < 1000) {
            $temp = ynz_terbilang_format($x / 100).' ratus'.ynz_terbilang_format($x % 100);
        } elseif ($x < 2000) {
            $temp = ' seribu'.ynz_terbilang_format($x - 1000);
        } elseif ($x < 1000000) {
            $temp = ynz_terbilang_format($x / 1000).' ribu'.ynz_terbilang_format($x % 1000);
        } elseif ($x < 1000000000) {
            $temp = ynz_terbilang_format($x / 1000000).' juta'.ynz_terbilang_format($x % 1000000);
        } elseif ($x < 1000000000000) {
            $temp = ynz_terbilang_format($x / 1000000000).' milyar'.ynz_terbilang_format(fmod($x, 1000000000));
        } elseif ($x < 1000000000000000) {
            $temp = ynz_terbilang_format($x / 1000000000000).' trilyun'.ynz_terbilang_format(fmod($x, 1000000000000));
        }

        return $temp;
    }
}

if (!function_exists('ynz_terbilang')) {
    function ynz_terbilang($x, $style = 1)
    {
        if ($x < 0) {
            $hasil = 'minus '.trim(ynz_terbilang_format($x));
        } else {
            $hasil = trim(ynz_terbilang_format($x));
        }
        switch ($style) {
        case 1:
            $hasil = strtoupper($hasil);
            break;
        case 2:
            $hasil = strtolower($hasil);
            break;
        case 3:
            $hasil = ucwords($hasil);
            break;
        default:
            $hasil = ucfirst($hasil);
            break;
        }

        return $hasil;
    }
}

if (!function_exists('tipe_pengiriman')) {
    function tipe_pengiriman($ket = false)
    {
        $uu = array(
            'SENDIRI' => 'MILIK SENDIRI',
            'SEWA' => 'SEWA',
            'EKSPEDISI' => 'EKSPEDISI',
            'PELANGGAN' => 'PELANGGAN AMBIL SENDIRI',
            );
        if ($ket == true) {
            return $uu[$ket];
        } else {
            return $uu;
        }
    }
}

if (!function_exists('selisih_hari')) {
    function selisih_hari($tgl, $now)
    {
        $aw = new DateTime($tgl);
        $ak = new DateTime($now);
        $interval = $aw->diff($ak);

        return $interval->days;
    }
}

if (!function_exists('kategori_umur_piutang')) {
    function kategori_umur_piutang($ket = false)
    {
        $uu = array(
            '0|14' => '0-14',
            '15|29' => '15-29',
            '30|59' => '30-59',
            '60|89' => '60-89',
            '90' => '>90',
            );
        if ($ket == true) {
            return $uu[$ket];
        } else {
            return $uu;
        }
    }
}

if (!function_exists('the_bulan')) {
    function the_bulan($time = false)
    {
        $a = array('1' => 'Januari',
            '2' => 'Februari',
            '3' => 'Maret',
            '4' => 'April',
            '5' => 'Mei',
            '6' => 'Juni',
            '7' => 'Juli',
            '8' => 'Agustus',
            '9' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        );

        return $time == false ? $a : $a[$time];
    }
}

if (!function_exists('bulan')) {
    function bulan($time = false)
    {
        $a = array('01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        );

        return $time == false ? $a : $a[$time];
    }
}

if (!function_exists('is_jenis_bayar')) {
    function is_jenis_bayar($ket = false)
    {
        $uu = array(
            'CASH' => 'CASH',
            'TRANSFER' => 'TRANSFER',
            'BG' => 'GIRO',
            );
        if ($ket == true) {
            return $uu[$ket];
        } else {
            return $uu;
        }
    }
}

if (!function_exists('is_status_giro')) {
    function is_status_giro($ket = false)
    {
        $uu = array(
            'OPEN' => 'OPEN',
            'INV' => 'INVOICE',
            'CAIR' => 'CAIR',
            'TOLAK' => 'TOLAK',
            );
        if ($ket == true) {
            return $uu[$ket];
        } else {
            return $uu;
        }
    }
}

if (!function_exists('is_filter_report_jual')) {
    function is_filter_report_jual($ket = false)
    {
        $uu = array(
            'by_customer' => 'Per Customer',
            'by_sales' => 'Per Sales',
            );
        if ($ket == true) {
            return $uu[$ket];
        } else {
            return $uu;
        }
    }
}

if (!function_exists('is_filter_detail_jual')) {
    function is_filter_detail_jual($ket = false)
    {
        $uu = array(
            'by_produk' => 'Per Produk',
            'by_customer' => 'Per Customer',
            'by_sales' => 'Per Sales',
            );
        if ($ket == true) {
            return $uu[$ket];
        } else {
            return $uu;
        }
    }
}

    function tgl_indo($tgl){
			$tanggal = substr($tgl,8,2);
			$bulan =substr($tgl,5,2);
			$tahun = substr($tgl,0,4);
			return $tanggal.'-'.$bulan.'-'.$tahun;		 
	}
	function get10hari($id){
					$hariini = date('Y-m-d H:i:s');
					$sepuluh_hari = mktime(0,0,0,date('n'),date('j')-10,date('Y'));
					$tendays = date("Y-m-d H:i:s", $sepuluh_hari);
					$this->db->select('AVG(nominal) avg_nominal') ;
					$this->db->from('child_history_lme');
					$this->db->where('id_category1', $id);
					$this->db->where('created_on >=', $tendays);
					$this->db->where('created_on <=', $hariini);
					$query = $this->db->get();
					$tenrata['avg_nominal'];
	}	

    function checkApprove($id){
        $CI 	=& get_instance();
		$query	= $CI->db->get_where('dt_spkmarketing', array('deal'=>'1','id_spkmarketing'=>$id))->result_array();
		return $query;
    }
	
	function get_dashboard_stock(){
        $CI 	=& get_instance();
		$query	= $CI->db
                        ->select('
                            a.nama AS nm_lv2,
                            a.id_category2 AS category_lv2,
                            b.nama AS nm_lv1,
                            a.aktif AS status,
                            c.berat
                        ')
                        ->from('ms_inventory_category2 a')
                        ->join('ms_inventory_category1 b', 'a.id_category1=b.id_category1','left')
                        ->join('stock_lv2 c', 'a.id_category2=c.id2','left')
                        ->where('a.deleted','0')
                        ->get()
                        ->result_array();
		return $query;
    }

    function get_name($table, $field, $where, $value){
        $CI = &get_instance();
        $query = "SELECT ".$field." FROM ".$table." WHERE ".$where."='".$value."' LIMIT 1";
        $result = $CI->db->query($query)->result();
        $hasil = (!empty($result))?$result[0]->$field:'';
        if(empty($result)){
            $hasil = $value;
        }
        return $hasil;
    }