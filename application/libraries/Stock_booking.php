<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once __DIR__ . '/Stock_booking_store.php';

class Stock_booking
{
    private $ci;
    private $store;

    public function __construct()
    {
        $this->ci =& get_instance();
        $this->store = new Stock_booking_store($this->ci->db->conn_id, $this->ci->auth->user_id());
    }

    public function document($callback)
    {
        $locked = false;
        $originalDebug = $this->ci->db->db_debug;
        $this->ci->db->db_debug = false;
        $bufferLevel = ob_get_level();
        ob_start();
        try {
            $result = $this->store->query("SELECT GET_LOCK('waterco-stock-booking',15) acquired");
            $locked = (int)$result[0]['acquired'] === 1;
            if (!$locked) { throw new DomainException('Stok sedang diproses. Silakan coba kembali.'); }
            $this->store->ready();
            if (!$this->ci->db->trans_begin()) { throw new RuntimeException('Cannot start stock transaction.'); }
            $callback();
            if (!$this->ci->db->trans_status() || !$this->ci->db->trans_commit()) { throw new RuntimeException('Cannot commit stock transaction.'); }
            $response = ob_get_clean();
            echo $response;
        } catch (Throwable $error) {
            while ($this->ci->db->trans_rollback()) {}
            while (ob_get_level() > $bufferLevel) { ob_end_clean(); }
            log_message('error', 'Stock booking operation rejected: ' . get_class($error));
            echo json_encode(array('status'=>0,'valid'=>0,'code'=>'','pesan'=>$error instanceof DomainException ? $error->getMessage() : 'Transaksi stok gagal; tidak ada perubahan disimpan.',
                'msg'=>$error instanceof DomainException ? $error->getMessage() : 'Transaksi stok gagal; tidak ada perubahan disimpan.'));
        } finally {
            $this->ci->db->db_debug = $originalDebug;
            if ($locked) { $this->store->query("SELECT RELEASE_LOCK('waterco-stock-booking')"); }
        }
    }

    private function transaction($callback)
    {
        $this->ci->db->trans_begin();
        try {
            $result = $callback();
            if (!$this->ci->db->trans_status()) { throw new RuntimeException('Stock transaction failed.'); }
            $this->ci->db->trans_commit();
            return $result;
        } catch (Throwable $error) {
            while ($this->ci->db->trans_rollback()) {}
            throw $error;
        }
    }

    public function reserveSo($noSo)
    {
        $this->transaction(function() use ($noSo) { $this->store->reserveSo($noSo); });
    }

    public function readyIndent($noSo)
    {
        $this->transaction(function() use ($noSo) { $this->store->readyIndent($noSo); });
    }

    public function releaseSo($noSo)
    {
        $this->transaction(function() use ($noSo) { $this->store->releaseSo($noSo); });
    }

    public function cancelSo($noSo)
    {
        $this->transaction(function() use($noSo){$this->store->cancelSo($noSo);});
    }

    public function cancelPlanning($noPlanning)
    {
        $this->transaction(function() use($noPlanning){$this->store->cancelPlanning($noPlanning);});
    }

    public function confirmDelivery($post, $upload = null)
    {
        $statuses = array();
        if (empty($post['no_surat']) || empty($post['dt']) || !is_array($post['dt'])) { throw new DomainException('Detail konfirmasi DO tidak lengkap.'); }
        foreach ($post['dt'] as $detail) {
            $id = (string)Stock_booking_rules::quantity($detail['id_do'] ?? null);
            if (isset($statuses[$id])) { throw new DomainException('Detail DO dikirim dua kali.'); }
            $statuses[$id] = (string)($detail['status_kirim'] ?? '');
        }
        $this->transaction(function() use ($post, $statuses, $upload) {
            $this->store->confirmDelivery($post['no_surat'], $statuses, $upload);
            foreach ($post['dt'] as $detail) {
                $this->store->query('UPDATE tr_delivery_order_detail SET keterangan_statuskirim=? WHERE id_do_detail=? AND no_do=?', array((string)($detail['keterangan_statuskirim']??''),$detail['id_do'],$post['no_surat']));
            }
        });
    }

    public function changeActual($material, $qty, $reference, $number, $direction, $warehouse = '1', $table = 'stock_material', $cost = array())
    {
        return $this->transaction(function() use ($material,$qty,$reference,$number,$direction,$warehouse,$table,$cost) {
            return $this->store->changeActual($material,$qty,$reference,$number,$direction,$warehouse,$table,$cost);
        });
    }

    public function adjustmentToken()
    {
        $tokens = $this->ci->session->userdata('adjustment_requests');
        // ponytail: Keep 50 open forms per session; use expiring token storage for larger batches.
        $tokens = is_array($tokens) ? array_slice($tokens, -49, null, true) : array();
        $token = bin2hex(random_bytes(16));
        $tokens[$token] = true;
        $this->ci->session->set_userdata('adjustment_requests', $tokens);
        return $token;
    }

    public function adjustment($post, $code, $mainOnly = true)
    {
        $tokens = $this->ci->session->userdata('adjustment_requests');
        $token = is_array($post) ? ($post['request_key'] ?? null) : null;
        if (!is_string($token) || !is_array($tokens) || !isset($tokens[$token])) {
            throw new DomainException('Token adjustment tidak valid atau kedaluwarsa. Muat ulang formulir.');
        }
        return $this->transaction(function () use ($post, $code, $mainOnly) { $this->store->adjustment($post, $code, $mainOnly); });
    }

    public function incomingStock($material)
    {
        $stock=$this->store->findStock($material);
        $this->store->assertLedger('stock_material',$stock);
        return (object)$stock;
    }

    public function validatePlanning($post)
    {
        $this->store->validatePlanning($post);
    }

    public function validateSpk($post)
    {
        $this->store->validateSpk($post);
    }

    public function validateDeliveryDraft($post)
    {
        $this->store->validateDeliveryDraft($post);
    }

    public function validateOrder($quotation, $postedType, $requestKey)
    {
        $rows=$this->store->query('SELECT order_status FROM tr_penawaran WHERE no_penawaran=? FOR UPDATE',array($quotation));
        if (count($rows)!==1 || !in_array($rows[0]['order_status'],array('stk','ind'),true) || $postedType!==$rows[0]['order_status']) { throw new DomainException('Jenis SO harus sesuai penawaran yang tersimpan.'); }
        if (!is_string($requestKey) || !preg_match('/^[a-f0-9]{32}$/D', $requestKey)) { throw new DomainException('Token permintaan SO tidak valid. Muat ulang formulir.'); }
        $key='create-so:'.$requestKey;
        if ($this->store->query('SELECT operation_key FROM stock_booking_operations WHERE operation_key=? FOR UPDATE',array($key))) { throw new DomainException('Permintaan SO ini sudah diproses. Periksa SO yang tersimpan.'); }
        $this->store->query("INSERT INTO stock_booking_operations VALUES (?,'create-so',?,NOW())",array($key,json_encode(array($quotation,$postedType))));
    }
}
