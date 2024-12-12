<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-09-25 08:23:10 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-09-25 08:23:12 --> 404 Page Not Found: /index
ERROR - 2020-09-25 08:25:24 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-09-25 08:25:27 --> 404 Page Not Found: /index
ERROR - 2020-09-25 09:15:43 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-09-25 09:15:48 --> 404 Page Not Found: /index
ERROR - 2020-09-25 09:19:35 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-09-25 09:20:25 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-09-25 09:20:26 --> 404 Page Not Found: /index
ERROR - 2020-09-25 09:21:29 --> Query error: Unknown column 'b.unit' in 'field list' - Invalid query: 
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
		
ERROR - 2020-09-25 09:22:16 --> Query error: Unknown column 'b.unit' in 'field list' - Invalid query: 
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
		
ERROR - 2020-09-25 10:12:47 --> Query error: Unknown column 'b.unit' in 'field list' - Invalid query: 
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
		
ERROR - 2020-09-25 10:51:39 --> 404 Page Not Found: ../modules/penawaran/controllers/Penawaran/EditHeader
ERROR - 2020-09-25 11:23:27 --> Query error: Unknown column 'b.unit' in 'field list' - Invalid query: 
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
		
ERROR - 2020-09-25 11:23:32 --> Query error: Unknown column 'b.unit' in 'field list' - Invalid query: 
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
		
ERROR - 2020-09-25 11:23:34 --> Query error: Table 'metalsindo_db.material_wip' doesn't exist - Invalid query: 
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
    
ERROR - 2020-09-25 11:23:36 --> Query error: Unknown column 'b.unit' in 'field list' - Invalid query: 
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
		
ERROR - 2020-09-25 13:32:33 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-09-25 13:32:34 --> 404 Page Not Found: /index
ERROR - 2020-09-25 13:32:56 --> Query error: Unknown column 'b.unit' in 'field list' - Invalid query: 
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
		
ERROR - 2020-09-25 13:33:00 --> Query error: Table 'metalsindo_db.material_wip' doesn't exist - Invalid query: 
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
    
ERROR - 2020-09-25 13:33:02 --> Query error: Unknown column 'b.unit' in 'field list' - Invalid query: 
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
		
ERROR - 2020-09-25 13:33:05 --> Query error: Unknown column 'c.nm_material' in 'field list' - Invalid query: 
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
            
ERROR - 2020-09-25 13:53:00 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/penawaran/views/EditHeader.php 101
ERROR - 2020-09-25 14:30:10 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/penawaran/views/EditHeader.php 101
ERROR - 2020-09-25 14:36:17 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/penawaran/views/EditHeader.php 101
ERROR - 2020-09-25 14:37:23 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/penawaran/views/EditHeader.php 101
ERROR - 2020-09-25 14:37:58 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-09-25 14:37:59 --> 404 Page Not Found: /index
ERROR - 2020-09-25 14:38:18 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/penawaran/views/EditHeader.php 101
ERROR - 2020-09-25 14:38:19 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/penawaran/views/EditHeader.php 101
ERROR - 2020-09-25 14:52:00 --> Severity: Warning --> Invalid argument supplied for foreach() /home/ssc/metalsindo_dev/application/modules/penawaran/views/EditHeader.php 100
ERROR - 2020-09-25 16:24:43 --> Severity: Warning --> Missing argument 1 for Penawaran::PrintHeader() /home/ssc/metalsindo_dev/application/modules/penawaran/controllers/Penawaran.php 64
