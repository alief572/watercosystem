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

  /**
   * DataTable serverside untuk index Planning Tagih (wt_invoicing/plan_tagih).
   * $can_manage: tampilkan tombol Create Invoice (izin Invoicing.Manage).
   */
  public function get_data_plan_tagih($can_manage)
  {
    $draw = (int) $this->input->post('draw');
    $start = max(0, (int) $this->input->post('start'));
    $length = (int) $this->input->post('length');
    $search = $this->input->post('search');
    $keyword = trim((string) ($search['value'] ?? ''));

    $base = function ($with_search) use ($keyword) {
      $this->db->from('wt_plan_tagih a');
      $this->db->join('tr_sales_order b', 'b.no_so = a.no_so');
      $this->db->join('master_customers c', 'c.id_customer = b.id_customer');
      $this->db->join('ms_top d', 'd.id_top = a.id_top');
      $this->db->where("a.status_invoice <> '1'");
      if ($with_search && $keyword !== '') {
        $this->db->group_start();
        $this->db->like('b.no_surat', $keyword, 'both');
        $this->db->or_like('c.name_customer', $keyword, 'both');
        $this->db->or_like('b.nama_sales', $keyword, 'both');
        $this->db->or_like('d.nama_top', $keyword, 'both');
        $this->db->or_like('a.payment', $keyword, 'both');
        $this->db->or_like('a.keterangan', $keyword, 'both');
        $this->db->group_end();
      }
    };

    // Total pakai join yang sama (inner join), supaya cocok dengan baris yang tampil.
    $base(false);
    $recordsTotal = $this->db->count_all_results();

    if ($keyword !== '') {
      $base(true);
      $recordsFiltered = $this->db->count_all_results();
    } else {
      $recordsFiltered = $recordsTotal;
    }

    $columns = [
      1 => 'b.no_surat',
      2 => 'c.name_customer',
      3 => 'b.nama_sales',
      4 => 'b.tgl_so',
      5 => 'a.tgl_create_inv',
      6 => 'b.grand_total',
      7 => 'a.persentase',
      8 => 'a.nilai_tagih',
      9 => 'd.nama_top',
      10 => 'a.payment',
      11 => 'a.keterangan',
    ];
    $order = $this->input->post('order');
    $col = isset($order[0]['column']) ? (int) $order[0]['column'] : -1;
    $dir = (($order[0]['dir'] ?? 'desc') === 'asc') ? 'ASC' : 'DESC';

    $this->db->select('a.id_plan_tagih, a.tgl_create_inv, a.persentase, a.nilai_tagih, a.payment, a.keterangan AS ket_tagih, a.status_invoice, b.no_surat, b.tgl_so, b.nama_sales, b.grand_total, b.upload_po, c.name_customer, d.nama_top');
    $base(true);
    if (isset($columns[$col])) {
      $this->db->order_by($columns[$col], $dir);
      $this->db->order_by('a.id_plan_tagih', 'DESC');
    } else {
      $this->db->order_by('a.tgl_create_inv', 'DESC');
      $this->db->order_by('a.id_plan_tagih', 'DESC');
    }
    if ($length > 0) {
      $this->db->limit($length, $start);
    }
    $rows = $this->db->get()->result();

    $hasil = [];
    $no = $start;
    foreach ($rows as $r) {
      $no++;

      $po = '';
      if ($r->upload_po !== null && $r->upload_po !== '') {
        $po = '<a class="btn btn-primary btn-sm" target="_blank" href="' . htmlspecialchars('.' . $r->upload_po, ENT_QUOTES) . '" title="View PO"><i class="fa fa-eye"></i></a>';
      }

      $action = '';
      if ($can_manage && $r->status_invoice == '0') {
        $action = '<a class="btn btn-success btn-sm" href="' . base_url('wt_invoicing/createInvoice/' . rawurlencode((string) $r->id_plan_tagih)) . '" title="Create Invoice"><i class="fa fa-check">&nbsp;Create Invoice</i></a>';
      }

      $hasil[] = [
        'no' => $no,
        'no_so' => htmlspecialchars((string) $r->no_surat),
        'customer' => htmlspecialchars(strtoupper((string) $r->name_customer)),
        'marketing' => htmlspecialchars((string) $r->nama_sales),
        'tgl_so' => $r->tgl_so ? date('d-F-Y', strtotime($r->tgl_so)) : '',
        'tgl_inv' => $r->tgl_create_inv ? date('d-F-Y', strtotime($r->tgl_create_inv)) : '',
        'nilai_so' => number_format((float) $r->grand_total, 2),
        'persentase' => htmlspecialchars((string) $r->persentase),
        'nilai_tagih' => number_format((float) $r->nilai_tagih, 2),
        'top' => htmlspecialchars((string) $r->nama_top),
        'payment' => htmlspecialchars((string) $r->payment),
        'keterangan' => htmlspecialchars((string) $r->ket_tagih),
        'po' => $po,
        'action' => $action,
      ];
    }

    echo json_encode([
      'draw' => $draw,
      'recordsTotal' => (int) $recordsTotal,
      'recordsFiltered' => (int) $recordsFiltered,
      'data' => $hasil,
    ]);
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
    $this->db->order_by('a.no_invoice', 'DESC');
    $query = $this->db->get();
    return $query->result();
  }

  /** Query dasar Monitoring Invoice: piutang aktif (sama dengan CariInvoiceDeal). */
  private function _monitoring_base($keyword)
  {
    $this->db->from('tr_invoice a');
    $this->db->join('master_customers b', 'b.id_customer = a.id_customer');
    $this->db->join('ms_top c', 'c.id_top = a.top');
    $this->db->where("a.no_invoice != ''");
    $this->db->where("a.status_close = '0'");
    $this->db->where('a.deleted_by IS NULL');
    if ($keyword !== '') {
      $this->db->group_start();
      $this->db->like('a.no_surat', $keyword, 'both');
      $this->db->or_like('b.name_customer', $keyword, 'both');
      $this->db->or_like('a.nama_sales', $keyword, 'both');
      $this->db->or_like('c.nama_top', $keyword, 'both');
      $this->db->or_like('a.payment', $keyword, 'both');
      $this->db->group_end();
    }
  }

  private function _monitoring_select()
  {
    $this->db->select('a.no_invoice, a.no_surat, a.nama_sales, a.payment, a.nilai_invoice, a.total_bayar_idr, a.tgl_invoice, a.tgl_janji_bayar, a.jatuh_tempo, b.name_customer, c.nama_top');
  }

  /** Nilai tampil satu baris Monitoring Invoice (tanpa kolom no dan action). */
  private function _monitoring_row($r)
  {
    $janji = !empty($r->tgl_janji_bayar) ? $r->tgl_janji_bayar : $r->jatuh_tempo;
    $umur = !empty($r->tgl_invoice) ? (int) floor((strtotime(date('Y-m-d')) - strtotime($r->tgl_invoice)) / 86400) : 0;
    $nilai = (float) $r->nilai_invoice;
    $bayar = (float) $r->total_bayar_idr;
    return [
      'no_surat' => (string) $r->no_surat,
      'customer' => strtoupper((string) $r->name_customer),
      'marketing' => (string) $r->nama_sales,
      'top' => (string) $r->nama_top,
      'payment' => (string) $r->payment,
      'nilai' => number_format($nilai),
      'bayar' => number_format($bayar),
      'sisa' => number_format($nilai - $bayar),
      'tgl_invoice' => !empty($r->tgl_invoice) ? date('d-F-Y', strtotime($r->tgl_invoice)) : '-',
      'janji' => !empty($janji) ? date('d-F-Y', strtotime($janji)) : '-',
      'umur' => $umur . ' Hari',
    ];
  }

  /** DataTable serverside untuk index Monitoring Invoice. */
  public function get_data_monitoring($can_view, $can_manage)
  {
    $draw = (int) $this->input->post('draw');
    $start = max(0, (int) $this->input->post('start'));
    $length = (int) $this->input->post('length');
    $search = $this->input->post('search');
    $keyword = trim((string) ($search['value'] ?? ''));

    $this->_monitoring_base('');
    $recordsTotal = $this->db->count_all_results();
    if ($keyword !== '') {
      $this->_monitoring_base($keyword);
      $recordsFiltered = $this->db->count_all_results();
    } else {
      $recordsFiltered = $recordsTotal;
    }

    $columns = [
      1 => 'a.no_surat',
      2 => 'b.name_customer',
      3 => 'a.nama_sales',
      4 => 'c.nama_top',
      5 => 'a.payment',
      6 => 'a.nilai_invoice',
      7 => 'a.total_bayar_idr',
      8 => '(a.nilai_invoice - a.total_bayar_idr)',
      9 => 'a.tgl_invoice',
      10 => 'COALESCE(a.tgl_janji_bayar, a.jatuh_tempo)',
    ];
    $order = $this->input->post('order');
    $col = isset($order[0]['column']) ? (int) $order[0]['column'] : -1;
    $dir = (($order[0]['dir'] ?? 'desc') === 'asc') ? 'ASC' : 'DESC';

    $this->_monitoring_select();
    $this->_monitoring_base($keyword);
    if (isset($columns[$col])) {
      $this->db->order_by($columns[$col], $dir, false);
    } elseif ($col === 11) {
      // Umur piutang makin besar = tgl_invoice makin lama.
      $this->db->order_by('a.tgl_invoice', $dir === 'ASC' ? 'DESC' : 'ASC');
    } else {
      $this->db->order_by('a.no_invoice', 'DESC');
    }
    $this->db->order_by('a.id', 'DESC');
    if ($length > 0) {
      $this->db->limit($length, $start);
    }
    $rows = $this->db->get()->result();

    $hasil = [];
    $no = $start;
    foreach ($rows as $r) {
      $no++;
      $v = array_map('htmlspecialchars', $this->_monitoring_row($r));
      $id = htmlspecialchars((string) $r->no_invoice, ENT_QUOTES);

      $action = '';
      if ($can_view) {
        $action .= '<a class="btn btn-primary btn-sm history" href="#" title="Riwayat Follow UP" data-no_invoice="' . $id . '"><i class="fa fa-history"></i></a> ';
      }
      if ($can_manage) {
        $action .= '<a class="btn btn-success btn-sm" href="' . base_url('wt_invoicing/FollowUp/' . rawurlencode((string) $r->no_invoice)) . '" title="Follow UP"><i class="fa fa-check"></i></a> ';
        $action .= '<a class="btn btn-warning btn-sm tutup" href="#" title="Close Invoice" data-no_invoice="' . $id . '"><i class="fa fa-close"></i></a>';
      }

      $hasil[] = ['no' => $no] + $v + ['action' => $action];
    }

    echo json_encode([
      'draw' => $draw,
      'recordsTotal' => (int) $recordsTotal,
      'recordsFiltered' => (int) $recordsFiltered,
      'data' => $hasil,
    ]);
  }

  /** Semua baris Monitoring Invoice (sesuai search) untuk ekspor Excel. */
  public function export_data_monitoring($keyword)
  {
    $this->_monitoring_select();
    $this->_monitoring_base(trim((string) $keyword));
    $this->db->order_by('a.no_invoice', 'DESC');
    $out = [];
    foreach ($this->db->get()->result() as $r) {
      $out[] = $this->_monitoring_row($r);
    }
    return $out;
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
    $this->db->where('a.deleted_by', null);
    $this->db->order_by('a.no_invoice', 'DESC');
    $query = $this->db->get();
    return $query->result();
  }
  /** Query dasar Close Invoice: invoice yang sudah ditutup (sama dengan CariInvoiceClose). */
  private function _close_base($keyword)
  {
    $this->db->from('tr_invoice a');
    $this->db->join('master_customers b', 'b.id_customer = a.id_customer');
    $this->db->join('ms_top c', 'c.id_top = a.top');
    $this->db->where("a.no_invoice != ''");
    $this->db->where("a.status_close = '1'");
    if ($keyword !== '') {
      $this->db->group_start();
      $this->db->like('a.no_surat', $keyword, 'both');
      $this->db->or_like('b.name_customer', $keyword, 'both');
      $this->db->or_like('a.nama_sales', $keyword, 'both');
      $this->db->or_like('c.nama_top', $keyword, 'both');
      $this->db->or_like('a.payment', $keyword, 'both');
      $this->db->group_end();
    }
  }

  private function _close_select()
  {
    $this->db->select('a.no_surat, a.nama_sales, a.payment, a.nilai_invoice, a.total_bayar_idr, a.tgl_invoice, a.tgl_terima, a.tgl_janji_bayar, b.name_customer, c.nama_top');
  }

  /** Nilai tampil satu baris Close Invoice. Umur = hari sejak tgl_terima (kosong bila belum diterima). */
  private function _close_row($r)
  {
    $umur = !empty($r->tgl_terima) ? (int) floor((strtotime(date('Y-m-d')) - strtotime($r->tgl_terima)) / 86400) : '-';
    $nilai = (float) $r->nilai_invoice;
    $bayar = (float) $r->total_bayar_idr;
    return [
      'no_surat' => (string) $r->no_surat,
      'customer' => strtoupper((string) $r->name_customer),
      'marketing' => (string) $r->nama_sales,
      'top' => (string) $r->nama_top,
      'payment' => (string) $r->payment,
      'nilai' => number_format($nilai),
      'bayar' => number_format($bayar),
      'sisa' => number_format($nilai - $bayar),
      'tgl_invoice' => !empty($r->tgl_invoice) ? date('d-F-Y', strtotime($r->tgl_invoice)) : '-',
      'janji' => !empty($r->tgl_janji_bayar) ? date('d-m-Y', strtotime($r->tgl_janji_bayar)) : '-',
      'umur' => (string) $umur,
    ];
  }

  /** DataTable serverside untuk index Close Invoice. */
  public function get_data_close()
  {
    $draw = (int) $this->input->post('draw');
    $start = max(0, (int) $this->input->post('start'));
    $length = (int) $this->input->post('length');
    $search = $this->input->post('search');
    $keyword = trim((string) ($search['value'] ?? ''));

    $this->_close_base('');
    $recordsTotal = $this->db->count_all_results();
    if ($keyword !== '') {
      $this->_close_base($keyword);
      $recordsFiltered = $this->db->count_all_results();
    } else {
      $recordsFiltered = $recordsTotal;
    }

    $columns = [
      1 => 'a.no_surat',
      2 => 'b.name_customer',
      3 => 'a.nama_sales',
      4 => 'c.nama_top',
      5 => 'a.payment',
      6 => 'a.nilai_invoice',
      7 => 'a.total_bayar_idr',
      8 => '(a.nilai_invoice - a.total_bayar_idr)',
      9 => 'a.tgl_invoice',
      10 => 'a.tgl_janji_bayar',
    ];
    $order = $this->input->post('order');
    $col = isset($order[0]['column']) ? (int) $order[0]['column'] : -1;
    $dir = (($order[0]['dir'] ?? 'desc') === 'asc') ? 'ASC' : 'DESC';

    $this->_close_select();
    $this->_close_base($keyword);
    if (isset($columns[$col])) {
      $this->db->order_by($columns[$col], $dir, false);
    } elseif ($col === 11) {
      // Umur makin besar = tgl_terima makin lama.
      $this->db->order_by('a.tgl_terima', $dir === 'ASC' ? 'DESC' : 'ASC');
    } else {
      $this->db->order_by('a.no_invoice', 'DESC');
    }
    $this->db->order_by('a.id', 'DESC');
    if ($length > 0) {
      $this->db->limit($length, $start);
    }
    $rows = $this->db->get()->result();

    $hasil = [];
    $no = $start;
    foreach ($rows as $r) {
      $no++;
      $hasil[] = ['no' => $no] + array_map('htmlspecialchars', $this->_close_row($r));
    }

    echo json_encode([
      'draw' => $draw,
      'recordsTotal' => (int) $recordsTotal,
      'recordsFiltered' => (int) $recordsFiltered,
      'data' => $hasil,
    ]);
  }

  /** Semua baris Close Invoice (sesuai search) untuk ekspor Excel. */
  public function export_data_close($keyword)
  {
    $this->_close_select();
    $this->_close_base(trim((string) $keyword));
    $this->db->order_by('a.no_invoice', 'DESC');
    $out = [];
    foreach ($this->db->get()->result() as $r) {
      $out[] = $this->_close_row($r);
    }
    return $out;
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
    $this->db->order_by('a.no_invoice', 'DESC');
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

  /** DataTable serverside untuk index Jurnal Invoicing: invoice yang belum dijurnal (status_jurnal OPN). */
  public function get_data_jurnal_invoicing($can_manage)
  {
    $draw = (int) $this->input->post('draw');
    $start = max(0, (int) $this->input->post('start'));
    $length = (int) $this->input->post('length');
    $search = $this->input->post('search');
    $keyword = trim((string) ($search['value'] ?? ''));

    $base = function ($with_search) use ($keyword) {
      $this->db->from('tr_invoice a');
      $this->db->join('master_customers b', 'b.id_customer = a.id_customer');
      $this->db->join('ms_top c', 'c.id_top = a.top');
      $this->db->where('a.status_jurnal', 'OPN');
      if ($with_search && $keyword !== '') {
        $this->db->group_start();
        $this->db->like('a.no_surat', $keyword, 'both');
        $this->db->or_like('b.name_customer', $keyword, 'both');
        $this->db->or_like('a.nama_sales', $keyword, 'both');
        $this->db->or_like('c.nama_top', $keyword, 'both');
        $this->db->or_like('a.payment', $keyword, 'both');
        $this->db->group_end();
      }
    };

    $base(false);
    $recordsTotal = $this->db->count_all_results();
    if ($keyword !== '') {
      $base(true);
      $recordsFiltered = $this->db->count_all_results();
    } else {
      $recordsFiltered = $recordsTotal;
    }

    $columns = [
      1 => 'a.no_surat',
      2 => 'b.name_customer',
      3 => 'a.nama_sales',
      4 => 'c.nama_top',
      5 => 'a.payment',
      6 => 'a.nilai_invoice',
      7 => 'a.tgl_invoice',
    ];
    $order = $this->input->post('order');
    $col = isset($order[0]['column']) ? (int) $order[0]['column'] : -1;
    $dir = (($order[0]['dir'] ?? 'desc') === 'asc') ? 'ASC' : 'DESC';

    $this->db->select('a.no_invoice, a.no_surat, a.nama_sales, a.payment, a.nilai_invoice, a.tgl_invoice, b.name_customer, c.nama_top');
    $base(true);
    if (isset($columns[$col])) {
      $this->db->order_by($columns[$col], $dir);
    } else {
      $this->db->order_by('a.no_invoice', 'DESC');
    }
    $this->db->order_by('a.id', 'DESC');
    if ($length > 0) {
      $this->db->limit($length, $start);
    }
    $rows = $this->db->get()->result();

    $hasil = [];
    $no = $start;
    foreach ($rows as $r) {
      $no++;
      $action = '';
      if ($can_manage) {
        $action = '<a class="btn btn-success btn-sm view3" href="javascript:void(0)" title="Create Jurnal" data-id_material="' . htmlspecialchars((string) $r->no_invoice, ENT_QUOTES) . '"><i class="fa fa-check"></i></a>';
      }
      $hasil[] = [
        'no' => $no,
        'no_surat' => htmlspecialchars((string) $r->no_surat),
        'customer' => htmlspecialchars(strtoupper((string) $r->name_customer)),
        'marketing' => htmlspecialchars((string) $r->nama_sales),
        'top' => htmlspecialchars((string) $r->nama_top),
        'payment' => htmlspecialchars((string) $r->payment),
        'nilai' => number_format((float) $r->nilai_invoice),
        'tgl_invoice' => !empty($r->tgl_invoice) ? date('d-F-Y', strtotime($r->tgl_invoice)) : '-',
        'action' => $action,
      ];
    }

    echo json_encode([
      'draw' => $draw,
      'recordsTotal' => (int) $recordsTotal,
      'recordsFiltered' => (int) $recordsFiltered,
      'data' => $hasil,
    ]);
  }

  public function CariInvoiceJurnal()
  {
    $this->db->select('a.*, b.name_customer as name_customer,c.nama_top');
    $this->db->from('tr_invoice a');
    $this->db->join('master_customers b', 'b.id_customer=a.id_customer');
    $this->db->join('ms_top c', 'c.id_top=a.top');
    $where = "a.status_jurnal ='OPN'";
    $this->db->where($where);
    $this->db->order_by('a.no_invoice', 'DESC');
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
    $this->db->where('a.deleted_by IS NULL');
    if (!empty($search['value'])) {
      $this->db->group_start();
      $this->db->like('a.no_surat', $search['value']);
      $this->db->or_like('b.name_customer', $search['value']);
      $this->db->or_like('a.tgl_invoice', $search['value']);
      $this->db->or_like('a.nilai_invoice', $search['value']);
      $this->db->or_like('c.nama_top', $search['value']);
      $this->db->or_like('a.nama_sales', $search['value']);
      $this->db->group_end();
    }
    $this->db->order_by('a.no_invoice', 'DESC');
    $this->db->limit($length, $start);
    $query = $this->db->get();

    $this->db->select('a.*, b.name_customer as name_customer,c.nama_top');
    $this->db->from('tr_invoice a');
    $this->db->join('master_customers b', 'b.id_customer=a.id_customer');
    $this->db->join('ms_top c', 'c.id_top=a.top');
    $this->db->where('a.deleted_by IS NULL');
    if (!empty($search['value'])) {
      $this->db->group_start();
      $this->db->like('a.no_surat', $search['value']);
      $this->db->or_like('b.name_customer', $search['value']);
      $this->db->or_like('a.tgl_invoice', $search['value']);
      $this->db->or_like('a.nilai_invoice', $search['value']);
      $this->db->or_like('c.nama_top', $search['value']);
      $this->db->or_like('a.nama_sales', $search['value']);
      $this->db->group_end();
    }
    $this->db->order_by('a.no_invoice', 'DESC');
    $query_all = $this->db->get();

    $hasil = [];

    $no = 0;
    foreach ($query->result() as $item) {
      $no++;

      $option = '';
      if (has_permission($this->managePermission) && $item->no_proforma_invoice != '') {
        $option .= '<a class="btn btn-primary btn-sm" href="' . base_url('/wt_invoicing/PrintProformaInvoice/' . $item->id_invoice) . '" target="_blank" title="Cetak Proforma Invoice"><i class="fa fa-print"></i></a>';
      }

      if (has_permission($this->managePermission) && $item->no_invoice == '') {
        $option .= '<a class="btn btn-warning btn-sm" href="' . base_url('/wt_invoicing/createDealInvoice/' . $item->id_invoice) . '" target="_blank" title="Create Invoice"><i class="fa fa-plus"></i></a>';
      }

      if (has_permission($this->managePermission) && $item->no_invoice != '') {
        $option .= '<a class="btn btn-success btn-sm" href="' . base_url('/wt_invoicing/print_invoice/' . $item->no_invoice) . '" target="_blank" title="Cetak Invoice"><i class="fa fa-print"></i></a>';
      }

      $noso =  $item->no_so;
      $so = $this->db->query('SELECT no_surat FROM tr_sales_order WHERE no_so = ?', [$noso])->row();


      $hasil[] = [
        'no' => $no,
        'no_invoice' => $item->no_surat,
        'no_so' => $so->no_surat ?? '',
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

  public function get_efaktur()
  {
    $draw   = $this->input->post('draw');
    $length = $this->input->post('length');
    $start  = $this->input->post('start');
    $search = $this->input->post('search');
    $search_val = is_array($search) ? (isset($search['value']) ? $search['value'] : '') : $search;

    $this->db->select('a.*, b.name_customer, b.npwp, b.npwp_name, b.npwp_address, b.facility, b.email, c.nama_top');
    $this->db->from('tr_invoice a');
    $this->db->join('master_customers b', 'b.id_customer = a.id_customer', 'left');
    $this->db->join('ms_top c', 'c.id_top = a.top', 'left');
    $this->db->where('a.stat_efaktur', 0);
    $this->db->where('a.deleted_by IS NULL');

    if (!empty($search_val)) {
      $this->_apply_efaktur_search($search_val);
    }
    $this->db->order_by('a.tgl_invoice', 'DESC');
    $this->db->order_by('a.no_invoice', 'DESC');
    if ($length != -1) {
      $this->db->limit($length, $start);
    }
    $query = $this->db->get();

    // Total filtered query
    $this->db->select('a.id');
    $this->db->from('tr_invoice a');
    $this->db->join('master_customers b', 'b.id_customer = a.id_customer', 'left');
    $this->db->join('ms_top c', 'c.id_top = a.top', 'left');
    $this->db->where('a.stat_efaktur', 0);
    $this->db->where('a.deleted_by IS NULL');
    if (!empty($search_val)) {
      $this->_apply_efaktur_search($search_val);
    }
    $recordsFiltered = $this->db->count_all_results();

    // Total records
    $this->db->where('stat_efaktur', 0);
    $this->db->where('deleted_by IS NULL');
    $recordsTotal = $this->db->count_all_results('tr_invoice');

    $hasil = [];
    $no = $start;

    foreach ($query->result() as $item) {
      $no++;
      $clean_npwp = preg_replace('/[^0-9]/', '', (string)$item->npwp);
      $has_npwp = !empty($clean_npwp);

      if ($has_npwp) {
        $npwp_badge = '<span class="label label-success" title="' . htmlspecialchars($item->npwp) . '">' . htmlspecialchars($item->npwp) . '</span>';
      } else {
        $npwp_badge = '<span class="label label-danger">KOSONG</span>';
      }

      $invoice_key = !empty($item->no_surat) ? $item->no_surat : $item->no_invoice;
      $checkbox = '<input type="checkbox" name="set_choose_invoice[]" class="set_choose_invoice" value="' . $invoice_key . '" data-npwp="' . ($has_npwp ? 'valid' : 'invalid') . '">';

      $dpp = (float)$item->dpp;
      if ($dpp <= 0) {
        $nilai = (float)$item->nilai_invoice > 0 ? (float)$item->nilai_invoice : (float)$item->grand_total;
        $dpp = ceil((11 / 12) * $nilai);
      }

      $nilai_ppn = (float)$item->nilai_ppn;
      if ($item->facility == 'Kawasan Berikat') {
        $nilai_ppn = 0;
      }

      $hasil[] = [
        'no'            => $no,
        'checkbox'      => $checkbox,
        'no_invoice'    => $invoice_key,
        'tgl_invoice'   => date('d-m-Y', strtotime($item->tgl_invoice)),
        'nama_customer' => $item->name_customer,
        'npwp'          => $npwp_badge,
        'dpp'           => number_format($dpp, 2),
        'nilai_ppn'     => number_format($nilai_ppn, 2),
        'grand_total'   => number_format($item->grand_total, 2),
      ];
    }

    echo json_encode([
      'draw'            => intval($draw),
      'recordsTotal'    => $recordsTotal,
      'recordsFiltered' => $recordsFiltered,
      'data'            => $hasil
    ]);
  }

  public function get_all_efaktur_id()
  {
    $search = $this->input->post('search');
    $search_val = is_array($search) ? (isset($search['value']) ? $search['value'] : '') : $search;

    $this->db->select('a.no_surat, a.no_invoice');
    $this->db->from('tr_invoice a');
    $this->db->join('master_customers b', 'b.id_customer = a.id_customer', 'left');
    $this->db->where('a.stat_efaktur', 0);
    $this->db->where('a.deleted_by IS NULL');

    if (!empty($search_val)) {
      $this->_apply_efaktur_search($search_val);
    }

    $query = $this->db->get();

    $ids = [];
    foreach ($query->result() as $row) {
      $ids[] = !empty($row->no_surat) ? $row->no_surat : $row->no_invoice;
    }
    return $ids;
  }

  private function _apply_efaktur_search($search_val)
  {
    $search_val = trim($search_val);
    if ($search_val === '') {
      return;
    }

    $clean_num = preg_replace('/[^0-9]/', '', $search_val);

    $this->db->group_start();
    // 1. No. Invoice (no_surat dan no_invoice internal)
    $this->db->like('a.no_surat', $search_val);
    $this->db->or_like('a.no_invoice', $search_val);

    // 2. Tanggal Invoice (format DB Y-m-d dan format tampilan d-m-Y, d/m/Y, d M Y, d-M-Y)
    $this->db->or_like('a.tgl_invoice', $search_val);
    $this->db->or_like("DATE_FORMAT(a.tgl_invoice, '%d-%m-%Y')", $search_val);
    $this->db->or_like("DATE_FORMAT(a.tgl_invoice, '%d/%m/%Y')", $search_val);
    $this->db->or_like("DATE_FORMAT(a.tgl_invoice, '%d-%M-%Y')", $search_val);
    $this->db->or_like("DATE_FORMAT(a.tgl_invoice, '%d %M %Y')", $search_val);

    // 3. Nama Customer
    $this->db->or_like('b.name_customer', $search_val);
    $this->db->or_like('b.npwp_name', $search_val);

    // 4. NPWP Customer (teks berformat, angka bersih, atau kata kunci 'kosong')
    $this->db->or_like('b.npwp', $search_val);
    if (!empty($clean_num)) {
      $this->db->or_like("REPLACE(REPLACE(REPLACE(b.npwp, '.', ''), '-', ''), ' ', '')", $clean_num);
    }
    if (strtolower($search_val) === 'kosong') {
      $this->db->or_where("b.npwp IS NULL OR b.npwp = '' OR b.npwp = '0'");
    }
    $this->db->group_end();
  }

  public function list_efaktur()
  {
    $draw   = $this->input->post('draw');
    $length = $this->input->post('length');
    $start  = $this->input->post('start');
    $search = $this->input->post('search');

    $this->db->select('id_export, date_export, time_export, COUNT(invoice_no) as total_inv');
    $this->db->from('faktur_e_logs');
    if (!empty($search['value'])) {
      $this->db->group_start();
      $this->db->like('id_export', $search['value']);
      $this->db->or_like('date_export', $search['value']);
      $this->db->group_end();
    }
    $this->db->group_by('id_export, date_export, time_export');
    $this->db->order_by('id_export', 'DESC');
    if ($length != -1) {
      $this->db->limit($length, $start);
    }
    $query = $this->db->get();

    // Count distinct id_export
    $this->db->select('COUNT(DISTINCT id_export) as total');
    $this->db->from('faktur_e_logs');
    if (!empty($search['value'])) {
      $this->db->group_start();
      $this->db->like('id_export', $search['value']);
      $this->db->or_like('date_export', $search['value']);
      $this->db->group_end();
    }
    $resFiltered = $this->db->get()->row();
    $recordsFiltered = $resFiltered ? (int)$resFiltered->total : 0;

    $this->db->select('COUNT(DISTINCT id_export) as total');
    $resTotal = $this->db->get('faktur_e_logs')->row();
    $recordsTotal = $resTotal ? (int)$resTotal->total : 0;

    $hasil = [];
    $no = $start;

    foreach ($query->result() as $item) {
      $no++;
      $btn_download = '<a href="' . base_url('wt_invoicing/export_coretax_excel_row?getID=' . $item->id_export) . '" class="btn btn-sm btn-success" title="Download Excel CoreTax"><i class="fa fa-file-excel-o"></i> Unduh Excel</a>';

      $hasil[] = [
        'no'          => $no,
        'id_export'   => $item->id_export,
        'date_export' => date('d-m-Y', strtotime($item->date_export)),
        'time_export' => $item->time_export ? date('H:i:s', strtotime($item->time_export)) : '-',
        'total_inv'   => '<span class="badge bg-blue">' . $item->total_inv . ' Invoice</span>',
        'action'      => $btn_download
      ];
    }

    echo json_encode([
      'draw'            => intval($draw),
      'recordsTotal'    => $recordsTotal,
      'recordsFiltered' => $recordsFiltered,
      'data'            => $hasil
    ]);
  }

  public function get_export_coretax_data($invoices = [])
  {
    if (empty($invoices)) {
      return [];
    }

    $this->db->select('a.*, b.name_customer, b.npwp, b.npwp_name, b.npwp_address, b.facility, b.email, b.address_office');
    $this->db->from('tr_invoice a');
    $this->db->join('master_customers b', 'b.id_customer = a.id_customer', 'left');
    $this->db->group_start();
    $this->db->where_in('a.no_surat', $invoices);
    $this->db->or_where_in('a.no_invoice', $invoices);
    $this->db->group_end();
    $this->db->order_by('a.tgl_invoice', 'ASC');
    $headers = $this->db->get()->result_array();

    $result = [];
    foreach ($headers as $hd) {
      $no_inv = $hd['no_invoice'];
      $details = $this->db->get_where('tr_invoice_detail', ['no_invoice' => $no_inv])->result_array();
      if (empty($details) && !empty($hd['id_invoice'])) {
        $details = $this->db->get_where('tr_invoice_detail', ['id_invoice' => $hd['id_invoice']])->result_array();
      }

      $result[] = [
        'header'  => $hd,
        'details' => $details
      ];
    }

    return $result;
  }
}
