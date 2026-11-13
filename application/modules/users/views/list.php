<?php 
    $ENABLE_ADD     = has_permission('Users.Add');
    $ENABLE_MANAGE  = has_permission('Users.Manage');
    $ENABLE_DELETE  = has_permission('Users.Delete');
	//echo "ENABLE_ADD=".$ENABLE_ADD."<BR>";
	//echo "ENABLE_MANAGE=".$ENABLE_MANAGE."<BR>";
	//echo $this->uri->uri_string()."ENABLE_DELETE=".$ENABLE_DELETE."<BR>";
?>
<link rel="stylesheet" href="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.css')?>">

<div class="box">
	<div class="box-header">
		<?php if ($ENABLE_ADD) : ?>
			<a href="<?= site_url('users/setting/create') ?>" class="btn btn-success" title="<?= lang('users_btn_new') ?>"><?= lang('users_btn_new') ?></a>
		<?php endif; ?>
	</div>
	<!-- /.box-header -->
	<div class="box-body">
		<table id="tbl_users" class="table table-bordered table-striped">
		<thead>
		<tr>
			<th width="50">#</th>
			<th><?= lang('users_username') ?></th>
			<th><?= lang('users_email') ?></th>
			<th><?= lang('users_nm_lengkap') ?></th>
			<th><?= lang('users_alamat') ?></th>
			<th><?= lang('users_kota') ?></th>
			<th><?= lang('users_hp') ?></th>
			<th><?= lang('users_st_aktif') ?></th>
			<?php if($ENABLE_MANAGE) : ?>
			<th width="80"></th>
			<?php endif; ?>			
		</tr>
		</thead>
        
		<tbody></tbody>
		
		<tfoot>
		<tr>
			<th width="50">#</th>
			<th><?= lang('users_username') ?></th>
			<th><?= lang('users_email') ?></th>
			<th><?= lang('users_nm_lengkap') ?></th>
			<th><?= lang('users_alamat') ?></th>
			<th><?= lang('users_kota') ?></th>
			<th><?= lang('users_hp') ?></th>
			<th><?= lang('users_st_aktif') ?></th>
			<?php if($ENABLE_MANAGE) : ?>
			<th width="80"></th>
			<?php endif; ?>		        
		</tr>
		</tfoot>
		</table>
	</div>
	<!-- /.box-body -->
</div>

<!-- DataTables -->
<script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.min.js')?>"></script>
<script src="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.min.js')?>"></script>

<!-- page script -->
<script>
  $(function () {
    // id tbl_users (bukan example1) agar tidak bentrok dengan init otomatis basic.js.
    var columns = [
      { data: 'no', orderable: false, searchable: false }, { data: 'username' }, { data: 'email' }, { data: 'nm_lengkap' },
      { data: 'alamat' }, { data: 'kota' }, { data: 'hp' }, { data: 'status' }
    ];
    <?php if($ENABLE_MANAGE) : ?>
    columns.push({ data: 'action', orderable: false, searchable: false });
    <?php endif; ?>
    $('#tbl_users').DataTable({
      processing: true,
      serverSide: true,
      autoWidth: false,
      searchDelay: 350,
      order: [],
      ajax: { url: siteurl + 'users/setting/data_users', type: 'POST' },
      columns: columns
    });
  });
</script>
