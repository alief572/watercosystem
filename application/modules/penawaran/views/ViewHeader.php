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
				<th><center><label>Quotation</label></center></th>
			</tr>
			</table>
			</td>
		</tr>	
		<tr>
			<td size='50%'>
			<table >
			<tr align = 'center'>
				<td>
					<table size='50%'>
						<tr><td colspan='4'>Address :</td></tr>
						<tr><td colspan='4'>Jl. Jababeka XIV, Blok J no. 10 H</td></tr>
						<tr><td colspan='4'>Cikarang Industrial Estate, Bekasi 17530</td></tr>
						<tr>
						<td>PHONE :</td>
						<td>(62-21)89831726734</td>
						<td>,FAX</td>
						<td>(62-21)89831866</td>
						</tr>
						<tr><td>NPWP:</td>
						<td >21.098.204.7-414.000</td>
						<td colspan='2'></td></tr>
					</table>
				</td>
			</tr>
			</table>
			</td>
			<td size='50%'>
			<table >
			<tr>
				<td>
				<table size='50%'>
						<tr >
						<td size='30%'>QUOTE No. :</td>
						<td size='70%'><?= $header->no_surat ?></td>
						</tr>
						<tr>
						<td size='30%'>Date On.  :</td>
						<td size='70%'><?= $header->tgl_penawaran ?></td>
						</tr>
				</table>
				</td>
			</tr>
			</table>
			</td>
		</tr>

		<tr>
			<td colspan='2' >
			<center>
			<table class='col-sm-12' border='1'>
			<tr>
				<td><center><table>
						<tr><td>Customer</td><td>:</td><td><?= $header->name_customer ?></td></tr>
						<tr><td>Address</td><td>:</td><td><?= $header->address_office ?></td></tr>
						<tr><td>Phone</td><td>:</td><td><?= $header->telephone ?></td></tr>
						<tr><td>FAX</td><td>:</td><td><?if(empty($header->fax)){echo"-";}else{echo"$header->fax";}  ?></td></tr>
						<tr><td>U.P</td><td>:</td><td><?= $header->pic_customer ?></td></tr>
					</table>
					<center>
					</td>
			</tr>
			</table>
			</center>
			</td>
		</tr>
		<tr><?if($header->mata_uang=='USD'){?>
			<td colspan='2' >
			<table class='col-sm-12' border='1'>
			<tr>
			<td rowspan='2'><center>Unit</center></td>
			<td rowspan='2'><center>Part</center></td>
			<td rowspan='2'><center>Item</center></td>
			<td colspan='5'><center>Description Of Merchendise</center></td>
			<td colspan='2'><center>Price/Kg</center></td>
			<td rowspan='2'><center>Remark</center></td>
			</tr>
			<tr>
			
			<td><center>Aloy</center></td>
			<td><center>Hardness</center></td>
			<td><center>Thickness</center></td>
			<td><center>Width</center></td>
			<td><center>Length</center></td>
			<td><center>USD</center></td>
			<td><center>IDR</center></td>
			</tr>
			
			<?php 
				foreach ($results['detail'] as $detail){
			?>
			<tr>
			<td><?= $detail->bentuk_material ?></td>
			<td><?= $detail->lotno ?></td>
			<td><?= $detail->nama2 ?></td>
			<td><?= $detail->nama3 ?></td>
			<td><?= $detail->hardness ?></td>
			<td><?= $detail->nilai ?></td>
			<td><?= $detail->width ?></td>
			<td><?php if($detail->id_bentuk == 'B2000001'){ echo"C";}else{echo"$detail->length";}; ?></td>
			<td>$ <?= number_format($detail->harga_dolar,2) ?></td>
			<td>Rp <?= number_format($detail->harga_penawaran_cust,2) ?></td>
			<td><?= $detail->keterangan ?></td>
			</tr>
			<?php
			};
			?>
			</table>
		</td>
		<?php
		}else{
			?>
		<td colspan='2' >
			<table class='col-sm-12' border='1'>
			<tr>
			<td rowspan='2'><center>Unit</center></td>
			<td rowspan='2'><center>Part</center></td>
			<td rowspan='2'><center>Item</center></td>
			<td colspan='5'><center>Description Of Merchendise</center></td>
			<td rowspan='2'><center>Price/Kg</center></td>
			<td rowspan='2'><center>Remark</center></td>
			</tr>
			<tr>
			
			<td><center>Aloy</center></td>
			<td><center>Hardness</center></td>
			<td><center>Thickness</center></td>
			<td><center>Width</center></td>
			<td><center>Length</center></td>
			</tr>
			
			<?php 
				foreach ($results['detail'] as $detail){
			?>
			<tr>
			<td><?= $detail->bentuk_material ?></td>
			<td><?= $detail->lotno ?></td>
			<td><?= $detail->nama2 ?></td>
			<td><?= $detail->nama3 ?></td>
			<td><?= $detail->hardness ?></td>
			<td><?= $detail->nilai ?></td>
			<td><?= $detail->width ?></td>
			<td><?php if($detail->id_bentuk == 'B2000001'){ echo"C";}else{echo"$detail->length";}; ?></td>
			<td>Rp <?= number_format($detail->harga_penawaran,2) ?></td>
			<td><?= $detail->keterangan ?></td>
			</tr>
			<?php
			};
			?>
			</table>
		</td>
		<?php
		}
		?>
		</tr>
		<tr>
			<td colspan='2' >
			<table class='col-sm-12' border='1'>
			<tr>
			<td colspan='4'>
			<table class='table table-bordered table-striped'>
			<tr>
			<td width='10%' valign='middle'>Note :</td>
			<td width='90%'><?= nl2br($header->note) ?></td>
			</tr>
			</table>
			</td>
			</tr>
			<tr>
			<td><center>Valid Until</center></td>
			<td><center>Terms Of Payment</center></td>
			<td rowspan='2'><center><?= $header->pengiriman ?>,<?php if($header->pengiriman == 'Loco'){
					echo"PT METALSINDO PACIFIC";
				}else{
					echo "$header->name_customer ";
				}?></center></td>
			<td rowspan='2'><center>Exclude vat <?= $header->exclude_vat ?> %</center></td>
			</tr>
			<tr>
			<td><center><?= $header->valid_until ?></center></td>
			<td><center><?= $header->terms_payment ?></center></td>
			</tr>
			</table>
			</td>
		</tr>		
		</table>		
		</div>		  
	</div>
</div>	
	
				  
				  
				  
