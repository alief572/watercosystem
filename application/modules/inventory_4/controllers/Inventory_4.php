<?php

if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

/*
 * @author Harboens
 * @copyright Copyright (c) 2022, Harboens
 *
 * This is controller for Master Deskripsi Produks
 */

class Inventory_4 extends Admin_Controller
{
	//Permission
	protected $viewPermission 	= 'Level_4.View';
	protected $addPermission  	= 'Level_4.Add';
	protected $managePermission = 'Level_4.Manage';
	protected $deletePermission = 'Level_4.Delete';

	public function __construct()
	{
		parent::__construct();

		$this->load->library(array('Mpdf', 'upload', 'Image_lib'));
		$this->load->model(array(
			'Inventory_4/Inventory_4_model',
			'Aktifitas/aktifitas_model',
		));
		$this->template->title('Manage Data Supplier');
		$this->template->page_icon('fa fa-building-o');

		date_default_timezone_set('Asia/Bangkok');
	}
	// public function index()
	// {
	// $this->auth->restrict($this->viewPermission);
	// $session = $this->session->userdata('app_session');
	// $this->template->page_icon('fa fa-users');
	// $deleted = '0';
	// $data = $this->Inventory_4_model->get_data('ms_bentuk','deleted',$deleted);
	// $this->template->set('results', $data);
	// $this->template->title('Material');
	// $this->template->render('index');
	// }
	public function index()
	{
		$id_bentuk = $this->uri->segment(3);
		$this->auth->restrict($this->viewPermission);
		$session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
		$deleted = '0';
		$data = $this->Inventory_4_model->get_data_category3();
		$this->template->set('results', $data);
		$this->template->title('Produk');
		$this->template->render('list');
	}
	public function editInventory($id)
	{
		$this->auth->restrict($this->viewPermission);
		$session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$deleted = '0';
		$inven = $this->Inventory_4_model->getedit($id);

		$all   = $this->db->query("SELECT * FROM ms_inventory_category3 WHERE id='$id'")->row();

		$alloy = $this->db->query("SELECT nama FROM ms_inventory_category2 WHERE id_category2='$all->id_category2'")->row();
		$komposisiold = $this->Inventory_4_model->get_data('child_inven_compotition', 'id_category3', $id);
		$komposisi = $this->Inventory_4_model->kompos($id);
		$dimensiold = $this->Inventory_4_model->get_data('child_inven_dimensi', 'id_category3', $id);
		$dimensi = $this->Inventory_4_model->dimensy($id);
		$supl = $this->Inventory_4_model->supl($id);
		$inventory_1 = $this->Inventory_4_model->get_data('ms_inventory_type', 'deleted', $deleted);
		$inventory_2 = $this->Inventory_4_model->get_data('ms_inventory_category1', 'id_type', $all->id_type);
		$inventory_3 = $this->db->query("SELECT * FROM ms_inventory_category2 WHERE id_category1='$all->id_category1' AND id_type='$all->id_type'")->result();
		$maker = $this->Inventory_4_model->get_data('negara');
		$id_bentuk = $this->Inventory_4_model->get_data('ms_bentuk');
		$id_supplier = $this->Inventory_4_model->get_data('master_supplier');
		$id_surface = $this->Inventory_4_model->get_data('ms_surface');
		$dt_suplier = $this->Inventory_4_model->get_data('child_inven_suplier', 'id_category3', $id);



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
			'alloy' => $alloy->nama,
			'id_surface' => $id_surface,
			'id_supplier' => $id_supplier,
			'dt_suplier' => $dt_suplier
		];
		$this->template->set('results', $data);
		$this->template->title('Add Inventory');
		//        $this->template->render('edit_inventory');
		$this->template->render('form_inventory');
	}
	public function copyInventory($id)
	{
		$this->auth->restrict($this->viewPermission);
		$session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$deleted = '0';
		$inven = $this->Inventory_4_model->getedit($id);
		$komposisiold = $this->Inventory_4_model->get_data('child_inven_compotition', 'id_category3', $id);
		$komposisi = $this->Inventory_4_model->kompos($id);
		$dimensiold = $this->Inventory_4_model->get_data('child_inven_dimensi', 'id_category3', $id);
		$dimensi = $this->Inventory_4_model->dimensy($id);
		$supl = $this->Inventory_4_model->supl($id);
		$inventory_1 = $this->Inventory_4_model->get_data('ms_inventory_type', 'deleted', $deleted);
		$inventory_2 = $this->Inventory_4_model->get_data('ms_inventory_category1', 'deleted', $deleted);
		$inventory_3 = $this->Inventory_4_model->get_data('ms_inventory_category2', 'deleted', $deleted);
		$maker = $this->Inventory_4_model->get_data('negara');
		$id_bentuk = $this->Inventory_4_model->get_data('ms_bentuk');
		$id_supplier = $this->Inventory_4_model->get_data('master_supplier');
		$id_surface = $this->Inventory_4_model->get_data('ms_surface');
		$dt_suplier = $this->Inventory_4_model->get_data('child_inven_suplier', 'id_category3', $id);
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
		$komposisiold = $this->Inventory_4_model->get_data('child_inven_compotition', 'id_category3', $id);
		$komposisi = $this->Inventory_4_model->kompos($id);
		$dimensiold = $this->Inventory_4_model->get_data('child_inven_dimensi', 'id_category3', $id);
		$dimensi = $this->Inventory_4_model->dimensy($id);
		$supl = $this->Inventory_4_model->supl($id);
		$inventory_1 = $this->Inventory_4_model->get_data('ms_inventory_type', 'deleted', $deleted);
		$inventory_2 = $this->Inventory_4_model->get_data('ms_inventory_category1', 'deleted', $deleted);
		$inventory_3 = $this->Inventory_4_model->get_data('ms_inventory_category2', 'deleted', $deleted);
		$maker = $this->Inventory_4_model->get_data('negara');
		$id_bentuk = $this->Inventory_4_model->get_data('ms_bentuk');
		$id_supplier = $this->Inventory_4_model->get_data('master_supplier');
		$id_surface = $this->Inventory_4_model->get_data('ms_surface');
		$dt_suplier = $this->Inventory_4_model->get_data('child_inven_suplier', 'id_category3', $id);
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
		//        $this->template->render('view_inventory');
		$this->template->render('form_inventory2');
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


	public function addInventory()
	{
		$id_data 	= '1';
		$this->auth->restrict($this->viewPermission);
		$session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$deleted = '0';
		$inventory_1 = $this->Inventory_4_model->get_data('ms_inventory_type', 'deleted', $deleted);
		$maker = $this->Inventory_4_model->get_data('negara');
		$dimensi = $this->Inventory_4_model->get_data('ms_dimensi', 'id_bentuk', $id_data);
		$id_bentuk = $this->Inventory_4_model->get_data('ms_bentuk', 'id_bentuk', $id_data);
		$id_supplier = $this->Inventory_4_model->get_data('master_supplier', 'deleted', $deleted);
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
		//        $this->template->render('add_inventory');
		$this->template->render('form_inventory');
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

	public function deleteInventory()
	{
		$this->auth->restrict($this->deletePermission);
		$id = $this->input->post('id');
		$data = [
			'deleted' 		=> '1',
			'deleted_by' 	=> $this->auth->user_id()
		];

		$this->db->trans_begin();
		$this->db->where('id', $id)->update("ms_inventory_category3", $data);

		$stock = $this->db->query("SELECT id_category3 FROM stock_material WHERE id_stock = $id")->row();
		$kategori = $stock->id_category3;


		$datastock = [
			'aktif' 		=> 'N',
			'deleted' 		=> '1',
			'deleted_by' 	=> $this->auth->user_id()
		];

		$this->db->where('id_category3', $kategori)->update("stock_material", $datastock);


		$costbook = $this->db->query("SELECT * FROM ms_costbook WHERE id_category3='" . $kategori . "'")->row();

		$header1 =  array(
			'id_costbook'	 		=> $costbook->id_costbook,
			'id_category3'		    => $costbook->id_category3,
			'nilai_costbook'		=> $costbook->nilai_costbook,
			'created_by'		    => $costbook->created_by,
			'created_on'		    => $costbook->created_on,
			'modified_by'		    => $this->auth->user_id(),
			'modified_on'		    => date('Y-m-d H:i:s')
		);
		//Add Data
		$this->db->insert('ms_costbook_history', $header1);

		// $this->db_query("DELETE FROM ms_costbook WHERE id_category3=$kategori")->row();



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
	function get_inven2()
	{
		$inventory_1 = $_GET['inventory_1'];
		$data = $this->Inventory_4_model->level_2($inventory_1);
		echo "<select id='inventory_2' name='hd1[1][inventory_2]' class='form-control onchange='get_inv3()'  input-sm select2'>";
		echo "<option value=''>--Pilih--</option>";
		foreach ($data as $key => $st) :
			echo "<option value='$st->id_category1' set_select('inventory_2', $st->id_category1, isset($data->id_category1) && $data->id_category1 == $st->id_category1)>$st->nama
                    </option>";
		endforeach;
		echo "</select>";
	}

	function get_namainven2()
	{
		$inventory_1 = $_GET['inventory_1'];

		$data = $this->db->query("SELECT * from ms_inventory_category2 WHERE id_category2='$inventory_1'")->row();

		echo "$data->nama";
	}
	function get_inven3()
	{
		$id_type = $_GET['id_type'];
		$inventory_2 = $_GET['inventory_2'];
		$data = $this->Inventory_4_model->level_3($id_type, $inventory_2);

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

	function get_inven4()
	{
		$inventory_3 = $_GET['inventory_3'];
		$data = $this->Inventory_4_model->level_4($inventory_3);

		// print_r($data);
		// exit();
		echo "<select id='inventory_4' name='hd1[1][inventory_4]' class='form-control input-sm select2'>";
		echo "<option value=''>--Pilih--</option>";
		foreach ($data as $key => $st) :
			echo "<option value='$st->id_category3' set_select('inventory_4', $st->id_category3, isset($data->id_category3) && $data->id_category3 == $st->id_category3)>$st->nama
                    </option>";
		endforeach;
		echo "</select>";
	}
	public function saveNewInventory()
	{
		$this->auth->restrict($this->addPermission);
		$session = $this->session->userdata('app_session');
		$code = $this->Inventory_4_model->generate_id();
		$this->db->trans_begin();
		$id_bentuk = $_POST['hd1']['1']['id_bentuk'];
		$numb1 = 0;
		//$head = $_POST['hd1'];
		foreach ($_POST['hd1'] as $h1) {
			$numb1++;
			$id_category2	= $h1[inventory_3];
			$carialloy	= $this->db->query("SELECT * FROM ms_inventory_category2 WHERE id_category2 = '$id_category2' ")->result();
			$alloy = $carialloy[0]->nama;
			$id_bentuk	= $h1[id_bentuk];
			$id_supplier  = $h1[id_bentuk];
			$caribentuk	= $this->db->query("SELECT * FROM ms_bentuk WHERE id_bentuk = '$id_bentuk' ")->result();
			$bentuk = $caribentuk[0]->nm_bentuk;



			foreach ($_POST['data1'] as $sp) {
				$id_supplier = $sp[id_supplier];
			}


			$carisupplier	= $this->db->query("SELECT * FROM master_supplier WHERE id_suplier = '$id_supplier' ")->result();
			$supplier		= $carisupplier[0]->name_suplier;



			$header1 =  array(
				'id_category3'	 		=> $code,
				'id_type'		        => $h1[inventory_1],
				'id_category1'		    => $h1[inventory_2],
				'id_category2'		    => $h1[inventory_3],
				'spek'		        	=> $h1[nm_inventory],
				'maker'		        	=> $supplier,
				'density'		        => $h1[density],
				'hardness'		        => $h1[hardness],
				'id_bentuk'		        => $h1[id_bentuk],
				'id_surface'		    => $h1[id_surface],
				'mountly_forecast'		=> $h1[mountly_forecast],
				'safety_stock'		    => $h1[safety_stock],
				'order_point'		    => $h1[order_point],
				'maksimum'		    	=> $h1[maksimum],
				'aktif'					=> 'aktif',
				'created_on'			=> date('Y-m-d H:i:s'),
				'created_by'			=> $this->auth->user_id(),
				'deleted'				=> '0',
				'thickness'				=> $_POST['dimens']['1']['nilai_dimensi'],
				'nama'		        	=> $h1[nama],
				'alloy'		        	=> $alloy,
				'negara'		        => $h1[maker],
			);
			//Add Data
			$this->db->insert('ms_inventory_category3', $header1);


			$bookp =  array(
				'id_category3'	 		=> $code,
				'nilai_costbook'		 => 0,
				'created_on'			=> date('Y-m-d H:i:s'),
				'created_by'			=> $this->auth->user_id()

			);
			//Add Data
			$this->db->insert('ms_costbook', $bookp);

			//Add Data

			$stok =  array(
				'id_category3'	 	=> $code,
				'qty'		        => 0,
				'qty_book'		    => 0,
				'qty_free'		    => 0,
				'aktif'		        => 'Y',
				'id_gudang'		    => 1,
				'created_on'		=> date('Y-m-d H:i:s'),
				'created_by'		=> $this->auth->user_id()

			);
			//Add Data
			$this->db->insert('stock_material', $stok);
		}

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
	public function saveInventory()
	{
		$this->auth->restrict($this->addPermission);
		$session = $this->session->userdata('app_session');
		$this->db->trans_begin();
		$id = $this->input->post("id");
		$id_category3 = $this->input->post("id_category3");
		$id_type = $this->input->post("id_type");
		$id_category1 = $this->input->post("id_category1");
		$id_category2 = $this->input->post("id_category2");
		$nama = $this->input->post("nama");
		$maker = $this->input->post("maker");
		$status = $this->input->post("status");
		$kode_barang = $this->input->post("kode_barang");
		$kode_mas = $this->input->post("kode_mas");
		if ($id != '') {
			$header1 =  array(
				'id_type'			=> $id_type,
				'id_category1'		=> $id_category1,
				'id_category2'		=> $id_category2,
				'id_category3'		=> $id_category3,
				'maker'				=> $maker,
				'nama'				=> $nama,
				'kode_barang'		=> $kode_barang,
				'kode_mas'		    => $kode_mas,
				'aktif'				=> $status,
				'modified_on'		=> date('Y-m-d H:i:s'),
				'modified_by'		=> $this->auth->user_id(),
			);
			$this->db->where('id', $id)->update("ms_inventory_category3", $header1);

			$pricelist =  array(
				'id_type'			=> $id_type,
				'id_category1'		=> $id_category1,
				'id_category2'		=> $id_category2,
			);
			$this->db->where('id_category3', $id_category3)->update("ms_product_pricelist", $pricelist);
		} else {
			$code	= $this->db->query("SELECT id_category3 FROM ms_inventory_category3 order by id_category3 desc limit 1 ")->row();
			$id_category3 = 'LVL4' . (str_replace("LVL4", "", $code->id_category3) + 1);
			$header1 =  array(
				'id_type'			=> $id_type,
				'id_category1'		=> $id_category1,
				'id_category2'		=> $id_category2,
				'id_category3'		=> $id_category3,
				'maker'				=> $maker,
				'nama'				=> $nama,
				'kode_barang'		=> $kode_barang,
				'kode_mas'		    => $kode_mas,
				'aktif'				=> $status,
				'created_on'		=> date('Y-m-d H:i:s'),
				'created_by'		=> $this->auth->user_id(),
				'deleted'			=> '0',
			);
			$this->db->insert('ms_inventory_category3', $header1);

			$stok =  array(
				'id_category3'	 	=> $id_category3,
				'qty'		        => 0,
				'qty_book'		    => 0,
				'qty_free'		    => 0,
				'aktif'		        => 'Y',
				'id_gudang'		    => 1,
				'created_on'		=> date('Y-m-d H:i:s'),
				'created_by'		=> $this->auth->user_id()

			);
			//Add Data
			$this->db->insert('stock_material', $stok);
		}

		$costbook =  array(
			'id_category3'	 	=> $id_category3,
			'nilai_costbook'    => 0,
			'created_on'		=> date('Y-m-d H:i:s'),
			'created_by'		=> $this->auth->user_id()

		);
		//Add Data
		$this->db->insert('ms_costbook', $costbook);

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$status	= array(
				'pesan'		=> 'Gagal Save Product. Thanks ...',
				'code' => $id_bentuk,
				'status'	=> 0
			);
		} else {
			$this->db->trans_commit();
			$status	= array(
				'pesan'		=> 'Success Save Product. Thanks ...',
				'code' => $id_bentuk,
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
		$numb1 = 0;
		foreach ($_POST['hd1'] as $h1) {
			$numb1++;
			$id_category2	= $h1[inventory_3];
			$carialloy	= $this->db->query("SELECT * FROM ms_inventory_category2 WHERE id_category2 = '$id_category2' ")->result();

			$alloy = $carialloy[0]->nama;
			$id_bentuk	= $h1[id_bentuk];
			$caribentuk	= $this->db->query("SELECT * FROM ms_bentuk WHERE id_bentuk = '$id_bentuk' ")->result();
			$bentuk = $caribentuk[0]->nm_bentuk;
			$header1 =  array(
				'id_type'		        => $h1[inventory_1],
				'id_category1'		    => $h1[inventory_2],
				'id_category2'		    => $h1[inventory_3],
				'spek'		        	=> $h1[nm_inventory],
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
				'deleted'			=> '0',
				'thickness'				=> $_POST['dimens']['1']['nilai_dimensi'],
				'nama'		        	=> $h1[nama],
				'alloy'		        	=> $alloy,
			);
			$this->db->where('id_category3', $id)->update("ms_inventory_category3", $header1);
			$bookp =  array(
				'alloy'		        	=> $alloy,
				'bentuk'		        	=> $bentuk,
				'material'		        => $h1[nm_inventory],
				'hardness'		        => $h1[hardness],
				'thickness'				=> $_POST['dimens']['1']['nilai_dimensi']

			);
			//Add Data
			$this->db->where('id_category3', $id)->update("ms_bookprice_material", $bookp);
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
		$comp = $this->Inventory_4_model->compotition($inventory_2);
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
		$dim = $this->Inventory_4_model->bentuk($id_bentuk);
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
		$comp = $this->Inventory_4_model->compotition_edit($inventory_2);
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
		$dim = $this->Inventory_4_model->bentuk_edit($id_bentuk);
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
		$code = $this->Inventory_4_model->generate_id();
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
		$comp = $this->Inventory_4_model->compotition($inventory_2);
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



	public function update_material()
	{
		$sql = $this->db->query("SELECT * FROM ms_inventory_new")->result();



		// print_r($sql);
		// exit;

		$n = 0;

		foreach ($sql as $val => $valx) {

			$n++;




			$this->db->query("UPDATE ms_inventory_category33 
							SET nama='$valx->nama',maker='$valx->maker',density='$valx->density',hardness='$valx->hardness',thickness='$valx->thickness',spek='$valx->spek',alloy='$valx->alloy'
							WHERE id_category3='$valx->id_category3'");

			echo "$n";

			//$this->db->where('id', $valx->id )->update("ms_inventory_category32",$data);

		}
	}


	function get_surface()
	{
		$idsurface = $_GET['idsurface'];
		$surface = $this->db->query("SELECT * FROM ms_surface WHERE id_surface='$idsurface'")->row();
		echo "$surface->nm_surface";
	}
}
