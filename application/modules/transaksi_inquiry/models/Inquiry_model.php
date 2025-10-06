<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * @author Yunas Handra
 * @copyright Copyright (c) 2018, Yunas Handra
 *
 * This is model class for table "Customer"
 */

class Inquiry_model extends BF_Model
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
	
	function generate_detail($kode='') {
      $query = $this->db->query("SELECT MAX(id_dt_inquery) as max_id FROM dt_inquery_transaksi");
      $row = $query->row_array();
      $thn = date('y');
      $max_id = $row['max_id'];
      $max_id1 =(int) substr($max_id,3,5);
      $counter = $max_id1 +1;
      $idcust = "D".$thn.str_pad($counter, 5, "0", STR_PAD_LEFT);
      return $idcust;
	}
	function generate_code($kode='') {
      $query = $this->db->query("SELECT MAX(no_penawaran) as max_id FROM tr_penawaran");
      $row = $query->row_array();
      $thn = date('y');
      $max_id = $row['max_id'];
      $max_id1 =(int) substr($max_id,3,5);
      $counter = $max_id1 +1;
      $idcust = "P".$thn.str_pad($counter, 5, "0", STR_PAD_LEFT);
      return $idcust;
	}
	function BuatNomor($kode='') {
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
      $query = $this->db->query("SELECT MAX(no_surat) as max_id FROM tr_inquiry WHERE month(tgl_inquiry)='$bulan' and Year(tgl_inquiry)='$tahun'");
      $row = $query->row_array();
      $thn = date('T');
      $max_id = $row['max_id'];
      $max_id1 =(int) substr($max_id,0,3);
      $counter = $max_id1 +1;
      $idcust = sprintf("%03s",$counter)."/MP/Q/".$romawi."/".$tahun;
      return $idcust;
	}
		public function getHeaderPenawaran($id){
		$this->db->select('a.*, b.name_customer as name_customer, b.address_office as address_office, b.telephone as telephone,b.fax as fax');
		$this->db->from('tr_inquiry a');
		$this->db->join('master_customers b','b.id_customer=a.id_customer');
		$this->db->where('a.no_inquiry',$id);
		$query = $this->db->get();	
		return $query->result();
	}
			public function PrintDetail($id){
		$this->db->select('a.*, b.nama as nama3,b.hardness as hardness, c.nama as nama2 , d.nilai_dimensi as nilai');
		$this->db->from('dt_inquery_transaksi a');
		$this->db->join('ms_inventory_category3 b','b.id_category3=a.id_category3');
		$this->db->join('ms_inventory_category2 c','c.id_category2=b.id_category2');
		$this->db->join('child_inven_dimensi d','d.id_category3=a.id_category3');
		$this->db->where('a.no_inquery',$id);
		$query = $this->db->get();	
		return $query->result();
	}
    function generate_id() {
		$today=date("Y-m-d");
		$year=date("y");
		$month=date("m");
		$day=date("d");
        $query = "SELECT MAX(RIGHT(no_inquiry,4)) as max_id from tr_inquiry WHERE tgl_inquiry LIKE '$today'";
        $q = $this->db->query($query);
		$r = $q->row();
        $query_cek = $q->num_rows();
		$kode2 = $r->max_id;
		$kd_noreg = "";
        if ($query_cek == 0) {
          $kd_noreg = 1;
          $reg = sprintf("%02d%02d%02d%04s", $year,$month,$day,$kode_noreg);  
        }else {
			$kd_new = $kode2+1;
			$reg = sprintf("%02d%02d%02d%04s", $year,$month,$day,$kd_new);	
        }
		$tr ="IQ$reg";
      return $tr;
	}

 	public function get_data($table,$where_field='',$where_value=''){
		if($where_field !='' && $where_value!=''){
			$query = $this->db->get_where($table, array($where_field=>$where_value));
		}else{
			$query = $this->db->get($table);
		}
		
		return $query->result();
	}
	
	public function CariInquiry(){
		$this->db->select('a.*, b.name_customer as name_customer, c.nama_karyawan as nama_karyawan');
		$this->db->from('tr_inquiry a');
		$this->db->join('master_customers b','b.id_customer=a.id_customer');
		$this->db->join('ms_karyawan c','c.id_karyawan=a.id_sales');
		$query = $this->db->get();		
		return $query->result();
	}
	
	public function get_data_category1(){
		$this->db->select('a.*, b.nama as nama_type');
		$this->db->from('ms_inventory_category1 a');
		$this->db->join('ms_inventory_type b','b.id_type=a.id_type');
		$this->db->where('a.deleted','0');
		$query = $this->db->get();		
		return $query->result();
	}
	public function get_cu($id_category3){
		$cari = "id_category3='$id_category3' and id_compotition='13' ";
		$this->db->from('child_inven_compotition');
		$this->db->where($cari);
		$query = $this->db->get();		
		return $query->result();
	}
	public function get_zn($id_category3){
		$cari = "id_category3='$id_category3' and id_compotition='14' ";
		$this->db->from('child_inven_compotition');
		$this->db->where($cari);
		$query = $this->db->get();		
		return $query->result();
	}
	public function get_sn($id_category3){
		$cari = "id_category3='$id_category3' and id_compotition='15' ";
		$this->db->from('child_inven_compotition');
		$this->db->where($cari);
		$query = $this->db->get();		
		return $query->result();
	}
	public function get_ni($id_category3){
		$cari = "id_category3='$id_category3' and id_compotition='16' ";
		$this->db->from('child_inven_compotition');
		$this->db->where($cari);
		$query = $this->db->get();		
		return $query->result();
	}
		public function get_ag($id_category3){
		$cari = "id_category3='$id_category3' and id_compotition='17' ";
		$this->db->from('child_inven_compotition');
		$this->db->where($cari);
		$query = $this->db->get();		
		return $query->result();
	}
		public function get_al($id_category3){
		$cari = "id_category3='$id_category3' and id_compotition='18' ";
		$this->db->from('child_inven_compotition');
		$this->db->where($cari);
		$query = $this->db->get();		
		return $query->result();
	}
	public function get_lmert1(){
		$cari = "status='0' and id_compotition='13' ";
		$this->db->from('child_history_lme');
		$this->db->where($cari);
		$query = $this->db->get();		
		return $query->result();
	}
		public function get_lmert2(){
		$cari = "status='0'  and id_compotition='14' ";
		$this->db->from('child_history_lme');
		$this->db->where($cari);
		$query = $this->db->get();		
		return $query->result();
	}
		public function get_lmert3(){
		$cari = "status='0'  and id_compotition='15' ";
		$this->db->from('child_history_lme');
		$this->db->where($cari);
		$query = $this->db->get();		
		return $query->result();
	}
		public function get_lmert4(){
		$cari = "status='0'  and id_compotition='16' ";
		$this->db->from('child_history_lme');
		$this->db->where($cari);
		$query = $this->db->get();		
		return $query->result();
	}
		public function get_lmert5(){
		$cari = "status='0'  and id_compotition='17' ";
		$this->db->from('child_history_lme');
		$this->db->where($cari);
		$query = $this->db->get();		
		return $query->result();
	}
		public function get_lmert6(){
		$cari = "status='0'  and id_compotition='18' ";
		$this->db->from('child_history_lme');
		$this->db->where($cari);
		$query = $this->db->get();		
		return $query->result();
	}
	public function GetMaterialroll($bentuk){
		$cari = "a.deleted='0' and a.id_bentuk='$bentuk' and c.id_dimensi = '22' ";
		$this->db->select('a.*, b.nama as nama_type , c.nilai_dimensi as thickness');
		$this->db->from('ms_inventory_category3 a');
		$this->db->join('ms_inventory_category2 b','b.id_category2=a.id_category2');
		$this->db->join('child_inven_dimensi c','c.id_category3=a.id_category3');
		$this->db->where($cari);
		$query = $this->db->get();		
		return $query->result();
	}
	 
		public function GetMaterialSheet($bentuk){
		$cari = "a.deleted='0' and a.id_bentuk='$bentuk' and c.id_dimensi = '25' ";
		$this->db->select('a.*, b.nama as nama_type , c.nilai_dimensi as thickness');
		$this->db->from('ms_inventory_category3 a');
		$this->db->join('ms_inventory_category2 b','b.id_category2=a.id_category2');
		$this->db->join('child_inven_dimensi c','c.id_category3=a.id_category3');
		$this->db->where($cari);
		$query = $this->db->get();		
		return $query->result();
	}
	public function GetMaterial($bentuk){
		$cari = "a.deleted='0' and a.id_bentuk='$bentuk'";
		$this->db->select('a.*, b.nama as nama_type , c.nilai_dimensi as thickness');
		$this->db->from('ms_inventory_category3 a');
		$this->db->join('ms_inventory_category2 b','b.id_category2=a.id_category2');
		$this->db->join('child_inven_dimensi c','c.id_category3=a.id_category3');
		$this->db->where($cari);
		$query = $this->db->get();		
		return $query->result();
	}
	public function GetTransakasi($no_inquiry){
		$this->db->select('a.*, b.nama_karyawan as nama_karyawan, c.name_customer as name_customer');
		$this->db->from('tr_inquiry a');
		$this->db->join('ms_karyawan b','b.id_karyawan=a.id_sales');
		$this->db->join('master_customers c','c.id_customer=a.id_customer');
		$this->db->where('a.no_inquiry',$no_inquiry);
		$query = $this->db->get();		
		return $query->result();
	}
	
	public function GetSemua($no_inquiry){
		$this->db->select('a.*, b.nm_bentuk as nm_bentuk, c.nama as nama_kategori3, d.nama as nama_kategori2, c.hardness as hardnessmt');
		$this->db->from('dt_inquery_transaksi a');
		$this->db->join('ms_bentuk b','b.id_bentuk=a.id_bentuk');
		$this->db->join('ms_inventory_category3 c','c.id_category3=a.id_category3');
		$this->db->join('ms_inventory_category2 d','d.id_category2=c.id_category2');
		$this->db->where('a.no_inquery',$no_inquiry);
		$query = $this->db->get();		
		return $query->result();
	}
	public function GetRoll($no_inquiry){
		$search = "a.no_inquery='$no_inquiry' and a.id_bentuk='B2000001'";
		$this->db->select('a.*, b.nm_bentuk as nm_bentuk, c.nama as nama_kategori3, d.nama as nama_kategori2, c.hardness as hardnessmt');
		$this->db->from('dt_inquery_transaksi a');
		$this->db->join('ms_bentuk b','b.id_bentuk=a.id_bentuk');
		$this->db->join('ms_inventory_category3 c','c.id_category3=a.id_category3');
		$this->db->join('ms_inventory_category2 d','d.id_category2=c.id_category2');
		$this->db->where($search);
		$query = $this->db->get();		
		return $query->result();
	}
	
	public function GetSheet($no_inquiry){
		$search = "a.no_inquery='$no_inquiry' and a.id_bentuk='B2000002'";
		$this->db->select('a.*, b.nm_bentuk as nm_bentuk, c.nama as nama_kategori3, d.nama as nama_kategori2, c.hardness as hardnessmt');
		$this->db->from('dt_inquery_transaksi a');
		$this->db->join('ms_bentuk b','b.id_bentuk=a.id_bentuk');
		$this->db->join('ms_inventory_category3 c','c.id_category3=a.id_category3');
		$this->db->join('ms_inventory_category2 d','d.id_category2=c.id_category2');
		$this->db->where($search);
		$query = $this->db->get();		
		return $query->result();
	}
	
	public function GetRoundBar($no_inquiry){
		$search = "a.no_inquery='$no_inquiry' and a.id_bentuk='B2000003'";
		$this->db->select('a.*, b.nm_bentuk as nm_bentuk, c.nama as nama_kategori3, d.nama as nama_kategori2, c.hardness as hardnessmt');
		$this->db->from('dt_inquery_transaksi a');
		$this->db->join('ms_bentuk b','b.id_bentuk=a.id_bentuk');
		$this->db->join('ms_inventory_category3 c','c.id_category3=a.id_category3');
		$this->db->join('ms_inventory_category2 d','d.id_category2=c.id_category2');
		$this->db->where($search);
		$query = $this->db->get();		
		return $query->result();
	}
	
	public function GetSquareBar($no_inquiry){
		$search = "a.no_inquery='$no_inquiry' and a.id_bentuk='B2000004'";
		$this->db->select('a.*, b.nm_bentuk as nm_bentuk, c.nama as nama_kategori3, d.nama as nama_kategori2, c.hardness as hardnessmt');
		$this->db->from('dt_inquery_transaksi a');
		$this->db->join('ms_bentuk b','b.id_bentuk=a.id_bentuk');
		$this->db->join('ms_inventory_category3 c','c.id_category3=a.id_category3');
		$this->db->join('ms_inventory_category2 d','d.id_category2=c.id_category2');
		$this->db->where($search);
		$query = $this->db->get();		
		return $query->result();
	}
	
	public function GetHexagonBar($no_inquiry){
		$search = "a.no_inquery='$no_inquiry' and a.id_bentuk='B2000005'";
		$this->db->select('a.*, b.nm_bentuk as nm_bentuk, c.nama as nama_kategori3, d.nama as nama_kategori2, c.hardness as hardnessmt');
		$this->db->from('dt_inquery_transaksi a');
		$this->db->join('ms_bentuk b','b.id_bentuk=a.id_bentuk');
		$this->db->join('ms_inventory_category3 c','c.id_category3=a.id_category3');
		$this->db->join('ms_inventory_category2 d','d.id_category2=c.id_category2');
		$this->db->where($search);
		$query = $this->db->get();		
		return $query->result();
	}
	
	public function GetOktagonBar($no_inquiry){
		$search = "a.no_inquery='$no_inquiry' and a.id_bentuk='B2000006'";
		$this->db->select('a.*, b.nm_bentuk as nm_bentuk, c.nama as nama_kategori3, d.nama as nama_kategori2, c.hardness as hardnessmt');
		$this->db->from('dt_inquery_transaksi a');
		$this->db->join('ms_bentuk b','b.id_bentuk=a.id_bentuk');
		$this->db->join('ms_inventory_category3 c','c.id_category3=a.id_category3');
		$this->db->join('ms_inventory_category2 d','d.id_category2=c.id_category2');
		$this->db->where($search);
		$query = $this->db->get();		
		return $query->result();
	}
	
	public function GetTube($no_inquiry){
		$search = "a.no_inquery='$no_inquiry' and a.id_bentuk='B2000007'";
		$this->db->select('a.*, b.nm_bentuk as nm_bentuk, c.nama as nama_kategori3, d.nama as nama_kategori2, c.hardness as hardnessmt');
		$this->db->from('dt_inquery_transaksi a');
		$this->db->join('ms_bentuk b','b.id_bentuk=a.id_bentuk');
		$this->db->join('ms_inventory_category3 c','c.id_category3=a.id_category3');
		$this->db->join('ms_inventory_category2 d','d.id_category2=c.id_category2');
		$this->db->where($search);
		$query = $this->db->get();		
		return $query->result();
	}
	
	public function GetPentagonBar($no_inquiry){
		$search = "a.no_inquery='$no_inquiry' and a.id_bentuk='B2000009'";
		$this->db->select('a.*, b.nm_bentuk as nm_bentuk, c.nama as nama_kategori3, d.nama as nama_kategori2, c.hardness as hardnessmt');
		$this->db->from('dt_inquery_transaksi a');
		$this->db->join('ms_bentuk b','b.id_bentuk=a.id_bentuk');
		$this->db->join('ms_inventory_category3 c','c.id_category3=a.id_category3');
		$this->db->join('ms_inventory_category2 d','d.id_category2=c.id_category2');
		$this->db->where($search);
		$query = $this->db->get();		
		return $query->result();
	}
	
	public function getDimensi($id){
		$search = "deleted='0' and id_bentuk='$id'";
		$this->db->select('*');
		$this->db->from('ms_dimensi');
		$this->db->where($search);
		$query = $this->db->get();		
		return $query->result();
	}
	
		function cariemail($id_customer)
    {
        $this->db->where('id_customer', $id_customer);
        return $this->db->from('master_customers')
            ->get()
			->result();
	}


		function DensityRoll($id_category3)
    {
        $this->db->where('id_category3', $id_category3);
        return $this->db->from('ms_inventory_category3')
            ->get()
			->result();
			
	}
	function ThicknessRoll($id_category3)
    {
		$search="id_category3='$id_category3' and id_dimensi='22'";
        $this->db->where($search);
        return $this->db->from('child_inven_dimensi')
            ->get()
			->result();
	}
	function DensitySheet($id_category3)
    {
        $this->db->where('id_category3', $id_category3);
        return $this->db->from('ms_inventory_category3')
            ->get()
			->result();
			
	}
	function ThicknessSheet($id_category3)
    {
		$search="id_category3='$id_category3' and id_dimensi='25'";
        $this->db->where($search);
        return $this->db->from('child_inven_dimensi')
            ->get()
			->result();
	}
	function Pricelist($id_category3)
    {
		$search="id_category3='$id_category3'";
        $this->db->where($search);
        return $this->db->from('ms_inventory_category3')
            ->get()
			->result();
	}
		function caripic($id_customer)
    {
        $this->db->where('id_customer', $id_customer);
        return $this->db->from('child_customer_pic')
            ->get()
			->result();
	}

   

}
