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
	$id_customer=$header->id_customer;
	$customer	= $this->db->query("SELECT * FROM master_customers WHERE id_customer = '$id_customer' ")->result();
 	$tgl1 = date_create($header->valid_until);
	$tgl2 = date_create($header->tgl_penawaran);
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
		<h5 style="text-align: center;">Penawaran Slitting</h5>
	</td>
</tr>
</table>
<table border="0" width='100%' align="center">
<tr>
	<td width="350" align="left">
	<table>
	<tr><td align='left'>Address</td></tr>
	<tr><td align='left'>Jl. Jababeka XIV, Blok J no. 10 H</td></tr>
	<tr><td align='left'>Cikarang Industrial Estate, Bekasi 17530</td></tr>
	<tr><td align='left'>PHONE:(62-21)89831726734,FAX(62-21)89831866</td></tr>
	<tr><td align='left'>NPWP:	21.098.204.7-414.000</td></tr>
	</table>
	</td>
	<td width="350" align="right">
	<table>
	<tr><td align='left'>Quote no</td><td align='left'>:</td><td align='left'><?= $header->no_surat ?></td></tr>
	<tr><td align='left'>Date</td><td align='left'>:</td><td align='left'><?= $header->tgl_penawaran ?></td></tr>
	</table>
	</td>
</tr>
</table>
<table border="0" width='100%' align="center">
<tr>
	<td width="380" align="center">
	<table width='380' align="center">
	<tr><td width='70' align="left">Custommer</td><td width='10' align="left">:</td><td width='300' align="left"><?= $customer[0]->name_customer ?></td></tr>
	<tr><td width='70' align="left">Address</td><td width='10' align="left">:</td><td width='300' align="left"><?= $customer[0]->address_office ?></td></tr>
	<tr><td width='70' align="left">Phone</td><td width='10' align="left">:</td><td width='300' align="left"><?= $customer[0]->telephone ?></td></tr>
	<tr><td width='70' align="left">FAX</td><td width='10' align="left">:</td><td width='300' align="left"><?= $customer[0]->fax ?></td></tr>
	</table>
	</td>
</tr>
</table>
	<table id="tables" border="0" width='100%' align="center" cellpadding="2" cellspacing="0">
			<tr>
			<th width='80' align='center'>Nama Material</th>
			<th width='50' align='center'>Berat Coil</th>
			<th width='50' align='center'>Density</th>
			<th width='50' align='center'>Thickness</th>
			<th width='50' align='center'>Lebar Material</th>
			<th width='50' align='center'>Panjang Coil</th>
			<th width='50' align='center'>Lebar Request</th>
			<th width='50' align='center'>Qty Coil</th>
			<th width='50' align='center'>Pegangan Coil</th>
			<th width='50' align='center'>Waste</th>
			<th width='50' align='center'>Jumlah Pisau</th>
			<th width='70' align='center'>Harga Penawaran</th>
			</tr>
			<?	foreach($detail as $detail){?>
						<tr>
			<th width='80' align='center'><?= $detail->nama_material ?></th>
			<th width='50' align='center'><?= $detail->berat ?></th>
			<th width='50' align='center'><?= $detail->density ?></th>
			<th width='50' align='center'><?= $detail->thickness ?></th>
			<th width='50' align='center'><?= $detail->lebar ?></th>
			<th width='50' align='center'><?= $detail->panjang ?></th>
			<th width='50' align='center'><?= $detail->lebarnew ?></th>
			<th width='50' align='center'><?= $detail->qty ?></th>
			<th width='50' align='center'><?= $detail->pegangan ?></th>
			<th width='50' align='center'><?= $detail->sisa ?></th>
			<th width='50' align='center'><?= $detail->jmlpisau ?></th>
			<th width='70' align='center'><?= number_format($detail->hargadeal) ?></th>
			</tr>
			<?}?>
						<tr>
			<th colspan='11' align='left'>Total Harga</th>
			<th width='70' align='center'><?= number_format($header->total_harga_penawaran) ?></th>
			</tr>

	</table>
		<br><br><br>
			<table id="tables" border="0" width='100%' align="center" cellpadding="2" cellspacing="0">
			<tr>
				<td width="185" align="center">Valid Until</td>
				<td width="185" align="center">Terms Of Payment</td>
				<td width="185" align="center" rowspan="2"><?= $header->pic_customer ?>,<?= $customer[0]->name_customer  ?></td>
			</tr>
			<tr>
				<td  align="center"><?= $header->valid_until ?></td>
				<td  align="center"><?= date_diff($tgl1,$tgl2)->d ?> Days</td>
			</tr>
			</table>
</div>