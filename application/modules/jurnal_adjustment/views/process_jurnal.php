<input type="hidden" name="id_transaksi" value="<?= $data_adjustment->id_transaksi ?>">
<div class="row">
    <div class="col-md-2">
        <span class="text-bold">No. Transaksi</span>
    </div>
    <div class="col-md-4">
        <input type="text" class="form-control form-control-sm" value="<?= $data_adjustment->id_transaksi ?>" readonly>
    </div>
    <div class="col-md-2">
        <span class="text-bold">Tanggal</span>
    </div>
    <div class="col-md-4">
        <input type="date" class="form-control form-control-sm" value="<?= $data_adjustment->tanggal_transaksi ?>" readonly>
    </div>
    <div class="col-md-2">
        <span class="text-bold">Material</span>
    </div>
    <div class="col-md-4">
        <input type="text" class="form-control form-control-sm" value="<?= $data_adjustment->nama_material ?>" readonly>
    </div>
    <div class="col-md-2">
        <span class="text-bold">Tipe Adjustment</span>
    </div>
    <div class="col-md-4">
        <input type="text" class="form-control form-control-sm" value="<?= $data_adjustment->adjustment ?>" readonly>
    </div>
    <div class="col-md-2">
        <span class="text-bold">Gudang</span>
    </div>
    <div class="col-md-4">
        <input type="text" class="form-control form-control-sm" value="<?= $data_adjustment->nama_gudang ?>" readonly>
    </div>
    <div class="col-md-2">
        <span class="text-bold">Keterangan</span>
    </div>
    <div class="col-md-4">
        <textarea class="form-control form-control-sm" readonly><?= $data_adjustment->note ?></textarea>
    </div>
</div>

<!-- <div class="col-md-12"> -->
<br>
<table class="table table-striped table-bordered">
    <thead class="bg-primary">
        <tr>
            <th class="text-center">Tanggal</th>
            <th class="text-center">Tipe</th>
            <th class="text-center">No. COA</th>
            <th class="text-center">Keterangan</th>
            <th class="text-center">No. Reff</th>
            <th class="text-center">Debit</th>
            <th class="text-center">Kredit</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no_jurnal = 0; 
        $ttl_jurnal_debit = 0;
        $ttl_jurnal_kredit = 0;
        foreach ($data_jurnal as $item_jurnal) {
            $no_jurnal++;

            echo '
                <tr>
                    <td class="text-center">' . date('d F Y', strtotime($item_jurnal['tanggal'])) . '</td>
                    <td class="text-center">' . $item_jurnal['tipe'] . '</td>
                    <td class="text-center">' . $item_jurnal['no_coa'] . '</td>
                    <td class="text-center">' . $item_jurnal['keterangan'] . '</td>
                    <td class="text-center">' . $item_jurnal['no_reff'] . '</td>
                    <td class="text-right">' . number_format($item_jurnal['debit']) . '</td>
                    <td class="text-right">' . number_format($item_jurnal['kredit']) . '</td>
                </tr>
            ';

            $ttl_jurnal_debit += $item_jurnal['debit'];
            $ttl_jurnal_kredit += $item_jurnal['kredit'];
        }
        ?>
    </tbody>
    <tfoot class="bg-gray">
        <tr>
            <th class="text-right" colspan="5">Grand Total</th>
            <th class="text-right"><?= number_format($ttl_jurnal_debit) ?></th>
            <th class="text-right"><?= number_format($ttl_jurnal_kredit) ?></th>
        </tr>
    </tfoot>
</table>
<!-- </div> -->