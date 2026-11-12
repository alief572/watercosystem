<?php
require_once dirname(__DIR__) . '/scripts/stock_booking_connection.php';
require_once dirname(__DIR__) . '/application/libraries/Stock_booking_schema.php';
$connection=stock_booking_connection();$suffix=bin2hex(random_bytes(6));
$table='stock_booking_guard_test_'.$suffix;$control='stock_booking_control_test_'.$suffix;$quarantine='stock_booking_quarantine_test_'.$suffix;
$created=array();$count=0;
function guardRejects($sql){global $connection,$count;try{$connection->query($sql);}catch(mysqli_sql_exception $e){if($e->getSqlState()!=='45000'){throw $e;}++$count;return;}throw new RuntimeException('Guard accepted an invalid stock mutation');}
try{
    // Triggers cannot reference TEMPORARY tables; all three disposable tables contain fixtures only.
    $connection->query("CREATE TABLE $control (id TINYINT PRIMARY KEY,maintenance TINYINT)");$created[]=$control;
    $connection->query("INSERT INTO $control VALUES (1,0)");
    $connection->query("CREATE TABLE $quarantine (stock_table VARCHAR(40),id_stock INT,id_category3 VARCHAR(255),id_gudang VARCHAR(255),status VARCHAR(20))");$created[]=$quarantine;
    $connection->query("CREATE TABLE $table (id_stock INT PRIMARY KEY,id_category3 VARCHAR(255),id_gudang VARCHAR(255),qty INT,qty_book INT,qty_free INT,aktif CHAR(1)) ENGINE=InnoDB");$created[]=$table;
    $connection->query("INSERT INTO $table VALUES (3,'BAD','1',-1,-2,1,'Y')");
    foreach(Stock_booking_schema::guards() as $name=>$sql){
        if(strpos($name,'multigudang')!==false){continue;}
        $sql=str_replace(array($name,' ON stock_material ','FROM stock_booking_control ','FROM stock_booking_quarantine '),array('booking_test_'.$suffix.'_'.substr($name,-6),' ON '.$table.' ','FROM '.$control.' ','FROM '.$quarantine.' '),$sql);
        $connection->query($sql);
    }
    $connection->query("INSERT INTO $table VALUES (1,'GOOD','1',10,0,10,'Y')");
    foreach(array(
        "INSERT INTO $table VALUES (2,'OTHER','1',-1,0,-1,'Y')",
        "INSERT INTO $table VALUES (2,'OTHER','1',10,-2,12,'Y')",
        "INSERT INTO $table VALUES (2,'OTHER','1',10,2,8,'Y')",
        "UPDATE $table SET qty_free=11 WHERE id_stock=1",
        "UPDATE $table SET qty_book=2,qty_free=8 WHERE id_stock=1",
        "UPDATE $table SET qty=NULL WHERE id_stock=1"
    )as $sql){guardRejects($sql);}
    $connection->query('SET @stock_booking_write=1');$connection->query("UPDATE $table SET qty_book=2,qty_free=8 WHERE id_stock=1");++$count;
    $connection->query('SET @stock_booking_write=NULL');$connection->query("UPDATE $table SET qty=11,qty_free=9 WHERE id_stock=1");++$count;
    $connection->query("INSERT INTO $quarantine VALUES ('stock_material',3,'BAD','1','active')");
    guardRejects("UPDATE $table SET qty=0,qty_book=0,qty_free=0 WHERE id_stock=3");
    guardRejects("DELETE FROM $table WHERE id_stock=3");
    guardRejects("INSERT INTO $table VALUES (4,'BAD','1',0,0,0,'Y')");
    guardRejects("UPDATE $table SET id_stock=5,id_category3='OTHER',qty=0,qty_book=0,qty_free=0 WHERE id_stock=3");
    $connection->query('SET @stock_booking_quarantine_admin=1');$connection->query("UPDATE $table SET aktif='N' WHERE id_stock=3");++$count;
    guardRejects("UPDATE $table SET qty=0,qty_book=0,qty_free=0,aktif='N' WHERE id_stock=3");
    $row=$connection->query("SELECT qty,qty_book,qty_free,aktif FROM $table WHERE id_stock=3")->fetch_assoc();
    if(array_map('strval',$row)!==array('qty'=>'-1','qty_book'=>'-2','qty_free'=>'1','aktif'=>'N')){throw new RuntimeException('Quarantine changed original quantities');}++$count;
    $connection->query('SET @stock_booking_quarantine_admin=NULL');$connection->query("UPDATE $control SET maintenance=1 WHERE id=1");
    guardRejects("UPDATE $table SET qty=12,qty_free=10 WHERE id_stock=1");
    guardRejects("DELETE FROM $table WHERE id_stock=1");
    $connection->query('SET @stock_booking_maintenance_write=1');$connection->query("UPDATE $table SET qty=12,qty_free=10 WHERE id_stock=1");++$count;
    echo "PASS: $count database guard cases\n";
}finally{
    $connection->query('SET @stock_booking_write=NULL,@stock_booking_maintenance_write=NULL,@stock_booking_quarantine_admin=NULL');
    foreach(array_reverse($created) as $name){$connection->query("DROP TABLE $name");}
}
