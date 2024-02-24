<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-07-30 15:02:54 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-07-30 15:02:58 --> 404 Page Not Found: /index
ERROR - 2020-07-30 15:05:39 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-07-30 15:05:43 --> 404 Page Not Found: /index
ERROR - 2020-07-30 20:24:46 --> Query error: Table 'metalsindo_db.ci_sessions' doesn't exist - Invalid query: SELECT `data`
FROM `ci_sessions`
WHERE `id` = 'c8d77f06ee7ab5833520af4f62caf89b7069c426'
ERROR - 2020-07-30 20:34:26 --> Query error: Table 'metalsindo_db.ci_sessions' doesn't exist - Invalid query: SELECT `data`
FROM `ci_sessions`
WHERE `id` = '1711cf7a46fc9d72e1cec7c87b908a11dd523652'
ERROR - 2020-07-30 21:32:03 --> Severity: Notice --> Use of undefined constant php - assumed 'php' /home/ssc/metalsindo_dev/application/modules/users/views/login_animate.php 6
ERROR - 2020-07-30 21:32:08 --> 404 Page Not Found: /index
ERROR - 2020-07-30 21:46:49 --> Severity: Notice --> Undefined variable: datgroupmenu /home/ssc/metalsindo_dev/application/modules/menus/views/menus_form.php 70
ERROR - 2020-07-30 21:48:07 --> Severity: Notice --> Undefined variable: datgroupmenu /home/ssc/metalsindo_dev/application/modules/menus/views/menus_form.php 70
ERROR - 2020-07-30 21:49:05 --> Severity: Notice --> Undefined variable: datgroupmenu /home/ssc/metalsindo_dev/application/modules/menus/views/menus_form.php 70
ERROR - 2020-07-30 21:49:35 --> Severity: Notice --> Undefined variable: datgroupmenu /home/ssc/metalsindo_dev/application/modules/menus/views/menus_form.php 70
ERROR - 2020-07-30 21:49:58 --> Severity: Notice --> Undefined variable: datgroupmenu /home/ssc/metalsindo_dev/application/modules/menus/views/menus_form.php 70
ERROR - 2020-07-30 21:50:28 --> Severity: Notice --> Undefined variable: datgroupmenu /home/ssc/metalsindo_dev/application/modules/menus/views/menus_form.php 70
ERROR - 2020-07-30 21:50:56 --> Severity: Notice --> Undefined variable: datgroupmenu /home/ssc/metalsindo_dev/application/modules/menus/views/menus_form.php 70
ERROR - 2020-07-30 21:51:14 --> Severity: Notice --> Undefined variable: datgroupmenu /home/ssc/metalsindo_dev/application/modules/menus/views/menus_form.php 70
ERROR - 2020-07-30 21:51:34 --> Severity: Notice --> Undefined variable: datgroupmenu /home/ssc/metalsindo_dev/application/modules/menus/views/menus_form.php 70
ERROR - 2020-07-30 21:52:10 --> Severity: Notice --> Undefined variable: datgroupmenu /home/ssc/metalsindo_dev/application/modules/menus/views/menus_form.php 70
ERROR - 2020-07-30 21:52:25 --> Severity: Notice --> Undefined variable: datgroupmenu /home/ssc/metalsindo_dev/application/modules/menus/views/menus_form.php 70
ERROR - 2020-07-30 21:53:28 --> Severity: error --> Exception: Unable to locate the model you have specified: Master_model /home/ssc/metalsindo_dev/system/core/Loader.php 344
ERROR - 2020-07-30 22:26:38 --> Query error: Expression #2 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'metalsindo_db.asset_generate.category' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT
				SUM(a.nilai_asset) AS total_aset,
				SUM(a.`value`) AS total_susut,
				SUM(b.sisa_nilai) AS total_sisa
			FROM
				asset a LEFT JOIN asset_nilai b ON a.kd_asset = b.kd_asset 
			WHERE 1=1
				AND a.deleted = 'N' 
				
				
				AND (
				a.nm_asset LIKE '%%'
				OR a.category LIKE '%%'
	        )
