<html>
<head>
  <title>Cetak PDF</title>
<style type='text/css'>
table {
  border-collapse: collapse;
}

.garis {
  border: 1px solid black;
}
</style>
</head>
<body>
<?php
	foreach($header as $header){
	}
?>
<div id='wrapper'>
<div id='layout'>
<table rules='none' width='100%' align='center'> 
<tr>
<td colspan='2'>
	<table rules='none' width='100%'>
	<tr>
	<td align='left'>
	<label>PT METALSINDO PASIFIC</label>
	</td>
	</tr>
	</table>
</td>
</tr>
<tr>
<td colspan='2' align='center'>
	<table border='2' rules='none' width='100%'>
	<tr>
	<td align='center'>
	<label>Quotation</label>
	</td>
	</tr>
	</table>
</td>
</tr>
<tr>
<td>
	<table>
	<tr><td align='left'>Address</td></tr>
	<tr><td align='left'>Jl. Jababeka XIV, Blok J no. 10 H</td></tr>
	<tr><td align='left'>Cikarang Industrial Estate, Bekasi 17530</td></tr>
	<tr><td align='left'>PHONE:(62-21)89831726734,FAX(62-21)89831866</td></tr>
	<tr><td align='left'>NPWP:	21.098.204.7-414.000</td></tr>
	</table>
</td>
<td>
	<table>
	<tr><td align='left'>Quote no</td><td align='left'>:</td><td align='left'><?= $header->no_surat ?></td></tr>
	<tr><td align='left'>Date</td><td align='left'>:</td><td align='left'><?= $header->tgl_penawaran ?></td></tr>
	</table>
</td>
</tr>
<tr>
<td colspan='2' align='center'  >
	<table border='1' rules='none' width='50%'>
	<tr><td align='left'>Custommer</td><td align='left'>:</td><td align='left'><?= $header->name_customer ?></td></tr>
	<tr><td align='top'>Address</td><td align='left'>:</td><td align='left' wordwrap='breakdown'><?= $header->address_office ?></td></tr>
	<tr><td align='left'>Phone</td><td align='left'>:</td><td align='left'><?= $header->telephone ?></td></tr>
	<tr><td align='left'>FAX</td><td align='left'>:</td><td align='left'><?= $header->fax ?></td></tr>
	</table>
</td>
</tr>
<tr> 
<td colspan='2'>
	<table width='100%' class='garis'>
			<tr>
			<td rowspan='2'><center>Unit</center></td>
			<td rowspan='2'><center>Part</center></td>
			<td rowspan='2'><center>Item</center></td>
			<td colspan='4'><center>Description Of Merchendise</center></td>
			<td colspan='2'><center>Price</center></td>
			<td rowspan='2'><center>Remark</center></td>
			</tr>
			<tr>
			
			<td><center>Aloy</center></td>
			<td><center>Hardness</center></td>
			<td><center>Thickness</center></td>
			<td><center>Width</center></td>
			<td><center>USD</center></td>
			<td><center>IDR</center></td>
			</tr>
	</table>
</td>
</tr>
<tr>
<td colspan='2'>
<label>Note</label>
</td>
</tr>
</table>
</div>
</div>