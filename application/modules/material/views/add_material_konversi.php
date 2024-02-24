<?php
    $ENABLE_ADD     = has_permission('Inventory_5.Add');
    $ENABLE_MANAGE  = has_permission('Inventory_5.Manage');
    $ENABLE_VIEW    = has_permission('Inventory_5.View');
    $ENABLE_DELETE  = has_permission('Inventory_5.Delete');
?>
</style>
<link rel="stylesheet" href="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.css')?>">
<link rel="stylesheet" href="<?= base_url('assets/plugins/sweetalert/dist/sweetalert.css')?>">
		
<div class="box box-primary">
	<!-- /.box-header -->
	<div class="box-body">
	<div id="data_material" >
		<form id="data_form">
		<div class="row">
		<div id="input1">
			<div class="col-md-12">			    
                <div class="col-md-5">
				<div class="form-group row">
					<div class="col-md-4">
					  <label for="material">Nama Material</label>
					</div>
					 <div class="col-md-8">
					  <select id="material" name="material"  class="form-control input-sm" required>
						<option value="">-- Pilih Type --</option>
						<?php foreach ($results['material'] as $material){ 
						?>
						<option value="<?= $material->id_material?>"><?= ucfirst(strtolower($material->nama))?></option>
						<?php } ?>
					  </select>
					 </div>
				</div>
				</div>
				<div class="col-md-5">
			    <div class="form-group row">
					<div class="col-md-4">
					  <label for="">Nama Satuan</label>
					</div>
					<div class="col-md-8">
					   <select id="satuan" name="satuan"  class="form-control input-sm" required>
						<option value="">-- Pilih Type --</option>
						<?php foreach ($results['satuan'] as $satuan){ 
						?>
						<option value="<?= $satuan->nama?>"><?= ucfirst(strtolower($satuan->nama))?></option>
						<?php } ?>
					  </select>
					  </div>
				</div>
				</div>
                <div class="col-md-5">
				<div class="form-group row">
					<div class="col-md-4">
					  <label for="">Nilai Konversi</label>
					</div>
					 <div class="col-md-8">
					  <input type="text" class="form-control input-sm" id="konversi"  name="konversi" placeholder="Nilai Konversi" value="" required>
					</div>
				</div>
				</div>
                <div class="col-md-5">
			    <div class="form-group row">
					<div class="col-md-4">
					  <label for="">Satuan Konversi</label>
					</div>
					<div class="col-md-8">
					   <select id="satuan_konversi" name="satuan_konversi"  class="form-control input-sm" required>
						<option value="">-- Pilih Type --</option>
						<?php foreach ($results['satuan'] as $satuan){ 
						?>
						<option value="<?= $satuan->nama?>"><?= ucfirst(strtolower($satuan->nama))?></option>
						<?php } ?>
					  </select>
					  </div>
				</div>
				</div>				
					
			
		</div>
		</div>
	   
	<hr>
	<center>
	<button type="submit" class="btn btn-success btn-sm" name="save" id="save"><i class="fa fa-save"></i>Simpan</button>
	<button type="reset" class="btn btn-danger btn-sm"><i class="fa fa-close"></i> Reset</button>
	<a class="btn btn-warning btn-sm" href="<?= base_url('inventory_5') ?>" title="Back"> <i class="fa fa-reply">&nbsp;</i>Back</a>
	</center>
	</form>
	</div>
	</div>
	<!-- /.box-body -->
</div>


<!-- Modal Bidus-->
<script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.min.js')?>"></script>
<script src="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.min.js')?>"></script>
<script src="<?= base_url('assets/plugins/sweetalert/dist/sweetalert.js')?>"></script>
<!-- End Modal Bidus-->

<script type="text/javascript">

  $(document).ready(function() {
	$('.select2').select2();
	$("#inventory_1").change(function(){

            // variabel dari nilai combo box kendaraan
            var inventory_1 = $("#inventory_1").val();

            // Menggunakan ajax untuk mengirim dan dan menerima data dari server
            $.ajax({
                url:siteurl+'inventory_5/get_inven2',
                method : "POST",
                data : {inventory_1:inventory_1},
                async : false,
                dataType : 'json',
                success: function(data){
                    var html = '';
                    var i;

                    for(i=0; i<data.length; i++){
                        html += '<option value='+data[i].id_category1+'>'+data[i].nama+'</option>';
                    }
                    $('#inventory_2').html(html);

                }
            });
        });
	
	$("#inventory_2").change(function(){

            // variabel dari nilai combo box kendaraan
            var inventory_2 = $("#inventory_2").val();

            // Menggunakan ajax untuk mengirim dan dan menerima data dari server
            $.ajax({
                url:siteurl+'inventory_5/get_inven3',
                method : "POST",
                data : {inventory_2:inventory_2},
                async : false,
                dataType : 'json',
                success: function(data){
                    var html = '';
                    var i;

                    for(i=0; i<data.length; i++){
                        html += '<option value='+data[i].id_category2+'>'+data[i].nama+'</option>';
                    }
                    $('#inventory_3').html(html);

                }
            });
        });
	
	$("#inventory_3").change(function(){

            // variabel dari nilai combo box kendaraan
            var inventory_3 = $("#inventory_3").val();

            // Menggunakan ajax untuk mengirim dan dan menerima data dari server
            $.ajax({
                url:siteurl+'inventory_5/get_inven4',
                method : "POST",
                data : {inventory_3:inventory_3},
                async : false,
                dataType : 'json',
                success: function(data){
                    var html = '';
                    var i;

                    for(i=0; i<data.length; i++){
                        html += '<option value='+data[i].id_category3+'>'+data[i].nama+'</option>';
                    }
                    $('#inventory_4').html(html);

                }
            });
        });
    $(document).on('submit', '#data_form', function(e){
		e.preventDefault()
		var data = $('#data_form').serialize();
		// alert(data);

		swal({
		  title: "Anda Yakin?",
		  text: "Data Material akan di simpan.",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonClass: "btn-info",
		  confirmButtonText: "Ya, Simpan!",
		  cancelButtonText: "Batal",
		  closeOnConfirm: false
		},
		function(){
		  $.ajax({
			  type:'POST',
			  url:siteurl+'material/saveNewKonversi',
			  dataType : "json",
			  data:data,
			  success:function(result){
				  if(result.status == '1'){
					 swal({
						  title: "Sukses",
						  text : "Data Konversi berhasil disimpan.",
						  type : "success"
						},
						function (){
							window.location.reload(true);
						})
				  } else {
					swal({
					  title : "Error",
					  text  : "Data error. Gagal insert data",
					  type  : "error"
					})
					
				  }
			  },
			  error : function(){
				swal({
					  title : "Error",
					  text  : "Data error. Gagal request Ajax",
					  type  : "error"
					})
			  }
		  })
		});
		
	})
   
  });

  

</script>
