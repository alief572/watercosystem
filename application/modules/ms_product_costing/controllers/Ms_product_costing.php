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

class Ms_product_costing extends Admin_Controller
{
    //Permission
    protected $viewPermission 	= 'Formula.View';
    protected $addPermission  	= 'Formula.Add';
    protected $managePermission = 'Formula.Manage';
    protected $deletePermission = 'Formula.Delete';

    public function __construct()
    {
        parent::__construct();

        $this->load->library(array('Mpdf', 'upload', 'Image_lib'));
        $this->load->model(array('ms_product_costing/Ms_product_costing_model',
                                 'Aktifitas/aktifitas_model', 'Inventory_4/Inventory_4_model',
                                ));
        $this->template->title('Manage Data Supplier');
        $this->template->page_icon('fa fa-building-o');

        date_default_timezone_set('Asia/Bangkok');
    }

    public function formula()
    {
       $this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
		$deleted = '0';
        $data = $this->Ms_product_costing_model->get_data_formula();
        $this->template->set('results', $data);
        $this->template->title('Formula Product Costing');
        $this->template->render('index_formula');
    }


    public function AddFormula()
    {
        $this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-plus');
        $material = $this->Ms_product_costing_model->get_data_usage();
		$data = [
			'material' => $material
		];
        $this->template->set('results', $data);
		$this->template->title('Add Formula');
        $this->template->render('addformula');
    }
    
    function GetProduk()
    {
		$loop=$_GET['jumlah']+1;
		
		$customers = $this->Ms_product_costing_model->get_data('master_customers','deleted',$deleted);
		
		
		$komponen = $this->db->query("SELECT a.* FROM ms_product_costing_komponen as a ")->result();
        $top      = $this->db->query("SELECT a.* FROM ms_top as a ")->result();
		
		
		
		echo "
		<tr id='tr_$loop'>
			<td>1</td>
			<td>
				<select id='used_komponen_bm_$loop' name='dt[$loop][komponen_bm]' data-no='$loop' class='form-control select' required>
					<option value=''>-Pilih-</option>";					
					//foreach($komponen as $produk){
					echo"<option value='1' selected>BM</option>";
					//}
		echo	"</select>
			</td>";          

		echo	"<td id='persentase_bm_$loop'><input type='text' align='right' class='form-control input-sm autoNumeric' id='used_persentase_bm_$loop' required name='dt[$loop][persentase_bm]'></td>
                 <td id='nilai_bm_$loop' hidden><input type='text' align='right' class='form-control input-sm autoNumeric' id='used_nilai_bm_$loop' required name='dt[$loop][nilai_bm]' readonly></td>
                 <td id='keterangan_bm_$loop'><input type='text' align='right' class='form-control input-sm' id='used_keterangan_bm_$loop' required name='dt[$loop][keterangan_bm]'></td>
                <td align='center'>
                <button type='button' class='btn btn-sm btn-danger' title='Hapus Data' data-role='qtip' onClick='return HapusItem($loop);'><i class='fa fa-close'></i></button>
                </td>
			
		</tr>
		<tr id='tr_$loop'>
			<td>2</td>
			<td>
				<select id='used_komponen_lc_$loop' name='dt[$loop][komponen_lc]' data-no='$loop' class='form-control select' required>
					<option value=''>-Pilih-</option>";					
					//foreach($komponen as $produk){
					echo"<option value='2' selected>Landed Cost</option>";
					//}
		echo	"</select>
			</td>";          

		echo	"<td id='persentase_lc_$loop'><input type='text' align='right' class='form-control input-sm autoNumeric' id='used_persentase_lc_$loop' required name='dt[$loop][persentase_lc]'></td>
                 <td id='nilai_lc_$loop' hidden><input type='text' align='right' class='form-control input-sm autoNumeric' id='used_nilai_lc_$loop' required name='dt[$loop][nilai_lc]' readonly></td>
                 <td id='keterangan_lc_$loop'><input type='text' align='right' class='form-control input-sm' id='used_keterangan_lc_$loop' required name='dt[$loop][keterangan_lc]'></td>
                <td align='center'>
                <button type='button' class='btn btn-sm btn-danger' title='Hapus Data' data-role='qtip' onClick='return HapusItem($loop);'><i class='fa fa-close'></i></button>
                </td>
			
		</tr>
		<tr id='tr_$loop'>
			<td>3</td>
			<td>
				<select id='used_komponen_oc_$loop' name='dt[$loop][komponen_oc]' data-no='$loop' class='form-control select' required>
					<option value=''>-Pilih-</option>";					
					//foreach($komponen as $produk){
					echo"<option value='3' selected>Operational Cost</option>";
					//}
		echo	"</select>
			</td>";          

		echo	"<td id='persentase_oc_$loop'><input type='text' align='right' class='form-control input-sm autoNumeric' id='used_persentase_oc_$loop' required name='dt[$loop][persentase_oc]'></td>
                 <td id='nilai_oc_$loop' hidden><input type='text' align='right' class='form-control input-sm autoNumeric' id='used_nilai_oc_$loop' required name='dt[$loop][nilai_oc]' readonly></td>
                 <td id='keterangan_oc_$loop'><input type='text' align='right' class='form-control input-sm' id='used_keterangan_oc_$loop' required name='dt[$loop][keterangan_oc]'></td>
                <td align='center'>
                <button type='button' class='btn btn-sm btn-danger' title='Hapus Data' data-role='qtip' onClick='return HapusItem($loop);'><i class='fa fa-close'></i></button>
                </td>
			
		</tr>
		<tr id='tr_$loop'>
			<td>4</td>
			<td>
				<select id='used_komponen_margin_$loop' name='dt[$loop][komponen_margin]' data-no='$loop' class='form-control select' required>
					<option value=''>-Pilih-</option>";					
					//foreach($komponen as $produk){
					echo"<option value='4' selected>Margin</option>";
					//}
		echo	"</select>
			</td>";          

		echo	"<td id='persentase_margin_$loop'><input type='text' align='right' class='form-control input-sm autoNumeric' id='used_persentase_margin_$loop' required name='dt[$loop][persentase_margin]'></td>
                 <td id='nilai_margin_$loop' hidden><input type='text' align='right' class='form-control input-sm autoNumeric' id='used_nilai_margin_$loop' required name='dt[$loop][nilai_margin]' readonly></td>
                 <td id='keterangan_margin_$loop'><input type='text' align='right' class='form-control input-sm' id='used_keterangan_margin_$loop' required name='dt[$loop][keterangan_margin]'></td>
                <td align='center'>
                <button type='button' class='btn btn-sm btn-danger' title='Hapus Data' data-role='qtip' onClick='return HapusItem($loop);'><i class='fa fa-close'></i></button>
                </td>
			
		</tr>
		<tr id='tr_$loop'>
			<td>5</td>
			<td>
				<select id='used_komponen_dd_$loop' name='dt[$loop][komponen_dd]' data-no='$loop' class='form-control select' required>
					<option value=''>-Pilih-</option>";					
					//foreach($komponen as $produk){
					echo"<option value='5' selected>Discount Distributor</option>";
					//}
		echo	"</select>
			</td>";          

		echo	"<td id='persentase_dd_$loop'><input type='text' align='right' class='form-control input-sm autoNumeric' id='used_persentase_dd_$loop' required name='dt[$loop][persentase_dd]'></td>
                 <td id='nilai_dd_$loop' hidden><input type='text' align='right' class='form-control input-sm autoNumeric' id='used_nilai_dd_$loop' required name='dt[$loop][nilai_dd]' readonly></td>
                 <td id='keterangan_dd_$loop'><input type='text' align='right' class='form-control input-sm' id='used_keterangan_dd_$loop' required name='dt[$loop][keterangan_dd]'></td>
                <td align='center'>
                <button type='button' class='btn btn-sm btn-danger' title='Hapus Data' data-role='qtip' onClick='return HapusItem($loop);'><i class='fa fa-close'></i></button>
                </td>
			
		</tr>
		<tr id='tr_$loop'>
			<td>6</td>
			<td>
				<select id='used_komponen_da_$loop' name='dt[$loop][komponen_da]' data-no='$loop' class='form-control select' required>
					<option value=''>-Pilih-</option>";					
					//foreach($komponen as $produk){
					echo"<option value='6' selected>Discount Agent</option>";
					//}
		echo	"</select>
			</td>";          

		echo	"<td id='persentase_da_$loop'><input type='text' align='right' class='form-control input-sm autoNumeric' id='used_persentase_da_$loop' required name='dt[$loop][persentase_da]'></td>
                 <td id='nilai_da_$loop' hidden><input type='text' align='right' class='form-control input-sm autoNumeric' id='used_nilai_da_$loop' required name='dt[$loop][nilai_da]' readonly></td>
                 <td id='keterangan_da_$loop'><input type='text' align='right' class='form-control input-sm' id='used_keterangan_da_$loop' required name='dt[$loop][keterangan_da]'></td>
                <td align='center'>
                <button type='button' class='btn btn-sm btn-danger' title='Hapus Data' data-role='qtip' onClick='return HapusItem($loop);'><i class='fa fa-close'></i></button>
                </td>
			
		</tr>
		<tr id='tr_$loop'>
			<td>7</td>
			<td>
				<select id='used_komponen_de_$loop' name='dt[$loop][komponen_de]' data-no='$loop' class='form-control select' required>
					<option value=''>-Pilih-</option>";					
					//foreach($komponen as $produk){
					echo"<option value='7' selected>Discount End User</option>";
					//}
		echo	"</select>
			</td>";          

		echo	"<td id='persentase_de_$loop'><input type='text' align='right' class='form-control input-sm autoNumeric' id='used_persentase_de_$loop' required name='dt[$loop][persentase_de]'></td>
                 <td id='nilai_de_$loop' hidden><input type='text' align='right' class='form-control input-sm autoNumeric' id='used_nilai_de_$loop' required name='dt[$loop][nilai_de]' readonly></td>
                 <td id='keterangan_de_$loop'><input type='text' align='right' class='form-control input-sm' id='used_keterangan_de_$loop' required name='dt[$loop][keterangan_de]'></td>
                <td align='center'>
                <button type='button' class='btn btn-sm btn-danger' title='Hapus Data' data-role='qtip' onClick='return HapusItem($loop);'><i class='fa fa-close'></i></button>
                </td>
			
		</tr>
		<tr id='tr_$loop'>
		<td>8</td>
		<td>
			<select id='used_komponen_aj_$loop' name='dt[$loop][komponen_aj]' data-no='$loop' class='form-control select' required>
				<option value=''>-Pilih-</option>";					
				//foreach($komponen as $produk){
				echo"<option value='8' selected>Adjustable</option>";
				//}
	echo	"</select>
		</td>";          

	echo	"<td id='persentase_aj_$loop'><input type='text' align='right' class='form-control input-sm autoNumeric' id='used_persentase_aj_$loop' required name='dt[$loop][persentase_aj]'></td>
			 <td id='nilai_aj_$loop' hidden><input type='text' align='right' class='form-control input-sm autoNumeric' id='used_nilai_aj_$loop' required name='dt[$loop][nilai_aj]' readonly></td>
			 <td id='keterangan_aj_$loop'><input type='text' align='right' class='form-control input-sm' id='used_keterangan_aj_$loop' required name='dt[$loop][keterangan_aj]'></td>
			<td align='center'>
			<button type='button' class='btn btn-sm btn-danger' title='Hapus Data' data-role='qtip' onClick='return HapusItem($loop);'><i class='fa fa-close'></i></button>
			</td>
		
	</tr>
		";
	}


    public function SaveNewFormula()
    {
        $this->auth->restrict($this->addPermission);
		$post = $this->input->post();
		// print_r($post);
		// exit;
       	$this->db->trans_begin();

		   $material=$post['id_material'];
		   $cat = $this->db->query("SELECT * FROM ms_inventory_category2 WHERE id_category2='$material'")->row();
		   $category = $cat->nama;

		   $code = $this->Ms_product_costing_model->generate_code();
		   $data = [
							   'id_product_costing'		=> $code,
							   'id_category2'			=> $post['id_material'],
							   'nama_category2'			=> $category,
							   'revisi'					=> 0,
							   'harga_beli'				=> str_replace(',','',$post['harga_beli']),
							   'total_pricelist'		=> str_replace(',','',$post['total_price']),
							   'created_on'			=> date('Y-m-d H:i:s'),
							   'created_by'			=> $this->auth->user_id()
							   ];
			   //Add Data
				 

	           $numb1 =0;
               foreach($_POST['dt'] as $used){
                   if(!empty($used[komponen_bm])){
                       $numb1++;   
                       $dt1[] =  array(
                               'id_product_costing'		    => $code,
                               'id_category2'		        => $post[id_material],
                               'nama_komponen'	    		=> $used[komponen_bm],
							   'persentase'	    			=> str_replace(',','',$used[persentase_bm]),
							   'nilai_costing'	    		=> str_replace(',','',$used[nilai_bm]),
							   'keterangan'	    			=> $used[keterangan_bm],
                               'created_on'					=> date('Y-m-d H:i:s'),
                               'created_by'					=> $this->auth->user_id()                       
                               );
                   }
               }
			   $numb2 =0;
               foreach($_POST['dt'] as $used){
                   if(!empty($used[komponen_lc])){
                       $numb2++;   
                       $dt2[] =  array(
                               'id_product_costing'		    => $code,
                               'id_category2'		        => $post[id_material],
                               'nama_komponen'	    		=> $used[komponen_lc],
							   'persentase'	    			=> str_replace(',','',$used[persentase_lc]),
							   'nilai_costing'	    		=> str_replace(',','',$used[nilai_lc]),
							   'keterangan'	    			=> $used[keterangan_lc],
                               'created_on'					=> date('Y-m-d H:i:s'),
                               'created_by'					=> $this->auth->user_id()                       
                               );
                   }
               }
			   $numb3 =0;
               foreach($_POST['dt'] as $used){
                   if(!empty($used[komponen_oc])){
                       $numb1++;   
                       $dt3[] =  array(
                               'id_product_costing'		    => $code,
                               'id_category2'		        => $post[id_material],
                               'nama_komponen'	    		=> $used[komponen_oc],
							   'persentase'	    			=> str_replace(',','',$used[persentase_oc]),
							   'nilai_costing'	    		=> str_replace(',','',$used[nilai_oc]),
							   'keterangan'	    			=> $used[keterangan_oc],
                               'created_on'					=> date('Y-m-d H:i:s'),
                               'created_by'					=> $this->auth->user_id()                       
                               );
                   }
               }
			   $numb4 =0;
               foreach($_POST['dt'] as $used){
                   if(!empty($used[komponen_margin])){
                       $numb4++;   
                       $dt4[] =  array(
                               'id_product_costing'		    => $code,
                               'id_category2'		        => $post[id_material],
                               'nama_komponen'	    		=> $used[komponen_margin],
							   'persentase'	    			=> str_replace(',','',$used[persentase_margin]),
							   'nilai_costing'	    		=> str_replace(',','',$used[nilai_margin]),
							   'keterangan'	    			=> $used[keterangan_margin],
                               'created_on'					=> date('Y-m-d H:i:s'),
                               'created_by'					=> $this->auth->user_id()                       
                               );
                   }
               }
			   $numb5 =0;
               foreach($_POST['dt'] as $used){
                   if(!empty($used[komponen_dd])){
                       $numb5++;   
                       $dt5[] =  array(
                               'id_product_costing'		    => $code,
                               'id_category2'		        => $post[id_material],
                               'nama_komponen'	    		=> $used[komponen_dd],
							   'persentase'	    			=> str_replace(',','',$used[persentase_dd]),
							   'nilai_costing'	    		=> str_replace(',','',$used[nilai_dd]),
							   'keterangan'	    			=> $used[keterangan_dd],
                               'created_on'					=> date('Y-m-d H:i:s'),
                               'created_by'					=> $this->auth->user_id()                       
                               );
                   }
               }
			   $numb6 =0;
               foreach($_POST['dt'] as $used){
                   if(!empty($used[komponen_da])){
                       $numb6++;   
                       $dt6[] =  array(
                               'id_product_costing'		    => $code,
                               'id_category2'		        => $post[id_material],
                               'nama_komponen'	    		=> $used[komponen_da],
							   'persentase'	    			=> str_replace(',','',$used[persentase_da]),
							   'nilai_costing'	    		=> str_replace(',','',$used[nilai_da]),
							   'keterangan'	    			=> $used[keterangan_da],
                               'created_on'					=> date('Y-m-d H:i:s'),
                               'created_by'					=> $this->auth->user_id()                       
                               );
                   }
               }
			   $numb7 =0;
               foreach($_POST['dt'] as $used){
                   if(!empty($used[komponen_de])){
                       $numb7++;   
                       $dt7[] =  array(
                               'id_product_costing'		    => $code,
                               'id_category2'		        => $post[id_material],
                               'nama_komponen'	    		=> $used[komponen_de],
							   'persentase'	    			=> str_replace(',','',$used[persentase_de]),
							   'nilai_costing'	    		=> str_replace(',','',$used[nilai_de]),
							   'keterangan'	    			=> $used[keterangan_de],
                               'created_on'					=> date('Y-m-d H:i:s'),
                               'created_by'					=> $this->auth->user_id()                       
                               );
                   }
               }
			   $numb8 =0;
               foreach($_POST['dt'] as $used){
                   if(!empty($used[komponen_aj])){
                       $numb8++;   
                       $dt8[] =  array(
                               'id_product_costing'		    => $code,
                               'id_category2'		        => $post[id_material],
                               'nama_komponen'	    		=> $used[komponen_aj],
							   'persentase'	    			=> str_replace(',','',$used[persentase_aj]),
							   'nilai_costing'	    		=> str_replace(',','',$used[nilai_aj]),
							   'keterangan'	    			=> $used[keterangan_aj],
                               'created_on'					=> date('Y-m-d H:i:s'),
                               'created_by'					=> $this->auth->user_id()                       
                               );
                   }
               }
            //    print_r($dt);
            //    exit();

			$this->db->insert('ms_product_costing',$data);
            $this->db->insert_batch('ms_product_costing_detail',$dt1);
			$this->db->insert_batch('ms_product_costing_detail',$dt2);
			$this->db->insert_batch('ms_product_costing_detail',$dt3);
			$this->db->insert_batch('ms_product_costing_detail',$dt4);
			$this->db->insert_batch('ms_product_costing_detail',$dt5);
			$this->db->insert_batch('ms_product_costing_detail',$dt6);
			$this->db->insert_batch('ms_product_costing_detail',$dt7);
			$this->db->insert_batch('ms_product_costing_detail',$dt8);

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
		$lvl1 = $this->Ms_product_costing_model->get_data('ms_inventory_type');
		$lvl2 = $this->Ms_product_costing_model->get_data('ms_top');
		$data = [
			'diskon' => $diskon,
			'lvl1' => $lvl1,
			'lvl2' => $lvl2
		];
        $this->template->set('results', $data);
		$this->template->title('Diskon');
        $this->template->render('editdiskon');
		
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
    

	public function index_sales()
    {
       $this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
		$deleted = '0';
        $data = $this->Ms_product_costing_model->get_data_pricelist();
        $this->template->set('results', $data);
        $this->template->title('Pricelist');
        $this->template->render('index_pricelist_sales');
    }

	public function calculation()
    {
       $this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
		$deleted = '0';
        $data = $this->Ms_product_costing_model->get_data_pricelist();
        $this->template->set('results', $data);
        $this->template->title('Pricelist');
        $this->template->render('index_pricelist');
    }

	public function AddPricelist()
    {
        $this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-plus');
		$deleted = '0';
        $material = $this->Ms_product_costing_model->get_data_usage();
		$inventory_1 = $this->Ms_product_costing_model->get_data('ms_inventory_type','deleted',$deleted);
		$inventory_2 = $this->Ms_product_costing_model->get_data('ms_inventory_category1','deleted',$deleted);
		$inventory_3 = $this->Ms_product_costing_model->get_data('ms_inventory_category2','deleted',$deleted);
		$inventory_4 = $this->Ms_product_costing_model->get_data('ms_inventory_category3','deleted',$deleted);
		$formula     = $this->Ms_product_costing_model->get_data('ms_product_costing','deleted',$deleted);
		$kurs     = $this->Ms_product_costing_model->get_data('ms_kurs','aktif','Y');
		$data = [
			'inventory_1' => $inventory_1,
			'inventory_2' => $inventory_2,
			'inventory_3' => $inventory_3,
			'inventory_4' => $inventory_4,
			'material' => $formula,
			'kurs' => $kurs

		];
        $this->template->set('results', $data);
		$this->template->title('Add Pricelist');
        $this->template->render('addpricelist');
    }

	function GetPersenPricelist($id)
    {
		$loop=$_GET['jumlah']+1;
		
		$customers = $this->Ms_product_costing_model->get_data('master_customers','deleted',$deleted);
		
		
		$komponen = $this->db->query("SELECT a.* FROM ms_product_costing_komponen as a ")->result();
        $top      = $this->db->query("SELECT a.* FROM ms_top as a ")->result();

		$idcategory = $id;
		$bm		  = $this->db->query("SELECT a.* FROM ms_product_costing_detail as a WHERE a.id_category2='$idcategory' AND nama_komponen=1 ")->row();
		$lc		  = $this->db->query("SELECT a.* FROM ms_product_costing_detail as a WHERE a.id_category2='$idcategory' AND nama_komponen=2 ")->row();
		$oc		  = $this->db->query("SELECT a.* FROM ms_product_costing_detail as a WHERE a.id_category2='$idcategory' AND nama_komponen=3 ")->row();
		$margin	  = $this->db->query("SELECT a.* FROM ms_product_costing_detail as a WHERE a.id_category2='$idcategory' AND nama_komponen=4 ")->row();
		$dd		  = $this->db->query("SELECT a.* FROM ms_product_costing_detail as a WHERE a.id_category2='$idcategory' AND nama_komponen=5 ")->row();
		$da		  = $this->db->query("SELECT a.* FROM ms_product_costing_detail as a WHERE a.id_category2='$idcategory' AND nama_komponen=6 ")->row();
		$de		  = $this->db->query("SELECT a.* FROM ms_product_costing_detail as a WHERE a.id_category2='$idcategory' AND nama_komponen=7 ")->row();
		$aj		  = $this->db->query("SELECT a.* FROM ms_product_costing_detail as a WHERE a.id_category2='$idcategory' AND nama_komponen=8 ")->row();
		
		
		echo "
		<tr id='tr_$loop'>
			<td>1</td>
			<td>
				<select id='used_komponen_bm_$loop' name='dt[$loop][komponen_bm]' data-no='$loop' class='form-control select' required>
					<option value=''>-Pilih-</option>";					
					//foreach($komponen as $produk){
					echo"<option value='1' selected>BM</option>";
					//}
		echo	"</select>
			</td>";          

		echo	"<td id='persentase_bm_$loop'><input type='text' align='right' class='form-control input-sm autoNumeric' id='used_persentase_bm_$loop' required name='dt[$loop][persentase_bm]' value='$bm->persentase' readonly></td>
                 <td id='nilai_bm_$loop'><input type='text' align='right' class='form-control input-sm autoNumeric' id='used_nilai_bm_$loop' required name='dt[$loop][nilai_bm]' readonly></td>
				 <td id='nilai_bm_rp_$loop'><input type='text' align='right' class='form-control input-sm autoNumeric' id='used_nilai_bm_rp_$loop' required name='dt[$loop][nilai_bm_rp]'  readonly></td>
                                                 
				 <td id='keterangan_bm_$loop'><input type='text' align='right' class='form-control input-sm' id='used_keterangan_bm_$loop' required name='dt[$loop][keterangan_bm]' value='$bm->keterangan'></td>
                <td align='center'>
                <button type='button' class='btn btn-sm btn-danger' title='Hapus Data' data-role='qtip' onClick='return HapusItem($loop);'><i class='fa fa-close'></i></button>
                </td>
			
		</tr>
		<tr id='tr_$loop'>
			<td>2</td>
			<td>
				<select id='used_komponen_lc_$loop' name='dt[$loop][komponen_lc]' data-no='$loop' class='form-control select' required>
					<option value=''>-Pilih-</option>";					
					//foreach($komponen as $produk){
					echo"<option value='2' selected>Landed Cost</option>";
					//}
		echo	"</select>
			</td>";          

		echo	"<td id='persentase_lc_$loop'><input type='text' align='right' class='form-control input-sm autoNumeric' id='used_persentase_lc_$loop' required name='dt[$loop][persentase_lc]' value='$lc->persentase' readonly></td>
                 <td id='nilai_lc_$loop'><input type='text' align='right' class='form-control input-sm autoNumeric' id='used_nilai_lc_$loop' required name='dt[$loop][nilai_lc]' readonly></td>
				 <td id='nilai_lc_rp_$loop'><input type='text' align='right' class='form-control input-sm autoNumeric' id='used_nilai_lc_rp_$loop' required name='dt[$loop][nilai_lc_rp]' readonly></td>
                                                
                 <td id='keterangan_lc_$loop'><input type='text' align='right' class='form-control input-sm' id='used_keterangan_lc_$loop' required name='dt[$loop][keterangan_lc]' value='$lc->keterangan'></td>
                <td align='center'>
                <button type='button' class='btn btn-sm btn-danger' title='Hapus Data' data-role='qtip' onClick='return HapusItem($loop);'><i class='fa fa-close'></i></button>
                </td>
			
		</tr>
		<tr id='tr_$loop'>
			<td>3</td>
			<td>
				<select id='used_komponen_oc_$loop' name='dt[$loop][komponen_oc]' data-no='$loop' class='form-control select' required>
					<option value=''>-Pilih-</option>";					
					//foreach($komponen as $produk){
					echo"<option value='3' selected>Operational Cost</option>";
					//}
		echo	"</select>
			</td>";          

		echo	"<td id='persentase_oc_$loop'><input type='text' align='right' class='form-control input-sm autoNumeric' id='used_persentase_oc_$loop' required name='dt[$loop][persentase_oc]' value='$oc->persentase' readonly></td>
                 <td id='nilai_oc_$loop'><input type='text' align='right' class='form-control input-sm autoNumeric' id='used_nilai_oc_$loop' required name='dt[$loop][nilai_oc]' readonly></td>
				 <td id='nilai_oc_rp_$loop'><input type='text' align='right' class='form-control input-sm autoNumeric' id='used_nilai_oc_rp_$loop' required name='dt[$loop][nilai_oc_rp]' readonly ></td>
                                                 
                 <td id='keterangan_oc_$loop'><input type='text' align='right' class='form-control input-sm' id='used_keterangan_oc_$loop' required name='dt[$loop][keterangan_oc]' value='$oc->keterangan'></td>
                <td align='center'>
                <button type='button' class='btn btn-sm btn-danger' title='Hapus Data' data-role='qtip' onClick='return HapusItem($loop);'><i class='fa fa-close'></i></button>
                </td>
			
		</tr>
		<tr id='tr_$loop'>
			<td>4</td>
			<td>
				<select id='used_komponen_margin_$loop' name='dt[$loop][komponen_margin]' data-no='$loop' class='form-control select' required>
					<option value=''>-Pilih-</option>";					
					//foreach($komponen as $produk){
					echo"<option value='4' selected>Margin</option>";
					//}
		echo	"</select>
			</td>";          

		echo	"<td id='persentase_margin_$loop'><input type='text' align='right' class='form-control input-sm autoNumeric' id='used_persentase_margin_$loop' required name='dt[$loop][persentase_margin]' value='$margin->persentase' readonly></td>
                 <td id='nilai_margin_$loop'><input type='text' align='right' class='form-control input-sm autoNumeric' id='used_nilai_margin_$loop' required name='dt[$loop][nilai_margin]' readonly></td>
				 <td id='nilai_margin_rp_$loop'><input type='text' align='right' class='form-control input-sm autoNumeric' id='used_nilai_margin_rp_$loop' required name='dt[$loop][nilai_margin_rp]' readonly></td>
                                                
                 <td id='keterangan_margin_$loop'><input type='text' align='right' class='form-control input-sm' id='used_keterangan_margin_$loop' required name='dt[$loop][keterangan_margin]' value='$margin->keterangan'></td>
                <td align='center'>
                <button type='button' class='btn btn-sm btn-danger' title='Hapus Data' data-role='qtip' onClick='return HapusItem($loop);'><i class='fa fa-close'></i></button>
                </td>
			
		</tr>
		<tr id='tr_$loop'>
			<td>5</td>
			<td>
				<select id='used_komponen_dd_$loop' name='dt[$loop][komponen_dd]' data-no='$loop' class='form-control select' required>
					<option value=''>-Pilih-</option>";					
					//foreach($komponen as $produk){
					echo"<option value='5' selected>Discount Distributor</option>";
					//}
		echo	"</select>
			</td>";          

		echo	"<td id='persentase_dd_$loop'><input type='text' align='right' class='form-control input-sm autoNumeric' id='used_persentase_dd_$loop' required name='dt[$loop][persentase_dd]' value='$dd->persentase' readonly></td>
                 <td id='nilai_dd_$loop'><input type='text' align='right' class='form-control input-sm autoNumeric' id='used_nilai_dd_$loop' required name='dt[$loop][nilai_dd]' readonly></td>
                 <td id='nilai_dd_rp_$loop'><input type='text' align='right' class='form-control input-sm autoNumeric' id='used_nilai_dd_rp_$loop' required name='dt[$loop][nilai_dd_rp]' readonly ></td>
                                                
				 <td id='keterangan_dd_$loop'><input type='text' align='right' class='form-control input-sm' id='used_keterangan_dd_$loop' required name='dt[$loop][keterangan_dd]' value='$dd->keterangan'></td>
                <td align='center'>
                <button type='button' class='btn btn-sm btn-danger' title='Hapus Data' data-role='qtip' onClick='return HapusItem($loop);'><i class='fa fa-close'></i></button>
                </td>
			
		</tr>
		<tr id='tr_$loop'>
			<td>6</td>
			<td>
				<select id='used_komponen_da_$loop' name='dt[$loop][komponen_da]' data-no='$loop' class='form-control select' required>
					<option value=''>-Pilih-</option>";					
					//foreach($komponen as $produk){
					echo"<option value='6' selected>Discount Agent</option>";
					//}
		echo	"</select>
			</td>";          

		echo	"<td id='persentase_da_$loop'><input type='text' align='right' class='form-control input-sm autoNumeric' id='used_persentase_da_$loop' required name='dt[$loop][persentase_da]' value='$da->persentase' readonly></td>
                 <td id='nilai_da_$loop'><input type='text' align='right' class='form-control input-sm autoNumeric' id='used_nilai_da_$loop' required name='dt[$loop][nilai_da]' readonly></td>
				 <td id='nilai_da_rp_$loop'><input type='text' align='right' class='form-control input-sm autoNumeric' id='used_nilai_da_rp_$loop' required name='dt[$loop][nilai_da_rp]' readonly ></td>
                                                 
				 <td id='keterangan_da_$loop'><input type='text' align='right' class='form-control input-sm' id='used_keterangan_da_$loop' required name='dt[$loop][keterangan_da]' value='$da->keterangan'></td>
                <td align='center'>
                <button type='button' class='btn btn-sm btn-danger' title='Hapus Data' data-role='qtip' onClick='return HapusItem($loop);'><i class='fa fa-close'></i></button>
                </td>
			
		</tr>
		<tr id='tr_$loop'>
			<td>7</td>
			<td>
				<select id='used_komponen_de_$loop' name='dt[$loop][komponen_de]' data-no='$loop' class='form-control select' required>
					<option value=''>-Pilih-</option>";					
					//foreach($komponen as $produk){
					echo"<option value='7' selected>Discount End User</option>";
					//}
		echo	"</select>
			</td>";          

		echo	"<td id='persentase_de_$loop'><input type='text' align='right' class='form-control input-sm autoNumeric' id='used_persentase_de_$loop' required name='dt[$loop][persentase_de]' value='$de->persentase' readonly></td>
                 <td id='nilai_de_$loop'><input type='text' align='right' class='form-control input-sm autoNumeric' id='used_nilai_de_$loop' required name='dt[$loop][nilai_de]' readonly></td>
				 <td id='nilai_de_rp_$loop'><input type='text' align='right' class='form-control input-sm autoNumeric' id='used_nilai_de_rp_$loop' required name='dt[$loop][nilai_de_rp]' readonly ></td>
                                                 
				 <td id='keterangan_de_$loop'><input type='text' align='right' class='form-control input-sm' id='used_keterangan_de_$loop' required name='dt[$loop][keterangan_de]' value='$de->keterangan'></td>
                <td align='center'>
                <button type='button' class='btn btn-sm btn-danger' title='Hapus Data' data-role='qtip' onClick='return HapusItem($loop);'><i class='fa fa-close'></i></button>
                </td>
			
		</tr>
		<tr id='tr_$loop'>
		<td>8</td>
		<td>
			<select id='used_komponen_aj_$loop' name='dt[$loop][komponen_aj]' data-no='$loop' class='form-control select' required>
				<option value=''>-Pilih-</option>";					
				//foreach($komponen as $produk){
				echo"<option value='8' selected>Adjustable</option>";
				//}
	echo	"</select>
		</td>";          

	echo	"<td id='persentase_aj_$loop'><input type='text' align='right' class='form-control input-sm autoNumeric' id='used_persentase_aj_$loop' required name='dt[$loop][persentase_aj]' value='$aj->persentase' readonly></td>
			 <td id='nilai_aj_$loop'><input type='text' align='right' class='form-control input-sm autoNumeric' id='used_nilai_aj_$loop' required name='dt[$loop][nilai_aj]' readonly></td>
			 <td id='nilai_aj_rp_$loop'><input type='text' align='right' class='form-control input-sm autoNumeric' id='used_nilai_aj_rp_$loop' required name='dt[$loop][nilai_aj_rp]' readonly ></td>
                                            
			 <td id='keterangan_aj_$loop'><input type='text' align='right' class='form-control input-sm' id='used_keterangan_aj_$loop' required name='dt[$loop][keterangan_aj]' value='$aj->keterangan'></td>
			<td align='center'>
			<button type='button' class='btn btn-sm btn-danger' title='Hapus Data' data-role='qtip' onClick='return HapusItem($loop);'><i class='fa fa-close'></i></button>
			</td>
		
	</tr>
		";
	}


	public function SaveNewPricelist()
    {
        $this->auth->restrict($this->addPermission);
		$post = $this->input->post();
		// print_r($post);
		// exit;
       	$this->db->trans_begin();

		   $material=$post['id_material'];
		   $cat = $this->db->query("SELECT * FROM ms_inventory_category2 WHERE id_category2='$material'")->row();
		   $category = $cat->nama;

		   $code = $this->Ms_product_costing_model->generate_code_pricelist();
		   $data = [
							   'id_product_pricelist'	=> $code,
							   'id_type'			    => $post['inventory_1'],
							   'id_category1'			=> $post['inventory_2'],
							   'id_category2'			=> $post['inventory_3'],
							   'id_category3'			=> $post['inventory_4'],
							   'id_formula'			    => $post['id_material'],
							   'nama_category2'			=> $category,
							   'revisi'					=> 0,
							   'kurs'					=> str_replace(',','',$post['kurs']),
							   'harga_beli'				=> str_replace(',','',$post['harga_beli']),
							   'total_pricelist'		=> str_replace(',','',$post['total_price']),
							   'harga_rupiah'		    => str_replace(',','',$post['total_price_rp']),
							   'created_on'			=> date('Y-m-d H:i:s'),
							   'created_by'			=> $this->auth->user_id()
							   ];
			   //Add Data
				 

	           $numb1 =0;
               foreach($_POST['dt'] as $used){
                   if(!empty($used[komponen_bm])){
                       $numb1++;   
                       $dt1[] =  array(
                               'id_product_pricelist'		=> $code,
                               'id_formula'		            => $post[id_material],
                               'nama_komponen'	    		=> $used[komponen_bm],
							   'persentase'	    			=> str_replace(',','',$used[persentase_bm]),
							   'nilai_costing'	    		=> str_replace(',','',$used[nilai_bm]),
							   'nilai_rupiah'	    		=> str_replace(',','',$used[nilai_bm_rp]),
							   'keterangan'	    			=> $used[keterangan_bm],
                               'created_on'					=> date('Y-m-d H:i:s'),
                               'created_by'					=> $this->auth->user_id()                       
                               );
                   }
               }
			   $numb2 =0;
               foreach($_POST['dt'] as $used){
                   if(!empty($used[komponen_lc])){
                       $numb2++;   
                       $dt2[] =  array(
                               'id_product_pricelist'		    => $code,
                               'id_formula'		           => $post[id_material],
                               'nama_komponen'	    		=> $used[komponen_lc],
							   'persentase'	    			=> str_replace(',','',$used[persentase_lc]),
							   'nilai_costing'	    		=> str_replace(',','',$used[nilai_lc]),
							   'nilai_rupiah'	    		=> str_replace(',','',$used[nilai_lc_rp]),
							   'keterangan'	    			=> $used[keterangan_lc],
                               'created_on'					=> date('Y-m-d H:i:s'),
                               'created_by'					=> $this->auth->user_id()                       
                               );
                   }
               }
			   $numb3 =0;
               foreach($_POST['dt'] as $used){
                   if(!empty($used[komponen_oc])){
                       $numb1++;   
                       $dt3[] =  array(
								'id_product_pricelist'		    => $code,
								'id_formula'			        => $post[id_material],
                               'nama_komponen'	    		=> $used[komponen_oc],
							   'persentase'	    			=> str_replace(',','',$used[persentase_oc]),
							   'nilai_costing'	    		=> str_replace(',','',$used[nilai_oc]),
							   'nilai_rupiah'	    		=> str_replace(',','',$used[nilai_oc_rp]),
							   'keterangan'	    			=> $used[keterangan_oc],
                               'created_on'					=> date('Y-m-d H:i:s'),
                               'created_by'					=> $this->auth->user_id()                       
                               );
                   }
               }
			   $numb4 =0;
               foreach($_POST['dt'] as $used){
                   if(!empty($used[komponen_margin])){
                       $numb4++;   
                       $dt4[] =  array(
								'id_product_pricelist'		    => $code,
								'id_formula'			        => $post[id_material],
								'nama_komponen'	    		=> $used[komponen_margin],
							   'persentase'	    			=> str_replace(',','',$used[persentase_margin]),
							   'nilai_costing'	    		=> str_replace(',','',$used[nilai_margin]),
							   'nilai_rupiah'	    		=> str_replace(',','',$used[nilai_margin_rp]),
							   'keterangan'	    			=> $used[keterangan_margin],
                               'created_on'					=> date('Y-m-d H:i:s'),
                               'created_by'					=> $this->auth->user_id()                       
                               );
                   }
               }
			   $numb5 =0;
               foreach($_POST['dt'] as $used){
                   if(!empty($used[komponen_dd])){
                       $numb5++;   
                       $dt5[] =  array(
								'id_product_pricelist'		    => $code,
								'id_formula'			        => $post[id_material],
                               'nama_komponen'	    		=> $used[komponen_dd],
							   'persentase'	    			=> str_replace(',','',$used[persentase_dd]),
							   'nilai_costing'	    		=> str_replace(',','',$used[nilai_dd]),
							   'nilai_rupiah'	    		=> str_replace(',','',$used[nilai_dd_rp]),
							   'keterangan'	    			=> $used[keterangan_dd],
                               'created_on'					=> date('Y-m-d H:i:s'),
                               'created_by'					=> $this->auth->user_id()                       
                               );
                   }
               }
			   $numb6 =0;
               foreach($_POST['dt'] as $used){
                   if(!empty($used[komponen_da])){
                       $numb6++;   
                       $dt6[] =  array(
								'id_product_pricelist'		    => $code,
								'id_formula'			        => $post[id_material],
                               'nama_komponen'	    		=> $used[komponen_da],
							   'persentase'	    			=> str_replace(',','',$used[persentase_da]),
							   'nilai_costing'	    		=> str_replace(',','',$used[nilai_da]),
							   'nilai_rupiah'	    		=> str_replace(',','',$used[nilai_da_rp]),
							   'keterangan'	    			=> $used[keterangan_da],
                               'created_on'					=> date('Y-m-d H:i:s'),
                               'created_by'					=> $this->auth->user_id()                       
                               );
                   }
               }
			   $numb7 =0;
               foreach($_POST['dt'] as $used){
                   if(!empty($used[komponen_de])){
                       $numb7++;   
                       $dt7[] =  array(
								'id_product_pricelist'		    => $code,
								'id_formula'		        => $post[id_material],
								'nama_komponen'	    		=> $used[komponen_de],
							   'persentase'	    			=> str_replace(',','',$used[persentase_de]),
							   'nilai_costing'	    		=> str_replace(',','',$used[nilai_de]),
							   'nilai_rupiah'	    		=> str_replace(',','',$used[nilai_de_rp]),
							   'keterangan'	    			=> $used[keterangan_de],
                               'created_on'					=> date('Y-m-d H:i:s'),
                               'created_by'					=> $this->auth->user_id()                       
                               );
                   }
               }
			   $numb8 =0;
               foreach($_POST['dt'] as $used){
                   if(!empty($used[komponen_aj])){
                       $numb8++;   
                       $dt8[] =  array(
								'id_product_pricelist'		    => $code,
								'id_formula'		        => $post[id_material],
                               'nama_komponen'	    		=> $used[komponen_aj],
							   'persentase'	    			=> str_replace(',','',$used[persentase_aj]),
							   'nilai_costing'	    		=> str_replace(',','',$used[nilai_aj]),
							   'nilai_rupiah'	    		=> str_replace(',','',$used[nilai_aj_rp]),
							   'keterangan'	    			=> $used[keterangan_aj],
                               'created_on'					=> date('Y-m-d H:i:s'),
                               'created_by'					=> $this->auth->user_id()                       
                               );
                   }
               }
            //    print_r($dt);
            //    exit();

			$this->db->insert('ms_product_pricelist',$data);
            $this->db->insert_batch('ms_product_pricelist_detail',$dt1);
			$this->db->insert_batch('ms_product_pricelist_detail',$dt2);
			$this->db->insert_batch('ms_product_pricelist_detail',$dt3);
			$this->db->insert_batch('ms_product_pricelist_detail',$dt4);
			$this->db->insert_batch('ms_product_pricelist_detail',$dt5);
			$this->db->insert_batch('ms_product_pricelist_detail',$dt6);
			$this->db->insert_batch('ms_product_pricelist_detail',$dt7);
			$this->db->insert_batch('ms_product_pricelist_detail',$dt8);

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
	public function editPricelist($id)
    {
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$aktif = 'active';
		$deleted = '0';
		$material = $this->Ms_product_costing_model->get_data_usage();
		$inventory_1 = $this->Ms_product_costing_model->get_data('ms_inventory_type','deleted',$deleted);
		$inventory_2 = $this->Ms_product_costing_model->get_data('ms_inventory_category1','deleted',$deleted);
		$inventory_3 = $this->Ms_product_costing_model->get_data('ms_inventory_category2','deleted',$deleted);
		$inventory_4 = $this->Ms_product_costing_model->get_data('ms_inventory_category3','deleted',$deleted);
		$formula     = $this->Ms_product_costing_model->get_data('ms_product_costing','deleted',$deleted);
		$header    = $this->Ms_product_costing_model->get_data('ms_product_pricelist','id_product_pricelist',$id);
		$detail    = $this->Ms_product_costing_model->get_data('ms_product_pricelist_detail','id_product_pricelist',$id);
		$kurs     = $this->Ms_product_costing_model->get_data('ms_kurs','aktif','Y');
		$data = [
			'inventory_1' => $inventory_1,
			'inventory_2' => $inventory_2,
			'inventory_3' => $inventory_3,
			'inventory_4' => $inventory_4,
			'material' => $formula,
			'header'=>$header,
			'detail'=>$detail,
			'kurs'=>$kurs,

		];
	

        $this->template->set('results', $data);
        $this->template->title('Edit Calculation');
        $this->template->render('editpricelist');

    }

	public function SaveEditPricelist()
    {
        $this->auth->restrict($this->addPermission);
		$post = $this->input->post();

		// print_r($post);
		// exit;

		$code		= $post['id_product_pricelist'];
		$this->db->trans_begin();

		   $data = [
							   'id_product_pricelist'	=> $code,
							   'id_type'			    => $post['inventory_1'],
							   'id_category1'			=> $post['inventory_2'],
							   'id_category2'			=> $post['inventory_3'],
							   'id_category3'			=> $post['inventory_4'],
							   'id_formula'			    => $post['id_material'],
							   'nama_category2'			=> $category,
							   'revisi'					=> 0,
							   'harga_beli'				=> str_replace(',','',$post['harga_beli']),
							   'total_pricelist'		=> str_replace(',','',$post['total_price']),
							   'kurs'					=> str_replace(',','',$post['kurs']),
							   'harga_rupiah'		    => str_replace(',','',$post['total_price_rp']),
							   'modified_on'			=> date('Y-m-d H:i:s'),
							   'modified_by'			=> $this->auth->user_id()
							   ];
			   //Edit Data
        	$this->db->where('id_product_pricelist',$code)->update("ms_product_pricelist",$data);			


			

			
		 $this->db->delete('ms_product_pricelist_detail',array('id_product_pricelist'=>$code));

		 $numb1 =0;
		 foreach($_POST['dt'] as $used){
			 if(!empty($used[komponen_bm])){
				 $numb1++;   
				 $dt1[] =  array(
						 'id_product_pricelist'		=> $code,
						 'id_formula'		            => $post[id_material],
						 'nama_komponen'	    		=> $used[komponen_bm],
						 'persentase'	    			=> str_replace(',','',$used[persentase_bm]),
						 'nilai_costing'	    		=> str_replace(',','',$used[nilai_bm]),
						 'nilai_rupiah'	    			=> str_replace(',','',$used[nilai_bm_rp]),
						 'keterangan'	    			=> $used[keterangan_bm],
						 'created_on'					=> date('Y-m-d H:i:s'),
						 'created_by'					=> $this->auth->user_id()                       
						 );
			 }
		 }
		 $numb2 =0;
		 foreach($_POST['dt'] as $used){
			 if(!empty($used[komponen_lc])){
				 $numb2++;   
				 $dt2[] =  array(
						 'id_product_pricelist'		    => $code,
						 'id_formula'		           => $post[id_material],
						 'nama_komponen'	    		=> $used[komponen_lc],
						 'persentase'	    			=> str_replace(',','',$used[persentase_lc]),
						 'nilai_costing'	    		=> str_replace(',','',$used[nilai_lc]),
						 'nilai_rupiah'	    			=> str_replace(',','',$used[nilai_lc_rp]),
						 'keterangan'	    			=> $used[keterangan_lc],
						 'created_on'					=> date('Y-m-d H:i:s'),
						 'created_by'					=> $this->auth->user_id()                       
						 );
			 }
		 }
		 $numb3 =0;
		 foreach($_POST['dt'] as $used){
			 if(!empty($used[komponen_oc])){
				 $numb1++;   
				 $dt3[] =  array(
						  'id_product_pricelist'		    => $code,
						  'id_formula'			        => $post[id_material],
						 'nama_komponen'	    		=> $used[komponen_oc],
						 'persentase'	    			=> str_replace(',','',$used[persentase_oc]),
						 'nilai_costing'	    		=> str_replace(',','',$used[nilai_oc]),
						 'nilai_rupiah'	    			=> str_replace(',','',$used[nilai_oc_rp]),
						 'keterangan'	    			=> $used[keterangan_oc],
						 'created_on'					=> date('Y-m-d H:i:s'),
						 'created_by'					=> $this->auth->user_id()                       
						 );
			 }
		 }
		 $numb4 =0;
		 foreach($_POST['dt'] as $used){
			 if(!empty($used[komponen_margin])){
				 $numb4++;   
				 $dt4[] =  array(
						  'id_product_pricelist'		    => $code,
						  'id_formula'			        => $post[id_material],
						  'nama_komponen'	    		=> $used[komponen_margin],
						 'persentase'	    			=> str_replace(',','',$used[persentase_margin]),
						 'nilai_costing'	    		=> str_replace(',','',$used[nilai_margin]),
						 'nilai_rupiah'	    			=> str_replace(',','',$used[nilai_margin_rp]),
						 'keterangan'	    			=> $used[keterangan_margin],
						 'created_on'					=> date('Y-m-d H:i:s'),
						 'created_by'					=> $this->auth->user_id()                       
						 );
			 }
		 }
		 $numb5 =0;
		 foreach($_POST['dt'] as $used){
			 if(!empty($used[komponen_dd])){
				 $numb5++;   
				 $dt5[] =  array(
						  'id_product_pricelist'		    => $code,
						  'id_formula'			        => $post[id_material],
						 'nama_komponen'	    		=> $used[komponen_dd],
						 'persentase'	    			=> str_replace(',','',$used[persentase_dd]),
						 'nilai_costing'	    		=> str_replace(',','',$used[nilai_dd]),
						 'nilai_rupiah'	    			=> str_replace(',','',$used[nilai_dd_rp]),
						 'keterangan'	    			=> $used[keterangan_dd],
						 'created_on'					=> date('Y-m-d H:i:s'),
						 'created_by'					=> $this->auth->user_id()                       
						 );
			 }
		 }
		 $numb6 =0;
		 foreach($_POST['dt'] as $used){
			 if(!empty($used[komponen_da])){
				 $numb6++;   
				 $dt6[] =  array(
						  'id_product_pricelist'		    => $code,
						  'id_formula'			        => $post[id_material],
						 'nama_komponen'	    		=> $used[komponen_da],
						 'persentase'	    			=> str_replace(',','',$used[persentase_da]),
						 'nilai_costing'	    		=> str_replace(',','',$used[nilai_da]),
						 'nilai_rupiah'	    			=> str_replace(',','',$used[nilai_da_rp]),
						 'keterangan'	    			=> $used[keterangan_da],
						 'created_on'					=> date('Y-m-d H:i:s'),
						 'created_by'					=> $this->auth->user_id()                       
						 );
			 }
		 }
		 $numb7 =0;
		 foreach($_POST['dt'] as $used){
			 if(!empty($used[komponen_de])){
				 $numb7++;   
				 $dt7[] =  array(
						  'id_product_pricelist'		    => $code,
						  'id_formula'		        => $post[id_material],
						  'nama_komponen'	    		=> $used[komponen_de],
						 'persentase'	    			=> str_replace(',','',$used[persentase_de]),
						 'nilai_costing'	    		=> str_replace(',','',$used[nilai_de]),
						 'nilai_rupiah'	    			=> str_replace(',','',$used[nilai_de_rp]),
						 'keterangan'	    			=> $used[keterangan_de],
						 'created_on'					=> date('Y-m-d H:i:s'),
						 'created_by'					=> $this->auth->user_id()                       
						 );
			 }
		 }
		 $numb8 =0;
		 foreach($_POST['dt'] as $used){
			 if(!empty($used[komponen_aj])){
				 $numb8++;   
				 $dt8[] =  array(
						  'id_product_pricelist'		=> $code,
						  'id_formula'		            => $post[id_material],
						 'nama_komponen'	    		=> $used[komponen_aj],
						 'persentase'	    			=> str_replace(',','',$used[persentase_aj]),
						 'nilai_costing'	    		=> str_replace(',','',$used[nilai_aj]),
						 'nilai_rupiah'	    			=> str_replace(',','',$used[nilai_aj_rp]),
						 'keterangan'	    			=> $used[keterangan_aj],
						 'created_on'					=> date('Y-m-d H:i:s'),
						 'created_by'					=> $this->auth->user_id()                       
						 );
			 }
		 }
	 
	  $this->db->insert_batch('ms_product_pricelist_detail',$dt1);
	  $this->db->insert_batch('ms_product_pricelist_detail',$dt2);
	  $this->db->insert_batch('ms_product_pricelist_detail',$dt3);
	  $this->db->insert_batch('ms_product_pricelist_detail',$dt4);
	  $this->db->insert_batch('ms_product_pricelist_detail',$dt5);
	  $this->db->insert_batch('ms_product_pricelist_detail',$dt6);
	  $this->db->insert_batch('ms_product_pricelist_detail',$dt7);
	  $this->db->insert_batch('ms_product_pricelist_detail',$dt8);
		



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

	public function deletePricelist(){
		$this->auth->restrict($this->deletePermission);
		$id = $this->input->post('id');
		$data = [
			'deleted' 		=> '1',
			'deleted_by' 	=> $this->auth->user_id()
		];
		
		$this->db->trans_begin();
		$this->db->where('id_product_pricelist',$id)->update("ms_product_pricelist",$data);
		
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

	public function revisiFormula($id)
    {
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$aktif = 'active';
		$deleted = '0';
		$material = $this->Ms_product_costing_model->get_data_usage();
		$inventory_1 = $this->Ms_product_costing_model->get_data('ms_inventory_type','deleted',$deleted);
		$inventory_2 = $this->Ms_product_costing_model->get_data('ms_inventory_category1','deleted',$deleted);
		$inventory_3 = $this->Ms_product_costing_model->get_data_usage();
		$inventory_4 = $this->Ms_product_costing_model->get_data('ms_inventory_category3','deleted',$deleted);
		$formula     = $this->Ms_product_costing_model->get_data('ms_product_costing','deleted',$deleted);
		$header    = $this->Ms_product_costing_model->get_data('ms_product_costing','id_product_costing',$id);
		$detail    = $this->Ms_product_costing_model->get_data('ms_product_costing_detail','id_product_costing',$id);
		$data = [
			'inventory_1' => $inventory_1,
			'inventory_2' => $inventory_2,
			'inventory_3' => $inventory_3,
			'inventory_4' => $inventory_4,
			'material' => $formula,
			'header'=>$header,
			'detail'=>$detail,

		];
	

        $this->template->set('results', $data);
        $this->template->title('Revisi Calculation');
        $this->template->render('editformula');

    }


	public function saveRevisiFormula()
	{
	
        $this->auth->restrict($this->addPermission);
		$post = $this->input->post();
		$this->db->trans_begin();

		   $code		= $post['id_product_costing'];

		   $material=$post['id_material'];
		   $cat = $this->db->query("SELECT * FROM ms_inventory_category2 WHERE id_category2='$material'")->row();
		   $category = $cat->nama;


			$select1 = $this->db->select('
			id_product_costing,
			id_category2,
			nama_category2,
			revisi,
			harga_beli,
			total_pricelist,
			created_by,
			created_on,
			modified_by,
			modified_on,
			deleted,
			deleted_by')->where('id_product_costing',$code)->get('ms_product_costing');

			
			if($select1->num_rows())
			{
				$insert = $this->db->insert_batch('ms_product_costing_history', $select1->result_array());
			}
	
	
			$select2 = $this->db->select('
			id_detail,
			id_product_costing,
			id_category2,
			nama_komponen,
			persentase,
			nilai_costing,
			keterangan,
			created_by,
			created_on,
			modified_by,
			modified_on,
			deleted,
			deleted_by
			')->where('id_product_costing',$code)->get('ms_product_costing_detail');	

			
	
			$rev = $select1->row();
			$norev = $rev->revisi+1;
		   	$data = [
							   'id_product_costing'	    => $code,
							   'id_category2'			=> $post['id_material'],
							   'nama_category2'			=> $category,
							   'revisi'					=> $norev,
							   'modified_on'			=> date('Y-m-d H:i:s'),
							   'modified_by'			=> $this->auth->user_id()
							   ];
			   //Edit Data
				 
			   $this->db->where('id_product_costing',$code)->update("ms_product_costing",$data);


	           $numb1 =0;
               foreach($_POST['dt'] as $used){
                   if(!empty($used[komponen_bm])){
                       $numb1++;   
                       $dt1[] =  array(
                               'id_product_costing'		    => $code,
                               'id_category2'		        => $post[id_material],
                               'nama_komponen'	    		=> $used[komponen_bm],
							   'persentase'	    			=> str_replace(',','',$used[persentase_bm]),
							   'nilai_costing'	    		=> str_replace(',','',$used[nilai_bm]),
							   'keterangan'	    			=> $used[keterangan_bm],
                               'created_on'					=> date('Y-m-d H:i:s'),
                               'created_by'					=> $this->auth->user_id(),
							   'revisi'					    => $norev                    
                               );
                   }
               }
			   $numb2 =0;
               foreach($_POST['dt'] as $used){
                   if(!empty($used[komponen_lc])){
                       $numb2++;   
                       $dt2[] =  array(
                               'id_product_costing'		    => $code,
                               'id_category2'		        => $post[id_material],
                               'nama_komponen'	    		=> $used[komponen_lc],
							   'persentase'	    			=> str_replace(',','',$used[persentase_lc]),
							   'nilai_costing'	    		=> str_replace(',','',$used[nilai_lc]),
							   'keterangan'	    			=> $used[keterangan_lc],
                               'created_on'					=> date('Y-m-d H:i:s'),
                               'created_by'					=> $this->auth->user_id(),
							   'revisi'					    => $norev                         
                               );
                   }
               }
			   $numb3 =0;
               foreach($_POST['dt'] as $used){
                   if(!empty($used[komponen_oc])){
                       $numb1++;   
                       $dt3[] =  array(
                               'id_product_costing'		    => $code,
                               'id_category2'		        => $post[id_material],
                               'nama_komponen'	    		=> $used[komponen_oc],
							   'persentase'	    			=> str_replace(',','',$used[persentase_oc]),
							   'nilai_costing'	    		=> str_replace(',','',$used[nilai_oc]),
							   'keterangan'	    			=> $used[keterangan_oc],
                               'created_on'					=> date('Y-m-d H:i:s'),
                               'created_by'					=> $this->auth->user_id(),
							   'revisi'					    => $norev                         
                               );
                   }
               }
			   $numb4 =0;
               foreach($_POST['dt'] as $used){
                   if(!empty($used[komponen_margin])){
                       $numb4++;   
                       $dt4[] =  array(
                               'id_product_costing'		    => $code,
                               'id_category2'		        => $post[id_material],
                               'nama_komponen'	    		=> $used[komponen_margin],
							   'persentase'	    			=> str_replace(',','',$used[persentase_margin]),
							   'nilai_costing'	    		=> str_replace(',','',$used[nilai_margin]),
							   'keterangan'	    			=> $used[keterangan_margin],
                               'created_on'					=> date('Y-m-d H:i:s'),
                               'created_by'					=> $this->auth->user_id(),
							   'revisi'					    => $norev                         
                               );
                   }
               }
			   $numb5 =0;
               foreach($_POST['dt'] as $used){
                   if(!empty($used[komponen_dd])){
                       $numb5++;   
                       $dt5[] =  array(
                               'id_product_costing'		    => $code,
                               'id_category2'		        => $post[id_material],
                               'nama_komponen'	    		=> $used[komponen_dd],
							   'persentase'	    			=> str_replace(',','',$used[persentase_dd]),
							   'nilai_costing'	    		=> str_replace(',','',$used[nilai_dd]),
							   'keterangan'	    			=> $used[keterangan_dd],
                               'created_on'					=> date('Y-m-d H:i:s'),
                               'created_by'					=> $this->auth->user_id(),
							   'revisi'					    => $norev                         
                               );
                   }
               }
			   $numb6 =0;
               foreach($_POST['dt'] as $used){
                   if(!empty($used[komponen_da])){
                       $numb6++;   
                       $dt6[] =  array(
                               'id_product_costing'		    => $code,
                               'id_category2'		        => $post[id_material],
                               'nama_komponen'	    		=> $used[komponen_da],
							   'persentase'	    			=> str_replace(',','',$used[persentase_da]),
							   'nilai_costing'	    		=> str_replace(',','',$used[nilai_da]),
							   'keterangan'	    			=> $used[keterangan_da],
                               'created_on'					=> date('Y-m-d H:i:s'),
                               'created_by'					=> $this->auth->user_id(),
							   'revisi'					    => $norev                         
                               );
                   }
               }
			   $numb7 =0;
               foreach($_POST['dt'] as $used){
                   if(!empty($used[komponen_de])){
                       $numb7++;   
                       $dt7[] =  array(
                               'id_product_costing'		    => $code,
                               'id_category2'		        => $post[id_material],
                               'nama_komponen'	    		=> $used[komponen_de],
							   'persentase'	    			=> str_replace(',','',$used[persentase_de]),
							   'nilai_costing'	    		=> str_replace(',','',$used[nilai_de]),
							   'keterangan'	    			=> $used[keterangan_de],
                               'created_on'					=> date('Y-m-d H:i:s'),
                               'created_by'					=> $this->auth->user_id(),
							   'revisi'					    => $norev                         
                               );
                   }
               }
			   $numb8 =0;
               foreach($_POST['dt'] as $used){
                   if(!empty($used[komponen_aj])){
                       $numb8++;   
                       $dt8[] =  array(
                               'id_product_costing'		    => $code,
                               'id_category2'		        => $post[id_material],
                               'nama_komponen'	    		=> $used[komponen_aj],
							   'persentase'	    			=> str_replace(',','',$used[persentase_aj]),
							   'nilai_costing'	    		=> str_replace(',','',$used[nilai_aj]),
							   'keterangan'	    			=> $used[keterangan_aj],
                               'created_on'					=> date('Y-m-d H:i:s'),
                               'created_by'					=> $this->auth->user_id(),
							   'revisi'					    => $norev                         
                               );
                   }
               }
            	

			   if($select2->num_rows())
				{
				$insert2 = $this->db->insert_batch('ms_product_costing_detail_history', $select2->result_array());

				$this->db->delete('ms_product_costing_detail',array('id_product_costing'=>$code));			
				$this->db->insert_batch('ms_product_costing_detail',$dt1);
				$this->db->insert_batch('ms_product_costing_detail',$dt2);
				$this->db->insert_batch('ms_product_costing_detail',$dt3);
				$this->db->insert_batch('ms_product_costing_detail',$dt4);
				$this->db->insert_batch('ms_product_costing_detail',$dt5);
				$this->db->insert_batch('ms_product_costing_detail',$dt6);
				$this->db->insert_batch('ms_product_costing_detail',$dt7);
				$this->db->insert_batch('ms_product_costing_detail',$dt8);
				}
	
				
			
			

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

	function get_inven3()
    {
        $id_type=$_GET['id_type'];
		$inventory_2=$_GET['inventory_2'];
        $data=$this->Inventory_4_model->level_3($id_type,$inventory_2);
		
		// print_r($data);
        // exit();
		
        echo "<select id='inventory_3' name='inventory_3' class='form-control input-sm select2'>";
        echo "<option value=''>--Pilih--</option>";
                foreach ($data as $key => $st) :
				      echo "<option value='$st->id_category2' set_select('inventory_3', $st->id_category2, isset($data->id_category2) && $data->id_category2 == $st->id_category2)>$st->nama
                    </option>";
                endforeach;
        echo "</select>";
    }

	
}
