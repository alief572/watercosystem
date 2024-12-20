<?php
$this->load->view('include/side_menu'); 
//echo"<pre>";print_r($data_menu);
?> 
<form action="#" method="POST" id="form_proses_bro"> 
	<div class="box box-primary">
		<div class="box-header">
			<h3 class="box-title"><?php echo $title;?></h3>		
		</div>
		<!-- /.box-header -->
		<div class="box-body">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#biodata" data-toggle="tab" aria-expanded="true" id="data">Master Customer</a></li>                
					<li class=""><a href="#cust_pic" data-toggle="tab" aria-expanded="false" id="data_pic">PIC Customer</a></li>
					<li class=""><a href="#toko" data-toggle="tab" aria-expanded="false" id="data_toko">Toko</a></li>
				</ul>
				<!-- /.tab-content -->
				<div class="tab-content">
					<div class="tab-pane active" id="biodata">					
						<div class="box box-success">
							<div class="box-body">
								<div class="form-group row">									
									<label class='label-control col-sm-2'><b>Customer Name <span class='text-red'>*</span></b></label>
									<div class='col-sm-4'>
										<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-user"></i></span>
											<?php
												
												echo form_input(array('id'=>'nm_customer','name'=>'Customer[0][nm_customer]','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Customer Name','style'=>'text-transform:uppercase'));										
											?>
										</div>
									</div>

									<label class='label-control col-sm-2'><b>Business Fields <span class='text-red'>*</span></b></label>
									<div class='col-sm-4'>
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-building"></i></span>
											<?php
											$rows_bidang[0]	= 'Select An Option';						
											echo form_dropdown('Customer[bidang_usaha]',$rows_bidang, 0, array('id'=>'bidang_usaha','class'=>'form-control input-sm'));
											?>
										</div>
									</div>
								</div>
								<div class="form-group row">									
									<label class='label-control col-sm-2'><b>Selling Product<span class='text-red'>*</span></b></label>
									<div class='col-sm-4'>
										<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-folder"></i></span>
											<?php
												
												echo form_input(array('id'=>'produk_jual','name'=>'Customer[produk_jual]','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Selling Product','style'=>'text-transform:uppercase'));										
											?>
										</div>
									</div>

									<label class='label-control col-sm-2'><b>Credibility <span class='text-red'>*</span></b></label>
									<div class='col-sm-4'>
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-check"></i></span>
											<?php
											$Arr_Credibility	= array(
												''		=> 'Select An Option',
												'A'		=> 'A',
												'B'		=> 'B',
												'C'		=> 'C',
												'D'		=> 'D'
											);						
											echo form_dropdown('Customer[kredibilitas]',$Arr_Credibility, '', array('id'=>'kredibilitas','class'=>'form-control input-sm'));
											?>
										</div>
									</div>
								</div>
								<div class="form-group row">									
									<label class='label-control col-sm-2'><b>Address<span class='text-red'>*</span></b></label>
									<div class='col-sm-4'>
										<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
											<?php
												echo form_textarea(array('id'=>'alamat','name'=>'Customer[alamat]','class'=>'form-control input-sm','cols'=>'75','rows'=>'2','autocomplete'=>'off','placeholder'=>'Address','style'=>'text-transform:uppercase'));			
											?>
										</div>
									</div>

									<label class='label-control col-sm-2'><b>Province <span class='text-red'>*</span></b></label>
									<div class='col-sm-4'>
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-home"></i></span>
											<?php
											$rows_province['']	='Select An Option';						
											echo form_dropdown('Customer[provinsi]',$rows_province, '', array('id'=>'provinsi','class'=>'form-control input-sm'));
											?>
										</div>
									</div>
								</div>
								<div class="form-group row">									
									<label class='label-control col-sm-2'><b>District / City<span class='text-red'>*</span></b></label>
									<div class='col-sm-4'>
										<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-home"></i></span>
											<?php
												$arr_Kota	= array(
													''			=> 'Empty List'
												);						
												echo form_dropdown('Customer[kota]',$arr_Kota, '', array('id'=>'kota','class'=>'form-control input-sm'));			
											?>
										</div>
									</div>

									<label class='label-control col-sm-2'><b>Post Code <span class='text-red'>*</span></b></label>
									<div class='col-sm-4'>
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
											<?php
											echo form_input(array('id'=>'kode_pos','name'=>'Customer[kode_pos]','class'=>'form-control input-sm','placeholder'=>'Post Code'));
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
												echo form_input(array('id'=>'telpon','name'=>'Customer[telpon]','class'=>'form-control input-sm','placeholder'=>'Phone'));		
											?>
										</div>
									</div>

									<label class='label-control col-sm-2'><b>Fax</b></label>
									<div class='col-sm-4'>
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-fax"></i></span>
											<?php
											echo form_input(array('id'=>'fax','name'=>'Customer[fax]','class'=>'form-control input-sm','placeholder'=>'Fax'));
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
												echo form_input(array('id'=>'npwp','name'=>'Customer[npwp]','class'=>'form-control input-sm','placeholder'=>'NPWP'));		
											?>
										</div>
									</div>

									<label class='label-control col-sm-2'><b>NPWP Address <span class='text-red'>*</span></b></label>
									<div class='col-sm-4'>
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
											<?php
											echo form_textarea(array('id'=>'alamat_npwp','name'=>'Customer[alamat_npwp]','class'=>'form-control input-sm','cols'=>'75','rows'=>'2','autocomplete'=>'off','placeholder'=>'NPWP Address','style'=>'text-transform:uppercase'));
											?>
										</div>
									</div>
								</div>
								<div class="form-group row">									
									<label class='label-control col-sm-2'><b>Branch <span class='text-red'>*</span></b></label>
									<div class='col-sm-4'>
										<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-building"></i></span>
											<?php
												$rows_branch['']	= 'Select An Option';
												echo form_dropdown('Customer[kdcab]',$rows_branch, '', array('id'=>'kdcab','class'=>'form-control input-sm'));		
											?>
										</div>
									</div>

									<label class='label-control col-sm-2'><b>Marketing <span class='text-red'>*</span></b></label>
									<div class='col-sm-4'>
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-user"></i></span>
											<?php
											$rows_marketing	= array(
																''		=> 'Empty List'												
															);
												echo form_dropdown('Customer[id_marketing]',$rows_marketing, '', array('id'=>'id_marketing','class'=>'form-control input-sm'));
											?>
										</div>
									</div>
								</div>
								<div class="form-group row">									
									<label class='label-control col-sm-2'><b>Website <span class='text-red'>*</span></b></label>
									<div class='col-sm-4'>
										<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-globe"></i></span>
											<?php
												echo form_input(array('id'=>'website','name'=>'Customer[website]','class'=>'form-control input-sm','placeholder'=>'Website'));		
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
												echo form_dropdown('Customer[sts_aktif]',$rows_active, 'aktif', array('id'=>'sts_aktif','class'=>'form-control input-sm'));
											?>
										</div>
									</div>
								</div>
								
								<div class="form-group row">
									<label class='label-control col-sm-2'><b>Discount Customer <span class='text-red'>*</span></b></label>
									<div class='col-sm-4'>
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-dollar-sign"></i></span>
											<?php
												echo form_input(array('id'=>'diskon_toko','name'=>'Customer[diskon_toko]','class'=>'form-control input-sm','placeholder'=>'Discount Customer'));	
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
												echo form_dropdown('Customer[reference_by]',$rows_reference, '', array('id'=>'reference_by','class'=>'form-control input-sm'));		
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
												echo form_input(array('id'=>'reference_name','name'=>'Customer[reference_name]','class'=>'form-control input-sm','placeholder'=>'Reference Name'));	
											?>
										</div>
									</div>
									<label class='label-control col-sm-2'><b>Reference Phone<span class='text-red'>*</span></b></label>
									<div class='col-sm-4'>
										<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-phone"></i></span>
											<?php
												echo form_input(array('id'=>'reference_phone','name'=>'Customer[reference_phone]','class'=>'form-control input-sm','placeholder'=>'Reference Phone'));		
											?>
										</div>
									</div>									
								</div>
							</div>						
						</div>
					<!-- Biodata Mitra -->
					</div>

					<div class="tab-pane" id="toko">					
						<div class="box box-success">
							<div class="box-body">
								<div class="form-group row">									
									<label class='label-control col-sm-2'><b>Store Name <span class='text-red'>*</span></b></label>
									<div class='col-sm-4'>
										<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-building"></i></span>
											<?php
												
												echo form_input(array('id'=>'nm_toko','name'=>'Store[nm_toko]','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Store Name','style'=>'text-transform:uppercase'));										
											?>
										</div>
									</div>

									<label class='label-control col-sm-2'><b>Ownership Status <span class='text-red'>*</span></b></label>
									<div class='col-sm-4'>
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-user"></i></span>
											<?php
											$rows_owner			= array(
												''			=> "Select An Option",
												'MILIK'		=> "One's Own",
												'SEWA'		=> "Rent"
											);						
											echo form_dropdown('Store[status_milik]',$rows_owner, '', array('id'=>'status_milik','class'=>'form-control input-sm'));
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
												
												echo form_input(array('id'=>'luas','name'=>'Store[luas]','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Store Width','style'=>'text-transform:uppercase'));										
											?>
										</div>
									</div>

									<label class='label-control col-sm-2'><b>Since <span class='text-red'>*</span></b></label>
									<div class='col-sm-4'>
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
											<?php
											echo form_input(array('id'=>'thn_berdiri','name'=>'Store[thn_berdiri]','class'=>'form-control input-sm','placeholder'=>'Store Name','style'=>'text-transform:uppercase'));
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
												
												echo form_input(array('id'=>'area','name'=>'Store[area]','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Store Area','style'=>'text-transform:uppercase'));										
											?>
										</div>
									</div>

									<label class='label-control col-sm-2'><b>Address Store <span class='text-red'>*</span></b></label>
									<div class='col-sm-4'>
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-street-view"></i></span>
											<?php
											echo form_textarea(array('id'=>'alamat_toko','name'=>'Store[alamat_toko]','class'=>'form-control input-sm','cols'=>'75','rows'=>'2','autocomplete'=>'off','placeholder'=>'Address','style'=>'text-transform:uppercase'));
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
												
												echo form_input(array('id'=>'telpon_toko','name'=>'Store[telpon_toko]','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Store Phone'));										
											?>
										</div>
									</div>

									<label class='label-control col-sm-2'><b>Store Fax</b></label>
									<div class='col-sm-4'>
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-fax"></i></span>
											<?php
											echo form_input(array('id'=>'fax_toko','name'=>'Store[fax_toko]','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Store Fax'));
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
													echo form_input(array('id'=>'pic_name','name'=>'Store[pic_name]','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Store PIC','style'=>'text-transform:uppercase'));										
												?>
											</div>
										</div>

										<label class='label-control col-sm-2'><b>Phone PIC <span class='text-red'>*</span></b></label>
										<div class='col-sm-4'>
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-phone"></i></span>
												<?php
												echo form_input(array('id'=>'hp_pic','name'=>'Store[hp_pic]','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Store PIC Phone',));
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
													echo form_input(array('id'=>'email_pic','name'=>'Store[email_pic]','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Store PIC Email'));										
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
													echo form_input(array('id'=>'jam_tagih','name'=>'Store[jam_tagih]','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Store PIC Email'));										
												?>
											</div>
										</div>

										<label class='label-control col-sm-2'><b>Billing Day</b></label>
										<div class='col-sm-4'>
											<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
												<?php
													$Arr_Day	= array(
														''			=> 'Select An Option',
														'Senin'		=> 'Monday',
														'Selasa'	=> 'Tuesday',
														'Rabu'		=> 'Wednesday',
														'Kamis'		=> 'Thusday',
														'Jumat'		=> 'Friday'
													);
													echo form_dropdown('Store[hari_tagih][]',$Arr_Day, '', array('id'=>'hari_tagih','class'=>'form-control input-sm','multiple'=>true));										
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
												echo form_textarea(array('id'=>'alamat_tagih','name'=>'Store[alamat_tagih]','class'=>'form-control input-sm','cols'=>'75','rows'=>'2','autocomplete'=>'off','placeholder'=>'Billing Address','style'=>'text-transform:uppercase'));
												?>
											</div>
										</div>
										<label class='label-control col-sm-2'><b>Billing Requirement <span class='text-red'>*</span></b></label>
										<div class='col-sm-4'>
											<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-list"></i></span>
												<?php
													$Arr_Req	= array(
														''					=> 'Select An Option',
														'Surat Jalan'		=> 'Surat Jalan',
														'Faktur Pajak'		=> 'Faktur Pajak',
														'Berita Acara'		=> 'Berita Acara',
														'Dok Delivery Order'=> 'Dok Delivery Order',
														'Invoice'			=> 'Invoice'
													);
													echo form_dropdown('Store[syarat_dokumen][]',$Arr_Day, '', array('id'=>'syarat_dokumen','class'=>'form-control input-sm','multiple'=>true));										
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
												$Arr_Payment	= array(
													''					=> 'Select An Option',
													'Cash'				=> 'Cash',
													'Transfer'			=> 'Transfer',
													'Giro'				=> 'Cheque'
												);
												echo form_dropdown('Store[metode_bayar][]',$Arr_Payment, '', array('id'=>'metode_bayar','class'=>'form-control input-sm','multiple'=>true));
												?>
											</div>
										</div>
										
										<label class='label-control col-sm-2'><b>Payment Type <span class='text-red'>*</span></b></label>
										<div class='col-sm-4'>
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-list"></i></span>
												<?php
												$Arr_PayType		= array(
													''								=> 'Silahkan Pilih',
													'Pembayaran Sebelum Pengiriman'	=> 'Before Delivery',
													'Progress'						=> 'Progress',
													'Kredit'						=> 'Credit',
													'Setelah Project Selesai'		=> 'After Project Close'
												);
												echo form_dropdown('Store[sistem_bayar]',$Arr_Payment, '', array('id'=>'sistem_bayar','class'=>'form-control input-sm'));
												?>
											</div>
										</div>
																			
									</div>
									
								</div>
							

							
							<div class="box-footer">
							

							<div class="form-group" id="row_kredit">
								<label for="kredit_limit" class="col-sm-2 control-label">Kredit Limit</label>
								<div class="col-sm-3">
									<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-commenting"></i></span>
									<input type="text" class="form-control" id="kredit_limit" name="kredit_limit" maxlength="15" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');" value="<?php echo set_value('kredit_limit', isset($data->kredit_limit) ? $data->kredit_limit : ''); ?>" placeholder="Kredit Limit">
									</div>
								</div>

								<label for="termin_bayar" class="col-sm-2 control-label">Termin Pembayaran</label>
								<div class="col-sm-3">
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
							<div class="box-footer">
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">

									<button type="submit" name="btntoko" class="btn btn-success" id="btntoko"><i class="fa fa-save">&nbsp;</i>Save</button>

									<!--<a class="btn btn-success" id='btntoko' href="javascript:void(0)" title="Add" onclick="add_toko()"><i class="fa fa-save">&nbsp;</i>Save</a>-->

									<a class="btn btn-danger" href="javascript:void(0)" title="Cancel" onclick="cancel()"><i class="fa fa-minus-circle">&nbsp;</i>Cancel</a>

								</div>
							</div>
							</div>

							</div>
						<?php echo  form_close() ?>
						<div id="list_toko"></div>
						</div>
					<!-- Toko Kerja -->
					</div>

					<div class="tab-pane" id="cust_pic">
					<!-- PIC Kerja -->
						<div id='alert_edit' class="alert alert-success alert-dismissable" style="padding: 15px; display: none;">
						</div>
						<!-- form start-->
						<div class="box box-primary">
						<?php echo  form_open($this->uri->uri_string(),array('id'=>'frm_pic','name'=>'frm_pic','role'=>'form','class'=>'form-horizontal')) ?>
							<div class="box-body">
							<input type="hidden" id="customerx" name="customerx" value="<?php echo set_value('customerx', isset($data->id_customer) ? $data->id_customer : ''); ?>">
							<input type="hidden" id="id_pic" name="id_pic" value="<?php echo set_value('id_pic', isset($data->id_pic) ? $data->id_pic : get_id_pic($data->id_customer)); ?>">

							<?php  if(isset($data->hari_penagihan)){$type1='edit';}?>
							<input type="hidden" id="type1" name="type1" value="<?php echo  isset($type1) ? $type1 : 'add' ?>">
							<div class="form-group ">
								<label for="nm_pic" class="col-sm-2 control-label">Nama PIC <font size="4" color="red"><B>*</B></font></label>
								<div class="col-sm-3">
									<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-building"></i></span>
									<input type="text" class="form-control" id="nm_pic" name="nm_pic" maxlength="45" value="<?php echo set_value('nm_pic', isset($data->nm_pic) ? $data->nm_pic : ''); ?>" placeholder="Nama InCharge" required style="text-transform:uppercase">
									</div>
								</div>

								<label for="divisi" class="col-sm-2 control-label">Divisi <font size="4" color="red"><B>*</B></font></label>
								<div class="col-sm-3">
									<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-building"></i></span>
									<input type="text" class="form-control" id="divisi" name="divisi" maxlength="45" value="<?php echo set_value('divisi', isset($data->divisi) ? $data->divisi : ''); ?>" placeholder="Divisi" required style="text-transform:uppercase">
									</div>
								</div>
							</div>

							<div class="form-group ">                    
								<label for="hp" class="col-sm-2 control-label">HP <font size="4" color="red"><B>*</B></font></label>
								<div class="col-sm-3">
									<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-building"></i></span>
									<input type="text" class="form-control" id="hp" name="hp" maxlength="15" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');" placeholder="Nomor hp" value="<?php echo set_value('hp', isset($data->hp) ? $data->hp : ''); ?>" required>
									</div>
								</div>

								<label for="email_pic" class="col-sm-2 control-label">Email</label>
								<div class="col-sm-3">
									<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
									<input type="text" class="form-control" id="email_pic" name="email_pic" maxlength="45" value="<?php echo set_value('email_pic', isset($data->email_pic) ? $data->email_pic : ''); ?>" placeholder="Email" style="text-transform:uppercase">
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
						<?php echo  form_close() ?>
						<div id="list_pic"></div>
						</div>
					<!-- Pembayaran Kerja -->
					</div>

					<div class="tab-pane" id="foto">
					<!-- Data foto -->
					<div class="box box-primary"> 
						<form role="form" name="frm_foto" id="frm_foto" 
							  action="javascript:add_foto();" method="post" enctype="multipart/form-data">

						<div class="box-body">

							<div class="form-group ">
								<input type="hidden" id="id_customer" name="id_customer" value="<?php echo set_value('id_customer', isset($data->id_customer) ? $data->id_customer : ''); ?>"> 
								<!-- file gambar kita buat pada field hidden -->
								<input type="hidden" name="filelama" id="filelama" class="form-control" value="<?php echo set_value('filelama', isset($data->foto) ? $data->foto : ''); ?>"> 

								<label for="foto" class="col-sm-2 control-label">Foto</label>
								<div class="col-sm-3">
									<div class="input-group">
									<input id="foto" name="foto" type="file">
									<p class="help-block">Max Image 2 MB</p>
									</div>
								</div>            

								<div class="col-sm-offset-2 col-sm-10">

									<button type="submit" onclick="javascript:add_foto();" class="btn btn-primary" id="btnfoto">
									<span class="glyphicon glyphicon-plus"></span>&nbsp;Upload
									</button>

									<a class="btn btn-danger" href="javascript:void(0)" title="Cancel" onclick="cancel()"><i class="fa fa-minus-circle">&nbsp;</i>Cancel</a>                            
								</div>   
								<p>
								<div class="col-sm-offset-2 col-sm-10">
									 <div id='list_foto'></div>   
								</div>                                          
							</div> 
						</div>
						</form>           
					</div>

					</div>

					<div class="tab-pane" id="pic_toko">
					<!-- Data foto -->
					<div class="box box-primary"> 
						<form role="form" name="frm_foto_toko" id="frm_foto_toko" 
							  action="javascript:add_foto_toko();" method="post" enctype="multipart/form-data">

						<div class="box-body">                

							<div class="form-group ">
								<input type="hidden" id="customer" name="customer" value="<?php echo set_value('customer', isset($data->id_customer) ? $data->id_customer : ''); ?>">
								<!-- file gambar kita buat pada field hidden -->
								<input type="hidden" name="filelama_toko" id="filelama_toko" class="form-control" value="<?php echo set_value('filelama_toko', isset($data->foto_toko) ? $data->foto_toko : ''); ?>"> 

								<label for="id_toko" class="col-sm-2 control-label">Toko <font size="4" color="red"><B>*</B></font></label>
								<div class="col-sm-3">
									<select id="id_toko_foto" name="id_toko_foto" class="form-control pil_toko" style="width: 100%;" tabindex="-1" required>
										<option value=""></option>
										<?php foreach ($datprov as $key => $st) : ?>
										<option value="<?php echo  $st->id_toko; ?>" <?php echo  set_select('id_toko', $st->id_toko, isset($data->id_toko) && $data->id_toko == $st->id_toko) ?>>
										<?php echo  strtoupper($st->nm_toko); ?>
										</option>
										<?php endforeach; ?>
									</select>
								</div>

								<label for="foto_toko" class="col-sm-2 control-label">Foto Toko</label>
								<div class="col-sm-3">
									<div class="input-group">
									<input id="foto_toko" name="foto_toko" type="file">
									<p class="help-block">Max Image 2 MB</p>
									</div>
								</div>            

								<div class="col-sm-offset-2 col-sm-10">

									<button type="submit" onclick="javascript:add_foto_toko();" class="btn btn-primary" id="btnfoto">
									<span class="glyphicon glyphicon-plus"></span>&nbsp;Upload
									</button>

									<a class="btn btn-danger" href="javascript:void(0)" title="Cancel" onclick="cancel()"><i class="fa fa-minus-circle">&nbsp;</i>Cancel</a>                            
								</div>   
								<p>
								<div class="col-sm-offset-2 col-sm-10">
									 <div id='list_foto_toko'></div>   
								</div>                                          
							</div> 
						</div>
						</form>           
					</div>

					</div>

				</div>
				<!-- /.tab-content -->
			</div>

						
		</div>
		<div class='box-footer'>
			<?php
			echo form_button(array('type'=>'button','class'=>'btn btn-md btn-primary','value'=>'save','content'=>'Save','id'=>'simpan-bro')).' ';
			echo form_button(array('type'=>'button','class'=>'btn btn-md btn-danger','value'=>'back','content'=>'Back','onClick'=>'javascript:back()'));
			?>
		</div>
		<!-- /.box-body -->
	 </div>
  <!-- /.box -->
</form>

<!-- MODAL !-->
<!-- Modal Bidus-->
<div class="modal modal-info" id="add_bidangusaha" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<h4 class="modal-title" id="myModalLabel"><span class="fa fa-file-pdf-o"></span>&nbsp;Tambah Bidang Usaha</h4>
			</div>
			<div class="modal-body" id="MyModalBody">
			<form action="#" id="form_bidus">
			<div class="form-group">
				<label for="bidus">Bidang Usaha <font size="4" color="red"><B>*</B></font></label>
				<input type="text" class="form-control" id="bidus" name="bidus" style="text-transform:uppercase" placeholder="Input Bidang Usaha Baru" required>
				<input type="hidden" class="form-control" id="idbidus" name="idbidus">
			</div>
			<div class="form-group">
				<label for="exampleInputPassword1">Keterangan <font size="4" color="red"><B>*</B></font></label>
				<textarea class="form-control" id="keterangan" name="Input keterangan" maxlength="255" placeholder="Keterangan" required="" autofocus="" style="margin: 0px; height: 49px; width: 216px;"></textarea>
			</div>
			<div class="form-group">
				<iframe onload="ListBD()" hidden="true"></iframe>
			</div> 
			</form>
			</div>
			<div class="modal-footer">
			<button type="button" class="btn btn-outline" onclick="javascript:save_bidus();">Save</button>
			<button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
			</div>
			<div id="list_bd"></div> 
			<div class="modal-footer"></div>
		</div>
	</div>
</div>
<!-- End Modal Bidus-->
<!-- Modal Syarat Penagihan-->
<div class="modal modal-info" id="add_syaratdok" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<h4 class="modal-title" id="myModalLabel"><span class="fa fa-file-pdf-o"></span>&nbsp;Tambah Syarat Penagihan</h4>
			</div>
			<div class="modal-body" id="MyModalBody">
			<form action="#" id="form_syardok">
			<div class="form-group">
				<label for="bidus">Syarat Penagihan <font size="4" color="red"><B>*</B></font></label>
				<input type="text" class="form-control" id="add_nama_syarat" name="add_nama_syarat" placeholder="Input Syarat Penagihan Baru" style="text-transform:uppercase" required>
				<input type="hidden" class="form-control" id="add_id_syarat" name="add_id_syarat">
			</div>
			<div class="form-group">
				<iframe onload="ListSD()" hidden="true"></iframe>
			</div> 
			</form>
			</div>
			<div class="modal-footer">
			<button type="button" class="btn btn-outline" onclick="javascript:save_syardok();">Save</button>
			<button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
			</div>
			<div id="list_sd"></div>   
			<div class="modal-footer"></div>          
		</div>
	</div>
</div>
<!-- End Modal Syarat Penagihan-->
<!-- Modal Reff-->
<div class="modal modal-info" id="add_referensi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<h4 class="modal-title" id="myModalLabel"><span class="fa fa-file-pdf-o"></span>&nbsp;Tambah Referensi</h4>
			</div>
			<div class="modal-body" id="MyModalBody">
			<form action="#" id="form_reff">
			<div class="form-group">
				<label for="reff">Referensi <font size="4" color="red"><B>*</B></font></label>
				<input type="text" class="form-control" id="reff" name="reff" placeholder="Referensi" style="text-transform:uppercase" required>
			</div>
			<div class="form-group">
				<label for="exampleInputPassword1">Keterangan></label>
				<textarea class="form-control" id="keterangan" name="keterangan" maxlength="255" placeholder="Keterangan" style="text-transform:uppercase" style="margin: 0px; height: 49px; width: 216px;"></textarea>
			</div>
			</form>
			</div>
			<div class="modal-footer">
			<button type="button" class="btn btn-outline" onclick="javascript:save_reff();">Save</button>
			<button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view('include/footer'); ?>
<script>
	$(document).ready(function(){		
		$('#simpan-bro').click(function(e){
			e.preventDefault();
			$(this).prop('disabled',true);
			var nama	= $('#bidang_usaha').val();
			var lokasi	= $('#keterangan').val();
			if(nama=='' || nama==null || nama=='-'){
				swal({
				  title	: "Error Message!",
				  text	: 'Empty Business Fields, please input business fields first.....',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;
				
			}
			
			if(lokasi=='' || lokasi==null || lokasi=='-'){
				swal({
				  title	: "Error Message!",
				  text	: 'Empty Business Fields Description, please input business  fields description first.....',
				  type	: "warning"
				});
				$('#simpan-bro').prop('disabled',false);
				return false;
			}
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
						loading_spinner();
						var formData 	= new FormData($('#form_proses_bro')[0]);
						var baseurl		= base_url + active_controller +'/edit';
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
									$('#simpan-bro').prop('disabled',false);
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
								$('#simpan-bro').prop('disabled',false);
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
