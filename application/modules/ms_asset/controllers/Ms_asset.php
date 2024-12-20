<?php if (!defined('BASEPATH')) { exit('No direct script access allowed');}

class Ms_asset extends CI_Controller{

    public function __construct(){
        parent::__construct();

		$this->load->model('asset_model');
		$this->load->model('master_model');
    }

    public function index(){ 
        $controller			= ucfirst(strtolower($this->uri->segment(1)));
		$Arr_Akses			= getAcccesmenu($controller);
		if($Arr_Akses['read'] !='1'){
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
			redirect(site_url('dashboard'));
		}
		
		$data = array(
			'title'			=> 'Indeks Of Assets',
			'action'		=> 'asset',
			'akses_menu'	=> $Arr_Akses,
			'kategori' 		=> $this->asset_model->getList('asset_category')
		);
        history("View index asset");
        $this->load->view('Ms_asset/index', $data);
    }

	public function data_side(){
		$this->asset_model->getDataJSON();
	}

	public function modal_view(){
		$id = $this->uri->segment(3);
		$qData	= "SELECT a.*, b.nm_costcenter FROM asset a LEFT JOIN costcenter b ON a.id_costcenter=b.id_costcenter WHERE a.id='".$this->uri->segment(3)."'";
		$dataD	= $this->db->query($qData)->result_array();

		$data = array(
			'title'			=> 'Indeks Of Assets',
			'action'		=> 'asset',
			'dataD'			=> $dataD, 
			'list_cab' 		=> $this->asset_model->getList('asset_branch'),
			'list_pajak'	=> $this->asset_model->getList('asset_category_pajak'),
			'list_dept' 	=> $this->asset_model->getList('department'),
			'list_catg' 	=> $this->asset_model->getList('asset_category')
		);
        history("View index asset");
		$this->load->view('Ms_asset/modal_view', $data);
	}

	public function add(){
		if($this->input->post()){
			$Arr_Kembali	= array();
			$data			= $this->input->post();
			$db2 			= $this->load->database('instalasi', TRUE);
			$id				= $data['id'];
			$kd_asset		= $data['kd_asset'];

			
			$nmCategory		= $this->asset_model->getWhere('asset_category', 'id', $data['category']);

			$category		= $data['category'];
			$penyusutan		= $data['penyusutan'];
			$category_pajak	= $data['category_pajak'];
			$KdCategory		= sprintf('%02s',$category);
			$KdCategoryPjk	= sprintf('%02s',$category_pajak);
			$Ym				= date('ym');
			$tgl_oleh		= date('Y-m-d');
			
			$branch		= $data['branch'];

			if(!empty($data['tanggal'])){
				$tgl_oleh		= date('Y-m-d', strtotime($data['tanggal']));
				$Year			= date('y', strtotime($data['tanggal']));
				$Month			= date('m', strtotime($data['tanggal']));
				$Ym				= $Year.$Month;
			}

			$qQuery			= "SELECT max(kd_asset) as maxP FROM asset WHERE category='".$category."' AND kd_asset LIKE '".$branch."-".$Ym.$KdCategory.$KdCategoryPjk."-%' ";
			$restQuery		= $this->db->query($qQuery)->result_array();

			$angkaUrut2		= $restQuery[0]['maxP'];
			$urutan2		= (int)substr($angkaUrut2, 10, 3);
			$urutan2++;
			$urut2			= sprintf('%03s',$urutan2);

			$kode_assets	= $branch."-".$Ym.$KdCategory.$KdCategoryPjk."-".$urut2;

			//kode group
			$q_group		= "SELECT max(code_group) as maxP FROM asset WHERE code_group LIKE 'AS%' ";
			$rest_group		= $this->db->query($q_group)->result_array();

			$angka_group	= $rest_group[0]['maxP'];
			$urut_g			= (int)substr($angka_group, 2, 5);
			$urut_g++;
			$urut			= sprintf('%05s',$urut_g);
			$kode_group		= "AS".$urut;

			//insert to instalasi
			$ArrHeaderInstalasi = array(
				'code_group' 	=> $kode_group,
				'category' 		=> 'asset '.strtolower($nmCategory[0]['nm_category']),
				'spec' 			=> strtolower($data['nm_asset']),
				'created_by' 	=> $this->session->userdata['ORI_User']['username'],
				'created_date' 	=> date('Y-m-d h:i:s')
			);

			$num_cty = $db2->query("SELECT * FROM vehicle_tool_category WHERE category='asset ".strtolower($nmCategory[0]['nm_category'])."' ")->num_rows();

			$ArrCategory = array(
				'category' 		=> 'asset '.strtolower($nmCategory[0]['nm_category']),
				'created_by' 	=> 'asset',
				'created_date' 	=> date('Y-m-d h:i:s')
			);

			$region = $db2->query("SELECT * FROM region ORDER BY urut ASC")->result_array();
			$ArrPrice = array();
			foreach ($region as $key => $value) {
				$ArrPrice[$key]['category'] 		= 'vehicle tool';
				$ArrPrice[$key]['code_group'] 		= $kode_group;
				$ArrPrice[$key]['unit_material'] 	= 'month';
				$ArrPrice[$key]['kurs'] 			= 'IDR';
				$ArrPrice[$key]['region'] 			= $value['region'];
				$ArrPrice[$key]['rate'] 			= str_replace(',', '', $data['value']);
				$ArrPrice[$key]['updated_by'] 		= $this->session->userdata['ORI_User']['username'];
				$ArrPrice[$key]['updated_date'] 	= date('Y-m-d h:i:s');
			}
			
			$config = array(
			  'upload_path' 		=> './assets/foto/',
			  'allowed_types' 		=> 'gif|jpg|png|jpeg|JPG|PNG',
			  'file_name' 			=> $kode_assets,
			  'file_ext_tolower' 	=> TRUE,
			  'overwrite' 			=> TRUE,
			  'max_size' 			=> 2000048,
			  'remove_spaces' 		=> TRUE
			);
			
			$tmp 		= explode(".", $_FILES['foto']['name']);
			$ext 		= end($tmp);
			$pic 		= $kode_assets.".".strtolower($ext);
			
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			if (!$this->upload->do_upload('foto')){
				$result = $this->upload->display_errors();
			}
			else{
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
				$detailData[$lopp]['code_group'] 	= $kode_group;
				$detailData[$lopp]['nm_asset'] 		= $data['nm_asset'];
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
				$detailData[$lopp]['id_dept'] 		= $data['lokasi_asset'];
				$detailData[$lopp]['department'] 	= get_name('department', 'nm_dept', 'id', $data['lokasi_asset']);
				$detailData[$lopp]['id_costcenter'] = $data['cost_center'];
				$detailData[$lopp]['cost_center'] 	= get_name('costcenter', 'nm_costcenter', 'id_costcenter', $data['cost_center']);
				$detailData[$lopp]['created_by'] 	= $this->session->userdata['ORI_User']['username'];
				$detailData[$lopp]['created_date'] 	= date('Y-m-d h:i:s');

				$jmlx   	= $data['depresiasi'] * 12;
				$date_now 	= date('Y-m-d');
				$date_now_real 	= date('Y-m-d');

				if(!empty($data['tanggal'])){
					$date_now 	= date('Y-m-d', strtotime($data['tanggal']));
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
					$detailDataDash[$lopp2]['nm_asset'] 	= $data['nm_asset'];
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

			$tanda = "Insert ";
			$tanda2 = $kode_assets;
			

			// print_r($ArrHeaderInstalasi);
			// print_r($ArrPrice);
			// echo $num_cty;
			// exit;

			$this->db->trans_start();
				$this->db->insert_batch('asset', $detailData);
				$this->db->insert_batch('asset_generate', $detailDataDash);

				$db2->insert('vehicle_tool_new', $ArrHeaderInstalasi);
				$db2->insert_batch('price_ref', $ArrPrice);
				if($num_cty < 1){
					$db2->insert('vehicle_tool_category', $ArrCategory);
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
			history($tanda."asset ".$tanda2);
			}

			echo json_encode($Arr_Data);
		}
		else{
			$id = $this->uri->segment(3);
			$header = $this->asset_model->getWhere('asset', 'id', $id);
			$data = array(
				'title'			=> 'Add Asset',
				'action'		=> 'add',
				'data' 			=> $header,
				'list_cab' 		=> $this->asset_model->getList('asset_branch'),
				'list_pajak'	=> $this->asset_model->getList('asset_category_pajak'),
				'list_dept' => $this->asset_model->getList('department'),
				'list_catg' => $this->asset_model->getList('asset_category')
				);
			$this->load->view('Ms_asset/add', $data);
		}
	}
	
	//move asset
	public function move_asset(){
		
		$Arr_Kembali	= array();
		$data			= $this->input->post();
		
		$branch				= $data['branch'];
		$kd_asset			= $data['kd_asset'];
		$lokasi_asset_new	= $data['lokasi_asset_new'];
		$cost_center_new	= $data['cost_center_new'];
		
		$ArrUpHeader = array(
			'kdcab' 	=> $branch,
			'id_dept' 	=> $lokasi_asset_new,
			'department' 	=> get_name('department', 'nm_dept', 'id', $lokasi_asset_new),
			'id_costcenter'	=> $cost_center_new,
			'cost_center' 	=> get_name('costcenter', 'nm_costcenter', 'id_costcenter', $cost_center_new),
			'modified_by' 	=> $this->session->userdata['ORI_User']['username'],
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
			history('Move asset to asset');
		}
		
		echo json_encode($Arr_Data);
	}
	
	//delete asset
	public function delete_asset(){
		
		$Arr_Kembali	= array();
		$data			= $this->input->post();

		$kd_asset		= $this->uri->segment(3);
		
		$ArrUpHeader = array(
			'deleted_by' 	=> $this->session->userdata['ORI_User']['username'],
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
			
			$this->db->where(array('kd_asset'=>$kd_asset,'flag'=>'X'));
			$this->db->update('asset_generate', $ArrUpGen);
		$this->db->trans_complete();
		
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$Arr_Data	= array(
				'pesan'		=>'Asset gagal dihapus ...',
				'status'	=> 0
			);			
		}
		else{
			$this->db->trans_commit();
			$Arr_Data	= array(
				'pesan'		=>'Asset berhasil dihapus. Thanks ...',
				'status'	=> 1
			);
			history('Delete asset '.$kd_asset);
		}
		
		echo json_encode($Arr_Data);
	}

	public function list_center(){
		$id = $this->uri->segment(3);
		$cs = $this->uri->segment(4);
		$query	 	= "SELECT * FROM costcenter WHERE id_dept='".$id."' ORDER BY nm_costcenter ASC";
		$Q_result	= $this->db->query($query)->result();
		$option 	= "<option value='0'>Select Costcenter</option>";
		foreach($Q_result as $row)	{
			$selx = ($row->id_costcenter == $cs)?'selected':'';
			$option .= "<option value='".$row->id_costcenter."' ".$selx.">".strtoupper($row->nm_costcenter)."</option>";
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

	//======================================================================================================================
    //===================================================CATEGORY============================================================
    //======================================================================================================================

	public function category(){
		$controller			= ucfirst(strtolower($this->uri->segment(1)));
		$Arr_Akses			= getAcccesmenu($controller);
		if($Arr_Akses['read'] !='1'){
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
			redirect(site_url('dashboard'));
		}

		$data_Group			= $this->master_model->getArray('groups',array(),'id','name');
		$data = array(
			'title'			=> 'Indeks Of Asset Category',
			'action'		=> 'category',
			'row_group'		=> $data_Group,
			'akses_menu'	=> $Arr_Akses
		);
		history('View Data Master Asset category');
		$this->load->view('Ms_asset/category',$data);
	}

	public function data_side_category(){
		$this->asset_model->get_json_category();
	}

	public function add_category(){ 
		if($this->input->post()){
			$Arr_Kembali	= array();
			$data			= $this->input->post();
			$data_session	= $this->session->userdata;
			$dateTime		= date('Y-m-d H:i:s');

			//header
			$id 		    = $data['id'];
			$nm_category	= strtoupper($data['nm_category']);
			$status			= $data['status'];

			if(empty($id)){
                $ArrHeader = array(
                    'nm_category'   => $nm_category,
                    'status' 		=> $status,
                    'created_by' 	=> $data_session['ORI_User']['username'],
                    'created_date' 	=> $dateTime
                );
                $TandaI = "Insert";
			}

			if(!empty($id)){
                $ArrHeader = array(
                    'nm_category'   => $nm_category,
                    'status' 		=> $status,
                    'updated_by' 	=> $data_session['ORI_User']['username'],
                    'updated_date' 	=> $dateTime
                );
                $TandaI = "Update";
            }

            // print_r($ArrHeader);
			// exit;
            
            $this->db->trans_start();
                if(empty($id)){
                    $this->db->insert('asset_category', $ArrHeader);
                }
                if(!empty($id)){
                    $this->db->where('id', $id);
                    $this->db->update('asset_category', $ArrHeader);
                }
            $this->db->trans_complete();


			if($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				$Arr_Kembali	= array(
					'pesan'		=> $TandaI.' data failed. Please try again later ...',
					'status'	=> 2
				);
			}
			else{
				$this->db->trans_commit();
				$Arr_Kembali	= array(
					'pesan'		=> $TandaI.' data success. Thanks ...',
					'status'	=> 1
				);
				history($TandaI.' Category Asset '.$id.' / '.$nm_category);
			}

			echo json_encode($Arr_Kembali);
		}
		else{
			$controller			= ucfirst(strtolower($this->uri->segment(1)));
			$Arr_Akses			= getAcccesmenu($controller);
			if($Arr_Akses['create'] !='1'){
				$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
				redirect(site_url('users'));
            }
            
            $id = $this->uri->segment(3);
            $query = "SELECT * FROM asset_category WHERE id ='".$id."' LIMIT 1 ";
            $result = $this->db->query($query)->result();

			$data = array(
				'title'		=> 'Add Category Asset',
                'action'	=> 'add',
                'data'      => $result
			);
			$this->load->view('Ms_asset/add_category',$data);
		}
	}

	public function hapus_category(){
		$id = $this->uri->segment(3);
		$data_session	= $this->session->userdata;

		$ArrPlant		= array(
			'deleted' 		=> 'Y',
			'deleted_by' 	=> $data_session['ORI_User']['username'],
			'deleted_date' 	=> date('Y-m-d H:i:s')
			);


		$this->db->trans_start();
            $this->db->where('id', $id);
            $this->db->update('asset_category', $ArrPlant);
		$this->db->trans_complete();

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$Arr_Data	= array(
				'pesan'		=>'Delete data failed. Please try again later ...',
				'status'	=> 0
			);
		}
		else{
			$this->db->trans_commit();
			$Arr_Data	= array(
				'pesan'		=>'Delete data success. Thanks ...',
				'status'	=> 1
			);
			history('Delete Category Asset Data : '.$id);
		}
		echo json_encode($Arr_Data);
	}


}
?>
