<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * @author Yunas Handra
 * @copyright Copyright (c) 2018, Yunas Handra
 *
 * This is model class for table "Customer"
 */

class Inventory_4_model extends BF_Model
{
	/**
	 * @var string  User Table Name
	 */
	protected $table_name = 'ms_inventory_category3';
	protected $key        = 'id';

	/**
	 * @var string Field name to use for the created time column in the DB table
	 * if $set_created is enabled.
	 */
	protected $created_field = 'created_on';

	/**
	 * @var string Field name to use for the modified time column in the DB
	 * table if $set_modified is enabled.
	 */
	protected $modified_field = 'modified_on';

	/**
	 * @var bool Set the created time automatically on a new record (if true)
	 */
	protected $set_created = true;

	/**
	 * @var bool Set the modified time automatically on editing a record (if true)
	 */
	protected $set_modified = true;
	/**
	 * @var string The type of date/time field used for $created_field and $modified_field.
	 * Valid values are 'int', 'datetime', 'date'.
	 */
	/**
	 * @var bool Enable/Disable soft deletes.
	 * If false, the delete() method will perform a delete of that row.
	 * If true, the value in $deleted_field will be set to 1.
	 */
	protected $soft_deletes = true;

	protected $date_format = 'datetime';

	/**
	 * @var bool If true, will log user id in $created_by_field, $modified_by_field,
	 * and $deleted_by_field.
	 */
	protected $log_user = true;

	/**
	 * Function construct used to load some library, do some actions, etc.
	 */
	public function __construct()
	{
		parent::__construct();
	}

	function generate_id($kode = '')
	{
		$query = $this->db->query("SELECT MAX(id_stock) as max_id FROM stock_material");
		$row = $query->row_array();
		$thn = date('y');
		$max_id = $row['max_id'];
		$max_id1 = (int) substr($max_id, 3, 5);
		$counter = $max_id1 + 1;
		$idcust = "I" . $thn . str_pad($counter, 5, "0", STR_PAD_LEFT);
		return $idcust;
	}

	function level_2($inventory_1)
	{
		$search = "deleted='0' and id_type='$inventory_1'";
		$this->db->where($search);
		$this->db->order_by('id_category1', 'ASC');
		return $this->db->from('ms_inventory_category1')
			->get()
			->result();
	}
	function level_3($id_inventory2)
	{
		$search = "deleted='0' and id_category1='$id_inventory2'";
		$this->db->where($search);
		$this->db->order_by('id_category2', 'ASC');
		return $this->db->from('ms_inventory_category2')
			->get()
			->result();
	}
	public function GetMaterial($id_category3)
	{
		$cari = "a.deleted='0' and a.id_category3='$id_category3' ";
		$this->db->select('a.*, b.nama as nama_type , c.nilai_dimensi as thickness');
		$this->db->from('ms_inventory_category3 a');
		$this->db->join('ms_inventory_category2 b', 'b.id_category2=a.id_category2');
		$this->db->join('child_inven_dimensi c', 'c.id_category3=a.id_category3');
		$this->db->where($cari);
		$query = $this->db->get();
		return $query->result();
	}
	function compotition($id_inventory2)
	{
		$search = "deleted='0' and id_category1='$id_inventory2'";
		$this->db->where($search);
		$this->db->order_by('id_compotition', 'ASC');
		return $this->db->from('ms_compotition')
			->get()
			->result();
	}
	function bentuk($id_bentuk)
	{
		$search = "deleted='0' and id_bentuk='$id_bentuk'";
		$this->db->where($search);
		$this->db->order_by('id_dimensi', 'ASC');
		return $this->db->from('ms_dimensi')
			->get()
			->result();
	}
	function level_4($id_inventory3)
	{
		$this->db->where('id_category2', $id_inventory3);
		$this->db->order_by('id_category3', 'ASC');
		return $this->db->from('ms_inventory_category3')
			->get()
			->result();
	}

	public function get_data($table, $where_field = '', $where_value = '')
	{
		if ($where_field != '' && $where_value != '') {
			$query = $this->db->get_where($table, array($where_field => $where_value));
		} else {
			$query = $this->db->get($table);
		}

		return $query->result();
	}

	function getById($id)
	{
		return $this->db->get_where('inven_lvl2', array('id_inventory2' => $id))->row_array();
	}

	public function get_data_category3()
	{
		$this->db->select('a.*, b.nama as nama_type, c.nama as nama_category1,f.nm_bentuk as nm_bentuk, d.nama as nama_category2, e.nilai_dimensi as nilai_dimensi');
		$this->db->from('ms_inventory_category3 a');
		$this->db->join('ms_inventory_type b', 'b.id_type=a.id_type');
		$this->db->join('ms_inventory_category1 c', 'c.id_category1 =a.id_category1');
		$this->db->join('ms_inventory_category2 d', 'd.id_category2 =a.id_category2');
		$this->db->join('child_inven_dimensi e', 'e.id_category3 =a.id_category3');
		$this->db->join('ms_bentuk f', 'f.id_bentuk =a.id_bentuk');
		$this->db->where('a.deleted', '0');
		$query = $this->db->get();
		return $query->result();
	}

	public function get_stock()
	{

		$this->db->from('ms_inventory_category3 a');
		$this->db->join('ms_inventory_type b', 'b.id_type=a.id_type');
		$this->db->join('ms_inventory_category1 c', 'c.id_category1 =a.id_category1');
		$this->db->join('ms_inventory_category2 d', 'd.id_category2 =a.id_category2');
		$this->db->where('a.deleted', '0');
		$query = $this->db->get();
		return $query->result();
	}

	public function dapat_stock($id_category3)
	{
		$this->db->select('a.*, b.nama_gudang as nama_gudang, c.nama as nama_category3');
		$this->db->from('stock_material a');
		$this->db->join('ms_gudang b', 'b.id_gudang =a.id_gudang');
		$this->db->join('ms_inventory_category3 c', 'c.id_category3 =a.id_category3');
		$this->db->where('a.id_category3', $id_category3);
		$query = $this->db->get();
		return $query->result();
	}

	public function PerGudang($id_gudang)
	{
		$this->db->select('a.*, b.nama_gudang as nama_gudang');
		$this->db->from('stock_material a');
		$this->db->join('ms_gudang b', 'b.id_gudang =a.id_gudang');
		$this->db->join('ms_inventory_category3 c', 'a.id_category3 =c.id_category3');
		$this->db->join('ms_inventory_type d', 'c.id_type=d.id_type');
		$this->db->join('ms_inventory_category1 e', 'c.id_category1 =e.id_category1');
		$this->db->join('ms_inventory_category2 f', 'c.id_category2 =f.id_category2');
		$this->db->where('a.id_gudang', $id_gudang);
		$query = $this->db->get();
		return $query->result();
	}
	public function SumPerGudang($id_gudang)
	{
		$this->db->select_sum('a.qty');
		$this->db->from('stock_material a');
		$this->db->join('ms_gudang 				b', 'b.id_gudang 		=a.id_gudang');
		$this->db->join('ms_inventory_category3 c', 'c.id_category3 	=a.id_category3');
		$this->db->join('ms_inventory_type 		d', 'd.id_type			=c.id_type');
		$this->db->join('ms_inventory_category1 e', 'e.id_category1 	=c.id_category1');
		$this->db->join('ms_inventory_category2 f', 'f.id_category2 	=c.id_category2');
		$this->db->where('a.id_gudang', $id_gudang);
		$query = $this->db->get();
		return $query->result();
	}

	public function getview($id)
	{
		$this->db->select('a.*, b.nama as nama_type, c.nama as nama_category1, d.nama as nama_category2');
		$this->db->from('ms_inventory_category3 a');
		$this->db->join('ms_inventory_type b', 'b.id_type=a.id_type');
		$this->db->join('ms_inventory_category1 c', 'c.id_category1 =a.id_category1');
		$this->db->join('ms_inventory_category2 d', 'd.id_category2 =a.id_category2');
		$this->db->where('a.id_category3', $id);
		$query = $this->db->get();
		return $query->result();
	}

	public function get_child_compotition($id)
	{
		$this->db->select('a.*, b.name_compotition as name_compotition');
		$this->db->from('dt_material_compotition a');
		$this->db->join('ms_material_compotition b', 'b.id_compotition=a.id_compotition');
		$this->db->where('a.id_category3', $id);
		$query = $this->db->get();
		return $query->result();
	}
	public function get_child_dimention($id)
	{
		$this->db->select('a.*, b.dimensi_bentuk as dimensi_bentuk');
		$this->db->from('dt_material_dimensi a');
		$this->db->join('child_dimensi_bentuk b', 'b.id_dimensi_bentuk=a.id_dimensi_bentuk');
		$this->db->where('a.id_category3', $id);
		$query = $this->db->get();
		return $query->result();
	}
	public function get_child_suplier($id)
	{
		$this->db->select('a.*, b.name_supplier as name_supplier');
		$this->db->from('dt_material_supplier a');
		$this->db->join('master_supplier b', 'b.id_supplier=a.id_supplier');
		$this->db->where('a.id_category3', $id);
		$query = $this->db->get();
		return $query->result();
	}

	public function getSpek($id)
	{
		$this->db->select('a.*, b.name_compotition as name_compotition');
		$this->db->from('dt_material_compotition a');
		$this->db->join('ms_material_compotition b', 'b.id_compotition = a.id_compotition');
		$this->db->where('a.id_category3', $id);
		$query = $this->db->get();
		return $query->result();
	}

	public function cariKartuStok($id = null)
	{
		$this->db->select('a.*, b.nama');
		$this->db->from('kartu_stok a');
		$this->db->join('ms_inventory_category3 b', 'b.id_category3=a.id_category3');

		if ($id != null) {
			$where = "a.id_category3='$id'";
			$this->db->where($where);
		}
		$this->db->order_by('a.created_on', DESC);
		$query = $this->db->get();
		return $query->result();
	}

	public function getedit($id)
	{
		$this->db->select('a.*');
		$this->db->from('kartu_stok a');
		$this->db->where('a.id_kartu_stok', $id);
		$query = $this->db->get();
		return $query->result();
	}

	public function get_data_kartu_stock()
	{
		$draw = $this->input->post('draw');
		$start = $this->input->post('start');
		$length = $this->input->post('length');
		$search = $this->input->post('search');

		$produk = $this->input->post('produk');

		$this->db->select('a.id_kartu_stok, a.id_category3, a.qty, a.qty_book, a.qty_free, a.transaksi, a.tgl_transaksi, a.no_transaksi, a.id_gudang, a.qty_transaksi, a.qty_akhir, a.qty_book_akhir, a.qty_free_akhir, a.status_transaksi, a.harga_stok, a.harga_do, a.cost_book, a.no_surat, b.nama');
		$this->db->from('kartu_stok a');
		$this->db->join('ms_inventory_category3 b', 'b.id_category3=a.id_category3');

		if ($produk != null) {
			$where = "a.id_category3='" . $produk . "'";
			$this->db->where($where);
		}
		if(!empty($search)) {
			$this->db->group_start();
			$this->db->like('a.tgl_transaksi', $search['value'], 'both');
			$this->db->or_like('a.no_surat', $search['value'], 'both');
			$this->db->or_like('a.transaksi', $search['value'], 'both');
			$this->db->or_like('a.id_category3', $search['value'], 'both');	
			$this->db->or_like('b.nama', $search['value'], 'both');
			$this->db->group_end();
		}
		$this->db->order_by('a.created_on', 'desc');
		$this->db->limit($length, $start);
		$query = $this->db->get();

		$this->db->select('a.id_kartu_stok, a.id_category3, a.qty, a.qty_book, a.qty_free, a.transaksi, a.tgl_transaksi, a.no_transaksi, a.id_gudang, a.qty_transaksi, a.qty_akhir, a.qty_book_akhir, a.qty_free_akhir, a.status_transaksi, a.harga_stok, a.harga_do, a.cost_book, a.no_surat, b.nama');
		$this->db->from('kartu_stok a');
		$this->db->join('ms_inventory_category3 b', 'b.id_category3=a.id_category3');
		if ($produk != null) {
			$where = "a.id_category3='" . $produk . "'";
			$this->db->where($where);	
		}
		if(!empty($search)) {
			$this->db->group_start();
			$this->db->like('a.tgl_transaksi', $search['value'], 'both');
			$this->db->or_like('a.no_surat', $search['value'], 'both');
			$this->db->or_like('a.transaksi', $search['value'], 'both');
			$this->db->or_like('a.id_category3', $search['value'], 'both');	
			$this->db->or_like('b.nama', $search['value'], 'both');
			$this->db->group_end();
		}
		$this->db->order_by('a.created_on', 'desc');
		$query_all = $this->db->get();

		$hasil = [];

		$no = 0 + $start;
		foreach ($query->result() as $item) {
			$no++;

			$transaksi_in_out = $item->qty_transaksi;
			if (ucfirst($item->transaksi) == 'Incoming' || ucfirst($item->transaksi) == 'Adjustment plus') {
				$transaksi_in_out = $item->qty_transaksi;
			} else if (ucfirst($item->transaksi) == 'Delivery order' || ucfirst($item->transaksi) == 'Adjustment minus') {
				$transaksi_in_out = ($item->qty_transaksi * -1);
			} else {
				$transaksi_in_out = 0;
			}

			$transaksi_booking = $item->qty_transaksi;
			if (ucfirst($item->transaksi) == 'Sales order') {
				$transaksi_booking = $item->qty_transaksi;
			} else if (ucfirst($item->transaksi) == 'Delivery order') {
				$transaksi_booking = ($item->qty_transaksi * -1);
			} else {
				$transaksi_booking = 0;
			}

			$hasil[] = [
				'no' => $no,
				'tgl_transaksi' => date('d F Y', strtotime($item->tgl_transaksi)),
				'no_transaksi' => $item->no_surat,
				'jenis_transaksi' => ucfirst($item->transaksi),
				'id_produk' => $item->id_category3,
				'produk' => $item->nama,
				'awal_stock' => $item->qty,
				'awal_booking' => $item->qty_book,
				'awal_free_stock' => $item->qty_free,
				'transaksi_in_out' => $transaksi_in_out,
				'transaksi_booking' => $transaksi_booking,
				'akhir_stock' => $item->qty_akhir,
				'akhir_booking' => $item->qty_book_akhir,
				'akhir_free_stock' => $item->qty_free_akhir
			];
		}

		echo json_encode([
			'draw' => intval($draw),
			'recordsTotal' => $query_all->num_rows(),
			'recordsFiltered' => $query_all->num_rows(),
			'data' => $hasil
		]);
	}
}
