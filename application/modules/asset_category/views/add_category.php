<?php
    $ENABLE_ADD     = has_permission('Asset_category.Add');
    $ENABLE_MANAGE  = has_permission('Asset_category.Manage');
    $ENABLE_VIEW    = has_permission('Asset_category.View');
    $ENABLE_DELETE  = has_permission('Asset_category.Delete');
?>
<style type="text/css">
thead input {
	width: 100%;
}
</style>
<link rel="stylesheet" href="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.css')?>">
<link rel="stylesheet" href="<?= base_url('assets/plugins/sweetalert/dist/sweetalert.css')?>">

          <div class="box box-primary">
            <div class="box-body">
			
			<form id="data_form">
				<div class="row">
			<div class="col-md-12">
				<div class="form-group row">
							<div class="col-md-4">
							  <label for="">Nama Kategory Asset</label>
							</div>
							 <div class="col-md-8">
							  <input type="text" class="form-control" id="nm_category" required name="nm_category" placeholder="Nama Kategory Asset">
							</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group row">
							<div class="col-md-4">
							  <label for="">Type</label>
							</div>
							 <div class="col-md-8">
								<select type="text" class="form-control" id="tipe" name="tipe">
									<option value="">--PILIH--</option>
									<option value="BERGERAK">BERGERAK</option>
									<option value="TIDAK BERGERAK">TIDAK BERGERAK</option>
								</select>
							</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group row">
					<div class="col-md-12" align="center">
					<cemter><button type="submit" class="btn btn-primary" name="save" id="save"><i class="fa fa-save"></i> Save</button></cemter>
					</div>
				</div>
			</div>
				</div>
			</form>
        </div>

<!-- Modal Bidus-->
<script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.min.js')?>"></script>
<script src="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.min.js')?>"></script>
<script src="<?= base_url('assets/plugins/sweetalert/dist/sweetalert.js')?>"></script>
<!-- End Modal Bidus-->

<script type="text/javascript">

  $(document).ready(function() {
	$('.select2').select2();
    $(document).on('submit', '#data_form', function(e){
		e.preventDefault()
		var data = $('#data_form').serialize();
		// alert(data);

		swal({
		  title: "Anda Yakin?",
		  text: "Data Inventory akan di simpan.",
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
			  url:siteurl+'asset_category/saveNewcategory',
			  dataType : "json",
			  data:data,
			  success:function(result){
				  if(result.status == '1'){
					 swal({
						  title: "Sukses",
						  text : "Data Inventory berhasil disimpan.",
						  type : "success"
						},
						function (){
							window.location.reload(true);
						})
				  } else {
					swal({
					  title : "Error",
					  text  : "Data error. Gagal insert data",
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
   
  });

  

</script>
