
<?php
	$tanggal = date('Y-m-d');
foreach ($head as $val =>$head){
}	

foreach ($hutang as $val =>$hutang){
}

//print_r($supplier);
//exit;

?>


<html>
 <head>
  <title> PO REQUEST PAYMENT</title>
 </head>
<body>
<style>
body{
	font-family: sans-serif;
}
table.garis {
	border-collapse: collapse;
	font-size: 0.9em;
	font-family: sans-serif;
}


</style>
<table cellpadding=2 cellspacing=0 border=0 width=650>
<tr>
	<th colspan=8>PO REQUEST PAYMENT <br> &nbsp;</th>
	<th></th>
	<th></th>
	
</tr>
<tr>
	<th>NO PO </th>
	<th>:</th>
	<th width=300  align="left"><?= html_escape($head->no_surat) ?></th>
</tr>
<tr>
	<th>NO INCOMING </th>
	<th>:</th>
	<th width=300  align="left"><?= html_escape($hutang->id_incoming) ?></th>
</tr>
<tr>
	<th>SUPPLIER</th>
	<th>:</th>
	<th width=300  align="left"><?= html_escape($supplier[0]->name_suplier) ?></th>
	
</tr>
<tr>
	<th>TGL REQUEST</th>
	<th>:</th>
	<th width=300  align="left"><?= html_escape($hutang->tgl_request_bayar) ?></th>
	
</tr>
&nbsp;</br>
<tr>
	<td colspan=8>
	<table cellpadding=2 cellspacing=0 border=1 width=650 class="garis">
	<tr>
	    <th nowrap>Mata Uang</th>
		<th nowrap>Total PO</th>
		<th nowrap>Nilai Hutang USD</th>
		<th nowrap>Nilai Hutang IDR</th>
		<th nowrap>Nilai Request Bayar</th>
	</tr>
	
		<tr>
		    <td align='center'><?= html_escape(strtoupper(strtolower($hutang->matauang))) ?></td>
			<td align='right'><?= html_escape(number_format((float)$head->subtotal,2)) ?></td>
			<td align='right'><?= html_escape(number_format((float)$hutang->hutang_kurs,2)) ?></td>
			<td align='right'><?= html_escape(number_format((float)$hutang->hutang_idr,2)) ?></td>
			<td align='right'><?= html_escape(number_format((float)$hutang->rencana_bayar_idr,2)) ?></td>
			
		</tr>
		<?php
			
	for($x=0;$x<4;$x++){
	echo '
		<tr>
			<td>&nbsp;</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			
		</tr>
	';
	}
	?>
	

<tr>
	<td colspan=2 align=center>Mengajukan</td>
	
	<td align=center colspan=2>Mengetahui</td>
	
	<td align=center>Menyetujui</td>
</tr>
<tr height=120>
	<td colspan=2 align=center nowrap valign="bottom" width=100></u><br /></td>
	<td colspan=2 align=center nowrap valign="bottom" width=120>
	<u>&nbsp;  &nbsp;</u><br /></td>
	<td align=center nowrap valign="bottom"><u>&nbsp; &nbsp; &nbsp; &nbsp; </u><br /></td>
</tr>
</table>

<br />

</body>
</html>



				  
				  
		 