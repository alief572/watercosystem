<?php
$ENABLE_ADD     = has_permission('Planning_Delivery.Add');
$ENABLE_MANAGE  = has_permission('Planning_Delivery.Manage');
$ENABLE_VIEW    = has_permission('Planning_Delivery.View');
$ENABLE_DELETE  = has_permission('Planning_Delivery.Delete');

foreach ($results['header'] as $hd){
	
	$id_customer=$hd->id_customer;
	
	$lok = $this->db->query("SELECT * FROM master_customers WHERE id_customer='$id_customer'")->row();
	
	if($hd->location ==''){
		$lokasi = $lok->address_office;
	}
	else{
		$lokasi =$hd->location; 
	}
	// print_r($lokasi);
	// exit;
	
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
					<textarea class="form-control" id="location" name="location"><?= $lokasi ?></textarea>
                   <!-- <input type="text" class="form-control" id="location" value="<?= $hd->location?>" name="location" placeholder="Lokasi">-->
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
        <?php } ?>
		<div class="col-sm-12">
			<div class="col-sm-12">
				<div class="form-group row" >
					<table class='table table-bordered table-striped'>
						<thead>
							<tr class='bg-blue'>
								<th width='3%'>No</th>
								<th width='20%'>Nama Produk</th>
								<th width='4%'>Qty <br> SO</th>
								<th width='4%'>Stok <br> Tersedia</th>
								<th width='4%'>Qty <br> Delivery</th>
								<th width='7%'>Request<br> Delivery</th>
								<th width='7%'>Schedule</th>
								<th width='4%'>Qty Terkirim</th>
								<th width='7%'>Metode Kirim</th>
								<th width='10%'>Keterangan Kirim</th>
							</tr>
						</thead>
						<tbody id="list_spk">
						<?php $loop=0;
						$do_method = $this->db->query("SELECT info from ms_generate where tipe='do_method'")->result();
						$do_info = $this->db->query("SELECT info, info2 from ms_generate where tipe='do_info'")->result();
						foreach ($results['detail'] as $dt_spk){$loop++; 
							$material = $this->db->query("SELECT a.* FROM ms_inventory_category3 as a where a.id_category3='".$dt_spk->id_category3."' ")->result();
							
							$sisa =$dt_spk->qty_so - $dt_spk->qty_delivery;
							$banding = $dt_spk->qty_so - ($dt_spk->qty_delivery + $dt_spk->qty_terkirim);
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
								<td id='qty_so_$loop'><input type='text' class='form-control input-sm' id='used_qty_so_$loop' required name='qty_so[]' value='$dt_spk->qty_so' readonly tabindex='-1'>
								<input type='hidden' class='form-control input-sm' id='used_qty_banding_$loop' required name='qty_banding[]' data-no='$loop' value='$banding' readonly tabindex='-1'>
								</td>
								<td id='stok_tersedia_$loop'><input type='text' value='$dt_spk->stok_tersedia' class='form-control input-sm' id='used_stok_tersedia_$loop' required name='stok_tersedia[]' readonly tabindex='-1'></td>
								<td id='qty_delivery_$loop'><input type='text' data-no='$loop' value='$sisa' class='form-control input-sm' id='used_qty_delivery_$loop' required name='qty_delivery[]' onBlur='cariselisih($loop)'></td>
								<td id='tgl_delivery_$loop'><input type='date' class='form-control input-sm' id='used_tgl_delivery_$loop' required name='tgl_delivery[]' value='$dt_spk->tgl_delivery' readonly tabindex='-1'></td>
								<td id='schedule_$loop'><input type='date' class='form-control input-sm' id='used_schedule_$loop' required name='schedule[]' value='$dt_spk->schedule'></td>
								<td id='qty_terkirim_$loop'><input type='text' value='$dt_spk->qty_terkirim' class='form-control input-sm' id='used_qty_terkirim_$loop' required name='qty_terkirim[]' readonly tabindex='-1'></td>

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
					</table>
				</div>
			</div>
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

	function cariselisih(no){
		    var banding	= $('#used_qty_banding_'+no).val();		
		    var sisa	= $('#used_qty_delivery_'+no).val();	

		    if(banding < sisa ){
					swal("Warning", "Qty Planning tidak boleh melebihi Qty SO)", "error");
					return false;
			}
	}
	
	//$('#input-kendaraan').hide();
	var base_url			= '<?php echo base_url(); ?>';
	var active_controller	= '<?php echo($this->uri->segment(1)); ?>';
	$(document).ready(function(){	
			var max_fields2      = 10; //maximum input boxes allowed
			var wrapper2         = $(".input_fields_wrap2"); //Fields wrapper
			var add_button2      = $(".add_field_button2"); //Add button ID		

			$('.select').select2({
				width: '100%'
			});
	$('#simpan-com').click(function(e){
			e.preventDefault();
			var no = $(this).data("no");
			var lokasi	= $('#lokasi').val();		
					
			var data, xhr;
			if(lokasi ==''){
					swal("Warning", "Lokasi Tidak Boleh Kosong :)", "error");
					return false;
			}
			else{
				
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

</script>