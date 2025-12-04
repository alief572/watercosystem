<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Purpose Produk (LV I)</th>
            <th>Produk Type (LV II)</th>
            <th>Usage (LV III)</th>
            <th>Deskripsi Produk (LV III)</th>
            <th>Kode Produk</th>
            <th>Nama Formula</th>
            <th>Harga Beli</th>
            <th>Kurs</th>
            <th>Pricelist <br>USD</th>
            <th>Pricelist<br>IDR</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($result as $record) {
        ?>
            <td><?= $numb; ?></td>
            <td><?= $record->nama_category1 ?></td>
            <td><?= $record->nama_category2 ?></td>
            <td><?= $record->nama_category3 ?></td>
            <td><?= $record->nama_category4 ?></td>
            <td><?= $record->kode_produk ?></td>
            <td><?= $record->nama_formula ?></td>
            <td><?= number_format($record->harga_beli, 2) ?></td>
            <td><?= number_format($record->kurs) ?></td>
            <td><?= number_format($record->total_pricelist) ?></td>
            <td><?= number_format($record->harga_rupiah) ?></td>
        <?php
        }
        ?>
    </tbody>
</table>