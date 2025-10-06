<?php
    $ENABLE_ADD     = has_permission('Master_karyawan.Add');
    $ENABLE_MANAGE  = has_permission('Master_karyawan.Manage');
    $ENABLE_VIEW    = has_permission('Master_karyawan.View');
    $ENABLE_DELETE  = has_permission('Master_karyawan.Delete');
	foreach ($results['karyawan'] as $karyawan){
}	

?>
<style type="text/css">
thead input {
	width: 100%;
}
</style>
<link rel="stylesheet" href="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.css')?>">
<link rel="stylesheet" href="<?= base_url('assets/plugins/sweetalert/dist/sweetalert.css')?>">

          <div class="box box-primary">
            <div class="box-body">
			
			<form id="data_form">
				<div class="row">
						<input type="hidden" name="id_karyawan" id="id_karyawan" value='<?= $karyawan->id_karyawan ?>'>
					<div class="col-md-12">
			<div class="form-group row">
							<div class="col-md-2">
							  <label for="">Id Number</label>
							</div>
							 <div class="col-md-6">
							  <input type="text" class="form-control" id="nik" required name="nik" maxlength="16" value="<?= $karyawan->nik ?>" placeholder="ID Number">
							</div>
			</div>
			<div class="form-group row">
								<div class="col-md-2">
							  <label for="">Employee Name</label>
							</div>
							 <div class="col-md-6">
							  <input type="text" class="form-control" id="nama_karyawan" required name="nama_karyawan" value="<?= $karyawan->nama_karyawan ?>" placeholder="Employee Name">
							</div>
			</div>
			<div class="form-group row">
							<div class="col-md-2">
							  <label for="">Birth Place And Date</label>
							</div>
							 <div class="col-md-6">
							  <input type="text" class="form-control" id="tempat_lahir_karyawan" required name="tempat_lahir_karyawan" value="<?= $karyawan->tempat_lahir_karyawan ?>" placeholder="Birth Place">
							  <input type="date" class="form-control" id="tanggal_lahir_karyawan" required name="tanggal_lahir_karyawan" value="<?= $karyawan->tanggal_lahir_karyawan ?>" placeholder="Employee Name">
							</div>
			</div>
			<div class="form-group row">
							<div class="col-md-2">
							  <label for="">Division</label>
							</div>
							 <div class="col-md-6">
						<select id="divisi" name="divisi" class="form-control input-sm" required>
						<option value="">-- Divisi --</option>
						<?php foreach ($results['divisi'] as $divisi){
						$select = $karyawan->divisi == $divisi->id ? 'selected' : '';
						?>
						<option value="<?= $divisi->id?>" <?= $select ?>><?= $divisi->cost_center?></option>
						<?php } ?>
					  </select>
							</div>
			</div>
			<div class="form-group row">
							<div class="col-md-2">
							  <label for="">Gender</label>
							</div>
							 <div class="col-md-6">
						<select id="gender" name="gender"  class="form-control input-sm" required>
						<?php if ($karyawan->jenis_kelamin == 'L'){?>
						<option value="L" selected>Laki-Laki</option>
						<option value="P" >Perempuan</option>
						<?php } else { ?>
						<option value="L">Laki-Laki</option>
						<option value="P" selected>Perempuan</option>
						<?php } ?>
					  </select>
							</div>
			</div>
			<div class="form-group row">
							<div class="col-md-2">
							  <label for="">Agama</label>
							</div>
							 <div class="col-md-6">
						<select id="agama" name="agama"  class="form-control input-sm" required>
						<option value="">-- Pilih Agama --</option>
						<?php foreach ($results['agama'] as $agama){
						$select = $karyawan->agama == $agama->id ? 'selected' : '';
						?>
						<option value="<?= $agama->id?>" <?= $select ?>><?= $agama->name_religion?></option>
						<?php } ?>
					  </select>
							</div>
			</div>
			<div class="form-group row">
							<div class="col-md-2">
							  <label for="">Education</label>
							</div>
							 <div class="col-md-6">
						<select id="levelpendidikan" name="levelpendidikan"  class="form-control input-sm" required>
						<?php if ($karyawan->levelpendidikan == 'SD'){?>
						<option value="SD" selected>SD</option>
						<option value="SMP">SMP</option>
						<option value="SMA">SMA</option>
						<option value="DIPLOMA">DIPLOMA</option>
						<option value="SARJANA">SARJANA</option>
						<option value="MASTER">MASTER</option>
						<option value="DOKTORAL">DOKTORAL</option>
						<option value="PROFESOR">PROFESOR</option>
						<option value="LAIN-LAIN">LAIN-LAIN</option>
						<?php } elseif ($karyawan->levelpendidikan == 'SMP'){?>
						<option value="SD">SD</option>
						<option value="SMP" selected>SMP</option>
						<option value="SMA">SMA</option>
						<option value="DIPLOMA">DIPLOMA</option>
						<option value="SARJANA">SARJANA</option>
						<option value="MASTER">MASTER</option>
						<option value="DOKTORAL">DOKTORAL</option>
						<option value="PROFESOR">PROFESOR</option>
						<option value="LAIN-LAIN">LAIN-LAIN</option>
						<?php } elseif ($karyawan->levelpendidikan == 'SMA'){?>
						<option value="SD" >SD</option>
						<option value="SMP">SMP</option>
						<option value="SMA" selected>SMA</option>
						<option value="DIPLOMA">DIPLOMA</option>
						<option value="SARJANA">SARJANA</option>
						<option value="MASTER">MASTER</option>
						<option value="DOKTORAL">DOKTORAL</option>
						<option value="PROFESOR">PROFESOR</option>
						<option value="LAIN-LAIN">LAIN-LAIN</option>
						<?php } elseif ($karyawan->levelpendidikan == 'DIPLOMA'){?>
						<option value="SD" >SD</option>
						<option value="SMP">SMP</option>
						<option value="SMA" >SMA</option>
						<option value="DIPLOMA" selected>DIPLOMA</option>
						<option value="SARJANA">SARJANA</option>
						<option value="MASTER">MASTER</option>
						<option value="DOKTORAL">DOKTORAL</option>
						<option value="PROFESOR">PROFESOR</option>
						<option value="LAIN-LAIN">LAIN-LAIN</option>
						<?php } elseif ($karyawan->levelpendidikan == 'SARJANA'){?>
						<option value="SD" >SD</option>
						<option value="SMP">SMP</option>
						<option value="SMA" >SMA</option>
						<option value="DIPLOMA">DIPLOMA</option>
						<option value="SARJANA" selected>SARJANA</option>
						<option value="MASTER">MASTER</option>
						<option value="DOKTORAL">DOKTORAL</option>
						<option value="PROFESOR">PROFESOR</option>
						<option value="LAIN-LAIN">LAIN-LAIN</option>
						<?php } elseif ($karyawan->levelpendidikan == 'MASTER'){?>
						<option value="SD" >SD</option>
						<option value="SMP">SMP</option>
						<option value="SMA" >SMA</option>
						<option value="DIPLOMA">DIPLOMA</option>
						<option value="SARJANA">SARJANA</option>
						<option value="MASTER">MASTER</option>
						<option value="DOKTORAL">DOKTORAL</option>
						<option value="PROFESOR">PROFESOR</option>
						<option value="LAIN-LAIN">LAIN-LAIN</option>
						<?php } elseif ($karyawan->levelpendidikan == 'DOKTORAL'){?>
						<option value="SD" >SD</option>
						<option value="SMP">SMP</option>
						<option value="SMA" >SMA</option>
						<option value="DIPLOMA">DIPLOMA</option>
						<option value="SARJANA">SARJANA</option>
						<option value="MASTER" selected>MASTER</option>
						<option value="DOKTORAL" selected>DOKTORAL</option>
						<option value="PROFESOR">PROFESOR</option>
						<option value="LAIN-LAIN">LAIN-LAIN</option>
						<?php } elseif ($karyawan->levelpendidikan == 'PROFESOR'){?>
						<option value="SD" >SD</option>
						<option value="SMP">SMP</option>
						<option value="SMA" >SMA</option>
						<option value="DIPLOMA">DIPLOMA</option>
						<option value="SARJANA">SARJANA</option>
						<option value="MASTER">MASTER</option>
						<option value="DOKTORAL">DOKTORAL</option>
						<option value="PROFESOR" selected>PROFESOR</option>
						<option value="LAIN-LAIN">LAIN-LAIN</option>
						<?php } else { ?>
						<option value="SD" >SD</option>
						<option value="SMP">SMP</option>
						<option value="SMA" >SMA</option>
						<option value="DIPLOMA">DIPLOMA</option>
						<option value="SARJANA">SARJANA</option>
						<option value="MASTER">MASTER</option>
						<option value="DOKTORAL">DOKTORAL</option>
						<option value="PROFESOR">PROFESOR</option>
						<option value="LAIN-LAIN" selected>LAIN-LAIN</option>
						<?php } ?>
					  </select>
							</div>
			</div>
			<div class="form-group row">
								<div class="col-md-2">
							  <label for="">Address</label>
							</div>
							 <div class="col-md-6">
							  <textarea type="text" class="form-control" id="alamataktif"  name="alamataktif" placeholder="Alamat"><?= $karyawan->alamataktif ?></textarea>
							</div>
			</div>
						<div class="form-group row">
								<div class="col-md-2">
							  <label for="">No. Hp</label>
							</div>
							 <div class="col-md-6">
							   <input type="text" class="form-control" id="nohp" required name="nohp"  value="<?= $karyawan->nohp ?>" placeholder="No Hp">
							</div>
			</div>
						<div class="form-group row">
								<div class="col-md-2">
							  <label for="">Email</label>
							</div>
							 <div class="col-md-6">
								<input type="email" class="form-control" id="email" required name="email"  value="<?= $karyawan->email ?>" placeholder="email@domain">
							</div>
			</div>
						<div class="form-group row">
								<div class="col-md-2">
							  <label for="">NPWP</label>
							</div>
							 <div class="col-md-6">
								 <input type="text" class="form-control" id="npwp" required name="npwp"  value="<?= $karyawan->npwp ?>" placeholder="No NPWP">
							</div>
			</div>
			<div class="form-group row">
								<div class="col-md-2">
							  <label for="">Join Date</label>
							</div>
							 <div class="col-md-6">
								 <input type="date" class="form-control" id="tgl_join" required name="tgl_join"  value="<?= $karyawan->tgl_join ?>" placeholder="No NPWP">
							</div>
			</div>
			<div class="form-group row">
								<div class="col-md-2">
							  <label for=""></label>
							</div>
							 <div class="col-md-6">
								 <input type="date" class="form-control" id="tgl_end" required name="tgl_end"  value="<?= $karyawan->tgl_end ?>" placeholder="No NPWP">
							</div>
			</div>
			<div class="form-group row">
			<div class="col-md-2">
							  <label for="">Employee Status</label>
							</div>
							 <div class="col-md-6">
						<select id="sts_karyawan" name="sts_karyawan"  class="form-control input-sm" required>
						<option value="">-- Pilih Type --</option>
						<?php if ($karyawan->sts_karyawan == 'Kontrak'){?>
						<option value="Kontrak" selected>Kontrak</option>
						<option value="Tetap">Tetap</option>
						<?php } else { ?>
						<option value="Kontrak">Kontrak</option>
						<option value="Tetap" selected>Tetap</option>
						<?php } ?>
					  </select>
							</div>
			</div>
			<div class="form-group row">
				<div class="col-md-2">
							  <label for="">Rekening</label>
							</div>
							 <div class="col-md-6">
								 <input type="text" class="form-control" id="norekening" required name="norekening" value="<?= $karyawan->norekening ?>" placeholder="No Rekening">
							</div>
			</div>
			<div class="form-group row">
				<div class="col-md-2">
							  <label for="">Tanda Tangan</label>
							</div>
							 <div class="col-md-6">
								 <input type="file" class="form-control" id="tanda_tangan" required name="tanda_tangan" placeholder="Tanda tangan">
								 
								 <input type="hidden" class="form-control" id="old_tanda_tangan" required name="old_tanda_tangan" value="tes" placeholder="Tanda tangan">
							</div>
			</div>
			
			<div class="form-group row">
			<div class="col-md-3">
			<button type="submit" class="btn btn-primary" name="save" id="simpan-com"><i class="fa fa-save"></i> Save</button>
			</div>
			</div>
					</div>
				</div>
				
			</form>
        </div>

<!-- Modal Bidus-->
<script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.min.js')?>"></script>
<script src="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.min.js')?>"></script>
<script src="<?= base_url('assets/plugins/sweetalert/dist/sweetalert.js')?>"></script>
<!-- End Modal Bidus-->

<script type="text/javascript">

  $(document).ready(function() {
	  
	$('.select2').select2();
    
	
	$('#simpan-com').click(function(e){
			e.preventDefault();
			var deskripsi	= $('#deskripsi').val();
			var image_labels	= $('#image_labels').val();
			var image_packing	= $('#image_packing').val();
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
				},
				function(isConfirm) {
				  if (isConfirm) {
						var formData 	=new FormData($('#data_form')[0]);
						var baseurl=siteurl+'master_karyawan/saveEditKaryawan';
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
									window.location.reload(true);
								}else{
									
									if(data.status == 2){
										swal({
										  title	: "Save Failed!",
										  text	: data.pesan,
										  type	: "warning",
										  timer	: 7000,
										  showCancelButton	: false,
										  showConfirmButton	: false,
										  allowOutsideClick	: false
										});
									}else{
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
   
  });

  

</script>
