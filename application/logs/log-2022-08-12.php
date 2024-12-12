<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2022-08-12 10:12:14 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /var/www/html/waterco/application/modules/users/views/login_animate.php 6
ERROR - 2022-08-12 10:12:15 --> 404 Page Not Found: /index
ERROR - 2022-08-12 10:27:35 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /var/www/html/waterco/application/modules/users/views/login_animate.php 6
ERROR - 2022-08-12 10:27:36 --> 404 Page Not Found: /index
ERROR - 2022-08-12 10:30:53 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /var/www/html/waterco/application/modules/users/views/login_animate.php 6
ERROR - 2022-08-12 10:30:53 --> 404 Page Not Found: /index
ERROR - 2022-08-12 09:39:21 --> Severity: Warning --> mysqli::query(): MySQL server has gone away /var/www/html/waterco/system/database/drivers/mysqli/mysqli_driver.php 306
ERROR - 2022-08-12 10:39:21 --> Severity: Warning --> mysqli::real_connect(): MySQL server has gone away /var/www/html/waterco/system/database/drivers/mysqli/mysqli_driver.php 202
ERROR - 2022-08-12 10:39:21 --> Severity: Warning --> mysqli::real_connect(): Error while reading greeting packet. PID=291309 /var/www/html/waterco/system/database/drivers/mysqli/mysqli_driver.php 202
ERROR - 2022-08-12 10:39:21 --> Severity: Warning --> mysqli::real_connect(): (HY000/2002): Connection refused /var/www/html/waterco/system/database/drivers/mysqli/mysqli_driver.php 202
ERROR - 2022-08-12 10:39:21 --> Severity: Warning --> mysqli::real_connect(): (HY000/2002): Connection refused /var/www/html/waterco/system/database/drivers/mysqli/mysqli_driver.php 202
ERROR - 2022-08-12 10:39:21 --> Severity: Warning --> mysqli::real_connect(): (HY000/2002): Connection refused /var/www/html/waterco/system/database/drivers/mysqli/mysqli_driver.php 202
ERROR - 2022-08-12 10:39:21 --> Unable to connect to the database
ERROR - 2022-08-12 09:39:21 --> Severity: Warning --> mysqli::query(): Error reading result set's header /var/www/html/waterco/system/database/drivers/mysqli/mysqli_driver.php 306
ERROR - 2022-08-12 09:39:21 --> Query error: MySQL server has gone away - Invalid query: SELECT `permissions`.`id_permission`
FROM `users`
JOIN `user_permissions` ON `users`.`id_user` = `user_permissions`.`id_user`
JOIN `permissions` ON `user_permissions`.`id_permission` = `permissions`.`id_permission`
WHERE `users`.`id_user` = '15'
ERROR - 2022-08-12 10:39:21 --> Severity: Warning --> mysqli::real_connect(): (HY000/2002): Connection refused /var/www/html/waterco/system/database/drivers/mysqli/mysqli_driver.php 202
ERROR - 2022-08-12 10:39:21 --> Unable to connect to the database
ERROR - 2022-08-12 10:39:21 --> Severity: Warning --> mysqli::real_connect(): (HY000/2002): Connection refused /var/www/html/waterco/system/database/drivers/mysqli/mysqli_driver.php 202
ERROR - 2022-08-12 10:39:21 --> Unable to connect to the database
ERROR - 2022-08-12 10:39:21 --> Severity: Warning --> mysqli::real_connect(): (HY000/2006): MySQL server has gone away /var/www/html/waterco/system/database/drivers/mysqli/mysqli_driver.php 202
ERROR - 2022-08-12 10:39:21 --> Unable to connect to the database
ERROR - 2022-08-12 10:39:21 --> Severity: Warning --> mysqli::query(): MySQL server has gone away /var/www/html/waterco/system/database/drivers/mysqli/mysqli_driver.php 306
ERROR - 2022-08-12 10:39:21 --> Unable to connect to the database
ERROR - 2022-08-12 10:39:21 --> Severity: Warning --> mysqli::query(): MySQL server has gone away /var/www/html/waterco/system/database/drivers/mysqli/mysqli_driver.php 306
ERROR - 2022-08-12 10:39:21 --> Severity: Warning --> mysqli::query(): Error reading result set's header /var/www/html/waterco/system/database/drivers/mysqli/mysqli_driver.php 306
ERROR - 2022-08-12 10:39:21 --> Query error: MySQL server has gone away - Invalid query: SELECT *
FROM `users`
JOIN `user_groups` ON `users`.`id_user` = `user_groups`.`id_user`
WHERE `users`.`id_user` IS NULL
AND `id_group` = 1
ERROR - 2022-08-12 10:39:21 --> Unable to connect to the database
ERROR - 2022-08-12 10:39:21 --> Severity: Warning --> mysqli::query(): Error reading result set's header /var/www/html/waterco/system/database/drivers/mysqli/mysqli_driver.php 306
ERROR - 2022-08-12 10:39:21 --> Query error: MySQL server has gone away - Invalid query: SELECT *
FROM `users`
JOIN `user_groups` ON `users`.`id_user` = `user_groups`.`id_user`
WHERE `users`.`id_user` IS NULL
AND `id_group` = 1
ERROR - 2022-08-12 10:39:21 --> Severity: Warning --> mysqli::real_connect(): (HY000/2002): Connection refused /var/www/html/waterco/system/database/drivers/mysqli/mysqli_driver.php 202
ERROR - 2022-08-12 10:39:21 --> Unable to connect to the database
ERROR - 2022-08-12 10:39:21 --> Severity: Warning --> mysqli::real_connect(): (HY000/2002): Connection refused /var/www/html/waterco/system/database/drivers/mysqli/mysqli_driver.php 202
ERROR - 2022-08-12 10:39:21 --> Unable to connect to the database
ERROR - 2022-08-12 10:39:21 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /var/www/html/waterco/system/core/Exceptions.php:272) /var/www/html/waterco/system/core/Common.php 573
ERROR - 2022-08-12 10:39:21 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /var/www/html/waterco/system/core/Exceptions.php:272) /var/www/html/waterco/system/core/Common.php 573
ERROR - 2022-08-12 09:39:21 --> Query error: MySQL server has gone away - Invalid query: UPDATE `ci_sessions` SET `timestamp` = 1660271961, `data` = '__ci_last_regenerate|i:1660271255;requested_page|s:12:\"wt_penawaran\";previous_page|s:14:\"wt_sales_order\";app_session|a:15:{s:7:\"id_user\";s:2:\"15\";s:8:\"username\";s:6:\"ivonne\";s:8:\"password\";s:60:\"$2y$10$P5tuRD7nvc7BuES3.Rss0OkiXzihUTKsuPVYrP9V2pgsheD5Do7Nq\";s:5:\"email\";s:24:\"waterco.ivonne@gmail.com\";s:10:\"nm_lengkap\";s:15:\"Jackline Ivonne\";s:6:\"alamat\";s:7:\"Jakarta\";s:4:\"kota\";s:7:\"Jakarta\";s:2:\"hp\";s:10:\"0811170384\";s:5:\"kdcab\";s:0:\"\";s:2:\"ip\";s:15:\"182.253.171.242\";s:14:\"login_terakhir\";s:19:\"2022-08-11 13:25:07\";s:8:\"st_aktif\";s:1:\"1\";s:5:\"photo\";N;s:10:\"created_on\";s:19:\"2022-07-06 10:51:30\";s:7:\"deleted\";s:1:\"0\";}'
WHERE `id` = 'fc51c41dc2a87852ca070d65e0db7f332780792c'
ERROR - 2022-08-12 10:39:21 --> Query error: MySQL server has gone away - Invalid query: SELECT GET_LOCK('fc51c41dc2a87852ca070d65e0db7f332780792c', 300) AS ci_session_lock
ERROR - 2022-08-12 10:39:21 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /var/www/html/waterco/system/core/Exceptions.php:272) /var/www/html/waterco/system/core/Common.php 573
ERROR - 2022-08-12 10:39:21 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /var/www/html/waterco/system/core/Exceptions.php:272) /var/www/html/waterco/system/core/Common.php 573
ERROR - 2022-08-12 10:39:21 --> Query error: MySQL server has gone away - Invalid query: SELECT GET_LOCK('fc51c41dc2a87852ca070d65e0db7f332780792c', 300) AS ci_session_lock
ERROR - 2022-08-12 10:39:21 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /var/www/html/waterco/system/core/Exceptions.php:272) /var/www/html/waterco/system/core/Common.php 573
ERROR - 2022-08-12 09:39:21 --> Query error: MySQL server has gone away - Invalid query: SELECT RELEASE_LOCK('fc51c41dc2a87852ca070d65e0db7f332780792c') AS ci_session_lock
ERROR - 2022-08-12 09:39:21 --> Severity: Warning --> Cannot modify header information - headers already sent /var/www/html/waterco/system/core/Common.php 573
ERROR - 2022-08-12 10:39:22 --> Severity: Warning --> mysqli::real_connect(): (HY000/2002): Connection refused /var/www/html/waterco/system/database/drivers/mysqli/mysqli_driver.php 202
ERROR - 2022-08-12 10:39:22 --> Unable to connect to the database
ERROR - 2022-08-12 10:39:22 --> Severity: Warning --> mysqli::real_connect(): (HY000/2002): Connection refused /var/www/html/waterco/system/database/drivers/mysqli/mysqli_driver.php 202
ERROR - 2022-08-12 10:39:22 --> Unable to connect to the database
ERROR - 2022-08-12 10:39:22 --> Severity: Warning --> mysqli::real_connect(): (HY000/2002): Connection refused /var/www/html/waterco/system/database/drivers/mysqli/mysqli_driver.php 202
ERROR - 2022-08-12 10:39:22 --> Unable to connect to the database
ERROR - 2022-08-12 10:39:22 --> Severity: Warning --> mysqli::real_connect(): (HY000/2002): Connection refused /var/www/html/waterco/system/database/drivers/mysqli/mysqli_driver.php 202
ERROR - 2022-08-12 10:39:22 --> Unable to connect to the database
ERROR - 2022-08-12 10:39:22 --> Severity: Warning --> mysqli::real_connect(): (HY000/2002): Connection refused /var/www/html/waterco/system/database/drivers/mysqli/mysqli_driver.php 202
ERROR - 2022-08-12 10:39:22 --> Unable to connect to the database
ERROR - 2022-08-12 10:39:22 --> Severity: Warning --> mysqli::real_connect(): (HY000/2002): Connection refused /var/www/html/waterco/system/database/drivers/mysqli/mysqli_driver.php 202
ERROR - 2022-08-12 10:39:22 --> Severity: Warning --> mysqli::real_connect(): (HY000/2002): Connection refused /var/www/html/waterco/system/database/drivers/mysqli/mysqli_driver.php 202
ERROR - 2022-08-12 10:39:22 --> Unable to connect to the database
ERROR - 2022-08-12 10:39:22 --> Severity: Warning --> mysqli::real_connect(): (HY000/2002): Connection refused /var/www/html/waterco/system/database/drivers/mysqli/mysqli_driver.php 202
ERROR - 2022-08-12 10:39:22 --> Severity: Warning --> mysqli::real_connect(): (HY000/2002): Connection refused /var/www/html/waterco/system/database/drivers/mysqli/mysqli_driver.php 202
ERROR - 2022-08-12 10:39:22 --> Severity: Warning --> mysqli::real_connect(): (HY000/2002): Connection refused /var/www/html/waterco/system/database/drivers/mysqli/mysqli_driver.php 202
ERROR - 2022-08-12 10:39:22 --> Unable to connect to the database
ERROR - 2022-08-12 10:39:22 --> Severity: Warning --> mysqli::real_connect(): (HY000/2002): Connection refused /var/www/html/waterco/system/database/drivers/mysqli/mysqli_driver.php 202
ERROR - 2022-08-12 10:39:22 --> Unable to connect to the database
ERROR - 2022-08-12 10:39:22 --> Severity: Warning --> mysqli::real_connect(): (HY000/2002): Connection refused /var/www/html/waterco/system/database/drivers/mysqli/mysqli_driver.php 202
ERROR - 2022-08-12 10:39:22 --> Unable to connect to the database
ERROR - 2022-08-12 10:39:22 --> Severity: Warning --> mysqli::real_connect(): (HY000/2002): Connection refused /var/www/html/waterco/system/database/drivers/mysqli/mysqli_driver.php 202
ERROR - 2022-08-12 10:39:22 --> Unable to connect to the database
ERROR - 2022-08-12 10:39:22 --> Severity: Warning --> mysqli::real_connect(): (HY000/2002): Connection refused /var/www/html/waterco/system/database/drivers/mysqli/mysqli_driver.php 202
ERROR - 2022-08-12 10:39:22 --> Unable to connect to the database
ERROR - 2022-08-12 10:39:22 --> Severity: Warning --> mysqli::real_connect(): (HY000/2002): Connection refused /var/www/html/waterco/system/database/drivers/mysqli/mysqli_driver.php 202
ERROR - 2022-08-12 10:39:22 --> Unable to connect to the database
ERROR - 2022-08-12 10:39:22 --> Unable to connect to the database
ERROR - 2022-08-12 10:39:22 --> Unable to connect to the database
ERROR - 2022-08-12 10:39:22 --> Unable to connect to the database
ERROR - 2022-08-12 10:39:22 --> Severity: Warning --> mysqli::real_connect(): (HY000/2002): Connection refused /var/www/html/waterco/system/database/drivers/mysqli/mysqli_driver.php 202
ERROR - 2022-08-12 10:39:22 --> Unable to connect to the database
ERROR - 2022-08-12 10:39:22 --> Severity: Warning --> mysqli::real_connect(): (HY000/2002): Connection refused /var/www/html/waterco/system/database/drivers/mysqli/mysqli_driver.php 202
ERROR - 2022-08-12 10:39:22 --> Unable to connect to the database
ERROR - 2022-08-12 10:39:22 --> Severity: Warning --> mysqli::real_connect(): (HY000/2002): Connection refused /var/www/html/waterco/system/database/drivers/mysqli/mysqli_driver.php 202
ERROR - 2022-08-12 10:39:22 --> Unable to connect to the database
ERROR - 2022-08-12 10:39:22 --> Severity: Warning --> mysqli::real_connect(): (HY000/2002): Connection refused /var/www/html/waterco/system/database/drivers/mysqli/mysqli_driver.php 202
ERROR - 2022-08-12 10:39:22 --> Severity: Warning --> mysqli::real_connect(): (HY000/2002): Connection refused /var/www/html/waterco/system/database/drivers/mysqli/mysqli_driver.php 202
ERROR - 2022-08-12 10:39:22 --> Severity: Warning --> mysqli::real_connect(): (HY000/2002): Connection refused /var/www/html/waterco/system/database/drivers/mysqli/mysqli_driver.php 202
ERROR - 2022-08-12 10:39:22 --> Unable to connect to the database
ERROR - 2022-08-12 10:39:22 --> Severity: Warning --> mysqli::real_connect(): (HY000/2002): Connection refused /var/www/html/waterco/system/database/drivers/mysqli/mysqli_driver.php 202
ERROR - 2022-08-12 10:39:22 --> Unable to connect to the database
ERROR - 2022-08-12 10:39:22 --> Unable to connect to the database
ERROR - 2022-08-12 10:39:22 --> Unable to connect to the database
ERROR - 2022-08-12 10:39:22 --> Severity: Warning --> mysqli::real_connect(): (HY000/2002): Connection refused /var/www/html/waterco/system/database/drivers/mysqli/mysqli_driver.php 202
ERROR - 2022-08-12 10:39:22 --> Unable to connect to the database
ERROR - 2022-08-12 10:39:22 --> Severity: Warning --> mysqli::real_connect(): (HY000/2002): Connection refused /var/www/html/waterco/system/database/drivers/mysqli/mysqli_driver.php 202
ERROR - 2022-08-12 10:39:22 --> Unable to connect to the database
ERROR - 2022-08-12 10:39:22 --> Severity: Warning --> mysqli::real_connect(): (HY000/2002): Connection refused /var/www/html/waterco/system/database/drivers/mysqli/mysqli_driver.php 202
ERROR - 2022-08-12 10:39:22 --> Unable to connect to the database
ERROR - 2022-08-12 10:39:22 --> Severity: Warning --> mysqli::real_connect(): (HY000/2002): Connection refused /var/www/html/waterco/system/database/drivers/mysqli/mysqli_driver.php 202
ERROR - 2022-08-12 10:39:22 --> Unable to connect to the database
ERROR - 2022-08-12 10:39:22 --> Severity: Warning --> mysqli::real_connect(): (HY000/2002): Connection refused /var/www/html/waterco/system/database/drivers/mysqli/mysqli_driver.php 202
ERROR - 2022-08-12 10:39:22 --> Unable to connect to the database
ERROR - 2022-08-12 10:39:22 --> Severity: Warning --> mysqli::real_connect(): (HY000/2002): Connection refused /var/www/html/waterco/system/database/drivers/mysqli/mysqli_driver.php 202
ERROR - 2022-08-12 10:39:22 --> Unable to connect to the database
ERROR - 2022-08-12 10:40:29 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /var/www/html/waterco/application/modules/users/views/login_animate.php 6
ERROR - 2022-08-12 10:40:29 --> 404 Page Not Found: /index
ERROR - 2022-08-12 10:46:38 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /var/www/html/waterco/application/modules/users/views/login_animate.php 6
ERROR - 2022-08-12 10:46:38 --> 404 Page Not Found: /index
ERROR - 2022-08-12 11:07:35 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /var/www/html/waterco/application/modules/users/views/login_animate.php 6
ERROR - 2022-08-12 11:07:35 --> 404 Page Not Found: /index
ERROR - 2022-08-12 11:07:39 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /var/www/html/waterco/application/modules/users/views/login_animate.php 6
ERROR - 2022-08-12 11:07:39 --> 404 Page Not Found: /index
ERROR - 2022-08-12 10:27:08 --> Severity: error --> Exception: ERROR n°6 : Impossible to load the image /var/www/html//waterco/assets/files/tandatangan/ /var/www/html/waterco/assets/html2pdf/html2pdf/html2pdf.class.php 1319
ERROR - 2022-08-12 10:27:25 --> Severity: error --> Exception: ERROR n°6 : Impossible to load the image /var/www/html//waterco/assets/files/tandatangan/ /var/www/html/waterco/assets/html2pdf/html2pdf/html2pdf.class.php 1319
ERROR - 2022-08-12 10:27:41 --> Severity: error --> Exception: ERROR n°6 : Impossible to load the image /var/www/html//waterco/assets/files/tandatangan/ /var/www/html/waterco/assets/html2pdf/html2pdf/html2pdf.class.php 1319
ERROR - 2022-08-12 10:28:20 --> Severity: error --> Exception: ERROR n°6 : Impossible to load the image /var/www/html//waterco/assets/files/tandatangan/ /var/www/html/waterco/assets/html2pdf/html2pdf/html2pdf.class.php 1319
ERROR - 2022-08-12 10:29:05 --> Severity: error --> Exception: ERROR n°6 : Impossible to load the image /var/www/html//waterco/assets/files/tandatangan/ /var/www/html/waterco/assets/html2pdf/html2pdf/html2pdf.class.php 1319
ERROR - 2022-08-12 10:29:11 --> Severity: error --> Exception: ERROR n°6 : Impossible to load the image /var/www/html/waterco/assets/files/tandatangan/ /var/www/html/waterco/assets/html2pdf/html2pdf/html2pdf.class.php 1319
ERROR - 2022-08-12 10:29:12 --> Severity: error --> Exception: ERROR n°6 : Impossible to load the image /var/www/html/waterco/assets/files/tandatangan/ /var/www/html/waterco/assets/html2pdf/html2pdf/html2pdf.class.php 1319
ERROR - 2022-08-12 10:30:59 --> Query error: Table 'waterco_live.ms_karyawan' doesn't exist - Invalid query: SELECT * FROM ms_karyawan WHERE id_karyawan='5'
ERROR - 2022-08-12 10:31:05 --> Severity: error --> Exception: ERROR n°6 : Impossible to load the image /var/www/html/waterco/assets/files/tandatangan/ /var/www/html/waterco/assets/html2pdf/html2pdf/html2pdf.class.php 1319
ERROR - 2022-08-12 11:17:09 --> Query error: Table 'waterco_live.child_customers_pic' doesn't exist - Invalid query: SELECT * FROM child_customers_pic WHERE id_customer='MC2000001'
ERROR - 2022-08-12 14:27:34 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /var/www/html/waterco/application/modules/users/views/login_animate.php 6
ERROR - 2022-08-12 14:27:35 --> 404 Page Not Found: /index
ERROR - 2022-08-12 13:45:06 --> Query error: Expression #1 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'waterco_live.a.id' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT *
FROM `ms_inventory_category2` `a`
GROUP BY `nama`
ERROR - 2022-08-12 13:45:11 --> Query error: Expression #1 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'waterco_live.a.id' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT *
FROM `ms_inventory_category2` `a`
GROUP BY `nama`
ERROR - 2022-08-12 13:47:54 --> Query error: Expression #1 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'waterco_live.a.id' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT *
FROM `ms_inventory_category2` `a`
GROUP BY `nama`
ERROR - 2022-08-12 14:49:02 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /var/www/html/waterco/application/modules/users/views/login_animate.php 6
ERROR - 2022-08-12 14:49:03 --> 404 Page Not Found: /index
ERROR - 2022-08-12 15:07:39 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /var/www/html/waterco/application/modules/users/views/login_animate.php 6
ERROR - 2022-08-12 15:07:40 --> 404 Page Not Found: /index
ERROR - 2022-08-12 14:07:55 --> Severity: error --> Exception: ERROR n°6 : Impossible to load the image /var/www/html/waterco/assets/files/tandatangan/ /var/www/html/waterco/assets/html2pdf/html2pdf/html2pdf.class.php 1319
ERROR - 2022-08-12 14:30:20 --> Severity: Error --> Call to undefined method Wt_penawaran_model::cariSalesOrderId() /var/www/html/waterco/application/modules/wt_sales_order/controllers/Wt_sales_order.php 858
ERROR - 2022-08-12 15:37:43 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /var/www/html/waterco/application/modules/users/views/login_animate.php 6
ERROR - 2022-08-12 15:37:43 --> 404 Page Not Found: /index
ERROR - 2022-08-12 15:54:08 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /var/www/html/waterco/application/modules/users/views/login_animate.php 6
ERROR - 2022-08-12 15:54:08 --> 404 Page Not Found: /index
ERROR - 2022-08-12 16:09:07 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /var/www/html/waterco/application/modules/users/views/login_animate.php 6
ERROR - 2022-08-12 16:09:07 --> 404 Page Not Found: /index
ERROR - 2022-08-12 17:45:37 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /var/www/html/waterco/application/modules/users/views/login_animate.php 6
ERROR - 2022-08-12 17:45:37 --> 404 Page Not Found: /index
