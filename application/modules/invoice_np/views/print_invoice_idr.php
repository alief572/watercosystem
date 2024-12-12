<?php
date_default_timezone_set("Asia/Bangkok");
$tglprint2 = date("d-m-Y");
$date = tgl_indo($total->tgl_invoice);//date('d-m-Y');
$invoice  = $total->no_invoice;
$so  = $total->so_number;
$total2  = $total->total_invoice;
$nm_customer  = $total->nm_customer;

?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <style>
    @font-face { font-family: kitfont; src: url('1979 Dot Matrix Regular.TTF'); }
      html
        {
            margin:0;
            padding:0;
            font-size:11px;
			<!--font-weignt:bold;-->
            color:#000;
        }
        body
        {
            width:100%;
            font-family: "Times New Roman", Times, serif;
            font-size:11px;
			<!--font-weignt:bold;-->
            margin:0;
            padding:0;
        }

        p
        {
            margin:0;
            padding:0;
        }

        .page
        {
            width: 210mm;
            height: 145mm;
            page-break-after:always;
        }

        #header-tabel tr {
            padding: 0px;
        }
        #tabel-laporan {
            border-spacing: -1px;
            padding: 0px !important;
        }

        #tabel-laporan th{
           border : solid 1px #000;
            margin: 0px;
        }
        #tabel-laporan td{
            border : solid 1px #000;
            margin: 0px;
        }
        #tabel-laporan {
          border-bottom:1px solid #000 !important;
        }
		.pagebreak {
			width:100% ;
			page-break-after: always;
			margin-bottom:10px;
		}
    </style>
</head>
<body>
	<table width="100%"  border=0 >
		<tr>
			<td colspan=3 align=center>INVOICE</td>
		</tr>
		<tr>
			<td>
			</td>
			<td width="20%">
			</td>
			<td>
			<table border=0>
			<tr><td>Invoice No.</td><td>: <?=$invoice?></td></tr>
			<tr><td>Date</td><td>: <?=date("F d, Y",strtotime($total->tgl_invoice))?></td></tr>
			<tr><td>Reff PO No.</td><td>: <?=$total->keterangan?></td></tr>
			<tr><td>Tax No.</td><td>: <?=$total->no_pajak?></td></tr>
			</table>
			</td>
		</tr>
		<tr>
			<td>
			BILL TO :<br />
			<?=$nm_customer?><br />
			<?=$customer->alamat?><br />
			Phone : <?=$customer->telpon?><br />
			Fax : <?=$customer->fax?><br />
			Attn. : <?=$pic_customer->nm_pic?><br />
			</td>
			<td width="20%">
			</td>
			<td>
			</td>
		</tr>
	</table>
	<table width="100%" id="tabel-laporan" >
		<thead>
     	<tr>
			<td style='height:50px; width:5% !important;' align="center">No</td>
			<td style='height:50px; width:30% !important;' align="center">Description</td>
			<td style='height:50px; width:10% !important;' align="center">Quantity</td>
			<td style='height:50px; width:10% !important;' align="center" colspan=2>Unit Price IDR</td>
			<td style='height:50px; width:14% !important;' align="center" colspan=2>Total Price IDR</td>
		</tr>
        </thead>
        <tbody>
		<?php
		if( ! empty($results)){
			$no = 1;
			$page=1;
			foreach($results as $data){
				echo "<tr>";
					echo "<td align='center' valign='top'>".$no."</td>";
					echo "<td valign='top'>".$data->desc."</td>";
					echo "<td valign='top' align='center'>".($data->qty)." ".($data->unit)."</td>";
					echo "<td valign='top' align='center' style='border-color: black white black black;'>IDR</td>";
					echo "<td valign='top' align='right' style='border-color: black black black white;'>".number_format($data->harga_satuan_usd,2)."</td>";
					echo "<td valign='top' align='center' style='border-color: black white black black;'>IDR</td>";
					echo "<td valign='top' align='right' style='border-color: black black black white;'>".number_format($data->harga_total_usd,2)."</td>";
				echo "</tr>";
				$no++;
		    }	
		}
		
		echo "<tr>";
			echo "<td colspan='2'></td>";
            echo "<td colspan='3' align=center>";
				if($total->ppn_persen > 0){echo 'VAT<br>';}
				if($total->total_invoice_usd > 0){echo 'TOTAL AMOUNT<br>';}
            echo "</td>";
			echo "<td align='center' style='border-color: black white black black;'>";
				if($total->ppn_persen > 0){echo 'IDR<br>';}
				if($total->total_invoice_usd > 0){echo 'IDR<br>';}
            echo "</td>";
            echo "<td align='right' style='border-color: black black black white;'>";
				if($total->ppn_persen > 0){echo number_format($total->total_ppn_idr,2).'<br>';}
				if($total->total_invoice_usd > 0){echo number_format($total->total_invoice_usd,2).'<br>';}
			echo "</td>";
        echo "</tr>";
		?>
    </table>
	<br><br>
    <?php
		
	echo "<table border='0' width='100%' cellpadding='0'>";
			echo "<tr>";
				echo "<td width='12%'></td>";
				echo "<td width='18%' style='vertical-align:top;'>";
					echo "<table class='sign' width='100%' cellpadding='2'>";
						echo "<tr>";
							echo "<td width='40%'>For and on Behalf of<br />PT. WATERCO INDONESIA</td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td style='height:70px;'></td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td><b>__________________________<br />Finance</b></td>";
						echo "</tr>";
					echo "</table>";
				echo "</td>";
				echo "<td width='12%'></td>";
				echo "<td width='58%' style='vertical-align:top;'>";
					echo "<table class='catatan' border='0' width='100%' cellpadding='2'>";
						echo "<tr>";
							echo "<td>   
							
							             


										Pembayaran dilakukan melalui rekening :<br>
										CIMB Niaga cabang kelapa gading
										No A/C. 8000-9570-4600(IDR)<br>
										BCA cabang kelapa gading square
										No A/C. 870-003-599-0(IDR)<br>
										On Behalf PT. WATERCO INDONESIA
									</td>";
						echo "</tr>";
					echo "</table>";
				echo "</td>";
				
			echo "</tr>";
		echo "</table>";
	?>
    
   
</body>
</html>
