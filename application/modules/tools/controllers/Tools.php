<?php
if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Tools extends Admin_Controller
{
	//Permission
	protected $viewPermission = "Tools.View";
	protected $addPermission = "Tools.Add";
	protected $managePermission = "Tools.Manage";
	protected $deletePermission = "Tools.Delete";

	// Nomor planning/SO: huruf, angka, titik, garis miring dan strip.
	const NOMOR_PATTERN = '/^[A-Za-z0-9._\/-]{1,50}$/';

	public function __construct()
	{
		parent::__construct();
		$this->template->title('Tools');
		$this->template->page_icon('fa fa-building-o');
		date_default_timezone_set('Asia/Bangkok');
	}

	// ---------------------------------------------------------------- Batal Planning

	public function batal_planning()
	{
		$this->auth->restrict($this->viewPermission);
		$this->template->page_icon('fa fa-list');
		$this->template->title('Hapus Data Planning');
		$this->template->render('index_dtspkmarketing');
	}

	// Data serverside daftar planning (DataTable). Filter "nomor" mencari di no_surat_planning.
	public function data_planning()
	{
		$this->auth->restrict($this->viewPermission);
		$this->load->helper('dt');
		dt_respond($this, function () {
			list($where, $binds) = $this->nomorFilter('a.no_surat_planning');
			$data = dt_list($this->db, $this->dtRequest(), array(
				'from'    => 'tr_planning_delivery a JOIN master_customers c ON c.id_customer = a.id_customer JOIN ms_top d ON d.id_top = a.top',
				'select'  => "a.id, a.no_planning, a.no_surat_planning, a.no_surat, a.nama_sales, c.name_customer, d.nama_top,
					EXISTS(SELECT 1 FROM wt_plan_tagih w WHERE w.no_planning = a.no_planning AND w.status_invoice = '1') AS ditagih",
				'where'   => $where,
				'binds'   => $binds,
				'search'  => array('a.no_surat_planning', 'a.no_surat', 'c.name_customer', 'a.nama_sales'),
				'sort'    => array(1 => 'a.no_surat_planning', 2 => 'a.no_surat', 3 => 'c.name_customer', 4 => 'a.nama_sales', 5 => 'd.nama_top'),
				'default' => 'a.no_planning DESC',
				'tiebreak' => 'a.id DESC',
			));
			$canDelete = has_permission($this->deletePermission);
			$rows = array(); $number = $data['start'];
			foreach ($data['rows'] as $row) {
				$ditagih = (int) $row->ditagih === 1;
				$action = '';
				// Planning yang sudah ditagih tidak boleh dibatalkan (ditolak juga di hapusplanning()).
				if ($canDelete && !$ditagih) {
					$action = '<a class="btn btn-danger btn-sm delete" href="javascript:void(0)" title="Delete" data-no_planning="' . html_escape($row->no_planning) . '"><i class="fa fa-trash"></i></a>';
				}
				$rows[] = array('DT_RowId' => 'plan-' . (int) $row->id, 'no' => ++$number,
					'no_surat_planning' => html_escape($row->no_surat_planning), 'no_surat' => html_escape($row->no_surat),
					'customer' => html_escape($row->name_customer), 'sales' => html_escape($row->nama_sales), 'top' => html_escape($row->nama_top),
					'status_tagih' => $ditagih ? '<span class="label label-success">Sudah ditagih</span>' : '<span class="label label-default">Belum</span>',
					'action' => $action);
			}
			return array('draw' => $data['draw'], 'recordsTotal' => $data['total'], 'recordsFiltered' => $data['filtered'], 'data' => $rows);
		}, 'Tools batal planning');
	}

	public function hapusplanning()
	{
		$this->auth->restrict($this->deletePermission);
		$id = $this->input->post('id');
		$this->load->library('Stock_booking');
		$this->stock_booking->document(function () use ($id) {
			if (!is_string($id) || !preg_match(self::NOMOR_PATTERN, $id)) {
				throw new DomainException('Nomor planning tidak valid.');
			}
			$run = function ($sql, array $binds = array()) {
				$query = $this->db->query($sql, $binds);
				if ($query === false) throw new RuntimeException('Query batal planning gagal.');
				return $query;
			};

			if (!$run('SELECT no_planning FROM tr_planning_delivery WHERE no_planning = ? FOR UPDATE', array($id))->row()) {
				throw new DomainException('Planning tidak ditemukan.');
			}
			if ($run("SELECT id_plan_tagih FROM wt_plan_tagih WHERE no_planning = ? AND status_invoice = '1' LIMIT 1 FOR UPDATE", array($id))->row()) {
				throw new DomainException('Planning sudah ditagih. Batalkan atau revisi invoice terlebih dahulu.');
			}

			// Lepas qty/booking SO (menolak bila planning sudah punya SPK).
			$this->stock_booking->cancelPlanning($id);

			// Arsipkan header dan detail ke tabel *_deleted; daftar kolom dari skema supaya tetap sama bila kolom bertambah.
			foreach (array('tr_planning_delivery' => 'tr_planning_delivery_deleted', 'tr_planning_delivery_detail' => 'tr_planning_delivery_detail_deleted') as $source => $archive) {
				$columns = array();
				foreach ($run('SHOW COLUMNS FROM ' . $source)->result() as $column) {
					$columns[] = '`' . $column->Field . '`';
				}
				$list = implode(', ', $columns);
				$run("INSERT INTO $archive ($list, deleted_by, deleted_on) SELECT $list, ?, NOW() FROM $source WHERE no_planning = ?",
					array((string) $this->auth->user_id(), $id));
			}

			$run('DELETE FROM tr_planning_delivery WHERE no_planning = ?', array($id));
			$run('DELETE FROM tr_planning_delivery_detail WHERE no_planning = ?', array($id));
			$run('DELETE FROM wt_plan_tagih WHERE no_planning = ?', array($id));

			simpan_aktifitas($this->deletePermission, $id, 'SUKSES, Batal Planning ' . $id, 1, '', 1);
			echo json_encode(array('status' => 1, 'pesan' => 'Planning dibatalkan.'));
		});
	}

	// ---------------------------------------------------------------- Batal SO

	public function batal_so()
	{
		$this->auth->restrict($this->viewPermission);
		$this->template->page_icon('fa fa-list');
		$this->template->title('Hapus Data SO');
		$this->template->render('index_so');
	}

	// Data serverside daftar SO aktif (DataTable). Filter "nomor" mencari di no_surat SO.
	public function data_so()
	{
		$this->auth->restrict($this->viewPermission);
		$this->load->helper('dt');
		dt_respond($this, function () {
			list($where, $binds) = $this->nomorFilter('a.no_surat', "a.status <> '0' AND a.deleted_by IS NULL");
			$data = dt_list($this->db, $this->dtRequest(), array(
				'from'    => 'tr_sales_order a JOIN master_customers b ON b.id_customer = a.id_customer LEFT JOIN tr_penawaran c ON c.no_penawaran = a.no_penawaran',
				'select'  => 'a.id, a.no_so, a.no_surat, a.nama_sales, a.grand_total, b.name_customer, c.grand_total AS total_penawaran',
				'where'   => $where,
				'binds'   => $binds,
				'search'  => array('a.no_surat', 'b.name_customer', 'a.nama_sales'),
				'sort'    => array(1 => 'a.no_surat', 2 => 'b.name_customer', 3 => 'a.nama_sales', 4 => 'c.grand_total', 5 => 'a.grand_total'),
				'default' => 'a.no_so DESC',
				'tiebreak' => 'a.id DESC',
			));
			$canDelete = has_permission($this->deletePermission);
			$rows = array(); $number = $data['start'];
			foreach ($data['rows'] as $row) {
				$action = '';
				if ($canDelete) {
					$action = '<a class="btn btn-danger btn-sm delete" href="javascript:void(0)" title="Delete" data-no_so="' . html_escape($row->no_so) . '"><i class="fa fa-trash"></i></a>';
				}
				$rows[] = array('DT_RowId' => 'so-' . (int) $row->id, 'no' => ++$number,
					'no_surat' => html_escape($row->no_surat), 'customer' => html_escape(strtoupper((string) $row->name_customer)),
					'sales' => html_escape($row->nama_sales),
					'nilai_penawaran' => number_format((float) $row->total_penawaran), 'nilai_so' => number_format((float) $row->grand_total),
					'action' => $action);
			}
			return array('draw' => $data['draw'], 'recordsTotal' => $data['total'], 'recordsFiltered' => $data['filtered'], 'data' => $rows);
		}, 'Tools batal SO');
	}

	public function hapus_so()
	{
		$this->auth->restrict($this->deletePermission);
		$id = $this->input->post('id');
		$this->load->library('Stock_booking');
		$this->stock_booking->document(function () use ($id) {
			if (!is_string($id) || !preg_match(self::NOMOR_PATTERN, $id)) {
				throw new DomainException('Nomor SO tidak valid.');
			}
			// SO yang masih punya planning tidak boleh dibatalkan: planning dan tagihnya akan tertinggal.
			$planning = $this->db->query('SELECT no_planning FROM tr_planning_delivery WHERE no_so = ? LIMIT 1', array($id));
			if ($planning === false) throw new RuntimeException('Query batal SO gagal.');
			if ($planning->row()) {
				throw new DomainException('SO masih memiliki planning. Batalkan planning terlebih dahulu di menu Batal Planning.');
			}

			$this->stock_booking->cancelSo($id);

			simpan_aktifitas($this->deletePermission, $id, 'SUKSES, Batal SO ' . $id, 1, '', 1);
			echo json_encode(array('status' => 1, 'pesan' => 'SO dibatalkan; sisa booking dilepas.'));
		});
	}

	// ---------------------------------------------------------------- bantu

	// Parameter DataTable dari POST.
	private function dtRequest()
	{
		$request = array();
		foreach (array('draw', 'start', 'length', 'search', 'order') as $key) {
			$request[$key] = $this->input->post($key);
		}
		return $request;
	}

	// Kondisi WHERE tetap + filter kotak "nomor" ($column LIKE ?). Mengembalikan array(where, binds).
	private function nomorFilter($column, $base = '1 = 1')
	{
		$nomor = $this->input->post('nomor');
		if ($nomor === null || $nomor === '') {
			return array($base, array());
		}
		if (!is_string($nomor) || preg_match_all('/./us', $nomor) > 100) {
			throw new DomainException('Nomor maksimal 100 karakter.');
		}
		return array($base . " AND $column LIKE ? ESCAPE '!'", array(dt_like(trim($nomor))));
	}
}
