<?php
    $ENABLE_MANAGE  = has_permission('Warehouse_material.Manage');
	
?>
<style type="text/css">
thead input {
	width: 100%;
}
</style>
<div id='alert_edit' class="alert alert-success alert-dismissable" style="padding: 15px; display: none;"></div>
<link rel="stylesheet" href="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.css')?>">

<div class="box">
	<!-- /.box-header -->
	<div class="box-header"><b>Filter Produk : </b>
      <select id="idcustomer" name="idcustomer" class="form-control input-sm select" style="width: 25%;" tabindex="-1" required onchange="getcustomer()">
          <option value=""></option>
          <?php
            $cus='';
            foreach(@$customer as $kc=>$vc){
              $selected = '';
              if($this->uri->segment(3) == $vc->id_category3){
                   $selected = 'selected="selected"';
                   $cus = $vc->nama;
              }
              ?>
          <option value="<?php echo html_escape($vc->id_category3); ?>" <?php echo $selected?>>
            <?php echo html_escape($vc->id_category3.' , '.$vc->nama.' | '.$vc->kode_barang) ?>
          </option>
          <?php } ?>
      </select>
    </div>
	<div class="box-body">
		<table id="tbl_kartu_stok_edit" class="table table-bordered table-striped">
		<thead>
		
					
				
		  <tr align='center'>
			<th width="5%" rowspan='2'>#</th>
            <th width="10%" rowspan='2'>Tgl Transaksi</th>
			<th width="10%" rowspan='2'>No.Transaksi</th>
			<th rowspan='2' width="10%">Jenis Transaksi</th>
			<th rowspan='2' width="10%">Id Produk</th>
            <th rowspan='2' width="10%">Produk</th>
          	<th width='50' align="center" colspan='3'>AWAL</th>
            <th width='50' align="center" colspan='2'>TRANSAKSI</th>
            <th width='50' align="center" colspan='3'>AKHIR</th>
			<th rowspan='2'>Action</th>
            
          </tr>
			
		   <tr align='center'>
			<th width='50'>Stock</th>
			<th width='50'>Booking</th>
			<th width='50'>Free Stock</th>
			<th width='50'>In/Out</th>
			<th width='50'>Booking</th>
			<th width='50'>Stock</th>
			<th width='50'>Booking</th>
			<th width='50'>Free Stock</th>
			
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
        <h4 class="modal-title" id="myModalLabel"><span class="fa fa-users"></span>&nbsp;Edit Kartu Stok</h4>
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


<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>

<!-- page script -->
<script type="text/javascript">
	var tblKartu;

	$(document).ready(function() {
		$("#idcustomer").select2({
			placeholder: "Pilih",
			allowClear: true
		});

		// Baris dimuat serverside per halaman; filter produk dikirim sebagai d.produk.
		tblKartu = $('#tbl_kartu_stok_edit').DataTable({
			processing: true,
			serverSide: true,
			autoWidth: false,
			searchDelay: 350,
			scrollX: true,
			order: [],
			ordering: false,
			dom: 'Blfrtip',
			buttons: [{
				extend: 'excel',
			}],
			ajax: {
				url: siteurl + 'stock_material/get_data_kartu_stock',
				type: 'POST',
				data: function(d) {
					d.produk = $('#idcustomer').val();
				}
			},
			columns: [
				{ data: 'no' }, { data: 'tgl_transaksi' }, { data: 'no_transaksi' }, { data: 'jenis_transaksi' },
				{ data: 'id_produk' }, { data: 'produk' },
				{ data: 'awal_stock' }, { data: 'awal_booking' }, { data: 'awal_free_stock' },
				{ data: 'transaksi_in_out' }, { data: 'transaksi_booking' },
				{ data: 'akhir_stock' }, { data: 'akhir_booking' }, { data: 'akhir_free_stock' },
				{
					data: 'id_kartu_stok',
					orderable: false,
					render: function(id) {
						<?php if ($ENABLE_MANAGE) : ?>
						return '<a class="btn btn-warning btn-sm edit" href="javascript:void(0)" title="Edit" data-id_inventory3="' + parseInt(id, 10) + '"><i class="fa fa-edit"></i></a>';
						<?php else : ?>
						return '';
						<?php endif; ?>
					}
				}
			]
		});
	});

	// Ganti produk: muat ulang tabel tanpa pindah halaman.
	function getcustomer() {
		tblKartu.ajax.reload();
	}

	$(document).on('click', '.edit', function(e) {
		var id = $(this).data('id_inventory3');
		$("#head_title").html("<i class='fa fa-list-alt'></i><b>Edit Inventory</b>");
		$.ajax({
			type: 'POST',
			url: siteurl + 'stock_material/editKartustok/' + id,
			success: function(data) {
				$("#dialog-popup").modal();
				$("#ModalView").html(data);
			}
		});
	});
</script>
