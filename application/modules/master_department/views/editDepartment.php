<?php
    $ENABLE_ADD     = has_permission('Master_department.Add');
    $ENABLE_MANAGE  = has_permission('Master_department.Manage');
    $ENABLE_VIEW    = has_permission('Master_department.View');
    $ENABLE_DELETE  = has_permission('Master_department.Delete');
	foreach ($results['inven'] as $record){
}
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
							<div class="col-md-2">
							  <label for="">Nama Department</label>
							</div>
							 <div class="col-md-6">
							  <input type="text" class="form-control" id="nm_dept" required name="nm_dept" value="<?= $record->nm_dept ?>"  placeholder="Nama Department">
							</div>
							<div class="col-md-8" hidden>
							   <input type="text" class="form-control" id="id" required name="id" value="<?= $record->id ?>" placeholder="Nama Kategory Asset">
							</div>
										<div class="col-md-3">
			<button type="submit" class="btn btn-primary" name="save" id="save"><i class="fa fa-save"></i> Save</button>
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
			  url:siteurl+'master_department/saveEditDepartment',
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
