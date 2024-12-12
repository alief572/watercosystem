<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2019-11-26 03:13:00 --> Query error: Table 'idefab_dev.view_invoice_payment' doesn't exist - Invalid query: SELECT
							  SUM(CASE WHEN umur <= 15 THEN (hargajualtotal - jum_bayar) ELSE 0 END) AS umur_15,
							  SUM(CASE WHEN umur > 15 AND umur <= 30 THEN (hargajualtotal - jum_bayar) ELSE 0 END) AS umur_30,
							  SUM(CASE WHEN umur > 30 AND umur <= 60 THEN (hargajualtotal - jum_bayar) ELSE 0 END) AS umur_60,
							  SUM(CASE WHEN umur > 60 AND umur <= 90 THEN (hargajualtotal - jum_bayar) ELSE 0 END) AS umur_90,
							  SUM(CASE WHEN umur > 90 THEN (hargajualtotal - jum_bayar) ELSE 0 END) AS umur_91
							FROM
								view_invoice_payment
							WHERE
								 (hargajualtotal - jum_bayar) > 0 AND kdcab='101'
ERROR - 2019-11-26 03:17:20 --> Query error: Table 'idefab_dev.view_invoice_payment' doesn't exist - Invalid query: SELECT
							  SUM(CASE WHEN umur <= 15 THEN (hargajualtotal - jum_bayar) ELSE 0 END) AS umur_15,
							  SUM(CASE WHEN umur > 15 AND umur <= 30 THEN (hargajualtotal - jum_bayar) ELSE 0 END) AS umur_30,
							  SUM(CASE WHEN umur > 30 AND umur <= 60 THEN (hargajualtotal - jum_bayar) ELSE 0 END) AS umur_60,
							  SUM(CASE WHEN umur > 60 AND umur <= 90 THEN (hargajualtotal - jum_bayar) ELSE 0 END) AS umur_90,
							  SUM(CASE WHEN umur > 90 THEN (hargajualtotal - jum_bayar) ELSE 0 END) AS umur_91
							FROM
								view_invoice_payment
							WHERE
								 (hargajualtotal - jum_bayar) > 0 AND kdcab='101'
ERROR - 2019-11-26 03:19:14 --> Severity: Notice --> Use of undefined constant php - assumed 'php' D:\Ampps\www\IT_Sentral\idefab_dev\application\modules\users\views\login_animate.php 6
ERROR - 2019-11-26 03:19:23 --> Query error: Table 'idefab_dev.view_invoice_payment' doesn't exist - Invalid query: SELECT
							  SUM(CASE WHEN umur <= 15 THEN (hargajualtotal - jum_bayar) ELSE 0 END) AS umur_15,
							  SUM(CASE WHEN umur > 15 AND umur <= 30 THEN (hargajualtotal - jum_bayar) ELSE 0 END) AS umur_30,
							  SUM(CASE WHEN umur > 30 AND umur <= 60 THEN (hargajualtotal - jum_bayar) ELSE 0 END) AS umur_60,
							  SUM(CASE WHEN umur > 60 AND umur <= 90 THEN (hargajualtotal - jum_bayar) ELSE 0 END) AS umur_90,
							  SUM(CASE WHEN umur > 90 THEN (hargajualtotal - jum_bayar) ELSE 0 END) AS umur_91
							FROM
								view_invoice_payment
							WHERE
								 (hargajualtotal - jum_bayar) > 0 AND kdcab='101'
ERROR - 2019-11-26 10:25:31 --> Severity: Notice --> Undefined variable: datgroupmenu D:\Ampps\www\IT_Sentral\idefab_dev\application\modules\menus\views\menus_form.php 70
ERROR - 2019-11-26 10:26:12 --> Severity: Notice --> Undefined variable: datgroupmenu D:\Ampps\www\IT_Sentral\idefab_dev\application\modules\menus\views\menus_form.php 70
ERROR - 2019-11-26 10:28:02 --> Severity: Notice --> Undefined variable: datgroupmenu D:\Ampps\www\IT_Sentral\idefab_dev\application\modules\menus\views\menus_form.php 70
ERROR - 2019-11-26 10:29:28 --> Severity: Notice --> Undefined variable: datgroupmenu D:\Ampps\www\IT_Sentral\idefab_dev\application\modules\menus\views\menus_form.php 70
ERROR - 2019-11-26 03:29:44 --> 404 Page Not Found: /index
ERROR - 2019-11-26 10:30:40 --> Query error: Table 'idefab_dev.supplier' doesn't exist - Invalid query: SELECT `supplier`.`id_supplier`, `supplier`.`nm_supplier`, `supplier`.`id_negara`, `supplier`.`id_prov`, `supplier`.`id_kab`, `supplier`.`mata_uang`, `supplier`.`alamat`, `supplier`.`telpon`, `supplier`.`fax`, `supplier`.`email`, `supplier`.`cp`, `supplier`.`hp_cp`, `supplier`.`id_webchat`, `supplier`.`npwp`, `supplier`.`alamat_npwp`, `supplier`.`keterangan`, `supplier`.`sts_aktif`, `negara`.`nm_negara`
FROM `supplier`
JOIN `negara` ON `negara`.`id_negara` = `supplier`.`id_negara`
WHERE `supplier`.`deleted` =0
ORDER BY `id_supplier` ASC
ERROR - 2019-11-26 10:31:53 --> Query error: Table 'idefab_dev.supplier' doesn't exist - Invalid query: SELECT `supplier`.`id_supplier`, `supplier`.`nm_supplier`, `supplier`.`id_negara`, `supplier`.`id_prov`, `supplier`.`id_kab`, `supplier`.`mata_uang`, `supplier`.`alamat`, `supplier`.`telpon`, `supplier`.`fax`, `supplier`.`email`, `supplier`.`cp`, `supplier`.`hp_cp`, `supplier`.`id_webchat`, `supplier`.`npwp`, `supplier`.`alamat_npwp`, `supplier`.`keterangan`, `supplier`.`sts_aktif`, `negara`.`nm_negara`
FROM `supplier`
JOIN `negara` ON `negara`.`id_negara` = `supplier`.`id_negara`
WHERE `supplier`.`deleted` =0
ORDER BY `id_supplier` ASC
ERROR - 2019-11-26 12:23:54 --> Could not find the language line "supplier_btn_new"
ERROR - 2019-11-26 12:23:54 --> Could not find the language line "supplier_btn_new"
ERROR - 2019-11-26 12:23:54 --> Could not find the language line "supplier_no_records_found"
ERROR - 2019-11-26 05:25:16 --> 404 Page Not Found: /index
ERROR - 2019-11-26 05:26:36 --> 404 Page Not Found: /index
ERROR - 2019-11-26 06:27:51 --> 404 Page Not Found: /index
ERROR - 2019-11-26 13:27:58 --> Severity: Notice --> Undefined variable: datgroupmenu D:\Ampps\www\IT_Sentral\idefab_dev\application\modules\menus\views\menus_form.php 70
ERROR - 2019-11-26 13:28:17 --> Severity: Notice --> Undefined variable: datgroupmenu D:\Ampps\www\IT_Sentral\idefab_dev\application\modules\menus\views\menus_form.php 70
ERROR - 2019-11-26 06:28:23 --> Severity: error --> Exception: Unable to locate the model you have specified: Supplier_model D:\Ampps\www\IT_Sentral\idefab_dev\system\core\Loader.php 344
ERROR - 2019-11-26 06:31:31 --> 404 Page Not Found: ../modules/master_supplier/controllers/Master_supplier/getDataJSONs
ERROR - 2019-11-26 13:32:31 --> Query error: Unknown column 'a.name_supplier' in 'where clause' - Invalid query: 
  			SELECT
  				a.*, b.name_country
  			FROM
  				master_supplier a
  				LEFT JOIN master_country b ON b.id_country = a.id_country
  			WHERE 1=1
           AND a.activation = 'aktif' 
  				AND a.deleted ='N' AND (
  				a.id_supplier LIKE '%%'
  				OR a.name_supplier LIKE '%%'
          OR b.name_country LIKE '%%'
  	        )
  		
