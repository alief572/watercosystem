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

class Material extends Admin_Controller
{
    //Permission
    protected $viewPermission 	= 'Inventory_1.View';
    protected $addPermission  	= 'Inventory_1.Add';
    protected $managePermission = 'Inventory_1.Manage';
    protected $deletePermission = 'Inventory_1.Delete';

    public function __construct()
    {
        parent::__construct();

        $this->load->library(array('Mpdf', 'upload', 'Image_lib'));
        $this->load->model(array('Material/Material_model',
                                 'Aktifitas/aktifitas_model',
                                ));
        $this->template->title('Manage Data Supplier');
        $this->template->page_icon('fa fa-building-o');

        date_default_timezone_set('Asia/Bangkok');
    }

    public function konversi()
    {
       $this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-gears');
		$deleted = '0';
        $data = $this->Material_model->get_data_material_konversi();
        $this->template->set('results', $data);
        $this->template->title('Material Konversi');
        $this->template->render('index');
    }
	public function addKonversi()
    { 
	    $material = $this->Material_model->get_data('ms_material');
		$satuan = $this->Material_model->get_data('ms_satuan');
		$lvl3 = $this->Material_model->get_data('ms_inventory_category2');
		$lvl4 = $this->Material_model->get_data('ms_inventory_category3');
		$data = [
			'material' => $material,
			'satuan' => $satuan,
			'lvl3' => $lvl3,
			'lvl4' => $lvl4
		];
		
		$this->template->page_icon('fa fa-gears');
	    $this->template->title('Add Material Konversi');
		$this->template->set('results', $data);
        $this->template->render('add_material_konversi');

    }	
	public function saveNewKonversi()
    {
        $this->auth->restrict($this->addPermission);
		$post = $this->input->post();
		$code = $this->Material_model->generate_id();
		$this->db->trans_begin();
		$data = [
			'id_material'		        => $post['material'],
			'nama_satuan'		        => $post['satuan'],
			'konversi'		            => $post['konversi'],
			'satuan_konversi'		    => $post['satuan_konversi'],
			'aktif'				=> 'aktif',
			'created_on'		=> date('Y-m-d H:i:s'),
			'created_by'		=> $this->auth->user_id(),
			'deleted'			=> '0'
		];
		
		$insert = $this->db->insert("ms_material_konversi",$data);
		
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
	
	public function editKonversi($id){
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-edit');
		$inven = $this->db->get_where('ms_material_konversi',array('id_material' => $id))->result();
		$data = [
			'inven' => $inven
		];
        $this->template->set('results', $data);
		$this->template->title('Inventory');
        $this->template->render('edit_material_konversi');
		
	}
	public function viewInventory(){
		$this->auth->restrict($this->viewPermission);
		$id 	= $this->input->post('id');
		$cust 	= $this->Material_model->getById($id);
			// echo "<pre>";
			// print_r($cust);
			// echo "<pre>";
        $this->template->set('result', $cust);
		$this->template->render('view_inventory');
	}
	public function saveEditKonversi(){
		$this->auth->restrict($this->editPermission);
		$post = $this->input->post();
		$this->db->trans_begin();
		$data = [
			'nama'		=> $post['nm_inventory'],
			'aktif'				=> $post['status'],
			'modified_on'		=> date('Y-m-d H:i:s'),
			'modified_by'		=> $this->auth->user_id()
		];
	 
		$this->db->where('id_type',$post['id_inventory'])->update("ms_inventory_type",$data);
		
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
	
	public function deleteInventory(){
		$this->auth->restrict($this->deletePermission);
		$id = $this->input->post('id');
		$data = [
			'deleted' 		=> '1',
			'deleted_by' 	=> $this->auth->user_id()
		];
		
		$this->db->trans_begin();
		$this->db->where('id_type',$id)->update("ms_inventory_type",$data);
		
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
