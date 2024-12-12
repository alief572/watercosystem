<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2021-03-29 08:33:29 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2021-03-29 08:33:29 --> 404 Page Not Found: /index
ERROR - 2021-03-29 09:23:09 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2021-03-29 09:23:09 --> 404 Page Not Found: /index
ERROR - 2021-03-29 09:23:13 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2021-03-29 09:23:14 --> 404 Page Not Found: /index
ERROR - 2021-03-29 09:58:11 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2021-03-29 09:58:17 --> 404 Page Not Found: /index
ERROR - 2021-03-29 10:01:13 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2021-03-29 10:01:14 --> 404 Page Not Found: /index
ERROR - 2021-03-29 10:55:40 --> Query error: Table 'metalsindo_db.ms_compotitionx' doesn't exist - Invalid query: SELECT `a`.*, `b`.`nominal` as `nominal_harga`
FROM `ms_compotitionx` `a`
JOIN `child_history_lme` `b` ON `b`.`id_compotition`=`a`.`id_compotition`
WHERE `a`.`deleted` = '0' and `a`.`id_category1` = 'I2000002' and `b`.`status` = '0'
