<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Request_payment extends Admin_Controller
{
    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model(['Request_payment/Request_payment_model','All/All_model']);
        $this->template->page_icon('fa fa-table');
    }

    public function index() { $this->page('request'); }
    public function list_approve() { $this->page('approval'); }
    public function list_payment() { $this->page('payment'); }
    public function payment_jurnal_list() { $this->page('jurnal'); }
    public function data_request() { $this->table('request'); }
    public function data_approval() { $this->table('approval'); }
    public function data_payment() { $this->table('payment'); }
    public function data_jurnal() { $this->table('jurnal'); }

    private function permission($kind) { return $kind === 'approval' ? 'Request_Payment_Approval' : 'Request_Payment'; }
    private function json($data) { $this->output->set_content_type('application/json'); echo json_encode($data); }
    private function post() {
        if ($this->input->method() !== 'post') throw new DomainException('Gunakan metode POST.');
        $data = $this->input->post();
        if (!is_array($data)) throw new DomainException('Data tidak valid.');
        return $data;
    }
    private function sameVersion($posted, $actual) {
        $posted = $this->Request_payment_model->text($posted,'Versi form',64);
        if (!hash_equals($actual,$posted)) throw new DomainException('Data berubah. Muat ulang halaman.');
    }
    private function rows($rows) {
        $rows = $this->decoded($rows);
        if (!is_array($rows) || !$rows || !array_is_list($rows)) throw new DomainException('Pilih minimal satu data.');
        foreach ($rows as $row) if (!is_array($row)) throw new DomainException('Susunan data tidak valid.');
        return $rows;
    }
    private function decoded($value) {
        if (!is_string($value)) return $value;
        try { return json_decode($value,true,512,JSON_THROW_ON_ERROR); }
        catch (JsonException $e) { throw new DomainException('Data JSON tidak valid.'); }
    }
    private function coa($value) {
        $value = $this->Request_payment_model->text($value,'COA',10);
        $coas = $this->All_model->GetCoaCombo();
        if ($value === '0' || !is_array($coas) || !isset($coas[$value])) throw new DomainException('COA tidak tersedia.');
        return $value;
    }

    private function page($kind) {
        $this->auth->restrict($this->permission($kind).'.View');
        $debug = $this->db->db_debug; $this->db->db_debug = false;
        try {
            $token = ''; $batch = [];
            if ($kind === 'payment' && has_permission('Request_Payment.Manage')) {
                $m = $this->Request_payment_model;
                $headers = $m->query('SELECT * FROM payment_approve WHERE status=1 ORDER BY id')->result_array();
                $details = $m->query('SELECT d.* FROM payment_approve_details d JOIN payment_approve p ON p.id=d.payment_id WHERE p.status=1 ORDER BY d.id')->result_array();
                $byPayment = []; foreach ($details as $row) $byPayment[$row['payment_id']][] = $row;
                $versions = []; $sources = []; $total = 0; $admin = 0;
                foreach ($headers as $h) {
                    $versions[$h['id']] = $m->version([$h,$byPayment[$h['id']] ?? []]); $total += $m->money($h['jumlah'],true); $admin += $m->money($h['bank_admin'] ?? 0);
                    try { $sources[$h['id']] = $m->source($h['tipe'],$h['ids'])['version']; }
                    catch (DomainException $e) { $sources[$h['id']] = ''; }
                }
                $token = bin2hex(random_bytes(16)); $batches = $this->session->userdata('payment_batches') ?: [];
                // ponytail: retain 20 tab manifests per session; persistent drafts need a dedicated store.
                $batches = array_slice($batches,-19,null,true);
                $batch = ['owner'=>$this->auth->user_name(),'versions'=>$versions,'sources'=>$sources,'count'=>count($versions),'total'=>$m->amount($total),'admin'=>$m->amount($admin)];
                $batches[$token] = $batch; $this->session->set_userdata('payment_batches',$batches);
            }
            foreach (['kind'=>$kind,'batch_token'=>$token,'batch'=>$batch,'can_manage'=>has_permission($this->permission($kind).'.Manage'),
                'data_coa'=>$kind === 'payment' ? $this->All_model->GetCoaCombo() : []] as $key=>$value) $this->template->set($key,$value);
            $titles = ['request'=>'Request Payment','approval'=>'Request Payment Approval','payment'=>'Payment','jurnal'=>'Payment Jurnal'];
            $this->template->title($titles[$kind]); $this->template->render(['request'=>'index','approval'=>'list_approve','payment'=>'list_payment','jurnal'=>'list_jurnal'][$kind]);
        } catch (Throwable $e) { log_message('error','Payment page: '.$e->getMessage()); show_error('Halaman payment tidak dapat dimuat.',500); }
        finally { $this->db->db_debug = $debug; }
    }

    private function manifest($token) {
        $token = $this->Request_payment_model->text($token,'Batch',32);
        $batches = $this->session->userdata('payment_batches') ?: [];
        $batch = $batches[$token] ?? null;
        if (!$batch || $batch['owner'] !== $this->auth->user_name()) throw new DomainException('Batch kedaluwarsa. Muat ulang halaman.');
        return $batch;
    }

    private function table($kind) {
        $this->auth->restrict($this->permission($kind).'.View');
        $debug = $this->db->db_debug; $this->db->db_debug = false; $draw = 0;
        try {
            $post = $this->post(); $rawDraw = filter_var($post['draw'] ?? 0,FILTER_VALIDATE_INT); $draw = $rawDraw !== false && $rawDraw >= 0 ? $rawDraw : 0;
            if ($kind === 'payment' && has_permission('Request_Payment.Manage')) $post['_payment_ids'] = array_keys($this->manifest($post['batch_token'] ?? '')['versions']);
            else unset($post['_payment_ids']);
            $data = $this->Request_payment_model->listData($kind,$post); $rows = []; $n = $data['start'];
            foreach ($data['rows'] as $r) {
                $r['no'] = ++$n;
                if ($kind === 'request') {
                    $r['key'] = $r['tipe'].':'.$r['ids'];
                    $r['version'] = $this->Request_payment_model->requestVersion($r);
                } else $r['key'] = (string)($r['id'] ?? $r['nomor']);
                if ($kind === 'approval') { $r['nilai_request'] = $r['jumlah']; $r['url'] = base_url('request_payment/approval_payment?'.http_build_query(['type'=>$r['tipe'],'id'=>$r['ids']])); }
                if ($kind === 'jurnal') { $r['url'] = base_url('request_payment/view_jurnal/'.rawurlencode($r['nomor'])); $r['edit_url'] = base_url('request_payment/edit_jurnal/'.rawurlencode($r['nomor'])); }
                $rows[] = $r;
            }
            $this->json(['draw'=>$data['draw'],'recordsTotal'=>$data['total'],'recordsFiltered'=>$data['filtered'],'data'=>$rows]);
        } catch (Throwable $e) {
            log_message('error','Payment list: '.$e->getMessage());
            $this->json(['draw'=>$draw,'recordsTotal'=>0,'recordsFiltered'=>0,'data'=>[], 'error'=>$e instanceof DomainException ? $e->getMessage() : 'Data tidak dapat dimuat.']);
        } finally { $this->db->db_debug = $debug; }
    }

    private function mutate($permission, $action) {
        $this->auth->restrict($permission.'.Manage');
        $m = $this->Request_payment_model; $debug = $this->db->db_debug; $this->db->db_debug = false;
        $active = false; $locked = false; $uncertain = false; $undo = []; $files = []; $success = false; $reply = ['save'=>false];
        $lock = 'request-payment:'.DBERP;
        try {
            $post = $this->post(); $m->text($this->auth->user_name(),'Pengguna',100);
            if ((int)$m->query('SELECT GET_LOCK(?,10) AS acquired',[$lock])->row()->acquired !== 1) throw new DomainException('Payment sedang diproses. Coba lagi.');
            $locked = true;
            if (!$this->db->trans_begin()) throw new RuntimeException('Cannot start payment transaction');
            $active = true; $action($post,$undo,$files);
            if (!$this->db->trans_status()) throw new RuntimeException('Payment transaction failed');
            $uncertain = true;
            if (!$this->db->trans_commit()) throw new RuntimeException('Cannot confirm payment commit');
            $uncertain = false; $active = false; $success = true; $reply['save'] = true;
        } catch (Throwable $e) {
            log_message('error','Payment mutation: '.$e->getMessage());
            $reply['pesan'] = $uncertain ? 'Hasil commit belum pasti. Muat ulang dan rekonsiliasi jurnal sebelum mencoba kembali.' : ($e instanceof DomainException ? $e->getMessage() : 'Proses gagal. Silakan coba lagi.');
        } finally {
            try {
                if ($active) {
                    if ($this->db->trans_rollback() && !$uncertain) {
                        foreach (array_reverse($undo) as $operation) {
                            try { $operation(); } catch (Throwable $e) { log_message('error','PAYMENT RECONCILE: '.$e->getMessage()); }
                        }
                        foreach ($files as $file) if (is_file($file) && !@unlink($file)) log_message('error','Cannot remove failed payment upload');
                    } else log_message('error','PAYMENT RECONCILE: rollback uncertain; journal and files retained');
                }
            } catch (Throwable $e) { log_message('error','PAYMENT RECONCILE: '.$e->getMessage()); }
            finally {
                if ($locked) { try { $m->query('SELECT RELEASE_LOCK(?)',[$lock]); } catch (Throwable $e) { log_message('error','Payment unlock: '.$e->getMessage()); } }
                $this->db->db_debug = $debug;
            }
        }
        try { simpan_aktifitas($permission.'.Manage','payment',$success ? 'SUKSES' : 'GAGAL',1,'',$success ? 1 : 0); }
        catch (Throwable $e) { log_message('error','Payment audit: '.$e->getMessage()); }
        $this->json($reply);
        return $success;
    }

    public function save_request() {
        $this->mutate('Request_Payment',function ($post) {
            $m = $this->Request_payment_model; $seen = [];
            foreach ($this->rows($post['items'] ?? null) as $item) {
                $s = $m->source($item['tipe'] ?? '',$item['ids'] ?? '',true); $m->requestable($s);
                $key = $s['type'].':'.$s['header']['id'];
                if (isset($seen[$key])) throw new DomainException('Pilihan duplikat.'); $seen[$key] = true;
                $current = $m->query('SELECT * FROM ('.$m->sourcesSql().') a WHERE a.tipe=? AND a.ids=?',[$s['type'],$s['header']['id']])->row_array();
                if (!$current) throw new DomainException('Sumber tidak tersedia.');
                $this->sameVersion($item['version'] ?? '',$m->requestVersion($current));
                $type = $s['type']; $h = $s['header'];
                [$description,$amount] = ['expense'=>['informasi','jumlah'],'kasbon'=>['keperluan','jumlah_kasbon'],
                    'transportasi'=>[null,'jumlah_expense'],'nonpo'=>['info','nilai_request'],'periodik'=>['nama','nilai']][$type];
                $data = ['no_doc'=>$h['no_doc'],'ids'=>(string)$h['id'],'tipe'=>$type,'status'=>0,
                    'nama'=>$m->text($current['nama'],'Nama',150),
                    'tgl_doc'=>$m->date($current['tgl_doc']),'tanggal'=>$m->date($item['tanggal'] ?? ''),
                    'keperluan'=>$m->text($description ? $h[$description] : 'Transportasi','Keperluan',150),
                    'jumlah'=>$m->amount($m->money($h[$amount],$type === 'expense')),
                    'created_by'=>$this->auth->user_name(),'created_on'=>date('Y-m-d H:i:s')];
                $data['nilai_request'] = $m->legacyAmount($m->money($data['jumlah'],true));
                foreach (['bank_id'=>50,'accnumber'=>100,'accname'=>100] as $field=>$max) $data[$field] = $m->text($h[$field] ?? '',$field,$max,false);
                $m->write('insert','request_payment',$data); $requestId = $this->db->insert_id();
                if ($type === 'periodik') $m->write('update','tr_pengajuan_rutin_detail',['id_payment'=>$requestId],['id'=>$h['id'],'no_doc'=>$h['no_doc']]);
                else $m->write('update',['expense'=>'tr_expense','kasbon'=>'tr_kasbon','transportasi'=>'tr_transport_req','nonpo'=>'tr_non_po_header'][$type],['status'=>$type === 'nonpo' ? 4 : 2],['id'=>$h['id']]);
            }
        });
    }

    public function approval_payment($type = null, $id = null) {
        $this->auth->restrict('Request_Payment_Approval.View');
        $debug = $this->db->db_debug; $this->db->db_debug = false;
        try {
            $s = $this->Request_payment_model->source($this->input->get('type') ?? $type,$this->input->get('id') ?? $id);
            $this->Request_payment_model->pending($s);
            foreach (['source'=>$s,'can_manage'=>has_permission('Request_Payment_Approval.Manage')] as $k=>$v) $this->template->set($k,$v);
            $this->template->title('Approval Payment'); $this->template->render('detail_approve');
        } catch (DomainException $e) { show_error(html_escape($e->getMessage()),404); }
        catch (Throwable $e) { log_message('error','Payment approval form: '.$e->getMessage()); show_error('Form tidak dapat dimuat.',500); }
        finally { $this->db->db_debug = $debug; }
    }

    public function save_approval() {
        $this->mutate('Request_Payment_Approval',function ($post) {
            $m = $this->Request_payment_model; $s = $m->source($post['tipe'] ?? '',$post['id'] ?? '',true); $m->pending($s);
            $this->sameVersion($post['version'] ?? '',$s['version']);
            $eligible = []; foreach ($s['details'] as $d) if ($m->eligible($s['type'],$d)) $eligible[(string)$d['id']] = $d;
            $selected = []; $sum = 0;
            foreach ($this->rows($post['items'] ?? null) as $item) {
                $id = $m->id($item['id'] ?? '');
                if (!isset($eligible[$id]) || isset($selected[$id])) throw new DomainException('Detail asing, duplikat, atau sudah diproses.');
                $selected[$id] = $m->snapshot($s['type'],$eligible[$id]); $sum += $m->money($selected[$id]['total']);
            }
            $restricted = $m->restricted($s);
            if ($restricted && (count($selected) !== count($s['details']) || count($eligible) !== count($s['details']))) throw new DomainException('Expense berpajak atau Kasbon wajib diproses utuh.');
            if ($restricted) {
                $sum = 0; foreach ($s['details'] as $d) $sum += $m->money($d['expense']) - $m->money($d['kasbon']);
                $sum += $m->money($s['header']['add_ppn_nilai'] ?? 0) - $m->money($s['header']['add_pph_nilai'] ?? 0);
            }
            if ($s['type'] === 'expense' && count($selected) === count($s['details']) && $sum !== $m->money($s['header']['jumlah'],true)) throw new DomainException('Total Expense tidak sesuai detail. Perlu rekonsiliasi.');
            if (count($selected) > 99) throw new DomainException('Maksimal 99 detail per batch sesuai kapasitas nomor.');
            $year = substr($m->date($s['request']['tgl_doc']),0,4); $prefix = 'PAY'.$year;
            $last = $m->query('SELECT id FROM payment_approve WHERE id LIKE ? ORDER BY id DESC LIMIT 1 FOR UPDATE',[$prefix.'%'])->row();
            $next = $last ? (int)substr($last->id,-5)+1 : 1;
            if ($next > 99999) throw new DomainException('Nomor pembayaran tahun ini penuh.');
            $paymentId = $prefix.str_pad((string)$next,5,'0',STR_PAD_LEFT);
            $h = $s['request']; $h['id'] = $paymentId; $h['jumlah'] = $m->amount($sum); $h['nilai_request'] = $m->legacyAmount($sum); $h['status'] = 1;
            $h['approved_by'] = $this->auth->user_name(); $h['approved_on'] = date('Y-m-d H:i:s');
            $m->write('insert','payment_approve',$h); $n = 0;
            $table = ['expense'=>'tr_expense_detail','kasbon'=>'tr_kasbon','transportasi'=>'tr_transport','nonpo'=>'tr_non_po_detail','periodik'=>'tr_pengajuan_rutin_detail'][$s['type']];
            foreach ($selected as $sourceId=>$detail) {
                $detail += ['id'=>$paymentId.'-'.str_pad((string)++$n,2,'0',STR_PAD_LEFT),'payment_id'=>$paymentId,'created_by'=>$this->auth->user_name(),'created_on'=>date('Y-m-d H:i:s')];
                $m->write('insert','payment_approve_details',$detail);
                $m->write('update',$table,['status'=>(string)['expense'=>1,'kasbon'=>3,'transportasi'=>2,'nonpo'=>1,'periodik'=>1][$s['type']]],['id'=>$sourceId]);
            }
            $m->write('update','request_payment',['status'=>count($selected) === count($eligible) ? 2 : 1,'approved_by'=>$this->auth->user_name(),'approved_on'=>date('Y-m-d H:i:s')],['id'=>$s['request']['id'],'tipe'=>$s['type']]);
        });
    }
    private function adminCoa($menu) {
        $rows = $this->Request_payment_model->query('SELECT no_perkiraan FROM '.DBACC.'.master_oto_jurnal_detail WHERE kode_master_jurnal=? AND menu=?',['BUK030',$menu])->result_array();
        if (count($rows) !== 1) throw new DomainException('Konfigurasi jurnal '.$menu.' tidak ditemukan atau ambigu.');
        return $this->coa($rows[0]['no_perkiraan']);
    }

    private function journalLine($number, $header, $coa, $cents, $note) {
        $m = $this->Request_payment_model;
        if (!is_int($cents) || abs($cents) > 9007199254740991) throw new DomainException('Total jurnal melewati batas aman.');
        $actor = $m->text($header['nama'],'Nama',150,false);
        // nocust holds 15 characters; preserve long display names outside this legacy reference field.
        if (preg_match_all('/./us',$actor) > 15) $actor = $header['_source_actor'];
        return ['nomor'=>$number,'tanggal'=>date('Y-m-d'),'tipe'=>'BUK','no_perkiraan'=>$this->coa($coa),
            'keterangan'=>$m->text($note,'Keterangan jurnal',150,false),'no_request'=>$m->text($header['no_doc'],'Nomor request',25),
            'no_reff'=>$m->text($header['no_doc'],'Referensi',25),'nocust'=>$m->text($actor,'Referensi pembuat jurnal',15,false),
            'debet'=>$m->amount(max(0,$cents)),'kredit'=>$m->amount(max(0,-$cents)),'jenis_jurnal'=>'BUK030','stspos'=>'0'];
    }

    private function upload($key, &$files) {
        if (!isset($_FILES[$key])) return null;
        $file = $_FILES[$key];
        if (!is_array($file) || !isset($file['error']) || !is_int($file['error'])) throw new DomainException('Lampiran tidak valid.');
        if ($file['error'] === UPLOAD_ERR_NO_FILE) return null;
        if ($file['error'] !== UPLOAD_ERR_OK) throw new DomainException('Upload gagal, kode '.$file['error'].'.');
        foreach (['name','type','tmp_name','size'] as $field) if (!isset($file[$field]) || !is_scalar($file[$field])) throw new DomainException('Lampiran tidak valid.');
        $directory = FCPATH.'assets/expense';
        if (!is_dir($directory) && !@mkdir($directory,0755) && !is_dir($directory)) throw new RuntimeException('Cannot create payment upload directory');
        $path = realpath($directory);
        $this->load->library('upload');
        $this->upload->initialize(['upload_path'=>$path,'allowed_types'=>'gif|jpg|png|jpeg|bmp|pdf|doc|docx|jfif','encrypt_name'=>true,'detect_mime'=>true]);
        if (!$this->upload->do_upload($key)) throw new DomainException('Upload lampiran gagal: '.strip_tags($this->upload->display_errors('','')));
        $data = $this->upload->data(); $full = realpath($data['full_path']);
        if (!$full || dirname($full) !== $path) throw new RuntimeException('Unexpected payment upload path');
        $files[] = $full;
        return basename($full);
    }

    private function matchedSource($payment, &$claimed) {
        $m = $this->Request_payment_model; $h = $payment['header']; $s = $m->source($h['tipe'],$h['ids'],true);
        if ($s['header']['no_doc'] !== $h['no_doc']) throw new DomainException('Relasi sumber pembayaran tidak valid.');
        if ($s['type'] === 'periodik') {
            if ((string)$s['parent']['status'] !== '1' || !$s['request'] || (string)$s['header']['id_payment'] !== (string)$s['request']['id']) throw new DomainException('Relasi rutin berubah.');
        } elseif ($s['type'] !== 'kasbon' && (string)$s['header']['status'] !== ($s['type'] === 'nonpo' ? '4' : '2')) throw new DomainException('Status sumber berubah.');
        $approved = ['expense'=>'1','kasbon'=>'3','transportasi'=>'2','nonpo'=>'1','periodik'=>'1'][$s['type']];
        $available = [];
        $sourceKey = $s['type'].':'.$s['header']['id'];
        foreach ($s['details'] as $row) if ((string)$row['status'] === $approved && !isset($claimed[$sourceKey][(string)$row['id']])) $available[(string)$row['id']] = $row;
        $matched = [];
        foreach ($payment['details'] as $detail) {
            $found = null;
            foreach ($available as $id=>$source) {
                $snapshot = $m->snapshot($s['type'],$source); $same = true;
                foreach ($snapshot as $field=>$value) {
                    $actual = $detail[$field] ?? '';
                    if (in_array($field,['harga','total'],true)) $actual = $m->amount($m->money($actual));
                    if ((string)$actual !== (string)$value) { $same = false; break; }
                }
                if ($same) { $found = $id; break; }
            }
            if ($found === null) throw new DomainException('Snapshot dan sumber pembayaran '.$h['id'].' berbeda. Perlu rekonsiliasi.');
            $matched[$found] = $available[$found]; unset($available[$found]);
            $claimed[$sourceKey][$found] = true;
        }
        if ($m->restricted($s) && count($matched) !== count($s['details'])) throw new DomainException('Expense berpajak/Kasbon parsial lama perlu rekonsiliasi.');
        return [$s,$matched];
    }

    public function save_payment() {
        $token = $this->input->post('batch_token');
        $success = $this->mutate('Request_Payment',function ($post,&$undo,&$files) {
            $m = $this->Request_payment_model; $batch = $this->manifest($post['batch_token'] ?? '');
            if (!$batch['versions']) throw new DomainException('Batch pembayaran kosong.');
            $edits = $this->decoded($post['edits'] ?? []);
            if (!is_array($edits)) throw new DomainException('Isian pembayaran tidak valid.');
            foreach ($edits as $id=>$edit) if (!isset($batch['versions'][$id]) || !is_array($edit)) throw new DomainException('Isian di luar batch awal.');
            $expectedFiles = $this->decoded($post['files'] ?? []);
            if (!is_array($expectedFiles) || !array_is_list($expectedFiles) || count(array_unique($expectedFiles,SORT_REGULAR)) !== count($expectedFiles)) throw new DomainException('Daftar lampiran tidak valid.');
            foreach ($expectedFiles as $id) {
                if (!is_string($id) || !isset($batch['versions'][$id]) || !isset($_FILES['doc_file_'.$id]) || ($_FILES['doc_file_'.$id]['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) throw new DomainException('Lampiran tidak lengkap atau melebihi batas server.');
            }
            foreach ($_FILES as $key=>$file) if (!in_array(substr($key,9),$expectedFiles,true) || substr($key,0,9) !== 'doc_file_') throw new DomainException('Lampiran di luar daftar batch.');
            $bank = $this->coa($post['bank_coa'] ?? ''); $plans = []; $claimed = [];
            $versions = $batch['versions']; ksort($versions);
            foreach ($versions as $id=>$version) {
                $p = $m->payment($id,true); $this->sameVersion($version,$p['version']); $h = $p['header'];
                [$s,$matched] = $this->matchedSource($p,$claimed); $this->sameVersion($batch['sources'][$id] ?? '',$s['version']); $edit = $edits[$id] ?? [];
                $h['_source_actor'] = ($s['parent']['created_by'] ?? $s['header']['created_by'] ?? '') ?: $h['ids'];
                $admin = $m->money($edit['bank_admin'] ?? $h['bank_admin'] ?? 0);
                $note = $m->text($edit['keterangan'] ?? $h['keterangan'] ?? '','Keterangan',150,false);
                $number = 'BUK030'.$id;
                if ($m->query('SELECT id FROM jurnal WHERE nomor=? LIMIT 1',[$number])->row()) throw new DomainException('Jurnal batch '.$id.' sudah ada. Perlu rekonsiliasi sebelum mengulang pembayaran.');
                $lines = []; $net = 0;
                if ($s['type'] === 'expense') {
                    foreach ($matched as $source) {
                        $value = $m->money($source['expense']) - $m->money($source['kasbon']); $net += $value;
                        $lines[] = $this->journalLine($number,$h,$source['coa'],$value,$note);
                    }
                    if ($m->restricted($s)) foreach (['add_ppn_nilai'=>['add_ppn_coa',1],'add_pph_nilai'=>['add_pph_coa',-1]] as $field=>$tax) {
                        $value = $m->money($s['header'][$field] ?? 0) * $tax[1]; $net += $value;
                        if ($value) $lines[] = $this->journalLine($number,$h,$s['header'][$tax[0]],$value,$note);
                    }
                } else {
                    foreach ($p['details'] as $d) $net += $m->money($d['total']);
                    if (in_array($s['type'],['kasbon','nonpo'],true)) $coa = $this->adminCoa($s['type']);
                    elseif ($s['type'] === 'transportasi') $coa = $this->adminCoa('transportasi');
                    else $coa = $s['header']['coa'];
                    $lines[] = $this->journalLine($number,$h,$coa,$net,$note);
                }
                if ($net !== $m->money($h['jumlah'],true)) throw new DomainException('Nominal batch tidak sesuai sumber. Perlu rekonsiliasi.');
                if ($admin) $lines[] = $this->journalLine($number,$h,$this->adminCoa('admin'),$admin,$note);
                $lines[] = $this->journalLine($number,$h,$bank,-($net+$admin),$note);
                $balance = 0; foreach ($lines as $line) $balance += $m->money($line['debet']) - $m->money($line['kredit']);
                if ($balance !== 0) throw new DomainException('Jurnal tidak seimbang.');
                $plans[] = ['id'=>$id,'header'=>$h,'source'=>$s,'matched'=>$matched,'lines'=>$lines,'admin'=>$admin,'net'=>$net,'note'=>$note,'number'=>$number];
            }
            foreach ($plans as $plan) {
                $id = $plan['id']; $number = $plan['number'];
                $file = $this->upload('doc_file_'.$id,$files);
                $data = ['status'=>2,'bank_nilai'=>$m->amount($plan['net']),'nilai_request'=>$m->legacyAmount($plan['net']),
                    'bank_admin'=>$m->amount($plan['admin']),'bank_coa'=>$bank,'keterangan'=>$plan['note'],'pay_by'=>$this->auth->user_name(),'pay_on'=>date('Y-m-d H:i:s')];
                if ($file !== null) $data['doc_file'] = $file;
                $m->write('update','payment_approve',$data,['id'=>$id,'status'=>1]);
                if ($this->db->affected_rows() !== 1) throw new DomainException('Pembayaran sudah diproses.');
                $table = ['expense'=>'tr_expense_detail','kasbon'=>'tr_kasbon','transportasi'=>'tr_transport','nonpo'=>'tr_non_po_detail','periodik'=>'tr_pengajuan_rutin_detail'][$plan['source']['type']];
                foreach ($plan['matched'] as $sourceId=>$row) $m->write('update',$table,['status'=>(string)['expense'=>2,'kasbon'=>4,'transportasi'=>3,'nonpo'=>2,'periodik'=>2][$plan['source']['type']]],['id'=>$sourceId]);
                // MyISAM cannot roll back; compensate only this reserved journal number.
                $undo[] = function () use ($m,$number) { $m->query("DELETE FROM jurnal WHERE nomor=? AND jenis_jurnal='BUK030'",[$number]); };
                foreach ($plan['lines'] as $line) $m->write('insert','jurnal',$line);
            }
        });
        if ($success) {
            $batches = $this->session->userdata('payment_batches') ?: []; unset($batches[$token]); $this->session->set_userdata('payment_batches',$batches);
        }
    }

    public function view_jurnal($number) { $this->journalForm($number,false); }
    public function edit_jurnal($number) { $this->journalForm($number,true); }
    private function journalForm($number, $edit) {
        $this->auth->restrict('Request_Payment.'.($edit ? 'Manage' : 'View'));
        $debug = $this->db->db_debug; $this->db->db_debug = false;
        try {
            $m = $this->Request_payment_model; $journal = $m->journal($number);
            if ($edit) foreach ($journal['rows'] as $row) if ((string)$row['stspos'] !== '0') throw new DomainException('Jurnal sudah diposting.');
            foreach (['journal'=>$journal,'edit'=>$edit,'groups'=>$m->journalGroups($journal['rows']),'data_coa'=>$this->All_model->GetCoaCombo()] as $k=>$v) $this->template->set($k,$v);
            $this->template->title('Payment Jurnal'); $this->template->render($edit ? 'form_jurnal' : 'view_jurnal');
        } catch (DomainException $e) { show_error(html_escape($e->getMessage()),404); }
        catch (Throwable $e) { log_message('error','Payment journal form: '.$e->getMessage()); show_error('Jurnal tidak dapat dimuat.',500); }
        finally { $this->db->db_debug = $debug; }
    }

    public function jurnal_save() {
        $this->mutate('Request_Payment',function ($post,&$undo) {
            $m = $this->Request_payment_model; $j = $m->journal($post['nomor'] ?? ''); $original = $j['rows']; $h = $original[0];
            foreach ($original as $r) if ((string)$r['stspos'] !== '0') throw new DomainException('Jurnal sudah diposting.');
            $this->sameVersion($post['version'] ?? '',$j['version']); $date = $m->date($post['tanggal'] ?? '');
            $groups = []; foreach ($m->journalGroups($original) as $g) $groups[$g['id']] = $g;
            $items = $this->rows($post['items'] ?? null);
            if (count($items) !== count($groups)) throw new DomainException('Susunan jurnal berubah.');
            $debet = 0; $kredit = 0; $lines = []; $seen = [];
            foreach ($items as $item) {
                $id = $m->id($item['id'] ?? '');
                if (!isset($groups[$id]) || isset($seen[$id])) throw new DomainException('Baris jurnal asing atau duplikat.'); $seen[$id] = true;
                $d = $m->money($item['debet'] ?? ''); $k = $m->money($item['kredit'] ?? '');
                $debet += $d; $kredit += $k;
                $lines[] = ['tipe'=>'BUK','tanggal'=>$date,'no_reff'=>$h['nomor'],'no_perkiraan'=>$this->coa($item['coa'] ?? ''),
                    'keterangan'=>$m->text($item['keterangan'] ?? '','Keterangan',150,false),'debet'=>$m->amount($d),'kredit'=>$m->amount($k)];
            }
            if ($debet !== $kredit || $debet === 0 || $debet > 9007199254740991) throw new DomainException('Total debit dan kredit harus seimbang dan bukan nol.');
            $counter = $m->query('SELECT * FROM '.DBACC.'.pastibisa_tb_cabang WHERE nocab=? FOR UPDATE',['101'])->result_array();
            if (count($counter) !== 1) throw new DomainException('Counter cabang tidak ditemukan atau ambigu.');
            $next = (int)$counter[0]['nobuk']+1; $number = '101BK'.date('y').str_pad((string)$next,6,'0',STR_PAD_LEFT);
            if (strlen($number) > 15 || $m->query('SELECT nomor FROM '.DBACC.'.jurnal WHERE nomor=? LIMIT 1',[$number])->row()
                || $m->query('SELECT nomor FROM '.DBACC.'.japh WHERE nomor=? OR no_reff=? LIMIT 1',[$number,$h['nomor']])->row()) throw new DomainException('Nomor atau referensi accounting sudah digunakan.');
            foreach ($lines as $line) $m->write('insert',DBACC.'.jurnal',['nomor'=>$number]+$line);
            $undo[] = function () use ($m,$number) { $m->query('DELETE FROM '.DBACC.'.japh WHERE nomor=?',[$number]); };
            $m->write('insert',DBACC.'.japh',['nomor'=>$number,'tgl'=>$date,'jml'=>$m->amount($debet),'kdcab'=>'101','jenis_reff'=>'BUK','no_reff'=>$h['nomor'],
                'customer'=>$h['nocust'] ?? '','valid'=>'0','jenis_ap'=>'V','note'=>$m->text('Payment '.$h['no_reff'],'Catatan accounting',50),'user_id'=>$m->text($this->auth->user_name(),'Pengguna accounting',30),'ho_valid'=>'','batal'=>0]);
            $m->write('update',DBACC.'.pastibisa_tb_cabang',['nobuk'=>$next],['id'=>$counter[0]['id'],'nocab'=>'101']);
            $undo[] = function () use ($m,$original) { foreach ($original as $r) $m->write('update','jurnal',['stspos'=>$r['stspos']],['id'=>$r['id'],'nomor'=>$r['nomor']]); };
            $m->write('update','jurnal',['stspos'=>'1'],['nomor'=>$h['nomor'],'jenis_jurnal'=>'BUK030']);
        });
    }

    public function export_payment() {
        $this->auth->restrict('Request_Payment.View'); $debug = $this->db->db_debug; $this->db->db_debug = false;
        try {
            $post = $this->post(); unset($post['_payment_ids']); $data = $this->Request_payment_model->listData('payment',$post,true);
            $this->output->set_content_type('application/vnd.ms-excel');
            $this->output->set_header('Content-Disposition: attachment; filename="Payment.xls"');
            echo '<meta charset="utf-8"><table><tr><th>No Dokumen</th><th>Request By</th><th>Nilai Pengajuan</th><th>Tanggal Pembayaran</th></tr>';
            foreach ($data['rows'] as $r) {
                echo '<tr>'; foreach (['no_doc','nama','jumlah','tanggal'] as $key) {
                    $value = (string)$r[$key]; if (preg_match('/^[\s]*[=+@-]/',$value)) $value = "'".$value;
                    echo '<td>'.html_escape($value).'</td>';
                } echo '</tr>';
            } echo '</table>';
        } catch (Throwable $e) { log_message('error','Payment export: '.$e->getMessage()); show_error('Export gagal.',400); }
        finally { $this->db->db_debug = $debug; }
    }
}
