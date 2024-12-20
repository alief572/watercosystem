<html>
<head>
  <title>Cetak PDF</title>
<style>
    #tables td, th {
		border: 1px solid #000000;
        padding: 2 px;
		font-size: 11px;
		border-collapse: collapse;
    }
	.clearth{
		border: 0px;
		border-collapse: collapse;
	}
</style>
</head>
<body>
<?php
	foreach($header as $header){
	}
	$kepala = $this->db->query("SELECT * FROM tr_inquiry WHERE no_inquiry = '$header->no_inquery' ")->result();
	$id_customer= $kepala[0]->id_customer;
	$id_sales = $kepala[0]->id_sales;
	$id_category3 = $header->id_category3;
	$id_bentuk = $header->id_bentuk;
	$customer	= $this->db->query("SELECT * FROM master_customers WHERE id_customer = '$id_customer' ")->result();
	$sales	= $this->db->query("SELECT * FROM ms_karyawan WHERE id_karyawan = '$id_sales' ")->result();
	$bentuk	= $this->db->query("SELECT * FROM ms_bentuk WHERE id_bentuk = '$id_bentuk' ")->result();
	$material	= $this->db->query("SELECT a.*, b.nama as nama_type , c.nilai_dimensi as thickness from ms_inventory_category3 as a INNER JOIN ms_inventory_category2 as b ON b.id_category2 = a.id_category2 INNER JOIN child_inven_dimensi as c ON c.id_category3=a.id_category3 WHERE a.id_category3 = '$id_category3' ")->result();
?>
<div id='wrapper'>
<table border="0" width='100%' align="center">
<tr>
	<td width="700" align="center">
		<h3 style="text-align: left;">PT METALSINDO PASIFIC</h3>
	</td>
</tr>
</table>
<table id="tables" border="0" width='100%' align="center">
<tr>
	<td width="700" align="left">
		<h5 style="text-align: center;">Customer Requirement Checklist</h5>
	</td>
</tr>
</table>
<table border="0" width='100%' align="center">
<tr>
	<td width="100" align="left">
	No. CRCL
	</td>
	<td width="200" align="left">
	<?= $kepala[0]->no_surat ?>
	</td>
	<td width="100" align="left">
	Tanggal
	</td>
	<td width="200" align="left">
	<?= $kepala[0]->tgl_inquiry ?>
	</td>
</tr>
<tr>
	<td width="100" align="left">
	Nama Customer
	</td>
	<td width="200" align="left">
	<?= $customer[0]->name_customer ?>
	</td>
	<td width="100" align="left">
	Email
	</td>
	<td width="200" align="left">
	<?= $kepala[0]->email_customer ?>
	</td>
</tr>
<tr>
	<td width="100" align="left">
	Nama Sales
	</td>
	<td width="200" align="left">
	<?= $sales[0]->nama_karyawan ?>
	</td>
		<td width="100" align="left">
	Nama Customer
	</td>
	<td width="200" align="left">
	<?= $kepala[0]->pic_customer ?>
	</td>
</tr>
</table>
<table id="tables" border="0" width='100%' align="center">
<tr>
	<td width="700" align="left">
		<h5 style="text-align: center;">Detail Produk</h5>
	</td>
</tr>
</table>
<table border="0" width='100%' align="center">
<tr>
<td width="110" align="left">ID Detail</td>
<td width="10">:</td>
<td width="200" align="left"><?= $header->id_surat_crcl ?></td>
<td width="110" align="left">Bentuk</td>
<td width="10">:</td>
<td width="200" align="left"><?= $bentuk[0]->nm_bentuk ?></td>
</tr>
<tr>
<td width="110" align="left">Produk</td>
<td width="10">:</td>
<td width="200" align="left"><?= $material[0]->nama ?>-<?= $material[0]->nama_type ?>-<?= $material[0]->thickness ?></td>
<td width="110" align="left">Thickness</td>
<td width="10">:</td>
<td width="200" align="left"><?= $header->thicknesss ?></td>
</tr>
<tr>
<td width="110" align="left">Density</td>
<td width="10">:</td>
<td width="200" align="left"><?= $header->density ?></td>
<td width="110" align="left">Width</td>
<td width="10">:</td>
<td width="200" align="left"><?= $header->dimensi1 ?></td>
</tr>
<tr>
<td width="110" align="left">Length</td>
<td width="10">:</td>
<td width="200" align="left"><?= $header->dimensi2 ?></td>
<td width="110" align="left">Weight/unit</td>
<td width="10">:</td>
<td width="200" align="left"><?= $header->berat_produk ?></td>
</tr>
<tr>
<td width="110" align="left">Forecast / Month</td>
<td width="10">:</td>
<td width="200" align="left"><?= $header->rerata ?>Pcs/Kg</td>
<td width="110" align="left">Master Sample</td>
<td width="10">:</td>
<td width="200" align="left"><?= $header->master_sample ?></td>
</tr>
<tr>
<td width="110" align="left">Mill Sheet</td>
<td width="10">:</td>
<td width="200" align="left"><?= $header->mill_sheet ?></td>
</tr>
</table>
<table border="0" width='100%' align="center">
<tr><td width="400" align="center">Toleransi</td></tr>
</table>
<table border="0" width='100%' align="center">
<tr>
<td width="110" align="left">Toleransi Thickness</td>
<td width="10">:</td>
<td width="200" align="left"><?= $header->toleransi1min ?>-<?= $header->toleransi1max ?></td>
<td width="110" align="left">Toleransi Width</td>
<td width="10">:</td>
<td width="200" align="left"><?= $header->toleransi2min ?>-<?= $header->toleransi2max ?></td>
</tr>
<tr>
<td width="110" align="left">Burry</td>
<td width="10">:</td>
<td width="200" align="left"><?= $header->burry ?>%<</td>
<td width="110" align="left">Sambungan Coil</td>
<td width="10">:</td>
<td width="200" align="left"><?= $header->sambungan ?></td>
</tr>
<tr>
<td width="110" align="left">Apperace</td>
<td width="10">:</td>
<td width="200" align="left"><?= $header->apperance ?></td>
<td width="110" align="left">Max Join</td>
<td width="10">:</td>
<td width="200" align="left"><?= $header->maxjoin ?></td>
</tr>
</table>
</div>