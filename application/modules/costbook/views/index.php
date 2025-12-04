<?php
$ENABLE_ADD     = has_permission('Costbooks.Add');
$ENABLE_MANAGE  = has_permission('Costbooks.Manage');
$ENABLE_VIEW    = has_permission('Costbooks.View');
$ENABLE_DELETE  = has_permission('Costbooks.Delete');
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
		<?php if ($ENABLE_VIEW) : ?>
			<a class="btn btn-primary btn-sm add" href="javascript:void(0)" title="Add"><i class="fa fa-plus">&nbsp;</i>Add Material Costbook</a>
		<?php endif; ?>

		<?php if ($ENABLE_MANAGE) : ?>
			<a class="btn btn-sm btn-success" href="<?= base_url('costbook/download_excel') ?>" target="_blank" title="Download Excel"><i class="fa fa-download"></i> Download Excel</a>

			<button type="button" class="btn btn-sm btn-danger" onclick="check_costbook();"><i class="fa fa-cogs"></i> Check</button>
		<?php endif; ?>

		<span class="pull-right">
	</div>
	<!-- /.box-header -->
	<div class="box-body">
		<table id="example3" width="100%" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>#</th>
					<th>Id Produk</th>
					<th>Nama Produk</th>
					<th>Kode Barang</th>
					<th>Harga HPP</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>

			</tbody>
		</table>
	</div>
	<!-- /.box-body -->
</div>

<!-- awal untuk modal dialog -->
<!-- Modal -->
</span>
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
			<form action="" id="form_datas" enctype="multipart/form-data">
				<div class="modal-body" id="ModalView">
					...
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">
						<span class="glyphicon glyphicon-remove"></span> Close</button>
					<button type="submit" class="btn btn-primary">
						<i class="fa fa-save"></i> Proses
					</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- DataTables -->
<script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.min.js') ?>"></script>

<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>


<!-- page script -->
<script type="text/javascript">
	$(document).ready(function() {
		datatables();
	});

	$(document).on('click', '.edit', function(e) {
		var id = $(this).data('id_inventory1');
		$("#head_title").html("<i class='fa fa-list-alt'></i><b>Edit Costbook</b>");
		$.ajax({
			type: 'POST',
			url: siteurl + 'costbook/editCostbook/' + id,
			success: function(data) {
				$("#dialog-popup").modal();
				$("#ModalView").html(data);

			}
		})
	});

	$(document).on('click', '.view', function() {
		var id = $(this).data('id_inventory1');
		// alert(id);
		$("#head_title").html("<i class='fa fa-list-alt'></i><b>Detail Inventory</b>");
		$.ajax({
			type: 'POST',
			url: siteurl + 'inventory_1/viewInventory/' + id,
			data: {
				'id': id
			},
			success: function(data) {
				$("#dialog-popup").modal();
				$("#ModalView").html(data);



			}
		})
	});
	$(document).on('click', '.add', function() {
		$("#head_title").html("<i class='fa fa-list-alt'></i><b>Tambah Material Costbook</b>");
		$.ajax({
			type: 'POST',
			url: siteurl + 'costbook/addCostbook',
			success: function(data) {

				$("#dialog-popup").modal();
				$("#ModalView").html(data);


			}
		})
	});


	// DELETE DATA
	$(document).on('click', '.delete', function(e) {
		e.preventDefault()
		var id = $(this).data('id_inventory1');
		// alert(id);
		swal({
				title: "Anda Yakin?",
				text: "Data Inventory akan di hapus.",
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
					url: siteurl + 'inventory_1/deleteInventory',
					dataType: "json",
					data: {
						'id': id
					},
					success: function(result) {
						if (result.status == '1') {
							swal({
									title: "Sukses",
									text: "Data Inventory berhasil dihapus.",
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

	$(document).on('submit', '#form_datas', function(e) {
		e.preventDefault();

		if ($('.checklist:checked').length === 0) {
			swal({
				type: 'warning',
				title: 'Warning !',
				text: 'Mohon check list salah satu barang yang mau di proses !',
				showConfirmButton: false,
				showCancelButton: false,
				allowEscapeKey: false,
				allowOutsideClick: false,
				timer: 3000
			}, function() {
				return false;
			});
		}

		swal({
			type: 'warning',
			title: 'Anda yakin ?',
			text: 'Data yang anda pilih akan terupdate costbook nya sesuai report mutasi stock !',
			showConfirmButton: true,
			showCancelButton: true,
			allowEscapeKey: false,
			allowOutsideClick: false
		}, function(next) {
			if (next) {
				var formdata = new FormData($('#form_datas')[0]);

				$.ajax({
					type: 'post',
					url: siteurl + active_controller + 'save_check_costbook',
					data: formdata,
					cache: false,
					dataType: 'json',
					contentType: false,
					processData: false,
					success: function(result) {
						if (result.status == 1) {
							swal({
								type: 'success',
								title: 'Success !',
								text: result.msg,
								showConfirmButton: false,
								showCancelButton: false,
								allowEscapeKey: false,
								allowOutsideClick: false,
								timer: 3000
							}, function() {
								swal.close();
								$('#dialog-popup').modal('hide');
								datatables();
							});
						} else {
							swal({
								type: 'warning',
								title: 'Failed !',
								text: result.msg,
								showConfirmButton: false,
								showCancelButton: false,
								allowEscapeKey: false,
								allowOutsideClick: false,
								timer: 3000
							});
						}
					},
					error: function(result) {
						swal({
							type: 'error',
							title: 'Error !',
							text: 'Please try again !',
							showConfirmButton: false,
							showCancelButton: false,
							allowEscapeKey: false,
							allowOutsideClick: false,
							timer: 3000
						});
					}
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

		// var table = $('#example1').DataTable( {
		// orderCellsTop: true,
		// fixedHeader: true
		// } );
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

	function datatables() {
		var datatables = $('#example3').dataTable({
			serverSide: true,
			processing: true,
			destroy: true,
			paging: true,
			stateSave: true,
			ajax: {
				type: 'post',
				url: siteurl + active_controller + 'get_costbooks',
				cache: false,
				dataType: 'json'
			},
			columns: [{
					data: 'no'
				},
				{
					data: 'id_product'
				},
				{
					data: 'nm_product'
				},
				{
					data: 'kode_barang'
				},
				{
					data: 'harga_hpp'
				},
				{
					data: 'action'
				}
			]
		});
	}

	function check_costbook() {
		$.ajax({
			type: 'post',
			url: siteurl + active_controller + 'check_costbook',
			cache: false,
			success: function(result) {
				$('.modal-title').html('<i class="fa fa-cogs"></i> Check Costbooks');
				$('.modal-body').html(result);

				$('#dialog-popup').modal('show');
			},
			error: function(result) {
				swal({
					type: 'error',
					title: 'Error !',
					text: 'Please try again later !',
					showConfirmButton: false,
					showCancelButton: false,
					allowOutsideClick: false,
					allowEscapeKey: false,
					timer: 3000
				});
			}
		});
	}
</script>