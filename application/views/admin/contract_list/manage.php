<?php init_head(); ?>
<style type="text/css"> 

</style>
<link href="<?=base_url()?>assets/css/fixedColumns.dataTables.min.css" rel="stylesheet">
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                
                <div class="panel_s">
                    <div class="panel-body">
                        <h3><?=$title?></h3>
                        <hr class="no-border"/>
                        <?php
                            $table_data = array(
                                'STT',

                                _l('client_contract_startdate'),

                                _l('client_contract_expirydate'),

                                _l('Loại(thuê/mua)'),

                                _l('client_contract_code'),
                                
                                _l('Tên hđ'),

                                _l('Mã căn hộ'),

                                _l('Tên Khách hàng'),
                                
                                _l('NV phụ trách KH'),
                                
                                _l('Hợp tác môi giới hay trợ lý'),

                                _l('Tên MG hay trợ lý'),

                                _l('Hoa hồng(trên hợp đồng)'),

                                _l('Hoa hồng cho MG hoặc trợ lý'),

                                _l('Chi phí khác'),

                                _l('Nội dung chi phí khác'),

                                _l('Hoa hồng thực nhận'),
                                
                                _l('actions'),
                            );
                            render_datatable($table_data,'contracts');
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="add_agency" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <?php echo form_open(admin_url().'agency/get_and_update',array('id'=>'form_agency')); ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Thêm môi giới</h4>
            </div>
            <div class="modal-body">
                <div class="clearfix"></div>
                <div class="col-md-12">
                    <?php echo render_input('id','','','hidden'); ?>
                    <?php echo render_input('agencyName','Họ Tên','','text'); ?>
                    <?php echo render_input('agencyPhone','Số điện thoại','','text'); ?>
                    <?php echo render_input('agencyEmail','Email','','text'); ?>
                    <?php echo render_input('agencyAddress','Địa chỉ','','text'); ?>
                    
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="modal-footer">
                <button type="submit" id="btn_save_agency" class="btn btn-info"><?php echo _l('Lưu'); ?></button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            <?php echo form_close(); ?>
        </div>

    </div>
</div>
<div class="modal fade lead-modal" id="viewBillingPeriod" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" style="width: 70%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close btn-close-single-modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    <span class="edit-title">Đợt thanh toán</span>
                </h4>
            </div>
            <div class="modal-body">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-close-single-modal"><?php echo _l('close'); ?></button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php init_tail(); ?>
<script src="<?=base_url()?>assets/js/dataTables.fixedColumns.min.js"></script>

<script type="text/javascript">
const agencyTable =  initDataTable('.table-contracts', window.location.href, [], [], [], [0, 'DESC']);
var formAddValidator;
function _validate_form_edited(form, form_rules, submithandler) {
    var f = $(form).validate({
        rules: form_rules,
        messages: {
            email: {
                remote: email_exists,
            },
        },
        ignore: [],
        submitHandler: function(form) {
            if (typeof(submithandler) !== 'undefined') {
                submithandler(form);
            } else {
                return true;
            }
        }
    });

    var custom_required_fields = $(form).find('[data-custom-field-required]');

    if (custom_required_fields.length > 0) {
        $.each(custom_required_fields, function() {
            $(this).rules("add", {
                required: true
            });
            var name = $(this).attr('name');
            var label = $(this).parents('.form-group').find('[for="' + name + '"]');
            if (label.length > 0) {
                if (label.find('.req').length == 0) {
                    label.prepend(' <small class="req text-danger">* </small>');
                }
            }
        });
    }

    $.each(form_rules, function(name, rule) {
        if ((rule == 'required' && !jQuery.isPlainObject(rule)) || (jQuery.isPlainObject(rule) && rule.hasOwnProperty('required'))) {
            var label = $(form).find('[for="' + name + '"]');
            if (label.length > 0) {
                if (label.find('.req').length == 0) {
                    label.prepend(' <small class="req text-danger">* </small>');
                }
            }
        }
    });

    return f;
}

function clear_data() {

}
function _edit(id) {
    $.ajax({
        type: "POST",
        dataType: "json",
        url: '<?=admin_url()?>agency/get_and_update/' + id,
        data: '',
        success: function (response) {
            if (response.success) {
                formAddValidator.resetForm();
                alert_float('success', response.message);
                $('#add_agency #id').val(response.data.id);
                $('#add_agency #agencyName').val(response.data.agencyName);
                $('#add_agency #agencyPhone').val(response.data.agencyPhone);
                $('#add_agency #agencyEmail').val(response.data.agencyEmail);
                $('#add_agency #agencyAddress').val(response.data.agencyAddress);
                                
                $('#add_agency').modal('show');
            }
            else {
                alert_float('danger', response.message);
            }
        }
    });
    return false;
}
function _delete(id)
{
    $.ajax({
        type: "POST",
        dataType: "json",
        url: '<?=admin_url()?>agency/delete/' + id,
        data: '',
        success: function (response) {
            if (response.success) {
                alert_float('success', response.message);
                $('.table-agencies').DataTable().ajax.reload();
            }
            else {
                alert_float('danger', response.message);
            }
        }
    });
    return false;
};
var customer_id;
$(function() {
    
    $('#btnNewAgency').on('click', function() {
        formAddValidator.resetForm();
        $('#add_agency').modal('show');
        
    });
    function send_data_agency_form(form) {
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
            $('.table-agencies').DataTable().ajax.reload();
            $('#add_agency').modal('hide');
        });
        return false;
    }
    formAddValidator = _validate_form_edited($('#form_agency'),{
        'agencyName': 'required',
        'agencyPhone': {
            required: true,
            number: true
        },
        'agencyEmail': {
            required: true,
            email: true
        },
        'agencyAddress': 'required',
    },send_data_agency_form);
    
    $(document).on('click', '.btn-billingperiod', function(e) {
        e.preventDefault();
        const buttonDetail = $(this);
        buttonDetail.button('loading');
        customer_id = buttonDetail.attr('data-idclient');
        $.get(admin_url + 'clients/modal_billingperiod/' + buttonDetail.attr('data-idclient') + '/' + $(this).attr('data-idproduct'), function(data) {
            $('#viewBillingPeriod .modal-body').html('');
            $('#viewBillingPeriod .modal-body').html(data);

            // init event
            const tableBill = initDataTable('.table-billing-period', `${admin_url}clients/getBillingPeriod/${buttonDetail.attr('data-idclient')}/${buttonDetail.attr('data-idproduct')}` , [0], [3], {}, [1, 'ASC']);
            init_selectpicker();
            init_datepicker();
            
            _validate_form('#formAddPeriod', {
                'datePay': 'required',
                'value': 'required',
            }, send_data_period_form);
            
            _validate_form('#formAddPay', {
                'datePay': 'required',
                'realValue': 'required',
                'idPaymentMethod': 'required',
            }, send_data_period_form);
            $('#viewBillingPeriod').attr('data-idproduct', buttonDetail.attr('data-idproduct'));
            // Show
            $('#viewBillingPeriod').modal('show');
            
            setTimeout(() => {
                buttonDetail.button('reset');
            }, 2000);
        }).fail(() => {
            setTimeout(() => {
                buttonDetail.button('reset');
            }, 2000);
        });

    });

    new_period = function() {
        if(typeof $('#formAddPeriod').validate != 'undefined') {
            $('#formAddPeriod').validate().resetForm();
        }
        $('#addPeriod').modal('show');
        jQuery('#formAddPeriod').prop('action', admin_url + 'clients/addPeriod/<?= (isset($client) ? $client->userid : "") ?>/' + $('#viewBillingPeriod').attr('data-idproduct'));
    }
    send_data_period_form = function(form) {
        var data = $(form).serialize();
        var url = form.action;
        
        let buttonSubmit = $(form).find('button[type="submit"]').button('loading');

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
            
            setTimeout(() => {
                buttonSubmit.button('reset');
            }, 2000);
        }).fail(function() {
            alert_float('danger', 'Lỗi nhận dữ liệu!');
            setTimeout(() => {
                buttonSubmit.button('reset');
            }, 2000);
        });
        return false;
    }
    // Items
    $(function() {
        _validate_form($('.form-item'),{
            'items[0][contractCode]': 'required',
            'items[0][contractStartDate]': 'required',
            'items[0][contractExpiryDate]': 'required',
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

            $(form).find('.datepicker').val('');
            $('.table-client-items').DataTable().ajax.reload();
            $('#newProduct').modal('hide');
        });
        return false;
    }
    // initDataTable('.table-client-items', admin_url + 'clients/clientItems/' + customer_id, [0], [0]);

    // Payment
    new_payment = function(stt, paymentId){
        if(typeof $('#formAddPay').validate != 'undefined') {
            $('#formAddPay').validate().resetForm();
            $('#formAddPay #datePay').val('');
            let buttonSubmit = $('#formAddPay').find('button[type="submit"]');
            setTimeout(() => {
                buttonSubmit.button('reset');
            }, 2000);
        }
        console.log(customer_id);
        $('#addPayment').modal('show');
        $('#addPayment').find('.edit-title').html('Thanh toán đợt '+stt);
        jQuery('#formAddPay').prop('action', admin_url + `clients/addPayment/${customer_id}/${$('#viewBillingPeriod').attr('data-idproduct')}/`+paymentId);
    }
    view_payment = function(stt, paymentId) {
        const htmlTableDetail = `
        <?php
        $table_data = array(
            _l('STT'),
            _l('Ngày thanh toán'),
            _l('Số tiền'),
            _l('Thanh toán bằng'),
            _l('Nhân viên nhận'),
            _l('actions'),
        );
        render_datatable($table_data, 'billing-payment');
        ?>
        `;
        $('#viewPaymentList').find('.edit-title').html('Danh sách thanh toán đợt '+stt);
        $('#viewPaymentList').find('.modal-body').html(htmlTableDetail);
        $('#viewPaymentList').modal('show');
        initDataTable('.table-billing-payment', admin_url + `clients/getPayment/${$('#viewBillingPeriod').attr('data-idproduct')}/` + paymentId , [0], [3], {}, [1, 'DESC']);
    }

    // paymenthistory
    initDataTable('.table-payment-history', admin_url + `clients/paymentHistory/${customer_id}` , [0], [3], {}, [2, 'DESC']);
    $(document).on('click', '.btn-close-single-modal', function(e) {
        // Bug !?
        $(this).parents('div.modal:first').modal('hide');
        $(this).parents('div.modal:first').removeClass('in');
        $(this).parents('div.modal:first').css('display', 'none');
        $(document).find('.modal-backdrop.fade.in:last').remove();
    });
    $(document).on('keyup', '[name="items[0][commissionPartner]"], [name="items[0][realPrice]"], [name="items[0][price]"], #value, #realValue', (e) => {
        const current = $(e.currentTarget);
        var charCode = (e.which) ? e.which : event.keyCode
        
        // Remove grop seperate

        current.val( current.val().replace(/\D/g, '') );
        current.val(formatNumber(current.val()));
    });
});

</script>
</body>
</html>