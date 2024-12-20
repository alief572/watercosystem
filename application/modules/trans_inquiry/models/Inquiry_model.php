<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * @author Yunas Handra
 * @copyright Copyright (c) 2018, Yunas Handra
 *
 * This is model class for table "Customer"
 */

class Inquiry_model extends BF_Model
{

    /**
     * @var string  User Table Name
     */
    protected $table_name = 'ms_inventory_category1';
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
		$today=date("Y-m-d");
		$year=date("y");
		$month=date("m");
		$day=date("d");
        $query = "SELECT MAX(RIGHT(no_inquiry,4)) as max_id from tr_inquiry WHERE tgl_inquiry LIKE '$today'";
        $q = $this->db->query($query);
		$r = $q->row();
        $query_cek = $q->num_rows();
		$kode2 = $r->max_id;
		$kd_noreg = "";
        if ($query_cek == 0) {
          $kd_noreg = 1;
          $reg = sprintf("%02d%02d%02d%04s", $year,$month,$day,$kode_noreg);  
        }else {
			$kd_new = $kode2+1;
			$reg = sprintf("%02d%02d%02d%04s", $year,$month,$day,$kd_new);	
        }
		$tr ="IQ$reg";
      return $tr;
	}
	
    function generate_Category($kode='') {
      $query = $this->db->query("SELECT MAX(id_category_customer) as max_id FROM child_customer_category");
      $row = $query->row_array();
      $thn = date('y');
      $max_id = $row['max_id'];
      $max_id1 =(int) substr($max_id,4,5);
      $counter = $max_id1 +1;
      $idcust = "CC".$thn.str_pad($counter, 5, "0", STR_PAD_LEFT);
      return $idcust;
	}

 	public function get_data($table,$where_field='',$where_value=''){
		if($where_field !='' && $where_value!=''){
			$query = $this->db->get_where($table, array($where_field=>$where_value));
		}else{
			$query = $this->db->get($table);
		}
		
		return $query->result();
	}
	
	public function get_inquiry(){
		$this->db->select('a.*, b.name_customer as name_customer');
		$this->db->from('tr_inquiry_hd a');
		$this->db->join('master_customers b','b.id_customer=a.id_customer');
		$query = $this->db->get();		
		return $query->result();
	}
	
	public function getinternational(){
		$search = "suplier_location='international' and deleted='0'";
		$this->db->select('a.*, b.name_category_supplier as name_category_supplier, c.nm_negara as nm_negara ');
		$this->db->from('master_supplier a');
		$this->db->join('child_supplier_category b','b.id_category_supplier=a.id_category_supplier');
		$this->db->join('negara c','c.id_negara=a.id_negara');
		$this->db->where($search);
		$query = $this->db->get();		
		return $query->result();
	}
	public function get_data_category3($bentuk){
		$search = "a.id_bentuk='$bentuk' and a.deleted='0'";
		$this->db->select('a.*, b.nama as nama_type, c.nama as nama_category1, d.nama as nama_category2');
		$this->db->from('ms_inventory_category3 a');
		$this->db->join('ms_inventory_type b','b.id_type=a.id_type');
		$this->db->join('ms_inventory_category1 c','c.id_category1 =a.id_category1');
		$this->db->join('ms_inventory_category2 d','d.id_category2 =a.id_category2');
		$this->db->where($search);
		$query = $this->db->get();		
		return $query->result();
	}
	public function get_data_dimensi($produk){
		$search = "a.id_category3='$produk' and a.deleted='0'";
		$this->db->select('a.*, b.nm_dimensi as nm_dimensi');
		$this->db->from('child_inven_dimensi a');
		$this->db->join('ms_dimensi b','b.id_dimensi=a.id_dimensi');
		$this->db->where($search);
		$query = $this->db->get();		
		return $query->result();
	}
	public function get_data_category1(){
		$this->db->select('a.*, b.nama as nama_type');
		$this->db->from('ms_inventory_category1 a');
		$this->db->join('ms_inventory_type b','b.id_type=a.id_type');
		$this->db->where('a.deleted','0');
		$query = $this->db->get();		
		return $query->result();
	}
	public function getDimensi($id){
		$search = "deleted='0' and id_bentuk='$id'";
		$this->db->select('*');
		$this->db->from('ms_dimensi');
		$this->db->where($search);
		$query = $this->db->get();		
		return $query->result();
	}
	
    function getById($id)
    {
       return $this->db->get_where('ms_inventory_category1',array('id_category1' => $id))->row_array();
    }
	
	function carikota($id_prov)
    {
        $this->db->where('id_prov', $id_prov);
        return $this->db->from('kota')
            ->get()
			->result();
	}
	
	function caripic($id_customer)
    {
        $this->db->where('id_customer', $id_customer);
        return $this->db->from('child_customer_pic')
            ->get()
			->result();
	}
	
	function cariemail($id_customer)
    {
        $this->db->where('id_customer', $id_customer);
        return $this->db->from('master_customers')
            ->get()
			->result();
	}
       

   

}
