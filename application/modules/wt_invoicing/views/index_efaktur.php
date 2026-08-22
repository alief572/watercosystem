<?php
$ENABLE_ADD     = has_permission('Invoicing.Add');
$ENABLE_MANAGE  = has_permission('Invoicing.Manage');
$ENABLE_VIEW    = has_permission('Invoicing.View');
$ENABLE_DELETE  = has_permission('Invoicing.Delete');
?>
<link rel="stylesheet" href="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/plugins/sweetalert/sweetalert.css') ?>">

<style type="text/css">
	.table-efaktur th {
		text-align: center;
		vertical-align: middle !important;
	}
	.btn-action-group {
		margin-bottom: 15px;
	}
</style>

<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title"><i class="fa fa-file-excel-o"></i> Ekspor Faktur Pajak Siap Lapor (DJP CoreTax)</h3>
		<div class="box-tools pull-right">
			<a href="<?= base_url('wt_invoicing/e_faktur_list') ?>" class="btn btn-sm btn-info">
				<i class="fa fa-history"></i> Riwayat Batch Ekspor
			</a>
			<a href="<?= base_url('wt_invoicing') ?>" class="btn btn-sm btn-default">
				<i class="fa fa-arrow-left"></i> Kembali ke Invoice
			</a>
		</div>
	</div>

	<div class="box-body">
		<div class="row btn-action-group">
			<div class="col-md-12">
				<button type="button" class="btn btn-success btn-sm" id="btn-generate-efaktur">
					<i class="fa fa-file-excel-o"></i> Generate &amp; Download CoreTax Excel
				</button>
				<button type="button" class="btn btn-default btn-sm" id="btn-check-all">
					<i class="fa fa-check-square-o"></i> Pilih Semua (Semua Halaman)
				</button>
				<button type="button" class="btn btn-default btn-sm" id="btn-uncheck-all">
					<i class="fa fa-square-o"></i> Batalkan Pilihan
				</button>
				<span class="text-muted" style="margin-left: 10px;" id="selected-counter">0 faktur terpilih</span>
			</div>
		</div>

		<div class="table-responsive">
			<table id="table_efaktur" class="table table-bordered table-striped table-hover table-efaktur" width="100%">
				<thead>
					<tr class="bg-blue">
						<th width="4%"><input type="checkbox" id="check_page_all"></th>
						<th width="4%">No</th>
						<th width="15%">No. Invoice</th>
						<th width="10%">Tanggal Invoice</th>
						<th width="20%">Nama Customer</th>
						<th width="15%">NPWP Customer</th>
						<th width="11%">DPP (Rp)</th>
						<th width="10%">PPN 12% (Rp)</th>
						<th width="11%">Total Tagihan (Rp)</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
	</div>
</div>

<!-- DataTables & SweetAlert -->
<script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/sweetalert/sweetalert.min.js') ?>"></script>

<script type="text/javascript">
	var selectedInvoices = [];

	function updateCounter() {
		$('#selected-counter').text(selectedInvoices.length + ' faktur terpilih');
	}

	$(document).ready(function() {
		var table = $('#table_efaktur').DataTable({
			processing: true,
			serverSide: true,
			ajax: {
				url: siteurl + 'wt_invoicing/get_efaktur',
				type: 'POST'
			},
			columns: [
				{ data: 'checkbox', orderable: false, className: 'text-center' },
				{ data: 'no', orderable: false, className: 'text-center' },
				{ data: 'no_invoice' },
				{ data: 'tgl_invoice', className: 'text-center' },
				{ data: 'nama_customer' },
				{ data: 'npwp', className: 'text-center' },
				{ data: 'dpp', className: 'text-right' },
				{ data: 'nilai_ppn', className: 'text-right' },
				{ data: 'grand_total', className: 'text-right' }
			],
			order: [[3, 'desc']],
			drawCallback: function(settings) {
				// Re-check checkboxes according to selectedInvoices
				$('.set_choose_invoice').each(function() {
					var val = $(this).val();
					if (selectedInvoices.indexOf(val) !== -1) {
						$(this).prop('checked', true);
					}
				});
			}
		});

		// Checkbox select per baris
		$(document).on('change', '.set_choose_invoice', function() {
			var val = $(this).val();
			if ($(this).is(':checked')) {
				if (selectedInvoices.indexOf(val) === -1) {
					selectedInvoices.push(val);
				}
			} else {
				var index = selectedInvoices.indexOf(val);
				if (index !== -1) {
					selectedInvoices.splice(index, 1);
				}
			}
			updateCounter();
		});

		// Checkbox Header per halaman
		$('#check_page_all').on('change', function() {
			var isChecked = $(this).is(':checked');
			$('.set_choose_invoice').each(function() {
				$(this).prop('checked', isChecked);
				var val = $(this).val();
				if (isChecked) {
					if (selectedInvoices.indexOf(val) === -1) {
						selectedInvoices.push(val);
					}
				} else {
					var index = selectedInvoices.indexOf(val);
					if (index !== -1) {
						selectedInvoices.splice(index, 1);
					}
				}
			});
			updateCounter();
		});

		// Tombol Pilih Semua (Semua Halaman)
		$('#btn-check-all').on('click', function() {
			var searchVal = table.search();
			$.ajax({
				url: siteurl + 'wt_invoicing/get_all_efaktur_id',
				type: 'POST',
				data: { search: searchVal },
				dataType: 'json',
				success: function(data) {
					selectedInvoices = data;
					$('.set_choose_invoice').prop('checked', true);
					$('#check_page_all').prop('checked', true);
					updateCounter();
					swal('Sukses', selectedInvoices.length + ' faktur berhasil dipilih.', 'success');
				},
				error: function() {
					swal('Error', 'Gagal memuat data faktur.', 'error');
				}
			});
		});

		// Tombol Batalkan Pilihan
		$('#btn-uncheck-all').on('click', function() {
			selectedInvoices = [];
			$('.set_choose_invoice').prop('checked', false);
			$('#check_page_all').prop('checked', false);
			updateCounter();
		});

		// Tombol Generate & Download CoreTax Excel
		$('#btn-generate-efaktur').on('click', function() {
			if (selectedInvoices.length === 0) {
				swal('Peringatan', 'Silakan pilih minimal satu faktur untuk diekspor.', 'warning');
				return;
			}

			// Cek apakah ada yang NPWP kosong
			var hasInvalidNpwp = false;
			$('.set_choose_invoice:checked').each(function() {
				if ($(this).data('npwp') === 'invalid') {
					hasInvalidNpwp = true;
				}
			});

			var confirmText = 'Apakah Anda yakin ingin mengekspor ' + selectedInvoices.length + ' faktur terpilih ke format DJP CoreTax?';
			if (hasInvalidNpwp) {
				confirmText = 'Terdapat faktur dengan NPWP KOSONG (akan menggunakan default 0000000000000000). Tetap lanjutkan ekspor?';
			}

			swal({
				title: 'Konfirmasi Ekspor CoreTax',
				text: confirmText,
				type: 'info',
				showCancelButton: true,
				confirmButtonClass: 'btn-success',
				confirmButtonText: 'Ya, Ekspor!',
				cancelButtonText: 'Batal',
				closeOnConfirm: false,
				showLoaderOnConfirm: true
			}, function(isConfirm) {
				if (isConfirm) {
					$.ajax({
						url: siteurl + 'wt_invoicing/generate_efaktur',
						type: 'POST',
						data: { id_generate: selectedInvoices },
						dataType: 'json',
						success: function(response) {
							if (response.status === 'success') {
								swal({
									title: 'Berhasil!',
									text: response.pesan,
									type: 'success'
								}, function() {
									// Trigger download file Excel
									window.location.href = siteurl + 'wt_invoicing/export_coretax_excel';
									selectedInvoices = [];
									updateCounter();
									table.ajax.reload();
								});
							} else {
								swal('Gagal', response.pesan, 'error');
							}
						},
						error: function() {
							swal('Error', 'Terjadi kesalahan pada server saat memproses batch.', 'error');
						}
					});
				}
			});
		});
	});
</script>
