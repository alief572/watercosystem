<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-08-28 07:16:30 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-08-28 07:16:42 --> 404 Page Not Found: /index
ERROR - 2020-08-28 07:23:18 --> 404 Page Not Found: ../modules/master_suplier/controllers/Master_suplier/viewLokal
ERROR - 2020-08-28 07:44:14 --> Severity: Compile Error --> Cannot redeclare Lme_model::getUpdate() /home/ssc/metalsindo_dev/application/modules/master_lme/models/Lme_model.php 160
ERROR - 2020-08-28 07:53:58 --> Severity: Parsing Error --> syntax error, unexpected '$this' (T_VARIABLE) /home/ssc/metalsindo_dev/application/modules/master_lme/views/index.php 99
ERROR - 2020-08-28 07:54:28 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'WHERE  IS NULL' at line 2 - Invalid query: SELECT *
WHERE  IS NULL
ERROR - 2020-08-28 07:59:55 --> Severity: Parsing Error --> syntax error, unexpected end of file, expecting function (T_FUNCTION) /home/ssc/metalsindo_dev/application/modules/master_lme/models/Lme_model.php 188
ERROR - 2020-08-28 08:00:26 --> Severity: Parsing Error --> syntax error, unexpected ')' /home/ssc/metalsindo_dev/application/modules/master_lme/views/index.php 98
ERROR - 2020-08-28 08:00:47 --> Severity: Error --> Call to undefined method CI_DB_mysqli_driver::getSebulan() /home/ssc/metalsindo_dev/application/modules/master_lme/views/index.php 98
ERROR - 2020-08-28 09:03:58 --> Query error: Unknown column 'd.created_on' in 'where clause' - Invalid query: SELECT `a`.*, `b`.`nominal` as `nominal_harga`, `c`.`nominal` as `nominal10`, `d`.`nominal` as `nominal30`
FROM `ms_compotition` `a`
JOIN `child_history_lme` `b` ON `b`.`id_compotition`=`a`.`id_compotition`
JOIN (select sum(nominal)as nominal ,id_compotition from child_history_lme group by id_compotition) c ON `a`.`id_compotition`=`c`.`id_compotition`
JOIN (select sum(nominal)as nominal ,id_compotition from child_history_lme group by id_compotition) d ON `a`.`id_compotition`=`d`.`id_compotition`
WHERE `a`.`deleted` = '0' and `b`.`status` = '0' and `d`.`created_on` between '2020-07-29 00:00:00' and '2020-08-28 09:03:58' and `c`.`created_on` between '2020-08-18 00:00:00' and '2020-08-28 09:03:58'
ERROR - 2020-08-28 09:08:57 --> Severity: Parsing Error --> syntax error, unexpected '$tendays' (T_VARIABLE) /home/ssc/metalsindo_dev/application/modules/master_lme/models/Lme_model.php 170
ERROR - 2020-08-28 09:09:42 --> Severity: Parsing Error --> syntax error, unexpected '$sbln' (T_VARIABLE) /home/ssc/metalsindo_dev/application/modules/master_lme/models/Lme_model.php 170
ERROR - 2020-08-28 09:10:50 --> Query error: Unknown column 'd.created_on' in 'where clause' - Invalid query: SELECT `a`.*, `b`.`nominal` as `nominal_harga`, `c`.`nominal` as `nominal10`, `d`.`nominal` as `nominal30`
FROM `ms_compotition` `a`
JOIN `child_history_lme` `b` ON `b`.`id_compotition`=`a`.`id_compotition`
JOIN (select sum(nominal)as nominal ,id_compotition from child_history_lme group by id_compotition) c ON `a`.`id_compotition`=`c`.`id_compotition`
JOIN (select sum(nominal)as nominal ,id_compotition from child_history_lme group by id_compotition) d ON `a`.`id_compotition`=`d`.`id_compotition`
WHERE `a`.`deleted` = '0' and `b`.`status` = '0' and `d`.`created_on` between '2020-07-29 00:00:00' and '2020-08-28 09:10:50' and `c`.`created_on` between '2020-08-18 00:00:00' and '2020-08-28 09:10:50'
ERROR - 2020-08-28 09:14:11 --> Query error: Unknown column 'd.nominal' in 'field list' - Invalid query: SELECT `a`.*, `b`.`nominal` as `nominal_harga`, `c`.`nominal` as `nominal10`, `d`.`nominal` as `nominal30`
FROM `ms_compotition` `a`
JOIN `child_history_lme` `b` ON `b`.`id_compotition`=`a`.`id_compotition`
JOIN (select sum(nominal)as nominal ,id_compotition from child_history_lme group by id_compotition) c ON `a`.`id_compotition`=`c`.`id_compotition`
WHERE `a`.`deleted` = '0' and `b`.`status` = '0'  and `c`.`created_on` between '2020-08-18 00:00:00' and '2020-08-28 09:14:11'
ERROR - 2020-08-28 09:14:40 --> Query error: Unknown column 'c.created_on' in 'where clause' - Invalid query: SELECT `a`.*, `b`.`nominal` as `nominal_harga`, `c`.`nominal` as `nominal10`
FROM `ms_compotition` `a`
JOIN `child_history_lme` `b` ON `b`.`id_compotition`=`a`.`id_compotition`
JOIN (select sum(nominal)as nominal ,id_compotition from child_history_lme group by id_compotition) c ON `a`.`id_compotition`=`c`.`id_compotition`
WHERE `a`.`deleted` = '0' and `b`.`status` = '0'  and `c`.`created_on` between '2020-08-18 00:00:00' and '2020-08-28 09:14:40'
ERROR - 2020-08-28 09:38:38 --> Severity: Parsing Error --> syntax error, unexpected '$antara30' (T_VARIABLE) /home/ssc/metalsindo_dev/application/modules/master_lme/models/Lme_model.php 167
ERROR - 2020-08-28 09:44:32 --> Severity: Parsing Error --> syntax error, unexpected '$tendays' (T_VARIABLE) /home/ssc/metalsindo_dev/application/modules/master_lme/models/Lme_model.php 172
ERROR - 2020-08-28 09:45:18 --> Query error: Unknown column '$tendays' in 'where clause' - Invalid query: SELECT `a`.*, `b`.`nominal` as `nominal_harga`, `c`.`nominal` as `nominal10`, `d`.`nominal` as `nominal30`
FROM `ms_compotition` `a`
JOIN `child_history_lme` `b` ON `b`.`id_compotition`=`a`.`id_compotition`
JOIN (select avg(nominal)as nominal ,id_compotition from child_history_lme WHERE created_on BETWEEN $tendays and $hariini group by id_compotition) c ON `a`.`id_compotition`=`c`.`id_compotition`
JOIN (select avg(nominal)as nominal ,id_compotition from child_history_lme group by id_compotition) d ON `a`.`id_compotition`=`d`.`id_compotition`
WHERE `a`.`deleted` = '0' and `b`.`status` = '0'
ERROR - 2020-08-28 09:46:54 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '07:36:59 and 2020-08-28 07:36:59 group by id_compotition) c ON `a`.`id_compotiti' at line 4 - Invalid query: SELECT `a`.*, `b`.`nominal` as `nominal_harga`, `c`.`nominal` as `nominal10`, `d`.`nominal` as `nominal30`
FROM `ms_compotition` `a`
JOIN `child_history_lme` `b` ON `b`.`id_compotition`=`a`.`id_compotition`
JOIN (select avg(nominal)as nominal ,id_compotition from child_history_lme WHERE created_on BETWEEN 2020-08-18 07:36:59 and 2020-08-28 07:36:59 group by id_compotition) c ON `a`.`id_compotition`=`c`.`id_compotition`
JOIN (select avg(nominal)as nominal ,id_compotition from child_history_lme group by id_compotition) d ON `a`.`id_compotition`=`d`.`id_compotition`
WHERE `a`.`deleted` = '0' and `b`.`status` = '0'
ERROR - 2020-08-28 09:47:47 --> Severity: Warning --> Missing argument 2 for CI_DB_query_builder::join(), called in /home/ssc/metalsindo_dev/application/modules/master_lme/models/Lme_model.php on line 172 and defined /home/ssc/metalsindo_dev/system/database/DB_query_builder.php 512
ERROR - 2020-08-28 09:47:47 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '','a.id_compotition=c.id_compotition USING ()
JOIN (select avg(nominal)as nomina' at line 4 - Invalid query: SELECT `a`.*, `b`.`nominal` as `nominal_harga`, `c`.`nominal` as `nominal10`, `d`.`nominal` as `nominal30`
FROM `ms_compotition` `a`
JOIN `child_history_lme` `b` ON `b`.`id_compotition`=`a`.`id_compotition`
JOIN (select avg(nominal)as nominal ,id_compotition from child_history_lme WHERE created_on BETWEEN '2020-08-18 07:36:59' and '2020-08-28 07:36:59' group by id_compotition) c','a.id_compotition=c.id_compotition USING ()
JOIN (select avg(nominal)as nominal ,id_compotition from child_history_lme group by id_compotition) d ON `a`.`id_compotition`=`d`.`id_compotition`
WHERE `a`.`deleted` = '0' and `b`.`status` = '0'
ERROR - 2020-08-28 09:48:59 --> Severity: Warning --> Missing argument 2 for CI_DB_query_builder::join(), called in /home/ssc/metalsindo_dev/application/modules/master_lme/models/Lme_model.php on line 172 and defined /home/ssc/metalsindo_dev/system/database/DB_query_builder.php 512
ERROR - 2020-08-28 09:48:59 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '','a.id_compotition=c.id_compotition USING ()
JOIN (select avg(nominal)as nomina' at line 4 - Invalid query: SELECT `a`.*, `b`.`nominal` as `nominal_harga`, `c`.`nominal` as `nominal10`, `d`.`nominal` as `nominal30`
FROM `ms_compotition` `a`
JOIN `child_history_lme` `b` ON `b`.`id_compotition`=`a`.`id_compotition`
JOIN (select avg(nominal)as nominal ,id_compotition from child_history_lme WHERE created_on BETWEEN '2020-08-18 00:00:00' and '2020-08-28 09:48:59' group by id_compotition) c','a.id_compotition=c.id_compotition USING ()
JOIN (select avg(nominal)as nominal ,id_compotition from child_history_lme group by id_compotition) d ON `a`.`id_compotition`=`d`.`id_compotition`
WHERE `a`.`deleted` = '0' and `b`.`status` = '0'
ERROR - 2020-08-28 09:49:05 --> Severity: Warning --> Missing argument 2 for CI_DB_query_builder::join(), called in /home/ssc/metalsindo_dev/application/modules/master_lme/models/Lme_model.php on line 172 and defined /home/ssc/metalsindo_dev/system/database/DB_query_builder.php 512
ERROR - 2020-08-28 09:49:05 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '','a.id_compotition=c.id_compotition USING ()
JOIN (select avg(nominal)as nomina' at line 4 - Invalid query: SELECT `a`.*, `b`.`nominal` as `nominal_harga`, `c`.`nominal` as `nominal10`, `d`.`nominal` as `nominal30`
FROM `ms_compotition` `a`
JOIN `child_history_lme` `b` ON `b`.`id_compotition`=`a`.`id_compotition`
JOIN (select avg(nominal)as nominal ,id_compotition from child_history_lme WHERE created_on BETWEEN '2020-08-18 00:00:00' and '2020-08-28 09:49:05' group by id_compotition) c','a.id_compotition=c.id_compotition USING ()
JOIN (select avg(nominal)as nominal ,id_compotition from child_history_lme group by id_compotition) d ON `a`.`id_compotition`=`d`.`id_compotition`
WHERE `a`.`deleted` = '0' and `b`.`status` = '0'
ERROR - 2020-08-28 09:52:35 --> Query error: Unknown column 'd.nominal as nominal30 e.nominal' in 'field list' - Invalid query: SELECT `a`.*, `b`.`nominal` as `nominal_harga`, `c`.`nominal` as `nominal10`, `d`.`nominal as nominal30 e`.`nominal` as `nominal30`
FROM `ms_compotition` `a`
JOIN `child_history_lme` `b` ON `b`.`id_compotition`=`a`.`id_compotition`
JOIN (select avg(nominal)as nominal ,id_compotition from child_history_lme group by id_compotition) c ON `a`.`id_compotition`=`c`.`id_compotition`
JOIN (select avg(nominal)as nominal ,id_compotition from child_history_lme group by id_compotition) d ON `a`.`id_compotition`=`d`.`id_compotition`
JOIN `child_history_lme` `e` ON `e`.`id_compotition`=`a`.`id_compotition`
WHERE `a`.`deleted` = '0' and `b`.`status` = '0' and `e`.`created_on` between '2020-08-18 00:00:00' and '2020-08-28 09:52:35' 
ERROR - 2020-08-28 09:54:24 --> Severity: Error --> Call to undefined function avg() /home/ssc/metalsindo_dev/application/modules/master_lme/views/index.php 97
ERROR - 2020-08-28 09:57:58 --> Severity: Warning --> Missing argument 2 for CI_DB_query_builder::join(), called in /home/ssc/metalsindo_dev/application/modules/master_lme/models/Lme_model.php on line 170 and defined /home/ssc/metalsindo_dev/system/database/DB_query_builder.php 512
ERROR - 2020-08-28 09:57:58 --> Severity: Warning --> Missing argument 2 for CI_DB_query_builder::join(), called in /home/ssc/metalsindo_dev/application/modules/master_lme/models/Lme_model.php on line 171 and defined /home/ssc/metalsindo_dev/system/database/DB_query_builder.php 512
ERROR - 2020-08-28 09:57:58 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '','a.id_compotition=c.id_compotition USING ()
JOIN (select avg(nominal)as nomina' at line 4 - Invalid query: SELECT `a`.*, `b`.`nominal` as `nominal_harga`, `c`.`nominal` as `nominal10`, `d`.`nominal` as `nominal30`
FROM `ms_compotition` `a`
JOIN `child_history_lme` `b` ON `b`.`id_compotition`=`a`.`id_compotition`
JOIN (select avg(nominal)as nominal ,id_compotition from child_history_lme group by id_compotition) c','a.id_compotition=c.id_compotition USING ()
JOIN (select avg(nominal)as nominal ,id_compotition from child_history_lme group by id_compotition) d','a.id_compotition=d.id_compotition USING ()
WHERE `a`.`deleted` = '0' and `b`.`status` = '0'
ERROR - 2020-08-28 10:01:37 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'create ,id_compotition from child_history_lme group by id_compotition) c ON `a`.' at line 4 - Invalid query: SELECT `a`.*, `b`.`nominal` as `nominal_harga`, `c`.`desimal` as `nominal10`, `d`.`nominal` as `nominal30`
FROM `ms_compotition` `a`
JOIN `child_history_lme` `b` ON `b`.`id_compotition`=`a`.`id_compotition`
JOIN (select avg(nominal)as nominal, created_on as create ,id_compotition from child_history_lme group by id_compotition) c ON `a`.`id_compotition`=`c`.`id_compotition`
JOIN (select avg(nominal)as nominal, created_on as create ,id_compotition from child_history_lme group by id_compotition) d ON `a`.`id_compotition`=`d`.`id_compotition`
WHERE `a`.`deleted` = '0' and `b`.`status` = '0' and c.create between'2020-08-18 00:00:00' and '2020-08-28 10:01:37' 
ERROR - 2020-08-28 10:02:25 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'create ,id_compotition from child_history_lme group by id_compotition) c ON `a`.' at line 4 - Invalid query: SELECT `a`.*, `b`.`nominal` as `nominal_harga`, `c`.`desimal` as `nominal10`, `d`.`nominal` as `nominal30`
FROM `ms_compotition` `a`
JOIN `child_history_lme` `b` ON `b`.`id_compotition`=`a`.`id_compotition`
JOIN (select avg(nominal)as nominal, created_on as create ,id_compotition from child_history_lme group by id_compotition) c ON `a`.`id_compotition`=`c`.`id_compotition`
JOIN (select avg(nominal)as nominal, created_on as create ,id_compotition from child_history_lme group by id_compotition) d ON `a`.`id_compotition`=`d`.`id_compotition`
WHERE `a`.`deleted` = '0' and `b`.`status` = '0' and `c`.`create` between '2020-08-18 00:00:00' and '2020-08-28 10:02:25' 
ERROR - 2020-08-28 10:03:26 --> Query error: Unknown column 'c.desimal' in 'field list' - Invalid query: SELECT `a`.*, `b`.`nominal` as `nominal_harga`, `c`.`desimal` as `nominal10`, `d`.`nominal` as `nominal30`
FROM `ms_compotition` `a`
JOIN `child_history_lme` `b` ON `b`.`id_compotition`=`a`.`id_compotition`
JOIN (select avg(nominal)as nominal, created_on as created_on ,id_compotition from child_history_lme group by id_compotition) c ON `a`.`id_compotition`=`c`.`id_compotition`
JOIN (select avg(nominal)as nominal, created_on as created_on ,id_compotition from child_history_lme group by id_compotition) d ON `a`.`id_compotition`=`d`.`id_compotition`
WHERE `a`.`deleted` = '0' and `b`.`status` = '0' and `c`.`created_on` between '2020-08-18 00:00:00' and '2020-08-28 10:03:26' 
ERROR - 2020-08-28 10:05:22 --> Query error: Unknown column 'c.desimal' in 'field list' - Invalid query: SELECT `a`.*, `b`.`nominal` as `nominal_harga`, `c`.`desimal` as `nominal10`, `d`.`nominal` as `nominal30`
FROM `ms_compotition` `a`
JOIN `child_history_lme` `b` ON `b`.`id_compotition`=`a`.`id_compotition`
JOIN (select avg(nominal)as nominal ,id_compotition from child_history_lme group by id_compotition) c ON `a`.`id_compotition`=`c`.`id_compotition`
JOIN (select avg(nominal)as nominal,id_compotition from child_history_lme group by id_compotition) d ON `a`.`id_compotition`=`d`.`id_compotition`
WHERE `a`.`deleted` = '0' and `b`.`status` = '0' and `c`.`created_on` between '2020-08-18 00:00:00' and '2020-08-28 10:05:22' 
ERROR - 2020-08-28 10:39:42 --> Severity: Warning --> trim() expects parameter 1 to be string, array given /home/ssc/metalsindo_dev/system/database/DB_query_builder.php 399
ERROR - 2020-08-28 10:39:42 --> Severity: Error --> Call to undefined method CI_DB_mysqli_driver::result() /home/ssc/metalsindo_dev/application/modules/master_lme/views/index.php 103
ERROR - 2020-08-28 10:50:46 --> 404 Page Not Found: ../modules/master_suplier/controllers/Master_suplier/viewLokal
ERROR - 2020-08-28 11:13:25 --> 404 Page Not Found: ../modules/master_rate/controllers/Master_rate/deleteType
ERROR - 2020-08-28 11:16:37 --> Severity: Parsing Error --> syntax error, unexpected ';', expecting ')' /home/ssc/metalsindo_dev/application/modules/transaksi_inquiry/controllers/Transaksi_inquiry.php 453
ERROR - 2020-08-28 11:18:28 --> Severity: Parsing Error --> syntax error, unexpected ';', expecting ')' /home/ssc/metalsindo_dev/application/modules/transaksi_inquiry/controllers/Transaksi_inquiry.php 453
ERROR - 2020-08-28 17:11:14 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-08-28 17:11:20 --> 404 Page Not Found: /index
ERROR - 2020-08-28 18:47:59 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-08-28 18:48:27 --> 404 Page Not Found: /index
