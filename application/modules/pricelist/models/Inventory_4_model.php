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
		
    function generate_codefr($kode='') {
      $query = $this->db->query("SELECT MAX(id_pricelistfr) as max_id FROM ms_pricelistfr");
      $row = $query->row_array();
      $thn = date('y');
      $max_id = $row['max_id'];
      $max_id1 =(int) substr($max_id,3,5);
      $counter = $max_id1 +1;
      $idcust = "P".$thn.str_pad($counter, 5, "0", STR_PAD_LEFT);
      return $idcust;
	}
	
	function generate_codenfr($kode='') {
      $query = $this->db->query("SELECT MAX(id_pricelistnfr) as max_id FROM ms_pricelistnfr");
      $row = $query->row_array();
      $thn = date('y');
      $max_id = $row['max_id'];
      $max_id1 =(int) substr($max_id,3,5);
      $counter = $max_id1 +1;
      $idcust = "P".$thn.str_pad($counter, 5, "0", STR_PAD_LEFT);
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

    public function get_data_categoryfr(){
		$this->db->select('a.*, b.nama as nama3, b.hardness as hardness, c.nama as nama2, d.nilai_dimensi as nilai_dimensi ');
		$this->db->from('ms_pricelistfr a');
		$this->db->join('ms_inventory_category3 b','b.id_category3 =a.id_category3');
		$this->db->join('ms_inventory_category2 c','b.id_category2 =c.id_category2');
		$this->db->join('child_inven_dimensi d','b.id_category3 =d.id_category3');
		$query = $this->db->get();		
		return $query->result();
	}
	    public function get_data_category($id_category1){
		$search = "a.deleted='0' and a.id_category1='$id_category1'";
		$this->db->select('a.*, b.nama as nama_type, c.nama as nama_category1, d.nama as nama_category2, e.nilai_dimensi as nilai_dimensi');
		$this->db->from('ms_inventory_category3 a');
		$this->db->join('ms_inventory_type b','b.id_type=a.id_type');
		$this->db->join('ms_inventory_category1 c','c.id_category1 =a.id_category1');
		$this->db->join('ms_inventory_category2 d','d.id_category2 =a.id_category2');
		$this->db->join('child_inven_dimensi e','e.id_category3 =a.id_category3');
		$this->db->where($search);
		$query = $this->db->get();		
		return $query->result();
	}
	public function getavg10cu(){
		$hariini = date('Y-m-d H:i:s');
		$sepuluh_hari = mktime(0,0,0,date('n'),date('j')-10,date('Y'));
		$tendays = date("Y-m-d H:i:s", $sepuluh_hari);
		$search = "id_compotition='13' and created_on between '$hariini' and '$tendays' ";
		$this->db->select_avg('nominal');
		$this->db->from('child_history_lme');
		$this->db->where($search);
		$query = $this->db->get();		
		return $query->result();
	}
		public function getavg10zn(){
		$hariini = date('Y-m-d H:i:s');
		$sepuluh_hari = mktime(0,0,0,date('n'),date('j')-10,date('Y'));
		$tendays = date("Y-m-d H:i:s", $sepuluh_hari);
		$search = "id_compotition='14' and created_on between '$hariini' and '$tendays' ";
		$this->db->select_avg('nominal');
		$this->db->from('child_history_lme');
		$this->db->where($search);
		$query = $this->db->get();		
		return $query->result();
	}
		public function getavg10sn(){
		$hariini = date('Y-m-d H:i:s');
		$sepuluh_hari = mktime(0,0,0,date('n'),date('j')-10,date('Y'));
		$tendays = date("Y-m-d H:i:s", $sepuluh_hari);
		$search = "id_compotition='15' and created_on between '$hariini' and '$tendays' ";
		$this->db->select_avg('nominal');
		$this->db->from('child_history_lme');
		$this->db->where($search);
		$query = $this->db->get();		
		return $query->result();
	}
		public function getavg10ni(){
		$hariini = date('Y-m-d H:i:s');
		$sepuluh_hari = mktime(0,0,0,date('n'),date('j')-10,date('Y'));
		$tendays = date("Y-m-d H:i:s", $sepuluh_hari);
		$search = "id_compotition='16' and created_on between '$hariini' and '$tendays' ";
		$this->db->select_avg('nominal');
		$this->db->from('child_history_lme');
		$this->db->where($search);
		$query = $this->db->get();		
		return $query->result();
	}
			public function getavg10ag(){
		$hariini = date('Y-m-d H:i:s');
		$sepuluh_hari = mktime(0,0,0,date('n'),date('j')-10,date('Y'));
		$tendays = date("Y-m-d H:i:s", $sepuluh_hari);
		$search = "id_compotition='17' and created_on between '$hariini' and '$tendays' ";
		$this->db->select_avg('nominal');
		$this->db->from('child_history_lme');
		$this->db->where($search);
		$query = $this->db->get();		
		return $query->result();
	}
			public function getavg10al(){
		$hariini = date('Y-m-d H:i:s');
		$sepuluh_hari = mktime(0,0,0,date('n'),date('j')-10,date('Y'));
		$tendays = date("Y-m-d H:i:s", $sepuluh_hari);
		$search = "id_compotition='18' and created_on between '$hariini' and '$tendays' ";
		$this->db->select_avg('nominal');
		$this->db->from('child_history_lme');
		$this->db->where($search);
		$query = $this->db->get();		
		return $query->result();
	}
	
    public function get_data_categorynfr(){
		$this->db->select('a.*, b.nama as nama3, b.hardness as hardness, c.nama as nama2, d.nilai_dimensi as nilai_dimensi ');
		$this->db->from('ms_pricelistnfr a');
		$this->db->join('ms_inventory_category3 b','b.id_category3 =a.id_category3');
		$this->db->join('ms_inventory_category2 c','b.id_category2 =c.id_category2');
		$this->db->join('child_inven_dimensi d','b.id_category3 =d.id_category3');
		$query = $this->db->get();		
		return $query->result();
	}
	
	public function get_viewnfr($id){
		$search = "a.id_pricelistnfr='$id'";
		$this->db->select('a.*, b.nama as nama3, b.hardness as hardness, c.nama as nama2, d.nilai_dimensi as nilai_dimensi ');
		$this->db->from('ms_pricelistnfr a');
		$this->db->join('ms_inventory_category3 b','b.id_category3 =a.id_category3');
		$this->db->join('ms_inventory_category2 c','b.id_category2 =c.id_category2');
		$this->db->join('child_inven_dimensi d','b.id_category3 =d.id_category3');
		$this->db->where($search);
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



}
