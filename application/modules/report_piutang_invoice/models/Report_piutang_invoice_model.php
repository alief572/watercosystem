<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_piutang_invoice_model extends CI_Model
{
    public function customers()
    {
        return $this->db->select('id_customer, name_customer')
            ->where('name_customer IS NOT NULL', null, false)->where("TRIM(name_customer) <> ''", null, false)
            ->order_by('name_customer', 'ASC')
            ->get('master_customers')->result_array();
    }

    public function customer_exists($id)
    {
        return $this->db->where('id_customer', $id)->count_all_results('master_customers') > 0;
    }

    public function dataset($filters)
    {
        $this->load->library('report_piutang_invoice/Piutang_invoice_dataset');
        $this->db->select('i.no_invoice, i.no_surat, i.tgl_invoice, i.nilai_invoice, i.printed_on, i.deleted_by, i.id_customer, i.total_bayar_idr, i.sisa_invoice_idr');
        $this->db->select("COALESCE(c.name_customer, i.id_customer, '') AS customer", false);
        $this->db->from('tr_invoice i')->join('master_customers c', 'c.id_customer = i.id_customer', 'left');
        $this->db->where('i.deleted_by IS NULL', null, false)->where('i.printed_on IS NOT NULL', null, false)
            ->where('i.printed_on >=', '1000-01-01 00:00:00')->where('i.tgl_invoice <=', $filters['tanggal']);
        if ($filters['customer_id'] !== '') {
            $this->db->where('i.id_customer', $filters['customer_id']);
        }
        if ($filters['no_invoice'] !== '') {
            $this->db->where('i.no_surat', $filters['no_invoice']);
        }
        $invoices = $this->db->get()->result_array();
        $keys = array();
        foreach ($invoices as $invoice) {
            $keys[] = $invoice['no_invoice'];
        }
        $details = array();
        foreach (array_chunk($keys, 500) as $chunk) {
            $this->detail_query();
            $batch = $this->db->where_in('d.no_invoice', $chunk)->get()->result_array();
            $details = array_merge($details, $batch);
        }
        // Orphan allocations have no display invoice number; search their internal reference instead.
        $this->detail_query();
        $this->db->select("COALESCE(NULLIF(d.nm_customer, ''), p.nm_customer, '') AS customer", false);
        $this->db->join('tr_invoice i', 'i.no_invoice = d.no_invoice', 'left')->where('i.id IS NULL', null, false);
        if ($filters['customer_id'] !== '') {
            $this->db->where("COALESCE(NULLIF(d.id_customer, ''), p.id_customer) = " . $this->db->escape($filters['customer_id']), null, false);
        }
        if ($filters['no_invoice'] !== '') {
            // A dropdown selection identifies an existing display invoice, not an orphan reference.
            $this->db->where('1 = 0', null, false);
        }
        $orphans = $this->db->get()->result_array();
        return $this->piutang_invoice_dataset->build($invoices, $details, $orphans, $filters['tanggal']);
    }

    private function detail_query()
    {
        $this->db->select('d.no_invoice, d.kd_pembayaran, d.total_bayar_idr, d.cancel_by, d.cancel_date, p.id AS header_id, p.tgl_pembayaran, p.status_bayar, p.is_cancel, p.cancel_on, p.cancel_by AS header_cancel_by');
        $this->db->from('tr_invoice_payment_detail d')->join('tr_invoice_payment p', 'p.kd_pembayaran = d.kd_pembayaran', 'left');
    }
}
