<?php
    $ENABLE_ADD     = has_permission('Transaksi_inquiry.Add');
    $ENABLE_MANAGE  = has_permission('Transaksi_inquiry.Manage');
    $ENABLE_VIEW    = has_permission('Transaksi_inquiry.View');
    $ENABLE_DELETE  = has_permission('Transaksi_inquiry.Delete');
	$tanggal = date('Y-m-d');
	foreach ($results['head'] as $head){
}	
?>

 <div class="box box-primary">
    <div class="box-body">
		<form id="data-head" method="post">
			<div class="col-sm-12">
				<div class="input_fields_wrap2">
<div class="row" id="header">
		<center><label for="customer" ><h3>CRCL (CUSTOMER REQUIREMENTS CHECK LIST)</h3></label></center>
		<div class="col-sm-12">
		<div class="col-sm-6">
		<div class="form-group row">
			<div class="col-md-4">
				<label for="customer">NO.CRCL</label>
			</div>
			<div class="col-md-8">
				<input type="text" class="form-control" id="no_inquiry" value="<?= $head->no_inquiry ?>"  required name="no_inquiry" readonly placeholder="No.CRCL">
			</div>
		</div>
		</div>
		<div class="col-sm-6">
		<div class="form-group row">
			<div class="col-md-4">
				<label for="customer">Tanggal</label>
			</div>
			<div class="col-md-8">
				<input type="date" class="form-control" id="tanggal" readonly value="<?= $tanggal ?>" onkeyup required name="tanggal" readonly >
			</div>
		</div>
		</div>
		</div>
		<div class="col-sm-12">
		<div class="col-sm-6">
		<div class="form-group row">
			<div class="col-md-4">
				<label for="customer">Nama Customer</label>
			</div>
			<div class="col-md-8">
				<input type="text" class="form-control" id="name_customer" value="<?= $head->name_customer ?>"  required name="name_customer" readonly placeholder="No.CRCL">
			</div>
		</div>
		</div>
		<div class="col-sm-6">
		<div class="form-group row">
			<div class="col-md-4">
				<label for="customer">Email</label>
			</div>
			<div class="col-md-8">
				<input type="text" class="form-control" id="email_customer" readonly value="<?= $head->email_customer ?>" onkeyup required name="email_customer" readonly >
			</div>
		</div>
		</div>
		</div>
				<div class="col-sm-12">
		<div class="col-sm-6">
		<div class="form-group row">
			<div class="col-md-4">
				<label for="customer">Sales</label>
			</div>
			<div class="col-md-8">
				<input type="text" class="form-control" id="nama_karyawan" value="<?= $head->nama_karyawan ?>"  required name="nama_karyawan" readonly placeholder="No.CRCL">
			</div>
		</div>
		</div>
		<div class="col-sm-6">
		<div class="form-group row">
			<div class="col-md-4">
				<label for="customer">Pic Customer</label>
			</div>
			<div class="col-md-8">
				<input type="text" class="form-control" id="pic_customer" readonly value="<?= $head->pic_customer ?>"  onkeyup required name="pic_customer" readonly >
			</div>
		</div>
		</div>
		</div>
				<div class="col-sm-12">
		<div class="form-group row" >
		<div class="col-md-12" id='data_customer'>
		<div class='col-sm-6'>
		<div class='form-group row'>
			<div class='col-md-4'>
				<label for='email_customer'>Berat Maksimum/palet</label>
			</div>
			<div class='col-md-8'>
				<input type='nember' class='form-control' id='berat_palet' readonly value="<?= $head->berat_palet ?>" required name='berat_palet' >
			</div>
		</div>
		</div>
		<div class='col-sm-6'>
			<div class='form-group row'>
				<div class='col-md-4'>
					<label for='id_category_supplier'>Tinggi Maksimum/palet</label>
				</div>
				<div class='col-md-8'>
					<input type='number' class='form-control' id='tinggi_palet' readonly value="<?= $head->tinggi_palet ?>" required name='tinggi_palet' >
				</div>
			</div>
		</div>
		</div>
		</div>
		</div>
</div>
<div class="row" id="tombol">
		
		<div class="col-sm-12" align="center">
		<div class="form-group row">
			
			<div class='col-md-1'>
				<input type='button' value='All Data' id='show_all' class='btn btn-primary btn-sm'>
			</div>
			<?php
				foreach ($results['bentuk'] as $bentuk){
					echo"
			<center>
			<div class='col-md-1'>
				<input type='button' value='$bentuk->nm_bentuk' id='show_$bentuk->id_bentuk' class='btn btn-primary btn-sm'>
			</div>
			<center>
					";
			}	
			?>
		</div>
		</div>
</div>
<div class="row" id="semua">
		<div class="col-sm-12">
		<table id="example1" class="table table-bordered table-striped">
		<thead>
		<tr>
			<th width="5">#</th>
			<th width="13%" idden>No. CRCL</th>
			<th>Nama Produk</th>
			<th>Bentuk Material</th>
			<th>Tanggal Reviisi</th>
		</tr>
		</thead>

		<tbody>
		<?php if(empty($results['semua'] )){
		}else{
			
			$numb=0; foreach($results['semua'] AS $all){ $numb++; ?>
		<tr>
		    <td><?= $numb; ?></td>
			<td><?= $all->id_surat_crcl?>-<?= $all->thickness ?></td>
			<td><?= $all->nama_kategori2 ?>-<?= $all->nama_kategori3 ?>-<?= $all->hardnessmt ?>-<?= $all->thickness ?></td>
			<td><?= $all->nm_bentuk ?></td>
			<td><?= $all->created_on ?></td>
		</tr>
		<?php } }  ?>
		</tbody>
		</table>
		</div>
</div>
<div class="row" id="form_B2000001">
	<div class="col-sm-12">
		<div class="col-sm-6">
		<div class="form-group row">
			<?php if($ENABLE_VIEW) : ?>
				<a class="btn btn-primary btn-sm add_roll" href="javascript:void(0)" title="View" data-customer="<?=$head->name_customer?>" data-no_inquiry="<?=$head->no_inquiry?>">Tambah</a>
			<?php endif; ?>
		</div>
</div>		
	</div>
		<div class="col-sm-12">
		<table id="example1" class="table table-bordered table-striped">
		<thead>
		<tr>
			<th width="5">#</th>
			<th width="13%" >No. CRCL</th>
			<th>Nama Produk</th>
			<th>Tanggal Reviisi</th>
			<?php if($ENABLE_MANAGE) : ?>
			<th width="13%">Action</th>
			<?php endif; ?>
		</tr>
		</thead>

		<tbody>
		<?php if(empty($results['roll'] )){
		}else{
			
			$numb=0; foreach($results['roll'] AS $data){ $numb++; ?>
		<tr>
		    <td><?= $numb; ?></td>
			<td ><?= $data->id_surat_crcl?>-<?= $data->thickness ?></td>
			<td><?= $data->nama_kategori2 ?>-<?= $data->nama_kategori3 ?>-<?= $data->hardnessmt ?>-<?= $data->thickness ?></td>
			<td><?= $data->created_on ?></td>
			<td style="padding-left:20px">
			<?php if($ENABLE_VIEW) : ?>
				<a class="btn btn-primary btn-sm view_roll" href="javascript:void(0)" title="View" data-id_dt_inquery="<?=$data->id_dt_inquery?>"><i class="fa fa-eye"></i>
				</a>
			<?php endif; ?>

			<?php if($ENABLE_MANAGE) : ?>
				<a class="btn btn-success btn-sm edit_roll" href="javascript:void(0)" title="Edit" data-id_dt_inquery="<?=$data->id_dt_inquery?>"><i class="fa fa-edit"></i>
				</a>
			<?php endif; ?>

			<?php if($ENABLE_DELETE) : ?>
				<a class="btn btn-danger btn-sm delete_roll" href="javascript:void(0)" title="Edit" data-id_dt_inquery="<?=$data->id_dt_inquery?>"><i class="fa fa-trash"></i>
				</a>
			<?php endif; ?>
			</td>

		</tr>
		<?php } }  ?>
		</tbody>
		</table>

		</div>
</div>
<div class="row" id="form_B2000002">
		<div class="col-sm-12">
<div class="col-sm-6">
		<div class="form-group row">
			<?php if($ENABLE_VIEW) : ?>
				<a class="btn btn-primary btn-sm add_sheet" href="javascript:void(0)" title="View" data-customer="<?=$head->name_customer?>"data-no_inquiry="<?=$head->no_inquiry?>">Tambah</a>
			<?php endif; ?>
		</div>
</div>		
	</div>
		<div class="col-sm-12">
		<table id="example1" class="table table-bordered table-striped">
		<thead>
		<tr>
			<th width="5">#</th>
			<th width="13%" >No CRCL</th>
			<th width="13%" hidden>Bentuk Material</th>
			<th>Nama Produk</th>
			<th>Tanggal Revisi</th>
			<?php if($ENABLE_MANAGE) : ?>
			<th width="13%">Action</th>
			<?php endif; ?>
		</tr>
		</thead> 

		<tbody>
		<?php if(empty($results['sheet'] )){ 
		}else{
			
			$numb=0; foreach($results['sheet'] AS $data2){ $numb++; ?>
		<tr>
		    <td><?= $numb; ?></td>
			<td ><?= $data2->id_surat_crcl?>-<?= $data2->thickness ?></td>
			<td hidden><?= $data2->no_inquiry?></td>
			<td><?= $data2->nama_kategori2 ?>-<?= $data2->nama_kategori3 ?>-<?= $data2->hardnessmt ?>-<?= $data2->thickness ?></td>
			<td ><?= $data2->created_on?></td>
			<td style="padding-left:20px">
			<?php if($ENABLE_VIEW) : ?>
				<a class="btn btn-primary btn-sm view_sheet" href="javascript:void(0)" title="View" data-id_dt_inquery="<?=$data2->id_dt_inquery?>"><i class="fa fa-eye"></i>
				</a>
			<?php endif; ?>

			<?php if($ENABLE_MANAGE) : ?>
				<a class="btn btn-success btn-sm edit_sheet" href="javascript:void(0)" title="Edit" data-id_dt_inquery="<?=$data2->id_dt_inquery?>"><i class="fa fa-edit"></i>
				</a>
			<?php endif; ?>

			<?php if($ENABLE_DELETE) : ?>
				<a class="btn btn-danger btn-sm delete_sheet" href="javascript:void(0)" title="Edit" data-id_dt_inquery="<?=$data2->id_dt_inquery?>"><i class="fa fa-trash"></i>
				</a>
			<?php endif; ?>
			</td>

		</tr>
		<?php } }  ?>
		</tbody>
		</table>
		</div>
</div>
<div class="row" id="form_B2000003">
		<div class="col-sm-12">
			<div class="col-sm-6">
		<div class="form-group row">
			<?php if($ENABLE_VIEW) : ?>
				<a class="btn btn-primary btn-sm add_round" href="javascript:void(0)" title="View" data-customer="<?=$head->name_customer?>"data-no_inquiry="<?=$head->no_inquiry?>">Tambah</a>
			<?php endif; ?>
		</div>
</div>		
	</div>
		<div class="col-sm-12">
		<table id="example1" class="table table-bordered table-striped">
		<thead>
		<tr>
			<th width="5">#</th>
			<th width="13%" hidden>Bentuk Material</th>
			<th>Nama Produk</th>
			<?php if($ENABLE_MANAGE) : ?>
			<th width="13%">Action</th>
			<?php endif; ?>
		</tr>
		</thead>

		<tbody>
		<?php if(empty($results['round'] )){
		}else{
			
			$numb=0; foreach($results['round'] AS $data3){ $numb++; ?>
		<tr>
		    <td><?= $numb; ?></td>
			<td hidden><?= $data3->no_inquiry?></td>
			<td><?= $data3->nama_kategori2 ?>-<?= $data3->nama_kategori3 ?>-<?= $data3->hardnessmt ?>-<?= $data3->thickness ?></td>
			<td style="padding-left:20px">
			<?php if($ENABLE_VIEW) : ?>
				<a class="btn btn-primary btn-sm view_round" href="javascript:void(0)" title="View" data-id_dt_inquery="<?=$data3->id_dt_inquery?>"><i class="fa fa-eye"></i>
				</a>
			<?php endif; ?>

			<?php if($ENABLE_MANAGE) : ?>
				<a class="btn btn-success btn-sm edit_round" href="javascript:void(0)" title="Edit" data-id_dt_inquery="<?=$data3->id_dt_inquery?>"><i class="fa fa-edit"></i>
				</a>
			<?php endif; ?>

			<?php if($ENABLE_DELETE) : ?>
				<a class="btn btn-danger btn-sm delete_round" href="javascript:void(0)" title="Edit" data-id_dt_inquery="<?=$data3->id_dt_inquery?>"><i class="fa fa-trash"></i>
				</a>
			<?php endif; ?>
			</td>

		</tr>
		<?php } }  ?>
		</tbody>
		</table>
		</div>
</div>
<div class="row" id="form_B2000004">
		<div class="col-sm-12">
		<div class="col-sm-6">
		<div class="form-group row">
			<?php if($ENABLE_VIEW) : ?>
				<a class="btn btn-primary btn-sm add_square" href="javascript:void(0)" title="View" data-customer="<?=$head->name_customer?>"data-no_inquiry="<?=$head->no_inquiry?>">Tambah</a>
			<?php endif; ?>
		</div>
</div>		
	</div>
		<div class="col-sm-12">
		<table id="example1" class="table table-bordered table-striped">
		<thead>
		<tr>
			<th width="5">#</th>
			<th width="13%" hidden>Bentuk Material</th>
			<th>Nama Produk</th>
			<?php if($ENABLE_MANAGE) : ?>
			<th width="13%">Action</th>
			<?php endif; ?>
		</tr>
		</thead>

		<tbody>
		<?php if(empty($results['square'] )){
		}else{
			
			$numb=0; foreach($results['square'] AS $data4){ $numb++; ?>
		<tr>
		    <td><?= $numb; ?></td>
			<td hidden><?= $data4->no_inquiry?></td>
			<td><?= $data4->nama_kategori2 ?>-<?= $data4->nama_kategori3 ?>-<?= $data4->hardnessmt ?>-<?= $data4->thickness ?></td>
			<td style="padding-left:20px">
			<?php if($ENABLE_VIEW) : ?>
				<a class="btn btn-primary btn-sm view_square" href="javascript:void(0)" title="View" data-id_dt_inquery="<?=$data4->id_dt_inquery?>"><i class="fa fa-eye"></i>
				</a>
			<?php endif; ?>

			<?php if($ENABLE_MANAGE) : ?>
				<a class="btn btn-success btn-sm edit_square" href="javascript:void(0)" title="Edit" data-id_dt_inquery="<?=$data4->id_dt_inquery?>"><i class="fa fa-edit"></i>
				</a>
			<?php endif; ?>

			<?php if($ENABLE_DELETE) : ?>
				<a class="btn btn-danger btn-sm delete_square" href="javascript:void(0)" title="Edit" data-id_dt_inquery="<?=$data4->id_dt_inquery?>"><i class="fa fa-trash"></i>
				</a>
			<?php endif; ?>
			</td>

		</tr>
		<?php } }  ?>
		</tbody>
		</table>
		</div>
</div>
<div class="row" id="form_B2000005">
		<div class="col-sm-12">
		<div class="col-sm-6">
		<div class="form-group row">
			<?php if($ENABLE_VIEW) : ?>
				<a class="btn btn-primary btn-sm add_hexa" href="javascript:void(0)" title="View" data-customer="<?=$head->name_customer?>"data-no_inquiry="<?=$head->no_inquiry?>">Tambah</a>
			<?php endif; ?>
		</div>
</div>		
	</div>
		<div class="col-sm-12">
		<table id="example1" class="table table-bordered table-striped">
		<thead>
		<tr>
			<th width="5">#</th>
			<th width="13%" hidden>Bentuk Material</th>
			<th>Nama Produk</th>
			<?php if($ENABLE_MANAGE) : ?>
			<th width="13%">Action</th>
			<?php endif; ?>
		</tr>
		</thead>

		<tbody>
		<?php if(empty($results['hexa'] )){
		}else{
			
			$numb=0; foreach($results['hexa'] AS $data5){ $numb++; ?>
		<tr>
		    <td><?= $numb; ?></td>
			<td hidden><?= $data2->no_inquiry?></td>
			<td><?= $data5->nama_kategori2 ?>-<?= $data5->nama_kategori3 ?>-<?= $data5->hardnessmt ?>-<?= $data5->thickness ?></td>
			<td style="padding-left:20px">
			<?php if($ENABLE_VIEW) : ?>
				<a class="btn btn-primary btn-sm view_hexa" href="javascript:void(0)" title="View" data-id_dt_inquery="<?=$data5->id_dt_inquery?>"><i class="fa fa-eye"></i>
				</a>
			<?php endif; ?>

			<?php if($ENABLE_MANAGE) : ?>
				<a class="btn btn-success btn-sm edit_hexa" href="javascript:void(0)" title="Edit" data-id_dt_inquery="<?=$data5->id_dt_inquery?>"><i class="fa fa-edit"></i>
				</a>
			<?php endif; ?>

			<?php if($ENABLE_DELETE) : ?>
				<a class="btn btn-danger btn-sm delete_hexa" href="javascript:void(0)" title="Edit" data-id_dt_inquery="<?=$data5->id_dt_inquery?>"><i class="fa fa-trash"></i>
				</a>
			<?php endif; ?>
			</td>

		</tr>
		<?php } }  ?>
		</tbody>
		</table>
		</div>
</div>
<div class="row" id="form_B2000006">
		<div class="col-sm-12">
		<div class="col-sm-6">
		<div class="form-group row">
			<?php if($ENABLE_VIEW) : ?>
				<a class="btn btn-primary btn-sm add_okta" href="javascript:void(0)" title="View" data-customer="<?=$head->name_customer?>"data-no_inquiry="<?=$head->no_inquiry?>">Tambah</a>
			<?php endif; ?>
		</div>
</div>		
	</div>
		<div class="col-sm-12">
		<table id="example1" class="table table-bordered table-striped">
		<thead>
		<tr>
			<th width="5">#</th>
			<th width="13%" hidden>Bentuk Material</th>
			<th>Nama Produk</th>
			<?php if($ENABLE_MANAGE) : ?>
			<th width="13%">Action</th>
			<?php endif; ?>
		</tr>
		</thead>

		<tbody>
		<?php if(empty($results['okta'] )){
		}else{
			
			$numb=0; foreach($results['okta'] AS $data6){ $numb++; ?>
		<tr>
		    <td><?= $numb; ?></td>
			<td hidden><?= $data6->no_inquiry?></td>
			<td><?= $data6->nama_kategori2 ?><?= $data6->nama_kategori3 ?><?= $data6->hardnessmt ?>-<?= $data6->thickness ?></td>
			<td style="padding-left:20px">
			<?php if($ENABLE_VIEW) : ?>
				<a class="btn btn-primary btn-sm view_okta" href="javascript:void(0)" title="View" data-id_dt_inquery="<?=$data6->id_dt_inquery?>"><i class="fa fa-eye"></i>
				</a>
			<?php endif; ?>

			<?php if($ENABLE_MANAGE) : ?>
				<a class="btn btn-success btn-sm edit_okta" href="javascript:void(0)" title="Edit" data-id_dt_inquery="<?=$data6->id_dt_inquery?>"><i class="fa fa-edit"></i>
				</a>
			<?php endif; ?>

			<?php if($ENABLE_DELETE) : ?>
				<a class="btn btn-danger btn-sm delete_okta" href="javascript:void(0)" title="Edit" data-id_dt_inquery="<?=$data6->id_dt_inquery?>"><i class="fa fa-trash"></i>
				</a>
			<?php endif; ?>
			</td>

		</tr>
		<?php } }  ?>
		</tbody>
		</table>
		</div>
</div>
<div class="row" id="form_B2000007">
		<div class="col-sm-12">
		<div class="col-sm-6">
		<div class="form-group row">
			<?php if($ENABLE_VIEW) : ?>
				<a class="btn btn-primary btn-sm add_tube" href="javascript:void(0)" title="View" data-customer="<?=$head->name_customer?>"data-no_inquiry="<?=$head->no_inquiry?>">Tambah</a>
			<?php endif; ?>
		</div>
</div>		
	</div>
		<div class="col-sm-12">
		<table id="example1" class="table table-bordered table-striped">
		<thead>
		<tr>
			<th width="5">#</th>
			<th width="13%" hidden>Bentuk Material</th>
			<th>Nama Produk</th>
			<?php if($ENABLE_MANAGE) : ?>
			<th width="13%">Action</th>
			<?php endif; ?>
		</tr>
		</thead>

		<tbody>
		<?php if(empty($results['tube'] )){
		}else{
			
			$numb=0; foreach($results['tube'] AS $data7){ $numb++; ?>
		<tr>
		    <td><?= $numb; ?></td>
			<td hidden><?= $data7->no_inquiry?></td>
			<td><?= $data7->nama_kategori2 ?><?= $data7->nama_kategori3 ?><?= $data7->hardnessmt ?>-<?= $data7->thickness ?></td>
			<td style="padding-left:20px">
			<?php if($ENABLE_VIEW) : ?>
				<a class="btn btn-primary btn-sm view_tube" href="javascript:void(0)" title="View" data-id_dt_inquery="<?=$data7->id_dt_inquery?>"><i class="fa fa-eye"></i>
				</a>
			<?php endif; ?>

			<?php if($ENABLE_MANAGE) : ?>
				<a class="btn btn-success btn-sm edit_tube" href="javascript:void(0)" title="Edit" data-id_dt_inquery="<?=$data7->id_dt_inquery?>"><i class="fa fa-edit"></i>
				</a>
			<?php endif; ?>

			<?php if($ENABLE_DELETE) : ?>
				<a class="btn btn-danger btn-sm delete_tube" href="javascript:void(0)" title="Edit" data-id_dt_inquery="<?=$data7->id_dt_inquery?>"><i class="fa fa-trash"></i>
				</a>
			<?php endif; ?>
			</td>

		</tr>
		<?php } }  ?>
		</tbody>
		</table>
		</div>
</div>
<div class="row" id="form_B2000009">
		<div class="col-sm-12">
		<div class="col-sm-6">
		<div class="form-group row">
			<?php if($ENABLE_VIEW) : ?>
				<a class="btn btn-primary btn-sm add_penta" href="javascript:void(0)" title="View" data-customer="<?=$head->name_customer?>"data-no_inquiry="<?=$head->no_inquiry?>">Tambah</a>
			<?php endif; ?>
		</div>
</div>		
	</div>
		<div class="col-sm-12">
		<table id="example1" class="table table-bordered table-striped">
		<thead>
		<tr>
			<th width="5">#</th>
			<th width="13%" hidden>Bentuk Material</th>
			<th>Nama Produk</th>
			<?php if($ENABLE_MANAGE) : ?>
			<th width="13%">Action</th>
			<?php endif; ?>
		</tr>
		</thead>

		<tbody>
		<?php if(empty($results['penta'] )){
		}else{
			
			$numb=0; foreach($results['penta'] AS $data9){ $numb++; ?>
		<tr>
		    <td><?= $numb; ?></td>
			<td hidden><?= $data9->no_inquiry?></td>
			<td><?= $data9->nama_kategori2 ?><?= $data9->nama_kategori3 ?><?= $data9->hardnessmt ?>-<?= $data9->thickness ?></td>
			<td style="padding-left:20px">
			<?php if($ENABLE_VIEW) : ?>
				<a class="btn btn-primary btn-sm view_penta" href="javascript:void(0)" title="View" data-id_dt_inquery="<?=$data9->id_dt_inquery?>"><i class="fa fa-eye"></i>
				</a>
			<?php endif; ?>

			<?php if($ENABLE_MANAGE) : ?>
				<a class="btn btn-success btn-sm edit_penta" href="javascript:void(0)" title="Edit" data-id_dt_inquery="<?=$data9->id_dt_inquery?>"><i class="fa fa-edit"></i>
				</a>
			<?php endif; ?>

			<?php if($ENABLE_DELETE) : ?>
				<a class="btn btn-danger btn-sm delete_penta" href="javascript:void(0)" title="Edit" data-id_dt_inquery="<?=$data9->id_dt_inquery?>"><i class="fa fa-trash"></i>
				</a>
			<?php endif; ?>
			</td>

		</tr>
		<?php } }  ?>
		</tbody>
		</table>
		</div>
</div>
<div type='row' id='close_button'>
		<div class="col-sm-12">
		<div class="col-sm-6">
		<div class="form-group row">
						<a class="btn btn-primary btn-sm" href="<?= base_url('/transaksi_inquiry') ?>" title="Detail" >Back</a>
				</a></div>
</div>		
	</div>
</div>
				 </div>
			</div>
		</form>		  
	</div>
</div>	
<!-- Modal -->
<div class="modal modal-primary" id="dialog-rekap" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel"><span class="fa fa-file-pdf-o"></span>&nbsp;Rekap Data Customer</h4>
      </div>
      <div class="modal-body" id="MyModalBody">
		...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">
        <span class="glyphicon glyphicon-remove"></span>  Close</button>
        </div>
    </div>
  </div>
</div>

<div class="modal modal-default fade" id="dialog-popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel"><span class="fa fa-users"></span>&nbsp;Detail</h4>
      </div>
      <div class="modal-body" id="ModalView">
		...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">
        <span class="glyphicon glyphicon-remove"></span>  Close</button>
        </div>
    </div>
  </div>
</div>	
				  
				  
				  
<script type="text/javascript">
	//$('#input-kendaraan').hide();
	var base_url			= '<?php echo base_url(); ?>';
	var active_controller	= '<?php echo($this->uri->segment(1)); ?>';
	$(document).ready(function(){
		$("#done").show();
		$("#tombol").show();
		$("#header").show();
		$("#semua").show();
		$("#form_B2000001").hide();
		$("#form_B2000002").hide();
		$("#form_B2000003").hide();	 
		$("#form_B2000004").hide();	 
		$("#form_B2000005").hide();
		$("#form_B2000006").hide();
		$("#form_B2000007").hide();
		$("#form_B2000009").hide();	
		$("#close_button").show();			
	});
	$("#show_all").click(function(){
		$("#done").show();
		$("#tombol").show();
		$("#header").show();
		$("#semua").show();
		$("#form_B2000001").hide();
		$("#form_B2000002").hide();
		$("#form_B2000003").hide();	 
		$("#form_B2000004").hide();	 
		$("#form_B2000005").hide();
		$("#form_B2000006").hide();
		$("#form_B2000007").hide();
		$("#form_B2000009").hide();	
		$("#close_button").show();	
	});
	$("#show_B2000001").click(function(){
		$("#done").show();
		$("#tombol").show();
		$("#header").show();
		$("#semua").hide();
		$("#form_B2000001").show();
		$("#form_B2000002").hide();
		$("#form_B2000003").hide();	 
		$("#form_B2000004").hide();	 
		$("#form_B2000005").hide();
		$("#form_B2000006").hide();
		$("#form_B2000007").hide();
		$("#form_B2000009").hide();	
		$("#close_button").show();	
	});
		$("#show_B2000002").click(function(){
		$("#done").show();
		$("#tombol").show();
		$("#header").show();
		$("#semua").hide();
		$("#form_B2000001").hide();
		$("#form_B2000002").show();
		$("#form_B2000003").hide();	 
		$("#form_B2000004").hide();	 
		$("#form_B2000005").hide();
		$("#form_B2000006").hide();
		$("#form_B2000007").hide();
		$("#form_B2000009").hide();
		$("#close_button").show();			
	});
		$("#show_B2000003").click(function(){
		$("#done").show();
		$("#tombol").show();
		$("#header").show();
		$("#semua").hide();
		$("#form_B2000001").hide();
		$("#form_B2000002").hide();
		$("#form_B2000003").show();	 
		$("#form_B2000004").hide();	 
		$("#form_B2000005").hide();
		$("#form_B2000006").hide();
		$("#form_B2000007").hide();
		$("#form_B2000009").hide();	
		$("#close_button").show();	
	});
		$("#show_B2000004").click(function(){
		$("#done").show();
		$("#tombol").show();
		$("#header").show();
		$("#semua").hide();
		$("#form_B2000001").hide();
		$("#form_B2000002").hide();
		$("#form_B2000003").hide();	 
		$("#form_B2000004").show();	 
		$("#form_B2000005").hide();
		$("#form_B2000006").hide();
		$("#form_B2000007").hide();
		$("#form_B2000009").hide();
		$("#close_button").show();	
	});
		$("#show_B2000005").click(function(){
		$("#done").show();
		$("#tombol").show();
		$("#header").show();
		$("#semua").hide();
		$("#form_B2000001").hide();
		$("#form_B2000002").hide();
		$("#form_B2000003").hide();	 
		$("#form_B2000004").hide();	 
		$("#form_B2000005").show();
		$("#form_B2000006").hide();
		$("#form_B2000007").hide();
		$("#form_B2000009").hide();
		$("#close_button").show();	
	});
		$("#show_B2000006").click(function(){
		$("#done").show();
		$("#tombol").show();
		$("#header").show();
		$("#semua").hide();
		$("#form_B2000001").hide();
		$("#form_B2000002").hide();
		$("#form_B2000003").hide();	 
		$("#form_B2000004").hide();	 
		$("#form_B2000005").hide();
		$("#form_B2000006").show();
		$("#form_B2000007").hide();
		$("#form_B2000009").hide();
		$("#close_button").show();	
	});
		$("#show_B2000007").click(function(){
		$("#done").show();
		$("#tombol").show();
		$("#header").show();
		$("#semua").hide();
		$("#form_B2000001").hide();
		$("#form_B2000002").hide();
		$("#form_B2000003").hide();	 
		$("#form_B2000004").hide();	 
		$("#form_B2000005").hide();
		$("#form_B2000006").hide();
		$("#form_B2000007").show();
		$("#form_B2000009").hide();
		$("#close_button").show();	
	});
		$("#show_B2000009").click(function(){
		$("#done").show();
		$("#tombol").show();
		$("#header").show();
		$("#semua").hide();
		$("#form_B2000001").hide();
		$("#form_B2000002").hide();
		$("#form_B2000003").hide();	 
		$("#form_B2000004").hide();	 
		$("#form_B2000005").hide();
		$("#form_B2000006").hide();
		$("#form_B2000007").hide();
		$("#form_B2000009").show();
		$("#close_button").show();	
	});
	$(document).on('click', '.add_roll', function(){
		var id = $(this).data('no_inquiry');
		var cust = $(this).data('customer');
		// alert(id);
		$("#head_title").html("<i class='fa fa-list-alt'></i><b>Tambah Data</b>");
		$.ajax({
			type:'POST',
			url:siteurl+'transaksi_inquiry/addRoll/'+id,
			data:{'id':id,'cust':cust,},
			success:function(data){
				$("#dialog-popup").modal();
				$("#ModalView").html(data);
				
			}
		})
	});
		$(document).on('click', '.view_roll', function(){
		var id = $(this).data('id_dt_inquery');
		// alert(id);
		$("#head_title").html("<i class='fa fa-list-alt'></i><b>Tambah Data</b>");
		$.ajax({
			type:'POST',
			url:siteurl+'transaksi_inquiry/ViewRoll/'+id,
			data:{'id':id},
			success:function(data){
				$("#dialog-popup").modal();
				$("#ModalView").html(data);
				
			}
		})
	});
		$(document).on('click', '.edit_roll', function(){
		var id = $(this).data('id_dt_inquery');
		// alert(id);
		$("#head_title").html("<i class='fa fa-list-alt'></i><b>Tambah Data</b>");
		$.ajax({
			type:'POST',
			url:siteurl+'transaksi_inquiry/EditRoll/'+id,
			data:{'id':id},
			success:function(data){
				$("#dialog-popup").modal();
				$("#ModalView").html(data);
				
			}
		})
	});
	$(document).on('click', '.delete_roll', function(e){
		e.preventDefault()
		var id = $(this).data('id_dt_inquery');
		// alert(id);
		swal({
		  title: "Anda Yakin?",
		  text: "Data Inventory akan di hapus.",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonClass: "btn-info",
		  confirmButtonText: "Ya, Hapus!",
		  cancelButtonText: "Batal",
		  closeOnConfirm: false
		},
		function(){
		  $.ajax({
			  type:'POST',
			  url:siteurl+'transaksi_inquiry/DeleteRoll',
			  dataType : "json",
			  data:{'id':id},
			  success:function(result){
				  if(result.status == '1'){
					 swal({
						  title: "Sukses",
						  text : "Data Inventory berhasil dihapus.",
						  type : "success"
						},
						function (){
							window.location.reload(true);
						})
				  } else {
					swal({
					  title : "Error",
					  text  : "Data error. Gagal hapus data",
					  type  : "error"
					})
					
				  }
			  },
			  error : function(){
				swal({
					  title : "Error",
					  text  : "Data error. Gagal request Ajax",
					  type  : "error"
					})
			  }
		  })
		});
		
	})
	$(document).on('click', '.add_sheet', function(){
		var id = $(this).data('no_inquiry');
		var cust = $(this).data('customer');
		// alert(id);
		$("#head_title").html("<i class='fa fa-list-alt'></i><b>Tambah Data</b>");
		$.ajax({
			type:'POST',
			url:siteurl+'transaksi_inquiry/addSheet/'+id,
			data:{'id':id,'cust':cust,},
			success:function(data){
				$("#dialog-popup").modal();
				$("#ModalView").html(data);
				
			}
		})
	});
			$(document).on('click', '.view_sheet', function(){
		var id = $(this).data('id_dt_inquery');
		// alert(id);
		$("#head_title").html("<i class='fa fa-list-alt'></i><b>Tambah Data</b>");
		$.ajax({
			type:'POST',
			url:siteurl+'transaksi_inquiry/ViewSheet/'+id,
			data:{'id':id},
			success:function(data){
				$("#dialog-popup").modal();
				$("#ModalView").html(data);
				
			}
		})
	});
		$(document).on('click', '.edit_sheet', function(){
		var id = $(this).data('id_dt_inquery');
		// alert(id);
		$("#head_title").html("<i class='fa fa-list-alt'></i><b>Tambah Data</b>"); 
		$.ajax({
			type:'POST',
			url:siteurl+'transaksi_inquiry/EditSheet/'+id,
			data:{'id':id},
			success:function(data){
				$("#dialog-popup").modal();
				$("#ModalView").html(data);
				
			}
		})
	});
	$(document).on('click', '.delete_sheet', function(e){
		e.preventDefault()
		var id = $(this).data('id_dt_inquery');
		// alert(id);
		swal({
		  title: "Anda Yakin?",
		  text: "Data Inventory akan di hapus.",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonClass: "btn-info",
		  confirmButtonText: "Ya, Hapus!",
		  cancelButtonText: "Batal",
		  closeOnConfirm: false
		},
		function(){
		  $.ajax({
			  type:'POST',
			  url:siteurl+'transaksi_inquiry/DeleteSheet',
			  dataType : "json",
			  data:{'id':id},
			  success:function(result){
				  if(result.status == '1'){
					 swal({
						  title: "Sukses",
						  text : "Data Inventory berhasil dihapus.",
						  type : "success"
						},
						function (){
							window.location.reload(true);
						})
				  } else {
					swal({
					  title : "Error",
					  text  : "Data error. Gagal hapus data",
					  type  : "error"
					})
					
				  }
			  },
			  error : function(){
				swal({
					  title : "Error",
					  text  : "Data error. Gagal request Ajax",
					  type  : "error"
					})
			  }
		  })
		});
		
	})
	$(document).on('click', '.add_round', function(){
		var id = $(this).data('no_inquiry');
		var cust = $(this).data('customer');
		// alert(id);
		$("#head_title").html("<i class='fa fa-list-alt'></i><b>Tambah Data</b>");
		$.ajax({
			type:'POST',
			url:siteurl+'transaksi_inquiry/addRoundBar/'+id,
			// data:{'id':id},
			data:{'id':id,'cust':cust,},
			success:function(data){
				$("#dialog-popup").modal();
				$("#ModalView").html(data);
				
			}
		})
	});
	$(document).on('click', '.add_square', function(){
		var id = $(this).data('no_inquiry');
		var cust = $(this).data('customer');
		// alert(id);
		$("#head_title").html("<i class='fa fa-list-alt'></i><b>Tambah Data</b>");
		$.ajax({
			type:'POST',
			url:siteurl+'transaksi_inquiry/addSquareBar/'+id,
			// data:{'id':id},
			data:{'id':id,'cust':cust,},
			success:function(data){
				$("#dialog-popup").modal();
				$("#ModalView").html(data);
				
			}
		})
	});
	$(document).on('click', '.add_hexa', function(){
		var id = $(this).data('no_inquiry');
		var cust = $(this).data('customer');
		// alert(id);
		$("#head_title").html("<i class='fa fa-list-alt'></i><b>Tambah Data</b>");
		$.ajax({
			type:'POST',
			url:siteurl+'transaksi_inquiry/addHexagonBar/'+id,
			// data:{'id':id},
			data:{'id':id,'cust':cust,},
			success:function(data){
				$("#dialog-popup").modal();
				$("#ModalView").html(data);
				
			}
		})
	});
	$(document).on('click', '.add_okta', function(){
		var id = $(this).data('no_inquiry');
		var cust = $(this).data('customer');			
		// alert(id);
		$("#head_title").html("<i class='fa fa-list-alt'></i><b>Tambah Data</b>");
		$.ajax({
			type:'POST',
			url:siteurl+'transaksi_inquiry/addOktagonBar/'+id,
			data:{'id':id,'cust':cust,},
			success:function(data){
				$("#dialog-popup").modal();
				$("#ModalView").html(data);
				
			}
		})
	});
	$(document).on('click', '.add_tube', function(){
		var id = $(this).data('no_inquiry');
		var cust = $(this).data('customer');
			
		// alert(id);
		$("#head_title").html("<i class='fa fa-list-alt'></i><b>Tambah Data</b>");
		$.ajax({
			type:'POST',
			url:siteurl+'transaksi_inquiry/addTube/'+id,
			data:{'id':id,'cust':cust,},
			success:function(data){
				$("#dialog-popup").modal();
				$("#ModalView").html(data);
				
			}
		})
	});
	$(document).on('click', '.add_penta', function(){
		var id = $(this).data('no_inquiry');
		var cust = $(this).data('customer');
				// alert(id);
		$("#head_title").html("<i class='fa fa-list-alt'></i><b>Tambah Data</b>");
		$.ajax({
			type:'POST',
			url:siteurl+'transaksi_inquiry/addPentagonBar/'+id,
			data:{'id':id,'cust':cust,},
			success:function(data){
				$("#dialog-popup").modal();
				$("#ModalView").html(data);
				
			}
		})
	});
	
	
	
</script>