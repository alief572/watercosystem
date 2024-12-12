 <?php
    $ENABLE_ADD     = has_permission('master_bentuk.Add');
    $ENABLE_MANAGE  = has_permission('master_bentuk.Manage');
    $ENABLE_VIEW    = has_permission('master_bentuk.View');
    $ENABLE_DELETE  = has_permission('master_bentuk.Delete');
	$id_category1 = 'I2000001';
	foreach($results['cycletime'] as $cycletime){}
?>
 <div class="box box-primary">
    <div class="box-body">
		<form id="data-form" method="post">
					  <div class="col-sm-12">
						   <div class="input_fields_wrap2">
										<div class="row"><div class="form-group row">
										<div class="col-md-2"><label for="customer">Costcenter</label></div>
									    <div class="col-md-4"> <select id="" name="hd1[1][costcenter]" class="form-control select" required>
											<option value="">-- Pilih Costcenter --</option>
											<?php foreach ($results['costcenter'] as $costcenter){ 
											$select = $cycletime->costcenter == $costcenter->id_costcenter? 'selected' : '';
											?>
											<option value="<?= $costcenter->id_costcenter?>" <?= $select ?>><?= ucfirst(strtolower($costcenter->nama_costcenter))?></option>
											<?php } ?>
										  </select></div>
										
										<div class="col-md-2"><label for="customer">Mechine</label></div>
										<div class="col-md-4"><input type="text" value="<?= $cycletime->machine?>" class="form-control" id="" required name="hd1[1][machine]" placeholder="Mechine"></div>
										  <div class="col-md-4" hidden><input type="text" value="<?= $cycletime->id_time?>" class="form-control" id="" required name="hd1[1][id_time]" placeholder="Mechine"></div>
										</div></div>
									<div class="row"><div class="form-group row">
									<?php
										echo form_button(array('type'=>'button','class'=>'btn btn-md btn-success','value'=>'back','content'=>'Add','id'=>'add-payment'));
									?>
									<table class='table table-bordered table-striped'>
										<thead><tr class='bg-blue'>
										<td align='center'><b>#</b></td>
										<td align='center'><b>Process</b></td>	
										<td align='center'><b>Cycletime (Minutes)</b></td>	
										<td align='center'><b>Qty Manpower</b></td>
										<td align='center'><b>Keterangan</b></td>
										<td align='center'><b>#</b></td>
										</tr></thead>
										<tbody id='list_payment'>
									<?php if(empty($results['detail'])){}else{
									$loop=0; foreach($results['detail'] AS $detail){ $loop++; ?>
							
							<tr id="tr_<?= $loop; ?>">
									<td align='left'><?= $loop; ?></td>
									<td align='left'><input type='text' class="form-control" value="<?= $detail->process; ?>" id="data1_<?= $loop; ?>_process" required name="data1[<?= $loop; ?>][process]" placeholder="Process"></td>
									<td align='left'><input type='number' class="form-control" value="<?= $detail->cycletime; ?>" id="data1_<?= $loop; ?>_cycletime" required name="data1[<?= $loop; ?>][cycletime]" placeholder="cycletime/Minute"></td>
									<td align='left'><input type='number' class="form-control" value="<?= $detail->qty_mp; ?>" id="data1_<?= $loop; ?>_qty_mp" required name="data1[<?= $loop; ?>][qty_mp]" placeholder="Manpower Qty"></td>
									<td align='left'><input type='text' class="form-control" value="<?= $detail->note; ?>" id="data1_<?= $loop; ?>_note" required name="data1[<?= $loop; ?>][note]" placeholder="NOTE"></td>
									<td align='center'><button type='button' class='btn btn-sm btn-danger' title="Hapus Data" data-role="qtip" onClick='return DelItem(<?= $loop; ?>);'><i class="fa fa-trash-o"></i></button></td>
							</tr>
									<?php } }  ?>
										</tbody>
									</table>
									</div></div>
						  </div>
						</div>
						<div class="col-sm-3">
						</div>
					  </div>
				  </div> 
				  
				  
				 	<hr>
					<center>
					<!--<button type="submit" class="btn btn-primary btn-sm add_field_button2" name="save"><i class="fa fa-plus"></i>Add Main Produk</button>
					--><button type="submit" class="btn btn-success btn-sm" name="save" id="simpan-com"><i class="fa fa-save"></i>Simpan</button>
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
			


		$('#add-payment').click(function(){
			var jumlah	=$('#list_payment').find('tr').length;
			if(jumlah==0 || jumlah==null){
				var ada		= 0;
				var loop	= 1;
			}else{
				var nilai		= $('#list_payment tr:last').attr('id');
				var jum1		= nilai.split('_');
				var loop		= parseInt(jum1[1])+1; 
			}
			Template	='<tr id="tr_'+loop+'">';
			Template	+='<td align="left">';
			Template	+=''+loop+'';		
			Template	+='</td>';
			Template	+='<td align="left">';
					Template	+='<input type="text" class="form-control" id="data1_'+loop+'_process" required name="data1['+loop+'][process]" placeholder="Process">';
			Template	+='</td>';
			Template	+='<td align="left">';
					Template	+='<input type="number" class="form-control" id="data1_'+loop+'_cycletime" required name="data1['+loop+'][cycletime]" placeholder="cycletime/Minute">';
			Template	+='</td>';
			Template	+='<td align="left">';
					Template	+='<input type="number" class="form-control" id="data1_'+loop+'_qty_mp" required name="data1['+loop+'][qty_mp]" placeholder="Manpower Qty">';
			Template	+='</td>';
			Template	+='<td align="left">';
					Template	+='<input type="text" class="form-control" id="data1_'+loop+'_note" required name="data1['+loop+'][note]" placeholder="NOTE">';
			Template	+='</td>';
			Template	+='<td align="center"><button type="button" class="btn btn-sm btn-danger" title="Hapus Data" data-role="qtip" onClick="return DelItem('+loop+');"><i class="fa fa-trash-o"></i></button></td>';
			Template	+='</tr>';
			$('#list_payment').append(Template);
			$('input[data-role="tglbayar"]').datepicker({
				format: 'dd-mm-yyyy',
				autoclose: true			
			});
			});
			
			
			
	$('#simpan-com').click(function(e){
			e.preventDefault();
			var deskripsi	= $('#deskripsi').val();
			var image	= $('#image').val();
			var idtype	= $('#inventory_1').val();
			
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
						var baseurl=siteurl+'cycletime/saveEditbentuk';
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

function DelItem(id){
		$('#list_payment #tr_'+id).remove();
		
	}
</script>