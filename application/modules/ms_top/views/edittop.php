<?php
    $ENABLE_ADD     = has_permission('Top.Add');
    $ENABLE_MANAGE  = has_permission('Top.Manage');
    $ENABLE_VIEW    = has_permission('Top.View');
    $ENABLE_DELETE  = has_permission('Top.Delete');

foreach ($results['top'] as $top){
}	

?>
<style type="text/css">
thead input {
	width: 100%;
}
</style>
<div id='alert_edit' class="alert alert-success alert-dismissable" style="padding: 15px; display: none;"></div>
<link rel="stylesheet" href="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.css')?>">
<div class="box box-primary">
	<!-- /.box-header -->
	<div class="box-body">
		<form id="data_form">
		<input type="hidden" name="id_top_planning" id="id_top_planning" value='<?= $top->id_top_planning ?>'>
		<div class="row">
			<div class="col-md-12"><legend>Data Term Of Payment</legend></div>
			<div class="col-md-6">
				<div class="form-group row">
					<div class="col-md-3">
					 <label for="Top">Term Of Payment</label>
					</div>
					<div class="col-md-9">
					  <select id="top"  name="top"  class="form-control select" required>
						<option value="">-- Pilih --</option>
						<?php foreach ($results['select_top'] as $select_top){
						$select = $top->id_top == $select_top->id_top ? 'selected' : '';
						?>
						<option value="<?= $select_top->id_top?>" <?= $select ?>><?= $select_top->nama_top?></option>
						<?php } ?>
					  </select>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-md-3">
					 <label for="top" >Payment</label>
					</div>
					<div class="col-md-9">
					  <select id="top" name="payment" class="form-control select" required>
						<option value="">-- Pilih --</option>
						<?php 
						$select1 = $top->payment == 'Payment I'? 'selected' : '';
                        $select2 = $top->payment == 'Payment II'? 'selected' : '';
                        $select3 = $top->payment == 'Payment III'? 'selected' : '';
                        $select4 = $top->payment == 'Payment IV'? 'selected' : '';
                        $select5 = $top->payment == 'Payment V'? 'selected' : '';
						?>
                        <option value='Payment I' <?=$select1?>>Payment I</option>
                        <option value='Payment II' <?=$select2?>>Payment II</option>
                        <option value='Payment III' <?=$select3?>>Payment III</option>
                        <option value='Payment IV' <?=$select4?>>Payment IV</option>
                        <option value='Payment V' <?=$select5?>>Payment V</option>   

						
					  </select>
					</div>
				</div>
                <div class="form-group row">
					<div class="col-md-3">
					  <label for="">Keterangan</label>
					</div>
					 <div class="col-md-9">
					  <input type="text" class="form-control" id="keterangan" required name="keterangan" placeholder="keterangan" value="<?= $top->keterangan ?>">
					</div>
				</div>
				<div class="form-group row">
					<div class="col-md-3">
					  <label for="">Nilai</label>
					</div>
					 <div class="col-md-9">
					  <input type="text" class="form-control" id="persentase" required name="persentase" placeholder="persentase" value="<?= $top->persentase ?>">
					</div>
				</div>
				
			</div>
		</div>
	<hr>
	<button type="submit" class="btn btn-primary" name="save" id="save"><i class="fa fa-save"></i> Save</button>
	</form>
	</div>
	<!-- /.box-body -->
</div>

<!-- DataTables -->
<script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.min.js')?>"></script>
<script src="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.min.js')?>"></script>

<!-- page script -->
<script type="text/javascript">

  	$(function() {
		$('.select2').select2();
  	});
	
	
	// ADD CUSTOMER 
	
	$(document).on('submit', '#data_form', function(e){
		e.preventDefault()
		var data = $('#data_form').serialize();
		var id = $('#id_diskon').val();
		// alert(id);
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
			  url:siteurl+'ms_top/saveEditTop',
			  dataType : "json",
			  data:data,
			  success:function(result){
				  if(result.status == '1'){
					 swal({
						  title: "Sukses",
						  text : "Data berhasil disimpan.",
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
