<?php if (!defined('BASEPATH')) { exit('No direct script access allowed');}

$datppn=array();
class Asset extends Admin_Controller{
   
    protected $viewPermission = 'Asset.View';
    protected $addPermission = 'Asset.Add';
    protected $managePermission = 'Asset.Manage';
    protected $deletePermission = 'Asset.Delete';

    public function __construct(){
        parent::__construct();

		$this->datppn=array('0'=>'Non PPN','10'=>'PPN');
        $this->load->library(array('Mpdf'));
        $this->load->model(array(
			'Asset/Asset_model',
			'Jurnal_nomor/Jurnal_model',
			'Jurnal_nomor/Acc_model',
			'Po_aset/Po_aset_model'
			));

        date_default_timezone_set('Asia/Bangkok');
        $this->template->page_icon('fa fa-table');
    }
	
	public function list_aset(){
        // $this->auth->restrict($this->viewPermission);
        $data = $this->Asset_model->getListTable('asset_out');
        $this->template->set('results', $data);
        $this->template->title('Pengeluaran Aset');
		$this->template->render('list_aset');
    }

	public function create_out(){
		$datcoa     = $this->Acc_model->GetCoaCombo();
		$dataset     = $this->Asset_model->GetAsetCombo();
		$datbank	= $this->Jurnal_model->get_Coa_Bank_Cabang('101');
		$this->template->set('datbank',$datbank);
		$this->template->set('dataset',$dataset);
		$this->template->set('datcoa',$datcoa);
        $this->template->set('datppn',$this->datppn);
        $this->template->set('dataaset',$dataaset);
		$this->template->title('Pengeluaran Aset');
        $this->template->render('aset_form');
	}

	public function edit_out($id){
		$datcoa     = $this->Acc_model->GetCoaCombo();
		$dataset     = $this->Asset_model->GetAsetCombo();
		$datbank	= $this->Jurnal_model->get_Coa_Bank_Cabang('101');
        $data = $this->Asset_model->getWhere('asset_out','id',$id);
        $this->template->set('data', $data[0]);
		$this->template->set('datbank',$datbank);
		$this->template->set('dataset',$dataset);
		$this->template->set('datcoa',$datcoa);
        $this->template->set('datppn',$this->datppn);
        $this->template->set('dataaset',$dataaset);
		$this->template->title('Pengeluaran Aset');
        $this->template->render('aset_form');
	}
	
	function save_out(){
		
        $id			= $this->input->post("id");
		$kd_asset	= $this->input->post('kd_asset');
		$coa    	= $this->input->post('coa');
		$notes		= $this->input->post('notes');
		$tgl		= $this->input->post('tgl');
		$bank		= $this->input->post('bank');
		$ppn		= $this->input->post("ppn");
		$nilai_ppn	= $this->input->post("nilai_ppn");
		$nilai_jual	= $this->input->post('nilai_jual');
		$nilai_akumulasi	= $this->input->post('nilai_akumulasi');
		$nilai_aset	= $this->input->post('nilai_aset');
		$nilai_selisih	= $this->input->post('nilai_selisih');
		$nilai_buku	= $this->input->post('nilai_buku');
		$this->db->trans_start();
		if($id!=''){
			$data = array(
					'kd_asset'=>$kd_asset, 'notes'=>$notes, 'tgl'=>$tgl,'bank'=>$bank,'ppn'=>$ppn,'nilai_ppn'=>$nilai_ppn,
					'nilai_jual'=>$nilai_jual, 'nilai_akumulasi'=>$nilai_akumulasi, 'nilai_aset'=>$nilai_aset, 'nilai_selisih'=>$nilai_selisih, 'nilai_buku'=>$nilai_buku,'coa'=>$coa,
					'modified_by'=> $this->auth->user_id(),
					'modified_on'=>date("Y-m-d h:i:s"),
					);
			$this->identitas_model->DataUpdate('asset_out',$data,array('id'=>$id));
		}else{
					if ($nilai_buku < $nilai_jual){
					$data = array(
					'status'=>0, 'kd_asset'=>$kd_asset, 'notes'=>$notes, 'tgl'=>$tgl,'bank'=>$bank,'ppn'=>$ppn,'nilai_ppn'=>$nilai_ppn,
					'nilai_jual'=>$nilai_jual, 'nilai_akumulasi'=>$nilai_akumulasi, 'nilai_aset'=>$nilai_aset, 
					'nilai_selisih'=>$nilai_selisih, 'nilai_buku'=>$nilai_buku,
					'created_by'=> $this->auth->user_id(),
					'created_on'=>date("Y-m-d h:i:s"),'laba'=>$nilai_selisih*-1,'coa'=>$coa,'nilai_jual_ppn'=>$nilai_jual+$nilai_ppn,					
					);					
					}
					else if ($nilai_buku > $nilai_jual){
					$data = array(
					'status'=>0, 'kd_asset'=>$kd_asset, 'notes'=>$notes, 'tgl'=>$tgl,'bank'=>$bank,'ppn'=>$ppn,'nilai_ppn'=>$nilai_ppn,
					'nilai_jual'=>$nilai_jual, 'nilai_akumulasi'=>$nilai_akumulasi, 'nilai_aset'=>$nilai_aset, 
					'nilai_selisih'=>$nilai_selisih, 'nilai_buku'=>$nilai_buku,
					'created_by'=> $this->auth->user_id(),
					'created_on'=>date("Y-m-d h:i:s"),'rugi'=>$nilai_selisih,'coa'=>$coa,'nilai_jual_ppn'=>$nilai_jual+$nilai_ppn,						
					);
					}
			
			
			$this->identitas_model->DataSave('asset_out',$data);
			
			    $kodejurnal1	            ='BUM001';
				$Keterangan_INV1		    = 'Penjualan Aset U/ '.$kd_asset.' TGL JUAL. '.$tgl;

				#AMBIL TEMPLATE JURNAL DAN SIMPAN KE TEMPORARY

				$datajurnal1  	 = $this->Acc_model->GetTemplateJurnal($kodejurnal1);

						foreach($datajurnal1 AS $rec){

						$tabel1  = $rec->menu;
						$posisi1 = $rec->posisi;
						$field1  = $rec->field;
						$param1  = 'kd_asset';
						$value_param1  = $kd_asset;
						$val1 = $this->Acc_model->GetData($tabel1,$field1,$param1,$value_param1);
						$nilaibayar1 = $val1[0]->$field1;

                        if ($field1 == 'nilai_jual_ppn'){ //full
						$nokir1 =$bank;
						}
						elseif ($field1 == 'nilai_aset'){ //full
						$nokir1 =$coa;
						}
						else {
						$nokir1  = $rec->no_perkiraan;
						}



						if ($posisi1=='D'){
						$det_Jurnaltes1[]  = array(
      					  'nomor'         => '',
      					  'tanggal'       => $tgl,
      					  'tipe'          => 'BUM',
      					  'no_perkiraan'  => $nokir1,
      					  'keterangan'    => $Keterangan_INV1,
      					  'no_reff'       => $kd_asset,
						  'debet'         => $nilaibayar1,
						  'kredit'        => 0,
						  'jenis_jurnal'  => 'penjualan'
					     );
						}
						elseif ($posisi1=='K'){
						$det_Jurnaltes1[]  = array(
      					  'nomor'         => '',
      					  'tanggal'       => $tgl,
      					  'tipe'          => 'BUM',
      					  'no_perkiraan'  => $nokir1,
      					  'keterangan'    => $Keterangan_INV1,
      					  'no_reff'       => $kd_asset,
						  'debet'         => 0,
						  'kredit'        => $nilaibayar1,
						  'jenis_jurnal'  => 'penjualan'
					     );
						}

						}

						$this->db->insert_batch('jurnal',$det_Jurnaltes1);
			
			
		}
		$this->db->trans_complete();
        $param = array('save' => $this->db->trans_status());
        echo json_encode($param);
	}
	function update_out($id){
		if($id!=''){
		  $this->db->trans_start();
			$data = $this->identitas_model->DataGetOne('asset_out',array('id'=>$id));
			$this->identitas_model->DataUpdate('asset_out',array('status'=>'1'),array('id'=>$id));
			$this->identitas_model->DataUpdate('asset',array('deleted'=>'Y','deleted_by'=>$this->auth->user_id(),'deleted_date'=>date('Y-m-d')),array('kd_asset'=>$data->kd_asset));
 
//			$this->identitas_model->DataDelete('asset_generate',array('kd_asset'=>$data->kd_asset));

/*
			$category=$data[0]['category'];
			if( $category == 1){
				$coaD 	= "6301-02-01";
				$ketD	= "BIAYA PENYUSUTAN KENDARAAN";
				$coaK 	= "1304-01-01";
				$ketK	= "AKUMULASI PENYUSUTAN KENDARAAN";
			}
			if($category == 2){
				$coaD 	= "6301-04-01";
				$ketD	= "BIAYA PENYUSUTAN PERALATAN";
				$coaK 	= "1304-01-01";
				$ketK	= "AKUMULASI PENYUSUTAN PERALATAN";
			}
			if($category == 3){
				$coaD 	= "6301-01-01";
				$ketD	= "BIAYA PENYUSUTAN BANGUNAN";
				$coaK 	= "1304-01-01";
				$ketK	= "AKUMULASI PENYUSUTAN BANGUNAN";
			}
			$ArrDebit['tipe'] 			= "JV";
			$ArrDebit['nomor'] 			= $this->Jurnal_model->get_Nomor_Jurnal_Sales($data[0]['kdcab'],date('Y-m-d'));
			$ArrDebit['tanggal'] 		= date('Y-m-d');
			$ArrDebit['no_perkiraan'] 	= $coaD;
			$ArrDebit['keterangan'] 		= $ketD;
			$ArrDebit['no_reff'] 		= "";
			$ArrDebit['debet'] 			= $valx['sisa_nilai'];
			$ArrDebit['kredit'] 			= 0;

// bank			
			$ArrKredit['tipe'] 			= "JV";
			$ArrKredit['nomor']			= $this->Jurnal_model->get_Nomor_Jurnal_Sales($data[0]['kdcab'],date('Y-m-d'));
			$ArrKredit['tanggal'] 		= date('Y-m-d');
			$ArrKredit['no_perkiraan'] 	= $data[0]['bank'];
			$ArrKredit['keterangan'] 	= "";
			$ArrKredit['no_reff'] 		= "";
			$ArrKredit['debet'] 		= 0;
			$ArrKredit['kredit'] 		= ($data[0]['nilai_jual']+$data[0]['nilai_ppn']);
// Akumulasi
			$ArrKredit['tipe'] 			= "JV";
			$ArrKredit['nomor']			= $this->Jurnal_model->get_Nomor_Jurnal_Sales($data[0]['kdcab'],date('Y-m-d'));
			$ArrKredit['tanggal'] 		= date('Y-m-d');
			$ArrKredit['no_perkiraan'] 	= $coaK;
			$ArrKredit['keterangan'] 	= "";
			$ArrKredit['no_reff'] 		= "";
			$ArrKredit['debet'] 		= 0;
			$ArrKredit['kredit'] 		= $data[0]['nilai_akumulasi'];
// Nilai Selisih
	if($data[0]['nilai_selisih'>0]){
			$ArrKredit['tipe'] 			= "JV";
			$ArrKredit['nomor']			= $this->Jurnal_model->get_Nomor_Jurnal_Sales($data[0]['kdcab'],date('Y-m-d'));
			$ArrKredit['tanggal'] 		= date('Y-m-d');
			$ArrKredit['no_perkiraan'] 	= $data[0]['coa_selisih'];
			$ArrKredit['keterangan'] 	= "";
			$ArrKredit['no_reff'] 		= "";
			$ArrKredit['debet'] 		= 0;
			$ArrKredit['kredit'] 		= $data[0]['nilai_selisih'];
	}else{
			$ArrDebit['tipe'] 			= "JV";
			$ArrDebit['nomor']			= $this->Jurnal_model->get_Nomor_Jurnal_Sales($data[0]['kdcab'],date('Y-m-d'));
			$ArrDebit['tanggal'] 		= date('Y-m-d');
			$ArrDebit['no_perkiraan'] 	= $data[0]['coa_selisih'];
			$ArrDebit['keterangan'] 	= "";
			$ArrDebit['no_reff'] 		= "";
			$ArrDebit['debet'] 			= $data[0]['nilai_selisih'];
			$ArrDebit['kredit'] 		= 0;
	}
// Aset
			$ArrDebit['tipe'] 			= "JV";
			$ArrDebit['nomor']			= $this->Jurnal_model->get_Nomor_Jurnal_Sales($data[0]['kdcab'],date('Y-m-d'));
			$ArrDebit['tanggal'] 		= date('Y-m-d');
			$ArrDebit['no_perkiraan'] 	= $coaD;
			$ArrDebit['keterangan'] 	= "";
			$ArrDebit['no_reff'] 		= "";
			$ArrDebit['debet'] 			= $data[0]['nilai_aset'];
			$ArrDebit['kredit'] 		= 0;
// Ppn
			$ArrDebit['tipe'] 			= "JV";
			$ArrDebit['nomor']			= $this->Jurnal_model->get_Nomor_Jurnal_Sales($data[0]['kdcab'],date('Y-m-d'));
			$ArrDebit['tanggal'] 		= date('Y-m-d');
			$ArrDebit['no_perkiraan'] 	= "";
			$ArrDebit['keterangan'] 	= "";
			$ArrDebit['no_reff'] 		= "";
			$ArrDebit['debet'] 			= $data[0]['nilai_ppn'];
			$ArrDebit['kredit'] 		= 0;

*/
		  $this->db->trans_complete();
		}
        $param = array('save' => $this->db->trans_status());
        echo json_encode($param);
	}

	function asset_info($kd_asset){
		$dataset     = $this->Asset_model->getWhere('asset', 'kd_asset', $kd_asset);
		$tgl_perolehan = $dataset[0]['tgl_perolehan'];
		$nilai_asset = $dataset[0]['nilai_asset'];
		$coa = $dataset[0]['coa'];
		$datasusut     = $this->db->query("select sum(nilai_susut) as nilai_akumulasi from asset_generate where flag='Y' and kd_asset='".$kd_asset."'");
		$nilai_akumulasi=0;
		if($datasusut->num_rows()>0) {
			$datas=$datasusut->result();
			$nilai_akumulasi= $datas[0]->nilai_akumulasi;
		}
		$aset	= array(
			'status'		=> '1',
			'nilai_asset'	=> $nilai_asset,
			'nilai_akumulasi' => $nilai_akumulasi,
			'nilai_buku' => ($nilai_asset-$nilai_akumulasi),
			'coa' => ($coa),
		);
		echo json_encode($aset);
	}

	public function index(){
        // $this->auth->restrict($this->viewPermission);
        $this->template->title('List PO Assets');
		 $this->auth->restrict($this->viewPermission);
        //$data = $this->Po_aset_model->GetPoAsetPeyusutan();
        $this->template->set('results', $data);
        $this->template->title('PR Aset');
		$this->template->render('list');
    }

    public function aset(){
        // $this->auth->restrict($this->viewPermission);
        $this->template->title('List Assets');
		$cabang		= $this->db->query("SELECT * FROM cabang WHERE sts_aktif = 'aktif'")->result_array();
		$kategori	= $this->db->query("SELECT * FROM asset_category")->result_array();
		$dataArr = array(
			'cabang' => $cabang,
			'kategori' => $kategori
			);
        $this->template->render('index', $dataArr);
    }
	
	public function data_side(){
		$this->Asset_model->getDataJSON();
	}
	
	public function modal_edit(){
		$this->load->view('modal_edit');
	}
	
	public function modal_jurnal(){
		$this->load->view('modal_jurnal');
	}
	
	public function modal_view(){
		$datdivisi  = $this->Acc_model->GetDivisiCombo();
		$this->template->set('datdivisi',$datdivisi);
		$this->load->view('modal_view');
	}
	
	public function modal(){
		$dataArr = array(
			'list_dept' => $this->Asset_model->getList('divisi'),
			'list_catg' => $this->Asset_model->getList('asset_category')
			);
		
		$this->template->render('modal', $dataArr);
	}
	
	public function create(){
		
			$no_pr   = $this->uri->segment(3);
			$search  = $this->db->query("SELECT * FROM tr_pr_aset WHERE no_pr='$no_pr'")->row();
			$idaset  = $search->id_aset;
			
						
			
		$dataArr = array(
			'list_dept' => $this->Asset_model->getList('divisi'),
			'list_catg' => $this->Asset_model->getList('asset_category')
			);
		
		$this->template->render('create', $dataArr);
		
		// $this->template->set('data',$data);
        // $this->template->set('dataaset',$dataaset);
        // $this->template->set('dattipe_pr',$this->dattipe_pr);
        // $this->template->set('datapr',$datapr);
        // $this->template->title('Tambah Penyusutan');
        // $this->template->render('create');
	}
	
	 public function create_aset() {
        $this->auth->restrict($this->addPermission);
		
			
		$nopr = $this->uri->segment(3);			
        $data  = $this->Po_aset_model->find_by(array('no_pr' => $nopr));
	    $dataaset = $this->Po_aset_model->aset_combo($tahun,$bulan);
		$datvendor	= $this->Acc_model->vendor_combo();
        $datdivisi  = $this->Acc_model->GetDivisiCombo();
		
			$dataArr = array(
			'list_dept' => $this->Asset_model->getList('divisi'),
			'list_catg' => $this->Asset_model->getList('asset_category')
			);
		
		$this->template->render('modal', $dataArr);
		$tipe_bayar=$this->Acc_model->tipe_bayar();
		$this->template->set('tipe_bayar',$tipe_bayar);
        $this->template->set('datppn',$this->datppn);
        $this->template->set('datdivisi',$datdivisi);
        $this->template->set('dataaset',$dataaset);
        $this->template->set('datvendor',$datvendor);
        $this->template->set('dattipe_pr',$this->dattipe_pr);
		$this->template->set('data',$data);
		
		
		$this->template->title('Input Penyusutan Aset');
        $this->template->render('create' , $dataArr);
    }
	
	public function InsertJurnal(){
		$ArrJurnal_D = $this->Asset_model->getList('asset_jurnal');
		$ArrJurnal_K = $this->Asset_model->getList('asset_jurnal');
		
		$ArrDebit = array();
		$ArrKredit = array();
		$ArrJavh = array();
		$Loop = 0;
		foreach($ArrJurnal_D AS $val => $valx){
			$Loop++;
			
			if($valx['category'] == 1){
				$coaD 	= "6301-02-01";
				$ketD	= "BIAYA PENYUSUTAN KENDARAAN";
				$coaK 	= "1304-01-01";
				$ketK	= "AKUMULASI PENYUSUTAN KENDARAAN";
			}
			if($valx['category'] == 2){
				$coaD 	= "6301-04-01";
				$ketD	= "BIAYA PENYUSUTAN PERALATAN";
				$coaK 	= "1304-01-01";
				$ketK	= "AKUMULASI PENYUSUTAN PERALATAN";
			}
			if($valx['category'] == 3){
				$coaD 	= "6301-01-01";
				$ketD	= "BIAYA PENYUSUTAN BANGUNAN";
				$coaK 	= "1304-01-01";
				$ketK	= "AKUMULASI PENYUSUTAN BANGUNAN";
			}
			
			
			$ArrDebit[$Loop]['tipe'] 			= "JV";
			$ArrDebit[$Loop]['nomor'] 			= $this->Jurnal_model->get_Nomor_Jurnal_Sales($valx['kdcab'],date('Y-m-d'));
			$ArrDebit[$Loop]['tanggal'] 		= date('Y-m-d');
			$ArrDebit[$Loop]['no_perkiraan'] 	= $coaD;
			$ArrDebit[$Loop]['keterangan'] 		= $ketD;
			$ArrDebit[$Loop]['no_reff'] 		= "";
			$ArrDebit[$Loop]['debet'] 			= $valx['sisa_nilai'];
			$ArrDebit[$Loop]['kredit'] 			= 0;
			
			$ArrKredit[$Loop]['tipe'] 			= "JV";
			$ArrKredit[$Loop]['nomor'] 			= $this->Jurnal_model->get_Nomor_Jurnal_Sales($valx['kdcab'],date('Y-m-d'));
			$ArrKredit[$Loop]['tanggal'] 		= date('Y-m-d');
			$ArrKredit[$Loop]['no_perkiraan'] 	= $coaK;
			$ArrKredit[$Loop]['keterangan'] 	= $ketK;
			$ArrKredit[$Loop]['no_reff'] 		= "";
			$ArrKredit[$Loop]['debet'] 			= 0;
			$ArrKredit[$Loop]['kredit'] 		= $valx['sisa_nilai'];
			
			$ArrJavh[$Loop]['nomor'] 			= $this->Jurnal_model->get_Nomor_Jurnal_Sales($valx['kdcab'],date('Y-m-d'));
			$ArrJavh[$Loop]['tgl'] 			= date('Y-m-d');
			$ArrJavh[$Loop]['jml'] 				= $valx['sisa_nilai'];
			$ArrJavh[$Loop]['kdcab'] 			= $valx['kdcab'];
			$ArrJavh[$Loop]['jenis'] 			= "V";
			$ArrJavh[$Loop]['keterangan'] 		= "PENYUSUTAN ASSET";
			$ArrJavh[$Loop]['bulan'] 			= ltrim(date('m'), 0);
			$ArrJavh[$Loop]['tahun'] 			= date('Y');
			$ArrJavh[$Loop]['user_id'] 			= "System";
			$ArrJavh[$Loop]['tgl_jvkoreksi'] 	= date('Y-m-d');
			
			$this->Jurnal_model->update_Nomor_Jurnal($valx['kdcab'],'JC');
		}
		
		// echo "<pre>";
		// print_r($ArrDebit);
		// print_r($ArrKredit);
		// print_r($ArrJavh);
		// exit;
		
		$this->db->trans_start();
			$this->db->insert_batch('jurnal', $ArrDebit);
			$this->db->insert_batch('jurnal', $ArrKredit);
			$this->db->insert_batch('javh', $ArrJavh);
		$this->db->trans_complete();
		
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$this->db->query("INSERT INTO asset_jurnal_log (tanggal, ket) VALUES ('".date('Y-m-d H:i:s')."', 'FAILED')");			
		}
		else{
			$this->db->trans_commit();
			$this->db->query("INSERT INTO asset_jurnal_log (tanggal, ket) VALUES ('".date('Y-m-d H:i:s')."', 'SUCCESS')");	
		}
	}
	
	public function saved_jurnal(){
		$db2 = $this->load->database('accounting', TRUE);
		$session 		= $this->session->userdata('app_session');
		$Qry_Search 	= "SELECT nomor FROM jurnal WHERE jenis_trans = 'asset jurnal' AND SUBSTRING_INDEX(tanggal, '-', 2) = '".date('Y-m')."' GROUP BY nomor ";
		$ArrDel 		= $db2->query($Qry_Search)->result_array();
		
		$dtListArray = array();
		foreach($ArrDel AS $val => $valx){
			$dtListArray[$val] = $valx['nomor'];
		}
		
		$dtImplode	= "('".implode("','", $dtListArray)."')";
		
		$date_now	= date('Y-m-d');
		$bln		= ltrim(date('m'), 0);
		$thn		= date('Y');
		$bulanx		= date('m');
		
		if(!empty($this->input->post('tgl_jurnal'))){
			$date_now	= $this->input->post('tgl_jurnal')."-01";
			$DtExpl		= explode('-', $date_now);
			$bln		= ltrim($DtExpl[1], 0);
			$thn		= $DtExpl[0];
			$bulanx		= $DtExpl[1];
		}
		
		
		$ArrJurnal_D = $this->Asset_model->getList('asset_jurnal');
		$ArrDebit = array();
		$ArrKredit = array();
		$ArrJavh = array();
		$Loop = 0;
		foreach($ArrJurnal_D AS $val => $valx){
			$Loop++;
			
			if($valx['category'] == 1){
				$coaD 	= "6301-02-01";
				$ketD	= "BIAYA PENYUSUTAN KENDARAAN".$valx['nm_asset']."";
				$coaK 	= "1304-01-01";
				$ketK	= "AKUMULASI PENYUSUTAN KENDARAAN".$valx['nm_asset']."";
			}
			if($valx['category'] == 2){
				$coaD 	= "6301-04-01";
				$ketD	= "BIAYA PENYUSUTAN PERALATAN".$valx['nm_asset']."";
				$coaK 	= "1304-01-01";
				$ketK	= "AKUMULASI PENYUSUTAN PERALATAN".$valx['nm_asset']."";
			}
			if($valx['category'] == 3){
				$coaD 	= "6301-01-01";
				$ketD	= "BIAYA PENYUSUTAN BANGUNAN".$valx['nm_asset']."";
				$coaK 	= "1304-01-01";
				$ketK	= "AKUMULASI PENYUSUTAN BANGUNAN".$valx['nm_asset']."";
			}
			
			$ArrDebit[$Loop]['tipe'] 			= "JV";
			$ArrDebit[$Loop]['nomor'] 			= $this->Jurnal_model->get_Nomor_Jurnal_Sales($valx['kdcab'],date('Y-m-d'));
			$ArrDebit[$Loop]['tanggal'] 		= $date_now;
			$ArrDebit[$Loop]['no_perkiraan'] 	= $coaD;
			$ArrDebit[$Loop]['keterangan'] 		= $ketD;
			$ArrDebit[$Loop]['no_reff'] 		= $this->Jurnal_model->get_Nomor_Jurnal_Sales($valx['kdcab'],date('Y-m-d'));
			$ArrDebit[$Loop]['debet'] 			= $valx['sisa_nilai'];
			$ArrDebit[$Loop]['kredit'] 			= 0;
			$ArrDebit[$Loop]['jenis_trans'] 	= 'asset jurnal';
			
			$ArrKredit[$Loop]['tipe'] 			= "JV";
			$ArrKredit[$Loop]['nomor'] 			= $this->Jurnal_model->get_Nomor_Jurnal_Sales($valx['kdcab'],date('Y-m-d'));
			$ArrKredit[$Loop]['tanggal'] 		= $date_now;
			$ArrKredit[$Loop]['no_perkiraan'] 	= $coaK;
			$ArrKredit[$Loop]['keterangan'] 	= $ketK;
			$ArrKredit[$Loop]['no_reff'] 		= $this->Jurnal_model->get_Nomor_Jurnal_Sales($valx['kdcab'],date('Y-m-d'));
			$ArrKredit[$Loop]['debet'] 			= 0;
			$ArrKredit[$Loop]['kredit'] 		= $valx['sisa_nilai'];
			$ArrKredit[$Loop]['jenis_trans'] 	= 'asset jurnal';
			
			$ArrJavh[$Loop]['nomor'] 			= $this->Jurnal_model->get_Nomor_Jurnal_Sales($valx['kdcab'],date('Y-m-d'));
			$ArrJavh[$Loop]['tgl'] 				= $date_now;
			$ArrJavh[$Loop]['jml'] 				= $valx['sisa_nilai'];
			$ArrJavh[$Loop]['kdcab'] 			= $valx['kdcab'];
			$ArrJavh[$Loop]['jenis'] 			= "V";
			$ArrJavh[$Loop]['keterangan'] 		= "PENYUSUTAN ASSET";
			$ArrJavh[$Loop]['bulan'] 			= $bln;
			$ArrJavh[$Loop]['tahun'] 			= $thn;
			$ArrJavh[$Loop]['user_id'] 			= "System";
			$ArrJavh[$Loop]['tgl_jvkoreksi'] 	= $date_now;
			
			$Qry_Update_Cabang_acc	 = "UPDATE pastibisa_tb_cabang SET nomorJC=nomorJC + 1 WHERE nocab='101'";
        	$db2->query($Qry_Update_Cabang_acc);
						
			//$this->Jurnal_model->update_Nomor_Jurnal($valx['kdcab'],'JM');
		}
		
		// echo "<pre>";
		// print_r($ArrDebit);
		// print_r($ArrKredit);
		// print_r($ArrJavh);
		// exit;
		
		$this->db->trans_start();
			$db2->query("DELETE FROM jurnal WHERE nomor IN ".$dtImplode." ");
			$db2->query("DELETE FROM javh WHERE nomor IN ".$dtImplode." ");			
			$db2->insert_batch('jurnal', $ArrDebit);
			$db2->insert_batch('jurnal', $ArrKredit);
			$db2->insert_batch('javh', $ArrJavh);
			$this->db->query("UPDATE asset_generate SET flag='Y' WHERE bulan='".$bulanx."' AND tahun='".$thn."' ");
		$this->db->trans_complete();
		
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$this->db->query("INSERT INTO asset_jurnal_log (tanggal, ket, jurnal_by, bulan, tahun, kdcab) VALUES ('".date('Y-m-d H:i:s')."', 'FAILED', '".$this->session->userdata['app_session']['username']."', '".$bulanx."', '".$thn."', '".$session['kdcab']."')");
			$Arr_Data	= array(
				'pesan'		=>'Asset gagal disimpan ...',
				'status'	=> 0
			);			
		}
		else{
			$this->db->trans_commit();
			$this->db->query("INSERT INTO asset_jurnal_log (tanggal, ket, jurnal_by, bulan, tahun, kdcab) VALUES ('".date('Y-m-d H:i:s')."', 'SUCCESS', '".$this->session->userdata['app_session']['username']."', '".$bulanx."', '".$thn."', '".$session['kdcab']."')");
			$Arr_Data	= array(
				'pesan'		=>'Asset berhasil disimpan. Terimakasih ...',
				'status'	=> 1
			);
		}
		
		echo json_encode($Arr_Data);
	}
	
	public function saved(){
		
		$Arr_Kembali	= array();
		$data			= $this->input->post();
		
		$no_pr			= $this->input->post('no_pr');
		
	    $session 		= $this->session->userdata('app_session');
		$nmCategory		= $this->Asset_model->getWhere('asset_category', 'id', $data['category']);
		
		$category		= $data['category'];
		$KdCategory		= sprintf('%02s',$category);
		$Ym				= date('Ym');
		$tgl_oleh		= date('Y-m-d');
		
		
		if(!empty($data['tanggal'])){
			$Year			= substr($data['tanggal'], 0,4);
			$Month			= substr($data['tanggal'], 5,2);
			$Ym				= $Year.$Month;
			$tgl_oleh		= $data['tanggal'];
		}
		
		$qQuery			= "SELECT max(kd_asset) as maxP FROM asset WHERE category='".$category."' AND kd_asset LIKE 'AST-".$session['kdcab'].$Ym."-".$KdCategory."-%' ";
		$restQuery		= $this->db->query($qQuery)->result_array();
		
		// AST-1011908-02-0001
		$category		= $data['category'];

		$KdCategory		= sprintf('%02s',$category);
		$angkaUrut2		= $restQuery[0]['maxP'];
		$urutan2		= (int)substr($angkaUrut2, 17, 3);
		$urutan2++;
		$urut2			= sprintf('%03s',$urutan2);

		$kode_assets	= "AST-".$session['kdcab'].$Ym."-".$KdCategory."-".$urut2;
		
		$detailDataDash	= array();
		// echo $kode_assets; exit;
		
		$lopp 	= 0;
		$lopp2 	= 0;
		for($no=1; $no <= $data['qty']; $no++){
			$Nomor	= sprintf('%02s',$no);
			$lopp++; 
			$detailData[$lopp]['kd_asset'] 		= $kode_assets.$Nomor;
			$detailData[$lopp]['nm_asset'] 		= $data['nm_asset'];
			$detailData[$lopp]['tgl_perolehan'] = $tgl_oleh;
			$detailData[$lopp]['category'] 		= $data['category'];
			$detailData[$lopp]['nm_category'] 	= strtoupper($nmCategory[0]['nm_category']);
			$detailData[$lopp]['nilai_asset'] 	= str_replace(',', '', $data['nilai_asset']);
			$detailData[$lopp]['qty'] 			= $data['qty'];
			$detailData[$lopp]['asset_ke'] 		= $no;
			$detailData[$lopp]['depresiasi'] 	= $data['depresiasi'];
			$detailData[$lopp]['value'] 		= str_replace(',', '', $data['value']);
			$detailData[$lopp]['kdcab'] 		= $session['kdcab'];
			$detailData[$lopp]['lokasi_asset'] 	= $data['lokasi_asset'];
			$detailData[$lopp]['created_by'] 	= $this->session->userdata['app_session']['username'];
			$detailData[$lopp]['created_date'] 	= date('Y-m-d h:i:s');
			$detailData[$lopp]['coa'] 	        = $data['coa'];
			
			$jmlx   	= $data['depresiasi'] * 12;
			$date_now 	= date('Y-m-d');
			
			if(!empty($data['tanggal'])){
				$date_now 	= $data['tanggal'];
			}
			
			for($x=1; $x <= $jmlx; $x++){
				$lopp2 += $x;
				
				//bulan depat mulai menyusut
				// $Tanggal 	= date('Y-m', mktime(0,0,0,substr($date_now,5,2)+ $x,1,substr($date_now,0,4)));
				//bulan sekarang langsung disusutkan
				$Tanggal 	= date('Y-m', mktime(0,0,0,substr($date_now,5,2)+ $x,0,substr($date_now,0,4)));
				
				$detailDataDash[$lopp2]['kd_asset'] 	= $kode_assets.$Nomor;
				$detailDataDash[$lopp2]['nm_asset'] 	= $data['nm_asset'];
				$detailDataDash[$lopp2]['category'] 	= $data['category'];
				$detailDataDash[$lopp2]['nm_category'] 	= strtoupper($nmCategory[0]['nm_category']);
				$detailDataDash[$lopp2]['bulan'] 		= substr($Tanggal, 5,2);
				$detailDataDash[$lopp2]['tahun'] 		= substr($Tanggal, 0,4);
				$detailDataDash[$lopp2]['nilai_susut'] 	= str_replace(',', '', $data['value']);
				$detailDataDash[$lopp2]['kdcab'] 		= $session['kdcab'];
			}
			
		}
		
		//print_r($detailData);
		//print_r($detailDataDash);
		//exit;
		
		$this->db->trans_start();
			$this->db->insert_batch('asset', $detailData);
			$this->db->insert_batch('asset_generate', $detailDataDash);
			
				$status_tr	 = "UPDATE tr_po_aset SET penyusutan=1 WHERE no_pr  = '$no_pr' ";
		                $this->db->query($status_tr);
						
		$this->db->trans_complete();
		
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$Arr_Data	= array(
				'pesan'		=>'Asset gagal disimpan ...',
				'status'	=> 0
			);			
		}
		else{
			$this->db->trans_commit();
			$Arr_Data	= array(
				'pesan'		=>'Asset berhasil disimpan. Thanks ...',
				'status'	=> 1
			);
		}
		
		echo json_encode($Arr_Data);
	}
	
	public function edit(){
		$Arr_Kembali	= array();
		$data			= $this->input->post();
		$session 		= $this->session->userdata('app_session');
		
		$helpx			= $data['helpa'];
		
		if($helpx == 'Y'){
			$nmCategory		= $this->Asset_model->getWhere('asset_category', 'id', $data['category']);
		
			$category		= $data['category'];
			$kd_asset		= substr($data['kd_asset'], 0, 18);
			// echo $kd_asset."<br>";
			
			$KdCategory		= sprintf('%02s',$category);
			$Ym				= date('ym');
			
			$qQuery			= "SELECT max(kd_asset) as maxP FROM asset WHERE category='".$category."' AND kd_asset LIKE 'AST-".$session['kdcab'].$Ym."-".$KdCategory."-%' ";
			$restQuery		= $this->db->query($qQuery)->result_array();

			$category		= $data['category'];

			$KdCategory		= sprintf('%02s',$category);
			$angkaUrut2		= $restQuery[0]['maxP'];
			$urutan2		= (int)substr($angkaUrut2, 15, 3);
			$urutan2++;
			$urut2			= sprintf('%03s',$urutan2);

			$kode_assets	= "AST-".$session['kdcab'].$Ym."-".$KdCategory."-".$urut2;
			
			// echo $kode_assets;
			
			$lopp = 0;
			for($no=1; $no <= $data['qty']; $no++){
				$Nomor	= sprintf('%02s',$no);
				$lopp++;
				$detailData[$lopp]['kd_asset'] 		= $kode_assets.$Nomor;
				$detailData[$lopp]['nm_asset'] 		= $data['nm_asset'];
				$detailData[$lopp]['category'] 		= $data['category'];
				$detailData[$lopp]['nm_category'] 	= strtoupper($nmCategory[0]['nm_category']);
				$detailData[$lopp]['nilai_asset'] 	= str_replace(',', '', $data['nilai_asset']);
				$detailData[$lopp]['qty'] 			= $data['qty'];
				$detailData[$lopp]['asset_ke'] 		= $no;
				$detailData[$lopp]['depresiasi'] 	= $data['depresiasi'];
				$detailData[$lopp]['value'] 		= str_replace(',', '', $data['value']);
				$detailData[$lopp]['kdcab'] 		= $session['kdcab'];
				$detailData[$lopp]['lokasi_asset'] 	= $data['lokasi_asset'];
				$detailData[$lopp]['created_by'] 	= $this->session->userdata['app_session']['username'];
				$detailData[$lopp]['created_date'] 	= date('Y-m-d h:i:s');
				
			}
			
			// print_r($detailData);
			
			$Data_Del	= array(
				'deleted' 		=> "Y",
				'deleted_by' 	=> $this->session->userdata['app_session']['username'],
				'deleted_date' 	=> date('Y-m-d h:i:s')
			);
			
		}
		elseif($helpx == 'N'){
			$idx			= $data['id'];
			$lokasi_asset	= $data['lokasi_asset'];
			
			$Data_Update	= array(
				'lokasi_asset' 	=> $lokasi_asset,
				'modified_by' 	=> $this->session->userdata['app_session']['username'],
				'modified_date' => date('Y-m-d h:i:s')
			);
			
			// print_r($Data_Update);
		}
		
		// exit;
		
		$this->db->trans_start();
			if($helpx == 'Y'){
				$this->db->insert_batch('asset', $detailData);

				$this->db->where('kd_asset LIKE ', $kd_asset.'%'); 
				$this->db->update('asset', $Data_Del);
			}
			elseif($helpx == 'N'){
				$this->db->where('id', $idx)->update('asset', $Data_Update);
			}
		$this->db->trans_complete();
		
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$Arr_Data	= array(
				'pesan'		=>'Asset gagal disimpan ...',
				'status'	=> 0
			);			
		}
		else{
			$this->db->trans_commit();
			$Arr_Data	= array(
				'pesan'		=>'Asset berhasil disimpan. Thanks ...',
				'status'	=> 1
			);
		}
		
		echo json_encode($Arr_Data);
	}
	
}
?>
