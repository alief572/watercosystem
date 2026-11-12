<div class="box box-primary">
	<div class="box-body">
		<div class="form-group row">
			<table class="table table-bordered" width="100%" id="tbl_invoice_np_modal">
				<thead>
					<tr>
						<th width="30%">Code</th>
						<th width="30%">No Invoice</th>
						<th width="30%">Nama Customer</th>
						<th width="30%">Total Invoice</th>
						<th width="30%">Sisa Invoice</th>
						<th width="2%" class="text-center">Aksi</th>
					</tr>
				</thead>
				<tbody></tbody>
			</table>
		</div>
	</div>
</div>

<script>
	(function() {
		var idCustomer = <?= json_encode((string) $results['detail']) ?>;
		var tbl = $('#tbl_invoice_np_modal').DataTable({
			processing: true,
			serverSide: true,
			autoWidth: false,
			order: [],
			ajax: {
				url: siteurl + 'penerimaan/get_data_invoice_np_modal',
				type: 'POST',
				data: function(d) {
					d.id_customer = idCustomer;
				}
			},
			columns: [{
					data: 'code'
				},
				{
					data: 'no_invoice'
				},
				{
					data: 'customer'
				},
				{
					data: 'total'
				},
				{
					data: 'sisa'
				},
				{
					data: 'aksi'
				}
			],
			columnDefs: [{
				orderable: false,
				targets: [5]
			}]
		});

		// Tombol dibuat ulang tiap halaman/search, jadi tandai invoice yang sudah dipilih setelah setiap draw.
		tbl.on('draw.dt', function() {
			markTerpilih();
		});

		$('#tbl_invoice_np_modal').off('click.pilihinv').on('click.pilihinv', '.btn-pilih-inv', function() {
			var b = $(this);
			// attr() bukan data(): data() mengubah "44000.00" jadi angka dan numx() butuh titik desimal.
			startmutasi(b.attr('data-id'), b.attr('data-surat'), b.attr('data-nm'), b.attr('data-total'), b.attr('data-sisa'));
		});
	})();
</script>
