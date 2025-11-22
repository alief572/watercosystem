<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report_mutasi_stock extends Admin_Controller
{
    /*
 * @author Syamsudin
 * @copyright Copyright (c) 2022, Syamsudin
 * 
 * This is controller for Reports
 */

    //Permission
    protected $viewPermission     = 'Report_Mutasi_Stock.View';
    protected $addPermission      = 'Report_Mutasi_Stock.Add';
    protected $managePermission = 'Report_Mutasi_Stock.Manage';
    protected $deletePermission = 'Report_Mutasi_Stock.Delete';


    public function __construct()
    {
        parent::__construct();

        $this->load->model('Report_mutasi_stock/Report_mutasi_stock_model');

        $this->template->page_icon('fa fa-dashboard');
    }

    public function index()
    {
        $this->template->title('Reports');

        $this->template->render('index');
    }

    public function export_excel()
    {
        $tgl = $this->input->get('tgl');

        if (empty($tgl)) {
            $tgl = date('Y-m-d');
        }

        $get_data_mutasi_stock = $this->Report_mutasi_stock_model->get_data_mutasi_stock($tgl);

        $data = [
            'data_mutasi_stock' => $get_data_mutasi_stock,
            'tgl' => $tgl
        ];

        $this->load->view('export_excel', $data);
    }

    public function detail_mutasi()
    {
        $post = $this->input->post();

        $id_category3 = $post['id_category3'];
        $tgl = $post['tgl'];
        if (empty($tgl)) {
            $tgl = date('Y-m-d');
        }

        $get_data = $this->Report_mutasi_stock_model->get_kartu_mutasi_stock($id_category3, $tgl);
        $get_category3 = $this->Report_mutasi_stock_model->get_inventory3($id_category3);

        $nm_category3 = (!empty($get_category3->nama)) ? $get_category3->nama : '';


        $data = [
            'data_mutasi' => $get_data,
            'id_category3' => $id_category3,
            'nm_category3' => $nm_category3,
            'tgl' => $tgl
        ];

        $this->template->render('detail', $data);
    }

    public function export_excel_detail()
    {
        $id_category3 = $this->input->get('id_category3');
        $tgl = $this->input->get('tgl');

        $get_data = $this->Report_mutasi_stock_model->get_kartu_mutasi_stock($id_category3, $tgl);
        $get_category3 = $this->Report_mutasi_stock_model->get_inventory3($id_category3);

        $nm_category3 = (!empty($get_category3->nama)) ? $get_category3->nama : '';

        $data = [
            'data_mutasi' => $get_data,
            'id_category3' => $id_category3,
            'nm_category3' => $nm_category3,
            'tgl' => $tgl
        ];

        $this->load->view('export_excel_detail', $data);
    }

    public function get_data_report_mutasi_stock()
    {
        $post = $this->input->post();

        $draw = intval($post['draw']);
        $length = $post['length'];
        $start = $post['start'];
        $search = $post['search']['value'];

        $tgl = $post['tgl'];

        if (empty($tgl) || $tgl == date('Y-m-d')) {
            $this->db->select('a.*, b.qty_free as qty, c.nilai_costbook');
            $this->db->from('ms_inventory_category3 a');
            $this->db->join('stock_material b', 'b.id_category3 = a.id_category3');
            $this->db->join('ms_costbook c', 'c.id_category3 = a.id_category3');
            $this->db->where('b.deleted', null);
        } else {
            $this->db->select('a.*, b.qty_free as qty, c.nilai_costbook');
            $this->db->from('ms_inventory_category3 a');
            $this->db->join('stock_material_backup b', 'b.id_category3 = a.id_category3');
            $this->db->join('ms_costbook_backup c', 'c.id_category3 = a.id_category3');
            $this->db->where('b.deleted', null);
            $this->db->like('b.tgl', $tgl, 'both');
            $this->db->like('c.tgl', $tgl, 'both');
        }

        $count_all = $this->db->count_all_results('', false);

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('a.id_category3', $search, 'both');
            $this->db->or_like('a.nama', $search, 'both');
            $this->db->or_like('b.qty_free', $search, 'both');
            $this->db->or_like('c.nilai_costbook', $search, 'both');
            $this->db->group_end();
        }

        $count_filtered = $this->db->count_all_results('', false);

        $this->db->order_by('a.id_category3', 'asc');
        $this->db->limit($length, $start);
        $get_data = $this->db->get()->result();

        $no = (0 + $start);
        $hasil = [];

        $ttl_total = 0;

        foreach ($get_data as $item) {
            $no++;

            if (!empty($tgl)) {
                $tanggal = date('d F Y', strtotime($tgl));
            } else {
                $tanggal = date('d F Y');
            }

            $action = '<button type="button" class="btn btn-sm btn-info detail" data-id_category3="' . $item->id_category3 . '" title="View Mutasi"><i class="fa fa-eye"></i></button>';

            $hasil[] = [
                'no' => $no,
                'tgl' => $tanggal,
                'nomor' => $item->id_category3,
                'nama_barang' => $item->nama,
                'qty' => number_format($item->qty),
                'costbook' => number_format($item->nilai_costbook),
                'total' => number_format($item->nilai_costbook * $item->qty),
                'action' => $action
            ];

            $ttl_total += ($item->nilai_costbook * $item->qty);
        }

        $response = [
            'draw' => $draw,
            'recordsTotal' => $count_all,
            'recordsFiltered' => $count_filtered,
            'data' => $hasil,
            'ttl_total' => $ttl_total
        ];

        echo json_encode($response);
    }
}
