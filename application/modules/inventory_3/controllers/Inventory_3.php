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

class Inventory_3 extends Admin_Controller
{
    //Permission
    protected $viewPermission 	= 'Inventory_3.View';
    protected $addPermission  	= 'Inventory_3.Add';
    protected $managePermission = 'Inventory_3.Manage';
    protected $deletePermission = 'Inventory_3.Delete';

    public function __construct()
    {
        parent::__construct();

        $this->load->library(array('Mpdf', 'upload', 'Image_lib'));
        $this->load->model(array('Inventory_3/Inventory_3_model',
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

        $result = $this->Inventory_3_model->get_datatable(
            (int) $post['start'],
            (int) $post['length'],
            isset($post['search']['value']) ? $post['search']['value'] : '',
            isset($post['order'][0]) ? $post['order'][0] : array()
        );

        $can_view   = has_permission('Inventory_3.View');
        $can_manage = has_permission('Inventory_3.Manage');
        $can_delete = has_permission('Inventory_3.Delete');

        $no = (int) $post['start'];
        $rows = array();
        foreach ($result['data'] as $r) {
            $no++;
            $id = html_escape($r->id_category2);
            $status = $r->aktif == 'aktif'
                ? '<label class="label label-success">Aktif</label>'
                : '<label class="label label-danger">Non Aktif</label>';
            $row = array($no, $id, html_escape($r->nama_type), html_escape($r->nama_category1), html_escape($r->nama), $status);
            if ($can_manage) {
                $btn = '';
                if ($can_view) {
                    $btn .= '<a class="btn btn-primary btn-sm view" href="javascript:void(0)" title="View" data-id_inventory3="' . $id . '"><i class="fa fa-eye"></i></a> ';
                }
                $btn .= '<a class="btn btn-success btn-sm edit" href="javascript:void(0)" title="Edit" data-id_inventory3="' . $id . '"><i class="fa fa-edit"></i></a> ';
                if ($can_delete) {
                    $btn .= '<a class="btn btn-danger btn-sm delete" href="javascript:void(0)" title="Delete" data-id_inventory3="' . $id . '"><i class="fa fa-trash"></i></a>';
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
		$inven = $this->db->get_where('ms_inventory_category2',array('id_category2' => $id))->result();
		$lvl1 = $this->Inventory_3_model->get_data('ms_inventory_type');
		$lvl2 = empty($inven) ? array() : $this->Inventory_3_model->level_2($inven[0]->id_type);
		$data = [
			'inven' => $inven,
			'lvl1' => $lvl1,
			'lvl2' => $lvl2
		];
        $this->template->set('results', $data);
		$this->template->title('Product');
        $this->template->render('edit_inventory');
		
	}
	public function viewInventory(){
		$this->auth->restrict($this->viewPermission);
		$id 	= $this->input->post('id');
		$cust 	= $this->Inventory_3_model->getview($id);
        $this->template->set('result', $cust);
		$this->template->render('view_inventory');
	}
	public function saveEditInventory(){
		$this->auth->restrict($this->managePermission);
		$post = $this->input->post();
		// print_r($post);
		// exit();
		$this->db->trans_begin();
		$data = [
			'id_type'		    => $post['inventory_1'],
			'id_category1'		=> $post['inventory_2'],
			'nama'      		=> $post['nm_inventory'],
			'aktif'				=> $post['status'],
			'modified_on'		=> date('Y-m-d H:i:s'),
			'modified_by'		=> $this->auth->user_id()
		];
	 
		$this->db->where('id_category2',$post['id_inventory'])->update("ms_inventory_category2",$data);
		
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
	public function addInventory()
    {
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$inventory_1 = $this->Inventory_3_model->get_data('ms_inventory_type');
		$inventory_2 = $this->Inventory_3_model->get_data('ms_inventory_category1');
		$data = [
			'inventory_1' => $inventory_1,
			'inventory_2' => $inventory_2
		];
        $this->template->set('results', $data);
        $this->template->title('Add Inventory');
        $this->template->render('add_inventory');

    }
	public function deleteInventory(){
		$this->auth->restrict($this->deletePermission);
		$id = $this->input->post('id');
		$data = [
			'deleted' 		=> '1',
			'deleted_by' 	=> $this->auth->user_id()
		];
		
		$this->db->trans_begin();
		$this->db->where('id_category2',$id)->update("ms_inventory_category2",$data);
		
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
	
	function get_inven2()
    {
        $inventory_1=$_GET['inventory_1'];
        $data=$this->Inventory_3_model->level_2($inventory_1);
		
        // print_r($data);
        // exit();
        echo "<select id='inventory_2' name='inventory_2' class='form-control input-sm select2'>";
        echo "<option value=''>--Pilih Category--</option>";
                foreach ($data as $key => $st) :
				      echo "<option value='$st->id_category1' set_select('inventory_2', $st->id_category1, isset($data->id_category1) && $data->id_category1 == $st->id_category1)>$st->nama
                    </option>";
                endforeach;
        echo "</select>";
    }
    
	public function saveNewinventory()
    {
        $this->auth->restrict($this->addPermission);
		$post = $this->input->post();
		$code = $this->Inventory_3_model->generate_id();
		$this->db->trans_begin();
		$data = [
			'id_category2'		=> $code,
			'id_type'		    => $post['inventory_1'],
			'id_category1'		=> $post['inventory_2'],
			'nama'      		=> $post['nm_inventory'],
			'aktif'				=> 'aktif',
			'created_on'		=> date('Y-m-d H:i:s'),
			'created_by'		=> $this->auth->user_id(),
			'deleted'			=> '0'
		];
		
		$insert = $this->db->insert("ms_inventory_category2",$data);
		
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
