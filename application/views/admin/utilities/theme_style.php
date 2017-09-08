<?php init_head(); ?>
<?php function render_theme_styling_picker($id, $value, $target,$css,$additional = ''){
    echo '<div class="input-group mbot15 colorpicker-component" data-target="'.$target.'" data-css="'.$css.'" data-additional="'.$additional.'">
    <input type="text" value="'.$value.'" data-id="'.$id.'" class="form-control" />
    <span class="input-group-addon"><i></i></span>
</div>';
}
$tags = get_styling_areas('tags');
?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                       <a href="#" onclick="save_theme_style(); return false;" class="btn btn-info">Save</a>
                   </div>
               </div>
           </div>
           <div class="col-md-3">
               <div class="panel_s">
                   <div class="panel-body picker">
                       <ul class="nav nav-tabs navbar-pills nav-stacked" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#tab_admin_styling" aria-controls="tab_admin_styling" role="tab" data-toggle="tab">
                                Admin
                            </a>
                        </li>
                        <li role="presentation">
                            <a href="#tab_customers_styling" aria-controls="tab_customers_styling" role="tab" data-toggle="tab">
                                Customers
                            </a>
                        </li>
                        <li role="presentation">
                            <a href="#tab_buttons_styling" aria-controls="tab_buttons_styling" role="tab" data-toggle="tab">
                                Buttons
                            </a>
                        </li>
                        <li role="presentation">
                            <a href="#tab_tabs_styling" aria-controls="tab_tabs_styling" role="tab" data-toggle="tab">
                                Tabs
                            </a>
                        </li>
                        <li role="presentation">
                            <a href="#tab_modals_styling" aria-controls="tab_modals_styling" role="tab" data-toggle="tab">
                                Modals
                            </a>
                        </li>
                        <li role="presentation">
                            <a href="#tab_general_styling" aria-controls="tab_general_styling" role="tab" data-toggle="tab">
                                General
                            </a>
                        </li>
                        <?php if(count($tags) > 0){ ?>
                        <li role="presentation">
                            <a href="#tab_styling_tags" aria-controls="tab_styling_tags" role="tab" data-toggle="tab">
                                Tags
                            </a>
                        </li>
                        <?php } ?>
                       <li role="presentation">
                           <a href="#tab_styling_images" aria-controls="tab_styling_images" role="tab" data-toggle="tab">
                               Watermark
                           </a>
                       </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-9">
         <div class="panel_s">
            <div class="panel-body pickers">

                <div class="tab-content">
                  <div role="tabpanel" class="tab-pane ptop10 active" id="tab_admin_styling">
                     <div class="row">
                         <div class="col-md-12">
                            <?php
                            foreach(get_styling_areas('admin') as $area){ ?>
                            <label class="bold mbot10 inline-block"><?php echo $area['name']; ?></label>
                            <?php render_theme_styling_picker($area['id'], get_custom_style_values('admin',$area['id']),$area['target'],$area['css'],$area['additional_selectors']); ?>
                            <hr />
                            <?php  } ?>
                        </div>
                    </div>
                </div>
                    <div role="tabpanel" class="tab-pane ptop10 active" id="tab_styling_images">
                     <div class="row">
                         <div class="col-md-12">
                             <?php
                                $water_text=get_colum_option('setting_watermark_text');

                                if($water_text)
                                {
                                    $_data=json_decode($water_text->value);
                                }
                             ?>
                             <div class="col-md-6 well" id="tab-text">
                                 <h4>Cài đặt đóng dấu bằng văn bản</h4>
                                 <div class="panel-body">
                                     <div class="panel-body"  style="height: 100px;">
                                         <p id="review_text"></p>
                                     </div>
                                     <div class="form-group">
                                         <label for="state" class="control-label ">
                                             Văn bản
                                         </label>
                                         <?php $value=( isset($_data) ? $_data->text : ''); ?>
                                         <input type="text" id="text"  name="text" class="form-control" value="<?=$value?>">
                                     </div>
                                     <label for="state" class="control-label ">
                                         Màu chữ
                                     </label>
                                     <?php $value=( isset($_data) ? $_data->color : '#5b5b5b'); ?>
                                     <div class="input-group mbot15 colorpicker-component colorpicker-element"  data-css="background">
                                         <input type="text" value="<?=$value?>"  id="color" name="color" class="form-control">
                                         <span class="input-group-addon"><i style="background-color: <?=$value?>;"></i></span>
                                     </div>
                                    <?php $vitri=array(array('name'=>'bottom'),array('name'=>'top'),array('name'=>'middle'))?>
                                     <?php $select=( isset($_data) ? $_data->vitri : ''); ?>
                                    <?php echo render_select('vitri',$vitri,array('name','name'),'Vị trí',$select)?>

                                    <?php $traiphai=array(array('name'=>'left'),array('name'=>'right'),array('name'=>'center'))?>
                                     <?php $select=( isset($_data) ? $_data->canhvitri : ''); ?>
                                    <?php echo render_select('canhvitri',$traiphai,array('name','name'),'Canh vị trí',$select)?>
                                     <div class="form-group">
                                         <label for="state" class="control-label ">
                                             font-size
                                         </label>
                                         <?php $value=( isset($_data) ? $_data->fontsize : ''); ?>
                                         <input type="text" id="fontsize"  name="fontsize" class="form-control" value="<?=$value?>">
                                     </div>
                                     <a href="#" onclick="save_watermark_text(); return false;" class="btn btn-info">Save</a>
                                 </div>

                             </div>
                             <div class="col-md-6 well" id="tab-images">
                                 <h4>Cài đặt đóng dấu bằng hình ảnh</h4>
                                 <div class="panel-body">
                                     <?php
                                     $water_images=get_colum_option('setting_watermark_images');

                                     if($water_images)
                                     {
                                         $__data=json_decode($water_images->value);
                                     }
                                     ?>
                                     <div class="panel-body" id="div-images" style="height: 100px;"></div>
                                     <div class="form-group">
                                         <form action="<?=admin_url()?>newview/upload_file_logo" class="dropzone dz-clickable" id="upload_file_logo" onchange="get_delete(this)" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                                             <input type="file" name="file" multiple="">
                                             <div class="dz-default dz-message">
                                                 <span>Thả file vào đây để upload</span>
                                             </div>
                                         </form>
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
                                     </div>
                                     <?php $value=( isset($__data) ? $__data->img_logo : ''); ?>
                                     <input type="text" id="img_logo" name="img_logo" class="form-control" value="<?=$value?>">
                                     <?php $vitri=array(array('name'=>'bottom'),array('name'=>'top'),array('name'=>'middle'))?>
                                     <?php $select=( isset($__data) ? $__data->vitri : ''); ?>
                                     <?php echo render_select('vitri',$vitri,array('name','name'),'Vị trí',$select)?>

                                     <?php $select=( isset($__data) ? $__data->canhvitri : ''); ?>
                                     <?php $traiphai=array(array('name'=>'left'),array('name'=>'right'),array('name'=>'center'))?>
                                     <?php echo render_select('canhvitri',$traiphai,array('name','name'),'Canh vị trí',$select)?>
                                     <div class="form-group">
                                         <label for="state" class="control-label ">
                                             Độ mờ hình ảnh
                                         </label>
                                         <?php $value=( isset($__data) ? $__data->opacity : ''); ?>
                                         <input type="text" id="opacity" name="opacity" class="form-control" value="<?=$value?>">
                                     </div>
                                     <div class="form-group">
                                         <div class="col-md-6 form-group">
                                             <label for="state" class="control-label ">
                                                 Chiều cao
                                             </label>
                                             <?php $value=( isset($__data) ? $__data->height : ''); ?>
                                             <input type="text" id="height" name="height" class="form-control" value="<?=$value?>">
                                         </div>
                                         <div class="col-md-6 form-group">
                                             <label for="state" class="control-label ">
                                                 Chiều Rộng
                                             </label>
                                             <?php $value=( isset($__data) ? $__data->width : ''); ?>
                                             <input type="text" id="width" name="width" class="form-control" value="<?=$value?>">
                                        </div>
                                     </div>
                                     <a href="#" onclick="save_watermark_images(); return false;" class="btn btn-info">Save</a>
                                 </div>
                             </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane ptop10" id="tab_customers_styling">
                   <div class="row">
                     <div class="col-md-12">
                        <?php foreach(get_styling_areas('customers') as $area){ ?>
                        <label class="bold mbot10 inline-block"><?php echo $area['name']; ?></label>
                        <?php render_theme_styling_picker($area['id'], get_custom_style_values('customers',$area['id']),$area['target'],$area['css'],$area['additional_selectors']); ?>
                        <hr />
                        <?php  } ?>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane ptop10" id="tab_buttons_styling">
               <div class="row">
                 <div class="col-md-12">
                    <?php foreach(get_styling_areas('buttons') as $area){ ?>
                    <label class="bold mbot10 inline-block"><?php echo $area['name']; ?></label>
                    <?php render_theme_styling_picker($area['id'], get_custom_style_values('buttons',$area['id']),$area['target'],$area['css'],$area['additional_selectors']); ?>
                    <?php if(isset($area['example'])){echo $area['example'];} ?>
                    <div class="clearfix"></div>
                    <hr />
                    <?php  } ?>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane ptop10" id="tab_tabs_styling">
           <div class="row">
             <div class="col-md-12">
                <?php foreach(get_styling_areas('tabs') as $area){ ?>
                <label class="bold mbot10 inline-block"><?php echo $area['name']; ?></label>
                <?php render_theme_styling_picker($area['id'], get_custom_style_values('tabs',$area['id']),$area['target'],$area['css'],$area['additional_selectors']); ?>
                <hr />
                <?php  } ?>
            </div>
        </div>
    </div>
    <div role="tabpanel" class="tab-pane ptop10" id="tab_modals_styling">
       <div class="row">
         <div class="col-md-12">
            <?php foreach(get_styling_areas('modals') as $area){ ?>
            <label class="bold mbot10 inline-block"><?php echo $area['name']; ?></label>
            <?php render_theme_styling_picker($area['id'], get_custom_style_values('modals',$area['id']),$area['target'],$area['css'],$area['additional_selectors']); ?>
            <hr />
            <?php  } ?>
            <div class="modal-content theme_style_modal_example">
              <div class="modal">
                <div class="modal-header">
                    <h4 class="modal-title">Example Modal Heading</h4>
                </div>
                <div class="modal-body">
                    Modal Body
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<div role="tabpanel" class="tab-pane ptop10" id="tab_general_styling">
   <div class="row">
     <div class="col-md-12">
        <?php foreach(get_styling_areas('general') as $area){ ?>
        <label class="bold mbot10 inline-block"><?php echo $area['name']; ?></label>
        <?php render_theme_styling_picker($area['id'], get_custom_style_values('general',$area['id']),$area['target'],$area['css'],$area['additional_selectors']); ?>
        <?php if(isset($area['example'])){echo $area['example'];} ?>
        <hr />
        <?php  } ?>
    </div>
</div>
</div>
<?php if(count($tags) > 0){ ?>
<div role="tabpanel" class="tab-pane ptop10" id="tab_styling_tags">
    <div class="row">
        <div class="col-md-12">
            <?php foreach($tags as $area){ ?>
            <label class="bold mbot10 inline-block"><?php echo $area['name']; ?></label>
            <?php render_theme_styling_picker($area['id'], get_custom_style_values('tags',$area['id']),$area['target'],$area['css'],$area['additional_selectors']); ?>
            <?php if(isset($area['example'])){echo $area['example'];} ?>
            <hr />
            <?php  } ?>
        </div>
    </div>
</div>
<?php  } ?>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<?php init_tail(); ?>
<script>
    var pickers = $('.colorpicker-component');
    $(function() {
        $.each(pickers, function() {
            $(this).colorpicker({
                format: "hex"
            });
            $(this).colorpicker().on('changeColor', function(e) {
                var color = e.color.toHex();
                var _class = 'custom_style_' + $(this).find('input').data('id');
                var val = $(this).find('input').val();
                if (val == '') {
                    $('.' + _class).remove();
                    return false;
                }
                var append_data = '';
                var additional = $(this).data('additional');
                additional = additional.split('+');
                if (additional.length > 0 && additional[0] != '') {
                    $.each(additional, function(i, add) {
                        add = add.split('|');
                        append_data += add[0] + '{' + add[1] + ':' + color + ';}';
                    });
                }
                append_data += $(this).data('target') + '{' + $(this).data('css') + ':' + color + ';}';
                if ($('head').find('.' + _class).length > 0) {
                    $('head').find('.' + _class).html(append_data);
                } else {
                    $("<style />", {
                        class: _class,
                        type: 'text/css',
                        html: append_data
                    }).appendTo("head");
                }
            });
        });
    });

    function save_theme_style() {
        var data = [];
        $.each(pickers, function() {
            var color = $(this).find('input').val();
            if (color != '') {
                var _data = {};
                _data.id = $(this).find('input').data('id');
                _data.color = color;
                data.push(_data);
            }
        });
        $.post(admin_url + 'utilities/save_theme_style', {
            data: JSON.stringify(data)
        }).done(function() {
            window.location.reload();
        });
    }


    Dropzone.options.clientAttachmentsUpload = false;
    if ($('#upload_file_logo').length > 0) {
        new Dropzone('#upload_file_logo', {
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
                response=JSON.parse(response);
                file.previewElement.remove();
                $('#img_logo').val('uploads/watermark/'+response.filename);
                $('#div-images').html('<img style="height:100%" src="<?=base_url()?>uploads/watermark/'+response.filename+'">');
            }
        });
    }


    function save_watermark_text()
    {
        var text=$('#tab-text #text').val();
        var color=$('#tab-text #color').val();
        var vitri=$('#tab-text #vitri').val();
        var canhvitri=$('#tab-text #canhvitri').val();
        var fontsize=$('#tab-text #fontsize').val();
        jQuery.ajax({
            type: "post",
            url:"<?=admin_url()?>newview/setting_images/0",
            data: {text:text,color:color,vitri:vitri,canhvitri:canhvitri,fontsize:fontsize},
            cache: false,
            success: function (data) {
                var obj = JSON.parse(data);
                if(obj.success){
                    alert_float('success', obj.message);

                }
                else
                {
                    alert_float('danger', "Cập nhật không thành công");
                }
            }
        });
    }
    function save_watermark_images()
    {
        var height=$('#tab-images #height').val();
        var width=$('#tab-images #width').val();
        var vitri=$('#tab-images #vitri').val();
        var canhvitri=$('#tab-images #canhvitri').val();
        var opacity=$('#tab-images #opacity').val();
        var img_logo=$('#tab-images #img_logo').val();
        jQuery.ajax({
            type: "post",
            url: "<?=admin_url()?>newview/setting_images/1",
            data: {height:height,width:width,vitri:vitri,canhvitri:canhvitri,opacity:opacity,img_logo:img_logo},
            cache: false,
            success: function (data) {
                var obj = JSON.parse(data);
                if(obj.success){
                    alert_float('success', obj.message);

                }
                else
                {
                    alert_float('danger', "Cập nhật không thành công");
                }
            }
        });
    }

</script>
</body>
</html>
