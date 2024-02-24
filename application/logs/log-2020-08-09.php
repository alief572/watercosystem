<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-08-09 00:59:15 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-08-09 00:59:17 --> 404 Page Not Found: /index
ERROR - 2020-08-09 01:03:01 --> Severity: Error --> Call to a member function get_data() on null /home/ssc/metalsindo_dev/application/modules/master_suplier/controllers/Master_suplier.php 86
ERROR - 2020-08-09 01:23:00 --> Query error: Table 'metalsindo_db.child_supplier_categoryactivation' doesn't exist - Invalid query: SELECT *
FROM `child_supplier_categoryactivation`
ERROR - 2020-08-09 04:28:30 --> Query error: Unknown column 'id_categorry_supplier' in 'field list' - Invalid query: SELECT MAX(id_categorry_supplier) as max_id FROM child_supplier_category
ERROR - 2020-08-09 05:15:47 --> 404 Page Not Found: /index
ERROR - 2020-08-09 05:16:10 --> 404 Page Not Found: /index
ERROR - 2020-08-09 05:24:28 --> 404 Page Not Found: /index
ERROR - 2020-08-09 08:53:11 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-08-09 08:53:28 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-08-09 08:53:29 --> 404 Page Not Found: /index
ERROR - 2020-08-09 09:05:17 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-08-09 09:05:22 --> 404 Page Not Found: /index
ERROR - 2020-08-09 09:07:02 --> Severity: Parsing Error --> syntax error, unexpected ''0'' (T_CONSTANT_ENCAPSED_STRING) /home/ssc/metalsindo_dev/application/modules/master_rate/controllers/Master_rate.php 41
ERROR - 2020-08-09 09:13:31 --> 404 Page Not Found: ../modules/master_surface/controllers/Master_surface/viewSurface
ERROR - 2020-08-09 09:24:36 --> Severity: Error --> Call to a member function generate_type() on null /home/ssc/metalsindo_dev/application/modules/master_rate/controllers/Master_rate.php 168
ERROR - 2020-08-09 09:28:07 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/master_rate/views/add_rate.php 80
ERROR - 2020-08-09 09:31:55 --> Severity: Parsing Error --> syntax error, unexpected '{' /home/ssc/metalsindo_dev/application/modules/master_rate/controllers/Master_rate.php 93
ERROR - 2020-08-09 09:32:23 --> Severity: Parsing Error --> syntax error, unexpected '{' /home/ssc/metalsindo_dev/application/modules/master_rate/controllers/Master_rate.php 93
ERROR - 2020-08-09 09:53:25 --> Severity: Parsing Error --> syntax error, unexpected ';', expecting ')' /home/ssc/metalsindo_dev/application/modules/master_rate/controllers/Master_rate.php 213
ERROR - 2020-08-09 09:54:23 --> 404 Page Not Found: ../modules/inventory_4/controllers/Inventory_4/viewInventory
ERROR - 2020-08-09 10:23:44 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/material/views/index.php 31
ERROR - 2020-08-09 10:50:02 --> Query error: Unknown column 'name_country' in 'where clause' - Invalid query: 
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
  		
ERROR - 2020-08-09 13:35:27 --> Severity: Parsing Error --> syntax error, unexpected '[', expecting '(' /home/ssc/metalsindo_dev/application/modules/master_rate/controllers/Master_rate.php 209
ERROR - 2020-08-09 13:37:03 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-08-09 13:37:05 --> 404 Page Not Found: /index
ERROR - 2020-08-09 13:37:50 --> 404 Page Not Found: ../modules/master_rate/controllers/Master_rate/EditRate
ERROR - 2020-08-09 13:47:42 --> Query error: Column 'deleted' in where clause is ambiguous - Invalid query: SELECT `a`.*, `b`.`type_rate` as `type_rate`
FROM `ms_rate` `a`
JOIN `ms_type_rate` `b` ON `b`.`id_type_rate`=`a`.`id_type_rate`
WHERE `deleted` = '0' and `id_rate` = '1'
ERROR - 2020-08-09 13:47:52 --> Query error: Column 'deleted' in where clause is ambiguous - Invalid query: SELECT `a`.*, `b`.`type_rate` as `type_rate`
FROM `ms_rate` `a`
JOIN `ms_type_rate` `b` ON `b`.`id_type_rate`=`a`.`id_type_rate`
WHERE `deleted` = '0' and `id_rate` = '1'
ERROR - 2020-08-09 13:48:23 --> Query error: Column 'deleted' in where clause is ambiguous - Invalid query: SELECT `a`.*, `b`.`type_rate` as `type_rate`
FROM `ms_rate` `a`
JOIN `ms_type_rate` `b` ON `b`.`id_type_rate`=`a`.`id_type_rate`
WHERE `deleted` = '0' and `id_rate` = '1'
ERROR - 2020-08-09 13:48:30 --> Query error: Column 'deleted' in where clause is ambiguous - Invalid query: SELECT `a`.*, `b`.`type_rate` as `type_rate`
FROM `ms_rate` `a`
JOIN `ms_type_rate` `b` ON `b`.`id_type_rate`=`a`.`id_type_rate`
WHERE `deleted` = '0' and `id_rate` = ''
ERROR - 2020-08-09 13:49:32 --> Query error: Column 'deleted' in where clause is ambiguous - Invalid query: SELECT `a`.*, `b`.`type_rate` as `type_rate`
FROM `ms_rate` `a`
JOIN `ms_type_rate` `b` ON `b`.`id_type_rate`=`a`.`id_type_rate`
WHERE `deleted` = '0' and `id_rate` = 1
ERROR - 2020-08-09 13:49:38 --> Query error: Column 'deleted' in where clause is ambiguous - Invalid query: SELECT `a`.*, `b`.`type_rate` as `type_rate`
FROM `ms_rate` `a`
JOIN `ms_type_rate` `b` ON `b`.`id_type_rate`=`a`.`id_type_rate`
WHERE `deleted` = '0' and `id_rate` IS NULL
ERROR - 2020-08-09 13:50:55 --> Query error: Column 'deleted' in where clause is ambiguous - Invalid query: SELECT `a`.*, `b`.`type_rate` as `type_rate`
FROM `ms_rate` `a`
JOIN `ms_type_rate` `b` ON `b`.`id_type_rate`=`a`.`id_type_rate`
WHERE `deleted` = '0' and `id_rate` = '1'
ERROR - 2020-08-09 13:55:16 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/master_rate/views/view_rate.php 72
ERROR - 2020-08-09 14:14:29 --> 404 Page Not Found: /index
ERROR - 2020-08-09 14:40:30 --> 404 Page Not Found: ../modules/master_rate/controllers/Master_rate/viewType
ERROR - 2020-08-09 14:41:04 --> Severity: Warning --> Missing argument 1 for Master_rate::EditType() /home/ssc/metalsindo_dev/application/modules/master_rate/controllers/Master_rate.php 65
ERROR - 2020-08-09 14:44:24 --> Severity: Warning --> Missing argument 1 for Master_rate::EditType() /home/ssc/metalsindo_dev/application/modules/master_rate/controllers/Master_rate.php 65
ERROR - 2020-08-09 14:44:53 --> Severity: Warning --> Missing argument 1 for Master_rate::EditType() /home/ssc/metalsindo_dev/application/modules/master_rate/controllers/Master_rate.php 65
ERROR - 2020-08-09 14:45:47 --> Severity: Warning --> Missing argument 1 for Master_rate::EditType() /home/ssc/metalsindo_dev/application/modules/master_rate/controllers/Master_rate.php 65
ERROR - 2020-08-09 14:48:49 --> 404 Page Not Found: ../modules/master_rate/controllers/Master_rate/viewType
ERROR - 2020-08-09 14:48:51 --> Severity: Warning --> Missing argument 1 for Master_rate::EditType() /home/ssc/metalsindo_dev/application/modules/master_rate/controllers/Master_rate.php 65
ERROR - 2020-08-09 14:49:11 --> Severity: Warning --> Missing argument 1 for Master_rate::EditType() /home/ssc/metalsindo_dev/application/modules/master_rate/controllers/Master_rate.php 65
ERROR - 2020-08-09 14:49:20 --> Severity: Warning --> Missing argument 1 for Master_rate::EditType() /home/ssc/metalsindo_dev/application/modules/master_rate/controllers/Master_rate.php 65
ERROR - 2020-08-09 14:49:24 --> Severity: Warning --> Missing argument 1 for Master_rate::EditType() /home/ssc/metalsindo_dev/application/modules/master_rate/controllers/Master_rate.php 65
ERROR - 2020-08-09 14:50:41 --> Severity: Warning --> Missing argument 1 for Master_rate::EditType() /home/ssc/metalsindo_dev/application/modules/master_rate/controllers/Master_rate.php 65
ERROR - 2020-08-09 14:51:36 --> Severity: Warning --> Missing argument 1 for Master_rate::EditType() /home/ssc/metalsindo_dev/application/modules/master_rate/controllers/Master_rate.php 65
ERROR - 2020-08-09 14:54:02 --> Severity: Warning --> Missing argument 1 for Master_rate::EditType() /home/ssc/metalsindo_dev/application/modules/master_rate/controllers/Master_rate.php 67
ERROR - 2020-08-09 14:54:37 --> Severity: Warning --> Missing argument 1 for Master_rate::EditType() /home/ssc/metalsindo_dev/application/modules/master_rate/controllers/Master_rate.php 67
ERROR - 2020-08-09 14:55:57 --> Severity: Warning --> Missing argument 1 for Master_rate::EditType() /home/ssc/metalsindo_dev/application/modules/master_rate/controllers/Master_rate.php 67
ERROR - 2020-08-09 14:57:37 --> Severity: Warning --> Missing argument 1 for Master_rate::EditType() /home/ssc/metalsindo_dev/application/modules/master_rate/controllers/Master_rate.php 67
ERROR - 2020-08-09 14:58:20 --> Severity: Warning --> Missing argument 1 for Master_rate::EditType() /home/ssc/metalsindo_dev/application/modules/master_rate/controllers/Master_rate.php 67
ERROR - 2020-08-09 15:00:32 --> Severity: Warning --> Missing argument 1 for Master_rate::EditType() /home/ssc/metalsindo_dev/application/modules/master_rate/controllers/Master_rate.php 67
ERROR - 2020-08-09 15:02:20 --> Severity: Warning --> Missing argument 1 for Master_rate::EditType() /home/ssc/metalsindo_dev/application/modules/master_rate/controllers/Master_rate.php 67
ERROR - 2020-08-09 15:03:32 --> Severity: Warning --> Missing argument 1 for Master_rate::EditTypeRate() /home/ssc/metalsindo_dev/application/modules/master_rate/controllers/Master_rate.php 67
ERROR - 2020-08-09 15:26:39 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/master_suplier/views/add_local.php 15
ERROR - 2020-08-09 15:29:04 --> Severity: Error --> Call to a member function get_data_category1() on null /home/ssc/metalsindo_dev/application/modules/harga_lme/controllers/Harga_lme.php 42
ERROR - 2020-08-09 15:29:24 --> Severity: Error --> Call to a member function get_data_category1() on null /home/ssc/metalsindo_dev/application/modules/harga_lme/controllers/Harga_lme.php 42
ERROR - 2020-08-09 15:30:19 --> Severity: Error --> Call to a member function get_data() on null /home/ssc/metalsindo_dev/application/modules/harga_lme/controllers/Harga_lme.php 41
ERROR - 2020-08-09 15:31:25 --> Severity: Error --> Call to a member function get_data() on null /home/ssc/metalsindo_dev/application/modules/harga_lme/controllers/Harga_lme.php 41
ERROR - 2020-08-09 15:32:53 --> Severity: Error --> Call to a member function get_data() on null /home/ssc/metalsindo_dev/application/modules/harga_lme/controllers/Harga_lme.php 41
ERROR - 2020-08-09 18:11:23 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-08-09 18:13:51 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-08-09 18:14:06 --> 404 Page Not Found: /index
ERROR - 2020-08-09 18:15:57 --> Severity: Warning --> Missing argument 1 for Master_rate::EditTypeRate() /home/ssc/metalsindo_dev/application/modules/master_rate/controllers/Master_rate.php 67
ERROR - 2020-08-09 18:16:29 --> Query error: Unknown column 'name_country' in 'where clause' - Invalid query: 
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
  		
ERROR - 2020-08-09 18:17:42 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/master_suplier/views/add_local.php 15
ERROR - 2020-08-09 18:46:46 --> Severity: Parsing Error --> syntax error, unexpected '=>' (T_DOUBLE_ARROW), expecting ']' /home/ssc/metalsindo_dev/application/modules/harga_lme/controllers/Harga_lme.php 78
ERROR - 2020-08-09 18:47:52 --> Severity: Parsing Error --> syntax error, unexpected '=>' (T_DOUBLE_ARROW), expecting ']' /home/ssc/metalsindo_dev/application/modules/harga_lme/controllers/Harga_lme.php 78
ERROR - 2020-08-09 18:48:17 --> 404 Page Not Found: /index
ERROR - 2020-08-09 18:49:14 --> Query error: Unknown column 'id_users' in 'where clause' - Invalid query: SELECT *
FROM `users`
WHERE `id_users` = '1'
ERROR - 2020-08-09 18:49:37 --> Query error: Unknown column 'id_users' in 'where clause' - Invalid query: SELECT *
FROM `users`
WHERE `id_users` = '1'
ERROR - 2020-08-09 18:49:58 --> Query error: Unknown column 'id_users' in 'where clause' - Invalid query: SELECT *
FROM `users`
WHERE `id_users` = '1'
ERROR - 2020-08-09 18:50:16 --> Query error: Unknown column 'id_users' in 'where clause' - Invalid query: SELECT *
FROM `users`
WHERE `id_users` = '1'
ERROR - 2020-08-09 18:52:09 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/harga_lme/views/view_harga.php 47
ERROR - 2020-08-09 18:52:43 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/harga_lme/views/view_harga.php 47
ERROR - 2020-08-09 19:01:12 --> 404 Page Not Found: /index
ERROR - 2020-08-09 19:02:20 --> 404 Page Not Found: /index
ERROR - 2020-08-09 19:13:17 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/harga_lme/controllers/Harga_lme.php 245
ERROR - 2020-08-09 19:13:17 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/harga_lme/controllers/Harga_lme.php 258
ERROR - 2020-08-09 19:14:19 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/harga_lme/controllers/Harga_lme.php 245
ERROR - 2020-08-09 19:14:33 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/harga_lme/controllers/Harga_lme.php 245
ERROR - 2020-08-09 19:14:49 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/harga_lme/controllers/Harga_lme.php 245
ERROR - 2020-08-09 19:17:01 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/harga_lme/controllers/Harga_lme.php 244
ERROR - 2020-08-09 19:34:53 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/harga_lme/controllers/Harga_lme.php 244
ERROR - 2020-08-09 19:41:39 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/harga_lme/controllers/Harga_lme.php 244
ERROR - 2020-08-09 20:00:19 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/harga_lme/views/edit_harga.php 6
ERROR - 2020-08-09 20:00:19 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/harga_lme/views/edit_harga.php 46
ERROR - 2020-08-09 20:01:36 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/harga_lme/views/edit_harga.php 6
ERROR - 2020-08-09 20:01:36 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/harga_lme/views/edit_harga.php 46
ERROR - 2020-08-09 20:02:38 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/harga_lme/views/edit_harga.php 47
ERROR - 2020-08-09 20:03:10 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/harga_lme/views/edit_harga.php 47
ERROR - 2020-08-09 20:03:26 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/harga_lme/views/edit_harga.php 44
ERROR - 2020-08-09 20:12:36 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/harga_lme/controllers/Harga_lme.php 244
ERROR - 2020-08-09 20:15:27 --> 404 Page Not Found: ../modules/harga_lme/controllers/Harga_lme/SaveEditHarga
ERROR - 2020-08-09 20:16:03 --> 404 Page Not Found: ../modules/harga_lme/controllers/Harga_lme/SaveEditHarga
ERROR - 2020-08-09 20:16:08 --> 404 Page Not Found: ../modules/harga_lme/controllers/Harga_lme/SaveEditHarga
ERROR - 2020-08-09 20:27:16 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/harga_lme/controllers/Harga_lme.php 245
ERROR - 2020-08-09 20:27:20 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/harga_lme/controllers/Harga_lme.php 245
ERROR - 2020-08-09 20:27:21 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/harga_lme/controllers/Harga_lme.php 245
ERROR - 2020-08-09 20:27:23 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/harga_lme/controllers/Harga_lme.php 245
ERROR - 2020-08-09 23:27:31 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
