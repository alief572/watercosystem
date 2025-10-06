<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Admin_Controller {
/*
 * @author Yunaz
 * @copyright Copyright (c) 2016, Yunaz
 * 
 * This is controller for Penerimaan
 */
	public function __construct()
	{
		parent::__construct();

        $this->load->model('dashboard/dashboard_model');
              
        $this->template->page_icon('fa fa-dashboard');
	}

	public function index()
	{
		$this->template->title('Dashboard');
		$sum_penawaran = $this->dashboard_model->penawaran();
		$sum_salesorder = $this->dashboard_model->salesorder();
		$sum_invoice = $this->dashboard_model->invoice();
		$sum_bayar = $this->dashboard_model->bayar();
        
        $this->template->set('penawaran', $sum_penawaran);
        $this->template->set('salesorder', $sum_salesorder);
        $this->template->set('invoice', $sum_invoice);
        $this->template->set('bayar', $sum_bayar);
		$this->template->render('index');
		
	}
	
	public function sales()
	{
		$this->template->title('Dashboard');
		$session 		= $this->session->userdata('app_session');
		$user			= $session['kdcab'];
		$iduser         = $this->auth->user_id();
		
		
		$karyawan		=  $this->dashboard_model->get_data('ms_karyawan','divisi','2');
		$sum_penawaranso = $this->dashboard_model->penawaranso();
		$sum_penawaranloss = $this->dashboard_model->penawaranloss();
		$sum_penawarandikirim = $this->dashboard_model->penawarandikirim();
		$sum_salesorder = $this->dashboard_model->salesorder();
		$sum_invoice = $this->dashboard_model->invoice();
		$sum_bayar = $this->dashboard_model->bayar();
        
        
		$this->template->set('penawaranso', $sum_penawaranso);
		$this->template->set('penawaranloss', $sum_penawaranloss);
		$this->template->set('penawarandikirim', $sum_penawarandikirim);
        $this->template->set('salesorder', $sum_salesorder);
        $this->template->set('invoice', $sum_invoice);
        $this->template->set('bayar', $sum_bayar);
		
		$this->template->set('karyawan', $karyawan);
		$this->template->render('sales');
		
	}

	public function management()
	{
		$this->template->title('Dashboard');
		$sum_penawaranso = $this->dashboard_model->penawaranso();
		$sum_penawaranloss = $this->dashboard_model->penawaranloss();
		$sum_penawarandikirim = $this->dashboard_model->penawarandikirim();
		$sum_salesorder = $this->dashboard_model->salesorder();
		$sum_invoice = $this->dashboard_model->invoice();
		$sum_bayar = $this->dashboard_model->bayar();
        
        
		$this->template->set('penawaranso', $sum_penawaranso);
		$this->template->set('penawaranloss', $sum_penawaranloss);
		$this->template->set('penawarandikirim', $sum_penawarandikirim);
        $this->template->set('salesorder', $sum_salesorder);
        $this->template->set('invoice', $sum_invoice);
        $this->template->set('bayar', $sum_bayar);
		$this->template->render('management');
		
	}

	public function management_chart()
	{
		$this->template->title('Dashboard');
		$sum_penawaran = $this->dashboard_model->penawaran();
		$sum_salesorder = $this->dashboard_model->salesorder();
		$sum_invoice = $this->dashboard_model->invoice();
		$sum_bayar = $this->dashboard_model->bayar();
        
        $this->template->set('penawaran', $sum_penawaran);
        $this->template->set('salesorder', $sum_salesorder);
        $this->template->set('invoice', $sum_invoice);
        $this->template->set('bayar', $sum_bayar);
		$this->template->render('management_chart');
		
	}
	
	## JSON DATA DASHBOARD
	function json_dashboard(){
		$Arr_Return		= array();
		$session 		= $this->session->userdata('app_session');
		$kdcab			= $session['kdcab'];
		## Data_Piutang	##
		$WHERE			= "(hargajualtotal - jum_bayar) > 0";
		if($kdcab !='100'){
			if(!empty($WHERE))$WHERE	.=" AND ";
			$WHERE	.="kdcab='".$kdcab."'";
		}
		$Query_Piutang	= "SELECT
							  SUM(CASE WHEN umur <= 15 THEN (hargajualtotal - jum_bayar) ELSE 0 END) AS umur_15,
							  SUM(CASE WHEN umur > 15 AND umur <= 30 THEN (hargajualtotal - jum_bayar) ELSE 0 END) AS umur_30,
							  SUM(CASE WHEN umur > 30 AND umur <= 60 THEN (hargajualtotal - jum_bayar) ELSE 0 END) AS umur_60,
							  SUM(CASE WHEN umur > 60 AND umur <= 90 THEN (hargajualtotal - jum_bayar) ELSE 0 END) AS umur_90,
							  SUM(CASE WHEN umur > 90 THEN (hargajualtotal - jum_bayar) ELSE 0 END) AS umur_91
							FROM
								view_invoice_payment
							WHERE
								 ".$WHERE;
		$det_Piutang	= $this->db->query($Query_Piutang)->result();
		$Arr_Return		= array(
			'ar_umur_15'	=> round($det_Piutang[0]->umur_15 / 1000000),
			'ar_umur_30'	=> round($det_Piutang[0]->umur_30 / 1000000),
			'ar_umur_60'	=> round($det_Piutang[0]->umur_60 / 1000000),
			'ar_umur_90'	=> round($det_Piutang[0]->umur_90 / 1000000),
			'ar_umur_91'	=> round($det_Piutang[0]->umur_91 / 1000000)
		);
		echo json_encode($Arr_Return);
	}
	function get_piutang_dashboard($kategori){
		$session 	= $this->session->userdata('app_session');
		$kdcab		= $session['kdcab'];
		## Data_Piutang	##
		$WHERE		= "(hargajualtotal - jum_bayar) > 0";
		if($kdcab !='100'){
			if(!empty($WHERE))$WHERE	.=" AND ";
			$WHERE	.="kdcab='".$kdcab."'";
		}
		if($kategori=='1'){
			if(!empty($WHERE))$WHERE	.=" AND ";
			$WHERE	.="umur <= 15";
		}else if($kategori==2){
			if(!empty($WHERE))$WHERE	.=" AND ";
			$WHERE	.="(umur > 15 AND umur <=30)";
			
		}else if($kategori==3){
			if(!empty($WHERE))$WHERE	.=" AND ";
			$WHERE	.="(umur > 30 AND umur <=60)";
		}else if($kategori==4){
			if(!empty($WHERE))$WHERE	.=" AND ";
			$WHERE	.="(umur > 60 AND umur <=90)";
		}else if($kategori==5){
			if(!empty($WHERE))$WHERE	.=" AND ";
			$WHERE	.="umur > 90";
		}
		$Query_Piutang	= "SELECT * FROM view_invoice_payment WHERE ".$WHERE;
		$det_Piutang	= $this->db->query($Query_Piutang)->result();
		//echo"<pre>";print_r($records);exit;
		$this->template->set('kategori', $kategori);
		$this->template->set('rows_ar', $det_Piutang);
        $this->template->render('piutang_dashboard');
	}
	
	
	
	function excel_piutang_dashboard($kategori){
		$session 	= $this->session->userdata('app_session');
		$kdcab		= $session['kdcab'];
		## Data_Piutang	##
		$WHERE		= "(hargajualtotal - jum_bayar) > 0";
		if($kdcab !='100'){
			if(!empty($WHERE))$WHERE	.=" AND ";
			$WHERE	.="kdcab='".$kdcab."'";
		}
		if($kategori=='1'){
			if(!empty($WHERE))$WHERE	.=" AND ";
			$WHERE	.="umur <= 15";
		}else if($kategori==2){
			if(!empty($WHERE))$WHERE	.=" AND ";
			$WHERE	.="(umur > 15 AND umur <=30)";
			
		}else if($kategori==3){
			if(!empty($WHERE))$WHERE	.=" AND ";
			$WHERE	.="(umur > 30 AND umur <=60)";
		}else if($kategori==4){
			if(!empty($WHERE))$WHERE	.=" AND ";
			$WHERE	.="(umur > 60 AND umur <=90)";
		}else if($kategori==5){
			if(!empty($WHERE))$WHERE	.=" AND ";
			$WHERE	.="umur > 90";
		}
		$Query_Piutang	= "SELECT * FROM view_invoice_payment WHERE ".$WHERE;
		$det_Piutang	= $this->db->query($Query_Piutang)->result();
		$data		= array(
			'rows_ar'	=> $det_Piutang,
			'kategori'	=> $kategori
		);
		$this->load->view('excel_piutang',$data);
		//echo"<pre>";print_r($records);exit;
		/*
		$this->template->set('kategori', $kategori);
		$this->template->set('rows_ar', $det_Piutang);
        $this->template->render('excel_piutang');
		*/
	}
	
	public function penawaran_pending()
	{
		$this->template->title('Dashboard Penawaran Pending');
		$sum_penawaranso = $this->dashboard_model->penawaranso();
		$sum_penawaranloss = $this->dashboard_model->penawaranloss();
		$sum_penawarandikirim = $this->dashboard_model->penawaranpending();
		$sum_salesorder = $this->dashboard_model->salesorder();
		$sum_invoice = $this->dashboard_model->invoice();
		$sum_bayar = $this->dashboard_model->bayar();
        
        
		$this->template->set('penawaranso', $sum_penawaranso);
		$this->template->set('penawaranloss', $sum_penawaranloss);
		$this->template->set('penawarandikirim', $sum_penawarandikirim);
        $this->template->set('salesorder', $sum_salesorder);
        $this->template->set('invoice', $sum_invoice);
        $this->template->set('bayar', $sum_bayar);
		$this->template->render('penawaran_pending');
		
	}
	
	public function pengiriman_terlambat()
	{
		$this->template->title('Dashboard Pengiriman Terlambat');
		$kirim = $this->dashboard_model->kirim_terlambat();  
        
		
        $this->template->set('pengiriman', $kirim);
		$this->template->render('pengiriman_terlambat');
		
	}
	public function penerimaan_terlambat()
	{
		$this->template->title('Dashboard Penerimaan Terlambat');
		$terima = $this->dashboard_model->terima_terlambat();  
        
		
        $this->template->set('penerimaan', $terima);
		$this->template->render('penerimaan_terlambat');
		
	}
}
