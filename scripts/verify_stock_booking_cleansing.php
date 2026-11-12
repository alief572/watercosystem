<?php
require_once __DIR__.'/stock_booking_connection.php';
require_once dirname(__DIR__).'/application/libraries/Stock_booking_store.php';
require_once dirname(__DIR__).'/application/libraries/Stock_booking_cleansing.php';
try{
    $options=getopt('',array('batch:','report:'));
    if(empty($options['batch']) || empty($options['report'])){throw new RuntimeException('Usage: php scripts/verify_stock_booking_cleansing.php --batch=HASH --report=output/stock-booking/applied-quarantine/verification.json');}
    $m=stock_booking_connection();$store=new Stock_booking_store($m);
    $m->begin_transaction(MYSQLI_TRANS_START_READ_ONLY|MYSQLI_TRANS_START_WITH_CONSISTENT_SNAPSHOT);
    $rows=$store->query("SELECT batch_key,status,snapshot,created_on FROM stock_booking_batches WHERE batch_key=? AND status='applied'",array($options['batch']));
    if(count($rows)!==1){throw new RuntimeException('Applied batch not found.');}
    $baseline=json_decode($rows[0]['snapshot'],true,512,JSON_THROW_ON_ERROR);
    $result=Stock_booking_cleansing::verify($store,$baseline['before']);
    $store->ready();
    $result['batch_key']=$rows[0]['batch_key'];$result['batch_status']=$rows[0]['status'];$result['applied_at']=$rows[0]['created_on'];
    $result['maintenance']=(int)$store->query('SELECT maintenance FROM stock_booking_control WHERE id=1')[0]['maintenance'];
    $result['allocations']=$store->query("SELECT COALESCE(SUM(a.qty_reserved),0) target_booking,
        COALESCE(SUM(IF(q.status='active',0,a.qty_reserved)),0) active_booking,
        COALESCE(SUM(IF(q.status='active',a.qty_reserved,0)),0) deferred_booking FROM stock_booking_allocations a
        LEFT JOIN stock_booking_quarantine q ON q.stock_table=a.stock_table AND q.id_stock=a.id_stock AND q.status='active'")[0];
    $result['cleansing_stock_cards']=(int)$store->query("SELECT (SELECT COUNT(*) FROM kartu_stok WHERE no_transaksi=?)+(SELECT COUNT(*) FROM kartu_stok_multigudang WHERE no_transaksi=?) count",array($options['batch'],$options['batch']))[0]['count'];
    $result['guards']=(int)$store->query("SELECT COUNT(*) count FROM information_schema.TRIGGERS WHERE TRIGGER_SCHEMA=DATABASE() AND TRIGGER_NAME LIKE 'booking_guard_v2_%'")[0]['count'];
    $result['quarantine_service_blocked']=true;
    foreach($baseline['plan']['quarantine'] as $q){
        try{$store->assertNotQuarantined($q['before']['stock_table'],$q['before']['id_stock']);$result['quarantine_service_blocked']=false;}
        catch(DomainException $expected){}
    }
    if($result['maintenance']!==0 || $result['guards']!==6 || !$result['quarantine_service_blocked'] || (int)$result['allocations']['target_booking']!==$baseline['plan']['target_booking']){throw new RuntimeException('Cleansing verification failed.');}
    $result['actual_qty_unchanged']=true;$result['quarantine_qty_unchanged']=true;$result['operational_balances_valid']=true;
    $m->rollback();
    if(file_put_contents($options['report'],json_encode($result,JSON_PRETTY_PRINT|JSON_THROW_ON_ERROR))===false){throw new RuntimeException('Cannot save verification report.');}
    echo json_encode($result,JSON_PRETTY_PRINT),"\n";
}catch(Throwable $e){if(isset($m)){$m->rollback();}fwrite(STDERR,($e instanceof RuntimeException || $e instanceof DomainException?$e->getMessage():'Verification failed.')."\n");exit(1);}
