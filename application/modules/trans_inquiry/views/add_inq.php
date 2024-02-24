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
		<div class="col-sm-12">
		<div class="col-sm-6">
		<div class="form-group row">
			<div class="col-md-4">
				<label for="customer">NO.CRCL</label>
			</div>
			<div class="col-md-8">
				<input type="text" class="form-control" id="no_inquiry" required name="no_inquiry" readonly placeholder="No.CRCL">
			</div>
		</div>
		</div>
		<div class="col-sm-6">
		<div class="form-group row">
			<div class="col-md-4">
				<label for="customer">Tanggal</label>
			</div>
			<div class="col-md-8">
				<input type="date" class="form-control" id="tanggal" value="<?= $tanggal ?>" onkeyup required name="tanggal" readonly >
			</div>
		</div>
		</div>
		</div>
		<div class="col-sm-12">
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="id_category_supplier">SALES/MARKETING</label>
				</div>
				<div class="col-md-8">
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
				<div class="col-md-4">
					<label for="id_customer">CUSTOMER</label>
				</div>
				<div class="col-md-8">
					<select id="id_customer" name="id_customer" class="form-control select" onchange="get_customer()" required>
						<option value="">--Pilih--</option>
							<?php foreach ($results['customers'] as $customers){?>
						<option value="<?= $customers->id_customer?>"><?= ucfirst(strtolower($customers->name_customer))?></option>
							<?php } ?>
					</select>
				</div>
			</div>
		</div>
		</div>
		</br>
		<div class="col-sm-12">
		<div class="form-group row">
		<div class="col-md-12">
			<table class="col-sm-12">
				<tbody id='data_customer'>
											
				</tbody>
			</table>
		</div>
		</div>
		</div>
		<div class="col-sm-12">
		<div class="form-group row">
		<div class="col-md-12">
			<?php
				echo form_button(array('type'=>'button','class'=>'btn btn-md btn-success','value'=>'back','content'=>'Tambah','id'=>'add-payment'));
			?>
		</div>
		</div>
		</div>
		<div class="col-sm-12">
		<table class='table table-bordered table-striped'>
		<thead>
		<tr><th>#</th>
		<th>Bentuk</th>
		<th>Produk</th>
		<th>Dimensi</th>
		<th>Action</th></tr>
		</thead>
		<tbody id="data_barang">
		</tbody>
		</table>
		</div>


		</br>

		</br>
		</br>
		<div class="col-sm-12">
			<div class="col-sm-6">
				<div class="form-group row">
					<div class="col-md-4">
						<label for="label">LABEL</label>
					</div>
					<div class="col-md-8">
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
					<div class="col-md-4">
						<label for="packaging">PACKAGING</label>
					</div>
					<div class="col-md-8">
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
		$('#add-payment').click(function(){
			var jumlah	=$('#data_barang').find('tr').length;
			if(jumlah==0 || jumlah==null){
				var ada		= 0;
				var loop	= 1;
			}
			else{
				var nilai		= $('#data_barang tr:last').attr('id');
				var jum1		= nilai.split('_');
				var loop		= parseInt(jum1[1])+1; 
			}
			Template	='<tr id="tr_'+loop+'">';
			Template	+='<td align="center">'+loop+'</td>';
			Template	+='<td align="left">';
					Template	+='<select id="bentuk_'+loop+'" name="data1['+loop+']bentuk" data-no='+loop+' class="form-control select get_product"  required>';
						Template	+='<option value="">--Pilih--</option>';
							Template	+='<?php foreach ($results["bentuk"] as $bentuk){?>';
						Template	+='<option value="<?= $bentuk->id_bentuk?>"><?= ucfirst(strtolower($bentuk->nm_bentuk))?></option>';
							Template	+='<?php } ?>';
					Template	+='</select>';
			Template	+='</td>';
			Template	+='<td align="left">';
					Template	+='<select id="produk_'+loop+'" name="data1['+loop+']produk" data-no='+loop+' class="form-control select get_dimensi" " required>';
					Template	+='<option>--Pilih--</option>';
					Template	+='</select>';
			Template	+='</td>';
			Template	+='<td align="left" id="dimensi_'+loop+'">';
			Template	+='</td>';
			Template	+='<td align="center"><button type="button" class="btn btn-sm btn-danger" title="Hapus Data" data-role="qtip" onClick="return DelItem('+loop+');"><i class="fa fa-trash-o"></i></button></td>';
			Template	+='</tr>';
			$('#data_barang').append(Template);
			$('input[data-role="tglbayar"]').datepicker({
				format: 'dd-mm-yyyy',
				autoclose: true			
			});
			loop++;
		});
			
	$(document).on('change','.get_dimensi',function(){
	    var produk = $(this).val();
		var nomor =  $(this).data('no');
	    $.ajax({
	      url: siteurl+'trans_inquiry/get_dimensi/',
	      data:"produk="+produk,
		  data:"nomor="+nomor,
            success:function(html){
               $("#dimensi_"+nomor).html(html);
            },
	      error: function() {
	        swal({
	          title				: "Error Message !",
	          text				: 'Connection Time Out. Please try again..',
	          type				: "warning",
	          timer				: 3000,
	          showCancelButton	: false,
	          showConfirmButton	: false,
	          allowOutsideClick	: false
	        });
	      }
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
						var baseurl=siteurl+'master_customers/saveNewCategory';
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
            url:siteurl+'trans_inquiry/getcustomer',
            data:"id_customer="+id_customer,
            success:function(html){
               $("#data_customer").html(html);
            }
        });
    }
function DelItem(id){
		$('#data_barang #tr_'+id).remove();
		
	}
	
	
	
</script>