 <?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Tools extends Admin_Controller {
    //Permission
    protected $viewPermission = "Tools.View";
    protected $addPermission = "Tools.Add";
    protected $managePermission = "Tools.Manage";
    protected $deletePermission = "Tools.Delete";
    public function __construct() {
        parent::__construct();
        $this->load->library(array('Mpdf', 'upload', 'Image_lib'));
        $this->load->model('Tools/Tools_model');
        $this->template->title('Manage Data Plan Bayar');
        $this->template->page_icon('fa fa-building-o');
        date_default_timezone_set('Asia/Bangkok');
    }
 
 
	public function batal_planning() {
        $this->auth->restrict($this->viewPermission);
        $this->template->page_icon('fa fa-list');
        $data = '0';
        $this->template->set('results', $data);
        $this->template->title('Hapus Data Planning');
        $this->template->render('index_dtspkmarketing.php'); 
    }
	
	public function tampilkan_planning()	{
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$post = $this->input->post();		
		$this->template->page_icon('fa fa-users');
        $data = $this->Tools_model->cariPlanning($this->input->post("nomor"));
		
		// print_r($data);
		// exit;
		
		
        $this->template->set('results', $data);
        $this->template->title('Hapus Data Planning');
		$this->template->render('index_dtspkmarketing');
	}
	
	
	public function hapusplanning(){
		$this->auth->restrict($this->deletePermission);
		$id = $this->input->post('id');
		
		$today			= date('Y-m-d H:i:s');
		$user			= $this->auth->user_id();
		
		$this->db->trans_begin();
		
		$so   = $this->db->query("SELECT * FROM tr_planning_delivery_detail WHERE no_planning='$id'")->result();
		
		foreach($so AS $val ){
		$id_so = $val->id_so_detail;
		
		$dataso = [
					
					'qty_delivery'		    => 0,
					'status_planning'		=> '0',
					'modified_by'			=> $this->auth->user_id(),
					'modified_on'			=> date('Y-m-d H:i:s'),
					
				]; 
		
		$this->db->where('id_so_detail',$id_so)->update("tr_sales_order_detail",$dataso);
			
		}
		
		$header =$this->db->query("INSERT INTO tr_planning_delivery_deleted (
							id,
							no_planning,
							no_surat_planning,
							tgl_planning,
							no_so,
							no_penawaran,
							no_surat,
							tgl_so,
							id_customer,
							pic_customer,
							mata_uang,
							email_customer,
							valid_until,
							top,
							nilai_so,
							order_status,
							id_sales,
							nama_sales,
							pengiriman,
							status,
							revisi,
							keterangan,
							created_by,
							created_on,
							modified_by,
							modified_on,
							printed_by,
							printed_on,
							delivered_by,
							delivered_on,
							approved_by,
							approved_on,
							revisi_by,
							revisi_on,
							ppn,
							nilai_ppn,
							grand_total,
							keterangan_loss,
							keterangan_approve,
							upload_po,
							upload_so,
							id_so,
							status_do,
							approval_finance,
							request_do,
							location,
							status_planning,
							percent_invoice,
							total_invoice,
							percent_do,
							total_do,
							total_dikirim,
							total_hpp,
							total_bayar_so,
							keterangan_kirim,
							invoice_revenue,
							hpp_revenue,
							persenhpp_revenue,
							perseninvoice_revenue,
							reff,							
							deleted_on
							) 
							(SELECT 
							id,
							no_planning,
							no_surat_planning,
							tgl_planning,
							no_so,
							no_penawaran,
							no_surat,
							tgl_so,
							id_customer,
							pic_customer,
							mata_uang,
							email_customer,
							valid_until,
							top,
							nilai_so,
							order_status,
							id_sales,
							nama_sales,
							pengiriman,
							status,
							revisi,
							keterangan,
							created_by,
							created_on,
							modified_by,
							modified_on,
							printed_by,
							printed_on,
							delivered_by,
							delivered_on,
							approved_by,
							approved_on,
							revisi_by,
							revisi_on,
							ppn,
							nilai_ppn,
							grand_total,
							keterangan_loss,
							keterangan_approve,
							upload_po,
							upload_so,
							id_so,
							status_do,
							approval_finance,
							request_do,
							location,
							status_planning,
							percent_invoice,
							total_invoice,
							percent_do,
							total_do,
							total_dikirim,
							total_hpp,
							total_bayar_so,
							keterangan_kirim,
							invoice_revenue,
							hpp_revenue,
							persenhpp_revenue,
							perseninvoice_revenue,
							reff,
							NOW()
							FROM tr_planning_delivery WHERE no_planning='$id')"
						 );
						 
						 
			$detail= $this->db->query("INSERT INTO tr_planning_delivery_detail_deleted (			 
					id_planning_delivery,
					id_so_detail,
					id_penawaran_detail,
					no_planning,
					no_so,
					no_penawaran,
					id_category3,
					nama_produk,
					id_bentuk,
					qty_so,
					qty,
					harga_satuan,
					stok_tersedia,
					potensial_loss,
					diskon,
					freight_cost,
					total_harga,
					keterangan,
					revisi,
					tgl_delivery,
					created_by,
					created_on,
					modified_by,
					modified_on,
					nilai_diskon,
					diskon_compare,
					id_so,
					qty_delivery,
					schedule,
					metode_kirim,
					keterangan_kirim,
					qty_terkirim,
					status_planning,
					status_kirim,
					keterangan_statuskirim,
					qty_spk,
					deleted_on
					) 
					(SELECT 
					id_planning_delivery,
					id_so_detail,
					id_penawaran_detail,
					no_planning,
					no_so,
					no_penawaran,
					id_category3,
					nama_produk,
					id_bentuk,
					qty_so,
					qty,
					harga_satuan,
					stok_tersedia,
					potensial_loss,
					diskon,
					freight_cost,
					total_harga,
					keterangan,
					revisi,
					tgl_delivery,
					created_by,
					created_on,
					modified_by,
					modified_on,
					nilai_diskon,
					diskon_compare,
					id_so,
					qty_delivery,
					schedule,
					metode_kirim,
					keterangan_kirim,
					qty_terkirim,
					status_planning,
					status_kirim,
					keterangan_statuskirim,
					qty_spk,
					NOW()
					FROM tr_planning_delivery_detail WHERE no_planning='$id')"
				     );
					 
					 
				$hapusheader = $this->db->query("DELETE FROM tr_planning_delivery WHERE no_planning='$id'");
				$hapusdetail = $this->db->query("DELETE FROM tr_planning_delivery_detail WHERE no_planning='$id'");
				$hapusplantagih = $this->db->query("DELETE FROM wt_plan_tagih WHERE no_planning='$id'");
					 
		
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$status	= array(
			  'pesan'		=>'Gagal Save Item. Thanks ...',
			  'status'	=> 0
			);
		} else {
			$this->db->trans_commit();
			$status	= array(
			  'pesan'		=>'Success Save Item. Thanks ...',
			  'status'	=> 1
			);			
		}
		
  		echo json_encode($status);
	}
	
	public function batal_so() {
        $this->auth->restrict($this->viewPermission);
        $this->template->page_icon('fa fa-list');
        $data = '0';
        $this->template->set('results', $data);
        $this->template->title('Hapus Data SO');
        $this->template->render('index_so.php'); 
    }
	
	public function tampilkan_so()	{
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$post = $this->input->post();		
		$this->template->page_icon('fa fa-users');
        $data = $this->Tools_model->cariSalesOrderId($this->input->post("nomor"));
	    $this->template->set('results', $data);
        $this->template->title('Hapus Data SO');
		$this->template->render('index_so');
	}
	
	
	public function hapus_so(){
		
		$this->auth->restrict($this->deletePermission);
		$id = $this->input->post('id');
		$today			= date('Y-m-d H:i:s');
		$user			= $this->auth->user_id();
		
		$this->db->trans_begin();
		
		
				
					 
					 
				$penawaran    = $this->db->query("SELECT no_penawaran FROM tr_sales_order WHERE no_so='$id'")->row();
				$no_pn        = $penawaran->no_penawaran;
				$datapn = [
							'status'		    => '4',
							'modified_by'			=> $this->auth->user_id(),
							'modified_on'			=> date('Y-m-d H:i:s'),
										
						  ]; 							
				$this->db->where('no_penawaran',$no_pn)->update("tr_penawaran",$datapn); 
				
				
				$so   = $this->db->query("SELECT * FROM tr_sales_order_detail WHERE no_so='$id'")->result();
	
				foreach($so AS $val ){
						$material = $val->id_category3;
						$qtyso    = $val->qty_so;
						$code     = $val->no_so;
						$nomor    = $this->db->query("SELECT no_surat FROM tr_sales_order WHERE no_so='$id'")->row();
						$surat    = $nomor->no_surat;
						$this->kartu_stok($material,$qtyso,$code,$surat);
							
				 }
					 
		
			$header =$this->db->query("INSERT INTO tr_sales_order_batal (
							id,
							no_so,
							no_penawaran,
							no_surat,
							tgl_so,
							id_customer,
							pic_customer,
							mata_uang,
							email_customer,
							valid_until,
							top,
							nilai_so,
							order_status,
							id_sales,
							nama_sales,
							pengiriman,
							status,
							revisi,
							keterangan,
							created_by,
							created_on,
							modified_by,
							modified_on,
							printed_by,
							printed_on,
							delivered_by,
							delivered_on,
							approved_by,
							approved_on,
							revisi_by,
							revisi_on,
							ppn,
							nilai_ppn,
							grand_total,
							keterangan_loss,
							keterangan_approve,
							upload_po,
							upload_so,
							id_so,
							status_do,
							approval_finance,
							request_do,
							location,
							status_planning,
							percent_invoice,
							total_invoice,
							percent_do,
							total_do,
							total_dikirim,
							total_hpp,
							total_bayar_so,
							keterangan_kirim,
							reff,
							deleted_on

							) 
							(SELECT 
							id,
							no_so,
							no_penawaran,
							no_surat,
							tgl_so,
							id_customer,
							pic_customer,
							mata_uang,
							email_customer,
							valid_until,
							top,
							nilai_so,
							order_status,
							id_sales,
							nama_sales,
							pengiriman,
							status,
							revisi,
							keterangan,
							created_by,
							created_on,
							modified_by,
							modified_on,
							printed_by,
							printed_on,
							delivered_by,
							delivered_on,
							approved_by,
							approved_on,
							revisi_by,
							revisi_on,
							ppn,
							nilai_ppn,
							grand_total,
							keterangan_loss,
							keterangan_approve,
							upload_po,
							upload_so,
							id_so,
							status_do,
							approval_finance,
							request_do,
							location,
							status_planning,
							percent_invoice,
							total_invoice,
							percent_do,
							total_do,
							total_dikirim,
							total_hpp,
							total_bayar_so,
							keterangan_kirim,
							reff,
							NOW()
							FROM tr_sales_order WHERE no_so='$id')"
						 );
						 
						 
			$detail= $this->db->query("INSERT INTO tr_sales_order_detail_batal (			 
								id_so_detail,
								id_penawaran_detail,
								no_so,
								no_penawaran,
								id_category3,
								nama_produk,
								id_bentuk,
								qty_so,
								qty,
								harga_satuan,
								stok_tersedia,
								potensial_loss,
								diskon,
								freight_cost,
								total_harga,
								keterangan,
								revisi,
								tgl_delivery,
								created_by,
								created_on,
								modified_by,
								modified_on,
								nilai_diskon,
								diskon_compare,
								id_so,
								qty_delivery,
								schedule,
								metode_kirim,
								keterangan_kirim,
								qty_terkirim,
								status_planning,
								status_kirim,
								keterangan_statuskirim,
								qty_spk,
								costbook_so,
								deleted_on
							) 
					(SELECT 
							id_so_detail,
							id_penawaran_detail,
							no_so,
							no_penawaran,
							id_category3,
							nama_produk,
							id_bentuk,
							qty_so,
							qty,
							harga_satuan,
							stok_tersedia,
							potensial_loss,
							diskon,
							freight_cost,
							total_harga,
							keterangan,
							revisi,
							tgl_delivery,
							created_by,
							created_on,
							modified_by,
							modified_on,
							nilai_diskon,
							diskon_compare,
							id_so,
							qty_delivery,
							schedule,
							metode_kirim,
							keterangan_kirim,
							qty_terkirim,
							status_planning,
							status_kirim,
							keterangan_statuskirim,
							qty_spk,
							costbook_so,
							NOW()
							FROM tr_sales_order_detail WHERE no_so='$id')"
				     );
					 
					 
					 
					 
					 
					
				$hapusheader = $this->db->query("DELETE FROM tr_sales_order WHERE no_so='$id'");
				$hapusdetail = $this->db->query("DELETE FROM tr_sales_order_detail WHERE no_so='$id'");
				
				
				
				
			
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$status	= array(
			  'pesan'		=>'Gagal Save Item. Thanks ...',
			  'status'	=> 0
			);
		} else {
			$this->db->trans_commit();
			$status	= array(
			  'pesan'		=>'Success Save Item. Thanks ...',
			  'status'	=> 1
			);			
		}
		
  		echo json_encode($status);
	}
	
	
	public function kartu_stok($material,$qtyso,$notr,$no_surat)
	{
		
		$mat = $this->db->query("SELECT * FROM stock_material WHERE id_category3='$material' ")->row();

		

		$book  = (int) $mat->qty_book - (int) $qtyso;
		$free  = (int) $mat->qty_free + (int)$qtyso;

		// print_r($free);
		// exit;
		$kartu = [
			'id_category3'		    => $material,
			'qty'		            => $mat->qty,
			'qty_book'			    => $mat->qty_book,
			'qty_free'		        => $mat->qty_free,
			'transaksi'			    => 'batal sales order',
			'tgl_transaksi'			=> date('Y-m-d'),
			'no_transaksi'			=> $notr,
			'id_gudang'             => $mat->id_gudang,
			'created_on'			=> date('Y-m-d H:i:s'),
			'created_by'			=> $this->auth->user_id(),
			'qty_transaksi'         => $qtyso,
			'qty_akhir'		        => $mat->qty,
			'qty_book_akhir'	    => $book,
			'qty_free_akhir'		=> $free,	
			'status_transaksi'		=> 'in',			
			'no_surat'		        => $no_surat,
			];

		$this->db->insert('kartu_stok',$kartu);	   

		$this->db->query("UPDATE stock_material SET qty_free=qty_free+$qtyso , qty_book=qty_book-$qtyso  WHERE id_category3='$material'");
	}

	
	
	  
	
	
}