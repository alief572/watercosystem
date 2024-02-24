<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2021-06-02 08:54:15 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2021-06-02 08:54:15 --> 404 Page Not Found: /index
ERROR - 2021-06-02 08:55:22 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2021-06-02 08:55:22 --> 404 Page Not Found: /index
ERROR - 2021-06-02 08:55:29 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2021-06-02 08:55:29 --> 404 Page Not Found: /index
ERROR - 2021-06-02 09:40:59 --> Query error: Table 'metalsindo_db.tr_spkmarketing' doesn't exist - Invalid query: SELECT `b`.`no_surat`, `b`.`nama_customer` AS `namacustomer`, `a`.`no_alloy` AS `nmmaterial`, `a`.`thickness`, `a`.`weight`, `a`.`delivery`, `a`.`total_width` AS `totalwidth`
FROM `dt_spkmarketing` `a`
LEFT JOIN `tr_spkmarketing` `b` ON `a`.`id_spkmarketing`=`b`.`id_spkmarketing`
ERROR - 2021-06-02 09:41:13 --> Query error: Unknown column 'a.total_width' in 'field list' - Invalid query: SELECT `b`.`no_surat`, `b`.`nama_customer` AS `namacustomer`, `a`.`no_alloy` AS `nmmaterial`, `a`.`thickness`, `a`.`weight`, `a`.`delivery`, `a`.`total_width` AS `totalwidth`
FROM `dt_spkmarketing` `a`
LEFT JOIN `tr_spk_marketing` `b` ON `a`.`id_spkmarketing`=`b`.`id_spkmarketing`
ERROR - 2021-06-02 09:43:32 --> Query error: Unknown column 'a.total_width' in 'field list' - Invalid query: SELECT `b`.`no_surat`, `b`.`nama_customer` AS `namacustomer`, `a`.`no_alloy` AS `nmmaterial`, `a`.`thickness`, `a`.`weight`, `a`.`delivery`, `a`.`total_width` AS `totalwidth`
FROM `dt_spkmarketing` `a`
LEFT JOIN `tr_spk_marketing` `b` ON `a`.`id_spkmarketing`=`b`.`id_spkmarketing`
ERROR - 2021-06-02 09:46:03 --> Query error: Unknown column 'a.total_width' in 'field list' - Invalid query: SELECT `b`.`no_surat`, `b`.`nama_customer` AS `namacustomer`, `a`.`no_alloy` AS `nmmaterial`, `a`.`thickness`, `a`.`weight`, `a`.`delivery`, `a`.`total_width` AS `totalwidth`
FROM `dt_spkmarketing` `a`
LEFT JOIN `tr_spk_marketing` `b` ON `a`.`id_spkmarketing`=`b`.`id_spkmarketing`
ERROR - 2021-06-02 10:48:33 --> Query error: Unknown column 'c.qty_aktual' in 'field list' - Invalid query: SELECT `b`.`no_surat`, `b`.`nama_customer` AS `namacustomer`, `a`.`no_alloy` AS `nmmaterial`, `a`.`thickness`, `a`.`width` AS `weight`, `a`.`delivery`, `a`.`qty_produk` AS `totalwidth`, `c`.`qty_aktual`
FROM `dt_spkmarketing` `a`
LEFT JOIN `tr_spk_marketing` `b` ON `a`.`id_spkmarketing`=`b`.`id_spkmarketing`
LEFT JOIN `tr_spk_aktual` `c` ON `a`.`id_spkmarketing`=`c`.`no_surat`
ERROR - 2021-06-02 10:48:52 --> Query error: Unknown column 'c.qtyaktual' in 'field list' - Invalid query: SELECT `b`.`no_surat`, `b`.`nama_customer` AS `namacustomer`, `a`.`no_alloy` AS `nmmaterial`, `a`.`thickness`, `a`.`width` AS `weight`, `a`.`delivery`, `a`.`qty_produk` AS `totalwidth`, `c`.`qtyaktual`
FROM `dt_spkmarketing` `a`
LEFT JOIN `tr_spk_marketing` `b` ON `a`.`id_spkmarketing`=`b`.`id_spkmarketing`
LEFT JOIN `tr_spk_aktual` `c` ON `a`.`id_spkmarketing`=`c`.`no_surat`
ERROR - 2021-06-02 10:49:59 --> Query error: Unknown column 'c.qtyaktual' in 'field list' - Invalid query: SELECT `b`.`no_surat`, `b`.`nama_customer` AS `namacustomer`, `a`.`no_alloy` AS `nmmaterial`, `a`.`thickness`, `a`.`width` AS `weight`, `a`.`delivery`, `a`.`qty_produk` AS `totalwidth`, `c`.`qtyaktual`
FROM `dt_spkmarketing` `a`
LEFT JOIN `tr_spk_marketing` `b` ON `a`.`id_spkmarketing`=`b`.`id_spkmarketing`
LEFT JOIN `tr_spk_aktual` `c` ON `a`.`id_spkmarketing`=`c`.`no_surat`
ERROR - 2021-06-02 10:57:14 --> Query error: Table 'metalsindo_db.dt_spkmarketingx' doesn't exist - Invalid query: SELECT `b`.`no_surat`, `b`.`nama_customer` AS `namacustomer`, `a`.`id_dt_spkmarketing`, `a`.`no_alloy` AS `nmmaterial`, `a`.`thickness`, `a`.`width` AS `weight`, `a`.`delivery`, `a`.`qty_produk` AS `totalwidth`, `c`.`qtyaktual`
FROM `dt_spkmarketingx` `a`
LEFT JOIN `tr_spk_marketing` `b` ON `a`.`id_spkmarketing`=`b`.`id_spkmarketing`
LEFT JOIN `dt_spk_aktual` `c` ON `a`.`id_spkmarketing`=`c`.`no_surat`
ERROR - 2021-06-02 12:56:55 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2021-06-02 12:56:55 --> 404 Page Not Found: /index
ERROR - 2021-06-02 13:08:06 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2021-06-02 13:08:07 --> 404 Page Not Found: /index
ERROR - 2021-06-02 13:21:54 --> Query error: Unknown column 'id_dt_spkmarketing' in 'field list' - Invalid query: INSERT INTO `stock_material_customer` (`berat`, `created_by`, `created_date`, `id_customer`, `id_dt_spkmarketing`, `id_stock`, `keterangan`) VALUES ('2822.40 - 0.00','1','2021-06-02 13:21:54','MC2000005','P2100008-1','220','')
ERROR - 2021-06-02 13:22:04 --> Query error: Unknown column 'id_dt_spkmarketing' in 'field list' - Invalid query: INSERT INTO `stock_material_customer` (`berat`, `created_by`, `created_date`, `id_customer`, `id_dt_spkmarketing`, `id_stock`, `keterangan`) VALUES ('2822.40 - 0.00','1','2021-06-02 13:22:04','MC2000005','P2100008-1','220','')
ERROR - 2021-06-02 13:31:30 --> Query error: Table 'metalsindo_db.stock_material_customerx' doesn't exist - Invalid query: SELECT SUM(berat) AS qty_booking
FROM `stock_material_customerx`
 LIMIT 1
ERROR - 2021-06-02 13:31:46 --> Query error: Table 'metalsindo_db.stock_material_customerx' doesn't exist - Invalid query: SELECT SUM(berat) AS qty_booking
FROM `stock_material_customerx`
 LIMIT 1
ERROR - 2021-06-02 13:31:48 --> Query error: Table 'metalsindo_db.stock_material_customerx' doesn't exist - Invalid query: SELECT SUM(berat) AS qty_booking
FROM `stock_material_customerx`
 LIMIT 1
ERROR - 2021-06-02 14:18:33 --> Query error: Table 'metalsindo_db.dt_spkproduksi' doesn't exist - Invalid query: SELECT SUM(totoalwidth) AS qty_produksi
FROM `dt_spkproduksi`
WHERE `no_surat` = 'P2100002-1'
ERROR - 2021-06-02 14:18:44 --> Query error: Table 'metalsindo_db.dt_spkproduksi' doesn't exist - Invalid query: SELECT SUM(totalwidth) AS qty_produksi
FROM `dt_spkproduksi`
WHERE `no_surat` = 'P2100002-1'
ERROR - 2021-06-02 14:18:46 --> Query error: Table 'metalsindo_db.dt_spkproduksi' doesn't exist - Invalid query: SELECT SUM(totalwidth) AS qty_produksi
FROM `dt_spkproduksi`
WHERE `no_surat` = 'P2100002-1'
ERROR - 2021-06-02 14:18:47 --> Query error: Table 'metalsindo_db.dt_spkproduksi' doesn't exist - Invalid query: SELECT SUM(totalwidth) AS qty_produksi
FROM `dt_spkproduksi`
WHERE `no_surat` = 'P2100002-1'
ERROR - 2021-06-02 14:18:47 --> Query error: Table 'metalsindo_db.dt_spkproduksi' doesn't exist - Invalid query: SELECT SUM(totalwidth) AS qty_produksi
FROM `dt_spkproduksi`
WHERE `no_surat` = 'P2100002-1'
ERROR - 2021-06-02 14:18:48 --> Query error: Table 'metalsindo_db.dt_spkproduksi' doesn't exist - Invalid query: SELECT SUM(totalwidth) AS qty_produksi
FROM `dt_spkproduksi`
WHERE `no_surat` = 'P2100002-1'
ERROR - 2021-06-02 14:18:48 --> Query error: Table 'metalsindo_db.dt_spkproduksi' doesn't exist - Invalid query: SELECT SUM(totalwidth) AS qty_produksi
FROM `dt_spkproduksi`
WHERE `no_surat` = 'P2100002-1'
ERROR - 2021-06-02 15:34:46 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2021-06-02 15:34:47 --> 404 Page Not Found: /index
ERROR - 2021-06-02 17:00:27 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2021-06-02 17:00:27 --> 404 Page Not Found: /index
ERROR - 2021-06-02 17:00:37 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2021-06-02 17:00:37 --> 404 Page Not Found: /index
ERROR - 2021-06-02 17:17:43 --> Severity: Notice --> Undefined variable: datgroupmenu /home/ssc/metalsindo_dev/application/modules/menus/views/menus_form.php 70
