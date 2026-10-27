<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_piutang_invoice extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->auth->restrict('Report_Piutang_Invoice.View', site_url());
        if ($this->input->method(true) !== 'GET') {
            show_error('Gunakan GET untuk membuka report.', 405);
        }
        $this->load->model('report_piutang_invoice/Report_piutang_invoice_model', 'report_model');
        $this->load->library('report_piutang_invoice/Piutang_invoice_dataset');
    }

    private function filters()
    {
        $today = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $filters = array('tanggal' => $today->format('Y-m-d'), 'customer_id' => '', 'no_invoice' => '');
        foreach ($filters as $key => $default) {
            $value = $this->input->get($key);
            if ($value !== null) {
                if (!is_string($value)) {
                    show_error('Parameter filter tidak valid.', 400);
                }
                $filters[$key] = trim($value);
            }
        }
        if (!Piutang_invoice_dataset::valid_date($filters['tanggal'])) {
            show_error('Tanggal wajib diisi dengan tanggal yang valid (YYYY-MM-DD).', 400);
        }
        if (strlen($filters['customer_id']) > 20 || strlen($filters['no_invoice']) > 255) {
            show_error('Filter terlalu panjang.', 400);
        }
        if ($filters['customer_id'] !== '' && !$this->report_model->customer_exists($filters['customer_id'])) {
            show_error('Customer tidak ditemukan.', 400);
        }
        return $filters;
    }

    public function index()
    {
        $filters = $this->filters();
        $data = array(
            'filters' => $filters, 'customers' => $this->report_model->customers(),
            'default_date' => (new DateTime('now', new DateTimeZone('Asia/Jakarta')))->format('Y-m-d')
        );
        $this->template->title('Report Piutang per Invoice');
        $this->template->page_icon('fa fa-file-text-o');
        $this->template->render('index', $data);
    }

    private function integer_parameter($key, $default, $max)
    {
        $value = $this->input->get($key);
        if ($value === null) {
            return $default;
        }
        if (!is_string($value) || !preg_match('/^[0-9]{1,10}$/D', $value) || (float) $value > $max) {
            show_error('Parameter tabel tidak valid.', 400);
        }
        return (int) $value;
    }

    private function json_response($data)
    {
        $this->output->set_content_type('application/json', 'utf-8')
            ->set_header('Cache-Control: no-store')->set_output(json_encode($data));
    }

    public function invoice_options()
    {
        $filters = $this->filters();
        $filters['no_invoice'] = '';
        $report = $this->report_model->dataset($filters);
        $options = array();
        $seen = array();
        foreach ($report['invoices'] as $invoice) {
            $number = trim($invoice['no_surat']);
            if ($number !== '' && !isset($seen[$number])) {
                $seen[$number] = true;
                $options[] = array('id' => $invoice['no_surat'], 'text' => $invoice['no_surat']);
            }
        }
        $this->json_response(array('options' => $options));
    }

    public function data()
    {
        $filters = $this->filters();
        $draw = $this->integer_parameter('draw', 0, 2147483647);
        $start = $this->integer_parameter('start', 0, 2147483647);
        $length = $this->integer_parameter('length', 25, 100);
        if (!in_array($length, array(10, 25, 50, 100), true)) {
            show_error('Ukuran halaman tidak valid.', 400);
        }
        $report = $this->report_model->dataset($filters);
        $columns = array(0 => 'customer', 1 => 'tgl_invoice', 2 => 'no_surat', 3 => 'nilai_invoice', 7 => 'total_bayar', 8 => 'sisa_piutang');
        $order = $this->input->get('order');
        if ($order !== null && !is_array($order)) {
            show_error('Urutan tabel tidak valid.', 400);
        }
        $rules = array();
        foreach (array_slice($order === null ? array() : $order, 0, 6) as $rule) {
            if (!is_array($rule) || !isset($rule['column'], $rule['dir']) || !is_string($rule['column'])
                || !ctype_digit($rule['column']) || !isset($columns[(int) $rule['column']])
                || !in_array($rule['dir'], array('asc', 'desc'), true)) {
                show_error('Urutan tabel tidak valid.', 400);
            }
            $rules[] = array('field' => $columns[(int) $rule['column']], 'direction' => $rule['dir']);
        }
        if ($rules) {
            $calculator = $this->piutang_invoice_dataset;
            usort($report['invoices'], function ($a, $b) use ($rules, $calculator) {
                foreach ($rules as $rule) {
                    $field = $rule['field'];
                    $comparison = is_numeric($a[$field]) && in_array($field, array('nilai_invoice', 'total_bayar', 'sisa_piutang'), true)
                        ? ($a[$field] == $b[$field] ? 0 : ($a[$field] < $b[$field] ? -1 : 1))
                        : strcasecmp($a[$field], $b[$field]);
                    if ($comparison !== 0) {
                        return $rule['direction'] === 'desc' ? -$comparison : $comparison;
                    }
                }
                return $calculator->compare_invoices($a, $b);
            });
        }
        $this->json_response(array(
            'draw' => $draw, 'recordsTotal' => $report['invoice_count'], 'recordsFiltered' => $report['invoice_count'],
            'data' => array_slice($report['invoices'], $start, $length),
            'total_piutang' => $report['total_piutang'], 'invoice_count' => $report['invoice_count'],
            'verification' => $report['verification'], 'verification_invoice_count' => $report['verification_invoice_count'],
            'tanggal' => $filters['tanggal']
        ));
    }

    public function export_excel()
    {
        $filters = $this->filters();
        $report = $this->report_model->dataset($filters);
        $this->load->library('PHPExcel');
        $this->load->library('report_piutang_invoice/Piutang_invoice_workbook');
        $book = $this->piutang_invoice_workbook->build($report, $filters);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Report_Piutang_per_Invoice_' . $filters['tanggal'] . '.xlsx"');
        header('Cache-Control: no-store');
        PHPExcel_IOFactory::createWriter($book, 'Excel2007')->save('php://output');
        $book->disconnectWorksheets();
    }
}
