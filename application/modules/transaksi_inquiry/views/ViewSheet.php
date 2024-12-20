<?php
    $ENABLE_ADD     = has_permission('Trans_inquiry.Add');
    $ENABLE_MANAGE  = has_permission('Trans_inquiry.Manage');
    $ENABLE_VIEW    = has_permission('Trans_inquiry.View');
    $ENABLE_DELETE  = has_permission('Trans_inquiry.Delete');
 foreach ($results['ink'] as $ink){}
?>

 <div class="box box-primary">
    <div class="box-body">
		<form id="detail-form" method="post">
			<div class="col-sm-12">
				<div class="input_fields_wrap2">
			<div class="row">
		<div class="col-sm-12">
		<div class="col-md-12">
			<div class="form-group row" align="center">
				<h4><label>Detail Produk</label></h4>
			</div>
		</div>
		</div>
						<div class="col-sm-12">
		<div class="col-sm-6">
		<div class="form-group row">
			<div class="col-md-4">
				<label for="customer">Id Detail CRCL</label>
			</div>
			<div class="col-md-8">
				<input type="text" class="form-control" value="<?= $ink->id_surat_crcl ?>" readonly id="id_surat_CRCL" required name="id_surat_CRCL" placeholder="Id Surat CRCL">
			</div>
		</div>
		</div>
		</div>
		<div class="col-sm-12">
		<div class="col-sm-6">
		<div class="form-group row">
			<div class="col-md-4">
				<label for="customer">Bentuk</label>
			</div>
			<div class="col-md-8" hidden>
			<input type="text" class="form-control" id="id_dt_inquery"  value ="<?= $ink->id_dt_inquery ?>" required name="id_dt_inquery" readonly placeholder="No.CRCL">
			<input type="text" class="form-control" id="old_image_labels"  value ="<?= $ink->image_labels ?>" required name="old_image_labels" readonly placeholder="No.CRCL">
			<input type="text" class="form-control" id="old_image_packing"  value ="<?= $ink->image_packing ?>" required name="old_image_packing" readonly placeholder="No.CRCL">
				<input type="text" class="form-control" id="no_inquiry"  value="<?= $ink->no_inquery ?>" required name="no_inquiry" readonly placeholder="No.CRCL">
				<input type="text" class="form-control" id="id_bentuk"  value ="B2000002" required name="id_bentuk" readonly placeholder="No.CRCL">
			</div>
			<div class="col-md-8">
				<input type="text" class="form-control" id="nama_bentuk"  value ="SHEET" required name="nama_bentuk" readonly placeholder="No.CRCL">
			</div>
		</div>
		</div>
		<div class="col-sm-6">
		<div class="form-group row">
			<div class="col-md-4">
				<label for="customer">Produk</label>
			</div>
			<div class="col-md-8">
				<select id="id_category3" disabled name="id_category3" class="form-control select" onchange="caridensity()"  required>
						<option value="">--Pilih--</option>
							<?php foreach ($results['material'] as $material){
							$select = $ink->id_category3 == $material->id_category3 ? 'selected' : '';
								?>
						<option value="<?= $material->id_category3?>" <?= $select ?>><?= ucfirst(strtolower($material->nama_type))?>-<?= ucfirst(strtolower($material->nama))?>-<?= ucfirst(strtolower($material->hardness))?>-<?= ucfirst(strtolower($material->thickness))?></option>
							<?php } ?>
					</select>
			</div>
		</div>
		</div>
		</div>
		<div class="col-sm-12" id='tempat_density'>
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="id_category_supplier">Thickness</label>
				</div>
				<div class="col-md-8">
				<input type="text" class="form-control" id="thickness" value="<?= $ink->thickness?>"  readonly required name="thickness">
				</div>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group row" >
				<div class="col-md-4">
					<label for="id_category_supplier">Density</label>
				</div>
				<div class="col-md-8">
				<input type="text" class="form-control" id="density" value="<?= $ink->density?>" readonly required name="density">
				</div>
			</div>
		</div>
		</div>
		<div class="col-sm-12">
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="id_category_supplier">Width</label>
				</div>
				<div class="col-md-8">
				<input type="number" class="form-control" disabled id="width" required value="<?= $ink->dimensi1?>"  name="width" onkeyup="hitungmasa()">
				</div>
			</div>
		</div>
		<div class="col-sm-6">
					<div class="form-group row" >
				<div class="col-md-4">
					<label for="id_category_supplier">Length</label>
				</div>
				<div class="col-md-8">
				<input type="number" class="form-control" disabled id="panjang" value="<?= $ink->dimensi2?>" required name="panjang"  onkeyup="hitungmasa()">
				</div>
			</div>
		</div>
		</div>
		<div class="col-sm-12">
		<div class="col-sm-6">
			<div class="form-group row" id="tempat_berat">
				<div class="col-md-4">
					<label for="id_category_supplier">Weight/sheet</label>
				</div>
				<div class="col-md-4">
				<input type="number" class="form-control" disabled id="berat_produk" value="<?= $ink->berat_produk?>" required  name="berat_produk">
				</div>
				<div class="col-md-4">
				<input type="number" class="form-control" disabled id="berat_produk_max" value="<?= $ink->berat_produk_max?>" required  name="berat_produk_max">
				</div>
			</div>

		</div>
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="id_category_supplier">Forecast / Month (PCS/Kg)</label>
				</div>
				<div class="col-md-8">
				<input type="number" class="form-control" disabled value="<?= $ink->rerata?>"  id="rerata" required name="rerata">
				</div>
			</div>
		</div>
		</div>
		<div class="col-sm-12">
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="master_sample">Master Sample</label>
				</div>
				<div class="col-md-8">
				<select id="master_sample" name="master_sample" disabled class="form-control select"  required>
						<?php if($ink->master_sample=="No"){?>
						<option value="">--Pilih--</option>
						<option selected value="No">No</option>
						<option value="Yes">Yes</option>
						<?php }else{?>
						<option value="">--Pilih--</option>
						<option value="No">No</option>
						<option selected value="Yes">Yes</option>
						<?php }?>
				</select>
				</div>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group row" >
			<div class="col-md-4">
					<label for="id_category_supplier">Mill Sheet</label>
				</div>
				<div class="col-md-8">
				<select id="mill_sheet" name="mill_sheet" disabled class="form-control select"  required>
						<?php if($ink->mill_sheet=="No"){?>
						<option value="">--Pilih--</option>
						<option selected value="No">No</option>
						<option value="Yes">Yes</option>
						<?php }else{?>
						<option value="">--Pilih--</option>
						<option value="No">No</option>
						<option selected value="Yes">Yes</option>
						<?php }?>
				</select>
				</div>
			</div>
		</div>
		</div>
		<div class="col-sm-12">
		<div class="col-md-12">
			<div class="form-group row" align="center">
				<h4><label>Toleransi</label></h4>
			</div>
		</div>
		</div>
		<div class="col-sm-12">
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="master_sample">Toleransi Thickness</label>
				</div>
				<div class="col-md-4">
				<input type="text" class="form-control" disabled id="toleransi1max" value="<?= $ink->toleransi1max?>"  required name="toleransi1max" placeholder="Max">
				</div>
				<div class="col-md-4">
				<input type="text" class="form-control" disabled id="toleransi1min" value="<?= $ink->toleransi1min?>"  required name="toleransi1min" placeholder="Min">
				</div>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group row" >
			<div class="col-md-4">
					<label for="id_category_supplier">Toleransi Width</label>
				</div>
				<div class="col-md-4">
				<input type="text" class="form-control"disabled id="toleransi2max" value="<?= $ink->toleransi2max?>"  required name="toleransi2max"placeholder="Max" >
				</div>
				<div class="col-md-4">
				<input type="text" class="form-control" disabled id="toleransi2min" value="<?= $ink->toleransi2min?>"  required name="toleransi2min"placeholder="Min" >
				</div>
			</div>
		</div>
		</div>
		<div class="col-sm-12">
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="master_sample">Burry</label>
				</div>
				<div class="col-md-8">
				<input type="text" class="form-control" disabled id="burry" value="<?= $ink->burry?>"  required name="burry" >
				</div>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="master_sample">Apperace</label>
				</div>
				<div class="col-md-8">
				<input type="text" class="form-control" disabled id="apperance" value="<?= $ink->apperance?>"  required name="apperance" placeholder="Max">
				</div>
			</div>
		</div>
		</div>

		</br>
		<div class="col-sm-12">
		<div class="col-md-12">
			<div class="form-group row" align="center">
				<h4><label>Label Dan Packing</label></h4>
			</div>
		</div>
		</div>
		<div class="col-sm-12">
		<div class="col-sm-6">
			<div class="form-group row" >
			<div class="col-md-4">
					<label for="id_category_supplier">Label</label>
				</div>
				<div class="col-md-8">
				<select id="labels" name="labels" disabled class="form-control select"  required>
											<?php if($ink->labels=="Metalsindo Format"){?>
						<option value="">--Pilih--</option>
						<option selected value="Metalsindo Format">Metalsindo Format</option>
						<option value="Customer Format">Customer Format</option>
					<?php }else{?>
						<option value="">--Pilih--</option>
						<option value="Metalsindo Format">Metalsindo Format</option>
						<option selected value="Customer Format">Customer Format</option>
					<?php }?>
				</select>
				</div>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group row" >
			<div class="col-md-4">
					<label for="id_category_supplier">Packing</label>
				</div>
				<div class="col-md-8">
				<select id="packing" name="packing" disabled class="form-control select"  required>
											<?php if($ink->packing=="Metalsindo Format"){?>
						<option value="">--Pilih--</option>
						<option selected value="Metalsindo Format">Metalsindo Format</option>
						<option value="Customer Format">Customer Format</option>
					<?php }else{?>
						<option value="">--Pilih--</option>
						<option value="Metalsindo Format">Metalsindo Format</option>
						<option selected value="Customer Format">Customer Format</option>
					<?php }?>
				</select>
				</div>
			</div>
		</div>
		</div>
		<div class="col-sm-12">
		<div class="col-sm-6">
			<div class="form-group row" >
			<div class="col-md-4">
					<label for="id_category_supplier">Label Picture</label>
				</div>
				<div class="col-md-8">

				</div>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group row" >
			<div class="col-md-4">
					<label for="id_category_supplier">Packing Picture</label>
				</div>
				<div class="col-md-8">

				</div>
			</div>
		</div>
		</div>
						<div class='col-sm-12'>
		<div class='form-group row'>
			<center>
		<a class="btn btn-success btn-sm" href="<?= base_url('/transaksi_inquiry/PrintSheet/'.$ink->id_dt_inquery) ?>" target="_blank" title="Edit">Cetak</a>
			</center>
				 </div>
			</div>
			</div>
			<center>
		
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

		$('#add-deliver').click(function(){
			var jumlah	=$('#list_delivery').find('tr').length;
			if(jumlah==0 || jumlah==null){
				var ada		= 0;
				var loop	= 1;
			}else{
				var nilai		= $('#list_delivery tr:last').attr('id');
				var jum1		= nilai.split('_');
				var loop		= parseInt(jum1[1])+1; 
			}
			Template	='<tr id="tr_'+loop+'">';
			Template	+='<td align="left">'+loop+'</td>';
			Template	+='<td align="left">';
					Template	+='<input type="date" class="form-control input-sm" name="data1['+loop+'][tgl_pengiriman]" id="data1_'+loop+'_tgl_pengiriman" label="FALSE" div="FALSE">';
			Template	+='</td>';
			Template	+='<td align="left">';
					Template	+='<input type="time" class="form-control input-sm" name="data1['+loop+'][waktu_pengiriman]" id="data1_'+loop+'_waktu_pengiriman" label="FALSE" div="FALSE">';
			Template	+='</td>';
			Template	+='<td align="left">';
					Template	+='<input type="number" class="form-control input-sm" name="data1['+loop+'][qty_pengiriman]" id="data1_'+loop+'_qty_pengiriman" label="FALSE" div="FALSE">';
			Template	+='</td>';
			Template	+='<td align="center"><button type="button" class="btn btn-sm btn-danger" title="Hapus Data" data-role="qtip" onClick="return DelItem('+loop+');"><i class="fa fa-trash-o"></i></button></td>';
			Template	+='</tr>';
			$('#list_delivery').append(Template);
			$('input[data-role="tglbayar"]').datepicker({
				format: 'dd-mm-yyyy',
				autoclose: true			
			});
			});

	$('#simpan-com').click(function(e){
			e.preventDefault();
			var deskripsi	= $('#deskripsi').val();
			var image_labels	= $('#image_labels').val();
			var image_packing	= $('#image_packing').val();
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
						var formData 	=new FormData($('#detail-form')[0]);
						var baseurl=siteurl+'transaksi_inquiry/SaveEditSheet';
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
									window.location.href = base_url + active_controller +'/detail/'+data.code;
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
	function caridensity(){
        var id_category3=$("#id_category3").val();
		 $.ajax({
            type:"GET",
            url:siteurl+'transaksi_inquiry/cari_densitySheet',
            data:"id_category3="+id_category3,
            success:function(html){
               $("#tempat_density").html(html);
            }
        });
    }

	function hitungmasa(){
        var thickness=$("#thickness").val();
		var density=$("#density").val();
		var panjang=$("#panjang").val();
		var width=$("#width").val();
		 $.ajax({
            type:"GET",
            url:siteurl+'transaksi_inquiry/hitung_beratsheet',
            data:"thickness="+thickness+"&density="+density+"&width="+width+"&panjang="+panjang,
            success:function(html){
               $("#tempat_berat").html(html);
            }
        });
    }
	function jumlahberat(){
        var berat_produk=$("#berat_produk").val();
		var qty_order=$("#qty_order").val();
		 var id_category3=$("#id_category3").val();
		 $.ajax({
            type:"GET",
            url:siteurl+'transaksi_inquiry/JumlahBeratRoll',
            data:"berat_produk="+berat_produk+"&qty_order="+qty_order,
            success:function(html){
               $("#jumlah_berat").html(html);
            }
        });    
		$.ajax({
            type:"GET",
            url:siteurl+'transaksi_inquiry/hitungharga',
            data:"id_category3="+id_category3+"&berat_produk="+berat_produk+"&qty_order="+qty_order,
            success:function(html){
               $("#form_pricelist").html(html);
            }
        });
    }
function DelItem(id){
		$('#list_delivery #tr_'+id).remove();
		
	}
	
	
	
</script>