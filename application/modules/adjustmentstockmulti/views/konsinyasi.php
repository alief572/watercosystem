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
	<!-- /.box-header -->
		<form method="post" action="<?= base_url() ?>adjustmentstockmulti/index_konsinyasi" autocomplete="off">
	<div class="box-header"><b>Filter Gudang : </b>
      <select id="id_gudang" name="id_gudang" class="form-control input-sm select" style="width: 25%;" tabindex="-1" required onchange="konsinyasi()">
          <option value="17"></option>
          <?php
            $cus='';
            foreach($results['gudang'] as $kc=>$vc){
              $selected = '';
              if($this->uri->segment(3) == $vc->id_category3){
                   $selected = 'selected="selected"';
                   $cus = $vc->nama;
              }
              ?>
          <option value="<?php echo $vc->id_gudang; ?>">
            <?php echo $vc->nama_gudang ?>
          </option>
          <?php } ?>
      </select>
	  
					   <div class="col-sm-5">
							<div class="form-group">
								<br>
								<label> &nbsp;</label><br>
								<input type="submit" name="adjustment" value="Adjustment" class="btn btn-primary"> &nbsp;
							</div>
						</div>
    </div>
    
							
					
			</form>
	
</div>




<!-- DataTables -->
<script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.min.js')?>"></script>
<script src="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.min.js')?>"></script>

<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>

<!-- page script -->
<script type="text/javascript">

	//Edit
		function konsinyasi(){
		var id = $('#id_gudang').val();
		siteurl +'adjustmentstockmulti/index_konsinyasi/'+id
		}

    

    
</script>
