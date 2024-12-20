<?php
    $ENABLE_ADD     = has_permission('master_bentuk.Add');
    $ENABLE_MANAGE  = has_permission('master_bentuk.Manage');
    $ENABLE_VIEW    = has_permission('master_bentuk.View');
    $ENABLE_DELETE  = has_permission('master_bentuk.Delete');
foreach ($results['inven'] as $inven){
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
									    <label for="customer">Type Inventory</label>
									    </div>
									    <div class="col-md-6">
					<select id="inventory_1" name="hd1[1][inventory_1]" class="form-control select" onchange="get_inv2()" required>
					<option value="">-- Inventory --</option>
						<?php foreach ($results['inventory_1'] as $inventory_1){
						$select = $inven->id_type == $inventory_1->id_type ? 'selected' : '';
						?>
						<option value="<?= $inventory_1->id_type?>" <?= $select ?>><?= $inventory_1->nama?></option>
						<?php } ?>
					 </select>
									    </div>
										</div>
										<div class="form-group row">
										<div class="col-md-4">
									    <label for="customer">Inventory Category I</label>
									    </div>
									    <div class="col-md-6">
					<select id="inventory_2" name="hd1[1][inventory_2]" class="form-control select" onchange="get_inv3()" required>
						<option value="">-- Pilih Category I --</option>
						<?php foreach ($results['inventory_2'] as $inventory_2){
						$select = $inven->id_category1 == $inventory_2->id_category1 ? 'selected' : '';
						?>
						<option value="<?= $inventory_2->id_category1?>" <?= $select ?>><?= $inventory_2->nama?></option>
						<?php } ?>
					 </select>
									    </div>
										</div>
										<div class="form-group row">
										<div class="col-md-4">
									    <label for="customer">Inventory Category II</label>
									    </div>
									    <div class="col-md-6">
					<select id="inventory_3" name="hd1[1][inventory_3]" class="form-control select" required>
						<option value="">-- Pilih Category II --</option>
						<?php foreach ($results['inventory_3'] as $inventory_3){
						$select = $inven->id_category2 == $inventory_3->id_category2 ? 'selected' : '';
						?>
						<option value="<?= $inventory_3->id_category2?>" <?= $select ?>><?= $inventory_3->nama?></option>
						<?php } ?>
					</select>
									    </div>
										</div>
										<div class="form-group row">
										<div class="col-md-4">
									    <label for="customer">Nama Inventory III</label>
									    </div>
									    <div class="col-md-6" hidden>
					<input type="text" class="form-control" id="hd1[1][id_category3]" required name="hd1[1][id_category3]" value='<?= $inven->id_category3 ?>' placeholder="Nama Bentuk">
									    </div>
										<div class="col-md-6">
					<input type="text" class="form-control" id="hd1[1][nm_inventory]" required name="hd1[1][nm_inventory]" value='<?= $inven->nama ?>' placeholder="Nama Bentuk">
									    </div>
										</div>
										<div class="form-group row">
										<div class="col-md-4">
									    <label for="customer">Country Origin</label>
									    </div>
									    <div class="col-md-6">
					<input type="text" class="form-control" id="hd1[1][maker]" required name="hd1[1][maker]" value='<?= $inven->maker ?>' placeholder="Maker">
									    </div>
										</div>
										<div class="form-group row">
										<div class="col-md-4">
									    <label for="customer">Density</label>
									    </div>
									    <div class="col-md-6">
					<input type="text" class="form-control" id="hd1[1][density]" required name="hd1[1][density]" value='<?= $inven->density ?>' placeholder="Density">
									    </div>
										</div>
										<div class="form-group row" >
										<div class="col-md-4">
									    <label for="customer">Hardness</label>
									    </div>
									    <div class="col-md-6">
					<input type="text" class="form-control" id="hd1[1][hardness]" required name="hd1[1][hardness]" value='<?= $inven->hardness ?>' placeholder="Hardness">
									    </div>
										</div>
									<div class="col-sm-12">
									<div class="col-md-4">
									    <label for="customer">Komposisi Material</label>
									    </div>
									<b></b>
									<table class='table table-bordered table-striped'>
										<tbody id='list_compotition'>
											<?php
										$numb=0;
										foreach($results['komposisi'] AS $komposisi){
										$numb++;
											?>
					<tr>
					  <td hidden align='left'>
					  <input type='text' name='compo[<?= $numb?>][id_compotition]' readonly class='form-control'  value='<?= $komposisi->id_compotition ?>'>
					  </td>
					  <td align='left'>
					  <?= $komposisi->name_compotition ?>
					  </td>
					  <td align='left'>
					  <input type='text' name='compo[<?= $numb?>][jumlah_kandungan]' class='form-control'  value='<?= $komposisi->nilai_compotition ?>'>
					  </td>
					  <td align='left'>%</td>
                    </tr>
											<?php
											}
											?>
										</tbody>
									</table>
									</div>
										<div class="form-group row">
										<div class="col-md-4">
									    <label for="customer">Bentuk Material</label>
									    </div>
									     <div class="col-md-6" hidden>
					<input type="text" class="form-control" id="hd1[1][id_bentuk]" required name="hd1[1][id_bentuk]" value='<?= $inven->id_bentuk ?>' placeholder="Hardness">
									    </div>
										 <div class="col-md-6">
					<input type="text" class="form-control" id="hd1[1][nm_bentuk]" required name="hd1[1][nm_bentuk]" value='<?= $inven->nm_bentuk ?>' placeholder="Hardness">
									    </div>
										</div>
									<div class="col-sm-12">
									<div class="col-md-4">
									    <label for="customer">Dimensi Material</label>
									    </div>
									<b></b>
									<table class='table table-bordered table-striped'>
										<tbody id='list_dimensi'>
											<?php
										$numb=0;
										foreach($results['dimensi'] AS $dimensi){$numb++;
											?>
					<tr>
					  <td hidden align='left'>
					  <input type='text' name='dimens[<?= $numb?>][id_dimensi]' readonly class='form-control'  value='<?= $dimensi->id_dimensi?>'>
					  </td>
					  <td align='left'>
					  <?= $dimensi->nm_dimensi?>
					  
					  </td>
					  <td align='left'>
					  <input type='text' name='dimens[<?= $numb?>][nilai_dimensi]' class='form-control' value='<?= $dimensi->nilai_dimensi?>'>
					  </td>
                    </tr>
											<?php
											}
											?>	
										</tbody>
									</table>
									</div>
										<div class="form-group row">
										<div class="col-md-4">
									    <label for="customer">Surface</label>
									    </div>
									    <div class="col-md-6">
					<select id="id_surface" name="hd1[1][id_surface]" class="form-control select" required>
						<option value="">-- Pilih Type --</option>
						<?php foreach ($results['id_surface'] as $id_surface){
						$select = $inven->id_surface == $id_surface->id_surface ? 'selected' : '';
						?>
						<option value="<?= $id_surface->id_surface?>" <?= $select ?>><?= $id_surface->nm_surface?></option>
						<?php } ?>
					 </select>
									    </div>
										</div>
										<div class="form-group row" hidden>
										<div class="col-md-4">
									    <label for="customer">Mountly Forecast</label>
									    </div>
									    <div class="col-md-6">
					<input type="text" class="form-control" id="hd1[1][mountly_forecast]" required name="hd1[1][mountly_forecast]" value='<?= $inven->mountly_forecast ?>' placeholder="Mountly Forecast">
									    </div>
										</div>
										<div class="form-group row" hidden>
										<div class="col-md-4">
									    <label for="customer">Safey Stock</label>
									    </div>
									    <div class="col-md-6">
					<input type="text" class="form-control" id="hd1[1][safety_stock]" required name="hd1[1][safety_stock]" value='<?= $inven->safety_stock ?>' placeholder="Safety Stock">
									    </div>
										</div>
										<div class="form-group row" hidden>
										<div class="col-md-4">
									    <label for="customer">Order Point</label>
									    </div>
									    <div class="col-md-6">
					<input type="text" class="form-control" id="hd1[1][order_point]" required name="hd1[1][order_point]" value='<?= $inven->order_point ?>' placeholder="Order Point">
									    </div>
										</div>
										<div class="form-group row" hidden>
										<div class="col-md-4">
									    <label for="customer">Maximum Stock</label>
									    </div>
									    <div class="col-md-6">
					<input type="text" class="form-control" id="hd1[1][maksimum]" required name="hd1[1][maksimum]" value='<?= $inven->maksimum ?>' placeholder="Maximum Stock">
									    </div>
										</div>
										
										<div class="col-xs-2">
										&nbsp;
										</div>
										</div>
									<div class="col-sm-12">
									<b></b>
									<div class='box-tool pull-right'>
									<?php
										echo form_button(array('type'=>'button','class'=>'btn btn-md btn-success','value'=>'back','content'=>'Add','id'=>'add-payment'));
									?>
									</div>
									<table class='table table-bordered table-striped'>
										<thead>
											<tr class='bg-blue'>
												<td align='center'><b>Nama Supplier</b></td>
												<td align='center'><b>Lead Time</b></td>
												<td align='center'><b>Minimum Order</b></td>
												<td align='center'><b>Action</b></td>
											</tr>
											
										</thead>
										<tbody id='list_payment'>
										<?php
										$loop=0;
										foreach($results['dt_suplier'] AS $dt_suplier){$loop++;
										?>
										<tr id="tr_<?= $loop ?>">
			<td align="left">
			<select id="id_supplier" name="data1[<?= $loop ?>][id_supplier]" id="data1_<?= $loop ?>_id_supplier" class="form-control select" required>
			<option value="">-- Pilih Type --</option>
			<?php foreach ($results["id_supplier"] as $id_supplier){
			$select = $dt_suplier->id_suplier == $id_supplier->id_suplier ? 'selected' : '';
			?>
			<option value="<?= $id_supplier->id_suplier?>" <?= $select ?>><?= ucfirst(strtolower($id_supplier->name_suplier))?></option>
			<?php } ?>
			</select>
			</td>
			<td align="left">
			<input type="text" class="form-control input-sm" name="data1[<?= $loop ?>][lead]" id="data1_<?= $loop ?>_lead" label="FALSE" div="FALSE">
			</td>
			<td align="left">
			<input type="text" class="form-control input-sm" name="data1[<?= $loop ?>][minimum]" id="data1_<?= $loop ?>_minimum" label="FALSE" div="FALSE">
			</td>
			<td align="center"><button type="button" class="btn btn-sm btn-danger" title="Hapus Data" data-role="qtip" onClick="return DelItem(<?= $loop ?>);"><i class="fa fa-trash-o"></i></button></td>
			</tr>
											<?php
											}
											?>	
										</tbody>
									</table>
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
					Template	+='<select id="id_supplier" name="data1['+loop+'][id_supplier]" id="data1_'+loop+'_id_supplier" class="form-control select" required>';
					Template	+='<option value="">-- Pilih Type --</option>';
					Template	+='<?php foreach ($results["id_supplier"] as $id_supplier){?>';
					Template	+='<option value="<?= $id_supplier->id_suplier?>"><?= ucfirst(strtolower($id_supplier->name_suplier))?></option>';
					Template	+='<?php } ?>';
					Template	+='</select>';
			Template	+='</td>';
			Template	+='<td align="left">';
					Template	+='<input type="text" class="form-control input-sm" name="data1['+loop+'][lead]" id="data1_'+loop+'_lead" label="FALSE" div="FALSE">';
			Template	+='</td>';
			Template	+='<td align="left">';
					Template	+='<input type="text" class="form-control input-sm" name="data1['+loop+'][minimum]" id="data1_'+loop+'_minimum" label="FALSE" div="FALSE">';
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
						var baseurl=siteurl+'inventory_4/saveEditInventory';
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
$('#inventory_2').change(function(){
        var inventory_2=$("#inventory_2").val();
		 $.ajax({
            type:"GET",
            url:siteurl+'inventory_4/get_compotition',
            data:"inventory_2="+inventory_2,
            success:function(html){
               $("#list_compotition").html(html);
            }
        });
			});

  	function get_inv2(){
        var inventory_1=$("#inventory_1").val();
		 $.ajax({
            type:"GET",
            url:siteurl+'inventory_4/get_inven2',
            data:"inventory_1="+inventory_1,
            success:function(html){
               $("#inventory_2").html(html);
            }
        });
    }
	function get_bentuk(){
        var id_bentuk=$("#id_bentuk").val();
		 $.ajax({
            type:"GET",
            url:siteurl+'inventory_4/get_dimensi',
            data:"id_bentuk="+id_bentuk,
            success:function(html){
               $("#list_dimensi").html(html);
            }
        });
    }
	function get_inv3(){
        var inventory_2=$("#inventory_2").val();
		 $.ajax({
            type:"GET",
            url:siteurl+'inventory_4/get_inven3',
            data:"inventory_2="+inventory_2,
            success:function(html){
               $("#inventory_3").html(html);
            }
        });
    }
function DelItem(id){
		$('#list_payment #tr_'+id).remove();
		
	}
</script>