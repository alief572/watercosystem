<?php
$ENABLE_ADD     = has_permission('Planning_Delivery.Add');
$ENABLE_MANAGE  = has_permission('Planning_Delivery.Manage');
$ENABLE_VIEW    = has_permission('Planning_Delivery.View');
$ENABLE_DELETE  = has_permission('Planning_Delivery.Delete');

foreach(@$headerso as $hdo => $hd){
	
        $id_customer=$hd->id_customer;
        
        $lok = $this->db->query("SELECT * FROM master_customers WHERE id_customer='$id_customer'")->row();
        
        if($hd->location ==''){
            $lokasi = $lok->address_office;
        }
        else{
            $lokasi =$hd->location; 
        }

}
?>
<div class="box box-primary">
    <div class="box-body"> 
		<form id="data-form" method="post">
			<div class="col-sm-12">
				<div class="input_fields_wrap2">
			<div class="row">
		<center><label for="customer" ><h3>SPK Delivery</h3></label></center>
		<div class="col-sm-12">
		    <div class="col-sm-6">
		        <div class="form-group row">
			        <div class="col-md-4">
				        <label for="customer">No.SPK Delivery</label>
			        </div>
			        <div class="col-md-8">
					 <input type="text" class="form-control" id="no_surat" required name="no_surat" readonly placeholder="No Surat" tabindex='-1'>                    
					 <input type="hidden" class="form-control" id="id_customer" required name="id_customer" value=<?= $hd->id_customer ?> placeholder="ID customer" tabindex='-1'>                    
			      
					</div>
		        </div>
		    </div>
		    <div class="col-sm-6">
		        <div class="form-group row">
			        <div class="col-md-4">
				        <label>Tanggal Kirim</label>
			        </div>
			        <div class="col-md-8">
                    <input type="date" class="form-control" id="tanggal"  name="tanggal" placeholder="Tanggal">
			        </div>
		        </div>
		    </div>		    
		</div>

        <div class="col-sm-12">
		    <div class="col-sm-6">
		        <div class="form-group row">
			        <div class="col-md-4">
				        <label for="customer">Location</label>
			        </div>
			        <div class="col-md-8">
                    <textarea class="form-control" id="location" name="location" readonly><?= $lokasi ?></textarea>
					</div>
		        </div>
		    </div>
		    <div class="col-sm-6">
		        <div class="form-group row">
			        <div class="col-md-4">
				        <label></label>
			        </div>
			        <div class="col-md-8">
                    
			        </div>
		        </div>
		    </div>		    
		</div>
		
		<div class="col-sm-12">
			<div class="col-sm-12">
				<div class="form-group row" >
					<table class='table table-bordered table-striped'>
						<thead>
							<tr class='bg-blue'>
								<th width='7%'>Plan Delivery</th>
								<th width='7%'>Nomor SO</th>
								<th width='15%'>Customer</th>
								<th width='7%' >Kode Produk</th>
								<th width='15%' >Produk</th>
								<th width='3%'>Qty<br> SPK</th>
								<th width='3%'> Delivery Check</th>
							</tr>
						</thead>
						<tbody id="list_spk">
                        <?php
                 if(@$getitemso){
                  $n=1;
                  foreach(@$getitemso as $kdo => $dt_spk){
                      $no=$n++;

                      $id_cust = $this->db->query("SELECT * FROM tr_sales_order WHERE no_so ='$dt_spk->no_so' ")->row();
                      $cust    = $this->db->query("SELECT * FROM master_customers WHERE id_customer ='$id_cust->id_customer' ")->row();
                      		
					 $idmaterial = $dt_spk->id_category3;
					 $media    = $this->db->query("SELECT * FROM ms_inventory_category3 WHERE id_category3 ='$idmaterial' ")->row();
					 $level1   =  $media->id_category1;

					 if($level1 =='LVL200020') {

						echo "
						<tr id='tr_$no'>
							<input type='hidden' class='form-control' 	value='$dt_spk->id_planning_delivery' 	 id='used_id_planning_delivery_$no' required name='dt[$no][id_planning_delivery]'>
							<input type='hidden' class='form-control' 	value='$dt_spk->id_so_detail' 	 id='used_id_so_$no' required name='dt[$no][id_so]'>
							<th ><input type='hidden' class='form-control' 	value='$dt_spk->schedule' 	 id='used_schedule_$no' required name='dt[$no][schedule]'></th>
							<th ><input type='hidden' class='form-control' 	value='$dt_spk->no_so' 	 id='used_no_so_$no' required name='dt[$no][no_so]'></th>
							<th><input type='hidden' class='form-control'  	   	value='$cust->name_customer' 	 id='used_namacustomer_$no' required name='dt[$no][namacustomer]'></th>
							<th ><input type='text' class='form-control' 		value='$dt_spk->id_category3'  	 id='used_id_category3_$no' required name='dt[$no][id_category3]'></th>
							<th ><input type='text' class='form-control' 		value='$dt_spk->nama_produk'  	 id='used_nama_produk_$no' required name='dt[$no][nama_produk]'></th>
							<th > <input type='text' class='form-control' 		value='$dt_spk->qty_so'	 				 id='used_qty_delivery_$no' required name='dt[$no][qty_delivery]'></th>
							<th><input type='checkbox'   														 id='used_kirim_$no'                 name='dt[$no][kirim]'></th>
														
						</tr>
						
						";
						

					 }
					 else{
					 
					  $countfiles = $dt_spk->qty_delivery;
						
					  for($loop1=0;$loop1<$countfiles;$loop1++){
						  $loop = $loop1+1;
						  
						//  $totalwidth += $dt_spk->weight;
						  
						  $i++; 

						  if($loop > 1){
							$type ='hidden';
						  }else{
							$type ='text';
						  }
						  
								echo "
								<tr id='tr_$i$loop'>
									<input type='hidden' class='form-control' 	value='$dt_spk->id_so_detail' 	 id='used_id_so_$i$loop' required name='dt[$i$loop][id_so]'>
									<input type='hidden' class='form-control' 	value='$dt_spk->id_planning_delivery' 	 id='used_id_planning_delivery_$i$loop' required name='dt[$i$loop][id_planning_delivery]'>
							
									</th>
									<th ><input type=$type class='form-control' 	value='$dt_spk->schedule' 	 id='used_schedule_$i$loop' required name='dt[$i$loop][schedule]'></th>
									<th ><input type=$type class='form-control' 	value='$dt_spk->no_so' 	 id='used_no_so_$i$loop' required name='dt[$i$loop][no_so]'></th>
									<th><input type=$type class='form-control'  	   	value='$cust->name_customer' 	 id='used_namacustomer_$i$loop' required name='dt[$i$loop][namacustomer]'></th>
									<th ><input type='text' class='form-control' 		value='$dt_spk->id_category3'  	 id='used_id_category3_$i$loop' required name='dt[$i$loop][id_category3]'></th>
									<th ><input type='text' class='form-control' 		value='$dt_spk->nama_produk'  	 id='used_nama_produk_$i$loop' required name='dt[$i$loop][nama_produk]'></th>
									<th > <input type='text' class='form-control' 		value='1' 		 				 id='used_qty_delivery_$i$loop' required name='dt[$i$loop][qty_delivery]'></th>
									<th><input type='checkbox'   														 id='used_kirim_$i$loop'                 name='dt[$i$loop][kirim]'></th>
																
								</tr>
								
								";
								
											
								} 

						}
				  	 } 

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
	//$('#input-kendaraan').hide();
	var base_url			= '<?=base_url(); ?>';
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
			var tanggal	= $('#tanggal').val();			
			var data, xhr;
			if(tanggal ==''){
					swal("Warning", "Tanggal Tidak Boleh Kosong :)", "error");
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
						var baseurl=siteurl+'wt_delivery_order/SaveSpkdelivery';
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