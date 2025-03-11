<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reports extends Admin_Controller
{
	/*
 * @author Syamsudin
 * @copyright Copyright (c) 2022, Syamsudin
 * 
 * This is controller for Reports
 */

	//Permission
	protected $viewPermission 	= 'Management.View';
	protected $addPermission  	= 'Management.Add';
	protected $managePermission = 'Management.Manage';
	protected $deletePermission = 'Management.Delete';

	public function __construct()
	{
		parent::__construct();

		$this->load->model('reports/Reports_model');

		$this->template->page_icon('fa fa-dashboard');
	}

	public function index()
	{
		$this->template->title('Reports');
		$sum_penawaran = $this->report_model->penawaran();
		$sum_salesorder = $this->report_model->salesorder();

		$this->template->set('penawaran', $sum_penawaran);
		$this->template->set('salesorder', $sum_salesorder);

		$this->template->render('index');
	}

	public function penawaran()
	{

		$this->auth->restrict($this->viewPermission);
		$session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
		$data = $this->Reports_model->CariPenawaran();
		$this->template->set('results', $data);
		$this->template->title('Report Penawaran');
		$this->template->render('report_penawaran');
	}

	public function penawaran_so()
	{

		$this->auth->restrict($this->viewPermission);
		$session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
		$data = $this->Reports_model->CariPenawaranSo();
		$this->template->set('results', $data);
		$this->template->title('Report Penawaran Deal');
		$this->template->render('report_penawaran_so');
	}

	public function penawaran_dikirim()
	{

		$this->auth->restrict($this->viewPermission);
		$session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
		$data = $this->Reports_model->CariPenawaranDikirim();
		$this->template->set('results', $data);
		$this->template->title('Report Penawaran On Progress');
		$this->template->render('report_penawaran_dikirim');
	}

	public function penawaran_loss()
	{

		$this->auth->restrict($this->viewPermission);
		$session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
		$data = $this->Reports_model->CariPenawaranLoss();
		$this->template->set('results', $data);
		$this->template->title('Report Penawaran On Progress');
		$this->template->render('report_penawaran_loss');
	}

	public function salesorder()
	{
		$this->auth->restrict($this->viewPermission);
		$session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
		$data = $this->Reports_model->cariSalesOrder();
		$this->template->set('results', $data);
		$this->template->title('Report Sales Order');
		$this->template->render('report_salesorder');
	}

	public function tampilkan_salesorder()
	{
		$this->auth->restrict($this->viewPermission);
		$session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
		$data = $this->Reports_model->cariSalesOrderTgl($this->input->post("tanggal"));
		$this->template->set('results', $data);
		$this->template->title('Report Sales Order');
		$this->template->render('report_salesorder');
	}

	public function detail_salesorder()
	{
		$this->auth->restrict($this->viewPermission);
		$session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
		
		$this->template->title('Report Detail Sales Order');
		$this->template->render('report_detail_salesorder');
	}

	public function tampilkan_detail_salesorder()
	{
		$this->auth->restrict($this->viewPermission);
		$session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
		$data = $this->Reports_model->cariSalesOrderDetailTgl($this->input->post("tanggal"));
		$this->template->set('results', $data);
		$this->template->title('Report Detail Sales Order');
		$this->template->render('report_detail_salesorder');
	}

	public function report_mutasi_stock()
	{
		$this->auth->restrict($this->viewPermission);
		$session = $this->session->userdata('app_session');

		$get_product = $this->db->select('a.id_category3, a.nama')->from('ms_inventory_category3 a')->join('kartu_stok b', 'b.id_category3 = a.id_category3')->where('a.deleted', 0)->group_by('a.id_category3')->get()->result();

		$this->template->page_icon('fa fa-users');
		$this->template->title('Report Mutasi Stock');
		$this->template->set('list_product', $get_product);
		$this->template->render('report_mutasi_stock');
	}

	public function invoice()
	{
		$this->auth->restrict($this->viewPermission);
		$session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');

		$this->template->title('Report Invoicing');
		$this->template->render('report_invoice');
	}

	public function tampilkan_invoice()
	{
		$this->auth->restrict($this->viewPermission);
		$session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
		$data = $this->Reports_model->CariInvoiceTgl($this->input->post("tanggal"));
		$this->template->set('results', $data);
		$this->template->title('Report Invoicing');
		$this->template->render('report_invoice');
	}

	public function penerimaan()
	{
		$this->auth->restrict($this->viewPermission);
		$session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
		$data = $this->Reports_model->CariPayment();
		$this->template->set('results', $data);
		$this->template->title('Report Penerimaan');
		$this->template->render('report_payment');
	}

	public function tampilkan_penerimaan()
	{
		$this->auth->restrict($this->viewPermission);
		$session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
		$data = $this->Reports_model->CariPaymentTgl($this->input->post("tanggal"));
		$this->template->set('results', $data);
		$this->template->title('Report Penerimaan');
		$this->template->render('report_payment');
	}

	public function tampilkan_jurnal_invoice()
	{
		$this->auth->restrict($this->viewPermission);
		$session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
		$data = $this->Reports_model->CariJurnalInvoiceTgl($this->input->post("tanggal"));
		$this->template->set('results', $data);
		$this->template->title('Report Jurnal Invoicing');
		$this->template->render('report_jurnal_invoice');
	}

	public function unlocated()
	{
		$this->auth->restrict($this->viewPermission);
		$session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
		$data = $this->Reports_model->CariDeposit();
		$this->template->set('results', $data);
		$this->template->title('Report Deposit');
		$this->template->render('report_deposit');
	}

	public function revenue()
	{
		$this->auth->restrict($this->viewPermission);
		$session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
		
		$this->template->title('Report Revenue');
		$this->template->render('report_revenue');
	}

	public function export_excel_report_revenue() {
		$tanggal = $this->input->get('tanggal');
		$tanggal_to = $this->input->get('tanggal_to');

		$this->db->select('a.no_so, a.tgl_so, a.no_surat, a.pengakuan_invoice, a.pengakuan_hpp, b.grand_total');
        $this->db->from('tr_revenue a');
        $this->db->join('tr_sales_order b', 'b.no_so=a.no_so');
        $this->db->where('a.status_jurnal', 'CLS');
        if ($tanggal !== '') {
            $this->db->where('a.tgl_so >=', $tanggal);
        }
        if ($tanggal_to !== '') {
            $this->db->where('a.tgl_so <=', $tanggal_to);
        }
        if (($tanggal !== '') && ($tanggal_to !== '')) {
            $this->db->where('a.tgl_so >=', $tanggal);
            $this->db->where('a.tgl_so <=', $tanggal_to);
        }
        $this->db->group_by('a.id');
        $this->db->order_by('a.tgl_so', 'desc');
        $get_data = $this->db->get()->result();

		$this->load->view('export_excel_report_revenue', array('list_revenue' => $get_data));
	}

	public function export_excel_report_revenue_detail() {
		$tanggal = $this->input->get('tanggal');
		$tanggal_to = $this->input->get('tanggal_to');

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
        $this->db->group_by('a.id');
		$this->db->order_by('a.tgl_so', 'desc');
        $get_data_all = $this->db->get()->result();

		$this->load->view('export_excel_report_revenue_detail', array('list_revenue_detail' => $get_data_all));
	}

	public function tampilkan_revenue()
	{
		$this->auth->restrict($this->viewPermission);
		$session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
		$data = $this->Reports_model->CariRevenueTgl($this->input->post("tanggal"));
		$this->template->set('results', $data);
		$this->template->title('Report Revenue');
		$this->template->render('report_revenue');
	}

	public function detailrevenue()
	{
		$this->auth->restrict($this->viewPermission);
		$session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
		$this->template->title('Report Revenue');
		$this->template->render('report_revenue_detail');
	}
	public function detailrevenueso()
	{
		$this->auth->restrict($this->viewPermission);
		$session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
		$data = $this->Reports_model->CariRevenuedetailDoSO();
		$this->template->set('results', $data);
		$this->template->title('Report Penjualan dan Pengiriman');
		$this->template->render('report_do_so');
	}
	public function tampilkan_do_so()
	{
		$this->auth->restrict($this->viewPermission);
		$session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
		$data = $this->Reports_model->CariRevenuedetailDoSOTgl($this->input->post("tanggal"));
		$this->template->set('results', $data);
		$this->template->title('Report Penjualan dan Pengiriman');
		$this->template->render('report_do_so');
	}

	public function update_begining()
	{
		$begining = $this->db->query("SELECT * FROM begining_stok_juni")->result();
		$no = 0;
		foreach ($begining as $dt) {
			$id_category3 = $dt->id_category3;
			$qty		  = $dt->qty;
			$idstok		  = $dt->id;
			$costbook	  = $dt->harga_satuan;
			$no++;

			$update = $this->db->query("UPDATE ms_costbook SET nilai_costbook=$costbook WHERE id_category3='$id_category3'");

			print_r($no);
			print_r($id_category3);
			print_r($idstok);
			echo "<br>";
		}
	}
	public function tampilkan_stock()
	{
		$this->auth->restrict($this->viewPermission);
		$session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
		$data = $this->Reports_model->stock_value();
		$this->template->set('results', $data);
		$this->template->title('Report Value Inventory ');
		$this->template->render('report_stock');
	}

	public function get_data_report_detail_sales_order() {
		$this->Reports_model->get_data_report_detail_sales_order();
	}

	public function get_data_report_revenue() {
		$this->Reports_model->get_data_report_revenue();
	}

	public function get_data_report_revenue_detail() {
		$this->Reports_model->get_data_report_revenue_detail();
	}

	public function get_data_report_mutasi_stock() {
		$this->Reports_model->get_data_report_mutasi_stock();
	}

	public function get_report_invoice() {
		$this->Reports_model->get_report_invoice();
	}

	public function export_excel($tanggal = null, $tanggal_to = null) {
		// $tanggal = $this->input->post('tanggal');
		// $tanggal_to = $this->input->post('tanggal_to');

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
        if(($tanggal !== '' && $tanggal !== null) && ($tanggal_to !== '' && $tanggal_to !== null)) {
            $this->db->where('b.tgl_so >=', $tanggal);
            $this->db->where('b.tgl_so <=', $tanggal_to);
        }
		$this->db->group_by('a.id_so_detail');
        $this->db->order_by('b.tgl_so', 'desc');
		$get_data = $this->db->get()->result();

		$this->load->view('export_excel_detail_salesorder', array('data' => $get_data));
	}

	public function export_excel_report_invoicing() {
		$tanggal = $this->input->get('tanggal');
		$tanggal_to = $this->input->get('tanggal_to');

		$this->db->select('a.*, b.name_customer as name_customer, c.nama_top');
        $this->db->from('tr_invoice a');
        $this->db->join('master_customers b', 'b.id_customer = a.id_customer');
        $this->db->join('ms_top c', 'c.id_top = a.top');
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

        $get_data = $this->db->get()->result();

		$data = array(
			'data_invoicing' => $get_data
		);

		$this->load->view('export_excel_report_invoicing', $data);
	}
}
