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
<table border="0">
<tr>
	<td width="30" align="left"></td>
	<td width="300" align="left" valign="top">
		<h4 style="text-align: left;">Stock Material Tanggal <?= date("Y-m-d") ?></h4>
	</td>
</tr>
</table>
<table id="tables" border="0" width='100%' align="center" cellpadding="2" cellspacing="0">
		<tr>
			<th width="50" align="center">No</th>
			<th width="200" align="center">FERROUS / NON FERROUS</th>
			<th width="300" align="center">Detail Nama Material</th>
			<th width="350" align="center">Supplier</th>
			<th width="100" align="center">Jumlah Stok</th>
		</tr>

		<?php 
			$numb=0; foreach($header AS $record){ $numb++; ?>
		<tr>
		    <td width="50" align="center"><?= $numb; ?></td>
			<td width="200" align="left"><?= $record->nama_category1 ?></td>
			<td width="300" align="left"><?= $record->nama_category2.'-'.$record->nama.'-'.$record->hardness.'-'.$record->nilai_dimensi.'-'.$record->maker ?></td>
			<td width="350" align="left"><?php 
			$id = $record->id_category3;
			$sup  = $this->db->get_where('child_inven_suplier', array('id_category3' => $id))->result();	
			foreach($sup AS $sp){  
			$kodesup = $sp->id_suplier;
			$sup2  = $this->db->get_where('master_supplier', array('id_suplier' => $kodesup))->result();
			foreach($sup2 AS $sp2){ 
			?>
			<?= $sp2->name_suplier ?>
			<?php }};?></td>
			<td align="left" width="100">
			<?php
			$stock	= $this->db->query("SELECT SUM(weight) as weight FROM stock_material WHERE id_category3 = '$record->id_category3' ")->result();
			?>
				<?= number_format( $stock[0]->weight,2);?>
			</td>

		</tr>
		<?php }   ?>
		<tr ><td colspan="4">Jumlah</td>
		<?php foreach($sum AS $sum){ }?>
		<td><?= $sum->weight ?> Kg</td></tr> 
	</table>
</body>
</html>