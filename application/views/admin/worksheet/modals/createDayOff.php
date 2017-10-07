<div id="contentModalCreateDayOff" class="panel-body">
        <?php echo form_open_multipart($this->uri->uri_string(),array('id'=>'form-create-worksheet','autocomplete'=>'off')); ?>
        <?php
            echo render_select('userid', $staff_members, array('staffid', 'firstname', 'lastname'), 'Nhân viên');
        ?>
        <?php
            $options = array(
                array(
                    'id' => 'ngay',
                    'value' => 'Ngày',
                ),
                array(
                    'id' => 'sang',
                    'value' => 'Buổi sáng',
                ),
                array(
                    'id' => 'trua',
                    'value' => 'Buổi trưa',
                ),
                array(
                    'id' => 'giờ',
                    'value' => 'Giờ',
                ),
            );
            echo render_select('dayOffType', $options, array('id', 'value'), 'Loại hình', '', array(), array(), '', '', false)
        ?>
        <?php echo form_close(); ?>
</div>
<script type="text/javascript">
    var staff_data = <?=json_encode($staff_members)?>;
    var Modal = $('#contentModalCreateDayOff');
    $(document).on('click', Modal.find('.content'), function() {
        
    });
    console.log(Modal.find('#userid'));
    $(document).on('change', Modal.find('#userid'), function() {
        let userElement = Modal.find('#userid');
        if(userElement.val()) {

        }
    });
</script>