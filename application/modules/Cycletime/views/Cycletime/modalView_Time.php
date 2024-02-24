<?php
$id = $this->uri->segment(3);
$listCode	= "SELECT * FROM help_default_name ORDER BY nm_default";
$getDef		= $this->db->query($listCode)->result_array();

$getKomp		= $this->db->query("SELECT * FROM product_parent ORDER BY product_parent ASC")->result_array();
$getPN		= $this->db->query("SELECT * FROM list_help WHERE group_by = 'pressure' ORDER BY name ASC")->result_array();
$getLiner		= $this->db->query("SELECT * FROM list_help WHERE group_by = 'liner' ORDER BY name ASC")->result_array();
$getStep		= $this->db->query("SELECT * FROM cycletime_step")->result_array();
$getDefault		= $this->db->query("SELECT * FROM cycletime_default WHERE id = '$id'")->row();
$getDetail		= $this->db->query("SELECT * FROM cycle_time_step_detail WHERE kode = '".$getDefault->kode."'")->result();
$getMachine		= $this->db->query("SELECT nm_mesin FROM machine WHERE no_mesin = '".$getDefault->id_mesin."' LIMIT 1")->row();


?>
<div class="box box-success">
	<div class="box-body" style="">
		<table id="my-grid" class="table table-striped table-bordered table-hover table-condensed" width="100%">
			<tbody>
				<tr style='background-color: #175477; color: white; font-size: 15px;'>
					<th class="text-center" colspan='3'>HEADER</th>
				</tr>
				<tr>
					<th class="text-left" width='34%'>Item</th>
					<th class="text-left" width='66%'>Standar Value</th>
				</tr>
				<tr>
					<td class="text-left vMid">Product <span class='text-red'>*</span></b></td>
					<td class="text-left">
						<?= strtoupper($getDefault->product_parent);?>
					</td>
				</tr>
				<tr>
					<td class="text-left vMid">Standart <span class='text-red'>*</span></b></td>
					<td class="text-left">
						<?=$getDefault->standard_code?>
					</td>
				</tr>
				<tr>
					<td class="text-left vMid">Pressure <span class='text-red'>*</span></b></td>
					<td class="text-left">
						<?=$getDefault->pn?>
					</td>
				</tr>
				<tr>
					<td class="text-left vMid">Liner <span class='text-red'>*</span></b></td>
					<td class="text-left">
						<?=floatval($getDefault->liner)?>
					</td>
				</tr>
				<tr>
					<td class="text-left vMid">Diameter <span class='text-red'>*</span></b></td>
					<td class="text-left">
						<?php
							echo form_input(array('type'=>'text','id'=>'diameter','name'=>'diameter','class'=>'form-control input-sm inSpL numberOnly','placeholder'=>'Diameter /mm','autocomplete'=>'off','disabled'=>'disabled'), floatval($getDefault->diameter));
						?>
					</td>
				</tr>
				<tr>
					<td class="text-left vMid">Diameter 2 <span class='text-red'>*</span></b></td>
					<td class="text-left">
						<?php
							echo form_input(array('type'=>'text','id'=>'diameter2','name'=>'diameter2','class'=>'form-control input-sm inSpL numberOnly','placeholder'=>'Diameter /mm','autocomplete'=>'off','disabled'=>'disabled'), floatval($getDefault->diameter2));
						?>
					</td>
				</tr>
				<tr>
					<td class="text-left vMid">Standard Length</td>
					<td class="text-left">
						<?php
							echo form_input(array('type'=>'text','id'=>'standard_length','name'=>'standard_length','class'=>'form-control input-sm inSpL numberOnly','placeholder'=>'Standard Length','autocomplete'=>'off','disabled'=>'disabled'), floatval($getDefault->standard_length));
						?>
					</td>
				</tr>


			</tbody>
		</table>
		<br>
		<table id="detail-step" class="table table-striped table-bordered table-hover table-condensed" width="100%">
				<thead>
					<tr style='background-color: #175477; color: white; font-size: 15px;'>
						<th class="text-center" colspan='3'><b>DETAIL STEP</b></th>
					</tr>
					<tr>
						<th class="text-left" width='50%'>STEP</th>
						<th class="text-center" width='50%'>STEP TIME(MINUTES)</th>
					</tr>
				</thead>
				<tbody id="tbody-detail">
					<?php
					$timeX	= 0;
					if(!empty($getDetail)){
						$detNum = 0;
						$timeX	= 0;
						foreach($getDetail AS $val => $valz){
							$detNum++; 
							$timeX += $valz->timing; 
							?>
							<tr class="addjs">
								<td><?=strtoupper($valz->step)?></td>
								<td style="text-align:center"><?=$valz->timing?></td>
							</tr>
							<?php
						}
					}
					else{
						echo "<tr><td colspan='2'>Detail step belum ditambahkan</td></tr>";	
					}
					?>
					<tr>
						<td class="text-left" width='50%'>JUMLAH TIME / 60</td>
						<td class="text-center" width='50%'><?= number_format($timeX/60, 2);?></td>
					</tr>
				</tbody>
		</table>
		<br>
		<table id="my-grid" class="table table-striped table-bordered table-hover table-condensed" width="100%" style="margin-top:7px">
			<tbody>
				<tr style='background-color: #175477; color: white; font-size: 15px;'>
					<th class="text-center" colspan='2'><b>MANPOWER</b></th>
				</tr>
				<tr>
					<td class="text-left vMid" width='50%'>MANPOWER</td>
					<td class="text-center" width='50%'>
						<?php
							echo $getDefault->man_power;
						?>
					</td>
				</tr>
				<tr>
					<td class="text-left vMid" width='50%'>MANHOURS</td>
					<td class="text-center" width='50%'>
						<?php
							echo number_format($getDefault->man_hours,1);
						?>
					</td>
				</tr>
				<tr>
					<td class="text-left vMid" width='50%'>MACHINE</td>
					<td class="text-center" width='50%'>
						<?php
							echo (!empty($getMachine->nm_mesin))?strtoupper($getMachine->nm_mesin):'NONE MACHINE';
						?>
					</td>
				</tr>
			</tbody>
		</table>
		<br>
		
	</div>
</div>

<style>
	.inSp{
		text-align: center;
		display: inline-block;
		width: 100px;
	}
	.inSp2{
		text-align: center;
		display: inline-block;
		width: 80px;
	}
	.inSpL{
		text-align: left;
	}
	.vMid{
		vertical-align: middle !important;
	}

</style>
