<?php
    $ENABLE_ADD     = has_permission('Trans_inquiry.Add');
    $ENABLE_MANAGE  = has_permission('Trans_inquiry.Manage');
    $ENABLE_VIEW    = has_permission('Trans_inquiry.View');
    $ENABLE_DELETE  = has_permission('Trans_inquiry.Delete');
 foreach ($results['no_inquiry'] as $no_inquiry){}
?>

 <div class="box box-primary">
    <div class="box-body">
		<form id="detail-form" method="post">
			<div class="col-sm-12">
				<div class="input_fields_wrap2">
			<div class="row">
					<div class="col-sm-12">
		<div class="col-sm-6">
		<div class="form-group row">
			<div class="col-md-4">
				<label for="customer">Id Detail CRCL</label>
			</div>
			<div class="col-md-8">
				<input type="text" class="form-control" id="id_surat_CRCL" required name="id_surat_CRCL" placeholder="Id Detail CRCL">
			</div>
		</div>
		</div>
		<div class="col-sm-6">
		<div class="form-group row">
			<div class="col-md-4">
				<label for="customer">Nama Customer</label>
			</div>
			<div class="col-md-8">
				<input type="text" class="form-control" id="name_customer" value="<?= $results['cust'] ?>"  required name="name_customer" readonly placeholder="No.CRCL">
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
				<input type="text" class="form-control" id="no_inquiry"  value="<?= $no_inquiry->no_inquiry ?>" required name="no_inquiry" readonly placeholder="No.CRCL">
				<input type="text" class="form-control" id="id_bentuk"  value ="B2000003" required name="id_bentuk" readonly placeholder="No.CRCL">
			</div>
			<div class="col-md-8">
				<input type="text" class="form-control" id="nama_bentuk"  value ="Round Bar" required name="nama_bentuk" readonly placeholder="No.CRCL">
			</div>
		</div>
		</div>
		<div class="col-sm-6">
		<div class="form-group row">
			<div class="col-md-4">
				<label for="customer">Produk</label>
			</div>
			<div class="col-md-8">
				<select id="id_category3" name="id_category3" class="form-control select" onchange="caridensity()" required>
						<option value="">--Pilih--</option>
							<?php foreach ($results['material'] as $material){?>
						<option value="<?= $material->id_category3?>"><?= ucfirst(strtolower($material->nama_type))?>-<?= ucfirst(strtolower($material->nama))?>-<?= ucfirst(strtolower($material->hardness))?></option>
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
				<input type="text" class="form-control" id="thickness" readonly required name="thickness">
				</div>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group row" id="tempat_berat">
				<div class="col-md-4">
					<label for="id_category_supplier">Density</label>
				</div>
				<div class="col-md-8">
				<input type="text" class="form-control" id="density" readonly required name="density">
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
				<input type="text" class="form-control" id="width" required  name="width" onkeyup="hitungmasa()">
				</div>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group row" id="tempat_berat">
				<div class="col-md-4">
					<label for="id_category_supplier">Berat</label>
				</div>
				<div class="col-md-8">
				<input type="text" class="form-control" id="berat_produk" readonly required name="berat_produk">
				</div>
			</div>
		</div>
		</div>
		<div class="col-sm-12">
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="id_category_supplier">Jumlah Order</label>
				</div>
				<div class="col-md-8">
				<input type="text" class="form-control" id="qty_order" required name="qty_order" onkeyup="jumlahberat()">
				</div>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group row" id="jumlah_berat">
				<div class="col-md-4">
					<label for="id_category_supplier">Total Berat</label>
				</div>
				<div class="col-md-8">
				<input type="text" class="form-control" id="total_berat" required name="total_berat">
				</div>
			</div>
		</div>
		</div>
		<div class="col-sm-12">
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="id_category_supplier">Averange Qty / Month</label>
				</div>
				<div class="col-md-8">
				<input type="text" class="form-control" id="rerata" required name="rerata">
				</div>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group row" >
			<div class="col-md-4">
					<label for="id_category_supplier">Target Harga</label>
				</div>
				<div class="col-md-8">
				<input type="text" class="form-control" id="target_harga" required name="target_harga">
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
				<select id="master_sample" name="master_sample" class="form-control select"  required>
						<option value="">--Pilih--</option>
						<option value="No">No</option>
						<option value="Yes">Yes</option>
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
				<select id="mill_sheet" name="mill_sheet" class="form-control select"  required>
						<option value="">--Pilih--</option>
						<option value="No">No</option>
						<option value="Yes">Yes</option>
				</select>
				</div>
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
				<input type="text" class="form-control" id="toleransi1min" required name="toleransi1min" placeholder="Min">
				</div>
				<div class="col-md-4">
				<input type="text" class="form-control" id="toleransi1max" required name="toleransi1max" placeholder="Max">
				</div>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group row" >
			<div class="col-md-4">
					<label for="id_category_supplier">Toleransi Width</label>
				</div>
				<div class="col-md-4">
				<input type="text" class="form-control" id="toleransi2min" required name="toleransi2min"placeholder="Min" >
				</div>
				<div class="col-md-4">
				<input type="text" class="form-control" id="toleransi2max" required name="toleransi2max"placeholder="Max" >
				</div>
			</div>
		</div>
		</div>
		<div class="col-sm-12">
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="master_sample">Burry(% from Thickness)</label>
				</div>
				<div class="col-md-8">
				<input type="text" class="form-control" id="burry" required name="burry" >
				</div>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group row" >
			<div class="col-md-4">
					<label for="id_category_supplier">Sambungan Coil</label>
				</div>
				<div class="col-md-8">
				<select id="sambungan" name="sambungan" class="form-control select"  required>
						<option value="">--Pilih--</option>
						<option value="Sambung atau Join">Sambung atau Join</option>
						<option value="Marking">Marking</option>
						<option value="Tidak Boleh Sambung atau Join">Tidak Boleh Sambung atau Join</option>
				</select>
				</div>
			</div>
		</div>
		</div>
		<div class="col-sm-12">
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="master_sample">Inner Diameter</label>
				</div>
				<div class="col-md-4">
				<input type="text" class="form-control" id="inner_diametermax" required name="inner_diametermax" placeholder="Max">
				</div>
				<div class="col-md-4">
				<input type="text" class="form-control" id="inner_diametermin" required name="inner_diametermin" placeholder="Min">
				</div>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group row" >
			<div class="col-md-4">
					<label for="id_category_supplier">Outer Diameter (Max)</label>
				</div>
				<div class="col-md-8">
				<input type="text" class="form-control" id="outer_diameter" required name="outer_diameter" >
				</div>
			</div>
		</div>
		</div>
				<div class="col-sm-12">
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="master_sample">Apperace</label>
				</div>
				<div class="col-md-8">
				<input type="text" class="form-control" id="apperance" required name="apperance" placeholder="Max">
				</div>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group row" >
			<div class="col-md-4">
					<label for="id_category_supplier">Max Join / Marking</label>
				</div>
				<div class="col-md-8">
				<input type="text" class="form-control" id="maxjoin" required name="maxjoin" >
				</div>
			</div>
		</div>
		</div>
		</br>
		<div class="col-sm-12">
		<div class="form-group row">
		<div class="col-md-12">
				
				
				
		</div>
		</div>
		</div>
		<div class="col-sm-12">
		<div class="form-group row">
		<div class="col-md-12">
		<?php
								echo form_button(array('type'=>'button','class'=>'btn btn-md btn-success','value'=>'back','content'=>'Add','id'=>'add-deliver'));
							?>
		</div>
		</div>
		</div>
		<div class="col-sm-12">
		<div class="form-group row">
		<div class="col-md-12">

			<table class='table table-bordered table-striped'>
					<thead>
						<tr class='bg-blue'>
						<th>#</th>
						<th>DELIVERY SCHEDULE</th>
						<th>WAKTU</th>
						<th>DELIVERY QUANTITY</th>
						<th>ACTION</th>
						</tr>				
					</thead>
					<tbody id='list_delivery'>
											
					</tbody>
			</table>
		</div>
		</div>
		</div>
			</div>
			<center>
		<button type="submit" class="btn btn-success btn-sm" name="save" id="simpan-com"><i class="fa fa-save"></i>Simpan</button>
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
			var image	= $('#image').val();
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
						var baseurl=siteurl+'transaksi_inquiry/SaveNewRoll';
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
            url:siteurl+'transaksi_inquiry/cari_densityroll',
            data:"id_category3="+id_category3,
            success:function(html){
               $("#tempat_density").html(html);
            }
        });
    }
	function hitungmasa(){
        var thickness=$("#thickness").val();
		var density=$("#density").val();
		var width=$("#width").val();
		 $.ajax({
            type:"GET",
            url:siteurl+'transaksi_inquiry/hitung_beratroll',
            data:"thickness="+thickness+"&density="+density+"&width="+width,
            success:function(html){
               $("#tempat_berat").html(html);
            }
        });
    }
	function jumlahberat(){
        var berat_produk=$("#berat_produk").val();
		var qty_order=$("#qty_order").val();
		 $.ajax({
            type:"GET",
            url:siteurl+'transaksi_inquiry/JumlahBeratRoll',
            data:"berat_produk="+berat_produk+"&qty_order="+qty_order,
            success:function(html){
               $("#jumlah_berat").html(html);
            }
        });
    }
function DelItem(id){
		$('#list_delivery #tr_'+id).remove();
		
	}
	
	
	
</script>