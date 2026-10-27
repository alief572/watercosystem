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

class Master_department extends Admin_Controller
{
    //Permission
    protected $viewPermission 	= 'Master_department.View';
    protected $addPermission  	= 'Master_department.Add';
    protected $managePermission = 'Master_department.Manage';
    protected $deletePermission = 'Master_department.Delete';

    public function __construct()
    {
        parent::__construct();

        $this->load->library(array('Mpdf', 'upload', 'Image_lib'));
        $this->load->model(array('Master_department/Department_model',
		                         'Crud/Crud_model',
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
        $data = $this->Department_model->get_data('department');
        $this->template->set('results', $data);
        $this->template->title('Departement');
        $this->template->render('index');
    }
	public function editDepartment($id){
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-edit');
		$inven = $this->db->get_where('department',array('id' => $id))->result();
		$data = [
			'inven' => $inven
		];
        $this->template->set('results', $data);
		$this->template->title('Departement');
        $this->template->render('editDepartment');
		
	}
	public function viewInventory(){
		$this->auth->restrict($this->viewPermission);
		$id 	= $this->input->post('id');
		$cust 	= $this->Inventory_1_model->getById($id);
        $this->template->set('result', $cust);
		$this->template->render('view_inventory');
	}
	public function saveEditDepartment(){
		$this->auth->restrict($this->editPermission);
		$post = $this->input->post();
		$this->db->trans_begin();
		
				
		$data = [
			'nm_dept'		        => $post['nm_dept'],
		];
	 
		$this->db->where('id',$post['id'])->update("department",$data);
		
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
	public function addDepartment()
    {
        $this->template->render('addDepartment');

    }
	public function deleteDepartment(){
		$this->auth->restrict($this->deletePermission);
		$id = $this->input->post('id');		
		$this->db->trans_begin();
		$this->db->delete('department', array('id' => $id));
		
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
	public function saveNewDepartment()
    {
        $this->auth->restrict($this->addPermission);
		$post = $this->input->post();
		$this->db->trans_begin();
		$data = [
			'nm_dept'		=> $post['nm_dept'],
		];
		
		$insert = $this->db->insert("department",$data);
		
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
	
}
