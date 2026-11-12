<?php
require_once __DIR__.'/stock_booking_cleansing_test.php';
require_once dirname(__DIR__).'/scripts/stock_booking_connection.php';
require_once dirname(__DIR__).'/application/libraries/Stock_booking_schema.php';
require_once dirname(__DIR__).'/application/libraries/Stock_booking_store.php';
$m=stock_booking_connection();$s=new Stock_booking_store($m,'test');
foreach(array('stock_material','stock_material_multigudang','kartu_stok','kartu_stok_multigudang') as $table){$ddl=$m->query("SHOW CREATE TABLE $table")->fetch_row()[1];$m->query(preg_replace('/^CREATE TABLE /','CREATE TEMPORARY TABLE ',$ddl));}
foreach(Stock_booking_schema::statements() as $sql){$m->query(str_replace('CREATE TABLE IF NOT EXISTS','CREATE TEMPORARY TABLE',$sql));}
foreach($snapshot['stocks'] as &$stock){$stock['aktif']='Y';}unset($stock);
$snapshot['stocks'][0]['qty']=-1;$snapshot['stocks'][20]['qty']=3;
foreach($snapshot['stocks'] as $stock){$s->query('INSERT INTO stock_material (id_stock,id_category3,id_gudang,qty,qty_book,qty_free,deleted,aktif) VALUES (?,?,?,?,?,?,?,?)',array($stock['id_stock'],$stock['id_category3'],$stock['id_gudang'],$stock['qty'],$stock['qty_book'],$stock['qty_free'],0,'Y'));}
$plan=Stock_booking_cleansing::plan($source,$snapshot,true);$batch=str_repeat('b',64);
$s->query('UPDATE stock_booking_control SET maintenance=1 WHERE id=1');
$m->begin_transaction();Stock_booking_cleansing::apply($s,$source,$snapshot,$plan,$batch);$m->rollback();
verify(!$s->query('SELECT * FROM stock_booking_batches'),'Rollback left an applied batch');
verify(!$s->query('SELECT * FROM stock_booking_quarantine'),'Rollback left quarantine markers');
verify((int)$s->query('SELECT maintenance FROM stock_booking_control')[0]['maintenance']===1,'Rollback incorrectly reopened maintenance');
$m->begin_transaction();Stock_booking_cleansing::apply($s,$source,$snapshot,$plan,$batch);$m->commit();
verify(count($s->query("SELECT * FROM stock_booking_quarantine WHERE status='active'"))===2,'Partial apply lost quarantine records');
verify((int)$s->query('SELECT SUM(qty_reserved) qty FROM stock_booking_allocations')[0]['qty']===61,'Partial apply changed approved booking quantity');
verify((int)$s->query('SELECT maintenance FROM stock_booking_control')[0]['maintenance']===0,'Successful partial apply left maintenance on');
foreach($snapshot['stocks'] as $stock){
    $row=$s->query('SELECT qty,qty_book,qty_free,aktif FROM stock_material WHERE id_stock=?',array($stock['id_stock']))[0];
    if(in_array($stock['id_stock'],array(1,21),true)){
        verify($row['aktif']==='N' && (int)$row['qty']===$stock['qty'] && (int)$row['qty_book']===$stock['qty_book'] && (int)$row['qty_free']===$stock['qty_free'],'Quarantine altered original quantities');
        try{$s->stock('stock_material',$stock['id_stock']);throw new RuntimeException('Quarantine did not block service access');}catch(DomainException $e){verify(true,'Quarantine rejected');}
    }else{
        verify((int)$row['qty']===$stock['qty'] && (int)$row['qty']-(int)$row['qty_book']===(int)$row['qty_free'],'Healthy stock did not reconcile');
    }
}
$m->begin_transaction();
try{Stock_booking_cleansing::apply($s,$source,$snapshot,$plan,$batch);throw new RuntimeException('Batch replay was accepted');}catch(DomainException $e){verify(true,'Replay rejected');}finally{$m->rollback();}
echo "PASS: partial cleansing/rollback/quarantine checks completed ($count total with planner cases)\n";
