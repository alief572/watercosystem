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
		$this->saveCostbook(true);
	}

	public function saveAddCostbook()
	{
		$this->saveCostbook(false);
	}

	private function saveCostbook($editing)
	{
		$this->auth->restrict($editing ? $this->managePermission : $this->addPermission);
		$this->load->library('Stock_booking');
		$this->stock_booking->document(function () use ($editing) {
			$post = $this->input->post();
			$value = round(Stock_booking_store::amount($post['costbook'] ?? null), 2);
			if ($editing) {
				if (!is_scalar($post['id'] ?? null) || !ctype_digit((string)$post['id']) || (int)$post['id'] <= 0) { throw new DomainException('ID costbook tidak valid.'); }
				$found = $this->db->query('SELECT id_category3 FROM ms_costbook WHERE id=?', array($post['id'] ?? ''))->result_array();
				if (count($found) !== 1) { throw new DomainException('Costbook tidak ditemukan.'); }
				$material = $found[0]['id_category3'];
			} else {
				$material = $post['inventory_3'] ?? '';
			}
			$rows = $this->stock_booking->costbook($material);
			if ($editing) {
				if (count($rows) !== 1 || (string)$rows[0]['id'] !== (string)($post['id'] ?? '')) { throw new DomainException('Referensi costbook berubah. Muat ulang data.'); }
				if ($this->db->insert('ms_costbook_history', array('id_costbook'=>$rows[0]['id'],'nilai_costbook'=>$rows[0]['nilai_costbook'],'created_on'=>date('Y-m-d H:i:s'),'created_by'=>$this->auth->user_id())) === false
					|| $this->db->query('UPDATE ms_costbook SET nilai_costbook=?,modified_on=NOW(),modified_by=? WHERE id=?', array($value,$this->auth->user_id(),$rows[0]['id'])) === false) { throw new RuntimeException('Gagal menyimpan costbook.'); }
			} else {
				if ($rows) { throw new DomainException('Costbook barang sudah tersedia.'); }
				if ($this->db->insert('ms_costbook', array('id_category3'=>$material,'nilai_costbook'=>$value,'created_on'=>date('Y-m-d H:i:s'),'created_by'=>$this->auth->user_id())) === false) { throw new RuntimeException('Gagal membuat costbook.'); }
			}
			$saved = $this->stock_booking->costbook($material);
			if (count($saved) !== 1 || (float)$saved[0]['nilai_costbook'] !== $value || !$this->db->trans_status()) { throw new RuntimeException('Costbook tidak tersimpan.'); }
			echo json_encode(array('status'=>1,'pesan'=>'Costbook berhasil disimpan.'));
		}, false);
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
		$this->auth->restrict($this->managePermission);
		$this->load->library('Stock_booking');
		$this->stock_booking->document(function () {
			$post = $this->input->post();
			if (empty($post['check']) || !is_array($post['check'])) { throw new DomainException('Tidak ada data yang diproses.'); }
			$values = array();
			foreach ($post['check'] as $index) {
				if (!is_int($index) && !is_string($index)) { throw new DomainException('Pilihan costbook tidak valid.'); }
				$detail = $post['detail'][$index] ?? array();
				$material = $detail['id_category3'] ?? '';
				if (!is_string($material) || $material === '' || isset($values[$material])) { throw new DomainException('Pilihan costbook tidak valid atau duplikat.'); }
				$values[$material] = round(Stock_booking_store::amount($detail['costbook_report'] ?? null), 2);
			}
			ksort($values);
			foreach ($values as $material=>$value) {
				$rows = $this->stock_booking->costbook($material);
				if (count($rows) !== 1) { throw new DomainException('Costbook barang belum tersedia: ' . $material); }
				if ($this->db->insert('ms_costbook_history', array('id_costbook'=>$rows[0]['id'],'nilai_costbook'=>$rows[0]['nilai_costbook'],'created_on'=>date('Y-m-d H:i:s'),'created_by'=>$this->auth->user_id())) === false
					|| $this->db->query('UPDATE ms_costbook SET nilai_costbook=?,modified_by=?,modified_on=NOW() WHERE id=?', array($value,$this->auth->user_id(),$rows[0]['id'])) === false) { throw new RuntimeException('Gagal memperbarui costbook.'); }
				$saved = $this->stock_booking->costbook($material);
				if (count($saved) !== 1 || (float)$saved[0]['nilai_costbook'] !== $value) { throw new RuntimeException('Costbook tidak tersimpan.'); }
			}
			if (!$this->db->trans_status()) { throw new RuntimeException('Gagal menyimpan costbook.'); }
			echo json_encode(array('status'=>1,'msg'=>'Costbook berhasil diperbarui.','pesan'=>'Costbook berhasil diperbarui.'));
		}, false);
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
