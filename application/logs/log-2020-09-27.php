<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-09-27 22:18:01 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-09-27 22:18:02 --> 404 Page Not Found: /index
ERROR - 2020-09-27 22:23:39 --> Query error: Unknown column 'b.unit' in 'field list' - Invalid query: 
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
		
