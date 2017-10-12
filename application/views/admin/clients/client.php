<?php init_head(); ?>
<style>
    fieldset 
    {
        border: 1px solid #ddd !important;
        margin: 0;
        xmin-width: 0;
        padding: 10px;       
        position: relative;
        border-radius:4px;
        background-color:#f5f5f5;
        padding-left:10px!important;
    }   
    
    legend
    {
        font-size:14px;
        font-weight:bold;
        margin-bottom: 0px; 
        width: 35%; 
        border: 1px solid #ddd;
        border-radius: 4px; 
        padding: 5px 5px 5px 10px; 
        background-color: #ffffff;
    }
    div:not(.dataTables_scrollFoot)::-webkit-scrollbar { 
        display: none; 
    }

</style>
<div id="wrapper" class="customer_profile">
    <input type="hidden" name="userid" value="<?=(isset($client) ? $client->userid : '')?>">
    <div class="content">
        <div class="row">
            <?php 
            $mess = "";
            $font = "font-size: 10px";
            ?>
            <?php if ($type_client) {
                if ($type_client == 1)
                    {
                    $mess = "Đang quan tâm";
                    $font = "font-size: 10px";
                    $class = "info";
                }
                if ($type_client == 2)
                    {
                    $mess = "Đã giao dịch";
                    $class = "success";
                }
                if ($type_client == 3)
                    {
                    $mess = "Khách hàng Fail";
                    $font = "font-size: 9px";
                    $class = "danger";
                }

            }
            ?>

        <?php if (isset($client) && is_null($this->input->get('convert'))) { ?>
            
            <div class="col-md-3">
                <div class="panel_s">
               
                <div class="panel-body">
                    <?php if ($type_client) { ?>
                        <div class="ribbon <?= $class ?>">
                            <span style="<?= $font ?>"><?= $mess ?></span>
                        </div>
                    <?php 
                } ?>
                    <?php if (has_permission('customers', '', 'delete') || is_admin()) { ?>
                    <div class="btn-group pull-left mright10">
                    <!-- <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-left">
                        <?php if (is_admin()) { ?>
                        <li>
                        <a href="<?php echo admin_url('clients/login_as_client/' . $client->userid); ?>" target="_blank">
                            <i class="fa fa-share-square-o"></i> <?php echo _l('login_as_client'); ?>
                        </a>
                        </li>
                        <?php 
                    } ?>
                        <?php if (has_permission('customers', '', 'delete')) { ?>
                        <li>
                        <a href="<?php echo admin_url('clients/delete/' . $client->userid); ?>" class="text-danger delete-text _delete" data-toggle="tooltip" data-title="<?php echo _l('client_delete_tooltip'); ?>" data-placement="bottom"><i class="fa fa-remove"></i> <?php echo _l('delete'); ?>
                        </a>
                        </li>
                        <?php 
                    } ?>
                    </ul> -->
                    </div>
                    <?php 
                } ?>
                    <h4 class="customer-heading-profile bold"><?php echo $title; ?></h4>
                    <?php $this->load->view('admin/clients/tabs'); ?>
                </div>
                </div>
            </div>
            <?php 
        } ?>
            <div class="col-md-<?= (!isset($client) || !is_null($this->input->get('convert')) ? 12 : 9) ?>">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="tab-content">
                        <?php $this->load->view('admin/clients/groups/' . $group); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
<?php include_once (APPPATH . 'views/admin/clients/client_js.php'); ?>

<script>

    function get_project(id)
    {
        jQuery.ajax({
            type: "post",
            dataType:'json',
            url: "<?= admin_url() ?>clients/get_project/"+id.value,
            data: '',
            cache: false,
            success: function (data) {
                var option="";
                $.each(data, function( index, value ) {
                    option=option+'<option data-subtext="'+value.code+'" value="'+value.id+'">'+value.project_name+'</option>';
                });
                $(id).parents('.form-group').next().find('select').html(option).selectpicker('refresh');

            }
        });
    }
    function append_colum(buttonElement)
    {
        var time=$('.class_time').html();
        var re_num=$('input[name="num_bonus[]"]').length+1;
        let parentFieldSet = $(buttonElement).parents('fieldset');
        parentFieldSet.append('<div class="col-md-3"><fieldset class="fieldset review_bonus_'+re_num+'">'+
                                    '<legend class="legend">Đợt:'+re_num+'<a href="javacript:void(0)" class="text-danger _delete" onclick="remove_field('+re_num+')"><i class="fa fa fa-times"></i></a></legend>'+
                                        '<div class="form-group">' +
                                            '<label for="time_num" class="control-label label-time col-sm-4">Ngày thu đợt:'+re_num+'</label>' +
                                            '<div class="col-sm-8">'+
                                            '<div class="input-group date">' +
                                                '<input type="text"  name="time_bonus[]" class="form-control datepicker" value="">' +
                                                '<div class="input-group-addon">'+
                                                    '<i class="fa fa-calendar calendar-icon"></i>'+
                                                '</div>' +
                                            '</div>' +
                                            '</div>' +
                                        '</div>' +
                                        '<div class="form-group review_bonus_'+re_num+'">' +
                                            '<label for="date_movein" class="control-label col-sm-4 label-num">Đợt:'+re_num+'</label>' +
                                            '<div class="col-sm-8">'+
                                            '<input type="text"  name="num_bonus[]" class="form-control" value="">'+
                                            '</div>' +
                                        '</div>'+
                                '</fieldset></div>'
        );
        init_datepicker();

    }
    function remove_field(key)
    {

        $('.review_bonus_'+key).parent().remove();
        var re_num=$('input[name="num_bonus[]"]').length;
        var legend=$('.legend');
        var field=$('.fieldset');
        var lable_time=$('.label-time');
        var lable_num=$('.label-num');
//        var time_num=$('control-label').attr('for',)
        console.log(legend);
        for(var i=0;i<re_num;i++)
        {
            $(field[i]).prop('class','fieldset review_bonus_'+(i+1));
            $(legend[i]).html('Đợt '+(i+1)+'<a href="javacript:void(0)" class="text-danger _delete" onclick="remove_field('+(i+1)+')"><i class="fa fa fa-times"></i></a>');
            $(lable_time[i]).html('Ngày thu tiền đợt: '+(i+1));
            $(lable_num[i]).html('Đợt: '+(i+1));
        }
    }
    function get_district_client(id)
    {
        jQuery.ajax({
            type: "post",
            dataType:'json',
            url: "<?= admin_url() ?>clients/get_district/"+id.value,
            data: '',
            cache: false,
            success: function (data) {
                var option="";
                $.each(data, function( index, value ) {
                    option=option+'<option data-subtext="'+value.type+'" value="'+value.districtid+'">'+value.name+'</option>';
                });
                $(id).parents('.form-group').next().find('select').html(option).selectpicker('refresh');

            }
        });
    }
    $(document).on('keyup', '[name="items[0][price]"], #value, #realValue, input[name="num_bonus[]"]', (e) => {
        const current = $(e.currentTarget);
        var charCode = (e.which) ? e.which : event.keyCode
        
        // Remove grop seperate

        current.val( current.val().replace(/\D/g, '') );
        current.val(formatNumber(current.val()));
    });
    //format currency
    function formatNumber(nStr, decSeperate=".", groupSeperate=",") {
        nStr += '';
        x = nStr.split(decSeperate);
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + groupSeperate + '$2');
        }
        return x1 + x2;
    }
    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
    function view_init_department(id)
    {
        jQuery.ajax({
            type: "post",
            url:admin_url+"clients/getProduct/<?= (isset($client) ? $client->userid : '') ?>/"+id,
            data: '',
            cache: false,
            dataType: 'json',
            success: function (data) {
                if(data.success)
                {
                    let item = data.data;
                    console.log(item);
                    $('#viewProduct').modal('show');
                    $('#viewProduct .modal-body .col-sm-8').each((i, v) => {
                        
                        switch(i) {
                            case 0:
                                $(v).html("<p class='form-control-static'>"+item.cityName+"</p>");
                                break;
                            case 1:
                                $(v).html("<p class='form-control-static'>"+item.districtName+"</p>");
                                break;
                            case 2:
                                $(v).html("<p class='form-control-static'>"+item.menuBdsName+"</p>");
                                break;
                            case 3:
                                $(v).html("<p class='form-control-static'>"+item.project_name+"</p>");
                                break;
                            case 4:
                                $(v).html("<p class='form-control-static'>"+(item.type == 1 ? "Mua" : "Thuê")+"</p>");
                                break;
                            case 5:
                                $(v).html("<p class='form-control-static'>"+formatNumber(item.price)+"</p>");
                                break;
                            case 6:
                                $(v).html("<p class='form-control-static'>"+(item.type == 1 ? "Không" : (item.rentalPeriod + ' tháng'))+"</p>");
                                break;
                            case 7:
                                const d = new Date(item.dateStart);
                                $(v).html("<p class='form-control-static'>"+d.getFullYear()+'-'+(d.getMonth()+1)+'-'+d.getDate()+"</p>");
                                break;
                        }
                    });
                }
                else {
                    alert_float('danger', 'Lấy dữ liệu thất bại!');
                }
            }
        });
    }
    function new_product(){
        $('#newProduct').modal('show');
        jQuery('#id_type').prop('action', admin_url + 'clients/addProduct/<?= (isset($client) ? $client->userid : "") ?>');
    }
    
    $(() => {
        _validate_form($('.form-item'),{
            'items[0][city]': 'required',
            'items[0][district]': 'required',
            'items[0][menuBdsId]': 'required',
            'items[0][projectBdsId]': 'required',
            'items[0][type]': 'required',
            'items[0][price]': 'required',
            'items[0][dateStart]': 'required',
        },send_data_form);
    });
    function send_data_form(form) {
        var data = $(form).serialize();
        var url = form.action;
        $.post(url, data).done(function(response) {
            response = JSON.parse(response);
            if(response.success == true){
                alert_float('success',response.message);
            }
            else {
                alert_float('danger',response.message);
            }
            $(form)[0].reset();
            
            $('.selectpicker').val('');
            $('.selectpicker').change();
            $('.selectpicker').selectpicker('refresh');

            $(form).find('.datepicker').val('<?= date('Y-m-d') ?>');
            $('.table-client-items').DataTable().ajax.reload();
            $('#newProduct').modal('hide');
        });
        return false;
    }
    if($('.table-client-items').length) {
        initDataTable('.table-client-items', window.location.href, [0], [0]);
    }
    
    initDataTable('.table-call-logs','<?= admin_url() ?>newview/init_relation_logs/<?php echo $id_bds; ?>' , [0], [0]);
    initDataTable('.table-master_bds','<?= admin_url() ?>newview/init_relation_master_bds/<?php echo $id_bds; ?>' , [0], [0]);
    initDataTable('.table-people-take','<?= admin_url() ?>newview/init_relation_take/<?php echo $id_bds; ?>' , [3], [3]);
</script>
<?php include_once (APPPATH . 'views/admin/newview/script_project.php'); ?>
<?php if (isset($client)) { ?>
<script>
// init_rel_tasks_table(<?php echo $client->userid; ?>,'customer');
 <?php if ($group == 'tasks') { ?>
     initDataTable('.table-rel-tasks','<?= admin_url() ?>tasks/init_relation_tasks/<?= $client->userid ?>/customer' , [0], [3]);
<?php 
} ?>
// Billing period
<?php
if ($group == 'billingperiod') {
    ?>
initDataTable('.table-billing-period','<?= admin_url() ?>clients/getBillingPeriod/<?= $client->userid ?>/<?= $this->input->get('id') ?>' , [0], [3], {}, [1, 'ASC']);
function new_period(){
    if(typeof $('#formAddPeriod').validate != 'undefined') {
        $('#formAddPeriod').validate().resetForm();
    }
    $('#addPeriod').modal('show');
    jQuery('#formAddPeriod').prop('action', admin_url + 'clients/addPeriod/<?= (isset($client) ? $client->userid : "") ?>/<?= $this->input->get('id') ?>');
}
$(document).ready(() => {    
    _validate_form('#formAddPeriod', {
        'datePay': 'required',
        'value': 'required',
    }, send_data_period_form);
    _validate_form('#formAddPay', {
        'datePay': 'required',
        'realValue': 'required',
        'idPaymentMethod': 'required',
    }, send_data_period_form);
    
});
function send_data_period_form(form) {
    var data = $(form).serialize();
    var url = form.action;
    $.post(url, data).done(function(response) {
        response = JSON.parse(response);
        if(response.success == true){
            alert_float('success',response.message);
            $('#addPeriod').modal('hide');
            $('#addPayment').modal('hide');
            $('.table-billing-period').DataTable().ajax.reload();

            $(form)[0].reset();
            
            $(form).find('input').val('');
            $(form).find('select').val('');
            $(form).find('select').selectpicker('refresh');
        }
        else {
            alert_float('danger',response.message);
        }
        
    }).fail(function() {
        alert_float('danger', 'Lỗi nhận dữ liệu!');
    });
    return false;
}
// Payment
function new_payment(stt, paymentId){
    if(typeof $('#formAddPay').validate != 'undefined') {
        $('#formAddPay').validate().resetForm();
    }

    $('#addPayment').modal('show');
    $('#addPayment').find('.edit-title').html('Thanh toán đợt '+stt);
    jQuery('#formAddPay').prop('action', admin_url + 'clients/addPayment/<?= (isset($client) ? $client->userid : "") ?>/<?= $this->input->get('id') ?>/'+paymentId);
}
function view_payment(stt, paymentId) {
    const htmlTableDetail = `
    <?php
    $table_data = array(
        _l('STT'),
        _l('Ngày thanh toán'),
        _l('Số tiền'),
        _l('Thanh toán bằng'),
        _l('actions'),
    );
    render_datatable($table_data, 'billing-payment');
    ?>
    `;
    $('#viewPaymentList').find('.edit-title').html('Danh sách thanh toán đợt '+stt);
    $('#viewPaymentList').find('.modal-body').html(htmlTableDetail);
    $('#viewPaymentList').modal('show');
    initDataTable('.table-billing-payment','<?= admin_url() ?>clients/getPayment/<?= $this->input->get('id') ?>/' + paymentId , [0], [3], {}, [1, 'DESC']);
}
$('body').on('click', '.delete-reminder-client', function() {
    var r = confirm(confirm_action_prompt);
    const thisButton = $(this);
    if (r == false) {
        return false;
    } else {
        $.get($(this).attr('href'), function(response) {
            alert_float(response.alert_type, response.message);
            if(response.alert_type != 'danger') {
                $('.table-billing-payment').DataTable().ajax.reload();
                $('.table-billing-period').DataTable().ajax.reload();
            }
        }, 'json');
    }
    return false;
});
        <?php

    }
    ?>
<?php 
}
if ($group == 'paymenthistory') {
    ?>
initDataTable('.table-payment-history','<?= admin_url() ?>clients/paymentHistory/<?= $client->userid ?>' , [0], [3], {}, [2, 'DESC']);
<?php

}
?>

</script>


</body>
</html>
