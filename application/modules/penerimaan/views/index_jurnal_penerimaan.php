<?php
    $ENABLE_ADD     = has_permission('Penerimaan.Add');
    $ENABLE_MANAGE  = has_permission('Penerimaan.Manage');
    $ENABLE_VIEW    = has_permission('Penerimaan.View');
    $ENABLE_DELETE  = has_permission('Penerimaan.Delete');
?>
	<style type="text/css">
thead input {
	width: 100%;
}

.modal-dialog {
/* new custom width */
width: 85%;
}

</style>
<div id='alert_edit' class="alert alert-success alert-dismissable" style="padding: 15px; display: none;"></div>
<link rel="stylesheet" href="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.css')?>">

<div class="box">
		<div class="box-body">
		<table id="tbl_jurnal_bum" class="table table-bordered table-striped" width="100%">
		<thead>
					<tr class='bg-blue'>
						<th class="text-center" width='4%'>No</th>
						<th width='7%'>Tgl Penerimaan</th>
						<th width='7%'>Kode Penerimaan</th>
						<th width='7%'>Nama Customer</th>
						<th width='18%'>Keterangan</th>
						<th width='7%'>No Invoice</th>
						<th width='7%'>Total Invoice</th>
						<th width='7%'>PPH</th>
						<th width='7%'>Biaya Admin</th>
						<th width='7%'>Lebih Bayar</th>
						<th width='7%'>Total Penerimaan</th>
						<th width='7%'>Option</th>
					</tr>
				</thead>
				<tbody></tbody>
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
        <h4 class="modal-title" id="myModalLabel"><span class="fa fa-users"></span>&nbsp;Data Invoicing</h4>
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

	$(function() {
		// Header selalu punya 12 kolom (Option kosong bila tanpa izin Manage), jadi columns juga 12.
		$('#tbl_jurnal_bum').DataTable({
			processing: true,
			serverSide: true,
			autoWidth: false,
			order: [],
			ajax: { url: siteurl + 'penerimaan/get_data_jurnal_bum', type: 'POST' },
			columns: [
				{ data: 'no' }, { data: 'tgl' }, { data: 'kode' }, { data: 'customer' }, { data: 'keterangan' },
				{ data: 'invoice' }, { data: 'total_invoice', className: 'text-right' }, { data: 'pph', className: 'text-right' },
				{ data: 'admin', className: 'text-right' }, { data: 'lebih_bayar', className: 'text-right' },
				{ data: 'total', className: 'text-right' }, { data: 'action' }
			],
			columnDefs: [{ orderable: false, targets: [0, 11] }]
		});

		// Setelah modal jurnal ditutup, muat ulang tabel supaya penerimaan yang sudah dijurnal hilang.
		$('#dialog-popup').on('hidden.bs.modal', function() {
			$('#tbl_jurnal_bum').DataTable().ajax.reload(null, false);
		});
	});

	$(document).on('click', '.edit', function(e){
		var id = $(this).data('no_penawaran');
		$("#head_title").html("<i class='fa fa-list-alt'></i><b>Edit Inventory</b>");
		$.ajax({
			type:'POST',
			url:siteurl+'wt_penawaran/editPenawaran/'+id,
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
	
	$(document).on('click', '.view3', function(){
		var id = $(this).data('id_material');
	    var pp = 'JV003';
		var akses = 'jurnalpenerimaan';
		// alert(id);
		$("#head_title").html("<i class='fa fa-list-alt'></i><b>Detail Jurnal</b>");
		$.ajax({
			type:'POST',
			url:siteurl+'jurnal_nomor/jurnal_fn/jurnal_penerimaan/'+id+'/'+pp+'/'+akses,
			data:{'id':id},
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