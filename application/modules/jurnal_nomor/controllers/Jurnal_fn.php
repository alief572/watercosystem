<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
 * @author Harboens
 * @copyright Copyright (c) 2018, Harboens
 *
 * This is controller for Purchase Order
 */

class Jurnal_fn extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->model(array(
            'Jurnal_nomor/Acc_model',
            'Jurnal_nomor/Jurnal_model'
        ));
        date_default_timezone_set("Asia/Bangkok");
        $this->datppn = array('0' => 'Non PPN', '10' => 'PPN');
        $this->datcombodata = array('No' => 'No', 'Asli' => 'Asli', 'Copy' => 'Copy');
    }

    public function index()
    {
        // $data = $this->Purchase_order_model->GetListPR('BIAYA');
        // $this->template->set('results', $data);
        // $this->template->title('Purchase Request Operational Titik (Existing)');
        // $this->template->render('list');
    }

    function jurnal_invoicing()
    {
        //JURNAL PENGAKUAN PIUTANG
        //TERJADI SAAT CREATE INVOICE

        $id        = $this->uri->segment(4);
        $kodejurnal = $this->uri->segment(5);
        $ket = $this->uri->segment(6);

        $invoicing = $this->db->query(
            "SELECT a.*, b.name_customer FROM tr_invoice a
             INNER JOIN master_customers b ON a.id_customer = b.id_customer WHERE a.no_invoice = ?",
            [$id]
        )->row();
        if (!$invoicing) {
            echo "<div class='alert alert-danger'>Invoice tidak ditemukan atau customer-nya tidak ada.</div>";
            return;
        }

        $nama   = $invoicing->name_customer;
        $nomor  = $invoicing->no_surat;

        $no_request = $id;
        $tgl_voucher = $invoicing->tgl_invoice;

        $Keterangan_INV            = 'Invoicing ' . ($nama) . ' No ' . ($nomor);

        #AMBIL TEMPLATE JURNAL DAN SIMPAN KE TEMPORARY

        $datajurnal       = $this->Acc_model->GetTemplateJurnal($kodejurnal);
        $det_Jurnaltes    = [];
        $nilaibayar       = 0;
        foreach ((array) $datajurnal as $record) {
            $nokir  = $record->no_perkiraan;
            $tabel  = $record->menu;
            $posisi = $record->posisi;
            $field  = $record->field;
            $val = $this->Acc_model->GetData($tabel, $field, 'no_invoice', $id);
            $nilaibayar = $val ? round($val[0]->$field) : 0;

            if ($posisi == 'D') {
                $det_Jurnaltes[]  = array(
                    'nomor'         => '',
                    'tanggal'       => $tgl_voucher,
                    'tipe'          => 'JV',
                    'no_perkiraan'  => $nokir,
                    'keterangan'    => $Keterangan_INV,
                    'no_reff'       => $id,
                    'debet'         => $nilaibayar,
                    'kredit'        => 0,
                    'jenis_jurnal'  => $ket,
                    'no_request'    => $no_request
                );
            } elseif ($posisi == 'K') {
                $det_Jurnaltes[]  = array(
                    'nomor'         => '',
                    'tanggal'       => $tgl_voucher,
                    'tipe'          => 'JV',
                    'no_perkiraan'  => $nokir,
                    'keterangan'    => $Keterangan_INV,
                    'no_reff'       => $id,
                    'debet'         => 0,
                    'kredit'        => $nilaibayar,
                    'jenis_jurnal'  => $ket,
                    'no_request'    => $no_request
                );
            }
        }

        $this->db->where('no_reff', $id);
        $this->db->where('jenis_jurnal', $ket);
        $this->db->delete('jurnal');

        if (!empty($det_Jurnaltes)) {
            $this->db->insert_batch('jurnal', $det_Jurnaltes);
        }

        $noreff     = $id;
        $tipe        = 'jv';
        $jenisjurnal = $ket;
        $data['list_data']         = $this->Jurnal_model->get_detail_jurnal($noreff, $tipe, $jenisjurnal);
        $data['data_perkiraan']    = $this->Acc_model->get_noperkiraan();
        $data['jenis']            = 'JV';
        $data['akses']            = 'jurnal';
        $data['jenis_jurnal']    = $jenisjurnal;
        $data['po_no']            = $id;
        $data['total_po']        = $nilaibayar;
        $data['id_vendor']        = '';
        $data['nama_vendor']    = '';
        $data['no_surat']        = $nomor;
        $this->load->view("v_detail_jurnal", $data);
    }

    public function save_jurnal_invoicing()
    {
        $this->auth->restrict('Invoicing.Manage');

        $tgl_inv     = $this->input->post('tgl_jurnal[0]');
        $keterangan  = $this->input->post('keterangan[0]');
        $reff        = $this->input->post('reff[0]');
        $total       = round((float) $this->input->post('total'));

        $types       = (array) $this->input->post('type');
        $tgl_list    = (array) $this->input->post('tgl_jurnal');
        $coa_list    = (array) $this->input->post('no_coa');
        $ket_list    = (array) $this->input->post('keterangan');
        $reff_list   = (array) $this->input->post('reff');
        $jj_list     = (array) $this->input->post('jenisjurnal');
        $debet_list  = (array) $this->input->post('debet');
        $kredit_list = (array) $this->input->post('kredit');

        if (empty($reff) || empty($types) || empty($tgl_inv)) {
            echo json_encode(['save' => 0, 'msg' => 'Data jurnal tidak lengkap.']);
            return;
        }

        $this->db->trans_begin();

        // Kunci baris invoice lalu cek belum dijurnal (anti jurnal ganda).
        $inv = $this->db->query("SELECT a.status_jurnal, a.id_customer, a.no_surat, a.grand_total, b.name_customer
            FROM tr_invoice a INNER JOIN master_customers b ON a.id_customer = b.id_customer
            WHERE a.no_invoice = ? FOR UPDATE", [$reff])->row();
        if (!$inv) {
            $this->db->trans_rollback();
            echo json_encode(['save' => 0, 'msg' => 'Invoice tidak ditemukan atau customer-nya tidak ada.']);
            return;
        }
        if ($inv->status_jurnal !== 'OPN') {
            $this->db->trans_rollback();
            echo json_encode(['save' => 0, 'msg' => 'Jurnal invoice ini sudah pernah disimpan.']);
            return;
        }

        $Nomor_JV = $this->Jurnal_model->get_Nomor_Jurnal_Sales('101', $tgl_inv);

        $this->db->insert(DBACC . '.javh', [
            'nomor'         => $Nomor_JV,
            'tgl'           => $tgl_inv,
            'jml'           => $total,
            'koreksi_no'    => '-',
            'kdcab'         => '101',
            'jenis'         => 'JV',
            'keterangan'    => $keterangan,
            'bulan'         => substr($tgl_inv, 5, 2),
            'tahun'         => substr($tgl_inv, 0, 4),
            'user_id'       => $this->auth->user_id(),
            'memo'          => '',
            'tgl_jvkoreksi' => $tgl_inv,
            'ho_valid'      => '',
        ]);

        foreach ($types as $i => $tipe) {
            $noreff      = $reff_list[$i] ?? $reff;
            $jenisjurnal = $jj_list[$i] ?? '';

            $this->db->insert(DBACC . '.jurnal', [
                'tipe'         => $tipe,
                'nomor'        => $Nomor_JV,
                'tanggal'      => $tgl_list[$i] ?? $tgl_inv,
                'no_perkiraan' => $coa_list[$i] ?? '',
                'keterangan'   => $ket_list[$i] ?? '',
                'no_reff'      => $noreff,
                'debet'        => round((float) ($debet_list[$i] ?? 0)),
                'kredit'       => round((float) ($kredit_list[$i] ?? 0)),
            ]);

            $this->db->query(
                "UPDATE jurnal SET stspos=1 WHERE tipe = ? AND jenis_jurnal = ? AND no_reff = ?",
                [$tipe, $jenisjurnal, $noreff]
            );
        }

        $this->db->query("UPDATE " . DBACC . ".pastibisa_tb_cabang SET nomorJC=nomorJC + 1 WHERE nocab='101'");
        $this->db->query("UPDATE tr_invoice SET status_jurnal='CLS' WHERE no_invoice = ?", [$reff]);

        $this->db->insert('tr_kartu_piutang', [
            'tipe'          => 'JV',
            'nomor'         => $Nomor_JV,
            'tanggal'       => $tgl_inv,
            'no_perkiraan'  => '1104-01-01',
            'keterangan'    => $keterangan,
            'no_reff'       => $inv->no_surat,
            'debet'         => $total,
            'kredit'        => 0,
            'id_supplier'   => $inv->id_customer,
            'nama_supplier' => $inv->name_customer,
        ]);

        $this->db->insert('tr_kartu_piutang', [
            'tipe'          => 'JV',
            'nomor'         => $Nomor_JV,
            'tanggal'       => $tgl_inv,
            'no_perkiraan'  => '2101-03-01',
            'keterangan'    => $keterangan,
            'no_reff'       => $inv->no_surat,
            'debet'         => 0,
            'kredit'        => $inv->grand_total,
            'id_supplier'   => $inv->id_customer,
            'nama_supplier' => $inv->name_customer,
        ]);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(['save' => 0, 'msg' => 'GAGAL, simpan data..!!!']);
            return;
        }
        $this->db->trans_commit();
        echo json_encode(['save' => 1, 'msg' => 'SUKSES, simpan data..!!!']);
    }

    function jurnal_penerimaan()
    {
        //JURNAL PENERIMAAN
        //TERJADI SAAT CREATE PENERIMAAN

        $id        = $this->uri->segment(4);
        $kodejurnal = $this->uri->segment(5);
        $ket = $this->uri->segment(6);
        $kd_bayar = $id;
        $no_request = $id;
        $data_bayar = $this->db->query("SELECT * FROM tr_invoice_payment WHERE kd_pembayaran = ?", [$kd_bayar])->row();
        if (!$data_bayar) {
            echo "<div class='alert alert-danger'>Penerimaan tidak ditemukan.</div>";
            return;
        }

        $tgl_byr             = $data_bayar->tgl_pembayaran;
        $kd_bank             = $data_bayar->kd_bank;
        $nama                = $data_bayar->nm_customer;

        // Customer: pakai id_customer bila terisi; data lama sering kosong, jadi cari lewat nama seperti sebelumnya.
        $id_cust = null;
        if (!empty($data_bayar->id_customer)) {
            $id_cust = $this->db->query("SELECT id_customer FROM master_customers WHERE id_customer = ?", [$data_bayar->id_customer])->row();
        }
        if (empty($id_cust)) {
            $id_cust = $this->db->query("SELECT id_customer FROM master_customers WHERE name_customer LIKE ?", ['%' . $nama . '%'])->row();
        }
        $idcust = !empty($id_cust) ? $id_cust->id_customer : '-';

        $No_Inv  = $kd_bayar;
        $Tgl_Inv = $tgl_byr;
        $keterangan_byr  = $data_bayar->keterangan;
        $jumlah_total    = round($data_bayar->jumlah_pembayaran_idr);
        $jumlah_terima   = round($data_bayar->jumlah_bank_idr);
        $biaya_admin     = round($data_bayar->biaya_admin_idr);
        $deposit         = round($data_bayar->tambah_lebih_bayar);

        $Keterangan_INV            = 'Penerimaan A/N ' . $nama . ' Kode Pembayaran. ' . $No_Inv . ',' . $keterangan_byr;

        $det_Jurnal                = array();
        $det_Jurnal[]            = array(
            'nomor'         => '',
            'tanggal'       => $Tgl_Inv,
            'tipe'          => 'BUM',
            'no_perkiraan'  => $kd_bank,
            'keterangan'    => $Keterangan_INV,
            'no_reff'       => $No_Inv,
            'debet'         => $jumlah_terima,
            'kredit'        => 0,
            'jenis_jurnal'  => $ket,
            'no_request'    => $no_request,

        );

        if ($biaya_admin != 0) {
            $det_Jurnal[]            = array(
                'nomor'         => '',
                'tanggal'       => $Tgl_Inv,
                'tipe'          => 'BUM',
                'no_perkiraan'  => '7201-01-02',
                'keterangan'    => $Keterangan_INV,
                'no_reff'       => $No_Inv,
                'debet'         => $biaya_admin,
                'kredit'        => 0,
                'jenis_jurnal'  => $ket,
                'no_request'    => $no_request,

            );
        }
        if ($deposit != 0) {
            $det_Jurnal[]            = array(
                'nomor'         => '',
                'tanggal'       => $Tgl_Inv,
                'tipe'          => 'BUM',
                'no_perkiraan'  => '2101-08-01',
                'keterangan'    => $Keterangan_INV,
                'no_reff'       => $No_Inv,
                'debet'         => 0,
                'kredit'        => $deposit,
                'jenis_jurnal'  => $ket,
                'no_request'    => $no_request,

            );
        }

        $data_jurnal = $this->db->query("SELECT * FROM tr_invoice_payment_detail WHERE kd_pembayaran = ?", [$kd_bayar])->result();

        foreach ($data_jurnal as $jr) {
            $jmlbayar   = $jr->total_bayar_idr;
            $invoice2    = $jr->no_invoice;

            $surat  = $this->db->query("SELECT no_surat FROM tr_invoice WHERE no_invoice = ?", [$invoice2])->row();

            $Keterangan_            = 'INVOICE A/N ' . $nama . ' INV NO. ' . $invoice2 . ', ' . ($surat->no_surat ?? '');

            $det_Jurnal[]              = array(
                'nomor'         => '',
                'tanggal'       => $Tgl_Inv,
                'tipe'          => 'BUM',
                'no_perkiraan'  => '1104-01-01',
                'keterangan'    => $Keterangan_,
                'no_reff'       => $No_Inv,
                'debet'         => 0,
                'kredit'        => $jmlbayar,
                'jenis_jurnal'  => $ket,
                'no_request'    => $no_request,
            );
        }

        $this->db->where('no_reff', $id);
        $this->db->where('jenis_jurnal', $ket);
        $this->db->delete('jurnal');

        $this->db->insert_batch('jurnal', $det_Jurnal);

        $noreff     = $id;
        $tipe        = 'BUM';
        $jenisjurnal = $ket;

        $data['list_data']         = $this->Jurnal_model->get_detail_jurnal($noreff, $tipe, $jenisjurnal);

        $data['data_perkiraan']    = $this->Acc_model->get_noperkiraan();
        $data['jenis']            = 'BUM';
        $data['akses']            = 'jurnal';
        $data['jenis_jurnal']    = $jenisjurnal;
        $data['po_no']            = $id;
        $data['total_po']        = $jumlah_total;
        $data['id_vendor']        = $idcust;
        $data['nama_vendor']    = $nama;
        $data['no_surat']        = $No_Inv;
        $this->load->view("v_detail_jurnal", $data);
    }

    public function save_jurnal_bum()
    {
        $this->auth->restrict('Penerimaan.Manage');
        $session     = $this->session->userdata('app_session');

        $tgl_inv     = $this->input->post('tgl_jurnal[0]');
        $keterangan  = $this->input->post('keterangan[0]');
        $reff        = $this->input->post('reff[0]');
        $total       = round((float) $this->input->post('total'));
        $id_vendor   = $this->input->post('vendor_id');
        $nama_vendor = $this->input->post('vendor_nm');

        $types       = (array) $this->input->post('type');
        $tgl_list    = (array) $this->input->post('tgl_jurnal');
        $coa_list    = (array) $this->input->post('no_coa');
        $ket_list    = (array) $this->input->post('keterangan');
        $reff_list   = (array) $this->input->post('reff');
        $jj_list     = (array) $this->input->post('jenisjurnal');
        $debet_list  = (array) $this->input->post('debet');
        $kredit_list = (array) $this->input->post('kredit');

        if (empty($reff) || empty($types) || empty($tgl_inv)) {
            echo json_encode(['save' => 0, 'msg' => 'Data jurnal tidak lengkap.']);
            return;
        }

        $this->db->trans_begin();

        // Kunci baris penerimaan lalu cek belum dijurnal (anti jurnal ganda).
        $pn = $this->db->query("SELECT status_jurnal FROM tr_invoice_payment WHERE kd_pembayaran = ? FOR UPDATE", [$reff])->row();
        if (!$pn) {
            $this->db->trans_rollback();
            echo json_encode(['save' => 0, 'msg' => 'Penerimaan tidak ditemukan.']);
            return;
        }
        if ($pn->status_jurnal !== '0') {
            $this->db->trans_rollback();
            echo json_encode(['save' => 0, 'msg' => 'Jurnal penerimaan ini sudah pernah disimpan.']);
            return;
        }

        ## NOMOR BUM ##
        $Nomor_BUM = $this->Jurnal_model->get_Nomor_Jurnal_BUM('101', $tgl_inv);

        $dataJARH = array(
            'nomor'             => $Nomor_BUM,
            'kd_pembayaran'     => $reff,
            'tgl'               => $tgl_inv,
            'jml'               => $total,
            'kdcab'             => '101',
            'jenis_reff'        => $reff,
            'no_reff'           => $reff,
            'customer'          => $nama_vendor,
            'terima_dari'       => '-',
            'jenis_ar'          => 'V',
            'note'              => $keterangan,
            'valid'             => $session['id_user'],
            'tgl_valid'         => $tgl_inv,
            'user_id'           => $session['id_user'],
            'tgl_invoice'       => $tgl_inv,
            'ho_valid'          => '',
            'batal'             => '0'
        );

        foreach ($types as $i => $tipe) {
            $perkiraan   = $coa_list[$i] ?? '';
            $noreff      = $reff_list[$i] ?? $reff;
            $jenisjurnal = $jj_list[$i] ?? '';
            $tgl_baris   = $tgl_list[$i] ?? $tgl_inv;
            $ket_baris   = $ket_list[$i] ?? '';
            $debet       = round((float) ($debet_list[$i] ?? 0));
            $kredit      = round((float) ($kredit_list[$i] ?? 0));

            $this->db->insert(DBACC . '.jurnal', array(
                'tipe'            => $tipe,
                'nomor'           => $Nomor_BUM,
                'tanggal'         => $tgl_baris,
                'no_perkiraan'    => $perkiraan,
                'keterangan'      => $ket_baris,
                'no_reff'         => $noreff,
                'debet'           => $debet,
                'kredit'          => $kredit
            ));

            if ($perkiraan == '1104-01-01' || $perkiraan == '2101-08-01') {
                $this->db->insert('tr_kartu_piutang', array(
                    'tipe'            => 'BUM',
                    'nomor'           => $Nomor_BUM,
                    'tanggal'         => $tgl_baris,
                    'no_perkiraan'    => $perkiraan,
                    'keterangan'      => $ket_baris,
                    'no_reff'         => $noreff,
                    'debet'           => $debet,
                    'kredit'          => $kredit,
                    'id_supplier'     => $id_vendor,
                    'nama_supplier'   => $nama_vendor,
                ));
            }

            $this->db->query(
                "UPDATE jurnal SET stspos=1 WHERE tipe = ? AND jenis_jurnal = ? AND no_reff = ?",
                [$tipe, $jenisjurnal, $noreff]
            );
        }

        ## INSERT JURNAL ##
        $this->db->insert(DBACC . '.jarh', $dataJARH);
        $this->db->query("UPDATE " . DBACC . ".pastibisa_tb_cabang SET nobum=nobum + 1 WHERE nocab='101'");
        $this->db->query("UPDATE tr_invoice_payment SET status_jurnal='1' WHERE kd_pembayaran = ?", [$reff]);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(['save' => 0, 'msg' => 'GAGAL, simpan data..!!!']);
            return;
        }
        $this->db->trans_commit();
        echo json_encode(['save' => 1, 'msg' => 'SUKSES, simpan data..!!!']);
    }

    public function save_jurnal_revenue()
    {
        $this->auth->restrict('Pengakuan_Revenue.Manage');

        $tgl_inv     = $this->input->post('tgl_jurnal[0]');
        $keterangan  = $this->input->post('keterangan[0]');
        $reff        = $this->input->post('reff[0]');
        $total       = $this->input->post('total');
        $id_vendor   = $this->input->post('vendor_id');
        $nama_vendor = $this->input->post('vendor_nm');

        $types       = (array) $this->input->post('type');
        $tgl_list    = (array) $this->input->post('tgl_jurnal');
        $coa_list    = (array) $this->input->post('no_coa');
        $ket_list    = (array) $this->input->post('keterangan');
        $reff_list   = (array) $this->input->post('reff');
        $debet_list  = (array) $this->input->post('debet');
        $kredit_list = (array) $this->input->post('kredit');

        if (empty($reff) || empty($types) || empty($tgl_inv)) {
            echo json_encode(['save' => 0, 'msg' => 'Data jurnal tidak lengkap.']);
            return;
        }

        $this->db->trans_begin();

        // Kunci baris revenue lalu cek belum dijurnal (anti jurnal ganda).
        $rev = $this->db->query("SELECT status_jurnal FROM tr_revenue WHERE id = ? FOR UPDATE", [$reff])->row();
        if (!$rev) {
            $this->db->trans_rollback();
            echo json_encode(['save' => 0, 'msg' => 'Data pengakuan revenue tidak ditemukan.']);
            return;
        }
        if ($rev->status_jurnal !== 'OPN') {
            $this->db->trans_rollback();
            echo json_encode(['save' => 0, 'msg' => 'Jurnal revenue ini sudah pernah disimpan.']);
            return;
        }

        $Nomor_JV = $this->Jurnal_model->get_Nomor_Jurnal_Sales('101', $tgl_inv);

        $this->db->insert(DBACC . '.javh', array(
            'nomor'             => $Nomor_JV,
            'tgl'               => $tgl_inv,
            'jml'               => $total,
            'koreksi_no'        => '-',
            'kdcab'             => '101',
            'jenis'             => 'JV',
            'keterangan'        => $keterangan,
            'bulan'             => substr($tgl_inv, 5, 2),
            'tahun'             => substr($tgl_inv, 0, 4),
            'user_id'           => $this->auth->user_id(),
            'memo'              => '',
            'tgl_jvkoreksi'     => $tgl_inv,
            'ho_valid'          => ''
        ));

        foreach ($types as $i => $tipe) {
            $perkiraan = $coa_list[$i] ?? '';
            $tgl_baris = $tgl_list[$i] ?? $tgl_inv;
            $ket_baris = $ket_list[$i] ?? '';
            $noreff    = $reff_list[$i] ?? $reff;
            $debet     = round((float) ($debet_list[$i] ?? 0));
            $kredit    = round((float) ($kredit_list[$i] ?? 0));

            $this->db->insert(DBACC . '.jurnal', array(
                'tipe'            => $tipe,
                'nomor'           => $Nomor_JV,
                'tanggal'         => $tgl_baris,
                'no_perkiraan'    => $perkiraan,
                'keterangan'      => $ket_baris,
                'no_reff'         => $noreff,
                'debet'           => $debet,
                'kredit'          => $kredit
            ));

            if ($perkiraan == '2101-03-01') {
                $this->db->insert('tr_kartu_piutang', array(
                    'tipe'            => 'BUM',
                    'nomor'           => $Nomor_JV,
                    'tanggal'         => $tgl_baris,
                    'no_perkiraan'    => '2101-03-01',
                    'keterangan'      => $ket_baris,
                    'no_reff'         => $noreff,
                    'debet'           => $debet,
                    'kredit'          => $kredit,
                    'id_supplier'     => $id_vendor,
                    'nama_supplier'   => $nama_vendor,
                ));
            }
        }

        $this->db->query("UPDATE " . DBACC . ".pastibisa_tb_cabang SET nomorJC=nomorJC + 1 WHERE nocab='101'");
        $this->db->query("UPDATE tr_revenue SET status_jurnal='CLS' WHERE id = ?", [$reff]);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(['save' => 0, 'msg' => 'GAGAL, simpan data..!!!']);
            return;
        }
        $this->db->trans_commit();
        echo json_encode(['save' => 1, 'msg' => 'SUKSES, simpan data..!!!']);
    }

    function jurnal_pembayaran()
    {
        //JURNAL PEMBAYARAN
        //TERJADI SAAT CREATE PEMBAYARAN HUTANG

        $id        = $this->uri->segment(4);
        $kodejurnal = $this->uri->segment(5);
        $ket = $this->uri->segment(6);
        $kd_bayar = $id;
        $no_request = $id;
        $data_bayar = $this->db->query("SELECT * FROM tr_po_payment WHERE kd_pembayaran = ?", [$kd_bayar])->row();
        if (!$data_bayar) {
            echo "<div class='alert alert-danger'>Pembayaran tidak ditemukan.</div>";
            return;
        }

        $tgl_byr             = $data_bayar->tgl_pembayaran;
        $kd_bank             = $data_bayar->kd_bank;
        $hutangidr         = round($data_bayar->jumlah_hutang_idr);
        $selisih             = round($data_bayar->selisih);
        // Kode dan nama supplier berupa teks: tidak boleh di-round() (TypeError di PHP 8).
        $idsupplier        = $data_bayar->supplier;
        $nama                = $data_bayar->nama_supplier;
        $kurs              = $data_bayar->kurs_bayar;

        $No_Inv  = $kd_bayar;
        $Tgl_Inv = $tgl_byr;
        $keterangan_byr  = $data_bayar->no_po;
        $jumlah_total    = round($data_bayar->jumlah_pembayaran_idr);

        $Keterangan_INV            = 'Pembayaran A/N ' . $nama . ' Kode Pembayaran. ' . $No_Inv . ',' . $keterangan_byr;

        $det_Jurnal                = array();

        if ($kurs == 1) {
            $det_Jurnal[]            = array(
                'nomor'         => '',
                'tanggal'       => $Tgl_Inv,
                'tipe'          => 'BUK',
                'no_perkiraan'  => '2101-01-01',
                'keterangan'    => $Keterangan_INV,
                'no_reff'       => $No_Inv,
                'debet'         => $hutangidr,
                'kredit'        => 0,
                'jenis_jurnal'  => $ket,
                'no_request'    => $no_request,

            );
        } else {
            $det_Jurnal[]            = array(
                'nomor'         => '',
                'tanggal'       => $Tgl_Inv,
                'tipe'          => 'BUK',
                'no_perkiraan'  => '2101-01-02',
                'keterangan'    => $Keterangan_INV,
                'no_reff'       => $No_Inv,
                'debet'         => $hutangidr,
                'kredit'        => 0,
                'jenis_jurnal'  => $ket,
                'no_request'    => $no_request,

            );
        }

        if ($selisih > 0) {
            $det_Jurnal[]            = array(
                'nomor'         => '',
                'tanggal'       => $Tgl_Inv,
                'tipe'          => 'BUK',
                'no_perkiraan'  => '7101-01-05',
                'keterangan'    => $Keterangan_INV,
                'no_reff'       => $No_Inv,
                'debet'         => 0,
                'kredit'        => $selisih,
                'jenis_jurnal'  => $ket,
                'no_request'    => $no_request,

            );
        }

        if ($selisih < 0) {
            $det_Jurnal[]            = array(
                'nomor'         => '',
                'tanggal'       => $Tgl_Inv,
                'tipe'          => 'BUK',
                'no_perkiraan'  => '7101-01-05',
                'keterangan'    => $Keterangan_INV,
                'no_reff'       => $No_Inv,
                'debet'         => $selisih * (-1),
                'kredit'        => 0,
                'jenis_jurnal'  => $ket,
                'no_request'    => $no_request,

            );
        }

        $det_Jurnal[]            = array(
            'nomor'         => '',
            'tanggal'       => $Tgl_Inv,
            'tipe'          => 'BUK',
            'no_perkiraan'  => $kd_bank,
            'keterangan'    => $Keterangan_INV,
            'no_reff'       => $No_Inv,
            'debet'         => 0,
            'kredit'        => $jumlah_total,
            'jenis_jurnal'  => $ket,
            'no_request'    => $no_request,

        );

        $this->db->where('no_reff', $id);
        $this->db->where('jenis_jurnal', $ket);
        $this->db->delete('jurnal');

        $this->db->insert_batch('jurnal', $det_Jurnal);

        $noreff     = $id;
        $tipe        = 'BUK';
        $jenisjurnal = $ket;

        $data['list_data']         = $this->Jurnal_model->get_detail_jurnal($noreff, $tipe, $jenisjurnal);

        $data['data_perkiraan']    = $this->Acc_model->get_noperkiraan();
        $data['jenis']            = 'BUM';
        $data['akses']            = 'jurnal';
        $data['jenis_jurnal']    = $jenisjurnal;
        $data['po_no']            = $id;
        $data['total_po']        = $jumlah_total;
        $data['id_vendor']        = $idsupplier;
        $data['nama_vendor']    = $nama;
        $data['no_surat']        = $No_Inv;
        $this->load->view("v_detail_jurnal", $data);
    }

    public function save_jurnal_pembayaran()
    {
        $this->auth->restrict('Jurnal_Pembayaran_PO.Manage');
        $session = $this->session->userdata('app_session');

        $tgl_po      = $this->input->post('tgl_jurnal[0]');
        $keterangan  = $this->input->post('keterangan[0]');
        $type        = $this->input->post('type[0]');
        $reff        = $this->input->post('reff[0]');
        $no_req      = $this->input->post('no_request[0]');
        $total       = round((float) $this->input->post('total'));
        $total_po    = round((float) $this->input->post('total_po'));
        $id_vendor   = $this->input->post('vendor_id');
        $nama_vendor = $this->input->post('vendor_nm');

        $types       = (array) $this->input->post('type');
        $tgl_list    = (array) $this->input->post('tgl_jurnal');
        $coa_list    = (array) $this->input->post('no_coa');
        $ket_list    = (array) $this->input->post('keterangan');
        $reff_list   = (array) $this->input->post('reff');
        $jj_list     = (array) $this->input->post('jenisjurnal');
        $debet_list  = (array) $this->input->post('debet');
        $kredit_list = (array) $this->input->post('kredit');

        if (empty($reff) || empty($types) || empty($tgl_po)) {
            echo json_encode(['save' => 0, 'msg' => 'Data jurnal tidak lengkap.']);
            return;
        }

        $this->db->trans_begin();

        // Kunci baris pembayaran lalu cek belum dijurnal (anti jurnal ganda).
        $pay = $this->db->query("SELECT status_jurnal FROM tr_po_payment WHERE kd_pembayaran = ? FOR UPDATE", [$reff])->row();
        if (!$pay) {
            $this->db->trans_rollback();
            echo json_encode(['save' => 0, 'msg' => 'Pembayaran tidak ditemukan.']);
            return;
        }
        if ($pay->status_jurnal !== '0') {
            $this->db->trans_rollback();
            echo json_encode(['save' => 0, 'msg' => 'Jurnal pembayaran ini sudah pernah disimpan.']);
            return;
        }

        $Nomor_JV = $this->Jurnal_model->get_no_buk('101');

        $this->db->insert(DBACC . '.japh', array(
            'nomor'             => $Nomor_JV,
            'tgl'               => $tgl_po,
            'jml'               => $total,
            'kdcab'             => '101',
            'jenis_reff'        => 'BUK',
            'no_reff'           => $reff,
            'customer'          => $nama_vendor,
            'bayar_kepada'      => $nama_vendor,
            'jenis_ap'          => 'V',
            'note'              => $keterangan,
            'user_id'           => $session['username'],
            'ho_valid'          => '',
            'batal'             => '0'
        ));

        foreach ($types as $i => $tipe) {
            $perkiraan   = $coa_list[$i] ?? '';
            $noreff      = $reff_list[$i] ?? $reff;
            $jenisjurnal = $jj_list[$i] ?? '';

            $this->db->insert(DBACC . '.jurnal', array(
                'tipe'            => $tipe,
                'nomor'           => $Nomor_JV,
                'tanggal'         => $tgl_list[$i] ?? $tgl_po,
                'no_perkiraan'    => $perkiraan,
                'keterangan'      => $ket_list[$i] ?? '',
                'no_reff'         => $noreff,
                'debet'           => round((float) ($debet_list[$i] ?? 0)),
                'kredit'          => round((float) ($kredit_list[$i] ?? 0))
            ));

            $this->db->query(
                "UPDATE jurnal SET stspos=1 WHERE tipe = ? AND jenis_jurnal = ? AND no_reff = ?",
                [$tipe, $jenisjurnal, $noreff]
            );

            if ($perkiraan == '2101-01-01' || $perkiraan == '2101-01-02') {
                $this->db->insert('tr_kartu_hutang', array(
                    'tipe'            => $type,
                    'nomor'           => $Nomor_JV,
                    'tanggal'         => $tgl_po,
                    'no_perkiraan'    => $perkiraan,
                    'keterangan'      => $keterangan,
                    'no_reff'         => $reff,
                    'debet'           => 0,
                    'kredit'          => $total_po,
                    'id_supplier'     => $id_vendor,
                    'nama_supplier'   => $nama_vendor,
                    'no_request'      => $no_req,
                ));
            }
        }

        $this->db->query("UPDATE " . DBACC . ".pastibisa_tb_cabang SET nobuk=nobuk + 1 WHERE nocab='101'");
        $this->db->query("UPDATE tr_po_payment SET status_jurnal='1' WHERE kd_pembayaran = ?", [$reff]);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(['save' => 0, 'msg' => 'GAGAL, simpan data..!!!']);
            return;
        }
        $this->db->trans_commit();
        echo json_encode(['save' => 1, 'msg' => 'SUKSES, simpan data..!!!']);
    }

    function jurnal_hutang()
    {
        //JURNAL PENGAKUAN HUTANG
        //TERJADI SAAT CREATE INCOMING

        $id        = $this->uri->segment(4);
        $kodejurnal = $this->uri->segment(5);
        $ket = $this->uri->segment(6);

        $hutang = $this->db->query(
            "SELECT a.*, b.id_suplier, b.name_suplier FROM tr_incoming a
             INNER JOIN master_supplier b ON a.id_suplier = b.id_suplier WHERE a.id_data = ?",
            [$id]
        )->row();
        if (!$hutang) {
            echo "<div class='alert alert-danger'>Incoming tidak ditemukan atau supplier-nya tidak ada.</div>";
            return;
        }
        if ($hutang->status_jurnal === 'CLS') {
            echo "<div class='alert alert-warning'>Incoming ini sudah dijurnal.</div>";
            return;
        }

        $idsupplier   = $hutang->id_suplier;
        $nama   = $hutang->name_suplier;
        $nomor  = $hutang->id_incoming;

        $Tgl_Invoice = date('Y-m-d');
        $no_request = $id;
        $tgl_voucher = $Tgl_Invoice;

        $Keterangan_INV            = 'Hutang ' . ($nama) . ' No ' . ($nomor);

        #AMBIL TEMPLATE JURNAL DAN SIMPAN KE TEMPORARY

        $datajurnal       = $this->Acc_model->GetTemplateJurnal($kodejurnal);
        $det_Jurnaltes    = [];
        $nilaibayar       = 0;
        foreach ((array) $datajurnal as $record) {
            if ($idsupplier == 'IS2200001') {
                $nokirhutang  = '2101-01-02';
            } else {
                $nokirhutang  = $record->no_perkiraan;
            }
            $nokir  = $record->no_perkiraan;
            $tabel  = $record->menu;
            $posisi = $record->posisi;
            $field  = $record->field;
            $val = $this->Acc_model->GetData($tabel, $field, 'id_data', $id);
            $nilaibayar = $val ? $val[0]->$field : 0;

            if ($posisi == 'D') {
                $det_Jurnaltes[]  = array(
                    'nomor'         => '',
                    'tanggal'       => $tgl_voucher,
                    'tipe'          => 'JV',
                    'no_perkiraan'  => $nokir,
                    'keterangan'    => $Keterangan_INV,
                    'no_reff'       => $id,
                    'debet'         => $nilaibayar,
                    'kredit'        => 0,
                    'jenis_jurnal'  => $ket,
                    'no_request'    => $no_request
                );
            } elseif ($posisi == 'K') {
                $det_Jurnaltes[]  = array(
                    'nomor'         => '',
                    'tanggal'       => $tgl_voucher,
                    'tipe'          => 'JV',
                    'no_perkiraan'  => $nokirhutang,
                    'keterangan'    => $Keterangan_INV,
                    'no_reff'       => $id,
                    'debet'         => 0,
                    'kredit'        => $nilaibayar,
                    'jenis_jurnal'  => $ket,
                    'no_request'    => $no_request
                );
            }
        }

        $this->db->where('no_reff', $id);
        $this->db->where('jenis_jurnal', $ket);
        $this->db->delete('jurnal');

        if (!empty($det_Jurnaltes)) {
            $this->db->insert_batch('jurnal', $det_Jurnaltes);
        }

        $noreff     = $id;
        $tipe        = 'jv';
        $jenisjurnal = $ket;
        $data['list_data']         = $this->Jurnal_model->get_detail_jurnal($noreff, $tipe, $jenisjurnal);
        $data['data_perkiraan']    = $this->Acc_model->get_noperkiraan();
        $data['jenis']            = 'JV';
        $data['akses']            = 'jurnal';
        $data['jenis_jurnal']    = $jenisjurnal;
        $data['po_no']            = $id;
        $data['total_po']        = $nilaibayar;
        $data['id_vendor']        = $idsupplier;
        $data['nama_vendor']    = $nama;
        $data['no_surat']        = $nomor;
        $this->load->view("v_detail_jurnal", $data);
    }

    public function save_jurnal_hutang()
    {
        $this->auth->restrict('Incoming.Manage');

        $tgl_inv     = $this->input->post('tgl_jurnal[0]');
        $keterangan  = $this->input->post('keterangan[0]');
        $type        = $this->input->post('type[0]');
        $reff        = $this->input->post('reff[0]');
        $no_req      = $this->input->post('no_request[0]');
        $total       = round((float) $this->input->post('total'));
        $id_vendor   = $this->input->post('vendor_id');
        $nama_vendor = $this->input->post('vendor_nm');

        $types       = (array) $this->input->post('type');
        $tgl_list    = (array) $this->input->post('tgl_jurnal');
        $coa_list    = (array) $this->input->post('no_coa');
        $ket_list    = (array) $this->input->post('keterangan');
        $reff_list   = (array) $this->input->post('reff');
        $jj_list     = (array) $this->input->post('jenisjurnal');
        $debet_list  = (array) $this->input->post('debet');
        $kredit_list = (array) $this->input->post('kredit');

        if (empty($reff) || empty($types) || empty($tgl_inv)) {
            echo json_encode(['save' => 0, 'msg' => 'Data jurnal tidak lengkap.']);
            return;
        }

        $this->db->trans_begin();

        // Kunci baris incoming lalu cek belum dijurnal (anti jurnal ganda).
        $inc = $this->db->query("SELECT status_jurnal FROM tr_incoming WHERE id_data = ? FOR UPDATE", [$reff])->row();
        if (!$inc) {
            $this->db->trans_rollback();
            echo json_encode(['save' => 0, 'msg' => 'Incoming tidak ditemukan.']);
            return;
        }
        if ($inc->status_jurnal !== 'OPN') {
            $this->db->trans_rollback();
            echo json_encode(['save' => 0, 'msg' => 'Jurnal incoming ini sudah pernah disimpan.']);
            return;
        }

        $Nomor_JV = $this->Jurnal_model->get_Nomor_Jurnal_Sales('101', $tgl_inv);

        $this->db->insert(DBACC . '.javh', array(
            'nomor'             => $Nomor_JV,
            'tgl'               => $tgl_inv,
            'jml'               => $total,
            'koreksi_no'        => '-',
            'kdcab'             => '101',
            'jenis'             => 'JV',
            'keterangan'        => $keterangan,
            'bulan'             => substr($tgl_inv, 5, 2),
            'tahun'             => substr($tgl_inv, 0, 4),
            'user_id'           => $this->auth->user_id(),
            'memo'              => '',
            'tgl_jvkoreksi'     => $tgl_inv,
            'ho_valid'          => ''
        ));

        $perkiraan = '';
        foreach ($types as $i => $tipe) {
            $perkiraan   = $coa_list[$i] ?? '';
            $noreff      = $reff_list[$i] ?? $reff;
            $jenisjurnal = $jj_list[$i] ?? '';

            $this->db->insert(DBACC . '.jurnal', array(
                'tipe'            => $tipe,
                'nomor'           => $Nomor_JV,
                'tanggal'         => $tgl_list[$i] ?? $tgl_inv,
                'no_perkiraan'    => $perkiraan,
                'keterangan'      => $ket_list[$i] ?? '',
                'no_reff'         => $noreff,
                'debet'           => round((float) ($debet_list[$i] ?? 0)),
                'kredit'          => round((float) ($kredit_list[$i] ?? 0))
            ));

            $this->db->query(
                "UPDATE jurnal SET stspos=1 WHERE tipe = ? AND jenis_jurnal = ? AND no_reff = ?",
                [$tipe, $jenisjurnal, $noreff]
            );
        }

        $this->db->query("UPDATE " . DBACC . ".pastibisa_tb_cabang SET nomorJC=nomorJC + 1 WHERE nocab='101'");
        $this->db->query("UPDATE tr_incoming SET status_jurnal='CLS' WHERE id_data = ?", [$reff]);

        // Perilaku lama dipertahankan: kartu hutang ditulis sekali, berdasarkan akun pada baris jurnal TERAKHIR.
        if ($perkiraan == '2101-01-01' || $perkiraan == '2101-01-02') {
            $this->db->insert('tr_kartu_hutang', array(
                'tipe'            => $type,
                'nomor'           => $Nomor_JV,
                'tanggal'         => $tgl_inv,
                'no_perkiraan'    => $perkiraan,
                'keterangan'      => $keterangan,
                'no_reff'         => $reff,
                'debet'           => $total,
                'kredit'          => 0,
                'id_supplier'     => $id_vendor,
                'nama_supplier'   => $nama_vendor,
                'no_request'      => $no_req,
            ));
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(['save' => 0, 'msg' => 'GAGAL, simpan data..!!!']);
            return;
        }
        $this->db->trans_commit();
        echo json_encode(['save' => 1, 'msg' => 'SUKSES, simpan data..!!!']);
    }

    /**
     * Susun jurnal sementara (tabel jurnal) untuk satu DO dari template Acc_model, lalu tampilkan detailnya.
     * Dipakai tombol Jurnal Delivery (JV004) dan Jurnal Confirm Delivery (JV005) di wt_delivery_order.
     */
    private function _tampil_jurnal_do($label_ket)
    {
        $id         = $this->uri->segment(4);
        $kodejurnal = $this->uri->segment(5);
        $ket        = $this->uri->segment(6);

        $invoicing = $this->db->query(
            "SELECT a.*, b.name_customer FROM tr_delivery_order a
             INNER JOIN master_customers b ON a.id_customer = b.id_customer WHERE a.no_do = ?",
            [$id]
        )->row();
        if (!$invoicing) {
            echo "<div class='alert alert-danger'>Delivery Order tidak ditemukan atau customer-nya tidak ada.</div>";
            return;
        }

        $idcust = $invoicing->id_customer;
        $nama   = $invoicing->name_customer;
        $nomor  = $invoicing->no_surat;

        $tgl_voucher = date('Y-m-d');
        $Keterangan_INV = $label_ket . ' ' . $nama . ' No ' . $nomor;

        $datajurnal = $this->Acc_model->GetTemplateJurnal($kodejurnal);
        $det_Jurnaltes = [];
        $nilaibayar = 0;
        foreach ((array) $datajurnal as $record) {
            $field = $record->field;
            $val = $this->Acc_model->GetData($record->menu, $field, 'no_do', $id);
            $nilaibayar = $val ? round($val[0]->$field) : 0;

            $baris = [
                'nomor'        => '',
                'tanggal'      => $tgl_voucher,
                'tipe'         => 'JV',
                'no_perkiraan' => $record->no_perkiraan,
                'keterangan'   => $Keterangan_INV,
                'no_reff'      => $id,
                'debet'        => 0,
                'kredit'       => 0,
                'jenis_jurnal' => $ket,
                'no_request'   => $id,
            ];
            if ($record->posisi == 'D') {
                $baris['debet'] = $nilaibayar;
            } elseif ($record->posisi == 'K') {
                $baris['kredit'] = $nilaibayar;
            } else {
                continue;
            }
            $det_Jurnaltes[] = $baris;
        }

        $this->db->where('no_reff', $id);
        $this->db->where('jenis_jurnal', $ket);
        $this->db->delete('jurnal');

        if (!empty($det_Jurnaltes)) {
            $this->db->insert_batch('jurnal', $det_Jurnaltes);
        }

        $data['list_data']      = $this->Jurnal_model->get_detail_jurnal($id, 'jv', $ket);
        $data['data_perkiraan'] = $this->Acc_model->get_noperkiraan();
        $data['jenis']          = 'JV';
        $data['akses']          = 'jurnal';
        $data['jenis_jurnal']   = $ket;
        $data['po_no']          = $id;
        $data['total_po']       = $nilaibayar;
        $data['id_vendor']      = $idcust;
        $data['nama_vendor']    = $nama;
        $data['no_surat']       = $nomor;
        $this->load->view("v_detail_jurnal", $data);
    }

    /**
     * Simpan jurnal DO ke akuntansi (javh + jurnal), naikkan nomor jurnal, lalu tandai status DO.
     * $kolom_status: status_jurnal_do atau status_jurnal_confirm. Menolak bila sudah dijurnal (anti ganda).
     */
    private function _simpan_jurnal_do($kolom_status)
    {
        $this->auth->restrict('Jurnal_Delivery.Add');

        $tgl_inv    = $this->input->post('tgl_jurnal[0]');
        $keterangan = $this->input->post('keterangan[0]');
        $reff       = $this->input->post('reff[0]');
        $total      = $this->input->post('total');
        $types      = (array) $this->input->post('type');
        $tgl_list   = (array) $this->input->post('tgl_jurnal');
        $coa_list   = (array) $this->input->post('no_coa');
        $ket_list   = (array) $this->input->post('keterangan');
        $reff_list  = (array) $this->input->post('reff');
        $debet_list = (array) $this->input->post('debet');
        $kredit_list = (array) $this->input->post('kredit');

        if (!in_array($kolom_status, ['status_jurnal_do', 'status_jurnal_confirm'], true)) {
            echo json_encode(['save' => 0, 'msg' => 'Jenis jurnal tidak valid.']);
            return;
        }
        if (empty($reff) || empty($types) || empty($tgl_inv)) {
            echo json_encode(['save' => 0, 'msg' => 'Data jurnal tidak lengkap.']);
            return;
        }

        $this->db->trans_begin();

        // Kunci baris DO lalu cek belum dijurnal.
        $do = $this->db->query("SELECT no_do, $kolom_status AS sudah FROM tr_delivery_order WHERE no_do = ? FOR UPDATE", [$reff])->row();
        if (!$do) {
            $this->db->trans_rollback();
            echo json_encode(['save' => 0, 'msg' => 'Delivery Order tidak ditemukan.']);
            return;
        }
        if ($do->sudah == '1') {
            $this->db->trans_rollback();
            echo json_encode(['save' => 0, 'msg' => 'Jurnal DO ini sudah pernah disimpan.']);
            return;
        }

        $Nomor_JV = $this->Jurnal_model->get_Nomor_Jurnal_Sales('101', $tgl_inv);

        $this->db->insert(DBACC . '.javh', [
            'nomor'         => $Nomor_JV,
            'tgl'           => $tgl_inv,
            'jml'           => $total,
            'koreksi_no'    => '-',
            'kdcab'         => '101',
            'jenis'         => 'JV',
            'keterangan'    => $keterangan,
            'bulan'         => substr($tgl_inv, 5, 2),
            'tahun'         => substr($tgl_inv, 0, 4),
            'user_id'       => $this->auth->user_id(),
            'memo'          => '',
            'tgl_jvkoreksi' => $tgl_inv,
            'ho_valid'      => '',
        ]);

        foreach ($types as $i => $tipe) {
            $this->db->insert(DBACC . '.jurnal', [
                'tipe'         => $tipe,
                'nomor'        => $Nomor_JV,
                'tanggal'      => $tgl_list[$i] ?? $tgl_inv,
                'no_perkiraan' => $coa_list[$i] ?? '',
                'keterangan'   => $ket_list[$i] ?? '',
                'no_reff'      => $reff_list[$i] ?? $reff,
                'debet'        => round((float) ($debet_list[$i] ?? 0)),
                'kredit'       => round((float) ($kredit_list[$i] ?? 0)),
            ]);
        }

        $this->db->query("UPDATE " . DBACC . ".pastibisa_tb_cabang SET nomorJC=nomorJC + 1 WHERE nocab='101'");
        $this->db->query("UPDATE tr_delivery_order SET $kolom_status='1' WHERE no_do = ?", [$reff]);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(['save' => 0, 'msg' => 'GAGAL, simpan data..!!!']);
            return;
        }
        $this->db->trans_commit();
        echo json_encode(['save' => 1, 'msg' => 'SUKSES, simpan data..!!!']);
    }

    function jurnal_delivery()
    {
        $this->_tampil_jurnal_do('Delivery Order');
    }

    public function save_jurnal_delivery()
    {
        $this->_simpan_jurnal_do('status_jurnal_do');
    }

    function jurnal_confirmdelivery()
    {
        $this->_tampil_jurnal_do('Delivery Order Confirm');
    }

    public function save_jurnal_confirmdelivery()
    {
        $this->_simpan_jurnal_do('status_jurnal_confirm');
    }

    function jurnal_penerimaan_np()
    {
        //JURNAL PENERIMAAN NON PRODUK
        //TERJADI SAAT CREATE PENERIMAAN

        $id        = $this->uri->segment(4);
        $kodejurnal = $this->uri->segment(5);
        $ket = $this->uri->segment(6);
        $kd_bayar = $id;
        $no_request = $id;
        $data_bayar = $this->db->query("SELECT * FROM tr_invoice_np_payment WHERE kd_pembayaran = ?", [$kd_bayar])->row();
        if (!$data_bayar) {
            echo "<div class='alert alert-danger'>Penerimaan tidak ditemukan.</div>";
            return;
        }

        $tgl_byr             = $data_bayar->tgl_pembayaran;
        $kd_bank             = $data_bayar->kd_bank;
        $nama                = $data_bayar->nm_customer;

        // id_customer di tabel NP kosong pada data lama, jadi customer dicari lewat nama.
        $id_cust = $this->db->query("SELECT id_customer FROM master_customers WHERE name_customer LIKE ?", ['%' . $nama . '%'])->row();
        $idcust = !empty($id_cust) ? $id_cust->id_customer : '-';

        $No_Inv  = $kd_bayar;
        $Tgl_Inv = $tgl_byr;
        $keterangan_byr  = $data_bayar->keterangan;
        $jumlah_total    = round($data_bayar->jumlah_pembayaran_idr);
        $jumlah_terima   = round($data_bayar->jumlah_bank_idr);
        $biaya_admin     = round($data_bayar->biaya_admin_idr);
        $deposit         = round($data_bayar->tambah_lebih_bayar);

        $Keterangan_INV            = 'Penerimaan A/N ' . $nama . ' Kode Pembayaran. ' . $No_Inv . ',' . $keterangan_byr;

        $det_Jurnal                = array();
        $det_Jurnal[]            = array(
            'nomor'         => '',
            'tanggal'       => $Tgl_Inv,
            'tipe'          => 'BUM',
            'no_perkiraan'  => $kd_bank,
            'keterangan'    => $Keterangan_INV,
            'no_reff'       => $No_Inv,
            'debet'         => $jumlah_terima,
            'kredit'        => 0,
            'jenis_jurnal'  => $ket,
            'no_request'    => $no_request,

        );

        if ($biaya_admin != 0) {
            // Pada jurnal NP biaya admin ada di sisi kredit (berbeda dari jurnal produk). Perilaku lama dipertahankan.
            $det_Jurnal[]            = array(
                'nomor'         => '',
                'tanggal'       => $Tgl_Inv,
                'tipe'          => 'BUM',
                'no_perkiraan'  => '7201-01-02',
                'keterangan'    => $Keterangan_INV,
                'no_reff'       => $No_Inv,
                'debet'         => 0,
                'kredit'        => $biaya_admin,
                'jenis_jurnal'  => $ket,
                'no_request'    => $no_request,

            );
        }
        if ($deposit != 0) {
            $det_Jurnal[]            = array(
                'nomor'         => '',
                'tanggal'       => $Tgl_Inv,
                'tipe'          => 'BUM',
                'no_perkiraan'  => '2101-08-01',
                'keterangan'    => $Keterangan_INV,
                'no_reff'       => $No_Inv,
                'debet'         => 0,
                'kredit'        => $deposit,
                'jenis_jurnal'  => $ket,
                'no_request'    => $no_request,

            );
        }

        $data_jurnal = $this->db->query("SELECT * FROM tr_invoice_np_payment_detail WHERE kd_pembayaran = ?", [$kd_bayar])->result();

        foreach ($data_jurnal as $jr) {
            $jmlbayar   = $jr->total_bayar_idr;
            $invoice2    = $jr->no_invoice;

            $surat  = $this->db->query("SELECT no_invoice FROM tr_invoice_np_header WHERE id_invoice = ?", [$invoice2])->row();

            $Keterangan_            = 'INVOICE A/N ' . $nama . ' INV NO. ' . $invoice2 . ', ' . ($surat->no_invoice ?? '');

            $det_Jurnal[]              = array(
                'nomor'         => '',
                'tanggal'       => $Tgl_Inv,
                'tipe'          => 'BUM',
                'no_perkiraan'  => '1104-01-01',
                'keterangan'    => $Keterangan_,
                'no_reff'       => $No_Inv,
                'debet'         => 0,
                'kredit'        => $jmlbayar,
                'jenis_jurnal'  => $ket,
                'no_request'    => $no_request,
            );
        }

        $this->db->where('no_reff', $id);
        $this->db->where('jenis_jurnal', $ket);
        $this->db->delete('jurnal');

        $this->db->insert_batch('jurnal', $det_Jurnal);

        $noreff     = $id;
        $tipe        = 'BUM';
        $jenisjurnal = $ket;

        $data['list_data']         = $this->Jurnal_model->get_detail_jurnal($noreff, $tipe, $jenisjurnal);

        $data['data_perkiraan']    = $this->Acc_model->get_noperkiraan();
        $data['jenis']            = 'BUM';
        $data['akses']            = 'jurnal';
        $data['jenis_jurnal']    = $jenisjurnal;
        $data['po_no']            = $id;
        $data['total_po']        = $jumlah_total;
        $data['id_vendor']        = $idcust;
        $data['nama_vendor']    = $nama;
        $data['no_surat']        = $No_Inv;
        $this->load->view("v_detail_jurnal", $data);
    }

    public function save_jurnal_bum_np()
    {
        $this->auth->restrict('Penerimaan.Manage');
        $session     = $this->session->userdata('app_session');

        $tgl_inv     = $this->input->post('tgl_jurnal[0]');
        $keterangan  = $this->input->post('keterangan[0]');
        $reff        = $this->input->post('reff[0]');
        $total       = round((float) $this->input->post('total'));
        $id_vendor   = $this->input->post('vendor_id');
        $nama_vendor = $this->input->post('vendor_nm');

        $types       = (array) $this->input->post('type');
        $tgl_list    = (array) $this->input->post('tgl_jurnal');
        $coa_list    = (array) $this->input->post('no_coa');
        $ket_list    = (array) $this->input->post('keterangan');
        $reff_list   = (array) $this->input->post('reff');
        $jj_list     = (array) $this->input->post('jenisjurnal');
        $debet_list  = (array) $this->input->post('debet');
        $kredit_list = (array) $this->input->post('kredit');

        if (empty($reff) || empty($types) || empty($tgl_inv)) {
            echo json_encode(['save' => 0, 'msg' => 'Data jurnal tidak lengkap.']);
            return;
        }

        $this->db->trans_begin();

        // Kunci baris penerimaan NP lalu cek belum dijurnal (anti jurnal ganda).
        $pn = $this->db->query("SELECT status_jurnal FROM tr_invoice_np_payment WHERE kd_pembayaran = ? FOR UPDATE", [$reff])->row();
        if (!$pn) {
            $this->db->trans_rollback();
            echo json_encode(['save' => 0, 'msg' => 'Penerimaan tidak ditemukan.']);
            return;
        }
        if ($pn->status_jurnal !== '0') {
            $this->db->trans_rollback();
            echo json_encode(['save' => 0, 'msg' => 'Jurnal penerimaan ini sudah pernah disimpan.']);
            return;
        }
        // Data lama: status_jurnal NP tidak pernah diubah, jadi jurnal BUM final yang tidak batal juga dianggap sudah dijurnal.
        $sudah = $this->db->query(
            "SELECT 1 AS ada FROM " . DBACC . ".jarh WHERE kd_pembayaran = ? AND COALESCE(batal, '0') <> '1' LIMIT 1",
            [$reff]
        )->row();
        if ($sudah) {
            $this->db->trans_rollback();
            echo json_encode(['save' => 0, 'msg' => 'Penerimaan ini sudah punya jurnal BUM.']);
            return;
        }

        ## NOMOR BUM ##
        $Nomor_BUM = $this->Jurnal_model->get_Nomor_Jurnal_BUM('101', $tgl_inv);

        $dataJARH = array(
            'nomor'             => $Nomor_BUM,
            'kd_pembayaran'     => $reff,
            'tgl'               => $tgl_inv,
            'jml'               => $total,
            'kdcab'             => '101',
            'jenis_reff'        => $reff,
            'no_reff'           => $reff,
            'customer'          => $nama_vendor,
            'terima_dari'       => '-',
            'jenis_ar'          => 'V',
            'note'              => $keterangan,
            'valid'             => $session['id_user'],
            'tgl_valid'         => $tgl_inv,
            'user_id'           => $session['id_user'],
            'tgl_invoice'       => $tgl_inv,
            'ho_valid'          => '',
            'batal'             => '0'
        );

        foreach ($types as $i => $tipe) {
            $perkiraan   = $coa_list[$i] ?? '';
            $noreff      = $reff_list[$i] ?? $reff;
            $jenisjurnal = $jj_list[$i] ?? '';
            $tgl_baris   = $tgl_list[$i] ?? $tgl_inv;
            $ket_baris   = $ket_list[$i] ?? '';
            $debet       = round((float) ($debet_list[$i] ?? 0));
            $kredit      = round((float) ($kredit_list[$i] ?? 0));

            $this->db->insert(DBACC . '.jurnal', array(
                'tipe'            => $tipe,
                'nomor'           => $Nomor_BUM,
                'tanggal'         => $tgl_baris,
                'no_perkiraan'    => $perkiraan,
                'keterangan'      => $ket_baris,
                'no_reff'         => $noreff,
                'debet'           => $debet,
                'kredit'          => $kredit
            ));

            if ($perkiraan == '1104-01-01' || $perkiraan == '2101-08-01') {
                $this->db->insert('tr_kartu_piutang', array(
                    'tipe'            => 'BUM',
                    'nomor'           => $Nomor_BUM,
                    'tanggal'         => $tgl_baris,
                    'no_perkiraan'    => $perkiraan,
                    'keterangan'      => $ket_baris,
                    'no_reff'         => $noreff,
                    'debet'           => $debet,
                    'kredit'          => $kredit,
                    'id_supplier'     => $id_vendor,
                    'nama_supplier'   => $nama_vendor,
                ));
            }

            $this->db->query(
                "UPDATE jurnal SET stspos=1 WHERE tipe = ? AND jenis_jurnal = ? AND no_reff = ?",
                [$tipe, $jenisjurnal, $noreff]
            );
        }

        ## INSERT JURNAL ##
        $this->db->insert(DBACC . '.jarh', $dataJARH);
        $this->db->query("UPDATE " . DBACC . ".pastibisa_tb_cabang SET nobum=nobum + 1 WHERE nocab='101'");
        $this->db->query("UPDATE tr_invoice_np_payment SET status_jurnal='1' WHERE kd_pembayaran = ?", [$reff]);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(['save' => 0, 'msg' => 'GAGAL, simpan data..!!!']);
            return;
        }
        $this->db->trans_commit();
        echo json_encode(['save' => 1, 'msg' => 'SUKSES, simpan data..!!!']);
    }
}
