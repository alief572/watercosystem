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

class Master_bentuk extends Admin_Controller
{
    //Permission
    protected $viewPermission 	= 'Master_bentuk.View';
    protected $addPermission  	= 'Master_bentuk.Add';
    protected $managePermission = 'Master_bentuk.Manage';
    protected $deletePermission = 'Master_bentuk.Delete';

    public function __construct()
    {
        parent::__construct();

        $this->load->library(array('Mpdf', 'upload', 'Image_lib'));
        $this->load->model(array('Master_bentuk/Bentuk_model',
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
		$deleted = '0';
        $data = $this->Bentuk_model->get_data('ms_bentuk','deleted',$deleted);
        $this->template->set('results', $data);
        $this->template->title('Bentuk Material');
        $this->template->render('index');
    }
	public function editBentuk($id){
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-edit');
		$bentuk = $this->db->get_where('ms_bentuk',array('id_bentuk' => $id))->result();
		$dimensi = $this->Bentuk_model->getDimensi($id);
		$data = [
			'bentuk' => $bentuk,
			'dimensi' => $dimensi,
		];
        $this->template->set('results', $data);
		$this->template->title('Bentuk Material');
        $this->template->render('edit_bentuk');
		
	}
	public function viewBentuk($id){
		$this->auth->restrict($this->viewPermission);
		$id 	= $this->input->post('id');
		$bentuk = $this->db->get_where('ms_bentuk',array('id_bentuk' => $id))->result();
		$dimensi = $this->Bentuk_model->getDimensi($id);
		$data = [
			'bentuk' => $bentuk,
			'dimensi' => $dimensi,
		];
        $this->template->set('results', $data);
		$this->template->render('view_bentuk');
	}
	
	
	public function addBentuk()
    {
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
        $this->template->title('Add Inventory');
        $this->template->render('add_bentuk');

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
		$this->db->where('id_dimensi',$id)->update("ms_dimensi",$data);
		
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

	public function deleteBentuk(){
		$this->auth->restrict($this->deletePermission);
		$id = $this->input->post('id');
		// print_r($id);
		// exit();
		$data = [
			'deleted' 		=> '1',
			'deleted_by' 	=> $this->auth->user_id()
		];
		
		$this->db->trans_begin();
		$this->db->where('id_bentuk',$id)->update("ms_bentuk",$data);
		
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
		public function saveNewbentuk()
    {
        $this->auth->restrict($this->addPermission);
		$session = $this->session->userdata('app_session');
		$post = $_POST['hd1']['1']['produk'];
		$code = $this->Bentuk_model->generate_id();
		$this->db->trans_begin();
		
		$numb1 =0;
		foreach($_POST['hd1'] as $h1){
		$numb1++;	
		        
                $header1 =  array(
							'id_bentuk'	 	=> $code,
							'nm_bentuk'		        => $h1[nm_bentuk],
							'created_on'		=> date('Y-m-d H:i:s'),
							'created_by'		=> $this->auth->user_id(),
							'deleted'			=> '0' 
                            );
            //Add Data
              $this->db->insert('ms_bentuk',$header1);
			
		    }			
		if(empty($_POST['data1'])){
		}else{
		$numb2 =0;
		foreach($_POST['data1'] as $d1){
		$numb2++;	   
              $data1 =  array(
			                    'id_bentuk'=>$code, 
								'nm_dimensi'=>$d1[nm_dimensi],
								'deleted' =>'0',
							    'created_on' => date('Y-m-d H:i:s'),
								'created_by' => $session['id_user'], 
                            );
            //Add Data
              $this->db->insert('ms_dimensi',$data1);
			
		    }		
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
	public function saveEditbentuk()
    {
        $this->auth->restrict($this->addPermission);
		$session = $this->session->userdata('app_session');
		$this->db->trans_begin();
		
		$numb1 =0;
		foreach($_POST['hd1'] as $h1){
		$numb1++;	
		        $produk = $_POST['hd1']['1']['id_bentuk'];
                $header1 =  array(
							'nm_bentuk'		        => $h1[nm_bentuk],
							'modified_on'		=> date('Y-m-d H:i:s'),
							'modified_by'		=> $this->auth->user_id(),
							'deleted'			=> '0' 
                            );
            //Add Data
			 $this->db->where('id_bentuk',$produk)->update("ms_bentuk",$header1);
		    }	
		if(empty($_POST['data1'])){
		}else{
		$numb2 =0;
		foreach($_POST['data1'] as $d1){
		$numb2++;	
		
		      $code = $_POST['hd1']['1']['id_bentuk'];    
              $data1 =  array(
			                    'id_bentuk'=>$code, 
								'nm_dimensi'=>$d1[nm_dimensi],
								'deleted' =>'0',
							    'created_on' => date('Y-m-d H:i:s'),
								'created_by' => $session['id_user'], 
                            );
            //Add Data
              $this->db->insert('ms_dimensi',$data1);
		    }		
		}
		$numb3 =0;
		foreach($_POST['data2'] as $d2){
		$numb3++;	
		
		      $info = $d2['id_dimensi'];    
              $data2 =  array(
								'nm_dimensi'=>$d2[nm_dimensi],
								'deleted' =>'0',
							    'modified_on' => date('Y-m-d H:i:s'),
								'modified_by' => $session['id_user'], 
                            );
            //Add Data
             $this->db->where('id_dimensi',$info)->update("ms_dimensi",$data2);
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
	public function saveNewinventoryold()
    {
        $this->auth->restrict($this->addPermission);
		$post = $this->input->post();
		$code = $this->Inventory_2_model->generate_id();
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
