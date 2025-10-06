<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/*
 * @author Ichsan
 * @copyright Copyright (c) 2019, Ichsan
 *
 * This is controller for Master Supplier
 */

class Control_po extends Admin_Controller
{
    //Permission
    protected $viewPermission 	= 'Control_PO.View';
    protected $addPermission  	= 'Control_PO.Add';
    protected $managePermission = 'Control_PO.Manage';
    protected $deletePermission = 'Control_PO.Delete';

    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('Mpdf', 'upload', 'Image_lib'));
        $this->load->model(array('Aktifitas/aktifitas_model',
                                ));
        $this->template->title('Control PO');
        $this->template->page_icon('fa fa-building-o');

        date_default_timezone_set('Asia/Bangkok');


    }
    public function index()
    {
       $this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
        $data = $this->db->query("  SELECT 
                                        a.*, 
                                        d.no_surat,
                                        e.no_surat AS no_surat_po,
                                        b.no_po,
                                        c.name_suplier,
                                        b.width AS width_po,
                                        f.qty_order AS qty_po,
                                        SUM(f.width_recive) AS incoming,
                                        b.close_po,
                                        b.id_dt_po
                                    FROM dt_trans_pr a 
                                        LEFT JOIN tr_purchase_request d ON a.no_pr=d.no_pr
                                        LEFT JOIN master_supplier c ON a.suplier=c.id_suplier
                                        LEFT JOIN dt_trans_po b ON a.id_dt_pr=b.idpr
                                        LEFT JOIN tr_purchase_order e ON b.no_po=e.no_po
                                        LEFT JOIN dt_incoming f ON f.id_dt_po=b.id_dt_po
                                    WHERE
                                        b.id_dt_po <> ''
                                    GROUP BY b.id_dt_po
                                    ")->result();
        $this->template->set('results', $data);
        $this->template->title('Control PO');
        $this->template->render('index');
    }

    public function modal_detail(){
		$id = $this->uri->segment(3);

		$detail = $this->db->get_where('dt_incoming', array('id_dt_po'=>$id))->result_array();
		$data = [
			'detail' => $detail
		];
        $this->template->set('results', $data);
        $this->template->title('Detail');
        $this->template->render('detail');

    }

    public function close_po(){
		$id_po = $this->input->post('id_po');

		$data = [
			'close_po' => 'Y',
            'close_date' => date('Y-m-d H:i:s'),
			'close_by'=> $this->auth->user_id()
		];

		$this->db->trans_begin();
		    $this->db->where('id_dt_po',$id_po)->update("dt_trans_po",$data);
        $this->db->trans_complete();

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$status	= array(
			  'pesan'		=>'Failed Process Data. Try Again ...',
			  'status'	=> 0
			);
		} else {
			$this->db->trans_commit();
			$status	= array(
			  'pesan'		=>'Success Process Data. Thanks ...',
			  'status'	=> 1
			);
		}
  		echo json_encode($status);
	}

}

?>