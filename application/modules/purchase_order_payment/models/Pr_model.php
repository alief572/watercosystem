<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * @author Syamsudin
 * @copyright Copyright (c) 2022, Syamsudin
 *
 * This is model class for table "Pr_model"
 */

class Pr_model extends BF_Model
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
		
    function generate_code($kode='') {
      $query = $this->db->query("SELECT MAX(no_po) as max_id FROM tr_purchase_order");
      $row = $query->row_array();
      $thn = date('y');
      $max_id = $row['max_id'];
      $max_id1 =(int) substr($max_id,3,5);
      $counter = $max_id1 +1;
      $idcust = "P".$thn.str_pad($counter, 5, "0", STR_PAD_LEFT);
      return $idcust;
	}
	function BuatNomor($kode='') {
	$bulan = date('m');
	$tahun = date('Y');
		$blnthn = date('Y-m');
      $query = $this->db->query("SELECT MAX(no_surat) as max_id FROM tr_purchase_order WHERE month(tanggal)='$bulan' and Year(tanggal)='$tahun'");
      $row = $query->row_array();
      $thn = date('T');
      $max_id = $row['max_id'];
      $max_id1 =(int) substr($max_id,-13,3);
      $counter = $max_id1 +1;
      $idcust = "PO-".sprintf("%03s",$counter)."/MP/".$bulan."/".$tahun;
      return $idcust;
	}
	
	
	public function CariPenawaran(){
		$this->db->select('a.*, b.name_customer as name_customer');
		$this->db->from('tr_penawaran a');
		$this->db->join('master_customers b','b.id_customer=a.id_customer');
		$this->db->order_by('a.no_penawaran', 'DESC');
		$query = $this->db->get();	
		return $query->result();
	}
	
	public function getHeaderPenawaran($id){
		$this->db->select('a.*, b.name_customer as name_customer, b.address_office as address_office, b.telephone as telephone,b.fax as fax');
		$this->db->from('tr_penawaran a');
		$this->db->join('master_customers b','b.id_customer=a.id_customer');
		$this->db->where('a.no_penawaran',$id);
		$query = $this->db->get();	
		return $query->result();
	}
		public function PrintDetail($id){
		$this->db->select('a.*, b.nama as nama3,b.hardness as hardness, c.nama as nama2 , d.nilai_dimensi as nilai');
		$this->db->from('child_penawaran a');
		$this->db->join('ms_inventory_category3 b','b.id_category3=a.id_category3');
		$this->db->join('ms_inventory_category2 c','c.id_category2=b.id_category2');
		$this->db->join('child_inven_dimensi d','d.id_category3=a.id_category3');
		$this->db->where('a.no_penawaran',$id);
		$query = $this->db->get();	
		return $query->result();
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

 	public function get_data($table,$where_field='',$where_value=''){
		if($where_field !='' && $where_value!=''){
			$query = $this->db->get_where($table, array($where_field=>$where_value));
		}else{
			$query = $this->db->get($table);
		}
		
		return $query->result();
	}
	
    function getById($id)
    {
       return $this->db->get_where('inven_lvl2',array('id_inventory2' => $id))->row_array();
    }

	public function get_data_category(){
		$search = "a.deleted='0'";
		$this->db->select('a.*, b.nama as nama_category2, c.nilai_dimensi as nilai_dimensi,d.nm_bentuk as nm_bentuk');
		$this->db->from('ms_inventory_category3 a');
		$this->db->join('ms_inventory_category2 b','b.id_category2 =a.id_category2');
		$this->db->join('child_inven_dimensi c','c.id_category3 =a.id_category3');
		$this->db->join('ms_bentuk d','d.id_bentuk =a.id_bentuk');
		$this->db->where($search);
		$query = $this->db->get();		
		return $query->result();
	}
	
	public function getpenawaran($id){
		$search = "a.no_penawaran='$id' ";
		$this->db->select('a.*, b.nama as nama_category3, b.hardness as hardness, c.nama as nama_category2, d.nilai_dimensi as thickness');
		$this->db->from('child_penawaran a');
		$this->db->join('ms_inventory_category3 b','b.id_category3 =a.id_category3');
		$this->db->join('ms_inventory_category2 c','c.id_category2 =b.id_category2');
		$this->db->join('child_inven_dimensi d','d.id_category3 =b.id_category3');
		$this->db->where('a.no_penawaran',$id);
		$query = $this->db->get();		
		return $query->result();
	}
	
	public function getview($id){
		$this->db->select('a.*, b.nama as nama_type, c.nama as nama_category1, d.nama as nama_category2');
		$this->db->from('ms_inventory_category3 a');
		$this->db->join('ms_inventory_type b','b.id_type=a.id_type');
		$this->db->join('ms_inventory_category1 c','c.id_category1 =a.id_category1');
		$this->db->join('ms_inventory_category2 d','d.id_category2 =a.id_category2');
		$this->db->where('a.id_category3',$id);
		$query = $this->db->get();		
		return $query->result();
	}
	
	public function get_child_compotition($id){
		$this->db->select('a.*, b.name_compotition as name_compotition');
		$this->db->from('dt_material_compotition a');
		$this->db->join('ms_material_compotition b','b.id_compotition=a.id_compotition');
		$this->db->where('a.id_category3',$id);
		$query = $this->db->get();		
		return $query->result();
	}
	public function get_child_dimention($id){
		$this->db->select('a.*, b.dimensi_bentuk as dimensi_bentuk');
		$this->db->from('dt_material_dimensi a');
		$this->db->join('child_dimensi_bentuk b','b.id_dimensi_bentuk=a.id_dimensi_bentuk');
		$this->db->where('a.id_category3',$id);
		$query = $this->db->get();		
		return $query->result();
	}
	public function get_child_suplier($id){
		$this->db->select('a.*, b.name_supplier as name_supplier');
		$this->db->from('dt_material_supplier a');
		$this->db->join('master_supplier b','b.id_supplier=a.id_supplier');
		$this->db->where('a.id_category3',$id);
		$query = $this->db->get();		
		return $query->result();
	}
	
	public function getSpek($id){
		$this->db->select('a.*, b.name_compotition as name_compotition');
		$this->db->from('dt_material_compotition a');
		$this->db->join('ms_material_compotition b','b.id_compotition = a.id_compotition');
		$this->db->where('a.id_category3',$id);
		$query = $this->db->get();		
		return $query->result();
	}

	public function cariPurchaserequest(){
		$this->db->select('a.*');
		$this->db->from('tr_purchase_request a');
		$this->db->where('status_po','OPN');
		$query = $this->db->get();		
		return $query->result();
	}

	
	function get_where_in($field,$kunci,$tabel){
		$this->db->where_in($field,$kunci);
		$query=$this->db->get($tabel);
		return $query->result();
	}
	
	function get_where_in_and($field,$kunci,$and,$tabel){
		$this->db->where_in($field,$kunci);
		$this->db->where($and);
		$query=$this->db->get($tabel);
		return $query->result();
	}

    public function getIndexData($mode, $request)
    {
        $filters = array(
            'request'=>"a.status_bayar = 'OPN' AND b.status = '2' AND a.approve_bayar <> '1' AND a.status_jurnal = 'CLS' AND a.rencana_bayar_idr < 1",
            'approval'=>"a.status_bayar = 'OPN' AND b.status = '2' AND a.request_bayar = '1' AND a.approve_bayar = '0'",
            'payment'=>"a.status_bayar = 'OPN' AND b.status = '2' AND a.approve_bayar = '1'"
        );
        if (!isset($filters[$mode]) || !is_array($request)) throw new DomainException('Daftar pembayaran tidak valid.');
        $page = array();
        foreach (array('draw'=>0, 'start'=>0, 'length'=>10) as $key=>$default) {
            $page[$key] = filter_var($request[$key] ?? $default, FILTER_VALIDATE_INT);
            if ($page[$key] === false || ($key === 'length' ? ($page[$key] < 1 && $page[$key] !== -1) : $page[$key] < 0)) {
                throw new DomainException('Parameter ' . $key . ' tidak valid.');
            }
        }
        $page['length'] = $page['length'] === -1 ? 100 : min(100, $page['length']);
        $search = $request['search'] ?? array();
        if (!is_array($search)) throw new DomainException('Pencarian tidak valid.');
        $search = $search['value'] ?? '';
        $size = is_string($search) ? preg_match_all('/./us', $search) : false;
        if ($size === false || $size > 255) throw new DomainException('Pencarian maksimal 255 karakter.');
        $usd = "CASE WHEN LOWER(a.matauang) = 'usd' THEN COALESCE(a.hutang_kurs,0) ELSE 0 END";
        $rate = "CASE WHEN LOWER(a.matauang) = 'usd' THEN COALESCE(a.kurs,0) ELSE 0 END";
        $columns = array(1=>'a.id_incoming', 2=>'a.tanggal', 3=>'c.name_suplier', 4=>$usd, 5=>$rate, 6=>'a.hutang_idr');
        $orders = $request['order'] ?? array();
        if (!is_array($orders)) throw new DomainException('Urutan tabel tidak valid.');
        $sort = array();
        foreach (array_slice($orders, 0, 6) as $order) {
            if (!is_array($order)) throw new DomainException('Urutan tabel tidak valid.');
            $column = filter_var($order['column'] ?? '', FILTER_VALIDATE_INT);
            if (!isset($columns[$column])) continue;
            if (!in_array($order['dir'] ?? '', array('asc','desc'), true)) throw new DomainException('Arah urutan tidak valid.');
            $sort[] = $columns[$column] . ' ' . strtoupper($order['dir']);
        }
        $sort[] = 'a.no_po DESC'; $sort[] = 'a.id DESC';
        $from = ' FROM tr_incoming a INNER JOIN tr_purchase_order b ON a.no_po = b.no_po INNER JOIN master_supplier c ON b.id_suplier = c.id_suplier';
        $base = ' WHERE ' . $filters[$mode];
        $where = ''; $binds = array();
        if ($search !== '') {
            $needle = '%' . str_replace(array('!','%','_'), array('!!','!%','!_'), $search) . '%';
            $parts = array();
            foreach (array('a.no_po', 'b.no_surat', 'a.id_incoming', 'a.tanggal', "DATE_FORMAT(a.tanggal,'%d-%b-%Y')",
                'c.name_suplier', $usd, $rate, 'a.hutang_idr', 'FORMAT(' . $usd . ',2)', 'FORMAT(' . $rate . ',2)', 'FORMAT(a.hutang_idr,2)') as $field) {
                $parts[] = $field . " LIKE ? ESCAPE '!'";
                $binds[] = $needle;
            }
            $where = ' AND (' . implode(' OR ', $parts) . ')';
        }
        $total = (int)$this->paymentIndexQuery('SELECT COUNT(*) AS total' . $from . $base)->row()->total;
        $filtered = $where === '' ? $total : (int)$this->paymentIndexQuery('SELECT COUNT(*) AS total' . $from . $base . $where, $binds)->row()->total;
        $rows = $this->paymentIndexQuery('SELECT a.id, a.no_po, a.id_data, a.id_incoming, a.tanggal, c.name_suplier AS namesup, '
            . $usd . ' AS hutang_usd, ' . $rate . ' AS kurs, a.hutang_idr' . $from . $base . $where
            . ' ORDER BY ' . implode(', ', $sort) . ' LIMIT ' . $page['length'] . ' OFFSET ' . $page['start'], $binds)->result();
        return array('draw'=>$page['draw'], 'start'=>$page['start'], 'total'=>$total, 'filtered'=>$filtered, 'rows'=>$rows);
    }

    /**
     * Data serverside untuk index Jurnal Pembayaran PO: semua pembayaran; tombol jurnal hanya untuk yang belum dijurnal.
     * LEFT JOIN ke PO supaya pembayaran tanpa PO tetap tampil.
     */
    public function getJurnalPoData($request)
    {
        if (!is_array($request)) throw new DomainException('Daftar jurnal tidak valid.');
        $page = array();
        foreach (array('draw'=>0, 'start'=>0, 'length'=>10) as $key=>$default) {
            $page[$key] = filter_var($request[$key] ?? $default, FILTER_VALIDATE_INT);
            if ($page[$key] === false || ($key === 'length' ? ($page[$key] < 1 && $page[$key] !== -1) : $page[$key] < 0)) {
                throw new DomainException('Parameter ' . $key . ' tidak valid.');
            }
        }
        $page['length'] = $page['length'] === -1 ? 100 : min(100, $page['length']);
        $search = $request['search'] ?? array();
        if (!is_array($search)) throw new DomainException('Pencarian tidak valid.');
        $search = $search['value'] ?? '';
        $size = is_string($search) ? preg_match_all('/./us', $search) : false;
        if ($size === false || $size > 255) throw new DomainException('Pencarian maksimal 255 karakter.');
        $columns = array(1=>'a.kd_pembayaran', 2=>'a.id_incoming', 3=>'a.tgl_pembayaran', 4=>'a.nama_supplier', 5=>'a.jumlah_hutang',
            6=>'a.jumlah_hutang_idr', 7=>'a.kurs_bayar', 8=>'a.jumlah_pembayaran', 9=>'a.jumlah_pembayaran_idr', 10=>'a.status_jurnal');
        $orders = $request['order'] ?? array();
        if (!is_array($orders)) throw new DomainException('Urutan tabel tidak valid.');
        $sort = array();
        foreach (array_slice($orders, 0, 6) as $order) {
            if (!is_array($order)) throw new DomainException('Urutan tabel tidak valid.');
            $column = filter_var($order['column'] ?? '', FILTER_VALIDATE_INT);
            if (!isset($columns[$column])) continue;
            if (!in_array($order['dir'] ?? '', array('asc','desc'), true)) throw new DomainException('Arah urutan tidak valid.');
            $sort[] = $columns[$column] . ' ' . strtoupper($order['dir']);
        }
        if (!$sort) $sort[] = 'a.created_on DESC';
        $sort[] = 'a.id DESC';
        $from = ' FROM tr_po_payment a LEFT JOIN tr_purchase_order b ON b.no_po = a.no_po';
        $where = ''; $binds = array();
        if ($search !== '') {
            $needle = '%' . str_replace(array('!','%','_'), array('!!','!%','!_'), $search) . '%';
            $parts = array();
            foreach (array('a.kd_pembayaran', 'a.id_incoming', 'a.nama_supplier', 'a.no_po') as $field) {
                $parts[] = $field . " LIKE ? ESCAPE '!'";
                $binds[] = $needle;
            }
            $where = ' WHERE (' . implode(' OR ', $parts) . ')';
        }
        $total = (int)$this->paymentIndexQuery('SELECT COUNT(*) AS total FROM tr_po_payment')->row()->total;
        $filtered = $where === '' ? $total : (int)$this->paymentIndexQuery('SELECT COUNT(*) AS total' . $from . $where, $binds)->row()->total;
        $rows = $this->paymentIndexQuery('SELECT a.id, a.kd_pembayaran, a.id_incoming, a.tgl_pembayaran, a.nama_supplier, a.jumlah_hutang, a.jumlah_hutang_idr, '
            . 'a.kurs_bayar, a.jumlah_pembayaran, a.jumlah_pembayaran_idr, a.status_jurnal' . $from . $where
            . ' ORDER BY ' . implode(', ', $sort) . ' LIMIT ' . $page['length'] . ' OFFSET ' . $page['start'], $binds)->result();
        return array('draw'=>$page['draw'], 'start'=>$page['start'], 'total'=>$total, 'filtered'=>$filtered, 'rows'=>$rows);
    }

    private function paymentIndexQuery($sql, $binds = array())
    {
        $query = $this->db->query($sql, $binds);
        if (!$query) throw new RuntimeException('Cannot read payment table');
        return $query;
    }

    public function generate_nopn($tgl)
    {
        $date = is_string($tgl) ? DateTimeImmutable::createFromFormat('!Y-m-d', $tgl) : false;
        if (!$date || $date->format('Y-m-d') !== $tgl) throw new DomainException('Tanggal pembayaran tidak valid.');
        $prefix = 'PB-' . $date->format('y') . chr(64 + (int)$date->format('n'));
        $query = $this->db->query('SELECT MAX(CAST(SUBSTRING(kd_pembayaran, 7) AS UNSIGNED)) AS max_id FROM tr_po_payment WHERE kd_pembayaran REGEXP ?',
            array('^' . $prefix . '[0-9]+$'));
        if (!$query) throw new RuntimeException('Cannot read payment counter');
        $next = (int)$query->row()->max_id + 1;
        if ($next > 99999) throw new DomainException('Kapasitas nomor pembayaran sudah habis.');
        return $prefix . sprintf('%05d', $next);
    }
}
