<?php
    $ENABLE_ADD     = has_permission('master_bentuk.Add');
    $ENABLE_MANAGE  = has_permission('master_bentuk.Manage');
    $ENABLE_VIEW    = has_permission('master_bentuk.View');
    $ENABLE_DELETE  = has_permission('master_bentuk.Delete');
	$id_category1 = $this->uri->segment(3);
foreach ($results['scrap'] as $scr){};
foreach ($results['cogs'] as $cgs){};
foreach ($results['operating_cost'] as $opcost){};
foreach ($results['interest'] as $interest){};					
?>
 <div class="box box-primary">
    <div class="box-body">
		<form id="data-form" method="post">
					  <div class="col-sm-12">
						<div class="input_fields_wrap2">
											<div class="row" hidden>
										<div class="form-group row">
										<div class="col-md-4">
									    <label for="customer">Book Price (Rp/kg)</label>
									    </div>
									    <div class="col-md-6">
					<input type="text" class="form-control" id="inven1"  required name="inven1" placeholder="Book Price (Rp/kg)" value="<?=$id_category1?>">
									    </div>
										</div>
						 </div>				
						<div class="row">
										<div class="form-group row">
										<div class="col-md-4">
									    <label for="customer">Material</label>
									    </div>
									    <div class="col-md-6">
					<select id="id_category3" name="id_category3" class="form-control select" onchange="hitungharga()" required>
						<option value="">-- Pilih Type --</option>
						<?php foreach ($results['inventory_3'] as $inventory_3){ 
						?>
						<option value="<?= $inventory_3->id_category3?>"><?= ucfirst(strtolower($inventory_3->nama_category2))?>-<?= ucfirst(strtolower($inventory_3->nama))?>-<?= ucfirst(strtolower($inventory_3->hardness))?>-<?= ucfirst(strtolower($inventory_3->nilai_dimensi))?></option>
						<?php } ?>
					</select>
									    </div>
										</div>
						</div>	
					<div class="row">
					<table class="col-sm-12">
						<tr>
						<th>#</th>
						<th>Book Price (Rp/Kg)</th>
						<th>Harga Lme rate 10 hari(Rp/Kg)</th>
						<th>Harga Lme rate 30 hari(Rp/Kg)</th>
						<th>Harga Lme SPOT(Rp/Kg)</th>
						</tr>
						<tr id="head_price">
						<th>Harga Satuan</th>
						<td><input type="text" class="form-control" id="book_price"  required name="book_price" placeholder="Book Price ($/kg)" ></td>
						<td><input type="text" class="form-control" id="lme101" readonly required name="lme101" placeholder="Book Price ($/kg)" ></td>
						<td><input type="text" class="form-control" id="lme301" readonly required name="lme301" placeholder="Book Price ($/kg)" ></td>
						<td><input type="text" class="form-control" id="lmespot1" readonly required name="lmespot1" placeholder="Book Price ($/kg)" ></td>
						<td hidden><input type="text" class="form-control" id="lme10" readonly required name="lme10" placeholder="Book Price ($/kg)" ></td>
						<td hidden><input type="text" class="form-control" id="lme30" readonly required name="lme30" placeholder="Book Price ($/kg)" ></td>
						<td hidden><input type="text" class="form-control" id="lmespot" readonly required name="lmespot" placeholder="Book Price ($/kg)" ></td>
						</tr>
						<tr>
						<th>SCRAP (%)</th>
						<td><input type="text" class="form-control" id="scrap"  readonly required name="scrap" placeholder="Scrap" value="<?=$scr->presentase_rate?>"></td>
						<td><input type="text" class="form-control" id="scrap1" readonly required name="scrap1" placeholder="Scrap" value="<?=$scr->presentase_rate?>"></td>
						<td><input type="text" class="form-control" id="scrap2" readonly required name="scrap2" placeholder="Scrap" value="<?=$scr->presentase_rate?>"></td>
						<td><input type="text" class="form-control" id="scrap3" readonly required name="scrap3" placeholder="Scrap" value="<?=$scr->presentase_rate?>"></td>
						</tr>
						<tr>
						<th>COGS (%)</th>
						<td><input type="text" class="form-control" id="cogs"  readonly required name="cogs" placeholder="COGS" value="<?= $cgs->presentase_rate?>"></td>
						<td><input type="text" class="form-control" id="cogs1" readonly required name="cogs1" placeholder="COGS" value="<?= $cgs->presentase_rate?>"></td>
						<td><input type="text" class="form-control" id="cogs2" readonly required name="cogs2" placeholder="COGS" value="<?= $cgs->presentase_rate?>"></td>
						<td><input type="text" class="form-control" id="cogs3" readonly required name="cogs3" placeholder="COGS" value="<?= $cgs->presentase_rate?>"></td>
						</tr>
						<th>Operating Cost (%)</th>
						<td><input type="text" class="form-control" id="operating_cost"  readonly required name="operating_cost" placeholder="Operating Cost" value="<?= $opcost->presentase_rate?>"></td>
						<td><input type="text" class="form-control" id="operating_cost1"  readonly required name="operating_cost1" placeholder="Operating Cost" value="<?= $opcost->presentase_rate?>"></td>
						<td><input type="text" class="form-control" id="operating_cost2"  readonly required name="operating_cost2" placeholder="Operating Cost" value="<?= $opcost->presentase_rate?>"></td>
						<td><input type="text" class="form-control" id="operating_cost3"  readonly required name="operating_cost3" placeholder="Operating Cost" value="<?= $opcost->presentase_rate?>"></td>
						</tr>
						<th>Interest inventory (%)</th>
						<td><input type="text" class="form-control" id="interest"  readonly required name="interest" placeholder="Interest" value="<?= $interest->presentase_rate?>"></td>
						<td><input type="text" class="form-control" id="interest1"  readonly required name="interest1" placeholder="Interest" value="<?= $interest->presentase_rate?>"></td>
						<td><input type="text" class="form-control" id="interest2"  readonly required name="interest2" placeholder="Interest" value="<?= $interest->presentase_rate?>"></td>
						<td><input type="text" class="form-control" id="interest3"  readonly required name="interest3" placeholder="Interest" value="<?= $interest->presentase_rate?>"></td>
						</tr>
						<th>Profit (%)</th>
						<td><input type="text" class="form-control" id="profit"      onkeyup="hitungbottom()" required name="profit" placeholder="Profit" ></td>
						<td><input type="text" class="form-control" id="profit10"    onkeyup="hitungbottom10()"  required name="profit10" placeholder="Profit" ></td>
						<td><input type="text" class="form-control" id="profit30"    onkeyup="hitungbottom30()"  required name="profit30" placeholder="Profit" ></td>
						<td><input type="text" class="form-control" id="profitspot"  onkeyup="hitungbottomspot()" required name="profitspot" placeholder="Profit" ></td>
						</tr >
						<th>Bottom price</th>
						<td id="bt_price" hidden><input type="text" class="form-control" id="bottom_price"   required name="bottom_price" placeholder="Bottom Price" ></td>
						<td id="bt_price1" ><input type="text" class="form-control" id="bottom_price1"   required name="bottom_price1" placeholder="Bottom Price" ></td>
						<td id="bt_price10" hidden><input type="text" class="form-control" id="bottom_price10"   required name="bottom_price10" placeholder="Bottom Price" ></td>
						<td id="bt_price101"><input type="text" class="form-control" id="bottom_price101"   required name="bottom_price101" placeholder="Bottom Price" ></td>
						<td id="bt_price30" hidden><input type="text" class="form-control" id="bottom_price30"   required name="bottom_price30" placeholder="Bottom Price" ></td>
						<td id="bt_price301"><input type="text" class="form-control" id="bottom_price301"   required name="bottom_price301" placeholder="Bottom Price" ></td>
						<td id="bt_pricespot" hidden><input type="text" class="form-control" id="bottom_pricespot"   required name="bottom_pricespot" placeholder="Bottom Price" ></td>
						<td id="bt_pricespot1"><input type="text" class="form-control" id="bottom_pricespot1"   required name="bottom_pricespot1" placeholder="Bottom Price" ></td>
						</tr>
					</table>
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
						var baseurl=siteurl+'pricelist/saveNewPricelistnfr';
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
									window.location.href = base_url + active_controller+'/detailnfr/'+data.code;
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

function hitungharga(){
        var id_category3=$("#id_category3").val();
		 $.ajax({
            type:"GET",
            url:siteurl+'pricelist/hitungharganfr',
            data:"id_category3="+id_category3,
            success:function(html){
               $("#head_price").html(html);
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
            url:siteurl+'pricelist/hitungbottomnfr',
            data:"book_price="+book_price+"&scrap="+scrap+"&cogs="+cogs+"&operating_cost="+operating_cost+"&interest="+interest+"&profit="+profit,
            success:function(html){
               $("#bt_price").html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'pricelist/hitungbottomnfr1',
            data:"book_price="+book_price+"&scrap="+scrap+"&cogs="+cogs+"&operating_cost="+operating_cost+"&interest="+interest+"&profit="+profit,
            success:function(html){
               $("#bt_price1").html(html);
            }
        });
    }
		function hitungbottom10(){
        var lme10=$("#lme10").val();
		var scrap=$("#scrap").val();
		var cogs=$("#cogs").val();
		var operating_cost=$("#operating_cost").val();
		var interest=$("#interest").val();
		var profit10=$("#profit10").val();
		 $.ajax({
            type:"GET",
            url:siteurl+'pricelist/hitungbottomnfr10',
            data:"lme10="+lme10+"&scrap="+scrap+"&cogs="+cogs+"&operating_cost="+operating_cost+"&interest="+interest+"&profit10="+profit10,
            success:function(html){
               $("#bt_price10").html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'pricelist/hitungbottomnfr101',
            data:"lme10="+lme10+"&scrap="+scrap+"&cogs="+cogs+"&operating_cost="+operating_cost+"&interest="+interest+"&profit10="+profit10,
            success:function(html){
               $("#bt_price101").html(html);
            }
        });
    }
			function hitungbottom30(){
        var lme30=$("#lme30").val();
		var scrap=$("#scrap").val();
		var cogs=$("#cogs").val();
		var operating_cost=$("#operating_cost").val();
		var interest=$("#interest").val();
		var profit30=$("#profit30").val();
		 $.ajax({
            type:"GET",
            url:siteurl+'pricelist/hitungbottomnfr30',
            data:"&lme30="+lme30+"&scrap="+scrap+"&cogs="+cogs+"&operating_cost="+operating_cost+"&interest="+interest+"&profit30="+profit30,
            success:function(html){
               $("#bt_price30").html(html);
            }
        });
				 $.ajax({
            type:"GET",
            url:siteurl+'pricelist/hitungbottomnfr301',
            data:"&lme30="+lme30+"&scrap="+scrap+"&cogs="+cogs+"&operating_cost="+operating_cost+"&interest="+interest+"&profit30="+profit30,
            success:function(html){
               $("#bt_price301").html(html);
            }
        });
    }
				function hitungbottomspot(){
        var lmespot=$("#lmespot").val();
		var scrap=$("#scrap").val();
		var cogs=$("#cogs").val();
		var operating_cost=$("#operating_cost").val();
		var interest=$("#interest").val();
		var profitspot=$("#profitspot").val();
		 $.ajax({
            type:"GET",
            url:siteurl+'pricelist/hitungbottomnfrspot',
            data:"lmespot="+lmespot+"&scrap="+scrap+"&cogs="+cogs+"&operating_cost="+operating_cost+"&interest="+interest+"&profitspot="+profitspot,
            success:function(html){
               $("#bt_pricespot").html(html);
            }
        });
				 $.ajax({
            type:"GET",
            url:siteurl+'pricelist/hitungbottomnfrspot1',
            data:"lmespot="+lmespot+"&scrap="+scrap+"&cogs="+cogs+"&operating_cost="+operating_cost+"&interest="+interest+"&profitspot="+profitspot,
            success:function(html){
               $("#bt_pricespot1").html(html);
            }
        });
    }
</script>