<?php
if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }

function jurnal_adjustment_tables($erp, $accounting)
{
    foreach (array($erp, $accounting) as $schema) {
        if (!is_string($schema) || !preg_match('/^[a-zA-Z0-9_]+$/D', $schema)) { throw new RuntimeException('Invalid database name'); }
    }
    return array($erp.'.adjustment_stock', $accounting.'.javh', $accounting.'.jurnal', $accounting.'.pastibisa_tb_cabang');
}

function jurnal_adjustment_metadata($connection, $table)
{
    $create = $connection->query('SHOW CREATE TABLE '.$table)->fetch_row()[1];
    preg_match('/\bENGINE=(\w+)/', $create, $engine);
    $indexes = array();
    foreach ($connection->query('SHOW INDEX FROM '.$table)->fetch_all(MYSQLI_ASSOC) as $index) {
        $indexes[$index['Key_name'].':'.$index['Seq_in_index']] = array_intersect_key($index, array_flip(array('Non_unique','Column_name','Sub_part','Index_type','Collation')));
    }
    ksort($indexes);
    $columns = $connection->query('SHOW FULL COLUMNS FROM '.$table)->fetch_all(MYSQLI_ASSOC);
    foreach ($columns as &$column) { unset($column['Key']); }
    unset($column);
    return array('engine'=>$engine[1] ?? '', 'columns'=>$columns, 'indexes'=>$indexes);
}

function jurnal_adjustment_preflight($connection, $erp, $accounting)
{
    $metadata = array();
    foreach (jurnal_adjustment_tables($erp, $accounting) as $table) { $metadata[$table] = jurnal_adjustment_metadata($connection, $table); }
    $queries = array(
        'duplicate_adjustment_ids'=>"SELECT id_transaksi,COUNT(*) rows_found FROM $erp.adjustment_stock GROUP BY id_transaksi HAVING COUNT(*)>1 LIMIT 100",
        'invalid_adjustment_ids'=>"SELECT COUNT(*) total FROM $erp.adjustment_stock WHERE id_transaksi IS NULL OR TRIM(id_transaksi)='' OR OCTET_LENGTH(id_transaksi)>25",
        'branch_101'=>"SELECT id,nocab,subcab,nomorJC FROM $accounting.pastibisa_tb_cabang WHERE nocab='101'",
        'coa_101_A'=>"SELECT no_perkiraan,COUNT(*) rows_found FROM $accounting.coa_master WHERE kdcab='101-A' AND no_perkiraan IN ('1105-01-01','6201-01-51') GROUP BY no_perkiraan",
        'unbalanced_journals'=>"SELECT d.nomor,COUNT(*) detail_rows,SUM(COALESCE(d.debet,0)) debit,SUM(COALESCE(d.kredit,0)) credit FROM $accounting.jurnal d JOIN (SELECT DISTINCT nomor FROM $accounting.jurnal WHERE keterangan LIKE 'Adjustment %') a ON a.nomor=d.nomor GROUP BY d.nomor HAVING ABS(SUM(COALESCE(d.debet,0))-SUM(COALESCE(d.kredit,0)))>0.000001 LIMIT 100",
        'details_without_header'=>"SELECT d.nomor,COUNT(*) detail_rows FROM $accounting.jurnal d LEFT JOIN $accounting.javh h ON h.nomor=d.nomor WHERE d.keterangan LIKE 'Adjustment %' AND h.nomor IS NULL GROUP BY d.nomor LIMIT 100",
        'headers_without_details'=>"SELECT h.nomor,h.keterangan FROM $accounting.javh h LEFT JOIN $accounting.jurnal d ON d.nomor=h.nomor WHERE h.keterangan LIKE 'Adjustment %' AND d.id IS NULL LIMIT 100",
        'open_adjustments_with_journals'=>"SELECT a.id_transaksi,a.status_jurnal,d.nomor FROM $erp.adjustment_stock a JOIN (SELECT DISTINCT no_reff,nomor FROM $accounting.jurnal) d ON d.no_reff=a.id_transaksi WHERE a.status_jurnal IS NULL OR a.status_jurnal<>'CLS' LIMIT 100",
        'duplicate_adjustment_postings'=>"SELECT a.id_transaksi,COUNT(DISTINCT d.nomor) journal_count FROM $erp.adjustment_stock a JOIN $accounting.jurnal d ON d.no_reff=a.id_transaksi GROUP BY a.id_transaksi HAVING COUNT(DISTINCT d.nomor)>1 LIMIT 100"
    );
    $report = array('tables'=>$metadata, 'findings'=>array());
    foreach ($queries as $name=>$sql) { $report['findings'][$name] = $connection->query($sql)->fetch_all(MYSQLI_ASSOC); }
    return $report;
}

function jurnal_adjustment_fingerprint($connection, $table, $dump = null)
{
    $hashes = array();
    $rows = $connection->query('SELECT * FROM '.$table, MYSQLI_USE_RESULT);
    while ($row = $rows->fetch_row()) {
        $hashes[] = hash('sha256', serialize($row));
        if ($dump !== null) {
            $values = array_map(function ($value) use ($connection) { return $value === null ? 'NULL' : "'".$connection->real_escape_string($value)."'"; }, $row);
            jurnal_adjustment_write($dump, 'INSERT INTO '.$table.' VALUES ('.implode(',', $values).");\n");
        }
    }
    $rows->free();
    sort($hashes, SORT_STRING);
    return array('rows'=>count($hashes), 'sha256'=>hash('sha256', implode('', $hashes)));
}

function jurnal_adjustment_write($file, $text)
{
    if (fwrite($file, $text) !== strlen($text)) { throw new RuntimeException('Backup write incomplete; do not migrate'); }
}

function jurnal_adjustment_backup($connection, $erp, $accounting, $directory)
{
    $tables = jurnal_adjustment_tables($erp, $accounting);
    if (file_exists($directory)) { throw new RuntimeException('Backup directory must be new; refusing to overwrite'); }
    if (!mkdir($directory, 0700, true)) { throw new RuntimeException('Cannot create backup directory'); }
    $manifest = array('erp'=>$erp, 'accounting'=>$accounting, 'server'=>$connection->query('SELECT @@hostname hostname,@@port port')->fetch_assoc(), 'created_at'=>date(DATE_ATOM), 'tables'=>array());
    $connection->query('LOCK TABLES '.implode(',', array_map(function ($table) { return $table.' READ'; }, $tables)));
    try {
        foreach ($tables as $table) {
            $metadata = jurnal_adjustment_metadata($connection, $table);
            if (!in_array($metadata['engine'], array('InnoDB','MyISAM'), true)) { throw new RuntimeException('Unsupported engine: '.$table); }
            if ($connection->query("SHOW TRIGGERS FROM ".explode('.', $table)[0]." WHERE `Table`='".explode('.', $table)[1]."'")->num_rows) {
                throw new RuntimeException('Triggers require a full DBA backup before this migration: '.$table);
            }
            $file = fopen($directory.'/'.$table.'.sql', 'xb');
            if (!$file) { throw new RuntimeException('Cannot create backup file'); }
            try {
                $create = $connection->query('SHOW CREATE TABLE '.$table)->fetch_row()[1];
                $create = preg_replace('/^CREATE TABLE `[^`]+`/', 'CREATE TABLE '.$table, $create);
                jurnal_adjustment_write($file, "SET NAMES utf8mb4;\nSET SQL_MODE='NO_AUTO_VALUE_ON_ZERO';\n".$create.";\n");
                $fingerprint = jurnal_adjustment_fingerprint($connection, $table, $file);
                jurnal_adjustment_write($file, "-- BACKUP COMPLETE\n");
            } finally { fclose($file); }
            $manifest['tables'][$table] = array_merge($metadata, $fingerprint, array('dump_sha256'=>hash_file('sha256', $directory.'/'.$table.'.sql')));
        }
    } finally { $connection->query('UNLOCK TABLES'); }
    $file = fopen($directory.'/manifest.json', 'xb');
    if (!$file) { throw new RuntimeException('Cannot create backup manifest'); }
    try { jurnal_adjustment_write($file, json_encode($manifest, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR)); }
    finally { fclose($file); }
    return $manifest;
}

function jurnal_adjustment_verify($connection, $erp, $accounting, $directory, $requireInnoDB = true)
{
    $manifest = json_decode(file_get_contents($directory.'/manifest.json'), true, 512, JSON_THROW_ON_ERROR);
    $tables = jurnal_adjustment_tables($erp, $accounting);
    if ($manifest['erp'] !== $erp || $manifest['accounting'] !== $accounting || array_keys($manifest['tables']) !== $tables || $manifest['server'] !== $connection->query('SELECT @@hostname hostname,@@port port')->fetch_assoc()) {
        throw new RuntimeException('Backup manifest does not match target server/databases');
    }
    foreach ($tables as $table) {
        $before = $manifest['tables'][$table];
        if (!hash_equals($before['dump_sha256'], hash_file('sha256', $directory.'/'.$table.'.sql'))) { throw new RuntimeException('Backup checksum mismatch: '.$table); }
        $after = jurnal_adjustment_metadata($connection, $table);
        if (!in_array($after['engine'], array('InnoDB','MyISAM'), true)) { throw new RuntimeException('Unexpected engine: '.$table); }
        $fingerprint = jurnal_adjustment_fingerprint($connection, $table);
        if (($requireInnoDB && $after['engine'] !== 'InnoDB') || $before['columns'] !== $after['columns'] || $before['rows'] !== $fingerprint['rows'] || !hash_equals($before['sha256'], $fingerprint['sha256'])) {
            throw new RuntimeException('Engine/schema/data verification failed: '.$table);
        }
        foreach ($before['indexes'] as $key=>$index) {
            if (!isset($after['indexes'][$key]) || $after['indexes'][$key] !== $index) { throw new RuntimeException('Existing index changed: '.$table.' '.$key); }
        }
        if ($requireInnoDB && $table === $erp.'.adjustment_stock') {
            $indexed = false;
            foreach ($after['indexes'] as $key=>$index) {
                if (substr($key, -2) === ':1' && $index['Column_name'] === 'id_transaksi' && $index['Sub_part'] === null) { $indexed = true; }
            }
            if (!$indexed) { throw new RuntimeException('Adjustment ID index missing'); }
        }
    }
    return $manifest;
}

function jurnal_adjustment_migrate($connection, $erp, $accounting, $directory)
{
    jurnal_adjustment_verify($connection, $erp, $accounting, $directory, false);
    foreach (jurnal_adjustment_tables($erp, $accounting) as $table) {
        $metadata = jurnal_adjustment_metadata($connection, $table);
        if ($metadata['engine'] !== 'InnoDB') { $connection->query('ALTER TABLE '.$table.' ENGINE=InnoDB'); }
    }
    $indexes = $connection->query('SHOW INDEX FROM '.$erp.'.adjustment_stock')->fetch_all(MYSQLI_ASSOC);
    $indexed = false;
    foreach ($indexes as $index) {
        if ($index['Column_name'] === 'id_transaksi' && (int)$index['Seq_in_index'] === 1 && $index['Sub_part'] === null) { $indexed = true; }
    }
    if (!$indexed) { $connection->query('ALTER TABLE '.$erp.'.adjustment_stock ADD INDEX idx_jurnal_adjustment_id (id_transaksi)'); }
    jurnal_adjustment_verify($connection, $erp, $accounting, $directory);
}

if (realpath($_SERVER['SCRIPT_FILENAME'] ?? '') !== __FILE__) { return; }
try {
    $options = getopt('', array('preflight','backup','migrate','verify','maintenance','backup-dir:','environment:'));
    $mode = array_values(array_intersect(array('preflight','backup','migrate','verify'), array_keys($options)));
    if (count($mode) > 1) { throw new RuntimeException('Choose one of --preflight, --backup, --migrate, --verify'); }
    $mode = $mode[0] ?? 'preflight';
    $environment = $options['environment'] ?? 'development';
    if (!in_array($environment, array('development','testing','production'), true)) { throw new RuntimeException('Invalid environment'); }
    define('BASEPATH', dirname(__DIR__).'/system/'); define('ENVIRONMENT', $environment);
    require dirname(__DIR__).'/application/config/constants.php';
    $configFile = dirname(__DIR__).'/application/config/'.$environment.'/database.php';
    if ($environment !== 'production' && !is_file($configFile)) { throw new RuntimeException('Environment database config missing'); }
    require is_file($configFile) ? $configFile : dirname(__DIR__).'/application/config/database.php';
    $config = $db['default'];
    if ($config['database'] !== DBERP) { throw new RuntimeException('Configured default database does not match DBERP'); }
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $connection = new mysqli($config['hostname'], $config['username'], $config['password'], $config['database'], (int)($config['port'] ?? 3306));
    $connection->set_charset('utf8mb4');
    if ($mode === 'preflight') { echo json_encode(jurnal_adjustment_preflight($connection, DBERP, DBACC), JSON_PRETTY_PRINT | JSON_INVALID_UTF8_SUBSTITUTE), "\n"; exit; }
    if (!isset($options['maintenance'], $options['backup-dir'])) { throw new RuntimeException('--maintenance and --backup-dir are required; stop all accounting/adjustment writers first'); }
    $directory = $options['backup-dir'];
    $resolved = realpath($directory) ?: realpath(dirname($directory));
    $root = strtolower(str_replace('\\','/', realpath(dirname(__DIR__))));
    if (!$resolved || strpos(strtolower(str_replace('\\','/', $resolved)).'/', $root.'/') === 0) { throw new RuntimeException('Backup must be outside web workspace, with an existing parent directory'); }
    if ($mode === 'backup') { jurnal_adjustment_backup($connection, DBERP, DBACC, $directory); }
    elseif ($mode === 'migrate') { jurnal_adjustment_migrate($connection, DBERP, DBACC, $directory); }
    else { jurnal_adjustment_verify($connection, DBERP, DBACC, $directory); }
    echo "$mode completed; keep maintenance active until all verification passes.\n";
} catch (Throwable $error) {
    fwrite(STDERR, 'Migration stopped: '.$error->getMessage()."\nKeep writers stopped. Do not reverse engines automatically.\n");
    exit(1);
}
