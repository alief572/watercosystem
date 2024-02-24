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

class Cycletime extends Admin_Controller
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
        $this->load->model(array('Cycletime/Bentuk_model',
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
        $data = $this->Bentuk_model->get_dataindex();
        $this->template->set('results', $data);
        $this->template->title('Cycletime');
        $this->template->render('index');
    }
	public function edit($id){
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-edit');
		$cycletime = $this->db->get_where('cycletime_header',array('id_time' => $id))->result();
		$detail = $this->db->get_where('cycletime_detail',array('id_time' => $id))->result();
		$costcenter = $this->Bentuk_model->get_data('ms_costcenter','deleted',$deleted);
		$data = [
			'cycletime' => $cycletime,
			'costcenter' => $costcenter,
			'detail' => $detail,
		];
        $this->template->set('results', $data);
		$this->template->title('Cycletime');
        $this->template->render('edit');
		
	}
	public function view($id){
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-edit');
		$cycletime = $this->db->get_where('cycletime_header',array('id_time' => $id))->result();
		$detail = $this->db->get_where('cycletime_detail',array('id_time' => $id))->result();
		$costcenter = $this->Bentuk_model->get_data('ms_costcenter','deleted',$deleted);
		$data = [
			'cycletime' => $cycletime,
			'costcenter' => $costcenter,
			'detail' => $detail,
		];
        $this->template->set('results', $data);
		$this->template->title('Cycletime');
        $this->template->render('view');
		
	}
	
	
	public function addCycletime()
    {
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$$deleted = "0";
		$costcenter = $this->Bentuk_model->get_data('ms_costcenter','deleted',$deleted);
		$data = [
			'costcenter' => $costcenter
		];
        $this->template->set('results', $data);
        $this->template->title('Add Inventory');
        $this->template->render('add');

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
		$this->db->where('id_time',$id)->update("cycletime_header",$data);
		
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
							'id_time'	 		=> $code,
							'costcenter'		=> $h1[costcenter],
							'machine'			=> $h1[machine],
							'created_on'		=> date('Y-m-d H:i:s'),
							'created_by'		=> $this->auth->user_id(),
							'deleted'			=> '0' 
                            );
            //Add Data
              $this->db->insert('cycletime_header',$header1);
			
		    }			

		$numb2 =0;
		foreach($_POST['data1'] as $d1){
		$numb2++;	   
              $data1 =  array(
			                    'id_time'=>$code, 
								'id_costcenter'=>$code.'-'.$numb2, 
								'process'=>$d1[process],
								'cycletime'=>$d1[cycletime],
								'qty_mp'=>$d1[qty_mp],
								'note'=>$d1[note], 
                            );
            //Add Data
              $this->db->insert('cycletime_detail',$data1);
	
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
		$id = $_POST['hd1']['1']['id_time'];
		$code = $this->Bentuk_model->generate_id();
		$this->db->trans_begin();
		$numb1 =0;
		foreach($_POST['hd1'] as $h1){
		$numb1++;	  
                $header1 =  array(
							'costcenter'		=> $h1[costcenter],
							'machine'			=> $h1[machine],
							'created_on'		=> date('Y-m-d H:i:s'),
							'created_by'		=> $this->auth->user_id(),
							'deleted'			=> '0' 
                            );
            //Add Data
			  $this->db->where('id_time',$id)->update("cycletime_header",$header1);
			
		    }			
		$this->db->delete('cycletime_detail', array('id_time' => $id));	
		$numb2 =0;
		foreach($_POST['data1'] as $d1){
		$numb2++;	   
              $data1 =  array(
			                    'id_time'=>$id, 
								'id_costcenter'=>$id.'-'.$numb2, 
								'process'=>$d1[process],
								'cycletime'=>$d1[cycletime],
								'qty_mp'=>$d1[qty_mp],
								'note'=>$d1[note], 
                            );
            //Add Data
              $this->db->insert('cycletime_detail',$data1);
	
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
