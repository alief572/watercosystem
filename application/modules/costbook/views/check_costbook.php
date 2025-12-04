<table class="table table-striped">
    <thead>
        <tr>
            <th class="text-center">
                <input type="checkbox" id="check_all" checked>
            </th>
            <th class="text-center">No.</th>
            <th class="text-center">ID Barang</th>
            <th class="text-center">Nama Barang</th>
            <th class="text-center">Costbook Report</th>
            <th class="text-center">Costbook Master</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 0;
        foreach ($list_barang as $item) {
            $no++;

            echo '<tr>
                <td class="text-center">
                    <input type="checkbox" class="check_list" name="check[]" value="' . $item['id_category3'] . '" checked>
                </td>
                <td class="text-center">' . $no . ' <input type="hidden" name="detail[' . $item['id_category3'] . '][id_category3]" value="' . $item['id_category3'] . '"></td>
                <td>' . $item['id_category3'] . '</td>
                <td>' . $item['nm_barang'] . '</td>
                <td class="text-right" style="color: green; font-weight: 700;">' . number_format($item['nilai_costbook_report'], 2) . ' <input type="hidden" name="detail[' . $item['id_category3'] . '][costbook_report]" value="' . $item['nilai_costbook_report'] . '"></td>
                <td class="text-right" style="color: red; font-weight: 700;">' . number_format($item['nilai_costbook_master'], 2) . '</td>
            </tr>';
        }
        ?>
    </tbody>
</table>

<script>
    $(document).on('click', '#check_all', function() {
        // Cek apakah #check_all tercentang atau tidak
        if ($(this).prop('checked')) {
            // Jika tercentang, centang semua checkbox yang ada
            $('input[type="checkbox"]').prop('checked', true);
        } else {
            // Jika tidak tercentang, hilangkan tanda centang dari semua checkbox
            $('input[type="checkbox"]').prop('checked', false);
        }
    })
</script>