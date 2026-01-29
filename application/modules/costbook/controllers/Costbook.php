<?php

if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

/*
 * @author Syamsudin
 * @copyright Copyright (c) 2019, Syamsudin
 *
 * This is controller for Master Kurs
 */

class Costbook extends Admin_Controller
{
	//Permission
	protected $viewPermission 	= 'Costbooks.View';
	protected $addPermission  	= 'Costbooks.Add';
	protected $managePermission = 'Costbooks.Manage';
	protected $deletePermission = 'Costbooks.Delete';

	public function __construct()
	{
		parent::__construct();

		$this->load->library(array('Mpdf', 'upload', 'Image_lib'));
		$this->load->model(array(
			'Costbook/Costbook_model',
			'Crud/Crud_model',
			'Aktifitas/aktifitas_model',
		));
		$this->template->title('Manage Data Costbooks');
		$this->template->page_icon('fa fa-building-o');

		date_default_timezone_set('Asia/Bangkok');
	}

	public function index()
	{
		$this->auth->restrict($this->viewPermission);
		$session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
		$aktif = 'Y';
		$data = $this->Costbook_model->get_costbook();
		$this->template->set('results', $data);
		$this->template->title('Costbooks');
		$this->template->render('index');
	}
	public function editCostbook($id)
	{
		$this->auth->restrict($this->viewPermission);
		$session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-edit');
		$inven = $this->db->get_where('ms_costbook', array('id' => $id))->result();
		$data = [
			'costbook' => $inven
		];
		$this->template->set('results', $data);
		$this->template->title('Edit Costbook');
		$this->template->render('edit_costbook');
	}

	public function addCostbook()
	{
		$this->auth->restrict($this->viewPermission);
		$session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-plus');
		$deleted = '0';
		$inventory_3 = $this->Costbook_model->get_data('ms_inventory_category3', 'deleted', $deleted);
		$data = [
			'inventory_3' => $inventory_3,
		];
		$this->template->set('results', $data);
		$this->template->title('Add Costbook');
		$this->template->render('add_costbook');
	}

	public function saveEditCostbook()
	{
		$this->auth->restrict($this->editPermission);
		$post = $this->input->post();
		$id	  = $post['id'];
		$this->db->trans_begin();

		$cb = $this->db->query("select * from ms_costbook WHERE id='$id'")->result();

		foreach ($cb as $record) {

			$data = [
				'id_costbook'		=> $id,
				'nilai_costbook'	=> $record->nilai_costbook,
				'created_on'		=> date('Y-m-d H:i:s'),
				'created_by'		=> $this->auth->user_id(),
			];

			$insert = $this->db->insert("ms_costbook_history", $data);
		}

		$data_update = [
			'nilai_costbook' 	=> $post['costbook'],
			'modified_on'		=> date('Y-m-d H:i:s'),
			'modified_by' 		=> $this->auth->user_id()
		];
		$this->db->where('id', $id)->update("ms_costbook", $data_update);



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


	public function saveAddCostbook()
	{
		$this->auth->restrict($this->editPermission);
		$post = $this->input->post();
		$id	  = $post['inventory_3'];
		$this->db->trans_begin();

		$cb = $this->db->query("select * from ms_costbook WHERE id_category3='$id'")->num_rows();



		if ($cb < 1) {

			$data = [
				'id_category3'		=> $id,
				'nilai_costbook'	=> $post['costbook'],
				'created_on'		=> date('Y-m-d H:i:s'),
				'created_by'		=> $this->auth->user_id(),
			];

			$insert = $this->db->insert("ms_costbook", $data);
		}

		if ($cb > 0) {

			$status	= array(
				'pesan'		=> 'Gagal Save Item material sudah ada. Thanks ...',
				'status'	=> 0
			);
		} else {

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
		}

		echo json_encode($status);
	}

	public function check_costbook()
	{
		$get_inventory3 = $this->db->get_where('ms_inventory_category3', ['deleted' => 0])->result();

		$hasil = [];

		foreach ($get_inventory3 as $item) {
			$this->db->select('a.nilai_costbook');
			$this->db->from('ms_costbook a');
			$this->db->where('a.id_category3', $item->id_category3);
			$get_costbook_master = $this->db->get()->row();

			$costbook_master = (!empty($get_costbook_master->nilai_costbook)) ? $get_costbook_master->nilai_costbook : 0;

			$this->db->select('a.cost_book');
			$this->db->from('kartu_stok a');
			$this->db->where('a.id_category3', $item->id_category3);
			$this->db->where('a.cost_book <>', null);
			$this->db->where('a.cost_book >', 0);
			$this->db->order_by('a.created_on', 'desc');
			$this->db->limit(1);
			$get_costbook_report = $this->db->get()->row();

			$costbook_report = (!empty($get_costbook_report->cost_book)) ? $get_costbook_report->cost_book : 0;

			if ($costbook_master <> $costbook_report && $costbook_report > 0) {
				$hasil[] = [
					'id_category3' => $item->id_category3,
					'nm_barang' => $item->nama,
					'nilai_costbook_master' => $costbook_master,
					'nilai_costbook_report' => $costbook_report
				];
			}
		}

		$data = [
			'list_barang' => $hasil
		];

		$this->load->view('check_costbook', $data);
	}

	public function save_check_costbook()
	{
		$post = $this->input->post();

		if (isset($post['check'])) {
			$arr_update = [];

			foreach ($post['check'] as $item_check) {
				$id_category3 = $post['detail'][$item_check]['id_category3'];
				$costbook_report = $post['detail'][$item_check]['costbook_report'];

				$arr_update[] = [
					'id_category3' => $id_category3,
					'nilai_costbook' => $costbook_report,
					'modified_by' => $this->auth->user_id(),
					'modified_on' => date('Y-m-d H:i:s')
				];
			}

			$this->db->trans_begin();

			try {
				$update_costbook = $this->db->update_batch('ms_costbook', $arr_update, 'id_category3');

				$this->db->trans_commit();

				$response = [
					'status' => 1,
					'msg' => 'Data costbook yang dipilih sudah terupdate !'
				];
			} catch (Exception $e) {
				$this->db->trans_rollback();

				$response = [
					'status' => 0,
					'msg' => $e->getMessage()
				];
			}
		} else {
			$response = [
				'status' => 0,
				'msg' => 'Tidak ada data yang di proses !'
			];
		}

		echo json_encode($response);
	}

	public function get_costbooks()
	{
		$post = $this->input->post();

		$draw = intval($post['draw']);
		$length = $post['length'];
		$start = $post['start'];
		$search = $post['search']['value'];

		$this->db->select('a.*, b.nama as nama_produk, b.kode_barang');
		$this->db->from('ms_costbook a');
		$this->db->join('ms_inventory_category3 b', 'b.id_category3 =a.id_category3');
		$this->db->where('b.deleted <>', '1');

		$count_all = $this->db->count_all_results('', false);

		if (!empty($search)) {
			$this->db->group_start();
			$this->db->like('a.id_category3', $search, 'both');
			$this->db->or_like('b.nama', $search, 'both');
			$this->db->or_like('b.kode_barang', $search, 'both');
			$this->db->or_like('a.nilai_costbook', $search, 'both');
			$this->db->group_end();
		}

		$count_filter = $this->db->count_all_results('', false);

		$this->db->order_by('a.id_category3', 'asc');
		$this->db->limit($length, $start);

		$get_data = $this->db->get()->result();

		$no = (0 + $start);
		$hasil = [];

		foreach ($get_data as $item) {
			$no++;

			$btn_edit = '';
			if (has_permission($this->managePermission)) {
				$btn_edit = '<a href="javascript:void(0);" class="btn btn-success btn-sm edit" title="Edit" data-id_inventory1="' . $item->id . '"><i class="fa fa-edit"></i></a>';
			}

			$hasil[] = [
				'no' => $no,
				'id_product' => $item->id_category3,
				'nm_product' => $item->nama_produk,
				'kode_barang' => $item->kode_barang,
				'harga_hpp' => number_format($item->nilai_costbook, 2),
				'action' => $btn_edit
			];
		}

		$response = [
			'draw' => $draw,
			'recordsTotal' => $count_all,
			'recordsFiltered' => $count_filter,
			'data' => $hasil
		];

		echo json_encode($response);
	}


	public function download_excel()
	{
		$get_costbook = $this->Costbook_model->get_costbook();

		$this->load->view('costbook_excel', ['costbook' => $get_costbook]);
	}
}
