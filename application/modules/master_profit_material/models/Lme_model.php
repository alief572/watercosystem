<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * @author Yunas Handra
 * @copyright Copyright (c) 2018, Yunas Handra
 *
 * This is model class for table "Customer"
 */

class Lme_model extends BF_Model
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
      $query = $this->db->query("SELECT MAX(id_history_lme) as max_id FROM ms_history_lme");
      $row = $query->row_array();
      $thn = date('y');
      $max_id = $row['max_id'];
      $max_id1 =(int) substr($max_id,3,5);
      $counter = $max_id1 +1;
      $idcust = "H".$thn.str_pad($counter, 5, "0", STR_PAD_LEFT);
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
	public function gethistory(){
		$edit_bln = date('m');
		$edit_thn = date('Y');
		$bln_lalu = $edit_bln-'1';
		$bln_ini = $edit_bln-'0';
		$search = "bulan_edit='$edit_bln' and tahun_edit='$edit_thn' or bulan_edit='$bln_lalu' and tahun_edit='$edit_thn'";
		$this->db->select('a.*, b.nm_lengkap as nm_lengkap');
		$this->db->from('ms_history_lme a');
		$this->db->join('users b','b.id_user=a.created_by');
		$this->db->where($search);
		$query = $this->db->get();		
		return $query->result();
	}
	public function getKomposisi($id){
		$search = "deleted='0' and id_category1='$id'";
		$this->db->select('*');
		$this->db->from('ms_compotition');
		$this->db->where($search);
		$query = $this->db->get();		
		return $query->result();
	}
	
	public function resultKomposisi(){
		$search = "deleted='0' and id_category1='$id'";
		$this->db->select('*');
		$this->db->from('ms_compotition');
		$this->db->where($search);
		$query = $this->db->get();		
		return $query->result();
	}
	
	public function get10hari($id){
					$hariini = date('Y-m-d H:i:s');
					$sepuluh_hari = mktime(0,0,0,date('n'),date('j')-10,date('Y'));
					$tendays = date("Y-m-d H:i:s", $sepuluh_hari);
					$serch1 = "id_category1 = '$id' and created_on between '$tendays' and '$hariini'";
					$this->db->select_avg('nominal');
					$this->db->from('child_history_lme');
					$this->db->where($serch1);
					$query = $this->db->get();
				$query->result();
	}
	public function get30hari($id){
					$hariini = date('Y-m-d H:i:s');
					$sebulan = mktime(0,0,0,date('n'),date('j')-30,date('Y'));
					$sbln = date("Y-m-d H:i:s", $sebulan);
					$serch1 = " id_category1 = '$id' and created_on between '$sbln' and '$hariini'";
					$this->db->select_avg('nominal');
					$this->db->from('child_history_lme');
					$this->db->where($serch1);
					$query = $this->db->get();
					$query->result();
	}
	public function getdthistory($id){
		$this->db->select('a.*, b.name_compotition as nama_komposisi');
		$this->db->from('child_history_lme a');
		$this->db->join('ms_compotition b','b.id_compotition=a.id_compotition');
		$this->db->where('id_history_lme',$id);
		$query = $this->db->get();		
		return $query->result();
	}
	
    function getById($id)
    {
       return $this->db->get_where('ms_inventory_category1',array('id_category1' => $id))->row_array();
    }

   

}
