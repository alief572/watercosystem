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
<h5 align="center">SALES ORDER</h5>
<?php
$customer =$this->db->query("SELECT * FROM master_customers WHERE id_customer='$header->id_customer'")->row();
$pic =$this->db->query("SELECT * FROM child_customer_pic WHERE id_customer='$header->id_customer'")->row();
$top =$this->db->query("SELECT * FROM ms_top WHERE id_top='$header->top'")->row();
?>
<table border="0" width='100%' align="left">

<tr>
	<td width="350" align="left">
	<table>
	
	<tr>
		<td align='left'>A.H</td><td align='left'>:</td><td align='left'><?=$header->nama_sales?></td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left' width="150">To :</td>
	</tr>
	
	<tr>
		<td align='left'>No</td><td align='left'>:</td><td align='left'><?= $header->no_surat ?></td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left' width="150"><?=$customer->name_customer?></td>
    </tr>
	<tr>
		<td align='left'>Date</td><td align='left'>:</td><td align='left'><?= date('d-F-Y', strtotime($header->tgl_so)) ?></td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left' width="150"><?=$customer->address_office?></td>
	</tr>
	
	<tr>
		<td align='left'>No. Reff / PO.</td><td align='left'>:</td><td align='left'><?= $header->nomor_penawaran ?></td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left' width="150"></td>
	</tr>
	<tr>
		<td align='left'>Tgl PO.</td><td align='left'>:</td><td align='left'><?= date('d-F-Y', strtotime($header->tgl_penawaran)) ?></td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left' width="150">Att.&nbsp; Bpk/Ibu.<?=$pic->name_pic?></td>
	</tr>
	
	</table>
</td>	
</tr>
</table>

<br>
    <table id="tables" border="0" width='100%' align="left">
	<thead>
			<tr height = '60'>
			<th align="center" width="30">No</th>	
			<th align="center" width="500">Type</th>			
			<th align="center" width="60">Discount</th>
			<th align="center" width="60">Quantity</th>
			</tr>
			<tr></tr>

	</thead>    
	<tbody>
			<?	$no=0; foreach($detail as $detail){
				
				$no++;
				
				if($header->order_status=='stk')
				{
					$sts ='Ready';
				}else
				{
					$sts ='Indent';
				}	
			?>
			<tr>
			<td align="center">&nbsp;<?= $no ?></td>
			<td align="left">&nbsp;<?= $detail->nama_produk ?></td>
			<td align="center"><?= number_format($detail->diskon,2) ?></td>
			<td align="center"><?= number_format($detail->qty_so) ?> &nbsp;Unit</td>			
			</tr>
			<?}?>
	</tbody>
			
	</table>


	<table border="0" width='100%' align="left">

		<tr>
		
			<td width="250" align="left"><br><br>
			<table>
			<tr><td align='center'>Prepared By,</td></tr>
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
			<tr><td align='center'><u>Jackeline Ivonne</u></td></tr>
			<tr><td align='center'>Administration</td></tr>	
			</table>
			</td>
			<td width="250" align="left"><br><br>
			<table>
			<tr><td align='center'>Request & Checked By,</td></tr>
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
			<tr><td align='center'><u><?=$header->nama_sales?></u></td></tr>
			<tr><td align='center'>Account Handler</td></tr>		
			</table>
			</td>
			<td width="250" align="left"><br><br>
			<table>
			<tr><td align='center'>Approved By,</td></tr>
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
			<tr><td align='center'><u>(........................)</u></td></tr>
			<tr><td align='center'>Finance</td></tr>	
			</table>
			</td>
		</tr>
	</table>