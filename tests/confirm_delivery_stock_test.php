<?php
// Uses only connection-local temporary tables on the local Docker database.
if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }
if (getenv('DB_HOST') !== 'db' || getenv('DB_NAME') !== 'waterco_demo') { throw new RuntimeException('Local Docker DB required.'); }
require_once dirname(__DIR__) . '/application/libraries/Stock_booking_schema.php';
require_once dirname(__DIR__) . '/application/libraries/Stock_booking_store.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$connection = new mysqli('db', getenv('DB_USER'), getenv('DB_PASS'), 'waterco_demo');
$definitions = array(
    'stock_material' => 'id_stock INT PRIMARY KEY,id_category3 VARCHAR(40),id_gudang VARCHAR(20),qty INT,qty_book INT,qty_free INT,deleted INT DEFAULT 0',
    'tr_sales_order' => 'no_so VARCHAR(20) PRIMARY KEY,total_dikirim INT,total_hpp DOUBLE,percent_do DOUBLE',
    'tr_sales_order_detail' => 'id_so_detail INT PRIMARY KEY,no_so VARCHAR(20),id_category3 VARCHAR(40),qty_so INT,qty_delivery INT DEFAULT 0,qty_spk INT DEFAULT 0',
    'tr_delivery_order' => 'no_do VARCHAR(20) PRIMARY KEY,no_surat VARCHAR(100),status_confirm CHAR(1),confirm_costbook DOUBLE,upload_sj VARCHAR(255)',
    'tr_delivery_order_detail' => "id_do_detail INT PRIMARY KEY,id_so_detail INT,no_do VARCHAR(20),no_so VARCHAR(20),id_category3 VARCHAR(40),qty_do INT,cost_book DOUBLE,status_kirim CHAR(1) DEFAULT '0',modified_on DATETIME,confirm_costbook DOUBLE",
    'kartu_stok' => 'id_category3 VARCHAR(40),qty INT,qty_book INT,qty_free INT,transaksi VARCHAR(100),tgl_transaksi DATE,no_transaksi VARCHAR(100),id_gudang VARCHAR(20),created_on DATETIME,created_by VARCHAR(50),qty_transaksi INT,qty_akhir INT,qty_book_akhir INT,qty_free_akhir INT,status_transaksi VARCHAR(5),no_surat VARCHAR(100),harga_stok DOUBLE,harga_do DOUBLE,cost_book DOUBLE',
);
foreach ($definitions as $table => $columns) { $connection->query("CREATE TEMPORARY TABLE $table ($columns) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci"); }
foreach (Stock_booking_schema::statements() as $sql) { $connection->query(str_replace('CREATE TABLE IF NOT EXISTS', 'CREATE TEMPORARY TABLE', $sql)); }
$s = new Stock_booking_store($connection, 'confirm-stock-test');
$s->query("INSERT INTO stock_booking_batches VALUES (?,'applied','{}',0,NOW())", array(str_repeat('a', 64)));
$checks = 0;
function confirmCheck($value, $message) { global $checks; if (!$value) { throw new RuntimeException($message); } ++$checks; }
function confirmTx($fn) {
    global $connection;
    $connection->begin_transaction();
    try { $fn(); $connection->commit(); } catch (Throwable $e) { $connection->rollback(); throw $e; }
}
function confirmSnapshot() {
    global $s;
    $result = array();
    foreach (array('stock_material','stock_booking_allocations','stock_booking_operations','tr_delivery_order','tr_delivery_order_detail','tr_sales_order','tr_sales_order_detail','kartu_stok') as $table) { $result[$table] = $s->query("SELECT * FROM $table"); }
    return $result;
}
function confirmReject($fn, $message) {
    $before = confirmSnapshot();
    try { confirmTx($fn); } catch (DomainException $e) {
        confirmCheck($e->getMessage() === $message, 'Unexpected rejection: ' . $e->getMessage());
        confirmCheck(confirmSnapshot() === $before, 'Failed confirmation did not roll back');
        return;
    }
    throw new RuntimeException('Expected rejection: ' . $message);
}
function confirmFixture($reserved, $qty, $actual = 10, $other = 4, $allocation = true) {
    global $s;
    foreach (array('stock_material','stock_booking_allocations','stock_booking_operations','tr_delivery_order','tr_delivery_order_detail','tr_sales_order','tr_sales_order_detail','kartu_stok') as $table) { $s->query("DELETE FROM $table"); }
    $s->query("INSERT INTO stock_material VALUES (1,'ITEM','1',?,?,?,0)", array($actual, $reserved+$other, $actual-$reserved-$other));
    $s->query("INSERT INTO tr_sales_order(no_so) VALUES ('SO1')");
    $s->query("INSERT INTO tr_sales_order_detail VALUES (1,'SO1','ITEM',6,6,6)");
    $s->query("INSERT INTO tr_delivery_order(no_do,no_surat) VALUES ('DO1','DO1')");
    $s->query("INSERT INTO tr_delivery_order_detail(id_do_detail,id_so_detail,no_do,no_so,id_category3,qty_do,cost_book) VALUES (1,1,'DO1','SO1','ITEM',?,10)", array($qty));
    if ($allocation) { $s->query("INSERT INTO stock_booking_allocations(id_so_detail,stock_table,id_stock,qty_reserved,ordered_qty,updated_on) VALUES (1,'stock_material',1,?,6,NOW())", array($reserved)); }
    $s->query("INSERT INTO stock_booking_allocations(id_so_detail,stock_table,id_stock,qty_reserved,ordered_qty,updated_on) VALUES (2,'stock_material',1,?,?,NOW())", array($other, $other));
}

foreach (array('partial booking' => array(1,3,true), 'zero booking' => array(0,2,true), 'no allocation' => array(0,2,false), 'full booking' => array(3,3,true)) as $name => $case) {
    list($reserved,$qty,$allocation) = $case;
    confirmFixture($reserved,$qty,10,4,$allocation);
    confirmTx(function () use ($s) { $s->confirmDelivery('DO1', array(1=>'1')); });
    $stock = $s->query('SELECT * FROM stock_material')[0];
    confirmCheck((int)$stock['qty'] === 10-$qty && (int)$stock['qty_book'] === 4 && (int)$stock['qty_free'] === 6-$qty, $name . ' incorrect stock');
    $a = $s->query('SELECT * FROM stock_booking_allocations WHERE id_so_detail=1')[0];
    confirmCheck((int)$a['qty_reserved'] === 0 && (int)$a['qty_consumed'] === $qty, $name . ' incorrect allocation');
    confirmCheck((int)$s->query('SELECT qty_reserved FROM stock_booking_allocations WHERE id_so_detail=2')[0]['qty_reserved'] === 4, 'Other SO booking changed');
    $before = confirmSnapshot();
    confirmTx(function () use ($s) { $s->confirmDelivery('DO1', array(1=>'1')); });
    confirmCheck(confirmSnapshot() === $before, 'Repeated confirm changed stock');
    confirmTx(function () use ($s) { $s->reverseDelivery('DO1', 'test return'); });
    $stock = $s->query('SELECT * FROM stock_material')[0];
    confirmCheck((int)$stock['qty'] === 10 && (int)$stock['qty_book'] === 4+$reserved && (int)$stock['qty_free'] === 6-$reserved, 'Reversal restored wrong booking');
    $before = confirmSnapshot();
    confirmTx(function () use ($s) { $s->reverseDelivery('DO1', 'test return'); });
    confirmCheck(confirmSnapshot() === $before, 'Repeated reversal changed stock');
    echo "PASS: $name and reversal\n";
}
confirmFixture(1,4,10,7);
confirmReject(function () use ($s) { $s->confirmDelivery('DO1',array(1=>'1')); }, 'Stok bebas dan booking SO ini tidak cukup untuk pengiriman; booking SO lain tetap dijaga.');
confirmFixture(0,3,2,0,false);
confirmReject(function () use ($s) { $s->confirmDelivery('DO1',array(1=>'1')); }, 'Stok aktual tidak cukup untuk pengiriman.');
confirmFixture(0,7,20,0,false);
confirmReject(function () use ($s) { $s->confirmDelivery('DO1',array(1=>'1')); }, 'Total pengiriman melebihi Qty SO.');
confirmFixture(0,4,20,0,false);
$s->query("INSERT INTO tr_delivery_order(no_do,no_surat,status_confirm) VALUES ('OLD','OLD','1')");
$s->query("INSERT INTO tr_delivery_order_detail(id_do_detail,id_so_detail,no_do,no_so,id_category3,qty_do,cost_book,status_kirim) VALUES (9,1,'OLD','SO1','ITEM',3,10,'1')");
confirmReject(function () use ($s) { $s->confirmDelivery('DO1',array(1=>'1')); }, 'Total pengiriman melebihi Qty SO.');
confirmFixture(0,4,20,0,false);
$s->query("INSERT INTO tr_delivery_order_detail(id_do_detail,id_so_detail,no_do,no_so,id_category3,qty_do,cost_book) VALUES (2,1,'DO1','SO1','ITEM',3,10)");
confirmReject(function () use ($s) { $s->confirmDelivery('DO1',array(1=>'1',2=>'1')); }, 'Total pengiriman melebihi Qty SO.');
confirmFixture(1,3);
$s->query("INSERT INTO tr_delivery_order_detail(id_do_detail,id_so_detail,no_do,no_so,id_category3,qty_do,cost_book) VALUES (2,1,'DO1','SO1','ITEM',2,10)");
confirmTx(function () use ($s) { $s->confirmDelivery('DO1',array(1=>'1',2=>'1')); });
confirmCheck((int)$s->query('SELECT qty FROM stock_material')[0]['qty'] === 5, 'Split DO did not consume combined qty');
confirmCheck((int)$s->query('SELECT qty_consumed FROM stock_booking_allocations WHERE id_so_detail=1')[0]['qty_consumed'] === 5, 'Split DO consumption incorrect');
confirmTx(function () use ($s) { $s->reverseDelivery('DO1','split return'); });
confirmCheck((int)$s->query('SELECT qty_book FROM stock_material')[0]['qty_book'] === 5, 'Split reversal restored wrong booking');
confirmFixture(0,2,10,4,false);
confirmTx(function () use ($s) { $s->confirmDelivery('DO1',array(1=>'0')); });
confirmCheck((int)$s->query('SELECT qty FROM stock_material')[0]['qty'] === 10, 'Failed delivery changed actual stock');
confirmCheck(!$s->query('SELECT id FROM stock_booking_allocations WHERE id_so_detail=1'), 'Failed delivery created allocation');
confirmFixture(3,3);
confirmTx(function () use ($s) { $s->confirmDelivery('DO1',array(1=>'1')); });
$s->query('UPDATE stock_booking_operations SET payload=? WHERE operation_key=?', array('{"1":"1"}','confirm-do:DO1'));
confirmTx(function () use ($s) { $s->reverseDelivery('DO1','legacy return'); });
confirmCheck((int)$s->query('SELECT qty_book FROM stock_material')[0]['qty_book'] === 7, 'Legacy reversal failed');
echo "PASS: $checks confirmation stock checks using temporary tables only\n";
