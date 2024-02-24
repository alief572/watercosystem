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

class Stock_material extends Admin_Controller
{
    //Permission
    protected $viewPermission 	= 'Inventory_4.View';
    protected $addPermission  	= 'Inventory_4.Add';
    protected $managePermission = 'Inventory_4.Manage';
    protected $deletePermission = 'Inventory_4.Delete';

    public function __construct()
    {
        parent::__construct();

        $this->load->library(array('Mpdf', 'upload', 'Image_lib'));
        $this->load->model(array('stock_material/Inventory_4_model',
                                 'Aktifitas/aktifitas_model',
                                ));
        $this->template->title('Manage Data Supplier');
        $this->template->page_icon('fa fa-building-o');

        date_default_timezone_set('Asia/Bangkok');
    }
		public function index()
    {
		$id_bentuk = $this->uri->segment(3);
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
		$deleted = '0';
        $data = $this->Inventory_4_model->get_data_category3();
        $this->template->set('results', $data);
        $this->template->title('Stock Material');
        $this->template->render('index');
    }
		public function detail()
    {
		$id_category3 = $this->uri->segment(3);
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
        $data = $this->Inventory_4_model->dapat_stock($id_category3);
        $this->template->set('results', $data);
        $this->template->title('Stock Material');
        $this->template->render('list');
    }
		public function GudangRawMaterial()
    {
		$id_gudang = '1';
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
		$gudang = $this->Inventory_4_model->PerGudang($id_gudang);
		$jumlah = $this->Inventory_4_model->SumPerGudang($id_gudang);
		$data = [
		'gudang' => $gudang,
		'jumlah' => $jumlah,
		];
        $this->template->set('results', $data);
        $this->template->title('Stock Material');
        $this->template->render('gudang');
    }
		public function GudangWIP()
    {
		$id_gudang = '2';
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
        $gudang = $this->Inventory_4_model->PerGudang($id_gudang);
		$jumlah = $this->Inventory_4_model->SumPerGudang($id_gudang);
		$data = [
		'gudang' => $gudang,
		'jumlah' => $jumlah,
		];
        $this->template->set('results', $data);
        $this->template->title('Stock Material');
        $this->template->render('gudang');
    }
		public function GudangFinishGood()
    {
		$id_gudang = '3';
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
        $gudang = $this->Inventory_4_model->PerGudang($id_gudang);
		$jumlah = $this->Inventory_4_model->SumPerGudang($id_gudang);
		$data = [
		'gudang' => $gudang,
		'jumlah' => $jumlah,
		];
        $this->template->set('results', $data);
        $this->template->title('Stock Material');
        $this->template->render('gudang');
    }
	public function GudangScrap()
    {
		$id_gudang = '4';
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
        $gudang = $this->Inventory_4_model->PerGudang($id_gudang);
		$jumlah = $this->Inventory_4_model->SumPerGudang($id_gudang);
		$data = [
		'gudang' => $gudang,
		'jumlah' => $jumlah,
		];
        $this->template->set('results', $data);
        $this->template->title('Stock Material');
        $this->template->render('gudang');
    }
	public function GudangSubcont()
    {
		$id_gudang = '5';
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
        $gudang = $this->Inventory_4_model->PerGudang($id_gudang);
		$jumlah = $this->Inventory_4_model->SumPerGudang($id_gudang);
		$data = [
		'gudang' => $gudang,
		'jumlah' => $jumlah,
		];
        $this->template->set('results', $data);
        $this->template->title('Stock Material');
        $this->template->render('gudang');
    }
	
		public function editInventory($id)
    {
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$deleted = '0';
		$inven = $this->Inventory_4_model->getedit($id);
		$komposisiold = $this->Inventory_4_model->get_data('child_inven_compotition','id_category3',$id);
		$komposisi = $this->Inventory_4_model->kompos($id);
		$dimensiold = $this->Inventory_4_model->get_data('child_inven_dimensi','id_category3',$id);
		$dimensi = $this->Inventory_4_model->dimensy($id);
		$supl = $this->Inventory_4_model->supl($id);
		$inventory_1 = $this->Inventory_4_model->get_data('ms_inventory_type','deleted',$deleted);
		$inventory_2 = $this->Inventory_4_model->get_data('ms_inventory_category1','deleted',$deleted);
		$inventory_3 = $this->Inventory_4_model->get_data('ms_inventory_category2','deleted',$deleted);
		$maker = $this->Inventory_4_model->get_data('negara');
		$id_bentuk = $this->Inventory_4_model->get_data('ms_bentuk');
		$id_supplier = $this->Inventory_4_model->get_data('master_supplier');
		$id_surface = $this->Inventory_4_model->get_data('ms_surface');
		$dt_suplier = $this->Inventory_4_model->get_data('child_inven_suplier','id_category3',$id);
		$data = [
			'inventory_1' => $inventory_1,
			'inventory_2' => $inventory_2,
			'inventory_3' => $inventory_3,
			'komposisi' => $komposisi,
			'dimensi' => $dimensi,
			'id_bentuk' => $id_bentuk,
			'inven' => $inven,
			'maker' => $maker,
			'supl' => $supl,
			'id_surface' => $id_surface,
			'id_supplier' => $id_supplier,
			'dt_suplier' => $dt_suplier
		];
        $this->template->set('results', $data);
        $this->template->title('Add Inventory');
        $this->template->render('edit_inventory');

    }
	public function copyInventory($id)
    {
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$deleted = '0';
		$inven = $this->Inventory_4_model->getedit($id);
		$komposisiold = $this->Inventory_4_model->get_data('child_inven_compotition','id_category3',$id);
		$komposisi = $this->Inventory_4_model->kompos($id);
		$dimensiold = $this->Inventory_4_model->get_data('child_inven_dimensi','id_category3',$id);
		$dimensi = $this->Inventory_4_model->dimensy($id);
		$supl = $this->Inventory_4_model->supl($id);
		$inventory_1 = $this->Inventory_4_model->get_data('ms_inventory_type','deleted',$deleted);
		$inventory_2 = $this->Inventory_4_model->get_data('ms_inventory_category1','deleted',$deleted);
		$inventory_3 = $this->Inventory_4_model->get_data('ms_inventory_category2','deleted',$deleted);
		$maker = $this->Inventory_4_model->get_data('negara');
		$id_bentuk = $this->Inventory_4_model->get_data('ms_bentuk');
		$id_supplier = $this->Inventory_4_model->get_data('master_supplier');
		$id_surface = $this->Inventory_4_model->get_data('ms_surface');
		$dt_suplier = $this->Inventory_4_model->get_data('child_inven_suplier','id_category3',$id);
		$data = [
			'inventory_1' => $inventory_1,
			'inventory_2' => $inventory_2,
			'inventory_3' => $inventory_3,
			'komposisi' => $komposisi,
			'dimensi' => $dimensi,
			'id_bentuk' => $id_bentuk,
			'inven' => $inven,
			'maker' => $maker,
			'supl' => $supl,
			'id_surface' => $id_surface,
			'id_supplier' => $id_supplier,
			'dt_suplier' => $dt_suplier
		];
        $this->template->set('results', $data);
        $this->template->title('Add Inventory');
        $this->template->render('copy_inventory');

    }
	public function viewInventory($id)
    {
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$deleted = '0';
		$inven = $this->Inventory_4_model->getedit($id);
		$komposisiold = $this->Inventory_4_model->get_data('child_inven_compotition','id_category3',$id);
		$komposisi = $this->Inventory_4_model->kompos($id);
		$dimensiold = $this->Inventory_4_model->get_data('child_inven_dimensi','id_category3',$id);
		$dimensi = $this->Inventory_4_model->dimensy($id);
		$supl = $this->Inventory_4_model->supl($id);
		$inventory_1 = $this->Inventory_4_model->get_data('ms_inventory_type','deleted',$deleted);
		$inventory_2 = $this->Inventory_4_model->get_data('ms_inventory_category1','deleted',$deleted);
		$inventory_3 = $this->Inventory_4_model->get_data('ms_inventory_category2','deleted',$deleted);
		$maker = $this->Inventory_4_model->get_data('negara');
		$id_bentuk = $this->Inventory_4_model->get_data('ms_bentuk');
		$id_supplier = $this->Inventory_4_model->get_data('master_supplier');
		$id_surface = $this->Inventory_4_model->get_data('ms_surface');
		$dt_suplier = $this->Inventory_4_model->get_data('child_inven_suplier','id_category3',$id);
		$data = [
			'inventory_1' => $inventory_1,
			'inventory_2' => $inventory_2,
			'inventory_3' => $inventory_3,
			'komposisi' => $komposisi,
			'dimensi' => $dimensi,
			'id_bentuk' => $id_bentuk,
			'inven' => $inven,
			'maker' => $maker,
			'supl' => $supl,
			'id_surface' => $id_surface,
			'id_supplier' => $id_supplier,
			'dt_suplier' => $dt_suplier
		];
        $this->template->set('results', $data);
        $this->template->title('Add Inventory');
        $this->template->render('view_inventory');

    }
	public function viewBentuk($id){
		$this->auth->restrict($this->viewPermission);
		$id 	= $this->input->post('id');
		$bentuk = $this->db->get_where('ms_bentuk',array('id_bentuk' => $id))->result();
		$dimensi = $this->Bentuk_model->getDimensi($id);
		$data = [
			'bentuk' => $bentuk,
			'dimensi' => $dimensi,
		];
        $this->template->set('results', $data);
		$this->template->render('view_bentuk');
	}
	
	
	public function addInventory($id)
    {
		$id_data 	= $this->input->post('id');
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$deleted = '0';
		$inventory_1 = $this->Inventory_4_model->get_data('ms_inventory_type','deleted',$deleted);
		$maker = $this->Inventory_4_model->get_data('negara');
		$dimensi = $this->Inventory_4_model->get_data('ms_dimensi','id_bentuk',$id_data);
		$id_bentuk = $this->Inventory_4_model->get_data('ms_bentuk','id_bentuk',$id_data);
		$id_supplier = $this->Inventory_4_model->get_data('master_supplier','deleted',$deleted);
		$id_surface = $this->Inventory_4_model->get_data('ms_surface');
		$data = [
			'inventory_1' => $inventory_1,
			'id_bentuk' => $id_bentuk,
			'dimensi' => $dimensi,
			'maker' => $maker,
			'id_surface' => $id_surface,
			'id_supplier' => $id_supplier
		];
        $this->template->set('results', $data);
        $this->template->title('Add Inventory');
        $this->template->render('add_inventory');

    }

		public function AddStock($id)
    {
		$id_category3 = $this->uri->segment(3);
		$id_data 	= $this->input->post('id');
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$inventory_3 = $this->Inventory_4_model->GetMaterial($id_category3);
		$gudang = $this->Inventory_4_model->get_data('ms_gudang');
		$data = [
			'inventory_3' => $inventory_3,
			'gudang' => $gudang
		];
        $this->template->set('results', $data);
        $this->template->title('Add Stock');
        $this->template->render('AddStock');

    }
	
			public function EditStock($id)
    {
		$id_category3 = $this->uri->segment(3);
		$id_data 	= $this->input->post('id');
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$inventory_3 = $this->Inventory_4_model->GetMaterial($id_category3);
		$gudang = $this->Inventory_4_model->get_data('ms_gudang');
		$data = [
			'inventory_3' => $inventory_3,
			'gudang' => $gudang
		];
        $this->template->set('results', $data);
        $this->template->title('Add Stock');
        $this->template->render('EditStock');

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
	public function PrintHeader(){
		ob_clean();
		ob_start();
        $this->auth->restrict($this->managePermission);
		$data['header']  = $this->Inventory_4_model->get_data_category3();
		$data['sum'] = $this->db->query("SELECT SUM(a.weight) as weight FROM stock_material as a INNER JOIN ms_inventory_category3 as b ON a.id_category3 = b.id_category3 INNER JOIN ms_inventory_type as c ON c.id_type = b.id_type INNER JOIN ms_inventory_category1 as d ON d.id_category1 = b.id_category1 INNER JOIN ms_inventory_category2 as e ON e.id_category2 = b.id_category2")->result();
		$this->template->title('Data');
		$this->load->view('PrintHeader',$data);
		$html = ob_get_contents();
		require_once('./assets/html2pdf/html2pdf/html2pdf.class.php');
		$html2pdf = new HTML2PDF('L','A4','en',true,'UTF-8',array(0, 0, 0, 0));
		$html2pdf->pdf->SetDisplayMode('fullpage');
		$html2pdf->WriteHTML($html);
		ob_end_clean();
		$html2pdf->Output($id.'.pdf', 'I');
	}
	public function deleteInventory(){
		$this->auth->restrict($this->deletePermission);
		$id = $this->input->post('id');
		$data = [
			'deleted' 		=> '1',
			'deleted_by' 	=> $this->auth->user_id()
		];
		
		$this->db->trans_begin();
		$this->db->where('id_category3',$id)->update("ms_inventory_category3",$data);
		
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
        $data=$this->Inventory_4_model->level_2($inventory_1);
        echo "<select id='inventory_2' name='hd1[1][inventory_2]' class='form-control onchange='get_inv3()'  input-sm select2'>";
        echo "<option value=''>--Pilih--</option>";
                foreach ($data as $key => $st) :
				      echo "<option value='$st->id_category1' set_select('inventory_2', $st->id_category1, isset($data->id_category1) && $data->id_category1 == $st->id_category1)>$st->nama
                    </option>";
                endforeach;
        echo "</select>";
    }
		function get_inven3()
    {
        $inventory_2=$_GET['inventory_2'];
        $data=$this->Inventory_4_model->level_3($inventory_2);
		
        // print_r($data);
        // exit();
        echo "<select id='inventory_3' name='hd1[1][inventory_3]' class='form-control input-sm select2'>";
        echo "<option value=''>--Pilih--</option>";
                foreach ($data as $key => $st) :
				      echo "<option value='$st->id_category2' set_select('inventory_3', $st->id_category2, isset($data->id_category2) && $data->id_category2 == $st->id_category2)>$st->nama
                    </option>";
                endforeach;
        echo "</select>";
    }
		public function saveNewStock()
    {
        $this->auth->restrict($this->addPermission);
		$post = $this->input->post();
		$id_inventory = $post['id_inventory'];
		$code = $this->Inventory_4_model->generate_id();
		$this->db->trans_begin();
		$data = [
							'id_stock'				=> $code,
							'id_category3'			=> $post['id_inventory'],
							'nama_material'			=> $post['nm_inventory'],
							'width'					=> $post['width'],
							'lotno'					=> $post['lotno'],
							'qty'					=> $post['qty'],
							'id_bentuk'					=> $post['id_bentuk'],
							'length'					=> $post['length'],
							'thickness'					=> $post['thickness'],
							'weight'				=> $post['weight'],
							'totalweight'			=> $post['qty']*$post['weight'],
							'aktif'					=> 'Y',
							'id_gudang'				=> $post['status'],
							'created_on'			=> date('Y-m-d H:i:s'),
							'created_by'			=> $this->auth->user_id()
                            ];
            //Add Data
               $this->db->insert('stock_material',$data);	
		
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$status	= array(
			  'pesan'		=>'Gagal Save Item. Thanks ...',
			  'code'	=> $id_inventory,
			  'status'	=> 0
			  
			);
		} else {
			$this->db->trans_commit();
			$status	= array(
			  'pesan'		=>'Success Save Item. invenThanks ...',
			  'code'	=> $id_inventory,
			  'status'	=> 1
			  
			);			
		}
		
  		echo json_encode($status);

    }
	public function saveEditInventory()
    {
        $this->auth->restrict($this->addPermission);
		$session = $this->session->userdata('app_session');
		$code = $this->Inventory_4_model->generate_id();
		$this->db->trans_begin();
		$id = $_POST['hd1']['1']['id_category3'];
		$id_bentuk = $_POST['hd1']['1']['id_bentuk'];
		$numb1 =0;
		foreach($_POST['hd1'] as $h1){
		$numb1++;        
                $header1 =  array(
							'id_type'		        => $h1[inventory_1],
							'id_category1'		    => $h1[inventory_2],
							'id_category2'		    => $h1[inventory_3],
							'nama'		        	=> $h1[nm_inventory],
							'maker'		        	=> $h1[maker],
							'density'		        => $h1[density],
							'hardness'		        => $h1[hardness],
							'id_bentuk'		        => $h1[id_bentuk],
							'id_surface'		    => $h1[id_surface],
							'mountly_forecast'		=> $h1[mountly_forecast],
							'safety_stock'		    => $h1[safety_stock],
							'order_point'		    => $h1[order_point],
							'maksimum'		    	=> $h1[maksimum],
							'aktif'					=> 'aktif',
							'created_on'		=> date('Y-m-d H:i:s'),
							'created_by'		=> $this->auth->user_id(),
							'deleted'			=> '0' 
                            );
                     $this->db->where('id_category3',$id)->update("ms_inventory_category3",$header1);
			
		    }
					
		if(empty($_POST['data1'])){
		}else{
		$this->db->delete('child_inven_suplier', array('id_category3' => $id));
		$numb2 =0;
		
		foreach($_POST['data1'] as $d1){
		$numb2++;	   
              $data1 =  array(
			                    'id_category3'=>$id, 
								'id_suplier'=>$d1[id_supplier],
								'lead'=>$d1[lead],
								'minimum'=>$d1[minimum],
								'deleted' =>'0',
							    'created_on' => date('Y-m-d H:i:s'),
								'created_by' => $this->auth->user_id(),
                            );
            //Add Data
              $this->db->insert('child_inven_suplier',$data1);
			
		    }		
		}
		
		if(empty($_POST['compo'])){
		}else{
		$this->db->delete('child_inven_compotition', array('id_category3' => $id));
		$numb3 =0;
		foreach($_POST['compo'] as $c1){
		$numb3++;	   
              $comp =  array(
			                    'id_category3'=>$id, 
								'id_compotition'=>$c1[id_compotition],
								'nilai_compotition'=>$c1[jumlah_kandungan],
								'deleted' =>'0',
							    'created_on' => date('Y-m-d H:i:s'),
								'created_by' => $this->auth->user_id(),
                            );
            //Add Data
              $this->db->insert('child_inven_compotition',$comp);
			
		    }		
		}
		
		if(empty($_POST['dimens'])){
		}else{
		$this->db->delete('child_inven_dimensi', array('id_category3' => $id));
		$numb4 =0;
		foreach($_POST['dimens'] as $dm){
		$numb4++;	   
              $dms =  array(
			                    'id_category3'=>$id, 
								'id_dimensi'=>$dm[id_dimensi],
								'nilai_dimensi'=>$dm[nilai_dimensi],
								'deleted' =>'0',
							    'created_on' => date('Y-m-d H:i:s'),
								'created_by' => $this->auth->user_id(),
                            );
            //Add Data
              $this->db->insert('child_inven_dimensi',$dms);
			
		    }		
		}
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$status	= array(
			  'pesan'		=>'Gagal Save Item. Thanks ...',
			  'code' => $id_bentuk,
			  'status'	=> 0
			);
		} else {
			$this->db->trans_commit();
			$status	= array(
			  'pesan'		=>'Success Save Item. invenThanks ...',
			  'code' => $id_bentuk,
			  'status'	=> 1
			);			
		}
		
  		echo json_encode($status);

    }
		function get_compotition_new()
    {
        $inventory_2=$_GET['inventory_2'];
        $comp=$this->Inventory_4_model->compotition($inventory_2);
		$numb = 0;
        // print_r($data);
        // exit();
                foreach ($comp as $key => $cmp): $numb++;
				      echo "<tr>
					  <td hidden align='left'>
					  <input type='text' name='compo[$numb][id_compotition]' readonly class='form-control'  value='$cmp->id_compotition'>
					  </td>
					  <td align='left'>
					  $cmp->name_compotition
					  </td>
					  <td align='left'>
					  <input type='text' name='compo[$numb][jumlah_kandungan]' class='form-control'>
					  </td>
					  <td align='left'>%</td>
                    </tr>";
                endforeach;
        echo "</select>";
    }
	function get_dimensi()
    {
        $id_bentuk=$_GET['id_bentuk'];
        $dim=$this->Inventory_4_model->bentuk($id_bentuk);
		$numb = 0;
        // print_r($data);
        // exit();
                foreach ($dim as $key => $ensi): $numb++;
				      echo "<tr>
					  <td align='left' hidden>
					  <input type='text' name='dimens[$numb][id_dimensi]' readonly class='form-control'  value='$ensi->id_dimensi'>
					  </td>
					  <td align='left'>
					  $ensi->nm_dimensi
					  </td>
					  <td align='left'>
					  <input type='text' name='dimens[$numb][nilai_dimensi]' class='form-control'>
					  </td>
                    </tr>";
                endforeach;
        echo "</select>";
    }
	function get_compotition_old()
    {
        $inventory_2=$_GET['inventory_2'];
        $comp=$this->Inventory_4_model->compotition_edit($inventory_2);
		$numb = 0;
        // print_r($data);
        // exit();
                foreach ($comp as $key => $cmp): $numb++;
				      echo "<tr>
					  <td hidden align='left'>
					  <input type='text' name='compo[$numb][id_compotition]' readonly class='form-control'  value='$cmp->id_compotition'>
					  </td>
					  <td align='left'>
					  $cmp->name_compotition
					  </td>
					  <td align='left'>
					  <input type='text' name='compo[$numb][jumlah_kandungan]' class='form-control'>
					  </td>
					  <td align='left'>%</td>
                    </tr>";
                endforeach;
        echo "</select>";
    }
	function get_dimensi_old()
    {
        $id_bentuk=$_GET['id_bentuk'];
        $dim=$this->Inventory_4_model->bentuk_edit($id_bentuk);
		$numb = 0;
        // print_r($data);
        // exit();
                foreach ($dim as $key => $ensi): $numb++;
				      echo "<tr>
					  <td hidden align='left'>
					  <input type='text' name='dimens[$numb][id_dimensi]' readonly class='form-control'  value='$cmp->id_dimensi'>
					  </td>
					  <td align='left'>
					  $ensi->nm_dimensi
					  </td>
					  <td align='left'>
					  <input type='text' name='dimens[$numb][nilai_dimensi]' class='form-control'>
					  </td>
                    </tr>";
                endforeach;
        echo "</select>";
    }
	public function saveEditInventorylama()
    {
        $this->auth->restrict($this->addPermission);
		$session = $this->session->userdata('app_session');
		$code = $this->Inventory_4_model->generate_id();
		$this->db->trans_begin();
		$id =$_POST['hd1']['1']['id_category3'];
		$numb1 =0;
		//$head = $_POST['hd1'];
		foreach($_POST['hd1'] as $h1){
		$numb1++;	
		        
                $header1 =  array(
							'id_type'		        => $h1[inventory_1],
							'id_category1'		    => $h1[inventory_2],
							'id_category2'		    => $h1[inventory_3],
							'nama'		        	=> $h1[nm_inventory],
							'maker'		        	=> $h1[maker],
							'density'		        => $h1[density],
							'hardness'		        => $h1[hardness],
							'id_bentuk'		        => $h1[id_bentuk],
							'id_surface'		    => $h1[id_surface],
							'mountly_forecast'		=> $h1[mountly_forecast],
							'safety_stock'		    => $h1[safety_stock],
							'order_point'		    => $h1[order_point],
							'maksimum'		    	=> $h1[maksimum],
							'aktif'					=> 'aktif',
							'created_on'		=> date('Y-m-d H:i:s'),
							'created_by'		=> $this->auth->user_id(),
							'deleted'			=> '0' 
                            );
            //Add Data
              $this->db->where('id_category3',$id)->update("ms_inventory_category3",$data);
			
		    }	
		$this->db->delete('child_inven_suplier', array('id_category3' => $id));
		if(empty($_POST['data1'])){
		}else{
		$numb2 =0;
		foreach($_POST['data1'] as $d1){
		$numb2++;	   
              $data1 =  array(
			                    'id_category3'=>$code, 
								'id_suplier'=>$d1[id_supplier],
								'lead'=>$d1[lead],
								'minimum'=>$d1[minimum],
								'deleted' =>'0',
							    'created_on' => date('Y-m-d H:i:s'),
								'created_by' => $this->auth->user_id(),
                            );
            //Add Data
              $this->db->insert('child_inven_suplier',$data1);
			
		    }		
		}	
		if(empty($_POST['compo'])){
		}else{
		$numb3 =0;
		foreach($_POST['compo'] as $c1){
		$numb3++;	   
              $comp =  array(
			                    'id_category3'=>$code, 
								'id_compotition'=>$c1[id_compotition],
								'nilai_compotition'=>$c1[jumlah_kandungan],
								'deleted' =>'0',
							    'created_on' => date('Y-m-d H:i:s'),
								'created_by' => $this->auth->user_id(),
                            );
            //Add Data
              $this->db->insert('child_inven_compotition',$comp);
			
		    }		
		}
		if(empty($_POST['dimens'])){
		}else{
		$numb4 =0;
		foreach($_POST['dimens'] as $dm){
		$numb4++;	   
              $dms =  array(
			                    'id_category3'=>$code, 
								'id_dimensi'=>$dm[id_dimensi],
								'nilai_dimensi'=>$dm[nilai_dimensi],
								'deleted' =>'0',
							    'created_on' => date('Y-m-d H:i:s'),
								'created_by' => $this->auth->user_id(),
                            );
            //Add Data
              $this->db->insert('child_inven_dimensi',$dms);
			
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
	public function saveEditInventoryOld()
    {
        $this->auth->restrict($this->addPermission);
		$session = $this->session->userdata('app_session');
		$code = $this->Inventory_4_model->generate_id();
		$this->db->trans_begin();
		$id =$_POST['hd1']['1']['id_category3'];
		$numb1 =0;
		//$head = $_POST['hd1'];
		foreach($_POST['hd1'] as $h1){
		$numb1++;	
		        
                $header1 =  array(
							'id_type'		        => $h1[inventory_1],
							'id_category1'		    => $h1[inventory_2],
							'id_category2'		    => $h1[inventory_3],
							'nama'		        	=> $h1[nm_inventory],
							'maker'		        	=> $h1[maker],
							'density'		        => $h1[density],
							'hardness'		        => $h1[hardness],
							'id_bentuk'		        => $h1[id_bentuk],
							'id_surface'		    => $h1[id_surface],
							'mountly_forecast'		=> $h1[mountly_forecast],
							'safety_stock'		    => $h1[safety_stock],
							'order_point'		    => $h1[order_point],
							'maksimum'		    	=> $h1[maksimum],
							'aktif'					=> 'aktif',
							'created_on'		=> date('Y-m-d H:i:s'),
							'created_by'		=> $this->auth->user_id(),
							'deleted'			=> '0' 
                            );
            //Add Data
              $this->db->where('id_category3',$id)->update("ms_inventory_category3",$data);
			
		    }		
		if(empty($_POST['data1'])){
		}else{
		$numb2 =0;
		foreach($_POST['data1'] as $d1){
		$numb2++;	   
              $data1 =  array(
			                    'id_category3'=>$id, 
								'id_suplier'=>$d1[id_supplier],
								'lead'=>$d1[lead],
								'minimum'=>$d1[minimum],
								'deleted' =>'0',
							    'created_on' => date('Y-m-d H:i:s'),
								'created_by' => $this->auth->user_id(),
                            );
            //Add Data
              $this->db->insert('child_inven_suplier',$data1);
			
		    }		
		}	
		if(empty($_POST['compo'])){
		}else{
		$numb3 =0;
		foreach($_POST['compo'] as $c1){
		$numb3++;	   
              $comp =  array(
			                    'id_category3'=>$id, 
								'id_compotition'=>$c1[id_compotition],
								'nilai_compotition'=>$c1[jumlah_kandungan],
								'deleted' =>'0',
							    'created_on' => date('Y-m-d H:i:s'),
								'created_by' => $this->auth->user_id(),
                            );
            //Add Data
              $this->db->insert('child_inven_compotition',$comp);
			
		    }		
		}
		if(empty($_POST['dimens'])){
		}else{
		$numb4 =0;
		foreach($_POST['dimens'] as $dm){
		$numb4++;	   
              $dms =  array(
			                    'id_category3'=>$id, 
								'id_dimensi'=>$dm[id_dimensi],
								'nilai_dimensi'=>$dm[nilai_dimensi],
								'deleted' =>'0',
							    'created_on' => date('Y-m-d H:i:s'),
								'created_by' => $this->auth->user_id(),
                            );
            //Add Data
              $this->db->insert('child_inven_dimensi',$dms);
			
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
		function get_compotition()
    {
        $inventory_2=$_GET['inventory_2'];
        $comp=$this->Inventory_4_model->compotition($inventory_2);
		$numb = 0;
        // print_r($data);
        // exit();
                foreach ($comp as $key => $cmp): $numb++;
				      echo "<tr>
					  <td hidden align='left'>
					  <input type='text' name='compo[$numb][id_compotition]' readonly class='form-control'  value='$cmp->id_compotition'>
					  </td>
					  <td align='left'>
					  $cmp->name_compotition
					  </td>
					  <td align='left'>
					  <input type='text' name='compo[$numb][jumlah_kandungan]' class='form-control'>
					  </td>
					  <td align='left'>%</td>
                    </tr>";
                endforeach;
        echo "</select>";
    }

	
}
