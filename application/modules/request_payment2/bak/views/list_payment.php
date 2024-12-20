<?php
    $ENABLE_ADD     = has_permission('Payment.Add');
    $ENABLE_MANAGE  = has_permission('Payment.Manage');
    $ENABLE_VIEW    = has_permission('Payment.View');
    $ENABLE_DELETE  = has_permission('Payment.Delete');
?>
<script src="//cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>
<div id="alert_edit" class="alert alert-success alert-dismissable" style="padding: 15px; display: none;"></div>
<?=form_open($this->uri->uri_string(),array('id'=>'frm_data','name'=>'frm_data','role'=>'form','class'=>'form-horizontal'));?>
<div class="box">
	<div class="box-body">
		<div class="row">
			<div class="col-md-2">Bank : </div>
			<div class="col-md-6">
			<?php
			echo form_dropdown('bank_coa',$data_coa, '',array('id'=>'bank_coa','required'=>'required','class'=>'form-control'));
			?>
			</div>
		</div><br />
		<div class="table-responsive">
		<table id="mytabledata" class="table table-bordered">
		<thead>
		<tr>
			<th width="5">#</th>
			<th class="exclass">No Dokumen</th>
			<th>Request By</th>
			<th class="exclass">Tanggal</th>
			<th>Keperluan</th>
			<th class="exclass">Tipe</th>
			<th>Info Transfer</th>
			<th>Nilai Pengajuan</th>
			<th class="exclass">Tanggal Pembayaran</th>
			<th class="exclass">Keterangan</th>
			<th class="exclass">Payment</th>
			<th class="exclass">Administrasi</th>
			<th class="exclass">Dokumen</th>
		</tr>
		</thead>
		<tbody>
		<?php
		if(!empty($results)){
			$numb=0; foreach($results AS $record){ $numb++; ?>
		<tr>
		    <td><?= $numb; ?></td>
			<td class="exclass"><?= $record->no_doc ?></td>
			<td><?= $record->nama ?></td>
			<td class="exclass"><?= $record->tgl_doc ?></td>
			<td><?= $record->keperluan ?></td>
			<td class="exclass"><?= $record->tipe ?></td>
			<td>Bank : <?= $record->bank_id ?><br />
			Nomor : <?= $record->accnumber ?><br />
			Nama : <?= $record->accname ?><br /></td>
			<td><?= number_format($record->jumlah) ?></td>			
			<td class="exclass"><?=$record->tanggal?></td>
			<?php if($ENABLE_MANAGE)  : ?>
				<td class="exclass"><input type="hidden" name="status[]" id="status<?=$numb?>" value="<?=$record->id?>">
				<input type="hidden" name="no_doc[]" id="no_doc<?=$numb?>" value="<?=$record->no_doc?>">
				<input type="hidden" name="ids[]" id="ids<?=$numb?>" value="<?=$record->ids?>">
				<input type="hidden" name="keperluan[]" id="keperluan<?=$numb?>" value="<?=$record->keperluan?>">
				<input type="hidden" name="tipe[]" id="tipe<?=$numb?>" value="<?=$record->tipe?>">
				<input type="hidden" name="nama[]" id="nama<?=$numb?>" value="<?=$record->nama?>">
				<input type="text" name="keterangan[]" class="form-control" id="keterangan<?=$numb?>" value="<?=$record->keterangan?>"></td>
				<td class="exclass"><input type="text" name="bank_nilai[]" class="form-control divide" id="bank_nilai<?=$numb?>" value="<?=$record->bank_nilai?>"></td>
				<td class="exclass"><input type="text" name="bank_admin[]" class="form-control divide" id="bank_admin<?=$numb?>" value="<?=$record->bank_admin?>"></td>
				<td class="exclass"><input type="file" name="doc_file_<?=$record->id?>" id="doc_file<?=$numb?>" /></td>
			<?php endif; ?>
		</tr>
		<?php
			}
		}  ?>
		</tbody>
		</table>
		<div class="pull-right"><button type="submit" name="save" class="btn btn-success btn-sm" id="submit"><i class="fa fa-save">&nbsp;</i>Update</button></div>
		</div>
	</div>
	<div> &nbsp;<button type="button" id="btnxls" class="btn btn-default">Export Excel</button><br /><br /></div>	
	<!-- /.box-body -->
</div>
<?= form_close() ?>
<script src="<?= base_url('assets/js/number-divider.min.js')?>"></script>
<script type="text/javascript">
	var url_save = siteurl+'request_payment/save_payment/';
	$('.divide').divide();
	//Save
    $('#frm_data').on('submit', function(e){
        e.preventDefault();
		var errors="";
		if($("#bank_coa").val()=="0") errors="Bank tidak boleh kosong";
		if(errors==""){
		swal({
		  title: "Anda Yakin?",
		  text: "Data Akan Di Update!",
		  type: "info",
		  showCancelButton: true,
		  confirmButtonText: "Ya, Update!",
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
							text: "Data Berhasil Di Update",
							type: "success",
							timer: 1500,
							showConfirmButton: false
						});
						window.location.reload();
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
		}else{
			swal(errors);
			return false;
		}
    });
$("#btnxls").click(function(){
	$("#mytabledata").table2excel({
		exclude: ".exclass",
		name: "Weekly Budget",
		filename: "WeeklyBudget.xls", // do include extension
		preserveColors: false // set to true if you want background colors and font colors preserved
	});	
});
</script>
