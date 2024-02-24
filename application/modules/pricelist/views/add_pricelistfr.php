<?php
    $ENABLE_ADD     = has_permission('master_bentuk.Add');
    $ENABLE_MANAGE  = has_permission('master_bentuk.Manage');
    $ENABLE_VIEW    = has_permission('master_bentuk.View');
    $ENABLE_DELETE  = has_permission('master_bentuk.Delete');
	$id_category1 = $this->uri->segment(3);
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
					<select id="id_category3" name="id_category3" class="form-control select" onchange="caribookpricefr()" required>
						<option value="">-- Pilih Type --</option>
						<?php foreach ($results['inventory_3'] as $inventory_3){ 
						?>
						<option value="<?= $inventory_3->id_category3?>"><?= ucfirst(strtolower($inventory_3->nama_category2))?>-<?= ucfirst(strtolower($inventory_3->nama))?>-<?= ucfirst(strtolower($inventory_3->hardness))?>-<?= ucfirst(strtolower($inventory_3->nilai_dimensi))?></option>
						<?php } ?>
					 </select>
									    </div>
										</div>
						  </div>	
					<div class="row" hidden>
										<div class="form-group row">
										<div class="col-md-4">
									    <label for="customer">Book Price (Rp/kg)</label>
									    </div>
									    <div class="col-md-6" >
					<input type="text" class="form-control" id="inven1"  required name="inven1" placeholder="Book Price (Rp/kg)" value="<?=$id_category1?>">
									    </div>
										</div>
						 </div>					
					<div class="row">
										<div class="form-group row">
										<div class="col-md-4">
									    <label for="customer">Book Price (Rp/kg)</label>
									    </div>
									    <div class="col-md-6" id="slotbookprice">
					<input type="text" class="form-control" id="book_price"  required name="book_price" placeholder="Book Price (Rp/kg)">
									    </div>
										</div>
						 </div>
						 <div class="row">
										<div class="form-group row">
										<div class="col-md-4">
									    <label for="customer">Scrap (%)</label>
									    </div>
									    <div class="col-md-6">
										<?php foreach ($results['scrap'] as $scr){ 
						?>
					<input type="text" class="form-control" id="scrap" value="<?= $scr->presentase_rate?>" required name="scrap" readonly placeholder="Scrap (%)">
									    <?php } ?>
										</div>
										</div>
						 </div>
						  <div class="row">
										<div class="form-group row">
										<div class="col-md-4">
									    <label for="customer">COGS (%)</label>
									    </div>
									    <div class="col-md-6">
										<?php
										foreach($results['cogs'] as $cgs){
											?>
					<input type="text" class="form-control" id="cogs" value="<?= $cgs->presentase_rate?>" required name="cogs" readonly placeholder="COGS (%)">
									    <?php } ?>
										</div>
										</div>
						 </div>
						 <div class="row">
										<div class="form-group row">
										<div class="col-md-4">
									    <label for="customer">Operating Cost (%)</label>
									    </div>
									    <div class="col-md-6">
										<?php foreach($results['operating_cost'] as $opcost){
											?>
					<input type="text" class="form-control" id="operating_cost" value="<?= $opcost->presentase_rate?>" required name="operating_cost" readonly placeholder="Operating Cost (%)">
									    <?php } ?>
										</div>
										</div>
						 </div>
						 <div class="row">
										<div class="form-group row">
										<div class="col-md-4">
									    <label for="customer">interest(%)</label>
									    </div>
									    <div class="col-md-6">
										<?
											foreach($results['interest'] as $interest){
										?>
					<input type="text" class="form-control" id="interest" value="<?= $interest->presentase_rate?>" required name="interest" readonly placeholder="Operating Cost (%)">
									    <?php } ?>
										</div>
										</div>
						 </div>
					<div class="row">
										<div class="form-group row">
										<div class="col-md-4">
									    <label for="customer">Profit (%)</label>
									    </div>
									    <div class="col-md-6">
					<input type="text" class="form-control" id="profit"  required name="profit" onkeyup="hitungbottom()" placeholder="Profit (%)">
									    </div>
										</div>
						 </div>
					<div class="row">
										<div class="form-group row">
										<div class="col-md-4">
									    <label for="customer">Bottom price (Rp/kg)</label>
									    </div>
									    <div class="col-md-6" id="untukbottom">
					<input type="text" class="form-control" id="bottom_price"  required name="bottom_price" placeholder="Bottom price (Rp/kg)">
									    </div>
										</div>
						 </div>
						</div>
				 	<hr>
					<center>
					<!--<button type="submit" class="btn btn-primary btn-sm add_field_button2" name="save"><i class="fa fa-plus"></i>Add Main Produk</button>
					--><button type="submit" class="btn btn-success btn-sm" name="save" id="simpan-com"><i class="fa fa-save"></i>Simpan</button>
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
						var baseurl=siteurl+'pricelist/saveNewPricelistfr';
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
function caribookpricefr(){
        var id_category3=$("#id_category3").val();
		 $.ajax({
            type:"GET",
            url:siteurl+'pricelist/caribookpricefr',
            data:"id_category3="+id_category3,
            success:function(html){
               $("#slotbookprice").html(html);
            }
        });
    }
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