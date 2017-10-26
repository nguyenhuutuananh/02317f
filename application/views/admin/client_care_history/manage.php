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
                        <div class="row">
                            <div class="col-md-12">
                                <div class="_buttons">
                                    <a class="btn btn-info mright5 test pull-left display-block" id="btnNewAgency" onclick="clear_data()" >Thêm môi giới</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel_s">
                    <div class="panel-body">
                    <?php
                        $table_data = array(
                            'STT',
                            'KHÁCH HÀNG',
                            'MỨC ĐỘ ƯU TIÊN (5 -> 1)',
                            'NGÀY',
                            'TÌNH HÌNH KHÁCH HÀNG',
                            'HƯỚNG GIẢI QUYẾT',
                            _l('actions'),
                        );
                        render_datatable($table_data,'care-history');
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
const careHistoryTable =  initDataTable('.table-care-history', window.location.href, [], [], [], [0, 'DESC']);
$(function() {
    function createInput(trItem) {
        let dateInput = $(`
        <div class="input-group date">
            <input type="text" id="dateMeeting" name="dateMeeting" class="form-control datepicker" value="<?=_l(Date())?>">
            <div class="input-group-addon">
                <i class="fa fa-calendar calendar-icon"></i>
            </div>
        </div>
        `);
        
        let opt = {
            format: date_format,
            timepicker: false,
            scrollInput: false,
            lazyInit: true,
            dayOfWeekStart: calendar_first_day,
        };
        dateInput.find('.datepicker').datetimepicker(opt);
        let clienStatus = $(`
        <textarea name="status" id="status" />`);
        let clienSolutions = $(`
        <textarea name="solutions" id="solutions" />`);

        $(trItem).find('td:nth-child(4)').html(dateInput);
        $(trItem).find('td:nth-child(5)').html(clienStatus);
        $(trItem).find('td:nth-child(6)').html(clienSolutions);
    }
    $(document).on('click', '.btn-edit', function(e) {
        e.preventDefault();
        if($(this).attr('data-status') == 1) {
            // Save
            $(this).button('reset');
        }
        else {
            // make input for save
            $(this).attr('data-status', 1);
            createInput($(this).parents('tr'));
            $(this).button('reset'); 
        }
        
    });
});
</script>