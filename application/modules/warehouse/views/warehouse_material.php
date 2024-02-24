<?php
    $ENABLE_ADD     = has_permission('Warehouse.Add');
    $ENABLE_MANAGE  = has_permission('Warehouse.Manage');
    $ENABLE_VIEW    = has_permission('Warehouse.View');
    $ENABLE_DELETE  = has_permission('Warehouse.Delete');

?>
<style type="text/css">
thead input {
	width: 100%;
}
</style>
<div id='alert_edit' class="alert alert-success alert-dismissable" style="padding: 15px; display: none;"></div>
<link rel="stylesheet" href="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.css')?>">
<div class="box box-primary">
            <div class="box-body">
			
			<form id="data_form">
				<div class="row">
					<div class="col-md-12">
					    <div class="form-group row">
							<div class="col-md-2">
							  <label for="">Gudang</label>
							</div>
							 <div class="col-md-6">
							 <input type="text" class="form-control" id="nama_gudang" required name="nama_gudang" placeholder="nama_gudang" value="<?=$results['nama_gudang']?>">
							</div>							
						</div>
						<div class="form-group row">
							<div class="col-md-2">
							  <label for="">Material</label>
							</div>
							 <div class="col-md-6">
							 <input type="hidden" class="form-control" id="id_gudang" required name="id_gudang" placeholder="id_gudang" value="<?=$results['id_gudang']?>">
							  <select id="inventory_3" name="inventory_3" class="form-control" >
								<?php foreach ($results['inventory_3'] as $inventory_3){ 
								?>
								<option value="<?= $inventory_3->id_category3?>"><?= ucfirst(strtolower($inventory_3->nama))?></option>
								<?php } ?>
							  </select>
							</div>							
						</div>
						<div class="form-group row">
							<div class="col-md-2">
							  <label for="">Qty</label>
							</div>
							 <div class="col-md-6">
							  <input type="number" class="form-control" id="qty" required name="qty" placeholder="Qty">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-2">
							  <label for="">Qty Booking</label>
							</div>
							 <div class="col-md-6">
							  <input type="number" class="form-control" id="qty_booking" required name="qty_booking" placeholder="Qty Booking">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-2">
							  <label for="">Qty Available</label>
							</div>
							 <div class="col-md-6">
							  <input type="number" class="form-control" id="qty_available" required name="qty_available" placeholder="Qty Available">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-3">
							<button type="submit" class="btn btn-primary" name="save" id="save"><i class="fa fa-save"></i> Save</button>
							</div>
						</div>
					</div>
				</div>
				
			</form>
        </div>

	<!-- /.box-body -->
</div>

<!-- DataTables -->
<script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.min.js')?>"></script>
<script src="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.min.js')?>"></script>

<!-- page script -->
<script type="text/javascript">
		$(document).ready(function(){
			$('#inventory_3').select2({
			dropdownParent:$('#data_form'),
			width : '100%'
			});
		})
   
	
	// ADD CUSTOMER 
	
	$(document).on('submit', '#data_form', function(e){
		e.preventDefault()
		var data = $('#data_form').serialize();
		var id = $('#inventory_3').val();
		//alert(id);
		swal({
		  title: "Anda Yakin?",
		  text: "Data akan Material Gudang di simpan.",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonClass: "btn-info",
		  confirmButtonText: "Ya, Simpan!",
		  cancelButtonText: "Batal",
		  closeOnConfirm: false
		},
		function(){
		  $.ajax({
			  type:'POST',
			  url:siteurl+'warehouse/saveAddMaterial',
			  dataType : "json",
			  data:data,
			  success:function(result){
				  if(result.status == '1'){
					 swal({
						  title: "Sukses",
						  text : "Data Material Gudang berhasil disimpan.",
						  type : "success"
						},
						function (){
							window.location.reload(true);
						})
				  } else {
					swal({
					  title : "Error",
					  text  :  result.pesan,
					  type  : "error"
					})
					
				  }
			  },
			  error : function(){
				swal({
					  title : "Error",
					  text  : "Data error. Gagal request Ajax",
					  type  : "error"
					})
			  }
		  })
		});
		
	})
	
	
	

	function PreviewPdf(id)
	{
		param=id;
		tujuan = 'customer/print_request/'+param;

	   	$(".modal-body").html('<iframe src="'+tujuan+'" frameborder="no" width="570" height="400"></iframe>');
	}

	function PreviewRekap()
	{
		tujuan = 'customer/rekap_pdf';
	   	$(".modal-body").html('<iframe src="'+tujuan+'" frameborder="no" width="100%" height="400"></iframe>');
	}
</script>
