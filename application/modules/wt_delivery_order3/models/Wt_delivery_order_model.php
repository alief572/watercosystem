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

    function generate_id($kode='') {
      $query = $this->db->query("SELECT MAX(id_so) as max_id FROM tr_sales_order");
      $row = $query->row_array();
      $thn = date('y');
      $max_id = $row['max_id'];
      $max_id1 =(int) substr($max_id,3,5);
      $counter = $max_id +1;
      $idcust = "P".$thn.str_pad($counter, 5, "0", STR_PAD_LEFT);
      return $counter;
	}
		
  function generate_code($kode='') {
    $query = $this->db->query("SELECT MAX(no_spk) as max_id FROM tr_spk_delivery");
    $row = $query->row_array();
    $thn = date('y');
    $max_id = $row['max_id'];
    $max_id1 =(int) substr($max_id,3,5);
    $counter = $max_id1 +1;
    $idcust = "S".$thn.str_pad($counter, 5, "0", STR_PAD_LEFT);
    return $idcust;
}

function generate_codePlanning($kode='') {
  $query = $this->db->query("SELECT MAX(no_planning) as max_id FROM tr_planning_delivery");
  $row = $query->row_array();
  $thn = date('y');
  $max_id = $row['max_id'];
  $max_id1 =(int) substr($max_id,3,5);
  $counter = $max_id1 +1;
  $idcust = "P".$thn.str_pad($counter, 5, "0", STR_PAD_LEFT);
  return $idcust;
}

function BuatNomor($tanggal) {
  $bulan = date('m', strtotime($tanggal));
  $tahun = date('Y', strtotime($tanggal));
  if ($bulan=='01'){$romawi = 'I';}
  elseif ($bulan=='02'){$romawi = 'II';}
  elseif ($bulan=='03'){$romawi = 'III';}
  elseif ($bulan=='04'){$romawi = 'IV';}
  elseif ($bulan=='05'){$romawi = 'V';}
  elseif ($bulan=='06'){$romawi = 'VI';}
  elseif ($bulan=='07'){$romawi = 'VII';}
  elseif ($bulan=='08'){$romawi = 'VIII';}
  elseif ($bulan=='09'){$romawi = 'IX';}
  elseif ($bulan=='10'){$romawi = 'X';}
  elseif ($bulan=='11'){$romawi = 'XI';}
  elseif ($bulan=='12'){$romawi = 'XII';}
  $blnthn = date('Y-m');
    $query = $this->db->query("SELECT MAX(no_surat) as max_id FROM tr_spk_delivery WHERE month(tgl_spk)='$bulan' and Year(tgl_spk)='$tahun'");
    $row = $query->row_array();
    $thn = date('T');
    $max_id = $row['max_id'];
    $max_id1 =(int) substr($max_id,0,3);
    $counter = $max_id1 +1;
    $idcust = sprintf("%03s",$counter)."/WI/SD/".$romawi."/".$tahun;
    return $idcust;
}


function BuatNomorPlanning($kode='') {
  $bulan = date('m');
  $tahun = date('Y');
    if ($bulan=='01'){$romawi = 'I';}
    elseif ($bulan=='02'){$romawi = 'II';}
    elseif ($bulan=='03'){$romawi = 'III';}
    elseif ($bulan=='04'){$romawi = 'IV';}
    elseif ($bulan=='05'){$romawi = 'V';}
    elseif ($bulan=='06'){$romawi = 'VI';}
    elseif ($bulan=='07'){$romawi = 'VII';}
    elseif ($bulan=='08'){$romawi = 'VIII';}
    elseif ($bulan=='09'){$romawi = 'IX';}
    elseif ($bulan=='10'){$romawi = 'X';}
    elseif ($bulan=='11'){$romawi = 'XI';}
    elseif ($bulan=='12'){$romawi = 'XII';}
    $blnthn = date('Y-m');
      $query = $this->db->query("SELECT MAX(no_surat_planning) as max_id FROM tr_planning_delivery WHERE month(tgl_planning)='$bulan' and Year(tgl_planning)='$tahun'");
      $row = $query->row_array();
      $thn = date('T');
      $max_id = $row['max_id'];
      $max_id1 =(int) substr($max_id,0,3);
      $counter = $max_id1 +1;
      $idcust = sprintf("%03s",$counter)."/WI/PD/".$romawi."/".$tahun;
      return $idcust;
  }

function generate_code_Do($kode='') {
  $query = $this->db->query("SELECT MAX(no_do) as max_id FROM tr_delivery_order");
  $row = $query->row_array();
  $thn = date('y');
  $max_id = $row['max_id'];
  $max_id1 =(int) substr($max_id,3,5);
  $counter = $max_id1 +1;
  $idcust = "D".$thn.str_pad($counter, 5, "0", STR_PAD_LEFT);
  return $idcust;
}
function BuatNomorDo($tanggal) {
  $bulan = date('m', strtotime($tanggal));
  $tahun = date('Y', strtotime($tanggal));
if ($bulan=='01'){$romawi = 'I';}
elseif ($bulan=='02'){$romawi = 'II';}
elseif ($bulan=='03'){$romawi = 'III';}
elseif ($bulan=='04'){$romawi = 'IV';}
elseif ($bulan=='05'){$romawi = 'V';}
elseif ($bulan=='06'){$romawi = 'VI';}
elseif ($bulan=='07'){$romawi = 'VII';}
elseif ($bulan=='08'){$romawi = 'VIII';}
elseif ($bulan=='09'){$romawi = 'IX';}
elseif ($bulan=='10'){$romawi = 'X';}
elseif ($bulan=='11'){$romawi = 'XI';}
elseif ($bulan=='12'){$romawi = 'XII';}
$blnthn = date('Y-m');
  $query = $this->db->query("SELECT MAX(no_surat) as max_id FROM tr_delivery_order WHERE month(tgl_do)='$bulan' and Year(tgl_do)='$tahun'");
  $row = $query->row_array();
  $thn = date('T');
  $max_id = $row['max_id'];
  $max_id1 =(int) substr($max_id,0,3);
  $counter = $max_id1 +1;
  $idcust = sprintf("%03s",$counter)."/WI/DO/".$romawi."/".$tahun;
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


  public function cariSalesOrder()
  {
		$this->db->select('a.*, b.name_customer as name_customer, c.grand_total as total_penawaran,d.nama_top');
		$this->db->from('tr_sales_order a');
		$this->db->join('master_customers b','b.id_customer=a.id_customer');
    $this->db->join('tr_penawaran c','c.no_penawaran=a.no_penawaran');
    $this->db->join('ms_top d','d.id_top=a.top');
    // $where2 = "a.status !='0'";
    // $this->db->where($where);
    //$this->db->where($where2);
		$this->db->order_by('a.no_penawaran', DESC);
		$query = $this->db->get();	
		return $query->result();
	}

  public function cariSalesOrderblmkirim()
  {
		$this->db->select('a.*, b.name_customer as name_customer, c.grand_total as total_penawaran,d.nama_top');
		$this->db->from('tr_sales_order a');
		$this->db->join('master_customers b','b.id_customer=a.id_customer');
    $this->db->join('tr_penawaran c','c.no_penawaran=a.no_penawaran');
    $this->db->join('ms_top d','d.id_top=a.top');
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
    $this->db->join('master_customers b','b.id_customer=a.id_customer');
    $this->db->join('tr_sales_order c','c.no_so=a.no_so');
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
		$this->db->join('master_customers b','b.id_customer=a.id_customer');
		$this->db->join('tr_spk_delivery c','c.no_spk=a.no_spk');
		$this->db->where($search);
		$query = $this->db->get();	
		return $query->result();
	}

  public function cariDeliveryOrderDetail($id)
  {
		$this->db->select('a.*, b.metode_kirim, b.keterangan_kirim, c.kode_barang');
		$this->db->from('tr_delivery_order_detail a');
    $this->db->join('tr_sales_order_detail b','b.id_so_detail=a.id_so_detail');
	$this->db->join('ms_inventory_category3 c','c.id_category3=a.id_category3');
    $this->db->where('a.no_do',$id);
		$query = $this->db->get();	
		return $query->result();
	}


  public function cariSpkDeliveryDetail($id)
  {
		$this->db->select('a.*, b.metode_kirim, b.keterangan_kirim');
		$this->db->from('tr_spk_delivery_detail a');
    $this->db->join('tr_sales_order_detail b','b.id_so_detail=a.id_so_detail');
    $this->db->where('a.no_spk',$id);
		$query = $this->db->get();	
		return $query->result();
	}

  public function cariSalesOrderPlanning($id=null)
  {
		$this->db->select('a.*, b.name_customer as name_customer, c.grand_total as total_penawaran,d.nama_top');
		$this->db->from('tr_sales_order a');
		$this->db->join('master_customers b','b.id_customer=a.id_customer');
    $this->db->join('tr_penawaran c','c.no_penawaran=a.no_penawaran');
    $this->db->join('ms_top d','d.id_top=a.top');
    if($id != null){
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
		$this->db->join('master_customers b','b.id_customer=a.id_customer');
    $this->db->join('tr_penawaran c','c.no_penawaran=a.no_penawaran');
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
		$this->db->join('master_customers b','b.id_customer=a.id_customer');
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
		$this->db->join('master_customers b','b.id_customer=a.id_customer');
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
		$this->db->join('master_customers b','b.id_customer=a.id_customer');
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
		$this->db->join('master_customers b','b.id_customer=a.id_customer');
   	$this->db->order_by('a.no_penawaran', DESC);
		$query1 = $this->db->get();	

    $this->db->select('a.*, b.name_customer as name_customer');
		$this->db->from('tr_penawaran  a');
		$this->db->join('master_customers b','b.id_customer=a.id_customer');
    $where = "a.status_so='1'";
    $this->db->where($where);
   	$this->db->order_by('a.no_penawaran', DESC);
		$query2 = $this->db->get();	

    $query3= $this->db->query($query1 . ' UNION ' . $query2);



		return $query3->result();
	}
  public function CariHeaderHistory($no,$rev)
  {
    $this->db->select('a.*, b.name_customer as name_customer');
		$this->db->from('tr_penawaran_history a');
		$this->db->join('master_customers b','b.id_customer=a.id_customer');
    $where = "a.no_penawaran='$no'";
    $where2 = "a.revisi='$rev'";
    $this->db->where($where);
    $this->db->where($where2);
		$this->db->order_by('a.no_penawaran', DESC);
		$query = $this->db->get();	
		return $query->result();
	}
  public function CariDetailHistory($no,$rev)
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

  function get_where_in($field,$kunci,$tabel){
    $this->db->where_in($field,$kunci);
    $query=$this->db->get($tabel);
    return $query->result();
}

function get_where_in_and($field,$kunci,$and,$tabel){
    $this->db->where_in($field,$kunci);
    $this->db->where($and);
    $query=$this->db->get($tabel);
    return $query->result();
}

public function cariDeliveryOrderDetailPengiriman()
{
  $this->db->select('a.*, b.tgl_do, b.no_surat, c.name_customer');
  $this->db->from('tr_delivery_order_detail a');
  $this->db->join('tr_delivery_order b','b.no_do=a.no_do');
  $this->db->join('master_customers c','b.id_customer=c.id_customer');

  $query = $this->db->get();	
  return $query->result();
}

public function cariPlanning($id=null)
  {
		$this->db->select('a.*, c.name_customer as name_customer,d.nama_top');
		$this->db->from('tr_planning_delivery a');
		$this->db->join('master_customers c','c.id_customer=a.id_customer');
    $this->db->join('ms_top d','d.id_top=a.top');
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
      $this->db->join('master_customers b','b.id_customer=a.id_customer');
      $this->db->join('tr_spk_delivery c','c.no_spk=a.no_spk');
      $this->db->where('a.status_confirm',1);
          $query = $this->db->get();	
          return $query->result();
      }
	
}