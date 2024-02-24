<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2019-11-25 08:49:42 --> Severity: Warning --> mysqli::real_connect(): (HY000/1049): Unknown database 'idefab_dev' D:\Ampps\www\IT_Sentral\idefab_dev\system\database\drivers\mysqli\mysqli_driver.php 202
ERROR - 2019-11-25 08:49:43 --> Unable to connect to the database
ERROR - 2019-11-25 09:03:35 --> Severity: Notice --> Use of undefined constant php - assumed 'php' D:\Ampps\www\IT_Sentral\idefab_dev\application\modules\users\views\login_animate.php 6
ERROR - 2019-11-25 09:03:45 --> Query error: Table 'idefab_dev.view_invoice_payment' doesn't exist - Invalid query: SELECT
							  SUM(CASE WHEN umur <= 15 THEN (hargajualtotal - jum_bayar) ELSE 0 END) AS umur_15,
							  SUM(CASE WHEN umur > 15 AND umur <= 30 THEN (hargajualtotal - jum_bayar) ELSE 0 END) AS umur_30,
							  SUM(CASE WHEN umur > 30 AND umur <= 60 THEN (hargajualtotal - jum_bayar) ELSE 0 END) AS umur_60,
							  SUM(CASE WHEN umur > 60 AND umur <= 90 THEN (hargajualtotal - jum_bayar) ELSE 0 END) AS umur_90,
							  SUM(CASE WHEN umur > 90 THEN (hargajualtotal - jum_bayar) ELSE 0 END) AS umur_91
							FROM
								view_invoice_payment
							WHERE
								 (hargajualtotal - jum_bayar) > 0 AND kdcab='101'
ERROR - 2019-11-25 09:04:27 --> Query error: Table 'idefab_dev.view_invoice_payment' doesn't exist - Invalid query: SELECT
							  SUM(CASE WHEN umur <= 15 THEN (hargajualtotal - jum_bayar) ELSE 0 END) AS umur_15,
							  SUM(CASE WHEN umur > 15 AND umur <= 30 THEN (hargajualtotal - jum_bayar) ELSE 0 END) AS umur_30,
							  SUM(CASE WHEN umur > 30 AND umur <= 60 THEN (hargajualtotal - jum_bayar) ELSE 0 END) AS umur_60,
							  SUM(CASE WHEN umur > 60 AND umur <= 90 THEN (hargajualtotal - jum_bayar) ELSE 0 END) AS umur_90,
							  SUM(CASE WHEN umur > 90 THEN (hargajualtotal - jum_bayar) ELSE 0 END) AS umur_91
							FROM
								view_invoice_payment
							WHERE
								 (hargajualtotal - jum_bayar) > 0 AND kdcab='101'
ERROR - 2019-11-25 09:04:32 --> Severity: error --> Exception: Unable to locate the model you have specified: Bidus_model D:\Ampps\www\IT_Sentral\idefab_dev\system\core\Loader.php 344
ERROR - 2019-11-25 09:04:43 --> Severity: error --> Exception: Unable to locate the model you have specified: Bidus_model D:\Ampps\www\IT_Sentral\idefab_dev\system\core\Loader.php 344
ERROR - 2019-11-25 09:04:43 --> Severity: error --> Exception: Unable to locate the model you have specified: Bidus_model D:\Ampps\www\IT_Sentral\idefab_dev\system\core\Loader.php 344
ERROR - 2019-11-25 09:04:46 --> Query error: Table 'idefab_dev.view_invoice_payment' doesn't exist - Invalid query: SELECT
							  SUM(CASE WHEN umur <= 15 THEN (hargajualtotal - jum_bayar) ELSE 0 END) AS umur_15,
							  SUM(CASE WHEN umur > 15 AND umur <= 30 THEN (hargajualtotal - jum_bayar) ELSE 0 END) AS umur_30,
							  SUM(CASE WHEN umur > 30 AND umur <= 60 THEN (hargajualtotal - jum_bayar) ELSE 0 END) AS umur_60,
							  SUM(CASE WHEN umur > 60 AND umur <= 90 THEN (hargajualtotal - jum_bayar) ELSE 0 END) AS umur_90,
							  SUM(CASE WHEN umur > 90 THEN (hargajualtotal - jum_bayar) ELSE 0 END) AS umur_91
							FROM
								view_invoice_payment
							WHERE
								 (hargajualtotal - jum_bayar) > 0 AND kdcab='101'
ERROR - 2019-11-25 09:06:53 --> Query error: Table 'idefab_dev.view_invoice_payment' doesn't exist - Invalid query: SELECT
							  SUM(CASE WHEN umur <= 15 THEN (hargajualtotal - jum_bayar) ELSE 0 END) AS umur_15,
							  SUM(CASE WHEN umur > 15 AND umur <= 30 THEN (hargajualtotal - jum_bayar) ELSE 0 END) AS umur_30,
							  SUM(CASE WHEN umur > 30 AND umur <= 60 THEN (hargajualtotal - jum_bayar) ELSE 0 END) AS umur_60,
							  SUM(CASE WHEN umur > 60 AND umur <= 90 THEN (hargajualtotal - jum_bayar) ELSE 0 END) AS umur_90,
							  SUM(CASE WHEN umur > 90 THEN (hargajualtotal - jum_bayar) ELSE 0 END) AS umur_91
							FROM
								view_invoice_payment
							WHERE
								 (hargajualtotal - jum_bayar) > 0 AND kdcab='101'
ERROR - 2019-11-25 09:07:09 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at D:\Ampps\www\IT_Sentral\idefab_dev\application\libraries\Menu_generator.php:150) D:\Ampps\www\IT_Sentral\idefab_dev\system\core\Common.php 573
ERROR - 2019-11-25 09:07:09 --> Severity: Compile Error --> 'goto' to undefined label 'end_for_sub' D:\Ampps\www\IT_Sentral\idefab_dev\application\libraries\Menu_generator.php 150
ERROR - 2019-11-25 09:07:37 --> Query error: Table 'idefab_dev.view_invoice_payment' doesn't exist - Invalid query: SELECT
							  SUM(CASE WHEN umur <= 15 THEN (hargajualtotal - jum_bayar) ELSE 0 END) AS umur_15,
							  SUM(CASE WHEN umur > 15 AND umur <= 30 THEN (hargajualtotal - jum_bayar) ELSE 0 END) AS umur_30,
							  SUM(CASE WHEN umur > 30 AND umur <= 60 THEN (hargajualtotal - jum_bayar) ELSE 0 END) AS umur_60,
							  SUM(CASE WHEN umur > 60 AND umur <= 90 THEN (hargajualtotal - jum_bayar) ELSE 0 END) AS umur_90,
							  SUM(CASE WHEN umur > 90 THEN (hargajualtotal - jum_bayar) ELSE 0 END) AS umur_91
							FROM
								view_invoice_payment
							WHERE
								 (hargajualtotal - jum_bayar) > 0 AND kdcab='101'
ERROR - 2019-11-25 16:07:44 --> Query error: Table 'idefab_dev.cabang' doesn't exist - Invalid query: SELECT *
FROM `cabang`
WHERE `deleted` =0
ORDER BY `namacabang` ASC
ERROR - 2019-11-25 09:07:57 --> Query error: Table 'idefab_dev.view_invoice_payment' doesn't exist - Invalid query: SELECT
							  SUM(CASE WHEN umur <= 15 THEN (hargajualtotal - jum_bayar) ELSE 0 END) AS umur_15,
							  SUM(CASE WHEN umur > 15 AND umur <= 30 THEN (hargajualtotal - jum_bayar) ELSE 0 END) AS umur_30,
							  SUM(CASE WHEN umur > 30 AND umur <= 60 THEN (hargajualtotal - jum_bayar) ELSE 0 END) AS umur_60,
							  SUM(CASE WHEN umur > 60 AND umur <= 90 THEN (hargajualtotal - jum_bayar) ELSE 0 END) AS umur_90,
							  SUM(CASE WHEN umur > 90 THEN (hargajualtotal - jum_bayar) ELSE 0 END) AS umur_91
							FROM
								view_invoice_payment
							WHERE
								 (hargajualtotal - jum_bayar) > 0 AND kdcab='101'
ERROR - 2019-11-25 16:08:15 --> Severity: Notice --> Undefined variable: datmenu D:\Ampps\www\IT_Sentral\idefab_dev\application\modules\menus\views\menus_form.php 53
ERROR - 2019-11-25 16:08:15 --> Severity: Notice --> Undefined variable: datgroupmenu D:\Ampps\www\IT_Sentral\idefab_dev\application\modules\menus\views\menus_form.php 69
ERROR - 2019-11-25 16:09:14 --> Severity: Notice --> Undefined variable: datmenu D:\Ampps\www\IT_Sentral\idefab_dev\application\modules\menus\views\menus_form.php 53
ERROR - 2019-11-25 16:09:14 --> Severity: Notice --> Undefined variable: datgroupmenu D:\Ampps\www\IT_Sentral\idefab_dev\application\modules\menus\views\menus_form.php 69
ERROR - 2019-11-25 16:09:48 --> Severity: Notice --> Undefined variable: datmenu D:\Ampps\www\IT_Sentral\idefab_dev\application\modules\menus\views\menus_form.php 53
ERROR - 2019-11-25 16:09:48 --> Severity: Notice --> Undefined variable: datgroupmenu D:\Ampps\www\IT_Sentral\idefab_dev\application\modules\menus\views\menus_form.php 69
ERROR - 2019-11-25 16:10:02 --> Severity: Notice --> Undefined variable: datmenu D:\Ampps\www\IT_Sentral\idefab_dev\application\modules\menus\views\menus_form.php 53
ERROR - 2019-11-25 16:10:02 --> Severity: Notice --> Undefined variable: datgroupmenu D:\Ampps\www\IT_Sentral\idefab_dev\application\modules\menus\views\menus_form.php 69
ERROR - 2019-11-25 09:11:20 --> 404 Page Not Found: /index
ERROR - 2019-11-25 16:36:51 --> Severity: Notice --> Undefined variable: parent D:\Ampps\www\IT_Sentral\idefab_dev\application\modules\menus\views\menus_form.php 53
ERROR - 2019-11-25 16:36:51 --> Severity: Notice --> Undefined variable: datgroupmenu D:\Ampps\www\IT_Sentral\idefab_dev\application\modules\menus\views\menus_form.php 69
ERROR - 2019-11-25 16:39:46 --> Severity: Notice --> Undefined variable: parent D:\Ampps\www\IT_Sentral\idefab_dev\application\modules\menus\views\menus_form.php 53
ERROR - 2019-11-25 16:39:46 --> Severity: Notice --> Undefined variable: datgroupmenu D:\Ampps\www\IT_Sentral\idefab_dev\application\modules\menus\views\menus_form.php 69
ERROR - 2019-11-25 16:42:21 --> Severity: Notice --> Undefined variable: parent D:\Ampps\www\IT_Sentral\idefab_dev\application\modules\menus\views\menus_form.php 53
ERROR - 2019-11-25 16:42:21 --> Severity: Notice --> Undefined variable: datgroupmenu D:\Ampps\www\IT_Sentral\idefab_dev\application\modules\menus\views\menus_form.php 69
ERROR - 2019-11-25 16:44:50 --> Severity: Notice --> Undefined variable: parent D:\Ampps\www\IT_Sentral\idefab_dev\application\modules\menus\views\menus_form.php 53
ERROR - 2019-11-25 16:44:50 --> Severity: Notice --> Undefined variable: datgroupmenu D:\Ampps\www\IT_Sentral\idefab_dev\application\modules\menus\views\menus_form.php 69
ERROR - 2019-11-25 16:46:07 --> Severity: Notice --> Undefined variable: parent D:\Ampps\www\IT_Sentral\idefab_dev\application\modules\menus\views\menus_form.php 53
ERROR - 2019-11-25 16:46:07 --> Severity: Notice --> Undefined variable: datgroupmenu D:\Ampps\www\IT_Sentral\idefab_dev\application\modules\menus\views\menus_form.php 69
ERROR - 2019-11-25 14:44:43 --> Severity: Notice --> Use of undefined constant php - assumed 'php' D:\Ampps\www\IT_Sentral\idefab_dev\application\modules\users\views\login_animate.php 6
ERROR - 2019-11-25 14:44:46 --> Severity: Notice --> Use of undefined constant php - assumed 'php' D:\Ampps\www\IT_Sentral\idefab_dev\application\modules\users\views\login_animate.php 6
