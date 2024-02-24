<?= form_open($this->uri->uri_string(),array('id'=>'frm_data','name'=>'frm_data','role'=>'form','class'=>'form-horizontal')) ?>
<?php
$readonly=""; 
if (isset($data->id)) $readonly=" readonly"; ?>
<input type="hidden" id="id" name="id" value="<?php echo (isset($data->id) ? $data->id : ''); ?>">
<div class="tab-content">
	<div class="tab-pane active">
		<div class="box box-primary">
			<div class="box-body">
				<div class="form-group ">
					<label for="wh_name" class="col-sm-2 control-label">Nama Gudang<b class="text-red">*</b></label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="wh_name" name="wh_name" value="<?php echo (isset($data->nama_gudang) ? $data->nama_gudang: ""); ?>" placeholder="Nama Gudang" required>							
					</div>
				</div>
				<div class="box-footer">
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button type="submit" name="save" class="btn btn-success btn-sm" id="submit"><i class="fa fa-save">&nbsp;</i>Simpan</button>
							<a class="btn btn-warning btn-sm" onclick="cancel()"><i class="fa fa-reply">&nbsp;</i>Batal</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?= form_close() ?>
<script type="text/javascript">
	// var url_save = siteurl+'warehouse/save/';
    // $('#frm_data').on('submit', function(e){
        // e.preventDefault();
		// var errors="";		
		// if($("#wh_name").val()=="") errors="Nama gudang tidak boleh kosong";	
		// if(errors==""){
			// data_save();
		// }else{
			// swal(errors);
			// return false;
		// }
    // });
	
	
	$(document).on('submit', '#frm_data', function(e){
		e.preventDefault()
		var data = $('#frm_data').serialize();
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
			  url:siteurl+'warehouse/save',
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
</script>
