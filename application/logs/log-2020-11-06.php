<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-11-06 08:44:43 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-11-06 08:44:44 --> 404 Page Not Found: /index
ERROR - 2020-11-06 08:45:18 --> Severity: Error --> Call to undefined method Inventory_4_model::Pergusdang() /home/ssc/metalsindo_dev/application/modules/stock_material/controllers/Stock_material.php 64
ERROR - 2020-11-06 08:45:42 --> Severity: Error --> Call to undefined method Inventory_4_model::Pergusdang() /home/ssc/metalsindo_dev/application/modules/stock_material/controllers/Stock_material.php 64
ERROR - 2020-11-06 08:50:05 --> Severity: Notice --> Undefined variable: datgroupmenu /home/ssc/metalsindo_dev/application/modules/menus/views/menus_form.php 70
ERROR - 2020-11-06 08:51:05 --> Severity: Notice --> Undefined variable: datgroupmenu /home/ssc/metalsindo_dev/application/modules/menus/views/menus_form.php 70
ERROR - 2020-11-06 08:52:55 --> Severity: Notice --> Undefined variable: datgroupmenu /home/ssc/metalsindo_dev/application/modules/menus/views/menus_form.php 70
ERROR - 2020-11-06 08:55:12 --> Severity: Notice --> Undefined variable: datgroupmenu /home/ssc/metalsindo_dev/application/modules/menus/views/menus_form.php 70
ERROR - 2020-11-06 08:55:29 --> Severity: Notice --> Undefined variable: datgroupmenu /home/ssc/metalsindo_dev/application/modules/menus/views/menus_form.php 70
ERROR - 2020-11-06 08:56:25 --> Severity: Notice --> Undefined variable: datgroupmenu /home/ssc/metalsindo_dev/application/modules/menus/views/menus_form.php 70
ERROR - 2020-11-06 08:56:49 --> Severity: Notice --> Undefined variable: datgroupmenu /home/ssc/metalsindo_dev/application/modules/menus/views/menus_form.php 70
ERROR - 2020-11-06 09:07:46 --> Severity: Notice --> Undefined variable: datgroupmenu /home/ssc/metalsindo_dev/application/modules/menus/views/menus_form.php 70
ERROR - 2020-11-06 09:12:07 --> Severity: Notice --> Undefined variable: datgroupmenu /home/ssc/metalsindo_dev/application/modules/menus/views/menus_form.php 70
ERROR - 2020-11-06 10:55:37 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-11-06 10:55:38 --> 404 Page Not Found: /index
ERROR - 2020-11-06 11:14:36 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'as `totalweight`) AS `totalweight as totalweight`
FROM `stock_material` `a`
JOIN' at line 1 - Invalid query: SELECT SUM(`a`.`totalweight` as `totalweight`) AS `totalweight as totalweight`
FROM `stock_material` `a`
JOIN `ms_gudang` `b` ON `b`.`id_gudang` =`a`.`id_gudang`
WHERE `a`.`id_gudang` = '1'
ERROR - 2020-11-06 11:20:21 --> Query error: Unknown column 'a.totalweght' in 'field list' - Invalid query: SELECT SUM(`a`.`totalweght`) AS `totalweght`, `totalweight`
FROM `stock_material` `a`
JOIN `ms_gudang` `b` ON `b`.`id_gudang` =`a`.`id_gudang`
WHERE `a`.`id_gudang` = '1'
ERROR - 2020-11-06 11:20:42 --> Query error: Unknown column 'a.totalweght' in 'field list' - Invalid query: SELECT SUM(`a`.`totalweght`) AS `totalweght`
FROM `stock_material` `a`
JOIN `ms_gudang` `b` ON `b`.`id_gudang` =`a`.`id_gudang`
WHERE `a`.`id_gudang` = '1'
ERROR - 2020-11-06 11:20:56 --> Severity: Error --> Class 'Inventory_4_model' not found /home/ssc/metalsindo_dev/application/third_party/MX/Loader.php 228
ERROR - 2020-11-06 13:28:41 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-11-06 13:28:42 --> 404 Page Not Found: /index
ERROR - 2020-11-06 14:39:22 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/ssc/metalsindo_dev/assets/html2pdf/html2pdf/_tcpdf_5.0.002/tcpdf.php:6133) /home/ssc/metalsindo_dev/assets/html2pdf/html2pdf/_tcpdf_5.0.002/tcpdf.php 6122
ERROR - 2020-11-06 15:33:14 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-11-06 15:33:15 --> 404 Page Not Found: /index
ERROR - 2020-11-06 16:59:04 --> Query error: Not unique table/alias: 'b' - Invalid query: SELECT `a`.*, `b`.`nama_gudang` as `nama_gudang`
FROM `stock_material` `a`
JOIN `ms_gudang` `b` ON `b`.`id_gudang` =`a`.`id_gudang`
JOIN `ms_inventory_category3` `b` ON `a`.`id_category3` =`a`.`id_category3`
WHERE `a`.`id_gudang` = '3'
ERROR - 2020-11-06 17:02:09 --> Severity: Warning --> Missing argument 1 for Penawaran_shearing::ViewHeader() /home/ssc/metalsindo_dev/application/modules/penawaran_shearing/controllers/Penawaran_shearing.php 155
