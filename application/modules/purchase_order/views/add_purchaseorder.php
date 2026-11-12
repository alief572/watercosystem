<?php
$tanggal = date('Y-m-d');
$loi = '';
$ENABLE_ADD     = has_permission('Purchase_Request.Add');
$ENABLE_MANAGE  = has_permission('Purchase_Request.Manage');
$ENABLE_VIEW    = has_permission('Purchase_Request.View');
$ENABLE_DELETE  = has_permission('Purchase_Request.Delete');
?>
<div class="box box-primary">
    <div class="box-body">
		<?php $poTaxMaster = $this->db->query('SELECT persen FROM ppn LIMIT 1')->row();
        $poTaxRate = $poTaxMaster && is_numeric($poTaxMaster->persen) && $poTaxMaster->persen >= 0 ? $poTaxMaster->persen : ''; ?>
        <form id="data-form" method="post" data-ppn-rate="<?= html_escape($poTaxRate) ?>">
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
					<select id="id_suplier" name="id_suplier" class='form-control input-md chosen-select'  onchange="get_lokasi()"  required>
						<option value="">--Pilih--</option>
							<?php foreach ($results['supplier'] as $supplier){?> 
						<option value="<?= html_escape($supplier->id_suplier) ?>" ><?= html_escape(strtoupper(strtolower($supplier->name_suplier))) ?></option>
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
				<div class="col-md-8" id="ubahloi">
					<select id="loi" name="loi" class="form-control select"  onchange="get_kurs()"  required>
						<option value="">--Pilih--</option>
						<option value="Import">Import</option>
						<option value="Lokal">Lokal</option>
					</select>
				</div>
			</div>
		</div>
		</div>
		<div class="col-sm-12">
		<div class="col-sm-6">
		<div class="form-group row">
			<div class="col-md-4">
				<label for="customer">NO.PO</label>
			</div>
			<div class="col-md-8" hidden>
				<input type="text" class="form-control" id="no_po"  required name="no_po" readonly placeholder="ID PO">
			</div>
			<div class="col-md-8">
				<input type="text" class="form-control" id="no_surat"  required name="no_surat" readonly placeholder="No.PO">
			</div>
		</div>
		</div>
		<div class="col-sm-6" id="input_kurs">
		
		</div>
		</div>
		<div class="col-sm-12">
		<div class="col-sm-6">
		<div class="form-group row">
			<div class="col-md-4">
				<label for="customer">Tanggal PO</label>
			</div>
			<div class="col-md-8">
				<input type="text" class="form-control" id="tanggal" value="<?= $tanggal ?>" onkeyup required name="tanggal">
			</div>
		</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="id_customer">Mata Uang</label>
				</div>
				<div class="col-md-8"> 
					<select id="matauang" name="matauang" class='form-control input-md chosen-select'required>
							<?php foreach ($results['matauang'] as $supplier){
							$selected = '';	
								?> 
						<option value="<?= html_escape($supplier->kode) ?>" <?=$selected;?>><?= html_escape(strtoupper(strtolower($supplier->kode))) ?></option>
							<?php } ?>
					</select>
				</div>
			</div>
		</div>
		</div>
				<!-- <div class="col-sm-12">
		<div class="col-sm-6">
		<div class="form-group row">
			<div class="col-md-4">
				<label for="customer">Expect Date</label>
			</div>
			<div class="col-md-8">
				<input type="date" class="form-control" id="expect_tanggal" required name="expect_tanggal"  >
			</div>
		</div>
		</div>
		</div> -->
				<div class="col-sm-12">
		<div class="col-sm-6">
		<div class="form-group row">
			<div class="col-md-4">
				<label for="customer">Payment Term</label>
			</div>
			<div class="col-md-8">
				<input type="text" class="form-control" id="term"  onkeyup required name="term" >
			</div>
		</div>
		</div>
		<div class="col-sm-6" hidden>
			<div class="form-group row">
				<div class="col-md-4">
					<label for="id_customer">PR</label>
				</div>
				<div class="col-md-8"> 
					<select id="no_pr" name="no_pr" class='form-control input-md chosen-select'required>
						<option value="0">List Empty</option>
					</select>
				</div>
			</div>
		</div>
		</div>
		<div class="col-sm-12" hidden>
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="id_customer">Price Method</label>
				</div>
				<div class="col-md-8">
					<select id="cif" name="cif" class="form-control select"   required>
						<option value="">--Pilih--</option>
						<option value="CIF">CIF</option>
						<option value="FOB">FOB</option>
						<option value="LOCO">LOCO</option>
						<option value="DDU">DDU</option>
						<option value="FRANCO">FRANCO</option>
					</select>
				</div>
			</div>
		</div>
		</div>
		
		<div class="col-sm-12">
			<div class="col-sm-12">
				<div class="form-group row" >
					<table class='table table-bordered table-striped'>
						<thead>
                        <tr class='bg-blue'>
                            <th>Item</th>
							<th>Kode Produk</th>
                            <th>Description</th>
                            <th width='7%' hidden>Width</th>
                            <th width='7%' hidden>Length</th>
                            <th width='7%'>Stock Avl</th>
							<th width='7%'>Qty PR</th>
							<th width='7%'>PO Qty</th>
                            <th width='8%' hidden>Rate LME</th>
                            <th width='7%' hidden>Alloy Price</th>
                            <th width='7%' hidden>Fab Cost</th>
                            <th width='7%'>Unit Price <br> Exclude PPN</th>
                            <th width='6%' hidden>Disc %</th>
                            <th width='6%' hidden>Biaya Kirim</th>
							<th width='7%'>PPN</th>
							<th width='9%'>Nilai Barang</th>
							<th width='7%'>Nilai PPN</th>
							<th width='9%'>Total Barang + PPN</th>
                            <th width='8%'>Note</th>
                            <th width='5%'>#</th>
                        </tr>
						</thead>
						<tbody id="list_spk">
                 <?php
                  if($results['getitemso']){
                  $n=1;
                  foreach($results['getitemso'] as $key => $value){
                           $no=$n++;
                       $key++;
                          $disabled = ($loi == 'Import')?'':'readonly';
                          $disabled2 = ($loi == 'Import')?'readonly':'';
                          $idmat =$value->idmaterial;
                          $harga = $this->db->query('SELECT * FROM ms_product_pricelist WHERE id_category3 = ?', array($idmat))->row();
                          $harga_beli = $harga ? (float)$harga->harga_beli : 0;
						  
						  $stock = $this->db->query('SELECT * FROM stock_material WHERE id_category3 = ?', array($idmat))->row();
						  		  
						  $avl      =	($stock ? (float)$stock->qty_free : 0);
						  $po    = max(0, $value->qty-($stock ? (float)$stock->qty_free : 0));
              
                          $total = $harga_beli*$value->qty;
              
                          $value = clone $value;
                          foreach (array('nama_material','kode_barang','keterangan','id_dt_pr','no_pr','idmaterial') as $field) $value->$field = html_escape($value->$field ?? '');
                          echo "<tr>
                              	<td>  ".$value->nama_material."
                                            <input type='hidden' class='form-control input-sm' id='dt_idpr_".$key."' name='dt[".$key."][idpr]' value='".$value->id_dt_pr."'>
											<input type='hidden' class='form-control input-sm' id='dt_no_pr_".$key."' name='dt[".$key."][no_pr]' value='".$value->no_pr."'>
                                              <input type='hidden' class='form-control input-sm' id='dt_idmaterial_".$key."' name='dt[".$key."][idmaterial]' value='".$value->idmaterial."'>
                                              <input type='hidden' class='form-control input-sm' id='dt_namamaterial_".$key."' name='dt[".$key."][namamaterial]' value='".$value->nama_material."'>
                                              <input type='hidden' class='form-control input-sm' id='dt_panjang_".$key."' name='dt[".$key."][panjang]'>
                                              <input type='hidden' class='form-control input-sm' id='dt_lebar_".$key."' name='dt[".$key."][lebar]'>
              
                                              <input type='hidden' class='form-control input-sm ch_diskon' id='dt_ch_diskon_".$key."'>
                                              <input type='hidden' class='form-control input-sm ch_pajak' id='dt_ch_pajak_".$key."'>
                                              <input type='hidden' class='form-control input-sm ch_jumlah' id='dt_ch_jumlah_".$key."'>
											  <input type='hidden' class='form-control input-sm ch_ppn' id='dt_ch_ppn_".$key."'>
              
                                          </td>
								
								<td><input type='text' class='form-control input-sm' name='dt[".$key."][kode_barang]' id='dt_kode_barang_".$key."' value='".$value->kode_barang."' readonly></td>
								
                              	<td><input type='text' class='form-control input-sm' name='dt[".$key."][description]' id='dt_description_".$key."' value='".$value->keterangan."'></td>
								
								<td><input type='text' class='form-control input-sm' id='dt_stock_".$key."' name='dt[".$key."][stock]' value='".$avl."' readonly ></td>
								
								<td><input type='text' class='form-control input-sm' id='dt_pr_".$key."' name='dt[".$key."][pr]' value='".$value->qty."' readonly ></td>
								
                              	<td hidden><input type='hidden' class='form-control input-sm autoNumeric' name='dt[".$key."][width]' id='dt_width_".$key."'  value='".$value->width."'></td>
                              	<td hidden><input type='hidden' class='form-control input-sm autoNumeric' name='dt[".$key."][length]' id='dt_length_".$key."'  value='".$value->length."'></td>
                              	<td><input type='hidden' class='form-control input-sm autoNumeric' name='dt[".$key."][totalweight]' id='dt_totalweight_".$key."' value='".$value->totalweight."'  onkeyup='HitAmmount(".$key.")'>
                                                      <input type='text' class='form-control input-sm' id='dt_qty_".$key."' name='dt[".$key."][qty]' value='".$po."' onkeyup='HitAmmount(".$key.")'>
                                              
                                          </td>
                              	<td hidden>
                                              <select class='form-control input-sm' id='dt_ratelme_".$key."' name='dt[".$key."][ratelme]' onchange='CariPrice(".$key.")'>
                                                  <option value=''>-Pilih-</option>
                                                  <option value='Hari Ini'>Hari ini</option>
                                                  <option value='H-10'>H-10</option>
                                                  <option value='H-30'>H-30</option>
                                              </select>
                                          </td>
                              	<td hidden><input type='text' class='form-control input-sm autoNumeric3' id='dt_alloyprice_".$key."' ".$disabled." data-decimal='.' data-thousand='' data-precision='0' data-allow-zero='' name='dt[".$key."][alloyprice]' onkeyup='HitAmmount(".$key.")'></td>
                              	<td hidden><input type='text' class='form-control input-sm autoNumeric3' id='dt_fabcost_".$key."' ".$disabled." name='dt[".$key."][fabcost]' onkeyup='HitAmmount(".$key.")'></td>
                                  <td><input type='text' class='form-control input-sm autoNumeric3' id='dt_hargasatuan_".$key."' name='dt[".$key."][hargasatuan]' onkeyup='HitAmmount(".$key.")' value='".($harga ? $harga_beli : "")."'></td>
								<td>
									  <select class='form-control input-sm' id='dt_ppn_".$key."' name='dt[".$key."][ppn]' onchange='CariPPN(".$key.")'>
										  <option value=''>SELECT</option>
										  <option value='Y'>Y</option>
										  <option value='N'>N</option>
									  </select>
								  </td>
                              	<td hidden><input type='text' class='form-control input-sm autoNumeric pajak' id='dt_pajak_".$key."' name='dt[".$key."][pajak]' onkeyup='HitAmmount(".$key.")'></td>
                              	<td hidden><input type='text' class='form-control input-sm autoNumeric3' id='dt_diskon_".$key."' ".$disabled." name='dt[".$key."][diskon]' onkeyup='HitAmmount(".$key.")'></td>
                              
								<td><input type='text' class='form-control input-sm ch_jumlah_ex' id='dt_jumlahharga_".$key."' readonly name='dt[".$key."][jumlahharga]' value='".($harga ? $total : "")."'></td>
                              	<td><input type='text' class='form-control input-sm ch_ppn' id='dt_nilai_ppn_".$key."' name='dt[".$key."][nilai_ppn]' readonly></td>
                                  <td><input type='text' class='form-control input-sm ch_jumlah_ex2' id='dt_totalharga_".$key."' readonly name='dt[".$key."][totalharga]' value='".($harga ? $total : "")."'></td>
                              	<td><input type='text' class='form-control input-sm' id='dt_note_".$key."' name='dt[".$key."][note]'></td>
                              	<td>
                                              <button type='button' class='btn btn-sm btn-danger hapus_baris' title='Hapus Data' data-role='qtip'><i class='fa fa-close'></i></button>
                                          </td>
                           </tr>";
                          
                      }
                    }

				   ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		
					
	</div>
		<div class="col-sm-12" hidden>
			<div class="col-sm-6">
				<div class="form-group row">
					<div class="col-md-4">
						<label for="customer">Expect Date</label>
					</div>
					<div class="col-md-8">
						<input type="text" class="form-control" id="expect_tanggal" required name="expect_tanggal"  readonly>
					</div>
				</div>
			</div>
			<div class="col-sm-6" >
				<div class="form-group row">
					<div class="col-md-2">
						<label for="customer">Note</label>
					</div>
					<div class="col-md-10">
						<input type="text" class="form-control"  id="note_ket" name="note_ket" >
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-12" >
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="id_customer">Sub Total</label>
				</div>
				<div class="col-md-8" id="ForHarga">
					<input readonly type="text" class="form-control" id="hargatotal"  onkeyup required name="hargatotal" >
				</div>
			</div>
		</div>
		</div>
		<div class="col-sm-12" >
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="id_customer">Total PPN</label>
				</div>
				<div class="col-md-8" id="ForHarga">
					<input readonly type="text" class="form-control" id="totalppn"  onkeyup required name="totalppn" >
				</div>
			</div>
		</div>
		</div>
				<div class="col-sm-12" hidden>
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="id_customer">Discount</label>
				</div>
				<div class="col-md-8" id="ForDiskon">
					<input readonly type="text" class="form-control" id="diskontotal"  onkeyup required name="diskontotal" >
				</div>
			</div>
		</div>
		</div>
		<div class="col-sm-12" >
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="id_customer">Biaya Kirim</label>
				</div>
				<div class="col-md-8" id="ForTax">
					<input type="hidden" class="form-control" id="taxtotal"  onkeyup required name="taxtotal" >
					<input type="text" class="form-control" id="kirim"  onblur="cariTotal()" required name="kirim" >
				</div>
			</div>
		</div>
		</div>
				<div class="col-sm-12">
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="id_customer">Total Order</label>
				</div>
				<div class="col-md-8" id="ForSum">
					<input readonly type="text" class="form-control" id="subtotal"  onkeyup required name="subtotal" >
				</div>
			</div>
		</div>
		</div>
			<center>
		<button type="submit" class="btn btn-success btn-sm" name="save" id="simpan-com"><i class="fa fa-save"></i>Simpan</button>
			</center>
				 </div>
			</div>
		</form>		  
	</div>
</div>	
	
				  
			  
<script type="text/javascript">
	//$('#input-kendaraan').hide();
	var base_url			= '<?php echo base_url(); ?>';
	var active_controller	= '<?php echo($this->uri->segment(1)); ?>';
	$(document).ready(function(){	

		TotalSemua()

		var max_fields2      = 10; //maximum input boxes allowed
		var wrapper2         = $(".input_fields_wrap2"); //Fields wrapper
		var add_button2      = $(".add_field_button2"); //Add button ID	

		$('.datepicker').datepicker({
			dateFormat: 'yy-mm-dd',
			changeMonth:true,
			changeYear:true,
		});

		$(document).on('click','.hapus_baris',function(){
			$(this).parent().parent().remove();
			SumDel();
		});
	});


	function addmaterial(){ 
		var jumlah	=$('#data_request').find('tr').length;
		var id_suplier=$("#id_suplier").val();
		var loi=$("#loi").val();
		var angka =jumlah+1;
				if( id_suplier == '' || id_suplier == null || loi == '' || loi == null){
					swal("Warning", "Silahkan Pilih Supplier Terlebih Dahulu :)", "error");
					return false;
		}else{
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/AddMaterial',
            data:"jumlah="+jumlah+"&id_suplier="+id_suplier+"&loi="+loi,
            success:function(html){
               $("#data_request").append(html);
			   $(".bilangan-desimal").maskMoney();
			   $(".chosen-select").select2({ width: '100%' });
			   $('.autoNumeric3').autoNumeric('init', { vMin: 0 });
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/UbahImport',
            data:"loi="+loi,
            success:function(html){
               $("ubahloi").html(html);
            }
        });
		}
    }
	function HitungHarga(id){
        var dt_qty=$("#dt_qty_"+id).val();
		 var dt_width=$("#dt_width_"+id).val();
		 var dt_hargasatuan=$("#dt_hargasatuan_"+id).val();
		 // $.ajax({
            // type:"GET",
            // url:siteurl+'purchase_order/HitungHarga',
            // data:"dt_hargasatuan="+dt_hargasatuan+"&dt_qty="+dt_qty+"&id="+id,
            // success:function(html){
               // $("#jumlahharga_"+id).html(html);
            // }
        // });
		 $.ajax({
            type:"GET",
            url:siteurl+'purchase_order/TotalWeight',
            data:"dt_width="+dt_width+"&dt_qty="+dt_qty+"&id="+id,
            success:function(html){
               $("#totalwidth_"+id).html(html);
            }
        });
    }
		function CariPrice(id){
		 var dt_ratelme=$("#dt_ratelme_"+id).val();
		 var dt_idmaterial=$("#dt_idmaterial_"+id).val();
		 if( dt_idmaterial == '' || dt_idmaterial == null){
					swal("Warning", "Silahkan Pilih Material Terlebih Dahulu :)", "error");
					return false;
		}else{
		 $.ajax({
            type:"GET",
            url:siteurl+'purchase_order/CariPrice',
            data:"dt_ratelme="+dt_ratelme+"&dt_idmaterial="+dt_idmaterial+"&id="+id,
            success:function(html){
               $("#dt_alloyprice_"+id).val(html);
            }
        });
		}
    }
	

	function get_kurs(){
        var loi=$("#loi").val();
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/FormInputKurs',
            data:"loi="+loi,
            success:function(html){
               $("#input_kurs").html(html);
            }
        });
    }
	
	
	function HitungUP(id){
       var alloyprice=$("#dt_alloyprice_"+id).val();
		 var fabcost=$("#dt_fabcost_"+id).val();
		 var diskon=$("#dt_diskon_"+id).val();
		 var pajak=$("#dt_pajak_"+id).val();
		 var qty=$("#dt_qty_"+id).val();
		 var hargasatuan=$("#dt_hargasatuan_"+id).val();
		 var dt_width=$("#dt_totalwidth_"+id).val();
		 
		 var loi=$("#loi").val();
		 // console.log(dt_width)
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/HitungUP',
            data:"fabcost="+fabcost+"&alloyprice="+alloyprice+"&hargasatuan="+hargasatuan+"&loi="+loi,
            success:function(html){
                // $("#dt_hargasatuan_"+id).val(html); 
				HitAmmount(id)
            }
        });
		// $.ajax({
            // type:"GET",
            // url:siteurl+'purchase_order/Hitjumlah',
            // data:"fabcost="+fabcost+"&alloyprice="+alloyprice+"&pajak="+pajak+"&diskon="+diskon+"&qty="+qty+"&hargasatuan="+hargasatuan+"&loi="+loi+"&dt_width="+dt_width,
            // success:function(html){
                // $("#dt_jumlahharga_"+id).val(html); 
            // }
        // });		
    }
	
	function HitungUPIm(id){
       var alloyprice=$("#dt_alloyprice_"+id).val();
		 var fabcost=$("#dt_fabcost_"+id).val();
		 var diskon=$("#dt_diskon_"+id).val();
		 var pajak=$("#dt_pajak_"+id).val();
		 var qty=$("#dt_qty_"+id).val();
		 var hargasatuan=$("#dt_hargasatuan_"+id).val();
		 var dt_width=$("#dt_totalwidth_"+id).val();
		 
		 var loi=$("#loi").val();
		 // console.log(dt_width)
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/HitungUP',
            data:"fabcost="+fabcost+"&alloyprice="+alloyprice+"&hargasatuan="+hargasatuan+"&loi="+loi,
            success:function(html){
                // $("#dt_hargasatuan_"+id).val(html); 
				$('.autoNumeric3').autoNumeric('init', { vMin: 0 });
				HitAmmount(id)
            }
        });
		// $.ajax({
            // type:"GET",
            // url:siteurl+'purchase_order/Hitjumlah',
            // data:"fabcost="+fabcost+"&alloyprice="+alloyprice+"&pajak="+pajak+"&diskon="+diskon+"&qty="+qty+"&hargasatuan="+hargasatuan+"&loi="+loi+"&dt_width="+dt_width,
            // success:function(html){
                // $("#dt_jumlahharga_"+id).val(html); 
            // }
        // });		
    }
	
	function CariProperties(id){
        var idpr=$("#dt_idpr_"+id).val();
		 $.ajax({
            type:"GET",
            url:siteurl+'purchase_order/CariIdMaterial',
            data:"idpr="+idpr+"&id="+id,
            success:function(html){
               $("#idmaterial_"+id).html(html); 
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/CariNamaMaterial',
            data:"idpr="+idpr+"&id="+id,
            success:function(html){
               $("#namaterial_"+id).html(html); 
            }
        });
				$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/CariPanjangMaterial',
            data:"idpr="+idpr+"&id="+id,
            success:function(html){
               $("#panjang_"+id).html(html); 
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/CariLebarMaterial', 
            data:"idpr="+idpr+"&id="+id,
            success:function(html){
               $("#lebar_"+id).html(html); 
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/CariDescripitionMaterial',
            data:"idpr="+idpr+"&id="+id,
            success:function(html){
               $("#description_"+id).html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/CariQtyMaterial',
            data:"idpr="+idpr+"&id="+id,
            success:function(html){
               $("#qty_"+id).html(html);
            }
        });
		// $.ajax({
            // type:"GET",
            // url:siteurl+'purchase_order/CariweightMaterial',
            // data:"idpr="+idpr+"&id="+id,
            // success:function(html){
               // $("#width_"+id).html(html);
            // }
        // });
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/CariTweightMaterial',
            data:"idpr="+idpr+"&id="+id,
            success:function(html){
               $("#totalwidth_"+id).html(html);
            }
        });
		
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/CariWidthMaterial',
            data:"idpr="+idpr+"&id="+id,
            success:function(html){
               $("#width_"+id).html(html);
            }
        });

		var a;
		var ArrList = [];
		for(a=1; a<=100; a++){
			var dataid = $('#dt_idpr_'+a).val();
			ArrList.push(dataid); 
		}
		$.ajax({
            type:"POST",
            url:siteurl+'purchase_order/getDateExp',
            data:{
				'id_pr' : ArrList
			},
			dataType	: 'json',
            success:function(data){
				$('#expect_tanggal').val(data.minimal)
            }
        });
    }
	function LockMaterial(id){
        var idpr=$("#dt_idpr_"+id).val();
		var idmaterial=$("#dt_idmaterial_"+id).val();
		var namaterial=$("#dt_namamaterial_"+id).val();
		var description=$("#dt_description_"+id).val();
		var qty=$("#dt_qty_"+id).val();
		var width=$("#dt_width_"+id).val();
		var totalwidth=$("#dt_totalweight_"+id).val();
		var hargasatuan=$("#dt_hargasatuan_"+id).val();
		var diskon=$("#dt_diskon_"+id).val();
		var pajak=$("#dt_pajak_"+id).val();
		var ratelme=$("#dt_ratelme_"+id).val();
		var alloyprice=$("#dt_alloyprice_"+id).val();
		var fabcost=$("#dt_fabcost_"+id).val();
		var panjang=$("#dt_panjang_"+id).val();
		var lebar=$("#dt_lebar_"+id).val();
		var jumlahharga=$("#dt_jumlahharga_"+id).val();
		var note=$("#dt_note_"+id).val();
		var subtotal=$("#subtotal").val();
		var hargatotal=$("#hargatotal").val();
		var diskontotal=$("#diskontotal").val();
		var taxtotal=$("#taxtotal").val();
		if( qty == '' || qty == null  || hargasatuan == '' || hargasatuan == null){
					swal("Warning", "Form Tidak Boleh Kosong :)", "error");
					return false;
		}else{
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/LockMatrial',
            data:"idpr="+idpr+"&id="+id+"&idmaterial="+idmaterial+"&width="+width+"&ratelme="+ratelme+"&alloyprice="+alloyprice+"&fabcost="+fabcost+"&panjang="+panjang+"&lebar="+lebar+"&totalwidth="+totalwidth+"&namaterial="+namaterial+"&description="+description+"&qty="+qty+"&hargasatuan="+hargasatuan+"&diskon="+diskon+"&pajak="+pajak+"&jumlahharga="+jumlahharga+"&note="+note,
            success:function(html){
               $("#trmaterial_"+id).html(html);
            }
        });
		 $.ajax({
            type:"GET",
            url:siteurl+'purchase_order/CariTHarga',
			data:"idpr="+idpr+"&id="+id+"&hargatotal="+hargatotal+"&idmaterial="+idmaterial+"&namaterial="+namaterial+"&description="+description+"&qty="+qty+"&hargasatuan="+hargasatuan+"&diskon="+diskon+"&pajak="+pajak+"&jumlahharga="+jumlahharga+"&note="+note,
            success:function(html){
               $("#ForHarga").html(html); 
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/CariTDiskon',
            data:"idpr="+idpr+"&id="+id+"&diskontotal="+diskontotal+"&idmaterial="+idmaterial+"&namaterial="+namaterial+"&description="+description+"&qty="+qty+"&hargasatuan="+hargasatuan+"&diskon="+diskon+"&pajak="+pajak+"&jumlahharga="+jumlahharga+"&note="+note,
            success:function(html){
               $("#ForDiskon").html(html); 
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/CariTPajak',
            data:"idpr="+idpr+"&id="+id+"&taxtotal="+taxtotal+"&idmaterial="+idmaterial+"&namaterial="+namaterial+"&description="+description+"&qty="+qty+"&hargasatuan="+hargasatuan+"&diskon="+diskon+"&pajak="+pajak+"&jumlahharga="+jumlahharga+"&note="+note,
            success:function(html){
               $("#ForTax").html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/CariTSum',
            data:"idpr="+idpr+"&id="+id+"&hargatotal="+hargatotal+"&diskontotal="+diskontotal+"&taxtotal="+taxtotal+"&idmaterial="+idmaterial+"&namaterial="+namaterial+"&description="+description+"&qty="+qty+"&hargasatuan="+hargasatuan+"&diskon="+diskon+"&pajak="+pajak+"&jumlahharga="+jumlahharga+"&note="+note,
            success:function(html){
               $("#ForSum").html(html);
            }
        });
		}
    }
	function CancelItem(id){
        var idpr=$("#dt_idpr_"+id).val();
		var idmaterial=$("#dt_idmaterial_"+id).val();
		var namaterial=$("#dt_namamaterial_"+id).val();
		var description=$("#dt_description_"+id).val();
		var qty=$("#dt_qty_"+id).val();
		var hargasatuan=$("#dt_hargasatuan_"+id).val();
		var diskon=$("#dt_diskon_"+id).val();
		var pajak=$("#dt_pajak_"+id).val();
		var jumlahharga=$("#dt_jumlahharga_"+id).val();
		var note=$("#dt_note_"+id).val();
		var subtotal=$("#subtotal").val();
		var hargatotal=$("#hargatotal").val();
		var diskontotal=$("#diskontotal").val();
		var taxtotal=$("#taxtotal").val();
		 $.ajax({
            type:"GET",
            url:siteurl+'purchase_order/CariMinHarga',
			data:"idpr="+idpr+"&id="+id+"&hargatotal="+hargatotal+"&idmaterial="+idmaterial+"&namaterial="+namaterial+"&description="+description+"&qty="+qty+"&hargasatuan="+hargasatuan+"&diskon="+diskon+"&pajak="+pajak+"&jumlahharga="+jumlahharga+"&note="+note,
            success:function(html){
               $("#ForHarga").html(html); 
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/CariMinDiskon',
            data:"idpr="+idpr+"&id="+id+"&diskontotal="+diskontotal+"&idmaterial="+idmaterial+"&namaterial="+namaterial+"&description="+description+"&qty="+qty+"&hargasatuan="+hargasatuan+"&diskon="+diskon+"&pajak="+pajak+"&jumlahharga="+jumlahharga+"&note="+note,
            success:function(html){
               $("#ForDiskon").html(html); 
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/CariMinPajak',
            data:"idpr="+idpr+"&id="+id+"&taxtotal="+taxtotal+"&idmaterial="+idmaterial+"&namaterial="+namaterial+"&description="+description+"&qty="+qty+"&hargasatuan="+hargasatuan+"&diskon="+diskon+"&pajak="+pajak+"&jumlahharga="+jumlahharga+"&note="+note,
            success:function(html){
               $("#ForTax").html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/CariMinSum',
            data:"idpr="+idpr+"&id="+id+"&hargatotal="+hargatotal+"&diskontotal="+diskontotal+"&taxtotal="+taxtotal+"&idmaterial="+idmaterial+"&namaterial="+namaterial+"&description="+description+"&qty="+qty+"&hargasatuan="+hargasatuan+"&diskon="+diskon+"&pajak="+pajak+"&jumlahharga="+jumlahharga+"&note="+note,
            success:function(html){
               $("#ForSum").html(html);
            }
        });
		$('#data_request #trmaterial_'+id).remove();
    }
	function HapusItem(id){
		
	}
	
	function HitungHarga2(id){
        var dt_qty=$("#dt_qty_"+id).val();
		 var dt_width=$("#dt_totalwidth_"+id).val();
		 var dt_hargasatuan=$("#dt_hargasatuan_"+id).val();
		 console.log(dt_width);
		 $.ajax({
            type:"GET",
            url:siteurl+'purchase_order/HitungHarga',
            data:"dt_hargasatuan="+dt_hargasatuan+"&dt_qty="+dt_qty+"&id="+id+"&dt_width="+dt_width,
            success:function(html){
               $("#jumlahharga_"+id).html(html);
            }
        });
		
    }
	
	function get_lokasi(){
        var supplier=$("#id_suplier").val();
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/CariLokasi',
            data:"supplier="+supplier,
            success:function(html){
               $("#loi").html(html);
			   get_kurs();
            }
			
        });
		
		
    }
	


	function getNum(val) {
		if (isNaN(val) || val == '') {
			return 0;
		}
		return parseFloat(val);
	}

	
	  
</script>
<script src="<?= base_url('assets/js/jquery.maskMoney.js')?>"></script> 
<script src="<?= base_url('assets/js/autoNumeric.js')?>"></script>
<script>
	$(function() {
		$('.chosen-select').select2({ width: '100%' });
		$('.select').select2({ width: '100%' });
		$('#tanggal').datepicker({
			dateFormat: 'yy-mm-dd',
			changeMonth:true,
			changeYear:true,
		});
    });
</script>
<script src="<?= base_url('assets/js/purchase_order_form.js') ?>"></script>
