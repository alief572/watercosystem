<?php
    $ENABLE_ADD     = has_permission('Diskon.Add');
    $ENABLE_MANAGE  = has_permission('Diskon.Manage');
    $ENABLE_VIEW    = has_permission('Diskon.View');
    $ENABLE_DELETE  = has_permission('Diskon.Delete');
	$tanggal = date('Y-m-d');
?>

<div class="box box-primary">
            <div class="box-body">
			
			<form id="data_form">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group row">
							<div class="col-md-2">
							  <label for="">Nama TOP</label>
							</div>
							 <div class="col-md-6">
							  <input type="text" class="form-control" id="top" required name="top" placeholder="Nama TOP">
							</div>
										<div class="col-md-3">
			<button type="submit" class="btn btn-primary" name="save" id="save"><i class="fa fa-save"></i> Save</button>
			</div>
						</div>
					</div>
				</div>
				
			</form>
        </div>
	
				  
				  
        <script type="text/javascript">

$(document).ready(function() {
  $('.select2').select2();
  $(document).on('submit', '#data_form', function(e){
      e.preventDefault()
      var data = $('#data_form').serialize();
      // alert(data);

      swal({
        title: "Anda Yakin?",
        text: "Data Top akan di simpan.",
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
            url:siteurl+'ms_top/saveNewmstop',
            dataType : "json",
            data:data,
            success:function(result){
                if(result.status == '1'){
                   swal({
                        title: "Sukses",
                        text : "Data Kurs berhasil disimpan.",
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