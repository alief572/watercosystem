<input type="hidden" name="id_transaksi" value="<?= html_escape($data_adjustment->id_transaksi) ?>">
<input type="hidden" name="preview_token" value="<?= html_escape($preview_token) ?>">
<div class="row">
    <?php foreach (array(
        array('No. Transaksi', 'text', $data_adjustment->id_transaksi),
        array('Tanggal', 'date', $data_adjustment->tanggal_transaksi),
        array('Material', 'text', $data_adjustment->nama_material),
        array('Tipe Adjustment', 'text', $data_adjustment->adjustment),
        array('Gudang', 'text', $data_adjustment->nama_gudang),
        array('Keterangan', 'textarea', $data_adjustment->note)
    ) as list($label, $type, $value)): ?>
        <div class="col-md-2"><span class="text-bold"><?= html_escape($label) ?></span></div>
        <div class="col-md-4">
            <?php if ($type === 'textarea'): ?>
                <textarea class="form-control form-control-sm" aria-label="<?= html_escape($label) ?>" readonly><?= html_escape($value ?? '') ?></textarea>
            <?php else: ?>
                <input type="<?= html_escape($type) ?>" class="form-control form-control-sm" aria-label="<?= html_escape($label) ?>" value="<?= html_escape($value ?? '') ?>" readonly>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>
<br>
    <table class="table table-striped table-bordered">
        <thead class="bg-primary"><tr><th class="text-center" aria-label="Tanggal posting">Tanggal</th><th class="text-center">Tipe</th><th class="text-center">No. COA</th><th class="text-center">Keterangan</th><th class="text-center">No. Reff</th><th class="text-center">Debit</th><th class="text-center">Kredit</th></tr></thead>
        <tbody>
        <?php foreach ($data_jurnal as $line): ?>
            <tr>
                <td class="text-center"><?= html_escape(date('d F Y', strtotime($line['tanggal']))) ?></td>
                <td class="text-center"><?= html_escape($line['tipe']) ?></td>
                <td class="text-center"><?= html_escape($line['no_coa']) ?></td>
                <td class="text-center"><?= html_escape($line['keterangan']) ?></td>
                <td class="text-center"><?= html_escape($line['no_reff']) ?></td>
                <td class="text-right"><?= number_format($line['debit']) ?></td>
                <td class="text-right"><?= number_format($line['kredit']) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
        <tfoot class="bg-gray"><tr><th colspan="5" class="text-right">Grand Total</th><th class="text-right"><?= number_format($amount) ?></th><th class="text-right"><?= number_format($amount) ?></th></tr></tfoot>
    </table>
