<?php
    $ENABLE_ADD     = has_permission('Top.Add');
    $ENABLE_MANAGE  = has_permission('Top.Manage');
    $ENABLE_VIEW    = has_permission('Top.View');
    $ENABLE_DELETE  = has_permission('Top.Delete');
?>
<style type="text/css">
thead input {
	width: 100%;
}
</style>
<div id='alert_edit' class="alert alert-success alert-dismissable" style="padding: 15px; display: none;"></div>
<link rel="stylesheet" href="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.css')?>">
<div class="box">
	<div class="box-header">
			 <?php if($ENABLE_ADD) : ?>
				<a class="btn btn-success btn-sm" href="<?= base_url('/ms_top/AddTopMs/') ?>"  title="Add New Master"><i class="fa fa-plus">&nbsp;</i>Add Master</i></a>
			<?php endif; ?>
	
            <?php if($ENABLE_ADD) : ?>
				<a class="btn btn-success btn-sm" href="<?= base_url('/ms_top/AddTop/') ?>"  title="Add New"><i class="fa fa-plus">&nbsp;</i>Add TOP</i></a>
			<?php endif; ?>
			
			

		<span class="pull-right">
		</span>
	</div>
	<!-- /.box-header -->
	<!-- /.box-header -->
	<div class="box-body">
		<table id="example1" class="table table-bordered table-striped">
		<thead>
		<tr>
			<th width="5">#</th>
			<th>Top</th>
			<th>Payment</th>
			<th>Keterangan</th>
            <th>Persentase</th>
			<?php if($ENABLE_MANAGE) : ?>
			<th width="13%">Action</th>
			<?php endif; ?>
		</tr>
		</thead>
		<tbody>
		<?php if(empty($results)){
		}else{
			$numb=0; foreach($results AS $record){ $numb++; ?>
		<tr>
		    <td><?= $numb; ?></td>
			<td><?= $record->nama_top ?></td>
			<td><?= $record->payment ?></td>
			<td><?= $record->keterangan ?></td>
            <td><?= $record->persentase ?></td>
			<td style="padding-left:20px">
		
			<?php if($ENABLE_MANAGE) : ?>
				<a class="btn btn-success btn-sm edit" href="javascript:void(0)" title="Edit" data-id="<?=$record->id_top_planning?>"><i class="fa fa-edit"></i>
				</a>
			<?php endif; ?>

			<?php if($ENABLE_DELETE) : ?>
				<a class="btn btn-danger btn-sm delete" href="javascript:void(0)" title="Delete" data-id="<?=$record->id_top_planning?>"><i class="fa fa-trash"></i>
				</a>
			<?php endif; ?>
			</td>

		</tr>
		<?php } }  ?>
		</tbody>
		</table>
	</div>
	<!-- /.box-body -->
</div>

<!-- awal untuk modal dialog -->
<!-- Modal -->
<div class="modal modal-primary" id="dialog-rekap" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel"><span class="fa fa-file-pdf-o"></span>&nbsp;Rekap Data Customer</h4>
      </div>
      <div class="modal-body" id="MyModalBody">
		...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">
        <span class="glyphicon glyphicon-remove"></span>  Close</button>
        </div>
    </div>
  </div>
</div>

<div class="modal modal-default fade" id="dialog-popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel"><span class="fa fa-users"></span>&nbsp;Data Inventory</h4>
      </div>
      <div class="modal-body" id="ModalView">
		...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">
        <span class="glyphicon glyphicon-remove"></span>  Close</button>
        </div>
    </div>
  </div>
</div>

<!-- DataTables -->
<script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.min.js')?>"></script>
<script src="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.min.js')?>"></script>

<!-- page script -->
<script type="text/javascript">

	$(document).on('click', '.edit', function(e){
		var id = $(this).data('id');
		$("#head_title").html("<i class='fa fa-list-alt'></i><b>Edit Term Of Payment</b>");
		$.ajax({
			type:'POST',
			url:siteurl+'ms_top/editTop/'+id,
			success:function(data){
				$("#dialog-popup").modal();
				$("#ModalView").html(data);
				
			}
		})
	});
	
		
	
	// DELETE DATA
	$(document).on('click', '.delete', function(e){
		e.preventDefault()
		var id = $(this).data('id');
		// alert(id);
		swal({
		  title: "Anda Yakin?",
		  text: "Data Ini akan di hapus.",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonClass: "btn-info",
		  confirmButtonText: "Ya, Hapus!",
		  cancelButtonText: "Batal",
		  closeOnConfirm: false
		},
		function(){
		  $.ajax({
			  type:'POST',
			  url:siteurl+'ms_top/deleteTop',
			  dataType : "json",
			  data:{'id':id},
			  success:function(result){
				  if(result.status == '1'){
					 swal({
						  title: "Sukses",
						  text : "Data data berhasil dihapus.",
						  type : "success"
						},
						function (){
							window.location.reload(true);
						})
				  } else {
					swal({
					  title : "Error",
					  text  : "Data error. Gagal hapus data",
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

  	$(function() {
    	// var table = $('#example1').DataTable( {
	        // orderCellsTop: true,
	        // fixedHeader: true
	    // } );
    	$("#form-area").hide();
  	});
	
	
	//Delete

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
