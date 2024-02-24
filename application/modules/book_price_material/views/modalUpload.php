
	<div class="box box-primary">
		<div class="box-header">
			<h3 class="box-title">Upload Template</h3>
		</div>
		<div class="box-body">
			<div class='form-group row'>		 	 
				<label class='label-control col-sm-2'><b>Upload File <span class='text-red'>*</span></b></label>
				<div class='col-sm-5'>              
					<?php
						echo form_input(array('type'=>'file', 'id'=>'excel_file','name'=>'excel_file','class'=>'form-control-file','autocomplete'=>'off','placeholder'=>'Supplier Name'));											
					?>
					<span style='color:#c30808;'><b>* <u>Customer name, customer email and email pic</u> cannot be empty ...</b></span>
				</div>
			</div>
			<div class='form-group row'>		 	 
				<label class='label-control col-sm-2'></label>
				<div class='col-sm-5'>
					<button type='button' id='uploadEx' class='btn btn-primary'>Upload Template</button>	
				</div>
			</div>
		</div>
	</div>

	<div class="box box-success">
		<div class="box-header">
			<h3 class="box-title">Download Template</h3>
		</div>
		<div class="box-body">
			<button type='button' id='download' class='btn btn-warning'>Download Template Excell</button>
			<button type='buttonPDF' id='downloadPDF' class='btn btn-success'>Download PDF</button>
		</div>
	</div>

<script>
	$(document).on('click', '#download', function(){
		var Link	= base_url + active_controller +'/temp_format';
		window.open(Link);
	});
	
	

</script>