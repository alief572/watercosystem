<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * @author Yunas Handra
 * @copyright Copyright (c) 2016, Yunas Handra
 * 
 * This is model class for table "log_5masterbarang"
 */

class Report_mutasi_stock_model extends BF_Model
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
        $where2 = "a.tgl_so LIKE '%$blnthn%'";
        $this->db->where($where2);
        $this->db->where('a.deleted_by <>', '1');
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
        $this->db->where('a.deleted_by IS NULL');
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
        $tanggal_to = $this->input->post('tanggal_to');

        $this->db->select('a.*, b.tgl_so, b.no_surat, c.name_customer as customer');
        $this->db->from('tr_sales_order_detail a');
        $this->db->join('tr_sales_order b', 'b.no_so=a.no_so');
        $this->db->join('master_customers c', 'c.id_customer=b.id_customer');
        if ($tanggal !== '' && $tanggal !== null) {
            $this->db->where('b.tgl_so >=', $tanggal);
        }
        if ($tanggal_to !== '' && $tanggal_to !== null) {
            $this->db->where('b.tgl_so <=', $tanggal_to);
        }
        if (($tanggal !== '' && $tanggal !== null) && ($tanggal_to !== '' && $tanggal_to !== null)) {
            $this->db->where('b.tgl_so >=', $tanggal);
            $this->db->where('b.tgl_so <=', $tanggal_to);
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
            $this->db->where('b.tgl_so >=', $tanggal);
        }
        if ($tanggal_to !== '' && $tanggal_to !== null) {
            $this->db->where('b.tgl_so <=', $tanggal_to);
        }
        if (($tanggal !== '' && $tanggal !== null) && ($tanggal_to !== '' && $tanggal_to !== null)) {
            $this->db->where('b.tgl_so >=', $tanggal);
            $this->db->where('b.tgl_so <=', $tanggal_to);
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

        $ttl_harga_total = 0;
        $ttl_diskon = 0;
        $ttl_harga_nett = 0;

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

            $ttl_harga_total += ($item->qty_so * $item->harga_satuan);
            $ttl_diskon += $item->nilai_diskon;
            $ttl_harga_nett += $item->total_harga;

            $no++;
        }

        echo json_encode([
            'ttl_harga_total' => $ttl_harga_total,
            'ttl_diskon' => $ttl_diskon,
            'ttl_harga_nett' => $ttl_harga_nett,
            'draw' => intval($draw),
            'recordsTotal' => $query_all->num_rows(),
            'recordsFiltered' => $query_all->num_rows(),
            'data' => $hasil
        ]);
    }

    public function get_data_report_revenue()
    {
        $draw = $this->input->post('draw');
        $start = $this->input->post('start');
        $length = $this->input->post('length');
        $search = $this->input->post('search');

        $tanggal = $this->input->post('tanggal');
        $tanggal_to = $this->input->post('tanggal_to');

        $this->db->select('a.no_so, a.tgl_so, a.no_surat, a.pengakuan_invoice, a.pengakuan_hpp, b.grand_total');
        $this->db->from('tr_revenue a');
        $this->db->join('tr_sales_order b', 'b.no_so=a.no_so');
        $this->db->where('a.status_jurnal', 'CLS');
        if ($tanggal !== '' && $tanggal !== null) {
            $this->db->where('a.tgl_so >=', $tanggal);
        }
        if ($tanggal_to !== '' && $tanggal_to !== null) {
            $this->db->where('a.tgl_so <=', $tanggal_to);
        }
        if (($tanggal !== '' && $tanggal !== null) && ($tanggal_to !== '' && $tanggal_to !== null)) {
            $this->db->where('a.tgl_so >=', $tanggal);
            $this->db->where('a.tgl_so <=', $tanggal_to);
        }

        if (!empty($search['value'])) {
            $where_invoice = '(SELECT aa.no_surat FROM tr_invoice aa WHERE aa.no_so = a.no_so)';

            $this->db->group_start();
            $this->db->like('a.tgl_so', $search['value'], 'both');
            $this->db->or_like('a.no_surat', $search['value'], 'both');
            $this->db->or_like('b.grand_total', $search['value'], 'both');
            $this->db->or_like('a.pengakuan_invoice', $search['value'], 'both');
            $this->db->or_like('a.pengakuan_hpp', $search['value'], 'both');
            $this->db->group_end();
        }
        $this->db->group_by('a.id');
        $this->db->order_by('a.tgl_so', 'desc');
        $this->db->limit($length, $start);
        $get_data = $this->db->get();

        $this->db->select('a.no_so, a.tgl_so, a.no_surat, a.pengakuan_invoice, a.pengakuan_hpp, b.grand_total');
        $this->db->from('tr_revenue a');
        $this->db->join('tr_sales_order b', 'b.no_so = a.no_so');
        $this->db->where('a.status_jurnal', 'CLS');
        if ($tanggal !== '' && $tanggal !== null) {
            $this->db->where('a.tgl_so >=', $tanggal);
        }
        if ($tanggal_to !== '' && $tanggal_to !== null) {
            $this->db->where('a.tgl_so <=', $tanggal_to);
        }
        if (($tanggal !== '' && $tanggal !== null) && ($tanggal_to !== '' && $tanggal_to !== null)) {
            $this->db->where('a.tgl_so >=', $tanggal);
            $this->db->where('a.tgl_so <=', $tanggal_to);
        }

        if (!empty($search['value'])) {
            $where_invoice = '(SELECT aa.no_surat FROM tr_invoice aa WHERE aa.no_so = a.no_so)';

            $this->db->group_start();
            $this->db->like('a.tgl_so', $search['value'], 'both');
            $this->db->or_like('a.no_surat', $search['value'], 'both');
            $this->db->or_like('b.grand_total', $search['value'], 'both');
            $this->db->or_like('a.pengakuan_invoice', $search['value'], 'both');
            $this->db->or_like('a.pengakuan_hpp', $search['value'], 'both');
            $this->db->group_end();
        }
        $this->db->group_by('a.id');
        $this->db->order_by('a.tgl_so', 'desc');
        $get_data_all = $this->db->get();

        $hasil = array();

        // $totalgrandtotalformat = 0;
        // $totalinvoiceformat = 0;
        // $totalhppformat = 0;

        $ttl_total_so = 0;
        $ttl_revenue = 0;
        $ttl_hpp = 0;

        $no = ($start + 0);
        foreach ($get_data->result() as $item) {
            $no++;

            $so = $item->no_so;
            $invoice = $this->db->query("select no_surat FROM tr_invoice WHERE no_so = '" . $so . "'")->result();
            $separator = ',';
            $allinv = array();
            foreach ($invoice as $inv) {
                $allinv[] = $inv->no_surat;
            }

            $invc =  implode($separator, $allinv);

            $hasil[] = [
                'no' => $no,
                'tgl' =>  date('d-F-Y', strtotime($item->tgl_so)),
                'no_so' => $item->no_surat,
                'no_invoice' => $invc,
                'total_so' => number_format($item->grand_total, 2),
                'revenue' => number_format($item->pengakuan_invoice, 2),
                'hpp' => number_format($item->pengakuan_hpp, 2)
            ];

            $ttl_total_so += $item->grand_total;
            $ttl_revenue += $item->pengakuan_invoice;
            $ttl_hpp += $item->pengakuan_hpp;
        }

        echo json_encode([
            'totalgrandtotalformat' => $ttl_total_so,
            'totalinvoiceformat' => $ttl_revenue,
            'totalhppformat' => $ttl_hpp,
            'draw' => intval($draw),
            'recordsTotal' => $get_data_all->num_rows(),
            'recordsFiltered' => $get_data_all->num_rows(),
            'data' => $hasil
        ]);
    }

    public function get_data_report_revenue_detail()
    {
        $draw = $this->input->post('draw');
        $start = $this->input->post('start');
        $length = $this->input->post('length');
        $search = $this->input->post('search');

        $tanggal = $this->input->post('tanggal');
        $tanggal_to = $this->input->post('tanggal_to');

        $this->db->select('a.*, b.no_so, SUM(b.qty * b.harga_satuan) as pricelist, SUM((b.qty * b.harga_satuan) * b.diskon / 100) as disc, b.diskon as disc_persen');
        $this->db->from('tr_revenue a');
        $this->db->join('tr_sales_order_detail b', 'b.no_so = a.no_so', 'left');
        if ($tanggal !== '' && $tanggal !== null) {
            $this->db->where('a.tgl_so >=', $tanggal);
        }
        if ($tanggal_to !== '' && $tanggal_to !== null) {
            $this->db->where('a.tgl_so <=', $tanggal_to);
        }
        if (($tanggal !== '' && $tanggal !== null) && ($tanggal_to !== '' && $tanggal_to !== null)) {
            $this->db->where('a.tgl_so >=', $tanggal);
            $this->db->where('a.tgl_so <=', $tanggal_to);
        }
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('a.tgl_so', $search['value'], 'both');
            $this->db->or_like('a.no_surat', $search['value'], 'both');
            $this->db->or_like('a.perseninvoice_pengakuan', $search['value'], 'both');
            $this->db->or_like('a.pengakuan_invoice', $search['value'], 'both');
            $this->db->or_like('a.pengakuan_hpp', $search['value'], 'both');
            $this->db->or_like('a.status_jurnal', $search['value'], 'both');
            $this->db->group_end();
        }
        $this->db->group_by('a.id');
        $this->db->order_by('a.tgl_so', 'desc');
        $this->db->limit($length, $start);
        $get_data = $this->db->get();

        $this->db->select('a.*, b.no_so, SUM(b.qty * b.harga_satuan) as pricelist, SUM((b.qty * b.harga_satuan) * b.diskon / 100) as disc, b.diskon as disc_persen');
        $this->db->from('tr_revenue a');
        $this->db->join('tr_sales_order_detail b', 'b.no_so = a.no_so', 'left');
        if ($tanggal !== '' && $tanggal !== null) {
            $this->db->where('a.tgl_so >=', $tanggal);
        }
        if ($tanggal_to !== '' && $tanggal_to !== null) {
            $this->db->where('a.tgl_so <=', $tanggal_to);
        }
        if (($tanggal !== '' && $tanggal !== null) && ($tanggal_to !== '' && $tanggal_to !== null)) {
            $this->db->where('a.tgl_so >=', $tanggal);
            $this->db->where('a.tgl_so <=', $tanggal_to);
        }
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('a.tgl_so', $search['value'], 'both');
            $this->db->or_like('a.no_surat', $search['value'], 'both');
            $this->db->or_like('a.perseninvoice_pengakuan', $search['value'], 'both');
            $this->db->or_like('a.pengakuan_invoice', $search['value'], 'both');
            $this->db->or_like('a.pengakuan_hpp', $search['value'], 'both');
            $this->db->or_like('a.status_jurnal', $search['value'], 'both');
            $this->db->group_end();
        }
        $this->db->group_by('a.id');
        $this->db->order_by('a.tgl_so', 'desc');
        $get_data_all = $this->db->get();

        $hasil = array();

        $ttl_revenue = 0;
        $ttl_hpp = 0;

        $no = 0;
        foreach ($get_data->result() as $item) {
            $no++;

            $so = $item->no_so;
            $invoice = $this->db->query("select no_surat FROM tr_invoice WHERE no_so='$so'")->result();
            $separator = ',';
            $allinv = array();
            foreach ($invoice as $inv) {
                $allinv[] = $inv->no_surat;
                $invoicing = $inv->no_surat;
            }

            $invc =  implode($separator, $allinv);

            $hasil[] = [
                'no' => $no,
                'tgl' => date('d-F-Y', strtotime($item->tgl_so)),
                'no_so' => $item->no_surat,
                'no_invoice' => $invc,
                'persentase' => number_format($item->perseninvoice_pengakuan) . '%',
                'price_list' => number_format($item->pricelist),
                'disc' => number_format($item->disc),
                'revenue' => number_format($item->pengakuan_invoice),
                'hpp' => number_format($item->pengakuan_hpp),
                'jurnal' => $item->status_jurnal,
            ];

            $ttl_revenue += $item->pengakuan_invoice;
            $ttl_hpp += $item->pengakuan_hpp;
        }

        echo json_encode([
            'totalinvoiceformat' => $ttl_revenue,
            'totalhppformat' => $ttl_hpp,
            'draw' => intval($draw),
            'recordsTotal' => $get_data_all->num_rows(),
            'recordsFiltered' => $get_data_all->num_rows(),
            'data' => $hasil
        ]);
    }

    public function get_data_report_mutasi_stock()
    {
        $draw = $this->input->post('draw');
        $start = $this->input->post('start');
        $length = $this->input->post('length');
        $search = $this->input->post('search');

        $product = $this->input->post('product');

        $this->db->select('a.*');
        $this->db->from('kartu_stok a');
        $this->db->where('a.id_category3', $product);
        $this->db->where_in('a.transaksi', array('incoming', 'delivery order'));
        $this->db->where('a.tgl_transaksi >', '2024-01-31');
        if (!empty($search['value'])) {
            $this->db->group_start();
            $this->db->like('a.transaksi', $search['value'], 'both');
            $this->db->or_like('a.no_surat', $search['value'], 'both');
            $this->db->group_end();
        }
        $this->db->order_by('a.tgl_transaksi', 'asc');
        $this->db->limit($length, $start);
        $get_data = $this->db->get();

        $this->db->select('a.*');
        $this->db->from('kartu_stok a');
        $this->db->where('a.id_category3', $product);
        $this->db->where_in('a.transaksi', array('incoming', 'delivery order'));
        $this->db->where('a.tgl_transaksi >', '2024-01-31');
        if (!empty($search['value'])) {
            $this->db->group_start();
            $this->db->like('a.transaksi', $search['value'], 'both');
            $this->db->or_like('a.no_surat', $search['value'], 'both');
            $this->db->group_end();
        }
        $this->db->order_by('a.tgl_transaksi', 'asc');
        $get_data_all = $this->db->get();

        $hasil = [];

        $no = (0 + $start);

        $qty_saldo = 0;
        $price_unit_saldo = 0;
        $saldo_total = 0;
        foreach ($get_data->result() as $item) {
            $no++;

            $saldo_total_per = 0;

            // $this->db->select('a.nilai_costbook');
            // $this->db->from('ms_costbook_backup a');
            // $this->db->where('a.id_category3', $item->);

            $transaksi_price_unit = 0;
            $transaksi_total = 0;
            $transaksi_in_out = $item->qty_transaksi;
            if ($item->transaksi == 'delivery order') {

                $do = $this->db->query("SELECT no_so, cost_book, qty_do FROM tr_delivery_order_detail WHERE id_category3='" . $item->id_category3 . "' AND no_do='" . $item->no_transaksi . "' limit 1")->row();

                $costbook = $do->cost_book;

                // $harga_do = (!empty($get_costbook) && $get_costbook->nilai_costbook > 0) ? ($get_costbook->nilai_costbook / $item->qty_transaksi) : $item->cost_book;

                // if($saldo_total < 1 || $item->qty_akhir < 1) {
                //     $transaksi_price_unit = 0;
                // } else {
                $transaksi_price_unit = $costbook;
                // }
                // $transaksi_price_unit = $harga_do;

                $transaksi_in_out = ($item->qty_transaksi * -1);
                $transaksi_total = ($transaksi_price_unit * ($item->qty_transaksi * 1));

                $saldo_total_per = ($transaksi_price_unit);

                $saldo_total = ($saldo_total_per * $item->qty_akhir);
                if ($item->qty_akhir < 1) {
                    $saldo_total = 0;
                }
            }
            if ($item->transaksi == 'incoming') {
                $transaksi_price_unit = ($item->harga_do / $item->qty_transaksi);
                $transaksi_total = $item->harga_do;

                $saldo_total = ($item->qty_akhir * $item->cost_book);
                if ($saldo_total < 1 || $item->qty_akhir < 1) {
                    $saldo_total_per = 0;
                } else {
                    $saldo_total_per = $item->cost_book;
                }
            }



            $hasil[] = [
                'no' => $no,
                'tgl_transaksi' => $item->tgl_transaksi,
                'keterangan' => strtoupper($item->transaksi),
                'no_transaksi' => $item->no_surat,
                'transaksi_in_out' => number_format($transaksi_in_out),
                'transaksi_price_unit' => number_format($transaksi_price_unit, 2),
                'transaksi_total' => number_format($transaksi_total, 2),
                'saldo_qty' => number_format($item->qty_akhir),
                'saldo_price_unit' => number_format($saldo_total_per, 2),
                'saldo_total' => number_format($saldo_total, 2)
            ];
        }

        echo json_encode([
            'draw' => intval($draw),
            'recordsTotal' => $get_data_all->num_rows(),
            'recordsFiltered' => $get_data_all->num_rows(),
            'data' => $hasil,
        ]);
    }

    public function get_report_invoice()
    {
        $draw = $this->input->post('draw');
        $length = $this->input->post('length');
        $start = $this->input->post('start');
        $search = $this->input->post('search');

        $tanggal = $this->input->post('tanggal');
        $tanggal_to = $this->input->post('tanggal_to');

        $this->db->select('a.*, b.name_customer as name_customer, c.nama_top');
        $this->db->from('tr_invoice a');
        $this->db->join('master_customers b', 'b.id_customer = a.id_customer');
        $this->db->join('ms_top c', 'c.id_top = a.top');
        $this->db->where('a.deleted_by IS NULL');
        if ($tanggal !== '' && $tanggal_to == '') {
            $this->db->where('a.tgl_invoice >=', $tanggal);
        }
        if ($tanggal == '' && $tanggal_to !== '') {
            $this->db->where('a.tgl_invoice <=', $tanggal_to);
        }
        if ($tanggal !== '' && $tanggal_to !== '') {
            $this->db->where('a.tgl_invoice >=', $tanggal);
            $this->db->where('a.tgl_invoice <=', $tanggal_to);
        }
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('a.no_surat', $search['value'], 'both');
            $this->db->like('b.name_customer', $search['value'], 'both');
            $this->db->like('a.nama_sales', $search['value'], 'both');
            $this->db->like('c.nama_top', $search['value'], 'both');
            $this->db->like('a.payment', $search['value'], 'both');
            $this->db->like('a.grand_total', $search['value'], 'both');
            $this->db->like('a.nilai_invoice', $search['value'], 'both');
            $this->db->like('a.tgl_invoice', $search['value'], 'both');
            $this->db->group_end();
        }
        $this->db->order_by('a.id', 'desc');
        $this->db->limit($length, $start);

        $get_data = $this->db->get();

        $this->db->select('a.*, b.name_customer as name_customer, c.nama_top');
        $this->db->from('tr_invoice a');
        $this->db->join('master_customers b', 'b.id_customer = a.id_customer');
        $this->db->join('ms_top c', 'c.id_top = a.top');
        $this->db->where('a.deleted_by IS NULL');
        if ($tanggal !== '' && $tanggal_to == '') {
            $this->db->where('a.tgl_invoice >', $tanggal);
        }
        if ($tanggal == '' && $tanggal_to !== '') {
            $this->db->where('a.tgl_invoice <', $tanggal_to);
        }
        if ($tanggal !== '' && $tanggal_to !== '') {
            $this->db->where('a.tgl_invoice >', $tanggal);
            $this->db->where('a.tgl_invoice <', $tanggal_to);
        }
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('a.no_surat', $search['value'], 'both');
            $this->db->like('b.name_customer', $search['value'], 'both');
            $this->db->like('a.nama_sales', $search['value'], 'both');
            $this->db->like('c.nama_top', $search['value'], 'both');
            $this->db->like('a.payment', $search['value'], 'both');
            $this->db->like('a.grand_total', $search['value'], 'both');
            $this->db->like('a.nilai_invoice', $search['value'], 'both');
            $this->db->like('a.tgl_invoice', $search['value'], 'both');
            $this->db->group_end();
        }
        $this->db->order_by('a.tgl_invoice', 'desc');

        $get_data_all = $this->db->get();

        $totaldppformat = 0;
        $totalformat = 0;
        $no = (0 + $start);

        $hasil = [];

        foreach ($get_data->result() as $item) {
            $no++;

            $hasil[] = [
                'no' => $no,
                'no_invoice' => $item->no_surat,
                'nama_customer' => $item->name_customer,
                'marketing' => $item->nama_sales,
                'top' => $item->nama_top,
                'payment' => $item->payment,
                'nilai_dpp' => number_format($item->grand_total, 2),
                'nilai_invoice' => number_format($item->nilai_invoice, 2),
                'tanggal_invoice' => date('d F Y', strtotime($item->tgl_invoice))
            ];

            $total = $item->nilai_invoice;
            $totaldpp = $item->grand_total;

            $totaldppformat += $totaldpp;
            $totalformat += $total;
        }

        echo json_encode([
            'draw' => intval($draw),
            'recordsTotal' => $get_data_all->num_rows(),
            'recordsFiltered' => $get_data_all->num_rows(),
            'totaldppformat' => $totaldppformat,
            'totalformat' => $totalformat,
            'data' => $hasil
        ]);
    }

    public function get_data_mutasi_stock($tgl = null)
    {
        if (empty($tgl)) {
            $tgl = date('Y-m-d');
        }

        if (empty($tgl) || $tgl == date('Y-m-d')) {
            $this->db->select('a.*, b.qty_free as qty, c.nilai_costbook');
            $this->db->from('ms_inventory_category3 a');
            $this->db->join('stock_material b', 'b.id_category3 = a.id_category3');
            $this->db->join('ms_costbook c', 'c.id_category3 = a.id_category3');
            $this->db->where('b.deleted', null);
        } else {
            $this->db->select('a.*, b.qty_free as qty, c.nilai_costbook');
            $this->db->from('ms_inventory_category3 a');
            $this->db->join('stock_material_backup b', 'b.id_category3 = a.id_category3');
            $this->db->join('ms_costbook_backup c', 'c.id_category3 = a.id_category3');
            $this->db->where('b.deleted', null);
            $this->db->like('b.tgl', $tgl, 'both');
            $this->db->like('c.tgl', $tgl, 'both');
        }
        $this->db->order_by('a.id_category3', 'asc');
        $get_data = $this->db->get()->result();

        return $get_data;
    }

    public function get_kartu_mutasi_stock($id_category3 = null, $tgl = null)
    {
        $this->db->select('a.*');
        $this->db->from('kartu_stok a');
        $this->db->where('a.tgl_transaksi >', '2024-01-31');
        $this->db->where('a.tgl_transaksi <=', $tgl);
        if (!empty($id_category3)) {
            $this->db->where('a.id_category3', $id_category3);
        }
        $this->db->order_by('a.id_kartu_stok', 'asc');
        $get_data = $this->db->get()->result();

        return $get_data;
    }

    public function get_inventory3($id_category3)
    {
        $get_data = $this->db->get_where('ms_inventory_category3', array('id_category3' => $id_category3))->row();

        return $get_data;
    }
}
