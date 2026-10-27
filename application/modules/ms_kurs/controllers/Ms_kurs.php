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

class Ms_kurs extends Admin_Controller
{
    //Permission
    protected $viewPermission 	= 'Master_Kurs.View';
    protected $addPermission  	= 'Master_Kurs.Add';
    protected $managePermission = 'Master_Kurs.Manage';
    protected $deletePermission = 'Master_Kurs.Delete';

    public function __construct()
    {
        parent::__construct();

        $this->load->library(array('Mpdf', 'upload', 'Image_lib'));
        $this->load->model(array('Ms_kurs/Ms_kurs_model',
		                         'Crud/Crud_model',
                                 'Aktifitas/aktifitas_model',
                                ));
        $this->template->title('Manage Data Kurs');
        $this->template->page_icon('fa fa-building-o');

        date_default_timezone_set('Asia/Bangkok');
    }

    public function index()
    {
       $this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
		$aktif = 'Y';
        $data = $this->Ms_kurs_model->get_data('ms_kurs');
        $this->template->set('results', $data);
        $this->template->title('Kurs');
        $this->template->render('index');
    }
	public function editKurs($id){
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-edit');
		$inven = $this->db->get_where('ms_kurs',array('id' => $id))->result();
		$data = [
			'kurs' => $inven
		];
        $this->template->set('results', $data);
		$this->template->title('Edit Kurs');
        $this->template->render('edit_kurs');
		
	}
	public function viewInventory(){
		$this->auth->restrict($this->viewPermission);
		$id 	= $this->input->post('id');
		$cust 	= $this->Ms_kurs_model->getById($id);
        $this->template->set('result', $cust);
		$this->template->render('view_inventory');
	}
	public function saveEditKurs(){
		$this->auth->restrict($this->editPermission);
		$post = $this->input->post();
		$this->db->trans_begin();
		
		$data_update = [
			'aktif' 		=> 'N',
			'modified_by' 	=> $this->auth->user_id()
		];
		$this->db->update("ms_kurs",$data_update);

		$data = [
			'nilai_kurs'		=> $post['kurs'],
			'aktif'				=> 'Y',
			'created_on'		=> date('Y-m-d H:i:s'),
			'created_by'		=> $this->auth->user_id(),
			'deleted'			=> '0'
		];

		$insert = $this->db->insert("ms_kurs",$data);

		$pl = $this->db->query("select * from ms_product_pricelist")->result();
		// print_r($pl);
		// exit;

		foreach($pl AS $record){
			$kurs  = $post['kurs'];
			$harga = $record->total_pricelist * $kurs;
			$id_pl =  $record->id_product_pricelist;
			$data_kurs = [
				'kurs' 				=> $kurs,
				'harga_rupiah' 		=> $harga				
			];

			$this->db->where('id_product_pricelist',$id_pl)->update("ms_product_pricelist",$data_kurs);
			
			
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
			  'pesan'		=>'Success Save Item. Thanks ...',
			  'status'	=> 1
			);			
		}
		
  		echo json_encode($status);
	
	}
	public function addKurs()
    {
        $this->template->render('add_kurs');

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
	public function saveNewkurs()
    {
        $this->auth->restrict($this->addPermission);
		$post = $this->input->post();
		$code = $this->Ms_kurs_model->generate_id();
		$this->db->trans_begin();
		$data_update = [
			'aktif' 		=> 'N',
			'modified_by' 	=> $this->auth->user_id()
		];
		$this->db->update("ms_kurs",$data_update);

		$data = [
			'nilai_kurs'		=> $post['kurs'],
			'aktif'				=> 'Y',
			'created_on'		=> date('Y-m-d H:i:s'),
			'created_by'		=> $this->auth->user_id(),
			'deleted'			=> '0'
		];
		
		$insert = $this->db->insert("ms_kurs",$data);
		
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
