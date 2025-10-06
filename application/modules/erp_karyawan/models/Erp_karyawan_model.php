<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * @author Syamsudin
 * @copyright Copyright (c) 2022, Syamsudin
 *
 * This is model class for table "Erp Karyawan"
 */

class Erp_karyawan_model extends BF_Model
{

    /**
     * @var string  User Table Name
     */
    protected $table_name = 'employees';
    protected $key        = 'id';

    /**
     * @var string Field name to use for the created time column in the DB table
     * if $set_created is enabled.
     */
    protected $created_field = 'created';

    /**
     * @var string Field name to use for the modified time column in the DB
     * table if $set_modified is enabled.
     */
    protected $modified_field = 'modified';

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
	function provinsi($id_negara)
    {
        $this->db->where('id_negara', $id_negara);
        $this->db->order_by('id_prov', 'ASC');
        return $this->db->from('provinsi')
            ->get()
            ->result();
    }

	function kota($id_prov)
    {
        $this->db->where('id_prov', $id_prov);
        $this->db->order_by('id_kota', 'ASC');
        return $this->db->from('kota')
            ->get()
            ->result();
    }
	
    function generate_id($kode='') {
      $query = $this->db->query("SELECT MAX(ms_karyawan) as max_id FROM id_karyawan");
      $row = $query->row_array();
      $thn = date('y');
      $max_id = $row['max_id'];
      $max_id1 =(int) substr($max_id,3,5);
      $counter = $max_id1 +1;
      $idkar = "K".$thn.str_pad($counter, 5, "0", STR_PAD_LEFT);
      return $idkar;
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
       return $this->db->get_where('inven_lvl1',array('id_inventory1' => $id))->row_array();
    }

    function get_prov($id){
        $query = $this->db->query("SELECT provinsi FROM customer WHERE id_customer='$id'");
        $row = $query->row_array();
        $provinsi     = $row['provinsi'];
        return $provinsi;
    }
    function get_kota($provinsi){
        $query="SELECT
                kota.id_kota,
                kota.nama,
				kota.id_prov
                FROM kota where id_prov='$provinsi'";
        return $this->db->query($query);
    }
	function getindex(){
		$search = "deleted='0'";
		$this->db->select('a.*, b.cost_center as cost_center ');
		$this->db->from('ms_karyawan a');
		$this->db->join('department_center b','b.id=a.divisi');
		$this->db->where($search);
		$query = $this->db->get();		
		return $query->result();
	}
    function pilih_kota($provinsi){
        $query="SELECT
                kabupaten.id_kab,
                kabupaten.nama
                FROM kabupaten where id_prov='$provinsi'";
        return $this->db->query($query);
    }


    public function getDataEmpl()
	{
		$this->db->select('a.*,b.name as company_name,c.name as department_name,
								d.name as division_name, e.name as title_name,
								f.name as firstcontract,g.name as secondcontract,
								h.name as thirdcontract,i.name as permanent, j.name as position_name');
		$this->db->from('employees a');
		$this->db->join('companies b', 'b.id=a.company_id', 'left');
		$this->db->join('departments c', 'c.id=a.department_id', 'left');
		$this->db->join('divisions d', 'd.id=a.division_id', 'left');
		$this->db->join('titles e', 'e.id=a.title_id', 'left');
		$this->db->join('contracts f', 'f.id=a.firstcontract_id', 'left');
		$this->db->join('contracts g', 'g.id=a.secondcontract_id', 'left');
		$this->db->join('contracts h', 'h.id=a.thirdcontract_id', 'left');
		$this->db->join('contracts i', 'i.id=a.permanent_id', 'left');
		$this->db->join('positions j', 'j.id=a.position_id', 'left');
		$this->db->where(array('a.flag_active' => 'Y'));
		$query = $this->db->get();
		//echo "<pre>";print_r($query->result());
		if ($query->num_rows() != 0) {
			return $query->result();
		} else {
			return false;
		}
	}

    public function Simpan($table, $data)
	{
		return $this->db->insert($table, $data);
	}
	public function getData($table, $where_field = '', $where_value = '')
	{
		if ($where_field != '' && $where_value != '') {
			$query = $this->db->get_where($table, array($where_field => $where_value));
		} else {
			$query = $this->db->get($table);
		}

		return $query->result();
	}

	public function getDataArray($table, $where_field = '', $where_value = '', $keyArr = '', $valArr = '', $where_field2 = '', $where_value2 = '')
	{
		if ($where_field != '' && $where_value != '') {
			$query = $this->db->get_where($table, array($where_field => $where_value));
		}
		if ($where_field2 != '' && $where_value2 != '' && $where_field != '' && $where_value != '') {
			$query = $this->db->get_where($table, array($where_field => $where_value, $where_field2 => $where_value2));
		} else {
			$query = $this->db->get($table);
		}
		$dataArr	= $query->result_array();

		if (!empty($keyArr) && !empty($valArr)) {
			$Arr_Data	= array();
			foreach ($dataArr as $key => $val) {
				$nilai_id				= $val[$keyArr];
				if (empty($valArr)) {
					$Arr_Data[$nilai_id]	= $val;
				} else {
					$Arr_Data[$nilai_id]	= $nilai_id;
				}
			}

			return $Arr_Data;
		} else {
			return $dataArr;
		}
	}

	public function getUpdate($table, $data, $where_field = '', $where_value = '')
	{
		if ($where_field != '' && $where_value != '') {
			$query = $this->db->where(array($where_field => $where_value));
		}
		$result	= $this->db->update($table, $data);
		//echo "<pre>";print_r(result()); 
		return $result;
	}
	public function getDelete($table, $where_field, $where_value)
	{
		$result	= $this->db->delete($table, array($where_field => $where_value));
		return $result;
	}

	public function getMenu($where = array())
	{
		$aMenu		= array();
		if (!empty($where)) {
			$query = $this->db->get_where('menus', $where);
		} else {
			$query = $this->db->get('menus');
		}

		$results	= $query->result_array();
		if ($results) {
			foreach ($results as $key => $vals) {
				$aMenu[$vals['id']]	= $vals['name'];
			}
		}
		return $aMenu;
	}

	public function getDepartments($where = array())
	{
		$aMenu		= array();
		if (!empty($where)) {
			$query = $this->db->get_where('departments', $where);
		} else {
			$query = $this->db->get('departments');
		}

		$results	= $query->result_array();
		if ($results) {
			foreach ($results as $key => $vals) {
				$aMenu[$vals['id']]	= $vals['name'];
			}
		}
		return $aMenu;
	}


	public function getDivisions($where = array())
	{
		$aMenu		= array();
		if (!empty($where)) {
			$query = $this->db->get_where('divisions', $where);
		} else {
			$query = $this->db->get('divisions');
		}

		$results	= $query->result_array();
		if ($results) {
			foreach ($results as $key => $vals) {
				$aMenu[$vals['id']]	= $vals['name'];
			}
		}
		return $aMenu;
	}

	public function getDivisionsHead($where = array())
	{
		$aMenu		= array();
		if (!empty($where)) {
			$query = $this->db->get_where('divisions_head', $where);
		} else {
			$query = $this->db->get('divisions_head');
		}

		$results	= $query->result_array();
		if ($results) {
			foreach ($results as $key => $vals) {
				$aMenu[$vals['id']]	= $vals['name'];
			}
		}
		return $aMenu;
	}

	public function getCompanies($where = array())
	{
		$aMenu		= array();
		if (!empty($where)) {
			$query = $this->db->get_where('companies', $where);
		} else {
			$query = $this->db->get('companies');
		}

		$results	= $query->result_array();
		if ($results) {
			foreach ($results as $key => $vals) {
				$aMenu[$vals['id']]	= $vals['name'];
			}
		}
		return $aMenu;
	}
	public function getEmployees($where = array())
	{
		$aMenu		= array();
		if (!empty($where)) {
			$query = $this->db->get_where('employees', $where);
		} else {
			$query = $this->db->get('employees');
		}

		$results	= $query->result_array();
		if ($results) {
			foreach ($results as $key => $vals) {
				$aMenu[$vals['id']]	= $vals['name'];
			}
		}
		return $aMenu;
	}
	public function getTitles($where = array())
	{
		$aMenu		= array();
		if (!empty($where)) {
			$query = $this->db->get_where('titles', $where);
		} else {
			$query = $this->db->get('titles');
		}

		$results	= $query->result_array();
		if ($results) {
			foreach ($results as $key => $vals) {
				$aMenu[$vals['id']]	= $vals['name'];
			}
		}
		return $aMenu;
	}
	public function getPositions($where = array())
	{
		$aMenu		= array();
		if (!empty($where)) {
			$query = $this->db->get_where('positions', $where);
		} else {
			$query = $this->db->get('positions');
		}

		$results	= $query->result_array();
		if ($results) {
			foreach ($results as $key => $vals) {
				$aMenu[$vals['id']]	= $vals['name'];
			}
		}
		return $aMenu;
	}
	public function getMarital($where = array())
	{
		$aMenu		= array();
		if (!empty($where)) {
			$query = $this->db->get_where('marital_status', $where);
		} else {
			$query = $this->db->get('marital_status');
		}

		$results	= $query->result_array();
		if ($results) {
			foreach ($results as $key => $vals) {
				$aMenu[$vals['code']]	= $vals['name'];
			}
		}
		return $aMenu;
	}
	public function getContract($where = array())
	{
		$aMenu		= array();
		if (!empty($where)) {
			$query = $this->db->get_where('contracts', $where);
		} else {
			$query = $this->db->get('contracts');
		}

		$results	= $query->result_array();
		if ($results) {
			foreach ($results as $key => $vals) {
				$aMenu[$vals['id']]	= $vals['name'];
			}
		}
		return $aMenu;
	}
	public function getIdfinger($where = array())
	{
		$aMenu		= array();
		if (!empty($where)) {

			$this->db->distinct();
			$query = $this->db->get_where('fingerprint_data', $where);
		} else {

			$this->db->distinct();
			$query = $this->db->get('fingerprint_data');
		}

		$results	= $query->result_array();
		if ($results) {
			foreach ($results as $key => $vals) {
				$aMenu[$vals['name']]	= $vals['name'];
			}
		}
		return $aMenu;
	}
	public function getPolicy($where = array())
	{
		$aMenu		= array();
		if (!empty($where)) {
			$query = $this->db->get_where('ms_policy', $where);
		} else {
			$query = $this->db->get('ms_policy');
		}

		$results	= $query->result_array();
		if ($results) {
			foreach ($results as $key => $vals) {
				$aMenu[$vals['id']]	= $vals['name'];
			}
		}
		return $aMenu;
	}
	public function optionDivisions($where = array())
	{
		$result = array();
		$query = $this->db->get_where('divisions', $where);
		$results	= $query->result_array();
		if ($results) {

			foreach ($results as $key => $vals) {
				$option[0]	= 'pilih';
				$option[$vals['id']]	= $vals['name'];
			}
		}

		return $option;
	}
	public function tampil($where, $table)
	{
		return $this->db->get_where($table, $where);
	}

	public function getArray($table, $WHERE = array(), $keyArr = '', $valArr = '')
	{
		if ($WHERE) {
			$query = $this->db->get_where($table, $WHERE);
		} else {
			$query = $this->db->get($table);
		}
		$dataArr	= $query->result_array();

		if (!empty($keyArr)) {
			$Arr_Data	= array();
			foreach ($dataArr as $key => $val) {
				$nilai_id					= $val[$keyArr];
				if (!empty($valArr)) {
					$nilai_val				= $val[$valArr];
					$Arr_Data[$nilai_id]	= $nilai_val;
				} else {
					$Arr_Data[$nilai_id]	= $val;
				}
			}

			return $Arr_Data;
		} else {
			return $dataArr;
		}
	}

	public function companies()
	{
		$aMenu		= array();

		$query = $this->db->get('companies');


		$results	= $query->result_array();
		if ($results) {
			foreach ($results as $key => $vals) {
				$aMenu[$vals['id']]	= $vals['name'];
			}
		}
		return $aMenu;
	}

    function code_otomatis($table, $pre)
	{
		$this->db->select('Right(id,4) as kode ', false);
		$this->db->order_by('id', 'desc');
		$this->db->limit(1);
		$query = $this->db->get($table);

		if ($query->num_rows() <> 0) {
			$data = $query->row();
			$kode = intval($data->kode) + 1;
		} else {
			$kode = 1;
		}
		$kodemax = str_pad($kode, 4, "0", STR_PAD_LEFT);
		$kodediv  = "$pre" . $kodemax;
		return $kodediv;
	}
	function code_otomatisNik($table, $pre, $mid)
	{
		$today = date('Ym');
		$this->db->select('Right(nik,3) as kode ', false);
		$this->db->like('nik', $today);
		$this->db->order_by('nik', 'desc');
		$this->db->limit(1);
		$query = $this->db->get($table);
		if ($query->num_rows() <> 0) {
			$data = $query->row();
			$kode = intval($data->kode) + 1;
		} else {
			$kode = 1;
		}
		$kodemax = str_pad($kode, 3, "0", STR_PAD_LEFT);
		$kodediv  = "$pre" . "$mid" . $kodemax;
		return $kodediv;
	}

}
