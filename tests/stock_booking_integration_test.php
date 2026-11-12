<?php
// All tables below are connection-local TEMPORARY tables; no shared data is changed.
require_once dirname(__DIR__) . '/scripts/stock_booking_connection.php';
require_once dirname(__DIR__) . '/application/libraries/Stock_booking_schema.php';
require_once dirname(__DIR__) . '/application/libraries/Stock_booking_store.php';
$connection=stock_booking_connection();
$definitions=array(
    'stock_material'=>'id_stock INT PRIMARY KEY,id_category3 VARCHAR(40),id_gudang VARCHAR(20),qty INT,qty_book INT,qty_free INT,deleted INT DEFAULT 0',
    'tr_sales_order'=>"no_so VARCHAR(20) PRIMARY KEY,no_surat VARCHAR(100),no_penawaran VARCHAR(20),order_status VARCHAR(10),indent_check CHAR(1),status INT DEFAULT 1,deleted_by VARCHAR(10),deleted_date DATETIME,total_dikirim INT,total_hpp DOUBLE,percent_do DOUBLE",
    'tr_sales_order_detail'=>'id_so_detail INT PRIMARY KEY,no_so VARCHAR(20),id_category3 VARCHAR(40),qty_so INT,qty_delivery INT DEFAULT 0,qty_spk INT DEFAULT 0',
    'tr_delivery_order'=>'no_do VARCHAR(20) PRIMARY KEY,no_surat VARCHAR(100),status_confirm CHAR(1),confirm_costbook DOUBLE,upload_sj VARCHAR(255)',
    'tr_delivery_order_detail'=>"id_do_detail INT PRIMARY KEY,id_so_detail INT,id_spk_detail INT,no_do VARCHAR(20),no_so VARCHAR(20),id_category3 VARCHAR(40),qty_do INT,cost_book DOUBLE,status_kirim CHAR(1) DEFAULT '0',modified_on DATETIME,confirm_costbook DOUBLE",
    'tr_invoice'=>'no_invoice VARCHAR(30),no_so VARCHAR(20),deleted_by VARCHAR(10)',
    'tr_spk_delivery_detail'=>'id_spk_detail INT PRIMARY KEY,id_so_detail INT,no_so VARCHAR(20),id_category3 VARCHAR(40),qty_delivery INT,status_do CHAR(1)',
    'tr_penawaran'=>'no_penawaran VARCHAR(20),status INT,status_so INT,modified_by VARCHAR(20),modified_on DATETIME',
    'tr_planning_delivery'=>'no_planning VARCHAR(20)',
    'tr_planning_delivery_detail'=>'id_planning_delivery INT,id_so_detail INT,no_planning VARCHAR(20),qty_delivery INT,qty_spk INT',
    'tr_spk_delivery'=>'no_planning VARCHAR(20),no_spk VARCHAR(20)',
    'kartu_stok'=>"id_category3 VARCHAR(40),qty INT,qty_book INT,qty_free INT,transaksi VARCHAR(100),tgl_transaksi DATE,no_transaksi VARCHAR(100),id_gudang VARCHAR(20),created_on DATETIME,created_by VARCHAR(50),qty_transaksi INT,qty_akhir INT,qty_book_akhir INT,qty_free_akhir INT,status_transaksi VARCHAR(5),no_surat VARCHAR(100),harga_stok DOUBLE,harga_do DOUBLE,cost_book DOUBLE"
);
foreach ($definitions as $table=>$columns) { $connection->query("CREATE TEMPORARY TABLE $table ($columns) ENGINE=InnoDB"); }
$connection->query('CREATE TEMPORARY TABLE stock_material_multigudang LIKE stock_material');
$connection->query('CREATE TEMPORARY TABLE kartu_stok_multigudang LIKE kartu_stok');
foreach (Stock_booking_schema::statements() as $sql) { $connection->query(str_replace('CREATE TABLE IF NOT EXISTS','CREATE TEMPORARY TABLE',$sql)); }
$s=new Stock_booking_store($connection,'integration-test');
$count=0;
function check($condition,$message) { global $count; ++$count; if (!$condition) { throw new RuntimeException($message); } }
function tx($callback) { global $connection; $connection->begin_transaction(); try { $v=$callback();$connection->commit();return $v; } catch(Throwable $e){$connection->rollback();throw $e;} }
function rejected($callback) { try { tx($callback); } catch(DomainException $e) { check(true,$e->getMessage());return; } throw new RuntimeException('Expected rejection'); }
function balance($qty,$book,$free) { global $s; $r=$s->query('SELECT qty,qty_book,qty_free FROM stock_material WHERE id_stock=1')[0];check(array_map('intval',$r)===array('qty'=>$qty,'qty_book'=>$book,'qty_free'=>$free),'Incorrect stock balance'); }

$s->query("INSERT INTO stock_booking_batches (batch_key,status,snapshot,max_legacy_detail,created_on) VALUES (?,'applied','{}',0,NOW())",array(str_repeat('a',64)));
$s->query("INSERT INTO stock_material VALUES (1,'ITEM','1',10,0,10,0),(2,'ITEM','2',100,0,100,0)");
$s->query("INSERT INTO tr_sales_order(no_so,no_surat,order_status) VALUES ('SO1','SO1','stk'),('SO2','SO2','ind'),('SO3','SO3','stk')");
$s->query("INSERT INTO tr_sales_order_detail(id_so_detail,no_so,id_category3,qty_so) VALUES (1,'SO1','ITEM',5),(2,'SO2','ITEM',4),(3,'SO3','ITEM',9)");
tx(function() use($s){$s->reserveSo('SO1');});balance(10,5,5);
tx(function() use($s){$s->reserveSo('SO1');});balance(10,5,5);
check((int)$s->query('SELECT COUNT(*) n FROM kartu_stok')[0]['n']===1,'Repeated reserve wrote a second card');
tx(function() use($s){$s->reserveSo('SO2');});balance(10,5,5);
tx(function() use($s){$s->readyIndent('SO2');$s->readyIndent('SO2');});balance(10,9,1);
$s->query("INSERT INTO tr_delivery_order(no_do,no_surat) VALUES ('DO1','DO1'),('DO2','DO2')");
$s->query("INSERT INTO tr_delivery_order_detail(id_do_detail,id_so_detail,no_do,no_so,id_category3,qty_do,cost_book) VALUES (1,1,'DO1','SO1','ITEM',3,10),(2,1,'DO2','SO1','ITEM',2,10)");
tx(function() use($s){$s->confirmDelivery('DO1',array(1=>'1'));});balance(7,6,1);
tx(function() use($s){$s->confirmDelivery('DO1',array(1=>'1'));});balance(7,6,1);
tx(function() use($s){$s->confirmDelivery('DO2',array(2=>'0'));});balance(7,6,1);
rejected(function() use($s){$s->confirmDelivery('DO2',array(2=>'1'));});balance(7,6,1);
tx(function() use($s){$s->releaseSo('SO2');});balance(7,2,5);
tx(function() use($s){$s->releaseSo('SO2');});balance(7,2,5);
rejected(function() use($s){$s->reserveSo('SO3');});balance(7,2,5);
check(!$s->query('SELECT * FROM stock_booking_allocations WHERE id_so_detail=3'),'Failed reserve left an allocation');
rejected(function() use($s){$s->releaseSo('SO1');});balance(7,2,5);
rejected(function() use($s){$s->changeActual('ITEM',6,'ADJ1','ADJ1','out');});balance(7,2,5);
tx(function() use($s){$s->changeActual('ITEM',2,'IN1','IN1','in');});balance(9,2,7);
tx(function() use($s){$s->changeActual('ITEM',2,'IN1','IN1','in');});balance(9,2,7);
rejected(function() use($s){$s->changeActual('ITEM',3,'IN1','IN1','in');});balance(9,2,7);
check((int)$s->query('SELECT qty FROM stock_material WHERE id_stock=2')[0]['qty']===100,'Another warehouse changed');
$s->query('UPDATE tr_sales_order_detail SET qty_so=3 WHERE id_so_detail=1');
tx(function() use($s){$s->reserveSo('SO1');});balance(9,0,9);
rejected(function() use($s){$s->validatePlanning(array('no_so'=>'SO1','id_so_detail'=>array(1),'qty_delivery'=>array(1)));});
$s->query('UPDATE stock_material SET qty_book=-2,qty_free=11 WHERE id_stock=1');
rejected(function() use($s){$s->changeActual('ITEM',1,'IN2','IN2','in');});
check((int)$s->query('SELECT qty FROM stock_material WHERE id_stock=1')[0]['qty']===9,'Rejected corrupt balance changed actual');
$s->query('UPDATE stock_material SET qty_book=0,qty_free=9 WHERE id_stock=1');
// Exercise the real CI library's buffering and nested transaction boundary.
class StockTestDb {
    public $conn_id;public $depth=0;public $db_debug=true;
    function __construct($m){$this->conn_id=$m;}
    function trans_begin(){if($this->depth++===0){$this->conn_id->begin_transaction();}return true;}
    function trans_commit(){if(!$this->depth){return false;}if(--$this->depth===0){return $this->conn_id->commit();}return true;}
    function trans_rollback(){if(!$this->depth){return false;}if(--$this->depth===0){return $this->conn_id->rollback();}return true;}
    function trans_status(){return true;}
}
class StockTestAuth {function user_id(){return 'test';}}
$stockTestCi=(object)array('db'=>new StockTestDb($connection),'auth'=>new StockTestAuth());
function &get_instance(){global $stockTestCi;return $stockTestCi;}
function log_message($level,$message){}
require_once dirname(__DIR__) . '/application/libraries/Stock_booking.php';
$adapter=new Stock_booking();
ob_start();$adapter->document(function()use($adapter,$stockTestCi){$stockTestCi->db->trans_begin();$adapter->reserveSo('SO3');$stockTestCi->db->trans_commit();echo '{"status":1}';});$response=ob_get_clean();
check(json_decode($response,true)['status']===1 && $stockTestCi->db->depth===0,'Nested transaction did not commit cleanly');balance(9,9,0);
ob_start();$adapter->document(function()use($adapter){$adapter->changeActual('ITEM',2,'ROLLBACK','ROLLBACK','in');echo '{"status":1}';throw new DomainException('Simulated failure after mutation');});$response=ob_get_clean();
check(json_decode($response,true)['status']===0,'Premature success escaped the rollback response');balance(9,9,0);
check($stockTestCi->db->depth===0 && $stockTestCi->db->db_debug===true,'Transaction/debug state leaked');
check(!$s->query("SELECT operation_key FROM stock_booking_operations WHERE operation_type='actual' AND payload LIKE '%ROLLBACK%'"),'Rollback left an operation marker');
tx(function()use($s){$s->reverseDelivery('DO1','TEST-RETURN');});balance(12,12,0);
tx(function()use($s){$s->reverseDelivery('DO1','TEST-RETURN');});balance(12,12,0);
rejected(function()use($s){$s->confirmDelivery('DO1',array(1=>'1'));});
tx(function()use($s){$s->cancelSo('SO1');});balance(12,9,3);
check($s->query("SELECT deleted_by FROM tr_sales_order WHERE no_so='SO1'")[0]['deleted_by']!==null,'SO history was not preserved as canceled');
tx(function()use($s){$s->cancelSo('SO1');});balance(12,9,3);
tx(function()use($s){$s->cancelSo('SO3');});balance(12,0,12);
$s->query("INSERT INTO tr_sales_order(no_so,no_surat,order_status) VALUES ('SO4','SO4','stk')");
$s->query("INSERT INTO tr_sales_order_detail(id_so_detail,no_so,id_category3,qty_so) VALUES (4,'SO4','ITEM',2),(5,'SO4','ITEM',99)");
$cardsBefore=(int)$s->query('SELECT COUNT(*) n FROM kartu_stok')[0]['n'];
rejected(function()use($s){$s->reserveSo('SO4');});balance(12,0,12);
check((int)$s->query('SELECT COUNT(*) n FROM kartu_stok')[0]['n']===$cardsBefore && !$s->query('SELECT id FROM stock_booking_allocations WHERE id_so_detail IN (4,5)'),'Second-line failure did not roll back the first line/card');
// Cancel must not touch quarantined stock when the allocation holds nothing, and must not move booking for an unready indent SO.
$s->query("INSERT INTO stock_material VALUES (3,'QITEM','1',3,0,3,0)");
$s->query("INSERT INTO stock_booking_quarantine VALUES ('stock_material',3,'QITEM','1',?, 'active',0,'{}','test',NOW(),NULL)",array(str_repeat('a',64)));
$s->query("INSERT INTO tr_sales_order(no_so,no_surat,order_status) VALUES ('SO5','SO5','stk'),('SO6','SO6','ind')");
$s->query("INSERT INTO tr_sales_order_detail(id_so_detail,no_so,id_category3,qty_so) VALUES (6,'SO5','QITEM',1),(7,'SO6','ITEM',4)");
$s->query("INSERT INTO stock_booking_allocations(id_so_detail,stock_table,id_stock,updated_on) VALUES (6,'stock_material',3,NOW())");
tx(function()use($s){$s->cancelSo('SO5');});
tx(function()use($s){$s->cancelSo('SO6');});balance(12,0,12);
check($s->query("SELECT deleted_by FROM tr_sales_order WHERE no_so IN ('SO5','SO6') AND deleted_by IS NULL")===array(),'Zero-allocation cancel failed');
$lock=$s->query("SELECT GET_LOCK('waterco-stock-booking',0) acquired");
$second=stock_booking_connection();
try{
    check((int)$lock[0]['acquired']===1,'Cannot acquire coordinator lock');
    check((int)$second->query("SELECT GET_LOCK('waterco-stock-booking',0)")->fetch_row()[0]===0,'Concurrent connection entered the stock critical section');
}finally{$second->close();$s->query("SELECT RELEASE_LOCK('waterco-stock-booking')");}
echo "PASS: $count integration checks using temporary tables only\n";
