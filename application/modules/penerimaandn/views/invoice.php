 <div class="box box-primary">
    <div class="box-body">
		<form id="data-form" method="post">
		<div class="form-group row" >
			 <table class="table table-bordered" width="100%" id="list_item_stok">
              <thead>
                  <tr>
				      <th width="30%">Code</th>
                      <th width="30%">No DN</th>
                      <th width="30%">Nama Customer</th>
                      <th width="30%">Total DN</th>
					   <th width="30%">Sisa DN</th>
                      <th width="2%" class="text-center">Aksi</th>  
                  </tr>
              </thead>
              <tbody>
                  <?php	
				 
				  $cust = $results['detail'];
				  
                  $invoice = $this->db->query("SELECT a.*, b.name_customer as nm_customer FROM tr_debit_note a
				                      INNER JOIN master_customers b ON a.id_customer=b.id_customer WHERE a.id_customer ='$cust' AND (a.sisa_tagihan >'0')")->result();
				  if($invoice){
					foreach($invoice as $ks=>$vs){
                  ?>
						  <tr>
							  <td><?php echo $vs->no_pr ?></td>
							  <td><?php echo $vs->no_surat ?></td>
							  <td><center><?php echo $vs->nm_customer ?></center></td>
							  <td><center><?php echo number_format($vs->nilai_tagihan) ?></center></td>
							  <td><center><?php echo number_format($vs->sisa_tagihan) ?></center></td>
							  <td>
							  <?php 
							  if($vs->status == '1'){
								  echo 'Belum Di Approve';
							  }else{
							  ?>
								<center>
									<button id="btn-<?php echo $vs->no_pr?>" class="btn btn-warning btn-sm" type="button" onclick="startmutasi('<?php echo $vs->no_pr?>', '<?php echo $vs->no_surat?>','<?php echo addslashes($vs->nm_customer) ?>','<?php echo $vs->nilai_tagihan?>','<?php echo $vs->sisa_tagihan?>')">
										Pilih
									</button>
								</center>
							  <?php 
							  }
							  ?>
							  </td>
						  </tr>
                  <?php 
						}
					  }				  
				  ?>
              </tbody>
          </table>
		</div>
			</div>
				 </div>
			</div>
		</form>		  
	</div>
</div>	
	
				  
				  

	
	
	
</script>