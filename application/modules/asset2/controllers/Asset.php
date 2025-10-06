<?php if (!defined('BASEPATH')) { exit('No direct script access allowed');}

class Asset extends Admin_Controller{
   
    protected $viewPermission = 'Barang.View';
    protected $addPermission = 'Barang.Add';
    protected $managePermission = 'Barang.Manage';
    protected $deletePermission = 'Barang.Delete';

    public function __construct(){
        parent::__construct();

        $this->load->library(array('Mpdf','upload'));
        $this->load->model(array(
			'Asset/Asset_model'
			));

        date_default_timezone_set('Asia/Bangkok');
        $this->template->page_icon('fa fa-table');
    }

    public function index(){
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
		$this->load->view('modal_view');
	}
	
	public function modal(){
		$id = $this->uri->segment(3);
		$query = "SELECT a.*, b.nm_dept FROM asset a LEFT JOIN department_center b ON a.cost_center=b.id WHERE a.id='".$id."' LIMIT 1 ";
		$result = $this->db->query($query)->result();
		$dataArr = array(
			'list_dept' => $this->Asset_model->getList('department'),
			'list_catg' => $this->Asset_model->getList('asset_category'),
			'list_cab' 	=> $this->Asset_model->getList('asset_branch'),
			'list_pajak'=> $this->Asset_model->getList('asset_category_pajak'),
			'data' 		=> $result
			);
		
		$this->template->render('modal', $dataArr);
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
				$coaD 	= "6831-02-01";
				$ketD	= "BIAYA PENYUSUTAN KENDARAAN";
				$coaK 	= "1309-05-01";
				$ketK	= "AKUMULASI PENYUSUTAN KENDARAAN";
			}
			if($valx['category'] == 2){
				$coaD 	= "6831-06-01";
				$ketD	= "BIAYA PENYUSUTAN HARTA LAINNYA";
				$coaK 	= "1309-08-01";
				$ketK	= "AKUMULASI PENYUSUTAN HARTA LAINNYA";
			}
			if($valx['category'] == 3){
				$coaD 	= "6831-01-01";
				$ketD	= "BIAYA PENYUSUTAN BANGUNAN";
				$coaK 	= "1309-07-01";
				$ketK	= "AKUMULASI PENYUSUTAN BANGUNAN";
			}
			
			$ArrDebit[$Loop]['tipe'] 			= "JV";
			$ArrDebit[$Loop]['nomor'] 			= $this->Jurnal_model->get_Nomor_Jurnal_Memorial($valx['kdcab'],date('Y-m-d'));
			$ArrDebit[$Loop]['tanggal'] 		= date('Y-m-d');
			$ArrDebit[$Loop]['no_perkiraan'] 	= $coaD;
			$ArrDebit[$Loop]['keterangan'] 		= $ketD;
			$ArrDebit[$Loop]['no_reff'] 		= "";
			$ArrDebit[$Loop]['debet'] 			= $valx['sisa_nilai'];
			$ArrDebit[$Loop]['kredit'] 			= 0;
			
			$ArrKredit[$Loop]['tipe'] 			= "JV";
			$ArrKredit[$Loop]['nomor'] 			= $this->Jurnal_model->get_Nomor_Jurnal_Memorial($valx['kdcab'],date('Y-m-d'));
			$ArrKredit[$Loop]['tanggal'] 		= date('Y-m-d');
			$ArrKredit[$Loop]['no_perkiraan'] 	= $coaK;
			$ArrKredit[$Loop]['keterangan'] 	= $ketK;
			$ArrKredit[$Loop]['no_reff'] 		= "";
			$ArrKredit[$Loop]['debet'] 			= 0;
			$ArrKredit[$Loop]['kredit'] 		= $valx['sisa_nilai'];
			
			$ArrJavh[$Loop]['nomor'] 			= $this->Jurnal_model->get_Nomor_Jurnal_Memorial($valx['kdcab'],date('Y-m-d'));
			$ArrJavh[$Loop]['tgl'] 			= date('Y-m-d');
			$ArrJavh[$Loop]['jml'] 				= $valx['sisa_nilai'];
			$ArrJavh[$Loop]['kdcab'] 			= $valx['kdcab'];
			$ArrJavh[$Loop]['jenis'] 			= "V";
			$ArrJavh[$Loop]['keterangan'] 		= "PENYUSUTAN ASSET";
			$ArrJavh[$Loop]['bulan'] 			= ltrim(date('m'), 0);
			$ArrJavh[$Loop]['tahun'] 			= date('Y');
			$ArrJavh[$Loop]['user_id'] 			= "System";
			$ArrJavh[$Loop]['tgl_jvkoreksi'] 	= date('Y-m-d');
			
			$this->Jurnal_model->update_Nomor_Jurnal($valx['kdcab'],'JM');
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
		$session 		= $this->session->userdata('app_session');
		$ArrDel = $this->db->query("SELECT nomor FROM jurnal WHERE jenis_trans = 'asset jurnal' AND SUBSTRING_INDEX(tanggal, '-', 2) = '".date('Y-m')."' GROUP BY nomor ")->result_array();
		
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
		// print_r($dtImplode);
		// exit;
		
		$ArrJurnal_D = $this->Asset_model->getList('asset_jurnal');
		$ArrDebit = array();
		$ArrKredit = array();
		$ArrJavh = array();
		$Loop = 0;
		foreach($ArrJurnal_D AS $val => $valx){
			$Loop++;
			
			if($valx['category'] == 1){
				$coaD 	= "6831-02-01";
				$ketD	= "BIAYA PENYUSUTAN KENDARAAN";
				$coaK 	= "1309-05-01";
				$ketK	= "AKUMULASI PENYUSUTAN KENDARAAN";
			}
			if($valx['category'] == 2){
				$coaD 	= "6831-06-01";
				$ketD	= "BIAYA PENYUSUTAN HARTA LAINNYA";
				$coaK 	= "1309-08-01";
				$ketK	= "AKUMULASI PENYUSUTAN HARTA LAINNYA";
			}
			if($valx['category'] == 3){
				$coaD 	= "6831-01-01";
				$ketD	= "BIAYA PENYUSUTAN BANGUNAN";
				$coaK 	= "1309-07-01";
				$ketK	= "AKUMULASI PENYUSUTAN BANGUNAN";
			}
			
			$ArrDebit[$Loop]['tipe'] 			= "JV";
			$ArrDebit[$Loop]['nomor'] 			= $this->Jurnal_model->get_Nomor_Jurnal_Memorial($valx['kdcab'],date('Y-m-d'));
			$ArrDebit[$Loop]['tanggal'] 		= $date_now;
			$ArrDebit[$Loop]['no_perkiraan'] 	= $coaD;
			$ArrDebit[$Loop]['keterangan'] 		= $ketD;
			$ArrDebit[$Loop]['no_reff'] 		= $this->Jurnal_model->get_Nomor_Jurnal_Memorial($valx['kdcab'],date('Y-m-d'));
			$ArrDebit[$Loop]['debet'] 			= $valx['sisa_nilai'];
			$ArrDebit[$Loop]['kredit'] 			= 0;
			$ArrDebit[$Loop]['jenis_trans'] 	= 'asset jurnal';
			
			$ArrKredit[$Loop]['tipe'] 			= "JV";
			$ArrKredit[$Loop]['nomor'] 			= $this->Jurnal_model->get_Nomor_Jurnal_Memorial($valx['kdcab'],date('Y-m-d'));
			$ArrKredit[$Loop]['tanggal'] 		= $date_now;
			$ArrKredit[$Loop]['no_perkiraan'] 	= $coaK;
			$ArrKredit[$Loop]['keterangan'] 	= $ketK;
			$ArrKredit[$Loop]['no_reff'] 		= $this->Jurnal_model->get_Nomor_Jurnal_Memorial($valx['kdcab'],date('Y-m-d'));
			$ArrKredit[$Loop]['debet'] 			= 0;
			$ArrKredit[$Loop]['kredit'] 		= $valx['sisa_nilai'];
			$ArrKredit[$Loop]['jenis_trans'] 	= 'asset jurnal';
			
			$ArrJavh[$Loop]['nomor'] 			= $this->Jurnal_model->get_Nomor_Jurnal_Memorial($valx['kdcab'],date('Y-m-d'));
			$ArrJavh[$Loop]['tgl'] 				= $date_now;
			$ArrJavh[$Loop]['jml'] 				= $valx['sisa_nilai'];
			$ArrJavh[$Loop]['kdcab'] 			= $valx['kdcab'];
			$ArrJavh[$Loop]['jenis'] 			= "V";
			$ArrJavh[$Loop]['keterangan'] 		= "PENYUSUTAN ASSET";
			$ArrJavh[$Loop]['bulan'] 			= $bln;
			$ArrJavh[$Loop]['tahun'] 			= $thn;
			$ArrJavh[$Loop]['user_id'] 			= "System";
			$ArrJavh[$Loop]['tgl_jvkoreksi'] 	= $date_now;
			
			$this->Jurnal_model->update_Nomor_Jurnal($valx['kdcab'],'JM');
		}
		
		// echo "<pre>";
		// print_r($ArrDebit);
		// print_r($ArrKredit);
		// print_r($ArrJavh);
		exit;
		
		$this->db->trans_start();
			$this->db->query("DELETE FROM jurnal WHERE nomor IN ".$dtImplode." ");
			$this->db->query("DELETE FROM javh WHERE nomor IN ".$dtImplode." ");
			$this->db->insert_batch('jurnal', $ArrDebit);
			$this->db->insert_batch('jurnal', $ArrKredit);
			$this->db->insert_batch('javh', $ArrJavh);
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
		
		$session 		= $this->session->userdata('app_session');
		$nmCategory		= $this->Asset_model->getWhere('asset_category', 'id', $data['category']);
		
		$category		= $data['category'];
		$penyusutan		= $data['penyusutan'];
		$category_pajak	= $data['category_pajak'];
		$KdCategory		= sprintf('%02s',$category);
		$KdCategoryPjk	= sprintf('%02s',$category_pajak);
		$Ym				= date('ym');
		$tgl_oleh		= date('Y-m-d');
		
		$foto		= $data['foto'];
		$branch		= $data['branch'];
		
		// $nama 			= $_FILES['file']['name'];
		// $ukuran			= $_FILES['file']['size'];
		// $file_tmp  			= $_FILES['file']['tmp_name'];
		
		// echo $nama; exit;
		
		if(!empty($data['tanggal'])){
			$Year			= date('ym',strtotime($data['tanggal']));
			$Ym				= $Year;
			$tgl_oleh		= $data['tanggal'];
		}
		
		$qQuery			= "SELECT max(kd_asset) as maxP FROM asset WHERE category='".$category."' AND kd_asset LIKE '".$branch."-".$Ym.$KdCategory.$KdCategoryPjk."-%' ";
		$restQuery		= $this->db->query($qQuery)->result_array();
		
		// AST-1011908-02-0001

		$angkaUrut2		= $restQuery[0]['maxP'];
		$urutan2		= (int)substr($angkaUrut2, 17, 3);
		$urutan2++;
		$urut2			= sprintf('%03s',$urutan2);

		$kode_assets	= $branch."-".$Ym.$KdCategory.$KdCategoryPjk."-".$urut2;
		
		$config = array(
		  'upload_path' 		=> './assets/foto/',
		  'allowed_types' 		=> 'gif|jpg|png|jpeg|JPG|PNG',
		  'file_name' 			=> $kode_assets,
		  'file_ext_tolower' 	=> TRUE,
		  'overwrite' 			=> TRUE,
		  'max_size' 			=> 2000048,
		  'remove_spaces' 		=> TRUE
		);

		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		if (!$this->upload->do_upload('foto')){
			$result = $this->upload->display_errors();
		}
		else{

			$ext 		= end((explode(".", $_FILES['foto']['name'])));
			$pic 		= $kode_assets.".".strtolower($ext);
			$paths 		= $_SERVER['DOCUMENT_ROOT'].'/assets/foto/'.$pic;
			if(file_exists($paths)){
				unlink($paths);
			}
			$data_foto  = array('upload_data' => $this->upload->data('foto'));
		}
		
		$detailDataDash	= array();
		// echo $kode_assets; exit;
		
		$lopp 	= 0;
		$lopp2 	= 0;
		for($no=1; $no <= $data['qty']; $no++){
			$Nomor	= sprintf('%03s',$no);
			$lopp++; 
			$detailData[$lopp]['kd_asset'] 		= $kode_assets.$Nomor;
			$detailData[$lopp]['nm_asset'] 		= strtolower($data['nm_asset']);
			$detailData[$lopp]['kd_manual'] 	= strtolower($data['kd_manual']);
			$detailData[$lopp]['tgl_perolehan'] = $tgl_oleh;
			$detailData[$lopp]['category'] 		= $data['category'];
			$detailData[$lopp]['category_pajak']= $data['category_pajak'];
			$detailData[$lopp]['nm_category'] 	= strtoupper($nmCategory[0]['nm_category']);
			$detailData[$lopp]['nilai_asset'] 	= str_replace(',', '', $data['nilai_asset']);
			$detailData[$lopp]['qty'] 			= $data['qty'];
			$detailData[$lopp]['asset_ke'] 		= $no;
			$detailData[$lopp]['depresiasi'] 	= $data['depresiasi'];
			$detailData[$lopp]['value'] 		= str_replace(',', '', $data['value']);
			$detailData[$lopp]['kdcab'] 		= $branch;
			$detailData[$lopp]['foto'] 			= $pic;
			$detailData[$lopp]['penyusutan'] 	= $penyusutan;
			$detailData[$lopp]['lokasi_asset'] 	= $data['lokasi_asset'];
			$detailData[$lopp]['cost_center'] 	= $data['cost_center'];
			$detailData[$lopp]['created_by'] 	= $this->session->userdata['app_session']['username'];
			$detailData[$lopp]['created_date'] 	= date('Y-m-d h:i:s');
			
			$jmlx   	= $data['depresiasi'] * 12;
			$date_now 	= date('Y-m-d');
			$date_now_real 	= date('Y-m-d');
			
			if(!empty($data['tanggal'])){
				$date_now 	= $data['tanggal'];
			}
			
			for($x=1; $x <= $jmlx; $x++){
				$lopp2 += $x;
				
				//bulan depat mulai menyusut
				// $Tanggal 	= date('Y-m', mktime(0,0,0,substr($date_now,5,2)+ $x,1,substr($date_now,0,4)));
				//bulan sekarang langsung disusutkan
				$TglNow		= date('Y-m', strtotime($date_now_real));
				$Tanggal 	= date('Y-m', mktime(0,0,0,substr($date_now,5,2)+ $x,0,substr($date_now,0,4)));
				$flagx		= 'X';
				if($penyusutan == 'Y'){
					$flagx		= 'N';
					if($Tanggal < $TglNow){
						$flagx	= 'Y';
					}
				}
				
				$detailDataDash[$lopp2]['kd_asset'] 	= $kode_assets.$Nomor;
				$detailDataDash[$lopp2]['nm_asset'] 	= strtolower($data['nm_asset']);
				$detailDataDash[$lopp2]['kd_manual'] 	= strtolower($data['kd_manual']);
				$detailDataDash[$lopp2]['category'] 	= $data['category'];
				$detailDataDash[$lopp2]['category_pajak'] 	= $data['category_pajak'];
				$detailDataDash[$lopp2]['nm_category'] 	= strtoupper($nmCategory[0]['nm_category']);
				$detailDataDash[$lopp2]['bulan'] 		= substr($Tanggal, 5,2);
				$detailDataDash[$lopp2]['tahun'] 		= substr($Tanggal, 0,4);
				$detailDataDash[$lopp2]['lokasi_asset'] = $data['lokasi_asset'];
				$detailDataDash[$lopp2]['cost_center'] 	= $data['cost_center'];
				$detailDataDash[$lopp2]['nilai_susut'] 	= str_replace(',', '', $data['value']);
				$detailDataDash[$lopp2]['kdcab'] 		= $branch;
				$detailDataDash[$lopp2]['flag'] 		= $flagx;
			}
			
		}
		$this->db->trans_start();
			$this->db->insert_batch('asset', $detailData);
			$this->db->insert_batch('asset_generate', $detailDataDash);
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
	
	//move asset
	public function move_asset(){
		
		$Arr_Kembali	= array();
		$data			= $this->input->post();
		
		$session 		= $this->session->userdata('app_session');
		$nmCategory		= $this->Asset_model->getWhere('asset_category', 'id', $data['category']);
		
		$category		= $data['category'];
		$KdCategory		= sprintf('%02s',$category);
		$Ym				= date('ym');
		$tgl_oleh		= date('Y-m-d');
		
		$branch				= $data['branch'];
		$kd_asset			= $data['kd_asset'];
		$lokasi_asset_new	= $data['lokasi_asset_new'];
		$cost_center_new	= $data['cost_center_new'];
		
		$ArrUpHeader = array(
			'kdcab' 	=> $branch,
			'lokasi_asset' 	=> $lokasi_asset_new,
			'cost_center'	=> $cost_center_new,
			'modified_by' 	=> $this->session->userdata['app_session']['username'],
			'modified_date' => date('Y-m-d h:i:s')
		);
		
		$ArrUpGen = array(
			'kdcab' 	=> $branch,
			'lokasi_asset' 	=> $lokasi_asset_new,
			'cost_center'	=> $cost_center_new
		);
		
		// echo $cost_center_new; exit;
		
		
		
		// print_r($detailData);
		// print_r($detailDataDash);
		// exit;
		
		$this->db->trans_start();
			$this->db->where('kd_asset', $kd_asset);
			$this->db->update('asset', $ArrUpHeader);
			
			$this->db->where(array('kd_asset'=>$kd_asset,'flag'=>'N'));
			$this->db->update('asset_generate', $ArrUpGen);
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
	
	//delete asset
	public function delete_asset(){
		
		$Arr_Kembali	= array();
		$data			= $this->input->post();
		
		$session 		= $this->session->userdata('app_session');
		$nmCategory		= $this->Asset_model->getWhere('asset_category', 'id', $data['category']);

		$kd_asset		= $this->uri->segment(3);
		
		$ArrUpHeader = array(
			'deleted_by' 	=> $this->session->userdata['app_session']['username'],
			'deleted_date' => date('Y-m-d h:i:s')
		);
		
		$ArrUpGen = array(
			'flag' 	=> 'L'
		);

		$this->db->trans_start();
			$this->db->where('kd_asset', $kd_asset);
			$this->db->update('asset', $ArrUpHeader);
			
			$this->db->where(array('kd_asset'=>$kd_asset,'flag'=>'N'));
			$this->db->update('asset_generate', $ArrUpGen);
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
	
	public function list_center(){
		$id = $this->uri->segment(3);
		$query	 	= "SELECT * FROM department_center WHERE id_dept='".$id."' ORDER BY cost_center ASC";
		$Q_result	= $this->db->query($query)->result();
		$option 	= "<option value='0'>Select an Option</option>";
		foreach($Q_result as $row)	{
		$option .= "<option value='".$row->id."'>".strtoupper($row->nm_dept)."</option>"; 
		}
		echo json_encode(array(
			'option' => $option
		));
	}
	
	public function get_jangka_waktu(){
		$id = $this->uri->segment(3);
		$query	 	= "SELECT * FROM asset_category_pajak WHERE id='".$id."' ";
		$Q_result	= $this->db->query($query)->result();
		$data 	 	= $Q_result[0]->jangka_waktu;
		echo json_encode(array(
			'jangka_waktu' => $data
		));
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
