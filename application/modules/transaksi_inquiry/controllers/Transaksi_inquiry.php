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

class Transaksi_inquiry extends Admin_Controller
{
    //Permission
    protected $viewPermission 	= 'Transaksi_inquiry.View';
    protected $addPermission  	= 'Transaksi_inquiry.Add';
    protected $managePermission = 'Transaksi_inquiry.Manage';
    protected $deletePermission = 'Transaksi_inquiry.Delete';

    public function __construct()
    {
        parent::__construct();

        $this->load->library(array('Mpdf', 'upload', 'Image_lib'));
        $this->load->model(array('Transaksi_inquiry/Inquiry_model',
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
		$deleted = '0';
        $data = $this->Inquiry_model->CariInquiry();
        $this->template->set('results', $data);
        $this->template->title('CRCL');
        $this->template->render('index');
    }
	    public function detail()
    {
		$no_inquiry = $this->uri->segment(3);
        $this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
		$deleted = '0';
        $head = $this->Inquiry_model->GetTransakasi($no_inquiry);
		$bentuk = $this->Inquiry_model->get_data('ms_bentuk','deleted',$deleted);
		$roll 	= $this->Inquiry_model->GetRoll($no_inquiry);
		$sheet 	= $this->Inquiry_model->GetSheet($no_inquiry);
		$tube 	= $this->Inquiry_model->GetTube($no_inquiry);
		$round 	= $this->Inquiry_model->GetRoundBar($no_inquiry);
		$square = $this->Inquiry_model->GetSquareBar($no_inquiry);
		$hexa 	= $this->Inquiry_model->GetHexagonBar($no_inquiry);
		$okta 	= $this->Inquiry_model->GetOktagonBar($no_inquiry);
		$penta 	= $this->Inquiry_model->GetPentagonBar($no_inquiry);
		$semua 	= $this->Inquiry_model->GetSemua($no_inquiry);
		$data = [
			'head' 		=> $head,
			'bentuk' 	=> $bentuk,
			'roll' 		=> $roll,
			'sheet' 	=> $sheet,
			'tube' 		=> $tube,
			'round' 	=> $round,
			'square' 	=> $square,
			'hexa' 		=> $hexa,
			'okta' 		=> $okta,
			'penta' 	=> $penta,
			'semua' 	=> $semua,
		];
        $this->template->set('results', $data);
        $this->template->title('CRCL');
        $this->template->render('detail');
    }
	public function PrintSheet($id){
		ob_clean();
		ob_start();
        $this->auth->restrict($this->managePermission);
        $id = $this->uri->segment(3);
		$data['header'] = $this->Inquiry_model->get_data('dt_inquery_transaksi','id_dt_inquery',$id);
		$this->load->view('PrintSheet',$data);
		$html = ob_get_contents();

		require_once('./assets/html2pdf/html2pdf/html2pdf.class.php');
		$html2pdf = new HTML2PDF('P','A4','en',true,'UTF-8',array(0, 0, 0, 0));
		$html2pdf->pdf->SetDisplayMode('fullpage');
		$html2pdf->WriteHTML($html);
		ob_end_clean();
		$html2pdf->Output('aaa.pdf', 'I');
	}
	public function PrintRoll($id){
		ob_clean();
		ob_start();
        $this->auth->restrict($this->managePermission);
        $id = $this->uri->segment(3);
		$data['header'] = $this->Inquiry_model->get_data('dt_inquery_transaksi','id_dt_inquery',$id);
		$this->load->view('PrintRoll',$data);
		$html = ob_get_contents();

		require_once('./assets/html2pdf/html2pdf/html2pdf.class.php');
		$html2pdf = new HTML2PDF('P','A4','en',true,'UTF-8',array(0, 0, 0, 0));
		$html2pdf->pdf->SetDisplayMode('fullpage');
		$html2pdf->WriteHTML($html);
		ob_end_clean();
		$html2pdf->Output('aaa.pdf', 'I');
	}
	public function addRoll($id){
		
		$customer=$this->input->post('cust');
		// print_r($customer);
		// exit;
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-edit');
		$bentuk = 'B2000001';
		$no_inquiry = $id;
		
		$material = $this->Inquiry_model->GetMaterialroll($bentuk);
		$no_inquiry = $this->Inquiry_model->get_data('tr_inquiry','no_inquiry',$id);
		$data = [
			'material' => $material,
			'bentuk' => $bentuk,
			'no_inquiry' => $no_inquiry,
			'cust' => $customer
		];
        $this->template->set('results', $data);
		$this->template->title('Tambah Detail Inquery');
        $this->template->render('AddRoll');
	}
	public function EditRoll($id){
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-edit');
		$bentuk = 'B2000001';
		$material = $this->Inquiry_model->GetMaterialroll($bentuk);
		$ink = $this->Inquiry_model->get_data('dt_inquery_transaksi','id_dt_inquery',$id);
		$data = [
			'material' => $material,
			'bentuk' => $bentuk,
			'ink' => $ink
		];
        $this->template->set('results', $data);
		$this->template->title('Tambah Detail Inquery');
        $this->template->render('EditRoll');
	}
		public function EditSheet($id){
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-edit');
		$bentuk = 'B2000002';
		$material = $this->Inquiry_model->GetMaterialSheet($bentuk);
		$ink = $this->Inquiry_model->get_data('dt_inquery_transaksi','id_dt_inquery',$id);
		$data = [
			'material' => $material,
			'bentuk' => $bentuk,
			'ink' => $ink
		];
        $this->template->set('results', $data);
		$this->template->title('Tambah Detail Inquery');
        $this->template->render('EditSheet');
	}
	public function ViewCrcl($id){
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-edit');
		$header = $this->Inquiry_model->getHeaderPenawaran($id);
		$detail = $this->Inquiry_model->PrintDetail($id);
		$data = [
			'header' => $header,
			'detail' => $detail,
		];
        $this->template->set('results', $data);
		$this->template->title('Tambah Detail Inquery');
        $this->template->render(ViewCrcl);
	}
		public function ViewRoll($id){
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-edit');
		$bentuk = 'B2000001';
		$material = $this->Inquiry_model->GetMaterialroll($bentuk);
		$ink = $this->Inquiry_model->get_data('dt_inquery_transaksi','id_dt_inquery',$id);
		$data = [
			'material' => $material,
			'bentuk' => $bentuk,
			'ink' => $ink
		];
        $this->template->set('results', $data);
		$this->template->title('Tambah Detail Inquery');
        $this->template->render('ViewRoll');
	}
		public function ViewSheet($id){
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-edit');
		$bentuk = 'B2000002';
		$material = $this->Inquiry_model->GetMaterialSheet($bentuk);
		$ink = $this->Inquiry_model->get_data('dt_inquery_transaksi','id_dt_inquery',$id);
		$data = [
			'material' => $material,
			'bentuk' => $bentuk,
			'ink' => $ink
		];
        $this->template->set('results', $data);
		$this->template->title('Tambah Detail Inquery');
        $this->template->render('ViewSheet');
	}

	public function addSheet($id){
		$this->auth->restrict($this->viewPermission);
		$customer=$this->input->post('cust');
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-edit');
		$bentuk = 'B2000002';
		$no_inquiry = $id;
		$material = $this->Inquiry_model->GetMaterialSheet($bentuk);
		$no_inquiry = $this->Inquiry_model->get_data('tr_inquiry','no_inquiry',$id);
		$data = [
			'material' => $material,
			'bentuk' => $bentuk,
			'no_inquiry' => $no_inquiry,
			'cust' => $customer
		];
        $this->template->set('results', $data);
		$this->template->title('Tambah Detail Inquery');
        $this->template->render('AddSheet');
	}
	public function addRoundBar($id){
		$this->auth->restrict($this->viewPermission);
		$customer=$this->input->post('cust');
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-edit');
		$bentuk = 'B2000003';
		$no_inquiry = $id;
		$material = $this->Inquiry_model->GetMaterial($bentuk);
		$no_inquiry = $this->Inquiry_model->get_data('tr_inquiry','no_inquiry',$id);
		$data = [
			'material' => $material,
			'bentuk' => $bentuk,
			'no_inquiry' => $no_inquiry,
			'cust' => $customer
		];
        $this->template->set('results', $data);
		$this->template->title('Tambah Detail Inquery');
        $this->template->render('AddRoundBar');
		
	}
	public function addSquareBar($id){
		$this->auth->restrict($this->viewPermission);
		$customer=$this->input->post('cust');
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-edit');
		$bentuk = 'B2000004';
		$no_inquiry = $id;
		$material = $this->Inquiry_model->GetMaterial($bentuk);
		$no_inquiry = $this->Inquiry_model->get_data('tr_inquiry','no_inquiry',$id);
		$data = [
			'material' => $material,
			'bentuk' => $bentuk,
			'no_inquiry' => $no_inquiry,
			'cust' => $customer
		];
        $this->template->set('results', $data);
		$this->template->title('Tambah Detail Inquery');
        $this->template->render('AddSquareBar');
		
	}
		public function addHexagonBar($id){
		$this->auth->restrict($this->viewPermission);
		$customer=$this->input->post('cust');
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-edit');
		$bentuk = 'B2000005';
		$no_inquiry = $id;
		$material = $this->Inquiry_model->GetMaterial($bentuk);
		$no_inquiry = $this->Inquiry_model->get_data('tr_inquiry','no_inquiry',$id);
		$data = [
			'material' => $material,
			'bentuk' => $bentuk,
			'no_inquiry' => $no_inquiry,
			'cust' => $customer
		];
        $this->template->set('results', $data);
		$this->template->title('Tambah Detail Inquery');
        $this->template->render('AddHexagonBar');
		
	}
	public function addOktagonBar($id){
		$this->auth->restrict($this->viewPermission);
		$customer=$this->input->post('cust');
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-edit');
		$bentuk = 'B2000006';
		$no_inquiry = $id;
		$material = $this->Inquiry_model->GetMaterial($bentuk);
		$no_inquiry = $this->Inquiry_model->get_data('tr_inquiry','no_inquiry',$id);
		$data = [
			'material' => $material,
			'bentuk' => $bentuk,
			'no_inquiry' => $no_inquiry,
			'cust' => $customer
		];
        $this->template->set('results', $data);
		$this->template->title('Tambah Detail Inquery');
        $this->template->render('AddOktagonBar');
	}
	public function addTube($id){
		$this->auth->restrict($this->viewPermission);
		$customer=$this->input->post('cust');
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-edit');
		$bentuk = 'B2000007';
		$no_inquiry = $id;
		$material = $this->Inquiry_model->GetMaterial($bentuk);
		$no_inquiry = $this->Inquiry_model->get_data('tr_inquiry','no_inquiry',$id);
		$data = [
			'material' => $material,
			'bentuk' => $bentuk,
			'no_inquiry' => $no_inquiry,
			'cust' => $customer
		];
        $this->template->set('results', $data);
		$this->template->title('Tambah Detail Inquery');
        $this->template->render('AddTube');
		
	}
   public function vpdf() {
		$id = $this->uri->segment(3);
		$data=$this->Inquiry_model->get_data('tr_inquiry','no_inquiry',$id);
		$this->template->set('results', $data);
		$this->load->view('view');
	}
    public function cetakcrcl() {
		$data="	";
		require_once('./assets/html2pdf/html2pdf/html2pdf.class.php');
		$html2pdf = new HTML2PDF('P','A4','en',true,'UTF-8',array(0, 0, 0, 0));
		$html2pdf->pdf->SetDisplayMode('fullpage');
		$html2pdf->WriteHTML($data);
		ob_end_clean();
		$html2pdf->Output('aaa.pdf');
	}
	public function addPentagonBar($id){
		$this->auth->restrict($this->viewPermission);
		$customer=$this->input->post('cust');
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-edit');
		$bentuk = 'B2000009';
		$no_inquiry = $id;
		$material = $this->Inquiry_model->GetMaterial($bentuk);
		$no_inquiry = $this->Inquiry_model->get_data('tr_inquiry','no_inquiry',$id);
		$data = [
			'material' => $material,
			'bentuk' => $bentuk,
			'no_inquiry' => $no_inquiry,
			'cust' => $customer
		];
        $this->template->set('results', $data);
		$this->template->title('Tambah Detail Inquery');
        $this->template->render('AddPentagonBar');
		
	}

	
	public function viewBentuk($id){
		$this->auth->restrict($this->viewPermission);
		$id 	= $this->input->post('id');
		$bentuk = $this->db->get_where('ms_bentuk',array('id_bentuk' => $id))->result();
		$dimensi = $this->Bentuk_model->getDimensi($id);
		$data = [
			'bentuk' => $bentuk,
			'dimensi' => $dimensi,
		];
        $this->template->set('results', $data);
		$this->template->render('view_bentuk');
	}
	
	
	public function addInquiry()
    {
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$aktif = 'active';
		$deleted = '0';
		$customers = $this->Inquiry_model->get_data('master_customers','deleted',$deleted);
		// $karyawan = $this->Inquiry_model->get_data('ms_karyawan','deleted',$deleted);
		$karyawan = $this->db->get_where('ms_karyawan',array('deleted'=>$deleted, 'divisi'=>12))->result();
		$data = [
			'customers' => $customers,
			'karyawan' => $karyawan,
		];
        $this->template->set('results', $data);
        $this->template->title('Add Inquiry');
        $this->template->render('addinquiry');

    }

	function getcustomer()
    {
        $id_customer=$_GET['id_customer'];
        $dim=$this->Inquiry_model->cariemail($id_customer);
		$data=$this->Inquiry_model->caripic($id_customer);
		$numb = 0;
                foreach ($dim as $key => $ensi):
		$numb++;
			echo "
		<div class='col-sm-6'>
		<div class='form-group row'>
			<div class='col-md-4'>
				<label for='email_customer'>EMAIL</label>
			</div>
			<div class='col-md-8'>
				<input type='email' class='form-control' id='email_customer'  value='$ensi->email' required name='email_customer' >
			</div>
		</div>
		</div>";
                endforeach;
		$numb2 = 0;
			echo"
		<div class='col-sm-6'>
			<div class='form-group row'>
				<div class='col-md-4'>
					<label for='id_category_supplier'>PIC CUSTOMER</label>
				</div>
				<div class='col-md-8'>
					<select id='pic_customer' name='pic_customer' class='form-control select' required>
						<option value=''>--Pilih--</option>";
				foreach ($data as $key => $ensik):
			echo"
						<option value='$ensik->name_pic'>$ensik->name_pic</option>
				";
				endforeach;
			echo"
					</select>
				</div>
			</div>
		</div>
			";
    }
	function hitung_beratroll()
    {
        $thickness=$_GET['thickness'];
		$berat_produk=$_GET['berat_produk'];
		$density=$_GET['density'];
		$width=$_GET['width'];
        $volume = $thickness*$width*$density;
		$rumus = number_format($berat_produk/$volume,2);
			echo "
			<div class='col-md-4'>
				<label for='email_customer'>Length</label>
			</div>
			<div class='col-md-8'>
				<input type='text' class='form-control' id='panjang' readonly value='$rumus' required name='panjang' >
			</div>
		";
    }
		function hitung_beratsheet()
    {
        $thickness=$_GET['thickness'];
		$panjang=$_GET['panjang'];
		$density=$_GET['density'];
		$width=$_GET['width'];
        $rumus = $panjang*$thickness*$width*$density;
			echo "
			<div class='col-md-4'>
				<label for='email_customer'>Weight/unit</label>
			</div>
			<div class='col-md-4'>
				<input type='number' readonly class='form-control' id='berat_produk' value='$rumus' required  name='berat_produk'>
			</div>
			<div class='col-md-4'>
				<input type='number' readonly class='form-control' id='berat_produk_max' value='$rumus' required  name='berat_produk_max'>
			</div>
		";
    }
	public function DeleteSheet(){
		$this->auth->restrict($this->deletePermission);
		$id = $this->input->post('id');		
		$this->db->trans_begin();
		$this->db->delete('dt_inquery_transaksi', array('id_dt_inquery' => $id));	
		
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$status	= array(
			  'pesan'		=>'Gagal Save Item. Thanks ...',
			  'status'	=> 0
			);
		} else {
			$this->db->trans_commit();
			$status	= array(
			  'pesan'		=>'Success Save Item. Thanks ...',
			  'status'	=> 1
			);			
		}
		
  		echo json_encode($status);
	}
		public function DeleteRoll(){
		$this->auth->restrict($this->deletePermission);
		$id = $this->input->post('id');		
		$this->db->trans_begin();
		$this->db->delete('dt_inquery_transaksi', array('id_dt_inquery' => $id));	
		
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$status	= array(
			  'pesan'		=>'Gagal Save Item. Thanks ...',
			  'status'	=> 0
			);
		} else {
			$this->db->trans_commit();
			$status	= array(
			  'pesan'		=>'Success Save Item. Thanks ...',
			  'status'	=> 1
			);			
		}
		
  		echo json_encode($status);
	}
	function JumlahBeratRoll()
    {
        $berat_produk=$_GET['berat_produk'];
		$qty_order=$_GET['qty_order'];
        $rumus = $berat_produk*$qty_order;
			echo "
			<div class='col-md-4'>
				<label for='email_customer'>Total Berat</label>
			</div>
			<div class='col-md-8'>
				<input type='text' class='form-control' id='total_berat' readonly value='$rumus'  required name='total_berat' >
			</div>
		";
    }
		function cari_densityroll()
    {
        $id_category3=$_GET['id_category3'];
        $den=$this->Inquiry_model->DensityRoll($id_category3);
		$tik=$this->Inquiry_model->ThicknessRoll($id_category3);
		$numb = 0;
                foreach ($tik as $key => $thick):
		$numb++;
			echo "
		<div class='col-sm-6'>
		<div class='form-group row'>
			<div class='col-md-4'>
				<label for='email_customer'>Thickness</label>
			</div>
			<div class='col-md-8'>
				<input type='text' class='form-control' id='thickness' readonly value='$thick->nilai_dimensi' required name='thickness' >
			</div>
		</div>
		</div>
		";
             endforeach;
                foreach ($den as $key => $ensi):
			echo "
		<div class='col-sm-6'>
		<div class='form-group row'>
			<div class='col-md-4'>
				<label for='email_customer'>Density</label>
			</div>
			<div class='col-md-8'>
				<input type='text' class='form-control' id='density' readonly value='$ensi->density' required name='density' placeholder='test' >
			</div>
		</div>
		</div>
		";
                endforeach;
		
    }
	function cari_densitySheet()
    {
        $id_category3=$_GET['id_category3'];
        $den=$this->Inquiry_model->DensitySheet($id_category3);
		$tik=$this->Inquiry_model->ThicknessSheet($id_category3);
		$numb = 0;
                foreach ($tik as $key => $thick):
		$numb++;
			echo "
		<div class='col-sm-6'>
		<div class='form-group row'>
			<div class='col-md-4'>
				<label for='email_customer'>Thickness</label>
			</div>
			<div class='col-md-8'>
				<input type='text' class='form-control' id='thickness' readonly value='$thick->nilai_dimensi' required name='thickness' >
			</div>
		</div>
		</div>
		";
             endforeach;
                foreach ($den as $key => $ensi):
			echo "
		<div class='col-sm-6'>
		<div class='form-group row'>
			<div class='col-md-4'>
				<label for='email_customer'>Density</label>
			</div>
			<div class='col-md-8'>
				<input type='text' class='form-control' id='density' readonly value='$ensi->density' required name='density' placeholder='test' >
			</div>
		</div>
		</div>
		";
                endforeach;
		
    }
	
	function formPricelist()
    {
        $id_category3=$_GET['id_category3'];
        $den = $this->Inquiry_model->get_data('ms_inventory_category3','id_category3',$id_category3);
		$a = $this->Inquiry_model->get_data('ms_rate','id_rate','1');
		$b = $this->Inquiry_model->get_data('ms_rate','id_rate','2');
		$c = $this->Inquiry_model->get_data('ms_rate','id_rate','3');
		$d = $this->Inquiry_model->get_data('ms_rate','id_rate','4');
	foreach($a as $key => $scr){};
	foreach($b as $key => $cgs){};
	foreach($c as $key => $opcost){};
	foreach($d as $key => $interest){};
	$persen_scr = $scr->presentase_rate;
	$persen_cgs = $cgs->presentase_rate;
	$persen_opcost = $opcost->presentase_rate;
	$persen_interest = $interest->presentase_rate;
        foreach ($den as $key => $ensi):
		$data = $ensi->id_category1;
		if($data == 'I2000001'){
			echo "
		<div class='col-sm-12'>
		<div class='form-group row'>
			<div class='col-md-4'>
				<label for='email_customer'>Book Prices (Rp/kg)</label>
			</div>
			<div class='col-md-7'>
				<input type='text' class='form-control' id='book_price' onkeyup='caripersentaseharga()'  required name='book_price' placeholder='Book Prices' >
			</div>
			<div class='col-md-1'>
			</div>
		</div>
		</div>
		<div class='col-sm-12'>
		<div class='form-group row'>
			<div class='col-md-4'>
				<label for='email_customer'>Scrap</label>
			</div>
			<div class='col-md-7'>
				<input type='text' class='form-control' id='scrap' readonly value='$persen_scr'  required name='scrap' placeholder='scrap' >
			</div>
			<div class='col-md-1'>
			%
			</div>
		</div>
		</div>
		<div class='col-sm-12'>
		<div class='form-group row'>
			<div class='col-md-4'>
				<label for='email_customer'>COGS</label>
			</div>
			<div class='col-md-7'>
				<input type='text' class='form-control' id='cogs' readonly value='$persen_opcost'  required name='cogs' placeholder='COGS' >
			</div>
			<div class='col-md-1'>
			%
			</div>
		</div>
		</div>
		<div class='col-sm-12'>
		<div class='form-group row'>
			<div class='col-md-4'>
				<label for='email_customer'>Operating cost</label>
			</div>
			<div class='col-md-7'>
				<input type='text' class='form-control' id='operating_cost' readonly value='$persen_scr' required name='operating_cost' placeholder='Operating cost' >
			</div>
			<div class='col-md-1'>
			%
			</div>
		</div>
		</div>
		<div class='col-sm-12'>
		<div class='form-group row'>
			<div class='col-md-4'>
				<label for='email_customer'>Interest inventory</label>
			</div>
			<div class='col-md-7'>
				<input type='text' class='form-control' id='interest' readonly value='$persen_interest' required name='interest' placeholder='Interest inventory' >
			</div>
			<div class='col-md-1'>
			%
			</div>
		</div>
		</div>
		<div class='col-sm-12'>
		<div class='form-group row'>
			<div class='col-md-4'>
				<label for='email_customer'>Profit (%)</label>
			</div>
			<div class='col-md-7'>
				<input type='text' class='form-control' id='profit' onkeyup='caripersentaseharga()'   required name='profit' placeholder='Profit (%)' >
			</div>
			<div class='col-md-1'>
			</div>
		</div>
		</div>
		<div class='col-sm-12'>
		<div class='form-group row'>
			<div class='col-md-4'>
				<label for='email_customer'>Bottom Price</label>
			</div>
			<div class='col-md-7'>
				<input type='text' class='form-control' id='bottom_price'  required name='bottom_price' placeholder='Bottom Price' >
			</div>
			<div class='col-md-1'>
			</div>
		</div>
		</div>
		";
		}else{
			echo "
			<div class='col-sm-12'>
			<table class='col-sm-12'>
			<tr>
				<th>#</th>
				<th>Book Of Prices</th>
				<th>Rate LME 10 Hari</th>
				<th>Rate LME 30 Hari</th>
				<th>LME SPOT</th>
			</tr>
			<tr>
				<th>Nilai Material (Rp/Kg)</th>
				<th><input type='text' class='form-control' id='nilai_material'  required name='nilai_material' placeholder='test' ></th>
				<th><input type='text' class='form-control' id='nilai_material10'  required name='nilai_material10' placeholder='test' ></th>
				<th><input type='text' class='form-control' id='nilai_material30'  required name='nilai_material30' placeholder='test' ></th>
				<th><input type='text' class='form-control' id='nilai_materialspot'  required name='nilai_materialspot' placeholder='test' ></th>
			</tr>
			<tr>
				<th>SCRAP (%)</th>
				<th><input type='text' class='form-control' readonly value='$persen_scr'  id='scrap'  required name='scrap' placeholder='test' ></th>
				<th><input type='text' class='form-control' readonly value='$persen_scr'  id='scrap10'  required name='scrap10' placeholder='test' ></th>
				<th><input type='text' class='form-control' readonly value='$persen_scr'  id='scrap30'  required name='scrap30' placeholder='test' ></th>
				<th><input type='text' class='form-control' readonly value='$persen_scr'  id='scrapspot'  required name='scrapspot' placeholder='test' ></th>
			</tr>
			<tr>
				<th>COGS(%)</th>
				<th><input type='text' class='form-control' readonly value='$persen_cgs' id='cogs'  required name='cogs' placeholder='test' ></th>
				<th><input type='text' class='form-control' readonly value='$persen_cgs' id='cogs10'  required name='cogs10' placeholder='test' ></th>
				<th><input type='text' class='form-control' readonly value='$persen_cgs' id='cogs30'  required name='cogs30' placeholder='test' ></th>
				<th><input type='text' class='form-control' readonly value='$persen_cgs' id='cogsspot'  required name='cogsspot' placeholder='test' ></th>
			</tr>
			<tr>
				<th>Operating Cost (%)</th>
				<th><input type='text' class='form-control' readonly value='$persen_opcost' id='operating_cost'  required name='operating_cost' placeholder='test' ></th>
				<th><input type='text' class='form-control' readonly value='$persen_opcost' id='operating_cost10'  required name='operating_cost10' placeholder='test' ></th>
				<th><input type='text' class='form-control' readonly value='$persen_opcost' id='operating_cost30'  required name='operating_cost30' placeholder='test' ></th>
				<th><input type='text' class='form-control' readonly value='$persen_opcost' id='operating_costspot'  required name='operating_costspot' placeholder='test' ></th>
			</tr>
			<tr>
				<th>Interest Inventory (%)</th>
				<th><input type='text' class='form-control' readonly value='$persen_interest' id='interest'  required name='interest' placeholder='test' ></th>
				<th><input type='text' class='form-control' readonly value='$persen_interest' id='interest10'  required name='interest10' placeholder='test' ></th>
				<th><input type='text' class='form-control' readonly value='$persen_interest' id='interest30'  required name='interest30' placeholder='test' ></th>
				<th><input type='text' class='form-control' readonly value='$persen_interest' id='interestspot'  required name='interestspot' placeholder='test' ></th>
			</tr>
			<tr>
				<th>Profit (%)</th>
				<th><input type='text' class='form-control'  id='profit'  required name='profit' placeholder='test' >%</th>
				<th><input type='text' class='form-control'  id='profit10'  required name='profit10' placeholder='test' >%</th>
				<th><input type='text' class='form-control'  id='profit30'  required name='profit30' placeholder='test' >%</th>
				<th><input type='text' class='form-control'  id='profitspot'  required name='profitspot' placeholder='test' >%</th>
			</tr>
			<tr id='tempat_botprice'>
				<th>Bottom Price</th>
				<th><input type='text' class='form-control' id='bottom_price'  required name='bottom_price' placeholder='test' ></th>
				<th><input type='text' class='form-control' id='bottom_price10'  required name='bottom_price10' placeholder='test' ></th>
				<th><input type='text' class='form-control' id='bottom_price30'  required name='bottom_price30' placeholder='test' ></th>
				<th><input type='text' class='form-control' id='bottom_pricespot'  required name='bottom_pricespot' placeholder='test' ></th>
			</tr>
			</table>
			</div>
		";
		}
                endforeach;
		
    }
	
		

	public function deleteBentuk(){
		$this->auth->restrict($this->deletePermission);
		$id = $this->input->post('id');
		// print_r($id);
		// exit();
		$data = [
			'deleted' 		=> '1',
			'deleted_by' 	=> $this->auth->user_id()
		];
		
		$this->db->trans_begin();
		$this->db->where('id_bentuk',$id)->update("ms_bentuk",$data);
		
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$status	= array(
			  'pesan'		=>'Gagal Save Item. Thanks ...',
			  'status'	=> 0
			);
		} else {
			$this->db->trans_commit();
			$status	= array(
			  'pesan'		=>'Success Save Item. Thanks ...',
			  'status'	=> 1
			);			
		}
		
  		echo json_encode($status);
	}
		public function SaveNewInquery()
    {
        $this->auth->restrict($this->addPermission);
		$post = $this->input->post();
		$id_cust = $post['id_customer'];
		$cek_cust	= $this->db->query("SELECT * FROM tr_inquiry WHERE id_customer = '$id_cust' ")->result();
		$code = $this->Inquiry_model->generate_id();
		$no_surat = $this->Inquiry_model->BuatNomor();
		$this->db->trans_begin();
		if(!empty($cek_cust)){
			$this->db->trans_rollback();
			$status	= array(
			  'pesan'		=>'CRCL Untuk Customer Tersebut Sudah Ada',
			  'code' => $id_bentuk,
			  'status'	=> 0
			);
		} else{
		$data = [
							'no_inquiry'			=> $code,
							'no_surat'			=> $no_surat,
							'tgl_inquiry'			=> date('Y-m-d'),
							'id_customer'			=> $post['id_customer'],
							'pic_customer'			=> $post['pic_customer'],
							'email_customer'		=> $post['email_customer'],
							'id_sales'				=> $post['id_sales'],
							'berat_palet'		=> $post['berat_palet'],
							'tinggi_palet'		=> $post['tinggi_palet'],
							'id_sales'				=> $post['id_sales'],
							'created_on'			=> date('Y-m-d H:i:s'),
							'created_by'			=> $this->auth->user_id()
                            ];
            //Add Data
               $this->db->insert('tr_inquiry',$data);	
		
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$status	= array(
			  'pesan'		=>'Gagal Save Item. Thanks ...',
			  'code'	=> $code,
			  'status'	=> 0
			  
			);
		} else {
			$this->db->trans_commit();
			$status	= array(
			  'pesan'		=>'Success Save Item. invenThanks ...',
			  'code'	=> $code,
			  'status'	=> 1
			  
			);			
		}
		};
		
  		echo json_encode($status);

    }
	public function SaveNewRoll()
    {
        $this->auth->restrict($this->addPermission);
		$post = $this->input->post();
		$no_inquiry = $post['no_inquiry'];
		$code = $this->Inquiry_model->generate_detail();
		$no_inquery = $post['no_inquiry'];
		$this->db->trans_begin();
		$srt = $this->db->query("SELECT max(id_surat_crcl) as maxkod FROM dt_inquery_transaksi WHERE no_inquery = '".$no_inquery."'")->result();
		$maxkod = $srt[0]->maxkod;
		$daya =(int) substr($maxkod,6,2);
		$hitung = $daya +1;
		$no_surat = "CRCL-".str_pad($hitung, 2, "0", STR_PAD_LEFT)."-".$post['width'];
		$config['upload_path'] = './assets/files/inquiry/'; //path folder
	    $config['allowed_types'] = 'gif|jpg|png|jpeg'; //type yang dapat diakses bisa anda sesuaikan
	    $config['encrypt_name'] = false; //Enkripsi nama yang terupload

	    $this->upload->initialize($config);
	   

	        if ($this->upload->do_upload('image_labels')){
	            $gbr = $this->upload->data();
	            //Compress Image
	            $config['image_library']='gd2';
	            $config['source_image']='./assets/files/inquiry/'.$gbr['file_name'];
	            $config['create_thumb']= FALSE;
				$config['overwrite']= TRUE;
	            $config['maintain_ratio']= FALSE;
	            $config['quality']= '50%';
	            $config['width']= 260;
	            $config['height']= 350;
	            $config['new_image']= './assets/files/inquiry/'.$gbr['file_name'];
	            $this->load->library('image_lib', $config);
	            $this->image_lib->resize();

	            $gambar  =$gbr['file_name'];
				$type    =$gbr['file_type'];
				$ukuran  =$gbr['file_size'];
				$ext1    =explode('.', $gambar);
				$ext     =$ext1[1];
				$lokasi = './assets/files/inquiry/'.$gbr['file_name'];	
			}
		$config2['upload_path'] = './assets/files/inquiry/'; //path folder
	    $config2['allowed_types'] = 'gif|jpg|png|jpeg'; //type yang dapat diakses bisa anda sesuaikan
	    $config2['encrypt_name'] = false; //Enkripsi nama yang terupload

	    $this->upload->initialize($config2);
			if ($this->upload->do_upload('image_packing')){
	            $gbr2 = $this->upload->data();
	            //Compress Image
	            $config2['image_library']='gd2';
	            $config2['source_image']='./assets/files/inquiry/'.$gbr2['file_name'];
	            $config2['create_thumb']= FALSE;
				$config2['overwrite']= TRUE;
	            $config2['maintain_ratio']= FALSE;
	            $config2['quality']= '50%';
	            $config2['width']= 260;
	            $config2['height']= 350;
	            $config2['new_image']= './assets/files/inquiry/'.$gbr2['file_name'];
	            $this->load->library('image_lib', $config2);
	            $this->image_lib->resize();

	            $gambar2  =$gbr2['file_name'];
				$type2    =$gbr2['file_type'];
				$ukuran2  =$gbr2['file_size'];
				$ext2    =explode('.', $gambar2);
				$ex2     =$ext2[1];
				$lokasi2 = './assets/files/inquiry/'.$gbr2['file_name'];	
			}
		$data = [
							'id_dt_inquery'			=> $code,
							'id_surat_crcl'			=> $no_surat,
							'no_inquery'			=> $post['no_inquiry'],
							'id_bentuk'				=> $post['id_bentuk'],
							'id_category3'			=> $post['id_category3'],
							'thickness'				=> $post['thickness'],
							'density'				=> $post['density'],
							'dimensi1'				=> $post['width'],
							'berat_produk'			=> $post['berat_produk'],
							'berat_produk_max'		=> $post['berat_produk_max'],
							'dimensi2'				=> $post['panjang'],
							'qty_order'				=> $post['qty_order'],
							'total_berat'			=> $post['total_berat'],
							'rerata'				=> $post['rerata'],
							'target_harga'			=> $post['target_harga'],
							'master_sample'			=> $post['master_sample'],
							'mill_sheet'			=> $post['mill_sheet'],
							'toleransi1max'			=> $post['toleransi1max'],
							'toleransi1min'			=> $post['toleransi1min'],
							'toleransi2max'			=> $post['toleransi2max'],
							'toleransi2min'			=> $post['toleransi2min'],
							'burry'					=> $post['burry'],
							'sambungan'				=> $post['sambungan'],
							'apperance'				=> $post['apperance'],
							'maxjoin'				=> $post['maxjoin'],
							'idiameter'				=> $post['idiameter'],
							'odiameter'				=> $post['odiameter'],
							'labels'					=> $post['labels'],
							'packing'				=> $post['packing'],
							'paking'				=> $post['paking'],
							'image_labels'				=> $lokasi,
							'image_packing'				=> $lokasi2,
							'deleted' 				=>'0',
							'created_on' 			=> date('Y-m-d H:i:s'),
							'created_by' 			=> $this->auth->user_id()
                            ];
               $this->db->insert('dt_inquery_transaksi',$data);	
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$status	= array(
			  'pesan'		=>'Gagal Save Item. Thanks ...',
			  'code' => $no_inquiry,
			  'status'	=> 0
			  
			);
		} else {
			$this->db->trans_commit();
			$status	= array(
			  'pesan'		=>'Success Save Item. invenThanks ...',
			  'code' => $no_inquiry,
			  'status'	=> 1
			  
			);			
		}
		
  		echo json_encode($status);

    }
	public function SaveEditRoll()
    {
        $this->auth->restrict($this->addPermission);
		$post = $this->input->post();
		$id=$post['id_dt_inquery'];
		$no_inquiry = $post['no_inquiry'];
		$code = $this->Inquiry_model->generate_detail();
		$this->db->trans_begin();
		$config['upload_path'] = './assets/files/inquiry/'; //path folder
	    $config['allowed_types'] = 'gif|jpg|png|jpeg'; //type yang dapat diakses bisa anda sesuaikan
	    $config['encrypt_name'] = false; //Enkripsi nama yang terupload

	    $this->upload->initialize($config);
	   

	        if ($this->upload->do_upload('image_labels')){
	            $gbr = $this->upload->data();
	            //Compress Image
	            $config['image_library']='gd2';
	            $config['source_image']='./assets/files/inquiry/'.$gbr['file_name'];
	            $config['create_thumb']= FALSE;
				$config['overwrite']= TRUE;
	            $config['maintain_ratio']= FALSE;
	            $config['quality']= '50%';
	            $config['width']= 260;
	            $config['height']= 350;
	            $config['new_image']= './assets/files/inquiry/'.$gbr['file_name'];
	            $this->load->library('image_lib', $config);
	            $this->image_lib->resize();

	            $gambar  =$gbr['file_name'];
				$type    =$gbr['file_type'];
				$ukuran  =$gbr['file_size'];
				$ext1    =explode('.', $gambar);
				$ext     =$ext1[1];
				$lokasi = './assets/files/inquiry/'.$gbr['file_name'];	
			}else{
				$lokasi= $post['old_image_labels'];
			}
		$config2['upload_path'] = './assets/files/inquiry/'; //path folder
	    $config2['allowed_types'] = 'gif|jpg|png|jpeg'; //type yang dapat diakses bisa anda sesuaikan
	    $config2['encrypt_name'] = false; //Enkripsi nama yang terupload

	    $this->upload->initialize($config2);
			if ($this->upload->do_upload('image_packing')){
	            $gbr2 = $this->upload->data();
	            //Compress Image
	            $config2['image_library']='gd2';
	            $config2['source_image']='./assets/files/inquiry/'.$gbr2['file_name'];
	            $config2['create_thumb']= FALSE;
				$config2['overwrite']= TRUE;
	            $config2['maintain_ratio']= FALSE;
	            $config2['quality']= '50%';
	            $config2['width']= 260;
	            $config2['height']= 350;
	            $config2['new_image']= './assets/files/inquiry/'.$gbr2['file_name'];
	            $this->load->library('image_lib', $config2);
	            $this->image_lib->resize();

	            $gambar2  =$gbr2['file_name'];
				$type2    =$gbr2['file_type'];
				$ukuran2  =$gbr2['file_size'];
				$ext2    =explode('.', $gambar2);
				$ex2     =$ext2[1];
				$lokasi2 = './assets/files/inquiry/'.$gbr2['file_name'];	
			}
			else{
				$lokasi2= $post['old_image_packing'];
			}
		$data = [
							'no_inquery'			=> $post['no_inquiry'],
							'id_bentuk'				=> $post['id_bentuk'],
							'id_category3'			=> $post['id_category3'],
							'thickness'				=> $post['thickness'],
							'density'				=> $post['density'],
							'dimensi1'				=> $post['width'],
							'berat_produk'			=> $post['berat_produk'],
							'berat_produk_max'		=> $post['berat_produk_max'],
							'dimensi2'				=> $post['panjang'],
							'qty_order'				=> $post['qty_order'],
							'total_berat'			=> $post['total_berat'],
							'rerata'				=> $post['rerata'],
							'target_harga'			=> $post['target_harga'],
							'master_sample'			=> $post['master_sample'],
							'mill_sheet'			=> $post['mill_sheet'],
							'toleransi1max'			=> $post['toleransi1max'],
							'toleransi1min'			=> $post['toleransi1min'],
							'toleransi2max'			=> $post['toleransi2max'],
							'toleransi2min'			=> $post['toleransi2min'],
							'burry'					=> $post['burry'],
							'sambungan'				=> $post['sambungan'],
							'apperance'				=> $post['apperance'],
							'maxjoin'				=> $post['maxjoin'],
							'idiameter'				=> $post['idiameter'],
							'odiameter'				=> $post['odiameter'],
							'labels'					=> $post['labels'],
							'packing'				=> $post['packing'],
							'paking'				=> $post['paking'],
							'image_labels'				=> $lokasi,
							'image_packing'				=> $lokasi2,
							'deleted' 				=>'0',
							'created_on' 			=> date('Y-m-d H:i:s'),
							'created_by' 			=> $this->auth->user_id()
                            ];
							$this->db->where('id_dt_inquery',$id)->update("dt_inquery_transaksi",$data);

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$status	= array(
			  'pesan'		=>'Gagal Save Item. Thanks ...',
			  'code' => $no_inquiry,
			  'status'	=> 0
			  
			);
		} else {
			$this->db->trans_commit();
			$status	= array(
			  'pesan'		=>'Success Save Item. invenThanks ...',
			  'code' => $no_inquiry,
			  'status'	=> 1
			  
			);			
		}
		
  		echo json_encode($status);

    }
	public function 
	SaveNewSheet()
    {
        $this->auth->restrict($this->addPermission);
		$post = $this->input->post();
		$no_inquiry = $post['no_inquiry'];
		$code = $this->Inquiry_model->generate_detail();
		$this->db->trans_begin();
		$no_inquery = $post['no_inquiry'];
		$srt = $this->db->query("SELECT max(id_surat_crcl) as maxkod FROM dt_inquery_transaksi WHERE no_inquery = '".$no_inquery."'")->result();
		$maxkod = $srt[0]->maxkod;
		$daya =(int) substr($maxkod,6,2);
		$hitung = $daya +1;
		$no_surat = "CRCL-".str_pad($hitung, 2, "0", STR_PAD_LEFT)."-".$post['width'];
		$config['upload_path'] = './assets/files/inquiry/'; //path folder
	    $config['allowed_types'] = 'gif|jpg|png|jpeg'; //type yang dapat diakses bisa anda sesuaikan
	    $config['encrypt_name'] = false; //Enkripsi nama yang terupload

	    $this->upload->initialize($config);
	   

	        if ($this->upload->do_upload('image_labels')){
	            $gbr = $this->upload->data();
	            //Compress Image
	            $config['image_library']='gd2';
	            $config['source_image']='./assets/files/inquiry/'.$gbr['file_name'];
	            $config['create_thumb']= FALSE;
				$config['overwrite']= TRUE;
	            $config['maintain_ratio']= FALSE;
	            $config['quality']= '50%';
	            $config['width']= 260;
	            $config['height']= 350;
	            $config['new_image']= './assets/files/inquiry/'.$gbr['file_name'];
	            $this->load->library('image_lib', $config);
	            $this->image_lib->resize();

	            $gambar  =$gbr['file_name'];
				$type    =$gbr['file_type'];
				$ukuran  =$gbr['file_size'];
				$ext1    =explode('.', $gambar);
				$ext     =$ext1[1];
				$lokasi = './assets/files/inquiry/'.$gbr['file_name'].'.'.$ext;	
			}
		$config2['upload_path'] = './assets/files/inquiry/'; //path folder
	    $config2['allowed_types'] = 'gif|jpg|png|jpeg'; //type yang dapat diakses bisa anda sesuaikan
	    $config2['encrypt_name'] = false; //Enkripsi nama yang terupload

	    $this->upload->initialize($config2);
			if ($this->upload->do_upload('image_packing')){
	            $gbr2 = $this->upload->data();
	            //Compress Image
	            $config2['image_library']='gd2';
	            $config2['source_image']='./assets/files/inquiry/'.$gbr2['file_name'];
	            $config2['create_thumb']= FALSE;
				$config2['overwrite']= TRUE;
	            $config2['maintain_ratio']= FALSE;
	            $config2['quality']= '50%';
	            $config2['width']= 260;
	            $config2['height']= 350;
	            $config2['new_image']= './assets/files/inquiry/'.$gbr2['file_name'];
	            $this->load->library('image_lib', $config2);
	            $this->image_lib->resize();

	            $gambar2  =$gbr2['file_name'];
				$type2    =$gbr2['file_type'];
				$ukuran2  =$gbr2['file_size'];
				$ext2    =explode('.', $gambar2);
				$ex2     =$ext2[1];
				$lokasi2 = './assets/files/inquiry/'.$gbr2['file_name'].'.';	
			}
		$data = [
							'id_dt_inquery'			=> $code,
							'id_surat_crcl'			=> $no_surat,
							'no_inquery'			=> $post['no_inquiry'],
							'id_bentuk'				=> $post['id_bentuk'],
							'id_category3'			=> $post['id_category3'],
							'thickness'				=> $post['thickness'],
							'density'				=> $post['density'],
							'dimensi1'				=> $post['width'],
							'berat_produk'			=> $post['berat_produk'],
							'berat_produk_max'			=> $post['berat_produk_max'],
							'dimensi2'				=> $post['panjang'],
							'qty_order'				=> $post['qty_order'],
							'total_berat'			=> $post['total_berat'],
							'rerata'				=> $post['rerata'],
							'target_harga'			=> $post['target_harga'],
							'master_sample'			=> $post['master_sample'],
							'mill_sheet'			=> $post['mill_sheet'],
							'toleransi1max'			=> $post['toleransi1max'],
							'toleransi1min'			=> $post['toleransi1min'],
							'toleransi2max'			=> $post['toleransi2max'],
							'toleransi2min'			=> $post['toleransi2min'],
							'burry'					=> $post['burry'],
							'apperance'				=> $post['apperance'],
							'labels'					=> $post['labels'],
							'packing'				=> $post['packing'],
							'image_labels'				=> $lokasi,
							'image_packing'				=> $lokasi2,
							'deleted' 				=>'0',
							'created_on' 			=> date('Y-m-d H:i:s'),
							'created_by' 			=> $this->auth->user_id()
                            ];
               $this->db->insert('dt_inquery_transaksi',$data);	
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$status	= array(
			  'pesan'		=>'Gagal Save Item. Thanks ...',
			  'code' => $no_inquiry,
			  'status'	=> 0
			  
			);
		} else {
			$this->db->trans_commit();
			$status	= array(
			  'pesan'		=>'Success Save Item. invenThanks ...',
			  'code' => $no_inquiry,
			  'status'	=> 1
			  
			);			
		}
		
  		echo json_encode($status);

    }
	public function SaveEditSheet()
    {
        $this->auth->restrict($this->addPermission);
		$post = $this->input->post();
		$no_inquiry = $post['no_inquiry'];
		$id=$post['id_dt_inquery'];
		$code = $this->Inquiry_model->generate_detail();
		$this->db->trans_begin();
		$config['upload_path'] = './assets/files/inquiry/'; //path folder
	    $config['allowed_types'] = 'gif|jpg|png|jpeg'; //type yang dapat diakses bisa anda sesuaikan
	    $config['encrypt_name'] = false; //Enkripsi nama yang terupload

	    $this->upload->initialize($config);
	   

	        if ($this->upload->do_upload('image_labels')){
	            $gbr = $this->upload->data();
	            //Compress Image
	            $config['image_library']='gd2';
	            $config['source_image']='./assets/files/inquiry/'.$gbr['file_name'];
	            $config['create_thumb']= FALSE;
				$config['overwrite']= TRUE;
	            $config['maintain_ratio']= FALSE;
	            $config['quality']= '50%';
	            $config['width']= 260;
	            $config['height']= 350;
	            $config['new_image']= './assets/files/inquiry/'.$gbr['file_name'];
	            $this->load->library('image_lib', $config);
	            $this->image_lib->resize();

	            $gambar  =$gbr['file_name'];
				$type    =$gbr['file_type'];
				$ukuran  =$gbr['file_size'];
				$ext1    =explode('.', $gambar);
				$ext     =$ext1[1];
				$lokasi = './assets/files/inquiry/'.$gbr['file_name'].'.'.$ext;	
			}
			else{
				$lokasi= $post['old_image_labels'];
			}
		$config2['upload_path'] = './assets/files/inquiry/'; //path folder
	    $config2['allowed_types'] = 'gif|jpg|png|jpeg'; //type yang dapat diakses bisa anda sesuaikan
	    $config2['encrypt_name'] = false; //Enkripsi nama yang terupload

	    $this->upload->initialize($config2);
			if ($this->upload->do_upload('image_packing')){
	            $gbr2 = $this->upload->data();
	            //Compress Image
	            $config2['image_library']='gd2';
	            $config2['source_image']='./assets/files/inquiry/'.$gbr2['file_name'];
	            $config2['create_thumb']= FALSE;
				$config2['overwrite']= TRUE;
	            $config2['maintain_ratio']= FALSE;
	            $config2['quality']= '50%';
	            $config2['width']= 260;
	            $config2['height']= 350;
	            $config2['new_image']= './assets/files/inquiry/'.$gbr2['file_name'];
	            $this->load->library('image_lib', $config2);
	            $this->image_lib->resize();

	            $gambar2  =$gbr2['file_name'];
				$type2    =$gbr2['file_type'];
				$ukuran2  =$gbr2['file_size']; 
				$ext2    =explode('.', $gambar2);
				$ex2     =$ext2[1];
				$lokasi2 = './assets/files/inquiry/'.$gbr2['file_name'].'.';	
			}else{
				$lokasi2= $post['old_image_packing'];
			}
		$data = [
							
							'id_surat_crcl'			=> $post['id_surat_CRCL'],
							'no_inquery'			=> $post['no_inquiry'],
							'id_bentuk'				=> $post['id_bentuk'],
							'id_category3'			=> $post['id_category3'],
							'thickness'				=> $post['thickness'],
							'density'				=> $post['density'],
							'dimensi1'				=> $post['width'],
							'berat_produk'			=> $post['berat_produk'],
							'berat_produk_max'			=> $post['berat_produk_max'],
							'dimensi2'				=> $post['panjang'],
							'qty_order'				=> $post['qty_order'],
							'total_berat'			=> $post['total_berat'],
							'rerata'				=> $post['rerata'],
							'target_harga'			=> $post['target_harga'],
							'master_sample'			=> $post['master_sample'],
							'mill_sheet'			=> $post['mill_sheet'],
							'toleransi1max'			=> $post['toleransi1max'],
							'toleransi1min'			=> $post['toleransi1min'],
							'toleransi2max'			=> $post['toleransi2max'],
							'toleransi2min'			=> $post['toleransi2min'],
							'burry'					=> $post['burry'],
							'apperance'				=> $post['apperance'],
							'labels'					=> $post['labels'],
							'packing'				=> $post['packing'],
							'image_labels'				=> $lokasi,
							'image_packing'				=> $lokasi2,
							'deleted' 				=>'0',
							'created_on' 			=> date('Y-m-d H:i:s'),
							'created_by' 			=> $this->auth->user_id()
                            ];
               $this->db->where('id_dt_inquery',$id)->update("dt_inquery_transaksi",$data);
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$status	= array(
			  'pesan'		=>'Gagal Save Item. Thanks ...',
			  'code' => $no_inquiry,
			  'status'	=> 0
			  
			);
		} else {
			$this->db->trans_commit();
			$status	= array(
			  'pesan'		=>'Success Save Item. invenThanks ...',
			  'code' => $no_inquiry,
			  'status'	=> 1
			  
			);			
		}
		
  		echo json_encode($status);

    }
	public function saveEditbentuk()
    {
        $this->auth->restrict($this->addPermission);
		$session = $this->session->userdata('app_session');
		$this->db->trans_begin();
		
		$numb1 =0;
		foreach($_POST['hd1'] as $h1){
		$numb1++;	
		        $produk = $_POST['hd1']['1']['id_bentuk'];
                $header1 =  array(
							'nm_bentuk'		        => $h1[nm_bentuk],
							'modified_on'		=> date('Y-m-d H:i:s'),
							'modified_by'		=> $this->auth->user_id(),
							'deleted'			=> '0' 
                            );
            //Add Data
			 $this->db->where('id_bentuk',$produk)->update("ms_bentuk",$header1);
		    }	
		if(empty($_POST['data1'])){
		}else{
		$numb2 =0;
		foreach($_POST['data1'] as $d1){
		$numb2++;	
		
		      $code = $_POST['hd1']['1']['id_bentuk'];    
              $data1 =  array(
			                    'id_bentuk'=>$code, 
								'nm_dimensi'=>$d1[nm_dimensi],
								'deleted' =>'0',
							    'created_on' => date('Y-m-d H:i:s'),
								'created_by' => $session['id_user'], 
                            );
            //Add Data
              $this->db->insert('ms_dimensi',$data1);
		    }		
		}
		$numb3 =0;
		foreach($_POST['data2'] as $d2){
		$numb3++;	
		
		      $info = $d2['id_dimensi'];    
              $data2 =  array(
								'nm_dimensi'=>$d2[nm_dimensi],
								'deleted' =>'0',
							    'modified_on' => date('Y-m-d H:i:s'),
								'modified_by' => $session['id_user'], 
                            );
            //Add Data
             $this->db->where('id_dimensi',$info)->update("ms_dimensi",$data2);
		    }	         		
	
		
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$status	= array(
			  'pesan'		=>'Gagal Save Item. Thanks ...',
			  'status'	=> 0
			);
		} else {
			$this->db->trans_commit();
			$status	= array(
			  'pesan'		=>'Success Save Item. invenThanks ...',
			  'status'	=> 1
			);			
		}
		
  		echo json_encode($status);

    }
	public function saveNewinventoryold()
    {
        $this->auth->restrict($this->addPermission);
		$post = $this->input->post();
		$code = $this->Inventory_2_model->generate_id();
		$this->db->trans_begin();
		$data = [
			'id_category1'	 	=> $code,
			'id_type'		    => $post['inventory_1'],
			'nama'		        => $post['nm_inventory'],
			'aktif'				=> 'aktif',
			'created_on'		=> date('Y-m-d H:i:s'),
			'created_by'		=> $this->auth->user_id(),
			'deleted'			=> '0'
		];
		
		$insert = $this->db->insert("ms_inventory_category1",$data);
		
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$status	= array(
			  'pesan'		=>'Gagal Save Item. Thanks ...',
			  'status'	=> 0
			);
		} else {
			$this->db->trans_commit();
			$status	= array(
			  'pesan'		=>'Success Save Item. invenThanks ...',
			  'status'	=> 1
			);			
		}
		
  		echo json_encode($status);

    }
	
}
