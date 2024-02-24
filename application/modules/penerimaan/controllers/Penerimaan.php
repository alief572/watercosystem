<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penerimaan extends Admin_Controller {
	
	 //Permission

    protected $viewPermission   = "Penerimaan.View"; 
    protected $addPermission    = "Penerimaan.Add";
    protected $managePermission = "Penerimaan.Manage";
    protected $deletePermission = "Penerimaan.Delete";
	
	 public function __construct()
    {
        parent::__construct();
        $this->load->library(array('Mpdf', 'upload', 'Image_lib'));
       	$this->load->model('Wt_invoicing/Wt_invoicing_model');
	    $this->load->model('Penerimaan/penerimaan_model'); 
		$this->load->model('Jurnal_nomor/Acc_model');
		$this->load->model('Jurnal_nomor/Jurnal_model');
        $this->template->title('Penerimaan Invoice');
        $this->template->page_icon('fa fa-building-o'); 
        date_default_timezone_set('Asia/Bangkok');
    }
	
	
	public function index(){        	   
			$this->template->page_icon('fa fa-list');			
			$data = $this->penerimaan_model->get_data_pn();			
			$this->template->set('results', $data);
			$this->template->title('Indeks Of Receivable');
			$this->template->render('list_payment');
	}
	
	public function index_np(){        	   
			$this->template->page_icon('fa fa-list');			
			$data = $this->penerimaan_model->get_data_pn_np();			
			$this->template->set('results', $data);
			$this->template->title('Indeks Of Receivable');
			$this->template->render('list_payment_np');
	}
	
	public function penerimaan_buktipotong($kd_bayar){
		$noinvoice=$this->db->query("SELECT no_invoice FROM tr_invoice_payment_detail WHERE kd_pembayaran = '$kd_bayar' ")->result();
		$buktipotong=$this->db->query("SELECT * FROM tr_invoice_bukti_potong WHERE kd_pembayaran = '$kd_bayar' ")->result();
		$data = array(
			'kodebayar' => $kd_bayar,
			'noinvoice'=>$noinvoice,
			'buktipotong'=>$buktipotong
		);		
		$this->load->view('form_buktipotong', $data);
	}
	
	public function save_buktipotong(){
		$data = array(
					'no_invoice'=>$this->input->post('no_invoice'),
					'tgl_terima'=>$this->input->post('tgl_terima'),
					'kd_pembayaran'=>$this->input->post('kd_pembayaran'),
					'no_bukti_potong'=>$this->input->post('no_bukti_potong'),
					'created_by'=> $this->auth->user_id(),
					'created_date'=> date('Y-m-d H:i:s'),
				);
		$this->db->insert('tr_invoice_bukti_potong',$data);
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
	
	public function create_new(){
		$this->auth->restrict($this->viewPermission);
        	   
			$this->template->page_icon('fa fa-list');			
			$data = '0';			
			$this->template->set('results', $data);
			$this->template->title('Indeks Of Invoice');
			$this->template->render('invoice_siap_terima');
	} 
	
	public function server_side_inv(){
		$this->penerimaan_model->get_data_json_inv();
	}
	public function create_penerimaan(){
		$this->invoicing_model->list_top();
	}
	
	public function server_side_payment(){
		$this->penerimaan_model->get_data_json_payment(); 
	}
	public function server_side_top(){
		$this->invoicing_model->get_data_json_top();
	}
	
	public function modal_detail_invoice(){ 
		$this->penerimaan_model->modal_detail_invoice($this->uri->segment(3));
	}
	
	public function modal_detail_invoice_np(){ 
		$this->penerimaan_model->modal_detail_invoice_np($this->uri->segment(3));
	}
	
	public function view_penerimaan(){
		$kd_bayar = $this->uri->segment(3);	
        $bank1			 = $this->Jurnal_model->get_Coa_Bank_Aja('101');		
		$data = array(
		    'datbank' => $bank1,
			'kodebayar' => $kd_bayar,		
		);		
		$this->load->view('view_penerimaan', $data);
	}
	
	public function save_penerimaan(){
		
		// print_r($this->input->post());
		// exit;
		 $session = $this->session->userdata('app_session');
		$Tgl_Invoice        = $this->input->post('tgl_bayar');
		
		$data_session 	    = $this->session->userdata; 
		$kd_bayar 			= $this->penerimaan_model->generate_nopn($Tgl_Invoice);
		
	    if(!empty($this->input->post('bank'))){
            // $bank = explode('|',$this->input->post('bank'));
            // $kd_bank = $bank[0];
            // $nmbank = $bank[1];
			
			$kd_bank  = $this->input->post('bank');
        }
		// print_r($kd_bank);
		// exit;
		$kurs = $this->input->post('kurs'); 
		$jumlah_total_idr = str_replace(",","",$this->input->post('total_bank'))*$kurs;
		
		$unlocated =  str_replace(",","",$this->input->post('total_bank'));
		$id_unlocated = $this->input->post('id_unlocated'); 
		
		$lebihbayar =  str_replace(",","",$this->input->post('pakai_lebih_bayar'));
		$id_lebihbayar = $this->input->post('id_lebihbayar');
		
		$idcustomer = $this->input->post('customer');
		
		$customer =  $this->db->query("SELECT * FROM master_customers WHERE id_customer = '$idcustomer'")->row();
	   
	    $idcs   = $customer->id_customer;
		$nmcs	= html_escape($customer->name_customer);
		
		
		
		$data = array(
						'no_invoice'=>$this->input->post('no_invoice'),
						'kd_pembayaran'=>$kd_bayar,
						'jenis_reff'=>'-',
						'no_reff'=>'-',
						'tgl_pembayaran'=>$this->input->post('tgl_bayar'),
						'kurs_bayar'=>$this->input->post('kurs'),
						'jumlah_piutang'=>str_replace(",","",$this->input->post('total_invoice')),
						'jumlah_piutang_idr'=>str_replace(",","",$this->input->post('total_invoice'))*$kurs,
						'jumlah_bank'=>str_replace(",","",$this->input->post('total_bank')),
						'jumlah_bank_idr'=>str_replace(",","",$this->input->post('total_bank'))*$kurs,
						'jumlah_pembayaran'=>str_replace(",","",$this->input->post('total_terima')),
						'jumlah_pembayaran_idr'=>str_replace(",","",$this->input->post('total_terima'))*$kurs,
						'kd_bank'=>$kd_bank,
						'biaya_admin'=>str_replace(",","",$this->input->post('biaya_adm')),
						'biaya_admin_idr'=>str_replace(",","",$this->input->post('biaya_adm'))*$kurs,
						'biaya_pph'=>str_replace(",","",$this->input->post('biaya_pph')),
						'biaya_pph_idr'=>str_replace(",","",$this->input->post('biaya_pph'))*$kurs,
						'created_by'    => $session['id_user'],
			            'created_on'=> date('Y-m-d H:i:s'),
						'jenis_pph'=>$this->input->post('jenis_pph'),
						'no_account'=>'-',
						'selisih'=>'-',
						'keterangan'=>$this->input->post('ket_bayar'),
						'nm_customer'=>$nmcs,
						'lebih_bayar'=>str_replace(",","",$this->input->post('pakai_lebih_bayar')),
						'tambah_lebih_bayar'=>str_replace(",","",$this->input->post('tambah_lebih_bayar')),
					);
					
		
						
		$this->db->insert('tr_invoice_payment',$data);
		
		
		for($i=0;$i < count($this->input->post('kode_produk'));$i++){
            $datadetail = array(
                'kd_pembayaran'     => $kd_bayar,
                'no_invoice'        => $this->input->post('kode_produk')[$i],
                'nm_customer'       => $this->input->post('nm_customer2')[$i],
                'total_invoice_idr'    => str_replace(",","",$this->input->post('sisa_invoice')[$i]),
				'total_bayar_idr'     => str_replace(",","",$this->input->post('jml_bayar')[$i]),
				'sisa_invoice_idr'    => str_replace(",","",$this->input->post('sisa_invoice')[$i]) - str_replace(",","",$this->input->post('jml_bayar')[$i]),
				'total_pph_idr'     => str_replace(",","",$this->input->post('pph')[$i]),
                'created_on'    => date('Y-m-d H:i:s'),
                'created_by'    => $session['id_user']
                );
             $this->db->insert('tr_invoice_payment_detail',$datadetail);
             //Update QTY_AVL
             $invoice = $this->input->post('kode_produk')[$i];
             $jmlbyr  = str_replace(",","",$this->input->post('jml_bayar')[$i]);			 
			 $Qry_Update	 = "UPDATE tr_invoice SET total_bayar_idr=total_bayar_idr + $jmlbyr, sisa_invoice_idr=sisa_invoice_idr - $jmlbyr WHERE no_invoice='$invoice'";
        	 $this->db->query($Qry_Update);


			 $so  = $this->db->query("SELECT * FROM tr_invoice WHERE no_invoice='$invoice'")->row();
			 $no_so = $so->no_so;

			 $Qry_Update_so	 = "UPDATE tr_sales_order SET total_bayar_so=total_bayar_so + $jmlbyr WHERE no_so='$no_so'";
        	 $this->db->query($Qry_Update_so);


        }
		               $tambah_lebih_bayar = $this->input->post('tambah_lebih_bayar');
					
					
		               if($tambah_lebih_bayar != 0){
						   
						 		
						   
        				$data_lebih_bayar[]			= array(
        					  'tgl'                => $this->input->post('tgl_bayar'),
        					  'keterangan'         => $nmcs,
        					  'totalpenerimaan'    => str_replace(",","",$this->input->post('tambah_lebih_bayar')),
        					  'saldo'              => str_replace(",","",$this->input->post('tambah_lebih_bayar')),
        					  'created_on'         => date('Y-m-d H:i:s'),
                              'created_by'         => $session['id_user'],
        					  'bank'         	  => $this->input->post('bank')       					  

        				);
						
						
						$this->db->insert_batch('tr_unlocated_bank',$data_lebih_bayar);
						
					$Nomor_BUM				= $this->Jurnal_model->get_Nomor_Jurnal_BUM('101',$Tgl_Invoice);
						
					// $Nomor_JV = $this->Jurnal_model->get_Nomor_Jurnal_Sales('101', $Tgl_Invoice);
					$Keterangan_INV1 = 'LEBIH BAYAR ' .$nmcs;
					$Jml_Ttl  = str_replace(",","",$this->input->post('tambah_lebih_bayar'));
					 $Bln = substr($Tgl_Invoice, 5, 2);
                     $Thn = substr($Tgl_Invoice, 0, 4);
					 
					// $dataJVhead = array(
										// 'nomor' => $Nomor_JV, 
										// 'tgl' => $Tgl_Invoice,
										// 'jml' => $Jml_Ttl, 
										// 'koreksi_no' => '-', 
										// 'kdcab' => '101', 
										// 'jenis' => 'JV', 
										// 'keterangan' => $Keterangan_INV1, 
										// 'bulan' => $Bln, 
										// 'tahun' => $Thn, 
										// 'user_id' => $session['id_user'], 
										// 'memo' => '', 
										// 'tgl_jvkoreksi' => $Tgl_Invoice, 
										// 'ho_valid' => ''
										// );
										
						$dataJARH2 = array(
          					'nomor' 	    	=> $Nomor_BUM,
							'kd_pembayaran'    	=> $kd_bayar,
          					'tgl'	         	=> $Tgl_Invoice,
          					'jml'	            => $Jml_Ttl,
          					'kdcab'				=> '101',
          					'jenis_reff'		=> $kd_bayar,
							'no_reff'		    => $kd_bayar,
							'customer'		    => $nmcs,
							'terima_dari'		=> '-',
							'jenis_ar'		    => 'V',
     						'note'				=> $Keterangan_INV1,
        					'valid'				=> $session['id_user'],
          					'tgl_valid'			=> $Tgl_Invoice,
							'user_id'			=> $session['id_user'],
							'tgl_invoice'	    => $Tgl_Invoice,
          					'ho_valid'			=> '',
							'batal'			    => '0'
          				);
										
                        $det_Jurnal_lebih  = array();
					    $det_Jurnal_lebih[]= array(
      					  'nomor'         => $Nomor_BUM,
      					  'tanggal'       => $Tgl_Invoice,
      					  'tipe'          => 'JV',
      					  'no_perkiraan'  => $kd_bank,
      					  'keterangan'    => $Keterangan_INV1,
      					  'no_reff'       => $kd_bayar,
      					  'debet'         => $Jml_Ttl,
      					  'kredit'        => 0
      				    );
						

						$det_Jurnal_lebih[] = array( 
      					  'nomor'         => $Nomor_BUM,
      					  'tanggal'       => $Tgl_Invoice,
      					  'tipe'          => 'JV',
      					  'no_perkiraan'  => '2109-02-01',
      					  'keterangan'    => $Keterangan_INV1,
      					  'no_reff'       => $kd_bayar,
      					  'debet'         => 0,
      					  'kredit'        => $Jml_Ttl
      				    );
					 
					
					   
					// $this->db->insert(DBACC.'.JARH',$dataJARH2);
        			// $this->db->insert_batch(DBACC.'.jurnal',$det_Jurnal_lebih);
					
					//$this->db->insert(DBACC.'.JARH',$dataJARH2);
        			//$this->db->insert_batch(DBACC.'.jurnal',$det_Jurnal_lebih);
					
					//$Qry_Update_Cabang_acc	 = "UPDATE ".DBACC.".pastibisa_tb_cabang SET nobum=nobum + 1 WHERE nocab='101'";
        			//$this->db->query($Qry_Update_Cabang_acc); 
						
					// $Qry_Update_Cabang_acc = "UPDATE ".DBACC.".pastibisa_tb_cabang SET nomorJC=nomorJC + 1 WHERE nocab='101'";
					// $this->db->query($Qry_Update_Cabang_acc);
								
		            }
		
		if($id_unlocated !=''){
		$Qry_Update2	 = "UPDATE tr_unlocated_bank SET saldo=saldo - $unlocated WHERE id='$id_unlocated'";
        	 $this->db->query($Qry_Update2);
	    }
			
        // elseif($id_lebihbayar !=''){			
		// $Qry_Update3	 = "UPDATE tr_lebihbayar_bank SET saldo=saldo - $lebihbayar WHERE id='$id_lebihbayar'";
        // 	 $this->db->query($Qry_Update3); 
		// } 
		
		
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

		$data_bayar =  $this->db->query("SELECT * FROM tr_invoice_payment WHERE kd_pembayaran = '$kd_bayar' ")->row();

		$tgl_byr 	= $data_bayar->tgl_pembayaran;
		$kd_invoice    	= $data_bayar->no_invoice; 
		$kd_bank 	= $data_bayar->kd_bank;
		$jenis_pph 	= $data_bayar->jenis_pph;
		$nama	= html_escape($data_bayar->nm_customer);
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
						



						// if ($jumlah_piutang2 > $pembayaran){

						// $det_Jurnal[]			  = array(
      					  // 'nomor'         => $Nomor_BUM,
      					  // 'tanggal'       => $Tgl_Inv,
      					  // 'tipe'          => 'BUM',
      					  // 'no_perkiraan'  => $no_account,
      					  // 'keterangan'    => $Keterangan_INV,
      					  // 'no_reff'       => $No_Inv,
      					  // 'debet'         => $selisih,
      					  // 'kredit'        => 0
      				    // );

						// }
						// else if ($jumlah_piutang2 < $pembayaran){
						// $det_Jurnal[]			  = array(
      					  // 'nomor'         => $Nomor_BUM,
      					  // 'tanggal'       => $Tgl_Inv,
      					  // 'tipe'          => 'BUM',
      					  // 'no_perkiraan'  => $no_account,
      					  // 'keterangan'    => $Keterangan_INV,
      					  // 'no_reff'       => $No_Inv,
      					  // 'debet'         => 0,
      					  // 'kredit'        => $selisih
      				    // );

						// }



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
	
	
	function print_penerimaan_fix(){
	  // $sroot 		= $_SERVER['DOCUMENT_ROOT'];
	  // include $sroot."/application/libraries/MPDF57/mpdf.php";
	  $data_session = $this->session->userdata;
	  $session      = $this->session->userdata('app_session');
	  
	  // print_r($session);
	  // exit;
	  
      $mpdf=new mPDF('utf-8','A5-L');
      $mpdf->SetImportUse();
	    
		$kd_bayar   = $this->uri->segment(3);
		$data_bayar =  $this->db->query("SELECT * FROM tr_invoice_payment WHERE kd_pembayaran = '$kd_bayar' ")->row();
		$coabank    =  $data_bayar->kd_bank;
		$coa        =  $this->db->query("SELECT * FROM ".DBACC.".coa_master WHERE no_perkiraan = '$coabank' ")->row();
	    
        $nomordoc   = html_escape($data_bayar->id_customer);
		$gethd = $this->db->query("SELECT * FROM ms_customers WHERE id_customer='$nomordoc'")->row();
		$tgl       = $gethd->tgl_invoice;
		$Jml_Ttl   = $gethd->total_invoice;
		$Id_klien     = $gethd->id_customer;
		$Nama_klien   = html_escape($gethd->nm_customer);
		$Bln 			= substr($tgl,5,2);
		$Thn 			= substr($tgl,0,4);
		
		$data_header = $this->db->query("SELECT * FROM tr_invoice_header WHERE no_invoice ='$nomordoc'")->row();
        $alamat_cust =  $this->db->query("SELECT * FROM master_customer WHERE id_customer = '$gethd->id_customer'")->row();
		$mso =  $this->db->query("SELECT * FROM mso_proses_header WHERE id_quotation = '$gethd->no_ipp'")->row();
		
		$quot =  $this->db->query("SELECT * FROM quotation_process WHERE id = '$gethd->no_ipp'")->row();
		
		$count = $this->db->query("SELECT COUNT(no_invoice) as total FROM tr_invoice_detail WHERE no_invoice ='$nomordoc'")->row();
		$count1= $count->total;
       
	   
        $total  = $this->invoicing_model->GetInvoiceHeader($nomordoc);
		$detail  = $this->invoicing_model->GetInvoiceDetail($nomordoc);

		$data['inv'] = $data_header;
		$data['quot'] = $quot;
		$data['total'] = $this->invoicing_model->GetInvoiceHeader($nomordoc);
		$data['results']  = $this->invoicing_model->GetInvoiceDetail($nomordoc);
		$data['user']  = $session['username'];
		$data['kodebayar'] = $kd_bayar;
		
		
		 $show = $this->load->view('penerimaan/print_penerimaan',$data,TRUE);
		

       

        $tglprint = date("d-m-Y H:i:s");
		$tglprint2 = date("d-m-Y");
		
		foreach($total as $val){
		$date = tgl_indo($val->tgl_invoice);//date('d-m-Y');
		$invoice  = $val->no_invoice;
		$so  = $val->so_number;
		$total2  = $val->total_invoice;
		$customer  = $val->nm_customer;
		$tagih  = $val->jenis_invoice;
		$persentase  = number_format($val->persentase);
		$persen      ='%';
		
		if($tagih=='TR-01'){
		$jenis_invoice1='DOWN PAYMENT OF ';
		$jenis_invoice=$jenis_invoice1.$persentase.$persen;
		}
		elseif($tagih=='TR-02'){
	    $jenis_invoice1='PAYMENT ';
		$jenis_invoice=$jenis_invoice1.$persentase.$persen;
		}
		else{
		$jenis_invoice='RETENSI';
		}
		
	    }
		
       
        $header = '
          <br>

        	<table width="100%" border="0"  style="font-size:7.5pt !important;max-height:100px;border-spacing:-1px">
			<tr>
  	      		<td width="8%" style="text-align: center;">
  	      			<img src="assets/images/logo.png" style="height: 40px;width: auto;">
  	      		</td>
  	      	</tr>
			</table>
			<br>
			<table width="100%" border="0"  style="font-size:7.5pt !important;max-height:100px;border-spacing:-1px">
			<tr>
  	      		<td style="text-align: center; font-weight: bold; font-size:12pt">
  	      			BUKTI UANG MASUK
  	      		</td>
  	      	</tr>
  	      	</table>
		  <br>
		  <br>
          <table border="0" width="100%">
            <tr><b>
                  <td width="15%" style="font-size:8pt !important;vertical-align:top"><b>Kode Penerimaan</b></td>
				 <td width="1%" style="font-size:8pt !important;vertical-align:top"><b>:</b></td>
				 <td width="35%" style="font-size:8pt !important;vertical-align:top"><b>' .@$kd_bayar.'</b></td>
				  <td width="15%" style="font-size:8pt !important;vertical-align:top"><b>Customer</b></td>
				 <td width="3%" style="font-size:8pt !important;vertical-align:top"><b>:</b></td>
				 <td width="35%" style="font-size:8pt !important;vertical-align:top"><b>' .@html_escape($gethd->name_customer).'</b></td>
		 </b> </tr>
		 <tr><b>
                 <<td width="10%"style="font-size:8pt !important;vertical-align:top"><b>Tgl Terima</b></td>
                 <td width="1%" style="font-size:8pt !important;vertical-align:top"><b>:</b></td>
				 <td width="35%" style="font-size:8pt !important;vertical-align:top"><b>' .@tgl_indo($data_bayar->tgl_pembayaran).'</b></td>
				 <td width="10%" style="font-size:8pt !important;vertical-align:top"><b></b></td> 
                 <td width="1%" style="font-size:8pt !important;vertical-align:top"><b></b></td>
				 <td width="35%" style="font-size:8pt !important;vertical-align:top"><b>' .@$alamat_cust->address_office.'</b></td>
				 
		 </b> </tr>
		  <tr><b> 
		         <td width="10%" style="font-size:8pt !important;vertical-align:top"><b>Bank</b></td>
				 <td width="1%" style="font-size:8pt !important;vertical-align:top"><b>:</b></td>
				 <td width="35%" style="font-size:8pt !important;vertical-align:top"><b>'.@$coa->nama.'</b></td>
				 <td width="10%" style="font-size:8pt !important;vertical-align:top"><b></b></td>
				 <td width="1%" style="font-size:8pt !important;vertical-align:top"><b></b></td>
				 <td width="35%" style="font-size:8pt !important;vertical-align:top"><b></b></td>
                
                 
		 </b> </tr> 
		    <tr><b>
                 <td width="10%" style="font-size:8pt !important;vertical-align:top"><b>Keterangan</b></td> 
                 <td width="1%" style="font-size:8pt !important;vertical-align:top"><b>:</b></td>
				 <td width="35%" style="font-size:8pt !important;vertical-align:top"><b>' .@$data_bayar->keterangan.'</b></td>
				 <td width="10%" style="font-size:8pt !important;vertical-align:top"><b></b></td>
                 <td width="1%" style="font-size:8pt !important;vertical-align:top"><b></b></td>
				 <td width="35%" style="font-size:8pt !important;vertical-align:top"><b></b></td>
				 
		 </b> </tr>
		 </table>
		    <br>
			
		  <hr> 
		  ';

        $this->mpdf->SetHTMLHeader($header,'0',true);
		
	    
        $this->mpdf->SetHTMLFooter('
        <hr>        
       	<div id="footer">
        <table>
            <tr><td>PT IDEFAB CIPTA - Printed By '.ucwords($session['username']).' On '.$tglprint.' </td></tr>
        </table>
        </div>
        ');
	    
       
         $this->mpdf->AddPageByArray([
                'orientation' => 'L',
                'margin-top' => 60,
                'margin-bottom' => 15,
                'margin-left' => 5,
                'margin-right' => 10,
                'margin-header' => 0,
                'margin-footer' => 0,
            ]);
        $this->mpdf->WriteHTML($show);
        $this->mpdf->Output();
    }

	
	public function unlocated(){ 

		$bank1			 = $this->Jurnal_model->get_Coa_Bank_Cabang('101');
		$pphpenjualan  	 = $this->Acc_model->combo_pph_penjualan(); 
		$datacoa  	     = $this->Acc_model->GetCoaCombo();
		$template  	     = $this->Acc_model->GetTemplate(); 
		$this->template->title('Penerimaan Unlocated');
		
				
		$this->template->set([
		  	'no_inv'  => $id,
			'datbank' => $bank1,
			'pphpenjualan'=> $pphpenjualan,
			'template'=> $template
		]);
		$this->template->render('create_unlocated');
	}
	public function lebihbayar(){ 

		$bank1			 = $this->Jurnal_model->get_Coa_Bank_Cabang('101');
		$pphpenjualan  	 = $this->Acc_model->combo_pph_penjualan(); 
		$datacoa  	     = $this->Acc_model->GetCoaCombo();
		$template  	     = $this->Acc_model->GetTemplate(); 
		$this->template->title('Penerimaan Lebih Bayar');
		
				
		$this->template->set([
		  	'no_inv'  => $id,
			'datbank' => $bank1,
			'pphpenjualan'=> $pphpenjualan,
			'template'=> $template
		]);
		$this->template->render('create_lebihbayar');
	}
    
	public function createunlocated(){ 

		$bank1			 = $this->Jurnal_model->get_Coa_Bank_Cabang('101');
		$pphpenjualan  	 = $this->Acc_model->combo_pph_penjualan(); 
		$datacoa  	     = $this->Acc_model->GetCoaCombo();
		$template  	     = $this->Acc_model->GetTemplate(); 
		$this->template->title('Penerimaan Unlocated');
		
				
		$this->template->set([
		  	//'no_inv'  => $id,
			'datbank' => $bank1,
			'pphpenjualan'=> $pphpenjualan,
			'template'=> $template
		]);
		$this->template->render('create_unlocated');
	}
	
	public function save_unlocated(){
		
		// print_r($this->input->post());
		// exit;
		 $session = $this->session->userdata('app_session');
	     $data_session 	    = $this->session->userdata;
		 
		
	    if(!empty($this->input->post('bank'))){
            $bank = explode('|',$this->input->post('bank'));
            $kd_bank = $bank[0];
            $nmbank = $bank[1];
        }
			
		
		for($i=0;$i < count($this->input->post('keterangan'));$i++){
            $datadetail = array(
                'tgl'               =>  $this->input->post('tanggal'),
                'keterangan'        => $this->input->post('keterangan')[$i],
                'bank'              => $this->input->post('bank'),
                'totalpenerimaan'   => $this->input->post('totalpenerimaan')[$i], 
				'saldo'             => $this->input->post('totalpenerimaan')[$i],
				'created_on'    => date('Y-m-d H:i:s'),
                'created_by'    => $session['id_user']
                );
             $this->db->insert('tr_unlocated_bank',$datadetail);
			 
			 
			 
			        $No_Inv  = $kd_bayar;
					$Tgl_Inv = $this->input->post('tanggal'); 
					$Bln 			= substr($Tgl_Inv,6,2);
					$Thn 			= substr($Tgl_Inv,0,4);
					$bulan_bayar = date("n",strtotime($Tgl_Inv));
					$tahun_bayar = date("Y",strtotime($Tgl_Inv));
                    $keterangan_byr  = $this->input->post('keterangan')[$i];
					$jumlah_total    = $this->input->post('totalpenerimaan')[$i];
						
                   $jenis_reff      = 'Deposit';
					$no_reff         = 'Deposit';
        				## NOMOR JV ##
        				$Nomor_BUM				= $this->Jurnal_model->get_Nomor_Jurnal_BUM('101',$Tgl_Inv);

						$Keterangan_INV		    = 'DEPOSIT CUSTOMER'.$keterangan_byr;

						$dataJARH = array(
          					'nomor' 	    	=> $Nomor_BUM,
							'kd_pembayaran'    	=> $kd_pembayaran,
          					'tgl'	         	=> $Tgl_Inv,
          					'jml'	            => $jumlah_total,
          					'kdcab'				=> '101',
          					'jenis_reff'		=> $jenis_reff,
							'no_reff'		    => $no_reff,
							'customer'		    => 'DEPOSIT CUSTOMER',
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

        				

					 
        				$det_Jurnal[]			  = array(
      					  'nomor'         => $Nomor_BUM,
      					  'tanggal'       => $Tgl_Inv,
      					  'tipe'          => 'BUM',
      					  'no_perkiraan'  => $kd_bank,
      					  'keterangan'    => $Keterangan_INV,
      					  'no_reff'       => 'DEPOSIT CUSTOMER',
      					  'debet'         => $jumlah_total,
      					  'kredit'        => 0
      				    );
						

						$det_Jurnal[]			  = array( 
      					  'nomor'         => $Nomor_BUM,
      					  'tanggal'       => $Tgl_Inv,
      					  'tipe'          => 'BUM', 
      					  'no_perkiraan'  => '2101-08-01',
      					  'keterangan'    => $Keterangan_INV,
      					  'no_reff'       => 'DEPOSIT CUSTOMER',
      					  'debet'         => 0,
      					  'kredit'        => $jumlah_total,
      				    );

					  


        				## INSERT JURNAL ##
        				$this->db->insert(DBACC.'.jarh',$dataJARH);
        				$this->db->insert_batch(DBACC.'.jurnal',$det_Jurnal);
						
						$Qry_Update_Cabang_acc	 = "UPDATE ".DBACC.".pastibisa_tb_cabang SET nobum=nobum + 1 WHERE nocab='101'";
        				$this->db->query($Qry_Update_Cabang_acc);

        			
             
        }
		
		
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
	
	public function TambahInvoice()
    {
		$customer = $this->uri->segment(3);
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$invoice = $this->db->query("SELECT * FROM tr_invoice WHERE id_customer ='$customer' AND sisa_invoice_idr >'0'")->result();        
		$data = [
			'detail' => $customer
		];
        $this->template->set('results', $data);
        $this->template->title('List Invoice');
        $this->template->render('invoice');

    }
	
	public function TambahInvoice_np()
    {
		$customer = $this->uri->segment(3);
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$invoice = $this->db->query("SELECT * FROM tr_invoice_np_header WHERE id_customer ='$customer' AND sisa_invoice_idr >'0'")->result();        
		$data = [
			'detail' => $customer
		];
        $this->template->set('results', $data);
        $this->template->title('List Invoice');
        $this->template->render('invoice_np');

    }
	
	public function TambahLebihBayar()
    {
		$customer = $this->uri->segment(3);
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		 $invoice = $this->db->query("SELECT * FROM tr_lebihbayar_bank WHERE saldo !=0 AND id_customer ='$customer'")->result();        
		$data = [
			'detail' => $customer
		];
        $this->template->set('results', $data);
        $this->template->title('List Invoice');
        $this->template->render('lebihbayar');

    }
	
	public function save_lebihbayar(){
		
		// print_r($this->input->post());
		// exit;
		 $session = $this->session->userdata('app_session');
	     $data_session 	    = $this->session->userdata;
		 
		
	    // if(!empty($this->input->post('bank'))){
            // $bank = explode('|',$this->input->post('bank'));
            // $kd_bank = $bank[0];
            // $nmbank = $bank[1];
        // }
			
		
		for($i=0;$i < count($this->input->post('tanggal'));$i++){
            $datadetail = array(
                'tgl'               =>  $this->input->post('tanggal'),
                'keterangan'        => $this->input->post('keterangan'),
                'bank'              => $this->input->post('bank'),
                'totalpenerimaan'   => $this->input->post('totalpenerimaan'),
				'saldo'             => $this->input->post('totalpenerimaan'),
				'created_on'    => date('Y-m-d H:i:s'),
                'created_by'    => $session['id_user']
                );
             $this->db->insert('tr_lebihbayar_bank',$datadetail);
             
        }
		
		
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
	
	public function jurnal_bum()
    {
        $this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-list');			
		$data = $this->penerimaan_model->get_data_pn_jurnal();			
		$this->template->set('results', $data);
        $this->template->title('Jurnal Penerimaan');
        $this->template->render('index_jurnal_penerimaan');
    }
	
	
	public function save_penerimaan_np(){
		
		// print_r($this->input->post());
		// exit;
		 $session = $this->session->userdata('app_session');
		$Tgl_Invoice        = $this->input->post('tgl_bayar');
		
		$data_session 	    = $this->session->userdata; 
		$kd_bayar 			= $this->penerimaan_model->generate_nopn_np($Tgl_Invoice);
		
	    if(!empty($this->input->post('bank'))){
            // $bank = explode('|',$this->input->post('bank'));
            // $kd_bank = $bank[0];
            // $nmbank = $bank[1];
			
			$kd_bank  = $this->input->post('bank');
        }
		// print_r($kd_bank);
		// exit;
		$kurs = $this->input->post('kurs'); 
		$jumlah_total_idr = str_replace(",","",$this->input->post('total_bank'))*$kurs;
		
		$unlocated =  str_replace(",","",$this->input->post('total_bank'));
		$id_unlocated = $this->input->post('id_unlocated'); 
		
		$lebihbayar =  str_replace(",","",$this->input->post('pakai_lebih_bayar'));
		$id_lebihbayar = $this->input->post('id_lebihbayar');
		
		$idcustomer = $this->input->post('customer');
		
		$customer =  $this->db->query("SELECT * FROM master_customers WHERE id_customer = '$idcustomer'")->row();
	   
	    $idcs   = $customer->id_customer;
		$nmcs	= html_escape($customer->name_customer);
		
		
		
		$data = array(
						'no_invoice'=>$this->input->post('no_invoice'),
						'kd_pembayaran'=>$kd_bayar,
						'jenis_reff'=>'-',
						'no_reff'=>'-',
						'tgl_pembayaran'=>$this->input->post('tgl_bayar'),
						'kurs_bayar'=>$this->input->post('kurs'),
						'jumlah_piutang'=>str_replace(",","",$this->input->post('total_invoice')),
						'jumlah_piutang_idr'=>str_replace(",","",$this->input->post('total_invoice'))*$kurs,
						'jumlah_bank'=>str_replace(",","",$this->input->post('total_bank')),
						'jumlah_bank_idr'=>str_replace(",","",$this->input->post('total_bank'))*$kurs,
						'jumlah_pembayaran'=>str_replace(",","",$this->input->post('total_terima')),
						'jumlah_pembayaran_idr'=>str_replace(",","",$this->input->post('total_terima'))*$kurs,
						'kd_bank'=>$kd_bank,
						'biaya_admin'=>str_replace(",","",$this->input->post('biaya_adm')),
						'biaya_admin_idr'=>str_replace(",","",$this->input->post('biaya_adm'))*$kurs,
						'biaya_pph'=>str_replace(",","",$this->input->post('biaya_pph')),
						'biaya_pph_idr'=>str_replace(",","",$this->input->post('biaya_pph'))*$kurs,
						'created_by'    => $session['id_user'],
			            'created_on'=> date('Y-m-d H:i:s'),
						'jenis_pph'=>$this->input->post('jenis_pph'),
						'no_account'=>'-',
						'selisih'=>'-',
						'keterangan'=>$this->input->post('ket_bayar'),
						'nm_customer'=>$nmcs,
						'lebih_bayar'=>str_replace(",","",$this->input->post('pakai_lebih_bayar')),
						'tambah_lebih_bayar'=>str_replace(",","",$this->input->post('tambah_lebih_bayar')),
					);
					
		
						
		$this->db->insert('tr_invoice_np_payment',$data);
		
		
		for($i=0;$i < count($this->input->post('kode_produk'));$i++){
            $datadetail = array(
                'kd_pembayaran'     => $kd_bayar,
                'no_invoice'        => $this->input->post('kode_produk')[$i],
                'nm_customer'       => $this->input->post('nm_customer2')[$i],
                'total_invoice_idr'    => str_replace(",","",$this->input->post('sisa_invoice')[$i]),
				'total_bayar_idr'     => str_replace(",","",$this->input->post('jml_bayar')[$i]),
				'sisa_invoice_idr'    => str_replace(",","",$this->input->post('sisa_invoice')[$i]) - str_replace(",","",$this->input->post('jml_bayar')[$i]),
				'total_pph_idr'     => str_replace(",","",$this->input->post('pph')[$i]),
                'created_on'    => date('Y-m-d H:i:s'),
                'created_by'    => $session['id_user']
                );
             $this->db->insert('tr_invoice_np_payment_detail',$datadetail);
             //Update QTY_AVL
             $invoice = $this->input->post('kode_produk')[$i];
             $jmlbyr  = str_replace(",","",$this->input->post('jml_bayar')[$i]);			 
			 $Qry_Update	 = "UPDATE tr_invoice_np_header SET total_bayar_idr=total_bayar_idr + $jmlbyr, sisa_invoice_idr=sisa_invoice_idr - $jmlbyr WHERE id_invoice='$invoice'";
        	 $this->db->query($Qry_Update);


			 $so  = $this->db->query("SELECT * FROM tr_invoice_np_header WHERE id_invoice='$invoice'")->row();
			 // $no_so = $so->no_so;

			 // $Qry_Update_so	 = "UPDATE tr_sales_order SET total_bayar_so=total_bayar_so + $jmlbyr WHERE no_so='$no_so'";
        	 // $this->db->query($Qry_Update_so);


        }
		               $tambah_lebih_bayar = $this->input->post('tambah_lebih_bayar');
					
					
		               if($tambah_lebih_bayar != 0){
						   
						 		
						   
        				$data_lebih_bayar[]			= array(
        					  'tgl'                => $this->input->post('tgl_bayar'),
        					  'keterangan'         => $nmcs,
        					  'totalpenerimaan'    => str_replace(",","",$this->input->post('tambah_lebih_bayar')),
        					  'saldo'              => str_replace(",","",$this->input->post('tambah_lebih_bayar')),
        					  'created_on'         => date('Y-m-d H:i:s'),
                              'created_by'         => $session['id_user'],
        					  'bank'         	  => $this->input->post('bank')       					  

        				);
						
						
						$this->db->insert_batch('tr_unlocated_bank',$data_lebih_bayar);
						
					$Nomor_BUM				= $this->Jurnal_model->get_Nomor_Jurnal_BUM('101',$Tgl_Invoice);
						
					// $Nomor_JV = $this->Jurnal_model->get_Nomor_Jurnal_Sales('101', $Tgl_Invoice);
					$Keterangan_INV1 = 'LEBIH BAYAR ' .$nmcs;
					$Jml_Ttl  = str_replace(",","",$this->input->post('tambah_lebih_bayar'));
					 $Bln = substr($Tgl_Invoice, 5, 2);
                     $Thn = substr($Tgl_Invoice, 0, 4);
					 
					// $dataJVhead = array(
										// 'nomor' => $Nomor_JV, 
										// 'tgl' => $Tgl_Invoice,
										// 'jml' => $Jml_Ttl, 
										// 'koreksi_no' => '-', 
										// 'kdcab' => '101', 
										// 'jenis' => 'JV', 
										// 'keterangan' => $Keterangan_INV1, 
										// 'bulan' => $Bln, 
										// 'tahun' => $Thn, 
										// 'user_id' => $session['id_user'], 
										// 'memo' => '', 
										// 'tgl_jvkoreksi' => $Tgl_Invoice, 
										// 'ho_valid' => ''
										// );
										
						$dataJARH2 = array(
          					'nomor' 	    	=> $Nomor_BUM,
							'kd_pembayaran'    	=> $kd_bayar,
          					'tgl'	         	=> $Tgl_Invoice,
          					'jml'	            => $Jml_Ttl,
          					'kdcab'				=> '101',
          					'jenis_reff'		=> $kd_bayar,
							'no_reff'		    => $kd_bayar,
							'customer'		    => $nmcs,
							'terima_dari'		=> '-',
							'jenis_ar'		    => 'V',
     						'note'				=> $Keterangan_INV1,
        					'valid'				=> $session['id_user'],
          					'tgl_valid'			=> $Tgl_Invoice,
							'user_id'			=> $session['id_user'],
							'tgl_invoice'	    => $Tgl_Invoice,
          					'ho_valid'			=> '',
							'batal'			    => '0'
          				);
										
                        $det_Jurnal_lebih  = array();
					    $det_Jurnal_lebih[]= array(
      					  'nomor'         => $Nomor_BUM,
      					  'tanggal'       => $Tgl_Invoice,
      					  'tipe'          => 'JV',
      					  'no_perkiraan'  => $kd_bank,
      					  'keterangan'    => $Keterangan_INV1,
      					  'no_reff'       => $kd_bayar,
      					  'debet'         => $Jml_Ttl,
      					  'kredit'        => 0
      				    );
						

						$det_Jurnal_lebih[] = array( 
      					  'nomor'         => $Nomor_BUM,
      					  'tanggal'       => $Tgl_Invoice,
      					  'tipe'          => 'JV',
      					  'no_perkiraan'  => '2109-02-01',
      					  'keterangan'    => $Keterangan_INV1,
      					  'no_reff'       => $kd_bayar,
      					  'debet'         => 0,
      					  'kredit'        => $Jml_Ttl
      				    );
					 
					
					   
					// $this->db->insert(DBACC.'.JARH',$dataJARH2);
        			// $this->db->insert_batch(DBACC.'.jurnal',$det_Jurnal_lebih);
					
					//$this->db->insert(DBACC.'.JARH',$dataJARH2);
        			//$this->db->insert_batch(DBACC.'.jurnal',$det_Jurnal_lebih);
					
					//$Qry_Update_Cabang_acc	 = "UPDATE ".DBACC.".pastibisa_tb_cabang SET nobum=nobum + 1 WHERE nocab='101'";
        			//$this->db->query($Qry_Update_Cabang_acc); 
						
					// $Qry_Update_Cabang_acc = "UPDATE ".DBACC.".pastibisa_tb_cabang SET nomorJC=nomorJC + 1 WHERE nocab='101'";
					// $this->db->query($Qry_Update_Cabang_acc);
								
		            }
		
		if($id_unlocated !=''){
		$Qry_Update2	 = "UPDATE tr_unlocated_bank SET saldo=saldo - $unlocated WHERE id='$id_unlocated'";
        	 $this->db->query($Qry_Update2);
	    }
			
        // elseif($id_lebihbayar !=''){			
		// $Qry_Update3	 = "UPDATE tr_lebihbayar_bank SET saldo=saldo - $lebihbayar WHERE id='$id_lebihbayar'";
        // 	 $this->db->query($Qry_Update3); 
		// } 
		
		
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
	public function jurnal_bum_np()
    {
        $this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-list');			
		$data = $this->penerimaan_model->get_data_pn_jurnal_np();			
		$this->template->set('results', $data);
        $this->template->title('Jurnal Penerimaan');
        $this->template->render('index_jurnal_penerimaan_np');
    }
	
	    public function print_penerimaan(){
		ob_clean();
		ob_start();
        $this->auth->restrict($this->managePermission); 
        $kd_bayar = $this->uri->segment(3);		
		$data = array(
			'kodebayar' => $kd_bayar,		
		);		
		$this->load->view('print_penerimaan',$data);
		$html = ob_get_contents();

		require_once('./assets/html2pdf/html2pdf/html2pdf.class.php');
		$html2pdf = new HTML2PDF('P','A4','en',true,'UTF-8',array(10, 5, 10, 5));
		$html2pdf->pdf->SetDisplayMode('fullpage');
		$html2pdf->WriteHTML($html);
		ob_end_clean();
		$html2pdf->Output('Penerimaan.pdf', 'I');
	}
}