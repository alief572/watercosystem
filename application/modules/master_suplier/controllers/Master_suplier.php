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

class Master_suplier extends Admin_Controller
{
    //Permission
    protected $viewPermission 	= 'Master_Supplier.View';
    protected $addPermission  	= 'Master_Supplier.Add';
    protected $managePermission = 'Master_Supplier.Manage';
    protected $deletePermission = 'Master_Supplier.Delete';

    public function __construct()
    {
        parent::__construct();

        $this->load->library(array('Mpdf', 'upload', 'Image_lib'));
        $this->load->model(array('Master_suplier/Suplier_model',
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
		$deleted = 'active';
        $category = $this->Suplier_model->get_data('child_supplier_category','activation',$deleted);
		$lokal 			= $this->Suplier_model->getlokal();
		$international = $this->Suplier_model->getinternational();
		$data = [
			'lokal' => $lokal,
			'international' => $international,
			'category' => $category
		];
        $this->template->set('results', $data);
        $this->template->title('Master Suplier');
        $this->template->render('index');
    }
	public function EditLokal($id){
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-edit');
		$deleted ='active';
		$sup = $this->db->get_where('master_supplier',array('id_suplier' => $id))->result();
		$category = $this->Suplier_model->get_data('child_supplier_category','activation',$deleted);
		$pic = $this->db->get_where('child_supplier_pic',array('id_suplier' => $id))->result();
		$prof = $this->Suplier_model->get_data('provinsi');
		$kota = $this->Suplier_model->get_data('kota');
		$data = [
			'sup' => $sup,
			'category' => $category,
			'prof' => $prof,
			'kota' => $kota,
			'pic' => $pic
		];
        $this->template->set('results', $data);
		$this->template->title('Edit Suplier');
        $this->template->render('edit_lokal');
		
	}
	public function viewLokal($id){
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-edit');
		$deleted ='active';
		$sup = $this->db->get_where('master_supplier',array('id_suplier' => $id))->result();
		$category = $this->Suplier_model->get_data('child_supplier_category','activation',$deleted);
		$pic = $this->db->get_where('child_supplier_pic',array('id_suplier' => $id))->result();
		$prof = $this->Suplier_model->get_data('provinsi');
		$kota = $this->Suplier_model->get_data('kota');
		$data = [
			'sup' => $sup,
			'category' => $category,
			'prof' => $prof,
			'kota' => $kota,
			'pic' => $pic
		];
        $this->template->set('results', $data);
		$this->template->title('Edit Suplier');
        $this->template->render('view_local');
		
	}
	public function EditInternasional($id){
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-edit');
		$deleted ='active';
		$sup = $this->db->get_where('master_supplier',array('id_suplier' => $id))->result();
		$category = $this->Suplier_model->get_data('child_supplier_category','activation',$deleted);
		$pic = $this->db->get_where('child_supplier_pic',array('id_suplier' => $id))->result();
		$negara = $this->Suplier_model->get_data('negara');
		$data = [
			'sup' => $sup,
			'category' => $category,
			'negara' => $negara,
			'pic' => $pic
		];
        $this->template->set('results', $data);
		$this->template->title('Edit Suplier');
        $this->template->render('edit_international');
		
	}
	public function ViewInternasional($id){
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-edit');
		$deleted ='active';
		$sup = $this->db->get_where('master_supplier',array('id_suplier' => $id))->result();
		$category = $this->Suplier_model->get_data('child_supplier_category','activation',$deleted);
		$pic = $this->db->get_where('child_supplier_pic',array('id_suplier' => $id))->result();
		$negara = $this->Suplier_model->get_data('negara');
		$data = [
			'sup' => $sup,
			'category' => $category,
			'negara' => $negara,
			'pic' => $pic
		];
        $this->template->set('results', $data);
		$this->template->title('Edit Suplier');
        $this->template->render('view_international');
		
	}
	public function EditCategory($id){
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-edit');
		$category = $this->db->get_where('child_supplier_category',array('id_category_supplier' => $id))->result();
		$data = [
			'category' => $category,
		];
        $this->template->set('results', $data);
		$this->template->title('Edit Suplier');
        $this->template->render('edit_category');
		
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
	public function addLocal()
    {
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$deleted = 'active';
		$category = $this->Suplier_model->get_data('child_supplier_category','activation',$deleted);
		$prof = $this->Suplier_model->get_data('provinsi');
		$data = [
			'category' => $category,
			'prof' => $prof
		];
        $this->template->set('results', $data);
        $this->template->title('Add Suplier Local');
        $this->template->render('add_local');

    }
	public function addInternational()
    {
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$deleted = 'active';
		$category = $this->Suplier_model->get_data('child_supplier_category','activation',$deleted);
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
        $this->template->title('Add Suplier Local');
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
		$this->db->where('id_category_supplier',$id)->update("child_supplier_category",$data);
		
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
		$code = $this->Suplier_model->generate_Category();
		$this->db->trans_begin();
		$data = [
			'id_category_supplier'		=> $code,
			'name_category_supplier'	=> $post['name_category_supplier'],
			'supplier_code'				=> $post['supplier_code'],
			'activation'				=> 'active',
			'created_on'				=> date('Y-m-d H:i:s'),
			'created_by'				=> $this->auth->user_id()
		];
		
		$insert = $this->db->insert("child_supplier_category",$data);
		
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
		public function saveNewLocal()
    {
		
		
        $this->auth->restrict($this->addPermission);
		$post = $this->input->post();
		$session = $this->session->userdata('app_session');
		$code = $this->Suplier_model->generate_id();
		$this->db->trans_begin();
					$header1 =  array(
							'id_suplier'	 		=> $code,
							'id_category_supplier'	=> $post['id_category_supplier'],
							'suplier_location'		=> 'local',
							'moq'		    => $post['moq'],
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
	public function saveNewInternational()
    {
		
		
        $this->auth->restrict($this->addPermission);
		$post = $this->input->post();
		$session = $this->session->userdata('app_session');
		$code = $this->Suplier_model->generate_idint();
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
							'moq'		    => $post['moq'],
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
							'moq'		    => $post['moq'],
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
							'moq'		    => $post['moq'],
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
			'name_category_supplier'	=> $post['name_category_supplier'],
			'supplier_code'				=> $post['supplier_code'],
			'modified_on'		=> date('Y-m-d H:i:s'),
			'modified_by'		=> $this->auth->user_id()
		];
	 
		$this->db->where('id_category_supplier',$post['id_category_supplier'])->update("child_supplier_category",$data);
		
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
		function getkota()
    {
        $id_prov=$_GET['id_prov'];
        $data=$this->Suplier_model->carikota($id_prov);
        echo "<select id='id_kota' name='id_kota' class='form-control input-sm select2'>";
        echo "<option value=''>--Pilih--</option>";
                foreach ($data as $key => $st) :
				      echo "<option value='$st->id_prov' set_select('id_kota', $st->id_prov, isset($data->id_prov) && $data->id_prov == $st->id_prov)>$st->nama_kota
                    </option>";
                endforeach;
        echo "</select>";
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
	
}
