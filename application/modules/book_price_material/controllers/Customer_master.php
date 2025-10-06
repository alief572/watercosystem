<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_Master extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('master_model');
		$this->folder		= 'Master_Customer';
		// Your own constructor code
		if(!$this->session->userdata('isORIlogin')){
			redirect('login');
		}		
	}

	public function index(){
		$controller			= ucfirst(strtolower($this->uri->segment(1)));
		$Arr_Akses			= getAcccesmenu($controller);
		if($Arr_Akses['read'] !='1'){
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
			redirect(site_url('dashboard'));
		}
		
		$data_Branch		= $this->master_model->getArray('branch',array(),'nocab','cabang');
		$data_Marketing		= $this->master_model->getArray('employee',array(),'id','nm_karyawan');
		$data = array(
			'title'			=> 'Indeks Of Customer',
			'action'		=> 'index',
			'row_branch'	=> $data_Branch,
			'row_sales'		=> $data_Marketing,
			'akses_menu'	=> $Arr_Akses
		);
		history('View Data Customer');
		$this->load->view($this->folder.'/index',$data);
	}
	
	public function modalUpload(){
		$this->load->view('Master_Customer/modalUpload');
	}
	
	function display_data(){
		$det_Akses		= akses_server_side();
		$data_session	= $this->session->userdata;
		$WHERE			= "deleted<>1";
		if($data_session['ORI_User']['group_id'] !='1'){
			if(!empty($WHERE))$WHERE	.=" AND ";
			$WHERE	.= "kdcab ='".$data_session['ORI_User']['kdcab']."'";
			
		}
		// $WHERE	.= " AND id_customer != 'C100-1903000'";
		
		$table = 'customer';
			$primaryKey = 'id_customer';
			$columns = array(
				array( 'db' => 'id_customer', 'dt' => 'id_customer'),
				 array(
					'db' => 'id_customer',
					'dt' => 'DT_RowId'
				),
				array( 'db' => 'nm_customer', 'dt' => 'nm_customer'),
				array( 'db' => 'kdcab', 'dt' => 'kdcab'),
				array( 'db' => 'bidang_usaha', 'dt' => 'bidang_usaha'),
				array( 'db' => 'kredibilitas', 'dt' => 'kredibilitas'),
				array( 'db' => 'alamat', 'dt' => 'alamat'),
				array( 'db' => 'referensi', 'dt' => 'referensi'),
				array( 'db' => 'id_marketing', 'dt' => 'id_marketing'),
				array( 'db' => 'sts_aktif', 'dt' => 'sts_aktif'),
				array( 
					'db' => 'id_customer', 
					'dt'=> 'action',
					'formatter' => function($d,$row){
						return '';
					}
				),
				array( 
					'db' => 'sts_aktif', 
					'dt'=> 'status',
					'formatter' => function($d,$row){
						return '';
					}
				)
			);
			$sql_details = array(
				'user' => $det_Akses['hostuser'],
				'pass' => $det_Akses['hostpass'],
				'db'   => $det_Akses['hostdb'],
				'host' => $det_Akses['hostname']
			);
			require( 'ssp.class.php' );
			
			
			echo json_encode(
				SSP::complex ($_GET, $sql_details, $table, $primaryKey, $columns,null, $WHERE)
			);
			//echo "<pre>";print_r($data);exit;
			
			
		
	}
	
	public function edit_user($id='') {
		if($this->input->post()){
			$Arr_Kembali			= array();
			$data					= $this->input->post();
			$data_session			= $this->session->userdata;
			
			$id_customer	= $data['id_customer'];
			// echo $id_customer; exit;
			//Check PIC
			$qCheckPIC		= "SELECT * FROM customer_pic WHERE email_pic = '".trim(strtolower($data['email_pic']))."' ";
			$NumCheckPIC	= $this->db->query($qCheckPIC)->num_rows();
			$dataPIC		= $this->db->query($qCheckPIC)->result_array();
			
			
			// echo $NumCheckPIC."<br>";
			
			$Ymonth		= date('ym');
			
			//Urutan PIC
			$qPIC 			= "SELECT MAX(id_pic) AS maxPC FROM customer_pic WHERE id_pic LIKE 'PIC-".$Ymonth."%' ";
			$numRowPIC		= $this->db->query($qPIC)->num_rows();
			$resultPIC		= $this->db->query($qPIC)->result_array();
			$angkaUrut2x	= $resultPIC[0]['maxPC'];
			$urutan2x		= (int)substr($angkaUrut2x, 8, 3);
			$urutan2x++;
			$urut2x			= sprintf('%03s',$urutan2x);
			$kodePIC		= "PIC-".$Ymonth.$urut2x;
			
			if($NumCheckPIC > 0){
				$kodePIC		= $dataPIC[0]['id_pic'];
			}
			
			$ArrCust = array(
				'kdcab' 			=> $data['kdcab'],
				'bidang_usaha' 		=> $data['bidang_usaha'],
				'produk_jual' 		=> ucwords(strtolower($data['produk_jual'])),
				'kredibilitas' 		=> $data['kredibilitas'],
				'alamat' 			=> ucwords(strtolower($data['alamat'])),
				'provinsi' 			=> $data['provinsi'],
				'kota' 				=> $data['kota'],
				'kode_pos' 			=> $data['kode_pos'],
				'telpon' 			=> str_replace('-', '', $data['telpon']),
				'fax' 				=> str_replace('-', '', $data['fax']),
				'npwp' 				=> $data['npwp'],
				'ktp' 				=> "",
				'alamat_ktp' 		=> "",
				'id_marketing' 		=> $data['id_marketing'],
				'id_pic' 			=> $kodePIC,
				'website' 			=> $data['website'],
				'foto' 				=> "",
				'diskon_toko' 		=> $data['diskon_toko'],
				'modified_on' 		=> $data_session['ORI_User']['username'],
				'modified_by' 		=> date('Y-m-d H:i:s')
			);
			
			$qBidU	= $this->db->query("SELECT*FROM bidang_usaha WHERE id_bidang_usaha='".$data['bidang_usaha']."' ")->result_array();
			
			$ArrBidUsaha = array(
				'bidang_usaha' 		=> $data['bidang_usaha'],
				'keterangan' 		=> $qBidU[0]['bidang_usaha'],
				'modified_on' 		=> date('Y-m-d H:i:s'),
				'modified_by' 		=> $data_session['ORI_User']['username']
			);
			
			if($NumCheckPIC < 1){
				$ArrPIC	= array(
					'id_pic' 			=> $kodePIC,
					'nm_pic' 			=> ucwords(strtolower($data['nm_pic'])),
					'divisi' 			=> strtoupper($data['divisi']),
					'jabatan' 			=> "",
					'hp' 				=> str_replace('-', '', $data['hp']),
					'email_pic' 		=> trim(strtolower($data['email_pic'])),
					'created_on' 		=> date('Y-m-d H:i:s'),
					'created_by' 		=> $data_session['ORI_User']['username']
				);
				// print_r($ArrPIC);
			}
			
			// print_r($ArrCust);
			// print_r($ArrBidUsaha);
			
			// echo "<pre>";
			// exit;
			
			$this->db->trans_start();
			$this->db->update('customer', $ArrCust, array('id_customer' => $id_customer));
			$this->db->update('customer_bidang_usaha', $ArrBidUsaha, array('id_customer' => $id_customer));
			if($NumCheckPIC < 1){
				$this->db->insert('customer_pic', $ArrPIC);
			}
			$this->db->trans_complete();
			
			if($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				$Arr_Kembali	= array(
					'pesan'		=>'Update Customer failed. Please try again later ...',
					'status'	=> 2
				);
			}
			else{
				$this->db->trans_commit();
				$Arr_Kembali	= array(
					'pesan'		=>'Update Customer Success. Thank you & have a nice day ...',
					'status'	=> 1
				);
				history('Update Customer '.$id_customer);
			}
			
			echo json_encode($Arr_Kembali);
		}
		else{		
			$controller			= ucfirst(strtolower($this->uri->segment(1)));
			$Arr_Akses			= getAcccesmenu($controller);
			if($Arr_Akses['update'] !='1'){
				$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
				redirect(site_url('users'));
			}
			
			$data_session		= $this->session->userdata;
			$WHERE				= array();
			if($data_session['ORI_User']['group_id'] !='1'){
				$WHERE			= array(
					'nocab'			=> $data_session['ORI_User']['kdcab']
				);
			}
			
			$id_Cust = $this->uri->segment(3);
			
			$dataCust			= $this->db->query("SELECT*FROM customer WHERE id_customer='".$id_Cust."' ")->result_array();
			$dataCustRef		= $this->db->query("SELECT*FROM customer_referensi WHERE id_customer='".$id_Cust."' ")->result_array();
			$dataCustPIC		= $this->db->query("SELECT*FROM customer a INNER JOIN customer_pic b ON a.id_pic=b.id_pic WHERE a.id_customer='".$id_Cust."' ")->result_array();
			$data_Group			= $this->master_model->getArray('groups',array(),'id','name');
			$det_Province		= $this->db->query("SELECT * FROM provinsi WHERE country_code = 'IDN' ORDER BY id_prov ASC")->result_array();
			$det_Kab			= $this->db->query("SELECT * FROM kabupaten WHERE id_prov = '".$dataCust[0]['provinsi']."' ORDER BY id_prov ASC")->result_array();
			$det_Branch			= $this->master_model->getArray('branch',$WHERE,'nocab','cabang');
			$det_Bidang			= $this->db->query("SELECT*FROM bidang_usaha WHERE deleted = 'N' ORDER BY bidang_usaha ASC")->result_array();
			$data = array(
				'title'			=> 'Edit Customer',
				'action'		=> 'edit_user',
				'rows_province'	=> $det_Province,
				'rows_kab'		=> $det_Kab,
				'rows_branch'	=> $det_Branch,
				'rows_bidang'	=> $det_Bidang,
				'data_group'	=> $data_Group,
				'row'			=> $dataCust,
				'rowR'			=> $dataCustRef,
				'rowP'			=> $dataCustPIC
			);
			$this->load->view('Master_Customer/edit',$data);
		}
	}
	
	function view(){
		$controller			= ucfirst(strtolower($this->uri->segment(1)));
		$Arr_Akses			= getAcccesmenu($controller);
		if($Arr_Akses['update'] !='1'){
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
			redirect(site_url('users'));
		}
		
		$data_session		= $this->session->userdata;
		$WHERE				= array();
		if($data_session['ORI_User']['group_id'] !='1'){
			$WHERE			= array(
				'nocab'			=> $data_session['ORI_User']['kdcab']
			);
		}
		
		$id_Cust = $this->uri->segment(3);
		
		$dataCust			= $this->db->query("SELECT*FROM customer WHERE id_customer='".$id_Cust."' ")->result_array();
		$dataCustRef		= $this->db->query("SELECT*FROM customer_referensi WHERE id_customer='".$id_Cust."' ")->result_array();
		$dataCustPIC		= $this->db->query("SELECT*FROM customer a INNER JOIN customer_pic b ON a.id_pic=b.id_pic WHERE a.id_customer='".$id_Cust."' ")->result_array();
		$data_Group			= $this->master_model->getArray('groups',array(),'id','name');
		$det_Province		= $this->db->query("SELECT * FROM provinsi WHERE country_code = 'IDN' ORDER BY id_prov ASC")->result_array();
		$det_Kab			= $this->db->query("SELECT * FROM kabupaten WHERE id_prov = '".$dataCust[0]['provinsi']."' ORDER BY id_prov ASC")->result_array();
		$det_Branch			= $this->master_model->getArray('branch',$WHERE,'nocab','cabang');
		$det_Bidang			= $this->db->query("SELECT*FROM bidang_usaha WHERE deleted = 'N' ORDER BY bidang_usaha ASC")->result_array();
		$data = array(
			'title'			=> 'Detail Customer',
			'action'		=> 'view/'.$id_Cust,
			'rows_province'	=> $det_Province,
			'rows_kab'		=> $det_Kab,
			'rows_branch'	=> $det_Branch,
			'rows_bidang'	=> $det_Bidang,
			'data_group'	=> $data_Group,
			'row'			=> $dataCust,
			'rowR'			=> $dataCustRef,
			'rowP'			=> $dataCustPIC
		);
		$this->load->view('Master_Customer/view',$data);
	}
	
	function hapus(){
		$id_customer = $this->uri->segment(3);
		$data_session			= $this->session->userdata;
		// echo $id_customer; exit;
		$data = array(
				'deleted' => 'Y',
				'deleted_by' => $data_session['ORI_User']['username'],
				'deleted_date' => date('Y-m-d H:i:s')
		);
		
		$this->db->trans_start();
		$this->db->update('customer', $data, array('id_customer' => $id_customer));
		$this->db->update('customer_bidang_usaha', $data, array('id_customer' => $id_customer));
		$this->db->update('customer_pic', $data, array('id_customer' => $id_customer));
		$this->db->update('customer_referensi', $data, array('id_customer' => $id_customer));
		$this->db->trans_complete();
		
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$Arr_Data	= array(
				'pesan'		=>'Delete customer data failed. Please try again later ...',
				'status'	=> 0
			);			
		}
		else{
			$this->db->trans_commit();
			$Arr_Data	= array(
				'pesan'		=>'Delete customer data success. Thanks ...',
				'status'	=> 1
			);				
			history('Delete customer with Id : '.$id_customer);
		}
		echo json_encode($Arr_Data);
	}
	
	function get_detail_data($kategori='',$kode=''){
		if($kategori=='marketing'){
			$Table		= 'employee';
			$Key		= 'id';
			$Value		= 'nm_karyawan';
			$WHERE		= array(
				'sts_aktif'		=> 'aktif',
				'kdcab'			=> $kode
			);
		}
		
		$det_detail			= $this->master_model->getArray($Table,$WHERE,$Key,$Value);
		
		echo json_encode($det_detail);
		
	}
	
	public function add() {
		if($this->input->post()){
			$Arr_Kembali			= array();
			$data					= $this->input->post();
			$data_session			= $this->session->userdata;
			
			//Check Customer
			$qCheckName		= "SELECT * FROM customer WHERE nm_customer = '".trim(strtoupper($data['nm_customer']))."' ";
			$NumCheckName	= $this->db->query($qCheckName)->num_rows();
			// echo $NumCheckName;
			
			//Check PIC
			$qCheckPIC		= "SELECT * FROM customer_pic WHERE email_pic = '".trim(strtolower($data['email_pic']))."' ";
			$NumCheckPIC	= $this->db->query($qCheckPIC)->num_rows();
			$dataPIC		= $this->db->query($qCheckPIC)->result_array();
			
			
			// echo $NumCheckPIC."<br>";
			
			$Ymonth		= date('ym');
			
			//Urutan Customer
			$qCust 			= "SELECT MAX(id_customer) AS maxP FROM customer WHERE kdcab='100' AND id_customer LIKE 'C100-".$Ymonth."%' ";
			$numRowCust		= $this->db->query($qCust)->num_rows();
			$resultPlant	= $this->db->query($qCust)->result_array();
			$angkaUrut2		= $resultPlant[0]['maxP'];
			$urutan2		= (int)substr($angkaUrut2, 9, 3);
			$urutan2++;
			$urut2			= sprintf('%03s',$urutan2);
			$kodeCust		= "C100-".$Ymonth.$urut2;
			
			//Urutan PIC
			$qPIC 			= "SELECT MAX(id_pic) AS maxPC FROM customer_pic WHERE id_pic LIKE 'PIC-".$Ymonth."%' ";
			$numRowPIC		= $this->db->query($qPIC)->num_rows();
			$resultPIC		= $this->db->query($qPIC)->result_array();
			$angkaUrut2x	= $resultPIC[0]['maxPC'];
			$urutan2x		= (int)substr($angkaUrut2x, 8, 3);
			$urutan2x++;
			$urut2x			= sprintf('%03s',$urutan2x);
			$kodePIC		= "PIC-".$Ymonth.$urut2x;
			
			if($NumCheckPIC > 0){
				$kodePIC		= $dataPIC[0]['id_pic'];
			}
			
			$ArrCust = array(
				'id_customer'		=> $kodeCust,
				'nm_customer' 		=> trim(strtoupper($data['nm_customer'])),
				'kdcab' 			=> '100',
				'bidang_usaha' 		=> $data['bidang_usaha'],
				'produk_jual' 		=> ucwords(strtolower($data['produk_jual'])),
				'kredibilitas' 		=> $data['kredibilitas'],
				'alamat' 			=> ucwords(strtolower($data['alamat'])),
				'country_code' 		=> $data['country_code'],
				'provinsi' 			=> $data['provinsi'],
				'kota' 				=> $data['kota'],
				'kode_pos' 			=> $data['kode_pos'],
				'telpon' 			=> str_replace('-', '', $data['telpon']),
				'fax' 				=> str_replace('-', '', $data['fax']),
				'npwp' 				=> $data['npwp'],
				'ktp' 				=> "",
				'alamat_ktp' 		=> "",
				'id_marketing' 		=> $data['id_marketing'],
				'id_pic' 			=> $kodePIC,
				'referensi' 		=> ucwords(strtolower($data['reference_by'])),
				'website' 			=> $data['website'],
				'foto' 				=> "",
				'diskon_toko' 		=> $data['diskon_toko'],
				'created_on' 		=> date('Y-m-d H:i:s'),
				'created_by' 		=> $data_session['ORI_User']['username']
			);
			
			$qBidU	= $this->db->query("SELECT*FROM bidang_usaha WHERE id_bidang_usaha='".$data['bidang_usaha']."' ")->result_array();
			
			$ArrBidUsaha = array(
				'id_customer' 		=> $kodeCust,
				'bidang_usaha' 		=> $data['bidang_usaha'],
				'keterangan' 		=> $qBidU[0]['bidang_usaha'],
				'created_on' 		=> date('Y-m-d H:i:s'),
				'created_by' 		=> $data_session['ORI_User']['username']
			);
			
			$ArrReferensi = array(
				'id_customer' 		=> $kodeCust,
				'reference_by' 		=> $data['reference_by'],
				'reference_name' 	=> ucwords(strtolower($data['reference_name'])),
				'reference_phone' 	=> str_replace('-', '', $data['reference_phone']),
				'created_on' 		=> date('Y-m-d H:i:s'),
				'created_by' 		=> $data_session['ORI_User']['username']
			);
			
			if($NumCheckPIC < 1){
				$ArrPIC	= array(
					'id_pic' 			=> $kodePIC,
					'nm_pic' 			=> ucwords(strtolower($data['nm_pic'])),
					'divisi' 			=> strtoupper($data['divisi']),
					'jabatan' 			=> "",
					'hp' 				=> str_replace('-', '', $data['hp']),
					'email_pic' 		=> trim(strtolower($data['email_pic'])),
					'created_on' 		=> date('Y-m-d H:i:s'),
					'created_by' 		=> $data_session['ORI_User']['username']
				);
				// print_r($ArrPIC);
			}
			
			// print_r($ArrCust);
			// print_r($ArrBidUsaha);
			// print_r($ArrReferensi);
			
			// echo "<pre>";
			// exit;
			
			if($NumCheckName > 0){
				$Arr_Kembali		= array(
					'status'		=> 3,
					'pesan'			=> 'Customer Name Already Exists. Please input different customer name ...'
				);
			}
			else{
				$this->db->trans_start();
				$this->db->insert('customer', $ArrCust);
				$this->db->insert('customer_bidang_usaha', $ArrBidUsaha);
				if($NumCheckPIC < 1){
					$this->db->insert('customer_pic', $ArrPIC);
				}
				$this->db->insert('customer_referensi', $ArrReferensi);
				$this->db->trans_complete();
				
				if($this->db->trans_status() === FALSE){
					$this->db->trans_rollback();
					$Arr_Kembali	= array(
						'pesan'		=>'Add Customer failed. Please try again later ...',
						'status'	=> 2
					);
				}
				else{
					$this->db->trans_commit();
					$Arr_Kembali	= array(
						'pesan'		=>'Add Customer Success. Thank you & have a nice day ...',
						'status'	=> 1
					);
					history('Add Customer '.$kodeCust);
				}
			}
			echo json_encode($Arr_Kembali);
		}
		else{		
			$controller			= ucfirst(strtolower($this->uri->segment(1)));
			$Arr_Akses			= getAcccesmenu($controller);
			if($Arr_Akses['create'] !='1'){
				$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
				redirect(site_url('customer_master'));
			}
			$data_session		= $this->session->userdata;
			$WHERE				= array();
			if($data_session['ORI_User']['group_id'] !='1'){
				$WHERE			= array(
					'nocab'			=> $data_session['ORI_User']['kdcab']
				);
			}
			$data_Group			= $this->master_model->getArray('groups',array(),'id','name');
			$det_Province		= $this->db->query("SELECT * FROM provinsi WHERE country_code = 'IDN' ORDER BY id_prov ASC")->result_array();
			$det_Branch			= $this->master_model->getArray('branch',$WHERE,'nocab','cabang');
			$det_Bidang			= $this->db->query("SELECT*FROM bidang_usaha WHERE deleted = 'N' ORDER BY bidang_usaha ASC")->result_array();
			//country
			$qCountry	= "SELECT * FROM country ORDER BY country_name ASC";
			$restContry	= $this->db->query($qCountry)->result_array();
			//country
			$qMkt	= "SELECT nik, nm_karyawan FROM employee WHERE department='12' ORDER BY nm_karyawan ASC";
			$restMkt	= $this->db->query($qMkt)->result_array(); 

			$data = array(
				'title'			=> 'Add Customer',
				'action'		=> 'add',
				'rows_province'	=> $det_Province,
				'rows_marketing'	=> $restMkt,
				'CountryName'	=> $restContry,
				'rows_branch'	=> $det_Branch,
				'rows_bidang'	=> $det_Bidang,
				'data_group'	=> $data_Group
			);
			$this->load->view($this->folder.'/add2',$data);
		}
	}
	
	public function getDistrict(){
		$id_Dist 	= $this->input->post('id_prov');
		$sqlDist	= "SELECT * FROM kabupaten WHERE id_prov='".$id_Dist."' ORDER BY nama ASC";
		$restDist	= $this->db->query($sqlDist)->result_array();
		$NumDist	= $this->db->query($sqlDist)->num_rows();
		
		$option	= "<option value='0'>Select An District</option>";
		foreach($restDist AS $val => $valx){
			$option .= "<option value='".$valx['id_kab']."'>".$valx['nama']."</option>";
		}
		if($NumDist == 0){
			$option .= "<option value=''>Data is empty, skip this input</option>";
		}

		$ArrJson	= array(
			'option' => $option
		);
		echo json_encode($ArrJson);
	}
	
	public function temp_format(){
        //membuat objek PHPExcel
        set_time_limit(0);
        ini_set('memory_limit','1024M');
        // $kode_Budget    ='';
        // if($this->input->post()){
            // $kode_Budget    = $this->input->post('kode_budget');
        // }
        $this->load->library("PHPExcel");
        //$this->load->library("PHPExcel/Writer/Excel2007");
        $objPHPExcel    = new PHPExcel();
         
        $style_header = array(
            'borders' => array(
                'allborders' => array(
                      'style' => PHPExcel_Style_Border::BORDER_THIN,
                      'color' => array('rgb'=>'1006A3')
                  )
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb'=>'E1E0F7'),
            ),
            'font' => array(
                'bold' => true,
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            )
        );
 
        $style_header2 = array( 
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb'=>'E1E0F7'),
            ),
            'font' => array(
                'bold' => true,
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            )
        );
 
        $styleArray = array(                      
              'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
              )
          );
        $styleArray3 = array(                     
              'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
              )
          );  
        $styleArray1 = array(
              'borders' => array(
                  'allborders' => array(
                      'style' => PHPExcel_Style_Border::BORDER_THIN
                  )
              ),
              'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
              )
          );
        $styleArray2 = array(
              'borders' => array(
                  'allborders' => array(
                      'style' => PHPExcel_Style_Border::BORDER_THIN
                  )
              ),
              'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
              )
          );
          
        $Arr_Bulan  = array(1=>'Jan','Feb','Mar','Apr','Mei','Jun','Jul','Aug','Sep','Oct','Nov','Dec'); 
        $sheet      = $objPHPExcel->getActiveSheet();
		
        $dateX	= date('Y-m-d H:i:s');
        $Row        = 1;
        $NewRow     = $Row+1;
        $Col_Akhir  = $Cols = getColsChar(26);
        $sheet->setCellValue('A'.$Row, "DAFTAR DATA CUSTOMER (Waktu Download : ".date('d F Y H:i:s', strtotime($dateX)).")");
        $sheet->getStyle('A'.$Row.':'.$Col_Akhir.$NewRow)->applyFromArray($style_header2);
        $sheet->mergeCells('A'.$Row.':'.$Col_Akhir.$NewRow);
         
        $NewRow = $NewRow +2;
        $NextRow= $NewRow +1;
        
		$sheet ->getColumnDimension("A")->setAutoSize(true);
        $sheet->setCellValue('A'.$NewRow, 'No');
        $sheet->getStyle('A'.$NewRow.':A'.$NextRow)->applyFromArray($style_header);
        $sheet->mergeCells('A'.$NewRow.':A'.$NextRow);
        
		$sheet ->getColumnDimension("B")->setAutoSize(true);
        $sheet->setCellValue('B'.$NewRow, 'Customer Name');
        $sheet->getStyle('B'.$NewRow.':B'.$NextRow)->applyFromArray($style_header);
        $sheet->mergeCells('B'.$NewRow.':B'.$NextRow);
		
		$sheet ->getColumnDimension("C")->setAutoSize(true);
		$sheet->setCellValue('C'.$NewRow, 'Business Fields');
        $sheet->getStyle('C'.$NewRow.':C'.$NextRow)->applyFromArray($style_header);
        $sheet->mergeCells('C'.$NewRow.':C'.$NextRow);
        
		$sheet ->getColumnDimension("D")->setAutoSize(true);
        $sheet->setCellValue('D'.$NewRow, 'Branch Code');
        $sheet->getStyle('D'.$NewRow.':D'.$NextRow)->applyFromArray($style_header);
        $sheet->mergeCells('D'.$NewRow.':D'.$NextRow);
        
		$sheet ->getColumnDimension("E")->setAutoSize(true);
        $sheet->setCellValue('E'.$NewRow, 'credibility');
        $sheet->getStyle('E'.$NewRow.':E'.$NextRow)->applyFromArray($style_header);
        $sheet->mergeCells('E'.$NewRow.':E'.$NextRow);
		
		$sheet ->getColumnDimension("F")->setAutoSize(true);
		$sheet->setCellValue('F'.$NewRow, 'Address');
        $sheet->getStyle('F'.$NewRow.':F'.$NextRow)->applyFromArray($style_header);
        $sheet->mergeCells('F'.$NewRow.':F'.$NextRow);
		
		$sheet ->getColumnDimension("G")->setAutoSize(true);
		$sheet->setCellValue('G'.$NewRow, 'Telephone 1');
        $sheet->getStyle('G'.$NewRow.':G'.$NextRow)->applyFromArray($style_header);
        $sheet->mergeCells('G'.$NewRow.':G'.$NextRow);
		
		$sheet ->getColumnDimension("H")->setAutoSize(true);
		$sheet->setCellValue('H'.$NewRow, 'Telephone 2');
        $sheet->getStyle('H'.$NewRow.':H'.$NextRow)->applyFromArray($style_header);
        $sheet->mergeCells('H'.$NewRow.':H'.$NextRow);
		
		$sheet ->getColumnDimension("I")->setAutoSize(true);
		$sheet->setCellValue('I'.$NewRow, 'Telephone 3');
        $sheet->getStyle('I'.$NewRow.':I'.$NextRow)->applyFromArray($style_header);
        $sheet->mergeCells('I'.$NewRow.':I'.$NextRow);
		
		$sheet ->getColumnDimension("J")->setAutoSize(true);
		$sheet->setCellValue('J'.$NewRow, 'Fax');
        $sheet->getStyle('J'.$NewRow.':J'.$NextRow)->applyFromArray($style_header);
        $sheet->mergeCells('J'.$NewRow.':J'.$NextRow);
		
		$sheet ->getColumnDimension("K")->setAutoSize(true);
		$sheet->setCellValue('K'.$NewRow, 'Email 1');
        $sheet->getStyle('K'.$NewRow.':K'.$NextRow)->applyFromArray($style_header);
        $sheet->mergeCells('K'.$NewRow.':K'.$NextRow);
		
		$sheet ->getColumnDimension("L")->setAutoSize(true);
		$sheet->setCellValue('L'.$NewRow, 'Email 2');
        $sheet->getStyle('L'.$NewRow.':L'.$NextRow)->applyFromArray($style_header);
        $sheet->mergeCells('L'.$NewRow.':L'.$NextRow);
		
		$sheet ->getColumnDimension("M")->setAutoSize(true);
		$sheet->setCellValue('M'.$NewRow, 'Email 3');
        $sheet->getStyle('M'.$NewRow.':M'.$NextRow)->applyFromArray($style_header);
        $sheet->mergeCells('M'.$NewRow.':M'.$NextRow);
		
		$sheet ->getColumnDimension("N")->setAutoSize(true);
		$sheet->setCellValue('N'.$NewRow, 'TAX ID');
        $sheet->getStyle('N'.$NewRow.':N'.$NextRow)->applyFromArray($style_header);
        $sheet->mergeCells('N'.$NewRow.':N'.$NextRow);
		
		$sheet ->getColumnDimension("O")->setAutoSize(true);
		$sheet->setCellValue('O'.$NewRow, 'TAX Address');
        $sheet->getStyle('O'.$NewRow.':O'.$NextRow)->applyFromArray($style_header);
        $sheet->mergeCells('O'.$NewRow.':O'.$NextRow);
		
		$sheet ->getColumnDimension("P")->setAutoSize(true);
		$sheet->setCellValue('P'.$NewRow, 'Website');
        $sheet->getStyle('P'.$NewRow.':P'.$NextRow)->applyFromArray($style_header);
        $sheet->mergeCells('P'.$NewRow.':P'.$NextRow);
		
		$sheet ->getColumnDimension("Q")->setAutoSize(true);
		$sheet->setCellValue('Q'.$NewRow, 'Selling Product');
        $sheet->getStyle('Q'.$NewRow.':Q'.$NextRow)->applyFromArray($style_header);
        $sheet->mergeCells('Q'.$NewRow.':Q'.$NextRow);
		
		$sheet ->getColumnDimension("R")->setAutoSize(true);
		$sheet->setCellValue('R'.$NewRow, 'PIC Name');
        $sheet->getStyle('R'.$NewRow.':R'.$NextRow)->applyFromArray($style_header);
        $sheet->mergeCells('R'.$NewRow.':R'.$NextRow);
        
		$sheet ->getColumnDimension("S")->setAutoSize(true);
		$sheet->setCellValue('S'.$NewRow, 'Division');
        $sheet->getStyle('S'.$NewRow.':S'.$NextRow)->applyFromArray($style_header);
        $sheet->mergeCells('S'.$NewRow.':S'.$NextRow);
		
		$sheet ->getColumnDimension("T")->setAutoSize(true);
		$sheet->setCellValue('T'.$NewRow, 'Position');
        $sheet->getStyle('T'.$NewRow.':T'.$NextRow)->applyFromArray($style_header);
        $sheet->mergeCells('T'.$NewRow.':T'.$NextRow);
		
		$sheet ->getColumnDimension("U")->setAutoSize(true);
		$sheet->setCellValue('U'.$NewRow, 'Contact PIC');
        $sheet->getStyle('U'.$NewRow.':U'.$NextRow)->applyFromArray($style_header);
        $sheet->mergeCells('U'.$NewRow.':U'.$NextRow);
		
		$sheet ->getColumnDimension("V")->setAutoSize(true);
		$sheet->setCellValue('V'.$NewRow, 'Email PIC');
        $sheet->getStyle('V'.$NewRow.':V'.$NextRow)->applyFromArray($style_header);
        $sheet->mergeCells('V'.$NewRow.':V'.$NextRow);
		
		$sheet ->getColumnDimension("W")->setAutoSize(true);
		$sheet->setCellValue('W'.$NewRow, 'Reference By');
        $sheet->getStyle('W'.$NewRow.':W'.$NextRow)->applyFromArray($style_header);
        $sheet->mergeCells('W'.$NewRow.':W'.$NextRow);
		
		$sheet ->getColumnDimension("X")->setAutoSize(true);
		$sheet->setCellValue('X'.$NewRow, 'Reference Name');
        $sheet->getStyle('X'.$NewRow.':X'.$NextRow)->applyFromArray($style_header);
        $sheet->mergeCells('X'.$NewRow.':X'.$NextRow);
		
		$sheet ->getColumnDimension("Y")->setAutoSize(true);
		$sheet->setCellValue('Y'.$NewRow, 'Reference Contact');
        $sheet->getStyle('Y'.$NewRow.':Y'.$NextRow)->applyFromArray($style_header);
        $sheet->mergeCells('Y'.$NewRow.':Y'.$NextRow);
		
		$sheet ->getColumnDimension("Z")->setAutoSize(true);
		$sheet->setCellValue('Z'.$NewRow, 'Customer Discount(%)');
        $sheet->getStyle('Z'.$NewRow.':Z'.$NextRow)->applyFromArray($style_header);
        $sheet->mergeCells('Z'.$NewRow.':Z'.$NextRow);
		
		$qSupplier   	= "	SELECT
								a.nm_customer,
								b.bidang_usaha,
								a.kdcab,
								a.kredibilitas,
								a.alamat,
								a.telpon,
								a.telpon2,
								a.telpon3,
								a.fax,
								a.email,
								a.email2,
								a.email3,
								a.npwp,
								a.alamat_npwp,
								a.website,
								a.produk_jual,
								a.diskon_toko,
								c.nm_pic,
								c.divisi,
								c.jabatan,
								c.hp,
								c.email_pic,
								d.reference_by,
								d.reference_name,
								d.reference_phone 
							FROM
								customer a
								LEFT JOIN bidang_usaha b ON a.bidang_usaha = b.id_bidang_usaha
								LEFT JOIN customer_pic c ON a.id_pic = c.id_pic
								LEFT JOIN customer_referensi d ON a.id_customer = d.id_customer 
							WHERE
								a.id_customer <> 'C100-1903000'
							";
		// echo $qSupplier;
		// exit;
		$restSupplier   = $this->db->query($qSupplier);
		 
		$Num_Cek    = $restSupplier->num_rows();
		if($Num_Cek > 0){
			$data_Det   = $restSupplier->result_array();
		}
		 
		if($data_Det){
			$awal_row   = $NextRow;
			 $no = 0;
			foreach($data_Det as $key=>$vals){
				$no++;
				$awal_row++;
				$awal_col   = 0;
				 
				$awal_col++;
				$no   = $no;
				$Cols       = getColsChar($awal_col);
				$sheet->setCellValue($Cols.$awal_row, $no);
				$sheet->getStyle($Cols.$awal_row)->applyFromArray($styleArray2);
				
				$awal_col++;
				$nm_customer   = strtoupper((isset($row_Cek[0]['nm_customer']) && $row_Cek[0]['nm_customer'])?$row_Cek[0]['nm_customer']:$vals['nm_customer']);
				$Cols       = getColsChar($awal_col);
				$sheet->setCellValue($Cols.$awal_row, $nm_customer);
				$sheet->getStyle($Cols.$awal_row)->applyFromArray($styleArray2);
				
				$awal_col++;
				$bidang_usaha   = strtoupper((isset($row_Cek[0]['bidang_usaha']) && $row_Cek[0]['bidang_usaha'])?$row_Cek[0]['bidang_usaha']:$vals['bidang_usaha']);
				$Cols       = getColsChar($awal_col);
				$sheet->setCellValue($Cols.$awal_row, $bidang_usaha);
				$sheet->getStyle($Cols.$awal_row)->applyFromArray($styleArray2);
				
				$awal_col++;
				$kdcab   = (isset($row_Cek[0]['kdcab']) && $row_Cek[0]['kdcab'])?$row_Cek[0]['kdcab']:$vals['kdcab'];
				$Cols       = getColsChar($awal_col);
				$sheet->setCellValue($Cols.$awal_row, $kdcab);
				$sheet->getStyle($Cols.$awal_row)->applyFromArray($styleArray2);
				
				$awal_col++;
				$kredibilitas   = strtoupper((isset($row_Cek[0]['kredibilitas']) && $row_Cek[0]['kredibilitas'])?$row_Cek[0]['kredibilitas']:$vals['kredibilitas']);
				$Cols       = getColsChar($awal_col);
				$sheet->setCellValue($Cols.$awal_row, $kredibilitas);
				$sheet->getStyle($Cols.$awal_row)->applyFromArray($styleArray2);
				
				$awal_col++;
				$alamat   = (isset($row_Cek[0]['alamat']) && $row_Cek[0]['alamat'])?$row_Cek[0]['alamat']:$vals['alamat'];
				$Cols       = getColsChar($awal_col);
				$sheet->setCellValue($Cols.$awal_row, $alamat);
				$sheet->getStyle($Cols.$awal_row)->applyFromArray($styleArray2);
				
				$awal_col++;
				$telpon   = (isset($row_Cek[0]['telpon']) && $row_Cek[0]['telpon'])?$row_Cek[0]['telpon']:$vals['telpon'];
				$Cols       = getColsChar($awal_col);
				$sheet->setCellValue($Cols.$awal_row, $telpon);
				$sheet->getStyle($Cols.$awal_row)->applyFromArray($styleArray2);
				
				$awal_col++;
				$telpon2   = (isset($row_Cek[0]['telpon2']) && $row_Cek[0]['telpon2'])?$row_Cek[0]['telpon2']:$vals['telpon2'];
				$Cols       = getColsChar($awal_col);
				$sheet->setCellValue($Cols.$awal_row, $telpon2);
				$sheet->getStyle($Cols.$awal_row)->applyFromArray($styleArray2);
				
				$awal_col++;
				$telpon3   = (isset($row_Cek[0]['telpon3']) && $row_Cek[0]['telpon3'])?$row_Cek[0]['telpon3']:$vals['telpon3'];
				$Cols       = getColsChar($awal_col);
				$sheet->setCellValue($Cols.$awal_row, $telpon3);
				$sheet->getStyle($Cols.$awal_row)->applyFromArray($styleArray2);
				
				$awal_col++;
				$fax   = strtolower((isset($row_Cek[0]['fax']) && $row_Cek[0]['fax'])?$row_Cek[0]['fax']:$vals['fax']);
				$Cols       = getColsChar($awal_col);
				$sheet->setCellValue($Cols.$awal_row, $fax);
				$sheet->getStyle($Cols.$awal_row)->applyFromArray($styleArray2);
				
				$awal_col++;
				$email   = strtolower((isset($row_Cek[0]['email']) && $row_Cek[0]['email'])?$row_Cek[0]['email']:$vals['email']);
				$Cols       = getColsChar($awal_col);
				$sheet->setCellValue($Cols.$awal_row, $email);
				$sheet->getStyle($Cols.$awal_row)->applyFromArray($styleArray2);
				
				$awal_col++;
				$email2   = strtolower((isset($row_Cek[0]['email2']) && $row_Cek[0]['email2'])?$row_Cek[0]['email2']:$vals['email2']);
				$Cols       = getColsChar($awal_col);
				$sheet->setCellValue($Cols.$awal_row, $email2);
				$sheet->getStyle($Cols.$awal_row)->applyFromArray($styleArray2);
				
				$awal_col++;
				$email3   = ucwords(strtolower((isset($row_Cek[0]['email3']) && $row_Cek[0]['email3'])?$row_Cek[0]['email3']:$vals['email3']));
				$Cols       = getColsChar($awal_col);
				$sheet->setCellValue($Cols.$awal_row, $email3);
				$sheet->getStyle($Cols.$awal_row)->applyFromArray($styleArray2);
				
				$awal_col++;
				$npwp   = (isset($row_Cek[0]['npwp']) && $row_Cek[0]['npwp'])?$row_Cek[0]['npwp']:$vals['npwp'];
				$Cols       = getColsChar($awal_col);
				$sheet->setCellValue($Cols.$awal_row, $npwp);
				$sheet->getStyle($Cols.$awal_row)->applyFromArray($styleArray2);
				
				$awal_col++;
				$alamat_npwp   = (isset($row_Cek[0]['alamat_npwp']) && $row_Cek[0]['alamat_npwp'])?$row_Cek[0]['alamat_npwp']:$vals['alamat_npwp'];
				$Cols       = getColsChar($awal_col);
				$sheet->setCellValue($Cols.$awal_row, $alamat_npwp);
				$sheet->getStyle($Cols.$awal_row)->applyFromArray($styleArray2);
				
				$awal_col++;
				$website   = (isset($row_Cek[0]['website']) && $row_Cek[0]['website'])?$row_Cek[0]['website']:$vals['website'];
				$Cols       = getColsChar($awal_col);
				$sheet->setCellValue($Cols.$awal_row, $website);
				$sheet->getStyle($Cols.$awal_row)->applyFromArray($styleArray2);
				
				$awal_col++;
				$produk_jual   = (isset($row_Cek[0]['produk_jual']) && $row_Cek[0]['produk_jual'])?$row_Cek[0]['produk_jual']:$vals['produk_jual'];
				$Cols       = getColsChar($awal_col);
				$sheet->setCellValue($Cols.$awal_row, $produk_jual);
				$sheet->getStyle($Cols.$awal_row)->applyFromArray($styleArray2);
				
				$awal_col++;
				$nm_pic   = (isset($row_Cek[0]['nm_pic']) && $row_Cek[0]['nm_pic'])?$row_Cek[0]['nm_pic']:$vals['nm_pic'];
				$Cols       = getColsChar($awal_col);
				$sheet->setCellValue($Cols.$awal_row, $nm_pic);
				$sheet->getStyle($Cols.$awal_row)->applyFromArray($styleArray2); 
				
				$awal_col++;
				$divisi   = (isset($row_Cek[0]['divisi']) && $row_Cek[0]['divisi'])?$row_Cek[0]['divisi']:$vals['divisi'];
				$Cols       = getColsChar($awal_col);
				$sheet->setCellValue($Cols.$awal_row, $divisi);
				$sheet->getStyle($Cols.$awal_row)->applyFromArray($styleArray2); 
				
				$awal_col++;
				$jabatan   = (isset($row_Cek[0]['jabatan']) && $row_Cek[0]['jabatan'])?$row_Cek[0]['jabatan']:$vals['jabatan'];
				$Cols       = getColsChar($awal_col);
				$sheet->setCellValue($Cols.$awal_row, $jabatan);
				$sheet->getStyle($Cols.$awal_row)->applyFromArray($styleArray2); 
				
				$awal_col++;
				$hp   = (isset($row_Cek[0]['hp']) && $row_Cek[0]['hp'])?$row_Cek[0]['hp']:$vals['hp'];
				$Cols       = getColsChar($awal_col);
				$sheet->setCellValue($Cols.$awal_row, $hp);
				$sheet->getStyle($Cols.$awal_row)->applyFromArray($styleArray2); 
				
				$awal_col++;
				$email_pic   = (isset($row_Cek[0]['email_pic']) && $row_Cek[0]['email_pic'])?$row_Cek[0]['email_pic']:$vals['email_pic'];
				$Cols       = getColsChar($awal_col);
				$sheet->setCellValue($Cols.$awal_row, $email_pic);
				$sheet->getStyle($Cols.$awal_row)->applyFromArray($styleArray2); 
				
				$awal_col++;
				$reference_by   = (isset($row_Cek[0]['reference_by']) && $row_Cek[0]['reference_by'])?$row_Cek[0]['reference_by']:$vals['reference_by'];
				$Cols       = getColsChar($awal_col);
				$sheet->setCellValue($Cols.$awal_row, $reference_by);
				$sheet->getStyle($Cols.$awal_row)->applyFromArray($styleArray2); 
				
				$awal_col++;
				$reference_name   = (isset($row_Cek[0]['reference_name']) && $row_Cek[0]['reference_name'])?$row_Cek[0]['reference_name']:$vals['reference_name'];
				$Cols       = getColsChar($awal_col);
				$sheet->setCellValue($Cols.$awal_row, $reference_name);
				$sheet->getStyle($Cols.$awal_row)->applyFromArray($styleArray2); 
				
				$awal_col++;
				$reference_phone   = (isset($row_Cek[0]['reference_phone']) && $row_Cek[0]['reference_phone'])?$row_Cek[0]['reference_phone']:$vals['reference_phone'];
				$Cols       = getColsChar($awal_col);
				$sheet->setCellValue($Cols.$awal_row, $reference_phone);
				$sheet->getStyle($Cols.$awal_row)->applyFromArray($styleArray2); 
				
				$awal_col++;
				$diskon_toko   = (isset($row_Cek[0]['diskon_toko']) && $row_Cek[0]['diskon_toko'])?$row_Cek[0]['diskon_toko']:$vals['diskon_toko'];
				$Cols       = getColsChar($awal_col);
				$sheet->setCellValue($Cols.$awal_row, $diskon_toko);
				$sheet->getStyle($Cols.$awal_row)->applyFromArray($styleArray2); 
			}
		}
        
		history('Download Template Excell Customer');
        $sheet->setTitle('Supplier');
        //mulai menyimpan excel format xlsx, kalau ingin xls ganti Excel2007 menjadi Excel5          
        $objWriter      = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();
        //sesuaikan headernya 
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        //ubah nama file saat diunduh
        header('Content-Disposition: attachment;filename="Customer_templete_'.date('YmdHis').'.xls"');
        //unduh file
        $objWriter->save("php://output"); 
    }
	
	public function importData(){
        if($this->input->post()){
            set_time_limit(0);
            ini_set('memory_limit','2048M');
          
			if($_FILES['excel_file']['name']){
				$exts   = getExtension($_FILES['excel_file']['name']);
				if(!in_array($exts,array(1=>'xls','xlsx')))
				{
					$Arr_Kembali		= array(
						'status'		=> 3,
						'pesan'			=> 'Invalid file type, Please Upload the Excel format ...'
					);
				}
				else{
					$fileName = $_FILES['excel_file']['name'];
					$this->load->library(array('PHPExcel'));
					$config['upload_path'] = './assets/file/'; 
					$config['file_name'] = $fileName;
					$config['allowed_types'] = 'xls|xlsx';
					$config['max_size'] = 10000;

					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if (!$this->upload->do_upload('excel_file')) {
						$error = array('error' => $this->upload->display_errors());
						$Arr_Kembali		= array(
							'status'		=> 3,
							'pesan'			=> 'An Error occured, please try again later ...'
						);
					}
					else{
						$media = $this->upload->data();
						$inputFileName = './assets/file/'.$media['file_name'];
						
						$data_session	= $this->session->userdata;
						$Create_By      = $data_session['ORI_User']['username'];
						$Create_Date    = date('Y-m-d H:i:s');
						 
						try{
							$inputFileType  = PHPExcel_IOFactory::identify($inputFileName);
							$objReader      = PHPExcel_IOFactory::createReader($inputFileType); 
							$objReader->setReadDataOnly(true);                               
							$objPHPExcel    = $objReader->load($inputFileName);
							 
						}catch(Exception $e){
							die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());                               
						}
						 
						$sheet = $objPHPExcel->getSheet(0);
						$highestRow     = $sheet->getHighestRow();
						$highestColumn = $sheet->getHighestColumn();
						$Error      = 0;
						$Arr_Keys   = array();
						$Loop       = 0;
						$Total      = 0;
						$Message    = "";
						$Urut       = 0;
						$Arr_Summary= array();
						$Arr_Detail = array();
						
						$intL 		= 0;
						$intError 	= 0;
						$pesan 		= '';
						$status		= '';
						
						for ($row = 6; $row <= $highestRow; $row++)
						{                              
							$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL,TRUE,FALSE);
							//echo "<pre>";print_r($rowData);exit;
							$Urut++;
							 
							//Kode =>  Kolom 1   
							$nm_customer							= (isset($rowData[0][1]) && $rowData[0][1])?$rowData[0][1]:'';
							$Arr_Detail[$Urut]['nm_customer']  		= $nm_customer;
							
							$keterangan								= (isset($rowData[0][2]) && $rowData[0][2])?$rowData[0][2]:'';
							$Arr_Detail[$Urut]['keterangan']  		= $keterangan;
							
							$kdcab									= (isset($rowData[0][3]) && $rowData[0][3])?$rowData[0][3]:'-';
							$Arr_Detail[$Urut]['kdcab']  			= $kdcab;
							
							$kredibilitas							= (isset($rowData[0][4]) && $rowData[0][4])?$rowData[0][4]:'-';
							$Arr_Detail[$Urut]['kredibilitas'] 		= $kredibilitas;
							
							$alamat									= (isset($rowData[0][5]) && $rowData[0][5])?$rowData[0][5]:'-';
							$Arr_Detail[$Urut]['alamat']  			= $alamat;
							
							$telpon									= (isset($rowData[0][6]) && $rowData[0][6])?$rowData[0][6]:'-';
							$Arr_Detail[$Urut]['telpon']  			= $telpon;
							
							$telpon2								= (isset($rowData[0][7]) && $rowData[0][7])?$rowData[0][7]:'-';
							$Arr_Detail[$Urut]['telpon2']  			= $telpon2;
							
							$telpon3								= (isset($rowData[0][8]) && $rowData[0][8])?$rowData[0][8]:'-';
							$Arr_Detail[$Urut]['telpon3']  			= $telpon3;
							
							$fax									= (isset($rowData[0][9]) && $rowData[0][9])?$rowData[0][9]:'';
							$Arr_Detail[$Urut]['fax']  				= $fax;
							
							$email									= (isset($rowData[0][10]) && $rowData[0][10])?$rowData[0][10]:'';
							$Arr_Detail[$Urut]['email']  			= $email;
							
							$email2									= (isset($rowData[0][11]) && $rowData[0][11])?$rowData[0][11]:'';
							$Arr_Detail[$Urut]['email2']  			= $email2;
							
							$email3									= (isset($rowData[0][12]) && $rowData[0][12])?$rowData[0][12]:'-';
							$Arr_Detail[$Urut]['email3']  			= $email3;
							
							$npwp									= (isset($rowData[0][13]) && $rowData[0][13])?$rowData[0][13]:'-';
							$Arr_Detail[$Urut]['npwp']  			= $npwp;
							
							$alamat_npwp							= (isset($rowData[0][14]) && $rowData[0][14])?$rowData[0][14]:'-';
							$Arr_Detail[$Urut]['alamat_npwp']  		= $alamat_npwp;
							
							$website								= (isset($rowData[0][15]) && $rowData[0][15])?$rowData[0][15]:'-';
							$Arr_Detail[$Urut]['website']  			= $website;
							
							$produk_jual							= (isset($rowData[0][16]) && $rowData[0][16])?$rowData[0][16]:'-';
							$Arr_Detail[$Urut]['produk_jual']  		= $produk_jual;
							
							$nm_pic									= (isset($rowData[0][17]) && $rowData[0][17])?$rowData[0][17]:'-';
							$Arr_Detail[$Urut]['nm_pic']  			= $nm_pic;
							
							$divisi									= (isset($rowData[0][18]) && $rowData[0][18])?$rowData[0][18]:'-';
							$Arr_Detail[$Urut]['divisi']  			= $divisi;
							
							$jabatan								= (isset($rowData[0][19]) && $rowData[0][19])?$rowData[0][19]:'-';
							$Arr_Detail[$Urut]['jabatan']  			= $jabatan;
							
							$hp										= (isset($rowData[0][20]) && $rowData[0][20])?$rowData[0][20]:'-';
							$Arr_Detail[$Urut]['hp']  				= $hp;
							
							$email_pic								= (isset($rowData[0][21]) && $rowData[0][21])?$rowData[0][21]:'-';
							$Arr_Detail[$Urut]['email_pic']  		= $email_pic;
							
							$reference_by							= (isset($rowData[0][22]) && $rowData[0][22])?$rowData[0][22]:'-';
							$Arr_Detail[$Urut]['reference_by']  	= $reference_by;
							
							$reference_name							= (isset($rowData[0][23]) && $rowData[0][23])?$rowData[0][23]:'-';
							$Arr_Detail[$Urut]['reference_name']  	= $reference_name;
							
							$reference_phone						= (isset($rowData[0][24]) && $rowData[0][24])?$rowData[0][24]:'-';
							$Arr_Detail[$Urut]['reference_phone']	= $reference_phone;
							
							$diskon_toko						= (isset($rowData[0][25]) && $rowData[0][25])?$rowData[0][25]:'-';
							$Arr_Detail[$Urut]['diskon_toko']	= $diskon_toko;
							
							$Arr_Detail[$Urut]['created_by']    = $Create_By;
							$Arr_Detail[$Urut]['created_date']  = $Create_Date; 
							
							//Get id customer by email
							// $qEmCust	= "SELECT id_customer FROM customer WHERE email='".$Arr_Detail[$Urut]['email']."' LIMIT 1 ";
							// $restEmCust	= $this->db->query($qEmCust)->result_array();
							// $idCustomer	= $restEmCust[0]['id_customer'];
							
							// $Arr_Detail[$Urut]['id_customer']  = $idCustomer;
							// $Arr_Detail[$Urut]['sqd']  = $qEmCust;
							
							if($Arr_Detail[$Urut]['nm_customer'] == '' || $Arr_Detail[$Urut]['nm_customer'] == '-' || $Arr_Detail[$Urut]['nm_customer'] == ' ')
							{
								$intError++;
								$status		= 3;
								$pesan		= "Customer Name number ".$Urut." is empty. Please check back ...";
								
							}
							if($Arr_Detail[$Urut]['email'] == '' || $Arr_Detail[$Urut]['email'] == '-' || $Arr_Detail[$Urut]['email'] == ' ')
							{
								$intError++;
								$status		= 3;
								$pesan		= "Customer Email number ".$Urut." is empty. Please check back ...";
							}
							
							if($Arr_Detail[$Urut]['email_pic'] == '' || $Arr_Detail[$Urut]['email_pic'] == '-' || $Arr_Detail[$Urut]['email_pic'] == ' ')
							{
								$intError++;
								$status		= 3;
								$pesan		= "PIC Email number ".$Urut." is empty. Please check back ...";
							}
							
						} //akhir perulangan
						
						// echo "<pre>";
						// print_r($Arr_Detail);
						// exit;
						
						if($intError > 0){
							$Arr_Kembali	= array(
								'pesan'		=> $pesan,
								'status'	=> $status
							);
						}
						else{
							//duplicate the same customer name
							$ArrDetx = 	array_intersect_key(
								$Arr_Detail, 
								array_unique(array_map(function($item) {
									return $item['nm_customer'];
								}, $Arr_Detail))
							);
							
							$NumArrDetx	= count($ArrDetx);
							$NumArrDet	= count($Arr_Detail);
							
							if($NumArrDetx != $NumArrDet){
								$Arr_Kembali	= array(
									'pesan'		=> "Customer name is the same, please check back ...",
									'status'	=> 3
								);
							}
							else{
								//duplicate the same customer email
								$ArrDetx2 = 	array_intersect_key(
									$Arr_Detail, 
									array_unique(array_map(function($item) {
										return $item['email'];
									}, $Arr_Detail))
								);
								
								$NumArrDetx2	= count($ArrDetx2);
								$NumArrDet2		= count($Arr_Detail);
								
								if($NumArrDetx2 != $NumArrDet2){
									$Arr_Kembali	= array(
										'pesan'		=> "Customer email is the same, please check back ...",
										'status'	=> 3
									);
								}
								else{
									$dtCust 	= array();
									$dtUsaha 	= array();
									$dtUsahaNew	= array();
									$dtRef  	= array();
									$dtPic 		= array();
									foreach($Arr_Detail AS $val => $valx){
										
										//Check Bidang Usaha
										$qChBidang			= "SELECT id_bidang_usaha, bidang_usaha FROM bidang_usaha WHERE UPPER(bidang_usaha) = '".$valx['keterangan']."' ";
										$restChBidang		= $this->db->query($qChBidang)->result_array();
										$numChBidang		= $this->db->query($qChBidang)->num_rows();
										
										$qChBidangMax		= "SELECT MAX(id_bidang_usaha) AS NumBd FROM bidang_usaha LIMIT 1";
										$restChBidangMax	= $this->db->query($qChBidangMax)->result_array();
										$NumPlus			= $restChBidangMax[0]['NumBd'] + 1;
										
										if($numChBidang > 0){
											$dtCust['bidang_usaha']	= $restChBidang[0]['id_bidang_usaha'];
											
											//mengubah customer bidang usaha
											$dtUsaha['bidang_usaha']	= $restChBidang[0]['id_bidang_usaha'];
											$dtUsaha['keterangan']		= strtoupper($valx['keterangan']);
											$dtUsaha['created_by']   	= $valx['created_by'];
											$dtUsaha['created_on'] 		= $valx['created_date'];
											
											//insert bidang usaha yang belum ada
											$dtUsahaNew['bidang_usaha']	= strtoupper($valx['keterangan']);
											$dtUsahaNew['keterangan']		= "-";
											$dtUsahaNew['created_by']   	= $valx['created_by'];
											$dtUsahaNew['created_on'] 		= $valx['created_date'];
										}
										if($numChBidang < 1){
											$dtCust['bidang_usaha']	= $NumPlus;
											
											//insert customer bidang usaha
											$dtUsaha['bidang_usaha']	= $NumPlus;
											$dtUsaha['keterangan']		= strtoupper($valx['keterangan']);
											$dtUsaha['created_by']   	= $valx['created_by'];
											$dtUsaha['created_on'] 		= $valx['created_date'];
											
											// insert biidang usaha yang belum ada
											$dtUsahaNew['bidang_usaha']	= strtoupper($valx['keterangan']);
											$dtUsahaNew['keterangan']		= "-";
											$dtUsahaNew['created_by']   	= $valx['created_by'];
											$dtUsahaNew['created_on'] 		= $valx['created_date'];
										}
										
										//Check PIC Customer berdasarkan email
										$qChPIC		= "SELECT id_pic, email_pic FROM customer_pic WHERE email_pic='".$valx['email_pic']."'";
										$restChPIC	= $this->db->query($qChPIC)->result_array();
										$NumChPIC	= $this->db->query($qChPIC)->num_rows();
										
										if($NumChPIC > 0){
											$dtCust['id_pic']		= $restChPIC[0]['id_pic'];
											
											//merubah pic berdasarkan email
											$dtPic['nm_pic']		= trim(strtoupper($valx['nm_pic']));
											$dtPic['divisi']		= trim(strtoupper($valx['divisi']));
											$dtPic['jabatan']		= trim(strtoupper($valx['jabatan']));
											$dtPic['hp']			= trim($valx['hp']);
											$dtPic['email_pic']		= trim(strtolower($valx['email_pic']));
											$dtPic['modified_on']   = $valx['created_by'];
											$dtPic['modified_by'] 	= $valx['created_date'];
										}
										elseif($NumChPIC < 1){
											//membuat kode PIC
											$Ymonth			= date('ym');
											$qPIC 			= "SELECT MAX(id_pic) AS maxPC FROM customer_pic WHERE id_pic LIKE 'PIC-".$Ymonth."%' ";
											$numRowPIC		= $this->db->query($qPIC)->num_rows();
											$resultPIC		= $this->db->query($qPIC)->result_array();
											$angkaUrut2x	= $resultPIC[0]['maxPC'];
											$urutan2x		= (int)substr($angkaUrut2x, 8, 3);
											$urutan2x++;
											$urut2x			= sprintf('%03s',$urutan2x);
											$kodePIC		= "PIC-".$Ymonth.$urut2x;
											
											$dtCust['id_pic']		= $kodePIC;
											//insert pic 
											$dtPic['id_pic']	= $kodePIC;
											$dtPic['nm_pic']	= trim(strtoupper($valx['nm_pic']));
											$dtPic['divisi']	= trim(strtoupper($valx['divisi']));
											$dtPic['jabatan']	= trim(strtoupper($valx['jabatan']));
											$dtPic['hp']		= trim($valx['hp']);
											$dtPic['email_pic']		= trim(strtolower($valx['email_pic']));
											$dtPic['created_by']   	= $valx['created_by'];
											$dtPic['created_on'] 	= $valx['created_date'];
										}
										
										//referensi tidak bisa diubah, tapi pas di tambah, referensi bisa bertambah, berdasarkan emial customer.
										
										$dtCust['nm_customer']	= trim(strtoupper($valx['nm_customer']));
										$dtCust['kdcab']		= trim(strtoupper($valx['kdcab']));
										$dtCust['kredibilitas']	= trim(strtoupper($valx['kredibilitas']));
										$dtCust['alamat']		= trim(strtoupper($valx['alamat']));
										$dtCust['telpon']		= trim($valx['telpon']);
										$dtCust['telpon2']		= trim($valx['telpon2']);
										$dtCust['telpon3']		= trim($valx['telpon3']);
										$dtCust['fax']			= trim($valx['fax']);
										$dtCust['email']		= trim(strtolower($valx['email']));
										$dtCust['email2']		= trim(strtolower($valx['email2']));
										$dtCust['email3']		= trim(strtolower($valx['email3']));
										$dtCust['npwp']			= trim($valx['npwp']);
										$dtCust['alamat_npwp']	= trim($valx['alamat_npwp']);
										$dtCust['website']		= trim($valx['website']);
										$dtCust['produk_jual']	= trim($valx['produk_jual']);
										$dtCust['diskon_toko']	= trim($valx['diskon_toko']);
										$dtCust['referensi']	= trim($valx['reference_by']);
										
										//Get id customer by email
										$qEmCustX		= "SELECT * FROM customer WHERE email='".$valx['email']."' LIMIT 1 ";
										$restEmCustX	= $this->db->query($qEmCustX)->result();
										$idCustomer		= $restEmCustX[0]->id_customer;
										// print_r($dtCust);
										// echo $idCustomer; exit;
										
										//check customer berdasarkan email
										$sql_Nums	= "SELECT id_customer FROM customer WHERE id_customer='".$idCustomer."' ";
										$q_Nums 	= $this->db->query($sql_Nums);                                                    
										$num_Rows 	= $q_Nums->num_rows();
										
										// echo $num_Rows."<br>";
										// exit;
										if($num_Rows < 1){
											$Ym				= date('ym');
											//pengurutan kode untuk insert data customer
											$srcMtr			= "SELECT MAX(id_customer) as maxP FROM customer WHERE id_customer LIKE 'C".$valx['kdcab']."-".$Ym."%' ";
											$numrowMtr		= $this->db->query($srcMtr)->num_rows();
											$resultMtr		= $this->db->query($srcMtr)->result_array();
											$angkaUrut2		= $resultMtr[0]['maxP'];
											$urutan2		= (int)substr($angkaUrut2, 9, 3);
											$urutan2++;
											$urut2			= sprintf('%03s',$urutan2);
											$id_customer	= "C".$valx['kdcab']."-".$Ym.$urut2;
											
											$dtUsaha['id_customer']	= $id_customer;
											
											$dtCust['created_by']   = $valx['created_by'];
											$dtCust['created_on'] 	= $valx['created_date'];
											$dtCust['id_customer']	= $id_customer;
											
											//insert referensi, because reference do not change
											$dtRef['id_customer']		= $id_customer;
											$dtRef['reference_by']   	= $valx['reference_by'];
											$dtRef['reference_name']   	= $valx['reference_name'];
											$dtRef['reference_phone']   = $valx['reference_phone'];
											$dtRef['created_by']   		= $valx['created_by'];
											$dtRef['created_on'] 		= $valx['created_date'];
											
										}
										if($num_Rows > 0){
											//Get id customer by email
											// $qEmCust	= "SELECT id_customer FROM customer WHERE email='".$valx['email']."' LIMIT 1 ";
											// $restEmCust	= $this->db->query($qEmCust)->result_array();
											// $idCustomer	= $restEmCust[0]['id_customer'];
										
											$dtCust['modified_by']  = $valx['created_by'];
											$dtCust['modified_on'] 	= $valx['created_date'];
										}
										
										// echo "<pre>";
										// print_r($dtCust);
										// print_r($dtUsaha);
										// print_r($dtPic);
										// print_r($dtRef);
										// exit;
										
										if($num_Rows > 0){
											$this->db->trans_strict(FALSE);
											$this->db->trans_start();
												$this->db->where('id_customer', $idCustomer)->update('customer', $dtCust);
												$this->db->where('id_customer', $idCustomer)->update('customer_bidang_usaha', $dtUsaha);
												if($NumChPIC > 0){
													$this->db->where('email_pic', $idCustomer)->update('customer_pic', $dtPic);
												}
											$this->db->trans_complete();
										}
										if($num_Rows < 1){
											$this->db->trans_strict(FALSE);
											$this->db->trans_start();
												if($num_Rows < 1){
													$this->db->insert('customer', $dtCust);
												}
												$this->db->insert('customer_bidang_usaha', $dtUsaha);
												if($numChBidang < 1){
													$this->db->insert('bidang_usaha', $dtUsahaNew);
												}
												if($NumChPIC < 1){
													$this->db->insert('customer_pic', $dtPic);
												}
												$this->db->insert('customer_referensi', $dtRef);
											$this->db->trans_complete();
										}
										
									} //akhir perulangan

									// echo "Saved Success";
									// exit;
									if ($this->db->trans_status() === FALSE){
										$this->db->trans_rollback();
										$Arr_Kembali	= array(
											'pesan'		=>'Upload Excell Customer Failed. Please try again later ...',
											'status'	=> 2
										);
									}
									else{
										$this->db->trans_commit();
										$Arr_Kembali	= array(
											'pesan'		=>'Upload Excell Customer Success. Thanks ...',
											'status'	=> 1
										);
										history('Upload Excell Customer');
									}
								}
							}
						}
					}
				}
			} 
			//penutup data array
			echo json_encode($Arr_Kembali);
		}
	} 

public function getDataJSON(){
		$controller			= ucfirst(strtolower($this->uri->segment(1)));
		$Arr_Akses			= getAcccesmenu($controller);
		$requestData	= $_REQUEST;
		$fetch			= $this->queryDataJSON(
			$requestData['search']['value'],
			$requestData['order'][0]['column'],
			$requestData['order'][0]['dir'],
			$requestData['start'],
			$requestData['length']
		);
		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		$urut1  = 1;
        $urut2  = 0;
		foreach($query->result_array() as $row)
		{
			$total_data     = $totalData;
            $start_dari     = $requestData['start'];
            $asc_desc       = $requestData['order'][0]['dir'];
            if($asc_desc == 'asc')
            {
                $nomor = $urut1 + $start_dari;
            }
            if($asc_desc == 'desc')
            {
                $nomor = ($total_data - $start_dari) - $urut2;
            }

			$nestedData 	= array();
			$nestedData[]	= "<div align='center'>".$nomor."</div>";
			$nestedData[]	= "<div align='left'>".strtoupper(strtolower($row['nm_customer']))."</div>";
			$nestedData[]	= "<div align='left'>".strtoupper(strtolower($row['kdcab']))."</div>";
			$nestedData[]	= "<div align='left'>".strtoupper(strtolower($row['kredibilitas']))."</div>";
				if($row['sts_aktif'] == 'Y'){
					$class	= 'bg-green';
					$status	= 'Active';
				}
				if($row['sts_aktif'] == 'N'){
					$class	= 'bg-red';
					$status	= 'Non-Active';
				}
			$nestedData[]	= "<div align='center'><span class='badge ".$class."'>".$status."</span></div>";
						$updX = "";
						$delX	= "";
					// $updX	= "&nbsp;<a href='".site_url($this->uri->segment(1).'/edit/'.$row['id'])."' class='btn btn-sm btn-primary' title='Edit SO' data-role='qtip'><i class='fa fa-edit'></i></a>";
					if($Arr_Akses['delete']=='1'){
					$delX	= "<button class='btn btn-sm btn-danger' id='deleteSO' title='Permanent Delete SO' data-id_so='".$row['id_customer']."'><i class='fa fa-trash'></i></button>";
					}
			$nestedData[]	= "<div align='center'>
									<a href='".base_url()."index.php/customer_master/view/".$row['id_customer']."' class='btn btn-sm btn-default' title='View Data' data-role='qtip'><i class='fa fa-eye'></i></a>
									".$updX."
									".$delX."
									</div>";
			$data[] = $nestedData;
            $urut1++;
            $urut2++;
		}

		$json_data = array(
			"draw"            	=> intval( $requestData['draw'] ),
			"recordsTotal"    	=> intval( $totalData ),
			"recordsFiltered" 	=> intval( $totalFiltered ),
			"data"            	=> $data
		);

		echo json_encode($json_data);
	}

	public function queryDataJSON($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL){

		$sql = "
			SELECT
				*
			FROM
				customer
		    WHERE sts_aktif <> 'N' AND (
				nm_customer LIKE '%".$this->db->escape_like_str($like_value)."%'
	        )
		";
		// echo $sql; exit;

		$data['totalData'] = $this->db->query($sql)->num_rows();
		$data['totalFiltered'] = $this->db->query($sql)->num_rows();
		$columns_order_by = array(
			0 => 'nomor',
			1 => 'nm_customer',
			2 => 'kdcab',
			3 => 'kredibilitas'
			
		);

		$sql .= " ORDER BY nm_customer ASC, ".$columns_order_by[$column_order]." ".$column_dir." ";
		$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";

		$data['query'] = $this->db->query($sql);
		return $data;
	}	
}
