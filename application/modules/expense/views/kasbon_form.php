<?=form_open($this->uri->uri_string(),array('id'=>'frm_data','name'=>'frm_data','role'=>'form','class'=>'form-horizontal','enctype'=>'multipart/form-data'));?>
<?php
$dept='';$bank_id='';$accnumber='';$accname='';
if(!isset($data->departement)){
	$datauser = $this->db->get_where('users', ['username' => $this->auth->user_name()])->row();
	$datadept = $this->db->get_where('employees', ['id' => $datauser->employee_id])->row();
	if(!empty($datadept)) {
		$dept=$datadept->department_id;$bank_id=$datadept->bank_id;$accnumber=$datadept->accnumber;$accname=$datadept->accname;
	}
}

?>
<input type="hidden" id="id" name="id" value="<?php echo set_value('id', isset($data->id) ? $data->id : ''); ?>">
<input type="hidden" id="departement" name="departement" value="<?php echo (isset($data->departement) ? $data->departement: $dept); ?>">
<input type="hidden" id="nama" name="nama" value="<?php echo (isset($data->nama) ? $data->nama: $this->auth->user_name() ); ?>">

<div class="tab-content">
	<div class="tab-pane active">
		<div class="box box-primary">
			<div class="box-body">
				<div class="form-group ">
					<label class="col-sm-2 control-label">No Dokumen</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="no_doc" name="no_doc" value="<?php echo (isset($data->no_doc) ? $data->no_doc: ""); ?>" placeholder="Automatic" readonly>
					</div>
					<label class="col-sm-2 control-label">Tanggal <b class="text-red">*</b></label>
					<div class="col-sm-4">
						<input type="text" class="form-control tanggal" id="tgl_doc" name="tgl_doc" value="<?php echo (isset($data->tgl_doc) ? $data->tgl_doc: date("Y-m-d")); ?>" placeholder="Tanggal Dokumen" required>
					</div>
				</div>
				<div class="form-group ">
					<label class="col-sm-2 control-label">Keperluan</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="keperluan" name="keperluan" value="<?php echo (isset($data->keperluan) ? $data->keperluan: ''); ?>" placeholder="Keperluan" required>
					</div>
					<label class="col-sm-2 control-label">Jumlah Kasbon</label>
					<div class="col-sm-4">
						<input type="text" class="form-control divide" id="jumlah_kasbon" name="jumlah_kasbon" value="<?php echo (isset($data->jumlah_kasbon) ? $data->jumlah_kasbon: '0'); ?>" placeholder="jumlah_kasbon">
					</div>
				</div>
				<div class="form-group ">
					<label class="col-sm-2 control-label">Project</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="project" name="project" value="<?php echo (isset($data->project) ? $data->project: ''); ?>" placeholder="Project">
					</div>
					<label class="col-sm-2 control-label">Keterangan</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="keterangan" name="keterangan" value="<?php echo (isset($data->keterangan) ? $data->keterangan: ''); ?>" placeholder="Keterangan" required>

					<?php
					if(isset($data->st_reject)){
						if($data->st_reject!=''){
							echo '
							  <div class="alert alert-danger alert-dismissible">
								<h4><i class="icon fa fa-ban"></i> Alasan Penolakan!</h4>
								'.$data->st_reject.'
							  </div>';
						}
					}
					?>
					</div>
				</div>
				<div class="form-group ">
					<label class="col-sm-2 control-label">Dokumen 1</label>
					<div class="col-sm-4">
						<input type="hidden" name="filename" id="filename" value="<?=(isset($data->doc_file)?$data->doc_file:'');?>">
						<input type="file" name="doc_file" id="doc_file">
						<span class="pull-right"><?php
						if(isset($data->doc_file)){
							echo ($data->doc_file!=''?'<a href="'.base_url('assets/expense/'.$data->doc_file).'" download target="_blank"><i class="fa fa-download"></i></a>':'');
						}
						?>
						</span>
					</div>
					<label class="col-sm-2 control-label">Dokumen 2</label>
					<div class="col-sm-4">
						<input type="hidden" name="filename2" id="filename2" value="<?=(isset($data->doc_file_2)?$data->doc_file_2:'');?>">
						<input type="file" name="doc_file_2" id="doc_file_2">
						<span class="pull-right"><?php
						if(isset($data->doc_file_2)){
							echo ($data->doc_file_2!=''?'<a href="'.base_url('assets/expense/'.$data->doc_file_2).'" download target="_blank"><i class="fa fa-download"></i></a>':'');
						}
						?>
						</span>
					</div>
				</div>

				<h4>Transfer ke</h4>
				<div class="form-group ">
					<label class="col-md-1 control-label">Bank</label>
					<div class="col-md-2">
						<input type="text" class="form-control" id="bank_id" name="bank_id" value="<?php echo (isset($data->bank_id) ? $data->bank_id: $bank_id); ?>" placeholder="Bank">
					</div>
					<label class="col-md-2 control-label">Nomor Rekening</label>
					<div class="col-md-2">
						<input type="text" class="form-control" id="accnumber" name="accnumber" value="<?php echo (isset($data->accnumber) ? $data->accnumber: $accnumber); ?>" placeholder="Nomor Rekening">
					</div>
					<label class="col-md-2 control-label">Nama Rekening</label>
					<div class="col-md-3">
						<input type="text" class="form-control" id="accname" name="accname" value="<?php echo (isset($data->accname) ? $data->accname: $accname); ?>" placeholder="Nama Pemilik Rekening">
					</div>
				</div>
			</div>
			<div class="box-footer">
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<?php
						if(isset($data)){
							if(($data->status==0 || $data->status==1)&& $stsview==''){
								if(($mod=='_fin' || $mod=='_mgt')){
									echo '<a class="btn btn-primary btn-sm" href="#" id="approve" onclick="data_approve('.$data->id.','.($data->status+1).')"><i class="fa fa-check-square-o"></i> Approve</a>';
									echo ' <a class="btn btn-danger btn-sm" onclick="data_reject()"><i class="fa fa-ban">&nbsp;</i> Reject</a>';
									$stsview='view';
								}
							}
						}
						?>
						<button type="submit" name="save" class="btn btn-success btn-sm stsview" id="submit"><i class="fa fa-save">&nbsp;</i>Simpan</button>
						<a class="btn btn-default btn-sm" onclick="window.location=siteurl+'expense/kasbon<?=$mod?>';return false;"><i class="fa fa-reply"></i> Batal</a>
					</div>
				</div>
			<?php
			if(isset($data)){
				if($data->doc_file!=''){
					 if(strpos($data->doc_file,'pdf',0)>1){
						 echo '<div class="col-md-12">
						<iframe src="'.base_url('assets/expense/'.$data->doc_file).'#toolbar=0&navpanes=0" title="PDF" style="width:600px; height:500px;" frameborder="0">
								 <a href="'.base_url('assets/expense/'.$data->doc_file).'">Download PDF</a>
						</iframe>
						<br />'.$data->no_doc.'</div>';
					 }else{
						echo '<div class="col-md-12"><a href="'.base_url('assets/expense/'.$data->doc_file).'" target="_blank"><img src="'.base_url('assets/expense/'.$data->doc_file).'" class="img-responsive"></a><br />'.$data->no_doc.'</div>';
					 }
				}
				if($data->doc_file_2!=''){
					 if(strpos($data->doc_file_2,'pdf',0)>1){
						 echo '<div class="col-md-12">
						<iframe src="'.base_url('assets/expense/'.$data->doc_file_2).'#toolbar=0&navpanes=0" title="PDF" style="width:600px; height:500px;" frameborder="0">
								 <a href="'.base_url('assets/expense/'.$data->doc_file_2).'">Download PDF</a>
						</iframe>
						<br />'.$data->no_doc.'</div>';
					 }else{
						echo '<div class="col-md-12"><a href="'.base_url('assets/expense/'.$data->doc_file_2).'" target="_blank"><img src="'.base_url('assets/expense/'.$data->doc_file_2).'" class="img-responsive"></a><br />'.$data->no_doc.'</div>';
					 }
				}
			}
			?>
			</div>
		</div>
	</div>
</div>
<?= form_close() ?>
<script src="<?= base_url('assets/js/number-divider.min.js')?>"></script>
<script type="text/javascript">
	var url_save = siteurl+'expense/kasbon_save/';
	var url_approve = siteurl+'expense/kasbon_approve/';
	$('.divide').divide();
    $('#frm_data').on('submit', function(e){
        e.preventDefault();
		var errors="";
		if($("#filename").val()==""){
			if ($('#doc_file').get(0).files.length === 0) {
					errors="Dokumen 1 harus diupload";
				}
		}
		if($("#jumlah_kasbon").val()=="0") errors="Jumlah Kasbon tidak boleh kosong";
		if($("#keperluan").val()=="") errors="keperluan tidak boleh kosong";
		if($("#tgl_doc").val()=="") errors="Tanggal Transaksi tidak boleh kosong";
		if(errors==""){
		swal({
		  title: "Anda Yakin?",
		  text: "Data Akan Disimpan!",
		  type: "info",
		  showCancelButton: true,
		  confirmButtonText: "Ya, simpan!",
		  cancelButtonText: "Tidak!",
		  closeOnConfirm: false,
		  closeOnCancel: true
		},
		function(isConfirm){
		  if (isConfirm) {
			var formdata = new FormData($('#frm_data')[0]);
			$.ajax({
				url: url_save,
				dataType : "json",
				type: 'POST',
				data: formdata,
				processData	: false,
				contentType	: false,
				success: function(msg){
					if(msg['save']=='1'){
						swal({
							title: "Sukses!",
							text: "Data Berhasil Di Simpan",
							type: "success",
							timer: 1500,
							showConfirmButton: false
						});
						window.location=siteurl+'expense/kasbon';
					} else {
						swal({
							title: "Gagal!",
							text: "Data Gagal Di Simpan",
							type: "error",
							timer: 1500,
							showConfirmButton: false
						});
					};
					console.log(msg);
				},
				error: function(msg){
					swal({
						title: "Gagal!",
						text: "Ajax Data Gagal Di Proses",
						type: "error",
						timer: 1500,
						showConfirmButton: false
					});
					console.log(msg);
				}
			});
		  }
		});

//			data_save();
		}else{
			swal(errors);
			return false;
		}
    });
	<?php if(isset($stsview)){
		if($stsview=='view'){
			?>
			$(".stsview").addClass("hidden");
			$("#frm_data :input").prop("disabled", true);
			<?php
		}
	}?>
	$(function () {
		$(".tanggal").datepicker({
			todayHighlight: true,
			format : "yyyy-mm-dd",
			showInputs: true,
			autoclose:true
		});
	});

	function data_approve(){
		swal({
		  title: "Anda Yakin?",
		  text: "Data Akan Diupdate!",
		  type: "info",
		  showCancelButton: true,
		  confirmButtonText: "Ya, setuju!",
		  cancelButtonText: "Tidak!",
		  closeOnConfirm: false,
		  closeOnCancel: true
		},
		function(isConfirm){
		  if (isConfirm) {
			id=$("#id").val();
			$.ajax({
				url: url_approve+id,
				dataType : "json",
				type: 'POST',
				success: function(msg){
					if(msg['save']=='1'){
						swal({
							title: "Sukses!",
							text: "Data Berhasil Di Update",
							type: "success",
							timer: 1500,
							showConfirmButton: false
						});
						window.location=siteurl+'expense/kasbon<?=$mod?>';
					} else {
						swal({
							title: "Gagal!",
							text: "Data Gagal Di Update",
							type: "error",
							timer: 1500,
							showConfirmButton: false
						});
					};
					console.log(msg);
				},
				error: function(msg){
					swal({
						title: "Gagal!",
						text: "Ajax Data Gagal Di Proses",
						type: "error",
						timer: 1500,
						showConfirmButton: false
					});
					console.log(msg);
				}
			});
		  }
		});
	}
	function data_reject(){
		swal({
			title: "Perhatian",
			text: "Berikan alasan penolakan",
			type: "input",
			showCancelButton: true,
			closeOnConfirm: false,
			closeOnCancel: true },
			function(inputValue){
				 if (inputValue === false) return false;
				 if (inputValue === "") {
					swal.showInputError("Tuliskan alasan anda");
					return false
				}

				swal({
				  title: "Anda Yakin?",
				  text: "Data Akan Tolak!",
				  type: "warning",
				  showCancelButton: true,
				  confirmButtonText: "Ya, tolak!",
				  cancelButtonText: "Tidak!",
				  closeOnConfirm: false,
				  closeOnCancel: true
				},
				function(isConfirm){
				  if (isConfirm) {
					id=$("#id").val();
					$.ajax({
						url: base_url+'expense/reject/',
						data: {'id':id,'reason':inputValue,'table':'tr_kasbon'},
						dataType : "json",
						type: 'POST',
						success: function(msg){
							if(msg['save']=='1'){
								swal({
									title: "Sukses!",
									text: "Data Berhasil Di Tolak",
									type: "success",
									timer: 1500,
									showConfirmButton: false
								});
								window.location=siteurl+'expense/kasbon<?=$mod?>'
							} else {
								swal({
									title: "Gagal!",
									text: "Data Gagal Di Tolak",
									type: "error",
									timer: 1500,
									showConfirmButton: false
								});
							};
							console.log(msg);
						},
						error: function(msg){
							swal({
								title: "Gagal!",
								text: "Ajax Data Gagal Di Proses",
								type: "error",
								timer: 1500,
								showConfirmButton: false
							});
							console.log(msg);
						}
					});
				  }
				});

			 });
	}	
</script>
