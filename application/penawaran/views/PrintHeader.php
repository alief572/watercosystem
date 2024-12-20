<html>
<head>
  <title>Cetak PDF</title>
<style>
    #tables td, th {
		border: 1px solid grey;
        padding: 0 px;
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
?>
<div id='wrapper'>
<table border="0" width='100%' align="center">
<tr>
	<td width="700" align="center">
		<h3 style="text-align: left;">PT METALSINDO PASIFICx</h3>
	</td>
</tr>
</table>
<table id="tables" border="0" width='100%' align="center">
<tr>
	<td width="700" align="left">
		<h5 style="text-align: center;">Quotation</h5>
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
<table border="1px" cellspacing="0" width='100%' align="center">
<tr>
	<td width="380" align="center">
	<table width='380' align="center">
	<tr><td width='70' align="left">Customer</td><td width='10' align="left">:</td><td width='300' align="left"><?= $header->name_customer ?></td></tr>
	<tr><td width='70' align="left">Address</td><td width='10' align="left">:</td><td width='300' align="left"><?= $header->address_office ?></td></tr>
	<tr><td width='70' align="left">Phone</td><td width='10' align="left">:</td><td width='300' align="left"><?= $header->telephone ?></td></tr>
	<tr><td width='70' align="left">FAX</td><td width='10' align="left">:</td><td width='300' align="left"><?if(empty($header->fax)){echo"-";}else{echo"$header->fax";}  ?></td></tr>
	<tr><td width='70' align="left">U.P</td><td width='10' align="left">:</td><td width='300' align="left"><?= $header->pic_customer ?></td></tr>
	</table>
	</td>
</tr>
</table>
<br>
<?php if($header->mata_uang=='USD'){
	$kurs	= $this->db->query("SELECT * FROM mata_uang WHERE kode = 'IDR' ")->result();
	$nominal = $kurs[0]->kurs;
	?>
	<table id="tables" border="0" width='100%' align="center" cellpadding="0" cellspacing="0">
			<tr>
			<th rowspan='2' align="center" width="50">Unit</th>
			<th rowspan='2' align="center" width="100">Part</th>
			<th rowspan='2' align="center" width="75">Item</th>
			<th colspan='4' align="center" >Description Of Merchendise</th>
			<th colspan='2' align="center" >Price/Kg</th>
			<th rowspan='2' align="center" width="100">Remark</th>
			</tr>
			<tr>
			
			<th width="60" align="center">Aloy</th>
			<th width="60" align="center">Hardness<</th>
			<th width="60" align="center">Thickness</th>
			<th width="60" align="center">Width</th>
			<th width="60" align="center">USD</th>
			<th width="60" align="center">IDR</th>
			</tr>
			<?	foreach($detail as $detail){?>
			<tr>
			<td align="center" ><?= $detail->bentuk_material ?></td>
			<td align="center"><?= $detail->lotno ?></td>
			<td align="center"><?= $detail->nama2 ?></td>
			<td align="center"><?= $detail->nama3 ?></td>
			<td width="60" align="center"><?= $detail->hardness ?></td>
			<td width="60" align="center"><?= $detail->nilai ?></td>
			<td width="60" align="center"><?= $detail->width ?></td>
			<td width="60" align="center">$ <?= number_format($detail->harga_dolar,2) ?></td>
			<td width="60" align="center">Rp <?= number_format($detail->harga_penawaran) ?></td>
			<td width="60" align="center"><?= $detail->keterangan ?></td>
			</tr>
			<?}?>
			<tr>
			<td align="center">Note</td>
			<td width="645" colspan='9'><textarea id="note" name="note" class='form-control col-md-12' rows="4" cols="2000"><?= $header->note ?></textarea></td>
			</tr>

	</table>
	<?php }else{ ?>
		<table id="tables" border="0" width='100%' align="center" cellpadding="0" cellspacing="0">
			<tr>
			<th rowspan='2' align="center" width="50">Unit</th>
			<th rowspan='2' align="center" width="100">Part</th>
			<th rowspan='2' align="center" width="75">Item</th>
			<th colspan='4' align="center" >Description Of Merchendise</th>
			<th rowspan='2' align="center" width="120">Price/Kg</th>
			<th rowspan='2' align="center" width="100">Remark</th>
			</tr>
			<tr>
			
			<th width="60" align="center">Aloy</th>
			<th width="60" align="center">Hardness<</th>
			<th width="60" align="center">Thickness</th>
			<th width="60" align="center">Width</th>
			</tr>
			<?	foreach($detail as $detail){?>
			<tr>
			<td align="center"><?= $detail->bentuk_material ?></td>
			<td align="center"><?= $detail->lotno ?></td>
			<td align="center"><?= $detail->nama2 ?></td>
			<td align="center"><?= $detail->nama3 ?></td>
			<td align="center"><?= $detail->hardness ?></td>
			<td align="center"><?= $detail->nilai ?></td>
			<td align="center"><?= $detail->width ?></td>
			<td align="center">Rp <?= number_format($detail->harga_penawaran,2) ?></td>
			<td align="center"><?= $detail->keterangan ?></td>
			</tr>
			<?}?>
			<tr>
			<td align="center">Note</td>
			<td width="645" colspan='9'><textarea id="note" name="note" class='form-control col-md-12' readonly rows="4" cols="2000"><?= $header->note ?></textarea></td>
			</tr>
	</table>
	<?php } ?>
	<br><br><br>
			<table id="tables" border="0" width='100%' align="center" cellpadding="2" cellspacing="0">
			<tr>
				<td width="185" align="center">Valid Until</td>
				<td width="185" align="center">Terms Of Payment</td>
				<td width="185" align="center" rowspan="2"><?= $header->name_customer ?></td>
				<td width="185" align="center" rowspan="2">Exclude vat <?= $header->exclude_vat ?> %</td>
			</tr>
			<tr>
				<td  align="center"><?= $header->valid_until ?></td>
				<td  align="center"><?= $header->terms_payment ?> Days</td>
			</tr>
			</table>
</div>