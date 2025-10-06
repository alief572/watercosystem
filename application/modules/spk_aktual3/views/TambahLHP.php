<?php
	$tanggal = date('Y-m-d');
foreach ($results['tr_spk'] as $tr_spk){
	}
?>
 <div class="box box-primary">
    <div class="box-body">
		<form id="data-form" method="post">
			<div class="row">
				<div class='box-body hide_header'>
					<table class='table table-sm table-striped table-bordered table-hover table-condensed' width='100%'>
						<thead>
							<tr class='bg-blue'>
								<th hidden>ID Stok</th>
								<th>No Lot</th>
								<th width='20%'>Material</th>
								<th width='12%'>Berat Mother Coil</th>
								<th width='12%'>Thickness</th>
								<th width='12%'>Density</th>
								<th width='12%'>Panjang Master Coil</th>
								<th width='12%'>Width Mother Coil</th>
								<th width='12%'>Keterangan</th>
							</tr>
						</thead>
							<tr>
								<th hidden><input type='text' class='form-control'  value='<?= $tr_spk->no_surat?>' 	readonly id='no_surat' required name='no_surat'></th>
								<th hidden><input type='text' class='form-control'  value='<?= $tr_spk->id_spkproduksi?>' 	readonly id='id_spk_aktual' required name='id_spk_aktual'>
								<input type='text' class='form-control'  value='<?= $tr_spk->id_tr_spk_produksi?>' 	readonly id='id_tr_spkproduksi' required name='id_tr_spkproduksi'> 
								</th>
								<th hidden><input type='text' class='form-control'  value='<?= $tr_spk->id_stock?>' 	readonly id='id_stock' required name='id_stock'></th>
								<th><input type='text' class='form-control'  	   	value='<?= $tr_spk->lotno?>' 	readonly id='lotno' required name='lotno'></th>
								<th hidden><input type='text' class='form-control'  value='<?= $tr_spk->id_material?>' 	readonly id='id_material' required name='id_material'></th>
								<th><input type='text' class='form-control'  	   	value='<?= $tr_spk->nama_material?>' 	readonly id='nama_material' required name='nama_material'></th>
								<th><input type='text' class='form-control' 		value='<?= $tr_spk->weight?>'  	readonly id='weight' required name='weight'></th>
								<th><input type='text' class='form-control'   		value='<?= $tr_spk->thickness?>'	readonly id='thickness' required name='thickness'></th>
								<th><input type='text' class='form-control'   		value='<?= $tr_spk->density?>'	readonly id='density' required name='density'></th>
								<th><input type='text' class='form-control'  		value='<?= $tr_spk->panjang?>' 	readonly id='panjang'  required name='panjang'></th>
								<th><input type='text' class='form-control'   		value='<?= $tr_spk->width?>' 	readonly id='width'  required name='width'></th>
								<th><input type='text' class='form-control'   		value='' 	readonly id='ket'  required name='ket'></th>
							</tr>
			
			<?php
				if(empty($results['detail_aktual'])){
					echo "<tr>";
						echo "<td align='left'>Progress Name </td>";
						echo "<td>";
						echo "<input type='hidden' name='dt[0][id_proses]' class='form-control input-md' placeholder='Progress Name' id='id_proses' value='MATL1' readonly>";
						echo "<input type='text' name='dt[0][namaproses]' class='form-control input-md' placeholder='Progress Name' id='namaproses_' value='MATL  CHANGE' readonly>";
						echo "</td>";
						echo "<td align='left'>";
						echo "<input type='time' name='dt[0][start]' class='selisih_time form-control input-md formsub' placeholder='Start Time'   id='start_' value='$start1' >";
						echo "</td>";
						echo "<td align='left'>Sampai</td>";
						echo "<td>";
						echo "<input type='Time' name='dt[0][finish]' class='selisih_time form-control input-md' placeholder='berat'   id='finish_' value='$finish1' >";
						echo "</td>";
						echo "<td align='left'>Total</td>";
						echo "<td align='left'>";
						echo "<input type='text' name='dt[0][total]' class='total_time form-control input-md formsubagain' placeholder='Total Waktu'   id='total_' value='$total1' >";
						echo "</td>";
						echo "<td align='left'>";
						echo "<input type='text' name='dt[0][keterangan_]' class='keterangan form-control input-md formsubagain' placeholder='Keterangan'   id='keterangan_' value='$keterangan1' >";
						echo "</td>";
						// echo "<td align='center'>";
						// echo "<button type='button' class='btn btn-sm btn-danger delSubPart' title='Delete Part'><i class='fa fa-close'></i></button>";
						// echo "</td>";
					echo "</tr>";
					echo "<tr>";
						
						echo "<td align='left'>Progress Name </td>";
						echo "<td>";
						echo "<input type='hidden' name='dt[1][id_proses]' class='form-control input-md' placeholder='Progress Name' id='id_proses' value='SETTING1' readonly>";
						echo "<input type='text' name='dt[1][namaproses]' class='form-control input-md' placeholder='Progress Name' id='namaproses_' value='SETTING KNIVE' readonly>";
						echo "</td>";
						echo "<td align='left'>";
						echo "<input type='time' name='dt[1][start]' class='selisih_time form-control input-md formsub' placeholder='Start Time'   id='start_' value='$start2' >";
						echo "</td>";
						echo "<td align='left'>Sampai</td>";
						echo "<td>";
						echo "<input type='Time' name='dt[1][finish]' class='selisih_time form-control input-md' placeholder='berat'   id='finish_' value='$finish2' >";
						echo "</td>";
						echo "<td align='left'>Total</td>";
						echo "<td align='left'>";
						echo "<input type='text' name='dt[1][total]' class='total_time form-control input-md formsubagain' placeholder='Total Waktu'   id='total_' value='$total2'>";
						echo "</td>";
						echo "<td align='left'>";
						echo "<input type='text' name='dt[1][keterangan_]' class='keterangan form-control input-md formsubagain' placeholder='Keterangan'   id='keterangan_' value='$keterangan2' >";
						echo "</td>";
						// echo "<td align='center'>";
						// echo "<button type='button' class='btn btn-sm btn-danger delSubPart' title='Delete Part'><i class='fa fa-close'></i></button>";
						// echo "</td>";
					echo "</tr>";
					echo "<tr>";
						
						echo "<td align='left'>Progress Name </td>";
						echo "<td>";
						echo "<input type='hidden' name='dt[2][id_proses]' class='form-control input-md' placeholder='Progress Name' id='id_proses' value='SETTUP1' readonly>";
						echo "<input type='text' name='dt[2][namaproses]' class='form-control input-md' placeholder='Progress Name' id='namaproses_' value='SETT UP' readonly>";
						echo "</td>";
						echo "<td align='left'>";
						echo "<input type='time' name='dt[2][start]' class='selisih_time form-control input-md formsub' placeholder='Start Time'   id='start_' value='$start3'>";
						echo "</td>";
						echo "<td align='left'>Sampai</td>";
						echo "<td>";
						echo "<input type='Time' name='dt[2][finish]' class='selisih_time form-control input-md' placeholder='berat'   id='finish_' value='$finish3'>";
						echo "</td>";
						echo "<td align='left'>Total</td>";
						echo "<td align='left'>";
						echo "<input type='text' name='dt[2][total]' class='total_time form-control input-md formsubagain' placeholder='Total Waktu'   id='total_' value='$total3'>";
						echo "</td>";
						echo "<td align='left'>";
						echo "<input type='text' name='dt[2][keterangan_]' class='keterangan form-control input-md formsubagain' placeholder='Keterangan'   id='keterangan_' value='$keterangan3' >";
						echo "</td>";
						// echo "<td align='center'>";
						// echo "<button type='button' class='btn btn-sm btn-danger delSubPart' title='Delete Part'><i class='fa fa-close'></i></button>";
						// echo "</td>";
					echo "</tr>";
						echo "<tr>";
						
						echo "<td align='left'>Progress Name </td>";
						echo "<td>";
						echo "<input type='hidden' name='dt[3][id_proses]' class='form-control input-md' placeholder='Progress Name' id='id_proses' value='QC1' readonly>";
						echo "<input type='text' name='dt[3][namaproses]' class='form-control input-md' placeholder='Progress Name' id='namaproses_' value='QC  CHECK SETTING' readonly>";
						echo "</td>";
						echo "<td align='left'>";
						echo "<input type='time' name='dt[3][start]' class='selisih_time form-control input-md formsub' placeholder='Start Time'   id='start_' value='$start4' >";
						echo "</td>";
						echo "<td align='left'>Sampai</td>";
						echo "<td>";
						echo "<input type='Time' name='dt[3][finish]' class='selisih_time form-control input-md' placeholder='berat'   id='finish_' value='$finish4'>";
						echo "</td>";
						echo "<td align='left'>Total</td>";
						echo "<td align='left'>";
						echo "<input type='text' name='dt[3][total]' class='total_time form-control input-md formsubagain' placeholder='Total Waktu'   id='total_' value='$total4'>";
						echo "</td>";
						echo "<td align='left'>";
						echo "<input type='text' name='dt[3][keterangan_]' class='keterangan form-control input-md formsubagain' placeholder='Keterangan'   id='keterangan_' value='$keterangan4' >";
						echo "</td>";
						// echo "<td align='center'>";
						// echo "<button type='button' class='btn btn-sm btn-danger delSubPart' title='Delete Part'><i class='fa fa-close'></i></button>";
						// echo "</td>";
					echo "</tr>";
					echo "<tr>";
						
						echo "<td align='left'>Progress Name </td>";
						echo "<td>";
						echo "<input type='hidden' name='dt[4][id_proses]' class='form-control input-md' placeholder='Progress Name' id='id_proses' value='SETTUP2' readonly>";
						echo "<input type='text' name='dt[4][namaproses]' class='form-control input-md' placeholder='Progress Name' id='namaproses_' value='SETT UP' readonly>";
						echo "</td>";
						echo "<td align='left'>";
						echo "<input type='time' name='dt[4][start]' class='selisih_time form-control input-md formsub' placeholder='Start Time'   id='start_' value='$start5' >";
						echo "</td>";
						echo "<td align='left'>Sampai</td>";
						echo "<td>";
						echo "<input type='Time' name='dt[4][finish]' class='selisih_time form-control input-md' placeholder='berat'   id='finish_' value='$finish5'>";
						echo "</td>";
						echo "<td align='left'>Total</td>";
						echo "<td align='left'>";
						echo "<input type='text' name='dt[4][total]' class='total_time form-control input-md formsubagain' placeholder='Total Waktu'   id='total_' value='$total5'>";
						echo "</td>";
						echo "<td align='left'>";
						echo "<input type='text' name='dt[4][keterangan_]' class='keterangan form-control input-md formsubagain' placeholder='Keterangan'   id='keterangan_' value='$keterangan5' >";
						echo "</td>";
						// echo "<td align='center'>";
						// echo "<button type='button' class='btn btn-sm btn-danger delSubPart' title='Delete Part'><i class='fa fa-close'></i></button>";
						// echo "</td>";
					echo "</tr>"; 
					echo "<tr>";
						
						echo "<td align='left'>Progress Name </td>";
						echo "<td>";
						echo "<input type='hidden' name='dt[5][id_proses]' class='form-control input-md' placeholder='Progress Name' id='id_proses' value='QC2' readonly>";
						echo "<input type='text' name='dt[5][namaproses]' class='form-control input-md' placeholder='Progress Name' id='namaproses_' value='QC  CHECK AWAL' readonly>";
						echo "</td>";
						echo "<td align='left'>";
						echo "<input type='time' name='dt[5][start]' class='selisih_time form-control input-md formsub' placeholder='Start Time'   id='start_' value='$start6'>";
						echo "</td>";
						echo "<td align='left'>Sampai</td>";
						echo "<td>";
						echo "<input type='Time' name='dt[5][finish]' class='selisih_time form-control input-md' placeholder='berat'   id='finish_' value='$finish6'>";
						echo "</td>";
						echo "<td align='left'>Total</td>";
						echo "<td align='left'>";
						echo "<input type='text' name='dt[5][total]' class='total_time form-control input-md formsubagain' placeholder='Total Waktu'   id='total_' value='$total6' >";
						echo "</td>";
						echo "<td align='left'>";
						echo "<input type='text' name='dt[5][keterangan_]' class='keterangan form-control input-md formsubagain' placeholder='Keterangan'   id='keterangan_' value='$keterangan6' >";
						echo "</td>";
						// echo "<td align='center'>";
						// echo "<button type='button' class='btn btn-sm btn-danger delSubPart' title='Delete Part'><i class='fa fa-close'></i></button>";
						// echo "</td>";
					echo "</tr>";
					echo "<tr>";
						
						echo "<td align='left'>Progress Name </td>";
						echo "<td>";
						echo "<input type='hidden' name='dt[6][id_proses]' class='form-control input-md' placeholder='Progress Name' id='id_proses' value='SLITTING1' readonly>";
						echo "<input type='text' name='dt[6][namaproses]' class='form-control input-md' placeholder='Progress Name' id='namaproses_' value='SLITTING PROCESS' readonly>";
						echo "</td>";
						echo "<td align='left'>";
						echo "<input type='time' name='dt[6][start]' class='selisih_time form-control input-md formsub' placeholder='Start Time'   id='start_' value='$start7'>";
						echo "</td>";
						echo "<td align='left'>Sampai</td>";
						echo "<td>";
						echo "<input type='Time' name='dt[6][finish]' class='selisih_time form-control input-md' placeholder='berat'   id='finish_' value='$finish8'>";
						echo "</td>";
						echo "<td align='left'>Total</td>";
						echo "<td align='left'>";
						echo "<input type='text' name='dt[6][total]' class='total_time form-control input-md formsubagain' placeholder='Total Waktu'   id='total_' value='$total7' >";
						echo "</td>";
						echo "<td align='left'>";
						echo "<input type='text' name='dt[6][keterangan_]' class='keterangan form-control input-md formsubagain' placeholder='Keterangan'   id='keterangan_' value='$keterangan7' >";
						echo "</td>";
						// echo "<td align='center'>";
						// echo "<button type='button' class='btn btn-sm btn-danger delSubPart' title='Delete Part'><i class='fa fa-close'></i></button>";
						// echo "</td>";
					echo "</tr>";
					echo "<tr>";
						
						echo "<td align='left'>Progress Name </td>";
						echo "<td>";
						echo "<input type='hidden' name='dt[7][id_proses]' class='form-control input-md' placeholder='Progress Name' id='id_proses' value='QC3' readonly>";
						echo "<input type='text' name='dt[7][namaproses]' class='form-control input-md' placeholder='Progress Name' id='namaproses_' value='QC  CHECK TENGAH' readonly>";
						echo "</td>";
						echo "<td align='left'>";
						echo "<input type='time' name='dt[7][start]' class='selisih_time form-control input-md formsub' placeholder='Start Time'   id='start_'value='$start8' >";
						echo "</td>";
						echo "<td align='left'>Sampai</td>";
						echo "<td>";
						echo "<input type='Time' name='dt[7][finish]' class='selisih_time form-control input-md' placeholder='berat'   id='finish_' value='$finish8'>";
						echo "</td>";
						echo "<td align='left'>Total</td>";
						echo "<td align='left'>";
						echo "<input type='text' name='dt[7][total]' class='total_time form-control input-md formsubagain' placeholder='Total Waktu'   id='total_' value='$total8' >";
						echo "</td>";
						echo "<td align='left'>";
						echo "<input type='text' name='dt[7][keterangan_]' class='keterangan form-control input-md formsubagain' placeholder='Keterangan'   id='keterangan_' value='$keterangan8' >";
						echo "</td>";
						// echo "<td align='center'>";
						// echo "<button type='button' class='btn btn-sm btn-danger delSubPart' title='Delete Part'><i class='fa fa-close'></i></button>";
						// echo "</td>";
					echo "</tr>";
					echo "<tr>";
						
						echo "<td align='left'>Progress Name </td>";
						echo "<td>";
						echo "<input type='hidden' name='dt[8][id_proses]' class='form-control input-md' placeholder='Progress Name' id='id_proses' value='SLITTING2' readonly>";
						echo "<input type='text' name='dt[8][namaproses]' class='form-control input-md' placeholder='Progress Name' id='namaproses_' value='SLITTING PROCESS' readonly>";
						echo "</td>";
						echo "<td align='left'>";
						echo "<input type='time' name='dt[8][start]' class='selisih_time form-control input-md formsub' placeholder='Start Time'   id='start_' value='$start9'>";
						echo "</td>";
						echo "<td align='left'>Sampai</td>";
						echo "<td>";
						echo "<input type='Time' name='dt[8][finish]' class='selisih_time form-control input-md' placeholder='berat'   id='finish_' value='$finish9'>";
						echo "</td>";
						echo "<td align='left'>Total</td>";
						echo "<td align='left'>";
						echo "<input type='text' name='dt[8][total]' class='total_time form-control input-md formsubagain' placeholder='Total Waktu'   id='total_' value='$total9' >";
						echo "</td>";
						echo "<td align='left'>";
						echo "<input type='text' name='dt[8][keterangan_]' class='keterangan form-control input-md formsubagain' placeholder='Keterangan'   id='keterangan_' value='$keterangan9' >";
						echo "</td>";
						// echo "<td align='center'>";
						// echo "<button type='button' class='btn btn-sm btn-danger delSubPart' title='Delete Part'><i class='fa fa-close'></i></button>";
						// echo "</td>";
					echo "</tr>";
					echo "<tr>";
						
						echo "<td align='left'>Progress Name </td>";
						echo "<td>";
						echo "<input type='hidden' name='dt[9][id_proses]' class='form-control input-md' placeholder='Progress Name' id='id_proses' value='QC4' readonly>";
						echo "<input type='text' name='dt[9][namaproses]' class='form-control input-md' placeholder='Progress Name' id='namaproses_' value='QC  CHECK AKHIR' readonly>";
						echo "</td>";
						echo "<td align='left'>";
						echo "<input type='time' name='dt[9][start]' class='selisih_time form-control input-md formsub' placeholder='Start Time'   id='start_' value='$start10' >";
						echo "</td>";
						echo "<td align='left'>Sampai</td>";
						echo "<td>";
						echo "<input type='Time' name='dt[9][finish]' class='selisih_time form-control input-md' placeholder='berat'   id='finish_' value='$finish10'>";
						echo "</td>";
						echo "<td align='left'>Total</td>";
						echo "<td align='left'>";
						echo "<input type='text' name='dt[9][total]' class='total_time form-control input-md formsubagain' placeholder='Total Waktu'   id='total_' value='$total10' >";
						echo "</td>";
						echo "<td align='left'>";
						echo "<input type='text' name='dt[9][keterangan_]' class='keterangan form-control input-md formsubagain' placeholder='Keterangan'   id='keterangan_' value='$keterangan10' >";
						echo "</td>";
						// echo "<td align='center'>";
						// echo "<button type='button' class='btn btn-sm btn-danger delSubPart' title='Delete Part'><i class='fa fa-close'></i></button>";
						// echo "</td>";
					echo "</tr>";
					echo "<tr>";
						
						echo "<td align='left'>Progress Name </td>";
						echo "<td>";
						echo "<input type='hidden' name='dt[10][id_proses]' class='form-control input-md' placeholder='Progress Name' id='id_proses' value='HANDLING1' readonly>";
						echo "<input type='text' name='dt[10][namaproses]' class='form-control input-md' placeholder='Progress Name' id='namaproses_' value='HANDLING' readonly>";
						echo "</td>";
						echo "<td align='left'>";
						echo "<input type='time' name='dt[10][start]' class='selisih_time form-control input-md formsub' placeholder='Start Time'   id='start_' value='$start11'>";
						echo "</td>";
						echo "<td align='left'>Sampai</td>";
						echo "<td>";
						echo "<input type='Time' name='dt[10][finish]' class='selisih_time form-control input-md' placeholder='berat'   id='finish_' value='$finish11'>";
						echo "</td>";
						echo "<td align='left'>Total</td>";
						echo "<td align='left'>";
						echo "<input type='text' name='dt[10][total]' class='total_time form-control input-md formsubagain' placeholder='Total Waktu'   id='total_' value='$total11' >";
						echo "</td>";
						echo "<td align='left'>";
						echo "<input type='text' name='dt[10][keterangan_]' class='keterangan form-control input-md formsubagain' placeholder='Keterangan'   id='keterangan_' value='$keterangan11' >";
						echo "</td>";
						// echo "<td align='center'>";
						// echo "<button type='button' class='btn btn-sm btn-danger delSubPart' title='Delete Part'><i class='fa fa-close'></i></button>";
						// echo "</td>";
					echo "</tr>";
				}
				else{
					foreach ($results['detail_aktual'] as $key => $value) {
						echo "<tr>";
							echo "<td align='left'>Progress Name </td>";
							echo "<td>";
								echo "<input type='hidden' name='dt[$key][id_proses]' class='form-control input-md' placeholder='Progress Name' id='id_proses' value='".$value['id_proses']."' readonly>";
								echo "<input type='text' name='dt[$key][namaproses]' class='form-control input-md' placeholder='Progress Name' id='namaproses_' value='".$value['namaproses']."' readonly>";
							echo "</td>";
							echo "<td align='left'>";
								echo "<input type='time' name='dt[$key][start]' class='selisih_time form-control input-md formsub' placeholder='Start Time'   id='start_' value='".$value['start']."'>";
							echo "</td>";
							echo "<td align='left'>Sampai</td>";
							echo "<td>";
								echo "<input type='Time' name='dt[$key][finish]' class='selisih_time form-control input-md' placeholder='berat'   id='finish_' value='".$value['finish']."'>";
							echo "</td>";
							echo "<td align='left'>Total</td>";
							echo "<td align='left'>";
								echo "<input type='text' name='dt[$key][total]' class='total_time form-control input-md formsubagain' placeholder='Total Waktu'   id='total_' value='".$value['total']."' >";
							echo "</td>";
							echo "<td align='left'>";
								echo "<input type='text' name='dt[$key][keterangan_]' class='total_time form-control input-md formsubagain' placeholder='Keterangan'   id='keterangan_' value='".$value['keterangan']."' >";
							echo "</td>";
						echo "</tr>";
					}
				}
				echo "<tr>";
						echo "<td'></td>";
						echo "<td></td>";
						echo "<td></td>";
						echo "<td></td>";
						echo "<td></td>";
						echo "<td></td>";
						echo "<td align='left'>";
							echo "<input type='text' class='form-control input-md' placeholder='Total Jam' id='total_jam' readonly>";
						echo "</td>";
						echo "<td align='left'>";
							echo "<input type='text' class='form-control input-md' placeholder='Total Waktu' id='total_time' readonly>";
						echo "</td>";
					echo "</tr>";
 			?>
			</tbody>
		</table>
          		<button type="button" class="btn btn-danger" style='float:right; margin-left:5px; margin-top:10px;' name="back" id="back"><i class="fa fa-reply"></i> Back</button>
				<button type="submit" class="btn btn-primary" style='float:right; margin-top:10px;' name="save" id="save"><i class="fa fa-save"></i> Save</button>

				</div>
			</div>
		</form>
	</div>
</div>


<script src="<?= base_url('assets/js/jquery.maskMoney.js')?>"></script>
<script src="<?= base_url('assets/js/autoNumeric.js')?>"></script>

<script type="text/javascript">
	//$('#input-kendaraan').hide();
	var base_url			= '<?php echo base_url(); ?>';
	var active_controller	= '<?php echo($this->uri->segment(1)); ?>';

	$(document).ready(function(){
		$('.chosen-select').select2();
		sumTime();
		//add part
		$(document).on('click', '.addPart', function(){
			// loading_spinner();
			var get_id 		= $(this).parent().parent().attr('id');
			// console.log(get_id);
			var split_id	= get_id.split('_');
			var id 		= parseInt(split_id[1])+1;
			var id_bef 	= split_id[1];

			$.ajax({
				url: base_url+'index.php/'+active_controller+'/get_add/'+id,
				cache: false,
				type: "POST",
				dataType: "json",
				success: function(data){
					$("#add_"+id_bef).before(data.header);
					$("#add_"+id_bef).remove();
					$('.chosen_select').select2({width: '100%'});
					$('.maskM').maskMoney();
					swal.close();
				},
				error: function() {
					swal({
						title				: "Error Message !",
						text				: 'Connection Time Out. Please try again..',
						type				: "warning",
						timer				: 3000,
						showCancelButton	: false,
						showConfirmButton	: false,
						allowOutsideClick	: false
					});
				}
			});
		});

		//add part
		$(document).on('click', '.addSubPart', function(){
			// loading_spinner();
			var get_id 		= $(this).parent().parent().attr('id');
			// console.log(get_id);
			var split_id	= get_id.split('_');
			var id 			= split_id[1];
			var id2 		= parseInt(split_id[2])+1;
			var id_bef 		= split_id[2];

			$.ajax({
				url: base_url+'index.php/'+active_controller+'/get_add_sub/'+id+'/'+id2,
				cache: false,
				type: "POST",
				dataType: "json",
				success: function(data){
					$("#add_"+id+"_"+id_bef).before(data.header);
					$("#add_"+id+"_"+id_bef).remove();
					$('.chosen_select').select2({width: '100%'});
					$('.maskM').maskMoney();
					swal.close();
				},
				error: function() {
					swal({
						title				: "Error Message !",
						text				: 'Connection Time Out. Please try again..',
						type				: "warning",
						timer				: 3000,
						showCancelButton	: false,
						showConfirmButton	: false,
						allowOutsideClick	: false
					});
				}
			});
		});

		//delete part
		$(document).on('click', '.delPart', function(){
			var get_id 		= $(this).parent().parent().attr('class');
			$("."+get_id).remove();
		});
		
		$(document).on('click', '.hapusPart', function(){
			var get_id 		= $(this).parent().parent().attr('class');
			var split_id	= get_id.split('_');
			var id 			= split_id[1];
			var id2 		= parseInt(split_id[2]);
			var total_harga_penawaran=$('#total_harga_penawaran').val();
		var total_panjang=$('#total_panjang').val();
		var jml_pisau=$('#jml_pisau').val();
		var jml_mother=$('#jml_mother').val();
		var total_berat=$('#total_berat').val();
		var hargadeal=$('#dt_hargadeal_'+id).val();
		var qty=$('#dt_qty_'+id).val();
		var panjang=$('#dt_panjang_'+id).val();
		var jmlpisaudt=$('#dt_jmlpisau_'+id).val();
		var berat=$('#dt_berat_'+id).val();
		
		
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/MinHarga',
            data:"hargadeal="+hargadeal+"&total_harga_penawaran="+total_harga_penawaran,
            success:function(html){
               $('#slot_total_peawaran').html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/MinPanjang',
            data:"panjang="+panjang+"&total_panjang="+total_panjang+"&qty="+qty,
            success:function(html){
               $('#tpanjang_slot').html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/MinPisau',
            data:"jmlpisaudt="+jmlpisaudt+"&jml_pisau="+jml_pisau,
            success:function(html){
               $('#jpisau_slot').html(html);
            }
        });
		$.ajax({ 
            type:"GET",
            url:siteurl+'penawaran_slitting/MinMother',
            data:"qty="+qty+"&jml_mother="+jml_mother,
            success:function(html){
               $('#mother_slot').html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/MinBerat',
            data:"berat="+berat+"&total_berat="+total_berat+"&qty="+qty,
            success:function(html){
               $('#tberat_slot').html(html);
			   
            }
        });
			$("."+get_id).remove();
		});

		$(document).on('click', '.delSubPart', function(){
			var get_id 		= $(this).parent().parent('tr').html();
			$(this).parent().parent('tr').remove();
		});
		$(document).on('click', '.cancelSubPart', function(){
			var get_id 		= $(this).parent().parent('tr').html();
			var split_id	= get_id.split('_');
			var id 			= split_id[1];
			var id2 		= parseInt(split_id[2]);
			var subqty 		=$('#subqty_'+id+'_'+id2).val();
			var subwidth 	=$('#subwidth_'+id+'_'+id2).val();
			var subberat 	=$('#subberat_'+id+'_'+id2).val();
			var mainqty 	=$('#dt_qty_'+id).val();
			var sisa 		=$('#dt_sisa_'+id).val();
			var mainberat 	=$('#dt_berat_'+id).val();
			var mainused 	=$('#dt_used_'+id).val();
			var mainsisakg 	=$('#dt_sisakg_'+id).val();
			var mainwidth 	=$('#dt_lebarnew_'+id).val();
			var pegangan 	=$('#dt_pegangan_'+id).val();
			var lebar 	=$('#dt_lebar_'+id).val();
					$.ajax({
						type:"GET",
						url:siteurl+'penawaran_slitting/minussubwidth',
						data:"id="+id+"&id2="+id2+"&mainwidth="+mainwidth+"&subwidth="+subwidth+"&subqty="+subqty,
						success:function(html){
						   $("#lebarnew_"+id).html(html);
						}
					});
					$.ajax({
						type:"GET",
						url:siteurl+'penawaran_slitting/minussubqty',
						data:"id="+id+"&id2="+id2+"&subqty="+subqty+"&mainqty="+mainqty,
						success:function(html){
						   $("#qty_"+id).html(html);
						}
					});
					$.ajax({
						type:"GET",
						url:siteurl+'penawaran_slitting/MinusSubPisauSatuan',
						data:"id="+id+"&subqty="+subqty+"&mainqty="+mainqty,
						success:function(html){
						   $("#pisau_"+id).html(html);
						}
					}); 
					$.ajax({
						type:"GET",
						url:siteurl+'penawaran_slitting/MinusSubUsed',
						data:"id="+id+"&mainberat="+mainberat+"&mainused="+mainused+"&subberat="+subberat,
						success:function(html){
						   $("#used_"+id).html(html);
						}
					});
					$.ajax({
						type:"GET",
						url:siteurl+'penawaran_slitting/MinusSubSisaKg',
						data:"id="+id+"&mainberat="+mainberat+"&mainused="+mainused+"&subberat="+subberat,
						success:function(html){
						   $("#sisakg_"+id).html(html);
						}
					}); 					
					$.ajax({
						type:"GET",
						url:siteurl+'penawaran_slitting/KunciSub',
						data:"id="+id+"&id2="+id2+"&subqty="+subqty+"&subwidth="+subwidth,
						success:function(html){
						   $("#header_"+id+"_"+id2).html(html);
						}
					});

					$.ajax({
						type:"GET",
						url:siteurl+'penawaran_slitting/Minussubsisasatuan',
						data:"id="+id+"&id2="+id2+"&subqty="+subqty+"&subwidth="+subwidth+"&sisa="+sisa+"&mainqty="+mainqty+"&mainwidth="+mainwidth+"&pegangan="+pegangan+"&lebar="+lebar,
						success:function(html){
						   $('#sisa_'+id).html(html);
						}
					});
			$(this).parent().parent('tr').remove();
		});
		
		$(document).on('click', '.LockSubData', function(){
			var get_id 		= $(this).parent().parent('tr').html();
			var split_id	= get_id.split('_');
			var id 			= split_id[1];
			var id2 		= parseInt(split_id[2]);
			var subqty 		=$('#subqty_'+id+'_'+id2).val();
			var subwidth 	=$('#subwidth_'+id+'_'+id2).val();
			var subberat 	=$('#subberat_'+id+'_'+id2).val();
			var subberatreq =$('#subberatreq_'+id+'_'+id2).val();
			var subqcoil 	=$('#subqcoil_'+id+'_'+id2).val();
			var mainberat 	=$('#dt_berat_'+id).val();
			var mainused 	=$('#dt_used_'+id).val();
			var mainsisakg 	=$('#dt_sisakg_'+id).val();
			var mainqty 	=$('#dt_qty_'+id).val();
			var mainwidth 	=$('#dt_lebarnew_'+id).val(); 
			var pegangan 	=$('#dt_pegangan_'+id).val();
			var lebar 	=$('#dt_lebar_'+id).val();
			var sisa 	=$('#dt_sisa_'+id).val();
					$.ajax({
						type:"GET",
						url:siteurl+'penawaran_slitting/hitungsubwidth',
						data:"id="+id+"&id2="+id2+"&mainwidth="+mainwidth+"&subwidth="+subwidth+"&subqty="+subqty,
						success:function(html){
						   $("#lebarnew_"+id).html(html);
						}
					});
					$.ajax({
						type:"GET",
						url:siteurl+'penawaran_slitting/hitungsubqty',
						data:"id="+id+"&id2="+id2+"&subqty="+subqty+"&mainqty="+mainqty,
						success:function(html){
						   $("#qty_"+id).html(html);
						}
					});
					$.ajax({
						type:"GET",
						url:siteurl+'penawaran_slitting/SubUsed',
						data:"id="+id+"&id2="+id2+"&mainberat="+mainberat+"&mainused="+mainused+"&subberat="+subberat,
						success:function(html){
						   $("#used_"+id).html(html);
						}
					});$.ajax({
						type:"GET",
						url:siteurl+'penawaran_slitting/SubSisaKg',
						data:"id="+id+"&id2="+id2+"&mainberat="+mainberat+"&mainused="+mainused+"&subberat="+subberat,
						success:function(html){
						   $("#sisakg_"+id).html(html);
						}
					});
					$.ajax({
						type:"GET",
						url:siteurl+'penawaran_slitting/HitungSubPisauSatuan',
						data:"id="+id+"&subqty="+subqty+"&mainqty="+mainqty,
						success:function(html){
						   $("#pisau_"+id).html(html);
						}
					});
					$.ajax({
						type:"GET",
						url:siteurl+'penawaran_slitting/KunciSub',
						data:"id="+id+"&id2="+id2+"&subqty="+subqty+"&subwidth="+subwidth+"&subberat="+subberat+"&subberatreq="+subberatreq+"&subqcoil="+subqcoil,
						success:function(html){
						   $("#header_"+id+"_"+id2).html(html);
						}
					});

					$.ajax({
						type:"GET",
						url:siteurl+'penawaran_slitting/Hitungsubsisasatuan',
						data:"id="+id+"&id2="+id2+"&subqty="+subqty+"&sisa="+sisa+"&subwidth="+subwidth+"&mainqty="+mainqty+"&mainwidth="+mainwidth+"&pegangan="+pegangan+"&lebar="+lebar,
						success:function(html){
						   $('#sisa_'+id).html(html);
						}
					});
		});
		
$(document).on('keyup', '.formsub', function(){
			var get_id 		= $(this).parent().parent('tr').html();
			var split_id	= get_id.split('_');
			var id 			= split_id[1];
			var id2 		= parseInt(split_id[2]);
			var subqty 		=$('#subqty_'+id+'_'+id2).val();
			var subwidth 	=$('#subwidth_'+id+'_'+id2).val();
			var maindensity 	=$('#dt_density_'+id).val();
			var mainthickness 	=$('#dt_thickness_'+id).val();
			var mainpanjang 	=$('#dt_panjang_'+id).val();
					$.ajax({
						type:"GET",
						url:siteurl+'penawaran_slitting/HitungSubFormBerat',
						data:"id="+id+"&id2="+id2+"&maindensity="+maindensity+"&mainthickness="+mainthickness+"&mainpanjang="+mainpanjang+"&subwidth="+subwidth+"&subqty="+subqty,
						success:function(html){
						   $("#subsberat_"+id+'_'+id2).html(html);
						}
					});
		});
$(document).on('keyup', '.formsubagain', function(){
			var get_id 		= $(this).parent().parent('tr').html();
			var split_id	= get_id.split('_');
			var id 			= split_id[1];
			var id2 		= parseInt(split_id[2]);
			var subreq 		=$('#subberatreq_'+id+'_'+id2).val();
			var subrumus 	=$('#subberat_'+id+'_'+id2).val();
					$.ajax({
						type:"GET",
						url:siteurl+'penawaran_slitting/HitungSubTauApaan',
						data:"id="+id+"&id2="+id2+"&subreq="+subreq+"&subrumus="+subrumus,
						success:function(html){
						   $("#qcoils_"+id+'_'+id2).html(html);
						}
					});
		});
    //add part
		$(document).on('click', '#back', function(){
		    window.location.href = base_url + active_controller;
		});



		$('#save').click(function(e){
			e.preventDefault();
			var produk		= $('#produk').val();
			var costcenter	= $('.costcenter').val();
			var process		= $('.process').val();

			if(produk == '0' ){
				swal({
					title	: "Error Message!",
					text	: 'Product name empty, select first ...',
					type	: "warning"
				});

				$('#save').prop('disabled',false);
				return false;
			}
			if(costcenter == '0' ){
				swal({
					title	: "Error Message!",
					text	: 'Costcenter empty, select first ...',
					type	: "warning"
				});

				$('#save').prop('disabled',false);
				return false;
			}
			if(process == '0' ){
				swal({
					title	: "Error Message!",
					text	: 'Process name empty, select first ...',
					type	: "warning"
				});

				$('#save').prop('disabled',false);
				return false;
			}

			swal({
				  title: "Are you sure?",
				  text: "You will not be able to process again this data!",
				  type: "warning",
				  showCancelButton: true,
				  confirmButtonClass: "btn-danger",
				  confirmButtonText: "Yes, Process it!",
				  cancelButtonText: "No, cancel process!",
				  closeOnConfirm: true,
				  closeOnCancel: false
				},
				function(isConfirm) {
				  if (isConfirm) {
						var formData 	=new FormData($('#data-form')[0]);
						var baseurl=siteurl+'spk_aktual/SaveLHP';
						$.ajax({
							url			: baseurl,
							type		: "POST",
							data		: formData,
							cache		: false,
							dataType	: 'json',
							processData	: false,
							contentType	: false,
							success		: function(data){
								if(data.status == 1){
									swal({
										  title	: "Save Success!",
										  text	: data.pesan,
										  type	: "success",
										  timer	: 7000,
										  showCancelButton	: false,
										  showConfirmButton	: false,
										  allowOutsideClick	: false
										});
									window.location.href = base_url + active_controller;
								}else{

									if(data.status == 2){
										swal({
										  title	: "Save Failed!",
										  text	: data.pesan,
										  type	: "warning",
										  timer	: 7000,
										  showCancelButton	: false,
										  showConfirmButton	: false,
										  allowOutsideClick	: false
										});
									}else{
										swal({
										  title	: "Save Failed!",
										  text	: data.pesan,
										  type	: "warning",
										  timer	: 7000,
										  showCancelButton	: false,
										  showConfirmButton	: false,
										  allowOutsideClick	: false
										});
									}

								}
							},
							error: function() {

								swal({
								  title				: "Error Message !",
								  text				: 'An Error Occured During Process. Please try again..',
								  type				: "warning",
								  timer				: 7000,
								  showCancelButton	: false,
								  showConfirmButton	: false,
								  allowOutsideClick	: false
								});
							}
						});
				  } else {
					swal("Cancelled", "Data can be process again :)", "error");
					return false;
				  }
			});
		});

});
	function CariPic(){
	   	var id_customer=$('#id_customer').val();

		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/CariPic',
            data:"id_customer="+id_customer,
            success:function(html){
               $("#list_pic").html(html);
            }
        });
	}
	
	
	function CariProperties(id){
	    var id_material=$('#dt_idmaterial_'+id).val();
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/CariDensity',
            data:"id_material="+id_material+"&id="+id,
            success:function(html){
               $('#density_'+id).html(html);
            }
        });
	}
	function DeleteItem(id){
		var total_harga_penawaran=$('#total_harga_penawaran').val();
		var total_panjang=$('#total_panjang').val();
		var total_waktu=$('#total_waktu').val();
		var jml_pisau=$('#jml_pisau').val();
		var jml_mother=$('#jml_mother').val();
		var total_berat=$('#total_berat').val();
		var hargadeal=$('#dt_hargadeal_'+id).val();
		var qty=$('#dt_qty_'+id).val();
		var panjang=$('#dt_panjang_'+id).val();
		var jmlpisaudt=$('#dt_jmlpisau_'+id).val();
		var berat=$('#dt_berat_'+id).val();
		var waktu=$('#dt_waktu_'+id).val();
		
		
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/MinHarga',
            data:"hargadeal="+hargadeal+"&total_harga_penawaran="+total_harga_penawaran,
            success:function(html){
               $('#slot_total_peawaran').html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/MinPanjang',
            data:"panjang="+panjang+"&total_panjang="+total_panjang+"&qty="+qty,
            success:function(html){
               $('#tpanjang_slot').html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/MinPisau',
            data:"jmlpisaudt="+jmlpisaudt+"&jml_pisau="+jml_pisau,
            success:function(html){
               $('#jpisau_slot').html(html);
            }
        });
		$.ajax({ 
            type:"GET",
            url:siteurl+'penawaran_slitting/MinMother',
            data:"qty="+qty+"&jml_mother="+jml_mother,
            success:function(html){
               $('#mother_slot').html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/MinBerat',
            data:"berat="+berat+"&total_berat="+total_berat+"&qty="+qty,
            success:function(html){
               $('#tberat_slot').html(html);
			   
            }
        });

				$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/MinTWaktu',
            data:"waktu="+waktu+"&total_waktu="+total_waktu,
            success:function(html){
               $('#twaktu_slot').html(html);
            }
        });
		 $('#stock_slot #header_'+id).remove();
		
	}
	function TambahItem(id){
	   	var lotno=$('#dt_lotno_'+id).val();
		var idmaterial=$('#dt_idmaterial_'+id).val();
		var berat=$('#dt_berat_'+id).val();
		var density=$('#dt_density_'+id).val();
		var thickness=$('#dt_thickness_'+id).val();
		var lebar=$('#dt_lebar_'+id).val();
		var panjang=$('#dt_panjang_'+id).val();
		var lebarnew=$('#dt_lebarnew_'+id).val();
		var qty=$('#dt_qty_'+id).val();
		var pegangan=$('#dt_pegangan_'+id).val();
		var sisa=$('#dt_sisa_'+id).val();
		var used=$('#dt_used_'+id).val();
		var sisakg=$('#dt_sisakg_'+id).val();
		var jmlpisau=$('#dt_jmlpisau_'+id).val();
		var harga=$('#dt_harga_'+id).val();
		var waktu=$('#dt_waktu_'+id).val();
		var profit=$('#dt_profit_'+id).val();
		var totalpenawaran=$('#dt_totalpenawaran_'+id).val();
		var hargadeal=$('#dt_hargadeal_'+id).val();
		var nama_material=$('#dt_nama_material_'+id).val();
		var total_panjang=$('#total_panjang').val();
		var jml_pisau=$('#jml_pisau').val();
		var jml_mother=$('#jml_mother').val();
		var total_berat=$('#total_berat').val();
		var total_waktu=$('#total_waktu').val();
		var id_customer=$('#id_customer').val();
		var total_harga_penawaran=$('#total_harga_penawaran').val();
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/LockDetail',
            data:"lotno="+lotno+"&nama_material="+nama_material+"&waktu="+waktu+"&used="+used+"&sisakg="+sisakg+"&profit="+profit+"&hargadeal="+hargadeal+"&totalpenawaran="+totalpenawaran+"&id_customer="+id_customer+"&idmaterial="+idmaterial+"&berat="+berat+"&density="+density+"&thickness="+thickness+"&lebar="+lebar+"&panjang="+panjang+"&lebarnew="+lebarnew+"&qty="+qty+"&pegangan="+pegangan+"&sisa="+sisa+"&jmlpisau="+jmlpisau+"&harga="+harga+"&id="+id,
            success:function(html){
               $('#trhead_'+id).html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/SumHarga',
            data:"lotno="+lotno+"&total_harga_penawaran="+total_harga_penawaran+"&nama_material="+nama_material+"&waktu="+waktu+"&profit="+profit+"&hargadeal="+hargadeal+"&totalpenawaran="+totalpenawaran+"&id_customer="+id_customer+"&idmaterial="+idmaterial+"&berat="+berat+"&density="+density+"&thickness="+thickness+"&lebar="+lebar+"&panjang="+panjang+"&lebarnew="+lebarnew+"&qty="+qty+"&pegangan="+pegangan+"&sisa="+sisa+"&jmlpisau="+jmlpisau+"&harga="+harga+"&id="+id,
            success:function(html){
               $('#slot_total_peawaran').html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/CariTPanjang',
            data:"lotno="+lotno+"&total_harga_penawaran="+total_harga_penawaran+"&total_panjang="+total_panjang+"&total_berat="+total_berat+"&jml_pisau="+jml_pisau+"&jml_mother="+jml_mother+"&id_customer="+id_customer+"&idmaterial="+idmaterial+"&berat="+berat+"&density="+density+"&thickness="+thickness+"&lebar="+lebar+"&panjang="+panjang+"&lebarnew="+lebarnew+"&qty="+qty+"&pegangan="+pegangan+"&sisa="+sisa+"&jmlpisau="+jmlpisau+"&harga="+harga+"&id="+id,
            success:function(html){
               $('#tpanjang_slot').html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/CariMCoils',
            data:"lotno="+lotno+"&total_panjang="+total_panjang+"&total_berat="+total_berat+"&jml_pisau="+jml_pisau+"&jml_mother="+jml_mother+"&id_customer="+id_customer+"&idmaterial="+idmaterial+"&berat="+berat+"&density="+density+"&thickness="+thickness+"&lebar="+lebar+"&panjang="+panjang+"&lebarnew="+lebarnew+"&qty="+qty+"&pegangan="+pegangan+"&sisa="+sisa+"&jmlpisau="+jmlpisau+"&harga="+harga+"&id="+id,
            success:function(html){
               $('#mother_slot').html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/CariJPisau',
            data:"lotno="+lotno+"&total_panjang="+total_panjang+"&total_berat="+total_berat+"&jml_pisau="+jml_pisau+"&jml_mother="+jml_mother+"&id_customer="+id_customer+"&idmaterial="+idmaterial+"&berat="+berat+"&density="+density+"&thickness="+thickness+"&lebar="+lebar+"&panjang="+panjang+"&lebarnew="+lebarnew+"&qty="+qty+"&pegangan="+pegangan+"&sisa="+sisa+"&jmlpisau="+jmlpisau+"&harga="+harga+"&id="+id,
            success:function(html){
               $('#jpisau_slot').html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/CariTBProduk',
            data:"lotno="+lotno+"&total_panjang="+total_panjang+"&total_berat="+total_berat+"&jml_pisau="+jml_pisau+"&jml_mother="+jml_mother+"&id_customer="+id_customer+"&idmaterial="+idmaterial+"&berat="+berat+"&density="+density+"&thickness="+thickness+"&lebar="+lebar+"&panjang="+panjang+"&lebarnew="+lebarnew+"&qty="+qty+"&pegangan="+pegangan+"&sisa="+sisa+"&jmlpisau="+jmlpisau+"&harga="+harga+"&id="+id,
            success:function(html){
               $('#tberat_slot').html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/HitungWaktu',
            data:"lotno="+lotno+"&total_panjang="+total_panjang+"&total_berat="+total_berat+"&jml_pisau="+jml_pisau+"&jml_mother="+jml_mother+"&id_customer="+id_customer+"&idmaterial="+idmaterial+"&berat="+berat+"&density="+density+"&thickness="+thickness+"&lebar="+lebar+"&panjang="+panjang+"&lebarnew="+lebarnew+"&qty="+qty+"&pegangan="+pegangan+"&sisa="+sisa+"&jmlpisau="+jmlpisau+"&harga="+harga+"&id="+id,
            success:function(html){
               $('#group_waktu').html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/HitungTWaktu',
            data:"waktu="+waktu+"&total_waktu="+total_waktu,
            success:function(html){
               $('#twaktu_slot').html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/HitungBiaya',
            data:"lotno="+lotno+"&total_panjang="+total_panjang+"&total_berat="+total_berat+"&jml_pisau="+jml_pisau+"&jml_mother="+jml_mother+"&id_customer="+id_customer+"&idmaterial="+idmaterial+"&berat="+berat+"&density="+density+"&thickness="+thickness+"&lebar="+lebar+"&panjang="+panjang+"&lebarnew="+lebarnew+"&qty="+qty+"&pegangan="+pegangan+"&sisa="+sisa+"&jmlpisau="+jmlpisau+"&harga="+harga+"&id="+id,
            success:function(html){
               $('#group_biaya').html(html);
            }
        });
	}
	function HitungPanjang(id){
	    var berat=$('#dt_berat_'+id).val();
		var density=$('#dt_density_'+id).val();
		var thickness=$('#dt_thickness_'+id).val();
		var lebar=$('#dt_lebar_'+id).val();
		var panjang=$('#dt_panjang_'+id).val();
		var lebarnew=$('#dt_lebarnew_'+id).val();
		var qty=$('#dt_qty_'+id).val();
		var pegangan=$('#dt_pegangan_'+id).val();
		var sisa=$('#dt_sisa_'+id).val();
		var jmlpisau=$('#dt_jmlpisau_'+id).val();
		var waktu=$('#dt_waktu_'+id).val();
		var harga=$('#dt_harga_'+id).val();
		var profit=$('#dt_profit_'+id).val();
		var totalpenawaran=$('#dt_totalpenawaran_'+id).val();
		var hargadeal=$('#dt_hargadeal_'+id).val();
		var total_panjang=$('#total_panjang').val();
		
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/HitungPanjang',
            data:"berat="+berat+"&density="+density+"&thickness="+thickness+"&hargadeal="+hargadeal+"&totalpenawaran="+totalpenawaran+"&profit="+profit+"&harga="+harga+"&pegangan="+pegangan+"&waktu="+waktu+"&jmlpisau="+jmlpisau+"&sisa="+sisa+"&lebar="+lebar+"&panjang="+panjang+"&lebarnew="+lebarnew+"&qty="+qty+"&id="+id,
            success:function(html){
               $('#panjang_'+id).html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/HitungPegangan',
            data:"berat="+berat+"&density="+density+"&thickness="+thickness+"&hargadeal="+hargadeal+"&totalpenawaran="+totalpenawaran+"&profit="+profit+"&harga="+harga+"&pegangan="+pegangan+"&waktu="+waktu+"&jmlpisau="+jmlpisau+"&sisa="+sisa+"&lebar="+lebar+"&panjang="+panjang+"&lebarnew="+lebarnew+"&qty="+qty+"&id="+id,
            success:function(html){
               $('#pegangan_'+id).html(html);
            }
        });
		
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/HitungWaktuSatuan',
            data:"berat="+berat+"&density="+density+"&thickness="+thickness+"&hargadeal="+hargadeal+"&totalpenawaran="+totalpenawaran+"&profit="+profit+"&harga="+harga+"&pegangan="+pegangan+"&waktu="+waktu+"&jmlpisau="+jmlpisau+"&sisa="+sisa+"&lebar="+lebar+"&panjang="+panjang+"&lebarnew="+lebarnew+"&qty="+qty+"&id="+id,
            success:function(html){
               $('#waktu_'+id).html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/HitungHargaSatuan',
            data:"berat="+berat+"&density="+density+"&thickness="+thickness+"&hargadeal="+hargadeal+"&totalpenawaran="+totalpenawaran+"&profit="+profit+"&harga="+harga+"&pegangan="+pegangan+"&waktu="+waktu+"&jmlpisau="+jmlpisau+"&sisa="+sisa+"&lebar="+lebar+"&panjang="+panjang+"&lebarnew="+lebarnew+"&qty="+qty+"&id="+id,
            success:function(html){
               $('#harga_'+id).html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/HitungPisauSatuan',
            data:"berat="+berat+"&density="+density+"&thickness="+thickness+"&hargadeal="+hargadeal+"&totalpenawaran="+totalpenawaran+"&profit="+profit+"&harga="+harga+"&pegangan="+pegangan+"&waktu="+waktu+"&jmlpisau="+jmlpisau+"&sisa="+sisa+"&lebar="+lebar+"&panjang="+panjang+"&lebarnew="+lebarnew+"&qty="+qty+"&id="+id,
            success:function(html){
               $('#pisau_'+id).html(html);
            }
        });

		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/HitungTotalPanjangSatuan',
            data:"berat="+berat+"&density="+density+"&thickness="+thickness+"&hargadeal="+hargadeal+"&totalpenawaran="+totalpenawaran+"&profit="+profit+"&harga="+harga+"&pegangan="+pegangan+"&waktu="+waktu+"&jmlpisau="+jmlpisau+"&sisa="+sisa+"&lebar="+lebar+"&panjang="+panjang+"&lebarnew="+lebarnew+"&qty="+qty+"&id="+id,
            success:function(html){
               $('#totalpenawaran_'+id).html(html);
            }
        });
		
		

	}
	
	function cariJam(id,urut){ 
		var waktuMulai	=$("#start_"+id+"_"+urut).val();
		var waktuSelesai  =$("#finish_"+id+"_"+urut).val();
		
		console.log(waktuMulai);
		console.log(waktuSelesai);
		
		 hours = waktuSelesai.split(':')[0] - waktuMulai.split(':')[0],
          minutes = waktuSelesai.split(':')[1] - waktuMulai.split(':')[1];
 
      if (waktuMulai <= "12:00:00" && waktuSelesai >= "13:00:00"){
        a = 1;
      }else {
        a = 0;
      }
      minutes = minutes.toString().length<2?'0'+minutes:minutes;
      if(minutes<0){ 
          hours--;
          minutes = 60 + minutes;        
      }
      hours = hours.toString().length<2?'0'+hours:hours;
	  
	  console.log(hours+ ':' + minutes);
 
      $("#total_"+id+"_"+urut).val(hours+ ':' + minutes);
	  
	  // $("#total_"+id+"_"+urut).val(hours-a);
		
		// $.ajax({
            // type:"GET",
            // url:siteurl+'spk_produksi/GetSpk',
            // data:"jumlah="+jumlah+"&id_stock="+id_stock+"&id_material="+id_material+"&thickness="+thickness+"&nama_material="+nama_material,
            // success:function(html){
               // $("#list_spk").append(html);
            // }
        // });
    }
	
	
	
	
	
	//ARWANT
	$(document).on('keyup','.total_time', function(){
		sumTime();
	});
	
	$(document).on('keyup, change','.selisih_time', function(){
		let time_awal 	= $(this).parent().parent().find("td:nth-child(3) input").val();
		let time_akhir 	= $(this).parent().parent().find("td:nth-child(5) input").val();
		let selisih 	= $(this).parent().parent().find("td:nth-child(7) input");
		selisihTime(time_awal,time_akhir,selisih);
	});

	const sumTime = () => {
		let SUM = 0;
		$(".total_time" ).each(function() {
         	SUM += getNum($(this).val().split(",").join(""));
			 console.log(getNum($(this).val().split(",").join("")))
			 
			 
			 
 		});

		 $('#total_time').val(number_format(SUM));
		 $('#total_jam').val(number_format((SUM/60),2));
	}
	
	const selisihTime = (time_awal,time_akhir,selisih) => {
		hours 	= time_akhir.split(':')[0] - time_awal.split(':')[0],
		minutes = time_akhir.split(':')[1] - time_awal.split(':')[1];
		
		minutes = minutes.toString().length<2?'0'+minutes:minutes;
		if(minutes<0){ 
			hours--;
			minutes = 60 + minutes;        
		}
		
		hours = hours.toString().length<2?'0'+hours:hours;
		
		var selisih_menit = (getNum(hours) * 60) + getNum(minutes);
		if(selisih_menit < 0){
			var selisih_menit = selisih_menit * -1;
		}

		// selisih.val(hours+ ':' + minutes);
		selisih.val(selisih_menit);
		sumTime();
	}

	function number_format (number, decimals, dec_point, thousands_sep) {
			// Strip all characters but numerical ones.
			number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
			var n = !isFinite(+number) ? 0 : +number,
				prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
				sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
				dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
				s = '',
				toFixedFix = function (n, prec) {
					var k = Math.pow(10, prec);
					return '' + Math.round(n * k) / k;
				};
			// Fix for IE parseFloat(0.55).toFixed(0) = 0;
			s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
			if (s[0].length > 3) {
				s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
			}
			if ((s[1] || '').length < prec) {
				s[1] = s[1] || '';
				s[1] += new Array(prec - s[1].length + 1).join('0');
			}
			return s.join(dec);
		}


	function getNum(val) {
        if (isNaN(val) || val == '') {
            return 0;
        }
        return parseFloat(val);
    }

</script>
