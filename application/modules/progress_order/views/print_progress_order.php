<html>
<head>
  <title>Cetak PDF</title>
<style>
    table.gridtable {
		font-family: Arial, Helvetica, sans-serif;
		font-size:11px;
		color:#333333;
		border: 1px solid #dddddd;
		border-collapse: collapse;
	}
	table.gridtable th {
		padding: 6px;
		background-color: #0049a8;
		color: white;
		border-color: #0049a8;
		border-style: solid;
		border-width: 1px;
	}
	table.gridtable th.head {
		padding: 6px; 
		background-color: #0049a8;
		color: white;
		border-color: #0049a8;
		border-style: solid;
		border-width: 1px;
	}
	table.gridtable tr:nth-child(even) {
		background-color: #f2f2f2;
	}
	table.gridtable td {
		padding: 6px;
	}
	table.gridtable td.cols {
		padding: 6px;
	}
</style>
</head>
<body>
    <table border="0"  align="center"  width='100%' >
        <tr>
            <td width="700" align="left" valign="top">
                <h5 style="text-align: left;">PT. METALSINDO PACIFIC</h5>
            </td>
        </tr>
            <tr>
            <td width="700" align="center" valign="top">
                <h4 style="text-align: center;">PROGRESS ORDER REPORT</h4>
            </td>
        </tr>
    </table>
    <br>
    <table class='gridtable' width='100%'  align="center" border='1' cellpadding='2'>
        <thead>
        <tr>
			<td>#</td>
			<td>SPK Marketing</td>
            <td>Customer</td>
            <td>Alloy</td>
            <td>Thickness</td>
            <td>Width</td>
            <td>Delivery Date</td>
            <td>Qty Order</td>
            <td>Stock</td>
            <td>Balance Stock</td>
            <td>SPK Produksi</td>
            <td>Balance Order</td>
		</tr>
        </thead>
        <?php 
		if(!empty($detail)){
			$numb=0; 
            foreach($detail AS $record){ $numb++; 
                $get_fg_booking = $this->db->select('SUM(berat) AS qty_booking')->get_where('stock_material_customer', array('id_dt_spkmarketing'=>$record->id_dt_spkmarketing))->result();
                $get_qty_aktual = $this->db->select('SUM(qtyaktual) AS qty_aktual')->get_where('dt_spk_aktual', array('no_surat'=>$record->id_dt_spkmarketing))->result();
                $get_qty_produksi = $this->db->select('SUM(totalwidth) AS qty_produksi')->get_where('dt_spk_produksi', array('no_surat'=>$record->id_dt_spkmarketing))->result();

                $fg_booking     = (!empty($get_fg_booking))?$get_fg_booking[0]->qty_booking:0;
                $qty_aktual     = (!empty($get_qty_aktual))?$get_qty_aktual[0]->qty_aktual:0;
                $qty_produksi   = (!empty($get_qty_produksi))?$get_qty_produksi[0]->qty_produksi:0;

                $stock          = $qty_aktual + $fg_booking;
                $balance_stock  = $record->totalwidth - $stock;
                $spk_produksi   = $qty_produksi;
                $balance_order  = $qty_produksi - $balance_stock;

                ?>
                <tr>
                    <td><?= $numb; ?></td>
                    <td><?= $record->no_surat ?></td>
                    <td><?= $record->namacustomer ?></td>
                    <td><?= $record->nmmaterial ?></td>
                    <td align='right'><?= number_format($record->thickness,2) ?></td>
                    <td align='right'><?= number_format($record->weight,2) ?></td>
                    <td align='right'><?= date('d F Y', strtotime($record->delivery)) ?></td>
                    <td align='right'><?= number_format($record->totalwidth,2) ?></td>
                    <td align='right'><?= number_format($stock,2) ?></td>
                    <td align='right'><?= number_format($balance_stock,2) ?></td>
                    <td align='right'><?= number_format($spk_produksi,2) ?></td>
                    <td align='right'><?= number_format($balance_order,2) ?></td>
                </tr>
                <?php 
            } 
        }  ?>
    </table>
</body>