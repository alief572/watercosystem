<?php
?>
<div class="nav-tabs-area">
    <div class="tab-content">
        <div class="tab-pane active" id="area">
            <div id='alert_edit' class="alert alert-success alert-dismissable" style="padding: 15px; display: none;"></div>
            <div class="box box-primary">
            <?= form_open(base_url().'asset/save_out',array('id'=>'frm_data','name'=>'frm_data','role'=>'form','class'=>'form-horizontal')) ?>
				<?php  if(isset($data)){$type='edit';}?>
                <div class="box-body">
					<div class="form-group ">
					   <label for="tgl_terima_invoice" class="col-sm-2 control-label">Tgl</label>
						<div class="col-sm-3">
							<input type="text" class="form-control <?php echo ($readonly==''?'tanggal':'');?>" id="tgl" name="tgl" value="<?=(isset($data)?$data['tgl']:'');?>">
						</div>
						<label for="biaya_lain_note" class="col-sm-2 control-label">Keterangan</label>
						<div class="col-sm-4">
							<textarea class="form-control" id="biaya_lain_note" name="notes"><?=(isset($data)?$data['notes']:'')?></textarea>
						</div>
					</div>
					<div class="form-group ">
						<label class="col-sm-2 control-label">ID Asset</label>
						<div class="col-sm-3">
							<?php
							$dataset[0]='Select Asset';
							echo form_dropdown('kd_asset',$dataset, (isset($data)?$data['kd_asset']:0), array('id'=>'kd_asset','class'=>'form-control ','onblur'=>'get_info()'));
							?>
						</div>
					</div>
					<div class="form-group ">
					   <label class="col-sm-2 control-label">Nilai Asset</label>
						<div class="col-sm-3">
							<input type="text" class="form-control divide" id="nilai_aset" name="nilai_aset" value="<?=(isset($data)?$data['nilai_aset']:'0');?>" readonly>
						</div>
					   <label class="col-sm-2 control-label">Akumulasi Penyusutan</label>
						<div class="col-sm-3">
							<input type="text" class="form-control divide" id="nilai_akumulasi" name="nilai_akumulasi" value="<?=(isset($data)?$data['nilai_akumulasi']:'0');?>" readonly>
						</div>
					</div>
					<div class="form-group ">
						<label for="bank" class="col-sm-2 control-label">Bank</label>
						<div class="col-sm-3">
							<?php
							echo form_dropdown('bank',$datbank, (isset($data)?$data['bank']:0), array('id'=>'bank','class'=>'form-control '.$readonly,$readonly=>$readonly));
							?>
						</div>
					    <label class="col-sm-2 control-label">Nilai Jual</label>
						<div class="col-sm-3">
							<input type="text" class="form-control divide" id="nilai_jual" name="nilai_jual" value="<?=(isset($data)?$data['nilai_jual']:'0');?>" onblur="cek_selisih()">
						</div>
					</div>
					<div class="form-group ">
					    <label class="col-sm-2 control-label">Nilai Buku</label>
						<div class="col-sm-3">
							<input type="text" class="form-control divide" id="nilai_buku" name="nilai_buku" value="<?=(isset($data)?$data['nilai_buku']:'0');?>" readonly>
						</div>
						<label class="col-sm-2 control-label">Selisih</label>
						<div class="col-sm-3">
							<input type="text" class="form-control" id="nilai_selisih" name="nilai_selisih" value="<?=(isset($data)?$data['nilai_selisih']:0)?>" onblur="cektotal()" readonly>
						</div>
					</div>
					<div class="form-group ">
					    <label for="ppn" class="col-sm-2 control-label">PPN</label>
						<div class="col-sm-3">
							<?php
							echo form_dropdown('ppn',$datppn, (isset($data)?$data['ppn']:0), array('id'=>'ppn','class'=>'form-control','onblur'=>'cektotal()'));
							?>
						</div>
					    <label for="nilai_ppn" class="col-sm-2 control-label">Nilai PPN</label>
						<div class="col-sm-3">
							<input type="text" class="form-control divide" id="nilai_ppn" name="nilai_ppn" value="<?=(isset($data)?$data['nilai_ppn']:'0');?>" readonly tabindex="-1">
						</div>
					</div>
					<div class="form-group ">
					   <label class="col-sm-2 control-label">COA Asset</label>
						<div class="col-sm-3">
						<input type="text" class="form-control" id="coa" name="coa" value="<?=(isset($data)?$data['coa']:'0');?>" readonly>
						</div>
					  
					</div>
					<div class="box-footer">
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<input type="hidden" id="status" name="status" value="<?=$data->status?>">
								<input type="hidden" id="id" name="id" value="<?=$data['id']; ?>">
								<button type="submit" name="save" class="btn btn-success" id="submit"><i class="fa fa-save">&nbsp;</i>Save</button>
<?php if(isset($data)) { ?>
								<button type="button" name="update" class="btn btn-warning" id="btn-update" onclick="update_asset()"><i class="fa fa-save">&nbsp;</i>Update</button>
<?php } ?>
								<a class="btn btn-danger" data-toggle="modal" onclick="cancel()"><i class="fa fa-minus-circle">&nbsp;</i>Cancel</a>
							</div>
						</div>
					</div>
				</div>
            <?= form_close() ?>

            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
	function update_asset(){
		var id=$("#id").val();
        $.ajax({
			url		: siteurl+"asset/update_out/"+id,
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
                    window.location.reload();
//                    cancel();
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

	function cektotal(){
		var ppn=$("#ppn").val();
		var nilai_jual=$("#nilai_jual").val();
		nilai_ppn=Math.ceil(Number(nilai_jual)*Number(ppn)/100);
		$("#nilai_ppn").val(nilai_ppn);
	}

	$(function () {
		$(".tanggal").datepicker({
			todayHighlight: true,
			format : "yyyy-mm-dd",
			showInputs: true,
			autoclose:true
		});
	});

    $(document).ready(function() {
<?php if(isset($data)) {
if($data['status']=='1') {	?>
		$('#frm_data :input').prop('disabled',true);
<?php }
}?>
		$(".divide").divide();
    });
    $('#frm_data').on('submit', function(e){
        e.preventDefault();
		var tgl=$("#tgl").val();
		if(tgl==''){
			alert("Tanggal harus diisi");
			return false
		}
        var formdata = $("#frm_data").serialize();
        $.ajax({
            url: siteurl+"asset/save_out",
            dataType : "json",
            type: 'POST',
            data: formdata,
            success: function(msg){
                if(msg['save']=='1'){
                    swal({
                        title: "Sukses!",
                        text: "Data Berhasil Di Simpan",
                        type: "success",
                        timer: 1500,
                        showConfirmButton: false
                    });
                    cancel();
                    window.location.reload();
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
    });

    function cancel(){
        $(".box").show();
        $("#form-data").hide();
    }

	function get_info(){
		var kd_asset=$("#kd_asset").val();
		if(kd_asset!=''){
			$.ajax({
				dataType : "json",
				type	: "POST",
				url		: siteurl+"asset/asset_info/"+kd_asset,
				success	: function(ret){
					$("#nilai_aset").val(ret['nilai_asset']);
					$("#nilai_akumulasi").val(ret['nilai_akumulasi']);
					$("#nilai_buku").val(ret['nilai_buku']);
					$("#coa").val(ret['coa']);
					console.log(ret);
				}
			});
		}
		cek_selisih();
	}
	
	function cek_selisih(){
		var nilai_buku=$("#nilai_buku").val();
		var nilai_jual=$("#nilai_jual").val();
		var nilai_selisih=(parseFloat(nilai_buku)-parseFloat(nilai_jual));
		$("#nilai_selisih").val(nilai_selisih);
	}
</script>
