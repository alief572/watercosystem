<?php
    $ENABLE_ADD     = has_permission('Trans_inquiry.Add');
    $ENABLE_MANAGE  = has_permission('Trans_inquiry.Manage');
    $ENABLE_VIEW    = has_permission('Trans_inquiry.View');
    $ENABLE_DELETE  = has_permission('Trans_inquiry.Delete');
	$tanggal = date('Y-m-d');
			foreach ($results['tr_spk'] as $tr_spk){
	}	
?>

 <div class="box box-primary">
    <div class="box-body">
		<form id="data-form" method="post">
			<div class="col-sm-12">
				<div class="input_fields_wrap2">
			<div class="row">
		<center><label for="customer" ><h3>Penawaran Shearing</h3></label></center>
		<div class="col-sm-12">
		<div class="col-sm-6">
		<div class="form-group row">
			<div class="col-md-4">
				<label for="customer">NO.SPK</label>
			</div>
			<div class="col-md-8" hidden>
				<input type="text" class="form-control" id="id_spkmarketing" disabled value="<?= $tr_spk->id_spkmarketing ?>" required name="id_spkmarketing" readonly placeholder="No.CRCL">
			</div>
			<div class="col-md-8">
				<input type="text" class="form-control" id="no_surat" disabled value="<?= $tr_spk->no_surat ?>"   required name="no_surat" readonly placeholder="No.SPK">
			</div>
		</div>
		</div>
		<div class="col-sm-6">
		<div class="form-group row">
			<div class="col-md-4">
				<label for="customer">Tanggal</label>
			</div>
			<div class="col-md-8">
				<input type="date" class="form-control" id="tgl_penawaran" disabled value="<?= $tr_spk->tgl_spk_marketing ?>" onkeyup required name="tgl_penawaran" readonly >
			</div>
		</div>
		</div>
		</div>
		<div class="col-sm-12">
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="no_penawaran">No. Penawaran</label>
				</div>
				<div class="col-md-8">
					<select id="no_penawaran" name="no_penawaran" disabled class="form-control select" onchange="get_produk()" required>
						<option value="">--Pilih--</option>
							<?php foreach ($results['penawaran'] as $penawaran){
								$select = $tr_spk->no_penawaran == $penawaran->no_penawaran? 'selected' : '';?>
						<option value="<?= $penawaran->no_penawaran?>" <?= $select ?>><?= ucfirst(strtolower($penawaran->no_surat))?></option>
							<?php } ?>
					</select>
				</div>
			</div>
		</div>
		<div class="col-sm-6">
		<div class="form-group row" id="slot_customer">
			<div class="col-md-4">
				<label for="customer">Customer</label>
			</div>
			<div class="col-md-8">
				<input type="text" class="form-control"  disabled value = '<?= $tr_spk->nama_customer ?>' id="nama_customer" onkeyup required name="nama_customer" readonly >
			</div>
			<div class="col-md-8" hidden>
				<input type="text" class="form-control" disabled value = '<?= $tr_spk->id_customer ?>' id="id_customer" onkeyup required name="id_customer" readonly >
			</div>
		</div>
		</div>
		
		</div>
		

		<div class="col-sm-12">
		<div class="form-group row" >
			<table class='table table-bordered table-striped'>
			<thead>
			<tr class='bg-blue'>
			<th hidden>Id dt penawaran</th>
			<th>Alloy No</th>
			<th>Thickness</th>
			<th>Width</th>
			<th>Harga Penawaran</th>
			<th>Harga Deal / Kg</th>
			<th>Qty</th>
			<th>Weight / Unit</th>
			<th>Total Wight<Total weight/th>
			<th>Total Harga</th>
			<th>Delivery Date</th>
			<th hidden>CRCL</th>
			<th>Deal</th>
			</tr>
			</thead>
			<tbody id="list_penawaran_slot">
			<?php $loop=0;
		foreach($results['dtspk'] as $dt){
			$loop++;
		echo "
			<tr id='tabel_penawaran_$loop'>
			<th hidden><input type='text' class='form-control'  disabled value='$dt->id_child_penawaran' readonly id='dp_id_child_penawaran_$loop' required name='dp[$loop][id_child_penawaran]'></th>
			<th><input type='text' class='form-control' disabled value='$dt->id_material' readonly id='dp_idmaterial_$loop' required name='dp[$loop][idmaterial]'></th>
			<th><input type='text' class='form-control' disabled value='$dt->thickness' readonly id='dp_thickness_$loop' required name='dp[$loop][thickness]'></th>
			<th><input type='text' class='form-control' disabled value='$dt->width' readonly id='dp_width_$loop' required name='dp[$loop][width]'></th>
			<th><input type='text' class='form-control' disabled value='$dt->harga_penawaran' readonly id='dp_hgpenwaran_$loop' required name='dp[$loop][hgpenaaran]'></th>
			<th><input type='text' class='form-control' disabled value='$dt->harga_deal' onkeyup='return AksiDetail($loop);' id='dp_hgdeal_$loop' required name='dp[$loop][hgdeal]'></th>
			<th><input type='text' class='form-control' disabled value='$dt->qty_produk' onkeyup='return AksiDetail($loop);' id='dp_qty_$loop' required name='dp[$loop][qty]'></th>
			<th><input type='text' class='form-control' disabled value='$dt->weight' onkeyup='return AksiDetail($loop);'id='dp_weight_$loop' required name='dp[$loop][weight]'></th>
			<th id='total_weight_$loop'><input type='text' disabled value='$dt->total_weight' class='form-control' value='$jcc' readonly id='dp_twight_$loop' required name='dp[$loop][twight]'></th>
			<th id='total_harga_$loop'><input type='text' disabled value='$dt->total_harga' class='form-control' value='$sp' readonly id='dp_tharga_$loop' required name='dp[$loop][tharga]'></th>
			<th><input type='date' class='form-control' disabled id='dp_ddate_$loop' data-role='qtip' onkeyup='return HitungPisau($loop);' required name='dp[$loop][ddate]'></th>";
		if($dt->deal == '1'){
			echo"<th><input type='checkbox' value='1' radonly checked id='dp_deal_$loop' required name='dp[$loop][deal]'></th>";
			}
		else{
			echo"<th><input type='checkbox' value='1' readonly id='dp_deal_$loop' required name='dp[$loop][deal]'></th>";
			}
		echo"</tr>";
			};?>
			</tbody>
			</table>
		</div>
			</div>
				 </div>
			</div>
		</form>		  
	</div>
</div>	
	
				  
				  
				  
<script type="text/javascript">
	//$('#input-kendaraan').hide();
	var base_url			= '<?php echo base_url(); ?>';
	var active_controller	= '<?php echo($this->uri->segment(1)); ?>';
	$(document).ready(function(){	
			var max_fields2      = 10; //maximum input boxes allowed
			var wrapper2         = $(".input_fields_wrap2"); //Fields wrapper
			var add_button2      = $(".add_field_button2"); //Add button ID			
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
						var baseurl=siteurl+'spk_marketing/SaveEditHeader';
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
	function get_produk(){ 
        var no_penawaran=$("#no_penawaran").val();
		
		$.ajax({
            type:"GET",
            url:siteurl+'spk_marketing/GetCustomer',
            data:"no_penawaran="+no_penawaran,
            success:function(html){
               $("#slot_customer").html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'spk_marketing/GetPenawaran',
            data:"no_penawaran="+no_penawaran,
            success:function(html){
               $("#list_penawaran_slot").html(html);
            }
        });
    }
	function get_lebar(){ 
        var id_produk=$("#id_produk").val();
		var lebar_coil=$("#lebar_coil").val();
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_shearing/GetStock',
            data:"id_produk="+id_produk+"&lebar_coil="+lebar_coil,
            success:function(html){
               $("#stock_slot").html(html);
            }
        });
    }
	function AksiDetail(id){
	    var hgdeal=$('#dp_hgdeal_'+id).val();
		var qty=$('#dp_qty_'+id).val();
		var weight=$('#dp_weight_'+id).val();
		$.ajax({
            type:"GET",
            url:siteurl+'spk_marketing/totalw',
            data:"hgdeal="+hgdeal+"&qty="+qty+"&weight="+weight+"&id="+id,
            success:function(html){
               $('#total_weight_'+id).html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'spk_marketing/totalhg',
            data:"hgdeal="+hgdeal+"&qty="+qty+"&weight="+weight+"&id="+id,
            success:function(html){
               $('#total_harga_'+id).html(html);
            }
        });
	}
	function HitungPisau(id){
	    var qty=$('#stok_qty_'+id).val();
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_shearing/HitungPisau',
            data:"qty="+qty+"&id="+id,
            success:function(html){
               $('#pisau_'+id).html(html);
            }
        });
	}
	function TambahItem(id){
	   	var idstk=$('#stok_idstk_'+id).val();
		var lotno=$('#stok_lotno_'+id).val();
		var namamaterial=$('#stok_namamaterial_'+id).val();
		var weight=$('#stok_weight_'+id).val();
		var density=$('#stok_density_'+id).val();
		var hasilpanjang=$('#stok_hasilpanjang_'+id).val();
		var width=$('#stok_width_'+id).val();
		var lebarcc=$('#stok_lebarcc_'+id).val();
		var jumlahcc=$('#stok_jumlahcc_'+id).val();
		var sisapotongan=$('#stok_sisapotongan_'+id).val();
		var qtystock=$('#stok_qty_'+id).val();
		var jumlahpisau=$('#stok_jmlpisau_'+id).val();
		var total_panjang=$("#total_panjang").val();
		var jml_pisau=$("#jml_pisau").val();
		var jml_mother=$("#jml_mother").val();
		var total_berat=$("#total_berat").val();
		var thickness=$("#thickness").val();
		var qty=$("#qty").val();
		var jumlah	=$('#used_slot').find('tr').length;
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_shearing/HitungTPanjang',
            data:"hasilpanjang="+hasilpanjang+"&total_panjang="+total_panjang,
            success:function(html){
               $("#tpanjang_slot").html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_shearing/HitungJPisau',
            data:"jumlahpisau="+jumlahpisau+"&jml_pisau="+jml_pisau,
            success:function(html){
               $("#jpisau_slot").html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_shearing/HitungJmother',
            data:"jml_mother="+jml_mother,
            success:function(html){
               $("#mother_slot").html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_shearing/HitungTBerat',
           data:"hasilpanjang="+hasilpanjang+"&total_panjang="+total_panjang+"&thickness="+thickness+"&lebarcc="+lebarcc+"&density="+density,
            success:function(html){
               $("#tberat_slot").html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_shearing/GetUsed',
            data:"idstk="+idstk+"&lotno="+lotno+"&namamaterial="+namamaterial+"&jumlah="+jumlah+"&weight="+weight+"&density="+density+"&hasilpanjang="+hasilpanjang+"&width="+width+"&lebarcc="+lebarcc+"&jumlahcc="+jumlahcc+"&sisapotongan="+sisapotongan+"&qtystock="+qtystock+"&jumlahpisau="+jumlahpisau,
            success:function(html){
               $("#used_slot").append(html);
            }
        });
	}
	function get_properties(){
        var id_produk=$("#id_produk").val();
		var lebar_coil=$("#lebar_coil").val();
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_shearing/GetMaterial',
            data:"id_produk="+id_produk,
            success:function(html){
               $("#material_slot").html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_shearing/GetThickness',
            data:"id_produk="+id_produk,
            success:function(html){
               $("#thickness_slot").html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_shearing/GetDensity',
            data:"id_produk="+id_produk,
            success:function(html){
               $("#density_slot").html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_shearing/GetSurface',
            data:"id_produk="+id_produk,
            success:function(html){
               $("#surface_slot").html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_shearing/GetPotongan',
            data:"id_produk="+id_produk,
            success:function(html){
               $("#potongan_slot").html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_shearing/GetStock',
            data:"id_produk="+id_produk+"&lebar_coil="+lebar_coil,
            success:function(html){
               $("#stock_slot").html(html);
            }
        });

    }

function DelItem(id){
		$('#data_barang #tr_'+id).remove();
		
	}
	
	
	
</script>