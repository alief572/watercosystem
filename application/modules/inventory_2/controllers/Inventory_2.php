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

class Inventory_2 extends Admin_Controller
{
    //Permission
    protected $viewPermission 	= 'Inventory_2.View';
    protected $addPermission  	= 'Inventory_2.Add';
    protected $managePermission = 'Inventory_2.Manage';
    protected $deletePermission = 'Inventory_2.Delete';

    public function __construct()
    {
        parent::__construct();

        $this->load->library(array('Mpdf', 'upload', 'Image_lib'));
        $this->load->model(array('Inventory_2/Inventory_2_model',
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
        $this->template->title('Product');
        $this->template->render('index');
    }

    public function get_data_json()
    {
        $this->auth->restrict($this->viewPermission);
        $post = $this->input->post();

        $result = $this->Inventory_2_model->get_datatable(
            (int) $post['start'],
            (int) $post['length'],
            isset($post['search']['value']) ? $post['search']['value'] : '',
            isset($post['order'][0]) ? $post['order'][0] : array()
        );

        $can_view   = has_permission('Inventory_2.View');
        $can_manage = has_permission('Inventory_2.Manage');
        $can_delete = has_permission('Inventory_2.Delete');

        $no = (int) $post['start'];
        $rows = array();
        foreach ($result['data'] as $r) {
            $no++;
            $id = html_escape($r->id_category1);
            $status = $r->aktif == 'aktif'
                ? '<label class="label label-success">Aktif</label>'
                : '<label class="label label-danger">Non Aktif</label>';
            $row = array($no, $id, html_escape($r->nama_type), html_escape($r->nama), $status);
            if ($can_manage) {
                $btn = '';
                if ($can_view) {
                    $btn .= '<a class="btn btn-primary btn-sm view" href="javascript:void(0)" title="View" data-id_inventory2="' . $id . '"><i class="fa fa-eye"></i></a> ';
                }
                $btn .= '<a class="btn btn-success btn-sm edit" href="javascript:void(0)" title="Edit" data-id_inventory2="' . $id . '"><i class="fa fa-edit"></i></a> ';
                if ($can_delete) {
                    $btn .= '<a class="btn btn-danger btn-sm delete" href="javascript:void(0)" title="Delete" data-id_inventory2="' . $id . '"><i class="fa fa-trash"></i></a>';
                }
                $row[] = $btn;
            }
            $rows[] = $row;
        }

        echo json_encode(array(
            'draw'            => (int) $post['draw'],
            'recordsTotal'    => $result['total'],
            'recordsFiltered' => $result['filtered'],
            'data'            => $rows,
        ));
    }
	public function editInventory($id){
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-edit');
		$inven = $this->db->get_where('ms_inventory_category1',array('id_category1' => $id))->result();
		$komposisi = $this->Inventory_2_model->getKomposisi($id);
		$lvl1 = $this->Inventory_2_model->get_data('ms_inventory_type');
		$data = [
			'inven' => $inven,
			'komposisi' => $komposisi,
			'lvl1' => $lvl1
		];
        $this->template->set('results', $data);
		$this->template->title('Product');
        $this->template->render('edit_inventory');
		
	}
	public function viewInventory(){
		$this->auth->restrict($this->viewPermission);
		$id 	= $this->input->post('id');
		$inven = $this->db->get_where('ms_inventory_category1',array('id_category1' => $id))->result();
		$komposisi = $this->Inventory_2_model->getKomposisi($id);
		$lvl1 = $this->Inventory_2_model->get_data('ms_inventory_type');
		$data = [
			'inven' => $inven,
			'komposisi' => $komposisi,
			'lvl1' => $lvl1
		];
        $this->template->set('results', $data);
		$this->template->render('view_inventory');
	}
	
	
	public function addInventory()
    {
				$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$inventory_1 = $this->Inventory_2_model->get_data('ms_inventory_type');
		$data = [
			'inventory_1' => $inventory_1
		];
        $this->template->set('results', $data);
        $this->template->title('Add Inventory');
        $this->template->render('add_inventory_2');

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
		public function saveNewinventory()
    {
        $this->auth->restrict($this->addPermission);
		$session = $this->session->userdata('app_session');
		$post = $_POST['hd1']['1']['produk'];
		$code = $this->Inventory_2_model->generate_id();
		$this->db->trans_begin();
		
		$numb1 =0;
		foreach($_POST['hd1'] as $h1){
		$numb1++;	
		        
                $header1 =  array(
							'id_category1'	 	=> $code,
							'id_type'		    => $h1['inventory_1'],
							'nama'		        => $h1['nm_inventory'],
							'aktif'				=> 'aktif',
							'created_on'		=> date('Y-m-d H:i:s'),
							'created_by'		=> $this->auth->user_id(),
							'deleted'			=> '0' 
                            );
            //Add Data
              $this->db->insert('ms_inventory_category1',$header1);
			
		    }			
		if(empty($_POST['data1'])){
		}else{
		$numb2 =0;
		foreach($_POST['data1'] as $d1){
		$numb2++;	
		
		      $produk = $_POST['hd1']['1']['produk'];
		       	       
              $data1 =  array(
			                    'id_category1'=>$code, 
								'name_compotition'=>$d1['name_compotition'],
								'deleted' =>'0',
							    'created_on' => date('Y-m-d H:i:s'),
								'created_by' => $session['id_user'], 
                            );
            //Add Data
              $this->db->insert('ms_compotition',$data1);
			
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
							'id_type'		    => $h1['inventory_1'],
							'nama'		        => $h1['nm_inventory'],
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
								'name_compotition'=>$d1['name_compotition'],
								'deleted' =>'0',
							    'created_on' => date('Y-m-d H:i:s'),
								'created_by' => $session['id_user'], 
                            );
            //Add Data
              $this->db->insert('ms_compotition',$data1);
		    }		
		}
		$numb3 =0;
		foreach(($_POST['data2'] ?? array()) as $d2){
		$numb3++;	
		
		      $info = $d2['id_compotition'];    
              $data2 =  array(
								'name_compotition'=>$d2['name_compotition'],
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
