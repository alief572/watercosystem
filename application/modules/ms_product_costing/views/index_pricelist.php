<?php
$ENABLE_ADD     = has_permission('Formula.Add');
$ENABLE_MANAGE  = has_permission('Formula.Manage');
$ENABLE_VIEW    = has_permission('Formula.View');
$ENABLE_DELETE  = has_permission('Formula.Delete');
?>
<style type="text/css">
	thead input {
		width: 100%;
	}
</style>
<div id='alert_edit' class="alert alert-success alert-dismissable" style="padding: 15px; display: none;"></div>
<link rel="stylesheet" href="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.css') ?>">
<div class="box">
	<div class="box-header">
		<?php if ($ENABLE_ADD) : ?>
			<a class="btn btn-success btn-sm" href="<?= base_url('/ms_product_costing/AddPricelist/') ?>" title="Add New"><i class="fa fa-plus">&nbsp;</i>Add</i></a>
			<button type="button" class="btn btn-sm btn-primary" onclick="ExportExcel();"><i class="fa fa-download"></i> Download Excel</button>
		<?php endif; ?>

		<span class="pull-right">
		</span>
	</div>
	<!-- /.box-header -->
	<!-- /.box-header -->
	<div class="box-body">
		<table id="tbl_calculation" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th width="5">#</th>
					<th>Purpose Produk (LV I)</th>
					<th>Produk Type (LV II)</th>
					<th>Usage (LV III)</th>
					<th>Deskripsi Produk (LV III)</th>
					<th>Kode Produk</th>
					<th>Nama Formula</th>
					<th>Harga Beli</th>
					<th>Kurs</th>
					<th>Pricelist <br>USD</th>
					<th>Pricelist<br>IDR</th>
					<?php if ($ENABLE_MANAGE) : ?>
						<th width="13%">Action</th>
					<?php endif; ?>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>

	<table id="example2" style="display: none;">
		<thead>
			<tr>
				<th width="5">#</th>
				<th>Purpose Produk (LV I)</th>
				<th>Produk Type (LV II)</th>
				<th>Usage (LV III)</th>
				<th>Deskripsi Produk (LV III)</th>
				<th>Kode Produk</th>
				<th>Nama Formula</th>
				<th>Harga Beli</th>
				<th>Kurs</th>
				<th>Pricelist <br>USD</th>
				<th>Pricelist<br>IDR</th>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
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
					<span class="glyphicon glyphicon-remove"></span> Close</button>
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
					<span class="glyphicon glyphicon-remove"></span> Close</button>
			</div>
		</div>
	</div>
</div>

<!-- DataTables -->
<script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.min.js') ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/table2excel@1.0.4/dist/table2excel.min.js"></script>

<!-- page script -->
<script type="text/javascript">
	$(document).on('click', '.edit', function(e) {
		var id = $(this).data('id');
		$("#head_title").html("<i class='fa fa-list-alt'></i><b>Edit Diskon</b>");
		$.ajax({
			type: 'POST',
			url: siteurl + 'ms_diskon/editDiskon/' + id,
			success: function(data) {
				$("#dialog-popup").modal();
				$("#ModalView").html(data);

			}
		})
	});



	// DELETE DATA
	$(document).on('click', '.delete', function(e) {
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
			function() {
				$.ajax({
					type: 'POST',
					url: siteurl + 'ms_product_costing/deletePricelist',
					dataType: "json",
					data: {
						'id': id
					},
					success: function(result) {
						if (result.status == '1') {
							swal({
									title: "Sukses",
									text: "Data berhasil dihapus.",
									type: "success"
								},
								function() {
									window.location.reload(true);
								})
						} else {
							swal({
								title: "Error",
								text: "Data error. Gagal hapus data",
								type: "error"
							})

						}
					},
					error: function() {
						swal({
							title: "Error",
							text: "Data error. Gagal request Ajax",
							type: "error"
						})
					}
				})
			});

	})

	$(function() {
		$("#tbl_calculation").DataTable({
			processing: true,
			serverSide: true,
			ajax: {
				url: siteurl + 'ms_product_costing/get_data_calculation_json',
				type: 'POST'
			},
			columnDefs: [{
				orderable: false,
				targets: [0<?= $ENABLE_MANAGE ? ', 11' : '' ?>]
			}]
		});
		$("#form-area").hide();
	});


	//Delete

	function PreviewPdf(id) {
		param = id;
		tujuan = 'customer/print_request/' + param;

		$(".modal-body").html('<iframe src="' + tujuan + '" frameborder="no" width="570" height="400"></iframe>');
	}

	function PreviewRekap() {
		tujuan = 'customer/rekap_pdf';
		$(".modal-body").html('<iframe src="' + tujuan + '" frameborder="no" width="100%" height="400"></iframe>');
	}

	function ExportExcel() {
		const table = document.getElementById('example2');

		if (!table) {
			alert('Table tidak ditemukan!');
			return;
		}

		if (typeof Table2Excel === 'undefined') {
			alert('Library Table2Excel tidak terload!');
			return;
		}

		// Tabel utama serverside hanya punya satu halaman, jadi ambil semua baris dari server.
		$.ajax({
			type: 'POST',
			url: siteurl + 'ms_product_costing/get_data_calculation_export',
			dataType: 'json',
			success: function(res) {
				var html = '';
				$.each(res.data, function(i, row) {
					html += '<tr><td>' + row.join('</td><td>') + '</td></tr>';
				});
				$(table).find('tbody').html(html);
				try {
					new Table2Excel().export(table, 'Pricelist_Data.xlsx');
				} catch (error) {
					console.error('Error:', error);
					alert('Error export: ' + error.message);
				}
			},
			error: function() {
				alert('Gagal mengambil data untuk export.');
			}
		});
	}
</script>
