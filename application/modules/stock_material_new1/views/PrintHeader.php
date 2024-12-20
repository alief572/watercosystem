<html>
<head>
  <title>Cetak PDF</title>
<style>
    #tables td, th {
		border: 1px solid #808080;
        padding: 5 px;
		border-collapse: collapse;
    }
	.clearth{
		border: 0px;
		border-collapse: collapse;
	}
</style>
</head>
<body>
<!-- <table border="0">
<tr>
	<td width="30" align="left"></td>
	<td width="300" align="left" valign="top">
		<h4 style="text-align: left;">Stock Material Tanggal <?= date("Y-m-d") ?></h4>
	</td>
</tr>
</table> -->
<table id="tables" border="0" width='100%' align="center" cellpadding="2" cellspacing="0">
		<thead>
			<tr>
				<th align="left" colspan='7'><h4 style="text-align: left;">Stock Material Tanggal <?= date("d F Y") ?></h4></th>
			</tr>
			<tr>
				<th width="50" align="center">No</th>
				<th width="75" align="center">ID Material</th>
				<th width="200" align="center">Type</th>
				<th width="150" align="center">Detail Material</th>
				<th width="350" align="center">Supplier</th>
				<th width="100" align="center">Thickness</th>
				<th width="100" align="center">Stok (kg)</th>
			</tr>
		</thead>
		<tbody>
		<?php 
			$SUM = 0;
			$numb=0; foreach($header AS $record){ $numb++; 
			$id = $record->id_category3;
			if(empty($id)){
			?>
		<tr>
		    <td width="50" align="center"><?= $numb; ?></td>
			<td colspan='4' align="center"> Mohon Maaf Material(<b> <?= $record->nama_material ?>-<?= $record->thickness ?> </b>)Belum Terdaftar Pada Master Material</td>
			<td align="left" width="100"><?= $record->totalweight ?>
			</td>

		</tr>
		<?php } else{   
			$SUM += $record->totalweight;
			?>
		 
		<tr>
		    <td align="center"><?= $numb; ?></td>
			<td align="left"><?= $record->id_category3 ?></td>
			<td align="left">
				<?php 
				$c3  	= $this->db->get_where('ms_inventory_category3', array('id_category3' => $id))->result();
				$c1 	= $c3[0]->id_category1;
				$n1  	= $this->db->get_where('ms_inventory_category1', array('id_category1' => $c1))->result();
				foreach($n1 AS $n1){ 
				?>
				<?= $n1->nama ?>
				<?php };?>
			</td>
			<td align="left"><?= $record->nama_material ?></td>
			
			<td align="left"><?php 
			$sup  = $this->db->get_where('child_inven_suplier', array('id_category3' => $id))->result();	
			foreach($sup AS $sp){  
			$kodesup = $sp->id_suplier;
			$sup2  = $this->db->get_where('master_supplier', array('id_suplier' => $kodesup))->result();
			foreach($sup2 AS $sp2){ 
			?>
			<?= $sp2->name_suplier ?>
			<?php }};
			
			?></td>
			<td align="center"><?= $record->thickness ?></td>
			<td align="right"><?= number_format($record->totalweight,2) ?></td>

		</tr>
		<?php }}   ?>
		<tr>
			<th colspan="6">Jumlah</th>
			<th align="right"><?= number_format($SUM,2) ?></th>
		</tr>
		</tbody>
	</table>
</body>
</html>