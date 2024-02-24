<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-10-16 07:34:11 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-10-16 07:34:17 --> 404 Page Not Found: /index
ERROR - 2020-10-16 08:27:05 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-10-16 08:27:06 --> 404 Page Not Found: /index
ERROR - 2020-10-16 11:04:33 --> Query error: Unknown column 'b.name_customer' in 'field list' - Invalid query: SELECT `a`.*, `b`.`name_customer` as `name_customer`
FROM `dt_spkmarketing` `a`
JOIN `tr_spk_marketing` `b` ON `b`.`id_spkmarketing`=`a`.`id_spkmarketing`
JOIN `master_customers` `c` ON `b`.`id_customer`=`b`.`id_customer`
WHERE `a`.`status_approve` = '1'
ORDER BY `a`.`id_spkmarketing` DESC
ERROR - 2020-10-16 11:04:44 --> Query error: Unknown column 'a.status_approve' in 'where clause' - Invalid query: SELECT `a`.*, `c`.`name_customer` as `name_customer`
FROM `dt_spkmarketing` `a`
JOIN `tr_spk_marketing` `b` ON `b`.`id_spkmarketing`=`a`.`id_spkmarketing`
JOIN `master_customers` `c` ON `b`.`id_customer`=`b`.`id_customer`
WHERE `a`.`status_approve` = '1'
ORDER BY `a`.`id_spkmarketing` DESC
ERROR - 2020-10-16 11:05:05 --> Query error: Unknown column 'a.status_approve' in 'where clause' - Invalid query: SELECT `a`.*, `c`.`name_customer` as `name_customer`
FROM `dt_spkmarketing` `a`
JOIN `tr_spk_marketing` `b` ON `b`.`id_spkmarketing`=`a`.`id_spkmarketing`
JOIN `master_customers` `c` ON `b`.`id_customer`=`b`.`id_customer`
WHERE `a`.`status_approve` = '1'
ORDER BY `a`.`id_spkmarketing` DESC
ERROR - 2020-10-16 11:05:51 --> Query error: Unknown column 'a.status_approve' in 'where clause' - Invalid query: SELECT `a`.*, `c`.`name_customer` as `name_customer`
FROM `dt_spkmarketing` `a`
JOIN `tr_spk_marketing` `b` ON `b`.`id_spkmarketing`=`a`.`id_spkmarketing`
JOIN `master_customers` `c` ON `b`.`id_customer`=`b`.`id_customer`
WHERE `a`.`status_approve` = '1'
ORDER BY `a`.`id_spkmarketing` DESC
ERROR - 2020-10-16 11:06:38 --> Query error: Unknown column 'a.status_approve' in 'where clause' - Invalid query: SELECT `a`.*, `c`.`name_customer` as `name_customer`
FROM `dt_spkmarketing` `a`
JOIN `tr_spk_marketing` `b` ON `b`.`id_spkmarketing`=`a`.`id_spkmarketing`
JOIN `master_customers` `c` ON `b`.`id_customer`=`b`.`id_customer`
WHERE `a`.`status_approve` = '1'
ORDER BY `a`.`id_spkmarketing` DESC
ERROR - 2020-10-16 11:28:54 --> Query error: Unknown column 'e.nama_gudang' in 'field list' - Invalid query: SELECT `a`.*, `b`.`nama` as `nama_type`, `c`.`nama` as `nama_category1`, `d`.`nama` as `nama_category2`, `e`.`nilai_dimensi` as `nilai_dimensi`, `e`.`nama_gudang` as `nama_gudang`
FROM `ms_inventory_category3` `a`
JOIN `ms_inventory_type` `b` ON `b`.`id_type`=`a`.`id_type`
JOIN `ms_inventory_category1` `c` ON `c`.`id_category1` =`a`.`id_category1`
JOIN `ms_inventory_category2` `d` ON `d`.`id_category2` =`a`.`id_category2`
JOIN `child_inven_dimensi` `e` ON `e`.`id_category3` =`a`.`id_category3`
JOIN `ms_gudang` `f` ON `f`.`id_gudang` =`a`.`id_gudang`
WHERE `a`.`deleted` = '0'
ERROR - 2020-10-16 11:29:09 --> Query error: Unknown column 'a.id_gudang' in 'on clause' - Invalid query: SELECT `a`.*, `b`.`nama` as `nama_type`, `c`.`nama` as `nama_category1`, `d`.`nama` as `nama_category2`, `e`.`nilai_dimensi` as `nilai_dimensi`, `f`.`nama_gudang` as `nama_gudang`
FROM `ms_inventory_category3` `a`
JOIN `ms_inventory_type` `b` ON `b`.`id_type`=`a`.`id_type`
JOIN `ms_inventory_category1` `c` ON `c`.`id_category1` =`a`.`id_category1`
JOIN `ms_inventory_category2` `d` ON `d`.`id_category2` =`a`.`id_category2`
JOIN `child_inven_dimensi` `e` ON `e`.`id_category3` =`a`.`id_category3`
JOIN `ms_gudang` `f` ON `f`.`id_gudang` =`a`.`id_gudang`
WHERE `a`.`deleted` = '0'
ERROR - 2020-10-16 12:33:08 --> Query error: Unknown column 'b.nama' in 'field list' - Invalid query: SELECT `a`.*, `b`.`nama` as `nama_type`, `f`.`nama_gudang` as `nama_gudang`
FROM `stock_material` `a`
JOIN `ms_gudang` `b` ON `b`.`id_gudang` =`a`.`id_gudang`
WHERE `a`.`id_category3` = 'I2000004'
ERROR - 2020-10-16 12:39:33 --> 404 Page Not Found: ../modules/material_planing/controllers/Material_planing/ViewStock
ERROR - 2020-10-16 12:41:57 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-10-16 12:41:57 --> 404 Page Not Found: /index
ERROR - 2020-10-16 12:42:05 --> 404 Page Not Found: ../modules/material_planing/controllers/Material_planing/ViewStock
ERROR - 2020-10-16 12:42:14 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-10-16 12:42:14 --> 404 Page Not Found: /index
ERROR - 2020-10-16 12:50:25 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/material_planing/views/EditHeader.php 7
ERROR - 2020-10-16 12:50:25 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/material_planing/views/EditHeader.php 52
ERROR - 2020-10-16 12:50:25 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/material_planing/views/EditHeader.php 99
ERROR - 2020-10-16 12:55:06 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/material_planing/views/EditHeader.php 7
ERROR - 2020-10-16 12:55:15 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/material_planing/views/EditHeader.php 7
ERROR - 2020-10-16 13:19:49 --> Severity: Notice --> Undefined variable: datgroupmenu /home/ssc/metalsindo_dev/application/modules/menus/views/menus_form.php 70
ERROR - 2020-10-16 13:20:13 --> Severity: Notice --> Undefined variable: datgroupmenu /home/ssc/metalsindo_dev/application/modules/menus/views/menus_form.php 70
ERROR - 2020-10-16 13:38:21 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-10-16 13:38:21 --> 404 Page Not Found: /index
ERROR - 2020-10-16 15:34:00 --> Severity: error --> Exception: ERROR n°1 : The tag &lt;BR&gt; does not yet exist.If you want to add it, you must create the methods o_BR (for opening) and c_BR (for closure) by following the model of existing tags.If you create these methods, do not hesitate to send me an email to webmaster@html2pdf.fr to included them in the next version of HTML2PDF. /home/ssc/metalsindo_dev/assets/html2pdf/html2pdf/html2pdf.class.php 1251
ERROR - 2020-10-16 15:43:18 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-10-16 15:43:19 --> 404 Page Not Found: /index
ERROR - 2020-10-16 15:51:31 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-10-16 15:51:33 --> 404 Page Not Found: /index
