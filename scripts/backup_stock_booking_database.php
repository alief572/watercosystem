<?php
require_once __DIR__.'/stock_booking_connection.php';
try{
    $options=getopt('',array('output:'));
    if(empty($options['output'])){throw new RuntimeException('Usage: php scripts/backup_stock_booking_database.php --output=output/stock-booking/backup.sql.gz');}
    $path=$options['output'];
    if(file_exists($path)){throw new RuntimeException('Refusing to overwrite an existing backup.');}
    if(!is_dir(dirname($path)) && !mkdir(dirname($path),0700,true)){throw new RuntimeException('Cannot create backup directory.');}
    $m=stock_booking_connection();
    $m->begin_transaction(MYSQLI_TRANS_START_READ_ONLY|MYSQLI_TRANS_START_WITH_CONSISTENT_SNAPSHOT);
    $objects=$m->query('SHOW FULL TABLES')->fetch_all(MYSQLI_NUM);
    $file=gzopen($path,'wb6');if(!$file){throw new RuntimeException('Cannot create backup file.');}
    $write=function($sql)use($file){if(gzwrite($file,$sql)===false){throw new RuntimeException('Backup write failed.');}};
    $write("-- waterco_dev table/trigger backup before stock booking cleansing\nSET NAMES utf8mb4;\nSET FOREIGN_KEY_CHECKS=0;\nSET SQL_MODE='NO_AUTO_VALUE_ON_ZERO';\n");
    $rows=0;$tables=0;$views=array();
    foreach($objects as $object){
        if($object[1]!=='BASE TABLE'){$views[]=$object[0];continue;}
        $name='`'.str_replace('`','``',$object[0]).'`';
        $create=$m->query('SHOW CREATE TABLE '.$name)->fetch_row()[1];$write($create.";\n");
        $columns=$m->query('SHOW COLUMNS FROM '.$name)->fetch_all(MYSQLI_ASSOC);
        $columns=array_filter($columns,function($c){return strpos($c['Extra'],'GENERATED')===false;});
        $fields=implode(',',array_map(function($c){return '`'.str_replace('`','``',$c['Field']).'`';},$columns));
        $result=$m->query('SELECT '.$fields.' FROM '.$name,MYSQLI_USE_RESULT);
        while($row=$result->fetch_row()){
            $values=array_map(function($v)use($m){return $v===null?'NULL':"'".$m->real_escape_string($v)."'";},$row);
            $write('INSERT INTO '.$name.' ('.$fields.') VALUES ('.implode(',',$values).");\n");++$rows;
        }
        $result->free();++$tables;
        if($tables%25===0){echo "Backed up $tables tables; $rows rows\n";flush();}
    }
    foreach($views as $view){$name='`'.str_replace('`','``',$view).'`';$write($m->query('SHOW CREATE VIEW '.$name)->fetch_row()[1].";\n");}
    $triggers=$m->query('SHOW TRIGGERS')->fetch_all(MYSQLI_ASSOC);
    foreach($triggers as $trigger){$name='`'.str_replace('`','``',$trigger['Trigger']).'`';$row=$m->query('SHOW CREATE TRIGGER '.$name)->fetch_assoc();$write("DELIMITER $$\n".$row['SQL Original Statement']."$$\nDELIMITER ;\n");}
    $write("SET FOREIGN_KEY_CHECKS=1;\n-- BACKUP COMPLETE: $tables tables, $rows rows\n");gzclose($file);$file=null;$m->rollback();
    $manifest=array('database'=>stock_booking_database(),'tables'=>$tables,'views'=>count($views),'triggers'=>count($triggers),'rows'=>$rows,'bytes'=>filesize($path),'sha256'=>hash_file('sha256',$path),'completed_at'=>date(DATE_ATOM));
    if(file_put_contents($path.'.json',json_encode($manifest,JSON_PRETTY_PRINT|JSON_THROW_ON_ERROR))===false){throw new RuntimeException('Cannot save backup manifest.');}
    echo json_encode($manifest,JSON_PRETTY_PRINT),"\n";
}catch(Throwable $e){
    if(isset($file) && is_resource($file)){gzclose($file);}
    if(isset($m)){$m->rollback();}
    fwrite(STDERR,'Backup failed; do not proceed with cleansing until a complete backup is available.' . "\n");exit(1);
}
