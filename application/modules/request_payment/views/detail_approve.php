<?php
$m = $this->Request_payment_model; $r = $source['request'];
$restricted = $m->restricted($source);
$fileUrl = function ($file) { $file = (string)$file; return $file !== '' && basename(str_replace('\\','/',$file)) === $file ? base_url('assets/expense/'.rawurlencode($file)) : ''; };
?>
<div class="box"><div class="box-body">
<?= form_open('request_payment/save_approval',['id'=>'payment-detail','data-base'=>base_url('request_payment/'),'data-action'=>'save_approval','data-back'=>'list_approve']) ?>
    <input type="hidden" name="id" value="<?= html_escape($source['header']['id']) ?>">
    <input type="hidden" name="tipe" value="<?= html_escape($source['type']) ?>">
    <input type="hidden" name="version" value="<?= html_escape($source['version']) ?>">
    <div class="form-group"><label>No Dokumen</label><input class="form-control" value="<?= html_escape($r['no_doc']) ?>" readonly></div>
    <div class="form-group"><label>Keperluan</label><input class="form-control" value="<?= html_escape($r['keperluan']) ?>" readonly></div>
    <p>Tanggal pembayaran: <?= html_escape($r['tanggal']) ?>. Nilai request: <?= number_format((float)$r['jumlah'],2) ?>.</p>
    <?php if ($restricted): ?><p class="text-warning">Expense berpajak atau Kasbon wajib diproses seluruh detail sekaligus.</p><?php endif; ?>
    <div class="table-responsive"><table class="table table-bordered"><thead><tr><th>#</th><th>COA</th><th>Barang/Jasa</th><th>Tanggal</th><th>Qty</th><th>Harga</th><th>Total Harga</th><th>Bon Bukti</th><th>Pilih</th></tr></thead><tbody>
    <?php foreach ($source['details'] as $i=>$d): $snap = $m->snapshot($source['type'],$d); $eligible = $m->eligible($source['type'],$d); ?>
    <tr><td><?= $i+1 ?></td><td><?= html_escape($snap['coa']) ?></td><td><?= html_escape($snap['deskripsi']) ?></td><td><?= html_escape($snap['tgl_doc']) ?></td><td><?= html_escape($snap['qty']) ?></td><td><?= number_format((float)$snap['harga'],2) ?></td><td><?= number_format((float)$snap['total'],2) ?></td>
    <td><?php if ($fileUrl($snap['doc_file']) !== ''): ?><a href="<?= html_escape($fileUrl($snap['doc_file'])) ?>" target="_blank" rel="noopener" download>Download</a><?php endif; ?></td>
    <td><?php if ($eligible && $can_manage): ?><input type="checkbox" name="items[<?= $i ?>][id]" value="<?= html_escape($d['id']) ?>" checked aria-label="Pilih detail <?= $i+1 ?>"><?php else: ?><?= $eligible ? 'Pending' : 'Sudah diproses' ?><?php endif; ?></td></tr>
    <?php endforeach; ?>
    </tbody></table></div>
    <a class="btn btn-default btn-sm" href="<?= base_url('request_payment/list_approve') ?>">Kembali</a>
    <?php if ($can_manage): ?><button type="submit" class="btn btn-success btn-sm">Approve</button><?php endif; ?>
</form></div></div>
<script src="<?= base_url('assets/js/request_payment.js') ?>"></script>
