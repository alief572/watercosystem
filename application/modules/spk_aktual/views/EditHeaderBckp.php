<?php
	$tanggal = date('Y-m-d');
foreach ($results['tr_spk'] as $tr_spk){
	
	
	}
	$get_stocklot = $this->db->get_where('stock_material',array('id_stock'=>$tr_spk->id_stock))->result();

?>

 <div class="box box-primary">
    <div class="box-body">
		<form id="data-form" method="post">
			<div class="col-sm-12">
				<div class="input_fields_wrap2">
			<div class="row">
		<center><label for="customer" ><h3>Aktual Produksi</h3></label></center>
		<div class='form-group row'>
			<label class='label-control col-sm-2'><b>Tanggal Produksi <span class='text-red'>*</span></b></label>
			<div class='col-sm-2'>
				<input type="text" name="date_production" id="date_production" class="form-control input-sm datepicker" placeholder="Tanggal Produksi" readonly />
			</div>
		</div>
		
        <div class="form-group row" >
		<div class="col-sm-12">
			<label>A.Material</label>
			<table class='table table-bordered table-striped'>
			<thead>
			<tr class='bg-blue'>
			<th width='3%' hidden>ID Stok</th>
			<th width='15%'>No Lot</th>
			<th width='10%'>Material</th>
			<th width='10%'>Berat Mother Coil</th>
			<th width='5%'>Thickness</th>
			<th width='5%'>Density</th>
			<th width='5%'>Panjang Master Coil</th>
			<th width='7%'>Width Mother Coil</th>
			</tr>
			</thead>
			<tbody>
		<tr>
		<th hidden><input type='text' class='form-control'  value='<?= $tr_spk->no_surat?>' 	readonly id='no_surat' required name='no_surat'></th>
		<th hidden><input type='text' class='form-control'  value='<?= $tr_spk->id_spkproduksi?>' 	readonly id='id_spk_aktual' required name='id_spk_aktual'></th>
		<th hidden><input type='text' class='form-control'  value='<?= $tr_spk->id_stock?>' 	readonly id='id_stock' required name='id_stock'></th>
		<th><input type='text' class='form-control'  	   	value='<?= $get_stocklot[0]->lotno?>' 	readonly id='lotno' required name='lotno'></th>
		<th hidden><input type='text' class='form-control'  value='<?= $tr_spk->id_material?>' 	readonly id='id_material' required name='id_material'></th>
		<th><input type='text' class='form-control'  	   	value='<?= $tr_spk->nama_material?>' 	readonly id='nama_material' required name='nama_material'></th>
		<th><input type='text' class='form-control weight' 		value='<?= $tr_spk->weight?>'  	readonly id='weight' required name='weight'></th>
		<th><input type='text' class='form-control'   		value='<?= $tr_spk->thickness?>'	readonly id='thickness' required name='thickness'></th>
		<th><input type='text' class='form-control'   		value='<?= $tr_spk->density?>'	readonly id='density' required name='density'></th>
		<th><input type='text' class='form-control'  		value='<?= $tr_spk->panjang?>' 	readonly id='panjang'  required name='panjang'></th>
		<th><input type='text' class='form-control'   		value='<?= $tr_spk->width?>' 	readonly id='width'  required name='width'></th>
			
		</tr>
			</tbody>
			</table>
		</div>
		</div>
		
		<div class="form-group row" >
		<div class="col-sm-12">
			<label>B.Produksi</label>
			<table class='table table-bordered table-striped'>
			<thead>
			<tr class='bg-blue'>
			<th rowspan='2'width='3%'>No</th>
			<th rowspan='2'width='7%'>SPK Marketing</th>
			<th rowspan='2'width='7%'>Customer</th>
			<th rowspan='2'width='7%'>Nomor Alloy</th>
			<th rowspan='2'width='5%'>Thickness</th>
			<th rowspan='2'width='5%'>Width</th>
			<th class='text-center' rowspan='2'width='5%'>#</th>
			<th colspan='2' >@Coil</th>
			<th colspan='2' >Total Weight<Total weight/th>
			<th rowspan='2' width='7%'>Delivery Date</th>
			<th rowspan='2' width='7%'>Lot Slitting</th>
			</tr>
						<tr class='bg-blue'>
			<th width='5%'>Request</th>
			<th width='5%'>Aktual</th>
			<th width='5%'>Request<Total weight/th>
			<th width='5%'>Aktual<Total weight/th>
			</tr>
			</thead>
			<tbody id="list_spk">
			<?php $loop=0;
			foreach ($results['dt_spk'] as $dt_spk){$loop++; 
			$surat = $dt_spk->no_surat;
			$nosurat = $this->db->query("SELECT a.*, b.no_surat as no_surat FROM dt_spkmarketing as a INNER JOIN tr_spk_marketing as b ON a.id_spkmarketing = b.id_spkmarketing WHERE a.id_dt_spkmarketing='$surat' ")->row();

			$spkmar = 'NONSPK';
			if($surat <> 'nonspk'){
				$spkmar = $nosurat->no_surat;
			}
		echo "
		<tr id='tr_$loop'>
			<th>$loop</th>
			<th ><input type='text' class='form-control' 	value='$spkmar' 	readonly id='used_nosurat_$loop' required name='dt[$loop][nosurat]'></th>
			<th hidden><input type='text' class='form-control' 	value='$dt_spk->idcustomer' 	readonly id='used_idcustomer_$loop' required name='dt[$loop][idcustomer]'></th>
			<th><input type='text' class='form-control'  	   	value='$dt_spk->name_customer' 	readonly id='used_namacustomer_$loop' required name='dt[$loop][namacustomer]'></th>
			<th><input type='text' class='form-control' 		value='$dt_spk->nmmaterial'  	readonly id='used_nmmaterial_$loop' required name='dt[$loop][nmmaterial]'></th>
			<th><input type='number' class='form-control' 		value='$dt_spk->thickness' 		readonly id='used_thickness_$loop' required name='dt[$loop][thickness]'></th>
			<th><input type='number' class='form-control'   		value='$dt_spk->weight' 		readonly id='used_weight_$loop' required name='dt[$loop][weight]'></th>

			<th class='text-center'>
				<button type='button' class='btn btn-sm btn-success' title='Add' data-role='qtip'  onclick='addinput($loop)'>Add</button>
				<button type='button' class='btn btn-sm btn-danger' title='Delete' data-role='qtip'  onclick='removeinput($loop)'>Del</button>
			</th>
					
			<th>
				<input type='number' class='form-control' value='$dt_spk->qtycoil' readonly id='used_qtycoil_$loop' onkeyup='HitungTotalCoil($loop)' required name='dt[$loop][qtycoil]'>
			</th>
			
			";
			
			$id = $dt_spk->id_dt_spk_aktual;
			$detail = $this->db->query("SELECT a.* FROM dt_spk_aktual_detail as a  WHERE a.id_dt_spk_aktual='$id' ")->result();
			
			
			//foreach ($detail as $dtaktual){
				
			echo "<th class='clone_tr2$loop'>
				<div class='clone_here2$loop'>
					<input type='number' class='form-control'  		value='$dt_spk->qtycoil' 		 id='used_qtyaktual_$loop' onkeyup='HitungTotalCoil($loop)' required name='dt[$loop][qtyaktual][]'>
				</div>
			</th>
			<th hidden class='clone_tr3$loop'>
				<div class='clone_here3$loop'>
					<input type='number' class='form-control'   		value='$dt_spk->width' 			readonly id='used_width_$loop' onkeyup='HitungTotalCoil($loop)' required name='dt[$loop][width][]'>
				</div>
			</th>
			<th class='clone_tr4$loop'>
				<div class='clone_here4$loop'>
					<input type='number' class='form-control'  		value='$dt_spk->totalwidth' 	readonly id='used_totalwidth_$loop' required name='dt[$loop][totalwidth][]'>
				</div>
			</th>
			<th class='clone_tr5$loop'>
				<div class='clone_here5$loop'>
					<input type='text' class='form-control dt_width autoNumeric'  		value='$dt_spk->totalwidth' 	 id='used_totalaktual_$loop' required name='dt[$loop][totalaktual][]'>
				</div>
			</th>
			<th class='clone_tr6$loop'>
				<div class='clone_here6$loop'>
					<input type='text' class='form-control datepicker' readonly   		value='$dt_spk->delivery' 		readonly id='used_delivery_$loop' required name='dt[$loop][delivery][]'>
				</div>
			</th>
			<th class='clone_tr7$loop'>
				<div class='clone_here7$loop'>
					<input type='text' class='form-control'   		value=''                         id='lot_slitting_$loop' required name='dt[$loop][lot_slitting][]'>
					<input type='hidden' class='form-control'   		value='$dt_spk->id_dt_spkproduksi' id='id_dt_spkproduksi_$loop' required name='dt[$loop][id_dt_spkproduksi][]'>
				</div>
			</th>
		</tr>
		";
			}
			?>
			</tbody>
			</table>
			</div>
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
		<div class="col-sm-12" hidden>
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="no_penawaran">Terpakai</label>
				</div>
				<div class="col-md-8" id="slot_jpisau">
				<input type='number' class='form-control' id='terpakai' value="<?= $tr_spk->used ?>" onkeyup required name='terpakai' readonly >
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
			</div>
		</div>
		</div>
		<div class="col-sm-12">
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="no_penawaran">Lebar Planing</label>
				</div>
				<div class="col-md-8" id="slot_sisa">
				<input type='number' class='form-control' id='lsisa_planing' value="<?= $tr_spk->sisa ?>" onkeyup required name='lsisa_planing' readonly >
			</div>
			</div>
		</div>
				<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="no_penawaran">Berat Planing</label>
				</div>
				<div class="col-md-8" id="slot_sisa">
				<input type='number' class='form-control' id='bsisa_planing' value="<?= $tr_spk->sisa*$tr_spk->density*$tr_spk->thickness*$tr_spk->panjang/1000 ?>" onkeyup required name='bsisa_planing' readonly >
			</div>
			</div>
		</div>	
		</div>
				<div class="col-sm-12">
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="no_penawaran">Lebar Aktual</label>
				</div>
				<div class="col-md-8" id="slot_sisa">
				<input type='number' class='form-control' id='lsisa_aktual' onkeyup required name='lsisa_aktual'  >
			</div>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="no_penawaran">Berat Aktual</label>
				</div>
				<div class="col-md-8" id="slot_sisa">
				<input type='number' class='form-control' value="0" id='bsisa_aktual' onkeyup required name='bsisa_aktual'  >
			</div>
			</div>
		</div>	
		</div>
		<div class="col-sm-12">
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="no_penawaran">SCRAP</label>
				</div>
			</div>
		</div>
		</div>
		<div class="col-sm-12">
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="no_penawaran">Lebar Planing</label>
				</div>
				<div class="col-md-8" id="slot_sisa">
				<input type='number' class='form-control' id='lscrap_planing' value="<?= $tr_spk->lpegangan ?>" onkeyup required name='lscrap_planing' readonly >
			</div>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="no_penawaran">Berat Planing</label>
				</div>
				<div class="col-md-8" id="slot_sisa">
				<input type='number' class='form-control' id='bscrap_planing' value="<?=  $tr_spk->lpegangan*$tr_spk->density*$tr_spk->thickness*$tr_spk->panjang/1000 ?>" onkeyup required name='bscrap_planing' readonly >
			</div>
			</div>
		</div>	
		</div>
				<div class="col-sm-12">
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="no_penawaran">Lebar Aktual</label>
				</div>
				<div class="col-md-8" id="slot_sisa">
				<input type='number' class='form-control' id='lscrap_aktual'  onkeyup required name='lscrap_aktual'  >
			</div>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="no_penawaran">Berat Aktual</label>
				</div>
				<div class="col-md-8" id="slot_sisa">
				<input type='number' class='form-control' id='bscrap_aktual' value="0" onkeyup required name='bscrap_aktual'  >
			</div>
			</div>
		</div>	
		</div>
		
		<!-- Tambahan -->
		<div class="col-sm-12 ngIN">
			<div class="col-sm-12 ngINApp">
				<div class="form-group row">
					<div class="col-md-2">
						<label class="text-red">NG INTERNAL</label>
					</div>
					<div class="col-md-2">
						<input type='text' class='form-control autoNumeric' name='ngin_lebar[]' placeholder='Lebar' >
					</div>
					<div class="col-md-2">
						<input type='text' class='form-control autoNumeric BeratAuto' name='ngin_berat[]' placeholder='Berat' >
					</div>
					<div class="col-md-2">
						<input type='text' class='form-control ket' name='ngin_ket[]' placeholder='Keterangan' >
					</div>
					<div class="col-md-3">
						<input type='file' class='form-control file' name='ngin_upload[]' placeholder='Upload' >
					</div>
					<div class="col-md-1">
						<button type='button' class='btn btn-sm btn-success add_ngin'><i class='fa fa-plus'></i></button>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-12 ngEK">
			<div class="col-sm-12 ngEKApp">
				<div class="form-group row">
					<div class="col-md-2">
						<label class="text-red">NG EKSTERNAL</label>
					</div>
					<div class="col-md-2">
						<input type='text' class='form-control autoNumeric' name='ngek_lebar[]' placeholder='Lebar' >
					</div>
					<div class="col-md-2">
						<input type='text' class='form-control autoNumeric BeratAuto' name='ngek_berat[]' placeholder='Berat' >
					</div>
					<div class="col-md-2">
						<input type='text' class='form-control' name='ngek_ket[]' placeholder='Keterangan' >
					</div>
					<div class="col-md-3">
						<input type='file' class='form-control' name='ngek_upload[]' placeholder='Upload' >
					</div>
					<div class="col-md-1">
						<button type='button' class='btn btn-sm btn-success add_ngek'><i class='fa fa-plus'></i></button>
					</div>
				</div>
			</div>
		</div>
		
		<div class="col-sm-12">
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="balance">DIFFERENCE</label>
				</div>
			</div>
		</div>
		</div>
		<div class="col-sm-12">
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="balance">Difference</label>
				</div>
				<div class="col-md-8" id="selisih">
				<input type='number' class='form-control balance' id='balance' value="0" name='balance' readonly >
			</div>
			</div>
		</div>
		</div>
			<center>
		<button type="submit" class="btn btn-success btn-sm" name="save" id="simpan-com"><i class="fa fa-save"></i>Simpan</button>
		<a class="btn btn-danger btn-sm" href="<?= base_url('/spk_aktual/') ?>"  title="Edit">Kembali</a>
			</center>
				 </div>
			</div>
		</form>		  
	</div>
</div>	
	
<style>
	.select2 {
		width:100%!important;
	}
	.datepicker{
		cursor: pointer;
	}
</style>			  
				  
				  
<script type="text/javascript">
	//$('#input-kendaraan').hide();
	var base_url			= '<?php echo base_url(); ?>';
	var active_controller	= '<?php echo($this->uri->segment(1)); ?>';
	$(document).ready(function(){	
			var max_fields2      = 10; //maximum input boxes allowed
			var wrapper2         = $(".input_fields_wrap2"); //Fields wrapper
			var add_button2      = $(".add_field_button2"); //Add button ID	
			$('.select2').select2();
				$('.autoNumeric').autoNumeric();
				$('.datepicker').datepicker({
					dateFormat: 'yy-mm-dd',
					changeMonth:true,
					changeYear:true,
				});

	$('#simpan-com').click(function(e){
			e.preventDefault();
			var deskripsi	= $('#deskripsi').val();
			var image		= $('#image').val();
			var idtype		= $('#inventory_1').val();
			var date_production = $('#date_production').val();
			var lsisa_aktual = $('#lsisa_aktual').val();
			
			if (date_production == '') {
				swal({
					title: "Warning!",
					text: "Tanggal Produksi masih kosong!",
					type: "warning",
					timer: 3000
				});
				return false;
			}
			
			if (lsisa_aktual == '') {
				swal({
					title: "Warning!",
					text: "Lebar aktual masih kosong!",
					type: "warning",
					timer: 3000
				});
				return false;
			
			
			var data, xhr;
			// if ($('#balance').val() != "0") {
			// if (getNum($('#balance').val()) >= 0.1 || getNum($('#balance').val()) < 0) {
            // swal({
                // title: "BALANCE BELUM NOL!",
                // text: "SILAHKAN PERBAIKI DATA ANDA!",
                // type: "warning",
                // timer: 3000,
                // showCancelButton: false,
                // showConfirmButton: false,
                // allowOutsideClick: false
            // });
            // 
			
			} else {
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
						var baseurl=siteurl+'spk_aktual/SaveEditHeader';
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
			
		}
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
	
$(document).on('keyup', '.dt_width', function() {

    totalBalanced()
   
});
$(document).on('blur', '#bsisa_aktual', function() {

    totalBalanced()
   
});
$(document).on('blur', '#bscrap_aktual', function() {

    totalBalanced()
   
});

	$(document).on('keyup', '.BeratAuto', function() {
		totalBalanced()
	});

	function totalBalanced(){
		var material = $('.weight').val();
		// var width    = $('.dt_width').val();
		var sisa     = $('#bsisa_aktual').val();
		var scrap    = $('#bscrap_aktual').val();
		var SUMx = 0;
		$(".dt_width" ).each(function() {
			SUMx += Number($(this).val().split(",").join(""));
		});
		
		let SUM_ng = 0;
		$(".BeratAuto" ).each(function() {
			SUM_ng += Number($(this).val().split(",").join(""));
		});

		var totalBalance = getNum(material) - SUMx - getNum(sisa) - getNum(scrap) - SUM_ng;
		
		$('.balance').val(number_format(totalBalance,2));
	}
	
	function addinput(id){
		$(".datepicker").datepicker('destroy');

		// $(".clone_here1"+id).last().clone().appendTo(".clone_tr1"+id);
		$(".clone_here2"+id).last().clone().appendTo(".clone_tr2"+id);
		$(".clone_here3"+id).last().clone().appendTo(".clone_tr3"+id);
		$(".clone_here4"+id).last().clone().appendTo(".clone_tr4"+id);
		$(".clone_here5"+id).last().clone().appendTo(".clone_tr5"+id);
		$(".clone_here6"+id).last().clone().appendTo(".clone_tr6"+id);
		$(".clone_here7"+id).last().clone().appendTo(".clone_tr7"+id);

		$(".datepicker").datepicker();
		totalBalanced();
		$('.autoNumeric').autoNumeric();
		
	}

	function removeinput(id){
		// $(".clone_here1"+id).last().remove();
		$(".clone_here2"+id).last().remove();
		$(".clone_here3"+id).last().remove();
		$(".clone_here4"+id).last().remove();
		$(".clone_here5"+id).last().remove();
		$(".clone_here6"+id).last().remove();
		$(".clone_here7"+id).last().remove();
		totalBalanced();
	}
	
	function getNum(val) {
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

	
	//CLONE
	$(document).on('click','.add_ngin', function(){
		var temp = "<div class='col-sm-12 ngINApp'>";
		 	temp += "			<div class='form-group row'>";
		 	temp += "				<div class='col-md-2'>";
		 	temp += "					<label></label>";
		 	temp += "				</div>";
		 	temp += "		<div class='col-md-2'>";
		 	temp += "			<input type='text' class='form-control autoNumeric' name='ngin_lebar[]' placeholder='Lebar'>";
		 	temp += "		</div>";
		 	temp += "		<div class='col-md-2'>";
		 	temp += "			<input type='text' class='form-control autoNumeric BeratAuto' name='ngin_berat[]' placeholder='Berat'>";
		 	temp += "		</div>";
		 	temp += "		<div class='col-md-2'>";
		 	temp += "			<input type='text' class='form-control ket' name='ngin_ket[]' placeholder='Keterangan'>";
			temp += "		</div>";
		 	temp += "		<div class='col-md-3'>";
		 	temp += "			<input type='file' class='form-control file' name='ngin_upload[]' placeholder='Upload'>";
		 	temp += "		</div>";
		 	temp += "		<div class='col-md-1'>";
		 	// temp += "			<button type='button' class='btn btn-sm btn-success add_ngin'><i class='fa fa-plus'></i></button>";
		 	temp += "			<button type='button' class='btn btn-sm btn-danger deletex'=''><i class='fa fa-trash'></i></button>";
			temp += "		</div>";
			temp += "	</div>";
		 	temp += "</div>";

		$(this).parent().parent().parent().after(temp);
		$('.autoNumeric').autoNumeric();
	});

	$(document).on('click','.add_ngek', function(){
		var temp = "<div class='col-sm-12 ngEKApp'>";
		 	temp += "			<div class='form-group row'>";
		 	temp += "				<div class='col-md-2'>";
		 	temp += "					<label></label>";
		 	temp += "				</div>";
		 	temp += "		<div class='col-md-2'>";
		 	temp += "			<input type='text' class='form-control autoNumeric' name='ngek_lebar[]' placeholder='Lebar'>";
		 	temp += "		</div>";
		 	temp += "		<div class='col-md-2'>";
		 	temp += "			<input type='text' class='form-control autoNumeric BeratAuto' name='ngek_berat[]' placeholder='Berat'>";
		 	temp += "		</div>";
		 	temp += "		<div class='col-md-2'>";
		 	temp += "			<input type='text' class='form-control ket' name='ngek_ket[]' placeholder='Keterangan'>";
			temp += "		</div>";
		 	temp += "		<div class='col-md-3'>";
		 	temp += "			<input type='file' class='form-control file' name='ngek_upload[]' placeholder='Upload'>";
		 	temp += "		</div>";
		 	temp += "		<div class='col-md-1'>";
		 	// temp += "			<button type='button' class='btn btn-sm btn-success add_ngek'><i class='fa fa-plus'></i></button>";
		 	temp += "			<button type='button' class='btn btn-sm btn-danger deletex'=''><i class='fa fa-trash'></i></button>";
			temp += "		</div>";
			temp += "	</div>";
		 	temp += "</div>";

		$(this).parent().parent().parent().after(temp);
		$('.autoNumeric').autoNumeric();
	});

	$(document).on('click','.deletex', function(){
		$(this).parent().parent().parent().remove();
	});
	
</script>