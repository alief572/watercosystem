<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-08-22 10:42:43 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-08-22 10:42:54 --> 404 Page Not Found: /index
ERROR - 2020-08-22 10:58:01 --> Query error: Unknown column 'a.supplier_location' in 'where clause' - Invalid query: 
  			SELECT
  				a.*,b.name_category_supplier
  			FROM
                  master_supplier a
                  LEFT JOIN child_supplier_category b ON a.id_category_supplier = b.id_category_supplier
  			WHERE 1=1
           AND a.activation = 'active' 
				AND a.supplier_location ='local'
  				AND (
  				a.id_supplier LIKE '%%'
  				OR a.name_supplier LIKE '%%'
                OR a.address_office LIKE '%%'
                OR a.activation LIKE '%%'
                OR b.name_category_supplier LIKE '%%'
  	        )
  		
ERROR - 2020-08-22 10:58:01 --> Query error: Unknown column 'a.supplier_location' in 'where clause' - Invalid query: 
  			SELECT
  				a.*,b.name_category_supplier
  			FROM
                  master_supplier a
                  LEFT JOIN child_supplier_category b ON a.id_category_supplier = b.id_category_supplier
  			WHERE 1=1
           AND a.activation = 'active' 
				AND a.supplier_location ='international'
  				AND (
  				a.id_supplier LIKE '%%'
  				OR a.name_supplier LIKE '%%'
                OR a.address_office LIKE '%%'
                OR a.activation LIKE '%%'
                OR b.name_category_supplier LIKE '%%'
  	        )
  		
ERROR - 2020-08-22 10:58:05 --> Query error: Unknown column 'id_supplier' in 'where clause' - Invalid query: SELECT *
FROM `master_supplier`
WHERE `id_supplier` = ''
ERROR - 2020-08-22 10:58:18 --> Query error: Unknown column 'id_supplier' in 'where clause' - Invalid query: SELECT *
FROM `master_supplier`
WHERE `id_supplier` = ''
ERROR - 2020-08-22 11:28:20 --> Query error: Unknown column 'a.supplier_location' in 'where clause' - Invalid query: 
  			SELECT
  				a.*,b.name_category_supplier
  			FROM
                  master_supplier a
                  LEFT JOIN child_supplier_category b ON a.id_category_supplier = b.id_category_supplier
  			WHERE 1=1
           AND a.activation = 'active' 
				AND a.supplier_location ='local'
  				AND (
  				a.id_supplier LIKE '%%'
  				OR a.name_supplier LIKE '%%'
                OR a.address_office LIKE '%%'
                OR a.activation LIKE '%%'
                OR b.name_category_supplier LIKE '%%'
  	        )
  		
ERROR - 2020-08-22 11:28:20 --> Query error: Unknown column 'a.supplier_location' in 'where clause' - Invalid query: 
  			SELECT
  				a.*,b.name_category_supplier
  			FROM
                  master_supplier a
                  LEFT JOIN child_supplier_category b ON a.id_category_supplier = b.id_category_supplier
  			WHERE 1=1
           AND a.activation = 'active' 
				AND a.supplier_location ='international'
  				AND (
  				a.id_supplier LIKE '%%'
  				OR a.name_supplier LIKE '%%'
                OR a.address_office LIKE '%%'
                OR a.activation LIKE '%%'
                OR b.name_category_supplier LIKE '%%'
  	        )
  		
ERROR - 2020-08-22 12:03:12 --> Query error: Unknown column 'a.supplier_location' in 'where clause' - Invalid query: 
  			SELECT
  				a.*,b.name_category_supplier
  			FROM
                  master_supplier a
                  LEFT JOIN child_supplier_category b ON a.id_category_supplier = b.id_category_supplier
  			WHERE 1=1
           AND a.activation = 'active' 
				AND a.supplier_location ='local'
  				AND (
  				a.id_supplier LIKE '%%'
  				OR a.name_supplier LIKE '%%'
                OR a.address_office LIKE '%%'
                OR a.activation LIKE '%%'
                OR b.name_category_supplier LIKE '%%'
  	        )
  		
ERROR - 2020-08-22 12:03:12 --> Query error: Unknown column 'a.supplier_location' in 'where clause' - Invalid query: 
  			SELECT
  				a.*,b.name_category_supplier
  			FROM
                  master_supplier a
                  LEFT JOIN child_supplier_category b ON a.id_category_supplier = b.id_category_supplier
  			WHERE 1=1
           AND a.activation = 'active' 
				AND a.supplier_location ='international'
  				AND (
  				a.id_supplier LIKE '%%'
  				OR a.name_supplier LIKE '%%'
                OR a.address_office LIKE '%%'
                OR a.activation LIKE '%%'
                OR b.name_category_supplier LIKE '%%'
  	        )
  		
