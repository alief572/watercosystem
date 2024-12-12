
  
<!-- TABLE: LATEST ORDERS -->
<div class="box box-info">
    <!-- /.box-header -->
  <div class="box-body">
  <div class="row">

<!-- <div class="col-lg-8 col-xs-12"> 
<div class="col-md-4">
  <!-- small box -->
  <!--<div class="small-box bg-green">
    <!-- <div class="small-box bg-aqua"> -->
   <!-- <div class="inner">
      <h3><b><u>Total Penawaran Deal</u></b></h3>
      <p><h3><b>Rp. <?= number_format($penawaranso,2) ?></b></h3></p>
    </div>
    <div class="icon">
      <i class="fa fa-money"></i>
    </div>
    <a href="<?= base_url('reports/penawaran_so'); ?>" class="small-box-footer" id="act_individu">View <i class="fa fa-arrow-circle-right"></i></a>
  </div>
</div> -->

<div class="box-header primary">
  <h1><b>PENAWARAN PER SALES BULAN <?= date('m-Y'); ?></b></h1>
		<span class="pull-right">
		</span>
	</div>

<?php 
 foreach ($karyawan as $val){
	$bulan = date('m');
    $tahun = date('Y');
    $blnthn = $tahun.'-'.$bulan;
	$id_sales = $val->id_karyawan;
	$nama_sales = $val->nama_karyawan;
	$penawaran = $this->db->query("SELECT sum(grand_total) as total_penawaran
            FROM tr_penawaran  WHERE tgl_penawaran LIKE '$blnthn%' AND status=4 AND id_sales ='$id_sales'")->row();
?>



<!-- <div class="col-lg-8 col-xs-12"> -->
<div class="col-md-4">
  <!-- small box -->
  <div class="small-box bg-primary">
    <!-- <div class="small-box bg-aqua"> -->
    <div class="inner">
      <h4><b><u>Total Penawaran On Proses (<?=$nama_sales?>)</u></b></h4>
      <p><h3><b>Rp. <?= number_format($penawaran->total_penawaran,2) ?></b></h3></p>
    </div>
    <div class="icon">
      <i class="fa fa-money"></i>
    </div>
    <!--<a href="<?= base_url('reports/penawaran_dikirim'); ?>" class="small-box-footer" id="act_individu">View <i class="fa fa-arrow-circle-right"></i></a>
  --></div>
</div>

<?php 
 }
?>

<br>

<div class="box-header primary">
  <h1><b>SALES ORDER PER SALES BULAN <?= date('m-Y'); ?></b></h1>
		<span class="pull-right">
		</span>
	</div>

<?php 
 foreach ($karyawan as $val){
	$bulan = date('m');
    $tahun = date('Y');
    $blnthn = $tahun.'-'.$bulan;
	$id_sales = $val->id_karyawan;
	$nama_sales = $val->nama_karyawan;
	$so = $this->db->query("SELECT sum(grand_total) as total_salesorder
           FROM tr_sales_order  WHERE tgl_so LIKE '%$blnthn%' AND id_sales ='$id_sales'")->row();
			
 
?>


<!-- <div class="col-lg-8 col-xs-12"> -->
<div class="col-md-4">
  <!-- small box -->
  <div class="small-box bg-purple">
  <div class="inner">
      <h4><b><u>Total Sales Order (<?=$nama_sales?>)</u></b></h4>
      <p><h3><b>Rp. <?= number_format($so->total_salesorder,2) ?></b></h3></p>
    </div>
    <div class="icon">
      <i class="fa fa-money"></i>
    </div>
   <!-- <a href="<?= base_url('reports/salesorder'); ?>" class="small-box-footer" id="act_project">View <i class="fa fa-arrow-circle-right"></i></a>
  --> </div>
</div>


<?php
}
?>



</div>
  </div>
  <!-- /.box-body -->
</div>