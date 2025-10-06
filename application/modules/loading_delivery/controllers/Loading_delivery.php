<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Loading_delivery extends Admin_Controller{
	
	protected $viewPermission 	= 'Loading_delivery.View';
    protected $addPermission  	= 'Loading_delivery.Add';
    protected $managePermission = 'Loading_delivery.Manage';
    protected $deletePermission = 'Loading_delivery.Delete';
	
	public function __construct(){
        parent::__construct();
        $this->load->library(array('Mpdf', 'upload', 'Image_lib'));
        // $this->load->model(array('Loading_delivery/Loading_delivery_model'));
        $this->template->title('Loading Delivery');
        $this->template->page_icon('fa fa-building-o');

        date_default_timezone_set('Asia/Bangkok');
    }
	
	public function index(){
		$this->auth->restrict($this->viewPermission);
		
        // $data = $this->Inventory_4_model->CariSPK();
		$get_last = $this->db->query("SELECT * FROM temp_last WHERE category='loading delivery' ORDER BY id DESC LIMIT 1")->result();
		
        $this->template->set('results', $get_last);
		$this->template->page_icon('fa fa-users');
        $this->template->title('Loading Delivery');
        $this->template->render('index');
    }
	
	public function get_loading_machine(){
		// $machine 	= $this->uri->segment(3);
		$tgl_awal 	= date('Y-m-d',strtotime($this->uri->segment(3)));
		$tgl_akhir 	= date('Y-m-d',strtotime($this->uri->segment(4)));

		$where_machine = "";
		$where_machine2 = "";
		// if($machine <> '0'){
			// $where_machine 	= " AND a.machine ='".$machine."'";
			// $where_machine2 = " AND a.machine ='".$machine."'";
		// }
		
		$detail = $this->db->query("SELECT 
										a.*,
										b.nama_customer,
										b.no_surat
									FROM 
										dt_spkmarketing_loading a 
										LEFT JOIN tr_spk_marketing b ON a.id_spkmarketing = b.id_spkmarketing
									WHERE a.delivery 
										BETWEEN '".$tgl_awal."' AND '".$tgl_akhir."' 
										".$where_machine." AND deal = '1' ORDER BY a.id ASC ")->result_array();
		
		$awal       = new DateTime($tgl_awal);
		$akhir      = new DateTime($tgl_akhir);
    	
		$perbedaan  = $akhir->diff($awal);
		$colspan    = $perbedaan->days + 1;
		$colspan2    = $perbedaan->days + 4;

		$d_Header = "<div class='table-responsive tableFixHead' style='max-height:600px;'>";
			$d_Header .= "<table class='table table-sm table-bordered table-striped dataTable no-footer' border='1'>";
				$d_Header .= "<thead class='thead'>";
					$d_Header .= "<tr>";
						$d_Header .= "<th class='text-center align-middle th' style='min-width:150px; z-index: 99999 !important; vertical-align:middle;'>No Alloy</th>";
						$d_Header .= "<th class='text-center align-middle th' style='min-width:300px; vertical-align:middle;'>Nama Customer</th>";
						$d_Header .= "<th class='text-center align-middle th' style='min-width:200px; vertical-align:middle;'>No SPK</th>";
						for ($a=0; $a<$colspan; $a++) {
							$loop_date = date("d-m-Y", strtotime("+".$a." day", strtotime($tgl_awal)));
							$loop_date2 = date("l", strtotime("+".$a." day", strtotime($tgl_awal)));
							$d_Header .= "<th class='text-center align-middle th' style='min-width:100px;'>".$loop_date2."<br>".$loop_date."</th>";
						}
					$d_Header .= "</tr>";
				$d_Header .= "</thead>";
				$d_Header .= "<tbody>";
					if(!empty($detail)){
						foreach($detail AS $val => $valx){
							$d_Header .= "<tr>";
								$d_Header .= "<td class='td'>".strtoupper($valx['no_alloy'])."</td>";
								$d_Header .= "<td class='td'>".strtoupper($valx['nama_customer'])."</td>";
								$d_Header .= "<td class='td'>".strtoupper($valx['no_surat'])."</td>";
								for ($a=0; $a<$colspan; $a++) {
									$loop_date = date("Y-m-d", strtotime("+".$a." day", strtotime($tgl_awal)));
									$get_hours = $this->db->select('SUM(a.qty_produk) AS hours')->get_where('dt_spkmarketing_loading a',array('a.id_spkmarketing'=>$valx['id_spkmarketing'],'a.id_dt_spkmarketing'=>$valx['id_dt_spkmarketing'],'a.delivery'=>$loop_date,'a.deal'=>'1'))->result();
									$hours = (!empty($get_hours[0]->hours))?"<a href='' class='change_loading' data-id_spkmarketing='".$valx['id_spkmarketing']."' data-id_dt_spkmarketing='".$valx['id_dt_spkmarketing']."' data-delivery='".$loop_date."' title='Move date loading'>".number_format($get_hours[0]->hours,2)."</a>":'-';
									$d_Header .= "<td class='text-center td'>".$hours."</td>";
								}
							$d_Header .= "</tr>";
						}
					}
					else{
						$d_Header .= "<tr>";
							$d_Header .= "<td class='td' colspan='".$colspan2."'>Tidak ada loading mesin</td>";
						$d_Header .= "</tr>";
					}
				$d_Header .= "</tbody>";
				$d_Header .= "<tfoot class='tfoot'>";
					$d_Header .= "<tr>";
						$d_Header .= "<th class='th' style='z-index: 99999 !important;'><b>TOTAL</b></th>";
						$d_Header .= "<th class='th'><b></b></th>";
						$d_Header .= "<th class='th'><b></b></th>";
						for ($a=0; $a<$colspan; $a++) {
							$loop_date = date("Y-m-d", strtotime("+".$a." day", strtotime($tgl_awal)));
							$get_hours = $this->db->query("SELECT SUM(a.qty_produk) AS hours FROM dt_spkmarketing_loading a WHERE a.delivery = '".$loop_date."' ".$where_machine2." AND a.deal = '1'")->result();
							$hours = (!empty($get_hours[0]->hours))?number_format($get_hours[0]->hours,2):'-';
							$d_Header .= "<th class='text-center th'><b>".$hours."</b></th>";
						}
					$d_Header .= "</tr>";
				$d_Header .= "<tfoot>";
			$d_Header .= "</table>";
		$d_Header .= "</div>";
		
		$data_temp = array(
			'category' 	=> 'loading delivery',
			'value1' 	=> $tgl_awal,
			'value2' 	=> $tgl_akhir,
			'last_by' 	=> $this->auth->user_id(),
			'last_date' => date('Y-m-d H:i:s')
		);
		
		$this->db->insert('temp_last', $data_temp);
	
		echo json_encode(array(
		'header' => $d_Header,
		));
	}
	
	public function modal_change_loading(){
		if($this->input->post()){
			$Arr_Kembali	= array();			
			$data			= $this->input->post();
			// print_r($data); exit;
			$data_session	= $this->session->userdata;
			$id_dt_spkmarketing			= $data['id_dt_spkmarketing'];
			$delivery	= $data['delivery'];
			$id_spkmarketing			= $data['id_spkmarketing'];
			$detail			= $data['detail'];

			$ArrDetail = array();
			$ArrDetail2 = array();

			foreach($detail AS $val => $valx){
				if(!empty($valx['new_date'])){
					$ArrDetail[$val]['id']     = $valx['id'];
					$ArrDetail[$val]['delivery']			= date('Y-m-d', strtotime($valx['new_date']));

					$ArrDetail2[$val]['id']     = $valx['id2'];
					$ArrDetail2[$val]['delivery']			= date('Y-m-d', strtotime($valx['new_date']));
				}
			}

			$this->db->trans_start();
				if(!empty($ArrDetail)){
					$this->db->update_batch('dt_spkmarketing_loading', $ArrDetail, 'id');
				}

				if(!empty($ArrDetail2)){
					$this->db->update_batch('dt_spkmarketing', $ArrDetail2, 'id');
				}
			$this->db->trans_complete();	

			if($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				$Arr_Data	= array(
					'pesan'		=>'Save process failed. Please try again later ...',
					'status'	=> 0
				);
			}
			else{
				$this->db->trans_commit();
				$Arr_Data	= array(
					'pesan'		=>'Save process success. Thanks ...',
					'status'	=> 1
				);
            }
            
			echo json_encode($Arr_Data);
				
		}
		else{
			$id_dt_spkmarketing			= $this->uri->segment(3);
			$delivery	= $this->uri->segment(4);
			$id_spkmarketing			= $this->uri->segment(5);
			
			$get_data = $this->db->select('a.*')->order_by('id_material', 'asc')->get_where('dt_spkmarketing_loading a',array('a.id_dt_spkmarketing'=>$id_dt_spkmarketing,'a.delivery'=>$delivery,'a.id_spkmarketing'=>$id_spkmarketing))->result_array();
			
			$data = array(
				'get_data' => $get_data,
				'id_dt_spkmarketing' => $id_dt_spkmarketing,
				'delivery' => $delivery,
				'id_spkmarketing' => $id_spkmarketing
			);
			
			$this->load->view('modal_move',$data);
		}
    }
	
}