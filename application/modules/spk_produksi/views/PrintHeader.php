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
<table border="0" >
	<tr><td>SPK PRODUUKSI</td></tr>
	<tr>
	<td>
	<table>
	<tr><td width='12%'>NO.SPK</td><td width='3%'>:</td><td width='22%'><?= $tr_spk->no_surat ?></td><td width='25%'><br><br><br><br></td>
	<td width='12%'> Tanggal </td><td width='3%'>:</td><td width='22%'> <?= $tr_spk->tgl_spk_produksi ?></td></tr>
	</table>
	</td>
	</tr>
	<tr><td>
	A. Material
	</td></tr>
	<tr><td align="center">
			<table id="tables" border="0" width='100%' align="left" cellpadding="2" cellspacing="0">
			<thead>
			<tr>
			<td >No</td>
			<td >Nomor. Lot</td>
			<td >Nama Material</td>
			<td >Berat Mother coil</td>
			<td >Density</td>
			<td >Thikness</td>
			<td >Panjang Mother Coil</td>
			<td >Width Mother Coil</td>
			</tr>
			</thead>
			<tbody >
			<tr>
			<td>1</td>
			<td><?= $tr_spk->lotno ?></td>
			<td><?= $tr_spk->nama_material ?></td>
			<td><?= $tr_spk->weight ?></td>
			<td><?= $tr_spk->density ?></td>
			<td><?= $tr_spk->thickness ?></td>
			<td><?= $tr_spk->panjang ?></td>
			<td><?= $tr_spk->width ?></td>
			</tr>
			
			</tbody>
			</table>
	</td></tr>
	<tr><td>
	B. Produksi
	</td></tr>
	<tr><td>
			<table id="tables" border="0" width='100%' align="left" cellpadding="2" cellspacing="0">
			<thead>
			<tr>
			<td rowspan='2'>No</td>
			<td rowspan='2's>Nomor. SO</td>
			<td rowspan='2'>Customer</td>
			<td rowspan='2'>Nomor Alloy</td>
			<td rowspan='2'>Thickness</td>
			<td rowspan='2'>Weight / Coil</td>
			<td colspan='2'>Qty Coil</td>
			<td colspan='2'>Total Wight</td>
			<td rowspan='2'>Delivery Date</td>
			
			</tr>
			<tr>

			<td>Order</td>
			<td>Aktual</td>
			<td>Order</td>
			<td>Aktual</td>
			
			</tr>
			</thead>
			<tbody>
			<?php $loop=0;
			foreach ($detail as $dt_spk){$loop++; 
			$customers = $this->db->query("SELECT * FROM master_customers WHERE id_customer ='$dt_spk->idcustomer' ")->result();
			$name_customer=$customers[0]->name_customer;
			$detailspk = $this->db->query("SELECT a.*, b.no_surat as nosu FROM dt_spkmarketing as a INNER JOIN tr_spk_marketing as b on a.id_spkmarketing = b.id_spkmarketing WHERE a.id_dt_spkmarketing ='$dt_spk->no_surat' ")->result();
			$idmarketing =$detailspk[0]->nosu;
			$qtycoil = number_format($dt_spk->qtycoil);
		echo "
		<tr>
			<td>$loop</td>
			<td>$idmarketing</td>
			<td>$name_customer</td>
			<td>$dt_spk->nmmaterial</td>
			<td>$dt_spk->thickness</td>
						<td>$dt_spk->width</td>

			<td>$qtycoil</td>
			<td></td>

			<td>$dt_spk->totalwidth</td>
						<td></td>
			<td>$dt_spk->delivery</td>
		</tr>
		";
			}
			?>
			</tbody>
			</table>
		</td></tr>
	<tr><td>
	<table>
	<tr><td>
					Lebar Pegangan
	</td>
	<td>:</td>
	<td>
				<?= number_format($tr_spk->lpegangan) ?>
	</td></tr>
	<tr><td>
					Qty Coil
	</td>
	<td>:</td>
	<td>
				<?= number_format($tr_spk->qcoil) ?>
	</td></tr>
	<tr><td>
					Jml Pisau
	</td>
	<td>:</td>
	<td>
				<?= number_format($tr_spk->jpisau) ?>
	</td></tr>
	<tr>
		<td>
	<table>
	<tr><td rowspan='2'>
					Sisa Potongan
	</td>
	<td rowspan='2'>
					:
	</td>
	
	<td>
					Lebar Planing
	</td>
	<td>
	:
	</td>
	<td>
					<?= $tr_spk->sisa ?>
	</td>
	<td>
					Berat Planing
	</td>
	<td>
	:
	</td>
	<td>
					<?= $tr_spk->sisa ?>
	</td></tr>
		<tr>
	<td>
					Lebar Aktual
	</td>
	<td>
	:
	</td>
	<td>
					____________
	</td>
	<td>
					Berat Aktual
	</td>
	<td>
	:
	</td>
	<td>
					____________
	</td>
	</tr>
	<tr><td rowspan='2'>
					Scrap
	</td>
	<td rowspan='2'>
					:
	</td>
	
	<td>
					Lebar Planing
	</td>
	<td>
	:
	</td>
	<td>
					<?= number_format($tr_spk->lpegangan) ?>
	</td>
	<td>
					Berat Planing
	</td>
	<td>
	:
	</td>
	<td>
					<?= number_format($tr_spk->lpegangan) ?>
	</td></tr>
		<tr>
	<td>
					Lebar Aktual
	</td>
	<td>
	:
	</td>
	<td>
					____________
	</td>
	<td>
					Berat Aktual
	</td>
	<td>
	:
	</td>
	<td>
					____________
	</td>
	</tr>
	</table>
	</td></tr>
	</table>
	</td></tr>
</table>
</body>