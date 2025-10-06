<html>
<head>
  <title>Cetak PDF</title>
<style>
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
<table border="0px" cellspacing="0" width='100%' valign="top">
    <tr>
        <td align="left"width="70%" valign="top" >           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
<h5 align="center">SALES INVOICE</h5>
<?php
$customer =$this->db->query("SELECT * FROM master_customers WHERE id_customer='$header->id_customer'")->row();
$pic =$this->db->query("SELECT * FROM child_customer_pic WHERE id_customer='$header->id_customer'")->row();
$top =$this->db->query("SELECT * FROM ms_top WHERE id_top='$header->top'")->row();
?>
<table border="0" width='100%' align="left" valign="top">

<tr>
	<td width="350" align="left" valign="top">
	<table>
	
	<tr>
		<td align='left' valign="top">No</td><td align='left' valign="top">:</td><td align='left' valign="top"><?= $header->no_surat ?></td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left' width="200">Jakarta,<?=  date('d-F-Y', strtotime($header->tgl_invoice))  ?></td>
    </tr>
	<tr>
		<td align='left' valign="top">Your Reff.</td><td align='left' valign="top">:</td><td width="200" align='left' valign="top"><?=$header->referensi?></td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left' width="200" valign="top">Kepada Yth.</td>
	</tr>
	<tr>
		<td align='left' valign="top">Marketing.</td><td align='left' valign="top">:</td><td align='left' valign="top"><?=$header->nama_sales?></td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left' width="200"><?=$customer->name_customer?></td>
	</tr>
	<tr>
		<td align='left'>Term Of Payment.</td><td align='left'>:</td><td align='left'><?=$top->nama_top?></td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left' width="200" valign="top"><?=$customer->address_office?></td>
	</tr>
	<tr>
		<td align='left'></td><td align='left'></td><td align='left'></td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left' width="200"><?=$customer->telephone?></td>
	</tr>
	<tr>
		<td align='left'>Tgl Jatuh Tempo.</td><td align='left'>:</td><td align='left'><?= date('d-F-Y', strtotime($header->jatuh_tempo)) ?></td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left' width="200">Att.&nbsp; Bpk/Ibu.<?=$pic->name_pic?></td>
	</tr>
	<tr>
		<td align='left'>No Faktur</td><td align='left'>:</td><td align='left'><?=$header->no_faktur?></td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='left' width="200">Telp.&nbsp; <?=$customer->telephone?></td>
	</tr>
	</table>
</td>	
</tr>
</table>

<br>
   <table id="tables" border="0" width='100%' align="left">
	<thead>
			<tr height = '60'>
			<th align="center" width="20">No</th>
			<th align="center" width="60">Code</th>
			<th align="center" width="190">Description</th>
			<th align="center" width="60">Quantity</th>
			<th align="center" width="60">Price/Unit</th>
			<th align="center" width="60">Percent</th>
			<th align="center" width="60">Discount</th>
			<th align="center" width="120">Amount</th>
			</tr>
			<tr></tr>

	</thead>    
	<tbody>
			<?php

			$no = 0;
			foreach($detail as $detail){
			$no++;
			$kode = $this->db->query("SELECT * from ms_inventory_category3 where id_category3 = '$detail->id_category3'")->row();
			?>
			<tr>
			<td align="left">&nbsp;<?= $no ?></td>
			<td align="left">&nbsp;<?= $kode->kode_barang ?></td>
			<td align="left" width="190">&nbsp;<?= $detail->nama_produk ?></td>
			<td align="center"><?= $detail->qty_invoice ?></td>
			<td align="right"><?= number_format($detail->harga_satuan) ?></td>
			<td align="right"><?= number_format($detail->diskon) ?></td>
			<td align="right"><?= number_format($detail->nilai_diskon) ?></td>
			<td align="right"><?= number_format($detail->total_harga) ?></td>
			</tr>
			<?}?>
	</tbody>
	<tfoot>
	        
			<tr>
			<th align="center" colspan='6' width="300" align='right'>&nbsp;</th>
			<th></th>
			<th align="right" width="120">&nbsp;</th>
			</tr>
			<tr>
			<th align="center" colspan='6' width="300" align='right'>&nbsp;</th>
			<th></th>
			<th align="right" width="120">&nbsp;</th>
			</tr>
			<tr>
			<th align="center" colspan='6' width="300" align='right'>DPP</th>
			<th></th>
			<th align="right" width="120"><?= number_format($header->nilai_produk) ?></th>
			</tr>
			<tr>
			<th align="center" colspan='6' width="300" align='right'>PPN</th>
			<th  align="right"><?= $header->ppn ?>%</th>
			<th align="right" width="120"><?= number_format($header->nilai_ppn) ?></th>
			</tr>
			<tr>
			<th align="right" colspan='6' width="300" align='right'>Total</th>
			<th></th>
			<th align="right" width="120"><?= number_format($header->grand_total) ?></th>
			</tr>
			<tr>
			<th align="right" colspan='6' width="300" align='right'><?=$header->payment?>&nbsp;<?=$header->persentase?>%</th>
			<th></th>
			<th align="right" width="120"><?= number_format($header->nilai_invoice) ?></th>
			</tr>
			<tr>
			<th align="right" colspan='6' width="300" align='right'>Total Invoice</th>
			<th></th>
			<th align="right" width="120"><b><?= number_format($header->nilai_invoice) ?></b></th>
			</tr>

			<tr>
			<th align="left" colspan='8' width="300" align='left'><i>In Word : <?= ucwords(ynz_terbilang_format($header->nilai_invoice))?>&nbsp;Rupiah</i></th>
			</tr>
	</tfoot>
			
	</table>

<br><br>
	<table border="0" width='100%' align="left">

		<tr>
		
			<td width="350" align="left" border='0.5'>
			<table>
			<tr><td align='left'>Keterangan</td></tr>
			<tr><td align='left'>&#61;&#62;Barang Kena Pajak</td></tr>
			<tr><td align='left'>&#61;&#62;Barang Yang sudah dibeli tidak bisa ditukar/dikembalikan</td></tr>
			<tr><td align='left'>&#61;&#62;Kwitansi ini dianggap sah bila ada pembayaran</td></tr>
			<tr><td align='left'>&#61;&#62;Pembayaran dapat dilakukan dengan transfer/setoran tunai melalui bank</td></tr>
			<tr><td align='left'>&#61;&#62;Apabila sudah transfer/setor tunai diharapkan konfirmasi/fax bukti transfer</td></tr>
			<tr><td align='left'>&#61;&#62;Faktur pajak dikirimkan bulan berikutnya via email</td></tr>	
			</table>
			</td>
			<td width="100" align="left" border='0.5'>
			<table>
			<tr><td align='left'>Pembayaran dilakukan melalui rekening :</td></tr>
			<tr><td align='left'><b>CIMB Niaga cabang kelapa gading</b></td></tr>
			<tr><td align='left'><b>No A/C. 8000-9570-4600(IDR)</b></td></tr>
			<tr><td align='left'>&nbsp;</td></tr>
			<tr><td align='left'><b>BCA cabang kelapa gading square</b></td></tr>
			<tr><td align='left'><b>No A/C. 870-003-599-0(IDR)</b></td></tr>
			<tr><td align='left'><b>On Behalf PT. WATERCO INDONESIA</b></td></tr>
			</table>
			</td>

		</tr>
	</table>
    <br>
	<br>

	<table border="0" width='100%' align="left">

		<tr>
		
			<td width="350" align="left" border='0'>
			<table>
			<tr><td align='left'>Note:</td></tr>
			<tr><td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			</td></tr>
			<tr><td align='left'>&nbsp;</td></tr>
			<tr><td align='left'>&nbsp;</td></tr>
			<tr><td align='left'>&nbsp;</td></tr>
			<tr><td align='left'>&nbsp;</td></tr>	
			</table>
			</td>
			<td width="100" align="left" border='0'>
			<table>
			<tr><td align='center'></td></tr>
			<tr><td align='left'>&nbsp;</td></tr>
			<tr><td align='left'>&nbsp;</td></tr>
			<tr><td align='left'>&nbsp;</td></tr>
			<tr><td align='left'>&nbsp;</td></tr>
			<tr><td align='left'>&nbsp;</td></tr>
			<tr><td align='center'></td></tr>
			</table>
			</td>
			<td width="100" align="left" border='0'>
			<table>
			<tr><td align='center'>Hormat Kami,</td></tr>
			<tr><td align='left'>&nbsp;</td></tr>
			<tr><td align='left'>&nbsp;</td></tr>
			<tr><td align='left'>&nbsp;</td></tr>
			<tr><td align='left'>&nbsp;</td></tr>
			<tr><td align='left'>&nbsp;</td></tr>
			<tr><td align='center'>Finance</td></tr>
			</table>
			</td>

		</tr>
	</table>