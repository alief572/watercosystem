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

class Harga_lme extends Admin_Controller
{
    //Permission
    protected $viewPermission 	= 'Master_lme.View';
    protected $addPermission  	= 'Master_lme.Add';
    protected $managePermission = 'Master_lme.Manage';
    protected $deletePermission = 'Master_lme.Delete';

    public function __construct()
    {
        parent::__construct();

        $this->load->library(array('Mpdf', 'upload', 'Image_lib'));
        $this->load->model(array('Harga_lme/Lme_model',
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
        $history = $this->Lme_model->gethistory();
		$comp = $this->Lme_model->get_data('ms_compotition','deleted',$deleted);
		$data = [
			'history' => $history,
			'comp' => $comp
		];
        $this->template->set('results', $data);
        $this->template->title('Master LME');
        $this->template->render('index');
    }
	public function ViewHistory(){
		$this->auth->restrict($this->viewPermission);
		$id 	= $this->input->post('id');
		$history = $this->Lme_model->getdthistory($id);
		$data = [
			'history' => $history
		];
        $this->template->set('results', $data);
		$this->template->render('view_history');
	}

	public function ViewHarga(){
		$this->auth->restrict($this->viewPermission);
		$id 	= $this->input->post('id');
		$harga = $this->Lme_model->getKomposisi($id);
		$tanggal= date('Y-m-d H:i:s');
		$usr 	= $this->auth->user_id();
		$nama_user = $this->Lme_model->get_data('users','id_user',$usr);
		$data = [
			'harga' => $harga,
			'tanggal' => $tanggal,
			'nama_user' => $nama_user
		];
        $this->template->set('results', $data);
		$this->template->render('view_harga');
	}
	public function EditHarga(){
		$this->auth->restrict($this->viewPermission);
		$id 	= $this->input->post('id');
		$harga = $this->Lme_model->get_data('ms_compotition');
		$tanggal= date('Y-m-d H:i:s');
		$usr 	= $this->auth->user_id();
		$inv = $this->Lme_model->get_data('ms_inventory_category1','id_category1',$id);
		$nama_user = $this->Lme_model->get_data('users','id_user',$usr);
		$data = [
			'inv'	=> $inv,
			'harga' => $harga,
			'tanggal' => $tanggal,
			'nama_user' => $nama_user
		];
        $this->template->set('results', $data);
		$this->template->render('edit_harga');
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

		public function SaveEditHarga()
    {
        $this->auth->restrict($this->addPermission);
		$post = $this->input->post();
		$code = $this->Lme_model->generate_id();
		$this->db->trans_begin();
		$data = [
			'id_history_lme'	=> $code,
			'tanggal_edit'		=> date('d'),
			'bulan_edit'		=> date('m'),
			'tahun_edit'		=> date('Y'),
			'created_on'		=> date('Y-m-d H:i:s'),
			'created_by'		=> $this->auth->user_id()
		];
		$insert = $this->db->insert("ms_history_lme",$data);
		$numb1 =0;
		foreach($_POST['data9'] as $h1){
		$numb1++;	
		        
                $header1 =  array(
							'id_category1'	 	=> $code,
							'id_type'		    => $h1[inventory_1],
							'nama'		        => $h1[nm_inventory],
							'aktif'				=> 'aktif',
							'created_on'		=> date('Y-m-d H:i:s'),
							'created_by'		=> $this->auth->user_id(),
							'deleted'			=> '0' 
                            );
            //Add Data
              $this->db->insert('ms_inventory_category1',$header1);
			
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

	public function deleteInventory(){
		$this->auth->restrict($this->deletePermission);
		$id = $this->input->post('id');
		// print_r($id);
		// exit();
		$data = [
			'deleted' 		=> '1',
			'deleted_by' 	=> $this->auth->user_id()
		];
		
		$this->db->trans_begin();
		$this->db->where('id_category1',$id)->update("ms_inventory_category1",$data);
		
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
