<?php
    $ENABLE_ADD     = has_permission('Master_rate.Add');
    $ENABLE_MANAGE  = has_permission('Master_rate.Manage');
    $ENABLE_VIEW    = has_permission('Master_rate.View');
    $ENABLE_DELETE  = has_permission('Master_rate.Delete');
	
?>
<style type="text/css">
thead input {
	width: 100%;
}
</style>
<div id='alert_edit' class="alert alert-success alert-dismissable" style="padding: 15px; display: none;"></div>
<link rel="stylesheet" href="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.css')?>">


<div class="nav-tabs-supplier">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#rate" data-toggle="tab" aria-expanded="true">Master Rate</a></li>
    <li class=""><a href="#type_rate" data-toggle="tab" aria-expanded="false">Type Rate</a></li>
  </ul>

  <div class="tab-content">
    <div class="tab-pane active" id="rate">
      <div class="box box-primary">
        	<div class="box-header">
			<?php if($ENABLE_VIEW) : ?>
				<a class="btn btn-success btn-sm add_rate" href="javascript:void(0)" title="Add"><i class="fa fa-plus">&nbsp;</i>Tambah Data</a>
			<?php endif; ?>
		<span class="pull-right"></span>
	</div>
        	<div class="box-body">
		<table id="example1" class="table table-bordered table-striped">
		<thead>
		<tr>
			<th width="5">#</th>
			<th width="13%" hidden>Id Rate</th>
			<th>Cost Element</th>
			<th>Type Rate</th>
			<th>Presentase Rate</th>
			<?php if($ENABLE_MANAGE) : ?>
			<th width="13%">Action</th>
			<?php endif; ?>
		</tr>
		</thead>

		<tbody>
		<?php if(empty($results['rate'])){
		}else{
			
			$numb=0; foreach($results['rate'] AS $rate){ $numb++; ?>
		<tr>
		    <td><?= $numb; ?></td>
			<td hidden><?= $rate->id_rate?></td>
			<td><?= $rate->cost_element ?></td>
			<td><?= $rate->type_rate ?></td>
			<td><?= $rate->presentase_rate ?></td>
			<td style="padding-left:20px">
			<?php if($ENABLE_VIEW) : ?>
				<a class="btn btn-primary btn-sm view_rate" href="javascript:void(0)" title="View" data-id_rate="<?=$rate->id_rate?>"><i class="fa fa-eye"></i>
				</a>
			<?php endif; ?>

			<?php if($ENABLE_MANAGE) : ?>
				<a class="btn btn-success btn-sm edit_rate" href="javascript:void(0)" title="Edit" data-id_rate="<?=$rate->id_rate?>"><i class="fa fa-edit"></i>
				</a>
			<?php endif; ?>

			<?php if($ENABLE_DELETE) : ?>
				<a class="btn btn-danger btn-sm delete_rate" href="javascript:void(0)" title="Delete" data-id_rate="<?=$rate->id_rate?>"><i class="fa fa-trash"></i>
				</a>
			<?php endif; ?>
			</td>
		</tr>
		<?php } }  ?>
		</tbody>
		</table>
	</div>
      </div>
    </div>
    <div class="tab-pane" id="type_rate">
      <div class="box box-primary">
                	<div class="box-header">
			<?php if($ENABLE_VIEW) : ?>
				<a class="btn btn-success btn-sm add_type" href="javascript:void(0)" title="Add"><i class="fa fa-plus">&nbsp;</i>Add</a>
			<?php endif; ?>
		<span class="pull-right"></span>
	</div>
        	<div class="box-body">
		<table id="example1" class="table table-bordered table-striped">
		<thead>
		<tr>
			<th width="5">#</th>
			<th hidden width="13%">Id Type Rate</th>
			<th>Type Rate</th>
			<?php if($ENABLE_MANAGE) : ?>
			<th width="13%">Aksi</th>
			<?php endif; ?>
		</tr>
		</thead>

		<tbody>
		<?php if(empty($results['type'])){
		}else{
			
			$numb3=0; foreach($results['type'] as $type){ $numb3++; ?>
		<tr>
		    <td><?= $numb3; ?></td>
			<td hidden ><?= $type->id_type_rate?></td>
			<td><?= $type->type_rate ?></td>
			<td style="padding-left:20px">
			<?php if($ENABLE_VIEW) : ?>
				<a class="btn btn-primary btn-sm view_type" href="javascript:void(0)" title="View" data-id_type_rate="<?=$type->id_type_rate?>"><i class="fa fa-eye"></i>
				</a>
			<?php endif; ?>

			<?php if($ENABLE_MANAGE) : ?>
				<a class="btn btn-success btn-sm edit_type" href="javascript:void(0)" title="Edit" data-id_type_rate="<?=$type->id_type_rate?>"><i class="fa fa-edit"></i>
				</a>
			<?php endif; ?>

			<?php if($ENABLE_DELETE) : ?>
				<a class="btn btn-danger btn-sm delete_type" href="javascript:void(0)" title="Delete" data-id_type_rate="<?=$type->id_type_rate?>"><i class="fa fa-trash"></i>
				</a>
			<?php endif; ?>
			</td>
		</tr>
		
		<?php } }  ?>
		</tbody>
		</table>
	</div>
      </div>
    </div>
  </div>
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
        <h4 class="modal-title" id="myModalLabel"><span class="fa fa-users"></span>&nbsp;Add Master Rate Product Costing</h4>
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
</div>
<!-- DataTables -->
<script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.min.js')?>"></script>
<script src="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.min.js')?>"></script>
<!-- End Modal Bidus-->
<style>
  .box-primary {

    border: 1px solid #ddd;
  }
</style>
<!-- page script -->
<script type="text/javascript">

	$(document).on('click', '.edit_type', function(e){
		var id = $(this).data('id_type_rate');
		$("#head_title").html("<i class='fa fa-list-alt'></i><b>Edit Data</b>");
		$.ajax({
			type:'POST',
			url:siteurl+'master_rate/EditTypeRate/'+id,
			data:{'id':id},
			success:function(data){
				$("#dialog-popup").modal();
				$("#ModalView").html(data);
				
			}
		})
	});
	$(document).on('click', '.edit_rate', function(e){
		var id = $(this).data('id_rate');
		$("#head_title").html("<i class='fa fa-list-alt'></i><b>Edit Data</b>");
		$.ajax({
			type:'POST',
			url:siteurl+'master_rate/EditRate/'+id,
			data:{'id':id},
			success:function(data){
				$("#dialog-popup").modal();
				$("#ModalView").html(data);
				
			}
		})
	});
	
	$(document).on('click', '.view_type', function(){
		var id = $(this).data('id_type_rate');
		// alert(id);
		$("#head_title").html("<i class='fa fa-list-alt'></i><b>Detail Data</b>");
		$.ajax({
			type:'POST',
			url:siteurl+'master_rate/viewType/'+id,
			data:{'id':id},
			success:function(data){
				$("#dialog-popup").modal();
				$("#ModalView").html(data);
				
			}
		})
	});
	$(document).on('click', '.view_rate', function(){
		var id = $(this).data('id_rate');
		// alert(id);
		$("#head_title").html("<i class='fa fa-list-alt'></i><b>Detail Data</b>");
		$.ajax({
			type:'POST',
			url:siteurl+'master_rate/viewRate/'+id,
			data:{'id':id},
			success:function(data){
				$("#dialog-popup").modal();
				$("#ModalView").html(data);
				
			}
		})
	});
	$(document).on('click', '.add_rate', function(){
		$("#head_title").html("<i class='fa fa-list-alt'></i><b>Tambah Data</b>");
		$.ajax({
			type:'POST',
			url:siteurl+'master_rate/addRate',
			success:function(data){
				$("#dialog-popup").modal();
				$("#ModalView").html(data);
				
			}
		})
	});
	$(document).on('click', '.add_type', function(){
		$("#head_title").html("<i class='fa fa-list-alt'></i><b>Tambah Data</b>");
		$.ajax({
			type:'POST',
			url:siteurl+'master_rate/addType',
			success:function(data){
				$("#dialog-popup").modal();
				$("#ModalView").html(data);
				
			}
		})
	});
	
	
	// DELETE DATA
	$(document).on('click', '.delete_rate', function(e){
		e.preventDefault()
		var id = $(this).data('id_rate');
		// alert(id);
		swal({
		  title: "Anda Yakin?",
		  text: "Data akan di hapus.",
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
			  url:siteurl+'master_rate/deleteRate',
			  dataType : "json",
			  data:{'id':id},
			  success:function(result){
				  if(result.status == '1'){
					 swal({
						  title: "Sukses",
						  text : "Data berhasil dihapus.",
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
	$(document).on('click', '.delete_type', function(e){
		e.preventDefault()
		var id = $(this).data('id_type_rate');
		// alert(id);
		swal({
		  title: "Anda Yakin?",
		  text: "Data akan di hapus.",
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
			  url:siteurl+'master_rate/deleteType',
			  dataType : "json",
			  data:{'id':id},
			  success:function(result){
				  if(result.status == '1'){
					 swal({
						  title: "Sukses",
						  text : "Data berhasil dihapus.",
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

	    var table = $('#example1').DataTable( {
	        orderCellsTop: true,
	        fixedHeader: true
	    } );
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
