<?php $m = $this->Request_payment_model; $h = $journal['rows'][0]; $data_coa = array_map('html_escape',$data_coa); ?>
<div class="box"><div class="box-body">
<?php if ($edit): ?><?= form_open('request_payment/jurnal_save',['id'=>'payment-detail','data-base'=>base_url('request_payment/'),'data-action'=>'jurnal_save','data-back'=>'payment_jurnal_list']) ?><?php else: ?><div id="payment-journal-view"><?php endif; ?>
    <input type="hidden" name="nomor" value="<?= html_escape($h['nomor']) ?>">
    <input type="hidden" name="version" value="<?= html_escape($journal['version']) ?>">
    <div class="form-group"><label for="journal-reference">No Request</label><input id="journal-reference" class="form-control" value="<?= html_escape($h['no_reff']) ?>" readonly></div>
    <div class="form-group"><label for="journal-date">Tanggal</label><input id="journal-date" class="form-control" type="date" name="tanggal" value="<?= html_escape($h['tanggal']) ?>" required <?= $edit ? '' : 'readonly' ?>></div>
    <table class="table table-bordered"><thead><tr><th>COA</th><th>Keterangan</th><th>Debet</th><th>Kredit</th></tr></thead><tbody>
    <?php $display = $edit ? $groups : $journal['rows']; $debet = 0; $kredit = 0;
    foreach ($display as $i=>$r):
        $d = $edit ? $r['debet'] : $m->money($r['debet']); $k = $edit ? $r['kredit'] : $m->money($r['kredit']); $debet += $d; $kredit += $k;
    ?>
    <tr><td><input type="hidden" name="items[<?= $i ?>][id]" value="<?= html_escape($r['id']) ?>">
    <?php if ($edit): ?><?= form_dropdown('items['.$i.'][coa]',$data_coa,$r['coa'],['class'=>'form-control','required'=>'required','aria-label'=>'COA baris '.($i+1)]) ?><?php else: ?><?= html_escape($r['no_perkiraan']) ?><?php endif; ?></td>
    <td><input class="form-control" name="items[<?= $i ?>][keterangan]" value="<?= html_escape($r['keterangan']) ?>" aria-label="Keterangan baris <?= $i+1 ?>" <?= $edit ? '' : 'readonly' ?>></td>
    <td><input class="form-control" name="items[<?= $i ?>][debet]" value="<?= $m->amount($d) ?>" data-journal-debet aria-label="Debet baris <?= $i+1 ?>" required <?= $edit ? '' : 'readonly' ?>></td>
    <td><input class="form-control" name="items[<?= $i ?>][kredit]" value="<?= $m->amount($k) ?>" data-journal-kredit aria-label="Kredit baris <?= $i+1 ?>" required <?= $edit ? '' : 'readonly' ?>></td></tr>
    <?php endforeach; ?>
    </tbody><tfoot><tr><th colspan="2">Total</th><th id="journal-debet"><?= $m->amount($debet) ?></th><th id="journal-kredit"><?= $m->amount($kredit) ?></th></tr></tfoot></table>
    <a class="btn btn-default btn-sm" href="<?= base_url('request_payment/payment_jurnal_list') ?>">Kembali</a>
    <?php if ($edit): ?><button type="submit" class="btn btn-success btn-sm">Submit</button><?php endif; ?>
<?php if ($edit): ?></form><?php else: ?></div><?php endif; ?></div></div>
<?php if ($edit): ?><script src="<?= base_url('assets/js/request_payment.js') ?>"></script><?php endif; ?>
