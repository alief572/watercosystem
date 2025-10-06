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
		<center><label for="customer" ><h3>SPK Produksi</h3></label></center>
		<div class="col-sm-12">
		<div class="col-sm-6">
		<div class="form-group row">
			<div class="col-md-4">
				<label for="customer">NO.SPK</label>
			</div>
			<div class="col-md-8" hidden>
				<input type="text" class="form-control" value = "<?= $tr_spk->id_spkproduksi?>" id="id_spkmarketing"  required name="id_spkmarketing" readonly placeholder="No.CRCL">
			</div>
			<div class="col-md-8">
				<input type="text" class="form-control" value = "<?= $tr_spk->no_surat ?>" id="no_surat"  required name="no_surat" readonly placeholder="No.SPK">
			</div>
		</div>
		</div>
		<div class="col-sm-6">
		<div class="form-group row">
			<div class="col-md-4">
				<label for="customer">Tanggal</label>
			</div>
			<div class="col-md-8">
				<input type="date" class="form-control" id="tgl_penawaran" value="<?= $tr_spk->tgl_spk_produksi ?>" onkeyup required name="tgl_penawaran" readonly >
			</div>
		</div>
		</div>
		</div>
		<div class="col-sm-12">

		<div class="col-sm-6">
		<div class="form-group row">
			<div class='col-md-4'>
				<label for='customer'>Material</label>
			</div>
			<div class="col-md-8">
					<select id="id_material" name="id_material" class="form-control select" onchange="Caristock()" required>
						<option value="">--Pilih--</option>
							<?php foreach ($results['material'] as $material){
								$select = $tr_spk->id_material == $material->id_category3 ? 'selected' : '';
								?>
						<option value="<?= $material->id_category3?>" <?= $select?> ><?= ucfirst(strtolower($material->nama_category2))?>-<?= ucfirst(strtolower($material->nama))?>-<?= ucfirst(strtolower($material->hardness))?>-<?= ucfirst(strtolower($material->thickness ))?></option>
							<?php } ?>
					</select>
			</div>
		</div>

		</div>
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="no_penawaran">Lot Number</label>
				</div>
				<div class="col-md-8" id='lotnumbe_slot'>
					<select id="id_stock" name="id_stock" class="form-control select" onchange="get_produk()" required>
						<option value="">--Pilih--</option>
						<?php
					$id_material = $tr_spk->id_material;
				$stok	= $this->db->query("SELECT * FROM stock_material WHERE id_category3 = '$id_material' AND id_gudang='1' ")->result();
				foreach($stok as $stok){
					$select = $tr_spk->id_stock == $stok->id_stock ? 'selected' : '';
					echo"<option value='$stok->id_stock' $select >$stok->lotno</option>";
				}
						?>
					</select>
				</div>
			</div>
		</div>
		</div>
		<div class="col-sm-12">
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="no_penawaran">Berat Coil</label>
				</div>
				<div class="col-md-8" id="slot_weight">
				<input type='number' class='form-control' id='weight' value="<?= $tr_spk->weight ?>" onkeyup required name='weight' readonly >
			</div>
			</div>
		</div>
		<div class="col-sm-6">
		<div class="form-group row">
			<div class="col-md-4">
				<label for="customer">Density</label>
			</div>
			<div class="col-md-8" id="slot_density">
				<input type='number' class='form-control' id='density' value="<?= $tr_spk->density ?>" onkeyup required name='density' readonly >
			</div>
		</div>
		</div>
		</div>
		<div class="col-sm-12">
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="no_penawaran">Thickness</label>
				</div>
				<div class="col-md-8" id="slot_thickness">
				<input type='number' class='form-control' id='thickness' value="<?= $tr_spk->thickness ?>" onkeyup required name='thickness' readonly >
			</div>
			</div>
		</div>
		<div class="col-sm-6">
		<div class="form-group row" id="slot_customer">
			<div class="col-md-4">
				<label for="customer">Panjang Mother Coil</label>
			</div>
			<div class="col-md-8" id="slot_panjang">
				<input type='number' class='form-control' id='panjang' value="<?= $tr_spk->panjang ?>" onkeyup required name='panjang' readonly >
			</div>
		</div>
		</div>
		</div>
		<div class="col-sm-12">
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="no_penawaran">Width Mother coil</label>
				</div>
			<div class="col-md-8" id="slot_width">
				<input type='number' class='form-control' id='width' value="<?= $tr_spk->width ?>" onkeyup required name='width' readonly >
			</div>
			</div>
		</div>
		<div class="col-sm-6" hidden>
			<div class="form-group row">
				<div class="col-md-4">
					<label for="no_penawaran">Lotno</label>
				</div>
			<div class="col-md-8" id="hiden_slot">
				<input type='text' class='form-control' id='lotno' value="<?= $tr_spk->lotno ?>" onkeyup required name='lotno' readonly >
				<input type='text' class='form-control' id='nama_material' value="<?= $tr_spk->nama_material ?>" onkeyup required name='nama_material' readonly >
			</div>
			</div>
		</div>
		</div>
		

		<div class="col-sm-12">
				<div class="form-group row">
		<button type='button' class='btn btn-sm btn-success' title='Ambil' id='tbh_ata' data-role='qtip' onClick='GetSpk();'><i class='fa fa-plus'></i>Add</button>

		</div>
		<div class="form-group row" >
			<table class='table table-bordered table-striped'>
			<thead>
			<tr class='bg-blue'>
			<th width='3%'>No</th>
			<th width='15%'>SPK Marketing</th>
			<th width='15%'>Customer</th>
			<th width='10%'>Nomor Alloy</th>
			<th width='5%'>Thickness</th>
			<th width='7%'>Width</th>
			<th width='7%'>Qty Coil</th>
			<th width='7%'>Weight / Coil</th>
			<th width='10%'>Total Wight<Total weight/th>
			<th width='7%'>Delivery Date</th>
			<th width='7%'>Aksi</th>
			</tr>
			</thead>
			<tbody id="list_spk">
			<?php $loop=0;
			foreach ($results['dt_spk'] as $dt_spk){$loop++; 
			$nosurat = $this->db->query("SELECT a.*, b.no_surat as no_surat FROM dt_spkmarketing as a INNER JOIN tr_spk_marketing as b ON a.id_spkmarketing = b.id_spkmarketing WHERE a.id_material='$id_material' ")->result();
			$cus = $this->db->query("SELECT * FROM master_customers WHERE id_customer='".$dt_spk->idcustomer."' ")->result();
		echo "
		<tr id='tr_$loop'>
			<th>$loop</th>
			<th><select id='used_no_surat_$loop' name='dt[$loop][no_surat]' readonly onchange='CariDetail($loop)' class='form-control' required>
			<option valu=''>-Pilih-</option>";
			foreach($nosurat as $nosurat){
				$select = $dt_spk->no_surat == $nosurat->id_dt_spkmarketing ? 'selected' : '';
			echo"<option value='$nosurat->id_dt_spkmarketing' $select>$nosurat->no_surat</option>";
			}
		echo"</select></th>
			<th hidden><input type='text' class='form-control' 	value='$dt_spk->idcustomer' 	readonly id='used_idcustomer_$loop' required name='dt[$loop][idcustomer]'></th>
			<th ><input type='text' class='form-control'  	   	value='".$cus[0]->name_customer."' 	readonly id='used_namacustomer_$loop' required name='dt[$loop][namacustomer]'></th>
			<th><input type='text' class='form-control' 		value='$dt_spk->nmmaterial'  	readonly id='used_nmmaterial_$loop' required name='dt[$loop][nmmaterial]'></th>
			<th><input type='text' class='form-control' 		value='$dt_spk->thickness' 		readonly id='used_thickness_$loop' required name='dt[$loop][thickness]'></th>
			<th><input type='text' class='form-control'   		value='$dt_spk->weight' 		readonly id='used_weight_$loop' required name='dt[$loop][weight]'></th>
			<th><input type='text' class='form-control'  		value='$dt_spk->qtycoil' 		readonly id='used_qtycoil_$loop' onkeyup='HitungTotalCoil($loop)' required name='dt[$loop][qtycoil]'></th>
			<th><input type='text' class='form-control'   		value='$dt_spk->width' 			readonly id='used_width_$loop' onkeyup='HitungTotalCoil($loop)' required name='dt[$loop][width]'></th>
			<th><input type='text' class='form-control'  		value='$dt_spk->totalwidth' 	readonly id='used_totalwidth_$loop' required name='dt[$loop][totalwidth]'></th>
			<th><input type='date' class='form-control'   		value='$dt_spk->delivery' 		readonly id='used_delivery_$loop' required name='dt[$loop][delivery]'></th>
			<th><button type='button' class='btn btn-sm btn-danger' title='Hapus Data' data-role='qtip' onClick='return CancelItem($loop);'><i class='fa fa-close'></i></button></th>
		</tr>
		";
			}
			?>
			</tbody>
			</table>
		</div>
			</div>
		<div class="col-sm-12">
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="no_penawaran">Lebar Pegangan</label>
				</div>
				<div class="col-md-8" id="slot_pegangan">
				<input type='number' class='form-control' id='lpegangan' value="<?= $tr_spk->lpegangan ?>" onkeyup required name='lpegangan' readonly >
			</div>
			</div>
		</div>
		</div>
		<div class="col-sm-12">
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="no_penawaran">Qty Coil</label>
				</div>
				<div class="col-md-8" id="slot_qcoil">
				<input type='number' class='form-control' id='qcoil' value="<?= $tr_spk->qcoil ?>" onkeyup required name='qcoil' readonly >
			</div>
			</div>
		</div>
		</div>
		<div class="col-sm-12">
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="no_penawaran">Jml Pisau</label>
				</div>
				<div class="col-md-8" id="slot_jpisau">
				<input type='number' class='form-control' id='jpisau' value="<?= $tr_spk->jpisau ?>" onkeyup required name='jpisau' readonly >
			</div>
			</div>
		</div>
		</div>
		<div class="col-sm-12">
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="no_penawaran">Sisa Potongan</label>
				</div>
				<div class="col-md-8" id="slot_sisa">
				<div hidden ><input type='number'  class='form-control' value="<?= $tr_spk->used ?>" id='used' onkeyup required name='used' readonly ></div>
				<input type='number' class='form-control' id='sisa' value="<?= $tr_spk->sisa ?>" onkeyup required name='sisa' readonly >
			</div>
			</div>
		</div>
		</div>
			<center>
		<button type="submit" class="btn btn-success btn-sm" name="save" id="simpan-com"><i class="fa fa-save"></i>Simpan</button>
		<a class="btn btn-danger btn-sm" href="<?= base_url('/spk_produksi/') ?>"  title="Edit">Kembali</a>
			</center>
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
						var baseurl=siteurl+'spk_produksi/SaveEditHeader';
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
        var id_stock=$("#id_stock").val();
		
		$.ajax({
            type:"GET",
            url:siteurl+'spk_produksi/GetMaterialName',
            data:"id_stock="+id_stock,
            success:function(html){
               $("#slot_material").html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'spk_produksi/GetMaterialWeight',
            data:"id_stock="+id_stock,
            success:function(html){
               $("#slot_weight").html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'spk_produksi/GetMaterialDensity',
            data:"id_stock="+id_stock,
            success:function(html){
               $("#slot_density").html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'spk_produksi/GetMaterialThickness',
            data:"id_stock="+id_stock,
            success:function(html){
               $("#slot_thickness").html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'spk_produksi/GetMaterialPanjang',
            data:"id_stock="+id_stock,
            success:function(html){
               $("#slot_panjang").html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'spk_produksi/GetSisaMaterial',
            data:"id_stock="+id_stock,
            success:function(html){
               $("#slot_sisa").html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'spk_produksi/GetMaterialWidth',
            data:"id_stock="+id_stock,
            success:function(html){
               $("#slot_width").html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'spk_produksi/GetMaterialHiden',
            data:"id_stock="+id_stock,
            success:function(html){
               $("#hiden_slot").html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'spk_produksi/GetPegangan',
            data:"id_stock="+id_stock,
            success:function(html){
               $("#slot_pegangan").html(html);
            }
        });
		
    }
	function GetSpk(){ 
		var jumlah	=$('#list_spk').find('tr').length;
		var id_stock=$("#id_stock").val();
		var thickness=$("#thickness").val();
		var nama_material=$("#nama_material").val();
		var id_material=$("#id_material").val();
		$.ajax({
            type:"GET",
            url:siteurl+'spk_produksi/GetSpk',
            data:"jumlah="+jumlah+"&id_stock="+id_stock+"&id_material="+id_material+"&thickness="+thickness+"&nama_material="+nama_material,
            success:function(html){
               $("#list_spk").append(html);
            }
        });
    }
	function CancelItem(id){
		var nmmaterial=$('#used_nmmaterial_'+id).val();
		var dtno_surat=$('#used_no_surat_'+id).val();
		var idcustomer=$('#used_idcustomer_'+id).val();
		var namacustomer=$('#used_namacustomer_'+id).val();
		var thickness=$('#used_thickness_'+id).val();
		var weight=$('#used_weight_'+id).val();
		var qtycoil=$('#used_qtycoil_'+id).val();
		var width=$('#used_width_'+id).val();
		var totalwidth=$('#used_totalwidth_'+id).val();
		var delivery=$('#used_delivery_'+id).val();
		var qcoil=$('#qcoil').val();
		var lpegangan=$('#lpegangan').val();
		var jpisau=$('#jpisau').val();
		var sisa=$('#sisa').val();
		var widthmother=$('#width').val();
		var used=$('#used').val();
		$.ajax({
            type:"GET",
            url:siteurl+'spk_produksi/MinusQtyCoil',
            data:"id="+id+"&used="+used+"&widthmother="+widthmother+"&qcoil="+qcoil+"&lpegangan="+lpegangan+"&jpisau="+jpisau+"&sisa="+sisa+"&nmmaterial="+nmmaterial+"&thickness="+thickness+"&weight="+weight+"&qtycoil="+qtycoil+"&width="+width+"&totalwidth="+totalwidth+"&delivery="+delivery,
            success:function(html){
               $("#slot_qcoil").html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'spk_produksi/MinusJPisau',
            data:"id="+id+"&used="+used+"&widthmother="+widthmother+"&qcoil="+qcoil+"&lpegangan="+lpegangan+"&jpisau="+jpisau+"&sisa="+sisa+"&nmmaterial="+nmmaterial+"&thickness="+thickness+"&weight="+weight+"&qtycoil="+qtycoil+"&width="+width+"&totalwidth="+totalwidth+"&delivery="+delivery,
            success:function(html){
               $("#slot_jpisau").html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'spk_produksi/MinusSisa',
            data:"id="+id+"&used="+used+"&widthmother="+widthmother+"&qcoil="+qcoil+"&lpegangan="+lpegangan+"&jpisau="+jpisau+"&sisa="+sisa+"&nmmaterial="+nmmaterial+"&thickness="+thickness+"&weight="+weight+"&qtycoil="+qtycoil+"&width="+width+"&totalwidth="+totalwidth+"&delivery="+delivery,
            success:function(html){
               $("#slot_sisa").html(html);
            }
        });

		$('#list_spk #tr_'+id).remove();
    }
function TambahItem(id){
		var nmmaterial=$('#used_nmmaterial_'+id).val();
		var dtno_surat=$('#used_no_surat_'+id).val();
		var idcustomer=$('#used_idcustomer_'+id).val();
		var namacustomer=$('#used_namacustomer_'+id).val();
		var thickness=$('#used_thickness_'+id).val();
		var weight=$('#used_weight_'+id).val();
		var qtycoil=$('#used_qtycoil_'+id).val();
		var width=$('#used_width_'+id).val();
		var totalwidth=$('#used_totalwidth_'+id).val();
		var delivery=$('#used_delivery_'+id).val();
		var id_material=$('#id_material').val();
		var qcoil=$('#qcoil').val();
		var lpegangan=$('#lpegangan').val();
		var jpisau=$('#jpisau').val();
		var sisa=$('#sisa').val();
		var widthmother=$('#width').val();
		var used=$('#used').val();
		$.ajax({
            type:"GET",
            url:siteurl+'spk_produksi/CariQtyCoil',
            data:"id="+id+"&used="+used+"&widthmother="+widthmother+"&qcoil="+qcoil+"&lpegangan="+lpegangan+"&jpisau="+jpisau+"&sisa="+sisa+"&nmmaterial="+nmmaterial+"&thickness="+thickness+"&weight="+weight+"&qtycoil="+qtycoil+"&width="+width+"&totalwidth="+totalwidth+"&delivery="+delivery,
            success:function(html){
               $("#slot_qcoil").html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'spk_produksi/CarijPisau',
            data:"id="+id+"&used="+used+"&widthmother="+widthmother+"&qcoil="+qcoil+"&lpegangan="+lpegangan+"&jpisau="+jpisau+"&sisa="+sisa+"&nmmaterial="+nmmaterial+"&thickness="+thickness+"&weight="+weight+"&qtycoil="+qtycoil+"&width="+width+"&totalwidth="+totalwidth+"&delivery="+delivery,
            success:function(html){
               $("#slot_jpisau").html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'spk_produksi/CariSisa',
            data:"id="+id+"&used="+used+"&widthmother="+widthmother+"&qcoil="+qcoil+"&lpegangan="+lpegangan+"&jpisau="+jpisau+"&sisa="+sisa+"&nmmaterial="+nmmaterial+"&thickness="+thickness+"&weight="+weight+"&qtycoil="+qtycoil+"&width="+width+"&totalwidth="+totalwidth+"&delivery="+delivery,
            success:function(html){
               $("#slot_sisa").html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'spk_produksi/LockSpk',
            data:"id="+id+"&used="+used+"&widthmother="+widthmother+"&id_material="+id_material+"&namacustomer="+namacustomer+"&idcustomer="+idcustomer+"&dtno_surat="+dtno_surat+"&qcoil="+qcoil+"&lpegangan="+lpegangan+"&jpisau="+jpisau+"&sisa="+sisa+"&nmmaterial="+nmmaterial+"&thickness="+thickness+"&weight="+weight+"&qtycoil="+qtycoil+"&width="+width+"&totalwidth="+totalwidth+"&delivery="+delivery,
            success:function(html){
               $('#list_spk #tr_'+id).html(html);
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
	function HitungTotalCoil(id){
	    var qtycoil=$('#used_qtycoil_'+id).val();
		var width=$('#used_width_'+id).val();
		$.ajax({
            type:"GET",
            url:siteurl+'spk_produksi/HitungTotalWidth',
            data:"qtycoil="+qtycoil+"&width="+width+"&id="+id,
            success:function(html){
               $('#twidth_'+id).html(html);
            }
        });
	}
	function Caristock(){
        var id_material=$("#id_material").val();
		$.ajax({
            type:"GET",
            url:siteurl+'spk_produksi/FindingStock',
            data:"id_material="+id_material,
            success:function(html){
               $("#lotnumbe_slot").html(html);
            }
        });

    }
	function CariDetail(id){
        var id_marketing=$('#used_no_surat_'+id).val();
		$.ajax({
            type:"GET",
            url:siteurl+'spk_produksi/CariIdCustomer',
            data:"id_marketing="+id_marketing+"&id="+id,
            success:function(html){
               $('#idcust_'+id).html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'spk_produksi/CariNamaCustomer',
            data:"id_marketing="+id_marketing+"&id="+id,
            success:function(html){
               $('#nmcust_'+id).html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'spk_produksi/CariW1material',
            data:"id_marketing="+id_marketing+"&id="+id,
            success:function(html){
               $('#weight_'+id).html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'spk_produksi/CariQrollmaterial',
            data:"id_marketing="+id_marketing+"&id="+id,
            success:function(html){
               $('#qtyproduk_'+id).html(html);
            }
        });
				$.ajax({
            type:"GET",
            url:siteurl+'spk_produksi/CariW2material',
            data:"id_marketing="+id_marketing+"&id="+id,
            success:function(html){
               $('#width_'+id).html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'spk_produksi/CariTW2material',
            data:"id_marketing="+id_marketing+"&id="+id,
            success:function(html){
               $('#twidth_'+id).html(html);
            }
        });
				$.ajax({
            type:"GET",
            url:siteurl+'spk_produksi/CariDelivermaterial',
            data:"id_marketing="+id_marketing+"&id="+id,
            success:function(html){
               $('#delivery_'+id).html(html);
            }
        });	

    }
	function get_properties(){
        var id_produk=$("#id_produk").val();
		var lebar_coil=$("#lebar_coil").val();
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

function HapusItem(id){
		$('#list_spk #tr_'+id).remove();
		
	}
	
	
	
</script>