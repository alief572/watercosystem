<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/*
 * @author Syamsudin
 * @copyright Copyright (c) 2022, Syamsudin
 *
 * This is controller for Purchase Order Payment
 */

class Purchase_order_payment extends Admin_Controller
{
    //Permission
    protected $viewPermission 	= 'Purchase_Order.View';
    protected $addPermission  	= 'Purchase_Order.Add';
    protected $managePermission = 'Purchase_Order.Manage';
    protected $deletePermission = 'Purchase_Order.Delete'; 

    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('Mpdf', 'upload', 'Image_lib'));
        $this->load->model(array('Purchase_order_payment/Pr_model',
                                 'Aktifitas/aktifitas_model',
                                ));
        $this->template->title('Manage Data Supplier');
        $this->template->page_icon('fa fa-building-o');

        date_default_timezone_set('Asia/Bangkok');


    }
    public function index()
    {
       $this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
        $data = $this->db->query("SELECT a.*, b.id_suplier, b.status, c.name_suplier as namesup FROM tr_incoming as a 								 
								 INNER JOIN tr_purchase_order as b on a.no_po = b.no_po 
								 INNER JOIN master_supplier as c on b.id_suplier = c.id_suplier 
								 WHERE a.status_bayar='OPN' AND b.status='2' AND a.approve_bayar != '1' AND status_jurnal='CLS' AND rencana_bayar_idr < 1 ORDER BY a.no_po DESC")->result();

        $this->template->set('results', $data);
        $this->template->title('Purchase Order Payment');
        $this->template->render('index_incoming');
    }
	
	
	 public function index_approval()
    {
       $this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
        $data = $this->db->query("SELECT a.*, b.id_suplier, b.status, c.name_suplier as namesup FROM tr_incoming as a 								 
								 INNER JOIN tr_purchase_order as b on a.no_po = b.no_po 
								 INNER JOIN master_supplier as c on b.id_suplier = c.id_suplier 
								 WHERE a.status_bayar='OPN' AND b.status='2' AND a.request_bayar = '1' AND a.approve_bayar = '0' ORDER BY a.no_po DESC")->result();

        $this->template->set('results', $data);
        $this->template->title('Approval Pembayaran');
        $this->template->render('index_approval');
    }
	
	
	public function index_payment()
    {
       $this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
        $data = $this->db->query("SELECT a.*, b.id_suplier, b.status, c.name_suplier as namesup FROM tr_incoming as a 								 
								 INNER JOIN tr_purchase_order as b on a.no_po = b.no_po 
								 INNER JOIN master_supplier as c on b.id_suplier = c.id_suplier 
								 WHERE a.status_bayar='OPN' AND b.status='2' AND a.approve_bayar = '1' ORDER BY a.no_po DESC")->result();

        $this->template->set('results', $data);
        $this->template->title('Purchase Order Payment');
        $this->template->render('index_payment');
    }


	public function index_bea()
    {
       $this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
        $data = $this->db->query("SELECT a.*, b.name_suplier as namesup FROM tr_purchase_order as a 
								 INNER JOIN master_supplier as b on a.id_suplier = b.id_suplier 
								 WHERE a.status='2' ORDER BY a.no_po DESC")->result();

        $this->template->set('results', $data);
        $this->template->title('Bayar Pajak Bea Cukai');
        $this->template->render('index');
    }

	public function jurnal_po()
    {
       $this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
        $data = $this->db->query("SELECT a.*, b.no_surat FROM tr_po_payment as a 
								 INNER JOIN tr_purchase_order as b on a.no_po = b.no_po 
								 ORDER BY a.created_on DESC")->result();

        $this->template->set('results', $data);
        $this->template->title('Jurnal Pembayaran PO');
        $this->template->render('index_jurnal');
    }


		public function add()
    {
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$aktif = 'active';
		$deleted = '0';
		$supplier = $data = $this->db->query("SELECT a.* FROM master_supplier as a INNER JOIN dt_trans_pr as b on b.suplier = a.id_suplier INNER JOIN tr_purchase_request as c on b.no_pr = c.no_pr WHERE c.status = '2' GROUP BY b.suplier ")->result();
		$comp	= $this->db->query("select a.*, b.nominal as nominal_harga FROM ms_compotition as a inner join child_history_lme as b on b.id_compotition=a.id_compotition where a.deleted='0' and b.status='0' ")->result();
		$customers = $this->Pr_model->get_data('master_customers','deleted',$deleted);
		$karyawan = $this->Pr_model->get_data('ms_karyawan','deleted',$deleted);
		$mata_uang = $this->Pr_model->get_data('mata_uang','deleted'.$deleted);
		$matauang = $this->db->get_where('matauang')->result();
		$data = [
			'supplier' => $supplier,
			'comp' => $comp,
			'customers' => $customers,
			'karyawan' => $karyawan,
			'mata_uang' => $mata_uang,
			'matauang' => $matauang,
		];
        $this->template->set('results', $data);
        $this->template->title('Purchase Order');
        $this->template->render('Add');

    }
	public function edit()
    {
		$id = $this->uri->segment(3);
		$id_data = $this->uri->segment(4);
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$aktif = 'active';
		$deleted = '0';
		$head   = $this->db->query("SELECT * FROM tr_purchase_order  WHERE no_po = '$id' ")->result();
		$hutang = $this->db->query("SELECT * FROM tr_incoming  WHERE id_data = '$id_data' ")->result();
		$comp	= $this->db->query("select a.*, b.nominal as nominal_harga FROM ms_compotition as a inner join child_history_lme as b on b.id_compotition=a.id_compotition where a.deleted='0' and b.status='0' ")->result();
		$detail = $this->db->query("SELECT * FROM dt_trans_po  WHERE no_po = '$id' ")->result_array();
		$supplier = $data = $this->db->query("SELECT a.* FROM master_supplier as a INNER JOIN dt_trans_pr as b on b.suplier = a.id_suplier INNER JOIN tr_purchase_request as c on b.no_pr = c.no_pr WHERE c.status = '2' GROUP BY b.suplier ")->result();
		$customers = $this->Pr_model->get_data('master_customers','deleted',$deleted);
		$karyawan = $this->Pr_model->get_data('ms_karyawan','deleted',$deleted);
		$mata_uang = $this->Pr_model->get_data('mata_uang','deleted'.$deleted);
		$matauang = $this->db->get_where('matauang')->result();
		$data = [
			'head' => $head,
			'comp' => $comp,
			'detail' => $detail,
			'supplier' => $supplier,
			'customers' => $customers,
			'karyawan' => $karyawan,
			'mata_uang' => $mata_uang,
			'matauang' => $matauang,
			'hutang' => $hutang,
		];
        $this->template->set('results', $data);
        $this->template->title('Purchase Order');
        $this->template->render('Edit');

    }
	
	
    public function SavePembayaran(){
		
		
        
		$session = $this->session->userdata('app_session');
		$Tgl_Invoice        = $this->input->post('tgl_bayar');
		
		$data_session 	    = $this->session->userdata; 
		$kd_bayar 			= $this->Pr_model->generate_nopn($Tgl_Invoice);
		
	    if(!empty($this->input->post('bank'))){
            $bank = explode('|',$this->input->post('bank'));
            $kd_bank = $bank[0];
            $nmbank = $bank[1];
        }
		// print_r($kd_bank);
		// exit;
	    if($this->input->post('matauang')=='idr'){
		$kurs = 1 ; 
		}elseif($this->input->post('matauang')=='usd'){
		$kurs = $this->input->post('nominal_kurs'); 
		}
		
		
		
		$idsupplier = $this->input->post('id_suplier');
		
		$supplier =  $this->db->query("SELECT * FROM master_supplier WHERE id_suplier = '$idsupplier'")->row();
	    $nmsupplier	= $supplier->name_suplier;

	    $hutang	= str_replace(",","",$this->input->post('total_ap_idr'));
		$bayar  = str_replace(",","",$this->input->post('total_bayar'))*$kurs;

		$selisih = $hutang - $bayar;
		
		// print_r($bayar);
		// exit;
		
		$data = array(
						'no_po'=>$this->input->post('no_po'),
						'kd_pembayaran'=>$kd_bayar,
						'supplier'=>$this->input->post('id_suplier'),
						'tgl_po'=>$this->input->post('tanggal'),
						'tgl_pembayaran'=>$this->input->post('tanggal_bayar'),
						'kurs_bayar'=>$this->input->post('nominal_kurs'),						
						'jumlah_hutang'=>str_replace(",","",$this->input->post('total_ap')),
						'jumlah_hutang_idr'=>str_replace(",","",$this->input->post('total_ap_idr')),
						'jumlah_pembayaran'=>str_replace(",","",$this->input->post('total_bayar')),
						'jumlah_pembayaran_idr'=>str_replace(",","",$this->input->post('total_bayar'))*$kurs,
						'kd_bank'=>$kd_bank,
						'created_by'    => $session['id_user'],
			            'created_on'=> date('Y-m-d H:i:s'),
						'no_account'=>$this->input->post('bank'),
						'selisih'=>$selisih,
						'keterangan'=>$this->input->post('ket_bayar'),
						'nama_supplier'=>$nmsupplier,
						'id_data'=>$this->input->post('id_data'),
						'id_incoming'=>$this->input->post('id_incoming'),
						'mata_uang'=>$this->input->post('matauang'),
					);
					
		
						
		$this->db->insert('tr_po_payment',$data);
		
		$no_po  = $this->input->post('no_po');
		$jmlbyr = str_replace(",","",$this->input->post('total_bayar'));

		$id_data  = $this->input->post('id_data');
		$jmlbyridr = str_replace(",","",$this->input->post('total_bayar'))*$kurs;

		$Qry_Update_po	 = "UPDATE tr_purchase_order SET total_bayar=total_bayar + $jmlbyr WHERE no_po='$no_po'";
		$this->db->query($Qry_Update_po);

		$Qry_Update_ic	 = "UPDATE tr_incoming SET bayar_kurs=bayar_kurs + $jmlbyr,bayar_idr=bayar_idr + $jmlbyridr, status_bayar='CLS' WHERE id_data='$id_data'";
		$this->db->query($Qry_Update_ic);
		
		              
						
					
	    if($this->db->trans_status() === FALSE){
			 $this->db->trans_rollback(); 
			 $Arr_Return		= array(
					'status'		=> 2, 
					'pesan'			=> 'Save Process Failed. Please Try Again...' 
			   );
		}else{
			 $this->db->trans_commit();
			 $Arr_Return		= array(
				'status'		=> 1,
				'pesan'			=> 'Save Process Success. '
		   );
		}
		echo json_encode($Arr_Return);
		
	
	}

	function appr_jurnal(){
		
		
		
	    
        $kd_bayar   = $this->uri->segment(3);
        $session = $this->session->userdata('app_session');

		$data_bayar =  $this->db->query("SELECT * FROM tr_po_payment WHERE kd_pembayaran = '$kd_bayar' ")->row();

		$tgl_byr 	= $data_bayar->tgl_pembayaran;
		$kd_invoice    	= $data_bayar->no_invoice; 
		$kd_bank 	= $data_bayar->kd_bank;
		$jenis_pph 	= $data_bayar->jenis_pph;
		$nama	= $data_bayar->nm_customer;
		$jmlpph   =$data_bayar->total_pph_idr;
		
       $id_cust =  $this->db->query("SELECT * FROM master_customer WHERE name_customer = '$nama'")->row();
	   $idcust  = $id_cust->id_customer;
		
	   
		
     				$No_Inv  = $kd_bayar;
					$Tgl_Inv = $tgl_byr; 
					$Bln 			= substr($Tgl_Inv,6,2);
					$Thn 			= substr($Tgl_Inv,0,4);
					$bulan_bayar = date("n",strtotime($Tgl_Inv));
					$tahun_bayar = date("Y",strtotime($Tgl_Inv));
                    $keterangan_byr  = $data_bayar->keterangan; 
					$jumlah_total    = $data_bayar->jumlah_pembayaran_idr; 
					$jumlah_terima   = $data_bayar->jumlah_bank_idr; 
					$biaya_admin     = $data_bayar->biaya_admin_idr;
                    $biaya_lain     = $data_bayar->biaya_pph_idr;	
                    $deposit         = $data_bayar->lebih_bayar;						
                    $jenis_reff      = $kd_bayar;
					$no_reff         = $kd_bayar;
        				## NOMOR JV ##
        				$Nomor_BUM				= $this->Jurnal_model->get_Nomor_Jurnal_BUM('101',$Tgl_Inv);

						//print_r($Nomor_BUM);
						//exit;


        			     //$Keterangan_INV		    = 'PENERIMAAN MULTI INVOICE A/N '.$nama.' INV NO. '.$No_Inv.
						//' Keterangan :'.$ket_invoice.', Catatan :'.$notes.', No Reff:'.$noreff.', No Pembayaran:'.$kd_pn;

        				$Keterangan_INV		    = 'PENERIMAAN MULTI INVOICE A/N '.$nama.' INV NO. '.$No_Inv.' Keterangan :'.$keterangan_byr;

						$dataJARH = array(
          					'nomor' 	    	=> $Nomor_BUM,
							'kd_pembayaran'    	=> $kd_pembayaran,
          					'tgl'	         	=> $Tgl_Inv,
          					'jml'	            => $jumlah_total,
          					'kdcab'				=> '101',
          					'jenis_reff'		=> $jenis_reff,
							'no_reff'		    => $no_reff,
							'customer'		    => $nama,
							'terima_dari'		=> '-',
							'jenis_ar'		    => 'V',
     						'note'				=> $Keterangan_INV,
        					'valid'				=> $session['id_user'],
          					'tgl_valid'			=> $Tgl_Inv,
							'user_id'			=> $session['id_user'],
							'tgl_invoice'	    => $Tgl_Inv,
          					'ho_valid'			=> '',
							'batal'			    => '0'
          				);

        				$det_Jurnal				= array();
        				$det_Jurnal[]			= array(
        					  'nomor'         => $Nomor_BUM,
        					  'tanggal'       => $Tgl_Inv,
        					  'tipe'          => 'BUM',
        					  'no_perkiraan'  => $kd_bank,
        					  'keterangan'    => $Keterangan_INV,
        					  'no_reff'       => $No_Inv,
        					  'debet'         => $jumlah_terima,
        					  'kredit'        => 0

        				);

						if($biaya_admin != 0){
        				$det_Jurnal[]			= array(
        					  'nomor'         => $Nomor_BUM,
        					  'tanggal'       => $Tgl_Inv,
        					  'tipe'          => 'BUM',
        					  'no_perkiraan'  => '7205-01-01',
        					  'keterangan'    => $Keterangan_INV,
        					  'no_reff'       => $No_Inv, 
        					  'debet'         => $biaya_admin,
        					  'kredit'        => 0

        				);
						}
						
						if($deposit != 0){
        				$det_Jurnal[]			= array(
        					  'nomor'         => $Nomor_BUM,
        					  'tanggal'       => $Tgl_Inv,
        					  'tipe'          => 'BUM',
        					  'no_perkiraan'  => '2109-02-01',
        					  'keterangan'    => $Keterangan_INV,
        					  'no_reff'       => $No_Inv, 
        					  'debet'         => $deposit,
        					  'kredit'        => 0

        				);
						}

					 $data_jurnal = $this->db->query("SELECT * FROM tr_invoice_payment_detail WHERE kd_pembayaran = '$kd_bayar' ")->result();

			          foreach($data_jurnal as $jr){
						$jmlbayar   =$jr->total_bayar_idr;
						$invoice2    =$jr->no_invoice;
						
						
						if($biaya_lain != 0){
        				$det_Jurnal[]			  = array(
      					  'nomor'         => $Nomor_BUM,
      					  'tanggal'       => $Tgl_Inv,
      					  'tipe'          => 'BUM',
      					  'no_perkiraan'  => $jenis_pph,
      					  'keterangan'    => $Keterangan_INV,
      					  'no_reff'       => $No_Inv,
      					  'debet'         => $jmlpph,
      					  'kredit'        => 0
      				    );
						}

						$det_Jurnal[]			  = array( 
      					  'nomor'         => $Nomor_BUM,
      					  'tanggal'       => $Tgl_Inv,
      					  'tipe'          => 'BUM', 
      					  'no_perkiraan'  => '1102-01-01',
      					  'keterangan'    => $Keterangan_INV,
      					  'no_reff'       => $invoice2,
      					  'debet'         => 0,
      					  'kredit'        => $jmlbayar,
      				    );

					  }


        				## INSERT JURNAL ##
        				$this->db->insert(DBACC.'.JARH',$dataJARH);
        				$this->db->insert_batch(DBACC.'.jurnal',$det_Jurnal);

        				## UPDATE AR ##
			            $Query_AR	= "UPDATE ".DBACC.".ar SET kredit=kredit + ".$jumlah_total.", saldo_akhir=saldo_akhir - ".$jumlah_total." WHERE  no_invoice='".$No_Inv."' AND thn='$tahun_bayar' AND bln='$bulan_bayar'";
			            $this->db->query($Query_AR);

        				$Qry_Update_Cabang_acc	 = "UPDATE ".DBACC.".pastibisa_tb_cabang SET nobum=nobum + 1 WHERE nocab='101'";
        				$this->db->query($Qry_Update_Cabang_acc);

    					//PROSES JURNAL

						$data_jr = $this->db->query("SELECT * FROM tr_invoice_payment_detail WHERE kd_pembayaran = '$kd_bayar' ")->result();

						foreach($data_jr as $val){
						$jml   =$val->total_bayar_idr;
						$inv   =$val->no_invoice;

						$Ket_INV		    = 'PENERIMAAN MULTI INVOICE A/N '.$nama.' INV NO. '.$inv.' Keterangan :'.$keterangan_byr;


						$datapiutang = array(
							'tipe'       	 => 'BUM',
							'nomor'       	 => $Nomor_BUM, 
							'tanggal'        => $Tgl_Inv,
							'no_perkiraan'  => '1103-01-01',
        					'keterangan'    => $Ket_INV,
        					'no_reff'       => $inv,
        					'debet'         => 0,
							'kredit'         => $jml,
							'id_supplier'     => $idcust,
							'nama_supplier'   => $nama,

							);



					    $idso=$this->db->insert('tr_kartu_piutang',$datapiutang);  
 
						}	
						
						$Qry  = "UPDATE tr_invoice_payment SET status_jurnal='1' WHERE kd_pembayaran='$kd_bayar'";
        	            $this->db->query($Qry);


                        $this->print_penerimaan_fix();			 			
	
	
	}
	
	 public function approval_bayar()
    {
		$id = $this->uri->segment(3);
		$id_data = $this->uri->segment(4);
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$aktif = 'active';
		$deleted = '0';
		$head   = $this->db->query("SELECT * FROM tr_purchase_order  WHERE no_po = '$id' ")->result();
		$hutang = $this->db->query("SELECT * FROM tr_incoming  WHERE id_data = '$id_data' ")->result();
		$comp	= $this->db->query("select a.*, b.nominal as nominal_harga FROM ms_compotition as a inner join child_history_lme as b on b.id_compotition=a.id_compotition where a.deleted='0' and b.status='0' ")->result();
		$detail = $this->db->query("SELECT * FROM dt_trans_po  WHERE no_po = '$id' ")->result_array();
		$supplier = $data = $this->db->query("SELECT a.* FROM master_supplier as a INNER JOIN dt_trans_pr as b on b.suplier = a.id_suplier INNER JOIN tr_purchase_request as c on b.no_pr = c.no_pr WHERE c.status = '2' GROUP BY b.suplier ")->result();
		$customers = $this->Pr_model->get_data('master_customers','deleted',$deleted);
		$karyawan = $this->Pr_model->get_data('ms_karyawan','deleted',$deleted);
		$mata_uang = $this->Pr_model->get_data('mata_uang','deleted'.$deleted);
		$matauang = $this->db->get_where('matauang')->result();
		$data = [
			'head' => $head,
			'comp' => $comp,
			'detail' => $detail,
			'supplier' => $supplier,
			'customers' => $customers,
			'karyawan' => $karyawan,
			'mata_uang' => $mata_uang,
			'matauang' => $matauang,
			'hutang' => $hutang,
		];
        $this->template->set('results', $data);
        $this->template->title('Purchase Order');
        $this->template->render('approval_bayar');

    }

	
	 public function SaveApproval(){
		
		// print_r($this->input->post());
		// exit;
        
		$session = $this->session->userdata('app_session');
		$data_session 	    = $this->session->userdata; 
		

		$id_data  = $this->input->post('id_data');
		$Qry_Update_ic	 = "UPDATE tr_incoming SET approve_bayar='1' WHERE id_data='$id_data'";
		$this->db->query($Qry_Update_ic);
		
		              
						
					
	    if($this->db->trans_status() === FALSE){
			 $this->db->trans_rollback(); 
			 $Arr_Return		= array(
					'status'		=> 2, 
					'pesan'			=> 'Save Process Failed. Please Try Again...' 
			   );
		}else{
			 $this->db->trans_commit();
			 $Arr_Return		= array(
				'status'		=> 1,
				'pesan'			=> 'Save Process Success. '
		   );
		}
		echo json_encode($Arr_Return);
		
	
	}
	
	 public function SaveReject(){
		
		
        
		$session = $this->session->userdata('app_session');
		$data_session 	    = $this->session->userdata; 
		

		$id_data  = $this->input->post('id_data');
		$Qry_Update_ic	 = "UPDATE tr_incoming SET rencana_bayar_idr= 0, request_bayar='0' WHERE id_data='$id_data'";
		$this->db->query($Qry_Update_ic);
		
		              
						
					
	    if($this->db->trans_status() === FALSE){
			 $this->db->trans_rollback(); 
			 $Arr_Return		= array(
					'status'		=> 2, 
					'pesan'			=> 'Save Process Failed. Please Try Again...' 
			   );
		}else{
			 $this->db->trans_commit();
			 $Arr_Return		= array(
				'status'		=> 1,
				'pesan'			=> 'Save Process Success. '
		   );
		}
		echo json_encode($Arr_Return);
		
	
	}
	
	public function request_bayar()
    {
		$id = $this->uri->segment(3);
		$id_data = $this->uri->segment(4);
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$aktif = 'active';
		$deleted = '0';
		$head   = $this->db->query("SELECT * FROM tr_purchase_order  WHERE no_po = '$id' ")->result();
		$hutang = $this->db->query("SELECT * FROM tr_incoming  WHERE id_data = '$id_data' ")->result();
		$comp	= $this->db->query("select a.*, b.nominal as nominal_harga FROM ms_compotition as a inner join child_history_lme as b on b.id_compotition=a.id_compotition where a.deleted='0' and b.status='0' ")->result();
		$detail = $this->db->query("SELECT * FROM dt_trans_po  WHERE no_po = '$id' ")->result_array();
		$supplier = $data = $this->db->query("SELECT a.* FROM master_supplier as a INNER JOIN dt_trans_pr as b on b.suplier = a.id_suplier INNER JOIN tr_purchase_request as c on b.no_pr = c.no_pr WHERE c.status = '2' GROUP BY b.suplier ")->result();
		$customers = $this->Pr_model->get_data('master_customers','deleted',$deleted);
		$karyawan = $this->Pr_model->get_data('ms_karyawan','deleted',$deleted);
		$mata_uang = $this->Pr_model->get_data('mata_uang','deleted'.$deleted);
		$matauang = $this->db->get_where('matauang')->result();
		$data = [
			'head' => $head,
			'comp' => $comp,
			'detail' => $detail,
			'supplier' => $supplier,
			'customers' => $customers,
			'karyawan' => $karyawan,
			'mata_uang' => $mata_uang,
			'matauang' => $matauang,
			'hutang' => $hutang,
		];
        $this->template->set('results', $data);
        $this->template->title('Request Pembayaran');
        $this->template->render('request_bayar');

    }
	
	
	
	public function request_print()
    {
		$id = $this->uri->segment(3);
		$id_data = $this->uri->segment(4);
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$aktif = 'active';
		$deleted = '0';
		$head   = $this->db->query("SELECT * FROM tr_purchase_order  WHERE no_po = '$id' ")->result();
		$incoming = $this->db->query("SELECT * FROM tr_incoming  WHERE id_data = '$id_data' ")->result();
		$hutang = $this->db->query("SELECT * FROM tr_incoming  WHERE id_data = '$id_data' ")->result();
		$comp	= $this->db->query("select a.*, b.nominal as nominal_harga FROM ms_compotition as a inner join child_history_lme as b on b.id_compotition=a.id_compotition where a.deleted='0' and b.status='0' ")->result();
		$detail = $this->db->query("SELECT * FROM dt_trans_po  WHERE no_po = '$id' ")->result_array();
		$supplier = $data = $this->db->query("SELECT a.* FROM master_supplier as a INNER JOIN dt_trans_pr as b on b.suplier = a.id_suplier INNER JOIN tr_purchase_request as c on b.no_pr = c.no_pr WHERE c.status = '2' GROUP BY b.suplier ")->result();
		$customers = $this->Pr_model->get_data('master_customers','deleted',$deleted);
		$karyawan = $this->Pr_model->get_data('ms_karyawan','deleted',$deleted);
		$mata_uang = $this->Pr_model->get_data('mata_uang','deleted'.$deleted);
		$matauang = $this->db->get_where('matauang')->result();
		$data = [
			'head' => $head,
			'comp' => $comp,
			'detail' => $incoming,
			'supplier' => $supplier,
			'customers' => $customers,
			'karyawan' => $karyawan,
			'mata_uang' => $mata_uang,
			'matauang' => $matauang,
			'hutang' => $hutang,
		];
        $this->load->view('request_print',$data);

    }


	
	 public function SaveRequest(){
		
		// print_r($this->input->post());
		// exit;
        
		$session = $this->session->userdata('app_session');
		$data_session 	    = $this->session->userdata; 
		

		$id_data  = $this->input->post('id_data');
		$tgl  = $this->input->post('tanggal_request');
		$jmlbyridr = str_replace(",","",$this->input->post('total_bayar'));
		$kurs = str_replace(",","",$this->input->post('nominal_kurs'));
		$Qry_Update_ic	 = "UPDATE tr_incoming SET kurs_request=$kurs, rencana_bayar_idr=$jmlbyridr, request_bayar = '1', tgl_request_bayar='$tgl' WHERE id_data='$id_data'";
		$this->db->query($Qry_Update_ic);
		
		              
						
					
	    if($this->db->trans_status() === FALSE){
			 $this->db->trans_rollback(); 
			 $Arr_Return		= array(
					'status'		=> 2, 
					'pesan'			=> 'Save Process Failed. Please Try Again...' 
			   );
		}else{
			 $this->db->trans_commit();
			 $Arr_Return		= array(
				'status'		=> 1,
				'pesan'			=> 'Save Process Success. '
		   );
		}
		echo json_encode($Arr_Return);
		
	
	}


}
	


