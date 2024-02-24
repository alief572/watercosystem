<?php
    $ENABLE_ADD     = has_permission('Product_Costing.Add');
    $ENABLE_MANAGE  = has_permission('Product_Costing.Manage');
    $ENABLE_VIEW    = has_permission('Product_Costing.View');
    $ENABLE_DELETE  = has_permission('Product_Costing.Delete');
	$tanggal = date('Y-m-d');
    foreach ($results['header'] as $hd){
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
                    <div class="col-sm-12" >
                        <div class="col-sm-6">  		
                            <div class="form-group row" hidden>
                                <div class="col-md-6" hidden>
                                <input type="text" class="form-control" id="id_product_costing" value="<?= $hd->id_product_costing?>" required name="id_product_costing" readonly placeholder="No.CRCL">
                                </div>
			               </div>
                        </div>
                    </div>
              

                    <div class="col-sm-12">
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label for="customer">USAGE (LV III)</label>
                                </div>
                                <div class="col-md-6">
                                    <select id="id_material" name="id_material" class="form-control select" onchange="get_inv4()" required>
                                    <option value="">-- Pilih Usage (lv 3) --</option>
                                    <?php foreach ($results['inventory_3'] as $inventory_3){
                                         $select3 = $hd->id_category2 == $inventory_3->id_category2 ? 'selected' : '';	?>
                                    ?>
                                    <option value="<?= $inventory_3->id_category2?>"<?=$select3?>><?= $inventory_3->nama?></option>
                                    <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                   
               
					

                    <?php } ?>
                    <br>
					<br>
		            <div class="col-sm-12">
					    <div class="col-sm-12">
						    <?php if(empty($results['view'])){ ?>
						    <div class="form-group row">
								<!-- <button type='button' class='btn btn-sm btn-success' title='Ambil' id='tbh_ata' data-role='qtip' onClick='GetProduk();'><i class='fa fa-plus'></i>Add</button> -->
							</div>
						    <?php } ?>
							<div class="form-group row" >
								<table class='table table-bordered table-striped'>
									<thead>
										<tr class='bg-blue'>
											<th width='3%'>No</th>
                                            <th width='5%'>Elemen Costing</th>
                                            <th width='5%'>Persentase</th>
											<th width='5%'>Keterangan</th>																					
											<th width='3%'>Aksi</th>
										</tr>
									</thead>
									<tbody id="list_spk">
                                    <?php $loop=1;
									                                                              
                                        $idcosting = $hd->id_product_costing;
                                        $bm		  = $this->db->query("SELECT a.* FROM ms_product_costing_detail as a WHERE a.id_product_costing='$idcosting' AND nama_komponen=1 ")->row();
                                        $lc		  = $this->db->query("SELECT a.* FROM ms_product_costing_detail as a WHERE a.id_product_costing='$idcosting' AND nama_komponen=2 ")->row();
                                        $oc		  = $this->db->query("SELECT a.* FROM ms_product_costing_detail as a WHERE a.id_product_costing='$idcosting' AND nama_komponen=3 ")->row();
                                        $margin	  = $this->db->query("SELECT a.* FROM ms_product_costing_detail as a WHERE a.id_product_costing='$idcosting' AND nama_komponen=4 ")->row();
                                        $dd		  = $this->db->query("SELECT a.* FROM ms_product_costing_detail as a WHERE a.id_product_costing='$idcosting' AND nama_komponen=5 ")->row();
                                        $da		  = $this->db->query("SELECT a.* FROM ms_product_costing_detail as a WHERE a.id_product_costing='$idcosting' AND nama_komponen=6 ")->row();
                                        $de		  = $this->db->query("SELECT a.* FROM ms_product_costing_detail as a WHERE a.id_product_costing='$idcosting' AND nama_komponen=7 ")->row();
                                        $aj		  = $this->db->query("SELECT a.* FROM ms_product_costing_detail as a WHERE a.id_product_costing='$idcosting' AND nama_komponen=8 ")->row();
                                        
                                       
                                        echo "
                                        <tr id='tr_$loop'>
                                            <td>1</td>
                                            <td>
                                                <select id='used_komponen_bm_$loop' name='dt[$loop][komponen_bm]' data-no='$loop' class='form-control select' required>
                                                    <option value=''>-Pilih-</option>";					
                                                    //foreach($komponen as $produk){
                                                    echo"<option value='1' selected>BM</option>";
                                                    //}
                                        echo	"</select>
                                            </td>";          
                                
                                        echo	"<td id='persentase_bm_$loop'><input type='text' align='right' class='form-control input-sm' id='used_persentase_bm_$loop' required name='dt[$loop][persentase_bm]' value='$bm->persentase' ></td>
                                                 <td id='nilai_bm_$loop' hidden><input type='text' align='right' class='form-control input-sm' id='used_nilai_bm_$loop' required name='dt[$loop][nilai_bm]'  value='$bm->nilai_costing' readonly></td>
                                                 <td id='keterangan_bm_$loop'><input type='text' align='right' class='form-control input-sm' id='used_keterangan_bm_$loop' required name='dt[$loop][keterangan_bm]' value='$bm->keterangan'></td>
                                                <td align='center'>
                                                <button type='button' class='btn btn-sm btn-danger' title='Hapus Data' data-role='qtip' onClick='return HapusItem($loop);'><i class='fa fa-close'></i></button>
                                                </td>
                                            
                                        </tr>
                                        <tr id='tr_$loop'>
                                            <td>2</td>
                                            <td>
                                                <select id='used_komponen_lc_$loop' name='dt[$loop][komponen_lc]' data-no='$loop' class='form-control select' required>
                                                    <option value=''>-Pilih-</option>";					
                                                    //foreach($komponen as $produk){
                                                    echo"<option value='2' selected>Landed Cost</option>";
                                                    //}
                                        echo	"</select>
                                            </td>";          
                                
                                        echo	"<td id='persentase_lc_$loop'><input type='text' align='right' class='form-control input-sm ' id='used_persentase_lc_$loop' required name='dt[$loop][persentase_lc]' value='$lc->persentase' ></td>
                                                 <td id='nilai_lc_$loop' hidden><input type='text' align='right' class='form-control input-sm ' id='used_nilai_lc_$loop' required name='dt[$loop][nilai_lc]' readonly value='$lc->nilai_costing'></td>
                                                 <td id='keterangan_lc_$loop'><input type='text' align='right' class='form-control input-sm' id='used_keterangan_lc_$loop' required name='dt[$loop][keterangan_lc]' value='$lc->keterangan'></td>
                                                <td align='center'>
                                                <button type='button' class='btn btn-sm btn-danger' title='Hapus Data' data-role='qtip' onClick='return HapusItem($loop);'><i class='fa fa-close'></i></button>
                                                </td>
                                            
                                        </tr>
                                        <tr id='tr_$loop'>
                                            <td>3</td>
                                            <td>
                                                <select id='used_komponen_oc_$loop' name='dt[$loop][komponen_oc]' data-no='$loop' class='form-control select' required>
                                                    <option value=''>-Pilih-</option>";					
                                                    //foreach($komponen as $produk){
                                                    echo"<option value='3' selected>Operational Cost</option>";
                                                    //}
                                        echo	"</select>
                                            </td>";          
                                
                                        echo	"<td id='persentase_oc_$loop'><input type='text' align='right' class='form-control input-sm ' id='used_persentase_oc_$loop' required name='dt[$loop][persentase_oc]' value='$oc->persentase' ></td>
                                                 <td id='nilai_oc_$loop' hidden><input type='text' align='right' class='form-control input-sm ' id='used_nilai_oc_$loop' required name='dt[$loop][nilai_oc]' readonly value='$oc->nilai_costing'></td>
                                                 <td id='keterangan_oc_$loop'><input type='text' align='right' class='form-control input-sm' id='used_keterangan_oc_$loop' required name='dt[$loop][keterangan_oc]' value='$oc->keterangan'></td>
                                                <td align='center'>
                                                <button type='button' class='btn btn-sm btn-danger' title='Hapus Data' data-role='qtip' onClick='return HapusItem($loop);'><i class='fa fa-close'></i></button>
                                                </td>
                                            
                                        </tr>
                                        <tr id='tr_$loop'>
                                            <td>4</td>
                                            <td>
                                                <select id='used_komponen_margin_$loop' name='dt[$loop][komponen_margin]' data-no='$loop' class='form-control select' required>
                                                    <option value=''>-Pilih-</option>";					
                                                    //foreach($komponen as $produk){
                                                    echo"<option value='4' selected>Margin</option>";
                                                    //}
                                        echo	"</select>
                                            </td>";          
                                
                                        echo	"<td id='persentase_margin_$loop'><input type='text' align='right' class='form-control input-sm ' id='used_persentase_margin_$loop' required name='dt[$loop][persentase_margin]' value='$margin->persentase' ></td>
                                                 <td id='nilai_margin_$loop' hidden><input type='text' align='right' class='form-control input-sm ' id='used_nilai_margin_$loop' required name='dt[$loop][nilai_margin]' readonly value='$margin->nilai_costing'></td>
                                                 <td id='keterangan_margin_$loop'><input type='text' align='right' class='form-control input-sm' id='used_keterangan_margin_$loop' required name='dt[$loop][keterangan_margin]' value='$margin->keterangan'></td>
                                                <td align='center'>
                                                <button type='button' class='btn btn-sm btn-danger' title='Hapus Data' data-role='qtip' onClick='return HapusItem($loop);'><i class='fa fa-close'></i></button>
                                                </td>
                                            
                                        </tr>
                                        <tr id='tr_$loop'>
                                            <td>5</td>
                                            <td>
                                                <select id='used_komponen_dd_$loop' name='dt[$loop][komponen_dd]' data-no='$loop' class='form-control select' required>
                                                    <option value=''>-Pilih-</option>";					
                                                    //foreach($komponen as $produk){
                                                    echo"<option value='5' selected>Discount Distributor</option>";
                                                    //}
                                        echo	"</select>
                                            </td>";          
                                
                                        echo	"<td id='persentase_dd_$loop'><input type='text' align='right' class='form-control input-sm ' id='used_persentase_dd_$loop' required name='dt[$loop][persentase_dd]' value='$dd->persentase' ></td>
                                                 <td id='nilai_dd_$loop' hidden><input type='text' align='right' class='form-control input-sm ' id='used_nilai_dd_$loop' required name='dt[$loop][nilai_dd]' readonly value='$dd->nilai_costing'></td>
                                                 <td id='keterangan_dd_$loop'><input type='text' align='right' class='form-control input-sm' id='used_keterangan_dd_$loop' required name='dt[$loop][keterangan_dd]' value='$dd->keterangan'></td>
                                                <td align='center'>
                                                <button type='button' class='btn btn-sm btn-danger' title='Hapus Data' data-role='qtip' onClick='return HapusItem($loop);'><i class='fa fa-close'></i></button>
                                                </td>
                                            
                                        </tr>
                                        <tr id='tr_$loop'>
                                            <td>6</td>
                                            <td>
                                                <select id='used_komponen_da_$loop' name='dt[$loop][komponen_da]' data-no='$loop' class='form-control select' required>
                                                    <option value=''>-Pilih-</option>";					
                                                    //foreach($komponen as $produk){
                                                    echo"<option value='6' selected>Discount Agent</option>";
                                                    //}
                                        echo	"</select>
                                            </td>";          
                                
                                        echo	"<td id='persentase_da_$loop'><input type='text' align='right' class='form-control input-sm ' id='used_persentase_da_$loop' required name='dt[$loop][persentase_da]' value='$da->persentase' ></td>
                                                 <td id='nilai_da_$loop' hidden><input type='text' align='right' class='form-control input-sm ' id='used_nilai_da_$loop' required name='dt[$loop][nilai_da]' readonly value='$da->nilai_costing'></td>
                                                 <td id='keterangan_da_$loop'><input type='text' align='right' class='form-control input-sm' id='used_keterangan_da_$loop' required name='dt[$loop][keterangan_da]' value='$da->keterangan'></td>
                                                <td align='center'>
                                                <button type='button' class='btn btn-sm btn-danger' title='Hapus Data' data-role='qtip' onClick='return HapusItem($loop);'><i class='fa fa-close'></i></button>
                                                </td>
                                            
                                        </tr>
                                        <tr id='tr_$loop'>
                                            <td>7</td>
                                            <td>
                                                <select id='used_komponen_de_$loop' name='dt[$loop][komponen_de]' data-no='$loop' class='form-control select' required>
                                                    <option value=''>-Pilih-</option>";					
                                                    //foreach($komponen as $produk){
                                                    echo"<option value='7' selected>Discount End User</option>";
                                                    //}
                                        echo	"</select>
                                            </td>";          
                                
                                        echo	"<td id='persentase_de_$loop'><input type='text' align='right' class='form-control input-sm ' id='used_persentase_de_$loop' required name='dt[$loop][persentase_de]' value='$de->persentase' ></td>
                                                 <td id='nilai_de_$loop' hidden><input type='text' align='right' class='form-control input-sm ' id='used_nilai_de_$loop' required name='dt[$loop][nilai_de]' readonly value='$de->nilai_costing'></td>
                                                 <td id='keterangan_de_$loop'><input type='text' align='right' class='form-control input-sm' id='used_keterangan_de_$loop' required name='dt[$loop][keterangan_de]' value='$de->keterangan'></td>
                                                <td align='center'>
                                                <button type='button' class='btn btn-sm btn-danger' title='Hapus Data' data-role='qtip' onClick='return HapusItem($loop);'><i class='fa fa-close'></i></button>
                                                </td>
                                            
                                        </tr>
                                        <tr id='tr_$loop'>
                                        <td>8</td>
                                        <td>
                                            <select id='used_komponen_aj_$loop' name='dt[$loop][komponen_aj]' data-no='$loop' class='form-control select' required>
                                                <option value=''>-Pilih-</option>";					
                                                //foreach($komponen as $produk){
                                                echo"<option value='8' selected>Adjustable</option>";
                                                //}
                                    echo	"</select>
                                        </td>";          
                                
                                    echo	"<td id='persentase_aj_$loop'><input type='text' align='right' class='form-control input-sm' id='used_persentase_aj_$loop' required name='dt[$loop][persentase_aj]' value='$aj->persentase' ></td>
                                             <td id='nilai_aj_$loop' hidden><input type='text' align='right' class='form-control input-sm ' id='used_nilai_aj_$loop' required name='dt[$loop][nilai_aj]' readonly value='$aj->nilai_costing'></td>
                                             <td id='keterangan_aj_$loop'><input type='text' align='right' class='form-control input-sm' id='used_keterangan_aj_$loop' required name='dt[$loop][keterangan_aj]' value='$aj->keterangan'></td>
                                            <td align='center'>
                                            <button type='button' class='btn btn-sm btn-danger' title='Hapus Data' data-role='qtip' onClick='return HapusItem($loop);'><i class='fa fa-close'></i></button>
                                            </td>
                                        
                                    </tr>
                                        ";

                                    ?>

														
									</tbody>
									<tfoot>
									<tfoot>
									    <tr hidden>
											<th width='3%'></th>
											<th width='5%' >Harga Akhir</th>
											<th width='5%'></th>	
											<th width='5%'><input type='text' class='form-control total_price' id='total_price' value="<?=$hd->total_pricelist?>" name='total_price' readonly ></th>
											<th width='5%'></th>																					
											<th width='3%'></th>
											
										</tr>    									   										
									</tfoot>
								</table>
						    </div>
					    </div>
				    </div>
					
                    <center>
                    <button type="submit" class="btn btn-success btn-sm" name="save" id="simpan-com"><i class="fa fa-save"></i>Simpan</button>
                    <a class="btn btn-danger btn-sm" href="<?= base_url('/ms_product_costing/formula') ?>"  title="Edit">Kembali</a>
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
			var id_material	= $('#id_material').val();
			
			var data, xhr;

			if (id_material == '') {
				swal({
					title: "Warning!",
					text: "Usage masih kosong!",
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
								var baseurl=siteurl+'ms_product_costing/SaveRevisiFormula';
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
											window.location.href = base_url + active_controller+'/formula';
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
		$("#used_persentase_bm_1").val(number_format(beli,4));
	});

	$(document).on('blur','#used_persentase_lc_1', function(){
		var beli		= $(this).val();
		$("#used_persentase_lc_1").val(number_format(beli,4));
		cariRumusA();
	});

	$(document).on('blur','#used_persentase_oc_1', function(){
		var beli		= $(this).val();
		$("#used_persentase_oc_1").val(number_format(beli,4));
		cariRumusB();
	});

	$(document).on('blur','#used_persentase_margin_1', function(){
		var beli		= $(this).val();
		$("#used_persentase_margin_1").val(number_format(beli,4));
		cariRumusC();
	});

	$(document).on('blur','#used_persentase_dd_1', function(){
		var beli		= $(this).val();
		$("#used_persentase_dd_1").val(number_format(beli,4));
		cariRumusD();
	});

	$(document).on('blur','#used_persentase_da_1', function(){
		var beli		= $(this).val();
		$("#used_persentase_da_1").val(number_format(beli,4));
		cariRumusE();
	});

	$(document).on('blur','#used_persentase_de_1', function(){
		var beli		= $(this).val();
		$("#used_persentase_de_1").val(number_format(beli,4));
		cariRumusF();
	});

	$(document).on('blur','#used_persentase_aj_1', function(){
		var beli		= $(this).val();
		$("#used_persentase_aj_1").val(number_format(beli,4));
		cariRumusG();
	});



	function cariRumusA()
	{
		
		var bm	= Number($('#used_persentase_bm_1').val().split(",").join("")); 
		var lc  = Number($('#used_persentase_lc_1').val().split(",").join(""));  		
		var harga	= Number( $('#harga_beli').val().split(",").join(""));
		
		
		var A = (getNum(bm)/getNum(100))+(getNum(lc)/getNum(100));
		var B = (getNum(A)*getNum(harga));
		var C =  getNum(B)+getNum(harga);		
		
		$('#used_nilai_lc_1').val(number_format(C,2));	
	}

	function cariRumusB()
	{
		
		var nilailc  = Number($('#used_nilai_lc_1').val().split(",").join(""));  		
		var op 		 = Number($('#used_persentase_oc_1').val().split(",").join(""));  
		
		
		var A = getNum(1) - getNum(op/100);
		var B = getNum(nilailc) / getNum(A);
		$('#used_nilai_oc_1').val(number_format(B,2));	
	}

	function cariRumusC()
	{
		
		var nilai  		 = Number($('#used_nilai_oc_1').val().split(",").join(""));  		
		var persen		 = Number($('#used_persentase_margin_1').val().split(",").join(""));  
		
		
		var A = getNum(1) - getNum(persen/100);
		var B = getNum(nilai) / getNum(A);
		$('#used_nilai_margin_1').val(number_format(B,2));	
	}


	function cariRumusD()
	{
		
		var nilai  		 = Number($('#used_nilai_margin_1').val().split(",").join(""));  		
		var persen		 = Number($('#used_persentase_dd_1').val().split(",").join(""));  
		
		
		var A = getNum(1) - getNum(persen/100);
		var B = getNum(nilai) / getNum(A);
		$('#used_nilai_dd_1').val(number_format(B,2));	
	}
	function cariRumusE()
	{
		
		var nilai  		 = Number($('#used_nilai_dd_1').val().split(",").join(""));  		
		var persen		 = Number($('#used_persentase_da_1').val().split(",").join(""));  
		
		
		var A = getNum(1) - getNum(persen/100);
		var B = getNum(nilai) / getNum(A);
		$('#used_nilai_da_1').val(number_format(B,2));	
	}
	function cariRumusF()
	{
		
		var nilai  		 = Number($('#used_nilai_da_1').val().split(",").join(""));  		
		var persen		 = Number($('#used_persentase_de_1').val().split(",").join(""));  
		
		
		var A = getNum(1) - getNum(persen/100);
		var B = getNum(nilai) / getNum(A);
		$('#used_nilai_de_1').val(number_format(B,2));	
	}
	function cariRumusG()
	{
		
		var nilai  		 = Number($('#used_nilai_de_1').val().split(",").join(""));  		
		var persen		 = Number($('#used_persentase_aj_1').val().split(",").join(""));  
		
		
		var A = getNum(1) + getNum(persen/100);
		var B = getNum(nilai) * getNum(A);
		var C = Math.round(B);
		$('#used_nilai_aj_1').val(number_format(B,2));	
		$('#total_price').val(number_format(C,2));	
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
    function get_inv3(){
        var inventory_2=$("#inventory_2").val();
		 $.ajax({
            type:"GET",
            url:siteurl+'inventory_4/get_inven3',
            data:"inventory_2="+inventory_2,
            success:function(html){
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