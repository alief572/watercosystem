<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * @author Harboens
 * @copyright Copyright (c) 2022, Harboens
 *
 * This is controller for All
 */

class All extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('all/All_model'));
        $this->template->title('Manage Data');
        $this->template->page_icon('fa fa-table');
        date_default_timezone_set("Asia/Bangkok");
    }
    public function index() {
	}
/*
    public function err_rpt() {
		$data=array(
			'masalah'		=> $this->input->post("masalah"),
			'modul'			=> $this->input->post("modul"),
			'created_by'	=> $this->session->userdata['app_session']['username'],
			'created_date'	=> date('Y-m-d H:i:s'),
		)
		$iddata=$this->All_model->dataSave('data_error_log',$data);
		$param = array(
					'save' => $iddata
				);
		echo json_encode($param);
    }
*/
    public function testprint(){
		$this->load->library(array('Mpdf'));
        $mpdf=new mPDF();
        $mpdf->SetImportUse();
        $mpdf->RestartDocTemplate();

        $show = "hello world";
		$this->mpdf->AddPageByArray(['orientation'=>'P','sheet-size'=>[100,100]]);
        $this->mpdf->WriteHTML($show);
        $this->mpdf->Output();

	}
	public function list_bank($id='') {
		$results = $this->db->query("select name,nik,bank_id,accnumber,accname from employees order by name")->result();
		if(!empty($results)){
			$numb=0;
			echo '<div class="row">
			<div class="table-responsive col-md-12">
			<table id="mylistbank" class="table table-bordered table-hover table-condensed">
			<thead>
			<tr>
				<th>Nama</th>
				<th>NIK</th>
				<th>Bank</th>
				<th>No Rekening</th>
				<th>Nama Rekening</th>
			</tr>
			</thead>
			<tbody>
			';
			foreach($results AS $record) {
				echo '
				<tr style="cursor:pointer" onclick=\'pilihini("'.$record->bank_id.'","'.$record->accnumber.'","'.$record->accname.'","'.$id.'")\'>
					<td>'.$record->name.'</td>
					<td>'.$record->nik.'</td>
					<td>'.$record->bank_id.'</td>
					<td>'.$record->accnumber.'</td>
					<td>'.$record->accname.'</td>
				</tr>
				';
			}
			echo '</tbody></table></div></div>';
		}else{
			echo 'No data found';
		}
    }
}