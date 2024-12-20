<?php
$this->load->view('include/side_menu'); 
?> 
<form action="#" method="POST" id="form_proses_bro">   
	<div class="box box-primary">
		<div class="box-header">
			<h3 class="box-title"><?php echo $title;?></h3>		
		</div>
	
		<div class="box-body">
			<!-- NEW -->
			<div class='headerTitleGroup'>GROUP COMPONENT</div>
			<div class='form-group row'>		 	 
				<label class='label-control col-sm-2'><b>Diameter <span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>              
					<?php
						echo form_input(array('id'=>'top_type','name'=>'top_type','class'=>'form-control input-sm Hide','readonly'=>'readonly'));											
						echo form_input(array('id'=>'top_diameter','name'=>'top_diameter','class'=>'form-control input-sm Hide','readonly'=>'readonly'));
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
						echo form_input(array('type'=>'text','id'=>'waste','name'=>'waste','class'=>'form-control input-sm numberOnly','placeholder'=>'Waste','value'=>'10','readonly'=>'readonly'));	
					?>	
				</div>
				<div class='col-sm-2'>              
					<?php
						echo form_input(array('id'=>'top_tebal_est','name'=>'top_tebal_est','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));
						echo form_input(array('type'=>'text','id'=>'area','name'=>'area','class'=>'HideCost'));
						echo form_input(array('type'=>'text','id'=>'acuhan_1','name'=>'acuhan_1','class'=>'HideCost'));
						echo form_input(array('type'=>'text','id'=>'radius','name'=>'radius','class'=>'form-control input-sm HideCost','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					
					?>
				</div>
			</div>
			<div class='form-group row'>
				<label class='label-control col-sm-2'><b>Thickness Design | Length<span class='text-red'>*</span></b></label>
				<div class='col-sm-2'>              
					<?php
						echo form_input(array('id'=>'top_tebal_design','name'=>'top_tebal_design','class'=>'form-control input-sm numberOnly','autocomplete'=>'off','placeholder'=>'Pipe Thickness (Design)', 'value'=>''));											
					?>	
				</div>
				<div class='col-sm-2'>              
					<?php
						echo form_input(array('id'=>'panjang','name'=>'panjang','class'=>'form-control input-sm numberOnly','autocomplete'=>'off','placeholder'=>'Length Mitter', 'value'=>'','readonly'=>'readonly'));											
				?>	
				</div>
				
			
					<label class='label-control col-sm-2'><b>Type Radius <span class='text-red'>*</span></b></label>
					<div class='col-sm-2'>              
						<select name='type_elbow' id='type_elbow' class='form-control input-sm'>
							<option value='0'>Type Radius</option>
							<option value='SR'>Short Radius</option>
							<option value='LR'>Long Radius</option>
						</select>
					</div>
					<div class='col-sm-2'>              
						<?php
							echo form_input(array('id'=>'angle','name'=>'angle','class'=>'form-control input-sm numberOnly','autocomplete'=>'off','placeholder'=>'Angle', 'maxlength'=>'3'));											
						?>	
					</div>
				</div>
			
			<div class='form-group row'>
				
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
			<div class='form-group row'>
				<input type='text' name='detail_name' id='detail_name' class='HideCost' value='LINER THIKNESS / CB'>
			</div>
			<div class='form-group row'>	
				<label class='label-control col-sm-2'><b><div id='plactic'>PLASTIC FILM<span class='text-red'>*</span></div></b></label>
				<div class='col-sm-3'>              
					<select name='ListDetail[1][id_material]' id='mid_mtl_plastic' class='form-control input-sm'>
						<option value=''>Select An Plastic Film</option>
					<?php
						foreach($ListPlastic AS $val => $valx){
							echo "<option value='".$valx['id_material']."'>".strtoupper($valx['nm_material'])."</option>";
						}
						echo "<option value='MTL-1903000'>NONE MATERIAL</option>";
					 ?>
					</select>	
					<input type='text' name='ListDetail[1][last_full]' class='HideCost' id='hasil_plastic' value='0'>
					<input type='text' name='ListDetail[1][containing]' class='HideCost' id='layer_plastic' value='1'>
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
					<input type='text' name='ListDetail[5][last_full]' class='HideCost' id='hasil_resin2' value='0'>
					<!--<input type='text' name='ListDetail[5][containing]' class='HideCost' id='layer_resin2' value='9'>-->
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
					<input type='text' name='ListDetail[7][last_full]' class='HideCost' id='hasil_resin3' value='0'>
					<!--<input type='text' name='ListDetail[7][containing]' class='HideCost' id='layer_resin3' value='2.333'>-->
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
					<input type='text' name='ListDetail[9][last_full]' class='HideCost' id='hasil_resin4' value='0'>
					<!--<input type='text' name='ListDetail[9][containing]' class='HideCost' id='layer_resin4' value='2.333'>-->
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
					<input type='text' name='ListDetail[10][last_full]' class='HideCost' id='hasil_resin_tot' value='0'>
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
					<input type='text' name='ListDetailPlus[1][perse]' style='margin-left:-92px;' class='form-control input-sm numberOnly' id='persen_sm' value='0'>	
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
				<div class='col-sm-11'>              
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
			
			<!-- ====================================================================================================== -->
			<!-- ==========================================EXTERNAL LAYER THICKNESS==================================== -->
			<!-- ====================================================================================================== -->
			<div class='headerTitle'>EXTERNAL LAYER THICKNESS</div>
			<div class='form-group row'>
				<label class='label-control col-sm-2' style='text-align:left;'><b>EXTERNAL LAYER ? <span class='text-red'>*</span></b></label>
				<div class='col-sm-2'>  						
					<select name='external_layer' id='external_layer' class='form-control input-sm'>
						<option value='Y'>Yes</option>
						<option value='N'>No</option>
					</select>				
				</div>
				<div class='col-sm-7'>              
					<input type='text' name='acuhan_3' class='Acuhan numberOnly' id='acuhan_3' value='0'>
					<input type='text' name='detail_name3' id='detail_name3' class='HideCost' value='EXTERNAL LAYER THICKNESS'>
				</div>
			</div>
			<div class='form-group row'>		 	 
				<label class='label-control col-sm-2' style='text-align:left;'><b>VEIL<span class='text-red'>*</span></b></label>
				<div class='col-sm-3'>  						
					<select name='ListDetail3[0][id_material]' id='mid_mtl_veil3' class='form-control input-sm'>
						<option value=''>Select An Veil</option>
					<?php
						foreach($ListVeil AS $val => $valx){
							echo "<option value='".$valx['id_material']."'>".strtoupper($valx['nm_material'])."</option>";
						}
						echo "<option value='MTL-1903000'>NONE MATERIAL</option>";
					 ?>
					</select>
					<input type='text' name='ListDetail3[0][thickness]' class='HideCost' id='thickness_veil3' value='0'>
					<input type='text' name='ListDetail3[0][last_full]' class='HideCost' id='hasil_veil3' value='0'>				
				</div>
				<label class='col-sm-2' style='text-align:left; margin-top: 6px;'>Weight</label>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'weight_veil3','name'=>'ListDetail3[0][value]', 'style'=>'margin-left:-110px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1' style='text-align:left; margin-left:-130px; margin-top: 6px;'>Layer</label>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'layer_veil3','name'=>'ListDetail3[0][layer]', 'style'=>'margin-left:-90px;width: 50px;','class'=>'form-control input-sm numberOnly','autocomplete'=>'off', 'value'=>''));											
					?>	
				</div>
				<label class='col-sm-2' style='text-align:left; margin-left: -130px; margin-top: 6px;'>Thickness</label>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'totthick_veil3','name'=>'ListDetail3[0][total_thickness]', 'style'=>'margin-left:-90px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly','value'=>'0'));											
					?>	
				</div>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'last_veil3','name'=>'ListDetail3[0][last_cost]', 'style'=>'margin-left:-80px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly','value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1 kghide' style='text-align:left; margin-left:-100px; margin-top: 6px;'>Kg</label>
			</div>
			<div class='form-group row'>		 	 
				<label class='label-control col-sm-2'><b></b></label>
				<div class='col-sm-3'>              
					<select name='id_material' id='mid_mtl_resin31' class='form-control input-sm' disabled>
						<option value=''>Select An Resin</option>
					<?php
						foreach($ListResin AS $val => $valx){
							echo "<option value='".$valx['id_material']."'>".strtoupper($valx['nm_material'])."</option>";
						}
						echo "<option value='MTL-1903000'>NONE MATERIAL</option>";
					 ?>
					</select>	
					<input type='text' name='ListDetail3[1][last_full]' class='HideCost' id='hasil_resin31' value='0'>
					<input type='text' name='ListDetail3[1][id_material]' class='HideCost' id='layer_resin31hide'>
					<!--<input type='text' name='ListDetail3[1][containing]' class='HideCost' id='layer_resin31' value='9'>-->
				</div>
				<label class='col-sm-2' style='text-align:left; margin-top: 6px;'><u>Rs.Containing</u></label>
				<div class='col-sm-1'>              
					
				</div>
				<label class='col-sm-1' style='text-align:left; margin-left:-130px; margin-top: 6px;'></label>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'layer_resin31','name'=>'ListDetail3[1][containing]', 'style'=>'margin-left:-90px;width: 50px;','class'=>'form-control input-sm numberOnly','autocomplete'=>'off', 'readonly'=>'readonly', 'value'=>'0'));											
					?>
				</div>
				<label class='col-sm-2' style='text-align:left; margin-left: -130px; margin-top: 6px;'></label>
				<div class='col-sm-1'>              
					
				</div>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'last_resin31','name'=>'ListDetail3[1][last_cost]', 'style'=>'margin-left:-80px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1 kghide' style='text-align:left; margin-left:-100px; margin-top: 6px;'>Kg</label>
			</div>
			<div class='form-group row'>		 	 
				<label class='label-control col-sm-2' style='text-align:left;'><b>ADDITIONAL VEIL<span class='text-red'>*</span></b></label>
				<div class='col-sm-3'>              
					<select name='ListDetail3[2][id_material]' id='mid_mtl_veil_add3' class='form-control input-sm'>
						<option value=''>Select An Veil Add</option>
					<?php
						foreach($ListVeil AS $val => $valx){
							echo "<option value='".$valx['id_material']."'>".strtoupper($valx['nm_material'])."</option>";
						}
						echo "<option value='MTL-1903000'>NONE MATERIAL</option>";
					 ?>
					</select>
					<input type='text' name='ListDetail3[2][thickness]' class='HideCost' id='thickness_veil_add3' value='0'>
					<input type='text' name='ListDetail3[2][last_full]' class='HideCost' id='hasil_veil_add3' value='0'>	
				</div>
				<label class='col-sm-2' style='text-align:left; margin-top: 6px;'>Weight</label>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'weight_veil_add3','name'=>'ListDetail3[2][value]', 'style'=>'margin-left:-110px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1' style='text-align:left; margin-left:-130px; margin-top: 6px;'>Layer</label>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'layer_veil_add3','name'=>'ListDetail3[2][layer]', 'style'=>'margin-left:-90px;width: 50px;','class'=>'form-control input-sm numberOnly','autocomplete'=>'off', 'value'=>''));											
					?>	
				</div>
				<label class='col-sm-2' style='text-align:left; margin-left: -130px; margin-top: 6px;'>Thickness</label>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'totthick_veil_add3','name'=>'ListDetail3[2][total_thickness]', 'style'=>'margin-left:-90px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'last_veil_add3','name'=>'ListDetail3[2][last_cost]', 'style'=>'margin-left:-80px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1 kghide' style='text-align:left; margin-left:-100px; margin-top: 6px;'>Kg</label>
			</div>
			<div class='form-group row'>		 	 
				<label class='label-control col-sm-2'><b></b></label>
				<div class='col-sm-3'>              
					<select name='id_material' id='mid_mtl_resin32' class='form-control input-sm' disabled>
						<option value=''>Select An Resin</option>
					<?php
						foreach($ListResin AS $val => $valx){
							echo "<option value='".$valx['id_material']."'>".strtoupper($valx['nm_material'])."</option>";
						}
						echo "<option value='MTL-1903000'>NONE MATERIAL</option>";
					 ?>
					</select>	
					<input type='text' name='ListDetail3[3][last_full]' class='HideCost' id='hasil_resin32' value='0'>
					<!--<input type='text' name='ListDetail3[3][containing]' class='HideCost' id='layer_resin32' value='9'>-->
					<input type='text' name='ListDetail3[3][id_material]' class='HideCost' id='layer_resin32hide'>
				</div>
				<label class='col-sm-2' style='text-align:left; margin-top: 6px;'><u>Rs.Containing</u></label>
				<div class='col-sm-1'>              
					
				</div>
				<label class='col-sm-1' style='text-align:left; margin-left:-130px; margin-top: 6px;'></label>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'layer_resin32','name'=>'ListDetail3[3][containing]', 'style'=>'margin-left:-90px;width: 50px;','class'=>'form-control input-sm numberOnly','autocomplete'=>'off', 'readonly'=>'readonly', 'value'=>'0'));											
					?>
				</div>
				<label class='col-sm-2' style='text-align:left; margin-left: -130px; margin-top: 6px;'></label>
				<div class='col-sm-1'>              
					
				</div>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'last_resin32','name'=>'ListDetail3[3][last_cost]', 'style'=>'margin-left:-80px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1 kghide' style='text-align:left; margin-left:-100px; margin-top: 6px;'>Kg</label>
			</div>
			<div class='form-group row'>		 	 
				<label class='label-control col-sm-2' style='text-align:left;'><b>MAT / CSM<span class='text-red'>*</span></b></label>
				<div class='col-sm-3'>              
					<select name='ListDetail3[4][id_material]' id='mid_mtl_matcsm3' class='form-control input-sm'>
						<option value=''>Select An MAT/CSM</option>
					<?php
						foreach($ListMatCsm AS $val => $valx){
							echo "<option value='".$valx['id_material']."'>".strtoupper($valx['nm_material'])."</option>";
						}
						echo "<option value='MTL-1903000'>NONE MATERIAL</option>";
					 ?>
					</select>
					<input type='text' name='ListDetail3[4][thickness]' class='HideCost' id='thickness_matcsm3' value='0'>
					<input type='text' name='ListDetail3[4][last_full]' class='HideCost' id='hasil_matcsm3' value='0'>	
				</div>
				<label class='col-sm-2' style='text-align:left; margin-top: 6px;'>Weight</label>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'weight_matcsm3','name'=>'ListDetail3[4][value]', 'style'=>'margin-left:-110px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1' style='text-align:left; margin-left:-130px; margin-top: 6px;'>Layer</label>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'layer_matcsm3','name'=>'ListDetail3[4][layer]', 'style'=>'margin-left:-90px;width: 50px;','class'=>'form-control input-sm numberOnly','autocomplete'=>'off', 'value'=>''));											
					?>	
				</div>
				<label class='col-sm-2' style='text-align:left; margin-left: -130px; margin-top: 6px;'>Thickness</label>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'totthick_matcsm3','name'=>'ListDetail3[4][total_thickness]', 'style'=>'margin-left:-90px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly','value'=>'0'));											
					?>	
				</div>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'last_matcsm3','name'=>'ListDetail3[4][last_cost]', 'style'=>'margin-left:-80px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly','value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1 kghide' style='text-align:left; margin-left:-100px; margin-top: 6px;'>Kg</label>
			</div>
			<div class='form-group row'>		 	 
				<label class='label-control col-sm-2'><b></b></label>
				<div class='col-sm-3'>              
					<select name='id_material' id='mid_mtl_resin33' class='form-control input-sm' disabled>
					<option value=''>Select An Resin</option>
					<?php
						foreach($ListResin AS $val => $valx){
							echo "<option value='".$valx['id_material']."'>".strtoupper($valx['nm_material'])."</option>";
						}
						echo "<option value='MTL-1903000'>NONE MATERIAL</option>";
					 ?>
					</select>
					<input type='text' name='ListDetail3[5][last_full]' class='HideCost' id='hasil_resin33' value='0'>
					<!--<input type='text' name='ListDetail3[5][containing]' class='HideCost' id='layer_resin33' value='2.333'>-->
					<input type='text' name='ListDetail3[5][id_material]' class='HideCost' id='layer_resin33hide'>
				</div>
				<label class='col-sm-2' style='text-align:left; margin-top: 6px;'><u>Rs.Containing</u></label>
				<div class='col-sm-1'>              
					
				</div>
				<label class='col-sm-1' style='text-align:left; margin-left:-130px; margin-top: 6px;'></label>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'layer_resin33','name'=>'ListDetail3[5][containing]', 'style'=>'margin-left:-90px;width: 50px;','class'=>'form-control input-sm numberOnly','autocomplete'=>'off', 'readonly'=>'readonly', 'value'=>'0'));											
					?>
				</div>
				<label class='col-sm-2' style='text-align:left; margin-left: -130px; margin-top: 6px;'></label>
				<div class='col-sm-1'>              
					
				</div>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'last_resin33','name'=>'ListDetail3[5][last_cost]', 'style'=>'margin-left:-80px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1 kghide' style='text-align:left; margin-left:-100px; margin-top: 6px;'>Kg</label>
			</div>
			<div class='form-group row'>		 	 
				<label class='label-control col-sm-2' style='text-align:left;'><b>ADDITIONAL CSM<span class='text-red'>*</span></b></label>
				<div class='col-sm-3'>              
					<select name='ListDetail3[6][id_material]' id='mid_mtl_csm_add3' class='form-control input-sm'>
					<option value=''>Select An MAT/CSM</option>
					<?php
						foreach($ListMatCsm AS $val => $valx){
							echo "<option value='".$valx['id_material']."'>".strtoupper($valx['nm_material'])."</option>";
						}
						echo "<option value='MTL-1903000'>NONE MATERIAL</option>";
					 ?>
					</select>	
					<input type='text' name='ListDetail3[6][thickness]' class='HideCost' id='thickness_csm_add3' value='0'>
					<input type='text' name='ListDetail3[6][last_full]' class='HideCost' id='hasil_csm_add3' value='0'>	
				</div>
				<label class='col-sm-2' style='text-align:left; margin-top: 6px;'>Weight</label>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'weight_csm_add3','name'=>'ListDetail3[6][value]', 'style'=>'margin-left:-110px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1' style='text-align:left; margin-left:-130px; margin-top: 6px;'>Layer</label>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'layer_csm_add3','name'=>'ListDetail3[6][layer]', 'style'=>'margin-left:-90px;width: 50px;','class'=>'form-control input-sm numberOnly','autocomplete'=>'off', 'value'=>''));											
					?>	
				</div>
				<label class='col-sm-2' style='text-align:left; margin-left: -130px; margin-top: 6px;'>Thickness</label>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'totthick_csm_add3','name'=>'ListDetail3[6][total_thickness]', 'style'=>'margin-left:-90px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly','value'=>'0'));											
					?>	
				</div>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'last_csm_add3','name'=>'ListDetail3[6][last_cost]', 'style'=>'margin-left:-80px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly','value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1 kghide' style='text-align:left; margin-left:-100px; margin-top: 6px;'>Kg</label>
			</div>
			<div class='form-group row'>		 	 
				<label class='label-control col-sm-2'><b></b></label>
				<div class='col-sm-3'>              
					<select name='id_material' id='mid_mtl_resin34' class='form-control input-sm' disabled>
					<option value=''>Select An Resin</option>
					<?php
						foreach($ListResin AS $val => $valx){
							echo "<option value='".$valx['id_material']."'>".strtoupper($valx['nm_material'])."</option>";
						}
						echo "<option value='MTL-1903000'>NONE MATERIAL</option>";
					 ?>
					</select>
					<input type='text' name='ListDetail3[7][last_full]' class='HideCost' id='hasil_resin34' value='0'>
					<!--<input type='text' name='ListDetail3[7][containing]' class='HideCost' id='layer_resin34' value='2.333'>-->
					<input type='text' name='ListDetail3[7][id_material]' class='HideCost' id='layer_resin34hide'>					
				</div>
				<label class='col-sm-2' style='text-align:left; margin-top: 6px;'><u>Rs.Containing</u></label>
				<div class='col-sm-1'>              
					
				</div>
				<label class='col-sm-1' style='text-align:left; margin-left:-130px; margin-top: 6px;'></label>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'layer_resin34','name'=>'ListDetail3[7][containing]', 'style'=>'margin-left:-90px;width: 50px;','class'=>'form-control input-sm numberOnly','autocomplete'=>'off', 'readonly'=>'readonly', 'value'=>'0'));											
					?>
				</div>
				<label class='col-sm-2' style='text-align:left; margin-left: -130px; margin-top: 6px;'></label>
				<div class='col-sm-1'>              
					
				</div>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'last_resin34','name'=>'ListDetail3[7][last_cost]', 'style'=>'margin-left:-80px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1 kghide' style='text-align:left; margin-left:-100px; margin-top: 6px;'>Kg</label>
			</div>
			<div class='form-group row'>		 	 
				<label class='label-control col-sm-2'><b>TOTAL RESIN<span class='text-red'>*</span></b></label>
				<div class='col-sm-3'>              
					<select name='ListDetail3[8][id_material]' id='mid_mtl_resin_tot3' class='form-control input-sm'>
					<option value=''>Select An Resin</option>
					<?php
						foreach($ListResin AS $val => $valx){
							echo "<option value='".$valx['id_material']."'>".strtoupper($valx['nm_material'])."</option>";
						}
						echo "<option value='MTL-1903000'>NONE MATERIAL</option>";
					 ?>
					</select>
					<input type='text' name='ListDetail3[8][last_full]' class='HideCost' id='hasil_resin_tot3' value='0'>
					<!--<input type='text' name='ListDetail3[8][id_material]' class='HideCost' id='layer_resin35hide'>-->
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
						echo form_input(array('id'=>'last_resin_tot3','name'=>'ListDetail3[8][last_cost]', 'style'=>'margin-left:-80px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1 kghide' style='text-align:left; margin-left:-100px; margin-top: 6px;'>Kg</label>
			</div>
			<div class='form-group row'>
				<label class='col-sm-2' style='text-align:left; margin-top: 6px;'></label>
				
				<label class='label-control col-sm-1'><b>Katalis<span class='text-red'>*</span></b></label>
				<div class='col-sm-3'>              
					<select name='ListDetailPlus3[0][id_material]' id='mid_mtl_katalis3' class='form-control input-sm'>
						<option value=''>Select An Katalis</option>
					<?php
						foreach($ListMatKatalis AS $val => $valx){
							echo "<option value='".$valx['id_material']."'>".strtoupper($valx['nm_material'])."</option>";
						}
						echo "<option value='MTL-1903000'>NONE MATERIAL</option>";
					 ?>
					</select>
					<input type='text' name='ListDetailPlus3[0][last_full]' class='HideCost' id='hasil_katalis3' value='0'>
					<!--
					<input type='text' name='ListDetailPlus3[0][containing]' class='HideCost' id='layer_katalis3' value='0'>
					<input type='text' name='ListDetailPlus3[0][perse]' class='HideCost' id='persen_katalis3' value='0.02'>
					-->
				</div>
				
				<label class='col-sm-1' style='text-align:left; margin-left: 0px; margin-top: 6px;'>Comparison</label>
				<div class='col-sm-2'>              
					<input type='text' name='ListDetailPlus3[0][containing]' style='width:50px; margin-left:12px;' class='form-control input-sm numberOnly' readonly='readonly' id='layer_katalis3' value='0'>	
				</div>
				<label class='col-sm-2' style='text-align:left; margin-left: -129px; margin-top: 6px;'>Percent</label>
				<div class='col-sm-1'>              
					<input type='text' name='ListDetailPlus3[0][perse]' style='margin-left:-92px;' class='form-control input-sm numberOnly' id='persen_katalis3' value='2'>	
				</div>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'last_katalis3','name'=>'ListDetailPlus3[0][last_cost]', 'style'=>'margin-left:-81px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1 kghide' style='text-align:left; margin-left:-101px; margin-top: 6px;'>Kg</label>
			</div>
			<div class='form-group row'>
				<label class='col-sm-2' style='text-align:left; margin-top: 6px;'></label>
				
				<label class='label-control col-sm-1'><b>SM<span class='text-red'>*</span></b></label>
				<div class='col-sm-3'>              
					<select name='ListDetailPlus3[1][id_material]' id='mid_mtl_sm3' class='form-control input-sm'>
						<option value=''>Select An SM</option>
					<?php
						foreach($ListMatSm AS $val => $valx){
							echo "<option value='".$valx['id_material']."'>".strtoupper($valx['nm_material'])."</option>";
						}
						echo "<option value='MTL-1903000'>NONE MATERIAL</option>";
					 ?>
					</select>
					<input type='text' name='ListDetailPlus3[1][last_full]' class='HideCost' id='hasil_sm3' value='0'>
					<!--
					<input type='text' name='ListDetailPlus3[1][containing]' class='HideCost' id='layer_sm3' value='0'>
					<input type='text' name='ListDetailPlus3[1][perse]' class='HideCost' id='persen_sm3' value='0.02'>
					-->
				</div>
				
				<label class='col-sm-1' style='text-align:left; margin-left: 0px; margin-top: 6px;'>Comparison</label>
				<div class='col-sm-2'>              
					<input type='text' name='ListDetailPlus3[1][containing]' style='width:50px; margin-left:12px;' class='form-control input-sm numberOnly' readonly='readonly' id='layer_sm3' value='0'>	
				</div>
				<label class='col-sm-2' style='text-align:left; margin-left: -129px; margin-top: 6px;'>Percent</label>
				<div class='col-sm-1'>              
					<input type='text' name='ListDetailPlus3[1][perse]' style='margin-left:-92px;' class='form-control input-sm numberOnly' id='persen_sm3' value='2'>	
				</div>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'last_sm3','name'=>'ListDetailPlus3[1][last_cost]', 'style'=>'margin-left:-81px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1 kghide' style='text-align:left; margin-left:-101px; margin-top: 6px;'>Kg</label>
			</div>
			<div class='form-group row'>
				<label class='col-sm-2' style='text-align:left; margin-top: 6px;'></label>
				
				<label class='label-control col-sm-1'><b>Cobalt<span class='text-red'>*</span></b></label>
				<div class='col-sm-3'>              
					<select name='ListDetailPlus3[2][id_material]' id='mid_mtl_cobalt3' class='form-control input-sm'>
						<option value=''>Select An Cobalt</option>
					<?php
						foreach($ListMatCobalt AS $val => $valx){
							echo "<option value='".$valx['id_material']."' >".strtoupper($valx['nm_material'])."</option>";
						}
						echo "<option value='MTL-1903000'>NONE MATERIAL</option>";
					 ?>
					</select>
					<input type='text' name='ListDetailPlus3[2][last_full]' class='HideCost' id='hasil_coblat3' value='0'>
					<!--
					<input type='text' name='ListDetailPlus3[2][containing]' class='HideCost' id='layer_coblat3' value='0'>
					<input type='text' name='ListDetailPlus3[2][perse]' class='HideCost' id='persen_coblat3' value='0.002'>
					-->
				</div>
				
				<label class='col-sm-1' style='text-align:left; margin-left: 0px; margin-top: 6px;'>Comparison</label>
				<div class='col-sm-2'>              
					<input type='text' name='ListDetailPlus3[2][containing]' style='width:50px; margin-left:12px;' class='form-control input-sm numberOnly' readonly='readonly' id='layer_coblat3' value='0'>	
				</div>
				<label class='col-sm-2' style='text-align:left; margin-left: -129px; margin-top: 6px;'>Percent</label>
				<div class='col-sm-1'>              
					<input type='text' name='ListDetailPlus3[2][perse]' style='margin-left:-92px;' class='form-control input-sm numberOnly' id='persen_coblat3' value='0.2'>	
				</div>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'last_cobalt3','name'=>'ListDetailPlus3[2][last_cost]', 'style'=>'margin-left:-81px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1 kghide' style='text-align:left; margin-left:-101px; margin-top: 6px;'>Kg</label>
			</div>
			<div class='form-group row'>
				<label class='col-sm-2' style='text-align:left; margin-top: 6px;'></label>
				
				<label class='label-control col-sm-1'><b>DMA<span class='text-red'>*</span></b></label>
				<div class='col-sm-3'>              
					<select name='ListDetailPlus3[3][id_material]' id='mid_mtl_dma3' class='form-control input-sm'>
						<option value=''>Select An DMA</option>
					<?php
						foreach($ListMatDma AS $val => $valx){
							echo "<option value='".$valx['id_material']."'>".strtoupper($valx['nm_material'])."</option>";
						}
						echo "<option value='MTL-1903000'>NONE MATERIAL</option>";
					 ?>
					</select>
					<input type='text' name='ListDetailPlus3[3][last_full]' class='HideCost' id='hasil_dma3' value='0'>
					<!--
					<input type='text' name='ListDetailPlus3[3][containing]' class='HideCost' id='layer_dma3' value='0'>
					<input type='text' name='ListDetailPlus3[3][perse]' class='HideCost' id='persen_dma3' value='0.002'>
					-->					
				</div>
				
				<label class='col-sm-1' style='text-align:left; margin-left: 0px; margin-top: 6px;'>Comparison</label>
				<div class='col-sm-2'>              
					<input type='text' name='ListDetailPlus3[3][containing]' style='width:50px; margin-left:12px;' class='form-control input-sm numberOnly' readonly='readonly' id='layer_dma3' value='0'>	
				</div>
				<label class='col-sm-2' style='text-align:left; margin-left: -129px; margin-top: 6px;'>Percent</label>
				<div class='col-sm-1'>              
					<input type='text' name='ListDetailPlus3[3][perse]' style='margin-left:-92px;' class='form-control input-sm numberOnly' id='persen_dma3' value='0.2'>	
				</div>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'last_dma3','name'=>'ListDetailPlus3[3][last_cost]', 'style'=>'margin-left:-81px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1 kghide' style='text-align:left; margin-left:-101px; margin-top: 6px;'>Kg</label>
			</div>
			<div class='form-group row'>
				<label class='col-sm-2' style='text-align:left; margin-top: 6px;'></label>
				
				<label class='label-control col-sm-1'><b>Hydroquinone<span class='text-red'>*</span></b></label>
				<div class='col-sm-3'>              
					<select name='ListDetailPlus3[4][id_material]' id='mid_mtl_hydro3' class='form-control input-sm'>
						<option value=''>Select An Hydroquinone</option>
					<?php
						foreach($ListMatHydo AS $val => $valx){
							echo "<option value='".$valx['id_material']."' >".strtoupper($valx['nm_material'])."</option>";
						}
						echo "<option value='MTL-1903000'>NONE MATERIAL</option>";
					 ?>
					</select>
					<input type='text' name='ListDetailPlus3[4][last_full]' class='HideCost' id='hasil_hydroquinone3' value='0'>
					<!--
					<input type='text' name='ListDetailPlus3[4][containing]' class='HideCost' id='layer_hydroquinone3' value='0'>
					<input type='text' name='ListDetailPlus3[4][perse]' class='HideCost' id='persen_hydroquinone3' value='0.0005'>
					-->
				</div>
				
				<label class='col-sm-1' style='text-align:left; margin-left: 0px; margin-top: 6px;'>Comparison</label>
				<div class='col-sm-2'>              
					<input type='text' name='ListDetailPlus3[4][containing]' style='width:50px; margin-left:12px;' class='form-control input-sm numberOnly' readonly='readonly' id='layer_hydroquinone3' value='0'>	
				</div>
				<label class='col-sm-2' style='text-align:left; margin-left: -129px; margin-top: 6px;'>Percent</label>
				<div class='col-sm-1'>              
					<input type='text' name='ListDetailPlus3[4][perse]' style='margin-left:-92px;' class='form-control input-sm numberOnly' id='persen_hydroquinone3' value='0.05'>	
				</div>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'last_hidro3','name'=>'ListDetailPlus3[4][last_cost]', 'style'=>'margin-left:-81px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1 kghide' style='text-align:left; margin-left:-101px; margin-top: 6px;'>Kg</label>
			</div>
			<div class='form-group row'>
				<label class='col-sm-2' style='text-align:left; margin-top: 6px;'></label>
				
				<label class='label-control col-sm-1'><b>Methanol<span class='text-red'>*</span></b></label>
				<div class='col-sm-3'>              
					<select name='ListDetailPlus3[5][id_material]' id='mid_mtl_methanol3' class='form-control input-sm'>
						<option value=''>Select An Methanol</option>
					<?php
						foreach($ListMatMethanol AS $val => $valx){
							echo "<option value='".$valx['id_material']."' >".strtoupper($valx['nm_material'])."</option>";
						}
						echo "<option value='MTL-1903000'>NONE MATERIAL</option>";
					 ?>
					</select>
					<input type='text' name='ListDetailPlus3[5][last_full]' class='HideCost' id='hasil_methanol3' value='0'>
					<!--
					<input type='text' name='ListDetailPlus3[5][containing]' class='HideCost' id='layer_methanol3' value='0'>
					<input type='text' name='ListDetailPlus3[5][perse]' class='HideCost' id='persen_methanol3' value='0.0005'>
					-->
				</div>
				
				<label class='col-sm-1' style='text-align:left; margin-left: 0px; margin-top: 6px;'>Comparison</label>
				<div class='col-sm-2'>              
					<input type='text' name='ListDetailPlus3[5][containing]' style='width:50px; margin-left:12px;' class='form-control input-sm numberOnly' readonly='readonly' id='layer_methanol3' value='0'>	
				</div>
				<label class='col-sm-2' style='text-align:left; margin-left: -129px; margin-top: 6px;'>Percent</label>
				<div class='col-sm-1'>              
					<input type='text' name='ListDetailPlus3[5][perse]' style='margin-left:-92px;' class='form-control input-sm numberOnly' id='persen_methanol3' value='0.05'>	
				</div>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'last_methanol3','name'=>'ListDetailPlus3[5][last_cost]', 'style'=>'margin-left:-81px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1 kghide' style='text-align:left; margin-left:-101px; margin-top: 6px;'>Kg</label>
			</div>
			<!--
			<div class='form-group row'>		 	 
				<label class='label-control col-sm-2'><b>Additive</b></label>
				<div class='col-sm-4'>              
					<select name='ListDetailPlus3[6][id_material]' id='mid_mtl_additive3' class='form-control input-sm'>
						<option value=''>Select An Additive</option>
					<?php
						// foreach($ListMatAdditive AS $val => $valx){
							// echo "<option value='".$valx['id_material']."' >".strtoupper($valx['nm_material'])."</option>";
						// }
					 ?>
					</select>
					<input type='text' name='ListDetailPlus3[6][last_full]' class='HideCost' id='hasil_additive3' value='0'>
					<!--
					<input type='text' name='ListDetailPlus3[6][containing]' class='HideCost' id='layer_additive3' value='0'>
					<input type='text' name='ListDetailPlus3[6][perse]' class='HideCost' id='persen_additive3' value='0'>
					-->
				<!--
				</div>
				
				<label class='col-sm-1' style='text-align:left; margin-left: 0px; margin-top: 6px;'>Comparison</label>
				<div class='col-sm-2'>              
					<input type='text' name='ListDetailPlus3[6][containing]' style='width:50px; margin-left:12px;' class='form-control input-sm numberOnly' readonly='readonly' id='layer_additive3' value='0'>	
				</div>
				<label class='col-sm-2' style='text-align:left; margin-left: -129px; margin-top: 6px;'>Percent</label>
				<div class='col-sm-1'>              
					<input type='text' name='ListDetailPlus3[6][perse]' style='margin-left:-92px;' class='form-control input-sm numberOnly' id='persen_additive3' value='0'>	
				</div>
				<div class='col-sm-1'>              
					<?php
						//echo form_input(array('id'=>'last_additive3','name'=>'ListDetailPlus3[6][last_cost]', 'style'=>'margin-left:-81px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1 kghide' style='text-align:left; margin-left:-101px; margin-top: 6px;'>Kg</label>
			</div>
			<!-- Add Material-->
			<button type='button' name='add_external' id='add_external' class='btn btn-success btn-sm' style='width:150px; margin-left: 10px;'>Add Material</button>
			<input type='hidden' name='numberMax_external' id='numberMax_external' value='0'>
			
			<div class="box-body" style="">
				<table id="my-grid_external" class="table table-striped table-bordered table-hover table-condensed" width="100%">
					<tbody id='detail_body_external'>
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
				<label class='col-sm-2' style='text-align:left; margin-left: -50px; margin-top: 6px;'>Total External Thickness</label>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'tot_lin_thickness3','name'=>'tot_lin_thickness3', 'style'=>'margin-left:-50px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
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
				<label class='col-sm-2' style='text-align:left; margin-left: -50px; margin-top: 6px;'>Min External Thickness</label>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'mix_lin_thickness3','name'=>'mix_lin_thickness3', 'style'=>'margin-left:-50px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
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
				<label class='col-sm-2' style='text-align:left; margin-left: -50px; margin-top: 6px;'>Max External Thickness</label>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'max_lin_thickness3','name'=>'max_lin_thickness3', 'style'=>'margin-left:-50px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
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
						echo form_input(array('id'=>'hasil_linier_thickness3','name'=>'hasil_linier_thickness3', 'style'=>'margin-left:-50px; height: 40px;','class'=>'form-control input-sm HasilKet','autocomplete'=>'off','readonly'=>'readonly','value'=>'OK'));											
					?>	
				</div>
				
				<label class='col-sm-1' style='text-align:left; margin-left:-100px; margin-top: 6px;'></label>
			</div>
			<!-- ====================================================================================================== -->
			<!-- ========================================END EXTERNAL LAYER THICKNESS================================== -->
			<!-- ====================================================================================================== -->
			
			<!-- ====================================================================================================== -->
			<!-- ==========================================TOPCOAT==================================== -->
			<!-- ====================================================================================================== -->
			<div class='headerTitle'>TOPCOAT</div>
				<input type='text' name='detail_name4' id='detail_name4'  class='HideCost' value='TOPCOAT'>
			<div class='form-group row'>		 	 
				<label class='label-control col-sm-2'><b>RESIN<span class='text-red'>*</span></b></label>
				<div class='col-sm-3'>              
					<select name='ListDetailPlus4[0][id_material]' id='mid_mtl_resin41' class='form-control input-sm'>
					<option value=''>Select An Resin</option>
					<?php
						foreach($ListResin AS $val => $valx){
							echo "<option value='".$valx['id_material']."'>".strtoupper($valx['nm_material'])."</option>";
						}
						echo "<option value='MTL-1903000'>NONE MATERIAL</option>";
					 ?>
					</select>
					<input type='text' name='ListDetailPlus4[0][last_full]' class='HideCost' id='hasil_resin41' value='0'>
					<input type='text' name='ListDetailPlus4[0][perse]' class='HideCost' id='resin41' value='0.3'>
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
						echo form_input(array('id'=>'last_resin41','name'=>'ListDetailPlus4[0][last_cost]', 'style'=>'margin-left:-80px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1 kghide' style='text-align:left; margin-left:-100px; margin-top: 6px;'>Kg</label>
			</div>
			<div class='form-group row'>
				<label class='col-sm-2' style='text-align:left; margin-top: 6px;'></label>
				
				<label class='label-control col-sm-1'><b>Katalis<span class='text-red'>*</span></b></label>
				<div class='col-sm-3'>              
					<select name='ListDetailPlus4[1][id_material]' id='mid_mtl_katalis4' class='form-control input-sm'>
						<option value=''>Select An Katalis</option>
					<?php
						foreach($ListMatKatalis AS $val => $valx){
							echo "<option value='".$valx['id_material']."'>".strtoupper($valx['nm_material'])."</option>";
						}
						echo "<option value='MTL-1903000'>NONE MATERIAL</option>";
					 ?>
					</select>
					<input type='text' name='ListDetailPlus4[1][last_full]' class='HideCost' id='hasil_katalis4' value='0'>
					<!--
					<input type='text' name='ListDetailPlus4[1][containing]' class='HideCost' id='layer_katalis4' value='0'>
					<input type='text' name='ListDetailPlus4[1][perse]' class='HideCost' id='persen_katalis4' value='0.02'>
					-->
				</div>
				
				<label class='col-sm-1' style='text-align:left; margin-left: 0px; margin-top: 6px;'>Comparison</label>
				<div class='col-sm-2'>              
					<input type='text' name='ListDetailPlus4[1][containing]' style='width:50px; margin-left:12px;' class='form-control input-sm numberOnly' readonly='readonly' id='layer_katalis4' value='0'>	
				</div>
				<label class='col-sm-2' style='text-align:left; margin-left: -129px; margin-top: 6px;'>Percent</label>
				<div class='col-sm-1'>              
					<input type='text' name='ListDetailPlus4[1][perse]' style='margin-left:-92px;' class='form-control input-sm numberOnly' id='persen_katalis4' value='2'>	
				</div>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'last_katalis4','name'=>'ListDetailPlus4[1][last_cost]', 'style'=>'margin-left:-81px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1 kghide' style='text-align:left; margin-left:-101px; margin-top: 6px;'>Kg</label>
			</div>
			<div class='form-group row'>
				<label class='col-sm-2' style='text-align:left; margin-top: 6px;'></label>
				
				<label class='label-control col-sm-1'><b>Color<span class='text-red'>*</span></b></label>
				<div class='col-sm-3'>              
					<select name='ListDetailPlus4[2][id_material]' id='mid_mtl_color4' class='form-control input-sm'>
						<option value=''>Select An Color</option>
					<?php
						foreach($ListMatColor AS $val => $valx){
							echo "<option value='".$valx['id_material']."'>".strtoupper($valx['nm_material'])."</option>";
						}
						echo "<option value='MTL-1903000'>NONE MATERIAL</option>";
					 ?>
					</select>
					<input type='text' name='ListDetailPlus4[2][last_full]' class='HideCost' id='hasil_color4' value='0'>
					<!--
					<input type='text' name='ListDetailPlus4[2][containing]' class='HideCost' id='layer_color4' value='0'>
					<input type='text' name='ListDetailPlus4[2][perse]' class='HideCost' id='persen_color4' value='0.05'>
					-->					
				</div>
				
				<label class='col-sm-1' style='text-align:left; margin-left: 0px; margin-top: 6px;'>Comparison</label>
				<div class='col-sm-2'>              
					<input type='text' name='ListDetailPlus4[2][containing]' style='width:50px; margin-left:12px;' class='form-control input-sm numberOnly' readonly='readonly' id='layer_color4' value='0'>	
				</div>
				<label class='col-sm-2' style='text-align:left; margin-left: -129px; margin-top: 6px;'>Percent</label>
				<div class='col-sm-1'>              
					<input type='text' name='ListDetailPlus4[2][perse]' style='margin-left:-92px;' class='form-control input-sm numberOnly' id='persen_color4' value='5'>	
				</div>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'last_color4','name'=>'ListDetailPlus4[2][last_cost]', 'style'=>'margin-left:-81px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1 kghide' style='text-align:left; margin-left:-101px; margin-top: 6px;'>Kg</label>
			</div>
			<div class='form-group row'>
				<label class='col-sm-2' style='text-align:left; margin-top: 6px;'></label>
				
				<label class='label-control col-sm-1'><b>Tinuvin<span class='text-red'>*</span></b></label>
				<div class='col-sm-3'>              
					<select name='ListDetailPlus4[3][id_material]' id='mid_mtl_tin4' class='form-control input-sm'>
						<option value=''>Select An Tinuvin</option>
					<?php
						foreach($ListMatTinuvin AS $val => $valx){
							echo "<option value='".$valx['id_material']."' >".strtoupper($valx['nm_material'])."</option>";
						}
						echo "<option value='MTL-1903000'>NONE MATERIAL</option>";
					 ?>
					</select>
					<input type='text' name='ListDetailPlus4[3][last_full]' class='HideCost' id='hasil_tin4' value='0'>
					<!--
					<input type='text' name='ListDetailPlus4[3][containing]' class='HideCost' id='layer_tin4' value='0'>
					<input type='text' name='ListDetailPlus4[3][perse]' class='HideCost' id='persen_tin4' value='0.026'>
					-->
				</div>
				
				<label class='col-sm-1' style='text-align:left; margin-left: 0px; margin-top: 6px;'>Comparison</label>
				<div class='col-sm-2'>              
					<input type='text' name='ListDetailPlus4[3][containing]' style='width:50px; margin-left:12px;' class='form-control input-sm numberOnly' readonly='readonly' id='layer_tin4' value='0'>	
				</div>
				<label class='col-sm-2' style='text-align:left; margin-left: -129px; margin-top: 6px;'>Percent</label>
				<div class='col-sm-1'>              
					<input type='text' name='ListDetailPlus4[3][perse]' style='margin-left:-92px;' class='form-control input-sm numberOnly' id='persen_tin4' value='2.6'>	
				</div>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'last_tin4','name'=>'ListDetailPlus4[3][last_cost]', 'style'=>'margin-left:-81px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1 kghide' style='text-align:left; margin-left:-101px; margin-top: 6px;'>Kg</label>
			</div>
			<div class='form-group row'>
				<label class='col-sm-2' style='text-align:left; margin-top: 6px;'></label>
				
				<label class='label-control col-sm-1'><b>Chlroroform<span class='text-red'>*</span></b></label>
				<div class='col-sm-3'>              
					<select name='ListDetailPlus4[4][id_material]' id='mid_mtl_chl4' class='form-control input-sm'>
						<option value=''>Select An Chlroroform</option>
					<?php
						foreach($ListMatChl AS $val => $valx){
							echo "<option value='".$valx['id_material']."'>".strtoupper($valx['nm_material'])."</option>";
						}
						echo "<option value='MTL-1903000'>NONE MATERIAL</option>"; 
					 ?>
					</select>
					<input type='text' name='ListDetailPlus4[4][last_full]' class='HideCost' id='hasil_chl4' value='0'>
					<!--
					<input type='text' name='ListDetailPlus4[4][containing]' class='HideCost' id='layer_chl4' value='0'>
					<input type='text' name='ListDetailPlus4[4][perse]' class='HideCost' id='persen_chl4' value='0.026'>
					-->
				</div>
				
				<label class='col-sm-1' style='text-align:left; margin-left: 0px; margin-top: 6px;'>Comparison</label>
				<div class='col-sm-2'>              
					<input type='text' name='ListDetailPlus4[4][containing]' style='width:50px; margin-left:12px;' class='form-control input-sm numberOnly' readonly='readonly' id='layer_chl4' value='0'>	
				</div>
				<label class='col-sm-2' style='text-align:left; margin-left: -129px; margin-top: 6px;'>Percent</label>
				<div class='col-sm-1'>              
					<input type='text' name='ListDetailPlus4[4][perse]' style='margin-left:-92px;' class='form-control input-sm numberOnly' id='persen_chl4' value='2.6'>	
				</div>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'last_chl4','name'=>'ListDetailPlus4[4][last_cost]', 'style'=>'margin-left:-81px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1 kghide' style='text-align:left; margin-left:-101px; margin-top: 6px;'>Kg</label>
			</div>
			<div class='form-group row'>
				<label class='col-sm-2' style='text-align:left; margin-top: 6px;'></label>
				
				<label class='label-control col-sm-1'><b>SM<span class='text-red'>*</span></b></label>
				<div class='col-sm-3'>              
					<select name='ListDetailPlus4[5][id_material]' id='mid_mtl_stery4' class='form-control input-sm'>
						<option value=''>Select An SM</option>
					<?php
						foreach($ListMatStery AS $val => $valx){
							echo "<option value='".$valx['id_material']."' >".strtoupper($valx['nm_material'])."</option>";
						}
						echo "<option value='MTL-1903000'>NONE MATERIAL</option>";
					 ?>
					</select>
					<input type='text' name='ListDetailPlus4[5][last_full]' class='HideCost' id='hasil_stery4' value='0'>
					<!--
					<input type='text' name='ListDetailPlus4[5][containing]' class='HideCost' id='layer_stery4' value='0'>
					<input type='text' name='ListDetailPlus4[5][perse]' class='HideCost' id='persen_stery4' value='0.03'>
					-->
				</div>
				
				<label class='col-sm-1' style='text-align:left; margin-left: 0px; margin-top: 6px;'>Comparison</label>
				<div class='col-sm-2'>              
					<input type='text' name='ListDetailPlus4[5][containing]' style='width:50px; margin-left:12px;' class='form-control input-sm numberOnly' readonly='readonly' id='layer_stery4' value='0'>	
				</div>
				<label class='col-sm-2' style='text-align:left; margin-left: -129px; margin-top: 6px;'>Percent</label>
				<div class='col-sm-1'>              
					<input type='text' name='ListDetailPlus4[5][perse]' style='margin-left:-92px;' class='form-control input-sm numberOnly' id='persen_stery4' value='3'>	
				</div>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'last_stery4','name'=>'ListDetailPlus4[5][last_cost]', 'style'=>'margin-left:-81px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1 kghide' style='text-align:left; margin-left:-101px; margin-top: 6px;'>Kg</label>
			</div>
			<div class='form-group row'>
				<label class='col-sm-2' style='text-align:left; margin-top: 6px;'></label>
				
				<label class='label-control col-sm-1'><b>Solution Wax<span class='text-red'>*</span></b></label>
				<div class='col-sm-3'>              
					<select name='ListDetailPlus4[6][id_material]' id='mid_mtl_wax4' class='form-control input-sm'>
						<option value=''>Select An Solution Wax</option>
					<?php
						foreach($ListMatWax AS $val => $valx){
							echo "<option value='".$valx['id_material']."' >".strtoupper($valx['nm_material'])."</option>";
						}
						echo "<option value='MTL-1903000'>NONE MATERIAL</option>";
					 ?>
					</select>
					<input type='text' name='ListDetailPlus4[6][last_full]' class='HideCost' id='hasil_wax4' value='0'>
					<!--
					<input type='text' name='ListDetailPlus4[6][containing]' class='HideCost' id='layer_wax4' value='0'>
					<input type='text' name='ListDetailPlus4[6][perse]' class='HideCost' id='persen_wax4' value='0.03'>
					-->
				</div>
				
				<label class='col-sm-1' style='text-align:left; margin-left: 0px; margin-top: 6px;'>Comparison</label>
				<div class='col-sm-2'>              
					<input type='text' name='ListDetailPlus4[6][containing]' style='width:50px; margin-left:12px;' class='form-control input-sm numberOnly' readonly='readonly' id='layer_wax4' value='0'>	
				</div>
				<label class='col-sm-2' style='text-align:left; margin-left: -129px; margin-top: 6px;'>Percent</label>
				<div class='col-sm-1'>              
					<input type='text' name='ListDetailPlus4[6][perse]' style='margin-left:-92px;' class='form-control input-sm numberOnly' id='persen_wax4' value='3'>	
				</div>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'last_wax4','name'=>'ListDetailPlus4[6][last_cost]', 'style'=>'margin-left:-81px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1 kghide' style='text-align:left; margin-left:-101px; margin-top: 6px;'>Kg</label>
			</div>
			<div class='form-group row'>
				<label class='col-sm-2' style='text-align:left; margin-top: 6px;'></label>
				
				<label class='label-control col-sm-1'><b>Methelene Chlorida<span class='text-red'>*</span></b></label>
				<div class='col-sm-3'>              
					<select name='ListDetailPlus4[7][id_material]' id='mid_mtl_mch4' class='form-control input-sm'>
						<option value=''>Select An Methelene Chlorida</option>
					<?php
						foreach($ListMatMchl AS $val => $valx){
							echo "<option value='".$valx['id_material']."' >".strtoupper($valx['nm_material'])."</option>";
						}
						echo "<option value='MTL-1903000'>NONE MATERIAL</option>";
					 ?>
					</select>
					<input type='text' name='ListDetailPlus4[7][last_full]' class='HideCost' id='hasil_mch4' value='0'>
					<!--
					<input type='text' name='ListDetailPlus4[7][containing]' class='HideCost' id='layer_mch4' value='0'>
					<input type='text' name='ListDetailPlus4[7][perse]' class='HideCost' id='persen_mch4' value='0.00'>
					-->
				</div>
				
				<label class='col-sm-1' style='text-align:left; margin-left: 0px; margin-top: 6px;'>Comparison</label>
				<div class='col-sm-2'>              
					<input type='text' name='ListDetailPlus4[7][containing]' style='width:50px; margin-left:12px;' class='form-control input-sm numberOnly' readonly='readonly' id='layer_mch4' value='0'>	
				</div>
				<label class='col-sm-2' style='text-align:left; margin-left: -129px; margin-top: 6px;'>Percent</label>
				<div class='col-sm-1'>              
					<input type='text' name='ListDetailPlus4[7][perse]' style='margin-left:-92px;' class='form-control input-sm numberOnly' id='persen_mch4' value='0'>	
				</div>
				<div class='col-sm-1'>              
					<?php
						echo form_input(array('id'=>'last_mch4','name'=>'ListDetailPlus4[7][last_cost]', 'style'=>'margin-left:-81px;','class'=>'form-control input-sm','autocomplete'=>'off','readonly'=>'readonly', 'value'=>'0'));											
					?>	
				</div>
				<label class='col-sm-1 kghide' style='text-align:left; margin-left:-101px; margin-top: 6px;'>Kg</label>
			</div>
			<!-- Add Material-->
			<button type='button' name='add_topcoat' id='add_topcoat' class='btn btn-success btn-sm' style='width:150px; margin-left: 10px;'>Add Material</button>
			<input type='hidden' name='numberMax_topcoat' id='numberMax_topcoat' value='0'>
			
			<div class="box-body" style="">
				<table id="my-grid_topcoat" class="table table-striped table-bordered table-hover table-condensed" width="100%">
					<tbody id='detail_body_topcoat'>
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
				<label class='col-sm-2' style='text-align:left; margin-left: -50px; margin-top: 6px;'></label>
				<div class='col-sm-2' style='float:right;'>              
					<button type='button' name='simpan-bro' id='simpan-bro' class='btn btn-primary' style='width:100px;'>Save</button>	
				</div>
				
				<label class='col-sm-1' style='text-align:left; margin-left:-100px; margin-top: 6px;'></label>
			</div>
			<!-- ====================================================================================================== -->
			<!-- ===============================================END TOPCOAT============================================ -->
			<!-- ====================================================================================================== -->
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
		$('.ToleranSt').hide();
		$('#top_min_toleran').val('0.125');
		$('#top_max_toleran').val('0.125');
		
		$('.HideCost').hide();
		$('.Hide').hide();
		$('#mirror').hide();
		
		$(document).on('click', '#setResin', function(e){
			e.preventDefault();
			$("#head_title").html("<b>SET RESIN CONTAINING [COOMING SOON]</b>");
			$("#view").load(base_url +'index.php/'+ active_controller+'/modalSetResin/');
			$("#ModalView").modal();
		});
		
		$(document).on('change', '#type_elbow', function(){
			if($('#top_diameter').val() == '' || $('#top_diameter').val() == null || $('#top_diameter').val() == '0'){
				swal({
				  title	: "Error Message!",
				  text	: 'Type Elbow belum dipilih ...',
				  type	: "warning"
				});
				return false;
			}
			else{
				if($(this).val() == 'SR'){
					var Hsr	= parseFloat($('#top_diameter').val()) * 1;
					var angle = parseFloat($('#angle').val());
					$('#radius').val(Hsr);
					
					length_mitter(Hsr, angle);
				}
				if($(this).val() == 'LR'){
					var Hlr	= parseFloat($('#top_diameter').val()) * 1.5;
					var angle = parseFloat($('#angle').val());
					$('#radius').val(Hlr);
					
					length_mitter(Hlr, angle);
				}
				if($(this).val() == 0){
					$('#radius').val('0');
					
					length_mitter(0, 0);
				}
			}
		});
		
		$(document).on('keyup', '#angle', function(e){
			e.preventDefault();
			var radius	= parseFloat($('#radius').val());
			var angle = parseFloat($(this).val());
			
			length_mitter(radius, angle);
		});
		
		$(document).on('change', '#external_layer', function(){
			if($(this).val() == 'N'){ 
				$("#mid_mtl_veil3 option:selected").val('MTL-1903000').html('NONE MATERIAL').trigger("chosen:updated");
				$("#layer_resin31hide").val('MTL-1903000');
				$("#layer_veil3").val('0');
				
				$("#mid_mtl_veil_add3 option:selected").val('MTL-1903000').html('NONE MATERIAL').trigger("chosen:updated");
				$("#layer_resin32hide").val('MTL-1903000');
				$("#layer_veil_add3").val('0');
				
				$("#mid_mtl_matcsm3 option:selected").val('MTL-1903000').html('NONE MATERIAL').trigger("chosen:updated");
				$("#layer_resin33hide").val('MTL-1903000');
				$("#layer_matcsm3").val('0');
				
				$("#mid_mtl_csm_add3 option:selected").val('MTL-1903000').html('NONE MATERIAL').trigger("chosen:updated");
				$("#layer_resin34hide").val('MTL-1903000');
				$("#layer_csm_add3").val('0');
				
				$("#mid_mtl_resin_tot3 option:selected").val('MTL-1903000').html('NONE MATERIAL').trigger("chosen:updated");
				$("#mid_mtl_katalis3 option:selected").val('MTL-1903000').html('NONE MATERIAL').trigger("chosen:updated");
				$("#mid_mtl_sm3 option:selected").val('MTL-1903000').html('NONE MATERIAL').trigger("chosen:updated");
				$("#mid_mtl_cobalt3 option:selected").val('MTL-1903000').html('NONE MATERIAL').trigger("chosen:updated");
				$("#mid_mtl_dma3 option:selected").val('MTL-1903000').html('NONE MATERIAL').trigger("chosen:updated");
				$("#mid_mtl_hydro3 option:selected").val('MTL-1903000').html('NONE MATERIAL').trigger("chosen:updated");
				$("#mid_mtl_methanol3 option:selected").val('MTL-1903000').html('NONE MATERIAL').trigger("chosen:updated");
				$("#hasil_linier_thickness3").val('OK');
			}
			else{
				$("#mid_mtl_veil3 option:selected").html('Select An Veil').trigger("chosen:updated"); 
				$("#layer_resin31hide").val('');
				$("#layer_veil3").val('');
				
				$("#mid_mtl_veil_add3 option:selected").html('Select An Veil Add').trigger("chosen:updated"); 
				$("#layer_resin32hide").val('');
				$("#layer_veil_add3").val('');
				
				$("#mid_mtl_matcsm3 option:selected").html('Select An MAT/CSM').trigger("chosen:updated"); 
				$("#layer_resin33hide").val('');
				$("#layer_matcsm3").val('');
				
				$("#mid_mtl_csm_add3 option:selected").html('Select An MAT/CSM').trigger("chosen:updated"); 
				$("#layer_resin34hide").val('');
				$("#layer_csm_add3").val('');
				
				$("#mid_mtl_resin_tot3 option:selected").html('Select An Resin').trigger("chosen:updated"); 
				$("#mid_mtl_katalis3 option:selected").html('Select An Katalis').trigger("chosen:updated"); 
				$("#mid_mtl_sm3 option:selected").html('Select An SM').trigger("chosen:updated"); 
				$("#mid_mtl_cobalt3 option:selected").html('Select An Cobalt').trigger("chosen:updated"); 
				$("#mid_mtl_dma3 option:selected").html('Select An DMA').trigger("chosen:updated"); 
				$("#mid_mtl_hydro3 option:selected").html('Select An Hydroquinone').trigger("chosen:updated"); 
				$("#mid_mtl_methanol3 option:selected").html('Select An Methanol').trigger("chosen:updated"); 
				$("#hasil_linier_thickness3").val('');
			}
		});
		
		$(document).on('change', '#customer', function(e){
			e.preventDefault();
			$.ajax({
				url: base_url +'index.php/'+ active_controller+'/getTolerance',
				cache: false,
				type: "POST",
				data: "cust="+this.value,
				dataType: "json",
				success: function(data){
					$("#top_toleran").html(data.option).trigger("chosen:updated");
				}
			});
		});
		
		//Add Tambahan
		var nomor	= 1;
		
		$('#add_liner').click(function(e){
			e.preventDefault();
			AppendBaris_Liner(nomor);
			
			var nilaiAwal	= parseInt($("#numberMax_liner").val());
			var nilaiAkhir	= nilaiAwal + 1;
			$("#numberMax_liner").val(nilaiAkhir);
		});
		
		$('#add_strukture').click(function(e){
			e.preventDefault();
			AppendBaris_Strukture(nomor);
			
			var nilaiAwal	= parseInt($("#numberMax_strukture").val());
			var nilaiAkhir	= nilaiAwal + 1;
			$("#numberMax_strukture").val(nilaiAkhir);
		});
		
		$('#add_external').click(function(e){
			e.preventDefault();
			AppendBaris_External(nomor);
			
			var nilaiAwal	= parseInt($("#numberMax_external").val());
			var nilaiAkhir	= nilaiAwal + 1;
			$("#numberMax_external").val(nilaiAkhir);
		});
		
		$('#add_topcoat').click(function(e){
			e.preventDefault();
			AppendBaris_TopCoat(nomor);
			
			var nilaiAwal	= parseInt($("#numberMax_topcoat").val());
			var nilaiAkhir	= nilaiAwal + 1;
			$("#numberMax_topcoat").val(nilaiAkhir);
		});
		
		$(".numberOnly").on("keypress keyup blur",function (event) {    
			// $(this).val($(this).val().replace(/[^\d].+/, ""));
			if ((event.which < 48 || event.which > 57 ) && (event.which < 46 || event.which > 46 )) {
				event.preventDefault();
			}
			// if($(this).val() == ''){
				// $(this).val(0);
			// }
		});
	
		$(document).on('change', '#top_toleran', function(){
			if($(this).val() != 'C100-1903000'){
				$('.ToleranSt').show();
			}
			else{
				$('.ToleranSt').hide();	
				$('#top_min_toleran').val('0.125');
				$('#top_max_toleran').val('0.125');
			}
		});
		
		$(document).on('keyup', '#top_tebal_design', function(){
			
			var waste			= parseFloat($('#waste').val()) / 100;
			var top_diameter	= parseFloat($('#top_diameter').val());
			var top_thickness	= parseFloat($('#top_tebal_design').val());
			
			var panjang			= parseFloat($('#panjang').val());
			
			var acuhan_1		= parseFloat($('#acuhan_1').val());
			var acuhan_3		= parseFloat($('#acuhan_3').val());
			
			var hasilAch2		= top_thickness - (acuhan_1 + acuhan_3);
			// alert('Hay');
			$('#acuhan_2').val(hasilAch2.toFixed(2)); 
			
			//Liner Thickness
			var layer_veil1		= $("#layer_veil").val();
			var layer_veil2		= $("#layer_veil_add").val();
			var layer_veil3		= $("#layer_matcsm").val();
			var layer_veil4		= $("#layer_csm_add").val();
			var tot_thickness1	= parseFloat($('#tot_lin_thickness').val());
			
			//Struktur Thickness
			var layer1			= $("#layer_matcsm2").val();
			var layer2			= $("#layer_csm_add2").val();
			var layer3			= $("#layer_wr2").val();
			var layer4			= $("#layer_wr_add2").val();
			var layer5			= $("#layer_rooving21").val();
			var layer6			= $("#layer_rooving22").val();
			var tot_thickness2	= parseFloat($('#tot_lin_thickness2').val());
			
			//External Thickness
			var layer31			= $("#layer_veil3").val();
			var layer32			= $("#layer_veil_add3").val();
			var layer33			= $("#layer_matcsm3").val();
			var layer34			= $("#layer_csm_add3").val();
			var tot_thickness3	= parseFloat($('#tot_lin_thickness3').val());
			
			Hasil(tot_thickness1, layer_veil1, layer_veil2, layer_veil3, layer_veil4, top_diameter, top_thickness, waste, panjang);
			Hasil2(tot_thickness2, layer1, layer2, layer3, layer4, layer5, layer6, top_diameter, top_thickness, waste, panjang);
			Hasil3(tot_thickness3, layer31, layer32, layer33, layer34, top_diameter, top_thickness, waste, panjang);
			rubaharea();
		}); 
		
		$(document).on('change', '#top_typeList', function(e){
			// e.preventDefault();
			var id	= $(this).val();
			$.ajax({
				url: base_url +'index.php/'+active_controller+'/getDiameter',
				cache: false,
				type: "POST",
				data: "id="+$(this).val(),
				dataType: "json",
				success: function(data){
					$('#top_type').val(data.pipeN);
					$('#top_diameter').val(data.pipeD);
					
					var ThisD = data.pipeD;
					if(ThisD <= 450){
						var angkaRoving	= 32/68;
					}
					else if(ThisD > 450){  
						var angkaRoving	= 28/72;
					}
					else{
						var angkaRoving	= 0;
					}
					var angkaVeil	= 9/1;
					var angkaCsm	= 7/3;
					var angkaCsmStr	= 60/40;
					var angkaWr		= 45/55;
					
					
					//Rooving
					$('#layer_resin25').val(angkaRoving.toFixed(3));
					$('#layer_resin26').val(angkaRoving.toFixed(3));
					
					//Veil
					$('#layer_resin1').val(angkaVeil.toFixed(3));
					$('#layer_resin2').val(angkaVeil.toFixed(3));
					$('#layer_resin31').val(angkaVeil.toFixed(3));
					$('#layer_resin32').val(angkaVeil.toFixed(3));
					
					//CSM
					$('#layer_resin3').val(angkaCsm.toFixed(3));
					$('#layer_resin4').val(angkaCsm.toFixed(3));
					$('#layer_resin21').val(angkaCsmStr.toFixed(3));
					$('#layer_resin22').val(angkaCsmStr.toFixed(3));
					$('#layer_resin33').val(angkaCsm.toFixed(3));
					$('#layer_resin34').val(angkaCsm.toFixed(3));
					
					//WR
					$('#layer_resin23').val(angkaWr.toFixed(3));
					$('#layer_resin24').val(angkaWr.toFixed(3));
					
					var waste			= parseFloat($('#waste').val()) / 100;
					var top_diameter	= parseFloat($('#top_diameter').val());
					var top_thickness	= parseFloat($('#top_tebal_design').val());
					
					// var radius	= top_diameter/2;
					// $("#radius").val(radius.toFixed(1));
					  
					if($('#type_elbow').val() == 'SR'){
						var Hsr	= parseFloat($('#top_diameter').val()) * 1;
						var angle = parseFloat($('#angle').val());
						$('#radius').val(Hsr);
						
						length_mitter(Hsr, angle);
					}
					if($('#type_elbow').val() == 'LR'){
						var Hlr	= parseFloat($('#top_diameter').val()) * 1.5;
						var angle = parseFloat($('#angle').val());
						$('#radius').val(Hlr);
						
						length_mitter(Hlr, angle);
					}
					if($('#type_elbow').val() == 0){
						$('#radius').val('0');
						
						length_mitter(0, 0);
					}
					
					var panjang			= parseFloat($('#panjang').val());

					//Liner Thickness
					var layer_veil1		= $("#layer_veil").val();
					var layer_veil2		= $("#layer_veil_add").val();
					var layer_veil3		= $("#layer_matcsm").val();
					var layer_veil4		= $("#layer_csm_add").val();
					var tot_thickness1	= parseFloat($('#tot_lin_thickness').val());
					
					//Struktur Thickness
					var layer1			= $("#layer_matcsm2").val();
					var layer2			= $("#layer_csm_add2").val();
					var layer3			= $("#layer_wr2").val();
					var layer4			= $("#layer_wr_add2").val();
					var layer5			= $("#layer_rooving21").val();
					var layer6			= $("#layer_rooving22").val();
					var tot_thickness2	= parseFloat($('#tot_lin_thickness2').val());
					
					//External Thickness
					var layer31			= $("#layer_veil3").val();
					var layer32			= $("#layer_veil_add3").val();
					var layer33			= $("#layer_matcsm3").val();
					var layer34			= $("#layer_csm_add3").val();
					var tot_thickness3	= parseFloat($('#tot_lin_thickness3').val());
					
					
					Hasil(tot_thickness1, layer_veil1, layer_veil2, layer_veil3, layer_veil4, top_diameter, top_thickness, waste, panjang);
					Hasil2(tot_thickness2, layer1, layer2, layer3, layer4, layer5, layer6, top_diameter, top_thickness, waste, panjang);
					Hasil3(tot_thickness3, layer31, layer32, layer33, layer34, top_diameter, top_thickness, waste, panjang);
					rubaharea();
				}
			});
		}); 
		
		$(document).on('change', '#series', function(){
			var series 	= $('#series').val();
			var linerEx	= series.split('-');
			var liner	= (linerEx[1] == '2.5')?'2.45':linerEx[1];
			
			var external			= parseFloat($('#acuhan_3').val());
			var MinToleransi		= $('#top_min_toleran').val();
			var MaxToleransi		= $('#top_max_toleran').val();
			var tot_lin_thickness	= $('#tot_lin_thickness').val();
			var tot_lin_thickness2	= $('#tot_lin_thickness2').val();
			var tot_lin_thickness3	= $('#tot_lin_thickness3').val();
			
			//pengurangan structure thickness
			var top_thickness	= parseFloat($('#top_tebal_design').val());
			var acuhan_1		= parseFloat(liner);
			var struktur		= top_thickness - (acuhan_1 + external);
			if(isNaN(struktur)){var struktur = 0;}
			$('#acuhan_2').val(struktur.toFixed(2));
			$('#acuhan_1').val(liner);
			
			AcuhanMaxMin(liner, struktur, external, MinToleransi, MaxToleransi, tot_lin_thickness, tot_lin_thickness2, tot_lin_thickness3);
		});
		
		$(document).on('keyup', '#acuhan_3', function(){
			var top_thickness	= parseFloat($('#top_tebal_design').val());
			var liner			= parseFloat($('#acuhan_1').val());
			var external		= parseFloat($('#acuhan_3').val());
			var struktur		= top_thickness - (liner + external);
			$('#acuhan_2').val(struktur.toFixed(2));
			var MinToleransi	= $('#top_min_toleran').val();
			var MaxToleransi		= $('#top_max_toleran').val();
			var tot_lin_thickness	= $('#tot_lin_thickness').val();
			var tot_lin_thickness2	= $('#tot_lin_thickness2').val();
			var tot_lin_thickness3	= $('#tot_lin_thickness3').val();
			
			AcuhanMaxMin(liner, struktur, external, MinToleransi, MaxToleransi, tot_lin_thickness, tot_lin_thickness2, tot_lin_thickness3);
		});
		
		$(document).on('keyup', '#top_min_toleran', function(){
			var liner		= $('#acuhan_1').val();
			var struktur	= $('#acuhan_2').val();
			var external	= $('#acuhan_3').val();
			var MinToleransi	= $('#top_min_toleran').val();
			var MaxToleransi		= $('#top_max_toleran').val();
			var tot_lin_thickness	= $('#tot_lin_thickness').val();
			var tot_lin_thickness2	= $('#tot_lin_thickness2').val();
			var tot_lin_thickness3	= $('#tot_lin_thickness3').val(); 
			
			AcuhanMaxMin(liner, struktur, external, MinToleransi, MaxToleransi, tot_lin_thickness, tot_lin_thickness2, tot_lin_thickness3);
		});
		
		$(document).on('keyup', '#top_max_toleran', function(){
			var liner		= $('#acuhan_1').val();
			var struktur	= $('#acuhan_2').val();
			var external	= $('#acuhan_3').val();
			var MinToleransi	= $('#top_min_toleran').val();
			var MaxToleransi		= $('#top_max_toleran').val();
			var tot_lin_thickness	= $('#tot_lin_thickness').val();
			var tot_lin_thickness2	= $('#tot_lin_thickness2').val();
			var tot_lin_thickness3	= $('#tot_lin_thickness3').val();
			
			AcuhanMaxMin(liner, struktur, external, MinToleransi, MaxToleransi, tot_lin_thickness, tot_lin_thickness2, tot_lin_thickness3);
		});
		//OnKeyUp bawah Total Resin
		//LINER
		$(document).on('keyup', '#persen_katalis', function(){
			var nilai			= $(this).val();
			var hasil_resin_tot = $('#hasil_resin_tot').val();
			var layer_katalis	= $('#layer_katalis').val();
			var Hasil			= (parseFloat(nilai)/100) * parseFloat(hasil_resin_tot) * parseFloat(layer_katalis);
			$('#last_katalis').val(Hasil.toFixed(3));
		});
		$(document).on('keyup', '#persen_sm', function(){
			var nilai			= $(this).val();
			var hasil_resin_tot = $('#hasil_resin_tot').val();
			var layer_sm	= $('#layer_sm').val();
			var Hasil			= (parseFloat(nilai)/100) * parseFloat(hasil_resin_tot) * parseFloat(layer_sm);
			$('#last_sm').val(Hasil.toFixed(3));
		});
		$(document).on('keyup', '#persen_coblat', function(){
			var nilai			= $(this).val();
			var hasil_resin_tot = $('#hasil_resin_tot').val();
			var layer_coblat	= $('#layer_coblat').val();
			var Hasil			= (parseFloat(nilai)/100) * parseFloat(hasil_resin_tot) * parseFloat(layer_coblat);
			$('#last_cobalt').val(Hasil.toFixed(3));
		});
		$(document).on('keyup', '#persen_dma', function(){
			var nilai			= $(this).val();
			var hasil_resin_tot = $('#hasil_resin_tot').val();
			var layer_dma		= $('#layer_dma').val();
			var Hasil			= (parseFloat(nilai)/100) * parseFloat(hasil_resin_tot) * parseFloat(layer_dma);
			$('#last_dma').val(Hasil.toFixed(3));
		});
		$(document).on('keyup', '#persen_hydroquinone', function(){
			var nilai				= $(this).val();
			var hasil_resin_tot 	= $('#hasil_resin_tot').val();
			var layer_hydroquinone	= $('#layer_hydroquinone').val();
			var Hasil				= (parseFloat(nilai)/100) * parseFloat(hasil_resin_tot) * parseFloat(layer_hydroquinone);
			$('#last_hidro').val(Hasil.toFixed(3));
		});
		$(document).on('keyup', '#persen_methanol', function(){
			var nilai				= $(this).val();
			var hasil_resin_tot 	= $('#hasil_resin_tot').val();
			var layer_methanol		= $('#layer_methanol').val();
			var Hasil				= (parseFloat(nilai)/100) * parseFloat(hasil_resin_tot) * parseFloat(layer_methanol);
			$('#last_methanol').val(Hasil.toFixed(3));
		});
		
		//STRUKTURE
		$(document).on('keyup', '#persen_katalis2', function(){
			var nilai			= $(this).val();
			var hasil_resin_tot = $('#hasil_resin_tot2').val();
			var layer_katalis	= $('#layer_katalis2').val();
			var Hasil			= (parseFloat(nilai)/100) * parseFloat(hasil_resin_tot) * parseFloat(layer_katalis);
			$('#last_katalis2').val(Hasil.toFixed(3));
		});
		$(document).on('keyup', '#persen_sm2', function(){
			var nilai			= $(this).val();
			var hasil_resin_tot = $('#hasil_resin_tot2').val();
			var layer_sm	= $('#layer_sm2').val();
			var Hasil			= (parseFloat(nilai)/100) * parseFloat(hasil_resin_tot) * parseFloat(layer_sm);
			$('#last_sm2').val(Hasil.toFixed(3));
		});
		$(document).on('keyup', '#persen_coblat2', function(){
			var nilai			= $(this).val();
			var hasil_resin_tot = $('#hasil_resin_tot2').val();
			var layer_coblat	= $('#layer_coblat2').val();
			var Hasil			= (parseFloat(nilai)/100) * parseFloat(hasil_resin_tot) * parseFloat(layer_coblat);
			$('#last_cobalt2').val(Hasil.toFixed(3));
		});
		$(document).on('keyup', '#persen_dma2', function(){
			var nilai			= $(this).val();
			var hasil_resin_tot = $('#hasil_resin_tot2').val();
			var layer_dma		= $('#layer_dma2').val();
			var Hasil			= (parseFloat(nilai)/100) * parseFloat(hasil_resin_tot) * parseFloat(layer_dma);
			$('#last_dma2').val(Hasil.toFixed(3));
		});
		$(document).on('keyup', '#persen_hydroquinone2', function(){
			var nilai				= $(this).val();
			var hasil_resin_tot 	= $('#hasil_resin_tot2').val();
			var layer_hydroquinone	= $('#layer_hydroquinone2').val();
			var Hasil				= (parseFloat(nilai)/100) * parseFloat(hasil_resin_tot) * parseFloat(layer_hydroquinone);
			$('#last_hidro2').val(Hasil.toFixed(3));
		});
		$(document).on('keyup', '#persen_methanol2', function(){
			var nilai				= $(this).val();
			var hasil_resin_tot 	= $('#hasil_resin_tot2').val();
			var layer_methanol		= $('#layer_methanol2').val();
			var Hasil				= (parseFloat(nilai)/100) * parseFloat(hasil_resin_tot) * parseFloat(layer_methanol);
			$('#last_methanol2').val(Hasil.toFixed(3));
		});
		
		//EXTERNAL
		$(document).on('keyup', '#persen_katalis3', function(){
			var nilai			= $(this).val();
			var hasil_resin_tot = $('#hasil_resin_tot3').val();
			var layer_katalis	= $('#layer_katalis3').val();
			var Hasil			= (parseFloat(nilai)/100) * parseFloat(hasil_resin_tot) * parseFloat(layer_katalis);
			$('#last_katalis3').val(Hasil.toFixed(3));
		});
		$(document).on('keyup', '#persen_sm3', function(){
			var nilai			= $(this).val();
			var hasil_resin_tot = $('#hasil_resin_tot3').val();
			var layer_sm	= $('#layer_sm3').val();
			var Hasil			= (parseFloat(nilai)/100) * parseFloat(hasil_resin_tot) * parseFloat(layer_sm);
			$('#last_sm3').val(Hasil.toFixed(3));
		});
		$(document).on('keyup', '#persen_coblat3', function(){
			var nilai			= $(this).val();
			var hasil_resin_tot = $('#hasil_resin_tot3').val();
			var layer_coblat	= $('#layer_coblat3').val();
			var Hasil			= (parseFloat(nilai)/100) * parseFloat(hasil_resin_tot) * parseFloat(layer_coblat);
			$('#last_cobalt3').val(Hasil.toFixed(3));
		});
		$(document).on('keyup', '#persen_dma3', function(){
			var nilai			= $(this).val();
			var hasil_resin_tot = $('#hasil_resin_tot3').val();
			var layer_dma		= $('#layer_dma3').val();
			var Hasil			= (parseFloat(nilai)/100) * parseFloat(hasil_resin_tot) * parseFloat(layer_dma);
			$('#last_dma3').val(Hasil.toFixed(3));
		});
		$(document).on('keyup', '#persen_hydroquinone3', function(){
			var nilai				= $(this).val();
			var hasil_resin_tot 	= $('#hasil_resin_tot3').val();
			var layer_hydroquinone	= $('#layer_hydroquinone3').val();
			var Hasil				= (parseFloat(nilai)/100) * parseFloat(hasil_resin_tot) * parseFloat(layer_hydroquinone);
			$('#last_hidro3').val(Hasil.toFixed(3));
		});
		$(document).on('keyup', '#persen_methanol3', function(){
			var nilai				= $(this).val();
			var hasil_resin_tot 	= $('#hasil_resin_tot3').val();
			var layer_methanol		= $('#layer_methanol3').val();
			var Hasil				= (parseFloat(nilai)/100) * parseFloat(hasil_resin_tot) * parseFloat(layer_methanol);
			$('#last_methanol3').val(Hasil.toFixed(3));
		});
		
		//TOPCOAT
		$(document).on('keyup', '#persen_katalis4', function(){
			var nilai			= $(this).val();
			var hasil_resin_tot = $('#hasil_katalis4').val();
			var layer_katalis	= $('#layer_katalis4').val();
			var Hasil			= (parseFloat(nilai)/100) * parseFloat(hasil_resin_tot) * parseFloat(layer_katalis);
			$('#last_katalis4').val(Hasil.toFixed(3));
		});
		$(document).on('keyup', '#persen_color4', function(){
			var nilai			= $(this).val();
			var hasil_resin_tot = $('#hasil_color4').val();
			var layer_katalis	= $('#layer_color4').val();
			var Hasil			= (parseFloat(nilai)/100) * parseFloat(hasil_resin_tot) * parseFloat(layer_katalis);
			$('#last_color4').val(Hasil.toFixed(3));
		});
		$(document).on('keyup', '#persen_tin4', function(){
			var nilai			= $(this).val();
			var hasil_resin_tot = $('#hasil_tin4').val();
			var layer_katalis	= $('#layer_tin4').val();
			var Hasil			= (parseFloat(nilai)/100) * parseFloat(hasil_resin_tot) * parseFloat(layer_katalis);
			$('#last_tin4').val(Hasil.toFixed(3));
		});
		$(document).on('keyup', '#persen_chl4', function(){
			var nilai			= $(this).val();
			var hasil_resin_tot = $('#hasil_chl4').val();
			var layer_katalis	= $('#layer_chl4').val();
			var Hasil			= (parseFloat(nilai)/100) * parseFloat(hasil_resin_tot) * parseFloat(layer_katalis);
			$('#last_chl4').val(Hasil.toFixed(3));
		});
		$(document).on('keyup', '#persen_stery4', function(){
			var nilai			= $(this).val();
			var hasil_resin_tot = $('#hasil_stery4').val();
			var layer_katalis	= $('#layer_stery4').val();
			var Hasil			= (parseFloat(nilai)/100) * parseFloat(hasil_resin_tot) * parseFloat(layer_katalis);
			$('#last_stery4').val(Hasil.toFixed(3));
		});
		$(document).on('keyup', '#persen_wax4', function(){
			var nilai			= $(this).val();
			var hasil_resin_tot = $('#hasil_wax4').val();
			var layer_katalis	= $('#layer_wax4').val();
			var Hasil			= (parseFloat(nilai)/100) * parseFloat(hasil_resin_tot) * parseFloat(layer_katalis);
			$('#last_wax4').val(Hasil.toFixed(3));
		});
		$(document).on('keyup', '#persen_mch4', function(){
			var nilai			= $(this).val();
			var hasil_resin_tot = $('#hasil_mch4').val();
			var layer_katalis	= $('#layer_mch4').val();
			var Hasil			= (parseFloat(nilai)/100) * parseFloat(hasil_resin_tot) * parseFloat(layer_katalis);
			$('#last_mch4').val(Hasil.toFixed(3));
		});
		
		//END UNDER SUM RESIN
		//LINER
		$(document).on('keyup', '.ChangeContaining', function(){
			var total_resin	= $('#last_resin_tot').val();
			var perse		= $(this).parent().parent().find("td:nth-child(5) input").val() / 100;
			var containing	= $(this).val();
			
			var HasilAkhir	= parseFloat(total_resin) * parseFloat(perse) * parseFloat(containing);
			
			$(this).parent().parent().find("td:nth-child(6) input").val(HasilAkhir.toFixed(3));
			$(this).parent().parent().find("td:nth-child(1) input").val(HasilAkhir);


		});
		
		$(document).on('keyup', '.ChangePerse', function(){
			var total_resin	= $('#last_resin_tot').val();
			var containing		= $(this).parent().parent().find("td:nth-child(4) input").val() / 100;
			var perse	= $(this).val();
			
			var HasilAkhir	= parseFloat(total_resin) * parseFloat(perse) * parseFloat(containing);
			
			$(this).parent().parent().find("td:nth-child(6) input").val(HasilAkhir.toFixed(3));
			$(this).parent().parent().find("td:nth-child(1) input").val(HasilAkhir);

		});
		//STRUKTURE
		$(document).on('keyup', '.ChangeContainingStr', function(){
			var total_resin	= $('#last_resin_tot2').val();
			var perse		= $(this).parent().parent().find("td:nth-child(5) input").val() / 100;
			var containing	= $(this).val();
			
			var HasilAkhir	= parseFloat(total_resin) * parseFloat(perse) * parseFloat(containing);
			
			$(this).parent().parent().find("td:nth-child(6) input").val(HasilAkhir.toFixed(3));
			$(this).parent().parent().find("td:nth-child(1) input").val(HasilAkhir);


		});
		
		$(document).on('keyup', '.ChangePerseStr', function(){
			var total_resin	= $('#last_resin_tot2').val();
			var containing		= $(this).parent().parent().find("td:nth-child(4) input").val() / 100;
			var perse	= $(this).val();
			
			var HasilAkhir	= parseFloat(total_resin) * parseFloat(perse) * parseFloat(containing);
			
			$(this).parent().parent().find("td:nth-child(6) input").val(HasilAkhir.toFixed(3));
			$(this).parent().parent().find("td:nth-child(1) input").val(HasilAkhir);

		});
		
		//EXTERNAL
		$(document).on('keyup', '.ChangeContainingExt', function(){
			var total_resin	= $('#last_resin_tot3').val();
			var perse		= $(this).parent().parent().find("td:nth-child(5) input").val() / 100;
			var containing	= $(this).val();
			
			var HasilAkhir	= parseFloat(total_resin) * parseFloat(perse) * parseFloat(containing);
			
			$(this).parent().parent().find("td:nth-child(6) input").val(HasilAkhir.toFixed(3));
			$(this).parent().parent().find("td:nth-child(1) input").val(HasilAkhir);


		});
		
		$(document).on('keyup', '.ChangePerseExt', function(){
			var total_resin	= $('#last_resin_tot3').val();
			var containing		= $(this).parent().parent().find("td:nth-child(4) input").val() / 100;
			var perse	= $(this).val();
			
			var HasilAkhir	= parseFloat(total_resin) * parseFloat(perse) * parseFloat(containing);
			
			$(this).parent().parent().find("td:nth-child(6) input").val(HasilAkhir.toFixed(3));
			$(this).parent().parent().find("td:nth-child(1) input").val(HasilAkhir);

		});
		//TOP COAT
		$(document).on('keyup', '.ChangeContainingTC', function(){
			var total_resin	= $('#last_resin41').val();
			var perse		= $(this).parent().parent().find("td:nth-child(5) input").val() / 100;
			var containing	= $(this).val();
			
			var HasilAkhir	= parseFloat(total_resin) * parseFloat(perse) * parseFloat(containing);
			
			$(this).parent().parent().find("td:nth-child(6) input").val(HasilAkhir.toFixed(3));
			$(this).parent().parent().find("td:nth-child(1) input").val(HasilAkhir);


		});
		
		$(document).on('keyup', '.ChangePerseTC', function(){
			var total_resin	= $('#last_resin41').val();
			var containing		= $(this).parent().parent().find("td:nth-child(4) input").val() / 100;
			var perse	= $(this).val();
			
			var HasilAkhir	= parseFloat(total_resin) * parseFloat(perse) * parseFloat(containing);
			
			$(this).parent().parent().find("td:nth-child(6) input").val(HasilAkhir.toFixed(3));
			$(this).parent().parent().find("td:nth-child(1) input").val(HasilAkhir);

		});
		//========================================LINER THICKNESS=========================================================
		$(document).on('change', '#mid_mtl_plastic', function(){
			var id_material	= $(this).val();
			$.ajax({
				url: base_url +'index.php/'+active_controller+'/getMicronPlastic',
				cache: false,
				type: "POST",
				data: "id_material="+$(this).val()+"&top_diameter="+$("#top_diameter").val(),
				dataType: "json",
				success: function(data){
					$('#micron_plastic').val(data.micron);
				}
			});
		});
		
		$(document).on('change', '#mid_mtl_veil', function(){
			var id_material	= $(this).val();
			$.ajax({
				url: base_url +'index.php/'+active_controller+'/getVeil',
				cache: false,
				type: "POST",
				data: "id_material="+$(this).val()+"&resin1="+$('#layer_resin1').val(),
				dataType: "json",
				success: function(data){
					$('#weight_veil').val(data.micron);
					$('#thickness_veil').val(RoundUp4(data.thickness));
					$('#layer_veil').val(data.layer);
					$('#layer_resin1hide').val(data.resin);
				}
			});
		});
		
		$(document).on('keyup', '#layer_veil', function(){
			var layer_veil		= $(this).val();
			var layer_veil2		= $("#layer_veil_add").val();
			var layer_veil3		= $("#layer_matcsm").val();
			var layer_veil4		= $("#layer_csm_add").val();
			
			var waste			= parseFloat($('#waste').val()) / 100;
			var top_diameter	= parseFloat($('#top_diameter').val());
			var top_thickness	= parseFloat($('#top_tebal_design').val());
			var panjang			= parseFloat($('#panjang').val());
			
			var thickness_veil 	= $('#thickness_veil').val();
			var tot_thickness	= layer_veil*thickness_veil;
			
			var thickness2		= parseFloat($('#totthick_veil_add').val());
			var thickness3		= parseFloat($('#totthick_matcsm').val());
			var thickness4		= parseFloat($('#totthick_csm_add').val());
			var tot_thickness2	= tot_thickness + thickness2 + thickness3 + thickness4;
			
			$('#tot_lin_thickness').val(tot_thickness2.toFixed(4));
			$('#totthick_veil').val(tot_thickness.toFixed(4));
			
			Hasil(tot_thickness2, layer_veil, layer_veil2, layer_veil3, layer_veil4, top_diameter, top_thickness, waste, panjang);
			rubaharea();
		});
		
		$(document).on('change', '#mid_mtl_veil_add', function(){
			var id_material	= $(this).val();
			$.ajax({
				url: base_url +'index.php/'+active_controller+'/getVeil2',
				cache: false,
				type: "POST",
				data: "id_material="+$(this).val()+"&resin2="+$('#layer_resin2').val(),
				dataType: "json",
				success: function(data){ 
					$('#weight_veil_add').val(data.micron);
					$('#thickness_veil_add').val(RoundUp4(data.thickness));
					$('#layer_veil_add').val(data.layer);
					$('#layer_resin2hide').val(data.resin);
				}
			});
		});
		
		$(document).on('keyup', '#layer_veil_add', function(){
			var layer_veil		= $(this).val();
			var layer_veil1		= $("#layer_veil").val();
			var layer_veil3		= $("#layer_matcsm").val();
			var layer_veil4		= $("#layer_csm_add").val();
			var waste			= parseFloat($('#waste').val()) / 100;
			var top_diameter	= parseFloat($('#top_diameter').val());
			var top_thickness	= parseFloat($('#top_tebal_design').val());
			var panjang			= parseFloat($('#panjang').val());
			
			var thickness_veil 	= $('#thickness_veil_add').val();
			var tot_thickness	= layer_veil*thickness_veil;
			
			var thickness1		= parseFloat($('#totthick_veil').val());
			var thickness3		= parseFloat($('#totthick_matcsm').val());
			var thickness4		= parseFloat($('#totthick_csm_add').val());
			var tot_thickness2	= thickness1 + tot_thickness + thickness3 + thickness4;
			
			$('#tot_lin_thickness').val(tot_thickness2.toFixed(4));
			$('#totthick_veil_add').val(tot_thickness.toFixed(4));
			
			Hasil(tot_thickness2, layer_veil1, layer_veil, layer_veil3, layer_veil4, top_diameter, top_thickness, waste, panjang);
			rubaharea();
		});
		
		$(document).on('change', '#mid_mtl_resin_tot', function(){ 
			if($("#mid_mtl_veil").val() != 'MTL-1903000'){
				$("#layer_resin1hide").val($(this).val());
			}
			if($("#mid_mtl_veil_add").val() != 'MTL-1903000'){
				$("#layer_resin2hide").val($(this).val());
			}
			if($("#mid_mtl_matcsm").val() != 'MTL-1903000'){
				$("#layer_resin3hide").val($(this).val());
			}
			if($("#mid_mtl_csm_add").val() != 'MTL-1903000'){
				$("#layer_resin4hide").val($(this).val());
			}
		});
		
		$(document).on('change', '#mid_mtl_matcsm', function(){
			var id_material	= $(this).val();
			$.ajax({
				url: base_url +'index.php/'+active_controller+'/getCsm',
				cache: false,
				type: "POST",
				data: "id_material="+$(this).val()+"&resin3="+$('#layer_resin3').val(),
				dataType: "json",
				success: function(data){
					$('#weight_matcsm').val(data.micron);
					$('#thickness_matcsm').val(RoundUp4(data.thickness));
					$('#layer_matcsm').val(data.layer);
					$('#layer_resin3hide').val(data.resin);
				}
			});
		});
		
		$(document).on('keyup', '#layer_matcsm', function(){
			var layer_veil		= $(this).val();
			var layer_veil1		= $("#layer_veil").val();
			var layer_veil2		= $("#layer_veil_add").val();
			var layer_veil4		= $("#layer_csm_add").val();
			var waste			= parseFloat($('#waste').val()) / 100;
			var top_diameter	= parseFloat($('#top_diameter').val());
			var top_thickness	= parseFloat($('#top_tebal_design').val());
			var panjang			= parseFloat($('#panjang').val());
			
			var thickness_veil 	= $('#thickness_matcsm').val();
			var tot_thickness	= layer_veil*thickness_veil;
			
			var thickness1		= parseFloat($('#totthick_veil').val());
			var thickness2		= parseFloat($('#totthick_veil_add').val());
			// var thickness3		= $('#totthick_matcsm').val();
			var thickness4		= parseFloat($('#totthick_csm_add').val());
			var tot_thickness2	= thickness1 + thickness2 + tot_thickness + thickness4;
			
			$('#tot_lin_thickness').val(tot_thickness2.toFixed(4));
			$('#totthick_matcsm').val(tot_thickness.toFixed(4));
			
			Hasil(tot_thickness2, layer_veil1, layer_veil2, layer_veil, layer_veil4, top_diameter, top_thickness, waste, panjang);
			rubaharea();
		});
		
		$(document).on('change', '#mid_mtl_csm_add', function(){
			var id_material	= $(this).val();
			$.ajax({
				url: base_url +'index.php/'+active_controller+'/getCsm2',
				cache: false,
				type: "POST",
				data: "id_material="+$(this).val()+"&resin4="+$('#layer_resin4').val(),
				dataType: "json",
				success: function(data){
					$('#weight_csm_add').val(data.micron);
					$('#thickness_csm_add').val(RoundUp4(data.thickness));
					$('#layer_csm_add').val(data.layer);
					$('#layer_resin4hide').val(data.resin);
				}
			});
		});
		
		$(document).on('keyup', '#layer_csm_add', function(){
			var layer_veil		= $(this).val();
			var layer_veil1		= $("#layer_veil").val();
			var layer_veil2		= $("#layer_veil_add").val();
			var layer_veil3		= $("#layer_matcsm").val();
			var waste			= parseFloat($('#waste').val()) / 100;
			var top_diameter	= parseFloat($('#top_diameter').val());
			var top_thickness	= parseFloat($('#top_tebal_design').val());
			var panjang			= parseFloat($('#panjang').val());
			
			var thickness_veil 	= $('#thickness_csm_add').val();
			var tot_thickness	= layer_veil*thickness_veil;
			
			var thickness1		= parseFloat($('#totthick_veil').val());
			var thickness2		= parseFloat($('#totthick_veil_add').val());
			var thickness3		= parseFloat($('#totthick_matcsm').val());
			var tot_thickness2	= thickness1 + thickness2 + thickness3 + tot_thickness;
			
			$('#tot_lin_thickness').val(tot_thickness2.toFixed(4));
			$('#totthick_csm_add').val(tot_thickness.toFixed(4));
			
			Hasil(tot_thickness2, layer_veil1, layer_veil2, layer_veil3, layer_veil, top_diameter, top_thickness, waste, panjang);
			rubaharea();
		});
		
		//=============================================END=========================================================
		
		//========================================STRUKTURE THICKNESS=========================================================
		$(document).on('change', '#mid_mtl_resin_tot2', function(){
			if($("#mid_mtl_matcsm2").val() != 'MTL-1903000'){
				$("#layer_resin21hide").val($(this).val());
			}
			if($("#mid_mtl_csm_add2").val() != 'MTL-1903000'){
				$("#layer_resin22hide").val($(this).val());
			}
			if($("#mid_mtl_wr2").val() != 'MTL-1903000'){
				$("#layer_resin23hide").val($(this).val());
			}
			if($("#mid_mtl_wr_add2").val() != 'MTL-1903000'){
				$("#layer_resin24hide").val($(this).val());
			}
			if($("#mid_mtl_rooving21").val() != 'MTL-1903000'){
				$("#layer_resin25hide").val($(this).val());
			}
			if($("#mid_mtl_rooving22").val() != 'MTL-1903000'){
				$("#layer_resin26hide").val($(this).val());
			}
			
		});
		
		$(document).on('change', '#mid_mtl_matcsm2', function(){
			var id_material	= $(this).val();
			$.ajax({
				url: base_url +'index.php/'+active_controller+'/getCsmX',
				cache: false,
				type: "POST",
				data: "id_material="+$(this).val()+"&resin3="+$('#layer_resin21').val(),
				dataType: "json",
				success: function(data){
					$('#weight_matcsm2').val(data.micron);
					$('#thickness_matcsm2').val(RoundUp4(data.thickness));
					$('#layer_matcsm2').val(data.layer);
					// $("#mid_mtl_resin21").html(data.option).trigger("chosen:updated");
					$('#layer_resin21hide').val(data.resin);
				}
			});
		});
		
		$(document).on('keyup', '#layer_matcsm2', function(){
			var layer_veil	= $(this).val();
			var layer2		= $("#layer_csm_add2").val();
			var layer3		= $("#layer_wr2").val();
			var layer4		= $("#layer_wr_add2").val();
			var layer5		= $("#layer_rooving21").val();
			var layer6		= $("#layer_rooving22").val();
			
			var waste			= parseFloat($('#waste').val()) / 100;
			var top_diameter	= parseFloat($('#top_diameter').val());
			var top_thickness	= parseFloat($('#top_tebal_design').val());
			var panjang			= parseFloat($('#panjang').val());
			
			var thickness_veil 	= $('#thickness_matcsm2').val();
			var tot_thickness	= layer_veil*thickness_veil;

			var thickness2		= parseFloat($('#totthick_csm_add2').val());
			var thickness3		= parseFloat($('#totthick_wr2').val());
			var thickness4		= parseFloat($('#totthick_wr_add2').val());
			var thickness5		= parseFloat($('#totthick_rooving21').val());
			var thickness6		= parseFloat($('#totthick_rooving22').val());
			var tot_thickness2	= tot_thickness + thickness2 + thickness3 + thickness4 + thickness5 + thickness6;
			
			$('#tot_lin_thickness2').val(tot_thickness2.toFixed(4));
			$('#totthick_matcsm2').val(tot_thickness.toFixed(4));
			
			Hasil2(tot_thickness2, layer_veil, layer2, layer3, layer4, layer5, layer6, top_diameter, top_thickness, waste, panjang);
			rubaharea();
		});
		
		$(document).on('change', '#mid_mtl_csm_add2', function(){
			var id_material	= $(this).val();
			$.ajax({
				url: base_url +'index.php/'+active_controller+'/getCsm2',
				cache: false,
				type: "POST",
				data: "id_material="+$(this).val()+"&resin4="+$('#layer_resin22').val(),
				dataType: "json",
				success: function(data){
					$('#weight_csm_add2').val(data.micron);
					$('#thickness_csm_add2').val(RoundUp4(data.thickness));
					$('#layer_csm_add2').val(data.layer);
					$('#layer_resin22hide').val(data.resin);
				}
			});
		});
		
		$(document).on('keyup', '#layer_csm_add2', function(){
			var layer_veil		= $(this).val();
			var layer1		= $("#layer_matcsm2").val();
			var layer3		= $("#layer_wr2").val();
			var layer4		= $("#layer_wr_add2").val();
			var layer5		= $("#layer_rooving21").val();
			var layer6		= $("#layer_rooving22").val();
			
			var waste			= parseFloat($('#waste').val()) / 100;
			var top_diameter	= parseFloat($('#top_diameter').val());
			var top_thickness	= parseFloat($('#top_tebal_design').val());
			var panjang			= parseFloat($('#panjang').val());
			
			var thickness_veil 	= $('#thickness_csm_add2').val();
			var tot_thickness	= layer_veil*thickness_veil;
			
			var thickness1		= parseFloat($('#totthick_matcsm2').val());
			var thickness3		= parseFloat($('#totthick_wr2').val());
			var thickness4		= parseFloat($('#totthick_wr_add2').val());
			var thickness5		= parseFloat($('#totthick_rooving21').val());
			var thickness6		= parseFloat($('#totthick_rooving22').val());
			var tot_thickness2	= tot_thickness + thickness1 + thickness3 + thickness4 + thickness5 + thickness6;
			
			$('#tot_lin_thickness2').val(tot_thickness2.toFixed(4));
			$('#totthick_csm_add2').val(tot_thickness.toFixed(4));
			
			Hasil2(tot_thickness2, layer1, layer_veil, layer3, layer4, layer5, layer6, top_diameter, top_thickness, waste, panjang);
			rubaharea();
		});
		
		
		
		$(document).on('change', '#mid_mtl_wr2', function(){
			var id_material	= $(this).val();
			$.ajax({
				url: base_url +'index.php/'+active_controller+'/getWoodR',
				cache: false,
				type: "POST",
				data: "id_material="+$(this).val()+"&resinutama="+$('#mid_mtl_resin21').val(),
				dataType: "json",
				success: function(data){
					$('#weight_wr2').val(data.weight);
					$('#thickness_wr2').val(RoundUp4(data.thickness));
					$('#layer_wr2').val(data.layer);
					$("#mid_mtl_resin23").html(data.option).trigger("chosen:updated");
					$('#layer_resin23hide').val(data.resin);
				}
			});
		});
		
		$(document).on('keyup', '#layer_wr2', function(){
			var layer_veil		= $(this).val();
			var layer1		= $("#layer_matcsm2").val();
			var layer2		= $("#layer_csm_add2").val();
			var layer4		= $("#layer_wr_add2").val();
			var layer5		= $("#layer_rooving21").val();
			var layer6		= $("#layer_rooving22").val();
			
			var waste			= parseFloat($('#waste').val()) / 100;
			var top_diameter	= parseFloat($('#top_diameter').val());
			var top_thickness	= parseFloat($('#top_tebal_design').val());
			var panjang			= parseFloat($('#panjang').val());
			
			var thickness_veil 	= $('#thickness_wr2').val();
			var tot_thickness	= layer_veil*thickness_veil;
			
			var thickness1		= parseFloat($('#totthick_matcsm2').val());
			var thickness2		= parseFloat($('#totthick_csm_add2').val());
			var thickness4		= parseFloat($('#totthick_wr_add2').val());
			var thickness5		= parseFloat($('#totthick_rooving21').val());
			var thickness6		= parseFloat($('#totthick_rooving22').val());
			var tot_thickness2	= tot_thickness + thickness1 + thickness2 + thickness4 + thickness5 + thickness6;
			
			$('#tot_lin_thickness2').val(tot_thickness2.toFixed(4));
			$('#totthick_wr2').val(tot_thickness.toFixed(4));
			
			Hasil2(tot_thickness2, layer1, layer2, layer_veil, layer4, layer5, layer6, top_diameter, top_thickness, waste, panjang);
			rubaharea();
		});
		
		$(document).on('change', '#mid_mtl_wr_add2', function(){
			var id_material	= $(this).val();
			$.ajax({
				url: base_url +'index.php/'+active_controller+'/getWoodR',
				cache: false,
				type: "POST",
				data: "id_material="+$(this).val(),
				dataType: "json",
				success: function(data){
					$('#weight_wr_add2').val(data.weight);
					$('#thickness_wr_add2').val(RoundUp4(data.thickness));
					$('#layer_wr_add2').val(data.layer);
					$('#layer_resin24hide').val(data.resin);
				}
			});
		});
		
		$(document).on('keyup', '#layer_wr_add2', function(){
			var layer_veil		= $(this).val();
			var layer1		= $("#layer_matcsm2").val();
			var layer2		= $("#layer_csm_add2").val();
			var layer3		= $("#layer_wr2").val();
			var layer5		= $("#layer_rooving21").val();
			var layer6		= $("#layer_rooving22").val();
			
			var waste			= parseFloat($('#waste').val()) / 100;
			var top_diameter	= parseFloat($('#top_diameter').val());
			var top_thickness	= parseFloat($('#top_tebal_design').val());
			var panjang			= parseFloat($('#panjang').val());
			
			var thickness_veil 	= $('#thickness_wr_add2').val();
			var tot_thickness	= layer_veil*thickness_veil;
			
			var thickness1		= parseFloat($('#totthick_matcsm2').val());
			var thickness2		= parseFloat($('#totthick_csm_add2').val());
			var thickness3		= parseFloat($('#totthick_wr2').val());
			var thickness5		= parseFloat($('#totthick_rooving21').val());
			var thickness6		= parseFloat($('#totthick_rooving22').val());
			var tot_thickness2	= tot_thickness + thickness1 + thickness2 + thickness3 + thickness5 + thickness6;
			
			$('#tot_lin_thickness2').val(tot_thickness2.toFixed(4));
			$('#totthick_wr_add2').val(tot_thickness.toFixed(4));
			
			Hasil2(tot_thickness2, layer1, layer2, layer3, layer_veil, layer5, layer6, top_diameter, top_thickness, waste, panjang);
			rubaharea();
		});
		
		$(document).on('change', '#mid_mtl_rooving21', function(){
			var id_material	= $(this).val();
			$.ajax({
				url: base_url +'index.php/'+active_controller+'/getRooving',
				cache: false,
				type: "POST",
				data: "id_material="+$(this).val()+"&resin="+$('#layer_resin25').val(),
				dataType: "json",
				success: function(data){
					$('#weight_rooving21').val(data.weight);
					$('#thickness_rooving21').val(RoundUp4(data.thickness));
					$('#bw_rooving21').val(data.bw);
					$('#jumlah_rooving21').val(data.jumRoov);
					$('#layer_rooving21').val(data.layer);
					$('#layer_resin25hide').val(data.resin);
				}
			});
		});
		
		$(document).on('keyup', '#layer_rooving21', function(){
			var layer_veil		= $(this).val();
			var layer1		= $("#layer_matcsm2").val();
			var layer2		= $("#layer_csm_add2").val();
			var layer3		= $("#layer_wr2").val();
			var layer4		= $("#layer_wr_add2").val();
			var layer6		= $("#layer_rooving22").val();
			
			var waste			= parseFloat($('#waste').val()) / 100;
			var top_diameter	= parseFloat($('#top_diameter').val());
			var top_thickness	= parseFloat($('#top_tebal_design').val());
			var panjang			= parseFloat($('#panjang').val());
			
			var thickness_veil 	= $('#thickness_rooving21').val();
			var tot_thickness	= layer_veil*thickness_veil;
			
			var thickness1		= parseFloat($('#totthick_matcsm2').val());
			var thickness2		= parseFloat($('#totthick_csm_add2').val());
			var thickness3		= parseFloat($('#totthick_wr2').val());
			var thickness4		= parseFloat($('#totthick_wr_add2').val());
			var thickness6		= parseFloat($('#totthick_rooving22').val());
			var tot_thickness2	= tot_thickness + thickness1 + thickness2 + thickness3 + thickness4 + thickness6;
			
			$('#tot_lin_thickness2').val(tot_thickness2.toFixed(4));
			$('#totthick_rooving21').val(tot_thickness.toFixed(4));
			
			Hasil2(tot_thickness2, layer1, layer2, layer3, layer4, layer_veil, layer6, top_diameter, top_thickness, waste, panjang);
			rubaharea();
		});
		
		$(document).on('change', '#mid_mtl_rooving22', function(){
			var id_material	= $(this).val();
			$.ajax({
				url: base_url +'index.php/'+active_controller+'/getRooving',
				cache: false,
				type: "POST",
				data: "id_material="+$(this).val()+"&resin="+$('#layer_resin26').val(),
				dataType: "json",
				success: function(data){
					$('#weight_rooving22').val(data.weight);
					$('#thickness_rooving22').val(RoundUp4(data.thickness));
					$('#bw_rooving22').val(data.bw);
					$('#jumlah_rooving22').val(data.jumRoov);
					$('#layer_rooving22').val(data.layer);
					$('#layer_resin26hide').val(data.resin);
				}
			});
		});
		
		$(document).on('keyup', '#layer_rooving22', function(){
			var layer_veil		= $(this).val();
			var layer1		= $("#layer_matcsm2").val();
			var layer2		= $("#layer_csm_add2").val();
			var layer3		= $("#layer_wr2").val();
			var layer4		= $("#layer_wr_add2").val();
			var layer5		= $("#layer_rooving21").val();
			
			var waste			= parseFloat($('#waste').val()) / 100;
			var top_diameter	= parseFloat($('#top_diameter').val());
			var top_thickness	= parseFloat($('#top_tebal_design').val());
			var panjang			= parseFloat($('#panjang').val());
			
			var thickness_veil 	= $('#thickness_rooving22').val();
			var tot_thickness	= layer_veil*thickness_veil;
			
			var thickness1		= parseFloat($('#totthick_matcsm2').val());
			var thickness2		= parseFloat($('#totthick_csm_add2').val());
			var thickness3		= parseFloat($('#totthick_wr2').val());
			var thickness4		= parseFloat($('#totthick_wr_add2').val());
			var thickness5		= parseFloat($('#totthick_rooving21').val());
			var tot_thickness2	= tot_thickness + thickness1 + thickness2 + thickness3 + thickness4 + thickness5;
			
			$('#tot_lin_thickness2').val(tot_thickness2.toFixed(4));
			$('#totthick_rooving22').val(tot_thickness.toFixed(4));
			
			Hasil2(tot_thickness2, layer1, layer2, layer3, layer4, layer5, layer_veil, top_diameter, top_thickness, waste, panjang);
			rubaharea();
		});
		
		//=============================================END=========================================================
		
		//===================================EXTERNAL LAYER THICKNESS==============================================
		$(document).on('change', '#mid_mtl_resin_tot3', function(){
			if($("#mid_mtl_veil3").val() != 'MTL-1903000'){
				$("#layer_resin31hide").val($(this).val());
			}
			if($("#mid_mtl_veil_add3").val() != 'MTL-1903000'){
				$("#layer_resin32hide").val($(this).val());
			}
			if($("#mid_mtl_matcsm3").val() != 'MTL-1903000'){
				$("#layer_resin33hide").val($(this).val());
			}
			if($("#mid_mtl_csm_add3").val() != 'MTL-1903000'){
				$("#layer_resin34hide").val($(this).val());
			}
		});
		
		$(document).on('change', '#mid_mtl_veil3', function(){
			var id_material	= $(this).val();
			$.ajax({
				url: base_url +'index.php/'+active_controller+'/getVeil',
				cache: false,
				type: "POST",
				data: "id_material="+$(this).val()+"&resin1="+$('#layer_resin31').val(),
				dataType: "json",
				success: function(data){
					$('#weight_veil3').val(data.micron);
					$('#thickness_veil3').val(RoundUp4(data.thickness));
					$('#layer_veil3').val(data.layer);
					$('#layer_resin31hide').val(data.resin);
				}
			});
		});
		
		$(document).on('keyup', '#layer_veil3', function(){
			var layer_veil		= $(this).val();
			var layer2		= $("#layer_veil_add3").val();
			var layer3		= $("#layer_matcsm3").val();
			var layer4		= $("#layer_csm_add3").val();
			
			var waste			= parseFloat($('#waste').val()) / 100;
			var top_diameter	= parseFloat($('#top_diameter').val());
			var top_thickness	= parseFloat($('#top_tebal_design').val());
			var panjang			= parseFloat($('#panjang').val());
			
			var thickness_veil 	= $('#thickness_veil3').val();
			var tot_thickness	= layer_veil*thickness_veil;
			
			var thickness2		= parseFloat($('#totthick_veil_add3').val());
			var thickness3		= parseFloat($('#totthick_matcsm3').val());
			var thickness4		= parseFloat($('#totthick_csm_add3').val());
			var tot_thickness2	= tot_thickness + thickness2 + thickness3 + thickness4;
			
			$('#tot_lin_thickness3').val(tot_thickness2.toFixed(4));
			$('#totthick_veil3').val(tot_thickness.toFixed(4));
			
			Hasil3(tot_thickness2, layer_veil, layer2, layer3, layer4, top_diameter, top_thickness, waste, panjang);
			rubaharea();
		});
		
		$(document).on('change', '#mid_mtl_veil_add3', function(){
			var id_material	= $(this).val();
			$.ajax({
				url: base_url +'index.php/'+active_controller+'/getVeil2',
				cache: false,
				type: "POST",
				data: "id_material="+$(this).val()+"&resin2="+$('#layer_resin32').val(),
				dataType: "json",
				success: function(data){
					$('#weight_veil_add3').val(data.micron);
					$('#thickness_veil_add3').val(RoundUp4(data.thickness));
					$('#layer_veil_add3').val(data.layer);
					$('#layer_resin32hide').val(data.resin);
				}
			});
		});
		
		$(document).on('keyup', '#layer_veil_add3', function(){
			var layer_veil		= $(this).val();
			var layer1		= $("#layer_veil3").val();
			var layer3		= $("#layer_matcsm3").val();
			var layer4		= $("#layer_csm_add3").val();
			
			var waste			= parseFloat($('#waste').val()) / 100;
			var top_diameter	= parseFloat($('#top_diameter').val());
			var top_thickness	= parseFloat($('#top_tebal_design').val());
			var panjang			= parseFloat($('#panjang').val());
			
			var thickness_veil 	= $('#thickness_veil_add3').val();
			var tot_thickness	= layer_veil*thickness_veil;
			
			var thickness1		= parseFloat($('#totthick_veil3').val());
			var thickness3		= parseFloat($('#totthick_matcsm3').val());
			var thickness4		= parseFloat($('#totthick_csm_add3').val());
			var tot_thickness2	= thickness1 + tot_thickness + thickness3 + thickness4;
			
			$('#tot_lin_thickness3').val(tot_thickness2.toFixed(4));
			$('#totthick_veil_add3').val(tot_thickness.toFixed(4));
			
			Hasil3(tot_thickness2, layer1, layer_veil, layer3, layer4, top_diameter, top_thickness, waste, panjang);
			rubaharea();
		});
		
		$(document).on('change', '#mid_mtl_matcsm3', function(){
			var id_material	= $(this).val();
			$.ajax({
				url: base_url +'index.php/'+active_controller+'/getCsm',
				cache: false,
				type: "POST",
				data: "id_material="+$(this).val()+"&resin3="+$('#layer_resin33').val(),
				dataType: "json",
				success: function(data){
					$('#weight_matcsm3').val(data.micron);
					$('#thickness_matcsm3').val(RoundUp4(data.thickness));
					$('#layer_matcsm3').val(data.layer);
					$('#layer_resin33hide').val(data.resin);
				}
			});
		});
		
		$(document).on('keyup', '#layer_matcsm3', function(){
			var layer_veil		= $(this).val();
			var layer1		= $("#layer_veil3").val();
			var layer2		= $("#layer_veil_add3").val();
			var layer4		= $("#layer_csm_add3").val();
			
			var waste			= parseFloat($('#waste').val()) / 100;
			var top_diameter	= parseFloat($('#top_diameter').val());
			var top_thickness	= parseFloat($('#top_tebal_design').val());
			var panjang			= parseFloat($('#panjang').val());
			
			var thickness_veil 	= $('#thickness_matcsm3').val();
			var tot_thickness	= layer_veil*thickness_veil;
			
			var thickness1		= parseFloat($('#totthick_veil3').val());
			var thickness2		= parseFloat($('#totthick_veil_add3').val());
			// var thickness3		= $('#totthick_matcsm').val();
			var thickness4		= parseFloat($('#totthick_csm_add3').val());
			var tot_thickness2	= thickness1 + thickness2 + tot_thickness + thickness4;
			
			$('#tot_lin_thickness3').val(tot_thickness2.toFixed(4));
			$('#totthick_matcsm3').val(RoundUp4(tot_thickness));
			
			Hasil3(tot_thickness2, layer1, layer2, layer_veil, layer4, top_diameter, top_thickness, waste, panjang);
			rubaharea();
		});
		
		$(document).on('change', '#mid_mtl_csm_add3', function(){
			var id_material	= $(this).val();
			$.ajax({
				url: base_url +'index.php/'+active_controller+'/getCsm2',
				cache: false,
				type: "POST",
				data: "id_material="+$(this).val()+"&resin4="+$('#layer_resin34').val(),
				dataType: "json",
				success: function(data){
					$('#weight_csm_add3').val(data.micron);
					$('#thickness_csm_add3').val(RoundUp4(data.thickness));
					$('#layer_csm_add3').val(data.layer);
					$('#layer_resin34hide').val(data.resin);
				}
			});
		});
		
		$(document).on('keyup', '#layer_csm_add3', function(){
			var layer_veil		= $(this).val();
			var layer1		= $("#layer_veil3").val();
			var layer2		= $("#layer_veil_add3").val();
			var layer3		= $("#layer_matcsm3").val();
			
			var waste			= parseFloat($('#waste').val()) / 100;
			var top_diameter	= parseFloat($('#top_diameter').val());
			var top_thickness	= parseFloat($('#top_tebal_design').val());
			var panjang			= parseFloat($('#panjang').val());
			
			var thickness_veil 	= $('#thickness_csm_add3').val();
			var tot_thickness	= layer_veil*thickness_veil;
			
			var thickness1		= parseFloat($('#totthick_veil3').val());
			var thickness2		= parseFloat($('#totthick_veil_add3').val());
			var thickness3		= parseFloat($('#totthick_matcsm3').val());
			var tot_thickness2	= thickness1 + thickness2 + thickness3 + tot_thickness;
			
			$('#tot_lin_thickness3').val(tot_thickness2.toFixed(4));
			$('#totthick_csm_add3').val(tot_thickness.toFixed(4));
			
			Hasil3(tot_thickness2, layer1, layer2, layer3, layer_veil, top_diameter, top_thickness, waste, panjang);
			rubaharea();
		});  
		
		//=============================================END=========================================================
		
		//==========================================SAVED=================================================
		$(document).on('click', '#simpan-bro', function(e){
			e.preventDefault();
			var top_type			= $('#top_typeList').val();
			var top_diameter		= $('#top_diameter').val();
			var top_tebal_design	= $('#top_tebal_design').val();
			var top_max_toleran		= $('#top_max_toleran').val();
			var top_min_toleran		= $('#top_min_toleran').val();
			
			var series				= $('#series').val();
			
			var criminal_barier		= $('#criminal_barier').val();
			var aplikasi_product	= $('#aplikasi_product').val();
			var vacum_rate			= $('#vacum_rate').val();
			var design_life			= $('#design_life').val();
			
			var top_app				= $('#top_app').val();
			var top_toleran			= $('#top_toleran').val();
			var type_elbow			= $('#type_elbow').val();
			var angle				= $('#angle').val();
			
			//LINER THICKNESS
			var mid_mtl_realese		= $('#mid_mtl_realese').val();
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
			// var mid_mtl_additive	= $('#mid_mtl_additive').val();
			
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
			// var mid_mtl_additive2	= $('#mid_mtl_additive2').val();
			
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
			
			//EXTERNAL THICKNESS
			var mid_mtl_veil3		= $('#mid_mtl_veil3').val();
			var mid_mtl_veil_add3	= $('#mid_mtl_veil_add3').val();
			var mid_mtl_matcsm3		= $('#mid_mtl_matcsm3').val();
			var mid_mtl_csm_add3	= $('#mid_mtl_csm_add3').val();
			var mid_mtl_resin_tot3	= $('#mid_mtl_resin_tot3').val();
			
			var mid_mtl_katalis3	= $('#mid_mtl_katalis3').val();
			var mid_mtl_sm3			= $('#mid_mtl_sm3').val();
			var mid_mtl_cobalt3		= $('#mid_mtl_cobalt3').val();
			var mid_mtl_dma3		= $('#mid_mtl_dma3').val();
			var mid_mtl_hydro3		= $('#mid_mtl_hydro3').val();
			var mid_mtl_methanol3	= $('#mid_mtl_methanol3').val();
			// var mid_mtl_additive3	= $('#mid_mtl_additive3').val();
			
			var layer_veil3 		= $('#layer_veil3').val();
			var layer_veil_add3 	= $('#layer_veil_add3').val();
			var layer_matcsm3 		= $('#layer_matcsm3').val();
			var layer_csm_add3 		= $('#layer_csm_add3').val();
			
			var persen_katalis3 	= $('#persen_katalis3').val();
			var persen_sm3 			= $('#persen_sm3').val();
			var persen_coblat3 		= $('#persen_coblat3').val();
			var persen_dma3 		= $('#persen_dma3').val();
			var persen_hydroquinone3 = $('#persen_hydroquinone3').val();
			var persen_methanol3 	= $('#persen_methanol3').val();
			
			//TOPCOAT
			var mid_mtl_resin41		= $('#mid_mtl_resin41').val();
			var mid_mtl_katalis4	= $('#mid_mtl_katalis4').val();
			var mid_mtl_color4		= $('#mid_mtl_color4').val();
			var mid_mtl_tin4		= $('#mid_mtl_tin4').val();
			var mid_mtl_chl4		= $('#mid_mtl_chl4').val();
			var mid_mtl_stery4		= $('#mid_mtl_stery4').val();
			var mid_mtl_wax4		= $('#mid_mtl_dma3').val();
			var mid_mtl_mch4		= $('#mid_mtl_hydro3').val();
			// var mid_mtl_additive4	= $('#mid_mtl_methanol3').val();
			
			var persen_katalis4 	= $('#persen_katalis4').val();
			var persen_color4 		= $('#persen_color4').val();
			var layer_matcsm3 		= $('#layer_matcsm3').val();
			var persen_chl4 		= $('#persen_chl4').val();
			var persen_stery4 		= $('#persen_stery4').val();
			var persen_wax4 		= $('#persen_wax4').val();
			var persen_mch4 		= $('#persen_mch4').val();
			
			//Maxsimal Number
			var numberMax_liner		= $('#numberMax_liner').val();
			var numberMax_strukture	= $('#numberMax_strukture').val();
			var numberMax_external	= $('#numberMax_external').val();
			var numberMax_topcoat	= $('#numberMax_topcoat').val();
			
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
			if(top_diameter == '' || top_diameter == null || top_diameter == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'ID Pipe is Empty, please input first ...',
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
				  text	: 'Stiffness is Empty, please input first ...',
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
			if(top_app == '' || top_app == null || top_app == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'Application is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(top_toleran == '' || top_toleran == null || top_toleran == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'Tolerance by is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(type_elbow == '' || type_elbow == null || type_elbow == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'Type Radius is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(angle == '' || angle == null || angle == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'Angle is Empty, please input first ...',
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
			// if(mid_mtl_additive == '' || mid_mtl_additive == null || mid_mtl_additive == 0){
				// swal({
				  // title	: "Error Message!",
				  // text	: 'Additive Material [LINER THICKNESS] is Empty, please input first ...',
				  // type	: "warning"
				// });
				// $('#simpan-bro').prop('disabled',false);
				// return false;	
			// }
			
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
			// if(mid_mtl_additive2 == '' || mid_mtl_additive2 == null || mid_mtl_additive2 == 0){
				// swal({
				  // title	: "Error Message!",
				  // text	: 'Additive Material [STRUKTURE THICKNESS] is Empty, please input first ...',
				  // type	: "warning"
				// });
				// $('#simpan-bro').prop('disabled',false);
				// return false;	
			// }
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
			
			
			//EXTERNAL LAYER
			if(mid_mtl_veil3 == '' || mid_mtl_veil3 == null || mid_mtl_veil3 == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'Veil Material [EXTERNAL THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			
			if(mid_mtl_veil_add3 == '' || mid_mtl_veil_add3 == null || mid_mtl_veil_add3 == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'Veil Add Material [EXTERNAL THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(mid_mtl_matcsm3 == '' || mid_mtl_matcsm3 == null || mid_mtl_matcsm3 == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'MAT/CSM Material [EXTERNAL THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(mid_mtl_csm_add3 == '' || mid_mtl_csm_add3 == null || mid_mtl_csm_add3 == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'MAT/CSM Add Material [EXTERNAL THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(mid_mtl_resin_tot3 == '' || mid_mtl_resin_tot3 == null || mid_mtl_resin_tot3 == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'Resin Material [EXTERNAL THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			//==
			if(mid_mtl_katalis3 == '' || mid_mtl_katalis3 == null || mid_mtl_katalis3 == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'Katalis Material [EXTERNAL THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(mid_mtl_sm3 == '' || mid_mtl_sm3 == null || mid_mtl_sm3 == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'SM Material [EXTERNAL THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(mid_mtl_cobalt3 == '' || mid_mtl_cobalt3 == null || mid_mtl_cobalt3 == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'Cobalt Material [EXTERNAL THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(mid_mtl_dma3 == '' || mid_mtl_dma3 == null || mid_mtl_dma3 == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'DMA Material [EXTERNAL THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(mid_mtl_hydro3 == '' || mid_mtl_hydro3 == null || mid_mtl_hydro3 == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'Hydroquinone Material [EXTERNAL THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(mid_mtl_methanol3 == '' || mid_mtl_methanol3 == null || mid_mtl_methanol3 == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'Methanol Material [EXTERNAL THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			// if(mid_mtl_additive3 == '' || mid_mtl_additive3 == null || mid_mtl_additive3 == 0){
				// swal({
				  // title	: "Error Message!",
				  // text	: 'Additive Material [EXTERNAL THICKNESS] is Empty, please input first ...',
				  // type	: "warning"
				// });
				// $('#simpan-bro').prop('disabled',false);
				// return false;	
			// }
			//Tambahan
			if(layer_veil3 == '' || layer_veil3 == null || layer_veil3 == '.'){
				swal({
				  title	: "Error Message!",
				  text	: 'Layer Veil [EXTERNAL THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(layer_veil_add3 == '' || layer_veil_add3 == null || layer_veil_add3 == '.'){
				swal({
				  title	: "Error Message!",
				  text	: 'Layer Veil Add [EXTERNAL THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(layer_matcsm3 == '' || layer_matcsm3 == null || layer_matcsm3 == '.'){
				swal({
				  title	: "Error Message!",
				  text	: 'Layer MAT/CSM [EXTERNAL THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(layer_csm_add3 == '' || layer_csm_add3 == null || layer_csm_add3 == '.'){
				swal({
				  title	: "Error Message!",
				  text	: 'Layer MAT/CSM Add [EXTERNAL THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(persen_katalis3 == '' || persen_katalis3 == null || persen_katalis3 == '.'){
				swal({
				  title	: "Error Message!",
				  text	: 'Percent Katalis [EXTERNAL THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(persen_sm3 == '' || persen_sm3 == null || persen_sm3 == '.'){
				swal({
				  title	: "Error Message!",
				  text	: 'Percent SM [EXTERNAL THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(persen_coblat3 == '' || persen_coblat3 == null || persen_coblat3 == '.'){
				swal({
				  title	: "Error Message!",
				  text	: 'Percent Coblat [EXTERNAL THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(persen_dma3 == '' || persen_dma3 == null || persen_dma3 == '.'){
				swal({
				  title	: "Error Message!",
				  text	: 'Percent DMA [EXTERNAL THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(persen_hydroquinone3 == '' || persen_hydroquinone3 == null || persen_hydroquinone3 == '.'){
				swal({
				  title	: "Error Message!",
				  text	: 'Percent Hydroquinone [EXTERNAL THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(persen_methanol3 == '' || persen_methanol3 == null || persen_methanol3 == '.'){
				swal({
				  title	: "Error Message!",
				  text	: 'Percent Methanol [EXTERNAL THICKNESS] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			
			//TOPCOAT
			if(mid_mtl_resin41 == '' || mid_mtl_resin41 == null || mid_mtl_resin41 == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'Resin Material [TOPCOAT] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(mid_mtl_katalis4 == '' || mid_mtl_katalis4 == null || mid_mtl_katalis4 == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'Katalis Material [TOPCOAT] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(mid_mtl_color4 == '' || mid_mtl_color4 == null || mid_mtl_color4 == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'Color Material [TOPCOAT] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(mid_mtl_tin4 == '' || mid_mtl_tin4 == null || mid_mtl_tin4 == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'Tinuvin Material [TOPCOAT] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(mid_mtl_chl4 == '' || mid_mtl_chl4 == null || mid_mtl_chl4 == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'Chlroroform Material [TOPCOAT] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(mid_mtl_stery4 == '' || mid_mtl_stery4 == null || mid_mtl_stery4 == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'Steryne Monomer Material [TOPCOAT] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(mid_mtl_wax4 == '' || mid_mtl_wax4 == null || mid_mtl_wax4 == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'Solution Wax Material [TOPCOAT] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(mid_mtl_mch4 == '' || mid_mtl_mch4 == null || mid_mtl_mch4 == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'Methelene Chlorida Material [TOPCOAT] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			// if(mid_mtl_additive4 == '' || mid_mtl_additive4 == null || mid_mtl_additive4 == 0){
				// swal({
				  // title	: "Error Message!",
				  // text	: 'Additive Material [TOPCOAT] is Empty, please input first ...',
				  // type	: "warning"
				// });
				// $('#simpan-bro').prop('disabled',false);
				// return false;	
			// }
			//tambahan
			if(persen_katalis4 == '' || persen_katalis4 == null || persen_katalis4 == '.'){
				swal({
				  title	: "Error Message!",
				  text	: 'Percent Katalis [TOPCOAT] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(persen_color4 == '' || persen_color4 == null || persen_color4 == '.'){
				swal({
				  title	: "Error Message!",
				  text	: 'Percent Color [TOPCOAT] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(persen_tin4 == '' || persen_tin4 == null || persen_tin4 == '.'){
				swal({
				  title	: "Error Message!",
				  text	: 'Percent Tinuvin [TOPCOAT] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(persen_chl4 == '' || persen_chl4 == null || persen_chl4 == '.'){
				swal({
				  title	: "Error Message!",
				  text	: 'Percent Chlroroform [TOPCOAT] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(persen_stery4 == '' || persen_stery4 == null || persen_stery4 == '.'){
				swal({
				  title	: "Error Message!",
				  text	: 'Percent SM [TOPCOAT] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(persen_wax4 == '' || persen_wax4 == null || persen_wax4 == '.'){
				swal({
				  title	: "Error Message!",
				  text	: 'Percent Wax [TOPCOAT] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			if(persen_mch4 == '' || persen_mch4 == null || persen_mch4 == '.'){
				swal({
				  title	: "Error Message!",
				  text	: 'Percent Methanol [TOPCOAT] is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;	
			}
			
			//MAX Number
			if(numberMax_liner != 0 || numberMax_strukture != 0 || numberMax_external != 0 || numberMax_topcoat != 0){
				var intL = 0;
				var intError = 0;
				var pesan = '';
				
				if(numberMax_topcoat != 0){
					$('#detail_body_topcoat').find('tr').each(function(){
						intL++;
						var findId	= $(this).attr('id');
						// console.log(findId);
						// return false;
						var nomor	= findId.split('_');
						var perse_topcoat		= $('#perse_topcoat_'+nomor[1]).val();
						var containing_topcoat	= $('#containing_topcoat_'+nomor[1]).val();
						var id_material_topcoat	= $('#id_material_topcoat_'+nomor[1]).val();
						var id_category_topcoat	= $('#id_category_topcoat_'+nomor[1]).val();
						
						if(perse_topcoat == '' ){
							intError++;
							pesan = "Number "+nomor[1]+" : Percent [TOPCOAT] has not empty ...";
						}
						if(containing_topcoat == '' ){
							intError++;
							pesan = "Number "+nomor[1]+" : Comparison [TOPCOAT] has not empty ...";
						}
						if(id_material_topcoat == '' || id_material_topcoat == null || id_material_topcoat == 0 ){
							intError++;
							pesan = "Number "+nomor[1]+" : Material [TOPCOAT] has not selected ...";
						}
						if(id_category_topcoat == '' || id_category_topcoat == null || id_category_topcoat == 0 ){
							intError++;
							pesan = "Number "+nomor[1]+" : Category Material [TOPCOAT] has not selected ...";
						}
					});
				}
				
				if(numberMax_external != 0){
					$('#detail_body_external').find('tr').each(function(){
						intL++;
						var findId	= $(this).attr('id');
						// console.log(findId);
						// return false;
						var nomor	= findId.split('_');
						var perse_external			= $('#perse_external_'+nomor[1]).val();
						var containing_external	= $('#containing_external_'+nomor[1]).val();
						var id_material_external	= $('#id_material_external_'+nomor[1]).val();
						var id_category_external	= $('#id_category_external_'+nomor[1]).val();
						
						if(perse_external == '' ){
							intError++;
							pesan = "Number "+nomor[1]+" : Percent [EXTERNAL THICKNESS] has not empty ...";
						}
						if(containing_external == '' ){
							intError++;
							pesan = "Number "+nomor[1]+" : Comparison [EXTERNAL THICKNESS] has not empty ...";
						}
						if(id_material_external == '' || id_material_external == null || id_material_external == 0 ){
							intError++;
							pesan = "Number "+nomor[1]+" : Material [EXTERNAL THICKNESS] has not selected ...";
						}
						if(id_category_external == '' || id_category_external == null || id_category_external == 0 ){
							intError++;
							pesan = "Number "+nomor[1]+" : Category Material [EXTERNAL THICKNESS] has not selected ...";
						}
					});
				}
				
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
			var hasil_linier_thickness3 = $('#hasil_linier_thickness3').val();
			
			if(hasil_linier_thickness != 'OK' || hasil_linier_thickness2 != 'OK' || hasil_linier_thickness3 != 'OK' ){
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
						var baseurl		= base_url + active_controller +'/elbowmitter';
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
		
		
	});
	
function Hasil(a, b, c, d, e, top_diameter, top_thickness, waste, panjang){
	var acuhan_1			= parseFloat($('#acuhan_1').val());
	var top_min_toleran		= parseFloat($('#top_min_toleran').val());
	var min_lin_thickness	= acuhan_1 - (acuhan_1*top_min_toleran);
	var max_lin_thickness	= acuhan_1 + (acuhan_1*top_min_toleran);
	
	$('#mix_lin_thickness').val(min_lin_thickness.toFixed(4));
	$('#max_lin_thickness').val(max_lin_thickness.toFixed(4));
	
	var topEST				= parseFloat($('#tot_lin_thickness2').val()) + parseFloat($('#tot_lin_thickness3').val()) + parseFloat(a);
	
	var micron_plastic 		= parseFloat($('#micron_plastic').val());
	var layer_plastic		= parseFloat($('#layer_plastic').val());
	var weight_veil			= parseFloat($('#weight_veil').val());
	var layer_resin1		= parseFloat($('#layer_resin1').val());
	var weight_veil_add		= parseFloat($('#weight_veil_add').val());
	var layer_resin2		= parseFloat($('#layer_resin2').val());
	var weight_matcsm		= parseFloat($('#weight_matcsm').val());
	var layer_resin3		= parseFloat($('#layer_resin3').val());
	var weight_csm_add		= parseFloat($('#weight_csm_add').val());
	var layer_resin4		= parseFloat($('#layer_resin4').val());
	var layer_resin_tot		= parseFloat($('#layer_resin_tot').val());
	
	var persen_katalis		= parseFloat($('#persen_katalis').val());
	var persen_sm			= parseFloat($('#persen_sm').val());
	var persen_coblat		= parseFloat($('#persen_coblat').val());
	var persen_dma			= parseFloat($('#persen_dma').val());
	var persen_hydroquinone	= parseFloat($('#persen_hydroquinone').val());
	var persen_methanol		= parseFloat($('#persen_methanol').val());
	
	var perkalian = 1350;
	if(top_diameter < 25){
		var perkalian = 800;
	}
	
	var Luas_Area_Rumus		= 3.14 * (top_diameter + topEST) * panjang / 1000000 * (1+waste);
	// alert(Luas_Area_Rumus);
	var HasilPlastic		= (Luas_Area_Rumus * micron_plastic * perkalian * layer_plastic);
	
	var HasilVeil			= (Luas_Area_Rumus * weight_veil * b)/1000;
	var Hasillayer_resin1	= parseFloat(HasilVeil) * layer_resin1;
	
	var HasilVeilAdd		= (Luas_Area_Rumus * weight_veil_add * c)/1000;
	var Hasillayer_resin12	= parseFloat(HasilVeilAdd) * layer_resin2;
	
	var HasilMatCsm			= (Luas_Area_Rumus * weight_matcsm * d)/1000;
	var Hasillayer_resin13	= parseFloat(HasilMatCsm) * layer_resin3;
	
	var HasilMatCsmAdd		= (Luas_Area_Rumus * weight_csm_add * e)/1000;
	var Hasillayer_resin14	= parseFloat(HasilMatCsmAdd) * layer_resin4;
	
	var TotalResin			= (Luas_Area_Rumus* 1.2 *layer_resin_tot) + Hasillayer_resin14 + Hasillayer_resin13 + Hasillayer_resin12 + Hasillayer_resin1;
	
	if(TotalResin == '' || TotalResin == 0 || TotalResin == '0' || TotalResin == null){
		var Katalis	= 0;
		var Sm		= 0;
		var Coblat	= 0;
		var Dma		= 0;
		var Hyro	= 0;
		var Methanol= 0;
	}
	else if(TotalResin > 0){
		var Katalis	= 1;
		var Sm		= 1;
		var Coblat	= 0.6;
		var Dma		= 0.4;
		var Hyro	= 0.1;
		var Methanol= 0.9;
	}
	
	var HasilKatalis	= Katalis * (persen_katalis/100) * TotalResin;
	var HasilSm			= Sm * (persen_sm/100) * TotalResin;
	var HasilCoblat		= Coblat * (persen_coblat/100) * TotalResin;
	var HasilDma		= Dma * (persen_dma/100) * TotalResin;
	var HasilHydro		= Hyro * (persen_hydroquinone/100) * TotalResin;
	var HasilMethanol	= Methanol * (persen_methanol/100) * TotalResin;
	
	//TopCoat
	var ResinCoat		= parseFloat($("#resin41").val());
	
	var persen_katalis4	= parseFloat($("#persen_katalis4").val());
	var persen_color4	= parseFloat($("#persen_color4").val());
	var persen_tin4		= parseFloat($("#persen_tin4").val());
	var persen_chl4		= parseFloat($("#persen_chl4").val());
	var persen_stery4	= parseFloat($("#persen_stery4").val());
	var persen_wax4		= parseFloat($("#persen_wax4").val());
	var persen_mch4		= parseFloat($("#persen_mch4").val());
	
	var HasilTopCoat	= (Luas_Area_Rumus * 1.2 * ResinCoat);
	
	if(HasilTopCoat == '' || HasilTopCoat == 0 || HasilTopCoat == '0' || HasilTopCoat == null){
		var Katalis4	= 0;
		var Color4		= 0;
		var Tinuvin4	= 0;
		var Chlr4		= 0;
		var Stery4		= 0;
		var Wax4		= 0;
		var MetCh4		= 0;
		var Addv4		= 0;
	}
	else if(HasilTopCoat > 0){
		var Katalis4	= 1;
		var Color4		= 1;
		var Tinuvin4	= 0.1;
		var Chlr4		= 0.9;
		var Stery4		= 0.9;
		var Wax4		= 0.1;
		var MetCh4		= 1;
		var Addv4		= 1;
	}
	
	var HasilKatalis4	= Katalis4 * (persen_katalis4/100) * HasilTopCoat;
	var HasilColor4		= Color4 * (persen_color4/100) * HasilTopCoat;
	var HasilTinuvin4	= Tinuvin4 * (persen_tin4/100) * HasilTopCoat;
	var HasilChlr4		= Chlr4 * (persen_chl4/100) * HasilTopCoat;
	var HasilStery4		= Stery4 * (persen_stery4/100) * HasilTopCoat;
	var HasilWax4		= Wax4 * (persen_wax4/100) * HasilTopCoat;
	var HasilMetCh4		= MetCh4 * (persen_mch4/100) * HasilTopCoat;
	
	//Sampai Sini
	if(a < min_lin_thickness){
		var Hasil	= "TOO LOW";
	}
	if(a > max_lin_thickness){
		var Hasil	= "TOO HIGH";
	}
	if(a > min_lin_thickness && a < max_lin_thickness){
		var Hasil	= "OK";
	}
	$('#hasil_linier_thickness').val(Hasil);
	$('#top_tebal_est').val(RoundUpEST(topEST));
	
	$('#area').val(Luas_Area_Rumus.toFixed(4));
	$('#hasil_plastic').val(HasilPlastic);
	$('#last_plastic').val(RoundUp(HasilPlastic));
	$('#hasil_veil').val(RoundUp4(HasilVeil));
	$('#last_veil').val(RoundUp(HasilVeil));
	$('#hasil_resin1').val(RoundUp4(Hasillayer_resin1));
	$('#last_resin1').val(RoundUp(Hasillayer_resin1));
	$('#hasil_veil_add').val(RoundUp4(HasilVeilAdd));
	$('#last_veil_add').val(RoundUp(HasilVeilAdd));
	$('#hasil_resin2').val(RoundUp4(Hasillayer_resin12));
	$('#last_resin2').val(RoundUp(Hasillayer_resin12));
	$('#hasil_matcsm').val(RoundUp4(HasilMatCsm));
	$('#last_matcsm').val(RoundUp(HasilMatCsm));
	$('#hasil_resin3').val(RoundUp4(Hasillayer_resin13));
	$('#last_resin3').val(RoundUp(Hasillayer_resin13));
	$('#hasil_csm_add').val(RoundUp4(HasilMatCsmAdd));
	$('#last_csm_add').val(RoundUp(HasilMatCsmAdd));
	$('#hasil_resin4').val(RoundUp4(Hasillayer_resin14));
	$('#last_resin4').val(RoundUp(Hasillayer_resin14));
	
	$('#hasil_resin_tot').val(TotalResin);
	$('#last_resin_tot').val(RoundUp(TotalResin));
	
	$('#layer_katalis').val(Katalis);
	$('#hasil_katalis').val(RoundUp4(HasilKatalis));
	$('#last_katalis').val(RoundUp(HasilKatalis));
	
	$('#layer_sm').val(Sm);
	$('#hasil_sm').val(RoundUp4(HasilSm));
	$('#last_sm').val(RoundUp(HasilSm));
	
	$('#layer_coblat').val(Coblat);
	$('#hasil_coblat').val(RoundUp4(HasilCoblat));
	$('#last_cobalt').val(RoundUp(HasilCoblat));
	
	$('#layer_dma').val(Dma);
	$('#hasil_dma').val(RoundUp4(HasilDma));
	$('#last_dma').val(RoundUp(HasilDma));
	
	$('#layer_hydroquinone').val(Hyro);
	$('#hasil_hydroquinone').val(RoundUp4(HasilHydro));
	$('#last_hidro').val(RoundUp(HasilHydro));
	
	$('#layer_methanol').val(Methanol);
	$('#hasil_methanol').val(RoundUp4(HasilMethanol));
	$('#last_methanol').val(RoundUp(HasilMethanol));
	
	//TopCoat
	$('#hasil_resin41').val(RoundUp4(HasilTopCoat));
	$('#last_resin41').val(RoundUp(HasilTopCoat));
	
	$('#layer_katalis4').val(Katalis4);
	$('#hasil_katalis4').val(RoundUp4(HasilKatalis4));
	$('#last_katalis4').val(RoundUp(HasilKatalis4));
	
	$('#layer_color4').val(Color4);
	$('#hasil_color4').val(RoundUp4(HasilColor4));
	$('#last_color4').val(RoundUp(HasilColor4));
	
	$('#layer_tin4').val(Tinuvin4);
	$('#hasil_tin4').val(RoundUp4(HasilTinuvin4));
	$('#last_tin4').val(RoundUp(HasilTinuvin4));
	
	$('#layer_chl4').val(Chlr4);
	$('#hasil_chl4').val(RoundUp4(HasilChlr4));
	$('#last_chl4').val(RoundUp(HasilChlr4));
	
	$('#layer_stery4').val(Stery4);
	$('#hasil_stery4').val(RoundUp4(HasilStery4));
	$('#last_stery4').val(RoundUp(HasilStery4));
	
	$('#layer_wax4').val(Wax4);
	$('#hasil_wax4').val(RoundUp4(HasilWax4));
	$('#last_wax4').val(RoundUp(HasilWax4));
	
	$('#layer_mch4').val(MetCh4);
	$('#hasil_mch4').val(RoundUp4(HasilMetCh4));
	$('#last_mch4').val(RoundUp(HasilMetCh4));
}

function Hasil2(a, b, c, d, e, f, g, top_diameter, top_thickness, waste, panjang){
	var acuhan_2			= parseFloat($('#acuhan_2').val());
	var top_min_toleran		=  parseFloat($('#top_min_toleran').val());
	var min_lin_thickness	= acuhan_2 - (acuhan_2*top_min_toleran);
	var max_lin_thickness	= acuhan_2 + (acuhan_2*top_min_toleran);
	
	$('#mix_lin_thickness2').val(min_lin_thickness.toFixed(4));
	$('#max_lin_thickness2').val(max_lin_thickness.toFixed(4));
	
	var topEST				= parseFloat($('#tot_lin_thickness').val()) + parseFloat($('#tot_lin_thickness3').val()) + parseFloat(a);
	
	var weight_matcsm2		= parseFloat($('#weight_matcsm2').val());
	var layer_matcsm2		= parseFloat($('#layer_matcsm2').val());
	var weight_csm_add2		= parseFloat($('#weight_csm_add2').val());
	var layer_csm_add2		= parseFloat($('#layer_csm_add2').val());
	var weight_wr2			= parseFloat($('#weight_wr2').val());
	var layer_wr2			= parseFloat($('#layer_wr2').val());
	var weight_wr_add2		= parseFloat($('#weight_wr_add2').val());
	var layer_wr_add2		= parseFloat($('#layer_wr_add2').val());
	
	var weight_rooving21	= parseFloat($('#weight_rooving21').val());
	var penggali_rooving21	= parseFloat($('#penggali_rooving21').val());
	var bw_rooving21		= parseFloat($('#bw_rooving21').val());
	var jumlah_rooving21	= parseFloat($('#jumlah_rooving21').val());
	
	var weight_rooving22	= parseFloat($('#weight_rooving22').val());
	var penggali_rooving22	= parseFloat($('#penggali_rooving22').val());
	var bw_rooving22		= parseFloat($('#bw_rooving22').val());
	var jumlah_rooving22	= parseFloat($('#jumlah_rooving22').val());
	
	var layer_resin21		= parseFloat($('#layer_resin21').val());
	var layer_resin22		= parseFloat($('#layer_resin22').val());
	var layer_resin23		= parseFloat($('#layer_resin23').val());
	var layer_resin24		= parseFloat($('#layer_resin24').val());
	var layer_resin25		= parseFloat($('#layer_resin25').val());
	var layer_resin26		= parseFloat($('#layer_resin26').val());
	
	var persen_katalis2		= parseFloat($('#persen_katalis2').val());
	var persen_sm2			= parseFloat($('#persen_sm2').val());
	var persen_coblat2		= parseFloat($('#persen_coblat2').val());
	var persen_dma2			= parseFloat($('#persen_dma2').val());
	var persen_hydroquinone2	= parseFloat($('#persen_hydroquinone2').val());
	var persen_methanol2	= parseFloat($('#persen_methanol2').val());
	
	var Luas_Area_Rumus		= 3.14 * (top_diameter + topEST) * panjang / 1000000 * (1+waste);
	
	var HasilMadCsm			= (Luas_Area_Rumus * weight_matcsm2 * b)/1000;
	var Hasillayer21		= parseFloat(HasilMadCsm) * layer_resin21;
	var HasilMadCsmAdd		= (Luas_Area_Rumus * weight_csm_add2 * c)/1000;
	var Hasillayer22		= parseFloat(HasilMadCsmAdd) * layer_resin22;
	var HasilWr				= (Luas_Area_Rumus * weight_wr2 * d)/1000;
	var Hasillayer23		= parseFloat(HasilWr) * layer_resin23;
	var HasilWrAdd			= (Luas_Area_Rumus * weight_wr_add2 * e)/1000;
	var Hasillayer24		= parseFloat(HasilWrAdd) * layer_resin24;
	
	var HasilRoof21			= ((weight_rooving21 * 0.001 * jumlah_rooving21 * penggali_rooving21)/(bw_rooving21/10)) * (2/1000) * f * Luas_Area_Rumus;
	if(isNaN(HasilRoof21)){
		var HasilRoof21		= 0;
	}
	var Hasillayer25		= parseFloat(HasilRoof21) * layer_resin25;
	
	var HasilRoof22			= ((weight_rooving22 * 0.001 * jumlah_rooving22 * penggali_rooving22)/(bw_rooving22/10)) * (2/1000) * g * Luas_Area_Rumus;
	if(isNaN(HasilRoof22)){
		var HasilRoof22		= 0;
	}
	var Hasillayer26		= parseFloat(HasilRoof22) * layer_resin26;
	
	var TotalResin2			= Hasillayer21 + Hasillayer22 + Hasillayer23 + Hasillayer24 + Hasillayer25 + Hasillayer26;
	
	if(TotalResin2 == '' || TotalResin2 == 0 || TotalResin2 == '0' || TotalResin2 == null){
		var Katalis2	= 0;
		var Sm2			= 0;
		var Coblat2		= 0;
		var Dma2		= 0;
		var Hyro2		= 0;
		var Methanol2	= 0;
	}
	else if(TotalResin2 > 0){
		var Katalis2	= 1;
		var Sm2			= 1;
		var Coblat2		= 0.6;
		var Dma2		= 0.4;
		var Hyro2		= 0.1;
		var Methanol2	= 0.9;
	}
	
	var HasilKatalis2	= Katalis2 * (persen_katalis2/100) * TotalResin2;
	var HasilSm2		= Sm2 * (persen_sm2/100) * TotalResin2;
	var HasilCoblat2	= Coblat2 * (persen_coblat2/100) * TotalResin2;
	var HasilDma2		= Dma2 * (persen_dma2/100) * TotalResin2;
	var HasilHydro2		= Hyro2 * (persen_hydroquinone2/100) * TotalResin2;
	var HasilMethanol2	= Methanol2 * (persen_methanol2/100) * TotalResin2;
	
	//TopCoat
	var ResinCoat		= parseFloat($("#resin41").val());
	
	var persen_katalis4	= parseFloat($("#persen_katalis4").val());
	var persen_color4	= parseFloat($("#persen_color4").val());
	var persen_tin4		= parseFloat($("#persen_tin4").val());
	var persen_chl4		= parseFloat($("#persen_chl4").val());
	var persen_stery4	= parseFloat($("#persen_stery4").val());
	var persen_wax4		= parseFloat($("#persen_wax4").val());
	var persen_mch4		= parseFloat($("#persen_mch4").val());
	
	var HasilTopCoat	= (Luas_Area_Rumus * 1.2  * ResinCoat );
	
	if(HasilTopCoat == '' || HasilTopCoat == 0 || HasilTopCoat == '0' || HasilTopCoat == null){
		var Katalis4	= 0;
		var Color4		= 0;
		var Tinuvin4	= 0;
		var Chlr4		= 0;
		var Stery4		= 0;
		var Wax4		= 0;
		var MetCh4		= 0;
		var Addv4		= 0;
	}
	else if(HasilTopCoat > 0){
		var Katalis4	= 1;
		var Color4		= 1;
		var Tinuvin4	= 0.1;
		var Chlr4		= 0.9;
		var Stery4		= 0.9;
		var Wax4		= 0.1;
		var MetCh4		= 1;
		var Addv4		= 1;
	}
	
	var HasilKatalis4	= Katalis4 * (persen_katalis4/100) * HasilTopCoat;
	var HasilColor4		= Color4 * (persen_color4/100) * HasilTopCoat;
	var HasilTinuvin4	= Tinuvin4 * (persen_tin4/100) * HasilTopCoat;
	var HasilChlr4		= Chlr4 * (persen_chl4/100) * HasilTopCoat;
	var HasilStery4		= Stery4 * (persen_stery4/100) * HasilTopCoat;
	var HasilWax4		= Wax4 * (persen_wax4/100) * HasilTopCoat;
	var HasilMetCh4		= MetCh4 * (persen_mch4/100) * HasilTopCoat;
	
	//Sampai Sini
	if(a < min_lin_thickness){
		var Hasil	= "TOO LOW";
	}
	if(a > max_lin_thickness){
		var Hasil	= "TOO HIGH";
	}
	if(a > min_lin_thickness && a < max_lin_thickness){
		var Hasil	= "OK";
	}
	$('#hasil_linier_thickness2').val(Hasil);
	$('#top_tebal_est').val(RoundUpEST(topEST));
	
	$('#area').val(Luas_Area_Rumus.toFixed(4));
	
	//Hasil Perhitungan Hitam
	$('#hasil_matcsm2').val(RoundUp4(HasilMadCsm));
	$('#last_matcsm2').val(RoundUp(HasilMadCsm));
	$('#hasil_resin21').val(RoundUp4(Hasillayer21));
	$('#last_resin21').val(RoundUp(Hasillayer21));
	
	$('#hasil_csm_add2').val(RoundUp4(HasilMadCsmAdd));
	$('#last_csm_add2').val(RoundUp(HasilMadCsmAdd));
	$('#hasil_resin22').val(RoundUp4(Hasillayer22));
	$('#last_resin22').val(RoundUp(Hasillayer22));
	
	$('#hasil_wr2').val(RoundUp4(HasilWr));
	$('#last_wr2').val(RoundUp(HasilWr));
	$('#hasil_resin23').val(RoundUp4(Hasillayer23));
	$('#last_resin23').val(RoundUp(Hasillayer23));
	
	$('#hasil_wr_add2').val(RoundUp4(HasilWrAdd));
	$('#last_wr_add2').val(RoundUp(HasilWrAdd));
	$('#hasil_resin24').val(RoundUp4(Hasillayer24));
	$('#last_resin24').val(RoundUp(Hasillayer24));
	
	$('#hasil_rooving21').val(RoundUp4(HasilRoof21));
	$('#last_rooving21').val(RoundUp(HasilRoof21));
	$('#hasil_resin25').val(RoundUp4(Hasillayer25));
	$('#last_resin25').val(RoundUp(Hasillayer25));
	
	$('#hasil_rooving22').val(RoundUp4(HasilRoof22));
	$('#last_rooving22').val(RoundUp(HasilRoof22));
	$('#hasil_resin26').val(RoundUp4(Hasillayer26));
	$('#last_resin26').val(RoundUp(Hasillayer26));
	
	$('#hasil_resin_tot2').val(RoundUp4(TotalResin2));
	$('#last_resin_tot2').val(RoundUp(TotalResin2));
	
	$('#layer_katalis2').val(Katalis2);
	$('#hasil_katalis2').val(RoundUp4(HasilKatalis2));
	$('#last_katalis2').val(RoundUp(HasilKatalis2));
	
	$('#layer_sm2').val(Sm2);
	$('#hasil_sm2').val(RoundUp4(HasilSm2));
	$('#last_sm2').val(RoundUp(HasilSm2));
	
	$('#layer_coblat2').val(Coblat2);
	$('#hasil_coblat2').val(RoundUp4(HasilCoblat2));
	$('#last_cobalt2').val(RoundUp(HasilCoblat2));
	
	$('#layer_dma2').val(Dma2);
	$('#hasil_dma2').val(RoundUp4(HasilDma2));
	$('#last_dma2').val(RoundUp(HasilDma2));
	
	$('#layer_hydroquinone2').val(Hyro2);
	$('#hasil_hydroquinone2').val(RoundUp4(HasilHydro2));
	$('#last_hidro2').val(RoundUp(HasilHydro2));
	
	$('#layer_methanol2').val(Methanol2);
	$('#hasil_methanol2').val(RoundUp4(HasilMethanol2));
	$('#last_methanol2').val(RoundUp(HasilMethanol2));
	
	//TopCoat
	$('#hasil_resin41').val(RoundUp4(HasilTopCoat));
	$('#last_resin41').val(RoundUp(HasilTopCoat));
	
	$('#layer_katalis4').val(Katalis4);
	$('#hasil_katalis4').val(RoundUp4(HasilKatalis4));
	$('#last_katalis4').val(RoundUp(HasilKatalis4));
	
	$('#layer_color4').val(Color4);
	$('#hasil_color4').val(RoundUp4(HasilColor4));
	$('#last_color4').val(RoundUp(HasilColor4));
	
	$('#layer_tin4').val(Tinuvin4);
	$('#hasil_tin4').val(RoundUp4(HasilTinuvin4));
	$('#last_tin4').val(RoundUp(HasilTinuvin4));
	
	$('#layer_chl4').val(Chlr4);
	$('#hasil_chl4').val(RoundUp4(HasilChlr4));
	$('#last_chl4').val(RoundUp(HasilChlr4));
	
	$('#layer_stery4').val(Stery4);
	$('#hasil_stery4').val(RoundUp4(HasilStery4));
	$('#last_stery4').val(RoundUp(HasilStery4));
	
	$('#layer_wax4').val(Wax4);
	$('#hasil_wax4').val(RoundUp4(HasilWax4));
	$('#last_wax4').val(RoundUp(HasilWax4));
	
	$('#layer_mch4').val(MetCh4);
	$('#hasil_mch4').val(RoundUp4(HasilMetCh4));
	$('#last_mch4').val(RoundUp(HasilMetCh4));
}

function Hasil3(a, b, c, d, e, top_diameter, top_thickness, waste, panjang){
	var acuhan_3			= parseFloat($('#acuhan_3').val());
	var top_min_toleran		=  parseFloat($('#top_min_toleran').val());
	var min_lin_thickness	= acuhan_3 - (acuhan_3*top_min_toleran);
	var max_lin_thickness	= acuhan_3 + (acuhan_3*top_min_toleran);
	
	$('#mix_lin_thickness3').val(min_lin_thickness.toFixed(4));
	$('#max_lin_thickness3').val(max_lin_thickness.toFixed(4));
	
	var topEST				= parseFloat($('#tot_lin_thickness').val()) + parseFloat($('#tot_lin_thickness2').val()) + parseFloat(a);
	
	//perhitungan hitam
	var weight_veil3		= parseFloat($('#weight_veil3').val());
	var weight_veil_add3	= parseFloat($('#weight_veil_add3').val());
	var weight_matcsm3		= parseFloat($('#weight_matcsm3').val());
	var weight_csm_add3		= parseFloat($('#weight_csm_add3').val());
	
	var layer_resin31		= parseFloat($('#layer_resin31').val());
	var layer_resin32		= parseFloat($('#layer_resin32').val());
	var layer_resin33		= parseFloat($('#layer_resin33').val());
	var layer_resin34		= parseFloat($('#layer_resin34').val());
	
	var persen_katalis3		= parseFloat($('#persen_katalis3').val());
	var persen_sm3			= parseFloat($('#persen_sm3').val());
	var persen_coblat3		= parseFloat($('#persen_coblat3').val());
	var persen_dma3			= parseFloat($('#persen_dma3').val());
	var persen_hydroquinone3	= parseFloat($('#persen_hydroquinone3').val());
	var persen_methanol3	= parseFloat($('#persen_methanol3').val());
	
	var Luas_Area_Rumus		= 3.14 * (top_diameter + topEST) * panjang / 1000000 * (1+waste);
	
	var HasilVeil3			= (Luas_Area_Rumus * weight_veil3 * b)/1000;
	var Hasillayer31		= parseFloat(HasilVeil3) * layer_resin31;
	var HasilVeilAdd3		= (Luas_Area_Rumus * weight_veil_add3 * c)/1000;
	var Hasillayer32		= parseFloat(HasilVeilAdd3) * layer_resin32;
	var HasilMadCsm3		= (Luas_Area_Rumus * weight_matcsm3 * d)/1000;
	var Hasillayer33		= parseFloat(HasilMadCsm3) * layer_resin33;
	var HasilMadCsmAdd3		= (Luas_Area_Rumus * weight_csm_add3 * e)/1000;
	var Hasillayer34		= parseFloat(HasilMadCsmAdd3) * layer_resin34;
	
	var TotalResin3			= Hasillayer31 + Hasillayer32 + Hasillayer33 + Hasillayer34;
	
	if(TotalResin3 == '' || TotalResin3 == 0 || TotalResin3 == '0' || TotalResin3 == null){
		var Katalis3	= 0;
		var Sm3			= 0;
		var Coblat3		= 0;
		var Dma3		= 0;
		var Hyro3		= 0;
		var Methanol3	= 0;
	}
	else if(TotalResin3 > 0){
		var Katalis3	= 1;
		var Sm3			= 1;
		var Coblat3		= 0.6;
		var Dma3		= 0.4;
		var Hyro3		= 0.1;
		var Methanol3	= 0.9;
	}
	
	var HasilKatalis3	= Katalis3 * (persen_katalis3/100) * TotalResin3;
	var HasilSm3		= Sm3 * (persen_sm3/100) * TotalResin3;
	var HasilCoblat3	= Coblat3 * (persen_coblat3/100) * TotalResin3;
	var HasilDma3		= Dma3 * (persen_dma3/100) * TotalResin3;
	var HasilHydro3		= Hyro3 * (persen_hydroquinone3/100) * TotalResin3;
	var HasilMethanol3	= Methanol3 * (persen_methanol3/100) * TotalResin3;
	
	//TopCoat
	var ResinCoat		= parseFloat($("#resin41").val());
	
	var persen_katalis4	= parseFloat($("#persen_katalis4").val());
	var persen_color4	= parseFloat($("#persen_color4").val());
	var persen_tin4		= parseFloat($("#persen_tin4").val());
	var persen_chl4		= parseFloat($("#persen_chl4").val());
	var persen_stery4	= parseFloat($("#persen_stery4").val());
	var persen_wax4		= parseFloat($("#persen_wax4").val());
	var persen_mch4		= parseFloat($("#persen_mch4").val());
	
	var HasilTopCoat	= (Luas_Area_Rumus * 1.2 * ResinCoat);
	
	if(HasilTopCoat == '' || HasilTopCoat == 0 || HasilTopCoat == '0' || HasilTopCoat == null){
		var Katalis4	= 0;
		var Color4		= 0;
		var Tinuvin4	= 0;
		var Chlr4		= 0;
		var Stery4		= 0;
		var Wax4		= 0;
		var MetCh4		= 0;
		var Addv4		= 0;
	}
	else if(HasilTopCoat > 0){
		var Katalis4	= 1;
		var Color4		= 1;
		var Tinuvin4	= 0.1;
		var Chlr4		= 0.9;
		var Stery4		= 0.9;
		var Wax4		= 0.1;
		var MetCh4		= 1;
		var Addv4		= 1;
	}
	
	var HasilKatalis4	= Katalis4 * (persen_katalis4/100) * HasilTopCoat;
	var HasilColor4		= Color4 * (persen_color4/100) * HasilTopCoat;
	var HasilTinuvin4	= Tinuvin4 * (persen_tin4/100) * HasilTopCoat;
	var HasilChlr4		= Chlr4 * (persen_chl4/100) * HasilTopCoat;
	var HasilStery4		= Stery4 * (persen_stery4/100) * HasilTopCoat;
	var HasilWax4		= Wax4 * (persen_wax4/100) * HasilTopCoat;
	var HasilMetCh4		= MetCh4 * (persen_mch4/100) * HasilTopCoat;
	
	//sampai sini
	if(a < min_lin_thickness){
		var Hasil	= "TOO LOW";
	}
	if(a > max_lin_thickness){
		var Hasil	= "TOO HIGH";
	}
	if(a > min_lin_thickness && a < max_lin_thickness){
		var Hasil	= "OK";
	}
	$('#hasil_linier_thickness3').val(Hasil);
	$('#top_tebal_est').val(RoundUpEST(topEST));
	$('#area').val(Luas_Area_Rumus.toFixed(4));
	
	//Penjumlahan Hitam
	$('#hasil_veil3').val(RoundUp4(HasilVeil3)); 
	$('#last_veil3').val(RoundUp(HasilVeil3));
	$('#hasil_resin31').val(RoundUp4(Hasillayer31));
	$('#last_resin31').val(RoundUp(Hasillayer31));
	
	$('#hasil_veil_add3').val(RoundUp4(HasilVeilAdd3));
	$('#last_veil_add3').val(RoundUp(HasilVeilAdd3));
	$('#hasil_resin32').val(RoundUp4(Hasillayer32));
	$('#last_resin32').val(RoundUp(Hasillayer32));
	
	$('#hasil_matcsm3').val(RoundUp4(HasilMadCsm3));
	$('#last_matcsm3').val(RoundUp(HasilMadCsm3));
	$('#hasil_resin33').val(RoundUp4(Hasillayer33));
	$('#last_resin33').val(RoundUp(Hasillayer33));
	
	$('#hasil_csm_add3').val(RoundUp4(HasilMadCsmAdd3));
	$('#last_csm_add3').val(RoundUp(HasilMadCsmAdd3));
	$('#hasil_resin34').val(RoundUp4(Hasillayer34));
	$('#last_resin34').val(RoundUp(Hasillayer34)); 
	
	$('#hasil_resin_tot3').val(RoundUp4(TotalResin3));
	$('#last_resin_tot3').val(RoundUp(TotalResin3));
	
	$('#layer_katalis3').val(Katalis3);
	$('#hasil_katalis3').val(RoundUp4(HasilKatalis3));
	$('#last_katalis3').val(RoundUp(HasilKatalis3));
	
	$('#layer_sm3').val(Sm3);
	$('#hasil_sm3').val(RoundUp4(HasilSm3));
	$('#last_sm3').val(RoundUp(HasilSm3));
	
	$('#layer_coblat3').val(Coblat3);
	$('#hasil_coblat3').val(RoundUp4(HasilCoblat3));
	$('#last_cobalt3').val(RoundUp(HasilCoblat3));
	
	$('#layer_dma3').val(Dma3);
	$('#hasil_dma3').val(RoundUp4(HasilDma3));
	$('#last_dma3').val(RoundUp(HasilDma3));
	
	$('#layer_hydroquinone3').val(Hyro3);
	$('#hasil_hydroquinone3').val(RoundUp4(HasilHydro3));
	$('#last_hidro3').val(RoundUp(HasilHydro3));
	
	$('#layer_methanol3').val(Methanol3);
	$('#hasil_methanol3').val(RoundUp4(HasilMethanol3));
	$('#last_methanol3').val(RoundUp(HasilMethanol3));
	
	//TopCoat
	$('#hasil_resin41').val(RoundUp4(HasilTopCoat));
	$('#last_resin41').val(RoundUp(HasilTopCoat));
	
	$('#layer_katalis4').val(Katalis4);
	$('#hasil_katalis4').val(RoundUp4(HasilKatalis4));
	$('#last_katalis4').val(RoundUp(HasilKatalis4));
	
	$('#layer_color4').val(Color4);
	$('#hasil_color4').val(RoundUp4(HasilColor4));
	$('#last_color4').val(RoundUp(HasilColor4));
	
	$('#layer_tin4').val(Tinuvin4);
	$('#hasil_tin4').val(RoundUp4(HasilTinuvin4));
	$('#last_tin4').val(RoundUp(HasilTinuvin4));
	
	$('#layer_chl4').val(Chlr4);
	$('#hasil_chl4').val(RoundUp4(HasilChlr4));
	$('#last_chl4').val(RoundUp(HasilChlr4));
	
	$('#layer_stery4').val(Stery4);
	$('#hasil_stery4').val(RoundUp4(HasilStery4));
	$('#last_stery4').val(RoundUp(HasilStery4));
	
	$('#layer_wax4').val(Wax4);
	$('#hasil_wax4').val(RoundUp4(HasilWax4));
	$('#last_wax4').val(RoundUp(HasilWax4));
	
	$('#layer_mch4').val(MetCh4);
	$('#hasil_mch4').val(RoundUp4(HasilMetCh4));
	$('#last_mch4').val(RoundUp(HasilMetCh4));
}

function AreaChange(a, b, c, d, e, top_diameter, top_thickness, waste, topEST, Luas_Area_Rumus, panjang){
	var acuhan_1			= parseFloat($('#acuhan_1').val());
	var top_min_toleran		= parseFloat($('#top_min_toleran').val());
	var min_lin_thickness	= acuhan_1 - (acuhan_1*top_min_toleran);
	var max_lin_thickness	= acuhan_1 + (acuhan_1*top_min_toleran);
	
	$('#mix_lin_thickness').val(min_lin_thickness.toFixed(4));
	$('#max_lin_thickness').val(max_lin_thickness.toFixed(4));
	
	var micron_plastic 		= parseFloat($('#micron_plastic').val());
	var layer_plastic		= parseFloat($('#layer_plastic').val());
	var weight_veil			= parseFloat($('#weight_veil').val());
	var layer_resin1		= parseFloat($('#layer_resin1').val());
	var weight_veil_add		= parseFloat($('#weight_veil_add').val());
	var layer_resin2		= parseFloat($('#layer_resin2').val());
	var weight_matcsm		= parseFloat($('#weight_matcsm').val());
	var layer_resin3		= parseFloat($('#layer_resin3').val());
	var weight_csm_add		= parseFloat($('#weight_csm_add').val());
	var layer_resin4		= parseFloat($('#layer_resin4').val());
	var layer_resin_tot		= parseFloat($('#layer_resin_tot').val());
	
	var persen_katalis		= parseFloat($('#persen_katalis').val());
	var persen_sm			= parseFloat($('#persen_sm').val());
	var persen_coblat		= parseFloat($('#persen_coblat').val());
	var persen_dma			= parseFloat($('#persen_dma').val());
	var persen_hydroquinone	= parseFloat($('#persen_hydroquinone').val());
	var persen_methanol		= parseFloat($('#persen_methanol').val());
	
	var perkalian = 1350;
	if(top_diameter < 25){
		var perkalian = 800;
	}
	
	var Luas_Area_Rumus		= 3.14 * (top_diameter + topEST) * panjang / 1000000 * (1+waste);
	
	var HasilPlastic		= (Luas_Area_Rumus * micron_plastic * perkalian * layer_plastic);
	
	var HasilVeil			= (Luas_Area_Rumus * weight_veil * b)/1000;
	var Hasillayer_resin1	= parseFloat(HasilVeil) * layer_resin1;
	
	var HasilVeilAdd		= (Luas_Area_Rumus * weight_veil_add * c)/1000;
	var Hasillayer_resin12	= parseFloat(HasilVeilAdd) * layer_resin2;
	
	var HasilMatCsm			= (Luas_Area_Rumus * weight_matcsm * d)/1000;
	var Hasillayer_resin13	= parseFloat(HasilMatCsm) * layer_resin3;
	
	var HasilMatCsmAdd		= (Luas_Area_Rumus * weight_csm_add * e)/1000;
	var Hasillayer_resin14	= parseFloat(HasilMatCsmAdd) * layer_resin4;
	
	var TotalResin			= (Luas_Area_Rumus* 1.2 *layer_resin_tot) + Hasillayer_resin14 + Hasillayer_resin13 + Hasillayer_resin12 + Hasillayer_resin1;
	
	if(TotalResin == '' || TotalResin == 0 || TotalResin == '0' || TotalResin == null){
		var Katalis	= 0;
		var Sm		= 0;
		var Coblat	= 0;
		var Dma		= 0;
		var Hyro	= 0;
		var Methanol= 0;
	}
	else if(TotalResin > 0){
		var Katalis	= 1;
		var Sm		= 1;
		var Coblat	= 0.6;
		var Dma		= 0.4;
		var Hyro	= 0.1;
		var Methanol= 0.9;
	}
	
	var HasilKatalis	= Katalis * (persen_katalis/100) * TotalResin;
	var HasilSm			= Sm * (persen_sm/100) * TotalResin;
	var HasilCoblat		= Coblat * (persen_coblat/100) * TotalResin;
	var HasilDma		= Dma * (persen_dma/100) * TotalResin;
	var HasilHydro		= Hyro * (persen_hydroquinone/100) * TotalResin;
	var HasilMethanol	= Methanol * (persen_methanol/100) * TotalResin;
	
	//TopCoat
	var ResinCoat		= parseFloat($("#resin41").val());
	
	var persen_katalis4	= parseFloat($("#persen_katalis4").val());
	var persen_color4	= parseFloat($("#persen_color4").val());
	var persen_tin4		= parseFloat($("#persen_tin4").val());
	var persen_chl4		= parseFloat($("#persen_chl4").val());
	var persen_stery4	= parseFloat($("#persen_stery4").val());
	var persen_wax4		= parseFloat($("#persen_wax4").val());
	var persen_mch4		= parseFloat($("#persen_mch4").val());
	
	var HasilTopCoat	= (Luas_Area_Rumus * 1.2 * ResinCoat);
	
	if(HasilTopCoat == '' || HasilTopCoat == 0 || HasilTopCoat == '0' || HasilTopCoat == null){
		var Katalis4	= 0;
		var Color4		= 0;
		var Tinuvin4	= 0;
		var Chlr4		= 0;
		var Stery4		= 0;
		var Wax4		= 0;
		var MetCh4		= 0;
		var Addv4		= 0;
	}
	else if(HasilTopCoat > 0){
		var Katalis4	= 1;
		var Color4		= 1;
		var Tinuvin4	= 0.1;
		var Chlr4		= 0.9;
		var Stery4		= 0.9;
		var Wax4		= 0.1;
		var MetCh4		= 1;
		var Addv4		= 1;
	}
	
	var HasilKatalis4	= Katalis4 * (persen_katalis4/100) * HasilTopCoat;
	var HasilColor4		= Color4 * (persen_color4/100) * HasilTopCoat;
	var HasilTinuvin4	= Tinuvin4 * (persen_tin4/100) * HasilTopCoat;
	var HasilChlr4		= Chlr4 * (persen_chl4/100) * HasilTopCoat;
	var HasilStery4		= Stery4 * (persen_stery4/100) * HasilTopCoat;
	var HasilWax4		= Wax4 * (persen_wax4/100) * HasilTopCoat;
	var HasilMetCh4		= MetCh4 * (persen_mch4/100) * HasilTopCoat;
	
	//Sampai Sini
	if(a < min_lin_thickness){
		var Hasil	= "TOO LOW";
	}
	if(a > max_lin_thickness){
		var Hasil	= "TOO HIGH";
	}
	if(a > min_lin_thickness && a < max_lin_thickness){
		var Hasil	= "OK";
	}
	$('#hasil_linier_thickness').val(Hasil);
	$('#top_tebal_est').val(RoundUpEST(topEST));
	
	$('#area').val(Luas_Area_Rumus.toFixed(4));
	$('#hasil_plastic').val(HasilPlastic);
	$('#last_plastic').val(RoundUp(HasilPlastic));
	$('#hasil_veil').val(RoundUp4(HasilVeil));
	$('#last_veil').val(RoundUp(HasilVeil));
	$('#hasil_resin1').val(RoundUp4(Hasillayer_resin1));
	$('#last_resin1').val(RoundUp(Hasillayer_resin1));
	$('#hasil_veil_add').val(RoundUp4(HasilVeilAdd));
	$('#last_veil_add').val(RoundUp(HasilVeilAdd));
	$('#hasil_resin2').val(RoundUp4(Hasillayer_resin12));
	$('#last_resin2').val(RoundUp(Hasillayer_resin12));
	$('#hasil_matcsm').val(RoundUp4(HasilMatCsm));
	$('#last_matcsm').val(RoundUp(HasilMatCsm));
	$('#hasil_resin3').val(RoundUp4(Hasillayer_resin13));
	$('#last_resin3').val(RoundUp(Hasillayer_resin13));
	$('#hasil_csm_add').val(RoundUp4(HasilMatCsmAdd));
	$('#last_csm_add').val(RoundUp(HasilMatCsmAdd));
	$('#hasil_resin4').val(RoundUp4(Hasillayer_resin14));
	$('#last_resin4').val(RoundUp(Hasillayer_resin14));
	
	$('#hasil_resin_tot').val(TotalResin);
	$('#last_resin_tot').val(RoundUp(TotalResin));
	
	$('#layer_katalis').val(Katalis);
	$('#hasil_katalis').val(RoundUp4(HasilKatalis));
	$('#last_katalis').val(RoundUp(HasilKatalis));
	
	$('#layer_sm').val(Sm);
	$('#hasil_sm').val(RoundUp4(HasilSm));
	$('#last_sm').val(RoundUp(HasilSm));
	
	$('#layer_coblat').val(Coblat);
	$('#hasil_coblat').val(RoundUp4(HasilCoblat));
	$('#last_cobalt').val(RoundUp(HasilCoblat));
	
	$('#layer_dma').val(Dma);
	$('#hasil_dma').val(RoundUp4(HasilDma));
	$('#last_dma').val(RoundUp(HasilDma));
	
	$('#layer_hydroquinone').val(Hyro);
	$('#hasil_hydroquinone').val(RoundUp4(HasilHydro));
	$('#last_hidro').val(RoundUp(HasilHydro));
	
	$('#layer_methanol').val(Methanol);
	$('#hasil_methanol').val(RoundUp4(HasilMethanol));
	$('#last_methanol').val(RoundUp(HasilMethanol));
	
	//TopCoat
	$('#hasil_resin41').val(RoundUp4(HasilTopCoat));
	$('#last_resin41').val(RoundUp(HasilTopCoat));
	
	$('#layer_katalis4').val(Katalis4);
	$('#hasil_katalis4').val(RoundUp4(HasilKatalis4));
	$('#last_katalis4').val(RoundUp(HasilKatalis4));
	
	$('#layer_color4').val(Color4);
	$('#hasil_color4').val(RoundUp4(HasilColor4));
	$('#last_color4').val(RoundUp(HasilColor4));
	
	$('#layer_tin4').val(Tinuvin4);
	$('#hasil_tin4').val(RoundUp4(HasilTinuvin4));
	$('#last_tin4').val(RoundUp(HasilTinuvin4));
	
	$('#layer_chl4').val(Chlr4);
	$('#hasil_chl4').val(RoundUp4(HasilChlr4));
	$('#last_chl4').val(RoundUp(HasilChlr4));
	
	$('#layer_stery4').val(Stery4);
	$('#hasil_stery4').val(RoundUp4(HasilStery4));
	$('#last_stery4').val(RoundUp(HasilStery4));
	
	$('#layer_wax4').val(Wax4);
	$('#hasil_wax4').val(RoundUp4(HasilWax4));
	$('#last_wax4').val(RoundUp(HasilWax4));
	
	$('#layer_mch4').val(MetCh4);
	$('#hasil_mch4').val(RoundUp4(HasilMetCh4));
	$('#last_mch4').val(RoundUp(HasilMetCh4));
}

function AreaChange2(a, b, c, d, e, f, g, top_diameter, top_thickness, waste, topEST, Luas_Area_Rumus, panjang){
	var acuhan_2			= parseFloat($('#acuhan_2').val());
	var top_min_toleran		=  parseFloat($('#top_min_toleran').val());
	var min_lin_thickness	= acuhan_2 - (acuhan_2*top_min_toleran);
	var max_lin_thickness	= acuhan_2 + (acuhan_2*top_min_toleran);
	
	$('#mix_lin_thickness2').val(min_lin_thickness.toFixed(4));
	$('#max_lin_thickness2').val(max_lin_thickness.toFixed(4));
	
	var topEST				= parseFloat($('#tot_lin_thickness').val()) + parseFloat($('#tot_lin_thickness3').val()) + parseFloat(a);
	
	var weight_matcsm2		= parseFloat($('#weight_matcsm2').val());
	var layer_matcsm2		= parseFloat($('#layer_matcsm2').val());
	var weight_csm_add2		= parseFloat($('#weight_csm_add2').val());
	var layer_csm_add2		= parseFloat($('#layer_csm_add2').val());
	var weight_wr2			= parseFloat($('#weight_wr2').val());
	var layer_wr2			= parseFloat($('#layer_wr2').val());
	var weight_wr_add2		= parseFloat($('#weight_wr_add2').val());
	var layer_wr_add2		= parseFloat($('#layer_wr_add2').val());
	
	var weight_rooving21	= parseFloat($('#weight_rooving21').val());
	var penggali_rooving21	= parseFloat($('#penggali_rooving21').val());
	var bw_rooving21		= parseFloat($('#bw_rooving21').val());
	var jumlah_rooving21	= parseFloat($('#jumlah_rooving21').val());
	
	var weight_rooving22	= parseFloat($('#weight_rooving22').val());
	var penggali_rooving22	= parseFloat($('#penggali_rooving22').val());
	var bw_rooving22		= parseFloat($('#bw_rooving22').val());
	var jumlah_rooving22	= parseFloat($('#jumlah_rooving22').val());
	
	var layer_resin21		= parseFloat($('#layer_resin21').val());
	var layer_resin22		= parseFloat($('#layer_resin22').val());
	var layer_resin23		= parseFloat($('#layer_resin23').val());
	var layer_resin24		= parseFloat($('#layer_resin24').val());
	var layer_resin25		= parseFloat($('#layer_resin25').val());
	var layer_resin26		= parseFloat($('#layer_resin26').val());
	
	var persen_katalis2		= parseFloat($('#persen_katalis2').val());
	var persen_sm2			= parseFloat($('#persen_sm2').val());
	var persen_coblat2		= parseFloat($('#persen_coblat2').val());
	var persen_dma2			= parseFloat($('#persen_dma2').val());
	var persen_hydroquinone2	= parseFloat($('#persen_hydroquinone2').val());
	var persen_methanol2	= parseFloat($('#persen_methanol2').val());
	
	var Luas_Area_Rumus		= 3.14 * (top_diameter + topEST) * panjang / 1000000 * (1+waste);
	
	var HasilMadCsm			= (Luas_Area_Rumus * weight_matcsm2 * b)/1000;
	var Hasillayer21		= parseFloat(HasilMadCsm) * layer_resin21;
	var HasilMadCsmAdd		= (Luas_Area_Rumus * weight_csm_add2 * c)/1000;
	var Hasillayer22		= parseFloat(HasilMadCsmAdd) * layer_resin22;
	var HasilWr				= (Luas_Area_Rumus * weight_wr2 * d)/1000;
	var Hasillayer23		= parseFloat(HasilWr) * layer_resin23;
	var HasilWrAdd			= (Luas_Area_Rumus * weight_wr_add2 * e)/1000;
	var Hasillayer24		= parseFloat(HasilWrAdd) * layer_resin24;
	
	var HasilRoof21			= ((weight_rooving21 * 0.001 * jumlah_rooving21 * penggali_rooving21)/(bw_rooving21/10)) * (2/1000) * f * Luas_Area_Rumus;
	if(isNaN(HasilRoof21)){
		var HasilRoof21		= 0;
	}
	var Hasillayer25		= parseFloat(HasilRoof21) * layer_resin25;
	
	var HasilRoof22			= ((weight_rooving22 * 0.001 * jumlah_rooving22 * penggali_rooving22)/(bw_rooving22/10)) * (2/1000) * g * Luas_Area_Rumus;
	if(isNaN(HasilRoof22)){
		var HasilRoof22		= 0;
	}
	var Hasillayer26		= parseFloat(HasilRoof22) * layer_resin26;
	
	var TotalResin2			= Hasillayer21 + Hasillayer22 + Hasillayer23 + Hasillayer24 + Hasillayer25 + Hasillayer26;
	
	if(TotalResin2 == '' || TotalResin2 == 0 || TotalResin2 == '0' || TotalResin2 == null){
		var Katalis2	= 0;
		var Sm2			= 0;
		var Coblat2		= 0;
		var Dma2		= 0;
		var Hyro2		= 0;
		var Methanol2	= 0;
	}
	else if(TotalResin2 > 0){
		var Katalis2	= 1;
		var Sm2			= 1;
		var Coblat2		= 0.6;
		var Dma2		= 0.4;
		var Hyro2		= 0.1;
		var Methanol2	= 0.9;
	}
	
	var HasilKatalis2	= Katalis2 * (persen_katalis2/100) * TotalResin2;
	var HasilSm2		= Sm2 * (persen_sm2/100) * TotalResin2;
	var HasilCoblat2	= Coblat2 * (persen_coblat2/100) * TotalResin2;
	var HasilDma2		= Dma2 * (persen_dma2/100) * TotalResin2;
	var HasilHydro2		= Hyro2 * (persen_hydroquinone2/100) * TotalResin2;
	var HasilMethanol2	= Methanol2 * (persen_methanol2/100) * TotalResin2;
	
	//TopCoat
	var ResinCoat		= parseFloat($("#resin41").val());
	
	var persen_katalis4	= parseFloat($("#persen_katalis4").val());
	var persen_color4	= parseFloat($("#persen_color4").val());
	var persen_tin4		= parseFloat($("#persen_tin4").val());
	var persen_chl4		= parseFloat($("#persen_chl4").val());
	var persen_stery4	= parseFloat($("#persen_stery4").val());
	var persen_wax4		= parseFloat($("#persen_wax4").val());
	var persen_mch4		= parseFloat($("#persen_mch4").val());
	
	var HasilTopCoat	= (Luas_Area_Rumus * 1.2  * ResinCoat );
	
	if(HasilTopCoat == '' || HasilTopCoat == 0 || HasilTopCoat == '0' || HasilTopCoat == null){
		var Katalis4	= 0;
		var Color4		= 0;
		var Tinuvin4	= 0;
		var Chlr4		= 0;
		var Stery4		= 0;
		var Wax4		= 0;
		var MetCh4		= 0;
		var Addv4		= 0;
	}
	else if(HasilTopCoat > 0){
		var Katalis4	= 1;
		var Color4		= 1;
		var Tinuvin4	= 0.1;
		var Chlr4		= 0.9;
		var Stery4		= 0.9;
		var Wax4		= 0.1;
		var MetCh4		= 1;
		var Addv4		= 1;
	}
	
	var HasilKatalis4	= Katalis4 * (persen_katalis4/100) * HasilTopCoat;
	var HasilColor4		= Color4 * (persen_color4/100) * HasilTopCoat;
	var HasilTinuvin4	= Tinuvin4 * (persen_tin4/100) * HasilTopCoat;
	var HasilChlr4		= Chlr4 * (persen_chl4/100) * HasilTopCoat;
	var HasilStery4		= Stery4 * (persen_stery4/100) * HasilTopCoat;
	var HasilWax4		= Wax4 * (persen_wax4/100) * HasilTopCoat;
	var HasilMetCh4		= MetCh4 * (persen_mch4/100) * HasilTopCoat;
	
	//Sampai Sini
	if(a < min_lin_thickness){
		var Hasil	= "TOO LOW";
	}
	if(a > max_lin_thickness){
		var Hasil	= "TOO HIGH";
	}
	if(a > min_lin_thickness && a < max_lin_thickness){
		var Hasil	= "OK";
	}
	$('#hasil_linier_thickness2').val(Hasil);
	$('#top_tebal_est').val(RoundUpEST(topEST));
	
	$('#area').val(Luas_Area_Rumus.toFixed(4));
	
	//Hasil Perhitungan Hitam
	$('#hasil_matcsm2').val(RoundUp4(HasilMadCsm));
	$('#last_matcsm2').val(RoundUp(HasilMadCsm));
	$('#hasil_resin21').val(RoundUp4(Hasillayer21));
	$('#last_resin21').val(RoundUp(Hasillayer21));
	
	$('#hasil_csm_add2').val(RoundUp4(HasilMadCsmAdd));
	$('#last_csm_add2').val(RoundUp(HasilMadCsmAdd));
	$('#hasil_resin22').val(RoundUp4(Hasillayer22));
	$('#last_resin22').val(RoundUp(Hasillayer22));
	
	$('#hasil_wr2').val(RoundUp4(HasilWr));
	$('#last_wr2').val(RoundUp(HasilWr));
	$('#hasil_resin23').val(RoundUp4(Hasillayer23));
	$('#last_resin23').val(RoundUp(Hasillayer23));
	
	$('#hasil_wr_add2').val(RoundUp4(HasilWrAdd));
	$('#last_wr_add2').val(RoundUp(HasilWrAdd));
	$('#hasil_resin24').val(RoundUp4(Hasillayer24));
	$('#last_resin24').val(RoundUp(Hasillayer24));
	
	$('#hasil_rooving21').val(RoundUp4(HasilRoof21));
	$('#last_rooving21').val(RoundUp(HasilRoof21));
	$('#hasil_resin25').val(RoundUp4(Hasillayer25));
	$('#last_resin25').val(RoundUp(Hasillayer25));
	
	$('#hasil_rooving22').val(RoundUp4(HasilRoof22));
	$('#last_rooving22').val(RoundUp(HasilRoof22));
	$('#hasil_resin26').val(RoundUp4(Hasillayer26));
	$('#last_resin26').val(RoundUp(Hasillayer26));
	
	$('#hasil_resin_tot2').val(RoundUp4(TotalResin2));
	$('#last_resin_tot2').val(RoundUp(TotalResin2));
	
	$('#layer_katalis2').val(Katalis2);
	$('#hasil_katalis2').val(RoundUp4(HasilKatalis2));
	$('#last_katalis2').val(RoundUp(HasilKatalis2));
	
	$('#layer_sm2').val(Sm2);
	$('#hasil_sm2').val(RoundUp4(HasilSm2));
	$('#last_sm2').val(RoundUp(HasilSm2));
	
	$('#layer_coblat2').val(Coblat2);
	$('#hasil_coblat2').val(RoundUp4(HasilCoblat2));
	$('#last_cobalt2').val(RoundUp(HasilCoblat2));
	
	$('#layer_dma2').val(Dma2);
	$('#hasil_dma2').val(RoundUp4(HasilDma2));
	$('#last_dma2').val(RoundUp(HasilDma2));
	
	$('#layer_hydroquinone2').val(Hyro2);
	$('#hasil_hydroquinone2').val(RoundUp4(HasilHydro2));
	$('#last_hidro2').val(RoundUp(HasilHydro2));
	
	$('#layer_methanol2').val(Methanol2);
	$('#hasil_methanol2').val(RoundUp4(HasilMethanol2));
	$('#last_methanol2').val(RoundUp(HasilMethanol2));
	
	//TopCoat
	$('#hasil_resin41').val(RoundUp4(HasilTopCoat));
	$('#last_resin41').val(RoundUp(HasilTopCoat));
	
	$('#layer_katalis4').val(Katalis4);
	$('#hasil_katalis4').val(RoundUp4(HasilKatalis4));
	$('#last_katalis4').val(RoundUp(HasilKatalis4));
	
	$('#layer_color4').val(Color4);
	$('#hasil_color4').val(RoundUp4(HasilColor4));
	$('#last_color4').val(RoundUp(HasilColor4));
	
	$('#layer_tin4').val(Tinuvin4);
	$('#hasil_tin4').val(RoundUp4(HasilTinuvin4));
	$('#last_tin4').val(RoundUp(HasilTinuvin4));
	
	$('#layer_chl4').val(Chlr4);
	$('#hasil_chl4').val(RoundUp4(HasilChlr4));
	$('#last_chl4').val(RoundUp(HasilChlr4));
	
	$('#layer_stery4').val(Stery4);
	$('#hasil_stery4').val(RoundUp4(HasilStery4));
	$('#last_stery4').val(RoundUp(HasilStery4));
	
	$('#layer_wax4').val(Wax4);
	$('#hasil_wax4').val(RoundUp4(HasilWax4));
	$('#last_wax4').val(RoundUp(HasilWax4));
	
	$('#layer_mch4').val(MetCh4);
	$('#hasil_mch4').val(RoundUp4(HasilMetCh4));
	$('#last_mch4').val(RoundUp(HasilMetCh4));
}

function AreaChange3(a, b, c, d, e, top_diameter, top_thickness, waste, topEST, Luas_Area_Rumus, panjang){
	var acuhan_3			= parseFloat($('#acuhan_3').val());
	var top_min_toleran		=  parseFloat($('#top_min_toleran').val());
	var min_lin_thickness	= acuhan_3 - (acuhan_3*top_min_toleran);
	var max_lin_thickness	= acuhan_3 + (acuhan_3*top_min_toleran);
	
	$('#mix_lin_thickness3').val(min_lin_thickness.toFixed(4));
	$('#max_lin_thickness3').val(max_lin_thickness.toFixed(4));
	
	var topEST				= parseFloat($('#tot_lin_thickness').val()) + parseFloat($('#tot_lin_thickness2').val()) + parseFloat(a);
	
	//perhitungan hitam
	var weight_veil3		= parseFloat($('#weight_veil3').val());
	var weight_veil_add3	= parseFloat($('#weight_veil_add3').val());
	var weight_matcsm3		= parseFloat($('#weight_matcsm3').val());
	var weight_csm_add3		= parseFloat($('#weight_csm_add3').val());
	
	var layer_resin31		= parseFloat($('#layer_resin31').val());
	var layer_resin32		= parseFloat($('#layer_resin32').val());
	var layer_resin33		= parseFloat($('#layer_resin33').val());
	var layer_resin34		= parseFloat($('#layer_resin34').val());
	
	var persen_katalis3		= parseFloat($('#persen_katalis3').val());
	var persen_sm3			= parseFloat($('#persen_sm3').val());
	var persen_coblat3		= parseFloat($('#persen_coblat3').val());
	var persen_dma3			= parseFloat($('#persen_dma3').val());
	var persen_hydroquinone3	= parseFloat($('#persen_hydroquinone3').val());
	var persen_methanol3	= parseFloat($('#persen_methanol3').val());
	
	var Luas_Area_Rumus		= 3.14 * (top_diameter + topEST) * panjang / 1000000 * (1+waste);
	
	var HasilVeil3			= (Luas_Area_Rumus * weight_veil3 * b)/1000;
	var Hasillayer31		= parseFloat(HasilVeil3) * layer_resin31;
	var HasilVeilAdd3		= (Luas_Area_Rumus * weight_veil_add3 * c)/1000;
	var Hasillayer32		= parseFloat(HasilVeilAdd3) * layer_resin32;
	var HasilMadCsm3		= (Luas_Area_Rumus * weight_matcsm3 * d)/1000;
	var Hasillayer33		= parseFloat(HasilMadCsm3) * layer_resin33;
	var HasilMadCsmAdd3		= (Luas_Area_Rumus * weight_csm_add3 * e)/1000;
	var Hasillayer34		= parseFloat(HasilMadCsmAdd3) * layer_resin34;
	
	var TotalResin3			= Hasillayer31 + Hasillayer32 + Hasillayer33 + Hasillayer34;
	
	if(TotalResin3 == '' || TotalResin3 == 0 || TotalResin3 == '0' || TotalResin3 == null){
		var Katalis3	= 0;
		var Sm3			= 0;
		var Coblat3		= 0;
		var Dma3		= 0;
		var Hyro3		= 0;
		var Methanol3	= 0;
	}
	else if(TotalResin3 > 0){
		var Katalis3	= 1;
		var Sm3			= 1;
		var Coblat3		= 0.6;
		var Dma3		= 0.4;
		var Hyro3		= 0.1;
		var Methanol3	= 0.9;
	}
	
	var HasilKatalis3	= Katalis3 * (persen_katalis3/100) * TotalResin3;
	var HasilSm3		= Sm3 * (persen_sm3/100) * TotalResin3;
	var HasilCoblat3	= Coblat3 * (persen_coblat3/100) * TotalResin3;
	var HasilDma3		= Dma3 * (persen_dma3/100) * TotalResin3;
	var HasilHydro3		= Hyro3 * (persen_hydroquinone3/100) * TotalResin3;
	var HasilMethanol3	= Methanol3 * (persen_methanol3/100) * TotalResin3;
	
	//TopCoat
	var ResinCoat		= parseFloat($("#resin41").val());
	
	var persen_katalis4	= parseFloat($("#persen_katalis4").val());
	var persen_color4	= parseFloat($("#persen_color4").val());
	var persen_tin4		= parseFloat($("#persen_tin4").val());
	var persen_chl4		= parseFloat($("#persen_chl4").val());
	var persen_stery4	= parseFloat($("#persen_stery4").val());
	var persen_wax4		= parseFloat($("#persen_wax4").val());
	var persen_mch4		= parseFloat($("#persen_mch4").val());
	
	var HasilTopCoat	= (Luas_Area_Rumus * 1.2 * ResinCoat);
	
	if(HasilTopCoat == '' || HasilTopCoat == 0 || HasilTopCoat == '0' || HasilTopCoat == null){
		var Katalis4	= 0;
		var Color4		= 0;
		var Tinuvin4	= 0;
		var Chlr4		= 0;
		var Stery4		= 0;
		var Wax4		= 0;
		var MetCh4		= 0;
		var Addv4		= 0;
	}
	else if(HasilTopCoat > 0){
		var Katalis4	= 1;
		var Color4		= 1;
		var Tinuvin4	= 0.1;
		var Chlr4		= 0.9;
		var Stery4		= 0.9;
		var Wax4		= 0.1;
		var MetCh4		= 1;
		var Addv4		= 1;
	}
	
	var HasilKatalis4	= Katalis4 * (persen_katalis4/100) * HasilTopCoat;
	var HasilColor4		= Color4 * (persen_color4/100) * HasilTopCoat;
	var HasilTinuvin4	= Tinuvin4 * (persen_tin4/100) * HasilTopCoat;
	var HasilChlr4		= Chlr4 * (persen_chl4/100) * HasilTopCoat;
	var HasilStery4		= Stery4 * (persen_stery4/100) * HasilTopCoat;
	var HasilWax4		= Wax4 * (persen_wax4/100) * HasilTopCoat;
	var HasilMetCh4		= MetCh4 * (persen_mch4/100) * HasilTopCoat;
	
	//sampai sini
	if(a < min_lin_thickness){
		var Hasil	= "TOO LOW";
	}
	if(a > max_lin_thickness){
		var Hasil	= "TOO HIGH";
	}
	if(a > min_lin_thickness && a < max_lin_thickness){
		var Hasil	= "OK";
	}
	$('#hasil_linier_thickness3').val(Hasil);
	$('#top_tebal_est').val(RoundUpEST(topEST));
	$('#area').val(Luas_Area_Rumus.toFixed(4));
	
	//Penjumlahan Hitam
	$('#hasil_veil3').val(RoundUp4(HasilVeil3)); 
	$('#last_veil3').val(RoundUp(HasilVeil3));
	$('#hasil_resin31').val(RoundUp4(Hasillayer31));
	$('#last_resin31').val(RoundUp(Hasillayer31));
	
	$('#hasil_veil_add3').val(RoundUp4(HasilVeilAdd3));
	$('#last_veil_add3').val(RoundUp(HasilVeilAdd3));
	$('#hasil_resin32').val(RoundUp4(Hasillayer32));
	$('#last_resin32').val(RoundUp(Hasillayer32));
	
	$('#hasil_matcsm3').val(RoundUp4(HasilMadCsm3));
	$('#last_matcsm3').val(RoundUp(HasilMadCsm3));
	$('#hasil_resin33').val(RoundUp4(Hasillayer33));
	$('#last_resin33').val(RoundUp(Hasillayer33));
	
	$('#hasil_csm_add3').val(RoundUp4(HasilMadCsmAdd3));
	$('#last_csm_add3').val(RoundUp(HasilMadCsmAdd3));
	$('#hasil_resin34').val(RoundUp4(Hasillayer34));
	$('#last_resin34').val(RoundUp(Hasillayer34)); 
	
	$('#hasil_resin_tot3').val(RoundUp4(TotalResin3));
	$('#last_resin_tot3').val(RoundUp(TotalResin3));
	
	$('#layer_katalis3').val(Katalis3);
	$('#hasil_katalis3').val(RoundUp4(HasilKatalis3));
	$('#last_katalis3').val(RoundUp(HasilKatalis3));
	
	$('#layer_sm3').val(Sm3);
	$('#hasil_sm3').val(RoundUp4(HasilSm3));
	$('#last_sm3').val(RoundUp(HasilSm3));
	
	$('#layer_coblat3').val(Coblat3);
	$('#hasil_coblat3').val(RoundUp4(HasilCoblat3));
	$('#last_cobalt3').val(RoundUp(HasilCoblat3));
	
	$('#layer_dma3').val(Dma3);
	$('#hasil_dma3').val(RoundUp4(HasilDma3));
	$('#last_dma3').val(RoundUp(HasilDma3));
	
	$('#layer_hydroquinone3').val(Hyro3);
	$('#hasil_hydroquinone3').val(RoundUp4(HasilHydro3));
	$('#last_hidro3').val(RoundUp(HasilHydro3));
	
	$('#layer_methanol3').val(Methanol3);
	$('#hasil_methanol3').val(RoundUp4(HasilMethanol3));
	$('#last_methanol3').val(RoundUp(HasilMethanol3));
	
	//TopCoat
	$('#hasil_resin41').val(RoundUp4(HasilTopCoat));
	$('#last_resin41').val(RoundUp(HasilTopCoat));
	
	$('#layer_katalis4').val(Katalis4);
	$('#hasil_katalis4').val(RoundUp4(HasilKatalis4));
	$('#last_katalis4').val(RoundUp(HasilKatalis4));
	
	$('#layer_color4').val(Color4);
	$('#hasil_color4').val(RoundUp4(HasilColor4));
	$('#last_color4').val(RoundUp(HasilColor4));
	
	$('#layer_tin4').val(Tinuvin4);
	$('#hasil_tin4').val(RoundUp4(HasilTinuvin4));
	$('#last_tin4').val(RoundUp(HasilTinuvin4));
	
	$('#layer_chl4').val(Chlr4);
	$('#hasil_chl4').val(RoundUp4(HasilChlr4));
	$('#last_chl4').val(RoundUp(HasilChlr4));
	
	$('#layer_stery4').val(Stery4);
	$('#hasil_stery4').val(RoundUp4(HasilStery4));
	$('#last_stery4').val(RoundUp(HasilStery4));
	
	$('#layer_wax4').val(Wax4);
	$('#hasil_wax4').val(RoundUp4(HasilWax4));
	$('#last_wax4').val(RoundUp(HasilWax4));
	
	$('#layer_mch4').val(MetCh4);
	$('#hasil_mch4').val(RoundUp4(HasilMetCh4));
	$('#last_mch4').val(RoundUp(HasilMetCh4));
}

function RoundUp(x){
	var HasilRoundUp = (Math.ceil(x * 1000 ) / 1000).toFixed(3);
	return HasilRoundUp;
}

function RoundUp4(x){
	var HasilRoundUp = (Math.ceil(x * 10000 ) / 10000).toFixed(4);
	return HasilRoundUp;
}

function RoundUpEST(x){
	var HasilRoundUp = (Math.ceil(x * 1000 ) / 1000).toFixed(3);
	return HasilRoundUp;
}

function AcuhanMaxMin(liner, struktur, external, MinToleransi, MaxToleransi, totThickness1, totThickness2, totThickness3){
	var min_lin_thickness	= parseFloat(liner) - (parseFloat(liner) * parseFloat(MinToleransi));
	var max_lin_thickness	= parseFloat(liner) + (parseFloat(liner) * parseFloat(MaxToleransi));
	
	var min_str_thickness	= parseFloat(struktur) - (parseFloat(struktur) * parseFloat(MinToleransi));
	var max_str_thickness	= parseFloat(struktur) + (parseFloat(struktur) * parseFloat(MaxToleransi));
	
	var min_ext_thickness	= parseFloat(external) - (parseFloat(external) * parseFloat(MinToleransi));
	var max_ext_thickness	= parseFloat(external) + (parseFloat(external) * parseFloat(MaxToleransi));
	
	$('#mix_lin_thickness').val(min_lin_thickness.toFixed(4));
	$('#max_lin_thickness').val(max_lin_thickness.toFixed(4));
	
	if(totThickness1 < min_lin_thickness){
		var Hasil1	= "TOO LOW";
	}
	if(totThickness1 > max_lin_thickness){
		var Hasil1	= "TOO HIGH";
	}
	if(totThickness1 > min_lin_thickness && totThickness1 < max_lin_thickness){
		var Hasil1	= "OK";
	}
	$('#hasil_linier_thickness').val(Hasil1);
	
	$('#mix_lin_thickness2').val(min_str_thickness.toFixed(4));
	$('#max_lin_thickness2').val(max_str_thickness.toFixed(4));
	
	if(totThickness2 < min_str_thickness){
		var Hasil2	= "TOO LOW";
	}
	if(totThickness2 > max_str_thickness){
		var Hasil2	= "TOO HIGH";
	}
	if(totThickness2 > min_str_thickness && totThickness2 < max_str_thickness){
		var Hasil2	= "OK";
	}
	$('#hasil_linier_thickness2').val(Hasil2);
	
	$('#mix_lin_thickness3').val(min_ext_thickness.toFixed(4));
	$('#max_lin_thickness3').val(max_ext_thickness.toFixed(4));
	
	if(totThickness3 < min_ext_thickness){
		var Hasil3	= "TOO LOW";
	}
	if(totThickness3 > max_ext_thickness){
		var Hasil3	= "TOO HIGH";
	}
	if(totThickness3 > min_ext_thickness && totThickness3 < max_ext_thickness){
		var Hasil3	= "OK";
	}
	$('#hasil_linier_thickness3').val(Hasil3);
}

function AppendBaris_Liner(intd){
	var nomor	= 1;
	var valuex	= $('#detail_body_liner').find('tr').length;
	if(valuex > 0){
		var akhir	= $('#detail_body_liner tr:last').attr('id');
		var det_id	= akhir.split('_');
		var nomor	= parseInt(det_id[1])+1;
	}

	var Rows	 = "<tr id='trliner_"+nomor+"'>";
		Rows 	+= 	"<td align=\"left\" width = '45px' style='vertical-align: middle;'>";
		Rows 	+=		"<div style='text-align: center;'><button type='button' class='but-det btn-danger' data-toggle='tooltip' data-placement='bottom' onClick='delRow_Liner("+nomor+")' title='Delete Record'><i class='fa fa-times-circle'></i></button></div>";
		Rows	+=		"<input type='hidden' class='form-control Full' name='ListDetailAdd_Liner["+nomor+"][last_full]' id='last_full_liner_"+nomor+"' value='0' autocomplete='off'>";
		Rows 	+= 	"</td>";
		Rows	+= 	"<td align='left'  width = '250px'>";
		Rows	+=		"Category<select name='ListDetailAdd_Liner["+nomor+"][id_category]' id='id_category_liner_"+nomor+"' class='chosen_select form-control inline-block' required><option value=''>Select An Category</option></select>";
		Rows	+= 	"</td>";
		Rows	+= 	"<td align='left'>";
		Rows	+=		"Material<select name='ListDetailAdd_Liner["+nomor+"][id_material]' id='id_material_liner_"+nomor+"' class='chosen_select form-control inline-block' required><option value=''>List Empty</option></select>";
		Rows	+= 	"</td>";
		Rows	+= 	"<td  width='150px'>";
		Rows	+=		"Comparison<input type='text' class='form-control numberOnly ChangeContaining' name='ListDetailAdd_Liner["+nomor+"][containing]' id='containing_liner_"+nomor+"' value='0' placeholder='Containing' autocomplete='off'>";
		Rows	+= 	"</td>";
		Rows	+= 	"<td  width='150px'>";
		Rows	+=		"Percent<input type='text' class='form-control numberOnly ChangePerse' name='ListDetailAdd_Liner["+nomor+"][perse]' id='perse_liner_"+nomor+"' value='0' placeholder='Percent' autocomplete='off'>";
		Rows	+= 	"</td>";
		Rows	+= 	"<td width='150px'>";
		Rows	+=		"Value /Kg<input type='text' class='form-control Cost' name='ListDetailAdd_Liner["+nomor+"][last_cost]' id='last_cost_liner_"+nomor+"' value='0' readonly autocomplete='off'>";
		Rows	+= 	"</td>";
		Rows	+= "</tr>";

	$('#detail_body_liner').append(Rows);
	var id_category_liner_ 	= "#id_category_liner_"+nomor;
	var id_material_liner_ 	= "#id_material_liner_"+nomor;
	
	
	
	$.ajax({
		url: base_url +'index.php/'+active_controller+'/getCategory',
		cache: false,
		type: "POST",
		dataType: "json",
		success: function(data){
			$(id_category_liner_).html(data.option).trigger("chosen:updated");
		}
	});
	
	$(".numberOnly").on("keypress keyup blur",function (event) {    
		// $(this).val($(this).val().replace(/[^\d].+/, ""));
		if ((event.which < 48 || event.which > 57 ) && (event.which < 46 || event.which > 46 )) {
			event.preventDefault();
		}
		// if($(this).val() == ''){
			// $(this).val(0);
		// }
	});
	
	$("#id_category_liner_"+nomor+"").on('change', function(e){
		e.preventDefault();
		$.ajax({
			url: base_url +'index.php/'+active_controller+'/getMaterial',
			cache: false,
			type: "POST",
			data: "id_category="+$(this).val(),
			dataType: "json",
			success: function(data){
				$(id_material_liner_).html(data.option).trigger("chosen:updated");
			}
		});
	});
	nomor++;
}

function AppendBaris_Strukture(intd){
	var nomor	= 1;
	var valuex	= $('#detail_body_strukture').find('tr').length;
	if(valuex > 0){
		var akhir	= $('#detail_body_strukture tr:last').attr('id');
		var det_id	= akhir.split('_');
		var nomor	= parseInt(det_id[1])+1;
	}

	var Rows	 = "<tr id='trstrukture_"+nomor+"'>";
		Rows 	+= 	"<td align=\"left\" width = '45px' style='vertical-align: middle;'>";
		Rows 	+=		"<div style='text-align: center;'><button type='button' class='but-det btn-danger' data-toggle='tooltip' data-placement='bottom' onClick='delRow_Strukture("+nomor+")' title='Delete Record'><i class='fa fa-times-circle'></i></button></div>";
		Rows	+=		"<input type='hidden' class='form-control Full' name='ListDetailAdd_Strukture["+nomor+"][last_full]' id='last_full_strukture_"+nomor+"' value='0' autocomplete='off'>";
		Rows 	+= 	"</td>";
		Rows	+= 	"<td align='left'  width = '250px'>";
		Rows	+=		"Category<select name='ListDetailAdd_Strukture["+nomor+"][id_category]' id='id_category_strukture_"+nomor+"' class='chosen_select form-control inline-block' required><option value=''>Select An Category</option></select>";
		Rows	+= 	"</td>";
		Rows	+= 	"<td align='left'>";
		Rows	+=		"Material<select name='ListDetailAdd_Strukture["+nomor+"][id_material]' id='id_material_strukture_"+nomor+"' class='chosen_select form-control inline-block' required><option value=''>List Empty</option></select>";
		Rows	+= 	"</td>";
		Rows	+= 	"<td  width='150px'>";
		Rows	+=		"Comparison<input type='text' class='form-control numberOnly ChangeContainingStr' name='ListDetailAdd_Strukture["+nomor+"][containing]' id='containing_strukture_"+nomor+"' value='0' placeholder='Containing' autocomplete='off'>";
		Rows	+= 	"</td>";
		Rows	+= 	"<td  width='150px'>";
		Rows	+=		"Percent<input type='text' class='form-control numberOnly ChangePerseStr' name='ListDetailAdd_Strukture["+nomor+"][perse]' id='perse_strukture_"+nomor+"' value='0' placeholder='Percent' autocomplete='off'>";
		Rows	+= 	"</td>";
		Rows	+= 	"<td width='150px'>";
		Rows	+=		"Value /Kg<input type='text' class='form-control Cost' name='ListDetailAdd_Strukture["+nomor+"][last_cost]' id='last_cost_strukture_"+nomor+"' value='0' readonly autocomplete='off'>";
		Rows	+= 	"</td>";
		Rows	+= "</tr>";

	$('#detail_body_strukture').append(Rows);
	var id_category_strukture_ 	= "#id_category_strukture_"+nomor;
	var id_material_strukture_ 	= "#id_material_strukture_"+nomor;
	
	
	
	$.ajax({
		url: base_url +'index.php/'+active_controller+'/getCategory',
		cache: false,
		type: "POST",
		dataType: "json",
		success: function(data){
			$(id_category_strukture_).html(data.option).trigger("chosen:updated");
		}
	});
	
	$(".numberOnly").on("keypress keyup blur",function (event) {    
		// $(this).val($(this).val().replace(/[^\d].+/, ""));
		if ((event.which < 48 || event.which > 57 ) && (event.which < 46 || event.which > 46 )) {
			event.preventDefault();
		}
		// if($(this).val() == ''){
			// $(this).val(0);
		// }
	});
	
	$("#id_category_strukture_"+nomor+"").on('change', function(e){
		e.preventDefault();
		$.ajax({
			url: base_url +'index.php/'+active_controller+'/getMaterial',
			cache: false,
			type: "POST",
			data: "id_category="+$(this).val(),
			dataType: "json",
			success: function(data){
				$(id_material_strukture_).html(data.option).trigger("chosen:updated");
			}
		});
	});
	nomor++;
}

function AppendBaris_External(intd){
	var nomor	= 1;
	var valuex	= $('#detail_body_external').find('tr').length;
	if(valuex > 0){
		var akhir	= $('#detail_body_external tr:last').attr('id');
		var det_id	= akhir.split('_');
		var nomor	= parseInt(det_id[1])+1;
	}

	var Rows	 = "<tr id='trexternal_"+nomor+"'>";
		Rows 	+= 	"<td align=\"left\" width = '45px' style='vertical-align: middle;'>";
		Rows 	+=		"<div style='text-align: center;'><button type='button' class='but-det btn-danger' data-toggle='tooltip' data-placement='bottom' onClick='delRow_External("+nomor+")' title='Delete Record'><i class='fa fa-times-circle'></i></button></div>";
		Rows	+=		"<input type='hidden' class='form-control Full' name='ListDetailAdd_External["+nomor+"][last_full]' id='last_full_strukture_"+nomor+"' value='0' autocomplete='off'>";
		Rows 	+= 	"</td>";
		Rows	+= 	"<td align='left'  width = '250px'>";
		Rows	+=		"Category<select name='ListDetailAdd_External["+nomor+"][id_category]' id='id_category_external_"+nomor+"' class='chosen_select form-control inline-block' required><option value=''>Select An Category</option></select>";
		Rows	+= 	"</td>";
		Rows	+= 	"<td align='left'>";
		Rows	+=		"Material<select name='ListDetailAdd_External["+nomor+"][id_material]' id='id_material_external_"+nomor+"' class='chosen_select form-control inline-block' required><option value=''>List Empty</option></select>";
		Rows	+= 	"</td>";
		Rows	+= 	"<td  width='150px'>";
		Rows	+=		"Comparison<input type='text' class='form-control numberOnly ChangeContainingExt' name='ListDetailAdd_External["+nomor+"][containing]' id='containing_external_"+nomor+"' value='0' placeholder='Containing' autocomplete='off'>";
		Rows	+= 	"</td>";
		Rows	+= 	"<td  width='150px'>";
		Rows	+=		"Percent<input type='text' class='form-control numberOnly ChangePerseExt' name='ListDetailAdd_External["+nomor+"][perse]' id='perse_external_"+nomor+"' value='0' placeholder='Percent' autocomplete='off'>";
		Rows	+= 	"</td>";
		Rows	+= 	"<td width='150px'>";
		Rows	+=		"Value /Kg<input type='text' class='form-control Cost' name='ListDetailAdd_External["+nomor+"][last_cost]' id='last_cost_external_"+nomor+"' value='0' readonly autocomplete='off'>";
		Rows	+= 	"</td>";
		Rows	+= "</tr>";

	$('#detail_body_external').append(Rows);
	var id_category_external_ 	= "#id_category_external_"+nomor;
	var id_material_external_ 	= "#id_material_external_"+nomor;
	
	
	
	$.ajax({
		url: base_url +'index.php/'+active_controller+'/getCategory',
		cache: false,
		type: "POST",
		dataType: "json",
		success: function(data){
			$(id_category_external_).html(data.option).trigger("chosen:updated");
		}
	});
	
	$(".numberOnly").on("keypress keyup blur",function (event) {    
		// $(this).val($(this).val().replace(/[^\d].+/, ""));
		if ((event.which < 48 || event.which > 57 ) && (event.which < 46 || event.which > 46 )) {
			event.preventDefault();
		}
		// if($(this).val() == ''){
			// $(this).val(0);
		// }
	});
	
	$("#id_category_external_"+nomor+"").on('change', function(e){
		e.preventDefault();
		$.ajax({
			url: base_url +'index.php/'+active_controller+'/getMaterial',
			cache: false,
			type: "POST",
			data: "id_category="+$(this).val(),
			dataType: "json",
			success: function(data){
				$(id_material_external_).html(data.option).trigger("chosen:updated");
			}
		});
	});
	nomor++;
}

function AppendBaris_TopCoat(intd){
	var nomor	= 1;
	var valuex	= $('#detail_body_topcoat').find('tr').length;
	if(valuex > 0){
		var akhir	= $('#detail_body_topcoat tr:last').attr('id');
		var det_id	= akhir.split('_');
		var nomor	= parseInt(det_id[1])+1;
	}

	var Rows	 = "<tr id='trtopcoat_"+nomor+"'>";
		Rows 	+= 	"<td align=\"left\" width = '45px' style='vertical-align: middle;'>";
		Rows 	+=		"<div style='text-align: center;'><button type='button' class='but-det btn-danger' data-toggle='tooltip' data-placement='bottom' onClick='delRow_TopCoat("+nomor+")' title='Delete Record'><i class='fa fa-times-circle'></i></button></div>";
		Rows	+=		"<input type='hidden' class='form-control Full' name='ListDetailAdd_TopCoat["+nomor+"][last_full]' id='last_full_topcoat_"+nomor+"' value='0' autocomplete='off'>";
		Rows 	+= 	"</td>";
		Rows	+= 	"<td align='left'  width = '250px'>";
		Rows	+=		"Category<select name='ListDetailAdd_TopCoat["+nomor+"][id_category]' id='id_category_topcoat_"+nomor+"' class='chosen_select form-control inline-block' required><option value=''>Select An Category</option></select>";
		Rows	+= 	"</td>";
		Rows	+= 	"<td align='left'>";
		Rows	+=		"Material<select name='ListDetailAdd_TopCoat["+nomor+"][id_material]' id='id_material_topcoat_"+nomor+"' class='chosen_select form-control inline-block' required><option value=''>List Empty</option></select>";
		Rows	+= 	"</td>";
		Rows	+= 	"<td  width='150px'>";
		Rows	+=		"Comparison<input type='text' class='form-control numberOnly ChangeContainingTC' name='ListDetailAdd_TopCoat["+nomor+"][containing]' id='containing_topcoat_"+nomor+"' value='0' placeholder='Containing' autocomplete='off'>";
		Rows	+= 	"</td>";
		Rows	+= 	"<td  width='150px'>";
		Rows	+=		"Percent<input type='text' class='form-control numberOnly ChangePerseTC' name='ListDetailAdd_TopCoat["+nomor+"][perse]' id='perse_topcoat_"+nomor+"' value='0' placeholder='Percent' autocomplete='off'>";
		Rows	+= 	"</td>";
		Rows	+= 	"<td width='150px'>";
		Rows	+=		"Value /Kg<input type='text' class='form-control Cost' name='ListDetailAdd_TopCoat["+nomor+"][last_cost]' id='last_cost_topcoat_"+nomor+"' value='0' readonly autocomplete='off'>";
		Rows	+= 	"</td>";
		Rows	+= "</tr>";

	$('#detail_body_topcoat').append(Rows);
	var id_category_topcoat_ 	= "#id_category_topcoat_"+nomor;
	var id_material_topcoat_ 	= "#id_material_topcoat_"+nomor;
	
	
	
	$.ajax({
		url: base_url +'index.php/'+active_controller+'/getCategory',
		cache: false,
		type: "POST",
		dataType: "json",
		success: function(data){
			$(id_category_topcoat_).html(data.option).trigger("chosen:updated");
		}
	});
	
	$(".numberOnly").on("keypress keyup blur",function (event) {    
		// $(this).val($(this).val().replace(/[^\d].+/, ""));
		if ((event.which < 48 || event.which > 57 ) && (event.which < 46 || event.which > 46 )) {
			event.preventDefault();
		}
		// if($(this).val() == ''){
			// $(this).val(0);
		// }
	});
	
	$("#id_category_topcoat_"+nomor+"").on('change', function(e){
		e.preventDefault();
		$.ajax({
			url: base_url +'index.php/'+active_controller+'/getMaterial',
			cache: false,
			type: "POST",
			data: "id_category="+$(this).val(),
			dataType: "json",
			success: function(data){
				$(id_material_topcoat_).html(data.option).trigger("chosen:updated");
			}
		});
	});
	nomor++;
}

function delRow_Liner(row){
	$('#trliner_'+row).remove();
	// row = 0;
	var updatemax	=	$("#numberMax_liner").val() - 1;
	$("#numberMax_liner").val(updatemax);
	
	var maxLine = $("#numberMax_liner").val();
}
function delRow_Strukture(row){
	$('#trstrukture_'+row).remove();
	// row = 0;
	var updatemax	=	$("#numberMax_strukture").val() - 1;
	$("#numberMax_strukture").val(updatemax);
	
	var maxLine = $("#numberMax_strukture").val();
}
function delRow_External(row){
	$('#trexternal_'+row).remove();
	// row = 0;
	var updatemax	=	$("#numberMax_external").val() - 1;
	$("#numberMax_external").val(updatemax);
	
	var maxLine = $("#numberMax_external").val();
}
function delRow_TopCoat(row){
	$('#trtopcoat_'+row).remove();
	// row = 0;
	var updatemax	=	$("#numberMax_topcoat").val() - 1;
	$("#numberMax_topcoat").val(updatemax);
	
	var maxLine = $("#numberMax_topcoat").val();
}

function rubaharea(){
	// alert('Hay');
	// console.log('Hay');
	var waste			= parseFloat($('#waste').val()) / 100;
	var top_diameter	= parseFloat($('#top_diameter').val());
	var top_thickness	= parseFloat($('#top_tebal_design').val());
	var panjang			= parseFloat($('#panjang').val());

	var topEST			= parseFloat($('#top_tebal_est').val());
	var Luas_Area_Rumus	= parseFloat($('#area').val());
	
	var acuhan_1		= parseFloat($('#acuhan_1').val());
	var acuhan_3		= parseFloat($('#acuhan_3').val());
	
	var hasilAch2		= top_thickness - (acuhan_1 + acuhan_3);
	
	$('#acuhan_2').val(hasilAch2.toFixed(2));
	
	//Liner Thickness
	var layer_veil1		= $("#layer_veil").val();
	var layer_veil2		= $("#layer_veil_add").val();
	var layer_veil3		= $("#layer_matcsm").val();
	var layer_veil4		= $("#layer_csm_add").val();
	var tot_thickness1	= parseFloat($('#tot_lin_thickness').val());
	
	//Struktur Thickness
	var layer1			= $("#layer_matcsm2").val();
	var layer2			= $("#layer_csm_add2").val();
	var layer3			= $("#layer_wr2").val();
	var layer4			= $("#layer_wr_add2").val();
	var layer5			= $("#layer_rooving21").val();
	var layer6			= $("#layer_rooving22").val();
	var tot_thickness2	= parseFloat($('#tot_lin_thickness2').val());
	
	//External Thickness
	var layer31			= $("#layer_veil3").val();
	var layer32			= $("#layer_veil_add3").val();
	var layer33			= $("#layer_matcsm3").val();
	var layer34			= $("#layer_csm_add3").val();
	var tot_thickness3	= parseFloat($('#tot_lin_thickness3').val());
	
	AreaChange(tot_thickness1, layer_veil1, layer_veil2, layer_veil3, layer_veil4, top_diameter, top_thickness, waste, topEST, Luas_Area_Rumus, panjang);
	AreaChange2(tot_thickness2, layer1, layer2, layer3, layer4, layer5, layer6, top_diameter, top_thickness, waste, topEST, Luas_Area_Rumus, panjang);
	AreaChange3(tot_thickness3, layer31, layer32, layer33, layer34, top_diameter, top_thickness, waste, topEST, Luas_Area_Rumus, panjang);
}

function length_mitter(radius, angle){
	var tan_tan		= Math.tan(11.25 * 3.14 / 180);
	var hasil_tan   = (angle/90) * 8 * tan_tan * radius;
	
	$('#panjang').val(hasil_tan.toFixed(2));
	
	var waste			= parseFloat($('#waste').val()) / 100;
	var top_diameter	= parseFloat($('#top_diameter').val());
	var top_thickness	= parseFloat($('#top_tebal_design').val());
	// var panjang			= parseFloat($('#panjang').val());
	
	var acuhan_1		= parseFloat($('#acuhan_1').val());
	
	var hasilAch2		= top_thickness - acuhan_1;
	// alert('Hay');
	$('#acuhan_2').val(hasilAch2.toFixed(1));
	
	//Liner Thickness
	var layer_veil1		= $("#layer_veil").val();
	var layer_veil2		= $("#layer_veil_add").val();
	var layer_veil3		= $("#layer_matcsm").val();
	var layer_veil4		= $("#layer_csm_add").val();
	var tot_thickness1	= parseFloat($('#tot_lin_thickness').val());
	
	//Struktur Thickness
	var layer1			= $("#layer_matcsm2").val();
	var layer2			= $("#layer_csm_add2").val();
	var layer3			= $("#layer_wr2").val();
	var layer4			= $("#layer_wr_add2").val();
	var layer5			= $("#layer_rooving21").val();
	var layer6			= $("#layer_rooving22").val();
	var tot_thickness2	= parseFloat($('#tot_lin_thickness2').val());
	
	//External Thickness
	var layer31			= $("#layer_veil3").val();
	var layer32			= $("#layer_veil_add3").val();
	var layer33			= $("#layer_matcsm3").val();
	var layer34			= $("#layer_csm_add3").val();
	var tot_thickness3	= parseFloat($('#tot_lin_thickness3').val());
	
	Hasil(tot_thickness1, layer_veil1, layer_veil2, layer_veil3, layer_veil4, top_diameter, top_thickness, waste, hasil_tan);
	Hasil2(tot_thickness2, layer1, layer2, layer3, layer4, layer5, layer6, top_diameter, top_thickness, waste, hasil_tan);
	Hasil3(tot_thickness3, layer31, layer32, layer33, layer34, top_diameter, top_thickness, waste, hasil_tan);
	rubaharea();
}

</script>
