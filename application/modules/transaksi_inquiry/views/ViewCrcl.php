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
				<th><center><label>CRCL</label></center></th>
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
						<td size='70%'><?= $header->tgl_inquiry?></td>
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
						<tr><td>Custommer</td><td>:</td><td><?= $header->name_customer ?></td></tr>
						<tr><td>Address</td><td>:</td><td><?= $header->address_office ?></td></tr>
						<tr><td>Phone</td><td>:</td><td><?= $header->telephone ?></td></tr>
						<tr><td>FAX</td><td>:</td><td><?= $header->fax ?></td></tr>
					</table>
					<center>
					</td>
			</tr>
			</table>
			</center>
			</td>
		</tr>
		<tr>
			<td colspan='2' >
			<table class='col-sm-12' border='1'>
			<tr>
			<td rowspan='2'><center>Unit</center></td>
			<td rowspan='2'><center>Part</center></td>
			<td rowspan='2'><center>Item</center></td>
			<td colspan='4'><center>Description Of Merchendise</center></td>
			</tr>
			<tr>
			
			<td><center>Aloy</center></td>
			<td><center>Hardness</center></td>
			<td><center>Thickness</center></td>
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
			</tr>
			<?php
			}
			?>
			</table>
					</td>
		</tr>	
		</table>		
		</div>		  
	</div>
</div>	
	
				  
				  
				  
