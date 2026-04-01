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

class Jurnal_adjustment extends Admin_Controller
{
    //Permission
    protected $viewPermission     = 'Jurnal_Adjustment.View';
    protected $addPermission      = 'Jurnal_Adjustment.Add';
    protected $managePermission = 'Jurnal_Adjustment.Manage';
    protected $deletePermission = 'Jurnal_Adjustment.Delete';

    public function __construct()
    {
        parent::__construct();

        $this->load->library(array('Mpdf', 'upload', 'Image_lib'));
        $this->load->model(array(
            'Jurnal_adjustment/Jurnal_adjustment_model',
            'Aktifitas/aktifitas_model',
        ));
        $this->template->title('Manage Data Supplier');
        $this->template->page_icon('fa fa-building-o');

        date_default_timezone_set('Asia/Bangkok');
    }

    public function index()
    {
        $this->template->title('Jurnal Adjustment');
        $this->template->render('index');
    }

    public function get_dataa_adjustment()
    {
        $draw = $this->input->get('draw', true);
        $length = $this->input->get('length', true);
        $start = $this->input->get('start', true);
        $search = $this->input->get('search', true);

        $get_data = $this->Jurnal_adjustment_model->get_data_adjustment(['draw' => $draw, 'length' => $length, 'start' => $start, 'search' => $search['value']]);

        $count_all = (!empty($get_data['count_all'])) ? $get_data['count_all'] : 0;
        $count_filter = (!empty($get_data['count_filter'])) ? $get_data['count_filter'] : 0;

        $no = (0 + $start);
        $hasil = [];

        if (!empty($get_data['data'])) {
            foreach ($get_data['data'] as $item) {
                $no++;

                $action = $this->_render_action_adjustment($item);

                $hasil[] = [
                    'no' => $no,
                    'no_transaksi' => $item->id_transaksi,
                    'tanggal' => date('d F Y', strtotime($item->tanggal_transaksi)),
                    'material' => $item->nama_material,
                    'tipe_adjust' => $item->adjustment,
                    'gudang' => $item->nama_gudang,
                    'keterangan' => $item->note,
                    'jumlah_stock' => number_format($item->total_qty),
                    'action' => $action
                ];
            }
        }

        $response = [
            'draw' => intval($draw),
            'recordsTotal' => $count_all,
            'recordsFiltered' => $count_filter,
            'data' => $hasil
        ];

        echo json_encode($response);
    }

    public function _render_action_adjustment($item)
    {
        $btn_jurnal = '';
        if (has_permission($this->managePermission)) {
            $btn_jurnal = '<button type="button" class="btn btn-sm btn-primary process_jurnal" data-id_transaksi="' . $item->id_transaksi . '" title="Process Jurnal Adjustment"><i class="fa fa-check"></i></button>';
        }

        $action = $btn_jurnal;

        return $action;
    }

    public function process_jurnal()
    {
        $id_transaksi = $this->input->get('id_transaksi', true);

        $get_adjustment = $this->Jurnal_adjustment_model->get_data_adjustment(null, $id_transaksi);

        $get_jurnal = $this->Jurnal_adjustment_model->get_jurnal($id_transaksi, $get_adjustment->adjustment);

        $data = [
            'data_adjustment' => $get_adjustment,
            'data_jurnal' => $get_jurnal
        ];

        $this->load->view('process_jurnal', $data);
    }

    public function save_post_jurnal_adjustment()
    {
        $id_transaksi = $this->input->post('id_transaksi', true);

        $this->db->trans_begin();

        try {
            $get_adjustment = $this->Jurnal_adjustment_model->get_data_adjustment('', $id_transaksi);

            $get_costbooks = $this->Jurnal_adjustment_model->get_costbook($get_adjustment->id_material, $get_adjustment->tanggal_transaksi);

            $nilai_costbook = (!empty($get_costbooks->nilai_costbook)) ? $get_costbooks->nilai_costbook : 0;

            $ttl = ($get_adjustment->total_qty * $nilai_costbook);

            $nomor = $this->Jurnal_adjustment_model->get_Nomor_Jurnal_Sales('101', date('Y-m-d'));

            $arr_jurnal_header = [
                'nomor' => $nomor,
                'tgl' => date('Y-m-d'),
                'jml' => $ttl,
                'koreksi_no' => '-',
                'kdcab' => '101',
                'jenis' => 'JV',
                'keterangan' => 'Adjustment ' . $get_adjustment->adjustment . ' ' . $id_transaksi,
                'bulan' => date('m'),
                'tahun' => date('Y'),
                'user_id' => $this->auth->user_id(),
                'memo' => '',
                'tgl_jvkoreksi' => date('Y-m-d'),
                'ho_valid' => ''
            ];

            $arr_jurnal_detail = [];

            $arr_coa = ['1105-01-01', '6201-01-51'];

            $this->db->select('a.no_perkiraan as no_coa, a.nama as nm_coa');
            $this->db->from(DBACC . '.coa_master a');
            $this->db->where_in('a.no_perkiraan', $arr_coa);
            $get_data_coa = $this->db->get()->result();

            foreach ($get_data_coa as $item_coa) {
                if ($get_adjustment->adjustment == 'PLUS') {
                    if ($item_coa->no_coa == '1105-01-01') {
                        $arr_jurnal_detail = [
                            'tipe' => 'JV',
                            'nomor' => $nomor,
                            'tanggal' => date('Y-m-d'),
                            'no_perkiraan' => $item_coa->no_coa,
                            'keterangan' => 'Adjustment ' . $get_adjustment->adjustment . ' ' . $id_transaksi,
                            'jenis_trans' => '',
                            'no_reff' => $id_transaksi,
                            'stspos' => '0',
                            'debet' => $ttl
                        ];
                    } else {
                        $arr_jurnal_detail = [
                            'tipe' => 'JV',
                            'nomor' => $nomor,
                            'tanggal' => date('Y-m-d'),
                            'no_perkiraan' => $item_coa->no_coa,
                            'keterangan' => 'Adjustment ' . $get_adjustment->adjustment . ' ' . $id_transaksi,
                            'jenis_trans' => '',
                            'no_reff' => $id_transaksi,
                            'stspos' => '0',
                            'kredit' => $ttl
                        ];
                    }
                } else {
                    if ($item_coa->no_coa == '1105-01-01') {
                        $arr_jurnal_detail = [
                            'tipe' => 'JV',
                            'nomor' => $nomor,
                            'tanggal' => date('Y-m-d'),
                            'no_perkiraan' => $item_coa->no_coa,
                            'keterangan' => 'Adjustment ' . $get_adjustment->adjustment . ' ' . $id_transaksi,
                            'jenis_trans' => '',
                            'no_reff' => $id_transaksi,
                            'stspos' => '0',
                            'kredit' => $ttl
                        ];
                    } else {
                        $arr_jurnal_detail = [
                            'tipe' => 'JV',
                            'nomor' => $nomor,
                            'tanggal' => date('Y-m-d'),
                            'no_perkiraan' => $item_coa->no_coa,
                            'keterangan' => 'Adjustment ' . $get_adjustment->adjustment . ' ' . $id_transaksi,
                            'jenis_trans' => '',
                            'no_reff' => $id_transaksi,
                            'stspos' => '0',
                            'debet' => $ttl
                        ];
                    }
                }

                $insert_jurnal_detail = $this->db->insert(DBACC . '.jurnal', $arr_jurnal_detail);
                if (!$insert_jurnal_detail) {
                    throw new Exception('Proses simpan jurnal ke TRAS gagal !');
                }
            }

            $insert_jurnal_header = $this->db->insert(DBACC . '.javh', $arr_jurnal_header);
            if (!$insert_jurnal_header) {
                throw new Exception('Proses simpan jurnal ke TRAS gagal !');
            }

            $update_adjustment_stock = $this->db->update('adjustment_stock', ['status_jurnal' => 'CLS'], ['id_transaksi' => $id_transaksi]);
            if (!$update_adjustment_stock) {
                throw new Exception('Proses simpan jurnal ke TRAS gagal !');
            }

            $Qry_Update_Cabang_acc     = $this->db->query("UPDATE " . DBACC . ".pastibisa_tb_cabang SET nomorJC = nomorJC + 1 WHERE nocab='101'");
            
            if (!$Qry_Update_Cabang_acc) {
                throw new Exception('Proses simpan jurnal ke TRAS gagal !');
            }

            $this->db->trans_commit();
            http_response_code(200);

            $response = [
                'code' => 200,
                'msg' => 'Selamat! Jurnal adjustment telah berhasil di proses ke TRAS !'
            ];

            echo json_encode($response);
        } catch (Exception $e) {
            $this->db->trans_rollback();
            http_response_code(500);

            $response = [
                'code' => 500,
                'msg' => $e->getMessage()
            ];

            echo json_encode($response);
        }
    }
}
