<?php
    $ENABLE_ADD     = has_permission('Penawaran.Add');
    $ENABLE_MANAGE  = has_permission('Penawaran.Manage');
    $ENABLE_VIEW    = has_permission('Penawaran.View');
    $ENABLE_DELETE  = has_permission('Penawaran.Delete');
	$tanggal = date('Y-m-d'); 
    foreach ($results['header'] as $hd){}
	$plan = $results['plan'];
?>

<div class="box box-primary">
    <div class="box-body">
		<form id="data-form" method="post">
			<div class="col-sm-12">
				<div class="input_fields_wrap2">
			<div class="row">
		<center><label for="customer" ><h3>Create Revenue</h3></label></center>
		<div class="col-sm-12">
		    <div class="col-sm-6">
		        <div class="form-group row">
			        <div class="col-md-4">
				        <label for="customer">No SO</label>
			        </div>
			        <div class="col-md-8" hidden>
				        <input type="text" class="form-control" id="no_so" value="<?= $hd->no_so?>" required name="no_so" readonly placeholder="No.SO">
				  
					</div>
			        <div class="col-md-8">
				        <input type="text" class="form-control" id="no_surat" required name="no_surat" value="<?= $hd->no_surat?>" readonly placeholder="No. Invoice">
			        </div>
		        </div>
		    </div>
		    <div class="col-sm-6">
		        <div class="form-group row">
			        <div class="col-md-4">
				        <label for="customer">Tanggal</label>
			        </div>
			        <div class="col-md-8">
				        <input type="date" class="form-control" id="tanggal" onkeyup required name="tanggal" value="<?php echo date('Y-m-d')?>" >
			        </div>
		        </div>
		    </div>
		</div>
		<div class="col-sm-12">
            <div class="col-sm-6">
                <div class="form-group row">
                    <div class="col-md-4">
                        <label for="id_customer">Customer</label>
                    </div>
                    <div class="col-md-8">
                        <select id="id_customer" name="id_customer" class="form-control select" onchange="get_customer()" disabled required>
                            <option value="">--Pilih--</option>
                             <?php foreach ($results['customers'] as $customers){
                             $select1 = $hd->id_customer == $customers->id_customer ? 'selected' : '';	?>
                            <option value="<?= $customers->id_customer?>"<?= $select1 ?>><?= strtoupper(strtolower($customers->name_customer))?></option>
                                <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group row">
                    <div class="col-md-4">
                        <label for="id_category_supplier">Sales/Marketing</label>
                    </div>
                    <div id="sales_slot">
                    <div class='col-md-8'>
                        <input type='text' class='form-control' id='nama_sales' value="<?= $hd->nama_sales?>"  required name='nama_sales' readonly placeholder='Sales Marketing'>
                    </div>
                    <div class='col-md-8' hidden>
                        <input type='text' class='form-control' id='id_sales'  value="<?= $hd->id_sales?>" required name='id_sales' readonly placeholder='Sales Marketing'>
                    </div>
                    </div>
                </div>
            </div>		
		</div>
		
		<div class="col-md-12">
		    <div class='col-sm-6'>
		        <div class='form-group row'>
			        <div class='col-md-4'>
				        <label for='email_customer'>Email</label> 
			        </div>
			        <div class='col-md-8' id="email_slot">
				        <input type='email' class='form-control'  value="<?= $hd->email_customer?>" id='email_customer' required name='email_customer' readonly >
			        </div>
		        </div>
		    </div>
		    <div class='col-sm-6'>
			    <div class='form-group row'>
				    <div class='col-md-4'>
					    <label for='id_category_supplier'>PIC Customer</label>
				    </div>
				    <div class='col-md-8' id="pic_slot" >
					    <select id='pic_customer' name='pic_customer' class='form-control select' required disabled>
						    <option value="<?= $hd->pic_customer?>" selected><?= strtoupper(strtolower($hd->pic_customer))?></option>
					    </select>
				    </div>
			    </div>
		    </div>
		</div>		
       
		
		<div class="col-sm-12">
		    <div class="col-sm-6">
		        <div class="form-group row">
			        <div class="col-md-4">
				        <label for="customer">Total DPP</label>
			        </div>
			        <div class="col-md-8">
				        <input type="text" class="form-control" id="total_so" required name="total_so" readonly placeholder="Pembayaran" value="<?=number_format($hd->nilai_so)  ?>">
			        </div>
		        </div>
		    </div>
			<div class="col-sm-6">
		        <div class="form-group row">
			        <div class="col-md-4">
				        <label for="customer">Total HPP</label>
			        </div>
			        <div class="col-md-8">
				        <input type="text" class="form-control" id="total_hpp" required name="total_hpp" readonly placeholder="Pembayaran" value="<?=number_format($hd->total_costbook_so)  ?>">
			        </div>
		        </div>
		    </div>
		    
		</div>

		<div class="col-sm-12">
		    <div class="col-sm-6">
		        <div class="form-group row">
			        <div class="col-md-4">
				        <label for="customer">Invoice Revenue</label>
			        </div>
			        <div class="col-md-8">
                        <?php $sisainvoice = $hd->total_invoice - $hd->invoice_revenue ?>
				        <input type="text" class="form-control" id="sisa_invoice" required name="sisa_invoice" value="<?=number_format($sisainvoice)  ?>" placeholder="Sisa Invoice" readonly>
			        </div>
		        </div>
		    </div>
		    <div class="col-sm-6">
		        <div class="form-group row">
			        <div class="col-md-4">
				        <label for="sisa_hpp">HPP Revenue</label>
			        </div>
			        <div class="col-md-8">
                        <?php $sisahpp = $hd->total_hpp - $hd->hpp_revenue ?>
				        <input type="text" class="form-control" id="sisa_hpp" required name="sisa_hpp" value="<?=number_format($sisahpp)  ?>" placeholder="Sisa Invoice" readonly>
			        </div>
		        </div>
		    </div>
		</div>
		<div class="col-sm-12">
		    <div class="col-sm-6">
		        <div class="form-group row">
			        <div class="col-md-4">
				        <label for="persen_invoice">Persentase Invoice</label>
			        </div>
			        <div class="col-md-8">
                        <?php $perseninvoice = $hd->percent_invoice - $hd->perseninvoice_revenue ?>
				        <input type="text" class="form-control" id="persen_invoice" required name="persen_invoice" value="<?=number_format($perseninvoice)  ?>" readonly placeholder="Persen Invoice">
			        </div>
		        </div>
		    </div>
			<div class='col-sm-6'>
		        <div class='form-group row'>
			        <div class='col-md-4'>
				        <label for='persen_hpp'>Persentase HPP</label>
			        </div>
			        <div class='col-md-8' id="persen_hpp">
                        <?php $persendo = $hd->percent_do - $hd->perseninvoice_revenue ?>
                        <input type="text" class="form-control" id="persen_do" required name="persen_do" value="<?=number_format($persendo)  ?>" readonly placeholder="Persen DO">
                   </div>
		        </div>
		    </div>
		</div>
        <div class="col-sm-12">
		    <div class="col-sm-6">
		        <div class="form-group row">
			        <div class="col-md-4">
				        <label for="persen_pengakuan">Jumlah Pengakuan %</label>
			        </div>
			        <div class="col-md-8">
                        <?php $perseninvoice = $hd->percent_invoice - $hd->perseninvoice_revenue ?>
				        <input type="text" class="form-control" id="persen_pengakuan" required name="persen_pengakuan" onKeyup="HitungRevenue()"  placeholder="jumlah Pengakuan dalam persen">
			        </div>
		        </div>
		    </div>
		</div>
        <div class="col-sm-12">
		    <div class="col-sm-6">
		        <div class="form-group row">
			        <div class="col-md-4">
				        <label for="pengakuan_invoice">Pengakuan Invoice</label>
			        </div>
			        <div class="col-md-8">
                        <input type="text" class="form-control" id="pengakuan_invoice" required name="pengakuan_invoice" readonly placeholder="Pengakuan Invoice">
			        </div>
		        </div>
		    </div>
			<div class='col-sm-6'>
		        <div class='form-group row'>
			        <div class='col-md-4'>
				        <label for='pengakuan_hpp'>Pengakuan HPP</label>
			        </div>
			        <div class='col-md-8'>
                    <input type="text" class="form-control" id="pengakuan_hpp" required name="pengakuan_hpp" readonly placeholder="Pengakuan HPP">
			      </div>
		        </div>
		    </div>
		</div>

        			<center>
					<button type="submit" class="btn btn-success btn-sm" name="save" id="simpan-com"><i class="fa fa-save"></i>&nbsp;Simpan</button>
                    <a class="btn btn-danger btn-sm" href="<?= base_url('/wt_revenue/') ?>"  title="Kembali">Kembali</a>
					</center>
		</form>		  
	</div>
</div>	

       

     
			  
<script type="text/javascript">
	$('#simpan-com2').hide();
	

	var base_url			= '<?php echo base_url(); ?>';
	var active_controller	= '<?php echo($this->uri->segment(1)); ?>';
	$(document).ready(function(){	
			var max_fields2      = 10; //maximum input boxes allowed
			var wrapper2         = $(".input_fields_wrap2"); //Fields wrapper
			var add_button2      = $(".add_field_button2"); //Add button ID		

			$('.select').select2({
				width: '100%'
			});
	$('#simpan-com').click(function(e){
			e.preventDefault();
			var deskripsi	= $('#deskripsi').val();
			var image	= $('#image').val();
			var tanggal  =$('#tanggal').val();

			$(".select").removeAttr("disabled");
			
			$("#simpan-com").attr("disabled", true);
			
			var data, xhr;
			
			if(tanggal ==''){
					swal("Warning", "Tanggal Invoice Tidak Boleh Kosong :)", "error");
					return false;
			}else{			
			
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
						var baseurl=siteurl+'wt_revenue/SaveNewRevenue';
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
									window.location.href = base_url + 'wt_revenue';
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
		
		
		$('#simpan-preview').click(function(e){
			e.preventDefault();
			var deskripsi	= $('#deskripsi').val();
			var image	= $('#image').val();
			var tanggal  =$('#tanggal').val();

			$(".select").removeAttr("disabled");
			
			var data, xhr;
			
			if(tanggal ==''){
					swal("Warning", "Tanggal Invoice Tidak Boleh Kosong :)", "error");
					return false;
			}else{			
			
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
						var baseurl=siteurl+'wt_invoicing/SavePreviewInvoice';
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
									window.open(base_url + 'wt_invoicing/PrintPreviewInvoice','_blank');									
								}else{
									
									if(data.status == 2){
										swal({
										  title	: "Preview Failed!",
										  text	: data.pesan,
										  type	: "warning",
										  timer	: 7000,
										  showCancelButton	: false,
										  showConfirmButton	: false,
										  allowOutsideClick	: false
										});
									}else{
										swal({
										  title	: "Preview Failed!",
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


		$('#simpan-com1').click(function(e){
			e.preventDefault();
			var deskripsi	= $('#deskripsi').val();
			var image	= $('#image').val();
			var idtype	= $('#inventory_1').val();

			$(".select").removeAttr("disabled");
			
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
						var baseurl=siteurl+'wt_invoicing/SaveNewProformaInvoice';
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
									window.location.href = base_url + 'wt_invoicing/plan_tagih';
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


function get_customer(){
        var id_customer=$("#id_customer").val();
		 $.ajax({
            type:"GET",
            url:siteurl+'wt_penawaran/getemail',
            data:"id_customer="+id_customer,
            success:function(html){
               $("#email_slot").html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'wt_penawaran/getpic',
            data:"id_customer="+id_customer,
            success:function(html){
               $("#pic_slot").html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'wt_penawaran/getsales',
            data:"id_customer="+id_customer,
            success:function(html){
               $("#sales_slot").html(html);
            }
        });
    }
function DelItem(id){
		$('#data_barang #tr_'+id).remove();
		
	}
	
	
    function GetProduk(){ 
		var jumlah	=$('#list_spk').find('tr').length;
		$.ajax({
            type:"GET",
            url:siteurl+'wt_penawaran/GetProduk',
            data:"jumlah="+jumlah,
            success:function(html){
               $("#list_spk").append(html);
			   $('.select').select2({
				   width:'100%'
			   });
            }
        });
    }	
	$(document).on('blur', '#upload_po', function(){
		var po = $(this).data('upload_po');
		if(po !='')
		{
			$('#simpan-com2').show();
		}
		
	});

	function HapusItem(id){
		$('#list_spk #tr_'+id).remove();
		
	}

    function CariDetail(id){
		
        var id_material=$('#used_no_surat_'+id).val();

		$.ajax({
            type:"GET",
            url:siteurl+'wt_penawaran/CariNamaProduk',
            data:"id_category3="+id_material+"&id="+id,
            success:function(html){
               $('#nama_produk_'+id).html(html);
            }
        });
			
    }


	function Freight(id)
		{
			var freight=$('#used_freight_cost_'+id).val();
			$('#used_freight_cost_'+id).val(number_format(freight,2));	

			HitungTotal(id);

		}

		function HitungTotal(id){
	    var qty=$('#used_qty_so_'+id).val();
		var harga=$('#used_harga_satuan_'+id).val();
		var diskon=$('#used_diskon_'+id).val();
		var freight=$('#used_freight_cost_'+id).val().split(",").join("");
		
		
		
		var totalBerat = getNum(qty) * getNum(harga);
		var nilai_diskon = (getNum(diskon) * getNum(totalBerat))/100;
		var total_harga =  getNum(totalBerat) - getNum(nilai_diskon)+getNum(freight);

		
		$('#used_total_harga_'+id).val(number_format(total_harga,2));	
		$('#used_nilai_diskon_'+id).val(number_format(nilai_diskon,2));	
			


		HitungLoss(id);

		totalBalanced();
		
		
		

		
			
		}



		function totalBalanced(){
		
		var SUMx = 0;
		$(".total" ).each(function() {
			SUMx += Number($(this).val().split(",").join(""));
		});
		
		
		$('.totalproduk').val(number_format(SUMx,2));

		$('#grandtotal').val(number_format(SUMx,2));	

		

		
		}


		function HitungRevenue(){
		var invoice 		=$('#total_so').val().split(",").join("");
		var hpp     		=$('#sisa_hpp').val().split(",").join("");	
		var persentase 		=$('#persen_pengakuan').val();
	
		var   nilai_invoice  = (getNum(invoice) * getNum(persentase))/100;
		var   nilai_hpp      = (getNum(hpp));

	

		
		$('#pengakuan_invoice').val(number_format(nilai_invoice));		
		$('#pengakuan_hpp').val(number_format(nilai_hpp));			
		}


		function HitungLoss(id){
	    var qty=$('#used_qty_'+id).val();
		var stok=$('#used_stok_tersedia_'+id).val();
		
		
		var totalstok      = getNum(qty) + getNum(stok);
		var totalselisih   = getNum(stok) - getNum(qty);
		var total_loss     =  getNum(totalstok) + getNum(totalselisih);
		var loss_nilai     = getNum(totalselisih) * -1;

		if (totalselisih >= 0)
		{
			var loss = 0;

		}
		else
		{
			var loss = loss_nilai;
		}

		
		if(order_sts=='ind')
		{
			$('#used_potensial_loss_'+id).val('0');		
		}else{
			$('#used_potensial_loss_'+id).val(number_format(loss,2));		
		}	
					
		}

		
			
		function getNum(val) 
		{
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


		$(function() {
               $("#tanggal2").datepicker({ dateFormat: "yyyy-mm-dd" }).val()
       });



</script>