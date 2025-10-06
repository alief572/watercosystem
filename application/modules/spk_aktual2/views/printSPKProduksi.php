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
        margin: 30px;
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

    table.gridtable2 {
		font-family: Arial, Helvetica, sans-serif;
		font-size:12px;
		color:#333333;
		border-width: 1px;
		border-color: #666666;
		border-collapse: collapse;
	}
	table.gridtable2 th {
		border-width: 1px;
		padding: 3px;
		border-style: none;
		border-color: #666666;
		background-color: #f2f2f2;
	}
	table.gridtable2 th.head {
		border-width: 1px;
		padding: 3px;
		border-style: none;
		border-color: #666666;
		background-color: #7f7f7f;
		color: #ffffff;
	}
	table.gridtable2 td {
		border-width: 1px;
		padding: 3px;
		border-style: none;
		border-color: #666666;
		background-color: #ffffff;
	}
	table.gridtable2 td.cols {
		border-width: 1px;
		padding: 3px;
		border-style: none;
		border-color: #666666;
		background-color: #ffffff;
	}

    table.gridtable3 {
		font-family: Arial, Helvetica, sans-serif;
		font-size:12px;
		color:#333333;
		border-width: 1px;
		border-color: #666666;
		border-collapse: collapse;
        margin: 25px;
	}
	table.gridtable3 th {
		border-width: 1px;
		padding: 3px;
		border-style: none;
		border-color: #666666;
		background-color: #f2f2f2;
	}
	table.gridtable3 th.head {
		border-width: 1px;
		padding: 3px;
		border-style: none;
		border-color: #666666;
		background-color: #7f7f7f;
		color: #ffffff;
	}
	table.gridtable3 td {
		border-width: 1px;
		padding: 3px;
		border-style: none;
		border-color: #666666;
		background-color: #ffffff;
	}
	table.gridtable3 td.cols {
		border-width: 1px;
		padding: 3px;
		border-style: none;
		border-color: #666666;
		background-color: #ffffff;
	}
</style>
</head>
<?php
    $id_spkproduksi = (!empty($header))?$header[0]->id_spkproduksi:'';
    $no_surat = (!empty($header))?$header[0]->no_surat:'';
    $tgl_spk_produksi = (!empty($header))?$header[0]->tgl_spk_produksi:'';
    $id_material = (!empty($header))?$header[0]->id_material:'';
    $density = (!empty($header))?$header[0]->density:'';
    $thickness = (!empty($header))?$header[0]->thickness:'';
    $width = (!empty($header))?$header[0]->width:'';
    $weight = (!empty($header))?$header[0]->weight:'';
    $lpegangan = (!empty($header))?$header[0]->lpegangan:'';
    $lotno = (!empty($header))?$header[0]->lotno:'';
    $panjang = (!empty($header))?$header[0]->panjang:'';
    $nama_material = (!empty($header))?$header[0]->nama_material:'';

    $process = (!empty($header))?$header[0]->process:'';
    $kg_process = (!empty($header))?$header[0]->kg_process:'';
    $length = (!empty($header))?$header[0]->length:'';
    $count_m = (!empty($header))?$header[0]->count_m:'';

    $id_stock = (!empty($header))?$header[0]->id_stock:'';

    $qcoil = (!empty($header))?$header[0]->qcoil:'';
    $jpisau = (!empty($header))?$header[0]->jpisau:'';
    $used = (!empty($header))?$header[0]->used:'';
    $sisa = (!empty($header))?$header[0]->sisa:'';
    $id_spkproduksi = (!empty($header))?$header[0]->id_spkproduksi:'';
	$keterangan = (!empty($header))?$header[0]->keterangan:'';
?>
<body>
    <table border="0"  align="center"  width='100%' >
        <tr>
            <td width="700" align="left" valign="top">
                <h5 style="text-align: left;">PT. METALSINDO PACIFIC</h5>
            </td>
        </tr>
            <tr>
            <td width="700" align="center" valign="top">
                <h4 style="text-align: center;">SPK PRODUKSI</h4>
            </td>
        </tr>
    </table>
    <br>
    <table class='gridtable2' border='0' align='center' width='100%' cellpadding='2'>
        <tr>
            <td width='15%' align="left">No. SPK</td>
            <td width='10%' align="left" valign="top">:</td>
            <td width='20%' align="left" valign="top"><?=$no_surat;?></td>
            <td width='10%' align="left" valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td width='15%' align="left">Tanggal</td>
            <td width='20%' align="left" valign="top">:</td>
            <td width='10%' align="left" valign="top"><?=date('d F Y', strtotime($tgl_spk_produksi));?></td>
        </tr>
        <tr>
            <td align="left">Material</td>
            <td align="left" valign="top">:</td>
            <td align="left" valign="top"><?=$material($id_material);?></td>
            <td align="left" valign="top"></td>
            <td align="left">Lot Number</td>
            <td align="left" valign="top">:</td>
            <td align="left" valign="top"><?=$stock($id_stock);?></td>
        </tr>
        <tr>
            <td align="left">Density</td>
            <td align="left" valign="top">:</td>
            <td align="left" valign="top"><?=number_format($density,2);?></td>
            <td align="left" valign="top"></td>
            <td align="left">Thickness</td>
            <td align="left" valign="top">:</td>
            <td align="left" valign="top"><?=number_format($thickness,2);?></td>
        </tr>
        <tr>
            <td align="left">Width (mm)</td>
            <td align="left" valign="top">:</td>
            <td align="left" valign="top"><?=number_format($width,2);?></td>
            <td align="left" valign="top"></td>
            <td align="left">Process | Kg Process</td>
            <td align="left" valign="top">:</td>
            <td align="left" valign="top"><?=number_format($process,2).' / '.number_format($kg_process,2);?></td>
        </tr>
        <tr>
            <td align="left">Weight</td>
            <td align="left" valign="top">:</td>
            <td align="left" valign="top"><?=number_format($weight,2);?></td>
            <td align="left" valign="top"></td>
            <td align="left">Length (m) | Count (m)</td>
            <td align="left" valign="top">:</td>
            <td align="left" valign="top"><?=number_format($length,2).' / '.number_format($count_m,2);?></td>
        </tr>
        <tr>
            <td align="left">Lebar Pegangan</td>
            <td align="left" valign="top">:</td>
            <td align="left" valign="top"><?=number_format($lpegangan,2);?></td>
            <td align="left" valign="top"></td>
            <td align="left"></td>
            <td align="left" valign="top"></td>
            <td align="left" valign="top"></td>
        </tr>
    </table>
    <br>
    <table class='gridtable' width='100%'  align="left" border='1' cellpadding='2'>
        <tr>
            <td width='3%'>No</td>
            <td>SPK Marketing</td>
            <td width='15%'>Customer</td>
            <td width='10%'>Nomor Alloy</td>
            <td width='7%'>Width</td>
            <td width='7%'>@KG</td>
            <td width='7%'>@Coil</td>
            <td width='7%'>Total Kg</td>
            <td width='7%'>Delivery Date</td>
        </tr>
        <?php 
        $loop=0;
        foreach($detail as $val => $dt_spk){$loop++; 
        ?>
            <tr>
                <td width='10' style='vertical-align:top;'  align='center'><?=$loop;?></td>
                <td width='100' style='vertical-align:top;'><?=strtoupper($no_suratx($dt_spk['no_surat']));?></td>
                <td width='100' style='vertical-align:top;'><?=$dt_spk['namacustomer'];?></td>
                <td width='100' style='vertical-align:top;'><?=$dt_spk['nmmaterial'];?></td>
                <td width='30'  style='vertical-align:top;' align='right'><?=number_format($dt_spk['weight'],2);?></td>
                <td width='30'  style='vertical-align:top;' align='right'><?=number_format($dt_spk['width'],2);?></td>
                <td width='30'  style='vertical-align:top;' align='right'><?=number_format($dt_spk['qtycoil'],2);?></td>
                <td width='30'  style='vertical-align:top;' align='right'><?=number_format($dt_spk['totalwidth'],2);?></td>
                <td width='60'  style='vertical-align:top;' align='right'><?=date('d F Y', strtotime($dt_spk['delivery']));?></td>
            </tr>
        <?php
        }
        ?>
    </table>
    <br>
    <table class='gridtable3' border='0' width='100%' cellpadding='2'>
	
        <tr>
            <td width='15%' align="left">Total Coil</td>
            <td width='10%' align="left" valign="top">:</td>
            <td width='20%' align="left" valign="top"><?=number_format($qcoil,2);?></td>
            <td width='15%' align="left" valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td width='15%' align="left" valign="top" rowspan="1">Note</td>
            <td width='20%' align="left" valign="top" rowspan="3">:</td>
            <td width='10%' align="left" valign="top" rowspan="3"><i>"<?= $keterangan?>"</i></td>
        </tr>
        <tr>
            <td align="left">Jumlah Pisau</td>
            <td align="left" valign="top">:</td>
            <td align="left" valign="top"><?=number_format($jpisau,2);?></td>
            <td align="left" valign="top"></td>
           
        </tr>
        <tr>
            <td align="left">Sisa Potongan</td>
            <td align="left" valign="top">:</td>
            <td align="left" valign="top"><?=number_format($sisa,2);?></td>
            <td align="left" valign="top"></td>
           
        </tr>
	
	
	
	
    </table>
</body>