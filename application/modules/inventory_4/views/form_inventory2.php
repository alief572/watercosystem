<?php
$ENABLE_ADD     = has_permission('Level_4.Add');
$ENABLE_MANAGE  = has_permission('Level_4.Manage');
$ENABLE_VIEW    = has_permission('Level_4.View');
$ENABLE_DELETE  = has_permission('Level_4.Delete');
$id='';
$id_category3='';
if(!empty($results['inven'])){
	
	foreach ($results['inven'] as $inven){
		if ($inven->alloy !=''){
			$all =$inven->alloy;
		}
		else {
			$all =$results['alloy'];
		}
		if ($inven->spek !=''){
			$spesifikasi =$inven->spek;
		}
		else {
			$spesifikasi =$inven->nama;
		}
		$id=$inven->id;
		$id_category3=$inven->id_category3;
	}
}
?>
<div class="box box-primary">
  <div class="box-body">
    <form id="data-form" method="post">
	  <input type="hidden" class="form-control" id="id" value='<?= $id ?>' name="id">
	  <input type="hidden" class="form-control" id="id_category3" value='<?= $id_category3 ?>' name="id_category3">
      <div class="col-sm-12">
        <div class="input_fields_wrap2">
          <div class="row">
            <div class="form-group row">
              <div class="col-md-4">
                <label for="customer">Purpose Product (Level 1)</label>
              </div>
              <div class="col-md-6">
                <select id="id_type" name="id_type" class="form-control select" onblur="get_inv2()" required>
                  <option value="">Purpose Product (Level 1)</option>
				  <?php foreach ($results['inventory_1'] as $datacombo){
						$select = $inven->id_type == $datacombo->id_type ? 'selected' : '';?>
						<option value="<?= $datacombo->id_type?>" <?= $select ?>> <?= $datacombo->nama?></option>
				  <?php } ?>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-md-4">
                <label for="customer">Product Type (Level 2)</label>
              </div>
              <div class="col-md-6">
                <select id="id_category1" name="id_category1" class="form-control select" onblur="get_inv3()" required>
                  <option value="">Product Type (Level 2)</option>
				  <?php
				  if(!empty($results['inventory_2'])){
					  foreach ($results['inventory_2'] as $datacombo){
							$select = $inven->id_category1 == $datacombo->id_category1 ? 'selected' : '';?>
							<option value="<?= $datacombo->id_category1?>" <?= $select ?>> <?= $datacombo->nama?></option>
					  <?php } 
				  }?>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-md-4">
                <label for="customer">Usage (Level 3)</label>
              </div>
              <div class="col-md-6">
                <select id="id_category2" name="id_category2" class="form-control select" required>
                  <option value="">Usage (Level 3)</option>
				  <?php 
				   if(!empty($results['inventory_3'])){
					   foreach ($results['inventory_3'] as $datacombo){
						$select = $inven->id_category2 == $datacombo->id_category2 ? 'selected' : '';?>
						<option value="<?= $datacombo->id_category2?>" <?= $select ?>> <?= $datacombo->nama?></option>
				  <?php } 
				   }?>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-md-4">
                <label for="customer">Maker</label>
              </div>
              <div class="col-md-6">
				<input type="text" class="form-control" id="maker" required name="maker" value='<?= $inven->maker ?>' placeholder="Maker">
              </div>
            </div>
            <div class="form-group row">
              <div class="col-md-4">
                <label for="customer">Product Name</label>
              </div>
              <div class="col-md-6">
                <input type="text" class="form-control nama" id="nama" name="nama" placeholder="Nama Material" value='<?= $inven->nama ?>'>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-md-4">
                <label for="customer">Kode Barang</label>
              </div>
              <div class="col-md-6">
				<input type="text" class="form-control" id="kode_barang" required name="kode_barang" value='<?= $inven->kode_barang ?>' placeholder="Kode Barang">
              </div>
            </div>
			<div class="form-group row">
				<div class="col-md-4">
				  <label for="">Status</label>
				</div>
				<div class="col-md-4">
				<?php
				$aktifcheck="";
				$nonaktifcheck="";
				if(!empty($inven->aktif)){
					if($inven->aktif=='aktif'){
						$aktifcheck="checked";
					}else{
						$nonaktifcheck="checked";
					}
				}
				?>
				  <label>
					<input type="radio" class="radio-control" id="statusa" name="status" value="aktif" <?=$aktifcheck?> required> Aktif
				  </label>
					&nbsp &nbsp &nbsp
				  <label>
					<input type="radio" class="radio-control" id="statusn" name="status" value="nonaktif" <?=$nonaktifcheck?> required> Non Aktif
				  </label>
				</div>
			</div>
          </div>
        </div>
      </div>
      <hr>
    
    </form>
  </div>
</div>
<script type="text/javascript">

var base_url = '<?php echo base_url(); ?>';
var active_controller = '<?php echo $this->uri->segment(1); ?>';
$(document).ready(function() {
    $('#simpan-com').click(function(e) {
        e.preventDefault();
        var deskripsi = $('#deskripsi').val();
        var image = $('#image').val();
        var idtype = $('#inventory_4').val();
        var bentuk = $('.idbentuk').val();
        var data, xhr;
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
        }, function(isConfirm) {
            if (isConfirm) {
                var formData = new FormData($('#data-form')[0]);
                var baseurl = siteurl + 'inventory_4/saveInventory';
                $.ajax({
                    url: baseurl,
                    type: "POST",
                    data: formData,
                    cache: false,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        if (data.status == 1) {
                            swal({
                                title: "Save Success!",
                                text: data.pesan,
                                type: "success",
                                timer: 7000,
                                showCancelButton: false,
                                showConfirmButton: false,
                                allowOutsideClick: false
                            });
							location.reload();
                        } else {
                            if (data.status == 2) {
                                swal({
                                    title: "Save Failed!",
                                    text: data.pesan,
                                    type: "warning",
                                    timer: 7000,
                                    showCancelButton: false,
                                    showConfirmButton: false,
                                    allowOutsideClick: false
                                });
                            } else {
                                swal({
                                    title: "Save Failed!",
                                    text: data.pesan,
                                    type: "warning",
                                    timer: 7000,
                                    showCancelButton: false,
                                    showConfirmButton: false,
                                    allowOutsideClick: false
                                });
                            }
                        }
                    },
                    error: function() {
                        swal({
                            title: "Error Message !",
                            text: 'An Error Occured During Process. Please try again..',
                            type: "warning",
                            timer: 7000,
                            showCancelButton: false,
                            showConfirmButton: false,
                            allowOutsideClick: false
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

function get_inv2() {
    var id_type = $("#id_type").val();
    $.ajax({
        type: "GET",
        url: siteurl + 'inventory_4/get_inven2',
        data: "inventory_1=" + id_type,
        success: function(html) {
            $("#id_category1").html(html);
        }
    });
}

function get_inv3() { 
    var id_type = $("#id_type").val();
    var id_category1 = $("#id_category1").val();
    $.ajax({
        type: "GET",
        url: siteurl + 'inventory_4/get_inven3',
        data: "inventory_2=" + id_category1+"&id_type="+id_type,
        success: function(html) {
            $("#id_category2").html(html);
        }
    });
}

</script>
