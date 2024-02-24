<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/*
 * @author Syamsudin
 * @copyright Copyright (c) 2022, Syamsudin
 *
 * This is controller for Erp karyawan
 */
 
 class Erp_karyawan extends Admin_Controller 
 {
	 //permission
     protected $viewPermission 	= 'Master_karyawan.View';
     protected $addPermission  	= 'Master_karyawan.Add';
     protected $managePermission = 'Master_karyawan.Manage';
     protected $deletePermission = 'Master_karyawan.Delete';

     public function __construct()
     {
         parent::__construct();
 
         $this->load->library(array('Mpdf', 'upload', 'Image_lib'));
         $this->load->model(array('Erp_karyawan/Erp_karyawan_model',
                                  'Aktifitas/aktifitas_model',
                                 ));
         $this->template->title('Manage Data Employee');
         $this->template->page_icon('fa fa-building-o');
 
         date_default_timezone_set('Asia/Bangkok');
     }

     public function index()
     {
        $this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
		$deleted = '0';
        $data = $this->Erp_karyawan_model->getDataEmpl();
        $this->template->set('results', $data);
        $this->template->title('Employees');
        $this->template->render('index');
     }

     public function add()
     {
        $this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
		$arr_Where			= '';
        $get_Data			= $this->Erp_karyawan_model->getCompanies($arr_Where);
        $get_Data2			= $this->Erp_karyawan_model->getDivisions($arr_Where);
        $get_Data3			= $this->Erp_karyawan_model->getDepartments($arr_Where);
        $get_Data4			= $this->Erp_karyawan_model->getTitles($arr_Where);
        $get_Data5			= $this->Erp_karyawan_model->getPositions($arr_Where);
        $get_Data6			= $this->Erp_karyawan_model->getMarital($arr_Where);
        $get_Data7			= $this->Erp_karyawan_model->getIdfinger($arr_Where);
        $get_Data8			= $this->Erp_karyawan_model->getDivisionsHead($arr_Where);
        $Family_Type		= $this->Erp_karyawan_model->getArray('family_category', array(), 'kode', 'category');
        $Education_Type		= $this->Erp_karyawan_model->getArray('education_level', array(), 'kode', 'category');

        $data = array(
            'title'				=> 'Add Employees',
            'action'			=> 'add',
            'data_companies'	=> $get_Data,
            'data_divisions'	=> $get_Data2,
            'data_divisions_head'  	=> $get_Data8,
            'data_department'  	=> $get_Data3,
            'data_title'  		=> $get_Data4,
            'data_position'  	=> $get_Data5,
            'data_marital'  	=> $get_Data6,
            'data_idfinger'  	=> $get_Data7,
            'family_type'		=> $Family_Type,
            'education_type'		=> $Education_Type
        );

        $this->template->set('results', $data);
        $this->template->title('Add Employee');
        $this->template->render('add');
     }

     public function simpan_employee()
     {
        $Arr_Kembali			= array();
        $data					= $this->input->post();

        $this->db->trans_begin();

        $session                = $this->session->userdata('app_session');
        $data['id']				= $this->Erp_karyawan_model->code_otomatis('employees', 'EMP');
        $data['salary']			= Enkripsi($this->input->post('salary'));
        $data['jabatan']		= Enkripsi($this->input->post('jabatan'));
        $data['pulsa']			= Enkripsi($this->input->post('pulsa'));
        $Arr_Family				= array();
        if ($this->input->post('det_Family')) {
            $det_Detail			= $this->input->post('det_Family');
            $loop				= 0;
            unset($data['det_Family']);
            foreach ($det_Detail as $key => $vals) {
                $loop++;
                $Arr_Family[$loop]					= $vals;
                $Arr_Family[$loop]['employee_id']	= $data['id'];
                $Arr_Family[$loop]['id']			= $data['id'] . '-' . sprintf('%03d', $loop);
                $Arr_Family[$loop]['created_by']	= $session['id_user'];
                $Arr_Family[$loop]['created']		= date('Y-m-d H:i:s');
            }
        }

        $Arr_Education				= array();
        if ($this->input->post('det_Education')) {
            $det_Edu			= $this->input->post('det_Education');
            $ulang				= 0;
            unset($data['det_Education']);
            foreach ($det_Edu as $key => $values) {
                $ulang++;
                $Arr_Education[$ulang]					= $values;
                $Arr_Education[$ulang]['employee_id']	= $data['id'];
                $Arr_Education[$ulang]['id']			= $data['id'] . '-' . sprintf('%03d', $ulang);
                $Arr_Education[$ulang]['created_by']	= $session['id_user'];
                $Arr_Education[$ulang]['created']		= date('Y-m-d H:i:s');
            }
        }
        if ($nik <> '') {
            $data['nik']		= $nik;
        } else {
            $data['nik']		= $this->Erp_karyawan_model->code_otomatisNik('employees', date('Y'), date('m'));
        }
        //echo"<pre>";print_r($Arr_Education);exit;
        $data['created_by']		= $session['id_user'];
        $data['created']		= date('Y-m-d H:i:s');

        if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();        
            $Arr_Kembali		= array(
                'status'		=> 2,
                'pesan'			=> 'Add Employees failed. Please try again later......'
            );
        }
        else{
            if ($this->Erp_karyawan_model->simpan('employees', $data)) {
                if ($Arr_Family) {
                    $this->db->insert_batch('family', $Arr_Family);
                }
                if ($Arr_Education) { 
    
                    $this->db->insert_batch('educational', $Arr_Education);
                }
                $Arr_Kembali		= array(
                    'status'		=> 1,
                    'pesan'			=> 'Add Employees Success. Thank you & have a nice day.......'
                );
                history('Add Data Employees' . $data['name']);
            } 
        }
               
        echo json_encode($Arr_Kembali);
     }


    public function  edit($id = '')
    {
            $arr_Where			= '';
			$get_Data1			= $this->Erp_karyawan_model->getCompanies($arr_Where);
			$get_Data2			= $this->Erp_karyawan_model->getDivisions($arr_Where);
			$get_Data3			= $this->Erp_karyawan_model->getDepartments($arr_Where);
			$get_Data4			= $this->Erp_karyawan_model->getTitles($arr_Where);
			$get_Data5			= $this->Erp_karyawan_model->getPositions($arr_Where);
			$get_Data6			= $this->Erp_karyawan_model->getMarital($arr_Where);
			$get_Data7			= $this->Erp_karyawan_model->getIdfinger($arr_Where);
			$get_Data8			= $this->Erp_karyawan_model->getDivisionsHead($arr_Where);
			$get_Data			= $this->Erp_karyawan_model->getEmployees();
			$Family_Type		= $this->Erp_karyawan_model->getArray('family_category', array(), 'kode', 'category');
			$Education_Type		= $this->Erp_karyawan_model->getArray('education_level', array(), 'kode', 'category');
			$detail				= $this->Erp_karyawan_model->getData('employees', 'id', $id);
			$detail_family		= $this->Erp_karyawan_model->getArray('family', array('employee_id' => $id));
			$detail_education	= $this->Erp_karyawan_model->getArray('educational', array('employee_id' => $id));

            $data = array(
				'title'			=> 'Edit Employees',
				'action'		=> 'edit',
				'data_Employees' => $get_Data,
				'data_companies' => $get_Data1,
				'data_divisions' => $get_Data2,
				'data_department'  => $get_Data3,
				'data_title'  	=> $get_Data4,
				'data_position'  	=> $get_Data5,
				'data_marital'  	=> $get_Data6,
				'data_idfinger'  	=> $get_Data7,
				'data_divisions_head'  	=> $get_Data8,
				'row'				=> $detail,
				'family_type'		=> $Family_Type,
				'rows_family'		=> $detail_family,
				'education_type'	=> $Education_Type,
				'rows_education'		=> $detail_education
			);


            $this->template->set('results', $data);
            $this->template->title('Edit Employee');
            $this->template->render('edit');

    }
    function getDetail($kode = '')
	{
		$Data_Array		= $this->Erp_karyawan_model->getArray('divisions', array('company_id' => $kode), 'id', 'name');
		echo json_encode($Data_Array);
	}

	function getDept($kode = '')
	{
		$Data_Array		= $this->Erp_karyawan_model->getArray('departments', array('division_id' => $kode), 'id', 'name');
		echo json_encode($Data_Array);
	}
	function getTitle($kode = '')
	{
		$Data_Array		= $this->Erp_karyawan_model->getArray('titles', array('department_id' => $kode), 'id', 'name');
		echo json_encode($Data_Array);
	}

 }