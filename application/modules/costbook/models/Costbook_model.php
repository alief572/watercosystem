<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * @author Syamsudin
 * @copyright Copyright (c) 2023, Syamsudin
 *
 * This is model class for table "Customer"
 */

class Costbook_model extends BF_Model
{

    /**
     * @var string  User Table Name
     */
    protected $table_name = 'ms_costbook';
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


    function generate_id($kode = '')
    {
        $query = $this->db->query("SELECT MAX(id_type) as max_id FROM ms_inventory_type");
        $row = $query->row_array();
        $thn = date('y');
        $max_id = $row['max_id'];
        $max_id1 = (int) substr($max_id, 3, 5);
        $counter = $max_id1 + 1;
        $idcust = "I" . $thn . str_pad($counter, 5, "0", STR_PAD_LEFT);
        return $idcust;
    }

    public function get_data($table, $where_field = '', $where_value = '')
    {
        if ($where_field != '' && $where_value != '') {
            $query = $this->db->get_where($table, array($where_field => $where_value));
        } else {
            $query = $this->db->get($table);
        }

        return $query->result();
    }

    function getById($id)
    {
        return $this->db->get_where('ms_kurs', array('id' => $id))->row_array();
    }

    public function get_costbook()
    {

        $this->db->select('a.*, b.nama as nama_produk, b.kode_barang');
        $this->db->from('ms_costbook a');
        $this->db->join('ms_inventory_category3 b', 'b.id_category3 =a.id_category3');
        $this->db->where('b.deleted <>', '1');
        $query = $this->db->get();
        return $query->result();
    }
}
