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
	<td align="left" valign="top" font-size='11px'>SPK No.</td><td align="left" valign="top">:</td><td align="left" valign="top">_________________________</td>
	<td align="left" valign="top" font-size='11px'>SPK RECEIVING DATE</td><td align="left" valign="top">:</td><td align="left" valign="top">_________________</td>
	<td align="center" border='1' width='70' rowspan='5' valign="middle">Total Process (Jam/ Menit)</td><td align="center"   border='1' width='50' valign="top">Operator</td>
</tr>
<tr>
	<td align="left" valign="top">PROCESS DATE   </td><td align="left" valign="top">:</td><td align="left" valign="top">_________________________</td>
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
	<td align="center"  border='1' width='50' valign="top">Satori</td>
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
	<td align="center"><?= $tr_spk->sisa*$tr_spk->density*$tr_spk->thickness*$tr_spk->panjang/1000 ?></td>
	<td align="center"><?= number_format($tr_spk->qcoil) ?></td>
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
	<td width="80" rowspan='2' align="center">Process Name</td>
	<td width="40" rowspan='2' align="center">Start</td>
	<td width="40" rowspan='2' align="center">Finish</td>
	<td width="40" rowspan='2' align="center">Total</td>
</tr>
<tr>
	<td width="30" align="center">DEl</td>
	<td width="30" align="center">STO</td>
	<td width="40" align="center">NO Area</td>
	<td width="40" align="center">Hold Area</td>
</tr>
<tr>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td align="left">1. MAT'L  CHANGE </td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td align="left">2. SETTING KNIVE </td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td align="left">3. SETT UP</td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td align="left">4. QC  CHECKING</td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td align="left">5. SETT UP</td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td align="left">6. QC  CHECKING</td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td align="left">7. SLITTING PROCESS</td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td align="left">8. QC  CHECKING</td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td align="left">9. SLITTING PROCESS</td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td align="left">10. QC  CHECKING</td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td align="left">11. Handling</td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td align="left">12. ....... </td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td colspan='4' align="left">GRAND TOTAL (Jam/Menit)</td>
</tr>
<tr>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td colspan='4' align="left">Remarks<textarea cols='30'></textarea></td>
</tr>
<tr>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td align="left">1. MAT'L  CHANGE </td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td align="left">2. SETTING KNIVE </td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td align="left">3. SETT UP</td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td align="left">4. QC  CHECKING</td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td align="left">5. SETT UP</td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td align="left">6. QC  CHECKING</td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td align="left">7. SLITTING PROCESS</td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td align="left">8. QC  CHECKING</td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td align="left">9. SLITTING PROCESS</td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td align="left">10. QC  CHECKING</td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td align="left">11. Handling</td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td align="left">12. ....... </td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<tr>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td colspan='4' align="left">GRAND TOTAL (Jam/Menit)</td>
</tr>
<tr>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td colspan='4' align="left">Remarks<textarea cols='30'></textarea></td>
</tr>
<tr border='0'>
	<td colspan="3">Roll</td>
	<td align="left"></td>
	<td colspan="11" rowspan='8'>&nbsp;Note: <br> &nbsp; DEL = Delivery/kirim  <br>&nbsp; STO = Stock/Finished goods &nbsp; <br>   &nbsp; P1, P2,..       = Paralel dengan proses no.1, paralel dengan proses no. 2s,dst
HANDLING <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TYPE A  .Angkat coil  dan simpan ke pallet pakai hoist<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TYPE B  .Angkat coil pakai hoist dan simpan ke pallet tidak pakai hoist/manual	<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TYPE C  .Angkat coil dan simpan ke pallet tidak pakai hoist/manual	
	</td>
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