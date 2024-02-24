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
$scrap = $scr->presentase_rate/100;
$cogs =$cgs->presentase_rate/100;
$operating_cost =$opcost->presentase_rate/100;
$inter  =$interest->presentase_rate/100;
?>
 <div class="box box-primary">
    <div class="box-body">
	<center><div><h1>Refresh Pricelist</h1></div></center>
		<form id="data-form" method="post">
					  <div class="col-sm-12">
					  <div hidden>
					  <input type="text" class="form-control" id="inven1"  required name="inven1" value="<?=$id_category1?>">
						</div>
						<?php $numb = 0; foreach ($results['inventory_3'] as $inventory_3){
					$id_category3 = $inventory_3->id_category3;
					$bookprice	= $this->db->query("SELECT * FROM ms_bookprice_material WHERE id_category3='$id_category3' ")->result();
					$wayoh	= $this->db->query("SELECT * FROM ms_pricelistfr WHERE id_category3='$id_category3' ")->result();
			
		$scrapbookprice = $bookprice[0]->nilai_bookprice*$scrap;
		$cogsbookprice = $bookprice[0]->nilai_bookprice*$cogs;
		$operating_costbookprice = $bookprice[0]->nilai_bookprice*$operating_cost;
		$interbookprice = $bookprice[0]->nilai_bookprice*$inter;
		$profitbookprice = $bookprice[0]->nilai_bookprice*$wayoh[0]->profit/100;

		$nilaiakhirbook = $bookprice[0]->nilai_bookprice+$scrapbookprice+$cogsbookprice+$operating_costbookprice+$interbookprice+$profitbookprice;
		$nilaiakhirlme10 = $lme10+$scraplme10+$cogslme10+$operating_costlme10+$interlme10+$profitlme10;
		$nilaiakhirlme30 = $lme30+$scraplme30+$cogslme30+$operating_costlme30+$interlme30+$profitlme30;
		$nilaiakhirlmespot = $lmespot+$scraplmespot+$cogslmespot+$operating_costlmespot+$interlmespot+$profitlmespot;
					$numb ++;
					?>
					<div hidden>
					<input type="text" class="form-control"  required name="plnfr[<?=$numb?>][id_category3]" value="<?=$id_category3?>">
					<input type="text" class="form-control"  required name="plnfr[<?=$numb?>][book_price]" value="<?=$bookprice[0]->nilai_bookprice?>">
					<input type="text" class="form-control"  required name="plnfr[<?=$numb?>][profit]" value="<?=$wayoh[0]->profit?>">
					<input type="text" class="form-control"  required name="plnfr[<?=$numb?>][bottom_price]" value="<?=$nilaiakhirbook?>">
					</div>
					<?php };?>
				 	<hr>
					<center>
					<!--<button type="submit" class="btn btn-primary btn-sm add_field_button2" name="save"><i class="fa fa-plus"></i>Add Main Produk</button>
					--><button type="submit" class="btn btn-success btn-sm" name="save"  id="simpan-com"><i class="fa fa-refresh"></i>Refresh</button>
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
						var baseurl=siteurl+'pricelist/saveRefreshPricelistfr';
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