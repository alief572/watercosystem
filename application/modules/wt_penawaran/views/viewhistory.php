<?php
    $ENABLE_ADD     = has_permission('Penawaran.Add');
    $ENABLE_MANAGE  = has_permission('Penawaran.Manage');
    $ENABLE_VIEW    = has_permission('Penawaran.View');
    $ENABLE_DELETE  = has_permission('Penawaran.Delete');
	$tanggal = date('Y-m-d');
    foreach ($results['header'] as $hd){
?>

<div class="box box-primary">
    <div class="box-body">
		<form id="data-form" method="post">
			<div class="col-sm-12">
				<div class="input_fields_wrap2">
			<div class="row">
		<center><label for="customer" ><h3>Penawaran</h3></label></center>
        <center><label for="customer" ><h3>Revisi <?= $hd->revisi?></h3></label></center>
        <br>
		<div class="col-sm-12">
		    <div class="col-sm-6">
		        <div class="form-group row">
			        <div class="col-md-4">
				        <label for="customer">NO.Penawaran</label>
			        </div>
			        <div class="col-md-8" hidden>
				        <input type="text" class="form-control" id="no_penawaran" value="<?= $hd->no_penawaran?>" required name="no_penawaran" readonly placeholder="No.CRCL">
			        </div>
			        <div class="col-md-8">
				        <input type="text" class="form-control" id="no_surat"  value="<?= $hd->no_surat?>" required name="no_surat" readonly placeholder="No.Penawaran">
			        </div>
		        </div>
		    </div>
		    <div class="col-sm-6">
		        <div class="form-group row">
			        <div class="col-md-4">
				        <label for="customer">Tanggal</label>
			        </div>
			        <div class="col-md-8">
				        <input type="date" class="form-control" id="tanggal" value="<?= $hd->tgl_penawaran?>"  onkeyup required name="tanggal" readonly >
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
                        <select id="id_customer" name="id_customer" class="form-control select" onchange="get_customer()" required>
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
				        <input type='email' class='form-control'  value="<?= $hd->email_customer?>" id='email_customer' required name='email_customer' >
			        </div>
		        </div>
		    </div>
		    <div class='col-sm-6'>
			    <div class='form-group row'>
				    <div class='col-md-4'>
					    <label for='id_category_supplier'>PIC Customer</label>
				    </div>
				    <div class='col-md-8' id="pic_slot" >
					    <select id='pic_customer' name='pic_customer' class='form-control select' required>
						    <option value="<?= $hd->pic_customer?>" selected><?= strtoupper(strtolower($hd->pic_customer))?></option>
					    </select>
				    </div>
			    </div>
		    </div>
		</div>		
       
		<div class="col-md-12">
		    <div class='col-sm-6'>
		        <div class='form-group row'>
			        <div class='col-md-4'>
				        <label for='email_customer'>Term Of Payment</label>
			        </div>
                    <div class='col-md-8'>
                        <select id="top" name="top" class="form-control select" required>
                            <option value="">--Pilih--</option>
                                <?php foreach ($results['top'] as $top){
                                $select2 = $top->id_top == $hd->top ? 'selected' : '';	?>
                            <option value="<?= $top->id_top?>" <?= $select2 ?>><?= strtoupper(strtolower($top->nama_top))?></option>
                                <?php } ?>
                        </select>
                    </div>
			    </div>
		    </div>
		    <div class='col-sm-6'>
		        <div class='form-group row'>
			        <div class='col-md-4'>
				        <label for='email_customer'>Order Status</label>
			        </div>
			        <div class='col-md-8' id="">
					    <select id="order_sts" name="order_sts" class="form-control select" required>
							<option value="">--Pilih--</option>
                           <?php if($hd->order_status==stk){ ?>
						    <option value="stk" selected>Stock</option>
                            <option value="ind" >Indent</option>
                            <?php } else if($hd->order_status==ind){?>
                            <option value="stk" >Stock</option>
                            <option value="ind" selected>Indent</option>
                            <?php } ?>
					    </select>
			        </div>
		        </div>
            </div>
		</div>

        <?php } ?>
		                
		<div class="col-sm-12">
					    <div class="col-sm-12">
						    <?php if(empty($results['view'])){ ?>
						    <div class="form-group row">
								
							</div>
						    <?php } ?>
							<div class="form-group row" >
								<table class='table table-bordered table-striped'>
									<thead>
										<tr class='bg-blue'>
											<th width='3%'>No</th>
											<th width='30%'>Produk</th>
											<th width='7%'>Qty <br> Penawaran</th>
											<th width='7%'>Harga <br> Produk</th>
											<th width='7%'>Stok <br> Tersedia</th>
											<th width='7%'>Potensial <br> Loss</th>											
											<th width='7%'>Diskon %</th>
											<th width='7%'>Freight Cost</th>											
											<th width='7%'>Total Harga</th>																						
											<th width='5%'>Aksi</th>
										</tr>
									</thead>
									<tbody id="list_spk">
                                    <?php $loop=0;
									foreach ($results['detail'] as $dt_spk){$loop++; 

                                        $customers = $this->Wt_penawaran_model->get_data('master_customers','deleted',$deleted);
		                                $material = $this->db->query("SELECT a.* FROM ms_inventory_category3 as a ")->result();
                                        echo "
                                        <tr id='tr_$loop'>
                                            <td>$loop</td>
                                            <td>
                                                <select id='used_no_surat_$loop' name='dt[$loop][no_surat]' data-no='$loop' onchange='CariDetail($loop)' class='form-control select' required>
                                                    <option value=''>-Pilih-</option>";	
                                                    foreach($material as $produk){
                                                        $select = $dt_spk->id_category3 == $produk->id_category3 ? 'selected' : '';				
                                                        echo"<option value='$produk->id_category3' $select>$produk->nama|$produk->kode_barang</option>";
                                                    }
                                        echo	"</select>
                                            </td>
                                            <td id='nama_produk_$loop' hidden><input type='text' value='$dt_spk->nama_produk' class='form-control input-sm' readonly id='used_nama_produk_$loop' required name='dt[$loop][nama_produk]'></td>
                                            <td id='qty_$loop'><input type='text' value='$dt_spk->qty' class='form-control input-sm' id='used_qty_$loop' required name='dt[$loop][qty]' onblur='HitungTotal($loop)'></td>
                                            <td id='harga_satuan_$loop'><input type='text' value='".number_format($dt_spk->harga_satuan, 2)."' class='form-control input-sm' id='used_harga_satuan_$loop' required name='dt[$loop][harga_satuan]' readonly></td>
                                            <td id='stok_tersedia_$loop'><input type='text' value='$dt_spk->stok_tersedia' class='form-control input-sm' id='used_stok_tersedia_$loop' required name='dt[$loop][stok_tersedia]' onblur='HitungLoss($loop)'></td>
                                            <td id='potensial_loss_$loop'><input type='text' value='$dt_spk->potensial_loss' class='form-control input-sm' id='used_potensial_loss_$loop' required name='dt[$loop][potensial_loss]' readonly></td>
											<td id='compare_diskon_$loop' hidden><input type='text' value='$dt_spk->diskon_compare' class='form-control'  id='used_compare_diskon_$loop' required name='dt[$loop][compare_diskon_]'></td>
                                            <td id='diskon_$loop'><input type='text' value='$dt_spk->diskon' class='form-control'  id='used_diskon_$loop' required name='dt[$loop][diskon]' onblur='HitungTotal($loop)'></td>
                                            <td id='nilai_diskon_$loop' hidden><input type='text' value='$dt_spk->nilai_diskon' class='form-control'  id='used_nilai_diskon_$loop' required name='dt[$loop][nilai_diskon]'></td>
                                            <td id='freight_cost_$loop'><input type='text' value='".number_format($dt_spk->freight_cost, 2)."' class='form-control input-sm' id='used_freight_cost_$loop' required name='dt[$loop][freight_cost]' onblur='Freight($loop)'></td>
                                            <td id='total_harga_$loop'><input type='text' value='".number_format($dt_spk->total_harga, 2)."' class='form-control input-sm total' id='used_total_harga_$loop' required name='dt[$loop][total_harga]' readonly></td>
                                            <td align='center'>
                                                
                                            </td>
                                            
                                        </tr>";
                                     }
                                    ?>

									</tbody>
									<tfoot>
									    <tr>
											<th width='3%'></th>
											<th width='10%'></th>
											<th width='7%'></th>
											<th width='7%'></th>
											<th width='7%'></th>
											<th width='7%'></th>
											<th width='7%'><b>Total</b></th>											
											<th width='7%'></th>                                            
                                            <th width='9%'><input type='text' class='form-control totalproduk' id='totalproduk'  name='totalproduk' readonly value="<?= number_format($hd->nilai_penawaran, 2)?>" ></th>										
                                            	
										</tr>
										<tr>
											<th width='3%'></th>
											<th width='10%'></th>
											<th width='7%'></th>
											<th width='7%'></th>
											<th width='7%'></th>
											<th width='7%'></th>
											<th width='7%'><b>PPN</b></th>											
											<th width='7%'><input type='text' class='form-control ppn' id='ppn'  name='ppn' onblur='hitungPpn()' value="<?= $hd->ppn?>" ></th>                                            
                                            <th width='9%'><input type='text' class='form-control totalppn' id='totalppn'  name='totalppn' value="<?= number_format($hd->nilai_ppn, 2)?>" readonly ></th>										
                                            	
										</tr>
										<tr>
											<th width='3%'></th>
											<th width='10%'></th>
											<th width='7%'></th>
											<th width='7%'></th>
											<th width='7%'></th>
											<th width='7%'></th>
											<th width='7%'><b>Grand Total</b></th>											
											<th width='7%'></th>                                            
                                            <th width='9%'><input type='text' class='form-control grandtotal' id='grandtotal'  name='grandtotal' value="<?= number_format($hd->grand_total, 2)?>" readonly ></th>										
                                            	
										</tr>
									   										
									</tfoot>
									
								</table>
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

			$('.select').select2({
				width: '100%'
			});
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
						var baseurl=siteurl+'wt_penawaran/SaveEditPenawaran';
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

</script>