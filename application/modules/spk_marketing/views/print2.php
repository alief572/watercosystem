<html>
<head>
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
            font-size:10px;
            color:#333333;
            border: none;
            border-collapse: collapse;
            margin-top:10px;
        }
        table.gridtableX td {
            border-width: 1px;
            padding: 4px;
        }
        table.gridtableX td.cols {
            border-width: 1px;
            padding: 4px;
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

        .noneborder{
            border:none;
        }
        .nonebordercst{
            border-top:none;
            border-bottom:none;
        }
    </style>
</head>
<body>

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
    <h3>SURAT PERINTAH KERJA<br>NO : <?=$header[0]->no_surat;?></h3>
</div>
<table class='gridtableX' width='100%' cellpadding='0' cellspacing='0' border='0'>
    <tbody>
        <tr>
            <td>PO</td>
            <td>:</td>
            <td><?=strtoupper($header[0]->nama_customer);?></td>
        </tr>
        <tr>
            <td>Sample</td>
            <td>:</td>
            <td><?=strtoupper($header[0]->sample);?></td>
        </tr>
        <tr>
            <td>Status</td>
            <td>:</td>
            <td></td>
        </tr>
    </tbody>
</table>
<br>
<table class='gridtable' width='100%' border='1' cellpadding='0' cellspacing='0'>
    <tr>
        <td class='noneborder'></td>
        <td class='nonebordercst' width='99'></td>
        <td colspan='2' align='center'><b>MARKETING</b></td>
        <td colspan='2' align='center'><b>PRODUCTION (Temporary Schedule)</b></td>
    </tr>
    <tr>
        <td class='noneborder' width='10'>To</td>
        <td class='nonebordercst' width='99'>: &nbsp;&nbsp;PRODUKSI</td>
        <td width='80'>Date SPK</td>
        <td width='80' align='center'><?=date('d-M-Y', strtotime($header[0]->tgl_spk_marketing));?></td>
        <td width='92'>Tgl Produksi</td>
        <td width='80'></td>
    </tr>
    <tr>
        <td class='noneborder'>Attn</td>
        <td class='nonebordercst' width='30'>: </td>
        <td>Date PO</td>
        <td align='center'><?=date('d-M-Y', strtotime($header[0]->tgl_po));?></td>
        <td>Mulai Produksi</td>
        <td></td>
    </tr>
    <tr>
        <td class='noneborder'></td>
        <td class='nonebordercst'></td>
        <td>Delivery Plan by Customer</td>
        <td align='center' width='125'><?=date('d-M-Y', strtotime($header[0]->plan_cust));?></td>
        <td>Urutan Produksi</td>
        <td width='125'></td>
    </tr>
    <tr>
        <td class='noneborder'></td>
        <td class='nonebordercst'></td>
        <td>No PO</td>
        <td><?=strtoupper($header[0]->no_po);?></td>
        <td>Urutan Delivery</td>
        <td></td>
    </tr>
</table>
<br>
    <?php
    $matauang = (!empty($header->matauang))?"<br>(".strtoupper($header->matauang).")":'';
    ?>
    <table class='gridtable'  cellpadding='0' cellspacing='0' width='100%' style='width:100% !important; vertical-align:top;'>
        <tbody>
            <tr style='vertical-align:middle; background-color:#c2c2c2; font-weight:bold;'>
                <td align="center" rowspan='2'>NO.</td>
                <td align="center" rowspan='2'>PRODUCT/ITEM</td>
                <td width='90' align="center" colspan='5'>DESCRIPTION</td>
                <td width='50' align="center" rowspan='2'>QTY (KG)</td>
                <td width='50' align="center" rowspan='2'>DELIVERY DATE</td>
                <td width='50' align="center" rowspan='2'>DELIVERY (KG)</td>
                <td align="center" rowspan='2'>+- (KG)</td>
            </tr>
            <tr style='vertical-align:middle; background-color:#c2c2c2; font-weight:bold;'>
                <td width='22' align="center">Aloy</td>
                <td width='22' align="center">Hard</td>
                <td width='22' align="center">Thick</td>
                <td width='22' align="center">Width</td>
                <td width='22' align="center">Lenght</td>
            </tr>
			<?php
            $a=0;
            $SUM=0;
            foreach($detail AS $val => $valx){$a++;
                $SUM += $valx['qty_produk']
                ?>
                <tr>
                    <td width='5' align="center"><?=$a?></td>
                    <td width='100'><?=$valx['item'];?></td>
                    <td width='22' align='center'><?=$valx['aloy'];?></td>
                    <td width='22' align='center'><?=$valx['hardness'];?></td>
                    <td width='22' align='center'><?=number_format($valx['thickness'],2);?></td>
                    <td width='22' align='center'><?=$valx['width'];?></td>
                    <td width='22' align='center'><?php if($valx['length'] <= 0){ echo"C";}else{echo number_format($valx['length'],2);}; ?></td>
                    <td width='50' align='right'><?=number_format($valx['qty_produk'],2);?></td>
                    <td width='50' align='center'><?= date('d-M-Y',strtotime($valx['delivery']));?></td>
                    <td width='50'></td>
                    <td width='50'></td>
                </tr>
                <?php
            }
            ?>
             <tr>
                <th></th>
                <th colspan='6'>TOTAL QUANTITY</th>
                <th align='right'><?=number_format($SUM,2);?></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </tbody>
	</table>
	<br>
    <table class='gridtable'  cellpadding='0' cellspacing='0' width='100%' style='width:100% !important; vertical-align:top;'>
        <tbody>
            <tr style='vertical-align:middle; background-color:#c2c2c2; font-weight:bold;'>
                <td align="center" rowspan='2'>NO.</td>
                <td align="center" rowspan='2' width='92'>ITEM<br>MATERIAL</td>
                <td width='35' align="center" rowspan='2'>SIZE MOTHER COIL</td>
                <td width='35' align="center" rowspan='2'>WEIGHT (KG)</td>
                <td width='35' align="center" rowspan='2'>SIZE</td>
                <td width='35' align="left">Sliting</td>
                <td align="center" colspan='2'>QTY</td>
                <td align="center" colspan='2'>TARGET PRODUKSI</td>
                <td align="center" rowspan='2'>Remarks</td>
            </tr>
            <tr style='vertical-align:middle; background-color:#c2c2c2; font-weight:bold;'>
                <td width='35' align="left">Shearing</td>
                <td width='35' align="center">Coil</td>
                <td width='35' align="center">Sheet</td>
                <td width='35' align="center">Target</td>
                <td width='35' align="center">Actual</td>
            </tr>
			<?php
           $a=0;
           foreach($detail AS $val => $valx){$a++;
                ?>
                <tr>
                    <td align="center" width='5'><?=$a?></td>
                    <td width='92'></td>
                    <td width='35'></td>
                    <td width='35'></td>
                    <td width='35'></td>
                    <td width='35'></td>
                    <td width='35'></td>
                    <td width='35'></td>
                    <td width='35'></td>
                    <td width='35'></td>
                    <td width='35'></td>
                </tr>
                <?php
            }
            ?>
             <tr>
                <th></th>
                <th colspan='5'>TOTAL QUANTITY</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </tbody>
	</table>
    <br>
    <table class='gridtable' width='100%' border='1' cellpadding='0' cellspacing='0'>
        <tr>
            <td width='340'>NOTE</td>
            <td width='30' class='nonebordercst' ></td>
            <td width='120' align="center" >PREPARED BY</td>
            <td width='120' align="center" >APPROVED BY</td>
        </tr>
        <tr>
            <td  width='340' height='50'  style='border-bottom:none;'><?=strtoupper($header[0]->note);?></td>
            <td class='nonebordercst' ></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td style='border-top:none;'></td>
            <td class='nonebordercst' ></td>
            <td align="center" >MARKETING</td>
            <td align="center" >PRODUCTION</td>
        </tr>
    </table>

    
</body>
</html>