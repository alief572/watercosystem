<?php
// Detail Penerimaan Debit Note. Data dari tr_debit_note_payment (header) dan tr_debit_note_payment_detail.
// Kolom no_invoice pada detail menyimpan no_pr dari tr_debit_note.
$data_header = $this->db->query("SELECT * FROM tr_debit_note_payment WHERE kd_pembayaran = ?", [(string) $kodebayar])->row();
if (!$data_header) {
	echo "<div class='alert alert-danger'>Penerimaan tidak ditemukan.</div>";
	return;
}
$detail = $this->db->query("SELECT d.*, i.no_surat AS no_dn, i.total_tagihan AS nilai_dn, i.sisa_tagihan AS sisa_dn
	FROM tr_debit_note_payment_detail d
	LEFT JOIN tr_debit_note i ON i.no_pr = d.no_invoice
	WHERE d.kd_pembayaran = ?", [(string) $kodebayar])->result();
$total_bayar = 0;
foreach ($detail as $d) {
	$total_bayar += (float) $d->total_bayar_idr;
}
$alamat_cust = $this->db->query("SELECT address_office FROM master_customers WHERE name_customer = ?", [(string) $data_header->nm_customer])->row();
?>
<link rel="stylesheet" href="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.css')?>">
<div class="nav-tabs-salesorder">
	<div class="tab-content">
		<div class="tab-pane active" id="salesorder">
			<div class="box box-primary">
				<div class="box-body">
					<div class="col-sm-6 form-horizontal">
						<div class="row">
							<div class="form-group">
								<label class="col-sm-4 control-label">Kode Bayar</label>
								<div class="col-sm-6">
									<input type="text" class="form-control input-sm" value="<?= htmlspecialchars((string) $data_header->kd_pembayaran) ?>" readonly>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="form-group">
								<label class="col-sm-4 control-label">Tgl Bayar :</label>
								<div class="col-sm-6">
									<input type="text" class="form-control input-sm" value="<?= !empty($data_header->tgl_pembayaran) ? date('d-F-Y', strtotime($data_header->tgl_pembayaran)) : '' ?>" readonly>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="form-group">
								<label class="col-sm-4 control-label">Nama Customer</label>
								<div class="col-sm-6">
									<input type="text" class="form-control input-sm" value="<?= htmlspecialchars((string) $data_header->nm_customer) ?>" readonly>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="form-group">
								<label class="col-sm-4 control-label">Alamat Customer</label>
								<div class="col-sm-6">
									<textarea class="form-control input-sm" height=100 readonly><?= htmlspecialchars((string) ($alamat_cust->address_office ?? '')) ?></textarea>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="form-group">
								<label class="col-sm-4 control-label">Keterangan Pembayaran</label>
								<div class="col-sm-6">
									<textarea class="form-control input-sm" height=100 readonly><?= htmlspecialchars((string) $data_header->keterangan) ?></textarea>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-6 form-horizontal">
						<div class="form-group">
							<label class="col-sm-4 control-label">Total DN Bayar</label>
							<div class="col-sm-6" style="padding-top: 8px;">
								<input type="text" class="form-control input-sm" value="<?= number_format($total_bayar) ?>" readonly>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label">Jumlah Penerimaan bank</label>
							<div class="col-sm-6" style="padding-top: 8px;">
								<input type="text" class="form-control input-sm" value="<?= number_format((float) $data_header->jumlah_bank_idr, 2) ?>" readonly>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label">Biaya Administrasi</label>
							<div class="col-sm-6" style="padding-top: 8px;">
								<input type="text" class="form-control input-sm" value="<?= number_format((float) $data_header->biaya_admin_idr, 2) ?>" readonly>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label">Total Penerimaan</label>
							<div class="col-sm-6" style="padding-top: 8px;">
								<input type="text" class="form-control input-sm" value="<?= number_format((float) $data_header->jumlah_pembayaran_idr, 2) ?>" readonly>
							</div>
						</div>
					</div>
					<div class="box-body">
						<table class="table table-bordered" width="100%">
							<thead>
								<tr class="bg-blue">
									<th class="text-center">No DN</th>
									<th class="text-center">Nama Customer</th>
									<th class="text-center">Total DN</th>
									<th class="text-center">Sisa DN</th>
									<th class="text-center">Total Bayar</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($detail as $det) : ?>
									<tr>
										<td class="text-center"><?= htmlspecialchars((string) ($det->no_dn ?? $det->no_invoice)) ?></td>
										<td class="text-center"><?= htmlspecialchars((string) $data_header->nm_customer) ?></td>
										<td class="text-center"><?= number_format((float) ($det->nilai_dn ?? 0), 2) ?></td>
										<td class="text-center"><?= number_format((float) ($det->sisa_dn ?? 0), 2) ?></td>
										<td class="text-center"><?= number_format((float) $det->total_bayar_idr, 2) ?></td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
