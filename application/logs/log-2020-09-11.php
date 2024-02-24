<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-09-11 07:52:17 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-09-11 07:52:20 --> 404 Page Not Found: /index
ERROR - 2020-09-11 08:49:57 --> Query error: Unknown column 'b.unit' in 'field list' - Invalid query: 
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
		
ERROR - 2020-09-11 08:58:55 --> Query error: Table 'metalsindo_db.material_wip' doesn't exist - Invalid query: 
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
    
ERROR - 2020-09-11 08:58:57 --> Severity: Error --> Call to undefined function get_data_planning() /home/ssc/metalsindo_dev/application/modules/warehouse_material/views/add_wip.php 13
ERROR - 2020-09-11 08:59:05 --> Query error: Table 'metalsindo_db.material_wip' doesn't exist - Invalid query: 
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
    
ERROR - 2020-09-11 09:24:10 --> 404 Page Not Found: /index
ERROR - 2020-09-11 09:24:15 --> 404 Page Not Found: /index
ERROR - 2020-09-11 10:30:51 --> Severity: Error --> Call to undefined method Inquiry_model::Pricelist() /home/ssc/metalsindo_dev/application/modules/transaksi_inquiry/controllers/Transaksi_inquiry.php 407
ERROR - 2020-09-11 10:31:27 --> Severity: Error --> Call to undefined method Inquiry_model::Pricelist() /home/ssc/metalsindo_dev/application/modules/transaksi_inquiry/controllers/Transaksi_inquiry.php 407
ERROR - 2020-09-11 10:32:23 --> 404 Page Not Found: ../modules/transaksi_inquiry/controllers/Transaksi_inquiry/form_pricelist
ERROR - 2020-09-11 10:32:56 --> 404 Page Not Found: ../modules/transaksi_inquiry/controllers/Transaksi_inquiry/form_pricelist
ERROR - 2020-09-11 11:19:48 --> Severity: Parsing Error --> syntax error, unexpected '{', expecting '(' /home/ssc/metalsindo_dev/application/modules/transaksi_inquiry/controllers/Transaksi_inquiry.php 374
ERROR - 2020-09-11 13:49:12 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-09-11 13:49:24 --> 404 Page Not Found: /index
ERROR - 2020-09-11 13:50:24 --> Severity: Notice --> Undefined variable: datgroupmenu /home/ssc/metalsindo_dev/application/modules/menus/views/menus_form.php 70
ERROR - 2020-09-11 13:50:54 --> Severity: Notice --> Undefined variable: datgroupmenu /home/ssc/metalsindo_dev/application/modules/menus/views/menus_form.php 70
ERROR - 2020-09-11 13:51:31 --> Severity: Notice --> Undefined variable: datgroupmenu /home/ssc/metalsindo_dev/application/modules/menus/views/menus_form.php 70
ERROR - 2020-09-11 13:51:46 --> Severity: Notice --> Undefined variable: datgroupmenu /home/ssc/metalsindo_dev/application/modules/menus/views/menus_form.php 70
ERROR - 2020-09-11 13:52:10 --> Severity: Notice --> Undefined variable: datgroupmenu /home/ssc/metalsindo_dev/application/modules/menus/views/menus_form.php 70
ERROR - 2020-09-11 13:52:28 --> Severity: Notice --> Undefined variable: datgroupmenu /home/ssc/metalsindo_dev/application/modules/menus/views/menus_form.php 70
ERROR - 2020-09-11 13:54:04 --> Severity: Notice --> Undefined variable: datgroupmenu /home/ssc/metalsindo_dev/application/modules/menus/views/menus_form.php 70
ERROR - 2020-09-11 13:55:05 --> Severity: Notice --> Undefined variable: datgroupmenu /home/ssc/metalsindo_dev/application/modules/menus/views/menus_form.php 70
ERROR - 2020-09-11 15:03:08 --> 404 Page Not Found: /index
