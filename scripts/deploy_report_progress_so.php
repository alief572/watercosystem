<?php
/** CLI only. Default is read-only; --apply registers metadata and indexes, never transactions. */
if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}
$options = getopt('', array('apply', 'environment:'));
$environment = isset($options['environment']) ? $options['environment'] : 'development';
if (!in_array($environment, array('development', 'testing', 'production'), true)) {
    fwrite(STDERR, "Invalid environment.\n");
    exit(1);
}
$root = dirname(__DIR__);
define('BASEPATH', $root . '/system/');
define('ENVIRONMENT', $environment);
require $root . '/application/config/database.php';
$override = $root . '/application/config/' . $environment . '/database.php';
if (file_exists($override)) {
    require $override;
}
$config = $db[$active_group];
$apply = isset($options['apply']);
mysqli_report(MYSQLI_REPORT_OFF);
$connection = mysqli_init();
$connection->options(MYSQLI_OPT_CONNECT_TIMEOUT, 15);
if (!@$connection->real_connect($config['hostname'], $config['username'], $config['password'], $config['database'], isset($config['port']) ? $config['port'] : 3306)) {
    fwrite(STDERR, "Database connection failed. Check the configured environment and access.\n");
    exit(1);
}
$connection->set_charset('utf8');

function report_query($sql)
{
    global $connection;
    $result = $connection->query($sql);
    if ($result === false) {
        throw new RuntimeException($connection->error);
    }
    return $result;
}

function report_index_exists($table, $columns)
{
    $indexes = array();
    $result = report_query('SHOW INDEX FROM `' . $table . '`');
    while ($row = $result->fetch_assoc()) {
        $indexes[$row['Key_name']][(int) $row['Seq_in_index']] = $row['Column_name'];
    }
    foreach ($indexes as $index) {
        ksort($index);
        if (array_slice(array_values($index), 0, count($columns)) === $columns) {
            return true;
        }
    }
    return false;
}

try {
    echo ($apply ? 'Apply' : 'Check only') . ' database: ' . $config['database'] . "\n";
    $parent_result = report_query("SELECT id FROM menus WHERE title='Reports' AND parent_id=0 AND group_menu=1 AND status=1");
    if ($parent_result->num_rows !== 1) {
        throw new RuntimeException('Expected exactly one active Reports parent menu.');
    }
    $parent = $parent_result->fetch_assoc();

    $indexes = array(
        array('tr_sales_order', array('tgl_so'), 'idx_so_tgl_so'),
        array('tr_sales_order_detail', array('no_so'), 'idx_so_detail_no_so'),
        array('tr_delivery_order_detail', array('id_so_detail'), 'idx_do_detail_id_so_detail')
    );

    foreach ($indexes as $index) {
        if (report_index_exists($index[0], $index[1])) {
            echo $index[0] . ": index already present for (" . implode(', ', $index[1]) . ")\n";
        } else {
            echo $index[0] . ': ' . ($apply ? 'adding' : 'needs') . " index for (" . implode(', ', $index[1]) . ")\n";
            if ($apply) {
                report_query('ALTER TABLE `' . $index[0] . '` ADD INDEX `' . $index[2] . '` (`' . implode('`, `', $index[1]) . '`)');
            }
        }
    }

    $permission_result = report_query("SELECT id_permission FROM permissions WHERE nm_permission='Report_Progress_So.View'");
    $menu_result = report_query("SELECT id FROM menus WHERE link='report_progress_so'");

    if ($permission_result->num_rows > 1 || $menu_result->num_rows > 1) {
        throw new RuntimeException('Duplicate permission or report menu; resolve before deployment.');
    }

    echo 'Permission: ' . ($permission_result->num_rows ? 'present' : 'needs registration') . "\n";
    echo 'Menu: ' . ($menu_result->num_rows ? 'present' : 'needs registration') . "\n";

    if ($apply) {
        $connection->begin_transaction();
        if (!$permission_result->num_rows) {
            report_query("INSERT INTO permissions (nm_permission, nm_menu, ket, created_on) VALUES ('Report_Progress_So.View', 'Report_Progress_So', 'View', NOW())");
            $permission_id = $connection->insert_id;
        } else {
            $permission = $permission_result->fetch_assoc();
            $permission_id = $permission['id_permission'];
        }

        $parent_id = (int) $parent['id'];
        $permission_id = (int) $permission_id;

        if (!$menu_result->num_rows) {
            $order_result = report_query('SELECT COALESCE(MAX(`order`),0)+1 AS next_order FROM menus WHERE parent_id=' . $parent_id . ' AND group_menu=1');
            $order = $order_result->fetch_assoc();
            report_query("INSERT INTO menus (title, link, icon, target, group_menu, parent_id, permission_id, status, `order`, created_on, pusat) VALUES ('Report Progress SO', 'report_progress_so', 'fa fa-line-chart', 'sametab', 1, $parent_id, $permission_id, 1, " . (int) $order['next_order'] . ', NOW(), 0)');
        } else {
            $menu = $menu_result->fetch_assoc();
            report_query("UPDATE menus SET title='Report Progress SO', permission_id=$permission_id, parent_id=$parent_id, group_menu=1 WHERE id=" . (int) $menu['id']);
        }

        $connection->commit();
        echo "Deployment complete. No user/group permissions or transaction records changed.\n";
    }
} catch (Exception $error) {
    if ($apply) {
        $connection->rollback();
    }
    fwrite(STDERR, $error->getMessage() . "\n");
    exit(1);
}
