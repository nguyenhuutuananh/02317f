<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">

                        <?php echo form_open(admin_url('newview/add'),array('id'=>"insert_menu")); ?>
                        <div class="row">

                            <div class="col-md-3">
                                <button type="button" data-toggle="modal" data-target="#view_add" class="btn btn-info"><?php echo _l('thêm danh sách bds'); ?></button>
                            </div>

                        </div>

                        <?php echo form_close(); ?>
                        <div class="modal fade" id="view_add" role="dialog">
                            <div class="modal-dialog">

                                <!-- Modal content-->
                                <?php echo form_open(admin_url('field/field'),array('id'=>'form-field')); ?>
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Thêm trường bds</h4>
                                    </div>

                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <?php echo render_input('name','Tên trường'); ?>
                                                <div class="form-group">
                                                    <label for="custom_type">Kiểu</label>
                                                    <select name="type" id="type" class="selectpicker" data-width="100%" data-none-selected-text="Không có gì được chọn" tabindex="-98">
                                                        <option value=""></option>
                                                        <option value="input">Input</option>
<!--                                                        <option value="colorpicker">Color Picker</option>-->
<!--                                                        <option value="textarea">Textarea</option>-->
<!--                                                        <option value="date_picker">Date Picker</option>-->
<!--                                                        <option value="select">Select</option>-->
<!--                                                        <option value="checkbox">Checkbox</option>-->
<!--                                                        <option value="link">Hyperlink</option>-->
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="custom_type">Danh mục</label>
                                                    <select name="_table" id="_table" class="selectpicker" data-width="100%" data-none-selected-text="Không có gì được chọn" tabindex="-98">
                                                        <option value=""></option>
                                                        <option value="menu_bds">Danh sách loại bds</option>
                                                        <option value="projectmenu">Dạng bất động sản</option>
                                                    </select>
                                                </div>
                                                <?php echo render_textarea('options','Nội dung tùy chỉnh'); ?>
                                                <?php echo render_input('field_order','sắp xếp','','number'); ?>
                                                <?php echo render_input('id_field','ID báo danh','','text',''); ?>
                                                <div class="input-group">
                                                    <span class="input-group-addon">col-md-</span>
                                                    <input type="number" class="form-control" name="bs_column" id="bs_column" value="6">
                                                </div>
                                                <div class="checkbox checkbox-primary" id="required_wrap">
                                                    <input type="checkbox" name="required" id="required">
                                                    <label for="required">Trường không được rổng</label>
                                                </div>
                                                <div class="checkbox checkbox-primary" id="required_wrap">
                                                    <input type="checkbox" name="show_on_table" id="show_on_table">
                                                    <label for="show_on_table">Hiện trên bảng</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="submit"  class="btn btn-info"><?php echo _l('submit'); ?></button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12" id="small-table">
                        <div class="panel_s">
                            <div class="panel-body">
                                <div class="clearfix"></div>
                                <?php
                                $table_data = array();
                                $_table_data = array(
                                    'Tên trường',
                                    'Kiểu',
                                    'ID báo danh',
                                );
                                foreach($_table_data as $_t){
                                    array_push($table_data,$_t);
                                }
                                array_unshift($table_data,'<span class="hide"> - </span><div class="checkbox mass_select_all_wrap"><input type="checkbox" id="mass_select_all" data-to-table="clients"><label></label></div>');
                                $_op = _l('options');

                                array_push($table_data, $_op);
                                render_datatable($table_data,'clients');
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7 small-table-right-col">
                        <div id="expense" class="hide">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
<script>
    $(function() {
        _validate_form($('#form-field'), {
            name: 'required',
            type: 'required',
            bs_column: 'required',
            _table: 'required',
            field_order: 'required',
            id_field: 'required',
        }, managa_upload);
    });
    function managa_upload(form) {
        var data = $(form).serialize();
        console.log(data);
        var url = form.action;
        $.post(url, data).done(function(response) {
            console.log(response);
            response=JSON.parse(response);
            if(response.success){
                alert_float('success', response.message);
            }
            else
            {
                alert_float('danger', response.message);
            }
        });
        return false;
    }
</script>
</body>
</html>
<script>
    $(function() {
        _validate_form($('#insert_menu'), {
            Menu_name: 'required',
            menu_chil: 'required'
        }, managa_upload);
    });
    function managa_upload(form) {
        var data = $(form).serialize();
        var url = form.action;
        $.post(url, data).done(function(response) {
            console.log(response);
            response=JSON.parse(response);
            if(response.success){
                $('.table-clients').DataTable().ajax.reload();
                alert_float('success', response.message);
            }
            else
            {
                alert_float('danger', response.message);
            }
        });
        return false;
    }

    function get_view_file(id){
        jQuery.ajax({
            type: "post",
            dataType: "json",
            url: "<?=admin_url()?>field/get_data_field/"+id,
            data: "",
            cache: false,
            success: function (data) {
                $('#name').val(data.name);
                $('#type').val(data.type).datepicker("refresh");
                $('#_table').val(data._table).datepicker("refresh");
                $('#options').val(data.options);
                $('#field_order').val(data.field_order);
                $('#id_field').val(data.id_field);
                $('#bs_column').val(data.bs_column);
            }
        })
    }










    $("select[name=menu_chil\\[\\]] option[value='']").remove().selectpicker('refresh');
    var CustomersServerParams = {};
    $.each($('._hidden_inputs._filters input'),function(){
        CustomersServerParams[$(this).attr('name')] = '[name="'+$(this).attr('name')+'"]';
    });
    var headers_clients = $('.table-clients').find('th');
    var not_sortable_clients = (headers_clients.length - 1);
    initDataTable('.table-clients', window.location.href, [not_sortable_clients,0], [not_sortable_clients,0], CustomersServerParams,<?php echo do_action('customers_table_default_order',json_encode(array(1,'ASC'))); ?>);

    function customers_bulk_action(event) {
        var r = confirm(confirm_action_prompt);
        if (r == false) {
            return false;
        } else {
            var mass_delete = $('#mass_delete').prop('checked');
            var ids = [];
            var data = {};
            if(mass_delete == false || typeof(mass_delete) == 'undefined'){
                data.groups = $('select[name="move_to_groups_customers_bulk[]"]').selectpicker('val');
                if (data.groups.length == 0) {
                    data.groups = 'remove_all';
                }
            } else {
                data.mass_delete = true;
            }
            var rows = $('.table-clients').find('tbody tr');
            $.each(rows, function() {
                var checkbox = $($(this).find('td').eq(0)).find('input');
                if (checkbox.prop('checked') == true) {
                    ids.push(checkbox.val());
                }
            });
            data.ids = ids;
            $(event).addClass('disabled');
            setTimeout(function(){
                $.post(admin_url + 'clients/bulk_action', data).done(function() {
                    window.location.reload();
                });
            },50);
        }
    }

    $(document).ready(function(){
        setInterval(function(){
            $("#screen").load('banners.php')
        }, 2000);
    });


    $(document).on('click', '#edit_menu', function(){

        id=$(this).data("id");
        jQuery.ajax({
            dataType: "json",
            type: "post",
            url: "<?=admin_url()?>field/newview/get_menubds/"+id,
            data: '',
            cache: false,
            success: function (data) {
                if(data)
                {
                    $('#menu_name').val(data.menu_name);
                    $('#update_menu_bds').prop('action','<?=admin_url()?>newview/update_menu_bds/'+id);
                    var res = data.menu_chil.split(",");
                    $('select[name=menu_chil\\[\\]]').selectpicker('val', res).selectpicker('refresh');
                }
            }
        });
    });


</script>