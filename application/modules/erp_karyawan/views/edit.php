<div class="nav-tabs-supplier">
    <!-- /.tab-content -->
    <div class="tab-content">
        <div class="tab-pane active" id="supplier">
        <!-- Biodata Mitra -->
            <div id='alert_edit' class="alert alert-success alert-dismissable" style="padding: 15px; display: none;">
            </div>
            <!-- form start-->
            <div class="box box-primary">
                <?php //print_r($results['data_position']);exit();?>
            
                <form action="#" method="POST" id="form_proses_bro">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title"><?= $title; ?></h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class='form-group row'>
                                <label class='label-control col-sm-2'><b>Employee ID <span class='text-red'>*</span></b></label>
                                <div class='col-sm-4'>
                                    <div class="input-group">
                                       
                                        <?php
                                        echo form_input(array('readonly' => 'readonly', 'id' => 'id', 'name' => 'id', 'class' => 'form-control input-sm', 'autocomplete' => 'off', 'placeholder' => 'Automatic'), $results['row'][0]->id);
                                        ?>
                                    </div>

                                </div>
                                <label class='label-control col-sm-2'><b>Employee Name <span class='text-red'>*</span></b></label>
                                <div class='col-sm-4'>
                                    <div class="input-group">
                                       
                                        <?php
                                        echo form_input(array('id' => 'name', 'name' => 'name', 'class' => 'form-control input-sm', 'autocomplete' => 'off', 'placeholder' => 'Employee Name'), $results['row'][0]->name);
                                        ?>
                                    </div>

                                </div>
                            </div>
                            <div class='form-group row'>
                                <label class='label-control col-sm-2'><b>NIK<span class='text-red'>*</span></b></label>
                                <div class='col-sm-4'>
                                    <div class="input-group">
                                       
                                        <?php
                                        echo form_input(array('id' => 'nik', 'name' => 'nik', 'class' => 'form-control input-sm', 'autocomplete' => 'off', 'placeholder' => 'Automatic'), $results['row'][0]->nik);
                                        ?>
                                    </div>

                                </div>
                                <label class='label-control col-sm-2'><b>Company Name<span class='text-red'>*</span></b></label>
                                <div class='col-sm-4'>
                                    <div class="input-group">
                                        
                                        <?php
                                        $results['data_companies'][0]	= 'Select An Option';
                                        echo form_dropdown('company_id', $results['data_companies'], $results['row'][0]->company_id, array('id' => 'company_id', 'class' => 'form-control input-sm'));
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class='form-group row'>
                                <label class='label-control col-sm-2'><b>Division Name<span class='text-red'>*</span></b></label>
                                <div class='col-sm-4'>
                                    <div class="input-group">
                                        
                                        <?php
                                       $results['data_divisions'][0]	= 'Select An Option';
                                        echo form_dropdown('division_id', $results['data_divisions'], $results['row'][0]->division_id, array('id' => 'division_id', 'class' => 'form-control input-sm'));
                                        ?>
                                    </div>
                                </div>
                                <label class='label-control col-sm-2'><b>Departement Name<span class='text-red'>*</span></b></label>
                                <div class='col-sm-4'>
                                    <div class="input-group">
                                        
                                        <?php
                                        $results['data_department'][0]	= 'Select An Option';
                                        echo form_dropdown('department_id', $results['data_department'], $results['row'][0]->department_id, array('id' => 'department_id', 'class' => 'form-control input-sm'));
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class='form-group row'>
                                <label class='label-control col-sm-2'><b>Title Name<span class='text-red'>*</span></b></label>
                                <div class='col-sm-4'>
                                    <div class="input-group">
                                        
                                        <?php
                                        $results['data_title'][0]	= 'Select An Option';
                                        echo form_dropdown('title_id', $results['data_title'], $results['row'][0]->title_id, array('id' => 'title_id', 'class' => 'form-control input-sm'));
                                        ?>
                                    </div>
                                </div>
                                <label class='label-control col-sm-2'><b>Position Name<span class='text-red'>*</span></b></label>
                                <div class='col-sm-4'>
                                    <div class="input-group">
                                        
                                        <?php
                                        $results['data_position'][0]	= 'Select An Option';
                                        echo form_dropdown('position_id',  $results['data_position'], $results['row'][0]->position_id, array('id' => 'position_id', 'class' => 'form-control input-sm'));
                                        ?>
                                    </div>
                                </div>

                            </div>

                            <!-- add by Hikmat / 18-07-2021 -->
                            <div class="form-group row">
                                <label class='label-control col-sm-2'><b>Place Of Birth <span class='text-red'>*</span></b></label>
                                <div class='col-sm-4'>
                                    <div class="input-group">
                                        
                                        <?php
                                        echo form_input(array('id' => 'hometown', 'name' => 'hometown', 'class' => 'form-control input-sm', 'autocomplete' => 'off', 'placeholder' => 'Hometown'), $results['row'][0]->hometown);
                                        ?>
                                    </div>

                                </div>
                                <label class='label-control col-sm-2'><b>Division Head<span class='text-red'>*</span></b></label>
                                <div class='col-sm-4'>
                                    <div class="input-group">
                                        
                                        <select name="division_head" id="divisions_head_id" class="form-control input-sm">
                                            <option value=""></option>
                                            <?php foreach ($results['data_divisions_head'] as $div => $val) : ?>
                                                <option value="<?= $div; ?>" <?= ($div == $results['row'][0]->division_head) ? 'selected' : ''; ?>><?= $val; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class='form-group row'>
                                <label class='label-control col-sm-2'><b>Date Of Birth <span class='text-red'>*</span></b></label>
                                <div class='col-sm-4'>
                                    <div class="input-group">
                                        
                                        <?php
                                        echo form_input(array('id' => 'birthday', 'name' => 'birthday', 'class' => 'form-control input-sm', 'autocomplete' => 'off', 'placeholder' => 'Birthday'), $results['row'][0]->birthday);
                                        ?>
                                    </div>
                                </div>
                                <label class='label-control col-sm-2'><b>Email <span class='text-red'>*</span></b></label>
                                <div class='col-sm-4'>
                                    <div class="input-group">
                                        
                                        <?php
                                        echo form_input(array('id' => 'email', 'name' => 'email', 'class' => 'form-control input-sm', 'autocomplete' => 'off', 'placeholder' => 'Email'), $results['row'][0]->email);
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <!-- end add -->

                            <div class='form-group row'>
                                <label class='label-control col-sm-2'><b>Religion <span class='text-red'>*</span></b></label>
                                <div class='col-sm-4'>
                                    <div class='input-group'>
                                        
                                        <?php
                                        $relid[0]	= 'Select An Option';
                                        $relid[1]	= 'Islam';
                                        $relid[2]	= 'Katolik';
                                        $relid[3]	= 'Kristen';
                                        $relid[4]	= 'Hindu';
                                        $relid[5]	= 'Budha';
                                        $relid[6]	= 'Kong Hu Chu';
                                        echo form_dropdown('relid', $relid, $results['row'][0]->relid, array('id' => 'relid', 'class' => 'form-control input-sm'));
                                        ?>
                                    </div>
                                </div>
                                <label class='label-control col-sm-2'><b>Gender</b></label>
                                <div class='col-sm-4'>
                                    <?php
                                    $active		= ($results['row'][0]->genderid == 'L') ? TRUE : FALSE;
                                    $data = array(
                                        'name'          => 'genderid',
                                        'id'            => 'genderid',
                                        'checked'       => $active,
                                        'value'         => 'L',
                                        'class'         => 'input-sm'
                                    );

                                    echo form_radio($data) . '&nbsp;&nbsp;Male';

                                    ?>
                                    <?php
                                    $active		= ($results['row'][0]->genderid == 'P') ? TRUE : FALSE;
                                    $data = array(
                                        'name'          => 'genderid',
                                        'id'            => 'genderid',
                                        'checked'       => $active,
                                        'value'         => 'P',
                                        'class'         => 'input-sm'
                                    );

                                    echo form_radio($data) . '&nbsp;&nbsp;Female';

                                    ?>
                                </div>
                            </div>
                            <div class='form-group row'>
                                <label class='label-control col-sm-2'><b>Stay Address<span class='text-red'>*</span></b></label>
                                <div class='col-sm-4'>
                                    <div class="input-group">
                                        
                                        <?php
                                        echo form_textarea(array('cols' => '40', 'rows' => '3', 'id' => 'address', 'name' => 'address', 'class' => 'form-control input-sm', 'autocomplete' => 'off', 'placeholder' => 'Address'), $results['row'][0]->address);
                                        ?>
                                    </div>

                                </div>
                                <label class='label-control col-sm-2'><b>City <span class='text-red'>*</span></b></label>
                                <div class='col-sm-4'>
                                    <div class="input-group">
                                        
                                        <?php
                                        echo form_input(array('id' => 'city', 'name' => 'city', 'class' => 'form-control input-sm', 'autocomplete' => 'off', 'placeholder' => 'City'), $results['row'][0]->city);
                                        ?>
                                    </div>

                                </div>
                            </div>

                            <div class='form-group row'>
                                <label class='label-control col-sm-2'><b>Province<span class='text-red'>*</span></b></label>
                                <div class='col-sm-4'>
                                    <div class="input-group">
                                        
                                        <?php
                                        echo form_input(array('id' => 'province', 'name' => 'province', 'class' => 'form-control input-sm', 'autocomplete' => 'off', 'placeholder' => 'Province'), $results['row'][0]->province);
                                        ?>
                                    </div>

                                </div>
                                <label class='label-control col-sm-2'><b>Post Code <span class='text-red'>*</span></b></label>
                                <div class='col-sm-4'>
                                    <div class="input-group">
                                        
                                        <?php
                                        echo form_input(array('id' => 'postcode', 'name' => 'postcode', 'class' => 'form-control input-sm', 'autocomplete' => 'off', 'placeholder' => 'Post code'), $results['row'][0]->postcode);
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class='form-group row'>
                                <label class='label-control col-sm-2'><b>Nationality<span class='text-red'>*</span></b></label>
                                <div class='col-sm-4'>
                                    <div class="input-group">
                                        <?php
                                        $active		= ($results['row'][0]->nationality == 'WNI') ? TRUE : FALSE;
                                        $data = array(
                                            'name'          => 'nationality',
                                            'id'            => 'nationality',
                                            'checked'       => $active,
                                            'value'         => 'WNI',
                                            'class'         => 'input-sm'
                                        );

                                        echo form_radio($data) . '&nbsp;&nbsp;WNI';

                                        ?>
                                        <?php
                                        $active		= ($results['row'][0]->genderid == 'WNA') ? TRUE : FALSE;
                                        $data = array(
                                            'name'          => 'nationality',
                                            'id'            => 'nationality',
                                            'checked'       => $active,
                                            'value'         => 'WNA',
                                            'class'         => 'input-sm'
                                        );

                                        echo form_radio($data) . '&nbsp;&nbsp;WNA';

                                        ?>
                                    </div>

                                </div>
                                <label class='label-control col-sm-2'><b>KTP <span class='text-red'>*</span></b></label>
                                <div class='col-sm-4'>
                                    <div class="input-group">
                                        
                                        <?php
                                        echo form_input(array('id' => 'licensid', 'name' => 'licensid', 'class' => 'form-control input-sm', 'autocomplete' => 'off', 'placeholder' => 'KTP'), $results['row'][0]->licensid);
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class='form-group row'>
                                <label class='label-control col-sm-2'><b>IdCard Address<span class='text-red'>*</span></b></label>
                                <div class='col-sm-4'>
                                    <div class="input-group">
                                        
                                        <?php
                                        echo form_textarea(array('cols' => '40', 'rows' => '3', 'id' => 'idcard_address', 'name' => 'idcard_address', 'class' => 'form-control input-sm', 'autocomplete' => 'off', 'placeholder' => 'IdCard Address'), $results['row'][0]->idcard_address);
                                        ?>
                                    </div>

                                </div>
                                <label class='label-control col-sm-2'><b>NPWP <span class='text-red'>*</span></b></label>
                                <div class='col-sm-4'>
                                    <div class="input-group">
                                        
                                        <?php
                                        echo form_input(array('id' => 'taxid', 'name' => 'taxid', 'class' => 'form-control input-sm', 'autocomplete' => 'off', 'placeholder' => 'NPWP'), $results['row'][0]->taxid);
                                        ?>
                                    </div>

                                </div>
                            </div>
                            <div class='form-group row'>
                                <label class='label-control col-sm-2'><b>Handphone Number <span class='text-red'>*</span></b></label>
                                <div class='col-sm-4'>
                                    <div class="input-group">
                                        
                                        <?php
                                        echo form_input(array('id' => 'hp', 'name' => 'hp', 'class' => 'form-control input-sm', 'autocomplete' => 'off', 'placeholder' => 'Handphone Number'), $results['row'][0]->hp);
                                        ?>
                                    </div>
                                </div>
                                <label class='label-control col-sm-2'><b>Phone Number<span class='text-red'></span></b></label>
                                <div class='col-sm-4'>
                                    <div class="input-group">
                                        
                                        <?php
                                        echo form_input(array('id' => 'phone', 'name' => 'phone', 'class' => 'form-control input-sm', 'autocomplete' => 'off', 'placeholder' => 'Phone Number'), $results['row'][0]->phone);
                                        ?>
                                    </div>
                                </div>

                            </div>
                            <div class='form-group row'>
                                <label class='label-control col-sm-2'><b>Hire Date<span class='text-red'>*</span></b></label>
                                <div class='col-sm-4'>
                                    <div class="input-group">
                                        
                                        <?php
                                        echo form_input(array('id' => 'hiredate', 'name' => 'hiredate', 'class' => 'form-control input-sm', 'autocomplete' => 'off', 'placeholder' => 'Hire Date'), $results['row'][0]->hiredate);
                                        ?>
                                    </div>
                                </div>
                                <label class='label-control col-sm-2'><b>Marital Status<span class='text-red'>*</span></b></label>
                                <div class='col-sm-4'>
                                    <div class="input-group">
                                        
                                        <?php
                                        $results['data_marital'][0]	= 'Select An Option';
                                        echo form_dropdown('marital_status', $data_marital, $results['row'][0]->marital_status, array('id' => 'marital_status', 'class' => 'form-control input-sm'));
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class='form-group row'>

                                <label class='label-control col-sm-2'><b>Bank Id<span class='text-red'></span></b></label>
                                <div class='col-sm-4'>
                                    <div class="input-group">
                                        <?php
                                        $active		= ($results['row'][0]->bank_id == 'BCA') ? TRUE : FALSE;
                                        $data = array(
                                            'name'          => 'bank_id',
                                            'id'            => 'bank_id',
                                            'checked'       => $active,
                                            'value'         => 'BCA',
                                            'class'         => 'input-sm'
                                        );

                                        echo form_radio($data) . '&nbsp;&nbsp;BCA';

                                        ?>
                                        <?php
                                        $active		= ($results['row'][0]->bank_id == 'BJB') ? TRUE : FALSE;
                                        $data = array(
                                            'name'          => 'bank_id',
                                            'id'            => 'bank_id',
                                            'checked'       => $active,
                                            'value'         => 'BJB',
                                            'class'         => 'input-sm'
                                        );

                                        echo form_radio($data) . '&nbsp;&nbsp;BJB';

                                        ?>

                                    </div>

                                </div>
                                <label class='label-control col-sm-2'><b>Account Number<span class='text-red'></span></b></label>
                                <div class='col-sm-4'>
                                    <div class="input-group">
                                        
                                        <?php
                                        echo form_input(array('id' => 'accnumber', 'name' => 'accnumber', 'class' => 'form-control input-sm', 'autocomplete' => 'off', 'placeholder' => 'Account Number'), $results['row'][0]->accnumber);
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class='form-group row'>

                                <label class='label-control col-sm-2'><b>Account Name<span class='text-red'></span></b></label>
                                <div class='col-sm-4'>
                                    <div class="input-group">
                                        
                                        <?php
                                        echo form_input(array('id' => 'accname', 'name' => 'accname', 'class' => 'form-control input-sm', 'autocomplete' => 'off', 'placeholder' => 'Account name'), $results['row'][0]->accname);						?>
                                    </div>

                                </div>
                                <label class='label-control col-sm-2'><b>Health Number Of BPJS <span class='text-red'></span></b></label>
                                <div class='col-sm-4'>
                                    <div class="input-group">
                                        
                                        <?php
                                        echo form_input(array('id' => 'bpjs_kes', 'name' => 'bpjs_kes', 'class' => 'form-control input-sm', 'autocomplete' => 'off', 'placeholder' => 'Health Number Of BPJS'), $results['row'][0]->bpjs_kes);
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class='form-group row'>

                                <label class='label-control col-sm-2'><b>Employee Number Of BPJS <span class='text-red'></span></b></label>
                                <div class='col-sm-4'>
                                    <div class="input-group">
                                        
                                        <?php
                                        echo form_input(array('id' => 'bpjs_ket', 'name' => 'bpjs_ket', 'class' => 'form-control input-sm', 'autocomplete' => 'off', 'placeholder' => 'Employee Number Of BPJS'), $results['row'][0]->bpjs_ket);
                                        ?>
                                    </div>

                                </div>
                                <label class='label-control col-sm-2'><b>Tax Marital Status<span class='text-red'>*</span></b></label>
                                <div class='col-sm-4'>
                                    <div class="input-group">
                                        
                                        <?php
                                        $data_marital[0]	= 'Select An Option';
                                        echo form_dropdown('tax_marital_status', $data_marital, $results['row'][0]->tax_marital_status, array('id' => 'tax_marital_status', 'class' => 'form-control input-sm'));
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <div class='form-group row'>
                                <label class='label-control col-sm-2'><b>Blood Group <span class='text-red'></span></b></label>
                                <div class='col-sm-4'>
                                    <div class="input-group">
                                       
                                        <?php
                                        $blood['']	= 'Select An Option';
                                        $blood['O']	= 'O';
                                        $blood['A']	= 'A';
                                        $blood['B']	= 'B';
                                        $blood['AB'] = 'AB';
                                        echo form_dropdown('blood_group', $blood, $results['row'][0]->blood_group, array('id' => 'blood_group', 'class' => 'form-control input-sm'));

                                        ?>
                                    </div>

                                </div>
                                <label class='label-control col-sm-2'><b>Finger Name<span class='text-red'>*</span></b></label>
                                <div class='col-sm-4'>
                                    <div class="input-group">
                                        
                                        <?php
                                        $data_idfinger[0]	= 'Select An Option';
                                        echo form_dropdown('finger_id', $data_idfinger, $results['row'][0]->finger_id, array('id' => 'finger_id', 'class' => 'form-control input-sm'));
                                        ?>
                                    </div>
                                </div>

                            </div>

                            <div class='form-group row'>
                                <label class='label-control col-sm-2'><b>Active<span class='text-red'></span>*</b></label>
                                <div class='col-sm-4'>
                                    <?php
                                    $active		= ($results['row'][0]->flag_active == 'Y') ? TRUE : FALSE;
                                    $data = array(
                                        'name'          => 'flag_active',
                                        'id'            => 'flag_active',
                                        'checked'       => $active,
                                        'value'         => 'Y',
                                        'class'         => 'input-sm'
                                    );

                                    echo form_checkbox($data) . '&nbsp;&nbsp;Yes';

                                    ?>

                                </div>

                                <label class='label-control col-sm-2'><b>Salary<span class='text-red'>*</span></b></label>
                                <div class='col-sm-4'>
                                    <div class="input-group">
                                        
                                        <?php
                                        echo form_input(array('id' => 'salary', 'name' => 'salary', 'class' => 'form-control input-sm', 'autocomplete' => 'off', 'placeholder' => 'Salary'), Dekripsi($results['row'][0]->salary));
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class='form-group row'> -->
                                <!-- <label class='label-control col-sm-2'><b>Jabatan Allowance<span class='text-red'>*</span></b></label>
                                <div class='col-sm-4'>
                                    <div class="input-group">
                                                      
                                        <?php
                                        //echo form_input(array('id'=>'jabatan','name'=>'jabatan','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Jabatan Allowance'),Dekripsi($results['row'][0]->jabatan));											
                                        ?>
                                    </div>
                                </div>				
                                <label class='label-control col-sm-2'><b>Pulsa Allowance<span class='text-red'>*</span></b></label>
                                <div class='col-sm-4'>
                                    <div class="input-group">
                                                      
                                        <?php
                                        //echo form_input(array('id'=>'pulsa','name'=>'pulsa','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Pulsa Allowance'),Dekripsi($results['row'][0]->pulsa));											
                                        ?>
                                    </div>
                                </div>	
                            </div> -->

                            <div class='form-group row'>
                                <label class='label-control col-sm-2'><b>Tanda&nbsp; (<span class='text-red'>*</span>)&nbsp Wajib Diisi</b></label>
                            </div>

                            <!-- </div> -->
                            <div class="box-body">
                                <div class="box box-danger">
                                    <div class="box-header">
                                        <h3 class="box-title">
                                            <i class="fa fa-star"></i> <?php echo ('<span class="important">Family Data</span>'); ?>
                                        </h3>
                                        <div class='box-tool pull-right'>
                                            <?php
                                            echo form_button(array('type' => 'button', 'class' => 'btn btn-md btn-success', 'value' => 'back', 'content' => 'Add Family', 'id' => 'add-family'));
                                            ?>
                                        </div>
                                    </div>
                                    <div class="clearfix box-body">
                                        <table class='table table-bordered table-striped'>
                                            <thead>
                                                <tr class='bg-blue'>
                                                    <td align='center'><b>Name</b></td>
                                                    <td align='center'><b>Place Of Birth</b></td>
                                                    <td align='center'><b>Date Of Birth</b></td>
                                                    <td align='center'><b>Relationship</b></td>
                                                    <td align='center'><b>Action</b></td>
                                                </tr>

                                            </thead>
                                            <tbody id='list_family'>
                                                <?php
                                                if ($rows_family) {
                                                    $loop		= 0;
                                                    foreach ($rows_family as $keyF => $valF) {
                                                        $loop++;
                                                        echo "<tr id='tr_" . $loop . "'>";
                                                        echo "<td>";
                                                        echo form_input(array('name' => 'det_Family[' . $loop . '][name]', 'id' => 'det_Family_' . $loop . '_name', 'class' => 'form-control input-sm', 'autocomplete' => 'off'), $valF['name']);
                                                        echo "</td>";
                                                        echo "<td>";
                                                        echo form_input(array('name' => 'det_Family[' . $loop . '][birth_place]', 'id' => 'det_Family_' . $loop . '_place', 'class' => 'form-control input-sm', 'autocomplete' => 'off'), $valF['birth_place']);
                                                        echo "</td>";
                                                        echo "<td>";
                                                        echo form_input(array('name' => 'det_Family[' . $loop . '][birth_date]', 'id' => 'det_Family_' . $loop . '_birthday', 'class' => 'form-control input-sm', 'readOnly' => true, 'data-role' => 'tanggal'), $valF['birth_date']);
                                                        echo "</td>";
                                                        echo "<td class='text-center'>";
                                                        $family_type[0]	= 'Select An Option';
                                                        echo form_dropdown('det_Family[' . $loop . '][category]', $family_type, $valF['category'], array('id' => 'det_Family_' . $loop . '_category', 'class' => 'form-control input-sm'));
                                                        echo "</td>";
                                                        echo "<td class='text-center'>";
                                                        echo "<button type='button' class='btn btn-sm btn-danger' title='Hapus Data' data-role='qtip' onClick='return DelItem(" . $loop . ");'><i class='fa fa-trash-o'></i></button>";
                                                        echo "</td>";
                                                        echo "</tr>";
                                                    }
                                                }

                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="box-body">
                                <div class="box box-danger">
                                    <div class="box-header">
                                        <h3 class="box-title">
                                            <i class="fa fa-star"></i> <?php echo ('<span class="important">Education History</span>'); ?>
                                        </h3>
                                        <div class='box-tool pull-right'>
                                            <?php
                                            echo form_button(array('type' => 'button', 'class' => 'btn btn-md btn-success', 'value' => 'back', 'content' => 'Add Education', 'id' => 'add-education'));
                                            ?>
                                        </div>
                                    </div>
                                    <div class="clearfix box-body">
                                        <table class='table table-bordered table-striped'>
                                            <thead>
                                                <tr class='bg-blue'>
                                                    <td align='center'><b>Level</b></td>
                                                    <td align='center'><b>Institution Name</b></td>
                                                    <td align='center'><b>Graduate Year</b></td>
                                                    <td align='center'><b>Action</b></td>
                                                </tr>

                                            </thead>
                                            <tbody id='list_education'>
                                                <?php
                                                if ($rows_education) {
                                                    $loop		= 0;
                                                    foreach ($rows_education as $keyE => $valE) {
                                                        $loop++;
                                                        echo "<tr id='tr_" . $loop . "'>";
                                                        echo "<td class='text-center'>";
                                                        $education_type[0]	= 'Select An Option';
                                                        echo form_dropdown('det_Education[' . $loop . '][level]', $education_type, $valE['level'], array('id' => 'det_Education' . $loop . '_category', 'class' => 'form-control input-sm'));
                                                        echo "</td>";
                                                        echo "<td>";
                                                        echo form_input(array('name' => 'det_Education[' . $loop . '][institution]', 'id' => 'det_Education' . $loop . '_institution', 'class' => 'form-control input-sm', 'autocomplete' => 'off'), $valE['institution']);
                                                        echo "</td>";
                                                        echo "<td>";
                                                        echo form_input(array('name' => 'det_Education[' . $loop . '][graduated]', 'id' => 'det_Education' . $loop . '_year', 'class' => 'form-control input-sm', 'autocomplete' => 'off'), $valE['graduated']);
                                                        echo "</td>";
                                                        echo "<td class='text-center'>";
                                                        echo "<button type='button' class='btn btn-sm btn-danger' title='Hapus Data' data-role='qtip' onClick='return DelItem2(" . $loop . ");'><i class='fa fa-trash-o'></i></button>";
                                                        echo "</td>";
                                                        echo "</tr>";
                                                    }
                                                }

                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class='box-footer'>
                                <?php
                                echo form_button(array('type' => 'button', 'class' => 'btn btn-md btn-primary', 'value' => 'save', 'content' => 'Save', 'id' => 'simpan-com')) . ' ';
                                echo form_button(array('type' => 'button', 'class' => 'btn btn-md btn-danger', 'value' => 'back', 'content' => 'Back', 'onClick' => 'javascript:back()'));
                                ?>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                </form>
            
            </div>



        <!-- Biodata Mitra -->
        </div>

    </div>
    <!-- /.tab-content -->
</div>