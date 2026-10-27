<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kartu_hutang_model extends CI_Model {

    private $table = 'tr_kartu_hutang';
    private $primary_key = 'id';

    public function __construct() {
        parent::__construct();
    }

    // Get all records with pagination
    public function get_all($limit = 10, $offset = 0, $search = '') {
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('nomor', $search);
            $this->db->or_like('no_reff', $search);
            $this->db->group_end();
        }
        
        $this->db->order_by('id', 'DESC');
        $this->db->limit($limit, $offset);
        return $this->db->get($this->table)->result();
    }

    // Count all records
    public function count_all($search = '') {
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('nomor', $search);
            $this->db->or_like('no_reff', $search);
            $this->db->group_end();
        }
        return $this->db->count_all_results($this->table);
    }

    // Get single record by ID
    public function get_by_id($id) {
        return $this->db->get_where($this->table, array($this->primary_key => $id))->row();
    }

    // Insert new record
    public function insert($data) {
        $insert_data = array(
            'tipe' => $data['tipe'],
            'nomor' => $data['nomor'],
            'tanggal' => $data['tanggal'],
            'no_perkiraan' => $data['no_perkiraan'],
            'keterangan' => $data['keterangan'],
            'jenis_trans' => $data['jenis_trans'],
            'no_reff' => $data['no_reff'],
            'debet' => $data['debet'],
            'kredit' => $data['kredit'],
            'nocust' => $data['nocust'],
            'valid' => $data['valid'],
            'waktu_valid' => !empty($data['waktu_valid']) ? $data['waktu_valid'] : null,
            'stspos' => $data['stspos'],
            'jenis_jurnal' => $data['jenis_jurnal'],
            'id_supplier' => $data['id_supplier'],
            'nama_supplier' => $data['nama_supplier'],
            'no_request' => $data['no_request'],
            'debet_usd' => $data['debet_usd'],
            'kredit_usd' => $data['kredit_usd']
        );
        
        return $this->db->insert($this->table, $insert_data);
    }

    // Update record
    public function update($id, $data) {
        $update_data = array(
            'tipe' => $data['tipe'],
            'nomor' => $data['nomor'],
            'tanggal' => $data['tanggal'],
            'no_perkiraan' => $data['no_perkiraan'],
            'keterangan' => $data['keterangan'],
            'jenis_trans' => $data['jenis_trans'],
            'no_reff' => $data['no_reff'],
            'debet' => $data['debet'],
            'kredit' => $data['kredit'],
            'nocust' => $data['nocust'],
            'valid' => $data['valid'],
            'waktu_valid' => !empty($data['waktu_valid']) ? $data['waktu_valid'] : null,
            'stspos' => $data['stspos'],
            'jenis_jurnal' => $data['jenis_jurnal'],
            'id_supplier' => $data['id_supplier'],
            'nama_supplier' => $data['nama_supplier'],
            'no_request' => $data['no_request'],
            'debet_usd' => $data['debet_usd'],
            'kredit_usd' => $data['kredit_usd']
        );
        
        $this->db->where($this->primary_key, $id);
        return $this->db->update($this->table, $update_data);
    }

    // Delete record
    public function delete($id) {
        $this->db->where($this->primary_key, $id);
        return $this->db->delete($this->table);
    }

    // Check if nomor exists
    public function check_nomor_exists($nomor, $exclude_id = null) {
        $this->db->where('nomor', $nomor);
        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }
        return $this->db->count_all_results($this->table) > 0;
    }
}