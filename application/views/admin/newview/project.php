<?php init_head(); ?>
<style>
    fieldset {
        padding: .35em .625em .75em!important;
        margin: 0 2px!important;
        border: 1px solid #19a9ea!important;
    }
    .table .alert-info{
        background-color: #d9edf7!important;

    }
    .table .alert-success{
        background-color: #dff0d8!important;

    }
    legend{
        font-size: 15px;
        font-weight:500;
        width: auto!important;
    }
    ul{
        margin-bottom: 0px!important;
        border-radius: 0px!important;
    }
    button[data-id="exigency[]"]{
        font-size: x-small!important;
    }
    ul.tagit.ui-widget.ui-widget-content.ui-corner-all{
        max-height: 34px;
        /*min-height: 34px;*/
    }
</style>
<div id="wrapper" class="customer_profile">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="tab-content">
                            <?php
                                if($id_project)
                                {
                                    $type_project='?project='.$id_project;
                                }
                                else
                                {
                                    $type_project="";
                                }
                            ?>
                            <a  href="<?=admin_url()?>newview/indexproject/<?=$id_menu->id.$type_project?>">
                                <button type="button" class="btn btn-default  pull-right">
                                    Trở lại
                                </button>
                            </a>
                            <h4 class="bold no-margin"><?php echo _l('Thông tin bất động sản '); ?><?=$id_menu->menu_name?> <?php if($project->code){ ?>(<?=$project->code?>)<?php }?></h4>

                            <hr class="no-mbot no-border" />
                            <div class="row">
                                    <div class="additional"></div>
                                    <div class="col-md-12">
                                        <ul class="nav nav-tabs profile-tabs" role="tablist">
                                            <li role="presentation" class="active">
                                                <a href="#view_project" aria-controls="view_project" role="tab" data-toggle="tab">
                                                    <?php echo _l( 'Chi tiết'); ?>
                                                </a>
                                            </li>
                                            <?php if(isset($id_bds)){?>
                                                <li role="presentation">
                                                    <a href="#review_host" onclick="initDataTable('.table-master_bds','<?=admin_url()?>newview/init_relation_master_bds/<?php echo $id_bds; ?>' , [4], [4]);" aria-controls="review_host" role="tab" data-toggle="tab">
                                                        <?php echo _l('Chủ Sở hữu'); ?>
                                                    </a>
                                                </li>
                                                <li role="presentation">
                                                    <a href="#file_project" aria-controls="billing_and_shipping" role="tab" data-toggle="tab">
                                                        <?php echo _l( 'Hình ảnh/Video'); ?>
                                                    </a>
                                                </li>
                                                <li role="presentation">
                                                    <a href="#tab_call_logs" onclick="initDataTable('.table-call-logs','<?=admin_url()?>newview/init_relation_logs/<?php echo $id_bds; ?>' , [0], [0]);" aria-controls="tab_call_logs" role="tab" data-toggle="tab">
                                                        <?php echo _l('Nhật ký cuộc gọi'); ?>
                                                    </a>
                                                </li>

                                                <li role="presentation">
                                                    <a href="#people_take" onclick="initDataTable('.table-people-take','<?=admin_url()?>newview/init_relation_take/<?php echo $id_bds; ?>' , [0], [0]);" aria-controls="tab_call_logs" role="tab" data-toggle="tab">
                                                        <?php echo _l('Quản trị viên bất động sản'); ?>
                                                    </a>
                                                </li>

                                                <li role="presentation">
                                                    <a href="#review_log" aria-controls="review_host" role="tab" data-toggle="tab">
                                                        <?php echo _l( 'Nhật ký hoạt động'); ?>
                                                    </a>
                                                </li>
                                            <?php }?>
                                        </ul>

                                        <div class="tab-content mtop20">
                                                <div role="tabpanel" class="tab-pane active" id="view_project">
                                                    <?php echo form_open($this->uri->uri_string(),array('class'=>'project-bds-form','autocomplete'=>'off')); ?>
                                                    <div>
                                                        <button class="btn btn-info  only-save customer-form-submiter" style="margin-bottom: 20px;">
                                                            <?php echo _l( 'submit'); ?>
                                                        </button>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <fieldset>
                                                                <legend><?=$id_menu->menu_name?></legend>
                                                                    <div class="row">
                                                                        <div class="col-md-3">
                                                                            <?php $selected=( isset($project) ? $project->project : ''); ?>
                                                                            <?php echo render_select( 'project', $s_project,array('id','name'),'Dự án',$selected,array('onchange'=>'get_code_project(this.value)'),'','input-group','',true,'input-group-addon'); ?>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <?php $value=( isset($project) ? $project->code : ''); ?>
    <!--                                                                        --><?//=;?>
                                                                            <?php echo render_input( 'code', get_name_lable_row('code'),$value,'text',array('readonly'=>'readonly'),'','input-group','','input-group-addon'); ?>
                                                                        </div>
                                                                        <?php if($id_menu->province_from==1){?>
                                                                            <div class="col-md-3">
                                                                                <?php $selected=( isset($project) ? $project->province : '79'); ?>
                                                                                <?php echo render_select( 'province',$province,array('provinceid','name'), get_name_lable_row('province_name'),$selected,array('onchange'=>'get_district(this.value)'),'','input-group','',true,'input-group-addon'); ?>
                                                                            </div>
                                                                        <?php }?>
                                                                        <?php if($id_menu->province_from==1){?>
                                                                                <div class="col-md-3">
                                                                                    <?php $array=$this->newview_model->get_table_where('district','provinceid='.$selected);?>
                                                                                    <?php $selected=( isset($project) ? $project->district : ''); ?>
                                                                                    <?php echo render_select( 'district',$array,array('districtid','name'), get_name_lable_row('district_name'),$selected,array(),'','input-group','',true,'input-group-addon'); ?>
                                                                                </div>
                                                                        <?php }?>
<!--                                                                        <div class="row">-->

                                                                             <?php
                                                                                    echo render_fields_row('menu_bds',$id_menu->id,$project->id,array('tblrow_menu_bds.fields_from=1'),3,'input-group-addon','input-group');
                                                                             ?>
<!--                                                                        </div>-->
                                                                    </div>

                                                            </fieldset>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <fieldset>
                                                                <legend>THÔNG TIN CHUNG</legend>
                                                                    <?php $value=( isset($project) ? $project->id_menu : $id_menu->id); ?>
<!--                                                                    --><?php //echo render_input( 'id_menu', '',$value,'hidden'); ?>
                                                                <input type="hidden" id="id_menu" name="id_menu" class="form-control" value="<?=$value?>">

                                                                <div class='row'>
                                                                    <div class="col-md-3">
                                                                        <?php
                                                                        $cus_check=array();
                                                                        if($cus_exigency)
                                                                        {

                                                                            foreach($cus_exigency as $cus)
                                                                            {
                                                                                $cus_check[]=$cus['id_exigency'];
                                                                            }
                                                                        }
                                                                        ?>
                                                                        <?php $selected=( isset($project) ? $cus_check : array()); ?>
                                                                        <?php echo render_select( 'exigency[]',$exigency,array('id','name'), get_name_lable_row('exigency_name'),$selected,array('multiple'=>true),'','input-group','',true,'input-group-addon'); ?>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <?php $selected=( isset($project) ? $project->district : ''); ?>
                                                                        <?php $array=( isset($district) ? $district : array());?>

                                                                        <?php $selected=( isset($project) ? $project->furniture : ''); ?>
                                                                        <?php echo render_select( 'furniture',$furniture,array('id','name'), get_name_lable_row('furniture_name'),$selected,array(),'','input-group','',true,'input-group-addon'); ?>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <?php $value = (isset($project) ?  number_format($project->price,0,".",".") : '');?>
                                                                        <?php echo render_input( 'price', get_name_lable_row('price'),$value,'text',array('onkeyup'=>"formart_money_contract('price')"),'','input-group','','input-group-addon'); ?>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <?php $value=( isset($project) ? $project->characteristics : ''); ?>
                                                                        <?php echo render_input( 'characteristics', get_name_lable_row('characteristics'),$value,'text',array(),'','input-group','','input-group-addon'); ?>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <?php $selected=( isset($project) ? $project->status : ''); ?>
                                                                        <?php echo render_select( 'status',$status,array('id','name'), get_name_lable_row('status'),$selected,array(),'','input-group','',true,'input-group-addon'); ?>
                                                                    </div>
                                                                    <script>
                                                                        function review_deadline(type)
                                                                        {
                                                                            if(type.value==0||type.value==2)
                                                                            {
                                                                                $('#review_true').collapse('hide');
                                                                            }
                                                                            else
                                                                            {
                                                                                $('#review_true').collapse('show');
                                                                            }
                                                                        }
                                                                        function review_deadlinetype(type)
                                                                        {
                                                                            if(type.value==3)
                                                                            {
                                                                                $('#to_deadtime').val('');
                                                                                $('#time_true').collapse('show');
                                                                                $('#time_not').collapse('hide');
                                                                            }
                                                                            else
                                                                            {
                                                                                $('#time_true').collapse('hide');
                                                                                $('#time_not').collapse('show');
                                                                            }
                                                                        }
                                                                    </script>
                                                                    <div class="col-md-3">
                                                                        <?php $value=( isset($project) ? $project->type_pn : ''); ?>
                                                                        <?php echo render_input( 'type_pn',get_name_lable_row('type_pn'),$value,'text',array(),'','input-group','','input-group-addon'); ?>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <?php $value=( isset($project) ? number_format($project->cost,0,"0",".") : ''); ?>
                                                                        <?php echo render_input( 'cost', get_name_lable_row('cost'),$value,'text',array('onkeyup'=>"formart_money_contract('cost')"),'','input-group','','input-group-addon'); ?>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group input-group">
                                                                            <label for="tags" class="control-label input-group-addon"><i class="fa fa-tag" aria-hidden="true"></i> <?php echo _l('tags'); ?></label>
                                                                            <input type="text" class="tagsinput tagit-hidden-field" id="tags" name="tags" value="<?php echo (isset($project) ? prep_tags_input(get_tags_in($project->id,'project_bds')) : ''); ?>" data-role="tagsinput">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <?php $value=( isset($project) ? $project->expires : ''); ?>
                                                                        <?php echo render_date_input( 'expires', get_name_lable_row('expires'),$value,'text',array(),'input-group','','input-group-addon'); ?>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <?php $value=( isset($project) ? $project->bathroom : ''); ?>
                                                                        <?php echo render_input('bathroom', get_name_lable_row('bathroom'),$value,'text',array(),'','input-group','','input-group-addon'); ?>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <?php $value=( isset($project) ? $project->detail_price : ''); ?>
                                                                        <?php echo render_input( 'detail_price', get_name_lable_row('detail_price'),$value,'text',array(),'','input-group','','input-group-addon'); ?>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <?php $value = (isset($project) ? $project->bonus : '');?>
                                                                        <?php echo render_input( 'bonus', get_name_lable_row('bonus'),$value,'text',array(),'','input-group','','input-group-addon'); ?>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <?php $value=( isset($project) ? $project->watch_house : ''); ?>
                                                                        <?php echo render_input( 'watch_house', get_name_lable_row('watch_house'),$value,'text',array(),'','input-group','','input-group-addon'); ?>
                                                                    </div>

                                                                    <div class="col-md-3">
                                                                        <?php $value=( isset($project) ? $project->convenient : ''); ?>
                                                                        <?php echo render_input( 'convenient',  get_name_lable_row('convenient'),$value,'text',array(),'','input-group','','input-group-addon'); ?>
                                                                    </div>




                                                                    <div class="col-md-3">
                                                                        <?php $selected=( isset($project) ? $project->door_direction : ''); ?>
                                                                        <?php echo render_select( 'door_direction',$door_direction,array('id','name'),get_name_lable_row('door_direction_name'),$selected,array(),'','input-group','',true,'input-group-addon'); ?>
                                                                    </div>
                                                                    <div class="col-md-3"></div>
                                                                    <div class="col-md-3">
                                                                        <div class="note">
                                                                            <?php $value=( isset($project) ? $project->note : ''); ?>
                                                                            <?php echo render_textarea( 'note',get_name_lable_row('note'),$value,array('rows'=>'5'),'',''); ?>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </fieldset>

                                                        </div>

                                                    </div>
                                                    <?php echo form_close(); ?>
                                            </div>

                                            <?php if(isset($id_bds)){?>
                                            <div role="tabpanel" class="tab-pane" id="file_project">
                                                <div class="col-md-6">
                                                    <div class="col-md-12 well">
                                                        <div class="form-group">
                                                        <?php echo form_open_multipart(admin_url('newview/upload_file/'.$id_bds),array('class'=>'dropzone','id'=>'upload_file_project','onchange'=>'get_delete(this)')); ?>
                                                        <input type="file" name="file" multiple />
                                                        <?php echo form_close(); ?>
                                                        <div class="text-right mtop15">
                                                            <div id="dropbox-chooser"></div>
                                                        </div>
                                                        <style>
                                                            .table-image {
                                                                width: 93%;
                                                                height: 100%;
                                                            }
                                                            .dz-message{
                                                                margin: 0px!important;
                                                            }
                                                            .dropzone{min-height: 50px!important;}
                                                        </style>
                                                        <div id="imagas_project_view" class="mtop30">
                                                            <div class="row">
                                                                <?php echo form_open(admin_url().'newview/sendemail',array('id'=>'send_email_images','class'=>'send_email_images','autocomplete'=>'off')); ?>
                                                                    <div class="preview_image" style="width: auto;">
                                                                        <?php foreach($images_project as  $img){
                                                                            $type=pathinfo(base_url()."uploads/project_bds/".$img['file'],PATHINFO_EXTENSION);
                                                                            ?>
                                                                            <div class="col-md-4 display-block contract-attachment-wrapper img-<?=$img['id']?>">
                                                                                <div class="">
                                                                                    <div class="checkbox mass_select_all_wrap">
                                                                                        <input type="checkbox" value="<?=$img['file']?>" >
                                                                                        <label></label>
                                                                                    </div>
                                                                                    <div class="col-md-2 text-right r_delete">
                                                                                        <a href="javacript:void(0)" class="text-danger" onclick="delete_file(<?=$img['id']?>,this)"><i class="fa fa fa-times"></i></a>
                                                                                    </div>
                                                                                    <a href="<?=base_url()?>uploads/project_bds/<?=$img['file']?>" data-lightbox="customer-profile" class="display-block mbot5">
                                                                                        <div class="table-image">
                                                                                            <img  src="<?=base_url().'uploads/project_bds/'.$img['file']?>">
                                                                                        </div>
                                                                                    </a>

                                                                                </div>

                                                                                <div class="clearfix"></div><hr/>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <button type="button" class="btn btn-danger btn-lg" onclick="delete_check_file()"><i class="glyphicon glyphicon-trash"></i></button>
                                                                        <button type="button" class="btn btn-info btn-lg" data-toggle="modal" onclick="get_images()" data-target="#get_sendemail"><i class="glyphicon glyphicon-envelope"></i></button>
                                                                        <div id="get_sendemail" class="modal fade" role="dialog">
                                                                            <div class="modal-dialog">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                                        <h4 class="modal-title">Gửi email </h4>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        <div class="form-group">
                                                                                            <label for="email" class="control-label"><i class="fa fa-tag" aria-hidden="true"></i> <?php echo _l('Email'); ?></label>
                                                                                            <input type="text" class="tagsemail tagit-hidden-field" id="tagsemail" name="email"  data-role="tagsemail">

                                                                                            <label for="email" class="control-label"><i class="fa fa-tag" aria-hidden="true"></i> <?php echo _l('Email CC'); ?></label>
                                                                                            <input type="text" class="tagsemail tagit-hidden-field" id="email_to_cc" name="email_to_cc"  data-role="tagsemail">

                                                                                            <label for="email" class="control-label"><i class="fa fa-tag" aria-hidden="true"></i> <?php echo _l('Email BC'); ?></label>
                                                                                            <input type="text" class="tagsemail tagit-hidden-field" id="email_to_cc" name="email_to_cc"  data-role="tagsemail">
                                                                                            <?php echo render_input('theme','Chủ đề','','');?>
                                                                                            <div class="radio radio-primary radio-inline">
                                                                                                <input type="radio" name="watermark" value="1">
                                                                                                <label>Đóng dấu hình ảnh</label>
                                                                                            </div>
                                                                                            <div class="radio radio-primary radio-inline">
                                                                                                <input type="radio" name="watermark" value="2">
                                                                                                <label>Đóng dấu văn bản</label>
                                                                                            </div>
                                                                                            <input type="hidden" id="images_send" name="images_send"  data-role="tagsemail">
                                                                                            <p class="bold">Nội dung email</p>
                                                                                            <?php echo render_textarea('description','','',array('data-task-ae-editor'=>true),array(),'','content_email'); ?>
                                                                                        </div>
                                                                                        <div class="form-group get_images">
                                                                                        </div>
                                                                                        <div class="clearfix"></div>
                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                        <button type="submit" id="btn_send_email" class="btn btn-info">Gửi</button>
                                                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                                    </div>
                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                <?php echo form_close(); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="col-md-12 well">
                                                        <form id="video" action="<?=admin_url()?>newview/upload_video/<?=$id_bds?>" method="post">
                                                            <?php echo render_input( 'name', 'Tên video',''); ?>
                                                            <?php echo render_textarea( 'file', 'Mã nhúng video Youtube','',array('rows'=>8)); ?>
                                                            <button id="save_video" class="btn btn-info mtop20 only-save customer-form-submiter">
                                                                Lưu
                                                            </button>
                                                        </form>

                                                        <div id="video_project_view" class="mtop30">
                                                        <div class="row">
                                                            <style>
                                                                iframe{
                                                                    width: 100%!important;
                                                                    margin: 0!important;
                                                                }
                                                            </style>
                                                            <?php foreach($video_project as  $_video){
                                                                ?>
                                                                <div class="display-block contract-attachment-wrapper img-<?=$_video['id']?>" >
                                                                    <div class="col-md-10">
                                                                        <a data-toggle="modal" data-target="#preview_video" onclick="load_video(<?=$_video['id']?>)">
                                                                            <div class="pull-left"><i class="mime mime-video"></i></div>
                                                                            <div>
                                                                                <?=$_video['name']?>
                                                                            </div>

                                                                            <p class="text-muted"><?=$type?></p>
                                                                        </a>
                                                                    </div>
                                                                    <div class="col-md-2 text-right r_delete">
                                                                        <a href="javacript:void(0)" class="text-danger" onclick="delete_file(<?=$_video['id']?>,this)"><i class="fa fa fa-times"></i></a>
                                                                    </div>
                                                                    <div class="clearfix"></div><hr/>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <div class="modal fade" id="preview_video" role="dialog">
                                                            <div class="modal-dialog modal-lg">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                        <h4 class="modal-title title_video"></h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="watch_video">

                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    </div>

                                                </div>

                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="review_host">
                                                <?php include_once(APPPATH . 'views/admin/newview/master.php');?>

                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="tab_call_logs">
                                                <a href="#"  onclick="view_update_or_add_call(0)" class="btn btn-info btn-xs" data-toggle="modal" data-target="#model_call_logs"><?php echo _l('Thêm nhật ký cuộc gọi')?></a>
                                                <a class="btn btn-danger mright5 test" onclick="_delete_all('table-call-logs','call_logs')" >Xóa số lượng lớn</a>
                                                <div class="clearfix"></div>
                                                <hr />
                                                <?php render_datatable(array(
                                                    '<span class="hide"> - </span><div class="checkbox mass_select_all_wrap"><input type="checkbox" id="mass_select_all" data-to-table="call-logs"><label></label></div>',
                                                    _l( 'Thời gian thực hiện cuộc gọi'),
                                                    _l( 'Ghi chú'),
                                                    _l( 'Nhân viên thực hiện cuộc gọi'),
                                                    _l( 'options'),
                                                    ), 'call-logs'); ?>

                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="review_log">
                                                <div class="activity-feed">
                                                    <?php foreach($log_bds as $log){ ?>
                                                        <div class="feed-item">
                                                            <div class="date">
                                                                <?=$log['date']?>
                                                            </div>
                                                            <div class="text">
                                                                <?php echo get_staff_full_name($log['staffid']); ?><br />
                                                                <?php echo $log['name']; ?></div>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>

                                            <div role="tabpanel" class="tab-pane" id="people_take">
                                                <a href="#" class="btn btn-info btn-xs" data-toggle="modal" data-target="#model_people_take"><?php echo _l('Thêm quản trị viên')?></a>
                                                <div class="clearfix"></div>
                                                <hr />
                                                <?php render_datatable(array(
                                                    _l( 'Thời gian Chỉ định'),
                                                    _l( 'Nhân viên quản trị viên'),
                                                    _l( 'Người Tạo'),
                                                    _l( 'options')
                                                , ), 'people-take'); ?>

                                            </div>
                                        </div>
                                        <?php }?>
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
<?php include_once(APPPATH . 'views/admin/newview/model_project.php');?>
<script>
    init_editor('.content_email',{height:200});
    $(function() {
        _validate_form($('#send_email_images'), {
            tagsemail: 'required',
            theme: 'required'
        }, sendemail);
    });
    function sendemail(form) {
        $('#btn_send_email').html('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
        var data = $(form).serialize();
        var url = form.action;
        $.post(url, data).done(function(response) {
            console.log(response);
            response=JSON.parse(response);
            if(response.success){
                alert_float('success', response.message);
                $('#btn_send_email').html('Gửi');
                $('#get_sendemail').modal('hide');
            }
            else
            {
                alert_float('danger', response.message);
                $('#btn_send_email').html('Gửi');
            }
        });
        return false;
    }
    function get_images()
    {
        $('.get_images').html('');
        $('#images_send').val('');
        check_images=$('#imagas_project_view input[type="checkbox"]:checked');
        $.each($(check_images),function( index, value ){
            $('.get_images').append('<div class="col-md-2"><img style="max-width:100px;" src="<?=base_url()?>uploads/project_bds/'+value.value+'"></div>');
            now_images=$('#images_send').val();
            $('#images_send').val(now_images+','+value.value);
        })
    }
    function delete_check_file()
    {
        if (confirm('Bạn có muốn xóa hình ảnh đã chọn?')){
            $('.get_images').html('');
            $('#images_send').val('');
            check_images=$('#imagas_project_view input[type="checkbox"]:checked');
            var images= [];
            $.each($(check_images),function( index, value ){
                images[index]=value.value;
            })
            var file_delete=images.toString();
            jQuery.ajax({
                type: "post",
                dataType: "json",
                url: "<?=admin_url()?>newview/delete_check_file/<?=$id_bds?>",
                data: {file_delete:file_delete},
                cache: false,
                success: function (data) {
                    if(data.success) {
                        alert_float('success', data.message);
                        $.each($(check_images),function( index, value ){
                            $("#imagas_project_view .row").load(location.href + " #imagas_project_view .row #send_email_images");
                        });
                    }
                    else
                    {
                        alert_float('danger','Không tìm thấy ảnh cần xóa');
                    }

                }
            });
        }

    }




    $(function() {
        <?php if(isset($project)){?>
            <?php if($project->type_deadline==1||$project->type_deadline==3||$project->type_deadline==4){?>
                $('#type_1').prop('checked','true');
                $('#review_true').collapse('show');
                    <?php if($project->type_deadline==3){?>
                        $('#type_3').prop('checked','true');
                        $('#time_true').collapse('show');
                        $('#time_not').collapse('hide');
                    <?php }?>
                    <?php if($project->type_deadline==4){?>
                        $('#type_4').prop('checked','true');
                        $('#time_true').collapse('hide');
                        $('#time_not').collapse('show');
                    <?php }?>

            <?php } else{?>
                $('#type_<?=$project->type_deadline?>').prop('checked','true');
                $('#time_true').collapse('hide');
                $('#time_not').collapse('hide');
                $('#review_true').collapse('hide');
        <?php }}?>
    })


    initDataTable('.table-call-logs','<?=admin_url()?>newview/init_relation_logs/<?php echo $id_bds; ?>' , [0], [0]);
    initDataTable('.table-master_bds_profile','<?=admin_url()?>newview/init_relation_master_bds/<?php echo $id_bds; ?>/0' , [0], [0]);
    initDataTable('.table-master_bds_company','<?=admin_url()?>newview/init_relation_master_bds/<?php echo $id_bds; ?>/1' , [0], [0]);
    initDataTable('.table-people-take','<?=admin_url()?>newview/init_relation_take/<?php echo $id_bds; ?>' , [3], [3]);
</script>
<?php include_once(APPPATH . 'views/admin/newview/script_project.php');?>
</body>
</html>
