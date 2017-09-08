<?php init_head(); ?>
<style>
    fieldset {
        padding: .35em .625em .75em!important;
        margin: 0 2px!important;
        border: 1px solid #19a9ea!important;
    }
    legend{
        font-size: 15px;
        font-weight:500;
        width: auto!important;
    }
</style>
<div id="wrapper" class="customer_profile">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="col-md-6"><h4 class="bold no-margin"><?php echo _l('Hướng cửa'); ?></h4>
                        </div>
                        <div class="col-md-6"> <h4 class="bold no-margin"><?php echo _l('Nội thất'); ?></h4>
                        </div>
                        <div class="tab-content">

                            <hr class="no-mbot no-border" />
                            <div class="col-md-6">

                                <div class="col-md-12 well">
                                    <div class="tab-content panel-body">
                                        <div class="_buttons" style="margin-bottom: 10px;">
                                            <a class="btn btn-info mright5" onclick="view_update_or_add(0)" data-toggle="modal" data-target="#view_door">Thêm Hướng cửa</a>
                                            <a class="btn btn-danger mright5 test" onclick="_delete_all('table-door-direction')" >Xóa Hướng cửa đã chọn</a>
                                            <div class="clearfix"></div>
                                        </div>
                                            <?php
                                            $table_data = array();
                                            $table_data = array(
                                                _l('Tên'),
                                            );
                                            array_unshift($table_data,'<span class="hide"> - </span><div class="checkbox mass_select_all_wrap"><input type="checkbox" id="mass_select_all" data-to-table="door-direction"><label></label></div>');

                                            render_datatable($table_data,'door-direction');
                                            ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">

                                <div class="col-md-12 well">
                                    <div class="tab-content panel-body">
                                        <div class="_buttons" style="margin-bottom: 10px;">
                                            <a class="btn btn-info mright5" onclick="view_update_or_add(1)" data-toggle="modal" data-target="#view_door">Thêm Nội thất</a>
                                            <a class="btn btn-danger mright5 test" onclick="_delete_all('table-furniture')" >Xóa Nội thất đã chọn</a>
                                            <div class="clearfix"></div>
                                        </div>
                                            <?php
                                            $table_data = array();
                                            $table_data = array(
                                                _l('Tên'),
                                            );
                                            array_unshift($table_data,'<span class="hide"> - </span><div class="checkbox mass_select_all_wrap"><input type="checkbox" id="mass_select_all" data-to-table="furniture"><label></label></div>');

                                            render_datatable($table_data,'furniture');
                                            ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">

                                <div class="col-md-12 well">
                                    <div class="tab-content panel-body">
                                        <div class="_buttons" style="margin-bottom: 10px;">
                                            <a class="btn btn-info mright5" onclick="view_update_or_add_status()" data-toggle="modal" data-target="#view_status">Thêm tình trạng</a>
                                            <a class="btn btn-danger mright5 test" onclick="_delete_all_status('table-status')" >Xóa tình trạng đã chọn</a>
                                            <div class="clearfix"></div>
                                        </div>
                                            <?php
                                            $table_data = array();
                                            $table_data = array(
                                                _l('Tên'),
                                            );
                                            array_unshift($table_data,'<span class="hide"> - </span><div class="checkbox mass_select_all_wrap"><input type="checkbox" id="mass_select_all" data-to-table="status"><label></label></div>');

                                            render_datatable($table_data,'status');
                                            ?>
                                    </div>
                                </div>
                            </div>
                            <div id="view_door" class="modal fade" role="dialog">
                                <div class="modal-dialog">

                                    <div class="modal-content">
                                        <?php echo form_open(admin_url().'categorys/add_update',array('class'=>'project-bds-form','autocomplete'=>'off')); ?>
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title"></h4>
                                            </div>
                                            <div class="modal-body">
                                               <?php echo render_input('name','Tên')?>
                                               <?php echo render_input('id','','','hidden')?>
                                               <?php echo render_input('type','','','hidden')?>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-info">Lưu</button>
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>
                                        <?php echo form_close(); ?>
                                    </div>

                                </div>
                            </div>
                            <div id="view_status" class="modal fade" role="dialog">
                                <div class="modal-dialog">

                                    <div class="modal-content">
                                        <?php echo form_open(admin_url().'categorys/add_update_status',array('class'=>'status-form','autocomplete'=>'off')); ?>
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title"></h4>
                                            </div>
                                            <div class="modal-body">
                                               <?php echo render_input('name','Tên')?>
                                               <?php echo render_input('id','','','hidden')?>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-info">Lưu</button>
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>
                                        <?php echo form_close(); ?>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
<script>
    function view_update_or_add(type)
    {
        $('#name').val('');
        $('#id').val('');
        $('#type').val(type);
        if(type==0)
        {
            $('.modal-title').html('THÊM HƯỚNG CỬA');
        }
        else{
            $('.modal-title').html('THÊM NỘI THẤT');
        }
    }
    function view_update_or_add_status()
    {
        $('.status-form #name').val('');
        $('.status-form #id').val('');
        $('.modal-title').html('THÊM TÌNH TRẠNG');
    }
    function get_data(id)
    {
        jQuery.ajax({
            type: "post",
            url: "<?=admin_url()?>categorys/getdata/"+id,
            dataType: "json",
            data: '',
            cache: false,
            success: function (data) {
                console.log(data);
                $('.project-bds-form #name').val(data.name);
                $('.project-bds-form #id').val(data.id);
                $('.project-bds-form #type').val(data.type);
                if(data.type==0)
                {
                    $('.project-bds-form .modal-title').html('SỦA ĐỔI TÊN HƯỚNG CỬA');
                }
                else{
                    $('.project-bds-form .modal-title').html('SỦA ĐỔI TÊN NỘI THẤT');
                }
            }
        });
    }
    function get_data_status(id)
    {
        jQuery.ajax({
            type: "post",
            url: "<?=admin_url()?>categorys/getdata_status/"+id,
            dataType: "json",
            data: '',
            cache: false,
            success: function (data) {
                console.log(data);
                $('.status-form #name').val(data.name);
                $('.status-form #id').val(data.id);
                $('.status-form .modal-title').html('SỦA ĐỔI TÊN TÌNH TRẠNG');
            }
        });
    }
    function _delete_all(table)
    {
        var ids = [];
        var num=0;
        var rows = $('.'+table+' tbody input[type=checkbox]');
        $.each(rows, function(i,v) {
            if ($(v).prop('checked') == true) {
                ids.push($(v).val());
                id=$(v).val();
            }
        });
        $.ajax({
            type: "POST",
            dataType: "json",
            url: '<?=admin_url()?>categorys/delete_mess',
            data: {array_id:ids},
            success: function (response) {
                if (response.success) {
                    alert_float('success', response.message);
                    $('.'+table).DataTable().ajax.reload();
                }
                else {
                    alert_float('danger', response.message);
                }
            }
        });
    };
    function _delete_all_status(table)
    {
        var ids = [];
        var num=0;
        var rows = $('.'+table+' tbody input[type=checkbox]');
        $.each(rows, function(i,v) {
            if ($(v).prop('checked') == true) {
                ids.push($(v).val());
                id=$(v).val();
            }
        });
        $.ajax({
            type: "POST",
            dataType: "json",
            url: '<?=admin_url()?>categorys/delete_mess_status',
            data: {array_id:ids},
            success: function (response) {
                if (response.success) {
                    alert_float('success', response.message);
                    $('.'+table).DataTable().ajax.reload();
                }
                else {
                    alert_float('danger', response.message);
                }
            }
        });
    };
    initDataTable('.table-door-direction','<?=admin_url()?>categorys/init_relation_door_direction/0' , [0], [0]);
    initDataTable('.table-furniture','<?=admin_url()?>categorys/init_relation_door_direction/1' , [0], [0]);
    initDataTable('.table-status','<?=admin_url()?>categorys/init_relation_status/1' , [0], [0]);
</script>
</body>
</html>
