<link rel="stylesheet" href="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.css') ?>">

<div class="box">
	<div class="row">
		<div class="col-sm-10">
			<div class="col-sm-3">
				<div class="form-group">
					<br>
					<label for="nomor">Nomor Planning</label>
					<input type="text" name="nomor" id="nomor" maxlength="100" class="form-control input-sm" autocomplete="off">
				</div>
			</div>
			<div class="col-sm-5">
				<div class="form-group">
					<br>
					<label> &nbsp;</label><br>
					<button type="button" id="btn-tampilkan" class="btn warnaTombol pull-center">Tampilkan</button>
				</div>
			</div>
		</div>
	</div>

	<div class="box-body">
		<table id="tbl_batal_planning" class="table table-bordered table-striped" width="100%">
			<thead>
				<tr class='bg-blue'>
					<th class="text-center" width='4%'>No</th>
					<th width='10%'>No Planning</th>
					<th width='15%'>No SO</th>
					<th width='25%'>Nama Customer</th>
					<th width='12%'>Nama Sales</th>
					<th width='10%'>TOP</th>
					<th width='10%'>Status Tagih</th>
					<th width='7%'>Action</th>
				</tr>
			</thead>
			<tbody></tbody>
		</table>
	</div>
	<!-- /.box-body -->
</div>
<!-- /.box -->

<!-- DataTables -->
<script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.min.js') ?>"></script>

<!-- page script -->
<script type="text/javascript">
	$(document).ready(function() {
		// id tbl_batal_planning (bukan example2) agar tidak bentrok dengan init otomatis basic.js.
		var tbl = $('#tbl_batal_planning').DataTable({
			processing: true,
			serverSide: true,
			autoWidth: false,
			searchDelay: 350,
			order: [],
			ajax: {
				url: siteurl + 'tools/data_planning',
				type: 'POST',
				data: function(d) {
					d.nomor = $('#nomor').val();
				}
			},
			columns: [
				{ data: 'no', orderable: false, searchable: false },
				{ data: 'no_surat_planning' }, { data: 'no_surat' }, { data: 'customer' }, { data: 'sales' }, { data: 'top' },
				{ data: 'status_tagih', orderable: false, searchable: false },
				{ data: 'action', className: 'text-center', orderable: false, searchable: false }
			]
		});

		$('#btn-tampilkan').on('click', function() {
			tbl.ajax.reload();
		});
		$('#nomor').on('keydown', function(e) {
			if (e.which === 13) {
				e.preventDefault();
				tbl.ajax.reload();
			}
		});

		// DELETE DATA
		$(document).on('click', '.delete', function(e) {
			e.preventDefault();
			var id = $(this).data('no_planning');
			swal({
					title: "Anda Yakin?",
					text: "Data Planning akan di hapus.",
					type: "warning",
					showCancelButton: true,
					confirmButtonClass: "btn-info",
					confirmButtonText: "Ya, Hapus!",
					cancelButtonText: "Batal",
					closeOnConfirm: false
				},
				function() {
					$.ajax({
						type: 'POST',
						url: siteurl + 'tools/hapusplanning',
						dataType: "json",
						data: {
							'id': id
						},
						success: function(result) {
							if (result.status == '1') {
								swal({
									title: "Sukses",
									text: "Data Planning berhasil dihapus.",
									type: "success"
								}, function() {
									tbl.ajax.reload(null, false);
								});
							} else {
								swal({
									title: "Error",
									text: result.pesan || "Data error. Gagal hapus data",
									type: "error"
								});
							}
						},
						error: function() {
							swal({
								title: "Error",
								text: "Data error. Gagal request Ajax",
								type: "error"
							});
						}
					});
				});
		});
	});
</script>
