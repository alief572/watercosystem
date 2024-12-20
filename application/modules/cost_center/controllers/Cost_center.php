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

class Cost_center extends Admin_Controller
{
    //Permission
    protected $viewPermission 	= 'Cost_center.View';
    protected $addPermission  	= 'Cost_center.Add';
    protected $managePermission = 'Cost_center.Manage';
    protected $deletePermission = 'Cost_center.Delete';

    public function __construct()
    {
        parent::__construct();

        $this->load->library(array('Mpdf', 'upload', 'Image_lib'));
        $this->load->model(array('Cost_center/Costcen_model',
		                         'Crud/Crud_model',
                                 'Aktifitas/aktifitas_model',
                                ));
        $this->template->title('Manage Data Supplier');
        $this->template->page_icon('fa fa-building-o');

        date_default_timezone_set('Asia/Bangkok');
    }

	function cari_nama()
    {
        $id_department=$_GET['id_department'];
		$tik = $this->db->get_where('department',array('id' => $id_department))->result();
		$numb = 0;
                foreach ($tik as $key => $thick):
		$numb++;
			echo "
		<div class='col-sm-6'>
		<div class='form-group row'>
			<div class='col-md-8'>
				<input type='text' class='form-control' id='nm_dept' readonly value='$thick->nm_dept' required name='nm_dept' >
			</div>
		</div>
		</div>
		";
             endforeach;
		
    }
    public function index()
    {
       $this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
		$deleted = '0';
        $data = $this->Costcen_model->get_costcen();
        $this->template->set('results', $data);
        $this->template->title('Cost Center');
        $this->template->render('index');
    }
	public function editCostCen($id){
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-edit');
		$inven = $this->db->get_where('department_center',array('id' => $id))->result();
		$department = $this->Costcen_model->get_data('department');
		$data = [
			'inven' => $inven,
			'department' => $department
		];
        $this->template->set('results', $data);
		$this->template->title('Edit');
        $this->template->render('editCostCen');
		
	}
	public function viewInventory(){
		$this->auth->restrict($this->viewPermission);
		$id 	= $this->input->post('id');
		$cust 	= $this->Inventory_1_model->getById($id);
        $this->template->set('result', $cust);
		$this->template->render('view_inventory');
	}
	public function saveEditCostCen(){
		$this->auth->restrict($this->editPermission);
		$post = $this->input->post();
		$this->db->trans_begin();
		
				
		$data = [
			'id_dept'		=> $post['id_department'],
			'nm_dept'		=> $post['nm_dept'],
			'cost_center'	=> $post['cost_center']
		];
	 
		$this->db->where('id',$post['id'])->update("department_center",$data);
		
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
		public function addCostCen()
    {
				$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$department = $this->Costcen_model->get_data('department');
		$data = [
			'department' => $department
		];
        $this->template->set('results', $data);
        $this->template->title('Add Cost Center');
        $this->template->render('addCostCen');

    }

	public function deleteCostCen(){
		$this->auth->restrict($this->deletePermission);
		$id = $this->input->post('id');
		$this->db->trans_begin();
		$this->db->delete('department_center', array('id' => $id));
		
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
	public function saveNewCostCen()
    {
        $this->auth->restrict($this->addPermission);
		$post = $this->input->post();
		$this->db->trans_begin();
		$data = [
			'id_dept'		=> $post['id_department'],
			'nm_dept'		=> $post['nm_dept'],
			'cost_center'	=> $post['cost_center']
		];
		
		$insert = $this->db->insert("department_center",$data);
		
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
