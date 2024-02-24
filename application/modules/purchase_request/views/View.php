<?php
	$tanggal = date('Y-m-d');
		foreach ($results['header'] as $header){
	}	
?>

 <div class="box box-primary">
    <div class="box-body">
		<form id="data-form" method="post">
			<div class="col-sm-12">
				<div class="input_fields_wrap2">
			<div class="row">
		<center><label for="customer" ><h3>Purchase Request</h3></label></center>
		<div class="col-sm-12">
		<div class="col-sm-6">
		<div class="form-group row">
			<div class="col-md-4">
				<label for="customer">NO.PR</label>
			</div>
			<div class="col-md-8">
				<?= $header->no_surat ?>
			</div>
		</div>
		</div>
		</div>
		<div class="col-sm-12">
		<div class="col-sm-6">
		<div class="form-group row">
			<div class="col-md-4">
				<label for="customer">Tanggal PR</label>
			</div>
			<div class="col-md-8">
				<?= $header->tanggal ?>
			</div>
		</div>
		</div>
		</div>
		<div class="col-sm-12">
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="id_customer">Requestor</label>
				</div>
				<div class="col-md-8">
					<?= $header->requestor ?>
				</div>
			</div>
		</div>
		</div>
		<div class="col-sm-12">
				<div class="form-group row">
		
		</div>
		<div class="form-group row" >
			<table class='table table-bordered table-striped'>
			<thead>
			<tr class='bg-blue'>
			<th width='30%' >Produk</th>
				<th width='8%'>Qty (Unit)</th>
				<th width='20%'>Supplier</th>
				<th width='10%'>Tanggal Dibutuhkan</th>
				<th width='30%'>Keterangan</th>
			</tr>
			</thead>
			<tbody id="data_request">
				<?php foreach ($results['detail'] as $detail){ 
			$suplier = $this->db->query("SELECT * FROM master_supplier WHERE id_suplier = '".$detail->suplier ."' ")->result();
			echo"
			<tr>
			<td>".$detail->nama ."</td>
			<td>".$detail->qty ."</td>
			<td>".$suplier[0]->name_suplier ."</td>
			<td>".$detail->tanggal ."</td>
			<td>".$detail->keterangan ."</td>
			</tr>
			";
			}?>
			</tbody>
			</table>
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
						var baseurl=siteurl+'purchase_request/SaveNew';
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
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_request/AddMaterial',
            data:"jumlah="+jumlah,
            success:function(html){
               $("#data_request").append(html);
            }
        });
    }
	function CariProperties(id){
        var idmaterial=$("#dt_idmaterial_"+id).val();
		 $.ajax({
            type:"GET",
            url:siteurl+'purchase_request/CariBentuk',
            data:"idmaterial="+idmaterial+"&id="+id,
            success:function(html){
               $("#bentuk_"+id).html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_request/CariIdBentuk',
            data:"idmaterial="+idmaterial+"&id="+id,
            success:function(html){
               $("#idbentuk_"+id).html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_request/CariSupplier',
            data:"idmaterial="+idmaterial+"&id="+id,
            success:function(html){
               $("#supplier_"+id).html(html);
            }
        });
    }
function HapusItem(id){
		$('#data_request #tr_'+id).remove();
		
	}
	
	
	
</script>