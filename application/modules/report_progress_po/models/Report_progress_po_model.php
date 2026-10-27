<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once dirname(__DIR__) . '/libraries/Progress_po_rules.php';

class Report_progress_po_model extends CI_Model
{
    public function get_suppliers()
    {
        return $this->db->select('s.id_suplier, s.name_suplier')->distinct()
            ->from('master_supplier s')->join('tr_purchase_order p', 'p.id_suplier = s.id_suplier')
            ->where_in('p.status', array('2', '3'))->order_by('s.name_suplier', 'ASC')->get()->result_array();
    }

    public function get_dataset($filters, $id = null)
    {
        $this->db->select('p.*, s.name_suplier AS supplier')->from('tr_purchase_order p')
            ->join('master_supplier s', 's.id_suplier = p.id_suplier', 'left')
            ->where_in('p.status', array('2', '3'))
            ->where_in('UPPER(TRIM(p.matauang))', array('USD', 'IDR'));
        if ($id !== null) { $this->db->where('p.no_po', $id); }
        $this->db->where('p.tanggal >=', $filters['start_date'])->where('p.tanggal <=', $filters['end_date']);
        if ($filters['supplier_id'] !== '') { $this->db->where('p.id_suplier', $filters['supplier_id']); }
        if ($filters['type'] !== '') { $this->db->where('p.loi', $filters['type']); }
        if ($filters['currency'] !== '') { $this->db->where('UPPER(TRIM(p.matauang))', $filters['currency']); }
        $pos = $this->db->order_by('p.tanggal', 'DESC')->order_by('p.no_po', 'DESC')->get()->result_array();
        $items = array(); $receipts = array(); $headers = array();
        foreach (array_chunk(array_column($pos, 'no_po'), 400) as $keys) {
            foreach ($this->db->from('dt_trans_po')->where_in('no_po', $keys)->order_by('id_dt_po', 'ASC')->get()->result_array() as $item) {
                $items[$item['no_po']][] = $item;
            }
            $incoming = $this->db->select('d.*, p.no_po AS report_po')->from('dt_incoming d')
                ->join('dt_trans_po p', 'p.id_dt_po = d.id_dt_po')->where_in('p.no_po', $keys)
                ->order_by('d.id_dt_incoming', 'ASC')->get()->result_array();
            foreach ($incoming as $receipt) { $receipts[$receipt['report_po']][] = $receipt; }
            $headerKeys = array_values(array_unique(array_column($incoming, 'id_data')));
            foreach (array_chunk($headerKeys, 400) as $chunk) {
                $found = $this->db->select('id_data, id_incoming, tanggal, kurs, matauang, pib')
                    ->from('tr_incoming')->where_in('id_data', $chunk)->get()->result_array();
                // Retain ambiguity rather than selecting an arbitrary duplicate header.
                $grouped = array();
                foreach ($found as $header) { $grouped[$header['id_data']][] = $header; }
                foreach ($grouped as $key => $values) { $headers[$key] = count($values) === 1 ? $values[0] : null; }
            }
        }
        $rules = new Progress_po_rules(); $rows = array();
        foreach ($pos as $po) {
            $poItems = isset($items[$po['no_po']]) ? $items[$po['no_po']] : array();
            $poReceipts = isset($receipts[$po['no_po']]) ? $receipts[$po['no_po']] : array();
            foreach ($poReceipts as &$receipt) {
                $header = isset($headers[$receipt['id_data']]) ? $headers[$receipt['id_data']] : null;
                $receipt['header_id'] = $header ? $header['id_data'] : null;
                foreach (array('tanggal', 'kurs', 'matauang', 'pib') as $field) { $receipt[$field] = $header ? $header[$field] : null; }
                if ($header) { $receipt['id_incoming'] = $header['id_incoming']; }
            }
            unset($receipt);
            $row = $rules->calculate($po, $poItems, $poReceipts);
            $rows[] = $row;
        }
        $total = count($rows);
        $rows = array_values(array_filter($rows, function ($row) use ($filters) {
            if ($filters['status'] === 'bermasalah' && !$row['issues']) { return false; }
            if ($filters['status'] !== '' && $filters['status'] !== 'bermasalah' && $row['status_code'] !== $filters['status']) { return false; }
            if ($filters['search'] === '') { return true; }
            $text = implode(' ', array($row['number'], $row['supplier'], $row['description'], $row['currency'], $row['status']));
            foreach ($row['items'] as $item) {
                $text .= ' ' . $item['name'];
                foreach ($item['receipts'] as $receipt) { $text .= ' ' . $receipt['number'] . ' ' . $receipt['pib']; }
            }
            return mb_stripos($text, $filters['search'], 0, 'UTF-8') !== false;
        }));
        return array_merge(array('rows' => $rows, 'records_total' => $total,
            'generated_at' => (new DateTimeImmutable('now', new DateTimeZone('Asia/Jakarta')))->format('Y-m-d H:i:s')),
            $rules->summarize($rows, $filters['start_date'], $filters['end_date']));
    }
}
