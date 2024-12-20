<div class="form-group">
    <label for="keterangan">Keterangan Closing Penawaran</label>
    <input type="hidden" id='no_penawaranx' value='<?=$id;?>'>
    <textarea class="form-control" id="keteranganx" placeholder="Keterangan" rows='3'></textarea>
</div>

<style>
	textarea {
		resize: vertical;
	}
</style>
<script type="text/javascript">
    
	$(document).on('click', '#close_penawaran', function(){
		
		var id = $('#no_penawaranx').val();
		var ket = $('#keteranganx').val();

		swal({
		  title: "Anda Yakin?",
		  text: "Closing Penawaran !!!",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonClass: "btn-info",
		  confirmButtonText: "Ya!",
		  cancelButtonText: "Batal",
		  closeOnConfirm: false
		},
		function(){
		  $.ajax({
			  type:'POST',
			  url:siteurl+'penawaran/close_penawaran',
			  dataType : "json",
			  data:{
				  'id':id,
				  'ket':ket
				},
			  success:function(result){
				  if(result.status == '1'){
					 swal({
						  title: "Sukses",
						  text : "Close Success !!!",
						  type : "success"
						},
						function (){
							window.location.reload(true);
						})
				  } else {
					swal({
					  title : "Error",
					  text  : "Data error. Close Failed !!!",
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
	});
</script>