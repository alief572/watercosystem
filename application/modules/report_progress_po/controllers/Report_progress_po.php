<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report_progress_po extends Admin_Controller
{
    protected $viewPermission = 'Report_Progress_Po.View';

    public function __construct()
    {
        parent::__construct();
        $this->auth->restrict($this->viewPermission, site_url());
        $this->load->model('report_progress_po/Report_progress_po_model', 'report_model');
        $this->template->title('Report Progress PO');
        $this->template->page_icon('fa fa-line-chart');
    }

    private function filters()
    {
        $input = array();
        foreach (array('start_date', 'end_date', 'supplier_id', 'type', 'currency', 'status', 'search') as $key) {
            $value = $this->input->get($key);
            if ($value !== null) { $input[$key] = $value; }
        }
        return Progress_po_rules::filters($input);
    }

    private function json($data, $status = 200)
    {
        return $this->output->set_status_header($status)->set_content_type('application/json', 'utf-8')
            ->set_header('Cache-Control: no-store')->set_output(json_encode($data));
    }

    private function failure($error)
    {
        if ($error instanceof InvalidArgumentException) { return $this->json(array('error' => $error->getMessage()), 422); }
        log_message('error', 'Report Progress PO: ' . $error->getMessage());
        return $this->json(array('error' => 'Laporan belum dapat dimuat. Silakan coba kembali.'), 500);
    }

    public function index()
    {
        $this->template->render('index', array('filters' => Progress_po_rules::filters(array()),
            'suppliers' => $this->report_model->get_suppliers()));
    }

    public function data_po()
    {
        try {
            $filters = $this->filters();
            $start = $this->input->get('start'); $length = $this->input->get('length');
            $draw = $this->input->get('draw');
            foreach (array($start, $length, $draw) as $value) {
                if ($value !== null && (!is_scalar($value) || !preg_match('/^\d+$/', (string) $value))) {
                    throw new InvalidArgumentException('Parameter halaman tidak valid.');
                }
            }
            $start = max(0, (int) $start); $length = min(100, max(1, $length === null ? 25 : (int) $length));
            $sort = $this->input->get('sort') ?: 'date'; $direction = $this->input->get('direction') ?: 'desc';
            if (!in_array($sort, array('date', 'number', 'supplier', 'native', 'total_idr', 'received_idr', 'remaining_idr', 'progress'), true)
                || !in_array($direction, array('asc', 'desc'), true)) { throw new InvalidArgumentException('Pengurutan tidak valid.'); }
            $data = $this->report_model->get_dataset($filters);
            usort($data['rows'], function ($a, $b) use ($sort, $direction) {
                $result = ($a[$sort] == $b[$sort] ? 0 : ($a[$sort] < $b[$sort] ? -1 : 1)) ?: strcmp($a['id'], $b['id']);
                return $direction === 'asc' ? $result : -$result;
            });
            $rows = array_slice($data['rows'], $start, $length);
            foreach ($rows as &$row) { unset($row['items']); }
            unset($row);
            return $this->json(array('draw' => (int) $draw, 'recordsTotal' => $data['records_total'],
                'recordsFiltered' => count($data['rows']), 'data' => $rows,
                'totals' => $data['totals'], 'monthly' => $data['monthly'], 'suppliers' => $data['suppliers'], 'generated_at' => $data['generated_at']));
        } catch (Exception $error) { return $this->failure($error); }
    }

    public function summary()
    {
        try {
            $data = $this->report_model->get_dataset($this->filters());
            unset($data['rows']);
            return $this->json($data);
        } catch (Exception $error) { return $this->failure($error); }
    }

    public function detail()
    {
        try {
            $id = $this->input->get('id');
            if (!is_string($id) || $id === '' || strlen($id) > 255) { throw new InvalidArgumentException('ID PO tidak valid.'); }
            $data = $this->report_model->get_dataset($this->filters(), $id);
            if (!$data['rows']) { return $this->json(array('error' => 'PO tidak ditemukan pada filter ini.'), 404); }
            return $this->json($data['rows'][0]);
        } catch (Exception $error) { return $this->failure($error); }
    }

    public function export_excel()
    {
        $path = null; $book = null;
        try {
            $filters = $this->filters();
            $data = $this->report_model->get_dataset($filters);
            $this->load->library('report_progress_po/Progress_po_workbook', null, 'workbook');
            $book = $this->workbook->build($data, $filters);
            $filename = 'Report_Progress_PO_' . $filters['start_date'] . '_sd_' . $filters['end_date'] . '.xlsx';
            // Finish serialization before setting download headers so failures remain valid JSON.
            $path = tempnam(sys_get_temp_dir(), 'progress-po-');
            if ($path === false) { throw new RuntimeException('Cannot create export file.'); }
            PHPExcel_IOFactory::createWriter($book, 'Excel2007')->save($path);
            $body = file_get_contents($path);
            if ($body === false) { throw new RuntimeException('Cannot read export file.'); }
            $this->output->enable_profiler(false);
            return $this->output->set_content_type('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
                ->set_header('Cache-Control: no-store')->set_header('Content-Disposition: attachment; filename="' . $filename . '"')->set_output($body);
        } catch (Exception $error) { return $this->failure($error); }
        finally {
            if (is_string($path) && is_file($path)) { unlink($path); }
            if ($book !== null) { $book->disconnectWorksheets(); }
        }
    }
}
