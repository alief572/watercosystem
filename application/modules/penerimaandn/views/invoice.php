 <div class="box box-primary">
    <div class="box-body">
		<div class="form-group row" >
			 <table class="table table-bordered" width="100%" id="tbl_dn_modal">
              <thead>
                  <tr>
				      <th width="30%">Code</th>
                      <th width="30%">No DN</th>
                      <th width="30%">Nama Customer</th>
                      <th width="30%">Total DN</th>
					   <th width="30%">Sisa DN</th>
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
		var tbl = $('#tbl_dn_modal').DataTable({
			processing: true,
			serverSide: true,
			autoWidth: false,
			order: [],
			ajax: {
				url: siteurl + 'penerimaandn/get_data_dn_modal',
				type: 'POST',
				data: function(d) {
					d.id_customer = idCustomer;
				}
			},
			columns: [
				{ data: 'code' }, { data: 'no_dn' }, { data: 'customer' }, { data: 'total' }, { data: 'sisa' }, { data: 'aksi' }
			],
			columnDefs: [{ orderable: false, targets: [5] }]
		});

		// Tombol dibuat ulang tiap halaman/search, jadi tandai DN yang sudah dipilih setelah setiap draw.
		tbl.on('draw.dt', function() {
			if (typeof markTerpilih === 'function') markTerpilih();
		});

		$('#tbl_dn_modal').off('click.pilihinv').on('click.pilihinv', '.btn-pilih-inv', function() {
			var b = $(this);
			// attr() bukan data(): data() mengubah "300000" jadi angka dan numx() butuh teks.
			startmutasi(b.attr('data-id'), b.attr('data-surat'), b.attr('data-nm'), b.attr('data-total'), b.attr('data-sisa'));
		});
	})();
</script>
