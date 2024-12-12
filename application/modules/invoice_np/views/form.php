<?php

$curency=array('USD'=>'USD','IDR'=>'IDR');
if(isset($results['data']->ppn_persen)){
	$ppn=$results['data']->ppn_persen;
}else{
	$ppn="0";
}
?>
<form action="#" method="POST" id="frm_data">
	<input type="hidden" name="id_invoice" value="<?=(isset($results['data']->id_invoice)?$results['data']->id_invoice:'')?>">
	<input type="hidden" name="no_invoice_old" value="<?=(isset($results['data']->no_invoice)?$results['data']->no_invoice:'')?>">
	<input type="hidden" id="nm_customer" name="nm_customer" value="<?=(isset($results['data']->nm_customer)?$results['data']->nm_customer:'')?>">
	<div class="box box-primary">
		<div class="box-header">
			<h3 class="box-title"></h3>
		</div>
		<!-- /.box-header -->
		<div class="box-body">
			<div class='form-group row'>
				<label class='label-control col-sm-2'><b>Nomor Invoice</b></label>
				<div class='col-sm-4'>
					<input type="text" class="form-control" id="no_invoice" name="no_invoice" value="<?php echo (isset($results['data']->no_invoice) ? $results['data']->no_invoice: ""); ?>">
				</div>
				<label class='label-control col-sm-2'><b>Tanggal Invoice</b></label>
				<div class='col-sm-4'>
					<input type="text" class="form-control tanggal" id="tgl_invoice" name="tgl_invoice" value="<?php echo (isset($results['data']->tgl_invoice) ? $results['data']->tgl_invoice: date("Y-m-d")); ?>" placeholder="Tanggal Invoice" required>
				</div>
			</div>
			<div class='form-group row'>
				<label class='label-control col-sm-2'><b>Customer</b></label>
				<div class='col-sm-4'>
					<select name="id_customer" id="id_customer" class="form-control select" placeholder="Customer" required>
					<?php
					echo '<option value="">Select an option</option>';
					foreach ($results['data_customer'] as $record){
						$selected='';
						if(isset($results['data']->id_customer)){
							if ($record->id_customer==$results['data']->id_customer) {
								$selected=' selected';
							}
						}
						echo '<option value="'.$record->id_customer.'" data-nm_customer="'.$record->name_customer.'" '.$selected.'>'.$record->name_customer.'</option>';
					}
					?>
					</select>
				</div>
				<label class='label-control col-sm-2'><b>Mata Uang</b></label>
				<div class='col-sm-4'>
					<select name="base_cur" id="base_cur" class="form-control" placeholder="Mata Uang" required>
						<?php
						foreach ($results['data_currency'] AS $kurs){
							$sel = ($kurs->kode == $kurs_mata_uang)?'selected':'';
							echo "<option value='".$kurs->kode."' ".$sel.">".$kurs->kode."</option>";
						}
						?>
					</select>
				</div>
			</div>
			<div class='form-group row'>
				<label class='label-control col-sm-2'><b>PPN</b></label>
				<div class='col-sm-2'>
					<div class="input-group">
					<input type="text" class="form-control" id="ppn_persen" name="ppn_persen" value="<?php echo $ppn; ?>" placeholder="PPN" required onblur="cektotal(0)">
					<span class="input-group-addon">%</span>
					</div>
				</div>
				<div class='col-sm-2'></div>
				<label class='label-control col-sm-2'><b>PPH</b></label>
				<div class='col-sm-2'>
					<div class="input-group">
					<input type="text" class="form-control" id="pph_persen" name="pph_persen" value="<?php echo (isset($results['data']->pph_persen) ? $results['data']->pph_persen: "0"); ?>" placeholder="PPH" required>
					<span class="input-group-addon">%</span>
					</div>					
				</div>
				<div class='col-sm-2'></div>
			</div>
			<div class='form-group row'>
				<label class='label-control col-sm-2'><b>Kategori</b></label>
				<div class='col-sm-4'>
					<select name="jenis_invoice" id="jenis_invoice" class="form-control" placeholder="Kategori" required>
					<?php
					$jenis_invoice='';
					echo '<option value="">Select an option</option>';
					if(!empty($results['data_category'])){
						foreach($results['data_category'] AS $record){
							$selected='';
							if(isset($results['data']->jenis_invoice)){
								if ($record->id==$results['data']->jenis_invoice) {
									$selected=' selected';
									$jenis_invoice=$results['data']->jenis_invoice;
								}
							}
							echo '<option value="'.$record->id.'" '.$selected.'>'.$record->nama.'</option>';
						}
					}
					?>
					</select>
				</div>
				<label class='label-control col-sm-2'><b>Keterangan</b></label>
				<div class='col-sm-4'>
					<input type="text" class="form-control" id="keterangan" name="keterangan" value="<?php echo (isset($results['data']->keterangan) ? $results['data']->keterangan: ""); ?>" placeholder="Keterangan">						
				</div>
			</div>
			<div class='form-group row'>
				<label class='label-control col-sm-2'><b>F. No Faktur</b></label>
				<div class='col-sm-4'>
					<input type="text" class="form-control" id="no_faktur" name="no_faktur" value="<?php echo (isset($results['data']->no_faktur) ? $results['data']->no_faktur: ""); ?>" placeholder="Nomor Faktur">						
				</div>
				<label class='label-control col-sm-2'><b>No Pajak</b></label>
				<div class='col-sm-4'>
					<input type="text" class="form-control" id="no_pajak" name="no_pajak" value="<?php echo (isset($results['data']->no_pajak) ? $results['data']->no_pajak: ""); ?>" placeholder="No Pajak">						
				</div>
			</div>

		</div>

        <!-- List product -->
		  <div class="box box-danger">
			<div class="box-header">
			  <h4 class="box-title"><label><i class="fa fa-list"></i> List Details</label></h4>
			</div>

			<div class="box-body">
			  <div class="table-responsive">
				<table class="table-bordered table-striped table-condensed table-responsive">
				  <thead>
					<tr class="bg-primary">
					  <th class="text-nowrap" width="1%">No.</th>
					  <th class="text-nowrap" width="10%">Keterangan</th>
					  <th class="text-center text-nowrap" width="5%">Qty</th>
					  <th class="text-center text-nowrap" width="10%">Satuan</th>
					  <th class="text-center text-nowrap" width="10%">Unit Price</th>
					  <th class="text-center text-nowrap" width="10%">Total Price</th>
					  <th width="2%">
						<button type="button" class="btn btn-success btn-xs stsview" href="javascript:void(0)" title="Tambah" onclick="add_detail()" id="add-material"><i class="fa fa-plus"></i> Tambah</button>
					  </th>
					</tr>
				  </thead>
					<tbody id="detail_body">
				<?php $total=0; $idd=1;$total_dpp_usd=0; $total_invoice_usd=0; $total_ppn_idr=0; $atrreadonly="";
				if(!empty($results['data_detail'])){
					foreach($results['data_detail'] AS $record){
						?>
						<tr id='tr1_<?=$idd?>' class='delAll'>
							<td><input type="hidden" name="detail_id[]" id="raw_id_<?=$idd?>" value="<?=$idd;?>" class="dtlloop"><?=$idd;?></td>
							<td data-header="Keterangan"><textarea class="form-control input-sm" name="desc[]" id="desc_<?=$idd;?>"><?=$record->desc;?></textarea>
							<?php
							if($jenis_invoice=='2'){
								echo '<div>';
								$atrreadonly=" readonly tabindex='-1' ";
							}else{
								echo '<div class="hidden">';
							}
								?>
							<input type='text' name='kd_aset[]' id='kd_aset_<?=$idd;?>' value='<?=$record->kd_aset;?>' class="asetloop form-control" readonly tabindex='-1' placeholder="Kode Aset">
							<input type='hidden' name='nilai_aset[]' id='nilai_aset_<?=$idd;?>' value='<?=$record->nilai_aset;?>'>
							<input type='text' name='nama_aset[]' id='nama_aset_<?=$idd;?>' value='<?=$record->nama_aset;?>' placeholder='Nama Aset' class='form-control' readonly tabindex='-1'>
							<button type='button' class='btn btn-success btn-xs stsview' title='Daftar Asset' onclick='list_asset(<?=$idd;?>)'><i class='fa fa-plus'></i> Daftar Asset</button></div>
							</td>
							<td data-header="Qty"><input type="text" class="form-control divide input-sm" name="qty[]" id="qty_<?=$idd;?>" value="<?=$record->qty;?>" onblur="cektotal(<?=$idd;?>)" size="15" style="width:60px;"<?=$atrreadonly?>></td>
							<td><input type="text" class="form-control input-sm" name="unit[]" id="unit_<?=$idd;?>" value="<?=$record->unit;?>"></td>
							<td data-header="Unit Price"><input type="text" class="form-control divide input-sm" name="harga_satuan_usd[]" id="harga_satuan_usd_<?=$idd;?>" value="<?=$record->harga_satuan_usd;?>" onblur="cektotal(<?=$idd;?>)"></td>
							<td data-header="Total Price"><input type="text" class="form-control divide input-sm subtotal" name="harga_total_usd[]" id="harga_total_usd_<?=$idd;?>" value="<?=$record->harga_total_usd;?>" onblur="cektotal(<?=$idd;?>)"></td>
							<td scope="row" align='center'><button type='button' class='btn btn-danger btn-xs stsview' data-toggle='tooltip' onClick='delDetail(<?=$idd?>)' title='Hapus data'><i class='fa fa-close'></i> Hapus</button></td>
						</tr>
						<?php
						$total_dpp_usd=($total_dpp_usd+$record->harga_total_usd);
						$idd++;
					}
					$total_ppn_idr=round($total_dpp_usd*$ppn/100);
					$total_invoice_usd=($total_dpp_usd+$total_ppn_idr);					
				}
				?>	
					</tbody>
					<footer>
						<tr>
							<td colspan="3" rowspan=3></td>
							<td colspan="2">Sub Total</td>
							<td><input type="text" class="form-control divide input-sm" id="total_dpp_usd" name="total_dpp_usd" value="<?=$total_dpp_usd?>" placeholder="Sub Total" tabindex="-1" readonly></td>
							<td rowspan=3></td>
						</tr>
						<tr>
							<td colspan="2">PPN</td>
							<td><input type="text" class="form-control divide input-sm" id="total_ppn_idr" name="total_ppn_idr" value="<?=$total_ppn_idr?>" placeholder="PPN" tabindex="-1" readonly></td>
						</tr>
						<tr>
							<td colspan="2">Total Invoice</td>
							<td><input type="text" class="form-control divide input-sm" id="total_invoice_usd" name="total_invoice_usd" value="<?=$total_invoice_usd?>" placeholder="Grand Total" tabindex="-1" readonly></td>
						</tr>
					</footer>
			   </table>
			  </div>
			</div>
		  </div>


		<div class='box-footer'>
			<?php
			echo form_button(array('type'=>'submit','class'=>'btn btn-md btn-primary','value'=>'save','content'=>'Save','id'=>'simpan-bro')).' ';
			//echo form_button(array('type'=>'button','class'=>'btn btn-md btn-danger','value'=>'back','content'=>'Back','onClick'=>'javascript:back()'));
			?>
			<a href="javascript:back()" class="btn btn-danger btn-md">Back</a>
		</div>
		<!-- /.box-body -->

	 </div>

  <!-- /.box -->
</form>
<style type="text/css">
	#unit_chosen{
		width: 100% !important;
	}
</style>

<script src="<?=base_url()?>assets/js/number-divider.min.js"></script>
				  
<script type="text/javascript">

$('.divide').divide();
var nomor=<?=$idd?>;
	function cektotal(id){
		if(id>0){
			var sqty = $("#qty_"+id).val();
			var pref = $("#harga_satuan_usd_"+id).val();
			var subtotal = (parseFloat(sqty)*parseFloat(pref));
			$("#harga_total_usd_"+id).val(subtotal);
		}
		var sum = 0;
		var ppn_persen = $("#ppn_persen").val();
		$('.subtotal').each(function() {
			sum += Number($(this).val());
		});
		$("#total_dpp_usd").val(sum);
		var total_ppn_idr=Math.floor(parseFloat(sum)*parseFloat(ppn_persen)/100);
		$("#total_ppn_idr").val(total_ppn_idr);
		$("#total_invoice_usd").val((parseFloat(sum)+parseFloat(total_ppn_idr)));
	}

	function add_detail(){
		var jenis_invoice=$("#jenis_invoice").val();
		var atrreadonly="";
		var Rows	 = 	"<tr id='tr1_"+nomor+"' class='delAll'>";
			Rows	+= 		"<td data-header='#'><input type='hidden' name='detail_id[]' id='raw_id_"+nomor+"' value='"+nomor+"' class='dtlloop'>";
			Rows	+= 		"<td data-header='Keterangan'>";
			Rows	+=			"<textarea class='form-control input-sm' name='desc[]' id='desc_"+nomor+"' rows=2/></textarea>";
			if(jenis_invoice=='2'){
				Rows	+= 		"<div>";
				atrreadonly = " readonly tabindex='-1' ";
			}else{
				Rows	+= 		"<div class='hidden'>";
			}
			Rows	+= 		"<input type='text' name='kd_aset[]' id='kd_aset_"+nomor+"' value='' class='asetloop form-control' readonly tabindex='-1' placeholder='Kode Aset'>";
			Rows	+= 		"<input type='hidden' name='nilai_aset[]' id='nilai_aset_"+nomor+"' value='0'>";
			Rows	+= 		"<input type='text' name='nama_aset[]' id='nama_aset_"+nomor+"' value='' placeholder='Nama Aset' class='form-control' readonly tabindex='-1'><button type='button' class='btn btn-success btn-xs stsview' title='Daftar Asset' onclick='list_asset("+nomor+")'><i class='fa fa-plus'></i> Daftar Asset</button></div>";
			Rows	+= 		"</td>";
			Rows	+= 		"<td data-header='Qty'>";
			Rows	+=			"<input type='text' class='form-control divide input-sm' name='qty[]' value='1' id='qty_"+nomor+"' onblur='cektotal("+nomor+")' "+atrreadonly+" style='width:60px;' />";
			Rows	+= 		"</td>";
			Rows	+= 		"<td data-header='Satuan'>";
			Rows	+=			"<input type='text' class='form-control input-sm' name='unit[]' value='' id='unit_"+nomor+"' />";
			Rows	+= 		"</td>";
			Rows	+= 		"<td data-header='Unit Price'>";
			Rows	+=			"<input type='text' class='form-control divide input-sm' name='harga_satuan_usd[]' value='0' id='harga_satuan_usd_"+nomor+"' onblur='cektotal("+nomor+")' />";
			Rows	+= 		"</td>";
			Rows	+= 		"<td data-header='Total Price'>";
			Rows	+=			"<input type='text' class='form-control divide input-sm subtotal' name='harga_total_usd[]' value='0' id='harga_total_usd_"+nomor+"' tabindex='-1' readonly />";
			Rows	+= 		"</td>";
			Rows	+= 		"<td align='center' th scope='row'>";
			Rows 	+=			"<button type='button' class='btn btn-danger btn-xs' data-toggle='tooltip' onClick='delDetail("+nomor+")' title='Hapus data'><i class='fa fa-close'></i> Hapus</button>";
			Rows	+= 		"</td>";
			Rows	+= 	"</tr>";
			nomor++;
		$('#detail_body').append(Rows);
		$(".divide").divide();
	}

$(function() {
    $(".tanggal").datepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true,
    });
});

$("#id_customer").change(function() {
  var selectedItem = $(this).val();
  var nm_customer = $('option:selected',this).data("nm_customer");
  $("#nm_customer").val(nm_customer);
});
function list_asset(id){
		loading_spinner();
		$(".modal-title").html("<b>DATA ASSET</b>");
		$("#listCoa").load(base_url + active_controller +'/list_asset/'+id);
		$("#Mymodal").modal();	
}
$(document).ready(function() {
	//$('.chosen-select').chosen();
    $('#frm_data').on('submit', function(e){
        e.preventDefault();
		var errors="";
		var lops=0;
		$('.dtlloop').each(function() {
			lops++;
		});
		if(lops==0) errors="Detail harus diisi";
		var jenis_invoice=$("#jenis_invoice").val();
		asetloop="";
		if(jenis_invoice==2){
			$('.asetloop').each(function() {
				if($(this).val()=="") errors="Aset Harus dipilih";
			});
		}
		if($("#jenis_invoice").val()=="") errors="Kategori tidak boleh kosong";
		if($("#id_customer").val()=="") errors="Customer tidak boleh kosong";
		if($("#tgl_invoice").val()=="") errors="Tanggal Invoice tidak boleh kosong";
		if($("#ppn_persen").val()=="") errors="Ppn persen tidak boleh kosong";
		if(errors==""){

		swal({
		  title: "Anda Yakin?",
		  text: "Data Akan Disimpan!",
		  type: "info",
		  showCancelButton: true,
		  confirmButtonText: "Ya, simpan!",
		  cancelButtonText: "Tidak!",
		  closeOnConfirm: false,
		  closeOnCancel: true
		},
		function(isConfirm){
		  if (isConfirm) {
			var formdata = new FormData($('#frm_data')[0]);
			$.ajax({
				url: base_url + active_controller + '/save_data',
				dataType : "json",
				type: 'POST',
				data: formdata,
				processData	: false,
				contentType	: false,
				success: function(msg){
					if(msg['save']=='1'){
						swal({
							title: "Sukses!",
							text: "Data Berhasil Di Simpan",
							type: "success",
							timer: 1500,
							showConfirmButton: false
						});
						window.location.href = base_url + active_controller;
					} else {
						swal({
							title: "Gagal!",
							text: "Data Gagal Di Simpan",
							type: "error",
							timer: 1500,
							showConfirmButton: false
						});
					};
					console.log(msg);
				},
				error: function(msg){
					swal({
						title: "Gagal!",
						text: "Ajax Data Gagal Di Proses",
						type: "error",
						timer: 1500,
						showConfirmButton: false
					});
					console.log(msg);
				}
			});
		  }
		});
//			data_save();
		}else{
			swal(errors);
			return false;
		}
    });
});

	function delDetail(row){
		$('#tr1_'+row).remove();
		cektotal(row);
	}
<?php if($results['tipe']=='view') echo '$("#frm_data :input").prop("disabled", true);';?>
</script>
