<?php
	$tanggal = date('Y-m-d');
foreach ($results['head'] as $head){
}	
?>

 <?php
	$tanggal = date('Y-m-d');
	$kode = $this->uri->segment(4);
?>

 <div class="box box-primary">
    <div class="box-body">
		<form id="data-form" method="post">
			<div class="col-sm-12">
				<div class="input_fields_wrap2"> 
			<div class="row">
		<center><label for="customer" ><h3>Debit Note</h3></label></center>
		<div class="col-sm-12">
		<div class="col-sm-6">
		<div class="form-group row">
			<div class="col-md-4">
				<label for="customer">NO.DN</label>
			</div>
			<div class="col-md-8" hidden>
				<input type="text" class="form-control" id="no_pr"  required name="no_pr" value=<?=$head->no_pr ?> readonly placeholder="id dn">
			</div>
			<div class="col-md-8">
				<input type="text" class="form-control" id="no_surat"  required name="no_surat" value=<?=$head->no_surat ?> readonly placeholder="No.DN">
			</div>
		</div>
		</div>
		<div class="col-sm-6">
                <div class="form-group row">
                    <div class="col-md-4">
                        <label for="id_customer">Customer</label>
                    </div>
                    <div class="col-md-8">
                        <select id="id_customer" name="id_customer" class="form-control input-md chosen-select select" onchange="get_customer()" required>
                            <option value="">--Pilih--</option>
                                <?php foreach ($results['customers'] as $customers){
								
								if($head->id_customer == $customers->id_customer ){									
									$selected ='selected';									
								}
								else{									
									$selected ='';							
								}
								
								?>
                            <option value="<?= $customers->id_customer.'|'.$customers->name_customer?>" <?= $selected ?> ><?= strtoupper(strtolower($customers->name_customer))?></option>
                                <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
		</div>
		<div class="col-sm-12">
		<div class="col-sm-6">
		<div class="form-group row">
			<div class="col-md-4">
				<label for="customer">Tanggal DN</label>
			</div>
			<div class="col-md-8">
				<input type="text" class="form-control datepicker" id="tanggal" value=<?=$head->tanggal ?> onkeyup required name="tanggal" readonly >
			</div>
		</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="id_customer">Mata Uang</label>
				</div>
				<div class="col-md-8"> 
					<select id="matauang" name="matauang" class='form-control input-md chosen-select'required>
							<?php foreach ($results['matauang'] as $supplier){								
								
								if($head->matauang == $supplier->kode ){									
									$selected ='selected';									
								}
								else{									
									$selected ='';							
								}
								?> 
						<option value="<?= $supplier->kode?>" <?=$selected;?>><?= strtoupper(strtolower($supplier->kode))?></option>
							<?php } ?>
					</select>
				</div>
			</div>
		</div>
		</div>
		
		<div class="col-sm-12">
				<div class="form-group row">
		<!--<button type='button' class='btn btn-sm btn-success' title='Ambil' id='tbh_ata' data-role='qtip'  data-klik='0'><i class='fa fa-plus'></i>Add</button>
		-->
		</div>
		<div class="form-group row" >
			<table class='table table-bordered table-striped'> 
			<thead>
			<tr class='bg-blue'>
				<th width='40%'>Keterangan</th>
				<th width='10%'> Harga</th>
				<th hidden width='5%'>Aksi</th>
			</tr>
			</thead>
			<tbody id="data_request">
			<?php
			$loop=0;
			foreach ($results['detail'] as $detail){
				$loop++;
				
			echo "
			<tr id='tr_$loop'>
			<td><input type='text' class='form-control' id='dt_keterangan_$loop' value='".$detail->keterangan ."'	required name='dt[$loop][keterangan]' 	readonly></td>
			<td><input type='number' class='form-control' value='".$detail->tagihan ."'  id='dt_harga_$loop' 			required name='dt[$loop][harga]' 		onblur='HitAmmount(".$loop.")' readonly></td>
			<td hidden><button type='button' class='btn btn-sm btn-danger' title='Hapus Data' data-role='qtip' onClick='return HapusItem($loop);'><i class='fa fa-close'></i></button></td>
			</tr>";
			}	 
			?>
			</tbody>
			
			<tfoot>
			<tr>
				<th width='40%'>Total</th>
				<th width='10%' align='right'><input type='text' class='form-control maskMoney' id='totalharga' required name='totalharga' value=<?=$head->total_tagihan ?> readonly></th>
				<th width='5%'></th>
			</tr>
			</tfoot>
			</table>
		</div>
			</div>
			<center>
			<?php if($kode !='view'){ ?>
		<button type="submit" class="btn btn-success btn-sm" name="save" id="simpan-com"><i class="fa fa-save"></i>Approve</button>
			<?php } ?>
			</center>
				 </div>
			</div>
		</form>		  
	</div>
</div>	
	
<style>
	.datepicker{
		cursor: pointer;
	}
</style>			  
				  
<script src="<?php echo base_url('assets/js/jquery.maskMoney.js'); ?>"></script>				  
<script type="text/javascript">
	
	var base_url			= '<?php echo base_url(); ?>';
	var active_controller	= '<?php echo($this->uri->segment(1)); ?>';
	$(document).ready(function(){	
	
	$('.select').select2({
				width: '100%'
			});
	
	
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
						var baseurl=siteurl+'debit_note/Approved';
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
									window.location.href = base_url + active_controller +'/index_approval';
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


$('#tbh_ata').on( 'click', function () {
		
		var jumlah	=$('#list_spk').find('tr').length;
	 var nomor   =$(this).data('klik');
	 
	 var klik = parseInt(nomor)+parseInt(1);
	 
	 
	 $.ajax({
		 type:"GET",
		 url:siteurl+'debit_note/AddMaterial',
		 data:"jumlah="+nomor,
		 success:function(html){
			$("#data_request").append(html);
			$('.select2').select2();
			$('.datepicker').datepicker({
					dateFormat: 'yy-mm-dd',
					changeMonth:true,
					changeYear:true,
				});
			
			
		   
		   
			
		 }
	 });
	 
	  $(this).data('klik',klik);
	  
	  //alert(klik);
 });	


	function HapusItem(id){		
		$('#data_request #tr_'+id).remove();
		cariTotal()
		
	}
	
	function HitAmmount(id){
		var dt_width	= $("#dt_harga_"+id).val();
		
		
      	var SUM_JML = 0;		
		$(".ch_jumlah" ).each(function() {
			SUM_JML += Number($(this).val().split(",").join(""));
		});

		$("#dt_harga_"+id).val(number_format(dt_width));
		$("#totalharga").val(number_format(SUM_JML));
	

    }


	function cariTotal(){
      	
		var SUM_JML = 0;		
		$(".ch_jumlah" ).each(function() {
			SUM_JML += Number($(this).val().split(",").join(""));
		});

		$("#totalharga").val(number_format(SUM_JML));

    }

	function SumDel(){
		var SUM_JML = 0
		var SUM_DIS = 0
		var SUM_PJK = 0
		var SUM_JMX = 0

		$(".ch_diskon" ).each(function() {
			SUM_DIS += Number($(this).val());
		});

		$(".ch_pajak" ).each(function() {
			SUM_PJK += Number($(this).val());
		});

		$(".ch_jumlah" ).each(function() {
			SUM_JML += Number($(this).val());
		});

		$(".ch_jumlah_ex" ).each(function() {
			SUM_JMX += Number($(this).val().split(",").join(""));
		});

		$("#hargatotal").val(number_format(SUM_JMX));
		$("#diskontotal").val(number_format(SUM_DIS));
		$("#taxtotal").val(number_format(SUM_PJK));
		$("#subtotal").val(number_format(SUM_JML));

    }

	function TotalSemua(){
		var SUM_JML = 0
		var SUM_DIS = 0
		var SUM_PJK = 0
		var SUM_JMX = 0

		$(".ch_diskon" ).each(function() {
			SUM_DIS += Number($(this).val());
		});

		$(".ch_pajak" ).each(function() {
			SUM_PJK += Number($(this).val());
		});

		$(".ch_jumlah" ).each(function() {
			SUM_JML += Number($(this).val());
		});

		$(".ch_jumlah_ex" ).each(function() {
			SUM_JMX += Number($(this).val().split(",").join(""));
		});

		$("#hargatotal").val(number_format(SUM_JMX));
		$("#diskontotal").val(number_format(SUM_DIS));
		$("#taxtotal").val(number_format(SUM_PJK));
		$("#subtotal").val(number_format(SUM_JMX));

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

	function getNum(val) {
		if (isNaN(val) || val == '') {
			return 0;
		}
		return parseFloat(val);
	}
	

	
	
	
</script>