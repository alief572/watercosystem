<?php
require_once __DIR__ . '/stock_booking_connection.php';
require_once dirname(__DIR__) . '/application/libraries/Stock_booking_store.php';
try{
    $options=getopt('',array('no-do:','reason:','apply'));
    if(empty($options['no-do']) || empty($options['reason'])){throw new RuntimeException('Usage: php scripts/reverse_stock_booking_delivery.php --no-do=INTERNAL_DO --reason="Return/correction reference" [--apply]');}
    $connection=stock_booking_connection();$store=new Stock_booking_store($connection);
    $lock=$store->query("SELECT GET_LOCK('waterco-stock-booking',15) acquired");
    if((int)$lock[0]['acquired']!==1){throw new RuntimeException('Stock transaction lock unavailable.');}
    $connection->begin_transaction();
    $store->reverseDelivery($options['no-do'],$options['reason']);
    if(isset($options['apply'])){$connection->commit();echo "Delivery reversal committed. Use a new DO for redelivery.\n";}
    else{$connection->rollback();echo "Dry-run reversal succeeded; no stock changed.\n";}
}catch(Throwable $e){
    if(isset($connection)){$connection->rollback();}
    fwrite(STDERR,($e instanceof DomainException || $e instanceof RuntimeException?$e->getMessage():'Delivery reversal failed.') . "\n");exit(1);
}finally{
    if(isset($store)){$store->query("SELECT RELEASE_LOCK('waterco-stock-booking')");}
}
