<?php
$consignment = $consignment ?? false;
$action = $consignment ? 'index_konsinyasi' : 'index_mutasi';
?>
<div class="box box-primary">
    <div class="box-body">
        <form method="post" action="<?= html_escape(base_url() . 'adjustmentstockmulti/' . $action) ?>">
            <div class="form-group">
                <label for="id_gudang">Pilih Gudang</label>
                <select id="id_gudang" name="id_gudang" class="form-control" required>
                    <option value="">--Pilih--</option>
                    <?php foreach ($results['gudang'] as $warehouse): ?>
                    <option value="<?= html_escape($warehouse->id_gudang) ?>"><?= html_escape($warehouse->nama_gudang) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Tampilkan</button>
        </form>
    </div>
</div>
