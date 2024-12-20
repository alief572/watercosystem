<?php
$this->load->view('include/side_menu'); 
?>    
<div class="box box-primary">
	<div class="box-header">
		<h3 class="box-title"><?php echo $title;?></h3>
		<div class="box-tool pull-right">
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
			<input type='hidden' name='group' id='group' value='<?= $this->uri->segment(3);?>'>
		</div>
	</div>
	<!-- /.box-header -->
	<div class="box-body">
		<table id="my-grid" width='100%' class="table table-bordered table-striped">
			<thead>
				<tr class='bg-blue'>
					<th class="text-center">No.</th>
					<th class="text-center">Product ID</th>
					<!--<th class="text-center">Series</th>-->
					<th class="text-center">Spesifikasi</th>
					<th class="text-center">Stifness</th>
					<th class="text-center">Service Fluide</th>
					<th class="text-center">Vacuum Rate</th>
					<th class="text-center">Rev</th>
					<th class="text-center">Option</th>
				</tr>
			</thead>
			<tbody>
			  <?php 
			  // if($row){
					// $int	=0;
					// foreach($row as $datas){
						// $int++;
						// $detail = "";
						// if(strtolower($datas->parent_product) == 'pipe'){
							// $detail = "(".$datas->diameter." x ".$datas->panjang." x ".$datas->design.")";
						// }
						// echo"<tr>";							
							// echo"<td align='center'>$int</td>";
							// echo"<td align='left'>".$datas->id_product."</td>"; 
							// echo"<td align='left'>".$datas->series."</td>"; 
							// echo"<td align='left'>".$datas->nm_product." ".$detail."</td>";
							// echo"<td align='center'>".$datas->stiffness."</td>";
							// echo"<td align='center'>".ucfirst(strtolower($datas->created_by))."</td>";
							// echo"<td align='center'>".$datas->rev."</td>";
								// if($datas->status == 'WAITING APPROVAL'){
									// $class	= 'bg-orange';
								// }
								// else{
									// $class	= 'bg-green';
								// }
							// echo"<td align='center'><span class='badge ".$class."'>".ucwords(strtolower($datas->status))."</span></td>";
							// echo"<td align='center'>";
								// echo"<button type='button' id='MatDetail' data-id_product='".$datas->id_product."' data-nm_product='".$datas->nm_product."' class='btn btn-sm btn-warning' title='View Data' data-role='qtip'><i class='fa fa-eye'></i></button>";									
								// //echo"&nbsp;<a href=''id='printSPK' data-id_product='".$datas->id_product."' data-nm_product='".$datas->nm_product."' class='btn btn-sm btn-success' title='Print SPK' data-role='qtip'><i class='fa fa-print'></i></button>";									
								// //echo "&nbsp;<a href='".base_url('calculation/printSPK/'.$datas->id_product)."' class='btn btn-sm btn-primary' target='_blank' title='Print SPK' data-role='qtip'><i class='fa fa-print'></i></a>";
							// echo"</td>";
						// echo"</tr>";
					// }
			  // }
			  ?>
			</tbody>
		</table>
	</div>
	<!-- /.box-body -->
 </div> 
  <!-- /.box -->
  
  <!-- modal -->
	<div class="modal fade" id="ModalView">
		<div class="modal-dialog"  style='width:95%; '>
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
			var group = $('#group').val();
			var series = $('#series').val();
			var komponen = "";
			if(group != ""){
				var komponen = $('#komponen').val();
			} 
			DataTables(series, group, komponen); 
		});
		
		$(document).on('change','#series', function(e){
			e.preventDefault();
			var series = $('#series').val();
			var group = $('#group').val();
			var komponen = "";
			if(group != ""){
				var komponen = $('#komponen').val();
			}
			DataTables(series, group, komponen);
		});
		
		$(document).on('change','#komponen', function(e){
			e.preventDefault();
			var series = $('#series').val();
			var group = $('#group').val();
			var komponen = $('#komponen').val();
			DataTables(series, group, komponen);
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
	});
	
	function DataTables(series = null, group = null, komponen = null){
		// alert(series);
		// alert(group);
		// alert(komponen);
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
					d.series 	= series,
					d.group 	= group,
					d.komponen 	= komponen
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
