<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-08-25 00:40:44 --> Severity: Parsing Error --> syntax error, unexpected 'foreach' (T_FOREACH), expecting '(' /home/ssc/metalsindo_dev/application/modules/master_customers/views/index.php 62
ERROR - 2020-08-25 01:07:22 --> Severity: Notice --> Undefined variable: datgroupmenu /home/ssc/metalsindo_dev/application/modules/menus/views/menus_form.php 70
ERROR - 2020-08-25 01:08:09 --> Severity: Notice --> Undefined variable: datgroupmenu /home/ssc/metalsindo_dev/application/modules/menus/views/menus_form.php 70
ERROR - 2020-08-25 01:08:31 --> Severity: Notice --> Undefined variable: datgroupmenu /home/ssc/metalsindo_dev/application/modules/menus/views/menus_form.php 70
ERROR - 2020-08-25 01:18:33 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-08-25 01:18:39 --> 404 Page Not Found: /index
ERROR - 2020-08-25 01:21:31 --> Query error: Unknown column 'a.supplier_location' in 'where clause' - Invalid query: 
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
  		
ERROR - 2020-08-25 01:21:34 --> Query error: Unknown column 'a.supplier_location' in 'where clause' - Invalid query: 
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
  		
ERROR - 2020-08-25 01:21:47 --> 404 Page Not Found: ../modules/master_suplier/controllers/Master_suplier/viewLokal
ERROR - 2020-08-25 01:23:40 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/master_customers/controllers/Master_customers.php 514
ERROR - 2020-08-25 01:41:30 --> Severity: Parsing Error --> syntax error, unexpected '"</option>"' (T_CONSTANT_ENCAPSED_STRING) /home/ssc/metalsindo_dev/application/modules/trans_inquiry/controllers/Trans_inquiry.php 946
ERROR - 2020-08-25 01:51:39 --> 404 Page Not Found: ../modules/trans_inquiry/controllers/Trans_inquiry/get_dimensi
ERROR - 2020-08-25 01:52:26 --> 404 Page Not Found: ../modules/trans_inquiry/controllers/Trans_inquiry/get_dimensi
ERROR - 2020-08-25 02:05:34 --> 404 Page Not Found: ../modules/trans_inquiry/controllers/Trans_inquiry/get_dimensi
ERROR - 2020-08-25 02:05:54 --> 404 Page Not Found: ../modules/trans_inquiry/controllers/Trans_inquiry/get_dimensi
ERROR - 2020-08-25 02:07:35 --> 404 Page Not Found: ../modules/trans_inquiry/controllers/Trans_inquiry/get_dimensi
ERROR - 2020-08-25 02:23:06 --> Query error: Unknown column 'B2000001' in 'where clause' - Invalid query: SELECT `a`.*, `b`.`nama` as `nama_type`, `c`.`nama` as `nama_category1`, `d`.`nama` as `nama_category2`
FROM `ms_inventory_category3` `a`
JOIN `ms_inventory_type` `b` ON `b`.`id_type`=`a`.`id_type`
JOIN `ms_inventory_category1` `c` ON `c`.`id_category1` =`a`.`id_category1`
JOIN `ms_inventory_category2` `d` ON `d`.`id_category2` =`a`.`id_category2`
WHERE `id_bentuk` = `B2000001` and `deleted` = '0'
ERROR - 2020-08-25 02:23:33 --> Query error: Column 'deleted' in where clause is ambiguous - Invalid query: SELECT `a`.*, `b`.`nama` as `nama_type`, `c`.`nama` as `nama_category1`, `d`.`nama` as `nama_category2`
FROM `ms_inventory_category3` `a`
JOIN `ms_inventory_type` `b` ON `b`.`id_type`=`a`.`id_type`
JOIN `ms_inventory_category1` `c` ON `c`.`id_category1` =`a`.`id_category1`
JOIN `ms_inventory_category2` `d` ON `d`.`id_category2` =`a`.`id_category2`
WHERE `id_bentuk` = 'B2000001' and `deleted` = '0'
ERROR - 2020-08-25 02:23:39 --> Query error: Column 'deleted' in where clause is ambiguous - Invalid query: SELECT `a`.*, `b`.`nama` as `nama_type`, `c`.`nama` as `nama_category1`, `d`.`nama` as `nama_category2`
FROM `ms_inventory_category3` `a`
JOIN `ms_inventory_type` `b` ON `b`.`id_type`=`a`.`id_type`
JOIN `ms_inventory_category1` `c` ON `c`.`id_category1` =`a`.`id_category1`
JOIN `ms_inventory_category2` `d` ON `d`.`id_category2` =`a`.`id_category2`
WHERE `id_bentuk` = 'B2000001' and `deleted` = '0'
ERROR - 2020-08-25 02:24:17 --> Query error: Unknown column 'b.nama' in 'field list' - Invalid query: SELECT `a`.*, `b`.`nama` as `nama_type`, `c`.`nama` as `nama_category1`, `d`.`nama` as `nama_category2`
FROM `child_inven_dimensi` `a`
JOIN `ms_dimensi` `b` ON `b`.`id_dimensi`=`a`.`id_dimensi`
WHERE `a`.`deleted` = '0'
ERROR - 2020-08-25 02:24:48 --> Query error: Unknown column 'b.nama' in 'field list' - Invalid query: SELECT `a`.*, `b`.`nama` as `nama_type`, `c`.`nama` as `nama_category1`, `d`.`nama` as `nama_category2`
FROM `child_inven_dimensi` `a`
JOIN `ms_dimensi` `b` ON `b`.`id_dimensi`=`a`.`id_dimensi`
WHERE `a`.`deleted` = '0'
ERROR - 2020-08-25 04:02:11 --> Severity: Notice --> Undefined variable: datgroupmenu /home/ssc/metalsindo_dev/application/modules/menus/views/menus_form.php 70
ERROR - 2020-08-25 04:02:34 --> Severity: Notice --> Undefined variable: datgroupmenu /home/ssc/metalsindo_dev/application/modules/menus/views/menus_form.php 70
ERROR - 2020-08-25 04:03:32 --> Severity: Notice --> Undefined variable: datgroupmenu /home/ssc/metalsindo_dev/application/modules/menus/views/menus_form.php 70
ERROR - 2020-08-25 04:03:48 --> Severity: Notice --> Undefined variable: datgroupmenu /home/ssc/metalsindo_dev/application/modules/menus/views/menus_form.php 70
ERROR - 2020-08-25 04:20:30 --> Severity: Notice --> Undefined variable: datgroupmenu /home/ssc/metalsindo_dev/application/modules/menus/views/menus_form.php 70
ERROR - 2020-08-25 04:43:46 --> Severity: Error --> Call to undefined method Inquiry_model::generate_no_inquiry() /home/ssc/metalsindo_dev/application/modules/transaksi_inquiry/controllers/Transaksi_inquiry.php 172
ERROR - 2020-08-25 04:47:39 --> Severity: Parsing Error --> syntax error, unexpected ')', expecting ']' /home/ssc/metalsindo_dev/application/modules/transaksi_inquiry/controllers/Transaksi_inquiry.php 182
ERROR - 2020-08-25 04:48:23 --> Severity: Error --> Call to undefined method Inquiry_model::generate_no_inquiry() /home/ssc/metalsindo_dev/application/modules/transaksi_inquiry/controllers/Transaksi_inquiry.php 171
ERROR - 2020-08-25 04:48:36 --> Severity: Error --> Call to undefined method Inquiry_model::generate_no_inquiry() /home/ssc/metalsindo_dev/application/modules/transaksi_inquiry/controllers/Transaksi_inquiry.php 171
ERROR - 2020-08-25 05:10:31 --> Query error: Unknown column 'a.supplier_location' in 'where clause' - Invalid query: 
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
  		
ERROR - 2020-08-25 05:10:31 --> Query error: Unknown column 'a.supplier_location' in 'where clause' - Invalid query: 
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
  		
ERROR - 2020-08-25 05:17:11 --> 404 Page Not Found: ../modules/transaksi_inquiry/controllers/Transaksi_inquiry/add_detail
ERROR - 2020-08-25 05:28:44 --> Severity: error --> Exception: Unable to locate the model you have specified: Master_model /home/ssc/metalsindo_dev/system/core/Loader.php 344
ERROR - 2020-08-25 05:38:00 --> 404 Page Not Found: /index
ERROR - 2020-08-25 05:40:22 --> 404 Page Not Found: ../modules/transaksi_inquiry/controllers/Transaksi_inquiry/add_detail
ERROR - 2020-08-25 07:35:29 --> 404 Page Not Found: /index
ERROR - 2020-08-25 07:36:12 --> 404 Page Not Found: /index
ERROR - 2020-08-25 07:42:49 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/transaksi_inquiry/views/detail.php 67
ERROR - 2020-08-25 07:42:49 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/transaksi_inquiry/views/detail.php 82
ERROR - 2020-08-25 07:44:31 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/transaksi_inquiry/views/detail.php 49
ERROR - 2020-08-25 07:44:31 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/transaksi_inquiry/views/detail.php 64
ERROR - 2020-08-25 07:45:28 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/transaksi_inquiry/views/detail.php 49
ERROR - 2020-08-25 07:45:28 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/transaksi_inquiry/views/detail.php 64
ERROR - 2020-08-25 08:57:58 --> Severity: Error --> Call to undefined method Inquiry_model::getroll() /home/ssc/metalsindo_dev/application/modules/transaksi_inquiry/controllers/Transaksi_inquiry.php 56
ERROR - 2020-08-25 09:12:26 --> Query error: Unknown column 'a.no_inquiry' in 'where clause' - Invalid query: SELECT `a`.*, `b`.`nm_bentuk` as `nm_bentuk`, `c`.`nama` as `nama_kategori3`, `c`.`nama` as `nama_kategori2`, `c`.`hardness` as `hardnessmt`
FROM `dt_inquery_transaksi` `a`
JOIN `ms_bentuk` `b` ON `b`.`id_bentuk`=`a`.`id_bentuk`
JOIN `ms_inventory_category3` `c` ON `c`.`id_category3`=`a`.`id_category3`
JOIN `ms_inventory_category2` `d` ON `d`.`id_category2`=`c`.`id_category2`
WHERE `a`.`no_inquiry` = 'IQ2008250002'
ERROR - 2020-08-25 09:12:38 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-08-25 09:12:43 --> 404 Page Not Found: /index
ERROR - 2020-08-25 09:29:52 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-08-25 09:29:54 --> 404 Page Not Found: /index
ERROR - 2020-08-25 09:33:51 --> 404 Page Not Found: ../modules/transaksi_inquiry/controllers/Transaksi_inquiry/addRoll
ERROR - 2020-08-25 09:33:54 --> 404 Page Not Found: ../modules/transaksi_inquiry/controllers/Transaksi_inquiry/addRoll
ERROR - 2020-08-25 10:02:19 --> Query error: Column 'deleted' in where clause is ambiguous - Invalid query: SELECT `a`.*, `b`.`nama` as `nama_type`
FROM `ms_inventory_category3` `a`
JOIN `ms_inventory_category2` `b` ON `b`.`id_category2`=`a`.`id_category2`
WHERE `deleted` = '0' and `id_bentuk` = 'B2000001'
ERROR - 2020-08-25 10:02:52 --> Query error: Column 'deleted' in where clause is ambiguous - Invalid query: SELECT `a`.*, `b`.`nama` as `nama_type`
FROM `ms_inventory_category3` `a`
JOIN `ms_inventory_category2` `b` ON `b`.`id_category2`=`a`.`id_category2`
WHERE `deleted` = '0' and `id_bentuk` = 'B2000001'
ERROR - 2020-08-25 10:03:07 --> Query error: Column 'deleted' in where clause is ambiguous - Invalid query: SELECT `a`.*, `b`.`nama` as `nama_type`
FROM `ms_inventory_category3` `a`
JOIN `ms_inventory_category2` `b` ON `b`.`id_category2`=`a`.`id_category2`
WHERE `deleted` = '0' and `id_bentuk` = 'B2000001'
ERROR - 2020-08-25 10:03:48 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/transaksi_inquiry/views/AddRoll.php 60
ERROR - 2020-08-25 10:11:57 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/transaksi_inquiry/views/AddRoll.php 65
ERROR - 2020-08-25 10:14:06 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/transaksi_inquiry/views/AddRoll.php 6
ERROR - 2020-08-25 10:14:06 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/transaksi_inquiry/views/AddRoll.php 66
ERROR - 2020-08-25 10:14:55 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/transaksi_inquiry/views/AddRoll.php 65
ERROR - 2020-08-25 10:15:48 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/transaksi_inquiry/views/AddRoll.php 65
ERROR - 2020-08-25 10:19:29 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/transaksi_inquiry/views/AddRoll.php 65
ERROR - 2020-08-25 10:19:46 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/transaksi_inquiry/views/AddRoll.php 65
ERROR - 2020-08-25 10:45:45 --> 404 Page Not Found: ../modules/transaksi_inquiry/controllers/Transaksi_inquiry/cari_density
ERROR - 2020-08-25 11:16:20 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-08-25 11:16:23 --> 404 Page Not Found: /index
ERROR - 2020-08-25 11:46:30 --> 404 Page Not Found: ../modules/transaksi_inquiry/controllers/Transaksi_inquiry/cari_density
ERROR - 2020-08-25 11:54:54 --> Severity: Notice --> Undefined variable: datgroupmenu /home/ssc/metalsindo_dev/application/modules/menus/views/menus_form.php 70
ERROR - 2020-08-25 12:04:47 --> Severity: Notice --> Undefined variable: datgroupmenu /home/ssc/metalsindo_dev/application/modules/menus/views/menus_form.php 70
ERROR - 2020-08-25 12:05:09 --> Severity: Notice --> Undefined variable: datgroupmenu /home/ssc/metalsindo_dev/application/modules/menus/views/menus_form.php 70
ERROR - 2020-08-25 12:05:36 --> Severity: Notice --> Undefined variable: datgroupmenu /home/ssc/metalsindo_dev/application/modules/menus/views/menus_form.php 70
ERROR - 2020-08-25 12:05:57 --> Severity: Notice --> Undefined variable: datgroupmenu /home/ssc/metalsindo_dev/application/modules/menus/views/menus_form.php 70
ERROR - 2020-08-25 12:06:12 --> Severity: Notice --> Undefined variable: datgroupmenu /home/ssc/metalsindo_dev/application/modules/menus/views/menus_form.php 70
ERROR - 2020-08-25 12:28:25 --> Severity: Parsing Error --> syntax error, unexpected 'public' (T_PUBLIC) /home/ssc/metalsindo_dev/application/modules/master_customers/models/Customer_model.php 123
ERROR - 2020-08-25 12:28:59 --> Severity: Parsing Error --> syntax error, unexpected end of file, expecting function (T_FUNCTION) /home/ssc/metalsindo_dev/application/modules/master_customers/models/Customer_model.php 178
ERROR - 2020-08-25 13:39:43 --> 404 Page Not Found: ../modules/master_suplier/controllers/Master_suplier/viewLokal
ERROR - 2020-08-25 13:39:45 --> 404 Page Not Found: ../modules/master_suplier/controllers/Master_suplier/viewLokal
ERROR - 2020-08-25 13:48:26 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/transaksi_inquiry/views/AddRoll.php 337
ERROR - 2020-08-25 14:00:11 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/master_customers/views/edit_customer.php 246
ERROR - 2020-08-25 14:12:57 --> Severity: Parsing Error --> syntax error, unexpected '.' /home/ssc/metalsindo_dev/application/modules/master_customers/views/edit_customer.php 250
ERROR - 2020-08-25 14:13:37 --> Severity: Parsing Error --> syntax error, unexpected '.' /home/ssc/metalsindo_dev/application/modules/master_customers/views/edit_customer.php 250
ERROR - 2020-08-25 14:14:23 --> Severity: Parsing Error --> syntax error, unexpected '' (T_ENCAPSED_AND_WHITESPACE), expecting identifier (T_STRING) or variable (T_VARIABLE) or number (T_NUM_STRING) /home/ssc/metalsindo_dev/application/modules/master_customers/views/edit_customer.php 252
ERROR - 2020-08-25 14:14:53 --> Severity: Parsing Error --> syntax error, unexpected '' (T_ENCAPSED_AND_WHITESPACE), expecting identifier (T_STRING) or variable (T_VARIABLE) or number (T_NUM_STRING) /home/ssc/metalsindo_dev/application/modules/master_customers/views/edit_customer.php 252
ERROR - 2020-08-25 14:21:15 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-08-25 14:21:16 --> 404 Page Not Found: /index
ERROR - 2020-08-25 14:22:54 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/master_customers/controllers/Master_customers.php 516
ERROR - 2020-08-25 14:57:19 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-08-25 14:57:20 --> 404 Page Not Found: /index
ERROR - 2020-08-25 16:51:50 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-08-25 16:51:57 --> 404 Page Not Found: /index
ERROR - 2020-08-25 16:52:43 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-08-25 16:52:46 --> 404 Page Not Found: /index
ERROR - 2020-08-25 17:04:47 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-08-25 17:04:52 --> 404 Page Not Found: /index
ERROR - 2020-08-25 17:09:25 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-08-25 17:09:26 --> 404 Page Not Found: /index
