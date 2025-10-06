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
            <img src='<?=$_SERVER['DOCUMENT_ROOT'];?>waterco/assets/images/logo_waterco.png' alt="" height='100' width='250'>
        </td>
        <td align="right" valign="top" width="30%">
			<br>
            PT WATERCO INDONESIA<br>
            Inkopal Plaza Kelapa Gading Blok B, No.31-32 <br> 
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			Jl. Boulevard Barat, Jakarta-14240, Indonesia<br>
			Phone: +62 21 4585 1481, Fax: +62 21 4585 1480<br>
			Website: www.waterco.co.id<br>
            E-Mail:waterco@waterco.co.id
            
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
	<?php if($header->revisi !='0'){ ?>
	<tr><td align='left'>Revisi</td><td align='left'>:</td><td align='left'><?=$header->revisi?></td></tr>
	<?php }?>
	</table>
</td>	
</tr>
<tr>
<?php
$customer =$this->db->query("SELECT * FROM master_customers WHERE id_customer='$header->id_customer'")->row();
$pic =$this->db->query("SELECT * FROM child_customer_pic WHERE id_customer='$header->id_customer'")->row();
$sales =$this->db->query("SELECT * FROM ms_karyawan WHERE id_karyawan='$header->id_sales'")->row();

?>
	<td width="350" align="left"><br><br>
	<table>
	<tr><td align='left'>Kepada Yth.</td></tr>
	<tr><td align='left'><?=$customer->name_customer?></td></tr>
	<tr><td align='left'>UP.&nbsp; Bpk/Ibu.&nbsp;<?=$pic->name_pic?></td></tr>
	<tr><td align='left'  width="250"><?=$customer->address_office?></td></tr>
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
			<th align="center" width="200">Type</th>
			<th align="center" width="60">Qty/Unit</th>
			<th align="center" width="60">Price/Unit</th>
			<th align="center" width="60">Discount</th>
			<th align="center" width="60">Status</th>
			<th align="center" width="60">Total Price</th>
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
			<td align="left" width="200"><?= $detail->nama_produk ?></td>
			<td align="center" width="60"><?= $detail->qty ?></td>
			<td align="right" width="100"><?= number_format($detail->harga_satuan,2) ?></td>
			<td align="right" width="100"><?= number_format($detail->nilai_diskon,2) ?></td>
			<td align="center" width="60"><?= $sts ?></td>
			<td align="right" width="100"><?= number_format($detail->total_harga,2) ?></td>
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
		
			<td width="250" align="left"><br><br>
			<table>
			<tr><td align='center'>Hormat kami,</td></tr>
			<tr><td align="center"width="70%" valign="top" >
            <img src='<?=$_SERVER['DOCUMENT_ROOT'];?>waterco/assets/files/tandatangan/<?=$sales->tanda_tangan?>' alt="" height='80' width='100'>
			</td></tr>
			<tr><td align='center'><u><?=$header->nama_sales?></u> </td></tr>
			<tr><td align='center'><?=$sales->nohp?></td></tr>	
			</table>
			</td>
			<td width="250" align="left"><br><br>
			<table>
			<tr><td align='center'>Mengetahui</td></tr>
			<tr><td align="center"width="70%" valign="top" >
			 <img src='<?=$_SERVER['DOCUMENT_ROOT'];?>waterco/assets/files/tandatangan/Cap_Waterco_dan_ttd_-_Fajar.png' alt="" height='80' width='100'>
			</td></tr>
			<tr><td align='center'><u>Fajar Nugroho Widyanto</u></td></tr>
			<tr><td align='center'>General Manager</td></tr>	
			</table>
			</td>
			<td width="250" align="left"><br><br>
			<table>
			<tr><td align='center'>Customer</td></tr>
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
			<tr><td align='center'><u></u></td></tr>
			<tr><td align='center'><?=$customer->name_customer?></td></tr>	
			</table>
			</td>
		</tr>
	</table>