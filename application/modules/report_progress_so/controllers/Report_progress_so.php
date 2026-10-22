<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report_progress_so extends Admin_Controller
{
    protected $viewPermission = 'Report_Progress_So.View';

    public function __construct()
    {
        parent::__construct();
        $this->auth->restrict($this->viewPermission, site_url());
        $this->load->model('report_progress_so/Report_progress_so_model', 'report_model');
        $this->load->library('report_progress_so/Progress_so_workbook', null, 'workbook');
        $this->template->title('Report Progress SO');
        $this->template->page_icon('fa fa-line-chart');
    }

    /**
     * Parse and sanitize request filter parameters
     */
    private function get_filters()
    {
        $start_date  = $this->input->get_post('start_date');
        $end_date    = $this->input->get_post('end_date');
        $customer_id = $this->input->get_post('customer_id');
        $sales_name  = $this->input->get_post('sales_name');

        // Default to current month if dates are not provided or invalid
        if (empty($start_date) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $start_date)) {
            $start_date = date('Y-m-01');
        }
        if (empty($end_date) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $end_date)) {
            $end_date = date('Y-m-d');
        }

        return array(
            'start_date'  => trim($start_date),
            'end_date'    => trim($end_date),
            'customer_id' => !empty($customer_id) ? trim($customer_id) : '',
            'sales_name'  => !empty($sales_name) ? trim($sales_name) : ''
        );
    }

    /**
     * Main view with 2 Tabs and Shared Filters
     */
    public function index()
    {
        $filters = $this->get_filters();
        $customers = $this->report_model->get_customers();
        $sales = $this->report_model->get_sales();

        $data = array(
            'filters'   => $filters,
            'customers' => $customers,
            'sales'     => $sales
        );

        $this->template->render('index', $data);
    }

    /**
     * AJAX endpoint for Tab 1: Progress Nilai SO (DataTables)
     */
    public function data_so()
    {
        $filters = $this->get_filters();
        $dataset = $this->report_model->get_progress_so_dataset($filters);

        // Global search filtering inside DataTables
        $search_input = $this->input->post('search');
        $search_value = isset($search_input['value']) ? trim($search_input['value']) : '';

        $filtered_rows = array();
        if ($search_value !== '') {
            foreach ($dataset['rows'] as $r) {
                if (
                    stripos($r['no_so'], $search_value) !== false ||
                    stripos($r['customer'], $search_value) !== false ||
                    stripos($r['sales'], $search_value) !== false ||
                    stripos($r['deskripsi'], $search_value) !== false ||
                    stripos($r['status'], $search_value) !== false ||
                    stripos($r['tanggal_so'], $search_value) !== false ||
                    stripos((string)$r['value_so'], $search_value) !== false ||
                    stripos((string)$r['invoice'], $search_value) !== false ||
                    stripos((string)$r['outstanding_so'], $search_value) !== false ||
                    stripos((string)$r['payment'], $search_value) !== false ||
                    stripos((string)$r['outstanding_piutang'], $search_value) !== false
                ) {
                    $filtered_rows[] = $r;
                }
            }
        } else {
            $filtered_rows = $dataset['rows'];
        }

        // Sorting
        $order_input = $this->input->post('order');
        if (!empty($order_input) && is_array($order_input)) {
            $col_idx = isset($order_input[0]['column']) ? (int)$order_input[0]['column'] : 0;
            $col_dir = isset($order_input[0]['dir']) && strtolower($order_input[0]['dir']) === 'desc' ? 'desc' : 'asc';

            $col_map1 = array(
                1 => 'no_so', 2 => 'tanggal_so', 3 => 'customer', 4 => 'sales', 5 => 'deskripsi',
                6 => 'value_so', 7 => 'invoice', 8 => 'outstanding_so', 9 => 'payment', 10 => 'outstanding_piutang',
                11 => 'persen_tertagih', 12 => 'persen_terbayar', 13 => 'status'
            );

            if (isset($col_map1[$col_idx])) {
                $sort_field = $col_map1[$col_idx];
                usort($filtered_rows, function ($a, $b) use ($sort_field, $col_dir) {
                    $valA = $a[$sort_field];
                    $valB = $b[$sort_field];
                    if (is_numeric($valA) && is_numeric($valB)) {
                        $cmp = ($valA == $valB) ? 0 : (($valA < $valB) ? -1 : 1);
                    } else {
                        $cmp = strcasecmp((string)$valA, (string)$valB);
                    }
                    return ($col_dir === 'desc') ? -$cmp : $cmp;
                });
            }
        }

        // Totals of filtered records
        $filtered_total_value_so = 0;
        $filtered_total_invoice = 0;
        $filtered_total_outstanding_so = 0;
        $filtered_total_payment = 0;
        $filtered_total_outstanding_piutang = 0;

        foreach ($filtered_rows as $fr) {
            $filtered_total_value_so += $fr['value_so'];
            $filtered_total_invoice += $fr['invoice'];
            $filtered_total_outstanding_so += $fr['outstanding_so'];
            $filtered_total_payment += $fr['payment'];
            $filtered_total_outstanding_piutang += $fr['outstanding_piutang'];
        }

        $filtered_tertagih = ($filtered_total_value_so > 0) ? round(($filtered_total_invoice / $filtered_total_value_so) * 100, 2) : 0;
        $filtered_terbayar = ($filtered_total_invoice > 0) ? round(($filtered_total_payment / $filtered_total_invoice) * 100, 2) : 0;

        // Pagination
        $start = (int) $this->input->post('start');
        $length = (int) $this->input->post('length');
        if ($length <= 0) {
            $length = 25;
        }

        $records_total = count($dataset['rows']);
        $records_filtered = count($filtered_rows);
        $paged_rows = array_slice($filtered_rows, $start, $length);

        $data = array();
        $no = $start + 1;
        foreach ($paged_rows as $r) {
            $status_badge = '';
            switch ($r['status_code']) {
                case 'belum_ditagih':
                    $status_badge = '<span class="badge bg-gray">' . html_escape($r['status']) . '</span>';
                    break;
                case 'belum_bayar':
                    $status_badge = '<span class="badge bg-red">' . html_escape($r['status']) . '</span>';
                    break;
                case 'sebagian_bayar':
                    $status_badge = '<span class="badge bg-yellow">' . html_escape($r['status']) . '</span>';
                    break;
                case 'lunas':
                    $status_badge = '<span class="badge bg-green">' . html_escape($r['status']) . '</span>';
                    break;
                default:
                    $status_badge = '<span class="badge bg-gray">' . html_escape($r['status']) . '</span>';
            }

            $data[] = array(
                'no' => $no++,
                'no_so' => '<strong>' . html_escape($r['no_so']) . '</strong>',
                'tanggal_so' => !empty($r['tanggal_so']) ? date('d/m/Y', strtotime($r['tanggal_so'])) : '-',
                'customer' => html_escape($r['customer']),
                'sales' => html_escape($r['sales']),
                'deskripsi' => '<div class="text-truncate-cell" title="' . html_escape($r['deskripsi']) . '">' . html_escape($r['deskripsi']) . '</div>',
                'value_so' => number_format($r['value_so'], 0, ',', '.'),
                'invoice' => number_format($r['invoice'], 0, ',', '.'),
                'outstanding_so' => number_format($r['outstanding_so'], 0, ',', '.'),
                'payment' => number_format($r['payment'], 0, ',', '.'),
                'outstanding_piutang' => number_format($r['outstanding_piutang'], 0, ',', '.'),
                'persen_tertagih' => number_format($r['persen_tertagih'], 1, ',', '.') . '%',
                'persen_terbayar' => number_format($r['persen_terbayar'], 1, ',', '.') . '%',
                'status' => $status_badge
            );
        }

        $response = array(
            'draw' => (int) $this->input->post('draw'),
            'recordsTotal' => $records_total,
            'recordsFiltered' => $records_filtered,
            'data' => $data,
            'totals' => array(
                'total_value_so' => number_format($filtered_total_value_so, 0, ',', '.'),
                'total_invoice' => number_format($filtered_total_invoice, 0, ',', '.'),
                'total_outstanding_so' => number_format($filtered_total_outstanding_so, 0, ',', '.'),
                'total_payment' => number_format($filtered_total_payment, 0, ',', '.'),
                'total_outstanding_piutang' => number_format($filtered_total_outstanding_piutang, 0, ',', '.'),
                'avg_persen_tertagih' => number_format($filtered_tertagih, 1, ',', '.') . '%',
                'avg_persen_terbayar' => number_format($filtered_terbayar, 1, ',', '.') . '%',
                'count_so' => $records_filtered
            )
        );

        $this->output->set_content_type('application/json', 'utf-8')
            ->set_header('Cache-Control: no-store')
            ->set_output(json_encode($response));
    }

    /**
     * AJAX endpoint for Tab 2: Status Pengiriman (DataTables)
     */
    public function data_delivery()
    {
        $filters = $this->get_filters();
        $dataset = $this->report_model->get_delivery_dataset($filters);

        // Global search filtering inside DataTables
        $search_input = $this->input->post('search');
        $search_value = isset($search_input['value']) ? trim($search_input['value']) : '';

        $filtered_rows = array();
        if ($search_value !== '') {
            foreach ($dataset['rows'] as $dr) {
                if (
                    stripos($dr['no_so'], $search_value) !== false ||
                    stripos($dr['barang'], $search_value) !== false ||
                    stripos($dr['status_kirim'], $search_value) !== false ||
                    stripos($dr['no_do'], $search_value) !== false ||
                    stripos($dr['tanggal_do'], $search_value) !== false ||
                    stripos($dr['tanggal_so'], $search_value) !== false ||
                    stripos($dr['nama_customer'], $search_value) !== false ||
                    stripos($dr['account_handler'], $search_value) !== false ||
                    stripos((string)$dr['qty'], $search_value) !== false ||
                    stripos((string)$dr['qty_kirim'], $search_value) !== false ||
                    stripos((string)$dr['outstanding'], $search_value) !== false
                ) {
                    $filtered_rows[] = $dr;
                }
            }
        } else {
            $filtered_rows = $dataset['rows'];
        }

        // Sorting
        $order_input = $this->input->post('order');
        if (!empty($order_input) && is_array($order_input)) {
            $col_idx = isset($order_input[0]['column']) ? (int)$order_input[0]['column'] : 0;
            $col_dir = isset($order_input[0]['dir']) && strtolower($order_input[0]['dir']) === 'desc' ? 'desc' : 'asc';

            $col_map2 = array(
                1 => 'no_so', 2 => 'barang', 3 => 'qty', 4 => 'tanggal_so', 5 => 'qty_kirim',
                6 => 'outstanding', 7 => 'persen_terkirim', 8 => 'status_kirim', 9 => 'tanggal_do',
                10 => 'no_do', 11 => 'nama_customer', 12 => 'account_handler'
            );

            if (isset($col_map2[$col_idx])) {
                $sort_field = $col_map2[$col_idx];
                usort($filtered_rows, function ($a, $b) use ($sort_field, $col_dir) {
                    $valA = $a[$sort_field];
                    $valB = $b[$sort_field];
                    if (is_numeric($valA) && is_numeric($valB)) {
                        $cmp = ($valA == $valB) ? 0 : (($valA < $valB) ? -1 : 1);
                    } else {
                        $cmp = strcasecmp((string)$valA, (string)$valB);
                    }
                    return ($col_dir === 'desc') ? -$cmp : $cmp;
                });
            }
        }

        // Totals of filtered delivery rows
        $filtered_qty_so = 0;
        $filtered_qty_kirim = 0;
        $filtered_outstanding = 0;

        foreach ($filtered_rows as $fdr) {
            $filtered_qty_so += (float) $fdr['qty'];
            $filtered_qty_kirim += (float) $fdr['qty_kirim'];
            $filtered_outstanding += (float) $fdr['outstanding'];
        }

        // Pagination
        $start = (int) $this->input->post('start');
        $length = (int) $this->input->post('length');
        if ($length <= 0) {
            $length = 25;
        }

        $records_total = count($dataset['rows']);
        $records_filtered = count($filtered_rows);
        $paged_rows = array_slice($filtered_rows, $start, $length);

        $data = array();
        $no = $start + 1;
        foreach ($paged_rows as $dr) {
            $status_badge = '';
            switch ($dr['status_code']) {
                case 'belum_terkirim':
                    $status_badge = '<span class="badge bg-red">' . html_escape($dr['status_kirim']) . '</span>';
                    break;
                case 'sebagian_kirim':
                    $status_badge = '<span class="badge bg-yellow">' . html_escape($dr['status_kirim']) . '</span>';
                    break;
                case 'terkirim':
                    $status_badge = '<span class="badge bg-green">' . html_escape($dr['status_kirim']) . '</span>';
                    break;
                default:
                    $status_badge = '<span class="badge bg-gray">' . html_escape($dr['status_kirim']) . '</span>';
            }

            $tgl_do_str = ($dr['tanggal_do'] !== '-' && !empty($dr['tanggal_do'])) ? date('d/m/Y', strtotime($dr['tanggal_do'])) : '-';

            $data[] = array(
                'no' => $no++,
                'no_so' => '<strong>' . html_escape($dr['no_so']) . '</strong>',
                'barang' => html_escape($dr['barang']),
                'qty' => number_format($dr['qty'], 0, ',', '.'),
                'tanggal_so' => !empty($dr['tanggal_so']) ? date('d/m/Y', strtotime($dr['tanggal_so'])) : '-',
                'qty_kirim' => number_format($dr['qty_kirim'], 0, ',', '.'),
                'outstanding' => number_format($dr['outstanding'], 0, ',', '.'),
                'persen_terkirim' => number_format($dr['persen_terkirim'], 1, ',', '.') . '%',
                'status_kirim' => $status_badge,
                'tanggal_do' => $tgl_do_str,
                'no_do' => html_escape($dr['no_do']),
                'nama_customer' => html_escape($dr['nama_customer']),
                'account_handler' => html_escape($dr['account_handler'])
            );
        }

        $response = array(
            'draw' => (int) $this->input->post('draw'),
            'recordsTotal' => $records_total,
            'recordsFiltered' => $records_filtered,
            'data' => $data,
            'totals' => array(
                'total_qty_so' => number_format($filtered_qty_so, 0, ',', '.'),
                'total_qty_kirim' => number_format($filtered_qty_kirim, 0, ',', '.'),
                'total_outstanding' => number_format($filtered_outstanding, 0, ',', '.'),
                'count_rows' => $records_filtered
            )
        );

        $this->output->set_content_type('application/json', 'utf-8')
            ->set_header('Cache-Control: no-store')
            ->set_output(json_encode($response));
    }

    /**
     * Export Excel containing both sheets
     */
    public function export_excel()
    {
        $filters = $this->get_filters();

        // Customer name lookup if filtered
        $filters['customer_name'] = '';
        if (!empty($filters['customer_id'])) {
            $cust = $this->db->select('name_customer')->where('id_customer', $filters['customer_id'])->get('master_customers')->row_array();
            if (!empty($cust['name_customer'])) {
                $filters['customer_name'] = $cust['name_customer'];
            }
        }

        // Fetch datasets for both tabs
        $so_dataset = $this->report_model->get_progress_so_dataset($filters);
        $deliv_dataset = $this->report_model->get_delivery_dataset($filters);

        // Generate multi-sheet workbook
        $book = $this->workbook->build($so_dataset, $deliv_dataset, $filters);

        $filename = 'Report_Progress_SO_' . str_replace('-', '', $filters['start_date']) . '_sd_' . str_replace('-', '', $filters['end_date']) . '.xlsx';

        // Output to browser
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Pragma: public');

        $writer = PHPExcel_IOFactory::createWriter($book, 'Excel2007');
        $writer->save('php://output');
        exit;
    }
}
