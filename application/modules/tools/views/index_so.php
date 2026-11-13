<link rel="stylesheet" href="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.css') ?>">

<div class="box">
	<div class="row">
		<div class="col-sm-10">
			<div class="col-sm-3">
				<div class="form-group">
					<br>
					<label for="nomor">Nomor SO</label>
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
		<table id="tbl_batal_so" class="table table-bordered table-striped" width="100%">
			<thead>
				<tr>
					<th>#</th>
					<th width="12%">No.SO</th>
					<th>Nama Customer</th>
					<th>Marketing</th>
					<th class="text-right">Nilai<br>Penawaran</th>
					<th class="text-right">Nilai<br>SO</th>
					<th>Action</th>
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
		// id tbl_batal_so (bukan example2) agar tidak bentrok dengan init otomatis basic.js.
		var tbl = $('#tbl_batal_so').DataTable({
			processing: true,
			serverSide: true,
			autoWidth: false,
			searchDelay: 350,
			order: [],
			ajax: {
				url: siteurl + 'tools/data_so',
				type: 'POST',
				data: function(d) {
					d.nomor = $('#nomor').val();
				}
			},
			columns: [
				{ data: 'no', orderable: false, searchable: false },
				{ data: 'no_surat' }, { data: 'customer' }, { data: 'sales' },
				{ data: 'nilai_penawaran', className: 'text-right' }, { data: 'nilai_so', className: 'text-right' },
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
			var id = $(this).data('no_so');
			swal({
					title: "Anda Yakin?",
					text: "Data SO akan di hapus.",
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
						url: siteurl + 'tools/hapus_so',
						dataType: "json",
						data: {
							'id': id
						},
						success: function(result) {
							if (result.status == '1') {
								swal({
									title: "Sukses",
									text: "SO berhasil dibatalkan.",
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
