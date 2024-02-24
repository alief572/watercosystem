<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * @author Yunas Handra
 * @copyright Copyright (c) 2018, Yunas Handra
 *
 * This is model class for table "Customer"
 */

class Cycletime_model extends BF_Model
{

    /**
     * @var string  User Table Name
     */
    protected $table_name = 'tr_cycletime_header';
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
	
	
    function generate_id($kode='') {
      
        $today=date("ymd");
		$year=date("y");
		$month=date("m");
		$day=date("d");

        $cek = date('y').$kode_bln;
        $query = "SELECT MAX(RIGHT(id_cycletime,5)) as max_id from tr_cycletime_hd ";
        $q = $this->db->query($query);
		$r = $q->row();
        $query_cek = $q->num_rows();
		$kode2 = $r->max_id;
		$kd_noreg = "";
		 
        if ($query_cek == 0) {
          $kd_noreg = 1;
          $reg = sprintf("%02d%05s", $year,$kode_noreg);
		  
        }else {
         		 	  
        // jk sudah ada maka
			$kd_new = $kode2+1; // kode sebelumnya ditambah 1.
			$reg = sprintf("%02d%05s", $year,$kd_new);
			
        }
		
		$tr ="CT$reg";
		
         
          // print_r($tr);
		  // exit();

      return $tr;
	}

 	public function get_data($table,$where_field='',$where_value=''){
		if($where_field !='' && $where_value!=''){
			$query = $this->db->get_where($table, array($where_field=>$where_value));
		}else{
			$query = $this->db->get($table);
		}
		
		return $query->result();
	}
	
	public function get_cycleheader(){
		$search = "'deleted'='N'";
		$this->db->select('a.*, b.nama as nm_kategory, c.nm_lengkap as nm_users');
		$this->db->from('cycletime_header a');
		$this->db->join('ms_inventory_category2 b','b.id_category2=a.id_product');
		$this->db->join('users c','c.id_user=a.created_by');
		$this->db->where('a.deleted','N');
		$query = $this->db->get();		
		return $query->result();
	}
	
	public function get_data_group($table,$where_field='',$where_value='',$where_group=''){
		if($where_field !='' && $where_value!=''){
			$query = $this->db->group_by($where_group)->get_where($table, array($where_field=>$where_value));
			
		}else{
			$query = $this->db->get($table);
		}
		
		return $query->result();
	}
	
    function getById($id)
    {
       return $this->db->get_where('ms_inventory_type',array('id_type' => $id))->row_array();
    }
	
	
	public function get_data_id_tr_cycletime($id){
		$this->db->select('a.*, b.nama as nama_material, c.nama_costcenter, d.nm_asset as nama_mesin, e.nm_asset as nama_mold');
		$this->db->from('tr_cycletime_header a');
		$this->db->join('ms_material b','b.id_material=a.produk');
		$this->db->join('ms_costcenter c','c.id_costcenter =a.cost_center');
		$this->db->join('asset d','d.kd_asset =a.mesin');
		$this->db->join('asset e','e.kd_asset =a.mold_tools');
		$this->db->where('a.deleted','0');
		$this->db->where('a.id_cycletime',$id);
		
		$query = $this->db->get();		
		return $query->result();
	}
	
	function get_name($table, $field, $where, $value)
    {
       $query = "SELECT ".$field." FROM ".$table." WHERE ".$where."='".$value."' LIMIT 1";
	   $result = $this->db->query($query)->result();
	   
	   return $result->$field;
    }

   

}
