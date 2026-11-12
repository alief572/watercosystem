<?php
require_once __DIR__ . '/Stock_booking_rules.php';

/** Uses the caller's transaction, so document, allocation and stock commit together. */
class Stock_booking_store
{
    private $connection;
    private $actor;
    private $maxLegacyDetail = 0;

    public function __construct($connection, $actor = 'stock-booking-cli')
    {
        $this->connection = $connection;
        $this->actor = (string)$actor;
        $this->query("SET time_zone='+07:00'");
        $this->query('SET @stock_booking_write=NULL');
        $this->query('SET @stock_booking_quarantine_admin=NULL, @stock_booking_maintenance_write=NULL');
    }

    public function query($sql, $params = array())
    {
        $stmt = $this->connection->prepare($sql);
        if (!$stmt) { throw new RuntimeException('Stock booking query preparation failed.'); }
        if ($params) { $stmt->bind_param(str_repeat('s', count($params)), ...$params); }
        if (!$stmt->execute()) { throw new RuntimeException('Stock booking query failed.'); }
        $result = $stmt->get_result();
        $rows = $result ? $result->fetch_all(MYSQLI_ASSOC) : array();
        $stmt->close();
        return $rows;
    }

    public function ready()
    {
        $control=$this->query('SELECT maintenance FROM stock_booking_control WHERE id=1');
        if(count($control)!==1 || (int)$control[0]['maintenance']!==0){throw new DomainException('Stok sedang dalam maintenance cleansing. Silakan coba kembali setelah selesai.');}
        $rows = $this->query("SELECT max_legacy_detail FROM stock_booking_batches WHERE status='applied' ORDER BY created_on LIMIT 1");
        if (!$rows) { throw new DomainException('Baseline booking belum diterapkan. Jalankan audit dan selesaikan konflik cleansing.'); }
        $this->maxLegacyDetail = (int)$rows[0]['max_legacy_detail'];
    }

    public static function table($table)
    {
        if (!in_array($table, array('stock_material', 'stock_material_multigudang'), true)) {
            throw new DomainException('Tabel stok tidak valid.');
        }
        return $table;
    }

    public function stock($table, $id)
    {
        $table = self::table($table);
        $this->assertNotQuarantined($table,$id);
        $rows = $this->query("SELECT * FROM $table WHERE id_stock=? FOR UPDATE", array($id));
        if (count($rows) !== 1) { throw new DomainException('Baris stok tidak ditemukan.'); }
        return $rows[0];
    }

    public function findStock($material, $warehouse = '1', $table = 'stock_material')
    {
        $table = self::table($table);
        $rows = $this->query("SELECT * FROM $table WHERE id_category3=? AND id_gudang=? AND COALESCE(deleted,0)=0 ORDER BY id_stock FOR UPDATE", array($material, $warehouse));
        if (count($rows) !== 1) { throw new DomainException('Stok barang/gudang tidak unik atau belum tersedia: ' . $material); }
        $this->assertNotQuarantined($table,$rows[0]['id_stock']);
        return $rows[0];
    }

    public function assertNotQuarantined($table, $id)
    {
        $rows=$this->query("SELECT reason FROM stock_booking_quarantine WHERE stock_table=? AND id_stock=? AND status='active' LIMIT 1",array(self::table($table),$id));
        if($rows){throw new DomainException('Barang ini dikarantina sampai Qty Aktual dan booking direkonsiliasi.');}
    }

    private function assertDetailAvailable($detailId)
    {
        $rows=$this->query("SELECT q.id_stock FROM stock_booking_quarantine q JOIN tr_sales_order_detail d
            ON d.id_category3=q.id_category3 WHERE d.id_so_detail=? AND q.stock_table='stock_material'
            AND q.id_gudang='1' AND q.status='active' LIMIT 1",array($detailId));
        if($rows){throw new DomainException('Detail SO memuat barang yang sedang dikarantina.');}
    }

    public function writeStock($table, $before, $after, $type, $reference, $number = '', $cost = array())
    {
        $table = self::table($table);
        $this->assertNotQuarantined($table,$before['id_stock']);
        $after = Stock_booking_rules::reconcile($after['qty'], $after['qty_book']);
        $this->query('SET @stock_booking_write=1');
        try {
            $this->query("UPDATE $table SET qty=?,qty_book=?,qty_free=? WHERE id_stock=?", array($after['qty'], $after['qty_book'], $after['qty_free'], $before['id_stock']));
        } finally {
            $this->query('SET @stock_booking_write=NULL');
        }
        $card = $table === 'stock_material' ? 'kartu_stok' : 'kartu_stok_multigudang';
        $delta = $after['qty'] - (int)$before['qty'];
        $this->query("INSERT INTO $card (id_category3,qty,qty_book,qty_free,transaksi,tgl_transaksi,no_transaksi,id_gudang,created_on,created_by,qty_transaksi,qty_akhir,qty_book_akhir,qty_free_akhir,status_transaksi,no_surat,harga_stok,harga_do,cost_book) VALUES (?,?,?,?,?,CURDATE(),?,?,NOW(),?,?,?,?,?,?,?,?,?,?)", array(
            $before['id_category3'], $before['qty'], $before['qty_book'], $before['qty_free'], $type,
            $reference, $before['id_gudang'], $this->actor,
            abs($delta ?: $after['qty_book']-(int)$before['qty_book']), $after['qty'], $after['qty_book'], $after['qty_free'],
            $delta < 0 || $after['qty_book'] > (int)$before['qty_book'] ? 'out' : 'in', $number,
            $cost['harga_stok']??0,$cost['harga_do']??0,$cost['cost_book']??0
        ));
    }

    private function operation($key, $type, $payload)
    {
        $encoded = json_encode($payload, JSON_THROW_ON_ERROR);
        $existing = $this->query('SELECT payload FROM stock_booking_operations WHERE operation_key=? FOR UPDATE', array($key));
        if ($existing) {
            if ($existing[0]['payload'] !== $encoded) { throw new DomainException('Operasi sudah diproses dengan isi berbeda. Gunakan transaksi pembalik.'); }
            return false;
        }
        $this->query('INSERT INTO stock_booking_operations VALUES (?,?,?,NOW())', array($key, $type, $encoded));
        return true;
    }

    public function reserveSo($noSo, $activateIndent = false)
    {
        $this->ready();
        $headers = $this->query('SELECT * FROM tr_sales_order WHERE no_so=? FOR UPDATE', array($noSo));
        if (count($headers) !== 1) { throw new DomainException('SO tidak unik atau tidak ditemukan.'); }
        $header = $headers[0];
        if ($header['deleted_by'] !== null || in_array((int)$header['status'], array(5,7), true)) { throw new DomainException('SO tidak aktif.'); }
        if ((int)$header['status'] === 0 || ($header['order_status'] === 'ind' && $header['indent_check'] !== '1')) { return; }
        $details = $this->query('SELECT * FROM tr_sales_order_detail WHERE no_so=? ORDER BY id_category3,id_so_detail FOR UPDATE', array($noSo));
        foreach ($details as $detail) {
            $this->assertDetailAvailable($detail['id_so_detail']);
            $ordered = Stock_booking_rules::quantity($detail['qty_so']);
            if (!$ordered) { throw new DomainException('Qty SO harus lebih dari nol.'); }
            $allocations = $this->query('SELECT * FROM stock_booking_allocations WHERE id_so_detail=? FOR UPDATE', array($detail['id_so_detail']));
            if (count($allocations) > 1) { throw new DomainException('Detail SO memiliki beberapa alokasi; perubahan Qty harus direkonsiliasi per gudang.'); }
            if ($allocations) {
                $allocation = $allocations[0];
                $stock = $this->stock($allocation['stock_table'], $allocation['id_stock']);
                $delta = $ordered - (int)$allocation['ordered_qty'];
                $target = (int)$allocation['qty_reserved'] + $delta;
                if ($target < 0) { throw new DomainException('Qty SO baru di bawah jumlah yang sudah dikirim/dilepas.'); }
                $table = $allocation['stock_table'];
            } else {
                if ((int)$detail['id_so_detail'] <= $this->maxLegacyDetail && !$activateIndent) {
                    throw new DomainException('Booking SO lama sudah dilepas saat cleansing. Alokasi ulang memerlukan pemeriksaan baru.');
                }
                $stock = $this->findStock($detail['id_category3']);
                $target = $ordered;
                $delta = $target;
                $table = 'stock_material';
                $this->query('INSERT INTO stock_booking_allocations (id_so_detail,stock_table,id_stock,updated_on) VALUES (?,?,?,NOW())', array($detail['id_so_detail'], $table, $stock['id_stock']));
            }
            $this->assertLedger($table, $stock);
            $after = Stock_booking_rules::reconcile($stock['qty'], (int)$stock['qty_book']+$delta);
            if ($delta) { $this->writeStock($table, $stock, $after, 'sales order booking', $noSo, $header['no_surat']); }
            $this->query('UPDATE stock_booking_allocations SET qty_reserved=?,ordered_qty=?,updated_on=NOW() WHERE id_so_detail=? AND stock_table=? AND id_stock=?', array($target,$ordered,$detail['id_so_detail'],$table,$stock['id_stock']));
        }
    }

    public function readyIndent($noSo)
    {
        $this->ready();
        $rows = $this->query('SELECT * FROM tr_sales_order WHERE no_so=? FOR UPDATE', array($noSo));
        if (count($rows) !== 1 || $rows[0]['order_status'] !== 'ind') { throw new DomainException('SO bukan SO Indent.'); }
        if ($rows[0]['indent_check'] === '1') { return; }
        $this->query("UPDATE tr_sales_order SET indent_check='1' WHERE no_so=?", array($noSo));
        $this->reserveSo($noSo, true);
    }

    public function assertLedger($table, $stock)
    {
        $valid = Stock_booking_rules::reconcile($stock['qty'], $stock['qty_book']);
        $sum = $this->query('SELECT COALESCE(SUM(qty_reserved),0) qty FROM stock_booking_allocations WHERE stock_table=? AND id_stock=? FOR UPDATE', array($table, $stock['id_stock']));
        if ((int)$sum[0]['qty'] !== $valid['qty_book'] || $stock['qty_free'] === null || (int)$stock['qty_free'] !== $valid['qty_free']) {
            throw new DomainException('Saldo stok berbeda dengan alokasi booking. Jalankan audit sebelum transaksi.');
        }
    }

    public function releaseSo($noSo)
    {
        $this->ready();
        $headers = $this->query('SELECT * FROM tr_sales_order WHERE no_so=? FOR UPDATE', array($noSo));
        if (count($headers) !== 1) { throw new DomainException('SO tidak ditemukan.'); }
        $invoices = $this->query('SELECT no_invoice FROM tr_invoice WHERE no_so=? AND deleted_by IS NULL LIMIT 1', array($noSo));
        $shipped = $this->query("SELECT id_do_detail FROM tr_delivery_order_detail d JOIN tr_delivery_order h ON h.no_do=d.no_do WHERE d.no_so=? AND h.status_confirm='1' AND d.status_kirim='1' LIMIT 1", array($noSo));
        if ($invoices || $shipped) { throw new DomainException('SO sudah memiliki invoice/pengiriman. Selesaikan pembalikan dokumen sebelum pembatalan penuh.'); }
        $allocations = $this->query('SELECT a.* FROM stock_booking_allocations a JOIN tr_sales_order_detail d ON d.id_so_detail=a.id_so_detail WHERE d.no_so=? ORDER BY a.stock_table,a.id_stock,a.id FOR UPDATE', array($noSo));
        foreach ($allocations as $a) {
            $qty = (int)$a['qty_reserved'];
            if ($qty === 0) { continue; }
            $stock = $this->stock($a['stock_table'], $a['id_stock']);
            // Cancel never fails on a booking/ledger mismatch: booking is clamped at 0 (Stock_booking_rules::release), never negative.
            $after = Stock_booking_rules::release($stock['qty'], $stock['qty_book'], $stock['qty_free'], $qty);
            $this->writeStock($a['stock_table'], $stock, $after, 'batal sales order', $noSo, $headers[0]['no_surat']);
            $this->query('UPDATE stock_booking_allocations SET qty_reserved=0,qty_released=qty_released+?,updated_on=NOW() WHERE id=?', array($qty, $a['id']));
        }
    }

    public function cancelSo($noSo)
    {
        $this->ready();
        $rows=$this->query('SELECT * FROM tr_sales_order WHERE no_so=? FOR UPDATE',array($noSo));
        if(count($rows)!==1){throw new DomainException('SO tidak unik atau tidak ditemukan.');}
        if($rows[0]['deleted_by']!==null){return;}
        $pending=$this->query("SELECT d.id_do_detail FROM tr_delivery_order_detail d JOIN tr_delivery_order h ON h.no_do=d.no_do WHERE d.no_so=? AND COALESCE(h.status_confirm,'0') NOT IN ('1','R') LIMIT 1",array($noSo));
        if($pending){throw new DomainException('Selesaikan pembatalan DO yang belum dikonfirmasi sebelum membatalkan SO.');}
        $this->releaseSo($noSo);
        $this->operation('cancel-so:'.$noSo,'cancel-so',array('actor'=>$this->actor,'no_surat'=>$rows[0]['no_surat']));
        $this->query('UPDATE tr_sales_order SET deleted_by=?,deleted_date=NOW() WHERE no_so=?',array($this->actor,$noSo));
        $other=$this->query('SELECT no_so FROM tr_sales_order WHERE no_penawaran=? AND deleted_by IS NULL AND status>0 AND no_so<>? LIMIT 1 FOR UPDATE',array($rows[0]['no_penawaran'],$noSo));
        if(!$other){$this->query("UPDATE tr_penawaran SET status=4,status_so=0,modified_by=?,modified_on=NOW() WHERE no_penawaran=?",array($this->actor,$rows[0]['no_penawaran']));}
    }

    public function cancelPlanning($noPlanning)
    {
        $this->ready();
        $headers=$this->query('SELECT no_planning FROM tr_planning_delivery WHERE no_planning=? FOR UPDATE',array($noPlanning));
        if(count($headers)!==1){throw new DomainException('Planning tidak unik atau tidak ditemukan.');}
        if($this->query('SELECT no_spk FROM tr_spk_delivery WHERE no_planning=? LIMIT 1 FOR UPDATE',array($noPlanning))){throw new DomainException('Planning sudah memiliki SPK. Selesaikan dokumen turunannya terlebih dahulu.');}
        $details=$this->query('SELECT id_so_detail,qty_delivery FROM tr_planning_delivery_detail WHERE no_planning=? FOR UPDATE',array($noPlanning));
        foreach($details as $detail){
            $this->assertDetailAvailable($detail['id_so_detail']);
            $qty=Stock_booking_rules::quantity($detail['qty_delivery']);
            $this->query('UPDATE tr_sales_order_detail SET qty_delivery=GREATEST(0,COALESCE(qty_delivery,0)-?) WHERE id_so_detail=?',array($qty,$detail['id_so_detail']));
        }
    }

    public function confirmDelivery($noDo, $statuses, $upload = null)
    {
        $this->ready();
        ksort($statuses, SORT_NUMERIC);
        $headers = $this->query('SELECT * FROM tr_delivery_order WHERE no_do=? FOR UPDATE', array($noDo));
        if (count($headers) !== 1) { throw new DomainException('DO tidak ditemukan atau tidak unik.'); }
        if ($headers[0]['status_confirm']==='R') { throw new DomainException('DO sudah dibalik. Gunakan DO baru untuk pengiriman ulang.'); }
        $details = $this->query('SELECT * FROM tr_delivery_order_detail WHERE no_do=? ORDER BY id_do_detail FOR UPDATE', array($noDo));
        $ids = array_map('strval', array_column($details, 'id_do_detail'));
        $submitted = array_map('strval', array_keys($statuses));
        sort($ids); sort($submitted);
        if ($ids !== $submitted) { throw new DomainException('Konfirmasi harus memuat seluruh detail DO yang benar.'); }
        foreach ($statuses as $status) { if (!in_array($status, array('0','1'), true)) { throw new DomainException('Status kirim tidak valid.'); } }
        $payload = $statuses;
        if ($headers[0]['status_confirm'] === '1') {
            foreach ($details as $d) { if ($statuses[$d['id_do_detail']] !== $d['status_kirim']) { throw new DomainException('DO sudah dikonfirmasi. Gunakan transaksi pembalik.'); } }
            return;
        }
        if (!$this->operation('confirm-do:' . $noDo, 'confirm-do', $payload)) { return; }
        $cost = 0;
        foreach ($details as $detail) {
            $this->assertDetailAvailable($detail['id_so_detail']);
            $status = $statuses[$detail['id_do_detail']];
            $qty = Stock_booking_rules::quantity($detail['qty_do']);
            if ($qty === 0) { throw new DomainException('Qty DO harus lebih dari nol.'); }
            if ($status === '1') {
                $allocations = $this->query('SELECT * FROM stock_booking_allocations WHERE id_so_detail=? AND qty_reserved>0 ORDER BY id FOR UPDATE', array($detail['id_so_detail']));
                if (count($allocations) !== 1 || (int)$allocations[0]['qty_reserved'] < $qty) { throw new DomainException('Sisa booking detail SO tidak cukup untuk pengiriman.'); }
                $a = $allocations[0];
                if ((int)$a['qty_consumed']+$qty > (int)$a['ordered_qty']) { throw new DomainException('Total pengiriman melebihi Qty SO.'); }
                $soDetail = $this->query('SELECT no_so,id_category3 FROM tr_sales_order_detail WHERE id_so_detail=? FOR UPDATE',array($a['id_so_detail']));
                if (count($soDetail)!==1 || $soDetail[0]['no_so']!==$detail['no_so'] || $soDetail[0]['id_category3']!==$detail['id_category3']) { throw new DomainException('Referensi detail SO pada DO tidak sesuai.'); }
                $stock = $this->stock($a['stock_table'], $a['id_stock']);
                if ($stock['id_category3'] !== $detail['id_category3']) { throw new DomainException('Barang DO berbeda dengan alokasi SO.'); }
                $this->assertLedger($a['stock_table'], $stock);
                $after = Stock_booking_rules::reconcile((int)$stock['qty']-$qty, (int)$stock['qty_book']-$qty);
                $this->writeStock($a['stock_table'], $stock, $after, 'delivery order', $noDo, $headers[0]['no_surat'],array('cost_book'=>$detail['cost_book']));
                $this->query('UPDATE stock_booking_allocations SET qty_reserved=qty_reserved-?,qty_consumed=qty_consumed+?,updated_on=NOW() WHERE id=?', array($qty,$qty,$a['id']));
                $cost += (float)$detail['cost_book']*$qty;
            } else {
                // Failed delivery releases its schedule, while the SO reservation remains intact.
                $this->query('UPDATE tr_sales_order_detail SET qty_delivery=GREATEST(0,COALESCE(qty_delivery,0)-?),qty_spk=GREATEST(0,COALESCE(qty_spk,0)-?) WHERE id_so_detail=?',array($qty,$qty,$detail['id_so_detail']));
                if (!empty($detail['id_planning_delivery'])) {
                    $this->query('UPDATE tr_planning_delivery_detail SET qty_delivery=GREATEST(0,COALESCE(qty_delivery,0)-?),qty_spk=GREATEST(0,COALESCE(qty_spk,0)-?) WHERE id_planning_delivery=?',array($qty,$qty,$detail['id_planning_delivery']));
                }
            }
            $this->query('UPDATE tr_delivery_order_detail SET status_kirim=?,modified_on=NOW(),confirm_costbook=? WHERE id_do_detail=?', array($status,$status==='1' ? (float)$detail['cost_book']*$qty : 0,$detail['id_do_detail']));
        }
        $this->query("UPDATE tr_delivery_order SET status_confirm='1',confirm_costbook=?,upload_sj=COALESCE(?,upload_sj) WHERE no_do=?", array($cost,$upload,$noDo));
        foreach (array_unique(array_column($details,'no_so')) as $noSo) {
            $totals=$this->query("SELECT COALESCE(SUM(d.qty_do),0) qty,COALESCE(SUM(d.qty_do*d.cost_book),0) cost FROM tr_delivery_order_detail d JOIN tr_delivery_order h ON h.no_do=d.no_do WHERE d.no_so=? AND h.status_confirm='1' AND d.status_kirim='1'",array($noSo))[0];
            $ordered=$this->query('SELECT COALESCE(SUM(qty_so),0) qty FROM tr_sales_order_detail WHERE no_so=?',array($noSo))[0];
            $percent=(int)$ordered['qty']>0 ? 100*(int)$totals['qty']/(int)$ordered['qty'] : 0;
            $this->query('UPDATE tr_sales_order SET total_dikirim=?,total_hpp=?,percent_do=? WHERE no_so=?',array($totals['qty'],$totals['cost'],$percent,$noSo));
        }
    }

    public function validatePlanning($post)
    {
        $this->ready(); $seen=array();
        if (empty($post['id_so_detail']) || !is_array($post['id_so_detail'])) { throw new DomainException('Detail planning kosong.'); }
        foreach ($post['id_so_detail'] as $index=>$id) {
            $this->assertDetailAvailable($id);
            if (isset($seen[$id])) { throw new DomainException('Detail planning duplikat.'); }
            $seen[$id]=true;
            $qty=Stock_booking_rules::quantity($post['qty_delivery'][$index] ?? null);
            $rows=$this->query('SELECT * FROM tr_sales_order_detail WHERE id_so_detail=? AND no_so=? FOR UPDATE',array($id,$post['no_so']??''));
            if (count($rows)!==1 || !$qty) { throw new DomainException('Detail/Qty planning tidak valid.'); }
            $a=$this->query('SELECT COALESCE(SUM(qty_reserved),0) qty FROM stock_booking_allocations WHERE id_so_detail=? FOR UPDATE',array($id));
            $delivered=$this->query("SELECT COALESCE(SUM(d.qty_do),0) qty FROM tr_delivery_order_detail d JOIN tr_delivery_order h ON h.no_do=d.no_do WHERE d.id_so_detail=? AND d.status_kirim='1' AND h.status_confirm='1'",array($id));
            $pending=max(0,(int)$rows[0]['qty_delivery']-(int)$delivered[0]['qty']);
            if ($qty+$pending>(int)$a[0]['qty']) { throw new DomainException('Planning melebihi sisa booking yang belum dijadwalkan.'); }
        }
    }

    public function validateDeliveryDraft($post)
    {
        $this->ready(); $seen=array();
        if (empty($post['dt']) || !is_array($post['dt'])) { throw new DomainException('Detail DO kosong.'); }
        foreach ($post['dt'] as $d) {
            if (empty($d['kirim'])) { continue; }
            $id=$d['id_so']??null;
            $this->assertDetailAvailable($id);
            if (isset($seen[$id])) { throw new DomainException('Detail SO pada DO duplikat.'); }
            $seen[$id]=true;
            $qty=Stock_booking_rules::quantity($d['qty_delivery']??null);
            $rows=$this->query('SELECT * FROM tr_sales_order_detail WHERE id_so_detail=? AND no_so=? AND id_category3=? FOR UPDATE',array($id,$d['no_so']??'',$d['id_category3']??''));
            if (count($rows)!==1 || !$qty) { throw new DomainException('Referensi/Qty DO tidak valid.'); }
            $a=$this->query('SELECT COALESCE(SUM(qty_reserved),0) qty FROM stock_booking_allocations WHERE id_so_detail=? FOR UPDATE',array($id));
            $pending=$this->query("SELECT COALESCE(SUM(d.qty_do),0) qty FROM tr_delivery_order_detail d JOIN tr_delivery_order h ON h.no_do=d.no_do WHERE d.id_so_detail=? AND COALESCE(h.status_confirm,'0') NOT IN ('1','R')",array($id));
            if ($qty+(int)$pending[0]['qty']>(int)$a[0]['qty']) { throw new DomainException('DO melebihi sisa alokasi booking.'); }
            $spk=$this->query('SELECT * FROM tr_spk_delivery_detail WHERE id_spk_detail=? FOR UPDATE',array($d['id_spk']??''));
            if (count($spk)!==1 || $spk[0]['status_do']==='1') { throw new DomainException('Detail SPK sudah dibuatkan DO atau tidak ditemukan.'); }
            if($spk[0]['id_so_detail']!=$id || $spk[0]['no_so']!==$d['no_so'] || $spk[0]['id_category3']!==$d['id_category3'] || $qty>(int)$spk[0]['qty_delivery']){throw new DomainException('Barang/Qty DO tidak sesuai detail SPK.');}
            if($this->query('SELECT id_do_detail FROM tr_delivery_order_detail WHERE id_spk_detail=? LIMIT 1',array($d['id_spk']))){throw new DomainException('Detail SPK sudah digunakan pada DO.');}
        }
        if (!$seen) { throw new DomainException('Tidak ada barang dipilih untuk DO.'); }
    }

    public function validateSpk($post)
    {
        $this->ready();$seen=array();
        if(empty($post['dt']) || !is_array($post['dt'])){throw new DomainException('Detail SPK kosong.');}
        foreach($post['dt'] as $d){
            if(empty($d['kirim'])){continue;}
            $id=$d['id_so']??null;
            $this->assertDetailAvailable($id);
            if(isset($seen[$id])){throw new DomainException('Detail SPK duplikat.');}$seen[$id]=true;
            $qty=Stock_booking_rules::quantity($d['qty_delivery']??null);
            $details=$this->query('SELECT * FROM tr_sales_order_detail WHERE id_so_detail=? AND no_so=? AND id_category3=? FOR UPDATE',array($id,$d['no_so']??'',$d['id_category3']??''));
            if(count($details)!==1 || !$qty){throw new DomainException('Referensi/Qty SPK tidak valid.');}
            $a=$this->query('SELECT COALESCE(SUM(qty_reserved),0) qty FROM stock_booking_allocations WHERE id_so_detail=? FOR UPDATE',array($id));
            $delivered=$this->query("SELECT COALESCE(SUM(d.qty_do),0) qty FROM tr_delivery_order_detail d JOIN tr_delivery_order h ON h.no_do=d.no_do WHERE d.id_so_detail=? AND d.status_kirim='1' AND h.status_confirm='1'",array($id));
            $pending=max(0,(int)$details[0]['qty_spk']-(int)$delivered[0]['qty']);
            if($qty+$pending>(int)$a[0]['qty']){throw new DomainException('SPK melebihi sisa alokasi booking.');}
            if(!empty($d['id_planning_delivery'])){
                $planning=$this->query('SELECT qty_delivery,qty_spk FROM tr_planning_delivery_detail WHERE id_planning_delivery=? AND id_so_detail=? FOR UPDATE',array($d['id_planning_delivery'],$id));
                if(count($planning)!==1 || $qty+(int)$planning[0]['qty_spk']>(int)$planning[0]['qty_delivery']){throw new DomainException('SPK melebihi Qty planning.');}
            }
        }
        if(!$seen){throw new DomainException('Tidak ada barang dipilih untuk SPK.');}
    }

    public function reverseDelivery($noDo, $reason)
    {
        $this->ready();
        if (trim($reason)==='') { throw new DomainException('Alasan pembalikan wajib diisi.'); }
        $headers=$this->query('SELECT * FROM tr_delivery_order WHERE no_do=? FOR UPDATE',array($noDo));
        if (count($headers)!==1) { throw new DomainException('DO tidak unik atau tidak ditemukan.'); }
        $header=$headers[0];
        if ($header['status_confirm']==='R') { return; }
        if ($header['status_confirm']!=='1' || !$this->query('SELECT operation_key FROM stock_booking_operations WHERE operation_key=?',array('confirm-do:'.$noDo))) { throw new DomainException('Pembalikan otomatis hanya untuk DO yang dikonfirmasi melalui layanan booking baru.'); }
        if (($header['status_jurnal_do']??'0')==='1' || ($header['status_jurnal_confirm']??'0')==='1') { throw new DomainException('Selesaikan pembalikan jurnal sebelum membalik stok DO.'); }
        if (!$this->operation('reverse-do:'.$noDo,'reverse-do',array('reason'=>$reason))) { return; }
        $details=$this->query('SELECT * FROM tr_delivery_order_detail WHERE no_do=? ORDER BY id_do_detail FOR UPDATE',array($noDo));
        foreach($details as $d){
            if($d['status_kirim']!=='1'){continue;}
            $qty=Stock_booking_rules::quantity($d['qty_do']);
            $rows=$this->query('SELECT * FROM stock_booking_allocations WHERE id_so_detail=? FOR UPDATE',array($d['id_so_detail']));
            if(count($rows)!==1 || (int)$rows[0]['qty_consumed']<$qty){throw new DomainException('Alokasi pengiriman tidak dapat dibalik.');}
            $a=$rows[0];$stock=$this->stock($a['stock_table'],$a['id_stock']);
            $this->assertLedger($a['stock_table'],$stock);
            $after=Stock_booking_rules::reconcile((int)$stock['qty']+$qty,(int)$stock['qty_book']+$qty);
            $this->writeStock($a['stock_table'],$stock,$after,'reverse delivery order',$noDo,$header['no_surat'],array('cost_book'=>$d['cost_book']));
            $this->query('UPDATE stock_booking_allocations SET qty_reserved=qty_reserved+?,qty_consumed=qty_consumed-?,updated_on=NOW() WHERE id=?',array($qty,$qty,$a['id']));
            $this->query('UPDATE tr_sales_order_detail SET qty_delivery=GREATEST(0,COALESCE(qty_delivery,0)-?),qty_spk=GREATEST(0,COALESCE(qty_spk,0)-?) WHERE id_so_detail=?',array($qty,$qty,$d['id_so_detail']));
        }
        $this->query("UPDATE tr_delivery_order SET status_confirm='R',confirm_costbook=0 WHERE no_do=?",array($noDo));
        foreach(array_unique(array_column($details,'no_so')) as $noSo){
            $totals=$this->query("SELECT COALESCE(SUM(d.qty_do),0) qty,COALESCE(SUM(d.qty_do*d.cost_book),0) cost FROM tr_delivery_order_detail d JOIN tr_delivery_order h ON h.no_do=d.no_do WHERE d.no_so=? AND h.status_confirm='1' AND d.status_kirim='1'",array($noSo))[0];
            $ordered=$this->query('SELECT COALESCE(SUM(qty_so),0) qty FROM tr_sales_order_detail WHERE no_so=?',array($noSo))[0];
            $percent=(int)$ordered['qty']>0 ? 100*(int)$totals['qty']/(int)$ordered['qty'] : 0;
            $this->query('UPDATE tr_sales_order SET total_dikirim=?,total_hpp=?,percent_do=? WHERE no_so=?',array($totals['qty'],$totals['cost'],$percent,$noSo));
        }
    }

    public function adjustment($post, $code, $mainOnly = true)
    {
        $this->ready();
        if (!is_array($post)) { throw new DomainException('Data adjustment tidak valid.'); }
        foreach (array('id_material','id_stock','adjustment','note','request_key') as $field) {
            if (!isset($post[$field]) || !is_string($post[$field]) || trim($post[$field]) === '') {
                throw new DomainException('Data adjustment tidak lengkap. Muat ulang formulir.');
            }
        }
        $type = $post['adjustment'];
        $qty = Stock_booking_rules::quantity($post['total_qty'] ?? null);
        $note = trim($post['note']);
        if (!in_array($type, $mainOnly ? array('PLUS','MINUS') : array('PLUS','MINUS','MUTASI'), true)
            || !$qty || $qty > 2147483647 || !preg_match('/^[a-f0-9]{32}$/D', $post['request_key'])
            || !preg_match('//u', $note) || mb_strlen($note, 'UTF-8') > 255) {
            throw new DomainException('Jenis, jumlah, alasan, atau token adjustment tidak valid.');
        }
        $warehouse = $post['gudang'] ?? ($mainOnly ? '1' : null);
        if (!is_string($warehouse) || !preg_match('/^[1-9][0-9]*$/D', $warehouse)
            || ($mainOnly && $warehouse !== '1') || (!$mainOnly && $type !== 'MUTASI' && $warehouse === '1')) {
            throw new DomainException('Gudang adjustment tidak valid.');
        }
        $warehouses = $this->query('SELECT * FROM ms_gudang WHERE id_gudang=?', array($warehouse));
        $materials = $this->query('SELECT * FROM ms_inventory_category3 WHERE id_category3=? AND COALESCE(deleted,0)=0', array($post['id_material']));
        if (count($warehouses) !== 1 || count($materials) !== 1) { throw new DomainException('Material atau gudang tidak ditemukan.'); }
        $table = $warehouse === '1' ? 'stock_material' : 'stock_material_multigudang';
        $stock = $this->findStock($post['id_material'], $warehouse, $table);
        if ((string)$stock['id_stock'] !== $post['id_stock'] || ($stock['aktif'] ?? '') === 'N') {
            throw new DomainException('Stok tidak sesuai material/gudang atau sudah tidak aktif.');
        }
        $this->assertLedger($table, $stock);
        if ($stock['qty'] > 2147483647) { throw new DomainException('Saldo stok melebihi kapasitas riwayat adjustment.'); }
        $destination = null;
        if ($type === 'MUTASI') {
            $target = $post['id_gudang_baru'] ?? null;
            if (!is_string($target) || !preg_match('/^[1-9][0-9]*$/D', $target) || $target === $warehouse) {
                throw new DomainException('Gudang tujuan harus valid dan berbeda dari gudang asal.');
            }
            $destinations = $this->query('SELECT * FROM ms_gudang WHERE id_gudang=?', array($target));
            if (count($destinations) !== 1) { throw new DomainException('Gudang tujuan tidak ditemukan.'); }
            $destination = $destinations[0];
        }
        if (!$this->operation('adjustment:' . $post['request_key'], 'adjustment', array($post['id_material'],$post['id_stock'],$warehouse,$type,$qty,$note,$destination))) {
            throw new DomainException('Permintaan adjustment sudah diproses. Periksa riwayat.');
        }
        $this->changeActual($stock['id_category3'], $qty, $code, $code, $type === 'PLUS' ? 'in' : 'out', $warehouse, $table);
        if ($destination) {
            $targetTable = $target === '1' ? 'stock_material' : 'stock_material_multigudang';
            $existing = $this->query("SELECT id_stock FROM $targetTable WHERE id_category3=? AND id_gudang=? AND COALESCE(deleted,0)=0 FOR UPDATE", array($stock['id_category3'],$target));
            if (!$existing) {
                if ($this->query("SELECT id_stock FROM stock_booking_quarantine WHERE stock_table=? AND id_category3=? AND id_gudang=? AND status='active'", array($targetTable,$stock['id_category3'],$target))) {
                    throw new DomainException('Stok tujuan dikarantina sampai rekonsiliasi selesai.');
                }
                $this->query("INSERT INTO $targetTable (id_category3,nama_material,id_gudang,qty,qty_book,qty_free,booking,aktif,deleted,lotno,id_bentuk,length,width,thickness,created_on,created_by) VALUES (?,?,?,0,0,0,0,'Y',0,?,?,?,?,?,NOW(),?)", array(
                    $stock['id_category3'],$materials[0]['nama'],$target,$stock['lotno'] ?? null,$stock['id_bentuk'] ?? $materials[0]['id_bentuk'] ?? null,
                    $stock['length'] ?? null,$stock['width'] ?? null,$stock['thickness'] ?? null,$this->actor
                ));
            }
            $targetStock = $this->findStock($stock['id_category3'], $target, $targetTable);
            if (($targetStock['aktif'] ?? '') === 'N') { throw new DomainException('Stok tujuan tidak aktif.'); }
            $this->changeActual($stock['id_category3'], $qty, $code, $code, 'in', $target, $targetTable);
        }
        $this->query('INSERT INTO adjustment_stock (id_transaksi,id_material,nama_material,adjustment,id_stock,lotno,id_bentuk,mother_qty,total_qty,id_gudang,nama_gudang,id_gudang_baru,nama_gudang_baru,length,width,thickness,note,tanggal_transaksi,user) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,CURDATE(),?)', array(
            $code,$stock['id_category3'],$materials[0]['nama'],$type,$stock['id_stock'],$stock['lotno'] ?? null,$stock['id_bentuk'] ?? $materials[0]['id_bentuk'] ?? null,
            $stock['qty'],$qty,$warehouse,$warehouses[0]['nama_gudang'],$destination ? $target : null,$destination['nama_gudang'] ?? null,
            $stock['length'] ?? null,$stock['width'] ?? null,$stock['thickness'] ?? null,$note,$this->actor
        ));
    }

    public function changeActual($material, $quantity, $reference, $number, $direction, $warehouse = '1', $table = 'stock_material', $cost = array())
    {
        $this->ready();
        $quantity = Stock_booking_rules::quantity($quantity);
        if (!$quantity) { throw new DomainException('Qty mutasi harus lebih dari nol.'); }
        if (!in_array($direction, array('in','out'), true)) { throw new DomainException('Arah mutasi tidak valid.'); }
        $stock = $this->findStock($material, $warehouse, $table);
        $this->assertLedger($table, $stock);
        $key = hash('sha256', json_encode(array($table,$stock['id_stock'],$reference,$direction)));
        if (!$this->operation('actual:' . $key, 'actual', array($quantity,$number))) { return false; }
        $after = Stock_booking_rules::reconcile((int)$stock['qty']+($direction==='in' ? $quantity : -$quantity), $stock['qty_book']);
        $this->writeStock($table, $stock, $after, 'stock ' . $direction, $reference, $number, $cost);
        return true;
    }
}
