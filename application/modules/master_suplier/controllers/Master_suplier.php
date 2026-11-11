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

class Master_suplier extends Admin_Controller
{
    //Permission
    protected $viewPermission 	= 'Master_Supplier.View';
    protected $addPermission  	= 'Master_Supplier.Add';
    protected $managePermission = 'Master_Supplier.Manage';
    protected $deletePermission = 'Master_Supplier.Delete';

    public function __construct()
    {
        parent::__construct();

        $this->load->library(array('Mpdf', 'upload', 'Image_lib'));
        $this->load->model(array('Master_suplier/Suplier_model',
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
		$deleted = 'active';
        $category = $this->Suplier_model->get_data('child_supplier_category','activation',$deleted);
		$lokal 			= $this->Suplier_model->getlokal();
		$international = $this->Suplier_model->getinternational();
		$data = [
			'lokal' => $lokal,
			'international' => $international,
			'category' => $category
		];
        $this->template->set('results', $data);
        $this->template->title('Master Suplier');
        $this->template->render('index');
    }
	public function EditLokal($id){
		$this->auth->restrict($this->managePermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-edit');
		$deleted ='active';
		$sup = $this->db->get_where('master_supplier',array('id_suplier' => $id, 'deleted' => 0))->result();
        if (!$sup) { show_404(); return; }
		$category = $this->Suplier_model->get_data('child_supplier_category','activation',$deleted);
		$pic = $this->db->get_where('child_supplier_pic',array('id_suplier' => $id))->result();
		$prof = $this->Suplier_model->get_data('provinsi');
		$kota = $this->Suplier_model->get_data('kota');
		$data = [
			'sup' => $sup,
			'category' => $category,
			'prof' => $prof,
			'kota' => $kota,
			'pic' => $pic
		];
        $this->template->set('results', $data);
		$this->template->title('Edit Suplier');
        $this->template->render('edit_lokal');
		
	}
	public function viewLokal($id){
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-edit');
		$deleted ='active';
		$sup = $this->db->get_where('master_supplier',array('id_suplier' => $id, 'deleted' => 0))->result();
        if (!$sup) { show_404(); return; }
		$category = $this->Suplier_model->get_data('child_supplier_category','activation',$deleted);
		$pic = $this->db->get_where('child_supplier_pic',array('id_suplier' => $id))->result();
		$prof = $this->Suplier_model->get_data('provinsi');
		$kota = $this->Suplier_model->get_data('kota');
		$data = [
			'sup' => $sup,
			'category' => $category,
			'prof' => $prof,
			'kota' => $kota,
			'pic' => $pic
		];
        $this->template->set('results', $data);
		$this->template->title('Edit Suplier');
        $this->template->render('view_local');
		
	}
	public function EditInternasional($id){
		$this->auth->restrict($this->managePermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-edit');
		$deleted ='active';
		$sup = $this->db->get_where('master_supplier',array('id_suplier' => $id, 'deleted' => 0))->result();
        if (!$sup) { show_404(); return; }
		$category = $this->Suplier_model->get_data('child_supplier_category','activation',$deleted);
		$pic = $this->db->get_where('child_supplier_pic',array('id_suplier' => $id))->result();
		$negara = $this->Suplier_model->get_data('negara');
		$data = [
			'sup' => $sup,
			'category' => $category,
			'negara' => $negara,
			'pic' => $pic
		];
        $this->template->set('results', $data);
		$this->template->title('Edit Suplier');
        $this->template->render('edit_international');
		
	}
	public function ViewInternasional($id){
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-edit');
		$deleted ='active';
		$sup = $this->db->get_where('master_supplier',array('id_suplier' => $id, 'deleted' => 0))->result();
        if (!$sup) { show_404(); return; }
		$category = $this->Suplier_model->get_data('child_supplier_category','activation',$deleted);
		$pic = $this->db->get_where('child_supplier_pic',array('id_suplier' => $id))->result();
		$negara = $this->Suplier_model->get_data('negara');
		$data = [
			'sup' => $sup,
			'category' => $category,
			'negara' => $negara,
			'pic' => $pic
		];
        $this->template->set('results', $data);
		$this->template->title('Edit Suplier');
        $this->template->render('view_international');
		
	}
	public function EditCategory($id){
		$this->auth->restrict($this->managePermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-edit');
		$category = $this->db->get_where('child_supplier_category',array('id_category_supplier' => $id))->result();
        if (!$category) { show_404(); return; }
		$data = [
			'category' => $category,
		];
        $this->template->set('results', $data);
		$this->template->title('Edit Suplier');
        $this->template->render('edit_category');
		
	}
	public function ViewCategory($id){
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-edit');
		$category = $this->db->get_where('child_supplier_category',array('id_category_supplier' => $id))->result();
        if (!$category) { show_404(); return; }
		$data = [
			'category' => $category,
		];
        $this->template->set('results', $data);
		$this->template->title('Edit Suplier');
        $this->template->render('view_category');
		
	}
	public function viewInventory(){
		$this->auth->restrict($this->viewPermission);
		$id 	= $this->input->post('id');
		$inven = $this->db->get_where('ms_inventory_category1',array('id_category1' => $id))->result();
        if (!$inven) { show_404(); return; }
		$deleted ='0';
		$komposisi = $this->db->get_where('ms_compotition',array('id_category1' => $id, 'deleted' => $deleted))->result();
		$lvl1 = $this->Suplier_model->get_data('ms_inventory_type');
		$data = [
			'inven' => $inven,
			'komposisi' => $komposisi,
			'lvl1' => $lvl1
		];
        $this->template->set('results', $data);
		$this->template->render('view_inventory');
	}
	public function addLocal()
    {
		$this->auth->restrict($this->addPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$deleted = 'active';
		$category = $this->Suplier_model->get_data('child_supplier_category','activation',$deleted);
		$prof = $this->Suplier_model->get_data('provinsi');
		$data = [
			'category' => $category,
			'prof' => $prof
		];
        $this->template->set('results', $data);
        $this->template->title('Add Suplier Local');
        $this->template->render('add_local');

    }
	public function addInternational()
    {
		$this->auth->restrict($this->addPermission);
        $session = $this->session->userdata('app_session');
		$deleted = 'active';
		$category = $this->Suplier_model->get_data('child_supplier_category','activation',$deleted);
		$negara = $this->Suplier_model->get_data('negara');
		$data = [
			'category' => $category,
			'negara' => $negara
		];
        $this->template->set('results', $data);
        $this->template->title('Add Suplier Local');
        $this->template->render('add_international');

    }
	public function addCategory()
    {
		$this->auth->restrict($this->addPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
        $this->template->title('Add Suplier Local');
        $this->template->render('add_category');

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

	public function deleteCategory(){
		$this->auth->restrict($this->deletePermission);
		$id = $this->input->post('id');
		if (!is_scalar($id) || (string) $id === '' || !$this->db->get_where('child_supplier_category', array('id_category_supplier' => $id, 'activation' => 'active'))->num_rows()) {
			return $this->rejectInput('Kategori supplier tidak ditemukan.');
		}
		// print_r($id);
		// exit();
		$data = [
			'activation' 		=> 'inactive',
			'deleted_by' 	=> $this->auth->user_id()
		];
		$this->db->trans_begin();
		$this->db->where('id_category_supplier',$id)->update("child_supplier_category",$data);
		
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
	public function deletelokal(){
		$this->auth->restrict($this->deletePermission);
		$id = $this->input->post('id');
		if (!is_scalar($id) || (string) $id === '' || !$this->db->get_where('master_supplier', array('id_suplier' => $id, 'suplier_location' => 'local', 'deleted' => 0))->num_rows()) {
			return $this->rejectInput('Supplier lokal tidak ditemukan.');
		}
		// print_r($id);
		// exit();
		$data = [
			'deleted' 		=> '1',
			'deleted_by' 	=> $this->auth->user_id()
		];
		$this->db->trans_begin();
		$this->db->where('id_suplier',$id)->update("master_supplier",$data);
		
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
		public function deleteinternational(){
		$this->auth->restrict($this->deletePermission);
		$id = $this->input->post('id');
		if (!is_scalar($id) || (string) $id === '' || !$this->db->get_where('master_supplier', array('id_suplier' => $id, 'suplier_location' => 'international', 'deleted' => 0))->num_rows()) {
			return $this->rejectInput('Supplier internasional tidak ditemukan.');
		}
		// print_r($id);
		// exit();
		$data = [
			'deleted' 		=> '1',
			'deleted_by' 	=> $this->auth->user_id()
		];
		$this->db->trans_begin();
		$this->db->where('id_suplier',$id)->update("master_supplier",$data);
		
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
	public function saveNewCategory()
    {
        $this->auth->restrict($this->addPermission);
		$post = $this->categoryInput();
		if ($post === false) { return; }
		$code = $this->Suplier_model->generate_Category();
		$this->db->trans_begin();
		$data = [
			'id_category_supplier'		=> $code,
			'name_category_supplier'	=> $post['name_category_supplier'],
			'supplier_code'				=> $post['supplier_code'],
			'activation'				=> 'active',
			'created_on'				=> date('Y-m-d H:i:s'),
			'created_by'				=> $this->auth->user_id()
		];
		
		$insert = $this->db->insert("child_supplier_category",$data);
		
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
    public function saveNewLocal()
    {
        $this->auth->restrict($this->addPermission);
        $this->saveSupplier('local');
    }

    public function saveNewInternational()
    {
        $this->auth->restrict($this->addPermission);
        $this->saveSupplier('international');
    }

    public function saveEditLocal()
    {
        $this->auth->restrict($this->managePermission);
        $this->saveSupplier('local', true);
    }

    public function saveEditInternational()
    {
        $this->auth->restrict($this->managePermission);
        $this->saveSupplier('international', true);
    }

    private function rejectInput($message)
    {
        echo json_encode(array('status' => 0, 'pesan' => $message));
        return false;
    }

    private function categoryInput($editing = false)
    {
        $post = $this->input->post();
        foreach (array('name_category_supplier' => 100, 'supplier_code' => 100) as $key => $limit) {
            $value = $post[$key] ?? '';
            if (!is_scalar($value) || mb_strlen((string) $value) > $limit) {
                return $this->rejectInput('Data kategori supplier tidak valid.');
            }
            $post[$key] = trim((string) $value);
        }
        if ($post['name_category_supplier'] === '') { return $this->rejectInput('Nama kategori supplier wajib diisi.'); }
        if ($editing) {
            $id = $post['id_category_supplier'] ?? '';
            if (!is_string($id) || $id === '' || !$this->db->get_where('child_supplier_category', array('id_category_supplier' => $id))->num_rows()) {
                return $this->rejectInput('Kategori supplier tidak ditemukan.');
            }
        }
        return $post;
    }

    private function saveSupplier($location, $editing = false)
    {
        $post = $this->input->post();
        $fields = array(
            'id_category_supplier' => 20, 'name_suplier' => 255, 'moq' => 255,
            'telephone' => 20, 'telephone_2' => 20, 'fax' => 255, 'email' => 255,
            'start_date' => 10, 'address_office' => 255, 'zip_code' => 10,
            'longitude' => 255, 'latitude' => 255, 'activation' => 10,
            'name_bank' => 50, 'no_rekening' => 255, 'nama_rekening' => 255,
            'alamat_bank' => 255, 'swift_code' => 255, 'payment_term' => 50
        );
        $fields += $location === 'local'
            ? array('id_prov' => 255, 'id_kota' => 255, 'npwp' => 255, 'npwp_name' => 255, 'npwp_address' => 255)
            : array('id_negara' => 255, 'international_prov' => 255, 'international_kota' => 255);
        $header = array();
        foreach ($fields as $key => $limit) {
            $value = $post[$key] ?? '';
            if (!is_scalar($value) || mb_strlen((string) $value) > $limit) {
                return $this->rejectInput('Data supplier tidak valid: ' . $key);
            }
            $header[$key] = trim((string) $value);
        }
        if ($header['name_suplier'] === '' || $header['id_category_supplier'] === ''
            || !in_array($header['activation'], array('aktif', 'inaktif'), true)
            || !in_array($header['payment_term'], array('LC', 'T/T 30 Day After BL Date', 'T/T 60 Day After BL Date'), true)
            || ($header['email'] !== '' && !filter_var($header['email'], FILTER_VALIDATE_EMAIL))
            || ($header['moq'] !== '' && (!is_numeric($header['moq']) || (float) $header['moq'] < 0))) {
            return $this->rejectInput('Lengkapi data supplier dengan benar.');
        }
        $date = $header['start_date'];
        $parsed = preg_match('/^\d{4}-\d{2}-\d{2}$/D', $date) ? DateTimeImmutable::createFromFormat('!Y-m-d', $date) : false;
        if ($date !== '' && (!$parsed || $parsed->format('Y-m-d') !== $date)) {
            return $this->rejectInput('Tanggal mulai tidak valid.');
        }
        $header['start_date'] = $date === '' ? null : $date;
        if (!$this->db->get_where('child_supplier_category', array('id_category_supplier' => $header['id_category_supplier'], 'activation' => 'active'))->num_rows()) {
            return $this->rejectInput('Kategori supplier tidak ditemukan atau tidak aktif.');
        }
        if ($location === 'local' && ($header['id_prov'] !== '' || $header['id_kota'] !== '')
            && !$this->db->get_where('kota', array('id_prov' => $header['id_prov'], 'id_kota' => $header['id_kota']))->num_rows()) {
            return $this->rejectInput('Kota tidak sesuai dengan provinsi.');
        }
        if ($location === 'international' && $header['id_negara'] !== ''
            && !$this->db->get_where('negara', array('id_negara' => $header['id_negara']))->num_rows()) {
            return $this->rejectInput('Negara tidak ditemukan.');
        }
        $pics = $post['data1'] ?? array();
        if (!is_array($pics)) { return $this->rejectInput('Data PIC tidak valid.'); }
        foreach ($pics as &$pic) {
            if (!is_array($pic)) { return $this->rejectInput('Data PIC tidak valid.'); }
            $clean = array();
            foreach (array('name_pic' => 100, 'phone_pic' => 20, 'email_pic' => 200, 'position_pic' => 20) as $key => $limit) {
                $value = $pic[$key] ?? '';
                if (!is_scalar($value) || mb_strlen((string) $value) > $limit) {
                    return $this->rejectInput('Data PIC tidak valid: ' . $key);
                }
                $clean[$key] = trim((string) $value);
            }
            if ($clean['name_pic'] === '' || ($clean['email_pic'] !== '' && !filter_var($clean['email_pic'], FILTER_VALIDATE_EMAIL))) {
                return $this->rejectInput('Nama dan email PIC tidak valid.');
            }
            $pic = $clean;
        }
        unset($pic);
        if ($editing) {
            $id = $post['id_suplier'] ?? '';
            if (!is_string($id) || $id === '' || !$this->db->get_where('master_supplier', array('id_suplier' => $id, 'suplier_location' => $location, 'deleted' => 0))->num_rows()) {
                return $this->rejectInput('Supplier tidak ditemukan.');
            }
            $header['modified_on'] = date('Y-m-d H:i:s');
            $header['modified_by'] = $this->auth->user_id();
        } else {
            $id = $location === 'local' ? $this->Suplier_model->generate_id() : $this->Suplier_model->generate_idint();
            $header += array('id_suplier' => $id, 'suplier_location' => $location, 'deleted' => 0,
                'created_on' => date('Y-m-d H:i:s'), 'created_by' => $this->auth->user_id());
        }
        $debug = $this->db->db_debug;
        $this->db->db_debug = false;
        try {
            if (!$this->db->trans_begin()) { throw new RuntimeException('Supplier transaction could not start'); }
            if ($editing) {
                $this->db->where('id_suplier', $id)->update('master_supplier', $header);
                $this->db->delete('child_supplier_pic', array('id_suplier' => $id));
            } else {
                $this->db->insert('master_supplier', $header);
            }
            foreach ($pics as $pic) { $this->db->insert('child_supplier_pic', array('id_suplier' => $id) + $pic); }
            if (!$this->db->trans_status() || !$this->db->trans_commit()) {
                throw new RuntimeException('Supplier transaction failed');
            }
            echo json_encode(array('status' => 1, 'pesan' => 'Data supplier berhasil disimpan.'));
        } catch (Throwable $e) {
            $this->db->trans_rollback();
            log_message('error', 'Supplier transaction failed.');
            $this->rejectInput('Data supplier gagal disimpan.');
        } finally {
            $this->db->db_debug = $debug;
        }
    }
	public function saveEditCategory(){
		$this->auth->restrict($this->managePermission);
		$post = $this->categoryInput(true);
		if ($post === false) { return; }
		$this->db->trans_begin();
		$data = [
			'name_category_supplier'	=> $post['name_category_supplier'],
			'supplier_code'				=> $post['supplier_code'],
			'modified_on'		=> date('Y-m-d H:i:s'),
			'modified_by'		=> $this->auth->user_id()
		];
	 
		$this->db->where('id_category_supplier',$post['id_category_supplier'])->update("child_supplier_category",$data);
		
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
	public function saveEditinventory()
    {
        $this->auth->restrict($this->managePermission);
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
		foreach($_POST['data2'] as $d2){
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
    public function getkota()
    {
        $this->auth->restrict($this->viewPermission);
        $id = $this->input->get('id_prov');
        $data = is_scalar($id) && ctype_digit((string) $id) ? $this->Suplier_model->carikota($id) : array();
        echo "<option value=''>--Pilih--</option>";
        foreach ($data as $city) {
            echo "<option value='" . html_escape($city->id_kota) . "'>" . html_escape($city->nama_kota) . "</option>";
        }
    }
	public function saveNewinventoryold()
    {
        $this->auth->restrict($this->addPermission);
		$post = $this->input->post();
		$code = $this->Suplier_model->generate_id();
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
