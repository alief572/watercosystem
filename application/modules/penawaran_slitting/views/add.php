<?php
	$tanggal = date('Y-m-d');
?>
 <div class="box box-primary">
    <div class="box-body"><br>
		<form id="data-form" method="post">
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
					<select id="id_customer" name="id_customer"  onchange='CariPic()'  class="form-control"required>
						<option value="">--Pilih--</option>
							<?php foreach ($results['customers'] as $customers){?>
						<option value="<?= $customers->id_customer?>"><?= ucfirst(strtolower($customers->name_customer))?></option>
							<?php } ?>
					</select>
				</div>
			</div>
		</div>
		<div class='col-sm-6'>
		<div class='form-group row'>
			<div class='col-md-4'>
				<label for='email_customer'>Kurs</label>
			</div>
			<div class='col-md-8' id="email_slot">
					<select id="mata_uang" name="mata_uang" class="form-control select" required>
						<option value="">--Pilih--</option>
						<option value="IDR">IDR(Rupiah)</option>
						<option value="USD">USD(Dolar)</option>
					</select>

			</div>
		</div>
		</div>
		</div>
				<div class="col-sm-12">
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="id_customer">PIC CUSTOMER</label>
				</div>
				<div class="col-md-8" id='list_pic'>
					<select id="pic_cutomer" name="pic_cutomer" class="form-control"required>
						<option value="">--Pilih--</option>
					</select>
				</div>
			</div>
		</div>
		<div class='col-sm-6'>
		<div class='form-group row'>
			<div class='col-md-4'>
				<label >VALID UNTIL</label>
			</div>
			<div class='col-md-8' >
				<input type="date" class="form-control" id="valid_until"  required name="valid_until" >
			</div>
		</div>
		</div>
		</div>
		</div>

			<br>
			<div class='box box-info'>
				<div class='box-header'>
					<h3 class='box-title'>Detail Penawaran</h3>
					<div class='box-tool pull-right'>
					</div>
				</div>
				<div class='box-body hide_header'>
					<table class='table table-striped table-bordered table-hover table-condensed' width='100%'>
			<thead>
			<tr class='bg-blue'>
			<th width='15%'>Nama Material</th>
			<th width='8%'>Berat Coil (Kg)</th>
			<th width='8%'>Density(g/cm3)</th>
			<th width='8%'>Thickness(mm)</th>
			<th width='8%'>Width (mm)</th>
			<th width='8%'>Length (M)</th>
			<th width='8%'>Waste(mm)</th>
			<th width='8%' hidden>Used</th>
			<th width='8%'>Waste(kg)</th>
			<th width='10%'>Biaya Proses</th>
			<th width='8%'>Profit</th>
			<th width='10%'>Harga Total</th>
			<th width='12%'>Harga Penawaran</th>
			<th width='6%'>#</th>
			</tr>
			</thead>
			<tbody>
							<tr id='add_0'>
								<td align='center'></td>
								<td align='left'><button type='button' class='btn btn-sm btn-warning addPart' title='Add penawran'><i class='fa fa-plus'></i>&nbsp;&nbsp;Add</button></td>
								<td colspan='10'></td>
							</tr>
			</tbody>
						<thead>
			<tr class='bg-blue'>
			<th colspan='10'>Total Biaya</th>
			<th id='slot_total_peawaran'><input type='text' class='form-control input-md maskM' placeholder= 'Total Biaya' id='total_harga_penawaran'  readonly required name='total_harga_penawaran' ></th>
			<th width='5%' id='djancuk'>#</th>
			</tr>
			</thead>
					</table>
					<br>
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
		<div class="col-sm-12">
		<div class="form-group row" >
		<div class="col-md-12">
		<div class='col-sm-6'>
		<div class='form-group row'>
			<div class='col-md-4'>
				<label for='email_customer'>Total Waktu</label>
			</div>
			<div class='col-md-8' id="twaktu_slot">
					<input type='number' class='form-control' id='total_waktu' readonly required name='total_waktu' >
			</div>
		</div>
		</div>
		</div>
		</div>
		</div>
          <button type="button" class="btn btn-danger" style='float:right; margin-left:5px;' name="back" id="back"><i class="fa fa-reply"></i> Back</button>
					<button type="submit" class="btn btn-primary" style='float:right;' name="save" id="save"><i class="fa fa-save"></i> Save</button>

				</div>
			</div>
		</form>
	</div>
</div>


<script src="<?= base_url('assets/js/jquery.maskMoney.js')?>"></script>
<script src="<?= base_url('assets/js/autoNumeric.js')?>"></script>

<script type="text/javascript">
	//$('#input-kendaraan').hide();
	var base_url			= '<?php echo base_url(); ?>';
	var active_controller	= '<?php echo($this->uri->segment(1)); ?>';

	$(document).ready(function(){
		$('.chosen-select').select2();

		//add part
		$(document).on('click', '.addPart', function(){
			// loading_spinner();
			var get_id 		= $(this).parent().parent().attr('id');
			// console.log(get_id);
			var split_id	= get_id.split('_');
			var id 		= parseInt(split_id[1])+1;
			var id_bef 	= split_id[1];

			$.ajax({
				url: base_url+'index.php/'+active_controller+'/get_add/'+id,
				cache: false,
				type: "POST",
				dataType: "json",
				success: function(data){
					$("#add_"+id_bef).before(data.header);
					$("#add_"+id_bef).remove();
					$('.chosen_select').select2({width: '100%'});
					$('.maskM').maskMoney();
					swal.close();
				},
				error: function() {
					swal({
						title				: "Error Message !",
						text				: 'Connection Time Out. Please try again..',
						type				: "warning",
						timer				: 3000,
						showCancelButton	: false,
						showConfirmButton	: false,
						allowOutsideClick	: false
					});
				}
			});
		});

		//add part
		$(document).on('click', '.addSubPart', function(){
			// loading_spinner();
			var get_id 		= $(this).parent().parent().attr('id');
			// console.log(get_id);
			var split_id	= get_id.split('_');
			var id 			= split_id[1];
			var id2 		= parseInt(split_id[2])+1;
			var id_bef 		= split_id[2];

			$.ajax({
				url: base_url+'index.php/'+active_controller+'/get_add_sub/'+id+'/'+id2,
				cache: false,
				type: "POST",
				dataType: "json",
				success: function(data){
					$("#add_"+id+"_"+id_bef).before(data.header);
					$("#add_"+id+"_"+id_bef).remove();
					$('.chosen_select').select2({width: '100%'});
					$('.maskM').maskMoney();
					swal.close();
				},
				error: function() {
					swal({
						title				: "Error Message !",
						text				: 'Connection Time Out. Please try again..',
						type				: "warning",
						timer				: 3000,
						showCancelButton	: false,
						showConfirmButton	: false,
						allowOutsideClick	: false
					});
				}
			});
		});

		//delete part
		$(document).on('click', '.delPart', function(){
			var get_id 		= $(this).parent().parent().attr('class');
			$("."+get_id).remove();
		});
		
		$(document).on('click', '.hapusPart', function(){
			var get_id 		= $(this).parent().parent().attr('class');
			var split_id	= get_id.split('_');
			var id 			= split_id[1];
			var id2 		= parseInt(split_id[2]);
			var total_harga_penawaran=$('#total_harga_penawaran').val();
		var total_panjang=$('#total_panjang').val();
		var jml_pisau=$('#jml_pisau').val();
		var jml_mother=$('#jml_mother').val();
		var total_berat=$('#total_berat').val();
		var hargadeal=$('#dt_hargadeal_'+id).val();
		var qty=$('#dt_qty_'+id).val();
		var panjang=$('#dt_panjang_'+id).val();
		var jmlpisaudt=$('#dt_jmlpisau_'+id).val();
		var berat=$('#dt_berat_'+id).val();
		
		
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/MinHarga',
            data:"hargadeal="+hargadeal+"&total_harga_penawaran="+total_harga_penawaran,
            success:function(html){
               $('#slot_total_peawaran').html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/MinPanjang',
            data:"panjang="+panjang+"&total_panjang="+total_panjang+"&qty="+qty,
            success:function(html){
               $('#tpanjang_slot').html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/MinPisau',
            data:"jmlpisaudt="+jmlpisaudt+"&jml_pisau="+jml_pisau,
            success:function(html){
               $('#jpisau_slot').html(html);
            }
        });
		$.ajax({ 
            type:"GET",
            url:siteurl+'penawaran_slitting/MinMother',
            data:"qty="+qty+"&jml_mother="+jml_mother,
            success:function(html){
               $('#mother_slot').html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/MinBerat',
            data:"berat="+berat+"&total_berat="+total_berat+"&qty="+qty,
            success:function(html){
               $('#tberat_slot').html(html);
			   
            }
        });
			$("."+get_id).remove();
		});

		$(document).on('click', '.delSubPart', function(){
			var get_id 		= $(this).parent().parent('tr').html();
			$(this).parent().parent('tr').remove();
		});
		$(document).on('click', '.cancelSubPart', function(){
			var get_id 		= $(this).parent().parent('tr').html();
			var split_id	= get_id.split('_');
			var id 			= split_id[1];
			var id2 		= parseInt(split_id[2]);
			var subqty 		=$('#subqty_'+id+'_'+id2).val();
			var subwidth 	=$('#subwidth_'+id+'_'+id2).val();
			var subberat 	=$('#subberat_'+id+'_'+id2).val();
			var mainqty 	=$('#dt_qty_'+id).val();
			var sisa 		=$('#dt_sisa_'+id).val();
			var mainberat 	=$('#dt_berat_'+id).val();
			var mainused 	=$('#dt_used_'+id).val();
			var mainsisakg 	=$('#dt_sisakg_'+id).val();
			var mainwidth 	=$('#dt_lebarnew_'+id).val();
			var pegangan 	=$('#dt_pegangan_'+id).val();
			var lebar 	=$('#dt_lebar_'+id).val();
					$.ajax({
						type:"GET",
						url:siteurl+'penawaran_slitting/minussubwidth',
						data:"id="+id+"&id2="+id2+"&mainwidth="+mainwidth+"&subwidth="+subwidth+"&subqty="+subqty,
						success:function(html){
						   $("#lebarnew_"+id).html(html);
						}
					});
					$.ajax({
						type:"GET",
						url:siteurl+'penawaran_slitting/minussubqty',
						data:"id="+id+"&id2="+id2+"&subqty="+subqty+"&mainqty="+mainqty,
						success:function(html){
						   $("#qty_"+id).html(html);
						}
					});
					$.ajax({
						type:"GET",
						url:siteurl+'penawaran_slitting/MinusSubPisauSatuan',
						data:"id="+id+"&subqty="+subqty+"&mainqty="+mainqty,
						success:function(html){
						   $("#pisau_"+id).html(html);
						}
					}); 
					$.ajax({
						type:"GET",
						url:siteurl+'penawaran_slitting/MinusSubUsed',
						data:"id="+id+"&mainberat="+mainberat+"&mainused="+mainused+"&subberat="+subberat,
						success:function(html){
						   $("#used_"+id).html(html);
						}
					});
					$.ajax({
						type:"GET",
						url:siteurl+'penawaran_slitting/MinusSubSisaKg',
						data:"id="+id+"&mainberat="+mainberat+"&mainused="+mainused+"&subberat="+subberat,
						success:function(html){
						   $("#sisakg_"+id).html(html);
						}
					}); 					
					$.ajax({
						type:"GET",
						url:siteurl+'penawaran_slitting/KunciSub',
						data:"id="+id+"&id2="+id2+"&subqty="+subqty+"&subwidth="+subwidth,
						success:function(html){
						   $("#header_"+id+"_"+id2).html(html);
						}
					});

					$.ajax({
						type:"GET",
						url:siteurl+'penawaran_slitting/Minussubsisasatuan',
						data:"id="+id+"&id2="+id2+"&subqty="+subqty+"&subwidth="+subwidth+"&sisa="+sisa+"&mainqty="+mainqty+"&mainwidth="+mainwidth+"&pegangan="+pegangan+"&lebar="+lebar,
						success:function(html){
						   $('#sisa_'+id).html(html);
						}
					});
			$(this).parent().parent('tr').remove();
		});
		
		$(document).on('click', '.LockSubData', function(){
			var get_id 		= $(this).parent().parent('tr').html();
			var split_id	= get_id.split('_');
			var id 			= split_id[1];
			var id2 		= parseInt(split_id[2]);
			var subqty 		=$('#subqty_'+id+'_'+id2).val();
			var subwidth 	=$('#subwidth_'+id+'_'+id2).val();
			var subberat 	=$('#subberat_'+id+'_'+id2).val();
			var subberatreq =$('#subberatreq_'+id+'_'+id2).val();
			var subqcoil 	=$('#subqcoil_'+id+'_'+id2).val();
			var mainberat 	=$('#dt_berat_'+id).val();
			var mainused 	=$('#dt_used_'+id).val();
			var mainsisakg 	=$('#dt_sisakg_'+id).val();
			var mainqty 	=$('#dt_qty_'+id).val();
			var mainwidth 	=$('#dt_lebarnew_'+id).val();
			var pegangan 	=$('#dt_pegangan_'+id).val();
			var lebar 	=$('#dt_lebar_'+id).val();
			var sisa 	=$('#dt_sisa_'+id).val();
					$.ajax({
						type:"GET",
						url:siteurl+'penawaran_slitting/hitungsubwidth',
						data:"id="+id+"&id2="+id2+"&mainwidth="+mainwidth+"&subwidth="+subwidth+"&subqty="+subqty,
						success:function(html){
						   $("#lebarnew_"+id).html(html);
						}
					});
					$.ajax({
						type:"GET",
						url:siteurl+'penawaran_slitting/hitungsubqty',
						data:"id="+id+"&id2="+id2+"&subqty="+subqty+"&mainqty="+mainqty,
						success:function(html){
						   $("#qty_"+id).html(html);
						}
					});
					$.ajax({
						type:"GET",
						url:siteurl+'penawaran_slitting/SubUsed',
						data:"id="+id+"&id2="+id2+"&mainberat="+mainberat+"&mainused="+mainused+"&subberat="+subberat,
						success:function(html){
						   $("#used_"+id).html(html);
						}
					});$.ajax({
						type:"GET",
						url:siteurl+'penawaran_slitting/SubSisaKg',
						data:"id="+id+"&id2="+id2+"&mainberat="+mainberat+"&mainused="+mainused+"&subberat="+subberat,
						success:function(html){
						   $("#sisakg_"+id).html(html);
						}
					});
					$.ajax({
						type:"GET",
						url:siteurl+'penawaran_slitting/HitungSubPisauSatuan',
						data:"id="+id+"&subqty="+subqty+"&mainqty="+mainqty,
						success:function(html){
						   $("#pisau_"+id).html(html);
						}
					});
					$.ajax({
						type:"GET",
						url:siteurl+'penawaran_slitting/KunciSub',
						data:"id="+id+"&id2="+id2+"&subqty="+subqty+"&subwidth="+subwidth+"&subberat="+subberat+"&subberatreq="+subberatreq+"&subqcoil="+subqcoil,
						success:function(html){
						   $("#header_"+id+"_"+id2).html(html);
						}
					});

					$.ajax({
						type:"GET",
						url:siteurl+'penawaran_slitting/Hitungsubsisasatuan',
						data:"id="+id+"&id2="+id2+"&subqty="+subqty+"&sisa="+sisa+"&subwidth="+subwidth+"&mainqty="+mainqty+"&mainwidth="+mainwidth+"&pegangan="+pegangan+"&lebar="+lebar,
						success:function(html){
						   $('#sisa_'+id).html(html);
						}
					});
		});
		
$(document).on('keyup', '.formsub', function(){
			var get_id 		= $(this).parent().parent('tr').html();
			var split_id	= get_id.split('_');
			var id 			= split_id[1];
			var id2 		= parseInt(split_id[2]);
			var subqty 		=$('#subqty_'+id+'_'+id2).val();
			var subwidth 	=$('#subwidth_'+id+'_'+id2).val();
			var maindensity 	=$('#dt_density_'+id).val();
			var mainthickness 	=$('#dt_thickness_'+id).val();
			var mainpanjang 	=$('#dt_panjang_'+id).val();
					$.ajax({
						type:"GET",
						url:siteurl+'penawaran_slitting/HitungSubFormBerat',
						data:"id="+id+"&id2="+id2+"&maindensity="+maindensity+"&mainthickness="+mainthickness+"&mainpanjang="+mainpanjang+"&subwidth="+subwidth+"&subqty="+subqty,
						success:function(html){
						   $("#subsberat_"+id+'_'+id2).html(html);
						}
					});
		});
$(document).on('keyup', '.formsubagain', function(){
			var get_id 		= $(this).parent().parent('tr').html();
			var split_id	= get_id.split('_');
			var id 			= split_id[1];
			var id2 		= parseInt(split_id[2]);
			var subreq 		=$('#subberatreq_'+id+'_'+id2).val();
			var subrumus 	=$('#subberat_'+id+'_'+id2).val();
					$.ajax({
						type:"GET",
						url:siteurl+'penawaran_slitting/HitungSubTauApaan',
						data:"id="+id+"&id2="+id2+"&subreq="+subreq+"&subrumus="+subrumus,
						success:function(html){
						   $("#qcoils_"+id+'_'+id2).html(html);
						}
					});
		});
    //add part
		$(document).on('click', '#back', function(){
		    window.location.href = base_url + active_controller;
		});



		$('#save').click(function(e){
			e.preventDefault();
			var produk		= $('#produk').val();
			var costcenter	= $('.costcenter').val();
			var process		= $('.process').val();

			if(produk == '0' ){
				swal({
					title	: "Error Message!",
					text	: 'Product name empty, select first ...',
					type	: "warning"
				});

				$('#save').prop('disabled',false);
				return false;
			}
			if(costcenter == '0' ){
				swal({
					title	: "Error Message!",
					text	: 'Costcenter empty, select first ...',
					type	: "warning"
				});

				$('#save').prop('disabled',false);
				return false;
			}
			if(process == '0' ){
				swal({
					title	: "Error Message!",
					text	: 'Process name empty, select first ...',
					type	: "warning"
				});

				$('#save').prop('disabled',false);
				return false;
			}

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
						var baseurl=siteurl+'penawaran_slitting/save_cycletime';
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
	function CariPic(){
	   	var id_customer=$('#id_customer').val();

		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/CariPic',
            data:"id_customer="+id_customer,
            success:function(html){
               $("#list_pic").html(html);
            }
        });
	}
	
	
	function CariProperties(id){
	    var id_material=$('#dt_idmaterial_'+id).val();
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/CariDensity',
            data:"id_material="+id_material+"&id="+id,
            success:function(html){
               $('#density_'+id).html(html);
            }
        });
	}
	function DeleteItem(id){
		var total_harga_penawaran=$('#total_harga_penawaran').val();
		var total_panjang=$('#total_panjang').val();
		var total_waktu=$('#total_waktu').val();
		var jml_pisau=$('#jml_pisau').val();
		var jml_mother=$('#jml_mother').val();
		var total_berat=$('#total_berat').val();
		var hargadeal=$('#dt_hargadeal_'+id).val();
		var qty=$('#dt_qty_'+id).val();
		var panjang=$('#dt_panjang_'+id).val();
		var jmlpisaudt=$('#dt_jmlpisau_'+id).val();
		var berat=$('#dt_berat_'+id).val();
		var waktu=$('#dt_waktu_'+id).val();
		
		
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/MinHarga',
            data:"hargadeal="+hargadeal+"&total_harga_penawaran="+total_harga_penawaran,
            success:function(html){
               $('#slot_total_peawaran').html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/MinPanjang',
            data:"panjang="+panjang+"&total_panjang="+total_panjang+"&qty="+qty,
            success:function(html){
               $('#tpanjang_slot').html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/MinPisau',
            data:"jmlpisaudt="+jmlpisaudt+"&jml_pisau="+jml_pisau,
            success:function(html){
               $('#jpisau_slot').html(html);
            }
        });
		$.ajax({ 
            type:"GET",
            url:siteurl+'penawaran_slitting/MinMother',
            data:"qty="+qty+"&jml_mother="+jml_mother,
            success:function(html){
               $('#mother_slot').html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/MinBerat',
            data:"berat="+berat+"&total_berat="+total_berat+"&qty="+qty,
            success:function(html){
               $('#tberat_slot').html(html);
			   
            }
        });

				$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/MinTWaktu',
            data:"waktu="+waktu+"&total_waktu="+total_waktu,
            success:function(html){
               $('#twaktu_slot').html(html);
            }
        });
		 $('#stock_slot #header_'+id).remove();
		
	}
	function TambahItem(id){
	   	var lotno=$('#dt_lotno_'+id).val();
		var idmaterial=$('#dt_idmaterial_'+id).val();
		var berat=$('#dt_berat_'+id).val();
		var density=$('#dt_density_'+id).val();
		var thickness=$('#dt_thickness_'+id).val();
		var lebar=$('#dt_lebar_'+id).val();
		var panjang=$('#dt_panjang_'+id).val();
		var lebarnew=$('#dt_lebarnew_'+id).val();
		var qty=$('#dt_qty_'+id).val();
		var pegangan=$('#dt_pegangan_'+id).val();
		var sisa=$('#dt_sisa_'+id).val();
		var used=$('#dt_used_'+id).val();
		var sisakg=$('#dt_sisakg_'+id).val();
		var jmlpisau=$('#dt_jmlpisau_'+id).val();
		var harga=$('#dt_harga_'+id).val();
		var waktu=$('#dt_waktu_'+id).val();
		var profit=$('#dt_profit_'+id).val();
		var totalpenawaran=$('#dt_totalpenawaran_'+id).val();
		var hargadeal=$('#dt_hargadeal_'+id).val();
		var nama_material=$('#dt_nama_material_'+id).val();
		var total_panjang=$('#total_panjang').val();
		var jml_pisau=$('#jml_pisau').val();
		var jml_mother=$('#jml_mother').val();
		var total_berat=$('#total_berat').val();
		var total_waktu=$('#total_waktu').val();
		var id_customer=$('#id_customer').val();
		var total_harga_penawaran=$('#total_harga_penawaran').val();
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/LockDetail',
            data:"lotno="+lotno+"&nama_material="+nama_material+"&waktu="+waktu+"&used="+used+"&sisakg="+sisakg+"&profit="+profit+"&hargadeal="+hargadeal+"&totalpenawaran="+totalpenawaran+"&id_customer="+id_customer+"&idmaterial="+idmaterial+"&berat="+berat+"&density="+density+"&thickness="+thickness+"&lebar="+lebar+"&panjang="+panjang+"&lebarnew="+lebarnew+"&qty="+qty+"&pegangan="+pegangan+"&sisa="+sisa+"&jmlpisau="+jmlpisau+"&harga="+harga+"&id="+id,
            success:function(html){
               $('#trhead_'+id).html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/SumHarga',
            data:"lotno="+lotno+"&total_harga_penawaran="+total_harga_penawaran+"&nama_material="+nama_material+"&waktu="+waktu+"&profit="+profit+"&hargadeal="+hargadeal+"&totalpenawaran="+totalpenawaran+"&id_customer="+id_customer+"&idmaterial="+idmaterial+"&berat="+berat+"&density="+density+"&thickness="+thickness+"&lebar="+lebar+"&panjang="+panjang+"&lebarnew="+lebarnew+"&qty="+qty+"&pegangan="+pegangan+"&sisa="+sisa+"&jmlpisau="+jmlpisau+"&harga="+harga+"&id="+id,
            success:function(html){
               $('#slot_total_peawaran').html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/CariTPanjang',
            data:"lotno="+lotno+"&total_harga_penawaran="+total_harga_penawaran+"&total_panjang="+total_panjang+"&total_berat="+total_berat+"&jml_pisau="+jml_pisau+"&jml_mother="+jml_mother+"&id_customer="+id_customer+"&idmaterial="+idmaterial+"&berat="+berat+"&density="+density+"&thickness="+thickness+"&lebar="+lebar+"&panjang="+panjang+"&lebarnew="+lebarnew+"&qty="+qty+"&pegangan="+pegangan+"&sisa="+sisa+"&jmlpisau="+jmlpisau+"&harga="+harga+"&id="+id,
            success:function(html){
               $('#tpanjang_slot').html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/CariMCoils',
            data:"lotno="+lotno+"&total_panjang="+total_panjang+"&total_berat="+total_berat+"&jml_pisau="+jml_pisau+"&jml_mother="+jml_mother+"&id_customer="+id_customer+"&idmaterial="+idmaterial+"&berat="+berat+"&density="+density+"&thickness="+thickness+"&lebar="+lebar+"&panjang="+panjang+"&lebarnew="+lebarnew+"&qty="+qty+"&pegangan="+pegangan+"&sisa="+sisa+"&jmlpisau="+jmlpisau+"&harga="+harga+"&id="+id,
            success:function(html){
               $('#mother_slot').html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/CariJPisau',
            data:"lotno="+lotno+"&total_panjang="+total_panjang+"&total_berat="+total_berat+"&jml_pisau="+jml_pisau+"&jml_mother="+jml_mother+"&id_customer="+id_customer+"&idmaterial="+idmaterial+"&berat="+berat+"&density="+density+"&thickness="+thickness+"&lebar="+lebar+"&panjang="+panjang+"&lebarnew="+lebarnew+"&qty="+qty+"&pegangan="+pegangan+"&sisa="+sisa+"&jmlpisau="+jmlpisau+"&harga="+harga+"&id="+id,
            success:function(html){
               $('#jpisau_slot').html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/CariTBProduk',
            data:"lotno="+lotno+"&total_panjang="+total_panjang+"&total_berat="+total_berat+"&jml_pisau="+jml_pisau+"&jml_mother="+jml_mother+"&id_customer="+id_customer+"&idmaterial="+idmaterial+"&berat="+berat+"&density="+density+"&thickness="+thickness+"&lebar="+lebar+"&panjang="+panjang+"&lebarnew="+lebarnew+"&qty="+qty+"&pegangan="+pegangan+"&sisa="+sisa+"&jmlpisau="+jmlpisau+"&harga="+harga+"&id="+id,
            success:function(html){
               $('#tberat_slot').html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/HitungWaktu',
            data:"lotno="+lotno+"&total_panjang="+total_panjang+"&total_berat="+total_berat+"&jml_pisau="+jml_pisau+"&jml_mother="+jml_mother+"&id_customer="+id_customer+"&idmaterial="+idmaterial+"&berat="+berat+"&density="+density+"&thickness="+thickness+"&lebar="+lebar+"&panjang="+panjang+"&lebarnew="+lebarnew+"&qty="+qty+"&pegangan="+pegangan+"&sisa="+sisa+"&jmlpisau="+jmlpisau+"&harga="+harga+"&id="+id,
            success:function(html){
               $('#group_waktu').html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/HitungTWaktu',
            data:"waktu="+waktu+"&total_waktu="+total_waktu,
            success:function(html){
               $('#twaktu_slot').html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/HitungBiaya',
            data:"lotno="+lotno+"&total_panjang="+total_panjang+"&total_berat="+total_berat+"&jml_pisau="+jml_pisau+"&jml_mother="+jml_mother+"&id_customer="+id_customer+"&idmaterial="+idmaterial+"&berat="+berat+"&density="+density+"&thickness="+thickness+"&lebar="+lebar+"&panjang="+panjang+"&lebarnew="+lebarnew+"&qty="+qty+"&pegangan="+pegangan+"&sisa="+sisa+"&jmlpisau="+jmlpisau+"&harga="+harga+"&id="+id,
            success:function(html){
               $('#group_biaya').html(html);
            }
        });
	}
	function HitungPanjang(id){
	    var berat=$('#dt_berat_'+id).val();
		var density=$('#dt_density_'+id).val();
		var thickness=$('#dt_thickness_'+id).val();
		var lebar=$('#dt_lebar_'+id).val();
		var panjang=$('#dt_panjang_'+id).val();
		var lebarnew=$('#dt_lebarnew_'+id).val();
		var qty=$('#dt_qty_'+id).val();
		var pegangan=$('#dt_pegangan_'+id).val();
		var sisa=$('#dt_sisa_'+id).val();
		var jmlpisau=$('#dt_jmlpisau_'+id).val();
		var waktu=$('#dt_waktu_'+id).val();
		var harga=$('#dt_harga_'+id).val();
		var profit=$('#dt_profit_'+id).val();
		var totalpenawaran=$('#dt_totalpenawaran_'+id).val();
		var hargadeal=$('#dt_hargadeal_'+id).val();
		var total_panjang=$('#total_panjang').val();
		
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/HitungPanjang',
            data:"berat="+berat+"&density="+density+"&thickness="+thickness+"&hargadeal="+hargadeal+"&totalpenawaran="+totalpenawaran+"&profit="+profit+"&harga="+harga+"&pegangan="+pegangan+"&waktu="+waktu+"&jmlpisau="+jmlpisau+"&sisa="+sisa+"&lebar="+lebar+"&panjang="+panjang+"&lebarnew="+lebarnew+"&qty="+qty+"&id="+id,
            success:function(html){
               $('#panjang_'+id).html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/HitungPegangan',
            data:"berat="+berat+"&density="+density+"&thickness="+thickness+"&hargadeal="+hargadeal+"&totalpenawaran="+totalpenawaran+"&profit="+profit+"&harga="+harga+"&pegangan="+pegangan+"&waktu="+waktu+"&jmlpisau="+jmlpisau+"&sisa="+sisa+"&lebar="+lebar+"&panjang="+panjang+"&lebarnew="+lebarnew+"&qty="+qty+"&id="+id,
            success:function(html){
               $('#pegangan_'+id).html(html);
            }
        });
		
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/HitungWaktuSatuan',
            data:"berat="+berat+"&density="+density+"&thickness="+thickness+"&hargadeal="+hargadeal+"&totalpenawaran="+totalpenawaran+"&profit="+profit+"&harga="+harga+"&pegangan="+pegangan+"&waktu="+waktu+"&jmlpisau="+jmlpisau+"&sisa="+sisa+"&lebar="+lebar+"&panjang="+panjang+"&lebarnew="+lebarnew+"&qty="+qty+"&id="+id,
            success:function(html){
               $('#waktu_'+id).html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/HitungHargaSatuan',
            data:"berat="+berat+"&density="+density+"&thickness="+thickness+"&hargadeal="+hargadeal+"&totalpenawaran="+totalpenawaran+"&profit="+profit+"&harga="+harga+"&pegangan="+pegangan+"&waktu="+waktu+"&jmlpisau="+jmlpisau+"&sisa="+sisa+"&lebar="+lebar+"&panjang="+panjang+"&lebarnew="+lebarnew+"&qty="+qty+"&id="+id,
            success:function(html){
               $('#harga_'+id).html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/HitungPisauSatuan',
            data:"berat="+berat+"&density="+density+"&thickness="+thickness+"&hargadeal="+hargadeal+"&totalpenawaran="+totalpenawaran+"&profit="+profit+"&harga="+harga+"&pegangan="+pegangan+"&waktu="+waktu+"&jmlpisau="+jmlpisau+"&sisa="+sisa+"&lebar="+lebar+"&panjang="+panjang+"&lebarnew="+lebarnew+"&qty="+qty+"&id="+id,
            success:function(html){
               $('#pisau_'+id).html(html);
            }
        });

		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/HitungTotalPanjangSatuan',
            data:"berat="+berat+"&density="+density+"&thickness="+thickness+"&hargadeal="+hargadeal+"&totalpenawaran="+totalpenawaran+"&profit="+profit+"&harga="+harga+"&pegangan="+pegangan+"&waktu="+waktu+"&jmlpisau="+jmlpisau+"&sisa="+sisa+"&lebar="+lebar+"&panjang="+panjang+"&lebarnew="+lebarnew+"&qty="+qty+"&id="+id,
            success:function(html){
               $('#totalpenawaran_'+id).html(html);
            }
        });
		
		

	}
</script>
