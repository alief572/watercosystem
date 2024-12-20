<?php
if (!defined('BASEPATH')){
    exit('No direct script access allowed');
}

/*
 * @author Syamsudin
 * @Copyright (c) 2022, Syamsudin
 *
 * This is controller for Wt_delivery_order
 */

class Wt_delivery_order extends Admin_Controller
{
    //Permission
    protected $viewPermission 	= 'Planning_Delivery.View';
    protected $addPermission  	= 'Planning_Delivery.Add';
    protected $managePermission = 'Planning_Delivery.Manage';
    protected $deletePermission = 'Planning_Delivery.Delete';

    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('Mpdf', 'upload', 'Image_lib'));
        $this->load->model(array('Wt_penawaran/Wt_penawaran_model',
								 'Wt_delivery_order/Wt_delivery_order_model',
                                 'Aktifitas/aktifitas_model',
                                ));
        $this->template->title('Manage Data Delivery');
        $this->template->page_icon('fa fa-building-o');
        date_default_timezone_set('Asia/Bangkok');
    }

    public function planning_do()
    {
        $this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
        $data = $this->Wt_delivery_order_model->cariSalesOrder();
        $this->template->set('results', $data);
        $this->template->title('Planning Delivery Order');
        $this->template->render('index');
    }
	public function viewPlanning($id){
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$aktif = 'active';
		$deleted = '0';
		$customers = $this->Wt_delivery_order_model->get_data('master_customers','deleted',$deleted);
		$header    = $this->Wt_delivery_order_model->get_data('tr_sales_order','no_so',$id);
		$detail    = $this->Wt_delivery_order_model->get_data('tr_sales_order_detail','no_so',$id);
		$data = [
			'customers' => $customers,
			'header'=>$header,
			'detail'=>$detail,
			'action'=>'view',
		];

        $this->template->set('results', $data);
        $this->template->title('View Planning Delivery');
        $this->template->render('planning_delivery');
	}
	public function createPlanning($id)
    {
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$aktif = 'active';
		$deleted = '0';
		$customers = $this->Wt_delivery_order_model->get_data('master_customers','deleted',$deleted);
		$header    = $this->Wt_delivery_order_model->get_data('tr_sales_order','no_so',$id);
		$detail    = $this->Wt_delivery_order_model->get_data('tr_sales_order_detail','no_so',$id);
		$data = [
			'customers' => $customers,
			'header'=>$header,
			'detail'=>$detail,
			'action'=>'edit',
		];

        $this->template->set('results', $data);
        $this->template->title('Planning Delivery');
        $this->template->render('planning_delivery');

    }
	function SavePlanning(){
		$post = $this->input->post();
		$data = [
					'location'	=> $post['location'],
					'status_planning'	=> '1',
				];
		$this->db->where('no_so',$post['no_so'])->update("tr_sales_order",$data);			
		$numb1 =0;
		for ($i=0;$i<count($post['id_so_detail']);$i++){
			$dt= array(
					'qty_delivery'		=> $post['qty_delivery'][$i],
					'schedule'	  		=> $post['schedule'][$i],
					'metode_kirim'		=> $post['metode_kirim'][$i],
					'keterangan_kirim'	=> $post['keterangan_kirim'][$i],     
					'status_planning'	=> '1',           
				 );
			$this->db->where('id_so_detail',$post['id_so_detail'][$i])->update("tr_sales_order_detail",$dt);
		}
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$status	= array(
			  'pesan'	=>'Failed.',
			  'code' 	=> $code,
			  'status'	=> 0
			);
		} else {
			$this->db->trans_commit();
			$status	= array(
			  'pesan'	=>'Success.',
			  'code' 	=> $code,
			  'status'	=> 1
			);
		}
  		echo json_encode($status);
	}

	public function spk_delivery()
    {
        $this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users'); 
        $data = $this->Wt_delivery_order_model->cariSpkDelivery();
        $this->template->set('results', $data);
        $this->template->title('SPK Delivery Order');
        $this->template->render('index_spkdelivery');
    }


	public function addSpkdelivery()
    {
        $this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
		$customer = $this->Wt_delivery_order_model->get_data('master_customers');
		$this->template->set('customer', $customer);

 		if($this->uri->segment(3) == ""){
        $data = $this->Wt_delivery_order_model->cariSalesOrderPlanning();	
		}
		else{
		$data = $this->Wt_delivery_order_model->cariSalesOrderPlanning($this->uri->segment(3));	
		}	
        $this->template->set('results', $data);
		
        $this->template->title('Planning Delivery Order');
        $this->template->render('index_planningdelivery');
    }


	public function proses(){
		    $session = $this->session->userdata('app_session');
			$getparam = explode(";",$_GET['param']);
			$getso = $this->Wt_delivery_order_model->get_where_in('no_so',$getparam,'tr_sales_order');  
			$and = " status_planning ='1' ";
			$getitemso = $this->Wt_delivery_order_model->get_where_in_and('no_so',$getparam,$and,'tr_sales_order_detail');
			
			$this->template->set('param',$getparam);
			$this->template->set('headerso',$getso);
			$this->template->set('getitemso',$getitemso);
			$this->template->title('Input SPK Delivery'); 
			$this->template->render('spk_delivery');
	}

	function SaveSpkdelivery(){
		$post = $this->input->post();
		$tanggal = $post['tanggal'];
		$code = 	$this->Wt_delivery_order_model->generate_code();
		$no_surat = $this->Wt_delivery_order_model->BuatNomor($tanggal);

		$data = [
			'no_spk'		        => $code,
			'no_surat'		        => $no_surat,
			'tgl_spk'				=> $post['tanggal'],
			'id_customer'			=> $post['id_customer'],
			'location'			    => $post['location'],
			'created_on'			=> date('Y-m-d H:i:s'),
			'created_by'			=> $this->auth->user_id(),
			
		

			];

			$this->db->insert('tr_spk_delivery',$data);


			$numb1 =0;
			foreach($_POST['dt'] as $used){
				$numb1++;      
				if($used[kirim]){  
				$dt =  array(
						'id_so_detail'			=> $used[id_so],
						'no_spk'		        => $code,
						'no_so'				    => $used[no_so],
						'id_category3'		    => $used[id_category3],
						'nama_produk'			=> $used[nama_produk],
						'qty_delivery'			=> $used[qty_delivery],
						'schedule'			    => $used[schedule],
						'created_on'			=> date('Y-m-d H:i:s'),
			            'created_by'			=> $this->auth->user_id()
						);
						
			// $this->db->where('id_spk_aktual',$id_spk_aktual);
			// $this->db->delete('dt_spk_aktual');
			
				$this->db->insert('tr_spk_delivery_detail',$dt);
				$idsodet =$used[id_so];

				$this->db->query("UPDATE tr_sales_order_detail SET qty_spk=qty_spk + 1 WHERE id_so_detail='$idsodet'");


				}

			}



						
			
      			  		

				


		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$status	= array(
			  'pesan'		=>'Gagal Save Item. Thanks ...',
			  'code' => $code,
			  'status'	=> 0
			);
		} else {
			$this->db->trans_commit();
			$status	= array(
			  'pesan'		=>'Success Save Item. invenThanks ...',
			  'code' => $code,
			  'status'	=> 1
			);
		}

  		echo json_encode($status);

    }	

	public function printSPK($id){
		ob_clean();
		ob_start();
        $this->auth->restrict($this->managePermission);
        $id = $this->uri->segment(3);

		// $data = [
		// 	'status'		        => 3,
		// 	'printed_on'			=> date('Y-m-d H:i:s'),
		// 	'printed_by'			=> $this->auth->user_id()
		// 	];
			//Edit Data
        // $this->db->where('no_penawaran',$id)->update("tr_penawaran",$data);	
		
		$getparam = $id;
		$data['header'] = $this->Wt_delivery_order_model->get_where_in('no_spk',$getparam,'tr_spk_delivery');  
		$data['detail'] = $this->Wt_delivery_order_model->cariSpkDeliveryDetail($id);  

		$this->load->view('PrintSPKDelivery',$data);
		$html = ob_get_contents();

		require_once('./assets/html2pdf/html2pdf/html2pdf.class.php');
		$html2pdf = new HTML2PDF('P','A4','en',true,'UTF-8',array(10, 5, 10, 5));
		$html2pdf->pdf->SetDisplayMode('fullpage');
		$html2pdf->WriteHTML($html);
		ob_end_clean();
		$html2pdf->Output('SPK Delivery.pdf', 'I');
	}

	public function EditSpkdelivery($id){
		$session = $this->session->userdata('app_session');
		$getparam = $id;
		$getso = $this->Wt_delivery_order_model->get_where_in('no_spk',$getparam,'tr_spk_delivery');  
		$getitemso = $this->Wt_delivery_order_model->get_where_in('no_spk',$getparam,'tr_spk_delivery_detail');  
		$and = " status_planning ='1' ";
		$getitemso2 = $this->Wt_delivery_order_model->get_where_in_and('no_so',$getparam,$and,'tr_sales_order_detail');
		
		$this->template->set('param',$getparam);
		$this->template->set('headerso',$getso);
		$this->template->set('getitemso',$getitemso);
		$this->template->title('Edit SPK Delivery');
		$this->template->render('spk_delivery_edit');
	}

	public function delivery_order()
    {
        $this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
        $data = $this->Wt_delivery_order_model->cariDeliveryOrder();
        $this->template->set('results', $data);
        $this->template->title('Delivery Order');
        $this->template->render('index_deliveryorder');
    }
	
	
	public function createDO($id){
		$session = $this->session->userdata('app_session');
		$getparam = $id;
		$getso = $this->Wt_delivery_order_model->get_where_in('no_spk',$getparam,'tr_spk_delivery');  
		$and  ="status_do='0'";
		$getitemso = $this->Wt_delivery_order_model->get_where_in_and('no_spk',$getparam,$and,'tr_spk_delivery_detail');  
		$and2 = " status_planning ='1' ";
		$getitemso2 = $this->Wt_delivery_order_model->get_where_in_and('no_so',$getparam,$and2,'tr_sales_order_detail');
		
		$this->template->set('param',$getparam);
		$this->template->set('headerso',$getso);
		$this->template->set('getitemso',$getitemso);
		$this->template->title('Input Delivery Order');
		$this->template->render('delivery_order');
	}

	function SaveDeliveryOrder(){
		$post = $this->input->post();

		$config['upload_path'] = './assets/file_po/'; //path folder
	    $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp|doc|docx|xls|xlsx|ppt|pptx|pdf|rar|zip|vsd'; //type yang dapat diakses bisa anda sesuaikan
	    $config['encrypt_name'] = false; //Enkripsi nama yang terupload
		

	    $this->upload->initialize($config);
	        if ($this->upload->do_upload('upload_foto')){
	            $gbr = $this->upload->data();
	            //Compress Image
	            $config['image_library']='gd2';
	            $config['source_image']='./assets/file_po/'.$gbr['file_name'];
	            $config['create_thumb']= FALSE;
	            $config['maintain_ratio']= FALSE;
	            $config['umum']= '50%';
	            $config['width']= 260;
	            $config['height']= 350;
	            $config['new_image']= './assets/file_po/'.$gbr['file_name'];
	            $this->load->library('image_lib', $config);
	            $this->image_lib->resize();

	            $gambar  =$gbr['file_name'];
				$type    =$gbr['file_type'];
				$ukuran  =$gbr['file_size'];
				$ext1    =explode('.', $gambar);
				$ext     =$ext1[1];
				$lokasi = $gbr['file_name'];
				
			}

		
		$tanggal  = $post['tanggal'];
		$code 	  = $this->Wt_delivery_order_model->generate_code_Do();
		$no_surat = $this->Wt_delivery_order_model->BuatNomorDo($tanggal);

		$data = [
			'no_do'		            => $code,
			'no_surat'		        => $no_surat,
			'id_customer'		    => $post['id_customer'],
			'no_spk'		        => $post['no_spk'],
			'tgl_do'				=> $post['tanggal'],
			'id_customer'			=> $post['id_customer'],
			'location'			    => $post['location'],
			'created_on'			=> date('Y-m-d H:i:s'),
			'created_by'			=> $this->auth->user_id(),
			'upload_foto'		    => $lokasi,
			
		

			];

			$this->db->trans_begin();

			$spk = $post['no_spk'];
			$this->db->insert('tr_delivery_order',$data);
			$this->db->query("UPDATE tr_spk_delivery SET status_do='1' WHERE no_spk='$spk'");


			$numb1 =0;
			foreach($_POST['dt'] as $used){
				$numb1++;      
				if($used[kirim]){  
				$qty_dikirim 	=	(int)$used[qty_delivery];
				$idmaterial 	= 	$used[id_category3];	
				$noso 			=  	$used[no_so];			
				$cost = $this->db->query("SELECT * FROM ms_costbook WHERE id_category3='$idmaterial'")->row();
				$so   = $this->db->query("SELECT sum(qty_so) as qtyso FROM tr_sales_order_detail WHERE no_so='$noso'")->row();

				$qtyso = (int)$so->qtyso;
				$persen = round(($qty_dikirim/$qtyso)*100);
				$persendo = (int)$persen;
				$costbook = $cost->nilai_costbook;
				$totalhpp = $qtyso*$costbook;

				
				$dt =  array(
						'id_so_detail'			=> $used[id_so],
						'id_spk_detail'			=> $used[id_spk],
						'no_do'		            => $code,
						'no_so'				    => $used[no_so],
						'no_spk'				=> $used[no_spk],
						'id_category3'		    => $used[id_category3],
						'nama_produk'			=> $used[nama_produk],
						'qty_do'			    => $used[qty_delivery],
						'schedule'			    => $used[schedule],
						'tgl_delivery'			=> $used[schedule],
						'serial_number'			=> $used[serial_number],
						'kartu_garansi'		    => $used[kartu_garansi],
						'created_on'			=> date('Y-m-d H:i:s'),
			            'created_by'			=> $this->auth->user_id(), 
						'cost_book'				=> $cost->nilai_costbook 

						);
						
			// $this->db->where('id_spk_aktual',$id_spk_aktual);
			// $this->db->delete('dt_spk_aktual');
			
				$this->db->insert('tr_delivery_order_detail',$dt); 
				
				$idspkdt = $used[id_spk];
				$this->db->query("UPDATE tr_spk_delivery_detail SET status_do='1' WHERE id_spk_detail='$idspkdt'");

			   

				$this->db->query("UPDATE tr_sales_order SET total_dikirim=total_dikirim + $qty_dikirim, percent_do=percent_do + $persendo, total_hpp='$totalhpp' WHERE no_so='$noso'");

				}

			}


		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$status	= array(
			  'pesan'		=>'Gagal Save Item. Thanks ...',
			  'code' => $code,
			  'status'	=> 0
			);
		} else {
			$this->db->trans_commit();
			$status	= array(
			  'pesan'		=>'Success Save Item. invenThanks ...',
			  'code' => $code,
			  'status'	=> 1
			);
		}

  		echo json_encode($status);



		
    }	


	

	public function viewDO($id){
		$session = $this->session->userdata('app_session');
		$getparam = $id;
		$getso = $this->Wt_delivery_order_model->get_where_in('no_do',$getparam,'tr_delivery_order');  
		$getitemso = $this->Wt_delivery_order_model->cariDeliveryOrderDetail($id);  
		$and = " status_planning ='1' ";
		$getitemso2 = $this->Wt_delivery_order_model->get_where_in_and('no_do',$getparam,$and,'tr_delivery_order_detail');
		
		$this->template->set('param',$getparam);
		$this->template->set('headerso',$getso);
		$this->template->set('getitemso',$getitemso);
		$this->template->title('View Delivery Order');
		$this->template->render('view_deliveryorder');
	}

	public function confirmDO($id){
		$session = $this->session->userdata('app_session');
		$getparam = $id;
		$getso = $this->Wt_delivery_order_model->get_where_in('no_do',$getparam,'tr_delivery_order');  
		$getitemso = $this->Wt_delivery_order_model->cariDeliveryOrderDetail($id);  
		$and = " status_planning ='1' ";
		$getitemso2 = $this->Wt_delivery_order_model->get_where_in_and('no_do',$getparam,$and,'tr_delivery_order_detail');
		
		$this->template->set('param',$getparam);
		$this->template->set('headerso',$getso);
		$this->template->set('getitemso',$getitemso);
		$this->template->title('View Delivery Order');
		$this->template->render('confirm_deliveryorder');
	}

	function SaveConfirmDeliveryOrder(){
		$post = $this->input->post();

		// print_r($post);
		// exit;

		$config['upload_path'] = './assets/file_po/'; //path folder
	    $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp|doc|docx|xls|xlsx|ppt|pptx|pdf|rar|zip|vsd'; //type yang dapat diakses bisa anda sesuaikan
	    $config['encrypt_name'] = false; //Enkripsi nama yang terupload
		

	    $this->upload->initialize($config);
	        if ($this->upload->do_upload('upload_sj')){
	            $gbr = $this->upload->data();
	            //Compress Image
	            $config['image_library']='gd2';
	            $config['source_image']='./assets/file_po/'.$gbr['file_name'];
	            $config['create_thumb']= FALSE;
	            $config['maintain_ratio']= FALSE;
	            $config['umum']= '50%';
	            $config['width']= 260;
	            $config['height']= 350;
	            $config['new_image']= './assets/file_po/'.$gbr['file_name'];
	            $this->load->library('image_lib', $config);
	            $this->image_lib->resize();

	            $gambar  =$gbr['file_name'];
				$type    =$gbr['file_type'];
				$ukuran  =$gbr['file_size'];
				$ext1    =explode('.', $gambar);
				$ext     =$ext1[1];
				$lokasi = $gbr['file_name'];
				
			}

		
			$data1 = [
				'upload_sj'				=> $lokasi,	
				'status_confirm'		=>'1',			
				];
				//Edit Data
		    $this->db->where('no_do', $post['no_surat'])->update("tr_delivery_order",$data1);

			

			$numb1 =0;
			foreach($_POST['dt'] as $used){
				$numb1++;      
				$id_detail = $used[id_do];
				$so = $this->db->query("SELECT no_so FROM tr_delivery_order_detail WHERE id_do_detail='$id_detail'")->row();
				$dt =  array(
						'status_kirim'		    => $used[status_kirim],
						'keterangan_statuskirim' => $used[keterangan_statuskirim],
						);
			
				$this->db->where('id_do_detail', $used[id_do])->update("tr_delivery_order_detail",$dt);
				
				   $material = $used[id_category3];
			       $notr     = $post['no_surat'];
				   $qtydo    = 1;

				if($used[status_kirim]=='1')
				{
					$this->kartu_stok_out($material,$qtydo,$notr);
				}
				else if($used[status_kirim]=='0')
				{
					$this->kartu_stok_in($material,$qtydo,$notr);
				}

				

			}


		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$status	= array(
			  'pesan'		=>'Gagal Save Item. Thanks ...',
			  'code' => $code,
			  'status'	=> 0
			);
		} else {
			$this->db->trans_commit();
			$status	= array(
			  'pesan'		=>'Success Save Item. invenThanks ...',
			  'code' => $code,
			  'status'	=> 1
			);
		}

  		echo json_encode($status);



		
    }	


	public function kartu_stok_out($material,$qtyso,$notr)
	{
		
		$mat = $this->db->query("SELECT * FROM stock_material WHERE id_category3='$material' ")->row();

		
        $qty   = (int) $mat->qty      - (int) $qtyso;
		$book  = (int) $mat->qty_book + (int) $qtyso;
		$free  = (int) $mat->qty_free - (int)$qtyso;

		// print_r($free);
		// exit;
		$kartu = [
			'id_category3'		    => $material,
			'qty'		            => $mat->qty,
			'qty_book'			    => $mat->qty_book,
			'qty_free'		        => $mat->qty_free,
			'transaksi'			    => 'delivery order',
			'tgl_transaksi'			=> date('Y-m-d'),
			'no_transaksi'			=> $notr,
			'id_gudang'             => $mat->id_gudang,
			'created_on'			=> date('Y-m-d H:i:s'),
			'created_by'			=> $this->auth->user_id(),
			'qty_transaksi'         => $qtyso,
			'qty_akhir'		        => $qty,
			'qty_book_akhir'	    => $book,
			'qty_free_akhir'		=> $free,	
			'status_transaksi'		=> 'out',			
			];

		$this->db->insert('kartu_stok',$kartu);	   

		$this->db->query("UPDATE stock_material SET qty=qty-$qtyso , qty_book=qty_book-$qtyso  WHERE id_category3='$material'");
	}


	public function kartu_stok_in($material,$qtyso,$notr)
	{
		
		$mat = $this->db->query("SELECT * FROM stock_material WHERE id_category3='$material' ")->row();

		

		$qty   = (int) $mat->qty;
		$book  = (int) $mat->qty_book - (int) $qtyso;
		$free  = (int) $mat->qty_free + (int)$qtyso;

		// print_r($free);
		// exit;
		$kartu = [
			'id_category3'		    => $material, 
			'qty'		            => $mat->qty,
			'qty_book'			    => $mat->qty_book,
			'qty_free'		        => $mat->qty_free,
			'transaksi'			    => 'delivery order',
			'tgl_transaksi'			=> date('Y-m-d'),
			'no_transaksi'			=> $notr,
			'id_gudang'             => $mat->id_gudang,
			'created_on'			=> date('Y-m-d H:i:s'),
			'created_by'			=> $this->auth->user_id(),
			'qty_transaksi'         => $qtyso,
			'qty_akhir'		        => $qty,
			'qty_book_akhir'	    => $book,
			'qty_free_akhir'		=> $free,	
			'status_transaksi'		=> 'in',			
			];

		$this->db->insert('kartu_stok',$kartu);	   

		$this->db->query("UPDATE stock_material SET qty_free=qty_free+$qtyso , qty_book=qty_book-$qtyso  WHERE id_category3='$material'");
	}

	public function printDO($id){
		ob_clean();
		ob_start();
        $this->auth->restrict($this->managePermission);
        $id = $this->uri->segment(3);

		// $data = [
		// 	'status'		        => 3,
		// 	'printed_on'			=> date('Y-m-d H:i:s'),
		// 	'printed_by'			=> $this->auth->user_id()
		// 	];
			//Edit Data
        // $this->db->where('no_penawaran',$id)->update("tr_penawaran",$data);	
		
		$getparam = $id;
		$data['header'] = $this->Wt_delivery_order_model->get_where_in('no_do',$getparam,'tr_delivery_order');  
		$data['detail'] = $this->Wt_delivery_order_model->cariDeliveryOrderDetail($id);  

		$this->load->view('PrintDeliveryOrder',$data);
		$html = ob_get_contents();

		require_once('./assets/html2pdf/html2pdf/html2pdf.class.php');
		$html2pdf = new HTML2PDF('P','Letter','en',true,'UTF-8',array(10, 5, 10, 5));
		$html2pdf->pdf->SetDisplayMode('fullpage');
		$html2pdf->WriteHTML($html);
		ob_end_clean();
		$html2pdf->Output('DeliveryOrder.pdf', 'I');
	}		

	public function approval_planning_do()
    {
        $this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
        $data = $this->Wt_delivery_order_model->cariSalesOrderblmkirim();
        $this->template->set('results', $data);
        $this->template->title('Planning Delivery Order');
        $this->template->render('index_approval_delivery');
    }

	public function modal_approve_pengiriman($id=null){
		$data = [
			'id' => $id
		];
        $this->load->view('approve_pengiriman', $data);

    }

	public function approve_pengiriman()
    {
        $this->auth->restrict($this->addPermission);
		$post = $this->input->post();
		$id		= $post['id'];
		$ket		= $post['ket'];
		
		$this->db->trans_begin();
		$this->db->where('no_so',$id)->update("tr_sales_order",
									 array('approval_finance'=>'1',
									 		'keterangan_kirim'=>$ket, 
											 'approved_on'	=> date('Y-m-d H:i:s'),
											 'approved_by'	=> $this->auth->user_id()
											));

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$status	= array(
			  'pesan'		=>'Gagal Save Item. Thanks ...',
			  'status'	=> 0
			);
		} else {
			$this->db->trans_commit();
			$status	= array(
			  'pesan'		=>'Success Save Item. invenThanks ...',
			  'status'	=> 1
			);
		}
  		echo json_encode($status);
    }

	public function delivery_order_history() 
    {
        $this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
        $data = $this->Wt_delivery_order_model->cariDeliveryOrderhistory();
        $this->template->set('results', $data);
        $this->template->title('Delivery Order');
        $this->template->render('index_deliveryorder_history');
    }
	
	public function history_pengiriman()
    {
        $this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
        $data = $this->Wt_delivery_order_model->cariDeliveryOrderDetailPengiriman();
        $this->template->set('results', $data);
        $this->template->title('Delivery Order');
        $this->template->render('index_deliveryorder_detail');
    }
	 
}