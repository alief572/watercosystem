<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/*
 * @author Syamsudin
 * @copyright Copyright (c) 2023
 *
 * This is controller for Master Warehouse
 */

	class Approval extends Admin_Controller
	{
		//Permission
		protected $viewPermission 	= 'Approval_Direktur.View';
		protected $addPermission  	= 'Approval_Direktur.Add';
		protected $managePermission = 'Approval_Direktur.Manage';
		protected $deletePermission = 'Approval_Direktur.Delete';
		public function __construct() {
			parent::__construct();
			$this->load->model(array('Approval/Approval_model','All/All_model','Aktifitas/aktifitas_model',));
			$this->template->title('Approval');
			$this->template->page_icon('fa fa-checklist');
			date_default_timezone_set('Asia/Bangkok');
	 }

	public function index_approval()
    {
        $this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$status =1;
		$this->template->page_icon('fa fa-users');
        $data = $this->Approval_model->CariPenawaranApproval();
        $this->template->set('results', $data);
        $this->template->title('Request Approval Penawaran');
        $this->template->render('index_approval');
    }
}