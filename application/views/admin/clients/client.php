<?php init_head(); ?>
<style>
    fieldset 
    {
        border: 1px solid #ddd !important;
        margin: 0;
        xmin-width: 0;
        padding: 10px;       
        position: relative;
        border-radius:4px;
        background-color:#f5f5f5;
        padding-left:10px!important;
    }   
    
    legend
    {
        font-size:14px;
        font-weight:bold;
        margin-bottom: 0px; 
        width: 35%; 
        border: 1px solid #ddd;
        border-radius: 4px; 
        padding: 5px 5px 5px 10px; 
        background-color: #ffffff;
    }
    div:not(.dataTables_scrollFoot)::-webkit-scrollbar { 
        display: none; 
    }

</style>
<div id="wrapper" class="customer_profile">
    <div class="content">
        <div class="row">

        <?php if (isset($client)) { ?>
            <div class="col-md-3">
                <div class="panel_s">
                <div class="panel-body">
                    <?php if (has_permission('customers', '', 'delete') || is_admin()) { ?>
                    <div class="btn-group pull-left mright10">
                    <!-- <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-left">
                        <?php if (is_admin()) { ?>
                        <li>
                        <a href="<?php echo admin_url('clients/login_as_client/' . $client->userid); ?>" target="_blank">
                            <i class="fa fa-share-square-o"></i> <?php echo _l('login_as_client'); ?>
                        </a>
                        </li>
                        <?php 
                    } ?>
                        <?php if (has_permission('customers', '', 'delete')) { ?>
                        <li>
                        <a href="<?php echo admin_url('clients/delete/' . $client->userid); ?>" class="text-danger delete-text _delete" data-toggle="tooltip" data-title="<?php echo _l('client_delete_tooltip'); ?>" data-placement="bottom"><i class="fa fa-remove"></i> <?php echo _l('delete'); ?>
                        </a>
                        </li>
                        <?php 
                    } ?>
                    </ul> -->
                    </div>
                    <?php 
                } ?>
                    <h4 class="customer-heading-profile bold"><?php echo $title; ?></h4>
                    <?php $this->load->view('admin/clients/tabs'); ?>
                </div>
                </div>
            </div>
            <?php 
            } ?>
            <div class="col-md-<?=(!isset($client)? 12 : 9)?>">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="tab-content">
                        <?php $this->load->view('admin/clients/groups/'.$group); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
<?php include_once(APPPATH . 'views/admin/clients/client_js.php');?>

<script>

    function get_project(id)
    {
        jQuery.ajax({
            type: "post",
            dataType:'json',
            url: "<?=admin_url()?>clients/get_project/"+id.value,
            data: '',
            cache: false,
            success: function (data) {
                var option="";
                $.each(data, function( index, value ) {
                    option=option+'<option data-subtext="'+value.code+'" value="'+value.id+'">'+value.project_name+'</option>';
                });
                $(id).parents('.form-group').next().find('select').html(option).selectpicker('refresh');

            }
        });
    }
    function append_colum()
    {
        var time=$('.class_time').html();
        var re_num=$('input[name="num_bonus[]"]').length+1;
        console.log(re_num);

        $('.time_bonus').parent().append('<div class="col-md-3"><fieldset class="fieldset review_bonus_'+re_num+'">'+
                                    '<legend class="legend">Đợt:'+re_num+'<a href="javacript:void(0)" class="text-danger _delete" onclick="remove_field('+re_num+')"><i class="fa fa fa-times"></i></a></legend>'+
                                        '<div class="form-group">' +
                                            '<label for="time_num" class="control-label label-time col-sm-4">Ngày thu đợt:'+re_num+'</label>' +
                                            '<div class="col-sm-8">'+
                                            '<div class="input-group date">' +
                                                '<input type="text"  name="time_bonus[]" class="form-control datepicker" value="">' +
                                                '<div class="input-group-addon">'+
                                                    '<i class="fa fa-calendar calendar-icon"></i>'+
                                                '</div>' +
                                            '</div>' +
                                            '</div>' +
                                        '</div>' +
                                        '<div class="form-group review_bonus_'+re_num+'">' +
                                            '<label for="date_movein" class="control-label col-sm-4 label-num">Đợt:'+re_num+'</label>' +
                                            '<div class="col-sm-8">'+
                                            '<input type="text"  name="num_bonus[]" class="form-control" value="">'+
                                            '</div>' +
                                        '</div>'+
                                '</fieldset></div>'
        );
        init_datepicker();

    }
    function remove_field(key)
    {

        $('.review_bonus_'+key).parent().remove();
        var re_num=$('input[name="num_bonus[]"]').length;
        var legend=$('.legend');
        var field=$('.fieldset');
        var lable_time=$('.label-time');
        var lable_num=$('.label-num');
//        var time_num=$('control-label').attr('for',)
        console.log(legend);
        for(var i=0;i<re_num;i++)
        {
            $(field[i]).prop('class','fieldset review_bonus_'+(i+1));
            $(legend[i]).html('Đợt '+(i+1)+'<a href="javacript:void(0)" class="text-danger _delete" onclick="remove_field('+(i+1)+')"><i class="fa fa fa-times"></i></a>');
            $(lable_time[i]).html('Ngày thu tiền đợt: '+(i+1));
            $(lable_num[i]).html('Đợt: '+(i+1));
        }
    }
    function get_district_client(id)
    {
        jQuery.ajax({
            type: "post",
            dataType:'json',
            url: "<?=admin_url()?>clients/get_district/"+id.value,
            data: '',
            cache: false,
            success: function (data) {
                var option="";
                $.each(data, function( index, value ) {
                    option=option+'<option data-subtext="'+value.type+'" value="'+value.districtid+'">'+value.name+'</option>';
                });
                $(id).parents('.form-group').next().find('select').html(option).selectpicker('refresh');

            }
        });
    }

    function view_init_department(id)
    {
        jQuery.ajax({
            type: "post",
            url:admin_url+"clients/getProduct/<?=(isset($client) ? $client->userid : '' )?>/"+id,
            data: '',
            cache: false,
            dataType: 'json',
            success: function (data) {
                if(data.success)
                {
                    let item = data.data;
                    $('#viewProduct').modal('show');
                    $('#viewProduct .modal-body .col-sm-8').each((i, v) => {
                        switch(i) {
                            case 0:
                                $(v).html(item.project_name);
                                break;
                            case 1:
                                $(v).html(item.project_name);
                                break;
                            case 2:
                                $(v).html(item.project_name);
                                break;
                            case 3:
                                $(v).html(item.project_name);
                                break;
                            case 4:
                                $(v).html(item.project_name);
                                break;
                            case 5:
                                $(v).html(item.project_name);
                                break;
                            case 6:
                                $(v).html(item.project_name);
                                break;
                            case 7:
                                $(v).html(item.project_name);
                                break;
                        }
                    });
                }
                else {
                    alert_float('danger', 'Lấy dữ liệu thất bại!');
                }
            }
        });
    }
    function new_product(){
        $('#newProduct').modal('show');
        jQuery('#id_type').prop('action', admin_url + 'clients/addProduct/<?=(isset($client) ? $client->userid : "")?>');
    }
    $(() => {
        _validate_form($('.form-item'),{
            'items[0][city]': 'required',
            'items[0][district]': 'required',
            'items[0][menuBdsId]': 'required',
            'items[0][projectBdsId]': 'required',
            'items[0][type]': 'required',
            'items[0][price]': 'required',
            'items[0][dateStart]': 'required',
        },send_data_form);
    });
    function send_data_form(form) {
        var data = $(form).serialize();
        var url = form.action;
        $.post(url, data).done(function(response) {
            response = JSON.parse(response);
            if(response.success == true){
                alert_float('success',response.message);
            }
            else {
                alert_float('danger',response.message);
            }
            $(form)[0].reset();
            
            $('.selectpicker').val('');
            $('.selectpicker').change();
            $('.selectpicker').selectpicker('refresh');

            $(form).find('.datepicker').val('<?=date('Y-m-d')?>');
            $('.table-client-items').DataTable().ajax.reload();
            $('#newProduct').modal('hide');
        });
        return false;
    }
    if($('.table-client-items').length) {
        initDataTable('.table-client-items', window.location.href, [0], [0]);
    }
    
    initDataTable('.table-call-logs','<?=admin_url()?>newview/init_relation_logs/<?php echo $id_bds; ?>' , [0], [0]);
    initDataTable('.table-master_bds','<?=admin_url()?>newview/init_relation_master_bds/<?php echo $id_bds; ?>' , [0], [0]);
    initDataTable('.table-people-take','<?=admin_url()?>newview/init_relation_take/<?php echo $id_bds; ?>' , [3], [3]);
</script>
<?php include_once(APPPATH . 'views/admin/newview/script_project.php');?>
</body>
</html>
