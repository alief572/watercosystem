<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/*
 * @author Syamsudin
 * @copyright Copyright (c) 2022, Syamsudin
 *
 * This is controller for Purchase Order Payment
 */

class Purchase_order_payment extends Admin_Controller
{
    //Permission
    protected $viewPermission 	= 'Purchase_Order.View';
    protected $addPermission  	= 'Purchase_Order.Add';
    protected $managePermission = 'Purchase_Order.Manage';
    protected $deletePermission = 'Purchase_Order.Delete'; 

    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('Mpdf', 'upload', 'Image_lib'));
        $this->load->model(array('Purchase_order_payment/Pr_model',
                                 'Aktifitas/aktifitas_model',
                                ));
        $this->template->title('Manage Data Supplier');
        $this->template->page_icon('fa fa-building-o');

        date_default_timezone_set('Asia/Bangkok');


    }
    public function index() { $this->paymentIndex('request'); }

    public function index_approval() { $this->paymentIndex('approval'); }

    public function index_payment() { $this->paymentIndex('payment'); }

	public function index_bea()
    {
       $this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
        $data = $this->db->query("SELECT a.*, b.name_suplier as namesup FROM tr_purchase_order as a 
								 INNER JOIN master_supplier as b on a.id_suplier = b.id_suplier 
								 WHERE a.status='2' ORDER BY a.no_po DESC")->result();

        $this->template->set('results', $data);
        $this->template->title('Bayar Pajak Bea Cukai');
        $this->template->render('index');
    }

	public function jurnal_po()
    {
       $this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
        $this->template->title('Jurnal Pembayaran PO');
        $this->template->render('index_jurnal');
    }

    public function data_jurnal_po()
    {
        $this->auth->restrict($this->viewPermission);
        $debug = $this->db->db_debug; $this->db->db_debug = false;
        $draw = 0;
        try {
            $request = array();
            foreach (array('draw','start','length','search','order') as $key) $request[$key] = $this->input->get($key);
            $rawDraw = filter_var($request['draw'], FILTER_VALIDATE_INT);
            $draw = $rawDraw !== false && $rawDraw >= 0 ? $rawDraw : 0;
            $data = $this->Pr_model->getJurnalPoData($request);
            $manage = has_permission('Jurnal_Pembayaran_PO.Manage');
            $rows = array(); $number = $data['start'];
            foreach ($data['rows'] as $row) {
                $action = '';
                if ($manage && $row->status_jurnal != '1') {
                    $action = '<a class="btn btn-success btn-sm view3" href="javascript:void(0)" title="Create Jurnal" data-id_material="'
                        . html_escape($row->kd_pembayaran) . '"><i class="fa fa-check"></i></a>';
                }
                $date = DateTimeImmutable::createFromFormat('!Y-m-d', (string)$row->tgl_pembayaran);
                $rows[] = array('DT_RowId'=>'jurnal-po-' . (int)$row->id, 'number'=>++$number,
                    'kd_pembayaran'=>html_escape($row->kd_pembayaran ?? ''),
                    'id_incoming'=>html_escape(strtoupper((string)($row->id_incoming ?? ''))),
                    'tgl_pembayaran'=>$date && $date->format('Y-m-d') === $row->tgl_pembayaran ? $date->format('Y-m-d') : html_escape((string)$row->tgl_pembayaran),
                    'supplier'=>html_escape($row->nama_supplier ?? ''),
                    'hutang'=>number_format((float)$row->jumlah_hutang), 'hutang_idr'=>number_format((float)$row->jumlah_hutang_idr),
                    'kurs'=>number_format((float)$row->kurs_bayar), 'bayar'=>number_format((float)$row->jumlah_pembayaran),
                    'bayar_idr'=>number_format((float)$row->jumlah_pembayaran_idr),
                    'status'=>$row->status_jurnal == '1' ? 'Sudah' : 'Belum', 'action'=>$action);
            }
            $reply = array('draw'=>$data['draw'], 'recordsTotal'=>$data['total'], 'recordsFiltered'=>$data['filtered'], 'data'=>$rows);
        } catch (Throwable $e) {
            log_message('error', 'Jurnal PO table: ' . $e->getMessage());
            $reply = array('draw'=>$draw, 'recordsTotal'=>0, 'recordsFiltered'=>0, 'data'=>array(),
                'error'=>$e instanceof DomainException ? $e->getMessage() : 'Data jurnal pembayaran tidak dapat dimuat.');
        } finally {
            $this->db->db_debug = $debug;
        }
        $this->output->set_content_type('application/json');
        echo json_encode($reply);
    }


		public function add()
    {
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$aktif = 'active';
		$deleted = '0';
		$supplier = $data = $this->db->query("SELECT a.* FROM master_supplier as a INNER JOIN dt_trans_pr as b on b.suplier = a.id_suplier INNER JOIN tr_purchase_request as c on b.no_pr = c.no_pr WHERE c.status = '2' GROUP BY b.suplier ")->result();
		$comp	= $this->db->query("select a.*, b.nominal as nominal_harga FROM ms_compotition as a inner join child_history_lme as b on b.id_compotition=a.id_compotition where a.deleted='0' and b.status='0' ")->result();
		$customers = $this->Pr_model->get_data('master_customers','deleted',$deleted);
		$karyawan = $this->Pr_model->get_data('ms_karyawan','deleted',$deleted);
		$mata_uang = $this->Pr_model->get_data('mata_uang','deleted'.$deleted);
		$matauang = $this->db->get_where('matauang')->result();
		$data = [
			'supplier' => $supplier,
			'comp' => $comp,
			'customers' => $customers,
			'karyawan' => $karyawan,
			'mata_uang' => $mata_uang,
			'matauang' => $matauang,
		];
        $this->template->set('results', $data);
        $this->template->title('Purchase Order');
        $this->template->render('Add');

    }
    public function edit() { $this->paymentForm('payment'); }

    public function SavePembayaran() { $this->savePaymentAction('payment'); }

	function appr_jurnal(){
		
		
		
	    
        $kd_bayar   = $this->uri->segment(3);
        $session = $this->session->userdata('app_session');

		$data_bayar =  $this->db->query("SELECT * FROM tr_po_payment WHERE kd_pembayaran = '$kd_bayar' ")->row();

		$tgl_byr 	= $data_bayar->tgl_pembayaran;
		$kd_invoice    	= $data_bayar->no_invoice; 
		$kd_bank 	= $data_bayar->kd_bank;
		$jenis_pph 	= $data_bayar->jenis_pph;
		$nama	= $data_bayar->nm_customer;
		$jmlpph   =$data_bayar->total_pph_idr;
		
       $id_cust =  $this->db->query("SELECT * FROM master_customer WHERE name_customer = '$nama'")->row();
	   $idcust  = $id_cust->id_customer;
		
	   
		
     				$No_Inv  = $kd_bayar;
					$Tgl_Inv = $tgl_byr; 
					$Bln 			= substr($Tgl_Inv,6,2);
					$Thn 			= substr($Tgl_Inv,0,4);
					$bulan_bayar = date("n",strtotime($Tgl_Inv));
					$tahun_bayar = date("Y",strtotime($Tgl_Inv));
                    $keterangan_byr  = $data_bayar->keterangan; 
					$jumlah_total    = $data_bayar->jumlah_pembayaran_idr; 
					$jumlah_terima   = $data_bayar->jumlah_bank_idr; 
					$biaya_admin     = $data_bayar->biaya_admin_idr;
                    $biaya_lain     = $data_bayar->biaya_pph_idr;	
                    $deposit         = $data_bayar->lebih_bayar;						
                    $jenis_reff      = $kd_bayar;
					$no_reff         = $kd_bayar;
        				## NOMOR JV ##
        				$Nomor_BUM				= $this->Jurnal_model->get_Nomor_Jurnal_BUM('101',$Tgl_Inv);

						//print_r($Nomor_BUM);
						//exit;


        			     //$Keterangan_INV		    = 'PENERIMAAN MULTI INVOICE A/N '.$nama.' INV NO. '.$No_Inv.
						//' Keterangan :'.$ket_invoice.', Catatan :'.$notes.', No Reff:'.$noreff.', No Pembayaran:'.$kd_pn;

        				$Keterangan_INV		    = 'PENERIMAAN MULTI INVOICE A/N '.$nama.' INV NO. '.$No_Inv.' Keterangan :'.$keterangan_byr;

						$dataJARH = array(
          					'nomor' 	    	=> $Nomor_BUM,
							'kd_pembayaran'    	=> $kd_pembayaran,
          					'tgl'	         	=> $Tgl_Inv,
          					'jml'	            => $jumlah_total,
          					'kdcab'				=> '101',
          					'jenis_reff'		=> $jenis_reff,
							'no_reff'		    => $no_reff,
							'customer'		    => $nama,
							'terima_dari'		=> '-',
							'jenis_ar'		    => 'V',
     						'note'				=> $Keterangan_INV,
        					'valid'				=> $session['id_user'],
          					'tgl_valid'			=> $Tgl_Inv,
							'user_id'			=> $session['id_user'],
							'tgl_invoice'	    => $Tgl_Inv,
          					'ho_valid'			=> '',
							'batal'			    => '0'
          				);

        				$det_Jurnal				= array();
        				$det_Jurnal[]			= array(
        					  'nomor'         => $Nomor_BUM,
        					  'tanggal'       => $Tgl_Inv,
        					  'tipe'          => 'BUM',
        					  'no_perkiraan'  => $kd_bank,
        					  'keterangan'    => $Keterangan_INV,
        					  'no_reff'       => $No_Inv,
        					  'debet'         => $jumlah_terima,
        					  'kredit'        => 0

        				);

						if($biaya_admin != 0){
        				$det_Jurnal[]			= array(
        					  'nomor'         => $Nomor_BUM,
        					  'tanggal'       => $Tgl_Inv,
        					  'tipe'          => 'BUM',
        					  'no_perkiraan'  => '7205-01-01',
        					  'keterangan'    => $Keterangan_INV,
        					  'no_reff'       => $No_Inv, 
        					  'debet'         => $biaya_admin,
        					  'kredit'        => 0

        				);
						}
						
						if($deposit != 0){
        				$det_Jurnal[]			= array(
        					  'nomor'         => $Nomor_BUM,
        					  'tanggal'       => $Tgl_Inv,
        					  'tipe'          => 'BUM',
        					  'no_perkiraan'  => '2109-02-01',
        					  'keterangan'    => $Keterangan_INV,
        					  'no_reff'       => $No_Inv, 
        					  'debet'         => $deposit,
        					  'kredit'        => 0

        				);
						}

					 $data_jurnal = $this->db->query("SELECT * FROM tr_invoice_payment_detail WHERE kd_pembayaran = '$kd_bayar' ")->result();

			          foreach($data_jurnal as $jr){
						$jmlbayar   =$jr->total_bayar_idr;
						$invoice2    =$jr->no_invoice;
						
						
						if($biaya_lain != 0){
        				$det_Jurnal[]			  = array(
      					  'nomor'         => $Nomor_BUM,
      					  'tanggal'       => $Tgl_Inv,
      					  'tipe'          => 'BUM',
      					  'no_perkiraan'  => $jenis_pph,
      					  'keterangan'    => $Keterangan_INV,
      					  'no_reff'       => $No_Inv,
      					  'debet'         => $jmlpph,
      					  'kredit'        => 0
      				    );
						}

						$det_Jurnal[]			  = array( 
      					  'nomor'         => $Nomor_BUM,
      					  'tanggal'       => $Tgl_Inv,
      					  'tipe'          => 'BUM', 
      					  'no_perkiraan'  => '1102-01-01',
      					  'keterangan'    => $Keterangan_INV,
      					  'no_reff'       => $invoice2,
      					  'debet'         => 0,
      					  'kredit'        => $jmlbayar,
      				    );

					  }


        				## INSERT JURNAL ##
        				$this->db->insert(DBACC.'.JARH',$dataJARH);
        				$this->db->insert_batch(DBACC.'.jurnal',$det_Jurnal);

        				## UPDATE AR ##
			            $Query_AR	= "UPDATE ".DBACC.".ar SET kredit=kredit + ".$jumlah_total.", saldo_akhir=saldo_akhir - ".$jumlah_total." WHERE  no_invoice='".$No_Inv."' AND thn='$tahun_bayar' AND bln='$bulan_bayar'";
			            $this->db->query($Query_AR);

        				$Qry_Update_Cabang_acc	 = "UPDATE ".DBACC.".pastibisa_tb_cabang SET nobum=nobum + 1 WHERE nocab='101'";
        				$this->db->query($Qry_Update_Cabang_acc);

    					//PROSES JURNAL

						$data_jr = $this->db->query("SELECT * FROM tr_invoice_payment_detail WHERE kd_pembayaran = '$kd_bayar' ")->result();

						foreach($data_jr as $val){
						$jml   =$val->total_bayar_idr;
						$inv   =$val->no_invoice;

						$Ket_INV		    = 'PENERIMAAN MULTI INVOICE A/N '.$nama.' INV NO. '.$inv.' Keterangan :'.$keterangan_byr;


						$datapiutang = array(
							'tipe'       	 => 'BUM',
							'nomor'       	 => $Nomor_BUM, 
							'tanggal'        => $Tgl_Inv,
							'no_perkiraan'  => '1103-01-01',
        					'keterangan'    => $Ket_INV,
        					'no_reff'       => $inv,
        					'debet'         => 0,
							'kredit'         => $jml,
							'id_supplier'     => $idcust,
							'nama_supplier'   => $nama,

							);



					    $idso=$this->db->insert('tr_kartu_piutang',$datapiutang);  
 
						}	
						
						$Qry  = "UPDATE tr_invoice_payment SET status_jurnal='1' WHERE kd_pembayaran='$kd_bayar'";
        	            $this->db->query($Qry);


                        $this->print_penerimaan_fix();			 			
	
	
	}
	
    public function approval_bayar() { $this->paymentForm('approval'); }

    public function SaveApproval() { $this->savePaymentAction('approve'); }

    public function SaveReject() { $this->savePaymentAction('reject'); }

    public function request_bayar() { $this->paymentForm('request'); }

    public function request_print() { $this->paymentForm('print'); }

    public function SaveRequest() { $this->savePaymentAction('request'); }


    public function data_index() { $this->paymentIndexData('request'); }
    public function data_approval() { $this->paymentIndexData('approval'); }
    public function data_payment() { $this->paymentIndexData('payment'); }

    private function paymentIndexData($mode)
    {
        $this->auth->restrict($this->viewPermission);
        $debug = $this->db->db_debug; $this->db->db_debug = false;
        $draw = 0;
        try {
            $request = array();
            foreach (array('draw','start','length','search','order') as $key) $request[$key] = $this->input->get($key);
            $rawDraw = filter_var($request['draw'], FILTER_VALIDATE_INT);
            $draw = $rawDraw !== false && $rawDraw >= 0 ? $rawDraw : 0;
            $data = $this->Pr_model->getIndexData($mode, $request);
            $manage = has_permission($this->managePermission);
            $view = has_permission($this->viewPermission);
            $rows = array(); $number = $data['start'];
            foreach ($data['rows'] as $row) {
                $action = '';
                $path = rawurlencode($row->no_po) . '/' . rawurlencode($row->id_data);
                if ($mode === 'approval' || $manage) {
                    $routes = array('request'=>'request_bayar', 'approval'=>'approval_bayar', 'payment'=>'edit');
                    $labels = array('request'=>'Request Pembayaran', 'approval'=>'Approve Pembayaran', 'payment'=>'Create Pembayaran');
                    $icons = array('request'=>'list', 'approval'=>'check', 'payment'=>'plus');
                    $action = '<a class="btn btn-info btn-sm" href="' . html_escape(base_url('purchase_order_payment/' . $routes[$mode] . '/' . $path))
                        . '" title="' . $labels[$mode] . '"><i class="fa fa-' . $icons[$mode] . '"></i></a> ';
                }
                if ($mode === 'payment' && $view) {
                    $action .= '<a class="btn btn-default btn-sm" href="' . html_escape(base_url('purchase_order_payment/request_print/' . $path))
                        . '" target="expense_print" title="Print"><i class="fa fa-print"></i></a>';
                }
                $date = DateTimeImmutable::createFromFormat('!Y-m-d', (string)$row->tanggal);
                $rows[] = array('DT_RowId'=>'incoming-' . (int)$row->id, 'number'=>++$number,
                    'id_incoming'=>html_escape($row->id_incoming ?? ''),
                    'tanggal'=>$date && $date->format('Y-m-d') === $row->tanggal ? $date->format('d-M-Y') : '-',
                    'supplier'=>html_escape($row->namesup ?? ''), 'hutang_usd'=>number_format((float)$row->hutang_usd, 2),
                    'kurs'=>number_format((float)$row->kurs, 2), 'hutang_idr'=>number_format((float)$row->hutang_idr, 2), 'action'=>$action);
            }
            $reply = array('draw'=>$data['draw'], 'recordsTotal'=>$data['total'], 'recordsFiltered'=>$data['filtered'], 'data'=>$rows);
        } catch (Throwable $e) {
            log_message('error', 'PO payment table: ' . $e->getMessage());
            $reply = array('draw'=>$draw, 'recordsTotal'=>0, 'recordsFiltered'=>0, 'data'=>array(),
                'error'=>$e instanceof DomainException ? $e->getMessage() : 'Data pembayaran tidak dapat dimuat.');
        } finally {
            $this->db->db_debug = $debug;
        }
        $this->output->set_content_type('application/json');
        echo json_encode($reply);
    }

    private function paymentIndex($mode)
    {
        $this->auth->restrict($this->viewPermission);
        $views = array('request'=>'index_incoming', 'approval'=>'index_approval', 'payment'=>'index_payment');
        $this->template->page_icon('fa fa-users');
        $this->template->title($mode === 'approval' ? 'Approval Pembayaran' : 'Purchase Order Payment');
        $this->template->render($views[$mode]);
    }

    private function paymentField($row, $key, $required = true)
    {
        $value = $row[$key] ?? '';
        if (!is_scalar($value) || is_bool($value)) throw new DomainException('Field ' . $key . ' tidak valid.');
        $value = trim((string)$value);
        if (($required && $value === '') || strlen($value) > 255) throw new DomainException('Field ' . $key . ' tidak valid.');
        return $value;
    }

    private function paymentDate($value)
    {
        $date = DateTimeImmutable::createFromFormat('!Y-m-d', $value);
        if (!$date || $date->format('Y-m-d') !== $value || (int)$date->format('Y') < 1000) {
            throw new DomainException('Tanggal tidak valid.');
        }
        return $value;
    }

    private function paymentNumber($value)
    {
        if (!is_scalar($value) || is_bool($value) || !preg_match('/^(?:[0-9]+|[0-9]{1,3}(?:,[0-9]{3})+)(?:\.[0-9]{1,2})?$/D', (string)$value)) {
            throw new DomainException('Nominal atau kurs tidak valid; gunakan maksimal dua desimal.');
        }
        $number = round((float)str_replace(',', '', (string)$value), 2);
        if (!is_finite($number) || $number <= 0) throw new DomainException('Nominal atau kurs harus positif.');
        return $number;
    }

    private function paymentQuery($sql, $binds = array())
    {
        $query = $this->db->query($sql, $binds);
        if (!$query) throw new RuntimeException('Payment database operation failed');
        return $query;
    }

    private function paymentContext($noPo, $idData, $lock = false)
    {
        $suffix = $lock ? ' FOR UPDATE' : '';
        $headers = $this->paymentQuery('SELECT * FROM tr_purchase_order WHERE no_po = ?' . $suffix, array($noPo))->result();
        $incoming = $this->paymentQuery('SELECT * FROM tr_incoming WHERE id_data = ?' . $suffix, array($idData))->result();
        if (count($headers) !== 1 || count($incoming) !== 1 || $incoming[0]->no_po !== $noPo) {
            throw new DomainException('Relasi PO dan Incoming tidak ditemukan atau ambigu.');
        }
        $suppliers = $this->paymentQuery('SELECT * FROM master_supplier WHERE id_suplier = ?', array($headers[0]->id_suplier))->result();
        if (count($suppliers) !== 1) throw new DomainException('Supplier PO tidak ditemukan atau ambigu.');
        return array($headers[0], $incoming[0], $suppliers[0]);
    }

    private function paymentForm($mode)
    {
        $this->auth->restrict($this->viewPermission);
        $debug = $this->db->db_debug; $this->db->db_debug = false;
        try {
            $noPo = $this->paymentField(array('id'=>$this->uri->segment(3)), 'id');
            $idData = $this->paymentField(array('id'=>$this->uri->segment(4)), 'id');
            list($header, $incoming, $supplier) = $this->paymentContext($noPo, $idData);
            $incoming->matauang = strtolower(trim((string)$incoming->matauang));
            $data = array('head'=>array($header), 'hutang'=>array($incoming), 'supplier'=>array($supplier),
                'matauang'=>array((object)array('kode'=>strtolower((string)$incoming->matauang))));
            if ($mode === 'print') { $this->load->view('request_print', $data); return; }
            $this->template->set('results', $data);
            $this->template->title($mode === 'request' ? 'Request Pembayaran' : 'Purchase Order Payment');
            $views = array('request'=>'request_bayar', 'approval'=>'approval_bayar', 'payment'=>'Edit');
            $this->template->render($views[$mode]);
        } catch (DomainException $e) {
            show_error(html_escape($e->getMessage()), 404);
        } catch (Throwable $e) {
            log_message('error', 'PO payment form: ' . $e->getMessage());
            show_error('Data pembayaran tidak dapat dimuat.', 500);
        } finally {
            $this->db->db_debug = $debug;
        }
    }

    private function savePaymentAction($action)
    {
        $this->auth->restrict($this->viewPermission);
        $debug = $this->db->db_debug; $this->db->db_debug = false;
        $transaction = false; $lock = null;
        $reply = array('status'=>2, 'pesan'=>'Proses gagal. Silakan coba lagi.');
        try {
            if ($this->input->method() !== 'post') throw new DomainException('Gunakan metode POST.');
            $session = $this->session->userdata('app_session');
            if (!is_array($session) || empty($session['id_user'])) throw new DomainException('Sesi pengguna tidak valid.');
            $post = $this->input->post();
            if (!is_array($post)) throw new DomainException('Data pembayaran tidak valid.');
            $noPo = $this->paymentField($post, 'no_po');
            $idData = $this->paymentField($post, 'id_data');
            $date = null;
            if ($action === 'payment') {
                $date = $this->paymentDate($this->paymentField($post, 'tanggal_bayar'));
                $lock = 'pop-number-' . substr($date, 0, 7);
                if ((int)$this->paymentQuery('SELECT GET_LOCK(?, 10) AS locked', array($lock))->row()->locked !== 1) {
                    $lock = null;
                    throw new DomainException('Penomoran pembayaran sedang dipakai. Silakan coba lagi.');
                }
            }
            if (!$this->db->trans_begin()) throw new RuntimeException('Cannot start payment transaction');
            $transaction = true;
            list($header, $incoming, $supplier) = $this->paymentContext($noPo, $idData, true);
            if ((string)$header->status !== '2' || $incoming->status_bayar !== 'OPN') {
                throw new DomainException('PO atau Incoming sudah tidak dapat diproses.');
            }
            $existing = $this->paymentQuery("SELECT id FROM tr_po_payment WHERE id_data = ? AND (status_bayar IS NULL OR status_bayar <> 'CANCEL') LIMIT 1", array($idData))->row();
            if ($existing) throw new DomainException('Incoming sudah memiliki pembayaran.');
            $currency = strtolower(trim((string)$incoming->matauang));
            if (!in_array($currency, array('idr','usd'), true)) throw new DomainException('Mata uang Incoming tidak didukung.');
            $balance = $currency === 'idr' ? (float)$incoming->hutang_idr - (float)$incoming->bayar_idr
                : (float)$incoming->hutang_kurs - (float)$incoming->bayar_kurs;
            if ($action === 'request') {
                if ($incoming->status_jurnal !== 'CLS' || (string)$incoming->approve_bayar !== '0'
                    || (string)$incoming->request_bayar === '1' || (float)$incoming->rencana_bayar_idr >= 1) {
                    throw new DomainException('Incoming tidak lagi tersedia untuk request.');
                }
                $amount = $this->paymentNumber($this->paymentField($post, 'total_bayar'));
                $rate = $currency === 'idr' ? 1 : $this->paymentNumber($this->paymentField($post, 'nominal_kurs'));
                if ($amount > round($balance, 2)) throw new DomainException('Nominal request melebihi sisa hutang.');
                // ponytail: legacy column stores request in Incoming currency; rename only with a coordinated data migration.
                $update = array('kurs_request'=>$rate, 'rencana_bayar_idr'=>$amount, 'request_bayar'=>'1',
                    'tgl_request_bayar'=>$this->paymentDate($this->paymentField($post, 'tanggal_request')));
            } else {
                if ((string)$incoming->request_bayar !== '1') throw new DomainException('Request pembayaran tidak tersedia.');
                if ($action !== 'reject') {
                    $amount = $this->paymentNumber($incoming->rencana_bayar_idr);
                    if ($amount > round($balance, 2)) throw new DomainException('Nominal request melebihi sisa hutang terkini.');
                }
                if ($action === 'approve' || $action === 'reject') {
                    if ((string)$incoming->approve_bayar !== '0') throw new DomainException('Request sudah diproses.');
                    $update = $action === 'approve' ? array('approve_bayar'=>'1')
                        : array('approve_bayar'=>'0', 'request_bayar'=>'0', 'rencana_bayar_idr'=>0, 'kurs_request'=>0, 'tgl_request_bayar'=>null);
                } else {
                    if ((string)$incoming->approve_bayar !== '1') throw new DomainException('Request belum disetujui.');
                    $rate = $currency === 'idr' ? 1 : $this->paymentNumber($this->paymentField($post, 'nominal_kurs'));
                    $bank = $this->paymentField($post, 'bank');
                    if (!in_array($bank, array('1102-01-01','1102-01-02','1102-01-06'), true)) throw new DomainException('Bank tidak valid.');
                    $idr = round($amount * $rate, 2);
                    if (!is_finite($idr)) throw new DomainException('Nominal pembayaran terlalu besar.');
                    $code = $this->Pr_model->generate_nopn($date);
                    $payment = array('no_po'=>$header->no_po, 'kd_pembayaran'=>$code, 'supplier'=>$header->id_suplier,
                        'tgl_po'=>$header->tanggal, 'tgl_pembayaran'=>$date, 'kurs_bayar'=>$rate,
                        'jumlah_hutang'=>(float)$incoming->hutang_kurs, 'jumlah_hutang_idr'=>(float)$incoming->hutang_idr,
                        'jumlah_pembayaran'=>$amount, 'jumlah_pembayaran_idr'=>$idr, 'kd_bank'=>$bank, 'no_account'=>$bank,
                        'created_by'=>$session['id_user'], 'created_on'=>date('Y-m-d H:i:s'),
                        'selisih'=>round((float)$incoming->hutang_idr - $idr, 2),
                        'keterangan'=>$this->paymentField($post, 'ket_bayar', false), 'nama_supplier'=>$supplier->name_suplier,
                        'id_data'=>$incoming->id_data, 'id_incoming'=>$incoming->id_incoming, 'mata_uang'=>$currency);
                    if (!$this->db->insert('tr_po_payment', $payment)) throw new RuntimeException('Cannot insert PO payment');
                    $this->paymentQuery('UPDATE tr_purchase_order SET total_bayar = COALESCE(total_bayar,0) + ?, total_bayar_idr = COALESCE(total_bayar_idr,0) + ? WHERE no_po = ?',
                        array($amount, $idr, $header->no_po));
                    if ($this->db->affected_rows() !== 1) throw new RuntimeException('PO payment total not updated');
                    $update = array('bayar_kurs'=>round((float)$incoming->bayar_kurs + $amount, 2),
                        'bayar_idr'=>round((float)$incoming->bayar_idr + $idr, 2), 'status_bayar'=>'CLS');
                }
            }
            if (!$this->db->where('id', $incoming->id)->update('tr_incoming', $update) || $this->db->affected_rows() !== 1) {
                throw new RuntimeException('Incoming payment not updated');
            }
            if (!$this->db->trans_status() || !$this->db->trans_commit()) throw new RuntimeException('Cannot commit payment');
            $transaction = false;
            $reply = array('status'=>1, 'pesan'=>'Save Process Success.');
        } catch (DomainException $e) {
            $reply['pesan'] = $e->getMessage();
        } catch (Throwable $e) {
            log_message('error', 'PO payment ' . $action . ': ' . $e->getMessage());
        } finally {
            try {
                if ($transaction && !$this->db->trans_rollback()) log_message('error', 'PO payment rollback failed');
            } catch (Throwable $e) {
                log_message('error', 'PO payment rollback: ' . $e->getMessage());
            } finally {
                try { if ($lock !== null) $this->paymentQuery('SELECT RELEASE_LOCK(?)', array($lock)); }
                catch (Throwable $e) { log_message('error', 'PO payment lock release: ' . $e->getMessage()); }
                finally { $this->db->db_debug = $debug; }
            }
        }
        $this->output->set_content_type('application/json');
        echo json_encode($reply);
    }
}
