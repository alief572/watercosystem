<?php
	$tanggal = date('Y-m-d');
?>

 <div class="box box-primary">
    <div class="box-body">
		<form id="data-form" method="post" autocomplete='off' data-po-direct="1">
        <input type="hidden" id="kirim" name="kirim" value="0">
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
					<select id="id_suplier" name="id_suplier" class='form-control input-md chosen-select'  onchange="get_lokasi()"  required>
						<option value="">--Pilih--</option>
							<?php foreach ($results['supplier'] as $supplier){?> 
						<option value="<?= html_escape($supplier->id_suplier) ?>" ><?= html_escape(strtoupper(strtolower($supplier->name_suplier))) ?></option>
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
				<div class="col-md-8" id="ubahloi">
					<select id="loi" name="loi" class="form-control select"  onchange="get_kurs()"  required>
						<option value="">--Pilih--</option>
						<option value="Import">Import</option>
						<option value="Lokal">Lokal</option>
					</select>
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
				<input type="text" class="form-control" id="no_po"  required name="no_po" readonly placeholder="ID PO">
			</div>
			<div class="col-md-8">
				<input type="text" class="form-control" id="no_surat"  required name="no_surat" readonly placeholder="No.PO">
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
				<input type="text" class="form-control" id="tanggal" value="<?= $tanggal ?>" onkeyup required name="tanggal" placeholder="yyyy-mm-dd" >
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
							$selected = '';	
								?> 
						<option value="<?= html_escape($supplier->kode) ?>" <?=$selected;?>><?= html_escape(strtoupper(strtolower($supplier->kode))) ?></option>
							<?php } ?>
					</select>
				</div>
			</div>
		</div>
		</div>
				<!-- <div class="col-sm-12">
		<div class="col-sm-6">
		<div class="form-group row">
			<div class="col-md-4">
				<label for="customer">Expect Date</label>
			</div>
			<div class="col-md-8">
				<input type="date" class="form-control" id="expect_tanggal" required name="expect_tanggal"  >
			</div>
		</div>
		</div>
		</div> -->
				<div class="col-sm-12">
		<div class="col-sm-6">
		<div class="form-group row">
			<div class="col-md-4">
				<label for="customer">Payment Term</label>
			</div>
			<div class="col-md-8">
				<input type="text" class="form-control" id="term"  onkeyup required name="term" >
			</div>
		</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="id_customer">PR</label>
				</div>
				<div class="col-md-8"> 
					<select id="no_pr" name="no_pr" class='form-control input-md chosen-select'required>
						<option value="0">List Empty</option>
					</select>
				</div>
			</div>
		</div>
		</div>
		<div class="col-sm-12" hidden>
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="id_customer">Price Method</label>
				</div>
				<div class="col-md-8">
					<select id="cif" name="cif" class="form-control select"   required>
						<option value="">--Pilih--</option>
						<option value="CIF">CIF</option>
						<option value="FOB">FOB</option>
						<option value="LOCO">LOCO</option>
						<option value="DDU">DDU</option>
						<option value="FRANCO">FRANCO</option>
					</select>
				</div>
			</div>
		</div>
		</div>
		
		<div class="col-sm-12">
				<div class="form-group row">
		<!-- <button type='button' class='btn btn-sm btn-success' title='Ambil' id='tbh_ata' data-role='qtip' onClick='addmaterial();'><i class='fa fa-plus'></i>Add</button> -->

		</div>
		<div class="form-group row" >
			<table class='table table-bordered table-striped'>
			<thead>
			<tr class='bg-blue'>
				<th>Item</th>
				<th>Description</th>
				<th width='7%' hidden>Width</th>
				<th width='7%' hidden>Length</th>
				<th width='7%'>Qty</th>
				<th width='8%' hidden>Rate LME</th>
				<th width='7%' hidden>Alloy Price</th>
				<th width='7%' hidden>Fab Cost</th>
				<th width='7%'>Unit Price</th>
				<th width='6%' hidden>Disc %</th>
				<th width='6%' >Biaya Kirim</th>
				<th width='9%'>Amount</th>
				<th width='8%'>Note</th>
				<th width='5%'>#</th>
			</tr>
			</thead>
			<tbody id="data_request"><tr><td colspan='14'>Tidak ada daftar material</td></tr></tbody>
			</table>
		</div>

			<div class="form-group row" id="fortombol">
				<button type='button' class='btn btn-sm btn-success' title='Ambil' id='tbh_ata' onClick="addPO('1');"><i class='fa fa-plus'></i>Add</button>
			</div>
			<div class="form-group row" id="Form_Po">
			
			</div>
			
	</div>
		<div class="col-sm-12" hidden>
			<div class="col-sm-6">
				<div class="form-group row">
					<div class="col-md-4">
						<label for="customer">Expect Date</label>
					</div>
					<div class="col-md-8">
						<input type="text" class="form-control" id="expect_tanggal" required name="expect_tanggal"  readonly>
					</div>
				</div>
			</div>
			<div class="col-sm-6" >
				<div class="form-group row">
					<div class="col-md-2">
						<label for="customer">Note</label>
					</div>
					<div class="col-md-10">
						<input type="text" class="form-control"  id="note_ket" name="note_ket" >
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-12" >
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="id_customer">Sub Total</label>
				</div>
				<div class="col-md-8" id="ForHarga">
					<input readonly type="text" class="form-control" id="hargatotal"  onkeyup required name="hargatotal" >
				</div>
			</div>
		</div>
		</div>
				<div class="col-sm-12" hidden>
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="id_customer">Discount</label>
				</div>
				<div class="col-md-8" id="ForDiskon">
					<input readonly type="text" class="form-control" id="diskontotal"  onkeyup required name="diskontotal" >
				</div>
			</div>
		</div>
		</div>
		<div class="col-sm-12" >
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="id_customer">Biaya Kirim</label>
				</div>
				<div class="col-md-8" id="ForTax">
					<input readonly type="text" class="form-control" id="taxtotal"  onkeyup required name="taxtotal" >
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
					<input readonly type="text" class="form-control" id="subtotal"  onkeyup required name="subtotal" >
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

		$('.datepicker').datepicker({
			dateFormat: 'yy-mm-dd',
			changeMonth:true,
			changeYear:true,
		});

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

		$(document).on('change','#no_pr',function(){
			let loi = $('#loi').val();
			let no_pr = $(this).val();
			$.ajax({
				type	: "POST",
				url		: siteurl+'purchase_order/AddMaterial_Direct',
				data	: {
					'loi' : loi,
					'no_pr' : no_pr
				},
				cache	: false,
				dataType: 'json',
				success:function(data){
					$('#data_request').html(data.list_mat);
					$(".bilangan-desimal").maskMoney();
					$('.autoNumeric3').autoNumeric('init', { vMin: 0 });
					$('.autoNumeric').autoNumeric();
					$('#expect_tanggal').val(data.min_date);
				}
			});
		});

		$(document).on('click','.hapus_baris',function(){
			$(this).parent().parent().remove();
			SumDel();
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
			   $('.autoNumeric3').autoNumeric('init', { vMin: 0 });
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
		 // $.ajax({
            // type:"GET",
            // url:siteurl+'purchase_order/HitungHarga',
            // data:"dt_hargasatuan="+dt_hargasatuan+"&dt_qty="+dt_qty+"&id="+id,
            // success:function(html){
               // $("#jumlahharga_"+id).html(html);
            // }
        // });
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
				$('.autoNumeric3').autoNumeric('init', { vMin: 0 });
				HitAmmount(id)
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
		// $.ajax({
            // type:"GET",
            // url:siteurl+'purchase_order/CariweightMaterial',
            // data:"idpr="+idpr+"&id="+id,
            // success:function(html){
               // $("#width_"+id).html(html);
            // }
        // });
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/CariTweightMaterial',
            data:"idpr="+idpr+"&id="+id,
            success:function(html){
               $("#totalwidth_"+id).html(html);
            }
        });
		
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/CariWidthMaterial',
            data:"idpr="+idpr+"&id="+id,
            success:function(html){
               $("#width_"+id).html(html);
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
		var totalwidth=$("#dt_totalweight_"+id).val();
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
		
	}
	
	function HitungHarga2(id){
        var dt_qty=$("#dt_qty_"+id).val();
		 var dt_width=$("#dt_totalwidth_"+id).val();
		 var dt_hargasatuan=$("#dt_hargasatuan_"+id).val();
		 console.log(dt_width);
		 $.ajax({
            type:"GET",
            url:siteurl+'purchase_order/HitungHarga',
            data:"dt_hargasatuan="+dt_hargasatuan+"&dt_qty="+dt_qty+"&id="+id+"&dt_width="+dt_width,
            success:function(html){
               $("#jumlahharga_"+id).html(html);
            }
        });
		
    }
	
	function get_lokasi(){
        var supplier=$("#id_suplier").val();
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/CariLokasi',
            data:"supplier="+supplier,
            success:function(html){
               $("#loi").html(html);
			   get_kurs();
            }
			
        });
		
		
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
		$('.select').select2({ width: '100%' });
		$('#tanggal').datepicker({
			dateFormat: 'yy-mm-dd',
			changeMonth:true,
			changeYear:true,
		});
    });
</script>
<script src="<?= base_url('assets/js/purchase_order_form.js') ?>"></script>
