<div class="box box-primary">
    <div class="box-body">
        <table class='table table-bordered table-striped'>
            <thead>
                <tr>
                    <th class='center_'>#</th>
                    <th class='center_'>Receive Date</th>
                    <th class='center_'>Lot Number</th>
                    <th class='center_'>Qty Receive (Kg)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $no = 0;
                    foreach($results['detail'] AS $val => $valx){ $no++;
                        echo "<tr>";
                            echo "<td align='center'>".$no."</td>";
                            echo "<td align='center'>".date('d-M-Y', strtotime($valx['tgl_datang']))."</td>";
                            echo "<td align='center'>".$valx['lotno']."</td>";
                            echo "<td align='center'>".number_format($valx['width_recive'],2)."</td>";
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>

<style>
.center_{
    text-align: center;
}
</style>