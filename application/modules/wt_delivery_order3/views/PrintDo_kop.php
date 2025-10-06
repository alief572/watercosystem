<html>
<head>
  <title>Cetak PDF</title>
<style>

	body
        {
            width:100%;
            font-family:Arial;
            font-size:12pt;
            margin:0;
            padding:0;
        }
		
	hr {
		
		border: 1px ;
		height: 3px solid ;
		
	}
	
    #tables td, th {
		border: 1px solid;
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

<h5 align="center">DELIVERY ORDER</h5>
<?php
$customer =$this->db->query("SELECT * FROM master_customers WHERE id_customer='$header->id_customer'")->row();
$top =$this->db->query("SELECT * FROM ms_top WHERE id_top='$header->top'")->row();

$spk  =$this->db->query("SELECT * FROM tr_spk_delivery WHERE no_spk='$header->no_spk'")->row();
$reff =$this->db->query("SELECT * FROM tr_sales_order WHERE no_so='$spk->no_so'")->row();

$tgl=$header->tgl_do;
?>
<table border="0" width='100%' align="left">

<tr>
	<td width="350" align="left">
	<table>
	
	<tr>
		<td align='left'>Date</td><td align='left'>:</td><td align='left'><?= date('d-F-Y', strtotime($header->tgl_do)) ?></td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left' width="150">Kepada Yth.</td>
    </tr>
	<tr>
		<td align='left'>No DO.</td><td align='left'>:</td><td align='left'><?= $header->no_surat?></td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left' width="150"><?=$customer->name_customer?></td>
	</tr>
	<tr>
		<td align='left'>No Invoice.</td><td align='left'>:</td><td align='left'><?= $header->no_invoice?></td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left' width="200"><?=ucwords(strtolower($header->location))?></td>
	</tr>
	<tr>
		<td align='left'>No PO.</td><td align='left'>:</td><td align='left'><?=$reff->reff?></td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left' width="150">Att.&nbsp; Bpk/Ibu.<?=$header->pic_customer?></td>
	</tr>
	
	<tr>
		<td align='left'></td><td align='left'></td><td align='left'></td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left' width="150">Telp.&nbsp; <?=$customer->telephone?></td>
	</tr>
	<tr>
		<td align='left'></td><td align='left'></td><td align='left'></td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left' width="150"></td>
	</tr>
	</table>
</td>	
</tr>
</table>

<br>
    <table id="tables" border="1" width='100%' align="left">
	<thead>
			<tr height = '60' border="1">
            <th align="center" width="20" border="1">No</th>
			<th align="center" width="300" border="1">Produk</th>
			<th align="center" width="100" border="1">Kode Barang</th>
			<th align="center" width="30" border="1">Qty</th>
			<th align="center" width="100" border="1">Serial Number</th>
			<th align="center" width="100" border="1">No Kartu Garansi</th>
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
            <td align="center"><?= $no ?></td>
			<td align="left">&nbsp;<?= $detail->nama_produk ?></td>
			<td align="left">&nbsp;<?= $detail->kode_barang ?></td>
			<td align="center"><?= number_format($detail->qty_do) ?></td>
			<td align="left"><?= $detail->serial_number ?></td>
			<td align="left"><?= $detail->kartu_garansi ?></td>
			</tr>
			<?}?>
	</tbody>
            

</table>



<table border="0" width='100%' align="left">
    <tr>

        <td width="150" align="left"><br><br>
        <table>
        <tr><td align='center'>Dibuat Oleh,</td></tr>
        <tr><td align='right'></td></tr>
        <tr><td align='right'></td></tr>
        <tr><td align='right'></td></tr>
        <tr><td align='right'></td></tr>
        <tr><td align='right'></td></tr>
        <tr><td align='right'></td></tr>
        <tr><td align='right'></td></tr>
        <tr><td align='right'></td></tr>
        <tr><td align='right'></td></tr>
        <tr><td align='right'></td></tr>
        <tr><td align='right'></td></tr>
        <tr><td align='right'></td></tr>
        <tr><td align='right'></td></tr>
        <tr><td align='right'></td></tr>
        <tr><td align='right'></td></tr>
        <tr><td align='right'></td></tr>
        <tr><td align='center'><u><?='(-------------------------)'?></u> </td></tr>
        <tr><td align='center'></td></tr>	
        </table>
        </td>
        <td width="250" align="left"><br><br>
        <table>
        <tr><td align='center'>Menyetujui</td></tr>
        <tr><td align='right'></td></tr>
        <tr><td align='right'></td></tr>
        <tr><td align='right'></td></tr>
        <tr><td align='right'></td></tr>
        <tr><td align='right'></td></tr>
        <tr><td align='right'></td></tr>
        <tr><td align='right'></td></tr>
        <tr><td align='right'></td></tr>
        <tr><td align='right'></td></tr>
        <tr><td align='right'></td></tr>
        <tr><td align='right'></td></tr>
        <tr><td align='right'></td></tr>
        <tr><td align='right'></td></tr>
        <tr><td align='right'></td></tr>
        <tr><td align='right'></td></tr>
        <tr><td align='right'></td></tr>
        <tr><td align='center'><u><?='(-------------------------)'?></u></td></tr>
        <tr><td align='center'></td></tr>	
        </table>
        </td>
        <td width="250" align="left"><br><br>
        <table>
        <tr><td align='center'>Ekspedisi</td></tr>
        <tr><td align='right'></td></tr>
        <tr><td align='right'></td></tr>
        <tr><td align='right'></td></tr>
        <tr><td align='right'></td></tr>
        <tr><td align='right'></td></tr>
        <tr><td align='right'></td></tr>
        <tr><td align='right'></td></tr>
        <tr><td align='right'></td></tr>
        <tr><td align='right'></td></tr>
        <tr><td align='right'></td></tr>
        <tr><td align='right'></td></tr>
        <tr><td align='right'></td></tr>
        <tr><td align='right'></td></tr>
        <tr><td align='right'></td></tr>
        <tr><td align='right'></td></tr>
        <tr><td align='right'></td></tr>
        <tr><td align='center'><u><?='(-------------------------)'?></u></td></tr>
        <tr><td align='center'></td></tr>	
        </table>
        </td>
        <table>
        <tr><td align='center' border='1'>Barang diterima dengan baik
        </td></tr>
        </table>
        <td width="200" align="left"><br><br>
        <table>
        <tr><td align='center'>Diterima Oleh</td></tr>
        <tr><td align='right'></td></tr>
        <tr><td align='right'></td></tr>
        <tr><td align='right'></td></tr>
        <tr><td align='right'></td></tr>
        <tr><td align='right'></td></tr>
        <tr><td align='right'></td></tr>
        <tr><td align='right'></td></tr>
        <tr><td align='right'></td></tr>
        <tr><td align='right'></td></tr>
        <tr><td align='right'></td></tr>
        <tr><td align='right'></td></tr>
        <tr><td align='right'></td></tr>
        <tr><td align='right'></td></tr>
        <tr><td align='right'></td></tr>
        <tr><td align='right'></td></tr>
        <tr><td align='right'></td></tr>
        <tr><td align='center'><u><?='(-------------------------)'?></u></td></tr>
        <tr><td align='center'></td></tr>	
        </table>
        </td>    
    </tr>
    <tr>
        <td width="800" align="left"><br><br>
        <table border='1'>
        <tr><td align='center'>CATATAN : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <br><br><br></td></tr>
        </table>
        </td>
    </tr>
</table>


