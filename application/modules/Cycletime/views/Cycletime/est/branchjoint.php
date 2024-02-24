<?php
$this->load->view('include/side_menu');
?>
<form action="#" method="POST" id="form_proses_bro">
	<div class="box box-primary">
		<div class="box-header">
			<h3 class="box-title"><?php echo $title;?></h3>
			<button type='button' name='simpan-bro' id='simpan-bro' class='btn btn-primary btn-sm' style='width:100px;right:0;float:right;margin:5px'>Save</button>
			<a class="btn btn-sm btn-success" id="calc" style="right:0;float:right;margin:5px">CALC</a>
		</div>

		<div class="box-body">
			<!-- NEW-->

			<div class='headerTitleGroup'>GROUP COMPONENT</div>
			<div class='form-group row'>
				<label class='label-control col-sm-2'><b>Diameter 1 <span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<?php
						echo form_input(array('id'=>'top_type_1','name'=>'top_type_1','class'=>'form-control input-sm Hide'));
						echo form_input(array('id'=>'diameter_1','name'=>'diameter_1','class'=>'form-control input-sm Hide'));
					?>
					<select name='d1' id='d1' class='form-control input-sm'>
						<option value='0'>Select Diameter</option>
					<?php
						foreach($product AS $val => $valx){
							echo "<option value='".$valx['id']."'>".ucfirst(strtolower($valx['nm_product']))."</option>";
						}
					 ?>
					</select>
				</div>
				<label class='label-control col-sm-2'><b>Series <span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<select name='series' id='series' class='form-control input-sm'>
						<option value='0'>Select Series</option>
					<?php
						foreach($series AS $val => $valx){
							echo "<option value='".$valx['kode_group']."'>".strtoupper($valx['kode_group'])."</option>";
						}
					 ?>
					</select>
				</div>

			</div>
			<div class='form-group row'>
				<label class='label-control col-sm-2'><b>Diameter 2 <span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<?php
						echo form_input(array('id'=>'top_type_2','name'=>'top_type_2','class'=>'form-control input-sm Hide','readonly'=>'readonly'));
						echo form_input(array('id'=>'diameter_2','name'=>'diameter_2','class'=>'form-control input-sm Hide','readonly'=>'readonly'));
					?>
					<select name='d2' id='d2' class='form-control input-sm'>
						<option value='0'>Select Diameter</option>
					<?php
						foreach($product AS $val => $valx){
							echo "<option value='".$valx['id']."'>".ucfirst(strtolower($valx['nm_product']))."</option>";
						}
					 ?>
					</select>
				</div>
				<label class='label-control col-sm-2'><b>Standard Tolerance By <span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<select name='top_toleran' id='top_toleran' class='form-control input-sm'>
						<option value='0'>Select Tolerance By</option>
					<?php
						foreach($customer AS $val => $valx){
							$seL = ($valx['id_customer'] == 'C100-1903000')?'selected':'';
							// $seL = "";
							echo "<option value='".$valx['id_customer']."' ".$seL.">".strtoupper(strtolower($valx['nm_customer']))."</option>";
						}
					 ?>
					</select>
				</div>

			</div>

			<div class='headerTitleGroup'>SPESIFICATION COMPONENT</div>
			<div class='form-group row'>
				<label class='label-control col-sm-1'><b>Minimum Width <span class='text-red'>*</span></b></label>
				<div class='col-sm-3'>
					<?php
						echo form_input(array('id'=>'minimum_width','name'=>'minimum_width','class'=>'form-control input-sm numberOnly','placeholder'=>'Width Minimum'));
					?>
				</div>
				<label class='label-control col-sm-1'><b>PIPE Thickness <span class='text-red'>*</span></b></label>
				<div class='col-sm-3'>
					<?php
						echo form_input(array('type'=>'text','id'=>'pipe_thickness','name'=>'pipe_thickness','class'=>'form-control input-sm numberOnly','placeholder'=>'Pipe Thickness'));
					?>
				</div>
				<label class='label-control col-sm-1'><b>Faktor <span class='text-red'>*</span></b></label>
				<div class='col-sm-3'>
					<?php
						echo form_input(array('type'=>'text','id'=>'factor','name'=>'factor','class'=>'form-control input-sm','readonly'=>'readonly','value'=>'3'));
					?>
				</div>
			</div>
			<div class='form-group row'>
				<label class='label-control col-sm-1'></label>
				<div class='col-sm-3'>
				</div>
				<label class='label-control col-sm-1'><b>Joint Thickness <span class='text-red'>*</span></b></label>
				<div class='col-sm-3'>
					<?php
						echo form_input(array('type'=>'text','id'=>'joint_thickness','name'=>'joint_thickness','class'=>'form-control input-sm','readonly'=>'readonly','value'=>'0'));
					?>
				</div>
				<label class='label-control col-sm-1'><b>Factor Thickness <span class='text-red'>*</span></b></label>
				<div class='col-sm-3'>
					<?php
						echo form_input(array('type'=>'text','id'=>'factor_thickness','name'=>'factor_thickness','class'=>'form-control input-sm','readonly'=>'readonly','value'=>'1.5'));
					?>
				</div>
			</div>



			<div class='headerTitle'>GLASS</div>
			<table class="table" border="0">
				<thead>
					<th width="20%">MATERIAL TYPE</th>
					<th width="16%">MATERIAL</th>
					<th width="16%">AREA WEIHT</th>
					<th width="16%">RESIN CONTENT</th>
					<th width="16%">THICKNESS</th>
					<th width="16%">MATERIAL WEIGHT</th>
				</thead>
				<tbody>
					<tr>
						<td>VEIL</td>
						<td>
							<?php
								echo $this->master_model->get_select('veil');;
							 ?>
						</td>

						<td>
							<?php
								echo form_input(array('id'=>'veil_area_weight','name'=>'glass[area_weight][]','class'=>'form-control input-sm numberOnly','placeholder'=>'Area Weight','readonly'=>'readonly'));
							?>
						</td>

						<td>
							<?php
								$veil_res = 9/1;
								echo form_input(array('id'=>'veil_resin_content','name'=>'glass[resin_content][]','class'=>'form-control input-sm numberOnly','placeholder'=>'Resin Content','value'=>$veil_res));
							?>
						</td>

						<td>
							<?php
								echo form_input(array('id'=>'veil_thickness','name'=>'glass[thickness][]','class'=>'form-control input-sm numberOnly','placeholder'=>'Thickness'));
							?>
						</td>

						<td>
							<?php
								echo form_input(array('id'=>'veil_material_weight','name'=>'glass[material_weight][]','class'=>'form-control input-sm numberOnly','placeholder'=>'Material Weight','value'=>'0.39'));
							?>
						</td>
					</tr>
					<tr>
						<td>WR</td>
						<td>
							<?php
								echo $this->master_model->get_select('wr');;
							 ?>
						</td>

						<td>
							<?php
								echo form_input(array('id'=>'wr_area_weight','name'=>'glass[area_weight][]','class'=>'form-control input-sm numberOnly','placeholder'=>'Area Weight','readonly'=>'readonly'));
							?>
						</td>

						<td>
							<?php
								$wr_res = 45/55;
								echo form_input(array('id'=>'wr_resin_content','name'=>'glass[resin_content][]','class'=>'form-control input-sm numberOnly','placeholder'=>'Resin Content','value'=>round($wr_res,3)));
							?>
						</td>

						<td>
							<?php
								echo form_input(array('id'=>'wr_thickness','name'=>'glass[thickness][]','class'=>'form-control input-sm numberOnly','placeholder'=>'Thickness'));
							?>
						</td>

						<td>
							<?php
								echo form_input(array('id'=>'wr_material_weight','name'=>'glass[material_weight][]','class'=>'form-control input-sm numberOnly','placeholder'=>'Material Weight','value'=>'73.32'));
							?>
						</td>
					</tr>
					<tr>
						<td>CSM</td>
						<td>
							<?php
								echo $this->master_model->get_select('csm');;
							 ?>
						</td>

						<td>
							<?php
								echo form_input(array('id'=>'csm_area_weight','name'=>'glass[area_weight][]','class'=>'form-control input-sm numberOnly','placeholder'=>'Area Weight','readonly'=>'readonly'));
							?>
						</td>

						<td>
							<?php
								$csm_res = 70/30;
								echo form_input(array('id'=>'csm_resin_content','name'=>'glass[resin_content][]','class'=>'form-control input-sm numberOnly','placeholder'=>'Resin Content','value'=>round($csm_res,3)));
							?>
						</td>

						<td>
							<?php
								echo form_input(array('id'=>'csm_thickness','name'=>'glass[thickness][]','class'=>'form-control input-sm numberOnly','placeholder'=>'Thickness'));
							?>
						</td>

						<td>
							<?php
								echo form_input(array('id'=>'csm_material_weight','name'=>'glass[material_weight][]','class'=>'form-control input-sm numberOnly','placeholder'=>'Material Weight','value'=>'227.99'));
							?>
						</td>
					</tr>
				</tbody>
			</table>

			<div class='headerTitle'>RESIN & ADD</div>
			<table class="table" border="0">
				<thead>
					<th width="25%">MATERIAL TYPE</th>
					<th width="25%">MATERIAL</th>
					<th width="25%">PERCENTAGE(%)</th>
					<th width="25%">MATERIAL WEIGHT</th>
				</thead>
				<tbody>
					<tr>
						<td>RESIN</td>
						<td>
							<?php
								echo $this->master_model->get_select_detail('TYP-0001','resinnadd[id_material][]','RESIN');;
							 ?>
						</td>

						<td>
							<?php
								echo form_input(array('id'=>'resin_percentage','name'=>'resinnadd[percentage][]','style'=>'text-align:center','class'=>'form-control input-sm numberOnly','placeholder'=>'Resin Material Weight','value'=>'NaN'));
							?>
						</td>

						<td>
							<?php
								echo form_input(array('id'=>'resin_material_weight','name'=>'resinnadd[material_weight][]','style'=>'text-align:center','class'=>'form-control input-sm numberOnly','placeholder'=>'Resin Material Weight','value'=>'0'));
							?>
						</td>
					</tr><!--1-->
					<tr><!--2-->
						<td>CATALYS</td>
						<td>
							<?php
								echo $this->master_model->get_select_detail('TYP-0002','resinnadd[id_material][]','CATALYS');
							 ?>
						</td>

						<td>
							<?php
								echo form_input(array('id'=>'catalys_percentage','name'=>'resinnadd[percentage][]','style'=>'text-align:center','class'=>'form-control input-sm numberOnly','placeholder'=>'Resin Material Weight','value'=>'2'));
							?>
						</td>

						<td>
							<?php
								echo form_input(array('id'=>'catalys_material_weight','name'=>'resinnadd[material_weight][]','style'=>'text-align:center','class'=>'form-control input-sm numberOnly','placeholder'=>'Resin Material Weight','value'=>'0'));
							?>
						</td>
					</tr>><!--2-->
					<tr><!--19-->
						<td>DEMPUL</td>
						<td>
							<?php
								echo $this->master_model->get_select_detail('TYP-0019','resinnadd[id_material][]','DEMPUL');
							 ?>
						</td>

						<td>
							<?php
								echo form_input(array('id'=>'dempul_percentage','name'=>'resinnadd[percentage][]','style'=>'text-align:center','class'=>'form-control input-sm numberOnly','placeholder'=>'Resin Material Weight','value'=>'140'));
							?>
						</td>

						<td>
							<?php
								echo form_input(array('id'=>'dempul_material_weight','name'=>'resinnadd[material_weight][]','style'=>'text-align:center','class'=>'form-control input-sm numberOnly','placeholder'=>'Resin Material Weight','value'=>'0'));
							?>
						</td>
					</tr>
					<tr><!--25-->
						<td>CARBOSIL BUBUK</td>
						<td>
							<?php
								echo $this->master_model->get_select_detail('TYP-0025','resinnadd[id_material][]','CARBOSIL BUBUK');
							 ?>
						</td>

						<td>
							<?php
								echo form_input(array('id'=>'carbosilbubuk_percentage','name'=>'resinnadd[percentage][]','style'=>'text-align:center','class'=>'form-control input-sm numberOnly','placeholder'=>'Resin Material Weight','value'=>'15'));
							?>
						</td>

						<td>
							<?php
								echo form_input(array('id'=>'carbosilbubuk_material_weight','name'=>'resinnadd[material_weight][]','style'=>'text-align:center','class'=>'form-control input-sm numberOnly','placeholder'=>'Resin Material Weight','value'=>'0'));
							?>
						</td>
					</tr>
					<tr><!--1-->
						<td>RESIN CARBOSIL</td>
						<td>
							<?php
								echo $this->master_model->get_select_detail('TYP-0001','resinnadd[id_material][]','RESIN CARBOSIL');
							 ?>
						</td>

						<td>
							<?php
								echo form_input(array('id'=>'resincarbosil_percentage','name'=>'resinnadd[percentage][]','style'=>'text-align:center','class'=>'form-control input-sm numberOnly','placeholder'=>'Resin Material Weight','value'=>'85'));
							?>
						</td>

						<td>
							<?php
								echo form_input(array('id'=>'resincarbosil_material_weight','name'=>'resinnadd[material_weight][]','style'=>'text-align:center','class'=>'form-control input-sm numberOnly','placeholder'=>'Resin Material Weight','value'=>'0'));
							?>
						</td>
					</tr>
					<tr><!--1-->
						<td>RESIN TOPCOAT</td>
						<td>
							<?php
								echo $this->master_model->get_select_detail('TYP-0001','resinnadd[id_material][]','RESIN TOPCOAT');
								?>
						</td>

						<td>
							<?php
								echo form_input(array('id'=>'resintopcoat_percentage','name'=>'resinnadd[percentage][]','style'=>'text-align:center','class'=>'form-control input-sm numberOnly','placeholder'=>'Resin Material Weight','value'=>'NaN'));
							?>
						</td>

						<td>
							<?php
								echo form_input(array('id'=>'resintopcoat_material_weight','name'=>'resinnadd[material_weight][]','style'=>'text-align:center','class'=>'form-control input-sm numberOnly','placeholder'=>'Resin Material Weight','value'=>'0'));
							?>
						</td>
					</tr>
					<tr>
						<td>COBALT</td>
						<td>
							<?php
								echo $this->master_model->get_select_detail('TYP-0021','resinnadd[id_material][]','COBALT');
							 ?>
						</td>

						<td>
							<?php
								echo form_input(array('id'=>'cobalt_percentage','name'=>'resinnadd[percentage][]','style'=>'text-align:center','class'=>'form-control input-sm numberOnly','placeholder'=>'Resin Material Weight','value'=>'2'));
							?>
						</td>

						<td>
							<?php
								echo form_input(array('id'=>'cobalt_material_weight','name'=>'resinnadd[material_weight][]','style'=>'text-align:center','class'=>'form-control input-sm numberOnly','placeholder'=>'Resin Material Weight','value'=>'0'));
							?>
						</td>
					</tr>
					<tr>
						<td>PIGMENT</td>
						<td>
							<?php
								echo $this->master_model->get_select_detail('TYP-0007','resinnadd[id_material][]','PIGMENT');
							 ?>
						</td>

						<td>
							<?php
								echo form_input(array('id'=>'pigment_percentage','name'=>'resinnadd[percentage][]','style'=>'text-align:center','class'=>'form-control input-sm numberOnly','placeholder'=>'Resin Material Weight','value'=>'5'));
							?>
						</td>

						<td>
							<?php
								echo form_input(array('id'=>'pigment_material_weight','name'=>'resinnadd[material_weight][]','style'=>'text-align:center','class'=>'form-control input-sm numberOnly','placeholder'=>'Resin Material Weight','value'=>'0'));
							?>
						</td>
					</tr>
					<tr>
						<td>TINUVIN</td>
						<td>
							<?php
								echo $this->master_model->get_select_detail('TYP-0019','resinnadd[id_material][]','TINUVIN');
							 ?>
						</td>

						<td>
							<?php
								echo form_input(array('id'=>'tinuvin_percentage','name'=>'resinnadd[percentage][]','style'=>'text-align:center','class'=>'form-control input-sm numberOnly','placeholder'=>'Resin Material Weight','value'=>'0'));
							?>
						</td>

						<td>
							<?php
								echo form_input(array('id'=>'tinuvin_material_weight','name'=>'resinnadd[material_weight][]','style'=>'text-align:center','class'=>'form-control input-sm numberOnly','placeholder'=>'Resin Material Weight','value'=>'0'));
							?>
						</td>
					</tr>
					<tr>
						<td>CHLOROFORM</td>
						<td>
							<?php
								echo $this->master_model->get_select_detail('TYP-0019','resinnadd[id_material][]','CHLOROFORM');
							 ?>
						</td>

						<td>
							<?php
								echo form_input(array('id'=>'chloroform_percentage','name'=>'resinnadd[percentage][]','style'=>'text-align:center','class'=>'form-control input-sm numberOnly','placeholder'=>'Resin Material Weight','value'=>'2'));
							?>
						</td>

						<td>
							<?php
								echo form_input(array('id'=>'chloroform_material_weight','name'=>'resinnadd[material_weight][]','style'=>'text-align:center','class'=>'form-control input-sm numberOnly','placeholder'=>'Resin Material Weight','value'=>'0'));
							?>
						</td>
					</tr>
					<tr>
						<td>SOLUTION WAX</td>
						<td>
							<?php
								echo $this->master_model->get_select_detail('TYP-0008','resinnadd[id_material][]','SOLUTION WAX');
							 ?>
						</td>

						<td>
							<?php
								echo form_input(array('id'=>'solutionwax_percentage','name'=>'resinnadd[percentage][]','style'=>'text-align:center','class'=>'form-control input-sm numberOnly','placeholder'=>'Resin Material Weight','value'=>'3'));
							?>
						</td>

						<td>
							<?php
								echo form_input(array('id'=>'solutionwax_material_weight','name'=>'resinnadd[material_weight][]','style'=>'text-align:center','class'=>'form-control input-sm numberOnly','placeholder'=>'Resin Material Weight','value'=>'0'));
							?>
						</td>
					</tr>
				</tbody>
			</table>

			<!-- ====================================================================================================== -->
			<!-- ============================================INSIDE LAMINATION========================================= -->
			<!-- ====================================================================================================== -->

			<div class='headerTitle'>INSIDE LAMINATION</div>
			<table class="table" border="0">
				<thead>
					<th width="5%">Lapisan</th>
					<th width="10%">STD GLASS CONFIGURATION</th>
					<th width="5%">WIDTH</th>
					<th width="5%">STAGE</th>
					<th width="10%">GLASS CONFIGURATION</th>
					<th width="15%" colspan="2">THICKNESS</th>
					<th width="5%">GLASS LENGTH</th>
					<th width="5%">WEIGHT VEIL</th>
					<th width="5%">WEIGTH CSM</th>
					<th width="5%">WEIGTH WR</th>
				</thead>
				<tbody>
					<?php $no = 0; ?>
					<?php foreach ($ILamination as $key => $v) { $no++?>
									<tr id="IL_<?=$no;?>">
										<input type="hidden" id="diameter_penentuan_<?=$no?>" name="diameter_penentuan_<?=$no?>" value="<?=$v['diameter_penentuan']?>">
										<input type="hidden" id="std_gc_<?=$no?>" name="std_gc_<?=$no?>" value="<?=$v['type']?>">

										<td >
											<input class="form-control input-sm" type="text" id="lapisan_<?=$no?>" name="lapisan_<?=$no?>" value="<?=$v['lapisan']?>">
										</td>

										<td >
											<?php	if ($v['type'] == "RUMUS") {?>
												<input class="form-control input-sm" type="text" id="std_<?=$no?>" name="std_<?=$no?>" value="">
											<?php	}else {	?>
												<input class="form-control input-sm" type="text" id="std_<?=$no?>" name="std_<?=$no?>" value="<?=$v['type']?>">
											<?php	}	?>
										</td>

										<td >
											<input class="form-control input-sm" type="text" id="width_<?=$no?>" name="width_<?=$no?>" value="">
										</td>

										<?php	if ($no == 1) {?>
											<td  style="text-align:center;vertical-align:middle" rowspan="<?=count($ILamination);?>">
												<input class="form-control input-sm" type="text" id="stage_<?=$no?>" name="stage_<?=$no?>" value="<?=$v['stage_ke']?>">
											</td>
										<?php	}	?>

										<td >
											<input class="form-control input-sm" type="text" id="glassconfiguration_<?=$no?>" name="glassconfiguration_<?=$no?>" value="">
										</td>

										<td >
											<input class="form-control input-sm" type="text" id="thickness1_<?=$no?>" name="thickness1_<?=$no?>" value="">
										</td>

										<td >
											<input class="form-control input-sm" type="text" id="thickness2_<?=$no?>" name="thickness2_<?=$no?>" value="">
										</td>

										<?php	if ($no == 1) {?>
											<td rowspan="<?=count($ILamination);?>" >
												<input class="form-control input-sm" type="text" id="glasslength_<?=$no?>" name="glasslength_<?=$no?>" value="">
											</td>
										<?php	}	?>

										<td >
											<input class="form-control input-sm" type="text" id="veil_weight_<?=$no?>" name="veil_weight_<?=$no?>" value="">
										</td>

										<td >
											<input class="form-control input-sm" type="text" id="csm_weight_<?=$no?>" name="csm_weight_<?=$no?>" value="">
										</td>

										<td >
											<input class="form-control input-sm" type="text" id="wr_weight_<?=$no?>" name="wr_weight_<?=$no?>" value="">
										</td>

									</tr>
					<?php } ?>
					<input type="hidden" name="no_il" value="<?=$no?>">
				</tbody>
			</table>


			<!-- ====================================================================================================== -->
			<!-- ============================================OUTSIDE LAMINATION======================================== -->
			<!-- ====================================================================================================== -->

			<div class='headerTitle'>OUTSIDE LAMINATION</div>
			<table class="table" border="0">
				<thead>
					<th width="5%">Lapisan</th>
					<th width="10%">STD GLASS CONFIGURATION</th>
					<th width="5%">WIDTH</th>
					<th width="5%">STAGE</th>
					<th width="10%">GLASS CONFIGURATION</th>
					<th width="15%" colspan="2">THICKNESS</th>
					<th width="5%">GLASS LENGTH</th>
					<th width="5%">WEIGHT VEIL</th>
					<th width="5%">WEIGTH CSM</th>
					<th width="5%">WEIGTH WR</th>
				</thead>
				<tbody>
					<?php $no = 0; ?>
					<?php for ($i=1; $i <= 20; $i++) {
								if ($i == 1) {
									$new = $OLamination_1 = $this->db->query("SELECT * FROM raw_material_lamination WHERE kategori='OUTSIDE LAMINATION' AND stage_ke = 1")->result_array();
								}else {
									$new = $OLamination_2 = $this->db->query("SELECT * FROM raw_material_lamination WHERE kategori='OUTSIDE LAMINATION' AND stage_ke = 2")->result_array();
								}
								$b = 0;
								foreach ($new as $key => $v) { $no++;$b++?>
									<?php if (($no+1) % 7 == 0): ?>
										<tr id="OL_<?=$no;?>" style="border-bottom:2px solid #000">
									<?php else: ?>
										<tr id="OL_<?=$no;?>">
									<?php endif; ?>

										<input type="hidden" id="o_diameter_penentuan_<?=$no?>" name="o_diameter_penentuan_<?=$no?>" value="<?=$v['diameter_penentuan']?>">
										<input type="hidden" id="o_std_gc_<?=$no?>" name="o_std_gc_<?=$no?>" value="<?=$v['type']?>">
										<input class="form-control input-sm" type="hidden" id="o_stage_ke_<?=$no?>" name="o_stage_ke_<?=$no?>" value="<?=$i?>">

										<td >
											<input class="form-control input-sm" type="text" id="o_lapisan_<?=$no?>" name="o_lapisan_<?=$no?>" value="<?=$no?>">
										</td>

										<td >
											<?php	if ($v['type'] == "RUMUS") {?>
												<input class="form-control input-sm" type="text" id="o_std_<?=$no?>" name="o_std_<?=$no?>" value="">
											<?php	}else {	?>
												<input class="form-control input-sm" type="text" id="o_std_<?=$no?>" name="o_std_<?=$no?>" value="<?=$v['type']?>">
											<?php	}	?>
										</td>

										<td >
											<input class="form-control input-sm" type="text" id="o_width_<?=$no?>" name="o_width_<?=$no?>" value="">
										</td>

										<?php	if ($no == 1) {?>
											<td  style="text-align:center;vertical-align:middle;border-bottom:2px solid #000" rowspan="<?=count($new);?>">
												<input class="form-control input-sm" type="text" id="o_stage_<?=$i?>" name="o_stage_<?=$i?>" value="<?=$i?>">
											</td>
										<?php	}elseif (($no % 7) == 0) {?>
											<td  style="text-align:center;vertical-align:middle;border-bottom:2px solid #000" rowspan="<?=count($new);?>">
												<input class="form-control input-sm" type="text" id="0_stage_<?=$i?>" name="0_stage_<?=$i?>" value="<?=$i?>">
											</td>
										<?php	}	?>

										<td >
											<input class="form-control input-sm" type="text" id="o_glassconfiguration_<?=$no?>" name="o_glassconfiguration_<?=$no?>" value="">
										</td>

										<td >
											<input class="form-control input-sm" type="text" id="o_thickness1_<?=$no?>" name="o_thickness1_<?=$no?>" value="">
										</td>

										<td >
											<input class="form-control input-sm" type="text" id="o_thickness2_<?=$no?>" name="o_thickness2_<?=$no?>" value="">
										</td>

										<?php	if ($no == 1) {?>
											<td rowspan="<?=count($new);?>" style="text-align:center;vertical-align:middle;border-bottom:2px solid #000" >
												<input class="form-control input-sm" type="text" id="o_glasslength_<?=$i?>" name="o_glasslength_<?=$i?>" value="">
											</td>
										<?php	}elseif (($no % 7) == 0) {?>
											<td rowspan="<?=count($new);?>" style="text-align:center;vertical-align:middle;border-bottom:2px solid #000" >
												<input class="form-control input-sm" type="text" id="o_glasslength_<?=$i?>" name="o_glasslength_<?=$i?>" value="">
											</td>
										<?php	}	?>

										<td >
											<input class="form-control input-sm" type="text" id="o_veil_weight_<?=$no?>" name="o_veil_weight_<?=$no?>" value="">
										</td>

										<td >
											<input class="form-control input-sm" type="text" id="o_csm_weight_<?=$no?>" name="o_csm_weight_<?=$no?>" value="">
										</td>

										<td >
											<input class="form-control input-sm" type="text" id="o_wr_weight_<?=$no?>" name="o_wr_weight_<?=$no?>" value="">
										</td>

									</tr>
					<?php
								}
								}	?>
								<input type="hidden" name="no_ol" value="<?=$no?>">
				</tbody>
			</table>

			<br><br><br>
			<!-- END -->


		</div>

		<!-- modal -->
		<div class="modal fade" id="ModalView">
			<div class="modal-dialog"  style='width:75%; '>
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="head_title"></h4>
						</div>
						<div class="modal-body" id="view">
						</div>
						<div class="modal-footer">
						<!--<button type="button" class="btn btn-primary">Save</button>-->
						<button type="button" class="btn btn-default " data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
		<!-- modal -->

</form>

<?php $this->load->view('include/footer'); ?>
<link rel="stylesheet" href="<?php echo base_url('assets/datepicker/css/datepicker.css');?>">
<script src="<?php echo base_url('assets/datepicker/js/bootstrap-datepicker.js'); ?>"></script>
<style type="text/css">
	.kghide{
		display:none !important;
	}
	label{
		    font-size: small !important;
	}
	.chosen-container-active .chosen-single {
	     border: none;
	     box-shadow: none;
	}
	.headerTitleGroup{
		text-align: center;
		background-color: #b97f29;
		height: 30px;
		font-weight: bold;
		padding-top: 5px;
		margin-bottom: 15px;
		margin-top: 30px;
		color: white;
	}

	.chosen-container-single .chosen-single {
		height: 34px;
	    border: 1px solid #d2d6de;
	    border-radius: 0px;
	     background: none;
	    box-shadow: none;
	    color: #444;
	    line-height: 32px;
	}
	.chosen-container-single .chosen-single div{
		top: 5px;
	}
	#app_pipe_chosen{
		width: 100% !important;
	}
	#standard_pipe_chosen{
		width: 100% !important;
	}
	.headerTitle{
		text-align: center;
		background-color: #294267;
		height: 30px;
		font-weight: bold;
		padding-top: 5px;
		margin-bottom: 5px;
		margin-top: 30px;
		color: white;
	}

	.HasilKet{
		font-size: 20px;
		text-align: center;
		font-weight: bold;
	}
	.Acuhan{
		float: right;
		width: 180px;
		font-size: 20px;
		text-align: center;
		font-weight: bold;
		background-color: #ffffff;
	}
	#customer_chosen,
	#top_type_chosen,
	#top_app_chosen,
	#top_toleran_chosen,
	#mid_mtl_realese_chosen,
	#mid_mtl_plastic_chosen,
	#mid_mtl_veil_chosen,
	#mid_mtl_resin1_chosen,
	#mid_mtl_veil_add_chosen,
	#mid_mtl_resin2_chosen,
	#mid_mtl_matcsm_chosen,
	#mid_mtl_resin3_chosen,
	#mid_mtl_csm_add_chosen,
	#mid_mtl_resin4_chosen,
	#mid_mtl_resin_tot_chosen,
	#mid_mtl_katalis_chosen,
	#mid_mtl_sm_chosen,
	#mid_mtl_cobalt_chosen,
	#mid_mtl_dma_chosen,
	#mid_mtl_hydro_chosen,
	#mid_mtl_methanol_chosen,
	#mid_mtl_additive_chosen,
	#mid_mtl_matcsm2_chosen,
	#mid_mtl_resin21_chosen,
	#mid_mtl_csm_add2_chosen,
	#mid_mtl_resin22_chosen,
	#mid_mtl_wr2_chosen,
	#mid_mtl_resin23_chosen,
	#mid_mtl_wr_add2_chosen,
	#mid_mtl_resin24_chosen,
	#mid_mtl_rooving21_chosen,
	#mid_mtl_resin25_chosen,
	#mid_mtl_rooving22_chosen,
	#mid_mtl_resin26_chosen,
	#mid_mtl_resin_tot2_chosen,
	#mid_mtl_katalis2_chosen,
	#mid_mtl_sm2_chosen,
	#mid_mtl_cobalt2_chosen,
	#mid_mtl_dma2_chosen,
	#mid_mtl_hydro2_chosen,
	#mid_mtl_methanol2_chosen,
	#mid_mtl_additive2_chosen,
	#mid_mtl_veil3_chosen,
	#mid_mtl_resin31_chosen,
	#mid_mtl_veil_add3_chosen,
	#mid_mtl_resin32_chosen,
	#mid_mtl_matcsm3_chosen,
	#mid_mtl_resin33_chosen,
	#mid_mtl_csm_add3_chosen,
	#mid_mtl_resin34_chosen,
	#mid_mtl_resin_tot3_chosen,
	#mid_mtl_katalis3_chosen,
	#mid_mtl_sm3_chosen,
	#mid_mtl_cobalt3_chosen,
	#mid_mtl_dma3_chosen,
	#mid_mtl_hydro3_chosen,
	#mid_mtl_methanol3_chosen,
	#mid_mtl_additive3_chosen,
	#mid_mtl_resin41_chosen,
	#mid_mtl_katalis4_chosen,
	#mid_mtl_color4_chosen,
	#mid_mtl_tin4_chosen,
	#mid_mtl_chl4_chosen,
	#mid_mtl_stery4_chosen,
	#mid_mtl_wax4_chosen,
	#mid_mtl_mch4_chosen,
	#mid_mtl_additive4_chosen{
		width: 100% !important;
	}


	#mid_mtl_resin1_chosen,
	#mid_mtl_resin2_chosen,
	#mid_mtl_resin3_chosen,
	#mid_mtl_resin4_chosen,
	#mid_mtl_resin21_chosen,
	#mid_mtl_resin22_chosen,
	#mid_mtl_resin23_chosen,
	#mid_mtl_resin24_chosen,
	#mid_mtl_resin25_chosen,
	#mid_mtl_resin26_chosen,
	#mid_mtl_resin31_chosen,
	#mid_mtl_resin32_chosen,
	#mid_mtl_resin33_chosen,
	#mid_mtl_resin34_chosen{
		display: none;
	}

</style>
<script>


	$(document).ready(function(){
		$('.HideCost').hide();
		$('.Hide').hide();
		std();
		OL_Function();
		hitung_all();

		$(document).on('change', '#d1', function(e){
			// e.preventDefault();
			var id	= $(this).val();
			//console.log(id+"XXX");
			$.ajax({
				url: base_url +'index.php/'+active_controller+'/getDiameterNoWaste',
				cache: false,
				type: "POST",
				data: "id="+$(this).val(),
				dataType: "json",
				success: function(data){
					//console.log(data.pipeN);
					$('#top_type_1').val(data.pipeN);
					$('#diameter_1').val(data.pipeD);
					//console.log($('#top_type_1').val());
					// $('#waste').val(data.wasted);

				}
			});
		});
		$(document).on('change', '#d2', function(e){
			// e.preventDefault();
			var id	= $(this).val();
			$.ajax({
				url: base_url +'index.php/'+active_controller+'/getDiameterNoWaste',
				cache: false,
				type: "POST",
				data: "id="+$(this).val(),
				dataType: "json",
				success: function(data){
					$('#top_type_2').val(data.pipeN);
					$('#diameter_2').val(data.pipeD);
					// $('#waste').val(data.wasted);

				}
			});
		});

		$(document).on('click', '#calc', function(e){
			std();
			OL_Function();
			hitung_all();
		});

		$(document).on('click paste keyup change', '#pipe_thickness', function(e){
			var x = parseFloat($("#factor_thickness").val())*parseFloat($("#pipe_thickness").val());
			if (isNaN(x)) {
				x = 0;
			}
			$("#joint_thickness").val(x);
		});
		function joint_thickness_calc(){
			var x = parseFloat($("#factor_thickness").val())*parseFloat($("#pipe_thickness").val());
			if (isNaN(x)) {
				x = 0;
			}
			$("#joint_thickness").val(x);
		}

		$(document).on('click paste keyup change', '#diameter', function(e){
			std();
			OL_Function();
			hitung_all();
		});

		//GET VEIL MATERIAL
		$(document).on('change', '#veil', function(e){

			var x = $("#veil").val();
			get_mat(x,'area weight','veil')
			//console.log(x);
			//$("#joint_thickness").val(x);
		});
		//GET WR MATERIAL
		$(document).on('change', '#wr', function(e){

			var x = $("#wr").val();
			get_mat(x,'area weight','wr')
			//console.log(x);
			//$("#joint_thickness").val(x);
		});
		//GET CSM MATERIAL
		$(document).on('change', '#csm', function(e){

			var x = $("#csm").val();
			get_mat(x,'area weight','csm')
			//console.log(x);
			//$("#joint_thickness").val(x);
		});
		//GET MATERIAL
		function get_mat(id, table, nama){
			if(id != ''){
        $.ajax({
          type:"GET",
          url:base_url+active_controller+"/get_detail_mat",
					data: {
				    id_material: id,
						nm_standard: table
				  },
          success:function(result){
            var data = JSON.parse(result);
            $('#'+nama+'_area_weight').val(data.nilai_standard);
						//$('#'+nama+'_thickness').val((parseFloat(data.nilai_standard)/1000/2.56)+(parseFloat(data.nilai_standard)/1000/1.2*parseFloat($('#veil_resin_content').val())));
						hitung_all();
          },error:function(){
						console.log(base_url+active_controller+"get_detail_mat");
					}
        });
      }
		}

		$(".numberOnly").on("keypress keyup blur",function (event) {
			// $(this).val($(this).val().replace(/[^\d].+/, ""));
			if ((event.which < 48 || event.which > 57 ) && (event.which < 46 || event.which > 46 )) {
				event.preventDefault();
			}
			// if($(this).val() == ''){
			// $(this).val(0);
			// }
		});

		//=====================================GLASS HEAD=============================================//
			//-----------KONSTANTA------------//
			function kg(){ // KONSTANTA GLASS
				var dia = '';
				if ($("#diameter_1").val() > $("#diameter_2").val()) {
					var dia = $("#diameter_1").val();
				}
				else {
					var dia = $("#diameter_2").val();
				}
				var D3 = parseFloat(dia);
				var D4 = parseFloat($("#minimum_width").val());
				var G3 = parseFloat($("#pipe_thickness").val());
				var G4 = parseFloat($("#joint_thickness").val());
				var G5 = parseFloat($("#factor_thickness").val());
				var J3 = parseFloat($("#factor").val());
				var F9 = parseFloat($("#veil_area_weight").val());
				var F10 = parseFloat($("#wr_area_weight").val());
				var F11 = parseFloat($("#csm_area_weight").val());
				var G9 = parseFloat($("#veil_resin_content").val());
				var G10 = parseFloat($("#wr_resin_content").val());
				var G11 = parseFloat($("#csm_resin_content").val());
				return {
				D3 : D3,
				D4 : D4,
				G3 : G3,
				G4 : G4,
				G5 : G5,
				J3 : J3,
				F9 : F9,
				F10 : F10,
				F11 : F11,
				G9 : G9,
				G10 : G10,
				G11 : G11}
			}
			//---------END KONSTANTA----------//

			function veil_thickness(){
				kg();
				var H9 = ((kg().F9/1000)/2.56)+(((kg().F9/1000)/1.2)*kg().G9);
				return H9.toFixed(4);
			}
			function wr_thickness(){
				kg();
				var H10 = (kg().F10/1000/2.56)+(kg().F10/1000/1.2*kg().G10);
				return H10.toFixed(4);
			}
			function csm_thickness(){
				kg();
				var H11 = (kg().F11/1000/2.56)+(kg().F11/1000/1.2*kg().G11);
				return H11.toFixed(4);
			}
		//=================================END GLASS HEAD=============================================//




		//=====================================RESIN & ADD=============================================//
			//-----------KONSTANTA------------//
			function ceilingxcl(a,b){
				return Math.ceil(a / b) * b;

			}
			function kons(){ //KONSTANTA RESIN & ADD
				if ($("#diameter_1").val() > $("#diameter_2").val()) {
					var dia = $("#diameter_1").val();
				}
				else {
					var dia = $("#diameter_2").val();
				}
				var D3 = parseFloat(dia);
				var D4 = parseFloat($("#minimum_width").val());
				var G3 = parseFloat($("#pipe_thickness").val());
				var G4 = parseFloat($("#joint_thickness").val());
				var G5 = parseFloat($("#factor_thickness").val());
				var J3 = parseFloat($("#factor").val());
				var J9 = parseFloat($("#veil_material_weight").val());
				var G9 = parseFloat($("#veil_resin_content").val());
				var J10 = parseFloat($("#wr_material_weight").val());
				var G10 = parseFloat($("#wr_resin_content").val());
				var J11 = parseFloat($("#csm_material_weight").val());
				var G11 = parseFloat($("#csm_resin_content").val());
				var G14 = parseFloat($("#resin_percentage").val()/100);
				var G15 = parseFloat($("#catalys_percentage").val()/100);
				var G16 = parseFloat($("#dempul_percentage").val()/100);
				var G17 = parseFloat($("#carbosilbubuk_percentage").val()/100);
				var G18 = parseFloat($("#resincarbosil_percentage").val()/100);
				var G19 = parseFloat($("#resintopcoat_percentage").val()/100);
				var G20 = parseFloat($("#cobalt_percentage").val()/100);
				var G21 = parseFloat($("#pigment_percentage").val()/100);
				var G22 = parseFloat($("#tinuvin_percentage").val()/100);
				var G23 = parseFloat($("#chloroform_percentage").val()/100);
				var G24 = parseFloat($("#solutionwax_percentage").val()/100);
				return {D3 : D3,
				D4 : D4,
				G3 : G3,
				G4 : G4,
				G5 : G5,
				J3 : J3,
				J9 : J9,
				G9 : G9,
				J10 : J10,
				G10 : G10,
				J11 : J11,
				G11 : G11,
				G14 : G14,
				G15 : G15,
				G16 : G16,
				G17 : G17,
				G18 : G18,
				G19 : G19,
				G20 : G20,
				G21 : G21,
				G22 : G22,
				G23 : G23,
				G24 : G24}
			}
			function PI(){
				return 3.141593;
			}
			//---------END KONSTANTA----------//

			function resin_material_weight(){
				kons();
				return (kons().J9*kons().G9)+(kons().J10*kons().G10)+(kons().J11*kons().G11);
			}
			function catalys_material_weight(){
				kons();
				var J14 = resin_material_weight();
				return (kons().G15)*J14;
			}
			function dempul_material_weight(){
				kons();
				var J14 = resin_material_weight();
				var J15 = catalys_material_weight();
				return ( (kons().D3)*PI() * (8/9) ) * ( (Math.pow(kons().G3,2)) / Math.pow(10,6) * ( kons().G16 ) );
			}
			function carbosilbubuk_material_weight(){
				kons();
				var J14 = resin_material_weight();
				var J15 = catalys_material_weight();
				var J16 = dempul_material_weight();
				return (kons().G17)*J16;
			}
			function resincarbosil_material_weight(){
				kons();
				var J14 = resin_material_weight();
				var J15 = catalys_material_weight();
				var J16 = dempul_material_weight();
				var J17 = carbosilbubuk_material_weight();
				return kons().G18*J16;
			}
			function resintopcoat_material_weight(){
				kons();
				var J14 = resin_material_weight();
				var J15 = catalys_material_weight();
				var J16 = dempul_material_weight();
				var J17 = carbosilbubuk_material_weight();
				var J18 = resincarbosil_material_weight();
				//console.log(ceilingxcl(kons().D4,50));
				return ((PI()*(kons().D3+2*kons().G3+2*kons().G4)*ceilingxcl(kons().D4,50)*1.2)/1000000)*0.5;
			}
			function cobalt_material_weight(){
				kons();
				var J14 = resin_material_weight();
				var J15 = catalys_material_weight();
				var J16 = dempul_material_weight();
				var J17 = carbosilbubuk_material_weight();
				var J18 = resincarbosil_material_weight();
				var J19 = resintopcoat_material_weight();
				return (J19+J17+J14)*kons().G20;
			}
			function pigment_material_weight(){
				kons();
				var J14 = resin_material_weight();
				var J15 = catalys_material_weight();
				var J16 = dempul_material_weight();
				var J17 = carbosilbubuk_material_weight();
				var J18 = resincarbosil_material_weight();
				var J19 = resintopcoat_material_weight();
				var J20 = cobalt_material_weight();
				return kons().G21*J19;
			}
			function tinuvin_material_weight(){
				kons();
				var J14 = resin_material_weight();
				var J15 = catalys_material_weight();
				var J16 = dempul_material_weight();
				var J17 = carbosilbubuk_material_weight();
				var J18 = resincarbosil_material_weight();
				var J19 = resintopcoat_material_weight();
				var J20 = cobalt_material_weight();
				var J21 = pigment_material_weight();
				return kons().G22*J19;
			}
			function chloroform_material_weight(){
				kons();
				var J14 = resin_material_weight();
				var J15 = catalys_material_weight();
				var J16 = dempul_material_weight();
				var J17 = carbosilbubuk_material_weight();
				var J18 = resincarbosil_material_weight();
				var J19 = resintopcoat_material_weight();
				var J20 = cobalt_material_weight();
				var J21 = pigment_material_weight();
				return kons().G23*J19;
			}
			function solutionwax_material_weight(){
				kons();
				var J14 = resin_material_weight();
				var J15 = catalys_material_weight();
				var J16 = dempul_material_weight();
				var J17 = carbosilbubuk_material_weight();
				var J18 = resincarbosil_material_weight();
				var J19 = resintopcoat_material_weight();
				var J20 = cobalt_material_weight();
				var J21 = pigment_material_weight();
				return kons().G24*J19;
			}

		//==================================END RESIN & ADD=============================================//

//--------------------------------------------------------------------------------------------------------------------//

		//=====================================GET ALL COUNT============================================//
			function hitung_all(){
				//kg();
				//veil_thickness();
				//wr_thickness();
				//csm_thickness();
				$('#veil_thickness').val(veil_thickness());
				$('#wr_thickness').val(wr_thickness());
				$('#csm_thickness').val(csm_thickness());

				$('#resin_material_weight').val(resin_material_weight());
				$('#catalys_material_weight').val(catalys_material_weight());
				$('#dempul_material_weight').val(dempul_material_weight());
				$('#carbosilbubuk_material_weight').val(carbosilbubuk_material_weight());
				$('#resincarbosil_material_weight').val(resincarbosil_material_weight());
				$('#resintopcoat_material_weight').val(resintopcoat_material_weight());
				$('#cobalt_material_weight').val(cobalt_material_weight());
				$('#pigment_material_weight').val(pigment_material_weight());
				$('#tinuvin_material_weight').val(tinuvin_material_weight());
				$('#chloroform_material_weight').val(chloroform_material_weight());
				$('#solutionwax_material_weight').val(solutionwax_material_weight());


				//console.log(kg().F9);
			}
		//==================================END GET ALL COUNT===========================================//

//--------------------------------------------------------------------------------------------------------------------//

		//=====================================INSIDE LAMINATION========================================//
			//-----------STD------------//
			function std(){ // STD

				var jum = '<?= count($ILamination)?>';
				var w_il = 2;
				var dia = '';
				if ($("#diameter_1").val() > $("#diameter_2").val()) {
					var dia = $("#diameter_1").val();
				}
				else {
					var dia = $("#diameter_2").val();
				}
				for (var i = parseInt(jum); i >= 1; i--) {
					//STD
					if ($('#std_gc_'+i).val() == 'RUMUS') {
						if (parseFloat(dia) < parseFloat($('#diameter_penentuan_'+i).val())) {
							$('#std_'+i).val('');
						}else {
							$('#std_'+i).val('VEIL');
						}
					}

					//WIDTH
					if ($('#std_'+jum).val() == '') {
						$('#width_'+jum).val('');
					}else {
						var c1 = ceilingxcl((0.5*ceilingxcl( $('#minimum_width').val(),50) ),50);
						$('#width_'+jum).val(c1);
					}
					$('#width_'+(jum-1)).val(c1);
					//PERHITUNGAN SELANJUTNYA KEATAS
					if (i <= (jum-2) && i > (jum-(2*2))) {
						if (parseFloat(dia) > 2150) {
							$('#width_'+i).val(c1-50);
						}
					}

					if (i <= (jum-(2*2))) {
						if (parseFloat(dia) > 1500) {
							if (parseFloat(dia) > 2150) {
								$('#width_'+i).val(c1-100);
							}else {
								$('#width_'+i).val(c1-50);
							}
						}
					}

					if (i <= (jum-(2*3))) {
						if (parseFloat(dia) > 1050) {
							if (parseFloat(dia) > 1500) {
								if (parseFloat(dia) > 2150) {
									$('#width_'+i).val(c1-150);
								}else {
									$('#width_'+i).val(c1-100);
								}
							}else {
								$('#width_'+i).val(c1-50);
							}
						}
					}

					if (i <= (jum-(2*4))) {
						if (parseFloat(dia) > 600) {
							if (parseFloat(dia) > 1050) {
								if (parseFloat(dia) > 1500) {
									if (parseFloat(dia) > 2150) {
										$('#width_'+i).val(c1-200);
									}else {
										$('#width_'+i).val(c1-150);
									}
								}else {
									$('#width_'+i).val(c1-100);
								}
							}else {
								$('#width_'+i).val(c1-50);
							}
						}
					}

					//GLASS CONFIGURATION
					if ($('#width_'+i).val() == '')  {
						$('#glassconfiguration_'+i).val('');
					}else {
						$('#glassconfiguration_'+i).val($('#std_'+i).val());
					}


					//THICKNESS 1
					if ($('#glassconfiguration_'+i).val() == "CSM") {
						$('#thickness1_'+i).val($('#csm_thickness').val());
					}else if ($('#glassconfiguration_'+i).val() == "VEIL") {
						$('#thickness1_'+i).val($('#veil_thickness').val());
					}else {
						$('#thickness1_'+i).val('');
					}

					//THICKNESS 2
					$('#thickness2_'+i).val($('#thickness1_'+i).val());

					//GLASS LENGTH
					if (parseFloat(dia) > 600) {
						var gl = PI()*parseFloat(dia)+100;
						$('#glasslength_'+i).val(gl);
					}



					//console.log($('#std_gc_'+i).val()+'xxx'+i);
				}
				//console.log(jum);
				//console.log(parseFloat(dia));
				//console.log(jum);
			}
			//---------END KONSTANTA----------//
		//=================================END INSIDE LAMINATION========================================//

//--------------------------------------------------------------------------------------------------------------------//

		//=====================================OUTSIDE LAMINATION=======================================//
			//-----------STD------------//
			/*function OL_Function_old(){ // STD
				kons();
				var jum = 0;
				var no = 0;
				for (var s = 1; s <= 20; s++) {
					if (s == 1) {
						var x = parseInt('<?= count($OLamination_1)?>');
					}else {
						var x = parseInt('<?= count($OLamination_2)?>');
					}
					jum = parseInt(jum) + x
					//console.log(jum);
				}

				for (var i = jum; i >= 1; i--) {

					no++;
					//STD
					if ($('#o_std_gc_'+i).val() == 'RUMUS') {
						if (parseFloat(kons().D3) < parseFloat($('#o_diameter_penentuan_'+i).val())) {
							$('#o_std_'+i).val('VEIL');
						}else {
							$('#o_std_'+i).val('CSM');
						}
					}

					//WIDTH
					if (no == 1) {
						if (	(G178 == '' && $('#o_glassconfiguration_'+i).val() == 'CSM')	||	(G179 == '' && F178 == 'CSM')) {
							var	width	=	ceilingxcl(kons().D4,50);
						}else if (D178 == '' || D178 < 1) {
							var width = 0;
						}else if (kons().D4 < 601 || (kons().D4 - (Math.floor(kons().G4/5.5)*100))<550) {
							var width = D178 - 50;
						}else {
							var width = D178 - 100;
						}
					}else {

					}

				}

			}*/
			function OL_Function(){ // STD
				kons();
				//KONSTANTA
				if (	kons().D3	<	600) {
					$('#o_std_1').val('VEIL');
					$('#o_glassconfiguration_1').val('VEIL');
					$('#o_thickness1_1').val(0);
				}else {
					$('#o_std_1').val('CSM');
					$('#o_glassconfiguration_1').val('CSM');
					$('#o_thickness1_1').val($('#csm_thickness').val());
				}
				//END KONSTANTA

				for (var i = 2; i <= <?=$no?>; i++) {
					var sum_thickness1 = 0;
					for (var j = 1; j < i; j++) {
						sum_thickness1 = sum_thickness1 + parseFloat($('#o_thickness1_'+j).val());
					}

					//GLASS CONFIGURATION
					if (sum_thickness1 < parseFloat($('#joint_thickness').val())) {
						if (i == 2) {
							if (sum_thickness1 == 0) {
								if (	(sum_thickness1	==	0	&&	$('#o_glassconfiguration_'+(parseInt(i-1))).val()	==	"CSM"	&&	$('#std_10').val()	==	"WR")	||
									(sum_thickness1	==	0	&&	$('#o_glassconfiguration_'+(parseInt(i-1))).val()	==	"WR"	&&	$('#std_10').val()	==	"CSM")	) {
										var	o_glassconfiguration_ = 'CSM';
									$('#o_glassconfiguration_'+i).val('CSM');
								}else {
									var	o_glassconfiguration_ = '';
									$('#o_glassconfiguration_'+i).val('');
								}
							}else {
								var	o_glassconfiguration_ = $('#o_std_'+i).val();
								$('#o_glassconfiguration_'+i).val($('#o_std_'+i).val());
							}
						}
						if (i != 1 && i >= 3) {
							if (sum_thickness1 == 0) {
								if (	(sum_thickness1	==	0	&&	$('#o_glassconfiguration_'+(parseInt(i)-1)).val()	==	"CSM"	&&	$('#o_std_'+(parseInt(i)-2)).val()	==	"WR")	||
									(sum_thickness1	==	0	&&	$('#o_glassconfiguration_'+(parseInt(i)-1)).val()	==	"WR"	&&	$('#o_std_'+(parseInt(i)-2)).val()	==	"CSM")	) {
										var	o_glassconfiguration_ = 'CSM';
									$('#o_glassconfiguration_'+i).val('CSM');
								}else {
									var	o_glassconfiguration_ = '';
									$('#o_glassconfiguration_'+i).val('');
								}
							}else {
								var	o_glassconfiguration_ = $('#o_std_'+i).val();
								$('#o_glassconfiguration_'+i).val($('#o_std_'+i).val());
							}
						}

						//THICKNESS 1
						if (o_glassconfiguration_ == 'CSM') {
							var o_thickness1_ = $('#csm_thickness').val()
							$('#o_thickness1_'+i).val(	$('#csm_thickness').val()	);
						}else if (o_glassconfiguration_ == 'WR') {
							var o_thickness1_ = $('#wr_thickness').val()
							$('#o_thickness1_'+i).val(	$('#wr_thickness').val()	);
						}

						//THICKNESS 2
						if (o_glassconfiguration_ == 'CSM') {
							var o_thickness2_ = $('#csm_thickness').val()
							$('#o_thickness2_'+i).val($('#csm_thickness').val());
						}else if (o_glassconfiguration_	==	'WR') {
							$('#o_thickness2_'+i).val($('#wr_thickness').val());
						}else if (o_glassconfiguration_ ==	'VEIL'	||	o_glassconfiguration_ == '') {
							$('#o_thickness2_'+i).val(0);
						}

					}else if (sum_thickness1 >	parseFloat($('#joint_thickness').val())) {
						//GLASS
						if (i != 1 && i >= 3) {
							if (	($('#o_glassconfiguration_'+(parseInt(i)-1)).val()	==	"CSM"	&&	$('#o_std_'+(parseInt(i)-2)).val()	==	"WR")	||
							($('#o_glassconfiguration_'+(parseInt(i)-1)).val()	==	"WR"	&&	$('#o_std_'+(parseInt(i)-2)).val()	==	"CSM")	) {
								var	o_glassconfiguration_ = 'CSM';
								$('#o_glassconfiguration_'+i).val('CSM');
							}else {
								var	o_glassconfiguration_ = '';
								$('#o_glassconfiguration_'+i).val('');
							}
						}

						//THICKNESS 2
						if (o_glassconfiguration_ == 'CSM') {
							var o_thickness2_ = $('#csm_thickness').val()
							$('#o_thickness2_'+i).val($('#csm_thickness').val());
						}else if (o_glassconfiguration_	==	'WR') {
							$('#o_thickness2_'+i).val($('#wr_thickness').val());
						}else if (o_glassconfiguration_ ==	'VEIL'	||	o_glassconfiguration_ == '') {
							$('#o_thickness2_'+i).val(0);
						}


					}else {
						$('#o_thickness1_'+i).val(0);
						$('#o_thickness2_'+i).val(0);
					}
					/*
					if (i == 2) {
						if ($('#o_thickness1_'+i).val() == '') {
							if (	($('#o_thickness1_'+i).val()	==	''	&&	$('#o_glassconfiguration_'+(parseInt(i-1))).val()	==	"CSM"	&&	$('#std_10').val()	==	"WR")	||
								($('#o_thickness1_'+i).val()	==	""	&&	$('#o_glassconfiguration_'+(parseInt(i-1))).val()	==	"WR"	&&	$('#std_10').val()	==	"CSM")	) {
								$('#o_glassconfiguration_'+i).val('CSM');
							}else {
								$('#o_glassconfiguration_'+i).val('');
							}
						}else {
							$('#o_glassconfiguration_'+i).val($('#o_std_'+i).val());
						}
					}

					if (i != 1 && i >= 3) {
						if ($('#o_thickness1_'+i).val() == '') {
							if (	($('#o_thickness1_'+i).val()	==	''	&&	$('#o_glassconfiguration_'+(parseInt(i)-1)).val()	==	"CSM"	&&	$('#o_std_'+(parseInt(i)-2)).val()	==	"WR")	||
								($('#o_thickness1_'+i).val()	==	""	&&	$('#o_glassconfiguration_'+(parseInt(i)-1)).val()	==	"WR"	&&	$('#o_std_'+(parseInt(i)-2)).val()	==	"CSM")	) {
								$('#o_glassconfiguration_'+i).val('CSM');
							}else {
								$('#o_glassconfiguration_'+i).val('');
							}
						}else {
							$('#o_glassconfiguration_'+i).val($('#o_std_'+i).val());
						}
					}*/
				}


				//console.log(<?php echo $no ?>);
				/*
				for (var i = 2; i <= parseInt('<?php echo $no ?>'); i++) {
					var sum_thickness1 = 0;
					for (var j = 1; j < i; j++) {
						sum_thickness1 = sum_thickness1 + parseFloat($('#o_thickness1_'+j).val());
					}
					//console.log("i = "+i+" = "+$('#o_thickness1_'+i).val());
					//console.log("HM = "+i+" = "+sum_thickness1);
					if (sum_thickness1 < parseFloat($('#joint_thickness').val())) {
						if ($('#o_glassconfiguration_'+i).val() == 'CSM') {
							$('#o_thickness1_'+i).val(	$('#csm_thickness').val()	);
						}else if ($('#o_glassconfiguration_'+i).val() == 'WR') {
							$('#o_thickness1_'+i).val(	$('#wr_thickness').val()	);
						}
					}else {
						$('#o_thickness1_'+i).val(0);
					}

					if ($('#o_glassconfiguration_'+i).val()	==	'CSM') {
						$('#o_thickness2_'+i).val($('#csm_thickness').val());
					}else if ($('#o_glassconfiguration_'+i).val()	==	'WR') {
						$('#o_thickness2_'+i).val($('#wr_thickness').val());
					}else if ($('#o_glassconfiguration_'+i).val()	==	'VEIL'	||	$('#o_glassconfiguration_'+i).val()	==	0) {
						$('#o_thickness2_'+i).val('');
					}

				}
				*/
				$('#o_thickness2_1').val($('#o_thickness1_1').val());

				if (n != 1) {
					//$('#o_thickness2_'+n).val($('#o_thickness1_'+n).val());

				}

				var jum = 0;
				var max_width = 0;
				var D178 = 0;
				var max_glassconfiguration = 0;
				var F178 = 0;
				var max_thickness_1 = 0;
				var G178 = '';
				var max_thickness_2 = 0;
				var G179 = '';
				var no = 0;
				for (var s = 20; s >= 1; s--) {
					if (s == 1) {
						var x = parseInt('<?= count($OLamination_1)?>');
						var max_num = s*x;
					}else {
						var x = parseInt('<?= count($OLamination_2)?>');
						var max_num = (s*x)-1;
					}

					var n = max_num;
					for (var i = x; i >= 1; i--) {

						no++;

						//WIDTH

						if (i == x && s == 20) {
							if ( $('#o_glassconfiguration_'+n).val() == 'CSM') {
								var	width	=	ceilingxcl(kons().D4,50);
							}else {
								var width = 0;
							}
							$('#o_width_'+n).val(width);
						}else if (i == x && s != 20) {
							if 	(	($('#o_thickness1_'+parseInt(n+1)).val() == 0 && $('#o_glassconfiguration_'+n).val() == 'CSM')	||
										($('#o_thickness1_'+parseInt(n+2)).val() == 0 && $('#o_glassconfiguration_'+parseInt(n+1)).val() == 'CSM')	||
										($('#o_thickness1_'+parseInt(n+1)).val() == null && $('#o_glassconfiguration_'+n).val() == 'CSM')	||
										($('#o_thickness1_'+parseInt(n+2)).val() == null && $('#o_glassconfiguration_'+parseInt(n+1)).val() == 'CSM')
									) {
											var	width	=	ceilingxcl(kons().D4,50);
							}else if ( $('#o_width_'+parseInt(n+1)).val() == null ) {
								var width = 0;
							}else if (kons().D4 < 601 || (kons().D4 - (Math.floor(kons().G4/5.5)*100))<550) {
								var width = $('#o_width_'+parseInt(n+1)).val() - 50;
							}else {
								var width = $('#o_width_'+parseInt(n+1)).val() - 100;
							}
							$('#o_width_'+n).val(width);
						}else {
							if (n != 1 && s != 1) {
									if (i%2 == 0) {
										if 	(	(($('#o_thickness1_'+(parseInt(n)+1)).val() == null || $('#o_thickness1_'+(parseInt(n)+1)).val() == 0) && $('#o_glassconfiguration_'+n).val() == 'CSM')	||
													(($('#o_thickness1_'+(parseInt(n)+2)).val() == null	|| $('#o_thickness1_'+(parseInt(n)+2)).val() == 0) && $('#o_glassconfiguration_'+(parseInt(n+1))).val() == 'CSM')
												) {
														var	width	=	ceilingxcl(kons().D4,50);
										}else if (($('#o_width_'+(parseInt(n)+1)).val() == null || $('#o_width_'+(parseInt(n)+1)).val() == 0) || parseFloat($('#o_width_'+(parseInt(n)+1)).val()) < 1) {
											var width = 0;
										}else {
											var width = parseFloat($('#o_width_'+(parseInt(n)+1)).val()) - 50;
										}
										$('#o_width_'+n).val(width);
									}else {
										if 	(	(($('#o_thickness1_'+(parseInt(n)+1)).val() == null || $('#o_thickness1_'+(parseInt(n)+1)).val() == 0) && $('#o_glassconfiguration_'+n).val() == 'CSM')	||
													(($('#o_thickness1_'+(parseInt(n)+2)).val() == null	|| $('#o_thickness1_'+(parseInt(n)+2)).val() == 0) && $('#o_glassconfiguration_'+(parseInt(n+1))).val() == 'CSM')
												) {
														var	width	=	ceilingxcl(kons().D4,50);
										}else if (
															($('#o_width_'+(parseInt(n)+1)).val() == null || $('#o_width_'+(parseInt(n)+1)).val() == 0) ||
															parseFloat($('#o_width_'+(parseInt(n)+1)).val()) < 1) {
											var width = 0;
										}else {
											var width = parseFloat($('#o_width_'+(parseInt(n)+2)).val());
										}
										$('#o_width_'+n).val(width);
									}
							}else if (n != 1 && s == 1) {
									if (i%2 != 0) {
										if 	(	(($('#o_thickness1_'+(parseInt(n)+1)).val() == null || $('#o_thickness1_'+(parseInt(n)+1)).val() == 0) && $('#o_glassconfiguration_'+n).val() == 'CSM')	||
													(($('#o_thickness1_'+(parseInt(n)+2)).val() == null	|| $('#o_thickness1_'+(parseInt(n)+2)).val() == 0) && $('#o_glassconfiguration_'+(parseInt(n+1))).val() == 'CSM')
												) {
														var	width	=	ceilingxcl(kons().D4,50);
										}else if (($('#o_width_'+(parseInt(n)+1)).val() == null || $('#o_width_'+(parseInt(n)+1)).val() == 0) || parseFloat($('#o_width_'+(parseInt(n)+1)).val()) < 1) {
											var width = 0;
										}else {
											var width = parseFloat($('#o_width_'+(parseInt(n)+1)).val()) - 50;
										}
										$('#o_width_'+n).val(width);
									}else {
										if 	(	(($('#o_thickness1_'+(parseInt(n)+1)).val() == null || $('#o_thickness1_'+(parseInt(n)+1)).val() == 0) && $('#o_glassconfiguration_'+n).val() == 'CSM')	||
													(($('#o_thickness1_'+(parseInt(n)+2)).val() == null	|| $('#o_thickness1_'+(parseInt(n)+2)).val() == 0) && $('#o_glassconfiguration_'+(parseInt(n+1))).val() == 'CSM')
												) {
														var	width	=	ceilingxcl(kons().D4,50);
										}else if (
															($('#o_width_'+(parseInt(n)+1)).val() == null || $('#o_width_'+(parseInt(n)+1)).val() == 0) ||
															parseFloat($('#o_width_'+(parseInt(n)+1)).val()) < 1) {
											var width = 0;
										}else {
											var width = parseFloat($('#o_width_'+(parseInt(n)+2)).val());
										}
										$('#o_width_'+n).val(width);
									}
							}
						}

						//GL

						if (i == 1) {
							if (($('#o_glassconfiguration_'+n).val() == '' || $('#o_glassconfiguration_'+n).val() == null)) {
								$('#o_glasslength_'+s).val('');
							}else {
								var sum_ = 0;
								for (var th = 1; th <= n; th++) {
									var sum_ = sum_ + parseFloat($('#o_thickness2_'+th).val());
								}
								if (parseFloat(kons().D3) < 300) {
									var nil = (parseFloat(kons().D3)	+	2*(parseFloat($('#pipe_thickness').val())	+	sum_	))*PI()+25;
									//$('#o_glasslength_'+s).val(nil);
								}else if (parseFloat(kons().D3) < 550) {
									var nil = (parseFloat(kons().D3)	+	2*(parseFloat($('#pipe_thickness').val())	+	sum_	))*PI()+50;
								}else if (parseFloat(kons().D3) < 800) {
									var nil = (parseFloat(kons().D3)	+	2*(parseFloat($('#pipe_thickness').val())	+	sum_	))*PI()+75;
								}else {
									var nil = (parseFloat(kons().D3)	+	2*(parseFloat($('#pipe_thickness').val())	+	sum_	))*PI()+100;
								}
								$('#o_glasslength_'+s).val(nil);
							}
						}


						n--;

					}
				}
				$('#o_width_1').val($('#o_width_2').val());

				for (var p = 20; p >= 1; p--) {
					if (p == 1) {
						var xx = parseInt('<?= count($OLamination_1)?>');
						var max_num_2 = p*xx;
					}else {
						var xx = parseInt('<?= count($OLamination_2)?>');
						var max_num_2 = (p*xx)-1;
					}
					var q = max_num_2;

					for (var i = xx; i >= 1; i--) {
						//VEIL
						var gl = 0;
						for (var k = 1; k <= p; k++) {
							//gl.push(parseFloat($('#o_glasslength_'+k).val()));
							//gl[k-1] = parseFloat($('#o_glasslength_'+k).val());
							if (gl	<	parseFloat($('#o_glasslength_'+k).val())) {
								gl = parseFloat($('#o_glasslength_'+k).val());
							}
						}
						//q =
						if ($('#o_glassconfiguration_'+q).val()	==	"VEIL") {
							var vw = parseFloat($('#o_width_'+q).val())*gl*(parseFloat($('#veil_area_weight').val())/Math.pow(10,9)*2)

							$('#o_veil_weight_'+q).val(vw);
						}else {
							$('#o_veil_weight_'+q).val(0);
						}

						//CSM

						if ($('#o_glassconfiguration_'+q).val()	==	"CSM") {
							var cw = parseFloat($('#o_width_'+q).val())*gl*(parseFloat($('#csm_area_weight').val())/Math.pow(10,9))
							$('#o_csm_weight_'+q).val(cw);
						}else {
							$('#o_csm_weight_'+q).val(0);
						}

						//WR

						if ($('#o_glassconfiguration_'+q).val()	==	"WR") {
							var ww = parseFloat($('#o_width_'+q).val())*gl*(parseFloat($('#wr_area_weight').val())/Math.pow(10,9))
							$('#o_wr_weight_'+q).val(ww);
						}else {
							$('#o_wr_weight_'+q).val(0);
						}
						//console.log(gl);
						q--;
					}
				}

				//VEIL
				var gl = 0;
				if (parseFloat($('#glasslength_1').val())	<	parseFloat($('#o_glasslength_1').val())) {
					gl = parseFloat($('#o_glasslength_1').val());
				}else {
					gl = parseFloat($('#glasslength_1').val())
				}
				for (var q = 10; q >= 1; q--) {
					if ($('#glassconfiguration_'+q).val()	==	"VEIL") {
						var vw = parseFloat($('#width_'+q).val())*gl*(parseFloat($('#veil_area_weight').val())/Math.pow(10,9)*2)

						$('#veil_weight_'+q).val(vw);
					}else {
						$('#veil_weight_'+q).val(0);
					}

					//CSM

					if ($('#glassconfiguration_'+q).val()	==	"CSM") {
						var cw = parseFloat($('#width_'+q).val())*gl*(parseFloat($('#csm_area_weight').val())/Math.pow(10,9))
						$('#csm_weight_'+q).val(cw);
					}else {
						$('#csm_weight_'+q).val(0);
					}

					//WR

					if ($('#glassconfiguration_'+q).val()	==	"WR") {
						var ww = parseFloat($('#width_'+q).val())*gl*(parseFloat($('#wr_area_weight').val())/Math.pow(10,9))
						$('#wr_weight_'+q).val(ww);
					}else {
						$('#wr_weight_'+q).val(0);
					}
				}

				//VEIL MATERIAL WEIGHT
				var juml_veil = 0;
				var juml_csm = 0;
				var juml_wr = 0;
				var il = '<?=count($ILamination)?>';
				var ol = '<?=$no?>';
				console.log(il);
				for (var i = 1; i <= il; i++) {
					juml_veil = juml_veil+parseFloat($('#veil_weight_'+i).val());
					juml_csm = juml_csm+parseFloat($('#csm_weight_'+i).val());
					juml_wr = juml_wr+parseFloat($('#wr_weight_'+i).val());
				}
				for (var j = 1; j <= ol; j++) {
					juml_veil = juml_veil+parseFloat($('#o_veil_weight_'+j).val());
					juml_csm = juml_csm+parseFloat($('#o_csm_weight_'+j).val());
					juml_wr = juml_wr+parseFloat($('#o_wr_weight_'+j).val());
					//console.log(ol);
				}
				$('#veil_material_weight').val(juml_veil*parseFloat($('#factor').val()));
				$('#csm_material_weight').val(juml_csm*parseFloat($('#factor').val()));
				$('#wr_material_weight').val(juml_wr*parseFloat($('#factor').val()));
			}


			//---------END KONSTANTA----------//
		//=================================END OUTSIDE LAMINATION=======================================//
	});
$(document).on('click', '#simpan-bro', function(e){
	swal({
			title: "Are you sure?",
			text: "You will not be able to process again this data!",
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-danger",
			confirmButtonText: "Yes, Process it!",
			cancelButtonText: "No, cancel process!",
			closeOnConfirm: false,
			closeOnCancel: false
		},
		function(isConfirm) {
			if (isConfirm) {
				loading_spinner();
				var formData  	= new FormData($('#form_proses_bro')[0]);
				var baseurl		= base_url + active_controller +'/branchjoint';
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
						}
						else if(data.status == 2){
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
						else{
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
						$('#simpan-bro').prop('disabled',false);
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
						$('#simpan-bro').prop('disabled',false);
					}
				});
			} else {
			swal("Cancelled", "Data can be process again :)", "error");
			$('#simpan-bro').prop('disabled',false);
			return false;
			}
	});
});

</script>
