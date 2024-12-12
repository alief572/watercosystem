<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2018-09-14 08:31:27 --> Severity: Notice --> Undefined variable: nama_program /home/www/importa/application/modules/users/views/login_animate.php 6
ERROR - 2018-09-14 08:31:52 --> Severity: Notice --> Undefined variable: nama_program /home/www/importa/application/modules/users/views/login_animate.php 6
ERROR - 2018-09-14 10:10:17 --> Severity: Notice --> Undefined variable: nama_program /home/www/importa/application/modules/users/views/login_animate.php 6
ERROR - 2018-09-14 10:29:04 --> Severity: Notice --> Undefined variable: nama_program /home/www/importa/application/modules/users/views/login_animate.php 6
ERROR - 2018-09-14 11:11:59 --> Query error: Unknown column 'no_dos' in 'where clause' - Invalid query: SELECT *
FROM `trans_do_detail`
WHERE `no_dos` = '101-SJ-18I00039'
AND `qty_supply` >0
ERROR - 2018-09-14 14:01:53 --> Severity: Notice --> Undefined variable: nama_program /home/www/importa/application/modules/users/views/login_animate.php 6
ERROR - 2018-09-14 14:18:02 --> Query error: Unknown column 'b.qty_leadtime_produksi' in 'field list' - Invalid query: 
			SELECT 
				b.kdcab,
				a.id_barang,
				a.nm_barang,
				b.qty_forecast,
				b.qty_leadtime_produksi AS wkt_produksi,
				b.qty_leadtime_pengiriman AS wkt_pengiriman,
				b.safety_stock,
				b.qty_safety_stock,
				(b.qty_leadtime_produksi + b.qty_leadtime_pengiriman + b.safety_stock) AS wkt_order_point,
				(
					b.qty_forecast * (b.qty_leadtime_produksi + b.qty_leadtime_pengiriman + b.safety_stock)
				) AS qty_reorder_point,
				b.qty_stock 
			FROM 
				barang_master AS a  
				INNER JOIN barang_stock AS b ON a.id_barang = b.id_barang
			WHERE 1=1
				AND b.kdcab = '101'
			
ERROR - 2018-09-14 14:18:09 --> Query error: Unknown column 'b.qty_leadtime_produksi' in 'field list' - Invalid query: 
			SELECT 
				b.kdcab,
				a.id_barang,
				a.nm_barang,
				b.qty_forecast,
				b.qty_leadtime_produksi AS wkt_produksi,
				b.qty_leadtime_pengiriman AS wkt_pengiriman,
				b.safety_stock,
				b.qty_safety_stock,
				(b.qty_leadtime_produksi + b.qty_leadtime_pengiriman + b.safety_stock) AS wkt_order_point,
				(
					b.qty_forecast * (b.qty_leadtime_produksi + b.qty_leadtime_pengiriman + b.safety_stock)
				) AS qty_reorder_point,
				b.qty_stock 
			FROM 
				barang_master AS a  
				INNER JOIN barang_stock AS b ON a.id_barang = b.id_barang
			WHERE 1=1
				AND b.kdcab = '102'
			
ERROR - 2018-09-14 14:23:37 --> Query error: Unknown column 'b.qty_leadtime_produksi' in 'field list' - Invalid query: 
			SELECT 
				b.kdcab,
				a.id_barang,
				a.nm_barang,
				b.qty_forecast,
				b.qty_leadtime_produksi AS wkt_produksi,
				b.qty_leadtime_pengiriman AS wkt_pengiriman,
				b.safety_stock,
				b.qty_safety_stock,
				(b.qty_leadtime_produksi + b.qty_leadtime_pengiriman + b.safety_stock) AS wkt_order_point,
				(
					b.qty_forecast * (b.qty_leadtime_produksi + b.qty_leadtime_pengiriman + b.safety_stock)
				) AS qty_reorder_point,
				b.qty_stock 
			FROM 
				barang_master AS a  
				INNER JOIN barang_stock AS b ON a.id_barang = b.id_barang
			WHERE 1=1
				AND b.kdcab = '101'
			
ERROR - 2018-09-14 14:23:40 --> Query error: Unknown column 'b.qty_leadtime_produksi' in 'field list' - Invalid query: 
			SELECT 
				b.kdcab,
				a.id_barang,
				a.nm_barang,
				b.qty_forecast,
				b.qty_leadtime_produksi AS wkt_produksi,
				b.qty_leadtime_pengiriman AS wkt_pengiriman,
				b.safety_stock,
				b.qty_safety_stock,
				(b.qty_leadtime_produksi + b.qty_leadtime_pengiriman + b.safety_stock) AS wkt_order_point,
				(
					b.qty_forecast * (b.qty_leadtime_produksi + b.qty_leadtime_pengiriman + b.safety_stock)
				) AS qty_reorder_point,
				b.qty_stock 
			FROM 
				barang_master AS a  
				INNER JOIN barang_stock AS b ON a.id_barang = b.id_barang
			WHERE 1=1
				AND b.kdcab = '101'
			
ERROR - 2018-09-14 15:21:28 --> Severity: Notice --> Undefined variable: nama_program /home/www/importa/application/modules/users/views/login_animate.php 6
ERROR - 2018-09-14 15:21:30 --> Severity: Notice --> Undefined variable: nama_program /home/www/importa/application/modules/users/views/login_animate.php 6
ERROR - 2018-09-14 15:21:37 --> Severity: Notice --> Undefined variable: nama_program /home/www/importa/application/modules/users/views/login_animate.php 6
ERROR - 2018-09-14 15:21:50 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/barang/views/barang_form.php 41
ERROR - 2018-09-14 15:21:50 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/barang/views/barang_form.php 60
ERROR - 2018-09-14 15:21:50 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/barang/views/barang_form.php 122
ERROR - 2018-09-14 15:21:50 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/barang/views/barang_form.php 273
ERROR - 2018-09-14 15:21:50 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/barang/views/barang_form.php 397
ERROR - 2018-09-14 15:23:19 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/supplier/views/supplier_form.php 46
ERROR - 2018-09-14 15:23:19 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/supplier/views/supplier_form.php 69
ERROR - 2018-09-14 15:23:19 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/supplier/views/supplier_form.php 103
ERROR - 2018-09-14 15:23:19 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/supplier/views/supplier_form.php 122
ERROR - 2018-09-14 15:23:21 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/supplier/views/supplier_form.php 122
ERROR - 2018-09-14 22:35:25 --> Severity: Notice --> Undefined variable: nama_program /home/www/importa/application/modules/users/views/login_animate.php 6
