<form action="#" method="POST" id="form_proses_bro" autocomplete='off' enctype="multipart/form-data">
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
</form>
<script>
$(document).on('click', '#uploadEx', function(){
			var excel_file = $('#excel_file').val();
			if(excel_file == '' || excel_file == null){
				swal({
				  title	: "Error Message!",
				  text	: 'File upload is Empty, please choose file first...',
				  type	: "warning"
				});
				// $('#simpan-bro').prop('disabled',false);
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
			  closeOnConfirm: false,
			  closeOnCancel: false
			},
			function(isConfirm) {
			  if (isConfirm) {
					var formData  	= new FormData($('#form_proses_bro')[0]);
					var baseurl		= base_url + active_controller +'importData';
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
							if(data.status == 2){
								swal({
								  title	: "Save Failed!",
								  text	: data.pesan,
								  type	: "warning",
								  timer	: 5000
								});
							}
							if(data.status == 3){
								swal({
								  title	: "Save Failed!",
								  text	: data.pesan,
								  type	: "warning",
								  timer	: 5000
								});
							}
							$('#uploadEx').prop('disabled',false);
						},
						error: function() {
							swal({
							  title				: "Error Message !",
							  text				: 'An Error Occured During Process. Please try again..',						
							  type				: "warning",								  
							  timer				: 5000,
							  showCancelButton	: false,
							  showConfirmButton	: false,
							  allowOutsideClick	: false
							});
							$('#uploadEx').prop('disabled',false);
						}
					});
			  } else {
				swal("Cancelled", "Data can be process again :)", "error");
				$('#uploadEx').prop('disabled',false);
				return false;
			  }
			});
		});

</script>