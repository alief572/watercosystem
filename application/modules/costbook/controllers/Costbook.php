<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/*
 * @author Syamsudin
 * @copyright Copyright (c) 2019, Syamsudin
 *
 * This is controller for Master Kurs
 */

class Costbook extends Admin_Controller
{
    //Permission
    protected $viewPermission 	= 'Costbooks.View';
    protected $addPermission  	= 'Costbooks.Add';
    protected $managePermission = 'Costbooks.Manage';
    protected $deletePermission = 'Costbooks.Delete';

    public function __construct()
    {
        parent::__construct();

        $this->load->library(array('Mpdf', 'upload', 'Image_lib'));
        $this->load->model(array('Costbook/Costbook_model',
		                         'Crud/Crud_model',
                                 'Aktifitas/aktifitas_model',
                                ));
        $this->template->title('Manage Data Costbooks');
        $this->template->page_icon('fa fa-building-o');

        date_default_timezone_set('Asia/Bangkok');
    }

    public function index()
    {
       $this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
		$aktif = 'Y';
        $data = $this->Costbook_model->get_costbook();
		$this->template->set('results', $data);
        $this->template->title('Costbooks');
        $this->template->render('index');
    }
	public function editCostbook($id){
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-edit');
		$inven = $this->db->get_where('ms_costbook',array('id' => $id))->result();
		$data = [
			'costbook' => $inven
		];
        $this->template->set('results', $data);
		$this->template->title('Edit Costbook');
        $this->template->render('edit_costbook');
		
	}
	
		public function addCostbook(){
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-plus');
		$deleted = '0';
		$inventory_3 = $this->Costbook_model->get_data('ms_inventory_category3','deleted',$deleted);
		$data = [
			'inventory_3' => $inventory_3,
		];
        $this->template->set('results', $data);
		$this->template->title('Add Costbook');
        $this->template->render('add_costbook');
		
	}
	
	public function saveEditCostbook(){
		$this->auth->restrict($this->editPermission);
		$post = $this->input->post();
		$id	  = $post['id'];
		$this->db->trans_begin();
		
		$cb = $this->db->query("select * from ms_costbook WHERE id='$id'")->result();
		
		foreach($cb AS $record){
			
		$data = [
			'id_costbook'		=> $id,
			'nilai_costbook'	=> $record->nilai_costbook,
			'created_on'		=> date('Y-m-d H:i:s'),
			'created_by'		=> $this->auth->user_id(),			
		];

		$insert = $this->db->insert("ms_costbook_history",$data);
		
		}
		
		$data_update = [
			'nilai_costbook' 	=> $post['costbook'],
			'modified_on'		=> date('Y-m-d H:i:s'),
			'modified_by' 		=> $this->auth->user_id()
		];
		$this->db->where('id',$id)->update("ms_costbook",$data_update);
		
		
		
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
	
	
	public function saveAddCostbook(){
		$this->auth->restrict($this->editPermission);
		$post = $this->input->post();
		$id	  = $post['inventory_3'];
		$this->db->trans_begin();
		
		$cb = $this->db->query("select * from ms_costbook WHERE id_category3='$id'")->num_rows();
		
			
		
		if( $cb < 1 ){		
				
		$data = [
			'id_category3'		=> $id,
			'nilai_costbook'	=> $post['costbook'],
			'created_on'		=> date('Y-m-d H:i:s'),
			'created_by'		=> $this->auth->user_id(),			
			];

		$insert = $this->db->insert("ms_costbook",$data);		
		
		}				
		
		if( $cb > 0 ){
			
			$status	= array(
				  'pesan'		=>'Gagal Save Item material sudah ada. Thanks ...',
				  'status'	=> 0
				);

		}
		else{
		
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
		
		}
		
  		echo json_encode($status);
	
	}
	
}