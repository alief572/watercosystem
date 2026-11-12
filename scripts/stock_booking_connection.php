<?php
if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }
function stock_booking_database()
{
    return $GLOBALS['stock_booking_database'] ?? 'waterco_dev';
}

function stock_booking_connection()
{
    $root = dirname(__DIR__);
    if (!defined('BASEPATH')) { define('BASEPATH', $root . '/system/'); }
    if (!defined('ENVIRONMENT')) { define('ENVIRONMENT', 'development'); }
    require $root . '/application/config/development/database.php';
    $c = $db['default'];
    $remote = $c['hostname'] === '206.84.97.106' && $c['database'] === 'waterco_dev';
    $local = getenv('STOCK_BOOKING_ALLOW_LOCAL') === '1' && $c['hostname'] === 'db' && $c['database'] === 'waterco_demo';
    if (!$remote && !$local) {
        throw new RuntimeException('Target must be 206.84.97.106/waterco_dev, or db/waterco_demo with STOCK_BOOKING_ALLOW_LOCAL=1; environment override refused.');
    }
    $GLOBALS['stock_booking_database'] = $c['database'];
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $connection = mysqli_init();
    $connection->options(MYSQLI_OPT_CONNECT_TIMEOUT, 15);
    $connection->real_connect($c['hostname'],$c['username'],$c['password'],$c['database'],(int)$c['port']);
    $connection->set_charset('utf8mb4');
    $connection->query("SET time_zone='+07:00'");
    return $connection;
}
