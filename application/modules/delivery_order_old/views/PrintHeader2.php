<html>
<head>
  <title>Delivery Order</title>
  <style type="text/css">
        .header_style_company{
            padding: 15px;
            color: black;
            font-size: 20px;
            vertical-align:bottom;
        }
        .header_style_company2{
            padding: 15px;
            color: black;
            font-size: 15px;
            vertical-align:top;
        }

        .header_style_alamat{
            padding: 10px;
            color: black;
            font-size: 10px;
        }

        table.default {
            font-family: arial,sans-serif;
            font-size:9px;
            padding: 0px;
        }

        p{
            font-family: arial,sans-serif;
            font-size:14px;
        }
        
        .font{
            font-family: arial,sans-serif;
            font-size:14px;
        }

        table.gridtable {
            font-family: arial,sans-serif;
            font-size:10px;
            color:#333333;
            border: 1px solid #808080;
            border-collapse: collapse;
        }
        table.gridtable th {
            padding: 6px;
            background-color: #f7f7f7;
            color: black;
            border-color: #808080;
            border-style: solid;
            border-width: 1px;
        }
        table.gridtable th.head {
            padding: 6px; 
            background-color: #f7f7f7;
            color: black;
            border-color: #808080;
            border-style: solid;
            border-width: 1px;
        }
        table.gridtable td {
            border-width: 1px;
            padding: 6px;
            border-style: solid;
            border-color: #808080;
        }
        table.gridtable td.cols {
            border-width: 1px;
            padding: 6px;
            border-style: solid;
            border-color: #808080;
        }


        table.gridtable2 {
            font-family: arial,sans-serif;
            font-size:13px;
            color:#333333;
            border-width: 1px;
            border-color: #666666;
            border-collapse: collapse;
        }
        table.gridtable2 td {
            border-width: 1px;
            padding: 1px;
            border-style: none;
            border-color: #666666;
            background-color: #ffffff;
        }
        table.gridtable2 td.cols {
            border-width: 1px;
            padding: 1px;
            border-style: none;
            border-color: #666666;
            background-color: #ffffff;
        }

        table.gridtableX {
            font-family: arial,sans-serif;
            font-size:12px;
            color:#333333;
            border: none;
            border-collapse: collapse;
        }
        table.gridtableX td {
            border-width: 1px;
            padding: 2px;
        }
        table.gridtableX td.cols {
            border-width: 1px;
            padding: 2px;
        }

        table.gridtableX2 {
            font-family: arial,sans-serif;
            font-size:12px;
            color:#333333;
            border: none;
            border-collapse: collapse;
        }
        table.gridtableX2 td {
            border-width: 1px;
            padding: 2px;
        }
        table.gridtableX2 td.cols {
            border-width: 1px;
            padding: 2px;
        }

        #testtable{
            width: 100%;
        }
    </style>
</head>
<body>
<?php
	foreach($header as $header){
	}
?>


<table border="0" width='100%'>
    <tr>
        <td align="left">
            <img src='<?=$_SERVER['DOCUMENT_ROOT'];?>/metalsindo/assets/images/logo_metalsindo.jpeg' alt="" height='30' width='60'>
        </td>
        <td align="left">
            <h5 style="text-align: left;">PT METALSINDO PACIFIC</h5>
        </td>
    </tr>
</table>
<div style='display:block; border-color:none; background-color:#c2c2c2;' align='center'>
    <h4>DELIVERY ORDER</h4>
</div>
<table class='gridtableX' border="0" width='100%' align="center" cellpadding='0' cellspacing='0'>
    <tr>
        <td>
            <p style="text-align: center;"><b>NO : <?= $header->no_surat ?></b></p>
        </td>
    </tr>
</table>
<table class='gridtableX' width='100%' cellpadding='0' cellspacing='0' border='0'>
    <tbody>
        <tr>
            <td style='width: 50%;' rowspan='2'>
                Address <br>
                Jl. Jababeka XIV, Blok J no. 10 H <br>
                Cikarang Industrial Estate, Bekasi 17530<br> 
                Phone: (62-21) 89831726734<br>
                Fax: (62-21) 89831866<br>
                NPWP: 21.098.204.7-414.000
            </td>
            <td style='width: 50%; vertical-align:top; border-collapse: collapse; border-width: 1px; border-bottom:solid;'>
                To :<br>
            </td>
        </tr>
        <tr>
            <td style='width: 50%; vertical-align:top; border-collapse: collapse; border-width: 1px; border:solid;'>
                <?= strtoupper($header->name_customer) ?><br>
                Address :<br>
                <?= $header->address_office?>
            </td>
        </tr>
        <tr>
            <td></td>
            <td style='width: 50%; vertical-align:top;'>
                REFF : <u><?= $header->reff ?></u> / <?= date('d-M-Y', strtotime($header->tgl_delivery_order)) ?>
            </td>
        </tr>
    </tbody>
</table>
<br>
<table class='gridtableX' border="0" width='100%' align="left">
<tr>
	<td align="left">
	   Harap barang-barang tersebut dibawah ini supaya diterima dengan baik sesuai dengan surat pesanan.<br>
	<i>(Please receive this good mentioned with gently care as an order)</i>
	</td>
</tr>
</table>
<br>

<table class='gridtableX' border="1" width='50%' align="center" cellpadding="4" cellspacing="0">
    <tr>
        <td style='width: 50%; vertical-align:top; font-weight:bold;'>
            Supir : <?=$header->driver?> 
        </td>
        <td style='width: 50%; vertical-align:top; font-weight:bold;'>
            No Kendaraan : <?=$header->nopol?> 
        </td>
    </tr>
</table>

<br>

<table class='gridtable' border="1" width='100%' align="center" cellpadding="2" cellspacing="0">
    <tr>
        <th bgcolor="#c9c9c9" rowspan='2' align="center" valign="middle" width="8">NO</th>
        <th bgcolor="#c9c9c9" rowspan='2' align="center" valign="middle" width="110">GOOD OF MERCHANDISE</th>
        <th bgcolor="#c9c9c9" rowspan='2' align="center" valign="middle" width="55">SPEC</th>
        <th bgcolor="#c9c9c9" rowspan='2' align="center" valign="middle" width="115" >LOT NO ALLOY</th>
        <th bgcolor="#c9c9c9" rowspan='2' align="center" valign="middle" width="40" >LOT NO SLIT</th>
        <th bgcolor="#c9c9c9" colspan='3' align="center" valign="middle" width="65">QUANTITY</th>
        <th bgcolor="#c9c9c9" rowspan='2' align="center" valign="middle" width="60">REMARK PALLET NO</th>
    </tr>
    <tr>
        <th bgcolor="#c9c9c9" width="20" align="center">COIL'S</th>
        <th bgcolor="#c9c9c9" width="25" align="center">SHEET'S<</th>
        <th bgcolor="#c9c9c9" width="20" align="center">KG'S</th>
    </tr>
    <?php
    $no=0;
    foreach($detail as $detail){
        $no++;
        $bentuk = $detail->bentuk;
        $length = $detail->length;
        if($detail->length <= 0){
            $length = 'C';
        }
        $spec = floatval($detail->thickness).' x '.floatval($detail->width).' x '.$length;

        $child2 		= $this->db->get_where('ms_inventory_category3', array('id_category3'=>$detail->id_material))->result();
        $bentuk 		= $this->db->get_where('ms_bentuk', array('id_bentuk'=>$child2[0]->id_bentuk))->result();
        $child3 		= $this->db->get_where('ms_inventory_category2', array('id_category2'=>$child2[0]->id_category2))->result();
        $nm_material 	= $bentuk[0]->nm_bentuk.' '.$child3[0]->nama.' '.$child2[0]->nama.' '.$child2[0]->hardness;

        $stock 		    = $this->db->get_where('stock_material', array('id_stock'=>$detail->id_stock))->result();
        ?>
        <tr>
            <td width="8" align="center" ><?= $no ?></td>
            <td width="110"><?=$nm_material ?></td>
            <td width="55"><?= $spec ?></td>
            <td width="115" align="left"><?= $stock[0]->lotno ?></td>
            <td width="40" align="center"><?= $stock[0]->lot_slitting ?></td>
            <td width="20" align="right"><?= $detail->qty_mat;?></td>
            <td width="25" align="right"></td>
            <td width="20" align="right"><?= $detail->weight_mat; ?></td>
            <td width="60" align="left"><?= $detail->remark ?></td> 
        </tr>
    <?php 
    }
    ?>
</table>
<br>
<br>
<table class='gridtableX2' width='100%' cellpadding='0' cellspacing='0' border='0' align='center'>
    <tr>
        <td style='width: 33%; vertical-align:top;text-align:center; border-bottom:none;'></td>
        <td style='width: 33%; vertical-align:top;text-align:center; border-bottom:none;'></td>
        <td style='width: 34%; vertical-align:top;text-align:center; border-bottom:none;'>Cikarang,<?php echo date('d-m-Y')?></td>
    </tr>
</table>

<table class='gridtableX2' width='100%' cellpadding='0' cellspacing='0' border='0' align='center'>
    <tr>
        <td style='width: 33%; vertical-align:top;text-align:center; border-bottom:none;'>YANG MENERIMA<br><i>(RECEIVED BY)</i></td>
        <td style='width: 33%; vertical-align:top;text-align:center; border-bottom:none;'>DIPERIKSA<br><i>(CHECKED BY)</i></td>
        <td style='width: 34%; vertical-align:top;text-align:center; border-bottom:none;'>HORMAT KAMI<br><i>(YOURS FAITHFULLY)</i></td>
    </tr>
    <tr>
        <td height='70' align='center'></td>
        <td></td>
        <td></td>
    </tr>
	<tr>
        <td style='width: 33%; vertical-align:top;text-align:center; border-bottom:none;'>STEMPEL/NAMA JELAS</td>
        <td style='width: 33%; vertical-align:top;text-align:center; border-bottom:none;'>POS JAGA</td>
        <td style='width: 34%; vertical-align:top;text-align:center; border-bottom:none;'>GUDANG JADI</td>
    </tr>
</table>
