<?php
$inventory = $results['inventory_3'][0];
$escape = static function ($value) { return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); };
$warehouse = (string)($results['idgudang'] ?? '1');
$mutasi = $mutasi ?? false;
$controller = $this->uri->segment(1);
$returnRoute = $controller === 'adjustmentstock' ? '' : ($mutasi ? '/mutasi' : (array('2'=>'/index_display','3'=>'/index_exdisplay','4'=>'/index_retur')[$warehouse] ?? '/konsinyasi'));
?>
<div class="box box-primary">
    <div class="box-body">
        <form id="data-form" method="post">
            <input type="hidden" id="id_material" name="id_material" value="<?= $escape($inventory->id_category3) ?>">
            <input type="hidden" id="id_stock" name="id_stock" value="<?= $escape($results['idstock']) ?>">
            <input type="hidden" id="gudang" name="gudang" value="<?= $escape($warehouse) ?>">
            <input type="hidden" name="request_key" value="<?= $escape($results['request_key']) ?>">
            <div class="form-group">
                <label for="nama_material">Nama Material</label>
                <input type="text" class="form-control" id="nama_material" name="nama_material" value="<?= $escape($inventory->nama) ?>" readonly>
            </div>
            <?php if (isset($results['stock'])): ?>
            <p>Qty Aktual: <?= $escape($results['stock']->qty) ?>; Booking: <?= $escape($results['stock']->qty_book) ?>; Qty Free: <?= $escape($results['stock']->qty_free) ?></p>
            <?php endif; ?>
            <div class="form-group">
                <label for="adjustment">Adjust</label>
                <select class="form-control" id="adjustment" name="adjustment" required>
                    <?php if ($mutasi): ?>
                    <option value="MUTASI">MUTASI</option>
                    <?php else: ?>
                    <option value="">--Pilih--</option>
                    <option value="PLUS">PLUS</option>
                    <option value="MINUS">MINUS</option>
                    <?php endif; ?>
                </select>
            </div>
            <?php if ($mutasi): ?>
            <div class="form-group">
                <label for="id_gudang_baru">Gudang Tujuan</label>
                <select class="form-control" id="id_gudang_baru" name="id_gudang_baru" required>
                    <option value="">--Pilih--</option>
                    <?php foreach ($results['gudang'] as $destination): ?>
                    <option value="<?= $escape($destination->id_gudang) ?>"><?= $escape($destination->nama_gudang) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <?php endif; ?>
            <div class="form-group">
                <label for="total_qty">Qty Adjustment</label>
                <input type="number" class="form-control" id="total_qty" name="total_qty" min="1" max="2147483647" step="1" required>
            </div>
            <div class="form-group">
                <label for="note">Alasan / Keterangan</label>
                <input type="text" class="form-control" id="note" name="note" maxlength="255" required>
            </div>
            <button type="submit" class="btn btn-success btn-sm" id="simpan-plus">Simpan</button>
        </form>
    </div>
</div>
<script type="text/javascript">
(function () {
    var endpoint = <?= json_encode(base_url() . $controller . '/SavePlus', JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
    var returnUrl = <?= json_encode(base_url() . $controller . $returnRoute, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
    var pending = false;
    $('#data-form').on('submit', function (event) {
        event.preventDefault();
        var form = this;
        if (pending || !form.reportValidity()) { return; }
        pending = true;
        $('#simpan-plus').prop('disabled', true);
        swal({
            title: 'Simpan perubahan stok?',
            text: 'Periksa jenis adjustment, jumlah, dan gudang sebelum menyimpan.',
            type: 'warning', showCancelButton: true, confirmButtonText: 'Simpan', cancelButtonText: 'Batal'
        }, function (confirmed) {
            if (!confirmed) { pending = false; $('#simpan-plus').prop('disabled', false); return; }
            $.ajax({
                url: endpoint, type: 'POST', data: new FormData(form), dataType: 'json',
                processData: false, contentType: false
            }).done(function (data) {
                if (data.status === 1) { window.location.href = returnUrl; }
                else { swal('Gagal menyimpan', data.pesan || 'Transaksi stok ditolak.', 'error'); }
            }).fail(function () {
                swal('Gagal memeriksa hasil', 'Periksa riwayat sebelum mencoba kembali. Pengiriman ulang formulir tidak menggandakan transaksi.', 'error');
            }).always(function () { pending = false; $('#simpan-plus').prop('disabled', false); });
        });
    });
})();
</script>
