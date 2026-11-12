<?php
require_once __DIR__ . '/Stock_booking_rules.php';

class Stock_booking_cleansing
{
    public static function apply($store, $source, $snapshot, $plan, $batch)
    {
        if($plan['blocking_issues']){throw new DomainException('Ambiguous or unapproved conflicts still block cleansing.');}
        if($store->query('SELECT batch_key FROM stock_booking_batches WHERE batch_key=? FOR UPDATE',array($batch))){throw new DomainException('This source batch was already applied; replay refused.');}
        if($store->query('SELECT id FROM stock_booking_allocations LIMIT 1')){throw new DomainException('Allocations already exist; baseline replacement refused.');}
        foreach($plan['quarantine'] as $q){
            $before=$q['before'];$table=Stock_booking_store::table($before['stock_table']);
            $store->query("INSERT INTO stock_booking_quarantine (stock_table,id_stock,id_category3,id_gudang,batch_key,status,target_booking,before_state,reason,created_on) VALUES (?,?,?,?,?,'active',?,?,?,NOW())",array($table,$before['id_stock'],$before['id_category3'],$before['id_gudang'],$batch,$q['target_booking'],json_encode($before,JSON_THROW_ON_ERROR),$q['reason']));
            $store->query('SET @stock_booking_quarantine_admin=1');
            try{$store->query("UPDATE $table SET aktif='N' WHERE id_stock=?",array($before['id_stock']));}
            finally{$store->query('SET @stock_booking_quarantine_admin=NULL');}
        }
        foreach($plan['allocations'] as $a){
            $store->query('INSERT INTO stock_booking_allocations (id_so_detail,stock_table,id_stock,qty_reserved,qty_consumed,baseline_qty,baseline_consumed,ordered_qty,updated_on) VALUES (?,?,?,?,?,?,?,?,NOW())',array($a['id_so_detail'],$a['stock_table'],$a['id_stock'],$a['qty_reserved'],$a['qty_consumed'],$a['qty_reserved'],$a['qty_consumed'],$a['ordered_qty']));
        }
        foreach($plan['changes'] as $change){$store->writeStock($change['stock_table'],$change['before'],$change['after'],'cleansing stock booking',$batch);}
        self::verify($store,$snapshot);
        $store->query("INSERT INTO stock_booking_batches (batch_key,status,snapshot,max_legacy_detail,created_on) VALUES (?,'applied',?,?,NOW())",array($batch,json_encode(array('source'=>$source,'before'=>$snapshot,'plan'=>$plan),JSON_THROW_ON_ERROR),max(array_column($snapshot['details'],'id_so_detail'))));
        $store->query('UPDATE stock_booking_control SET maintenance=0,updated_on=NOW() WHERE id=1');
    }

    public static function verify($store, $snapshot)
    {
        $before=array();foreach($snapshot['stocks'] as $row){$before[$row['stock_table'].':'.$row['id_stock']]=$row;}
        $checked=0;$quarantined=0;
        foreach(array('stock_material','stock_material_multigudang') as $table){
            $rows=$store->query("SELECT s.id_stock,s.qty,s.qty_book,s.qty_free,s.aktif,COALESCE(a.reserved,0) ledger,q.status quarantine_status
                FROM $table s LEFT JOIN (SELECT id_stock,SUM(qty_reserved) reserved FROM stock_booking_allocations WHERE stock_table=? GROUP BY id_stock) a ON a.id_stock=s.id_stock
                LEFT JOIN stock_booking_quarantine q ON q.stock_table=? AND q.id_stock=s.id_stock AND q.status='active' ORDER BY s.id_stock",array($table,$table));
            foreach($rows as $row){
                $key=$table.':'.$row['id_stock'];$old=$before[$key]??null;
                if(!$old || (string)$row['qty']!==(string)$old['qty']){throw new RuntimeException('Stock identities or Qty Aktual changed during cleansing.');}
                if($row['quarantine_status']==='active'){
                    foreach(array('qty','qty_book','qty_free') as $field){
                        if(($row[$field]===null)!==($old[$field]===null) || (string)$row[$field]!==(string)$old[$field]){throw new RuntimeException('A quarantined quantity changed during cleansing.');}
                    }
                    if($row['aktif']!=='N'){throw new RuntimeException('Quarantined stock was not deactivated.');}++$quarantined;
                }else{
                    $valid=Stock_booking_rules::reconcile($row['qty'],$row['ledger']);
                    if($row['qty_book']===null || $row['qty_free']===null || (int)$row['qty_book']!==$valid['qty_book'] || (int)$row['qty_free']!==$valid['qty_free']){throw new RuntimeException('A healthy stock balance differs from its approved allocations.');}
                }
                ++$checked;
            }
        }
        if($checked!==count($before)){throw new RuntimeException('Stock row count changed during cleansing.');}
        return array('verified_rows'=>$checked,'quarantined_rows'=>$quarantined,'operational_rows'=>$checked-$quarantined);
    }

    private static function normalize($text)
    {
        return strtoupper(preg_replace('/\s+/', '', (string)$text));
    }

    public static function plan($source, $snapshot, $quarantineConflicts = false)
    {
        $issues = array(); $allocations = array(); $mapped = array(); $stocks = array();
        if (($source['cutoff'] ?? '') !== '2026-10-20 10:00:00' || ($source['quantity_policy'] ?? '') !== 'fixed_excel'
            || count($source['rows'] ?? array()) !== 21 || array_sum(array_column($source['rows'], 'qty')) != 57
            || count(array_unique(array_column($source['rows'], 'so_number'))) !== 9) {
            throw new DomainException('Manifest bukan daftar Excel yang disetujui.');
        }
        foreach ($snapshot['stocks'] as $stock) { $stocks[$stock['stock_table'] . ':' . $stock['id_stock']] = $stock; }
        $details = array();
        foreach ($snapshot['details'] as $detail) {
            if (isset($details[(string)$detail['id_so_detail']])) { $issues[]=array('type'=>'duplicate_detail_reference','detail'=>$detail['id_so_detail']); }
            $details[(string)$detail['id_so_detail']] = $detail;
        }
        $confirmed = array();
        foreach ($snapshot['deliveries'] as $delivery) {
            if ($delivery['status_confirm'] === '1' && $delivery['status_kirim'] === '1') {
                $key = (string)$delivery['id_so_detail'];
                $confirmed[$key] = ($confirmed[$key] ?? 0) + Stock_booking_rules::quantity($delivery['qty_do']);
            }
        }
        $assign = function($detail, $qty, $basis) use (&$allocations, &$issues, $stocks, $confirmed) {
            $matches = array_filter($stocks, function($stock) use ($detail) {
                return $stock['stock_table'] === 'stock_material' && $stock['id_category3'] === $detail['id_category3']
                    && $stock['id_gudang'] === '1' && (int)$stock['deleted'] === 0;
            });
            if (count($matches) !== 1) { $issues[] = array('type'=>'ambiguous_stock','detail'=>$detail['id_so_detail'],'material'=>$detail['id_category3']); return; }
            $stock = reset($matches);
            $allocations[] = array('id_so_detail'=>(int)$detail['id_so_detail'],'no_so'=>$detail['no_so'],'so_number'=>$detail['no_surat'],
                'stock_table'=>$stock['stock_table'],'id_stock'=>(int)$stock['id_stock'],'qty_reserved'=>Stock_booking_rules::quantity($qty),
                'qty_consumed'=>$confirmed[$detail['id_so_detail']] ?? 0,'ordered_qty'=>Stock_booking_rules::quantity($detail['qty_so']),'basis'=>$basis);
        };
        foreach ($source['rows'] as $row) {
            $matches = array_filter($details, function($d) use ($row) {
                if (self::normalize($d['no_surat']) !== self::normalize($row['so_number'])) { return false; }
                return $row['item_code'] !== '' ? self::normalize($d['kode_barang']) === self::normalize($row['item_code'])
                    : self::normalize($d['nama_produk']) === self::normalize($row['item_name']) || self::normalize($d['inventory_name']) === self::normalize($row['item_name']);
            });
            if (count($matches) !== 1) { $issues[] = array('type'=>'ambiguous_excel_mapping','excel_row'=>$row['excel_row'],'so'=>$row['so_number'],'code'=>$row['item_code'],'matches'=>count($matches)); continue; }
            $detail = reset($matches);
            if (isset($mapped[$detail['id_so_detail']])) { $issues[] = array('type'=>'duplicate_excel_detail','detail'=>$detail['id_so_detail']); continue; }
            $mapped[$detail['id_so_detail']] = true;
            if ($detail['deleted_by'] !== null || in_array((int)$detail['status'], array(0,5,7), true)) {
                $issues[] = array('type'=>'excel_so_inactive','excel_row'=>$row['excel_row'],'so'=>$row['so_number']);
            }
            $assign($detail, $row['qty'], 'excel row ' . $row['excel_row']);
        }
        $postCards = array();
        foreach ($snapshot['cards'] as $card) {
            if ($card['transaksi'] !== 'sales order') { continue; }
            $key = $card['no_transaksi'] . ':' . $card['id_category3'];
            $postCards[$key][] = $card;
        }
        foreach ($details as $id=>$detail) {
            if (isset($mapped[$id]) || $detail['deleted_by'] !== null || in_array((int)$detail['status'], array(0,5,7), true)) { continue; }
            $cards = $postCards[$detail['no_so'] . ':' . $detail['id_category3']] ?? array();
            $newSo = $detail['created_on'] > $source['cutoff'];
            if (!$newSo && !$cards) { continue; }
            if ($detail['order_status'] === 'ind' && $detail['indent_check'] !== '1') { continue; }
            $remaining = max(0, Stock_booking_rules::quantity($detail['qty_so'])-($confirmed[$id] ?? 0));
            if (!$newSo) {
                $sameItems = array_filter($details, function($d) use ($detail) { return $d['no_so']===$detail['no_so'] && $d['id_category3']===$detail['id_category3']; });
                if (count($cards) !== 1 || count($sameItems) !== 1) { $issues[] = array('type'=>'ambiguous_post_cutoff_booking','detail'=>$id); continue; }
                $card = $cards[0];
                $qty = (int)$card['qty_book_akhir']-(int)$card['qty_book'];
                if ($qty <= 0 || $qty > (int)$detail['qty_so']) { $issues[] = array('type'=>'invalid_post_cutoff_booking','detail'=>$id); continue; }
                $after = 0;
                foreach ($snapshot['deliveries'] as $delivery) {
                    if ($delivery['id_so_detail'] == $id && $delivery['status_confirm']==='1' && $delivery['status_kirim']==='1') {
                        if (!$delivery['modified_on']) { $issues[] = array('type'=>'missing_delivery_confirmation_time','detail'=>$id); }
                        elseif ($delivery['modified_on'] >= $card['created_on']) { $after += (int)$delivery['qty_do']; }
                    }
                }
                $remaining = max(0, $qty-$after);
            }
            $assign($detail, $remaining, 'post-cutoff booking');
        }
        $totals = array();
        foreach ($allocations as $a) { $key=$a['stock_table'].':'.$a['id_stock']; $totals[$key]=($totals[$key]??0)+$a['qty_reserved']; }
        $changes = array();
        foreach ($stocks as $key=>$stock) {
            try { $after=Stock_booking_rules::reconcile($stock['qty'], $totals[$key]??0); }
            catch (DomainException $e) { $issues[]=array('type'=>'stock_capacity_conflict','stock'=>$key,'material'=>$stock['id_category3'],'actual'=>$stock['qty'],'target_booking'=>$totals[$key]??0,'message'=>$e->getMessage()); continue; }
            if ($stock['qty_book']===null || $stock['qty_free']===null || (int)$stock['qty_book']!==$after['qty_book'] || (int)$stock['qty_free']!==$after['qty_free']) {
                $changes[]=array('stock_table'=>$stock['stock_table'],'before'=>$stock,'after'=>$after,
                    'released_positive_booking'=>max(0,max(0,(int)$stock['qty_book'])-$after['qty_book']),
                    'negative_booking_corrected'=>min(0,(int)$stock['qty_book']));
            }
        }
        $quarantine=array(); $blockingIssues=array();
        foreach($issues as $issue){
            if($quarantineConflicts && $issue['type']==='stock_capacity_conflict'){
                $quarantine[$issue['stock']]=array('before'=>$stocks[$issue['stock']],'target_booking'=>$issue['target_booking'],'reason'=>$issue['message']);
            }else{$blockingIssues[]=$issue;}
        }
        $deferred=0;
        foreach($allocations as &$allocation){
            $allocation['quarantined']=isset($quarantine[$allocation['stock_table'].':'.$allocation['id_stock']]);
            if($allocation['quarantined']){$deferred+=$allocation['qty_reserved'];}
        }
        unset($allocation);
        $targetBooking=array_sum(array_column($allocations,'qty_reserved'));
        return array('source_sha256'=>$source['source_sha256'],'snapshot_sha256'=>hash('sha256',json_encode($snapshot)),
            'source_rows'=>21,'source_qty'=>57,'allocations'=>$allocations,'changes'=>$changes,'issues'=>$issues,
            'blocking_issues'=>$blockingIssues,'quarantine'=>array_values($quarantine),'quarantine_mode'=>$quarantineConflicts,
            'stock_rows'=>count($stocks),'target_booking'=>$targetBooking,'active_booking'=>$targetBooking-$deferred,'deferred_booking'=>$deferred);
    }
}
