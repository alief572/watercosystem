<?php
$ENABLE_ADD     = has_permission('Level_4.Add');
$ENABLE_MANAGE  = has_permission('Level_4.Manage');
$ENABLE_VIEW    = has_permission('Level_4.View');
$ENABLE_DELETE  = has_permission('Level_4.Delete');
$id='';
$id_category3='';
if(!empty($results['all'])){
	
	foreach ($results['all'] as $mat){
		$id=$mat->id_kartu_stok;
		$id_category3=$mat->id_category3;
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
                <label for="customer">Nama</label>
              </div>
              <div class="col-md-6">
				<input type="text" class="form-control" id="nama" required name="nama" value='<?= $mat->nama ?>' placeholder="Maker" readonly>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-md-4">
                <label for="customer">Transaksi</label>
              </div>
              <div class="col-md-6">
                <input type="text" class="form-control" id="transaksi" name="transaksi" placeholder="Nama Material" value='<?= $mat->transaksi ?>' readonly>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-md-4">
                <label for="customer">Qty</label>
              </div>
              <div class="col-md-6">
				<input type="text" class="form-control" id="qty" required name="qty" value='<?= $mat->qty ?>' placeholder="Kode Barang">
              </div>
            </div>
			<div class="form-group row">
              <div class="col-md-4">
                <label for="customer">Qty Book</label>
              </div>
              <div class="col-md-6">
				<input type="text" class="form-control" id="qty_book" required name="qty_book" value='<?= $mat->qty_book ?>' placeholder="Kode Barang">
              </div>
            </div>
			<div class="form-group row">
              <div class="col-md-4">
                <label for="customer">Qty Free</label>
              </div>
              <div class="col-md-6">
				<input type="text" class="form-control" id="qty_free" required name="qty_free" value='<?= $mat->qty_free ?>' placeholder="Kode Barang">
              </div>
            </div>
			
			<div class="form-group row">
              <div class="col-md-4">
                <label for="customer">Transaksi In/Out</label>
              </div>
			  <?php 
			  if($mat->transaksi=='sales order'){
				  $inout = 0;				  
			  }
			  else if($mat->transaksi=='delivery order'){
				  $inout = $mat->qty_transaksi*(-1);				  
			  }
			  else if($mat->transaksi=='adjustment minus'){
				  $inout = $mat->qty_transaksi*(-1);				  
			  }
			  else if($mat->transaksi=='adjustment plus'){
				  $inout = $mat->qty_transaksi;				  
			  }
			  else if($mat->transaksi=='incoming'){
				  $inout = $mat->qty_transaksi;				  
			  }
			  
			  ?>
              <div class="col-md-6">
				<input type="text" class="form-control" id="qty_transaksi" required name="qty_transaksi" value='<?= $inout ?>' placeholder="Kode Barang" readonly>
              </div>
            </div>
			
			<div class="form-group row">
              <div class="col-md-4">
                <label for="customer">Transaksi Booking</label>
              </div>
              <div class="col-md-6">
			  <?php 
			  if($mat->transaksi=='sales order'){
				  $booking = $mat->qty_transaksi;				  
			  }
			  else if($mat->transaksi=='delivery order'){
				  $booking = $mat->qty_transaksi*(-1);				  
			  }
			   else if($mat->transaksi=='adjustment minus'){
				  $booking = 0;				  
			  }
			  else if($mat->transaksi=='adjustment plus'){
				  $booking = 0;				  
			  }
			  else if($mat->transaksi=='incoming'){
				  $booking = 0;			  
			  }
			  ?>
				<input type="text" class="form-control" id="qty_transaksi_book" required name="qty_transaksi_book" value='<?= $booking ?>' placeholder="Kode Barang" readonly>
              </div>
            </div>
			
			
			<div class="form-group row">
              <div class="col-md-4">
                <label for="customer">Qty Akhir</label>
              </div>
              <div class="col-md-6">
				<input type="text" class="form-control" id="qty_akhir" required name="qty_akhir" value='<?= $mat->qty_akhir ?>' placeholder="Kode Barang">
              </div>
            </div>
			<div class="form-group row">
              <div class="col-md-4">
                <label for="customer">Qty Book Akhir</label>
              </div>
              <div class="col-md-6">
				<input type="text" class="form-control" id="qty_book_akhir" required name="qty_book_akhir" value='<?= $mat->qty_book_akhir ?>' placeholder="Kode Barang">
              </div>
            </div>
			<div class="form-group row">
              <div class="col-md-4">
                <label for="customer">Qty Free Akhir</label>
              </div>
              <div class="col-md-6">
				<input type="text" class="form-control" id="qty_free_akhir" required name="qty_free_akhir" value='<?= $mat->qty_free_akhir ?>' placeholder="Kode Barang">
              </div>
            </div>
			
          </div>
        </div>
      </div>
      <hr>
      <center>
        <button type="submit" class="btn btn-success btn-sm" name="save" id="simpan-com">
          <i class="fa fa-save"></i> Simpan </button>
      </center>
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
                var baseurl = siteurl + 'stock_material/saveEditKartustok';
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
        data:"id_type="+id_type+"&inventory_2="+id_category1,
        success: function(html) {
            $("#id_category2").html(html);
        }
    });
}

</script>
