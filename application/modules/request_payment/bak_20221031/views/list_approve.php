<?php
$ENABLE_ADD     = has_permission('Request_Payment_Approval.Add');
$ENABLE_MANAGE  = has_permission('Request_Payment_Approval.Manage');
$ENABLE_VIEW    = has_permission('Request_Payment_Approval.View');
$ENABLE_DELETE  = has_permission('Request_Payment_Approval.Delete');
?>
<div id="alert_edit" class="alert alert-success alert-dismissable" style="padding: 15px; display: none;"></div>
<?= form_open($this->uri->uri_string(), array('id' => 'frm_data', 'name' => 'frm_data', 'role' => 'form', 'class' => 'form-horizontal')); ?>
<div class="box">
	<div class="box-body">
		<div class="table-responsive">
			<table id="mytabledata" class="table table-bordered">
				<thead>
					<tr>
						<th width="5">#</th>
						<th>No Dokumen</th>
						<th>Request By</th>
						<th>Tanggal</th>
						<th>Keperluan</th>
						<th>Tipe</th>
						<th>Nilai Pengajuan</th>
						<th>Tanggal Pembayaran</th>
						<th>Status</th>
						<th width="120">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					if (!empty($data)) {
						$numb = 0;
						foreach ($data as $record) {
							$numb++; ?>
							<tr>
								<td><?= $numb; ?></td>
								<td><?= $record->no_doc ?></td>
								<td><?= $record->nama ?></td>
								<td><?= $record->tgl_doc ?></td>
								<td><?= $record->keperluan ?></td>
								<td><?= $record->tipe ?></td>
								<td><?= number_format($record->jumlah) ?></td>
								<td><?= $record->tanggal ?></td>
								<td class="text-center">
									<?php if ($record->status == '0') : ?>
										<label class="label bg-aqua">Open</label>
									<?php elseif ($record->status == 1) : ?>
										<label class="label bg-yellow">Partial Payment</label>
									<?php elseif ($record->status == 2) : ?>
										<label class="label bg-green">Full Payment</label>
									<?php else : ?>
										<label class="label bg-gray"><span class="text-muted">Undefinde</span></label>
									<?php endif; ?>
								</td>
								<td>
									<?php
									if ($record->tipe == 'kasbon') { ?>
										<!-- <a href="<?= base_url('expense/kasbon_view/' . $record->ids) ?>" target="_blank"><i class="fa fa-search pull-right"></i></a> -->
									<?php }
									if ($record->tipe == 'transportasi') { ?>
										<!-- <a href="<?= base_url('expense/transport_req_view/' . $record->ids) ?>" target="_blank"><i class="fa fa-search pull-right"></i></a> -->
									<?php }
									if ($record->tipe == 'expense') { ?>
										<!-- <a href="<?= base_url('expense/view/' . $record->ids) ?>" target="_blank"><i class="fa fa-search pull-right"></i></a> -->
									<?php }
									if ($record->tipe == 'nonpo') { ?>
										<!-- <a href="<?= base_url('purchase_order/non_po/view/' . $record->ids) ?>" target="_blank"><i class="fa fa-search pull-right"></i></a> -->
									<?php }
									if ($record->tipe == 'periodiks') { ?>
										<!-- <a href="<?= base_url('pembayaran_rutin/view/' . $record->ids) ?>" target="_blank"><i class="fa fa-search pull-right"></i></a> -->
									<?php }
									if ($ENABLE_MANAGE) : ?>
										<div class="text-center"><a href="<?= base_url($this->uri->segment(1) . '/approval_payment/?type=' . $record->tipe . '&id=' . $record->ids); ?>" name="save" class="btn btn-primary btn-sm"><i class="fa fa-save">&nbsp;</i>Approve</a></div>
										<!-- <input type="checkbox" name="status[]" id="status_<?= $numb ?>" value="<?= $record->id ?>"> -->
									<?php endif; ?>
								</td>
							</tr>
					<?php
						}
					}  ?>
				</tbody>
			</table>
			<!-- <div class="pull-right"><button type="submit" name="save" class="btn btn-primary btn-sm" id="submit"><i class="fa fa-save">&nbsp;</i>Approve</button></div> -->
		</div>
	</div>
	<!-- /.box-body -->
</div>
<?= form_close() ?>
<script type="text/javascript">
	var url_save = siteurl + 'request_payment/save_approval/';
	//Save
	$('#frm_data').on('submit', function(e) {
		e.preventDefault();
		var errors = "";
		if (errors == "") {
			swal({
					title: "Anda Yakin?",
					text: "Data Akan Di Setujui!",
					type: "info",
					showCancelButton: true,
					confirmButtonText: "Ya, Setujui!",
					cancelButtonText: "Tidak!",
					closeOnConfirm: false,
					closeOnCancel: true
				},
				function(isConfirm) {
					if (isConfirm) {
						var formdata = new FormData($('#frm_data')[0]);
						$.ajax({
							url: url_save,
							dataType: "json",
							type: 'POST',
							data: formdata,
							processData: false,
							contentType: false,
							success: function(msg) {
								if (msg['save'] == '1') {
									swal({
										title: "Sukses!",
										text: "Data Berhasil Di Setujui",
										type: "success",
										timer: 1500,
										showConfirmButton: false
									});
									window.location.href= window.location.href;
								} else {
									swal({
										title: "Gagal!",
										text: "Data Gagal Di Setujui",
										type: "error",
										timer: 1500,
										showConfirmButton: false
									});
								};
								console.log(msg);
							},
							error: function(msg) {
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
		} else {
			swal(errors);
			return false;
		}
	});
</script>