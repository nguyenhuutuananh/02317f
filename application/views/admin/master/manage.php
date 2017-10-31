<?php init_head(); ?>
<div id="wrapper">

    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <ul class="nav nav-tabs">
                            <li  class="active"><a data-toggle="tab" href="#profile">Cá nhân</a></li>
                            <li><a data-toggle="tab" href="#company">Công ty</a></li>
                        </ul>
                        <div class="tab-content mtop20">
                            <div id="profile" class="tab-pane fade in active">
                                <div class="_buttons" style="margin-bottom: 10px;">
                                    <a class="btn btn-info mright5" onclick="view_update_or_add(0,0)" data-toggle="modal" data-target="#view_master">Thêm chủ sở hữu</a>
                                    <a class="btn btn-danger mright5 test" onclick="_delete_all('table-master_bds','master_bds')" >Xóa số lượng lớn</a>
                                    <div class="clearfix"></div>
                                </div>
                                <?php
                                $table_data = array();
                                $table_data = array(
                                    _l('Mã chủ sở hữu'),
                                    _l('Họ Tên'),
                                    _l('Quan hệ'),
                                    _l('Quốc tịch'),
                                    _l('Xưng hô'),
                                    _l('Ngày sinh'),
                                    _l('CMND'),
                                    _l('Số điện thoại'),
                                    _l('Email'),
                                    _l('Thuế TNCN'),
                                    _l('Địa chỉ'),
                                    _l('Địa chỉ thường trú'),
                                    _l('Công ty'),
                                    _l('Chức vụ'),
                                    _l('Nghề nghiệp'),
                                    _l('Sở thích'),
                                    _l('Facebook'),
                                    _l('options')
                                );
                                array_unshift($table_data,'<span class="hide"> - </span><div class="checkbox mass_select_all_wrap"><input type="checkbox" id="mass_select_all" data-to-table="master_bds"><label></label></div>');

                                render_datatable($table_data,'master_bds_profile');
                                ?>

                            </div>
                            <div id="company" class="tab-pane fade">
                                <div class="_buttons" style="margin-bottom: 10px;">
                                    <a class="btn btn-info mright5" onclick="view_update_or_add_company(0,1)" data-toggle="modal" data-target="#view_master_company">Thêm chủ sở hữu</a>
                                    <a class="btn btn-danger mright5 test" onclick="_delete_all('table-master_bds','master_bds')" >Xóa số lượng lớn</a>
                                    <div class="clearfix"></div>
                                </div>
                                <?php
                                $table_data = array();
                                $table_data = array(
                                    _l('Mã chủ sở hữu'),
                                    _l('Họ Tên'),
                                    _l('Số điện thoại'),
                                    _l('Email'),
                                    _l('Địa chỉ'),
                                    _l('Mã số công ty'),
                                    _l('Lĩnh vực kinh doanh'),
                                    _l('Website'),
                                    _l('Note'),
                                    _l('options')
                                );
                                array_unshift($table_data,'<span class="hide"> - </span><div class="checkbox mass_select_all_wrap"><input type="checkbox" id="mass_select_all" data-to-table="master_bds"><label></label></div>');

                                render_datatable($table_data,'master_bds_company');
                                ?>

                            </div>

                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
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

<div id="view_relation" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body body_relation">
         <div class="_buttons" style="margin-bottom: 10px;">
                    <a class="btn btn-info mright5" onclick="view_update_or_add(0,0)" data-toggle="modal" data-target="#view_master">Thêm chủ sở hữu</a>
                    <a class="btn btn-danger mright5 test" onclick="_delete_all('table-master_bds','master_bds')" >Xóa số lượng lớn</a>
                    <div class="clearfix"></div>
        </div>
                
            <div class="listDetail">
                
            </div>
        </div>
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
                            <!-- <?php echo render_input('idproject','',$id_bds,'hidden'); ?> -->
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
<?php init_tail(); ?>
<script type="text/javascript">

      // var not_sortable_contracts = (headers_contracts.length - 1);
    $(function(){
        initDataTable('.table-master_bds_profile', admin_url+'master/init_profile' , [4],[4]);
        initDataTable('.table-master_bds_company', admin_url+'master/init_company' , [4],[4]);
    });
    function get_relation(id_project,type)
    {
        var contentDetail = `
                <?php
                    $table_data = array();
                    $table_data = array(
                        _l('Mã chủ sở hữu'),
                        _l('Họ Tên'),
                        _l('Quan hệ'),
                        _l('Quốc tịch'),
                        _l('Xưng hô'),
                        _l('Ngày sinh'),
                        _l('CMND'),
                        _l('Số điện thoại'),
                        _l('Email'),
                        _l('Thuế TNCN'),
                        _l('Địa chỉ'),
                        _l('Địa chỉ thường trú'),
                        _l('Công ty'),
                        _l('Chức vụ'),
                        _l('Nghề nghiệp'),
                        _l('Sở thích'),
                        _l('Facebook'),
                        _l('options')
                    );
                    array_unshift($table_data,'<span class="hide"> - </span><div class="checkbox mass_select_all_wrap"><input type="checkbox" id="mass_select_all" data-to-table="master_bds"><label></label></div>');
                    render_datatable($table_data,'master_bds_profile_company');
                ?>
        `;
        $('.listDetail').html(contentDetail);
        initDataTable('.table-master_bds_profile_company', admin_url+'master/init_profile/'+id_project+'/'+type , [4],[4]);
    }
    function view_update_or_add(id,type)
    {
        $('#update-master #div_isset_master').hide();
        $('#update-master .view_file').html('');
        if(id!=0)
        {
            $('#div_isset_master').hide();
            $('#phonenumber').tagit('removeAll');
            $('.title-master').html('Cập nhật chủ sở hữu');
            jQuery.ajax({
                type: "post",
                url: "<?=admin_url()?>newview/get_master/"+id,
                data: '',
                dataType: "json",
                cache: false,
                success: function (data) {
                    $('#update-master').prop('action','<?=admin_url('newview/update_master/')?>'+id);
                    $('#upload_file_master').prop('action','<?=admin_url('newview/upload_file_master/')?>'+id);
                    var phone=data.phonenumber.split(",");
                    $('#update-master #phonenumber').tagit('removeAll');
                    $.each($(phone), function( index, value ) {
                        $('#update-master #phonenumber').tagit('createTag',value);
                    })
                    $('#update-master #email_master').val(data.email_master);
                    $('#update-master #code_master').val(data.code_master);
                    $('#update-master #address').val(data.address);
                    $('#update-master #name').val(data.name);
                    $('#update-master #state').val(data.state);
                    $('#update-master #vocative').val(data.vocative).selectpicker('refresh');
                    $('#update-master #birthday').val(data.birthday);
                    $('#update-master #CMND').val(data.CMND);
                    $('#update-master #email_master').val(data.email_master);
                    $('#update-master #TNCN').val(data.TNCN);
                    $('#update-master #address').val(data.address);
                    $('#update-master #address_permanent').val(data.address_permanent);
                    $('#update-master #position').val(data.position);
                    $('#update-master #hobby').val(data.hobby);
                    $('#update-master #hear').val(data.hear);
                    $('#update-master #facebook').val(data.facebook);
                    $('#update-master #relation').val(data.relation);
                    $('#update-master #company').val(data.company);
                    $('#update-master #_file').val(data._file);
                    $('#update-master #type_master').val(type);
                    if(type=='1') {
                        $('#update-master #type_master').val('1')
                    }
                    var datafile=data._file;
                    if(datafile!=""&&datafile!=null) {
                        var _array = datafile.split(',');
                        $.each(_array, function (index, value) {
                            $('#update-master .view_file').append('<div class="col-md-3 file_index_' + index + ' "><a target="_blank" href="<?=base_url()?>uploads/project_bds/' + value + '">' + value + '</a>' +
                                '<div class="col-md-2 text-right r_delete">' +
                                '<a href="#" onclick=delete_file_master("' + value + '",' + index + ') class="text-danger"><i class="fa fa fa-times"></i></a>' +
                                '</div>' +
                                '</div>');
                        });
                    }
                }
            });
        }
        else
        {
            $('.title-master').html('Thêm chủ sở hữu cá nhân');
            $('#upload_file_master').prop('action','<?=admin_url('newview/upload_file_master')?>');
            $('#update-master').prop('action','<?=admin_url('newview/update_master')?>');
            $('#update-master #phonenumber').tagit('removeAll');
            $('#email_master').val('');
            $('#address').val('');
            $('#update-master #name').val('');
            $('#update-master #code_master').val('');
            $('#update-master #_file').val('');
            $('#update-master .view_file').html('');
            $('#update-master #email_master').val('');
            $('#update-master #code_master').val('');
            $('#update-master #address').val('');
            $('#update-master #name').val('');
            $('#update-master #state').val('');
            $('#update-master #vocative').val('').selectpicker('refresh');
            $('#update-master #birthday').val('');
            $('#update-master #CMND').val('');
            $('#update-master #email_master').val('');
            $('#update-master #TNCN').val('');
            $('#update-master #address').val('');
            $('#update-master #address_permanent').val('');
            $('#update-master #position').val('');
            $('#update-master #hobby').val('');
            $('#update-master #hear').val('');
            $('#update-master #facebook').val('');
            $('#update-master #relation').val('');
            $('#update-master #company').val('');
            $('#update-master #_file').val('');
            $('#update-master #type_master').val(type);
        }
    }
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
                    // console.log($('#update-master #code_master').val());
                    if($('#update-master #code_master').val()=="")
                    {
                        $('#update-master #div_isset_master').show();
                    }
                }

            }
        });
    }
    function view_update_or_add_company(id,type)
    {
        $('#update-master-company .view_file').html('');
        if(id!=0&&id!=null)
        {
            $('#phonenumber').tagit('removeAll');
            $('.title-master').html('Cập nhật công ty chủ sở hữu');
            jQuery.ajax({
                type: "post",
                url: "<?=admin_url()?>newview/get_master/"+id,
                data: '',
                dataType: "json",
                cache: false,
                success: function (data) {
                    $('#update-master-company').prop('action','<?=admin_url('newview/update_master_company/')?>'+id);
                    $('#upload_file_master_company').prop('action','<?=admin_url('newview/upload_file_master/')?>'+id);
                    var phone=data.phonenumber.split(",");
                    $.each($(phone), function( index, value ) {
                        $('#update_master_company #phonenumber').tagit('createTag',value);
                    })
                    $('#update-master-company #email_master').val(data.email_master);
                    $('#update-master-company #address').val(data.address);
                    $('#update-master-company #name').val(data.name);
                    $('#update-master-company #tax').val(data.tax);
                    $('#update-master-company #hear').val(data.hear);
                    $('#update-master-company #website').val(data.website);
                    $('#update-master-company #_file').val(data._file);
                    $('#update-master-company #type_master').val(type);
                    $('#update-master-company #div_isset_master_company').hide();
                    $('#update-master-company #code_master').val(data.code_master);
                    var datafile=data._file;
                    if(datafile!=""&&datafile!=null)
                    {
                        console.log(datafile);
                        var _array = datafile.split(',');
                        $.each(_array, function(index, value) {
                            $('#update-master-company .view_file').append('<div class="col-md-3 file_index_'+index+' "><a target="_blank" href="<?=base_url()?>uploads/project_bds/'+value+'">'+value+'</a>'+
                                    '<div class="col-md-2 text-right r_delete">'+
                                        '<a href="#" onclick=delete_file_master_company("'+value+'",'+index+') class="text-danger"><i class="fa fa fa-times"></i></a>'+
                                    '</div>'+
                                '</div>');
                        });
                    }
                }
            });

        }
        else
        {
            $('#update-master-company #div_isset_master_company').show();
            $('.title-master').html('Thêm Công ty chủ sở hữu');
            $('#update-master-company').prop('action','<?=admin_url('newview/update_master_company')?>');
            $('#update_master_company #upload_file_master_company').prop('action','<?=admin_url('newview/upload_file_master')?>');
            $('#update_master_company #phonenumber').tagit('removeAll');
            $('#update_master_company #email_master').val('');
            $('#update_master_company #address').val('');
            $('#update-master-company #name').val('');
            $('#update-master-company #_file').val('');
            $('#update-master-company #type_master').val(type); 
            // console.log($('#update-master-company'));
            alert(type);
        }
    }
    function _delete_all(table,d_table)
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
            url: '<?=admin_url()?>newview/delete_mess',
            data: {array_id:ids,table:d_table},
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
    function delete_true(id,table)
    {
        $.ajax({
            type: "POST",
            dataType: "json",
            url: '<?=admin_url()?>newview/delete_true/'+id,
            data: {table:table},
            success: function (response) {
                if (response.success) {
                    alert_float('success', response.message);
                    if(table=='call_logs')
                    {
                        $('.table-call-logs').DataTable().ajax.reload();
                    }
                    else
                    {
                        if(table=='master_bds')
                        {
                            $('.table-master_bds_profile').DataTable().ajax.reload();
                            $('.table-master_bds_company').DataTable().ajax.reload();
                        }
                    }

                }
                else {
                    alert_float('danger', response.message);
                }
            }
        });
    }

</script>
</body>
</html>
