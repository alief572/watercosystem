<?php
// Detail Penerimaan Non Produk. Data dari tr_invoice_np_payment (header) dan tr_invoice_np_payment_detail.
// Catatan: kolom no_invoice di detail menyimpan id_invoice dari tr_invoice_np_header.
$header = $this->db->query("SELECT * FROM tr_invoice_np_payment WHERE kd_pembayaran = ?", [$kodebayar])->row();
if (!$header) {
	echo "<div class='alert alert-danger'>Penerimaan tidak ditemukan.</div>";
	return;
}
$detail = $this->db->query("SELECT d.*, h.no_invoice AS no_surat_np, h.total_invoice_idr AS nilai_invoice, h.sisa_invoice_idr AS sisa_now
	FROM tr_invoice_np_payment_detail d
	LEFT JOIN tr_invoice_np_header h ON h.id_invoice = d.no_invoice
	WHERE d.kd_pembayaran = ?", [$kodebayar])->result();

$total_bayar = 0;
foreach ($detail as $d) {
	$total_bayar += (float) $d->total_bayar_idr;
}

$cust = $this->db->query("SELECT address_office FROM master_customers WHERE name_customer = ?", [(string) $header->nm_customer])->row();
$bank = $this->db->query("SELECT nama FROM " . DBACC . ".coa_master WHERE no_perkiraan = ? LIMIT 1", [(string) $header->kd_bank])->row();
?>
<link rel="stylesheet" href="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.css') ?>">
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
									<input type="text" class="form-control input-sm" value="<?= htmlspecialchars((string) $header->kd_pembayaran) ?>" readonly>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="form-group">
								<label class="col-sm-4 control-label">Tgl Bayar :</label>
								<div class="col-sm-6">
									<input type="text" class="form-control input-sm" value="<?= !empty($header->tgl_pembayaran) ? date('d-F-Y', strtotime($header->tgl_pembayaran)) : '' ?>" readonly>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="form-group">
								<label class="col-sm-4 control-label">Nama Customer</label>
								<div class="col-sm-6">
									<input type="text" class="form-control input-sm" value="<?= htmlspecialchars((string) $header->nm_customer) ?>" readonly>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="form-group">
								<label class="col-sm-4 control-label">Alamat Customer</label>
								<div class="col-sm-6">
									<textarea class="form-control input-sm" height=100 readonly><?= htmlspecialchars((string) ($cust->address_office ?? '')) ?></textarea>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="form-group">
								<label class="col-sm-4 control-label">Keterangan Pembayaran</label>
								<div class="col-sm-6">
									<textarea class="form-control input-sm" height=100 readonly><?= htmlspecialchars((string) $header->keterangan) ?></textarea>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="form-group">
								<label class="col-sm-4 control-label">Bank</label>
								<div class="col-sm-6">
									<input type="text" class="form-control input-sm" value="<?= htmlspecialchars((string) ($bank->nama ?? '')) ?>" readonly>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-6 form-horizontal">
						<div class="form-group">
							<label class="col-sm-4 control-label">Total Invoice Bayar</label>
							<div class="col-sm-6" style="padding-top: 8px;">
								<input type="text" class="form-control input-sm" value="<?= number_format($total_bayar) ?>" readonly>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label">Jumlah Penerimaan bank</label>
							<div class="col-sm-6" style="padding-top: 8px;">
								<input type="text" class="form-control input-sm" value="<?= number_format((float) $header->jumlah_bank_idr, 2) ?>" readonly>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label">Biaya Administrasi</label>
							<div class="col-sm-6" style="padding-top: 8px;">
								<input type="text" class="form-control input-sm" value="<?= number_format((float) $header->biaya_admin_idr, 2) ?>" readonly>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label">PPH</label>
							<div class="col-sm-6" style="padding-top: 8px;">
								<input type="text" class="form-control input-sm" value="<?= number_format((float) $header->biaya_pph_idr, 2) ?>" readonly>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label">Total Penerimaan</label>
							<div class="col-sm-6" style="padding-top: 8px;">
								<input type="text" class="form-control input-sm" value="<?= number_format((float) $header->jumlah_pembayaran_idr, 2) ?>" readonly>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label">Lebih Bayar</label>
							<div class="col-sm-6" style="padding-top: 8px;">
								<input type="text" class="form-control input-sm" value="<?= number_format((float) $header->tambah_lebih_bayar, 2) ?>" readonly>
							</div>
						</div>
					</div>

					<div class="box-body">
						<table class="table table-bordered" width="100%">
							<thead>
								<tr class="bg-blue">
									<th class="text-center">No Invoice</th>
									<th class="text-center">Nama Customer</th>
									<th class="text-center">Total Invoice</th>
									<th class="text-center">Sisa Invoice</th>
									<th class="text-center">Total Bayar</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($detail as $det) : ?>
									<tr>
										<td class="text-center"><?= htmlspecialchars((string) ($det->no_surat_np ?? '')) ?></td>
										<td class="text-center"><?= htmlspecialchars((string) $header->nm_customer) ?></td>
										<td class="text-center"><?= number_format((float) ($det->nilai_invoice ?? 0), 2) ?></td>
										<td class="text-center"><?= number_format((float) ($det->sisa_now ?? 0), 2) ?></td>
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
