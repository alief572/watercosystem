
  
<!-- TABLE: LATEST ORDERS -->
<div class="box box-info">
  <div class="box-header with-border">
  <div class="box-header">
  <h1><b>DASHBOARD TRANSAKSI BULAN <?= date('m-Y'); ?></b></h1>
		<span class="pull-right">
		</span>
	</div>

    
  </div>
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

<!-- <div class="col-lg-8 col-xs-12"> -->
<div class="col-md-4">
  <!-- small box -->
  <div class="small-box bg-primary">
    <!-- <div class="small-box bg-aqua"> -->
    <div class="inner">
      <h3><b><u>Total Penawaran On Proses</u></b></h3>
      <p><h3><b>Rp. <?= number_format($penawarandikirim,2) ?></b></h3></p>
    </div>
    <div class="icon">
      <i class="fa fa-money"></i>
    </div>
    <a href="<?= base_url('reports/penawaran_dikirim'); ?>" class="small-box-footer" id="act_individu">View <i class="fa fa-arrow-circle-right"></i></a>
  </div>
</div>

<!-- <div class="col-lg-8 col-xs-12"> -->
<div class="col-md-4">
  <!-- small box -->
  <div class="small-box bg-red">
    <!-- <div class="small-box bg-aqua"> -->
    <div class="inner">
      <h3><b><u>Total Penawaran Loss</u></b></h3>
      <p><h3><b>Rp. <?= number_format($penawaranloss,2) ?></b></h3></p>
    </div>
    <div class="icon">
      <i class="fa fa-money"></i>
    </div>
    <a href="<?= base_url('reports/penawaran_loss'); ?>" class="small-box-footer" id="act_individu">View <i class="fa fa-arrow-circle-right"></i></a>
  </div>
</div>


<!-- <div class="col-lg-8 col-xs-12"> -->
<div class="col-md-4">
  <!-- small box -->
  <div class="small-box bg-purple">
  <div class="inner">
      <h3><b><u>Total Sales Order</u></b></h3>
      <p><h3><b>Rp. <?= number_format($salesorder,2) ?></b></h3></p>
    </div>
    <div class="icon">
      <i class="fa fa-money"></i>
    </div>
    <a href="<?= base_url('reports/salesorder'); ?>" class="small-box-footer" id="act_project">View <i class="fa fa-arrow-circle-right"></i></a>
  </div>
</div>

<!-- <div class="col-lg-8 col-xs-12"> -->
<div class="col-md-4">
  <!-- small box -->
  <div class="small-box bg-orange">
  <div class="inner">
      <h3><b><u>Total Invoice</u></b></h3>
      <p><h3><b>Rp. <?= number_format($invoice,2) ?></b></h3></p>
    </div>
    <div class="icon">
      <i class="fa fa-money"></i>
    </div>
    <a href="<?= base_url('reports/invoice'); ?>" class="small-box-footer" id="act_project">View <i class="fa fa-arrow-circle-right"></i></a>
  </div>
</div>

<!-- <div class="col-lg-8 col-xs-12"> -->
<div class="col-md-4">
  <!-- small box -->
  <div class="small-box bg-green">
  <div class="inner">
      <h3><b><u>Total Penerimaan</u></b></h3>
      <p><h3><b>Rp. <?= number_format($bayar,2) ?></b></h3></p>
    </div>
    <div class="icon">
      <i class="fa fa-money"></i>
    </div>
    <a href="<?= base_url('reports/penerimaan'); ?>" class="small-box-footer" id="act_project">View <i class="fa fa-arrow-circle-right"></i></a>
  </div>
</div>

</div>
  </div>
  <!-- /.box-body -->
</div>