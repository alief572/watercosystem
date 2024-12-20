<?php
    $ENABLE_ADD = has_permission('Barang.Add');
    $ENABLE_MANAGE = has_permission('Barang.Manage');
    $ENABLE_VIEW = has_permission('Barang.View');
    $ENABLE_DELETE = has_permission('Barang.Delete');
?>
<style type="text/css">
thead input {
	width: 100%;
}
</style>
<link rel="stylesheet" href="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.css'); ?>">
<form action="#" method="POST" id="form_proses_bro" enctype="multipart/form-data">   
	<div class="box"> 
		<div class="box-header">
			<div class="box-tool pull-right">
				
				
					<button type='button' id='add' class="btn btn-success" title="Tambah Asset"><i class="fa fa-plus">&nbsp;</i>Tambah Asset</button>
					<!--<button type='button' id='jurnal' class="btn btn-primary" title="Buat Jurnal"><i class="fa fa-plus">&nbsp;</i>Buat Jurnal</button>-->
			
			</div>
			<div class="box-tool pull-left"> 
				
				<label>Pencarian : </label>
				<!--<select id='kdcab' name='kdcab' class='form-control input-sm chosen-container' style='min-width:150px; float:left; margin-bottom: 5px;'>
					<option value='0'>Semua Cabang</option>
					<?php
						foreach($cabang AS $val => $valx){
							echo "<option value='".$valx['kdcab']."'>".strtoupper($valx['namacabang'])."</option>";
						}
					?>
				</select>-->
				<select id='kategory' name='kategory' class='form-control input-sm chosen-select' style='min-width:150px; float:left; margin-bottom: 5px;'>
					<option value='0'>Semua Kategori</option>
					<?php
						foreach($kategori AS $val => $valx){
							echo "<option value='".$valx['id']."'>".strtoupper($valx['nm_category'])."</option>";
						}
					?>
				</select>
				<?php
					echo form_input(array('type'=>'hidden','id'=>'tanggalx','name'=>'tanggalx','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Tanggal', 'readonly'=>'readonly'));											
				?>
				
			</div>
		</div>
		<!-- /.box-header -->
		<div class="box-body">
			<table id="example1" class="table table-bordered table-striped" width='100%'>
				<thead>
					<tr class='bg-blue' >
						<th class="text-center">No</th>
						<th class="text-center" width='140px'>Kode Asset</th>
						<th class="text-center">Nama Asset</th>
						<th class="text-center">Category</th>
						<th class="text-center">Tgl Perolehan</th>
						<th class="text-center">Depresiasi</th>
						<th class="text-center">Nilai&nbsp;Perolehan</th>
						<th class="text-center">Penyusutan</th>
						<th class="text-center">Nilai&nbsp;Asset</th>
						<th class="text-center" class='no-sort'>#</th>
					</tr>
				</thead>
				<tbody></tbody>
				 <tfoot>
					<tr>
						<th colspan="6" style="text-align:center">TOTAL KESELURUHAN</th>
						<th></th>
						<th></th>
						<th></th>
						<th></th> 
					</tr>
				</tfoot>
			</table>
		</div>
		<!-- /.box-body -->
	</div>

 <!-- modal -->
	<div class="modal fade" id="ModalView">
		<div class="modal-dialog"  style='width:80%; '>
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="head_title"></h4>
					</div>
					<div class="modal-body" id="view">
					</div>
					<div class="modal-footer">
					<!--<button type="button" class="btn btn-primary">Save</button>-->
					<button type="button" class="btn btn-default " data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<!-- modal -->
	
	<!-- modal alert -->
	<div class="modal fade" id="myModal" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content" style='margin-top: 150px;'>
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><b>Pemberitahuan</b></h4>
				</div>
				<div class="modal-body">
					<p id="error"></p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<!-- modal alert -->
	  
</form>
<!-- DataTables -->

<style> 
	.chosen-container{
		width: 100% !important;
		text-align : left !important;
	}

</style>

<script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.min.js'); ?>"></script>
<script src="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.min.js');?>"></script>
<script src="<?= base_url('assets/js/jquery.maskMoney.js')?>"></script>
<script src="<?= base_url('assets/js/autoNumeric.js')?>"></script>

<!-- page script -->
<script type="text/javascript">
	$(document).ready(function(){
		var kdcab 		= $('#kdcab').val();
		var tgl 		= $('#tanggalx').val();
		var kategori 	= $('#kategory').val();
		DataTables(kdcab, tgl, kategori);
		$('.chosen-select').select2();
	});
	
	$(document).on('change','#kdcab', function(e){
		e.preventDefault();
		var kdcab 	= $('#kdcab').val();
		var tgl 	= $('#tanggalx').val();
		var kategori 	= $('#kategory').val();
		DataTables(kdcab, tgl, kategori);
	});
	
	$(document).on('change','#tanggalx', function(e){
		e.preventDefault();
		var kdcab 	= $('#kdcab').val();
		var tgl 	= $('#tanggalx').val();
		var kategori 	= $('#kategory').val();
		DataTables(kdcab, tgl, kategori);
		// alert($(this).val());
	});
	
	$(document).on('change','#kategory', function(e){
		e.preventDefault();
		var kdcab 		= $('#kdcab').val();
		var tgl 		= $('#tanggalx').val();
		var kategori 	= $('#kategory').val();
		DataTables(kdcab, tgl, kategori);
		// alert($(this).val());
	});
	
	$("#tanggalx").datepicker( {
		format: 'mm-yyyy',
		// dateFormat: 'dd, mm, yy',
		viewMode: "months",
		minViewMode: "months",
		autoClose: true
		// defaultDate: new Date()
	});
	
	$(document).on('click', '#add', function(e){
		e.preventDefault();
		$("#head_title").html("<b>TAMBAHKAN ASET BARU</b>");
		$("#view").load(siteurl +'asset/modal');
		$("#ModalView").modal();
	});
	
	$(document).on('click', '#jurnal', function(e){
		e.preventDefault();
		$("#head_title").html("<b>TAMBAHKAN JURNAL BARU</b>");
		$("#view").load(siteurl +'asset/modal_jurnal');
		$("#ModalView").modal();
	});
	
	$(document).on('click', '.edit', function(e){
		e.preventDefault();
		$("#head_title").html("<b>EDIT ASET</b>");
		$("#view").load(siteurl +'asset/modal/'+$(this).data('id'));
		$("#ModalView").modal();
	});
	
	$(document).on('click', '#detail', function(e){
		e.preventDefault();
		$("#head_title").html("<b>DETAIL ASET</b>");
		$("#view").load(siteurl +'asset/modal_view/'+$(this).data('id'));
		$("#ModalView").modal();
	});
	
	function DataTables(kdcab = null, tgl = null, kategori = null){
		let total_aset	= 0;
		let total_susut	= 0;
		let total_sisa	= 0;
		var dataTable = $('#example1').DataTable({
			"serverSide": true,
			"stateSave" : true,
			"bAutoWidth": true,
			"destroy"	: true,
			"responsive": true,
			"oLanguage": {
				"sSearch": "<b>Live Search : </b>",
				"sLengthMenu": "_MENU_ &nbsp;&nbsp;<b>Records Per Page</b>&nbsp;&nbsp;",
				"sInfo": "Showing _START_ to _END_ of _TOTAL_ entries",
				"sInfoFiltered": "(filtered from _MAX_ total entries)",
				"sZeroRecords": "No matching records found",
				"sEmptyTable": "No data available in table",
				"sLoadingRecords": "Please wait - loading...",
				"oPaginate": {
					"sPrevious": "Prev",
					"sNext": "Next"
				}
			},
			"aaSorting"		: [[ 1, "asc" ]],
			"columnDefs"	: [ {
				"targets"	: 'no-sort',
				"orderable"	: false,
				},
				{ className: 'text-right', targets: [6, 7, 8] }
			],
			"sPaginationType": "simple_numbers",
			"iDisplayLength": 10,
			"aLengthMenu": [[10, 20, 50, 100, 150], [10, 20, 50, 100, 150]],
			"ajax":{
				url : siteurl +'asset/data_side', 
				type: "post",
				data: function(d){
					d.kdcab = kdcab,
					d.tgl = tgl,
					d.kategori = kategori
				},
				cache: false,
				error: function(){
					$(".my-grid-error").html("");
					$("#my-grid").append('<tbody class="my-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
					$("#my-grid_processing").css("display","none");
				},
				 dataSrc: function ( data ) {
				   total_aset = data.recordsAset;
				   total_susut = data.recordsSusut;
				   total_sisa = data.recordsSisa;
				   return data.data;
				 } 
			},
			/*
			"footerCallback": function ( row, data, start, end, display ) {
				var api = this.api(), data;  

				var intVal = function ( i ) {
					
					return typeof i === 'string' ?
						i.replace(/[\$,]/g, '')*1 :
						typeof i === 'number' ?
							i : 0;
				};
				console.log(data);  
				var perolehan = api
					.column(5)
					// .cells( null, this.index())
					.data()
					.reduce( function (a, b) { return intVal(a) + intVal(b); }, 0 );
				
				var susut = api
					.column(6)
					.data()
					.reduce( function (a, b) { return intVal(a) + intVal(b); }, 0 );
				
				var sisa = api
					.column(7)
					.data()
					.reduce( function (a, b) { return intVal(a) + intVal(b); }, 0 );  
				
				$( api.column( 5 ).footer() ).html("<div align='right'>"+ number_format(perolehan) +"</div>");
				$( api.column( 6 ).footer() ).html("<div align='right'>"+ number_format(susut) +"</div>");
				$( api.column( 7 ).footer() ).html("<div align='right'>"+ number_format(sisa) +"</div>");
			}
			*/
			drawCallback: function( settings ) {
				var api = this.api();
	 
				$( api.column( 6 ).footer() ).html("<div align='right'>"+ number_format(total_aset) +"</div>");
				$( api.column( 7 ).footer() ).html("<div align='right'>"+ number_format(total_susut) +"</div>");
				$( api.column( 8 ).footer() ).html("<div align='right'>"+ number_format(total_sisa) +"</div>");
			}
				
			
		});
	}
	
	function number_format (number, decimals, dec_point, thousands_sep) {
		// Strip all characters but numerical ones.
		number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
		var n = !isFinite(+number) ? 0 : +number,
			prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
			sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
			dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
			s = '',
			toFixedFix = function (n, prec) {
				var k = Math.pow(10, prec);
				return '' + Math.round(n * k) / k;
			};
		// Fix for IE parseFloat(0.55).toFixed(0) = 0;
		s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
		if (s[0].length > 3) {
			s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
		}
		if ((s[1] || '').length < prec) {
			s[1] = s[1] || '';
			s[1] += new Array(prec - s[1].length + 1).join('0');
		}
		return s.join(dec);
	}
	
	$(document).on('keyup', '#nilai_asset', function(){
		var nilai_asset = $('#nilai_asset').val();
		var qty_asset 	= $('#qty').val();
		var depresiasi	= parseFloat($('#depresiasi').val());
		var nilai		= parseFloat(nilai_asset.split(',').join(''));
		
		var per_bulan	= (nilai / (depresiasi * 12));
		if(isNaN(per_bulan)){
			var per_bulan = 0;
		}
		$('#value').val(per_bulan.toFixed(0));
	});
	
	$(document).on('change', '#lokasi_asset', function(){
		var nilai_asset = $(this).val();
		var cost_center = $("#cost_center");
		
		$.ajax({
			url: base_url+'index.php/'+active_controller+'/list_center/'+nilai_asset,
			cache: false,
			type: "POST",
			dataType: "json",
			success: function(data){
				$(cost_center).html(data.option).trigger("chosen:updated");
				$('.chosen-select').select2();
				
				swal.close();
			},
			error: function() {
			swal({
			  title				: "Error Message !",
			  text				: 'Connection Time Out. Please try again..',
			  type				: "warning",
			  timer				: 3000,
			  showCancelButton	: false,
			  showConfirmButton	: false,
			  allowOutsideClick	: false
			});
		  }
		});
	});
	
	$(document).on('change', '#lokasi_asset_new', function(){
		var nilai_asset = $(this).val();
		var cost_center = $("#cost_center_new");
		
		$.ajax({
			url: base_url+'index.php/'+active_controller+'/list_center/'+nilai_asset,
			cache: false,
			type: "POST",
			dataType: "json",
			success: function(data){
				$(cost_center).html(data.option).trigger("chosen:updated");
				$('.chosen-select').select2();
				
				swal.close();
			},
			error: function() {
			swal({
			  title				: "Error Message !",
			  text				: 'Connection Time Out. Please try again..',
			  type				: "warning",
			  timer				: 3000,
			  showCancelButton	: false,
			  showConfirmButton	: false,
			  allowOutsideClick	: false
			});
		  }
		});
	});
	
	$(document).on('change', '#category_pajak', function(){
		var category = $(this).val();
		
		$.ajax({
			url: base_url + active_controller+'/get_jangka_waktu/'+category,
			cache: false,
			type: "POST",
			dataType: "json",
			success: function(data){
				$("#depresiasi").val(data.jangka_waktu);
				get_depresiasi();
			},
			error: function() {
			swal({
			  title				: "Error Message !",
			  text				: 'Connection Time Out. Please try again..',
			  type				: "warning",
			  timer				: 3000,
			  showCancelButton	: false,
			  showConfirmButton	: false,
			  allowOutsideClick	: false
			});
		  }
		});
	});
	
	$(document).on('change', '#penyusutan', function(){
		var penyusutan = $(this).val();
		if(penyusutan == 'Y'){
			$('.hide_penyusutan').show();
		}
		if(penyusutan == 'N'){
			$('.hide_penyusutan').hide();
		}
		
	});

	
	$(document).on('click', '#simpan-bro', function(e){
		e.preventDefault();
		$(this).prop('disabled',true);
		var branch			= $('#branch').val();
		var kd_manual		= $('#kd_manual').val();
		var nm_asset		= $('#nm_asset').val();
		var category		= $('#category').val();
		var lokasi_asset	= $('#lokasi_asset').val();
		var cost_center		= $('#cost_center').val();
		var nilai_asset		= $('#nilai_asset').val();
		var qty				= $('#qty').val();
		// var tanggal			= $('#tanggal').val();
		
		if(branch == '' || branch == null){
			swal({
				title	: "Error Message!",
				text	: 'Asset milik masih kosong ...',
				type	: "warning"
			});

			$('#simpan-bro').prop('disabled',false);
			return false;
		}
		if(nm_asset == '' || nm_asset == null){
			swal({
				title	: "Error Message!",
				text	: 'Nama asset masih kosong ...',
				type	: "warning"
			});

			$('#simpan-bro').prop('disabled',false);
			return false;
		}
		if(category == '' || category == null || category == 0){
			swal({
				title	: "Error Message!",
				text	: 'Kategori asset belum dipilih ...',
				type	: "warning"
			});

			$('#simpan-bro').prop('disabled',false);
			return false;
		}
		
		if(lokasi_asset == '' || lokasi_asset == null || lokasi_asset == 0){
			swal({
				title	: "Error Message!",
				text	: 'Lokasi asset belum dipilih ...',
				type	: "warning"
			});

			$('#simpan-bro').prop('disabled',false);
			return false;
		}
		
		if(cost_center == '' || cost_center == null || cost_center == 0){
			swal({
				title	: "Error Message!",
				text	: 'Cost Center belum dipilih ...',
				type	: "warning"
			});

			$('#simpan-bro').prop('disabled',false);
			return false;
		}
		
		if(nilai_asset == '' || nilai_asset == null || nilai_asset == 0){
			swal({
				title	: "Error Message!",
				text	: 'Nilai asset belum dipilih ...',
				type	: "warning"
			});

			$('#simpan-bro').prop('disabled',false);
			return false;
		}
		if(qty == '' || qty == null || qty == 0){
			swal({
				title	: "Error Message!",
				text	: 'Qty asset belum dipilih ...',
				type	: "warning"
			});

			$('#simpan-bro').prop('disabled',false);
			return false;
		}
		// if(tanggal == '' || tanggal == null || tanggal == 0){
			// swal({
				// title	: "Error Message!",
				// text	: 'Tanggal asset belum dipilih ...',
				// type	: "warning"
			// });

			// $('#simpan-bro').prop('disabled',false);
			// return false;
		// }
			// swal({
				// title	: "Error Message!",
				// text	: 'STOP',
				// type	: "warning"
			// });

			// return false;
		
		swal({
			  title: "Are you sure?",
			  text: "You will not be able to process again this data!",
			  type: "warning",
			  showCancelButton: true,
			  confirmButtonClass: "btn-danger",
			  confirmButtonText: "Yes, Process it!",
			  cancelButtonText: "No, cancel process!",
			  closeOnConfirm: false,
			  closeOnCancel: false
			},
			function(isConfirm) {
			  if (isConfirm) {
					// loading_spinner();
					var formData  	= new FormData($('#form_proses_bro')[0]);
					var baseurl		= siteurl +'asset/saved';
					$.ajax({
						url			: baseurl,
						type		: "POST",
						data		: formData,
						cache		: false,
						dataType	: 'json',
						processData	: false, 
						contentType	: false,				
						success		: function(data){								
							if(data.status == 1){											
								swal({
									  title	: "Save Success!",
									  text	: data.pesan,
									  type	: "success",
									  timer	: 7000
									});
								window.location.href = siteurl + 'asset';
							}
							else{ 
								if(data.status == 2){
									swal({
									  title	: "Save Failed!",
									  text	: data.pesan,
									  type	: "warning",
									  timer	: 7000
									});
								}
								else if(data.status == 3){
									swal({
									  title	: "Save Failed!",
									  text	: data.pesan,
									  type	: "warning",
									  timer	: 7000
									});
								}
								else{
									swal({
									  title	: "Save Failed!",
									  text	: data.pesan,
									  type	: "warning",
									  timer	: 7000,
									  showCancelButton	: false,
									  showConfirmButton	: false,
									  allowOutsideClick	: false
									});
								}
								$('#simpan-bro').prop('disabled',false);
							}
						},
						error: function() {
							swal({
							  title				: "Error Message !",
							  text				: 'An Error Occured During Process. Please try again..',						
							  type				: "warning",								  
							  timer				: 7000,
							  showCancelButton	: false,
							  showConfirmButton	: false,
							  allowOutsideClick	: false
							});
							$('#simpan-bro').prop('disabled',false);
						}
					});
			  } else {
				swal("Cancelled", "Data can be process again :)", "error");
				$('#simpan-bro').prop('disabled',false);
				return false;
			  }
		});
	});
		
	//move asesset
	$(document).on('click', '#move_asset', function(e){
		e.preventDefault();
		$(this).prop('disabled',true);
		var branch			= $('#branch').val();
		var lokasi_asset	= $('#lokasi_asset_new').val();
		var cost_center		= $('#cost_center_new').val();
		
		if(branch == '' || branch == null){
			swal({
				title	: "Error Message!",
				text	: 'Asset milik masih kosong ...',
				type	: "warning"
			});

			$('#move_asset').prop('disabled',false);
			return false;
		}
		
		if(lokasi_asset == '' || lokasi_asset == null || lokasi_asset == 0){
			swal({
				title	: "Error Message!",
				text	: 'Department New belum dipilih ...',
				type	: "warning"
			});

			$('#move_asset').prop('disabled',false);
			return false;
		}
		
		if(cost_center == '' || cost_center == null || cost_center == 0){
			swal({
				title	: "Error Message!",
				text	: 'Cost Center New belum dipilih ...',
				type	: "warning"
			});

			$('#move_asset').prop('disabled',false);
			return false;
		}
		
		swal({
			  title: "Are you sure?",
			  text: "You will not be able to process again this data!",
			  type: "warning",
			  showCancelButton: true,
			  confirmButtonClass: "btn-danger",
			  confirmButtonText: "Yes, Process it!",
			  cancelButtonText: "No, cancel process!",
			  closeOnConfirm: false,
			  closeOnCancel: false
			},
			function(isConfirm) {
			  if (isConfirm) {
					// loading_spinner();
					var formData  	= new FormData($('#form_proses_bro')[0]);
					var baseurl		= siteurl +'asset/move_asset';
					$.ajax({
						url			: baseurl,
						type		: "POST",
						data		: formData,
						cache		: false,
						dataType	: 'json',
						processData	: false, 
						contentType	: false,				
						success		: function(data){								
							if(data.status == 1){											
								swal({
									  title	: "Save Success!",
									  text	: data.pesan,
									  type	: "success",
									  timer	: 7000
									});
								window.location.href = siteurl + 'asset';
							}
							else{ 
								if(data.status == 2){
									swal({
									  title	: "Save Failed!",
									  text	: data.pesan,
									  type	: "warning",
									  timer	: 7000
									});
								}
								else if(data.status == 3){
									swal({
									  title	: "Save Failed!",
									  text	: data.pesan,
									  type	: "warning",
									  timer	: 7000
									});
								}
								else{
									swal({
									  title	: "Save Failed!",
									  text	: data.pesan,
									  type	: "warning",
									  timer	: 7000,
									  showCancelButton	: false,
									  showConfirmButton	: false,
									  allowOutsideClick	: false
									});
								}
								$('#move_asset').prop('disabled',false);
							}
						},
						error: function() {
							swal({
							  title				: "Error Message !",
							  text				: 'An Error Occured During Process. Please try again..',						
							  type				: "warning",								  
							  timer				: 7000,
							  showCancelButton	: false,
							  showConfirmButton	: false,
							  allowOutsideClick	: false
							});
							$('#move_asset').prop('disabled',false);
						}
					});
			  } else {
				swal("Cancelled", "Data can be process again :)", "error");
				$('#move_asset').prop('disabled',false);
				return false;
			  }
		});
		
	});
	
	$(document).on('click', '.delete_asset', function(e){
		e.preventDefault();
		var id			= $(this).data('id');
		
		swal({
			  title: "Are you sure?",
			  text: "You will not be able to process again this data!",
			  type: "warning",
			  showCancelButton: true,
			  confirmButtonClass: "btn-danger",
			  confirmButtonText: "Yes, Process it!",
			  cancelButtonText: "No, cancel process!",
			  closeOnConfirm: false,
			  closeOnCancel: false
			},
			function(isConfirm) {
			  if (isConfirm) {
					var baseurl		= siteurl +'asset/delete_asset/'+id;
					$.ajax({
						url			: baseurl,
						type		: "POST",
						cache		: false,
						dataType	: 'json',
						processData	: false, 
						contentType	: false,				
						success		: function(data){								
							if(data.status == 1){											
								swal({
									  title	: "Save Success!",
									  text	: data.pesan,
									  type	: "success",
									  timer	: 7000
									});
								window.location.href = siteurl + 'asset';
							}
							else{
								swal({
								  title	: "Save Failed!",
								  text	: data.pesan,
								  type	: "warning",
								  timer	: 7000,
								  showCancelButton	: false,
								  showConfirmButton	: false,
								  allowOutsideClick	: false
								});
							}
						},
						error: function() {
							swal({
							  title				: "Error Message !",
							  text				: 'An Error Occured During Process. Please try again..',						
							  type				: "warning",								  
							  timer				: 3000,
							  showCancelButton	: false,
							  showConfirmButton	: false,
							  allowOutsideClick	: false
							});
						}
					});
			  } else {
				swal("Cancelled", "Data can be process again :)", "error");
				return false;
			  }
		});
		
	});
	
	function get_depresiasi(){
		var nilai_asset = $('#nilai_asset').val();
		var qty_asset 	= $('#qty').val();
		var depresiasi	= parseFloat($('#depresiasi').val());
		var nilai		= parseFloat(nilai_asset.split(',').join(''));
		
		var per_bulan	= (nilai / (depresiasi * 12));
		if(isNaN(per_bulan)){
			var per_bulan = 0;
		}
		$('#value').val(per_bulan.toFixed(0));
	}

</script>
