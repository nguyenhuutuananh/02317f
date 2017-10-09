<script>



    Dropzone.options.clientAttachmentsUpload = false;
    if ($('#upload_file_project').length > 0) {
        new Dropzone('#upload_file_project', {
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
//                if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                    $('.dz-preview').remove();
                    $('.dz-default').show();
                    console.log(response);
                    response=JSON.parse(response);
//                    console.log(response);

                    count=$('.c_file').length;
                    $('.preview_image').append(
                        '<div class="col-md-4 display-block contract-attachment-wrapper img-'+response.file_id+'">'+
                            '<div>'+
                                    '<div class="checkbox mass_select_all_wrap">'+
                                        '<input type="checkbox" value="'+response.filename+'" >'+
                                    '<label></label>'+
                                    '</div>'+
                                '<div class="col-md-2 text-right">'+
                                    '<a href="javacript:void(0)"  class="text-danger _delete" onclick="delete_file('+response.file_id+',this)"><i class="fa fa fa-times"></i></a>'+
                                '</div>'+
                                '<a href="<?=base_url()?>uploads/project_bds/'+response.filename+'" data-lightbox="customer-profile" class="display-block mbot5">'+
                                    '<div class="table-image">'+
                                        '<img  src="<?=base_url()?>uploads/project_bds/'+response.filename+'">'+
                                    '</div>'+
                                '</a>'+
                        '</div>'+
                        '</div>'

                    );
//                }
            }
        });
    }







    $(function() {
        _validate_form($('#video'), {
            name: 'required',
            file: 'required'
        }, managa_upload);
    });
    function managa_upload(form) {
        var data = $(form).serialize();
        var url = form.action;
        $.post(url, data).done(function(response) {
            console.log(response);
            response=JSON.parse(response);
            if(response.success){
                alert_float('success', response.message);
                $('#video_project_view .row').append('<div class="display-block contract-attachment-wrapper img-'+response.id+'" style="padding:0px;">'+
                    '<div class="col-md-10">'+
                    '<a data-toggle="modal" data-target="#preview_video" onclick="load_video('+response.id+')">'+
                    '<div class="pull-left"><i class="mime mime-video"></i></div>'+
                    '<div>'+
                    response.name+
                    '</div>'+
                    '<p class="text-muted"></p>'+
                    '</a>'+
                    '</div>'+
                    '<div class="col-md-2 text-right r_delete">'+
                    '<a href="javacript:void(0)" class="text-danger" onclick="delete_file('+response.id+',this)"><i class="fa fa fa-times"></i></a>'+
                    '</div>'+
                    '<div class="clearfix"></div><hr/>'+
                    '</div>');
                $('#name').val('');
                $('#file').val('');

            }
            else
            {
                alert_float('danger', response.message);
            }
        });
        return false;
    }

    function delete_file(id,ro)
    {
        var r = confirm("Bạn có chắc bạn muốn xóa!");
        if(r==true){
            jQuery.ajax({
                type: "post",
                dataType:'json',
                url: "<?=admin_url()?>newview/delete_file/"+id,
                data: '',
                cache: false,
                success: function (data) {
                    $('.img-'+id).remove();
                }
            });
        }

    }
    function get_code_project(id)
    {
        jQuery.ajax({
            type: "post",
            dataType:'json',
            url: "<?=admin_url()?>newview/get_code_project/"+id,
            data: '',
            cache: false,
            success: function (data) {
                $('#code').val(data.code);
            }
        });
    }



    function load_video(id)
    {
        jQuery.ajax({
            type: "post",
            dataType:'json',
            url: "<?=admin_url()?>newview/get_video/"+id,
            data: '',
            cache: false,
            success: function (data) {
                $('.title_video').html(data.name);
                $('.watch_video').html(data.file).text();
            }
        });
    }





    function get_district(id)
    {
        jQuery.ajax({
            type: "post",
            dataType:'json',
            url: "<?=admin_url()?>newview/get_district/"+id,
            data: '',
            cache: false,
            success: function (data) {
                var option="";
                $.each(data, function( index, value ) {
                    option=option+'<option data-subtext="'+value.type+'" value="'+value.districtid+'">'+value.name+'</option>';
                });
                $('#district').html(option).selectpicker('refresh');

            }
        });
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
                        alert('123');
                        $('#update-master #type_master').val('1')
                    };
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
//            $('#div_isset_master').show();
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
    function delete_file_master(val,inl)
    {
        var allval=$('#update-master #_file').val();
        jQuery.ajax({
            type: "post",
            url: "<?=admin_url()?>newview/delete_file_master",
            data: {val:val,allval:allval},
            cache: false,
            success: function (data) {
                console.log(data)
                $('#update-master #_file').val(data);
                $('.file_index_'+inl).remove();
            }
        })
    }
    function delete_file_master_company(val,inl)
    {
        var allval=$('#update-master-company #_file').val();
        jQuery.ajax({
            type: "post",
            url: "<?=admin_url()?>newview/delete_file_master",
            data: {val:val,allval:allval},
            cache: false,
            success: function (data) {
                console.log(data)
                $('#update-master-company #_file').val(data);
                $('.file_index_'+inl).remove();
            }
        })
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

        }
    }
    function view_update_or_add_call(id=0)
    {
        if(id!=0)
        {
            $('.title-call').html('Cập nhật nhật ký cuộc gọi');
            jQuery.ajax({
                type: "post",
                url: "<?=admin_url()?>newview/get_one_table_call/"+id,
                data: '',
                dataType: "json",
                cache: false,
                success: function (data) {
                    console.log(data.note);
                    $('#update-call_logs').prop('action','<?=admin_url('newview/update_call_logs/')?>'+id);
                    $('#update-call_logs #note').val(data.note);
                    $('#date_call').val(data.date_call);
                }
            });

        }
        else
        {
            $('.title-call').html('Thêm nhật ký cuộc gọi');
            $('#update-call_logs').prop('action','<?=admin_url('newview/update_call_logs')?>');
            $('#date_call').val('');
            $('#update-call_logs #note').val('');
        }
    }






    function onchange_status(id,status)
    {
        jQuery.ajax({
            type: "post",
            url: "<?=admin_url()?>newview/update_view_master/"+id+'/'+status,
            data: '',
            dataType: "json",
            cache: false,
            success: function (data) {
                $('.table-master_bds_profile').DataTable().ajax.reload();
                $('.table-master_bds_company').DataTable().ajax.reload();
                console.log(data);

            }
        });
    }
    function onchange_type(id,type)
    {
        jQuery.ajax({
            type: "post",
            url: "<?=admin_url()?>newview/update_type_master/"+id+'/'+type,
            data: '',
            dataType: "json",
            cache: false,
            success: function (data) {
                console.log(data);
                $('.table-master_bds_profile').DataTable().ajax.reload();
                $('.table-master_bds_company').DataTable().ajax.reload();
                console.log(data);

            }
        });
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
        var r = confirm(confirm_action_prompt);
        if(!r)
        {
            return false;
        }

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
    function delete_profile(id)
    {
        $.ajax({
            type: "POST",
            dataType: "json",
            url: '<?=admin_url()?>newview/delete_profile/'+id,
            data: '',
            success: function (response) {
                if (response.success) {
                    alert_float('success', response.message);
                    $('.table-people-take').DataTable().ajax.reload();
                }
                else {
                    alert_float('danger', response.message);
                }
            }
        });
    }
</script>