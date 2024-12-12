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

class Adjustmentstock extends Admin_Controller
{
    //Permission
    protected $viewPermission 	= 'Adjustmentstock.View';
    protected $addPermission  	= 'Adjustmentstock.Add';
    protected $managePermission = 'Adjustmentstock.Manage';
    protected $deletePermission = 'Adjustmentstock.Delete';

    public function __construct()
    {
        parent::__construct();

        $this->load->library(array('Mpdf', 'upload', 'Image_lib'));
        $this->load->model(array('Adjustmentstock/Inventory_4_model',
                                 'Aktifitas/aktifitas_model',
                                ));
        $this->template->title('Manage Data Supplier');
        $this->template->page_icon('fa fa-building-o');

        date_default_timezone_set('Asia/Bangkok');
    }
		public function index()
    {
		$id_bentuk = $this->uri->segment(3);
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
		$deleted = '0';
        $stok		 = $this->Inventory_4_model->get_data_stock();
		$history	= $this->db->query("SELECT * FROM adjustment_stock ")->result();
		$data = [
		'stok' => $stok,
		'history' => $history,
		];
        $this->template->set('results', $data);
        $this->template->title('Adjustment Stock');
        $this->template->render('index');
    }
		public function detail()
    {
		$id_category3 = $this->uri->segment(3);
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
        $data = $this->Inventory_4_model->dapat_stock($id_category3);
        $this->template->set('results', $data);
        $this->template->title('Stock Material');
        $this->template->render('list');
    }
		public function GudangRawMaterial()
    {
		$id_gudang = '1';
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
		$gudang = $this->Inventory_4_model->PerGudang($id_gudang);
		$jumlah = $this->Inventory_4_model->SumPerGudang($id_gudang);
		$data = [
		'gudang' => $gudang,
		'jumlah' => $jumlah,
		];
        $this->template->set('results', $data);
        $this->template->title('Stock Material');
        $this->template->render('gudang');
    }
		public function GudangWIP()
    {
		$id_gudang = '2';
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
        $gudang = $this->Inventory_4_model->PerGudang($id_gudang);
		$jumlah = $this->Inventory_4_model->SumPerGudang($id_gudang);
		$data = [
		'gudang' => $gudang,
		'jumlah' => $jumlah,
		];
        $this->template->set('results', $data);
        $this->template->title('Stock Material');
        $this->template->render('gudang');
    }
		public function GudangFinishGood()
    {
		$id_gudang = '3';
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
        $gudang = $this->Inventory_4_model->PerGudang($id_gudang);
		$jumlah = $this->Inventory_4_model->SumPerGudang($id_gudang);
		$data = [
		'gudang' => $gudang,
		'jumlah' => $jumlah,
		];
        $this->template->set('results', $data);
        $this->template->title('Stock Material');
        $this->template->render('gudang');
    }
	public function GudangScrap()
    {
		$id_gudang = '4';
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
        $gudang = $this->Inventory_4_model->PerGudang($id_gudang);
		$jumlah = $this->Inventory_4_model->SumPerGudang($id_gudang);
		$data = [
		'gudang' => $gudang,
		'jumlah' => $jumlah,
		];
        $this->template->set('results', $data);
        $this->template->title('Stock Material');
        $this->template->render('gudang');
    }
	public function GudangSubcont()
    {
		$id_gudang = '5';
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
        $gudang = $this->Inventory_4_model->PerGudang($id_gudang);
		$jumlah = $this->Inventory_4_model->SumPerGudang($id_gudang);
		$data = [
		'gudang' => $gudang,
		'jumlah' => $jumlah,
		];
        $this->template->set('results', $data);
        $this->template->title('Stock Material');
        $this->template->render('gudang');
    }
	
		public function editInventory($id)
    {
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$deleted = '0';
		$inven = $this->Inventory_4_model->getedit($id);
		$komposisiold = $this->Inventory_4_model->get_data('child_inven_compotition','id_category3',$id);
		$komposisi = $this->Inventory_4_model->kompos($id);
		$dimensiold = $this->Inventory_4_model->get_data('child_inven_dimensi','id_category3',$id);
		$dimensi = $this->Inventory_4_model->dimensy($id);
		$supl = $this->Inventory_4_model->supl($id);
		$inventory_1 = $this->Inventory_4_model->get_data('ms_inventory_type','deleted',$deleted);
		$inventory_2 = $this->Inventory_4_model->get_data('ms_inventory_category1','deleted',$deleted);
		$inventory_3 = $this->Inventory_4_model->get_data('ms_inventory_category2','deleted',$deleted);
		$maker = $this->Inventory_4_model->get_data('negara');
		$id_bentuk = $this->Inventory_4_model->get_data('ms_bentuk');
		$id_supplier = $this->Inventory_4_model->get_data('master_supplier');
		$id_surface = $this->Inventory_4_model->get_data('ms_surface');
		$dt_suplier = $this->Inventory_4_model->get_data('child_inven_suplier','id_category3',$id);
		$data = [
			'inventory_1' => $inventory_1,
			'inventory_2' => $inventory_2,
			'inventory_3' => $inventory_3,
			'komposisi' => $komposisi,
			'dimensi' => $dimensi,
			'id_bentuk' => $id_bentuk,
			'inven' => $inven,
			'maker' => $maker,
			'supl' => $supl,
			'id_surface' => $id_surface,
			'id_supplier' => $id_supplier,
			'dt_suplier' => $dt_suplier
		];
        $this->template->set('results', $data);
        $this->template->title('Add Inventory');
        $this->template->render('edit_inventory');

    }
	public function copyInventory($id)
    {
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$deleted = '0';
		$inven = $this->Inventory_4_model->getedit($id);
		$komposisiold = $this->Inventory_4_model->get_data('child_inven_compotition','id_category3',$id);
		$komposisi = $this->Inventory_4_model->kompos($id);
		$dimensiold = $this->Inventory_4_model->get_data('child_inven_dimensi','id_category3',$id);
		$dimensi = $this->Inventory_4_model->dimensy($id);
		$supl = $this->Inventory_4_model->supl($id);
		$inventory_1 = $this->Inventory_4_model->get_data('ms_inventory_type','deleted',$deleted);
		$inventory_2 = $this->Inventory_4_model->get_data('ms_inventory_category1','deleted',$deleted);
		$inventory_3 = $this->Inventory_4_model->get_data('ms_inventory_category2','deleted',$deleted);
		$maker = $this->Inventory_4_model->get_data('negara');
		$id_bentuk = $this->Inventory_4_model->get_data('ms_bentuk');
		$id_supplier = $this->Inventory_4_model->get_data('master_supplier');
		$id_surface = $this->Inventory_4_model->get_data('ms_surface');
		$dt_suplier = $this->Inventory_4_model->get_data('child_inven_suplier','id_category3',$id);
		$data = [
			'inventory_1' => $inventory_1,
			'inventory_2' => $inventory_2,
			'inventory_3' => $inventory_3,
			'komposisi' => $komposisi,
			'dimensi' => $dimensi,
			'id_bentuk' => $id_bentuk,
			'inven' => $inven,
			'maker' => $maker,
			'supl' => $supl,
			'id_surface' => $id_surface,
			'id_supplier' => $id_supplier,
			'dt_suplier' => $dt_suplier
		];
        $this->template->set('results', $data);
        $this->template->title('Add Inventory');
        $this->template->render('copy_inventory');

    }
	public function viewInventory($id)
    {
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$deleted = '0';
		$inven = $this->Inventory_4_model->getedit($id);
		$komposisiold = $this->Inventory_4_model->get_data('child_inven_compotition','id_category3',$id);
		$komposisi = $this->Inventory_4_model->kompos($id);
		$dimensiold = $this->Inventory_4_model->get_data('child_inven_dimensi','id_category3',$id);
		$dimensi = $this->Inventory_4_model->dimensy($id);
		$supl = $this->Inventory_4_model->supl($id);
		$inventory_1 = $this->Inventory_4_model->get_data('ms_inventory_type','deleted',$deleted);
		$inventory_2 = $this->Inventory_4_model->get_data('ms_inventory_category1','deleted',$deleted);
		$inventory_3 = $this->Inventory_4_model->get_data('ms_inventory_category2','deleted',$deleted);
		$maker = $this->Inventory_4_model->get_data('negara');
		$id_bentuk = $this->Inventory_4_model->get_data('ms_bentuk');
		$id_supplier = $this->Inventory_4_model->get_data('master_supplier');
		$id_surface = $this->Inventory_4_model->get_data('ms_surface');
		$dt_suplier = $this->Inventory_4_model->get_data('child_inven_suplier','id_category3',$id);
		$data = [
			'inventory_1' => $inventory_1,
			'inventory_2' => $inventory_2,
			'inventory_3' => $inventory_3,
			'komposisi' => $komposisi,
			'dimensi' => $dimensi,
			'id_bentuk' => $id_bentuk,
			'inven' => $inven,
			'maker' => $maker,
			'supl' => $supl,
			'id_surface' => $id_surface,
			'id_supplier' => $id_supplier,
			'dt_suplier' => $dt_suplier
		];
        $this->template->set('results', $data);
        $this->template->title('Add Inventory');
        $this->template->render('view_inventory');

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
	
	
	public function addInventory($id)
    {
		$id_data 	= $this->input->post('id');
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$deleted = '0';
		$inventory_1 = $this->Inventory_4_model->get_data('ms_inventory_type','deleted',$deleted);
		$maker = $this->Inventory_4_model->get_data('negara');
		$dimensi = $this->Inventory_4_model->get_data('ms_dimensi','id_bentuk',$id_data);
		$id_bentuk = $this->Inventory_4_model->get_data('ms_bentuk','id_bentuk',$id_data);
		$id_supplier = $this->Inventory_4_model->get_data('master_supplier','deleted',$deleted);
		$id_surface = $this->Inventory_4_model->get_data('ms_surface');
		$data = [
			'inventory_1' => $inventory_1,
			'id_bentuk' => $id_bentuk,
			'dimensi' => $dimensi,
			'maker' => $maker,
			'id_surface' => $id_surface,
			'id_supplier' => $id_supplier
		];
        $this->template->set('results', $data);
        $this->template->title('Add Inventory');
        $this->template->render('add_inventory');

    }

		public function AddStock($id)
    {
		$id_category3 = $this->uri->segment(3);
		$id_data 	= $this->input->post('id');
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$inventory_3 = $this->Inventory_4_model->GetMaterial($id_category3);
		$gudang = $this->Inventory_4_model->get_data('ms_gudang');
		$data = [
			'inventory_3' => $inventory_3,
			'gudang' => $gudang
		];
        $this->template->set('results', $data);
        $this->template->title('Add Stock');
        $this->template->render('AddStock');

    }
	
		public function AdjustNow($id)
    {
		$id_category3 = $this->uri->segment(3);
		$id_stock = $this->uri->segment(4);
		$id_data 	= $this->input->post('id');
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$inventory_3 = $this->Inventory_4_model->GetMaterial($id_category3);
		$data = [
			'inventory_3' => $inventory_3,
			'idstock' => $id_stock
		];
        $this->template->set('results', $data);
        $this->template->title('Add Stock');
        $this->template->render('Adjust');

    }

	public function delDetail(){
		$this->auth->restrict($this->deletePermission);
		$id = $this->input->post('id');
		// print_r($id);
		// exit();
		$data = [
			'deleted' 		=> '1',
			'deleted_by' 	=> $this->auth->user_id()
		];
		
		$this->db->trans_begin();
		$this->db->where('id_dimensi',$id)->update("ms_dimensi",$data);
		
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
	public function LotNumber(){
		$adjus			=$_GET['adjus'];
		$id_material	=$_GET['id_material'];
		$lookstock 		= $this->db->query("SELECT * FROM stock_material WHERE id_category3 = '$id_material' ")->result();		
		if($adjus == 'PLUS'){
			echo"<input type='text' class='form-control' id='lotno'  name='lotno' placeholder='Lot Number Metalsindo'>";
		}elseif($adjus == 'MINUS') {
			echo"<select class='form-control' id='id_stock'  name='id_stock' onchange='GetDataMinus()' >
				<option>-Pilih-</option>";
			foreach ($lookstock as $stock){
				echo"<option value='$stock->id_stock'>$stock->lotno</option>";
			};
			echo"</select>";
		}elseif($adjus == 'MUTASI') {
			echo"<select class='form-control' id='id_stock'  name='id_stock' onchange='GetDataMutasi()'>
				<option>-Pilih-</option>";
			foreach ($lookstock as $stock){
				echo"<option value='$stock->id_stock'>$stock->lotno</option>";
			};
			echo"</select>";
		}
	}
	public function HitungJumlah(){
		$total_qty			=$_GET['total_qty'];
		$total_berat			=$_GET['total_berat'];
		$total = $total_qty*$total_berat;
		echo"".$total."";
	}
	public function FormPlus(){
		
		$gudang 		= $this->db->query("SELECT * FROM ms_gudang")->result();	
		echo"
			<div class='form-group row'>
				<div class='col-md-12'>
				<div class='col-md-4'>
						<div class='col-md-5'>
							<label>Qty Adjustment</label>
						</div> 
						<div class='col-md-7' >
						<input type='number' class='form-control' id='total_qty'  required name='total_qty' placeholder='Qty'>
						</div>
				</div>
				</div>
			</div>";
	}
	public function FormMutasi(){
		
		$gudang 		= $this->db->query("SELECT * FROM ms_gudang")->result();	
		echo"<div class='form-group row'>
				<div class='col-md-12' id='form_mother'>
				<div class='col-md-4'>
						<div class='col-md-5'>
							<label>Qty Asal</label>
						</div> 
						<div class='col-md-7'>
						<input type='number' class='form-control' id='mother_qty' readonly required name='mother_qty' placeholder='Qty'>
						</div>
				</div>
				<div class='col-md-4'>
						<div class='col-md-5'>
							<label>Berat/Qty Asal</label>
						</div>
						<div class='col-md-7'>
						<input type='number' class='form-control' id='mother_berat' readonly required name='mother_berat' placeholder='Berat/Qty'>
						</div>
				</div>
				<div class='col-md-4'>
						<div class='col-md-5'>
							<label>Total Berat Asal</label>
						</div>
						<div class='col-md-7'>
						<input type='number' class='form-control' id='mother_jumlah_berat' readonly required name='mother_jumlah_berat' placeholder='Total Berat'>
						</div>
				</div>
				</div>
			</div>
			<div class='form-group row'>
				<div class='col-md-12'>
				<div class='col-md-4'>
						<div class='col-md-5'>
							<label>Qty</label>
						</div> 
						<div class='col-md-7'>
						<input type='number' class='form-control' id='total_qty'  required name='total_qty' placeholder='Qty'>
						</div>
				</div>
				<div class='col-md-4'>
						<div class='col-md-5'>
							<label>Berat/Qty</label>
						</div>
						<div class='col-md-7'>
						<input type='number' class='form-control' id='total_berat' readonly required name='total_berat' placeholder='Berat/Qty'>
						</div>
				</div>
				<div class='col-md-4'>
						<div class='col-md-5'>
							<label>Total Berat</label>
						</div>
						<div class='col-md-7'>
						<input type='number' class='form-control' id='total_jumlah_berat' readonly  required name='total_jumlah_berat' placeholder='Total Berat'>
						</div>
				</div>
				</div>
			</div>
			<div class='form-group row'>
				<div class='col-md-12' id='form_gudang_mother'>
			<div class='col-md-6'>
						<div class='col-md-2'>
							<label>Gudang Asal</label>
						</div> 
						<div class='col-md-10' hidden>
			<input type='number' class='form-control' id='id_gudang' readonly required name='id_gudang' placeholder='Gudang Asal'>
						</div>
						<div class='col-md-10'>
			<input type='number' class='form-control' id='nama_gudang' readonly required name='nama_gudang' placeholder='Gudang Asal'>
						</div>
				</div>
				<div class='col-md-6'>
						<div class='col-md-2'>
							<label>Gudang Tujuan</label>
						</div> 
						<div class='col-md-10'>
			<select class='form-control' id='id_gudang_baru'  name='id_gudang_baru' >
				<option>-Pilih-</option>";
			foreach ($gudang as $gudang){
				echo"<option value='$gudang->id_gudang'>$gudang->nama_gudang</option>";
			};
			echo"</select>
						</div>
				</div>
				</div>
			</div>";
	}
	public function FormMinus(){
		
		$gudang 		= $this->db->query("SELECT * FROM ms_gudang")->result();	
		echo"
			<div class='form-group row'>
				<div class='col-md-12'>
				<div class='col-md-4'>
						<div class='col-md-5'>
							<label>Qty Adjustment</label>
						</div> 
						<div class='col-md-7' >
						<input type='number' class='form-control' id='total_qty'  required name='total_qty' placeholder='Qty'>
						</div>
				</div>
				</div>
			</div>";
	}
	public function AmbilDataMutasi(){
		$id_stock		= $_GET['id_stock'];
		$stocklama 		= $this->db->query("SELECT * FROM stock_material WHERE id_stock='$id_stock'")->result();
		$gudanglama		= $this->db->query("SELECT * FROM ms_gudang WHERE id_gudang='".$stocklama[0]->id_gudang."'")->result();	
		$gudang 		= $this->db->query("SELECT * FROM ms_gudang")->result();	
		echo"<div class='form-group row'>
				<div class='col-md-12' id='form_mother'>
				<div class='col-md-4'>
						<div class='col-md-5'>
							<label>Qty Asal</label>
						</div> 
						<div class='col-md-7'>
						<input type='number' class='form-control' id='mother_qty' value='".$stocklama[0]->qty."' readonly required name='mother_qty' placeholder='Qty'>
						</div>
				</div>
				<div class='col-md-4'>
						<div class='col-md-5'>
							<label>Berat/Qty Asal</label>
						</div>
						<div class='col-md-7'>
						<input type='number' class='form-control' id='mother_berat' value='".$stocklama[0]->weight."' readonly required name='mother_berat' placeholder='Berat/Qty'>
						</div>
				</div>
				<div class='col-md-4'>
						<div class='col-md-5'>
							<label>Total Berat Asal</label>
						</div>
						<div class='col-md-7'>
						<input type='number' class='form-control' id='mother_jumlah_berat' value='".$stocklama[0]->totalweight."' readonly required name='mother_jumlah_berat' placeholder='Total Berat'>
						</div>
				</div>
				</div>
			</div>
			<div class='form-group row' hidden>
				<div class='col-md-12'>
						<div class='col-md-7' >
						<input type='number' class='form-control' value='".$stocklama[0]->length."' id='length'  required name='length' placeholder='Qty'>
						</div>
						<div class='col-md-7'>
						<input type='number' class='form-control' value='".$stocklama[0]->width."' id='width' readonly required name='width' placeholder='Berat/Qty'>
						</div>
						<div class='col-md-7'>
						<input type='number' class='form-control' value='".$stocklama[0]->thickness."' id='thickness' readonly  required name='thickness' placeholder='Total Berat'>
						</div>
						<div class='col-md-7'>
						<input type='text' class='form-control' value='".$stocklama[0]->lotno."' id='lotno' readonly  required name='lotno' placeholder='Total Berat'>
						</div>
				</div>
			</div>
			<div class='form-group row'>
				<div class='col-md-12'>
				<div class='col-md-4'>
						<div class='col-md-5'>
							<label>Qty</label>
						</div> 
						<div class='col-md-7'>
						<input type='number' class='form-control' id='total_qty'  required name='total_qty' onkeyup='HitungJumlahMinus()' placeholder='Qty'>
						</div>
				</div>
				<div class='col-md-4'>
						<div class='col-md-5'>
							<label>Berat/Qty</label>
						</div>
						<div class='col-md-7'>
						<input type='number' class='form-control' id='total_berat' value='".$stocklama[0]->weight."' readonly required name='total_berat' placeholder='Berat/Qty'>
						</div>
				</div>
				<div class='col-md-4'>
						<div class='col-md-5'>
							<label>Total Berat</label>
						</div>
						<div class='col-md-7'>
						<input type='number' class='form-control' id='total_jumlah_berat' readonly  required name='total_jumlah_berat' placeholder='Total Berat'>
						</div>
				</div>
				</div>
			</div>
			<div class='form-group row'>
				<div class='col-md-12' id='form_gudang_mother'>
			<div class='col-md-6'>
						<div class='col-md-2'>
							<label>Gudang Asal</label>
						</div> 
						<div class='col-md-10' hidden>
			<input type='text' class='form-control' id='id_gudang' value='".$stocklama[0]->id_gudang."' readonly required name='id_gudang' placeholder='Gudang Asal'>
						</div>
						<div class='col-md-10'>
			<input type='text' class='form-control' id='nama_gudang' value='".$gudanglama[0]->nama_gudang."'  readonly required name='nama_gudang' placeholder='Gudang Asal'>
						</div>
				</div>
				<div class='col-md-6'>
						<div class='col-md-2'>
							<label>Gudang Tujuan</label>
						</div> 
						<div class='col-md-10'>
			<select class='form-control' id='id_gudang_baru'  name='id_gudang_baru' >
				<option>-Pilih-</option>";
			foreach ($gudang as $gudang){
				echo"<option value='$gudang->id_gudang'>$gudang->nama_gudang</option>";
			};
			echo"</select>
						</div>
				</div>
				</div>
			</div>";
	}
	public function AmbilDataMinus(){
		$id_stock		= $_GET['id_stock'];
		$stocklama 		= $this->db->query("SELECT * FROM stock_material WHERE id_stock='$id_stock'")->result();
		$gudanglama		= $this->db->query("SELECT * FROM ms_gudang WHERE id_gudang='".$stocklama[0]->id_gudang."'")->result();	
		echo"<div class='form-group row'>
				<div class='col-md-12' id='form_mother'>
				<div class='col-md-4'>
						<div class='col-md-5'>
							<label>Qty Asal</label>
						</div> 
						<div class='col-md-7'>
						<input type='number' class='form-control' value='".$stocklama[0]->qty."' id='mother_qty' readonly required name='mother_qty' placeholder='Qty'>
						</div>
				</div>
				<div class='col-md-4'>
						<div class='col-md-5'>
							<label>Berat/Qty Asal</label>
						</div>
						<div class='col-md-7'>
						<input type='number' class='form-control' value='".$stocklama[0]->weight."' id='mother_berat' readonly required name='mother_berat' placeholder='Berat/Qty'>
						</div>
				</div>
				<div class='col-md-4'>
						<div class='col-md-5'>
							<label>Total Berat Asal</label>
						</div>
						<div class='col-md-7'>
						<input type='number' class='form-control' value='".$stocklama[0]->totalweight."' id='mother_jumlah_berat' readonly required name='mother_jumlah_berat' placeholder='Total Berat'>
						</div>
				</div>
				</div>
			</div>
			<div class='form-group row' hidden>
				<div class='col-md-12'>
						<div class='col-md-7' >
						<input type='number' class='form-control' value='".$stocklama[0]->length."' id='length'  required name='length' placeholder='Qty'>
						</div>
						<div class='col-md-7'>
						<input type='number' class='form-control' value='".$stocklama[0]->width."' id='width' readonly required name='width' placeholder='Berat/Qty'>
						</div>
						<div class='col-md-7'>
						<input type='number' class='form-control' value='".$stocklama[0]->thickness."' id='thickness' readonly  required name='thickness' placeholder='Total Berat'>
						</div>
						<div class='col-md-7'>
						<input type='text' class='form-control' value='".$stocklama[0]->lotno."' id='lotno' readonly  required name='lotno' placeholder='Total Berat'>
						</div>
				</div>
			</div>
			<div class='form-group row'>
				<div class='col-md-12'>
				<div class='col-md-4'>
						<div class='col-md-5'>
							<label>Qty</label>
						</div> 
						<div class='col-md-7' >
						<input type='number' class='form-control' id='total_qty'  required name='total_qty' onkeyup='HitungJumlahMinus()' placeholder='Qty'>
						</div>
				</div>
				<div class='col-md-4'>
						<div class='col-md-5'>
							<label>Berat/Qty</label>
						</div>
						<div class='col-md-7'>
						<input type='number' class='form-control' id='total_berat' value='".$stocklama[0]->weight."' readonly required name='total_berat' placeholder='Berat/Qty'>
						</div>
				</div>
				<div class='col-md-4'>
						<div class='col-md-5'>
							<label>Total Berat</label>
						</div>
						<div class='col-md-7'>
						<input type='number' class='form-control' id='total_jumlah_berat' readonly  required name='total_jumlah_berat' placeholder='Total Berat'>
						</div>
				</div>
				</div>
			</div>
			<div class='form-group row'>
				<div class='col-md-12'>
			<div class='col-md-12' id='form_gudang_mother'>
						<div class='col-md-2'>
							<label>Gudang Asal</label>
						</div> 
						<div class='col-md-10' hidden>
			<input type='text' class='form-control' id='id_gudang' value='".$stocklama[0]->id_gudang."' readonly required name='id_gudang' placeholder='Gudang Asal'>
						</div>
						<div class='col-md-10'>
			<input type='text' class='form-control' id='nama_gudang' value='".$gudanglama[0]->nama_gudang."' readonly required name='nama_gudang' placeholder='Gudang Asal'>
						</div>
				</div>
				</div>
			</div>";
	}
	public function PrintHeader(){
		ob_clean();
		ob_start();
        $this->auth->restrict($this->managePermission);
		$data['header']  = $this->db->query("SELECT * FROM stock_material ")->result();
		$data['sum'] = $this->db->query("SELECT SUM(weight) as weight FROM stock_material ")->result();
		$this->template->title('Data');
		$this->load->view('PrintHeader',$data);
		$html = ob_get_contents();
		require_once('./assets/html2pdf/html2pdf/html2pdf.class.php');
		$html2pdf = new HTML2PDF('L','A4','en',true,'UTF-8',array(0, 0, 0, 0));
		$html2pdf->pdf->SetDisplayMode('fullpage');
		$html2pdf->WriteHTML($html);
		ob_end_clean();
		$html2pdf->Output($id.'.pdf', 'I');
	}
	public function deleteInventory(){
		$this->auth->restrict($this->deletePermission);
		$id = $this->input->post('id');
		$data = [
			'deleted' 		=> '1',
			'deleted_by' 	=> $this->auth->user_id()
		];
		
		$this->db->trans_begin();
		$this->db->where('id_category3',$id)->update("ms_inventory_category3",$data);
		
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
		public function SavePlus()
    {
        $this->auth->restrict($this->addPermission);
		$post = $this->input->post();
		
		
		
		$code = $this->Inventory_4_model->generate_id();
		
		$material  = $post['id_material'];
		$qtydo     = $post['total_qty'];
		$surat     = $code;
		
		
		$adjustment = $post['adjustment'];
		$id_gudang = $post['id_gudang'];
		$carigudang = $this->db->query("SELECT * FROM ms_gudang WHERE id_gudang ='1' ")->result();
		$nama_gudang = $carigudang[0]->nama_gudang;
		
		$this->db->trans_begin();
		if($adjustment == 'PLUS'){
		$notr	   = 'ADJUSMENT PLUS';	
		
		$historical = [
							'id_transaksi'			=> $code,
							'id_material'			=> $post['id_material'],
							'nama_material'			=> $post['nama_material'],
							'id_bentuk'				=> $post['id_bentuk'],
							'nama_bentuk'			=> $post['nama_bentuk'],
							'adjustment'			=> $post['adjustment'],
							'id_stock'				=> $post['id_stock'],
							'lotno'					=> $post['lotno'],
							'note'					=> $post['note'],
							'length'				=> $post['length'],
							'width'					=> $post['width'],
							'thickness'				=> $post['thickness'],
							'total_qty'				=> $post['total_qty'],
							'total_berat'			=> $post['total_berat'],
							'total_jumlah_berat'	=> $post['total_jumlah_berat'],
							'id_gudang'				=> $post['id_gudang'],
							'nama_gudang'			=> $nama_gudang,
							'tanggal_transaksi'		=> date('Y-m-d'),
							'user'					=> $this->auth->user_id()
                            ];
		$this->db->insert('adjustment_stock',$historical);	
		
		$this->kartu_stok_in($material,$qtydo,$notr,$surat);
				
		}elseif($adjustment == 'MINUS'){
			
		$notr	   = 'ADJUSMENT MINUS';
		$historical = [
							'id_transaksi'			=> $code,
							'id_material'			=> $post['id_material'],
							'nama_material'			=> $post['nama_material'],
							'id_bentuk'				=> $post['id_bentuk'],
							'nama_bentuk'			=> $post['nama_bentuk'],
							'adjustment'			=> $post['adjustment'],
							'id_stock'				=> $post['id_stock'],
							'lotno'					=> $post['lotno'],
							'note'					=> $post['note'],
							'length'				=> $post['length'],
							'width'					=> $post['width'],
							'thickness'				=> $post['thickness'],
							'mother_qty'			=> $post['mother_qty'],
							'mother_berat'			=> $post['mother_berat'],
							'mother_jumlah_berat'	=> $post['mother_jumlah_berat'],
							'total_qty'				=> $post['total_qty'],
							'total_berat'			=> $post['total_berat'],
							'total_jumlah_berat'	=> $post['total_jumlah_berat'],
							'id_gudang'				=> $post['id_gudang'],
							'nama_gudang'			=> $nama_gudang,
							'tanggal_transaksi'		=> date('Y-m-d'),
							'user'					=> $this->auth->user_id()
                            ];
				  $this->db->insert('adjustment_stock',$historical);
				  
		$this->kartu_stok_out($material,$qtydo,$notr,$surat);
		
		}elseif($adjustment == 'MUTASI'){
		$id_gudang_baru		= $post['id_gudang_baru'];
		$carigudangbaru = $this->db->query("SELECT * FROM ms_gudang WHERE id_gudang ='".$id_gudang_baru."' ")->result();
		$nama_gudang_baru = $carigudangbaru[0]->nama_gudang;
		$historical = [
							'id_transaksi'			=> $code,
							'id_material'			=> $post['id_material'],
							'nama_material'			=> $post['nama_material'],
							'id_bentuk'				=> $post['id_bentuk'],
							'nama_bentuk'			=> $post['nama_bentuk'],
							'adjustment'			=> $post['adjustment'],
							'id_stock'				=> $post['id_stock'],
							'lotno'					=> $post['lotno'],
							'note'					=> $post['note'],
							'length'				=> $post['length'],
							'width'					=> $post['width'],
							'thickness'				=> $post['thickness'],
							'mother_qty'			=> $post['mother_qty'],
							'mother_berat'			=> $post['mother_berat'],
							'mother_jumlah_berat'	=> $post['mother_jumlah_berat'],
							'total_qty'				=> $post['total_qty'],
							'total_berat'			=> $post['total_berat'],
							'total_jumlah_berat'	=> $post['total_jumlah_berat'],
							'id_gudang'				=> $post['id_gudang'],
							'id_gudang_baru'		=> $post['id_gudang_baru'],
							'nama_gudang_baru'		=> $nama_gudang_baru,
							'nama_gudang'			=> $post['nama_gudang'],
							'tanggal_transaksi'		=> date('Y-m-d'),
							'user'					=> $this->auth->user_id()
                            ];
				  $this->db->insert('adjustment_stock',$historical);
		$mother_qty		= $post['mother_qty'];
		$total_qty		= $post['total_qty'];
		$id_stock		= $post['id_stock'];
		$total_berat	= $post['total_berat'];
		$hasil			= $mother_qty-$total_qty;
		$jtotalberat 	= $hasil*$total_berat;
		if($hasil < 1){
		$this->db->delete('stock_material', array('id_stock' => $id_stock));
				$data = [
							'id_category3'			=> $post['id_material'],
							'nama_material'			=> $post['nama_material'],
							'width'					=> $post['width'],
							'lotno'					=> $post['lotno'],
							'qty'					=> $post['total_qty'],
							'id_bentuk'				=> $post['id_bentuk'],
							'length'				=> $post['length'],
							'thickness'				=> $post['thickness'],
							'weight'				=> $post['total_berat'],
							'totalweight'			=> $post['total_jumlah_berat'],
							'aktif'					=> 'Y',
							'id_gudang'				=> $post['id_gudang_baru'],
							'created_on'			=> date('Y-m-d H:i:s'),
							'created_by'			=> $this->auth->user_id()
                            ];
               $this->db->insert('stock_material',$data);
		}else{	$data1 = [
							'id_category3'			=> $post['id_material'],
							'nama_material'			=> $post['nama_material'],
							'width'					=> $post['width'],
							'lotno'					=> $post['lotno'],
							'qty'					=> $hasil,
							'id_bentuk'				=> $post['id_bentuk'],
							'length'				=> $post['length'],
							'thickness'				=> $post['thickness'],
							'weight'				=> $post['total_berat'],
							'totalweight'			=> $jtotalberat,
							'aktif'					=> 'Y',
							'id_gudang'				=> $post['id_gudang'],
							'created_on'			=> date('Y-m-d H:i:s'),
							'created_by'			=> $this->auth->user_id()
                            ];
				$this->db->where('id_stock',$id_stock)->update("stock_material",$data1);
						$data = [
							'id_category3'			=> $post['id_material'],
							'nama_material'			=> $post['nama_material'],
							'width'					=> $post['width'],
							'lotno'					=> $post['lotno'],
							'qty'					=> $post['total_qty'],
							'id_bentuk'				=> $post['id_bentuk'],
							'length'				=> $post['length'],
							'thickness'				=> $post['thickness'],
							'weight'				=> $post['total_berat'],
							'totalweight'			=> $post['total_jumlah_berat'],
							'aktif'					=> 'Y',
							'id_gudang'				=> $post['id_gudang_baru'],
							'created_on'			=> date('Y-m-d H:i:s'),
							'created_by'			=> $this->auth->user_id()
                            ];
               $this->db->insert('stock_material',$data);
			};
		}
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$status	= array(
			  'pesan'		=>'Gagal Save Item. Thanks ...',
			  'code'	=> $id_inventory,
			  'status'	=> 0
			  
			);
		} else {
			$this->db->trans_commit();
			$status	= array(
			  'pesan'		=>'Success Save Item. invenThanks ...',
			  'code'	=> $id_inventory,
			  'status'	=> 1
			  
			);			
		}
		
  		echo json_encode($status);

    }
	public function saveEditInventory()
    {
        $this->auth->restrict($this->addPermission);
		$session = $this->session->userdata('app_session');
		$code = $this->Inventory_4_model->generate_id();
		$this->db->trans_begin();
		$id = $_POST['hd1']['1']['id_category3'];
		$id_bentuk = $_POST['hd1']['1']['id_bentuk'];
		$numb1 =0;
		foreach($_POST['hd1'] as $h1){
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
                     $this->db->where('id_category3',$id)->update("ms_inventory_category3",$header1);
			
		    }
					
		if(empty($_POST['data1'])){
		}else{
		$this->db->delete('child_inven_suplier', array('id_category3' => $id));
		$numb2 =0;
		
		foreach($_POST['data1'] as $d1){
		$numb2++;	   
              $data1 =  array(
			                    'id_category3'=>$id, 
								'id_suplier'=>$d1[id_supplier],
								'lead'=>$d1[lead],
								'minimum'=>$d1[minimum],
								'deleted' =>'0',
							    'created_on' => date('Y-m-d H:i:s'),
								'created_by' => $this->auth->user_id(),
                            );
            //Add Data
              $this->db->insert('child_inven_suplier',$data1);
			
		    }		
		}
		
		if(empty($_POST['compo'])){
		}else{
		$this->db->delete('child_inven_compotition', array('id_category3' => $id));
		$numb3 =0;
		foreach($_POST['compo'] as $c1){
		$numb3++;	   
              $comp =  array(
			                    'id_category3'=>$id, 
								'id_compotition'=>$c1[id_compotition],
								'nilai_compotition'=>$c1[jumlah_kandungan],
								'deleted' =>'0',
							    'created_on' => date('Y-m-d H:i:s'),
								'created_by' => $this->auth->user_id(),
                            );
            //Add Data
              $this->db->insert('child_inven_compotition',$comp);
			
		    }		
		}
		
		if(empty($_POST['dimens'])){
		}else{
		$this->db->delete('child_inven_dimensi', array('id_category3' => $id));
		$numb4 =0;
		foreach($_POST['dimens'] as $dm){
		$numb4++;	   
              $dms =  array(
			                    'id_category3'=>$id, 
								'id_dimensi'=>$dm[id_dimensi],
								'nilai_dimensi'=>$dm[nilai_dimensi],
								'deleted' =>'0',
							    'created_on' => date('Y-m-d H:i:s'),
								'created_by' => $this->auth->user_id(),
                            );
            //Add Data
              $this->db->insert('child_inven_dimensi',$dms);
			
		    }		
		}
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$status	= array(
			  'pesan'		=>'Gagal Save Item. Thanks ...',
			  'code' => $id_bentuk,
			  'status'	=> 0
			);
		} else {
			$this->db->trans_commit();
			$status	= array(
			  'pesan'		=>'Success Save Item. invenThanks ...',
			  'code' => $id_bentuk,
			  'status'	=> 1
			);			
		}
		
  		echo json_encode($status);

    }
		function get_compotition_new()
    {
        $inventory_2=$_GET['inventory_2'];
        $comp=$this->Inventory_4_model->compotition($inventory_2);
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
        $id_bentuk=$_GET['id_bentuk'];
        $dim=$this->Inventory_4_model->bentuk($id_bentuk);
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
        $inventory_2=$_GET['inventory_2'];
        $comp=$this->Inventory_4_model->compotition_edit($inventory_2);
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
        $id_bentuk=$_GET['id_bentuk'];
        $dim=$this->Inventory_4_model->bentuk_edit($id_bentuk);
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
		$code = $this->Inventory_4_model->generate_id();
		$this->db->trans_begin();
		$id =$_POST['hd1']['1']['id_category3'];
		$numb1 =0;
		//$head = $_POST['hd1'];
		foreach($_POST['hd1'] as $h1){
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
              $this->db->where('id_category3',$id)->update("ms_inventory_category3",$data);
			
		    }	
		$this->db->delete('child_inven_suplier', array('id_category3' => $id));
		if(empty($_POST['data1'])){
		}else{
		$numb2 =0;
		foreach($_POST['data1'] as $d1){
		$numb2++;	   
              $data1 =  array(
			                    'id_category3'=>$code, 
								'id_suplier'=>$d1[id_supplier],
								'lead'=>$d1[lead],
								'minimum'=>$d1[minimum],
								'deleted' =>'0',
							    'created_on' => date('Y-m-d H:i:s'),
								'created_by' => $this->auth->user_id(),
                            );
            //Add Data
              $this->db->insert('child_inven_suplier',$data1);
			
		    }		
		}	
		if(empty($_POST['compo'])){
		}else{
		$numb3 =0;
		foreach($_POST['compo'] as $c1){
		$numb3++;	   
              $comp =  array(
			                    'id_category3'=>$code, 
								'id_compotition'=>$c1[id_compotition],
								'nilai_compotition'=>$c1[jumlah_kandungan],
								'deleted' =>'0',
							    'created_on' => date('Y-m-d H:i:s'),
								'created_by' => $this->auth->user_id(),
                            );
            //Add Data
              $this->db->insert('child_inven_compotition',$comp);
			
		    }		
		}
		if(empty($_POST['dimens'])){
		}else{
		$numb4 =0;
		foreach($_POST['dimens'] as $dm){
		$numb4++;	   
              $dms =  array(
			                    'id_category3'=>$code, 
								'id_dimensi'=>$dm[id_dimensi],
								'nilai_dimensi'=>$dm[nilai_dimensi],
								'deleted' =>'0',
							    'created_on' => date('Y-m-d H:i:s'),
								'created_by' => $this->auth->user_id(),
                            );
            //Add Data
              $this->db->insert('child_inven_dimensi',$dms);
			
		    }		
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
	public function saveEditInventoryOld()
    {
        $this->auth->restrict($this->addPermission);
		$session = $this->session->userdata('app_session');
		$code = $this->Inventory_4_model->generate_id();
		$this->db->trans_begin();
		$id =$_POST['hd1']['1']['id_category3'];
		$numb1 =0;
		//$head = $_POST['hd1'];
		foreach($_POST['hd1'] as $h1){
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
              $this->db->where('id_category3',$id)->update("ms_inventory_category3",$data);
			
		    }		
		if(empty($_POST['data1'])){
		}else{
		$numb2 =0;
		foreach($_POST['data1'] as $d1){
		$numb2++;	   
              $data1 =  array(
			                    'id_category3'=>$id, 
								'id_suplier'=>$d1[id_supplier],
								'lead'=>$d1[lead],
								'minimum'=>$d1[minimum],
								'deleted' =>'0',
							    'created_on' => date('Y-m-d H:i:s'),
								'created_by' => $this->auth->user_id(),
                            );
            //Add Data
              $this->db->insert('child_inven_suplier',$data1);
			
		    }		
		}	
		if(empty($_POST['compo'])){
		}else{
		$numb3 =0;
		foreach($_POST['compo'] as $c1){
		$numb3++;	   
              $comp =  array(
			                    'id_category3'=>$id, 
								'id_compotition'=>$c1[id_compotition],
								'nilai_compotition'=>$c1[jumlah_kandungan],
								'deleted' =>'0',
							    'created_on' => date('Y-m-d H:i:s'),
								'created_by' => $this->auth->user_id(),
                            );
            //Add Data
              $this->db->insert('child_inven_compotition',$comp);
			
		    }		
		}
		if(empty($_POST['dimens'])){
		}else{
		$numb4 =0;
		foreach($_POST['dimens'] as $dm){
		$numb4++;	   
              $dms =  array(
			                    'id_category3'=>$id, 
								'id_dimensi'=>$dm[id_dimensi],
								'nilai_dimensi'=>$dm[nilai_dimensi],
								'deleted' =>'0',
							    'created_on' => date('Y-m-d H:i:s'),
								'created_by' => $this->auth->user_id(),
                            );
            //Add Data
              $this->db->insert('child_inven_dimensi',$dms);
			
		    }		
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
		function get_compotition()
    {
        $inventory_2=$_GET['inventory_2'];
        $comp=$this->Inventory_4_model->compotition($inventory_2);
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
	
	
	

	public function kartu_stok_out($material,$qtyso,$notr,$surat)
	{
		
		$mat = $this->db->query("SELECT * FROM stock_material WHERE id_category3='$material' ")->row();

		
        $qty   = (int) $mat->qty      - (int) $qtyso;
		//$book  = (int) $mat->qty_book - (int) $qtyso;
		$free  = (int)$qty - (int) $mat->qty_book;;
		$book2  =$mat->qty_book;

		// print_r($free);
		// exit;
		$kartu = [
			'id_category3'		    => $material,
			'qty'		            => $mat->qty,
			'qty_book'			    => $mat->qty_book,
			'qty_free'		        => $mat->qty_free,
			'transaksi'			    => 'adjustment minus',
			'tgl_transaksi'			=> date('Y-m-d'),
			'no_transaksi'			=> $notr,
			'id_gudang'             => $mat->id_gudang,
			'created_on'			=> date('Y-m-d H:i:s'),
			'created_by'			=> $this->auth->user_id(),
			'qty_transaksi'         => $qtyso,
			'qty_akhir'		        => $qty,
			'qty_book_akhir'	    => $mat->qty_book,
			'qty_free_akhir'		=> $free,	
			'status_transaksi'		=> 'out',		
			'no_surat'		        => $surat,					
			];

		$this->db->insert('kartu_stok',$kartu);	   

		$this->db->query("UPDATE stock_material SET qty=qty-$qtyso, qty_free=$free  WHERE id_category3='$material'");
	}


	public function kartu_stok_in($material,$qtyso,$notr,$surat)
	{
		
		$mat = $this->db->query("SELECT * FROM stock_material WHERE id_category3='$material' ")->row();
		
		
		$qty   = (int) $mat->qty + (int)$qtyso;;
		$book  = (int) $mat->qty_book;
		$free  = (int)$qty - (int) $mat->qty_book;;
		$book2  =$mat->qty_book;

		// print_r($free);
		// exit;
		$kartu = [
			'id_category3'		    => $material, 
			'qty'		            => $mat->qty,
			'qty_book'			    => $mat->qty_book,
			'qty_free'		        => $mat->qty_free,
			'transaksi'			    => 'adjustment plus',
			'tgl_transaksi'			=> date('Y-m-d'),
			'no_transaksi'			=> $notr,
			'id_gudang'             => $mat->id_gudang,
			'created_on'			=> date('Y-m-d H:i:s'),
			'created_by'			=> $this->auth->user_id(),
			'qty_transaksi'         => $qtyso,
			'qty_akhir'		        => $qty,
			'qty_book_akhir'	    => $mat->qty_book,
			'qty_free_akhir'		=> $free,	
			'status_transaksi'		=> 'in',
			'no_surat'		        => $surat,				
			];

		$this->db->insert('kartu_stok',$kartu);	   

		$this->db->query("UPDATE stock_material SET qty=qty+$qtyso, qty_free=$free  WHERE id_category3='$material'");
	}


	
}
