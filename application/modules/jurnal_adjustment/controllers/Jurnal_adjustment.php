<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Jurnal_adjustment extends Admin_Controller
{
    protected $viewPermission = 'Jurnal_Adjustment.View';
    protected $managePermission = 'Jurnal_Adjustment.Manage';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Jurnal_adjustment/Jurnal_adjustment_model');
        $this->template->title('Jurnal Adjustment');
        $this->template->page_icon('fa fa-building-o');
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index()
    {
        $this->auth->restrict($this->viewPermission);
        $this->template->render('index');
    }

    private function authorize($manage = false)
    {
        if (!has_permission($this->viewPermission) || ($manage && !has_permission($this->managePermission))) {
            throw new DomainException('Anda tidak memiliki izin untuk mengakses jurnal adjustment.', 403);
        }
    }

    private function require_method($method)
    {
        if ($this->input->method(true) !== $method) {
            $this->output->set_header('Allow: '.$method);
            throw new DomainException('Metode request tidak diizinkan.', 405);
        }
    }

    private function json($response, $status = 200)
    {
        http_response_code($status);
        $this->output->set_content_type('application/json');
        $this->output->set_header('Cache-Control: no-store');
        echo json_encode($response, JSON_INVALID_UTF8_SUBSTITUTE);
    }

    private function failure(Throwable $error)
    {
        $status = $error instanceof DomainException && in_array($error->getCode(), array(403,404,405,409,422,503), true) ? $error->getCode() : 500;
        if ($status === 500) { log_message('error', 'Jurnal adjustment: '.$error->getMessage()); }
        $this->json(array('code'=>$status, 'msg'=>$status === 500 ? 'Posting belum terkonfirmasi. Periksa status adjustment sebelum mencoba kembali; hubungi administrator jika masalah berlanjut.' : $error->getMessage()), $status);
    }

    public function get_dataa_adjustment()
    {
        $debug = $this->db->db_debug;
        $this->db->db_debug = false;
        try {
            $this->authorize();
            $this->require_method('GET');
            $search = $this->input->get('search');
            $data = $this->Jurnal_adjustment_model->get_data_adjustment(array('start'=>$this->input->get('start'), 'length'=>$this->input->get('length'), 'search'=>is_array($search) ? ($search['value'] ?? '') : ''));
            $rows = array();
            $no = max(0, (int)$this->input->get('start'));
            foreach ($data['data'] as $item) {
                $rows[] = array('no'=>++$no, 'no_transaksi'=>html_escape($item->id_transaksi ?? ''),
                    'tanggal'=>html_escape($item->tanggal_transaksi ?? ''), 'material'=>html_escape($item->nama_material ?? ''),
                    'tipe_adjust'=>html_escape($item->adjustment ?? ''), 'gudang'=>html_escape($item->nama_gudang ?? ''),
                    'keterangan'=>html_escape($item->note ?? ''), 'jumlah_stock'=>number_format((float)$item->total_qty),
                    'action'=>has_permission($this->managePermission) ? '<button type="button" class="btn btn-sm btn-primary process_jurnal" data-id_transaksi="'.html_escape($item->id_transaksi ?? '').'" title="Process Jurnal Adjustment"><i class="fa fa-check"></i></button>' : '');
            }
            $this->json(array('draw'=>max(0, (int)$this->input->get('draw')), 'recordsTotal'=>$data['count_all'], 'recordsFiltered'=>$data['count_filter'], 'data'=>$rows));
        } catch (Throwable $error) { $this->failure($error); }
        finally { $this->db->db_debug = $debug; }
    }

    public function process_jurnal()
    {
        $debug = $this->db->db_debug;
        $this->db->db_debug = false;
        try {
            $this->authorize(true);
            $this->require_method('GET');
            $this->output->set_header('Cache-Control: no-store');
            $this->session->set_userdata('jurnal_adjustment_preview', null);
            $data = $this->Jurnal_adjustment_model->prepare_journal($this->input->get('id_transaksi'));
            $token = bin2hex(random_bytes(32));
            $this->session->set_userdata('jurnal_adjustment_preview', array('token'=>$token, 'snapshot'=>$data['snapshot']));
            $data['preview_token'] = $token;
            $this->load->view('process_jurnal', $data);
        } catch (Throwable $error) { $this->failure($error); }
        finally { $this->db->db_debug = $debug; }
    }

    public function save_post_jurnal_adjustment()
    {
        try {
            $this->authorize(true);
            $this->require_method('POST');
            $id = $this->input->post('id_transaksi');
            $token = $this->input->post('preview_token');
            $preview = $this->session->userdata('jurnal_adjustment_preview');
            if (!is_string($token) || !is_array($preview) || !isset($preview['token'], $preview['snapshot']['id']) || !hash_equals($preview['token'], $token) || $preview['snapshot']['id'] !== $id) {
                throw new DomainException('Token preview tidak valid. Buka preview adjustment kembali.', 403);
            }
            $number = $this->Jurnal_adjustment_model->post_journal($id, $preview['snapshot'], $this->auth->user_id());
            $this->session->set_userdata('jurnal_adjustment_preview', null);
            $this->json(array('code'=>200, 'msg'=>'Jurnal adjustment berhasil diposting ke TRAS.', 'nomor'=>$number));
        } catch (Throwable $error) { $this->failure($error); }
    }
}
