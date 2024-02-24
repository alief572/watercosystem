<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2018-09-10 08:29:27 --> Severity: Notice --> Undefined variable: nama_program /home/www/importa/application/modules/users/views/login_animate.php 6
ERROR - 2018-09-10 08:41:40 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/karyawan/views/karyawan_form.php 126
ERROR - 2018-09-10 08:46:39 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/barang/views/barang_form.php 41
ERROR - 2018-09-10 08:46:39 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/barang/views/barang_form.php 60
ERROR - 2018-09-10 08:46:39 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/barang/views/barang_form.php 122
ERROR - 2018-09-10 08:46:39 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/barang/views/barang_form.php 255
ERROR - 2018-09-10 08:46:39 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/barang/views/barang_form.php 379
ERROR - 2018-09-10 09:14:43 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/barang/views/barang_form.php 41
ERROR - 2018-09-10 09:14:43 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/barang/views/barang_form.php 60
ERROR - 2018-09-10 09:14:43 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/barang/views/barang_form.php 122
ERROR - 2018-09-10 09:14:43 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/barang/views/barang_form.php 255
ERROR - 2018-09-10 09:14:43 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/barang/views/barang_form.php 379
ERROR - 2018-09-10 09:18:03 --> Severity: Notice --> Undefined variable: datkota /home/www/importa/application/modules/cabang/views/cabang_form.php 82
ERROR - 2018-09-10 09:18:03 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/cabang/views/cabang_form.php 82
ERROR - 2018-09-10 09:21:31 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/barang/views/barang_form.php 41
ERROR - 2018-09-10 09:21:31 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/barang/views/barang_form.php 60
ERROR - 2018-09-10 09:21:31 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/barang/views/barang_form.php 122
ERROR - 2018-09-10 09:21:31 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/barang/views/barang_form.php 255
ERROR - 2018-09-10 09:21:31 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/barang/views/barang_form.php 379
ERROR - 2018-09-10 09:59:50 --> Severity: Notice --> Undefined variable: nama_program /home/www/importa/application/modules/users/views/login_animate.php 6
ERROR - 2018-09-10 10:40:12 --> Severity: Parsing Error --> syntax error, unexpected ''Aktifitas/aktifitas_model'' (T_CONSTANT_ENCAPSED_STRING), expecting ')' /home/www/importa/application/modules/purchaseorder/controllers/Purchaseorder.php 31
ERROR - 2018-09-10 13:02:06 --> Severity: Notice --> Undefined variable: nama_program /home/www/importa/application/modules/users/views/login_animate.php 6
ERROR - 2018-09-10 13:03:30 --> Query error: Table 'importa_sys.tb_coba_ss' doesn't exist - Invalid query: SELECT id,coba FROM tb_coba_ss WHERE 1=1 
ERROR - 2018-09-10 13:12:04 --> Severity: Error --> Call to undefined function clean_data() /home/www/importa/application/modules/kurs/views/ajax/ajaxgetcoba.php 9
ERROR - 2018-09-10 13:12:37 --> Severity: Error --> Call to undefined function clean_data() /home/www/importa/application/modules/kurs/views/ajax/ajaxgetcoba.php 9
ERROR - 2018-09-10 13:12:44 --> Severity: Error --> Call to undefined function clean_data() /home/www/importa/application/modules/kurs/views/ajax/ajaxgetcoba.php 9
ERROR - 2018-09-10 13:12:53 --> Severity: Notice --> Undefined variable: nama_program /home/www/importa/application/modules/users/views/login_animate.php 6
ERROR - 2018-09-10 13:18:54 --> Severity: Notice --> Undefined variable: nama_program /home/www/importa/application/modules/users/views/login_animate.php 6
ERROR - 2018-09-10 13:19:17 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/po_form.php 8
ERROR - 2018-09-10 13:19:34 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/po_form.php 8
ERROR - 2018-09-10 13:19:45 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/po_form.php 8
ERROR - 2018-09-10 13:20:48 --> Query error: Column 'no_pr' in where clause is ambiguous - Invalid query: SELECT *
FROM `trans_pr_header`
LEFT JOIN `cabang` ON `trans_pr_header`.`kdcab` = `cabang`.`kdcab`
WHERE `no_pr` IN('101-PR-18I00004', '101-PR-18I00006')
ERROR - 2018-09-10 13:21:51 --> Severity: Error --> Call to undefined method Detailpurchaserequest_model::get_where_in_and() /home/www/importa/application/modules/purchaseorder/controllers/Purchaseorder.php 83
ERROR - 2018-09-10 13:23:21 --> Query error: Unknown column 'proses_po' in 'where clause' - Invalid query: SELECT *
FROM `trans_pr_detail`
LEFT JOIN `barang_master` ON `trans_pr_detail`.`id_barang` = `barang_master`.`id_barang`
WHERE `trans_pr_detail`.`no_pr` IN('101-PR-18I00004', '101-PR-18I00006')
AND  `proses_po` IS NULL
ERROR - 2018-09-10 13:25:03 --> Severity: Error --> Call to a member function pilih_driver() on null /home/www/importa/application/modules/purchaseorder/controllers/Purchaseorder.php 84
ERROR - 2018-09-10 13:25:27 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 59
ERROR - 2018-09-10 13:25:27 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 75
ERROR - 2018-09-10 13:26:23 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 59
ERROR - 2018-09-10 13:26:23 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 75
ERROR - 2018-09-10 13:26:51 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 59
ERROR - 2018-09-10 13:26:51 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 75
ERROR - 2018-09-10 13:27:12 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 59
ERROR - 2018-09-10 13:27:12 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 75
ERROR - 2018-09-10 13:35:44 --> Query error: Column 'no_pr' in where clause is ambiguous - Invalid query: SELECT *
FROM `trans_pr_header`
LEFT JOIN `cabang` ON `trans_pr_header`.`kdcab` = `cabang`.`kdcab`
WHERE `no_pr` IN('101-PR-18I00004', '101-PR-18I00006')
ERROR - 2018-09-10 13:39:23 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 59
ERROR - 2018-09-10 13:39:23 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 75
ERROR - 2018-09-10 13:40:24 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 59
ERROR - 2018-09-10 13:40:24 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 75
ERROR - 2018-09-10 13:42:12 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 59
ERROR - 2018-09-10 13:42:12 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 75
ERROR - 2018-09-10 13:45:48 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 59
ERROR - 2018-09-10 13:45:48 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 75
ERROR - 2018-09-10 13:46:06 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 59
ERROR - 2018-09-10 13:46:06 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 75
ERROR - 2018-09-10 13:47:08 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 59
ERROR - 2018-09-10 13:47:08 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 75
ERROR - 2018-09-10 13:47:15 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 59
ERROR - 2018-09-10 13:47:15 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 75
ERROR - 2018-09-10 13:47:53 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 59
ERROR - 2018-09-10 13:47:53 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 75
ERROR - 2018-09-10 13:48:19 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 59
ERROR - 2018-09-10 13:48:19 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 75
ERROR - 2018-09-10 13:48:45 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 59
ERROR - 2018-09-10 13:48:45 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 75
ERROR - 2018-09-10 13:49:44 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 59
ERROR - 2018-09-10 13:49:44 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 75
ERROR - 2018-09-10 13:50:05 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 59
ERROR - 2018-09-10 13:50:05 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 75
ERROR - 2018-09-10 13:50:27 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 59
ERROR - 2018-09-10 13:50:27 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 75
ERROR - 2018-09-10 13:52:01 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 59
ERROR - 2018-09-10 13:52:01 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 75
ERROR - 2018-09-10 13:52:55 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 59
ERROR - 2018-09-10 13:52:55 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 75
ERROR - 2018-09-10 13:53:02 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 59
ERROR - 2018-09-10 13:53:02 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 75
ERROR - 2018-09-10 13:53:13 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 59
ERROR - 2018-09-10 13:53:13 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 75
ERROR - 2018-09-10 13:56:32 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 69
ERROR - 2018-09-10 13:56:32 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 85
ERROR - 2018-09-10 14:24:50 --> Severity: Notice --> Undefined variable: nama_program /home/www/importa/application/modules/users/views/login_animate.php 6
ERROR - 2018-09-10 14:25:35 --> Severity: Notice --> Undefined variable: nama_program /home/www/importa/application/modules/users/views/login_animate.php 6
ERROR - 2018-09-10 14:27:15 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 77
ERROR - 2018-09-10 14:27:15 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 93
ERROR - 2018-09-10 14:28:54 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 87
ERROR - 2018-09-10 14:28:54 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 103
ERROR - 2018-09-10 14:29:03 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 87
ERROR - 2018-09-10 14:29:03 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 103
ERROR - 2018-09-10 14:29:28 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 87
ERROR - 2018-09-10 14:29:28 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 103
ERROR - 2018-09-10 14:29:35 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 87
ERROR - 2018-09-10 14:29:35 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 103
ERROR - 2018-09-10 14:29:50 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 87
ERROR - 2018-09-10 14:29:50 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 103
ERROR - 2018-09-10 14:30:04 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 87
ERROR - 2018-09-10 14:30:04 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 103
ERROR - 2018-09-10 14:30:21 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 87
ERROR - 2018-09-10 14:30:21 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 103
ERROR - 2018-09-10 14:30:28 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 87
ERROR - 2018-09-10 14:30:28 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 103
ERROR - 2018-09-10 14:30:39 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 87
ERROR - 2018-09-10 14:30:39 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 103
ERROR - 2018-09-10 14:31:51 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 87
ERROR - 2018-09-10 14:31:51 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 103
ERROR - 2018-09-10 14:33:02 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 87
ERROR - 2018-09-10 14:33:02 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 103
ERROR - 2018-09-10 14:33:17 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 87
ERROR - 2018-09-10 14:33:17 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 103
ERROR - 2018-09-10 14:33:46 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 87
ERROR - 2018-09-10 14:33:46 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 103
ERROR - 2018-09-10 14:34:04 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 87
ERROR - 2018-09-10 14:34:04 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 103
ERROR - 2018-09-10 14:34:08 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 87
ERROR - 2018-09-10 14:34:08 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 103
ERROR - 2018-09-10 14:34:20 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 87
ERROR - 2018-09-10 14:34:20 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 103
ERROR - 2018-09-10 14:34:33 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 87
ERROR - 2018-09-10 14:34:33 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 103
ERROR - 2018-09-10 14:34:39 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 87
ERROR - 2018-09-10 14:34:39 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 103
ERROR - 2018-09-10 14:34:52 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 87
ERROR - 2018-09-10 14:34:52 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 103
ERROR - 2018-09-10 14:35:15 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 87
ERROR - 2018-09-10 14:35:15 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 103
ERROR - 2018-09-10 14:35:25 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 87
ERROR - 2018-09-10 14:35:25 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 103
ERROR - 2018-09-10 14:35:51 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 87
ERROR - 2018-09-10 14:35:51 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 103
ERROR - 2018-09-10 14:36:02 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 87
ERROR - 2018-09-10 14:36:02 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 103
ERROR - 2018-09-10 14:58:32 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 87
ERROR - 2018-09-10 14:58:32 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 103
ERROR - 2018-09-10 15:57:39 --> Severity: Error --> Call to a member function find_by() on null /home/www/importa/application/modules/purchaseorder/controllers/Purchaseorder.php 204
ERROR - 2018-09-10 15:59:07 --> Severity: Notice --> Undefined variable: nama_program /home/www/importa/application/modules/users/views/login_animate.php 6
ERROR - 2018-09-10 16:00:42 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 87
ERROR - 2018-09-10 16:00:42 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 103
ERROR - 2018-09-10 16:00:54 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 87
ERROR - 2018-09-10 16:00:54 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 103
ERROR - 2018-09-10 16:01:31 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 87
ERROR - 2018-09-10 16:01:31 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 103
ERROR - 2018-09-10 16:02:12 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 87
ERROR - 2018-09-10 16:02:12 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 103
ERROR - 2018-09-10 16:02:18 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 87
ERROR - 2018-09-10 16:02:18 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 103
ERROR - 2018-09-10 16:02:33 --> 404 Page Not Found: ../modules/salesorder/controllers/Salesorder/index
ERROR - 2018-09-10 16:04:22 --> Query error: Table 'importa_sys.trans_so_detail_pending' doesn't exist - Invalid query: UPDATE `trans_so_detail_pending` SET `proses_do` = 1, `qty_confirm` = NULL
WHERE `no_so` = '101-SO-18I00016'
AND `id_barang` = 'HEBCCN001002'
ERROR - 2018-09-10 16:05:23 --> Query error: Table 'importa_sys.trans_so_detail_pending' doesn't exist - Invalid query: UPDATE `trans_so_detail_pending` SET `proses_do` = 1, `qty_confirm` = NULL
WHERE `no_so` = '101-SO-18I00016'
AND `id_barang` = 'HEBCCN001002'
ERROR - 2018-09-10 16:06:17 --> Query error: Table 'importa_sys.trans_so_detail_pending' doesn't exist - Invalid query: UPDATE `trans_so_detail_pending` SET `proses_do` = 1, `qty_confirm` = NULL
WHERE `no_so` = '101-SO-18I00016'
AND `id_barang` = 'HEBCCN001002'
ERROR - 2018-09-10 16:07:59 --> Severity: Error --> Call to a member function find_by() on null /home/www/importa/application/modules/purchaseorder/controllers/Purchaseorder.php 204
ERROR - 2018-09-10 16:08:04 --> Severity: Error --> Call to a member function find_by() on null /home/www/importa/application/modules/purchaseorder/controllers/Purchaseorder.php 204
ERROR - 2018-09-10 16:08:11 --> Severity: Error --> Call to a member function find_by() on null /home/www/importa/application/modules/purchaseorder/controllers/Purchaseorder.php 204
ERROR - 2018-09-10 16:08:45 --> Severity: Error --> Call to a member function find_by() on null /home/www/importa/application/modules/purchaseorder/controllers/Purchaseorder.php 204
ERROR - 2018-09-10 16:09:56 --> Severity: Error --> Call to a member function find_by() on null /home/www/importa/application/modules/purchaseorder/controllers/Purchaseorder.php 204
ERROR - 2018-09-10 16:10:08 --> Severity: Error --> Call to a member function find_by() on null /home/www/importa/application/modules/purchaseorder/controllers/Purchaseorder.php 204
ERROR - 2018-09-10 16:10:13 --> Severity: Error --> Call to a member function find_by() on null /home/www/importa/application/modules/purchaseorder/controllers/Purchaseorder.php 204
ERROR - 2018-09-10 16:11:12 --> Severity: Error --> Call to a member function find_by() on null /home/www/importa/application/modules/purchaseorder/controllers/Purchaseorder.php 204
ERROR - 2018-09-10 16:12:45 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 87
ERROR - 2018-09-10 16:12:45 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 103
ERROR - 2018-09-10 16:12:48 --> Severity: Error --> Call to a member function find_by() on null /home/www/importa/application/modules/purchaseorder/controllers/Purchaseorder.php 204
ERROR - 2018-09-10 16:12:58 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 87
ERROR - 2018-09-10 16:12:58 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 103
ERROR - 2018-09-10 16:13:01 --> Severity: Error --> Call to a member function find_by() on null /home/www/importa/application/modules/purchaseorder/controllers/Purchaseorder.php 204
ERROR - 2018-09-10 16:13:10 --> Severity: Error --> Call to a member function find_by() on null /home/www/importa/application/modules/purchaseorder/controllers/Purchaseorder.php 204
ERROR - 2018-09-10 16:13:42 --> 404 Page Not Found: ../modules/purchaseorder/controllers/Purchaseorder/saveheaderpo
ERROR - 2018-09-10 16:13:49 --> Severity: Error --> Call to a member function find_by() on null /home/www/importa/application/modules/purchaseorder/controllers/Purchaseorder.php 204
ERROR - 2018-09-10 16:14:34 --> 404 Page Not Found: ../modules/deliveryorder/controllers/Deliveryorder/saveheaderpo
ERROR - 2018-09-10 16:14:40 --> 404 Page Not Found: ../modules/deliveryorder/controllers/Deliveryorder/saveheaderpo
ERROR - 2018-09-10 16:14:44 --> Severity: Notice --> Undefined variable: nama_program /home/www/importa/application/modules/users/views/login_animate.php 6
ERROR - 2018-09-10 16:15:17 --> Severity: Error --> Call to a member function find_by() on null /home/www/importa/application/modules/purchaseorder/controllers/Purchaseorder.php 204
ERROR - 2018-09-10 16:15:28 --> Severity: Error --> Call to a member function find_by() on null /home/www/importa/application/modules/purchaseorder/controllers/Purchaseorder.php 204
ERROR - 2018-09-10 16:15:35 --> Severity: Error --> Call to a member function find_by() on null /home/www/importa/application/modules/purchaseorder/controllers/Purchaseorder.php 204
ERROR - 2018-09-10 16:15:49 --> Severity: Error --> Call to a member function find_by() on null /home/www/importa/application/modules/purchaseorder/controllers/Purchaseorder.php 204
ERROR - 2018-09-10 16:16:27 --> Query error: Table 'importa_sys.trans_so_detail_pending' doesn't exist - Invalid query: UPDATE `trans_so_detail_pending` SET `proses_do` = 1, `qty_confirm` = NULL
WHERE `no_so` = '101-SO-18I00016'
AND `id_barang` = 'HEBCCN001002'
ERROR - 2018-09-10 16:21:49 --> Severity: Error --> Call to a member function find_by() on null /home/www/importa/application/modules/purchaseorder/controllers/Purchaseorder.php 204
ERROR - 2018-09-10 16:22:03 --> Severity: Error --> Call to a member function find_by() on null /home/www/importa/application/modules/purchaseorder/controllers/Purchaseorder.php 204
ERROR - 2018-09-10 16:38:40 --> Severity: Error --> Call to a member function find_by() on null /home/www/importa/application/modules/purchaseorder/controllers/Purchaseorder.php 204
ERROR - 2018-09-10 16:45:04 --> Severity: Error --> Call to a member function find_by() on null /home/www/importa/application/modules/purchaseorder/controllers/Purchaseorder.php 204
ERROR - 2018-09-10 16:54:15 --> Severity: Error --> Call to a member function find_by() on null /home/www/importa/application/modules/purchaseorder/controllers/Purchaseorder.php 204
ERROR - 2018-09-10 16:54:36 --> 404 Page Not Found: /index
ERROR - 2018-09-10 16:54:44 --> 404 Page Not Found: /index
ERROR - 2018-09-10 16:56:31 --> 404 Page Not Found: /index
ERROR - 2018-09-10 16:56:41 --> 404 Page Not Found: /index
ERROR - 2018-09-10 17:02:19 --> Severity: Notice --> Undefined variable: nama_program /home/www/importa/application/modules/users/views/login_animate.php 6
ERROR - 2018-09-10 17:03:15 --> Severity: Error --> Call to a member function find_by() on null /home/www/importa/application/modules/purchaseorder/controllers/Purchaseorder.php 204
ERROR - 2018-09-10 17:04:31 --> Severity: Error --> Call to a member function find_by() on null /home/www/importa/application/modules/purchaseorder/controllers/Purchaseorder.php 204
ERROR - 2018-09-10 17:08:44 --> Severity: Error --> Call to a member function find_by() on null /home/www/importa/application/modules/purchaseorder/controllers/Purchaseorder.php 204
ERROR - 2018-09-10 17:11:01 --> Severity: Error --> Call to a member function find_by() on null /home/www/importa/application/modules/purchaseorder/controllers/Purchaseorder.php 204
ERROR - 2018-09-10 17:12:40 --> Severity: Error --> Call to a member function find_by() on null /home/www/importa/application/modules/purchaseorder/controllers/Purchaseorder.php 204
ERROR - 2018-09-10 17:12:41 --> Severity: Error --> Call to a member function find_by() on null /home/www/importa/application/modules/purchaseorder/controllers/Purchaseorder.php 204
ERROR - 2018-09-10 17:12:42 --> Severity: Error --> Call to a member function find_by() on null /home/www/importa/application/modules/purchaseorder/controllers/Purchaseorder.php 204
ERROR - 2018-09-10 17:12:42 --> Severity: Error --> Call to a member function find_by() on null /home/www/importa/application/modules/purchaseorder/controllers/Purchaseorder.php 204
ERROR - 2018-09-10 17:12:42 --> Severity: Error --> Call to a member function find_by() on null /home/www/importa/application/modules/purchaseorder/controllers/Purchaseorder.php 204
ERROR - 2018-09-10 17:12:43 --> Severity: Error --> Call to a member function find_by() on null /home/www/importa/application/modules/purchaseorder/controllers/Purchaseorder.php 204
ERROR - 2018-09-10 17:12:43 --> Severity: Error --> Call to a member function find_by() on null /home/www/importa/application/modules/purchaseorder/controllers/Purchaseorder.php 204
ERROR - 2018-09-10 17:12:43 --> Severity: Error --> Call to a member function find_by() on null /home/www/importa/application/modules/purchaseorder/controllers/Purchaseorder.php 204
ERROR - 2018-09-10 17:12:44 --> Severity: Error --> Call to a member function find_by() on null /home/www/importa/application/modules/purchaseorder/controllers/Purchaseorder.php 204
ERROR - 2018-09-10 17:12:44 --> Severity: Error --> Call to a member function find_by() on null /home/www/importa/application/modules/purchaseorder/controllers/Purchaseorder.php 204
ERROR - 2018-09-10 17:12:44 --> Severity: Error --> Call to a member function find_by() on null /home/www/importa/application/modules/purchaseorder/controllers/Purchaseorder.php 204
ERROR - 2018-09-10 17:14:02 --> Severity: Error --> Call to a member function find_by() on null /home/www/importa/application/modules/purchaseorder/controllers/Purchaseorder.php 204
ERROR - 2018-09-10 17:14:37 --> Severity: Error --> Call to a member function find_by() on null /home/www/importa/application/modules/purchaseorder/controllers/Purchaseorder.php 204
ERROR - 2018-09-10 17:15:18 --> Severity: Error --> Call to a member function find_by() on null /home/www/importa/application/modules/purchaseorder/controllers/Purchaseorder.php 204
ERROR - 2018-09-10 17:16:33 --> Severity: Notice --> Undefined variable: nama_program /home/www/importa/application/modules/users/views/login_animate.php 6
ERROR - 2018-09-10 17:18:18 --> Query error: Unknown column 'kdcab' in 'field list' - Invalid query: INSERT INTO `trans_po_header` (`no_po`, `kdcab`, `id_supplier`, `nm_supplier`, `tgl_po`, `plan_delivery_date`, `real_delivery_date`, `created_on`, `created_by`) VALUES ('101-PO-18I00008', '103', 'CN001', 'XKODE MACHINA', '2018-09-10', '2018-09-05', '2018-09-16', '2018-09-10 17:18:18', '1')
ERROR - 2018-09-10 17:25:28 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 59
ERROR - 2018-09-10 17:25:28 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 75
ERROR - 2018-09-10 17:30:05 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 59
ERROR - 2018-09-10 17:30:05 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 75
ERROR - 2018-09-10 17:32:14 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 59
ERROR - 2018-09-10 17:32:14 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 75
ERROR - 2018-09-10 17:32:22 --> Severity: Error --> Call to a member function find_by() on null /home/www/importa/application/modules/purchaseorder/controllers/Purchaseorder.php 204
ERROR - 2018-09-10 17:33:59 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 59
ERROR - 2018-09-10 17:33:59 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 75
ERROR - 2018-09-10 17:34:01 --> Severity: Error --> Call to a member function find_by() on null /home/www/importa/application/modules/purchaseorder/controllers/Purchaseorder.php 204
ERROR - 2018-09-10 17:47:56 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 59
ERROR - 2018-09-10 17:47:56 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 75
ERROR - 2018-09-10 17:47:59 --> Query error: Unknown column 'no_pr' in 'field list' - Invalid query: INSERT INTO `trans_po_detail` (`no_po`, `no_pr`, `id_barang`, `nm_barang`, `satuan`, `qty_order`, `qty_supply`) VALUES ('101-PO-18I00008', '101-PR-18I00005', 'HEBCCN001002', 'WY115 BLACK BAR CHAIR', 'PCS', '1', '1')
ERROR - 2018-09-10 17:48:36 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 59
ERROR - 2018-09-10 17:48:36 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 75
ERROR - 2018-09-10 17:49:07 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 59
ERROR - 2018-09-10 17:49:07 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 75
ERROR - 2018-09-10 17:49:34 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 59
ERROR - 2018-09-10 17:49:34 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 75
ERROR - 2018-09-10 17:50:19 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 59
ERROR - 2018-09-10 17:50:19 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 75
ERROR - 2018-09-10 17:50:31 --> Query error: Unknown column 'no_pr' in 'field list' - Invalid query: INSERT INTO `trans_po_detail` (`no_po`, `no_pr`, `id_barang`, `nm_barang`, `satuan`, `qty_order`, `qty_supply`) VALUES ('101-PO-18I00008', '101-PR-18I00006', 'HEBCCN001001', 'WY115 BLACK BAR CHAIR', 'SET', '3', '3')
ERROR - 2018-09-10 17:50:48 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 59
ERROR - 2018-09-10 17:50:48 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 75
ERROR - 2018-09-10 17:51:31 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 59
ERROR - 2018-09-10 17:51:31 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 75
ERROR - 2018-09-10 17:51:49 --> Severity: Notice --> Undefined variable: nama_program /home/www/importa/application/modules/users/views/login_animate.php 6
ERROR - 2018-09-10 17:51:52 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 59
ERROR - 2018-09-10 17:51:52 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 75
ERROR - 2018-09-10 17:52:10 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 59
ERROR - 2018-09-10 17:52:10 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 75
ERROR - 2018-09-10 17:52:25 --> Query error: Unknown column 'no_pr' in 'field list' - Invalid query: INSERT INTO `trans_po_detail` (`no_po`, `no_pr`, `id_barang`, `nm_barang`, `satuan`, `qty_order`, `qty_supply`) VALUES ('101-PO-18I00008', '101-PR-18I00006', 'HEBCCN001001', 'WY115 BLACK BAR CHAIR', 'SET', '3', '3')
ERROR - 2018-09-10 17:52:29 --> Query error: Unknown column 'no_pr' in 'field list' - Invalid query: INSERT INTO `trans_po_detail` (`no_po`, `no_pr`, `id_barang`, `nm_barang`, `satuan`, `qty_order`, `qty_supply`) VALUES ('101-PO-18I00008', '101-PR-18I00006', 'HEBCCN001001', 'WY115 BLACK BAR CHAIR', 'SET', '3', '3')
