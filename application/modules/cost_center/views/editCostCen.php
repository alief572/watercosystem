<?php
    $ENABLE_ADD     = has_permission('Inventory_1.Add');
    $ENABLE_MANAGE  = has_permission('Inventory_1.Manage');
    $ENABLE_VIEW    = has_permission('Inventory_1.View');
    $ENABLE_DELETE  = has_permission('Inventory_1.Delete');
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
							<div class="col-md-4">
							  <label for="">Nama Department</label>
							</div>
							 <div class="col-md-8">
							   <select id="id_department" name="id_department" class="form-control select" onchange="carinama()" required>
											<option value="">-- Pilih --</option>
											<?php foreach ($results['department'] as $department){ 
											$select = $record->id_dept == $department->id ? 'selected' : '';
											?>
											<option value="<?= $department->id?>" <?= $select ?>><?= ucfirst(strtolower($department->nm_dept))?></option>
											<?php } ?>
										  </select>
							</div>
						</div>
					</div>
					<div class="col-md-12" hidden>
							<div class="form-group row" id="tempat_nama">
							 <div class="col-md-8" >
							  <input type="text" class="form-control" value="<?= $record->nm_dept?>" id="nm_dept" required name="nm_dept" placeholder="Cost Center">
							</div>
							</div>
					</div>
					<div class="col-md-12">
							<div class="form-group row">
							<div class="col-md-4">
							  <label for="">Nama Cost Center</label>
							</div>
							 <div class="col-md-8">
							  <input type="text" class="form-control" value="<?= $record->cost_center?>" id="cost_center" required name="cost_center" placeholder="Cost Center">
							</div>
							 <div class="col-md-8" hidden>
							  <input type="text" class="form-control" value="<?= $record->id?>" id="id" required name="id" placeholder="Cost Center">
							</div>
						</div>	
					</div>
			<div class="col-md-3">
			<button type="submit" class="btn btn-primary" name="save" id="save"><i class="fa fa-save"></i> Save</button>
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
			  url:siteurl+'cost_center/saveEditCostCen',
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

 	function carinama(){
        var id_department=$("#id_department").val();
		 $.ajax({
            type:"GET",
            url:siteurl+'cost_center/cari_nama',
            data:"id_department="+id_department,
            success:function(html){
               $("#tempat_nama").html(html);
            }
        });
    } 

</script>
