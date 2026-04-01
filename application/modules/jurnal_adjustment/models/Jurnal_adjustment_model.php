<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * @author Yunas Handra
 * @copyright Copyright (c) 2018, Yunas Handra
 *
 * This is model class for table "Customer"
 */

class Jurnal_adjustment_model extends BF_Model
{
    public function get_data_adjustment($arr_datatable = null, $id_transaksi = null)
    {
        $this->db->select('a.*');
        $this->db->from('adjustment_stock a');
        if (!empty($arr_datatable)) {
            $this->db->group_start();
            $this->db->where('a.status_jurnal !=', 'CLS');
            $this->db->or_where('a.status_jurnal IS NULL');
            $this->db->group_end();

            $count_all = $this->db->count_all_results('', false);

            if (!empty($arr_datatable['search'])) {
                $search = $arr_datatable['search'];
                $this->db->group_start();
                $this->db->like('a.id_transaksi', $search, 'both');
                $this->db->or_like('DATE_FORMAT(a.tanggal_transaksi, "%d %M %Y")', $search, 'both');
                $this->db->or_like('a.nama_material', $search, 'both');
                $this->db->or_like('a.adjustment', $search, 'both');
                $this->db->or_like('a.nama_gudang', $search, 'both');
                $this->db->or_like('a.note', $search, 'both');
                $this->db->or_like('a.total_qty', $search, 'both');
                $this->db->group_end();
            }

            $count_filter = $this->db->count_all_results('', false);

            $this->db->order_by('a.tanggal_transaksi', 'desc');
            $this->db->limit($arr_datatable['length'], $arr_datatable['start']);

            $get_data = $this->db->get()->result();

            $response = [
                'count_all' => $count_all,
                'count_filter' => $count_filter,
                'data' => $get_data
            ];

            return $response;
        } else {
            if (!empty($id_transaksi)) {
                $this->db->where('id_transaksi', $id_transaksi);
                $get_data = $this->db->get()->row();

                return $get_data;
            } else {
                $get_data = $this->db->get()->result();

                return $get_data;
            }
        }
    }

    public function get_costbook($id_material, $tgl)
    {
        if ($tgl == date('Y-m-d')) {
            $this->db->select('a.nilai_costbook');
            $this->db->from('ms_costbook a');
            $this->db->where('a.id_category3', $id_material);
            $get_data = $this->db->get()->row();
        } else {
            $this->db->select('a.nilai_costbook');
            $this->db->from('ms_costbook_backup a');
            $this->db->where('a.id_category3', $id_material);
            $this->db->where('DATE_FORMAT(a.tgl, "%Y-%m-%d") >=', $tgl);
            $this->db->where('DATE_FORMAT(a.tgl, "%Y-%m-%d") <=', $tgl);
            $this->db->order_by('a.tgl', 'desc');
            $this->db->limit(1);
            $get_data = $this->db->get()->row();
        }

        return $get_data;
    }

    public function get_jurnal($id_transaksi, $adjustment)
    {
        if ($adjustment == 'PLUS') {
        }

        $get_adjustment = $this->get_data_adjustment(null, $id_transaksi);

        $get_costbooks = $this->get_costbook($get_adjustment->id_material, $get_adjustment->tanggal_transaksi);

        $nilai_costbook = (!empty($get_costbooks->nilai_costbook)) ? $get_costbooks->nilai_costbook : 0;

        $arr_coa = ['1105-01-01', '6201-01-51'];

        $this->db->select('a.no_perkiraan as no_coa, a.nama as nm_coa');
        $this->db->from(DBACC . '.coa_master a');
        $this->db->where_in('a.no_perkiraan', $arr_coa);
        $get_data_coa = $this->db->get()->result();

        $hasil = [];

        foreach ($get_data_coa as $item_coa) {
            $debit = 0;
            $kredit = 0;

            if ($adjustment == 'PLUS') {
                if ($item_coa->no_coa == '1105-01-01') {
                    $debit = ($get_adjustment->total_qty * $nilai_costbook);
                } else {
                    $kredit = ($get_adjustment->total_qty * $nilai_costbook);
                }
            } else {
                if ($item_coa->no_coa == '1105-01-01') {
                    $kredit = ($get_adjustment->total_qty * $nilai_costbook);
                } else {
                    $debit = ($get_adjustment->total_qty * $nilai_costbook);
                }
            }

            $hasil[] = [
                'tanggal' => $get_adjustment->tanggal_transaksi,
                'tipe' => $get_adjustment->adjustment,
                'no_coa' => $item_coa->no_coa,
                'keterangan' => $item_coa->nm_coa,
                'no_reff' => $id_transaksi,
                'debit' => $debit,
                'kredit' => $kredit
            ];
        }



        return $hasil;
    }

    function get_Nomor_Jurnal_Sales($Cabang = '', $Tgl_Inv = '')
    {
        // $db2 = $this->load->database('accounting', TRUE);
        $nocab            = 'A';
        $bulan_Proses    = date('Y', strtotime($Tgl_Inv));
        $Urut            = 1;
        $Query_Cab        = "SELECT subcab,nomorJC FROM " . DBACC . ".pastibisa_tb_cabang WHERE nocab='" . $Cabang . "'";
        $Pros_Cab        = $this->db->query($Query_Cab);
        $det_Cab        = $Pros_Cab->result_array();
        if ($det_Cab) {
            $nocab        = $det_Cab[0]['subcab'];
            $Urut        = intval($det_Cab[0]['nomorJC']) + 1;
        }
        $Format            = $Cabang . '-' . $nocab . 'JV' . date('y', strtotime($Tgl_Inv));

        $Nomor_JS        = $Format . str_pad($Urut, 5, "0", STR_PAD_LEFT);

        return $Nomor_JS;
    }
}
