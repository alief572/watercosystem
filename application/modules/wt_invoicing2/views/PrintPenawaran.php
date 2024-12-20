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
            <img src='<?=$_SERVER['DOCUMENT_ROOT'];?>/demo_erp/assets/images/logo_waterco.png' alt="" height='100' width='250'>
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

<table border="0" width='100%' align="left">
<tr>
	<td width="350" align="left">
	<table>
	<tr>
		<td align='left'>No</td><td align='left'>:</td><td align='left'><?= $header->no_surat ?></td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>Jakarta,<?= date('d-F-Y') ?></td>
    </tr>
	<tr><td align='left'>Hal</td><td align='left'>:</td><td align='left'>Penawaran Produk Waterco</td></tr>
	</table>
</td>	
</tr>
<tr>
<?php
$customer =$this->db->query("SELECT * FROM master_customers WHERE id_customer='$header->id_customer'")->row();
?>
	<td width="350" align="left"><br><br>
	<table>
	<tr><td align='left'>Kepada Yth.</td></tr>
	<tr><td align='left'><?=$customer->name_customer?></td></tr>
	<tr><td align='left'>UP.&nbsp; Bpk/Ibu.<?=$header->pic_customer?></td></tr>
	<tr><td align='left'><?=$customer->address_office?></td></tr>
	<tr><td align='left'><?=$customer->zip_code?></td></tr>
	</table>
	<br><br>
	<table>
	<tr><td align='left'>Dengan Hormat,</td></tr>
	<tr><td align='left'></td></tr>
	<tr><td align='left'></td></tr>
	<tr><td align='left'>Berikut kami sampaikan penawaran produk waterco sesuai dengan spek yang Bpk/Ibu minta. </td></tr>
	<tr><td align='left'></td></tr>
	</table>
	</td>

</tr>
</table>

<br>
    <table id="tables" border="0" width='100%' align="left">
	<thead>
			<tr height = '60'>
			<th align="center" width="300">Type</th>
			<th align="center" width="60">Qty/Unit</th>
			<th align="center" width="60">Price/Unit</th>
			<th align="center" width="60">Discount</th>
			<th align="center" width="60">Status</th>
			<th align="center" width="120">Total Price</th>
			</tr>
			<tr></tr>

	</thead>    
	<tbody>
			<?	foreach($detail as $detail){
				if($header->order_status=='stk')
				{
					$sts ='Ready';
				}else
				{
					$sts ='Indent';
				}	
			?>
			<tr>
			<td align="left">&nbsp;<?= $detail->nama_produk ?></td>
			<td align="center"><?= $detail->qty ?></td>
			<td align="right"><?= number_format($detail->harga_satuan,2) ?></td>
			<td align="right"><?= number_format($detail->nilai_diskon,2) ?></td>
			<td align="center"><?= $sts ?></td>
			<td align="right"><?= number_format($detail->total_harga,2) ?></td>
			</tr>
			<?}?>
	</tbody>
	<tfoot>
			<tr>
			<th align="center" colspan='4' width="300" align='right'>Total</th>
			<th></th>
			<th align="right" width="120"><?= number_format($header->nilai_penawaran,2) ?></th>
			</tr>
			<tr>
			<th align="center" colspan='4' width="300" align='right'>PPN</th>
			<th  align="right"><?= $header->ppn ?>%</th>
			<th align="right" width="120"><?= number_format($header->nilai_ppn,2) ?></th>
			</tr>
			<tr>
			<th align="right" colspan='4' width="300" align='right'>Grand Total</th>
			<th></th>
			<th align="right" width="120"><?= number_format($header->grand_total,2) ?></th>
			</tr>
	</tfoot>
			
	</table>


	<table border="0" width='100%' align="left">

		<tr>
		
			<td width="350" align="left"><br><br>
			<table>
			<tr><td align='left'>Keterangan</td></tr>
			<tr><td align='right'>&#61;&#62;</td><td>Harga Franco Jakarta</td></tr>
			<tr><td align='right'>&#61;&#62;</td><td>Pembayaran, Waterco Indonesia BCA 87000-35990</td></tr>
			<tr><td align='right'>&#61;&#62;</td><td>Penawaran Sand Filter belum termasuk Silica filter</td></tr>
			<tr><td align='right'>&#61;&#62;</td><td>Pembayaran Cash/Transfer sebelum pengiriman</td></tr>
			<tr><td align='right'>&#61;&#62;</td><td>Penjualan unit waterco tidak termasuk supervisi dan testing & commissioning </td></tr>
			<tr><td align='right'>&#61;&#62;</td><td>Penawaran berlaku 2 minggu</td></tr>	
		</table>
			<br><br>
			<table>
			<tr><td align='left'>Demikian penawaran kami, atas perhatian kami ucapkan terima kasih. </td></tr>
			<tr><td align='left'></td></tr>
			</table>
			</td>

		</tr>
	</table>


	<table border="0" width='100%' align="left">

		<tr>
		
			<td width="350" align="left"><br><br>
			<table>
			<tr><td align='center'>Hormat kami,</td></tr>
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
			<tr><td align='center'><u>Anyim Dede</u> </td></tr>
			<tr><td align='center'>08179113323</td></tr>	
			</table>
			</td>
			<td width="350" align="left"><br><br>
			<table>
			<tr><td align='center'>Mengetahui</td></tr>
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
			<tr><td align='center'><u>Fajar Nugroho Widitanto</u></td></tr>
			<tr><td align='center'>General Manager</td></tr>	
			</table>
			</td>
		</tr>
	</table>