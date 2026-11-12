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
		$this->template->page_icon('fa fa-users');
		$this->template->title('Invoice');
		$this->template->render('index_invoice');

		history('View Invoice Non Product');
	}

	/**
	 * Data DataTable serverside untuk index.
	 */
	public function get_data()
	{
		$this->auth->restrict($this->viewPermission);

		$draw   = (int) $this->input->post('draw');
		$start  = (int) $this->input->post('start');
		$length = (int) $this->input->post('length');
		$search = $this->input->post('search');
		$order  = $this->input->post('order');

		$result = $this->Invoice_np_model->get_invoice_json(
			$search['value'] ?? '',
			isset($order[0]['column']) ? (int) $order[0]['column'] : -1,
			$order[0]['dir'] ?? 'desc',
			$start,
			$length
		);

		$can_manage = has_permission($this->managePermission);

		$data = [];
		$no   = $start;
		foreach ($result['rows'] as $row) {
			$no++;
			$id = (int) $row->id_invoice;

			$option = "<button type='button' data-iddata='" . $id . "' class='btn btn-sm btn-warning viewed' title='View'><i class='fa fa-eye'></i></button> ";
			if ($can_manage) {
				$option .= "<a href='" . site_url('invoice_np/print_pdf/' . $id) . "' class='btn btn-sm btn-success' title='Print' target='_blank'><i class='fa fa-print'></i></a>";
			}

			$data[] = [
				'no'            => $no,
				'no_invoice'    => htmlspecialchars((string) $row->no_invoice),
				'tgl_invoice'   => $row->tgl_invoice ? date('d-F-Y', strtotime($row->tgl_invoice)) : '',
				'no_faktur'     => htmlspecialchars((string) $row->no_faktur),
				'keterangan'    => htmlspecialchars((string) $row->keterangan),
				'nm_customer'   => htmlspecialchars((string) $row->nm_customer),
				'total_invoice' => '<div align="right">' . strtoupper((string) $row->base_cur) . ' ' . number_format((float) $row->total_invoice_idr, 2) . '</div>',
				'option'        => $option,
			];
		}

		echo json_encode([
			'draw'            => $draw,
			'recordsTotal'    => (int) $result['total'],
			'recordsFiltered' => (int) $result['filtered'],
			'data'            => $data,
		]);
	}

	public function print_pdf($id)
	{
		$this->auth->restrict($this->managePermission);
		$id = (int) $id;
		// Notice/warning dari view/library tidak boleh bocor ke output PDF.
		error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);

		$gethd = $this->db->get_where('tr_invoice_np_header', ['id_invoice' => $id])->row();
		if (!$gethd) {
			show_404();
		}
		$getdtl   = $this->db->get_where('tr_invoice_np_detail', ['no_invoice' => $gethd->no_invoice])->result();
		$customer = $this->db->get_where('master_customers', ['id_customer' => $gethd->id_customer])->row();
		$pic      = $this->db->order_by('id_pic', 'ASC')->get_where('child_customer_pic', ['id_customer' => $gethd->id_customer])->row();

		$data = [
			'customer'     => $customer,
			'pic_customer' => $pic,
			'total'        => $gethd,
			'results'      => $getdtl,
			'user'         => $this->auth->user_name(),
		];
		$show = $this->load->view('print_invoice_idr', $data, TRUE);

		// mPDF 5.7 lama (MPDF57) fatal di PHP 8 -> pakai shim mPDF 8 via library.
		$this->load->library('Mpdf');
		$mpdf = new mPDF('utf-8', 'A4');
		$mpdf->SetImportUse();
		$mpdf->AddPageByArray([
			'orientation'   => 'P',
			'margin-top'    => 10,
			'margin-bottom' => 15,
			'margin-left'   => 15,
			'margin-right'  => 15,
			'margin-header' => 0,
			'margin-footer' => 0,
		]);
		$kop = FCPATH . 'assets/images/kop-surat-opc.jpg';
		if (is_file($kop)) {
			$mpdf->SetDefaultBodyCSS('background', "url('assets/images/kop-surat-opc.jpg')");
			$mpdf->SetDefaultBodyCSS('background-image-resize', 5);
		}
		$mpdf->SetTitle($gethd->no_invoice);
		$mpdf->WriteHTML($show);

		while (ob_get_level() > 0) {
			ob_end_clean();
		}
		$mpdf->Output('INVOICE ' . date('dmYHis') . '.pdf', 'I');
	}

	public function data_form($id = "", $tipe = "")
	{
		$id = (int) $id;
		$this->auth->restrict($id > 0 ? $this->viewPermission : $this->addPermission);

		$data_customer = $this->db->query("SELECT * FROM master_customers ORDER BY name_customer ASC ")->result();
		$data_category = $this->db->query("SELECT * FROM ms_inv_category ORDER BY nama ASC ")->result();
		$data_currency = $this->db->query("SELECT * FROM matauang ORDER BY kode ASC ")->result();
		$data        = null;
		$data_detail = null;
		if ($id > 0) {
			$data = $this->db->get_where('tr_invoice_np_header', ['id_invoice' => $id])->row();
			if (!$data) {
				show_404();
			}
			$data_detail = $this->db->get_where('tr_invoice_np_detail', ['no_invoice' => $data->no_invoice])->result();
			if ($data->status > 0) {
				$tipe = "view";
			}
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
		history($id > 0 ? 'Open Invoice NP ' . $id : 'Create New Invoice NP');

		$this->template->set('results', $data);
		$this->template->title('Invoice');
		$this->template->render('form');
	}

	public function save_data()
	{
		$this->auth->restrict($this->addPermission);

		$id_invoice = (int) $this->input->post('id_invoice');
		$detail     = $this->input->post('detail');
		$ppn_persen = (float) str_replace(',', '', (string) $this->input->post('ppn_persen'));
		$pph_persen = (float) str_replace(',', '', (string) $this->input->post('pph_persen'));
		$jenis_invoice = $this->input->post('jenis_invoice');

		$clean = function ($v) {
			return (float) str_replace(',', '', (string) $v);
		};

		// Susun detail dulu. Total dihitung dari qty * harga satuan, bukan dari input klien.
		$rows = [];
		$total_dpp = 0;
		$dateTime  = date('Y-m-d H:i:s');
		$userName  = $this->auth->user_id();
		if (!empty($detail) && is_array($detail)) {
			foreach ($detail as $val) {
				$qty = $clean($val['qty'] ?? 0);
				if ($qty <= 0) {
					continue;
				}
				$harga = $clean($val['harga_satuan_usd'] ?? 0);
				$total = round($qty * $harga, 2);
				$rows[] = [
					'jenis_invoice'    => $jenis_invoice,
					'qty'              => $qty,
					'harga_satuan_usd' => $harga,
					'harga_total_usd'  => $total,
					'desc'             => $val['desc'] ?? '',
					'unit'             => $val['unit'] ?? '',
					'nilai_aset'       => $clean($val['nilai_asset'] ?? 0),
					'kd_aset'          => $val['kd_asset'] ?? '',
					'nama_aset'        => $val['nama_asset'] ?? '',
					'created_by'       => $userName,
					'created_date'     => $dateTime,
					'modified_by'      => $userName,
					'modified_date'    => $dateTime,
				];
				$total_dpp += $total;
			}
		}

		if (empty($rows)) {
			echo json_encode(['save' => false, 'id' => $id_invoice, 'pesan' => 'Detail harus diisi']);
			return;
		}

		$total_ppn     = round($total_dpp * $ppn_persen / 100, 2);
		$total_invoice = $total_dpp + $total_ppn;

		$header = [
			'tgl_invoice'       => $this->input->post('tgl_invoice'),
			'id_customer'       => $this->input->post('id_customer'),
			'nm_customer'       => $this->input->post('nm_customer'),
			'base_cur'          => $this->input->post('base_cur'),
			'total_dpp_usd'     => $total_dpp,
			'total_dpp_rp'      => $total_dpp,
			'total_ppn_idr'     => $total_ppn,
			'total_invoice_usd' => $total_invoice,
			'total_invoice_idr' => $total_invoice,
			'ppn_persen'        => $ppn_persen,
			'pph_persen'        => $pph_persen,
			'jenis_invoice'     => $jenis_invoice,
			'no_faktur'         => $this->input->post('no_faktur'),
			'no_pajak'          => $this->input->post('no_pajak'),
			'keterangan'        => $this->input->post('keterangan'),
			'sisa_invoice_idr'  => $total_invoice,
			'sisa_invoice'      => $total_invoice,
			'printed_on'        => '1',
		];

		$this->db->trans_begin();
		if ($id_invoice > 0) {
			$old = $this->db->get_where('tr_invoice_np_header', ['id_invoice' => $id_invoice])->row();
			if (!$old || $old->status != '0') {
				$this->db->trans_rollback();
				echo json_encode(['save' => false, 'id' => $id_invoice, 'pesan' => 'Invoice tidak ditemukan atau sudah diproses']);
				return;
			}
			$no_invoice = $old->no_invoice;
			$header['no_invoice']    = $no_invoice;
			$header['modified_by']   = $userName;
			$header['modified_date'] = $dateTime;
			$this->db->where('id_invoice', $id_invoice)->update('tr_invoice_np_header', $header);
			$this->db->delete('tr_invoice_np_detail', ['no_invoice' => $no_invoice]);
		} else {
			$no_invoice = $this->Invoice_np_model->get_no_invoice();
			$header['status']       = '0';
			$header['no_invoice']   = $no_invoice;
			$header['created_by']   = $userName;
			$header['created_date'] = $dateTime;
			$this->db->insert('tr_invoice_np_header', $header);
			$id_invoice = $this->db->insert_id();
		}
		foreach ($rows as &$r) {
			$r['no_invoice'] = $no_invoice;
		}
		unset($r);
		$this->db->insert_batch('tr_invoice_np_detail', $rows);

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			echo json_encode(['save' => false, 'id' => $id_invoice, 'pesan' => 'Gagal menyimpan']);
			return;
		}
		$this->db->trans_commit();
		echo json_encode(['save' => true, 'id' => $id_invoice]);
	}

	public function delete_data($iddata)
	{
		$this->auth->restrict($this->deletePermission);
		$iddata = (int) $iddata;

		$data = $this->db->get_where('tr_invoice_np_header', ['id_invoice' => $iddata])->row();
		if (!$data) {
			echo json_encode(['pesan' => 'Data tidak ditemukan', 'status' => 0]);
			return;
		}
		if ($data->status != '0') {
			echo json_encode(['pesan' => 'Invoice sudah diproses, tidak bisa dihapus', 'status' => 0]);
			return;
		}

		$this->db->trans_begin();
		$this->db->delete('tr_invoice_np_detail', ['no_invoice' => $data->no_invoice]);
		$this->db->delete('tr_invoice_np_header', ['id_invoice' => $iddata]);
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			echo json_encode(['pesan' => 'Failed. Please try again later ...', 'status' => 0]);
			return;
		}
		$this->db->trans_commit();
		echo json_encode(['pesan' => 'Success Delete. Thanks ...', 'status' => 1]);
	}

	public function update_data($iddata)
	{
		$this->auth->restrict($this->managePermission);

		// ponytail: posting jurnal akuntansi (get_generate_jurnal, DB 'accounting', ms_kurs lama, template JV055)
		// belum tersedia di build PHP 8 ini. Ditolak jelas daripada fatal / jurnal salah posting.
		// Upgrade: perbaiki jalur jurnal memakai DBACC dan ms_kurs.nilai_kurs, lalu hapus guard ini.
		if (!function_exists('get_generate_jurnal')) {
			echo json_encode([
				'pesan'  => 'Posting jurnal belum tersedia (fungsi get_generate_jurnal tidak ditemukan). Data tidak diubah.',
				'status' => 0,
			]);
			return;
		}

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
			'user_id'			=> $this->auth->user_name(),
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
				$this->db->query("update asset set deleted='Y',deleted_by='" . $this->auth->user_name() . "',deleted_date=now() where kd_asset='" . $dataset->kd_aset . "'");
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
