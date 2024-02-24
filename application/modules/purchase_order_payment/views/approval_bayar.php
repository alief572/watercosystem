
<?php
	$tanggal = date('Y-m-d');
foreach ($results['head'] as $head){
}	

foreach ($results['hutang'] as $hutang){
}	

?>

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
					<select id="id_suplier" name="id_suplier" class='form-control input-md chosen-select'required>
						<option value="">--Pilih--</option>
							<?php foreach ($results['supplier'] as $supplier){
							$selected = ($supplier->id_suplier == $head->id_suplier)?'selected':'';	
								?> 
						<option value="<?= $supplier->id_suplier?>" <?=$selected;?>><?= strtoupper(strtolower($supplier->name_suplier))?></option>
							<?php } ?>
					</select>
				</div>
			</div>
		</div>
				<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="id_customer">Local / Import</label>
				</div>
				<div class="col-md-8" id='ubahloi'>
					<select id="loi" name="loi" class="form-control select"  onchange="get_kurs()"  required>
						<option value="">--Pilih--</option>
						<?php
						if($head->loi == "Import"){
						echo"
						<option value='Import' selected>Import</option>
						<option value='Lokal'>Lokal</option>
						";
						}elseif($head->loi == "Lokal"){
						echo"
						<option value='Import'>Import</option>
						<option value='Lokal' selected>Lokal</option>
						";
						}else{
						echo"
						<option value='Import'>Import</option>
						<option value='Lokal'>Lokal</option>
						";
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
					<label for="customer">NO.Incoming</label>
				</div>
				<div class="col-md-8" hidden>
					<input type="text" class="form-control" id="no_po"  value="<?= $head->no_po  ?>" required name="no_po" readonly placeholder="ID PO">
				</div>
				<div class="col-md-8" hidden>
					<input type="text" class="form-control" id="no_surat" value="<?= $head->no_surat  ?>"  required name="no_surat" readonly placeholder="No.PR">
				</div>
				<div class="col-md-8" hidden>
					<input type="text" class="form-control" id="id_data"  value="<?= $hutang->id_data  ?>" required name="id_data" readonly placeholder="ID PO">
				</div>
				<div class="col-md-8">
					<input type="text" class="form-control" id="id_incoming" value="<?= $hutang->id_incoming  ?>"  required name="id_incoming" readonly placeholder="No.PR">
				</div>
				<div class="col-md-8" hidden>
				<input type="date" class="form-control" id="tanggal" value="<?= $head->tanggal ?>" onkeyup required name="tanggal" readonly >
                </div>
			</div>
			</div>

		    <div class="col-sm-6">
            <div class="form-group row">
                <div class="col-md-4">
                    <label for="customer">Kurs</label>
                </div>
                <div class="col-md-8">
                    <?php if($hutang->matauang =='idr') { ?>
                    <input type='hidden' class='form-control' value="<?= $hutang->kurs  ?>" id='nominal_kurs'  required name='nominal_kurs'  placeholder='Nominal Kurs'> 
                    <?php } else{ ?>
                    <input type='text' class='form-control' value="<?= $hutang->kurs_request  ?>" id='nominal_kurs'  required name='nominal_kurs'  placeholder='Nominal Kurs'> 
                    <?php }?>
                </div>
		    </div>
		    </div>
        </div>
		<div class="col-sm-12" hidden>
			<div class="col-sm-6">
				<div class="form-group row">
					<div class="col-md-4">
						<label for="customer">Mata Uang</label>
					</div>
					<div class="col-md-8">
					<select id="matauang" name="matauang" class='form-control input-md chosen-select'required>
							<?php foreach ($results['matauang'] as $supplier){
                                if($supplier->kode==$hutang->matauang){
                                    $selected = 'selected';	
                                }
                                else{
                                    $selected = '';	
                                }
							
								?> 
						<option value="<?= $supplier->kode?>" <?=$selected;?>><?= strtoupper(strtolower($supplier->kode))?></option>
							<?php } ?>
					</select>
				</div>
				</div>
			</div>
			<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="id_customer">Tanggal Bayar</label>
				</div>
				<div class="col-md-8"> 
				<input type="date" class="form-control" id="tanggal_bayar" value="<?= date('Y-m-d') ?>" onkeyup required name="tanggal_bayar" >
					
				</div>
			</div>
		</div>
		</div>
        
		<div class="col-sm-12" hidden>
            <div class="col-sm-6">
                <div class="form-group row">
				    <div class="col-md-4">
					    <label for="id_customer">Pilih Bank</label>
				    </div>
                    <div class="col-md-8"> 
                        <select class="form-control input-sm" name="bank" id="bank">
                        <option value="">Pilih Bank</option>
                        <option value="1102-01-01">CIMB NIAGA IDR  8000.9570.4600</option>
                        <option value="1102-01-02">BCA IDR 870.003.599.0</option>
                        <option value="1102-01-06">CIMB NIAGA USD 8000.9633.1040</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
				<div class="form-group row">
					<div class="col-md-4">
						<label for="customer"></label>
					</div>
					<div class="col-md-8">
						</div>
				</div>
			</div>
		</div> 

        <div class="col-sm-12">
            <div class="col-sm-6"hidden>
                <div class="form-group row">
				    <div class="col-md-4">
					    <label for="id_customer">Total PO</label>
				    </div>
                    <div class="col-md-8"> 
                    <input type="input" class="form-control" id="total_po" value="<?= number_format($head->subtotal) ?>" onkeyup required name="total_po" readonly >
					</div>
                </div>
            </div>
            <div class="col-sm-6">
				<div class="form-group row">
					<div class="col-md-4">
						<label for="customer">Total Hutang USD</label>
					</div>
					<div class="col-md-8">
					 <?php if($hutang->matauang =='usd') { ?>
                    <input type="input" class="form-control" id="total_ap" value="<?= number_format($hutang->hutang_kurs,2) ?>" onkeyup required name="total_ap" readonly >
					<?php } else{ ?>
                    <input type="input" class="form-control" id="total_ap" value="0" onkeyup required name="total_ap" readonly >
					<?php } ?>
					</div>
				</div>
			</div>
		</div> 

        <div class="col-sm-12">
            <div class="col-sm-6">
                <div class="form-group row">
				    <div class="col-md-4">
					    <label for="id_customer">Total Hutang IDR</label>
				    </div>
                    <div class="col-md-8"> 
					<input type="input" class="form-control" id="total_ap_idr" value="<?= number_format($hutang->hutang_idr)?>" onkeyup required name="total_ap_idr" readonly >
					</div>
                </div>
            </div>
            <div class="col-sm-6">
				<div class="form-group row">
					<div class="col-md-4">
                    <label for="id_customer">Rencana Bayar <?= strtoupper($hutang->matauang) ?></label>
					</div>
					<div class="col-md-8">
                    <input type="input" class="form-control" id="total_bayar"  onblur="separator()" required name="total_bayar" value="<?= number_format($hutang->rencana_bayar_idr,2)?>" readonly>	
					</div>
				</div>
			</div>
		</div> 

				
		    <center>
		    <button type="submit" class="btn btn-success btn-sm" name="save" id="simpan-com"><i class="fa fa-save">&nbsp;</i>Approve Pembayaran</button>
		    <button type="submit" class="btn btn-warning btn-sm" name="save" id="simpan-com2"><i class="fa fa-save">&nbsp;</i>Reject Pembayaran</button>
		   
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

			$(".bilangan-desimal").maskMoney();
			$('.autoNumeric3').autoNumeric('init', { vMin: 0, mDec: 3 });
			$('.autoNumeric').autoNumeric();

	SumDel();
	let id_suplier = $('#id_suplier').val();
	let no_po = "<?=$this->uri->segment(3);?>";
	if(id_suplier != '' && id_suplier != '0'){
		$.ajax({
			type	: "POST",
			url		: siteurl+'purchase_order/getPR',
			data	: {
				'id_suplier' : id_suplier,
				'no_po' : no_po
			},
			cache	: false,
			dataType: 'json',
			success:function(data){
				$('#no_pr').html(data.option).trigger("chosen:updated");
			}
		});
	}

	$(document).on('change','#id_suplier',function(){
		let id_suplier = $('#id_suplier').val();
		$.ajax({
			type	: "POST",
			url		: siteurl+'purchase_order/getPR',
			data	: {
				'id_suplier' : id_suplier
			},
			cache	: false,
			dataType: 'json',
			success:function(data){
				$('#no_pr').html(data.option).trigger("chosen:updated");
			}
		});
	});

	$(document).on('click','.hapus_baris',function(){
		$(this).parent().parent().remove();
		SumDel();
	});


	$('#simpan-com').click(function(e){
			e.preventDefault();
			var deskripsi	= $('#deskripsi').val();
			var expect_tanggal	= $('#expect_tanggal').val();
			var loi	= $('#loi').val();
			var term	= $('#term').val();
			var tanggal	= $('#tanggal_bayar').val();
			var bank	= $('#bank').val();
			
			var data, xhr;
				if(tanggal == '' || tanggal == null){
					swal("Warning", "Tanggal Tidak Boleh Kosong :)", "error");
					return false;
					}
								
					else			
					{
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
						var baseurl=siteurl+'purchase_order_payment/SaveApproval';
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
				}
		});
		

        $('#simpan-com2').click(function(e){
			e.preventDefault();
			var deskripsi	= $('#deskripsi').val();
			var expect_tanggal	= $('#expect_tanggal').val();
			var loi	= $('#loi').val();
			var term	= $('#term').val();
			var tanggal	= $('#tanggal_bayar').val();
			var bank	= $('#bank').val();
			
			var data, xhr;
				if(tanggal == '' || tanggal == null){
					swal("Warning", "Tanggal Tidak Boleh Kosong :)", "error");
					return false;
					}
								
					else			
					{
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
						var baseurl=siteurl+'purchase_order_payment/SaveReject';
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
				}
		});
		
});
function addmaterial(){ 
		var jumlah	=$('#data_request').find('tr').length;
		var id_suplier=$("#id_suplier").val();
		var loi=$("#loi").val();
		var angka =jumlah+1;
				if( id_suplier == '' || id_suplier == null || loi == '' || loi == null){
					swal("Warning", "Silahkan Pilih Supplier Terlebih Dahulu :)", "error");
					return false;
		}else{
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/AddMaterial',
            data:"jumlah="+jumlah+"&id_suplier="+id_suplier+"&loi="+loi,
            success:function(html){
               $("#data_request").append(html);
			   $(".bilangan-desimal").maskMoney();
			   $(".chosen-select").select2({ width: '100%' });
			   $('.autoNumeric3').autoNumeric('init', { vMin: 0, mDec: 3 });
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/UbahImport',
            data:"loi="+loi,
            success:function(html){
               $("ubahloi").html(html);
            }
        });
		}
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
		function CariPrice(id){
		 var dt_ratelme=$("#dt_ratelme_"+id).val();
		 var dt_idmaterial=$("#dt_idmaterial_"+id).val();
		 if( dt_idmaterial == '' || dt_idmaterial == null){
					swal("Warning", "Silahkan Pilih Material Terlebih Dahulu :)", "error");
					return false;
		}else{
		 $.ajax({
            type:"GET",
            url:siteurl+'purchase_order/CariPrice',
            data:"dt_ratelme="+dt_ratelme+"&dt_idmaterial="+dt_idmaterial+"&id="+id,
            success:function(html){
               $("#dt_alloyprice_"+id).val(html);
            }
        });
		}
    }
	function get_kurs(){
        var loi=$("#loi").val();
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/FormInputKurs',
            data:"loi="+loi,
            success:function(html){
               $("#input_kurs").html(html);
            }
        });
    }
function HitungUP(id){
       var alloyprice=$("#dt_alloyprice_"+id).val();
		 var fabcost=$("#dt_fabcost_"+id).val();
		 var diskon=$("#dt_diskon_"+id).val();
		 var pajak=$("#dt_pajak_"+id).val();
		 var qty=$("#dt_qty_"+id).val();
		 var hargasatuan=$("#dt_hargasatuan_"+id).val();
		 var loi=$("#loi").val();
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/HitungUP',
            data:"fabcost="+fabcost+"&alloyprice="+alloyprice+"&hargasatuan="+hargasatuan+"&loi="+loi,
            success:function(html){
                // $("#dt_hargasatuan_"+id).val(html); 
				HitAmmount(id)
				$('.autoNumeric3').autoNumeric('init', { vMin: 0, mDec: 3 });
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/Hitjumlah',
            data:"fabcost="+fabcost+"&alloyprice="+alloyprice+"&pajak="+pajak+"&diskon="+diskon+"&qty="+qty+"&hargasatuan="+hargasatuan+"&loi="+loi,
            success:function(html){
                $("#dt_jumlahharga_"+id).val(html); 
            }
        });
		
		$('.autoNumeric3').autoNumeric('init', { vMin: 0, mDec: 3 });
		
    }
	
	function HitungUPIm(id){
       var alloyprice=$("#dt_alloyprice_"+id).val();
		 var fabcost=$("#dt_fabcost_"+id).val();
		 var diskon=$("#dt_diskon_"+id).val();
		 var pajak=$("#dt_pajak_"+id).val();
		 var qty=$("#dt_qty_"+id).val();
		 var hargasatuan=$("#dt_hargasatuan_"+id).val();
		 var dt_width=$("#dt_totalwidth_"+id).val();
		 
		 var loi=$("#loi").val();
		 // console.log(dt_width)
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/HitungUP',
            data:"fabcost="+fabcost+"&alloyprice="+alloyprice+"&hargasatuan="+hargasatuan+"&loi="+loi,
            success:function(html){
                // $("#dt_hargasatuan_"+id).val(html); 
				HitAmmount(id)
				$('.autoNumeric3').autoNumeric('init', { vMin: 0, mDec: 3 });
            }
        });
		// $.ajax({
            // type:"GET",
            // url:siteurl+'purchase_order/Hitjumlah',
            // data:"fabcost="+fabcost+"&alloyprice="+alloyprice+"&pajak="+pajak+"&diskon="+diskon+"&qty="+qty+"&hargasatuan="+hargasatuan+"&loi="+loi+"&dt_width="+dt_width,
            // success:function(html){
                // $("#dt_jumlahharga_"+id).val(html); 
            // }
        // });		
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
            url:siteurl+'purchase_order/CariPanjangMaterial',
            data:"idpr="+idpr+"&id="+id,
            success:function(html){
               $("#panjang_"+id).html(html); 
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/CariLebarMaterial',
            data:"idpr="+idpr+"&id="+id,
            success:function(html){
               $("#lebar_"+id).html(html); 
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

		var a;
		var ArrList = [];
		for(a=1; a<=100; a++){
			var dataid = $('#dt_idpr_'+a).val();
			ArrList.push(dataid); 
		}
		$.ajax({
            type:"POST",
            url:siteurl+'purchase_order/getDateExp',
            data:{
				'id_pr' : ArrList
			},
			dataType	: 'json',
            success:function(data){
				$('#expect_tanggal').val(data.minimal)
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
		var ratelme=$("#dt_ratelme_"+id).val();
		var alloyprice=$("#dt_alloyprice_"+id).val();
		var fabcost=$("#dt_fabcost_"+id).val();
		var panjang=$("#dt_panjang_"+id).val();
		var lebar=$("#dt_lebar_"+id).val();
		var jumlahharga=$("#dt_jumlahharga_"+id).val();
		var note=$("#dt_note_"+id).val();
		var subtotal=$("#subtotal").val();
		var hargatotal=$("#hargatotal").val();
		var diskontotal=$("#diskontotal").val();
		var taxtotal=$("#taxtotal").val();
		if( qty == '' || qty == null  || hargasatuan == '' || hargasatuan == null){
					swal("Warning", "Form Tidak Boleh Kosong :)", "error");
					return false;
		}else{
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/LockMatrial',
            data:"idpr="+idpr+"&id="+id+"&idmaterial="+idmaterial+"&width="+width+"&ratelme="+ratelme+"&alloyprice="+alloyprice+"&fabcost="+fabcost+"&panjang="+panjang+"&lebar="+lebar+"&totalwidth="+totalwidth+"&namaterial="+namaterial+"&description="+description+"&qty="+qty+"&hargasatuan="+hargasatuan+"&diskon="+diskon+"&pajak="+pajak+"&jumlahharga="+jumlahharga+"&note="+note,
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
	
	// function HitAmmount(id){
    //   	  var alloyprice=$("#dt_alloyprice_"+id).val();
	// 	 var fabcost=$("#dt_fabcost_"+id).val();
	// 	 var diskon=$("#dt_diskon_"+id).val();
	// 	 var pajak=$("#dt_pajak_"+id).val();
	// 	 var qty=$("#dt_qty_"+id).val();
	// 	 var hargasatuan=$("#dt_hargasatuan_"+id).val();
	// 	 var dt_width=$("#dt_totalwidth_"+id).val();
		 
	// 	 var loi=$("#loi").val();
	// 	$.ajax({
    //         type:"GET",
    //         url:siteurl+'purchase_order/Hitjumlah',
    //         data:"fabcost="+fabcost+"&alloyprice="+alloyprice+"&pajak="+pajak+"&diskon="+diskon+"&qty="+qty+"&hargasatuan="+hargasatuan+"&loi="+loi+"&dt_width="+dt_width,
    //         success:function(html){
    //             $("#dt_jumlahharga_"+id).val(html); 
    //         }
    //     });		
		
    // }
	
	function HitAmmount(id){
      	var alloyprice 	= getNum($("#dt_alloyprice_"+id).val().split(",").join(""));
		var fabcost		= getNum($("#dt_fabcost_"+id).val().split(",").join(""));
		var diskon		= getNum($("#dt_diskon_"+id).val().split(",").join(""));
		var pajak		= getNum($("#dt_pajak_"+id).val().split(",").join(""));
		var qty			= getNum($("#dt_qty_"+id).val().split(",").join(""));
		var hargasatuan	= getNum($("#dt_hargasatuan_"+id).val().split(",").join(""));
		var dt_width	= getNum($("#dt_totalweight_"+id).val().split(",").join(""));
		var loi			= $("#loi").val();

		if(loi == 'Import'){
			var total 	= Number(alloyprice) + Number(fabcost);
			var jumlah 	= total * dt_width;	

			$("#dt_hargasatuan_"+id).val(number_format(total,3));
		}
		else{
			var total 	= hargasatuan;
			var jumlah 	= hargasatuan * dt_width;
		}

		var tot_pajak 	= pajak / 100 * jumlah;
		var tot_diskon = diskon / 100 * jumlah;
		var tot_jumlah = jumlah - tot_diskon + tot_pajak;

		

		$("#dt_jumlahharga_"+id).val(number_format(jumlah,3));

		$("#dt_ch_pajak_"+id).val(tot_pajak);
		$("#dt_ch_diskon_"+id).val(tot_diskon);
		$("#dt_ch_jumlah_"+id).val(tot_jumlah);

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

	function separator(){
      	var bayar    	= getNum($("#total_bayar").val());		
		$("#total_bayar").val(number_format(bayar,2));	
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
<script src="<?= base_url('assets/js/jquery.maskMoney.js')?>"></script>
<script src="<?= base_url('assets/js/autoNumeric.js')?>"></script>
<script>
	$(function() {
		$('.chosen-select').select2({ width: '100%' }); 
		$('select').select2({ width: '100%' }); 
		$('#tanggal').datepicker({
			format : 'yyyy-mm-dd'
			// minDate: 0
		});
    });
</script>