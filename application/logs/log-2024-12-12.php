<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2024-12-12 04:23:21 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /opt/lampp/htdocs/watercosystem/application/modules/users/views/login_animate.php 6
ERROR - 2024-12-12 04:23:21 --> 404 Page Not Found: /index
ERROR - 2024-12-12 04:23:45 --> Severity: Notice --> Undefined variable: inv /opt/lampp/htdocs/watercosystem/application/modules/reports/views/report_revenue.php 161
ERROR - 2024-12-12 04:23:45 --> Severity: Notice --> Trying to get property of non-object /opt/lampp/htdocs/watercosystem/application/modules/reports/views/report_revenue.php 161
ERROR - 2024-12-12 04:23:51 --> Severity: Notice --> Undefined property: stdClass::$nm_customer /opt/lampp/htdocs/watercosystem/application/modules/reports/views/report_revenue_detail.php 139
ERROR - 2024-12-12 04:53:16 --> Query error: Unknown column 'a.tgl_so' in 'where clause' - Invalid query: SELECT `a`.*, `b`.`tgl_so`, `b`.`no_surat`, `c`.`name_customer` as `customer`, GROUP_CONCAT((SELECT aa.no_surat FROM tr_invoice aa WHERE aa.no_so = a.no_so) SEPARATOR ", ") as invc
FROM `tr_sales_order_detail` `a`
JOIN `tr_sales_order` `b` ON `b`.`no_so`=`a`.`no_so`
JOIN `master_customers` `c` ON `c`.`id_customer`=`b`.`id_customer`
WHERE   (
`a`.`tgl_so` LIKE '%%' ESCAPE '!'
OR  `a`.`no_surat` LIKE '%%' ESCAPE '!'
OR  GROUP_CONCAT((SELECT aa.no_surat FROM tr_invoice aa WHERE aa.no_so = a.no_so) SEPARATOR ",")  LIKE '%%' ESCAPE '!'
OR  `a`.`name_customer` LIKE '%%' ESCAPE '!'
OR  `a`.`nama_produk` LIKE '%%' ESCAPE '!'
OR  `a`.`qty_so` LIKE '%%' ESCAPE '!'
OR  `a`.`harga_satuan` LIKE '%%' ESCAPE '!'
OR  (a.qty_so * a.harga_satuan) LIKE '%%' ESCAPE '!'
OR  `a`.`nilai_diskon` LIKE '%%' ESCAPE '!'
OR  `a`.`total_harga` LIKE '%%' ESCAPE '!'
 )
ORDER BY `a`.`tgl_so` DESC
 LIMIT 10
ERROR - 2024-12-12 04:53:25 --> Query error: Unknown column 'a.tgl_so' in 'where clause' - Invalid query: SELECT `a`.*, `b`.`tgl_so`, `b`.`no_surat`, `c`.`name_customer` as `customer`, GROUP_CONCAT((SELECT aa.no_surat FROM tr_invoice aa WHERE aa.no_so = a.no_so) SEPARATOR ", ") as invc
FROM `tr_sales_order_detail` `a`
JOIN `tr_sales_order` `b` ON `b`.`no_so`=`a`.`no_so`
JOIN `master_customers` `c` ON `c`.`id_customer`=`b`.`id_customer`
WHERE   (
`a`.`tgl_so` LIKE '%%' ESCAPE '!'
OR  `a`.`no_surat` LIKE '%%' ESCAPE '!'
OR  GROUP_CONCAT((SELECT aa.no_surat FROM tr_invoice aa WHERE aa.no_so = a.no_so) SEPARATOR ",")  LIKE '%%' ESCAPE '!'
OR  `a`.`name_customer` LIKE '%%' ESCAPE '!'
OR  `a`.`nama_produk` LIKE '%%' ESCAPE '!'
OR  `a`.`qty_so` LIKE '%%' ESCAPE '!'
OR  `a`.`harga_satuan` LIKE '%%' ESCAPE '!'
OR  (a.qty_so * a.harga_satuan) LIKE '%%' ESCAPE '!'
OR  `a`.`nilai_diskon` LIKE '%%' ESCAPE '!'
OR  `a`.`total_harga` LIKE '%%' ESCAPE '!'
 )
ORDER BY `a`.`tgl_so` DESC
 LIMIT 10
ERROR - 2024-12-12 04:54:08 --> Query error: Unknown column 'a.no_surat' in 'where clause' - Invalid query: SELECT `a`.*, `b`.`tgl_so`, `b`.`no_surat`, `c`.`name_customer` as `customer`, GROUP_CONCAT((SELECT aa.no_surat FROM tr_invoice aa WHERE aa.no_so = a.no_so) SEPARATOR ", ") as invc
FROM `tr_sales_order_detail` `a`
JOIN `tr_sales_order` `b` ON `b`.`no_so`=`a`.`no_so`
JOIN `master_customers` `c` ON `c`.`id_customer`=`b`.`id_customer`
WHERE   (
`b`.`tgl_so` LIKE '%%' ESCAPE '!'
OR  `a`.`no_surat` LIKE '%%' ESCAPE '!'
OR  GROUP_CONCAT((SELECT aa.no_surat FROM tr_invoice aa WHERE aa.no_so = a.no_so) SEPARATOR ",")  LIKE '%%' ESCAPE '!'
OR  `a`.`name_customer` LIKE '%%' ESCAPE '!'
OR  `a`.`nama_produk` LIKE '%%' ESCAPE '!'
OR  `a`.`qty_so` LIKE '%%' ESCAPE '!'
OR  `a`.`harga_satuan` LIKE '%%' ESCAPE '!'
OR  (a.qty_so * a.harga_satuan) LIKE '%%' ESCAPE '!'
OR  `a`.`nilai_diskon` LIKE '%%' ESCAPE '!'
OR  `a`.`total_harga` LIKE '%%' ESCAPE '!'
 )
ORDER BY `b`.`tgl_so` DESC
 LIMIT 10
ERROR - 2024-12-12 04:54:29 --> Query error: Invalid use of group function - Invalid query: SELECT `a`.*, `b`.`tgl_so`, `b`.`no_surat`, `c`.`name_customer` as `customer`, GROUP_CONCAT((SELECT aa.no_surat FROM tr_invoice aa WHERE aa.no_so = a.no_so) SEPARATOR ", ") as invc
FROM `tr_sales_order_detail` `a`
JOIN `tr_sales_order` `b` ON `b`.`no_so`=`a`.`no_so`
JOIN `master_customers` `c` ON `c`.`id_customer`=`b`.`id_customer`
WHERE   (
`b`.`tgl_so` LIKE '%%' ESCAPE '!'
OR  `b`.`no_surat` LIKE '%%' ESCAPE '!'
OR  GROUP_CONCAT((SELECT aa.no_surat FROM tr_invoice aa WHERE aa.no_so = a.no_so) SEPARATOR ",")  LIKE '%%' ESCAPE '!'
OR  `a`.`name_customer` LIKE '%%' ESCAPE '!'
OR  `a`.`nama_produk` LIKE '%%' ESCAPE '!'
OR  `a`.`qty_so` LIKE '%%' ESCAPE '!'
OR  `a`.`harga_satuan` LIKE '%%' ESCAPE '!'
OR  (a.qty_so * a.harga_satuan) LIKE '%%' ESCAPE '!'
OR  `a`.`nilai_diskon` LIKE '%%' ESCAPE '!'
OR  `a`.`total_harga` LIKE '%%' ESCAPE '!'
 )
ORDER BY `b`.`tgl_so` DESC
 LIMIT 10
ERROR - 2024-12-12 04:56:24 --> Query error: Unknown column 'a.name_customer' in 'where clause' - Invalid query: SELECT `a`.*, `b`.`tgl_so`, `b`.`no_surat`, `c`.`name_customer` as `customer`
FROM `tr_sales_order_detail` `a`
JOIN `tr_sales_order` `b` ON `b`.`no_so`=`a`.`no_so`
JOIN `master_customers` `c` ON `c`.`id_customer`=`b`.`id_customer`
WHERE   (
`b`.`tgl_so` LIKE '%%' ESCAPE '!'
OR  `b`.`no_surat` LIKE '%%' ESCAPE '!'
OR  `a`.`name_customer` LIKE '%%' ESCAPE '!'
OR  `a`.`nama_produk` LIKE '%%' ESCAPE '!'
OR  `a`.`qty_so` LIKE '%%' ESCAPE '!'
OR  `a`.`harga_satuan` LIKE '%%' ESCAPE '!'
OR  (a.qty_so * a.harga_satuan) LIKE '%%' ESCAPE '!'
OR  `a`.`nilai_diskon` LIKE '%%' ESCAPE '!'
OR  `a`.`total_harga` LIKE '%%' ESCAPE '!'
 )
ORDER BY `b`.`tgl_so` DESC
 LIMIT 10
ERROR - 2024-12-12 04:56:45 --> Severity: Notice --> Undefined property: stdClass::$name_customer /opt/lampp/htdocs/watercosystem/application/modules/reports/models/Reports_model.php 542
ERROR - 2024-12-12 04:56:45 --> Severity: Notice --> Undefined property: stdClass::$name_customer /opt/lampp/htdocs/watercosystem/application/modules/reports/models/Reports_model.php 542
ERROR - 2024-12-12 04:56:45 --> Severity: Notice --> Undefined property: stdClass::$name_customer /opt/lampp/htdocs/watercosystem/application/modules/reports/models/Reports_model.php 542
ERROR - 2024-12-12 04:56:45 --> Severity: Notice --> Undefined property: stdClass::$name_customer /opt/lampp/htdocs/watercosystem/application/modules/reports/models/Reports_model.php 542
ERROR - 2024-12-12 04:56:45 --> Severity: Notice --> Undefined property: stdClass::$name_customer /opt/lampp/htdocs/watercosystem/application/modules/reports/models/Reports_model.php 542
ERROR - 2024-12-12 04:56:45 --> Severity: Notice --> Undefined property: stdClass::$name_customer /opt/lampp/htdocs/watercosystem/application/modules/reports/models/Reports_model.php 542
ERROR - 2024-12-12 04:56:45 --> Severity: Notice --> Undefined property: stdClass::$name_customer /opt/lampp/htdocs/watercosystem/application/modules/reports/models/Reports_model.php 542
ERROR - 2024-12-12 04:56:45 --> Severity: Notice --> Undefined property: stdClass::$name_customer /opt/lampp/htdocs/watercosystem/application/modules/reports/models/Reports_model.php 542
ERROR - 2024-12-12 04:56:45 --> Severity: Notice --> Undefined property: stdClass::$name_customer /opt/lampp/htdocs/watercosystem/application/modules/reports/models/Reports_model.php 542
ERROR - 2024-12-12 04:56:45 --> Severity: Notice --> Undefined property: stdClass::$name_customer /opt/lampp/htdocs/watercosystem/application/modules/reports/models/Reports_model.php 542
ERROR - 2024-12-12 05:48:45 --> 404 Page Not Found: ../modules/tools/controllers/Tools/index
