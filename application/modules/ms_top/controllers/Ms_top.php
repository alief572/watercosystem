<?php

if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

/*
 * @author Syamsudin
 * @copyright Copyright (c) 2022, Syamsudin
 *
 * This is controller for Master Top
 */

class Ms_top extends Admin_Controller
{
	//Permission
	protected $viewPermission 	= 'Top.View';
	protected $addPermission  	= 'Top.Add';
	protected $managePermission = 'Top.Manage';
	protected $deletePermission = 'Top.Delete';

	public function __construct()
	{
		parent::__construct();

		require_once 'vendor/autoload.php';

		$this->load->library(array('upload', 'Image_lib'));
		$this->load->model(array(
			'ms_top/Ms_top_model',
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
		$data = $this->Ms_top_model->get_data_top();
		$this->template->set('results', $data);
		$this->template->title('Term Of Payment');
		$this->template->render('index');
	}

	public function top()
	{
		$this->auth->restrict($this->viewPermission);
		$session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
		$deleted = '0';
		$data = $this->Ms_top_model->get_top();
		$this->template->set('results', $data);
		$this->template->title('Master Term Of Payment');
		$this->template->render('top');
	}

	public function AddMsTop()
	{
		$this->auth->restrict($this->viewPermission);
		$session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-plus');
		$this->template->title('Add Term Of Payment');
		$this->template->render('addmstop');
	}

	public function AddTopMs()
	{
		$this->auth->restrict($this->viewPermission);
		$session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-plus');
		$this->template->title('Add Master TOP');
		$this->template->render('addmstopms');
	}

	public function saveNewmstop()
	{
		$this->auth->restrict($this->addPermission);
		$post = $this->input->post();
		$this->db->trans_begin();
		$data = [
			'nama_top'		    => $post['top'],
			'created_on'		=> date('Y-m-d H:i:s'),
			'created_by'		=> $this->auth->user_id(),
			'deleted'			=> '0'
		];

		$insert = $this->db->insert("ms_top", $data);

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


	public function AddTop()
	{
		$this->auth->restrict($this->viewPermission);
		$session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-plus');
		$this->template->title('Add Term Of Payment');
		$this->template->render('addtop');
	}

	function GetProduk()
	{
		$loop = $_GET['jumlah'] + 1;

		$customers = $this->Ms_top_model->get_data('master_customers', 'deleted', $deleted);


		$material = $this->db->query("SELECT a.* FROM ms_inventory_type as a ")->result();
		$top      = $this->db->query("SELECT a.* FROM ms_top as a ")->result();



		echo "
		<tr id='tr_$loop'>
			<td hidden>$loop</td>
			<td>
            <select id='used_top_$loop' name='dt[$loop][top]' data-no='$loop' class='form-control select' required>
            <option value=''>-Pilih-</option>";
		foreach ($top as $top) {
			echo "<option value='$top->id_top'>$top->nama_top</option>";
		}
		echo	"</select>
			</td>
            <td>
				<select id='used_payment_$loop' name='dt[$loop][payment]' data-no='$loop' class='form-control select' required>
					<option value=''>-Pilih-</option>";
		echo "<option value='Payment I'>Payment I</option>";
		echo "<option value='Payment II'>Payment II</option>";
		echo "<option value='Payment III'>Payment III</option>";
		echo "<option value='Payment IV'>Payment IV</option>";
		echo "<option value='Payment V'>Payment V</option>";

		echo	"</select>
			</td>";

		echo	"<td id='keterangan_$loop'><input type='text' align='right' class='form-control input-sm' id='used_keterangan_$loop' required name='dt[$loop][keterangan]'></td>
                <td id='nilai_$loop'><input type='text' align='right' class='form-control input-sm' id='used_nilai_$loop' required name='dt[$loop][nilai]'></td>
                <td align='center'>
                <button type='button' class='btn btn-sm btn-danger' title='Hapus Data' data-role='qtip' onClick='return HapusItem($loop);'><i class='fa fa-close'></i></button>
                </td>
                <td align='center'>
                <button type='button' class='btn btn-sm btn-primary' title='Tambah Data' data-role='qtip' onClick='return GetSubProduk($loop);'><i class='fa fa-plus'></i></button>
                </td>
			
		</tr>
		";
	}

	function GetSubProduk()
	{
		$loop = $_GET['jumlah'] + 1;
		$top_now = $_GET['idtop'];

		// print_r($top_now);
		// exit();

		$customers = $this->Ms_top_model->get_data('master_customers', 'deleted', $deleted);


		$material = $this->db->query("SELECT a.* FROM ms_inventory_type as a ")->result();
		$top      = $this->db->query("SELECT a.* FROM ms_top as a ")->result();



		echo "
		<tr id='tr_$loop'>
			<td>$loop</td>
            <td></td>
			<td hidden>
            <select id='used_top_$loop' name='dt[$loop][top]' data-no='$loop' class='form-control select' readonly required >
            <option value=''>-Pilih-</option>";
		foreach ($top as $top) {
			$selected = $top_now == $top->id_top ? 'selected' : '';
			echo "<option value='$top->id_top'  $selected >$top->nama_top</option>";
		}
		echo	"</select>
			</td>
            <td>
				<select id='used_payment_$loop' name='dt[$loop][payment]' data-no='$loop' class='form-control select' required>
					<option value=''>-Pilih-</option>";
		echo "<option value='Payment I'>Payment I</option>";
		echo "<option value='Payment II'>Payment II</option>";
		echo "<option value='Payment III'>Payment III</option>";
		echo "<option value='Payment IV'>Payment IV</option>";
		echo "<option value='Payment V'>Payment V</option>";

		echo	"</select>
			</td>";

		echo	"<td id='keterangan_$loop'><input type='text' align='right' class='form-control input-sm' id='used_keterangan_$loop' required name='dt[$loop][keterangan]'></td>
                <td id='nilai_$loop'><input type='text' align='right' class='form-control input-sm' id='used_nilai_$loop' required name='dt[$loop][nilai]'></td>
                <td align='center'>
                <button type='button' class='btn btn-sm btn-danger' title='Hapus Data' data-role='qtip' onClick='return HapusItem($loop);'><i class='fa fa-close'></i></button>
                </td>
                <td align='center' hidden>
                <button type='button' class='btn btn-sm btn-primary' title='Tambah Data' data-role='qtip' onClick='return GetSubProduk($loop);'><i class='fa fa-plus'></i></button>
                </td>
			
		</tr>
		";
	}


	public function SaveNewTop()
	{
		$this->auth->restrict($this->addPermission);
		$post = $this->input->post();
		$this->db->trans_begin();

		$numb1 = 0;
		foreach ($_POST['dt'] as $used) {
			if (!empty($used[top])) {
				$numb1++;
				$dt[] =  array(
					'id_top'		        => $used[top],
					'payment'		    => $used[payment],
					'keterangan'	        => $used[keterangan],
					'persentase'	            => $used[nilai],
					'created_on'			=> date('Y-m-d H:i:s'),
					'created_by'			=> $this->auth->user_id()
				);
			}
		}
		//    print_r($dt);
		//    exit();
		$this->db->insert_batch('ms_top_planning', $dt);

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

	public function editTop($id)
	{
		$this->auth->restrict($this->viewPermission);
		$session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-edit');
		$top = $this->db->get_where('ms_top_planning', array('id_top_planning' => $id))->result();
		$lvl1 = $this->Ms_top_model->get_data('ms_inventory_type');
		$lvl2 = $this->Ms_top_model->get_data('ms_top');
		$data = [
			'top' => $top,
			'select_top' => $lvl2,
		];
		$this->template->set('results', $data);
		$this->template->title('Top');
		$this->template->render('edittop');
	}

	public function saveEditTop()
	{
		$this->auth->restrict($this->editPermission);
		$post = $this->input->post();
		// print_r($post);
		// exit();
		$this->db->trans_begin();
		$data = [
			'id_top'		    => $post['top'],
			'payment'		    => $post['payment'],
			'keterangan'        => $post['keterangan'],
			'persentase'        => $post['persentase'],
			'modified_on'		=> date('Y-m-d H:i:s'),
			'modified_by'		=> $this->auth->user_id()
		];

		$this->db->where('id_top_planning', $post['id_top_planning'])->update("ms_top_planning", $data);

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$status	= array(
				'pesan'		=> 'Gagal Save Data. Thanks ...',
				'status'	=> 0
			);
		} else {
			$this->db->trans_commit();
			$status	= array(
				'pesan'		=> 'Success Save Data. Thanks ...',
				'status'	=> 1
			);
		}

		echo json_encode($status);
	}

	public function deleteTop()
	{
		$this->auth->restrict($this->deletePermission);
		$id = $this->input->post('id');
		$data = [
			'deleted' 		=> '1',
			'deleted_by' 	=> $this->auth->user_id()
		];

		$this->db->trans_begin();
		$this->db->where('id_top_planning', $id)->update("ms_top_planning", $data);

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
}
