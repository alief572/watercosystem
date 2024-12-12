<?php
$ENABLE_ADD     = has_permission('Planning_Delivery.Add');
$ENABLE_MANAGE  = has_permission('Planning_Delivery.Manage');
$ENABLE_VIEW    = has_permission('Planning_Delivery.View');
$ENABLE_DELETE  = has_permission('Planning_Delivery.Delete');

foreach ($results['header'] as $hd){
?>
<div class="box box-primary">
    <div class="box-body">
		<form id="data-form" method="post">
			<div class="col-sm-12">
				<div class="input_fields_wrap2">
			<div class="row">
		<center><label for="customer" ><h3>Planning Delivery</h3></label></center>
		<div class="col-sm-12">
		    <div class="col-sm-6">
		        <div class="form-group row">
			        <div class="col-md-4">
				        <label for="customer">No.Sales Order</label>
			        </div>
			        <div class="col-md-8">
					<input type="hidden" id="no_so" value="<?= $hd->no_so?>" required name="no_so" readonly placeholder> 
                    <input type="text" class="form-control" id="no_surat" value="<?= $hd->no_surat?>" required name="no_surat" readonly placeholder="No Surat" tabindex='-1'>                    
			        </div>
		        </div>
		    </div>
		    <div class="col-sm-6">
		        <div class="form-group row">
			        <div class="col-md-4">
				        <label>Lokasi</label>
			        </div>
			        <div class="col-md-8">
                    <input type="text" class="form-control" id="location" value="<?= $hd->location?>" name="location" placeholder="Lokasi">
			        </div>
		        </div>
		    </div>		    
		</div>
		<div class="col-sm-12">
            <div class="col-sm-6">
                <div class="form-group row">
                    <div class="col-md-4">
                        <label for="id_customer">Customer</label>
                    </div>
                    <div class="col-md-8">
                        <select id="id_customer" name="id_customer" class="form-control select" disabled required tabindex='-1'>
                            <option value="">--Pilih--</option>
                             <?php foreach ($results['customers'] as $customers){
                             $select1 = $hd->id_customer == $customers->id_customer ? 'selected' : '';	?>
                            <option value="<?= $customers->id_customer?>"<?= $select1 ?>><?= strtoupper(strtolower($customers->name_customer))?></option>
                                <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
			<div class="col-sm-6">
		        <div class="form-group row">
			        <div class="col-md-4">
				        <label for="customer">Tanggal Kirim</label>
			        </div>
			        <div class="col-md-8">
				        <input type="date" class="form-control" id="tanggal" onkeyup required name="tanggal" value="<?php echo date('m/d/Y')?>" >
			        </div>
		        </div>
		    </div>
		</div>

		<div class="col-md-12">
		    <div class='col-sm-6'>
		        <div class='form-group row'>
			        <div class='col-md-4'>
				        <label for='email_customer'>Term Of Payment</label>
			        </div>
                    <div class='col-md-8'>
                        <select id="top" name="top" class="form-control select" required>
                            <option value="">--Pilih--</option>
                                <?php foreach ($results['top'] as $top){
                                $select2 = $top->id_top == $hd->top ? 'selected' : '';	?>
                            <option value="<?= $top->id_top?>" <?= $select2 ?> readonly><?= strtoupper(strtolower($top->nama_top))?></option>
                                <?php } ?>
                        </select>
                    </div>
			    </div>
		    </div>
		</div>
        <?php } ?>
		<div class="col-sm-12">
			<div class="col-sm-12">
				<div class="form-group row" >
					<table class='table table-bordered table-striped'>
						<thead>
							<tr class='bg-blue'>
								<th width='3%'>No</th>
								<th width='20%'>Nama Produk</th>
								<th width='5px'>Qty <br> SO</th>
								<th width='5px'>Qty <br> Planning</th>
								<th width='7%'>Harga <br> Produk</th>
								<th width='5px'>Diskon</th>
								<th width='3%'>Request<br> Delivery</th>
								<th width='3%'>Qty Terplanning</th>
								<th>Total Harga</th>
								<th>Metode Kirim</th>
								<th>Keterangan Kirim</th>
								
							</tr>
						</thead>
						<tbody id="list_spk">
						<?php $loop=0;
						$do_method = $this->db->query("SELECT info from ms_generate where tipe='do_method'")->result();
						$do_info = $this->db->query("SELECT info, info2 from ms_generate where tipe='do_info'")->result();
						foreach ($results['detail'] as $dt_spk){$loop++; 
							$material = $this->db->query("SELECT a.* FROM ms_inventory_category3 as a where a.id_category3='".$dt_spk->id_category3."' ")->result();
						$harga_satuan = number_format($dt_spk->harga_satuan);
						$total        = number_format($dt_spk->total_harga);
							
							echo "
							<tr id='tr_$loop'>
								<td><input type='hidden' name='id_so_detail[]' value='$dt_spk->id_so_detail'>$loop</td>
								<td>
									<select id='used_no_surat_$loop' name='id_category3[]' data-no='$loop' class='form-control select' required disabled tabindex='-1'>
									";	
									foreach($material as $produk){
										$select = $dt_spk->id_category3 == $produk->id_category3 ? 'selected' : '';
										echo"<option value='$produk->id_category3' $select>$produk->nama|$produk->kode_barang</option>";
									}
							echo	"</select>
								</td>
								<td id='qty_so_$loop' width='5px'><input type='text' class='form-control input-sm' id='used_qty_so_$loop' required name='qty_so[]' value='$dt_spk->qty_so' readonly tabindex='-1'></td>
								<td id='qty_delivery_$loop' width='5px'><input type='text' class='form-control input-sm qty' id='used_qty_delivery_$loop' required name='qty_delivery[]' onkeyup='HitungTotal($loop)'></td>
								<td id='harga_satuan_$loop'><input type='text' value='$harga_satuan' class='form-control input-sm' id='used_harga_satuan_$loop' required name='harga_satuan[]' readonly></td>
								<td id='diskon_$loop' width='5px'><input type='text' value='$dt_spk->diskon' class='form-control input-sm' id='used_diskon_$loop' required name='diskon[]' readonly></td>
								<td id='tgl_delivery_$loop'><input type='date' class='form-control input-sm' id='used_tgl_delivery_$loop' required name='tgl_delivery[]' value='$dt_spk->tgl_delivery' readonly tabindex='-1'></td>
								<td id='schedule_$loop' hidden><input type='date' class='form-control input-sm' id='used_schedule_$loop' required name='schedule[]' value='$dt_spk->schedule'></td>
								<td id='qty_terkirim_$loop' hidden><input type='text' value='$dt_spk->qty_terkirim' class='form-control input-sm' id='used_qty_terkirim_$loop' required name='qty_terkirim[]' readonly tabindex='-1'></td>
								<td id='qty_plan_$loop' ><input type='text' class='form-control input-sm' id='used_qty_plan_$loop' required name='qty_plan[]' value='$dt_spk->qty_delivery' readonly></td>
								<td id='freight_cost_$loop' hidden><input type='text' value='$dt_spk->freight_cost' class='form-control input-sm' id='used_freight_cost_$loop' required name='freight_cost[]' onblur='Freight($loop)' readonly></td>
								<td id='nilai_diskon_$loop' hidden><input type='text' value='$dt_spk->nilai_diskon' class='form-control'  id='used_nilai_diskon_$loop' required name='nilai_diskon[]' readonly></td>
								<td id='total_harga_$loop'><input type='text' value='$total' class='form-control input-sm total' id='used_total_harga_$loop' required name='total_harga[]' readonly tabindex='-1'></td>
								<td id='metode_kirim_$loop'>
								<select id='used_metode_kirim_$loop' name='metode_kirim[]' class='form-control' onblur='cekdoinfo($loop)'>
									<option value=''>Select</option>
									";	
									foreach($do_method as $methode){
										$select = $dt_spk->metode_kirim == $methode->info ? 'selected' : '';
										echo"<option value='$methode->info' $select>$methode->info</option>"; 
									}
							echo	"</select></td>

								<td id='keterangan_kirim_$loop'>
									<select id='used_keterangan_kirim_$loop' name='keterangan_kirim[]' class='form-control'>
									<option value=''>Select</option>
									";	
									foreach($do_info as $doinfo){
										$select = $dt_spk->keterangan_kirim == $doinfo->info2 ? 'selected' : '';
										echo"<option value='$doinfo->info2' $select data-info='$doinfo->info'>$doinfo->info2</option>";
									}
							echo	"</select></td>	
							    				
							</tr>";
						 }
						?>
						</tbody>
						<tfoot>
									    <tr>
											<th width='3%'></th>
											<th width='10%'></th>
											<th width='7%'></th>
											<th width='7%'></th>
											<th width='7%'></th>
											<th width='7%'></th>
											<th width='7%'><b>Total</b></th>											
											<th width='7%'></th>                                            
                                            <th width='7%'><input type='text' class='form-control totalproduk' id='totalproduk'  name='totalproduk' readonly value="<?= number_format($hd->nilai_so)?>" ></th>										
                                            <th width='7%'></th>
											<th width='7%'></th>	
										</tr>
										<tr>
											<th width='3%'></th>
											<th width='10%'></th>
											<th width='7%'></th>
											<th width='7%'></th>
											<th width='7%'></th> 
											<th width='7%'></th>
										
											<th width='7%'><b>PPN</b></th>											
											<th width='7%'><input type='text' class='form-control ppn' id='ppn'  name='ppn' onblur='hitungPpn()' value="<?= $hd->ppn?>" readonly></th>                                            
                                            <th width='7%'><input type='text' class='form-control totalppn' id='totalppn'  name='totalppn' value="<?= number_format($hd->nilai_ppn)?>" readonly ></th>										
											<th width='7%'></th>
											<th width='7%'></th>	
										</tr>
										<tr>
											<th width='3%'></th>
											<th width='10%'></th>
											<th width='7%'></th>
											<th width='7%'></th>
											<th width='7%'></th>
											<th width='7%'></th>
											
											<th width='7%'><b>Grand Total</b></th>											
											<th width='7%'></th>                                            
                                            <th width='7%'><input type='text' class='form-control grandtotal' id='grandtotal'  name='grandtotal' value="<?= number_format($hd->grand_total)?>" readonly ></th>										
                                            <th width='7%'></th>
											<th width='7%'></th>	
										</tr>
									   										
									</tfoot>
					</table>
				</div>
			</div>

			<div id="list_top"></div>

		</div>

		
		
		<center>
		<button type="submit" class="btn btn-success btn-sm" name="save" id="simpan-com"><i class="fa fa-save"></i>Simpan</button>
		<a class="btn btn-danger btn-sm" href="<?= base_url('/wt_delivery_order/planning_do') ?>"  title="Kembali">Kembali</a>
		</center>
		</form>		  
	</div>
</div>	
	
				  
				  
				  
<script type="text/javascript">
	<?php
	if($results['action']=='view') echo '$("#data-form :input").prop("disabled", true);';
	?>
	function cekdoinfo(id){
		let selector = $("#used_metode_kirim_"+id).val();
		$("#used_keterangan_kirim_"+id+" > option").hide();
		$("#used_keterangan_kirim_"+id+" > option").filter(function(){return $(this).data('info') == selector}).show();
	}
	//$('#input-kendaraan').hide();
	var base_url			= '<?php echo base_url(); ?>';
	var active_controller	= '<?php echo($this->uri->segment(1)); ?>';
	$(document).ready(function(){	
			GetTop();
			var max_fields2      = 10; //maximum input boxes allowed
			var wrapper2         = $(".input_fields_wrap2"); //Fields wrapper
			var add_button2      = $(".add_field_button2"); //Add button ID		

			$('.select').select2({
				width: '100%'
			});
	$('#simpan-com').click(function(e){
			e.preventDefault();
			var lokasi	= $('#lokasi').val();
			var tanggal	= $('#tanggal').val();		
			var qty  	= $('.qty').val();		

			var data, xhr;
			if(lokasi ==''){
					swal("Warning", "Lokasi Tidak Boleh Kosong :)", "error");
					return false;
			}else if(tanggal ==''){
					swal("Warning", "Tanggal kirim Tidak Boleh Kosong :)", "error");
					return false;
			}else if(qty ==''){
					swal("Warning", "QTY kirim Tidak Boleh Kosong :)", "error");
					return false;
			}else{
				
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
						var baseurl=siteurl+'wt_delivery_order/SavePlanning';
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
									window.location.href = base_url + 'wt_delivery_order/spk_delivery';
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

		}
		
		});
		
});


function GetTop(){ 
		var top	= $('#top').val();
		$.ajax({
            type:"GET",
            url:siteurl+'wt_delivery_order/GetTop',
            data:"top="+top,
            success:function(html){
               $("#list_top").append(html);
            }
        });
}


function HitungTotal(id){
	    var qty=$('#used_qty_delivery_'+id).val().split(",").join("");
		var qtyplan=$('#used_qty_plan_'+id).val().split(",").join("");
		var qtyso=$('#used_qty_so_'+id).val().split(",").join("");
		var harga=$('#used_harga_satuan_'+id).val().split(",").join("");
		var diskon=$('#used_diskon_'+id).val().split(",").join("");
		var freight=$('#used_freight_cost_'+id).val().split(",").join("");

		
		 var totalplan = getNum(qty) + getNum(qtyplan);

		if (totalplan > qtyso) {
				swal({
					title: "Warning!",
					text: "Planning Melebihi Qty SO!",
					type: "warning",
					timer: 3000
				});
				
				$('#used_qty_delivery_'+id).val(0);
				
				return false;
		}else 
		{
		
		
		var totalBerat = getNum(qty) * getNum(harga);

		

		var nilai_diskon = (getNum(diskon) * getNum(totalBerat))/100;
		var total_harga =  getNum(totalBerat) - getNum(nilai_diskon)+getNum(freight);

		

		
		$('#used_total_harga_'+id).val(number_format(total_harga));	
		$('#used_nilai_diskon_'+id).val(number_format(nilai_diskon));	
			


		

		totalBalanced();
		
		}
		

		
			
		}


		
		

		function totalBalanced(){
		
		var SUMx = 0;
		$(".total" ).each(function() {
			SUMx += Number($(this).val().split(",").join(""));
		});
		
		
		$('.totalproduk').val(number_format(SUMx));

		$('#grandtotal').val(number_format(SUMx));	

		hitungPpn();

		
		}


		function hitungPpn(){
		var total =$('.totalproduk').val().split(",").join("");
		var ppn   =$('#ppn').val();	
	
		var   nilai_ppn  = (getNum(total) * getNum(ppn))/100;
		var   grand_total =  getNum(total) + getNum(nilai_ppn);

		
		$('#totalppn').val(number_format(nilai_ppn));		
		$('#grandtotal').val(number_format(grand_total));		

		
		}


		function HitungLoss(id){
	    var qty=$('#used_qty_'+id).val();
		var stok=$('#used_stok_tersedia_'+id).val();
		
		
		var totalstok      = getNum(qty) + getNum(stok);
		var totalselisih   = getNum(stok) - getNum(qty);
		var total_loss     =  getNum(totalstok) + getNum(totalselisih);
		var loss_nilai     = getNum(totalselisih) * -1;

		if (totalselisih >= 0)
		{
			var loss = 0;

		}
		else
		{
			var loss = loss_nilai;
		}

		
		if(order_sts=='ind')
		{
			$('#used_potensial_loss_'+id).val('0');		
		}else{
			$('#used_potensial_loss_'+id).val(number_format(loss));		
		}	
					
		}

		
			
		function getNum(val) 
		{
        if (isNaN(val) || val == '') {
            return 0;
        }
        return parseFloat(val);
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



</script>