<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * @author Yunas Handra
 * @copyright Copyright (c) 2016, Yunas Handra
 * 
 * This is model class for table "log_5masterbarang"
 */

class Reports_model extends BF_Model
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

    public function monitor_eoq()
    {
        $query = "SELECT * FROM monitor_eoq";
        return $this->db->query($query);
    }

    public function barang_masuk()
    {
        $query = "SELECT
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

    public function penawaran()
    {

        $bulan = date('m');
        $tahun = date('Y');
        $blnthn = $tahun . '-' . $bulan;

        $query = "SELECT sum(grand_total) as total_penawaran
            FROM tr_penawaran  WHERE tgl_penawaran LIKE '$blnthn' ";
        $query = $this->db->query($query);
        if ($query->num_rows() > 0) {
            return $query->row()->total_penawaran;
        }
        return false;
    }

    public function salesorder()
    {

        $bulan = date('m');
        $tahun = date('Y');
        $blnthn = $tahun . '-' . $bulan;

        $query = "SELECT sum(tr_sales_order.grand_total) as total_salesorder
           FROM tr_sales_order WHERE tgl_so LIKE '$blnthn' ";
        $query = $this->db->query($query);
        if ($query->num_rows() > 0) {
            return $query->row()->total_salesorder;
        }
        return false;
    }

    public function CariPenawaran()
    {

        $bulan = date('m');
        $tahun = date('Y');
        $blnthn = $tahun . '-' . $bulan;

        $this->db->select('a.*, b.name_customer as name_customer');
        $this->db->from('tr_penawaran a');
        $this->db->join('master_customers b', 'b.id_customer=a.id_customer');
        $where2 = "a.tgl_penawaran  LIKE '%$blnthn%'";
        $this->db->where($where2);

        $query = $this->db->get();
        return $query->result();
    }

    public function CariPenawaranSo()
    {

        $bulan = date('m');
        $tahun = date('Y');
        $blnthn = $tahun . '-' . $bulan;

        $this->db->select('a.*, b.name_customer as name_customer');
        $this->db->from('tr_penawaran a');
        $this->db->join('master_customers b', 'b.id_customer=a.id_customer');
        $where2 = "a.tgl_penawaran  LIKE '%$blnthn%' AND status=6 ";
        $this->db->where($where2);

        $query = $this->db->get();
        return $query->result();
    }

    public function CariPenawaranDikirim()
    {

        $bulan = date('m');
        $tahun = date('Y');
        $blnthn = $tahun . '-' . $bulan;

        $this->db->select('a.*, b.name_customer as name_customer');
        $this->db->from('tr_penawaran a');
        $this->db->join('master_customers b', 'b.id_customer=a.id_customer');
        $where2 = "a.tgl_penawaran  LIKE '%$blnthn%' AND status=4 ";
        $this->db->where($where2);

        $query = $this->db->get();
        return $query->result();
    }

    public function CariPenawaranLoss()
    {

        $bulan = date('m');
        $tahun = date('Y');
        $blnthn = $tahun . '-' . $bulan;

        $this->db->select('a.*, b.name_customer as name_customer');
        $this->db->from('tr_penawaran a');
        $this->db->join('master_customers b', 'b.id_customer=a.id_customer');
        $where2 = "a.tgl_penawaran  LIKE '%$blnthn%' AND status=7 ";
        $this->db->where($where2);

        $query = $this->db->get();
        return $query->result();
    }


    public function cariSalesOrder()
    {

        $bulan = date('m');
        $tahun = date('Y');
        $blnthn = $tahun . '-' . $bulan;

        $this->db->select('a.*, b.name_customer as name_customer, c.grand_total as total_penawaran');
        $this->db->from('tr_sales_order a');
        $this->db->join('master_customers b', 'b.id_customer=a.id_customer');
        $this->db->join('tr_penawaran c', 'c.no_penawaran=a.no_penawaran');
        $where2 = "a.tgl_so  LIKE '%$blnthn%'";
        $this->db->where($where2);
        $query = $this->db->get();
        return $query->result();
    }

    public function cariSalesOrderTgl($tgl)
    {

        $bulan = date('m', strtotime($tgl));
        $tahun = date('Y', strtotime($tgl));
        $blnthn = $tahun . '-' . $bulan;


        $this->db->select('a.*, b.name_customer as name_customer, c.grand_total as total_penawaran');
        $this->db->from('tr_sales_order a');
        $this->db->join('master_customers b', 'b.id_customer=a.id_customer');
        $this->db->join('tr_penawaran c', 'c.no_penawaran=a.no_penawaran');
        $where2 = "a.tgl_so  LIKE '%$blnthn%'";
        $this->db->where($where2);
        $query = $this->db->get();
        return $query->result();
    }

    public function cariSalesOrderDetail()
    {

        $bulan = date('m');
        $tahun = date('Y');
        $blnthn = $tahun . '-' . $bulan;

        $this->db->select('a.*, b.tgl_so, b.no_surat, c.name_customer as customer ');
        $this->db->from('tr_sales_order_detail a');
        $this->db->join('tr_sales_order b', 'b.no_so=a.no_so');
        $this->db->join('master_customers c', 'c.id_customer=b.id_customer');
        $where2 = "b.tgl_so  LIKE '%$blnthn%'";
        $this->db->where($where2);
        $query = $this->db->get();
        return $query->result();
    }

    public function cariSalesOrderDetailTgl($tgl)
    {

        $bulan = date('m', strtotime($tgl));
        $tahun = date('Y', strtotime($tgl));
        $blnthn = $tahun . '-' . $bulan;


        $this->db->select('a.*, b.tgl_so, b.no_surat, c.name_customer as customer ');
        $this->db->from('tr_sales_order_detail a');
        $this->db->join('tr_sales_order b', 'b.no_so=a.no_so');
        $this->db->join('master_customers c', 'c.id_customer=b.id_customer');

        $where2 = "b.tgl_so  LIKE '%$blnthn%'";
        $this->db->where($where2);
        $query = $this->db->get();
        return $query->result();
    }

    public function CariInvoice()
    {
        $bulan = date('m');
        $tahun = date('Y');
        $blnthn = $tahun . '-' . $bulan;


        $this->db->select('a.*, b.name_customer as name_customer,c.nama_top');
        $this->db->from('tr_invoice a');
        $this->db->join('master_customers b', 'b.id_customer=a.id_customer');
        $this->db->join('ms_top c', 'c.id_top=a.top');
        $where2 = "a.tgl_invoice  LIKE '%$blnthn%'";
        $this->db->where($where2);
        $query = $this->db->get();
        return $query->result();
    }

    public function CariInvoiceTgl($tgl)
    {
        $bulan = date('m', strtotime($tgl));
        $tahun = date('Y', strtotime($tgl));
        $blnthn = $tahun . '-' . $bulan;


        $this->db->select('a.*, b.name_customer as name_customer,c.nama_top');
        $this->db->from('tr_invoice a');
        $this->db->join('master_customers b', 'b.id_customer=a.id_customer');
        $this->db->join('ms_top c', 'c.id_top=a.top');
        $where2 = "a.tgl_invoice  LIKE '%$blnthn%'";
        $this->db->where($where2);
        $query = $this->db->get();
        return $query->result();
    }



    public function get_data_pn()
    {

        $query =  $this->db->query("SELECT a.*, c.invoiced, c.totalinvoiced FROM tr_invoice_payment a	        
        left outer join (
            SELECT kd_pembayaran,
            GROUP_CONCAT(no_surat SEPARATOR ',') as invoiced,
            sum(total_bayar_idr) as totalinvoiced
            FROM view_tr_invoice_payment
            GROUP BY kd_pembayaran
        ) c on a.kd_pembayaran=c.kd_pembayaran       
        ");

        return $query->result();
    }

    public function CariPayment()
    {

        $bulan = date('m');
        $tahun = date('Y');
        $blnthn = $tahun . '-' . $bulan;
        $query =  $this->db->query("SELECT a.*, c.invoiced, c.totalinvoiced FROM tr_invoice_payment a	        
        left outer join ( SELECT kd_pembayaran,
            GROUP_CONCAT(no_surat SEPARATOR ',') as invoiced,
            sum(total_bayar_idr) as totalinvoiced
            FROM view_tr_invoice_payment
            GROUP BY kd_pembayaran
        ) c on a.kd_pembayaran=c.kd_pembayaran       
        WHERE a.tgl_pembayaran LIKE '%$blnthn%'");
        return $query->result();
    }

    public function CariPaymentTgl($tgl)
    {
        $bulan = date('m', strtotime($tgl));
        $tahun = date('Y', strtotime($tgl));
        $blnthn = $tahun . '-' . $bulan;

        $query =  $this->db->query("SELECT a.*, c.invoiced, c.totalinvoiced FROM tr_invoice_payment a	        
        left outer join ( SELECT kd_pembayaran,
            GROUP_CONCAT(no_surat SEPARATOR ',') as invoiced,
            sum(total_bayar_idr) as totalinvoiced
            FROM view_tr_invoice_payment
            GROUP BY kd_pembayaran
        ) c on a.kd_pembayaran=c.kd_pembayaran       
        WHERE a.tgl_pembayaran LIKE '%$blnthn%'");
        return $query->result();
    }

    public function CariJurnalInvoiceTgl($tgl)
    {
        $bulan = date('m', strtotime($tgl));
        $tahun = date('Y', strtotime($tgl));
        $blnthn = $tahun . '-' . $bulan;


        $this->db->select('a.*, b.name_customer as name_customer,c.nama_top');
        $this->db->from('tr_invoice a');
        $this->db->join('master_customers b', 'b.id_customer=a.id_customer');
        $this->db->join('ms_top c', 'c.id_top=a.top');
        $where = "a.status_jurnal ='CLS'";
        $where2 = "a.tgl_invoice  LIKE '%$blnthn%'";
        $this->db->where($where);
        $this->db->where($where2);
        $query = $this->db->get();
        return $query->result();
    }

    public function CariDeposit()
    {
        $query =  $this->db->query("SELECT a.* FROM tr_unlocated_bank a");
        return $query->result();
    }

    public function CariRevenue()
    {
        $bulan = date('m');
        $tahun = date('Y');
        $blnthn = $tahun . '-' . $bulan;


        $this->db->select('a.*');
        $this->db->from('tr_revenue a');
        $where = "a.status_jurnal ='CLS'";
        $where2 = "a.tgl_so  LIKE '%$blnthn%'";
        $this->db->where($where);
        $this->db->where($where2);
        $query = $this->db->get();
        return $query->result();
    }

    public function CariRevenueTgl($tgl)
    {
        $bulan = date('m', strtotime($tgl));
        $tahun = date('Y', strtotime($tgl));
        $blnthn = $tahun . '-' . $bulan;


        $this->db->select('a.*,b.grand_total');
        $this->db->from('tr_revenue a');
        $this->db->join('tr_sales_order b', 'b.no_so=a.no_so');
        $where = "a.status_jurnal ='CLS'";
        $where2 = "a.tgl_so  LIKE '%$blnthn%'";
        $this->db->where($where);
        $this->db->where($where2);
        $query = $this->db->get();
        return $query->result();
    }

    public function CariRevenuedetail()
    {

        $this->db->select('a.*, SUM(b.qty * b.harga_satuan) as pricelist, SUM((b.qty * b.harga_satuan) * b.diskon / 100) as disc, b.diskon as disc_persen');
        $this->db->from('tr_revenue a');
        $this->db->join('tr_sales_order_detail b', 'b.no_so = a.no_so', 'left');
        $this->db->group_by('a.id');
        $query = $this->db->get();
        return $query->result();
    }
    public function CariRevenuedetailSo()
    {

        $this->db->select('a.*');
        $this->db->from('tr_revenue a');
        $this->db->group_by('a.no_so');
        $query = $this->db->get();
        return $query->result();
    }
    public function CariRevenuedetailDoSO()
    {

        $this->db->select('a.*, sum(qty_do) as total_do, b.qty_so,b.qty_so, b.harga_satuan, b.nilai_diskon,b.total_harga ');
        $this->db->from('tr_delivery_order_detail a');
        $this->db->join('tr_sales_order_detail b', 'b.id_so_detail=a.id_so_detail');
        $where = "a.status_kirim ='1'";
        // $where2 = "a.tgl_invoice  LIKE '%$blnthn%'"; 
        $this->db->where($where);
        //$this->db->where($where2);
        $this->db->group_by('a.no_so');
        $this->db->group_by('a.id_category3');
        $query = $this->db->get();
        return $query->result();
    }


    public function CariRevenuedetailDoSOTgl($tgl)
    {
        $bulan = date('m', strtotime($tgl));
        $tahun = date('Y', strtotime($tgl));
        $blnthn = $tahun . '-' . $bulan;

        $this->db->select('a.*, sum(qty_do) as total_do, b.qty_so,b.qty_so, b.harga_satuan, b.nilai_diskon,b.total_harga, c.tgl_do, c.no_surat, d.tgl_so ');
        $this->db->from('tr_delivery_order_detail a');
        $this->db->join('tr_sales_order_detail b', 'b.id_so_detail=a.id_so_detail');
        $this->db->join('tr_delivery_order c', 'c.no_do=a.no_do');
        $this->db->join('tr_revenue d', 'd.no_so=a.no_so');
        $where = "a.status_kirim ='1'";
        $where2 = "d.tgl_so  LIKE '%$blnthn%'";
        $this->db->where($where);
        $this->db->where($where2);
        $this->db->group_by('d.no_so');
        $this->db->group_by('a.id_category3');

        $query = $this->db->get();
        return $query->result();
    }

    public function stock_value()
    {
        $this->db->select('a.*, b.nilai_costbook, c.nama, c.kode_barang');
        $this->db->from('stock_material_31mei a');
        $this->db->join('ms_costbook b', 'b.id_category3=a.id_category3');
        $this->db->join('ms_inventory_category3 c', 'c.id_category3=a.id_category3');
        $where = "a.qty !='0'";
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_data_report_detail_sales_order()
    {
        $draw = $this->input->post('draw');
        $start = $this->input->post('start');
        $length = $this->input->post('length');
        $search = $this->input->post('search');

        $tanggal = $this->input->post('tanggal');

        $this->db->select('a.*, b.tgl_so, b.no_surat, c.name_customer as customer');
        $this->db->from('tr_sales_order_detail a');
        $this->db->join('tr_sales_order b', 'b.no_so=a.no_so');
        $this->db->join('master_customers c', 'c.id_customer=b.id_customer');
        if ($tanggal !== '' && $tanggal !== null) {
            $this->db->where('b.tgl_so', $tanggal);
        }
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('b.tgl_so', $search['value'], 'both');
            $this->db->or_like('b.no_surat', $search['value'], 'both');
            $this->db->or_like('c.name_customer', $search['value'], 'both');
            $this->db->or_like('a.nama_produk', $search['value'], 'both');
            $this->db->or_like('a.qty_so', $search['value'], 'both');
            $this->db->or_like('a.harga_satuan', $search['value'], 'both');
            $this->db->or_like('(a.qty_so * a.harga_satuan)', $search['value'], 'both');
            $this->db->or_like('a.nilai_diskon', $search['value'], 'both');
            $this->db->or_like('a.total_harga', $search['value'], 'both');
            $this->db->group_end();
        }
        $this->db->group_by('a.id_so_detail');
        $this->db->order_by('b.tgl_so', 'desc');
        $this->db->limit($length, $start);
        $query = $this->db->get();

        $this->db->select('a.*, b.tgl_so, b.no_surat, c.name_customer as customer');
        $this->db->from('tr_sales_order_detail a');
        $this->db->join('tr_sales_order b', 'b.no_so=a.no_so');
        $this->db->join('master_customers c', 'c.id_customer=b.id_customer');
        if ($tanggal !== '' && $tanggal !== null) {
            $this->db->where('b.tgl_so', $tanggal);
        }
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('b.tgl_so', $search['value'], 'both');
            $this->db->or_like('b.no_surat', $search['value'], 'both');
            $this->db->or_like('c.name_customer', $search['value'], 'both');
            $this->db->or_like('a.nama_produk', $search['value'], 'both');
            $this->db->or_like('a.qty_so', $search['value'], 'both');
            $this->db->or_like('a.harga_satuan', $search['value'], 'both');
            $this->db->or_like('(a.qty_so * a.harga_satuan)', $search['value'], 'both');
            $this->db->or_like('a.nilai_diskon', $search['value'], 'both');
            $this->db->or_like('a.total_harga', $search['value'], 'both');
            $this->db->group_end();
        }
        $this->db->group_by('a.id_so_detail');
        $this->db->order_by('b.tgl_so', 'desc');

        $query_all = $this->db->get();

        $hasil = [];

        $no = $start + 1;
        foreach ($query->result() as $item) {
            $invoice = $this->db->query("select no_surat FROM tr_invoice WHERE no_so='" . $item->no_so . "'")->result();
            $separator = ',';
            $allinv = array();
            foreach ($invoice as $inv) {
                $allinv[] = $inv->no_surat;
            }

            $invc =  implode($separator, $allinv);

            $hasil[] = [
                'no' => $no,
                'tgl_so' => $item->tgl_so,
                'no_surat' => $item->no_surat,
                'no_invoice' => $invc,
                'nm_customer' => $item->customer,
                'nama_produk' => $item->nama_produk,
                'qty_so' => number_format($item->qty_so),
                'harga_pricelist' => number_format($item->harga_satuan, 2),
                'harga_total' => number_format($item->qty_so * $item->harga_satuan, 2),
                'diskon' => number_format($item->nilai_diskon, 2),
                'harga_nett' => number_format($item->total_harga, 2)
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
}
