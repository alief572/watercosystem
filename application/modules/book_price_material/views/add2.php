<?php
$this->load->view('include/side_menu'); 
//echo"<pre>";print_r($data_menu);
?> 
<form action="#" method="POST" id="form_proses_bro"> 
	<div class="box box-primary">
		<div class="box-header">
			<h3 class="box-title"><?php echo $title;?></h3>		
		</div>
		<div class="box-body">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li class="active"><a data-toggle="tab" href="#data">Master Customer</a></li>
					<li><a data-toggle="tab" href="#data_pic">PIC Customer</a></li>
					<!--<li><a data-toggle="tab" href="#data_toko">Shop</a></li>-->
				</ul>
				<div class="tab-content">
					<div id="data" class="tab-pane fade in active">
						<div class="box box-primary">
							<div class="box-body">
								<div class="form-group row">								
									<label class='label-control col-sm-2'><b>Customer Name <span class='text-red'>*</span></b></label>
									<div class='col-sm-4'>
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-check"></i></span>
											<?php
												echo form_input(array('id'=>'nm_customer','name'=>'nm_customer','class'=>'form-control input-md','autocomplete'=>'off','placeholder'=>'Customer Name','style'=>'text-transform:uppercase'));										
											?>
										</div>
									</div>
									<label class='label-control col-sm-2'><b>Business Fields <span class='text-red'>*</span></b></label>
									<div class='col-sm-4'>
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-building"></i></span>
											<select name='bidang_usaha' id='bidang_usaha' class='form-control input-md'>
												<option value=''>Select An Business Fields</option>
											<?php
												foreach($rows_bidang AS $val => $valx){
													echo "<option value='".$valx['id_bidang_usaha']."'>".ucwords(strtolower($valx['bidang_usaha']))."</option>";
												}
											 ?>
											</select>
										</div>
									</div>
								</div>
								<div class="form-group row">									
									<label class='label-control col-sm-2'><b>Selling Product<span class='text-red'>*</span></b></label>
									<div class='col-sm-4'>
										<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-folder"></i></span>
											<?php
												echo form_input(array('id'=>'produk_jual','name'=>'produk_jual','class'=>'form-control input-md','autocomplete'=>'off','placeholder'=>'Selling Product','style'=>'text-transform:uppercase'));										
											?>
										</div>
									</div>

									<label class='label-control col-sm-2'><b>Credibility <span class='text-red'>*</span></b></label>
									<div class='col-sm-4'>
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-check"></i></span>
											<?php
											$Arr_Credibility	= array(
												''		=> 'Select An Credibility',
												'A'		=> 'A',
												'B'		=> 'B',
												'C'		=> 'C',
												'D'		=> 'D'
											);						
											echo form_dropdown('kredibilitas',$Arr_Credibility, '', array('id'=>'kredibilitas','class'=>'form-control input-sm'));
											?>
										</div>
									</div>
								</div>
								<div class="form-group row">									
									<label class='label-control col-sm-2'><b>Country<span class='text-red'>*</span></b></label>
									<div class='col-sm-4'>
										<select name='country_code' id='country_code' class='form-control input-md'>
										 <?php
											foreach($CountryName AS $val => $valx){
												$selx = ($valx['country_code'] == 'IDN')?'selected':'';
												echo "<option value='".$valx['country_code']."' ".$selx.">".$valx['country_name']."</option>";
											}
										 ?>
										 </select>
									</div>

									<label class='label-control col-sm-2'><b>Province</b></label>
									<div class='col-sm-4'>
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-home"></i></span>
											<select name='provinsi' id='provinsi' class='form-control input-md'>
												<option value=''>Select An Province</option>
											<?php
												foreach($rows_province AS $val => $valx){
													echo "<option value='".$valx['id_prov']."'>".$valx['nama']."</option>";
												}
											 ?>	
											</select>
										</div>
									</div>
								</div>
								<div class="form-group row">									
									<label class='label-control col-sm-2'><b>District / City</b></label>
									<div class='col-sm-4'>
										<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-home"></i></span>
											<select name='kota' id='kota' class='form-control input-md'>
												<option value=''>List Empty</option>
											</select>	
										</div>
									</div>

									<label class='label-control col-sm-2'><b>Post Code <span class='text-red'>*</span></b></label>
									<div class='col-sm-4'>
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
											<?php
											echo form_input(array('id'=>'kode_pos','name'=>'kode_pos','class'=>'form-control input-md','placeholder'=>'Post Code'));
											?>
										</div>
									</div>
								</div>
								<div class="form-group row">									
									<label class='label-control col-sm-2'><b>Address<span class='text-red'>*</span></b></label>
									<div class='col-sm-10'>
										<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
											<?php
												echo form_textarea(array('id'=>'alamat','name'=>'alamat','class'=>'form-control input-md','cols'=>'75','rows'=>'2','autocomplete'=>'off','placeholder'=>'Address','style'=>'text-transform:uppercase'));			
											?>
										</div>
									</div>
								</div>
								<div class="form-group row">									
									<label class='label-control col-sm-2'><b>Phone</b></label>
									<div class='col-sm-4'>
										<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-phone"></i></span>
											<?php
												echo form_input(array('id'=>'telpon','name'=>'telpon','class'=>'form-control input-md','placeholder'=>'Phone'));		
											?>
										</div>
									</div>

									<label class='label-control col-sm-2'><b>Fax</b></label>
									<div class='col-sm-4'>
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-fax"></i></span>
											<?php
											echo form_input(array('id'=>'fax','name'=>'fax','class'=>'form-control input-md','placeholder'=>'Fax'));
											?>
										</div>
									</div>
								</div>
								<div class="form-group row">									
									<label class='label-control col-sm-2'><b>NPWP <span class='text-red'>*</span></b></label>
									<div class='col-sm-4'>
										<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
											<?php
												echo form_input(array('id'=>'npwp','name'=>'npwp','class'=>'form-control input-md','placeholder'=>'NPWP'));		
											?>
										</div>
									</div>

									<label class='label-control col-sm-2'><b>NPWP Address <span class='text-red'>*</span></b></label>
									<div class='col-sm-4'>
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
											<?php
											echo form_textarea(array('id'=>'alamat_npwp','name'=>'alamat_npwp','class'=>'form-control input-md','cols'=>'75','rows'=>'2','autocomplete'=>'off','placeholder'=>'NPWP Address','style'=>'text-transform:uppercase'));
											?>
										</div>
									</div>
								</div>
								<div class="form-group row">									
									

									<label class='label-control col-sm-2'><b>Marketing <span class='text-red'>*</span></b></label>
									<div class='col-sm-4'>
										<select name='id_marketing' id='id_marketing' class='form-control input-md'>
											<option>Select An Marketing</option>
										 <?php
											foreach($rows_marketing AS $val => $valx){
												echo "<option value='".$valx['nik']."'>".$valx['nm_karyawan']."</option>";
											}
										 ?>
										 </select>
									</div>
								</div>
								<div class="form-group row">									
									<label class='label-control col-sm-2'><b>Website <span class='text-red'>*</span></b></label>
									<div class='col-sm-4'>
										<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-globe"></i></span>
											<?php
												echo form_input(array('id'=>'website','name'=>'website','class'=>'form-control input-md','placeholder'=>'Website'));		
											?>
										</div>
									</div>

									<label class='label-control col-sm-2'><b>Status <span class='text-red'>*</span></b></label>
									<div class='col-sm-4'>
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-user"></i></span>
											<?php
											$rows_active	= array(
												'aktif'		=> 'Active',
												'nonaktif'	=> 'Inactive'
											);
												echo form_dropdown('sts_aktif',$rows_active, 'aktif', array('id'=>'sts_aktif','class'=>'form-control input-md'));
											?>
										</div>
									</div>
								</div>
								
								<div class="form-group row">
									<label class='label-control col-sm-2'><b>Discount Customer (%) <span class='text-red'>*</span></b></label>
									<div class='col-sm-4'>
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-dollar"></i></span>
											<?php
												echo form_input(array('id'=>'diskon_toko','name'=>'diskon_toko','class'=>'form-control input-md','placeholder'=>'Discount Customer'));	
											?>
										</div>
									</div>
									<label class='label-control col-sm-2'><b>Reference By<span class='text-red'>*</span></b></label>
									<div class='col-sm-4'>
										<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-building"></i></span>
											<?php
												$rows_reference		= array(
													''			=> 'Select An Option',
													'Event'		=> 'Event',
													'Call'		=> 'Call',
													'Sales'		=> 'Sales',
													'Socmed'	=> 'Social Media',
													'Website'	=> 'Website',
													'Agent'		=> 'Agent',
													'Adword'	=> 'Google Adword'												
												);
												echo form_dropdown('reference_by',$rows_reference, '', array('id'=>'reference_by','class'=>'form-control input-md'));		
											?>
										</div>
									</div>
									
								</div>
								<div class="form-group row" id="detail_reff">
									<label class='label-control col-sm-2'><b>Reference Name <span class='text-red'>*</span></b></label>
									<div class='col-sm-4'>
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-user"></i></span>
											<?php
												echo form_input(array('id'=>'reference_name','name'=>'reference_name','class'=>'form-control input-md','placeholder'=>'Reference Name'));	
											?>
										</div>
									</div>
									<label class='label-control col-sm-2'><b>Reference Phone<span class='text-red'>*</span></b></label>
									<div class='col-sm-4'>
										<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-phone"></i></span>
											<?php
												echo form_input(array('id'=>'reference_phone','name'=>'reference_phone','class'=>'form-control input-md','placeholder'=>'Reference Phone'));		
											?>
										</div>
									</div>									
								</div>
							</div>						
						</div>
					</div>
					<div id="data_pic" class="tab-pane fade">
						<div class="box box-primary">
							<div class="box-body">
								<div class="form-group row">
									<label for="nm_pic" class="col-sm-2 control-label">PIC Name <font size="4" color="red"><B>*</B></font></label>
									<div class="col-sm-4">
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-building"></i></span>
											<input type="text" class="form-control input-md" id="nm_pic" name="nm_pic" maxlength="45" placeholder="PIC Name" autocomplete='off' required style="text-transform:uppercase">
										</div>
									</div>
									<label for="divisi" class="col-sm-2 control-label">Division <font size="4" color="red"><B>*</B></font></label>
									<div class="col-sm-4">
										<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-building"></i></span>
										<input type="text" class="form-control" id="divisi" name="divisi" maxlength="45" placeholder="Division" required autocomplete='off' style="text-transform:uppercase">
										</div>
									</div>
								</div>
								<div class="form-group row">                    
									<label for="hp" class="col-sm-2 control-label">Contact Number <font size="4" color="red"><B>*</B></font></label>
									<div class="col-sm-4">
										<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-building"></i></span>
										<input type="text" class="form-control" id="hp" name="hp" maxlength="15" placeholder="Contact Number" autocomplete='off' required>
										</div>
									</div>
									<label for="email_pic" class="col-sm-2 control-label">Email Address</label>
									<div class="col-sm-4">
										<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
										<input type="text" class="form-control" id="email_pic" name="email_pic" maxlength="45" placeholder="Email Address" autocomplete='off'>
										</div>
									</div>
								</div>
								<div class="box-footer">
									<div class="form-group">
										<div class="col-sm-offset-2 col-sm-10">
											<button type="submit" name="btnpic" class="btn btn-success" id="btnpic"><i class="fa fa-save">&nbsp;</i>Save</button>
											<!--<a class="btn btn-success" id='btntoko' href="javascript:void(0)" title="Add" onclick="add_toko()"><i class="fa fa-save">&nbsp;</i>Save</a>-->
											<a class="btn btn-danger" href="javascript:void(0)" title="Cancel" onclick="cancel()"><i class="fa fa-minus-circle">&nbsp;</i>Cancel</a>
										</div>
									</div>
								</div>
							</div>
							<div id="list_pic"></div>
						</div>
					</div>
					<!--
					<div id="data_toko" class="tab-pane fade">
						<div class="box box-primary">
							<div class="box-body">
								<div class="form-group row">									
									<label class='label-control col-sm-2'><b>Store Name <span class='text-red'>*</span></b></label>
									<div class='col-sm-4'>
										<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-building"></i></span>
											<?php
												// echo form_input(array('id'=>'nm_toko','name'=>'Store[nm_toko]','class'=>'form-control input-md','autocomplete'=>'off','placeholder'=>'Store Name','style'=>'text-transform:uppercase'));										
											?>
										</div>
									</div>

									<label class='label-control col-sm-2'><b>Ownership Status <span class='text-red'>*</span></b></label>
									<div class='col-sm-4'>
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-user"></i></span>
											<?php
											// $rows_owner			= array(
												// ''			=> "Select An Option",
												// 'MILIK'		=> "One's Own",
												// 'SEWA'		=> "Rent"
											// );						
											// echo form_dropdown('Store[status_milik]',$rows_owner, '', array('id'=>'status_milik','class'=>'form-control input-md'));
											?>
										</div>
									</div>
								</div>
								<div class="form-group row">									
									<label class='label-control col-sm-2'><b>Width <span class='text-red'>*</span></b></label>
									<div class='col-sm-4'>
										<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-globe"></i></span>
											<?php
												// echo form_input(array('id'=>'luas','name'=>'Store[luas]','class'=>'form-control input-md','autocomplete'=>'off','placeholder'=>'Store Width','style'=>'text-transform:uppercase'));										
											?>
										</div>
									</div>

									<label class='label-control col-sm-2'><b>Since <span class='text-red'>*</span></b></label>
									<div class='col-sm-4'>
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
											<?php
											// echo form_input(array('id'=>'thn_berdiri','name'=>'Store[thn_berdiri]','class'=>'form-control input-md','placeholder'=>'Store Name','style'=>'text-transform:uppercase'));
											?>
										</div>
									</div>
								</div>
								
								<div class="form-group row">									
									<label class='label-control col-sm-2'><b>Area <span class='text-red'>*</span></b></label>
									<div class='col-sm-4'>
										<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-home"></i></span>
											<?php
												// echo form_input(array('id'=>'area','name'=>'Store[area]','class'=>'form-control input-md','autocomplete'=>'off','placeholder'=>'Store Area','style'=>'text-transform:uppercase'));										
											?>
										</div>
									</div>

									<label class='label-control col-sm-2'><b>Address Store <span class='text-red'>*</span></b></label>
									<div class='col-sm-4'>
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-street-view"></i></span>
											<?php
											// echo form_textarea(array('id'=>'alamat_toko','name'=>'Store[alamat_toko]','class'=>'form-control input-md','cols'=>'75','rows'=>'2','autocomplete'=>'off','placeholder'=>'Address','style'=>'text-transform:uppercase'));
											?>
										</div>
									</div>
								</div>
								<div class="form-group row">									
									<label class='label-control col-sm-2'><b>Store Phone</b></label>
									<div class='col-sm-4'>
										<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-phone"></i></span>
											<?php
												// echo form_input(array('id'=>'telpon_toko','name'=>'Store[telpon_toko]','class'=>'form-control input-md','autocomplete'=>'off','placeholder'=>'Store Phone'));										
											?>
										</div>
									</div>

									<label class='label-control col-sm-2'><b>Store Fax</b></label>
									<div class='col-sm-4'>
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-fax"></i></span>
											<?php
											// echo form_input(array('id'=>'fax_toko','name'=>'Store[fax_toko]','class'=>'form-control input-md','autocomplete'=>'off','placeholder'=>'Store Fax'));
											?>
										</div>
									</div>
								</div>
								<div class="box-footer">
									<div class="form-group row">									
										<label class='label-control col-sm-2'><b>PIC Name <span class='text-red'>*</span></b></label>
										<div class='col-sm-4'>
											<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-user"></i></span>
												<?php													
													// echo form_input(array('id'=>'pic_name','name'=>'Store[pic_name]','class'=>'form-control input-md','autocomplete'=>'off','placeholder'=>'Store PIC','style'=>'text-transform:uppercase'));										
												?>
											</div>
										</div>

										<label class='label-control col-sm-2'><b>Phone PIC <span class='text-red'>*</span></b></label>
										<div class='col-sm-4'>
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-phone"></i></span>
												<?php
												// echo form_input(array('id'=>'hp_pic','name'=>'Store[hp_pic]','class'=>'form-control input-md','autocomplete'=>'off','placeholder'=>'Store PIC Phone',));
												?>
											</div>
										</div>
									</div>
									<div class="form-group row">									
										<label class='label-control col-sm-2'><b>PIC Email</b></label>
										<div class='col-sm-4'>
											<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
												<?php													
													// echo form_input(array('id'=>'email_pic','name'=>'Store[email_pic]','class'=>'form-control input-md','autocomplete'=>'off','placeholder'=>'Store PIC Email'));										
												?>
											</div>
										</div>

										<label class='label-control col-sm-2'><b></b></label>
										<div class='col-sm-4'>
											
										</div>
									</div>
									
								</div>
								<div class="box-footer">
									<div class="form-group row">									
										<label class='label-control col-sm-2'><b>Billing Time</b></label>
										<div class='col-sm-4'>
											<div class="input-group bootstrap-timepicker timepicker">
											<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
												<?php													
													// echo form_input(array('id'=>'jam_tagih','name'=>'Store[jam_tagih]','class'=>'form-control input-md','autocomplete'=>'off','placeholder'=>'Store PIC Email'));										
												?>
											</div>
										</div>

										<label class='label-control col-sm-2'><b>Billing Day</b></label>
										<div class='col-sm-4'>
											<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
												<?php
													// $Arr_Day	= array(
														// ''			=> 'Select An Option',
														// 'Senin'		=> 'Monday',
														// 'Selasa'	=> 'Tuesday',
														// 'Rabu'		=> 'Wednesday',
														// 'Kamis'		=> 'Thusday',
														// 'Jumat'		=> 'Friday'
													// );
													// echo form_dropdown('Store[hari_tagih][]',$Arr_Day, '', array('id'=>'hari_tagih','class'=>'form-control input-md','multiple'=>true));										
												?>
											</div>
										</div>
									</div>
									<div class="form-group row">
										<label class='label-control col-sm-2'><b>Billing Address <span class='text-red'>*</span></b></label>
										<div class='col-sm-4'>
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-street-view"></i></span>
												<?php
												// echo form_textarea(array('id'=>'alamat_tagih','name'=>'Store[alamat_tagih]','class'=>'form-control input-md','cols'=>'75','rows'=>'2','autocomplete'=>'off','placeholder'=>'Billing Address','style'=>'text-transform:uppercase'));
												?>
											</div>
										</div>
										<label class='label-control col-sm-2'><b>Billing Requirement <span class='text-red'>*</span></b></label>
										<div class='col-sm-4'>
											<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-list"></i></span>
												<?php
													// $Arr_Req	= array(
														// ''					=> 'Select An Option',
														// 'Surat Jalan'		=> 'Surat Jalan',
														// 'Faktur Pajak'		=> 'Faktur Pajak',
														// 'Berita Acara'		=> 'Berita Acara',
														// 'Dok Delivery Order'=> 'Dok Delivery Order',
														// 'Invoice'			=> 'Invoice'
													// );
													// echo form_dropdown('Store[syarat_dokumen][]',$Arr_Day, '', array('id'=>'syarat_dokumen','class'=>'form-control input-md','multiple'=>true));										
												?>
											</div>
										</div>										
									</div>
									<div class="form-group row">
										<label class='label-control col-sm-2'><b>Payment Method <span class='text-red'>*</span></b></label>
										<div class='col-sm-4'>
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
												<?php
												// $Arr_Payment	= array(
													// ''					=> 'Select An Option',
													// 'Cash'				=> 'Cash',
													// 'Transfer'			=> 'Transfer',
													// 'Giro'				=> 'Cheque'
												// );
												// echo form_dropdown('Store[metode_bayar][]',$Arr_Payment, '', array('id'=>'metode_bayar','class'=>'form-control input-md','multiple'=>true));
												?>
											</div>
										</div>
										
										<label class='label-control col-sm-2'><b>Payment Type <span class='text-red'>*</span></b></label>
										<div class='col-sm-4'>
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-list"></i></span>
												<?php
												// $Arr_PayType		= array(
													// ''								=> 'Silahkan Pilih',
													// 'Pembayaran Sebelum Pengiriman'	=> 'Before Delivery',
													// 'Progress'						=> 'Progress',
													// 'Kredit'						=> 'Credit',
													// 'Setelah Project Selesai'		=> 'After Project Close'
												// );
												// echo form_dropdown('Store[sistem_bayar]',$Arr_Payment, '', array('id'=>'sistem_bayar','class'=>'form-control input-md'));
												?>
											</div>
										</div>
																			
									</div>
									
								</div>
							

							
							<div class="box-footer">
							

							<div class="form-group" id="row_kredit">
								<label for="kredit_limit" class="col-sm-2 control-label">Kredit Limit</label>
								<div class="col-sm-4">
									<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-commenting"></i></span>
									<input type="text" class="form-control" id="kredit_limit" name="kredit_limit" maxlength="15" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');" value="<?php echo set_value('kredit_limit', isset($data->kredit_limit) ? $data->kredit_limit : ''); ?>" placeholder="Kredit Limit">
									</div>
								</div>

								<label for="termin_bayar" class="col-sm-2 control-label">Termin Pembayaran</label>
								<div class="col-sm-4">
									<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-commenting"></i></span>
									<input type="text" class="form-control" id="termin_bayar" name="termin_bayar" maxlength="15" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');" value="<?php echo set_value('termin_bayar', isset($data->termin_bayar) ? $data->termin_bayar : ''); ?>" placeholder="Termin Pembayaran dalam Hari">
									<div class="input-group-btn">
										<a class="btn btn-info">Hari
										</a>
									</div>
									</div>
								</div>
							</div>               
							</div>

							<!--
							<div class="box-footer">
							<label for="foto_toko" class="col-sm-2 control-label">Foto Toko</label>
								<div class="col-sm-3">
									<div class="input-group">
									<input class="form-control" id="foto_toko" name="foto_toko" type="file">
									<p class="help-block">Max Image 2 MB</p>
									</div>
								</div>      
							</div>
							-->
							<!--
							<div class="box-footer">
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">

									<button type="submit" name="btntoko" class="btn btn-success" id="btntoko"><i class="fa fa-save">&nbsp;</i>Save</button>

									<!--<a class="btn btn-success" id='btntoko' href="javascript:void(0)" title="Add" onclick="add_toko()"><i class="fa fa-save">&nbsp;</i>Save</a>-->
<!--
									<a class="btn btn-danger" href="javascript:void(0)" title="Cancel" onclick="cancel()"><i class="fa fa-minus-circle">&nbsp;</i>Cancel</a>

								</div>
							</div>
							</div>

							</div>
						<div id="list_toko"></div>
						</div>
					</div>
				</div>
			</div>
			-->
		</div>
	</div>
</form>

<?php $this->load->view('include/footer'); ?>
<style type="text/css">
	.chosen-container-active .chosen-single {
	     border: none;
	     box-shadow: none;
	}
	.chosen-container-single .chosen-single {
		height: 34px;
	    border: 1px solid #d2d6de;
	    border-radius: 0px;
	     background: none;
	    box-shadow: none;
	    color: #444;
	    line-height: 32px;
	}
	.chosen-container-single .chosen-single div{
		top: 5px;
	}
	#bidang_usaha_chosen{
		width: 100% !important;
	}
	#kredibilitas_chosen{
		width: 100% !important;
	}
	#provinsi_chosen{
		width: 100% !important;
	}
	#kota_chosen{
		width: 100% !important;
	}
	#kdcab_chosen{
		width: 100% !important;
	}
	#id_marketing_chosen{
		width: 100% !important;
	}
	#sts_aktif_chosen{
		width: 100% !important;
	}
	#reference_by_chosen{
		width: 100% !important;
	}
	#metode_bayar_chosen{
		width: 100% !important;
	}
	#hari_tagih_chosen{
		width: 100% !important;
	}
	#syarat_dokumen_chosen{
		width: 100% !important;
	}
	#sistem_bayar_chosen{
		width: 100% !important;
	}
	#status_milik_chosen{
		width: 100% !important;
	}
	#country_code_chosen{
		width: 100% !important;
	}
</style>
<script>
	$(document).ready(function(){
		$('#diskon_toko').mask('?99');
		$('#kode_pos').mask('?99999');
		$('#telpon').mask('?999-999999999');
		$('#fax').mask('?999-999999999');
		$('#npwp').mask('?99.999.999.9-999.99');
		$('#reference_phone').mask('?9999-9999-99999');
		$('#hp').mask('?9999-9999-99999');
		$(document).on('change', '#provinsi', function(e){
			e.preventDefault();
			$.ajax({
				url: base_url +'index.php/'+ active_controller+'/getDistrict',
				cache: false,
				type: "POST",
				data: "id_prov="+this.value,
				dataType: "json",
				success: function(data){
					$("#kota").html(data.option).trigger("chosen:updated");
				}
			});
		});		
		$('#btnpic').click(function(e){
			e.preventDefault();
			$(this).prop('disabled',true);
			//Customer
			var nm_customer		= $('#nm_customer').val();
			var bidang_usaha	= $('#bidang_usaha').val();
			var produk_jual		= $('#produk_jual').val();
			var kredibilitas	= $('#kredibilitas').val();
			var alamat			= $('#alamat').val();
			var provinsi		= $('#provinsi').val();
			var kota			= $('#kota').val();
			var kode_pos		= $('#kode_pos').val();
			var telpon			= $('#telpon').val();
			var fax				= $('#fax').val();
			var npwp			= $('#npwp').val();
			var alamat_npwp		= $('#alamat_npwp').val();
			var kdcab			= $('#kdcab').val();
			var id_marketing	= $('#id_marketing').val();
			var website			= $('#website').val();
			var sts_aktif		= $('#sts_aktif').val();
			var diskon_toko		= $('#diskon_toko').val();
			var reference_by	= $('#reference_by').val();
			var reference_name	= $('#reference_name').val();
			var reference_phone	= $('#reference_phone').val();
			
			//PIC Customer
			var nm_pic			= $('#nm_pic').val();
			var divisi			= $('#divisi').val();
			var hp				= $('#hp').val();
			var email_pic		= $('#email_pic').val();
			
			if(nm_customer=='' || nm_customer==null || nm_customer=='-' || nm_customer=='0'){
				swal({
				  title	: "Error Message!",
				  text	: 'Customer Name in master customer tab is empty, please input first ...',
				  type	: "warning"
				});
				$('#btnpic').prop('disabled',false);
				return false;
			}
			if(bidang_usaha=='' || bidang_usaha==null || bidang_usaha=='-' || bidang_usaha=='0'){
				swal({
				  title	: "Error Message!",
				  text	: 'Business Field in master customer tab is empty, please input first ...',
				  type	: "warning"
				});
				$('#btnpic').prop('disabled',false);
				return false;
			}
			if(produk_jual=='' || produk_jual==null || produk_jual=='-' || produk_jual=='0'){
				swal({
				  title	: "Error Message!",
				  text	: 'Selling Producte in master customer tab is empty, please input first ...',
				  type	: "warning"
				});
				$('#btnpic').prop('disabled',false);
				return false;
			}
			if(kredibilitas=='' || kredibilitas==null || kredibilitas=='-' || kredibilitas=='0'){
				swal({
				  title	: "Error Message!",
				  text	: 'Credibility in master customer tab is empty, please input first ...',
				  type	: "warning"
				});
				$('#btnpic').prop('disabled',false);
				return false;
			}
			if(alamat=='' || alamat==null || alamat=='-' || alamat=='0'){
				swal({
				  title	: "Error Message!",
				  text	: 'Address in master customer tab is empty, please input first ...',
				  type	: "warning"
				});
				$('#btnpic').prop('disabled',false);
				return false;
			}
			// if(provinsi=='' || provinsi==null || provinsi=='-' || provinsi=='0'){
				// swal({
				  // title	: "Error Message!",
				  // text	: 'Province in master customer tab is empty, please input first ...',
				  // type	: "warning"
				// });
				// $('#btnpic').prop('disabled',false);
				// return false;
			// }
			// if(kota=='' || kota==null || kota=='-' || kota=='0'){
				// swal({
				  // title	: "Error Message!",
				  // text	: 'City in master customer tab is empty, please input first ...',
				  // type	: "warning"
				// });
				// $('#btnpic').prop('disabled',false);
				// return false;
			// }
			if(kode_pos=='' || kode_pos==null || kode_pos=='-' || kode_pos=='0'){
				swal({
				  title	: "Error Message!",
				  text	: 'Postal Code in master customer tab is empty, please input first ...',
				  type	: "warning"
				});
				$('#btnpic').prop('disabled',false);
				return false;
			}
			if(telpon=='' || telpon==null || telpon=='-' || telpon=='0'){
				swal({
				  title	: "Error Message!",
				  text	: 'Telephone in master customer tab is empty, please input first ...',
				  type	: "warning"
				});
				$('#btnpic').prop('disabled',false);
				return false;
			}
			if(fax=='' || fax==null || fax=='-' || fax=='0'){
				swal({
				  title	: "Error Message!",
				  text	: 'Fax in master customer tab is empty, please input first ...',
				  type	: "warning"
				});
				$('#btnpic').prop('disabled',false);
				return false;
			}
			if(npwp=='' || npwp==null || npwp=='-' || npwp=='0'){
				swal({
				  title	: "Error Message!",
				  text	: 'Tax ID in master customer tab is empty, please input first ...',
				  type	: "warning"
				});
				$('#btnpic').prop('disabled',false);
				return false;
			}
			if(alamat_npwp=='' || alamat_npwp==null || alamat_npwp=='-' || alamat_npwp=='0'){
				swal({
				  title	: "Error Message!",
				  text	: 'Tax ID Address in master customer tab is empty, please input first ...',
				  type	: "warning"
				});
				$('#btnpic').prop('disabled',false);
				return false;
			}
			// if(kdcab=='' || kdcab==null || kdcab=='-' || kdcab=='0'){
				// swal({
				  // title	: "Error Message!",
				  // text	: 'Branch in master customer tab is empty, please input first ...',
				  // type	: "warning"
				// });
				// $('#btnpic').prop('disabled',false);
				// return false;
			// } 
			// if(id_marketing=='' || id_marketing==null || id_marketing=='-' || id_marketing=='0'){
				// swal({
				  // title	: "Error Message!",
				  // text	: 'Marketing in master customer tab is empty, please input first ...',
				  // type	: "warning"
				// });
				// $('#btnpic').prop('disabled',false);
				// return false;
			// }
			if(website=='' || website==null || website=='-' || website=='0'){
				swal({
				  title	: "Error Message!",
				  text	: 'Website in master customer tab is empty, please input first ...',
				  type	: "warning"
				});
				$('#btnpic').prop('disabled',false);
				return false;
			}
			if(sts_aktif=='' || sts_aktif==null || sts_aktif=='-' || sts_aktif=='0'){
				swal({
				  title	: "Error Message!",
				  text	: 'Status in master customer tab is empty, please input first ...',
				  type	: "warning"
				});
				$('#btnpic').prop('disabled',false);
				return false;
			}
			if(diskon_toko=='' || diskon_toko==null || diskon_toko=='-' || diskon_toko=='0'){
				swal({
				  title	: "Error Message!",
				  text	: 'Customer discount in master customer tab is empty, please input first ...',
				  type	: "warning"
				});
				$('#btnpic').prop('disabled',false);
				return false;
			}
			if(reference_by=='' || reference_by==null || reference_by=='-' || reference_by=='0'){
				swal({
				  title	: "Error Message!",
				  text	: 'Reference by in master customer tab is empty, please input first ...',
				  type	: "warning"
				});
				$('#btnpic').prop('disabled',false);
				return false;
			}
			if(reference_name=='' || reference_name==null || reference_name=='-' || reference_name=='0'){
				swal({
				  title	: "Error Message!",
				  text	: 'Reference by in master customer tab is empty, please input first ...',
				  type	: "warning"
				});
				$('#btnpic').prop('disabled',false);
				return false;
			}
			if(reference_phone=='' || reference_phone==null || reference_phone=='-' || reference_phone=='0'){
				swal({
				  title	: "Error Message!",
				  text	: 'Reference phone in master customer tab is empty, please input first ...',
				  type	: "warning"
				});
				$('#btnpic').prop('disabled',false);
				return false;
			}
			
			
			if(nm_pic=='' || nm_pic==null || nm_pic=='-' || nm_pic=='0'){
				swal({
				  title	: "Error Message!",
				  text	: 'PIC name in PIC customer tab is empty, please input first ...',
				  type	: "warning"
				});
				$('#btnpic').prop('disabled',false);
				return false;
			}
			if(divisi=='' || divisi==null || divisi=='-' || divisi=='0'){
				swal({
				  title	: "Error Message!",
				  text	: 'Division in PIC customer tab is empty, please input first ...',
				  type	: "warning"
				});
				$('#btnpic').prop('disabled',false);
				return false;
			}
			if(hp=='' || hp==null || hp=='-' || hp=='0'){
				swal({
				  title	: "Error Message!",
				  text	: 'PIC phone in PIC customer tab is empty, please input first ...',
				  type	: "warning"
				});
				$('#btnpic').prop('disabled',false);
				return false;
			}
			if(email_pic=='' || email_pic==null || email_pic=='-' || email_pic=='0'){
				swal({
				  title	: "Error Message!",
				  text	: 'PIC email in PIC customer tab is empty, please input first ...',
				  type	: "warning"
				});
				$('#btnpic').prop('disabled',false);
				return false;
			}
			// $('#btnpic').prop('disabled',false);
			
			swal({
				  title: "Are you sure?",
				  text: "You will not be able to process again this data!",
				  type: "warning",
				  showCancelButton: true,
				  confirmButtonClass: "btn-danger",
				  confirmButtonText: "Yes, Process it!",
				  cancelButtonText: "No, cancel process!",
				  closeOnConfirm: false,
				  closeOnCancel: false
				},
				function(isConfirm) {
				  if (isConfirm) {
						loading_spinner();
						var formData 	= new FormData($('#form_proses_bro')[0]);
						var baseurl		= base_url + active_controller +'/add';
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
										  timer	: 7000
										});
									window.location.href = base_url + active_controller;
								}
								if(data.status == 2){
									swal({
									  title	: "Save Failed!",
									  text	: data.pesan,
									  type	: "warning",
									  timer	: 7000
									});
								}
								if(data.status == 3){
									swal({
									  title	: "Save Failed!",
									  text	: data.pesan,
									  type	: "warning",
									  timer	: 7000
									});
								}
								else{
									swal({
									  title	: "Save Failed!",
									  text	: data.pesan,
									  type	: "warning",
									  timer	: 7000
									});
								}
								$('#btnpic').prop('disabled',false);
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
								$('#btnpic').prop('disabled',false);
							}
						});
				  } else {
					swal("Cancelled", "Data can be process again :)", "error");
					$('#simpan-bro').prop('disabled',false);
					return false;
				  }
			});
		});
		
	});
	
</script>
