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
            font-size:11px;
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
            font-size:12px;
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
            padding: 6px;
        }
        table.gridtableX td.cols {
            border-width: 1px;
            padding: 6px;
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
    $findnegara = empty($header->negara) ? null : $this->db->query('SELECT nm_negara FROM negara WHERE id_negara = ?',array($header->negara))->row();
    $cou = empty($header->negara) ? 'Indonesia' : ($findnegara ? $findnegara->nm_negara : '-');
    $findpic = $this->db->query('SELECT name_pic FROM child_supplier_pic WHERE id_suplier = ? LIMIT 1',array($header->id_suplier))->row();
    $namapic = $findpic ? $findpic->name_pic : '-';
    $itemShipping = array_sum(array_map(function($row) { return (float)$row->pajak; },$detail));
?>
<table border="0px" cellspacing="0" width='100%' valign="top">
    <tr>
        <td align="left"width="70%" valign="top" >
            <img src='<?= html_escape(FCPATH . 'assets/images/logo_waterco.png') ?>' alt="" height='100' width='250'>
        </td>
        <td align="right" valign="top" width="30%">
			<br>
            PT WATERCO INDONESIA<br>
            Inkopal Plaza Kelapa Gading Blok B, No.31-32 <br> 
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			Jl. Boulevard Barat, Jakarta-14240, Indonesia<br>
			Phone: +62 21 4585 1481, Fax: +62 21 4585 1480<br>
			Website: www.waterco.co.id<br>
            E-Mail:waterco@waterco.co.id
            
        </td>
    </tr>
</table>
<hr>
<div style='display:block; border-color:none; background-color:#c2c2c2;' align='center'>
    <h3>PURCHASE ORDER</h3>
</div>
<br>
<table class='gridtable2' width='100%' border='1' align='left' cellpadding='0' cellspacing='0'>
    <tr>
        <td width="300" align="center">
            <table width='300' align="center">
                <tr><td width='50' align="left">Supplier</td><td width='10' align="left">:</td><td width='250' align="left"><?= html_escape($header->name_suplier ?? "") ?></td></tr>
                <tr><td width='50' align="left">Address</td><td width='10' align="left">:</td><td width='250' align="left"><?= html_escape($header->address_office ?? "") ?></td></tr>
                <tr><td width='50' align="left">Country</td><td width='10' align="left">:</td><td width='250' align="left"><?= html_escape($cou ?? "") ?></td></tr>
                <tr><td width='50' align="left">PIC</td><td width='10' align="left">:</td><td width='250' align="left"><?= html_escape($namapic ?? "") ?></td></tr>
                <tr><td width='50' align="left">Phone</td><td width='10' align="left">:</td><td width='250' align="left"><?= html_escape($header->telephone ?? "") ?></td></tr>
                <tr><td width='50' align="left">Fax</td><td width='10' align="left">:</td><td width='250' align="left"><?php if(empty($header->fax)){echo"-";}else{echo html_escape($header->fax);}  ?></td></tr>
            </table>
        </td>
        <td width="300" align="center">
            <table width='300' align="center">
                <tr><td width='50' align="left">No</td><td width='10' align="left">:</td><td width='250' align="left"><?= html_escape($header->no_surat ?? "") ?></td></tr>
                <tr><td width='50' align="left">Date</td><td width='10' align="left">:</td><td width='250' align="left"><?=  date('d-F-Y', strtotime($header->tanggal))  ?></td></tr>
                <tr><td width='50' align="left">Revision</td><td width='10' align="left">:</td><td width='250' align="left"></td></tr>
                <tr><td width='50' align="left">Page</td><td width='10' align="left">:</td><td width='250' align="left"></td></tr>
                <tr><td width='50' align="left">Ref PI</td><td width='10' align="left">:</td><td width='250' align="left"></td></tr>
                <tr><td width='50' align="left">&nbsp;</td><td width='10' align="left"></td><td width='250' align="left"></td></tr>
           </table>
        </td>
    </tr>
</table>
<br>
    <?php
    $matauang = (!empty($header->matauang))?"<br>(".strtoupper($header->matauang).")":'';

    $kode = html_escape(strtoupper($header->matauang ?? ''));
    if(strtolower($header->matauang ?? '') == 'usd'){
        $kode = '$';                                      
    }
    if(strtolower($header->matauang ?? '') == 'idr'){
        $kode = 'Rp';                                      
    }
    ?>
    <table class='gridtable'  cellpadding='0' cellspacing='0' style='vertical-align:top;'>
        <tbody>
            <tr style='vertical-align:middle; background-color:#c2c2c2; font-weight:bold;'>
                <td align="center" width='50'>Code</td>
                <td align="center" width='330'>Description</td>
                <td align="center" width='40'>Price &nbsp;(<?=$kode?>) </td>
				<td align="center" width='40'>Qty</td>
                <td align="center" width='50'>Total &nbsp;(<?=$kode?>) </td>
               
            </tr>
			<?php	
            foreach($detail as $detail){
                $HS = number_format($detail->hargasatuan,2);
                $JH = number_format($detail->jumlahharga,2);
                $detail = clone $detail;
                foreach (array('product_code','nama','namamaterial') as $field) $detail->$field = html_escape($detail->$field ?? '');
                echo "<tr>
                    <td width='50'>".$detail->product_code."</td>
                    <td width='330'>".$detail->nama."</td>
                    <td width='50' align='right'>".$HS."</td>
                    <td width='50'>".$detail->qty."</td>
                    <td width='80' align='right'>".$JH."</td>
                </tr>";
			} ?>

			<tr>
                <td align="right" colspan='4'>Total </td>
                <td align="right"><?= number_format($header->total_barang ?? 0,2) ?></td>
              
			</tr>		
            <?php if ((float)$header->diskontotal != 0) { ?>
            <tr><td align="right" colspan="4">Discount</td><td align="right"><?= number_format($header->diskontotal ?? 0,2) ?></td></tr>
            <?php } if ($itemShipping != 0) { ?>
            <tr><td align="right" colspan="4">Biaya Kirim Item</td><td align="right"><?= number_format($itemShipping,2) ?></td></tr>
            <?php } ?>
            <tr>
                <td align="right" colspan='4'>Biaya Kirim </td>
                <td align="right"><?= number_format($header->taxtotal ?? 0,2) ?></td>
              
			</tr>	
				 <?php
				if((float)$header->total_ppn != 0){
                ?>
			 <tr>
                <td align="right" colspan='4'>PPN </td>
                <td align="right"><?= number_format($header->total_ppn ?? 0,2) ?></td>
              
			</tr>
			  <?php
				}
				?>
             <tr>
                <td align="right" colspan='4'>Grand Total </td>
                <td align="right"><?= number_format($header->subtotal ?? 0,2) ?></td>
              
			</tr>
			
        </tbody>
	</table>
	<br>

	<table border="0" width='100%' align="left">

		<tr>
		
			<td width="250" align="left"><br><br>
			<table>
			<tr><td align='center'></td></tr>
			<tr><td align="center"width="70%" valign="top" >
           </td></tr>
			<tr><td align='center'> </td></tr>
			<tr><td align='center'></td></tr>	
			</table>
			</td>
			<td width="250" align="left"><br><br>
			<table>
			<tr><td align='center'></td></tr>
			<tr><td align="center"width="70%" valign="top" >
			 </td></tr>
			<tr><td align='center'></td></tr>
			<tr><td align='center'></td></tr>	
			</table>
			</td>
			<td width="250" align="left"><br><br>
			<table>
			<tr><td align='center'></td></tr>
			<tr><td align='right'></td></tr>
			<tr><td align='right'></td></tr>
			<tr><td align='right'></td></tr>
			<tr><td align='right'></td></tr>
			<tr><td align='right'></td></tr>
			<tr><td align='right'></td></tr>
			<tr><td align='right'></td></tr>
			<tr><td align='right'></td></tr>
			<tr><td align='right'></td></tr>
			<tr><td align='right'></td></tr>
			<tr><td align='right'></td></tr>
			<tr><td align='right'></td></tr>
			<tr><td align='right'></td></tr>
			<tr><td align='right'></td></tr>
			<tr><td align='right'></td></tr>
			<tr><td align='right'></td></tr>
			<tr><td align='center'><u></u></td></tr>
			<tr><td align='center'>(Rengky)</td></tr>	
			</table>
			</td>
		</tr>
	</table>
    

    
</body>
</html>