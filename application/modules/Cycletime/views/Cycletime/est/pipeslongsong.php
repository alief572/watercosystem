<?php
$this->load->view('include/side_menu'); 
?> 
<form action="#" method="POST" id="form_proses_bro">   
	<div class="box box-primary">
		<div class="box-header">
			<h3 class="box-title"><?php echo $title;?></h3>		
		</div>
		<div class="box-body">
			<!--<button type='button' class='btn btn-success btn-sm' style='float:right;' id='setResin'>Set Resin Containing</button>-->
			<div class='headerTitleGroup'>GROUP COMPONENT</div>
			<div class='form-group row'>		 	 
				<label class='label-control col-sm-2'><b>Diameter <span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>              
					<?php
						echo form_input(array('id'=>'top_type','name'=>'top_type','class'=>'form-control input-sm Hide','readonly'=>'readonly'));											
						echo form_input(array('id'=>'diameter','name'=>'diameter','class'=>'form-control input-sm Hide','readonly'=>'readonly'));
					?>	
					<select name='top_typeList' id='top_typeList' class='form-control input-sm'>
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
				<label class='label-control col-sm-2'><b>Pipe FOR <span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>    
					<select name='pipe_for' id='pipe_for' class='form-control input-sm'> 
						<option value='0'>Select Pipe For</option>
						<option value='M'>ELBOW MITTER</option>
						<option value='Q'>EQUAL TEE SLONGSONG</option>
						<option value='A'>FLANGE SLONGSONG</option>
						<option value='L'>REDUCER TEE SLONGSONG</option>
					</select>
				</div>
			</div>
			<div class='headerTitleGroup'>SPESIFIKASI COMPONENT</div>
			<div class='form-group row'>		 	 
				<label class='label-control col-sm-2'><b>Fluida <span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>              
					<select name='criminal_barier' id='criminal_barier' class='form-control input-sm'>
						<option value='0'>Select Fluida</option>
					<?php
						foreach($criminal_barier AS $val => $valx){
							echo "<option value='".$valx['name']."'>".strtoupper(strtolower($valx['name']))."</option>";
						}
					 ?>
					</select>
				</div>
				<label class='label-control col-sm-2'><b>Stiffness <span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>              
					<select name='aplikasi_product' id='aplikasi_product' class='form-control input-sm'>
						<option value='0'>Select Stiffness</option>
					<?php
						foreach($aplikasi_product AS $val => $valx){
							echo "<option value='".$valx['name']."'>".strtoupper($valx['data2'])."</option>";
						}
					 ?>
					</select>
				</div>
			</div>
			<div class='form-group row'>		 	 
				<label class='label-control col-sm-2'><b>Vacuum Rate <span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>              
					<select name='vacum_rate' id='vacum_rate' class='form-control input-sm'>
						<option value='0'>Select Vacuum Rate</option>
					<?php
						foreach($vacum_rate AS $val => $valx){
							echo "<option value='".$valx['data1']."'>".$valx['name']."</option>";
						}
					 ?>
					</select>
				</div>
				<label class='label-control col-sm-2'><b>Design Life <span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<select name='design_life' id='design_life' class='form-control input-sm'>
						<option value='0'>Select Design Life</option>
					<?php
						foreach($design_life AS $val => $valx){
							echo "<option value='".$valx['name']."'>".strtoupper(strtolower($valx['name']))."</option>";
						}
					 ?>
					</select>
				</div>
			</div>
			<div class='form-group row'>		 	 
				<label class='label-control col-sm-2'><b>Application<span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>              
					<select id='top_app' name='top_app' class='form-control input-sm'>
						<option value='ABOVE GROUND' selected>Above Ground</option>
						<option value='UNDER GROUND'>Under Ground</option>
					</select>
				</div>
			</div>
			<!-- //// -->
			<div class='headerTitle'>DETAILED ESTIMATION</div>
			<div class='form-group row'>		 	 
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
				
				<label class='label-control col-sm-2'><b>Waste | Thickness (EST)</b></label>
				<div class='col-sm-2'>              
					<?php
						echo form_input(array('type'=>'text','id'=>'waste','name'=>'waste','class'=>'form-control input-sm numberOnly','placeholder'=>'Waste','value'=>'0','readonly'=>'readonly'));	
					?>	
				</div>
				<div class='col-sm-2'>              
					<?php
						echo form_input(array('id'=>'top_tebal_est','name'=>'top_tebal_est','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));
						echo form_input(array('type'=>'text','id'=>'area','name'=>'area','class'=>'HideCost'));
						echo form_input(array('type'=>'text','id'=>'acuhan_1','name'=>'acuhan_1','class'=>'HideCost'));
					?>
				</div>
			</div>
			<div class='form-group row'>
				<label class='label-control col-sm-2'><b>Thickness Design <span class='text-red'>*</span></b></label>
				<div class='col-sm-2'>              
					<?php
						echo form_input(array('id'=>'top_tebal_design','name'=>'top_tebal_design','class'=>'form-control input-sm numberOnly','autocomplete'=>'off','placeholder'=>'Pipe Thickness (Design)', 'value'=>''));											
					?>	
				</div>
				<div class='col-sm-2'>              
					<?php
						echo form_input(array('id'=>'top_length','name'=>'top_length','class'=>'form-control input-sm numberOnly HideCost','value'=>'1000','readonly'=>'readonly'));				
					?>	
				</div>
				
				<div class='ToleranSt'>
					<label class='label-control col-sm-2'><b>Min | Max Standard <span class='text-red'>*</span></b></label>
					<div class='col-sm-1'>              
						<?php
							echo form_input(array('id'=>'top_min_toleran','name'=>'top_min_toleran','class'=>'form-control input-sm numberOnly','autocomplete'=>'off','placeholder'=>'Mix'));											
						?>	
					</div>
					<div class='col-sm-1'>              
						<?php
							echo form_input(array('id'=>'top_max_toleran','name'=>'top_max_toleran','class'=>'form-control input-sm numberOnly','autocomplete'=>'off','placeholder'=>'Max'));											
						?>	
					</div>
				</div>
			</div>
			<!-- ====================================================================================================== -->
			<!-- ============================================LINER THICKNESS=========================================== -->
			<!-- ====================================================================================================== -->
			<div class='headerTitle'>LINER THIKNESS / CB</div>
			<input type='text' name='detail_name' id='detail_name' class='HideCost' value='LINER THIKNESS / CB'>
			<div class='form-group row'>		 	 
				<label class='label-control col-sm-2'><b><div id='mirror'>MIRROR GLASS<span class='text-red'>*</span></div><div id='plactic'>PLASTIC FILM<span class='text-red'>*</span></div></b></label>
				<div class='col-sm-3'>              
					<select name='ListDetail[1][id_material]' id='mid_mtl_plastic' class='form-control input-sm'>
						<option value=''>Select An Mirror Glass</option>
					<?php
						foreach($ListPlastic AS $val => $valx){
							echo "<option value='".$valx['id_material']."'>".strtoupper($valx['nm_material'])."</option>";
						}
						echo "<option value='MTL-1903000'>NONE MATERIAL</option>";
					 ?>
					</select>
					<input type='text' name='ListDetail[1][id_ori]' class='HideCost' id='id_ori' value='TYP-0008'>
					<input type='text' name='ListDetail[1][id_ori2]' class='HideCost' id='id_ori2' value='TYP-0008'>
					<input type='text' name='ListDetail[1][last_full]' class='HideCost' id='hasil_plastic' value='0'>
					<input type='text' name='ListDetail[1][containing]' class='HideCost' id='layer_plastic' value='1.5'>
				</div>
				<label class='col-sm-2' style='text-align:left; margin-top: 6px;'>Micron</label>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'micron_plastic','name'=>'ListDetail[1][value]', 'style'=>'margin-left:-110px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1' style='text-align:left; margin-left:-130px; margin-top: 6px;'></label>
				<div class='col-sm-1'>              
				</div>
				<label class='col-sm-2' style='text-align:left; margin-left: -130px; margin-top: 6px;'></label>
				<div class='col-sm-1'>              
	
				</div>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'last_plastic','name'=>'ListDetail[1][last_cost]', 'style'=>'margin-left:-80px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1 kghide' style='text-align:left; margin-left:-100px; margin-top: 6px;'>Kg</label>
			</div>
			<div class='form-group row'>		 	 
				<label class='label-control col-sm-2' style='text-align:left;'><b>VEIL<span class='text-red'>*</span></b></label>
				<div class='col-sm-3'>              
					<select name='ListDetail[2][id_material]' id='mid_mtl_veil' class='form-control input-sm'>
						<option value=''>Select An Veil</option>
					<?php
						foreach($ListVeil AS $val => $valx){
							echo "<option value='".$valx['id_material']."'>".strtoupper($valx['nm_material'])."</option>";
						}
						echo "<option value='MTL-1903000'>NONE MATERIAL</option>";
					 ?>
					</select>
					<input type='text' name='ListDetail[2][id_ori]' class='HideCost' id='id_ori' value='TYP-0003'>
					<input type='text' name='ListDetail[2][id_ori2]' class='HideCost' id='id_ori2' value='TYP-0003'>
					<input type='text' name='ListDetail[2][thickness]' class='HideCost' id='thickness_veil' value='0'>
					<input type='text' name='ListDetail[2][last_full]' class='HideCost' id='hasil_veil' value='0'>				
				</div>
				<label class='col-sm-2' style='text-align:left; margin-top: 6px;'>Weight</label>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'weight_veil','name'=>'ListDetail[2][value]', 'style'=>'margin-left:-110px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1' style='text-align:left; margin-left:-130px; margin-top: 6px;'>Layer</label>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'layer_veil','name'=>'ListDetail[2][layer]', 'style'=>'margin-left:-90px;width: 50px;','class'=>'form-control input-sm numberOnly','autocomplete'=>'off', 'value'=>''));											
					?>	
				</div>
				<label class='col-sm-2' style='text-align:left; margin-left: -130px; margin-top: 6px;'>Thickness</label>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'totthick_veil','name'=>'ListDetail[2][total_thickness]', 'style'=>'margin-left:-90px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly','value'=>'0'));											
					?>	
				</div>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'last_veil','name'=>'ListDetail[2][last_cost]', 'style'=>'margin-left:-80px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly','value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1 kghide' style='text-align:left; margin-left:-100px; margin-top: 6px;'>Kg</label>
			</div>
			<div class='form-group row'>		 	 
				<label class='label-control col-sm-2'><b></b></label>
				<div class='col-sm-3'>              
					<select name='id_material' id='mid_mtl_resin1' class='form-control input-sm' disabled>
						<option value=''>Select An Resin</option>
					<?php
						foreach($ListResin AS $val => $valx){
							echo "<option value='".$valx['id_material']."'>".strtoupper($valx['nm_material'])."</option>";
						}
						echo "<option value='MTL-1903000'>NONE MATERIAL</option>";
					 ?>
					</select>
					<input type='text' name='ListDetail[3][id_ori]' class='HideCost' id='id_ori' value='TYP-0001'>
					<input type='text' name='ListDetail[3][id_ori2]' class='HideCost' id='id_ori2' value='TYP-0001'>
					<input type='text' name='ListDetail[3][last_full]' class='HideCost' id='hasil_resin1' value='0'>
					<input type='text' name='ListDetail[3][id_material]' class='HideCost' id='layer_resin1hide'>
				</div>
				<label class='col-sm-2' style='text-align:left; margin-top: 6px;'><u>Rs.Containing</u></label>
				<div class='col-sm-1'>              
					
				</div>
				<label class='col-sm-1' style='text-align:left; margin-left:-130px; margin-top: 6px;'></label>
				<div class='col-sm-1'>              
					<!--<input type='text' name='ListDetail[3][layer_resin1]' id='layer_resin1' value='9' readonly>-->
					<?php
						echo form_input(array('id'=>'layer_resin1','name'=>'ListDetail[3][containing]', 'style'=>'margin-left:-90px;width: 50px;','class'=>'form-control input-sm numberOnly','autocomplete'=>'off', 'readonly'=>'readonly', 'value'=>'0'));	//9										
					?>
				</div>
				<label class='col-sm-2' style='text-align:left; margin-left: -130px; margin-top: 6px;'></label>
				<div class='col-sm-1'>              
					
				</div>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'last_resin1','name'=>'ListDetail[3][last_cost]', 'style'=>'margin-left:-80px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1 kghide' style='text-align:left; margin-left:-100px; margin-top: 6px;'>Kg</label>
			</div>
			<div class='form-group row'>		 	 
				<label class='label-control col-sm-2' style='text-align:left;'><b>ADDITIONAL VEIL<span class='text-red'>*</span></b></label>
				<div class='col-sm-3'>              
					<select name='ListDetail[4][id_material]' id='mid_mtl_veil_add' class='form-control input-sm'>
						<option value=''>Select An Veil Add</option>
					<?php
						foreach($ListVeil AS $val => $valx){
							echo "<option value='".$valx['id_material']."'>".strtoupper($valx['nm_material'])."</option>";
						}
						echo "<option value='MTL-1903000'>NONE MATERIAL</option>";
					 ?>
					</select>
					<input type='text' name='ListDetail[4][id_ori]' class='HideCost' id='id_ori' value='TYP-0003'>
					<input type='text' name='ListDetail[4][id_ori2]' class='HideCost' id='id_ori2' value='TYP-0003'>
					<input type='text' name='ListDetail[4][thickness]' class='HideCost' id='thickness_veil_add' value='0'>
					<input type='text' name='ListDetail[4][last_full]' class='HideCost' id='hasil_veil_add' value='0'>	
				</div>
				<label class='col-sm-2' style='text-align:left; margin-top: 6px;'>Weight</label>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'weight_veil_add','name'=>'ListDetail[4][value]', 'style'=>'margin-left:-110px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1' style='text-align:left; margin-left:-130px; margin-top: 6px;'>Layer</label>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'layer_veil_add','name'=>'ListDetail[4][layer]', 'style'=>'margin-left:-90px;width: 50px;','class'=>'form-control input-sm numberOnly','autocomplete'=>'off', 'value'=>''));											
					?>	
				</div>
				<label class='col-sm-2' style='text-align:left; margin-left: -130px; margin-top: 6px;'>Thickness</label>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'totthick_veil_add','name'=>'ListDetail[4][total_thickness]', 'style'=>'margin-left:-90px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'last_veil_add','name'=>'ListDetail[4][last_cost]', 'style'=>'margin-left:-80px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1 kghide' style='text-align:left; margin-left:-100px; margin-top: 6px;'>Kg</label>
			</div>
			<div class='form-group row'>		 	 
				<label class='label-control col-sm-2'><b></b></label>
				<div class='col-sm-3'>              
					<select name='id_material' id='mid_mtl_resin2' class='form-control input-sm' disabled>
						<option value=''>Select An Resin</option>
					<?php
						foreach($ListResin AS $val => $valx){
							echo "<option value='".$valx['id_material']."'>".strtoupper($valx['nm_material'])."</option>";
						}
						echo "<option value='MTL-1903000'>NONE MATERIAL</option>";
					 ?>
					</select>
					<input type='text' name='ListDetail[5][id_ori]' class='HideCost' id='id_ori' value='TYP-0001'>
					<input type='text' name='ListDetail[5][id_ori2]' class='HideCost' id='id_ori2' value='TYP-0001'>					
					<input type='text' name='ListDetail[5][last_full]' class='HideCost' id='hasil_resin2' value='0'>
					<input type='text' name='ListDetail[5][id_material]' class='HideCost' id='layer_resin2hide'>
				</div>
				<label class='col-sm-2' style='text-align:left; margin-top: 6px;'><u>Rs.Containing</u></label>
				<div class='col-sm-1'>              
					
				</div>
				<label class='col-sm-1' style='text-align:left; margin-left:-130px; margin-top: 6px;'></label>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'layer_resin2','name'=>'ListDetail[5][containing]', 'style'=>'margin-left:-90px;width: 50px;','class'=>'form-control input-sm numberOnly','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));	//9										
					?>
				</div>
				<label class='col-sm-2' style='text-align:left; margin-left: -130px; margin-top: 6px;'></label>
				<div class='col-sm-1'>              
					
				</div>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'last_resin2','name'=>'ListDetail[5][last_cost]', 'style'=>'margin-left:-80px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1 kghide' style='text-align:left; margin-left:-100px; margin-top: 6px;'>Kg</label>
			</div>
			<div class='form-group row'>		 	 
				<label class='label-control col-sm-2' style='text-align:left;'><b>MAT / CSM<span class='text-red'>*</span></b></label>
				<div class='col-sm-3'>              
					<select name='ListDetail[6][id_material]' id='mid_mtl_matcsm' class='form-control input-sm'>
						<option value=''>Select An MAT/CSM</option>
					<?php
						foreach($ListMatCsm AS $val => $valx){
							echo "<option value='".$valx['id_material']."'>".strtoupper($valx['nm_material'])."</option>";
						}
						echo "<option value='MTL-1903000'>NONE MATERIAL</option>";
					 ?>
					</select>
					<input type='text' name='ListDetail[6][id_ori]' class='HideCost' id='id_ori' value='TYP-0004'>
					<input type='text' name='ListDetail[6][id_ori2]' class='HideCost' id='id_ori2' value='TYP-0004'>	
					<input type='text' name='ListDetail[6][thickness]' class='HideCost' id='thickness_matcsm' value='0'>
					<input type='text' name='ListDetail[6][last_full]' class='HideCost' id='hasil_matcsm' value='0'>	
				</div>
				<label class='col-sm-2' style='text-align:left; margin-top: 6px;'>Weight</label>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'weight_matcsm','name'=>'ListDetail[6][value]', 'style'=>'margin-left:-110px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1' style='text-align:left; margin-left:-130px; margin-top: 6px;'>Layer</label>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'layer_matcsm','name'=>'ListDetail[6][layer]', 'style'=>'margin-left:-90px;width: 50px;','class'=>'form-control input-sm numberOnly','autocomplete'=>'off', 'value'=>''));											
					?>	
				</div>
				<label class='col-sm-2' style='text-align:left; margin-left: -130px; margin-top: 6px;'>Thickness</label>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'totthick_matcsm','name'=>'ListDetail[6][total_thickness]', 'style'=>'margin-left:-90px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly','value'=>'0'));											
					?>	
				</div>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'last_matcsm','name'=>'ListDetail[6][last_cost]', 'style'=>'margin-left:-80px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly','value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1 kghide' style='text-align:left; margin-left:-100px; margin-top: 6px;'>Kg</label>
			</div>
			<div class='form-group row'>		 	 
				<label class='label-control col-sm-2'><b></b></label>
				<div class='col-sm-3'>              
					<select name='id_material' id='mid_mtl_resin3' class='form-control input-sm' disabled>
					<option value=''>Select An Resin</option>
					<?php
						foreach($ListResin AS $val => $valx){
							echo "<option value='".$valx['id_material']."'>".strtoupper($valx['nm_material'])."</option>";
						}
						echo "<option value='MTL-1903000'>NONE MATERIAL</option>";
					 ?>
					</select>
					<input type='text' name='ListDetail[7][id_ori]' class='HideCost' id='id_ori' value='TYP-0001'>
					<input type='text' name='ListDetail[7][id_ori2]' class='HideCost' id='id_ori2' value='TYP-0001'>
					<input type='text' name='ListDetail[7][last_full]' class='HideCost' id='hasil_resin3' value='0'>
					<input type='text' name='ListDetail[7][id_material]' class='HideCost' id='layer_resin3hide'>
				</div>
				<label class='col-sm-2' style='text-align:left; margin-top: 6px;'><u>Rs.Containing</u></label>
				<div class='col-sm-1'>              
					
				</div>
				<label class='col-sm-1' style='text-align:left; margin-left:-130px; margin-top: 6px;'></label>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'layer_resin3','name'=>'ListDetail[7][containing]', 'style'=>'margin-left:-90px;width: 50px;','class'=>'form-control input-sm numberOnly','autocomplete'=>'off', 'readonly'=>'readonly','value'=>'0'));	//2.333									
					?>
				</div>
				<label class='col-sm-2' style='text-align:left; margin-left: -130px; margin-top: 6px;'></label>
				<div class='col-sm-1'>              
					
				</div>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'last_resin3','name'=>'ListDetail[7][last_cost]', 'style'=>'margin-left:-80px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1 kghide' style='text-align:left; margin-left:-100px; margin-top: 6px;'>Kg</label>
			</div>
			<div class='form-group row'>		 	 
				<label class='label-control col-sm-2' style='text-align:left;'><b>ADDITIONAL CSM<span class='text-red'>*</span></b></label>
				<div class='col-sm-3'>              
					<select name='ListDetail[8][id_material]' id='mid_mtl_csm_add' class='form-control input-sm'>
					<option value=''>Select An MAT/CSM</option>
					<?php
						foreach($ListMatCsm AS $val => $valx){
							echo "<option value='".$valx['id_material']."'>".strtoupper($valx['nm_material'])."</option>";
						}
						echo "<option value='MTL-1903000'>NONE MATERIAL</option>";
					 ?>
					</select>
					<input type='text' name='ListDetail[8][id_ori]' class='HideCost' id='id_ori' value='TYP-0004'>
					<input type='text' name='ListDetail[8][id_ori2]' class='HideCost' id='id_ori2' value='TYP-0004'>	
					<input type='text' name='ListDetail[8][thickness]' class='HideCost' id='thickness_csm_add' value='0'>
					<input type='text' name='ListDetail[8][last_full]' class='HideCost' id='hasil_csm_add' value='0'>	
				</div>
				<label class='col-sm-2' style='text-align:left; margin-top: 6px;'>Weight</label>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'weight_csm_add','name'=>'ListDetail[8][value]', 'style'=>'margin-left:-110px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1' style='text-align:left; margin-left:-130px; margin-top: 6px;'>Layer</label>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'layer_csm_add','name'=>'ListDetail[8][layer]', 'style'=>'margin-left:-90px;width: 50px;','class'=>'form-control input-sm numberOnly','autocomplete'=>'off', 'value'=>''));											
					?>	
				</div>
				<label class='col-sm-2' style='text-align:left; margin-left: -130px; margin-top: 6px;'>Thickness</label>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'totthick_csm_add','name'=>'ListDetail[8][total_thickness]', 'style'=>'margin-left:-90px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly','value'=>'0'));											
					?>	
				</div>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'last_csm_add','name'=>'ListDetail[8][last_cost]', 'style'=>'margin-left:-80px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly','value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1 kghide' style='text-align:left; margin-left:-100px; margin-top: 6px;'>Kg</label>
			</div>
			<div class='form-group row'>		 	 
				<label class='label-control col-sm-2'><b></b></label>
				<div class='col-sm-3'>              
					<select name='id_material' id='mid_mtl_resin4' class='form-control input-sm' disabled>
					<option value=''>Select An Resin</option>
					<?php
						foreach($ListResin AS $val => $valx){
							echo "<option value='".$valx['id_material']."'>".strtoupper($valx['nm_material'])."</option>";
						}
						echo "<option value='MTL-1903000'>NONE MATERIAL</option>";
					 ?>
					</select>
					<input type='text' name='ListDetail[9][id_ori]' class='HideCost' id='id_ori' value='TYP-0001'>
					<input type='text' name='ListDetail[9][id_ori2]' class='HideCost' id='id_ori2' value='TYP-0001'>
					<input type='text' name='ListDetail[9][last_full]' class='HideCost' id='hasil_resin4' value='0'>
					<input type='text' name='ListDetail[9][id_material]' class='HideCost' id='layer_resin4hide'>					
				</div>
				<label class='col-sm-2' style='text-align:left; margin-top: 6px;'><u>Rs.Containing</u></label>
				<div class='col-sm-1'>              
					
				</div>
				<label class='col-sm-1' style='text-align:left; margin-left:-130px; margin-top: 6px;'></label>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'layer_resin4','name'=>'ListDetail[9][containing]', 'style'=>'margin-left:-90px;width: 50px;','class'=>'form-control input-sm numberOnly','autocomplete'=>'off', 'readonly'=>'readonly','value'=>'0'));	//2.333										
					?>
				</div>
				<label class='col-sm-2' style='text-align:left; margin-left: -130px; margin-top: 6px;'></label>
				<div class='col-sm-1'>              
					
				</div>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'last_resin4','name'=>'ListDetail[9][last_cost]', 'style'=>'margin-left:-80px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1 kghide' style='text-align:left; margin-left:-100px; margin-top: 6px;'>Kg</label>
			</div>
			<div class='form-group row'>		 	 
				<label class='label-control col-sm-2'><b>TOTAL RESIN<span class='text-red'>*</span></b></label>
				<div class='col-sm-3'>              
					<select name='ListDetail[10][id_material]' id='mid_mtl_resin_tot' class='form-control input-sm'>
					<option value=''>Select An Resin</option>
					<?php
						foreach($ListResin AS $val => $valx){
							echo "<option value='".$valx['id_material']."'>".strtoupper($valx['nm_material'])."</option>";
						}
						echo "<option value='MTL-1903000'>NONE MATERIAL</option>";
					 ?>
					</select>
					<input type='text' name='ListDetail[10][id_ori]' class='HideCost' id='id_ori' value='TYP-0001'>
					<input type='text' name='ListDetail[10][id_ori2]' class='HideCost' id='id_ori2' value='TYP-0001'>
					<input type='text' name='ListDetail[10][last_full]' class='HideCost' id='hasil_resin_tot' value='0'>
					<!-- Pergantian  resin liner 0.5 menjadi 0.3, 20 april 2019 -->
					<input type='text' name='ListDetail[10][containing]' class='HideCost' id='layer_resin_tot' value='0.3'>
					<!--<input type='text' name='ListDetail[10][id_material]' class='HideCost' id='layer_resinTothide'>-->
				</div>
				<label class='col-sm-2' style='text-align:left; margin-top: 6px;'></label>
				<div class='col-sm-1'>              
					
				</div>
				<label class='col-sm-1' style='text-align:left; margin-left:-130px; margin-top: 6px;'></label>
				<div class='col-sm-1'>              
					
				</div>
				<label class='col-sm-2' style='text-align:left; margin-left: -130px; margin-top: 6px;'></label>
				<div class='col-sm-1'>              
					
				</div>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'last_resin_tot','name'=>'ListDetail[10][last_cost]', 'style'=>'margin-left:-80px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1 kghide' style='text-align:left; margin-left:-100px; margin-top: 6px;'>Kg</label>
			</div>
			<div class='form-group row'>
				<label class='col-sm-2' style='text-align:left; margin-top: 6px;'></label>
				
				<label class='label-control col-sm-1'><b>Katalis<span class='text-red'>*</span></b></label>
				<div class='col-sm-3'>              
					<select name='ListDetailPlus[0][id_material]' id='mid_mtl_katalis' class='form-control input-sm'>
						<option value=''>Select An Katalis</option>
					<?php
						foreach($ListMatKatalis AS $val => $valx){
							echo "<option value='".$valx['id_material']."'>".strtoupper($valx['nm_material'])."</option>";
						}
						echo "<option value='MTL-1903000'>NONE MATERIAL</option>";
					 ?>
					</select>
					<input type='text' name='ListDetailPlus[0][id_ori]' class='HideCost' id='id_ori' value='TYP-0002'>
					<input type='text' name='ListDetailPlus[0][id_ori2]' class='HideCost' id='id_ori2' value='TYP-0002'>
					<input type='text' name='ListDetailPlus[0][last_full]' class='HideCost' id='hasil_katalis' value='0'>
					<!--<input type='text' name='ListDetailPlus[0][containing]' class='HideCost' id='layer_katalis' value='0'>-->
					<!--<input type='text' name='ListDetailPlus[0][perse]' class='HideCost' id='persen_katalis' value='0.025'>-->
				</div>
				
				<label class='col-sm-1' style='text-align:left; margin-left: 0px; margin-top: 6px;'>Comparison</label>
				<div class='col-sm-2'>              
					<input type='text' name='ListDetailPlus[0][containing]' style='width:50px; margin-left:12px;' class='form-control input-sm numberOnly' readonly='readonly' id='layer_katalis' value='0'>	
				</div>
				<label class='col-sm-2' style='text-align:left; margin-left: -129px; margin-top: 6px;'>Percent</label>
				<div class='col-sm-1'>              
					<input type='text' name='ListDetailPlus[0][perse]' style='margin-left:-92px;' class='form-control input-sm numberOnly' id='persen_katalis' value='2'>	
				</div>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'last_katalis','name'=>'ListDetailPlus[0][last_cost]', 'style'=>'margin-left:-81px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1 kghide' style='text-align:left; margin-left:-101px; margin-top: 6px;'>Kg</label>
			</div>
			<div class='form-group row'>
				<label class='col-sm-2' style='text-align:left; margin-top: 6px;'></label>
				
				<label class='label-control col-sm-1'><b>SM<span class='text-red'>*</span></b></label>
				<div class='col-sm-3'>              
					<select name='ListDetailPlus[1][id_material]' id='mid_mtl_sm' class='form-control input-sm'>
						<option value=''>Select An SM</option>
					<?php
						foreach($ListMatSm AS $val => $valx){
							echo "<option value='".$valx['id_material']."'>".strtoupper($valx['nm_material'])."</option>";
						}
						echo "<option value='MTL-1903000'>NONE MATERIAL</option>";
					 ?>
					</select>
					<input type='text' name='ListDetailPlus[1][id_ori]' class='HideCost' id='id_ori' value='TYP-0024'>
					<input type='text' name='ListDetailPlus[1][id_ori2]' class='HideCost' id='id_ori2' value='TYP-0024'>
					<input type='text' name='ListDetailPlus[1][last_full]' class='HideCost' id='hasil_sm' value='0'>
					<!--
					<input type='text' name='ListDetailPlus[1][containing]' class='HideCost' id='layer_sm' value='0'>
					<input type='text' name='ListDetailPlus[1][perse]' class='HideCost' id='persen_sm' value='0.025'>
					-->
				</div>
				
				<label class='col-sm-1' style='text-align:left; margin-left:0px; margin-top: 6px;'>Comparison</label>
				<div class='col-sm-2'>              
					<input type='text' name='ListDetailPlus[1][containing]' style='width:50px; margin-left:12px;' class='form-control input-sm numberOnly' readonly='readonly' id='layer_sm' value='0'>	
				</div>
				<label class='col-sm-2' style='text-align:left; margin-left: -129px; margin-top: 6px;'>Percent</label>
				<div class='col-sm-1'>              
					<input type='text' name='ListDetailPlus[1][perse]' style='margin-left:-92px;' class='form-control input-sm numberOnly' id='persen_sm' value='2.5'>	
				</div>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'last_sm','name'=>'ListDetailPlus[1][last_cost]', 'style'=>'margin-left:-81px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1 kghide' style='text-align:left; margin-left:-101px; margin-top: 6px;'>Kg</label>
			</div>
			<div class='form-group row'>
				<label class='col-sm-2' style='text-align:left; margin-top: 6px;'></label>
				
				<label class='label-control col-sm-1'><b>Cobalt<span class='text-red'>*</span></b></label>
				<div class='col-sm-3'>              
					<select name='ListDetailPlus[2][id_material]' id='mid_mtl_cobalt' class='form-control input-sm'>
						<option value=''>Select An Cobalt</option>
					<?php
						foreach($ListMatCobalt AS $val => $valx){
							echo "<option value='".$valx['id_material']."' >".strtoupper($valx['nm_material'])."</option>";
						}
						echo "<option value='MTL-1903000'>NONE MATERIAL</option>";
					 ?>
					</select>
					<input type='text' name='ListDetailPlus[2][id_ori]' class='HideCost' id='id_ori' value='TYP-0021'>
					<input type='text' name='ListDetailPlus[2][id_ori2]' class='HideCost' id='id_ori2' value='TYP-0021'>
					<input type='text' name='ListDetailPlus[2][last_full]' class='HideCost' id='hasil_coblat' value='0'>
					<!--
					<input type='text' name='ListDetailPlus[2][containing]' class='HideCost' id='layer_coblat' value='0'>
					<input type='text' name='ListDetailPlus[2][perse]' class='HideCost' id='persen_coblat' value='0.002'>
					-->
				</div>
				
				<label class='col-sm-1' style='text-align:left; margin-left:0px; margin-top: 6px;'>Comparison</label>
				<div class='col-sm-2'>              
					<input type='text' name='ListDetailPlus[2][containing]' style='width:50px; margin-left:12px;' class='form-control input-sm numberOnly' readonly='readonly' id='layer_coblat' value='0'>	
				</div>
				<label class='col-sm-2' style='text-align:left; margin-left: -129px; margin-top: 6px;'>Percent</label>
				<div class='col-sm-1'>              
					<input type='text' name='ListDetailPlus[2][perse]' style='margin-left:-92px;' class='form-control input-sm numberOnly' id='persen_coblat' value='0.2'>	
				</div>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'last_cobalt','name'=>'ListDetailPlus[2][last_cost]', 'style'=>'margin-left:-81px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1 kghide' style='text-align:left; margin-left:-101px; margin-top: 6px;'>Kg</label>
			</div>
			<div class='form-group row'>
				<label class='col-sm-2' style='text-align:left; margin-top: 6px;'></label>
				
				<label class='label-control col-sm-1'><b>DMA<span class='text-red'>*</span></b></label>
				<div class='col-sm-3'>              
					<select name='ListDetailPlus[3][id_material]' id='mid_mtl_dma' class='form-control input-sm'>
						<option value=''>Select An DMA</option>
					<?php
						foreach($ListMatDma AS $val => $valx){
							echo "<option value='".$valx['id_material']."'>".strtoupper($valx['nm_material'])."</option>";
						}
						echo "<option value='MTL-1903000'>NONE MATERIAL</option>";
					 ?>
					</select>
					<input type='text' name='ListDetailPlus[3][id_ori]' class='HideCost' id='id_ori' value='TYP-0021'>
					<input type='text' name='ListDetailPlus[3][id_ori2]' class='HideCost' id='id_ori2' value='TYP-0021'>
					<input type='text' name='ListDetailPlus[3][last_full]' class='HideCost' id='hasil_dma' value='0'>
					<!--
					<input type='text' name='ListDetailPlus[3][containing]' class='HideCost' id='layer_dma' value='0'>
					<input type='text' name='ListDetailPlus[3][perse]' class='HideCost' id='persen_dma' value='0.002'>
					-->
				</div>
				
				<label class='col-sm-1' style='text-align:left; margin-left:0px; margin-top: 6px;'>Comparison</label>
				<div class='col-sm-2'>              
					<input type='text' name='ListDetailPlus[3][containing]' style='width:50px; margin-left:12px;' class='form-control input-sm numberOnly' readonly='readonly' id='layer_dma' value='0'>	
				</div>
				<label class='col-sm-2' style='text-align:left; margin-left: -129px; margin-top: 6px;'>Percent</label>
				<div class='col-sm-1'>              
					<input type='text' name='ListDetailPlus[3][perse]' style='margin-left:-92px;' class='form-control input-sm numberOnly' id='persen_dma' value='0.2'>	
				</div>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'last_dma','name'=>'ListDetailPlus[3][last_cost]', 'style'=>'margin-left:-81px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1 kghide' style='text-align:left; margin-left:-101px; margin-top: 6px;'>Kg</label>
			</div>
			<div class='form-group row'>
				<label class='col-sm-2' style='text-align:left; margin-top: 6px;'></label>
				
				<label class='label-control col-sm-1'><b>Hydroquinone<span class='text-red'>*</span></b></label>
				<div class='col-sm-3'>              
					<select name='ListDetailPlus[4][id_material]' id='mid_mtl_hydro' class='form-control input-sm'>
						<option value=''>Select An Hydroquinone</option>
					<?php
						foreach($ListMatHydo AS $val => $valx){
							echo "<option value='".$valx['id_material']."' >".strtoupper($valx['nm_material'])."</option>";
						}
						echo "<option value='MTL-1903000'>NONE MATERIAL</option>";
					 ?>
					</select>
					<input type='text' name='ListDetailPlus[4][id_ori]' class='HideCost' id='id_ori' value='TYP-0026'>
					<input type='text' name='ListDetailPlus[4][id_ori2]' class='HideCost' id='id_ori2' value='TYP-0026'>
					<input type='text' name='ListDetailPlus[4][last_full]' class='HideCost' id='hasil_hydroquinone' value='0'>
					<!--
					<input type='text' name='ListDetailPlus[4][containing]' class='HideCost' id='layer_hydroquinone' value='0'>
					<input type='text' name='ListDetailPlus[4][perse]' class='HideCost' id='persen_hydroquinone' value='0.0005'>
					-->
				</div>
				
				<label class='col-sm-1' style='text-align:left; margin-left:0px; margin-top: 6px;'>Comparison</label>
				<div class='col-sm-2'>              
					<input type='text' name='ListDetailPlus[4][containing]' style='width:50px; margin-left:12px;' class='form-control input-sm numberOnly' readonly='readonly' id='layer_hydroquinone' value='0'>	
				</div>
				<label class='col-sm-2' style='text-align:left; margin-left: -129px; margin-top: 6px;'>Percent</label>
				<div class='col-sm-1'>              
					<input type='text' name='ListDetailPlus[4][perse]' style='margin-left:-92px;' class='form-control input-sm numberOnly' id='persen_hydroquinone' value='0.05'>	
				</div>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'last_hidro','name'=>'ListDetailPlus[4][last_cost]', 'style'=>'margin-left:-81px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1 kghide' style='text-align:left; margin-left:-101px; margin-top: 6px;'>Kg</label>
			</div>
			<div class='form-group row'>
				<label class='col-sm-2' style='text-align:left; margin-top: 6px;'></label>
				
				<label class='label-control col-sm-1'><b>Methanol<span class='text-red'>*</span></b></label>
				<div class='col-sm-3'>              
					<select name='ListDetailPlus[5][id_material]' id='mid_mtl_methanol' class='form-control input-sm'>
						<option value=''>Select An Methanol</option>
					<?php
						foreach($ListMatMethanol AS $val => $valx){
							echo "<option value='".$valx['id_material']."' >".strtoupper($valx['nm_material'])."</option>";
						}
						echo "<option value='MTL-1903000'>NONE MATERIAL</option>";
					 ?>
					</select>
					<input type='text' name='ListDetailPlus[5][id_ori]' class='HideCost' id='id_ori' value='TYP-0026'>
					<input type='text' name='ListDetailPlus[5][id_ori2]' class='HideCost' id='id_ori2' value='TYP-0026'>
					<input type='text' name='ListDetailPlus[5][last_full]' class='HideCost' id='hasil_methanol' value='0'>
					<!--
					<input type='text' name='ListDetailPlus[5][containing]' class='HideCost' id='layer_methanol' value='0'>
					<input type='text' name='ListDetailPlus[5][perse]' class='HideCost' id='persen_methanol' value='0.0005'>
					-->
				</div>
				
				<label class='col-sm-1' style='text-align:left; margin-left:0px; margin-top: 6px;'>Comparison</label>
				<div class='col-sm-2'>              
					<input type='text' name='ListDetailPlus[5][containing]' style='width:50px; margin-left:12px;' class='form-control input-sm numberOnly' readonly='readonly' id='layer_methanol' value='0'>	
				</div>
				<label class='col-sm-2' style='text-align:left; margin-left: -129px; margin-top: 6px;'>Percent</label>
				<div class='col-sm-1'>              
					<input type='text' name='ListDetailPlus[5][perse]' style='margin-left:-92px;' class='form-control input-sm numberOnly' id='persen_methanol' value='0.05'>	
				</div>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'last_methanol','name'=>'ListDetailPlus[5][last_cost]', 'style'=>'margin-left:-81px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1 kghide' style='text-align:left; margin-left:-101px; margin-top: 6px;'>Kg</label>
			</div>
			<!-- Add Material-->
			<button type='button' name='add_liner' id='add_liner' class='btn btn-success btn-sm' style='width:150px; margin-left: 10px;'>Add Material</button>
			<input type='hidden' name='numberMax_liner' id='numberMax_liner' value='0'>
			
			<div class="box-body" style="">
				<table id="my-grid_liner" class="table table-striped table-bordered table-hover table-condensed" width="100%">
					<tbody id='detail_body_liner'>
					</tbody>
				</table>
			</div>
			<!-- END -->
			<div class='form-group row'>		 	 
				<label class='label-control col-sm-2' style='text-align:right;'></label>
				<div class='col-sm-2'>              
					
				</div>
				<label class='col-sm-2' style='text-align:left; margin-top: 6px;'></label>
				<div class='col-sm-1'>              
					
				</div>
				<label class='col-sm-1' style='text-align:left; margin-left:-100px; margin-top: 6px;'></label>
				<div class='col-sm-1'>              
					
				</div>
				<label class='col-sm-2' style='text-align:left; margin-left: -50px; margin-top: 6px;'>Total Liner Thickness</label>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'tot_lin_thickness','name'=>'tot_lin_thickness', 'style'=>'margin-left:-50px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<div class='col-sm-1'>              
					
				</div>
				<label class='col-sm-1' style='text-align:left; margin-left:-100px; margin-top: 6px;'></label>
			</div>
			<div class='form-group row'>		 	 
				<label class='label-control col-sm-2' style='text-align:right;'></label>
				<div class='col-sm-2'>              
					
				</div>
				<label class='col-sm-2' style='text-align:left; margin-top: 6px;'></label>
				<div class='col-sm-1'>              
					
				</div>
				<label class='col-sm-1' style='text-align:left; margin-left:-100px; margin-top: 6px;'></label>
				<div class='col-sm-1'>              
					
				</div>
				<label class='col-sm-2' style='text-align:left; margin-left: -50px; margin-top: 6px;'>Min Liner Thickness</label>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'mix_lin_thickness','name'=>'mix_lin_thickness', 'style'=>'margin-left:-50px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<div class='col-sm-1'>              
					
				</div>
				<label class='col-sm-1' style='text-align:left; margin-left:-100px; margin-top: 6px;'></label>
			</div>
			<div class='form-group row'>		 	 
				<label class='label-control col-sm-2' style='text-align:right;'></label>
				<div class='col-sm-2'>              
					
				</div>
				<label class='col-sm-2' style='text-align:left; margin-top: 6px;'></label>
				<div class='col-sm-1'>              
					
				</div>
				<label class='col-sm-1' style='text-align:left; margin-left:-100px; margin-top: 6px;'></label>
				<div class='col-sm-1'>              
					
				</div>
				<label class='col-sm-2' style='text-align:left; margin-left: -50px; margin-top: 6px;'>Max Liner Thickness</label>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'max_lin_thickness','name'=>'max_lin_thickness', 'style'=>'margin-left:-50px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<div class='col-sm-1'>              
					
				</div>
				<label class='col-sm-1' style='text-align:left; margin-left:-100px; margin-top: 6px;'></label>
			</div>
			<div class='form-group row'>		 	 
				<label class='label-control col-sm-2' style='text-align:right;'></label>
				<div class='col-sm-2'>              
					
				</div>
				<label class='col-sm-2' style='text-align:left; margin-top: 6px;'></label>
				<div class='col-sm-1'>              
					
				</div>
				<label class='col-sm-1' style='text-align:left; margin-left:-100px; margin-top: 6px;'></label>
				<div class='col-sm-1'>              
					
				</div>
				<label class='col-sm-2' style='text-align:left; margin-left: -50px; margin-top: 6px;'></label>
				<div class='col-sm-2'>              
					<?php
						echo form_input(array('id'=>'hasil_linier_thickness','name'=>'hasil_linier_thickness', 'style'=>'margin-left:-50px; height: 40px;','class'=>'form-control input-sm HasilKet','autocomplete'=>'off','readonly'=>'readonly'));											
					?>	
				</div>
				
				<label class='col-sm-1' style='text-align:left; margin-left:-100px; margin-top: 6px;'></label>
			</div>
			<!-- ====================================================================================================== -->
			<!-- ============================================END LINER THICKNESS======================================= -->
			<!-- ====================================================================================================== -->
			
			<!-- ====================================================================================================== -->
			<!-- ============================================STRUKTUR THICKNESS======================================== -->
			<!-- ====================================================================================================== -->
			<div class='headerTitle'>STRUKTUR THIKNESS</div>
			<div class='form-group row'>		 	 
				<div class='col-sm-12'>              
					<input type='text' name='acuhan_2' class='Acuhan numberOnly' id='acuhan_2' readonly='readonly' value='0'>
					<input type='text' name='detail_name2' id='detail_name2' class='HideCost' value='STRUKTUR THICKNESS'>
				</div>
			</div>
			<div class='form-group row'>		 	 
				<label class='label-control col-sm-2' style='text-align:left;'><b>MAT / CSM<span class='text-red'>*</span></b></label>
				
				<div class='col-sm-3'>              
					<select name='ListDetail2[0][id_material]' id='mid_mtl_matcsm2' class='form-control input-sm'>
						<option value=''>Select An MAT/CSM</option>
					<?php
						foreach($ListMatCsm AS $val => $valx){
							echo "<option value='".$valx['id_material']."'>".strtoupper($valx['nm_material'])."</option>";
						}
						echo "<option value='MTL-1903000'>NONE MATERIAL</option>";
					 ?>
					</select>
					<input type='text' name='ListDetail2[0][id_ori]' class='HideCost' id='id_ori' value='TYP-0004'>
					<input type='text' name='ListDetail2[0][id_ori2]' class='HideCost' id='id_ori2' value='TYP-0004'>
					<input type='text' name='ListDetail2[0][thickness]' class='HideCost' id='thickness_matcsm2' value='0'>
					<input type='text' name='ListDetail2[0][last_full]' class='HideCost' id='hasil_matcsm2' value='0'>	
				</div>
				<label class='col-sm-2' style='text-align:left; margin-top: 6px;'>Weight</label>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'weight_matcsm2','name'=>'ListDetail2[0][value]', 'style'=>'margin-left:-110px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1' style='text-align:left; margin-left:-130px; margin-top: 6px;'>Layer</label>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'layer_matcsm2','name'=>'ListDetail2[0][layer]', 'style'=>'margin-left:-90px;width: 50px;','class'=>'form-control input-sm numberOnly','autocomplete'=>'off', 'value'=>''));											
					?>	
				</div>
				<label class='col-sm-2' style='text-align:left; margin-left: -130px; margin-top: 6px;'>Thickness</label>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'totthick_matcsm2','name'=>'ListDetail2[0][total_thickness]', 'style'=>'margin-left:-90px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly','value'=>'0'));											
					?>	
				</div>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'last_matcsm2','name'=>'ListDetail2[0][last_cost]', 'style'=>'margin-left:-80px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly','value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1 kghide' style='text-align:left; margin-left:-100px; margin-top: 6px;'>Kg</label>
			</div>
			<div class='form-group row'>		 	 
				<label class='label-control col-sm-2'><b></b></label>
				<div class='col-sm-3'>              
					<select name='id_material' id='mid_mtl_resin21' class='form-control input-sm' disabled>
					<option value=''>Select An Resin</option>
					<?php
						foreach($ListResin AS $val => $valx){
							echo "<option value='".$valx['id_material']."'>".strtoupper($valx['nm_material'])."</option>";
						}
						echo "<option value='MTL-1903000'>NONE MATERIAL</option>";
					 ?>
					</select>
					<input type='text' name='ListDetail2[1][id_ori]' class='HideCost' id='id_ori' value='TYP-0001'>
					<input type='text' name='ListDetail2[1][id_ori2]' class='HideCost' id='id_ori2' value='TYP-0001'>
					<input type='text' name='ListDetail2[1][last_full]' class='HideCost' id='hasil_resin21' value='0'>
					<input type='text' name='ListDetail2[1][id_material]' class='HideCost' id='layer_resin21hide'>	
					<!--<input type='text' name='ListDetail2[1][containing]' class='HideCost' id='layer_resin21' value='2.333'>-->
				</div>
				<label class='col-sm-2' style='text-align:left; margin-top: 6px;'><u>Rs.Containing</u></label>
				<div class='col-sm-1'>              
					
				</div>
				<label class='col-sm-1' style='text-align:left; margin-left:-130px; margin-top: 6px;'></label>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'layer_resin21','name'=>'ListDetail2[1][containing]', 'style'=>'margin-left:-90px;width: 50px;','class'=>'form-control input-sm numberOnly','autocomplete'=>'off', 'readonly'=>'readonly', 'value'=>'0'));	//2.333										
					?>
				</div>
				<label class='col-sm-2' style='text-align:left; margin-left: -130px; margin-top: 6px;'></label>
				<div class='col-sm-1'>              
					
				</div>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'last_resin21','name'=>'ListDetail2[1][last_cost]', 'style'=>'margin-left:-80px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1 kghide' style='text-align:left; margin-left:-100px; margin-top: 6px;'>Kg</label>
			</div>
			<div class='form-group row'>		 	 
				<label class='label-control col-sm-2' style='text-align:left;'><b>ADDITIONAL CSM<span class='text-red'>*</span></b></label>
				<div class='col-sm-3'>              
					<select name='ListDetail2[2][id_material]' id='mid_mtl_csm_add2' class='form-control input-sm'>
					<option value=''>Select An MAT/CSM</option> 
					<?php
						foreach($ListMatCsm AS $val => $valx){
							echo "<option value='".$valx['id_material']."'>".strtoupper($valx['nm_material'])."</option>";
						}
						echo "<option value='MTL-1903000'>NONE MATERIAL</option>";
					 ?>
					</select>
					<input type='text' name='ListDetail2[2][id_ori]' class='HideCost' id='id_ori' value='TYP-0004'>
					<input type='text' name='ListDetail2[2][id_ori2]' class='HideCost' id='id_ori2' value='TYP-0004'>
					<input type='text' name='ListDetail2[2][thickness]' class='HideCost' id='thickness_csm_add2' value='0'>
					<input type='text' name='ListDetail2[2][last_full]' class='HideCost' id='hasil_csm_add2' value='0'>	
				</div>
				<label class='col-sm-2' style='text-align:left; margin-top: 6px;'>Weight</label>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'weight_csm_add2','name'=>'ListDetail2[2][value]', 'style'=>'margin-left:-110px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1' style='text-align:left; margin-left:-130px; margin-top: 6px;'>Layer</label>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'layer_csm_add2','name'=>'ListDetail2[2][layer]', 'style'=>'margin-left:-90px;width: 50px;','class'=>'form-control input-sm numberOnly','autocomplete'=>'off', 'value'=>''));											
					?>	
				</div>
				<label class='col-sm-2' style='text-align:left; margin-left: -130px; margin-top: 6px;'>Thickness</label>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'totthick_csm_add2','name'=>'ListDetail2[2][total_thickness]', 'style'=>'margin-left:-90px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly','value'=>'0'));											
					?>	
				</div>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'last_csm_add2','name'=>'ListDetail2[2][last_cost]', 'style'=>'margin-left:-80px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly','value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1 kghide' style='text-align:left; margin-left:-100px; margin-top: 6px;'>Kg</label>
			</div>
			<div class='form-group row'>		 	 
				<label class='label-control col-sm-2'><b></b></label>
				<div class='col-sm-3'>              
					<select name='id_material' id='mid_mtl_resin22' class='form-control input-sm' style="display:none;" disabled>
					<option value=''>Select An Resin</option>
					<?php
						foreach($ListResin AS $val => $valx){
							echo "<option value='".$valx['id_material']."'>".strtoupper($valx['nm_material'])."</option>";
						}
						echo "<option value='MTL-1903000'>NONE MATERIAL</option>";
					 ?>
					</select>
					<input type='text' name='ListDetail2[3][id_ori]' class='HideCost' id='id_ori' value='TYP-0001'>
					<input type='text' name='ListDetail2[3][id_ori2]' class='HideCost' id='id_ori2' value='TYP-0001'>
					<input type='text' name='ListDetail2[3][last_full]' class='HideCost' id='hasil_resin22' value='0'>
					<!--<input type='text' name='ListDetail2[3][containing]' class='HideCost' id='layer_resin22' value='2.333'>-->
					<input type='text' name='ListDetail2[3][id_material]' class='HideCost' id='layer_resin22hide'>					
				</div>
				<label class='col-sm-2' style='text-align:left; margin-top: 6px;'><u>Rs.Containing</u></label>
				<div class='col-sm-1'>              
					
				</div>
				<label class='col-sm-1' style='text-align:left; margin-left:-130px; margin-top: 6px;'></label>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'layer_resin22','name'=>'ListDetail2[3][containing]', 'style'=>'margin-left:-90px;width: 50px;','class'=>'form-control input-sm numberOnly','autocomplete'=>'off', 'readonly'=>'readonly', 'value'=>'0'));	//2,333										
					?>
				</div>
				<label class='col-sm-2' style='text-align:left; margin-left: -130px; margin-top: 6px;'></label>
				<div class='col-sm-1'>              
					
				</div>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'last_resin22','name'=>'ListDetail2[3][last_cost]', 'style'=>'margin-left:-80px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1 kghide' style='text-align:left; margin-left:-100px; margin-top: 6px;'>Kg</label>
			</div>
			<div class='form-group row'>		 	 
				<label class='label-control col-sm-2' style='text-align:left;'><b>WR<span class='text-red'>*</span></b></label>
				<div class='col-sm-3'>              
					<select name='ListDetail2[4][id_material]' id='mid_mtl_wr2' class='form-control input-sm'>
						<option value=''>Select An WR</option>
					<?php
						foreach($ListMatWR AS $val => $valx){
							echo "<option value='".$valx['id_material']."'>".strtoupper($valx['nm_material'])."</option>";
						}
						echo "<option value='MTL-1903000'>NONE MATERIAL</option>";
					 ?>
					</select>
					<input type='text' name='ListDetail2[4][id_ori]' class='HideCost' id='id_ori' value='TYP-0006'>
					<input type='text' name='ListDetail2[4][id_ori2]' class='HideCost' id='id_ori2' value='TYP-0006'>
					<input type='text' name='ListDetail2[4][thickness]' class='HideCost' id='thickness_wr2' value='0'>
					<input type='text' name='ListDetail2[4][last_full]' class='HideCost' id='hasil_wr2' value='0'>				
				</div>
				<label class='col-sm-2' style='text-align:left; margin-top: 6px;'>Weight</label>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'weight_wr2','name'=>'ListDetail2[4][value]', 'style'=>'margin-left:-110px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1' style='text-align:left; margin-left:-130px; margin-top: 6px;'>Layer</label>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'layer_wr2','name'=>'ListDetail2[4][layer]', 'style'=>'margin-left:-90px;width: 50px;','class'=>'form-control input-sm numberOnly','autocomplete'=>'off', 'value'=>''));											
					?>	
				</div>
				<label class='col-sm-2' style='text-align:left; margin-left: -130px; margin-top: 6px;'>Thickness</label>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'totthick_wr2','name'=>'ListDetail2[4][total_thickness]', 'style'=>'margin-left:-90px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly','value'=>'0'));											
					?>	
				</div>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'last_wr2','name'=>'ListDetail2[4][last_cost]', 'style'=>'margin-left:-80px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly','value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1 kghide' style='text-align:left; margin-left:-100px; margin-top: 6px;'>Kg</label>
			</div>
			<div class='form-group row'>		 	 
				<label class='label-control col-sm-2'><b></b></label>
				<div class='col-sm-3'>              
					<select name='id_material' id='mid_mtl_resin23' class='form-control input-sm' disabled>
						<option value=''>Select An Resin</option>
					<?php
						foreach($ListResin AS $val => $valx){
							echo "<option value='".$valx['id_material']."'>".strtoupper($valx['nm_material'])."</option>";
						}
						echo "<option value='MTL-1903000'>NONE MATERIAL</option>";
					 ?>
					</select>
					<input type='text' name='ListDetail2[5][id_ori]' class='HideCost' id='id_ori' value='TYP-0001'>
					<input type='text' name='ListDetail2[5][id_ori2]' class='HideCost' id='id_ori2' value='TYP-0001'>					
					<input type='text' name='ListDetail2[5][last_full]' class='HideCost' id='hasil_resin23' value='0'>
					<!--<input type='text' name='ListDetail2[5][containing]' class='HideCost' id='layer_resin23' value='1'>-->
					<input type='text' name='ListDetail2[5][id_material]' class='HideCost' id='layer_resin23hide'>
				</div>
				<label class='col-sm-2' style='text-align:left; margin-top: 6px;'><u>Rs.Containing</u></label>
				<div class='col-sm-1'>              
					
				</div>
				<label class='col-sm-1' style='text-align:left; margin-left:-130px; margin-top: 6px;'></label>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'layer_resin23','name'=>'ListDetail2[5][containing]', 'style'=>'margin-left:-90px;width: 50px;','class'=>'form-control input-sm numberOnly','autocomplete'=>'off', 'readonly'=>'readonly','value'=>'0'));		//1									
					?>
				</div>
				<label class='col-sm-2' style='text-align:left; margin-left: -130px; margin-top: 6px;'></label>
				<div class='col-sm-1'>              
					
				</div>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'last_resin23','name'=>'ListDetail2[5][last_cost]', 'style'=>'margin-left:-80px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1 kghide' style='text-align:left; margin-left:-100px; margin-top: 6px;'>Kg</label>
			</div>
			<div class='form-group row'>		 	 
				<label class='label-control col-sm-2' style='text-align:left;'><b>ADDITIONAL WR<span class='text-red'>*</span></b></label>
				<div class='col-sm-3'>              
					<select name='ListDetail2[6][id_material]' id='mid_mtl_wr_add2' class='form-control input-sm'>
						<option value=''>Select An WR Add</option>
					<?php
						foreach($ListMatWR AS $val => $valx){
							echo "<option value='".$valx['id_material']."'>".strtoupper($valx['nm_material'])."</option>";
						}
						echo "<option value='MTL-1903000'>NONE MATERIAL</option>";
					 ?>
					</select>
					<input type='text' name='ListDetail2[6][id_ori]' class='HideCost' id='id_ori' value='TYP-0006'>
					<input type='text' name='ListDetail2[6][id_ori2]' class='HideCost' id='id_ori2' value='TYP-0006'>
					<input type='text' name='ListDetail2[6][thickness]' class='HideCost' id='thickness_wr_add2' value='0'>
					<input type='text' name='ListDetail2[6][last_full]' class='HideCost' id='hasil_wr_add2' value='0'>	
				</div>
				<label class='col-sm-2' style='text-align:left; margin-top: 6px;'>Weight</label>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'weight_wr_add2','name'=>'ListDetail2[6][value]', 'style'=>'margin-left:-110px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1' style='text-align:left; margin-left:-130px; margin-top: 6px;'>Layer</label>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'layer_wr_add2','name'=>'ListDetail2[6][layer]', 'style'=>'margin-left:-90px;width: 50px;','class'=>'form-control input-sm numberOnly','autocomplete'=>'off', 'value'=>''));											
					?>	
				</div>
				<label class='col-sm-2' style='text-align:left; margin-left: -130px; margin-top: 6px;'>Thickness</label>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'totthick_wr_add2','name'=>'ListDetail2[6][total_thickness]', 'style'=>'margin-left:-90px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'last_wr_add2','name'=>'ListDetail2[6][last_cost]', 'style'=>'margin-left:-80px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1 kghide' style='text-align:left; margin-left:-100px; margin-top: 6px;'>Kg</label>
			</div>
			<div class='form-group row'>		 	 
				<label class='label-control col-sm-2'><b></b></label>
				<div class='col-sm-3'>              
					<select name='id_material' id='mid_mtl_resin24' class='form-control input-sm' disabled>
						<option value=''>Select An Resin</option>
					<?php
						foreach($ListResin AS $val => $valx){
							echo "<option value='".$valx['id_material']."'>".strtoupper($valx['nm_material'])."</option>";
						}
						echo "<option value='MTL-1903000'>NONE MATERIAL</option>";
					 ?>
					</select>
					<input type='text' name='ListDetail2[7][id_ori]' class='HideCost' id='id_ori' value='TYP-0001'>
					<input type='text' name='ListDetail2[7][id_ori2]' class='HideCost' id='id_ori2' value='TYP-0001'>						
					<input type='text' name='ListDetail2[7][last_full]' class='HideCost' id='hasil_resin24' value='0'>
					<!--<input type='text' name='ListDetail2[7][containing]' class='HideCost' id='layer_resin24' value='1'>-->
					<input type='text' name='ListDetail2[7][id_material]' class='HideCost' id='layer_resin24hide'>
				</div>
				<label class='col-sm-2' style='text-align:left; margin-top: 6px;'><u>Rs.Containing</u></label>
				<div class='col-sm-1'>              
					
				</div>
				<label class='col-sm-1' style='text-align:left; margin-left:-130px; margin-top: 6px;'></label>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'layer_resin24','name'=>'ListDetail2[7][containing]', 'style'=>'margin-left:-90px;width: 50px;','class'=>'form-control input-sm numberOnly','autocomplete'=>'off', 'readonly'=>'readonly', 'value'=>'0'));		//1									
					?>
				</div>
				<label class='col-sm-2' style='text-align:left; margin-left: -130px; margin-top: 6px;'></label>
				<div class='col-sm-1'>              
					
				</div>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'last_resin24','name'=>'ListDetail2[7][last_cost]', 'style'=>'margin-left:-80px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1 kghide' style='text-align:left; margin-left:-100px; margin-top: 6px;'>Kg</label>
			</div>
			
			<div class='form-group row'>		 	 
				<label class='label-control col-sm-2' style='text-align:left;'><b>ROOVING<span class='text-red'>*</span></b></label>
				<div class='col-sm-3'>              
					<select name='ListDetail2[8][id_material]' id='mid_mtl_rooving21' class='form-control input-sm'>
						<option value=''>Select An Rooving</option>
					<?php
						foreach($ListMatRooving AS $val => $valx){
							echo "<option value='".$valx['id_material']."'>".strtoupper($valx['nm_material'])."</option>";
						}
						echo "<option value='MTL-1903000'>NONE MATERIAL</option>";
					 ?>
					</select>
					<input type='text' name='ListDetail2[8][id_ori]' class='HideCost' id='id_ori' value='TYP-0005'>
					<input type='text' name='ListDetail2[8][id_ori2]' class='HideCost' id='id_ori2' value='TYP-0005'>		
					<input type='text' name='ListDetail2[8][thickness]' class='HideCost' id='thickness_rooving21' value='0'>
					<input type='text' name='ListDetail2[8][last_full]' class='HideCost' id='hasil_rooving21' value='0'>
					<input type='text' name='ListDetail2[8][fak_pengali]' class='HideCost' id='penggali_rooving21' value='100'>
					<input type='text' name='ListDetail2[8][bw]' class='HideCost' id='bw_rooving21' value='0'>	
					<input type='text' name='ListDetail2[8][jumlah]' class='HideCost' id='jumlah_rooving21' value='0'>	
				</div>
				<label class='col-sm-2' style='text-align:left; margin-top: 6px;'>Weight</label>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'weight_rooving21','name'=>'ListDetail2[8][value]', 'style'=>'margin-left:-110px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1' style='text-align:left; margin-left:-130px; margin-top: 6px;'>Layer</label>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'layer_rooving21','name'=>'ListDetail2[8][layer]', 'style'=>'margin-left:-90px;width: 50px;','class'=>'form-control input-sm numberOnly','autocomplete'=>'off', 'value'=>''));											
					?>	
				</div>
				<label class='col-sm-2' style='text-align:left; margin-left: -130px; margin-top: 6px;'>Thickness</label>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'totthick_rooving21','name'=>'ListDetail2[8][total_thickness]', 'style'=>'margin-left:-90px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'last_rooving21','name'=>'ListDetail2[8][last_cost]', 'style'=>'margin-left:-80px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1 kghide' style='text-align:left; margin-left:-100px; margin-top: 6px;'>Kg</label>
			</div>
			<div class='form-group row'>		 	 
				<label class='label-control col-sm-2'><b></b></label>
				<div class='col-sm-3'>              
					<select name='id_material' id='mid_mtl_resin25' class='form-control input-sm' disabled>
						<option value=''>Select An Resin</option>
					<?php
						foreach($ListResin AS $val => $valx){
							echo "<option value='".$valx['id_material']."'>".strtoupper($valx['nm_material'])."</option>";
						}
						echo "<option value='MTL-1903000'>NONE MATERIAL</option>";
					 ?>
					</select>
					<input type='text' name='ListDetail2[9][id_ori]' class='HideCost' id='id_ori' value='TYP-0001'>
					<input type='text' name='ListDetail2[9][id_ori2]' class='HideCost' id='id_ori2' value='TYP-0001'>					
					<input type='text' name='ListDetail2[9][last_full]' class='HideCost' id='hasil_resin25' value='0'>
					<!--<input type='text' name='ListDetail2[9][containing]' class='HideCost' id='layer_resin25' value='0.429'>-->
					<input type='text' name='ListDetail2[9][id_material]' class='HideCost' id='layer_resin25hide'>
				</div>
				<label class='col-sm-2' style='text-align:left; margin-top: 6px;'><u>Rs.Containing</u></label>
				<div class='col-sm-1'>              
					
				</div>
				<label class='col-sm-1' style='text-align:left; margin-left:-130px; margin-top: 6px;'></label>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'layer_resin25','name'=>'ListDetail2[9][containing]', 'style'=>'margin-left:-90px;width: 50px;','class'=>'form-control input-sm numberOnly','autocomplete'=>'off', 'readonly'=>'readonly', 'value'=>'0'));											
					?>
				</div>
				<label class='col-sm-2' style='text-align:left; margin-left: -130px; margin-top: 6px;'></label>
				<div class='col-sm-1'>              
					
				</div>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'last_resin25','name'=>'ListDetail2[9][last_cost]', 'style'=>'margin-left:-80px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1 kghide' style='text-align:left; margin-left:-100px; margin-top: 6px;'>Kg</label>
			</div>
			<div class='form-group row'>		 	 
				<label class='label-control col-sm-2' style='text-align:left;'><b>ADDITIONAL ROOVING<span class='text-red'>*</span></b></label>
				<div class='col-sm-3'>              
					<select name='ListDetail2[10][id_material]' id='mid_mtl_rooving22' class='form-control input-sm'>
						<option value=''>Select An Rooving</option>
					<?php
						foreach($ListMatRooving AS $val => $valx){
							echo "<option value='".$valx['id_material']."'>".strtoupper($valx['nm_material'])."</option>";
						}
						echo "<option value='MTL-1903000'>NONE MATERIAL</option>";
					 ?>
					</select>
					<input type='text' name='ListDetail2[10][id_ori]' class='HideCost' id='id_ori' value='TYP-0005'>
					<input type='text' name='ListDetail2[10][id_ori2]' class='HideCost' id='id_ori2' value='TYP-0005'>
					<input type='text' name='ListDetail2[10][thickness]' class='HideCost' id='thickness_rooving22' value='0'>
					<input type='text' name='ListDetail2[10][last_full]' class='HideCost' id='hasil_rooving22' value='0'>
					<input type='text' name='ListDetail2[10][fak_pengali]' class='HideCost' id='penggali_rooving22' value='100'>
					<input type='text' name='ListDetail2[10][bw]' class='HideCost' id='bw_rooving22' value='0'>	
					<input type='text' name='ListDetail2[10][jumlah]' class='HideCost' id='jumlah_rooving22' value='0'>	
				</div>
				<label class='col-sm-2' style='text-align:left; margin-top: 6px;'>Weight</label>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'weight_rooving22','name'=>'ListDetail2[10][value]', 'style'=>'margin-left:-110px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1' style='text-align:left; margin-left:-130px; margin-top: 6px;'>Layer</label>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'layer_rooving22','name'=>'ListDetail2[10][layer]', 'style'=>'margin-left:-90px;width: 50px;','class'=>'form-control input-sm numberOnly','autocomplete'=>'off', 'value'=>''));											
					?>	
				</div>
				<label class='col-sm-2' style='text-align:left; margin-left: -130px; margin-top: 6px;'>Thickness</label>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'totthick_rooving22','name'=>'ListDetail2[10][total_thickness]', 'style'=>'margin-left:-90px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'last_rooving22','name'=>'ListDetail2[10][last_cost]', 'style'=>'margin-left:-80px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1 kghide' style='text-align:left; margin-left:-100px; margin-top: 6px;'>Kg</label>
			</div>
			<div class='form-group row'>		 	 
				<label class='label-control col-sm-2'><b></b></label>
				<div class='col-sm-3'>              
					<select name='id_material' id='mid_mtl_resin26' class='form-control input-sm' disabled>
						<option value=''>Select An Resin</option>
					<?php
						foreach($ListResin AS $val => $valx){
							echo "<option value='".$valx['id_material']."'>".strtoupper($valx['nm_material'])."</option>";
						}
						echo "<option value='MTL-1903000'>NONE MATERIAL</option>";
					 ?>
					</select>
					<input type='text' name='ListDetail2[11][id_ori]' class='HideCost' id='id_ori' value='TYP-0001'>
					<input type='text' name='ListDetail2[11][id_ori2]' class='HideCost' id='id_ori2' value='TYP-0001'>
					<input type='text' name='ListDetail2[11][last_full]' class='HideCost' id='hasil_resin26' value='0'>
					<!--<input type='text' name='ListDetail2[11][containing]' class='HideCost' id='layer_resin26' value='0.429'>-->
					<input type='text' name='ListDetail2[11][id_material]' class='HideCost' id='layer_resin26hide'>
				</div>
				<label class='col-sm-2' style='text-align:left; margin-top: 6px;'><u>Rs.Containing</u></label>
				<div class='col-sm-1'>              
					
				</div>
				<label class='col-sm-1' style='text-align:left; margin-left:-130px; margin-top: 6px;'></label>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'layer_resin26','name'=>'ListDetail2[11][containing]', 'style'=>'margin-left:-90px;width: 50px;','class'=>'form-control input-sm numberOnly','autocomplete'=>'off', 'readonly'=>'readonly', 'value'=>'0'));											
					?>
				</div>
				<label class='col-sm-2' style='text-align:left; margin-left: -130px; margin-top: 6px;'></label>
				<div class='col-sm-1'>              
					
				</div>
				<div class='col-sm-1'>               
					<?php
						echo form_input(array('id'=>'last_resin26','name'=>'ListDetail2[11][last_cost]', 'style'=>'margin-left:-80px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1 kghide' style='text-align:left; margin-left:-100px; margin-top: 6px;'>Kg</label>
			</div>
			<div class='form-group row'>		 	 
				<label class='label-control col-sm-2'><b>TOTAL RESIN<span class='text-red'>*</span></b></label>
				<div class='col-sm-3'>              
					<select name='ListDetail2[12][id_material]' id='mid_mtl_resin_tot2' class='form-control input-sm'>
					<option value=''>Select An Resin</option>
					<?php
						foreach($ListResin AS $val => $valx){
							echo "<option value='".$valx['id_material']."'>".strtoupper($valx['nm_material'])."</option>";
						}
						echo "<option value='MTL-1903000'>NONE MATERIAL</option>";
					 ?>
					</select>
					<input type='text' name='ListDetail2[12][id_ori]' class='HideCost' id='id_ori' value='TYP-0001'>
					<input type='text' name='ListDetail2[12][id_ori2]' class='HideCost' id='id_ori2' value='TYP-0001'>
					<input type='text' name='ListDetail2[12][last_full]' class='HideCost' id='hasil_resin_tot2' value='0'>
					<!--<input type='text' name='ListDetail2[12][id_material]' class='HideCost' id='layer_resin27hide'>-->
				</div>
				<label class='col-sm-2' style='text-align:left; margin-top: 6px;'></label>
				<div class='col-sm-1'>              
					
				</div>
				<label class='col-sm-1' style='text-align:left; margin-left:-130px; margin-top: 6px;'></label>
				<div class='col-sm-1'>              
					
				</div>
				<label class='col-sm-2' style='text-align:left; margin-left: -130px; margin-top: 6px;'></label>
				<div class='col-sm-1'>              
					
				</div>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'last_resin_tot2','name'=>'ListDetail2[12][last_cost]', 'style'=>'margin-left:-80px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1 kghide' style='text-align:left; margin-left:-100px; margin-top: 6px;'>Kg</label>
			</div>
			<div class='form-group row'>
				<label class='col-sm-2' style='text-align:left; margin-top: 6px;'></label>
				
				<label class='label-control col-sm-1'><b>Katalis<span class='text-red'>*</span></b></label>
				<div class='col-sm-3'>              
					<select name='ListDetailPlus2[0][id_material]' id='mid_mtl_katalis2' class='form-control input-sm'>
						<option value=''>Select An Katalis</option>
					<?php
						foreach($ListMatKatalis AS $val => $valx){
							echo "<option value='".$valx['id_material']."'>".strtoupper($valx['nm_material'])."</option>";
						}
						echo "<option value='MTL-1903000'>NONE MATERIAL</option>";
					 ?>
					</select>
					<input type='text' name='ListDetailPlus2[0][id_ori]' class='HideCost' id='id_ori' value='TYP-0002'>
					<input type='text' name='ListDetailPlus2[0][id_ori2]' class='HideCost' id='id_ori2' value='TYP-0002'>
					<input type='text' name='ListDetailPlus2[0][last_full]' class='HideCost' id='hasil_katalis2' value='0'>
					<!--
					<input type='text' name='ListDetailPlus2[0][containing]' class='HideCost' id='layer_katalis2' value='0'>
					<input type='text' name='ListDetailPlus2[0][perse]' class='HideCost' id='persen_katalis2' value='0.025'>
					--> 
				</div>
				
				<label class='col-sm-1' style='text-align:left; margin-left: 0px; margin-top: 6px;'>Comparison</label>
				<div class='col-sm-2'>              
					<input type='text' name='ListDetailPlus2[0][containing]' style='width:50px; margin-left:12px;' class='form-control input-sm numberOnly' readonly='readonly' id='layer_katalis2' value='0'>	
				</div>
				<label class='col-sm-2' style='text-align:left; margin-left: -129px; margin-top: 6px;'>Percent</label>
				<div class='col-sm-1'>              
					<input type='text' name='ListDetailPlus2[0][perse]' style='margin-left:-92px;' class='form-control input-sm numberOnly' id='persen_katalis2' value='2'>	
				</div>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'last_katalis2','name'=>'ListDetailPlus2[0][last_cost]', 'style'=>'margin-left:-81px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1 kghide' style='text-align:left; margin-left:-101px; margin-top: 6px;'>Kg</label>
			</div>
			<div class='form-group row'>
				<label class='col-sm-2' style='text-align:left; margin-top: 6px;'></label>
				
				<label class='label-control col-sm-1'><b>SM<span class='text-red'>*</span></b></label>
				<div class='col-sm-3'>              
					<select name='ListDetailPlus2[1][id_material]' id='mid_mtl_sm2' class='form-control input-sm'>
						<option value=''>Select An SM</option>
					<?php
						foreach($ListMatSm AS $val => $valx){
							echo "<option value='".$valx['id_material']."'>".strtoupper($valx['nm_material'])."</option>";
						}
						echo "<option value='MTL-1903000'>NONE MATERIAL</option>";
					 ?>
					</select>
					<input type='text' name='ListDetailPlus2[1][id_ori]' class='HideCost' id='id_ori' value='TYP-0024'>
					<input type='text' name='ListDetailPlus2[1][id_ori2]' class='HideCost' id='id_ori2' value='TYP-0024'>
					<input type='text' name='ListDetailPlus2[1][last_full]' class='HideCost' id='hasil_sm2' value='0'>
					<!--
					<input type='text' name='ListDetailPlus2[1][containing]' class='HideCost' id='layer_sm2' value='0'>
					<input type='text' name='ListDetailPlus2[1][perse]' class='HideCost' id='persen_sm2' value='0.025'>
					-->					
				</div>
				
				<label class='col-sm-1' style='text-align:left; margin-left: 0px; margin-top: 6px;'>Comparison</label>
				<div class='col-sm-2'>              
					<input type='text' name='ListDetailPlus2[1][containing]' style='width:50px; margin-left:12px;' class='form-control input-sm numberOnly' readonly='readonly' id='layer_sm2' value='0'>	
				</div>
				<label class='col-sm-2' style='text-align:left; margin-left: -129px; margin-top: 6px;'>Percent</label>
				<div class='col-sm-1'>              
					<input type='text' name='ListDetailPlus2[1][perse]' style='margin-left:-92px;' class='form-control input-sm numberOnly' id='persen_sm2' value='2.5'>	
				</div>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'last_sm2','name'=>'ListDetailPlus2[1][last_cost]', 'style'=>'margin-left:-81px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1 kghide' style='text-align:left; margin-left:-101px; margin-top: 6px;'>Kg</label>
			</div>
			<div class='form-group row'>
				<label class='col-sm-2' style='text-align:left; margin-top: 6px;'></label>
				
				<label class='label-control col-sm-1'><b>Cobalt<span class='text-red'>*</span></b></label>
				<div class='col-sm-3'>              
					<select name='ListDetailPlus2[2][id_material]' id='mid_mtl_cobalt2' class='form-control input-sm'>
						<option value=''>Select An Cobalt</option>
					<?php
						foreach($ListMatCobalt AS $val => $valx){
							echo "<option value='".$valx['id_material']."'>".strtoupper($valx['nm_material'])."</option>";
						}
						echo "<option value='MTL-1903000'>NONE MATERIAL</option>";
					 ?>
					</select>
					<input type='text' name='ListDetailPlus2[2][id_ori]' class='HideCost' id='id_ori' value='TYP-0021'>
					<input type='text' name='ListDetailPlus2[2][id_ori2]' class='HideCost' id='id_ori2' value='TYP-0021'>
					<input type='text' name='ListDetailPlus2[2][last_full]' class='HideCost' id='hasil_coblat2' value='0'>
					<!--
					<input type='text' name='ListDetailPlus2[2][containing]' class='HideCost' id='layer_coblat2' value='0'>
					<input type='text' name='ListDetailPlus2[2][perse]' class='HideCost' id='persen_coblat2' value='0.002'>
					-->
				</div>
				
				<label class='col-sm-1' style='text-align:left; margin-left: 0px; margin-top: 6px;'>Comparison</label>
				<div class='col-sm-2'>              
					<input type='text' name='ListDetailPlus2[2][containing]' style='width:50px; margin-left:12px;' class='form-control input-sm numberOnly' readonly='readonly' id='layer_coblat2' value='0'>	
				</div>
				<label class='col-sm-2' style='text-align:left; margin-left: -129px; margin-top: 6px;'>Percent</label>
				<div class='col-sm-1'>              
					<input type='text' name='ListDetailPlus2[2][perse]' style='margin-left:-92px;' class='form-control input-sm numberOnly' id='persen_coblat2' value='0.2'>	
				</div>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'last_cobalt2','name'=>'ListDetailPlus2[2][last_cost]', 'style'=>'margin-left:-81px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1 kghide' style='text-align:left; margin-left:-101px; margin-top: 6px;'>Kg</label>
			</div>
			<div class='form-group row'>
				<label class='col-sm-2' style='text-align:left; margin-top: 6px;'></label>
				
				<label class='label-control col-sm-1'><b>DMA<span class='text-red'>*</span></b></label>
				<div class='col-sm-3'>              
					<select name='ListDetailPlus2[3][id_material]' id='mid_mtl_dma2' class='form-control input-sm'>
						<option value=''>Select An DMA</option>
					<?php
						foreach($ListMatDma AS $val => $valx){
							echo "<option value='".$valx['id_material']."'>".strtoupper($valx['nm_material'])."</option>";
						}
						echo "<option value='MTL-1903000'>NONE MATERIAL</option>";
					 ?>
					</select>
					<input type='text' name='ListDetailPlus2[3][id_ori]' class='HideCost' id='id_ori' value='TYP-0021'>
					<input type='text' name='ListDetailPlus2[3][id_ori2]' class='HideCost' id='id_ori2' value='TYP-0021'>
					<input type='text' name='ListDetailPlus2[3][last_full]' class='HideCost' id='hasil_dma2' value='0'>
					<!--
					<input type='text' name='ListDetailPlus2[3][containing]' class='HideCost' id='layer_dma2' value='0'>
					<input type='text' name='ListDetailPlus2[3][perse]' class='HideCost' id='persen_dma2' value='0.002'>
					-->					
				</div>
				
				<label class='col-sm-1' style='text-align:left; margin-left: 0px; margin-top: 6px;'>Comparison</label>
				<div class='col-sm-2'>              
					<input type='text' name='ListDetailPlus2[3][containing]' style='width:50px; margin-left:12px;' class='form-control input-sm numberOnly' readonly='readonly' id='layer_dma2' value='0'>	
				</div>
				<label class='col-sm-2' style='text-align:left; margin-left: -129px; margin-top: 6px;'>Percent</label>
				<div class='col-sm-1'>              
					<input type='text' name='ListDetailPlus2[3][perse]' style='margin-left:-92px;' class='form-control input-sm numberOnly' id='persen_dma2' value='0.2'>	
				</div>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'last_dma2','name'=>'ListDetailPlus2[3][last_cost]', 'style'=>'margin-left:-81px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1 kghide' style='text-align:left; margin-left:-101px; margin-top: 6px;'>Kg</label>
			</div>
			<div class='form-group row'>
				<label class='col-sm-2' style='text-align:left; margin-top: 6px;'></label>
				
				<label class='label-control col-sm-1'><b>Hydroquinone<span class='text-red'>*</span></b></label>
				<div class='col-sm-3'>              
					<select name='ListDetailPlus2[4][id_material]' id='mid_mtl_hydro2' class='form-control input-sm'>
						<option value=''>Select An Hydroquinone</option>
					<?php
						foreach($ListMatHydo AS $val => $valx){
							echo "<option value='".$valx['id_material']."'>".strtoupper($valx['nm_material'])."</option>";
						}
						echo "<option value='MTL-1903000'>NONE MATERIAL</option>";
					 ?>
					</select>
					<input type='text' name='ListDetailPlus2[4][id_ori]' class='HideCost' id='id_ori' value='TYP-0026'>
					<input type='text' name='ListDetailPlus2[4][id_ori2]' class='HideCost' id='id_ori2' value='TYP-0026'>
					<input type='text' name='ListDetailPlus2[4][last_full]' class='HideCost' id='hasil_hydroquinone2' value='0'>
					<!--
					<input type='text' name='ListDetailPlus2[4][containing]' class='HideCost' id='layer_hydroquinone2' value='0'>
					<input type='text' name='ListDetailPlus2[4][perse]' class='HideCost' id='persen_hydroquinone2' value='0.002'>
					-->
				</div>
				
				<label class='col-sm-1' style='text-align:left; margin-left: 0px; margin-top: 6px;'>Comparison</label>
				<div class='col-sm-2'>              
					<input type='text' name='ListDetailPlus2[4][containing]' style='width:50px; margin-left:12px;' class='form-control input-sm numberOnly' readonly='readonly' id='layer_hydroquinone2' value='0'>	
				</div>
				<label class='col-sm-2' style='text-align:left; margin-left: -129px; margin-top: 6px;'>Percent</label>
				<div class='col-sm-1'>              
					<input type='text' name='ListDetailPlus2[4][perse]' style='margin-left:-92px;' class='form-control input-sm numberOnly' id='persen_hydroquinone2' value='0.2'>	
				</div>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'last_hidro2','name'=>'ListDetailPlus2[4][last_cost]', 'style'=>'margin-left:-81px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1 kghide' style='text-align:left; margin-left:-101px; margin-top: 6px;'>Kg</label>
			</div>
			<div class='form-group row'>
				<label class='col-sm-2' style='text-align:left; margin-top: 6px;'></label>
				
				<label class='label-control col-sm-1'><b>Methanol<span class='text-red'>*</span></b></label>
				<div class='col-sm-3'>              
					<select name='ListDetailPlus2[5][id_material]' id='mid_mtl_methanol2' class='form-control input-sm'>
						<option value=''>Select An Methanol</option>
					<?php
						foreach($ListMatMethanol AS $val => $valx){
							echo "<option value='".$valx['id_material']."'>".strtoupper($valx['nm_material'])."</option>";
						}
						echo "<option value='MTL-1903000'>NONE MATERIAL</option>";
					 ?>
					</select>
					<input type='text' name='ListDetailPlus2[5][id_ori]' class='HideCost' id='id_ori' value='TYP-0026'>
					<input type='text' name='ListDetailPlus2[5][id_ori2]' class='HideCost' id='id_ori2' value='TYP-0026'>
					<input type='text' name='ListDetailPlus2[5][last_full]' class='HideCost' id='hasil_methanol2' value='0'>
					<!--
					<input type='text' name='ListDetailPlus2[5][containing]' class='HideCost' id='layer_methanol2' value='0'>
					<input type='text' name='ListDetailPlus2[5][perse]' class='HideCost' id='persen_methanol2' value='0.002'>
					-->
				</div>
				
				<label class='col-sm-1' style='text-align:left; margin-left: 0px; margin-top: 6px;'>Comparison</label>
				<div class='col-sm-2'>              
					<input type='text' name='ListDetailPlus2[5][containing]' style='width:50px; margin-left:12px;' class='form-control input-sm numberOnly' readonly='readonly' id='layer_methanol2' value='0'>	
				</div>
				<label class='col-sm-2' style='text-align:left; margin-left: -129px; margin-top: 6px;'>Percent</label>
				<div class='col-sm-1'>              
					<input type='text' name='ListDetailPlus2[5][perse]' style='margin-left:-92px;' class='form-control input-sm numberOnly' id='persen_methanol2' value='0.2'>	
				</div>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'last_methanol2','name'=>'ListDetailPlus2[5][last_cost]', 'style'=>'margin-left:-81px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1 kghide' style='text-align:left; margin-left:-101px; margin-top: 6px;'>Kg</label>
			</div>
			<!-- Add Material-->
			<button type='button' name='add_strukture' id='add_strukture' class='btn btn-success btn-sm' style='width:150px; margin-left: 10px;'>Add Material</button>
			<input type='hidden' name='numberMax_strukture' id='numberMax_strukture' value='0'>
			
			<div class="box-body" style="">
				<table id="my-grid_strukture" class="table table-striped table-bordered table-hover table-condensed" width="100%">
					<tbody id='detail_body_strukture'>
					</tbody>
				</table>
			</div>
			<!-- END -->
			<div class='form-group row'>		 	 
				<label class='label-control col-sm-2' style='text-align:right;'></label>
				<div class='col-sm-2'>              
					
				</div>
				<label class='col-sm-2' style='text-align:left; margin-top: 6px;'></label>
				<div class='col-sm-1'>              
					
				</div>
				<label class='col-sm-1' style='text-align:left; margin-left:-100px; margin-top: 6px;'></label>
				<div class='col-sm-1'>              
					
				</div>
				<label class='col-sm-2' style='text-align:left; margin-left: -50px; margin-top: 6px;'>Total Strukture Thickness</label>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'tot_lin_thickness2','name'=>'tot_lin_thickness2', 'style'=>'margin-left:-50px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<div class='col-sm-1'>              
					
				</div>
				<label class='col-sm-1' style='text-align:left; margin-left:-100px; margin-top: 6px;'></label>
			</div>
			<div class='form-group row'>		 	 
				<label class='label-control col-sm-2' style='text-align:right;'></label>
				<div class='col-sm-2'>              
					
				</div>
				<label class='col-sm-2' style='text-align:left; margin-top: 6px;'></label>
				<div class='col-sm-1'>              
					
				</div>
				<label class='col-sm-1' style='text-align:left; margin-left:-100px; margin-top: 6px;'></label>
				<div class='col-sm-1'>              
					
				</div>
				<label class='col-sm-2' style='text-align:left; margin-left: -50px; margin-top: 6px;'>Min Strukture Thickness</label>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'mix_lin_thickness2','name'=>'mix_lin_thickness2', 'style'=>'margin-left:-50px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<div class='col-sm-1'>              
					
				</div>
				<label class='col-sm-1' style='text-align:left; margin-left:-100px; margin-top: 6px;'></label>
			</div>
			<div class='form-group row'>		 	 
				<label class='label-control col-sm-2' style='text-align:right;'></label>
				<div class='col-sm-2'>              
					
				</div>
				<label class='col-sm-2' style='text-align:left; margin-top: 6px;'></label>
				<div class='col-sm-1'>              
					
				</div>
				<label class='col-sm-1' style='text-align:left; margin-left:-100px; margin-top: 6px;'></label>
				<div class='col-sm-1'>              
					
				</div>
				<label class='col-sm-2' style='text-align:left; margin-left: -50px; margin-top: 6px;'>Max Strukture Thickness</label>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'max_lin_thickness2','name'=>'max_lin_thickness2', 'style'=>'margin-left:-50px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<div class='col-sm-1'>              
					
				</div>
				<label class='col-sm-1' style='text-align:left; margin-left:-100px; margin-top: 6px;'></label>
			</div>
			<div class='form-group row'>		 	 
				<label class='label-control col-sm-2' style='text-align:right;'></label>
				<div class='col-sm-2'>              
					
				</div>
				<label class='col-sm-2' style='text-align:left; margin-top: 6px;'></label>
				<div class='col-sm-1'>              
					
				</div>
				<label class='col-sm-1' style='text-align:left; margin-left:-100px; margin-top: 6px;'></label>
				<div class='col-sm-1'>              
					
				</div>
				<label class='col-sm-2' style='text-align:left; margin-left: -50px; margin-top: 6px;'></label>
				<div class='col-sm-2'>              
					<?php
						echo form_input(array('id'=>'hasil_linier_thickness2','name'=>'hasil_linier_thickness2', 'style'=>'margin-left:-50px; height: 40px;','class'=>'form-control input-sm HasilKet','autocomplete'=>'off','readonly'=>'readonly'));											
					?>	
				</div>
				
				<label class='col-sm-1' style='text-align:left; margin-left:-100px; margin-top: 6px;'></label>
			</div>
			
			<!-- ====================================================================================================== -->
			<!-- ============================================END STRUKTUR THICKNESS==================================== -->
			<!-- ====================================================================================================== -->
			
			
			<div class='headerTitle'>TIMING</div>
			<div style="text-align:center;">
			<table id="my-grid" style='width:70% !important;' class="table table-bordered table-striped">
				<tbody>
					<tr>
						<td width='20%' class="text-left"><b>Preparation</b></td>
						<td width='20%' class="text-left">
							Time Preparation
							<input type='text' name='ListTime[1][man_hours]' class='Hide man_hours'>
						</td>
						<td width='20%' class="text-left">
							<input type='text' name='ListTime[1][time_process]' class='form-control input-sm numberOnly time_process' placeholder='per Minutes'>
						</td>
						<td width='20%' class="text-left">
							Jumlah MP
							<input type='text' name='ListTime[1][process]' value='preparation' class='Hide'>
							<input type='text' name='ListTime[1][sub_process]' value='time preparation' class='Hide'>
						</td>
						<td width='20%' class="text-left"><input type='text' name='ListTime[1][man_power]' class='form-control input-sm numberOnly man_power'></td>
					</tr>
					<tr>
						<td class="text-left"><b>Liner</b></td>
						<td class="text-left">HLU<input type='text' name='ListTime[2][man_hours]' class='Hide man_hours'></td>
						<td class="text-left">
							<input type='text' name='ListTime[2][time_process]' class='form-control input-sm numberOnly time_process' placeholder='per Minutes'>
						</td>
						<td class="text-left">
							Jumlah MP
							<input type='text' name='ListTime[2][process]' value='liner' class='Hide'>
							<input type='text' name='ListTime[2][sub_process]' value='hlu' class='Hide'>
						</td>
						<td class="text-left"><input type='text' name='ListTime[2][man_power]' class='form-control input-sm numberOnly man_power'></td>
					</tr>
					<tr>
						<td class="text-left"></td>
						<td class="text-left">Curing<input type='text' name='ListTime[3][man_hours]' class='Hide man_hoursx'></td>
						<td class="text-left">
							<input type='text' name='ListTime[3][time_process]' class='form-control input-sm numberOnly time_processx' placeholder='per Minutes'>
						</td>
						<td class="text-left">
							<input type='text' name='ListTime[3][process]' value='liner' class='Hide'>
							<input type='text' name='ListTime[3][sub_process]' value='curing' class='Hide'>
						</td>
						<td class="text-left"></td>
					</tr>
					<tr>
						<td class="text-left"><b>Strukture</b></td>
						<td class="text-left">HLU<input type='text' name='ListTime[4][man_hours]' class='Hide man_hours'></td>
						<td class="text-left">
							<input type='text' name='ListTime[4][time_process]' class='form-control input-sm numberOnly time_process' placeholder='per Minutes'>	
						</td>
						<td class="text-left">
							Jumlah MP
							<input type='text' name='ListTime[4][process]' value='strukture' class='Hide'>
							<input type='text' name='ListTime[4][sub_process]' value='hlu' class='Hide'>
						</td>
						<td class="text-left"><input type='text' name='ListTime[4][man_power]' class='form-control input-sm numberOnly man_power'></td>
					</tr>
					<tr>
						<td class="text-left"></td>
						<td class="text-left">Curing<input type='text' name='ListTime[5][man_hours]' class='Hide man_hoursx'></td>
						<td class="text-left">
							<input type='text' name='ListTime[5][time_process]' class='form-control input-sm numberOnly time_processx' placeholder='per Minutes'>
						</td>
						<td class="text-left">
							<input type='text' name='ListTime[5][process]' value='strukture' class='Hide'>
							<input type='text' name='ListTime[5][sub_process]' value='curing' class='Hide'>
						</td>
						<td class="text-left"></td>
					</tr>
					<tr>
						<td class="text-left"><b>External</b></td>
						<td class="text-left">HLU<input type='text' name='ListTime[6][man_hours]' class='Hide man_hours'></td>
						<td class="text-left">
							<input type='text' name='ListTime[6][time_process]' class='form-control input-sm numberOnly time_process' placeholder='per Minutes'>
						</td>
						<td class="text-left">
							Jumlah MP
							<input type='text' name='ListTime[6][process]' value='external' class='Hide'>
							<input type='text' name='ListTime[6][sub_process]' value='hlu' class='Hide'>
						</td>
						<td class="text-left"><input type='text' name='ListTime[6][man_power]' class='form-control input-sm numberOnly man_power'></td>
					</tr>
					<tr>
						<td class="text-left"></td>
						<td class="text-left">Curing<input type='text' name='ListTime[7][man_hours]' class='Hide man_hoursx'></td>
						<td class="text-left">
							<input type='text' name='ListTime[7][time_process]' class='form-control input-sm numberOnly time_processx' placeholder='per Minutes'>
						</td>
						<td class="text-left">
							<input type='text' name='ListTime[7][process]' value='external' class='Hide'>
							<input type='text' name='ListTime[7][sub_process]' value='curing' class='Hide'>
						</td>
						<td class="text-left"></td>
					</tr>
					<tr>
						<td class="text-left"><b>Top Coat</b></td>
						<td class="text-left">HLU<input type='text' name='ListTime[8][man_hours]' class='Hide man_hours'></td>
						<td class="text-left">
							<input type='text' name='ListTime[8][time_process]' class='form-control input-sm numberOnly time_process' placeholder='per Minutes'>
						</td>
						<td class="text-left">
							Jumlah MP
							<input type='text' name='ListTime[8][process]' value='top coat' class='Hide'>
							<input type='text' name='ListTime[8][sub_process]' value='hlu' class='Hide'>
						</td>
						<td class="text-left"><input type='text' name='ListTime[8][man_power]' class='form-control input-sm numberOnly man_power'></td>
					</tr>
					<tr>
						<td class="text-left"></td>
						<td class="text-left">Curing<input type='text' name='ListTime[9][man_hours]' class='Hide man_hoursx'></td>
						<td class="text-left">
							<input type='text' name='ListTime[9][time_process]' class='form-control input-sm numberOnly time_processx' placeholder='per Minutes'>
						</td>
						<td class="text-left">
							<input type='text' name='ListTime[9][process]' value='top coat' class='Hide'>
							<input type='text' name='ListTime[9][sub_process]' value='curing' class='Hide'>
						</td>
						<td class="text-left"></td>
					</tr>
					<tr>
						<td width='20%' class="text-left"><b>Demolding</b></td>
						<td width='20%' class="text-left">FW<input type='text' name='ListTime[10][man_hours]' class='Hide man_hours'></td>
						<td width='20%' class="text-left">
							<input type='text' name='ListTime[10][time_process]' class='form-control input-sm numberOnly time_process' placeholder='per Minutes'>
						</td>
						<td width='20%' class="text-left">
							Jumlah MP
							<input type='text' name='ListTime[10][process]' value='demolding' class='Hide'>
							<input type='text' name='ListTime[10][sub_process]' value='fw' class='Hide'>
						</td>
						<td width='20%' class="text-left"><input type='text' name='ListTime[10][man_power]' class='form-control input-sm numberOnly man_power'></td>
					</tr>
					<tr>
						<td width='20%' class="text-left"><b>Cutting and Finising</b></td>
						<td width='20%' class="text-left">FW<input type='text' name='ListTime[11][man_hours]' class='Hide man_hours'></td>
						<td width='20%' class="text-left">
							<input type='text' name='ListTime[11][time_process]' class='form-control input-sm numberOnly time_process' placeholder='per Minutes'>
						</td>
						<td width='20%' class="text-left">
							Jumlah MP
							<input type='text' name='ListTime[11][process]' value='cutting' class='Hide'>
							<input type='text' name='ListTime[11][sub_process]' value='fw' class='Hide'>
						</td>
						<td width='20%' class="text-left"><input type='text' name='ListTime[11][man_power]' class='form-control input-sm numberOnly man_power'></td>
					</tr>
				</tbody>
			</table>
			</div>
			
			
			<br><br><br>
			<!-- END -->
			<div class='form-group row'>		 	 
				<label class='label-control col-sm-2' style='text-align:right;'></label>
				<div class='col-sm-2'>              
					
				</div>
				<label class='col-sm-2' style='text-align:left; margin-top: 6px;'></label>
				<div class='col-sm-1'>              
					
				</div>
				<label class='col-sm-1' style='text-align:left; margin-left:-100px; margin-top: 6px;'></label>
				<div class='col-sm-1'>              
					
				</div>
				<label class='col-sm-2' style='text-align:left; margin-left: -50px; margin-top: 6px;'></label>
				<div class='col-sm-2' style='float:right;'>              
					<button type='button' name='simpan-bro' id='simpan-bro' class='btn btn-primary' style='width:100px;'>Save</button>
				</div>
				
				<label class='col-sm-1' style='text-align:left; margin-left:-100px; margin-top: 6px;'></label>
			</div>
			
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
<script src="<?php echo base_url('application/views/Est_js/pipe_slongsong.js'); ?>"></script>
<script src="<?php echo base_url('application/views/Component/est/javascript/help_general.js'); ?>"></script>
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
		margin-bottom: 15px;
		margin-top: 30px;
		color: white;
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
	#top_typeList_chosen,
	#series_chosen,
	#criminal_barier_chosen,
	#vacum_rate_chosen,
	#aplikasi_product_chosen,
	#design_life_chosen,
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
	#mid_mtl_resin26_chosen{
		display: none;
	}
	
</style>
<script>
	
		
	$(document).ready(function(){	
		$('.ToleranSt').hide();
		$('#top_min_toleran').val('0.125');
		$('#top_max_toleran').val('0.125');
		
		$('.HideCost').hide();
		$('.Hide').hide();
		$('#plactic').hide();
		
		$(document).on('keyup', '.time_process', function(){
			var man_power		= parseFloat($(this).parent().parent().find("td:nth-child(5) input").val());
			var time_process	= parseFloat($(this).val());
			
			var man_hours	= (time_process/60) * man_power;
			if(isNaN(man_hours)){ var man_hours=0; }
			$(this).parent().parent().find("td:nth-child(2) input").val(man_hours.toFixed(4));
		});
		
		$(document).on('keyup', '.man_power', function(){
			var time_process	= parseFloat($(this).parent().parent().find("td:nth-child(3) input").val());
			var man_power		= parseFloat($(this).val());
			
			var man_hours	= (time_process/60) * man_power;
			if(isNaN(man_hours)){ var man_hours=0; }
			$(this).parent().parent().find("td:nth-child(2) input").val(man_hours.toFixed(4));
		});
		
		$(document).on('keyup', '.time_processx', function(){
			var time_process	= parseFloat($(this).val());
			
			var man_hours	= time_process / 60;
			if(isNaN(man_hours)){ var man_hours=0; }
			$(this).parent().parent().find("td:nth-child(2) input").val(man_hours.toFixed(4));
		});
		
		$(document).on('keyup', '#top_tebal_design', function(){
			changeTop();
		}); 
		
		$(document).on('change', '#series', function(){
			var series 		= $('#series').val();
			var linerEx		= series.split('-');
			var liner		= (linerEx[1] == '2.5')?'2.45':linerEx[1];

			var external			= parseFloat($('#acuhan_3').val());
			
			//pengurangan structure thickness
			var top_thickness	= parseFloat($('#top_tebal_design').val());
			var acuhan_1		= parseFloat(liner);
			var struktur		= top_thickness - (acuhan_1 + external);
			
			$('#acuhan_2').val(struktur.toFixed(2));
			$('#acuhan_1').val(liner);
			
			AcuhanMaxMin();
		});
		
		
		
		$(document).on('keyup', '#top_min_toleran', function(){
			AcuhanMaxMin();
		});
		
		$(document).on('keyup', '#top_max_toleran', function(){
			AcuhanMaxMin();
		});
		
		//==========================================SAVED=================================================
		$(document).on('click', '#simpan-bro', function(e){
			e.preventDefault(); 
			
			var top_type			= $('#top_typeList').val();
			var top_diameter		= $('#diameter').val();
			var pipe_for			= $('#pipe_for').val();
			var top_length			= $('#top_length').val();
			var top_tebal_design	= $('#top_tebal_design').val();
			var top_max_toleran		= $('#top_max_toleran').val();
			var top_min_toleran		= $('#top_min_toleran').val();
			
			var series				= $('#series').val();
			
			var criminal_barier		= $('#criminal_barier').val();
			var aplikasi_product	= $('#aplikasi_product').val();
			var vacum_rate			= $('#vacum_rate').val();
			var design_life			= $('#design_life').val();
			
			//LINER THICKNESS
			var acuhan_1			= $('#acuhan_1').val();
			var mid_mtl_plastic		= $('#mid_mtl_plastic').val();
			var mid_mtl_veil		= $('#mid_mtl_veil').val();
			var mid_mtl_veil_add	= $('#mid_mtl_veil_add').val();
			var mid_mtl_matcsm		= $('#mid_mtl_matcsm').val();
			var mid_mtl_csm_add		= $('#mid_mtl_csm_add').val();
			var mid_mtl_resin_tot	= $('#mid_mtl_resin_tot').val();
			
			var mid_mtl_katalis		= $('#mid_mtl_katalis').val();
			var mid_mtl_sm			= $('#mid_mtl_sm').val();
			var mid_mtl_cobalt		= $('#mid_mtl_cobalt').val();
			var mid_mtl_dma			= $('#mid_mtl_dma').val();
			var mid_mtl_hydro		= $('#mid_mtl_hydro').val();
			var mid_mtl_methanol	= $('#mid_mtl_methanol').val();
			
			var layer_veil 			= $('#layer_veil').val();
			var layer_veil_add 		= $('#layer_veil_add').val();
			var layer_matcsm 		= $('#layer_matcsm').val();
			var layer_csm_add 		= $('#layer_csm_add').val();
			
			var persen_katalis 		= $('#persen_katalis').val();
			var persen_sm 			= $('#persen_sm').val();
			var persen_coblat 		= $('#persen_coblat').val();
			var persen_dma 			= $('#persen_dma').val();
			var persen_hydroquinone = $('#persen_hydroquinone').val();
			var persen_methanol 	= $('#persen_methanol').val();
			
			//STRYKTURE THICKNESS
			var mid_mtl_matcsm2		= $('#mid_mtl_matcsm2').val();
			var mid_mtl_csm_add2	= $('#mid_mtl_csm_add2').val();
			var mid_mtl_wr2			= $('#mid_mtl_wr2').val();
			var mid_mtl_wr_add2		= $('#mid_mtl_wr_add2').val();
			var mid_mtl_rooving21	= $('#mid_mtl_rooving21').val();
			var mid_mtl_rooving22	= $('#mid_mtl_rooving22').val();
			var mid_mtl_resin_tot2	= $('#mid_mtl_resin_tot2').val();
			
			var mid_mtl_katalis2	= $('#mid_mtl_katalis2').val();
			var mid_mtl_sm2			= $('#mid_mtl_sm2').val();
			var mid_mtl_cobalt2		= $('#mid_mtl_cobalt2').val();
			var mid_mtl_dma2		= $('#mid_mtl_dma2').val();
			var mid_mtl_hydro2		= $('#mid_mtl_hydro2').val();
			var mid_mtl_methanol2	= $('#mid_mtl_methanol2').val();
			
			var layer_matcsm2		= $('#layer_matcsm2').val();
			var layer_csm_add2		= $('#layer_csm_add2').val();
			var layer_wr2			= $('#layer_wr2').val();
			var layer_wr_add2		= $('#layer_wr_add2').val();
			var layer_rooving21		= $('#layer_rooving21').val();
			var layer_rooving22		= $('#layer_rooving22').val();
			
			var persen_katalis2		= $('#persen_katalis2').val();
			var persen_sm2			= $('#persen_sm2').val();
			var persen_coblat2		= $('#persen_coblat2').val();
			var persen_dma2			= $('#persen_dma2').val();
			var persen_hydroquinone2	= $('#persen_hydroquinone2').val();
			var persen_methanol2	= $('#persen_methanol2').val();
			
			//Maxsimal Number
			var numberMax_liner		= $('#numberMax_liner').val();
			var numberMax_strukture	= $('#numberMax_strukture').val();
			
			var time_process		= $('.time_process').val();
			var man_power			= $('.man_power').val();
			
			$(this).prop('disabled',true);
			
			
			if(top_type == '' || top_type == null || top_type == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'Diameter is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			
			if(series == '' || series == null || series == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'Series is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(pipe_for == '' || pipe_for == null || pipe_for == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'Pipe For is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(criminal_barier == '' || criminal_barier == null || criminal_barier == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'Fluida is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(aplikasi_product == '' || aplikasi_product == null || aplikasi_product == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'Application is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(vacum_rate == '' || vacum_rate == null || vacum_rate == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'Vacuum Rate is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(design_life == '' || design_life == null || design_life == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'Design Life is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(top_diameter == '' || top_diameter == null || top_diameter == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'ID Pipe is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(top_length == '' || top_length == null || top_length == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'Length Pipe is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(top_tebal_design == '' || top_tebal_design == null || top_tebal_design == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'Thickness Pipe Design is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(top_max_toleran == '' || top_max_toleran == null || top_max_toleran == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'Min Tolerance is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(top_min_toleran == '' || top_min_toleran == null || top_min_toleran == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'Max Tolerance is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			
			//LINER THICKNESS
			if(mid_mtl_plastic == '' || mid_mtl_plastic == null || mid_mtl_plastic == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'Plastic Film/Mirror Glass Material [LINER THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(mid_mtl_veil == '' || mid_mtl_veil == null || mid_mtl_veil == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'Veil Material [LINER THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(mid_mtl_veil_add == '' || mid_mtl_veil_add == null || mid_mtl_veil_add == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'Veil Add Material [LINER THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(mid_mtl_matcsm == '' || mid_mtl_matcsm == null || mid_mtl_matcsm == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'MAT/CSM Material [LINER THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(mid_mtl_csm_add == '' || mid_mtl_csm_add == null || mid_mtl_csm_add == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'MAT/CSM Add Material [LINER THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(mid_mtl_resin_tot == '' || mid_mtl_resin_tot == null || mid_mtl_resin_tot == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'Resin Material [LINER THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(mid_mtl_katalis == '' || mid_mtl_katalis == null || mid_mtl_katalis == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'Katalis Material [LINER THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(mid_mtl_sm == '' || mid_mtl_sm == null || mid_mtl_sm == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'SM Material [LINER THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(mid_mtl_cobalt == '' || mid_mtl_cobalt == null || mid_mtl_cobalt == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'Cobalt Material [LINER THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(mid_mtl_dma == '' || mid_mtl_dma == null || mid_mtl_dma == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'DMA Material [LINER THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(mid_mtl_hydro == '' || mid_mtl_hydro == null || mid_mtl_hydro == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'Hydroquinone Material [LINER THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(mid_mtl_methanol == '' || mid_mtl_methanol == null || mid_mtl_methanol == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'Methanol Material [LINER THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			//Tambahan
			if(layer_veil == '' || layer_veil == null || layer_veil == '.'){
				swal({
				  title	: "Error Message!",
				  text	: 'Layer Veil [LINER THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(layer_veil_add == '' || layer_veil_add == null || layer_veil_add == '.'){
				swal({
				  title	: "Error Message!",
				  text	: 'Layer Veil Add [LINER THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(layer_matcsm == '' || layer_matcsm == null || layer_matcsm == '.'){
				swal({
				  title	: "Error Message!",
				  text	: 'Layer MAT/CSM [LINER THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(layer_csm_add == '' || layer_csm_add == null || layer_csm_add == '.'){
				swal({
				  title	: "Error Message!",
				  text	: 'Layer CSM Add [LINER THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(persen_katalis == '' || persen_katalis == null || persen_katalis == '.'){
				swal({
				  title	: "Error Message!",
				  text	: 'Percent Katalis [LINER THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(persen_sm == '' || persen_sm == null || persen_sm == '.'){
				swal({
				  title	: "Error Message!",
				  text	: 'Percent SM [LINER THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(persen_coblat == '' || persen_coblat == null || persen_coblat == '.'){
				swal({
				  title	: "Error Message!",
				  text	: 'Percent Coblat [LINER THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(persen_dma == '' || persen_dma == null || persen_dma == '.'){
				swal({
				  title	: "Error Message!",
				  text	: 'Percent DMA [LINER THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(persen_hydroquinone == '' || persen_hydroquinone == null || persen_hydroquinone == '.'){
				swal({
				  title	: "Error Message!",
				  text	: 'Percent Hydroquinone [LINER THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(persen_methanol == '' || persen_methanol == null || persen_methanol == '.'){
				swal({
				  title	: "Error Message!",
				  text	: 'Percent Methanol [LINER THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			
			//STRUKTUR THICKNESS
			if(mid_mtl_matcsm2 == '' || mid_mtl_matcsm2 == null || mid_mtl_matcsm2 == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'MAT/CSM Material [STRUKTURE THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(mid_mtl_csm_add2 == '' || mid_mtl_csm_add2 == null || mid_mtl_csm_add2 == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'MAT/CSM Add Material [STRUKTURE THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(mid_mtl_wr2 == '' || mid_mtl_wr2 == null || mid_mtl_wr2 == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'WR Material [STRUKTURE THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(mid_mtl_wr_add2 == '' || mid_mtl_wr_add2 == null || mid_mtl_wr_add2 == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'WR Add Material [STRUKTURE THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(mid_mtl_rooving21 == '' || mid_mtl_rooving21 == null || mid_mtl_rooving21 == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'Rooving 1 Material [STRUKTURE THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(mid_mtl_rooving22 == '' || mid_mtl_rooving22 == null || mid_mtl_rooving22 == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'Rooving 2 Material [STRUKTURE THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(mid_mtl_resin_tot2 == '' || mid_mtl_resin_tot2 == null || mid_mtl_resin_tot2 == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'Resin Material [STRUKTURE THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			//==
			if(mid_mtl_katalis2 == '' || mid_mtl_katalis2 == null || mid_mtl_katalis2 == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'Katalis Material [STRUKTURE THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(mid_mtl_sm2 == '' || mid_mtl_sm2 == null || mid_mtl_sm2 == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'SM Material [STRUKTURE THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(mid_mtl_cobalt2 == '' || mid_mtl_cobalt2 == null || mid_mtl_cobalt2 == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'Cobalt Material [STRUKTURE THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(mid_mtl_dma2 == '' || mid_mtl_dma2 == null || mid_mtl_dma2 == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'DMA Material [STRUKTURE THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(mid_mtl_hydro2 == '' || mid_mtl_hydro2 == null || mid_mtl_hydro2 == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'Hydroquinone Material [STRUKTURE THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(mid_mtl_methanol2 == '' || mid_mtl_methanol2 == null || mid_mtl_methanol2 == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'Methanol Material [STRUKTURE THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			//Tambahan
			if(layer_matcsm2 == '' || layer_matcsm2 == null || layer_matcsm2 == '.'){
				swal({
				  title	: "Error Message!",
				  text	: 'Layer MAT/CSM [STRUKTURE THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(layer_csm_add2 == '' || layer_csm_add2 == null || layer_csm_add2 == '.'){
				swal({
				  title	: "Error Message!",
				  text	: 'Layer CSM Add [STRUKTURE THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(layer_wr2 == '' || layer_wr2 == null || layer_wr2 == '.'){
				swal({
				  title	: "Error Message!",
				  text	: 'Layer WR [STRUKTURE THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(layer_wr_add2 == '' || layer_wr_add2 == null || layer_wr_add2 == '.'){
				swal({
				  title	: "Error Message!",
				  text	: 'Layer WR Add [STRUKTURE THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(layer_rooving21 == '' || layer_rooving21 == null || layer_rooving21 == '.'){
				swal({
				  title	: "Error Message!",
				  text	: 'Layer Rooving [STRUKTURE THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(layer_rooving22 == '' || layer_rooving22 == null || layer_rooving22 == '.'){
				swal({
				  title	: "Error Message!",
				  text	: 'Layer Rooving Add [STRUKTURE THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(persen_katalis2 == '' || persen_katalis2 == null || persen_katalis2 == '.'){
				swal({
				  title	: "Error Message!",
				  text	: 'Percent Katalis [STRUKTURE THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(persen_sm2 == '' || persen_sm2 == null || persen_sm2 == '.'){
				swal({
				  title	: "Error Message!",
				  text	: 'Percent SM [STRUKTURE THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(persen_coblat2 == '' || persen_coblat2 == null || persen_coblat2 == '.'){
				swal({
				  title	: "Error Message!",
				  text	: 'Percent Coblat [STRUKTURE THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(persen_dma2 == '' || persen_dma2 == null || persen_dma2 == '.'){
				swal({
				  title	: "Error Message!",
				  text	: 'Percent DMA [STRUKTURE THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(persen_hydroquinone2 == '' || persen_hydroquinone2 == null || persen_hydroquinone2 == '.'){
				swal({
				  title	: "Error Message!",
				  text	: 'Percent Hydroquinone [STRUKTURE THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(persen_methanol2 == '' || persen_methanol2 == null || persen_methanol2 == '.'){
				swal({
				  title	: "Error Message!",
				  text	: 'Percent Methanol [STRUKTURE THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			
			//MAX Number
			if(numberMax_liner != 0 || numberMax_strukture != 0 ){
				var intL = 0;
				var intError = 0;
				var pesan = '';
				
				if(numberMax_strukture != 0){
					$('#detail_body_strukture').find('tr').each(function(){
						intL++;
						var findId	= $(this).attr('id');
						// console.log(findId);
						// return false;
						var nomor	= findId.split('_');
						var perse_strukture			= $('#perse_strukture_'+nomor[1]).val();
						var containing_strukture	= $('#containing_strukture_'+nomor[1]).val();
						var id_material_strukture	= $('#id_material_strukture_'+nomor[1]).val();
						var id_category_strukture	= $('#id_category_strukture_'+nomor[1]).val();
						
						if(perse_strukture == '' ){
							intError++;
							pesan = "Number "+nomor[1]+" :Percent [STRUKTURE THICKNESS] has not empty ...";
						}
						if(containing_strukture == '' ){
							intError++;
							pesan = "Number "+nomor[1]+" : Comparison [STRUKTURE THICKNESS] has not empty ...";
						}
						if(id_material_strukture == '' || id_material_strukture == null || id_material_strukture == 0 ){
							intError++;
							pesan = "Number "+nomor[1]+" : Material [STRUKTURE THICKNESS] has not selected ...";
						}
						if(id_category_strukture == '' || id_category_strukture == null || id_category_strukture == 0 ){
							intError++;
							pesan = "Number "+nomor[1]+" : Category Material [STRUKTURE THICKNESS] has not selected ...";
						}
					});
				}
				
				if(numberMax_liner != 0){
					$('#detail_body_liner').find('tr').each(function(){
						intL++;
						var findId	= $(this).attr('id');
						// console.log(findId);
						// return false;
						var nomor	= findId.split('_');
						var perse_liner			= $('#perse_liner_'+nomor[1]).val();
						var containing_liner	= $('#containing_liner_'+nomor[1]).val();
						var id_material_liner	= $('#id_material_liner_'+nomor[1]).val();
						var id_category_liner	= $('#id_category_liner_'+nomor[1]).val();
						
						if(perse_liner == '' ){
							intError++;
							pesan = "Number "+nomor[1]+" : Percent [LINER THICKNESS] has not empty ...";
						}
						if(containing_liner == '' ){
							intError++;
							pesan = "Number "+nomor[1]+" : Comparison [LINER THICKNESS] has not empty ...";
						}
						if(id_material_liner == '' || id_material_liner == null || id_material_liner == 0 ){
							intError++;
							pesan = "Number "+nomor[1]+" : Material [LINER THICKNESS] has not selected ...";
						}
						if(id_category_liner == '' || id_category_liner == null || id_category_liner == 0 ){
							intError++;
							pesan = "Number "+nomor[1]+" : Category Material [LINER THICKNESS] has not selected ...";
						}
					});
				}
				
				if(intError > 0){
					// alert(pesan);
					swal({
						title				: "Notification Message !",
						text				: pesan,						
						type				: "warning"
					});
					$('#simpan-bro').prop('disabled',false);
					return false;
				}
			}
			
			var hasil_linier_thickness 	= $('#hasil_linier_thickness').val();
			var hasil_linier_thickness2 = $('#hasil_linier_thickness2').val();
			
			if(hasil_linier_thickness != 'OK' || hasil_linier_thickness2 != 'OK'){
				swal({
				  title	: "Error Message!",
				  text	: 'Thickness is To High or To Low, please check back ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			} 
			
			$('#simpan-bro').prop('disabled',false);
			
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
						var baseurl		= base_url + active_controller +'/pipeslongsong';
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
								else if(data.status == 3){
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
		
		
	});
	
</script>