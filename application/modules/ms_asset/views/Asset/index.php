<?php
$this->load->view('include/side_menu');
?>
<form action="#" method="POST" id="form_proses_bro" enctype="multipart/form-data">
	<div class="box box-primary">
		<div class="box-header">
		<h3 class="box-title"><?php echo $title;?></h3><br><br>
			<div class="box-tool pull-right">
			<?php
				if($akses_menu['create']=='1'){
			?>
				<a href="<?php echo site_url('asset/add') ?>" class="btn btn-sm btn-success" id='btn-add'>
					<i class="fa fa-plus"></i> Add Asset
				</a>
			<?php } ?>
			</div>
			<div class="box-tool pull-left">
				<select id='kategory' name='kategory' class='form-control input-sm chosen-select' style='min-width:150px; float:left; margin-bottom: 5px;'>
					<option value='0'>All Category</option>
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
						<th class="text-center" width='4%'>#</th>
						<th class="text-center" width='15%'>Asset Code</th>
						<th class="text-center">Asset Name</th>
						<th class="text-center" width='12%'>Category</th>
						<th class="text-center" width='9%'>Costcenter</th>
						<th class="text-center" width='9%'>Depreciation</th>
						<th class="text-center" width='9%'>Acquisition</th>
						<th class="text-center" width='9%'>Depreciation</th>
						<th class="text-center" width='9%'>Asset&nbsp;Val</th>
						<th class="text-center no-sort" width='10%'>#</th>
					</tr>
				</thead>
				<tbody></tbody>
				 <tfoot>
					<tr>
						<th colspan="6" style="text-align:center">SUM</th>
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
		<div class="modal-dialog"  style='width:70%; '>
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="head_title"></h4>
				</div>
				<div class="modal-body" id="view">
				</div>
				<div class="modal-footer">
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
			</div>
		</div>
	</div>
	<!-- modal alert -->

</form>
<!-- DataTables -->
<?php $this->load->view('include/footer'); ?>
<style>
    .chosen-container-active .chosen-single {
	     border: none;
	     box-shadow: none;
	}
	.chosen-container-single .chosen-single {
		height: 34px;
	    border: 1px solid #d2d6de;
	    border-radius: 0px;
	     background: none;
	    box-shadow: none;
	    color: #444;
	    line-height: 32px;
	}
	.chosen-container-single .chosen-single div{
		top: 5px;
	}
</style>
<!-- page script -->
<script type="text/javascript">
	$(document).ready(function(){
		var kdcab 		= $('#kdcab').val();
		var tgl 		= $('#tanggalx').val();
		var kategori 	= $('#kategory').val();
		DataTables(kdcab, tgl, kategori);
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

	$(document).on('click', '.detail', function(e){
		e.preventDefault();
		loading_spinner();
		$("#head_title").html("<b>DETAIL ASSET</b>");
		$("#view").load(base_url + active_controller +'/modal_view/'+$(this).data('id'));
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
			"processing": true,
			"fixedHeader": {
				"header": true,
				"footer": true
			},
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
				url : base_url + active_controller+'/data_side',
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
					var baseurl		= base_url + active_controller +'/delete_asset/'+id;
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
								window.location.href = base_url + active_controller;
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

</script>
