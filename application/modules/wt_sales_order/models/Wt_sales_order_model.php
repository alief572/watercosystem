<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * @Author Syamsudin
 * @Copyright (c) 2022, Syamsudin
 *
 * This is model class for table "Wt_penawaran"
 */

class Wt_sales_order_model extends BF_Model
{
  /**
   * @var string  User Table Name
   */
  protected $table_name = 'tr_sales_order';
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

  protected $viewPermission   = "Penawaran.View";
  protected $addPermission    = "Penawaran.Add";
  protected $managePermission = "Penawaran.Manage";
  protected $deletePermission = "Penawaran.Delete";
  public function __construct()
  {
    parent::__construct();
  }

  function generate_id($kode = '')
  {
    $query = $this->db->query("SELECT MAX(id_so) as max_id FROM tr_sales_order");
    $row = $query->row_array();
    $thn = date('y');
    $max_id = $row['max_id'];
    $max_id1 = (int) substr($max_id, 3, 5);
    $counter = $max_id + 1;
    $idcust = "P" . $thn . str_pad($counter, 5, "0", STR_PAD_LEFT);
    return $counter;
  }

  function generate_code($kode = '')
  {
    $query = $this->db->query("SELECT MAX(no_so) as max_id FROM tr_sales_order");
    $row = $query->row_array();
    $thn = date('y');
    $max_id = $row['max_id'];
    $max_id1 = (int) substr($max_id, 3, 5);
    $counter = $max_id1 + 1;
    $idcust = "P" . $thn . str_pad($counter, 5, "0", STR_PAD_LEFT);
    return $idcust;
  }
  function BuatNomor($tanggal)
  {
    $bulan = date("m", strtotime($tanggal));
    $tahun = date("Y", strtotime($tanggal));
    if ($bulan == '01') {
      $romawi = 'I';
    } elseif ($bulan == '02') {
      $romawi = 'II';
    } elseif ($bulan == '03') {
      $romawi = 'III';
    } elseif ($bulan == '04') {
      $romawi = 'IV';
    } elseif ($bulan == '05') {
      $romawi = 'V';
    } elseif ($bulan == '06') {
      $romawi = 'VI';
    } elseif ($bulan == '07') {
      $romawi = 'VII';
    } elseif ($bulan == '08') {
      $romawi = 'VIII';
    } elseif ($bulan == '09') {
      $romawi = 'IX';
    } elseif ($bulan == '10') {
      $romawi = 'X';
    } elseif ($bulan == '11') {
      $romawi = 'XI';
    } elseif ($bulan == '12') {
      $romawi = 'XII';
    }
    $blnthn = date('Y-m');
    $query = $this->db->query("SELECT MAX(no_surat) as max_id FROM tr_sales_order WHERE month(tgl_so)='$bulan' and Year(tgl_so)='$tahun'");
    $row = $query->row_array();
    $thn = date('T');
    $max_id = $row['max_id'];
    $max_id1 = (int) substr($max_id, 0, 3);
    $counter = $max_id1 + 1;
    $idcust = sprintf("%03s", $counter) . "/WI/SO/" . $romawi . "/" . $tahun;
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
  public function cariSalesOrder()
  {
    $this->db->select('a.*, b.name_customer as name_customer, c.grand_total as total_penawaran, c.no_surat as nomor_penawaran, c.tgl_penawaran, d.nm_lengkap');
    $this->db->from('tr_sales_order a');
    $this->db->join('master_customers b', 'b.id_customer=a.id_customer');
    $this->db->join('tr_penawaran c', 'c.no_penawaran=a.no_penawaran');
    $this->db->join('users d', 'd.id_user=a.created_by');
    // $where = "a.status<>'6'";
    $where2 = "a.status !='0'";
    // $this->db->where($where);
    $this->db->where($where2);
    $this->db->order_by('a.no_so', 'desc');
    $query = $this->db->get();
    return $query->result();
  }

  public function cariSalesOrderId($noso)
  {
    $this->db->select('a.*, b.name_customer as name_customer, c.grand_total as total_penawaran, c.no_surat as nomor_penawaran, c.tgl_penawaran');
    $this->db->from('tr_sales_order a');
    $this->db->join('master_customers b', 'b.id_customer=a.id_customer');
    $this->db->join('tr_penawaran c', 'c.no_penawaran=a.no_penawaran');
    $where = "a.no_so = '$noso'";
    $where2 = "a.status !='0'";
    $this->db->where($where);
    $this->db->where($where2);
    $this->db->order_by('a.no_so', 'desc');
    $query = $this->db->get();
    return $query->result();
  }

  public function cariSalesOrderNodeal()
  {
    $this->db->select('a.*, b.name_customer as name_customer, c.grand_total as total_penawaran');
    $this->db->from('tr_sales_order a');
    $this->db->join('master_customers b', 'b.id_customer=a.id_customer');
    $this->db->join('tr_penawaran c', 'c.no_penawaran=a.no_penawaran');
    // $where = "a.status<>'6'";
    $where2 = "a.status ='0'";
    // $this->db->where($where);
    $this->db->where($where2);
    $this->db->order_by('a.no_penawaran', 'desc');
    $query = $this->db->get();
    return $query->result();
  }
  public function CariPenawaranApproval()
  {
    $this->db->select('a.*, b.name_customer as name_customer');
    $this->db->from('tr_penawaran a');
    $this->db->join('master_customers b', 'b.id_customer=a.id_customer');
    $where = "a.status='1'";
    $this->db->where($where);
    $this->db->order_by('a.no_penawaran', 'desc');
    $query = $this->db->get();
    return $query->result();
  }
  public function CariPenawaranSo()
  {
    $this->db->select('a.*, b.name_customer as name_customer');
    $this->db->from('tr_penawaran a');
    $this->db->join('master_customers b', 'b.id_customer=a.id_customer');
    $where = "a.status='6'";
    $this->db->where($where);
    $this->db->order_by('a.no_penawaran', 'desc');
    $query = $this->db->get();
    return $query->result();
  }
  public function CariPenawaranLoss()
  {
    $this->db->select('a.*, b.name_customer as name_customer');
    $this->db->from('tr_penawaran a');
    $this->db->join('master_customers b', 'b.id_customer=a.id_customer');
    $where = "a.status='7'";
    $this->db->where($where);
    $this->db->order_by('a.no_penawaran', 'desc');
    $query = $this->db->get();
    return $query->result();
  }

  public function CariPenawaranHistory()
  {
    $this->db->select('a.*, b.name_customer as name_customer');
    $this->db->from('tr_penawaran_history a');
    $this->db->join('master_customers b', 'b.id_customer=a.id_customer');
    $this->db->order_by('a.no_penawaran', 'desc');
    $query1 = $this->db->get();

    $this->db->select('a.*, b.name_customer as name_customer');
    $this->db->from('tr_penawaran  a');
    $this->db->join('master_customers b', 'b.id_customer=a.id_customer');
    $where = "a.status_so='1'";
    $this->db->where($where);
    $this->db->order_by('a.no_penawaran', 'desc');
    $query2 = $this->db->get();

    $query3 = $this->db->query($query1 . ' UNION ' . $query2);



    return $query3->result();
  }

  public function CariHeaderHistory($no, $rev)
  {
    $this->db->select('a.*, b.name_customer as name_customer');
    $this->db->from('tr_penawaran_history a');
    $this->db->join('master_customers b', 'b.id_customer=a.id_customer');
    $where = "a.no_penawaran='$no'";
    $where2 = "a.revisi='$rev'";
    $this->db->where($where);
    $this->db->where($where2);
    $this->db->order_by('a.no_penawaran', 'desc');
    $query = $this->db->get();
    return $query->result();
  }

  public function CariDetailHistory($no, $rev)
  {
    $this->db->select('a.*');
    $this->db->from('tr_penawaran_detail_history a');
    $where = "a.no_penawaran='$no'";
    $where2 = "a.revisi='$rev'";
    $this->db->where($where);
    $this->db->where($where2);
    $query = $this->db->get();
    return $query->result();
  }

  public function get_so()
  {
    $draw = $this->input->post('draw');
    $start = $this->input->post('start');
    $length = $this->input->post('length');
    $search = $this->input->post('search');

    $this->db->select('a.no_surat, a.no_so, a.nama_sales, a.status, a.upload_po, a.upload_so, b.name_customer as name_customer, a.grand_total, c.grand_total as total_penawaran, c.no_surat as nomor_penawaran, c.tgl_penawaran, d.nm_lengkap');
    $this->db->from('tr_sales_order a');
    $this->db->join('master_customers b', 'b.id_customer=a.id_customer');
    $this->db->join('tr_penawaran c', 'c.no_penawaran=a.no_penawaran');
    $this->db->join('users d', 'd.id_user = a.created_by');
    $this->db->where('a.status <>', 0);
    $this->db->where('a.order_status <>', 'ind');
    $this->db->where('a.deleted_by', null);
    if (!empty($search)) {
      $this->db->group_start();
      $this->db->like('a.no_surat', $search['value'], 'both');
      $this->db->or_like('a.nama_sales', $search['value'], 'both');
      $this->db->or_like('a.grand_total', $search['value'], 'both');
      $this->db->or_like('c.grand_total', $search['value'], 'both');
      $this->db->or_like('b.name_customer', $search['value'], 'both');
      $this->db->or_like('c.no_surat', $search['value'], 'both');
      $this->db->or_like('c.tgl_penawaran', $search['value'], 'both');
      $this->db->group_end();
    }
    $this->db->order_by('a.no_so', 'desc');
    $this->db->limit($length, $start);
    $get_data = $this->db->get();

    $this->db->select('a.no_surat, a.no_so, a.nama_sales, a.upload_po, a.upload_so, b.name_customer as name_customer, a.grand_total, c.grand_total as total_penawaran, c.no_surat as nomor_penawaran, c.tgl_penawaran, d.nm_lengkap');
    $this->db->from('tr_sales_order a');
    $this->db->join('master_customers b', 'b.id_customer=a.id_customer');
    $this->db->join('tr_penawaran c', 'c.no_penawaran=a.no_penawaran');
    $this->db->join('users d', 'd.id_user=a.created_by');
    $this->db->where('a.status <>', 0);
    $this->db->where('a.order_status <>', 'ind');
    $this->db->where('a.deleted_by', null);
    if (!empty($search)) {
      $this->db->group_start();
      $this->db->like('a.no_surat', $search['value'], 'both');
      $this->db->or_like('a.nama_sales', $search['value'], 'both');
      $this->db->or_like('a.grand_total', $search['value'], 'both');
      $this->db->or_like('c.grand_total', $search['value'], 'both');
      $this->db->or_like('b.name_customer', $search['value'], 'both');
      $this->db->or_like('c.no_surat', $search['value'], 'both');
      $this->db->or_like('c.tgl_penawaran', $search['value'], 'both');
      $this->db->group_end();
    }
    $this->db->order_by('a.no_so', 'desc');
    $get_data_all = $this->db->get();

    $hasil = [];

    $no = (0 + $start);
    foreach ($get_data->result() as $item) {


      if ($item->status == 0) {
        $Status = "<span class='badge bg-grey'>Draft</span>";
      } elseif ($item->status == 1) {

        $Status = "<span class='badge bg-green'>Deal</span>";
      } elseif ($item->status == 2) {
        $Status = "<span class='badge bg-green'>Approved</span>";
      } elseif ($item->status == 3) {
        $Status = "<span class='badge bg-blue'>Dicetak</span>";
      } elseif ($item->status == 4) {
        $Status = "<span class='badge bg-green'>Terkirim</span>";
      } elseif ($item->status == 5) {
        $Status = "<span class='badge bg-red'>Not Approved</span>";
      } elseif ($item->status == 6) {
        $Status = "<span class='badge bg-green'>SO</span>";
      } elseif ($item->status == 7) {
        $Status = "<span class='badge bg-red'>Loss</span>";
      }

      if ($item->grand_total != 0) {
        $persen = Round(($item->grand_total / $item->total_penawaran) * 100);
      } else {
        $persen = 0;
      }

      if ($item->status <> 6 || $item->status <> 7) {
        $no++;

        $view_po = ($item->upload_po <> null && file_exists($item->upload_po)) ? '<a class="btn btn-primary btn-sm" href="' . $item->upload_po . '" title="View PO"><i class="fa fa-eye"></i></a>' : '';

        $view_so = ($item->upload_so <> null && file_exists($item->upload_so)) ? '<a class="btn btn-primary btn-sm" href="' . $item->upload_so . '" title="View PO"><i class="fa fa-eye"></i></a>' : '';

        $option = '';
        if (has_permission($this->managePermission)) {
          $option = '<a class="btn btn-primary btn-sm" target="_blank" href="' . base_url('/wt_sales_order/printSO/' . $item->no_so) . '" title="Print SO"><i class="fa fa-print">&nbsp;Print SO</i></a>';
        }

        $hasil[] = [
          'no' => $no,
          'no_so' => $item->no_surat,
          'nm_customer' => $item->name_customer,
          'marketing' => $item->nama_sales,
          'nilai_penawaran' => number_format($item->total_penawaran, 2),
          'nilai_so' => number_format($item->grand_total, 2),
          'persentase' => $persen . '%',
          'view_po' => $view_po,
          'view_penawaran_deal' => $view_so,
          'created_by' => $item->nm_lengkap,
          'status' => $Status,
          'option' => $option
        ];
      }
    }

    echo json_encode([
      'draw' => intval($draw),
      'recordsTotal' => $get_data_all->num_rows(),
      'recordsFiltered' => $get_data_all->num_rows(),
      'data' => $hasil
    ]);
  }

  public function get_so_indent()
  {
    $draw = $this->input->post('draw');
    $start = $this->input->post('start');
    $length = $this->input->post('length');
    $search = $this->input->post('search');

    $this->db->select('a.no_surat, a.no_so, a.nama_sales, a.status, a.order_status, a.upload_po, a.upload_so, b.name_customer as name_customer, a.grand_total, a.indent_check, c.grand_total as total_penawaran, c.no_surat as nomor_penawaran, c.tgl_penawaran, d.nm_lengkap');
    $this->db->from('tr_sales_order a');
    $this->db->join('master_customers b', 'b.id_customer=a.id_customer');
    $this->db->join('tr_penawaran c', 'c.no_penawaran=a.no_penawaran');
    $this->db->join('users d', 'd.id_user = a.created_by');
    $this->db->where('a.status <>', 0);
    $this->db->where('a.order_status', 'ind');
    if (!empty($search)) {
      $this->db->group_start();
      $this->db->like('a.no_surat', $search['value'], 'both');
      $this->db->or_like('a.nama_sales', $search['value'], 'both');
      $this->db->or_like('a.grand_total', $search['value'], 'both');
      $this->db->or_like('c.grand_total', $search['value'], 'both');
      $this->db->or_like('b.name_customer', $search['value'], 'both');
      $this->db->or_like('c.no_surat', $search['value'], 'both');
      $this->db->or_like('c.tgl_penawaran', $search['value'], 'both');
      $this->db->group_end();
    }
    $this->db->order_by('a.no_so', 'desc');
    $this->db->limit($length, $start);
    $get_data = $this->db->get();

    $this->db->select('a.no_surat, a.no_so, a.nama_sales, a.status, a.order_status, a.upload_po, a.upload_so, b.name_customer as name_customer, a.grand_total, a.indent_check, c.grand_total as total_penawaran, c.no_surat as nomor_penawaran, c.tgl_penawaran, d.nm_lengkap');
    $this->db->from('tr_sales_order a');
    $this->db->join('master_customers b', 'b.id_customer=a.id_customer');
    $this->db->join('tr_penawaran c', 'c.no_penawaran=a.no_penawaran');
    $this->db->join('users d', 'd.id_user=a.created_by');
    $this->db->where('a.status <>', 0);
    $this->db->where('a.order_status', 'ind');
    if (!empty($search)) {
      $this->db->group_start();
      $this->db->like('a.no_surat', $search['value'], 'both');
      $this->db->or_like('a.nama_sales', $search['value'], 'both');
      $this->db->or_like('a.grand_total', $search['value'], 'both');
      $this->db->or_like('c.grand_total', $search['value'], 'both');
      $this->db->or_like('b.name_customer', $search['value'], 'both');
      $this->db->or_like('c.no_surat', $search['value'], 'both');
      $this->db->or_like('c.tgl_penawaran', $search['value'], 'both');
      $this->db->group_end();
    }
    $this->db->order_by('a.no_so', 'desc');
    $get_data_all = $this->db->get();

    $hasil = [];

    $no = (0 + $start);
    foreach ($get_data->result() as $item) {


      if ($item->status == 0) {
        $Status = "<span class='badge bg-grey'>Draft</span>";
      } elseif ($item->status == 1) {

        $Status = "<span class='badge bg-green'>Deal</span>";
      } elseif ($item->status == 2) {
        $Status = "<span class='badge bg-green'>Approved</span>";
      } elseif ($item->status == 3) {
        $Status = "<span class='badge bg-blue'>Dicetak</span>";
      } elseif ($item->status == 4) {
        $Status = "<span class='badge bg-green'>Terkirim</span>";
      } elseif ($item->status == 5) {
        $Status = "<span class='badge bg-red'>Not Approved</span>";
      } elseif ($item->status == 6) {
        $Status = "<span class='badge bg-green'>SO</span>";
      } elseif ($item->status == 7) {
        $Status = "<span class='badge bg-red'>Loss</span>";
      }

      if ($item->grand_total != 0) {
        $persen = Round(($item->grand_total / $item->total_penawaran) * 100);
      } else {
        $persen = 0;
      }

      if ($item->status <> 6 || $item->status <> 7) {
        $no++;

        $view_po = ($item->upload_po <> null && file_exists($item->upload_po)) ? '<a class="btn btn-primary btn-sm" href="' . base_url($item->upload_po) . '" title="View PO"><i class="fa fa-eye"></i></a>' : '';

        $view_so = ($item->upload_so <> null && file_exists($item->upload_so)) ? '<a class="btn btn-primary btn-sm" href="' . base_url($item->upload_so) . '" title="View PO"><i class="fa fa-eye"></i></a>' : '';

        $option = '';
        if (has_permission($this->managePermission)) {
          $option = '<a class="btn btn-primary btn-sm" target="_blank" href="' . base_url('/wt_sales_order/printSO/' . $item->no_so) . '" title="Print SO"><i class="fa fa-print">&nbsp;Print SO</i></a>';
        }

        if ($item->indent_check !== '1') {
          $option .= ' <button type="button" class="btn btn-sm btn-success reddeliv" data-no_so="' . $item->no_so . '"><i class="fa fa-check"></i> Ready to Deliver</button>';
        }

        $hasil[] = [
          'no' => $no,
          'no_so' => $item->no_surat,
          'nm_customer' => $item->name_customer,
          'marketing' => $item->nama_sales,
          'nilai_penawaran' => number_format($item->total_penawaran, 2),
          'nilai_so' => number_format($item->grand_total, 2),
          'persentase' => $persen . '%',
          'view_po' => $view_po,
          'view_penawaran_deal' => $view_so,
          'created_by' => $item->nm_lengkap,
          'status' => $Status,
          'option' => $option
        ];
      }
    }

    echo json_encode([
      'draw' => intval($draw),
      'recordsTotal' => $get_data_all->num_rows(),
      'recordsFiltered' => $get_data_all->num_rows(),
      'data' => $hasil
    ]);
  }
}
