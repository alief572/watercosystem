<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * @Author Syamsudin
 * @Copyright (c) 2022, Syamsudin
 *
 * This is model class for table "Wt_penawaran"
 */

class Wt_penawaran_model extends BF_Model
{
  /**
   * @var string  User Table Name
   */
  protected $table_name = 'tr_penawaran';
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

  protected $viewPermission   = 'Penawaran.View';
  protected $addPermission    = 'Penawaran.Add';
  protected $managePermission = 'Penawaran.Manage';
  protected $deletePermission = 'Penawaran.Delete';

  public function __construct()
  {
    parent::__construct();
  }

  function generate_code($kode = '')
  {
    $query = $this->db->query("SELECT MAX(no_penawaran) as max_id FROM tr_penawaran");
    $row = $query->row_array();
    $thn = date('y');
    $max_id = $row['max_id'];
    $max_id1 = (int) substr($max_id, 3, 5);
    $counter = $max_id1 + 1;
    $idcust = "P" . $thn . str_pad($counter, 5, "0", STR_PAD_LEFT);
    return $idcust;
  }
  function BuatNomor($tgl)
  {
    $bulan = date('m', strtotime($tgl));
    $tahun = date('Y', strtotime($tgl));
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
    $query = $this->db->query("SELECT MAX(no_surat) as max_id FROM tr_penawaran WHERE month(tgl_penawaran)='$bulan' and Year(tgl_penawaran)='$tahun'");
    $row = $query->row_array();
    $thn = date('T');
    $max_id = $row['max_id'];
    $max_id1 = (int) substr($max_id, 0, 3);
    $counter = $max_id1 + 1;
    $idcust = sprintf("%03s", $counter) . "/WI/SP/" . $romawi . "/" . $tahun;
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
  public function CariPenawaran()
  {
    $this->db->select('a.*, b.name_customer as name_customer');
    $this->db->from('tr_penawaran a');
    $this->db->join('master_customers b', 'b.id_customer=a.id_customer');
    $where = "a.status<>'6'";
    $where2 = "a.status<>'7'";
    $this->db->where($where);
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
    $where2 = "a.status_so='0'";
    $this->db->where($where);
    $this->db->where($where2);
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
    $this->db->select('a.no_surat, a.nama_sales, a.nilai_penawaran, a.tgl_penawaran, a.revisi,a.no_penawaran,a.status, b.name_customer as name_customer');
    $this->db->from('tr_penawaran_history a');
    $this->db->join('master_customers b', 'b.id_customer=a.id_customer');
    $query1 = $this->db->get_compiled_select();

    $this->db->select('a.no_surat, a.nama_sales, a.nilai_penawaran, a.tgl_penawaran, a.revisi,a.no_penawaran,a.status, b.name_customer as name_customer');
    $this->db->from('tr_penawaran  a');
    $this->db->join('master_customers b', 'b.id_customer=a.id_customer');
    $where = "a.status_so='1'";
    $this->db->where($where);
    $query2 = $this->db->get_compiled_select();

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

  public function CariHeaderHistoryso($no, $rev)
  {
    $this->db->select('a.*, b.name_customer as name_customer');
    $this->db->from('tr_penawaran a');
    $this->db->join('master_customers b', 'b.id_customer=a.id_customer');
    $where = "a.no_penawaran='$no'";
    $where2 = "a.revisi='$rev'";
    $this->db->where($where);
    $this->db->where($where2);
    $this->db->order_by('a.no_penawaran', DESC);
    $query = $this->db->get();
    return $query->result();
  }
  public function CariDetailHistoryso($no, $rev)
  {
    $this->db->select('a.*');
    $this->db->from('tr_penawaran_detail a');
    $where = "a.no_penawaran='$no'";
    $where2 = "a.revisi='$rev'";
    $this->db->where($where);
    $this->db->where($where2);
    $query = $this->db->get();
    return $query->result();
  }

  public function get_penawaran()
  {
    $draw = $this->input->post('draw');
    $length = $this->input->post('length');
    $start = $this->input->post('start');
    $search = $this->input->post('search');

    $this->db->select('a.*, b.name_customer as name_customer');
    $this->db->from('tr_penawaran a');
    $this->db->join('master_customers b', 'b.id_customer=a.id_customer');
    $this->db->where('a.status <>', 6);
    $this->db->where('a.status <>', 7);
    if (!empty($search['value'])) {
      $this->db->group_start();
      $this->db->like('a.no_surat', $search['value'], 'both');
      $this->db->or_like('a.no_revisi', $search['value'], 'both');
      $this->db->or_like('b.name_customer', $search['value'], 'both');
      $this->db->or_like('a.nama_sales', $search['value'], 'both');
      $this->db->or_like('a.grand_total', $search['value'], 'both');
      $this->db->or_like('a.tgl_penawaran', $search['value'], 'both');
      $this->db->or_like('a.keterangan_approve', $search['value'], 'both');
      $this->db->or_like('a.revisi', $search['value'], 'both');
      $this->db->group_end();
    }
    $this->db->order_by('a.no_penawaran', 'desc');
    $this->db->limit($length, $start);
    $get_data = $this->db->get();

    $this->db->select('a.*, b.name_customer as name_customer');
    $this->db->from('tr_penawaran a');
    $this->db->join('master_customers b', 'b.id_customer=a.id_customer');
    $this->db->where('a.status <>', 6);
    $this->db->where('a.status <>', 7);
    if (!empty($search['value'])) {
      $this->db->group_start();
      $this->db->like('a.no_surat', $search['value'], 'both');
      $this->db->or_like('a.no_revisi', $search['value'], 'both');
      $this->db->or_like('b.name_customer', $search['value'], 'both');
      $this->db->or_like('a.nama_sales', $search['value'], 'both');
      $this->db->or_like('a.grand_total', $search['value'], 'both');
      $this->db->or_like('a.tgl_penawaran', $search['value'], 'both');
      $this->db->or_like('a.keterangan_approve', $search['value'], 'both');
      $this->db->or_like('a.revisi', $search['value'], 'both');
      $this->db->group_end();
    }
    $this->db->order_by('a.no_penawaran', 'desc');
    $get_data_all = $this->db->get();

    $hasil = array();

    $no = (0 + $start);
    foreach ($get_data->result() as $item) {

      if ($item->status == 0) {
        $Status = "<span class='badge bg-grey'>Draft</span>";
      } elseif ($item->status == 1) {

        $Status = "<span class='badge bg-yellow'>Menunggu Approval</span>";
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

      $option = '';

      if ($item->status != '4') {
        if (has_permission($this->managePermission) && $item->status == '2') {
          $option .= '<a class="btn btn-primary btn-sm" href="' . base_url('/wt_penawaran/editpenawaranapprove/' . $item->no_penawaran) . '" title="Edit" data-no_inquiry="<?= $record->no_inquiry ?>"><i class="fa fa-edit"></i></a>';
        }
      }

      if ($item->status != '1') {
        if ($item->status != '4') {
          if (has_permission($this->managePermission) && $item->status != '2') {
            $option .= ' <a class="btn btn-primary btn-sm" href="' . base_url('/wt_penawaran/editpenawaran/' . $item->no_penawaran) . '" title="Edit" data-no_inquiry="<?= $record->no_inquiry ?>"><i class="fa fa-edit"></i></a>';
          }
        }
      }

      if (has_permission($this->viewPermission) && $item->status != '4') {
        $option .= ' <a class="btn btn-info btn-sm" href="' . base_url('/wt_penawaran/printpenawaran/' . $item->no_penawaran) . '" target="_blank" title="Print" data-no_inquiry="' . $item->no_inquiry . '"><i class="fa fa-print"></i></a>';
      }

      if (has_permission($this->managePermission) && $item->status != '4' && $item->printed_by != null) {
        $option .= ' <a class="btn btn-success btn-sm" href="' . base_url('/wt_penawaran/statusterkirim/' . $item->no_penawaran) . '" title="Ubah Status" data-no_inquiry="' . $item->no_inquiry . '"><i class="fa fa-check"></i></a>';
      }

      if (has_permission($this->managePermission) && $item->status != '4') {
        $option .= ' <a class="btn btn-warning btn-sm" href="' . base_url('/wt_penawaran/ajukanapprove/' . $item->no_penawaran) . '" title="Ajukan approval" data-no_inquiry="' . $item->no_inquiry . '"><i class="fa fa-mail-forward"></i></a>';
      }

      if (has_permission($this->managePermission) && $item->status == '4' && $item->printed_by != null) {
        $option .= ' <a class="btn btn-success btn-sm" href="' . base_url('/wt_sales_order/createSO/' . $item->no_penawaran) . '" title="Create SO" data-no_inquiry="' . $item->no_inquiry . '"><i class="fa fa-plus">Create SO</i></a>';
      }

      if (has_permission($this->managePermission) && $item->status == '4') {
        $option .= ' <a class="btn btn-danger btn-sm" href="' . base_url('/wt_penawaran/statusloss/' . $item->no_penawaran) . '" title="Loss" data-no_inquiry="' . $item->no_inquiry . '"><i class="fa fa-check"></i>';
      }

      if ($item->status != '6' || $item->status != '7') {
        $no++;
        $hasil[] = [
          'no' => $no,
          'no_penawaran' => $item->no_surat,
          'no_revisi' => $item->no_revisi,
          'nama_customer' => strtoupper($item->name_customer),
          'marketing' => $item->nama_sales,
          'nilai_penawaran' => number_format($item->grand_total),
          'tanggal_penawaran' => date('d-F-Y', strtotime($item->tgl_penawaran)),
          'keterangan_approved' => $item->keterangan_approve,
          'revisi' => $item->revisi,
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

  public function get_loss_penawaran()
  {
    $draw = $this->input->post('draw');
    $length = $this->input->post('length');
    $start = $this->input->post('start');
    $search = $this->input->post('search');

    $this->db->select('a.*, b.name_customer as name_customer');
    $this->db->from('tr_penawaran a');
    $this->db->join('master_customers b', 'b.id_customer=a.id_customer');
    $this->db->where('a.status', 7);
    if (!empty($search['value'])) {
      $this->db->group_start();
      $this->db->like('a.no_surat', $search['value'], 'both');
      $this->db->or_like('a.no_revisi', $search['value'], 'both');
      $this->db->or_like('b.name_customer', $search['value'], 'both');
      $this->db->or_like('a.nama_sales', $search['value'], 'both');
      $this->db->or_like('a.grand_total', $search['value'], 'both');
      $this->db->or_like('a.tgl_penawaran', $search['value'], 'both');
      $this->db->or_like('a.keterangan_approve', $search['value'], 'both');
      $this->db->or_like('a.revisi', $search['value'], 'both');
      $this->db->group_end();
    }
    $this->db->order_by('a.no_penawaran', 'desc');
    $this->db->limit($length, $start);
    $get_data = $this->db->get();

    $this->db->select('a.*, b.name_customer as name_customer');
    $this->db->from('tr_penawaran a');
    $this->db->join('master_customers b', 'b.id_customer=a.id_customer');
    $this->db->where('a.status', 7);
    if (!empty($search['value'])) {
      $this->db->group_start();
      $this->db->like('a.no_surat', $search['value'], 'both');
      $this->db->or_like('a.no_revisi', $search['value'], 'both');
      $this->db->or_like('b.name_customer', $search['value'], 'both');
      $this->db->or_like('a.nama_sales', $search['value'], 'both');
      $this->db->or_like('a.grand_total', $search['value'], 'both');
      $this->db->or_like('a.tgl_penawaran', $search['value'], 'both');
      $this->db->or_like('a.keterangan_approve', $search['value'], 'both');
      $this->db->or_like('a.revisi', $search['value'], 'both');
      $this->db->group_end();
    }
    $this->db->order_by('a.no_penawaran', 'desc');
    $get_data_all = $this->db->get();

    $hasil = array();

    $no = (0 + $start);
    foreach ($get_data->result() as $item) {
      $no++;
      if ($item->status == 0) {
        $Status = "<span class='badge bg-grey'>Draft</span>";
      } elseif ($item->status == 1) {

        $Status = "<span class='badge bg-yellow'>Menunggu Approval</span>";
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

      $option = '<a class="btn btn-primary btn-sm" href="' . base_url('/wt_penawaran/lihatpenawaran/' . $item->no_penawaran) . '" title="View" data-no_inquiry="' . $item->no_inquiry . '"><i class="fa fa-search"></i></a>';

      $hasil[] = [
        'no' => $no,
        'no_penawaran' => $item->no_surat,
        'no_revisi' => $item->no_revisi,
        'nama_customer' => strtoupper($item->name_customer),
        'marketing' => $item->nama_sales,
        'nilai_penawaran' => number_format($item->grand_total),
        'tanggal_penawaran' => date('d-F-Y', strtotime($item->tgl_penawaran)),
        'keterangan_approved' => $item->keterangan_approve,
        'revisi' => $item->revisi,
        'status' => $Status,
        'option' => $option
      ];
    }

    echo json_encode([
      'draw' => intval($draw),
      'recordsTotal' => $get_data_all->num_rows(),
      'recordsFiltered' => $get_data_all->num_rows(),
      'data' => $hasil
    ]);
  }

  public function get_history_penawaran()
  {
    $draw = $this->input->post('draw');
    $length = $this->input->post('length');
    $start = $this->input->post('start');
    $search = $this->input->post('search');

    $where_search = '';
    if (!empty($search['value'])) {
      $where_search = '
        AND (
            z.no_surat LIKE "%' . $search['value'] . '%"
            OR z.nama_sales LIKE "%' . $search['value'] . '%"
            OR z.nilai_penawaran LIKE "%' . $search['value'] . '%"
            OR z.tgl_penawaran LIKE "%' . $search['value'] . '%"
            OR z.revisi LIKE "%' . $search['value'] . '%"
            OR z.no_penawaran LIKE "%' . $search['value'] . '%"
            OR z.name_customer LIKE "%' . $search['value'] . '%"
        )
      ';
    }

    $query = '
      SELECT
        z.no_surat, 
        z.nama_sales, 
        z.nilai_penawaran, 
        z.tgl_penawaran, 
        z.revisi,
        z.no_penawaran,
        z.status, 
        z.name_customer
      FROM
        (
          SELECT
            a.no_surat as no_surat, 
            a.nama_sales as nama_sales, 
            a.nilai_penawaran as nilai_penawaran, 
            a.tgl_penawaran as tgl_penawaran, 
            a.revisi as revisi,
            a.no_penawaran as no_penawaran,
            a.status as status, 
            b.name_customer as name_customer
          FROM
            tr_penawaran_history a
            JOIN master_customers b ON b.id_customer = a.id_customer
          
          UNION ALL

          SELECT
            a.no_surat as no_surat, 
            a.nama_sales as nama_sales, 
            a.nilai_penawaran as nilai_penawaran, 
            a.tgl_penawaran as tgl_penawaran, 
            a.revisi as revisi,
            a.no_penawaran as no_penawaran,
            a.status as status, 
            b.name_customer as name_customer
          FROM
            tr_penawaran a
            JOIN master_customers b ON b.id_customer = a.id_customer
          WHERE
            a.status_so = 1 AND
            a.deleted_by IS NULL
        ) z
        WHERE
          1 = 1
          ' . $where_search . '
        ORDER BY z.no_surat DESC
        LIMIT ' . $length . ' OFFSET ' . $start . '
    ';
    $get_data = $this->db->query($query);

    $query_all = '
      SELECT
        z.no_surat, 
        z.nama_sales, 
        z.nilai_penawaran, 
        z.tgl_penawaran, 
        z.revisi,
        z.no_penawaran,
        z.status, 
        z.name_customer
      FROM
        (
          SELECT
            a.no_surat as no_surat, 
            a.nama_sales as nama_sales, 
            a.nilai_penawaran as nilai_penawaran, 
            a.tgl_penawaran as tgl_penawaran, 
            a.revisi as revisi,
            a.no_penawaran as no_penawaran,
            a.status as status, 
            b.name_customer as name_customer
          FROM
            tr_penawaran_history a
            JOIN master_customers b ON b.id_customer = a.id_customer
          
          UNION ALL

          SELECT
            a.no_surat as no_surat, 
            a.nama_sales as nama_sales, 
            a.nilai_penawaran as nilai_penawaran, 
            a.tgl_penawaran as tgl_penawaran, 
            a.revisi as revisi,
            a.no_penawaran as no_penawaran,
            a.status as status, 
            b.name_customer as name_customer
          FROM
            tr_penawaran a
            JOIN master_customers b ON b.id_customer = a.id_customer
          WHERE
            a.status_so = 1
        ) z
        WHERE
          1 = 1
          ' . $where_search . '
        ORDER BY z.no_surat DESC
    ';
    $get_data_all = $this->db->query($query_all);
    $no = (0 + $start);
    foreach ($get_data->result() as $item) {
      
      if ($item->status == 0) {
        $Status = "<span class='badge bg-grey'>Draft</span>";
      } elseif ($item->status == 1) {

        $Status = "<span class='badge bg-yellow'>Menunggu Approval</span>";
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

      $option = '';
      if (has_permission($this->viewPermission) && $item->status != '6') {
        $option .= '<a class="btn btn-primary btn-sm" href="' . base_url('/wt_penawaran/viewhistory/' . $item->no_penawaran . "/" . $item->revisi) . '" title="view" data-no_inquiry="' . $item->no_inquiry . '"><i class="fa fa-eye"></i></a>';
      }

      if (has_permission($this->viewPermission)) {
        $option .= '<a class="btn btn-success btn-sm" href="' . base_url('/wt_penawaran/viewhistoryso/' . $item->no_penawaran . "/" . $item->revisi) . '" title="view" data-no_inquiry="' . $item->no_inquiry . '"><i class="fa fa-eye"></i></a>';
      }

      if ($item->status != '6' || $item->status != '7') {
        $no++;

        $hasil[] = [
          'no' => $no,
          'no_penawaran' => $item->no_surat,
          'nama_customer' => strtoupper($item->name_customer),
          'marketing' => $item->nama_sales,
          'nilai_penawaran' => number_format($item->nilai_penawaran),
          'tanggal_penawaran' => date('d-F-Y', strtotime($item->tgl_penawaran)),
          'revisi' => $item->revisi,
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
