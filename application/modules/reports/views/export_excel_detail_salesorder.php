<?php
// fungsi header dengan mengirimkan raw data excel
header("Content-type: application/vnd-ms-excel");

// membuat nama file ekspor "export-to-excel.xls"
header("Content-Disposition: attachment; filename=Report Sales Detail Order.xls");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <table border="1">
        <thead>
            <tr>
                <th>#</th>
                <th width="10%">Tgl.SO</th>
                <th width="10%">No.SO</th>
                <th width="10%">No.Invoice</th>
                <th width="10%">Customer</th>
                <th>Nama Produk</th>
                <th width="10%">Qty SO</th>
                <th>Harga<br>Pricelist</th>
                <th>Harga<br>Total</th>
                <th>Diskon</th>
                <th>Harga<br>Nett</th>

            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($data as $item) {
                $invoice = $this->db->query("select no_surat FROM tr_invoice WHERE no_so='" . $item->no_so . "'")->result();
                $separator = ',';
                $allinv = array();
                foreach ($invoice as $inv) {
                    $allinv[] = $inv->no_surat;
                }

                $invc =  implode($separator, $allinv);

                echo '<tr>';
                echo '<td class="text-center">' . $no . '</td>';
                echo '<td class="text-center">' . $item->tgl_so . '</td>';
                echo '<td class="text-center">' . $item->no_surat . '</td>';
                echo '<td class="text-center">' . $invc . '</td>';
                echo '<td class="text-center">' . $item->customer . '</td>';
                echo '<td class="text-center">' . $item->nama_produk . '</td>';
                echo '<td class="text-center">' . number_format($item->qty_so) . '</td>';
                echo '<td class="text-right">' . number_format($item->harga_satuan, 2) . '</td>';
                echo '<td class="text-right">' . number_format($item->qty_so * $item->harga_satuan, 2) . '</td>';
                echo '<td class="text-right">' . number_format($item->nilai_diskon, 2) . '</td>';
                echo '<td class="text-right">' . number_format($item->total_harga, 2) . '</td>';
                echo '</tr>';

                $no++;
            }
            ?>
        </tbody>
    </table>
</body>

</html>