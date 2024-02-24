<form action="#" method="POST" id="form_update_loading" enctype="multipart/form-data">
    <div class="table-responsive">
        <input type="hidden" name="id_dt_spkmarketing" value='<?=$id_dt_spkmarketing;?>'>
        <input type="hidden" name="delivery" value='<?=$delivery;?>'>
        <input type="hidden" name="id_spkmarketing" value='<?=$id_spkmarketing;?>'>
        <table class="table table-sm table-bordered table-striped" width='100%'>
            <thead>
                <tr>
                    <th class="text-center" width='3%'>#</th>
                    <th class="text-center" >No Alloy</th>
                    <th class="text-center" width='10%'>Berat</th>
                    <th class="text-center" width='20%'>Old Date</th>
                    <th class="text-center" width='20%'>New Date</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $nomor = 0;
                $SUM = 0;
                foreach($get_data AS $val => $valx){
                    $nomor++;
                    $SUM += $valx['qty_produk'];

                    $get_id2 = $this->db->select('id')->get_where('dt_spkmarketing', array('id_dt_spkmarketing'=>$valx['id_dt_spkmarketing'],'id_material'=>$valx['id_material']))->result();
                    echo "<tr>";
                        echo "<td class='align-middle' align='center'>".$nomor."</td>";
                        echo "<td class='align-middle'>".$valx['no_alloy']."</td>";
                        echo "<td class='align-middle' align='right'>".number_format($valx['qty_produk'],2)."</td>";
                        echo "<td class='align-middle' align='right'>".date('d-M-Y', strtotime($valx['delivery']))."</td>";
                        echo "<td class='align-middle' align='right'>
                                <input type='hidden' name='detail[".$nomor."][id]' class='form-control input-sm' value='".$valx['id']."'>
                                <input type='hidden' name='detail[".$nomor."][id2]' class='form-control input-sm' value='".$get_id2[0]->id."'>
                                <input type='text' id='new_date_".$nomor."' name='detail[".$nomor."][new_date]' class='form-control input-sm text-center datepicker' readonly>
                                </td>";
                    echo "</tr>";
                }
                echo "<tr>";
                    echo "<td align='right' colspan='2'></td>";
                    echo "<td align='right'><b>".number_format($SUM,2)."</b></td>";
                    echo "<td align='right'></td>";
                    echo "<td align='right'></td>";
                echo "</tr>";
            ?>
            </tbody>
        </table>
    </div>
</form>
<?php
    echo form_button(array('type'=>'button','class'=>'btn btn-md btn-primary','value'=>'save','content'=>'Save','id'=>'update_loading'));
?>

<style>
    .datepicker{
        cursor: pointer;
    }
</style>

<script>
	swal.close();

    $(document).ready(function(){
        $('.datepicker').datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth:true,
            changeYear:true,
            minDate: 0,
            showButtonPanel: true,
            closeText: 'Clear',
            onClose: function (dateText, inst) {
                if ($(window.event.srcElement).hasClass('ui-datepicker-close')) {
                    document.getElementById(this.id).value = '';
                }
            }
        });
    });
</script>