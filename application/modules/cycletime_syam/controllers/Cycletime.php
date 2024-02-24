<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 */
class Cycletime extends Admin_Controller
{
    //Permission
    protected $viewPermission 	= 'Cycletime.View';
    protected $addPermission  	= 'Cycletime.Add';
    protected $managePermission = 'Cycletime.Manage';
    protected $deletePermission = 'Cycletime.Delete';

   public function __construct()
    {
        parent::__construct();

        // $this->load->library(array('Mpdf', 'upload', 'Image_lib'));
        $this->load->model(array('Cycletime/Cycletime_model',
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
      $deleted = '0';
      $data = $this->Cycletime_model->get_cycleheader();
      $this->template->set('results', $data);
      $this->template->title('Cycletime');
      $this->template->render('index');
    }

    public function add(){

    	$session = $this->session->userdata('app_session');

			$customer    = $this->Cycletime_model->get_data('master_customers');
			$supplier    = $this->Cycletime_model->get_data('master_supplier');
			$material    = $this->Cycletime_model->get_data('ms_inventory_category2');
			$mesin      = $this->Cycletime_model->get_data_group('asset','category','4','nm_asset');
      $mould      = $this->Cycletime_model->get_data_group('asset','category','5','nm_asset');
			$costcenter  = $this->Cycletime_model->get_data('ms_costcenter','deleted','0');
			$data = [
			'customer' => $customer,
			'supplier' => $supplier,
			'material' => $material,
			'mesin' => $mesin,
      'mould' => $mould,
			'costcenter' => $costcenter,
			];
			$this->template->set('results', $data);
      $this->template->title('Add Cycletime');
      $this->template->page_icon('fa fa-edit');
      $this->template->title('Add Cycletime');
      $this->template->render('add');
    }

    public function edit(){

    	$session = $this->session->userdata('app_session');
      $id_time = $this->uri->segment(3);
			$customer    = $this->Cycletime_model->get_data('master_customers');
			$supplier    = $this->Cycletime_model->get_data('master_supplier');
			$material    = $this->Cycletime_model->get_data('ms_inventory_category2');

      $header	= $this->db->query("SELECT * FROM cycletime_header WHERE id_time='".$id_time."' LIMIT 1 ")->result();
      $costcenter	= $this->db->query("SELECT * FROM ms_costcenter WHERE deleted='0' ORDER BY nama_costcenter ASC ")->result_array();
      $machine	= $this->db->query("SELECT * FROM asset WHERE category='4' GROUP BY nm_asset ORDER BY nm_asset ASC ")->result_array();
      $mould	= $this->db->query("SELECT * FROM asset WHERE category='5' GROUP BY nm_asset ORDER BY nm_asset ASC ")->result_array();
			$data = [
			'customer' => $customer,
			'supplier' => $supplier,
			'material' => $material,
			'mesin' => $machine,
      'mould' => $mould,
			'costcenter' => $costcenter,
      'header' => $header
			];
			$this->template->set('results', $data);
      $this->template->page_icon('fa fa-edit');
      $this->template->title('Edit Cycletime');
      $this->template->render('edit', $data);
    }


	public function view(){
		$this->auth->restrict($this->viewPermission);
		$id 	= $this->input->post('id');
		$header = $this->db->get_where('cycletime_header',array('id_time' => $id))->result();
    // print_r($header);
		$data = [
			'header' => $header
			];
    $this->template->set('results', $data);
		$this->template->render('view', $data);
	}

  public function get_add(){
		$id 	= $this->uri->segment(3);
		$no 	= 0;

		$costcenter	= $this->db->query("SELECT * FROM ms_costcenter WHERE deleted='0' ORDER BY nama_costcenter ASC ")->result_array();
    $machine	= $this->db->query("SELECT * FROM asset WHERE category='4' GROUP BY nm_asset ORDER BY nm_asset ASC ")->result_array();
    $mould	= $this->db->query("SELECT * FROM asset WHERE category='5' GROUP BY nm_asset ORDER BY nm_asset ASC ")->result_array();
		// echo $qListResin; exit;
		$d_Header = "";
		// $d_Header .= "<tr>";
			$d_Header .= "<tr class='header_".$id."'>";
				$d_Header .= "<td align='center'>".$id."</td>";
				$d_Header .= "<td align='left'>";
        $d_Header .= "<select name='Detail[".$id."][costcenter]' class='chosen_select form-control input-sm inline-blockd costcenter'>";
        $d_Header .= "<option value='0'>Select Costcenter</option>";
        foreach($costcenter AS $val => $valx){
          $d_Header .= "<option value='".$valx['id_costcenter']."'>".strtoupper($valx['nama_costcenter'])."</option>";
        }
        $d_Header .= 		"</select>";
				$d_Header .= "</td>";
        $d_Header .= "<td align='left'>";
        $d_Header .= "<select name='Detail[".$id."][machine]' class='chosen_select form-control input-sm inline-blockd'>";
        $d_Header .= "<option value='0'>Select Machine</option>";
        foreach($machine AS $val => $valx){
          $d_Header .= "<option value='".$valx['kd_asset']."'>".strtoupper($valx['nm_asset'])."</option>";
        }
        $d_Header .= "<option value='0'>NONE MACHINE</option>";
        $d_Header .= 		"</select>";

				$d_Header .= "</td>";
        $d_Header .= "<td align='left'>";
        $d_Header .= "<select name='Detail[".$id."][mould]' class='chosen_select form-control input-sm inline-blockd'>";
        $d_Header .= "<option value='0'>Select Mould/Tools</option>";
        foreach($mould AS $val => $valx){
          $d_Header .= "<option value='".$valx['kd_asset']."'>".strtoupper($valx['nm_asset'])."</option>";
        }
        $d_Header .= "<option value='0'>NONE MOULD/TOOLS</option>";
        $d_Header .= 		"</select>";
				$d_Header .= "</td>";
				$d_Header .= "<td align='left'></td>";
				$d_Header .= "<td align='center'>";
				$d_Header .= "&nbsp;<button type='button' class='btn btn-sm btn-danger delPart' title='Delete Part'><i class='fa fa-close'></i></button>";
				$d_Header .= "</td>";
			$d_Header .= "</tr>";

		//add nya
		$d_Header .= "<tr id='add_".$id."_".$no."' class='header_".$id."'>";
			$d_Header .= "<td align='center'></td>";
			$d_Header .= "<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type='button' class='btn btn-sm btn-primary addSubPart' title='Add Process'><i class='fa fa-plus'></i>&nbsp;&nbsp;Add Process</button></td>";
			$d_Header .= "<td align='center'></td>";
			$d_Header .= "<td align='center'></td>";
			$d_Header .= "<td align='center'></td>";
			$d_Header .= "<td align='center'></td>";
		$d_Header .= "</tr>";

		//add part
		$d_Header .= "<tr id='add_".$id."'>";
			$d_Header .= "<td align='center'></td>";
			$d_Header .= "<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type='button' class='btn btn-sm btn-warning addPart' title='Add Costcenter'><i class='fa fa-plus'></i>&nbsp;&nbsp;Add Costcenter</button></td>";
			$d_Header .= "<td align='center'></td>";
			$d_Header .= "<td align='center'></td>";
			$d_Header .= "<td align='center'></td>";
			$d_Header .= "<td align='center'></td>";
		$d_Header .= "</tr>";

		 echo json_encode(array(
				'header'			=> $d_Header,
		 ));
	}

  public function get_add_sub(){
		$id 	= $this->uri->segment(3);
    $no 	= $this->uri->segment(4);

		$process	= $this->db->query("SELECT * FROM ms_process ORDER BY nm_process ASC ")->result_array();
		// echo $qListResin; exit;
		$d_Header = "";
		// $d_Header .= "<tr>";
			$d_Header .= "<tr class='header_".$id."'>";
				$d_Header .= "<td align='center'></td>";
				$d_Header .= "<td align='left' style='vertical-align:middle; padding-left: 30px;'>";
        $d_Header .= "<select name='Detail[".$id."][detail][".$no."][process]' class='chosen_select form-control input-sm inline-blockd process'>";
        $d_Header .= "<option value='0'>Select Process Name</option>";
        foreach($process AS $val => $valx){
          $d_Header .= "<option value='".$valx['id']."'>".strtoupper($valx['nm_process'])."</option>";
        }
        $d_Header .= 		"</select>";
				$d_Header .= "</td>";
        $d_Header .= "<td align='left'>";
        $d_Header .= "<input type='text' name='Detail[".$id."][detail][".$no."][cycletime]' class='form-control input-md maskM' placeholder='Cycletime (Minutes)'  data-decimal='.' data-thousand='' data-precision='0' data-allow-zero=''>";
				$d_Header .= "</td>";
        $d_Header .= "<td align='left'>";
        $d_Header .= "<input type='text' name='Detail[".$id."][detail][".$no."][qty_mp]' class='form-control input-md maskM' placeholder='Qty Man Power'  data-decimal='.' data-thousand='' data-precision='0' data-allow-zero=''>";
				$d_Header .= "</td>";
        $d_Header .= "<td align='left'>";
        $d_Header .= "<input type='text' name='Detail[".$id."][detail][".$no."][note]' class='form-control input-md' placeholder='Information'  data-decimal='.' data-thousand='' data-precision='0' data-allow-zero=''>";
        $d_Header .= "</td>";
				$d_Header .= "<td align='center'>";
				$d_Header .= "&nbsp;<button type='button' class='btn btn-sm btn-danger delSubPart' title='Delete Part'><i class='fa fa-close'></i></button>";
				$d_Header .= "</td>";
			$d_Header .= "</tr>";

		//add nya
		$d_Header .= "<tr id='add_".$id."_".$no."' class='header_".$id."'>";
			$d_Header .= "<td align='center'></td>";
			$d_Header .= "<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type='button' class='btn btn-sm btn-primary addSubPart' title='Add Process'><i class='fa fa-plus'></i>&nbsp;&nbsp;Add Process</button></td>";
			$d_Header .= "<td align='center'></td>";
			$d_Header .= "<td align='center'></td>";
			$d_Header .= "<td align='center'></td>";
			$d_Header .= "<td align='center'></td>";
		$d_Header .= "</tr>";

		 echo json_encode(array(
				'header'			=> $d_Header,
		 ));
	}


  public function save_cycletime(){

  	$Arr_Kembali	= array();
		$data			= $this->input->post();
    // print_r($data);
    // exit;
		$session 		= $this->session->userdata('app_session');
    $Detail 	= $data['Detail'];
    $Ym						= date('ym');
    //pengurutan kode
    $srcMtr			= "SELECT MAX(id_time) as maxP FROM cycletime_header WHERE id_time LIKE 'TM-".$Ym."%' ";
    $numrowMtr		= $this->db->query($srcMtr)->num_rows();
    $resultMtr		= $this->db->query($srcMtr)->result_array();
    $angkaUrut2		= $resultMtr[0]['maxP'];
    $urutan2		= (int)substr($angkaUrut2, 7, 3);
    $urutan2++;
    $urut2			= sprintf('%03s',$urutan2);
    $id_material	= "TM-".$Ym.$urut2;

    $ArrHeader		= array(
      'id_time'			=> $id_material,
      'id_product'	=> $data['produk'],
      'created_by'	=> $session['id_user'],
      'created_date'	=> date('Y-m-d H:i:s')
    );



    $ArrDetail	= array();
    $ArrDetail2	= array();
    foreach($Detail AS $val => $valx){
      $urut				= sprintf('%02s',$val);
      $ArrDetail[$val]['id_time'] 			= $id_material;
      $ArrDetail[$val]['id_costcenter'] = $id_material."-".$urut;
      $ArrDetail[$val]['costcenter'] 		= $valx['costcenter'];
      $ArrDetail[$val]['machine'] 			= $valx['machine'];
      $ArrDetail[$val]['mould'] 				= $valx['mould'];
      foreach($valx['detail'] AS $val2 => $valx2){
        $ArrDetail2[$val2.$val]['id_time'] 			= $id_material;
        $ArrDetail2[$val2.$val]['id_costcenter'] = $id_material."-".$urut;
        $ArrDetail2[$val2.$val]['id_process'] 	= $valx2['process'];
        $ArrDetail2[$val2.$val]['cycletime'] 		= $valx2['cycletime'];
        $ArrDetail2[$val2.$val]['qty_mp'] 			= $valx2['qty_mp'];
        $ArrDetail2[$val2.$val]['note'] 				= $valx2['note'];
      }
    }

    // print_r($ArrHeader);
		// print_r($ArrDetail);
		// print_r($ArrDetail2);
		// exit;

		$this->db->trans_start();
			$this->db->insert('cycletime_header', $ArrHeader);
      if(!empty($ArrDetail)){
  			$this->db->insert_batch('cycletime_detail_header', $ArrDetail);
      }
      if(!empty($ArrDetail)){
        $this->db->insert_batch('cycletime_detail_detail', $ArrDetail2);
      }
		$this->db->trans_complete();

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$Arr_Data	= array(
				'pesan'		=>'Save gagal disimpan ...',
				'status'	=> 0
			);
		}
		else{
			$this->db->trans_commit();
			$Arr_Data	= array(
				'pesan'		=>'Save berhasil disimpan. Thanks ...',
				'status'	=> 1
			);
		}

		echo json_encode($Arr_Data);
	}

	public function list_center(){
		$id = $this->uri->segment(3);
		$query	 	= "SELECT * FROM ms_costcenter WHERE id_dept='".$id."' ORDER BY nama_costcenter ASC";
		$Q_result	= $this->db->query($query)->result();
		$option 	= "<option value='0'>Select an Option</option>";
		foreach($Q_result as $row)	{
		$option .= "<option value='".$row->nama_costcenter."'>".strtoupper($row->nama_costcenter)."</option>";
		}
		echo json_encode(array(
			'option' => $option
		));
	}

  public function edit_cycletime(){

  	$Arr_Kembali	= array();
		$data			    = $this->input->post();
    // print_r($data);
    // exit;
		$session 		   = $this->session->userdata('app_session');
    $Detail 	     = $data['Detail'];
    $id_material	 = $data['id_time'];

    $ArrHeader		  = array(
      'id_time'			=> $id_material,
      'id_product'	=> $data['produk'],
      'updated_by'	=> $session['id_user'],
      'updated_date'	=> date('Y-m-d H:i:s')
    );



    $ArrDetail	= array();
    $ArrDetail2	= array();
    foreach($Detail AS $val => $valx){
      $urut				= sprintf('%02s',$val);
      $ArrDetail[$val]['id_time'] 			= $id_material;
      $ArrDetail[$val]['id_costcenter'] = $id_material."-".$urut;
      $ArrDetail[$val]['costcenter'] 		= $valx['costcenter'];
      $ArrDetail[$val]['machine'] 			= $valx['machine'];
      $ArrDetail[$val]['mould'] 				= $valx['mould'];
      foreach($valx['detail'] AS $val2 => $valx2){
        $ArrDetail2[$val2.$val]['id_time'] 			= $id_material;
        $ArrDetail2[$val2.$val]['id_costcenter'] = $id_material."-".$urut;
        $ArrDetail2[$val2.$val]['id_process'] 	= $valx2['process'];
        $ArrDetail2[$val2.$val]['cycletime'] 		= $valx2['cycletime'];
        $ArrDetail2[$val2.$val]['qty_mp'] 			= $valx2['qty_mp'];
        $ArrDetail2[$val2.$val]['note'] 				= $valx2['note'];
      }
    }

    // print_r($ArrHeader);
		// print_r($ArrDetail);
		// print_r($ArrDetail2);
		// exit;

		$this->db->trans_start();
      $this->db->where('id_time', $id_material);
			$this->db->update('cycletime_header', $ArrHeader);

      $this->db->delete('cycletime_detail_header', array('id_time' => $id_material));
      $this->db->delete('cycletime_detail_detail', array('id_time' => $id_material));

      if(!empty($ArrDetail)){
  			$this->db->insert_batch('cycletime_detail_header', $ArrDetail);
      }
      if(!empty($ArrDetail)){
        $this->db->insert_batch('cycletime_detail_detail', $ArrDetail2);
      }
		$this->db->trans_complete();

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$Arr_Data	= array(
				'pesan'		=>'Save gagal disimpan ...',
				'status'	=> 0
			);
		}
		else{
			$this->db->trans_commit();
			$Arr_Data	= array(
				'pesan'		=>'Save berhasil disimpan. Thanks ...',
				'status'	=> 1
			);
		}

		echo json_encode($Arr_Data);
	}

  public function delete_cycletime(){

  	$Arr_Kembali	= array();
		$data			    = $this->input->post();
    // print_r($data);
    // exit;
		$session 		   = $this->session->userdata('app_session');
    $id_material	 = $data['id'];

    $ArrHeader		  = array(
      'deleted'			=> "Y",
      'deleted_by'	=> $session['id_user'],
      'deleted_date'	=> date('Y-m-d H:i:s')
    );

		$this->db->trans_start();
      $this->db->where('id_time', $id_material);
			$this->db->update('cycletime_header', $ArrHeader);
		$this->db->trans_complete();

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$Arr_Data	= array(
				'pesan'		=>'Delete gagal disimpan ...',
				'status'	=> 0
			);
		}
		else{
			$this->db->trans_commit();
			$Arr_Data	= array(
				'pesan'		=>'Delete berhasil disimpan. Thanks ...',
				'status'	=> 1
			);
		}

		echo json_encode($Arr_Data);
	}

}

?>
