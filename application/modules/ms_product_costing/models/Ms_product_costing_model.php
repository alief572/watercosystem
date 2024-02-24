<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * @author Syamsudin
 * @copyright Copyright (c) 2022, Syamsudin
 *
 * This is model class for table "ms_diskon"
 */

class Ms_product_costing_model extends BF_Model
{
    /**
     * @var string  User Table Name
     */
    protected $table_name = 'ms_diskon';
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
      $query = $this->db->query("SELECT MAX(id_category2) as max_id FROM ms_inventory_category2");
      $row = $query->row_array();
      $thn = date('y');
      $max_id = $row['max_id'];
      $max_id1 =(int) substr($max_id,4,5);
      $counter = $max_id1 +1;
      $idcust = "LVL3".str_pad($counter, 5, "0", STR_PAD_LEFT);
      return $idcust;
	}
	
	function level_2($inventory_1)
    {
        $this->db->where('id_type', $inventory_1);
		$this->db->where('deleted', "0");
        $this->db->order_by('id_category1', 'ASC');
        return $this->db->from('ms_inventory_category1')
            ->get()
            ->result();
    }
    function level_3($id_inventory2)
    {
        $this->db->where('id_category1', $id_inventory2);
        $this->db->order_by('id_category2', 'ASC');
        return $this->db->from('ms_inventory_category2')
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
       return $this->db->get_where('ms_inventory_category1',array('id_category1' => $id))->row_array();
    }
	
	public function get_data_formula(){
		$this->db->select('a.*, b.nama as nama_category3');
		$this->db->from('ms_product_costing a');
		$this->db->join('ms_inventory_category2 b','b.id_category2=a.id_category2');
		$this->db->where('a.deleted',0);
		$query = $this->db->get();		
		return $query->result();
	}
    public function get_data_usage(){
		$this->db->select('*');
		$this->db->from('ms_inventory_category2 a');
        $this->db->group_by('nama');
		$query = $this->db->get();		
		return $query->result();
	}

    function generate_code($kode='') {
        $query = $this->db->query("SELECT MAX(id_product_costing) as max_id FROM ms_product_costing");
        $row = $query->row_array();
        $thn = date('y');
        $max_id = $row['max_id'];
        $counter = $max_id +1;
        $idcust = $counter;
        return $idcust;
      }

      public function get_data_pricelist(){
		$this->db->select('a.*, b.nama as nama_category1, c.nama as nama_category2, d.nama as nama_category3, 
        e.nama as nama_category4, e.kode_barang as kode_produk, f.nama_category2 as nama_formula');
		$this->db->from('ms_product_pricelist a');
        $this->db->join('ms_inventory_type b','b.id_type=a.id_type');
        $this->db->join('ms_inventory_category1 c','c.id_category1=a.id_category1');
		$this->db->join('ms_inventory_category2 d','d.id_category2=a.id_category2');
        $this->db->join('ms_inventory_category3 e','e.id_category3=a.id_category3');
        $this->db->join('ms_product_costing f','f.id_category2=a.id_formula',left);
		$this->db->where('a.deleted',0);
		$query = $this->db->get();		
		return $query->result();
	}


    function generate_code_pricelist($kode='') {
        $query = $this->db->query("SELECT MAX(id_product_pricelist) as max_id FROM ms_product_pricelist");
        $row = $query->row_array();
        $thn = date('y');
        $max_id = $row['max_id'];
        $counter = $max_id +1;
        $idcust = $counter;
        return $idcust;
      }

    

}
