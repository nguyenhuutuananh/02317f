<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="_buttons">
                                    <a class="btn btn-info mright5 test pull-left display-block" data-toggle="modal" data-target="#add_data" onclick="clear_data()" >Thêm đối tác</a>
                                    <a class="btn btn-default mright5 test pull-left display-block" data-toggle="modal" data-target="#import_data">import đối tác</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="nav nav-tabs profile-tabs" role="tablist">
                                    <li role="presentation" class="active">
                                        <a href="#partner" onclick="initDataTable('.table-partner_project','<?=admin_url()?>partner/init_relation_partner_project/1' , [4], [4]);" aria-controls="review_host" role="tab" data-toggle="tab">
                                            <?php echo _l('Chuyên Dự Án'); ?>
                                        </a>
                                    </li>
                                    <li role="presentation">
                                        <a href="#not_partner" onclick="initDataTable('.table-partner_not_project','<?=admin_url()?>partner/init_relation_partner_project/0' , [4], [4]);" aria-controls="review_host" role="tab" data-toggle="tab">
                                            <?php echo _l('Không Hợp Tác'); ?>
                                        </a>
                                    </li>
                                    <li role="presentation">
                                        <a href="#success" onclick="initDataTable('.table-partner_success','<?=admin_url()?>partner/init_relation_partner_project/3' , [4], [4]);" aria-controls="review_host" role="tab" data-toggle="tab">
                                            <?php echo _l('Giao dịch thường xuyên'); ?>
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="partner">
                                        <a class="btn btn-danger mright5 test pull-left display-block" style="margin-bottom: 10px;" onclick="_delete_all(1,'partner_project')" >Xóa số lượng lớn</a>
                                        <div class="clearfix"></div>
                                            <?php render_datatable(
                                                array(
                                                    '<span class="hide"> - </span><div class="checkbox mass_select_all_wrap"><input type="checkbox" id="mass_select_all" data-to-table="partner_project"><label></label></div>',
                                                    _l( 'Tên'),
                                                    _l( 'Số điện thoại'),
                                                    _l( 'Email'),
                                                    _l( 'Công ty'),
                                                    _l( 'Ngày thêm'),
                                                    _l( 'Tags'),
                                                    _l( 'Nhân viên tạo'),
                                                    _l( 'options'),
                                                    ),
                                                'partner_project'); ?>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="not_partner">
                                        <a class="btn btn-danger mright5 test pull-left display-block" style="margin-bottom: 10px;" onclick="_delete_all(0,'partner_not_project')" >Xóa số lượng lớn</a>
                                        <div class="clearfix"></div>
                                            <?php
                                            $table_data = array();
                                            $table_data = array(
                                                _l( 'Tên'),
                                                _l( 'Số điện thoại'),
                                                _l( 'Email'),
                                                _l( 'Công ty'),
                                                _l( 'Tags'),
                                                _l( 'Nhân viên tạo'),
                                                _l( 'options'),
                                            );
                                            array_unshift($table_data,'<span class="hide"> - </span><div class="checkbox mass_select_all_wrap"><input type="checkbox" id="mass_select_all" data-to-table="partner_not_project"><label></label></div>');

                                            render_datatable($table_data,'partner_not_project');
                                            ?>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="success">
                                        <a class="btn btn-danger mright5 test pull-left display-block" style="margin-bottom: 10px;" onclick="_delete_all(0,'partner_success')" >Xóa số lượng lớn</a>
                                        <div class="clearfix"></div>
                                            <?php
                                            $table_data = array(
                                                _l( 'Tên'),
                                                _l( 'Số điện thoại'),
                                                _l( 'Email'),
                                                _l( 'Công ty'),
                                                _l( 'Tags'),
                                                _l( 'Nhân viên tạo'),
                                                _l( 'options'),
                                            );
                                            array_unshift($table_data,'<span class="hide"> - </span><div class="checkbox mass_select_all_wrap"><input type="checkbox" id="mass_select_all" data-to-table="partner_success"><label></label></div>');

                                            render_datatable($table_data,'partner_success');
                                            ?>
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

<div id="import_data" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Import</h4>
            </div>
            <div class="modal-body">
                <a class="btn btn-info mright5 test pull-left display-block" href="<?=base_url()?>uploads/excel/partner_sample.xlsx">Tải bản mẩu</a>
                <div class="clearfix"></div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tên</th>
                            <th>Số điện thoại</th>
                            <th>Email</th>
                            <th>Công ty</th>
                            <th>Ngày thêm</th>
                            <th>loại đối tác(1= chuyên dự án,0= không hợp tác)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                        </tr>
                    </tbody>
                </table>
                <div class="col-md-4">
                    <?php echo form_open_multipart(admin_url().'partner/import_partner',array('id'=>'import_form')) ;?>
                    <?php echo form_hidden('leads_import','true'); ?>
                    <?php echo render_input('file_csv','choose_csv_file','','file'); ?>

                    <?php echo form_close(); ?>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_import" class="btn btn-info import btn-import-submit"><?php echo _l('import'); ?></button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
<div id="add_data" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <?php echo form_open(admin_url().'partner/update',array('id'=>'form_partner')); ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Thêm Đối Tác</h4>
            </div>
            <div class="modal-body">
                <div class="clearfix"></div>
                <div class="col-md-12">
                    <?php echo render_input('id','','','hidden'); ?>
                    <?php echo render_input('name_partner','Họ Tên','','text'); ?>
                    <?php echo render_input('phone_partner','Số điện thoại','','text'); ?>
                    <?php echo render_input('email_partner','Email','','text'); ?>
                    <?php echo render_input('company_partner','Công ty','','text'); ?>
                    <?php echo render_select('status',array(array('id'=>1,'name'=>'Chuyên dự án'),array('id'=>'2','name'=>'Không hợp tác'), array('id'=>'3', 'name'=>'Giao dịch thành công')),array('id','name'),'Loại đối tác',''); ?>
                    <div class="form-group">
                        <label for="tag_partner" class="control-label"><i class="fa fa-tag" aria-hidden="true"></i>Thẻ Phân loại ĐT</label>
                        <input type="text" class="tagspartner" id="tag_partner" name="tag_partner" value="" data-role="tagsinput">
                    </div>

                </div>
                <div class="clearfix"></div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_save_partner" class="btn btn-info import btn-import-submit"><?php echo _l('Lưu'); ?></button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>

            <?php echo form_close(); ?>
        </div>

    </div>
</div>
<?php init_tail(); ?>

<script>
    initDataTable('.table-partner_project','<?=admin_url()?>partner/init_relation_partner_project/1' , [0,7], [0,7]);
    initDataTable('.table-partner_not_project','<?=admin_url()?>partner/init_relation_partner_project/0' , [0,7], [0,7]);
    function clear_data()
    {
        $('#tag_partner').tagit('removeAll');
        $('#id').val('');
        $('#name_partner').val('');
        $('#phone_partner').val('');
        $('#email_partner').val('');
        $('#company_partner').val('');
        $('#status').val('').selectpicker('refresh');
    }
    function get_data(id) {
        $('#tag_partner').tagit('removeAll');
        $.ajax({
            type: "POST",
            dataType: "json",
            url: '<?=admin_url()?>partner/get_partner/' + id,
            data: '',
            success: function (response) {
                $('#id').val(id);
                $('#name_partner').val(response.name_partner);
                $('#phone_partner').val(response.phone_partner);
                $('#email_partner').val(response.email_partner);
                $('#company_partner').val(response.company_partner);
                $.each($(response.tag), function(key,value) {
                    $('#tag_partner').tagit('createTag',value);
                })
                if(response.status==0)
                {
                    response.status=2;
                }
                $('#status').val(response.status).selectpicker('refresh');
            }
        })
    }
    function _delete(id)
    {
        $.ajax({
            type: "POST",
            dataType: "json",
            url: '<?=admin_url()?>partner/delete_partner/' + id,
            data: '',
            success: function (response) {
                if (response.success) {
                    alert_float('success', response.message);
                    $('.table-partner_project').DataTable().ajax.reload();
                    $('.table-partner_not_project').DataTable().ajax.reload();
                }
                else {
                    alert_float('danger', response.message);
                }
            }
        });
        return false;
    };
    function _delete_all(type,table)
    {
                var ids = [];
                var num=0;
                var rows = $('.table-'+table+' tbody input[type=checkbox]');
                $.each(rows, function(i,v) {
                    if ($(v).prop('checked') == true) {
                        ids.push($(v).val());
                        id=$(v).val();
                    }
                });
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: '<?=admin_url()?>partner/delete_mess_partner',
                    data: {array_id:ids},
                    success: function (response) {
                        if (response.success) {
                            alert_float('success', response.message);
                            $('.table-partner_project').DataTable().ajax.reload();
                            $('.table-partner_not_project').DataTable().ajax.reload();
                        }
                        else {
                            alert_float('danger', response.message);
                        }
                    }
                });
    };
</script>

</body>
</html>
