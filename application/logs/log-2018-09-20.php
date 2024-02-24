<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2018-09-20 08:14:02 --> Severity: Notice --> Undefined variable: nama_program /home/www/importa/application/modules/users/views/login_animate.php 6
ERROR - 2018-09-20 08:14:09 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/barang/views/barang_form.php 41
ERROR - 2018-09-20 08:14:09 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/barang/views/barang_form.php 60
ERROR - 2018-09-20 08:14:09 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/barang/views/barang_form.php 122
ERROR - 2018-09-20 08:14:09 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/barang/views/barang_form.php 273
ERROR - 2018-09-20 08:14:09 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/barang/views/barang_form.php 397
ERROR - 2018-09-20 08:14:50 --> 404 Page Not Found: /index
ERROR - 2018-09-20 08:19:02 --> Severity: Notice --> Undefined variable: nama_program /home/www/importa/application/modules/users/views/login_animate.php 6
ERROR - 2018-09-20 09:24:56 --> 404 Page Not Found: ../modules/pickinglistdop/controllers//index
ERROR - 2018-09-20 09:28:13 --> Query error: Unknown column 'qty_booker' in 'where clause' - Invalid query: SELECT *
FROM `trans_so_header`
LEFT JOIN `trans_so_detail` ON `trans_so_detail`.`no_so` = `trans_so_header`.`no_so`
WHERE `qty_booker` > 'qty_supply'
ORDER BY `trans_so_header`.`no_so` ASC
ERROR - 2018-09-20 09:31:38 --> Query error: Unknown column 'qty_booker' in 'where clause' - Invalid query: SELECT *
FROM `trans_so_header`
LEFT JOIN `trans_so_detail` ON `trans_so_detail`.`no_so` = `trans_so_header`.`no_so`
WHERE `qty_booker` > 'qty_supply'
ORDER BY `trans_so_header`.`no_so` ASC
ERROR - 2018-09-20 09:36:59 --> Severity: Notice --> Undefined variable: nama_program /home/www/importa/application/modules/users/views/login_animate.php 6
ERROR - 2018-09-20 09:37:37 --> 404 Page Not Found: /index
ERROR - 2018-09-20 09:37:44 --> Query error: Unknown column 'qty_booker' in 'where clause' - Invalid query: SELECT *
FROM `trans_so_header`
LEFT JOIN `trans_so_detail` ON `trans_so_detail`.`no_so` = `trans_so_header`.`no_so`
WHERE `qty_booker` > 'qty_supply'
ORDER BY `trans_so_header`.`no_so` ASC
ERROR - 2018-09-20 09:38:15 --> Query error: Unknown column 'qty_booker' in 'where clause' - Invalid query: SELECT *
FROM `trans_so_header`
LEFT JOIN `trans_so_detail` ON `trans_so_detail`.`no_so` = `trans_so_header`.`no_so`
WHERE `qty_booker` > `qty_supply`
ORDER BY `trans_so_header`.`no_so` ASC
ERROR - 2018-09-20 09:38:17 --> Query error: Unknown column 'qty_booker' in 'where clause' - Invalid query: SELECT *
FROM `trans_so_header`
LEFT JOIN `trans_so_detail` ON `trans_so_detail`.`no_so` = `trans_so_header`.`no_so`
WHERE `qty_booker` > `qty_supply`
ORDER BY `trans_so_header`.`no_so` ASC
ERROR - 2018-09-20 09:38:18 --> Query error: Unknown column 'qty_booker' in 'where clause' - Invalid query: SELECT *
FROM `trans_so_header`
LEFT JOIN `trans_so_detail` ON `trans_so_detail`.`no_so` = `trans_so_header`.`no_so`
WHERE `qty_booker` > `qty_supply`
ORDER BY `trans_so_header`.`no_so` ASC
ERROR - 2018-09-20 09:38:47 --> 404 Page Not Found: /index
ERROR - 2018-09-20 10:22:42 --> Severity: Notice --> Undefined variable: nama_program /home/www/importa/application/modules/users/views/login_animate.php 6
ERROR - 2018-09-20 10:23:18 --> Severity: Notice --> Undefined variable: nama_program /home/www/importa/application/modules/users/views/login_animate.php 6
ERROR - 2018-09-20 10:23:28 --> Severity: Notice --> Undefined variable: nama_program /home/www/importa/application/modules/users/views/login_animate.php 6
ERROR - 2018-09-20 10:29:58 --> 404 Page Not Found: /index
ERROR - 2018-09-20 12:25:34 --> Severity: Notice --> Undefined variable: nama_program /home/www/importa/application/modules/users/views/login_animate.php 6
ERROR - 2018-09-20 13:38:12 --> Severity: Notice --> Undefined variable: nama_program /home/www/importa/application/modules/users/views/login_animate.php 6
ERROR - 2018-09-20 13:53:42 --> Severity: Notice --> Undefined variable: nama_program /home/www/importa/application/modules/users/views/login_animate.php 6
ERROR - 2018-09-20 16:26:47 --> Severity: Notice --> Undefined variable: nama_program /home/www/importa/application/modules/users/views/login_animate.php 6
ERROR - 2018-09-20 16:27:09 --> Severity: Notice --> Undefined variable: nama_program /home/www/importa/application/modules/users/views/login_animate.php 6
ERROR - 2018-09-20 16:51:57 --> Severity: Parsing Error --> syntax error, unexpected '?>' /home/www/importa/application/modules/pendingso/views/list.php 37
ERROR - 2018-09-20 16:59:12 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'FROM
            trans_so_header a
            JOIN
            trans_so_detail ' at line 6 - Invalid query: SELECT
            a.no_so,a.nm_customer,a.tanggal,a.stsorder,
            SUM(b.qty_order) AS qty_order,
            SUM(b.qty_pending) AS qty_pending,
            SUM(b.qty_cancel) AS qty_cancel,
            FROM
            trans_so_header a
            JOIN
            trans_so_detail b ON a.no_so = b.no_so
            WHERE qty_pending != 0
            GROUP BY a.no_so
ERROR - 2018-09-20 17:09:14 --> Severity: Notice --> Undefined variable: nama_program /home/www/importa/application/modules/users/views/login_animate.php 6
ERROR - 2018-09-20 17:14:11 --> Query error: Column 'no_so' in group statement is ambiguous - Invalid query: SELECT *
FROM `trans_so_header`
LEFT JOIN `trans_so_detail` ON `trans_so_detail`.`no_so` = `trans_so_header`.`no_so`
WHERE `qty_booked` > `qty_supply`
GROUP BY `no_so`
ORDER BY `trans_so_header`.`no_so` ASC
ERROR - 2018-09-20 18:22:54 --> Severity: Notice --> Undefined variable: nama_program /home/www/importa/application/modules/users/views/login_animate.php 6
ERROR - 2018-09-20 20:06:28 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 50
ERROR - 2018-09-20 20:06:28 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 105
ERROR - 2018-09-20 20:06:28 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 119
ERROR - 2018-09-20 20:06:28 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 177
ERROR - 2018-09-20 20:06:28 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 190
ERROR - 2018-09-20 20:06:28 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 336
ERROR - 2018-09-20 20:06:28 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 400
ERROR - 2018-09-20 20:06:28 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 632
ERROR - 2018-09-20 20:21:17 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 50
ERROR - 2018-09-20 20:21:17 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 105
ERROR - 2018-09-20 20:21:17 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 119
ERROR - 2018-09-20 20:21:17 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 177
ERROR - 2018-09-20 20:21:17 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 190
ERROR - 2018-09-20 20:21:17 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 336
ERROR - 2018-09-20 20:21:17 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 400
ERROR - 2018-09-20 20:21:17 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 632
ERROR - 2018-09-20 20:21:30 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 50
ERROR - 2018-09-20 20:21:30 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 105
ERROR - 2018-09-20 20:21:30 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 119
ERROR - 2018-09-20 20:21:30 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 177
ERROR - 2018-09-20 20:21:30 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 190
ERROR - 2018-09-20 20:21:30 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 336
ERROR - 2018-09-20 20:21:30 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 400
ERROR - 2018-09-20 20:21:30 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 632
ERROR - 2018-09-20 20:34:04 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 50
ERROR - 2018-09-20 20:34:04 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 105
ERROR - 2018-09-20 20:34:04 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 119
ERROR - 2018-09-20 20:34:04 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 177
ERROR - 2018-09-20 20:34:04 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 190
ERROR - 2018-09-20 20:34:04 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 336
ERROR - 2018-09-20 20:34:04 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 400
ERROR - 2018-09-20 20:34:04 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 632
ERROR - 2018-09-20 20:34:30 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 50
ERROR - 2018-09-20 20:34:30 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 105
ERROR - 2018-09-20 20:34:30 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 119
ERROR - 2018-09-20 20:34:30 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 177
ERROR - 2018-09-20 20:34:30 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 190
ERROR - 2018-09-20 20:34:30 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 336
ERROR - 2018-09-20 20:34:30 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 400
ERROR - 2018-09-20 20:34:30 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 632
ERROR - 2018-09-20 20:34:33 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 50
ERROR - 2018-09-20 20:34:33 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 105
ERROR - 2018-09-20 20:34:33 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 119
ERROR - 2018-09-20 20:34:33 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 177
ERROR - 2018-09-20 20:34:33 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 190
ERROR - 2018-09-20 20:34:33 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 336
ERROR - 2018-09-20 20:34:33 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 400
ERROR - 2018-09-20 20:34:33 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 632
ERROR - 2018-09-20 20:34:35 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 50
ERROR - 2018-09-20 20:34:35 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 105
ERROR - 2018-09-20 20:34:35 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 119
ERROR - 2018-09-20 20:34:35 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 177
ERROR - 2018-09-20 20:34:35 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 190
ERROR - 2018-09-20 20:34:35 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 336
ERROR - 2018-09-20 20:34:35 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 400
ERROR - 2018-09-20 20:34:35 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 632
ERROR - 2018-09-20 20:35:09 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 50
ERROR - 2018-09-20 20:35:09 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 105
ERROR - 2018-09-20 20:35:09 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 119
ERROR - 2018-09-20 20:35:09 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 177
ERROR - 2018-09-20 20:35:09 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 190
ERROR - 2018-09-20 20:35:09 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 336
ERROR - 2018-09-20 20:35:09 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 400
ERROR - 2018-09-20 20:35:09 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 632
ERROR - 2018-09-20 20:35:11 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 50
ERROR - 2018-09-20 20:35:11 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 105
ERROR - 2018-09-20 20:35:11 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 119
ERROR - 2018-09-20 20:35:11 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 177
ERROR - 2018-09-20 20:35:11 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 190
ERROR - 2018-09-20 20:35:11 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 336
ERROR - 2018-09-20 20:35:11 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 400
ERROR - 2018-09-20 20:35:11 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 632
ERROR - 2018-09-20 20:35:13 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 50
ERROR - 2018-09-20 20:35:13 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 105
ERROR - 2018-09-20 20:35:13 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 119
ERROR - 2018-09-20 20:35:13 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 177
ERROR - 2018-09-20 20:35:13 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 190
ERROR - 2018-09-20 20:35:13 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 336
ERROR - 2018-09-20 20:35:13 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 400
ERROR - 2018-09-20 20:35:13 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 632
ERROR - 2018-09-20 20:35:15 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 50
ERROR - 2018-09-20 20:35:15 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 105
ERROR - 2018-09-20 20:35:15 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 119
ERROR - 2018-09-20 20:35:15 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 177
ERROR - 2018-09-20 20:35:15 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 190
ERROR - 2018-09-20 20:35:15 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 336
ERROR - 2018-09-20 20:35:15 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 400
ERROR - 2018-09-20 20:35:15 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 632
ERROR - 2018-09-20 20:36:15 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 50
ERROR - 2018-09-20 20:36:15 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 105
ERROR - 2018-09-20 20:36:15 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 119
ERROR - 2018-09-20 20:36:15 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 177
ERROR - 2018-09-20 20:36:15 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 190
ERROR - 2018-09-20 20:36:15 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 336
ERROR - 2018-09-20 20:36:15 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 400
ERROR - 2018-09-20 20:36:15 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 632
ERROR - 2018-09-20 20:39:03 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 50
ERROR - 2018-09-20 20:39:03 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 105
ERROR - 2018-09-20 20:39:03 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 119
ERROR - 2018-09-20 20:39:03 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 177
ERROR - 2018-09-20 20:39:03 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 190
ERROR - 2018-09-20 20:39:03 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 336
ERROR - 2018-09-20 20:39:03 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 400
ERROR - 2018-09-20 20:39:03 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 632
ERROR - 2018-09-20 20:39:14 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 50
ERROR - 2018-09-20 20:39:14 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 105
ERROR - 2018-09-20 20:39:14 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 119
ERROR - 2018-09-20 20:39:14 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 177
ERROR - 2018-09-20 20:39:14 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 190
ERROR - 2018-09-20 20:39:14 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 336
ERROR - 2018-09-20 20:39:14 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 400
ERROR - 2018-09-20 20:39:14 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 632
ERROR - 2018-09-20 20:40:18 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/karyawan/views/karyawan_form.php 126
ERROR - 2018-09-20 20:40:21 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 50
ERROR - 2018-09-20 20:40:21 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 105
ERROR - 2018-09-20 20:40:21 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 119
ERROR - 2018-09-20 20:40:21 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 177
ERROR - 2018-09-20 20:40:21 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 190
ERROR - 2018-09-20 20:40:21 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 336
ERROR - 2018-09-20 20:40:21 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 400
ERROR - 2018-09-20 20:40:21 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/customer/views/customer_form.php 632
