<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * @Author Syamsudin
 * @Copyright (c) 2022, Syamsudin
 *
 * This is model class for table "Wt_penawaran"
 */

class Wt_delivery_order_model extends BF_Model
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
    $query = $this->db->query("SELECT MAX(no_spk) as max_id FROM tr_spk_delivery");
    $row = $query->row_array();
    $thn = date('y');
    $max_id = $row['max_id'];
    $max_id1 = (int) substr($max_id, 3, 5);
    $counter = $max_id1 + 1;
    $idcust = "S" . $thn . str_pad($counter, 5, "0", STR_PAD_LEFT);
    return $idcust;
  }

  function generate_codePlanning($kode = '')
  {
    $query = $this->db->query("SELECT MAX(no_planning) as max_id FROM tr_planning_delivery");
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
    $bulan = date('m', strtotime($tanggal));
    $tahun = date('Y', strtotime($tanggal));
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
    $query = $this->db->query("SELECT MAX(no_surat) as max_id FROM tr_spk_delivery WHERE month(tgl_spk)='$bulan' and Year(tgl_spk)='$tahun'");
    $row = $query->row_array();
    $thn = date('T');
    $max_id = $row['max_id'];
    $max_id1 = (int) substr($max_id, 0, 3);
    $counter = $max_id1 + 1;
    $idcust = sprintf("%03s", $counter) . "/WI/SD/" . $romawi . "/" . $tahun;
    return $idcust;
  }


  function BuatNomorPlanning($kode = '')
  {
    $bulan = date('m');
    $tahun = date('Y');
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
    $query = $this->db->query("SELECT MAX(no_surat_planning) as max_id FROM tr_planning_delivery WHERE month(tgl_planning)='$bulan' and Year(tgl_planning)='$tahun'");
    $row = $query->row_array();
    $thn = date('T');
    $max_id = $row['max_id'];
    $max_id1 = (int) substr($max_id, 0, 3);
    $counter = $max_id1 + 1;
    $idcust = sprintf("%03s", $counter) . "/WI/PD/" . $romawi . "/" . $tahun;
    return $idcust;
  }

  function generate_code_Do($kode = '')
  {
    $query = $this->db->query("SELECT MAX(no_do) as max_id FROM tr_delivery_order");
    $row = $query->row_array();
    $thn = date('y');
    $max_id = $row['max_id'];
    $max_id1 = (int) substr($max_id, 3, 5);
    $counter = $max_id1 + 1;
    $idcust = "D" . $thn . str_pad($counter, 5, "0", STR_PAD_LEFT);
    return $idcust;
  }
  function BuatNomorDo($tanggal)
  {
    $bulan = date('m', strtotime($tanggal));
    $tahun = date('Y', strtotime($tanggal));
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
    $query = $this->db->query("SELECT MAX(no_surat) as max_id FROM tr_delivery_order WHERE month(tgl_do)='$bulan' and Year(tgl_do)='$tahun'");
    $row = $query->row_array();
    $thn = date('T');
    $max_id = $row['max_id'];
    $max_id1 = (int) substr($max_id, 0, 3);
    $counter = $max_id1 + 1;
    $idcust = sprintf("%03s", $counter) . "/WI/DO/" . $romawi . "/" . $tahun;
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
    $this->db->select('a.*, b.name_customer as name_customer, c.grand_total as total_penawaran,d.nama_top');
    $this->db->from('tr_sales_order a');
    $this->db->join('master_customers b', 'b.id_customer=a.id_customer', 'left');
    $this->db->join('tr_penawaran c', 'c.no_penawaran=a.no_penawaran', 'left');
    $this->db->join('ms_top d', 'd.id_top=a.top', 'left');
    $this->db->where('a.status <>', 0);
    // $this->db->where('IF(a.order_status = "ind", a.indent_check, 1) =', 1);
    // $where2 = "a.status !='0'";
    //$this->db->where($where2);
    $this->db->order_by('a.no_penawaran', 'desc');
    $query = $this->db->get();

    return $query->result();
  }

  public function cariSalesOrderblmkirim()
  {
    $this->db->select('a.*, b.name_customer as name_customer, c.grand_total as total_penawaran,d.nama_top');
    $this->db->from('tr_sales_order a');
    $this->db->join('master_customers b', 'b.id_customer=a.id_customer');
    $this->db->join('tr_penawaran c', 'c.no_penawaran=a.no_penawaran');
    $this->db->join('ms_top d', 'd.id_top=a.top');
    $where = "a.approval_finance is null";
    $this->db->where($where);
    $this->db->order_by('a.no_penawaran', DESC);
    $query = $this->db->get();
    return $query->result();
  }


  public function cariSpkDelivery()
  {
    $this->db->select('a.*, c.no_surat as nomor_so, b.name_customer as name_customer');
    $this->db->from('tr_spk_delivery a');
    $this->db->join('master_customers b', 'b.id_customer=a.id_customer');
    $this->db->join('tr_sales_order c', 'c.no_so=a.no_so');
    $where = "a.status_create_do ='0'";
    $this->db->where($where);
    $query = $this->db->get();
    return $query->result();
  }

  public function cariDeliveryOrder()
  {
    $search = "a.status_confirm is null";
    $this->db->select('a.*, c.no_surat as nomor_spk, b.name_customer as name_customer');
    $this->db->from('tr_delivery_order a');
    $this->db->join('master_customers b', 'b.id_customer=a.id_customer');
    $this->db->join('tr_spk_delivery c', 'c.no_spk=a.no_spk');
    $this->db->where($search);
    $query = $this->db->get();
    return $query->result();
  }

  public function cariDeliveryOrderDetail($id)
  {
    $this->db->select('a.*, b.metode_kirim, b.keterangan_kirim, c.kode_barang');
    $this->db->from('tr_delivery_order_detail a');
    $this->db->join('tr_sales_order_detail b', 'b.id_so_detail=a.id_so_detail');
    $this->db->join('ms_inventory_category3 c', 'c.id_category3=a.id_category3');
    $this->db->where('a.no_do', $id);
    $query = $this->db->get();
    return $query->result();
  }


  public function cariSpkDeliveryDetail($id)
  {
    $this->db->select('a.*, b.metode_kirim, b.keterangan_kirim');
    $this->db->from('tr_spk_delivery_detail a');
    $this->db->join('tr_sales_order_detail b', 'b.id_so_detail=a.id_so_detail');
    $this->db->where('a.no_spk', $id);
    $query = $this->db->get();
    return $query->result();
  }

  public function cariSalesOrderPlanning($id = null)
  {
    $this->db->select('a.*, b.name_customer as name_customer, c.grand_total as total_penawaran,d.nama_top');
    $this->db->from('tr_sales_order a');
    $this->db->join('master_customers b', 'b.id_customer=a.id_customer');
    $this->db->join('tr_penawaran c', 'c.no_penawaran=a.no_penawaran');
    $this->db->join('ms_top d', 'd.id_top=a.top');
    if ($id != null) {
      $where = "a.id_customer='$id'";
      $this->db->where($where);
    }
    $where2 = "a.status_planning ='1'";
    $this->db->where($where2);
    $this->db->order_by('a.no_penawaran', DESC);
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
    $this->db->order_by('a.no_penawaran', DESC);
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
    $this->db->order_by('a.no_penawaran', DESC);
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
    $this->db->order_by('a.no_penawaran', DESC);
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
    $this->db->order_by('a.no_penawaran', DESC);
    $query = $this->db->get();
    return $query->result();
  }

  public function CariPenawaranHistory()
  {
    $this->db->select('a.*, b.name_customer as name_customer');
    $this->db->from('tr_penawaran_history a');
    $this->db->join('master_customers b', 'b.id_customer=a.id_customer');
    $this->db->order_by('a.no_penawaran', DESC);
    $query1 = $this->db->get();

    $this->db->select('a.*, b.name_customer as name_customer');
    $this->db->from('tr_penawaran  a');
    $this->db->join('master_customers b', 'b.id_customer=a.id_customer');
    $where = "a.status_so='1'";
    $this->db->where($where);
    $this->db->order_by('a.no_penawaran', DESC);
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
    $this->db->order_by('a.no_penawaran', DESC);
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

  function get_where_in($field, $kunci, $tabel)
  {
    $this->db->where_in($field, $kunci);
    $query = $this->db->get($tabel);
    return $query->result();
  }

  function get_where_in_and($field, $kunci, $and, $tabel)
  {
    $this->db->where_in($field, $kunci);
    $this->db->where($and);
    $query = $this->db->get($tabel);
    return $query->result();
  }

  public function cariDeliveryOrderDetailPengiriman()
  {
    $this->db->select('a.*, b.tgl_do, b.no_surat, c.name_customer');
    $this->db->from('tr_delivery_order_detail a');
    $this->db->join('tr_delivery_order b', 'b.no_do=a.no_do');
    $this->db->join('master_customers c', 'b.id_customer=c.id_customer');

    $query = $this->db->get();
    return $query->result();
  }

  public function cariPlanning($id = null)
  {
    $this->db->select('a.*, c.name_customer as name_customer,d.nama_top');
    $this->db->from('tr_planning_delivery a');
    $this->db->join('master_customers c', 'c.id_customer=a.id_customer');
    $this->db->join('ms_top d', 'd.id_top=a.top');
    $where2 = "a.status_planning ='1'";
    $this->db->where($where2);
    $this->db->order_by('a.no_planning', DESC);
    $query = $this->db->get();
    return $query->result();
  }

  public function cariDeliveryOrderHistory()
  {
    $this->db->select('a.*, b.name_customer as name_customer, c.no_surat as no_surat_spk');
    $this->db->from('tr_delivery_order a');
    $this->db->join('master_customers b', 'b.id_customer=a.id_customer');
    $this->db->join('tr_spk_delivery c', 'c.no_spk=a.no_spk');
    $this->db->where('a.status_confirm', 1);
    $this->db->order_by('a.tgl_do', DESC);
    $query = $this->db->get();
    return $query->result();
  }



  public function cariDeliveryOrderjurnal()
  {

    $this->db->select('a.*, c.no_surat as nomor_spk, b.name_customer as name_customer');
    $this->db->from('tr_delivery_order a');
    $this->db->join('master_customers b', 'b.id_customer=a.id_customer');
    $this->db->join('tr_spk_delivery c', 'c.no_spk=a.no_spk');
    $query = $this->db->get();
    return $query->result();
  }

  public function get_data_history_delivery_order()
  {
    $draw = $this->input->post('draw');
    $start = $this->input->post('start');
    $length = $this->input->post('length');
    $search = $this->input->post('search');

    $this->db->select('a.*, b.name_customer as name_customer, c.no_surat as no_surat_spk');
    $this->db->from('tr_delivery_order a');
    $this->db->join('master_customers b', 'b.id_customer=a.id_customer');
    $this->db->join('tr_spk_delivery c', 'c.no_spk=a.no_spk');
    $this->db->where('a.status_confirm', 1);
    if (!empty($search)) {
      $this->db->group_start();
      $this->db->like('c.no_surat', $search['value'], 'both');
      $this->db->or_like('DATE_FORMAT(a.tgl_do, "%d-%M-%Y")', $search['value'], 'both');
      $this->db->or_like('a.no_surat', $search['value'], 'both');
      $this->db->or_like('b.name_customer', $search['value'], 'both');
      $this->db->or_like('a.no_invoice', $search['value'], 'both');
      $this->db->group_end();
    }
    $this->db->order_by('a.tgl_do', 'desc');
    $this->db->limit($length, $start);
    $query = $this->db->get();

    $this->db->select('a.*, b.name_customer as name_customer, c.no_surat as no_surat_spk');
    $this->db->from('tr_delivery_order a');
    $this->db->join('master_customers b', 'b.id_customer=a.id_customer');
    $this->db->join('tr_spk_delivery c', 'c.no_spk=a.no_spk');
    $this->db->where('a.status_confirm', 1);
    if (!empty($search)) {
      $this->db->group_start();
      $this->db->like('c.no_surat', $search['value'], 'both');
      $this->db->or_like('DATE_FORMAT(a.tgl_do, "%d-%M-%Y")', $search['value'], 'both');
      $this->db->or_like('a.no_surat', $search['value'], 'both');
      $this->db->or_like('b.name_customer', $search['value'], 'both');
      $this->db->or_like('a.no_invoice', $search['value'], 'both');
      $this->db->group_end();
    }
    $this->db->order_by('a.tgl_do', 'desc');
    $query_all = $this->db->get();

    $hasil = [];

    $no = 1 + $start;
    foreach ($query->result() as $item) {

      $view_do = '<a class="btn btn-success btn-sm" href="' . base_url('/wt_delivery_order/viewDO/' . $item->no_do) . '" title="View DO"><i class="fa fa-eye"></i></a>';

      $print_do = '<a class="btn btn-primary btn-sm" target="_blank" href="' . base_url('/wt_delivery_order/printDOHistory/' . $item->no_do) . '" title="Print DO History"><i class="fa fa-print"></i></a>';

      $option = $view_do . ' ' . $print_do;

      $nilai_costbook = 0;

      $no_invoice = [];

      $this->db->select('a.id_category3, a.qty_do, a.tgl_delivery');
      $this->db->from('tr_delivery_order_detail a');
      $this->db->where('a.no_do', $item->no_do);
      $get_detail = $this->db->get()->result();

      foreach ($get_detail as $item_detail) {
        $this->db->select('a.nilai_costbook');
        $this->db->from('ms_costbook_backup a');
        $this->db->where('a.id_category3', $item_detail->id_category3);
        $this->db->where('DATE_FORMAT(a.tgl, "%Y-%m-%d") >=', $item->tgl_do);
        $this->db->where('DATE_FORMAT(a.tgl, "%Y-%m-%d") <=', $item->tgl_do);
        $this->db->limit(1);
        $get_costbook = $this->db->get()->row();

        if (!empty($get_costbook)) {
          $nilai_costbook += ($get_costbook->nilai_costbook * $item_detail->qty_do);
        }
      }

      $hasil[] = [
        'no' => $no,
        'no_spk_delivery' => $item->no_surat_spk,
        'tanggal_do' => date('d-M-Y', strtotime($item->tgl_do)),
        'no_do' => $item->no_surat,
        'nama_customer' => $item->name_customer,
        'no_invoice' => $item->no_invoice,
        'nilai_costbook' => number_format($nilai_costbook, 2),
        'option' => $option
      ];

      $no++;
    }

    echo json_encode([
      'draw' => intval($draw),
      'recordsTotal' => $query_all->num_rows(),
      'recordsFiltered' => $query_all->num_rows(),
      'data' => $hasil
    ]);
  }

  public function get_data_history_delivery_order_detail()
  {
    $draw = $this->input->post('draw');
    $start = $this->input->post('start');
    $length = $this->input->post('length');
    $search = $this->input->post('search');

    $this->db->select('a.*, b.tgl_do, b.no_surat, c.name_customer, d.no_surat as no_invoice');
    $this->db->from('tr_delivery_order_detail a');
    $this->db->join('tr_delivery_order b', 'b.no_do=a.no_do');
    $this->db->join('master_customers c', 'b.id_customer=c.id_customer');
    $this->db->join('tr_invoice d', 'd.no_so = a.no_so', 'left');
    if (!empty($search)) {
      $this->db->group_start();
      $this->db->like('b.no_surat', $search['value'], 'both');
      $this->db->or_like('DATE_FORMAT(b.tgl_do, "%d-%M-%Y")', $search['value'], 'both');
      $this->db->or_like('c.name_customer', $search['value'], 'both');
      $this->db->or_like('a.nama_produk', $search['value'], 'both');
      $this->db->or_like('a.qty_do', $search['value'], 'both');
      $this->db->or_like('a.serial_number', $search['value'], 'both');
      $this->db->or_like('a.kartu_garansi', $search['value'], 'both');
      $this->db->or_like('a.keterangan_statuskirim', $search['value'], 'both');
      $this->db->or_like('d.no_surat', $search['value'], 'both');
      $this->db->group_end();
    }
    $this->db->order_by('a.created_on', 'desc');
    $this->db->limit($length, $start);

    $query = $this->db->get();

    $this->db->select('a.*, b.tgl_do, b.no_surat, c.name_customer, d.no_surat as no_invoice');
    $this->db->from('tr_delivery_order_detail a');
    $this->db->join('tr_delivery_order b', 'b.no_do=a.no_do');
    $this->db->join('master_customers c', 'b.id_customer=c.id_customer');
    $this->db->join('tr_invoice d', 'd.no_so = a.no_so', 'left');
    if (!empty($search)) {
      $this->db->group_start();
      $this->db->like('b.no_surat', $search['value'], 'both');
      $this->db->or_like('DATE_FORMAT(b.tgl_do, "%d-%M-%Y")', $search['value'], 'both');
      $this->db->or_like('c.name_customer', $search['value'], 'both');
      $this->db->or_like('a.nama_produk', $search['value'], 'both');
      $this->db->or_like('a.qty_do', $search['value'], 'both');
      $this->db->or_like('a.serial_number', $search['value'], 'both');
      $this->db->or_like('a.kartu_garansi', $search['value'], 'both');
      $this->db->or_like('a.keterangan_statuskirim', $search['value'], 'both');
      $this->db->or_like('d.no_surat', $search['value'], 'both');
      $this->db->group_end();
    }
    $this->db->order_by('a.created_on', 'desc');

    $query_all = $this->db->get();

    $hasil = [];

    $no = 1 + $start;
    foreach ($query->result() as $item) {

      $costbook = 0;
      $grand_total = 0;

      $this->db->select('a.nilai_costbook');
      $this->db->from('ms_costbook_backup a');
      $this->db->where('a.id_category3', $item->id_category3);
      $this->db->where('DATE_FORMAT(a.tgl, "%Y-%m-%d") >=', $item->tgl_do);
      $this->db->where('DATE_FORMAT(a.tgl, "%Y-%m-%d") <=', $item->tgl_do);
      $this->db->limit(1);
      $get_costbook = $this->db->get()->row();

      if (!empty($get_costbook)) {
        $costbook = ($get_costbook->nilai_costbook);
      }
      $grand_total = ($costbook * $item->qty_do);

      $hasil[] = [
        'no' => $no,
        'no_do' => $item->no_surat,
        'tgl_do' => date('d-M-Y', strtotime($item->tgl_do)),
        'no_invoice' => $item->no_invoice,
        'nama_customer' => $item->name_customer,
        'nama_produk' => $item->nama_produk,
        'qty_kirim' => $item->qty_do,
        'serial_number' => $item->serial_number,
        'no_garansi' => $item->kartu_garansi,
        'keterangan' => $item->keterangan_statuskirim,
        'costbook' => number_format($costbook, 2),
        'grand_total' => number_format($grand_total, 2)
      ];

      $no++;
    }

    echo json_encode([
      'draw' => intval($draw),
      'recordsTotal' => $query_all->num_rows(),
      'recordsFiltered' => $query_all->num_rows(),
      'data' => $hasil
    ]);
  }

  public function get_data_planning_delivery()
  {
    $draw = $this->input->post('draw');
    $start = $this->input->post('start');
    $length = $this->input->post('length');
    $search = $this->input->post('search');

    $this->db->select('a.*, b.name_customer as name_customer, c.grand_total as total_penawaran,d.nama_top');
    $this->db->from('tr_sales_order a');
    $this->db->join('master_customers b', 'b.id_customer=a.id_customer', 'left');
    $this->db->join('tr_penawaran c', 'c.no_penawaran=a.no_penawaran', 'left');
    $this->db->join('ms_top d', 'd.id_top=a.top', 'left');
    $this->db->where_not_in('a.status', ['6', '7']);
    $this->db->where('(SELECT SUM(aa.qty_so) FROM tr_sales_order_detail aa WHERE aa.no_so = a.no_so) <> (SELECT SUM(aa.qty_delivery) FROM tr_sales_order_detail aa WHERE aa.no_so = a.no_so)');

    if (!empty($search['value'])) {
      $this->db->like('a.no_surat', $search['value'], 'both');
      $this->db->or_like('b.name_customer', $search['value'], 'both');
      $this->db->or_like('a.nama_sales', $search['value'], 'both');
      $this->db->or_like('d.nama_top', $search['value'], 'both');
    }
    $this->db->order_by('a.no_surat', 'desc');
    $this->db->limit($length, $start);

    $get_data = $this->db->get();

    $this->db->select('a.*, b.name_customer as name_customer, c.grand_total as total_penawaran,d.nama_top');
    $this->db->from('tr_sales_order a');
    $this->db->join('master_customers b', 'b.id_customer=a.id_customer', 'left');
    $this->db->join('tr_penawaran c', 'c.no_penawaran=a.no_penawaran', 'left');
    $this->db->join('ms_top d', 'd.id_top=a.top', 'left');
    $this->db->where_not_in('a.status', ['6', '7']);
    $this->db->where('(SELECT SUM(aa.qty_so) FROM tr_sales_order_detail aa WHERE aa.no_so = a.no_so) <> (SELECT SUM(aa.qty_delivery) FROM tr_sales_order_detail aa WHERE aa.no_so = a.no_so)');
    if (!empty($search['value'])) {
      $this->db->like('a.no_surat', $search['value'], 'both');
      $this->db->or_like('b.name_customer', $search['value'], 'both');
      $this->db->or_like('a.nama_sales', $search['value'], 'both');
      $this->db->or_like('d.nama_top', $search['value'], 'both');
    }
    $this->db->order_by('a.no_surat', 'desc');

    $get_data_all = $this->db->get();

    $hasil = [];

    $no = (0 + $start);
    foreach ($get_data->result() as $item) :
      $no++;

      $plan = $this->db->query("SELECT sum(qty_so) as total_so, sum(qty_delivery) as total_delivery FROM tr_sales_order_detail WHERE no_so = '" . $item->no_so . "'")->row();
      // if ($item->status <> '6' or $item->status <> '7') {
        // if ($plan->total_so !== $plan->total_delivery) {
          if ($plan->total_delivery == 0  && ($plan->total_so > $plan->total_delivery)) {
            $create = 0;
            $Statusdo = "<span class='badge bg-grey'>Belum Dikirim</span>";
          } elseif ($plan->total_delivery != 0 && ($plan->total_so > $plan->total_delivery)) {
            $create = 1;
            $Statusdo = "<span class='badge bg-blue'>Parsial</span>";
          } elseif ($plan->total_delivery != 0 && ($plan->total_so == $plan->total_delivery)) {
            $create = 2;
            $Statusdo = "<span class='badge bg-green'>Terkirim</span>";
          }
  
          $ENABLE_ADD     = has_permission('Planning_Delivery.Add');
          $ENABLE_MANAGE  = has_permission('Planning_Delivery.Manage');
          $ENABLE_VIEW    = has_permission('Planning_Delivery.View');
          $ENABLE_DELETE  = has_permission('Planning_Delivery.Delete');
  
          $action = '<a class="btn btn-default btn-sm" href="' . base_url('/wt_delivery_order/viewPlanning/' . $item->no_so) . '" title="View SO"><i class="fa fa-eye"></i></a>';
          if ($ENABLE_MANAGE) {
            $action .= ' <a class="btn btn-success btn-sm" href="' . base_url('/wt_delivery_order/createPlanning/' . $item->no_so) . '" title="Create Planning" data-no_inquiry="<?= $record->no_inquiry ?>"> <i class="fa fa-check">Create Planning</i></a>';
          }
  
          $hasil[] = [
            'no' => $no,
            'no_so' => $item->no_surat,
            'nama_customer' => $item->name_customer,
            'marketing' => $item->nama_sales,
            'top' => $item->nama_top,
            'status_pengiriman' => $Statusdo,
            'action' => $action
          ];
        // }
      // }
    endforeach;

    echo json_encode([
      'draw' => intval($draw),
      'recordsTotal' => $get_data_all->num_rows(),
      'recordsFiltered' => $get_data_all->num_rows(),
      'data' => $hasil
    ]);
  }
}
