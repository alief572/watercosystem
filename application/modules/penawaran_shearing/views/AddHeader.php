<?php
    $ENABLE_ADD     = has_permission('Trans_inquiry.Add');
    $ENABLE_MANAGE  = has_permission('Trans_inquiry.Manage');
    $ENABLE_VIEW    = has_permission('Trans_inquiry.View');
    $ENABLE_DELETE  = has_permission('Trans_inquiry.Delete');
	$tanggal = date('Y-m-d');
?>

 <div class="box box-primary">
    <div class="box-body">
		<form id="data-form" method="post">
			<div class="col-sm-12">
				<div class="input_fields_wrap2">
			<div class="row">
		<center><label for="customer" ><h3>Penawaran Slitting</h3></label></center>
		<div class="col-sm-12">
		<div class="col-sm-6">
		<div class="form-group row">
			<div class="col-md-4">
				<label for="customer">NO.Penawaran</label>
			</div>
			<div class="col-md-8" hidden>
				<input type="text" class="form-control" id="id_shearing"  required name="id_shearing" readonly placeholder="No.CRCL">
			</div>
			<div class="col-md-8">
				<input type="text" class="form-control" id="no_surat"  required name="no_surat" readonly placeholder="No.Penawaran">
			</div>
		</div>
		</div>
		<div class="col-sm-6">
		<div class="form-group row">
			<div class="col-md-4">
				<label for="customer">Tanggal</label>
			</div>
			<div class="col-md-8">
				<input type="date" class="form-control" id="tgl_penawaran" value="<?= $tanggal ?>" onkeyup required name="tgl_penawaran" readonly >
			</div>
		</div>
		</div>
		</div>
		<div class="col-sm-12">
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="id_customer">CUSTOMER</label>
				</div>
				<div class="col-md-8">
					<select id="id_customer" name="id_customer" class="form-control select" onchange="get_produk()" required>
						<option value="">--Pilih--</option>
							<?php foreach ($results['customers'] as $customers){?>
						<option value="<?= $customers->id_customer?>"><?= ucfirst(strtolower($customers->name_customer))?></option>
							<?php } ?>
					</select>
				</div>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="id_category_supplier">Material</label>
				</div>
				<div >
				<div class='col-md-8' id="produk_slot">
					<select id="id_produk" name="id_produk" onchange="get_properties()"  class="form-control select" required>
						<option value="">--Pilih--</option>
					</select>
				</div>

				</div>
			</div>
		</div>
		
		</div>
		<div class="col-sm-12">
		<div class="form-group row" >
		<div class="col-md-12">
		<div class='col-sm-6'>
		<div class='form-group row'>
			<div class='col-md-4'>
				<label for='email_customer'>Nama Material</label>
			</div>
			<div class='col-md-8' id="material_slot">
					<input type='text' class='form-control' readonly id='material' required name='material' >
			</div>
		</div>
		</div>
		<div class='col-sm-6'>
			<div class='form-group row'>
				<div class='col-md-4'>
					<label for='id_category_supplier'>Thickness</label>
				</div>
				<div class='col-md-8' id="thickness_slot" >
					<input type='text' class='form-control' readonly id='thickness' required name='thickness' >
				</div>
			</div>
		</div>
		</div>
		</div>
		</div>
		<div class="col-sm-12">
		<div class="form-group row" >
		<div class="col-md-12">
		<div class='col-sm-6'>
		<div class='form-group row'>
			<div class='col-md-4'>
				<label for='email_customer'>Density</label>
			</div>
			<div class='col-md-8' id="density_slot">
					<input type='text' class='form-control' readonly id='density' required name='density' >
			</div>
		</div>
		</div>
		<div class='col-sm-6'>
			<div class='form-group row'>
				<div class='col-md-4'>
					<label for='id_category_supplier'>Surface</label>
				</div>
				<div class='col-md-8' id="surface_slot" >
					<input type='text' class='form-control' readonly id='surface' required name='surface' >
				</div>
			</div>
		</div>
		</div>
		</div>
		</div>
		<div class="col-sm-12">
		<div class="form-group row" >
		<div class="col-md-12">
		<div class='col-sm-6'>
		<div class='form-group row'>
			<div class='col-md-4'>
				<label for='email_customer'>Lebar Coil</label>
			</div>
			<div class='col-md-8' id="lebar_coil_slot">
					<input type='number' class='form-control' id='lebar_coil' onkeyup="get_lebar()" required name='lebar_coil' >
			</div>
		</div>
		</div>
		<div class='col-sm-6'>
			<div class='form-group row'>
				<div class='col-md-4'>
					<label for='id_category_supplier'>Qty Request</label>
				</div>
				<div class='col-md-8' id="qty_slot" >
					<input type='number' class='form-control' id='qty' required name='qty' >
				</div>
			</div>
		</div>
		</div>
		</div>
		</div>
		<div class="col-sm-12">
		<div class="form-group row" >
		<div class="col-md-12">
		<div class='col-sm-6'>
		<div class='form-group row'>
			<div class='col-md-4'>
				<label for='email_customer'>Kurs</label>
			</div>
			<div class='col-md-8' id="email_slot">
									<select id="mata_uang" name="mata_uang" class="form-control select" required>
						<option value="">--Pilih--</option>
							<?php foreach ($results['mata_uang'] as $mata_uang){?>
						<option value="<?= $mata_uang->kode?>"><?= ucfirst(strtolower($mata_uang->kode))?></option>
							<?php } ?>
					</select>
			</div>
		</div>
		</div>
		<div class='col-sm-6'>
			<div class='form-group row'>
				<div class='col-md-4'>
					<label for='id_category_supplier'>Potongan Pinggir</label>
				</div>
				<div class='col-md-8' id="potongan_slot" >
					<input type='number' class='form-control' readonly id='potongan_pinggir' required name='potongan_pinggir' >
				</div>
			</div>
		</div>
		</div>
		</div>
		</div>

		<div class="col-sm-12">
		<div class="form-group row" >
			<table class='table table-bordered table-striped'>
			<thead>
			<tr class='bg-blue'>
			<th hidden>Id Stok</th>
			<th>Lot. No. Material</th>
			<th>Nama Material</th>
			<th>Berat Coil</th>
			<th>Density</th>
			<th>Panjang Coil</th>
			<th>Lebar Material</th>
			<th>Lebar coil permintaan Customer</th>
			<th>Jumlah Coil Customer</th>
			<th>Sisa Potongan</th>
			<th>Qty Roll</th>
			<th>Jumlah Pisau</th>
			<th>Aksi</th>
			</tr>
			</thead>
			<tbody id="stock_slot">
			</tbody>
			</table>
		</div>
			</div>
		<div class="col-sm-12" hidden>
		<div class="form-group row" >
			<table class='table table-bordered table-striped'>
			<thead>
			<tr class='bg-blue'>
			<th hidden>Id Stok</th>
			<th>Lot. No. Material</th>
			<th>Nama Material</th>
			<th>Berat Coil</th>
			<th>Density</th>
			<th>Panjang Coil</th>
			<th>Lebar Material</th>
			<th>Lebar coil permintaan Customer</th>
			<th>Jumlah Coil Customer</th>
			<th>Sisa Potongan</th>
			<th>Qty Roll</th>
			<th>Jumlah Pisau</th>
			</tr>
			</thead>
			<tbody id="used_slot">
			</tbody>
			</table>
		</div>
			</div>
				<div class="col-sm-12">
		<div class="form-group row" >
		<div class="col-md-12">
		<div class='col-sm-6'>
		<div class='form-group row'>
			<div class='col-md-4'>
				<label for='email_customer'>Total Panjang</label>
			</div>
			<div class='col-md-8' id="tpanjang_slot">
					<input type='number' class='form-control' id='total_panjang' readonly required name='total_panjang' >
			</div>
		</div>
		</div>
		<div class='col-sm-6'>
		<div class='form-group row'>
			<div class='col-md-4'>
				<label for='email_customer'>Jumlah Pisau</label>
			</div>
			<div class='col-md-8' id="jpisau_slot">
					<input type='number' class='form-control' id='jml_pisau' readonly required name='jml_pisau' >
			</div>
		</div>
		</div>
		</div>
		</div>
		</div>
			<div class="col-sm-12">
		<div class="form-group row" >
		<div class="col-md-12">
		<div class='col-sm-6'>
		<div class='form-group row'>
			<div class='col-md-4'>
				<label for='email_customer'>Jumlah Mother Coil</label>
			</div>
			<div class='col-md-8' id="mother_slot">
					<input type='number' class='form-control' id='jml_mother' readonly required name='jml_mother' >
			</div>
		</div>
		</div>
		<div class='col-sm-6'>
		<div class='form-group row'>
			<div class='col-md-4'>
				<label for='email_customer'>Total Berat Produk</label>
			</div>
			<div class='col-md-8' id="tberat_slot">
					<input type='number' class='form-control' id='total_berat' readonly required name='total_berat' >
			</div>
		</div>
		</div>
		</div>
		</div>
		</div>
		<div class="col-sm-6">
		<div class="form-group row" >
		<div class="col-md-6">
		<div class='col-sm-12'>
		<div class='form-group row'>
			<div class='col-md-12'>
				<label for='email_customer'>Waktu Proses</label>
			</div>
		</div>
		</div>
		<div class='col-sm-12'>
		<div class='form-group row'>
			<div class='col-md-4'>
				<label for='email_customer'>Waktu Proses</label>
			</div>
			<div class='col-md-8' id="sl_wproses">
					<input type='number' class='form-control' id='wproses' readonly required name='wproses' >
			</div>
		</div>
		</div>
		<div class='col-sm-12'>
		<div class='form-group row'>
			<div class='col-md-4'>
				<label for='email_customer'>Setting Pisau</label>
			</div>
			<div class='col-md-8' id="sl_spisau">
					<input type='number' class='form-control' id='spisau' readonly required name='spisau' >
			</div>
		</div>
		</div>
				<div class='col-sm-12'>
		<div class='form-group row'>
			<div class='col-md-4'>
				<label for='email_customer'>Ganti Coil dan Pengecekan</label>
			</div>
			<div class='col-md-8' id="sl_gcoil">
					<input type='number' class='form-control' id='gcoil' readonly required name='gcoil' >
			</div>
		</div>
		</div>
						<div class='col-sm-12'>
		<div class='form-group row'>
			<div class='col-md-4'>
				<label for='email_customer'>Total Waktu Proses</label>
			</div>
			<div class='col-md-8' id="sl_ttwproses">
					<input type='number' class='form-control' id='twproses' readonly required name='twproses' >
			</div>
		</div>
		</div>
		<div class='col-sm-12'>
		<div class='form-group row'>
			<div class='col-md-4'>
				<label for='email_customer'>Handling</label>
			</div>
			<div class='col-md-8' id="sl_handling">
					<input type='number' class='form-control' id='handling' readonly required name='handling' >
			</div>
		</div>
		</div>
										<div class='col-sm-12'>
		<div class='form-group row'>
			<div class='col-md-4'>
				<label for='email_customer'>Total Waktu</label>
			</div>
			<div class='col-md-8' id="sl_twaktu">
					<input type='number' class='form-control' id='twaktu' readonly required name='twaktu' >
			</div>
		</div>
		</div>
		</div>
		</div>
		</div>
		<div class="col-sm-6">
		<div class="form-group row" >
		<div class="col-md-6">
		<div class='col-sm-12'>
		<div class='form-group row'>
			<div class='col-md-12'>
				<label for='email_customer'>Harga Proses</label>
			</div>
		</div>
		</div>
		<div class='col-sm-12'>
		<div class='form-group row'>
			<div class='col-md-4'>
				<label for='email_customer'>Biaya Proses</label>
			</div>
			<div class='col-md-8' id="sl_bproses">
					<input type='number' class='form-control' id='bproses' readonly required name='bproses' >
			</div>
		</div>
		</div>
		<div class='col-sm-12'>
		<div class='form-group row'>
			<div class='col-md-4'>
				<label for='email_customer'>Profit</label>
			</div>
			<div class='col-md-8' id="sl_profit">
					<input type='number' class='form-control' id='profit' readonly required name='profit' >
			</div>
		</div>
		</div>
				<div class='col-sm-12'>
		<div class='form-group row'>
			<div class='col-md-4'>
				<label for='email_customer'>Total Harga Penawaran</label>
			</div>
			<div class='col-md-8' id="sl_totalharga">
					<input type='number' class='form-control' id='ttlhgpenawaran' readonly required name='ttlhgpenawaran' >
			</div>
		</div>
		</div>
		<div class='col-sm-12'>
		<div class='form-group row'>
			<div class='col-md-4'>
				<label for='email_customer'>Harga Per Kilo(Rp)</label>
			</div>
			<div class='col-md-8' id="sl_rupiah">
					<input type='number' class='form-control' id='hgpkgrp' readonly required name='hgpkgrp' >
			</div>
		</div>
		</div>
		<div class='col-sm-12'>
		<div class='form-group row'>
			<div class='col-md-4'>
				<label for='email_customer'>Harga Per Kilo($)</label>
			</div>
			<div class='col-md-8' id="sl_dolar">
					<input type='number' class='form-control' id='hgpkgdl' readonly required name='hgpkgdl' >
			</div>
		</div>
		</div>
		</div>
		</div>
		</div>
										<div class='col-sm-12'>
		<div class='form-group row'>
			<center>
		<button type="submit" class="btn btn-success btn-sm" name="save" id="simpan-com"><i class="fa fa-save"></i>Simpan</button>
		<a class="btn btn-danger btn-sm" href="<?= base_url('/penawaran_shearing/') ?>"  title="Edit">Kembali</a>
			</center>
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
						var baseurl=siteurl+'penawaran_shearing/SaveNewHeader';
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
        var id_customer=$("#id_customer").val();
		
		 $.ajax({
            type:"GET",
            url:siteurl+'penawaran_shearing/GetProduk',
            data:"id_customer="+id_customer,
            success:function(html){
               $("#produk_slot").html(html);
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
            url:siteurl+'penawaran_shearing/HitungWProses',
            data:"hasilpanjang="+hasilpanjang+"&total_panjang="+total_panjang,
            success:function(html){
               $("#sl_wproses").html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_shearing/HitungSTPisau',
            data:"jumlahpisau="+jumlahpisau+"&jml_pisau="+jml_pisau,
            success:function(html){
               $("#sl_spisau").html(html);
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
            url:siteurl+'penawaran_shearing/HitungGcoil',
            data:"jml_mother="+jml_mother,
            success:function(html){
               $("#sl_gcoil").html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_shearing/HitungTWProses',
            data:"jml_mother="+jml_mother+"&jumlahpisau="+jumlahpisau+"&jml_pisau="+jml_pisau+"&hasilpanjang="+hasilpanjang+"&total_panjang="+total_panjang,
            success:function(html){
               $("#sl_ttwproses").html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_shearing/HitungHandling',
            data:"jml_mother="+jml_mother+"&jumlahpisau="+jumlahpisau+"&jml_pisau="+jml_pisau+"&hasilpanjang="+hasilpanjang+"&total_panjang="+total_panjang,
            success:function(html){
               $("#sl_handling").html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_shearing/HitungTWaktu',
            data:"jml_mother="+jml_mother+"&jumlahpisau="+jumlahpisau+"&jml_pisau="+jml_pisau+"&hasilpanjang="+hasilpanjang+"&total_panjang="+total_panjang,
            success:function(html){
               $("#sl_twaktu").html(html);
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
            url:siteurl+'penawaran_shearing/HitungBProses',
           data:"hasilpanjang="+hasilpanjang+"&total_panjang="+total_panjang+"&thickness="+thickness+"&lebarcc="+lebarcc+"&density="+density,
            success:function(html){
               $("#sl_bproses").html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_shearing/HitungProfit',
           data:"hasilpanjang="+hasilpanjang+"&total_panjang="+total_panjang+"&thickness="+thickness+"&lebarcc="+lebarcc+"&density="+density,
            success:function(html){
               $("#sl_profit").html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_shearing/HitungHtotal',
           data:"hasilpanjang="+hasilpanjang+"&total_panjang="+total_panjang+"&thickness="+thickness+"&lebarcc="+lebarcc+"&density="+density,
            success:function(html){
               $("#sl_totalharga").html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_shearing/HitungHRp',
           data:"hasilpanjang="+hasilpanjang+"&total_panjang="+total_panjang+"&thickness="+thickness+"&lebarcc="+lebarcc+"&density="+density,
            success:function(html){
               $("#sl_rupiah").html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_shearing/HitungHdl',
           data:"hasilpanjang="+hasilpanjang+"&total_panjang="+total_panjang+"&thickness="+thickness+"&lebarcc="+lebarcc+"&density="+density,
            success:function(html){
               $("#sl_dolar").html(html);
            }
        });
		;$.ajax({
            type:"GET",
            url:siteurl+'penawaran_shearing/HitungHtotal',
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