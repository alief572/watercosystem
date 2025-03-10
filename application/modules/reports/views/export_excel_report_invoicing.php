<?php
// fungsi header dengan mengirimkan raw data excel
header("Content-type: application/vnd-ms-excel");

// membuat nama file ekspor "export-to-excel.xls"
header("Content-Disposition: attachment; filename=Report Invoicing.xls");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Invoicing</title>
</head>

<body>
    <table width="100%" border="1">
        <thead>
            <tr>
                <th align="center">#</th>
                <th align="center">No.Invoice</th>
                <th align="center">Nama Customer</th>
                <th align="center">Marketing</th>
                <th align="center">Top</th>
                <th align="center">Payment</th>
                <th align="center">Nilai<br>DPP</th>
                <th align="center">Nilai<br>Invoice</th>
                <th align="center">Tanggal<br>Invoice</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 0;

            $ttl_grand_total = 0;
            $ttl_nilai_invoice = 0;
            foreach ($data_invoicing as $item) {
                $no++;

                echo '<tr>';
                echo '<td align="center">' . $no . '</td>';
                echo '<td align="left">' . $item->no_surat . '</td>';
                echo '<td align="left">' . $item->name_customer . '</td>';
                echo '<td align="left">' . $item->nama_sales . '</td>';
                echo '<td align="left">' . $item->nama_top . '</td>';
                echo '<td align="left">' . $item->payment . '</td>';
                echo '<td align="right">' . number_format($item->grand_total, 2) . '</td>';
                echo '<td align="right">' . number_format($item->nilai_invoice, 2) . '</td>';
                echo '<td align="right">' . date('d F Y', strtotime($item->tgl_invoice)) . '</td>';
                echo '</tr>';

                $ttl_grand_total += $item->grand_total;
                $ttl_nilai_invoice += $item->nilai_invoice;
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <th></th>
                <th colspan="5" class="text-right">Total</th>
                <th class="totaldppformat" align="right"><?= number_format($ttl_grand_total, 2) ?></th>
                <th class="totalformat" align="right"><?= number_format($ttl_nilai_invoice, 2) ?></th>
                <th></th>
            </tr>
        </tfoot>
    </table>
</body>

</html>