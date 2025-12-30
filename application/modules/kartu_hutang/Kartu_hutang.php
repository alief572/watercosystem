<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kartu_hutang extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Kartu_hutang_model');
        $this->load->library('pagination');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    // Display list with pagination
    public function index() {
        $config['base_url'] = base_url('kartu_hutang/index');
        $config['total_rows'] = $this->Kartu_hutang_model->count_all();
        $config['per_page'] = 10;
        $config['uri_segment'] = 3;
        
        // Bootstrap 4 pagination styling
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['attributes'] = array('class' => 'page-link');

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $search = $this->input->get('search');

        $data['kartu_hutang'] = $this->Kartu_hutang_model->get_all($config['per_page'], $page, $search);
        $data['pagination'] = $this->pagination->create_links();
        $data['search'] = $search;

        $this->load->view('kartu_hutang/index', $data);
    }

    // Display create form
    public function create() {
        $this->load->view('kartu_hutang/create');
    }

    // Store new record
    public function store() {
        $this->form_validation->set_rules('nomor', 'Nomor', 'required|max_length[50]');
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
        $this->form_validation->set_rules('no_perkiraan', 'No Perkiraan', 'required|max_length[10]');
        $this->form_validation->set_rules('jenis_trans', 'Jenis Transaksi', 'required|max_length[20]');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('kartu_hutang/create');
        }

        // Check if nomor already exists
        if ($this->Kartu_hutang_model->check_nomor_exists($this->input->post('nomor'))) {
            $this->session->set_flashdata('error', 'Nomor sudah digunakan');
            redirect('kartu_hutang/create');
        }

        $data = array(
            'tipe' => $this->input->post('tipe'),
            'nomor' => $this->input->post('nomor'),
            'tanggal' => $this->input->post('tanggal'),
            'no_perkiraan' => $this->input->post('no_perkiraan'),
            'keterangan' => $this->input->post('keterangan'),
            'jenis_trans' => $this->input->post('jenis_trans'),
            'no_reff' => $this->input->post('no_reff'),
            'debet' => $this->input->post('debet') ?: 0,
            'kredit' => $this->input->post('kredit') ?: 0,
            'nocust' => $this->input->post('nocust'),
            'valid' => $this->input->post('valid'),
            'waktu_valid' => $this->input->post('waktu_valid'),
            'stspos' => $this->input->post('stspos'),
            'jenis_jurnal' => $this->input->post('jenis_jurnal'),
            'id_supplier' => $this->input->post('id_supplier'),
            'nama_supplier' => $this->input->post('nama_supplier'),
            'no_request' => $this->input->post('no_request'),
            'debet_usd' => $this->input->post('debet_usd') ?: 0,
            'kredit_usd' => $this->input->post('kredit_usd') ?: 0
        );

        if ($this->Kartu_hutang_model->insert($data)) {
            $this->session->set_flashdata('success', 'Data berhasil ditambahkan');
        } else {
            $this->session->set_flashdata('error', 'Gagal menambahkan data');
        }

        redirect('kartu_hutang');
    }

    // Display edit form
    public function edit($id) {
        $data['kartu_hutang'] = $this->Kartu_hutang_model->get_by_id($id);
        
        if (!$data['kartu_hutang']) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect('kartu_hutang');
        }

        $this->load->view('kartu_hutang/edit', $data);
    }

    // Update record
    public function update($id) {
        // Get current data
        $current_data = $this->Kartu_hutang_model->get_by_id($id);
        if (!$current_data) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect('kartu_hutang');
        }

        $this->form_validation->set_rules('nomor', 'Nomor', 'required|max_length[50]');
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
        $this->form_validation->set_rules('no_perkiraan', 'No Perkiraan', 'required|max_length[10]');
        $this->form_validation->set_rules('jenis_trans', 'Jenis Transaksi', 'required|max_length[20]');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('kartu_hutang/edit/' . $id);
        }

        // Check if nomor changed and already exists
        $new_nomor = $this->input->post('nomor');
        if ($new_nomor != $current_data->nomor) {
            if ($this->Kartu_hutang_model->check_nomor_exists($new_nomor)) {
                $this->session->set_flashdata('error', 'Nomor sudah digunakan oleh data lain');
                redirect('kartu_hutang/edit/' . $id);
            }
        }

        $data = array(
            'tipe' => $this->input->post('tipe'),
            'nomor' => $this->input->post('nomor'),
            'tanggal' => $this->input->post('tanggal'),
            'no_perkiraan' => $this->input->post('no_perkiraan'),
            'keterangan' => $this->input->post('keterangan'),
            'jenis_trans' => $this->input->post('jenis_trans'),
            'no_reff' => $this->input->post('no_reff'),
            'debet' => $this->input->post('debet') ?: 0,
            'kredit' => $this->input->post('kredit') ?: 0,
            'nocust' => $this->input->post('nocust'),
            'valid' => $this->input->post('valid'),
            'waktu_valid' => $this->input->post('waktu_valid'),
            'stspos' => $this->input->post('stspos'),
            'jenis_jurnal' => $this->input->post('jenis_jurnal'),
            'id_supplier' => $this->input->post('id_supplier'),
            'nama_supplier' => $this->input->post('nama_supplier'),
            'no_request' => $this->input->post('no_request'),
            'debet_usd' => $this->input->post('debet_usd') ?: 0,
            'kredit_usd' => $this->input->post('kredit_usd') ?: 0
        );

        if ($this->Kartu_hutang_model->update($id, $data)) {
            $this->session->set_flashdata('success', 'Data berhasil diupdate');
        } else {
            $this->session->set_flashdata('error', 'Gagal mengupdate data');
        }

        redirect('kartu_hutang');
    }

    // Delete record
    public function delete($id) {
        if ($this->Kartu_hutang_model->delete($id)) {
            $this->session->set_flashdata('success', 'Data berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data');
        }

        redirect('kartu_hutang');
    }

    // View detail
    public function view($id) {
        $data['kartu_hutang'] = $this->Kartu_hutang_model->get_by_id($id);
        
        if (!$data['kartu_hutang']) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect('kartu_hutang');
        }

        $this->load->view('kartu_hutang/view', $data);
    }
}