<style>
img {
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 5px;
    width: 50px;
}

img:hover {
    box-shadow: 0 0 2px 1px rgba(0, 140, 186, 0.5);
}
</style>
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#biodata" data-toggle="tab" aria-expanded="true" id="data">Master Customer</a></li>                
        <li class=""><a href="#cust_pic" data-toggle="tab" aria-expanded="false" id="data_pic">PIC Customer</a></li>
    </ul>
    <!-- /.tab-content -->
    <div class="tab-content">
        <div class="tab-pane active" id="biodata">
			<h3>Biodata</h3>
        </div>

        <div class="tab-pane" id="cust_pic">
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
                            <option value="<?= $st->id_toko; ?>" <?= set_select('id_toko', $st->id_toko, isset($data->id_toko) && $data->id_toko == $st->id_toko) ?>>
                            <?= strtoupper($st->nm_toko); ?>
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

<!-- awal untuk modal dialog -->
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
<!-- End Modal Reff-->
<script type="text/javascript">

    $(function() {
        $('#row_kredit').hide(); 
        $('#sistem_bayar').change(function(){
        if($('#sistem_bayar').val() == 'Kredit') {
            $('#row_kredit').show(); 
        } else {
            $('#row_kredit').hide(); 
        } 
        });
    });

    //Timepicker
    $('#jam_tagih').timepicker({
        showInputs: true
    });
    
    $("#hari_tagih").select2({
        placeholder: "Pilih Hari"//,
        //allowClear: true
    });

    $("#syarat_dokumen").select2({
        placeholder: "Pilih Dokumen"//,
        //allowClear: true
    });

    $("#metode_bayar").select2({
        placeholder: "Pilih"//,
        //allowClear: true
    });

    $(document).ready(function() {
        var type = $('#type').val();
        if(type=='edit'){
            ShowOtherButton();
        }else{
            HideOtherButton();
        }
        
        $(".pil_bidus").select2({
            placeholder: "Pilih Bidang Usaha",
            allowClear: true
        });

        $(".pil_reff").select2({
            placeholder: "Pilih Referensi",
            allowClear: true
        });

        $(".pil_provinsi").select2({
            placeholder: "Pilih",
            allowClear: true
        });

        $(".pil_pic").select2({
            placeholder: "Pilih",
            allowClear: true
        });

        $(".pil_toko").select2({
            placeholder: "Pilih",
            allowClear: true
        });

        $(".pil_kota").select2({
            placeholder: "Pilih",
            allowClear: true
        });

        $(".pil_marketing").select2({
            placeholder: "Pilih",
            allowClear: true
        });

        $('#data_toko').click(function(){
            var id = $('#id_customer').val();
            if(id==''){
                $("#list_toko").hide();
            }else{
                load_toko_temp(id);
                load_pic_toko(id);
            }
        });

        $('#data_pic').click(function(){
            var id = $('#id_customer').val();
            if(id==''){
                $("#list_pic").hide();
            }else{
                load_pic(id);
                get_idcust_pic(id);
            }
        });

        $('#data_foto').click(function(){
            var id = $('#id_customer').val();
            if(id==''){
                $("#list_foto").hide();
            }else{
                load_foto(id);
            }
        });    

        $('#data_foto_toko').click(function(){
            var id = $('#id_customer').val();
            if(id==''){
                $("#list_foto_toko").hide();
            }else{
                load_id_toko(id);
                //load_foto_toko(id);
            }
        });                        

        
    });

    //Bidang Usaha
    function save_bidus(){

    var idbidus=$("#idbidus").val();
    var bidang_usaha=$("#bidus").val();
    var keterangan=$("#keterangan").val();

    if(bidang_usaha=='' || keterangan==''){
        swal({
          title: "Peringatan!",
          text: "Isi Data Dengan Lengkap!",
          type: "warning",
          confirmButtonText: "Ok"
        });
        //die;
    }else{
        $.ajax({
            type:"POST",
            url:siteurl+"customer/add_bidangusaha",
            data:"idbidus="+idbidus+"&bidang_usaha="+bidang_usaha+"&keterangan="+keterangan,
            success:function(html){
                $('#add_bidangusaha').modal('hide');
                $('#form_bidus')[0].reset(); // reset form on modals
                get_bidus();
                ListBD();
            }
        });
    }

    }

    
    //save_syardok
    function save_syardok(){

    var id_syarat=$("#add_id_syarat").val();
    var nm_syarat=$("#add_nama_syarat").val();

    if(nm_syarat==''){
        swal({
          title: "Peringatan!",
          text: "Isi Data Dengan Lengkap!",
          type: "warning",
          confirmButtonText: "Ok"
        });
        //die;
    }else{
        $.ajax({
            type:"POST",
            url:siteurl+"customer/add_syaratdok",
            data:"id_syarat="+id_syarat+"&nm_syarat="+nm_syarat,
            success:function(html){
                $('#add_syaratdok').modal('hide');
                $('#form_syardok')[0].reset(); // reset form on modals
                get_syardok();
                ListSD();
            }
        });
    }

    }


    function ListSD(){
    $.ajax({
        type:"GET",
        url:siteurl+"customer/ListSD",
        success:function(html){
            $("#list_sd").html(html);
        }
    })
    }

    function ListBD(){
    $.ajax({
        type:"GET",
        url:siteurl+"customer/ListBD",
        success:function(html){
            $("#list_bd").html(html);
        }
    })
    }

    function edit_bd(id){
        if(id != ""){
        $.ajax({
            type:"POST",
            url:siteurl+"customer/edit_bd",
            data:{"id":id},
            success:function(result){
                var data = JSON.parse(result);
                $('#bidus').val(data.bidang_usaha);
                $('#keterangan').val(data.keterangan);
                $('#idbidus').val(data.id_bidang_usaha);
            }
        })
    }   
    }

    function edit_sd(id){
        if(id != ""){
        $.ajax({
            type:"POST",
            url:siteurl+"customer/edit_sd",
            data:{"id":id},
            success:function(result){
                var data = JSON.parse(result);
                $('#add_nama_syarat').val(data.nm_syarat);
                $('#add_id_syarat').val(data.id_syarat);
            }
        })
    }   
    }
/*
    function get_LisBidus() {
        var bidang_usaha = $('#bidang_usaha').val();
        $.ajax({
            type:"GET",
            url:siteurl+"customer/get_LisBidus",
            data:"bidang_usaha="+bidang_usaha,
            dataType : "json",
            success:function(msg){
               $("#nm_cp").val(msg['nm_cp']);
               set_nmcolly();
            }
        });
    }    
*/
    function get_bidus(){
        $.ajax({
            type:"GET",
            url:siteurl+"customer/get_bidus",
            success:function(html){
               $("#bidang_usaha").html(html);
            }
        });
    }    

    function get_syardok(){
        $.ajax({
            type:"GET",
            url:siteurl+"customer/get_syardok",
            success:function(html){
               $("#syarat_dokumen").html(html);
            }
        });
    }   

    function load_id_toko(id){
        $.ajax({
            type:"GET",
            url:siteurl+"customer/load_id_toko",
            data:"id="+id,
            success:function(html){
               $("#id_toko_foto").html(html);
            }
        });
    }

    function load_pic_toko(id){
        $.ajax({
            type:"GET",
            url:siteurl+"customer/load_pic_toko",
            data:"id="+id,
            success:function(html){
               $("#pic").html(html);
            }
        });
    }

    //Reff
    function save_reff(){

    var referensi=$("#reff").val();
    var keterangan=$("#keterangan").val();

    if(referensi==''){
        swal({
        title: "Peringatan!",
        text: "Isi Data Referensi!",
        type: "warning",
        confirmButtonText: "Ok"
        });
        //die;
    }else{
        $.ajax({
            type:"POST",
            url:siteurl+"customer/add_referensi",
            data:"referensi="+referensi+"&keterangan="+keterangan,
            success:function(html){
                $('#add_referensi').modal('hide');
                $('#form_reff')[0].reset(); // reset form on modals
                get_reff();
            }
        });
    }

    }

    function get_reff(){
        $.ajax({
            type:"GET",
            url:siteurl+"customer/get_reff",
            success:function(html){
                $("#referensi").html(html);
            }
        });
    }

    function get_kota(){
        var provinsi=$("#provinsi").val();
        $.ajax({
            type:"GET",
            url:siteurl+"customer/get_kota",
            data:"provinsi="+provinsi,
            success:function(html){
               $("#kota").html(html);
            }
        });
    }

    //Biodata
    $('#frm_biodata').on('submit', function(e){
        e.preventDefault();
        var formdata = $("#frm_biodata").serialize();
        $.ajax({
            url: siteurl+"customer/save_customer_ajax",
            dataType : "json",
            type: 'POST',
            data: formdata,
            //alert(msg);
            success: function(msg){
                if(msg['save']=='1'){
                    var customer =msg['customer'];
                    swal({
                      title: "Sukses!",
                      text: "Data Berhasil Disimpan, Lanjutkan pengisian data Toko",
                      type: "success",
                      showCancelButton: true,
                      confirmButtonColor: "Blue",
                      confirmButtonText: "Ya, Lanjutkan",
                      cancelButtonText: "Tidak, Lain waktu saja",
                      closeOnConfirm: true,
                      closeOnCancel: true
                    },
                    function(isConfirm){
                      if (isConfirm) {
                        $('[href="#cust_pic"]').tab('show');
                        $('#customerx').val(customer);
                        get_idcust_pic(customer);
                        load_pic(customer);
                        ShowOtherButton();
                      } else {
                        window.location.reload();
                        cancel();
                      }
                    });
                } else {
                    swal({
                        title: "Gagal!",
                        text: "Data Gagal Di Simpan",
                        type: "error",
                        timer: 1500,
                        showConfirmButton: false
                    });
                };//alert(msg);
            },
            error: function(){
                swal({
                    title: "Gagal!",
                    text: "Ajax Data Gagal Di Proses",
                    type: "error",
                    timer: 1500,
                    showConfirmButton: false
                });
            }
        });
    });

    function get_idcust_pic(customer){
         $.ajax({
             dataType : "json",
             type: 'POST',
             url:siteurl+"customer/get_idcust_pic",
             data:"customer="+customer,
             success:function(msg){
                 var id_pic =msg['id_pic'];
                 $("#id_pic").val(id_pic);
             }
         })
    }

    function get_emailpic(){
    var pic = $('#pic').val();
    if(pic != ""){
        $.ajax({
            type:"POST",
            url:siteurl+"customer/get_emailpic",
            data:{"pic":pic},
            success:function(result){
                var data = JSON.parse(result);
                $("#email").val(data.email_pic);
                $('#hp_pic').val(data.hp);
            }
        })
    }
    }
    
    //Toko
    function get_idtoko(customer){
     $.ajax({
         dataType : "json",
         type: 'POST',
         url:siteurl+"customer/get_idtoko",
         data:"customer="+customer,
         success:function(msg){
             var id_toko =msg['id_toko'];
             $("#id_toko").val(id_toko);
         }
     })
    }    

    $('#frm_toko').on('submit', function(e){
        e.preventDefault();
        var formdata = $("#frm_toko").serialize();
        $.ajax({
            url: siteurl+"customer/save_toko_ajax",
            dataType : "json",
            type: 'POST',
            data: formdata,
            success: function(msg){
                if(msg['save']=='1'){
                    var customer =msg['customer'];
                    swal({
                      title: "Sukses!",
                      text: "Data Berhasil Disimpan, Lanjutkan pengisian data Sistem Penagihan",
                      type: "success",
                      showCancelButton: true,
                      confirmButtonColor: "Blue",
                      confirmButtonText: "Ya, Lanjutkan",
                      cancelButtonText: "Tidak, Lain waktu saja",
                      closeOnConfirm: true,
                      closeOnCancel: true
                    },
                    function(isConfirm){
                      if (isConfirm) {
                        $('[href="#pic_toko"]').tab('show');
                        load_id_toko(customer);
                        get_idtoko(customer);
                        ShowOtherButton();
                        $("#frm_toko")[0].reset();
                      } else {
                        load_toko_temp(customer);  
                        $('#id_customer').val(customer);
                        get_idtoko(customer);   
                        $("#frm_toko")[0].reset();
                      }
                    });
                } else {
                    swal({
                        title: "Gagal!",
                        text: "Data Gagal Di Simpan",
                        type: "error",
                        timer: 1500,
                        showConfirmButton: false
                    });
                };//alert(msg);
            },
            error: function(){
                swal({
                    title: "Gagal!",
                    text: "Ajax Data Gagal Di Proses",
                    type: "error",
                    timer: 1500,
                    showConfirmButton: false
                });
            }
        });
    });

    //PIC
    $('#frm_pic').on('submit', function(e){
        e.preventDefault();
        var formdata = $("#frm_pic").serialize();
        $.ajax({
            url: siteurl+"customer/save_pic",
            dataType : "json",
            type: 'POST',
            data: formdata,
            success: function(msg){
                if(msg['save']=='1'){
                    var customer =msg['customer'];
                    swal({
                      title: "Sukses!",
                      text: "Data Berhasil Disimpan, Lanjutkan pengisian data PIC",
                      type: "success",
                      showCancelButton: true,
                      confirmButtonColor: "Blue",
                      confirmButtonText: "Ya, Lanjutkan",
                      cancelButtonText: "Tidak, Lain waktu saja",
                      closeOnConfirm: true,
                      closeOnCancel: true
                    },
                    function(isConfirm){
                      if (isConfirm) {
                        $('[href="#toko"]').tab('show');
                        $('#customer').val(customer);                        
                        load_foto(customer);
                        load_pic_toko(customer);
                        ShowOtherButton();
                        load_toko_temp(customer);
                        $("#frm_pic")[0].reset();
                      } else {
                        load_pic(customer);
                        $('#id_customer').val(customer);
                        get_idcust_pic(customer);
                        $("#frm_pic")[0].reset();
                      }
                    });
                } else {
                    swal({
                        title: "Gagal!",
                        text: "Data Gagal Di Simpan",
                        type: "error",
                        timer: 1500,
                        showConfirmButton: false
                    });
                };//alert(msg);
            },
            error: function(){
                swal({
                    title: "Gagal!",
                    text: "Ajax Data Gagal Di Proses",
                    type: "error",
                    timer: 1500,
                    showConfirmButton: false
                });
            }
        });
    });
    
    //FOTO CUST
    function add_foto(){
    var foto        =   $('#foto').val();
    var id_customer =   $('#id_customer').val();
    
    $('#frm_foto').ajaxForm({
     url:siteurl+"customer/add_datafoto",
     dataType : "json",
     type: "post",
     data:{"foto":foto,"id_customer":id_customer},
     success:function(msg){
        var pesan = msg['save'];
        var gambar = msg['gambar'];
        if(msg['save']=='1'){    
            swal({
                title: "SUKSES!",
                text: "Sukses Upload Foto Customer",
                type: "success",
                timer: 1500,
                showConfirmButton: false
                });

            load_foto(id_customer);
            $('#filelama').val(gambar);
                //nextDataUrgen();
        }else{
            swal({
                title: "Gagal!",
                text: pesan,
                type: "error",
                //timer: 1500,
                showConfirmButton: true
            });
        };//alert(msg); 
    },
        error: function(){            
            swal({
                title: "Gagal!",
                text: "Gagal Eksekusi Ajax",
                type: "error",
                timer: 1500,
                showConfirmButton: false
            });
        }
    });     

    }    

    //FOTO TOKO
    function add_foto_toko(){
    var foto_toko       =   $('#foto_toko').val();
    var id_toko_foto    =   $('#id_toko_foto').val();
    var filelama_toko   =   $('#filelama_toko').val();
    
    $('#frm_foto_toko').ajaxForm({
     url:siteurl+"customer/add_datafoto_toko",
     dataType : "json",
     type: "post",
     data:{"foto_toko":foto_toko,"id_toko_foto":id_toko_foto,"filelama_toko":filelama_toko},
     success:function(msg){
        var pesan = msg['save'];
        var gambar = msg['gambar'];
        var id = $('#id_customer').val();
        if(msg['save']=='1'){    
            swal({
                title: "SUKSES!",
                text: "Sukses Upload Foto Toko",
                type: "success",
                timer: 1500,
                showConfirmButton: false
                });

            $('[href="#toko"]').tab('show');
            load_toko_temp(id);
        }else{
            swal({
                title: "Gagal!",
                text: pesan,
                type: "error",
                //timer: 1500,
                showConfirmButton: true
            });
        };//alert(msg); 
    },
        error: function(){            
            swal({
                title: "Gagal!",
                text: "Gagal Eksekusi Ajax",
                type: "error",
                timer: 1500,
                showConfirmButton: false
            });
        }
    });     

    }    

    function cancel(){
        $(".box").show();
        $("#form-area").hide();
        //window.location.reload();
        reload_table();
    }

    function load_toko_temp(id_customer){
    $.ajax({
        type:"GET",
        url:siteurl+"customer/load_toko",
        data:"id_customer="+id_customer,
        success:function(html){
            $("#list_toko").html(html);
        }
    })
    }

    function load_pic(id_customer){
    $.ajax({
        type:"GET",
        url:siteurl+"customer/load_pic",
        data:"id_customer="+id_customer,
        success:function(html){
            $("#list_pic").html(html);
        }
    })
    }
    
    function load_foto(id_customer){
    $.ajax({
        type:"GET",
        url:siteurl+"customer/load_foto",
        data:"id_customer="+id_customer,
        success:function(html){
            $("#list_foto").html(html);
        }
    })
    }

    function load_foto_toko(id_toko){
    $.ajax({
        type:"GET",
        url:siteurl+"customer/load_foto_toko",
        data:"id_toko="+id_toko,
        success:function(html){
            $("#list_toko").html(html);
        }
    })
    }

    function ShowOtherButton()
    {
        //after success saving then activate sumbit button on each tab
        $("#btntoko").show();
        $("#btnpngh").show();
        $("#btnpngh").show();
        $("#btnpmbyr").show();
        $("#btnpic").show();
        $("#btnfoto").show();
    }

    function HideOtherButton()
    {
        //after success saving then activate sumbit button on each tab
        $("#btntoko").hide();
        $("#btnpngh").hide();
        $("#btnpngh").hide();
        $("#btnpmbyr").hide();
        $("#btnpic").hide();
        $("#btnfoto").hide();
    }

    //Delete Toko
    function hapus_toko(id){
        //alert(id);
        swal({
          title: "Anda Yakin?",
          text: "Data Toko Akan Terhapus secara Permanen!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Ya, delete!",
          cancelButtonText: "Tidak!",
          closeOnConfirm: false,
          closeOnCancel: true
        },
        function(isConfirm){
          if (isConfirm) {
            $.ajax({
                    url: siteurl+'customer/hapus_toko/'+id,
                    dataType : "json",
                    type: 'POST',
                    success: function(msg){
                        if(msg['delete']=='1'){
                            $("#dataku"+id).hide(2000);
                            //swal("Terhapus!", "Data berhasil dihapus.", "success");
                            swal({
                              title: "Terhapus!",
                              text: "Data berhasil dihapus",
                              type: "success",
                              timer: 1500,
                              showConfirmButton: false
                            });
                        } else {
                            swal({
                              title: "Gagal!",
                              text: "Data gagal dihapus",
                              type: "error",
                              timer: 1500,
                              showConfirmButton: false
                            });
                        };
                    },
                    error: function(){
                        swal({
                          title: "Gagal!",
                          text: "Gagal Eksekusi Ajax",
                          type: "error",
                          timer: 1500,
                          showConfirmButton: false
                        });
                    }
                });
          } else {
            //cancel();
          }
        });
    }

    function hapus_pic(id){
        //alert(id);
        swal({
          title: "Anda Yakin?",
          text: "Data Toko Akan Terhapus secara Permanen!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Ya, delete!",
          cancelButtonText: "Tidak!",
          closeOnConfirm: false,
          closeOnCancel: true
        },
        function(isConfirm){
          if (isConfirm) {
            $.ajax({
                    url: siteurl+'customer/hapus_pic/'+id,
                    dataType : "json",
                    type: 'POST',
                    success: function(msg){
                        if(msg['delete']=='1'){
                            $("#dataku"+id).hide(2000);
                            //swal("Terhapus!", "Data berhasil dihapus.", "success");
                            swal({
                              title: "Terhapus!",
                              text: "Data berhasil dihapus",
                              type: "success",
                              timer: 1500,
                              showConfirmButton: false
                            });
                        } else {
                            swal({
                              title: "Gagal!",
                              text: "Data gagal dihapus",
                              type: "error",
                              timer: 1500,
                              showConfirmButton: false
                            });
                        };
                    },
                    error: function(){
                        swal({
                          title: "Gagal!",
                          text: "Gagal Eksekusi Ajax",
                          type: "error",
                          timer: 1500,
                          showConfirmButton: false
                        });
                    }
                });
          } else {
            //cancel();
          }
        });
    } 
</script>

