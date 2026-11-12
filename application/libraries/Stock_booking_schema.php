<?php

class Stock_booking_schema
{
    public static function statements()
    {
        return array(
            "CREATE TABLE IF NOT EXISTS stock_booking_allocations (
                id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                id_so_detail INT NOT NULL,
                stock_table VARCHAR(40) NOT NULL,
                id_stock INT NOT NULL,
                qty_reserved DECIMAL(20,0) NOT NULL DEFAULT 0,
                qty_consumed DECIMAL(20,0) NOT NULL DEFAULT 0,
                qty_released DECIMAL(20,0) NOT NULL DEFAULT 0,
                baseline_qty DECIMAL(20,0) NOT NULL DEFAULT 0,
                baseline_consumed DECIMAL(20,0) NOT NULL DEFAULT 0,
                ordered_qty DECIMAL(20,0) NOT NULL DEFAULT 0,
                updated_on DATETIME NOT NULL,
                UNIQUE KEY detail_stock (id_so_detail, stock_table, id_stock),
                KEY stock_balance (stock_table, id_stock)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
            "CREATE TABLE IF NOT EXISTS stock_booking_operations (
                operation_key VARCHAR(191) NOT NULL PRIMARY KEY,
                operation_type VARCHAR(40) NOT NULL,
                payload LONGTEXT NOT NULL,
                created_on DATETIME NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
            "CREATE TABLE IF NOT EXISTS stock_booking_batches (
                batch_key CHAR(64) NOT NULL PRIMARY KEY,
                status VARCHAR(20) NOT NULL,
                snapshot LONGTEXT NOT NULL,
                max_legacy_detail INT NOT NULL DEFAULT 0,
                created_on DATETIME NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
            "CREATE TABLE IF NOT EXISTS stock_booking_control (
                id TINYINT NOT NULL PRIMARY KEY,
                maintenance TINYINT NOT NULL DEFAULT 0,
                updated_on DATETIME NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
            "INSERT IGNORE INTO stock_booking_control (id,maintenance,updated_on) VALUES (1,0,NOW())",
            "CREATE TABLE IF NOT EXISTS stock_booking_quarantine (
                stock_table VARCHAR(40) NOT NULL,
                id_stock INT NOT NULL,
                id_category3 VARCHAR(255) NOT NULL,
                id_gudang VARCHAR(255) NOT NULL,
                batch_key CHAR(64) NOT NULL,
                status VARCHAR(20) NOT NULL DEFAULT 'active',
                target_booking DECIMAL(20,0) NOT NULL,
                before_state LONGTEXT NOT NULL,
                reason TEXT NOT NULL,
                created_on DATETIME NOT NULL,
                resolved_on DATETIME NULL,
                PRIMARY KEY (stock_table,id_stock),
                KEY item_guard (stock_table,id_category3(64),id_gudang(32),status)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"
        );
    }

    public static function guards()
    {
        $sql=array();
        foreach (array('stock_material','stock_material_multigudang') as $table) {
            foreach (array('INSERT','UPDATE','DELETE') as $event) {
                $name='booking_guard_v2_'.$table.'_'.strtolower($event);
                $bookingCheck=$event==='INSERT' ? 'COALESCE(NEW.qty_book,0)<>0' : 'NOT (NEW.qty_book <=> OLD.qty_book)';
                $maintenance="IF EXISTS (SELECT 1 FROM stock_booking_control WHERE id=1 AND maintenance=1)
                    AND COALESCE(@stock_booking_maintenance_write,0)<>1 THEN
                    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT='Stock booking maintenance in progress';
                END IF;";
                $itemAlias=$event==='DELETE'?'OLD':'NEW';
                $quarantined="EXISTS (SELECT 1 FROM stock_booking_quarantine WHERE stock_table='$table' AND status='active'
                    AND (id_stock=$itemAlias.id_stock OR (id_category3=$itemAlias.id_category3 AND id_gudang=$itemAlias.id_gudang)".
                    ($event==='UPDATE'?" OR id_stock=OLD.id_stock OR (id_category3=OLD.id_category3 AND id_gudang=OLD.id_gudang)":'')."))";
                if($event==='DELETE'){
                    $sql[$name]="CREATE TRIGGER $name BEFORE DELETE ON $table FOR EACH ROW BEGIN $maintenance
                        IF $quarantined THEN SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT='Stock is quarantined pending reconciliation'; END IF;
                    END";
                    continue;
                }
                $admin=$event==='UPDATE' ? "COALESCE(@stock_booking_quarantine_admin,0)=1 AND NEW.aktif <=> 'N'
                    AND NEW.qty <=> OLD.qty AND NEW.qty_book <=> OLD.qty_book AND NEW.qty_free <=> OLD.qty_free
                    AND NEW.id_stock=OLD.id_stock AND NEW.id_category3 <=> OLD.id_category3 AND NEW.id_gudang <=> OLD.id_gudang" : 'FALSE';
                $sql[$name]="CREATE TRIGGER $name BEFORE $event ON $table FOR EACH ROW BEGIN
                    $maintenance
                    IF $quarantined THEN
                        IF NOT ($admin) THEN SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT='Stock is quarantined pending reconciliation'; END IF;
                    ELSE
                    IF NEW.qty IS NULL OR NEW.qty<0 OR NEW.qty_book IS NULL OR NEW.qty_book<0
                        OR NEW.qty_free IS NULL OR NEW.qty_free<0 OR NEW.qty_free>NEW.qty
                        OR NEW.qty_free<>NEW.qty-NEW.qty_book THEN
                        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT='Invalid actual/booking/free stock balance';
                    END IF;
                    IF ($bookingCheck) AND COALESCE(@stock_booking_write,0)<>1 THEN
                        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT='Booking must use SO allocation service';
                    END IF;
                    END IF;
                END";
            }
        }
        return $sql;
    }
}
