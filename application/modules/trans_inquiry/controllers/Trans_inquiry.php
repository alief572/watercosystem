<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/*
 * @author Ichsan
 * @copyright Copyright (c) 2019, Ichsan
 *
 * This is controller for Master Supplier
 */

class Trans_inquiry extends Admin_Controller
{
    //Permission
    protected $viewPermission 	= 'Trans_inquiry.View';
    protected $addPermission  	= 'Trans_inquiry.Add';
    protected $managePermission = 'Trans_inquiry.Manage';
    protected $deletePermission = 'Trans_inquiry.Delete';

    public function __construct()
    {
        parent::__construct();

        $this->load->library(array('Mpdf', 'upload', 'Image_lib'));
        $this->load->model(array('Trans_inquiry/Inquiry_model',
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
        $inquiry = $this->Inquiry_model->get_inquiry();
		$data = [
			'inquiry' => $inquiry
		];
        $this->template->set('results', $data);
        $this->template->title('Inquiry');
        $this->template->render('index');
    }
	public function editCustomer($id){
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-edit');
		$aktif = 'active';
		$cus = $this->db->get_where('master_customers',array('id_customer' => $id))->result();
		$pic = $this->db->get_where('child_customer_pic',array('id_customer' => $id))->result();
		$category = $this->Customer_model->get_data('child_customer_category','activation',$aktif);
		$prof = $this->Customer_model->get_data('provinsi');
		$kota = $this->Customer_model->get_data('kota');
		$karyawan = $this->Customer_model->get_data('ms_karyawan');
		$data = [
			'cus'	=> $cus,
			'category' => $category,
			'kota' => $kota,
			'prof' => $prof,
			'pic' => $pic,
			'karyawan' => $karyawan
		];
        $this->template->set('results', $data);
		$this->template->title('Edit Suplier');
        $this->template->render('edit_customer');
		
	}
	public function ViewCategory($id){
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-edit');
		$category = $this->db->get_where('child_supplier_category',array('id_category_supplier' => $id))->result();
		$data = [
			'category' => $category,
		];
        $this->template->set('results', $data);
		$this->template->title('Edit Suplier');
        $this->template->render('view_category');
		
	}
	public function viewInventory(){
		$this->auth->restrict($this->viewPermission);
		$id 	= $this->input->post('id');
		$inven = $this->db->get_where('ms_inventory_category1',array('id_category1' => $id))->result();
		$deleted ='0';
		$komposisi = $this->db->get_where('ms_compotition',array('id_category1' => $id, 'deleted' => $deleted))->result();
		$lvl1 = $this->Inventory_2_model->get_data('ms_inventory_type');
		$data = [
			'inven' => $inven,
			'komposisi' => $komposisi,
			'lvl1' => $lvl1
		];
        $this->template->set('results', $data);
		$this->template->render('view_inventory');
	}
	public function get_idcust(){
	  $id_customer=$this->input->post('id_customer');
	  $data=$this->Inquiry_model->get_bynama($id_customer);
	  echo json_encode($data);
	}
		function getcustomer()
    {
        $id_customer=$_GET['id_customer'];
        $dim=$this->Inquiry_model->cariemail($id_customer);
		$data=$this->Inquiry_model->caripic($id_customer);
		$numb = 0;
                foreach ($dim as $key => $ensi):
		$numb++;
			echo "
		<div class='col-sm-6'>
		<div class='form-group row'>
			<div class='col-md-4'>
				<label for='email_customer'>EMAIL</label>
			</div>
			<div class='col-md-8'>
				<input type='email' class='form-control' id='email_customer' value='$ensi->email' required name='email_customer' >
			</div>
		</div>
		</div>";
                endforeach;
		$numb2 = 0;
			echo"
		<div class='col-sm-6'>
			<div class='form-group row'>
				<div class='col-md-4'>
					<label for='id_category_supplier'>PIC CUSTOMER</label>
				</div>
				<div class='col-md-8'>
					<select id='pic_customer' name='pic_customer' class='form-control select' required>
						<option value=''>--Pilih--</option>";
				foreach ($data as $key => $ensik):
			echo"
						<option value='$ensik->name_pic'>$ensik->name_pic</option>
				";
				endforeach;
			echo"
					</select>
				</div>
			</div>
		</div>
			";
    }
	public function addInquiry()
    {
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$aktif = 'active';
		$deleted = '0';
		$customers = $this->Inquiry_model->get_data('master_customers','deleted',$deleted);
		$karyawan = $this->Inquiry_model->get_data('ms_karyawan','deleted',$deleted);
		$bentuk = $this->Inquiry_model->get_data('ms_bentuk','deleted',$deleted);
		$data = [
			'customers' => $customers,
			'karyawan' => $karyawan,
			'bentuk' => $bentuk,
		];
        $this->template->set('results', $data);
        $this->template->title('Add Customer');
        $this->template->render('add_inq');

    }
	
	public function addInternational()
    {
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$category = $this->Suplier_model->get_data('child_supplier_category');
		$negara = $this->Suplier_model->get_data('negara');
		$data = [
			'category' => $category,
			'negara' => $negara
		];
        $this->template->set('results', $data);
        $this->template->title('Add Suplier Local');
        $this->template->render('add_international');

    }
	public function addCategory()
    {
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
        $this->template->title('Add Customer Local');
        $this->template->render('add_category');

    }

	public function delDetail(){
		$this->auth->restrict($this->deletePermission);
		$id = $this->input->post('id');
		// print_r($id);
		// exit();
		$data = [
			'deleted' 		=> '1',
			'deleted_by' 	=> $this->auth->user_id()
		];
		
		$this->db->trans_begin();
		$this->db->where('id_compotition',$id)->update("ms_compotition",$data);
		
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

	public function deleteCategory(){
		$this->auth->restrict($this->deletePermission);
		$id = $this->input->post('id');
		// print_r($id);
		// exit();
		$data = [
			'activation' 		=> 'inactive',
			'deleted_by' 	=> $this->auth->user_id()
		];
		$this->db->trans_begin();
		$this->db->where('id_category_customer',$id)->update("child_customer_category",$data);
		
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
	public function deletelokal(){
		$this->auth->restrict($this->deletePermission);
		$id = $this->input->post('id');
		// print_r($id);
		// exit();
		$data = [
			'deleted' 		=> '1',
			'deleted_by' 	=> $this->auth->user_id()
		];
		$this->db->trans_begin();
		$this->db->where('id_suplier',$id)->update("master_supplier",$data);
		
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
		public function deleteinternational(){
		$this->auth->restrict($this->deletePermission);
		$id = $this->input->post('id');
		// print_r($id);
		// exit();
		$data = [
			'deleted' 		=> '1',
			'deleted_by' 	=> $this->auth->user_id()
		];
		$this->db->trans_begin();
		$this->db->where('id_suplier',$id)->update("master_supplier",$data);
		
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
	public function saveNewCategory()
    {
        $this->auth->restrict($this->addPermission);
		$post = $this->input->post();
		$code = $this->Customer_model->generate_Category();
		$this->db->trans_begin();
		$data = [
			'id_category_customer'		=> $code,
			'name_category_customer'	=> $post['name_category_customer'],
			'customer_code'				=> $post['customer_code'],
			'activation'				=> 'active',
			'created_on'				=> date('Y-m-d H:i:s'),
			'created_by'				=> $this->auth->user_id()
		];
		
		$insert = $this->db->insert("child_customer_category",$data);
		
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
		public function saveNewcustomer()
    {
        $this->auth->restrict($this->addPermission);
		$post = $this->input->post();
		if(isset($post['senin'])){$senin = 'Y';}else{$senin = 'N';};
		if(isset($post['selasa'])){$selasa = 'Y';}else{$selasa = 'N';};
		if(isset($post['rabu'])){$rabu = 'Y';}else{$rabu = 'N';};
		if(isset($post['kamis'])){$kamis = 'Y';}else{$kamis = 'N';};
		if(isset($post['jumat'])){$jumat = 'Y';}else{$jumat = 'N';};
		if(isset($post['sabtu'])){$sabtu = 'Y';}else{$sabtu = 'N';};
		if(isset($post['minggu'])){$minggu = 'Y';}else{$minggu = 'N';};
		if(isset($post['berita_acara'])){$berita_acara = 'Y';}else{$berita_acara = 'N';};
		if(isset($post['faktur'])){$faktur = 'Y';}else{$faktur = 'N';};
		if(isset($post['tdp'])){$tdp = 'Y';}else{$tdp = 'N';};
		if(isset($post['real_po'])){$real_po = 'Y';}else{$real_po = 'N';};
		if(isset($post['ttd_specimen'])){$ttd_specimen = 'Y';}else{$ttd_specimen = 'N';};
		if(isset($post['payement_certificate'])){$payement_certificate = 'Y';}else{$payement_certificate = 'N';};
		if(isset($post['photo'])){$photo = 'Y';}else{$photo = 'N';};
		if(isset($post['siup'])){$siup = 'Y';}else{$siup = 'N';};
		if(isset($post['spk'])){$spk = 'Y';}else{$spk = 'N';};
		if(isset($post['delivery_order'])){$delivery_order = 'Y';}else{$delivery_order = 'N';};
		if(isset($post['need_npwp'])){$need_npwp = 'Y';}else{$need_npwp = 'N';};
		$session = $this->session->userdata('app_session');
		$code = $this->Customer_model->generate_id();
		$this->db->trans_begin();
					$header1 =  array(
							'id_customer'	 		=> $code,
							'id_category_customer'	=> $post['id_category_customer'],
							'name_customer'		    => $post['name_customer'],
							'telephone'		    	=> $post['telephone'],
							'telephone_2'		    => $post['telephone_2'],
							'fax'		    		=> $post['fax'],
							'email'			    	=> $post['email'],
							'start_date'		    => $post['start_date'],
							'id_karyawan'		    => $post['id_karyawan'],
							'id_prov'		    	=> $post['id_prov'],
							'id_kota'		    	=> $post['id_kota'],
							'address_office'		=> $post['address_office'],
							'zip_code'		    	=> $post['zip_code'],
							'longitude'		    	=> $post['longitude'],
							'latitude'		    	=> $post['latitude'],
							'activation'		    => $post['activation'],
							'facility'		   		=> $post['facility'],
							'name_bank'		    	=> $post['name_bank'],
							'no_rekening'		    => $post['no_rekening'],
							'nama_rekening'		    => $post['nama_rekening'],
							'alamat_bank'		    => $post['alamat_bank'],
							'swift_code'		    => $post['swift_code'],
							'npwp'		   			=> $post['npwp'],
							'npwp_name'		    	=> $post['npwp_name'],
							'npwp_address'		    => $post['npwp_address'],
							'payment_term'		    => $post['payment_term'],
							'nominal_dp'		    => $post['nominal_dp'],
							'sisa_pembayaran'		=> $post['sisa_pembayaran'],
							'start_recive'			=> $post['start_recive'],
							'end_recive'			=> $post['end_recive'],
							'adress_invoice'		=> $post['address_invoice'],
							'senin'					=> $senin,
							'selasa'				=> $selasa,
							'rabu'					=> $rabu,
							'kamis'					=> $kamis,
							'jumat'					=> $jumat,
							'sabtu'					=> $sabtu,
							'minggu'				=> $minggu,
							'berita_acara'			=> $berita_acara,
							'faktur'				=> $faktur,
							'tdp'					=> $tdp,
							'real_po'				=> $real_po,
							'ttd_specimen'			=> $ttd_specimen,
							'payement_certificate'	=> $payement_certificate,
							'photo'					=> $photo,
							'siup'					=> $siup,
							'spk'					=> $spk,
							'delivery_order'		=> $delivery_order,
							'need_npwp'				=> $need_npwp,
							'deleted'				=> '0',
							'created_on'			=> date('Y-m-d H:i:s'),
							'created_by'			=> $this->auth->user_id()
                            );
            //Add Data
              $this->db->insert('master_customers',$header1);
		$numb2 =0;
		foreach($_POST['data1'] as $d1){
		$numb2++;
              $data =  array(
			                    'id_customer'	=>$code, 
								'name_pic'		=>$d1[name_pic],
								'phone_pic'		=>$d1[phone_pic],
								'email_pic'		=>$d1[email_pic],
								'position_pic'	=>$d1[position_pic] 
                            );
            //Add Data
              $this->db->insert('child_customer_pic',$data);
		    }
		
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
	public function saveEditcustomer()
    {
        $this->auth->restrict($this->addPermission);
		$post = $this->input->post();
		if(isset($post['senin'])){$senin = 'Y';}else{$senin = 'N';};
		if(isset($post['selasa'])){$selasa = 'Y';}else{$selasa = 'N';};
		if(isset($post['rabu'])){$rabu = 'Y';}else{$rabu = 'N';};
		if(isset($post['kamis'])){$kamis = 'Y';}else{$kamis = 'N';};
		if(isset($post['jumat'])){$jumat = 'Y';}else{$jumat = 'N';};
		if(isset($post['sabtu'])){$sabtu = 'Y';}else{$sabtu = 'N';};
		if(isset($post['minggu'])){$minggu = 'Y';}else{$minggu = 'N';};
		if(isset($post['berita_acara'])){$berita_acara = 'Y';}else{$berita_acara = 'N';};
		if(isset($post['faktur'])){$faktur = 'Y';}else{$faktur = 'N';};
		if(isset($post['tdp'])){$tdp = 'Y';}else{$tdp = 'N';};
		if(isset($post['real_po'])){$real_po = 'Y';}else{$real_po = 'N';};
		if(isset($post['ttd_specimen'])){$ttd_specimen = 'Y';}else{$ttd_specimen = 'N';};
		if(isset($post['payement_certificate'])){$payement_certificate = 'Y';}else{$payement_certificate = 'N';};
		if(isset($post['photo'])){$photo = 'Y';}else{$photo = 'N';};
		if(isset($post['siup'])){$siup = 'Y';}else{$siup = 'N';};
		if(isset($post['spk'])){$spk = 'Y';}else{$spk = 'N';};
		if(isset($post['delivery_order'])){$delivery_order = 'Y';}else{$delivery_order = 'N';};
		if(isset($post['need_npwp'])){$need_npwp = 'Y';}else{$need_npwp = 'N';};
		$session = $this->session->userdata('app_session');
		$this->db->trans_begin();
					$header1 =  array(
							'id_category_customer'	=> $post['id_category_customer'],
							'name_customer'		    => $post['name_customer'],
							'telephone'		    	=> $post['telephone'],
							'telephone_2'		    => $post['telephone_2'],
							'fax'		    		=> $post['fax'],
							'email'			    	=> $post['email'],
							'start_date'		    => $post['start_date'],
							'id_karyawan'		    => $post['id_karyawan'],
							'id_prov'		    	=> $post['id_prov'],
							'id_kota'		    	=> $post['id_kota'],
							'address_office'		=> $post['address_office'],
							'zip_code'		    	=> $post['zip_code'],
							'longitude'		    	=> $post['longitude'],
							'latitude'		    	=> $post['latitude'],
							'activation'		    => $post['activation'],
							'facility'		   		=> $post['facility'],
							'name_bank'		    	=> $post['name_bank'],
							'no_rekening'		    => $post['no_rekening'],
							'nama_rekening'		    => $post['nama_rekening'],
							'alamat_bank'		    => $post['alamat_bank'],
							'swift_code'		    => $post['swift_code'],
							'npwp'		   			=> $post['npwp'],
							'npwp_name'		    	=> $post['npwp_name'],
							'npwp_address'		    => $post['npwp_address'],
							'payment_term'		    => $post['payment_term'],
							'nominal_dp'		    => $post['nominal_dp'],
							'sisa_pembayaran'		=> $post['sisa_pembayaran'],
							'start_recive'			=> $post['start_recive'],
							'end_recive'			=> $post['end_recive'],
							'adress_invoice'		=> $post['address_invoice'],
							'senin'					=> $senin,
							'selasa'				=> $selasa,
							'rabu'					=> $rabu,
							'kamis'					=> $kamis,
							'jumat'					=> $jumat,
							'sabtu'					=> $sabtu,
							'minggu'				=> $minggu,
							'berita_acara'			=> $berita_acara,
							'faktur'				=> $faktur,
							'tdp'					=> $tdp,
							'real_po'				=> $real_po,
							'ttd_specimen'			=> $ttd_specimen,
							'payement_certificate'	=> $payement_certificate,
							'photo'					=> $photo,
							'siup'					=> $siup,
							'spk'					=> $spk,
							'delivery_order'		=> $delivery_order,
							'need_npwp'				=> $need_npwp,
							'deleted'				=> '0',
							'created_on'			=> date('Y-m-d H:i:s'),
							'created_by'			=> $this->auth->user_id()
                            );
            //Add Data
               $this->db->where('id_customer',$post['id_customer'])->update("master_customers",$header1);
			  $this->db->delete('child_customer_pic', array('id_customer' => $post['id_customer']));
		$numb2 =0;
		foreach($_POST['data1'] as $d1){
		$numb2++;
		$code = $post['id_customer'];
              $data =  array(
			                    'id_customer'	=>$code, 
								'name_pic'		=>$d1[name_pic],
								'phone_pic'		=>$d1[phone_pic],
								'email_pic'		=>$d1[email_pic],
								'position_pic'	=>$d1[position_pic] 
                            );
            //Add Data
              $this->db->insert('child_customer_pic',$data);
		    }
		
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
	public function saveNewInternational()
    {
		
		
        $this->auth->restrict($this->addPermission);
		$post = $this->input->post();
		$session = $this->session->userdata('app_session');
		$code = $this->Suplier_model->generate_id();
		$this->db->trans_begin();
					$header1 =  array(
							'id_suplier'	 		=> $code,
							'id_category_supplier'	=> $post['id_category_supplier'],
							'suplier_location'		=> 'international',
							'name_suplier'		    => $post['name_suplier'],
							'telephone'		    	=> $post['telephone'],
							'telephone_2'		    => $post['telephone_2'],
							'fax'		    		=> $post['fax'],
							'email'			    	=> $post['email'],
							'start_date'		    => $post['start_date'],
							'id_negara'		    	=> $post['id_negara'],
							'international_prov'	=> $post['international_prov'],
							'international_kota'	=> $post['international_kota'],
							'address_office'		=> $post['address_office'],
							'zip_code'		    	=> $post['zip_code'],
							'longitude'		    	=> $post['longitude'],
							'latitude'		    	=> $post['latitude'],
							'activation'		    => $post['activation'],
							'name_bank'		    	=> $post['name_bank'],
							'no_rekening'		    => $post['no_rekening'],
							'nama_rekening'		    => $post['nama_rekening'],
							'alamat_bank'		    => $post['alamat_bank'],
							'swift_code'		    => $post['swift_code'],
							'payment_term'		    => $post['payment_term'],
							'deleted'				=> '0',
							'created_on'			=> date('Y-m-d H:i:s'),
							'created_by'			=> $this->auth->user_id()
                            );
            //Add Data
              $this->db->insert('master_supplier',$header1);
		$numb2 =0;
		foreach($_POST['data1'] as $d1){
		$numb2++;
              $data =  array(
			                    'id_suplier'	=>$code, 
								'name_pic'		=>$d1[name_pic],
								'phone_pic'		=>$d1[phone_pic],
								'email_pic'		=>$d1[email_pic],
								'position_pic'	=>$d1[position_pic] 
                            );
            //Add Data
              $this->db->insert('child_supplier_pic',$data);
		    }
		
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
	public function saveEditLocal()
    {
		
		
        $this->auth->restrict($this->addPermission);
		$post = $this->input->post();
		$session = $this->session->userdata('app_session');
		$this->db->trans_begin();
					$header1 =  array(
							'id_category_supplier'	=> $post['id_category_supplier'],
							'suplier_location'		=> 'local',
							'name_suplier'		    => $post['name_suplier'],
							'telephone'		    	=> $post['telephone'],
							'telephone_2'		    => $post['telephone_2'],
							'fax'		    		=> $post['fax'],
							'email'			    	=> $post['email'],
							'start_date'		    => $post['start_date'],
							'id_prov'		    	=> $post['id_prov'],
							'id_kota'		    	=> $post['id_kota'],
							'address_office'		=> $post['address_office'],
							'zip_code'		    	=> $post['zip_code'],
							'longitude'		    	=> $post['longitude'],
							'latitude'		    	=> $post['latitude'],
							'activation'		    => $post['activation'],
							'name_bank'		    	=> $post['name_bank'],
							'no_rekening'		    => $post['no_rekening'],
							'nama_rekening'		    => $post['nama_rekening'],
							'alamat_bank'		    => $post['alamat_bank'],
							'swift_code'		    => $post['swift_code'],
							'npwp'		   			=> $post['npwp'],
							'npwp_name'		    	=> $post['npwp_name'],
							'npwp_address'		    => $post['npwp_address'],
							'payment_term'		    => $post['payment_term'],
							'deleted'				=> '0',
							'created_on'			=> date('Y-m-d H:i:s'),
							'created_by'			=> $this->auth->user_id()
                            );
            //Add Data
              $this->db->where('id_suplier',$post['id_suplier'])->update("master_supplier",$header1);
			  $this->db->delete('child_supplier_pic', array('id_suplier' => $post['id_suplier']));
		$numb2 =0;
		foreach($_POST['data1'] as $d1){
		$numb2++;
		$code = $post['id_suplier'];
              $data =  array(
			                    'id_suplier'	=>$code, 
								'name_pic'		=>$d1[name_pic],
								'phone_pic'		=>$d1[phone_pic],
								'email_pic'		=>$d1[email_pic],
								'position_pic'	=>$d1[position_pic] 
                            );
            //Add Data
              $this->db->insert('child_supplier_pic',$data);
		    }
		
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
	public function saveEditInternational()
    {
		
		
        $this->auth->restrict($this->addPermission);
		$post = $this->input->post();
		$session = $this->session->userdata('app_session');
		$this->db->trans_begin();
					$header1 =  array(
							'id_category_supplier'	=> $post['id_category_supplier'],
							'suplier_location'		=> 'international',
							'name_suplier'		    => $post['name_suplier'],
							'telephone'		    	=> $post['telephone'],
							'telephone_2'		    => $post['telephone_2'],
							'fax'		    		=> $post['fax'],
							'email'			    	=> $post['email'],
							'start_date'		    => $post['start_date'],
							'id_negara'		    	=> $post['id_negara'],
							'international_prov'	=> $post['international_prov'],
							'international_kota'	=> $post['international_kota'],
							'address_office'		=> $post['address_office'],
							'zip_code'		    	=> $post['zip_code'],
							'longitude'		    	=> $post['longitude'],
							'latitude'		    	=> $post['latitude'],
							'activation'		    => $post['activation'],
							'name_bank'		    	=> $post['name_bank'],
							'no_rekening'		    => $post['no_rekening'],
							'nama_rekening'		    => $post['nama_rekening'],
							'alamat_bank'		    => $post['alamat_bank'],
							'swift_code'		    => $post['swift_code'],
							'payment_term'		    => $post['payment_term'],
							'deleted'				=> '0',
							'created_on'			=> date('Y-m-d H:i:s'),
							'created_by'			=> $this->auth->user_id()
                            );
            //Add Data
               $this->db->where('id_suplier',$post['id_suplier'])->update("master_supplier",$header1);
			  $this->db->delete('child_supplier_pic', array('id_suplier' => $post['id_suplier']));
		$code = $post['id_suplier'];
		$numb2 =0;
		foreach($_POST['data1'] as $d1){
		$numb2++;
              $data =  array(
			                    'id_suplier'	=>$code, 
								'name_pic'		=>$d1[name_pic],
								'phone_pic'		=>$d1[phone_pic],
								'email_pic'		=>$d1[email_pic],
								'position_pic'	=>$d1[position_pic] 
                            );
            //Add Data
              $this->db->insert('child_supplier_pic',$data);
		    }
		
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
	public function saveEditCategory(){
		$this->auth->restrict($this->editPermission);
		$post = $this->input->post();
		$this->db->trans_begin();
		$data = [
			'name_category_customer'	=> $post['name_category_customer'],
			'customer_code'				=> $post['customer_code'],
			'modified_on'		=> date('Y-m-d H:i:s'),
			'modified_by'		=> $this->auth->user_id()
		];
	 
		$this->db->where('id_category_customer',$post['id_category_customer'])->update("child_customer_category",$data);
		
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
	public function saveEditinventory()
    {
        $this->auth->restrict($this->addPermission);
		$session = $this->session->userdata('app_session');
		$this->db->trans_begin();
		
		$numb1 =0;
		foreach($_POST['hd1'] as $h1){
		$numb1++;	
		        $produk = $_POST['hd1']['1']['id_inventory'];
                $header1 =  array(
							'id_type'		    => $h1[inventory_1],
							'nama'		        => $h1[nm_inventory],
							'modified_on'		=> date('Y-m-d H:i:s'),
							'modified_by'		=> $this->auth->user_id(),
							'deleted'			=> '0' 
                            );
            //Add Data
			 $this->db->where('id_category1',$produk)->update("ms_inventory_category1",$header1);
		    }	
		if(empty($_POST['data1'])){
		}else{
		$numb2 =0;
		foreach($_POST['data1'] as $d1){
		$numb2++;	
		
		      $code = $_POST['hd1']['1']['id_inventory'];    
              $data1 =  array(
			                    'id_category1'=>$code, 
								'name_compotition'=>$d1[name_compotition],
								'deleted' =>'0',
							    'created_on' => date('Y-m-d H:i:s'),
								'created_by' => $session['id_user'], 
                            );
            //Add Data
              $this->db->insert('ms_compotition',$data1);
		    }		
		}
		$numb3 =0;
		foreach($_POST['data2'] as $d2){
		$numb3++;	
		
		      $info = $d2['id_compotition'];    
              $data2 =  array(
								'name_compotition'=>$d2[name_compotition],
								'deleted' =>'0',
							    'modified_on' => date('Y-m-d H:i:s'),
								'modified_by' => $session['id_user'], 
                            );
            //Add Data
             $this->db->where('id_compotition',$info)->update("ms_compotition",$data2);
		    }	         		
	
		
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

	
		function getpic()
    {
        $id_customer=$_GET['id_customer'];
        $data=$this->Inquiry_model->caripic($id_customer);
		 echo "<option value=''>--Pilih--</option>";
                foreach ($data as $key => $st) :
				      echo "<option value='$st->id_customer' set_select('name_pic', $st->id_customer, isset($data->id_customer) && $data->id_customer == $st->id_customer)>$st->name_pic
                    </option>";
                endforeach;
        echo "</select>";
    }
		function getemail()
    {
        $id_customer=$_GET['id_customer'];
        $data1=$this->Inquiry_model->cariemail($id_customer);
		foreach ($data1 as $key => $st) :
		$data_email = array('email_customer'   =>  $st['email'],);
		endforeach;
		echo json_encode($data_email);
    }
	public function saveNewinventoryold()
    {
        $this->auth->restrict($this->addPermission);
		$post = $this->input->post();
		$code = $this->Suplier_model->generate_id();
		$this->db->trans_begin();
		$data = [
			'id_category1'	 	=> $code,
			'id_type'		    => $post['inventory_1'],
			'nama'		        => $post['nm_inventory'],
			'aktif'				=> 'aktif',
			'created_on'		=> date('Y-m-d H:i:s'),
			'created_by'		=> $this->auth->user_id(),
			'deleted'			=> '0'
		];
		
		$insert = $this->db->insert("ms_inventory_category1",$data);
		
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
	
	//arwant
	public function get_product(){
		$bentuk = $this->uri->segment(3);
		$query	 	= "SELECT * FROM ms_inventory_category3 WHERE id_bentuk='".$bentuk."'";
		$Q_result	=  $this->Inquiry_model->get_data_category3($bentuk);
		if(!empty($Q_result)){
			$option 	= "<option value='0'>Select an Option</option>";
			foreach($Q_result as $row)	{
				$option .= "<option value='".$row->id_category3."'>".strtoupper(strtolower($row->nama_category2)).".".strtoupper(strtolower($row->nama)).".".strtoupper(strtolower($row->hardness))."</option>";
			}
		}
		if(empty($Q_result)){
			$option 	= "<option value='0'>Data not found</option>";
		}
		echo json_encode(array(
		'option' => $option
		));
	}
	function get_dimensi()
    {
        $produk = $_GET['produk'];
		$nomor = $_GET['nomor'];
        $dim		=  $this->Inquiry_model->get_data_dimensi($produk);
		$numb = 0;
                foreach ($dim as $key => $ensi):
		$numb++;
			echo "
		$ensi->nm_dimensi<input type='email' class='form-control' id='email_customer' value='$ensi->email' required name='email_customer' >
		";
                endforeach;
    }
			function getForm()
    {
        $bentuk=$_GET['bentuk'];
		$nomor=$_GET['nomor'];
        if($bentuk == "B2000001"){
			echo"
			<table table table-bordered table-striped>
			</table>
			";
		}
		elseif($bentuk == "B2000002"){
			echo"
			<table table table-bordered table-striped>
			</table>
			";
		}
		elseif($bentuk == "B2000003"){
		$produk		=  $this->Inquiry_model->get_data_category3($bentuk);
		echo"
		<div class='col-sm-6'>
			<div class='form-group row'>
				<div class='col-md-4'>
					<label for='produk'>Produk</label>
				</div>
				<div class='col-md-8'>
					<select id='produk_$nomor' name='data1[$nomor]produk' data-no='$nomor' class='form-control select get_dimensirb()' required>
						<option value=''>--Pilih--</option>
							foreach ($produk as $prod){
						<option value='$prod->id_customer'>.strtoupper(strtolower($row->nama_category2)).'.'.strtoupper(strtolower($row->nama)).'.'.strtoupper(strtolower($row->hardness)).</option>
							<?php } ?>
					</select>
				</div>
			</div>
		</div>
		<div class='col-sm-6'>
			<div class='form-group row'>
				<div class='col-md-4'>
					<label for='diameter'>Diameter</label>
				</div>
				<div class='col-md-8'>
					<input type='text' class='form-control' id='diameter_$nomor' value='$ensi->email' onkeyup='HitungMasa()' required name='data1[$nomor]diameter' >
				</div>
			</div>
		</div>
		<div class='col-sm-6'>
			<div class='form-group row'>
				<div class='col-md-4'>
					<label for='length'>Length</label>
				</div>
				<div class='col-md-8'>
					<input type='text' class='form-control' id='length_$nomor' value='$ensi->email' onkeyup='HitungMasa()' required name='data1[$nomor]length' >
				</div>
			</div>
		</div>
		<div class='col-sm-6'>
			<div class='form-group row'>
				<div class='col-md-4'>
					<label for='length'>Length</label>
				</div>
				<div class='col-md-8'>
					<input type='text' class='form-control' id='length_$nomor' value='$ensi->email' required name='data1[$nomor]length' >
				</div>
			</div>
		</div>
		<div class='col-sm-6'>
			<div class='form-group row'>
				<div class='col-md-4'>
					<label for='denstity'>Density</label>
				</div>
				<div class='col-md-8'>
					<input type='text' class='form-control' id='density_$nomor' value='$ensi->email' required name='data1[$nomor]density' >
				</div>
			</div>
		</div>
		<div class='col-sm-6'>
			<div class='form-group row'>
				<div class='col-md-4'>
					<label for='berat'>Berat Satuan</label>
				</div>
				<div class='col-md-8'>
					<input type='text' class='form-control' id='berat_$nomor' required name='data1[$nomor]berat' >
				</div>
			</div>
		</div>
		<div class='col-sm-6'>
			<div class='form-group row'>
				<div class='col-md-4'>
					<label for='berat'>Jumlah Order</label>
				</div>
				<div class='col-md-8'>
					<input type='text' class='form-control' id='qty_$nomor' onkeyup='HitungBerat()' required name='data1[$nomor]qty' >
				</div>
			</div>
		</div>
		<div class='col-sm-6'>
			<div class='form-group row'>
				<div class='col-md-4'>
					<label for='berat'>Berat Total</label>
				</div>
				<div class='col-md-8'>
					<input type='text' class='form-control' id='berat_total_$nomor' required name='data1[$nomor]berat_total' >
				</div>
			</div>
		</div>
		<div class='col-sm-6'>
			<div class='form-group row'>
				<div class='col-md-4'>
					<label for='berat'>Rata-Rata PErbulan</label>
				</div>
				<div class='col-md-8'>
					<input type='text' class='form-control' id='rerata_$nomor' required name='data1[$nomor]rerata' >
				</div>
			</div>
		</div>
		<div class='col-sm-6'>
			<div class='form-group row'>
				<div class='col-md-4'>
					<label for='berat'>Targat Harga</label>
				</div>
				<div class='col-md-8'>
					<input type='text' class='form-control' id='harga_$nomor' required name='data1[$nomor]harga' >
				</div>
			</div>
		</div>
		<div class='col-sm-6'>
			<div class='form-group row'>
				<div class='col-md-4'>
					<label for='berat'>Master Sample</label>
				</div>
				<div class='col-md-8'>
						<select id='sample_$nomor' name='data1[$nomor]sample' data-no='$nomor' class='form-control select' required>
						<option value='No'>No</option>
						<option value='Yes'>Yes</option>
					</select>
				</div>
			</div>
		</div>
			";
		}
		elseif($bentuk == "B2000004"){
			echo"
			<table table table-bordered table-striped>
			</table>
			";
		}
		elseif($bentuk == "B2000005"){
			echo"
			<table table table-bordered table-striped>
			</table>
			";
		}
		elseif($bentuk == "B2000006"){
			echo"
			<table table table-bordered table-striped>
			</table>
			";
		}
		elseif($bentuk == "B2000007"){
			echo"
			<table table table-bordered table-striped>
			</table>
			";
		}
		elseif($bentuk == "B2000008"){
			echo"
			<table table table-bordered table-striped>
			</table>
			";
		}
		elseif($bentuk == "B2000009"){
			echo"
			<table table table-bordered table-striped>
			</table>
			";
		}
		
    }
	
}
