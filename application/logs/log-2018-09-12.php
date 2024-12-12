<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2018-09-12 08:22:21 --> Severity: Notice --> Undefined variable: nama_program /home/www/importa/application/modules/users/views/login_animate.php 6
ERROR - 2018-09-12 08:22:28 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 59
ERROR - 2018-09-12 08:22:28 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 75
ERROR - 2018-09-12 08:23:13 --> Query error: Unknown column 'no_pr' in 'field list' - Invalid query: INSERT INTO `trans_po_detail` (`no_po`, `no_pr`, `id_barang`, `nm_barang`, `satuan`, `qty_order`, `qty_supply`) VALUES ('101-PO-18I00008', '101-PR-18I00006', 'HEBCCN001001', 'WY115 BLACK BAR CHAIR', 'SET', '3', '3')
ERROR - 2018-09-12 08:27:44 --> Query error: Unknown column 'no_pr' in 'field list' - Invalid query: INSERT INTO `trans_po_detail` (`no_po`, `no_pr`, `id_barang`, `nm_barang`, `satuan`, `qty_order`, `qty_supply`) VALUES ('101-PO-18I00008', '101-PR-18I00006', 'HEBCCN001001', 'WY115 BLACK BAR CHAIR', 'SET', '3', '3')
ERROR - 2018-09-12 08:27:49 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 59
ERROR - 2018-09-12 08:27:49 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 75
ERROR - 2018-09-12 08:28:06 --> Query error: Unknown column 'no_pr' in 'field list' - Invalid query: INSERT INTO `trans_po_detail` (`no_po`, `no_pr`, `id_barang`, `nm_barang`, `satuan`, `qty_order`, `qty_supply`) VALUES ('101-PO-18I00008', '101-PR-18I00006', 'HEBCCN001001', 'WY115 BLACK BAR CHAIR', 'SET', '3', '3')
ERROR - 2018-09-12 08:47:47 --> Severity: Notice --> Undefined variable: nama_program /home/www/importa/application/modules/users/views/login_animate.php 6
ERROR - 2018-09-12 08:48:04 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/po_form.php 8
ERROR - 2018-09-12 08:48:57 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/po_form.php 8
ERROR - 2018-09-12 08:57:02 --> Severity: Parsing Error --> syntax error, unexpected ')' /home/www/importa/application/modules/purchaseorder/controllers/Purchaseorder.php 60
ERROR - 2018-09-12 09:00:51 --> Query error: Unknown column 'h.total' in 'where clause' - Invalid query:  SELECT
              h.no_pr,
              h.kdcab,
              h.id_supplier,
              h.nm_supplier,
              h.tgl_pr,
              h.total_pr,
              d.proses_po

            FROM
              trans_pr_header h
            JOIN
            trans_pr_detail d ON h.no_pr = d.no_pr
            WHERE h.total != 0  
            GROUP BY h.no_pr
          
ERROR - 2018-09-12 09:01:17 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/po_form.php 8
ERROR - 2018-09-12 09:01:42 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 59
ERROR - 2018-09-12 09:01:42 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/purchaseorder/views/purchaseorder_form.php 75
ERROR - 2018-09-12 09:01:56 --> Query error: Unknown column 'no_pr' in 'field list' - Invalid query: INSERT INTO `trans_po_detail` (`no_po`, `no_pr`, `id_barang`, `nm_barang`, `satuan`, `qty_order`, `qty_supply`) VALUES ('101-PO-18I00008', '101-PR-18I00004', 'HPDCCN001001', 'X12 GREEN DIREKTUR CHAIR', 'SET', NULL, '090')
ERROR - 2018-09-12 09:04:35 --> Query error: Column 'no_pr' in where clause is ambiguous - Invalid query: SELECT *
FROM `trans_pr_header`
LEFT JOIN `cabang` ON `trans_pr_header`.`kdcab` = `cabang`.`kdcab`
WHERE `no_pr` IN('101-PR-18I00004', '101-PR-18I00006')
ERROR - 2018-09-12 09:05:56 --> Query error: Unknown column 'no_pr' in 'field list' - Invalid query: INSERT INTO `trans_po_detail` (`no_po`, `no_pr`, `id_barang`, `nm_barang`, `satuan`, `qty_order`, `qty_supply`) VALUES ('101-PO-18I00008', '101-PR-18I00004', 'HPDCCN001001', 'X12 GREEN DIREKTUR CHAIR', 'SET', NULL, '090')
ERROR - 2018-09-12 09:12:07 --> Query error: Unknown column 'no_pr' in 'field list' - Invalid query: INSERT INTO `trans_po_detail` (`no_po`, `no_pr`, `id_barang`, `nm_barang`, `satuan`, `qty_order`, `qty_supply`) VALUES ('101-PO-18I00008', '101-PR-18I00004', 'HPDCCN001001', 'X12 GREEN DIREKTUR CHAIR', 'SET', NULL, '090')
ERROR - 2018-09-12 09:17:16 --> Query error: Unknown column 'no_pr' in 'field list' - Invalid query: INSERT INTO `trans_po_detail` (`no_po`, `no_pr`, `id_barang`, `nm_barang`, `satuan`, `qty_order`, `qty_supply`) VALUES ('101-PO-18I00008', '101-PR-18I00004', 'HPDCCN001001', 'X12 GREEN DIREKTUR CHAIR', 'SET', NULL, '090')
ERROR - 2018-09-12 09:20:40 --> Query error: Unknown column 'no_pr' in 'field list' - Invalid query: INSERT INTO `trans_po_detail` (`no_po`, `no_pr`, `id_barang`, `nm_barang`, `satuan`, `qty_order`, `qty_supply`) VALUES ('101-PO-18I00008', '101-PR-18I00004', 'HPDCCN001001', 'X12 GREEN DIREKTUR CHAIR', 'SET', NULL, '090')
ERROR - 2018-09-12 09:22:31 --> Query error: Unknown column 'no_pr' in 'field list' - Invalid query: INSERT INTO `trans_po_detail` (`no_po`, `no_pr`, `id_barang`, `nm_barang`, `satuan`, `qty_order`, `qty_supply`) VALUES ('101-PO-18I00008', '101-PR-18I00004', 'HPDCCN001001', 'X12 GREEN DIREKTUR CHAIR', 'SET', NULL, '090')
ERROR - 2018-09-12 09:22:35 --> Query error: Unknown column 'no_pr' in 'field list' - Invalid query: INSERT INTO `trans_po_detail` (`no_po`, `no_pr`, `id_barang`, `nm_barang`, `satuan`, `qty_order`, `qty_supply`) VALUES ('101-PO-18I00008', '101-PR-18I00004', 'HPDCCN001001', 'X12 GREEN DIREKTUR CHAIR', 'SET', NULL, '090')
ERROR - 2018-09-12 09:24:23 --> Query error: Unknown column 'no_pr' in 'field list' - Invalid query: INSERT INTO `trans_po_detail` (`no_po`, `no_pr`, `id_barang`, `nm_barang`, `satuan`, `qty_order`, `qty_supply`) VALUES ('101-PO-18I00008', '101-PR-18I00004', 'HPDCCN001001', 'X12 GREEN DIREKTUR CHAIR', 'SET', NULL, '090')
ERROR - 2018-09-12 09:25:42 --> Severity: Notice --> Undefined variable: nama_program /home/www/importa/application/modules/users/views/login_animate.php 6
ERROR - 2018-09-12 09:26:42 --> Query error: Unknown column 'no_pr' in 'field list' - Invalid query: INSERT INTO `trans_po_detail` (`no_po`, `no_pr`, `id_barang`, `nm_barang`, `satuan`, `qty_order`, `qty_supply`) VALUES ('101-PO-18I00008', '101-PR-18I00004', 'HPDCCN001001', 'X12 GREEN DIREKTUR CHAIR', 'SET', NULL, '90')
ERROR - 2018-09-12 09:27:04 --> Query error: Unknown column 'no_pr' in 'field list' - Invalid query: INSERT INTO `trans_po_detail` (`no_po`, `no_pr`, `id_barang`, `nm_barang`, `satuan`, `qty_order`, `qty_supply`) VALUES ('101-PO-18I00008', '101-PR-18I00004', 'HPDCCN001001', 'X12 GREEN DIREKTUR CHAIR', 'SET', NULL, '')
ERROR - 2018-09-12 09:27:12 --> Query error: Unknown column 'no_pr' in 'field list' - Invalid query: INSERT INTO `trans_po_detail` (`no_po`, `no_pr`, `id_barang`, `nm_barang`, `satuan`, `qty_order`, `qty_supply`) VALUES ('101-PO-18I00008', '101-PR-18I00004', 'HPDCCN001001', 'X12 GREEN DIREKTUR CHAIR', 'SET', NULL, '90')
ERROR - 2018-09-12 09:29:32 --> Query error: Unknown column 'no_pr' in 'field list' - Invalid query: INSERT INTO `trans_po_detail` (`no_po`, `no_pr`, `id_barang`, `nm_barang`, `satuan`, `qty_order`, `qty_supply`) VALUES ('101-PO-18I00008', '101-PR-18I00004', 'HPDCCN001001', 'X12 GREEN DIREKTUR CHAIR', 'SET', NULL, '090')
ERROR - 2018-09-12 09:29:41 --> Query error: Unknown column 'no_pr' in 'field list' - Invalid query: INSERT INTO `trans_po_detail` (`no_po`, `no_pr`, `id_barang`, `nm_barang`, `satuan`, `qty_order`, `qty_supply`) VALUES ('101-PO-18I00008', '101-PR-18I00004', 'HPDCCN001001', 'X12 GREEN DIREKTUR CHAIR', 'SET', NULL, '090')
ERROR - 2018-09-12 09:33:54 --> Query error: Unknown column 'no_pr' in 'field list' - Invalid query: INSERT INTO `trans_po_detail` (`no_po`, `no_pr`, `id_barang`, `nm_barang`, `satuan`, `qty_order`, `qty_supply`) VALUES ('101-PO-18I00008', '101-PR-18I00004', 'HPDCCN001001', 'X12 GREEN DIREKTUR CHAIR', 'SET', NULL, '090')
ERROR - 2018-09-12 09:34:52 --> Query error: Unknown column 'no_pr' in 'field list' - Invalid query: INSERT INTO `trans_po_detail` (`no_po`, `no_pr`, `id_barang`, `nm_barang`, `satuan`, `qty_order`, `qty_supply`) VALUES ('101-PO-18I00008', '101-PR-18I00004', 'HPDCCN001001', 'X12 GREEN DIREKTUR CHAIR', 'SET', NULL, '090')
ERROR - 2018-09-12 09:35:16 --> Query error: Unknown column 'no_pr' in 'field list' - Invalid query: INSERT INTO `trans_po_detail` (`no_po`, `no_pr`, `id_barang`, `nm_barang`, `satuan`, `qty_order`, `qty_supply`) VALUES ('101-PO-18I00008', '101-PR-18I00004', 'HPDCCN001001', 'X12 GREEN DIREKTUR CHAIR', 'SET', NULL, '090')
ERROR - 2018-09-12 09:35:41 --> Query error: Unknown column 'no_pr' in 'field list' - Invalid query: INSERT INTO `trans_po_detail` (`no_po`, `no_pr`, `id_barang`, `nm_barang`, `satuan`, `qty_order`, `qty_supply`) VALUES ('101-PO-18I00008', '101-PR-18I00004', 'HPDCCN001001', 'X12 GREEN DIREKTUR CHAIR', 'SET', NULL, '090')
ERROR - 2018-09-12 09:37:57 --> Severity: Notice --> Undefined variable: nama_program /home/www/importa/application/modules/users/views/login_animate.php 6
ERROR - 2018-09-12 09:37:57 --> Severity: Notice --> Undefined variable: nama_program /home/www/importa/application/modules/users/views/login_animate.php 6
ERROR - 2018-09-12 09:37:58 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:37:58 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:37:58 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:37:58 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:37:58 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:37:58 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:37:58 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:37:58 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:37:58 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:37:58 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:37:58 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:37:58 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:37:59 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:37:59 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:37:59 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:37:59 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:37:59 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:37:59 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:37:59 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:37:59 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:37:59 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:37:59 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:37:59 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:37:59 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:37:59 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:37:59 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:37:59 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:38:00 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:38:00 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:38:00 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:38:00 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:38:00 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:38:00 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:38:00 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:38:00 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:38:00 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:38:00 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:38:00 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:38:00 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:38:00 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:38:00 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:38:00 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:38:00 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:38:00 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:38:00 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:38:00 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:38:01 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:38:01 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:38:01 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:38:01 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:38:01 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:38:01 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:38:01 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:38:01 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:38:01 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:38:01 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:38:01 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:38:01 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:38:01 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:38:01 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:38:01 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:38:01 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:38:01 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:38:01 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:38:01 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:38:01 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:38:23 --> Query error: Unknown column 'no_pr' in 'field list' - Invalid query: INSERT INTO `trans_po_detail` (`no_po`, `no_pr`, `id_barang`, `nm_barang`, `satuan`, `qty_order`, `qty_supply`) VALUES ('101-PO-18I00008', '101-PR-18I00004', 'HPDCCN001001', 'X12 GREEN DIREKTUR CHAIR', 'SET', NULL, '90')
ERROR - 2018-09-12 09:39:57 --> Query error: Unknown column 'kdcab' in 'field list' - Invalid query: INSERT INTO `trans_po_header` (`no_po`, `kdcab`, `nm_cabang`, `alamat_cabang`, `id_salesman`, `nm_salesman`, `tgl_po`, `tipe_pengiriman`, `id_supir`, `nm_supir`, `id_kendaraan`, `status`) VALUES ('101-PO-18I00008', NULL, NULL, NULL, NULL, NULL, '2018-09-12', NULL, NULL, NULL, NULL, NULL)
ERROR - 2018-09-12 09:41:19 --> Query error: Unknown column 'nm_cabang' in 'field list' - Invalid query: INSERT INTO `trans_po_header` (`no_po`, `kdcab`, `nm_cabang`, `alamat_cabang`, `id_salesman`, `nm_salesman`, `tgl_po`, `tipe_pengiriman`, `id_supir`, `nm_supir`, `id_kendaraan`, `status`) VALUES ('101-PO-18I00008', NULL, NULL, NULL, NULL, NULL, '2018-09-12', NULL, NULL, NULL, NULL, NULL)
ERROR - 2018-09-12 09:41:42 --> Query error: Unknown column 'alamat_cabang' in 'field list' - Invalid query: INSERT INTO `trans_po_header` (`no_po`, `kdcab`, `nm_cabang`, `alamat_cabang`, `id_salesman`, `nm_salesman`, `tgl_po`, `tipe_pengiriman`, `id_supir`, `nm_supir`, `id_kendaraan`, `status`) VALUES ('101-PO-18I00008', NULL, NULL, NULL, NULL, NULL, '2018-09-12', NULL, NULL, NULL, NULL, NULL)
ERROR - 2018-09-12 09:42:08 --> Query error: Unknown column 'id_salesman' in 'field list' - Invalid query: INSERT INTO `trans_po_header` (`no_po`, `kdcab`, `nm_cabang`, `id_salesman`, `nm_salesman`, `tgl_po`, `status`) VALUES ('101-PO-18I00008', NULL, NULL, NULL, NULL, '2018-09-12', NULL)
ERROR - 2018-09-12 09:42:18 --> Query error: Unknown column 'status' in 'field list' - Invalid query: INSERT INTO `trans_po_header` (`no_po`, `kdcab`, `nm_cabang`, `id_supplier`, `nm_supplier`, `tgl_po`, `status`) VALUES ('101-PO-18I00008', NULL, NULL, NULL, NULL, '2018-09-12', NULL)
ERROR - 2018-09-12 09:43:23 --> Query error: Column 'id_supplier' cannot be null - Invalid query: INSERT INTO `trans_po_header` (`no_po`, `kdcab`, `nm_cabang`, `id_supplier`, `nm_supplier`, `tgl_po`, `status`) VALUES ('101-PO-18I00008', NULL, NULL, NULL, NULL, '2018-09-12', NULL)
ERROR - 2018-09-12 09:43:32 --> Query error: Unknown column 'no_pr' in 'field list' - Invalid query: INSERT INTO `trans_po_detail` (`no_po`, `no_pr`, `id_barang`, `nm_barang`, `satuan`, `qty_order`, `qty_supply`) VALUES ('101-PO-18I00008', '101-PR-18I00004', 'HPDCCN001001', 'X12 GREEN DIREKTUR CHAIR', 'SET', NULL, '90')
ERROR - 2018-09-12 09:43:38 --> Query error: Unknown column 'no_pr' in 'field list' - Invalid query: INSERT INTO `trans_po_detail` (`no_po`, `no_pr`, `id_barang`, `nm_barang`, `satuan`, `qty_order`, `qty_supply`) VALUES ('101-PO-18I00008', '101-PR-18I00004', 'HPDCCN001001', 'X12 GREEN DIREKTUR CHAIR', 'SET', NULL, '90')
ERROR - 2018-09-12 09:45:29 --> Query error: Unknown column 'no_pr' in 'field list' - Invalid query: INSERT INTO `trans_po_detail` (`no_po`, `no_pr`, `id_barang`, `nm_barang`, `satuan`, `qty_order`, `qty_supply`) VALUES ('101-PO-18I00008', '101-PR-18I00004', 'HPDCCN001001', 'X12 GREEN DIREKTUR CHAIR', 'SET', NULL, '90')
ERROR - 2018-09-12 09:48:27 --> Query error: Unknown column 'no_pr' in 'field list' - Invalid query: INSERT INTO `trans_po_detail` (`no_po`, `no_pr`, `id_barang`, `nm_barang`, `satuan`, `qty_order`, `qty_supply`) VALUES ('101-PO-18I00008', '101-PR-18I00004', 'HPDCCN001001', 'X12 GREEN DIREKTUR CHAIR', 'SET', NULL, '090')
ERROR - 2018-09-12 09:53:04 --> Query error: Unknown column 'no_pr' in 'field list' - Invalid query: INSERT INTO `trans_po_detail` (`no_po`, `no_pr`, `id_barang`, `nm_barang`, `satuan`, `qty_order`, `qty_supply`) VALUES ('101-PO-18I00008', '101-PR-18I00004', 'HPDCCN001001', 'X12 GREEN DIREKTUR CHAIR', 'SET', NULL, '090')
ERROR - 2018-09-12 09:53:54 --> Query error: Unknown column 'no_pr' in 'field list' - Invalid query: INSERT INTO `trans_po_detail` (`no_po`, `no_pr`, `id_barang`, `nm_barang`, `satuan`, `qty_order`, `qty_supply`) VALUES ('101-PO-18I00008', '101-PR-18I00004', 'HPDCCN001001', 'X12 GREEN DIREKTUR CHAIR', 'SET', NULL, '090')
ERROR - 2018-09-12 09:54:01 --> Query error: Unknown column 'no_pr' in 'field list' - Invalid query: INSERT INTO `trans_po_detail` (`no_po`, `no_pr`, `id_barang`, `nm_barang`, `satuan`, `qty_order`, `qty_supply`) VALUES ('101-PO-18I00008', '101-PR-18I00004', 'HPDCCN001001', 'X12 GREEN DIREKTUR CHAIR', 'SET', NULL, '90')
ERROR - 2018-09-12 09:54:10 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:10 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:10 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:10 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:10 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:10 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:10 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:10 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:10 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:10 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:10 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:10 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:10 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:10 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:10 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:10 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:10 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:10 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:10 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:10 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:10 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:10 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:10 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:10 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:10 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:10 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:10 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:10 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:10 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:10 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:10 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:10 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:10 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:10 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:10 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:10 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:10 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:10 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:10 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:10 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:10 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:10 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:10 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:10 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:10 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:10 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:10 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:10 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:10 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:10 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:10 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:10 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:10 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:10 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:10 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:10 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:10 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:11 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:11 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:11 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:11 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:11 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:11 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:11 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:11 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:11 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:16 --> Query error: Unknown column 'no_pr' in 'field list' - Invalid query: INSERT INTO `trans_po_detail` (`no_po`, `no_pr`, `id_barang`, `nm_barang`, `satuan`, `qty_order`, `qty_supply`) VALUES ('101-PO-18I00008', '101-PR-18I00004', 'HPDCCN001001', 'X12 GREEN DIREKTUR CHAIR', 'SET', NULL, '90')
ERROR - 2018-09-12 09:54:39 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:39 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:39 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:39 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:39 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:39 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:39 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:39 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:39 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:39 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:39 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:39 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:39 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:39 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:39 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:39 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:39 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:39 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:39 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:39 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:39 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:39 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:39 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:39 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:39 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:39 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:39 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:39 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:39 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:39 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:39 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:39 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:39 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:39 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:39 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:39 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:39 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:39 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:39 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:39 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:39 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:39 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:39 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:39 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:39 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:39 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:39 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:39 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:39 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:39 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:39 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:39 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:39 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:39 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:39 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:39 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:39 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:39 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:39 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:39 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:39 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:39 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:39 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:39 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:39 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:39 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:54:48 --> Query error: Unknown column 'no_pr' in 'field list' - Invalid query: INSERT INTO `trans_po_detail` (`no_po`, `no_pr`, `id_barang`, `nm_barang`, `satuan`, `qty_order`, `qty_supply`) VALUES ('101-PO-18I00008', '101-PR-18I00004', 'HPDCCN001001', 'X12 GREEN DIREKTUR CHAIR', 'SET', NULL, '90')
ERROR - 2018-09-12 09:55:14 --> Severity: Notice --> Undefined variable: nama_program /home/www/importa/application/modules/users/views/login_animate.php 6
ERROR - 2018-09-12 09:55:15 --> Severity: Notice --> Undefined variable: nama_program /home/www/importa/application/modules/users/views/login_animate.php 6
ERROR - 2018-09-12 09:55:19 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:19 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:19 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:19 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:19 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:19 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:19 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:19 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:19 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:19 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:19 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:19 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:19 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:19 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:19 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:19 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:19 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:19 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:19 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:19 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:19 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:19 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:19 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:19 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:19 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:19 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:19 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:19 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:19 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:19 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:19 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:19 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:19 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:19 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:19 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:19 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:19 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:19 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:19 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:19 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:19 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:19 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:19 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:19 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:19 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:19 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:19 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:19 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:19 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:19 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:19 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:19 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:19 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:19 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:19 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:19 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:19 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:19 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:19 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:19 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:19 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:19 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:19 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:19 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:19 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:19 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:21 --> Severity: Notice --> Undefined variable: nama_program /home/www/importa/application/modules/users/views/login_animate.php 6
ERROR - 2018-09-12 09:55:33 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:33 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:33 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:33 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:33 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:33 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:33 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:33 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:33 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:33 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:33 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:33 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:33 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:33 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:33 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:33 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:33 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:33 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:33 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:33 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:33 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:33 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:33 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:33 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:33 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:33 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:33 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:33 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:33 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:33 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:33 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:33 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:33 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:33 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:33 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:33 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:33 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:33 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:33 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:33 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:33 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:33 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:33 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:33 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:33 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:33 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:33 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:33 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:33 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:33 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:33 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:33 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:33 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:33 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:33 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:33 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:33 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:33 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:33 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:33 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:33 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:33 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:33 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:33 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:33 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:33 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:52 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:52 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:52 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:52 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:52 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:52 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:52 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:52 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:52 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:52 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:52 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:52 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:52 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:52 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:52 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:52 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:52 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:52 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:52 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:52 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:52 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:52 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:52 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:52 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:52 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:52 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:52 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:52 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:52 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:52 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:52 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:52 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:52 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:52 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:52 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:52 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:52 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:52 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:52 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:52 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:52 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:52 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:52 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:52 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:52 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:52 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:52 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:52 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:52 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:53 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:53 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:53 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:53 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:53 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:53 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:53 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:53 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:53 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:53 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:53 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:53 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:53 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:53 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:53 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:53 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:55:53 --> 404 Page Not Found: /index
ERROR - 2018-09-12 09:57:45 --> 404 Page Not Found: ../modules/purchaseorder_old/controllers//index
ERROR - 2018-09-12 09:58:00 --> Query error: Unknown column 'no_pr' in 'field list' - Invalid query: INSERT INTO `trans_po_detail` (`no_po`, `no_pr`, `id_barang`, `nm_barang`, `satuan`, `qty_order`, `qty_supply`) VALUES ('101-PO-18I00008', '101-PR-18I00004', 'HPDCCN001001', 'X12 GREEN DIREKTUR CHAIR', 'SET', NULL, '090')
ERROR - 2018-09-12 09:58:41 --> Query error: Column 'id_supplier' cannot be null - Invalid query: INSERT INTO `trans_po_header` (`no_po`, `kdcab`, `nm_cabang`, `id_supplier`, `nm_supplier`, `tgl_po`, `status`) VALUES ('101-PO-18I00008', NULL, NULL, NULL, NULL, '2018-09-12', NULL)
ERROR - 2018-09-12 09:59:14 --> Query error: Unknown column 'no_pr' in 'field list' - Invalid query: INSERT INTO `trans_po_detail` (`no_po`, `no_pr`, `id_barang`, `nm_barang`, `satuan`, `qty_order`, `qty_supply`) VALUES ('101-PO-18I00008', '101-PR-18I00004', 'HPDCCN001001', 'X12 GREEN DIREKTUR CHAIR', 'SET', NULL, '090')
ERROR - 2018-09-12 09:59:39 --> Query error: Unknown column 'no_pr' in 'field list' - Invalid query: INSERT INTO `trans_po_detail` (`no_po`, `no_pr`, `id_barang`, `nm_barang`, `satuan`, `qty_order`, `qty_supply`) VALUES ('101-PO-18I00008', '101-PR-18I00004', 'HPDCCN001001', 'X12 GREEN DIREKTUR CHAIR', 'SET', NULL, '090')
ERROR - 2018-09-12 10:00:34 --> Query error: Unknown column 'no_pr' in 'field list' - Invalid query: INSERT INTO `trans_po_detail` (`no_po`, `no_pr`, `id_barang`, `nm_barang`, `satuan`, `qty_order`, `qty_supply`) VALUES ('101-PO-18I00008', '101-PR-18I00004', 'HPDCCN001001', 'X12 GREEN DIREKTUR CHAIR', 'SET', NULL, '090')
ERROR - 2018-09-12 10:01:05 --> Query error: Unknown column 'no_pr' in 'field list' - Invalid query: INSERT INTO `trans_po_detail` (`no_po`, `no_pr`, `id_barang`, `nm_barang`, `satuan`, `qty_order`, `qty_supply`) VALUES ('101-PO-18I00008', '101-PR-18I00004', 'HPDCCN001001', 'X12 GREEN DIREKTUR CHAIR', 'SET', NULL, '090')
ERROR - 2018-09-12 10:14:33 --> Query error: Unknown column 'qty_order' in 'field list' - Invalid query: INSERT INTO `trans_po_detail` (`no_po`, `no_pr`, `id_barang`, `nm_barang`, `satuan`, `qty_order`, `qty_supply`) VALUES ('101-PO-18I00008', '101-PR-18I00004', 'HPDCCN001001', 'X12 GREEN DIREKTUR CHAIR', 'SET', '90', '90')
ERROR - 2018-09-12 10:15:03 --> Query error: Unknown column 'qty_order' in 'field list' - Invalid query: INSERT INTO `trans_po_detail` (`no_po`, `no_pr`, `id_barang`, `nm_barang`, `satuan`, `qty_order`, `qty_supply`) VALUES ('101-PO-18I00008', '101-PR-18I00004', 'HPDCCN001001', 'X12 GREEN DIREKTUR CHAIR', 'SET', '90', '90')
ERROR - 2018-09-12 10:16:53 --> Query error: Unknown column 'qty_order' in 'field list' - Invalid query: INSERT INTO `trans_po_detail` (`no_po`, `no_pr`, `id_barang`, `nm_barang`, `satuan`, `qty_order`, `qty_supply`) VALUES ('101-PO-18I00008', '101-PR-18I00004', 'HPDCCN001001', 'X12 GREEN DIREKTUR CHAIR', 'SET', '90', '89')
ERROR - 2018-09-12 14:09:19 --> Severity: Notice --> Undefined variable: nama_program /home/www/importa/application/modules/users/views/login_animate.php 6
ERROR - 2018-09-12 14:54:22 --> Severity: Notice --> Undefined variable: nama_program /home/www/importa/application/modules/users/views/login_animate.php 6
ERROR - 2018-09-12 15:46:18 --> Severity: Parsing Error --> syntax error, unexpected '$this' (T_VARIABLE) /home/www/importa/application/modules/purchaserequest/controllers/Purchaserequest.php 50
ERROR - 2018-09-12 15:46:35 --> 404 Page Not Found: ../modules/purchaserequest/controllers/Purchaserequest/create
ERROR - 2018-09-12 15:54:22 --> Severity: Parsing Error --> syntax error, unexpected '->' (T_OBJECT_OPERATOR), expecting identifier (T_STRING) or variable (T_VARIABLE) or '{' or '$' /home/www/importa/application/modules/purchaserequest/controllers/Purchaserequest.php 50
ERROR - 2018-09-12 17:23:35 --> Severity: Notice --> Undefined variable: nama_program /home/www/importa/application/modules/users/views/login_animate.php 6
ERROR - 2018-09-12 17:37:49 --> Severity: Notice --> Undefined variable: nama_program /home/www/importa/application/modules/users/views/login_animate.php 6
ERROR - 2018-09-12 17:40:50 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/barang/views/barang_form.php 41
ERROR - 2018-09-12 17:40:50 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/barang/views/barang_form.php 60
ERROR - 2018-09-12 17:40:50 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/barang/views/barang_form.php 122
ERROR - 2018-09-12 17:40:50 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/barang/views/barang_form.php 255
ERROR - 2018-09-12 17:40:50 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/barang/views/barang_form.php 379
ERROR - 2018-09-12 17:40:59 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/barang/views/barang_form.php 379
ERROR - 2018-09-12 17:51:35 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/barang/views/barang_form.php 41
ERROR - 2018-09-12 17:51:35 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/barang/views/barang_form.php 60
ERROR - 2018-09-12 17:51:35 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/barang/views/barang_form.php 122
ERROR - 2018-09-12 17:51:35 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/barang/views/barang_form.php 255
ERROR - 2018-09-12 17:51:35 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/barang/views/barang_form.php 379
ERROR - 2018-09-12 17:52:04 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/barang/views/barang_form.php 41
ERROR - 2018-09-12 17:52:04 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/barang/views/barang_form.php 60
ERROR - 2018-09-12 17:52:04 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/barang/views/barang_form.php 122
ERROR - 2018-09-12 17:52:04 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/barang/views/barang_form.php 255
ERROR - 2018-09-12 17:52:04 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/barang/views/barang_form.php 379
ERROR - 2018-09-12 21:11:18 --> Severity: Notice --> Undefined variable: nama_program /home/www/importa/application/modules/users/views/login_animate.php 6
ERROR - 2018-09-12 21:57:03 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/barang/views/barang_form.php 41
ERROR - 2018-09-12 21:57:03 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/barang/views/barang_form.php 60
ERROR - 2018-09-12 21:57:03 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/barang/views/barang_form.php 122
ERROR - 2018-09-12 21:57:03 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/barang/views/barang_form.php 255
ERROR - 2018-09-12 21:57:03 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/barang/views/barang_form.php 379
ERROR - 2018-09-12 22:03:46 --> Severity: Notice --> Undefined variable: nama_program /home/www/importa/application/modules/users/views/login_animate.php 6
ERROR - 2018-09-12 22:04:18 --> 404 Page Not Found: /index
ERROR - 2018-09-12 22:21:21 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/barang/views/barang_form.php 41
ERROR - 2018-09-12 22:21:21 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/barang/views/barang_form.php 60
ERROR - 2018-09-12 22:21:21 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/barang/views/barang_form.php 122
ERROR - 2018-09-12 22:21:21 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/barang/views/barang_form.php 273
ERROR - 2018-09-12 22:21:21 --> Severity: Warning --> Invalid argument supplied for foreach() /home/www/importa/application/modules/barang/views/barang_form.php 397
ERROR - 2018-09-12 22:46:03 --> 404 Page Not Found: /index
ERROR - 2018-09-12 22:46:30 --> 404 Page Not Found: /index
ERROR - 2018-09-12 22:47:11 --> 404 Page Not Found: /index
ERROR - 2018-09-12 22:50:28 --> 404 Page Not Found: /index
ERROR - 2018-09-12 22:50:29 --> Query error: Unknown column 'status1' in 'where clause' - Invalid query: SELECT *
FROM `trans_do_header`
WHERE `status` = 'DO'
AND `status1` = 'DO-PENDING'
ORDER BY `no_do` ASC
