<html>
<head>
  <title>Cetak PDF</title>
<style>
    .header_style_company{
            padding: 15px;
            color: black;
            font-size: 20px;
            vertical-align:bottom;
        }
        .header_style_company2{
            padding: 15px;
            color: black;
            font-size: 15px;
            vertical-align:top;
        }

        .header_style_alamat{
            padding: 10px;
            color: black;
            font-size: 10px;
        }

        table.default {
            font-family: arial,sans-serif;
            font-size:9px;
            padding: 0px;
        }

        p{
            font-family: arial,sans-serif;
            font-size:14px;
        }
        
        .font{
            font-family: arial,sans-serif;
            font-size:14px;
        }

        table.gridtable {
            font-family: arial,sans-serif;
            font-size:10px;
            color:#333333;
            border: 1px solid #808080;
            border-collapse: collapse;
        }
        table.gridtable th {
            padding: 6px;
            background-color: #f7f7f7;
            color: black;
            border-color: #808080;
            border-style: solid;
            border-width: 1px;
        }
        table.gridtable th.head {
            padding: 6px; 
            background-color: #f7f7f7;
            color: black;
            border-color: #808080;
            border-style: solid;
            border-width: 1px;
        }
        table.gridtable td {
            border-width: 1px;
            padding: 6px;
            border-style: solid;
            border-color: #808080;
        }
        table.gridtable td.cols {
            border-width: 1px;
            padding: 6px;
            border-style: solid;
            border-color: #808080;
        }


        table.gridtable2 {
            font-family: arial,sans-serif;
            font-size:13px;
            color:#333333;
            border-width: 1px;
            border-color: #666666;
            border-collapse: collapse;
        }
        table.gridtable2 td {
            border-width: 1px;
            padding: 1px;
            border-style: none;
            border-color: #666666;
            background-color: #ffffff;
        }
        table.gridtable2 td.cols {
            border-width: 1px;
            padding: 1px;
            border-style: none;
            border-color: #666666;
            background-color: #ffffff;
        }

        table.gridtableX {
            font-family: arial,sans-serif;
            font-size:12px;
            color:#333333;
            border: none;
            border-collapse: collapse;
            margin-top:10px;
			vertical-align: top;
        }
        table.gridtableX td {
            border-width: 1px;
            padding: 2px;
        }
        table.gridtableX td.cols {
            border-width: 1px;
            padding: 2px;
        }

        table.gridtableX2 {
            font-family: arial,sans-serif;
            font-size:12px;
            color:#333333;
            border: none;
            border-collapse: collapse;
        }
        table.gridtableX2 td {
            border-width: 1px;
            padding: 2px;
        }
        table.gridtableX2 td.cols {
            border-width: 1px;
            padding: 2px;
        }

        #testtable{
            width: 100%;
        }

        .noneborder{
            border:none;
        }
        .nonebordercst{
            border-top:none;
            border-bottom:none;
        }
</style>
</head>
<body>
<?php
	foreach($header as $header){
	}
	// $jumlahdetail = $this->db->query("SELECT COUNT(no_penawaran) as no_penawaran FROM child_penawaran WHERE no_penawaran = '".$header->no_penawaran."' ")->result();
	// $jumlahdata = $jumlahdetail[0]->no_penawaran;
	// $tinggi = 300/$jumlahdata ;
?>

<table border="0" width='100%'>
    <tr>
        <td align="left">
            <img src='<?=$_SERVER['DOCUMENT_ROOT'];?>/metalsindo/assets/images/logo_metalsindo.jpeg' alt="" height='30' width='60'>
        </td>
        <td align="left">
            <h5 style="text-align: left;">PT METALSINDO PACIFIC</h5>
        </td>
    </tr>
</table>

<div style='display:block; border-color:none; background-color:#c2c2c2;' align='center'>
    <h3>QUOTATION</h3>
</div>

<table class='gridtableX' width='100%' cellpadding='0' cellspacing='0' border='0'>
    <tbody>
        <tr>
            <td width='510'>Address :</td>
			<td width='55'>Quote No</td>
			<td width='5'>:</td>
			<td width='110'><?= $header->no_surat ?></td>
        </tr>
        <tr>
            <td>Jl. Jababeka XIV, Blok J no. 10 H</td>
			<td>Date</td>
			<td>:</td>
			<td><?= date('d F Y', strtotime($header->tgl_penawaran)) ?></td>
        </tr>
        <tr>
            <td>Cikarang Industrial Estate, Bekasi 17530</td>
            <td></td>
        </tr>
		<tr>
            <td>Phone : (62-21) 89831726734, Fax : (62-21) 89831866</td>
            <td></td>
        </tr>
		<tr>
            <td>NPWP  : 21.098.204.7-414.000</td>
            <td></td>
        </tr>
    </tbody>
</table>
<table class='gridtableX' border="1px" cellspacing="0" width='100%' align="center">
<tr>
	<td width="380" align="center">
	<table width='380' align="center">
	<tr><td width='70' align="left">Customer</td><td width='10' align="left">:</td><td width='300' align="left"><?= $header->name_customer ?></td></tr>
	<tr><td width='70' align="left">Address</td><td width='10' align="left">:</td><td width='300' align="left"><?= $header->address_office ?></td></tr>
	<tr><td width='70' align="left">Phone</td><td width='10' align="left">:</td><td width='300' align="left"><?= $header->telephone ?></td></tr>
	<tr><td width='70' align="left">FAX</td><td width='10' align="left">:</td><td width='300' align="left"><?if(empty($header->fax)){echo"-";}else{echo"$header->fax";}  ?></td></tr>
	<tr><td width='70' align="left">U.P</td><td width='10' align="left">:</td><td width='300' align="left"><?= $header->pic_customer ?></td></tr>
	</table>
	</td>
</tr>
</table>
<br>
<?php 
if($header->mata_uang=='USD'){
	$kurs	= $this->db->query("SELECT * FROM mata_uang WHERE kode = 'IDR' ")->result();
	$nominal = $kurs[0]->kurs;
	?>
		<table class='gridtable'  cellpadding='0' cellspacing='0' width='100%' style='width:100% !important; vertical-align:top;'>
			<tbody>
				<tr style='vertical-align:middle; background-color:#c2c2c2; font-weight:bold;'>
					<td align="center" rowspan='2'>UNIT</td>
					<td align="center" rowspan='2'>PART</td>
					<td align="center" rowspan='2'>ITEM</td>
					<td width='90' align="center" colspan='5'>DESCRIPTION OF MERCHENDISE</td>
					<td width='50' align="center" colspan='2'>PRICE/KG</td>
					<td width='70' align="center" rowspan='2'>REMAKS</td>
				</tr>
				<tr style='vertical-align:middle; background-color:#c2c2c2; font-weight:bold;'>
					<td width='50' align="center">Aloy</td>
					<td width='22' align="center">Hard</td>
					<td width='22' align="center">Thick</td>
					<td width='22' align="center">Width</td>
					<td width='22' align="center">Lenght</td>
					<td width='22' align="center">USD</td>
					<td width='22' align="center">IDR</td>
				</tr>
				<?php
				$a=0;
				foreach($detail as $detail){$a++;
					$jumlahroll = $this->db->query("SELECT COUNT(no_penawaran) as no_penawaran FROM child_penawaran WHERE no_penawaran = '".$header->no_penawaran."' AND bentuk_material = 'ROLL' ")->result();
					$roll = $jumlahroll[0]->no_penawaran;
					?>
					<tr>
						<td width='40' align="center"><?= $detail->bentuk_material ?></td>
						<td width='100'><?= $detail->lotno ?></td>
						<td width='50'><?= $detail->nama2 ?></td>
						<td width='50' align='center'><?= $detail->spek ?></td>
						<td width='22' align='center'><?= $detail->hardness ?></td>
						<td width='22' align='center'><?=number_format($detail->thickness,2);?></td>
						<td width='22' align='center'><?=$detail->width;?></td>
						<td width='22' align='center'><?php if($detail->length <= 0){ echo"C";}else{echo number_format($detail->length,2);}; ?></td>
						
						<td width='22' align='right'>$ <?= number_format($detail->harga_dolar,2) ?></td>
						<td width='22' align='right'>Rp <?= number_format($detail->harga_penawaran_cust) ?></td>

						<td width='70' align='left'><?= $detail->keterangan ?></td>
					</tr>
					<?php
				}
				?>
				<tr>
					<td height='40' colspan='11'>Note : <br><br> <?= nl2br($header->note) ?></td>
				</tr>
			</tbody>
		</table>
	<?php
}
else{
	?>
		<table class='gridtable'  cellpadding='0' cellspacing='0' width='100%' style='width:100% !important; vertical-align:top;'>
			<tbody>
				<tr style='vertical-align:middle; background-color:#c2c2c2; font-weight:bold;'>
					<td align="center" rowspan='2'>UNIT</td>
					<td align="center" rowspan='2'>PART</td>
					<td align="center" rowspan='2'>ITEM</td>
					<td width='200' align="center" colspan='5'>DESCRIPTION OF MERCHENDISE</td>
					<td width='50' align="center" rowspan='2'>PRICE/KG</td>
					<td width='70' align="center" rowspan='2'>REMAKS</td>
				</tr>
				<tr style='vertical-align:middle; background-color:#c2c2c2; font-weight:bold;'>
					<td width='50' align="center">Aloy</td>
					<td width='22' align="center">Hard</td>
					<td width='22' align="center">Thick</td>
					<td width='22' align="center">Width</td>
					<td width='22' align="center">Lenght</td>
				</tr>
				<?php
				$a=0;
				foreach($detail as $detail){$a++;
					$jumlahroll = $this->db->query("SELECT COUNT(no_penawaran) as no_penawaran FROM child_penawaran WHERE no_penawaran = '".$header->no_penawaran."' AND bentuk_material = 'ROLL' ")->result();
					$roll = $jumlahroll[0]->no_penawaran;
					?>
					<tr>
						<td width='40' align="center"><?= $detail->bentuk_material ?></td>
						<td width='100'><?= $detail->lotno ?></td>
						<td width='50'><?= $detail->nama2 ?></td>

						<td width='50' align='center'><?= $detail->spek ?></td>
						<td width='22' align='center'><?= $detail->hardness ?></td>
						<td width='22' align='center'><?=number_format($detail->thickness,2);?></td>
						<td width='22' align='center'><?=$detail->width;?></td>
						<td width='22' align='center'><?php if($detail->length <= 0){ echo"C";}else{echo number_format($detail->length,2);}; ?></td>
						
						<td width='22' align='right'>Rp <?= number_format($detail->harga_penawaran_cust) ?></td>

						<td width='70' align='left'><?= $detail->keterangan ?></td>
					</tr>
					<?php
				}
				?>
				<tr>
					<td height='40' colspan='11'>Note : <br><br> <?= nl2br($header->note) ?></td>
				</tr>
			</tbody>
		</table>
	<?php
}
?>

<br>
<table class="gridtable" border="0" width='100%' cellpadding="1" cellspacing="0">
	<tr>
		<td width="152" align="center" style='padding-top:10px; padding-bottom:10px;'><b>Valid Until</b></td>
		<td width="152" align="center" style='padding-top:10px; padding-bottom:10px;'><b>Terms Of Payment</b></td>
		<td width="155" align="center"  style='padding-top:10px; padding-bottom:10px; vertical-align:middle;' rowspan="2"><b><?= $header->pengiriman ?>, <?php if($header->pengiriman == 'Loco'){
			echo"PT METALSINDO PACIFIC";
		}else{
			echo "$header->name_customer ";
		}?></b></td>
		<td width="152" align="center"  style='padding-top:10px; padding-bottom:10px;'><b>Exclude Of</b></td>
	</tr>
	<tr>
		<td  align="center" style='padding-top:10px; padding-bottom:10px;'><?= date('d F Y', strtotime($header->valid_until)) ?></td>
		<td  align="center" style='padding-top:10px; padding-bottom:10px;'><?= $header->terms_payment ?></td>
		<td  align="center" style='padding-top:10px; padding-bottom:10px;'>VAT <?= $header->exclude_vat ?> %</td>
	</tr>
</table>

<br><br>
<?php
$sroot = $_SERVER['DOCUMENT_ROOT'].'/metalsindo';
?>
<table  class="gridtableX" border="0" width='100%' align="center" cellpadding="1" cellspacing="0">
	<tr>
		<td width="85" align="center"></td>
		<td width="185" align="center"></td>
		<td width="185" align="center"></td>
		<td width="250" align="center"><b>FAITHFULLY YOURS,</b></td>
	</tr>
	<tr>
		<td  align="center" valign="middle" ></td>
		<td  align="center" valign="middle" ></td>
		<td  align="center" valign="middle" ></td>
		<td  align="center" valign="middle" ><img src='<?=$sroot;?>/assets/images/ttd_metalsindo.jpg' alt="" height='100' width='220'></td>
	</tr>
	<tr>
		<td  align="center" valign="middle" ></td>
		<td  align="center" valign="middle" ></td>
		<td  align="center" valign="middle" ></td>
		<td  align="center" valign="middle" ><b><u>Harry Widjaja</u></b></td>
	</tr>
	<tr>
		<td  align="center" valign="middle" ></td>
		<td  align="center" valign="middle" ></td>
		<td  align="center" valign="middle" ></td>
		<td  align="center" valign="middle" >President Director</td>
	</tr>
</table>