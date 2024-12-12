<div class="box box-primary">
	<div class="box-body">
		<div class="table-responsive">
			<table id="tabledataset" class="table table-bordered table-striped" width='100%'>
				<thead>
					<tr class='bg-blue' >
						<th class="text-center">Kode Asset</th>
						<th class="text-center">Asset Name</th>
						<th class="text-center">Tgl Perolehan</th>
						<th class="text-center">Category</th>
						<th class="text-center">Depreciation</th>
						<!-- <th class="text-center">Acquisition</th>
						<th class="text-center">Asset Value</th>-->
						<th class="text-center no-sort">#</th>
					</tr>
				</thead>
				<tbody>
				<?php $idd=0;
				if(!empty($data_asset)){
					foreach($data_asset AS $record){ $idd++;?>
					<tr>
						<td>
						<input type='hidden' name='valaset_<?=$idd?>' id='valaset_<?=$idd?>' value='<?=$record->kd_asset?>#<?=$record->nm_asset?>#<?=$record->sisa_nilai?>'>
						<?=$record->kd_asset?></td>
						<td><?=$record->nm_asset?></td>
						<td><?=date('d-M-Y',strtotime($record->tgl_perolehan))?></td>
						<td><?=$record->nm_category?></td>
						<td><?=$record->depresiasi?> Tahun</td>
						<!--<td><?=number_format($record->nilai_asset,2)?></td>
						<td><?=number_format($record->sisa_nilai,2)?></td>-->
						<td><button type="button" onclick="pilihini(<?=$idd?>)" class="btn btn-xs btn-success">Pilih</button></td>
					</tr>
				<?php
					}
				}
				?>	
				</tbody>
			</table>
		</div>
	</div>
	<!-- /.box-body -->
</div>
<script>
function pilihini(id){
	var id_asset='<?=$id_asset?>';
	var dataaset=$("#valaset_"+id).val();
	oneaset=dataaset.split("#");
	$("#kd_aset_"+id_asset).val(oneaset[0]);
	$("#nama_aset_"+id_asset).val(oneaset[1]);
	$("#nilai_aset_"+id_asset).val(oneaset[2]);
	$('#Mymodal').modal('toggle');
}
$(document).ready(function () {
    $('#tabledataset').DataTable();
});
swal.close();
</script>