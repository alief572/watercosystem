<?php
if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }
$options = getopt('', array('apply', 'environment:'));
$environment = isset($options['environment']) ? $options['environment'] : 'development';
if (!in_array($environment, array('development', 'testing', 'production'), true)) {
    fwrite(STDERR, "Invalid environment.\n"); exit(1);
}
$root = dirname(__DIR__);
define('BASEPATH', $root . '/system/');
define('ENVIRONMENT', $environment);
require $root . '/application/config/database.php';
$override = $root . '/application/config/' . $environment . '/database.php';
if (file_exists($override)) { require $override; }
$config = $db[$active_group]; $apply = isset($options['apply']);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$connection = mysqli_init();
$connection->options(MYSQLI_OPT_CONNECT_TIMEOUT, 10);
try {
    $connection->real_connect($config['hostname'], $config['username'], $config['password'], $config['database'], (int) (isset($config['port']) ? $config['port'] : 3306));
    $connection->set_charset('utf8mb4');
    echo ($apply ? 'Apply' : 'Check only') . ' database: ' . $config['database'] . "\n";
    $required = array('tr_purchase_order' => array('no_po', 'tanggal', 'matauang', 'nominal_kurs', 'status'),
        'dt_trans_po' => array('no_po', 'id_dt_po', 'qty', 'jumlahharga', 'diskon', 'close_po'),
        'dt_incoming' => array('id_dt_po', 'id_data', 'id_dt_incoming', 'qty_recive'),
        'tr_incoming' => array('id_data', 'tanggal', 'kurs', 'matauang', 'pib'));
    foreach ($required as $table => $fields) {
        $present = array_column($connection->query('SHOW COLUMNS FROM `' . $table . '`')->fetch_all(MYSQLI_ASSOC), 'Field');
        if (array_diff($fields, $present)) { throw new RuntimeException('Report schema incomplete: ' . $table); }
    }
    $parents = $connection->query("SELECT id FROM menus WHERE title='Reports' AND parent_id=0 AND group_menu=1 AND status=1")->fetch_all(MYSQLI_ASSOC);
    if (count($parents) !== 1) { throw new RuntimeException('Expected one active Reports parent menu.'); }
    $permissions = $connection->query("SELECT id_permission FROM permissions WHERE nm_permission='Report_Progress_Po.View'")->fetch_all(MYSQLI_ASSOC);
    $menus = $connection->query("SELECT id FROM menus WHERE link='report_progress_po'")->fetch_all(MYSQLI_ASSOC);
    if (count($permissions) > 1 || count($menus) > 1) { throw new RuntimeException('Duplicate report metadata; resolve before deployment.'); }
    echo 'Permission: ' . ($permissions ? 'present' : 'needs registration') . "\n";
    echo 'Menu: ' . ($menus ? 'present' : 'needs registration') . "\n";
    foreach (array('tr_purchase_order' => array('tanggal'), 'dt_trans_po' => array('no_po', 'id_dt_po'),
        'dt_incoming' => array('id_dt_po'), 'tr_incoming' => array('id_data')) as $table => $columns) {
        $indexes = $connection->query('SHOW INDEX FROM `' . $table . '`')->fetch_all(MYSQLI_ASSOC);
        $leading = array_column(array_filter($indexes, function ($row) { return (int) $row['Seq_in_index'] === 1; }), 'Column_name');
        foreach ($columns as $column) {
            echo $table . '.' . $column . ': ' . (in_array($column, $leading, true) ? 'indexed' : 'review EXPLAIN before adding an index') . "\n";
        }
    }
    if ($apply) {
        $connection->begin_transaction();
        if (!$permissions) {
            $connection->query("INSERT INTO permissions (nm_permission,nm_menu,ket,created_on) VALUES ('Report_Progress_Po.View','Report_Progress_Po','View',NOW())");
            $permissionId = (int) $connection->insert_id;
        } else { $permissionId = (int) $permissions[0]['id_permission']; }
        $parentId = (int) $parents[0]['id'];
        if (!$menus) {
            $next = $connection->query('SELECT COALESCE(MAX(`order`),0)+1 n FROM menus WHERE parent_id=' . $parentId . ' AND group_menu=1')->fetch_assoc();
            $order = (int) $next['n'];
            $connection->query("INSERT INTO menus (title,link,icon,target,group_menu,parent_id,permission_id,status,`order`,created_on,pusat) VALUES ('Report Progress PO','report_progress_po','fa fa-line-chart','sametab',1,$parentId,$permissionId,1,$order,NOW(),0)");
        } else {
            $menuId = (int) $menus[0]['id'];
            $connection->query("UPDATE menus SET title='Report Progress PO',permission_id=$permissionId,parent_id=$parentId,group_menu=1 WHERE id=$menuId");
        }
        $connection->commit();
        echo "Report registered. No role grants, transaction records or indexes changed.\n";
    }
} catch (Exception $error) {
    if (isset($connection) && $connection->connect_errno === 0 && $apply) { $connection->rollback(); }
    fwrite(STDERR, "Report registration failed; verify database connectivity, schema and metadata.\n");
    exit(1);
}
