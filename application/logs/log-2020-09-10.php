<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-09-10 06:30:23 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-09-10 06:30:27 --> 404 Page Not Found: /index
ERROR - 2020-09-10 07:00:01 --> 404 Page Not Found: /index
ERROR - 2020-09-10 07:02:49 --> 404 Page Not Found: /index
ERROR - 2020-09-10 07:07:43 --> Severity: Error --> Call to a member function get_data() on null /home/ssc/metalsindo_dev/application/modules/pricelist_f/controllers/Pricelist_f.php 42
ERROR - 2020-09-10 08:38:20 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-09-10 08:38:24 --> 404 Page Not Found: /index
ERROR - 2020-09-10 08:57:49 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-09-10 08:57:50 --> 404 Page Not Found: /index
ERROR - 2020-09-10 10:00:12 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-09-10 10:00:16 --> 404 Page Not Found: /index
ERROR - 2020-09-10 11:05:01 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-09-10 11:05:04 --> 404 Page Not Found: /index
ERROR - 2020-09-10 13:14:58 --> Severity: Notice --> Undefined variable: datgroupmenu /home/ssc/metalsindo_dev/application/modules/menus/views/menus_form.php 70
ERROR - 2020-09-10 13:21:52 --> Severity: Notice --> Undefined variable: datgroupmenu /home/ssc/metalsindo_dev/application/modules/menus/views/menus_form.php 70
ERROR - 2020-09-10 13:26:31 --> Severity: Notice --> Undefined variable: datgroupmenu /home/ssc/metalsindo_dev/application/modules/menus/views/menus_form.php 70
ERROR - 2020-09-10 13:26:38 --> 404 Page Not Found: ../modules/warehouse_material/controllers/Warehouse_material/index
ERROR - 2020-09-10 13:27:24 --> Severity: Notice --> Undefined variable: datgroupmenu /home/ssc/metalsindo_dev/application/modules/menus/views/menus_form.php 70
ERROR - 2020-09-10 13:27:31 --> Query error: Table 'metalsindo_db.tran_material_purchase_header' doesn't exist - Invalid query: SELECT no_po FROM tran_material_purchase_header WHERE sts_ajuan = 'OPN' ORDER BY no_po ASC 
ERROR - 2020-09-10 14:10:03 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-09-10 14:10:03 --> 404 Page Not Found: /index
ERROR - 2020-09-10 14:29:06 --> Severity: Notice --> Undefined variable: datgroupmenu /home/ssc/metalsindo_dev/application/modules/menus/views/menus_form.php 70
ERROR - 2020-09-10 14:29:19 --> Query error: Table 'metalsindo_db.tran_material_purchase_header' doesn't exist - Invalid query: SELECT no_po FROM tran_material_purchase_header WHERE sts_ajuan = 'OPN' ORDER BY no_po ASC 
ERROR - 2020-09-10 14:30:33 --> Severity: Notice --> Undefined variable: datgroupmenu /home/ssc/metalsindo_dev/application/modules/menus/views/menus_form.php 70
ERROR - 2020-09-10 14:31:12 --> Query error: Table 'metalsindo_db.tran_material_purchase_header' doesn't exist - Invalid query: SELECT no_po FROM tran_material_purchase_header WHERE sts_ajuan = 'OPN' ORDER BY no_po ASC 
ERROR - 2020-09-10 14:33:10 --> Severity: Notice --> Undefined variable: datgroupmenu /home/ssc/metalsindo_dev/application/modules/menus/views/menus_form.php 70
ERROR - 2020-09-10 14:34:32 --> Severity: Notice --> Undefined variable: datgroupmenu /home/ssc/metalsindo_dev/application/modules/menus/views/menus_form.php 70
ERROR - 2020-09-10 14:34:40 --> Query error: Table 'metalsindo_db.tran_material_purchase_header' doesn't exist - Invalid query: SELECT no_po FROM tran_material_purchase_header WHERE sts_ajuan = 'OPN' ORDER BY no_po ASC 
ERROR - 2020-09-10 14:35:43 --> Severity: Error --> Call to undefined function history() /home/ssc/metalsindo_dev/application/modules/warehouse_material/controllers/Warehouse_material.php 418
ERROR - 2020-09-10 14:47:31 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-09-10 14:47:33 --> 404 Page Not Found: /index
ERROR - 2020-09-10 14:48:28 --> Severity: Error --> Call to undefined function history() /home/ssc/metalsindo_dev/application/modules/warehouse_material/controllers/Warehouse_material.php 35
ERROR - 2020-09-10 14:49:14 --> Severity: Error --> Call to undefined function history() /home/ssc/metalsindo_dev/application/modules/warehouse_material/controllers/Warehouse_material.php 418
ERROR - 2020-09-10 14:50:23 --> Severity: Error --> Call to undefined function history() /home/ssc/metalsindo_dev/application/modules/warehouse_material/controllers/Warehouse_material.php 35
ERROR - 2020-09-10 14:52:05 --> Query error: Unknown column 'b.unit' in 'field list' - Invalid query: 
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
		
ERROR - 2020-09-10 14:52:09 --> Query error: Table 'metalsindo_db.material_wip' doesn't exist - Invalid query: 
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
    
ERROR - 2020-09-10 14:52:14 --> Query error: Unknown column 'b.unit' in 'field list' - Invalid query: 
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
		
ERROR - 2020-09-10 14:52:16 --> Severity: Error --> Call to undefined function get_warehouse() /home/ssc/metalsindo_dev/application/modules/warehouse_material/views/adjustment_material.php 29
ERROR - 2020-09-10 14:52:35 --> Severity: Error --> Call to undefined function history() /home/ssc/metalsindo_dev/application/modules/warehouse_material/controllers/Warehouse_material.php 662
ERROR - 2020-09-10 14:54:32 --> Severity: Error --> Call to undefined function get_warehouse() /home/ssc/metalsindo_dev/application/modules/warehouse_material/views/adjustment_material.php 29
ERROR - 2020-09-10 14:54:46 --> Query error: Unknown column 'b.unit' in 'field list' - Invalid query: 
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
		
ERROR - 2020-09-10 14:55:15 --> Query error: Unknown column 'b.unit' in 'field list' - Invalid query: 
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
		
ERROR - 2020-09-10 14:56:05 --> Query error: Unknown column 'b.unit' in 'field list' - Invalid query: 
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
		
ERROR - 2020-09-10 14:56:22 --> Query error: Unknown column 'b.unit' in 'field list' - Invalid query: 
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
		
ERROR - 2020-09-10 14:56:34 --> Query error: Table 'metalsindo_db.material_wip' doesn't exist - Invalid query: 
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
    
ERROR - 2020-09-10 14:56:40 --> Severity: Error --> Call to undefined function get_warehouse() /home/ssc/metalsindo_dev/application/modules/warehouse_material/views/adjustment_material.php 29
ERROR - 2020-09-10 14:58:12 --> Query error: Table 'metalsindo_db.material_wip' doesn't exist - Invalid query: 
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
    
ERROR - 2020-09-10 14:58:15 --> Severity: Error --> Call to undefined function get_data_planning() /home/ssc/metalsindo_dev/application/modules/warehouse_material/views/add_wip.php 13
ERROR - 2020-09-10 14:58:58 --> Query error: Table 'metalsindo_db.material_wip' doesn't exist - Invalid query: 
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
    
ERROR - 2020-09-10 14:59:06 --> Query error: Unknown column 'b.unit' in 'field list' - Invalid query: 
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
		
ERROR - 2020-09-10 14:59:10 --> Query error: Unknown column 'b.unit' in 'field list' - Invalid query: 
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
		
ERROR - 2020-09-10 14:59:15 --> Query error: Unknown column 'b.unit' in 'field list' - Invalid query: 
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
		
ERROR - 2020-09-10 14:59:18 --> Query error: Unknown column 'b.unit' in 'field list' - Invalid query: 
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
		
ERROR - 2020-09-10 14:59:32 --> Severity: Error --> Call to undefined function get_warehouse() /home/ssc/metalsindo_dev/application/modules/warehouse_material/views/adjustment_material.php 29
ERROR - 2020-09-10 14:59:57 --> Severity: Error --> Call to undefined function get_warehouse() /home/ssc/metalsindo_dev/application/modules/warehouse_material/views/adjustment_material.php 29
ERROR - 2020-09-10 15:00:51 --> Query error: Unknown column 'b.unit' in 'field list' - Invalid query: 
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
		
ERROR - 2020-09-10 15:00:55 --> Query error: Table 'metalsindo_db.material_wip' doesn't exist - Invalid query: 
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
    
ERROR - 2020-09-10 15:00:59 --> Severity: Error --> Call to undefined function get_data_planning() /home/ssc/metalsindo_dev/application/modules/warehouse_material/views/add_wip.php 13
ERROR - 2020-09-10 16:11:16 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-09-10 16:11:18 --> 404 Page Not Found: /index
ERROR - 2020-09-10 16:12:28 --> Severity: Error --> Call to undefined function get_warehouse() /home/ssc/metalsindo_dev/application/modules/warehouse_material/views/adjustment_material.php 29
ERROR - 2020-09-10 16:12:33 --> Severity: Error --> Call to undefined function get_warehouse() /home/ssc/metalsindo_dev/application/modules/warehouse_material/views/adjustment_material.php 29
ERROR - 2020-09-10 16:12:34 --> Severity: Error --> Call to undefined function get_warehouse() /home/ssc/metalsindo_dev/application/modules/warehouse_material/views/adjustment_material.php 29
ERROR - 2020-09-10 16:12:43 --> Severity: Error --> Call to undefined function get_warehouse() /home/ssc/metalsindo_dev/application/modules/warehouse_material/views/add_adjustment.php 12
ERROR - 2020-09-10 16:12:43 --> Severity: Error --> Call to undefined function get_warehouse() /home/ssc/metalsindo_dev/application/modules/warehouse_material/views/add_adjustment.php 12
ERROR - 2020-09-10 16:12:44 --> Severity: Error --> Call to undefined function get_warehouse() /home/ssc/metalsindo_dev/application/modules/warehouse_material/views/adjustment_material.php 29
ERROR - 2020-09-10 16:12:51 --> Query error: Unknown column 'b.unit' in 'field list' - Invalid query: 
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
		
ERROR - 2020-09-10 16:13:03 --> Query error: Table 'metalsindo_db.material_wip' doesn't exist - Invalid query: 
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
    
ERROR - 2020-09-10 16:13:37 --> Severity: Error --> Call to undefined function get_warehouse() /home/ssc/metalsindo_dev/application/modules/warehouse_material/views/adjustment_material.php 29
ERROR - 2020-09-10 16:14:05 --> Query error: Unknown column 'b.unit' in 'field list' - Invalid query: 
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
		
ERROR - 2020-09-10 16:14:29 --> Query error: Table 'metalsindo_db.material_wip' doesn't exist - Invalid query: 
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
    
ERROR - 2020-09-10 16:15:37 --> Severity: Error --> Call to undefined function get_warehouse() /home/ssc/metalsindo_dev/application/modules/warehouse_material/views/adjustment_material.php 29
ERROR - 2020-09-10 16:15:41 --> Severity: Error --> Call to undefined function get_warehouse() /home/ssc/metalsindo_dev/application/modules/warehouse_material/views/adjustment_material.php 29
ERROR - 2020-09-10 16:15:42 --> Query error: Unknown column 'b.unit' in 'field list' - Invalid query: 
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
		
ERROR - 2020-09-10 16:15:45 --> Query error: Table 'metalsindo_db.material_wip' doesn't exist - Invalid query: 
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
    
ERROR - 2020-09-10 16:18:52 --> Query error: Unknown column 'b.unit' in 'field list' - Invalid query: 
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
		
ERROR - 2020-09-10 16:19:09 --> 404 Page Not Found: ../modules/pricelist_nf/controllers/Pricelist_nf/index
ERROR - 2020-09-10 16:19:10 --> Query error: Unknown column 'b.unit' in 'field list' - Invalid query: 
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
		
ERROR - 2020-09-10 16:19:26 --> 404 Page Not Found: /index
ERROR - 2020-09-10 16:19:58 --> Severity: Error --> Call to undefined function get_warehouse() /home/ssc/metalsindo_dev/application/modules/warehouse_material/views/add_adjustment.php 12
ERROR - 2020-09-10 16:21:47 --> Severity: Error --> Call to undefined function get_warehouse() /home/ssc/metalsindo_dev/application/modules/warehouse_material/views/add_adjustment.php 12
ERROR - 2020-09-10 16:21:56 --> Severity: Error --> Call to undefined function get_warehouse() /home/ssc/metalsindo_dev/application/modules/warehouse_material/views/adjustment_material.php 29
ERROR - 2020-09-10 16:22:12 --> Severity: Error --> Call to undefined function get_warehouse() /home/ssc/metalsindo_dev/application/modules/warehouse_material/views/adjustment_material.php 29
ERROR - 2020-09-10 16:24:50 --> 404 Page Not Found: /index
ERROR - 2020-09-10 16:24:55 --> Severity: Error --> Call to undefined function history() /home/ssc/metalsindo_dev/application/modules/warehouse_material/controllers/Warehouse_material.php 662
ERROR - 2020-09-10 16:25:14 --> Severity: Error --> Call to undefined function get_warehouse() /home/ssc/metalsindo_dev/application/modules/warehouse_material/views/adjustment_material.php 29
ERROR - 2020-09-10 16:25:23 --> Severity: Error --> Call to undefined function history() /home/ssc/metalsindo_dev/application/modules/warehouse_material/controllers/Warehouse_material.php 418
ERROR - 2020-09-10 16:25:43 --> Severity: Error --> Call to undefined function history() /home/ssc/metalsindo_dev/application/modules/warehouse_material/controllers/Warehouse_material.php 35
ERROR - 2020-09-10 16:26:02 --> Query error: Unknown column 'b.unit' in 'field list' - Invalid query: 
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
		
ERROR - 2020-09-10 16:32:06 --> Severity: Error --> Call to undefined function get_warehouse() /home/ssc/metalsindo_dev/application/modules/warehouse_material/views/adjustment_material.php 29
ERROR - 2020-09-10 16:37:44 --> Severity: Error --> Call to undefined function get_warehouse() /home/ssc/metalsindo_dev/application/modules/warehouse_material/views/adjustment_material.php 29
ERROR - 2020-09-10 16:39:32 --> Severity: Error --> Call to undefined function get_warehouse() /home/ssc/metalsindo_dev/application/modules/warehouse_material/views/adjustment_material.php 29
ERROR - 2020-09-10 16:40:25 --> Query error: Unknown column 'b.unit' in 'field list' - Invalid query: 
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
		
ERROR - 2020-09-10 16:40:32 --> Severity: Error --> Call to undefined function history() /home/ssc/metalsindo_dev/application/modules/warehouse_material/controllers/Warehouse_material.php 68
ERROR - 2020-09-10 16:40:35 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-09-10 16:40:35 --> 404 Page Not Found: /index
ERROR - 2020-09-10 16:40:54 --> Severity: Parsing Error --> syntax error, unexpected 'Material' (T_STRING) /home/ssc/metalsindo_dev/application/modules/warehouse_material/controllers/Warehouse_material.php 67
ERROR - 2020-09-10 16:40:56 --> Severity: Parsing Error --> syntax error, unexpected 'Material' (T_STRING) /home/ssc/metalsindo_dev/application/modules/warehouse_material/controllers/Warehouse_material.php 67
ERROR - 2020-09-10 16:41:08 --> Severity: Parsing Error --> syntax error, unexpected 'Material' (T_STRING) /home/ssc/metalsindo_dev/application/modules/warehouse_material/controllers/Warehouse_material.php 67
ERROR - 2020-09-10 16:41:13 --> Query error: Table 'metalsindo_db.material_wip' doesn't exist - Invalid query: 
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
    
ERROR - 2020-09-10 16:41:14 --> Severity: Error --> Call to undefined function history() /home/ssc/metalsindo_dev/application/modules/warehouse_material/controllers/Warehouse_material.php 51
ERROR - 2020-09-10 16:41:21 --> Query error: Unknown column 'b.unit' in 'field list' - Invalid query: 
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
		
ERROR - 2020-09-10 16:41:22 --> Query error: Table 'metalsindo_db.material_wip' doesn't exist - Invalid query: 
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
    
ERROR - 2020-09-10 16:41:23 --> Severity: Parsing Error --> syntax error, unexpected end of file, expecting function (T_FUNCTION) /home/ssc/metalsindo_dev/application/modules/warehouse_material/controllers/Warehouse_material.php 398
ERROR - 2020-09-10 16:41:26 --> Query error: Unknown column 'b.unit' in 'field list' - Invalid query: 
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
		
ERROR - 2020-09-10 16:41:28 --> Query error: Table 'metalsindo_db.material_wip' doesn't exist - Invalid query: 
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
    
ERROR - 2020-09-10 16:41:29 --> Severity: Error --> Call to undefined function get_warehouse() /home/ssc/metalsindo_dev/application/modules/warehouse_material/views/adjustment_material.php 29
ERROR - 2020-09-10 16:41:31 --> Query error: Table 'metalsindo_db.material_wip' doesn't exist - Invalid query: 
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
    
ERROR - 2020-09-10 16:41:32 --> Severity: Error --> Call to undefined function get_warehouse() /home/ssc/metalsindo_dev/application/modules/warehouse_material/views/adjustment_material.php 29
ERROR - 2020-09-10 16:41:33 --> Severity: Error --> Call to undefined function get_data_planning() /home/ssc/metalsindo_dev/application/modules/warehouse_material/views/add_wip.php 13
ERROR - 2020-09-10 16:44:24 --> Query error: Table 'metalsindo_db.material_wip' doesn't exist - Invalid query: 
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
    
ERROR - 2020-09-10 16:44:31 --> Query error: Table 'metalsindo_db.material_wip' doesn't exist - Invalid query: 
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
    
ERROR - 2020-09-10 16:44:37 --> Query error: Table 'metalsindo_db.material_wip' doesn't exist - Invalid query: 
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
    
ERROR - 2020-09-10 16:44:44 --> Severity: Error --> Call to undefined function get_data_planning() /home/ssc/metalsindo_dev/application/modules/warehouse_material/views/add_wip.php 13
ERROR - 2020-09-10 16:55:07 --> Severity: Error --> Call to undefined function get_data_planning() /home/ssc/metalsindo_dev/application/modules/warehouse_material/views/add_wip.php 13
ERROR - 2020-09-10 16:59:12 --> Severity: Parsing Error --> syntax error, unexpected '\' (T_NS_SEPARATOR) /home/ssc/metalsindo_dev/application/modules/warehouse_material/controllers/Warehouse_material.php 659
ERROR - 2020-09-10 16:59:48 --> Severity: Error --> Call to undefined function get_data_planning() /home/ssc/metalsindo_dev/application/modules/warehouse_material/views/add_wip.php 13
ERROR - 2020-09-10 16:59:58 --> Query error: Table 'metalsindo_db.material_wip' doesn't exist - Invalid query: 
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
    
ERROR - 2020-09-10 17:00:08 --> Severity: Error --> Cannot use object of type stdClass as array /home/ssc/metalsindo_dev/application/modules/warehouse_material/views/adjustment_material.php 30
ERROR - 2020-09-10 17:03:11 --> Severity: Error --> Call to a member function get_data() on null /home/ssc/metalsindo_dev/application/modules/warehouse_material/controllers/Warehouse_material.php 659
ERROR - 2020-09-10 17:03:54 --> Severity: Error --> Cannot use object of type stdClass as array /home/ssc/metalsindo_dev/application/modules/warehouse_material/views/adjustment_material.php 30
ERROR - 2020-09-10 17:08:57 --> Severity: Error --> Cannot use object of type stdClass as array /home/ssc/metalsindo_dev/application/modules/warehouse_material/views/adjustment_material.php 30
ERROR - 2020-09-10 17:09:01 --> Severity: Error --> Cannot use object of type stdClass as array /home/ssc/metalsindo_dev/application/modules/warehouse_material/views/adjustment_material.php 30
ERROR - 2020-09-10 17:13:15 --> Severity: Error --> Cannot use object of type stdClass as array /home/ssc/metalsindo_dev/application/modules/warehouse_material/views/adjustment_material.php 45
ERROR - 2020-09-10 17:13:36 --> Query error: Unknown column 'c.nm_material' in 'field list' - Invalid query: 
            SELECT
              (@row:=@row+1) AS nomor,
              a.*,
              b.nm_gudang,
              c.nm_material
            FROM
              warehouse_material_adjustment a
              LEFT JOIN warehouse b ON a.kd_gudang=b.kd_gudang
              LEFT JOIN ms_material c ON a.material = c.code_material,
              (SELECT @row:=0) r
            WHERE 1=1   AND (
              b.nm_gudang LIKE '%%'
              OR c.nm_material LIKE '%%'
            )
            
ERROR - 2020-09-10 17:15:14 --> Query error: Unknown column 'c.nm_material' in 'field list' - Invalid query: 
            SELECT
              (@row:=@row+1) AS nomor,
              a.*,
              b.nm_gudang,
              c.nm_material
            FROM
              warehouse_material_adjustment a
              LEFT JOIN warehouse b ON a.kd_gudang=b.kd_gudang
              LEFT JOIN ms_material c ON a.material = c.code_material,
              (SELECT @row:=0) r
            WHERE 1=1   AND (
              b.nm_gudang LIKE '%%'
              OR c.nm_material LIKE '%%'
            )
            
ERROR - 2020-09-10 17:16:41 --> Query error: Unknown column 'c.nm_material' in 'field list' - Invalid query: 
            SELECT
              (@row:=@row+1) AS nomor,
              a.*,
              b.nm_gudang,
              c.nm_material
            FROM
              warehouse_material_adjustment a
              LEFT JOIN warehouse b ON a.kd_gudang=b.kd_gudang
              LEFT JOIN ms_material c ON a.material = c.code_material,
              (SELECT @row:=0) r
            WHERE 1=1   AND (
              b.nm_gudang LIKE '%%'
              OR c.nm_material LIKE '%%'
            )
            
ERROR - 2020-09-10 17:17:21 --> Severity: Error --> Call to undefined function get_warehouse() /home/ssc/metalsindo_dev/application/modules/warehouse_material/views/add_adjustment.php 12
ERROR - 2020-09-10 17:18:07 --> Severity: Error --> Call to undefined function get_data_planning() /home/ssc/metalsindo_dev/application/modules/warehouse_material/views/add_wip.php 13
ERROR - 2020-09-10 17:20:24 --> Severity: Error --> Call to undefined function get_data_planning() /home/ssc/metalsindo_dev/application/modules/warehouse_material/views/add_wip.php 13
ERROR - 2020-09-10 17:39:39 --> Query error: Unknown column 'c.nm_material' in 'field list' - Invalid query: 
            SELECT
              (@row:=@row+1) AS nomor,
              a.*,
              b.nm_gudang,
              c.nm_material
            FROM
              warehouse_material_adjustment a
              LEFT JOIN warehouse b ON a.kd_gudang=b.kd_gudang
              LEFT JOIN ms_material c ON a.material = c.code_material,
              (SELECT @row:=0) r
            WHERE 1=1   AND (
              b.nm_gudang LIKE '%%'
              OR c.nm_material LIKE '%%'
            )
            
