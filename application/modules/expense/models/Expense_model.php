<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
 * @author Harboens
 * @copyright Copyright (c) 2020
 *
 * This is model class for table "Purchase Request"
 */

class Expense_model extends BF_Model
{
    /**
     * @var string  User Table Name
     */
    protected $table_name = 'tr_expense';
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

	// list data kasbon
	public function GetListDataKasbon($where=''){
		$this->db->select('a.*, c.name as nmuser');
		$this->db->from(DBERP.'.tr_kasbon a');
		$this->db->join('users b','a.nama=b.username','left');
		$this->db->join('employees c','b.employee_id=c.id');
		if($where!='') $this->db->where($where);
		$this->db->order_by('a.id', 'desc');
		$query = $this->db->get();
		if($query->num_rows() != 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	// get data kasbon
	public function GetDataKasbon($id){
		$this->db->select('a.*');
		$this->db->from('tr_kasbon a');
		$this->db->where('a.id',$id);
		$query = $this->db->get();
		if($query->num_rows() != 0) {
			return $query->row();
		} else {
			return false;
		}
	}

	// list data transport request
	public function GetListDataTransportRequest($id_user='',$where=''){
		$this->db->select('a.*, b.name as nmuser');
		$this->db->from(DBERP.'.tr_transport_req a');
		$this->db->join('(select users.username,employees.name from users join employees on users.employee_id=employees.id)b','a.created_by=b.username','left');
		if($id_user!='') $this->db->where('a.created_by',$id_user);
		if($where!='') $this->db->where($where);
		$this->db->order_by('a.id', 'desc');
		$query = $this->db->get();
		if($query->num_rows() != 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	// get data transport req
	public function GetDataTransportReq($id){
		$this->db->select('a.*');
		$this->db->from('tr_transport_req a');
		$this->db->where('a.id',$id);
		$query = $this->db->get();
		if($query->num_rows() != 0) {
			return $query->row();
		} else {
			return false;
		}
	}

	// get data transport req detail
	public function GetDataTransportInReq($id){
		$this->db->select('a.*');
		$this->db->from('tr_transport a');
		$this->db->where('a.no_req',$id);
		$query = $this->db->get();
		if($query->num_rows() != 0) {
			return $query->result();
		} else {
			return false;
		}
	}


	// list data transport
	public function GetListDatatransport($id_user=''){
		$this->db->select('a.*, b.name as nmuser');
		$this->db->from(DBERP.'.tr_transport a');
		$this->db->join('(select users.username,employees.name from users join employees on users.employee_id=employees.id)b','a.nama=b.username','left');
		if($id_user!='') $this->db->where('a.nama',$id_user);
		$this->db->order_by('a.id', 'desc');
		$query = $this->db->get();
		if($query->num_rows() != 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	// get data transport
	public function GetDataTransport($id){
		$this->db->select('a.*');
		$this->db->from('tr_transport a');
		$this->db->where('a.id',$id);
		$query = $this->db->get();
		if($query->num_rows() != 0) {
			return $query->row();
		} else {
			return false;
		}
	}

	// list data
	public function GetListData($where=''){
		$this->db->select('a.*, b.username as nmuser, c.username as nmapproval');
		$this->db->from(DBERP.'.'.$this->table_name.' a');
		$this->db->join('users b','a.nama=b.username','left');
		$this->db->join('users c','a.approval=c.username','left');
		if($where!='') $this->db->where($where);
		$this->db->order_by('a.id', 'desc');
		$query = $this->db->get();
		if($query->num_rows() != 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	/**
	 * Data serverside untuk daftar Expense (Expense, Petty Cash, Expense List, Approval).
	 * $filter: 'index' | 'petty_cash' | 'list_all' | 'approval'. $user = username login (untuk index/petty_cash).
	 * Hasil sama dengan GetListData() + filter lama; urutan default a.id DESC.
	 */
	public function GetListDataServerside($filter, $user, $request){
		$conditions = array(
			'index'      => array('a.nama = ? AND a.pettycash IS NULL', array((string) $user)),
			'petty_cash' => array("a.nama = ? AND a.pettycash <> ''", array((string) $user)),
			'list_all'   => array('1 = 1', array()),
			'approval'   => array('a.status = 0', array()),
		);
		if (!isset($conditions[$filter]) || !is_array($request)) throw new DomainException('Daftar expense tidak valid.');
		list($baseWhere, $baseBinds) = $conditions[$filter];

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

		// Kolom 1..: No Dokumen, Tanggal, Nama, Approval, Keterangan, [Jumlah], Status. Approval: tanpa kolom Approval dan Jumlah.
		$maps = array(
			'index'      => array(1=>'a.no_doc', 2=>'a.tgl_doc', 3=>'b.username', 4=>'c.username', 5=>'a.informasi', 6=>'a.jumlah', 7=>'a.status'),
			'list_all'   => array(1=>'a.no_doc', 2=>'a.tgl_doc', 3=>'b.username', 4=>'c.username', 5=>'a.informasi', 6=>'a.jumlah', 7=>'a.status'),
			'petty_cash' => array(1=>'a.no_doc', 2=>'a.tgl_doc', 3=>'b.username', 4=>'c.username', 5=>'a.informasi', 6=>'a.status'),
			'approval'   => array(1=>'a.no_doc', 2=>'a.tgl_doc', 3=>'b.username', 4=>'a.informasi', 5=>'a.status'),
		);
		$columns = $maps[$filter];
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
		$sort[] = 'a.id DESC';

		$from = ' FROM ' . DBERP . '.' . $this->table_name . ' a LEFT JOIN users b ON a.nama = b.username LEFT JOIN users c ON a.approval = c.username';
		$where = ' WHERE ' . $baseWhere;
		$binds = $baseBinds;
		$searchSql = ''; $searchBinds = array();
		if ($search !== '') {
			$needle = '%' . str_replace(array('!','%','_'), array('!!','!%','!_'), $search) . '%';
			$parts = array();
			foreach (array('a.no_doc', 'a.tgl_doc', 'b.username', 'c.username', 'a.informasi') as $field) {
				$parts[] = $field . " LIKE ? ESCAPE '!'";
				$searchBinds[] = $needle;
			}
			$searchSql = ' AND (' . implode(' OR ', $parts) . ')';
		}

		$total = (int) $this->listQuery('SELECT COUNT(*) AS total' . $from . $where, $binds)->row()->total;
		$filtered = $searchSql === '' ? $total : (int) $this->listQuery('SELECT COUNT(*) AS total' . $from . $where . $searchSql, array_merge($binds, $searchBinds))->row()->total;
		$rows = $this->listQuery('SELECT a.id, a.no_doc, a.tgl_doc, a.informasi, a.jumlah, a.status, b.username AS nmuser, c.username AS nmapproval'
			. $from . $where . $searchSql . ' ORDER BY ' . implode(', ', $sort) . ' LIMIT ' . $page['length'] . ' OFFSET ' . $page['start'],
			array_merge($binds, $searchBinds))->result();
		return array('draw'=>$page['draw'], 'start'=>$page['start'], 'total'=>$total, 'filtered'=>$filtered, 'rows'=>$rows);
	}

	private function listQuery($sql, $binds = array()){
		$query = $this->db->query($sql, $binds);
		if (!$query) throw new RuntimeException('Cannot read expense list');
		return $query;
	}

	// get data
	public function GetDataHeader($id){
		$this->db->select('a.*');
		$this->db->from($this->table_name.' a');
		$this->db->where('a.id',$id);
		$query = $this->db->get();
		if($query->num_rows() != 0) {
			return $query->row();
		} else {
			return false;
		}
	}

	public function GetDataDetail($id){
		$this->db->select('a.*');
		$this->db->from('tr_expense_detail a');
		$this->db->where('a.no_doc',$id);
		$query = $this->db->get();
		if($query->num_rows() != 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function GetDetailPurchaseRequest($id){
		$this->db->select('a.*');
		$this->db->from('tr_expense_detail a');
		$this->db->where('a.id',$id);
		$query = $this->db->get();
		if($query->num_rows() != 0) {
			return $query->row();
		} else {
			return false;
		}
	}

	public function GetBudget($coa,$tahun){
		$this->db->select('a.*');
		$this->db->from('ms_budget a');
		$this->db->where('a.coa',$coa);
		$this->db->where('a.tahun',$tahun);
		$query = $this->db->get();
		if($query->num_rows() != 0) {
			return $query->row();
		} else {
			return false;
		}
	}

	public function GetBudgetDivisi($type,$divisi,$tahun){
		$this->db->select('a.*');
		$this->db->from('ms_coa_budget a');
		$this->db->where('a.coa',$type);
		$this->db->where('a.divisi',$divisi);
		$this->db->where('a.tahun',$tahun);
		$query = $this->db->get();
		if($query->num_rows() != 0) {
			return $query->row();
		} else {
			return false;
		}
	}

	public function Update_budget($coa,$tgl,$nilai,$divisi,$nilai_pr=0){
		$bulan=date("n",strtotime($tgl));
		$tahun=date("Y",strtotime($tgl));

		$this->db->select('a.*');
		$this->db->from('ms_coa_budget a');
		$this->db->where('a.coa', $coa);
		$this->db->where('a.tahun', $tahun);
		$this->db->where('a.divisi', $divisi);
		$query = $this->db->get();
		if($query->num_rows() != 0) {
			$data=$query->row();
			$terpakai_bulan=$data->{"terpakai_bulan_".$bulan};
			$terpakai=$data->terpakai;
			$sisa=$data->sisa;
			$idbudget=$data->id;
			$upd_terpakai_bulan=($terpakai_bulan+$nilai-$nilai_pr);
			$upd_terpakai=($terpakai+$nilai-$nilai_pr);
			$upd_sisa=($sisa-$nilai+$nilai_pr);
			$this->db->query("update ms_coa_budget set terpakai_bulan_".$bulan."=".$upd_terpakai_bulan.", terpakai=".$upd_terpakai.", sisa=".$upd_sisa." where id=".$idbudget." and coa='".$coa."' and tahun='".$tahun."'");
			return true;
		} else {
			return false;
		}
	}

}
