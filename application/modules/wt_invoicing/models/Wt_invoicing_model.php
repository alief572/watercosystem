<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * @Author Syamsudin
 * @Copyright (c) 2022, Syamsudin
 *
 * This is model class for table "Wt_penawaran"
 */

class Wt_invoicing_model extends BF_Model
{
  /**
   * @var string  User Table Name
   */
  protected $viewPermission   = 'Invoicing.View';
  protected $addPermission    = 'Invoicing.Add';
  protected $managePermission = 'Invoicing.Manage';
  protected $deletePermission = 'Invoicing.Delete';

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

  function generate_id($kode = '')
  {
    $query = $this->db->query("SELECT MAX(id_invoice) as max_id FROM tr_invoice");
    $row = $query->row_array();
    $thn = date('y');
    $max_id = $row['max_id'];
    $max_id1 = (int) substr($max_id, 3, 5);
    $counter = $max_id + 1;
    $idcust = "I" . $thn . str_pad($counter, 5, "0", STR_PAD_LEFT);
    return $counter;
  }

  function generate_code($kode = '')
  {
    $query = $this->db->query("SELECT MAX(no_invoice) as max_id FROM tr_invoice");
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
    $query = $this->db->query("SELECT MAX(no_surat) as max_id FROM tr_invoice WHERE Year(tgl_invoice)='$tahun'");
    $row = $query->row_array();
    $thn = date('T');
    $max_id = $row['max_id'];
    $max_id1 = (int) substr($max_id, 3, 3);
    $counter = $max_id1 + 1;
    $idcust = "WI-" . sprintf("%03s", $counter) . "/" . $bulan . "-" . $tahun;
    return $idcust;
  }

  function BuatNomorProforma($kode = '')
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
    $query = $this->db->query("SELECT MAX(no_proforma_invoice) as max_id FROM tr_invoice WHERE Year(tgl_invoice)='$tahun'");
    $row = $query->row_array();
    $thn = date('T');
    $max_id = $row['max_id'];
    $max_id1 = (int) substr($max_id, 0, 3);
    $counter = $max_id1 + 1;
    $idcust = sprintf("%03s", $counter) . "/PR-WI/" . $romawi . "/" . $tahun;
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

  public function cariPlantagih()
  {
    $this->db->select('a.*,a.keterangan as ket_tagih,b.*, c.name_customer as name_customer, d.nama_top');
    $this->db->from('wt_plan_tagih a');
    $this->db->join('tr_sales_order b', 'b.no_so=a.no_so');
    $this->db->join('master_customers c', 'c.id_customer=b.id_customer');
    $this->db->join('ms_top d', 'd.id_top=a.id_top');
    $where = "a.status_invoice <>'1'";
    // $where2 = "a.status<>'7'";
    $this->db->where($where);
    // $this->db->where($where2);
    // $this->db->order_by('a.no_penawaran', DESC);
    $query = $this->db->get();
    return $query->result();
  }

  public function CariInvoice()
  {
    $this->db->select('a.*, b.name_customer as name_customer,c.nama_top');
    $this->db->from('tr_invoice a');
    $this->db->join('master_customers b', 'b.id_customer=a.id_customer');
    $this->db->join('ms_top c', 'c.id_top=a.top');

    // $where = "a.status<>'6'";
    // $where2 = "a.status<>'7'";
    // $this->db->where($where);
    // $this->db->where($where2);
    $this->db->order_by('a.no_invoice', DESC);
    $query = $this->db->get();
    return $query->result();
  }

  public function CariInvoiceDeal()
  {
    $this->db->select('a.*, b.name_customer as name_customer, c.nama_top');
    $this->db->from('tr_invoice a');
    $this->db->join('master_customers b', 'b.id_customer=a.id_customer');
    $this->db->join('ms_top c', 'c.id_top=a.top');
    $where = "a.no_invoice !=''";
    $where2 = "a.status_close ='0'";
    $this->db->where($where);
    $this->db->where($where2);
    $this->db->order_by('a.no_invoice', DESC);
    $query = $this->db->get();
    return $query->result();
  }
  public function CariInvoiceClose()
  {
    $this->db->select('a.*, b.name_customer as name_customer, c.nama_top');
    $this->db->from('tr_invoice a');
    $this->db->join('master_customers b', 'b.id_customer=a.id_customer');
    $this->db->join('ms_top c', 'c.id_top=a.top');
    $where = "a.no_invoice !=''";
    $where2 = "a.status_close ='1'";
    $this->db->where($where);
    $this->db->where($where2);
    $this->db->order_by('a.no_invoice', DESC);
    $query = $this->db->get();
    return $query->result();
  }

  public function getAlamatSO($so)
  {
    $this->db->select('a.no_so, b.address_office');
    $this->db->from('tr_sales_order a');
    $this->db->join('master_customers b', 'b.id_customer=a.id_customer');
    $where = "a.no_so ='$so'";
    $this->db->where($where);
    $query = $this->db->get();
    return $query->result();
  }

  public function CariInvoiceJurnal()
  {
    $this->db->select('a.*, b.name_customer as name_customer,c.nama_top');
    $this->db->from('tr_invoice a');
    $this->db->join('master_customers b', 'b.id_customer=a.id_customer');
    $this->db->join('ms_top c', 'c.id_top=a.top');
    $where = "a.status_jurnal ='OPN'";
    $this->db->where($where);
    $this->db->order_by('a.no_invoice', DESC);
    $query = $this->db->get();
    return $query->result();
  }

  public function get_data_invoice()
  {
    $draw = $this->input->post('draw');
    $length = $this->input->post('length');
    $start = $this->input->post('start');
    $search = $this->input->post('search');

    $this->db->select('a.*, b.name_customer as name_customer,c.nama_top');
    $this->db->from('tr_invoice a');
    $this->db->join('master_customers b', 'b.id_customer=a.id_customer');
    $this->db->join('ms_top c', 'c.id_top=a.top');
    $this->db->where('1', '1');
    if (!empty($search['value'])) {
      $this->db->like('a.no_surat', $search['value']);
      $this->db->or_like('b.name_customer', $search['value']);
      $this->db->or_like('a.tgl_invoice', $search['value']);
      $this->db->or_like('a.nilai_invoice', $search['value']);
      $this->db->or_like('c.nama_top', $search['value']);
      $this->db->or_like('a.nama_sales', $search['value']);
    }
    $this->db->order_by('a.no_invoice', 'DESC');
    $this->db->limit($length, $start);
    $query = $this->db->get();

    $this->db->select('a.*, b.name_customer as name_customer,c.nama_top');
    $this->db->from('tr_invoice a');
    $this->db->join('master_customers b', 'b.id_customer=a.id_customer');
    $this->db->join('ms_top c', 'c.id_top=a.top');
    $this->db->where('1', '1');
    if (!empty($search['value'])) {
      $this->db->like('a.no_surat', $search['value']);
      $this->db->or_like('b.name_customer', $search['value']);
      $this->db->or_like('a.tgl_invoice', $search['value']);
      $this->db->or_like('a.nilai_invoice', $search['value']);
      $this->db->or_like('c.nama_top', $search['value']);
      $this->db->or_like('a.nama_sales', $search['value']);
    }
    $this->db->order_by('a.no_invoice', 'DESC');
    $query_all = $this->db->get();

    $hasil = [];

    $no = 0;
    foreach ($query->result() as $item) {
      $no++;

      $option = '';
      if (has_permission($this->managePermission) && $item->no_proforma_invoice != '') {
        $option .= '<a class="btn btn-primary btn-sm" href="' . base_url('/wt_invoicing/PrintProformaInvoice/' . $item->id_invoice) . '" target="_blank" title="Cetak Proforma Invoice" data-no_inquiry="' . $item->no_inquiry . '"><i class="fa fa-print"></i></a>';
      }

      if (has_permission($this->managePermission) && $item->no_invoice == '') {
        $option .= '<a class="btn btn-warning btn-sm" href="' . base_url('/wt_invoicing/createDealInvoice/' . $item->id_invoice) . '" target="_blank" title="Create Invoice" data-no_inquiry="' . $item->no_inquiry . '"><i class="fa fa-plus"></i></a>';
      }

      if (has_permission($this->managePermission) && $item->no_invoice != '') {
        $option .= '<a class="btn btn-success btn-sm" href="' . base_url('/wt_invoicing/print_invoice/' . $item->no_invoice) . '" target="_blank" title="Cetak Invoice" data-no_inquiry="' . $item->no_inquiry . '"><i class="fa fa-print"></i></a>';
      }

      $noso =  $item->no_so;
      $so = $this->db->query("SELECT no_surat FROM tr_sales_order WHERE no_so ='$noso' ")->row();


      $hasil[] = [
        'no' => $no,
        'no_invoice' => $item->no_surat,
        'no_so' => $so->no_surat,
        'nama_customer' => $item->name_customer,
        'marketing' => $item->nama_sales,
        'top' => $item->nama_top,
        'payment' => $item->payment,
        'tgl_invoice' => date('d-F-Y', strtotime($item->tgl_invoice)),
        'nilai_invoice' => number_format($item->nilai_invoice),
        'option' => $option
      ];
    }

    echo json_encode([
      'draw' => $draw,
      'recordsTotal' => $query_all->num_rows(),
      'recordsFiltered' => $query_all->num_rows(),
      'data' => $hasil
    ]);
  }
}
