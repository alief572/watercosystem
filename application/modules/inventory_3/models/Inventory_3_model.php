<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * @author Yunas Handra
 * @copyright Copyright (c) 2018, Yunas Handra
 *
 * This is model class for table "Customer"
 */

class Inventory_3_model extends BF_Model
{
    /**
     * @var string  User Table Name
     */
    protected $table_name = 'ms_inventory_category2';
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
	
	private function _category2_base($search = '')
	{
		$this->db->from('ms_inventory_category2 a');
		$this->db->join('ms_inventory_type b', 'b.id_type=a.id_type');
		$this->db->join('ms_inventory_category1 c', 'c.id_category1=a.id_category1');
		$this->db->where('a.deleted', 0);
		if ($search !== '') {
			$this->db->group_start()
				->like('a.id_category2', $search)
				->or_like('b.nama', $search)
				->or_like('c.nama', $search)
				->or_like('a.nama', $search)
				->group_end();
		}
	}

	public function get_datatable($start, $length, $search, $order)
	{
		$cols = array(1 => 'a.id_category2', 2 => 'b.nama', 3 => 'c.nama', 4 => 'a.nama', 5 => 'a.aktif');

		$this->_category2_base();
		$total = $this->db->count_all_results();

		$this->_category2_base($search);
		$filtered = $this->db->count_all_results();

		$this->db->select('a.id_category2, a.nama, a.aktif, b.nama as nama_type, c.nama as nama_category1');
		$this->_category2_base($search);
		$col = isset($order['column'], $cols[(int) $order['column']]) ? $cols[(int) $order['column']] : 'a.id_category2';
		$dir = (isset($order['dir']) && $order['dir'] === 'desc') ? 'desc' : 'asc';
		$this->db->order_by($col, $dir);
		if ($length > 0) {
			$this->db->limit($length, $start);
		}

		return array(
			'total'    => $total,
			'filtered' => $filtered,
			'data'     => $this->db->get()->result(),
		);
	}

	public function getview($id)
	{
		$this->db->select('a.*, b.nama as nama_type, c.nama as nama_category1');
		$this->db->from('ms_inventory_category2 a');
		$this->db->join('ms_inventory_type b', 'b.id_type=a.id_type', 'left');
		$this->db->join('ms_inventory_category1 c', 'c.id_category1=a.id_category1', 'left');
		$this->db->where('a.id_category2', $id);
		return $this->db->get()->row();
	}

    

}
