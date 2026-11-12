<?php
require_once __DIR__ . '/stock_booking_connection.php';
require_once dirname(__DIR__) . '/application/libraries/Stock_booking_store.php';
require_once dirname(__DIR__) . '/application/libraries/Stock_booking_schema.php';
require_once dirname(__DIR__) . '/application/libraries/Stock_booking_cleansing.php';

function booking_snapshot($store, $cutoff, $lock)
{
    $snapshot = array('stocks'=>array());
    $suffix = $lock ? ' FOR UPDATE' : '';
    foreach (array('stock_material','stock_material_multigudang') as $table) {
        $rows = $store->query("SELECT '$table' stock_table,id_stock,id_category3,id_gudang,qty,qty_book,qty_free,deleted,aktif FROM $table ORDER BY id_stock" . $suffix);
        $snapshot['stocks'] = array_merge($snapshot['stocks'], $rows);
    }
    $snapshot['details'] = $store->query('SELECT d.id_so_detail,d.no_so,d.id_category3,d.nama_produk,d.qty_so,h.no_surat,h.created_on,h.order_status,h.indent_check,h.status,h.deleted_by,i.kode_barang,i.nama inventory_name FROM tr_sales_order_detail d JOIN tr_sales_order h ON h.no_so=d.no_so LEFT JOIN ms_inventory_category3 i ON i.id_category3=d.id_category3 ORDER BY d.id_so_detail' . $suffix);
    $snapshot['deliveries'] = $store->query('SELECT d.id_do_detail,d.id_so_detail,d.qty_do,d.status_kirim,d.modified_on,h.status_confirm FROM tr_delivery_order_detail d JOIN tr_delivery_order h ON h.no_do=d.no_do ORDER BY d.id_do_detail' . $suffix);
    $snapshot['cards'] = $store->query("SELECT id_kartu_stok,id_category3,transaksi,no_transaksi,qty_book,qty_book_akhir,created_on FROM kartu_stok WHERE created_on>? AND transaksi='sales order' ORDER BY id_kartu_stok" . $suffix, array($cutoff));
    return $snapshot;
}

function booking_report($directory, $plan, $snapshot)
{
    if (!is_dir($directory) && !mkdir($directory, 0700, true)) { throw new RuntimeException('Cannot create report directory.'); }
    foreach (array('report.json'=>$plan,'snapshot.json'=>$snapshot) as $file=>$data) {
        if (file_put_contents($directory . '/' . $file,json_encode($data, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_THROW_ON_ERROR),LOCK_EX)===false) { throw new RuntimeException('Cannot save audit report.'); }
    }
    $f = fopen($directory . '/changes.csv','w');
    if (!$f) { throw new RuntimeException('Cannot save CSV report.'); }
    fputcsv($f,array('table','id_stock','item','warehouse','actual','booking_before','free_before','booking_after','free_after','positive_booking_released','negative_booking_corrected'));
    foreach ($plan['changes'] as $c) { $b=$c['before'];$a=$c['after']; fputcsv($f,array($c['stock_table'],$b['id_stock'],$b['id_category3'],$b['id_gudang'],$b['qty'],$b['qty_book'],$b['qty_free'],$a['qty_book'],$a['qty_free'],$c['released_positive_booking'],$c['negative_booking_corrected'])); }
    fclose($f);
    $f=fopen($directory.'/conflicts.csv','w');
    if(!$f){throw new RuntimeException('Cannot save conflict report.');}
    fputcsv($f,array('type','stock','item','actual','target_booking','message'));
    foreach($plan['issues'] as $issue){fputcsv($f,array($issue['type'],$issue['stock']??'',$issue['material']??'',$issue['actual']??'',$issue['target_booking']??'',$issue['message']??json_encode($issue)));}
    fclose($f);
    $f=fopen($directory.'/allocations.csv','w');
    if(!$f){throw new RuntimeException('Cannot save allocation report.');}
    fputcsv($f,array('so','id_so_detail','stock_table','id_stock','booking','already_delivered','ordered_qty','basis','status'));
    foreach($plan['allocations'] as $a){fputcsv($f,array($a['so_number'],$a['id_so_detail'],$a['stock_table'],$a['id_stock'],$a['qty_reserved'],$a['qty_consumed'],$a['ordered_qty'],$a['basis'],$a['quarantined']?'quarantined':'active'));}
    fclose($f);
    $f=fopen($directory.'/quarantine.csv','w');if(!$f){throw new RuntimeException('Cannot save quarantine report.');}
    fputcsv($f,array('table','id_stock','item','warehouse','actual_unchanged','booking_unchanged','free_unchanged','target_booking_deferred','reason'));
    foreach($plan['quarantine'] as $q){$b=$q['before'];fputcsv($f,array($b['stock_table'],$b['id_stock'],$b['id_category3'],$b['id_gudang'],$b['qty'],$b['qty_book'],$b['qty_free'],$q['target_booking'],$q['reason']));}fclose($f);
    $summary="# Audit stock booking\n\nTarget: 206.84.97.106 / waterco_dev.\n\n";
    $summary.="Daftar Excel: 21 baris, 9 SO, 57 unit. Booking tujuan termasuk SO sah setelah cutoff: ".$plan['target_booking']." unit.\n\n";
    $summary.="Baris stok diperiksa: ".$plan['stock_rows'].". Usulan baris dikoreksi: ".count($plan['changes']).". Konflik: ".count($plan['issues']).".\n\n";
    $summary.="Booking operasional: ".$plan['active_booking'].". Booking disimpan untuk rekonsiliasi: ".$plan['deferred_booking'].". Baris karantina: ".count($plan['quarantine']).".\n\n";
    $summary.=$plan['blocking_issues']?"**Apply diblokir oleh konflik yang belum dapat dipetakan dengan aman.**\n\n":(($plan['status']??'')==='applied'?"**Cleansing sudah diterapkan. Baris karantina dinonaktifkan dan diblokir untuk transaksi; Qty-nya tidak diubah.**\n\n":"Audit siap untuk cleansing bertahap. Qty Aktual dan Qty Excel tidak diubah.\n\n");
    $summary.="| Stok | Kode internal | Aktual | Booking tujuan |\n|---|---|---:|---:|\n";
    foreach($plan['issues'] as $issue){if($issue['type']==='stock_capacity_conflict'){$summary.='| '.$issue['stock'].' | '.$issue['material'].' | '.$issue['actual'].' | '.$issue['target_booking']." |\n";}}
    $summary.="\nSnapshot SHA256: `".$plan['snapshot_sha256']."`.\n\nRincian: changes.csv, conflicts.csv, quarantine.csv, allocations.csv, report.json, snapshot.json.\n";
    if(file_put_contents($directory.'/summary.md',$summary,LOCK_EX)===false){throw new RuntimeException('Cannot save audit summary.');}
}

function booking_verify_guards($store)
{
    foreach(Stock_booking_schema::guards() as $name=>$sql){
        $existing=$store->query('SELECT ACTION_STATEMENT FROM information_schema.TRIGGERS WHERE TRIGGER_SCHEMA=DATABASE() AND TRIGGER_NAME=?',array($name));
        $expected=substr($sql,strpos($sql,' BEGIN')+1);
        if(count($existing)!==1 || strtoupper(preg_replace('/\s+/','',$existing[0]['ACTION_STATEMENT']))!==strtoupper(preg_replace('/\s+/','',$expected))){throw new RuntimeException('A required stock guard is missing or has a different definition.');}
    }
}

$exitCode=0;$committed=false;
try {
    $options=getopt('',array('source:','report:','apply','expected-snapshot:','maintenance','install-schema','quarantine-conflicts','expected-quarantine-count:','backup:'));
    if(empty($options['source']) || empty($options['report'])){throw new RuntimeException('Usage: php scripts/cleanse_stock_booking.php --source=source.json --report=output/stock-booking/audit [--quarantine-conflicts] [--apply --maintenance --expected-snapshot=SHA256 --expected-quarantine-count=11 --backup=backup.sql.gz]');}
    $source=json_decode(file_get_contents($options['source']),true,512,JSON_THROW_ON_ERROR);
    $connection=stock_booking_connection();$store=new Stock_booking_store($connection);
    $apply=isset($options['apply']);$install=isset($options['install-schema']);$quarantine=isset($options['quarantine-conflicts']);
    if($install && $apply){throw new RuntimeException('Install schema and apply in separate maintenance steps.');}
    if(($apply || $install) && (!isset($options['maintenance']) || empty($options['expected-snapshot']) || empty($options['backup']))){throw new RuntimeException('Mutation requires --maintenance, --expected-snapshot and --backup.');}
    if(($apply || $install) && $quarantine && !isset($options['expected-quarantine-count'])){throw new RuntimeException('Quarantine apply requires the reviewed --expected-quarantine-count.');}
    if($apply || $install){
        $backup=$options['backup'];
        $manifest=json_decode(file_get_contents($backup.'.json'),true,512,JSON_THROW_ON_ERROR);
        if(($manifest['database']??'')!==stock_booking_database() || empty($manifest['tables']) || !is_file($backup) || !hash_equals($manifest['sha256'],hash_file('sha256',$backup))){throw new RuntimeException('Complete verified database backup is required.');}
        $source['backup']=array('path'=>$backup,'sha256'=>$manifest['sha256']);
    }
    $engines=$store->query("SELECT TABLE_NAME,ENGINE FROM information_schema.TABLES WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME IN ('stock_material','stock_material_multigudang','kartu_stok','kartu_stok_multigudang','tr_sales_order','tr_sales_order_detail','tr_delivery_order','tr_delivery_order_detail')");
    if(count($engines)!==8 || array_filter($engines,function($e){return $e['ENGINE']!=='InnoDB';})){throw new RuntimeException('All source and stock-card tables must use InnoDB.');}
    $lock=$store->query("SELECT GET_LOCK('waterco-stock-booking',15) acquired");
    if((int)$lock[0]['acquired']!==1){throw new RuntimeException('Stock maintenance lock unavailable.');}
    $connection->begin_transaction($apply?0:MYSQLI_TRANS_START_READ_ONLY);
    $snapshot=booking_snapshot($store,$source['cutoff'],$apply);
    $plan=Stock_booking_cleansing::plan($source,$snapshot,$quarantine);
    booking_report($options['report'],$plan,$snapshot);
    echo json_encode(array('mode'=>$apply?'apply':($install?'install-schema':'dry-run'),'stock_rows'=>$plan['stock_rows'],'changed_rows'=>count($plan['changes']),'quarantined_rows'=>count($plan['quarantine']),'blocking_issues'=>count($plan['blocking_issues']),'target_booking'=>$plan['target_booking'],'active_booking'=>$plan['active_booking'],'deferred_booking'=>$plan['deferred_booking'],'snapshot_sha256'=>$plan['snapshot_sha256']),JSON_PRETTY_PRINT),"\n";
    if($plan['blocking_issues']){throw new DomainException('Apply blocked by unresolved mapping/quantity conflicts. No stock changed.');}
    if(($apply || $install) && !hash_equals($options['expected-snapshot'],$plan['snapshot_sha256'])){throw new DomainException('Database changed since dry-run; repeat audit.');}
    if(($apply || $install) && $quarantine && (int)$options['expected-quarantine-count']!==count($plan['quarantine'])){throw new DomainException('Quarantine count changed since review; repeat audit.');}
    if(!$apply){
        $connection->rollback();
        if($install){
            foreach(Stock_booking_schema::statements() as $sql){$connection->query($sql);}
            if($store->query("SELECT batch_key FROM stock_booking_batches WHERE status='applied' LIMIT 1")){throw new DomainException('An applied baseline already exists; refusing maintenance reinstall.');}
            $store->query('UPDATE stock_booking_control SET maintenance=1,updated_on=NOW() WHERE id=1');
            foreach(Stock_booking_schema::guards() as $name=>$sql){
                $exists=$store->query('SELECT TRIGGER_NAME FROM information_schema.TRIGGERS WHERE TRIGGER_SCHEMA=DATABASE() AND TRIGGER_NAME=?',array($name));
                if(!$exists){$connection->query($sql);}
            }
            booking_verify_guards($store);
            echo "Schema/guards installed; database stock maintenance remains ON until baseline apply commits.\n";
        }
    }else{
        booking_verify_guards($store);
        $control=$store->query('SELECT maintenance FROM stock_booking_control WHERE id=1 FOR UPDATE');
        if(count($control)!==1 || (int)$control[0]['maintenance']!==1){throw new RuntimeException('Install guards and enable stock maintenance before applying.');}
        $store->query('SET @stock_booking_maintenance_write=1');
        $batch=hash('sha256',$source['source_sha256'].$source['cutoff']);
        Stock_booking_cleansing::apply($store,$source,$snapshot,$plan,$batch);
        $connection->commit();$committed=true;
        $plan['status']='applied';$plan['batch_key']=$batch;booking_report($options['report'],$plan,$snapshot);
        echo "Applied and verified batch $batch; stock maintenance OFF.\n";
    }
}catch(Throwable $error){
    if(isset($connection) && !$committed){$connection->rollback();}
    $message=$error instanceof DomainException || $error instanceof RuntimeException?$error->getMessage():'Database operation failed; no cleansing committed.';
    if($committed){$message='Database cleansing committed; saving the final report failed. Inspect the batch journal.';}
    fwrite(STDERR,$message."\n");$exitCode=1;
}finally{
    if(isset($store)){$store->query('SET @stock_booking_maintenance_write=NULL, @stock_booking_quarantine_admin=NULL');$store->query("SELECT RELEASE_LOCK('waterco-stock-booking')");}
}
exit($exitCode);
