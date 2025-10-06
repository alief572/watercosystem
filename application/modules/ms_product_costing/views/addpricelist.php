<?php
    $ENABLE_ADD     = has_permission('Product_Costing.Add');
    $ENABLE_MANAGE  = has_permission('Product_Costing.Manage');
    $ENABLE_VIEW    = has_permission('Product_Costing.View');
    $ENABLE_DELETE  = has_permission('Product_Costing.Delete');
	$tanggal = date('Y-m-d');
?>

<div class="box box-primary">
    <div class="box-body">
		<form id="data-form" method="post">
			<div class="col-sm-12">
				<div class="input_fields_wrap2">
			<div class="row">
		    <center><label for="customer" ><h3>Calculation</h3></label></center>
			<br>
			<br>
                    <div class="col-sm-12">
                        <div class="col-sm-6">  		
                            <div class="form-group row">
								<div class="col-md-4">
                                <label for="customer">Purpose Product (Lv 1)</label>
                                </div>
                                <div class="col-md-6">
                                    <select id="inventory_1" name="inventory_1" class="form-control select" onchange="get_inv2()" required>
                                    <option value="">-- Pilih Purpose Product (Lv 1) --</option>
                                        <?php foreach ($results['inventory_1'] as $inventory_1){
                                        ?>
                                        <option value="<?= $inventory_1->id_type?>"><?= $inventory_1->nama?></option>
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
                                <label for="customer">Product Type (lv 2)</label>
                                </div>
                                <div class="col-md-6">
                                    <select id="inventory_2" name="inventory_2" class="form-control select" onchange="get_inv3()" required>
                                    <option value="">-- Pilih Product Type (lv 2) --</option>
                                    <?php foreach ($results['inventory_2'] as $inventory_2){
                                    ?>
                                    <option value="<?= $inventory_2->id_category1?>"><?= $inventory_2->nama?></option>
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
                                    <label for="customer">Usage (lv 3)</label>
                                </div>
                                <div class="col-md-6">
                                    <select id="inventory_3" name="inventory_3" class="form-control select" onchange="get_inv4()" required>
                                    <option value="">-- Pilih Usage (lv 3) --</option>
                                    <?php foreach ($results['inventory_3'] as $inventory_3){
                                    ?>
                                    <option value="<?= $inventory_3->id_category2?>"><?= $inventory_3->nama?></option>
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
                                    <label for="customer">Product Name (lv 4)</label>
                                </div>
                                <div class="col-md-6">
                                    <select id="inventory_4" name="inventory_4" class="form-control select" required>
                                    <option value="">-- Pilih Product Name (lv 4) --</option>
                                    <?php foreach ($results['inventory_4'] as $inventory_4){
                                    ?>
                                    <option value="<?= $inventory_4->id_category3?>"><?= $inventory_4->nama?></option>
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
									<label for="customer">Formula</label>
								</div>
								<div class="col-md-6">
								<select id="id_material" name="id_material" class="form-control select" onChange='GetProduk()' required>
											<option value="">--Pilih--</option>
												<?php foreach ($results['material'] as $material){
												?>
											<option value="<?= $material->id_category2?>"><?= ucfirst(strtolower($material->nama_category2))?></option>
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
									<label for="customer">Kurs</label>
								</div>
								<div class="col-md-6">
								<?php foreach ($results['kurs'] as $kurs){}
                                        ?>
									<input type="text" class="form-control autoNumeric" id="kurs"  required name="kurs" placeholder="Kurs" value="<?=$kurs->nilai_kurs ?>" readonly>
								</div>
							</div>
						</div>
						
					</div>
                    <div class="col-sm-12">
						<div class="col-sm-6">
							<div class="form-group row">
								<div class="col-md-4">
									<label for="customer">Purchase Price</label>
								</div>
								<div class="col-md-6">
									<input type="text" class="form-control autoNumeric" id="harga_beli"  required name="harga_beli" placeholder="Purchase Price">
								</div>
							</div>
						</div>
						
					</div>
                    <br>
					<br>
		            <div class="col-sm-12">
					    <div class="col-sm-12">
						    <?php if(empty($results['view'])){ ?>
						    <div class="form-group row">
								<button type='button' class='btn btn-sm btn-success' title='Ambil' id='tbh_ata' data-role='qtip' onClick='GetProduk();'><i class='fa fa-plus'></i>Add</button>
							</div>
						    <?php } ?>
							<div class="form-group row" >
								<table class='table table-bordered table-striped'>
									<thead>
										<tr class='bg-blue'>
											<th width='3%'>No</th>
                                            <th width='5%'>Elemen Costing</th>
                                            <th width='5%'>Persentase</th>
											<th width='5%'>Nilai</th>
											<th width='5%'>Nilai Rupiah</th>
                                            <th width='5%'>Keterangan</th>																					
											<th width='3%'>Aksi</th>
										</tr>
									</thead>
									<tbody id="list_spk">														
									</tbody>
									<tfoot>
									<tfoot>
									    <tr>
											<th width='3%'></th>
											<th width='5%' >Harga Akhir</th>
											<th width='5%'></th>	
											<th width='5%'><input type='text' class='form-control total_price' id='total_price'  name='total_price' readonly ></th>
											<th width='5%'><input type='text' class='form-control total_price_rp' id='total_price_rp' value="<?=$hd->harga_rupiah?>" name='total_price_rp' readonly ></th>
										    <th width='3%'></th>
											
										</tr>    									   										
									</tfoot>
								</table>
						    </div>
					    </div>
				    </div>
					
                    <center>
                    <button type="submit" class="btn btn-success btn-sm" name="save" id="simpan-com"><i class="fa fa-save"></i>Simpan</button>
                    <a class="btn btn-danger btn-sm" href="<?= base_url('/ms_product_costing/calculation') ?>"  title="Edit">Kembali</a>
                    </center>
		</form>		  
	</div>
</div>	
	
				  
				  
<script src="<?= base_url('assets/js/autoNumeric.js')?>"></script>					  
<script type="text/javascript">
	//$('#input-kendaraan').hide();
	
	var base_url			= '<?php echo base_url(); ?>';
	var active_controller	= '<?php echo($this->uri->segment(1)); ?>';
	$(document).ready(function(){	
			var max_fields2      = 10; //maximum input boxes allowed
			var wrapper2         = $(".input_fields_wrap2"); //Fields wrapper
			var add_button2      = $(".add_field_button2"); //Add button ID		

			$('.select').select2({
				width: '100%'
			});

			$('.autoNumeric').autoNumeric();

	$('#simpan-com').click(function(e){
			e.preventDefault();
			var deskripsi	= $('#deskripsi').val();
			var image	= $('#image').val();
			var id_material	= $('#inventory_4').val();
			
			var data, xhr;

			if (id_material == '') {
				swal({
					title: "Warning!",
					text: "Produk masih kosong!",
					type: "warning",
					timer: 3000
				});
				return false;
			}else {
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
								var baseurl=siteurl+'ms_product_costing/SaveNewPricelist';
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
											window.location.href = base_url + active_controller+'/calculation';
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
		HapusItem(1);
		var jumlah	=$('#list_spk').find('tr').length;
        var id = $('#id_material').val();
		$.ajax({
            type:"GET",
            url:siteurl+'ms_product_costing/GetPersenPricelist/'+id,
            data:"jumlah="+jumlah,
            success:function(html){
               $("#list_spk").append(html);
			   $('.select').select2({
				   width:'100%'
			   });
            }
        });
    }	

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

	$(document).on('blur','#harga_beli', function(){
		var beli		= $(this).val();
		$("#harga_beli").val(number_format(beli,2));
        cariRumusA();
        cariRumusB();
        cariRumusC();
        cariRumusD();
        cariRumusE();
        cariRumusF();
        cariRumusG();

	});

	$(document).on('blur','#used_persentase_bm_1', function(){
		var beli		= $(this).val();
		$("#used_persentase_bm_1").val(number_format(beli,2));
	});

	$(document).on('blur','#used_persentase_lc_1', function(){
		var beli		= $(this).val();
		$("#used_persentase_lc_1").val(number_format(beli,2));
		cariRumusA();
	});

	$(document).on('blur','#used_persentase_oc_1', function(){
		var beli		= $(this).val();
		$("#used_persentase_oc_1").val(number_format(beli,2));
		cariRumusB();
	});

	$(document).on('blur','#used_persentase_margin_1', function(){
		var beli		= $(this).val();
		$("#used_persentase_margin_1").val(number_format(beli,2));
		cariRumusC();
	});

	$(document).on('blur','#used_persentase_dd_1', function(){
		var beli		= $(this).val();
		$("#used_persentase_dd_1").val(number_format(beli,2));
		cariRumusD();
	});

	$(document).on('blur','#used_persentase_da_1', function(){
		var beli		= $(this).val();
		$("#used_persentase_da_1").val(number_format(beli,2));
		cariRumusE();
	});

	$(document).on('blur','#used_persentase_de_1', function(){
		var beli		= $(this).val();
		$("#used_persentase_de_1").val(number_format(beli,2));
		cariRumusF();
	});

	$(document).on('blur','#used_persentase_aj_1', function(){
		var beli		= $(this).val();
		$("#used_persentase_aj_1").val(number_format(beli,2));
		cariRumusG();
	});



	function cariRumusA()
	{
		
		var bm	= Number($('#used_persentase_bm_1').val().split(",").join("")); 
		var lc  = Number($('#used_persentase_lc_1').val().split(",").join(""));  		
		var harga	= Number( $('#harga_beli').val().split(",").join(""));
        var kurs	= Number( $('#kurs').val().split(",").join(""));
		
		
		var A = (getNum(bm)/getNum(100))+(getNum(lc)/getNum(100));
		var B = (getNum(A)*getNum(harga));
		var C =  getNum(B)+getNum(harga);	
        var D =  getNum(C)*getNum(kurs);	
		
		$('#used_nilai_lc_1').val(number_format(C,2));	
        $('#used_nilai_lc_rp_1').val(number_format(D,2));	
	}

	function cariRumusB()
	{
		
		var nilailc  = Number($('#used_nilai_lc_1').val().split(",").join(""));  		
		var op 		 = Number($('#used_persentase_oc_1').val().split(",").join(""));  
        var kurs	= Number( $('#kurs').val().split(",").join(""));
		
		
		var A = getNum(1) - getNum(op/100);
		var B = getNum(nilailc) / getNum(A);
        var C =  getNum(B)*getNum(kurs);	
		$('#used_nilai_oc_1').val(number_format(B,2));	
        $('#used_nilai_oc_rp_1').val(number_format(C,2));	
	}

	function cariRumusC()
	{
		
		var nilai  		 = Number($('#used_nilai_oc_1').val().split(",").join(""));  		
		var persen		 = Number($('#used_persentase_margin_1').val().split(",").join("")); 
        var kurs	= Number( $('#kurs').val().split(",").join("")); 
		
		
		var A = getNum(1) - getNum(persen/100);
		var B = getNum(nilai) / getNum(A);
        var C =  getNum(B)*getNum(kurs);	
		$('#used_nilai_margin_1').val(number_format(B,2));	
        $('#used_nilai_margin_rp_1').val(number_format(C,2));	
	}


	function cariRumusD()
	{
		
		var nilai  		 = Number($('#used_nilai_margin_1').val().split(",").join(""));  		
		var persen		 = Number($('#used_persentase_dd_1').val().split(",").join(""));  
        var kurs	     = Number( $('#kurs').val().split(",").join("")); 
		
		
		var A = getNum(1) - getNum(persen/100);
		var B = getNum(nilai) / getNum(A);
        var C =  getNum(B)*getNum(kurs);	
		$('#used_nilai_dd_1').val(number_format(B,2));	
        $('#used_nilai_dd_rp_1').val(number_format(C,2));	
	}
	function cariRumusE()
	{
		
		var nilai  		 = Number($('#used_nilai_dd_1').val().split(",").join(""));  		
		var persen		 = Number($('#used_persentase_da_1').val().split(",").join(""));  
        var kurs	     = Number( $('#kurs').val().split(",").join("")); 
		
		
		var A = getNum(1) - getNum(persen/100);
		var B = getNum(nilai) / getNum(A);
        var C =  getNum(B)*getNum(kurs);	
		$('#used_nilai_da_1').val(number_format(B,2));	
        $('#used_nilai_da_rp_1').val(number_format(C,2));
	}
	function cariRumusF()
	{
		
		var nilai  		 = Number($('#used_nilai_da_1').val().split(",").join(""));  		
		var persen		 = Number($('#used_persentase_de_1').val().split(",").join(""));  
        var kurs	     = Number( $('#kurs').val().split(",").join("")); 
		
		
		var A = getNum(1) - getNum(persen/100);
		var B = getNum(nilai) / getNum(A);
        var C =  getNum(B)*getNum(kurs);	
		$('#used_nilai_de_1').val(number_format(B,2));	
        $('#used_nilai_de_rp_1').val(number_format(C,2));	
	}
	function cariRumusG()
	{
		
		var nilai  		 = Number($('#used_nilai_de_1').val().split(",").join(""));  		
		var persen		 = Number($('#used_persentase_aj_1').val().split(",").join(""));  
        var kurs	     = Number( $('#kurs').val().split(",").join("")); 
		
		
		var A = getNum(1) + getNum(persen/100);
		var B = getNum(nilai) * getNum(A);
		var C = Math.round(B);

        var D =  getNum(B)*getNum(kurs);	
        var E =  getNum(C)*getNum(kurs);	

		$('#used_nilai_aj_1').val(number_format(B,2));	
        $('#used_nilai_aj_rp_1').val(number_format(D,2));	

		$('#total_price').val(number_format(C,2));	
        $('#total_price_rp').val(number_format(E,2));
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

    function get_inv2(){
        var inventory_1=$("#inventory_1").val();
		 $.ajax({
            type:"GET",
            url:siteurl+'inventory_4/get_inven2',
            data:"inventory_1="+inventory_1,
            success:function(html){
               $("#inventory_2").html(html);
            }
        });
    }

    function get_inv3() {
 	var id_type = $("#inventory_1").val();
    var id_category1 = $("#inventory_2").val();
    $.ajax({
        type: "GET",
		url: siteurl + 'ms_product_costing/get_inven3',
        data:"id_type="+id_type+"&inventory_2="+id_category1,
        success: function(html) {
            $("#inventory_3").html(html);
        }
    });
}

    function get_inv4(){
        var inventory_3=$("#inventory_3").val();
		 $.ajax({
            type:"GET",
            url:siteurl+'inventory_4/get_inven4',
            data:"inventory_3="+inventory_3,
            success:function(html){
               $("#inventory_4").html(html);
            }
        });
    }

</script>