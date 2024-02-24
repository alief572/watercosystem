<?php
    $ENABLE_ADD     = has_permission('Trans_inquiry.Add');
    $ENABLE_MANAGE  = has_permission('Trans_inquiry.Manage');
    $ENABLE_VIEW    = has_permission('Trans_inquiry.View');
    $ENABLE_DELETE  = has_permission('Trans_inquiry.Delete');
	$tanggal = date('Y-m-d');
	foreach ($results['header'] as $header){
	}
	$pic	= $this->db->query("SELECT * FROM child_customer_pic WHERE id_customer = '$header->id_customer' ")->result();
?>
<style>
.modal-dialog{
	width:90%
}
</style>
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
				<input type="text" class="form-control" disabled id="id_slitting" value="<?= $header->id_slitting?>" required name="id_slitting" readonly placeholder="No.CRCL">
			</div>
			<div class="col-md-8">
				<input type="text" class="form-control" disabled id="no_surat" value="<?= $header->no_surat?>" required name="no_surat" readonly placeholder="No.Penawaran">
			</div>
		</div>
		</div>
		<div class="col-sm-6">
		<div class="form-group row">
			<div class="col-md-4">
				<label for="customer">Tanggal</label>
			</div>
			<div class="col-md-8">
				<input type="date" class="form-control" disabled id="tgl_penawaran" value="<?= $header->tgl_penawaran?>" onkeyup required name="tgl_penawaran" readonly >
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
					<select id="id_customer" name="id_customer" disabled class="form-control"required>
						<option value="">--Pilih--</option>
							<?php foreach ($results['customers'] as $customers){
								$select = $header->id_customer == $customers->id_customer ? 'selected' : '';
								?>
						<option value="<?= $customers->id_customer?>" <?= $select ?>><?= ucfirst(strtolower($customers->name_customer))?></option>
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
					<select id="mata_uang" name="mata_uang" disabled class="form-control select" required>
						<?php
						if($header->mata_uang == 'IDR'){
							echo"
						<option value=''>--Pilih--</option>
						<option value='IDR' selected>IDR(Rupiah)</option>
						<option value='USD'>USD(Dolar)</option>";
						}if($header->mata_uang == 'USD'){
							echo"
						<option value=''>--Pilih--</option>
						<option value='IDR' >IDR(Rupiah)</option>
						<option value='USD' selected>USD(Dolar)</option>";
						}else{
							echo"
						<option value=''>--Pilih--</option>
						<option value='IDR'>IDR(Rupiah)</option>
						<option value='USD'>USD(Dolar)</option>";
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
					<label for="id_customer">PIC CUSTOMER</label>
				</div>
				<div class="col-md-8" id='list_pic'>
					<select id="pic_cutomer" name="pic_cutomer" disabled class="form-control"required>
						<option value="">--Pilih--</option>
						<?php foreach ($pic as $pic){
								$select = $header->pic_customer == $pic->name_pic? 'selected' : '';
								?>
						<option value="<?= $pic->name_pic?>"<?= $select ?>><?= ucfirst(strtolower($pic->name_pic))?></option>
							<?php } ?>
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
				<input type="date" class="form-control" value="<?= $header->valid_until?>" disabled id="valid_until"  required name="valid_until" >
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
			<th hidden >No. Lot</th>
			<th width='9%'>Nama Material</th>
			<th width='5%'>Berat Coil</th>
			<th width='5%'>Density</th>
			<th width='5%'>Thickness</th>
			<th width='5%'>Lebar Material</th>
			<th width='5%'>Panjang Coil (M)</th>
			<th width='5%'>Lebar Request</th>
			<th width='5%'>Qty Coil</th>
			<th width='5%'>Pegangan Coil</th>
			<th width='5%'>Waste</th>
			<th width='5%'>Jumlah Pisau</th>
			<th width='5%' hidden>Waktu Proses</th>
			<th width='10%'>Biaya Proses</th>
			<th width='10%'>Profit</th>
			<th width='10%'>Harga Total</th>
			<th width='10%'>Harga Penawaran</th>
			</tr>
			</thead>
			<tbody id="stock_slot">
						<?php $loop=0;
			foreach ($results['detail'] as $detail){$loop++; 
		echo "
		<tr id='tr_$loop'>
		<th hidden><input type='text' 	disabled class='form-control' value='$detail->lotno' id='dt_lotno_$loop' required name='dt[$loop][lotno]'></th>
		<th hidden><select readonly class='form-control' id='dt_idmaterial_$loop' name='dt[$loop][idmaterial]'	onchange ='CariProperties($loop)'>
		<option value=''>--Pilih--</option>";
		foreach ($material as $material){
		$select = $material->id_category3 == $id_material? 'selected' : '';
		if($material->id_bentuk == 'B2000001' ){
		$dimensi = $this->db->query("SELECT * FROM child_inven_dimensi WHERE id_category3 = '$material->id_category3' AND id_dimensi = '22'")->result();
		$thickness = $dimensi[0]->nilai_dimensi;
		echo"<option value='$material->id_category3' $select >$material->bentuk $material->alloy $material->nama $material->hardness $thickness</option>";
		}elseif($material->id_bentuk == 'B2000002' ){
		$dimensi = $this->db->query("SELECT * FROM child_inven_dimensi WHERE id_category3 = '$material->id_category3' AND id_dimensi = '25' ")->result();
		$thickness = $dimensi[0]->nilai_dimensi;
		echo"<option value='$material->id_category3' $select >$material->bentuk $material->alloy $material->nama $material->hardness $thickness</option>";
		}elseif($material->id_bentuk == 'B2000003' ){
		$dimensi = $this->db->query("SELECT * FROM child_inven_dimensi WHERE id_category3 = '$material->id_category3' AND id_dimensi = '30' ")->result();
		$thickness = $dimensi[0]->nilai_dimensi;
		echo"<option value='$material->id_category3' $select >$material->bentuk $material->alloy $material->nama $material->hardness $thickness</option>";
		}elseif($material->id_bentuk == 'B2000004' ){
		$dimensi = $this->db->query("SELECT * FROM child_inven_dimensi WHERE id_category3 = '$material->id_category3' AND id_dimensi = '8' ")->result();
		$thickness = $dimensi[0]->nilai_dimensi;
		$dimensi2 = $this->db->query("SELECT * FROM child_inven_dimensi WHERE id_category3 = '$material->id_category3' AND id_dimensi = '9' ")->result();
		$thickness2 = $dimensi[0]->nilai_dimensi;
		echo"<option value='$material->id_category3' $select >$material->bentuk $material->alloy $material->nama $material->hardness $thickness x $thickness</option>";
		}elseif($material->id_bentuk == 'B2000005' ){
		$dimensi = $this->db->query("SELECT * FROM child_inven_dimensi WHERE id_category3 = '$material->id_category3' AND id_dimensi = '11' ")->result();
		$thickness = $dimensi[0]->nilai_dimensi;
		echo"<option value='$material->id_category3' $select >$material->bentuk $material->alloy $material->nama $material->hardness $thickness</option>";
		}elseif($material->id_bentuk == 'B2000006' ){
		$dimensi = $this->db->query("SELECT * FROM child_inven_dimensi WHERE id_category3 = '$material->id_category3' AND id_dimensi = '13' ")->result();
		$thickness = $dimensi[0]->nilai_dimensi;
		echo"<option value='$material->id_category3' $select >$material->bentuk $material->alloy $material->nama $material->hardness $thickness</option>";
		}elseif($material->id_bentuk == 'B2000007' ){
		$dimensi = $this->db->query("SELECT * FROM child_inven_dimensi WHERE id_category3 = '$material->id_category3' AND id_dimensi = '15' ")->result();
		$thickness = $dimensi[0]->nilai_dimensi;
		$dimensi2 = $this->db->query("SELECT * FROM child_inven_dimensi WHERE id_category3 = '$material->id_category3' AND id_dimensi = '16' ")->result();
		$thickness2 = $dimensi[0]->nilai_dimensi;
		echo"<option value='$material->id_category3' $select >$material->bentuk $material->alloy $material->nama $material->hardness $thickness $thickness2</option>";
		}elseif($material->id_bentuk == 'B2000009' ){
		$dimensi = $this->db->query("SELECT * FROM child_inven_dimensi WHERE id_category3 = '$material->id_category3' AND id_dimensi = '19' ")->result();
		$thickness = $dimensi[0]->nilai_dimensi;
		echo"<option value='$material->id_category3' $select >$material->bentuk $material->alloy $material->nama $material->hardness $thickness</option>";
		};
		};
		echo"</select></th>";
		echo"<th><input type='text' 	disabled class='form-control' value='$detail->nama_material' id='dt_nama_material_$loop' required name='dt[$loop][nama_material]'></th>
		<th><input type='number'disabled class='form-control' value='$detail->berat'  id='dt_berat_$loop' 							required name='dt[$loop][berat]' 		onkeyup='HitungPanjang($loop)'></th>
		<th><input type='number' disabled class='form-control' value='$detail->density' id='dt_density_$loop' 						required name='dt[$loop][density]' 		onkeyup='HitungPanjang($loop)'></th>
		<th><input type='number' disabled class='form-control' value='$detail->thickness' id='dt_thickness_$loop' 						required name='dt[$loop][thickness]' 	onkeyup='HitungPanjang($loop)'></th>
		<th><input type='text' 	disabled class='form-control' value='$detail->lebar' id='dt_lebar_$loop' 							required name='dt[$loop][lebar]' 		onkeyup='HitungPanjang($loop)'></th>
		<th><input type='text'	disabled class='form-control' value='$detail->panjang' id='dt_panjang_$loop' readonly 	required name='dt[$loop][panjang]'></th>
		<th><input type='text'	disabled class='form-control' value='$detail->lebarnew' id='dt_lebarnew_$loop' 							required name='dt[$loop][lebarnew]' 	onkeyup='HitungPanjang($loop)'></th>
		<th><input type='text'	disabled class='form-control' value='$detail->qty' id='dt_qty_$loop'						required name='dt[$loop][qty]'      	onkeyup='HitungPanjang($loop)'></th>
		<th><input type='text'	disabled class='form-control' value='$detail->pegangan' id='dt_pegangan_$loop' required name='dt[$loop][pegangan]'></th>
		<th><input type='text'	disabled class='form-control' value='$detail->sisa' id='dt_sisa_$loop' readonly required name='dt[$loop][sisa]'></th>
		<th><input type='text'	disabled class='form-control' value='$detail->jmlpisau' id='dt_jmlpisau_$loop' 	required name='dt[$loop][jmlpisau]' readonly></th>
		<th hidden><input type='text' disabled class='form-control' value='$detail->waktu' id='dt_waktu_$loop' 		required name='dt[$loop][waktu]' 	readonly	></th>
		<th><input type='text'	disabled class='form-control' value='$detail->harga' id='dt_harga_$loop' 		required name='dt[$loop][harga]' 	readonly	></th>
		<th><input type='text'	disabled class='form-control' value='$detail->profit' id='dt_profit_$loop' 							required name='dt[$loop][profit]' onkeyup='HitungPanjang($loop)'></th>
		<th><input type='text'	disabled class='form-control' value='$detail->totalpenawaran' id='dt_totalpenawaran_$loop' 	required name='dt[$loop][totalpenawaran]' readonly></th>
		<th><input type='text'	disabled class='form-control' value='$detail->hargadeal' sid='dt_hargadeal_$loop' 							required name='dt[$loop][hargadeal]'></th>
		
		</tr>
		";
			}
			?>s
			</tbody>
			<tbody>
			<tr class='bg-blue'>
			<th colspan='14s'>Total Biaya</th>

			<th id='slot_total_peawaran'><input type='number' disabled value="<?= $header->total_harga_penawaran?>"  class='form-control' id='total_harga_penawaran' readonly required name='total_harga_penawaran' ></th>
			</tr>
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
					<input type='number' class='form-control' disabled value="<?= $header->total_panjang?>"  id='total_panjang' readonly required name='total_panjang' >
			</div>
		</div>
		</div>
		<div class='col-sm-6'>
		<div class='form-group row'>
			<div class='col-md-4'>
				<label for='email_customer'>Jumlah Pisau</label>
			</div>
			<div class='col-md-8' id="jpisau_slot">
					<input type='number' class='form-control' disabled value="<?= $header->jml_pisau?>"   id='jml_pisau' readonly required name='jml_pisau' >
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
					<input type='number' class='form-control' disabled id='jml_mother' value="<?= $header->jml_mother?>"   readonly required name='jml_mother' >
			</div>
		</div>
		</div>
		<div class='col-sm-6'>
		<div class='form-group row'>
			<div class='col-md-4'>
				<label for='email_customer'>Total Berat Produk</label>
			</div>
			<div class='col-md-8' id="tberat_slot">
					<input type='number' class='form-control' disabled id='total_berat' value="<?= $header->total_berat?>" readonly required name='total_berat' >
			</div>
		</div>
		</div>
		</div>
		</div>
		</div>

		<div class='col-sm-12'>
		<div class='form-group row'>
			<center>
		
		<a class="btn btn-success btn-sm" href="<?= base_url('/penawaran_slitting/PrintHeader/'.$header->id_slitting) ?>" target="_blank" title="Edit">Cetak</a>
			</center>
				 </div>
			</div>

		</form>		  
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
						var baseurl=siteurl+'penawaran_slitting/SaveNewHeader';
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
               $('#slot_panjang_'+id).html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/HitungPegangan',
            data:"berat="+berat+"&density="+density+"&thickness="+thickness+"&hargadeal="+hargadeal+"&totalpenawaran="+totalpenawaran+"&profit="+profit+"&harga="+harga+"&pegangan="+pegangan+"&waktu="+waktu+"&jmlpisau="+jmlpisau+"&sisa="+sisa+"&lebar="+lebar+"&panjang="+panjang+"&lebarnew="+lebarnew+"&qty="+qty+"&id="+id,
            success:function(html){
               $('#slot_pegangan_'+id).html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/Hitungsisasatuan',
            data:"berat="+berat+"&density="+density+"&thickness="+thickness+"&hargadeal="+hargadeal+"&totalpenawaran="+totalpenawaran+"&profit="+profit+"&harga="+harga+"&pegangan="+pegangan+"&waktu="+waktu+"&jmlpisau="+jmlpisau+"&sisa="+sisa+"&lebar="+lebar+"&panjang="+panjang+"&lebarnew="+lebarnew+"&qty="+qty+"&id="+id,
            success:function(html){
               $('#slot_sisa_'+id).html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/HitungPisauSatuan',
            data:"berat="+berat+"&density="+density+"&thickness="+thickness+"&hargadeal="+hargadeal+"&totalpenawaran="+totalpenawaran+"&profit="+profit+"&harga="+harga+"&pegangan="+pegangan+"&waktu="+waktu+"&jmlpisau="+jmlpisau+"&sisa="+sisa+"&lebar="+lebar+"&panjang="+panjang+"&lebarnew="+lebarnew+"&qty="+qty+"&id="+id,
            success:function(html){
               $('#slot_pisau_'+id).html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/HitungWaktuSatuan',
            data:"berat="+berat+"&density="+density+"&thickness="+thickness+"&hargadeal="+hargadeal+"&totalpenawaran="+totalpenawaran+"&profit="+profit+"&harga="+harga+"&pegangan="+pegangan+"&waktu="+waktu+"&jmlpisau="+jmlpisau+"&sisa="+sisa+"&lebar="+lebar+"&panjang="+panjang+"&lebarnew="+lebarnew+"&qty="+qty+"&id="+id,
            success:function(html){
               $('#slot_waktu_'+id).html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/HitungHargaSatuan',
            data:"berat="+berat+"&density="+density+"&thickness="+thickness+"&hargadeal="+hargadeal+"&totalpenawaran="+totalpenawaran+"&profit="+profit+"&harga="+harga+"&pegangan="+pegangan+"&waktu="+waktu+"&jmlpisau="+jmlpisau+"&sisa="+sisa+"&lebar="+lebar+"&panjang="+panjang+"&lebarnew="+lebarnew+"&qty="+qty+"&id="+id,
            success:function(html){
               $('#slot_harga_'+id).html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/HitungTotalPanjangSatuan',
            data:"berat="+berat+"&density="+density+"&thickness="+thickness+"&hargadeal="+hargadeal+"&totalpenawaran="+totalpenawaran+"&profit="+profit+"&harga="+harga+"&pegangan="+pegangan+"&waktu="+waktu+"&jmlpisau="+jmlpisau+"&sisa="+sisa+"&lebar="+lebar+"&panjang="+panjang+"&lebarnew="+lebarnew+"&qty="+qty+"&id="+id,
            success:function(html){
               $('#slot_totalpenawaran_'+id).html(html);
            }
        });
		
		

	}
	function HitungSisa(id){
	    var pegangan=$('#dt_pegangan_'+id).val();
		var qty=$('#dt_qty_'+id).val();
		var lebar=$('#dt_lebar_'+id).val();
		var lebarnew=$('#dt_lebarnew_'+id).val();
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/HitungSisa',
            data:"lebarnew="+lebarnew+"&lebar="+lebar+"&qty="+qty+"&pegangan="+pegangan+"&id="+id,
            success:function(html){
               $('#slot_sisa_'+id).html(html);
            }
        });
	}
	function HitungQty(id){
		var lebar=$('#dt_lebar_'+id).val();
		var lebarnew=$('#dt_lebarnew_'+id).val();
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/HitungQty',
            data:"lebar="+lebar+"&lebarnew="+lebarnew+"&id="+id,
            success:function(html){
               $('#slot_qty_'+id).html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/HitungPisauNew',
            data:"lebar="+lebar+"&lebarnew="+lebarnew+"&id="+id,
            success:function(html){
               $('#slot_pisau_'+id).html(html);
            }
        });
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
		var id_customer=$('#id_customer').val();
		var total_harga_penawaran=$('#total_harga_penawaran').val();
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/LockDetail',
            data:"lotno="+lotno+"&nama_material="+nama_material+"&waktu="+waktu+"&profit="+profit+"&hargadeal="+hargadeal+"&totalpenawaran="+totalpenawaran+"&id_customer="+id_customer+"&idmaterial="+idmaterial+"&berat="+berat+"&density="+density+"&thickness="+thickness+"&lebar="+lebar+"&panjang="+panjang+"&lebarnew="+lebarnew+"&qty="+qty+"&pegangan="+pegangan+"&sisa="+sisa+"&jmlpisau="+jmlpisau+"&harga="+harga+"&id="+id,
            success:function(html){
               $('#tr_'+id).html(html);
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
            url:siteurl+'penawaran_slitting/HitungBiaya',
            data:"lotno="+lotno+"&total_panjang="+total_panjang+"&total_berat="+total_berat+"&jml_pisau="+jml_pisau+"&jml_mother="+jml_mother+"&id_customer="+id_customer+"&idmaterial="+idmaterial+"&berat="+berat+"&density="+density+"&thickness="+thickness+"&lebar="+lebar+"&panjang="+panjang+"&lebarnew="+lebarnew+"&qty="+qty+"&pegangan="+pegangan+"&sisa="+sisa+"&jmlpisau="+jmlpisau+"&harga="+harga+"&id="+id,
            success:function(html){
               $('#group_biaya').html(html);
            }
        });
	}
	function GetStock(){
	   	var id_customer=$('#id_customer').val();
		var jumlah	=$('#stock_slot').find('tr').length;

		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/GetStock',
            data:"id_customer="+id_customer+"&jumlah="+jumlah,
            success:function(html){
               $("#stock_slot").append(html);
            }
        });
	}

function HapusItem(id){
		$('#stock_slot #tr_'+id).remove();
		
	}
	function DeleteItem(id){
		$('#stock_slot #tr_'+id).remove();
		
	}
	
	
	
</script>