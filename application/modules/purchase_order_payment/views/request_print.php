
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

<?php

$noexpense = $data->no_doc;
$bank = $data->bank_nama;
$bk = $this->db->query("SELECT nama FROM gl_waterco_dev.coa_master WHERE no_perkiraan='$bank'")->row();
$nama = $bk->nama;
$tgl = $data->tgl_doc;
$informasi = $data->informasi;

$idsupp = $head->id_suplier;

$nm = $this->db->query("SELECT * FROM master_supplier WHERE id_suplier='$idsupp'")->row();
$nm_supp = $nm->name_suplier;

?>
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
	<th width=300  align="left"><?= $head->no_surat ?></th>
</tr>
<tr>
	<th>NO INCOMING </th>
	<th>:</th>
	<th width=300  align="left"><?= $hutang->id_incoming ?></th>
</tr>
<tr>
	<th>SUPPLIER</th>
	<th>:</th>
	<th width=300  align="left"><?= $nm_supp ?></th>
	
</tr>
<tr>
	<th>TGL REQUEST</th>
	<th>:</th>
	<th width=300  align="left"><?= $hutang->tgl_request_bayar ?></th>
	
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
		    <td align='center'><?= strtoupper(strtolower($hutang->matauang)) ?></td>
			<td align='right'><?= number_format($head->subtotal,2) ?></td>
			<td align='right'><?= number_format($hutang->hutang_kurs,2) ?></td>
			<td align='right'><?= number_format($hutang->hutang_idr)?></td>
			<td align='right'><?= number_format($hutang->rencana_bayar_idr,2)?></td>
			
		</tr>
		<?php
			
	for($x=0;$x<(5-$i);$x++){
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



				  
				  
		 