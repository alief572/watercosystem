</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!-- Main Footer -->
<footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
    <?= isset($idt->nm_perusahaan) ? $idt->nm_perusahaan : 'not-set'; ?> - Page rendered in <strong>{elapsed_time}</strong> seconds
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2020 <a href="<?= site_url(); ?>"><?= isset($idt->nm_perusahaan) ? $idt->nm_perusahaan : 'not-set'; ?></a>.</strong> All rights reserved.
</footer>
</div>
<!-- ./wrapper -->

<div id="Processing"></div>
<div id="ajaxFailed"></div>
<!-- REQUIRED JS SCRIPTS -->
<!-- Bootstrap 3.3.6 -->
<script src="<?= base_url('assets/adminlte/bootstrap/js/bootstrap.min.js'); ?>"></script>
<!-- bootstrap datetimepicker -->
<script src="<?= base_url('assets/plugins/datetimepicker/bootstrap-datetimepicker.js'); ?>"></script>
<script src="<?= base_url('assets/plugins/datetimepicker/moment-with-locales.js'); ?>"></script>
<!-- bootstrap time picker -->
<script src="<?= base_url('assets/plugins/timepicker/bootstrap-timepicker.min.js'); ?>"></script>
<!-- Select2 -->
<script src="<?= base_url('assets/plugins/select2/select2.full.min.js'); ?>"></script>
<!-- iCheck 1.0.1 -->
<script src="<?= base_url('assets/plugins/iCheck/icheck.min.js'); ?>"></script>
<!-- Multi Select -->
<script src="<?= base_url('assets/plugins/multiselect/multiselect.min.js'); ?>"></script>
<!-- AdminLTE App -->
<script src="<?= base_url('assets/adminlte/dist/js/app.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/custome_ddr.js'); ?>" type="text/javascript"></script>

<!-- DataTables -->
<script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.min.js')?>"></script>
<script src="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.min.js')?>"></script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
Both of these plugins are recommended to enhance the
user experience. Slimscroll is required when using the
fixed layout. -->
<!-- AutoNumberic -->
<script src="<?= base_url('assets/autoNumeric.js'); ?>"></script>
<!-- AdminLTE App -->
</body>
</html>


<!-- page script -->
<script type="text/javascript">

		$('#example1').DataTable( {
	        orderCellsTop: true,
	        fixedHeader: true,
			scrollX: true,
	    } );

</script>

