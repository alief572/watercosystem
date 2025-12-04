<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Report Mutasi Stock (" . date('d F Y', strtotime($tgl)) . ").xlsx");
?>
<table width="100%" border="1">
    <thead>
        <th style="text-align: center;">No.</th>
        <th style="text-align: center;">Tgl</th>
        <th style="text-align: center;">Nomor</th>
        <th style="text-align: center;">Nama Barang</th>
        <th style="text-align: center;">Qty</th>
        <th style="text-align: center;">Costbook</th>
        <th style="text-align: center;">Total</th>
    </thead>
    <tbody>
        <?php
        $no = 0;
        $ttl_total = 0;

        foreach ($data_mutasi_stock as $item) {

            $no++;

            if (!empty($tgl)) {
                $tanggal = date('d F Y', strtotime($tgl));
            } else {
                $tanggal = date('d F Y');
            }

            echo '<tr>';
            echo '<td style="text-align: center;">' . $no . '</td>';
            echo '<td>' . $tanggal . '</td>';
            echo '<td>' . $item->id_category3 . '</td>';
            echo '<td>' . $item->nama . '</td>';
            echo '<td style="text-align: center;">' . number_format($item->qty) . '</td>';
            echo '<td style="text-align: right;">' . number_format($item->nilai_costbook) . '</td>';
            echo '<td style="text-align: right;">' . number_format($item->nilai_costbook * $item->qty) . '</td>';
            echo '</tr>';

            $ttl_total += ($item->nilai_costbook * $item->qty);
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="6" style="text-align: center;">Grand Total</th>
            <th style="text-align: right;"><?= number_format($ttl_total) ?></th>
        </tr>
    </tfoot>
</table>