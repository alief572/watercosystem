<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Report Mutasi Stock detail (" . $nm_category3 . " - " . date('d F Y', strtotime($tgl)) . ").xlsx");
?>
<h5>Nama Barang : <span style="font-weight: bold;"><?= $nm_category3 ?></span>
</h5>
<table width="100%" border="1">
    <thead>
        <tr>
            <th style="text-align: center;" rowspan="2">No.</th>
            <th style="text-align: center;" rowspan="2">Tgl Transaksi</th>
            <th style="text-align: center;" rowspan="2">Keterangan</th>
            <th style="text-align: center;" rowspan="2">No. Transaksi</th>
            <th style="text-align: center;" colspan="3">Transaksi</th>
            <th style="text-align: center;" colspan="3">Saldo</th>
        </tr>
        <tr>
            <th style="text-align: center;">In/Out</th>
            <th style="text-align: center;">Price/Unit</th>
            <th style="text-align: center;">Total</th>
            <th style="text-align: center;">In/Out</th>
            <th style="text-align: center;">Price/Unit</th>
            <th style="text-align: center;">Total</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 0;

        $qty_saldo = 0;
        $price_unit_saldo = 0;
        $saldo_total = 0;
        foreach ($data_mutasi as $item) {
            $no++;

            $saldo_total_per = 0;

            $transaksi_price_unit = 0;
            $transaksi_total = 0;
            $transaksi_in_out = $item->qty_transaksi;
            if ($item->transaksi == 'delivery order') {

                $do = $this->db->query("SELECT no_so, cost_book, qty_do FROM tr_delivery_order_detail WHERE id_category3='" . $item->id_category3 . "' AND no_do='" . $item->no_transaksi . "' limit 1")->row();

                $costbook = $do->cost_book;

                // $harga_do = (!empty($get_costbook) && $get_costbook->nilai_costbook > 0) ? ($get_costbook->nilai_costbook / $item->qty_transaksi) : $item->cost_book;

                // if($saldo_total < 1 || $item->qty_akhir < 1) {
                //     $transaksi_price_unit = 0;
                // } else {
                $transaksi_price_unit = $costbook;
                // }
                // $transaksi_price_unit = $harga_do;

                $transaksi_in_out = ($item->qty_transaksi * -1);
                $transaksi_total = ($transaksi_price_unit * ($item->qty_transaksi * 1));

                $saldo_total_per = ($transaksi_price_unit);

                $saldo_total = ($saldo_total_per * $item->qty_akhir);
                if ($item->qty_akhir < 1) {
                    $saldo_total = 0;
                }
            }
            if ($item->transaksi == 'incoming') {
                $transaksi_price_unit = ($item->harga_do / $item->qty_transaksi);
                $transaksi_total = $item->harga_do;

                $saldo_total = ($item->qty_akhir * $item->cost_book);
                if ($saldo_total < 1 || $item->qty_akhir < 1) {
                    $saldo_total_per = 0;
                } else {
                    $saldo_total_per = $item->cost_book;
                }
            }

            echo '<tr>';
            echo '<td style="text-align: center;">' . $no . '</td>';
            echo '<td style="text-align: center;">' . date('d F Y', strtotime($item->tgl_transaksi)) . '</td>';
            echo '<td style="text-align: center;">' . ucfirst($item->transaksi) . '</td>';
            echo '<td style="text-align: center;">' . $item->no_surat . '</td>';
            echo '<td>' . number_format($transaksi_in_out) . '</td>';
            echo '<td>' . number_format($transaksi_price_unit, 2) . '</td>';
            echo '<td>' . number_format($transaksi_total, 2) . '</td>';
            echo '<td>' . number_format($item->qty_akhir) . '</td>';
            echo '<td>' . number_format($saldo_total_per, 2) . '</td>';
            echo '<td>' . number_format($saldo_total, 2) . '</td>';
            echo '</tr>';
        }
        ?>
    </tbody>
</table>