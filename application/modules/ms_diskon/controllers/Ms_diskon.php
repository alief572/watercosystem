<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/*
 * @author Syamsudin
 * @copyright Copyright (c) 2022, Syamsudin
 *
 * This is controller for Master diskon
 */

class Ms_diskon extends Admin_Controller
{
    //Permission
    protected $viewPermission 	= 'Diskon.View';
    protected $addPermission  	= 'Diskon.Add';
    protected $managePermission = 'Diskon.Manage';
    protected $deletePermission = 'Diskon.Delete';

    public function __construct()
    {
        parent::__construct();

        $this->load->library(array('Mpdf', 'upload', 'Image_lib'));
        $this->load->model(array('ms_diskon/Ms_diskon_model',
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
        $data = $this->Ms_diskon_model->get_data_diskon();
        $this->template->set('results', $data);
        $this->template->title('Diskon');
        $this->template->render('index');
    }


    public function AddDiskon()
    {
        $this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-plus');
		$this->template->title('Add Diskon');
        $this->template->render('adddiskon');
    }
    
    function GetProduk()
    {
		$loop=$_GET['jumlah']+1;
		
		$customers = $this->Ms_diskon_model->get_data('master_customers','deleted',$deleted);
		
		
		$material = $this->db->query("SELECT a.* FROM ms_inventory_type as a ")->result();
        $top      = $this->db->query("SELECT a.* FROM ms_top as a ")->result();
		
		
		
		echo "
		<tr id='tr_$loop'>
			<td>$loop</td>
			<td>
				<select id='used_level1_$loop' name='dt[$loop][level1]' data-no='$loop' class='form-control select' required>
					<option value=''>-Pilih-</option>";					
					foreach($material as $produk){
					echo"<option value='$produk->id_type'>$produk->nama</option>";
					}
		echo	"</select>
			</td>
            <td>
				<select id='used_top_$loop' name='dt[$loop][top]' data-no='$loop' class='form-control select' required>
					<option value=''>-Pilih-</option>";					
					foreach($top as $top){
					echo"<option value='$top->id_top'>$top->nama_top</option>";
					}
		echo	"</select>
			</td>";

		echo	"<td id='nilai_$loop'><input type='text' align='right' class='form-control input-sm' id='used_nilai_$loop' required name='dt[$loop][nilai]'></td>
                <td align='center'>
                <button type='button' class='btn btn-sm btn-danger' title='Hapus Data' data-role='qtip' onClick='return HapusItem($loop);'><i class='fa fa-close'></i></button>
                </td>
			
		</tr>
		";
	}


    public function SaveNewDiskon()
    {
        $this->auth->restrict($this->addPermission);
		$post = $this->input->post();
       	$this->db->trans_begin();

	           $numb1 =0;
               foreach($_POST['dt'] as $used){
                   if(!empty($used[level1])){
                       $numb1++;   
                       $dt[] =  array(
                               'id_type'		    => $used[level1],
                               'id_top'		        => $used[top],
                               'nilai_diskon'	    => $used[nilai],
                               'created_on'			=> date('Y-m-d H:i:s'),
                               'created_by'			=> $this->auth->user_id()                       
                               );
                   }
               }
            //    print_r($dt);
            //    exit();
            $this->db->insert_batch('ms_diskon',$dt);

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$status	= array(
			  'pesan'		=>'Gagal Save Item. Thanks ...',
			  'code' => $code,
			  'status'	=> 0
			);
		} else {
			$this->db->trans_commit();
			$status	= array(
			  'pesan'		=>'Success Save Item. invenThanks ...',
			  'code' => $code,
			  'status'	=> 1
			);
		}

  		echo json_encode($status);

    }


    public function editDiskon($id){
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-edit');
		$diskon = $this->db->get_where('ms_diskon',array('id' => $id))->result();
		$lvl1 = $this->Ms_diskon_model->get_data('ms_inventory_type');
		$lvl2 = $this->Ms_diskon_model->get_data('ms_top');
		$data = [
			'diskon' => $diskon,
			'lvl1' => $lvl1,
			'lvl2' => $lvl2
		];
        $this->template->set('results', $data);
		$this->template->title('Diskon');
        $this->template->render('editdiskon');
		
	}

    public function saveEditDiskon(){
		$this->auth->restrict($this->editPermission);
		$post = $this->input->post();
		// print_r($post);
		// exit();
		$this->db->trans_begin();
		$data = [
			'id_type'		    => $post['level1'],
			'id_top'		    => $post['top'],
			'nilai_diskon'      => $post['nilai'],
		    'modified_on'		=> date('Y-m-d H:i:s'),
			'modified_by'		=> $this->auth->user_id()
		];
	 
		$this->db->where('id',$post['id_diskon'])->update("ms_diskon",$data);
		
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$status	= array(
			  'pesan'		=>'Gagal Save Data. Thanks ...',
			  'status'	=> 0
			);
		} else {
			$this->db->trans_commit();
			$status	= array(
			  'pesan'		=>'Success Save Data. Thanks ...',
			  'status'	=> 1
			);			
		}
		
  		echo json_encode($status);
	
	}

    public function deleteDiskon(){
		$this->auth->restrict($this->deletePermission);
		$id = $this->input->post('id');
		$data = [
			'deleted' 		=> '1',
			'deleted_by' 	=> $this->auth->user_id()
		];
		
		$this->db->trans_begin();
		$this->db->where('id',$id)->update("ms_diskon",$data);
		
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
