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

class Adjustmentstockmulti extends Admin_Controller
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
		$this->load->model(array(
			'Adjustmentstockmulti/Inventory_4_model',
			'Aktifitas/aktifitas_model',
		));
		$this->template->title('Manage Data Supplier');
		$this->template->page_icon('fa fa-building-o');

		date_default_timezone_set('Asia/Bangkok');
	}
	public function index_display()
	{
		$id_bentuk = $this->uri->segment(3);
		$this->auth->restrict($this->viewPermission);
		$session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
		$deleted = '0';
		$stok		 = $this->Inventory_4_model->get_data_display();
		$history	= $this->db->query("SELECT * FROM adjustment_stock WHERE id_gudang=? OR id_gudang_baru=?", array('2','2'))->result();
		$data = [
			'stok' => $stok,
			'history' => $history,
		];
		$this->template->set('results', $data);
		$this->template->title('Adjustment Stock Display');
		$this->template->render('index_display');
	}

	public function index_exdisplay()
	{
		$id_bentuk = $this->uri->segment(3);
		$this->auth->restrict($this->viewPermission);
		$session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
		$deleted = '0';
		$stok		 = $this->Inventory_4_model->get_data_exdisplay();
		$history	= $this->db->query("SELECT * FROM adjustment_stock WHERE id_gudang=? OR id_gudang_baru=?", array('3','3'))->result();
		$data = [
			'stok' => $stok,
			'history' => $history,
		];
		$this->template->set('results', $data);
		$this->template->title('Adjustment Stock Exdisplay');
		$this->template->render('index_exdisplay');
	}

	public function index_retur()
	{
		$id_bentuk = $this->uri->segment(3);
		$this->auth->restrict($this->viewPermission);
		$session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
		$deleted = '0';
		$stok		 = $this->Inventory_4_model->get_data_retur();
		$history	= $this->db->query("SELECT * FROM adjustment_stock WHERE id_gudang=? OR id_gudang_baru=?", array('4','4'))->result();
		$data = [
			'stok' => $stok,
			'history' => $history,
		];
		$this->template->set('results', $data);
		$this->template->title('Adjustment Stock Retur');
		$this->template->render('index_retur');
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
		$this->auth->restrict($this->viewPermission);
		$id_stock = $this->uri->segment(4);
		$id_gudang = $this->uri->segment(5);
		$inventory = $this->Inventory_4_model->GetMaterial($id);
		$table = ($id_gudang === '1' ? 'stock_material' : 'stock_material_multigudang');
		$stock = $this->db->get_where($table, array('id_stock'=>$id_stock, 'id_category3'=>$id, 'id_gudang'=>$id_gudang))->row();
		if (count($inventory) !== 1 || !$stock || ($stock->deleted ?? 0) != 0 || ($stock->aktif ?? '') === 'N') {
			show_404();
			return;
		}
		$this->load->library('Stock_booking');
		$data = array('inventory_3'=>$inventory, 'idstock'=>$id_stock, 'idgudang'=>$id_gudang, 'stock'=>$stock, 'request_key'=>$this->stock_booking->adjustmentToken());
		$this->template->set('results', $data);
		$this->template->title('Adjustment Stock');
		$this->template->render('Adjust');
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
	public function LotNumber()
	{
		$this->auth->restrict($this->viewPermission);
		$warehouse = ($this->input->get_post('gudang') ?? $this->input->get_post('id_gudang'));
		$material = $this->input->get_post('id_material');
		$type = $this->input->get_post('adjus');
		if (!is_string($warehouse) || !ctype_digit($warehouse) || !is_string($material) || !in_array($type, array('PLUS','MINUS','MUTASI'), true)) {
			show_error('Parameter stok tidak valid.', 400);
			return;
		}
		if ($type === 'PLUS') { echo "<input type='text' class='form-control' id='lotno' name='lotno'>"; return; }
		$table = $warehouse === '1' ? 'stock_material' : 'stock_material_multigudang';
		$stocks = $this->db->query("SELECT id_stock,lotno FROM $table WHERE id_category3=? AND id_gudang=? AND COALESCE(deleted,0)=0 AND COALESCE(aktif,'Y')!='N'", array($material,$warehouse))->result();
		echo "<select class='form-control' id='id_stock' name='id_stock'><option value=''>--Pilih--</option>";
		foreach ($stocks as $stock) { echo '<option value="' . html_escape($stock->id_stock) . '">' . html_escape($stock->lotno ?? '') . '</option>'; }
		echo '</select>';
	}

	public function HitungJumlah()
	{
		$this->auth->restrict($this->viewPermission);
		$qty = $this->input->get('total_qty');
		$weight = $this->input->get('total_berat');
		if (!is_scalar($qty) || !is_scalar($weight) || !is_numeric($qty) || !is_numeric($weight)
			|| $qty < 0 || $weight < 0 || !is_finite((float)$qty * (float)$weight)) {
			show_error('Jumlah atau berat tidak valid.', 400);
			return;
		}
		echo (float)$qty * (float)$weight;
	}

	public function FormPlus()
	{
		$this->auth->restrict($this->viewPermission);
		echo "<label for='total_qty'>Qty Adjustment</label><input type='number' class='form-control' id='total_qty' name='total_qty' min='1' max='2147483647' step='1' required>";
	}

	public function FormMinus()
	{
		$this->FormPlus();
	}

	public function FormMutasi()
	{
		$this->auth->restrict($this->viewPermission);
		$warehouse = ($this->input->get_post('gudang') ?? $this->input->get_post('id_gudang'));
		$id = $this->input->get_post('id_stock');
		if (!is_string($warehouse) || !ctype_digit($warehouse) || !is_string($id) || !ctype_digit($id)) {
			show_error('Parameter stok tidak valid.', 400);
			return;
		}
		$table = $warehouse === '1' ? 'stock_material' : 'stock_material_multigudang';
		$stock = $this->db->query("SELECT * FROM $table WHERE id_stock=? AND id_gudang=? AND COALESCE(deleted,0)=0", array($id,$warehouse))->row();
		if (!$stock || ($stock->aktif ?? '') === 'N') { show_404(); return; }
		echo '<p>Qty Free: ' . html_escape($stock->qty_free) . '</p>';
		echo '<input type="hidden" name="id_gudang" value="' . html_escape($warehouse) . '">';
		$this->FormPlus();
		echo "<label for='id_gudang_baru'>Gudang Tujuan</label><select class='form-control' id='id_gudang_baru' name='id_gudang_baru' required><option value=''>--Pilih--</option>";
		foreach ($this->db->where('id_gudang !=', $warehouse)->get('ms_gudang')->result() as $destination) {
			echo '<option value="' . html_escape($destination->id_gudang) . '">' . html_escape($destination->nama_gudang) . '</option>';
		}
		echo '</select>';
	}

	public function AmbilDataMutasi()
	{
		$this->FormMutasi();
	}

	public function AmbilDataMinus()
	{
		$this->FormMinus();
	}

	public function PrintHeader()
	{
		if (ob_get_level() > 0) {
			ob_clean();
		}
		ob_start();
		$this->auth->restrict($this->managePermission);
		$data['header']  = $this->db->query("SELECT * FROM stock_material ")->result();
		$data['sum'] = $this->db->query("SELECT SUM(weight) as weight FROM stock_material ")->result();
		$this->template->title('Data');
		$this->load->view('PrintHeader', $data);
		$html = ob_get_contents();
		require_once('./assets/html2pdf/html2pdf/html2pdf.class.php');
		$html2pdf = new HTML2PDF('L', 'A4', 'en', true, 'UTF-8', array(0, 0, 0, 0));
		$html2pdf->pdf->SetDisplayMode('fullpage');
		$html2pdf->WriteHTML($html);
		ob_end_clean();
		$html2pdf->Output($id . '.pdf', 'I');
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
		$this->db->where('id_category3', $id)->update("ms_inventory_category3", $data);

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
	public function SavePlus()
	{
		$this->auth->restrict($this->managePermission);
		$this->auth->restrict($this->addPermission);
		$this->output->set_content_type('application/json');
		if ($this->input->method(true) !== 'POST') {
			echo json_encode(array('status'=>0, 'code'=>'', 'pesan'=>'Gunakan POST untuk menyimpan adjustment.'));
			return;
		}
		$this->load->library('Stock_booking');
		$this->stock_booking->document(function () {
			$code = $this->Inventory_4_model->generate_id();
			$this->stock_booking->adjustment($this->input->post(), $code, false);
			echo json_encode(array('status'=>1, 'code'=>$code, 'pesan'=>'Adjustment stok berhasil disimpan.'));
		});
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

	protected function kartu_stok_out($material, $qtyso, $notr, $surat, $gudang)
	{
		$this->stock_booking->changeActual($material, $qtyso, $notr, $surat, 'out', $gudang, 'stock_material_multigudang');
	}

	protected function kartu_stok_out_penjualan($material, $qtyso, $notr, $surat, $gudang)
	{
		$this->stock_booking->changeActual($material, $qtyso, $notr, $surat, 'out', $gudang, 'stock_material');
	}



	protected function kartu_stok_in($material, $qtyso, $notr, $surat, $gudang)
	{
		$this->stock_booking->changeActual($material, $qtyso, $notr, $surat, 'in', $gudang, 'stock_material_multigudang');
	}

	protected function kartu_stok_in_penjualan($material, $qtyso, $notr, $surat, $gudang)
	{
		$this->stock_booking->changeActual($material, $qtyso, $notr, $surat, 'in', $gudang, 'stock_material');
	}



	public function konsinyasi()
	{
		$id_bentuk = $this->uri->segment(3);
		$this->auth->restrict($this->viewPermission);
		$session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-warehouse');
		$gudang = $this->db->query("SELECT * FROM ms_gudang where id_gudang NOT IN('1','2','3','4')")->result();
		$data = [
			'gudang' => $gudang,
		];
		$this->template->set('results', $data);
		$this->template->title('Adjustment Stock Konsinyasi');
		$this->template->render('konsinyasi');
	}

	public function index_konsinyasi()
	{



		$gudang = $this->input->post('id_gudang');
		// print_r($gudang);
		// exit;
		$this->auth->restrict($this->viewPermission);
		if (!is_string($gudang) || !ctype_digit($gudang) || in_array($gudang, array('1','2','3','4'), true) || !$this->db->get_where('ms_gudang', array('id_gudang'=>$gudang))->row()) { show_error('Gudang tidak valid.', 400); return; }
		$session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
		$deleted = '0';
		$stok		 = $this->Inventory_4_model->get_data_konsinyasi($gudang);
		$history	= $this->db->query("SELECT * FROM adjustment_stock WHERE id_gudang=? OR id_gudang_baru=?", array($gudang,$gudang))->result();
		$data = [
			'stok' => $stok,
			'history' => $history,
		];
		$this->template->set('results', $data);
		$this->template->title('Adjustment Stock Konsinyasi');
		$this->template->render('index_konsinyasi');
	}

	public function mutasi()
	{
		$id_bentuk = $this->uri->segment(3);
		$this->auth->restrict($this->viewPermission);
		$session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-warehouse');
		$gudang = $this->db->query("SELECT * FROM ms_gudang")->result();
		$data = [
			'gudang' => $gudang,
		];
		$this->template->set('results', $data);
		$this->template->title('Mutasi Stock');
		$this->template->render('mutasi');
	}

	public function index_mutasi()
	{



		$gudang = $this->input->post('id_gudang');
		// print_r($gudang);
		// exit;
		$this->auth->restrict($this->viewPermission);
		if (!is_string($gudang) || !ctype_digit($gudang) || !$this->db->get_where('ms_gudang', array('id_gudang'=>$gudang))->row()) { show_error('Gudang tidak valid.', 400); return; }
		$session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
		$deleted = '0';
		if ($gudang == 1) {
			$stok		 = $this->Inventory_4_model->get_data_mutasi1($gudang);
		} else {
			$stok		 = $this->Inventory_4_model->get_data_mutasi2($gudang);
		}

		$history	= $this->db->query("SELECT * FROM adjustment_stock WHERE id_gudang=? OR id_gudang_baru=?", array($gudang,$gudang))->result();
		$data = [
			'stok' => $stok,
			'history' => $history,
		];
		$this->template->set('results', $data);
		$this->template->title('Mutasi Stock');
		$this->template->render('index_mutasi');
	}

	public function MutasiNow($id)
	{
		$this->auth->restrict($this->viewPermission);
		$id_stock = $this->uri->segment(4);
		$id_gudang = $this->uri->segment(5);
		$inventory = $this->Inventory_4_model->GetMaterial($id);
		$table = ($id_gudang === '1' ? 'stock_material' : 'stock_material_multigudang');
		$stock = $this->db->get_where($table, array('id_stock'=>$id_stock, 'id_category3'=>$id, 'id_gudang'=>$id_gudang))->row();
		if (count($inventory) !== 1 || !$stock || ($stock->deleted ?? 0) != 0 || ($stock->aktif ?? '') === 'N') {
			show_404();
			return;
		}
		$this->load->library('Stock_booking');
		$data = array('inventory_3'=>$inventory, 'idstock'=>$id_stock, 'idgudang'=>$id_gudang, 'stock'=>$stock, 'request_key'=>$this->stock_booking->adjustmentToken());
		$data['gudang'] = $this->db->where('id_gudang !=', $id_gudang)->get('ms_gudang')->result();
		$this->template->set('results', $data);
		$this->template->title('Mutasi Stock');
		$this->template->render('CreateMutasi');
	}
}
