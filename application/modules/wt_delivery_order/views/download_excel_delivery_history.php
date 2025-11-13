<?php
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Delivery_Order.xls");
?>

<table border="1">
    <thead>
        <th>#</th>
        <th>No SPK Delivery</th>
        <th>Tanggal DO</th>
        <th>No DO</th>
        <th>Nama Customer</th>
        <th>No Invoice</th>
        <th>Nilai Costbook</th>
    </thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($results as $item) {

            $nilai_costbook = 0;

            $this->db->select('a.id_category3, a.qty_do, a.tgl_delivery');
            $this->db->from('tr_delivery_order_detail a');
            $this->db->where('a.no_do', $item->no_do);
            $get_detail = $this->db->get()->result();

            foreach ($get_detail as $item_detail) {
                $this->db->select('a.nilai_costbook');
                $this->db->from('ms_costbook_backup a');
                $this->db->where('a.id_category3', $item_detail->id_category3);
                $this->db->where('DATE_FORMAT(a.tgl, "%Y-%m-%d") >=', $item->tgl_do);
                $this->db->where('DATE_FORMAT(a.tgl, "%Y-%m-%d") <=', $item->tgl_do);
                $this->db->limit(1);
                $get_costbook = $this->db->get()->row();

                if (!empty($get_costbook)) {
                    $nilai_costbook += ($get_costbook->nilai_costbook * $item_detail->qty_do);
                }
            }

            echo '<tr>';

            echo '<td class="text-center">' . $no . '</td>';
            echo '<td>' . $item->no_surat_spk . '</td>';
            echo '<td>' . date('d-M-Y', strtotime($item->tgl_do)) . '</td>';
            echo '<td>' . $item->no_surat . '</td>';
            echo '<td>' . $item->name_customer . '</td>';
            echo '<td>' . $item->no_invoice . '</td>';
            echo '<td style="text-align: right;">' . number_format($item->totalcostbook, 2) . '</td>';

            echo '</tr>';

            $no++;
        }
        ?>
    </tbody>
</table>