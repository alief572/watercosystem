<?php
    $ENABLE_ADD     = has_permission('Inventory_4.Add');
    $ENABLE_MANAGE  = has_permission('Inventory_4.Manage');
    $ENABLE_VIEW    = has_permission('Inventory_4.View');
    $ENABLE_DELETE  = has_permission('Inventory_4.Delete');
foreach ($results['inventory_3'] as $inventory_3){
}	
?>
 <div class="box box-primary">
    <div class="box-body">
		<form id="data-form" method="post">
						<div class="col-sm-12">
						   <div class="input_fields_wrap2">
								<div class="row">
									<div class="form-group row">
										<div class="col-md-4">
									    <label for="customer">Nama Material</label>
									    </div>
									    <div class="col-md-6" hidden>
						<input type="text" class="form-control" id="id_inventory" value="<?= $inventory_3->id_category3 ?>" readonly required name="id_inventory" placeholder="Id Material">
									    </div>
										<div class="col-md-6" >
						<input type="text" class="form-control"  id="nm_inventory" value="<?= $inventory_3->nama_type ?>-<?= $inventory_3->nama ?>-<?= $inventory_3->hardness ?>-<?= $inventory_3->thickness ?>" readonly required name="nm_inventory" placeholder="Nama Material">
									    </div>
									</div>
									<div class="form-group row">
										<div class="col-md-4">
									    <label for="customer">Lot Number</label>
									    </div>
									    <div class="col-md-6">
						<input type="text" class="form-control" id="lotno"  name="lotno" placeholder="Lot Number Metalsindo">
									    </div>
									</div>
									<div class="form-group row">
										<div class="col-md-4">
									    <label for="customer">length</label>
									    </div>
									    <div class="col-md-6">
						<input type="text" class="form-control" id="length"  name="lengh" placeholder="Length">
									    </div>
									</div>
									<div class="form-group row" hidden>
										<div class="col-md-4">
									    <label for="customer">bentuk</label>
									    </div>
									    <div class="col-md-6">
						<input type="text" class="form-control" id="id_bentuk" value="<?= $inventory_3->id_bentuk ?>" name="id_bentuk" placeholder="Length">
									    </div>
									</div>
									<div class="form-group row" hidden>
										<div class="col-md-4">
									    <label for="customer">Thickness</label>
									    </div>
									    <div class="col-md-6">
						<input type="text" class="form-control" id="thickness" value="<?= $inventory_3->thickness ?>" name="thickness" placeholder="Length">
									    </div>
									</div>
									<div class="form-group row">
										<div class="col-md-4">
									    <label for="customer">Width</label>
									    </div>
									    <div class="col-md-6">
						<input type="number" class="form-control" id="width"  name="width" placeholder="Width">
									    </div>
									</div>
									<div class="form-group row">
										<div class="col-md-4">
									    <label for="customer">Jumlah</label>
									    </div>
									    <div class="col-md-6">
						<input type="number" class="form-control" id="qty"  name="qty" placeholder="Jumlah">
									    </div>
									</div>
									<div class="form-group row">
										<div class="col-md-4">
									    <label for="customer">Berat Satuan</label>
									    </div>
									    <div class="col-md-6">
						<input type="number" class="form-control" id="weight"  name="weight" placeholder="weight">
									    </div>
									</div>
									<div class="form-group row">
										<div class="col-md-4">
									    <label for="customer">Status</label>
									    </div>
									    <div class="col-md-6">
										<select class="form-control" id="status"  name="status" >
										<option>-Pilih-</option>
										<?php
										foreach ($results['gudang'] as $gudang){
										echo"<option value='$gudang->id_gudang'>$gudang->nama_gudang</option>";
										}	?>
										</select>
									    </div>
									</div>
								</div>
							</div>
						</div>
				 	<hr>
					<center>
					<button type="submit" class="btn btn-success btn-sm" name="save" id="simpan-com"><i class="fa fa-save"></i>Simpan</button>
					</center>
					
				  </form>
				  
				  
				  
	</div>
</div>	
	
				  
				  
				  
<script type="text/javascript">
	//$('#input-kendaraan').hide();
	var base_url			= '<?php echo base_url(); ?>';
	var active_controller	= '<?php echo($this->uri->segment(1)); ?>';
	
	$(document).ready(function(){
		 var data_pay	        = <?php echo json_encode($results['supplier']);?>;	
		 
				  ///INPUT PERKIRAAN KIRIM
			
			
			var max_fields2      = 10; //maximum input boxes allowed
			var wrapper2         = $(".input_fields_wrap2"); //Fields wrapper
			var add_button2      = $(".add_field_button2"); //Add button ID

			//console.log(persen);

			var x2 = 1; //initlal text box count
			$(add_button2).click(function(e){ //on add input button click
			  e.preventDefault();
			  if(x2 < max_fields2){ //max input box allowed
				x2++; //text box increment
				
				$(wrapper2).append('<div class="row">'+
				'<div class="col-xs-1">'+x2+'</div>'+
				'<div class="col-xs-3">'+
				'<div class="input-group">'+
				'<input type="text" name="hd'+x2+'[produk]"  class="form-control input-sm" value="">'+
				'</div>'+
				'<div class="input-group">'+
				'<input type="text" name="hd'+x2+'[costcenter]"  class="form-control input-sm" value="">'+
				'</div>'+
				'<div class="input-group">'+
				'<input type="text" name="hd'+x2+'[mesin]"  class="form-control input-sm" value="">'+
				'</div>'+
				'<div class="input-group">'+
				'<input type="text" name="hd'+x2+'[mold_tools]"  class="form-control input-sm" value="">'+
				'</div>'+
				'</div>'+
				'<a href="#" class="remove_field2">Remove</a>'+
				'</div>'); //add input box
				$('#datepickerxxr'+x2).datepicker({
				  format: 'dd-mm-yyyy',
				  autoclose: true
				});
			  }
			});

			$(wrapper2).on("click",".remove_field2", function(e){ //user click on remove text
			  e.preventDefault(); $(this).parent('div').remove(); x2--;
			})

	$('#simpan-com').click(function(e){
			e.preventDefault();
			var deskripsi	= $('#deskripsi').val();
			var image	= $('#image').val();
			var idtype	= $('#inventory_4').val();
			
			var data, xhr;
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
						var baseurl=siteurl+'stock_material/saveNewStock';
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
									window.location.href = base_url + active_controller+'/detail/'+data.code;
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

</script>