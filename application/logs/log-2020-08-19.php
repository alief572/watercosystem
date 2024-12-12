<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-08-19 06:40:09 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-08-19 06:40:29 --> 404 Page Not Found: /index
ERROR - 2020-08-19 06:41:17 --> Severity: Error --> Call to undefined function history() /home/ssc/metalsindo_dev/application/modules/cycletime/controllers/Cycletime.php 35
ERROR - 2020-08-19 06:45:37 --> Severity: Error --> Call to undefined function get_name() /home/ssc/metalsindo_dev/application/modules/cycletime/views/index.php 45
ERROR - 2020-08-19 08:38:53 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-08-19 08:38:56 --> 404 Page Not Found: /index
ERROR - 2020-08-19 08:48:02 --> Severity: Error --> Call to undefined function history() /home/ssc/metalsindo_dev/application/modules/cycletime/controllers/Cycletime.php 35
ERROR - 2020-08-19 08:48:08 --> Severity: error --> Exception: Unable to locate the model you have specified: Master_model /home/ssc/metalsindo_dev/system/core/Loader.php 344
ERROR - 2020-08-19 08:48:15 --> Query error: Unknown column 'a.supplier_location' in 'where clause' - Invalid query: 
  			SELECT
  				a.*,b.name_category_supplier
  			FROM
                  master_supplier a
                  LEFT JOIN child_supplier_category b ON a.id_category_supplier = b.id_category_supplier
  			WHERE 1=1
           AND a.activation = 'active' 
				AND a.supplier_location ='local'
  				AND (
  				a.id_supplier LIKE '%%'
  				OR a.name_supplier LIKE '%%'
                OR a.address_office LIKE '%%'
                OR a.activation LIKE '%%'
                OR b.name_category_supplier LIKE '%%'
  	        )
  		
ERROR - 2020-08-19 08:48:15 --> Query error: Unknown column 'a.supplier_location' in 'where clause' - Invalid query: 
  			SELECT
  				a.*,b.name_category_supplier
  			FROM
                  master_supplier a
                  LEFT JOIN child_supplier_category b ON a.id_category_supplier = b.id_category_supplier
  			WHERE 1=1
           AND a.activation = 'active' 
				AND a.supplier_location ='international'
  				AND (
  				a.id_supplier LIKE '%%'
  				OR a.name_supplier LIKE '%%'
                OR a.address_office LIKE '%%'
                OR a.activation LIKE '%%'
                OR b.name_category_supplier LIKE '%%'
  	        )
  		
ERROR - 2020-08-19 08:48:25 --> Query error: Unknown column 'id_supplier' in 'where clause' - Invalid query: SELECT *
FROM `master_supplier`
WHERE `id_supplier` = ''
ERROR - 2020-08-19 08:49:30 --> Query error: Unknown column 'id_supplier' in 'where clause' - Invalid query: SELECT *
FROM `master_supplier`
WHERE `id_supplier` = ''
ERROR - 2020-08-19 08:49:51 --> Query error: Unknown column 'id_supplier' in 'where clause' - Invalid query: SELECT *
FROM `master_supplier`
WHERE `id_supplier` = ''
ERROR - 2020-08-19 08:50:08 --> 404 Page Not Found: ../modules/master_suplier/controllers/Master_suplier/viewLokal
ERROR - 2020-08-19 09:02:28 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-08-19 09:02:38 --> 404 Page Not Found: /index
ERROR - 2020-08-19 09:02:47 --> Severity: Error --> Call to undefined function history() /home/ssc/metalsindo_dev/application/modules/cycletime/controllers/Cycletime.php 35
ERROR - 2020-08-19 09:05:29 --> Severity: Error --> Call to undefined function get_name() /home/ssc/metalsindo_dev/application/modules/cycletime/views/index.php 45
ERROR - 2020-08-19 09:26:31 --> Severity: Notice --> Undefined property: CI::$get_cycletime_header /home/ssc/metalsindo_dev/system/core/Model.php 77
ERROR - 2020-08-19 09:26:41 --> Severity: Notice --> Undefined property: CI::$get_cycletime_header /home/ssc/metalsindo_dev/system/core/Model.php 77
ERROR - 2020-08-19 09:26:46 --> Severity: Notice --> Undefined property: CI::$get_cycletime_header /home/ssc/metalsindo_dev/system/core/Model.php 77
ERROR - 2020-08-19 09:26:49 --> Severity: Notice --> Undefined property: CI::$get_cycletime_header /home/ssc/metalsindo_dev/system/core/Model.php 77
ERROR - 2020-08-19 09:26:51 --> Severity: Notice --> Undefined property: CI::$get_cycletime_header /home/ssc/metalsindo_dev/system/core/Model.php 77
ERROR - 2020-08-19 09:26:56 --> Severity: Notice --> Undefined property: CI::$get_cycletime_header /home/ssc/metalsindo_dev/system/core/Model.php 77
ERROR - 2020-08-19 09:27:00 --> Severity: Notice --> Undefined property: CI::$get_cycletime_header /home/ssc/metalsindo_dev/system/core/Model.php 77
ERROR - 2020-08-19 09:27:03 --> Severity: Notice --> Undefined property: CI::$get_cycletime_header /home/ssc/metalsindo_dev/system/core/Model.php 77
ERROR - 2020-08-19 09:27:06 --> Severity: Notice --> Undefined property: CI::$get_cycletime_header /home/ssc/metalsindo_dev/system/core/Model.php 77
ERROR - 2020-08-19 09:28:13 --> Severity: Error --> Call to undefined method Cycletime_model::get_cycleheader() /home/ssc/metalsindo_dev/application/modules/cycletime/controllers/Cycletime.php 34
ERROR - 2020-08-19 09:28:41 --> Query error: Column 'deleted' in where clause is ambiguous - Invalid query: SELECT `a`.*, `b`.`nama` as `nm_kategory`, `c`.`nm_lengkap` as `nm_users`
FROM `cycletime_header` `a`
JOIN `ms_inventory_category2` `b` ON `b`.`id_category2`=`a`.`id_product`
JOIN `users` `c` ON `c`.`id_user`=`a`.`created_by`
WHERE `deleted` = '0'
ERROR - 2020-08-19 09:32:22 --> Query error: Table 'metalsindo_db.ms_costcenter' doesn't exist - Invalid query: SELECT *
FROM `ms_costcenter`
WHERE `deleted` = '0'
ERROR - 2020-08-19 09:34:37 --> Query error: Table 'metalsindo_db.ms_process' doesn't exist - Invalid query: SELECT * FROM ms_process ORDER BY nm_process ASC 
ERROR - 2020-08-19 09:34:50 --> Query error: Table 'metalsindo_db.ms_process' doesn't exist - Invalid query: SELECT * FROM ms_process ORDER BY nm_process ASC 
ERROR - 2020-08-19 09:36:05 --> Query error: Table 'metalsindo_db.cycletime_detail_header' doesn't exist - Invalid query: INSERT INTO `cycletime_detail_header` (`costcenter`, `id_costcenter`, `id_time`, `machine`, `mould`) VALUES ('CC2000009','TM-2008001-01','TM-2008001','0','0')
ERROR - 2020-08-19 09:36:11 --> Severity: Notice --> Undefined index: Detail /home/ssc/metalsindo_dev/application/modules/cycletime/controllers/Cycletime.php 232
ERROR - 2020-08-19 09:36:11 --> Severity: Notice --> Undefined index: produk /home/ssc/metalsindo_dev/application/modules/cycletime/controllers/Cycletime.php 246
ERROR - 2020-08-19 09:36:11 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/cycletime/controllers/Cycletime.php 255
ERROR - 2020-08-19 09:36:11 --> Severity: Error --> Call to undefined function history() /home/ssc/metalsindo_dev/application/modules/cycletime/controllers/Cycletime.php 300
ERROR - 2020-08-19 09:39:09 --> Severity: Error --> Call to undefined function history() /home/ssc/metalsindo_dev/application/modules/cycletime/controllers/Cycletime.php 300
ERROR - 2020-08-19 09:39:14 --> Severity: Notice --> Undefined index: Detail /home/ssc/metalsindo_dev/application/modules/cycletime/controllers/Cycletime.php 232
ERROR - 2020-08-19 09:39:14 --> Severity: Notice --> Undefined index: produk /home/ssc/metalsindo_dev/application/modules/cycletime/controllers/Cycletime.php 246
ERROR - 2020-08-19 09:39:14 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/cycletime/controllers/Cycletime.php 255
ERROR - 2020-08-19 09:39:14 --> Severity: Error --> Call to undefined function history() /home/ssc/metalsindo_dev/application/modules/cycletime/controllers/Cycletime.php 300
ERROR - 2020-08-19 09:42:54 --> Severity: Notice --> Undefined index: Detail /home/ssc/metalsindo_dev/application/modules/cycletime/controllers/Cycletime.php 232
ERROR - 2020-08-19 09:42:54 --> Severity: Notice --> Undefined index: produk /home/ssc/metalsindo_dev/application/modules/cycletime/controllers/Cycletime.php 246
ERROR - 2020-08-19 09:42:54 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/cycletime/controllers/Cycletime.php 255
ERROR - 2020-08-19 09:42:54 --> Severity: Error --> Call to undefined function history() /home/ssc/metalsindo_dev/application/modules/cycletime/controllers/Cycletime.php 300
ERROR - 2020-08-19 09:44:05 --> Severity: Error --> Call to undefined function history() /home/ssc/metalsindo_dev/application/modules/cycletime/controllers/Cycletime.php 300
ERROR - 2020-08-19 09:44:12 --> Severity: Notice --> Undefined index: Detail /home/ssc/metalsindo_dev/application/modules/cycletime/controllers/Cycletime.php 232
ERROR - 2020-08-19 09:44:12 --> Severity: Notice --> Undefined index: produk /home/ssc/metalsindo_dev/application/modules/cycletime/controllers/Cycletime.php 246
ERROR - 2020-08-19 09:44:12 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/cycletime/controllers/Cycletime.php 255
ERROR - 2020-08-19 09:44:12 --> Severity: Error --> Call to undefined function history() /home/ssc/metalsindo_dev/application/modules/cycletime/controllers/Cycletime.php 300
ERROR - 2020-08-19 09:50:41 --> Severity: Parsing Error --> syntax error, unexpected 'public' (T_PUBLIC) /home/ssc/metalsindo_dev/application/modules/cycletime/controllers/Cycletime.php 304
ERROR - 2020-08-19 09:51:37 --> Severity: Notice --> Undefined property: CI::$get_cycleheader /home/ssc/metalsindo_dev/system/core/Model.php 77
ERROR - 2020-08-19 09:52:22 --> Severity: Notice --> Undefined property: CI::$get_cycleheader /home/ssc/metalsindo_dev/system/core/Model.php 77
ERROR - 2020-08-19 09:52:41 --> Severity: Notice --> Undefined property: CI::$get_cycleheader /home/ssc/metalsindo_dev/system/core/Model.php 77
ERROR - 2020-08-19 09:54:23 --> Severity: Notice --> Undefined index: detail /home/ssc/metalsindo_dev/application/modules/cycletime/controllers/Cycletime.php 262
ERROR - 2020-08-19 09:54:23 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/cycletime/controllers/Cycletime.php 262
ERROR - 2020-08-19 09:54:24 --> Could not find the language line "insert_batch() called with no data"
ERROR - 2020-08-19 09:54:29 --> Severity: Notice --> Undefined index: Detail /home/ssc/metalsindo_dev/application/modules/cycletime/controllers/Cycletime.php 232
ERROR - 2020-08-19 09:54:29 --> Severity: Notice --> Undefined index: produk /home/ssc/metalsindo_dev/application/modules/cycletime/controllers/Cycletime.php 246
ERROR - 2020-08-19 09:54:29 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/cycletime/controllers/Cycletime.php 255
ERROR - 2020-08-19 09:54:29 --> Severity: Error --> Call to undefined function history() /home/ssc/metalsindo_dev/application/modules/cycletime/controllers/Cycletime.php 300
ERROR - 2020-08-19 09:55:27 --> Severity: Notice --> Undefined index: detail /home/ssc/metalsindo_dev/application/modules/cycletime/controllers/Cycletime.php 262
ERROR - 2020-08-19 09:55:27 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/cycletime/controllers/Cycletime.php 262
ERROR - 2020-08-19 09:55:27 --> Could not find the language line "insert_batch() called with no data"
ERROR - 2020-08-19 09:55:31 --> Severity: Notice --> Undefined index: Detail /home/ssc/metalsindo_dev/application/modules/cycletime/controllers/Cycletime.php 232
ERROR - 2020-08-19 09:55:31 --> Severity: Notice --> Undefined index: produk /home/ssc/metalsindo_dev/application/modules/cycletime/controllers/Cycletime.php 246
ERROR - 2020-08-19 09:55:31 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/cycletime/controllers/Cycletime.php 255
ERROR - 2020-08-19 10:35:14 --> Severity: Notice --> Undefined index: Detail /home/ssc/metalsindo_dev/application/modules/cycletime/controllers/Cycletime.php 232
ERROR - 2020-08-19 10:35:14 --> Severity: Notice --> Undefined index: produk /home/ssc/metalsindo_dev/application/modules/cycletime/controllers/Cycletime.php 246
ERROR - 2020-08-19 10:35:14 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/cycletime/controllers/Cycletime.php 255
ERROR - 2020-08-19 10:42:34 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-08-19 10:42:34 --> 404 Page Not Found: /index
ERROR - 2020-08-19 10:43:05 --> Severity: error --> Exception: Unable to locate the model you have specified: Master_model /home/ssc/metalsindo_dev/system/core/Loader.php 344
ERROR - 2020-08-19 11:44:04 --> Severity: Parsing Error --> syntax error, unexpected '=' /home/ssc/metalsindo_dev/application/modules/cycletime/models/Cycletime_model.php 120
ERROR - 2020-08-19 11:44:52 --> Severity: Error --> Call to undefined function get_name() /home/ssc/metalsindo_dev/application/modules/cycletime/views/view.php 20
ERROR - 2020-08-19 11:47:02 --> Severity: Warning --> Missing argument 1 for Lme_model::getdthistory(), called in /home/ssc/metalsindo_dev/application/modules/harga_lme/controllers/Harga_lme.php on line 42 and defined /home/ssc/metalsindo_dev/application/modules/harga_lme/models/Lme_model.php 132
ERROR - 2020-08-19 11:48:26 --> Severity: Warning --> Missing argument 1 for Lme_model::getdthistory(), called in /home/ssc/metalsindo_dev/application/modules/harga_lme/controllers/Harga_lme.php on line 42 and defined /home/ssc/metalsindo_dev/application/modules/harga_lme/models/Lme_model.php 132
ERROR - 2020-08-19 11:50:51 --> Severity: Warning --> Missing argument 1 for Lme_model::getdthistory(), called in /home/ssc/metalsindo_dev/application/modules/harga_lme/controllers/Harga_lme.php on line 42 and defined /home/ssc/metalsindo_dev/application/modules/harga_lme/models/Lme_model.php 132
ERROR - 2020-08-19 12:31:37 --> Severity: Notice --> Undefined variable: datgroupmenu /home/ssc/metalsindo_dev/application/modules/menus/views/menus_form.php 70
ERROR - 2020-08-19 12:32:46 --> Severity: Notice --> Undefined variable: datgroupmenu /home/ssc/metalsindo_dev/application/modules/menus/views/menus_form.php 70
ERROR - 2020-08-19 12:37:20 --> Severity: Error --> Call to undefined method Lme_model::gethistory() /home/ssc/metalsindo_dev/application/modules/master_lme/controllers/Master_lme.php 42
ERROR - 2020-08-19 12:45:13 --> 404 Page Not Found: /index
ERROR - 2020-08-19 12:46:53 --> 404 Page Not Found: /index
ERROR - 2020-08-19 12:47:11 --> 404 Page Not Found: /index
ERROR - 2020-08-19 12:48:38 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/master_lme/views/updatelme.php 6
ERROR - 2020-08-19 12:48:38 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/master_lme/views/updatelme.php 130
ERROR - 2020-08-19 12:48:38 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/master_lme/views/updatelme.php 249
ERROR - 2020-08-19 12:53:48 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/master_lme/views/updatelme.php 31
ERROR - 2020-08-19 12:53:48 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/master_lme/views/updatelme.php 95
ERROR - 2020-08-19 12:53:48 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/master_lme/views/updatelme.php 112
ERROR - 2020-08-19 12:53:48 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/master_lme/views/updatelme.php 128
ERROR - 2020-08-19 12:56:44 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/master_lme/views/updatelme.php 31
ERROR - 2020-08-19 12:56:44 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/master_lme/views/updatelme.php 95
ERROR - 2020-08-19 12:56:44 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/master_lme/views/updatelme.php 112
ERROR - 2020-08-19 12:56:44 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/master_lme/views/updatelme.php 128
ERROR - 2020-08-19 12:57:32 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/master_lme/views/updatelme.php 31
ERROR - 2020-08-19 12:57:32 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/master_lme/views/updatelme.php 95
ERROR - 2020-08-19 12:57:32 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/master_lme/views/updatelme.php 112
ERROR - 2020-08-19 12:57:32 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/master_lme/views/updatelme.php 128
ERROR - 2020-08-19 14:09:32 --> Severity: Parsing Error --> syntax error, unexpected '{', expecting '(' /home/ssc/metalsindo_dev/application/modules/master_lme/controllers/Master_lme.php 436
ERROR - 2020-08-19 14:10:59 --> Query error: Table 'metalsindo_db.id_history_lme' doesn't exist - Invalid query: INSERT INTO `id_history_lme` (`id_history_lme`, `id_compotition`, `nominal`, `status`, `created_on`, `created_by`) VALUES ('LS2000004', '13', '1', '0', '2020-08-19 14:10:59', '1')
ERROR - 2020-08-19 14:11:09 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/master_lme/controllers/Master_lme.php 438
ERROR - 2020-08-19 14:25:05 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-08-19 14:25:06 --> 404 Page Not Found: /index
ERROR - 2020-08-19 14:35:53 --> 404 Page Not Found: ../modules/inventory_4/controllers/Inventory_4/viewInventory
ERROR - 2020-08-19 14:36:01 --> 404 Page Not Found: ../modules/inventory_4/controllers/Inventory_4/viewInventory
ERROR - 2020-08-19 14:36:27 --> 404 Page Not Found: ../modules/inventory_4/controllers/Inventory_4/viewInventory
ERROR - 2020-08-19 14:38:45 --> 404 Page Not Found: ../modules/inventory_4/controllers/Inventory_4/viewInventory
ERROR - 2020-08-19 15:18:38 --> 404 Page Not Found: ../modules/master_suplier/controllers/Master_suplier/viewLokal
ERROR - 2020-08-19 15:22:30 --> Query error: Unknown column 'deleted' in 'where clause' - Invalid query: SELECT *
FROM `child_supplier_category`
WHERE `deleted` = '0'
ERROR - 2020-08-19 15:22:32 --> Query error: Unknown column 'deleted' in 'where clause' - Invalid query: SELECT *
FROM `child_supplier_category`
WHERE `deleted` = '0'
ERROR - 2020-08-19 15:22:33 --> Query error: Unknown column 'deleted' in 'where clause' - Invalid query: SELECT *
FROM `child_supplier_category`
WHERE `deleted` = '0'
ERROR - 2020-08-19 15:22:41 --> Query error: Unknown column 'a.supplier_location' in 'where clause' - Invalid query: 
  			SELECT
  				a.*,b.name_category_supplier
  			FROM
                  master_supplier a
                  LEFT JOIN child_supplier_category b ON a.id_category_supplier = b.id_category_supplier
  			WHERE 1=1
           AND a.activation = 'active' 
				AND a.supplier_location ='local'
  				AND (
  				a.id_supplier LIKE '%%'
  				OR a.name_supplier LIKE '%%'
                OR a.address_office LIKE '%%'
                OR a.activation LIKE '%%'
                OR b.name_category_supplier LIKE '%%'
  	        )
  		
ERROR - 2020-08-19 15:22:41 --> Query error: Unknown column 'a.supplier_location' in 'where clause' - Invalid query: 
  			SELECT
  				a.*,b.name_category_supplier
  			FROM
                  master_supplier a
                  LEFT JOIN child_supplier_category b ON a.id_category_supplier = b.id_category_supplier
  			WHERE 1=1
           AND a.activation = 'active' 
				AND a.supplier_location ='international'
  				AND (
  				a.id_supplier LIKE '%%'
  				OR a.name_supplier LIKE '%%'
                OR a.address_office LIKE '%%'
                OR a.activation LIKE '%%'
                OR b.name_category_supplier LIKE '%%'
  	        )
  		
ERROR - 2020-08-19 22:31:47 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-08-19 22:31:58 --> 404 Page Not Found: /index
ERROR - 2020-08-19 22:32:09 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-08-19 22:32:18 --> 404 Page Not Found: /index
ERROR - 2020-08-19 22:32:21 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-08-19 22:32:22 --> 404 Page Not Found: /index
ERROR - 2020-08-19 22:33:08 --> Query error: Unknown column 'a.supplier_location' in 'where clause' - Invalid query: 
  			SELECT
  				a.*,b.name_category_supplier
  			FROM
                  master_supplier a
                  LEFT JOIN child_supplier_category b ON a.id_category_supplier = b.id_category_supplier
  			WHERE 1=1
           AND a.activation = 'active' 
				AND a.supplier_location ='local'
  				AND (
  				a.id_supplier LIKE '%%'
  				OR a.name_supplier LIKE '%%'
                OR a.address_office LIKE '%%'
                OR a.activation LIKE '%%'
                OR b.name_category_supplier LIKE '%%'
  	        )
  		
ERROR - 2020-08-19 22:33:11 --> Query error: Unknown column 'a.supplier_location' in 'where clause' - Invalid query: 
  			SELECT
  				a.*,b.name_category_supplier
  			FROM
                  master_supplier a
                  LEFT JOIN child_supplier_category b ON a.id_category_supplier = b.id_category_supplier
  			WHERE 1=1
           AND a.activation = 'active' 
				AND a.supplier_location ='international'
  				AND (
  				a.id_supplier LIKE '%%'
  				OR a.name_supplier LIKE '%%'
                OR a.address_office LIKE '%%'
                OR a.activation LIKE '%%'
                OR b.name_category_supplier LIKE '%%'
  	        )
  		
