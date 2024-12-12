<html>
<head>
  <title>Cetak PDF</title>
<style>
    #tables td, th {
		border: 1px solid #808080;
        padding: 2 px;
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
	foreach($header as $tr_spk){
	}
?>
<table border="0">
<tr>
	<td width="30" align="left"></td>
	<td width="220" align="left" valign="top">
		<h3 style="text-align: left;">SPK Produksi</h3>
	</td>
</tr>
</table>

<table border="0" align="left">
<tr>
	<td width="30" align="left"></td>
	<td width="100" align="left" valign="top">	No. SPK</td>
	<td width="50" align="left" valign="top">	: </td>
	<td width="150" align="left" valign="top"><?= $tr_spk->no_surat ?></td>
	<td width="200" align="center" valign="top"></td>
	<td width="100" align="center" valign="top">Plan Produksi</td>
	<td width="50" align="center" valign="top">:</td>
	<td width="150" align="center" valign="top"><?= $tr_spk->tgl_spk_produksi ?></td>
	<td width="300" align="center" valign="top"></td>
</tr>
</table>
<table border="0">
<tr>
	<td width="30" align="left"></td>
	<td width="220" align="left" valign="top">
		<h5 style="text-align: left;">A. Material</h5>
	</td>
</tr>
</table>
<table id="tables" border="0" width='100%' align="center" cellpadding="2" cellspacing="0">
  			<tr>
			<td width="50" align="center">No</td>
			<td width="400" align="center">Nomor. Lot</td>
			<td width="200" align="center">Nama Material</td>
			<td width="80" align="center">Berat Mother coil</td>
			<td width="80" align="center">Density</td>
			<td width="80" align="center">Thikness</td>
			<td width="80" align="center">Panjang Mother Coil</td>
			<td width="80" align="center">Width Mother Coil</td>
			</tr>
 			<tr>
			<td align="center">1</td>
			<td align="center"><?= $tr_spk->lotno ?></td>
			<td align="center"><?= $tr_spk->nama_material ?></td>
			<td align="center"><?= $tr_spk->weight ?></td>
			<td align="center"><?= $tr_spk->density ?></td>
			<td align="center"><?= $tr_spk->thickness ?></td>
			<td align="center"><?= $tr_spk->panjang ?></td>
			<td align="center"><?= $tr_spk->width ?></td>
			</tr>
	</table>
<table border="0">
<tr>
	<td width="30" align="left"></td>
	<td width="220" align="left" valign="top">
		<h5 style="text-align: left;">B. Produksi</h5>
	</td>
</tr>
</table>
<table id="tables" border="0" width='100%' align="center" cellpadding="2" cellspacing="0">
			<tr>
			<td rowspan='2' width="50" align="center">No</td>
			<td rowspan='2' width="200" align="center"s>Nomor. SO</td>
			<td rowspan='2' width="250" align="center">Customer</td>
			<td rowspan='2' width="120" align="center">Nomor Alloy</td>
			<td rowspan='2' width="60" align="center">Thickness</td>
			<td rowspan='2' width="60" align="center">Weight / Coil</td>
			<td colspan='2' align="center">Qty Coil</td>
			<td colspan='2' align="center">Total Wight</td>
			<td rowspan='2' width="70" align="center">Delivery Date</td>
			
			</tr>
			<tr>

			<td width="60" align="center">Order</td>
			<td width="60" align="center">Aktual</td>
			<td width="60" align="center">Order</td>
			<td width="60" align="center">Aktual</td>
			
			</tr>
			<?php $loop=0;
			foreach ($detail as $dt_spk){$loop++; 
			$customers = $this->db->query("SELECT * FROM master_customers WHERE id_customer ='$dt_spk->idcustomer' ")->result();
			$name_customer=$customers[0]->name_customer;
			$qtycoil = number_format($dt_spk->qtycoil);
		echo "
		<tr>
			<td align='center'>$loop</td>
			<td align='center'>$dt_spk->no_surat</td>
			<td align='center'>$name_customer</td>
			<td align='center'>$dt_spk->nmmaterial</td>
			<td align='center'>$dt_spk->thickness</td>
						<td align='center'>$dt_spk->width</td>

			<td align='center'>$qtycoil</td>
			<td align='center'></td>

			<td align='center'>$dt_spk->totalwidth</td>
						<td align='center'></td>
			<td align='center'>$dt_spk->delivery</td>
		</tr>
		";
			}
			?>
	</table>
	<table border="0">
	<tr>
	<td width="30" align="left"></td>
	<td width="110" align="left" valign="top">Lebar Pegangan</td>
	<td width="0" align="left" valign="top">:</td>
	<td width="110" align="left" valign="top"><?= number_format($tr_spk->lpegangan) ?></td>
	</tr>
	<tr>
	<td width="30" align="left"></td>
	<td width="110" align="left" valign="top">Qty Coil Hasil</td>
	<td width="0" align="left" valign="top">:</td>
	<td width="110" align="left" valign="top"><?= number_format($tr_spk->qcoil) ?></td>
	</tr>
	<tr>
	<td width="30" align="left"></td>
	<td width="110" align="left" valign="top">Jml Pisau</td>
	<td width="0" align="left" valign="top">:</td>
	<td width="110" align="left" valign="top"><?= number_format($tr_spk->jpisau) ?></td>
	</tr>
	<tr>
	<td width="30" align="left"></td>
	<td width="110" align="left" valign="top">Sisa Potongan</td>
	<td width="0" align="left" valign="top">:</td>
	<td width="110" align="left" valign="top">Lebar Planing</td>
	<td width="0" align="left" valign="top">:</td>
	<td width="220" align="left" valign="top"><?= $tr_spk->sisa ?></td>
	<td width="110" align="left" valign="top">Berat Planing</td>
	<td width="0" align="left" valign="top">:</td>
	<td width="220" align="left" valign="top"><?= $tr_spk->sisa*$tr_spk->density*$tr_spk->thickness*$tr_spk->panjang/1000 ?></td>
	</tr>
		<tr>
	<td width="30" align="left"></td>
	<td width="110" align="left" valign="top"></td>
	<td width="30" align="left" valign="top"></td>
	<td width="110" align="left" valign="top">Lebar Aktual</td>
	<td width="0" align="left" valign="top">:</td>
	<td width="220" align="left" valign="top">_____________________</td>
	<td width="110" align="left" valign="top">Berat Aktual</td>
	<td width="0" align="left" valign="top">:</td>
	<td width="220" align="left" valign="top">_____________________</td>
	</tr>
	<tr>
	<td width="30" align="left"></td>
	<td width="110" align="left" valign="top">Scrap</td>
	<td width="0" align="left" valign="top">:</td>
	<td width="110" align="left" valign="top">Lebar Planing</td>
	<td width="0" align="left" valign="top">:</td>
	<td width="220" align="left" valign="top"><?= $tr_spk->lpegangan ?></td>
	<td width="110" align="left" valign="top">Berat Planing</td>
	<td width="0" align="left" valign="top">:</td>
	<td width="220" align="left" valign="top"><?= $tr_spk->lpegangan*$tr_spk->density*$tr_spk->thickness*$tr_spk->panjang/1000 ?></td>
	</tr>
		<tr>
	<td width="30" align="left"></td>
	<td width="110" align="left" valign="top"></td>
	<td width="30" align="left" valign="top"></td>
	<td width="110" align="left" valign="top">Lebar Aktual</td>
	<td width="0" align="left" valign="top">:</td>
	<td width="220" align="left" valign="top">_____________________</td>
	<td width="110" align="left" valign="top">Berat Aktual</td>
	<td width="0" align="left" valign="top">:</td>
	<td width="220" align="left" valign="top">_____________________</td>
	</tr>

	</table>
</body>
</html>