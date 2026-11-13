<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
 * @author Harboens
 * @copyright Copyright (c) 2020
 *
 * This is model class for table "Budget Rutin"
 */

class Budget_periodik_model extends BF_Model
{
    /**
     * @var string  User Table Name
     */
    protected $table_name = 'ms_budget_rutin';
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

	// list data
	public function GetBudgetRutinGroup($key=''){
		$sql="select a.departement,b.nm_dept from ".$this->table_name." a left join department b on a.departement=b.id ";
		if($key!='') $sql.=" where a.departement='".$key."' ";
		$sql.=" group by a.departement, b.nm_dept order by b.nm_dept ";
		$query = $this->db->query($sql);
		if($query->num_rows() != 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	/**
	 * Data serverside untuk daftar Budget Pembayaran Periodik (satu baris per departemen).
	 * Hasil sama dengan GetBudgetRutinGroup(): urut nm_dept ASC.
	 */
	public function GetBudgetRutinGroupServerside($request){
		if (!is_array($request)) throw new DomainException('Daftar budget tidak valid.');
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
		$orders = $request['order'] ?? array();
		if (!is_array($orders)) throw new DomainException('Urutan tabel tidak valid.');
		$dir = 'ASC';
		foreach (array_slice($orders, 0, 1) as $order) {
			if (!is_array($order)) throw new DomainException('Urutan tabel tidak valid.');
			if ((int) ($order['column'] ?? -1) !== 1) continue;
			if (!in_array($order['dir'] ?? '', array('asc','desc'), true)) throw new DomainException('Arah urutan tidak valid.');
			$dir = strtoupper($order['dir']);
		}

		$from = ' FROM ' . $this->table_name . ' a LEFT JOIN department b ON a.departement = b.id';
		$where = ''; $binds = array();
		if ($search !== '') {
			$where = " WHERE b.nm_dept LIKE ? ESCAPE '!'";
			$binds[] = '%' . str_replace(array('!','%','_'), array('!!','!%','!_'), $search) . '%';
		}
		$total = (int) $this->listQuery('SELECT COUNT(DISTINCT a.departement) AS total' . $from)->row()->total;
		$filtered = $where === '' ? $total : (int) $this->listQuery('SELECT COUNT(DISTINCT a.departement) AS total' . $from . $where, $binds)->row()->total;
		$rows = $this->listQuery('SELECT a.departement, b.nm_dept' . $from . $where . ' GROUP BY a.departement, b.nm_dept ORDER BY b.nm_dept ' . $dir
			. ' LIMIT ' . $page['length'] . ' OFFSET ' . $page['start'], $binds)->result();
		return array('draw'=>$page['draw'], 'start'=>$page['start'], 'total'=>$total, 'filtered'=>$filtered, 'rows'=>$rows);
	}

	private function listQuery($sql, $binds = array()){
		$query = $this->db->query($sql, $binds);
		if (!$query) throw new RuntimeException('Cannot read budget list');
		return $query;
	}

	public function GetBudgetRutin($key=''){
		$this->db->select('a.*, b.nm_dept, c.nama as nama_perkiraan');
		$this->db->from($this->table_name.' a');
		$this->db->join('department b','a.departement=b.id','left');
		$this->db->join(DBACC.'.coa_master  c','a.coa=c.no_perkiraan','left');
		if($key!='') $this->db->where('a.departement',$key);
		$this->db->order_by('a.coa asc,a.nama');
		$query = $this->db->get();
		if($query->num_rows() != 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	public function GetNewBudgetRutin($divisi){
		$this->db->select('a.*, b.nm_dept, c.nama as nama_perkiraan');
		$this->db->from($this->table_name.' a');
		$this->db->join('department b','a.departement=b.id','left');
		$this->db->join(DBACC.'.coa_master c','a.coa=c.no_perkiraan','left');
		if($divisi!='') $this->db->where('a.departement',$divisi);
		$this->db->order_by('a.coa', 'asc');
		$query = $this->db->get();
		if($query->num_rows() != 0) {
			return $query->result();
		} else {
			return false;
		}

	}

	public function updatebudget($data){
		// Semua nilai lewat binding; nama kolom bulan_N dibatasi 1..12. Hasil SQL sama dengan versi lama.
		$nilai = (float) $data['nilai'];
		$user = $this->auth->user_id();
		$now = date('Y-m-d H:i:s');
		if($data['tipe']=='bulan'){
			$set = array();
			for ($i = 1; $i <= 12; $i++) $set[] = "bulan_$i = (bulan_$i + ?)";
			$binds = array_fill(0, 12, $nilai);
			$binds[] = $nilai * 12; $binds[] = $user; $binds[] = $now; $binds[] = $data['tahun']; $binds[] = $data['coa'];
			$this->db->query("update ms_budget set " . implode(', ', $set) . ", total = ?, created_by_dept = ?, created_on_dept = ? WHERE tahun = ? and coa = ? and kategori = 'PEMBAYARAN PERIODIK'", $binds);
		}
		if($data['tipe']=='tahun'){
			$ts = strtotime('2021-'.$data['tanggal']);
			if ($ts === false) return;
			$bulan = (int) date("n", $ts);
			$this->db->query("update ms_budget set bulan_$bulan = (bulan_$bulan + ?), total = (total + ?), created_by_dept = ?, created_on_dept = ? WHERE tahun = ? and coa = ? and kategori = 'PEMBAYARAN PERIODIK'",
				array($nilai, $nilai, $user, $now, $data['tahun'], $data['coa']));
		}
	}
	// get data
	public function GetDataBudgetRutin($id){
		$this->db->select('a.*');
		$this->db->from($this->table_name.' a');
		$this->db->where('a.id',$id);
		$this->db->order_by('a.department', 'asc');
		$query = $this->db->get();
		if($query->num_rows() != 0) {
			return $query->row();
		} else {
			return false;
		}
	}

}
