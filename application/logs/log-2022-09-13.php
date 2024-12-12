<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2022-09-13 09:43:43 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /var/www/html/waterco/application/modules/users/views/login_animate.php 6
ERROR - 2022-09-13 09:43:43 --> 404 Page Not Found: /index
ERROR - 2022-09-13 10:21:49 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /var/www/html/waterco/application/modules/users/views/login_animate.php 6
ERROR - 2022-09-13 10:21:53 --> 404 Page Not Found: /index
ERROR - 2022-09-13 10:24:56 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /var/www/html/waterco/application/modules/users/views/login_animate.php 6
ERROR - 2022-09-13 10:24:58 --> 404 Page Not Found: /index
ERROR - 2022-09-13 10:25:45 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /var/www/html/waterco/application/modules/users/views/login_animate.php 6
ERROR - 2022-09-13 10:25:46 --> 404 Page Not Found: /index
ERROR - 2022-09-13 10:55:07 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /var/www/html/waterco/application/modules/users/views/login_animate.php 6
ERROR - 2022-09-13 10:55:07 --> 404 Page Not Found: /index
ERROR - 2022-09-13 11:35:08 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /var/www/html/waterco/application/modules/users/views/login_animate.php 6
ERROR - 2022-09-13 11:35:08 --> 404 Page Not Found: /index
ERROR - 2022-09-13 12:00:46 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /var/www/html/waterco/application/modules/users/views/login_animate.php 6
ERROR - 2022-09-13 12:00:47 --> 404 Page Not Found: /index
ERROR - 2022-09-13 11:01:12 --> Severity: Notice --> Undefined variable: datgroupmenu /var/www/html/waterco/application/modules/menus/views/menus_form.php 70
ERROR - 2022-09-13 11:03:13 --> Severity: Notice --> Undefined variable: datgroupmenu /var/www/html/waterco/application/modules/menus/views/menus_form.php 70
ERROR - 2022-09-13 05:03:19 --> Severity: error --> Exception: Unable to locate the model you have specified: Acc_model /var/www/html/waterco/system/core/Loader.php 344
ERROR - 2022-09-13 11:04:14 --> Query error: Table 'waterco_live.tr_invoice_payment' doesn't exist - Invalid query: SELECT a.*, c.invoiced, c.totalinvoiced FROM tr_invoice_payment a	        
        left outer join (
            SELECT kd_pembayaran,
            GROUP_CONCAT(no_invoice SEPARATOR ',') as invoiced,
            sum(total_bayar_idr) as totalinvoiced
            FROM tr_invoice_payment_detail
            GROUP BY kd_pembayaran
        ) c on a.kd_pembayaran=c.kd_pembayaran       
        
ERROR - 2022-09-13 11:05:46 --> Query error: Unknown database 'DBACC' - Invalid query: SELECT *
FROM `DBACC`.`pastibisa_tb_cabang`
WHERE `nocab` = '101'
ERROR - 2022-09-13 11:07:56 --> Severity: Notice --> Undefined variable: datgroupmenu /var/www/html/waterco/application/modules/menus/views/menus_form.php 70
ERROR - 2022-09-13 11:08:13 --> Severity: Notice --> Undefined variable: datgroupmenu /var/www/html/waterco/application/modules/menus/views/menus_form.php 70
ERROR - 2022-09-13 11:09:06 --> Severity: Notice --> Undefined variable: datgroupmenu /var/www/html/waterco/application/modules/menus/views/menus_form.php 70
ERROR - 2022-09-13 11:09:17 --> Severity: Notice --> Undefined variable: datgroupmenu /var/www/html/waterco/application/modules/menus/views/menus_form.php 70
ERROR - 2022-09-13 11:09:31 --> Severity: Notice --> Undefined variable: datgroupmenu /var/www/html/waterco/application/modules/menus/views/menus_form.php 70
ERROR - 2022-09-13 12:10:03 --> 404 Page Not Found: ../modules/stock_material/controllers/Stock_material/view_kartu_stok
ERROR - 2022-09-13 11:11:48 --> Severity: Error --> Call to undefined method Inventory_4_model::cariKartuStok() /var/www/html/waterco/application/modules/stock_material/controllers/Stock_material.php 1011
ERROR - 2022-09-13 11:12:55 --> Severity: Error --> Call to undefined method Inventory_4_model::cariKartuStok() /var/www/html/waterco/application/modules/stock_material/controllers/Stock_material.php 1011
ERROR - 2022-09-13 11:14:25 --> Severity: Notice --> Undefined variable: datgroupmenu /var/www/html/waterco/application/modules/menus/views/menus_form.php 70
ERROR - 2022-09-13 11:15:50 --> Severity: Notice --> Undefined variable: datgroupmenu /var/www/html/waterco/application/modules/menus/views/menus_form.php 70
ERROR - 2022-09-13 11:15:57 --> Query error: Table 'waterco_live.matauang' doesn't exist - Invalid query: SELECT *
FROM `matauang`
ERROR - 2022-09-13 14:09:14 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /var/www/html/waterco/application/modules/users/views/login_animate.php 6
ERROR - 2022-09-13 14:09:14 --> 404 Page Not Found: /index
ERROR - 2022-09-13 13:13:45 --> Query error: Unknown database 'DBACC' - Invalid query: SELECT *
FROM `DBACC`.`pastibisa_tb_cabang`
WHERE `nocab` = '101'
ERROR - 2022-09-13 14:23:06 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /var/www/html/waterco/application/modules/users/views/login_animate.php 6
ERROR - 2022-09-13 14:23:06 --> 404 Page Not Found: /index
ERROR - 2022-09-13 14:34:26 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /var/www/html/waterco/application/modules/users/views/login_animate.php 6
ERROR - 2022-09-13 14:34:26 --> 404 Page Not Found: /index
ERROR - 2022-09-13 15:59:30 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /var/www/html/waterco/application/modules/users/views/login_animate.php 6
ERROR - 2022-09-13 15:59:30 --> 404 Page Not Found: /index
ERROR - 2022-09-13 16:33:32 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /var/www/html/waterco/application/modules/users/views/login_animate.php 6
ERROR - 2022-09-13 16:33:32 --> 404 Page Not Found: /index
ERROR - 2022-09-13 16:45:22 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /var/www/html/waterco/application/modules/users/views/login_animate.php 6
ERROR - 2022-09-13 16:45:23 --> 404 Page Not Found: /index
ERROR - 2022-09-13 17:10:32 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /var/www/html/waterco/application/modules/users/views/login_animate.php 6
ERROR - 2022-09-13 17:10:33 --> 404 Page Not Found: /index
ERROR - 2022-09-13 17:48:07 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /var/www/html/waterco/application/modules/users/views/login_animate.php 6
ERROR - 2022-09-13 17:48:07 --> 404 Page Not Found: /index
ERROR - 2022-09-13 17:52:05 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /var/www/html/waterco/application/modules/users/views/login_animate.php 6
ERROR - 2022-09-13 17:52:06 --> 404 Page Not Found: /index
ERROR - 2022-09-13 17:52:37 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /var/www/html/waterco/application/modules/users/views/login_animate.php 6
ERROR - 2022-09-13 17:52:39 --> 404 Page Not Found: /index
ERROR - 2022-09-13 17:54:26 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /var/www/html/waterco/application/modules/users/views/login_animate.php 6
ERROR - 2022-09-13 17:54:26 --> 404 Page Not Found: /index
ERROR - 2022-09-13 17:54:49 --> Severity: Notice --> Undefined variable: cabang /var/www/html/waterco/application/modules/users/views/users_form.php 68
ERROR - 2022-09-13 17:54:49 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/waterco/application/modules/users/views/users_form.php 68
ERROR - 2022-09-13 17:55:04 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /var/www/html/waterco/application/modules/users/views/login_animate.php 6
ERROR - 2022-09-13 17:55:04 --> 404 Page Not Found: /index
ERROR - 2022-09-13 17:55:13 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /var/www/html/waterco/application/modules/users/views/login_animate.php 6
ERROR - 2022-09-13 17:55:13 --> 404 Page Not Found: /index
ERROR - 2022-09-13 17:55:32 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /var/www/html/waterco/application/modules/users/views/login_animate.php 6
ERROR - 2022-09-13 17:55:32 --> 404 Page Not Found: /index
ERROR - 2022-09-13 17:56:53 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /var/www/html/waterco/application/modules/users/views/login_animate.php 6
ERROR - 2022-09-13 17:56:53 --> 404 Page Not Found: /index
ERROR - 2022-09-13 17:57:26 --> Severity: Notice --> Undefined variable: data /var/www/html/waterco/application/modules/users/views/users_form.php 70
ERROR - 2022-09-13 17:57:26 --> Severity: Notice --> Trying to get property of non-object /var/www/html/waterco/application/modules/users/views/users_form.php 70
ERROR - 2022-09-13 17:57:26 --> Severity: Notice --> Undefined variable: data /var/www/html/waterco/application/modules/users/views/users_form.php 70
ERROR - 2022-09-13 17:57:26 --> Severity: Notice --> Trying to get property of non-object /var/www/html/waterco/application/modules/users/views/users_form.php 70
ERROR - 2022-09-13 17:57:26 --> Severity: Notice --> Undefined variable: data /var/www/html/waterco/application/modules/users/views/users_form.php 70
ERROR - 2022-09-13 17:57:26 --> Severity: Notice --> Trying to get property of non-object /var/www/html/waterco/application/modules/users/views/users_form.php 70
ERROR - 2022-09-13 17:57:26 --> Severity: Notice --> Undefined variable: data /var/www/html/waterco/application/modules/users/views/users_form.php 70
ERROR - 2022-09-13 17:57:26 --> Severity: Notice --> Trying to get property of non-object /var/www/html/waterco/application/modules/users/views/users_form.php 70
ERROR - 2022-09-13 18:00:38 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /var/www/html/waterco/application/modules/users/views/login_animate.php 6
ERROR - 2022-09-13 18:00:38 --> 404 Page Not Found: /index
ERROR - 2022-09-13 18:00:59 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /var/www/html/waterco/application/modules/users/views/login_animate.php 6
ERROR - 2022-09-13 18:01:00 --> 404 Page Not Found: /index
ERROR - 2022-09-13 18:01:00 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /var/www/html/waterco/application/modules/users/views/login_animate.php 6
ERROR - 2022-09-13 18:01:00 --> 404 Page Not Found: /index
ERROR - 2022-09-13 18:01:19 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /var/www/html/waterco/application/modules/users/views/login_animate.php 6
ERROR - 2022-09-13 18:01:19 --> 404 Page Not Found: /index
ERROR - 2022-09-13 18:03:22 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /var/www/html/waterco/application/modules/users/views/login_animate.php 6
ERROR - 2022-09-13 18:03:22 --> 404 Page Not Found: /index
ERROR - 2022-09-13 17:05:39 --> Severity: Notice --> Undefined variable: datgroupmenu /var/www/html/waterco/application/modules/menus/views/menus_form.php 70
ERROR - 2022-09-13 18:08:33 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /var/www/html/waterco/application/modules/users/views/login_animate.php 6
ERROR - 2022-09-13 18:08:33 --> 404 Page Not Found: /index
ERROR - 2022-09-13 18:09:29 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /var/www/html/waterco/application/modules/users/views/login_animate.php 6
ERROR - 2022-09-13 18:09:29 --> 404 Page Not Found: /index
ERROR - 2022-09-13 18:10:28 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /var/www/html/waterco/application/modules/users/views/login_animate.php 6
ERROR - 2022-09-13 18:10:28 --> 404 Page Not Found: /index
ERROR - 2022-09-13 17:10:42 --> Severity: Notice --> Undefined variable: datgroupmenu /var/www/html/waterco/application/modules/menus/views/menus_form.php 70
ERROR - 2022-09-13 18:10:47 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /var/www/html/waterco/application/modules/users/views/login_animate.php 6
ERROR - 2022-09-13 18:10:47 --> 404 Page Not Found: /index
ERROR - 2022-09-13 18:11:02 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /var/www/html/waterco/application/modules/users/views/login_animate.php 6
ERROR - 2022-09-13 18:11:02 --> 404 Page Not Found: /index
ERROR - 2022-09-13 17:12:19 --> Severity: Notice --> Undefined variable: datgroupmenu /var/www/html/waterco/application/modules/menus/views/menus_form.php 70
ERROR - 2022-09-13 17:12:33 --> Severity: Notice --> Undefined variable: datgroupmenu /var/www/html/waterco/application/modules/menus/views/menus_form.php 70
ERROR - 2022-09-13 18:12:59 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /var/www/html/waterco/application/modules/users/views/login_animate.php 6
ERROR - 2022-09-13 18:12:59 --> 404 Page Not Found: /index
ERROR - 2022-09-13 18:13:23 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /var/www/html/waterco/application/modules/users/views/login_animate.php 6
ERROR - 2022-09-13 18:13:23 --> 404 Page Not Found: /index
ERROR - 2022-09-13 18:13:34 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /var/www/html/waterco/application/modules/users/views/login_animate.php 6
ERROR - 2022-09-13 18:13:34 --> 404 Page Not Found: /index
ERROR - 2022-09-13 17:17:03 --> Severity: Notice --> Undefined variable: datgroupmenu /var/www/html/waterco/application/modules/menus/views/menus_form.php 70
ERROR - 2022-09-13 18:17:12 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /var/www/html/waterco/application/modules/users/views/login_animate.php 6
ERROR - 2022-09-13 18:17:12 --> 404 Page Not Found: /index
ERROR - 2022-09-13 18:17:22 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /var/www/html/waterco/application/modules/users/views/login_animate.php 6
ERROR - 2022-09-13 18:17:22 --> 404 Page Not Found: /index
ERROR - 2022-09-13 17:18:32 --> Severity: Notice --> Undefined variable: datgroupmenu /var/www/html/waterco/application/modules/menus/views/menus_form.php 70
ERROR - 2022-09-13 17:18:43 --> Severity: Notice --> Undefined variable: datgroupmenu /var/www/html/waterco/application/modules/menus/views/menus_form.php 70
ERROR - 2022-09-13 18:18:58 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /var/www/html/waterco/application/modules/users/views/login_animate.php 6
ERROR - 2022-09-13 18:18:59 --> 404 Page Not Found: /index
ERROR - 2022-09-13 18:19:25 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /var/www/html/waterco/application/modules/users/views/login_animate.php 6
ERROR - 2022-09-13 18:19:25 --> 404 Page Not Found: /index
ERROR - 2022-09-13 17:19:52 --> Severity: Notice --> Undefined variable: datgroupmenu /var/www/html/waterco/application/modules/menus/views/menus_form.php 70
ERROR - 2022-09-13 18:21:07 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /var/www/html/waterco/application/modules/users/views/login_animate.php 6
ERROR - 2022-09-13 18:21:07 --> 404 Page Not Found: /index
ERROR - 2022-09-13 22:01:29 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /var/www/html/waterco/application/modules/users/views/login_animate.php 6
ERROR - 2022-09-13 22:01:29 --> 404 Page Not Found: /index
ERROR - 2022-09-13 22:22:54 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /var/www/html/waterco/application/modules/users/views/login_animate.php 6
ERROR - 2022-09-13 22:22:54 --> 404 Page Not Found: /index
ERROR - 2022-09-13 22:26:15 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /var/www/html/waterco/application/modules/users/views/login_animate.php 6
ERROR - 2022-09-13 22:26:19 --> 404 Page Not Found: /index
ERROR - 2022-09-13 22:30:22 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /var/www/html/waterco/application/modules/users/views/login_animate.php 6
ERROR - 2022-09-13 22:30:43 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /var/www/html/waterco/application/modules/users/views/login_animate.php 6
ERROR - 2022-09-13 22:30:51 --> 404 Page Not Found: /index
ERROR - 2022-09-13 21:30:53 --> Severity: Warning --> Invalid argument supplied for foreach() /var/www/html/waterco/application/modules/wt_penawaran/controllers/Wt_penawaran.php 252
