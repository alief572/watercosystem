<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * @Author Syamsudin
 * @Copyright (c) 2022, Syamsudin
 *
 * This is model class for table "Wt_penawaran"
 */

class Invoice_np_model extends BF_Model
{
    /**
     * @var string  User Table Name
     */
    protected $table_name = 'tr_invoicing';
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

    public function CariInvoice()
    {
        $this->db->select('a.*');
        $this->db->from('tr_invoice_np_header a');
        $this->db->order_by('a.created_date', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Query serverside untuk DataTable index. Kolom order urut sesuai urutan kolom di tabel.
     */
    private function _query_invoice($keyword = '')
    {
        $this->db->from('tr_invoice_np_header a');
        $keyword = trim((string) $keyword);
        if ($keyword !== '') {
            $this->db->group_start();
            $this->db->like('a.no_invoice', $keyword);
            $this->db->or_like('a.tgl_invoice', $keyword);
            $this->db->or_like('a.no_faktur', $keyword);
            $this->db->or_like('a.keterangan', $keyword);
            $this->db->or_like('a.nm_customer', $keyword);
            $this->db->or_like('a.total_invoice_idr', str_replace(',', '', $keyword));
            $this->db->group_end();
        }
    }

    public function get_invoice_json($keyword, $order_col, $order_dir, $start, $length)
    {
        $columns = [
            1 => 'a.no_invoice',
            2 => 'a.tgl_invoice',
            3 => 'a.no_faktur',
            4 => 'a.keterangan',
            5 => 'a.nm_customer',
            6 => 'a.total_invoice_idr',
        ];

        $this->_query_invoice($keyword);
        $filtered = $this->db->count_all_results();

        $this->_query_invoice($keyword);
        $this->db->select('a.*');
        if (isset($columns[$order_col])) {
            $this->db->order_by($columns[$order_col], strtolower($order_dir) === 'asc' ? 'ASC' : 'DESC');
        } else {
            $this->db->order_by('a.id_invoice', 'DESC');
        }
        if ($length > 0) {
            $this->db->limit((int) $length, (int) $start);
        }
        $rows = $this->db->get()->result();

        return [
            'total'    => $this->db->count_all('tr_invoice_np_header'),
            'filtered' => $filtered,
            'rows'     => $rows,
        ];
    }

    public function get_no_invoice()
    {
        $this->db->select('MAX(a.no_invoice) as max');
        $this->db->from('tr_invoice_np_header a');
        $this->db->like('a.no_invoice', 'WI-PNP/' . date('Y'), 'both');
        $get_data = $this->db->get()->row();

        if (!empty($get_data->max)) {
            $max = $get_data->max;
            $substr = substr($max, 15, 4);
            $substr = intval($substr) + 1;

            $prefix = 'WI-PNP/' . date('Y_m') . '/';

            $noInvoice = $prefix . str_pad($substr, 4, '0', STR_PAD_LEFT);
        } else {
            $noInvoice = 'WI-PNP/' . date('Y_m') . '/0001';
        }

        return $noInvoice;
    }
}
