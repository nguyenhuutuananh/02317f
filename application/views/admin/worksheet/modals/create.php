
    <div class="panel-body">
            <?php echo form_open_multipart($this->uri->uri_string(),array('id'=>'form-create-worksheet','autocomplete'=>'off')); ?>
            <?php
                $options = array(
                    array(
                        'id' => 1,
                        'name' => 'Tính theo ngày',
                    ),
                    array(
                        'id' => 2,
                        'name' => 'Tính theo buổi',
                    ),
                    array(
                        'id' => 3,
                        'name' => 'Tính theo giờ',
                    ),
                );
                echo render_select('jobType', $options, array('id', 'name'), 'Làm việc tính theo', '', array(), array(), '', '', false);
            ?>

            <?php
                echo render_select('userid[]', $staff_members, array('staffid', 'firstname', 'lastname'), 'Nhân viên', '', array('multiple' => 'multiple'), array(), '', '', false);
            ?>
            
            <div class="form-group">
                <label for="workingHours" class="control-label ">Ngày làm việc</label>
                <table class="table">
                    <thead></thead>
                    <tbody style="width: 600px;" id="J_workSheet">
                    </tbody>
                </table>
                <input type="hidden" name="workingDays" id="workingDays">
                <input type="hidden" name="workingHours" id="workingHours">
            </div>
            <?php
                echo render_date_input('dateStartWork', 'Ngày bắt đầu làm việc', date('Y-m-d'));
            ?>
            <?php
                echo render_textarea('note', 'Ghi chú');
            ?>
            <?php echo form_close(); ?>
    </div>
