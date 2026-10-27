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

class Cronjob extends Admin_Controller
{
    //Permission

    public function __construct()
    {
        parent::__construct();

        date_default_timezone_set('Asia/Bangkok');
    }

    public function cronjob_costbook()
    {
        $this->db->select('a.id, a.id_category3, a.nilai_costbook, a.created_by, a.created_on, a.modified_by, a.modified_on');
        $this->db->from('ms_costbook a');
        $get_costbook = $this->db->get()->result();

        $arr_insert_backup = [];

        foreach ($get_costbook as $item) {
            $arr_insert_backup[] = [
                'id_category3' => $item->id_category3,
                'nilai_costbook' => $item->nilai_costbook,
                'created_by' => $item->created_by,
                'created_on' => $item->created_on,
                'modified_by' => $item->modified_by,
                'modified_on' => $item->modified_on,
                'tgl' => date('Y-m-d H:i:s')
            ];
        }

        $this->db->trans_begin();

        $insert_backup = $this->db->insert_batch('ms_costbook_backup', $arr_insert_backup);
        if (!$insert_backup) {
            $this->db->trans_rollback();

            $response = [
                'status' => 0,
                'msg' => $this->db->error()['message']
            ];

            print_r($response);
        }

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();

            $response = [
                'status' => 0,
                'msg' => 'Please try again later !'
            ];
        } else {
            $this->db->trans_commit();

            $response = [
                'status' => 1,
                'msg' => 'Success !'
            ];
        }

        print_r($response);
    }

    public function cronjob_product_price_list()
    {
        $get_ms_product_pricelist = $this->db->get('ms_product_pricelist')->result();

        $arr_insert_backup = [];

        foreach ($get_ms_product_pricelist as $item) {
            $arr_insert_backup[] = [
                'id_formula' => $item->id_formula,
                'id_type' => $item->id_type,
                'id_category1' => $item->id_category1,
                'id_category2' => $item->id_category2,
                'id_category3' => $item->id_category3,
                'nama_category2' => $item->nama_category2,
                'revisi' => $item->revisi,
                'harga_beli' => $item->harga_beli,
                'total_pricelist' => $item->total_pricelist,
                'kurs' => $item->kurs,
                'harga_rupiah' => $item->harga_rupiah,
                'created_by' => $item->created_by,
                'created_on' => $item->created_on,
                'modified_by' => $item->modified_by,
                'modified_on' => $item->modified_on,
                'deleted_by' => $item->deleted_by,
                'deleted' => $item->deleted,
                'aktif' => $item->aktif
            ];
        }

        $this->db->trans_begin();

        $insert_backup = $this->db->insert_batch('ms_product_pricelist_backup', $arr_insert_backup);
        if (!$insert_backup) {
            $this->db->trans_rollback();

            $response = [
                'status' => 0,
                'msg' => $this->db->error()['message']
            ];

            print_r($response);
        }

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();

            $response = [
                'status' => 0,
                'msg' => 'Please try again later !'
            ];
        } else {
            $this->db->trans_commit();

            $response = [
                'status' => 1,
                'msg' => 'Success !'
            ];
        }

        print_r($response);
    }

    public function cronjob_stock_material()
    {
        $get_stock_material = $this->db->get('stock_material')->result();

        $arr_insert_backup = [];

        foreach ($get_stock_material as $item) {
            $arr_insert_backup[] = [
                'id_category3' => $item->id_category3,
                'nama_material' => $item->nama_material,
                'width' => $item->width,
                'length' => $item->length,
                'id_bentuk' => $item->id_bentuk,
                'lotno' => $item->lotno,
                'qty' => $item->qty,
                'qty_book' => $item->qty_book,
                'qty_free' => $item->qty_free,
                'booking' => $item->booking,
                'thickness' => $item->thickness,
                'aktif' => $item->aktif,
                'id_gudang' => $item->id_gudang,
                'created_by' => $item->created_by,
                'created_on' => $item->created_on,
                'modified_by' => $item->modified_by,
                'modified_on' => $item->modified_on,
                'deleted' => $item->deleted,
                'deleted_by' => $item->deleted_by,
                'no_po' => $item->no_po,
                'id_incoming' => $item->id_incoming,
                'keterangan' => $item->keterangan,
                'id_roll' => $item->id_roll,
                'tgl' => date('Y-m-d H:i:s')
            ];
        }

        $this->db->trans_begin();

        $insert_backup = $this->db->insert_batch('stock_material_backup', $arr_insert_backup);
        if (!$insert_backup) {
            $this->db->trans_rollback();

            $response = [
                'status' => 0,
                'msg' => $this->db->error()['message']
            ];

            print_r($response);
            exit;
        }

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();

            $response = [
                'status' => 0,
                'msg' => 'Please try again later !'
            ];
        } else {
            $this->db->trans_commit();

            $response = [
                'status' => 1,
                'msg' => 'Success !'
            ];
        }

        print_r($response);
    }
}
