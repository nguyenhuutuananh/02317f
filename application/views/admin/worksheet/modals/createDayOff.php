<div id="contentModalCreateDayOff" class="panel-body">
        <?php echo form_open_multipart($this->uri->uri_string(),array('id'=>'form-create-worksheet','autocomplete'=>'off')); ?>
        <?php
            echo render_select('userid', $staff_members, array('staffid', 'firstname', 'lastname'), 'Nhân viên');
        ?>
        <?php
            echo render_date_input('dateWorkOff', 'Ngày xin nghỉ', strftime(get_current_date_format()));
        ?>

        <?php
            $options = array(
                array(
                    'id' => 'ngay',
                    'value' => 'Ngày',
                ),
                array(
                    'id' => 'buoi',
                    'value' => 'Buổi',
                ),
                array(
                    'id' => 'gio',
                    'value' => 'Giờ',
                ),
            );
            echo render_select('dayOffType', $options, array('id', 'value'), 'Loại hình', '', array(), array(), '', '', false)
        ?>

        <?php
            $options = array(
                array(
                    'id' => 'sang',
                    'value' => 'Sáng',
                ),
                array(
                    'id' => 'chieu',
                    'value' => 'Chiều',
                ),
            );
            echo render_select('session', $options, array('id', 'value'), 'Buổi', '', array(), array('style' => 'display:none;'), '', '')
        ?>

        <?php
            echo render_input('hoursOff', 'Số giờ nghỉ', '', 'text', array(), array('style' => 'display: none'));
        ?>
        <?php
            echo render_textarea('note', 'Ghi chú');
        ?>
        <?php echo form_close(); ?>
</div>
<script type="text/javascript">
    // var staff_data = <?/*=json_encode($staff_members)*/?>;
    var Modal = $('#contentModalCreateDayOff');
    _validate_form(Modal.find('form'), {
        'userid': 'required',
        'dateWorkOff': 'required',
        'dayOffType': 'required',
    }, send_data_form_dayOff);
        
    function send_data_form_dayOff(form) {
        // custom validation
        let sessionInput = $(Modal).find('#session');
        let hoursInput = $(Modal).find('#hoursOff');

        let dayOffType = Modal.find('#dayOffType');
        if(dayOffType.val() == 'ngay') {
            sessionInput.val('');
            hoursInput.val('');
        }
        else if(dayOffType.val() == 'buoi') {
            hoursInput.val('');
            if(sessionInput.val() || sessionInput.val() == '') {
                alert_float('danger', 'Buổi không được rỗng');
                sessionInput.focus();
                return;
            }
        }
        else if(dayOffType.val() == 'gio') {
            console.log(sessionInput.val());
            console.log(hoursInput.val());
            if(sessionInput.val() == '') {
                alert_float('danger', 'Buổi không được rỗng');
                sessionInput.focus();
                return;
            }
            if(hoursInput.val() == '') {
                alert_float('danger', 'Giờ không được rỗng');
                return;
            }
        }
        // end custom validation

        var data = $(form).serialize();
        var url = form.action;
        $.post(url, data).done(function(response) {
            response = JSON.parse(response);
            if(response.success){
                alert_float('success',response.message);
                location.reload();
            }
            else {
                alert_float('danger',response.message);
            }
        });
        return false;
    }
    $(document).on('click', Modal.find('.content'), function() {
        
    });
    $(Modal).on('change', '#dayOffType', function() {
        let sessionDiv = $(Modal).find('#session').parents('.form-group');
        let hoursDiv = $(Modal).find('#hoursOff').parents('.form-group');
        if($(this).val() == 'ngay') {
            sessionDiv.hide();
            hoursDiv.hide();
        }
        else if($(this).val() == 'buoi') {
            sessionDiv.show();
            hoursDiv.hide();
        }
        else if($(this).val() == 'gio') {
            sessionDiv.show();
            hoursDiv.show();
        }
    });

    $(document).on('change', Modal.find('#userid'), function() {
        let userElement = Modal.find('#userid');
        if(userElement.val()) {

        }
    });
</script>