<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/*
 * @author Harboens
 * @copyright Copyright (c) 2020
 *
 * This is controller for Master Warehouse
 */
$status=array();
class Warehouse extends Admin_Controller
{
    //Permission
    protected $viewPermission 	= 'Warehouse.View';
    protected $addPermission  	= 'Warehouse.Add';
    protected $managePermission = 'Warehouse.Manage';
    protected $deletePermission = 'Warehouse.Delete';
    public function __construct() {
        parent::__construct();
        $this->load->model(array('Warehouse/Warehouse_model','All/All_model'));
        $this->template->title('Gudang');
        $this->template->page_icon('fa fa-dollar');
        date_default_timezone_set('Asia/Bangkok');
		$this->status=array("0"=>"Aktif","1"=>"Non Aktif");
    }

	// list
    public function index() {
		$data = $this->Warehouse_model->GetListWarehouse();
        $this->template->set('results', $data);
        $this->template->set('status', $this->status);
		$this->template->page_icon('fa fa-list');
		$this->template->title('Gudang');
        $this->template->render('warehouse_list');
    }

	// create
	public function create(){
        $this->template->set('status', $this->status);
        $this->template->render('warehouse_form');
	}

	// edit
	public function edit($id){
		$data = $this->Warehouse_model->GetDataWarehouse($id);
        $this->template->set('status', $this->status);
        $this->template->set('data', $data);
		$this->template->page_icon('fa fa-list');
        $this->template->render('warehouse_form');
	}
	
	public function addMaterial($id){
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-plus');
		$deleted = '0';
		$nama        = $this->db->query("select * from ms_gudang where id_gudang='$id'")->row();
		$inventory_3 = $this->Warehouse_model->get_data('ms_inventory_category3','deleted',$deleted);
		$data = [
		    'id_gudang' => $id,
			'nama_gudang' => $nama->nama_gudang,
			'inventory_3' => $inventory_3,
		];
        $this->template->set('results', $data);
		$this->template->title('Add Material Gudang');
        $this->template->render('warehouse_material');
		
	}

	// save
	public function save(){

        $wh_name	= $this->input->post("wh_name");	
		
		// print_r($this->input->post());
		// exit;
		
		
		$this->db->trans_begin();   
            $data =  array(
						'nama_gudang'=>$wh_name,
					 );
            $id = $this->db->insert("ms_gudang",$data);


			if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
				$keterangan     = "GAGAL, tambah data".$id;
                $status2         = 0;
                $nm_hak_akses   = $this->addPermission;
                $kode_universal = 'NewData';
                $jumlah         = 1;
                $sql            = $this->db->last_query();
                $result = FALSE;
				
				$status	= array(
				  'pesan'		=>'Gagal Save Item. Thanks ...',
				  'status'	=> 0
				);
				
            } else {
			$this->db->trans_commit();
                $keterangan     = "SUKSES, tambah data ".$id;
                $status2         = 1;
                $nm_hak_akses   = $this->addPermission;
                $kode_universal = 'NewData';
                $jumlah         = 1;
                $sql            = $this->db->last_query();
                $result         = TRUE;
				
				$status	= array(
				  'pesan'		=>'Success Save Item. Thanks ...',
				  'status'	=> 1
				);	
            }
           // simpan_aktifitas($nm_hak_akses, $kode_universal, $keterangan, $jumlah, $sql, $status2);
        
			echo json_encode($status);
	}

	// delete
	public function delete($id){
        $result=$this->Warehouse_model->delete($id);
        $param = array( 'delete' => $result );
        echo json_encode($param);
	}
	
	public function saveAddMaterial(){
		$this->auth->restrict($this->addPermission);
		$post = $this->input->post();
		$gudang	  	= $post['id_gudang'];
		$id	  		= $post['inventory_3'];
		$this->db->trans_begin();
		
		if($gudang =='1'){
		$cb = $this->db->query("select * from stock_material WHERE id_category3='$id' and id_gudang='1'")->num_rows();
		} 
		else{
		$cb = $this->db->query("select * from stock_material_multigudang WHERE id_category3='$id' and id_gudang='$gudang'")->num_rows();
		}
			
		
		if( $cb < 1 ){	

			if($gudang =='1'){
					
			$data = [
				'id_category3'		=> $id,
				'qty'			=> $post['qty'],
				'qty_book'		=> $post['qty_booking'],
				'qty_free'		=> $post['qty_available'],
				'aktif'		    => 'Y',
				'id_gudang'		=> $gudang,
				'created_on'	=> date('Y-m-d H:i:s'),
				'created_by'	=> $this->auth->user_id(),			
				];

			$insert = $this->db->insert("stock_material",$data);	

			}
			else{
					
			$data = [
				'id_category3'		=> $id,
				'qty'			=> $post['qty'],
				'qty_book'		=> $post['qty_booking'],
				'qty_free'		=> $post['qty_available'],
				'aktif'		    => 'Y',
				'id_gudang'		=> $gudang,
				'created_on'	=> date('Y-m-d H:i:s'),
				'created_by'	=> $this->auth->user_id(),			
				];

			$insert = $this->db->insert("stock_material_multigudang",$data);	

			}
			
			
			
		
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
