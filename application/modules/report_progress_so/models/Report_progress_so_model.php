<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report_progress_so_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get list of customers for filter dropdown
     */
    public function get_customers()
    {
        return $this->db->select('id_customer, name_customer')
            ->from('master_customers')
            ->where('deleted', '0')
            ->where('name_customer IS NOT NULL', null, false)
            ->where("TRIM(name_customer) <> ''", null, false)
            ->order_by('name_customer', 'ASC')
            ->get()
            ->result_array();
    }

    /**
     * Get list of sales for filter dropdown
     */
    public function get_sales()
    {
        return $this->db->select('DISTINCT(nama_sales) as nama_sales', false)
            ->from('tr_sales_order')
            ->where('deleted_by IS NULL', null, false)
            ->where('nama_sales IS NOT NULL', null, false)
            ->where("TRIM(nama_sales) <> ''", null, false)
            ->order_by('nama_sales', 'ASC')
            ->get()
            ->result_array();
    }

    /**
     * Get dataset for Tab 1: Progress Nilai SO
     */
    public function get_progress_so_dataset($filters)
    {
        // 1. Fetch Sales Orders matching filters
        $this->db->select('so.no_so, so.no_surat, so.tgl_so, so.id_customer, so.nama_sales, so.grand_total, so.reff');
        $this->db->select("COALESCE(c.name_customer, so.id_customer, '') AS customer_name", false);
        $this->db->from('tr_sales_order so');
        $this->db->join('master_customers c', 'c.id_customer = so.id_customer', 'left');
        $this->db->where('so.deleted_by IS NULL', null, false);

        if (!empty($filters['start_date'])) {
            $this->db->where('so.tgl_so >=', $filters['start_date']);
        }
        if (!empty($filters['end_date'])) {
            $this->db->where('so.tgl_so <=', $filters['end_date']);
        }
        if (!empty($filters['customer_id'])) {
            $this->db->where('so.id_customer', $filters['customer_id']);
        }
        if (!empty($filters['sales_name'])) {
            $this->db->where('so.nama_sales', $filters['sales_name']);
        }

        $this->db->order_by('so.tgl_so', 'DESC');
        $this->db->order_by('so.no_so', 'DESC');
        $so_records = $this->db->get()->result_array();

        if (empty($so_records)) {
            return array(
                'rows' => array(),
                'totals' => array(
                    'total_value_so' => 0,
                    'total_invoice' => 0,
                    'total_outstanding_so' => 0,
                    'total_payment' => 0,
                    'total_outstanding_piutang' => 0,
                    'avg_persen_tertagih' => 0,
                    'avg_persen_terbayar' => 0,
                    'count_so' => 0
                )
            );
        }

        // Collect all internal no_so keys
        $so_keys = array();
        foreach ($so_records as $r) {
            $so_keys[] = $r['no_so'];
        }

        // 2. Fetch Item Summaries from tr_sales_order_detail
        $items_by_so = array();
        foreach (array_chunk($so_keys, 500) as $chunk) {
            $details = $this->db->select('no_so, nama_produk, qty_so')
                ->from('tr_sales_order_detail')
                ->where_in('no_so', $chunk)
                ->order_by('id_so_detail', 'ASC')
                ->get()
                ->result_array();

            foreach ($details as $d) {
                $n_so = $d['no_so'];
                if (!isset($items_by_so[$n_so])) {
                    $items_by_so[$n_so] = array();
                }
                $qty = (float) $d['qty_so'];
                $qty_str = (floor($qty) == $qty) ? (int)$qty : number_format($qty, 2);
                $items_by_so[$n_so][] = trim($d['nama_produk']) . ' (' . $qty_str . ')';
            }
        }

        // 3. Fetch Invoices from tr_invoice
        $invoices_by_so = array();
        $invoice_numbers = array();
        foreach (array_chunk($so_keys, 500) as $chunk) {
            $inv_rows = $this->db->select('no_so, no_invoice, no_surat, nilai_invoice')
                ->from('tr_invoice')
                ->where_in('no_so', $chunk)
                ->where('deleted_by IS NULL', null, false)
                ->get()
                ->result_array();

            foreach ($inv_rows as $inv) {
                $n_so = $inv['no_so'];
                if (!isset($invoices_by_so[$n_so])) {
                    $invoices_by_so[$n_so] = array(
                        'total_nilai' => 0,
                        'invoices' => array()
                    );
                }
                $invoices_by_so[$n_so]['total_nilai'] += (float) $inv['nilai_invoice'];
                $invoices_by_so[$n_so]['invoices'][] = $inv['no_invoice'];
                $invoice_numbers[] = $inv['no_invoice'];
            }
        }

        // 4. Fetch Payments from tr_invoice_payment_detail
        $payments_by_invoice = array();
        if (!empty($invoice_numbers)) {
            $invoice_numbers = array_unique($invoice_numbers);
            foreach (array_chunk($invoice_numbers, 500) as $chunk) {
                $pay_rows = $this->db->select('d.no_invoice, SUM(d.total_bayar_idr) as total_bayar', false)
                    ->from('tr_invoice_payment_detail d')
                    ->where_in('d.no_invoice', $chunk)
                    ->where('d.cancel_by IS NULL', null, false)
                    ->group_by('d.no_invoice')
                    ->get()
                    ->result_array();

                foreach ($pay_rows as $p) {
                    $payments_by_invoice[$p['no_invoice']] = (float) $p['total_bayar'];
                }
            }
        }

        // 5. Build final dataset and calculate metrics
        $rows = array();
        $total_value_so = 0;
        $total_invoice = 0;
        $total_outstanding_so = 0;
        $total_payment = 0;
        $total_outstanding_piutang = 0;

        foreach ($so_records as $so) {
            $n_so = $so['no_so'];
            $value_so = (float) $so['grand_total'];

            // Description summary
            $deskripsi = isset($items_by_so[$n_so]) ? implode(', ', $items_by_so[$n_so]) : '-';

            // Invoices and payments
            $invoice_val = 0;
            $payment_val = 0;
            if (isset($invoices_by_so[$n_so])) {
                $invoice_val = $invoices_by_so[$n_so]['total_nilai'];
                foreach ($invoices_by_so[$n_so]['invoices'] as $inv_no) {
                    if (isset($payments_by_invoice[$inv_no])) {
                        $payment_val += $payments_by_invoice[$inv_no];
                    }
                }
            }

            // Calculations
            $outstanding_so = max(0, $value_so - $invoice_val);
            $outstanding_piutang = max(0, $invoice_val - $payment_val);

            $pct_tertagih = ($value_so > 0) ? round(($invoice_val / $value_so) * 100, 2) : 0;
            $pct_terbayar = ($invoice_val > 0) ? round(($payment_val / $invoice_val) * 100, 2) : 0;

            // Business Status Rule
            if ($invoice_val <= 0) {
                $status_code = 'belum_ditagih';
                $status_label = 'Belum Ditagih';
            } elseif ($payment_val <= 0) {
                $status_code = 'belum_bayar';
                $status_label = 'Belum Bayar';
            } elseif ($payment_val < $invoice_val) {
                $status_code = 'sebagian_bayar';
                $status_label = 'Sebagian Bayar';
            } else {
                $status_code = 'lunas';
                $status_label = 'Lunas';
            }

            // Accumulate grand totals
            $total_value_so += $value_so;
            $total_invoice += $invoice_val;
            $total_outstanding_so += $outstanding_so;
            $total_payment += $payment_val;
            $total_outstanding_piutang += $outstanding_piutang;

            $rows[] = array(
                'no_so_internal' => $so['no_so'],
                'no_so' => !empty($so['no_surat']) ? $so['no_surat'] : $so['no_so'],
                'tanggal_so' => $so['tgl_so'],
                'customer' => $so['customer_name'],
                'sales' => !empty($so['nama_sales']) ? $so['nama_sales'] : '-',
                'deskripsi' => $deskripsi,
                'value_so' => $value_so,
                'invoice' => $invoice_val,
                'outstanding_so' => $outstanding_so,
                'payment' => $payment_val,
                'outstanding_piutang' => $outstanding_piutang,
                'persen_tertagih' => $pct_tertagih,
                'persen_terbayar' => $pct_terbayar,
                'status_code' => $status_code,
                'status' => $status_label
            );
        }

        $overall_tertagih = ($total_value_so > 0) ? round(($total_invoice / $total_value_so) * 100, 2) : 0;
        $overall_terbayar = ($total_invoice > 0) ? round(($total_payment / $total_invoice) * 100, 2) : 0;

        return array(
            'rows' => $rows,
            'totals' => array(
                'total_value_so' => $total_value_so,
                'total_invoice' => $total_invoice,
                'total_outstanding_so' => $total_outstanding_so,
                'total_payment' => $total_payment,
                'total_outstanding_piutang' => $total_outstanding_piutang,
                'avg_persen_tertagih' => $overall_tertagih,
                'avg_persen_terbayar' => $overall_terbayar,
                'count_so' => count($rows)
            )
        );
    }

    /**
     * Get dataset for Tab 2: Status Pengiriman
     */
    public function get_delivery_dataset($filters)
    {
        // 1. Fetch SO Item Details matching filters
        $this->db->select('d.id_so_detail, d.no_so, d.nama_produk, d.qty_so');
        $this->db->select('so.no_surat as no_surat_so, so.tgl_so, so.nama_sales, so.id_customer');
        $this->db->select("COALESCE(c.name_customer, so.id_customer, '') AS customer_name", false);
        $this->db->from('tr_sales_order_detail d');
        $this->db->join('tr_sales_order so', 'so.no_so = d.no_so', 'inner');
        $this->db->join('master_customers c', 'c.id_customer = so.id_customer', 'left');
        $this->db->where('so.deleted_by IS NULL', null, false);

        if (!empty($filters['start_date'])) {
            $this->db->where('so.tgl_so >=', $filters['start_date']);
        }
        if (!empty($filters['end_date'])) {
            $this->db->where('so.tgl_so <=', $filters['end_date']);
        }
        if (!empty($filters['customer_id'])) {
            $this->db->where('so.id_customer', $filters['customer_id']);
        }
        if (!empty($filters['sales_name'])) {
            $this->db->where('so.nama_sales', $filters['sales_name']);
        }

        $this->db->order_by('so.tgl_so', 'DESC');
        $this->db->order_by('so.no_so', 'DESC');
        $this->db->order_by('d.id_so_detail', 'ASC');
        $items = $this->db->get()->result_array();

        if (empty($items)) {
            return array(
                'rows' => array(),
                'totals' => array(
                    'total_qty_so' => 0,
                    'total_qty_kirim' => 0,
                    'total_outstanding' => 0,
                    'count_rows' => 0
                )
            );
        }

        $id_so_details = array();
        foreach ($items as $item) {
            $id_so_details[] = $item['id_so_detail'];
        }

        // 2. Fetch DO Details linked to these SO detail items
        $deliveries_by_item = array();
        foreach (array_chunk($id_so_details, 500) as $chunk) {
            $do_rows = $this->db->select('dod.id_so_detail, dod.no_do, dod.qty_do, do.no_surat as no_surat_do, do.tgl_do')
                ->from('tr_delivery_order_detail dod')
                ->join('tr_delivery_order do', 'do.no_do = dod.no_do', 'left')
                ->where_in('dod.id_so_detail', $chunk)
                ->order_by('do.tgl_do', 'ASC')
                ->order_by('dod.id_so_detail', 'ASC')
                ->get()
                ->result_array();

            foreach ($do_rows as $do) {
                $id_dtl = $do['id_so_detail'];
                if (!isset($deliveries_by_item[$id_dtl])) {
                    $deliveries_by_item[$id_dtl] = array();
                }
                $deliveries_by_item[$id_dtl][] = $do;
            }
        }

        // 3. Build rows with progressive cumulative running balance
        $rows = array();
        $total_qty_so = 0;
        $total_qty_kirim = 0;
        $total_outstanding = 0;

        foreach ($items as $item) {
            $id_dtl = $item['id_so_detail'];
            $qty_so = (float) $item['qty_so'];
            $no_so_display = !empty($item['no_surat_so']) ? $item['no_surat_so'] : $item['no_so'];
            $sales = !empty($item['nama_sales']) ? $item['nama_sales'] : '-';

            $deliveries = isset($deliveries_by_item[$id_dtl]) ? $deliveries_by_item[$id_dtl] : array();

            if (empty($deliveries)) {
                // Item has not been shipped at all
                $total_qty_so += $qty_so;
                $total_outstanding += $qty_so;

                $rows[] = array(
                    'no_so' => $no_so_display,
                    'barang' => $item['nama_produk'],
                    'qty' => $qty_so,
                    'tanggal_so' => $item['tgl_so'],
                    'qty_kirim' => 0,
                    'outstanding' => $qty_so,
                    'persen_terkirim' => 0,
                    'status_kirim' => 'Belum Terkirim',
                    'status_code' => 'belum_terkirim',
                    'tanggal_do' => '-',
                    'no_do' => '-',
                    'nama_customer' => $item['customer_name'],
                    'account_handler' => $sales
                );
            } else {
                // Progressive running balance across DO shipments
                $cumulative_shipped = 0;
                $is_first_line = true;

                foreach ($deliveries as $do) {
                    $qty_do = (float) $do['qty_do'];
                    $cumulative_shipped += $qty_do;
                    $outstanding = max(0, $qty_so - $cumulative_shipped);
                    $pct_terkirim = ($qty_so > 0) ? min(100, round(($cumulative_shipped / $qty_so) * 100, 2)) : 0;

                    if ($cumulative_shipped >= $qty_so) {
                        $status_kirim = 'Terkirim';
                        $status_code = 'terkirim';
                    } elseif ($cumulative_shipped > 0) {
                        $status_kirim = 'Sebagian Kirim';
                        $status_code = 'sebagian_kirim';
                    } else {
                        $status_kirim = 'Belum Terkirim';
                        $status_code = 'belum_terkirim';
                    }

                    $do_num = !empty($do['no_surat_do']) ? $do['no_surat_do'] : (!empty($do['no_do']) ? $do['no_do'] : '-');
                    $do_date = !empty($do['tgl_do']) ? $do['tgl_do'] : '-';

                    // For the grand totals: only count Qty SO once per item
                    if ($is_first_line) {
                        $total_qty_so += $qty_so;
                        $is_first_line = false;
                    }
                    $total_qty_kirim += $qty_do;

                    $rows[] = array(
                        'no_so' => $no_so_display,
                        'barang' => $item['nama_produk'],
                        'qty' => $qty_so,
                        'tanggal_so' => $item['tgl_so'],
                        'qty_kirim' => $qty_do,
                        'outstanding' => $outstanding,
                        'persen_terkirim' => $pct_terkirim,
                        'status_kirim' => $status_kirim,
                        'status_code' => $status_code,
                        'tanggal_do' => $do_date,
                        'no_do' => $do_num,
                        'nama_customer' => $item['customer_name'],
                        'account_handler' => $sales
                    );
                }

                // Remaining final outstanding for this item in grand total
                $final_outstanding = max(0, $qty_so - $cumulative_shipped);
                $total_outstanding += $final_outstanding;
            }
        }

        return array(
            'rows' => $rows,
            'totals' => array(
                'total_qty_so' => $total_qty_so,
                'total_qty_kirim' => $total_qty_kirim,
                'total_outstanding' => $total_outstanding,
                'count_rows' => count($rows)
            )
        );
    }
}
