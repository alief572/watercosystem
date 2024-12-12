<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/*
 * @author Harboens
 * @copyright Copyright (c) 2020
 *
 * This is controller for Trasaction Purchase Request
 */

$status=array();
class Expense extends Admin_Controller
{
    //Permission
    protected $viewPermission 	= 'Expense.View';
    protected $addPermission  	= 'Expense.Add';
    protected $managePermission = 'Expense.Manage';
    protected $deletePermission = 'Expense.Delete';
    public function __construct() {
        parent::__construct();
        $this->load->model(array('all/All_model','Expense/Expense_model','All/All_model'));
        $this->template->title('Expense Report');
        $this->template->page_icon('fa fa-cubes');
        date_default_timezone_set('Asia/Bangkok');
		$this->status=array("0"=>"Baru","1"=>"Disetujui","2"=>"Disetujui Management","3"=>"Selesai","9"=>"Ditolak");
    }

	// list kasbon
    public function kasbon() {
		$where=array('a.nama'=>$this->auth->user_name());
		$data = $this->Expense_model->GetListDataKasbon($where);
        $this->template->set('results', $data);
        $this->template->set('status', $this->status);
		$this->template->page_icon('fa fa-list');
		$this->template->title('Kasbon');
        $this->template->render('kasbon_list');
    }
	// list kasbon all
    public function kasbon_list_all() {
		$data = $this->Expense_model->GetListDataKasbon();
        $this->template->set('results', $data);
        $this->template->set('status', $this->status);
		$this->template->page_icon('fa fa-list');
		$this->template->title('Kasbon List');
        $this->template->render('kasbon_list_all');
    }

	// kasbon create
	public function kasbon_create(){
        $this->template->set('mod', '');
        $this->template->render('kasbon_form');
	}

	// kasbon save
	public function kasbon_save(){
        $id             = $this->input->post("id");
		$tgl_doc  		= $this->input->post("tgl_doc");
        $no_doc		    = $this->input->post("no_doc");
        $departement	= $this->input->post("departement");
        $nama			= $this->input->post("nama");
        $keperluan		= $this->input->post("keperluan");
        $keterangan		= $this->input->post("keterangan");
        $jumlah_kasbon	= $this->input->post("jumlah_kasbon");
        $filename		= $this->input->post("filename");
        $bank_id		= $this->input->post("bank_id");
        $accnumber		= $this->input->post("accnumber");
        $accname		= $this->input->post("accname");
        $filename2		= $this->input->post("filename2");
        $project		= $this->input->post("project");

		$this->db->trans_begin();
		$config['upload_path'] = './assets/expense/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp|pdf|doc|docx|jfif';
		$config['remove_spaces'] = TRUE;
		$config['encrypt_name'] = TRUE;
		$filenames=$filename;
		if(!empty($_FILES['doc_file']['name'])){
			$_FILES['file']['name'] = $_FILES['doc_file']['name'];
			$_FILES['file']['type'] = $_FILES['doc_file']['type'];
			$_FILES['file']['tmp_name'] = $_FILES['doc_file']['tmp_name'];
			$_FILES['file']['error'] = $_FILES['doc_file']['error'];
			$_FILES['file']['size'] = $_FILES['doc_file']['size'];
			$this->load->library('upload',$config);
			$this->upload->initialize($config);
			if($this->upload->do_upload('file')){
				$uploadData = $this->upload->data();
				$filenames = $uploadData['file_name'];
			}
		}
		$filenames2=$filename2;
		if(!empty($_FILES['doc_file_2']['name'])){
			$_FILES['file']['name'] = $_FILES['doc_file_2']['name'];
			$_FILES['file']['type'] = $_FILES['doc_file_2']['type'];
			$_FILES['file']['tmp_name'] = $_FILES['doc_file_2']['tmp_name'];
			$_FILES['file']['error'] = $_FILES['doc_file_2']['error'];
			$_FILES['file']['size'] = $_FILES['doc_file_2']['size'];
			$this->load->library('upload',$config); 					
			$this->upload->initialize($config);
			if($this->upload->do_upload('file')){
				$uploadData2 = $this->upload->data();
				$filenames2 = $uploadData2['file_name'];
			}
		}
		
        if($id!="") {
			$data = array(
					'tgl_doc'=>$tgl_doc,
					'departement'=>$departement,
					'keperluan'=>$keperluan,
					'project'=>$project,
					'nama'=>$nama,
					'keterangan'=>$keterangan,
					'jumlah_kasbon'=>$jumlah_kasbon,
					'doc_file_2'=>$filenames2,
					'status'=>0,
					'bank_id'=>$bank_id,
					'accnumber'=>$accnumber,
					'accname'=>$accname,
					'modified_by'=> $this->auth->user_name(),
					'modified_on'=>date("Y-m-d h:i:s"),
				);
			$result=$this->All_model->dataUpdate(DBERP.'.tr_kasbon',$data,array('id'=>$id));
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
			} else {
				$this->db->trans_commit();
			}
        } else {
			$rec = $this->db->query("select no_perkiraan from ".DBACC.".master_oto_jurnal_detail where kode_master_jurnal='BUK030' and menu='kasbon'")->row();
			$no_doc=$this->All_model->GetAutoGenerate('format_kasbon');
            $data =  array(
						'no_doc'=>$no_doc,
						'tgl_doc'=>$tgl_doc,
						'departement'=>$departement,
						'keperluan'=>$keperluan,
						'keterangan'=>$keterangan,
						'nama'=>$nama,
						'jumlah_kasbon'=>$jumlah_kasbon,
						'doc_file'=>$filenames,
						'project'=>$project,
						'coa'=>$rec->no_perkiraan,
						'status'=>0,
						'doc_file_2'=>$filenames2,
						'bank_id'=>$bank_id,
						'accnumber'=>$accnumber,
						'accname'=>$accname,
						'created_by'=> $this->auth->user_name(),
						'created_on'=>date("Y-m-d h:i:s"),
					);
            $id = $this->All_model->dataSave(DBERP.'.tr_kasbon',$data);
            if(is_numeric($id)) {
                $result         = TRUE;
            } else {
                $result = FALSE;
            }
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
			} else {
				$this->db->trans_commit();
			}
        }
        $param = array(
                'save' => $result, 'id'=>$id
                );
        echo json_encode($param);
	}

	public function get_kasbon($nama,$departement){
        $data = $this->All_model->GetOneTable('tr_kasbon',array('nama'=>$nama,'departement'=>$departement,'status'=>'1'),'tgl_doc');
		echo json_encode($data);
		die();
	}

	// kasbon edit	
	public function kasbon_edit($id,$mod=''){
		$data = $this->Expense_model->GetDataKasbon($id);
        $this->template->set('mod', $mod);
        $this->template->set('status', $this->status);
        $this->template->set('data', $data);
        $this->template->set('stsview', '');
		$this->template->title('Kasbon Form');
		$this->template->page_icon('fa fa-list');
        $this->template->render('kasbon_form');
	}
	// kasbon print
	public function kasbon_print($id){
		$results = $this->Expense_model->GetDataKasbon($id);
		$data = array(
			'title'			=> 'Print Kasbon',
			'stsview'		=> 'print',
			'data'			=> $results
		);
		$this->load->view('kasbon_print',$data);
	}
	// kasbon view
	public function kasbon_view($id,$mod=''){
		$data = $this->Expense_model->GetDataKasbon($id);
        $this->template->set('mod', $mod);
        $this->template->set('status', $this->status);
        $this->template->set('data', $data);
        $this->template->set('stsview', 'view');
		$this->template->title('Kasbon Form');
		$this->template->page_icon('fa fa-list');
        $this->template->render('kasbon_form');
	}
	// kasbon approval
	public function kasbon_fin(){
		$datawhere=("a.status=0");
		$data = $this->Expense_model->GetListDataKasbon($datawhere);
        $this->template->set('status', $this->status);
        $this->template->set('results', $data);
        $this->template->set('stsview', 'view');
		$this->template->title('Kasbon Approval');
		$this->template->page_icon('fa fa-list');
        $this->template->render('kasbon_list_fin');
	}

	// kasbon approve
	public function kasbon_approve($id=''){
		$result=false;
        if($id!="") {
			$data = array(
						'id'=>$id,
						'status'=>1,
						'st_reject'=>'',
						'approved_by'=>$this->auth->user_name(),
						'approved_on'=>date("Y-m-d h:i:s")
					);
			$result=$this->All_model->dataUpdate('tr_kasbon',$data,array('id'=>$id));
			$keterangan     = "SUKSES, Update data ".$id;
			$status         = 1; $nm_hak_akses   = $this->managePermission; $kode_universal = $id; $jumlah = 1;
			$sql            = $this->db->last_query();
			simpan_aktifitas($nm_hak_akses, $kode_universal, $keterangan, $jumlah, $sql, $status);
        }
        $param = array(
                'save' => $result, 'id'=>$id
                );
        echo json_encode($param);
	}

	// kasbon delete
	public function kasbon_delete($id){
        $result=$this->All_model->dataDelete('tr_kasbon',array('id'=>$id));
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
        $param = array( 'delete' => $result );
        echo json_encode($param);
	}

	// list
    public function index() {
		$data = $this->Expense_model->GetListData(array('nama'=>$this->auth->user_name(),'pettycash'=>null));
        $this->template->set('results', $data);
        $this->template->set('hakakses', "expense");
        $this->template->set('status', $this->status);
		$this->template->page_icon('fa fa-list');
		$this->template->title('Expense Report');
        $this->template->render('index');
    }

	// create
	public function create(){
		$data_budget = $this->All_model->GetComboBudget('','EXPENSE',date('Y'));
		$data_pc = $this->All_model->GetPettyCashCombo();	
		$data_approval = $this->All_model->GetOneTable('user_emp','','nama_karyawan');     
		
        $data_coa = $this->All_model->GetCoaCombo('5'," a.no_perkiraan like '1101%'");
		$combo_coa_pph=$this->All_model->Getcomboparamcoa('pph_pembelian');
		
		
        $this->template->set('data_coa', $data_coa);	
		$this->template->set('combo_coa_pph', $combo_coa_pph);	
		$this->template->set('data_approval', $data_approval);		
        $this->template->set('data_pc', $data_pc);
        $this->template->set('data_budget', $data_budget);
		$this->template->set('edit', '0');
        $this->template->render('form');
	}

	// edit
	public function edit($id){
		$data = $this->Expense_model->GetDataHeader($id);
		$data_detail	= $this->Expense_model->GetDataDetail($data->no_doc);
		$data_budget = $this->All_model->GetComboBudget('','EXPENSE',date('Y'));
		$data_pc = $this->All_model->GetPettyCashCombo();	
		$data_approval = $this->All_model->GetOneTable('user_emp','','nama_karyawan');     

        $data_coa = $this->All_model->GetCoaCombo('5'," a.no_perkiraan like '1101%'");
		$combo_coa_pph=$this->All_model->Getcomboparamcoa('pph_pembelian');
		
		
        $this->template->set('data_coa', $data_coa);	
		$this->template->set('combo_coa_pph', $combo_coa_pph);			
        $this->template->set('data_approval', $data_approval);	
        $this->template->set('data_pc', $data_pc);
        $this->template->set('data_budget', $data_budget);
        $this->template->set('data_detail', $data_detail);
        $this->template->set('status', $this->status);
        $this->template->set('data', $data);
        $this->template->set('stsview', '');
		$this->template->set('edit', '0');
		$this->template->page_icon('fa fa-list');
        $this->template->render('form');
	}
	
	// edit
	public function edit2($id){
		$data = $this->Expense_model->GetDataHeader($id);
		$data_detail	= $this->Expense_model->GetDataDetail($data->no_doc);
		$data_budget = $this->All_model->GetComboBudget('','EXPENSE',date('Y'));
		$data_pc = $this->All_model->GetPettyCashCombo();	
		$data_approval = $this->All_model->GetOneTable('user_emp','','nama_karyawan');     

        $data_coa = $this->All_model->GetCoaCombo('5'," a.no_perkiraan like '1101%'");
		$combo_coa_pph=$this->All_model->Getcomboparamcoa('pph_pembelian');
		
		
        $this->template->set('data_coa', $data_coa);	
		$this->template->set('combo_coa_pph', $combo_coa_pph);			
        $this->template->set('data_approval', $data_approval);	
        $this->template->set('data_pc', $data_pc);
        $this->template->set('data_budget', $data_budget);
        $this->template->set('data_detail', $data_detail);
        $this->template->set('status', $this->status);
        $this->template->set('data', $data);
        $this->template->set('stsview', '');
		$this->template->set('edit', '1');
		$this->template->page_icon('fa fa-list');
        $this->template->render('form');
	}


	// view
	public function view($id){
		$data = $this->Expense_model->GetDataHeader($id);
		$data_detail	= $this->Expense_model->GetDataDetail($data->no_doc);
		$data_budget = $this->All_model->GetComboBudget('','EXPENSE',date('Y'));
		$data_pc = $this->All_model->GetPettyCashCombo();	
		
		 $data_coa = $this->All_model->GetCoaCombo('5'," a.no_perkiraan like '1101%'");
		$combo_coa_pph=$this->All_model->Getcomboparamcoa('pph_pembelian');
		
		
        $this->template->set('data_coa', $data_coa);	
		$this->template->set('combo_coa_pph', $combo_coa_pph);	
        $this->template->set('data_pc', $data_pc);
        $this->template->set('data_budget', $data_budget);
        $this->template->set('data_detail', $data_detail);
        $this->template->set('status', $this->status);
        $this->template->set('data', $data);
		$this->template->set('edit', '0');
        $this->template->set('stsview', 'view');
		$this->template->page_icon('fa fa-list');
        $this->template->render('form');
	}
	// print
	public function expense_print($id){
		$response = $this->Expense_model->GetDataHeader($id);
		
		// print_r($response);
		// exit;
		
		$data_detail	= $this->Expense_model->GetDataDetail($response->no_doc);
		$data = array(
			'status'		=> $this->status,
			'data_detail'	=> $data_detail,
			'data'			=> $response,
		);
		$this->load->view('expense_print',$data);

/*
		$show = $this->template->load_view('expense_print',$data);
		
		$this->load->library(array('Mpdf'));
		$mpdf=new mPDF('','','','','','','','','','');

		$this->mpdf->SetImportUse();
		$this->mpdf->RestartDocTemplate();
		$this->mpdf->AddPage('P','A4','en');
		$this->mpdf->WriteHTML($show);
		foreach($data_detail as $record){
			if(strpos($record->doc_file,'pdf',0)>1){
				$pagecount = $this->mpdf->SetSourceFile(('assets/expense/'.$record->doc_file));
				$this->mpdf->AddPage();
				for ($i=1; $i<=$pagecount; $i++) {
					$import_page = $this->mpdf->ImportPage($i);
					$this->mpdf->UseTemplate($import_page);
					if ($i < $pagecount) $this->mpdf->AddPage();
				}
			}
		}
		$this->mpdf->Output();
*/
	}
    public function list_expense_approval() {
		$data = $this->Expense_model->GetListData('status=0');
        $this->template->set('status', $this->status);
        $this->template->set('data', $data);
		$this->template->page_icon('fa fa-list');
		$this->template->title('Expense Approval');
        $this->template->render('index_approval');
    }
    public function expense_list_all() {
		$data = $this->Expense_model->GetListData();
		$this->template->page_icon('fa fa-list');
		$this->template->title('Expense Report List');
        $this->template->set('status', $this->status);
        $this->template->set('results', $data);		
        $this->template->set('hakakses', "expense_list");
        $this->template->render('index');
    }	
	public function approval($id){
		$data = $this->Expense_model->GetDataHeader($id);
		$data_detail = $this->Expense_model->GetDataDetail($data->no_doc);
		$data_budget = $this->All_model->GetComboBudget('','EXPENSE',date('Y'));
		$data_approval = $this->All_model->GetOneTable('user_emp','','nama_karyawan');    
		$data_coa = $this->All_model->GetCoaCombo('5'," a.no_perkiraan like '1101%'");
		$combo_coa_pph=$this->All_model->Getcomboparamcoa('pph_pembelian');
		
		
        $this->template->set('data_coa', $data_coa);	
		$this->template->set('combo_coa_pph', $combo_coa_pph);
        $this->template->set('data_approval', $data_approval);
        $this->template->set('data_budget', $data_budget);
        $this->template->set('data_detail', $data_detail);
        $this->template->set('status', $this->status);
        $this->template->set('data', $data);
        $this->template->set('stsview', 'approval');
		$this->template->page_icon('fa fa-list');
		if($data->pettycash!=""){
			$data_budget = $this->All_model->GetPettyCashComboCoa($data->pettycash);
			$data_pc = $this->All_model->GetOneTable('ms_petty_cash','','nama');
			$this->template->set('data_pc', $data_pc);
			$this->template->set('data_budget', $data_budget);
			$this->template->set('edit', '0');
			$this->template->render('form_pc');
		}else{
			$this->template->set('edit', '0');
			$this->template->render('form');
		}
	}
	// approve
	public function approve($id=''){
		$result=false;
        if($id!="") {
			$data = array(
						array(
							'id'=>$id,
							'status'=>1,
							'st_reject'=>"",
							'approved_by'=> $this->auth->user_name(),
							'approved_on'=>date("Y-m-d h:i:s")
						)
					);
			$result = $this->Expense_model->update_batch($data,'id');
			$keterangan     = "SUKSES, Approve data ".$id;
			$status         = 1; $nm_hak_akses   = $this->managePermission; $kode_universal = $id; $jumlah = 1;
			$sql            = $this->db->last_query();
			simpan_aktifitas($nm_hak_akses, $kode_universal, $keterangan, $jumlah, $sql, $status);
        }
        $param = array(
                'save' => $result, 'id'=>$id
                );
        echo json_encode($param);
	}

	// save
	public function save(){
		
		$post = $this->input->post();
		
		// print_r($post);
		// exit;
		
		
		
		$pettycash = $this->input->post("pettycash");
		$app = $this->db->query("SELECT approval FROM ms_petty_cash WHERE nama='$pettycash'")->row();
		
		if($this->input->post("approval")){
			$approval = $this->input->post("approval");
		}
		else{
			$approval = $app->approval;
		}
		
		
        $id             = $this->input->post("id");
		$tgl_doc  		= $this->input->post("tgl_doc");
        $no_doc		    = $this->input->post("no_doc");
        $departement	= $this->input->post("departement");
        $nama			= $this->input->post("nama");
        $approval		= $approval;
        $informasi		= $this->input->post("informasi");		
        $bank_id		= $this->input->post("bank_id");
        $accnumber		= $this->input->post("accnumber");
        $accname		= $this->input->post("accname");	
        $coa			= $this->input->post("coa");
        $detail_id		= $this->input->post("detail_id");
        $deskripsi		= $this->input->post("deskripsi");
        $spesifikasi	= $this->input->post("spesifikasi");
        $qty			= $this->input->post("qty");
        $harga			= $this->input->post("harga");
        $kasbon			= $this->input->post("kasbon");
        $expense		= $this->input->post("expense");
        $tanggal		= $this->input->post("tanggal");
        $keterangan		= $this->input->post("keterangan");
        $filename		= $this->input->post("filename");
        $id_kasbon		= $this->input->post("id_kasbon");
        $grand_total		= $this->input->post("grand_total");
		
		
		// print_r( $grand_total);
		// exit;
		
		
		$add_ppn_nilai	= $this->input->post("add_ppn_nilai");
        $add_ppn_coa	= '1108-01-01';
        $add_pph_nilai	= $this->input->post("add_pph_nilai");
        $add_pph_coa	= $this->input->post("add_pph_coa");
		
		$bank_nama		= $this->input->post("bank_nama");
        $note    		= $this->input->post("note");

		$this->db->trans_begin();
        if($id!="") {
			$data = array(
						'tgl_doc'=>$tgl_doc,
//						'coa'=>$coa,
						'jumlah'=>$grand_total,
						'informasi'=>$informasi,
						'bank_id'=>$bank_id,
						'accnumber'=>$accnumber,
						'status'=>0,
						'accname'=>$accname,
						'pettycash'=>$pettycash,
						'modified_by'=> $this->auth->user_name(),
						'modified_on'=>date("Y-m-d h:i:s"),
						'add_ppn_nilai'=>$add_ppn_nilai,
						'add_ppn_coa'=>$add_ppn_coa,
						'add_pph_nilai'=>$add_pph_nilai,
						'add_pph_coa'=>$add_pph_coa,
						'bank_nama'=>$bank_nama,
						'note'=>$note

					);
			$result = $this->All_model->dataUpdate(DBERP.'.tr_expense',$data,array('id'=>$id));

			$this->All_model->dataDelete(DBERP.'.tr_expense_detail',array('no_doc'=>$no_doc));
			if(!empty($detail_id)){
				foreach ($detail_id as $keys => $val){
					$no_doc = $no_doc;
					if($qty[$keys]>0) {
						$config['upload_path'] = './assets/expense/';
						$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp|pdf|doc|docx|jfif';
						$config['remove_spaces'] = TRUE;
						$config['encrypt_name'] = TRUE;
						$filenames=$filename[$keys];
						if(!empty($_FILES['doc_file_'.$val]['name'])){
							$_FILES['file']['name'] = $_FILES['doc_file_'.$val]['name'];
							$_FILES['file']['type'] = $_FILES['doc_file_'.$val]['type'];
							$_FILES['file']['tmp_name'] = $_FILES['doc_file_'.$val]['tmp_name'];
							$_FILES['file']['error'] = $_FILES['doc_file_'.$val]['error'];
							$_FILES['file']['size'] = $_FILES['doc_file_'.$val]['size'];
							$this->load->library('upload',$config);
							$this->upload->initialize($config);
							if($this->upload->do_upload('file')){
								$uploadData = $this->upload->data();
								$filenames = $uploadData['file_name'];
							}
						}
						$data_detail =  array(
								'no_doc'=>$no_doc,
								'deskripsi'=>$deskripsi[$keys],
								'qty'=>$qty[$keys],
								'harga'=>$harga[$keys],
								'total_harga'=>($qty[$keys]*$harga[$keys]),
								'kasbon'=>$kasbon[$keys],
								'expense'=>$expense[$keys],
								'tanggal'=>$tanggal[$keys],
								'keterangan'=>$keterangan[$keys],
								'coa'=>$coa[$keys],
								'doc_file'=>$filenames,
								'id_kasbon'=>$id_kasbon[$keys],
								'created_by'=> $this->auth->user_name(),
								'created_on'=>date("Y-m-d h:i:s"),
								'modified_by'=> $this->auth->user_name(),
								'modified_on'=>date("Y-m-d h:i:s")
							);
						$this->All_model->dataSave(DBERP.'.tr_expense_detail',$data_detail);
					}
				}
			}
			$keterangan     = "SUKSES, Edit data ".$id;
			$status         = 1; $nm_hak_akses   = ""; $kode_universal = $id; $jumlah = 1;
			$sql            = $this->db->last_query();
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
			} else {
				$this->db->trans_commit();
			}
        } else {
			$no_doc=$this->All_model->GetAutoGenerate('format_expense');
            $data =  array(
						'no_doc'=>$no_doc,
						'tgl_doc'=>$tgl_doc,
						'departement'=>$departement,
						'departement'=>$departement,
						'add_ppn_nilai'=>$add_ppn_nilai,
						'add_ppn_coa'=>$add_ppn_coa,
						'add_pph_nilai'=>$add_pph_nilai,
						'add_pph_coa'=>$add_pph_coa,
//						'coa'=>$coa,
						'nama'=>$nama,
						'informasi'=>$informasi,
						'bank_id'=>$bank_id,
						'accnumber'=>$accnumber,
						'accname'=>$accname,
						'pettycash'=>$pettycash,
						'approval'=>$approval,
						'status'=>0,
						'jumlah'=>$grand_total,
						'created_by'=> $this->auth->user_name(),
						'created_on'=>date("Y-m-d h:i:s"),
						'bank_nama'=>$bank_nama,
						'note'=>$note,
					);
            $id = $this->All_model->dataSave(DBERP.'.tr_expense',$data);
			// update budget
//			$this->Expense_model->Update_budget($id_type,$tgl_doc,$total,$divisi);
			if(!empty($detail_id)){
				foreach ($detail_id as $keys => $val){
					$no_doc			= $no_doc;
					if($qty[$keys]>0) {
						$config['upload_path'] = './assets/expense/';
						$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp|pdf|doc|docx|jfif';
						$config['remove_spaces'] = TRUE;
						$config['encrypt_name'] = TRUE;
						$filenames="";
						if(!empty($_FILES['doc_file_'.$val]['name'])){
							$_FILES['file']['name'] = $_FILES['doc_file_'.$val]['name'];
							$_FILES['file']['type'] = $_FILES['doc_file_'.$val]['type'];
							$_FILES['file']['tmp_name'] = $_FILES['doc_file_'.$val]['tmp_name'];
							$_FILES['file']['error'] = $_FILES['doc_file_'.$val]['error'];
							$_FILES['file']['size'] = $_FILES['doc_file_'.$val]['size'];
							$this->load->library('upload',$config);
							$this->upload->initialize($config);
							if($this->upload->do_upload('file')){
								$uploadData = $this->upload->data();
								$filenames = $uploadData['file_name'];
							}
						}
						$data_detail =  array(
								'no_doc'=>$no_doc,
								'deskripsi'=>$deskripsi[$keys],
								'qty'=>$qty[$keys],
								'harga'=>$harga[$keys],
								'total_harga'=>($qty[$keys]*$harga[$keys]),
								'kasbon'=>$kasbon[$keys],
								'expense'=>$expense[$keys],
								'tanggal'=>$tanggal[$keys],
								'keterangan'=>$keterangan[$keys],
								'doc_file'=>$filenames,
								'id_kasbon'=>$id_kasbon[$keys],
								'coa'=>$coa[$keys],
								'created_by'=> $this->auth->user_name(),
								'created_on'=>date("Y-m-d h:i:s")
							);
						$this->All_model->dataSave(DBERP.'.tr_expense_detail',$data_detail);
					}
				}
			}
            if(is_numeric($id)) {
                $result	= TRUE;
            } else {
                $result = FALSE;
            }
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
			} else {
				$this->db->trans_commit();
			}
        }
        $param = array(
                'save' => $result, 'id'=>$id
                );
        echo json_encode($param);
	}
	
	
	// save
	public function save_edit(){	

        $post = $this->input->post();

        // print_r($post);
		// exit;		
		
		$id             = $this->input->post("id");
		$tgl_doc  		= $this->input->post("tgl_doc");
        $no_doc		    = $this->input->post("no_doc");
        $departement	= $this->input->post("departement");
        $nama			= $this->input->post("nama");
        $informasi		= $this->input->post("informasi");		
        $bank_id		= $this->input->post("bank_id");
        $accnumber		= $this->input->post("accnumber");
        $accname		= $this->input->post("accname");	
        $coa			= $this->input->post("coa");
        $detail_id		= $this->input->post("detail_id");
        $deskripsi		= $this->input->post("deskripsi");
        $spesifikasi	= $this->input->post("spesifikasi");
        $qty			= $this->input->post("qty");
        $harga			= $this->input->post("harga");
        $kasbon			= $this->input->post("kasbon");
        $expense		= $this->input->post("expense");
        $tanggal		= $this->input->post("tanggal");
        $keterangan		= $this->input->post("keterangan");
        $filename		= $this->input->post("filename");
        $id_kasbon		= $this->input->post("id_kasbon");
        $grand_total		= $this->input->post("grand_total");
		$created_on		= $this->input->post("created_on");
		$created_by		= $this->input->post("created_by");
		
		$add_ppn_nilai	= $this->input->post("add_ppn_nilai");
        $add_ppn_coa	= '1108-01-01';
        $add_pph_nilai	= $this->input->post("add_pph_nilai");
        $add_pph_coa	= $this->input->post("add_pph_coa");
		$note    		= $this->input->post("note");

		$this->db->trans_begin();
			
		
		    $data = array(
						'jumlah'=>$grand_total,
						'informasi'=>$informasi,
						'modified_by'=> $this->auth->user_name(),
						'modified_on'=>date("Y-m-d h:i:s"),
						'add_ppn_nilai'=>$add_ppn_nilai,
						'add_ppn_coa'=>$add_ppn_coa,
						'add_pph_nilai'=>$add_pph_nilai,
						'add_pph_coa'=>$add_pph_coa,
						'note'=>$note
					);
			$result = $this->All_model->dataUpdate(DBERP.'.tr_expense',$data,array('id'=>$id));

      
			
			$this->All_model->dataDelete(DBERP.'.tr_expense_detail',array('no_doc'=>$no_doc));
			if(!empty($detail_id)){
				foreach ($detail_id as $keys => $val){
					$no_doc = $no_doc;
					if($qty[$keys]>0) {
						$config['upload_path'] = './assets/expense/';
						$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp|pdf|doc|docx|jfif';
						$config['remove_spaces'] = TRUE;
						$config['encrypt_name'] = TRUE;
						$filenames=$filename[$keys];
						if(!empty($_FILES['doc_file_'.$val]['name'])){
							$_FILES['file']['name'] = $_FILES['doc_file_'.$val]['name'];
							$_FILES['file']['type'] = $_FILES['doc_file_'.$val]['type'];
							$_FILES['file']['tmp_name'] = $_FILES['doc_file_'.$val]['tmp_name'];
							$_FILES['file']['error'] = $_FILES['doc_file_'.$val]['error'];
							$_FILES['file']['size'] = $_FILES['doc_file_'.$val]['size'];
							$this->load->library('upload',$config);
							$this->upload->initialize($config);
							if($this->upload->do_upload('file')){
								$uploadData = $this->upload->data();
								$filenames = $uploadData['file_name'];
							}
						}
						$data_detail =  array(
								'no_doc'=>$no_doc,
								'deskripsi'=>$deskripsi[$keys],
								'qty'=>$qty[$keys],
								'harga'=>$harga[$keys],
								'total_harga'=>($qty[$keys]*$harga[$keys]),
								'kasbon'=>$kasbon[$keys],
								'expense'=>$expense[$keys],
								'tanggal'=>$tanggal[$keys],
								'keterangan'=>$keterangan[$keys],
								'coa'=>$coa[$keys],
								'doc_file'=>$filenames,
								'id_kasbon'=>$id_kasbon[$keys],
								'created_by'=> $created_by[$keys],
								'created_on'=> $created_on[$keys],
								'modified_by'=> $this->auth->user_name(),
								'modified_on'=>date("Y-m-d h:i:s")
							);
						$id2 = $this->All_model->dataSave(DBERP.'.tr_expense_detail',$data_detail);
					}
				}
			}
			$keterangan     = "SUKSES, Edit data ".$id;
			$status         = 1; $nm_hak_akses   = ""; $kode_universal = $id; $jumlah = 1;
			$sql            = $this->db->last_query();
			
			if(is_numeric($id2)) {
                $result	= TRUE;
            } else {
                $result = FALSE;
            }
			
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
			} else {
				$this->db->trans_commit();
			}
			
			 $param = array(
                'save' => $result, 'id'=>$id
                );
             echo json_encode($param);
			
	}

	// delete
	public function delete($id){
		$this->db->trans_begin();
		$data = $this->Expense_model->GetDataHeader($id);
        $this->All_model->dataDelete(DBERP.'.tr_expense_detail',array('no_doc'=>$data->no_doc));
        $this->All_model->dataDelete(DBERP.'.tr_expense',array('no_doc'=>$data->no_doc));
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$result=FALSE;
		} else {
			$this->db->trans_commit();
			$result=TRUE;
		}
        $param = array( 'delete' => $result );
        echo json_encode($param);
	}

	function cekbudget(){
        $dtl		= $this->input->post("dtl");
        $divisi		= $this->input->post("divisi");

		$tanggal	= $this->input->post("tgl_doc");
        $coa	= $this->input->post("coa");
		$tahun = date("Y",strtotime($tanggal));
        $data = $this->Expense_model->GetBudget($coa,$tahun);
		$param=array();
		if($data!==false){
			if($dtl==''){
				$bulan=date("n",strtotime($tanggal));
				$budget=0;
				$terpakai=0;
				for($i=1;$i<=$bulan;$i++){
					$budget=($budget+$data->{"bulan_".$i});
					$terpakai=($terpakai+$data->{"terpakai_bulan_".$i});
				}
				$sisa=($budget-$terpakai);
				$param = array(
						'budget' => $budget,
						'terpakai' => $terpakai,
						'sisa'=>$sisa,
						);
			}else{
				$param=$data;
			}
		}else{
			if($dtl==''){
				$param = array(
						'budget' =>0,
						'terpakai' =>0,
						'sisa'=>0,
						'tipe'=>'',
						);
			}
		}
		echo json_encode($param);
   }
	// list management transport
    public function transport_req_mgt() {
		$data = $this->Expense_model->GetListDataTransportRequest($this->auth->user_name());
        $this->template->set('results', $data);
        $this->template->set('status', $this->status);
		$this->template->page_icon('fa fa-list');
		$this->template->title('Persetujuan Managemen Penggantian Transport');
        $this->template->render('transport_req_mgt_list');
    }

	// list finance transport
    public function transport_req_fin() {
		$data = $this->Expense_model->GetListDataTransportRequest('',array('a.status'=>'0'));
        $this->template->set('results', $data);
        $this->template->set('status', $this->status);
		$this->template->page_icon('fa fa-list');
		$this->template->title('Pengecekan Finance Penggantian Transport');
        $this->template->render('transport_req_fin_list');
    }
	// list pengajuan transport
    public function transport_req_all() {
		$status=array("0"=>"Baru","1"=>"Disetujui","2"=>"Selesai","3"=>"Selesai","9"=>"Ditolak");
		$data = $this->Expense_model->GetListDataTransportRequest();
        $this->template->set('results', $data);
        $this->template->set('status', $status);
		$this->template->page_icon('fa fa-list');
		$this->template->title('Pengajuan  Transport');
        $this->template->render('transport_req_all');
    }

	// list pengajuan transport
    public function transport_req() {
		$data = $this->Expense_model->GetListDataTransportRequest($this->auth->user_name());
        $this->template->set('results', $data);
        $this->template->set('status', $this->status);
		$this->template->page_icon('fa fa-list');
		$this->template->title('Pengajuan Penggantian Transport');
        $this->template->render('transport_req_list');
    }
	// transport pengajuan create
	public function transport_req_create(){
        $this->template->set('mod', '');
        $this->template->render('transport_req_form');
	}

	// transport req save
	public function transport_req_save(){
        $id             = $this->input->post("id");
		$tgl_doc  		= $this->input->post("tgl_doc");
        $no_doc		    = $this->input->post("no_doc");
        $departement	= $this->input->post("departement");
        $nama			= $this->input->post("nama");
		$date1  		= $this->input->post("date1");
		$date2  		= $this->input->post("date2");
        $id_transport	= $this->input->post("id_transport");
        $jumlah_expense	= $this->input->post("jumlah_expense");
        $bank_id		= $this->input->post("bank_id");
        $accnumber		= $this->input->post("accnumber");
        $accname		= $this->input->post("accname");

		$this->db->trans_begin();
        if($id!="") {
			$data = array(
					'tgl_doc'=>$tgl_doc,
					'departement'=>$departement,
					'nama'=>$nama,
					'date1'=>$date1,
					'date2'=>$date2,
					'bank_id'=>$bank_id,
					'accnumber'=>$accnumber,
					'status'=>0,
					'accname'=>$accname,
					'jumlah_expense'=>($jumlah_expense),
					'modified_by'=> $this->auth->user_name(),
					'modified_on'=>date("Y-m-d h:i:s")
				);
			$result=$this->All_model->dataUpdate(DBERP.'.tr_transport_req',$data,array('id'=>$id));
			$result=$this->All_model->dataUpdate(DBERP.'.tr_transport',array('no_req'=>'','status'=>'0'),array('no_req'=>$no_doc));
			if(!empty($id_transport)){
				foreach ($id_transport as $keys => $val){
					$result=$this->All_model->dataUpdate(DBERP.'.tr_transport',array('no_req'=>$no_doc,'status'=>'1'),array('id'=>$val));
				}
			}
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
			} else {
				$this->db->trans_commit();
			}
        } else {
			$no_doc=$this->All_model->GetAutoGenerate('format_transport_req');
            $data =  array(
					'no_doc'=>$no_doc,
					'tgl_doc'=>$tgl_doc,
					'departement'=>$departement,
					'nama'=>$nama,
					'date1'=>$date1,
					'date2'=>$date2,
					'jumlah_expense'=>($jumlah_expense),
					'status'=>0,
					'bank_id'=>$bank_id,
					'accnumber'=>$accnumber,
					'accname'=>$accname,
					'created_by'=> $this->auth->user_name(),
					'created_on'=>date("Y-m-d h:i:s"),
				);
            $id = $this->All_model->dataSave(DBERP.'.tr_transport_req',$data);
			if(!empty($id_transport)){
				foreach ($id_transport as $keys => $val){
					$result=$this->All_model->dataUpdate(DBERP.'.tr_transport',array('no_req'=>$no_doc,'status'=>'1'),array('id'=>$val));
				}
			}
            if(is_numeric($id)) {
                $result         = TRUE;
            } else {
                $result = FALSE;
            }
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
			} else {
				$this->db->trans_commit();
			}
        }
        $param = array(
                'save' => $result, 'id'=>$id
                );
        echo json_encode($param);
	}

	// transport req edit	
	public function transport_req_edit($id,$mod=''){
		$data = $this->Expense_model->GetDataTransportReq($id);
		$data_detail = $this->Expense_model->GetDataTransportInReq($data->no_doc);
        $this->template->set('data_detail', $data_detail);
        $this->template->set('status', $this->status);
        $this->template->set('data', $data);
        $this->template->set('mod', $mod);
        $this->template->set('stsview', '');
		$this->template->page_icon('fa fa-list');
        $this->template->render('transport_req_form');
	}
	public function transport_req_print($id){
		$results = $this->Expense_model->GetDataTransportReq($id);
		$data_detail = $this->Expense_model->GetDataTransportInReq($results->no_doc);
		$data = array(
			'title'			=> 'Print Transportasi Request',
			'stsview'		=> 'print',
			'data_detail'	=> $data_detail,
			'data'			=> $results
		);
		$this->load->view('transport_req_print',$data);
	}
	// transport req view	
	public function transport_req_view($id,$mod=''){
		$data = $this->Expense_model->GetDataTransportReq($id);
		$data_detail = $this->Expense_model->GetDataTransportInReq($data->no_doc);
        $this->template->set('data_detail', $data_detail);
        $this->template->set('status', $this->status);
        $this->template->set('data', $data);
        $this->template->set('mod', $mod);
        $this->template->set('stsview', 'view');
		$this->template->page_icon('fa fa-list');
        $this->template->render('transport_req_form');
	}

	// list transport
    public function transport() {
		$data = $this->Expense_model->GetListDataTransport($this->auth->user_name());
        $this->template->set('results', $data);
		$dt_status=array("0"=>"Baru","1"=>"Diajukan","2"=>"Disetujui Management","3"=>"Selesai");
        $this->template->set('status', $dt_status);
		$this->template->page_icon('fa fa-list');
		$this->template->title('Transportasi');
        $this->template->render('transport_list');
    }

	// transport create
	public function transport_create(){
		$data_departement= $this->All_model->GetDeptCombo();
        $this->template->set('data_departement', $data_departement);
        $this->template->render('transport_form');
	}

	// transport save
	public function transport_save(){
        $id             = $this->input->post("id");
		$tgl_doc  		= $this->input->post("tgl_doc");
        $no_doc		    = $this->input->post("no_doc");
        $departement	= $this->input->post("departement");
        $nama			= $this->input->post("nama");
        $keperluan		= $this->input->post("keperluan");
        $rute			= $this->input->post("rute");
        $nopol			= $this->input->post("nopol");
        $km_awal		= $this->input->post("km_awal");
        $km_akhir		= $this->input->post("km_akhir");
        $bensin			= $this->input->post("bensin");
        $tol			= $this->input->post("tol");
        $parkir			= $this->input->post("parkir");
        $filename		= $this->input->post("filename");
        $lainnya		= $this->input->post("lainnya");
        $keterangan		= $this->input->post("keterangan");

		$this->db->trans_begin();
		$config['upload_path'] = './assets/expense/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp|pdf|doc|docx|jfif|';
		$config['remove_spaces'] = TRUE;
		$config['encrypt_name'] = TRUE;
		$filenames=$filename;
		if(!empty($_FILES['doc_file']['name'])){
			$_FILES['file']['name'] = $_FILES['doc_file']['name'];
			$_FILES['file']['type'] = $_FILES['doc_file']['type'];
			$_FILES['file']['tmp_name'] = $_FILES['doc_file']['tmp_name'];
			$_FILES['file']['error'] = $_FILES['doc_file']['error'];
			$_FILES['file']['size'] = $_FILES['doc_file']['size'];
			$this->load->library('upload',$config);
			$this->upload->initialize($config);
			if($this->upload->do_upload('file')){
				$uploadData = $this->upload->data();
				$filenames = $uploadData['file_name'];
			}
		}
        if($id!="") {
			$data = array(
					'tgl_doc'=>$tgl_doc,
					'departement'=>$departement,
					'keperluan'=>$keperluan,
					'nama'=>$nama,
					'rute'=>$rute,
					'km_awal'=>$km_awal,
					'km_akhir'=>$km_akhir,
					'nopol'=>$nopol,
					'bensin'=>$bensin,
					'tol'=>$tol,
					'lainnya'=>$lainnya,
					'keterangan'=>$keterangan,
					'parkir'=>$parkir,
					'jumlah_kasbon'=>($bensin+$tol+$parkir+$lainnya),
					'doc_file'=>$filenames,
					'modified_by'=> $this->auth->user_name(),
					'modified_on'=>date("Y-m-d h:i:s")
				);
			$result=$this->All_model->dataUpdate(DBERP.'.tr_transport',$data,array('id'=>$id));
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
			} else {
				$this->db->trans_commit();
			}
        } else {
			$no_doc=$this->All_model->GetAutoGenerate('format_transport');
            $data =  array(
					'no_doc'=>$no_doc,
					'tgl_doc'=>$tgl_doc,
					'departement'=>$departement,
					'keperluan'=>$keperluan,
					'nama'=>$nama,
					'rute'=>$rute,
					'km_awal'=>$km_awal,
					'km_akhir'=>$km_akhir,
					'nopol'=>$nopol,
					'bensin'=>$bensin,
					'tol'=>$tol,
					'parkir'=>$parkir,
					'lainnya'=>$lainnya,
					'keterangan'=>$keterangan,
					'jumlah_kasbon'=>($bensin+$tol+$parkir+$lainnya),
					'doc_file'=>$filenames,
					'status'=>0,
					'created_by'=> $this->auth->user_name(),
					'created_on'=>date("Y-m-d h:i:s"),
				);
            $id = $this->All_model->dataSave(DBERP.'.tr_transport',$data);
            if(is_numeric($id)) {
                $result = TRUE;
            } else {
                $result = FALSE;
            }
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
			} else {
				$this->db->trans_commit();
			}
        }
        $param = array(
                'save' => $result, 'id'=>$id
                );
        echo json_encode($param);
	}

	public function get_list_req_transport($nama,$departement,$date1,$date2){
		$data	= $this->db->query("SELECT * FROM tr_transport WHERE nama='".$nama."' and departement='".$departement."' and tgl_doc between '".$date1."' and '".$date2."' and (no_req ='' or no_req is null) order by tgl_doc")->result();
		echo json_encode($data);
		die();
	}
	public function get_transport($nama,$departement){
        $data = $this->All_model->GetOneTable('tr_transport',array('nama'=>$nama,'departement'=>$departement,'status'=>'1'),'tgl_doc');
		echo json_encode($data);
		die();
	}

	// transport edit	
	public function transport_edit($id){
		$data = $this->Expense_model->GetDataTransport($id);
        $this->template->set('status', $this->status);
        $this->template->set('data', $data);
        $this->template->set('stsview', '');
		$this->template->page_icon('fa fa-list');
        $this->template->render('transport_form');
	}

	// transport view
	public function transport_view($id){
		$data = $this->Expense_model->GetDataTransport($id);
        $this->template->set('status', $this->status);
        $this->template->set('data', $data);
        $this->template->set('stsview', 'view');
		$this->template->page_icon('fa fa-list');
        $this->template->render('transport_form');
	}

	// transport fin approve
	public function transport_req_approve($id='',$status){
		$result=false;
        if($id!="") {
			$data = array(
						'id'=>$id,
						'status'=>$status,
						'st_reject'=>'',
					);
			if($status==1){
				$data['fin_check_by']=$this->auth->user_name();
				$data['fin_check_on']=date("Y-m-d h:i:s");
				$data['approved_by']=$this->auth->user_name();
				$data['approved_on']=date("Y-m-d h:i:s");				
			}
			if($status==2){
				$data['management_by']=$this->auth->user_name();
				$data['management_on']=date("Y-m-d h:i:s");
			}
			$result=$this->All_model->dataUpdate('tr_transport_req',$data,array('id'=>$id));
			$keterangan     = "SUKSES, Update data ".$id;
			$status         = 1; $nm_hak_akses   = $this->managePermission; $kode_universal = $id; $jumlah = 1;
			$sql            = $this->db->last_query();
			simpan_aktifitas($nm_hak_akses, $kode_universal, $keterangan, $jumlah, $sql, $status);
        }else{
			$result=false;
			$id=0;
		}
        $param = array(
                'save' => $result, 'id'=>$id
                );
        echo json_encode($param);
	}

	// transport approve
	public function transport_approve($id=''){
		$result=false;
        if($id!="") {
			$data = array(
						'id'=>$id,
						'status'=>1,
					);
			$result=$this->All_model->dataUpdate('tr_transport',$data,array('id'=>$id));
			$keterangan     = "SUKSES, Update data ".$id;
			$status         = 1; $nm_hak_akses   = $this->managePermission; $kode_universal = $id; $jumlah = 1;
			$sql            = $this->db->last_query();
			simpan_aktifitas($nm_hak_akses, $kode_universal, $keterangan, $jumlah, $sql, $status);
        }
        $param = array(
                'save' => $result, 'id'=>$id
                );
        echo json_encode($param);
	}

	// transport delete
	public function transport_delete($id){
		$this->db->trans_begin();
        $result=$this->All_model->dataDelete('tr_transport',array('id'=>$id));
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
        $param = array( 'delete' => $result );
        echo json_encode($param);
	}

	// transport delete
	public function transport_req_delete($id){
		$this->db->trans_begin();
		$data = $this->Expense_model->GetDataTransportReq($id);
		$this->All_model->dataUpdate(DBERP.'.tr_transport',array('status'=>0,'no_req'=>''),array('no_req'=>$data->no_doc));
        $result=$this->All_model->dataDelete('tr_transport_req',array('id'=>$id));
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
        $param = array( 'delete' => $result );
        echo json_encode($param);
	}

	// list petty_cash
    public function petty_cash() {
		$data = $this->Expense_model->GetListData(array('nama'=>$this->auth->user_name(),'pettycash != '=>''));
        $this->template->set('results', $data);
        $this->template->set('status', $this->status);
		$this->template->page_icon('fa fa-list');
		$this->template->title('Petty Cash');
        $this->template->render('index_pc');
    }

	// create petty_cash
	public function create_pc(){
		$data_budget = $this->All_model->GetComboBudget('','EXPENSE',date('Y'));
		$data_pc = $this->All_model->GetOneTable('ms_petty_cash','','nama');
        $this->template->set('data_pc', $data_pc);
        $this->template->set('data_budget', $data_budget);
        $this->template->render('form_pc');
	}

	// edit petty_cash
	public function edit_pc($id){
		$data = $this->Expense_model->GetDataHeader($id);
		$data_detail	= $this->Expense_model->GetDataDetail($data->no_doc);
		$data_budget = $this->All_model->GetPettyCashComboCoa($data->pettycash);
		$data_pc = $this->All_model->GetOneTable('ms_petty_cash','','nama');
        $this->template->set('data_pc', $data_pc);
        $this->template->set('data_budget', $data_budget);
        $this->template->set('data_detail', $data_detail);
        $this->template->set('status', $this->status);
        $this->template->set('data', $data);
        $this->template->set('stsview', '');
		$this->template->page_icon('fa fa-list');
        $this->template->render('form_pc');
	}

	// view petty_cash
	public function view_pc($id){
		$data = $this->Expense_model->GetDataHeader($id);
		$data_detail	= $this->Expense_model->GetDataDetail($data->no_doc);
		$data_budget = $this->All_model->GetComboBudget('','EXPENSE',date('Y'));
		$data_pc = $this->All_model->GetOneTable('ms_petty_cash','','nama');
        $this->template->set('data_pc', $data_pc);
        $this->template->set('data_budget', $data_budget);
        $this->template->set('data_detail', $data_detail);
        $this->template->set('status', $this->status);
        $this->template->set('data', $data);
        $this->template->set('stsview', 'view');
		$this->template->page_icon('fa fa-list');
        $this->template->render('form_pc');
	}
	function getcoabudget(){
		$coa=$this->input->post("coa");
		$coabudget=str_ireplace(";","','",$coa);
		$datacombocoa="";
		$data_budget = $this->db->query("select * from ".DBACC.".coa_master where no_perkiraan in ('".$coabudget."')")->result();
		foreach($data_budget as $keys){
			$datacombocoa.="<option value='".$keys->no_perkiraan."'>".$keys->no_perkiraan." - ".$keys->nama."</option>";
		}
		echo $datacombocoa;die();
	}
	public function reject(){
		$result=false;
        $id		= $this->input->post("id");
		$reason	= $this->input->post("reason");
		$table	= $this->input->post("table");
        if($id!="") {
			$data = array(
						'status'=>9,
						'st_reject'=>$reason,
						'approved_by'=>$this->auth->user_name(),
						'approved_on'=>date("Y-m-d h:i:s")
					);
			$result=$this->All_model->dataUpdate($table,$data,array('id'=>$id));
			$keterangan     = "SUKSES, Reject data ".$id;
			$status         = 1; $nm_hak_akses   = $this->managePermission; $kode_universal = $id; $jumlah = 1;
			$sql            = $this->db->last_query();
			simpan_aktifitas($nm_hak_akses, $kode_universal, $keterangan, $jumlah, $sql, $status);
        }
        $param = array(
                'save' => $result, 'id'=>$id
                );
        echo json_encode($param);
	}
}
