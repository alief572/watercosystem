<?php
// fungsi header dengan mengirimkan raw data excel
header("Content-type: application/vnd-ms-excel");

// membuat nama file ekspor "export-to-excel.xls"
header("Content-Disposition: attachment; filename=Report Report Revenue.xls");
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
                <th align="center" width='4%'>No</th>
                <th width='7%'>Tgl</th>
                <th width='18%'>No SO</th>
                <th width='18%'>No Invoice</th>
                <th width='7%'>Total SO</th>
                <th width='7%'>Revenue</th>
                <th width='7%'>HPP</th>

            </tr>
        </thead>
        <tbody>
            <?php
            $ttl_total_so = 0;
            $ttl_revenue = 0;
            $ttl_hpp = 0;

            $no = 0;
            foreach ($list_revenue as $item) {
                $no++;

                $so = $item->no_so;
                $invoice = $this->db->query("select no_surat FROM tr_invoice WHERE no_so = '" . $so . "'")->result();
                $separator = ',';
                $allinv = array();
                foreach ($invoice as $inv) {
                    $allinv[] = $inv->no_surat;
                }

                $invc =  implode($separator, $allinv);

                echo '<tr>';
                echo '<td align="center">' . $no . '</td>';
                echo '<td align="center">' . date('d-F-Y', strtotime($item->tgl_so)) . '</td>';
                echo '<td align="left">' . $item->no_surat . '</td>';
                echo '<td align="left">' . $invc . '</td>';
                echo '<td align="right">' . number_format($item->grand_total, 2) . '</td>';
                echo '<td align="right">' . number_format($item->pengakuan_invoice, 2) . '</td>';
                echo '<td align="right">' . number_format($item->pengakuan_hpp, 2) . '</td>';
                echo '</tr>';

                $ttl_total_so += $item->grand_total;
                $ttl_revenue += $item->pengakuan_invoice;
                $ttl_hpp += $item->pengakuan_hpp;
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" align="right">Total</td>
                <td align="right" class="totalgrandtotalformat"><?= number_format($ttl_total_so, 2) ?></td>
                <td align="right" class="totalinvoiceformat"><?= number_format($ttl_revenue, 2) ?></td>
                <td align="right" class="totalhppformat"><?= number_format($ttl_hpp, 2) ?></td>
            </tr>
        </tfoot>
    </table>
</body>

</html>