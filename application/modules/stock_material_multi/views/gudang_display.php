<?php
    $ENABLE_ADD     = has_permission('Warehouse_material.Add');
    $ENABLE_MANAGE  = has_permission('Warehouse_material.Manage');
    $ENABLE_VIEW    = has_permission('Warehouse_material.View');
    $ENABLE_DELETE  = has_permission('Warehouse_material.Delete');
	$id_bentuk = $this->uri->segment(3);
?>
<style type="text/css">
thead input {
	width: 100%;
}
</style>
<div id='alert_edit' class="alert alert-success alert-dismissable" style="padding: 15px; display: none;"></div>
<link rel="stylesheet" href="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.css')?>">
<div class="box">
	<div class="box-header">
    
	</div>
	<div class="box-body">
		<table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
					<th class='no-sort text-center'>Id Material</th>
					<th class='no-sort text-center'>Kode Barang</th>
                    <th class='no-sort text-center'>Nama Material</th>
                    <th class='no-sort text-center'>Qty</th>
                    <th class='no-sort text-center'>Qty Booking</th>
                    <th class='no-sort text-center'>Qty Free</th>
                   	<th class='no-sort text-center'>Keterangan</th>
                    <th class='no-sort text-center'>Gudang</th>
                </tr>
            </thead>
            <tbody></tbody>
            
        </table>
	</div>
</div>


<!-- DataTables -->
<script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.min.js')?>"></script>
<script src="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.min.js')?>"></script>

<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>

<!-- page script -->
<script type="text/javascript">

    $(document).ready(function(){
        $('.select').select2();

    	DataTables();

        $(document).on('click','#cetak', function(){
            var kategori 	= $('#kategory').val();
            var url = siteurl +'stock_material_multi/PrintHeader/'+kategori;
            // alert(url)
            window.open(url, '_blank');
        });
  	});

    function DataTables(){
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
			"aaSorting"		: [[ 0, "asc" ]],
			"columnDefs"	: [ {
				"targets"	: 'no-sort',
				"orderable"	: false,
				},
				{ className: 'text-right', targets: [5, 6, 7] }
			],
			"dom": 'Blfrtip',
				"buttons": [
				{
                "extend": 'excel',
				}],	
				
			"sPaginationType": "simple_numbers",
			"iDisplayLength": 10,
			"aLengthMenu": [[10, 20, 50, 100, 2000,3000,4000], [10, 20, 50, 100, 2000,3000,4000]],
			"ajax":{
				url : siteurl +'stock_material_multi/data_side_material_grw',
				type: "post",
				data: function(d){
					d.gudang = '2'
				},
				cache: false,
				error: function(){
					$(".my-grid-error").html("");
					$("#my-grid").append('<tbody class="my-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
					$("#my-grid_processing").css("display","none");
				},
				 dataSrc: function ( data ) {
				   total_aset = data.recordsAset;
				   return data.data;
				 }
			},
			drawCallback: function( settings ) {
				var api = this.api();

				$( api.column( 2 ).footer() ).html("<div align='right'>"+ number_format(total_aset,2) +"</div>");
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
</script>
