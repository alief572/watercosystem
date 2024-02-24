<?php
    $ENABLE_ADD     = has_permission('Trans_inquiry.Add');
    $ENABLE_MANAGE  = has_permission('Trans_inquiry.Manage');
    $ENABLE_VIEW    = has_permission('Trans_inquiry.View');
    $ENABLE_DELETE  = has_permission('Trans_inquiry.Delete');
	$tanggal = date('Y-m-d');
?>
 <div class="box box-primary">
    <div class="box-body">
		<form id="data-form" method="post">
			<div class="col-sm-12">
				<div class="input_fields_wrap2">
					<div class="row">
						
										<center><label for="customer" ><h3>INQUIRY (CUSTOMER REQUIREMENTS CHECK LIST)</h3></label></center>
							<div class="col-sm-6">
							<div class="form-group row">
										<div class="col-md-6">
									    <label for="customer">NO. CRCL</label>
									    </div>
									    <div class="col-md-6">
											<input type="text" class="form-control" id="no_inquiry" required name="no_inquiry" readonly placeholder="No.CRCL">
									    </div>
							</div>
								<div class="form-group row">
									<div class="col-md-6">
									    <label for="id_supplier">Tanggal</label>
									</div>
									<div class="col-md-6">
											<input type="date" value="<?= $tanggal ?>" class="form-control" id="tanggal" required name="tanggal" readonly placeholder="Id Suplier">
									</div>
								</div>
										<div class="form-group row">
											<div class="col-md-6">
											 <label for="id_category_supplier">SALES/MARKETING</label>
											</div>
											<div class="col-md-6">
											  <select id="id_sales" name="id_sales" class="form-control select" required>
												<option value="">--Pilih--</option>
												<?php foreach ($results['karyawan'] as $karyawan){?>
												<option value="<?= $karyawan->id_karyawan?>"><?= ucfirst(strtolower($karyawan->nama_karyawan))?></option>
												<?php } ?>
											  </select>
											</div>
										</div>
								
						</div>
						<div class="col-sm-6">
						<div class="form-group row">
									<div class="col-md-6">
										<label for="id_customer">Customer</label>
									</div>
									<div class="col-md-6">
											  <select id="id_customer" name="id_customer" class="form-control select" onchange="cek_database()" required>
												<option value="">--Pilih--</option>
												<?php foreach ($results['customers'] as $customers){?>
												<option value="<?= $customers->id_customer?>"><?= ucfirst(strtolower($customers->name_customer))?></option>
												<?php } ?>
											  </select>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-md-6">
									    <label for="customer">Email Customer</label>
									    </div>
									    <div class="col-md-6">
											<input type="email" class="form-control" id="email_customer" required name="email_customer" placeholder="Nama Customer">
									</div>
								</div>
										
										<div class="form-group row">
											<div class="col-md-6">
											 <label for="id_category_supplier">PIC CUSTOMER</label>
											</div>
											<div class="col-md-6">
											  <select id="pic_customer" name="pic_customer" class="form-control select" required>
												<option value="">--Pilih--</option>
											  </select>
											</div>
										</div>										
						</div>
						<br>
						<div class="col-sm-12">
								<div class="col-md-12">
						<center><label for="customer" ><h3>DETAIL PRODUCT</h3></label></center>
								</div>
						</div>
							<div class="col-sm-12">
							<?php
								echo form_button(array('type'=>'button','class'=>'btn btn-md btn-success','value'=>'back','content'=>'Add','id'=>'add-payment'));
							?>
							</div>
							<div class="form-group row">
							<div class="col-md-12">
							
								<table class='table table-bordered table-striped'>
										<tbody id='list_payment'>
											
										</tbody>
								</table>
							</div>
							</div>
						
						
						<center><label for="customer" ><h3>Pengiriman</h3></label></center>
						
						<div class="col-sm-6">
									<div class="form-group row">
									<div class="col-md-6">
										<label for="id_category_customer">LABEL</label>
									</div>
									<div class="col-md-6">
											  <select id="label" name="label" class="form-control select" required>
												<option value="">--Pilih--</option>
												<option value="Metalsindo Format">Metalsindo Format</option>
												<option value="Customer Format">Customer Format</option>
											  </select>
									</div>
									</div>
							</div>
							<div class="col-sm-6">
									<div class="form-group row">
									<div class="col-md-6">
										<label for="id_category_customer">PACKAGING</label>
									</div>
									<div class="col-md-6">
											  <select id="packaging" name="packaging" class="form-control select" required>
												<option value="">--Pilih--</option>
												<option value="Metalsindo Format">Metalsindo Format</option>
												<option value="Customer Format">Customer Format</option>
											  </select>
									</div>
									</div>
										
									</div>
								</div>
							</div>
						<div class="col-sm-12">
							<center>
								<button type="submit" class="btn btn-success btn-sm" name="save" id="simpan-com"><i class="fa fa-save"></i>Simpan</button>
								</center>
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
		 var data_pay	        = <?php echo json_encode($results['supplier']);?>;	
		 
				  ///INPUT PERKIRAAN KIRIM
			
			
			var max_fields2      = 10; //maximum input boxes allowed
			var wrapper2         = $(".input_fields_wrap2"); //Fields wrapper
			var add_button2      = $(".add_field_button2"); //Add button ID

			//console.log(persen);

			var x2 = 1; //initlal text box count
			$(add_button2).click(function(e){ //on add input button click
			  e.preventDefault();
			  if(x2 < max_fields2){ //max input box allowed
				x2++; //text box increment
				
				$(wrapper2).append('<div class="row">'+
				'<div class="col-xs-1">'+x2+'</div>'+
				'<div class="col-xs-3">'+
				'<div class="input-group">'+
				'<input type="text" name="hd'+x2+'[produk]"  class="form-control input-sm" value="">'+
				'</div>'+
				'<div class="input-group">'+
				'<input type="text" name="hd'+x2+'[costcenter]"  class="form-control input-sm" value="">'+
				'</div>'+
				'<div class="input-group">'+
				'<input type="text" name="hd'+x2+'[mesin]"  class="form-control input-sm" value="">'+
				'</div>'+
				'<div class="input-group">'+
				'<input type="text" name="hd'+x2+'[mold_tools]"  class="form-control input-sm" value="">'+
				'</div>'+
				'</div>'+
				'<a href="#" class="remove_field2">Remove</a>'+
				'</div>'); //add input box
				$('#datepickerxxr'+x2).datepicker({
				  format: 'dd-mm-yyyy',
				  autoclose: true
				});
			  }
			});

			$(wrapper2).on("click",".remove_field2", function(e){ //user click on remove text
			  e.preventDefault(); $(this).parent('div').remove(); x2--;
			})

		$('#add-payment').click(function(){
			var jumlah	=$('#list_payment').find('tr').length;
			if(jumlah==0 || jumlah==null){
				var ada		= 0;
				var loop	= 1;
			}else{
				var nilai		= $('#list_payment tr:last').attr('id');
				var jum1		= nilai.split('_');
				var loop		= parseInt(jum1[1])+1; 
			}
			Template	='<tr id="tr_'+loop+'">';
			Template	+='<td align="left">';
					Template	+='<input type="text" class="form-control input-sm" name="data1['+loop+'][email_pic]" id="data1_'+loop+'_email_pic" label="FALSE" div="FALSE">';
			Template	+='</td>';
			Template	+='<td align="left">';
					Template	+='<input type="text" class="form-control input-sm" name="data1['+loop+'][email_pic]" id="data1_'+loop+'_email_pic" label="FALSE" div="FALSE">';
			Template	+='</td>';
			Template	+='<td align="left">';
					Template	+='<input type="text" class="form-control input-sm" name="data1['+loop+'][email_pic]" id="data1_'+loop+'_email_pic" label="FALSE" div="FALSE">';
			Template	+='</td>';
			Template	+='<td align="left">';
					Template	+='<input type="text" class="form-control input-sm" name="data1['+loop+'][position_pic]" id="data1_'+loop+'_position_pic" label="FALSE" div="FALSE">';
			Template	+='</td>';
			Template	+='<td align="center"><button type="button" class="btn btn-sm btn-danger" title="Hapus Data" data-role="qtip" onClick="return DelItem('+loop+');"><i class="fa fa-trash-o"></i></button></td>';
			Template	+='</tr>';
			$('#list_payment').append(Template);
			});
			
			
	$('#id_customer').change(function(){
        var id_customer = $("#id_customer").val();
                $.ajax({
                    url:siteurl+'trans_inquiry/getemail',
                    data:"id_customer="+id_customer ,
                }).success(function (data) {
                    var json = data,
                    obj = JSON.parse(json);
                    $('#email_customer').val(obj.email);
                });
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
						var baseurl=siteurl+'master_customers/saveNewcustomer';
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

  function get_kota(){
        var id_prov=$("#id_prov").val();
		 $.ajax({
            type:"GET",
            url:siteurl+'master_customers/getkota',
            data:"id_prov="+id_prov,
            success:function(html){
               $("#id_kota").html(html);
            }
        });
    }
	function get_pic(){
        var id_customer=$("#id_customer").val();
		 $.ajax({
            type:"GET",
            url:siteurl+'trans_inquiry/getpic',
            data:"id_customer="+id_customer,
            success:function(html){
               $("#pic_customer").html(html);
            }
        });
    }
	function cek_database(){
        var id_customer = $("#id_customer").val();
        $.ajax({
            url:siteurl+'trans_inquiry/getemail',
            data:"id_customer="+id_customer ,
        }).success(function (data) {
            var json = data,
            obj = JSON.parse(json);
            $('#email_customer').val(obj.email_customer);
        });
    }
function DelItem(id){
		$('#list_payment #tr_'+id).remove();
		
	}
</script>