<?php

if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

/*
 * @author Ichsan
 * @copyright Copyright (c) 2019, Ichsan
 *
 * This is controller for Master Supplier
 */

class Purchase_order extends Admin_Controller
{
	//Permission
	protected $viewPermission 	= 'Purchase_Order.View';
	protected $addPermission  	= 'Purchase_Order.Add';
	protected $managePermission = 'Purchase_Order.Manage';
	protected $deletePermission = 'Purchase_Order.Delete';

	public function __construct()
	{
		parent::__construct();
		require_once 'vendor/autoload.php';

		$this->load->library(array('upload', 'Image_lib'));
		$this->load->model(array(
			'Purchase_order/Pr_model',
			'Aktifitas/aktifitas_model',
		));
		$this->template->title('Manage Data Supplier');
		$this->template->page_icon('fa fa-building-o');

		date_default_timezone_set('Asia/Bangkok');
	}
	public function index()
	{
		$this->auth->restrict($this->viewPermission);
		$session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
		$data = $this->db->query("SELECT a.*, b.name_suplier as namesup FROM tr_purchase_order as a INNER JOIN master_supplier as b on a.id_suplier = b.id_suplier ORDER BY a.no_po DESC")->result();
		$this->template->set('results', $data);
		$this->template->title('Purchase Order');
		$this->template->render('index');
	}

	public function add()
	{
		$this->auth->restrict($this->viewPermission);
		$session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$aktif = 'active';
		$deleted = '0';
		$supplier = $data = $this->db->query("SELECT a.* FROM master_supplier as a INNER JOIN dt_trans_pr as b on b.suplier = a.id_suplier INNER JOIN tr_purchase_request as c on b.no_pr = c.no_pr WHERE c.status = '2' GROUP BY b.suplier ")->result();
		$comp	= $this->db->query("select a.*, b.nominal as nominal_harga FROM ms_compotition as a inner join child_history_lme as b on b.id_compotition=a.id_compotition where a.deleted='0' and b.status='0' ")->result();
		$customers = $this->Pr_model->get_data('master_customers', 'deleted', $deleted);
		$karyawan = $this->Pr_model->get_data('ms_karyawan', 'deleted', $deleted);
		$mata_uang = $this->Pr_model->get_data('mata_uang', 'deleted' . $deleted);
		$matauang = $this->db->get_where('matauang')->result();
		$data = [
			'supplier' => $supplier,
			'comp' => $comp,
			'customers' => $customers,
			'karyawan' => $karyawan,
			'mata_uang' => $mata_uang,
			'matauang' => $matauang,
		];
		$this->template->set('results', $data);
		$this->template->title('Purchase Order');
		$this->template->render('Add');
	}
	public function edit()
	{
		$id = $this->uri->segment(3);
		$this->auth->restrict($this->viewPermission);
		$session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$aktif = 'active';
		$deleted = '0';
		$head = $this->db->query("SELECT * FROM tr_purchase_order  WHERE no_po = '$id' ")->result();
		$comp	= $this->db->query("select a.*, b.nominal as nominal_harga FROM ms_compotition as a inner join child_history_lme as b on b.id_compotition=a.id_compotition where a.deleted='0' and b.status='0' ")->result();
		$detail = $this->db->query("SELECT * FROM dt_trans_po  WHERE no_po = '$id' ")->result_array();
		$supplier = $data = $this->db->query("SELECT a.* FROM master_supplier as a INNER JOIN dt_trans_pr as b on b.suplier = a.id_suplier INNER JOIN tr_purchase_request as c on b.no_pr = c.no_pr WHERE c.status = '2' GROUP BY b.suplier ")->result();
		$customers = $this->Pr_model->get_data('master_customers', 'deleted', $deleted);
		$karyawan = $this->Pr_model->get_data('ms_karyawan', 'deleted', $deleted);
		$mata_uang = $this->Pr_model->get_data('mata_uang', 'deleted' . $deleted);
		$matauang = $this->db->get_where('matauang')->result();
		$data = [
			'head' => $head,
			'comp' => $comp,
			'detail' => $detail,
			'supplier' => $supplier,
			'customers' => $customers,
			'karyawan' => $karyawan,
			'mata_uang' => $mata_uang,
			'matauang' => $matauang,
		];
		$this->template->set('results', $data);
		$this->template->title('Purchase Order');
		$this->template->render('Edit');
	}
	public function Lihat()
	{
		$id = $this->uri->segment(3);
		$this->auth->restrict($this->viewPermission);
		$session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$aktif = 'active';
		$deleted = '0';
		$comp	= $this->db->query("select a.*, b.nominal as nominal_harga FROM ms_compotition as a inner join child_history_lme as b on b.id_compotition=a.id_compotition where a.deleted='0' and b.status='0' ")->result();
		$head = $this->db->query("SELECT a.*, b.name_suplier as suplier FROM tr_purchase_order as a INNER JOIN master_supplier as b on a.id_suplier = b.id_suplier  WHERE a.no_po = '$id' ")->result();
		$detail = $this->db->query("SELECT a.*, b.nama  FROM dt_trans_po a
		INNER JOIN ms_inventory_category3 b ON a.idmaterial = b.id_category3
		WHERE no_po = '$id' ")->result();
		$supplier = $data = $this->db->query("SELECT a.* FROM master_supplier as a INNER JOIN dt_trans_pr as b on b.suplier = a.id_suplier INNER JOIN tr_purchase_request as c on b.no_pr = c.no_pr WHERE c.status = '2' ")->result();
		$customers = $this->Pr_model->get_data('master_customers', 'deleted', $deleted);
		$karyawan = $this->Pr_model->get_data('ms_karyawan', 'deleted', $deleted);
		$mata_uang = $this->Pr_model->get_data('mata_uang', 'deleted' . $deleted);
		$matauang = $this->db->get_where('matauang')->result();
		$data = [
			'head' => $head,
			'comp' => $comp,
			'detail' => $detail,
			'supplier' => $supplier,
			'customers' => $customers,
			'karyawan' => $karyawan,
			'mata_uang' => $mata_uang,
			'matauang' => $matauang,
		];
		$this->template->set('results', $data);
		$this->template->title('Purchase Order');
		$this->template->render('View');
	}
	public function add_pr()
	{
		$this->auth->restrict($this->viewPermission);
		$session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$aktif = 'active';
		$deleted = '0';
		$customers = $this->Pr_model->get_data('master_customers', 'deleted', $deleted);
		$karyawan = $this->Pr_model->get_data('ms_karyawan', 'deleted', $deleted);
		$mata_uang = $this->Pr_model->get_data('mata_uang', 'deleted' . $deleted);
		$data = [
			'customers' => $customers,
			'karyawan' => $karyawan,
			'mata_uang' => $mata_uang,
		];
		$this->template->set('results', $data);
		$this->template->title('Add Penawaran');
		$this->template->render('Addpr');
	}
	function CariKurs()
	{

		$loi	= $_GET['loi'];
		$hariini = date('Y-m-d');
		$sepuluh_hari = mktime(0, 0, 0, date('n'), date('j') - 10, date('Y'));
		$tendays = date("Y-m-d", $sepuluh_hari);
		$tglnow = date('d');
		$blnnow = date('m');
		if ($blnnow != '1') {
			$blnkmrn = $blnnow - 1;
			$yearkemaren = date('Y');
		} else {
			$blnkmrn = "12";
			$yearnow = date('Y');
			$yearkemaren = $yearnow - 1;
		}
		$kurs	= $this->db->query("SELECT * FROM mata_uang WHERE kode = 'IDR' ")->result();
		$kurs10hari	= $this->db->query("SELECT AVG(nominal) as nominal FROM perubahan_kurs WHERE tanggal_ubah BETWEEN  '$tendays' AND '$hariini' AND kode_kurs='IDR' ")->result();
		$kurs30hari	= $this->db->query("SELECT AVG(nominal) as nominal FROM perubahan_kurs WHERE MONTH(tanggal_ubah) =  '$blnkmrn' AND YEAR(tanggal_ubah) = '$yearkemaren' AND kode_kurs='IDR' ")->result();
		$nomkurs = $kurs[0]->kurs;
		$nomkurs10 = $kurs10hari[0]->nominal;
		$nomkurs30 = $kurs30hari[0]->nominal;
		$k =  number_format($nomkurs, 2);
		$k10 =  number_format($nomkurs10, 2);
		$k30 =  number_format($nomkurs30, 2);
		if ($loi == 'Import') {
			echo "
				<table class='col-sm-12' border='1' cellspacing='0'>
					<tr>
						<th><center>Kurs On The Spot</center></th>
						<th><center>Kurs 10 Hari</center></th>
						<th><center>Kurs 30 Hari</center></th>
					</tr>
					<tr>
						<td><center>Rp. $k  ,-</center></td>
						<td><center>Rp. $k10  ,-</center></td>
						<td><center>Rp. $k30  ,-</center></td>
					</tr>
				<table>
		";
		} else {
		};
	}
	public function PrintHeader1($id)
	{
		$this->auth->restrict($this->managePermission);
		$id = $this->uri->segment(3);
		$data['header'] = $this->Pr_model->getHeaderPenawaran($id);
		$data['detail']  = $this->Pr_model->PrintDetail($id);
		$this->load->view('PrintHeader', $data);
	}
	public function PrintHeader($id)
	{
		ob_clean();
		ob_start();
		$this->auth->restrict($this->managePermission);
		$id = $this->uri->segment(3);
		$data['header'] = $this->Pr_model->getHeaderPenawaran($id);
		$data['detail']  = $this->Pr_model->PrintDetail($id);
		$this->load->view('PrintHeader', $data);
		$html = ob_get_contents();

		require_once('./assets/html2pdf/html2pdf/html2pdf.class.php');
		$html2pdf = new HTML2PDF('P', 'A4', 'en', true, 'UTF-8', array(0, 0, 0, 0));
		$html2pdf->pdf->SetDisplayMode('fullpage');
		$html2pdf->WriteHTML($html);
		ob_end_clean();
		$html2pdf->Output('Penawaran.pdf', 'I');
	}
	public function EditHeader($id)
	{
		$this->auth->restrict($this->viewPermission);
		$session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$aktif = 'active';
		$deleted = '0';
		$head = $this->Pr_model->get_data('tr_penawaran', 'no_penawaran', $id);
		$customers = $this->Pr_model->get_data('master_customers', 'deleted', $deleted);
		$karyawan = $this->Pr_model->get_data('ms_karyawan', 'deleted', $deleted);
		$mata_uang = $this->Pr_model->get_data('mata_uang', 'deleted', $deleted);
		$data = [
			'customers' => $customers,
			'karyawan' => $karyawan,
			'head' => $head,
			'mata_uang' => $mata_uang,
		];
		$this->template->set('results', $data);
		$this->template->title('Add Penawaran');
		$this->template->render('EditHeader');
	}
	public function detail()
	{
		$id = $this->uri->segment(3);
		$this->auth->restrict($this->viewPermission);
		$session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
		$deleted = '0';
		$detail = $this->Pr_model->getpenawaran($id);
		$header = $this->Pr_model->getHeaderPenawaran($id);
		$data = [
			'detail' => $detail,
			'header' => $header
		];
		$this->template->set('results', $data);
		$this->template->title('Penawaran');
		$this->template->render('detail');
	}

	public function editPenawaran($id)
	{
		$this->auth->restrict($this->viewPermission);
		$session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$penawaran = $this->Pr_model->get_data('child_penawaran', 'id_child_penawaran', $id);
		$inventory_3 = $this->Pr_model->get_data_category();
		$data = [
			'penawaran' => $penawaran,
			'inventory_3' => $inventory_3,
		];
		$this->template->set('results', $data);
		$this->template->title('Edit Penawaran');
		$this->template->render('editPenawaran');
	}



	public function View($id)
	{
		$this->auth->restrict($this->viewPermission);
		$session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$header = $this->db->query("SELECT * FROM tr_purchase_request WHERE no_pr = '$id' ")->result();
		$detail = $this->db->query("SELECT * FROM dt_trans_pr WHERE no_pr = '$id' ")->result();
		$data = [
			'header' => $header,
			'detail' => $detail,
		];
		$this->template->set('results', $data);
		$this->template->title('View P.R');
		$this->template->render('View');
	}

	public function viewPenawaran($id)
	{
		$this->auth->restrict($this->viewPermission);
		$session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$penawaran = $this->Pr_model->get_data('child_penawaran', 'id_child_penawaran', $id);
		$inventory_3 = $this->Pr_model->get_data_category();
		$data = [
			'penawaran' => $penawaran,
			'inventory_3' => $inventory_3,
		];
		$this->template->set('results', $data);
		$this->template->title('Edit Penawaran');
		$this->template->render('viewPenawaran');
	}

	public function viewBentuk($id)
	{
		$this->auth->restrict($this->viewPermission);
		$id 	= $this->input->post('id');
		$bentuk = $this->db->get_where('ms_bentuk', array('id_bentuk' => $id))->result();
		$dimensi = $this->Bentuk_model->getDimensi($id);
		$data = [
			'bentuk' => $bentuk,
			'dimensi' => $dimensi,
		];
		$this->template->set('results', $data);
		$this->template->render('view_bentuk');
	}


	public function addPenawaran($id)
	{
		$this->auth->restrict($this->viewPermission);
		$session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$headpenawaran = $this->Pr_model->get_data('tr_penawaran', 'no_penawaran', $id);
		$inventory_3 = $this->Pr_model->get_data_category();
		$data = [
			'inventory_3' => $inventory_3,
			'headpenawaran' => $headpenawaran
		];
		$this->template->set('results', $data);
		$this->template->title('Add Penawaran');
		$this->template->render('AddPenawaran');
	}

	function AddMaterial()
	{
		$loop		= $_GET['jumlah'] + 1;
		$id_suplier	= $_GET['id_suplier'];
		$loi 		= $_GET['loi'];
		$material 	= $this->db->query("SELECT * FROM dt_trans_pr WHERE suplier = '$id_suplier'  ")->result();

		if ($loi == 'Import') {
			echo "
			<tr id='trmaterial_$loop'>
			<th style='font-size:90%'><select style='font-size:90%' class='form-control chosen-select' id='dt_idpr_" . $loop . "' name='dt[" . $loop . "][idpr]'	onchange ='CariProperties(" . $loop . ")'>
			<option value=''>--Pilih--</option>";
			foreach ($material as $material) {
				$nopr = $material->no_pr;
				$surat = $this->db->query("SELECT * FROM tr_purchase_request WHERE no_pr = '$nopr'")->row();
				echo "<option value='$material->id_dt_pr'>$material->nama_material|$surat->no_surat</option>";
			};
			echo "</select></th>
			<th id='idmaterial_" . $loop . "'	hidden><input  type='text' 	style='font-size:90%'	class='form-control' id='dt_idmaterial_" . $loop . "' 	required name='dt[" . $loop . "][idmaterial]' ></th>
			<th id='namaterial_" . $loop . "'	hidden><input  type='text' 	style='font-size:90%'	class='form-control' id='dt_namamaterial_" . $loop . "' required name='dt[" . $loop . "][namamaterial]' ></th>
			
			<th id='description_" . $loop . "'	style='font-size:90%'><input style='font-size:90%' type='text' 			class='form-control' id='dt_description_" . $loop . "' 	required name='dt[" . $loop . "][description]' ></th>
			
			<th id='width_" . $loop . "'><input  type='number' style='font-size:90%'	class='form-control' id='dt_width_" . $loop . "' 		required name='dt[" . $loop . "][width]' onblur='HitungHarga(" . $loop . ")' ></th>
			
			
			<th id='totalwidth_" . $loop . "'	><input  type='number' style='font-size:90%'	class='form-control' id='dt_totalwidth_" . $loop . "' 	required name='dt[" . $loop . "][totalwidth]' onblur='HitungHarga(" . $loop . ")' ></th>
			
			<th id='qty_" . $loop . "'			hidden style='font-size:90%'><input style='font-size:90%' type='number' 			class='form-control' id='dt_qty_" . $loop . "' 			required name='dt[" . $loop . "][qty]' onkeyup='HitungUP(" . $loop . ")' ></th>
			
			<th 							style='font-size:90%' ><select		style='font-size:90%'				class='form-control' id='dt_ratelme_" . $loop . "' 		required name='dt[" . $loop . "][ratelme]' onchange='CariPrice(" . $loop . ")'>
			<option value=''>-Pilih-</option>
			<option value='Hari Ini'>Hari ini</option>
			<option value='H-10'>H-10</option>
			<option value='H-30'>H-30</option>
			</select></th>
			
			<th id='alloyprice_" . $loop . "'	style='font-size:90%'><input  type='text' 	style='font-size:90%'		class='form-control input-md bilangan-desimal' id='dt_alloyprice_" . $loop . "' 	required data-decimal='.' data-thousand='' data-precision='0' data-allow-zero='' name='dt[" . $loop . "][alloyprice]' onkeyup='HitungUP(" . $loop . ")' ></th>
			
			<th 							style='font-size:90%'><input  type='text' 	style='font-size:90%'		class='form-control input-md' id='dt_fabcost_" . $loop . "' 		required  name='dt[" . $loop . "][fabcost]' onkeyup='HitungUP(" . $loop . ")' ></th>
			
			<th	id='panjang_" . $loop . "'		hidden><input  type='number' style='font-size:90%'	class='form-control' id='dt_panjang_" . $loop . "' 		required name='dt[" . $loop . "][panjang]' onkeyup='HitungHarga(" . $loop . ")'></th>
			<th	id='lebar_" . $loop . "'		hidden><input  type='number' style='font-size:90%'	class='form-control' id='dt_lebar_" . $loop . "' 		required name='dt[" . $loop . "][lebar]' ></th>
			
			<th								style='font-size:90%'><input style='font-size:90%' class='form-control input-md autoNumeric3'		class='form-control' id='dt_hargasatuan_" . $loop . "' data-decimal='.' data-thousand='' data-allow-zero='' 	required name='dt[" . $loop . "][hargasatuan]' onblur='HitungUP(" . $loop . ")'></th>
			
			<th								style='font-size:90%'><input style='font-size:90%' type='text' 			class='form-control bilangan-desimal' id='dt_diskon_" . $loop . "' 		required name='dt[" . $loop . "][diskon]' onkeyup='HitungUPIm(" . $loop . ")'></th>
			
			<th								style='font-size:90%'><input style='font-size:90%' type='text' 			class='form-control bilangan-desimal' id='dt_pajak_" . $loop . "' 		required name='dt[" . $loop . "][pajak]' onkeyup='HitungUPIm(" . $loop . ")'></th>
			
			<th id='jumlahharga_" . $loop . "'	style='font-size:90%'><input style='font-size:90%' readonly type='text' 	class='form-control' id='dt_jumlahharga_" . $loop . "' 	required name='dt[" . $loop . "][jumlahharga]' ></th>
			
			<th								style='font-size:90%'><input style='font-size:90%' type='text' 			class='form-control' id='dt_note_" . $loop . "' 		required name='dt[" . $loop . "][note]' ></th>
			
			<th><button type='button' class='btn btn-sm btn-success' title='Lock' data-role='qtip' onClick='return LockMaterial(" . $loop . ");'><i class='fa fa-key'></i></button>
			<button type='button' class='btn btn-sm btn-danger' title='Hapus Data' data-role='qtip' onClick='return HapusItem(" . $loop . ");'><i class='fa fa-close'></i></button></th>
			</tr>
			";
		} else {
			echo "
			<tr id='trmaterial_$loop'>
			<th style='font-size:90%'><select style='font-size:90%' class='form-control chosen-select' id='dt_idpr_" . $loop . "' name='dt[" . $loop . "][idpr]'	onchange ='CariProperties(" . $loop . ")'>
			<option value=''>--Pilih--</option>";
			foreach ($material as $material) {
				echo "<option value='$material->id_dt_pr'>$material->nama_material</option>";
			};
			echo "</select></th>
			<th id='idmaterial_" . $loop . "'	hidden><input  type='text' 	style='font-size:90%'	class='form-control' id='dt_idmaterial_" . $loop . "' 	required name='dt[" . $loop . "][idmaterial]' ></th>
			<th id='namaterial_" . $loop . "'	hidden><input  type='text' 	style='font-size:90%'	class='form-control' id='dt_namamaterial_" . $loop . "' required name='dt[" . $loop . "][namamaterial]' ></th>
			<th id='description_" . $loop . "'	style='font-size:90%'><input style='font-size:90%' type='text' 			class='form-control' id='dt_description_" . $loop . "' 	required name='dt[" . $loop . "][description]' ></th>
			<th id='width_" . $loop . "'		><input  type='number' style='font-size:90%'	class='form-control' id='dt_width_" . $loop . "' 		required name='dt[" . $loop . "][width]' onkeyup='HitungHarga(" . $loop . ")' ></th>
			<th id='totalwidth_" . $loop . "'	><input  type='number' style='font-size:90%'	class='form-control' id='dt_totalwidth_" . $loop . "' 	required name='dt[" . $loop . "][totalwidth]' onkeyup='HitungHarga(" . $loop . ")' ></th>
			<th id='qty_" . $loop . "'			hidden style='font-size:90%'><input style='font-size:90%' type='number' 			class='form-control' id='dt_qty_" . $loop . "' 			required name='dt[" . $loop . "][qty]' onkeyup='HitungUP(" . $loop . ")' ></th>
			<th 							style='font-size:90%' ><select		style='font-size:90%'		class='form-control' id='dt_ratelme_" . $loop . "' 		required name='dt[" . $loop . "][ratelme]' onchange='CariPrice(" . $loop . ")'>
			<option value=''>-Pilih-</option>
			<option value='Hari Ini'>Hari ini</option>
			<option value='H-10'>H-10</option>
			<option value='H-30'>H-30</option>
			</select></th>
			<th id='alloyprice_" . $loop . "'	style='font-size:90%'><input  type='text' 	style='font-size:90%' disabled class='form-control input-md bilangan-desimal' id='dt_alloyprice_" . $loop . "' 	required data-decimal='.' data-thousand='' data-precision='0' data-allow-zero='' name='dt[" . $loop . "][alloyprice]' onkeyup='HitungUPIm(" . $loop . ")' ></th>
			<th 							style='font-size:90%'><input  type='text' 	style='font-size:90%' disabled	class='form-control input-md bilangan-desimal' id='dt_fabcost_" . $loop . "' 		required data-decimal='.' data-thousand='' data-precision='0' data-allow-zero='' name='dt[" . $loop . "][fabcost]' onkeyup='HitungUPIm(" . $loop . ")' ></th>
			<th	id='panjang_" . $loop . "'		hidden><input  type='number' style='font-size:90%'	class='form-control' id='dt_panjang_" . $loop . "' 		required name='dt[" . $loop . "][panjang]' onkeyup='HitungHarga(" . $loop . ")'></th>
			<th	id='lebar_" . $loop . "'		hidden><input  type='number' style='font-size:90%'	class='form-control' id='dt_lebar_" . $loop . "' 		required name='dt[" . $loop . "][lebar]' ></th>
			<th								style='font-size:90%'><input style='font-size:90%' class='form-control input-md autoNumeric3'			class='form-control' id='dt_hargasatuan_" . $loop . "' 	required data-decimal='.' data-thousand='' data-precision='0' data-allow-zero='' name='dt[" . $loop . "][hargasatuan]' onkeyup='HitungUP(" . $loop . ")'></th>
			<th								style='font-size:90%'><input style='font-size:90%' type='text' 			class='form-control bilangan-desimal' id='dt_diskon_" . $loop . "' 		required name='dt[" . $loop . "][diskon]' onkeyup='HitungUP(" . $loop . ")'></th>
			<th								style='font-size:90%'><input style='font-size:90%' type='text' 			class='form-control bilangan-desimal' id='dt_pajak_" . $loop . "' 		required name='dt[" . $loop . "][pajak]' onkeyup='HitungUP(" . $loop . ")'></th>
			<th id='jumlahharga_" . $loop . "'	style='font-size:90%'><input style='font-size:90%' readonly type='text' 	class='form-control' id='dt_jumlahharga_" . $loop . "' 	required name='dt[" . $loop . "][jumlahharga]' ></th>
			<th								style='font-size:90%'><input style='font-size:90%' type='text' 			class='form-control' id='dt_note_" . $loop . "' 		required name='dt[" . $loop . "][note]' ></th>
			<th><button type='button' class='btn btn-sm btn-success' title='Lock' data-role='qtip' onClick='return LockMaterial(" . $loop . ");'><i class='fa fa-key'></i></button>
			<button type='button' class='btn btn-sm btn-danger' title='Hapus Data' data-role='qtip' onClick='return HapusItem(" . $loop . ");'><i class='fa fa-close'></i></button></th>
			</tr>
		";
		}
	}

	function AddMaterial_Direct()
	{
		$no_pr		= $this->input->post('no_pr');
		$loi 		= $this->input->post('loi');
		$material 	= $this->db->query("SELECT * FROM dt_trans_pr WHERE no_pr = '$no_pr'")->result_array();
		$datemin 	= $this->db->query("SELECT MIN(tanggal) AS tanggal FROM dt_trans_pr WHERE no_pr = '$no_pr'")->result();
		// print_r($material);
		$LIST = "";
		foreach ($material as $key => $value) {
			$key++;
			$disabled = ($loi == 'Import') ? '' : 'readonly';
			$disabled2 = ($loi == 'Import') ? 'readonly' : '';
			$idmat = $value['idmaterial'];
			$harga 	= $this->db->query("SELECT * FROM ms_product_pricelist WHERE id_category3 = '$idmat'")->row();

			$total = $harga->harga_beli * $value['qty'];

			$LIST .= "<tr>";
			$LIST .= 	"<td>" . $value['nama_material'] . "
								<input type='hidden' class='form-control input-sm' id='dt_idpr_" . $key . "' name='dt[" . $key . "][idpr]' value='" . $value['id_dt_pr'] . "'>
								<input type='hidden' class='form-control input-sm' id='dt_idmaterial_" . $key . "' name='dt[" . $key . "][idmaterial]' value='" . $value['idmaterial'] . "'>
								<input type='hidden' class='form-control input-sm' id='dt_namamaterial_" . $key . "' name='dt[" . $key . "][namamaterial]' value='" . $value['nama_material'] . "'>
								<input type='hidden' class='form-control input-sm' id='dt_panjang_" . $key . "' name='dt[" . $key . "][panjang]'>
								<input type='hidden' class='form-control input-sm' id='dt_lebar_" . $key . "' name='dt[" . $key . "][lebar]'>

								<input type='hidden' class='form-control input-sm ch_diskon' id='dt_ch_diskon_" . $key . "'>
								<input type='hidden' class='form-control input-sm ch_pajak' id='dt_ch_pajak_" . $key . "'>
								<input type='hidden' class='form-control input-sm ch_jumlah' id='dt_ch_jumlah_" . $key . "'>

							</td>";
			$LIST .= 	"<td><input type='text' class='form-control input-sm' name='dt[" . $key . "][description]' id='dt_description_" . $key . "' value='" . $value['keterangan'] . "'></td>";
			$LIST .= 	"<td hidden><input type='hidden' class='form-control input-sm autoNumeric' name='dt[" . $key . "][width]' id='dt_width_" . $key . "'  value='" . $value['width'] . "'></td>";
			$LIST .= 	"<td hidden><input type='hidden' class='form-control input-sm autoNumeric' name='dt[" . $key . "][length]' id='dt_length_" . $key . "'  value='" . $value['length'] . "'></td>";
			$LIST .= 	"<td><input type='hidden' class='form-control input-sm autoNumeric' name='dt[" . $key . "][totalweight]' id='dt_totalweight_" . $key . "' value='" . $value['totalweight'] . "'  onkeyup='HitAmmount(" . $key . ")'>
										<input type='text' class='form-control input-sm' id='dt_qty_" . $key . "' name='dt[" . $key . "][qty]' value='" . $value['qty'] . "' onkeyup='HitAmmount(" . $key . ")'>
								
							</td>";
			$LIST .= 	"<td hidden>
								<select class='form-control input-sm' id='dt_ratelme_" . $key . "' name='dt[" . $key . "][ratelme]' onchange='CariPrice(" . $key . ")'>
									<option value=''>-Pilih-</option>
									<option value='Hari Ini'>Hari ini</option>
									<option value='H-10'>H-10</option>
									<option value='H-30'>H-30</option>
								</select>
							</td>";
			$LIST .= 	"<td hidden><input type='text' class='form-control input-sm autoNumeric3' id='dt_alloyprice_" . $key . "' " . $disabled . " data-decimal='.' data-thousand='' data-precision='0' data-allow-zero='' name='dt[" . $key . "][alloyprice]' onkeyup='HitAmmount(" . $key . ")'></td>";
			$LIST .= 	"<td hidden><input type='text' class='form-control input-sm autoNumeric3' id='dt_fabcost_" . $key . "' " . $disabled . " name='dt[" . $key . "][fabcost]' onkeyup='HitAmmount(" . $key . ")'></td>";
			$LIST .= 	"<td><input type='text' class='form-control input-sm autoNumeric3' id='dt_hargasatuan_" . $key . "' name='dt[" . $key . "][hargasatuan]' onkeyup='HitAmmount(" . $key . ")' value='" . $harga->harga_beli . "'></td>";
			$LIST .= 	"<td hidden><input type='text' class='form-control input-sm autoNumeric' id='dt_diskon_" . $key . "' name='dt[" . $key . "][diskon]' onkeyup='HitAmmount(" . $key . ")'></td>";
			$LIST .= 	"<td><input type='text' class='form-control input-sm autoNumeric pajak' id='dt_pajak_" . $key . "' name='dt[" . $key . "][pajak]' onkeyup='HitAmmount(" . $key . ")'></td>";
			$LIST .= 	"<td><input type='text' class='form-control input-sm ch_jumlah_ex' id='dt_jumlahharga_" . $key . "' readonly name='dt[" . $key . "][jumlahharga]' value='" . $total . "'></td>";
			$LIST .= 	"<td><input type='text' class='form-control input-sm' id='dt_note_" . $key . "' name='dt[" . $key . "][note]'></td>";
			$LIST .= 	"<td>
								<button type='button' class='btn btn-sm btn-danger hapus_baris' title='Hapus Data' data-role='qtip'><i class='fa fa-close'></i></button>
							</td>";
			$LIST .= "</tr>";
		}

		$data = [
			'list_mat' => $LIST,
			'min_date' => date('d-M-Y', strtotime($datemin[0]->tanggal))
		];

		echo json_encode($data);
	}



	function LockMatrial()
	{
		$loop = $_GET['id'];
		$idpr = $_GET['idpr'];
		$idmaterial = $_GET['idmaterial'];
		$namamaterial = $_GET['namaterial'];
		$description = $_GET['description'];
		$qty = $_GET['qty'];
		$width = $_GET['width'];
		$alloyprice = $_GET['alloyprice'];
		$fabcost = $_GET['fabcost'];
		$ratelme = $_GET['ratelme'];
		$totalwidth = $_GET['totalwidth'];
		$hargasatuan = $_GET['hargasatuan'];
		$panjang = $_GET['panjang'];
		$lebar = $_GET['lebar'];
		$diskon = $_GET['diskon'];
		$pajak = $_GET['pajak'];
		$jumlahharga = $_GET['jumlahharga'];
		$note = $_GET['note'];
		echo "
		<td hidden><input readonly 	type='text' 	value='" . $idpr . "'				class='form-control' id='dt_idpr_" . $loop . "' 	required name='dt[" . $loop . "][idpr]' ></td>		
		<td hidden><input readonly 	type='text' 	value='" . $idmaterial . "'			class='form-control' id='dt_idmaterial_" . $loop . "' 	required name='dt[" . $loop . "][idmaterial]' ></td>		
		<td ><input		readonly  	type='text' 	value='" . $namamaterial . "'		class='form-control' id='dt_namamaterial_" . $loop . "' required name='dt[" . $loop . "][namamaterial]' ></td>
		
		<td ><input		readonly  	type='text' 	value='" . $description . "'		class='form-control' id='dt_description_" . $loop . "' 	required name='dt[" . $loop . "][description]' ></td>
		
		<td><input		readonly  	type='number' 	value='" . $width . "'		class='form-control' id='dt_width_" . $loop . "' 			required name='dt[" . $loop . "][width]'  ></td>
		
		<td ><input		readonly  	type='number' 	value='" . $totalwidth . "'	class='form-control' id='dt_totalwidth_" . $loop . "' 			required name='dt[" . $loop . "][totalwidth]'  ></td>
		
		<td hidden><input		readonly  	type='number' 	value='" . $qty . "'				class='form-control' id='dt_qty_" . $loop . "' 			required name='dt[" . $loop . "][qty]'  ></td>
		
		<td ><input		readonly  	type='text' 	value='" . $ratelme . "'			class='form-control' id='dt_ratelme_" . $loop . "' 			required name='dt[" . $loop . "][ratelme]'  ></td>
		
		<td ><input		readonly  	type='text' 	value='" . $alloyprice . "'			class='form-control' id='dt_alloyprice_" . $loop . "' 			required name='dt[" . $loop . "][alloyprice]'  ></td>
		
		<td ><input		readonly  	type='text' 	value='" . $fabcost . "'			class='form-control' id='dt_fabcost_" . $loop . "' 			required name='dt[" . $loop . "][fabcost]'  ></td>
		
		<td hidden><input		readonly  	type='number' 	value='" . $panjang . "'	class='form-control' id='dt_panjang_" . $loop . "' 			required name='dt[" . $loop . "][panjang]'  ></td>
		<td hidden><input		readonly  	type='number' 	value='" . $lebar . "'		class='form-control' id='dt_lebar_" . $loop . "' 			required name='dt[" . $loop . "][lebar]'  ></td>
		
		<td	><input		readonly  	type='text' 	value='" . $hargasatuan . "'		class='form-control' id='dt_hargasatuan_" . $loop . "' 	required name='dt[" . $loop . "][hargasatuan]' ></td>
		
		<td	hidden><input		readonly 	type='number' 	value='" . $diskon . "'				class='form-control' id='dt_diskon_" . $loop . "' 		required name='dt[" . $loop . "][diskon]' ></td>
		<td	hidden><input		readonly	type='text' 	value='" . $pajak . "'				class='form-control' id='dt_pajak_" . $loop . "' 		required name='dt[" . $loop . "][pajak]' ></td>
		<td ><input		readonly 	type='text' 	value='" . $jumlahharga . "'		class='form-control' id='dt_jumlahharga_" . $loop . "' 	required name='dt[" . $loop . "][jumlahharga]' ></td>
		<td	><input		readonly  	type='text' 	value='" . $note . "'				class='form-control' id='dt_note_" . $loop . "' 		required name='dt[" . $loop . "][note]' ></td>
		<td><button type='button' class='btn btn-sm btn-danger' title='Hapus Data' data-role='qtip' onClick='return CancelItem($loop);'><i class='fa fa-close'></i></button></td>
		";
	}
	function CariPrice()
	{
		$dt_idmaterial = $_GET['dt_idmaterial'];
		$dt_ratelme = $_GET['dt_ratelme'];
		$hariini 		= date('Y-m-d');
		$satu_hari 		= mktime(0, 0, 0, date('n'), date('j') - 1, date('Y'));
		$kemarin 		= date("Y-m-d", $satu_hari);
		$sepuluh_hari 	= mktime(0, 0, 0, date('n'), date('j') - 14, date('Y'));
		$tendays 		= date("Y-m-d", $sepuluh_hari);
		$tglnow 		= date('d');
		$blnnow 		= date('m');
		if ($blnnow 	!= '1') {
			$blnkmrn	 	= $blnnow - 1;
			$yearkemaren 	= date('Y');
		} else {
			$blnkmrn 		= "12";
			$yearnow 		= date('Y');
			$yearkemaren 	= $yearnow - 1;
		}
		$comp13	= $this->db->query("select * FROM child_inven_compotition WHERE id_category3 = '" . $dt_idmaterial . "' AND id_compotition = '13' ")->result();
		$kandungan13 = $comp13[0]->nilai_compotition;
		$lme_spot13		= $this->db->query("SELECT AVG(nominal) as nominal FROM child_history_lme WHERE status='0' AND id_compotition='13' ")->result();
		$lme_10hari13	= $this->db->query("SELECT AVG(nominal) as nominal FROM child_history_lme WHERE tanggal_update BETWEEN  '$tendays' AND '$kemarin' AND id_compotition='13' ")->result();
		$lme_30hari13	= $this->db->query("SELECT AVG(nominal) as nominal FROM child_history_lme WHERE MONTH(tanggal_update) =  '$blnkmrn' AND YEAR(tanggal_update) = '$yearkemaren' AND id_compotition='13' ")->result();
		$nomspot13		= $lme_spot13[0]->nominal * ($kandungan13 / 100);
		$nom1013		= $lme_10hari13[0]->nominal * ($kandungan13 / 100);
		$nom3013		= $lme_30hari13[0]->nominal * ($kandungan13 / 100);
		$comp14	= $this->db->query("select * FROM child_inven_compotition WHERE id_category3 = '" . $dt_idmaterial . "' AND id_compotition = '14' ")->result();
		$kandungan14 = $comp14[0]->nilai_compotition;
		$lme_spot14		= $this->db->query("SELECT AVG(nominal) as nominal FROM child_history_lme WHERE status='0' AND id_compotition='14' ")->result();
		$lme_10hari14	= $this->db->query("SELECT AVG(nominal) as nominal FROM child_history_lme WHERE tanggal_update BETWEEN  '$tendays' AND '$kemarin' AND id_compotition='14' ")->result();
		$lme_30hari14	= $this->db->query("SELECT AVG(nominal) as nominal FROM child_history_lme WHERE MONTH(tanggal_update) =  '$blnkmrn' AND YEAR(tanggal_update) = '$yearkemaren' AND id_compotition='14' ")->result();
		$nomspot14		= $lme_spot14[0]->nominal * ($kandungan14 / 100);
		$nom1014		= $lme_10hari14[0]->nominal * ($kandungan14 / 100);
		$nom3014		= $lme_30hari14[0]->nominal * ($kandungan14 / 100);
		$comp15	= $this->db->query("select * FROM child_inven_compotition WHERE id_category3 = '" . $dt_idmaterial . "' AND id_compotition = '15' ")->result();
		$kandungan15 = $comp15[0]->nilai_compotition;
		$lme_spot15		= $this->db->query("SELECT AVG(nominal) as nominal FROM child_history_lme WHERE status='0' AND id_compotition='15' ")->result();
		$lme_10hari15	= $this->db->query("SELECT AVG(nominal) as nominal FROM child_history_lme WHERE tanggal_update BETWEEN  '$tendays' AND '$kemarin' AND id_compotition='15' ")->result();
		$lme_30hari15	= $this->db->query("SELECT AVG(nominal) as nominal FROM child_history_lme WHERE MONTH(tanggal_update) =  '$blnkmrn' AND YEAR(tanggal_update) = '$yearkemaren' AND id_compotition='15' ")->result();
		$nomspot15		= $lme_spot15[0]->nominal * ($kandungan15 / 100);
		$nom1015		= $lme_10hari15[0]->nominal * ($kandungan15 / 100);
		$nom3015		= $lme_30hari15[0]->nominal * ($kandungan15 / 100);
		$comp16	= $this->db->query("select * FROM child_inven_compotition WHERE id_category3 = '" . $dt_idmaterial . "' AND id_compotition = '16' ")->result();
		$kandungan16 = $comp16[0]->nilai_compotition;
		$lme_spot16		= $this->db->query("SELECT AVG(nominal) as nominal FROM child_history_lme WHERE status='0' AND id_compotition='16' ")->result();
		$lme_10hari16	= $this->db->query("SELECT AVG(nominal) as nominal FROM child_history_lme WHERE tanggal_update BETWEEN  '$tendays' AND '$kemarin' AND id_compotition='16' ")->result();
		$lme_30hari16	= $this->db->query("SELECT AVG(nominal) as nominal FROM child_history_lme WHERE MONTH(tanggal_update) =  '$blnkmrn' AND YEAR(tanggal_update) = '$yearkemaren' AND id_compotition='16' ")->result();
		$nomspot16		= $lme_spot16[0]->nominal * ($kandungan16 / 100);
		$nom1016		= $lme_10hari16[0]->nominal * ($kandungan16 / 100);
		$nom3016		= $lme_30hari16[0]->nominal * ($kandungan16 / 100);
		$comp17	= $this->db->query("select * FROM child_inven_compotition WHERE id_category3 = '" . $dt_idmaterial . "' AND id_compotition = '17' ")->result();
		$kandungan17 = $comp17[0]->nilai_compotition;
		$lme_spot17		= $this->db->query("SELECT AVG(nominal) as nominal FROM child_history_lme WHERE status='0' AND id_compotition='17' ")->result();
		$lme_10hari17	= $this->db->query("SELECT AVG(nominal) as nominal FROM child_history_lme WHERE tanggal_update BETWEEN  '$tendays' AND '$kemarin' AND id_compotition='17' ")->result();
		$lme_30hari17	= $this->db->query("SELECT AVG(nominal) as nominal FROM child_history_lme WHERE MONTH(tanggal_update) =  '$blnkmrn' AND YEAR(tanggal_update) = '$yearkemaren' AND id_compotition='17' ")->result();
		$nomspot17		= $lme_spot17[0]->nominal * ($kandungan17 / 100);
		$nom1017		= $lme_10hari17[0]->nominal * ($kandungan17 / 100);
		$nom3017		= $lme_30hari17[0]->nominal * ($kandungan17 / 100);
		$comp18	= $this->db->query("select * FROM child_inven_compotition WHERE id_category3 = '" . $dt_idmaterial . "' AND id_compotition = '18' ")->result();
		$kandungan18 = $comp18[0]->nilai_compotition;
		$lme_spot18		= $this->db->query("SELECT AVG(nominal) as nominal FROM child_history_lme WHERE status='0' AND id_compotition='18' ")->result();
		$lme_10hari18	= $this->db->query("SELECT AVG(nominal) as nominal FROM child_history_lme WHERE tanggal_update BETWEEN  '$tendays' AND '$kemarin' AND id_compotition='18' ")->result();
		$lme_30hari18	= $this->db->query("SELECT AVG(nominal) as nominal FROM child_history_lme WHERE MONTH(tanggal_update) =  '$blnkmrn' AND YEAR(tanggal_update) = '$yearkemaren' AND id_compotition='18' ")->result();
		$nomspot18		= $lme_spot18[0]->nominal * ($kandungan18 / 100);
		$nom1018		= $lme_10hari18[0]->nominal * ($kandungan18 / 100);
		$nom3018		= $lme_30hari18[0]->nominal * ($kandungan18 / 100);
		$valnow			= number_format($nomspot13 + $nomspot14 + $nomspot15 + $nomspot16 + $nomspot17 + $nomspot18);
		$val10			= number_format($nom1013 + $nom1014 + $nom1015 + $nom1016 + $nom1017 + $nom1018);
		$val30			= number_format($nom3013 + $nom3014 + $nom3015 + $nom3016 + $nom3017 + $nom3018);
		if ($dt_ratelme == "Hari Ini") {
			echo "" . $valnow . "";
		} elseif ($dt_ratelme == "H-10") {
			echo "" . $val10 . "";
		} elseif ($dt_ratelme == "H-30") {
			echo "" . $val30 . "";
		}
	}

	function CariPPN()
	{
		$harga = $_GET['harga'];
		$cari		= $this->db->query("select persen FROM ppn")->row();
		$ppn   		= $cari->persen;
		$ppnbarang 	= number_format(($ppn * $harga) / 100, 2);

		echo "" . $ppnbarang . "";
	}
	function HitungHarga()
	{
		$dt_hargasatuan = $_GET['dt_hargasatuan'];
		$dt_qty = $_GET['dt_qty'];
		$loop = $_GET['id'];
		$dt_weight = $_GET['dt_width'];
		// $isi =  $dt_hargasatuan*$dt_qty;
		$isi =  $dt_hargasatuan * $dt_weight;

		// print_r ($isi);
		// exit;
		echo "<input type='text' value='" . $isi . "' 	class='form-control' id='dt_jumlahharga_" . $loop . "' 	required name='dt[" . $loop . "][jumlahharga]' >";
	}
	function UbahImport()
	{
		$loi = $_GET['loi'];
		echo "<input type='text' readonly value='" . $loi . "' class='form-control' id='loi'  required name='loi' readonly placeholder=''>";
	}
	function TotalWeight()
	{
		$dt_width = $_GET['dt_width'];
		$dt_qty = $_GET['dt_qty'];
		$loop = $_GET['id'];
		$isi =  $dt_width * $dt_qty;
		echo "<input type='text' value='" . $isi . "' 	class='form-control' id='dt_totalwidth_" . $loop . "' 	required name='dt[" . $loop . "][totalwidth]' >";
	}
	function CariIdMaterial()
	{
		$idpr = $_GET['idpr'];
		$loop = $_GET['id'];
		$material = $this->db->query("SELECT * FROM dt_trans_pr WHERE id_dt_pr = '$idpr'  ")->result();
		$isi = $material[0]->idmaterial;
		echo "<input readonly type='text' value='" . $isi . "' 	class='form-control' id='dt_idmaterial_" . $loop . "' 	required name='dt[" . $loop . "][idmaterial]' >";
	}
	function HitungUP()
	{
		$alloyprice = str_replace(",", "", $_GET['alloyprice']);
		$fabcost = $_GET['fabcost'];
		$hargasatuan = str_replace(",", "", $_GET['hargasatuan']);
		// $total2 = round(($alloyprice+$fabcost)/1000,3);
		// print_r( $alloyprice);
		// echo "<PRE>";
		// print_r( $fabcost);
		// echo "<PRE>";
		// print_r( $total2);
		// exit;
		$loi = $_GET['loi'];
		if ($loi == 'Import') {
			$total = number_format(round(($alloyprice + $fabcost) / 1000, 3), 2, ".", ",");
		} else {
			$total = number_format($hargasatuan, 3, ".", ",");
		}
		echo "" . $total . "";
	}
	function Hitjumlah()
	{
		$alloyprice = str_replace(",", "", $_GET['alloyprice']);
		$fabcost = str_replace(",", "", $_GET['fabcost']);
		$hargasatuan = str_replace(",", "", $_GET['hargasatuan']);
		$qty = $_GET['qty'];
		$loi = $_GET['loi'];
		$dt_width = $_GET['dt_width'];
		$diskon = $_GET['diskon'];
		$pajak = $_GET['pajak'];
		// if($loi == 'Import'){
		// $total = $alloyprice+$fabcost;
		//$th1 = $total*$qty;
		// $th1 = $total*$dt_width;
		// $jumlah=number_format($th1);
		// }else{
		//$th1 = $hargasatuan*$qty;
		// $th1 = $hargasatuan*$dt_width;
		// $jumlah=number_format($th1);
		// }

		if ($loi == 'Import') {
			$total = $alloyprice + $fabcost;
			//$th1 = $total*$qty;
			$th1 = $hargasatuan * $dt_width;
			$jumlah = number_format($th1, 2, ".", ",");
		} else {
			//$th1 = $hargasatuan*$qty;
			$th1 = $hargasatuan * $dt_width;
			$jumlah = number_format($th1, 2, ".", ",");
		}

		echo "" . $jumlah . "";
	}
	function CariNamaMaterial()
	{
		$idpr = $_GET['idpr'];
		$loop = $_GET['id'];
		$material = $this->db->query("SELECT * FROM dt_trans_pr WHERE id_dt_pr = '$idpr'  ")->result();
		$isi = $material[0]->nama_material;
		echo "<input readonly type='text' value='" . $isi . "' 	class='form-control' id='dt_namamaterial_" . $loop . "' 	required name='dt[" . $loop . "][namamaterial]' >";
	}
	function CariDescripitionMaterial()
	{
		$idpr = $_GET['idpr'];
		$loop = $_GET['id'];
		$material = $this->db->query("SELECT * FROM dt_trans_pr WHERE id_dt_pr = '$idpr'  ")->result();
		$isi = $material[0]->keterangan;
		echo "<input  type='text' value='" . $isi . "' 	class='form-control' id='dt_description_" . $loop . "' 	required name='dt[" . $loop . "][description]' >";
	}
	function CariPanjangMaterial()
	{
		$idpr = $_GET['idpr'];
		$loop = $_GET['id'];
		$material = $this->db->query("SELECT * FROM dt_trans_pr WHERE id_dt_pr = '$idpr'  ")->result();
		$isi = $material[0]->length;
		echo "<input  type='text' value='" . $isi . "' 	class='form-control' id='dt_panjang_" . $loop . "' 	required name='dt[" . $loop . "][panjang]' >";
	}
	function CariLebarMaterial()
	{
		$idpr = $_GET['idpr'];
		$loop = $_GET['id'];
		$material = $this->db->query("SELECT * FROM dt_trans_pr WHERE id_dt_pr = '$idpr'  ")->result();
		$isi = $material[0]->width;
		echo "<input  type='text' value='" . $isi . "' 	class='form-control' id='dt_lebar_" . $loop . "' 	required name='dt[" . $loop . "][lebar]' >";
	}
	function FormInputKurs()
	{
		$loi = $_GET['loi'];
		$hariini = date('Y-m-d');
		$sepuluh_hari = mktime(0, 0, 0, date('n'), date('j') - 10, date('Y'));
		$tendays = date("Y-m-d", $sepuluh_hari);
		$tglnow = date('d');
		$blnnow = date('m');
		if ($blnnow != '1') {
			$blnkmrn = $blnnow - 1;
			$yearkemaren = date('Y');
		} else {
			$blnkmrn = "12";
			$yearnow = date('Y');
			$yearkemaren = $yearnow - 1;
		}
		$kurs	= $this->db->query("SELECT * FROM ms_kurs WHERE aktif = 'Y' ")->result();
		$kurs10hari	= $this->db->query("SELECT AVG(nominal) as nominal FROM perubahan_kurs WHERE tanggal_ubah BETWEEN  '$tendays' AND '$hariini' AND kode_kurs='IDR' ")->result();
		$kurs30hari	= $this->db->query("SELECT AVG(nominal) as nominal FROM perubahan_kurs WHERE MONTH(tanggal_ubah) =  '$blnkmrn' AND YEAR(tanggal_ubah) = '$yearkemaren' AND kode_kurs='IDR' ")->result();
		$nomkurs_asli = $kurs[0]->nilai_kurs;
		$nomkurs10 = $kurs10hari[0]->nominal;
		$nomkurs30 = $kurs30hari[0]->nominal;
		$k =  $nomkurs;
		$k10 =  $nomkurs10;
		$k30 =  $nomkurs30;
		if ($loi == "Import") {
			echo "
		<div class='form-group row'>
			<div class='col-md-4'>
				<label>Kurs</label>
			</div>
			<div class='col-md-8'>
				<input type='text' class='form-control' value='" . number_format($nomkurs_asli, 2) . "' id='nominal_kurs'  required name='nominal_kurs'  placeholder='Nominal Kurs'> 
			</div>
		</div>
		";
		} else {
			echo "
		<div class='form-group row'>
			<div class='col-md-4'>
				<label>Kurs</label>
			</div>
			<div class='col-md-8'>
				<input type='text' class='form-control' value='" . number_format($nomkurs_asli, 2) . "' id='nominal_kurs'  required name='nominal_kurs'  placeholder='Nominal Kurs'>
			</div>
		</div>
		";
		}
	}
	function CariQtyMaterial()
	{
		$idpr = $_GET['idpr'];
		$loop = $_GET['id'];
		$material = $this->db->query("SELECT * FROM dt_trans_pr WHERE id_dt_pr = '$idpr'  ")->result();
		$isi = $material[0]->qty;
		echo "<input  type='text' value='" . $isi . "' 	class='form-control' id='dt_qty_" . $loop . "' onkeyup='HitungHarga(" . $loop . ")' 	required name='dt[" . $loop . "][qty]' >";
	}
	function CariweightMaterial()
	{
		$idpr = $_GET['idpr'];
		$loop = $_GET['id'];
		$material = $this->db->query("SELECT * FROM dt_trans_pr WHERE id_dt_pr = '$idpr'  ")->result();
		$isi = $material[0]->width;
		echo "<input  type='text' value='" . $isi . "' 	class='form-control' id='dt_width_" . $loop . "' onkeyup='HitungHarga(" . $loop . ")' 	required name='dt[" . $loop . "][width]' >";
	}
	function CariTweightMaterial()
	{
		$idpr = $_GET['idpr'];
		$loop = $_GET['id'];
		$material = $this->db->query("SELECT * FROM dt_trans_pr WHERE id_dt_pr = '$idpr'  ")->result();
		$isi = $material[0]->totalweight;
		echo "<input  type='text' value='" . $isi . "' 	class='form-control' id='dt_totalwidth_" . $loop . "' onkeyup='HitungHarga(" . $loop . ")' 	required name='dt[" . $loop . "][totalwidth]' >";
	}
	function CariWidthMaterial()
	{
		$idpr = $_GET['idpr'];
		$loop = $_GET['id'];
		$material = $this->db->query("SELECT * FROM dt_trans_pr WHERE id_dt_pr = '$idpr'  ")->result();
		$isi = $material[0]->width;
		echo "<input  type='text' value='" . $isi . "' 	class='form-control' id='dt_width_" . $loop . "' onkeyup='HitungHarga(" . $loop . ")' 	required name='dt[" . $loop . "][width]' >";
	}
	function CariIdBentuk()
	{
		$id_category3 = $_GET['idmaterial'];
		$loop = $_GET['id'];
		$kategory3	= $this->db->query("SELECT * FROM ms_inventory_category3 WHERE id_category3 = '$id_category3' ")->result();
		$id_bentuk = $kategory3[0]->id_bentuk;
		echo "<input readonly type='text' class='form-control' value='" . $id_bentuk . "' id='dt_idbentuk_" . $loop . "' required name='dt[" . $loop . "][idbentuk]' >";
	}
	function CariSupplier()
	{
		$id_category3 = $_GET['idmaterial'];
		$loop = $_GET['id'];
		$supplier	= $this->db->query("SELECT a.*, b.name_suplier as supname FROM child_inven_suplier as a INNER JOIN master_supplier as b on a.id_suplier = b.id_suplier WHERE a.id_category3 = '$id_category3' ")->result();
		echo "<select class='form-control' id='dt_suplier_" . $loop . "' name='dt[" . $loop . "][suplier]'>
		<option value=''>--Pilih--</option>";
		foreach ($supplier as $supplier) {
			echo "<option value='" . $supplier->id_suplier . "'>" . $supplier->supname . "</option>";
		}
		echo "</select>";
	}
	function CariTHarga()
	{
		$hargatotal = str_replace(',', '', $_GET['hargatotal']);
		$jumlahharga = str_replace(',', '', $_GET['jumlahharga']);
		$isi = number_format($hargatotal + $jumlahharga);
		echo "<input readonly type='text' value='" . $isi . "' class='form-control' id='hargatotal'  onkeyup required name='hargatotal' >";
	}
	function CariTDiskon()
	{
		$diskontotal = str_replace(',', '', $_GET['diskontotal']);
		$diskon = str_replace(',', '', $_GET['diskon']) / 100;
		$jumlahharga = str_replace(',', '', $_GET['jumlahharga']);
		$val1 = $jumlahharga * $diskon;
		$isi = number_format($val1 + $diskontotal);
		echo "<input readonly type='text' value='" . $isi . "' class='form-control' id='diskontotal'  onkeyup required name='diskontotal' >";
	}
	function CariTPajak()
	{
		$taxtotal = str_replace(',', '', $_GET['taxtotal']);
		$pajak = str_replace(',', '', $_GET['pajak']) / 100;
		$jumlahharga = str_replace(',', '', $_GET['jumlahharga']);
		$val1 = $jumlahharga * $pajak;
		$isi = number_format($val1 + $taxtotal);
		echo "<input readonly type='text' value='" . $isi . "' class='form-control' id='taxtotal'  onkeyup required name='taxtotal' >";
	}
	function CariTSum()
	{
		$taxtotal = str_replace(',', '', $_GET['taxtotal']);
		$pajak = str_replace(',', '', $_GET['pajak']) / 100;
		$jumlahharga = str_replace(',', '', $_GET['jumlahharga']);
		$val1 = $jumlahharga * $pajak;
		$isi1 = $val1 + $taxtotal;
		$diskontotal = str_replace(',', '', $_GET['diskontotal']);
		$diskon = str_replace(',', '', $_GET['diskon']) / 100;
		$val2 = $jumlahharga * $diskon;
		$isi2 = $val2 + $diskontotal;
		$hargatotal = str_replace(',', '', $_GET['hargatotal']);
		$isi3 = $hargatotal + $jumlahharga;
		$isi = number_format($isi1 - $isi2 + $isi3);
		echo "<input readonly type='text' value='" . $isi . "' class='form-control' id='subtotal'  onkeyup required name='subtotal' >";
	}
	function CariMinHarga()
	{
		$hargatotal = str_replace(',', '', $_GET['hargatotal']);
		$jumlahharga = str_replace(',', '', $_GET['jumlahharga']);
		$isi = number_format($hargatotal - $jumlahharga);
		echo "<input readonly type='text' value='" . $isi . "' class='form-control' id='hargatotal'  onkeyup required name='hargatotal' >";
	}
	function CariMinDiskon()
	{
		$diskontotal = str_replace(',', '', $_GET['diskontotal']);
		$diskon = str_replace(',', '', $_GET['diskon']) / 100;
		$jumlahharga = str_replace(',', '', $_GET['jumlahharga']);
		$val1 = $jumlahharga * $diskon;
		$isi = number_format($val1 - $diskontotal);
		echo "<input readonly type='text' value='" . $isi . "' class='form-control' id='diskontotal'  onkeyup required name='diskontotal' >";
	}
	function CariMinPajak()
	{
		$taxtotal = str_replace(',', '', $_GET['taxtotal']);
		$pajak = str_replace(',', '', $_GET['pajak']) / 100;
		$jumlahharga = str_replace(',', '', $_GET['jumlahharga']);
		$val1 = $jumlahharga * $pajak;
		$isi = number_format($taxtotal - $val1);
		echo "<input readonly type='text' value='" . $isi . "' class='form-control' id='taxtotal'  onkeyup required name='taxtotal' >";
	}
	function CariMinSum()
	{
		$taxtotal = str_replace(',', '', $_GET['taxtotal']);
		$pajak = str_replace(',', '', $_GET['pajak']) / 100;
		$jumlahharga = str_replace(',', '', $_GET['jumlahharga']);
		$val1 = $jumlahharga * $pajak;
		$isi1 = $val1 - $taxtotal;
		$diskontotal = str_replace(',', '', $_GET['diskontotal']);
		$diskon = str_replace(',', '', $_GET['diskon']) / 100;
		$val2 = $jumlahharga * $diskon;
		$isi2 = $val2 - $diskontotal;
		$hargatotal = str_replace(',', '', $_GET['hargatotal']);
		$isi3 = $hargatotal - $jumlahharga;
		$isi = number_format($isi1 - $isi2 + $isi3);
		echo "<input readonly type='text' value='" . $isi . "' class='form-control' id='subtotal'  onkeyup required name='subtotal' >";
	}
	function HitungTwight()
	{
		$loop = $_GET['id'];
		$dt_qty = $_GET['dt_qty'];
		$dt_weight = $_GET['dt_weight'];
		$totalweight = $dt_qty * $dt_weight;
		echo "<input type='number' value='" . $totalweight . "' class='form-control' id='dt_totalweight_$loop' 	required name='dt[$loop][totalweight]' >";
	}
	function getsales()
	{
		$id_customer = $_GET['id_customer'];
		$kategory3	= $this->db->query("SELECT * FROM master_customers WHERE id_customer = '$id_customer' ")->result();
		$id_karyawan = $kategory3[0]->id_karyawan;
		$karyawan	= $this->db->query("SELECT * FROM ms_karyawan WHERE id_karyawan = '$id_karyawan' ")->result();
		$nama_karyawan = $karyawan[0]->nama_karyawan;
		echo "	<div class='col-md-8' hidden>
					<input type='text' class='form-control' id='nama_sales' value='$id_karyawan' required name='nama_sales' readonly placeholder='Sales Marketing'>
				</div>
				<div class='col-md-8'>
					<input type='text' class='form-control' id='id_sales' value='$nama_karyawan'  required name='id_sales' readonly placeholder='Sales Marketing'>
				</div>";
	}
	function getpic()
	{
		$id_customer = $_GET['id_customer'];
		$kategory3	= $this->db->query("SELECT * FROM child_customer_pic WHERE id_customer = '$id_customer' ")->result();
		echo "<select id='pic_customer' name='pic_customer' class='form-control select' required>
				<option value=''>--Pilih--</option>";
		foreach ($kategory3 as $pic) {
			echo "<option value='$pic->name_pic'>$pic->name_pic</option>";
		}
		echo "</select>";
	}

	function cari_thickness()
	{
		$id_category3 = $_GET['id_category3'];
		$kategory3	= $this->db->query("SELECT * FROM child_inven_dimensi WHERE id_category3 = '$id_category3' ")->result();
		$thickness = $kategory3[0]->nilai_dimensi;
		echo "<input type='text' class='form-control' readonly id='thickness' value='$thickness' required name='thickness' placeholder='Bentuk Material'>";
	}
	function cari_density()
	{
		$id_category3 = $_GET['id_category3'];
		$kategory3	= $this->db->query("SELECT * FROM ms_inventory_category3 WHERE id_category3 = '$id_category3' ")->result();
		$density = $kategory3[0]->density;
		echo "<input type='text' class='form-control' readonly id='density' value='$density' required name='density' placeholder='Bentuk Material'>";
	}
	function hitung_komisi()
	{
		$bottom = $_GET['bottom'];
		$komisi = $_GET['bottom'] * $_GET['komisi'] / 100;
		$profit = $_GET['bottom'] * $_GET['profit'] / 100;
		$hasil = $bottom + $komisi + $profit;
		echo "<input type='text' class='form-control' value='$hasil' id='harga_penawaran'  required name='harga_penawaran' placeholder='Bentuk Material'>";
	}
	function carimsprofit()
	{
		$density = $_GET['density'];
		$inven1 = $_GET['inven1'];
		$thickness = $_GET['thickness'];
		$width = $_GET['width'];
		$berat = $_GET['forecast'];
		$maxprofit	= $this->db->query("SELECT max(maksimum) as maximum FROM ms_profit_material WHERE alloy = '$inven1' ")->result();
		$nilaimax = $maxprofit[0]->maximum;

		if ($berat > $nilaimax) {
			$profitaa	= $this->db->query("SELECT * FROM ms_profit_material WHERE alloy = '$inven1' AND minimum < '$berat' AND maksimum  IS NULL   ")->result();
			$nilai_profit = $profitaa[0]->profit;
			$aaa = huhu;
		} else {
			$profitaa	= $this->db->query("SELECT * FROM ms_profit_material WHERE  alloy = '$inven1' AND minimum < '$berat' AND maksimum >= '$berat'  ")->result();
			$nilai_profit = $profitaa[0]->profit;
			$aaa = hihi;
		}
		echo "$nilai_profit %";
	}
	function cari_inven1()
	{
		$id_category3 = $_GET['id_category3'];
		$kategory3	= $this->db->query("SELECT * FROM ms_inventory_category3 WHERE id_category3 = '$id_category3' ")->result();
		$inven1 = $kategory3[0]->id_category1;
		echo "<input type='text' class='form-control' id='inven1' value='$inven1'  required name='inven1' placeholder='Bentuk Material'>";
	}
	public function delDetail()
	{
		$this->auth->restrict($this->deletePermission);
		$id = $this->input->post('id');
		// print_r($id);
		// exit();
		$data = [
			'deleted' 		=> '1',
			'deleted_by' 	=> $this->auth->user_id()
		];

		$this->db->trans_begin();
		$this->db->where('id_dimensi', $id)->update("ms_dimensi", $data);

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$status	= array(
				'pesan'		=> 'Gagal Save Item. Thanks ...',
				'status'	=> 0
			);
		} else {
			$this->db->trans_commit();
			$status	= array(
				'pesan'		=> 'Success Save Item. Thanks ...',
				'status'	=> 1
			);
		}

		echo json_encode($status);
	}

	public function Approved()
	{
		$this->auth->restrict($this->deletePermission);
		$id = $this->input->post('id');
		$data = [
			'status' 		=> '2',
		];

		$this->db->trans_begin();
		$this->db->where('no_po', $id)->update("tr_purchase_order", $data);

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$status	= array(
				'pesan'		=> 'Gagal Approve P.R. Thanks ...',
				'status'	=> 0
			);
		} else {
			$this->db->trans_commit();
			$status	= array(
				'pesan'		=> 'Success Approve P.R. Thanks ...',
				'status'	=> 1
			);
		}

		echo json_encode($status);
	}
	function get_inven2()
	{
		$inventory_1 = $_GET['inventory_1'];
		$data = $this->Pr_model->level_2($inventory_1);
		echo "<select id='inventory_2' name='hd1[1][inventory_2]' class='form-control onchange='get_inv3()'  input-sm select2'>";
		echo "<option value=''>--Pilih--</option>";
		foreach ($data as $key => $st) :
			echo "<option value='$st->id_category1' set_select('inventory_2', $st->id_category1, isset($data->id_category1) && $data->id_category1 == $st->id_category1)>$st->nama
                    </option>";
		endforeach;
		echo "</select>";
	}
	function get_inven3()
	{
		$inventory_2 = $_GET['inventory_2'];
		$data = $this->Pr_model->level_3($inventory_2);

		// print_r($data);
		// exit();
		echo "<select id='inventory_3' name='hd1[1][inventory_3]' class='form-control input-sm select2'>";
		echo "<option value=''>--Pilih--</option>";
		foreach ($data as $key => $st) :
			echo "<option value='$st->id_category2' set_select('inventory_3', $st->id_category2, isset($data->id_category2) && $data->id_category2 == $st->id_category2)>$st->nama
                    </option>";
		endforeach;
		echo "</select>";
	}
	public function saveNewPenawaran()
	{
		$this->auth->restrict($this->addPermission);
		$post = $this->input->post();
		$this->db->trans_begin();
		$hariini = date('Y-m-d');
		$sepuluh_hari = mktime(0, 0, 0, date('n'), date('j') - 10, date('Y'));
		$tendays = date("Y-m-d", $sepuluh_hari);
		$sebulan = mktime(0, 0, 0, date('n'), date('j') - 30, date('Y'));
		$tirtydays = date("Y-m-d", $sebulan);
		$tglnow = date('d');
		$blnnow = date('m');
		if ($blnnow != '1') {
			$blnkmrn = $blnnow - 1;
			$yearkemaren = date('Y');
		} else {
			$blnkmrn = "12";
			$yearnow = date('Y');
			$yearkemaren = $yearnow - 1;
		}
		$kurs_terpakai = $post['kurs_terpakai'];
		if ($kurs_terpakai == 'spot') {
			$kurs	= $this->db->query("SELECT * FROM mata_uang WHERE kode = 'IDR' ")->result();
			$nominal = $kurs[0]->kurs;
		} elseif ($kurs_terpakai == '10') {
			$kurs	= $this->db->query("SELECT AVG(nominal) as nominal FROM perubahan_kurs WHERE tanggal_ubah BETWEEN  '$tendays' AND '$hariini' AND kode_kurs='IDR' ")->result();
			$nominal = $kurs[0]->nominal;
		} elseif ($kurs_terpakai == '30') {
			$kurs	= $this->db->query("SELECT AVG(nominal) as nominal FROM perubahan_kurs WHERE MONTH(tanggal_ubah) =  '$blnkmrn' AND YEAR(tanggal_ubah) = '$yearkemaren' AND kode_kurs='IDR' ")->result();
			$nominal = $kurs[0]->nominal;
		} else {
			$noinal = '1';
		}
		$code = $post['no_penawaran'];
		$dolar = $post['harga_penawaran'] / $nominal;
		$data = [
			'id_child_penawaran'	=> $code,
			'id_category3'			=> $post['id_category3'],
			'no_penawaran'			=> $post['no_penawaran'],
			'bentuk_material'		=> $post['bentuk_material'],
			'id_bentuk'				=> $post['id_bentuk'],
			'thickness'				=> $post['thickness'],
			'density'				=> $post['density'],
			'lotno'					=> $post['lotno'],
			'width'					=> $post['width'],
			'forecast'				=> $post['forecast'],
			'kurs_terpakai'				=> $post['kurs_terpakai'],
			'inven1'				=> $post['inven1'],
			'bottom'				=> $post['bottom'],
			'dasar_harga'			=> $post['dasar_harga'],
			'komisi'				=> $post['komisi'],
			'profit'				=> $post['profit'],
			'keterangan'			=> $post['keterangan'],
			'harga_penawaran'		=> $post['harga_penawaran'],
			'harga_dolar'			=> $dolar,
			'created_on'			=> date('Y-m-d H:i:s'),
			'created_by'			=> $this->auth->user_id()
		];
		//Add Data
		$this->db->insert('child_penawaran', $data);

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$status	= array(
				'pesan'		=> 'Gagal Save Item. Thanks ...',
				'code' => $code,
				'status'	=> 0
			);
		} else {
			$this->db->trans_commit();
			$status	= array(
				'pesan'		=> 'Success Save Item. invenThanks ...',
				'code' => $code,
				'status'	=> 1
			);
		}

		echo json_encode($status);
	}


	public function SaveNew()
	{
		$this->auth->restrict($this->addPermission);
		$post = $this->input->post();

		$tgl  = $post['tanggal'];
		$code = $this->Pr_model->generate_code($tgl);
		$no_surat = $this->Pr_model->BuatNomor($tgl);

		$this->db->trans_begin();
		$data = [
			'no_po'				=> $code,
			'no_surat'			=> $no_surat,
			'id_suplier'		=> $post['id_suplier'],
			'loi'				=> $post['loi'],
			'nominal_kurs'		=> str_replace(',', '', $post['nominal_kurs']),
			'tanggal'			=> $post['tanggal'],
			'expect_tanggal'	=> date('Y-m-d', strtotime($post['expect_tanggal'])),
			'term'				=> $post['term'],
			'cif'				=> $post['cif'],
			'note'				=> $post['note_ket'],
			'no_pr'				=> $post['no_pr'],
			'matauang'			=> $post['matauang'],
			'hargatotal'		=> str_replace(',', '', $post['hargatotal']),
			'diskontotal'		=> str_replace(',', '', $post['diskontotal']),
			'taxtotal'			=> str_replace(',', '', $post['kirim']),
			'subtotal'			=> str_replace(',', '', $post['subtotal']),
			'total_ppn'			=> str_replace(',', '', $post['totalppn']),
			'total_barang'		=> str_replace(',', '', $post['hargatotal']),
			'status'			=> '1',
			'created_on'		=> date('Y-m-d H:i:s'),
			'created_by'		=> $this->auth->user_id()
		];
		//Add Data
		$this->db->insert('tr_purchase_order', $data);

		$numb1 = 0;
		foreach ($_POST['dt'] as $used) {
			$numb1++;
			$dt =  array(
				'no_po'					=> $code,
				'id_dt_po'				=> $code . '-' . $numb1,
				'idpr'					=> $used[idpr],
				'idmaterial'			=> $used[idmaterial],
				'namamaterial'			=> $used[namamaterial],
				'description'			=> $used[description],
				'qty'					=> $used[qty],
				'width'					=> str_replace(",", "", $used[width]),
				'rate_lme'				=> $used[ratelme],
				'fabcost'				=> str_replace(",", "", $used[fabcost]),
				'alloyprice'			=> str_replace(",", "", $used[alloyprice]),
				'totalwidth'			=> str_replace(",", "", $used[totalweight]),
				'hargasatuan'			=> str_replace(",", "", $used[hargasatuan]),
				'lebar'					=> $used[lebar],
				'panjang'				=> str_replace(",", "", $used[length]),
				'diskon'				=> str_replace(",", "", $used[diskon]),
				'pajak'					=> str_replace(",", "", $used[pajak]),
				'jumlahharga'			=> str_replace(",", "", $used[jumlahharga]),
				'ppn'					=> str_replace(",", "", $used[nilai_ppn]),
				'harga_total'			=> str_replace(",", "", $used[totalharga]),
				'note'					=> $used[note],
				'kode_barang'			=> $used[kode_barang],
			);

			$this->db->insert('dt_trans_po', $dt);
			$nopr = $used[no_pr];
			$dataupdate = [
				'status_po'				=> 'CLS',
			];

			$this->db->where('no_pr', $nopr)->update("tr_purchase_request", $dataupdate);
		}
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$status	= array(
				'pesan'		=> 'Gagal Save Item. Thanks ...',
				'code' => $code,
				'status'	=> 0
			);
		} else {
			$this->db->trans_commit();
			$status	= array(
				'pesan'		=> 'Success Save Item. invenThanks ...',
				'code' => $code,
				'status'	=> 1
			);
		}

		echo json_encode($status);
	}
	public function SaveEdit()
	{
		$this->auth->restrict($this->addPermission);
		$post = $this->input->post();
		$code = $post['no_po'];
		$no_surat =  $post['no_surat'];
		$this->db->trans_begin();
		$data = [
			'no_po'				=> $code,
			'no_surat'			=> $no_surat,
			'id_suplier'		=> $post['id_suplier'],
			'loi'				=> $post['loi'],
			'nominal_kurs'		=> str_replace(',', '', $post['nominal_kurs']),
			'tanggal'			=> $post['tanggal'],
			'expect_tanggal'	=> date('Y-m-d', strtotime($post['expect_tanggal'])),
			'term'				=> $post['term'],
			'cif'				=> $post['cif'],
			'note'				=> $post['note_ket'],
			'no_pr'				=> $post['no_pr'],
			'matauang'			=> $post['matauang'],
			'hargatotal'		=> str_replace(',', '', $post['hargatotal']),
			'diskontotal'		=> str_replace(',', '', $post['diskontotal']),
			'taxtotal'			=> str_replace(',', '', $post['taxtotal']),
			'subtotal'			=> str_replace(',', '', $post['subtotal']),
			'status'			=> '1',
			'created_on'		=> date('Y-m-d H:i:s'),
			'created_by'		=> $this->auth->user_id()
		];
		//Add Data 
		$this->db->where('no_po', $code)->update("tr_purchase_order", $data);
		$this->db->delete('dt_trans_po', array('no_po' => $code));
		$numb1 = 0;
		foreach ($_POST['dt'] as $used) {
			$numb1++;
			$dt =  array(
				'no_po'					=> $code,
				'id_dt_po'				=> $code . '-' . $numb1,
				'idpr'					=> $used[idpr],
				'idmaterial'			=> $used[idmaterial],
				'namamaterial'			=> $used[namamaterial],
				'description'			=> $used[description],
				'qty'					=> $used[qty],
				'width'					=> str_replace(",", "", $used[width]),
				'rate_lme'				=> $used[ratelme],
				'fabcost'				=> str_replace(",", "", $used[fabcost]),
				'alloyprice'			=> str_replace(",", "", $used[alloyprice]),
				'totalwidth'			=> str_replace(",", "", $used[totalweight]),
				'hargasatuan'			=> str_replace(",", "", $used[hargasatuan]),
				'lebar'					=> $used[lebar],
				'panjang'				=> str_replace(",", "", $used[length]),
				'diskon'				=> str_replace(",", "", $used[diskon]),
				'pajak'					=> str_replace(",", "", $used[pajak]),
				'jumlahharga'			=> str_replace(",", "", $used[jumlahharga]),
				'note'					=> $used[note],
			);
			$this->db->insert('dt_trans_po', $dt);
		}
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$status	= array(
				'pesan'		=> 'Gagal Save Item. Thanks ...',
				'code' => $code,
				'status'	=> 0
			);
		} else {
			$this->db->trans_commit();
			$status	= array(
				'pesan'		=> 'Success Save Item. invenThanks ...',
				'code' => $code,
				'status'	=> 1
			);
		}

		echo json_encode($status);
	}
	public function PrintH()
	{
		ob_clean();
		ob_start();
		$this->auth->restrict($this->managePermission);
		$id = $this->uri->segment(3);
		$data['header'] = $this->db->query("SELECT a.*, b.name_suplier as name_suplier, b.address_office as address_office,b.id_negara as negara, b.telephone as telephone,b.fax as fax FROM tr_purchase_order as a INNER JOIN master_supplier as b on a.id_suplier = b.id_suplier WHERE a.no_po = '" . $id . "' ")->result();
		$data['detail']  = $this->db->query("SELECT * FROM dt_trans_po WHERE no_po = '" . $id . "' ")->result();
		$data['detailsum'] = $this->db->query("SELECT AVG(width) as totalwidth, AVG(qty) as totalqty FROM dt_trans_po WHERE no_po = '" . $id . "' ")->result();
		$this->load->view('print', $data);
		$html = ob_get_contents();

		require_once('./assets/html2pdf/html2pdf/html2pdf.class.php');
		$html2pdf = new HTML2PDF('P', 'A4', 'en', true, 'UTF-8', array(0, 0, 0, 0));
		$html2pdf->pdf->SetDisplayMode('fullpage');
		$html2pdf->WriteHTML($html);
		ob_end_clean();
		$html2pdf->Output('Penawran.pdf', 'I');
	}

	public function PrintH2()
	{
		ob_clean();
		ob_start();
		$this->auth->restrict($this->managePermission);
		$id = $this->uri->segment(3);
		$data['header'] = $this->db->query("SELECT a.*, b.name_suplier as name_suplier, b.address_office as address_office,b.id_negara as negara, b.telephone as telephone,b.fax as fax FROM tr_purchase_order as a INNER JOIN master_supplier as b on a.id_suplier = b.id_suplier WHERE a.no_po = '" . $id . "' ")->result();
		$data['detail']  = $this->db->query("SELECT a.*, b.nama FROM dt_trans_po a 
		INNER JOIN ms_inventory_category3 b ON b.id_category3 = a.idmaterial 
		WHERE a.no_po = '" . $id . "' ")->result();
		$data['detailsum'] = $this->db->query("SELECT AVG(width) as totalwidth, AVG(qty) as totalqty FROM dt_trans_po WHERE no_po = '" . $id . "' ")->result();
		$this->load->view('print2', $data);
		$html = ob_get_contents();

		require_once('./assets/html2pdf/html2pdf/html2pdf.class.php');
		$html2pdf = new HTML2PDF('P', 'A4', 'en', true, 'UTF-8', array(10, 5, 10, 5));
		$html2pdf->pdf->SetDisplayMode('fullpage');
		$html2pdf->WriteHTML($html);
		ob_end_clean();
		$html2pdf->Output('Purchase Order.pdf', 'I');
	}

	public function PrintH3($id)
	{

		$data = [
			'header' 	=> $this->db->query("SELECT a.*, b.name_suplier as name_suplier, b.address_office as address_office,b.id_negara as negara, b.telephone as telephone,b.fax as fax FROM tr_purchase_order as a INNER JOIN master_supplier as b on a.id_suplier = b.id_suplier WHERE a.no_po = '" . $id . "' ")->result(),
			'detail'  	=> $this->db->query("SELECT * FROM dt_trans_po WHERE no_po = '" . $id . "' ")->result(),
			'detailsum' => $this->db->query("SELECT AVG(width) as totalwidth, AVG(qty) as totalqty FROM dt_trans_po WHERE no_po = '" . $id . "' ")->result()
		];
		$this->load->view('print3', $data);
	}

	public function SaveEditHeader()
	{
		$this->auth->restrict($this->addPermission);
		$post = $this->input->post();
		$code		= $post['no_penawaran'];
		$no_surat	= $post['no_surat'];
		$this->db->trans_begin();
		$data = [
			'no_surat'				=> $no_surat,
			'tgl_penawaran'			=> date('Y-m-d'),
			'id_customer'			=> $post['id_customer'],
			'pic_customer'			=> $post['pic_customer'],
			'mata_uang'			=> $post['mata_uang'],
			'email_customer'		=> $post['email_customer'],
			'valid_until'			=> $post['valid_until'],
			'pengiriman'			=> $post['pengiriman'],
			'terms_payment'			=> $post['terms_payment'],
			'exclude_vat'			=> $post['exclude_vat'],
			'note'					=> $post['note'],
			'id_sales'				=> $post['id_sales'],
			'nama_sales'			=> $post['nama_sales'],
			'created_on'			=> date('Y-m-d H:i:s'),
			'created_by'			=> $this->auth->user_id()
		];
		//Add Data
		$this->db->where('no_penawaran', $code)->update("tr_penawaran", $data);

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$status	= array(
				'pesan'		=> 'Gagal Save Item. Thanks ...',
				'code' => $code,
				'status'	=> 0
			);
		} else {
			$this->db->trans_commit();
			$status	= array(
				'pesan'		=> 'Success Save Item. invenThanks ...',
				'code' => $code,
				'status'	=> 1
			);
		}

		echo json_encode($status);
	}
	public function saveEditPenawaran()
	{
		$this->auth->restrict($this->addPermission);
		$post = $this->input->post();

		$this->db->trans_begin();
		$hariini = date('Y-m-d');
		$sepuluh_hari = mktime(0, 0, 0, date('n'), date('j') - 10, date('Y'));
		$tendays = date("Y-m-d", $sepuluh_hari);
		$sebulan = mktime(0, 0, 0, date('n'), date('j') - 30, date('Y'));
		$tirtydays = date("Y-m-d", $sebulan);
		$tglnow = date('d');
		$blnnow = date('m');
		if ($blnnow != '1') {
			$blnkmrn = $blnnow - 1;
			$yearkemaren = date('Y');
		} else {
			$blnkmrn = "12";
			$yearnow = date('Y');
			$yearkemaren = $yearnow - 1;
		}
		$kurs_terpakai = $post['kurs_terpakai'];
		if ($kurs_terpakai == 'spot') {
			$kurs	= $this->db->query("SELECT * FROM mata_uang WHERE kode = 'IDR' ")->result();
			$nominal = $kurs[0]->kurs;
		} elseif ($kurs_terpakai == '10') {
			$kurs	= $this->db->query("SELECT AVG(nominal) as nominal FROM perubahan_kurs WHERE tanggal_ubah BETWEEN  '$tendays' AND '$hariini' AND kode_kurs='IDR' ")->result();
			$nominal = $kurs[0]->nominal;
		} elseif ($kurs_terpakai == '30') {
			$kurs	= $this->db->query("SELECT AVG(nominal) as nominal FROM perubahan_kurs WHERE MONTH(tanggal_ubah) =  '$blnkmrn' AND YEAR(tanggal_ubah) = '$yearkemaren' AND kode_kurs='IDR' ")->result();
			$nominal = $kurs[0]->nominal;
		} else {
			$noinal = '1';
		}
		$id = $post['id_child_penawaran'];
		$dolar = $post['harga_penawaran'] / $nominal;
		$data = [
			'id_category3'			=> $post['id_category3'],
			'bentuk_material'		=> $post['bentuk_material'],
			'id_bentuk'				=> $post['id_bentuk'],
			'thickness'				=> $post['thickness'],
			'density'				=> $post['density'],
			'forecast'				=> $post['forecast'],
			'inven1'				=> $post['inven1'],
			'bottom'				=> $post['bottom'],
			'dasar_harga'			=> $post['dasar_harga'],
			'komisi'				=> $post['komisi'],
			'profit'				=> $post['profit'],
			'kurs_terpakai'			=> $post['kurs_terpakai'],
			'keterangan'			=> $post['keterangan'],
			'harga_penawaran'		=> $post['harga_penawaran'],
			'harga_dolar'			=> $dolar,
			'created_on'			=> date('Y-m-d H:i:s'),
			'created_by'			=> $this->auth->user_id()
		];
		//Add Data
		$this->db->where('id_child_penawaran', $id)->update("child_penawaran", $data);

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$status	= array(
				'pesan'		=> 'Gagal Save Item. Thanks ...',
				'code' => $id_bentuk,
				'status'	=> 0
			);
		} else {
			$this->db->trans_commit();
			$status	= array(
				'pesan'		=> 'Success Save Item. invenThanks ...',
				'code' => $id_bentuk,
				'status'	=> 1
			);
		}

		echo json_encode($status);
	}
	public function deletePenawaran()
	{
		$this->auth->restrict($this->deletePermission);
		$id = $this->input->post('id');
		$this->db->trans_begin();
		$this->db->delete('child_penawaran', array('id_child_penawaran' => $id));

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$status	= array(
				'pesan'		=> 'Gagal Save Item. Thanks ...',
				'status'	=> 0
			);
		} else {
			$this->db->trans_commit();
			$status	= array(
				'pesan'		=> 'Success Save Item. Thanks ...',
				'status'	=> 1
			);
		}

		echo json_encode($status);
	}

	public function saveEditInventory()
	{
		$this->auth->restrict($this->addPermission);
		$session = $this->session->userdata('app_session');
		$code = $this->Pr_model->generate_id();
		$this->db->trans_begin();
		$id = $_POST['hd1']['1']['id_category3'];
		$id_bentuk = $_POST['hd1']['1']['id_bentuk'];
		$numb1 = 0;
		foreach ($_POST['hd1'] as $h1) {
			$numb1++;
			$header1 =  array(
				'id_type'		        => $h1[inventory_1],
				'id_category1'		    => $h1[inventory_2],
				'id_category2'		    => $h1[inventory_3],
				'nama'		        	=> $h1[nm_inventory],
				'maker'		        	=> $h1[maker],
				'density'		        => $h1[density],
				'hardness'		        => $h1[hardness],
				'id_bentuk'		        => $h1[id_bentuk],
				'id_surface'		    => $h1[id_surface],
				'mountly_forecast'		=> $h1[mountly_forecast],
				'safety_stock'		    => $h1[safety_stock],
				'order_point'		    => $h1[order_point],
				'maksimum'		    	=> $h1[maksimum],
				'aktif'					=> 'aktif',
				'created_on'		=> date('Y-m-d H:i:s'),
				'created_by'		=> $this->auth->user_id(),
				'deleted'			=> '0'
			);
			$this->db->where('id_category3', $id)->update("ms_inventory_category3", $header1);
		}

		if (empty($_POST['data1'])) {
		} else {
			$this->db->delete('child_inven_suplier', array('id_category3' => $id));
			$numb2 = 0;

			foreach ($_POST['data1'] as $d1) {
				$numb2++;
				$data1 =  array(
					'id_category3' => $id,
					'id_suplier' => $d1[id_supplier],
					'lead' => $d1[lead],
					'minimum' => $d1[minimum],
					'deleted' => '0',
					'created_on' => date('Y-m-d H:i:s'),
					'created_by' => $this->auth->user_id(),
				);
				//Add Data
				$this->db->insert('child_inven_suplier', $data1);
			}
		}

		if (empty($_POST['compo'])) {
		} else {
			$this->db->delete('child_inven_compotition', array('id_category3' => $id));
			$numb3 = 0;
			foreach ($_POST['compo'] as $c1) {
				$numb3++;
				$comp =  array(
					'id_category3' => $id,
					'id_compotition' => $c1[id_compotition],
					'nilai_compotition' => $c1[jumlah_kandungan],
					'deleted' => '0',
					'created_on' => date('Y-m-d H:i:s'),
					'created_by' => $this->auth->user_id(),
				);
				//Add Data
				$this->db->insert('child_inven_compotition', $comp);
			}
		}

		if (empty($_POST['dimens'])) {
		} else {
			$this->db->delete('child_inven_dimensi', array('id_category3' => $id));
			$numb4 = 0;
			foreach ($_POST['dimens'] as $dm) {
				$numb4++;
				$dms =  array(
					'id_category3' => $id,
					'id_dimensi' => $dm[id_dimensi],
					'nilai_dimensi' => $dm[nilai_dimensi],
					'deleted' => '0',
					'created_on' => date('Y-m-d H:i:s'),
					'created_by' => $this->auth->user_id(),
				);
				//Add Data
				$this->db->insert('child_inven_dimensi', $dms);
			}
		}
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$status	= array(
				'pesan'		=> 'Gagal Save Item. Thanks ...',
				'code' => $id_bentuk,
				'status'	=> 0
			);
		} else {
			$this->db->trans_commit();
			$status	= array(
				'pesan'		=> 'Success Save Item. invenThanks ...',
				'code' => $id_bentuk,
				'status'	=> 1
			);
		}

		echo json_encode($status);
	}
	function get_compotition_new()
	{
		$inventory_2 = $_GET['inventory_2'];
		$comp = $this->Pr_model->compotition($inventory_2);
		$numb = 0;
		// print_r($data);
		// exit();
		foreach ($comp as $key => $cmp): $numb++;
			echo "<tr>
					  <td hidden align='left'>
					  <input type='text' name='compo[$numb][id_compotition]' readonly class='form-control'  value='$cmp->id_compotition'>
					  </td>
					  <td align='left'>
					  $cmp->name_compotition
					  </td>
					  <td align='left'>
					  <input type='text' name='compo[$numb][jumlah_kandungan]' class='form-control'>
					  </td>
					  <td align='left'>%</td>
                    </tr>";
		endforeach;
		echo "</select>";
	}
	function get_dimensi()
	{
		$id_bentuk = $_GET['id_bentuk'];
		$dim = $this->Pr_model->bentuk($id_bentuk);
		$numb = 0;
		// print_r($data);
		// exit();
		foreach ($dim as $key => $ensi): $numb++;
			echo "<tr>
					  <td align='left' hidden>
					  <input type='text' name='dimens[$numb][id_dimensi]' readonly class='form-control'  value='$ensi->id_dimensi'>
					  </td>
					  <td align='left'>
					  $ensi->nm_dimensi
					  </td>
					  <td align='left'>
					  <input type='text' name='dimens[$numb][nilai_dimensi]' class='form-control'>
					  </td>
                    </tr>";
		endforeach;
		echo "</select>";
	}
	function get_compotition_old()
	{
		$inventory_2 = $_GET['inventory_2'];
		$comp = $this->Pr_model->compotition_edit($inventory_2);
		$numb = 0;
		// print_r($data);
		// exit();
		foreach ($comp as $key => $cmp): $numb++;
			echo "<tr>
					  <td hidden align='left'>
					  <input type='text' name='compo[$numb][id_compotition]' readonly class='form-control'  value='$cmp->id_compotition'>
					  </td>
					  <td align='left'>
					  $cmp->name_compotition
					  </td>
					  <td align='left'>
					  <input type='text' name='compo[$numb][jumlah_kandungan]' class='form-control'>
					  </td>
					  <td align='left'>%</td>
                    </tr>";
		endforeach;
		echo "</select>";
	}
	function get_dimensi_old()
	{
		$id_bentuk = $_GET['id_bentuk'];
		$dim = $this->Pr_model->bentuk_edit($id_bentuk);
		$numb = 0;
		// print_r($data);
		// exit();
		foreach ($dim as $key => $ensi): $numb++;
			echo "<tr>
					  <td hidden align='left'>
					  <input type='text' name='dimens[$numb][id_dimensi]' readonly class='form-control'  value='$cmp->id_dimensi'>
					  </td>
					  <td align='left'>
					  $ensi->nm_dimensi
					  </td>
					  <td align='left'>
					  <input type='text' name='dimens[$numb][nilai_dimensi]' class='form-control'>
					  </td>
                    </tr>";
		endforeach;
		echo "</select>";
	}
	public function saveEditInventorylama()
	{
		$this->auth->restrict($this->addPermission);
		$session = $this->session->userdata('app_session');
		$code = $this->Pr_model->generate_id();
		$this->db->trans_begin();
		$id = $_POST['hd1']['1']['id_category3'];
		$numb1 = 0;
		//$head = $_POST['hd1'];
		foreach ($_POST['hd1'] as $h1) {
			$numb1++;

			$header1 =  array(
				'id_type'		        => $h1[inventory_1],
				'id_category1'		    => $h1[inventory_2],
				'id_category2'		    => $h1[inventory_3],
				'nama'		        	=> $h1[nm_inventory],
				'maker'		        	=> $h1[maker],
				'density'		        => $h1[density],
				'hardness'		        => $h1[hardness],
				'id_bentuk'		        => $h1[id_bentuk],
				'id_surface'		    => $h1[id_surface],
				'mountly_forecast'		=> $h1[mountly_forecast],
				'safety_stock'		    => $h1[safety_stock],
				'order_point'		    => $h1[order_point],
				'maksimum'		    	=> $h1[maksimum],
				'aktif'					=> 'aktif',
				'created_on'		=> date('Y-m-d H:i:s'),
				'created_by'		=> $this->auth->user_id(),
				'deleted'			=> '0'
			);
			//Add Data
			$this->db->where('id_category3', $id)->update("ms_inventory_category3", $data);
		}
		$this->db->delete('child_inven_suplier', array('id_category3' => $id));
		if (empty($_POST['data1'])) {
		} else {
			$numb2 = 0;
			foreach ($_POST['data1'] as $d1) {
				$numb2++;
				$data1 =  array(
					'id_category3' => $code,
					'id_suplier' => $d1[id_supplier],
					'lead' => $d1[lead],
					'minimum' => $d1[minimum],
					'deleted' => '0',
					'created_on' => date('Y-m-d H:i:s'),
					'created_by' => $this->auth->user_id(),
				);
				//Add Data
				$this->db->insert('child_inven_suplier', $data1);
			}
		}
		if (empty($_POST['compo'])) {
		} else {
			$numb3 = 0;
			foreach ($_POST['compo'] as $c1) {
				$numb3++;
				$comp =  array(
					'id_category3' => $code,
					'id_compotition' => $c1[id_compotition],
					'nilai_compotition' => $c1[jumlah_kandungan],
					'deleted' => '0',
					'created_on' => date('Y-m-d H:i:s'),
					'created_by' => $this->auth->user_id(),
				);
				//Add Data
				$this->db->insert('child_inven_compotition', $comp);
			}
		}
		if (empty($_POST['dimens'])) {
		} else {
			$numb4 = 0;
			foreach ($_POST['dimens'] as $dm) {
				$numb4++;
				$dms =  array(
					'id_category3' => $code,
					'id_dimensi' => $dm[id_dimensi],
					'nilai_dimensi' => $dm[nilai_dimensi],
					'deleted' => '0',
					'created_on' => date('Y-m-d H:i:s'),
					'created_by' => $this->auth->user_id(),
				);
				//Add Data
				$this->db->insert('child_inven_dimensi', $dms);
			}
		}
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$status	= array(
				'pesan'		=> 'Gagal Save Item. Thanks ...',
				'status'	=> 0
			);
		} else {
			$this->db->trans_commit();
			$status	= array(
				'pesan'		=> 'Success Save Item. invenThanks ...',
				'status'	=> 1
			);
		}

		echo json_encode($status);
	}
	public function saveEditInventoryOld()
	{
		$this->auth->restrict($this->addPermission);
		$session = $this->session->userdata('app_session');
		$code = $this->Pr_model->generate_id();
		$this->db->trans_begin();
		$id = $_POST['hd1']['1']['id_category3'];
		$numb1 = 0;
		//$head = $_POST['hd1'];
		foreach ($_POST['hd1'] as $h1) {
			$numb1++;

			$header1 =  array(
				'id_type'		        => $h1[inventory_1],
				'id_category1'		    => $h1[inventory_2],
				'id_category2'		    => $h1[inventory_3],
				'nama'		        	=> $h1[nm_inventory],
				'maker'		        	=> $h1[maker],
				'density'		        => $h1[density],
				'hardness'		        => $h1[hardness],
				'id_bentuk'		        => $h1[id_bentuk],
				'id_surface'		    => $h1[id_surface],
				'mountly_forecast'		=> $h1[mountly_forecast],
				'safety_stock'		    => $h1[safety_stock],
				'order_point'		    => $h1[order_point],
				'maksimum'		    	=> $h1[maksimum],
				'aktif'					=> 'aktif',
				'created_on'		=> date('Y-m-d H:i:s'),
				'created_by'		=> $this->auth->user_id(),
				'deleted'			=> '0'
			);
			//Add Data
			$this->db->where('id_category3', $id)->update("ms_inventory_category3", $data);
		}
		if (empty($_POST['data1'])) {
		} else {
			$numb2 = 0;
			foreach ($_POST['data1'] as $d1) {
				$numb2++;
				$data1 =  array(
					'id_category3' => $id,
					'id_suplier' => $d1[id_supplier],
					'lead' => $d1[lead],
					'minimum' => $d1[minimum],
					'deleted' => '0',
					'created_on' => date('Y-m-d H:i:s'),
					'created_by' => $this->auth->user_id(),
				);
				//Add Data
				$this->db->insert('child_inven_suplier', $data1);
			}
		}
		if (empty($_POST['compo'])) {
		} else {
			$numb3 = 0;
			foreach ($_POST['compo'] as $c1) {
				$numb3++;
				$comp =  array(
					'id_category3' => $id,
					'id_compotition' => $c1[id_compotition],
					'nilai_compotition' => $c1[jumlah_kandungan],
					'deleted' => '0',
					'created_on' => date('Y-m-d H:i:s'),
					'created_by' => $this->auth->user_id(),
				);
				//Add Data
				$this->db->insert('child_inven_compotition', $comp);
			}
		}
		if (empty($_POST['dimens'])) {
		} else {
			$numb4 = 0;
			foreach ($_POST['dimens'] as $dm) {
				$numb4++;
				$dms =  array(
					'id_category3' => $id,
					'id_dimensi' => $dm[id_dimensi],
					'nilai_dimensi' => $dm[nilai_dimensi],
					'deleted' => '0',
					'created_on' => date('Y-m-d H:i:s'),
					'created_by' => $this->auth->user_id(),
				);
				//Add Data
				$this->db->insert('child_inven_dimensi', $dms);
			}
		}
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$status	= array(
				'pesan'		=> 'Gagal Save Item. Thanks ...',
				'status'	=> 0
			);
		} else {
			$this->db->trans_commit();
			$status	= array(
				'pesan'		=> 'Success Save Item. invenThanks ...',
				'status'	=> 1
			);
		}

		echo json_encode($status);
	}

	function get_compotition()
	{
		$inventory_2 = $_GET['inventory_2'];
		$comp = $this->Pr_model->compotition($inventory_2);
		$numb = 0;
		// print_r($data);
		// exit();
		foreach ($comp as $key => $cmp): $numb++;
			echo "<tr>
					  <td hidden align='left'>
					  <input type='text' name='compo[$numb][id_compotition]' readonly class='form-control'  value='$cmp->id_compotition'>
					  </td>
					  <td align='left'>
					  $cmp->name_compotition
					  </td>
					  <td align='left'>
					  <input type='text' name='compo[$numb][jumlah_kandungan]' class='form-control'>
					  </td>
					  <td align='left'>%</td>
                    </tr>";
		endforeach;
		echo "</select>";
	}

	function CariLokasi()
	{

		$supplier	= $_GET['supplier'];
		$GetSupp = $this->db->query("SELECT a.* FROM master_supplier as a  WHERE a.id_suplier = '$supplier' ")->result();
		$lokasi = $GetSupp[0]->suplier_location;

		if ($lokasi == 'international') {
			echo "<option value='Import' selected>Import</option>
		      <option value='Lokal'>Lokal</option>";
		} else {
			echo "<option value='Import'>Import</option>
	      <option value='Lokal' selected >Lokal</option>";
		};
	}

	public function getDateExp()
	{
		$id_pr 			= $this->input->post('id_pr');
		// print_r($expect_tanggal);
		$result			= $this->db
			->select('tanggal')
			->from('dt_trans_pr')
			->where_in('id_dt_pr', $id_pr)
			->get()
			->result();
		$expTgl			= date('Y-m-d', strtotime($expect_tanggal));

		$minimal	= $result[0]->tanggal;
		if (!empty($expect_tanggal)) {
			if ($expTgl < $minimal and $expTgl > date('Y-m-d')) {
				$minimal	= $expTgl;
			}
		} else {
			$minimal	= $result[0]->tanggal;
		}
		$ArrJson	= array(
			'minimal' => date('d-M-Y', strtotime($minimal))
		);
		echo json_encode($ArrJson);
	}

	public function getPR()
	{
		$id_suplier = $this->input->post('id_suplier');

		$no_po 		= (!empty($this->input->post('no_po'))) ? $this->input->post('no_po') : 0;

		$get_no_po 	= $this->db->get_where('tr_purchase_order', array('no_po' => $no_po))->result();
		$npo 		= (!empty($get_no_po)) ? $get_no_po[0]->no_pr : 0;

		$filter_pr 	= $this->db->get_where('tr_purchase_order', array('no_pr <>' => $npo))->result_array();


		$ArrPR = [];
		foreach ($filter_pr as $key => $value) {
			if (!empty($value['no_pr'])) {
				$ArrPR[$key] = $value['no_pr'];
			}
		}
		$dtImplode	= "('" . implode("','", $ArrPR) . "')";


		$data 		=  $this->db->query("	SELECT 
												c.* 
											FROM 
												dt_trans_pr b 
												LEFT JOIN tr_purchase_request c ON b.no_pr = c.no_pr 
											WHERE 
												c.status = '2' 
												AND b.suplier='" . $id_suplier . "' 
												AND c.no_pr NOT IN " . $dtImplode . "
											GROUP BY 
												b.no_pr ")->result_array();

		$option 	= "<option value='0'>Pilih PR</option>";
		foreach ($data as $key => $value) {
			$sel = ($npo == $value['no_pr']) ? 'selected' : '';
			$option .= "<option value='" . $value['no_pr'] . "'>" . $value['no_surat'] . "</option>";
		}

		$dataArr = [
			'option' => $option
		];

		echo json_encode($dataArr);
	}



	public function addPurchaseOrder()
	{
		$this->auth->restrict($this->viewPermission);
		$session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
		$customer = $this->Pr_model->get_data('master_customers');
		$this->template->set('customer', $customer);


		$data = $this->Pr_model->cariPurchaserequest();



		$this->template->set('results', $data);

		$this->template->title('Purchase Order');
		$this->template->render('index_pr');
	}

	public function proses()
	{
		$session = $this->session->userdata('app_session');
		$getparam = explode(";", $_GET['param']);

		$getso = $this->Pr_model->get_where_in('no_pr', $getparam, 'tr_purchase_request');
		$getitemso = $this->Pr_model->get_where_in('no_pr', $getparam, 'dt_trans_pr');
		$aktif = 'active';
		$deleted = '0';
		$supplier = $data = $this->db->query("SELECT a.* FROM master_supplier as a INNER JOIN dt_trans_pr as b on b.suplier = a.id_suplier INNER JOIN tr_purchase_request as c on b.no_pr = c.no_pr WHERE c.status = '2' GROUP BY b.suplier ")->result();

		$comp	= $this->db->query("select a.*, b.nominal as nominal_harga FROM ms_compotition as a inner join child_history_lme as b on b.id_compotition=a.id_compotition where a.deleted='0' and b.status='0' ")->result();
		$customers = $this->Pr_model->get_data('master_customers', 'deleted', $deleted);
		$karyawan = $this->Pr_model->get_data('ms_karyawan', 'deleted', $deleted);
		$mata_uang = $this->Pr_model->get_data('mata_uang', 'deleted' . $deleted);
		$matauang = $this->db->get_where('matauang')->result();
		$data = [
			'supplier' => $supplier,
			'comp' => $comp,
			'customers' => $customers,
			'karyawan' => $karyawan,
			'mata_uang' => $mata_uang,
			'matauang' => $matauang,
			'param' => $getparam,
			'headerso' => $getso,
			'getitemso' => $getitemso

		];

		$this->template->set('results', $data);
		$this->template->title('Input Purchase Order');
		$this->template->render('add_purchaseorder');
	}
}
