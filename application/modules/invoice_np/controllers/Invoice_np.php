<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Invoice_np extends Admin_Controller
{

	//Permission
	protected $viewPermission 	= 'Penjualan_Non_Product.View';
	protected $addPermission  	= 'Penjualan_Non_Product.Add';
	protected $managePermission = 'Penjualan_Non_Product.Manage';
	protected $deletePermission = 'Penjualan_Non_Product.Delete';


	public function __construct()
	{
		parent::__construct();
		//$this->load->model('master_model');
		$this->load->model('Invoice_np/Invoice_np_model');
		$this->load->model('All/All_model');
		$this->load->model('jurnal_nomor/Acc_model');
		$this->load->model('jurnal_nomor/Jurnal_model');
		$this->load->database();
		// if(!$this->session->userdata('isORIlogin')){
		// redirect('login');
		// }
	}

	public function index()
	{
		$this->auth->restrict($this->viewPermission);
		$session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
		$data = $this->Invoice_np_model->CariInvoice();
		$this->template->set('results', $data);
		$this->template->title('Invoice');
		$this->template->render('index_invoice');

		history('View Invoice Non Product');
	}

	public function server_side_data()
	{
		$controller	= 'invoice_np';
		$Arr_Akses	= getAcccesmenu($controller);
		$requestData	= $_REQUEST;
		$fetch	= $this->query_data_json_invoicenp(
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
		foreach ($query->result_array() as $row) {
			$total_data     = $totalData;
			$start_dari     = $requestData['start'];
			$asc_desc       = $requestData['order'][0]['dir'];
			if ($asc_desc == 'asc') {
				$nomor = $urut1 + $start_dari;
			}
			if ($asc_desc == 'desc') {
				$nomor = ($total_data - $start_dari) - $urut2;
			}
			$printX = '';
			$updX = '';
			$ajukan = '';
			$delX = '';
			$nestedData 	= array();
			$nestedData[]	= "<div align='center'>" . $nomor . "</div>";
			$nestedData[]	= "<div>" . $row['no_invoice'] . "</div>";
			$nestedData[]	= "<div>" . $row['tgl_invoice'] . "</div>";
			$nestedData[]	= "<div>" . $row['no_faktur'] . "</div>";
			$nestedData[]	= "<div>" . $row['keterangan'] . "</div>";
			$nestedData[]	= "<div>" . $row['nm_customer'] . "</div>";
			$nestedData[]	= "<div align='right'>" . $row['base_cur'] . " " . number_format($row['total_invoice_usd'], 2) . "</div>";
			//$class = Color_status($row['status']);
			if ($row['status'] == '0') {
				if ($Arr_Akses['update'] == '1') {
					$updX	= "<button type='button' class='btn btn-sm btn-primary edited' title='Edit' data-iddata='" . $row['id_invoice'] . "'><i class='fa fa-edit'></i></button>";
					$ajukan	= "<button type='button' class='btn btn-sm btn-info updated' title='Update' data-iddata='" . $row['id_invoice'] . "'><i class='fa fa-check'></i></button>";
				}
				if ($Arr_Akses['delete'] == '1') {
					$delX	= "<button type='button' class='btn btn-sm btn-danger deleted' title='Delete' data-iddata='" . $row['id_invoice'] . "'><i class='fa fa-close'></i></button>";
				}
			} else {
				$printX	= "<a href='invoice_np/print_pdf/" . $row['id_invoice'] . "' class='btn btn-sm btn-success printed' title='Print' data-iddata='" . $row['id_invoice'] . "' target='_blank'><i class='fa fa-print'></i></a>";
			}
			$nestedData[]	= "<div align='left'>
									<button type='button' data-iddata='" . $row['id_invoice'] . "' class='btn btn-sm btn-warning viewed' title='View' data-role='qtip'><i class='fa fa-eye'></i></button>
									" . $printX . "
									" . $updX . "
									" . $ajukan . "
									" . $delX . "
								</div>";
			$data[] = $nestedData;
			$urut1++;
			$urut2++;
		}

		$json_data = array(
			"draw"            	=> intval($requestData['draw']),
			"recordsTotal"    	=> intval($totalData),
			"recordsFiltered" 	=> intval($totalFiltered),
			"data"            	=> $data
		);
		echo json_encode($json_data);
	}

	public function query_data_json_invoicenp($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{

		$where = "";

		$sql = "
			SELECT
				(@row:=@row+1) AS nomor,
				a.*
			FROM
				tr_invoice_np_header a,
				(SELECT @row:=0) r
		    WHERE 1=1 " . $where . " AND (
				a.no_invoice LIKE '%" . $this->db->escape_like_str($like_value) . "%'
				OR a.nm_customer LIKE '%" . $this->db->escape_like_str($like_value) . "%'
				OR a.jenis_invoice LIKE '%" . $this->db->escape_like_str($like_value) . "%'
	        )
		";
		$data['totalData'] = $this->db->query($sql)->num_rows();
		$data['totalFiltered'] = $this->db->query($sql)->num_rows();
		$columns_order_by = array(
			0 => 'id_invoice',
			1 => 'no_invoice',
			2 => 'nm_customer',
			3 => 'jenis_invoice'
		);

		$sql .= " ORDER BY " . $columns_order_by[$column_order] . " " . $column_dir . " ";
		$sql .= " LIMIT " . $limit_start . " ," . $limit_length . " ";

		$data['query'] = $this->db->query($sql);
		return $data;
	}

	function print_pdf($id)
	{
		$sroot 		= $_SERVER['DOCUMENT_ROOT'];
		include $sroot . "watercosystem/application/libraries/MPDF57/mpdf.php";
		$data_session	= $this->session->userdata;
		$mpdf		= new mPDF('utf-8', 'A4');
		$mpdf->SetImportUse();
		$gethd 		= $this->db->query("SELECT * FROM tr_invoice_np_header WHERE id_invoice='$id'")->row();
		$getdtl		= $this->db->query("SELECT * FROM tr_invoice_np_detail WHERE no_invoice='$gethd->no_invoice'")->result();
		$nomordoc	= $gethd->no_invoice;
		$tgl       	= $gethd->tgl_invoice;
		$Jml_Ttl   	= $gethd->total_invoice;
		$Id_klien   = $gethd->id_customer;
		$Nama_klien = $gethd->nm_customer;
		$Bln 		= substr($tgl, 5, 2);
		$Thn 		= substr($tgl, 0, 4);

		$customer 	= $this->db->query("SELECT * FROM master_customers WHERE id_customer = '" . $gethd->id_customer . "'")->row();

		$count 			= $this->db->query("SELECT COUNT(no_invoice) as total FROM tr_invoice_np_detail WHERE no_invoice ='" . $gethd->no_invoice . "'")->row();
		$count1			= $count->total;

		$total  		= $gethd;
		$detail  		= $getdtl;

		$data['customer']	= $customer;
		$data['total'] 		= $total;
		$data['results']  	= $detail;
		$data['user'] 		= $data_session['ORI_User']['username'];

		$show 		= $this->load->view('print_invoice_idr', $data, TRUE);

		$mpdf->AddPageByArray([
			'orientation' => 'P',
			'margin-top' => 10,
			'margin-bottom' => 15,
			'margin-left' => 15,
			'margin-right' => 15,
			'margin-header' => 0,
			'margin-footer' => 0,
		]);
		$mpdf->SetDefaultBodyCSS('background', "url('assets/images/kop-surat-opc.jpg')");
		$mpdf->SetDefaultBodyCSS('background-image-resize', 5);
		$mpdf->SetTitle($nomordoc);
		$mpdf->WriteHTML($show);
		$mpdf->Output("INVOICE " . date('dmYHis') . ".pdf", 'I');
	}

	public function data_form($id = "", $tipe = "")
	{
		$data_customer = $this->db->query("SELECT * FROM master_customers ORDER BY name_customer ASC ")->result();
		$data_category = $this->db->query("SELECT * FROM ms_inv_category ORDER BY nama ASC ")->result();
		$data_currency = $this->db->query("SELECT * FROM matauang ORDER BY kode ASC ")->result();
		if ($id != "") {
			$data	= $this->db->query("SELECT * FROM tr_invoice_np_header WHERE id_invoice='" . $id . "'")->row();
			$data_detail	= $this->db->query("SELECT * FROM tr_invoice_np_detail WHERE no_invoice='" . $data->no_invoice . "'")->result();
			if ($data->status > 0) $tipe = "view";
		} else {
			$data	= null;
			$data_detail	= null;
		}
		$data = array(
			'title'			=> 'Invoice Non Product',
			'action'		=> 'index',
			'data_customer'	=> $data_customer,
			'data_category'	=> $data_category,
			'data_currency'	=> $data_currency,
			'data'			=> $data,
			'data_detail'	=> $data_detail,
			'tipe'			=> $tipe,
		);
		history('Create New Invoice NP');
		// $this->load->view('Invoice_np/form',$data);

		$this->template->set('results', $data);
		$this->template->title('Invoice');
		$this->template->render('form');
	}

	public function save_data()
	{
		$post = $this->input->post();
		$detail = $post['detail'];

		$data_session	= $this->session->userdata;
		$id_invoice		= $this->input->post("id_invoice");
		$no_invoice		= $this->input->post("no_invoice");
		if (empty($no_invoice)) {
			$no_invoice = $this->Invoice_np_model->get_no_invoice();
		}

		// print_r($no_invoice);
		// exit;

		$no_invoice_old	= $this->input->post("no_invoice_old");
		$tgl_invoice	= $this->input->post("tgl_invoice");
		$id_customer	= $this->input->post("id_customer");
		$nm_customer	= $this->input->post("nm_customer");
		$base_cur		= $this->input->post("base_cur");
		$ppn_persen		= $this->input->post("ppn_persen");
		$pph_persen		= $this->input->post("pph_persen");
		$jenis_invoice	= $this->input->post("jenis_invoice");
		$keterangan		= $this->input->post("keterangan");
		$no_faktur		= $this->input->post("no_faktur");
		$no_pajak		= $this->input->post("no_pajak");

		$detail_id		= $this->input->post("detail_id");
		$desc			= $this->input->post("desc");
		$qty			= $this->input->post("qty");

		// print_r($qty);
		// exit;

		$unit			= $this->input->post("unit");
		$harga_satuan_usd = $this->input->post("harga_satuan_usd");
		$harga_total_usd = $this->input->post("harga_total_usd");
		$kd_aset		= $this->input->post("kd_aset");
		$nilai_aset		= $this->input->post("nilai_aset");
		$nama_aset		= $this->input->post("nama_aset");

		$dateTime = date('Y-m-d H:i:s');
		$UserName =  $this->auth->user_id();
		$total_dpp_usd = 0;
		$total_ppn_idr = 0;
		$total_invoice_usd = 0;

		$this->db->trans_begin();
		if ($id_invoice !== "") {

			$this->All_model->dataDelete('tr_invoice_np_detail', array('no_invoice' => $no_invoice_old));

			if (!empty($detail)) {
				foreach ($detail as $keys => $val) {
					if (str_replace(',', '', $val['qty']) > 0) {
						$data_detail =  array(
							'no_invoice' => $no_invoice,
							'jenis_invoice' => $jenis_invoice,
							'qty' => str_replace(',', '', $val['qty']),
							'harga_satuan_usd' => str_replace(',', '', $val['harga_satuan_usd']),
							'harga_total_usd' => str_replace(',', '', $val['harga_total_usd']),
							'desc' => $val['desc'],
							'unit' => $val['unit'],
							'nilai_aset' => $val['nilai_aset'],
							'kd_aset' => $val['kd_asset'],
							'nama_aset' => $val['nama_aset'],
							'created_by' => $UserName,
							'created_date' => $dateTime,
							'modified_by' => $UserName,
							'modified_date' => $dateTime
						);
						$this->All_model->dataSave('tr_invoice_np_detail', $data_detail);
						$total_dpp_usd = ($total_dpp_usd + str_replace(',', '', $val['harga_satuan_usd']));
					}
				}
				if ($ppn_persen <> 0) $total_ppn_idr = ($total_dpp_usd * $ppn_persen / 100);
				$total_invoice_usd = ($total_dpp_usd + $total_ppn_idr);
			}

			// if (!empty($detail_id)) {
			// 	foreach ($detail_id as $keys => $val) {
			// 		if ($qty[$keys] > 0) {
			// 			$data_detail =  array(
			// 				'no_invoice' => $no_invoice,
			// 				'jenis_invoice' => $jenis_invoice,
			// 				'qty' => $qty[$keys],
			// 				'harga_satuan_usd' => $harga_satuan_usd[$keys],
			// 				'harga_total_usd' => ($harga_total_usd[$keys]),
			// 				'desc' => $desc[$keys],
			// 				'unit' => $unit[$keys],
			// 				'nilai_aset' => $nilai_aset[$keys],
			// 				'kd_aset' => $kd_aset[$keys],
			// 				'nama_aset' => $nama_aset[$keys],
			// 				'created_by' => $UserName,
			// 				'created_date' => $dateTime,
			// 				'modified_by' => $UserName,
			// 				'modified_date' => $dateTime
			// 			);
			// 			$this->All_model->dataSave('tr_invoice_np_detail', $data_detail);
			// 			$total_dpp_usd = ($total_dpp_usd + $harga_total_usd[$keys]);
			// 		}
			// 	}
			// 	if ($ppn_persen <> 0) $total_ppn_idr = ($total_dpp_usd * $ppn_persen / 100);
			// 	$total_invoice_usd = ($total_dpp_usd + $total_ppn_idr);
			// }
			$data =  array(
				'no_invoice' => $no_invoice,
				'id_customer' => $id_customer,
				'nm_customer' => $nm_customer,
				'tgl_invoice' => $tgl_invoice,
				'base_cur' => $base_cur,
				'total_dpp_usd' => $total_dpp_usd,
				'total_dpp_rp' => $total_dpp_usd,
				'total_ppn_idr' => $total_ppn_idr,
				'total_invoice_usd' => $total_invoice_usd,
				'total_invoice_idr' => $total_invoice_usd,
				'ppn_persen' => $ppn_persen,
				'ppn_persen' => $ppn_persen,
				'pph_persen' => $pph_persen,
				'jenis_invoice' => $jenis_invoice,
				'no_faktur' => $no_faktur,
				'no_pajak' => $no_pajak,
				'keterangan' => $keterangan,
				'modified_by' => $UserName,
				'modified_date' => $dateTime,
				'sisa_invoice_idr' => $total_invoice_usd,
				'sisa_invoice' => $total_invoice_usd,
				'printed_on' => '1'
			);
			$result = $this->All_model->dataUpdate('tr_invoice_np_header', $data, array('id_invoice' => $id_invoice));

			$keterangan     = "SUKSES, Edit data " . $id_invoice;
			$status         = 1;
			$nm_hak_akses   = "";
			$kode_universal = $id_invoice;
			$jumlah = 1;
			$sql            = $this->db->last_query();
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
			} else {
				$this->db->trans_commit();
			}
		} else {
			//			$no_doc=$this->All_model->GetAutoGenerate('format_invoice_np');			
			$no_doc = $no_invoice;
			if (!empty($detail)) {
				foreach ($detail as $keys => $val) {
					if (str_replace(',', '', $val['qty']) > 0) {
						$data_detail =  array(
							'no_invoice' => $no_invoice,
							'jenis_invoice' => $jenis_invoice,
							'qty' => str_replace(',', '', $val['qty']),
							'harga_satuan_usd' => str_replace(',', '', $val['harga_satuan_usd']),
							'harga_total_usd' => str_replace(',', '', $val['harga_total_usd']),
							'desc' => $val['desc'],
							'unit' => $val['unit'],
							'nilai_aset' => (isset($val['nilai_aset'])) ? $val['nilai_aset'] : 0,
							'kd_aset' => (isset($val['kd_asset'])) ? $val['kd_asset'] : '',
							'nama_aset' => (isset($val['nama_aset'])) ? $val['nama_aset'] : '',
							'created_by' => $UserName,
							'created_date' => $dateTime,
							'modified_by' => $UserName,
							'modified_date' => $dateTime
						);
						$this->All_model->dataSave('tr_invoice_np_detail', $data_detail);
						$total_dpp_usd = ($total_dpp_usd + str_replace(',', '', $val['harga_satuan_usd']));
					}
				}
				if ($ppn_persen <> 0) $total_ppn_idr = ($total_dpp_usd * $ppn_persen / 100);
				$total_invoice_usd = ($total_dpp_usd + $total_ppn_idr);
			}
			// if (!empty($detail_id)) {
			// 	foreach ($detail_id as $keys => $val) {
			// 		$no_doc			= $no_doc;
			// 		if ($qty[$keys] > 0) {
			// 			$data_detail =  array(
			// 				'no_invoice' => $no_doc,
			// 				'jenis_invoice' => $jenis_invoice,
			// 				'qty' => $qty[$keys],
			// 				'harga_satuan_usd' => $harga_satuan_usd[$keys],
			// 				'harga_total_usd' => ($harga_total_usd[$keys]),
			// 				'desc' => $desc[$keys],
			// 				'unit' => $unit[$keys],
			// 				'nilai_aset' => $nilai_aset[$keys],
			// 				'kd_aset' => $kd_aset[$keys],
			// 				'nama_aset' => $nama_aset[$keys],
			// 				'created_by' => $UserName,
			// 				'created_date' => $dateTime,
			// 				'modified_by' => $UserName,
			// 				'modified_date' => $dateTime
			// 			);
			// 			$total_dpp_usd = ($total_dpp_usd + $harga_total_usd[$keys]);
			// 			$this->All_model->dataSave('tr_invoice_np_detail', $data_detail);
			// 		}
			// 	}
			// 	if ($ppn_persen <> 0) $total_ppn_idr = ($total_dpp_usd * $ppn_persen / 100);
			// 	$total_invoice_usd = ($total_dpp_usd + $total_ppn_idr);
			// }
			$data =  array(
				'status' => '0',
				'no_invoice' => $no_doc,
				'tgl_invoice' => $tgl_invoice,
				'id_customer' => $id_customer,
				'nm_customer' => $nm_customer,
				'base_cur' => $base_cur,
				'total_dpp_usd' => $total_dpp_usd,
				'total_dpp_rp' => $total_dpp_usd,
				'total_ppn_idr' => $total_ppn_idr,
				'total_invoice_usd' => $total_invoice_usd,
				'total_invoice_idr' => $total_invoice_usd,
				'ppn_persen' => $ppn_persen,
				'ppn_persen' => $ppn_persen,
				'pph_persen' => $pph_persen,
				'jenis_invoice' => $jenis_invoice,
				'no_faktur' => $no_faktur,
				'no_pajak' => $no_pajak,
				'keterangan' => $keterangan,
				'created_by' => $UserName,
				'created_date' => $dateTime,
				'sisa_invoice_idr' => $total_invoice_usd,
				'sisa_invoice' => $total_invoice_usd,
				'printed_on' => '1'
			);
			$id_invoice = $this->All_model->dataSave('tr_invoice_np_header', $data);
			if (is_numeric($id_invoice)) {
				$result	= TRUE;
			} else {
				$result = FALSE;
			}
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
			} else {
				$this->db->trans_commit();
			}
		}
		$param = array(
			'save' => $result,
			'id' => $id_invoice
		);
		echo json_encode($param);
	}

	public function delete_data($iddata)
	{
		$this->db->trans_begin();
		if ($iddata != "") {
			$data	= $this->db->query("SELECT * FROM tr_invoice_np_header WHERE id_invoice='" . $iddata . "'")->row();
			$this->db->where('id_invoice', $iddata);
			$this->db->delete('tr_invoice_np_header');
			$this->db->where('no_invoice', $data->no_invoice);
			$this->db->delete('tr_invoice_np_detail');
			$this->db->trans_complete();
		}
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$Arr_Kembali    = array(
				'pesan'        => 'Failed. Please try again later ...',
				'status'    => 0
			);
		} else {
			$this->db->trans_commit();
			$Arr_Kembali    = array(
				'pesan'        => 'Success Delete. Thanks ...',
				'status'    => 1
			);
		}
		echo json_encode($Arr_Kembali);
	}

	public function update_data($iddata)
	{
		$this->db->trans_begin();
		$data_session	= $this->session->userdata;
		$dtinv 			= $this->db->query("SELECT * FROM tr_invoice_np_header WHERE id_invoice='" . $iddata . "'")->row();
		$kurs_jual = 1;
		$noinvoice = $dtinv->no_invoice;
		if ($dtinv->base_cur != 'IDR') {
			$getkurs = $this->db->query("SELECT * FROM ms_kurs WHERE mata_uang='" . $dtinv->base_cur . "' and tanggal<='" . $dtinv->tgl_invoice . "' limit 1")->row();
			$kurs_jual = $getkurs->kurs;
			$total_dpp_rp = ($dtinv->total_dpp_usd * $kurs_jual);
			$total_ppn_idr = ($dtinv->total_dpp_usd * $dtinv->ppn_persen * $kurs_jual / 100);
			$total_invoice_idr = ($dtinv->total_invoice_usd * $kurs_jual);
			$Arrdata = [
				'status'	=> "1",
				'kurs_jual'	=> $kurs_jual,
				'total_dpp_rp'	=> $total_dpp_rp,
				'total_ppn_idr'	=> $total_ppn_idr,
				'total_invoice_idr'	=> $total_invoice_idr,
			];
			$this->db->query("update tr_invoice_np_detail set harga_satuan_idr=(harga_satuan_usd*" . $kurs_jual . "), harga_total_idr=(harga_total_usd*" . $kurs_jual . ") WHERE no_invoice='" . $noinvoice . "'");
		} else {
			$Arrdata = [
				'status'	=> "1",
				'kurs_jual'	=> 1,
				'total_dpp_rp'	=> $dtinv->total_dpp_usd,
				'total_invoice_idr'	=> $dtinv->total_invoice_usd,
			];
			$this->db->query("update tr_invoice_np_detail set harga_satuan_idr=(harga_satuan_usd*" . $kurs_jual . "), harga_total_idr=(harga_total_usd*" . $kurs_jual . ") WHERE no_invoice='" . $noinvoice . "'");
		}
		$this->db->where('id_invoice', $iddata)->update('tr_invoice_np_header', $Arrdata);
		$gethd 			= $this->db->query("SELECT * FROM tr_invoice_np_header WHERE id_invoice='$iddata'")->row();

		$kodejurnal1	= 'JV055';
		$nomordoc		= $gethd->no_invoice;
		$db2 			= $this->load->database('accounting', TRUE);
		$data_session 	= $this->session->userdata;
		$tgl       		= $gethd->tgl_invoice;
		$Jml_Ttl   		= $gethd->total_invoice_idr;
		$Id_klien     	= $gethd->id_customer;
		$Nama_klien   	= $gethd->nm_customer;
		$Bln 			= substr($tgl, 5, 2);
		$Thn 			= substr($tgl, 0, 4);

		$Nomor_JV				= get_generate_jurnal('GJ', date('y-m-d'));
		$Keterangan_INV		    = 'PENJUALAN A/N ' . $Nama_klien . ' INV NO. ' . $nomordoc;
		$dataJVhead = array(
			'nomor' 	    	=> $Nomor_JV,
			'tgl'	         	=> $tgl,
			'jml'	            => $Jml_Ttl,
			'koreksi_no'		=> '-',
			'kdcab'				=> '101',
			'jenis'			    => 'JV',
			'keterangan' 		=> $Keterangan_INV,
			'bulan'				=> $Bln,
			'tahun'				=> $Thn,
			'user_id'			=> $data_session['ORI_User']['username'],
			'memo'			    => $nomordoc,
			'tgl_jvkoreksi'	    => $tgl,
			'ho_valid'			=> ''
		);
		$datajurnal1  	 = $this->Acc_model->GetTemplateJurnal($kodejurnal1);
		//aset
		if ($gethd->jenis_invoice == '2') {
			$getdtl	= $this->db->query("SELECT * FROM tr_invoice_np_detail WHERE no_invoice='" . $noinvoice . "'")->result();
			$persen_ppn = $gethd->ppn_persen;
			foreach ($getdtl as $dataset) {
				$nilaijualdpp = $dataset->harga_total_idr;
				$nilaippn = $nilaijualdpp * $persen_ppn / 100;
				$nilaitotal = ($nilaijualdpp + $nilaippn);
				// cari aset
				$getaset = $this->db->query("SELECT
				a.id,
				c.coa_jual,
				a.nilai_asset,
				b.sisa_nilai as nilai_buku,
				(a.nilai_asset - b.sisa_nilai) as akumulasi_penyusutan
			FROM
				asset a 
				LEFT JOIN asset_nilai b ON a.kd_asset = b.kd_asset
				LEFT JOIN asset_category c ON a.category = c.id
			WHERE 1=1
				AND a.deleted_date IS NULL and penyusutan='Y' and a.kd_asset='" . $dataset->kd_aset . "'")->row();
				$harga_beli = $getaset->nilai_asset;
				$akumulasi_penyusutan = $getaset->akumulasi_penyusutan;
				$nilai_buku = $getaset->nilai_buku;
				$pl_debit = 0;
				$pl_kredit = 0;
				$profit_lost = $nilaijualdpp - $nilai_buku;
				if ($profit_lost >= 0) {
					$pl_kredit = $profit_lost;
				} else {
					$pl_debit = ($profit_lost * -1);
				}
				$coa_jual = explode("/", $getaset->coa_jual);
				// Akumulasi
				$det_Jurnaltes1[]  = array(
					'nomor'         => $Nomor_JV,
					'tanggal'       => $tgl,
					'tipe'          => 'JV',
					'no_perkiraan'  => $coa_jual[0],
					'keterangan'    => $Keterangan_INV,
					'no_reff'       => $nomordoc,
					'debet'         => $akumulasi_penyusutan,
					'kredit'        => 0
				);
				// Harga Beli
				$det_Jurnaltes1[]  = array(
					'nomor'         => $Nomor_JV,
					'tanggal'       => $tgl,
					'tipe'          => 'JV',
					'no_perkiraan'  => $coa_jual[1],
					'keterangan'    => $Keterangan_INV,
					'no_reff'       => $nomordoc,
					'debet'         => 0,
					'kredit'        => $harga_beli
				);
				foreach ($datajurnal1 as $rec) {
					$posisi1 		= $rec->posisi;
					$nokir1  = $rec->no_perkiraan;
					$parameter_no  = $rec->parameter_no;
					if ($parameter_no == "1") {	// AR
						$nilaibayar1 = $nilaitotal;
					}
					if ($parameter_no == "2") {	// Profit n Loss
						$nilaibayar1 = $pl_kredit;
						if ($profit_lost < 0) {
							$posisi1 = 'D';
							$nilaibayar1 = $pl_debit;
						}
					}
					if ($parameter_no == "3") {	// PPN
						$nilaibayar1 = $nilaippn;
					}
					if ($posisi1 == 'D') {
						$det_Jurnaltes1[]  = array(
							'nomor'         => $Nomor_JV,
							'tanggal'       => $tgl,
							'tipe'          => 'JV',
							'no_perkiraan'  => $nokir1,
							'keterangan'    => $Keterangan_INV,
							'no_reff'       => $nomordoc,
							'debet'         => $nilaibayar1,
							'kredit'        => 0
						);
					} elseif ($posisi1 == 'K') {
						$det_Jurnaltes1[]  = array(
							'nomor'         => $Nomor_JV,
							'tanggal'       => $tgl,
							'tipe'          => 'JV',
							'no_perkiraan'  => $nokir1,
							'keterangan'    => $Keterangan_INV,
							'no_reff'       => $nomordoc,
							'debet'         => 0,
							'kredit'        => $nilaibayar1
						);
					}
				}
				// update aset status
				$this->db->query("update asset set deleted='Y',deleted_by='" . $data_session['ORI_User']['username'] . "',deleted_date=now() where kd_asset='" . $dataset->kd_aset . "'");
			}
		} else {
			foreach ($datajurnal1 as $rec) {
				$tabel1  		= $rec->menu;
				$posisi1 		= $rec->posisi;
				$field1  		= $rec->field;
				$param1  		= 'no_invoice';
				$value_param1  	= $nomordoc;
				$val1 			= $this->Acc_model->GetData($tabel1, $field1, $param1, $value_param1);
				$nilaibayar1 	= $val1[0]->$field1;
				$nokir1  = $rec->no_perkiraan;
				if ($posisi1 == 'D') {
					$det_Jurnaltes1[]  = array(
						'nomor'         => $Nomor_JV,
						'tanggal'       => $tgl,
						'tipe'          => 'JV',
						'no_perkiraan'  => $nokir1,
						'keterangan'    => $Keterangan_INV,
						'no_reff'       => $nomordoc,
						'debet'         => $nilaibayar1,
						'kredit'        => 0
						//'jenis_jurnal'  => 'invoicing'
					);
				} elseif ($posisi1 == 'K') {
					$det_Jurnaltes1[]  = array(
						'nomor'         => $Nomor_JV,
						'tanggal'       => $tgl,
						'tipe'          => 'JV',
						'no_perkiraan'  => $nokir1,
						'keterangan'    => $Keterangan_INV,
						'no_reff'       => $nomordoc,
						'debet'         => 0,
						'kredit'        => $nilaibayar1
					);
				}
			}
		}

		$db2->insert('javh', $dataJVhead);
		$db2->insert_batch('jurnal', $det_Jurnaltes1);

		$datapiutang = array(
			'tipe'       	 => 'JV',
			'nomor'       	 => $Nomor_JV,
			'tanggal'        => $tgl,
			'no_perkiraan'  => '1102-01-01',
			'keterangan'    => $Keterangan_INV,
			'no_reff'       => $nomordoc,
			'debet'         => $Jml_Ttl,
			'kredit'        =>  0,
			'id_supplier'   => $Id_klien,
			'nama_supplier' => $Nama_klien,
		);

		$this->db->insert('tr_kartu_piutang', $datapiutang);
		$Qry_Update_Cabang_acc	 = "UPDATE pastibisa_tb_cabang SET nomorJC=nomorJC + 1 WHERE nocab='101'";
		$db2->query($Qry_Update_Cabang_acc);

		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$Arr_Kembali    = array(
				'pesan'        => 'Failed. Please try again later ...',
				'status'    => 0
			);
		} else {
			$this->db->trans_commit();
			$Arr_Kembali    = array(
				'pesan'        => 'Success Update. Thanks ...',
				'status'    => 1
			);
		}
		echo json_encode($Arr_Kembali);
	}

	function list_asset($id)
	{
		$sql = "
			SELECT
				a.id,
				a.kd_asset,
				a.nm_asset,
				a.category,
				a.penyusutan,
				c.nm_category,
				a.nilai_asset,
				a.depresiasi,
				a.`value`,
				b.sisa_nilai as sisa_nilai,
				(a.nilai_asset - b.sisa_nilai) as total_depresiasi,
				a.department,
				a.kdcab,
				a.cost_center,
				a.tgl_perolehan
			FROM
				asset a 
				LEFT JOIN asset_nilai b ON a.kd_asset = b.kd_asset
				LEFT JOIN asset_category c ON a.category = c.id
			WHERE 1=1
				AND a.deleted_date IS NULL and penyusutan='Y'
		";

		$data_asset	= $this->db->query($sql)->result();
		$data = array(
			'data_asset'	=> $data_asset,
			'id_asset'		=> $id,
		);
		$this->load->view('Invoice_np/list_asset', $data);
	}
}
