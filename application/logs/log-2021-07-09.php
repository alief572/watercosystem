<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2021-07-09 10:06:24 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2021-07-09 10:06:26 --> 404 Page Not Found: /index
ERROR - 2021-07-09 10:06:34 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2021-07-09 10:06:34 --> 404 Page Not Found: /index
ERROR - 2021-07-09 10:13:06 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2021-07-09 10:13:09 --> 404 Page Not Found: /index
ERROR - 2021-07-09 17:30:49 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2021-07-09 17:30:49 --> 404 Page Not Found: /index
ERROR - 2021-07-09 18:46:25 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2021-07-09 19:21:36 --> Severity: Parsing Error --> syntax error, unexpected '"', expecting ',' or ';' /home/ssc/metalsindo_dev/application/modules/progress_order/controllers/Progress_order.php 64
ERROR - 2021-07-09 20:41:05 --> Query error: Unknown column '$customer' in 'where clause' - Invalid query: SELECT `b`.`no_surat`, `b`.`nama_customer` AS `namacustomer`, `a`.`id_dt_spkmarketing`, `a`.`no_alloy` AS `nmmaterial`, `a`.`thickness`, `a`.`width` AS `weight`, `a`.`delivery`, `a`.`qty_produk` AS `totalwidth`
FROM `dt_spkmarketing` `a`
LEFT JOIN `tr_spk_marketing` `b` ON `a`.`id_spkmarketing`=`b`.`id_spkmarketing`
LEFT JOIN `dt_spk_aktual` `c` ON `a`.`id_dt_spkmarketing`=`c`.`no_surat`
WHERE `b`.`nama_customer` = `$customer`
ERROR - 2021-07-09 20:41:35 --> Severity: Parsing Error --> syntax error, unexpected '$customer' (T_VARIABLE) /home/ssc/metalsindo_dev/application/modules/progress_order/controllers/Progress_order.php 49
ERROR - 2021-07-09 20:41:58 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '`PRECISION`' at line 5 - Invalid query: SELECT `b`.`no_surat`, `b`.`nama_customer` AS `namacustomer`, `a`.`id_dt_spkmarketing`, `a`.`no_alloy` AS `nmmaterial`, `a`.`thickness`, `a`.`width` AS `weight`, `a`.`delivery`, `a`.`qty_produk` AS `totalwidth`
FROM `dt_spkmarketing` `a`
LEFT JOIN `tr_spk_marketing` `b` ON `a`.`id_spkmarketing`=`b`.`id_spkmarketing`
LEFT JOIN `dt_spk_aktual` `c` ON `a`.`id_dt_spkmarketing`=`c`.`no_surat`
WHERE `b`.`nama_customer` = `PT`.` INDONESIA G-SHANK` `PRECISION`
ERROR - 2021-07-09 20:46:15 --> Query error: Unknown column 'MC2000005' in 'where clause' - Invalid query: SELECT `b`.`no_surat`, `b`.`nama_customer` AS `namacustomer`, `b`.`id_customer` AS `idcustomer`, `a`.`id_dt_spkmarketing`, `a`.`no_alloy` AS `nmmaterial`, `a`.`thickness`, `a`.`width` AS `weight`, `a`.`delivery`, `a`.`qty_produk` AS `totalwidth`
FROM `dt_spkmarketing` `a`
LEFT JOIN `tr_spk_marketing` `b` ON `a`.`id_spkmarketing`=`b`.`id_spkmarketing`
LEFT JOIN `dt_spk_aktual` `c` ON `a`.`id_dt_spkmarketing`=`c`.`no_surat`
WHERE `b`.`id_customer` = `MC2000005`
ERROR - 2021-07-09 20:47:20 --> Query error: Unknown column 'MC2000006' in 'where clause' - Invalid query: SELECT `b`.`no_surat`, `b`.`nama_customer` AS `namacustomer`, `b`.`id_customer` AS `idcustomer`, `a`.`id_dt_spkmarketing`, `a`.`no_alloy` AS `nmmaterial`, `a`.`thickness`, `a`.`width` AS `weight`, `a`.`delivery`, `a`.`qty_produk` AS `totalwidth`
FROM `dt_spkmarketing` `a`
LEFT JOIN `tr_spk_marketing` `b` ON `a`.`id_spkmarketing`=`b`.`id_spkmarketing`
LEFT JOIN `dt_spk_aktual` `c` ON `a`.`id_dt_spkmarketing`=`c`.`no_surat`
WHERE `b`.`id_customer` = `MC2000006`
ERROR - 2021-07-09 20:47:25 --> Query error: Unknown column 'MC2000005' in 'where clause' - Invalid query: SELECT `b`.`no_surat`, `b`.`nama_customer` AS `namacustomer`, `b`.`id_customer` AS `idcustomer`, `a`.`id_dt_spkmarketing`, `a`.`no_alloy` AS `nmmaterial`, `a`.`thickness`, `a`.`width` AS `weight`, `a`.`delivery`, `a`.`qty_produk` AS `totalwidth`
FROM `dt_spkmarketing` `a`
LEFT JOIN `tr_spk_marketing` `b` ON `a`.`id_spkmarketing`=`b`.`id_spkmarketing`
LEFT JOIN `dt_spk_aktual` `c` ON `a`.`id_dt_spkmarketing`=`c`.`no_surat`
WHERE `b`.`id_customer` = `MC2000005`
ERROR - 2021-07-09 20:47:57 --> Query error: Unknown column '$customer' in 'where clause' - Invalid query: SELECT `b`.`no_surat`, `b`.`nama_customer` AS `namacustomer`, `b`.`id_customer` AS `idcustomer`, `a`.`id_dt_spkmarketing`, `a`.`no_alloy` AS `nmmaterial`, `a`.`thickness`, `a`.`width` AS `weight`, `a`.`delivery`, `a`.`qty_produk` AS `totalwidth`
FROM `dt_spkmarketing` `a`
LEFT JOIN `tr_spk_marketing` `b` ON `a`.`id_spkmarketing`=`b`.`id_spkmarketing`
LEFT JOIN `dt_spk_aktual` `c` ON `a`.`id_dt_spkmarketing`=`c`.`no_surat`
WHERE `b`.`id_customer` = `$customer`
ERROR - 2021-07-09 20:49:13 --> Query error: Unknown column '$cust' in 'where clause' - Invalid query: SELECT `b`.`no_surat`, `b`.`nama_customer` AS `namacustomer`, `b`.`id_customer` AS `idcustomer`, `a`.`id_dt_spkmarketing`, `a`.`no_alloy` AS `nmmaterial`, `a`.`thickness`, `a`.`width` AS `weight`, `a`.`delivery`, `a`.`qty_produk` AS `totalwidth`
FROM `dt_spkmarketing` `a`
LEFT JOIN `tr_spk_marketing` `b` ON `a`.`id_spkmarketing`=`b`.`id_spkmarketing`
LEFT JOIN `dt_spk_aktual` `c` ON `a`.`id_dt_spkmarketing`=`c`.`no_surat`
WHERE `b`.`id_customer` = `$cust`
ERROR - 2021-07-09 20:49:29 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 5 - Invalid query: SELECT `b`.`no_surat`, `b`.`nama_customer` AS `namacustomer`, `b`.`id_customer` AS `idcustomer`, `a`.`id_dt_spkmarketing`, `a`.`no_alloy` AS `nmmaterial`, `a`.`thickness`, `a`.`width` AS `weight`, `a`.`delivery`, `a`.`qty_produk` AS `totalwidth`
FROM `dt_spkmarketing` `a`
LEFT JOIN `tr_spk_marketing` `b` ON `a`.`id_spkmarketing`=`b`.`id_spkmarketing`
LEFT JOIN `dt_spk_aktual` `c` ON `a`.`id_dt_spkmarketing`=`c`.`no_surat`
WHERE `b`.`id_customer` = .`$cust`
ERROR - 2021-07-09 20:50:47 --> Query error: Unknown column '$customer' in 'where clause' - Invalid query: SELECT `b`.`no_surat`, `b`.`nama_customer` AS `namacustomer`, `b`.`id_customer` AS `idcustomer`, `a`.`id_dt_spkmarketing`, `a`.`no_alloy` AS `nmmaterial`, `a`.`thickness`, `a`.`width` AS `weight`, `a`.`delivery`, `a`.`qty_produk` AS `totalwidth`
FROM `dt_spkmarketing` `a`
LEFT JOIN `tr_spk_marketing` `b` ON `a`.`id_spkmarketing`=`b`.`id_spkmarketing`
LEFT JOIN `dt_spk_aktual` `c` ON `a`.`id_dt_spkmarketing`=`c`.`no_surat`
WHERE `b`.`id_customer` = `$customer`
ERROR - 2021-07-09 20:52:28 --> Query error: Unknown column 'b.id_customerx' in 'where clause' - Invalid query: SELECT `b`.`no_surat`, `b`.`nama_customer` AS `namacustomer`, `b`.`id_customer` AS `idcustomer`, `a`.`id_dt_spkmarketing`, `a`.`no_alloy` AS `nmmaterial`, `a`.`thickness`, `a`.`width` AS `weight`, `a`.`delivery`, `a`.`qty_produk` AS `totalwidth`
FROM `dt_spkmarketing` `a`
LEFT JOIN `tr_spk_marketing` `b` ON `a`.`id_spkmarketing`=`b`.`id_spkmarketing`
LEFT JOIN `dt_spk_aktual` `c` ON `a`.`id_dt_spkmarketing`=`c`.`no_surat`
WHERE `b`.`id_customerx` = ".$customer"
ERROR - 2021-07-09 20:53:25 --> Query error: Unknown column 'b.id_customerx' in 'where clause' - Invalid query: SELECT `b`.`no_surat`, `b`.`nama_customer` AS `namacustomer`, `b`.`id_customer` AS `idcustomer`, `a`.`id_dt_spkmarketing`, `a`.`no_alloy` AS `nmmaterial`, `a`.`thickness`, `a`.`width` AS `weight`, `a`.`delivery`, `a`.`qty_produk` AS `totalwidth`
FROM `dt_spkmarketing` `a`
LEFT JOIN `tr_spk_marketing` `b` ON `a`.`id_spkmarketing`=`b`.`id_spkmarketing`
LEFT JOIN `dt_spk_aktual` `c` ON `a`.`id_dt_spkmarketing`=`c`.`no_surat`
WHERE `b`.`id_customerx` IS NULL
ERROR - 2021-07-09 20:53:57 --> Severity: Parsing Error --> syntax error, unexpected '=>' (T_DOUBLE_ARROW) /home/ssc/metalsindo_dev/application/modules/progress_order/controllers/Progress_order.php 51
ERROR - 2021-07-09 20:54:21 --> Query error: Unknown column 'b.id_customerx' in 'where clause' - Invalid query: SELECT `b`.`no_surat`, `b`.`nama_customer` AS `namacustomer`, `b`.`id_customer` AS `idcustomer`, `a`.`id_dt_spkmarketing`, `a`.`no_alloy` AS `nmmaterial`, `a`.`thickness`, `a`.`width` AS `weight`, `a`.`delivery`, `a`.`qty_produk` AS `totalwidth`
FROM `dt_spkmarketing` `a`
LEFT JOIN `tr_spk_marketing` `b` ON `a`.`id_spkmarketing`=`b`.`id_spkmarketing`
LEFT JOIN `dt_spk_aktual` `c` ON `a`.`id_dt_spkmarketing`=`c`.`no_surat`
WHERE `b`.`id_customerx` IS NULL
ERROR - 2021-07-09 20:56:38 --> Query error: Unknown column 'b.id_customerx' in 'where clause' - Invalid query: SELECT `b`.`no_surat`, `b`.`nama_customer` AS `namacustomer`, `b`.`id_customer` AS `idcustomer`, `a`.`id_dt_spkmarketing`, `a`.`no_alloy` AS `nmmaterial`, `a`.`thickness`, `a`.`width` AS `weight`, `a`.`delivery`, `a`.`qty_produk` AS `totalwidth`
FROM `dt_spkmarketing` `a`
LEFT JOIN `tr_spk_marketing` `b` ON `a`.`id_spkmarketing`=`b`.`id_spkmarketing`
LEFT JOIN `dt_spk_aktual` `c` ON `a`.`id_dt_spkmarketing`=`c`.`no_surat`
WHERE `b`.`id_customerx` IS NULL
ERROR - 2021-07-09 21:18:54 --> Severity: Parsing Error --> syntax error, unexpected '<' /home/ssc/metalsindo_dev/application/modules/progress_order/views/index.php 30
