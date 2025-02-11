<?php
// fungsi header dengan mengirimkan raw data excel
header("Content-type: application/vnd-ms-excel");

// membuat nama file ekspor "export-to-excel.xls"
header("Content-Disposition: attachment; filename=Report Report Revenue Detail.xls");
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
            <tr class='bg-blue'>
                <th align="center">No</th>
                <th>Tgl</th>
                <th>No SO</th>
                <th>No Invoice</th>
                <th>Persentase</th>
                <th>Price List</th>
                <th>Disc (Rp.)</th>
                <th>Revenue</th>
                <th>HPP</th>
                <th>Jurnal</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $ttl_revenue = 0;
            $ttl_hpp = 0;

            $no = 0;
            foreach ($list_revenue_detail as $item) {
                $no++;

                $so = $item->no_so;
                $invoice = $this->db->query("select no_surat FROM tr_invoice WHERE no_so='$so'")->result();
                $separator = ',';
                $allinv = array();
                foreach ($invoice as $inv) {
                    $allinv[] = $inv->no_surat;
                    $invoicing = $inv->no_surat;
                }

                $invc =  implode($separator, $allinv);

                echo '<tr>';
                echo '<td align="center">' . $no . '</td>';
                echo '<td align="center">' . date('d-F-Y', strtotime($item->tgl_so)) . '</td>';
                echo '<td align="center">' . $item->no_surat . '</td>';
                echo '<td align="left">' . $invc . '</td>';
                echo '<td align="right">' . number_format($item->perseninvoice_pengakuan) . '%</td>';
                echo '<td align="right">' . number_format($item->pricelist) . '</td>';
                echo '<td align="right">' . number_format($item->disc) . '</td>';
                echo '<td align="right">' . number_format($item->pengakuan_invoice) . '</td>';
                echo '<td align="right">' . number_format($item->pengakuan_hpp) . '</td>';
                echo '<td align="center">' . $item->status_jurnal . '</td>';
                echo '</tr>';

                $ttl_revenue += $item->pengakuan_invoice;
                $ttl_hpp += $item->pengakuan_hpp;
            }
            ?>
        </tbody>

        <tfoot>
            <tr>
                <th></th>
                <th colspan="6" align="right">Total</th>
                <th align="right"><?= number_format($ttl_revenue) ?></th>
                <th align="right"><?= number_format($ttl_hpp) ?></th>
                <th></th>
            </tr>
        </tfoot>
    </table>
</body>

</html>