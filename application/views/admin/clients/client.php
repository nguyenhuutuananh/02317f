<?php init_head(); ?>
<style>
    fieldset {
        padding: .35em .625em .75em!important;
        margin: 0 2px!important;
        border: 1px solid silver!important;
    }
    legend{
        width: auto!important;
    }
</style>
<div id="wrapper" class="customer_profile">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="tab-content">
                            <a  href="<?=admin_url()?>clients">
                                <button type="button" class="btn btn-default  pull-right">
                                    Trở lại
                                </button>
                            </a>
                            <h4 class="bold no-margin"><?php echo _l('Thông tin Khách hàng '); ?></h4>

                            <hr class="no-mbot no-border" />
                            <div class="row">
                                <div class="additional"></div>
                                <div class="col-md-12">
                                    <ul class="nav nav-tabs profile-tabs" role="tablist">
                                        <li role="presentation" class="active">
                                            <a href="#view_client" aria-controls="view_project" role="tab" data-toggle="tab">
                                                <?php echo _l( 'Chi tiết'); ?>
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                            <div role="tabpanel" class="tab-pane active" id="view_project">
                                                <?php echo form_open('http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'],array('class'=>'clients-bds-form','autocomplete'=>'off')); ?>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <p class="text-dark text-uppercase" style="text-align: center;"></p>
                                                        <hr class="no-mtop">
                                                    </div>
                                                    <div class="col-md-12">
                                                        <p class="text-dark text-uppercase" style="text-align: center; font-weight: bold"></p>
                                                        <hr class="no-mtop">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <fieldset>
                                                            <legend>Khách hàng</legend>
                                                                <?php $value=( isset($client) ? $client->company : ''); ?>
                                                                <?php echo render_input( 'company', 'Tên Khách hàng',$value); ?>
                                                                <?php $value=( isset($client) ? $client->email : ''); ?>
                                                                <?php echo render_input( 'email', 'Email',$value); ?>
                                                                <?php $selected=( isset($client) ? $client->exigency : ''); ?>
                                                                <?php echo render_select( 'exigency', $exigency,array('id','name'),'Nhu cầu',$selected,array()); ?>
                                                                <?php $selected=( isset($client) ? $client->purpose : ''); ?>
                                                                <?php echo render_select( 'purpose', $purpose,array('id','name'),'Mục đích',$selected,array()); ?>
                                                                <?php $value=( isset($client) ? $client->phonenumber : ''); ?>
                                                                <?php echo render_input( 'phonenumber', 'Số điện thoại',$value); ?>
                                                                <?php $selected=( isset($client) ? $client->country : ''); ?>
                                                                <?php echo render_select( 'country', $countries,array('country_id','short_name'),'Quốc tịch',$selected,array()); ?>
                                                                <!--                                                        --><?php //$selected=( isset($client) ? $client->type_client : ''); ?>
                                                                <!--                                                        --><?php //echo render_select( 'type_client', array(array('id'=>1,'name'=>'Khách hàng đang quan tâm'),array('id'=>2,'name'=>'Khách hàng mua/thuê'),array('id'=>3,'name'=>'Khách hàng fail')),array('id','name'),'Loại khách hàng',$selected,array()); ?>
                                                                <?php $selected=( isset($client) ? $client->source : ''); ?>
                                                                <?php echo render_select( 'source',$source,array('id','name'),'Nguồn',$selected,array()); ?>

                                                                <?php $selected=( isset($client) ? $client->class_client : ''); ?>
                                                                <?php echo render_select( 'class_client',$class_client,array('id','name'),'Loại khách hàng',$selected,array()); ?>
                                                                <?php $value=( isset($client) ? $client->date_contact : ''); ?>
                                                                <?php echo render_date_input('date_contact','Ngày Hẹn gặp',$value); ?>
                                                        </fieldset>

                                                        <p class="text-dark text-uppercase" style="text-align: center;"></p>
                                                        <hr class="no-mtop">
                                                        <fieldset>
                                                            <legend>Yêu Cầu Chi Tiết Sản Phẩm</legend>
                                                            <?php $value=( isset($client) ? $client->date_movein : ''); ?>
                                                            <?php echo render_date_input('date_movein','Ngày move in',$value); ?>
                                                            <?php $value=( isset($client) ? $client->date_tax : ''); ?>
                                                            <?php echo render_input( 'date_tax', 'Thời hạn thuê',$value); ?>
                                                        </fieldset>
                                                        <fieldset>
                                                            <legend>Tổng hợp</legend>
                                                            <?php $selected=( isset($client) ? $client->status : ''); ?>
                                                            <?php echo render_select('status', $status,array('id','name'),'Trạng thái',$selected,array()); ?>
                                                            <?php $selected=( isset($client) ? $client->nvgd : ''); ?>
                                                            <?php echo render_select('status', $staff,array('staffid','lastname'),'Nhân viên giám định',$selected,array()); ?>
                                                            <?php $value=( isset($client) ? $client->requirements : ''); ?>
                                                            <?php echo render_input( 'requirements', 'Yêu cầu khác',$value); ?>
                                                        </fieldset>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <fieldset>
                                                            <legend>Đối Tác</legend>
                                                            <?php $selected=( isset($client) ? $client->id_partner : ''); ?>
                                                            <?php echo render_select( 'id_partner', $id_partner,array('id_partner','name_partner'),'Đối tác',$selected,array()); ?>
                                                        </fieldset>
                                                        <p class="text-dark text-uppercase" style="text-align: center;"></p>
                                                        <hr class="no-mtop">

                                                        <fieldset>
                                                            <legend>Yêu cầu khu vực dự án</legend>
                                                            <?php $selected=( isset($client) ? $client->type_bds : ''); ?>
                                                            <?php echo render_select('type_bds', $menu_project,array('id','menu_name'),'Loại bất động sản',$selected,array('onchange'=>'get_project(this.value)')); ?>
                                                            <?php $selected=( isset($client) ? $client->province : ''); ?>
                                                            <?php echo render_select('province', $province,array('provinceid','name','type'),'Tỉnh/Thành phố',$selected,array('onchange'=>'get_district(this.value)')); ?>
                                                            <?php $selected=( isset($client) ? $client->id_project_bds : ''); ?>
                                                            <?php if(isset($client->type_bds)){
                                                                $id_project_bds=$this->clients_model->get_project($client->type_bds);
                                                            }?>
                                                            <?php echo render_select( 'id_project_bds', $id_project_bds,array('id','project_name','code'),'Dự án',$selected,array()); ?>
                                                            <?php $selected=( isset($client) ? $client->district : ''); ?>
                                                            <?php if(isset($client->province)){
                                                                $district=$this->clients_model->get_district($client->province);
                                                            }?>
                                                            <?php echo render_select('district', $district,array('districtid','name','type'),'Quận/huyện',$selected,array()); ?>

                                                        </fieldset>
                                                        <p class="text-dark text-uppercase" style="text-align: center;"></p>
                                                        <hr class="no-mtop">
                                                        <fieldset>
                                                            <legend>Yêu Cầu Chi Tiết Sản Phẩm</legend>
                                                            <?php $value=( isset($client) ? $client->pn : ''); ?>
                                                            <?php echo render_input( 'pn', 'Phòng ngủ',$value); ?>

                                                            <?php $value=( isset($client) ? $client->budget : ''); ?>
                                                            <?php echo render_input( 'budget', 'Ngân sách khoản',$value); ?>
                                                            <?php $value=( isset($client) ? $client->area : ''); ?>
                                                            <?php echo render_input( 'area', 'Diện tích',$value); ?>
                                                        </fieldset>
                                                        <?php if($type_client==2||$client->type_client==2){?>
                                                        <p class="text-dark text-uppercase" style="text-align: center;"></p>
                                                        <hr class="no-mtop">
                                                        <fieldset>
                                                            <legend>Hoa hồng</legend>

                                                                <div class="col-md-6">
                                                                    <?php $value=( isset($client) ? $client->status_bonus : ''); ?>
                                                                    <?php echo render_input( 'status_bonus', 'Trạng thái hoa hồng',$value); ?>
                                                                    <button type="button" class="btn btn-success" onclick="append_colum()">
                                                                        Thêm Đợt Thanh toán Hoa hồng
                                                                    </button>
                                                                </div>
                                                                <div class="col-md-6 time_bonus">
                                                                    <?php if(isset($client)){
                                                                        $time_bonus=explode(',',$client->time_bonus);
                                                                        $num_bonus=explode(',',$client->num_bonus);
                                                                        ?>
                                                                        <?php foreach($time_bonus as $num=> $rom){?>
                                                                            <fieldset class="fieldset review_bonus_<?=$num+1?>">
                                                                                <legend class="legend">Đợt: <?=$num+1?>  <a href="javacript:void(0)" class="text-danger _delete" onclick="remove_field(<?=$num+1?>)"><i class="fa fa fa-times"></i></a></legend>
                                                                                <div class="form-group">
                                                                                    <label for="time_bonus" class="control-label label-time">Ngày thu tiền đợt: <?=$num+1?></label>
                                                                                    <div class="input-group date">
                                                                                        <input type="text"  name="time_bonus[]" class="form-control datepicker" value="<?=$rom?>">
                                                                                        <div class="input-group-addon">
                                                                                            <i class="fa fa-calendar calendar-icon"></i>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="num_bonus" class="control-label label-num">Đợt: <?=$num+1?></label>
                                                                                    <input type="text"  name="num_bonus[]" class="form-control" value="<?=$num_bonus[$num]?>">
                                                                                </div>
                                                                            </fieldset>


                                                                        <?php }?>
                                                                </div>
                                                            <?php }?>


                                                                <div class="col-md-6 money_bonus">
                                                                </div>
                                                            <?php } ?>


                                                        </fieldset>


                                                    </div>

                                                    <div class="col-md-6">

                                                    </div>
                                                </div>
                                            <div>
                                                <button class="btn btn-info mtop20 only-save customer-form-submiter">
                                                    <?php echo _l( 'submit'); ?>
                                                </button>
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
</div>
<?php init_tail(); ?>
<script>

    function get_project(id)
    {
        jQuery.ajax({
            type: "post",
            dataType:'json',
            url: "<?=admin_url()?>clients/get_project/"+id,
            data: '',
            cache: false,
            success: function (data) {
                var option="";
                $.each(data, function( index, value ) {
                    option=option+'<option data-subtext="'+value.code+'" value="'+value.id+'">'+value.project_name+'</option>';
                });
                $('#id_project_bds').html(option).selectpicker('refresh');

            }
        });
    }
    function append_colum()
    {
        var time=$('.class_time').html();
        var re_num=$('input[name="num_bonus[]"]').length+1;
        console.log(re_num);

        $('.time_bonus').append('<fieldset class="fieldset review_bonus_'+re_num+'">'+
                                    '<legend class="legend">Đợt:'+re_num+'<a href="javacript:void(0)" class="text-danger _delete" onclick="remove_field('+re_num+')"><i class="fa fa fa-times"></i></a></legend>'+
                                        '<div class="form-group">' +
                                            '<label for="time_num" class="control-label label-time">Ngày thu tiền đợt:'+re_num+'</label>' +
                                            '<div class="input-group date">' +
                                                '<input type="text"  name="time_bonus[]" class="form-control datepicker" value="">' +
                                                '<div class="input-group-addon">'+
                                                    '<i class="fa fa-calendar calendar-icon"></i>'+
                                                '</div>'+
                                            '</div>'+
                                        '</div>'+
                                        '<div class="form-group review_bonus_'+re_num+'">' +
                                            '<label for="date_movein" class="control-label label-num">Đợt:'+re_num+'</label>' +
                                            '<input type="text"  name="num_bonus[]" class="form-control" value="">'+
                                        '</div>'+
                                '</fieldset>'
        );
        init_datepicker();

    }
    function remove_field(key)
    {
        $('.review_bonus_'+key).remove();
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
    function get_district(id)
    {
        jQuery.ajax({
            type: "post",
            dataType:'json',
            url: "<?=admin_url()?>clients/get_district/"+id,
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
    initDataTable('.table-call-logs','<?=admin_url()?>newview/init_relation_logs/<?php echo $id_bds; ?>' , [0], [0]);
    initDataTable('.table-master_bds','<?=admin_url()?>newview/init_relation_master_bds/<?php echo $id_bds; ?>' , [0], [0]);
    initDataTable('.table-people-take','<?=admin_url()?>newview/init_relation_take/<?php echo $id_bds; ?>' , [3], [3]);
</script>
<?php include_once(APPPATH . 'views/admin/newview/script_project.php');?>
</body>
</html>
