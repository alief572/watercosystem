<?php
require_once dirname(__DIR__) . '/application/libraries/Stock_booking_cleansing.php';
$source=array('source_sha256'=>str_repeat('a',64),'cutoff'=>'2026-10-20 10:00:00','quantity_policy'=>'fixed_excel','rows'=>array());
$snapshot=array('stocks'=>array(),'details'=>array(),'deliveries'=>array(),'cards'=>array());
for($i=1;$i<=21;++$i){
    $qty=$i===21?37:1;
    $source['rows'][]=array('excel_row'=>$i+4,'so_number'=>'SO'.($i%9),'item_code'=>'CODE'.$i,'item_name'=>'Name'.$i,'qty'=>$qty);
    $snapshot['stocks'][]=array('stock_table'=>'stock_material','id_stock'=>$i,'id_category3'=>'MAT'.$i,'id_gudang'=>'1','qty'=>100,'qty_book'=>0,'qty_free'=>100,'deleted'=>0);
    $snapshot['details'][]=array('id_so_detail'=>$i,'no_so'=>'SO'.($i%9),'no_surat'=>'SO'.($i%9),'id_category3'=>'MAT'.$i,'kode_barang'=>'CODE'.$i,'nama_produk'=>'Name'.$i,'inventory_name'=>'Name'.$i,'qty_so'=>$qty,'status'=>1,'deleted_by'=>null,'order_status'=>'stk','indent_check'=>null,'created_on'=>'2026-10-19 10:00:00');
}
$count=0;
function verify($condition,$message){global $count;++$count;if(!$condition){throw new RuntimeException($message);}}
$source['rows'][0]['item_code']='';
$source['rows'][1]['item_code']=' CODE2 + KIT ';
$snapshot['details'][1]['kode_barang']='CODE2+KIT';
$snapshot['stocks'][0]['qty_book']=-2;$snapshot['stocks'][0]['qty_free']=102;
$snapshot['deliveries'][]=array('id_so_detail'=>1,'qty_do'=>1,'status_confirm'=>'1','status_kirim'=>'1','modified_on'=>'2026-10-22 10:00:00');
$plan=Stock_booking_cleansing::plan($source,$snapshot);
verify(!$plan['issues'],'Exact/name/combined code mapping failed');
verify($plan['target_booking']===57,'Excel quantities changed after a delivery');
verify($plan['changes'][0]['released_positive_booking']===0,'Negative booking created a positive release');
verify($plan['changes'][0]['after']['qty_free']===99,'Free stock did not reconcile to actual minus approved booking');
$d=$snapshot['details'][2];$d['id_so_detail']=22;$d['no_so']='NEW';$d['no_surat']='NEW';$d['created_on']='2026-10-21 10:00:00';$d['qty_so']=4;
$snapshot['details'][]=$d;
$snapshot['deliveries'][]=array('id_so_detail'=>22,'qty_do'=>1,'status_confirm'=>'1','status_kirim'=>'1','modified_on'=>'2026-10-22 10:00:00');
$plan=Stock_booking_cleansing::plan($source,$snapshot);
verify(!$plan['issues'] && $plan['target_booking']===60,'New SO reservation not preserved net of confirmed delivery');
$d['id_so_detail']=23;$d['no_so']='OLD';$d['no_surat']='OLD';$d['created_on']='2026-10-01 10:00:00';$d['qty_so']=2;
$snapshot['details'][]=$d;
$snapshot['cards'][]=array('transaksi'=>'sales order','no_transaksi'=>'OLD','id_category3'=>$d['id_category3'],'qty_book'=>0,'qty_book_akhir'=>2,'created_on'=>'2026-10-21 10:00:00');
$snapshot['deliveries'][]=array('id_so_detail'=>23,'qty_do'=>1,'status_confirm'=>'1','status_kirim'=>'1','modified_on'=>'2026-10-22 10:00:00');
$plan=Stock_booking_cleansing::plan($source,$snapshot);
verify(!$plan['issues'] && $plan['target_booking']===61,'New booking on old SO was lost');
$bad=$snapshot;$bad['stocks'][0]['qty']=-1;
verify(count(Stock_booking_cleansing::plan($source,$bad)['issues'])===1,'Negative actual did not block apply');
$bad=$snapshot;$bad['stocks'][20]['qty']=3;
verify(count(Stock_booking_cleansing::plan($source,$bad)['issues'])===1,'Insufficient actual did not block apply');
$bad=$snapshot;$bad['details'][]=$snapshot['details'][0];
verify((bool)Stock_booking_cleansing::plan($source,$bad)['issues'],'Duplicate master reference was silently accepted');
$bad=$snapshot;unset($bad['details'][0]);
verify((bool)Stock_booking_cleansing::plan($source,$bad)['issues'],'Missing Excel match was silently accepted');
$bad=$snapshot;$bad['stocks'][0]['qty']=-1;$bad['stocks'][20]['qty']=3;
$partial=Stock_booking_cleansing::plan($source,$bad,true);
verify(count($partial['quarantine'])===2 && !$partial['blocking_issues'],'Capacity conflicts were not isolated');
verify($partial['target_booking']===61 && $partial['deferred_booking']===38 && $partial['active_booking']===23,'Approved quantities changed or quarantine contaminated active booking');
verify(!array_filter($partial['changes'],function($c){return in_array($c['before']['id_stock'],array(1,21),true);}), 'Quarantined balances would be modified');
$bad['details'][]=$bad['details'][0];
verify((bool)Stock_booking_cleansing::plan($source,$bad,true)['blocking_issues'],'Quarantine mode bypassed an ambiguous reference');
echo "PASS: $count cleansing cases\n";
