<?php
$id 			= (!empty($data[0]->id))?$data[0]->id:'';
$kdcab 			= (!empty($data[0]->id))?$data[0]->kdcab:'';
$kd_asset 		= (!empty($data[0]->id))?$data[0]->kd_asset:'';
$kd_manual 		= (!empty($data[0]->id))?$data[0]->kd_manual:'';
$nm_asset 		= (!empty($data[0]->id))?strtoupper($data[0]->nm_asset):'';
$category 		= (!empty($data[0]->id))?$data[0]->category:'';
$category_pajak = (!empty($data[0]->id))?$data[0]->category_pajak:'';
$lokasi_asset 	= (!empty($data[0]->id))?$data[0]->lokasi_asset:'';
$cost_center 	= (!empty($data[0]->id))?strtoupper($data[0]->nm_dept):'';
$nilai_asset 	= (!empty($data[0]->id))?$data[0]->nilai_asset:'';
$depresiasi 	= (!empty($data[0]->id))?$data[0]->depresiasi:'';
$tgl_perolehan 	= (!empty($data[0]->id))?date('d F Y', strtotime($data[0]->tgl_perolehan)):'';
$value 			= (!empty($data[0]->id))?$data[0]->value:'';
$foto 			= (!empty($data[0]->id))?$data[0]->foto:'';
$qty 			= (!empty($data[0]->id))?1:'';
$paths 	= base_url().'/assets/foto/'.$foto;
$dist 			= (!empty($data[0]->id))?'disabled':'';

// echo $id;
?>
<div class="box box-primary">
	<div class="box-header">
		<h3 class="box-title"></h3>
	</div>
	<div class="box-body">
		<div class='form-group row'>		 	 
			<label class='label-control col-sm-2'><b>Kode Asset <span class='text-red'>*</span></b></label>
			<div class='col-sm-4'>             
					<?php
						echo form_input(array('id'=>'kd_manual','name'=>'kd_manual','class'=>'form-control input-md','autocomplete'=>'off','placeholder'=>'Kode Asset',$dist=>$dist),$kd_manual);											
					?>		
			</div>
		</div>
		<div class='form-group row'>
			<label class='label-control col-sm-2'><b>Asset Milik <span class='text-red'>*</span></b></label>
			<div class='col-sm-4'>  
				<select name='branch' id='branch' class='form-control input-md chosen-select'>
					<option>Pilih Asset Milik</option>
					<?php
						foreach($list_cab AS $val => $valx){
							$sexd	= ($valx['id_branch'] == $kdcab)?'selected':'';
							echo "<option value='".$valx['id_branch']."' ".$sexd.">".strtoupper($valx['nm_alias'])."</option>";
						}
					?>
				</select>	
			</div>
			<label class='label-control col-sm-2'><b>Kategori Pajak <span class='text-red'>*</span></b></label>
			<div class='col-sm-4'>  
				<select name='category_pajak' id='category_pajak' class='form-control input-md chosen-select'  <?=$dist;?>>
					<option>Pilih Kategori Pajak</option>
					<?php
						foreach($list_pajak AS $val => $valx){
							$sexd	= ($valx['id'] == $category_pajak)?'selected':'';
							echo "<option value='".$valx['id']."' ".$sexd.">".strtoupper($valx['nm_category'])."</option>";
						}
					?>
				</select>	
			</div>
		</div>
		<div class='form-group row'>		 	 
			<label class='label-control col-sm-2'><b>Nama Asset <span class='text-red'>*</span></b></label>
			<div class='col-sm-4'>             
					<?php
						echo form_input(array('id'=>'nm_asset','name'=>'nm_asset','class'=>'form-control input-md','autocomplete'=>'off','placeholder'=>'Nama Asset',$dist=>$dist),$nm_asset);											
						echo form_input(array('type'=>'hidden','id'=>'kd_asset','name'=>'kd_asset','class'=>'form-control input-md','autocomplete'=>'off','placeholder'=>'Nama Asset'),$kd_asset);											
					?>		
			</div>
			<label class='label-control col-sm-2'><b>Kategori <span class='text-red'>*</span></b></label>
			<div class='col-sm-4'>  
				<select name='category' id='category' class='form-control input-md chosen-select'  <?=$dist;?>>
					<option>Pilih Kategori</option>
					<?php
						foreach($list_catg AS $val => $valx){
							$sexd	= ($valx['id'] == $category)?'selected':'';
							echo "<option value='".$valx['id']."' ".$sexd.">".strtoupper($valx['nm_category'])."</option>";
						}
					?>
				</select>	
			</div>
		</div>
		<div class='form-group row'>		 	 
			<label class='label-control col-sm-2'><b>Department  <span class='text-red'>*</span></b></label>
			<div class='col-sm-4'> 
				<select name='lokasi_asset' id='lokasi_asset' class='form-control input-md chosen-select' <?=$dist;?>>
					<option>Pilih Department</option>
					<?php
						foreach($list_dept AS $val => $valx){
							$sexd	= ($valx['id'] == $lokasi_asset)?'selected':'';
							echo "<option value='".$valx['id']."' ".$sexd.">".strtoupper($valx['nm_dept'])."</option>";
						}
					?>
				</select>	
			</div>
			<label class='label-control col-sm-2'><b>Cost Center  <span class='text-red'>*</span></b></label>
			<div class='col-sm-4'> 
				<?php 
				if(!empty($data[0]->id)){ 
					echo form_input(array('id'=>'cost_center','name'=>'cost_center','class'=>'form-control input-md','autocomplete'=>'off','placeholder'=>'Costcenter',$dist=>$dist),$cost_center);											
				}
				?>
				<?php 
				if(empty($data[0]->id)){ ?>
				<select name='cost_center' id='cost_center' class='form-control input-md chosen-select' <?=$dist;?>>
					<option>List Empty</option>
				</select>
				<?php } ?>
			</div>
		</div>
		<?php if(!empty($data[0]->id)){ ?>
		<div class='form-group row'>		 	 
			<label class='label-control col-sm-2'><b>Department  New <span class='text-red'>*</span></b></label>
			<div class='col-sm-4'> 
				<select name='lokasi_asset_new' id='lokasi_asset_new' class='form-control input-md chosen-select'>
					<option value='0'>Pilih Department</option>
					<?php
						foreach($list_dept AS $val => $valx){
							// $sexd	= ($valx['nm_dept'] == 'UMUM')?'selected':'';
							$sexd	= "";
							echo "<option value='".$valx['id']."' ".$sexd.">".strtoupper($valx['nm_dept'])."</option>";
						}
					?>
				</select>	
			</div>
			<label class='label-control col-sm-2'><b>Cost Center  New <span class='text-red'>*</span></b></label>
			<div class='col-sm-4'> 
				<select name='cost_center_new' id='cost_center_new' class='form-control input-md chosen-select'><option value='0'>List Empty</option></select>	
			</div>
		</div>
		<?php } ?>
		<div class='form-group row'>		 	 
			<label class='label-control col-sm-2'><b>Nilai Asset <span class='text-red'>*</span></b></label>
			<div class='col-sm-4'>             
					<?php
						echo form_input(array('id'=>'nilai_asset','name'=>'nilai_asset','class'=>'form-control input-md','autocomplete'=>'off','placeholder'=>'Nilai Asset','data-decimal'=>'.','data-thousand'=>'','data-precision'=>'0','data-allow-zero'=>false,$dist=>$dist),$nilai_asset);											
					?>		
			</div>
			<label class='label-control col-sm-2'><b>Tanggal Perolehan <span class='text-red'>*</span></b></label>
			<div class='col-sm-4'>             
				<?php 
					echo form_input(array('id'=>'tanggal','name'=>'tanggal','class'=>'form-control input-md','autocomplete'=>'off','placeholder'=>'Tanggal', 'readonly'=>'readonly',$dist=>$dist),$tgl_perolehan);											
				?>
			</div>
		</div>
		<div class='form-group row'>		 	 
			<label class='label-control col-sm-2'><b>Qty <span class='text-red'>*</span></b></label>
			<div class='col-sm-4'>            
					<?php
						echo form_input(array('id'=>'qty','name'=>'qty','class'=>'form-control input-md','autocomplete'=>'off','placeholder'=>'Qty Assets','data-decimal'=>'.','data-thousand'=>'','data-precision'=>'0','data-allow-zero'=>false,$dist=>$dist),$qty);											
					?>		
			</div>
			<?php if(empty($data[0]->id)){ ?>
			<label class='label-control col-sm-2'><b>Foto <span class='text-red'>*</span></b></label> 
			<div class='col-sm-4'>             
				<?php 
					echo form_input(array('type'=>'file','id'=>'foto','name'=>'foto','class'=>'form-control input-md','accept'=>'image/*'));											
				?>
			</div>
			<?php } ?>
		</div>
		<div class='form-group row hide_penyusutan'>		 	 
			<label class='label-control col-sm-2'><b>Jangka Waktu (Tahun)</b></label>
			<div class='col-sm-4'>
				<?php
					echo form_input(array('id'=>'depresiasi','name'=>'depresiasi','class'=>'form-control input-md','autocomplete'=>'off','placeholder'=>'Jangka Waktu','readonly'=>'readonly',$dist=>$dist),$depresiasi);											
				?>	
			</div>
			<label class='label-control col-sm-2'><b>Dipresiasi Perbulan</b></label>
			<div class='col-sm-4'>             
					<?php
						echo form_input(array('id'=>'value','name'=>'value','class'=>'form-control input-md','autocomplete'=>'off','placeholder'=>'Dipresiasi Perbulan', 'readonly'=>'readonly','data-decimal'=>'.','data-thousand'=>'','data-precision'=>'0','data-allow-zero'=>false,$dist=>$dist),$value);											
					?>		
			</div>
		</div>
		<div class='form-group row'>		 	 
			<label class='label-control col-sm-2'><b>Penyusutan <span class='text-red'>*</span></b></label>
			<div class='col-sm-4'>             
				<select name='penyusutan' id='penyusutan' class='form-control input-md chosen-select' <?=$dist;?>>
					<option value='Y'>Yes</option>
					<option value='N'>No</option>
				</select>
			</div>
		</div>
		<div class='form-group row'>
			<div class='col-sm-12'>
				<?php
					if(empty($data[0]->id)){
						echo form_button(array('type'=>'button','class'=>'btn btn-md btn-primary','value'=>'save','content'=>'Save','id'=>'simpan-bro','style'=>'width:100px; float:right;')).' ';
					}
					if(!empty($data[0]->id)){
						echo form_button(array('type'=>'button','class'=>'btn btn-md btn-success','value'=>'save','content'=>'Save','id'=>'move_asset','style'=>'width:100px; float:right;')).' ';
					}
				?>
			</div>
		</div>
		<?php if(!empty($data[0]->id)){ ?>
		<div class='form-group row'>	
			<label class='label-control col-sm-2'><b>Foto</b></label>
			<div class='col-sm-4'>
				<img src="<?=$paths;?>" width='400px' height='400px'> 
			</div>
		</div>
		<?php } ?>
	</div>
</div>
<?php if(empty($data[0]->id)){ ?>
	<style>
		#tanggal{
			cursor:pointer;
			background-color: white;
		}
	</style>
<?php } ?>
<script>
	$(function() {
		$('#nilai_asset').maskMoney();
        $('#qty').maskMoney();
		$('.chosen-select').select2({ width: '100%' });
		
		$('#tanggal').datepicker({
			format : 'yyyy-mm-dd'
			// minDate: 0
		});
    });

</script>