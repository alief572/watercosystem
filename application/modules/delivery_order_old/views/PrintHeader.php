<html>
<head>
  <title>Cetak PDF</title>
<style>
    #tables td, th {
		border: 1px solid #000000;
        padding: 2 px;
		font-size: 11px;
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
	// $jumlahdetail = $this->db->query("SELECT COUNT(no_penawaran) as no_penawaran FROM child_penawaran WHERE no_penawaran = //'".$header->no_penawaran."' ")->result();
	// $jumlahdata = $jumlahdetail[0]->no_penawaran;
	// $tinggi = 300/$jumlahdata ;
?>
<div id='wrapper'>
<table border="0" width='100%' align="center">
<tr>
	<td width="700" align="center">
		<h4 style="text-align: left;">PT METALSINDO PACIFIC</h4>
	</td>
</tr>
</table>
<table id="tables" bgcolor="#c9c9c9" border="0" width='100%' align="center" cellpadding="2" cellspacing="0">
<tr>
	<td width="700" align="left">
		<h4 style="text-align: center;">DELIVERY ORDER</h4>
	</td>
</tr>
</table>
<table border="0" width='100%' align="center">
<tr>
	<td width="700" align="left">
		<h5 style="text-align: center;">NO : <?= $header->no_surat ?> </h5>
	</td>
</tr>

</table>
<table border="0" width='100%' align="center">
<tr>
	<td width="350" align="left">
	Address <br>
	Jl. Jababeka XIV, Blok J no. 10 H <br>
	Cikarang Industrial Estate, Bekasi 17530<br> 
	PHONE:(62-21)89831726734,FAX(62-21)89831866<br>
	NPWP:	21.098.204.7-414.000
	</td>
	<td width="350" align="left">
	
	To<br>
	<?= $header->name_customer ?><br>
	Address<br>
	<?= $header->address_office?>
	</td>
</tr>
<tr>
	<td width="350" align="left">
	</td>
	<td width="350" align="left">	
	REFF :
	<u><?= $header->reff ?></u>
	</td>
</tr>
</table>
<br>

<table border="0" width='100%' align="center">
<tr>
	<td width="700" align="left">
	   Harap barang-barang tersebut dibawah ini supaya diterima dengan baik sesuai dengan surat pesanan.<br>
	<i>(Please receive this good mentioned with gently care as an order)</i>
	</td>
</tr>
</table>
<br>

<table id="tables" border="1px" width='50%' align="center" cellpadding="2" cellspacing="0">
<tr>
	<th width="350" align="left">
	Supir : <?=$header->driver?> 
	</th>
	<th width="350" align="left">
	No Kendaraan : <?=$header->nopol?> 
	</th>
</tr>
</table>

<br>

	<table id="tables" border="1px" width='100%' align="center" cellpadding="2" cellspacing="0">
			<tr>
			<th bgcolor="#c9c9c9" rowspan='2' align="center" valign="middle"  width="50">NO</th>
			<th bgcolor="#c9c9c9"  rowspan='2' align="center" valign="middle"  width="100">GOOD OF MERCHANDISE</th>
			<th bgcolor="#c9c9c9" rowspan='2' align="center" valign="middle"  width="50">SPEC</th>
			<th bgcolor="#c9c9c9" rowspan='2' align="center" valign="middle" width="150" >LOT NO ALLOY</th>
			<th bgcolor="#c9c9c9"rowspan='2' align="center" valign="middle" width="100" >LOT NO SLIT</th>
			<th bgcolor="#c9c9c9" colspan='3' align="center" valign="middle"  width="100">QUANTITY</th>
			<th bgcolor="#c9c9c9" rowspan='2' align="center" valign="middle" width="50">REMARK PALLET NO</th>
			</tr>
			<tr>
			
			<th bgcolor="#c9c9c9" width="60" align="center">COIL'S</th>
			<th bgcolor="#c9c9c9" width="50" align="center">SHEET'S<</th>
			<th bgcolor="#c9c9c9" width="50" align="center">KG'S</th>
			
			</tr>
			<?php
                $no=0;
                foreach($detail as $detail){
				$no++;
				$bentuk = $detail->bentuk;
				// $jumlahroll = $this->db->query("SELECT COUNT(no_penawaran) as no_penawaran FROM child_penawaran WHERE no_penawaran = '".$header->no_penawaran."' AND bentuk_material = 'ROLL' ")->result();
				// $roll = $jumlahroll[0]->no_penawaran;
			?>
			<tr>
			<td align="center" ><?= $no ?></td>
			<td align="center"><?= $detail->id_material ?></td>
			<td align="center"><?= $detail->no_alloy ?></td>
			<td width="50" align="center"><?= $detail->lotno ?></td>
			<td width="50" align="center"><?= $detail->lot_slitting ?></td>
			<td width="50" align="center">
			<?php if($bentuk =='B2000001'){ 
			      echo $detail->qty_mat;
			} ?>
			</td>
			<td width="50" align="center">
			<?php if($bentuk =='B2000002'){ 
			      echo $detail->qty_mat;
			} ?>
			</td>
			<td width="60" align="center"><?= $detail->weight_mat   ?></td>
			<td width="60" align="center"><?= $detail->remark ?></td> 
			</tr>
			<?php }
			?>
			

	</table>
	<br><br><br>
	        <table border="0" width='100%' align="center" cellpadding="1" cellspacing="0">
			<tr>
				<td width="230" align="center"></td>
				<td width="230" align="center"></td> 
				<td width="230" align="center">Cikarang,<?php echo date('d-m-Y')?></td>
			</tr>
			</table>
			<table border="0" width='100%' align="center" cellpadding="1" cellspacing="0">
			<tr>
				<td width="230" align="center"><br>YANG MENERIMA<br><i>(RECEIVED BY)</i><br><br><br><br><br><br><br><br></td>
				<td width="230" align="center"><br>DIPERIKSA<br><i>(CHECKED BY)</i></td> 
				<td width="230" align="center">Cikarang,<?php echo date('d-m-Y')?><br>HORMAT KAMI<br><i>(YOURS FAITHFULLY)</i></td>
			</tr>
			</table>
</div>