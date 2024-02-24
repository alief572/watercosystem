<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * @author harboens
 * @copyright Copyright (c) 2021, Harboens
 *
 * This is controller for Budget Rutin
 */

class Budget_rutin extends Admin_Controller {

    protected $viewPermission   = "Budget_Rutin.View";
    protected $addPermission    = "Budget_Rutin.Add";
    protected $managePermission = "Budget_Rutin.Manage";
    protected $deletePermission = "Budget_Rutin.Delete";

    public function __construct()
    {
        parent::__construct();

        $this->load->model(array('Budget_rutin/Budget_rutin_model','All/All_model'
                                ));
        $this->template->title('Manage Data Budget Stock');
        $this->template->page_icon('fa fa-table');
        date_default_timezone_set("Asia/Bangkok");
    }

    public function index() {
//        $this->auth->restrict($this->viewPermission);
        $data = $this->Budget_rutin_model->GetBudgetRutin();
        $this->template->set('results', $data);
        $this->template->title('Indeks Budget Stock');
        $this->template->render('list');
    }
	
	public function get_cost_center($department){
        $data = $this->All_model->GetCostCenter($department);
		echo json_encode($data);
		die();
	}
	
	public function get_material($id_type){
        $data = $this->All_model->GetOneTable('ms_material',array('id_type'=>$id_type, 'deleted'=>0),'nama');
		echo json_encode($data);
		die();
	}
	public function get_satuan($id_material){
        $data = $this->All_model->GetOneTable('ms_material_konversi',array('id_material'=>$id_material));
		echo json_encode($data);
		die();
	}
    public function create() {
        $datdepartemen  = $this->All_model->GetDeptCombo();
        $jenisrutin     = $this->All_model->GetOneTable('ms_inventory_type',"id_type != 'I2000001' and deleted='0'",'nama');
        $this->template->set('datdepartemen',$datdepartemen);
        $this->template->set('jenisrutin',$jenisrutin);
		$this->template->title('Input Budget Rutin');
        $this->template->render('budget_rutin_form');
    }

	public function kompilasi(){
		$group_header = $this->db->query("SELECT a.department, a.costcenter, b.nm_dept, c.cost_center FROM budget_rutin_header a join department b on a.department=b.id join department_center c on a.costcenter=c.id where b.company_id='COM003' and c.company_id='COM003' GROUP BY a.department,a.costcenter, b.nm_dept, c.cost_center")->result_array();
		$group_barang = $this->db->query("SELECT a.id_barang, a.jenis_barang, a.satuan, b.nama as jenisbarang, c.nama, c.spec1, c.spec2 FROM budget_rutin_detail a join ms_inventory_type b on a.jenis_barang=b.id_type join ms_material c on a.id_barang=c.id_material GROUP BY a.id_barang, a.jenis_barang, a.satuan, b.nama, c.nama, c.spec1, c.spec2 ORDER BY jenisbarang ASC, nama")->result_array();	
        $this->template->set('group_header',$group_header);
        $this->template->set('group_barang',$group_barang);
		$this->template->title('Kompilasi Budget Stock');
        $this->template->render('kompilasi');
	}

    public function edit($id) {
        $data  = $this->Budget_rutin_model->find_by(array('code_budget' => $id));
        if(!$data) {
            $this->template->set_message("Invalid Budget Stock", 'error');
            redirect('budget_rutin');
        }
		$data_detail  = $this->Budget_rutin_model->GetBudgetRutinDetail($data->code_budget);
        $datdepartemen  = $this->All_model->GetDeptCombo();
		$datcostcenter  = $this->All_model->GetCostCenterCombo($data->department);
		$this->template->set('data',$data);
		$this->template->set('data_detail',$data_detail);
		$this->template->set('datcostcenter',$datcostcenter);
        $this->template->set('datdepartemen',$datdepartemen);
		$this->template->title('Edit Budget Stock');
        $this->template->render('budget_rutin_form');
    }

    public function save_data(){
        $type           = $this->input->post("type");
        $id             = $this->input->post("id");
        $rev             = $this->input->post("rev");
		$department		= $this->input->post("department");
        $costcenter     = $this->input->post("costcenter");
        $jenis_barang	= $this->input->post("jenis_barang");
        $id_barang		= $this->input->post("id_barang");
        $kebutuhan_month= $this->input->post("kebutuhan_month");
        $satuan       	= $this->input->post("satuan");
		$this->db->trans_begin();
        if($type=="edit") {
			$data = array(
					'department'=>$department,
					'costcenter'=>$costcenter,
					'rev'=>($rev+1),
					'modified_by'=> $this->auth->user_id(),
					'modified_on'=>date("Y-m-d h:i:s")
				);
			$this->All_model->dataUpdate('budget_rutin_header',$data,array('code_budget'=>$id));
			$keterangan="SUKSES, Edit data ".$id;
        } else {
			$id=$this->All_model->GetAutoGenerate('format_budget_rutin');
            $data =  array(
					'code_budget'=>$id,
					'department'=>$department,
					'costcenter'=>$costcenter,
					'tanggal'=>date('Y-m-d'),
					'rev'=>0,
					'created_by'=> $this->auth->user_id(),
					'created_on'=>date("Y-m-d h:i:s")
				);
			$this->All_model->dataSave('budget_rutin_header',$data);
			$keterangan="SUKSES, New data ".$id;
		}
		$sql=$this->db->last_query();
		if(!empty($id_barang)){
			$this->All_model->dataDelete('budget_rutin_detail',array('code_budget'=>$id));
			for ($i=0;$i<count($id_barang);$i++){
				if($kebutuhan_month[$i]>0) {
					$data_detail =  array(
							'code_budget'=>$id,
							'jenis_barang'=>$jenis_barang[$i],
							'id_barang'=>$id_barang[$i],
							'kebutuhan_month'=>$kebutuhan_month[$i],
							'satuan'=>$satuan[$i],
						);
					$this->All_model->dataSave('budget_rutin_detail',$data_detail);
				}
			}
		}
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$result=false;
		} else {
			$this->db->trans_commit();
			$result=true;
		}
		$nm_hak_akses   = $this->managePermission; 
		$kode_universal   = $id; 
		simpan_aktifitas($nm_hak_akses, $kode_universal, $keterangan, 1, $sql, 1);
        $param = array(
                'save' => $result, 'id'=>$id
                );
        echo json_encode($param);
    }

    function hapus_data($id)
    {
        $this->auth->restrict($this->deletePermission);
        if($id!=''){
            $result 		= true;
			$this->All_model->dataDelete('budget_rutin_detail',array('code_budget'=>$id));
			$this->All_model->dataDelete('budget_rutin_header',array('code_budget'=>$id));
            $keterangan     = "SUKSES, Delete data Budget ".$id;
            $status         = 1; $nm_hak_akses   = $this->deletePermission; $kode_universal = $id; $jumlah = 1;
            $sql            = $this->db->last_query();
        } else {
            $result 		= 0;
            $keterangan     = "GAGAL, Delete data Budget ".$id;
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
}
