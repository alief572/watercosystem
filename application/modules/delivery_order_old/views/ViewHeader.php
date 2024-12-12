<?php
    $ENABLE_ADD     = has_permission('master_bentuk.Add');
    $ENABLE_MANAGE  = has_permission('master_bentuk.Manage');
    $ENABLE_VIEW    = has_permission('master_bentuk.View');
    $ENABLE_DELETE  = has_permission('master_bentuk.Delete');
	$id_category1 = $this->uri->segment(3);	
	foreach ($results['header'] as $header){
	}	
?>
 <div class="box box-primary">
    <div class="box-body">
		<div class='col-sm-12'>
		<table 	class='col-sm-12'>
		<tr >
			<td colspan='2'>
			<table 	class='col-sm-12'>
			<tr>
				<th> PT Metalsindo Pacific</th>
				<th size ='50%'></th>
				<th size='25%'></th>
			</tr>
			</table>
			</td>
		</tr>
		<tr >
			<td colspan='2'>
			<table 	class='col-sm-12' border='1'>
			<tr align = 'center'>
				<th><center><label>DELIVERY ORDER</label></center></th>
			</tr>
			</table>
			</td>
		</tr>	
		<tr>
			<td size='50%'>
			<table border="0" width='100%' align="center">
			<tr>
				<td width="350" align="left">
				Address <br>
				Jl. Jababeka XIV, Blok J no. 10 H <br>
				Cikarang Industrial Estate, Bekasi 17530<br> 
				PHONE:(62-21)89831726734,FAX(62-21)89831866<br>
				NPWP:	21.098.204.7-414.000
				</td>
				<td width="350" align="left">
				
				To<br>
				<?= $header->name_customer ?><br>
				Address<br>
				<?= $header->address_office?>
				</td>
			</tr>
			<tr>
				<td width="350" align="left">
				</td>
				<td width="350" align="left">	
				REFF :
				<u><?= $header->reff ?></u>
				</td>
			</tr>
			</table>
			<br>
			
		</tr>

		<table border="0" width='100%' align="center">
		<tr>
			<td width="700" align="left">
			   Harap barang-barang tersebut dibawah ini supaya diterima dengan baik sesuai dengan surat pesanan.<br>
			<i>(Please receive this good mentioned with gently care as an order)</i>
			</td>
		</tr>
		</table>
		<br>

		<table id="tables" border="1px" width='50%' align="center" cellpadding="2" cellspacing="0">
		<tr>
			<th width="350" align="left">
			Supir : <?=$header->driver?> 
			</th>
			<th width="350" align="left">
			No Kendaraan : <?=$header->nopol?> 
			</th>
		</tr>
		</table>

		<br>

		<table id="tables" border="1px" width='100%' align="center" cellpadding="2" cellspacing="0">
			<tr>
			<th bgcolor="#c9c9c9" rowspan='2' align="center" valign="middle"  width="50">NO</th>
			<th bgcolor="#c9c9c9"  rowspan='2' align="center" valign="middle"  width="100">GOOD OF MERCHANDISE</th>
			<th bgcolor="#c9c9c9" rowspan='2' align="center" valign="middle"  width="50">SPEC</th>
			<th bgcolor="#c9c9c9" rowspan='2' align="center" valign="middle" width="150" >LOT NO ALLOY</th>
			<th bgcolor="#c9c9c9"rowspan='2' align="center" valign="middle" width="100" >LOT NO SLIT</th>
			<th bgcolor="#c9c9c9" colspan='3' align="center" valign="middle"  width="100">QUANTITY</th>
			<th bgcolor="#c9c9c9" rowspan='2' align="center" valign="middle" width="50">REMARK PALLET NO</th>
			</tr>
			<tr>
			
			<th bgcolor="#c9c9c9" width="60" align="center">COIL'S</th>
			<th bgcolor="#c9c9c9" width="50" align="center">SHEET'S</th>
			<th bgcolor="#c9c9c9" width="50" align="center">KG'S</th>
			
			</tr>
			<?php
                $no=0;
                foreach($results['detail'] as $detail){
				$no++;
				$bentuk = $detail->bentuk;
				
			?>
			<tr>
			<td align="center" ><?= $no ?></td>
			<td align="center"><?= $detail->id_material ?></td>
			<td align="center"><?= $detail->no_alloy ?></td>
			<td width="50" align="center"><?= $detail->lotno ?></td>
			<td width="50" align="center"><?= $detail->lot_slitting ?></td>
			<td width="50" align="center">
			<?php if($bentuk =='B2000001'){ 
			      echo $detail->qty_mat;
			} ?>
			</td>
			<td width="50" align="center">
			<?php if($bentuk =='B2000002'){ 
			      echo $detail->qty_mat;
			} ?>
			</td>
			<td width="60" align="center"><?= $detail->weight_mat   ?></td>
			<td width="60" align="center"><?= $detail->remark ?></td> 
			</tr>
			<?php }
			?>
			

	    </table>
				
		</div>		  
	</div>
</div>	
	
				  
				  
				  
