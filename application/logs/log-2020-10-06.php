<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-10-06 07:22:27 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-10-06 07:22:33 --> 404 Page Not Found: /index
ERROR - 2020-10-06 07:58:59 --> Severity: Parsing Error --> syntax error, unexpected '=>' (T_DOUBLE_ARROW) /home/ssc/metalsindo_dev/application/modules/transaksi_inquiry/controllers/Transaksi_inquiry.php 772
ERROR - 2020-10-06 07:59:20 --> Severity: Parsing Error --> syntax error, unexpected ';' /home/ssc/metalsindo_dev/application/modules/transaksi_inquiry/controllers/Transaksi_inquiry.php 788
ERROR - 2020-10-06 08:01:26 --> Severity: Parsing Error --> syntax error, unexpected 'else' (T_ELSE) /home/ssc/metalsindo_dev/application/modules/transaksi_inquiry/controllers/Transaksi_inquiry.php 808
ERROR - 2020-10-06 08:01:55 --> Severity: Parsing Error --> syntax error, unexpected '=>' (T_DOUBLE_ARROW) /home/ssc/metalsindo_dev/application/modules/transaksi_inquiry/controllers/Transaksi_inquiry.php 772
ERROR - 2020-10-06 08:03:27 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '=''' at line 1 - Invalid query: SELECT * FROM tr_inquiry id_customer='' 
ERROR - 2020-10-06 08:03:51 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '=''' at line 1 - Invalid query: SELECT * FROM tr_inquiry id_customer='' 
ERROR - 2020-10-06 08:04:06 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '=''' at line 1 - Invalid query: SELECT * FROM tr_inquiry id_customer='' 
ERROR - 2020-10-06 08:04:49 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '= ''' at line 1 - Invalid query: SELECT * FROM tr_inquiry id_customer = '' 
ERROR - 2020-10-06 08:05:28 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '= 'MC2000005'' at line 1 - Invalid query: SELECT * FROM tr_inquiry id_customer = 'MC2000005' 
ERROR - 2020-10-06 08:05:37 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '= ''' at line 1 - Invalid query: SELECT * FROM tr_inquiry id_customer = '' 
ERROR - 2020-10-06 09:09:09 --> Severity: Parsing Error --> syntax error, unexpected '">--Pilih--</option>"' (T_CONSTANT_ENCAPSED_STRING), expecting ',' or ';' /home/ssc/metalsindo_dev/application/modules/penawaran_shearing/controllers/Penawaran_shearing.php 418
ERROR - 2020-10-06 09:21:56 --> Query error: Unknown column 'no_inquiry' in 'where clause' - Invalid query: SELECT * FROM dt_inquery_transaksi WHERE no_inquiry = 'IQ2009290001' 
ERROR - 2020-10-06 09:22:26 --> Query error: Unknown column 'no_inquiry' in 'where clause' - Invalid query: SELECT * FROM dt_inquery_transaksi WHERE no_inquiry = 'IQ2010060001' 
ERROR - 2020-10-06 09:22:36 --> Query error: Unknown column 'no_inquiry' in 'where clause' - Invalid query: SELECT * FROM dt_inquery_transaksi WHERE no_inquiry = 'IQ2009290001' 
ERROR - 2020-10-06 09:23:19 --> Query error: Unknown column 'no_inquiry' in 'where clause' - Invalid query: SELECT * FROM dt_inquery_transaksi WHERE no_inquiry = 'IQ2009290001' 
ERROR - 2020-10-06 09:38:59 --> Query error: Unknown column 'no_inquiry' in 'where clause' - Invalid query: SELECT * FROM dt_inquery_transaksi WHERE no_inquiry = '' 
ERROR - 2020-10-06 09:39:10 --> Query error: Unknown column 'no_inquiry' in 'where clause' - Invalid query: SELECT * FROM dt_inquery_transaksi WHERE no_inquiry = '' 
ERROR - 2020-10-06 09:39:37 --> Query error: Unknown column 'no_inquiry' in 'where clause' - Invalid query: SELECT * FROM dt_inquery_transaksi WHERE no_inquiry = 'IQ2009290001' 
ERROR - 2020-10-06 09:39:51 --> Query error: Unknown column 'no_inquiry' in 'where clause' - Invalid query: SELECT * FROM dt_inquery_transaksi WHERE no_inquiry = 'IQ2010060001' 
ERROR - 2020-10-06 09:40:02 --> Query error: Unknown column 'no_inquiry' in 'where clause' - Invalid query: SELECT * FROM dt_inquery_transaksi WHERE no_inquiry = 'IQ2010060001' 
ERROR - 2020-10-06 09:46:01 --> Severity: Parsing Error --> syntax error, unexpected ';' /home/ssc/metalsindo_dev/application/modules/penawaran_shearing/controllers/Penawaran_shearing.php 424
ERROR - 2020-10-06 09:46:48 --> Severity: Parsing Error --> syntax error, unexpected ';' /home/ssc/metalsindo_dev/application/modules/penawaran_shearing/controllers/Penawaran_shearing.php 423
ERROR - 2020-10-06 09:56:28 --> Severity: Parsing Error --> syntax error, unexpected ';' /home/ssc/metalsindo_dev/application/modules/penawaran_shearing/controllers/Penawaran_shearing.php 417
ERROR - 2020-10-06 09:56:40 --> Severity: Parsing Error --> syntax error, unexpected ';' /home/ssc/metalsindo_dev/application/modules/penawaran_shearing/controllers/Penawaran_shearing.php 417
ERROR - 2020-10-06 11:16:39 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-10-06 11:16:42 --> 404 Page Not Found: /index
ERROR - 2020-10-06 11:17:14 --> 404 Page Not Found: /index
ERROR - 2020-10-06 11:17:24 --> Query error: Unknown column 'b.unit' in 'field list' - Invalid query: 
			SELECT
        (@row:=@row+1) AS nomor,
				a.*,
        b.unit,
        b.konversi,
        b.satuan_packing
			FROM
			   warehouse_stock a LEFT JOIN ms_material b ON a.id_material = b.code_material,
         (SELECT @row:=0) r
		   WHERE 1=1 AND kd_gudang='OPC'AND (
				a.id_material LIKE '%%'
				OR a.idmaterial LIKE '%%'
				OR a.nm_material LIKE '%%'
	        )
		
ERROR - 2020-10-06 11:17:28 --> Query error: Table 'metalsindo_db.material_wip' doesn't exist - Invalid query: 
      SELECT
      (@row:=@row+1) AS nomor,
        a.*
      FROM
        material_wip a LEFT JOIN ms_costcenter b ON a.costcenter=b.id_costcenter,
        (SELECT @row:=0) r
       WHERE 1=1 AND a.deleted='N' AND (
        a.no_wip LIKE '%%'
        OR b.nama_costcenter LIKE '%%'
          )
    
ERROR - 2020-10-06 11:17:30 --> Query error: Unknown column 'b.unit' in 'field list' - Invalid query: 
			SELECT
        (@row:=@row+1) AS nomor,
				a.*,
        b.unit,
        b.konversi,
        b.satuan_packing
			FROM
			   warehouse_stock a LEFT JOIN ms_material b ON a.id_material = b.code_material,
         (SELECT @row:=0) r
		   WHERE 1=1 AND kd_gudang='OPC'AND (
				a.id_material LIKE '%%'
				OR a.idmaterial LIKE '%%'
				OR a.nm_material LIKE '%%'
	        )
		
ERROR - 2020-10-06 11:17:33 --> Query error: Unknown column 'b.unit' in 'field list' - Invalid query: 
			SELECT
        (@row:=@row+1) AS nomor,
				a.*,
        b.unit,
        b.konversi,
        b.satuan_packing
			FROM
			   warehouse_stock a LEFT JOIN ms_material b ON a.id_material = b.code_material,
         (SELECT @row:=0) r
		   WHERE 1=1 AND kd_gudang='PRO' AND (
				a.id_material LIKE '%%'
				OR a.idmaterial LIKE '%%'
				OR a.nm_material LIKE '%%'
	        )
		
ERROR - 2020-10-06 11:22:54 --> Query error: Unknown column 'b.unit' in 'field list' - Invalid query: 
			SELECT
        (@row:=@row+1) AS nomor,
				a.*,
        b.unit,
        b.konversi,
        b.satuan_packing
			FROM
			   warehouse_stock a LEFT JOIN ms_material b ON a.id_material = b.code_material,
         (SELECT @row:=0) r
		   WHERE 1=1 AND kd_gudang='OPC'AND (
				a.id_material LIKE '%%'
				OR a.idmaterial LIKE '%%'
				OR a.nm_material LIKE '%%'
	        )
		
ERROR - 2020-10-06 11:24:29 --> Query error: Unknown column 'b.unit' in 'field list' - Invalid query: 
			SELECT
        (@row:=@row+1) AS nomor,
				a.*,
        b.unit,
        b.konversi,
        b.satuan_packing
			FROM
			   warehouse_stock a LEFT JOIN ms_material b ON a.id_material = b.code_material,
         (SELECT @row:=0) r
		   WHERE 1=1 AND kd_gudang='OPC'AND (
				a.id_material LIKE '%%'
				OR a.idmaterial LIKE '%%'
				OR a.nm_material LIKE '%%'
	        )
		
ERROR - 2020-10-06 11:31:18 --> Query error: Unknown column 'b.unit' in 'field list' - Invalid query: 
			SELECT
        (@row:=@row+1) AS nomor,
				a.*,
        b.unit,
        b.konversi,
        b.satuan_packing
			FROM
			   warehouse_stock a LEFT JOIN ms_material b ON a.id_material = b.code_material,
         (SELECT @row:=0) r
		   WHERE 1=1 AND kd_gudang='OPC'AND (
				a.id_material LIKE '%%'
				OR a.idmaterial LIKE '%%'
				OR a.nm_material LIKE '%%'
	        )
		
ERROR - 2020-10-06 11:31:29 --> Query error: Table 'metalsindo_db.material_wip' doesn't exist - Invalid query: 
      SELECT
      (@row:=@row+1) AS nomor,
        a.*
      FROM
        material_wip a LEFT JOIN ms_costcenter b ON a.costcenter=b.id_costcenter,
        (SELECT @row:=0) r
       WHERE 1=1 AND a.deleted='N' AND (
        a.no_wip LIKE '%%'
        OR b.nama_costcenter LIKE '%%'
          )
    
ERROR - 2020-10-06 11:31:33 --> Severity: Error --> Call to undefined function get_data_planning() /home/ssc/metalsindo_dev/application/modules/warehouse_material/views/add_wip.php 13
ERROR - 2020-10-06 11:31:39 --> Query error: Table 'metalsindo_db.material_wip' doesn't exist - Invalid query: 
      SELECT
      (@row:=@row+1) AS nomor,
        a.*
      FROM
        material_wip a LEFT JOIN ms_costcenter b ON a.costcenter=b.id_costcenter,
        (SELECT @row:=0) r
       WHERE 1=1 AND a.deleted='N' AND (
        a.no_wip LIKE '%%'
        OR b.nama_costcenter LIKE '%%'
          )
    
ERROR - 2020-10-06 11:31:43 --> Severity: Notice --> Undefined variable: datgroupmenu /home/ssc/metalsindo_dev/application/modules/menus/views/menus_form.php 70
ERROR - 2020-10-06 11:32:05 --> Severity: Notice --> Undefined variable: datgroupmenu /home/ssc/metalsindo_dev/application/modules/menus/views/menus_form.php 70
ERROR - 2020-10-06 11:32:24 --> Severity: Notice --> Undefined variable: datgroupmenu /home/ssc/metalsindo_dev/application/modules/menus/views/menus_form.php 70
ERROR - 2020-10-06 11:32:48 --> Severity: Notice --> Undefined variable: datgroupmenu /home/ssc/metalsindo_dev/application/modules/menus/views/menus_form.php 70
ERROR - 2020-10-06 11:33:11 --> Severity: Notice --> Undefined variable: datgroupmenu /home/ssc/metalsindo_dev/application/modules/menus/views/menus_form.php 70
ERROR - 2020-10-06 11:33:27 --> Severity: Notice --> Undefined variable: datgroupmenu /home/ssc/metalsindo_dev/application/modules/menus/views/menus_form.php 70
ERROR - 2020-10-06 11:33:38 --> Query error: Unknown column 'b.unit' in 'field list' - Invalid query: 
			SELECT
        (@row:=@row+1) AS nomor,
				a.*,
        b.unit,
        b.konversi,
        b.satuan_packing
			FROM
			   warehouse_stock a LEFT JOIN ms_material b ON a.id_material = b.code_material,
         (SELECT @row:=0) r
		   WHERE 1=1 AND kd_gudang='OPC'AND (
				a.id_material LIKE '%%'
				OR a.idmaterial LIKE '%%'
				OR a.nm_material LIKE '%%'
	        )
		
ERROR - 2020-10-06 11:33:42 --> Severity: Notice --> Undefined variable: datgroupmenu /home/ssc/metalsindo_dev/application/modules/menus/views/menus_form.php 70
ERROR - 2020-10-06 11:34:29 --> Severity: Notice --> Undefined variable: datgroupmenu /home/ssc/metalsindo_dev/application/modules/menus/views/menus_form.php 70
ERROR - 2020-10-06 11:44:07 --> Severity: Notice --> Undefined variable: datgroupmenu /home/ssc/metalsindo_dev/application/modules/menus/views/menus_form.php 70
ERROR - 2020-10-06 12:02:25 --> 404 Page Not Found: ../modules/penawaran_shearing/controllers/Penawaran_shearing/GetProduk
ERROR - 2020-10-06 12:12:27 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'onchange='get_properties()' at line 1 - Invalid query: SELECT * FROM dt_inquery_transaksi WHERE no_inquery = 'IQ2009290001' onchange='get_properties() 
ERROR - 2020-10-06 12:12:36 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'onchange='get_properties()' at line 1 - Invalid query: SELECT * FROM dt_inquery_transaksi WHERE no_inquery = 'IQ2009290001' onchange='get_properties() 
ERROR - 2020-10-06 12:12:49 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'onchange='get_properties()' at line 1 - Invalid query: SELECT * FROM dt_inquery_transaksi WHERE no_inquery = 'IQ2009290001' onchange='get_properties() 
ERROR - 2020-10-06 12:13:29 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'onchange='get_properties()'' at line 1 - Invalid query: SELECT * FROM dt_inquery_transaksi WHERE no_inquery = 'IQ2009290001' onchange='get_properties()' 
ERROR - 2020-10-06 12:13:36 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'onchange='get_properties()'' at line 1 - Invalid query: SELECT * FROM dt_inquery_transaksi WHERE no_inquery = 'IQ2009290001' onchange='get_properties()' 
ERROR - 2020-10-06 12:38:34 --> 404 Page Not Found: ../modules/penawaran_shearing/controllers/Penawaran_shearing/GetMaterial
ERROR - 2020-10-06 12:38:34 --> 404 Page Not Found: ../modules/penawaran_shearing/controllers/Penawaran_shearing/GetThickness
ERROR - 2020-10-06 12:38:34 --> 404 Page Not Found: ../modules/penawaran_shearing/controllers/Penawaran_shearing/GetDensity
ERROR - 2020-10-06 12:38:34 --> 404 Page Not Found: ../modules/penawaran_shearing/controllers/Penawaran_shearing/GetSurface
ERROR - 2020-10-06 12:38:34 --> 404 Page Not Found: ../modules/penawaran_shearing/controllers/Penawaran_shearing/GetPotongan
ERROR - 2020-10-06 12:55:59 --> 404 Page Not Found: ../modules/penawaran_shearing/controllers/Penawaran_shearing/GetMaterial
ERROR - 2020-10-06 12:55:59 --> 404 Page Not Found: ../modules/penawaran_shearing/controllers/Penawaran_shearing/GetThickness
ERROR - 2020-10-06 12:55:59 --> 404 Page Not Found: ../modules/penawaran_shearing/controllers/Penawaran_shearing/GetDensity
ERROR - 2020-10-06 12:55:59 --> 404 Page Not Found: ../modules/penawaran_shearing/controllers/Penawaran_shearing/GetSurface
ERROR - 2020-10-06 12:55:59 --> 404 Page Not Found: ../modules/penawaran_shearing/controllers/Penawaran_shearing/GetPotongan
ERROR - 2020-10-06 13:06:07 --> 404 Page Not Found: ../modules/penawaran_shearing/controllers/Penawaran_shearing/GetThickness
ERROR - 2020-10-06 13:06:07 --> 404 Page Not Found: ../modules/penawaran_shearing/controllers/Penawaran_shearing/GetDensity
ERROR - 2020-10-06 13:06:07 --> 404 Page Not Found: ../modules/penawaran_shearing/controllers/Penawaran_shearing/GetSurface
ERROR - 2020-10-06 13:06:07 --> 404 Page Not Found: ../modules/penawaran_shearing/controllers/Penawaran_shearing/GetPotongan
ERROR - 2020-10-06 13:06:07 --> 404 Page Not Found: ../modules/penawaran_shearing/controllers/Penawaran_shearing/GetStock
ERROR - 2020-10-06 13:06:39 --> 404 Page Not Found: ../modules/penawaran_shearing/controllers/Penawaran_shearing/GetThickness
ERROR - 2020-10-06 13:06:39 --> 404 Page Not Found: ../modules/penawaran_shearing/controllers/Penawaran_shearing/GetDensity
ERROR - 2020-10-06 13:06:39 --> 404 Page Not Found: ../modules/penawaran_shearing/controllers/Penawaran_shearing/GetSurface
ERROR - 2020-10-06 13:06:39 --> 404 Page Not Found: ../modules/penawaran_shearing/controllers/Penawaran_shearing/GetPotongan
ERROR - 2020-10-06 13:06:39 --> 404 Page Not Found: ../modules/penawaran_shearing/controllers/Penawaran_shearing/GetStock
ERROR - 2020-10-06 13:08:08 --> 404 Page Not Found: ../modules/penawaran_shearing/controllers/Penawaran_shearing/GetThickness
ERROR - 2020-10-06 13:08:08 --> 404 Page Not Found: ../modules/penawaran_shearing/controllers/Penawaran_shearing/GetDensity
ERROR - 2020-10-06 13:08:08 --> 404 Page Not Found: ../modules/penawaran_shearing/controllers/Penawaran_shearing/GetSurface
ERROR - 2020-10-06 13:08:08 --> 404 Page Not Found: ../modules/penawaran_shearing/controllers/Penawaran_shearing/GetPotongan
ERROR - 2020-10-06 13:08:08 --> 404 Page Not Found: ../modules/penawaran_shearing/controllers/Penawaran_shearing/GetStock
ERROR - 2020-10-06 13:27:31 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-10-06 13:27:31 --> 404 Page Not Found: /index
ERROR - 2020-10-06 13:32:02 --> Severity: error --> Exception: ERROR n°1 : The tag &lt;BR&gt; does not yet exist.If you want to add it, you must create the methods o_BR (for opening) and c_BR (for closure) by following the model of existing tags.If you create these methods, do not hesitate to send me an email to webmaster@html2pdf.fr to included them in the next version of HTML2PDF. /home/ssc/metalsindo_dev/assets/html2pdf/html2pdf/html2pdf.class.php 1251
ERROR - 2020-10-06 13:32:14 --> Severity: error --> Exception: ERROR n°1 : The tag &lt;BR&gt; does not yet exist.If you want to add it, you must create the methods o_BR (for opening) and c_BR (for closure) by following the model of existing tags.If you create these methods, do not hesitate to send me an email to webmaster@html2pdf.fr to included them in the next version of HTML2PDF. /home/ssc/metalsindo_dev/assets/html2pdf/html2pdf/html2pdf.class.php 1251
ERROR - 2020-10-06 14:10:49 --> 404 Page Not Found: /index
ERROR - 2020-10-06 14:35:36 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-10-06 14:35:37 --> 404 Page Not Found: /index
ERROR - 2020-10-06 14:36:18 --> 404 Page Not Found: /index
ERROR - 2020-10-06 14:50:28 --> Severity: Parsing Error --> syntax error, unexpected ',' /home/ssc/metalsindo_dev/application/modules/penawaran_shearing/controllers/Penawaran_shearing.php 466
ERROR - 2020-10-06 14:50:28 --> Severity: Parsing Error --> syntax error, unexpected ',' /home/ssc/metalsindo_dev/application/modules/penawaran_shearing/controllers/Penawaran_shearing.php 466
ERROR - 2020-10-06 14:50:28 --> Severity: Parsing Error --> syntax error, unexpected ',' /home/ssc/metalsindo_dev/application/modules/penawaran_shearing/controllers/Penawaran_shearing.php 466
ERROR - 2020-10-06 14:50:28 --> Severity: Parsing Error --> syntax error, unexpected ',' /home/ssc/metalsindo_dev/application/modules/penawaran_shearing/controllers/Penawaran_shearing.php 466
ERROR - 2020-10-06 14:50:28 --> Severity: Parsing Error --> syntax error, unexpected ',' /home/ssc/metalsindo_dev/application/modules/penawaran_shearing/controllers/Penawaran_shearing.php 466
ERROR - 2020-10-06 14:50:28 --> Severity: Parsing Error --> syntax error, unexpected ',' /home/ssc/metalsindo_dev/application/modules/penawaran_shearing/controllers/Penawaran_shearing.php 466
ERROR - 2020-10-06 14:51:09 --> Severity: Parsing Error --> syntax error, unexpected ',' /home/ssc/metalsindo_dev/application/modules/penawaran_shearing/controllers/Penawaran_shearing.php 466
ERROR - 2020-10-06 14:51:28 --> Severity: Parsing Error --> syntax error, unexpected ',' /home/ssc/metalsindo_dev/application/modules/penawaran_shearing/controllers/Penawaran_shearing.php 466
ERROR - 2020-10-06 15:32:38 --> Severity: Parsing Error --> syntax error, unexpected 'echo' (T_ECHO) /home/ssc/metalsindo_dev/application/modules/penawaran_shearing/controllers/Penawaran_shearing.php 481
ERROR - 2020-10-06 15:37:51 --> Query error: Unknown column 'b.thickness' in 'field list' - Invalid query: SELECT `a`.*, `b`.`density` as `density`, `b`.`thickness` as `thickness`
FROM `stock_material` `a`
JOIN `ms_inventory_category3` `b` ON `b`.`id_category3`=`a`.`id_category3`
WHERE `a`.`id_category3` = 'I2000006'
ERROR - 2020-10-06 15:37:54 --> Query error: Unknown column 'b.thickness' in 'field list' - Invalid query: SELECT `a`.*, `b`.`density` as `density`, `b`.`thickness` as `thickness`
FROM `stock_material` `a`
JOIN `ms_inventory_category3` `b` ON `b`.`id_category3`=`a`.`id_category3`
WHERE `a`.`id_category3` = 'I2000004'
ERROR - 2020-10-06 15:38:09 --> Query error: Unknown column 'b.thickness' in 'field list' - Invalid query: SELECT `a`.*, `b`.`density` as `density`, `b`.`thickness` as `thickness`
FROM `stock_material` `a`
JOIN `ms_inventory_category3` `b` ON `b`.`id_category3`=`a`.`id_category3`
WHERE `a`.`id_category3` = 'I2000004'
ERROR - 2020-10-06 15:38:21 --> Query error: Unknown column 'b.thickness' in 'field list' - Invalid query: SELECT `a`.*, `b`.`density` as `density`, `b`.`thickness` as `thickness`
FROM `stock_material` `a`
JOIN `ms_inventory_category3` `b` ON `b`.`id_category3`=`a`.`id_category3`
WHERE `a`.`id_category3` = 'I2000004'
ERROR - 2020-10-06 16:07:00 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-10-06 16:07:01 --> 404 Page Not Found: /index
ERROR - 2020-10-06 16:11:36 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-10-06 16:11:37 --> 404 Page Not Found: /index
