<html>
<head>
  <title>Cetak PDF</title>
<style>
    #tables td, th {
		border: 1px solid #808080;
        padding: 2 px;
		border-collapse: collapse;
		font-size: 11px;
    }
	.clearth{
		border: 0px;
		border-collapse: collapse;
		font-size: 11px;
	}
	#cleartables td, th {
		border: 0px solid #808080;
        padding: 2 px;
		border-collapse: collapse;
		font-size: 11px;
    }
	.clearth{
		border: 0px;
		border-collapse: collapse;
		font-size: 11px;
	}
</style>
</head>
<body>
<?php
	foreach($header as $tr_spk){
	}
?>
<table border="0"  align="center"  width='100%' >
<tr>
	<td width="700" align="left" valign="top">
		<h5 style="text-align: left;">PT. METALSINDO PACIFIC</h5>
	</td>
</tr>
	<tr>
	<td width="700" align="center" valign="top">
		<h4 style="text-align: center;">LAPORAN HARIAN KERJA PRODUKSI</h4>
	</td>
</tr>
</table>

<table id="cleartables" border="0" align="center"  width='100%' cellspacing="0" cellpadding="2" >
<tr>
	<td align="left" valign="top" font-size='11px'>SPK No.</td><td align="left" valign="top">:</td><td align="left" valign="top">&nbsp;<?=$tr_spk->no_surat_produksi?></td>
	<td align="left" valign="top" font-size='11px'>SPK RECEIVING DATE</td><td align="left" valign="top">:</td><td align="left" valign="top">_________________</td>
	<td align="center" border='1' width='70' rowspan='5' valign="middle">Total Process (Jam/ Menit)</td><td align="center"   border='1' width='50' valign="top">Operator</td>
</tr>
<tr>
	<td align="left" valign="top">PROCESS DATE   </td><td align="left" valign="top">:</td><td align="left" valign="top">&nbsp;<?= $tr_spk->tgl_produksi ?></td>
	<td align="left" valign="top">PROD. PROCESS NAME</td><td align="left" valign="top">:</td><td align="left" valign="top">_________________</td>
	<td align="center"  border='1' rowspan='3'  width='70' valign="top"></td>
</tr>
<tr>
	<td align="left" valign="top">CUSTOMER</td><td align="left" valign="top">:</td><td align="left" valign="top">_________________________</td>
	<td align="left" valign="top">TYPE KNIVE </td><td align="left" valign="top">:</td><td align="left" valign="top">_________________</td>
</tr>
<tr>
	<td align="left" valign="top">PO NO.</td><td align="left" valign="top">:</td><td align="left" valign="top">_________________________</td>
	<td align="left" valign="top">SPEED KONTROL </td><td align="left" valign="top">:</td><td align="left" valign="top">________________</td>
</tr>
<tr>
	<td align="left" valign="top">STATUS </td><td align="left" valign="top">:</td><td align="left" valign="top">
	<table>
	<tr>
	<td align="left" valign="top">SALES</td>	<td align="left" valign="top">____</td>
	<td align="left" valign="top">SERVICES</td> <td align="left" valign="top">____</td>
	
	</tr>
	</table>
	</td>
	<td align="left" valign="top">PERSENELING  </td><td align="left" valign="top">:</td><td align="left" valign="top">________________</td>
	<td align="center"  border='1' width='50' valign="top"></td>
</tr>
</table>
<table border="0"  align="center"  width='100%' >
	<tr>
	<td width="700" align="center" valign="top">
	ORIGIN MATERIAL
	</td>
</tr>
</table>
<table id="tables" border="0" width='100%' align="center" cellpadding="2" cellspacing="0">
	<tr>
	<td width="200" align="center">Material Name</td>
	<td width="50" align="center">THICK</td>
	<td width="50" align="center">WIDTH</td>
	<td width="50" align="center">*QTY (kg)</td>
	<td width="50" align="center">QTY (COIL) </td>
	<td width="200" align="center">LOT NO.</td>
	<td width="100" align="center">SUPPLIER</td>
</tr>
	<tr>
	<td align="center"><?= $tr_spk->nama_material ?></td>
	<td align="center"><?= $tr_spk->thickness ?></td>
	<td align="center"><?= $tr_spk->width ?></td>
	<td align="center"><?= $tr_spk->weight ?></td>
	<td align="center"><?= number_format(1) ?></td>
	<td align="center"><?= $tr_spk->lotno ?></td>
	<td align="center"></td>
</tr>
</table>
<table border="0"  align="center"  width='100%' >
	<tr>
	<td width="700" align="center" valign="top">
	PRODUCTION PROCESS
	</td>
</tr>
</table>


<table id="tables" border="0" width='100%' align="center" cellpadding="2" cellspacing="0">
	<tr>
	<td width="40" rowspan='2' align="center">SIZE</td>
	<td width="40" rowspan='2' align="center">Coil No</td>
	<td width="40" rowspan='2' align="center">Width</td>
	<td width="40" rowspan='2' align="center">QTY (Kg/ Sheet)</td>
	<td width="40" rowspan='2' align="center">Total QTY (Kg)</td>
	<td align="center" colspan='4'>Storage Status</td>
	<td width="60" rowspan='2' align="center">Desription</td>
	<td width="70" rowspan='2' align="center">For Custommer</td>
	
</tr>
<tr>
	<td width="30" align="center">DEl</td>
	<td width="30" align="center">STO</td>
	<td width="40" align="center">NO Area</td>
	<td width="40" align="center">Hold Area</td>
</tr>
<?php
$no=0;
	foreach($detail as $dt_spk){
		
?>

<tr>
	<td></td>
	<td align='center'><?= $dt_spk->lot_slitting ?></td>
	<td align='center'><?= number_format($dt_spk->weight) ?></td>
	<td align='center'><?= number_format($dt_spk->width) ?></td>
	<td align='center'><?= number_format($dt_spk->width) ?></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	
</tr>
<?php
	}
?>

</table>


<table border="0"  align="center"  width='100%' >
	<tr>
	<td width="700" align="center" valign="top">
	TIME PROCESS
	</td>
</tr>
</table>

<?php

$id = $this->uri->segment(3);
$MATL1 = $this->db->query("SELECT * FROM dt_spk_produksi_lph WHERE id_proses='MATL1' AND id_spk_aktual='$id'")->row();
$SETTING1 = $this->db->query("SELECT * FROM dt_spk_produksi_lph WHERE id_proses='SETTING1' AND id_spk_aktual='$id'")->row();
$SETTUP1 = $this->db->query("SELECT * FROM dt_spk_produksi_lph WHERE id_proses='SETTUP1' AND id_spk_aktual='$id'")->row();
$QC1 = $this->db->query("SELECT * FROM dt_spk_produksi_lph WHERE id_proses='QC1' AND id_spk_aktual='$id'")->row();
$SETTUP2 = $this->db->query("SELECT * FROM dt_spk_produksi_lph WHERE id_proses='SETTUP2' AND id_spk_aktual='$id'")->row();
$QC2 = $this->db->query("SELECT * FROM dt_spk_produksi_lph WHERE id_proses='QC2' AND id_spk_aktual='$id'")->row();
$SLITTING1 = $this->db->query("SELECT * FROM dt_spk_produksi_lph WHERE id_proses='SLITTING1' AND id_spk_aktual='$id'")->row();
$QC3 = $this->db->query("SELECT * FROM dt_spk_produksi_lph WHERE id_proses='QC3' AND id_spk_aktual='$id'")->row();
$SLITTING2 = $this->db->query("SELECT * FROM dt_spk_produksi_lph WHERE id_proses='SLITTING2' AND id_spk_aktual='$id'")->row();
$QC4 = $this->db->query("SELECT * FROM dt_spk_produksi_lph WHERE id_proses='QC4' AND id_spk_aktual='$id'")->row();
$HANDLING1 = $this->db->query("SELECT * FROM dt_spk_produksi_lph WHERE id_proses='HANDLING1' AND id_spk_aktual='$id'")->row();


$totalmenit = $MATL1->total + $SETTING1->total + $SETTUP1->total + $QC1->total + $SETTUP2->total + $QC2->total + $SLITTING1->total + $QC3->total + $SLITTING2->total + $QC4->total + $HANDLING1->total;
?>

<table id="tables" border="0" width='100%' align="center" cellpadding="2" cellspacing="0">
	<tr>
    <td width="150" align="center">Process Name</td>
	<td width="50" align="center">Start</td>
	<td width="50" align="center">Finish</td>
	<td width="50" align="center">Total</td>
   </tr>
   <tr>
   <td>MATL  CHANGE</td>
   <td align='center'><?=$MATL1->start ?></td> 
   <td align='center'><?=$MATL1->finish ?></td> 
   <td align='center'><?=$MATL1->total ?></td>
   </tr>
  <tr>
   <td>SETTING KNIVE</td>
   <td align='center'><?=$SETTING1->start ?></td> 
   <td align='center'><?=$SETTING1->finish ?></td> 
   <td align='center'><?=$SETTING1->total ?></td>
   </tr>
   <tr>
   <td>SETT UP</td>
   <td align='center'><?=$SETTUP1->start ?></td> 
   <td align='center'><?=$SETTUP1->finish ?></td> 
   <td align='center'><?=$SETTUP1->total ?></td>
   </tr>
   <tr>
   <td>QC  CHECK SETTING</td>
   <td align='center'><?=$QC1->start ?></td> 
   <td align='center'><?=$QC1->finish ?></td> 
   <td align='center'><?=$QC1->total ?></td>
   </tr>
    <tr>
   <td>SETT UP</td>
   <td align='center'><?=$SETTUP2->start ?></td> 
   <td align='center'><?=$SETTUP2->finish ?></td> 
   <td align='center'><?=$SETTUP2->total ?></td>
   </tr>
   <tr>
   <td>QC  CHECK AWAL</td>
   <td align='center'><?=$QC2->start ?></td> 
   <td align='center'><?=$QC2->finish ?></td> 
   <td align='center'><?=$QC2->total ?></td>
   </tr>
    <tr>
   <td>SLITTING PROCESS</td>
   <td align='center'><?=$SLITTING1->start ?></td> 
   <td align='center'><?=$SLITTING1->finish ?></td> 
   <td align='center'><?=$SLITTING1->total ?></td>
   </tr>
    <tr>
   <td>QC  CHECK TENGAH</td>
   <td align='center'><?=$QC3->start ?></td> 
   <td align='center'><?=$QC3->finish ?></td> 
   <td align='center'><?=$QC3->total ?></td>
   </tr>
    <tr>
   <td>SLITTING PROCESS</td>
   <td align='center'><?=$SLITTING2->start ?></td> 
   <td align='center'><?=$SLITTING2->finish ?></td> 
   <td align='center'><?=$SLITTING2->total ?></td>
   </tr>
    <tr>
   <td>QC  CHECK AKHIR</td>
   <td align='center'><?=$QC4->start ?></td> 
   <td align='center'><?=$QC4->finish ?></td> 
   <td align='center'><?=$QC4->total ?></td>
   </tr>
    <tr>
   <td>HANDLING</td>
   <td align='center'><?=$HANDLING1->start ?></td> 
   <td align='center'><?=$HANDLING1->finish ?></td> 
   <td align='center'><?=$HANDLING1->total ?></td>
   </tr>
   
    <tr>
	<td colspan='3' align="left">GRAND TOTAL (Jam/Menit)</td>
	<td align='center' ><?= $totalmenit ?></td>
    </tr>
   
   
</table>



 
 
 

<table id="tables3" border="0" width='100%' align="center" cellpadding="2" cellspacing="0">
<tr>
	
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td align="left">Remarks<textarea cols='30'></textarea></td>
</tr>
<tr>
</tr>

<tr border='0'>
	<td colspan="3"  valign="top">Roll</td>
	<td align="left" valign="top"></td>
	<td colspan="8" rowspan='8' valign="top">&nbsp;&nbsp;Note: <br> &nbsp; DEL &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;= Delivery/kirim  <br>&nbsp; STO &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; = Stock/Finished goods &nbsp; <br>   &nbsp; P1, P2,..       = Paralel dengan proses no.1, paralel dengan proses no. 2s,dst
HANDLING <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TYPE A  .Angkat coil  dan simpan ke pallet pakai hoist<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TYPE B  .Angkat coil pakai hoist dan simpan ke pallet tidak pakai hoist/manual	<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TYPE C  .Angkat coil dan simpan ke pallet tidak pakai hoist/manual	
	</td>
</tr>
<tr>
	<td colspan="3"></td>
	<td align="left"></td>
</tr>
<tr>
	<td colspan="3"></td>
	<td align="left"></td>
</tr>
<tr>
	<td colspan="3"></td>
	<td align="left"></td>
</tr>
<tr>
	<td colspan="3"></td>
	<td align="left"></td>
</tr>
<tr>
	<td colspan="3"></td>
	<td align="left"></td>
</tr>
<tr>
	<td colspan="3"></td>
	<td align="left"></td>
</tr>
<tr>
	<td colspan="3"></td>
	<td align="left"></td>
</tr>
<tr>
	<td colspan="3"></td>
	<td align="left"></td>
</tr>

<tr>
	<td colspan="3"></td>
	<td align="left"></td>
</tr>
<tr>
	<td colspan="3"></td>
	<td align="left"></td>
</tr>
<tr>
	<td colspan="3"></td>
	<td align="left"></td>
</tr>
<tr>
	<td colspan="3"></td>
	<td align="left"></td>
</tr>
<tr>
	<td colspan="3">Internal</td>
	<td align="left"></td>
</tr>
<tr>
	<td colspan="3">Eksternal</td>
	<td align="left"></td>
</tr>
<tr>
	<td colspan="3">TOTAL PRODUKSI</td>
	<td align="left"></td>
</tr>
<tr>
	<td colspan="3">RETURN TO</td>
	<td align="left"></td>
</tr>
<tr>
	<td colspan="3">STOCK W/H</td>
	<td align="left"></td>
</tr>
<tr>
	<td colspan="3">DIFFEREANCE</td>
	<td align="left"></td>
</tr>
<tr>
	<td colspan="3">BALANCE</td>
	<td align="left"></td>
</tr>
</table>

