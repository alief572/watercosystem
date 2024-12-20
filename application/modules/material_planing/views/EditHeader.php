<?php
    $ENABLE_ADD     = has_permission('Trans_inquiry.Add');
    $ENABLE_MANAGE  = has_permission('Trans_inquiry.Manage');
    $ENABLE_VIEW    = has_permission('Trans_inquiry.View');
    $ENABLE_DELETE  = has_permission('Trans_inquiry.Delete');
	$tanggal = date('Y-m-d');
?>
<form id="data-form" method="post">
<input type="hidden" name='id_material' value='<?=$results['header'][0]->id_material;?>'>
<input type="hidden" name='id_customer' value='<?=$results['header'][0]->id_customer;?>'>
<input type="hidden" name='width' value='<?=$results['width'];?>'>
<input type="hidden" name='id_dt_spkmarketing' value='<?=$results['header'][0]->id_dt_spkmarketing;?>'>
	<div class="box box-primary">
		<div class="box-body">	
			<div class="col-sm-12">
				<div class="form-group row">
					<div class="col-md-2">
						<label for="customer"><b>Alloy Number</b></label>
					</div>
					<div class="col-md-8">
						<?= $results['header'][0]->no_alloy;?>
					</div>
				</div>
			</div>
			<div class="col-sm-12">
				<div class="form-group row">
					<div class="col-md-2">
						<label for="customer"><b>Order</b></label>
					</div>
					<div class="col-md-8" id='max_qty'><?= number_format($results['header'][0]->qty_produk);?></div>
				</div>
			</div>
			<div class="col-sm-12">
				<div class="form-group row">
					<div class="col-md-2">
						<label for="customer"><b>Proses PO-PR</b></label>
					</div>
					<div class="col-md-8"><?= $results['get_po_pr'];?> Kg</div>
				</div>
			</div>
			<div class="col-sm-12">
				<div class="form-group row">
					<div class="col-md-2">
						<label for="width"><b>Width</b></label>
					</div>
					<div class="col-md-8"><?= number_format($results['header'][0]->width);?></div>
				</div>
			</div>
			<div class="col-sm-12">
				<div class="form-group row" >
					<table class='table table-bordered table-striped'>
						<thead>
							<tr>
								<th colspan='5'>MATERIAL</th>
							</tr>
							<tr class='bg-blue'>
								<th>No Lot</th>
								<th>Width</th>
								<th>Qty</th>
								<th>Berat Coil</th>
								<th>Total Berat</th>
							</tr>
						</thead>
						<tbody id="list_penawaran_slot">
							<?php
							if(!empty($results['stok'])){
							$loop=0;
							$SUM = 0;
							$BOOK = 0;
							$BALL = 0;
							foreach($results['stok'] as $stok){
								$loop++;
								$SUM += $stok->totalweight - $stok->booking;
								$BOOK += $stok->booking;

								$balance = $stok->totalweight - $stok->booking;

								$BALL += $balance;

								echo "
								<tr id='tabel_penawaran_$loop'>
									<td>$stok->lotno</td>
									<td align='right'>$stok->width</td>
									<td align='center'>$stok->qty</td>
									<td align='right'>$stok->weight</td>
									<td align='right'>$stok->totalweight</td>
								</tr>";
							};?>
							<tr>
								<td colspan='4'>TOTAL</td>
								<td align='right'><?=number_format($SUM,2);?></td>
							</tr>
							<?php }else{ ?>
								<tr>
									<td colspan='5'>Data not found.</td>
								</tr>
							<?php } ?>
						</tbody>
						<?php if($results['viewx'] != 'onlyview'){ ?>
						<thead>
							<tr>
								<th colspan='7'>FINISH GOOD</th>
							</tr>
							<tr class='bg-blue'>
								<th>No Lot</th>
								<th>Width</th>
								<th>Qty</th>
								<th>Berat Coil</th>
								<th>Total Berat</th>
								<th>Option</th>
								<th>Keterangan</th>
							</tr>
						</thead>
						<tbody id="list_penawaran_slot">
							<?php 
							if(!empty($results['stok_fg'])){
							$loop=0;
							$SUM = 0;
							foreach($results['stok_fg'] as $stok){
								if($stok->totalweight - $stok->booking > 0){
									$loop++;
									$SUM += $stok->totalweight - $stok->booking;
									echo "
									<tr id='tabel_penawaran_$loop'>
										<td>$stok->lotno</td>
										<td align='right'>$stok->width</td>
										<td align='center'>$stok->qty</td>
										<td align='right'>$stok->weight</td>
										<td align='right' id='weight_$stok->id_stock'>".number_format($stok->totalweight - $stok->booking,2)."</td>
										<td align='center'>
											<input type='checkbox' class='chk_personal' id='ch_$loop' name='detail[$loop][id]' value='".$stok->id_stock."'>
										</td>
										<td>
											<input type='text' class='form-control input-sm' name='detail[$loop][keterangan]'>
											<input type='hidden' class='form-control' name='detail[$loop][id_stock]' value='$stok->id_stock'>
											<input type='hidden' class='form-control' name='detail[$loop][width]' value='$stok->width'>
											<input type='hidden' class='form-control' name='detail[$loop][qty]' value='$stok->qty'>
											<input type='hidden' class='form-control' name='detail[$loop][weight]' value='$stok->weight'>
											<input type='hidden' class='form-control' name='detail[$loop][berat]' value='$stok->totalweight - $stok->booking'>
										</td>
									</tr>";
								}
							};?>
							<tr>
								<td colspan='4'>TOTAL</td>
								<td align='right' id='total_check'></td>
								<td></td>
								<td></td>
							</tr>
							<?php }else{ ?>
								<tr>
									<td colspan='5'>Data not found.</td>
									<td></td>
									<td></td>
								</tr>
							<?php } ?>
						</tbody>
						<?php } ?>
						<thead>
							<tr>
								<th colspan='5'>BOOKING</th>
							</tr>
							<tr class='bg-blue'>
								<th>No Lot</th>
								<th>Width</th>
								<th>Qty</th>
								<th>Berat Coil</th>
								<th>Booking</th>
							</tr>
						</thead>
						<tbody id="list_penawaran_slot">
							<?php
							if(!empty($results['stok_book'])){
							$loop=0;
							$SUM = 0;
							$BOOK = 0;
							$BALL = 0;
							foreach($results['stok_book'] as $stok){
								if($stok->booking >0){
									$loop++;
									$SUM += $stok->totalweight - $stok->booking;
									$BOOK += $stok->booking;

									$balance = $stok->totalweight - $stok->booking;

									$BALL += $balance;

									echo "
									<tr id='tabel_penawaran_$loop'>
										<td>$stok->lotno</td>
										<td align='right'>$stok->width</td>
										<td align='center'>$stok->qty</td>
										<td align='right'>$stok->weight</td>
										<td align='right'>$stok->booking</td>
									</tr>";
								}
							};?>
							<tr>
								<td colspan='4'>TOTAL</td>
								<td align='right'><?=number_format($BOOK,2);?></td>
							</tr>
							<?php }else{ ?>
								<tr>
									<td colspan='5'>Data not found.</td>
								</tr>
							<?php } ?>
						</tbody>

					</table>
					<?php if($results['viewx'] != 'onlyview'){ ?>
					<button type='button' class='btn btn-md btn-primary' id='save_fg'>Save</button>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>	
</form>	
				  
				  
				  
<script type="text/javascript">
	var base_url			= '<?php echo base_url(); ?>';
	var active_controller	= '<?php echo($this->uri->segment(1)); ?>';
	$(document).ready(function(){	
		var max_fields2      = 10; //maximum input boxes allowed
		var wrapper2         = $(".input_fields_wrap2"); //Fields wrapper
		var add_button2      = $(".add_field_button2"); //Add button ID		

		$('#save_fg').click(function(e){
			e.preventDefault();
			if($('.chk_personal:checked').length == 0){
				swal({
					title	: "Error Message!",
					text	: 'Checklist minimal satu ...',
					type	: "warning"
				});
				return false;
			}
			
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
						var formData = new FormData($('#data-form')[0]);
						var baseurl = siteurl + active_controller+'/SaveEditHeaderNew';
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

		$(document).on('click','.chk_personal', function(){
			if ($(this).is(':checked')) {
				changeChecked();
			}
			else{
				changeChecked();
			}
		});
	});

	function changeChecked(){
		let max_qty = getNum($('#max_qty').html().split(",").join(""));
		let SUM = 0;
		$(".chk_personal" ).each(function() {
			if ($(this).is(':checked')) {
				let id 		= $(this).val();
				SUM 		+= Number($('#weight_'+id).html().split(",").join(""));
			}
		});
		
		$('#total_check').html(number_format(SUM,2));
	}

	function number_format (number, decimals, dec_point, thousands_sep) {
		// Strip all characters but numerical ones.
		number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
		var n = !isFinite(+number) ? 0 : +number,
			prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
			sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
			dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
			s = '',
			toFixedFix = function (n, prec) {
				var k = Math.pow(10, prec);
				return '' + Math.round(n * k) / k;
			};
		// Fix for IE parseFloat(0.55).toFixed(0) = 0;
		s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
		if (s[0].length > 3) {
			s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
		}
		if ((s[1] || '').length < prec) {
			s[1] = s[1] || '';
			s[1] += new Array(prec - s[1].length + 1).join('0');
		}
		return s.join(dec);
	}

	function getNum(val) {
		if (isNaN(val) || val == '') {
			return 0;
		}
		return parseFloat(val);
	}
</script>