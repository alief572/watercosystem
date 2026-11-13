
<?php
	$tanggal = date('Y-m-d');
foreach ($results['head'] as $head){
}	

foreach ($results['hutang'] as $hutang){
}	

?>

 <div class="box box-primary">
    <div class="box-body">
		<form id="data-form" method="post" data-payment-action="SaveRequest" data-payment-base="<?= html_escape(base_url('purchase_order_payment/')) ?>">
			<div class="col-sm-12">
				<div class="input_fields_wrap2">
			<div class="row">
		<center><label for="customer" ><h3>Purchase Order</h3></label></center>
				<div class="col-sm-12">
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="id_customer">Supplier</label>
				</div>
				<div class="col-md-8"> 
					<select id="id_suplier" name="id_suplier" class='form-control input-md chosen-select' disabled>
						<option value="">--Pilih--</option>
							<?php foreach ($results['supplier'] as $supplier){
							$selected = ($supplier->id_suplier == $head->id_suplier)?'selected':'';	
								?> 
						<option value="<?= html_escape($supplier->id_suplier) ?>" <?= html_escape($selected) ?>><?= html_escape(strtoupper(strtolower((string)$supplier->name_suplier))) ?></option>
							<?php } ?>
					</select>
				</div>
			</div>
		</div>
				<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="id_customer">Local / Import</label>
				</div>
				<div class="col-md-8" id='ubahloi'>
					<select id="loi" name="loi" class="form-control select" disabled>
						<option value="">--Pilih--</option>
						<?php
						if($head->loi == "Import"){
						echo"
						<option value='Import' selected>Import</option>
						<option value='Lokal'>Lokal</option>
						";
						}elseif($head->loi == "Lokal"){
						echo"
						<option value='Import'>Import</option>
						<option value='Lokal' selected>Lokal</option>
						";
						}else{
						echo"
						<option value='Import'>Import</option>
						<option value='Lokal'>Lokal</option>
						";
						}
						
						?>
					</select>
				</div>
			</div>
		</div>
		</div>
		<div class="col-sm-12">
			<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="customer">NO.Incoming</label>
				</div>
				<div class="col-md-8" hidden>
					<input type="text" class="form-control" id="no_po"  value="<?= html_escape($head->no_po) ?>" required name="no_po" readonly placeholder="ID PO">
				</div>
				<div class="col-md-8" hidden>
					<input type="text" class="form-control" id="no_surat" value="<?= html_escape($head->no_surat) ?>"  required name="no_surat" readonly placeholder="No.PR">
				</div>
				<div class="col-md-8" hidden>
					<input type="text" class="form-control" id="id_data"  value="<?= html_escape($hutang->id_data) ?>" required name="id_data" readonly placeholder="ID PO">
				</div>
				<div class="col-md-8">
					<input type="text" class="form-control" id="id_incoming" value="<?= html_escape($hutang->id_incoming) ?>"  required name="id_incoming" readonly placeholder="No.PR">
				</div>
				<div class="col-md-8" hidden>
				<input type="date" class="form-control" id="tanggal" value="<?= html_escape($head->tanggal) ?>" required name="tanggal" readonly >
                </div>
			</div>
			</div>

		    <div class="col-sm-6">
            <div class="form-group row">
                <div class="col-md-4">
                    <label for="customer">Kurs</label>
                </div>
                <div class="col-md-8">
                    <?php if($hutang->matauang =='idr') { ?>
                    <input type='hidden' class='form-control' value="<?= html_escape(($hutang->matauang === 'idr' ? 1 : $hutang->kurs)) ?>" id='nominal_kurs'  required name='nominal_kurs'  placeholder='Nominal Kurs'>
                    <?php } else{ ?>
                    <input type='text' class='form-control' value="<?= html_escape(($hutang->matauang === 'idr' ? 1 : $hutang->kurs)) ?>" id='nominal_kurs'  required name='nominal_kurs'  placeholder='Nominal Kurs'>
                    <?php }?>
                </div>
		    </div>
		    </div>
        </div>
		<div class="col-sm-12" >
			<div class="col-sm-6" hidden>
				<div class="form-group row">
					<div class="col-md-4">
						<label for="customer">Mata Uang</label>
					</div>
					<div class="col-md-8">
					<select id="matauang" name="matauang" class='form-control input-md chosen-select' disabled>
							<?php foreach ($results['matauang'] as $supplier){
                                if($supplier->kode==$hutang->matauang){
                                    $selected = 'selected';	
                                }
                                else{
                                    $selected = '';	
                                }
							
								?> 
						<option value="<?= html_escape($supplier->kode) ?>" <?= html_escape($selected) ?>><?= html_escape(strtoupper(strtolower($supplier->kode))) ?></option>
							<?php } ?>
					</select>
				</div>
				</div>
			</div>
			<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="id_customer">Tanggal Request</label>
				</div>
				<div class="col-md-8"> 
				<input type="date" class="form-control" id="tanggal_request" value="<?= html_escape(date('Y-m-d')) ?>" required name="tanggal_request"  >
                <input type="hidden" class="form-control" id="tanggal_bayar" value="<?= html_escape(date('Y-m-d')) ?>" required name="tanggal_bayar" >
					
				</div>
			</div>
		</div>
		</div>
        
		<div class="col-sm-12" hidden>
            <div class="col-sm-6">
                <div class="form-group row">
				    <div class="col-md-4">
					    <label for="id_customer">Pilih Bank</label>
				    </div>
                    <div class="col-md-8"> 
                        <select class="form-control input-sm" name="bank" id="bank">
                        <option value="">Pilih Bank</option>
                        <option value="1102-01-01">CIMB NIAGA IDR  8000.9570.4600</option>
                        <option value="1102-01-02">BCA IDR 870.003.599.0</option>
                        <option value="1102-01-06">CIMB NIAGA USD 8000.9633.1040</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
				<div class="form-group row">
					<div class="col-md-4">
						<label for="customer"></label>
					</div>
					<div class="col-md-8">
						</div>
				</div>
			</div>
		</div> 

        <div class="col-sm-12">
            <div class="col-sm-6"hidden>
                <div class="form-group row">
				    <div class="col-md-4">
					    <label for="id_customer">Total PO</label>
				    </div>
                    <div class="col-md-8"> 
                    <input type="input" class="form-control" id="total_po" value="<?= html_escape(number_format((float)$head->subtotal,2)) ?>" required name="total_po" readonly >
					</div>
                </div>
            </div>
            <div class="col-sm-6">
				<div class="form-group row">
					<div class="col-md-4">
						<label for="customer">Total Hutang USD</label>
					</div>
					<div class="col-md-8">
					 <?php if($hutang->matauang =='usd') { ?>
                    <input type="input" class="form-control" id="total_ap" value="<?= html_escape(number_format((float)$hutang->hutang_kurs,2)) ?>" required name="total_ap" readonly >
					<?php } else{ ?>
                    <input type="input" class="form-control" id="total_ap" value="0" required name="total_ap" readonly >
					<?php } ?>
					</div>
				</div>
			</div>
		</div> 

        <div class="col-sm-12">
            <div class="col-sm-6">
                <div class="form-group row">
				    <div class="col-md-4">
					    <label for="id_customer">Total Hutang IDR</label>
				    </div>
                    <div class="col-md-8"> 
					<input type="input" class="form-control" id="total_ap_idr" value="<?= html_escape(number_format((float)$hutang->hutang_idr,2)) ?>" required name="total_ap_idr" readonly >
					</div>
                </div>
            </div>
            <div class="col-sm-6">
				<div class="form-group row">
					<div class="col-md-4">
                    <label for="id_customer">Rencana Bayar <?= html_escape(strtoupper($hutang->matauang)) ?></label>
					</div>
					<div class="col-md-8">
                    <input type="input" class="form-control" id="total_bayar"   required name="total_bayar"  >
					</div>
				</div>
			</div>
		</div> 

				
		    <center>
		    <button type="submit" class="btn btn-success btn-sm" name="save" id="simpan-com"><i class="fa fa-save">&nbsp;</i>Request Pembayaran</button>
		    	</center>
				 </div>
			</div>
		</form>		   
	</div>
</div>
<script src="<?= base_url('assets/js/purchase_order_payment.js') ?>"></script>
