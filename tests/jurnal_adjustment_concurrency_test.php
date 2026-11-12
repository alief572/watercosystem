<?php
// Creates two randomly named test databases; never writes source database tables.
if (PHP_SAPI !== 'cli' || getenv('JURNAL_ADJUSTMENT_TEST_DB') !== '1') { exit("Set JURNAL_ADJUSTMENT_TEST_DB=1 to run isolated database checks.\n"); }
error_reporting(E_ALL);
set_error_handler(function ($severity, $message, $file, $line) {
    if (error_reporting() & $severity) { throw new ErrorException($message, 0, $severity, $file, $line); }
    return false;
});
$worker = ($argv[1] ?? '') === '--worker';
$prefix = 'jurnal_adj_test_'.bin2hex(random_bytes(6));
define('DBERP', $worker ? $argv[2] : $prefix.'_erp');
define('DBACC', $worker ? $argv[3] : $prefix.'_acc');
foreach (array(DBERP, DBACC) as $database) {
    if (!preg_match('/^jurnal_adj_test_[a-f0-9]{12}_(erp|acc)$/D', $database)) { throw new RuntimeException('Unsafe test database name'); }
}
define('BASEPATH', dirname(__DIR__).'/system/'); define('ENVIRONMENT', 'development');
require dirname(__DIR__).'/application/config/development/database.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$config=$db['default'];
$connection=new mysqli($config['hostname'],$config['username'],$config['password'],$config['database'],(int)($config['port'] ?? 3306));
$connection->set_charset('utf8mb4');
$connection->query("SET SESSION sql_mode='STRICT_ALL_TABLES,NO_ENGINE_SUBSTITUTION'");
$connection->query('SET SESSION innodb_lock_wait_timeout=5');
function log_message($level, $message) {}
function is_php($version) { return version_compare(PHP_VERSION,$version,'>='); }
require BASEPATH.'database/DB_driver.php'; require BASEPATH.'database/DB_query_builder.php';
class CI_DB extends CI_DB_query_builder {}
require BASEPATH.'database/drivers/mysqli/mysqli_driver.php';
require BASEPATH.'core/Model.php';
require dirname(__DIR__).'/application/core/BF_Model.php';
require dirname(__DIR__).'/application/modules/jurnal_adjustment/models/Jurnal_adjustment_model.php';
require dirname(__DIR__).'/scripts/migrate_jurnal_adjustment.php';
$ciDb=new CI_DB_mysqli_driver(array('conn_id'=>$connection,'database'=>DBERP,'db_debug'=>false,'char_set'=>'utf8mb4','save_queries'=>false));
$model=(new ReflectionClass('Jurnal_adjustment_model'))->newInstanceWithoutConstructor(); $model->db=$ciDb;
if ($worker) {
    $snapshot=unserialize(stream_get_contents(STDIN), array('allowed_classes'=>false));
    echo json_encode(array('ready'=>$connection->thread_id)),"\n"; flush();
    try { $result=array('code'=>200,'nomor'=>$model->post_journal($argv[4],$snapshot,'race-test')); }
    catch (Throwable $error) { $result=array('code'=>$error instanceof DomainException ? $error->getCode() : 500,'msg'=>$error->getMessage()); }
    echo json_encode($result,JSON_THROW_ON_ERROR),"\n"; exit;
}
$checks=0; $created=array(); $processes=array();
$backup=sys_get_temp_dir().DIRECTORY_SEPARATOR.$prefix.'_backup';
function raceCheck($condition,$message) { ++$GLOBALS['checks']; if (!$condition) { throw new RuntimeException($message); } }
function raceSeed() {
    global $connection;
    foreach (array(DBERP.'.adjustment_stock',DBERP.'.ms_costbook',DBERP.'.ms_costbook_backup',DBACC.'.javh',DBACC.'.jurnal',DBACC.'.pastibisa_tb_cabang',DBACC.'.coa_master') as $table) { $connection->query('DELETE FROM '.$table); }
    $connection->query("INSERT INTO ".DBERP.".adjustment_stock (id_transaksi,id_material,adjustment,total_qty,tanggal_transaksi,status_jurnal) VALUES ('ADJ-RACE','ITEM','PLUS',3,CURDATE(),'OPN'),('ADJ-OTHER','ITEM','MINUS',2,CURDATE(),'OPN')");
    $connection->query("INSERT INTO ".DBERP.".ms_costbook (id_category3,nilai_costbook) VALUES ('ITEM',10.25)");
    $connection->query("INSERT INTO ".DBACC.".pastibisa_tb_cabang (nocab,subcab,nomorJC,lastupdate) VALUES ('101','A',100,CURDATE())");
    $connection->query("INSERT INTO ".DBACC.".coa_master (no_perkiraan,nama,kdcab) VALUES ('1105-01-01','Persediaan','101-A'),('6201-01-51','Selisih','101-A')");
}
function raceStart($id,$snapshot) {
    global $processes;
    $command=array(PHP_BINARY,'-n','-d','extension_dir='.ini_get('extension_dir'),'-d','extension=mysqli',__FILE__,'--worker',DBERP,DBACC,$id);
    $process=proc_open($command,array(0=>array('pipe','r'),1=>array('pipe','w'),2=>array('pipe','w')),$pipes,dirname(__DIR__));
    if (!is_resource($process)) { throw new RuntimeException('Cannot launch posting worker'); }
    $processes[]=array($process,$pipes);
    fwrite($pipes[0],serialize($snapshot)); fclose($pipes[0]);
    $ready=json_decode(fgets($pipes[1]),true,512,JSON_THROW_ON_ERROR);
    return array('process'=>$process,'pipes'=>$pipes,'connection'=>$ready['ready']);
}
function raceWait($workers) {
    global $connection;
    $ids=implode(',',array_map(function($worker) { return (int)$worker['connection']; },$workers));
    $deadline=microtime(true)+4;
    do {
        $count=(int)$connection->query('SELECT COUNT(*) FROM information_schema.PROCESSLIST WHERE ID IN ('.$ids.') AND INFO IS NOT NULL')->fetch_row()[0];
        if ($count===count($workers)) { raceCheck(true,'Workers blocked on database locks'); return; }
        usleep(20000);
    } while (microtime(true)<$deadline);
    throw new RuntimeException('Workers did not reach locked posting queries');
}
function raceFinish($worker) {
    $output=stream_get_contents($worker['pipes'][1]); $errors=stream_get_contents($worker['pipes'][2]);
    fclose($worker['pipes'][1]); fclose($worker['pipes'][2]);
    $exit=proc_close($worker['process']);
    raceCheck($exit===0 && $errors==='', 'Posting worker failed: '.$errors.' '.$output);
    return json_decode(trim($output),true,512,JSON_THROW_ON_ERROR);
}
try {
    foreach (array(DBERP,DBACC) as $database) { $connection->query('CREATE DATABASE '.$database); $created[]=$database; }
    foreach (array('adjustment_stock','ms_costbook','ms_costbook_backup') as $table) { $connection->query('CREATE TABLE '.DBERP.'.'.$table.' LIKE waterco_demo.'.$table); }
    foreach (array('javh','jurnal','pastibisa_tb_cabang','coa_master') as $table) { $connection->query('CREATE TABLE '.DBACC.'.'.$table.' LIKE gl_waterco.'.$table); }
    raceSeed();
    $report=jurnal_adjustment_preflight($connection,DBERP,DBACC);
    raceCheck(count($report['tables'])===4 && $report['findings']['unbalanced_journals']===array(), 'Preflight failed');
    $connection->query("INSERT INTO ".DBACC.".jurnal (nomor,no_perkiraan,keterangan,debet,kredit) VALUES ('MIXED-LABEL','1105-01-01','Adjustment PLUS LEGACY',31,0),('MIXED-LABEL','6201-01-51','Selisih stok',0,31)");
    $report=jurnal_adjustment_preflight($connection,DBERP,DBACC);
    raceCheck($report['findings']['unbalanced_journals']===array(),'Balanced legacy journal with different detail descriptions was flagged');
    raceSeed();
    $connection->query("INSERT INTO ".DBACC.".jurnal (nomor,no_perkiraan,no_reff,keterangan,debet,kredit) VALUES ('ORPHAN','1105-01-01','ADJ-RACE','Adjustment PLUS ADJ-RACE',31,0)");
    $connection->query("INSERT INTO ".DBACC.".javh (nomor,tgl,jml,memo,keterangan) VALUES ('HEADER-ONLY',CURDATE(),31,'','Adjustment PLUS OTHER')");
    $report=jurnal_adjustment_preflight($connection,DBERP,DBACC);
    foreach (array('unbalanced_journals','details_without_header','headers_without_details','open_adjustments_with_journals') as $finding) {
        raceCheck(count($report['findings'][$finding])===1,'Preflight missed '.$finding);
    }
    raceSeed();
    $manifest=jurnal_adjustment_backup($connection,DBERP,DBACC,$backup);
    raceCheck(count($manifest['tables'])===4, 'Backup manifest incomplete');
    jurnal_adjustment_migrate($connection,DBERP,DBACC,$backup);
    jurnal_adjustment_migrate($connection,DBERP,DBACC,$backup);
    raceCheck(true,'Migration and repeated verification passed');
    $model->assert_transactional_tables();
    $connection->query('UPDATE '.DBERP.'.adjustment_stock SET total_qty=99');
    try { jurnal_adjustment_verify($connection,DBERP,DBACC,$backup); throw new LogicException('Data corruption accepted'); }
    catch (RuntimeException $error) { raceCheck(strpos($error->getMessage(),'verification failed')!==false,'Verification did not detect changed data'); }
    // Restore only generated test tables from the actual SQL backup, then rehearse migration again.
    foreach (jurnal_adjustment_tables(DBERP,DBACC) as $table) {
        $connection->query('DROP TABLE '.$table);
        $connection->multi_query(file_get_contents($backup.'/'.$table.'.sql'));
        do { if ($result=$connection->store_result()) { $result->free(); } } while ($connection->more_results() && $connection->next_result());
    }
    jurnal_adjustment_migrate($connection,DBERP,DBACC,$backup);
    raceCheck(true,'SQL backup restored original contents and migrated again');

    foreach (array(false,true) as $differentSources) {
        raceSeed();
        $first=$model->prepare_journal('ADJ-RACE')['snapshot'];
        $second=$model->prepare_journal($differentSources ? 'ADJ-OTHER' : 'ADJ-RACE')['snapshot'];
        $connection->begin_transaction();
        $connection->query($differentSources ? 'SELECT * FROM '.DBACC.".pastibisa_tb_cabang WHERE nocab='101' FOR UPDATE" : 'SELECT * FROM '.DBERP.".adjustment_stock WHERE id_transaksi='ADJ-RACE' FOR UPDATE");
        $workers=array(raceStart('ADJ-RACE',$first),raceStart($differentSources ? 'ADJ-OTHER' : 'ADJ-RACE',$second));
        raceWait($workers); $connection->commit();
        $results=array(raceFinish($workers[0]),raceFinish($workers[1]));
        $codes=array_column($results,'code'); sort($codes);
        raceCheck($codes===($differentSources ? array(200,200) : array(200,409)), 'Concurrent results wrong: '.json_encode($results));
        $expected=$differentSources ? 2 : 1;
        raceCheck((int)$connection->query('SELECT COUNT(*) FROM '.DBACC.'.javh')->fetch_row()[0]===$expected, 'Concurrent header count wrong');
        raceCheck((int)$connection->query('SELECT COUNT(*) FROM '.DBACC.'.jurnal')->fetch_row()[0]===$expected*2, 'Concurrent detail count wrong');
        raceCheck((int)$connection->query('SELECT nomorJC FROM '.DBACC.'.pastibisa_tb_cabang')->fetch_row()[0]===100+$expected, 'Concurrent counter wrong');
        raceCheck((int)$connection->query("SELECT COUNT(*) FROM ".DBERP.".adjustment_stock WHERE status_jurnal='CLS'")->fetch_row()[0]===$expected, 'Concurrent status wrong');
    }
    raceSeed(); $snapshot=$model->prepare_journal('ADJ-RACE')['snapshot'];
    $connection->begin_transaction(); $connection->query('SELECT * FROM '.DBACC.".pastibisa_tb_cabang WHERE nocab='101' FOR UPDATE");
    $worker=raceStart('ADJ-RACE',$snapshot); raceWait(array($worker));
    $number='101-AJV'.date('y').'00101';
    $connection->query("INSERT INTO ".DBACC.".javh (nomor,tgl,jml,memo) VALUES ('$number',CURDATE(),99,'legacy writer')");
    $connection->commit(); $result=raceFinish($worker);
    raceCheck($result['code']===409,'Legacy number collision not rejected');
    raceCheck((int)$connection->query('SELECT COUNT(*) FROM '.DBACC.'.jurnal')->fetch_row()[0]===0,'Legacy collision left details');
    raceCheck((int)$connection->query('SELECT nomorJC FROM '.DBACC.'.pastibisa_tb_cabang')->fetch_row()[0]===100,'Legacy collision changed counter');
    raceCheck($connection->query("SELECT status_jurnal FROM ".DBERP.".adjustment_stock WHERE id_transaksi='ADJ-RACE'")->fetch_row()[0]==='OPN','Legacy collision closed source');
    echo "jurnal_adjustment migration/concurrency: $checks checks passed\n";
} finally {
    foreach ($processes as list($process,$pipes)) {
        if (is_resource($process)) { proc_terminate($process); foreach ($pipes as $pipe) { if (is_resource($pipe)) fclose($pipe); } proc_close($process); }
    }
    $connection->rollback();
    foreach ($created as $database) {
        if (preg_match('/^jurnal_adj_test_[a-f0-9]{12}_(erp|acc)$/D',$database)) { $connection->query('DROP DATABASE '.$database); }
    }
    $resolved=realpath($backup);
    if ($resolved && dirname($resolved)===realpath(sys_get_temp_dir()) && basename($resolved)===$prefix.'_backup') {
        foreach (array_merge(array('manifest.json'),array_map(function($table) { return $table.'.sql'; },jurnal_adjustment_tables(DBERP,DBACC))) as $file) {
            if (is_file($resolved.DIRECTORY_SEPARATOR.$file)) { unlink($resolved.DIRECTORY_SEPARATOR.$file); }
        }
        rmdir($resolved);
    }
}
