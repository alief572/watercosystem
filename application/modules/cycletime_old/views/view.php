<?php
// print_r($header);
?>
<div class="box box-primary">
	<!-- /.box-header -->
	<div class="box-body"><br>
		<form id="data_form">
		<div class="row">
				<form id="data_form">
		<input type="hidden" name="id_material" id="id_material" value='<?= $header[0]->id_time ?>'>
		<div class="row">
		<div id="input1">
			<div class="col-md-12">			    
                <div class="col-md-5">
				<div class="form-group row">
					<div class="col-md-4">
					  <label for="inventory_1">Produk</label>
					</div>
					 <div class="col-md-8">
					    <input type="text" class="form-control input-sm" id="spec6"  name="spec6" readonly="readonly" value="<?= strtoupper(get_name('ms_inventory_category2', 'nama', 'id_category2', $header[0]->id_product)); ?>">
					
					 </div>
				</div>
				</div>
				
				
				
				<div class="col-md-12">
				<h5 class="box-title"><b>Detail Cycletime</b></h5>
				<table id="example1" border='0' width='100%' class="table table-striped table-bordered table-hover table-condensed">
					<thead id='head_table'>
						<tr class='bg-blue'>
							<th class='text-center' style='width: 4%;'>#</th>
							<th class='text-center' style='width: 30%;'>Cost Center</th>
							<th class='text-center'>Machine</th>
							<th class='text-center'>Mould/Tools</th>
							<th class='text-center'>Information</th>
						</tr>
					</thead>
					<tbody>
						<?php
						  $q_header_test = $this->db->query("SELECT * FROM cycletime_detail_header WHERE id_time='".$header[0]->id_time."'")->result_array();
						$nox = 0;
						  foreach($q_header_test AS $val2 => $val2x){ $nox++;
						  echo "<tr>";
							echo "<td align='center'>".$nox."</td>";
							echo "<td align='left'><b>".strtoupper(get_name('ms_costcenter', 'nama_costcenter', 'id_costcenter', $val2x['costcenter']))."</b></td>";
							echo "<td align='left'><b>".strtoupper(get_name('asset', 'nm_asset', 'kd_asset', $val2x['machine']))."</b></td>";
							echo "<td align='left'><b>".strtoupper(get_name('asset', 'nm_asset', 'kd_asset', $val2x['mould']))."</b></td>";
							echo "<td align='left'></td>";
						  echo "</tr>";
							$q_dheader_test = $this->db->query("SELECT * FROM cycletime_detail_detail WHERE id_costcenter='".$val2x['id_costcenter']."'")->result_array();
							foreach($q_dheader_test AS $val2D => $val2Dx){ $val2D++;
							  $nomor = ($val2D==1)?$val2D:'';
							  echo "<tr>";
								echo "<td align='center'></td>";
								echo "<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".strtoupper(get_name('ms_process', 'nm_process', 'id', $val2Dx['id_process']))."</td>";
								echo "<td align='left'>Time : ".$val2Dx['cycletime']." minutes</td>";
								echo "<td align='left'>Qty MP : ".$val2Dx['qty_mp']."</td>";
								echo "<td align='left'>".$val2Dx['note']."</td>";
							  echo "</tr>";
							}
						  }
						  ?>
					</tbody>
				</table>
				</div>	
            </div>		
		</div>
		</div>
	</div>
	</div>
	
</div>



