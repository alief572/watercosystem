<?php
    $ENABLE_ADD     = has_permission('Inventory_1.Add');
    $ENABLE_MANAGE  = has_permission('Inventory_1.Manage');
    $ENABLE_VIEW    = has_permission('Inventory_1.View');
    $ENABLE_DELETE  = has_permission('Inventory_1.Delete');
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
			<?php if($ENABLE_VIEW) : ?>
				<a href="<?= site_url('erp_karyawan/add') ?>" class="btn btn-sm btn-success" id='btn-add'>
					<i class="fa fa-plus"></i> Add
				</a>
			<?php endif; ?>

		<span class="pull-right">
		</span>
	</div>
	<!-- /.box-header  -->
	<!-- /.box-header -->
	<div class="box-body">
		<table id="example1" class="table table-bordered table-striped">
		<thead>
		<tr class="bg-yellow">
			<th width="5">#</th>
			<th class="text-center">NIK</th>
			<th class="text-center">Name</th>
			<th class="text-center">Stay Address</th>
			<th class="text-center">Company</th>
			<th class="text-center">Division</th>
			<th class="text-center">Departement</th>
			<th class="text-center">Title</th>
			<th class="text-center">Position</th>			
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

			<td align='left'><?= $record->nik ?></td>
			<td align='left'><?= $record->name ?></td>
			<td align='left'><?= $record->address ?></td>
			<td align='left'><?= $record->company_name ?></td>
			<td align='left'><?= $record->division_name ?></td>
			<td align='left'><?= $record->department_name ?></td>
			<td align='left'><?= $record->title_name ?></td>
			<td align='left'><?= $record->position_name ?></td>
			
			<td style="padding-left:20px">
			<?php if($ENABLE_VIEW) : ?>
				<a class="btn btn-primary btn-sm view" href="javascript:void(0)" title="View" data-id_karyawan="<?=$record->id_karyawan?>"><i class="fa fa-eye"></i>
				</a>
			<?php endif; ?>

			<?php if($ENABLE_MANAGE) : ?>
				<a href="<?= site_url('erp_karyawan/edit/'. $record->id) ?>" class="btn btn-warning btn-sm edit" id='btn-edit' title='Edit Data' data-role='qtip'>
					<i class="fa fa-edit"></i>
				</a>
			<?php endif; ?>

			<?php if($ENABLE_DELETE) : ?>
				<a class="btn btn-danger btn-sm delete" href="javascript:void(0)" title="Delete" data-id_karyawan="<?=$record->id_karyawan?>"><i class="fa fa-trash"></i>
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
        <h4 class="modal-title" id="myModalLabel"><span class="fa fa-users"></span>&nbsp;Data Karyawan</h4>
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
		var id = $(this).data('id_karyawan');
		$("#head_title").html("<i class='fa fa-list-alt'></i><b>Edit Inventory</b>");
		$.ajax({
			type:'POST',
			url:siteurl+'master_karyawan/editKaryawan/'+id,
			success:function(data){
				$("#dialog-popup").modal();
				$("#ModalView").html(data);
				
			}
		})
	});
	
	$(document).on('click', '.view', function(e){
		var id = $(this).data('id_karyawan');
		$("#head_title").html("<i class='fa fa-list-alt'></i><b>Edit Inventory</b>");
		$.ajax({
			type:'POST',
			url:siteurl+'master_karyawan/viewKaryawan/'+id,
			success:function(data){
				$("#dialog-popup").modal();
				$("#ModalView").html(data);
				
			}
		})
	});
		$(document).on('click', '.add', function(){
		$("#head_title").html("<i class='fa fa-list-alt'></i><b>Tambah Inventory</b>");
		$.ajax({
			type:'POST',
			url:siteurl+'master_karyawan/addKaryawan',
			success:function(data){
				$("#dialog-popup").modal();
				$("#ModalView").html(data);
				
			}
		})
	});
	
	
	// DELETE DATA
	$(document).on('click', '.delete', function(e){
		e.preventDefault()
		var id = $(this).data('id_karyawan');
		// alert(id);
		swal({
		  title: "Anda Yakin?",
		  text: "Data Inventory akan di hapus.",
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
			  url:siteurl+'master_karyawan/deleteInventory',
			  dataType : "json",
			  data:{'id':id},
			  success:function(result){
				  if(result.status == '1'){
					 swal({
						  title: "Sukses",
						  text : "Data Customer berhasil dihapus.",
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
    	// $('#example1 thead tr').clone(true).appendTo( '#example1 thead' );
	    // $('#example1 thead tr:eq(1) th').each( function (i) {
	        // var title = $(this).text();
	        //alert(title);
	        // if (title == "#" || title =="Action" ) {
	        	// $(this).html( '' );
	        // }else{
	        	// $(this).html( '<input type="text" />' );
	        // }

	        // $( 'input', this ).on( 'keyup change', function () {
	            // if ( table.column(i).search() !== this.value ) {
	                // table
	                    // .column(i)
	                    // .search( this.value )
	                    // .draw();
	            // }else{
	            	// table
	                    // .column(i)
	                    // .search( this.value )
	                    // .draw();
	            // }
	        // } );
	    // } );

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
