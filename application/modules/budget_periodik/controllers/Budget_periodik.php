<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/*
 * @author Harboens
 * @copyright Copyright (c) 2020
 *
 * This is controller for Budget Rutin
 */

$status=array();
$waktu=array();
class Budget_periodik extends Admin_Controller
{
    //Permission
    protected $viewPermission 	= 'Pembayaran_Periodik.View';
    protected $addPermission  	= 'Pembayaran_Periodik.Add';
    protected $managePermission = 'Pembayaran_Periodik.Manage';
    protected $deletePermission = 'Pembayaran_Periodik.Delete';
    public function __construct() {
        parent::__construct();
        $this->load->model(array('All/All_model','Budget_periodik/Budget_periodik_model'));
        $this->template->title('Master Pembayaran Rutin');
        $this->template->page_icon('fa fa-cubes');
        date_default_timezone_set('Asia/Bangkok');
		$this->waktu=array("bulan"=>"bulan","tahun"=>"tahun");
    }

    public function index() {
        $this->auth->restrict($this->viewPermission);
        $datdept  = $this->All_model->GetDeptCombo();
		$this->template->set('datdept',$datdept);
        $this->template->title('Master Pembayaran Periodik');
        $this->template->render('list');
    }

    // Data serverside daftar departemen (DataTable).
    public function data_periodik() {
        $this->auth->restrict($this->viewPermission);
        $debug = $this->db->db_debug; $this->db->db_debug = false;
        $draw = 0;
        try {
            $request = array();
            foreach (array('draw','start','length','search','order') as $key) $request[$key] = $this->input->post($key);
            $rawDraw = filter_var($request['draw'], FILTER_VALIDATE_INT);
            $draw = $rawDraw !== false && $rawDraw >= 0 ? $rawDraw : 0;
            $data = $this->Budget_periodik_model->GetBudgetRutinGroupServerside($request);
            $canView = has_permission($this->viewPermission);
            $canManage = has_permission($this->managePermission);
            $rows = array(); $number = $data['start'];
            foreach ($data['rows'] as $row) {
                $dept = json_encode((string) $row->departement, JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP);
                $action = '';
                if ($canView) {
                    $action .= '<a class="btn btn-warning btn-sm view" href="javascript:void(0)" title="View" onclick="new_data(' . html_escape($dept) . ')"><i class="fa fa-eye"></i></a> ';
                }
                if ($canManage) {
                    $action .= '<a class="btn btn-success btn-sm edit" href="javascript:void(0)" title="Edit" onclick="data_edit(' . html_escape($dept) . ')"><i class="fa fa-edit"></i></a>';
                }
                $rows[] = array('DT_RowId' => 'periodik-' . preg_replace('/[^A-Za-z0-9_-]/', '', (string) $row->departement),
                    'no' => ++$number, 'nm_dept' => html_escape($row->nm_dept ?? ''), 'action' => $action);
            }
            $reply = array('draw' => $data['draw'], 'recordsTotal' => $data['total'], 'recordsFiltered' => $data['filtered'], 'data' => $rows);
        } catch (Throwable $e) {
            log_message('error', 'Budget periodik table: ' . $e->getMessage());
            $reply = array('draw' => $draw, 'recordsTotal' => 0, 'recordsFiltered' => 0, 'data' => array(),
                'error' => $e instanceof DomainException ? $e->getMessage() : 'Data budget tidak dapat dimuat.');
        } finally {
            $this->db->db_debug = $debug;
        }
        $this->output->set_content_type('application/json');
        echo json_encode($reply);
    }

    public function create($key) {
        $this->auth->restrict($this->addPermission);
        $datdept  = $this->All_model->GetDeptCombo($key);
        $this->template->set('datdept',$datdept);
//		$datcoa	= $this->All_model->GetBudgetComboCategory('PEMBAYARAN PERIODIK',date("Y"),$key);
		$datcoa	= $this->All_model->GetCoaCombo();
        $data	= $this->Budget_periodik_model->GetBudgetRutin($key);
		$callcoa=$this->All_model->GetComboBudget();
        $this->template->set('callcoa',$callcoa);
        $this->template->set('data_detail',$data);
        $this->template->set('datcoa',$datcoa);
        $this->template->set('waktu',$this->waktu);
		$this->template->title('Input Master Pembayaran Periodik');
        $this->template->render('input_form');
    }

    public function edit($key) {
        $this->auth->restrict($this->addPermission);
        $datdept  = $this->All_model->GetDeptCombo($key);
        $this->template->set('datdept',$datdept);
//		$datcoa	= $this->All_model->GetBudgetComboCategory('PEMBAYARAN PERIODIK',date("Y"),$key);
		$datcoa	= $this->All_model->GetCoaCombo();
        $data	= $this->Budget_periodik_model->GetBudgetRutin($key);
		$callcoa=$this->All_model->GetComboBudget();
        $this->template->set('callcoa',$callcoa);
        $this->template->set('data_detail',$data);
        $this->template->set('datcoa',$datcoa);
        $this->template->set('waktu',$this->waktu);
		$this->template->title('Input Master Pembayaran Periodik');
        $this->template->render('input_form');
	}

    public function save_data(){

		$detail_id		= $this->input->post("detail_id");
        $coa       		= $this->input->post("coa");
        $nama           = $this->input->post("nama");
		$tipe  			= $this->input->post("tipe");
		$bln  			= $this->input->post("bln");
		$thn  			= $this->input->post("thn");
        $nilai			= $this->input->post("nilai");
        $keterangan		= $this->input->post("keterangan");
        $departement	= $this->input->post("departement");
        $kode_id	= $this->input->post("kode_id");

			// Form dikirim sebagai array; input kosong/bukan array tidak boleh melempar TypeError.
			$detail_id = (array) $detail_id; $coa = (array) $coa; $nama = (array) $nama; $tipe = (array) $tipe;
			$bln = (array) $bln; $thn = (array) $thn; $nilai = (array) $nilai; $keterangan = (array) $keterangan; $kode_id = (array) $kode_id;

			// Izin: baris baru butuh Add, mengubah baris yang ada butuh Manage (sebelumnya tanpa cek sama sekali).
			$adaBaru = false; $adaLama = false;
			foreach ($detail_id as $did) { if ($did === '' || $did === null) { $adaBaru = true; } else { $adaLama = true; } }
			if ($adaBaru || !$adaLama) $this->auth->restrict($this->addPermission);
			if ($adaLama) $this->auth->restrict($this->managePermission);

			// Departemen harus ada di master department.
			$deptValid = is_string($departement) && $departement !== '' && $this->db->query('SELECT 1 FROM department WHERE id = ?', array($departement))->row();
			if (!$deptValid) {
				echo json_encode(array('save' => FALSE));
				return;
			}

			$this->db->trans_begin();

			$ids = array();
			foreach ($detail_id as $did) { if ($did !== '' && $did !== null) $ids[] = $did; }
			$budgetcoa=array();
			// Hapus baris departemen ini yang tidak lagi ada di form (sama dengan "id not in (...) and departement=...").
			$this->db->where('departement', $departement);
			if ($ids) $this->db->where_not_in('id', $ids);
			$this->db->delete('ms_budget_rutin');
			for ($x = 0; $x < count($detail_id); $x++) {
				if($tipe[$x]=='bulan'){
					$tanggal=$bln[$x];
				}else{
					$tanggal=$thn[$x];
				}
				if($detail_id[$x]!='') {
					$data = array(
							array(
								'id'=>$detail_id[$x],
								'nama'=>$nama[$x],
								'coa'=>$coa[$x],
								'tipe'=>$tipe[$x],
								'tanggal'=>$tanggal,
								'nilai'=>$nilai[$x],
								'keterangan'=>$keterangan[$x],
								'kode_id'=>$kode_id[$x],
								'departement'=>$departement,
							)
						);
					$this->Budget_periodik_model->update_batch($data,'id');
				}else{
					$data =  array(
								'nama'=>$nama[$x],
								'coa'=>$coa[$x],
								'tipe'=>$tipe[$x],
								'tanggal'=>$tanggal,
								'nilai'=>$nilai[$x],
								'keterangan'=>$keterangan[$x],
								'kode_id'=>$kode_id[$x],
								'departement'=>$departement,
							);
					$this->Budget_periodik_model->insert($data);
				}
			}

//alokasi
			$detail_alokasi	= $this->input->post("detail_alokasi");
			$kode_detail	= $this->input->post("kode_detail");
			$coa_alokasi	= $this->input->post("coa_alokasi");
			$nilai_alokasi	= $this->input->post("nilai_alokasi");
			$kode_detail = (array) $kode_detail; $coa_alokasi = (array) $coa_alokasi; $nilai_alokasi = (array) $nilai_alokasi;
            $this->All_model->dataDelete('ms_budget_rutin_alokasi',array('departement'=>$departement));
			for ($x = 0; $x < count($kode_detail); $x++) {
				$dataalokasi =  array(
						'kode'=>$kode_detail[$x],
						'coa'=>$coa_alokasi[$x],
						'nilai'=>$nilai_alokasi[$x],
						'departement'=>$departement,
						'created_by'=>$this->auth->user_id(),
						'created_on'=>date('Y-m-d H:i:s')
					);
				$this->All_model->dataSave('ms_budget_rutin_alokasi',$dataalokasi);
			}

            if($this->db->trans_status()) {
                $keterangan     = "SUKSES, tambah data ";
                $status         = 1;
                $nm_hak_akses   = $this->addPermission;
                $kode_universal = 'NewData';
                $jumlah         = $x;
                $sql            = $this->db->last_query();
                $result         = TRUE;
            } else {
                $keterangan     = "GAGAL, tambah data ";
                $status         = 0;
                $nm_hak_akses   = $this->addPermission;
                $kode_universal = 'NewData';
                $jumlah         = $x;
                $sql            = $this->db->last_query();
                $result = FALSE;
            }
            simpan_aktifitas($nm_hak_akses, $kode_universal, $keterangan, $jumlah, $sql, $status);
			if ($result) { $this->db->trans_commit(); } else { $this->db->trans_rollback(); }
			$param = array(
					'save' => $result
					);
			echo json_encode($param);
    }

    function hapus_data($id)
    {
        $this->auth->restrict($this->deletePermission);
        if($id!=''){
			$data=$this->All_model->GetOneData('ms_budget_rutin',array('id'=>$id));
			if (!$data) {
				echo json_encode(array('delete' => 0, 'idx' => $id));
				return;
			}
            $this->All_model->dataDelete('ms_budget_rutin_alokasi',array('kode'=>$data->kode_id));
            $result = $this->All_model->dataDelete('ms_budget_rutin',array('id'=>$id));
            $keterangan     = "SUKSES, Delete data Budget ";
            $status         = 1; $nm_hak_akses   = $this->deletePermission; $kode_universal = $id; $jumlah = 1;
            $sql            = $this->db->last_query();
        } else {
            $result = 0;
            $keterangan     = "GAGAL, Delete data Budget ";
            $status         = 0; $nm_hak_akses   = $this->deletePermission; $kode_universal = $id; $jumlah = 1;
            $sql            = $this->db->last_query();
        }
		simpan_aktifitas($nm_hak_akses, $kode_universal, $keterangan, $jumlah, $sql, $status);
        $param = array(
                'delete' => $result,
                'idx'=>$id
                );
        echo json_encode($param);
    }

	function proses_budget_periodik(){
        $this->auth->restrict($this->managePermission);
        $data = $this->Budget_periodik_model->GetBudgetRutin();
		$this->db->trans_begin();
		if(!empty($data)){
			$this->db->query("update ms_budget set bulan_1=0,bulan_2=0, bulan_3=0, bulan_4=0, bulan_5=0, bulan_6=0, bulan_7=0, bulan_8=0, bulan_9=0, bulan_10=0, bulan_11=0, bulan_12=0,total=0 WHERE tahun = ? and kategori='PEMBAYARAN PERIODIK'", array(date("Y")));
			foreach($data AS $record){

				$databudget['tipe']=$record->tipe;
				$databudget['coa']=$record->coa;
				$databudget['tanggal']=$record->tanggal;
				$databudget['nilai']=$record->nilai;
				$databudget['departement']=$record->departement;
				$databudget['kode_id']=$record->kode_id;
				$databudget['tahun']=date("Y");
				if($record->kode_id!=''){ 
					$dtalok=$this->db->query("select * from ms_budget_rutin_alokasi where kode = ?", array($record->kode_id))->result();
					if(!empty($dtalok)){
						foreach($dtalok AS $rdetail){
							$databudget['coa']=$rdetail->coa;
							$databudget['nilai']=($rdetail->nilai*$record->nilai/100);
							$this->Budget_periodik_model->updatebudget($databudget);
						}
					}else{
						$this->Budget_periodik_model->updatebudget($databudget);
					}
				}else{
					$this->Budget_periodik_model->updatebudget($databudget);
				}
			}
		}
		if($this->db->trans_status()) {
			$keterangan     = "SUKSES, proses data ";
			$status         = 1;
			$nm_hak_akses   = $this->addPermission;
			$kode_universal = 'UpdateData';
			$jumlah         = 1;
			$sql            = $this->db->last_query();
			$result         = TRUE;
		} else {
			$keterangan     = "GAGAL, proses data ";
			$status         = 0;
			$nm_hak_akses   = $this->addPermission;
			$kode_universal = 'UpdateData';
			$jumlah         = 1;
			$sql            = $this->db->last_query();
			$result = FALSE;
		}
		if ($result) { $this->db->trans_commit(); } else { $this->db->trans_rollback(); }
		simpan_aktifitas($nm_hak_akses, $kode_universal, $keterangan, $jumlah, $sql, $status);
		$param = array(
				'save' => $result
				);
		echo json_encode($param);
	}
}
