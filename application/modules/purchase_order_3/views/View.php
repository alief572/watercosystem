<?php
	$tanggal = date('Y-m-d');
foreach ($results['head'] as $head){
}	
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
		<center><label for="customer" ><h3>Purchase Order</h3></label></center>
				<div class="col-sm-12">
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="id_customer">Supplier</label>
				</div>
				<div class="col-md-8"> 
				<input type="text" class="form-control" readonly id="suplier" value="<?= $head->suplier  ?>" onkeyup required name="suplier" >
				</div>
			</div>
		</div>
				<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="id_customer">Local / Import</label>
				</div>
				<div class="col-md-8">
				<input type="text" class="form-control" readonly id="loi" value="<?= $head->loi  ?>" onkeyup required name="loi" >
				</div>
			</div>
		</div>
		</div>
		<div class="col-sm-12">
		<div class="col-sm-6">
		<div class="form-group row">
			<div class="col-md-4">
				<label for="customer">NO.PO</label>
			</div>
			<div class="col-md-8" hidden>
				<input type="text" class="form-control" id="no_po"  value="<?= $head->no_po  ?>" required name="no_po" readonly placeholder="ID PO">
			</div>
			<div class="col-md-8">
				<input type="text" class="form-control" id="no_surat" value="<?= $head->no_surat  ?>"  required name="no_surat" readonly placeholder="No.PR">
			</div>
		</div>
		</div>
		<div class="col-sm-6" id="input_kurs">
		
		</div>
		</div>
		<div class="col-sm-12">
		<div class="col-sm-6">
		<div class="form-group row">
			<div class="col-md-4">
				<label for="customer">Tanggal PO</label>
			</div>
			<div class="col-md-8">
				<input type="date" class="form-control" id="tanggal" value="<?= $head->tanggal ?>" onkeyup required name="tanggal" readonly >
			</div>
		</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="id_customer">Mata Uang</label>
				</div>
				<div class="col-md-8"> 
				<input type="text" class="form-control" id="matauang" value="<?= $head->matauang  ?>"  required name="matauang" readonly>
				</div>
			</div>
		</div>
		</div>
				<div class="col-sm-12">
		<div class="col-sm-6">
		<div class="form-group row">
			<div class="col-md-4">
				<label for="customer">Expect Date</label>
			</div>
			<div class="col-md-8">
				<input type="date" class="form-control" readonly value="<?= $head->expect_tanggal  ?>"  id="expect_tanggal" required name="expect_tanggal"  >
			</div>
		</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="id_customer">PR</label>
				</div>
				<div class="col-md-8"> 
				<input type="text" class="form-control" id="no_pr" value="<?= $head->no_pr  ?>"  required name="no_pr" readonly>
				</div>
			</div>
		</div>
		</div>
				<div class="col-sm-12">
		<div class="col-sm-6">
		<div class="form-group row">
			<div class="col-md-4">
				<label for="customer">Term</label>
			</div>
			<div class="col-md-8">
				<input type="text" class="form-control" readonly id="term" value="<?= $head->term  ?>" onkeyup required name="term" >
			</div>
		</div>
		</div>
		</div>
		<div class="col-sm-12">
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="id_customer">CIF</label>
				</div>
				<div class="col-md-8">
				<input type="text" class="form-control" readonly id="cif" value="<?= $head->cif  ?>" onkeyup required name="cif" >
				</div>
			</div>
		</div>
		</div>
		<div class="col-sm-12">
			<div class="form-group row" id='kurs_place'>
			<?php
			$hariini = date('Y-m-d');
		$sepuluh_hari = mktime(0,0,0,date('n'),date('j')-10,date('Y'));
		$tendays = date("Y-m-d", $sepuluh_hari);
		$tglnow = date('d');
		$blnnow = date('m');
		if ($blnnow != '1'){ 
		$blnkmrn = $blnnow-1;
		$yearkemaren = date('Y');
		}else{
		$blnkmrn = "12";
		$yearnow = date('Y');
		$yearkemaren = $yearnow-1;
		}	
	$kurs	= $this->db->query("SELECT * FROM mata_uang WHERE kode = 'IDR' ")->result();
	$kurs10hari	= $this->db->query("SELECT AVG(nominal) as nominal FROM perubahan_kurs WHERE tanggal_ubah BETWEEN  '$tendays' AND '$hariini' AND kode_kurs='IDR' ")->result();
	$kurs30hari	= $this->db->query("SELECT AVG(nominal) as nominal FROM perubahan_kurs WHERE MONTH(tanggal_ubah) =  '$blnkmrn' AND YEAR(tanggal_ubah) = '$yearkemaren' AND kode_kurs='IDR' ")->result();
	$nomkurs = $kurs[0]->kurs;
	$nomkurs10 = $kurs10hari[0]->nominal;
	$nomkurs30 = $kurs30hari[0]->nominal;
	$k =  number_format($nomkurs,2);
	$k10 =  number_format($nomkurs10,2);
	$k30 =  number_format($nomkurs30,2);
	if($head->loi == 'Import'){
		echo "
				<table class='col-sm-12' border='1' cellspacing='0'>
					<tr>
						<th><center>Kurs On The Spot</center></th>
						<th><center>Kurs 10 Hari</center></th>
						<th><center>Kurs 30 Hari</center></th>
					</tr>
					<tr>
						<td><center>Rp. $k  ,-</center></td>
						<td><center>Rp. $k10  ,-</center></td>
						<td><center>Rp. $k30  ,-</center></td>
					</tr>
				<table>
		";
	}else{};
			?>
			</div>
		</div>
	<div class="col-sm-12">
			<div class="form-group row" id='lme_place'>
			<table class='table table-bordered table-striped'>
		<thead>
		<tr>
			<th width="5">#</th>
			<th width="13%">Kompisisi</th>
			<th>Rate H-30</th>
			<th>Rate H-10</th>
			<th>Rate Saat Ini</th>
		</tr>
		</thead>

		<tbody>
		<?php if(empty($results['comp'])){ 
		}else{
		$hariini 		= date('Y-m-d');
		$satu_hari 		= mktime(0,0,0,date('n'),date('j')-1,date('Y'));
		$kemarin 		= date("Y-m-d", $satu_hari);
		$sepuluh_hari 	= mktime(0,0,0,date('n'),date('j')-14,date('Y'));
		$tendays 		= date("Y-m-d", $sepuluh_hari);
		$tglnow 		= date('d');
		$blnnow 		= date('m');
		if ($blnnow 	!= '1'){ 
		$blnkmrn	 	= $blnnow-1;
		$yearkemaren 	= date('Y');
		}else{
		$blnkmrn 		= "12";
		$yearnow 		= date('Y');
		$yearkemaren 	= $yearnow-1;
		}
			$numb3=0; foreach($results['comp'] as $comp){ $numb3++;
			$id_comp = $comp->id_compotition;
			$lme_10hari	= $this->db->query("SELECT AVG(nominal) as nominal FROM child_history_lme WHERE tanggal_update BETWEEN  '$tendays' AND '$kemarin' AND id_compotition='$id_comp' ")->result();
			$lme_30hari	= $this->db->query("SELECT AVG(nominal) as nominal FROM child_history_lme WHERE MONTH(tanggal_update) =  '$blnkmrn' AND YEAR(tanggal_update) = '$yearkemaren' AND id_compotition='$id_comp' ")->result();
			?>
		<tr>
		    <td><?= $numbc; ?></td>
			<td><?= $comp->name_compotition ?></td>
			<td>$ <?= number_format( $lme_30hari[0]->nominal,2);?></td>
			<td>$ <?= number_format( $lme_10hari[0]->nominal,2);?></td>
			<td>$ <?= number_format( $comp->nominal_harga,2); ?></td>
		</tr>
		
		<?php } }  ?>
		</tbody>
		</table>
			</div>
		</div>
		<div class="col-sm-12">
		<div class="form-group row" >
			<table class='table table-bordered table-striped'>
			<thead>
	<tr class='bg-blue'>
			<th width='15%'>Item</th>
			<th width='7%'>Description</th>
			<th hidden width='7%'>Width</th>
			<th hidden width='7%'>Qty (Unit)</th>
			<th width='7%'>Total Weight</th>
			<th hidden width='10%'>Rate LME</th>
			<th hidden width='7%'>Alloy Price</th>
			<th hidden width='7%'>Fab Cost</th>
			<th width='10%'>Unit Price</th>
			<th width='7%'>Discount %</th>
			<th width='7%'>Tax</th>
			<th width='10%'>Amount</th>
			<th width='10%'>Note</th>
			</tr>
			</thead>
			<tbody id="data_request">
			<?php
			$loop=0;
			foreach ($results['detail'] as $detail){
			$loop ++;
			echo"
			<tr id='trmaterial_$loop'>
				<td hidden><input readonly 	type='text' 	value='".$detail->idpr."'			class='form-control input-sm' id='dt_idpr_".$loop."' 		required name='dt[".$loop."][idpr]' ></td>
				<td hidden><input readonly 	type='text' 	value='".$detail->idmaterial."'		class='form-control input-sm' id='dt_idmaterial_".$loop."' 	required name='dt[".$loop."][idmaterial]' ></td>
				<td ><input		readonly  	type='text' 	value='".$detail->nama."'	class='form-control input-sm' id='dt_namamaterial_".$loop."' required name='dt[".$loop."][namamaterial]' ></td>
				<td ><input		readonly  	type='text' 	value='".$detail->description."'	class='form-control input-sm' id='dt_description_".$loop."' 	required name='dt[".$loop."][description]' ></td>
				<td hidden ><input		readonly  	type='number' 	value='".$detail->width."'	class='form-control text-right input-sm' id='dt_width_".$loop."' 		required name='dt[".$loop."][width]'  ></td>
				<td hidden ><input		readonly  	type='number' 	value='".$detail->qty."'	class='form-control text-right input-sm' id='dt_qty_".$loop."' 			required name='dt[".$loop."][qty]'  ></td>
				<td ><input		readonly  	type='number' 	value='".$detail->totalwidth."'		class='form-control text-right input-sm' id='dt_totalwidth_".$loop."' 	required name='dt[".$loop."][totalwidth]'  ></td>
				<td	><input		readonly  	type='number' 	value='".$detail->hargasatuan."'	class='form-control text-right input-sm' id='dt_hargasatuan_".$loop."' 	required name='dt[".$loop."][hargasatuan]' ></td>
				<td	><input		readonly 	type='number' 	value='".$detail->diskon."'			class='form-control text-right input-sm' id='dt_diskon_".$loop."' 		required name='dt[".$loop."][diskon]' ></td>
				<td	><input		readonly	type='number' 	value='".$detail->pajak."'			class='form-control text-right input-sm' id='dt_pajak_".$loop."' 		required name='dt[".$loop."][pajak]' ></td>
				<td ><input		readonly 	type='number' 	value='".$detail->jumlahharga."'	class='form-control text-right input-sm' id='dt_jumlahharga_".$loop."' 	required name='dt[".$loop."][jumlahharga]' ></td>
				<td	><input		readonly  	type='text' 	value='".$detail->note."'			class='form-control input-sm' id='dt_note_".$loop."' 		required name='dt[".$loop."][note]' ></td>
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
					<label for="id_customer">Sub Total</label>
				</div>
				<div class="col-md-8" id="ForHarga">
					<input readonly type="text" class="form-control" value="<?= $head->hargatotal  ?>" id="hargatotal"  onkeyup required name="hargatotal" >
				</div>
			</div>
		</div>
		</div>
				<div class="col-sm-12">
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="id_customer">Discount</label>
				</div>
				<div class="col-md-8" id="ForDiskon">
					<input readonly type="text" class="form-control" value="<?= $head->diskontotal  ?>" id="diskontotal"  onkeyup required name="diskontotal" >
				</div>
			</div>
		</div>
		</div>
		<div class="col-sm-12">
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="id_customer">TAX</label>
				</div>
				<div class="col-md-8" id="ForTax">
					<input readonly type="text" class="form-control" value="<?= $head->taxtotal  ?>" id="taxtotal"  onkeyup required name="taxtotal" >
				</div>
			</div>
		</div>
		</div>
				<div class="col-sm-12">
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="id_customer">Total Order</label>
				</div>
				<div class="col-md-8" id="ForSum">
					<input readonly type="text" class="form-control" value="<?= $head->subtotal  ?>" id="subtotal"  onkeyup required name="subtotal" >
				</div>
			</div>
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
						var baseurl=siteurl+'purchase_order/SaveEdit';
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
	function addmaterial(){ 
		var jumlah	=$('#data_request').find('tr').length;
		var id_suplier=$("#id_suplier").val();
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/AddMaterial',
            data:"jumlah="+jumlah+"&id_suplier="+id_suplier,
            success:function(html){
               $("#data_request").append(html);
            }
        });
    }
	function HitungHarga(id){
        var dt_qty=$("#dt_qty_"+id).val();
		 var dt_width=$("#dt_width_"+id).val();
		 var dt_hargasatuan=$("#dt_hargasatuan_"+id).val();
		 $.ajax({
            type:"GET",
            url:siteurl+'purchase_order/HitungHarga',
            data:"dt_hargasatuan="+dt_hargasatuan+"&dt_qty="+dt_qty+"&id="+id,
            success:function(html){
               $("#jumlahharga_"+id).html(html);
            }
        });
		 $.ajax({
            type:"GET",
            url:siteurl+'purchase_order/TotalWeight',
            data:"dt_width="+dt_width+"&dt_qty="+dt_qty+"&id="+id,
            success:function(html){
               $("#totalwidth_"+id).html(html);
            }
        });
    }
	function get_kurs(){
        var loi=$("#loi").val();
		 $.ajax({
            type:"GET",
            url:siteurl+'purchase_order/CariKurs',
            data:"loi="+loi,
            success:function(html){
               $("#kurs_place").html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/FormInputKurs',
            data:"loi="+loi,
            success:function(html){
               $("#input_kurs").html(html);
            }
        });
    }
	function CariProperties(id){
        var idpr=$("#dt_idpr_"+id).val();
		 $.ajax({
            type:"GET",
            url:siteurl+'purchase_order/CariIdMaterial',
            data:"idpr="+idpr+"&id="+id,
            success:function(html){
               $("#idmaterial_"+id).html(html); 
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/CariNamaMaterial',
            data:"idpr="+idpr+"&id="+id,
            success:function(html){
               $("#namaterial_"+id).html(html); 
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/CariDescripitionMaterial',
            data:"idpr="+idpr+"&id="+id,
            success:function(html){
               $("#description_"+id).html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/CariQtyMaterial',
            data:"idpr="+idpr+"&id="+id,
            success:function(html){
               $("#qty_"+id).html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/CariweightMaterial',
            data:"idpr="+idpr+"&id="+id,
            success:function(html){
               $("#width_"+id).html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/CariTweightMaterial',
            data:"idpr="+idpr+"&id="+id,
            success:function(html){
               $("#totalwidth_"+id).html(html);
            }
        });
    }
	function LockMaterial(id){
        var idpr=$("#dt_idpr_"+id).val();
		var idmaterial=$("#dt_idmaterial_"+id).val();
		var namaterial=$("#dt_namamaterial_"+id).val();
		var description=$("#dt_description_"+id).val();
		var qty=$("#dt_qty_"+id).val();
		var width=$("#dt_width_"+id).val();
		var totalwidth=$("#dt_totalwidth_"+id).val();
		var hargasatuan=$("#dt_hargasatuan_"+id).val();
		var diskon=$("#dt_diskon_"+id).val();
		var pajak=$("#dt_pajak_"+id).val();
		var jumlahharga=$("#dt_jumlahharga_"+id).val();
		var note=$("#dt_note_"+id).val();
		var subtotal=$("#subtotal").val();
		var hargatotal=$("#hargatotal").val();
		var diskontotal=$("#diskontotal").val();
		var taxtotal=$("#taxtotal").val();
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/LockMatrial',
            data:"idpr="+idpr+"&id="+id+"&idmaterial="+idmaterial+"&width="+width+"&totalwidth="+totalwidth+"&namaterial="+namaterial+"&description="+description+"&qty="+qty+"&hargasatuan="+hargasatuan+"&diskon="+diskon+"&pajak="+pajak+"&jumlahharga="+jumlahharga+"&note="+note,
            success:function(html){
               $("#trmaterial_"+id).html(html);
            }
        });
		 $.ajax({
            type:"GET",
            url:siteurl+'purchase_order/CariTHarga',
			data:"idpr="+idpr+"&id="+id+"&hargatotal="+hargatotal+"&idmaterial="+idmaterial+"&namaterial="+namaterial+"&description="+description+"&qty="+qty+"&hargasatuan="+hargasatuan+"&diskon="+diskon+"&pajak="+pajak+"&jumlahharga="+jumlahharga+"&note="+note,
            success:function(html){
               $("#ForHarga").html(html); 
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/CariTDiskon',
            data:"idpr="+idpr+"&id="+id+"&diskontotal="+diskontotal+"&idmaterial="+idmaterial+"&namaterial="+namaterial+"&description="+description+"&qty="+qty+"&hargasatuan="+hargasatuan+"&diskon="+diskon+"&pajak="+pajak+"&jumlahharga="+jumlahharga+"&note="+note,
            success:function(html){
               $("#ForDiskon").html(html); 
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/CariTPajak',
            data:"idpr="+idpr+"&id="+id+"&taxtotal="+taxtotal+"&idmaterial="+idmaterial+"&namaterial="+namaterial+"&description="+description+"&qty="+qty+"&hargasatuan="+hargasatuan+"&diskon="+diskon+"&pajak="+pajak+"&jumlahharga="+jumlahharga+"&note="+note,
            success:function(html){
               $("#ForTax").html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/CariTSum',
            data:"idpr="+idpr+"&id="+id+"&hargatotal="+hargatotal+"&diskontotal="+diskontotal+"&taxtotal="+taxtotal+"&idmaterial="+idmaterial+"&namaterial="+namaterial+"&description="+description+"&qty="+qty+"&hargasatuan="+hargasatuan+"&diskon="+diskon+"&pajak="+pajak+"&jumlahharga="+jumlahharga+"&note="+note,
            success:function(html){
               $("#ForSum").html(html);
            }
        });
    }
	function CancelItem(id){
        var idpr=$("#dt_idpr_"+id).val();
		var idmaterial=$("#dt_idmaterial_"+id).val();
		var namaterial=$("#dt_namamaterial_"+id).val();
		var description=$("#dt_description_"+id).val();
		var qty=$("#dt_qty_"+id).val();
		var hargasatuan=$("#dt_hargasatuan_"+id).val();
		var diskon=$("#dt_diskon_"+id).val();
		var pajak=$("#dt_pajak_"+id).val();
		var jumlahharga=$("#dt_jumlahharga_"+id).val();
		var note=$("#dt_note_"+id).val();
		var subtotal=$("#subtotal").val();
		var hargatotal=$("#hargatotal").val();
		var diskontotal=$("#diskontotal").val();
		var taxtotal=$("#taxtotal").val();
		 $.ajax({
            type:"GET",
            url:siteurl+'purchase_order/CariMinHarga',
			data:"idpr="+idpr+"&id="+id+"&hargatotal="+hargatotal+"&idmaterial="+idmaterial+"&namaterial="+namaterial+"&description="+description+"&qty="+qty+"&hargasatuan="+hargasatuan+"&diskon="+diskon+"&pajak="+pajak+"&jumlahharga="+jumlahharga+"&note="+note,
            success:function(html){
               $("#ForHarga").html(html); 
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/CariMinDiskon',
            data:"idpr="+idpr+"&id="+id+"&diskontotal="+diskontotal+"&idmaterial="+idmaterial+"&namaterial="+namaterial+"&description="+description+"&qty="+qty+"&hargasatuan="+hargasatuan+"&diskon="+diskon+"&pajak="+pajak+"&jumlahharga="+jumlahharga+"&note="+note,
            success:function(html){
               $("#ForDiskon").html(html); 
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/CariMinPajak',
            data:"idpr="+idpr+"&id="+id+"&taxtotal="+taxtotal+"&idmaterial="+idmaterial+"&namaterial="+namaterial+"&description="+description+"&qty="+qty+"&hargasatuan="+hargasatuan+"&diskon="+diskon+"&pajak="+pajak+"&jumlahharga="+jumlahharga+"&note="+note,
            success:function(html){
               $("#ForTax").html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/CariMinSum',
            data:"idpr="+idpr+"&id="+id+"&hargatotal="+hargatotal+"&diskontotal="+diskontotal+"&taxtotal="+taxtotal+"&idmaterial="+idmaterial+"&namaterial="+namaterial+"&description="+description+"&qty="+qty+"&hargasatuan="+hargasatuan+"&diskon="+diskon+"&pajak="+pajak+"&jumlahharga="+jumlahharga+"&note="+note,
            success:function(html){
               $("#ForSum").html(html);
            }
        });
		$('#data_request #trmaterial_'+id).remove();
    }
function HapusItem(id){
		$('#data_request #trmaterial_'+id).remove();
		
	}
	
	
	
</script>