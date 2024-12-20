<html>
<head>
  <title>Cetak PDF</title>
<style>
    #tables td, th {
		border: 1px solid grey;
        padding: 0 px;
		font-size: 12px;
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
<table border="0px" cellspacing="0" width='100%' valign="top">
    <tr>
        <td align="left"width="70%" valign="top" >
            <img src='<?=$_SERVER['DOCUMENT_ROOT'];?>/waterco/assets/images/logo_waterco.png' alt="" height='100' width='250'>
        </td>
        <td align="right" valign="top" width="30%">
			<br>
            PT WATERCO INDONESIA<br>
            Inkopal Plaza Kelapa Gading Blok B, No.31-32 <br> 
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			Jl. Boulevard Barat Kelapa Gading Jakarta Utara 14240<br>
            Email:anyimdede18@gmail.com/anyim.dede@waterco.co.id<br>
            Telp. 021-45851480 Hp. 08179113323, 081384388864
        </td>
    </tr>
</table>
<hr>

<table border="0" width='100%' align="center">
<tr>
	<td align="center"><h5> SPK DELIVERY <br> No. <?= $header->no_surat ?> </h5></td>	
</tr>
</table>

<br>
    <table id="tables" border="0" width='100%' align="left">
	<thead>
			<tr height = '60'>
            <th align="center" width="20">No</th>
			<th align="center" width="220">Produk</th>
			<th align="center" width="30">Qty</th>
			<th align="center" width="60">Ket Kirim</th>
			<th align="center" width="100">Serial Number</th>
			<th align="center" width="100">No Kartu Garansi</th>
			</tr>
			<tr></tr>

	</thead>    
	<tbody>
			<?	
               $n0 =0;
               foreach($detail as $detail){
				$no++;
			?>
			<tr>
            <td align="left"><?= $no ?></td>
			<td align="left" width="220">&nbsp;<?= $detail->nama_produk ?></td>
			<td align="left"><?= $detail->qty_delivery ?></td>
			<td align="left"><?= ucwords($detail->keterangan_kirim)  ?></td>
			<td align="left"></td>
			<td align="left"></td>
			</tr>
			<?}?>
	</tbody>
            

</table>