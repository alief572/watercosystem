<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * @author Harboens
 * @copyright Copyright (c) 2022
 *
 * This is controller for Request Payment
 */

$status = array();
class Request_payment extends Admin_Controller
{

	//Permission
	protected $viewPermission   = "Request_Payment.View";
	protected $addPermission    = "Request_Payment.Add";
	protected $managePermission = "Request_Payment.Manage";
	protected $deletePermission = "Request_Payment.Delete";

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('Request_payment/Request_payment_model', 'All/All_model', 'Jurnal_nomor/Jurnal_model'));
		$this->template->title('Manage Request Payment');
		$this->template->page_icon('fa fa-table');
		$this->status = array("0" => "Baru", "1" => "Disetujui", "2" => "Selesai");
		date_default_timezone_set("Asia/Bangkok");
	}

	public function index()
	{
		$data = $this->Request_payment_model->GetListDataRequest();
		$this->template->set('data', $data);
		$this->template->title('Request Payment');
		$this->template->render('index');
	}
	public function save_request()
	{
		$status	= $this->input->post("status");
		$this->db->trans_begin();
		if (!empty($status)) {
			foreach ($status as $val) {
				$tipe = $this->input->post("tipe_" . $val);
				$no_doc = $this->input->post("no_doc_" . $val);
				$data =  array(
					'no_doc' => $no_doc,
					'nama' => $this->input->post("nama_" . $val),
					'tgl_doc' => $this->input->post("tgl_doc_" . $val),
					'tanggal' => $this->input->post("tanggal_" . $val),
					'keperluan' => $this->input->post("keperluan_" . $val),
					'tipe' => $tipe,
					'jumlah' => $this->input->post("jumlah_" . $val),
					'ids' => $this->input->post("ids_" . $val),
					'status' => 0,
					'bank_id' => $this->input->post("bank_id_" . $val),
					'accnumber' => $this->input->post("accnumber_" . $val),
					'accname' => $this->input->post("accname_" . $val),
					'created_by' => $this->auth->user_name(),
					'created_on' => date("Y-m-d h:i:s"),
				);
				$idreq = $this->All_model->dataSave(DBERP . '.request_payment', $data);
				if ($tipe == 'transportasi') {
					$this->All_model->dataUpdate(DBERP . '.tr_transport_req', array('status' => 2), array('no_doc' => $no_doc));
				}
				if ($tipe == 'kasbon') {
					$this->All_model->dataUpdate(DBERP . '.tr_kasbon', array('status' => 2), array('no_doc' => $no_doc));
				}
				if ($tipe == 'expense') {
					$this->All_model->dataUpdate(DBERP . '.tr_expense', array('status' => 2), array('no_doc' => $no_doc));
				}
				if ($tipe == 'nonpo') {
					$this->All_model->dataUpdate(DBERP . '.tr_non_po_header', array('status' => 4), array('no_doc' => $no_doc));
				}
				if ($tipe == 'periodik') {
					$this->All_model->dataUpdate(DBERP . '.tr_pengajuan_rutin_detail', array('id_payment' => $idreq), array('no_doc' => $no_doc, 'id' => $this->input->post("ids_" . $val)));
				}
			}
		}
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$result = false;
		} else {
			$this->db->trans_commit();
			$result = true;
		}
		$param = array(
			'save' => $result
		);
		echo json_encode($param);
	}
	public function list_approve()
	{
		$data = $this->Request_payment_model->GetListDataApproval('status!=2');
		$this->template->set('data', $data);
		$this->template->title('Request Payment Approval');
		$this->template->render('list_approve');
	}

	/* 
	##########
	# Updated by Hikmat A.R 15-08-2022
	##########
	*/

	public function approval_payment($type = null, $id = null)
	{
		$type 	= $_GET['type'];
		$id 	= $_GET['id'];
		$this->template->title('Approval Payment');

		/* Expense */
		if (isset($type) && $type == 'expense') {
			$data 			= $this->db->get_where('tr_expense', ['id' => $id])->row();
			$data_detail	= $this->db->get_where('tr_expense_detail', ['no_doc' => $data->no_doc])->result();
		}

		/* Kasbon */
		if (isset($type) && $type == 'kasbon') {
			$data 			= $this->db->get_where('tr_kasbon', ['id' => $id])->row();
			$data_detail	= $this->db->get_where('tr_kasbon', ['no_doc' => $data->no_doc])->result();
		}

		/* Transportasi */
		if (isset($type) && $type == 'transportasi') {
			$data 			= $this->db->get_where('tr_transport_req', ['id' => $id])->row();
			$data_detail	= $this->db->get_where('tr_transport', ['no_req' => $data->no_doc])->result();
		}

		/* NON PO */
		if (isset($type) && $type == 'nonpo') {
			$data 			= $this->db->get_where('tr_non_po_header', ['id' => $id])->row();
			$data_detail	= $this->db->get_where('tr_non_po_detail', ['no_doc' => $data->no_doc])->result();
		}

		/* Periodik/Rutin */
		if (isset($type) && $type == 'periodik') {
			$data 			= $this->db->get_where('tr_pengajuan_rutin_detail', ['id' => $id])->row();
			$data_detail	= $this->db->get_where('tr_pengajuan_rutin_detail', ['no_doc' => $data->no_doc])->result();
		}

		// $data_budget 	= $this->All_model->GetComboBudget('', 'EXPENSE', date('Y'));
		// $data_pc 		= $this->All_model->GetPettyCashCombo();

		// $this->template->set('data_pc', $data_pc);
		// $this->template->set('data_budget', $data_budget);
		// $this->template->set('data_detail', $data_detail);
		// $this->template->set('status', $this->status);
		// $this->template->set('data', $data);
		// $this->template->set('stsview', 'view');



		$this->template->set([
			'type'		 => $type,
			'header'	 => $data,
			'details' 	=> $data_detail,
		]);
		$this->template->render('detail_approve');
	}


	/* public function save_approval()
	{
		$status	= $this->input->post("status");
		$this->db->trans_begin();
		if (!empty($status)) {
			foreach ($status as $val) {
				$data =  array(
					'status' => 1,
					'approved_by' => $this->auth->user_name(),
					'approved_on' => date("Y-m-d h:i:s"),
				);
				$this->All_model->dataUpdate(DBERP . '.request_payment', $data, array('id' => $val));
			}
		}
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$result = false;
		} else {
			$this->db->trans_commit();
			$result = true;
		}
		$param = array(
			'save' => $result
		);
		echo json_encode($param);
	} */


	/* 
	Update by Hikmat A.R (16/08)
	*/
	private function _getIdPayment($date)
	{
		$count 		= 1;
//		$m 			= date_format(date_create($date), 'm');
		$y 			= date_format(date_create($date), 'Y');
		
		$sql 		= "SELECT count(id) as max_id FROM payment_approve where YEAR(tgl_doc) = '$y'";
		$max_id 	= $this->db->query($sql)->row()->max_id;

		if ($max_id > 0) {
			$max_id = (int)$max_id;
			$count 	= $max_id + 1;
		}
		$new_id  	= 'PAY' .$y. str_pad($count, 5, '0', STR_PAD_LEFT);
		return  $new_id;
	}


	private function _getIdDetail($payment_id)
	{
		$count 		= 1;
		$sql 		= "SELECT MAX(RIGHT(id,2)) as max_id FROM payment_approve_details where payment_id = '$payment_id'";
		$max_id 	= $this->db->query($sql)->row()->max_id;

		if ($max_id > 0) {
			$count 	= $max_id + 1;
		}

		// $new_id  	= 'PAY' . date('ym') . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);
		return  $count;
	}

	public function save_approval()
	{
		$Data		= $this->input->post();
		$header 	= $this->db->get_where('request_payment', ['ids' => $Data['id']])->row_array();
		$Id 		= $this->_getIdPayment($Data['date']);

		// $detail = 
		$ArrDetail 			= [];
		$idDetail 			= $this->_getIdDetail($Id);

		$n = 0;
		foreach ($Data['item'] as $detail) {
			$n++;
			$idDetail++;
			if ($Data['tipe'] == 'expense') {
				$dtl 				= $this->db->get_where('tr_expense_detail', ['id' => $detail['id']])->row();
				$ArrDetail[] 		= [
					'id' 			=> $Id . "-" . str_pad($idDetail, 2, '0', STR_PAD_LEFT),
					'payment_id' 	=> $Id,
					'no_doc' 		=> $dtl->no_doc,
					'tgl_doc' 		=> $dtl->tanggal,
					'deskripsi' 	=> $dtl->deskripsi,
					'qty' 			=> $dtl->qty,
					'harga' 		=> $dtl->harga,
					'total' 		=> $dtl->total_harga,
					'keterangan' 	=> $dtl->keterangan,
					'doc_file' 		=> $dtl->doc_file,
					'coa' 			=> $dtl->coa,
					'created_by' 	=> $this->auth->user_name(),
					'created_on' 	=> date("Y-m-d h:i:s"),
				];
				$updateExpense[] = [
					'id' 			=> $dtl->id,
					'status' 		=> '1',
					'modified_by' 	=> $this->auth->user_name(),
					'modified_on' 	=> date("Y-m-d h:i:s"),
				];
				$Harga[] 		= $dtl->total_harga;
			}

			if ($Data['tipe'] == 'kasbon') {
				$dtl 				= $this->db->get_where('tr_kasbon', ['id' => $detail['id']])->row();

				$ArrDetail[] 		= [
					'id' 			=> $Id . "-" . str_pad($idDetail, 2, '0', STR_PAD_LEFT),
					'payment_id' 	=> $Id,
					'no_doc' 		=> $dtl->no_doc,
					'tgl_doc' 		=> $dtl->tgl_doc,
					'deskripsi' 	=> $dtl->keperluan,
					'qty' 			=> '1',
					'harga' 		=> $dtl->jumlah_kasbon,
					'total' 		=> $dtl->jumlah_kasbon,
					'keterangan' 	=> $dtl->keperluan,
					'doc_file' 		=> $dtl->doc_file,
					'coa' 			=> $dtl->coa,
					'created_by' 	=> $this->auth->user_name(),
					'created_on' 	=> date("Y-m-d h:i:s"),
				];
				$updateDetail[] = [
					'id' 			=> $dtl->id,
					'status' 		=> '3',
					'modified_by' 	=> $this->auth->user_name(),
					'modified_on' 	=> date("Y-m-d h:i:s"),
				];
				$Harga[] 		= $dtl->jumlah_kasbon;
			}

			if ($Data['tipe'] == 'transportasi') {
				$dtl 				= $this->db->get_where('tr_transport', ['id' => $detail['id']])->row();
				$ArrDetail[] 		= [
					'id' 			=> $Id . "-" . str_pad($idDetail, 2, '0', STR_PAD_LEFT),
					'payment_id' 	=> $Id,
					'no_doc' 		=> $dtl->no_req,
					'tgl_doc' 		=> $dtl->tgl_doc,
					'deskripsi' 	=> $dtl->keperluan,
					'qty' 			=> '1',
					'harga' 		=> $dtl->jumlah_kasbon,
					'total' 		=> $dtl->jumlah_kasbon,
					'keterangan' 	=> $dtl->keperluan,
					'doc_file' 		=> $dtl->doc_file,
					'coa' 			=> null,
					'created_by' 	=> $this->auth->user_name(),
					'created_on' 	=> date("Y-m-d h:i:s"),
				];
				$updateDetail[] = [
					'id' 			=> $dtl->id,
					'status' 		=> '2',
					'modified_by' 	=> $this->auth->user_name(),
					'modified_on' 	=> date("Y-m-d h:i:s"),
				];
				$Harga[] 		= $dtl->jumlah_kasbon;
			}

			if ($Data['tipe'] == 'nonpo') {
				$dtl 				= $this->db->get_where('tr_non_po_detail', ['id' => $detail['id']])->row();

				$ArrDetail[] 		= [
					'id' 			=> $Id . "-" . str_pad($idDetail, 2, '0', STR_PAD_LEFT),
					'payment_id' 	=> $Id,
					'no_doc' 		=> $dtl->no_doc,
					'tgl_doc' 		=> $dtl->tgl_pr,
					'deskripsi' 	=> $dtl->deskripsi,
					'qty' 			=> '1',
					'harga' 		=> $dtl->nilai_satuan_request,
					'total' 		=> $dtl->total_request,
					'keterangan' 	=> $dtl->keterangan,
					// 'doc_file' 		=> $dtl->doc_file,
					'coa' 			=> null,
					'created_by' 	=> $this->auth->user_name(),
					'created_on' 	=> date("Y-m-d h:i:s"),
				];

				$updateDetail[] = [
					'id' 			=> $dtl->id,
					'status' 		=> '1',
					'modified_by' 	=> $this->auth->user_name(),
					'modified_on' 	=> date("Y-m-d h:i:s"),
				];
				$Harga[] 		= $dtl->total_request;
			}

			if ($Data['tipe'] == 'periodik') {
				$dtl 				= $this->db->get_where('tr_pengajuan_rutin_detail', ['id' => $detail['id']])->row();

				$ArrDetail[] 		= [
					'id' 			=> $Id . "-" . str_pad($idDetail, 2, '0', STR_PAD_LEFT),
					'payment_id' 	=> $Id,
					'no_doc' 		=> $dtl->no_doc,
					'tgl_doc' 		=> $dtl->tanggal,
					'deskripsi' 	=> $dtl->keterangan,
					'qty' 			=> '1',
					'harga' 		=> $dtl->nilai,
					'total' 		=> $dtl->nilai,
					'keterangan' 	=> $dtl->keterangan,
					'doc_file' 		=> $dtl->doc_file,
					'coa' 			=> $dtl->coa,
					'created_by' 	=> $this->auth->user_name(),
					'created_on' 	=> date("Y-m-d h:i:s"),
				];

				$updateDetail[] = [
					'id' 			=> $dtl->id,
					'status' 		=> '1',
					'modified_by' 	=> $this->auth->user_name(),
					'modified_on' 	=> date("Y-m-d h:i:s"),
				];
				$Harga[] 		= $dtl->nilai;
			}
		}


		$header['jumlah'] 	= array_sum($Harga);
		$header['status'] 	= '1';

		$this->db->trans_rollback();
		$this->db->trans_begin();

		if (($header)) {
			$header['id'] = $Id;
			$header['approved_by'] = $this->auth->user_name();
			$header['approved_on'] = date("Y-m-d h:i:s");
			$exist_data = $this->db->get_where('payment_approve', ['ids' => $Data['id']])->num_rows();
			if ($exist_data == '0') {
				$this->db->insert(DBERP . '.payment_approve', $header);
			}
		}

		/* Details */
		if ($ArrDetail) {
			if ($Data['tipe'] == 'expense') {
				$this->db->insert_batch(DBERP . '.payment_approve_details', $ArrDetail);
				$this->db->update_batch(DBERP . '.tr_expense_detail', $updateExpense, 'id');

				// Update request_payment
				$countData 		= $this->db->get_where('tr_expense_detail', ['no_doc' => $header['no_doc']])->num_rows();
				$actualPayment 	= $this->db->get_where('tr_expense_detail', ['no_doc' => $header['no_doc'], 'status >=' => '1'])->num_rows();

				if ($countData > $actualPayment) {
					$this->db->update('request_payment', ['status' => '1'], ['ids' => $Data['id']]);
				} elseif (($countData == $actualPayment)) {
					$this->db->update('request_payment', ['status' => '2'], ['ids' => $Data['id']]);
				}
			}

			if ($Data['tipe'] == 'kasbon') {
				$this->db->insert_batch(DBERP . '.payment_approve_details', $ArrDetail);
				$this->db->update_batch(DBERP . '.tr_kasbon', $updateDetail, 'id');

				// Update request_payment
				$countData 		= $this->db->get_where('tr_kasbon', ['no_doc' => $header['no_doc']])->num_rows();
				$actualPayment 	= $this->db->get_where('tr_kasbon', ['no_doc' => $header['no_doc'], 'status >=' => '3'])->num_rows();

				if ($countData > $actualPayment) {
					$this->db->update('request_payment', ['status' => '1'], ['ids' => $Data['id']]);
				} elseif (($countData == $actualPayment)) {
					$this->db->update('request_payment', ['status' => '2'], ['ids' => $Data['id']]);
				}
			}

			if ($Data['tipe'] == 'transportasi') {
				$this->db->insert_batch(DBERP . '.payment_approve_details', $ArrDetail);
				$this->db->update_batch(DBERP . '.tr_transport', $updateDetail, 'id');

				// Update request_payment
				$countData 		= $this->db->get_where('tr_transport', ['no_doc' => $header['no_doc']])->num_rows();
				$actualPayment 	= $this->db->get_where('tr_transport', ['no_doc' => $header['no_doc'], 'status >=' => '2'])->num_rows();

				if ($countData > $actualPayment) {
					$this->db->update('request_payment', ['status' => '1'], ['ids' => $Data['id']]);
				} elseif (($countData == $actualPayment)) {
					$this->db->update('request_payment', ['status' => '2'], ['ids' => $Data['id']]);
				}
			}

			if ($Data['tipe'] == 'nonpo') {
				$this->db->insert_batch(DBERP . '.payment_approve_details', $ArrDetail);
				$this->db->update_batch(DBERP . '.tr_non_po_detail', $updateDetail, 'id');

				// Update request_payment
				$countData 		= $this->db->get_where('tr_non_po_detail', ['no_doc' => $header['no_doc']])->num_rows();
				$actualPayment 	= $this->db->get_where('tr_non_po_detail', ['no_doc' => $header['no_doc'], 'status >=' => '1'])->num_rows();

				if ($countData > $actualPayment) {
					$this->db->update('request_payment', ['status' => '1'], ['ids' => $Data['id']]);
				} elseif (($countData == $actualPayment)) {
					$this->db->update('request_payment', ['status' => '2'], ['ids' => $Data['id']]);
				}
			}

			if ($Data['tipe'] == 'periodik') {
				$this->db->insert_batch(DBERP . '.payment_approve_details', $ArrDetail);
				$this->db->update_batch(DBERP . '.tr_pengajuan_rutin_detail', $updateDetail, 'id');

				// Update request_payment
				$countData 		= $this->db->get_where('tr_pengajuan_rutin_detail', ['no_doc' => $header['no_doc']])->num_rows();
				$actualPayment 	= $this->db->get_where('tr_pengajuan_rutin_detail', ['no_doc' => $header['no_doc'], 'status >=' => '1'])->num_rows();

				if ($countData > $actualPayment) {
					$this->db->update('request_payment', ['status' => '1'], ['ids' => $Data['id']]);
				} elseif (($countData == $actualPayment)) {
					$this->db->update('request_payment', ['status' => '2'], ['ids' => $Data['id']]);
				}
			}
		}

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$result = false;
		} else {
			$this->db->trans_commit();
			$result = true;
		}
		$param = array(
			'save' => $result
		);

		echo json_encode($param);
	}
	public function list_payment()
	{
		$data_coa = $this->All_model->GetCoaCombo();
		$results = $this->Request_payment_model->GetListDataPayment('status!=2');
		$this->template->set('data_coa', $data_coa);
		$this->template->set('results', $results);
		$this->template->title('Payment');
		$this->template->render('list_payment');
	}

	public function save_payment()
	{
		$bank_coa		= $this->input->post("bank_coa");
		$keterangan		= $this->input->post("keterangan");
		$bank_nilai		= $this->input->post("bank_nilai");
		$bank_admin		= $this->input->post("bank_admin");
		$status			= $this->input->post("status");
		$no_doc			= $this->input->post("no_doc");
		$keperluan		= $this->input->post("keperluan");
		$tipe			= $this->input->post("tipe");
		$nama			= $this->input->post("nama");
		$ids			= $this->input->post("ids");
		$this->db->trans_begin();
		$jenis_jurnal = 'BUK030';
		$payment_date = date("Y-m-d");
		$det_Jurnaltes1 = array();
		$ix = 0;
		$config['upload_path'] = './assets/expense/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp|pdf|doc|docx|jfif';
		$config['remove_spaces'] = TRUE;
		$config['encrypt_name'] = TRUE;

		if (!empty($status)) {
			foreach ($status as $keys => $val) {
				if ($bank_nilai[$keys] <> 0) {
					$filenames = "";
					if (!empty($_FILES['doc_file_' . $val]['name'])) {
						$_FILES['file']['name'] = $_FILES['doc_file_' . $val]['name'];
						$_FILES['file']['type'] = $_FILES['doc_file_' . $val]['type'];
						$_FILES['file']['tmp_name'] = $_FILES['doc_file_' . $val]['tmp_name'];
						$_FILES['file']['error'] = $_FILES['doc_file_' . $val]['error'];
						$_FILES['file']['size'] = $_FILES['doc_file_' . $val]['size'];
						$this->load->library('upload', $config);
						$this->upload->initialize($config);
						if ($this->upload->do_upload('file')) {
							$uploadData = $this->upload->data();
							$filenames = $uploadData['file_name'];
						}
					}
					$ix++;
					$nomor_jurnal = $jenis_jurnal . date("ymd") . rand(1000, 9999) . $ix;
					$data =  array(
						'keterangan' => $keterangan[$keys],
						'bank_nilai' => $bank_nilai[$keys],
						'bank_admin' => $bank_admin[$keys],
						'bank_coa' => $bank_coa,
						'doc_file' => $filenames,
						'status' => 2,
						'pay_by' => $this->auth->user_name(),
						'pay_on' => date("Y-m-d h:i:s"),
					);

					$this->All_model->dataUpdate(DBERP . '.payment_approve', $data, array('id' => $val));

					if ($tipe[$keys] == 'transportasi') {
						$rec = $this->db->query("select * from " . DBACC . ".master_oto_jurnal_detail where kode_master_jurnal='" . $jenis_jurnal . "' and menu='" . $tipe[$keys] . "'")->row();
						$det_Jurnaltes1[] = array(
							'nomor' => $nomor_jurnal, 'tanggal' => $payment_date, 'tipe' => 'BUK', 'no_perkiraan' => $rec->no_perkiraan, 'keterangan' => $keterangan[$keys], 'no_request' => $no_doc[$keys], 'debet' => $bank_nilai[$keys], 'kredit' => 0, 'no_reff' =>  $no_doc[$keys], 'jenis_jurnal' => $jenis_jurnal, 'nocust' => $nama[$keys]
						);
						if ($bank_admin[$keys] > 0) {
							$rec = $this->db->query("select * from " . DBACC . ".master_oto_jurnal_detail where kode_master_jurnal='" . $jenis_jurnal . "' and menu='admin'")->row();
							$det_Jurnaltes1[] = array(
								'nomor' => $nomor_jurnal, 'tanggal' => $payment_date, 'tipe' => 'BUK', 'no_perkiraan' => $rec->no_perkiraan, 'keterangan' => $keterangan[$keys], 'no_request' => $no_doc[$keys], 'debet' =>  $bank_admin[$keys], 'kredit' => 0, 'no_reff' =>  $no_doc[$keys], 'jenis_jurnal' => $jenis_jurnal, 'nocust' => $nama[$keys]
							);
						}
					}
					if ($tipe[$keys] == 'kasbon') {
						$rec = $this->db->query("select * from " . DBACC . ".master_oto_jurnal_detail where kode_master_jurnal='" . $jenis_jurnal . "' and menu='" . $tipe[$keys] . "'")->row();
						$det_Jurnaltes1[] = array(
							'nomor' => $nomor_jurnal, 'tanggal' => $payment_date, 'tipe' => 'BUK', 'no_perkiraan' => $rec->no_perkiraan, 'keterangan' => $keterangan[$keys], 'no_request' => $no_doc[$keys], 'debet' => $bank_nilai[$keys], 'kredit' => 0, 'no_reff' =>  $no_doc[$keys], 'jenis_jurnal' => $jenis_jurnal, 'nocust' => $nama[$keys]
						);
						if ($bank_admin[$keys] > 0) {
							$rec = $this->db->query("select * from " . DBACC . ".master_oto_jurnal_detail where kode_master_jurnal='" . $jenis_jurnal . "' and menu='admin'")->row();
							$det_Jurnaltes1[] = array(
								'nomor' => $nomor_jurnal, 'tanggal' => $payment_date, 'tipe' => 'BUK', 'no_perkiraan' => $rec->no_perkiraan, 'keterangan' => $keterangan[$keys], 'no_request' => $no_doc[$keys], 'debet' =>  $bank_admin[$keys], 'kredit' => 0, 'no_reff' =>  $no_doc[$keys], 'jenis_jurnal' => $jenis_jurnal, 'nocust' => $nama[$keys]
							);
						}
					}

					if ($tipe[$keys] == 'expense') {
						$rec = $this->db->query("select * from " . DBERP . ".tr_expense_detail where no_doc='" . $no_doc[$keys] . "' and status = '1'")->result();
						// $rec = $this->db->get_where('payment_approve_details', ['payment_id' => $val])->result();
						$this->db->update('tr_expense_detail', ['status' => '2'], ['no_doc' => $no_doc[$keys], 'status' => '1']);
						foreach ($rec as $record) {
							if ($record->id_kasbon != '') {
								$det_Jurnaltes1[] = array(
									'nomor' => $nomor_jurnal, 'tanggal' => $payment_date, 'tipe' => 'BUK', 'no_perkiraan' => $record->coa, 'keterangan' => $keterangan[$keys], 'no_request' => $no_doc[$keys], 'debet' => 0, 'kredit' => $record->kasbon, 'no_reff' =>  $no_doc[$keys], 'jenis_jurnal' => $jenis_jurnal, 'nocust' => $nama[$keys]
								);
							} else {
								$det_Jurnaltes1[] = array(
									'nomor' => $nomor_jurnal, 'tanggal' => $payment_date, 'tipe' => 'BUK', 'no_perkiraan' => $record->coa, 'keterangan' => $keterangan[$keys], 'no_request' => $no_doc[$keys], 'debet' => $record->expense, 'kredit' => 0, 'no_reff' =>  $no_doc[$keys], 'jenis_jurnal' => $jenis_jurnal, 'nocust' => $nama[$keys]
								);
							}
						}
						if ($bank_admin[$keys] > 0) {
							$rec = $this->db->query("select * from " . DBACC . ".master_oto_jurnal_detail where kode_master_jurnal='" . $jenis_jurnal . "' and menu='admin'")->row();
							$det_Jurnaltes1[] = array(
								'nomor' => $nomor_jurnal, 'tanggal' => $payment_date, 'tipe' => 'BUK', 'no_perkiraan' => $rec->no_perkiraan, 'keterangan' => $keterangan[$keys], 'no_request' => $no_doc[$keys], 'debet' =>  $bank_admin[$keys], 'kredit' => 0, 'no_reff' =>  $no_doc[$keys], 'jenis_jurnal' => $jenis_jurnal, 'nocust' => $nama[$keys]
							);
						}
					}

					if ($tipe[$keys] == 'nonpo') {
						$rec = $this->db->query("select * from " . DBACC . ".master_oto_jurnal_detail where kode_master_jurnal='" . $jenis_jurnal . "' and menu='" . $tipe[$keys] . "'")->row();
						$det_Jurnaltes1[] = array(
							'nomor' => $nomor_jurnal, 'tanggal' => $payment_date, 'tipe' => 'BUK', 'no_perkiraan' => $rec->no_perkiraan, 'keterangan' => $keterangan[$keys], 'no_request' => $no_doc[$keys], 'debet' => $bank_nilai[$keys], 'kredit' => 0, 'no_reff' =>  $no_doc[$keys], 'jenis_jurnal' => $jenis_jurnal, 'nocust' => $nama[$keys]
						);
						if ($bank_admin[$keys] > 0) {
							$rec = $this->db->query("select * from " . DBACC . ".master_oto_jurnal_detail where kode_master_jurnal='" . $jenis_jurnal . "' and menu='admin'")->row();
							$det_Jurnaltes1[] = array(
								'nomor' => $nomor_jurnal, 'tanggal' => $payment_date, 'tipe' => 'BUK', 'no_perkiraan' => $rec->no_perkiraan, 'keterangan' => $keterangan[$keys], 'no_request' => $no_doc[$keys], 'debet' =>  $bank_admin[$keys], 'kredit' => 0, 'no_reff' =>  $no_doc[$keys], 'jenis_jurnal' => $jenis_jurnal, 'nocust' => $nama[$keys]
							);
						}
					}

					if ($tipe[$keys] == 'periodik') {
						$rec = $this->db->query("select coa from " . DBERP . ".tr_pengajuan_rutin_detail where id='" . $ids[$keys] . "' and no_doc='" . $no_doc[$keys] . "'")->row();
						$det_Jurnaltes1[] = array(
							'nomor' => $nomor_jurnal, 'tanggal' => $payment_date, 'tipe' => 'BUK', 'no_perkiraan' => $rec->coa, 'keterangan' => $keterangan[$keys], 'no_request' => $no_doc[$keys], 'debet' => $bank_nilai[$keys], 'kredit' => 0, 'no_reff' =>  $no_doc[$keys], 'jenis_jurnal' => $jenis_jurnal, 'nocust' => $nama[$keys]
						);
						if ($bank_admin[$keys] > 0) {
							$rec = $this->db->query("select * from " . DBACC . ".master_oto_jurnal_detail where kode_master_jurnal='" . $jenis_jurnal . "' and menu='admin'")->row();
							$det_Jurnaltes1[] = array(
								'nomor' => $nomor_jurnal, 'tanggal' => $payment_date, 'tipe' => 'BUK', 'no_perkiraan' => $rec->no_perkiraan, 'keterangan' => $keterangan[$keys], 'no_request' => $no_doc[$keys], 'debet' =>  $bank_admin[$keys], 'kredit' => 0, 'no_reff' =>  $no_doc[$keys], 'jenis_jurnal' => $jenis_jurnal, 'nocust' => $nama[$keys]
							);
						}
					}


					//bank coa
					$det_Jurnaltes1[] = array(
						'nomor' => $nomor_jurnal, 'tanggal' => $payment_date, 'tipe' => 'BUK', 'no_perkiraan' => $bank_coa, 'keterangan' => $keterangan[$keys], 'no_request' => $no_doc[$keys], 'debet' => ($bank_nilai[$keys] < 0 ? ($bank_nilai[$keys] * -1) : 0), 'kredit' => ($bank_nilai[$keys] >= 0 ? $bank_nilai[$keys] : 0), 'no_reff' =>  $no_doc[$keys], 'jenis_jurnal' => $jenis_jurnal, 'nocust' => $nama[$keys]
					);
					if ($bank_admin[$keys] > 0) {
						$rec = $this->db->query("select * from " . DBACC . ".master_oto_jurnal_detail where kode_master_jurnal='" . $jenis_jurnal . "' and menu='admin'")->row();
						$det_Jurnaltes1[] = array(
							'nomor' => $nomor_jurnal, 'tanggal' => $payment_date, 'tipe' => 'BUK', 'no_perkiraan' => $bank_coa, 'keterangan' => $keterangan[$keys], 'no_request' => $no_doc[$keys], 'debet' => 0, 'kredit' => $bank_admin[$keys], 'no_reff' =>  $no_doc[$keys], 'jenis_jurnal' => $jenis_jurnal, 'nocust' => $nama[$keys]
						);
					}
				}
			}
			$this->db->insert_batch(DBERP . '.jurnal', $det_Jurnaltes1);
		}

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$result = false;
		} else {
			$this->db->trans_commit();
			$result = true;
		}
		$param = array(
			'save' => $result
		);
		echo json_encode($param);
	}

	public function payment_jurnal_list()
	{
		$results = $this->Request_payment_model->GetListDataJurnal();
		$this->template->set('results', $results);
		$this->template->title('Payment Jurnal');
		$this->template->render('list_jurnal');
	}
	public function view_jurnal($id)
	{
		$data = $this->db->query("select * from " . DBERP . ".jurnal where nomor='" . $id . "' order by kredit,debet,no_perkiraan")->result();
		$data_coa = $this->All_model->GetCoaCombo();
		$results = $this->Request_payment_model->GetListDataPayment('status=1');
		$this->template->set('data', $data);
		$this->template->set('datacoa', $data_coa);
		$this->template->set('results', $results);
		$this->template->set('status', 'view');
		$this->template->title('Payment Jurnal');
		$this->template->render('form_jurnal');
	}
	public function edit_jurnal($id)
	{
		$data = $this->db->query("select * from " . DBERP . ".jurnal where nomor='" . $id . "' order by kredit,debet,no_perkiraan")->result();
		$data_coa = $this->All_model->GetCoaCombo();
		$results = $this->Request_payment_model->GetListDataPayment('status=1');
		$this->template->set('data', $data);
		$this->template->set('datacoa', $data_coa);
		$this->template->set('status', 'edit');
		$this->template->title('Payment Jurnal');
		$this->template->render('form_jurnal');
	}
	public function jurnal_save()
	{
		$id = $this->input->post("id");
		$no_perkiraan = $this->input->post("no_perkiraan");
		$keterangan = $this->input->post("keterangan");
		$debet = $this->input->post("debet");
		$kredit = $this->input->post("kredit");

		$tanggal		= $this->input->post('tanggal');
		$tipe			= $this->input->post('tipe');
		$no_reff        = $this->input->post('no_reff');
		$no_request		= $this->input->post('no_request');
		$jenis_jurnal	= $this->input->post('jenis_jurnal');
		$nocust         = $this->input->post('nocust');
		$total			= 0;
		$total_po		= $this->input->post('total_po');
		$Bln 			= substr($tanggal, 5, 2);
		$Thn 			= substr($tanggal, 0, 4);
		$Nomor_JV = $this->Jurnal_model->get_no_buk('101');
		$session = $this->session->userdata('app_session');
		$data_session	= $this->session->userdata;

		$this->db->trans_begin();
		for ($i = 0; $i < count($id); $i++) {
			$dataheader =  array(
				'stspos' => "1",
				'no_perkiraan' => $no_perkiraan[$i],
				'keterangan' => $keterangan[$i],
				'debet' => $debet[$i],
				'kredit' => $kredit[$i]
			);
			$total = ($total + $debet[$i]);
			$this->All_model->DataUpdate(DBERP . '.jurnal', $dataheader, array('id' => $id[$i]));

			$datadetail = array(
				'tipe'        	=> $tipe,
				'nomor'       	=> $Nomor_JV,
				'tanggal'     	=> $tanggal,
				'no_reff'     	=> $no_reff,
				'no_perkiraan'	=> $no_perkiraan[$i],
				'keterangan' 	=> $keterangan[$i],
				'debet' 		=> $debet[$i],
				'kredit' 		=> $kredit[$i]
			);
			$this->db->insert(DBACC . '.jurnal', $datadetail);
		}

		$keterangan	= 'Payment';
		$dataJVhead = array(
			'nomor' 	    	=> $Nomor_JV,
			'tgl'	         	=> $tanggal,
			'jml'	            => $total,
			'kdcab'				=> '101',
			'jenis_reff'	    => 'BUK',
			'no_reff' 		    => $no_reff,
			'jenis_ap'			=> 'V',
			'note'				=> $keterangan,
			'user_id'			=> $this->auth->user_name(),
			'ho_valid'			=> '',
			'batal'			    => '0'
		);
		$this->db->insert(DBACC . '.japh', $dataJVhead);
		$Qry_Update_Cabang_acc	 = "UPDATE " . DBACC . ".pastibisa_tb_cabang SET nobuk=nobuk + 1 WHERE nocab='101'";
		$this->db->query($Qry_Update_Cabang_acc);

		$this->db->trans_complete();
		if ($this->db->trans_status()) {
			$this->db->trans_commit();
			$result         = TRUE;
		} else {
			$this->db->trans_rollback();
			$result = FALSE;
		}
		$param = array(
			'save' => $result
		);
		echo json_encode($param);
	}
}
