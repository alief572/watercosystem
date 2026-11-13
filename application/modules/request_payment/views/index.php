<?php
$data_coa = array_map('html_escape',$data_coa);
$columns = [
    'request'=>['#','No Dokumen','Request By','Tanggal','Keperluan','Tipe','Nilai Pengajuan','Tanggal Pembayaran','Action'],
    'approval'=>['#','No Dokumen','Request By','Tanggal','Keperluan','Tipe','Nilai Request','Total','Tanggal Pembayaran','Status','Action'],
    'payment'=>['#','No Dokumen','Request By','Tanggal','Keperluan','Tipe','Nilai Pengajuan','Tanggal Pembayaran','Keterangan','Payment','Administrasi','Dokumen'],
    'jurnal'=>['#','Nomor','No Transaksi','Tgl Jurnal','Keterangan','Jumlah','Status','Option']];
?>
<link rel="stylesheet" href="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.css') ?>">
<div class="box"><div class="box-body">
<?= form_open('request_payment/',['id'=>'payment-form','data-kind'=>$kind,'data-base'=>base_url('request_payment/'),'data-manage'=>$can_manage ? '1' : '0','data-token'=>$batch_token,'data-count'=>(int)($batch['count'] ?? 0),'data-total'=>$batch['total'] ?? '0','data-admin'=>$batch['admin'] ?? '0','data-files-max'=>(int)ini_get('max_file_uploads')]) ?>
    <?php if ($kind === 'payment' && $can_manage): ?>
    <div class="form-group"><label for="bank_coa">Bank</label><?= form_dropdown('bank_coa',$data_coa,'',['id'=>'bank_coa','class'=>'form-control select2','required'=>'required']) ?></div>
    <?php endif; ?>
    <div id="payment-summary" role="status" aria-live="polite"></div>
    <table id="payment-table" class="table table-bordered table-striped" style="width:100%"><thead><tr>
        <?php foreach ($columns[$kind] as $column): ?><th><?= html_escape($column) ?></th><?php endforeach; ?>
    </tr></thead><tbody></tbody></table>
    <?php if (in_array($kind,['request','payment'],true) && $can_manage): ?><button type="submit" class="btn btn-success btn-sm">Update</button><?php endif; ?>
    <?php if ($kind === 'payment'): ?><button type="button" id="payment-export" class="btn btn-default btn-sm">Export Excel</button><?php endif; ?>
</form>
</div></div>
<script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.min.js') ?>"></script>
<script src="<?= base_url('assets/js/request_payment.js') ?>"></script>
