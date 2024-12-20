<?php
$this->load->view('include/side_menu'); 
?>
<form action="#" method="POST" id="form_proses_bro" enctype="multipart/form-data">    
<div class="box box-primary">
	<div class="box-header">
		<h3 class="box-title"><?php echo $title;?></h3>
		<div class="box-tool pull-right">
		<?php
			if($akses_menu['create']=='1'){
		?>
		  <a href="<?php echo site_url(strtolower($this->uri->segment(1)).'/add') ?>" class="btn btn-sm btn-success" id='btn-add'>
			<i class="fa fa-plus"></i> Add Customer
		  </a>
		  <?php
			}
			if($akses_menu['download']=='1'){
		?>
		  <input type='button' id='upload' class='btn btn-sm btn-warning' value='Upload/Download'>
		  <?php
			}
		  ?>
		</div>
	</div>
	<!-- /.box-header -->
	<div class="box-body" "> <!-- style="overflow-x: scroll; -->
		<table class="table table-bordered table-striped" id="my-grid">
			<thead>
				<tr class='bg-blue'>
					<th class="text-center">No</th>
					<th class="text-center">Customer</th>
					<th class="text-center">Branch</th>
					<th class="text-center">Credibility</th>
					<th class="text-center">Status</th>
					<th class="text-center">Option</th>
				</tr>
			</thead>
			<tbody>
			  
			</tbody>
		</table>
	</div>
	<!-- /.box-body -->
 </div>
  <!-- /.box -->
  
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
	
	</form>

<?php $this->load->view('include/footer'); ?>
<script>
	var akses_menu		= <?php echo json_encode($akses_menu);?>;
	var akses_cabang	= <?php echo json_encode($row_branch);?>;
	var akses_sales		= <?php echo json_encode($row_sales);?>;
	$(document).ready(function(){
		DataTables();
		
		$(document).on('click', '#upload', function(e){
			e.preventDefault();
			$("#head_title").html("<b>[CUSTOMER] DOWNLOAD TEMPLATE / UPLOAD TEMPLATE</b>");
			$("#view").load(base_url +'index.php/'+ active_controller+'/modalUpload/');
			$("#ModalView").modal();
		});
		
		// $('#listData').dataTable( {
			// "processing": true,
			// "serverSide": true,
			// "ajax": base_url + active_controller+'/display_data',
			// "columns": [
				// {"data":"nm_customer"},
				// {"data":"kdcab","sClass":"text-center","searchable":"false"},
				// {"data":"bidang_usaha"},
				// {"data":"alamat"},
				// {"data":"id_marketing","sClass":"text-center"},
				// {"data":"kredibilitas","sClass":"text-center"},
				// {"data":"status","sClass":"text-center","searchable":"false"},
				// {"data":"action","sClass":"text-center","searchable":"false"}
			// ],
			// "rowCallback": function(row,data,index,iDisplayIndexFull){
				// // console.log(data.tool_id);
				// var group		= data.kdcab;
				// var group_name	= akses_cabang[group];
				// var sts			= data.sts_aktif;
				// var marketing	= parseInt(data.id_marketing);
				// var salesman	= akses_sales[marketing];
				
				// if(sts=='Y'){
					// var status	='<span class="badge bg-green">ACTIVE</span>';
				// }else{
					// var status	='<span class="badge bg-red">INACTIVE</span>';
				// }
				// $('td:eq(1)',row).html(group_name);
				// $('td:eq(4)',row).html(salesman);
				// $('td:eq(6)',row).html(status);
				// var Template	='<button type="button" class="btn btn-sm btn-default" title="View Data" data-role="qtip" onClick="viewCustomer('+"'"+data.id_customer+"'"+');"><i class="fa fa-search"></i></button>';
				// if(akses_menu.update =='1'){
					// Template	+='&nbsp;&nbsp;<button type="button" class="btn btn-sm btn-primary" title="Edit Data" data-role="qtip" onClick="editCustomer('+"'"+data.id_customer+"'"+');"><i class="fa fa-pencil"></i></button>';
					
				// }
				// if(akses_menu.delete =='1'){
					// Template	+='&nbsp;&nbsp;<button type="button" class="btn btn-sm btn-danger" title="Delete Data" data-role="qtip" id="delCust" data-id_customer="'+""+data.id_customer+""+'"><i class="fa fa-trash-o"></i></button>';
				// }
				// $('td:eq(7)',row).html(Template);
				
			// },
			// "order": [[1,"asc"]]
		// });
		
		
		
		$('#btn-add').click(function(){
			loading_spinner();
		});
		
	});
	
	$(document).on('click', '#delCust', function(){
		var bF	= $(this).data('id_customer');
		// alert(bF);
		// return false;
		swal({
		  title: "Are you sure?",
		  text: "Delete this data ?",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonClass: "btn-danger",
		  confirmButtonText: "Yes, Process it!",
		  cancelButtonText: "No, cancel process!",
		  closeOnConfirm: true,
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
			swal("Cancelled", "Data can be process again :)", "error");
			return false;
			}
		});
	});
	
	$(document).on('click', '#uploadEx', function(){
			var excel_file = $('#excel_file').val();
			if(excel_file == '' || excel_file == null){
				swal({
				  title	: "Error Message!",
				  text	: 'File upload is Empty, please choose file first...',
				  type	: "warning"
				});
				// $('#simpan-bro').prop('disabled',false);
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
					var baseurl		= base_url + active_controller +'/importData';
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
									timer	: 7000,
									showCancelButton	: false,
									showConfirmButton	: false,
									allowOutsideClick	: false
									});
								window.location.href = base_url + active_controller;
							}
							if(data.status == 2){
								swal({
								  title	: "Save Failed!",
								  text	: data.pesan,
								  type	: "warning",
								  timer	: 5000
								});
							}
							if(data.status == 3){
								swal({
								  title	: "Save Failed!",
								  text	: data.pesan,
								  type	: "warning",
								  timer	: 5000
								});
							}
							$('#uploadEx').prop('disabled',false);
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
							$('#uploadEx').prop('disabled',false);
						}
					});
			  } else {
				swal("Cancelled", "Data can be process again :)", "error");
				$('#uploadEx').prop('disabled',false);
				return false;
			  }
			});
		});
	
	function deleteCustomer(id){
		swal({
			  title: "Are you sure?",
			  text: "You will not be able to process again this data!",
			  type: "warning",
			  showCancelButton: true,
			  confirmButtonClass: "btn-danger",
			  confirmButtonText: "Yes, Process it!",
			  cancelButtonText: "No, cancel process!",
			  closeOnConfirm: true,
			  closeOnCancel: false
			},
			function(isConfirm) {
			  if (isConfirm) {
					loading_spinner();
					window.location.href = base_url +'index.php/'+ active_controller+'/delete_user/'+id;
					
			  } else {
				swal("Cancelled", "Data can be process again :)", "error");
				return false;
			  }
		});
       
	} 
	
	function viewCustomer(id){
		loading_spinner();
		window.location.href = base_url +'index.php/'+ active_controller+'/view/'+id;
		    
	}
	
	function editCustomer(id){
		loading_spinner();
		window.location.href = base_url +'index.php/'+ active_controller+'/edit_user/'+id;
		    
	}
	
	function DataTables(){
		var dataTable = $('#my-grid').DataTable({
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
				url : base_url +'index.php/'+active_controller+'/getDataJSON',
				type: "post",
				data: function(d){
					// d.kode_partner = $('#kode_partner').val()
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
