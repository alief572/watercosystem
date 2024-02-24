<?php
    $ENABLE_ADD     = has_permission('Progress_Order.Add');
    $ENABLE_MANAGE  = has_permission('Progress_Order.Manage');
    $ENABLE_VIEW    = has_permission('Progress_Order.View');
    $ENABLE_DELETE  = has_permission('Progress_Order.Delete');
	
?>
<style type="text/css">
thead input {
	width: 100%;
}
</style>
<div id="detail">
<div id='alert_edit' class="alert alert-success alert-dismissable" style="padding: 15px; display: none;"></div>
<link rel="stylesheet" href="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.css')?>">

<div class="box">
  
	<div class="box-header" align='right'>
	  <div class="row" align='right'>
		<label for="tgl_bayar" class="col-sm-4 control-label"><b>CUSTOMER :</label>
		<div class="col-sm-4" id="select_customer">
			 <select class="form-control input-sm select" onchange="CariDetail()" name="customer" id="customer">
				<option value="">Pilih Customer</option>								
			  </select> 	
             		  
		</div>
		</div>	
		 <input type="hidden" class="form-control" id="id_customer" value="<?php echo $customer ?>">	
        <a class="btn btn-success btn-sm" href="<?= base_url('/progress_order/print_progress_order/'.$customer) ?>" target="_blank"  title="Cetak"><i class="fa fa-print">&nbsp;</i>Cetak Laporan</i></a>
	</div>
	<!-- /.box-header -->
	<!-- /.box-header -->
	<div class="box-body">
		<table id="example1" class="table table-bordered table-striped">
		<thead>
		<tr>
			<th width="5">#</th>
			<th>SPK Marketing</th>
            <th>Customer</th>
            <th>Alloy</th>
            <th>Thickness</th>
            <th>Width</th>
            <th>Delivery Date</th>
            <th>Qty Order</th>
            <th>Stock</th>
            <th>Balance Stock</th>
            <th>SPK Produksi</th>
            <th>Balance Order</th>
		</tr>
		</thead>

		<tbody>
		<?php 
		if(!empty($results)){
			$numb=0; 
            foreach($results AS $record){ $numb++; 
                $get_fg_booking = $this->db->select('SUM(berat) AS qty_booking')->get_where('stock_material_customer', array('id_dt_spkmarketing'=>$record->id_dt_spkmarketing))->result();
                $get_qty_aktual = $this->db->select('SUM(qtyaktual) AS qty_aktual')->get_where('dt_spk_aktual', array('no_surat'=>$record->id_dt_spkmarketing))->result();
                $get_qty_produksi = $this->db->select('SUM(totalwidth) AS qty_produksi')->get_where('dt_spk_produksi', array('no_surat'=>$record->id_dt_spkmarketing))->result();

                $fg_booking     = (!empty($get_fg_booking))?$get_fg_booking[0]->qty_booking:0;
                $qty_aktual     = (!empty($get_qty_aktual))?$get_qty_aktual[0]->qty_aktual:0;
                $qty_produksi   = (!empty($get_qty_produksi))?$get_qty_produksi[0]->qty_produksi:0;

                $stock          = $qty_aktual + $fg_booking;
                $balance_stock  = $record->totalwidth - $stock;
                $spk_produksi   = $qty_produksi;
                $balance_order  = $qty_produksi - $balance_stock;

                ?>
                <tr>
                    <td><?= $numb; ?></td>
                    <td><?= $record->no_surat ?></td>
                    <td><?= $record->namacustomer ?></td>
                    <td><?= $record->nmmaterial ?></td>
                    <td align='right'><?= number_format($record->thickness,2) ?></td>
                    <td align='right'><?= number_format($record->weight,2) ?></td>
                    <td align='right'><?= date('d F Y', strtotime($record->delivery)) ?></td>
                    <td align='right'><?= number_format($record->totalwidth,2) ?></td>
                    <td align='right'><?= number_format($stock,2) ?></td>
                    <td align='right'><?= number_format($balance_stock,2) ?></td>
                    <td align='right'><?= number_format($spk_produksi,2) ?></td>
                    <td align='right'><?= number_format($balance_order,2) ?></td>
                </tr>
                <?php 
            } 
        }  ?>
		</tbody>
		</table>
	</div>
	<!-- /.box-body -->
</div>
</div>
<!-- DataTables -->
<script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.min.js')?>"></script>
<script src="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.min.js')?>"></script>

<!-- page script -->
<script type="text/javascript">

     $(document).ready(function(){
		
		get_subject();
		$('.select').select2();
		
	});	
	
	$(function() {
		$('.select').select2();
  	});
	 
  	$(function() {
	    var table = $('#example1').DataTable( {
	        orderCellsTop: true,
	        fixedHeader: true
	    } );
    	$("#form-area").hide();
  	});
	
	function get_subject(){
       
		$.ajax({
            type:"GET",
            url:siteurl+'progress_order/get_customer',
            data:"",
            success:function(html){
               $("#select_customer").html(html);
            }
        });
	}
	
	function CariDetail(){
        var customer=$("#customer").val();
		$.ajax({
            type:"POST",
            url:siteurl+'progress_order/index',
            data:"customer="+customer,
            success:function(html){			  
               $("#detail").html(html);
			   $('.select').select2();
            }			
        });

    }
</script>
