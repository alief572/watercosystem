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
	public function history_planning()
    {
        $this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
        $data = $this->Wt_delivery_order_model->cariSalesOrder();
		$this->template->set('results', $data);
        $this->template->title('Planning Delivery Order');
        $this->template->render('history_planning');
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
		$top       = $this->Wt_penawaran_model->get_data('ms_top','deleted'.$deleted);

		$data = [
			'customers' => $customers,
			'header'=>$header,
			'detail'=>$detail,
			'action'=>'edit',
			'top' => $top,
		];

        $this->template->set('results', $data);
        $this->template->title('Planning Delivery');
        $this->template->render('planning_delivery');

    }

	function GetTop()
    {
		$top=$_GET['top'];		
		$planning = $this->db->query("SELECT a.* FROM ms_top_planning a WHERE a.id_top ='$top'")->result();

		$loop = 0;
		foreach($planning as $plan){
			$loop++;
			
			echo "<tr id='$loop'> 		 
			<td ><input type='hidden' class='form-control input-sm' readonly id='id_top_$loop' required name='dt[$loop][id_top]' value ='$plan->id_top_planning'></td>
			<td ><input type='text' class='form-control input-sm' readonly id='payment_$loop' required name='dt[$loop][payment]' value ='$plan->payment' ></td>
			<td ><input type='text' class='form-control input-sm' readonly id='keterangan_$loop' required name='dt[$loop][keterangan]' value ='$plan->keterangan'></td>
			<td ><input type='text' class='form-control input-sm'  id='persentase_$loop' required name='dt[$loop][persentase]' value ='$plan->persentase' readonly></td>
			<td ><input type='date' class='form-control input-sm'  id='tanggal_$loop' required name='dt[$loop][tanggal]' ></td>
			</tr>";	

			}
		
		
	}

	function SavePlanning(){
		$post = $this->input->post();

		// print_r($post);
		// exit;
		$id   		=  $post['no_so'];
		$code 		= 	$this->Wt_delivery_order_model->generate_codePlanning();
		$no_surat 	= $this->Wt_delivery_order_model->BuatNomorPlanning();

		
		$this->db->trans_begin();
		
		$data = [
					'location'	=> $post['location'],
					'status_planning'	=> '1',
				];
		$this->db->where('no_so',$post['no_so'])->update("tr_sales_order",$data);		

		$numb1 =0;
		for ($i=0;$i<count($post['id_so_detail']);$i++){
			$iddtl    = $post['id_so_detail'][$i];
			$caridt    = $this->db->query("SELECT * FROM tr_sales_order_detail WHERE id_so_detail='$iddtl'")->row();
			$totalplanning  = $post['qty_delivery'][$i] + $caridt->qty_delivery;

			$dt= array(
					'qty_delivery'		=> $totalplanning,
					'schedule'	  		=> $post['schedule'][$i],
					'metode_kirim'		=> $post['metode_kirim'][$i],
					'keterangan_kirim'	=> $post['keterangan_kirim'][$i],     
					'status_planning'	=> '1',           
				 );
			$this->db->where('id_so_detail',$post['id_so_detail'][$i])->update("tr_sales_order_detail",$dt);
		}

		$hd    = $this->db->query("SELECT * FROM tr_sales_order WHERE no_so='$id'")->row();

		$data = [
			'no_planning'			=> $code,
			'no_surat_planning'	    => $no_surat,
			'no_penawaran'			=> $hd->no_penawaran,
			'tgl_so'				=> $hd->tgl_so,
			'id_customer'			=> $hd->id_customer,
			'pic_customer'			=> $hd->pic_customer,
			'mata_uang'			    => $hd->mata_uang,
			'order_status'			=> $hd->order_status,
			'id_sales'			    => $hd->id_sales,
			'nama_sales'			=> $hd->nama_sales,
			'status'			    => $hd->status,
			'status'			    => $hd->status,
			'approval_finance'	    => $hd->approval_finance,
			'location'			    => $post['location'],
			'tgl_planning'		    => date('Y-m-d'),
			'no_so'			        => $post['no_so'],
			'no_surat'				=> $post['no_surat'],
			'top'			        => $post['top'],
			'nilai_so'				=> str_replace(',','',$post['totalproduk']),
			'created_on'			=> date('Y-m-d H:i:s'),
			'created_by'			=> $this->auth->user_id(),
			'ppn'					=> str_replace(',','',$post['ppn']),
			'nilai_ppn'				=> str_replace(',','',$post['totalppn']),
			'grand_total'			=> str_replace(',','',$post['grandtotal']),
			'status_planning'	    => '1', 
			
			];
//Add Data

//    $this->db->delete('tr_sales_order',array('id_so'=>$id));
$this->db->insert('tr_planning_delivery',$data);

$detail =0;
for ($a=0;$a<count($post['id_so_detail']);$a++){

	$iddt  = $post['id_so_detail'][$a];
	$det    = $this->db->query("SELECT * FROM tr_sales_order_detail WHERE id_so_detail='$iddt'")->row();

	$nilaidiskon = $post[diskon][$a] * (str_replace(',','',$post[harga_satuan][$a]) * $post['qty_delivery'][$a] ) / 100;
	
	$dtl= array(		
		'no_planning'	    => $code,
		'id_so_detail'      => $post['id_so_detail'][$a],
		'no_so'			    => $post['no_so'],
		'no_penawaran'	    => $det->no_penawaran,
		'id_category3'	    => $det->id_category3,
		'no_penawaran'	    => $det->no_penawaran,
		'nama_produk'	    => $det->nama_produk,
		
		'qty_delivery'		=> $post['qty_delivery'][$a],
		'schedule'	  		=> $post['tanggal'],

		'qty_so'		    => $post[qty_so][$a],
		'qty'	   			=> $det->qty,
		'harga_satuan'		=> str_replace(',','',$post[harga_satuan][$a]),
		'diskon'		    => $post[diskon][$a],
		'diskon_compare'	=> $det->diskon_compare,
		'qty_terkirim'		=> $det->qty_terkirim,
		'qty_spk'		    => $det->qty_spk,
		'freight_cost'		=> str_replace(',','',$post[freight_cost][$a]),
		'total_harga'	    => str_replace(',','',$post[total_harga][$a]),
		'tgl_delivery'	    => $post[tgl_delivery][$a],
		'created_on'		=> date('Y-m-d H:i:s'),
		'created_by'		=> $this->auth->user_id(),
		'nilai_diskon'		=> $nilaidiskon,  
		'metode_kirim'		=> $post['metode_kirim'][$a],
		'keterangan_kirim'	=> $post['keterangan_kirim'][$a],   
		'status_planning'	=> '1',           
	 );

	 $this->db->insert('tr_planning_delivery_detail',$dtl);

	//    $dt[] =  array(
	// 		   'no_so'		=> $code,
	// 		   'id_penawaran_detail'=> $used[id_penawaran],
	// 		   'no_penawaran'		=> $post['no_penawaran'],
	// 		   'id_category3'		=> $used[no_surat],
	// 		   'nama_produk'	    => $used[nama_produk],
	// 		   'qty_so'			    => $used[qty_so],
	// 		   'qty'			    => $used[qty],
	// 		   'harga_satuan'		=> str_replace(',','',$used[harga_satuan]),
	// 		   'stok_tersedia'		=> $used[stok_tersedia],
	// 		   'potensial_loss'		=> $used[potensial_loss],
	// 		   'diskon'		        => $used[diskon],
	// 		   'freight_cost'		=> str_replace(',','',$used[freight_cost]),
	// 		   'total_harga'	    =>  str_replace(',','',$used[total_harga]),
	// 		   'tgl_delivery'	    => $used[tgl_delivery],
	// 		   'created_on'			=> date('Y-m-d H:i:s'),
	// 		   'created_by'			=> $this->auth->user_id(),
	// 		   'nilai_diskon'		=> str_replace(',','',$used[nilai_diskon])                
	// 		   );
   
}

// $this->db->delete('tr_sales_order_detail',array('id_so'=>$id));
	foreach($_POST['dt'] as $used){

		$nilai  = str_replace(',','',$post['grandtotal']);

		$dtplan[] =  array(   
			'id_top'			    => $post['top'],
			'id_top_planning'		=> $used[id_top],
			'payment'			    => $used[payment],
			'keterangan'		    => $used[keterangan],
			'persentase'			=> $used[persentase],
			'nilai'					=> $nilai,
			'nilai_tagih'			=> round(($used[persentase]*$nilai)/100,2),
			'no_so'			        => $post['no_so'],
			'no_planning'			=> $code,
			'created_on'			=> date('Y-m-d H:i:s'),
			'created_by'			=> $this->auth->user_id(),	
			'tgl_create_inv'		=> $used[tanggal]		
		);

	}

	$this->db->insert_batch('wt_plan_tagih',$dtplan);



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
			$getso = $this->Wt_delivery_order_model->get_where_in('no_planning',$getparam,'tr_planning_delivery');  
			$and = " status_planning ='1' AND qty_delivery > qty_spk";
			$getitemso = $this->Wt_delivery_order_model->get_where_in_and('no_planning',$getparam,$and,'tr_planning_delivery_detail');
			
			$this->template->set('param',$getparam);
			$this->template->set('headerso',$getso);
			$this->template->set('getitemso',$getitemso);
			$this->template->title('Input SPK Delivery');
			$this->template->render('spk_delivery');
	}

	function SaveSpkdelivery(){
		$post = $this->input->post();
		$tanggal = $post['tanggal'];
		// print_r($post);
		// exit;
		$code = 	$this->Wt_delivery_order_model->generate_code();
		$no_surat = $this->Wt_delivery_order_model->BuatNomor($tanggal);

		$data = [
			'no_spk'		        => $code,
			'no_surat'		        => $no_surat,
			'no_planning'			=> $post['no_planning'],
			'no_so'					=> $post['no_so'],
			'location'				=> $post['location'],
			'tgl_spk'				=> $post['tanggal'],
			'id_customer'			=> $post['id_customer'],
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
						'id_planning_delivery'  => $used[id_planning_delivery],
						);
						
			// $this->db->where('id_spk_aktual',$id_spk_aktual);
			// $this->db->delete('dt_spk_aktual');
			
				$this->db->insert('tr_spk_delivery_detail',$dt);

				$idsodet =$used[id_so];
				$idpldet =$used[id_planning_delivery];
				$qtyspk = $used[qty_delivery];

				$this->db->query("UPDATE tr_sales_order_detail SET qty_spk=qty_spk + $qtyspk WHERE id_so_detail='$idsodet'");
				$this->db->query("UPDATE tr_planning_delivery_detail SET qty_spk=qty_spk + $qtyspk WHERE id_planning_delivery='$idpldet'");

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
	public function delivery_order_jurnal()
    {
        $this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
        $data = $this->Wt_delivery_order_model->cariDeliveryOrderjurnal();
        $this->template->set('results', $data);
        $this->template->title('Delivery Order');
        $this->template->render('index_deliveryorder_jurnal');
    }
	
	
	public function createDO($id){
		$session = $this->session->userdata('app_session');
		$getparam = $id;
		$getso = $this->Wt_delivery_order_model->get_where_in('no_spk',$getparam,'tr_spk_delivery');
		$and2 = " status_do ='0' ";		
		$getitemso = $this->Wt_delivery_order_model->get_where_in_and('no_spk',$getparam,$and2,'tr_spk_delivery_detail');  
		$and = " status_planning ='1' ";
		$getitemso2 = $this->Wt_delivery_order_model->get_where_in_and('no_so',$getparam,$and,'tr_sales_order_detail');
		
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
			
		$this->db->trans_begin();

		$tanggal = $post['tanggal'];
		$code = 	$this->Wt_delivery_order_model->generate_code_Do();
		$no_surat = $this->Wt_delivery_order_model->BuatNomorDo($tanggal);
		
		 $data = [
			'no_do'		            => $code,
			'no_surat'		        => $no_surat,
			'id_customer'		    => $post['id_customer'],
			'no_spk'		        => $post['no_spk'],
			'tgl_do'				=> $post['tanggal'],
			'id_customer'			=> $post['id_customer'],
			'created_on'			=> date('Y-m-d H:i:s'),
			'created_by'			=> $this->auth->user_id(),
			'upload_foto'		    => $lokasi,
			'no_invoice'			=> $post['no_invoice'],
			'location'				=> $post['location'],
			];

			$this->db->insert('tr_delivery_order',$data);

		   

            $persendo = 0;
			$totalqty  = 0;
			
			$numb1 =0;
			foreach($_POST['dt'] as $used){
				$numb1++;      
				if($used[kirim]){  
				$qty_dikirim 	=	(int)$used[qty_delivery];
				
				$idmaterial 	= 	$used[id_category3];	
				$noso 			=  	$used[no_so];			
				$cost = $this->db->query("SELECT * FROM ms_costbook WHERE id_category3='$idmaterial'")->row();
				//$so   = $this->db->query("SELECT sum(costbook_so) as qtyso FROM tr_sales_order_detail WHERE no_so='$noso'")->row();
				
				$sobook   = $this->db->query("SELECT costbook_so as qtyso FROM tr_sales_order_detail WHERE no_so='$noso' AND id_category3='$idmaterial' ")->row();
				
				$costbook   = $cost->nilai_costbook;
				$costbookso = $sobook->costbook_so;				
				$totalhppdo   = $qty_dikirim*$costbook;				
				//$totalhpp   = $qty_dikirim*$costbookso;				
				//$totalqty   += (int)$totalhpp;//totalcostbookso*qtydo
				
				
				
				$totalqty    	+=	(int)$used[qty_delivery];
				
				$so   = $this->db->query("SELECT sum(qty_so) as qtyso FROM tr_sales_order_detail WHERE no_so='$noso'")->row();

				$qtyso = (int)$so->qtyso;
				$persen = round(($totalqty/$qtyso)*100);
				$persendo = (int)$persen;
				
				// $qtyso 		= (int)$so->qtyso; //totalcostbookso
				// $persen     = round(($totalqty/$qtyso)*100);				
				// $persendo   = (int)$persen;				
				$updatehpp  = (int)$totalhppdo;
				
				// print_r($$noso );
				// exit;

				
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
						'tgl_delivery'			=> $post['tanggal'],
						'serial_number'			=> $used[serial_number],
						'kartu_garansi'		    => $used[kartu_garansi],
						'created_on'			=> date('Y-m-d H:i:s'),
			            'created_by'			=> $this->auth->user_id(), 
						'cost_book'				=> $cost->nilai_costbook,
						'costbook_so'			=> $sobook->costbook_so,
						'id_planning_delivery'  => $used[id_planning_delivery]
						);
						
			
			
				$this->db->insert('tr_delivery_order_detail',$dt); 
				
				$idspkdt = $used[id_spk];
				$nospk   = $used[no_spk];
				$this->db->query("UPDATE tr_spk_delivery_detail SET status_do='1' WHERE id_spk_detail='$idspkdt'");  
				$this->db->query("UPDATE tr_spk_delivery SET status_create_do='1' WHERE no_spk='$nospk'");  

				$this->db->query("UPDATE tr_sales_order SET total_dikirim=total_dikirim + $qty_dikirim,total_hpp=total_hpp + $updatehpp WHERE no_so='$noso'");
				
				$this->db->query("UPDATE tr_delivery_order SET persen = $persendo, totalcostbook=totalcostbook + $totalhppdo  WHERE no_do='$code'");

				}
				
				

			}
			
			// print_r($persendo );
			// exit;
			
			$this->db->query("UPDATE tr_sales_order SET percent_do=percent_do + $persendo WHERE no_so='$noso'");


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

		

			

			$numb1 =0;
			$totalconfirm=0;
			foreach($_POST['dt'] as $used){
				$numb1++;      
				$id_detail = $used[id_do];
				$so = $this->db->query("SELECT no_so, cost_book, qty_do FROM tr_delivery_order_detail WHERE id_do_detail='$id_detail'")->row();
				$costbook = $so->cost_book*$so->qty_do;
				if($used[status_kirim]=='1')
				{
				$totalconfirm += $costbook;
				}
				$dt =  array(
						'status_kirim'		    => $used[status_kirim],
						'keterangan_statuskirim' => $used[keterangan_statuskirim],
						'modified_on' => date('Y-m-d H:i:s'),
						'confirm_costbook' =>$costbook,
						);
			
				$this->db->where('id_do_detail', $used[id_do])->update("tr_delivery_order_detail",$dt);
				
				   $material = $used[id_category3];
			       $notr     = $post['no_surat'];
				   $nomorsurat = $this->db->query("SELECT no_surat FROM tr_delivery_order WHERE no_do='$notr'")->row();
				   $surat      = $nomorsurat->no_surat;
				   $qtydo    = $used[qty_delivery];

				if($used[status_kirim]=='1')
				{
					$this->kartu_stok_out($material,$qtydo,$notr,$surat);
				}
				else if($used[status_kirim]=='0')
				{
					$this->kartu_stok_in($material,$qtydo,$notr,$surat);
				}

				

			}
			
			
			$data1 = [
				'upload_sj'				=> $lokasi,	
				'status_confirm'		=>'1',	
				'confirm_costbook' 		=> $totalconfirm			
				];
				//Edit Data
		    $this->db->where('no_do', $post['no_surat'])->update("tr_delivery_order",$data1);


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



	public function kartu_stok_out($material,$qtyso,$notr,$surat)
	{
		
		$mat = $this->db->query("SELECT * FROM stock_material WHERE id_category3='$material' ")->row();

		
        $qty   = (int) $mat->qty      - (int) $qtyso;
		$book  = (int) $mat->qty_book - (int) $qtyso;
		$free  = (int) $mat->qty_free;

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
			'no_surat'		        => $surat,					
			];

		$this->db->insert('kartu_stok',$kartu);	   

		$this->db->query("UPDATE stock_material SET qty=qty-$qtyso , qty_book=qty_book-$qtyso  WHERE id_category3='$material'");
	}


	public function kartu_stok_in($material,$qtyso,$notr,$surat)
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
			'no_surat'		        => $surat,				
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
		$html2pdf = new HTML2PDF('P','A4','en',true,'UTF-8',array(10, 5, 10, 5));
		$html2pdf->pdf->SetDisplayMode('fullpage');
		$html2pdf->WriteHTML($html);
		ob_end_clean();
		$html2pdf->Output('DeliveryOrder.pdf', 'I');
	}	
	
	
	
	public function printDOhistory($id){
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
		
		
		$this->load->view('PrintDeliveryOrderHistory',$data);
		$html = ob_get_contents();

		require_once('./assets/html2pdf/html2pdf/html2pdf.class.php');
		$html2pdf = new HTML2PDF('P','A4','en',true,'UTF-8',array(10, 5, 10, 5));
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
		// print_r($data);
		// exit;

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

		$this->db->where('no_so',$id)->update("tr_planning_delivery",
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
	
	public function history_pengiriman_costbook()
    {
        $this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
        $data = $this->Wt_delivery_order_model->cariDeliveryOrderDetailPengiriman();
        $this->template->set('results', $data);
        $this->template->title('Delivery Order');
        $this->template->render('index_deliveryorder_detail_costbook');
    }
	public function pengirimandetail_costbook()
    {
        $this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
        $data = $this->Wt_delivery_order_model->cariDeliveryOrderDetailPengiriman();
        $this->template->set('results', $data);
        $this->template->title('Delivery Order');
        $this->template->render('deliveryorder_detail_costbook');
    }

	public function index_planning()
    {
        $this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
        $data = $this->Wt_delivery_order_model->cariPlanning();

		// print_r($data);
		// exit;

        $this->template->set('results', $data);
        $this->template->title('SO Delivery');
        $this->template->render('index_planning');
    }
	
	function print_do($id){
      $mpdf=new mPDF('utf-8', array(216,279), 10 , 5, 5, 16, 16, 1, 4, 'P');
      $mpdf->SetImportUse();

		$getparam = $id;
		$data['header'] = $this->Wt_delivery_order_model->get_where_in('no_do',$getparam,'tr_delivery_order');  
		$data['detail'] = $this->Wt_delivery_order_model->cariDeliveryOrderDetail($id);  			
        $show = $this->template->load_view('PrintDo_kop',$data);
        

        $kop = '
		      <table border="0px" cellspacing="0" width="100%" valign="top">
				<tr>
					<td align="left"width="50%" valign="top" >
					</td>
					  <td align="right" valign="top" width="50%">
						<br>
						PT WATERCO INDONESIA<br>
						Inkopal Plaza Kelapa Gading Blok B, No.31-32 <br>
						Jl. Boulevard Barat, Jakarta-14240, Indonesia<br>
						Phone: +62 21 4585 1481, Fax: +62 21 4585 1480<br>
						Website: www.waterco.co.id<br>
						E-Mail:waterco@waterco.co.id
						
					</td>
				</tr>
			</table>
			<hr>';

         $this->mpdf->SetHTMLHeader($kop,'1',true);
        


            $this->mpdf->AddPageByArray([
                    'orientation' => 'P',
                    'format'=> [216 ,279],
                    'margin-top' => 45,
                    'margin-bottom' =>10,
                    'margin-left' => 5,
                    'margin-right' => 5,
                    'margin-header' => 0,
                    'margin-footer' => 0,
                ]);
            $this->mpdf->WriteHTML($show);
            $this->mpdf->Output('Deliveryorder.pdf', 'I');

    }


	
	 
}