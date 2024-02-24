<?php
    $ENABLE_ADD     = has_permission('Penawaran.Add');
    $ENABLE_MANAGE  = has_permission('Penawaran.Manage');
    $ENABLE_VIEW    = has_permission('Penawaran.View');
    $ENABLE_DELETE  = has_permission('Penawaran.Delete');
	
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
				<a class="btn btn-success btn-sm add" href="javascript:void(0)" title="Add"><i class="fa fa-plus">&nbsp;</i>Add</a>
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
			<th>#</th>
			<th >No.Penawaran</th>
			<th>Nama Customer</th>
			<th>Tanggal Inquiry</th>
			<th>Status</th>
			<th>Ket Closing</th>
			<?php if($ENABLE_MANAGE) : ?>
			<th>Action</th>
			<?php endif; ?>
		</tr>
		</thead>

		<tbody>
		<?php if(empty($results)){
		}else{
			
			$numb=0; foreach($results AS $record){ $numb++; 
			
				$get_spk = $this->db->select('no_surat')->get_where('tr_spk_marketing', array('no_penawaran'=>$record->no_penawaran))->result_array();
				$arrImp = [];
				foreach ($get_spk as $key => $value) {
					$arrImp[] = $value['no_surat'];
				}
				$Status = "<span class='badge bg-yellow'>Open</span>";
				$keterangan = ucfirst(strtolower($record->keterangan));
				if($record->spkmarketing != NULL){
					$Status = "<span class='badge bg-green'>Closed</span>";
					$keterangan = implode("<br>", $arrImp);
				}
				if($record->spkmarketing == NULL AND $record->status == 'Y'){
					$Status = "<span class='badge bg-red'>Closed</span>";
				}
			?>
		<tr>
		    <td><?= $numb; ?></td>
			<td><?= $record->no_surat ?></td>
			<td><?= strtoupper($record->name_customer) ?></td>
			<td><?= date('d-F-Y', strtotime($record->tgl_penawaran)) ?></td>
			<td><?=$Status;?></td>
			<td><?= $keterangan;?></td>
			<td style="padding-left:20px">
			<?php if($ENABLE_VIEW) : ?>
				<a class="btn btn-warning btn-sm view" href="javascript:void(0)" title="View" data-no_penawaran="<?=$record->no_penawaran?>"><i class="fa fa-eye"></i>
				</a>
			<?php endif; ?>

			<?php if($ENABLE_MANAGE AND $record->status == 'N') : ?>
				<a class="btn btn-success btn-sm edit" href="javascript:void(0)" title="Edit" data-no_penawaran="<?=$record->no_penawaran?>"><i class="fa fa-edit"></i>
				</a>
			<?php endif; ?>

			<?php if($ENABLE_VIEW AND $record->status == 'N') : ?>
				<a class="btn btn-primary btn-sm" href="<?= base_url('/penawaran/detail/'.$record->no_penawaran) ?>" title="Detail" data-no_inquiry="<?=$record->no_inquiry?>"><i class="fa fa-table"></i>
				</a>
			<?php endif; ?>
			<?php if($ENABLE_VIEW) : ?>
				<a class="btn btn-info btn-sm" href="<?= base_url('/penawaran/PrintHeader/'.$record->no_penawaran) ?>" target="_blank" title="Detail" data-no_inquiry="<?=$record->no_inquiry?>"><i class="fa fa-print"></i>
				</a>
			<?php endif; ?>
			<?php if($ENABLE_MANAGE AND $record->status == 'N') : ?>
				<a class="btn bg-purple btn-sm close_penawaran" href="javascript:void(0)" title="Close Penawaran" data-no_penawaran="<?=$record->no_penawaran?>"><i class="fa fa-check"></i>
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
<div class="modal modal-primary" id="dialog-rekap" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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

<div class="modal modal-default fade" id="dialog-popup" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel"><span class="fa fa-users"></span>&nbsp;Data Penawaran</h4>
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

<!-- modal -->
<div class="modal modal-default fade" id="ModalViewX"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<h4 class="modal-title" id='head_title'>Closing Penawaran</h4>
		</div>
		<div class="modal-body" id="viewX">
			
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-primary" data-dismiss="modal" id='close_penawaran'>Save</button>
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- DataTables -->
<script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.min.js')?>"></script>
<script src="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.min.js')?>"></script>

<!-- page script -->
<script type="text/javascript">

	$(document).on('click', '.edit', function(e){
		var id = $(this).data('no_penawaran');
		$("#head_title").html("<i class='fa fa-list-alt'></i><b>Edit Inventory</b>");
		$.ajax({
			type:'POST',
			url:siteurl+'penawaran/EditHeader/'+id,
			success:function(data){
				$("#dialog-popup").modal();
				$("#ModalView").html(data);
				
			}
		})
	});
	
		$(document).on('click', '.cetak', function(e){
		var id = $(this).data('no_penawaran');
		$("#head_title").html("<i class='fa fa-list-alt'></i><b>Edit Inventory</b>");
		$.ajax({
			type:'POST',
			url:siteurl+'xtes/cetak'+id,
			success:function(data){
				
			}
		})
	});
	
	$(document).on('click', '.view', function(){
		var id = $(this).data('no_penawaran');
		// alert(id);
		$("#head_title").html("<i class='fa fa-list-alt'></i><b>Detail Inventory</b>");
		$.ajax({
			type:'POST',
			url:siteurl+'penawaran/ViewHeader/'+id,
			data:{'id':id},
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
			url:siteurl+'penawaran/addHeader',
			success:function(data){
				$("#dialog-popup").modal();
				$("#ModalView").html(data);
				
			}
		})
	});
	
	
	// CLOSE PENAWARAN
	$(document).on('click','.close_penawaran', function(e){
		e.preventDefault();
		var id = $(this).data('no_penawaran');
		
		$("#head_title").html("Closing Penawaran");
		$.ajax({
			type:'POST',
			url: base_url + active_controller+'/modal_closing_penawaran/'+id,
			success:function(data){
				$("#ModalViewX").modal();
				$("#viewX").html(data);

			},
			error: function() {
				swal({
				title				: "Error Message !",
				text				: 'Connection Timed Out ...',
				type				: "warning",
				timer				: 5000,
				showCancelButton	: false,
				showConfirmButton	: false,
				allowOutsideClick	: false
				});
			}
		});
	});

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
