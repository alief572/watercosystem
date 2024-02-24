<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-08-05 00:36:17 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/inventory_4/views/add_inventory.php 53
ERROR - 2020-08-05 00:38:39 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/inventory_4/views/add_inventory.php 53
ERROR - 2020-08-05 02:19:46 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/inventory_4/views/add_inventory.php 53
ERROR - 2020-08-05 02:22:08 --> Query error: Table 'metalsindo_db.ms_material_compotition' doesn't exist - Invalid query: SELECT *
FROM `ms_material_compotition`
WHERE `id_category1` = 'I2000001'
ORDER BY `id_compotition` ASC
ERROR - 2020-08-05 02:24:48 --> Query error: Table 'metalsindo_db.ms_material_compotition' doesn't exist - Invalid query: SELECT *
FROM `ms_material_compotition`
WHERE `id_category1` = 'I2000001'
ORDER BY `id_compotition` ASC
ERROR - 2020-08-05 02:27:35 --> Query error: Table 'metalsindo_db.child_dimensi_bentuk' doesn't exist - Invalid query: SELECT *
FROM `child_dimensi_bentuk`
WHERE `id_bentuk` = 'B2000001'
ORDER BY `id_dimensi_bentuk` ASC
ERROR - 2020-08-05 02:28:55 --> Query error: Unknown column 'id_dimensi_bentuk' in 'order clause' - Invalid query: SELECT *
FROM `ms_dimensi`
WHERE `deleted` = '0' and `id_bentuk` = 'B2000002'
ORDER BY `id_dimensi_bentuk` ASC
ERROR - 2020-08-05 02:31:54 --> Query error: Unknown column 'safety_stock' in 'field list' - Invalid query: INSERT INTO `ms_inventory_category3` (`id_category3`, `id_type`, `id_category1`, `id_category2`, `nama`, `maker`, `hardness`, `density`, `id_bentuk`, `id_surface`, `safety_stock`, `mountly_forecast`, `order_point`, `max_stock`, `aktif`, `created_on`, `created_by`, `deleted`) VALUES ('I2000001', 'I2000001', 'I2000002', 'I2000002', 'percobaan', 'CN', '20', '10', 'B2000002', 'I2000005', '10', '10', '10', '10', 'aktif', '2020-08-05 02:31:54', '1', '0')
ERROR - 2020-08-05 02:35:39 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/inventory_4/controllers/Inventory_4.php 205
ERROR - 2020-08-05 02:35:39 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/inventory_4/controllers/Inventory_4.php 233
ERROR - 2020-08-05 02:35:39 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/inventory_4/controllers/Inventory_4.php 249
ERROR - 2020-08-05 02:35:39 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/inventory_4/controllers/Inventory_4.php 265
ERROR - 2020-08-05 02:39:09 --> Severity: Parsing Error --> syntax error, unexpected '<' /home/ssc/metalsindo_dev/application/modules/inventory_4/controllers/Inventory_4.php 231
ERROR - 2020-08-05 02:40:00 --> Severity: Parsing Error --> syntax error, unexpected '<' /home/ssc/metalsindo_dev/application/modules/inventory_4/controllers/Inventory_4.php 231
ERROR - 2020-08-05 02:42:57 --> Query error: Unknown column 'safety_stock' in 'field list' - Invalid query: INSERT INTO `ms_inventory_category3` (`id_category3`, `id_type`, `id_category1`, `id_category2`, `nama`, `maker`, `hardness`, `density`, `id_bentuk`, `id_surface`, `safety_stock`, `mountly_forecast`, `order_point`, `max_stock`, `aktif`, `created_on`, `created_by`, `deleted`) VALUES ('I2000001', 'I2000001', 'I2000001', 'I2000006', 'horolled', 'CN', '60', '60', 'B2000001', 'I2000004', '12', '12', '12', '12', 'aktif', '2020-08-05 02:42:57', '1', '0')
ERROR - 2020-08-05 02:43:18 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/inventory_4/controllers/Inventory_4.php 205
ERROR - 2020-08-05 02:49:26 --> Query error: Unknown column 'jumlah_kandungan' in 'field list' - Invalid query: INSERT INTO `child_inven_compotition` (`id_compotition`, `id_category3`, `jumlah_kandungan`, `deleted`, `created_on`, `created_by`) VALUES ('9', 'I2000001', '10', '0', '2020-08-05 02:49:26', NULL)
ERROR - 2020-08-05 02:49:41 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/inventory_4/controllers/Inventory_4.php 205
ERROR - 2020-08-05 02:53:55 --> Query error: Unknown column 'jumlah_kandungan' in 'field list' - Invalid query: INSERT INTO `child_inven_compotition` (`id_compotition`, `id_category3`, `jumlah_kandungan`, `deleted`, `created_on`, `created_by`) VALUES ('9', 'I2000001', '90', '0', '2020-08-05 02:53:55', NULL)
ERROR - 2020-08-05 02:54:05 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/inventory_4/controllers/Inventory_4.php 205
ERROR - 2020-08-05 02:56:44 --> Query error: Unknown column 'jumlah_kandungan' in 'field list' - Invalid query: INSERT INTO `child_inven_compotition` (`id_compotition`, `id_category3`, `jumlah_kandungan`, `deleted`, `created_on`, `created_by`) VALUES ('9', 'I2000001', '90', '0', '2020-08-05 02:56:44', '1')
ERROR - 2020-08-05 02:58:56 --> Query error: Unknown column 'jumlah_kandungan' in 'field list' - Invalid query: INSERT INTO `child_inven_compotition` (`id_compotition`, `id_category3`, `jumlah_kandungan`, `deleted`, `created_on`, `created_by`) VALUES ('9', 'I2000001', '89', '0', '2020-08-05 02:58:55', '1')
ERROR - 2020-08-05 02:59:02 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/inventory_4/controllers/Inventory_4.php 205
ERROR - 2020-08-05 03:09:14 --> Query error: Unknown column 'jumlah_kandungan' in 'field list' - Invalid query: INSERT INTO `child_inven_compotition` (`id_compotition`, `id_category3`, `jumlah_kandungan`, `deleted`, `created_on`, `created_by`) VALUES ('9', 'I2000001', '11', '0', '2020-08-05 03:09:14', '1')
ERROR - 2020-08-05 03:09:23 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/inventory_4/controllers/Inventory_4.php 205
ERROR - 2020-08-05 03:22:15 --> Query error: Unknown column 'jumlah_kandungan' in 'field list' - Invalid query: INSERT INTO `child_inven_compotition` (`id_compotition`, `id_category3`, `jumlah_kandungan`, `deleted`, `created_on`, `created_by`) VALUES ('9', 'I2000001', '10', '0', '2020-08-05 03:22:15', '1')
ERROR - 2020-08-05 03:22:49 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/inventory_4/controllers/Inventory_4.php 204
ERROR - 2020-08-05 03:31:49 --> Query error: Unknown column 'jumlah_kandungan' in 'field list' - Invalid query: INSERT INTO `child_inven_compotition` (`id_compotition`, `id_category3`, `jumlah_kandungan`, `deleted`, `created_on`, `created_by`) VALUES ('9', 'I2000001', '10', '0', '2020-08-05 03:31:49', '1')
ERROR - 2020-08-05 03:32:22 --> Query error: Unknown column 'jumlah_kandungan' in 'field list' - Invalid query: INSERT INTO `child_inven_compotition` (`id_compotition`, `id_category3`, `jumlah_kandungan`, `deleted`, `created_on`, `created_by`) VALUES ('9', 'I2000001', '', '0', '2020-08-05 03:32:22', '1')
ERROR - 2020-08-05 03:32:47 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/inventory_4/controllers/Inventory_4.php 204
ERROR - 2020-08-05 03:35:48 --> 404 Page Not Found: /index
ERROR - 2020-08-05 03:37:33 --> Query error: Unknown column 'jumlah_kandungan' in 'field list' - Invalid query: INSERT INTO `child_inven_compotition` (`id_compotition`, `id_category3`, `jumlah_kandungan`, `deleted`, `created_on`, `created_by`) VALUES ('9', 'I2000001', '1', '0', '2020-08-05 03:37:33', '1')
ERROR - 2020-08-05 03:48:46 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/inventory_4/controllers/Inventory_4.php 204
ERROR - 2020-08-05 03:51:10 --> Severity: Parsing Error --> syntax error, unexpected 'if' (T_IF), expecting function (T_FUNCTION) /home/ssc/metalsindo_dev/application/modules/inventory_4/controllers/Inventory_4.php 232
ERROR - 2020-08-05 03:53:18 --> Query error: Unknown column 'jumlah_kandungan' in 'field list' - Invalid query: INSERT INTO `child_inven_compotition` (`id_compotition`, `id_category3`, `jumlah_kandungan`, `deleted`, `created_on`, `created_by`) VALUES ('9', 'I2000001', '10', '0', '2020-08-05 03:53:18', NULL)
ERROR - 2020-08-05 04:11:15 --> 404 Page Not Found: ../modules/inventory_4/controllers//index
ERROR - 2020-08-05 04:11:43 --> 404 Page Not Found: ../modules/inventory_4/controllers//index
ERROR - 2020-08-05 04:12:36 --> Severity: error --> Exception: Unable to locate the model you have specified: Inventory_4_model /home/ssc/metalsindo_dev/system/core/Loader.php 344
ERROR - 2020-08-05 04:12:55 --> Severity: Error --> Call to a member function get_data() on null /home/ssc/metalsindo_dev/application/modules/inventory_4/controllers/Inventory_4.php 42
ERROR - 2020-08-05 04:14:54 --> 404 Page Not Found: ../modules/inventory_4/controllers/Inventory_4/addInventory
ERROR - 2020-08-05 04:54:46 --> Severity: Parsing Error --> syntax error, unexpected ';', expecting ')' /home/ssc/metalsindo_dev/application/modules/inventory_4/controllers/Inventory_4.php 216
ERROR - 2020-08-05 04:56:19 --> Query error: Unknown column 'id_supplier' in 'field list' - Invalid query: INSERT INTO `child_inven_suplier` (`id_category3`, `id_supplier`, `lead`, `min_order`, `deleted`, `created_on`, `created_by`) VALUES ('I2000001', 'CR0001', '12', '12', '0', '2020-08-05 04:56:19', '1')
ERROR - 2020-08-05 04:56:43 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/inventory_4/controllers/Inventory_4.php 198
ERROR - 2020-08-05 04:59:59 --> Query error: Unknown column 'id_supplier' in 'field list' - Invalid query: INSERT INTO `child_inven_suplier` (`id_category3`, `id_supplier`, `lead`, `min_order`, `deleted`, `created_on`, `created_by`) VALUES ('I2000001', 'CR0001', '11', '11', '0', '2020-08-05 04:59:59', '1')
ERROR - 2020-08-05 05:03:03 --> Query error: Unknown column 'id_supplier' in 'field list' - Invalid query: INSERT INTO `child_inven_suplier` (`id_category3`, `id_supplier`, `lead`, `min_order`, `deleted`, `created_on`, `created_by`) VALUES ('I2000001', 'CR0001', '12', '12', '0', '2020-08-05 05:03:03', '1')
ERROR - 2020-08-05 05:03:26 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/inventory_4/controllers/Inventory_4.php 197
ERROR - 2020-08-05 05:13:01 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/inventory_4/controllers/Inventory_4.php 197
ERROR - 2020-08-05 05:23:33 --> Query error: Unknown column 'id_supplier' in 'field list' - Invalid query: INSERT INTO `child_inven_suplier` (`id_category3`, `id_supplier`, `lead`, `minimum`, `deleted`, `created_on`, `created_by`) VALUES ('I2000001', 'CR0001', '12', '12', '0', '2020-08-05 05:23:33', '1')
ERROR - 2020-08-05 05:23:52 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/inventory_4/controllers/Inventory_4.php 197
ERROR - 2020-08-05 05:27:25 --> Query error: Unknown column 'id_supplier' in 'field list' - Invalid query: INSERT INTO `child_inven_suplier` (`id_category3`, `id_supplier`, `lead`, `minimum`, `deleted`, `created_on`, `created_by`) VALUES ('I2000001', 'CR0001', '12', '12', '0', '2020-08-05 05:27:25', '1')
ERROR - 2020-08-05 05:28:23 --> Query error: Unknown column 'id_supplier' in 'field list' - Invalid query: INSERT INTO `child_inven_suplier` (`id_category3`, `id_supplier`, `lead`, `minimum`, `deleted`, `created_on`, `created_by`) VALUES ('I2000001', 'CR0002', '11', '90', '0', '2020-08-05 05:28:23', '1')
ERROR - 2020-08-05 05:28:35 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/inventory_4/controllers/Inventory_4.php 197
ERROR - 2020-08-05 05:28:46 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/inventory_4/controllers/Inventory_4.php 197
ERROR - 2020-08-05 05:29:17 --> Query error: Unknown column 'id_supplier' in 'field list' - Invalid query: INSERT INTO `child_inven_suplier` (`id_category3`, `id_supplier`, `lead`, `minimum`, `deleted`, `created_on`, `created_by`) VALUES ('I2000001', 'CR0002', '11', '90', '0', '2020-08-05 05:29:16', '1')
ERROR - 2020-08-05 05:30:11 --> Query error: Unknown column 'id_supplier' in 'field list' - Invalid query: INSERT INTO `child_inven_suplier` (`id_category3`, `id_supplier`, `lead`, `minimum`, `deleted`, `created_on`, `created_by`) VALUES ('I2000001', 'CR0001', '78', '8', '0', '2020-08-05 05:30:11', '1')
ERROR - 2020-08-05 05:36:31 --> Query error: Unknown column 'id_supplier' in 'field list' - Invalid query: INSERT INTO `child_inven_suplier` (`id_category3`, `id_supplier`, `lead`, `minimum`, `deleted`, `created_on`, `created_by`) VALUES ('I2000001', 'CR0001', '878', '878', '0', '2020-08-05 05:36:31', '1')
ERROR - 2020-08-05 05:37:48 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/inventory_4/controllers/Inventory_4.php 197
ERROR - 2020-08-05 05:39:10 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/inventory_4/controllers/Inventory_4.php 198
ERROR - 2020-08-05 05:45:16 --> Query error: Unknown column 'max_stock' in 'field list' - Invalid query: INSERT INTO `ms_inventory_category3` (`id_category3`, `id_type`, `id_category1`, `id_category2`, `nama`, `maker`, `hardness`, `density`, `id_bentuk`, `id_surface`, `safety_stock`, `mountly_forecast`, `order_point`, `max_stock`, `aktif`, `created_on`, `created_by`, `deleted`) VALUES ('I2000002', 'I2000001', 'I2000001', 'I2000006', 'percobaan', '12', '12', '121', 'B2000003', 'I2000003', '12', '12', '12', '12', 'aktif', '2020-08-05 05:45:16', '1', '0')
ERROR - 2020-08-05 05:45:29 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/inventory_4/controllers/Inventory_4.php 206
ERROR - 2020-08-05 05:49:57 --> Query error: Unknown column 'id_supplier' in 'field list' - Invalid query: INSERT INTO `child_inven_suplier` (`id_category3`, `id_supplier`, `lead`, `minimum`, `deleted`, `created_on`, `created_by`) VALUES ('I2000002', 'CR0001', '12', '12', '0', '2020-08-05 05:49:57', '1')
ERROR - 2020-08-05 05:50:09 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/inventory_4/controllers/Inventory_4.php 198
ERROR - 2020-08-05 05:50:41 --> Query error: Unknown column 'id_supplier' in 'field list' - Invalid query: INSERT INTO `child_inven_suplier` (`id_category3`, `id_supplier`, `lead`, `minimum`, `deleted`, `created_on`, `created_by`) VALUES ('I2000002', 'CR0001', '12', '12', '0', '2020-08-05 05:50:41', '1')
ERROR - 2020-08-05 05:51:32 --> Query error: Unknown column 'id_supplier' in 'field list' - Invalid query: INSERT INTO `child_inven_suplier` (`id_category3`, `id_supplier`, `lead`, `minimum`, `deleted`, `created_on`, `created_by`) VALUES ('I2000002', 'CR0002', '78', '3223', '0', '2020-08-05 05:51:32', '1')
ERROR - 2020-08-05 06:25:37 --> Query error: Unknown column 'nilai' in 'field list' - Invalid query: INSERT INTO `child_inven_compotition` (`id_category3`, `id_compotition`, `nilai`, `deleted`, `created_on`, `created_by`) VALUES ('I2000005', '9', '89', '0', '2020-08-05 06:25:37', '1')
ERROR - 2020-08-05 07:04:36 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/inventory_4/views/edit_inventory.php 38
ERROR - 2020-08-05 07:04:36 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/inventory_4/views/edit_inventory.php 53
ERROR - 2020-08-05 07:26:33 --> Query error: Unknown column 'b.nm_compotition' in 'field list' - Invalid query: SELECT `a`.*, `b`.`nm_compotition` as `nm_compotition`
FROM `child_inven_compotition` `a`
JOIN `ms_compotition` `b` ON `b`.`id_compotition`=`a`.`id_compotition`
WHERE `a`.`deleted` = '0' and `a`.`id_category3` = 'I2000004'
ERROR - 2020-08-05 07:28:17 --> Query error: Unknown column 'b.nm_compotition' in 'field list' - Invalid query: SELECT `a`.*, `b`.`nm_compotition` as `nm_compotition`
FROM `child_inven_compotition` `a`
JOIN `ms_compotition` `b` ON `b`.`id_compotition`=`a`.`id_compotition`
WHERE `a`.`deleted` = '0' and `a`.`id_category3` = 'I2000004'
ERROR - 2020-08-05 07:35:10 --> Query error: Column 'deleted' in where clause is ambiguous - Invalid query: SELECT `a`.*, `b`.`name_compotition` as `name_compotition`
FROM `child_inven_compotition` `a`
JOIN `ms_compotition` `b` ON `b`.`id_compotition`=`a`.`id_compotition`
WHERE `deleted` = '0' and `id_category3` = 'I2000004'
ERROR - 2020-08-05 13:07:11 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-08-05 13:07:20 --> 404 Page Not Found: /index
ERROR - 2020-08-05 14:17:00 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-08-05 14:17:10 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-08-05 14:17:11 --> 404 Page Not Found: /index
ERROR - 2020-08-05 14:17:35 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-08-05 14:17:36 --> 404 Page Not Found: /index
ERROR - 2020-08-05 14:44:07 --> Severity: Compile Error --> Cannot redeclare Inventory_4::get_compotition() /home/ssc/metalsindo_dev/application/modules/inventory_4/controllers/Inventory_4.php 512
ERROR - 2020-08-05 14:44:18 --> Severity: Compile Error --> Cannot redeclare Inventory_4::get_compotition() /home/ssc/metalsindo_dev/application/modules/inventory_4/controllers/Inventory_4.php 512
ERROR - 2020-08-05 14:47:49 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-08-05 14:47:52 --> 404 Page Not Found: /index
ERROR - 2020-08-05 15:01:20 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-08-05 15:01:36 --> 404 Page Not Found: /index
ERROR - 2020-08-05 15:03:50 --> Severity: error --> Exception: Unable to locate the model you have specified: Supplier_model /home/ssc/metalsindo_dev/system/core/Loader.php 344
ERROR - 2020-08-05 15:04:04 --> 404 Page Not Found: /index
ERROR - 2020-08-05 15:39:09 --> Query error: Unknown column 'name_country' in 'where clause' - Invalid query: 
  			SELECT
  				*
  			FROM
  				master_country
  			WHERE 1=1
           AND activation = 'active' 
  				AND (
  				id_country LIKE '%%'
  				OR name_country LIKE '%%'
  	        )
  		
ERROR - 2020-08-05 15:39:39 --> Query error: Unknown column 'name_country' in 'where clause' - Invalid query: 
  			SELECT
  				*
  			FROM
  				master_country
  			WHERE 1=1
           AND activation = 'active' 
  				AND (
  				id_country LIKE '%%'
  				OR name_country LIKE '%%'
  	        )
  		
ERROR - 2020-08-05 15:55:21 --> 404 Page Not Found: ../modules/master_surface/controllers/Master_surface/viewSurface
ERROR - 2020-08-05 15:55:44 --> 404 Page Not Found: ../modules/master_surface/controllers/Master_surface/viewSurface
ERROR - 2020-08-05 16:03:36 --> 404 Page Not Found: ../modules/master_bentuk/controllers/Master_bentuk/saveEditbentuk
ERROR - 2020-08-05 16:04:07 --> 404 Page Not Found: ../modules/master_bentuk/controllers/Master_bentuk/saveEditbentuk
ERROR - 2020-08-05 16:07:09 --> 404 Page Not Found: ../modules/master_bentuk/controllers/Master_bentuk/saveEditbentuk
ERROR - 2020-08-05 16:07:35 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/material/views/index.php 31
ERROR - 2020-08-05 16:07:41 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/material/views/index.php 31
ERROR - 2020-08-05 16:07:42 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/material/views/index.php 31
ERROR - 2020-08-05 16:37:51 --> 404 Page Not Found: ../modules/inventory_4/controllers/Inventory_4/viewInventory
ERROR - 2020-08-05 16:38:16 --> 404 Page Not Found: ../modules/inventory_4/controllers/Inventory_4/viewInventory
ERROR - 2020-08-05 16:45:21 --> Query error: Unknown column 'id_category1' in 'field list' - Invalid query: INSERT INTO `ms_dimensi` (`id_category1`, `nm_dimensi`, `deleted`, `created_on`, `created_by`) VALUES ('B2000001', 'HARDNESS', '0', '2020-08-05 16:45:21', '1')
ERROR - 2020-08-05 16:48:14 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/material/views/index.php 31
ERROR - 2020-08-05 16:48:17 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/material/views/index.php 31
ERROR - 2020-08-05 16:49:12 --> Query error: Unknown column 'b.name_country' in 'field list' - Invalid query: 
  			SELECT
  				a.*, b.name_country
  			FROM
  				master_supplier a
  				LEFT JOIN master_country b ON b.id_country = a.id_country
  			WHERE 1=1
           AND a.activation = 'aktif' 
  				AND a.deleted ='N' AND (
  				a.id_supplier LIKE '%%'
  				OR a.nm_supplier LIKE '%%'
          OR b.name_country LIKE '%%'
  	        )
  		
ERROR - 2020-08-05 16:49:19 --> Query error: Unknown column 'b.name_country' in 'field list' - Invalid query: 
  			SELECT
  				a.*, b.name_country
  			FROM
  				master_supplier a
  				LEFT JOIN master_country b ON b.id_country = a.id_country
  			WHERE 1=1
           AND a.activation = 'aktif' 
  				AND a.deleted ='N' AND (
  				a.id_supplier LIKE '%%'
  				OR a.nm_supplier LIKE '%%'
          OR b.name_country LIKE '%%'
  	        )
  		
ERROR - 2020-08-05 16:49:20 --> Query error: Unknown column 'b.name_country' in 'field list' - Invalid query: 
  			SELECT
  				a.*, b.name_country
  			FROM
  				master_supplier a
  				LEFT JOIN master_country b ON b.id_country = a.id_country
  			WHERE 1=1
           AND a.activation = 'aktif' 
  				AND a.deleted ='N' AND (
  				a.id_supplier LIKE '%%'
  				OR a.nm_supplier LIKE '%%'
          OR b.name_country LIKE '%%'
  	        )
  		
ERROR - 2020-08-05 16:52:15 --> Severity: error --> Exception: Unable to locate the model you have specified: Master_model /home/ssc/metalsindo_dev/system/core/Loader.php 344
ERROR - 2020-08-05 17:11:30 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-08-05 17:11:31 --> 404 Page Not Found: /index
ERROR - 2020-08-05 23:23:25 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-08-05 23:23:26 --> 404 Page Not Found: /index
