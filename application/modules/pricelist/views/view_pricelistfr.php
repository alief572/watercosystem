<?php
    $ENABLE_ADD     = has_permission('master_bentuk.Add');
    $ENABLE_MANAGE  = has_permission('master_bentuk.Manage');
    $ENABLE_VIEW    = has_permission('master_bentuk.View');
    $ENABLE_DELETE  = has_permission('master_bentuk.Delete');
	$id_category1 = 'I2000001';
	foreach($results['pl'] as $pricelist){}
?>
 <div class="box box-primary">
    <div class="box-body">
		<form id="data-form" method="post">
					  <div class="col-sm-12">
						<div class="input_fields_wrap2">
										
							<div class="row">
										<div class="form-group row">
										<div class="col-md-4">
									    <label for="customer">Material</label>
									    </div>
									    <div class="col-md-6">
					<select readonly id="id_category3" name="id_category3" class="form-control select"  required>
					<option value="">-- Material --</option>
					<?php foreach ($results['inventory_3'] as $inventory_3){
						$select = $pricelist->id_category3 == $inventory_3->id_category3 ? 'selected' : '';
						?>
						<option value="<?= $inventory_3->id_category3?>" <?= $select ?>><?= ucfirst(strtolower($inventory_3->nama_category2))?>-<?= ucfirst(strtolower($inventory_3->nama))?>-<?= ucfirst(strtolower($inventory_3->hardness))?></option>
						<?php } ?>
					 </select>
									    </div>
										</div>
						  </div>	
					<div class="row" >
										<div class="form-group row" hidden>
										<div class="col-md-4">
									    <label for="customer">Book Price (Rp/kg)</label>
									    </div>
									    <div class="col-md-6">
					<input type="text" class="form-control" id="id_pricelistfr"  required name="id_pricelistfr"  placeholder="Book Price (Rp/kg)" value="<?=$pricelist->id_pricelistfr?> ">
					<input type="text" class="form-control" id="inven1"  required name="inven1"  placeholder="Book Price (Rp/kg)" value="<?=$id_category1?> ">
									    </div>
										</div>
						 </div>					
					<div class="row">
										<div class="form-group row">
										<div class="col-md-4">
									    <label for="customer">Book Price (Rp/kg)</label>
									    </div>
									    <div class="col-md-6">
					<input type="text" class="form-control" id="book_price" readonly required name="book_price" value="<?=$pricelist->book_price?>" placeholder="Book Price (Rp/kg)">
									    </div>
										</div>
						 </div>
						 <div class="row">
										<div class="form-group row">
										<div class="col-md-4">
									    <label for="customer">Scrap (%)</label>
									    </div>
									    <div class="col-md-6">
					<input type="text" class="form-control" id="scrap" value="<?=$pricelist->scrap?>" required name="scrap" readonly placeholder="Scrap (%)">
										</div>
										</div>
						 </div>
						  <div class="row">
										<div class="form-group row">
										<div class="col-md-4">
									    <label for="customer">COGS (%)</label>
									    </div>
									    <div class="col-md-6">
					<input type="text" class="form-control" id="cogs" value="<?=$pricelist->cogs?>"required name="cogs" readonly placeholder="COGS (%)">
										</div>
										</div>
						 </div>
						 <div class="row">
										<div class="form-group row">
										<div class="col-md-4">
									    <label for="customer">Operating Cost (%)</label>
									    </div>
									    <div class="col-md-6">
					<input type="text" class="form-control" id="operating_cost" value="<?=$pricelist->operating_cost?>" required name="operating_cost" readonly placeholder="Operating Cost (%)">
										</div>
										</div>
						 </div>
						 <div class="row">
										<div class="form-group row">
										<div class="col-md-4">
									    <label for="customer">interest(%)</label>
									    </div>
									    <div class="col-md-6">
					<input type="text" class="form-control" id="interest" value="<?=$pricelist->interest?>" required name="interest" readonly placeholder="Operating Cost (%)">
										</div>
										</div>
						 </div>
					<div class="row">
										<div class="form-group row">
										<div class="col-md-4">
									    <label for="customer">Profit (%)</label>
									    </div>
									    <div class="col-md-6">
					<input type="text" class="form-control" id="profit" readonly value="<?=$pricelist->profit?>"  required name="profit" onkeyup="hitungbottom()" placeholder="Profit (%)">
									    </div>
										</div>
						 </div>
					<div class="row">
										<div class="form-group row">
										<div class="col-md-4">
									    <label for="customer">Bottom price (Rp/kg)</label>
									    </div>
									    <div class="col-md-6" id="untukbottom">
					<input type="text" class="form-control" id="bottom_price" readonly value="<?=$pricelist->bottom_price?>" required name="bottom_price" placeholder="Bottom price (Rp/kg)">
									    </div>
										</div>
						 </div>
						</div>
				 	<hr>
					<center>
					<!--<button type="submit" class="btn btn-primary btn-sm add_field_button2" name="save"><i class="fa fa-plus"></i>Add Main Produk</button>
					<button type="submit" class="btn btn-success btn-sm" name="save" id="simpan-com"><i class="fa fa-save"></i>Simpan</button>-->
					</center>
					</div>
				  </form>
				  
				  
				  
	</div>
</div>	
	
				  
				  
				  
<script type="text/javascript">
	//$('#input-kendaraan').hide();
	var base_url			= '<?php echo base_url(); ?>';
	var active_controller	= '<?php echo($this->uri->segment(1)); ?>';
	
	$(document).ready(function(){
	
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
						var baseurl=siteurl+'pricelist/saveEditPricelistfr';
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
									window.location.href = base_url + active_controller+'/detailfr/'+data.code;
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
	function hitungbottom(){
        var book_price=$("#book_price").val();
		var scrap=$("#scrap").val();
		var cogs=$("#cogs").val();
		var operating_cost=$("#operating_cost").val();
		var interest=$("#interest").val();
		var profit=$("#profit").val();
		 $.ajax({
            type:"GET",
            url:siteurl+'pricelist/hitungbottomfr',
            data:"book_price="+book_price+"&scrap="+scrap+"&cogs="+cogs+"&operating_cost="+operating_cost+"&interest="+interest+"&profit="+profit,
            success:function(html){
               $("#untukbottom").html(html);
            }
        });
    }
</script>