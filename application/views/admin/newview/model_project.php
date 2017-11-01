<div class="modal fade " id="view_master_company" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title title-master">Thêm Công ty</h4>
            </div>

            <div class="modal-body">
                <div class="row">
                        <div class="col-md-12">
                            <?php echo form_open(admin_url('newview/update_master_company'),array('id'=>'update-master-company')); ?>
                                <?php echo render_input('idproject','',$id_bds,'hidden'); ?>
                                <?php echo render_input('code_master','','','hidden'); ?>
                                <?php echo render_input('name','Họ tên'); ?>
                                <style>
                                    ul.tagit {
                                        border: 1px solid #ccc!important;
                                    }
                                </style>
                                <div class="form-group">
                                    <label for="phonenumber" class="control-label"><?php echo _l('Phone'); ?></label>
                                    <input type="text" class="tagsphone" id="phonenumber" name="phonenumber" value="" data-role="tagsphone">
                                </div>
                                <?php echo render_input('email_master','Email'); ?>
                                <?php echo render_input('address','Địa chỉ'); ?>
                                <?php echo render_input('tax','Mã thuế công ty','','text',array('onchange'=>'get_tax_data(this)')); ?>
                                <?php echo render_input('hear','Lĩnh vực kinh doanh'); ?>
                                <?php echo render_input('website','Website'); ?>
                                <?php echo render_textarea('note','Note'); ?>
                                <div class="form-group" style="display:none;">
                                    <label for="_file" class="control-label ">_file</label>
                                    <input type="hidden" id="_file" name="_file" class="form-control" value="">
                                </div>
                            <div class="col-md-12 view_file">

                            </div>
                            <div class="clearfix"></div>
                            <?php echo form_close(); ?>

                            <form action="<?=admin_url()?>newview/upload_file_master" class="dropzone drop-master dz-clickable" id="upload_file_master_company" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                                <input type="file" name="file" multiple="">
                                <div class="dz-default dz-message"><span>Thả file vào đây để upload</span></div></form>
                        </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" id="master_company" class="btn btn-info"><?php echo _l('submit'); ?></button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="view_master" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title title-master">Thêm chủ sở hữu</h4>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo form_open(admin_url('newview/update_master'),array('id'=>'update-master')); ?>
                        <div class="col-md-12" id="div_isset_master">
                            <div class="form-group">
                                <div class="dropdown">
                                    <button class="btn btn-default pull-right dropdown-toggle" type="button" data-toggle="dropdown">Chủ sở hữu đã thêm
                                        <span class="caret"></span>
                                    </button>
                                            <ul class="dropdown-menu dropdown-menu-right" id="view_master_isset">

                                            </ul>
                                </div>
                            </div>
                        </div>
                            <?php echo render_input('idproject','',$id_bds,'hidden'); ?>
                            <?php echo render_input('code_master','','','hidden'); ?>
                            <?php echo render_input('type_master','','','hidden'); ?>
                            <div class="col-md-6">
                                <?php echo render_input('name','Họ tên'); ?>
                                <?php echo render_input('relation','Quan hệ'); ?>
                                <?php echo render_input('state','Quốc tịch'); ?>
                                <?php echo render_select('vocative',array(array('id'=>1,'name'=>'Mr'),array('id'=>2,'name'=>'Ms')),array('id','name'),'Xưng hô'); ?>
                                <?php echo render_input('birthday','Ngày tháng sinh nhật'); ?>
                                <?php echo render_input('CMND','CMND/PASSPORT'); ?>
                                <?php echo render_input('email_master','Email'); ?>
                                <?php echo render_input('TNCN','Mã số thuế CN','','number'); ?>
                            </div>
                            <style>
                                ul.tagit {
                                    border: 1px solid #ccc!important;
                                }
                            </style>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phonenumber" class="control-label"><?php echo _l('Phone'); ?></label>
                                    <input type="text" class="tagsphone" onchange="review_master(this,3)" id="phonenumber" name="phonenumber" value="" data-role="tagsphone">
                                </div>

                                <?php echo render_input('address','Địa chỉ'); ?>
                                <?php echo render_input('address_permanent','Địa chỉ thường trú'); ?>
                                <?php echo render_input('position','Chức vụ'); ?>
                                <?php echo render_input('company','Công ty'); ?>
                                <?php echo render_input('hear','Ngành nghề'); ?>
                                <?php echo render_input('hobby','Sở thích'); ?>
                                <?php echo render_input('facebook','Facebook'); ?>
                                <div class="form-group" style="display:none;">
                                    <label for="_file" class="control-label ">_file</label>
                                    <input type="hidden" id="_file" name="_file" class="form-control" value="">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <?php echo render_textarea('note','Note'); ?>
                            </div>
                        <div class="col-md-12 view_file">

                        </div>
                        <?php echo form_close(); ?>

                        <div class="col-md-12">
                            <form action="<?=admin_url()?>newview/upload_file_master" class="dropzone drop-master dz-clickable" id="upload_file_master" onchange="get_delete(this)" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                                <input type="file" name="file" multiple="">
                                <div class="dz-default dz-message">
                                    <span>Thả file vào đây để upload</span>
                                </div>
                            </form>
                        </div>
                    
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" id="master" class="btn btn-info"><?php echo _l('submit'); ?></button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="model_call_logs" role="dialog">
    <div class="modal-dialog">
        <?php echo form_open(admin_url('newview/update_call_logs'),array('id'=>'update-call_logs')); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title title-call" >Thêm nhật ký cuộc gọi</h4>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo render_input('id_project_bds','',$id_bds,'hidden')?>
                        <?php echo render_datetime_input('date_call','Thời gian liên hệ','',date('Y-m-d'))?>
                        <?php echo render_textarea('note','Ghi chú'); ?>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" id="btncall_logs" class="btn btn-info"><?php echo _l('submit'); ?></button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<div class="modal fade" id="model_people_take" role="dialog">
    <div class="modal-dialog">
        <?php echo form_open(admin_url('newview/update_profile'),array('id'=>'update-profile')); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title title-master">Thêm chủ sở hữu</h4>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php $selected=array();
                        foreach($customer as $r)
                        {
                            $selected[]=$r['staffid'];
                        }

                        ?>
                        <?php echo render_input('id_project','',$id_bds,'hidden')?>
                        <?php echo render_select('customer[]',$staff,array('staffid','fullname'),'',$selected,array('multiple'=>true)); ?>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" id="btnprofile" class="btn btn-info"><?php echo _l('submit'); ?></button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<script>
    Dropzone.options.clientAttachmentsUpload = false;
    
    if ($('#upload_file_master').length > 0) {
        new Dropzone('#upload_file_master', {
            paramName: "file",
            dictDefaultMessage:drop_files_here_to_upload,
            dictFallbackMessage:browser_not_support_drag_and_drop,
            dictRemoveFile:remove_file,
            dictFileTooBig: file_exceds_maxfile_size_in_form,
            dictMaxFilesExceeded:you_can_not_upload_any_more_files,
            maxFilesize: max_php_ini_upload_size.replace(/\D/g, ''),
            addRemoveLinks: false,
            accept: function(file, done) {
                done();
            },
            acceptedFiles: allowed_files,
            error: function(file, response) {
                alert_float('danger', response);
            },
            success: function(file, response) {
                $('.dz-preview').remove();
                $('.dz-default').show();
                console.log(file);
                console.log(response);
            }
        });
    }

    if ($('#upload_file_master_company').length > 0) {
        new Dropzone('#upload_file_master_company', {
            paramName: "file",
            dictDefaultMessage:drop_files_here_to_upload,
            dictFallbackMessage:browser_not_support_drag_and_drop,
            dictRemoveFile:remove_file,
            dictFileTooBig: file_exceds_maxfile_size_in_form,
            dictMaxFilesExceeded:you_can_not_upload_any_more_files,
            maxFilesize: max_php_ini_upload_size.replace(/\D/g, ''),
            addRemoveLinks: false,
            accept: function(file, done) {
                done();
            },
            acceptedFiles: allowed_files,
            error: function(file, response) {
                alert_float('danger', response);
            },
            success: function(file, response) {
                $('.dz-preview').remove();
                $('.dz-default').show();
                if($('#update-master-company input[name="_file"]').val()!="")
                {
                    $('#update-master-company input[name="_file"]').val($('#update-master-company input[name="_file"]').val()+','+response);
                }
                else
                {
                    $('#update-master-company input[name="_file"]').val(response);
                }
            }
        });
    }
</script>
<script>
    function review_master(_this,type)
    {
        $('#update-master').prop('');
        var numphone=$(_this).val();
        jQuery.ajax({
            type: "post",
            url:'<?=admin_url()."newview/getdata_master"?>',
            data: {numphone:numphone,type_master:type},
            cache: false,
            success: function (data) {
                var obj = JSON.parse(data);
                $('#view_master_isset').html('');
                $.each($(obj), function( index, value ) {
                    $('#view_master_isset').append('<li><a href="#" onclick="get_data_master('+value.id+')" >'+value.name+'('+value.code_master+')</a></li>');
                });
                if(obj!=null)
                {
                    console.log($('#update-master #code_master').val());
                    if($('#update-master #code_master').val()=="")
                    {
                        $('#update-master #div_isset_master').show();
                    }
                }

            }
        });
    }
    function get_tax_data(_this)
    {
        var tax=$(_this).val();
        jQuery.ajax({
            type: "post",
            url:'<?=admin_url()."newview/getdata_master_tax"?>',
            data: {tax:tax},
            cache: false,
            success: function (data) {
                var obj = JSON.parse(data);
                console.log(obj);
                if(obj!=null)
                {
                    if (confirm('Tìm thấy công ty với mã số thuế bạn có muốn lấy dữ liệu này không')) {
                        $('#update-master-company #name').val(obj.name);

                        $('#update-master-company #code_master').val(obj.code_master);

                        $('#update-master-company #email_master').val(obj.email_master);

                        $('#update-master-company #address').val(obj.address);
                        var phone = obj.phonenumber.split(",");
                        $.each($(phone), function (index, value) {
                            $('#update-master-company #phonenumber').tagit('createTag', value);
                        })

                        $('#update-master-company #hear').val(obj.hear);

                        $('#update-master-company #website').val(obj.website);
                        $('#update-master-company #code_master').val(obj.code_master);

                        $('#update-master-company #note').val(obj.note);
                        var datafile = obj._file;
                        if (datafile != "" && datafile != null) {
                            console.log(datafile);
                            var _array = datafile.split(',');
                            $.each(_array, function (index, value) {
                                $('#update-master-company .view_file').append('<div class="col-md-3 file_index_' + index + ' "><a target="_blank" href="<?=base_url()?>uploads/project_bds/' + value + '">' + value + '</a>' +
                                    '<div class="col-md-2 text-right r_delete">' +
                                    '<a href="#" onclick=delete_file_master_company("' + value + '",' + index + ') class="text-danger"><i class="fa fa fa-times"></i></a>' +
                                    '</div>' +
                                    '</div>');
                            });
                        }
                    }
                }
            }
        });
    }
    function get_data_master(id)
    {
        jQuery.ajax({
            type: "post",
            url:'<?=admin_url()."newview/get_data_master"?>',
            data: {id:id},
            cache: false,
            success: function (data) {
                var obj = JSON.parse(data);
                $('#update-master #name').val(obj.name);
                $('#update-master #code_master').val(obj.code_master);
                $('#update-master #relation').val(obj.relation);
                $('#update-master #address').val(obj.address);
                $('#update-master #state').val(obj.state);
                $('#update-master #address_permanent').val(obj.address_permanent);
                $('#update-master #position').val(obj.position);
                $('#update-master #company').val(obj.company);
                $('#update-master #CMND').val(obj.CMND);
                $('#update-master #hear').val(obj.hear);
                $('#update-master #email_master').val(obj.email_master);
                $('#update-master #hobby').val(obj.hobby);
                $('#update-master #TNCN').val(obj.TNCN);
                $('#update-master #facebook').val(obj.facebook);
                $('#update-master #_file').val(obj._file);
                if($('#update-master #type_master').val()!=1)
                {
                    $('#update-master #type_master').val(obj.type_master);
                }
                var datafile = obj._file;
                if (datafile != "" && datafile != null) {
                    var _array = datafile.split(',');
                    $.each(_array, function (index, value) {
                        $('#update-master .view_file').append('<div class="col-md-3 file_index_' + index + ' "><a target="_blank" href="<?=base_url()?>uploads/project_bds/' + value + '">' + value + '</a>' +
                            '<div class="col-md-2 text-right r_delete">' +
                            '<a href="#" onclick=delete_file_master_company("' + value + '",' + index + ') class="text-danger"><i class="fa fa fa-times"></i></a>' +
                            '</div>' +
                            '</div>');
                    });
                }

            }
        });
    }
</script>
