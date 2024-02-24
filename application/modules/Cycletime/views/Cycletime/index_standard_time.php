<?php
$this->load->view('include/side_menu');
?>
<form action="#" method="POST" id="form_proses_bro" enctype="multipart/form-data">
	<div class="box box-primary">
	<div class="box-header">
		<h3 class="box-title"><?php echo $title;?></h3><br><br>
		<!--div class="box-tool pull-right">
			<label>Search : </label>
			<select id='series' name='series' class='form-control input-sm' style='min-width:200px;'>
				<option value='0'>All Series</option>
				<?php
					foreach($listseries AS $val => $valx){
						echo "<option value='".$valx['kode_group']."'>".strtoupper($valx['kode_group'])."</option>";
					}
				?>
			</select>
			<?php
			if(empty($this->uri->segment(3))){
			?>
			<select id='komponen' name='komponen' class='form-control input-sm' style='min-width:200px;'>
				<option value='0'>All Component</option>
				<?php
					foreach($listkomponen AS $val => $valx){
						echo "<option value='".$valx['product_parent']."'>".strtoupper($valx['product_parent'])."</option>";
					}
				?>
			</select>
			<?php
			}
			?>
		</div-->

		<div class="box-tool pull-left">
			<button type='button' id='update_cost' style='min-width:150px;' class="btn btn-sm btn-primary" id='btn-add'>
				Update Cost Process
			  </button><br><div style='color:red;'><b>Last Update by <?= ucwords(strtolower($get_by[0]['update_by']))." On <u>".date('d-m-Y H:i:s', strtotime($get_by[0]['update_on']));?></u></b></div>
		</div>
		<div class="box-tool pull-right">
			<a class="btn btn-primary btn-sm" id="add">+ Add Time Process</a>
		</div>
	</div>
	<!-- /.box-header -->
	<div class="box-body">
		<table id="example1" width='100%' class="table table-bordered table-striped">
			<thead>
				<tr class='bg-blue'>
					<th width='3px' class="text-center">No.</th>
					<th class="text-center">Standard Code</th>
					<th class="text-center">Component</th>
					<th class="text-center">Pressure</th>
					<th class="text-center">Liner</th>
					<!--<th class="text-center">Vacuum Rate</th>-->
					<th class="text-center">Diameter</th>
					<th class="text-center">Diameter 2</th>
					<th class="text-center">Total Time</th>
          <th class="text-center">Man Power</th>
          <th class="text-center">Man Hours</th>
					<th class="text-center" width="15%">Option</th>
				</tr>
			</thead>
			<tbody></tbody>
		</table>
	</div>
	<!-- /.box-body -->
 </div>
  <!-- /.box -->

  <!-- modal -->
	<div class="modal fade" id="ModalView">
		<div class="modal-dialog"  style='width:55%; '>
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

	<div class="modal fade" id="ModalView2">
		<div class="modal-dialog"  style='width:30%; '>
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="head_title2"></h4>
					</div>
					<div class="modal-body" id="view2">
					</div>
					<div class="modal-footer">
					<!--<button type="button" class="btn btn-primary">Save</button>-->
					<button type="button" class="btn btn-default " data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<!-- modal -->
</form>
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
<script>
	$(document).ready(function(){

		$(document).ready(function(){
			var series = $('#series').val();
			var komponen = $('#komponen').val();
			DataTables(series, komponen);
		});

		$('#btn-add').click(function(){
			loading_spinner();
		});

		$('#printSPK').click(function(e){
			e.preventDefault();
			var id_product	= $(this).data('id_product');

			var Links		= base_url +'index.php/'+ active_controller+'/printSPK/'+id_product;
			window.open(Links,'_blank');
		});

		$(document).on('click', '#MatDetail', function(e){
			e.preventDefault();
			$("#head_title").html("<b>DETAIL ESTIMATION ["+$(this).data('id_product')+"]</b>");
			$("#view").load(base_url +'index.php/'+ active_controller+'/modalDetail/'+$(this).data('id_product'));
			$("#ModalView").modal();
		});
		
		$(document).on('click', '#update_cost', function(){
			
			swal({
			  title: "Apakah anda yakin ?",
			  text: "Update Cost Process",
			  type: "warning",
			  showCancelButton: true,
			  confirmButtonClass: "btn-danger",
			  confirmButtonText: "Ya, Update!",
			  cancelButtonText: "Tidak, Batalkan!",
			  closeOnConfirm: true,
			  closeOnCancel: false
			},
			function(isConfirm) {
				if (isConfirm) {
					loading_spinner();
					$.ajax({
						url			: base_url+'index.php/'+active_controller+'/update_cost',
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
								  timer	: 7000,
								  showCancelButton	: false,
								  showConfirmButton	: false,
								  allowOutsideClick	: false
								});
								swal.close();
								window.location.href = base_url + active_controller + '/standard_time';
							}
							else if(data.status == 0){
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
							  timer				: 7000,
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

		$(document).on('click', '#del_type', function(){
			var bF	= $(this).data('idcategory');
			// alert(bF);
			// return false;
			swal({
			  title: "Apakah anda yakin ?",
			  text: "Data akan terhapus secara Permanen !!!",
			  type: "warning",
			  showCancelButton: true,
			  confirmButtonClass: "btn-danger",
			  confirmButtonText: "Ya, Lanjutkan !",
			  cancelButtonText: "Tidak, Batalkan !",
			  closeOnConfirm: false,
			  closeOnCancel: false
			},
			function(isConfirm) {
				if (isConfirm) {
					loading_spinner();
					$.ajax({
						url			: base_url+'index.php/'+active_controller+'/hapus/'+bF,
						type		: "POST",
						data		: "id="+bF,
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
									  timer	: 7000,
									  showCancelButton	: false,
									  showConfirmButton	: false,
									  allowOutsideClick	: false
									});
								window.location.href = base_url + active_controller;
							}
							else if(data.status == 0){
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
							  timer				: 7000,
							  showCancelButton	: false,
							  showConfirmButton	: false,
							  allowOutsideClick	: false
							});
						}
					});
				} else {
				swal("Dibatalkan", "Data dapat di hapus kembali ...", "error");
				return false;
				}
			});
		});

		$(document).on('click', '#add', function(e){
			e.preventDefault();
			$("#head_title").html("<b>ADD STANDART TIME</b>");
			$("#view").load(base_url +'index.php/'+ active_controller+'/modalAdd_Time/');
			$("#ModalView").modal();
		});

		$(document).on('click', '#TimeDetail', function(e){
			var id = $(this).data('id');
			e.preventDefault();
			$("#head_title").html("<b>DETAIL TIME</b>");
			$("#view").load(base_url +'index.php/'+ active_controller+'/modalView_Time/'+id);
			$("#ModalView").modal();
		});

		$(document).on('click', '#TimeEdit', function(e){
			var id = $(this).data('id');
			e.preventDefault();
			$("#head_title").html("<b>DETAIL TIME</b>");
			$("#view").load(base_url +'index.php/'+ active_controller+'/modalEdit_Time/'+id);
			$("#ModalView").modal();
		});

		$(document).on('click', '#addPSave', function(){
			var standart_code			= $('#standart_codex').val();

			if(standart_code == '' || standart_code == null || standart_code == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'Default Name is Empty, please input first ...',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
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
					loading_spinner();
					var formData  	= new FormData($('#form_proses_bro')[0]);
					$.ajax({
						url			: base_url+'index.php/'+active_controller+'/addPSave',
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
									  timer	: 5000,
									  showCancelButton	: false,
									  showConfirmButton	: false,
									  allowOutsideClick	: false
									});
								// window.location.href = base_url + active_controller+'/'+data_url;
								$("#ModalView2").modal('hide');
								$("#head_title").html("<b>ADD DEFAULT</b>");
								$("#view").load(base_url +'index.php/'+ active_controller+'/modalAdd_Time/');
								$("#ModalView").modal();


							}
							else{
								swal({
								  title	: "Save Failed!",
								  text	: data.pesan,
								  type	: "warning",
								  timer	: 5000,
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
							  timer				: 5000,
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

		$(document).on('click', '#addDefaultSave', function(){
			var komponen		= $('#komponen').val();
			var standart_code	= $('#standart_code').val();
			var diameter		= $('#diameter').val();
			var diameter2		= $('#diameter2').val();
			var max				= $('#max').val();
			var min				= $('#min').val();
			var plastic_film	= $('#plastic_film').val();
			var waste			= $('#waste').val();
			var overlap			= $('#overlap').val();
			
			var man_power		= $('#man_power').val();
			var machine			= $('#machine').val();

			if(komponen == '' || komponen == null || komponen == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'Product Namex is Empty, please input first ...',
				  type	: "warning"
				});
				$('#addDefaultSave').prop('disabled',false);
				return false;
			}
			if(standart_code == '' || standart_code == null || standart_code == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'Default Name is Empty, please input first ...',
				  type	: "warning"
				});
				$('#addDefaultSave').prop('disabled',false);
				return false;
			}
			if(diameter == '' || diameter == null || diameter == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'Diameter is Empty, please input first ...',
				  type	: "warning"
				});
				$('#addDefaultSave').prop('disabled',false);
				return false;
			}
			if(diameter2 == '' || diameter2 == null){
				swal({
				  title	: "Error Message!",
				  text	: 'Diameter 2 is Empty, please input first ...',
				  type	: "warning"
				});
				$('#addDefaultSave').prop('disabled',false);
				return false;
			}
			
			if(man_power == '' || man_power == null || man_power == '0'){
				swal({
				  title	: "Error Message!",
				  text	: 'Man Power is Empty, please input first ...',
				  type	: "warning"
				});
				$('#addDefaultSave').prop('disabled',false);
				return false;
			}
			if(machine == '0'){
				swal({
				  title	: "Error Message!",
				  text	: 'Machine is Empty, please input first ...',
				  type	: "warning"
				});
				$('#addDefaultSave').prop('disabled',false);
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
					loading_spinner();
					var formData  	= new FormData($('#form_proses_bro')[0]);
					$.ajax({
						url			: base_url+'index.php/'+active_controller+'/addTimeSave',
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
									  timer	: 5000,
									  showCancelButton	: false,
									  showConfirmButton	: false,
									  allowOutsideClick	: false
									});
								window.location.href = base_url + active_controller+'/standard_time';
								// $("#ModalView2").modal('hide');
								// $("#head_title").html("<b>ADD DEFAULT</b>");
								// $("#view").load(base_url +'index.php/'+ active_controller+'/modalAddDefault/');
								// $("#ModalView").modal();


							}
							else{
								swal({
								  title	: "Save Failed!",
								  text	: data.pesan,
								  type	: "warning",
								  timer	: 5000,
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
							  timer				: 5000,
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

		$(document).on('click', '#editTimeSave', function(){
			var komponen		= $('#komponen').val();
			var standart_code	= $('#standart_code').val();
			var diameter		= $('#diameter').val();
			var diameter2		= $('#diameter2').val();
			var pn				= $('#pn').val();
			var liner			= $('#liner').val();
			var standard_length	= $('#standard_length').val();

			if(komponen == '' || komponen == null || komponen == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'Product Namex is Empty, please input first ...',
				  type	: "warning"
				});
				$('#editDefaultSave').prop('disabled',false);
				return false;
			}
			if(standart_code == '' || standart_code == null || standart_code == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'Default Name is Empty, please input first ...',
				  type	: "warning"
				});
				$('#editDefaultSave').prop('disabled',false);
				return false;
			}
			if(diameter == '' || diameter == null || diameter == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'Diameter is Empty, please input first ...',
				  type	: "warning"
				});
				$('#editDefaultSave').prop('disabled',false);
				return false;
			}
			if(diameter2 == '' || diameter2 == null){
				swal({
				  title	: "Error Message!",
				  text	: 'Diameter 2 is Empty, please input first ...',
				  type	: "warning"
				});
				$('#editDefaultSave').prop('disabled',false);
				return false;
			}
			if(pn == '' || pn == null || pn == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'Plessure is Empty, please input first ...',
				  type	: "warning"
				});
				$('#editDefaultSave').prop('disabled',false);
				return false;
			}
			if(liner == '' || liner == null || liner == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'Liner is Empty, please input first ...',
				  type	: "warning"
				});
				$('#editDefaultSave').prop('disabled',false);
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
					loading_spinner();
					var formData  	= new FormData($('#form_proses_bro')[0]);
					$.ajax({
						url			: base_url+'index.php/'+active_controller+'/editTimeSave',
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
									  timer	: 5000,
									  showCancelButton	: false,
									  showConfirmButton	: false,
									  allowOutsideClick	: false
									});
								window.location.href = base_url + active_controller+'/standard_time';
								// $("#ModalView2").modal('hide');
								// $("#head_title").html("<b>ADD DEFAULT</b>");
								// $("#view").load(base_url +'index.php/'+ active_controller+'/modalAddDefault/');
								// $("#ModalView").modal();


							}
							else{
								swal({
								  title	: "Save Failed!",
								  text	: data.pesan,
								  type	: "warning",
								  timer	: 5000,
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
							  timer				: 5000,
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

		$(document).on('click', '#TimeDelete', function(){
			var id		= $(this).data('kode'); 

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
					loading_spinner();
					var formData  	= new FormData($('#form_proses_bro')[0]);
					$.ajax({
						url			: base_url+'index.php/'+active_controller+'/deleteTime/'+id,
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
									  timer	: 5000,
									  showCancelButton	: false,
									  showConfirmButton	: false,
									  allowOutsideClick	: false
									});
								window.location.href = base_url + active_controller+'/standard_time';
								// $("#ModalView2").modal('hide');
								// $("#head_title").html("<b>ADD DEFAULT</b>");
								// $("#view").load(base_url +'index.php/'+ active_controller+'/modalAddDefault/');
								// $("#ModalView").modal();


							}
							else{
								swal({
								  title	: "Save Failed!",
								  text	: data.pesan,
								  type	: "warning",
								  timer	: 5000,
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
							  timer				: 5000,
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
	});

	function DataTables(series = null, komponen = null){

		var dataTable = $('#example1').DataTable({
			"serverSide": true,
			"stateSave" : true,
			"bAutoWidth": true,
			"destroy": true,
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
			"aaSorting": [[ 1, "asc" ]],
			"columnDefs": [ {
				"targets": 'no-sort',
				"orderable": false,
			}],
			"sPaginationType": "simple_numbers",
			"iDisplayLength": 10,
			"aLengthMenu": [[10, 20, 50, 100, 150], [10, 20, 50, 100, 150]],
			"ajax":{
				url : base_url +'index.php/'+active_controller+'/getDataJSON2',
				type: "post",
				data: function(d){
					d.series 	= series,
					d.komponen 	= komponen,
					d.group			= ''
				},
				cache: false,
				error: function(){
					$(".my-grid-error").html("");
					$("#my-grid").append('<tbody class="my-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
					$("#my-grid_processing").css("display","none");
				}
			}
		});
	}

</script>
