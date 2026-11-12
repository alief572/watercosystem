<div class="box box-solid">
	<div class="box-body">
		<div class="row">
			<div class="col-md-12">
				<?php if (empty($result)) : ?>
					<p>Data tidak ditemukan.</p>
				<?php else : ?>
					<legend><h3 style="margin:0px !important"><label>Kode Usage : <?= html_escape($result->id_category2) ?></label></h3></legend>
					<legend><h3 style="margin:0px !important"><label>Purpose Produk (LV I) : <?= html_escape($result->nama_type) ?></label></h3></legend>
					<legend><h3 style="margin:0px !important"><label>Produk Type (LV II) : <?= html_escape($result->nama_category1) ?></label></h3></legend>
					<legend><h3 style="margin:0px !important"><label>Usage (LV III) : <?= html_escape($result->nama) ?></label></h3></legend>
					<legend><h3 style="margin:0px !important"><label>Status : <?= $result->aktif == 'aktif' ? 'Aktif' : 'Non Aktif' ?></label></h3></legend>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
