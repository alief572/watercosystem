<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * @author Yunas Handra
 * @copyright Copyright (c) 2016, Yunas Handra
 * 
 * This is model class for table "log_5masterbarang"
 */

class Dashboard_model extends BF_Model
{

    /**
     * @var string  User Table Name
     */
    protected $table_name = 'tr_penawaran';
    protected $key        = 'no_penawaran';

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

    public function monitor_eoq() {
      $query="SELECT * FROM monitor_eoq";
      return $this->db->query($query);
    }

    public function barang_masuk(){
         $query="SELECT
            sum(log_transaksidt.jumlahrealisasi) as masuk
            FROM
            log_transaksidt
            INNER JOIN log_transaksiht ON log_transaksidt.notransaksi = log_transaksiht.notransaksi
            WHERE 
            log_transaksiht.post='1' AND log_transaksidt.statussaldo='1' AND log_transaksiht.tipetransaksi='2'";
        $query = $this->db->query($query);
        if ($query->num_rows() > 0) {
         return $query->row()->masuk;
        }
        return false;
    }


	public function penawaran(){

        $bulan = date('m');
        $tahun = date('Y');
        $blnthn = $tahun.'-'.$bulan;

         $query="SELECT sum(grand_total) as total_penawaran
            FROM tr_penawaran  WHERE tgl_penawaran LIKE '$blnthn%' ";
        $query = $this->db->query($query);
        if ($query->num_rows() > 0) {
         return $query->row()->total_penawaran;
        }
        return false;
    }
	
    public function penawaranso(){

        $bulan = date('m');
        $tahun = date('Y');
        $blnthn = $tahun.'-'.$bulan;

         $query="SELECT sum(grand_total) as total_penawaran
            FROM tr_penawaran  WHERE tgl_penawaran LIKE '$blnthn%' AND status=6 ";
        $query = $this->db->query($query);
        if ($query->num_rows() > 0) {
         return $query->row()->total_penawaran;
        }
        return false;
    }
	
	  public function penawarandikirim(){

        $bulan = date('m');
        $tahun = date('Y');
        $blnthn = $tahun.'-'.$bulan;

         $query="SELECT sum(grand_total) as total_penawaran
            FROM tr_penawaran  WHERE tgl_penawaran LIKE '$blnthn%' AND status=4 ";
        $query = $this->db->query($query);
        if ($query->num_rows() > 0) {
         return $query->row()->total_penawaran;
        }
        return false;
    }
	  public function penawaranloss(){

        $bulan = date('m');
        $tahun = date('Y');
        $blnthn = $tahun.'-'.$bulan;

         $query="SELECT sum(grand_total) as total_penawaran
            FROM tr_penawaran  WHERE tgl_penawaran LIKE '$blnthn%' AND status=7 ";
        $query = $this->db->query($query);
        if ($query->num_rows() > 0) {
         return $query->row()->total_penawaran;
        }
        return false;
    }

    public function salesorder(){
        $bulan = date('m');
        $tahun = date('Y');
        $blnthn = $tahun.'-'.$bulan;

        $query="SELECT sum(grand_total) as total_salesorder
           FROM tr_sales_order  WHERE tgl_so LIKE '%$blnthn%'";
       $query = $this->db->query($query);
       if ($query->num_rows() > 0) {
        return $query->row()->total_salesorder;
       }
       return false;
   }

   public function invoice(){
    $bulan = date('m');
    $tahun = date('Y');
    $blnthn = $tahun.'-'.$bulan;

    $query="SELECT sum(grand_total) as total_invoice
       FROM tr_invoice  WHERE tgl_invoice LIKE '%$blnthn%'";
   $query = $this->db->query($query);
   if ($query->num_rows() > 0) {
    return $query->row()->total_invoice;
   }
   return false;
   }

   public function bayar(){
    $bulan = date('m');
    $tahun = date('Y');
    $blnthn = $tahun.'-'.$bulan;

    $query="SELECT sum(jumlah_pembayaran_idr) as total_bayar
       FROM tr_invoice_payment  WHERE tgl_pembayaran LIKE '%$blnthn%'";
   $query = $this->db->query($query);
   if ($query->num_rows() > 0) {
    return $query->row()->total_bayar;
   }
   return false;
   }

    public function pengajuan_pending(){
         $query="SELECT
            sum(log_prapodt.jumlah) as pending
            FROM
            log_prapodt
            INNER JOIN log_prapoht ON log_prapodt.nopp = log_prapoht.nopp
            WHERE 
            log_prapoht.sts_pp='0'";
        $query = $this->db->query($query);
        if ($query->num_rows() > 0) {
         return $query->row()->pending;
        }
        return false;
    }

    public function pengajuan_acc(){
         $query="SELECT
            sum(log_prapodt.jumlah) as pending
            FROM
            log_prapodt
            INNER JOIN log_prapoht ON log_prapodt.nopp = log_prapoht.nopp
            WHERE 
            log_prapoht.sts_pp='1'";
        $query = $this->db->query($query);
        if ($query->num_rows() > 0) {
         return $query->row()->pending;
        }
        return false;
    }
	
	public function get_data($table,$where_field='',$where_value=''){
		if($where_field !='' && $where_value!=''){
			$query = $this->db->get_where($table, array($where_field=>$where_value));
		}else{
			$query = $this->db->get($table);
		}
		
		return $query->result();
	}
	
	
	public function penawaranpending(){

        $bulan = date('m');
        $tahun = date('Y');
        $blnthn = $tahun.'-'.$bulan;

         $query="SELECT sum(grand_total) as total_penawaran
            FROM tr_penawaran  WHERE status=4 AND DATEDIFF(CURDATE(),tgl_penawaran) > 60";
        $query = $this->db->query($query);
        if ($query->num_rows() > 0) {
         return $query->row()->total_penawaran;
        }
        return false;
    }
	
	public function kirim_terlambat(){

        $bulan = date('m');
        $tahun = date('Y');
        $blnthn = $tahun.'-'.$bulan;

         $query="SELECT sum(qty_do) as total_qty
            FROM tr_delivery_order_detail  WHERE status_kirim<>'1' AND DATEDIFF(CURDATE(),schedule) > 0";
        $query = $this->db->query($query);
        if ($query->num_rows() > 0) {
         return $query->row()->total_qty;
        }
        return false;
    }
	
	public function terima_terlambat(){

        $bulan = date('m');
        $tahun = date('Y');
        $blnthn = $tahun.'-'.$bulan;

         $query="SELECT sum(qty) as total_qty
            FROM dt_trans_po  WHERE ISNULL(sts_incoming)";
        $query = $this->db->query($query);
        if ($query->num_rows() > 0) {
         return $query->row()->total_qty;
        }
        return false;
    }


    
}
