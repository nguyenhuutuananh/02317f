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
                                // _l('actions'),
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

$(function() {
    
    $('#btnNewAgency').on('click', function() {
        formAddValidator.resetForm();
        $('#add_agency').modal('show');
        
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
    },send_data_form);
    
});

</script>
</body>
</html>