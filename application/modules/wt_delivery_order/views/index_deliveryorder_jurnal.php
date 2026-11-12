<?php
    $ENABLE_ADD     = has_permission('Planning_Delivery.Add');
    $ENABLE_MANAGE  = has_permission('Planning_Delivery.Manage');
    $ENABLE_VIEW    = has_permission('Planning_Delivery.View');
    $ENABLE_DELETE  = has_permission('Planning_Delivery.Delete');
	
?>
<style type="text/css">
thead input {
	width: 100%;
}

.modal-dialog {
/* new custom width */
width: 95%;
}
</style>
<div id='alert_edit' class="alert alert-success alert-dismissable" style="padding: 15px; display: none;"></div>
<link rel="stylesheet" href="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.css')?>">

<div class="box">
	    
	<div class="box-body">
		<table id="tbl_do_jurnal" class="table table-bordered table-striped" width="100%">
		<thead>
		<tr>
			<th>#</th>
			<th>No SPK Delivery</th>
			<th>No Delivery</th>
			<th>Tanggal SPK</th>
			<th>Nama Customer</th>
			<th>Nilai Inventory</th>
			<th>Action</th>
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
        <h4 class="modal-title" id="myModalLabel"><span class="fa fa-users"></span>&nbsp;Jurnal Delivery</h4>
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
		$('#tbl_do_jurnal').DataTable({
			processing: true,
			serverSide: true,
			autoWidth: false,
			order: [],
			ajax: {
				url: siteurl + 'wt_delivery_order/get_data_do_jurnal',
				type: 'POST'
			},
			columns: [
				{ data: 'no' },
				{ data: 'no_spk' },
				{ data: 'no_do' },
				{ data: 'tgl_do' },
				{ data: 'nama_customer' },
				{ data: 'nilai' },
				{ data: 'action' }
			],
			columnDefs: [{
				orderable: false,
				targets: [0, 6]
			}]
		});
	});

	// Tampilkan detail jurnal di modal. Setelah modal ditutup, muat ulang tabel supaya tombol
	// yang statusnya sudah berubah (jurnal tersimpan) langsung hilang.
	function bukaJurnal(id, kode, akses, fn) {
		$("#head_title").html("<i class='fa fa-list-alt'></i><b>Detail Jurnal</b>");
		$.ajax({
			type: 'POST',
			url: siteurl + 'jurnal_nomor/jurnal_fn/' + fn + '/' + id + '/' + kode + '/' + akses,
			data: {'id': id},
			success: function(data) {
				$("#dialog-popup").modal();
				$("#ModalView").html(data);
			},
			error: function() {
				swal({title: "Error Message !", text: 'Gagal memuat jurnal. Coba lagi.', type: "warning"});
			}
		});
	}

	$(document).on('click', '.view3', function() {
		bukaJurnal($(this).data('id_material'), 'JV004', 'jurnaldelivery', 'jurnal_delivery');
	});

	$(document).on('click', '.view4', function() {
		bukaJurnal($(this).data('id_material'), 'JV005', 'jurnalconfirmdelivery', 'jurnal_confirmdelivery');
	});

	$('#dialog-popup').on('hidden.bs.modal', function() {
		$('#tbl_do_jurnal').DataTable().ajax.reload(null, false);
	});
</script>
