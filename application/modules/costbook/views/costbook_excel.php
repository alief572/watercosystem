<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Costbook Report.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<table border="1" width="100%">
    <thead>
        <tr>
            <th colspan="5" style="text-align: center; font-size: 16px;">Costbook Report</th>
        </tr>
        <tr>
            <th style="text-align: center;">No</th>
            <th style="text-align: center;">ID Produk</th>
            <th style="text-align: center;">Nama Produk</th>
            <th style="text-align: center;">Kode Barang</th>
            <th style="text-align: center;">Harga HPP</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($costbook as $item) : ?>
            <tr>
                <td style="text-align: center;"><?php echo $no++; ?></td>
                <td style="text-align: center;"><?php echo $item->id_category3; ?></td>
                <td style="text-align: left;"><?php echo $item->nama_produk; ?></td>
                <td style="text-align: center;"><?php echo $item->kode_barang; ?></td>
                <td style="text-align: right;"><?php echo number_format($item->nilai_costbook, 2); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>