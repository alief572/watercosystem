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

class Asset_category extends Admin_Controller
{
    //Permission
    protected $viewPermission 	= 'Asset_category.View';
    protected $addPermission  	= 'Asset_category.Add';
    protected $managePermission = 'Asset_category.Manage';
    protected $deletePermission = 'Asset_category.Delete';

    public function __construct()
    {
        parent::__construct();

        $this->load->library(array('Mpdf', 'upload', 'Image_lib'));
        $this->load->model(array('Asset_category/Category_model',
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
        $data = $this->Category_model->get_data('asset_category');
        $this->template->set('results', $data);
        $this->template->title('Kategori Asset');
        $this->template->render('index');
    }
	public function addKategory()
    {
		$this->template->title('Kategory');
        $this->template->render('add_category');

    }
	public function editCategory($id){
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-edit');
		$inven = $this->db->get_where('asset_category',array('id' => $id))->result();
		$data = [
			'inven' => $inven
		];
        $this->template->set('results', $data);
		$this->template->title('Kategory');
        $this->template->render('edit_category');
		
	}
	public function viewInventory(){
		$this->auth->restrict($this->viewPermission);
		$id 	= $this->input->post('id');
		$cust 	= $this->Inventory_1_model->getById($id);
        $this->template->set('result', $cust);
		$this->template->render('view_inventory');
	}
	public function saveEditcategory(){
		$this->auth->restrict($this->editPermission);
		$post = $this->input->post();
		$this->db->trans_begin();
		
				
		$data = [
			'nm_category'		        => $post['nm_category'],
			'tipe'				=> $post['tipe']
		];
	 
		$this->db->where('id',$post['id'])->update("asset_category",$data);
		
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

	public function deleteKategory(){
		$this->auth->restrict($this->deletePermission);
		$id = $this->input->post('id');
		$this->db->trans_begin();
		$this->db->delete('asset_category', array('id' => $id));
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
	public function saveNewcategory()
    {
        $this->auth->restrict($this->addPermission);
		$post = $this->input->post();
		$code = $this->Category_model->generate_id();
		$this->db->trans_begin();
		$data = [
			'nm_category'		=> $post['nm_category'],
			'tipe'				=> $post['tipe'],
		];
		
		$insert = $this->db->insert("asset_category",$data);
		
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
