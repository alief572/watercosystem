<?php
	$tanggal = date('Y-m-d');
foreach ($results['head'] as $head){
}
$material	= $this->db->query("SELECT * FROM dt_trans_po WHERE no_po = '".$head->no_po."' ")->result();
$suplier	= $this->db->query("SELECT * FROM master_supplier WHERE id_suplier = '".$head->id_suplier."' ")->result();
?>

 <div class="box box-primary">
    <div class="box-body">
		<form id="data-form" method="post">
			<div class="col-sm-12">
				<div class="input_fields_wrap2">
			<div class="row">
		<center><label for="customer" ><h3>Incoming</h3></label></center>
				<div class="col-sm-12">
		<div class="col-sm-6">
		<div class="form-group row">
			<div class="col-md-4">
				<label for="customer">No.Dokumen</label>
			</div>
			<div class="col-md-8">
				<label>: <?= $head->id_incoming?></label>
			</div>
		</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="id_customer">Supplier</label>
				</div>
				<div class="col-md-8">
				<label>: <?= strtoupper($suplier[0]->name_suplier)?></label>
			</div>
			</div>
		</div>
		</div>
		<div class="col-sm-12">
		<div class="col-sm-6">
		<div class="form-group row">
			<div class="col-md-4">
				<label for="customer">Tgl. Transaksi</label>
			</div>
			<div class="col-md-8">
				<label>: <?= date('d F Y',strtotime($head->tanggal));?></label>
			</div>
		</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="id_customer">Keterangan</label>
				</div>
			<div class="col-md-8">
				<label>: <?= $head->keterangan?></label>
			</div>
			</div>
		</div>
		</div>
		<div class="col-sm-12">
		<div class="col-sm-6">
		<div class="form-group row">
			<div class="col-md-4">
				<label for="customer">PIC</label>
			</div>
			<div class="col-md-8">
				<label>: <?= $head->pic ?></label>
			</div>
		</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="id_customer">PIB</label>
				</div>
			<div class="col-md-8">
				<label>: <?= $head->pib?></label>
			</div>
			</div>
		</div>
		
		</div>
		<div class="col-sm-12">
		<div class="col-sm-6">
		<div class="form-group row">
			<div class="col-md-4">
				<label for="customer">Kurs</label>
			</div>
			<div class="col-md-8">
			<?php
			if($head->kurs != 1){
				
				$kurs = number_format($head->kurs);
			}else{
				$kurs =0;
			}
			?>
				<label>: <?= $kurs ?></label>
			</div>
		</div>
		</div>
		
		</div>
		</div>
		<div class="form-group row" >
			<table class='table table-bordered table-striped'>
			<thead>
				<tr class='bg-blue'>
					<th class='text-center'>No PO</th>
					<th class='text-center'>Produk</th>
					<th class='text-center'>Qty Order</th>
					<th class='text-center'>Qty Terima</th>
					<th class='text-center'>Harga Satuan</th>
					<th class='text-center'>Total Harga</th>
				</tr>
			</thead>
			<tbody id="data_request">
			<?php
		$loop=0;
	foreach ($results['detail'] as $material){
	$no_po	= substr($material->id_dt_po,0,8);
	$mt     = $this->db->query("SELECT * FROM tr_purchase_order WHERE no_po = '".$no_po."'  ")->row();
	$no_surat = $mt->no_surat;
	$total    += $material->harga_satuan_usd * $material->qty_recive;
					
		$loop++;
		echo "
		<tr id='trmaterial_$loop'>
			<td class='text-left'>".$no_surat."</td>
			<td class='text-left'>".$material->nama_material."</td>
			<td class='text-right'>".number_format($material->qty_order)."</td>
			<td class='text-center'>".number_format($material->qty_recive)."</td>
			<td class='text-center'>".number_format($material->harga_satuan_usd,2)."</td>
			<td class='text-center'>".number_format($material->harga_satuan_usd * $material->qty_recive,2)."</td>
			
		</tr>
		";
		}
			?>
			<tr class='bg-blue'>
					<th class='text-center'></th>
					<th class='text-center'>Total</th>
					<th class='text-center'></th>
					<th class='text-center'></th>
					<th class='text-center'></th>
					<th class='text-center'><?=number_format($total,2)?></th>
				</tr>
			</tbody>
			</table>
		</div>
			</div>
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
			var max_fields2      = 10; //maximum input boxes allowed
			var wrapper2         = $(".input_fields_wrap2"); //Fields wrapper
			var add_button2      = $(".add_field_button2"); //Add button ID			
	$('#simpan-com').click(function(e){
			e.preventDefault();
			var deskripsi	= $('#deskripsi').val();
			var image	= $('#image').val();
			var idtype	= $('#inventory_1').val();
			
			var data, xhr;
			swal({
				  title: "Are you sure?",
				  text: "You will not be able to process again this data!",
				  type: "warning",
				  showCancelButton: true,
				  confirmButtonClass: "btn-danger",
				  confirmButtonText: "Yes, Process it!",
				  cancelButtonText: "No, cancel process!",
				  closeOnConfirm: true,
				  closeOnCancel: false
				},
				function(isConfirm) {
				  if (isConfirm) {
						var formData 	=new FormData($('#data-form')[0]);
						var baseurl=siteurl+'incoming/SaveUpdate';
						$.ajax({
							url			: baseurl,
							type		: "POST",
							data		: formData,
							cache		: false,
							dataType	: 'json',
							processData	: false, 
							contentType	: false,				
							success		: function(data){								
								if(data.status == 1){											
									swal({
										  title	: "Save Success!",
										  text	: data.pesan,
										  type	: "success",
										  timer	: 7000,
										  showCancelButton	: false,
										  showConfirmButton	: false,
										  allowOutsideClick	: false
										});
									window.location.href = base_url + active_controller;
								}else{
									
									if(data.status == 2){
										swal({
										  title	: "Save Failed!",
										  text	: data.pesan,
										  type	: "warning",
										  timer	: 7000,
										  showCancelButton	: false,
										  showConfirmButton	: false,
										  allowOutsideClick	: false
										});
									}else{
										swal({
										  title	: "Save Failed!",
										  text	: data.pesan,
										  type	: "warning",
										  timer	: 7000,
										  showCancelButton	: false,
										  showConfirmButton	: false,
										  allowOutsideClick	: false
										});
									}
									
								}
							},
							error: function() {
								
								swal({
								  title				: "Error Message !",
								  text				: 'An Error Occured During Process. Please try again..',						
								  type				: "warning",								  
								  timer				: 7000,
								  showCancelButton	: false,
								  showConfirmButton	: false,
								  allowOutsideClick	: false
								});
							}
						});
				  } else {
					swal("Cancelled", "Data can be process again :)", "error");
					return false;
				  }
			});
		});
		
});
	function get_material(){ 
		var jumlah	=$('#data_request').find('tr').length;
		var no_po=$("#no_po").val();
		$.ajax({
            type:"GET",
            url:siteurl+'incoming/GetMaterial',
            data:"jumlah="+jumlah+"&no_po="+no_po,
            success:function(html){
               $("#data_request").html(html);
            }
        });
    }
	function HitungHarga(id){
        var dt_qty=$("#dt_qty_"+id).val();
		 var dt_width=$("#dt_width_"+id).val();
		 var dt_hargasatuan=$("#dt_hargasatuan_"+id).val();
		 $.ajax({
            type:"GET",
            url:siteurl+'incoming/HitungHarga',
            data:"dt_hargasatuan="+dt_hargasatuan+"&dt_qty="+dt_qty+"&id="+id,
            success:function(html){
               $("#jumlahharga_"+id).html(html);
            }
        });
		 $.ajax({
            type:"GET",
            url:siteurl+'purchase_order/TotalWeight',
            data:"dt_width="+dt_width+"&dt_qty="+dt_qty+"&id="+id,
            success:function(html){
               $("#totalwidth_"+id).html(html);
            }
        });
    }
	function get_kurs(){
        var loi=$("#loi").val();
		 $.ajax({
            type:"GET",
            url:siteurl+'purchase_order/CariKurs',
            data:"loi="+loi,
            success:function(html){
               $("#kurs_place").html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/FormInputKurs',
            data:"loi="+loi,
            success:function(html){
               $("#input_kurs").html(html);
            }
        });
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
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/CariweightMaterial',
            data:"idpr="+idpr+"&id="+id,
            success:function(html){
               $("#width_"+id).html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/CariTweightMaterial',
            data:"idpr="+idpr+"&id="+id,
            success:function(html){
               $("#totalwidth_"+id).html(html);
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
		var totalwidth=$("#dt_totalwidth_"+id).val();
		var hargasatuan=$("#dt_hargasatuan_"+id).val();
		var diskon=$("#dt_diskon_"+id).val();
		var pajak=$("#dt_pajak_"+id).val();
		var panjang=$("#dt_panjang_"+id).val();
		var lebar=$("#dt_lebar_"+id).val();
		var jumlahharga=$("#dt_jumlahharga_"+id).val();
		var note=$("#dt_note_"+id).val();
		var subtotal=$("#subtotal").val();
		var hargatotal=$("#hargatotal").val();
		var diskontotal=$("#diskontotal").val();
		var taxtotal=$("#taxtotal").val();
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/LockMatrial',
            data:"idpr="+idpr+"&id="+id+"&idmaterial="+idmaterial+"&width="+width+"&panjang="+panjang+"&lebar="+lebar+"&totalwidth="+totalwidth+"&namaterial="+namaterial+"&description="+description+"&qty="+qty+"&hargasatuan="+hargasatuan+"&diskon="+diskon+"&pajak="+pajak+"&jumlahharga="+jumlahharga+"&note="+note,
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
		$('#data_request #trmaterial_'+id).remove();
		
	}
	
	
	
</script>