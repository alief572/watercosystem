<?php
date_default_timezone_set("Asia/Bangkok");
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
            font-style: kitfont; 
            font-family:Arial;
            font-size:9pt;
			font-weignt:bold;
            color:#000;
        }
        body
        {
            width:100%;
            font-family:Arial;
            font-style: kitfont;
            font-size:9pt;
			font-weight:bold;
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
            /*
            border-top: solid 1px #000;
            border-bottom: solid 1px #000;
            */
           border : solid 1px #000;
            margin: 0px;
            height: auto;
        }

        #tabel-laporan td{
            border : solid 1px #000;
            margin: 0px;
            height: auto;
        }
        #tabel-laporan {
          border-bottom:1px solid #000 !important;
        }

        .isi td{
          border-top:0px !important;
          border-bottom:0px !important;
        }
		
		 #grey
        {
             background:#eee;
        }

        #footer
        {
            /*width:180mm;*/
            margin:0 15mm;
            padding-bottom:3mm;
        }
        #footer table
        {
            width:100%;
            border-left: 1px solid #ccc;
            border-top: 1px solid #ccc;

            background:#eee;

            border-spacing:0;
            border-collapse: collapse;
        }
        #footer table td
        {
            width:25%;
            text-align:center;
            font-size:9pt;
            border-right: 1px solid #ccc;
            border-bottom: 1px solid #ccc;
        }

        img.resize {
          max-width:12%;
          max-height:12%;
        }
		.pagebreak 
		{
		width:100% ;
		page-break-after: always;
		margin-bottom:10px;
		}
    </style>
</head>
<body>

    <br>
	    <table valign="top" width="100%" id="tabel-laporan" style="!important; padding: 0 !important;">
		
		<?php
			echo "<tr>";
			echo "<th align='center' valign='top'>Nomor Invoice</th>";
			echo "<th align='center' valign='top'>Customer</th>";
			echo "<th align='center' valign='top'>Total Invoice</th>";
			echo "<th align='center' valign='top'>Total PPH</th>";
			echo "<th align='center' valign='top'>Sisa Invoice</th>";
			echo "<th align='center' valign='top'>Total Bayar</th>";
			echo "</tr>";	
		?>
		        	
		<?php
								    
			$detail        = $this->db->query("SELECT * FROM tr_invoice_payment_detail WHERE kd_pembayaran ='$kodebayar'")->result();
			
			

			
			foreach($detail as $val=>$det){
				
			$kodeinv = $det->no_invoice;
			
			$inv_det  = $this->db->query("SELECT * FROM tr_invoice_header WHERE no_invoice ='$kodeinv'")->row();
			
			
		
		?>
		
		<tbody>
			<tr>
				<td class="text-center"><?php echo $det->no_invoice ?></td>
				<td class="text-center"><?php echo $det->nm_customer ?></td>
				<td class="text-right" align="right"><?php echo  number_format($inv_det->total_invoice_idr,2)?></td>
				<td class="text-right" align="right"><?php echo  number_format($inv_det->total_pph_idr,2)?></td>
				<td class="text-right" align="right"><?php echo  number_format($inv_det->sisa_invoice_idr,2)?></td>
				<td class="text-right" align="right"><?php echo  number_format($det->total_bayar_idr,2)?></td>
				
			</tr>
		</tbody>
		
		<?php
		
				}
				
				$data_header    = $this->db->query("SELECT * FROM tr_invoice_payment WHERE kd_pembayaran ='$kodebayar'")->row();
				$coapph         = $data_header->jenis_pph;
				$coa            =  $this->db->query("SELECT * FROM ".DBACC.".coa_master WHERE no_perkiraan = '$coapph' ")->row();
                $data_detail    = $this->db->query("SELECT sum(total_bayar_idr) as total_bayar FROM tr_invoice_payment_detail WHERE kd_pembayaran ='$kodebayar'")->row();
		
		?>
		        	
		<tbody>
			<tr>
				<td class="text-center"  colspan='5'> <b>Total Bayar</b></td>
				<td class="text-right"   align="right"><b><?php echo  number_format( $data_detail->total_bayar,2)?></b></td>
				
			</tr>
			<tr>
				<td class="text-center"  colspan='5'> <b>Administrasi Bank</b></td>
				<td class="text-right"   align="right"><b><?php echo  number_format( $data_header->biaya_admin_idr,2)?></b></td>
				
			</tr>
			<tr>
				<td class="text-center"  colspan='5'> <b>PPH <?php echo $coa->nama ?> </b></td>
				<td class="text-right"   align="right"><b><?php echo  number_format( $data_header->biaya_pph_idr,2)?></b></td>
				
			</tr>
			<tr>
				<td class="text-center"  colspan='5'> <b>Total Penerimaan </b></td>
				<td class="text-right" align="right"><b><?php echo  number_format( $data_header->jumlah_bank_idr,2)?></b></td>
				
			</tr>
		</tbody>
		
		</table>

    
   
</body>
</html>
