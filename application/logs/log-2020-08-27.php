<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-08-27 00:01:12 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-08-27 00:01:14 --> 404 Page Not Found: /index
ERROR - 2020-08-27 00:01:23 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-08-27 00:01:26 --> 404 Page Not Found: /index
ERROR - 2020-08-27 02:17:19 --> Severity: Parsing Error --> syntax error, unexpected ',' /home/ssc/metalsindo_dev/application/modules/transaksi_inquiry/controllers/Transaksi_inquiry.php 302
ERROR - 2020-08-27 02:22:27 --> Severity: Parsing Error --> syntax error, unexpected ',' /home/ssc/metalsindo_dev/application/modules/transaksi_inquiry/controllers/Transaksi_inquiry.php 302
ERROR - 2020-08-27 03:58:57 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/transaksi_inquiry/views/AddRoll.php 47
ERROR - 2020-08-27 03:58:57 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/transaksi_inquiry/views/AddRoll.php 62
ERROR - 2020-08-27 03:59:58 --> Severity: Compile Error --> Cannot redeclare Transaksi_inquiry::addInquiry() /home/ssc/metalsindo_dev/application/modules/transaksi_inquiry/controllers/Transaksi_inquiry.php 118
ERROR - 2020-08-27 04:07:18 --> Severity: Error --> Call to undefined method Inquiry_model::CariInquiry() /home/ssc/metalsindo_dev/application/modules/transaksi_inquiry/controllers/Transaksi_inquiry.php 42
ERROR - 2020-08-27 04:08:16 --> Severity: Error --> Call to undefined method Inquiry_model::CariInquiry() /home/ssc/metalsindo_dev/application/modules/transaksi_inquiry/controllers/Transaksi_inquiry.php 42
ERROR - 2020-08-27 04:12:42 --> Query error: Unknown column 'a.deleted' in 'where clause' - Invalid query: SELECT `a`.*, `b`.`name_customer` as `name_customer`, `c`.`nama_karyawan` as `nama_karyawan`
FROM `tr_inquiry` `a`
JOIN `master_customers` `b` ON `b`.`id_customer`=`a`.`id_customer`
JOIN `ms_karyawan` `c` ON `c`.`id_karyawan`=`a`.`id_sales`
WHERE `a`.`deleted` = '0'
ERROR - 2020-08-27 04:34:15 --> Query error: Table 'metalsindo_db.dt_inquery_transasi' doesn't exist - Invalid query: INSERT INTO `dt_inquery_transasi` (`id_dt_inquery`, `no_inquery`, `id_bentuk`, `id_category3`, `thickness`, `density`, `dimensi1`, `berat_produk`, `qty_order`, `total_berat`, `rerata`, `target_harga`, `master_sample`, `mill_sheet`, `toleransi1max`, `toleransi1min`, `toleransi2max`, `toleransi2min`, `burry`, `sambungan`, `inner_diametermax`, `inner_diametermin`, `outer_diameter`, `apperance`, `maxjoin`, `deleted`, `created_on`, `created_by`) VALUES ('D2000001', 'IQ2008250003', 'B2000001', 'I2000001', '0.5', '7.93', '12', '47.58', '12', '570.96', '89', '89', 'Yes', 'Yes', '89', '89', '89', NULL, '98', 'Tidak Boleh Sambung atau Join', '89', '89', '9', '89', '89', '0', '2020-08-27 04:34:15', '1')
ERROR - 2020-08-27 04:34:42 --> Query error: Table 'metalsindo_db.dt_inquery_transasi' doesn't exist - Invalid query: INSERT INTO `dt_inquery_transasi` (`id_dt_inquery`, `no_inquery`, `id_bentuk`, `id_category3`, `thickness`, `density`, `dimensi1`, `berat_produk`, `qty_order`, `total_berat`, `rerata`, `target_harga`, `master_sample`, `mill_sheet`, `toleransi1max`, `toleransi1min`, `toleransi2max`, `toleransi2min`, `burry`, `sambungan`, `inner_diametermax`, `inner_diametermin`, `outer_diameter`, `apperance`, `maxjoin`, `deleted`, `created_on`, `created_by`) VALUES ('D2000001', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2020-08-27 04:34:42', '1')
ERROR - 2020-08-27 04:36:55 --> Query error: Table 'metalsindo_db.dt_inquery_transasi' doesn't exist - Invalid query: INSERT INTO `dt_inquery_transasi` (`id_dt_inquery`, `no_inquery`, `id_bentuk`, `id_category3`, `thickness`, `density`, `dimensi1`, `berat_produk`, `qty_order`, `total_berat`, `rerata`, `target_harga`, `master_sample`, `mill_sheet`, `toleransi1max`, `toleransi1min`, `toleransi2max`, `toleransi2min`, `burry`, `sambungan`, `inner_diametermax`, `inner_diametermin`, `outer_diameter`, `apperance`, `maxjoin`, `deleted`, `created_on`, `created_by`) VALUES ('D2000001', 'IQ2008250003', 'B2000001', 'I2000001', '0.5', '7.93', '89', '352.885', '89', '31406.765', '89', '89', 'No', 'No', '89', '89', '89', NULL, '89', 'Sambung atau Join', '89', '89', '9', '89', '89', '0', '2020-08-27 04:36:55', '1')
ERROR - 2020-08-27 04:37:17 --> Query error: Table 'metalsindo_db.dt_inquery_transasi' doesn't exist - Invalid query: INSERT INTO `dt_inquery_transasi` (`id_dt_inquery`, `no_inquery`, `id_bentuk`, `id_category3`, `thickness`, `density`, `dimensi1`, `berat_produk`, `qty_order`, `total_berat`, `rerata`, `target_harga`, `master_sample`, `mill_sheet`, `toleransi1max`, `toleransi1min`, `toleransi2max`, `toleransi2min`, `burry`, `sambungan`, `inner_diametermax`, `inner_diametermin`, `outer_diameter`, `apperance`, `maxjoin`, `deleted`, `created_on`, `created_by`) VALUES ('D2000001', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2020-08-27 04:37:17', '1')
ERROR - 2020-08-27 04:38:17 --> Query error: Table 'metalsindo_db.dt_inquery_transasi' doesn't exist - Invalid query: INSERT INTO `dt_inquery_transasi` (`id_dt_inquery`, `no_inquery`, `id_bentuk`, `id_category3`, `thickness`, `density`, `dimensi1`, `berat_produk`, `qty_order`, `total_berat`, `rerata`, `target_harga`, `master_sample`, `mill_sheet`, `toleransi1max`, `toleransi1min`, `toleransi2max`, `toleransi2min`, `burry`, `sambungan`, `inner_diametermax`, `inner_diametermin`, `outer_diameter`, `apperance`, `maxjoin`, `deleted`, `created_on`, `created_by`) VALUES ('D2000001', 'IQ2008250003', 'B2000001', 'I2000001', '0.5', '7.93', '89', '352.885', '89', '31406.765', '89', '89', 'No', 'No', '89', '89', '89', NULL, '89', 'Sambung atau Join', '89', '89', '9', '89', '89', '0', '2020-08-27 04:38:17', '1')
ERROR - 2020-08-27 04:38:23 --> Query error: Table 'metalsindo_db.dt_inquery_transasi' doesn't exist - Invalid query: INSERT INTO `dt_inquery_transasi` (`id_dt_inquery`, `no_inquery`, `id_bentuk`, `id_category3`, `thickness`, `density`, `dimensi1`, `berat_produk`, `qty_order`, `total_berat`, `rerata`, `target_harga`, `master_sample`, `mill_sheet`, `toleransi1max`, `toleransi1min`, `toleransi2max`, `toleransi2min`, `burry`, `sambungan`, `inner_diametermax`, `inner_diametermin`, `outer_diameter`, `apperance`, `maxjoin`, `deleted`, `created_on`, `created_by`) VALUES ('D2000001', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2020-08-27 04:38:23', '1')
ERROR - 2020-08-27 08:18:29 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-08-27 08:18:32 --> 404 Page Not Found: /index
ERROR - 2020-08-27 11:00:37 --> The upload destination folder does not appear to be writable.
ERROR - 2020-08-27 11:00:37 --> The upload destination folder does not appear to be writable.
ERROR - 2020-08-27 13:37:22 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-08-27 13:37:46 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-08-27 13:37:48 --> 404 Page Not Found: /index
ERROR - 2020-08-27 13:38:35 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-08-27 13:38:39 --> 404 Page Not Found: /index
ERROR - 2020-08-27 13:55:00 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-08-27 13:55:12 --> 404 Page Not Found: /index
ERROR - 2020-08-27 15:07:49 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-08-27 15:07:51 --> 404 Page Not Found: /index
ERROR - 2020-08-27 17:10:53 --> 404 Page Not Found: ../modules/master_suplier/controllers/Master_suplier/viewLokal
ERROR - 2020-08-27 17:10:55 --> 404 Page Not Found: ../modules/master_suplier/controllers/Master_suplier/viewLokal
ERROR - 2020-08-27 17:10:57 --> 404 Page Not Found: ../modules/master_suplier/controllers/Master_suplier/viewLokal
ERROR - 2020-08-27 17:10:58 --> 404 Page Not Found: ../modules/master_suplier/controllers/Master_suplier/viewLokal
ERROR - 2020-08-27 17:10:59 --> 404 Page Not Found: ../modules/master_suplier/controllers/Master_suplier/viewLokal
ERROR - 2020-08-27 17:11:21 --> 404 Page Not Found: ../modules/master_suplier/controllers/Master_suplier/viewLokal
ERROR - 2020-08-27 17:11:23 --> 404 Page Not Found: ../modules/master_suplier/controllers/Master_suplier/viewLokal
ERROR - 2020-08-27 17:11:24 --> 404 Page Not Found: ../modules/master_suplier/controllers/Master_suplier/viewLokal
ERROR - 2020-08-27 17:11:27 --> 404 Page Not Found: ../modules/master_suplier/controllers/Master_suplier/viewLokal
ERROR - 2020-08-27 18:04:24 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-08-27 18:04:24 --> 404 Page Not Found: /index
ERROR - 2020-08-27 19:41:56 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-08-27 19:41:57 --> 404 Page Not Found: /index
ERROR - 2020-08-27 19:53:13 --> 404 Page Not Found: ../modules/inventory_4/controllers/Inventory_4/deleteInventory
ERROR - 2020-08-27 21:45:14 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-08-27 21:45:15 --> 404 Page Not Found: /index
ERROR - 2020-08-27 21:49:10 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-08-27 21:49:11 --> 404 Page Not Found: /index
ERROR - 2020-08-27 21:50:50 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-08-27 21:50:55 --> 404 Page Not Found: /index
ERROR - 2020-08-27 22:18:12 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-08-27 22:18:12 --> 404 Page Not Found: /index
ERROR - 2020-08-27 22:19:01 --> 404 Page Not Found: ../modules/master_suplier/controllers/Master_suplier/viewLokal
ERROR - 2020-08-27 22:19:04 --> Severity: Warning --> Missing argument 1 for Master_customers::editCustomer() /home/ssc/metalsindo_dev/application/modules/master_customers/controllers/Master_customers.php 52
ERROR - 2020-08-27 22:29:07 --> Severity: Compile Error --> Cannot redeclare Inventory_4::saveNewInventory() /home/ssc/metalsindo_dev/application/modules/inventory_4/controllers/Inventory_4.php 435
ERROR - 2020-08-27 22:29:21 --> Severity: Compile Error --> Cannot redeclare Inventory_4::saveNewInventory() /home/ssc/metalsindo_dev/application/modules/inventory_4/controllers/Inventory_4.php 435
ERROR - 2020-08-27 22:29:23 --> Severity: Compile Error --> Cannot redeclare Inventory_4::saveNewInventory() /home/ssc/metalsindo_dev/application/modules/inventory_4/controllers/Inventory_4.php 435
ERROR - 2020-08-27 22:29:54 --> Severity: Compile Error --> Cannot redeclare Inventory_4::saveNewInventory() /home/ssc/metalsindo_dev/application/modules/inventory_4/controllers/Inventory_4.php 435
ERROR - 2020-08-27 22:33:33 --> Severity: Parsing Error --> syntax error, unexpected ';', expecting ')' /home/ssc/metalsindo_dev/application/modules/transaksi_inquiry/controllers/Transaksi_inquiry.php 453
ERROR - 2020-08-27 22:35:34 --> 404 Page Not Found: ../modules/inventory_4/controllers/Inventory_4/deleteInventory
ERROR - 2020-08-27 22:36:06 --> 404 Page Not Found: ../modules/inventory_4/controllers/Inventory_4/deleteInventory
ERROR - 2020-08-27 22:40:33 --> 404 Page Not Found: ../modules/master_rate/controllers/Master_rate/viewType
ERROR - 2020-08-27 22:40:34 --> Severity: Warning --> Missing argument 1 for Master_rate::EditTypeRate() /home/ssc/metalsindo_dev/application/modules/master_rate/controllers/Master_rate.php 67
ERROR - 2020-08-27 22:43:52 --> Severity: Warning --> Missing argument 1 for Master_rate::EditTypeRate() /home/ssc/metalsindo_dev/application/modules/master_rate/controllers/Master_rate.php 67
ERROR - 2020-08-27 22:43:58 --> Severity: Warning --> Missing argument 1 for Master_rate::EditTypeRate() /home/ssc/metalsindo_dev/application/modules/master_rate/controllers/Master_rate.php 67
ERROR - 2020-08-27 22:44:08 --> Severity: Warning --> Missing argument 1 for Master_rate::EditTypeRate() /home/ssc/metalsindo_dev/application/modules/master_rate/controllers/Master_rate.php 67
ERROR - 2020-08-27 22:44:10 --> Severity: Warning --> Missing argument 1 for Master_rate::EditTypeRate() /home/ssc/metalsindo_dev/application/modules/master_rate/controllers/Master_rate.php 67
ERROR - 2020-08-27 22:44:15 --> 404 Page Not Found: ../modules/master_rate/controllers/Master_rate/deleteType
ERROR - 2020-08-27 22:44:18 --> 404 Page Not Found: ../modules/master_rate/controllers/Master_rate/deleteType
ERROR - 2020-08-27 22:44:22 --> 404 Page Not Found: ../modules/master_rate/controllers/Master_rate/deleteType
ERROR - 2020-08-27 23:07:36 --> 404 Page Not Found: ../modules/master_rate/controllers/Master_rate/deleteType
ERROR - 2020-08-27 23:08:08 --> Severity: Warning --> Missing argument 1 for Master_rate::EditTypeRate() /home/ssc/metalsindo_dev/application/modules/master_rate/controllers/Master_rate.php 67
ERROR - 2020-08-27 23:08:11 --> 404 Page Not Found: ../modules/master_rate/controllers/Master_rate/viewType
ERROR - 2020-08-27 23:09:19 --> 404 Page Not Found: ../modules/master_rate/controllers/Master_rate/deleteType
ERROR - 2020-08-27 23:11:41 --> Severity: Warning --> Missing argument 1 for Master_rate::EditTypeRate() /home/ssc/metalsindo_dev/application/modules/master_rate/controllers/Master_rate.php 67
ERROR - 2020-08-27 23:11:52 --> 404 Page Not Found: ../modules/master_rate/controllers/Master_rate/deleteType
ERROR - 2020-08-27 23:11:55 --> 404 Page Not Found: ../modules/master_rate/controllers/Master_rate/viewType
ERROR - 2020-08-27 23:11:56 --> Severity: Warning --> Missing argument 1 for Master_rate::EditTypeRate() /home/ssc/metalsindo_dev/application/modules/master_rate/controllers/Master_rate.php 67
ERROR - 2020-08-27 23:12:19 --> Severity: Warning --> Missing argument 1 for Master_rate::EditTypeRate() /home/ssc/metalsindo_dev/application/modules/master_rate/controllers/Master_rate.php 67
ERROR - 2020-08-27 23:14:14 --> 404 Page Not Found: ../modules/master_rate/controllers/Master_rate/viewType
ERROR - 2020-08-27 23:14:16 --> Severity: Warning --> Missing argument 1 for Master_rate::EditTypeRate() /home/ssc/metalsindo_dev/application/modules/master_rate/controllers/Master_rate.php 67
ERROR - 2020-08-27 23:14:19 --> 404 Page Not Found: ../modules/master_rate/controllers/Master_rate/deleteType
ERROR - 2020-08-27 23:15:13 --> 404 Page Not Found: ../modules/master_rate/controllers/Master_rate/deleteType
ERROR - 2020-08-27 23:18:06 --> 404 Page Not Found: ../modules/master_rate/controllers/Master_rate/deleteType
ERROR - 2020-08-27 23:18:08 --> 404 Page Not Found: ../modules/master_rate/controllers/Master_rate/viewType
ERROR - 2020-08-27 23:18:59 --> 404 Page Not Found: ../modules/master_rate/controllers/Master_rate/deleteType
ERROR - 2020-08-27 23:19:02 --> 404 Page Not Found: ../modules/master_rate/controllers/Master_rate/viewType
ERROR - 2020-08-27 23:20:14 --> 404 Page Not Found: ../modules/master_rate/controllers/Master_rate/deleteType
ERROR - 2020-08-27 23:35:56 --> 404 Page Not Found: ../modules/master_rate/controllers/Master_rate/viewType
ERROR - 2020-08-27 23:36:05 --> 404 Page Not Found: ../modules/master_rate/controllers/Master_rate/deleteType
