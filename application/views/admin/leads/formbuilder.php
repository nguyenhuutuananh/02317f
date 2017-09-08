<?php init_head(); ?>
<?php if(isset($form)){
  echo form_hidden('form_id',$form->id);
} ?>
<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="panel_s">
          <div class="panel-body">
           <ul class="nav nav-tabs" role="tablist">
            <?php if(isset($form)){ ?>
            <li role="presentation" class="active">
              <a href="#tab_form_build" aria-controls="tab_form_build" role="tab" data-toggle="tab">
               <?php echo _l('form_builder'); ?>
             </a>
           </li>
           <li role="presentation">
            <a href="#tab_form_information" aria-controls="tab_form_information" role="tab" data-toggle="tab">
             <?php echo _l('form_informations'); ?>
           </a>
         </li>
         <li role="presentation">
          <a href="#tab_form_integration" aria-controls="tab_form_integration" role="tab" data-toggle="tab">
           <?php echo _l('form_integration_code'); ?>
         </a>
       </li>
     </ul>
     <?php } ?>
     <div class="tab-content">
      <?php if(isset($form)){ ?>
      <div role="tabpanel" class="tab-pane active" id="tab_form_build">
       <div class="build-wrap"></div>
     </div>
     <div role="tabpanel" class="tab-pane" id="tab_form_integration">
       <p><?php echo _l('form_integration_code_help'); ?></p>
       <textarea readonly class="form-control" rows="5"><iframe width="600" height="850" src="<?php echo site_url('forms/wtl/'.$form->form_key); ?>" frameborder="0" allowfullscreen></iframe></textarea>
     </div>
     <?php } ?>
     <div role="tabpanel" class="tab-pane<?php if(!isset($form)){echo ' active';} ?>" id="tab_form_information">
       <?php if(!isset($form)){ ?>
       <h4 class="font-medium-xs bold"><?php echo _l('form_builder_create_form_first'); ?></h4>

       <?php } ?>
       <?php echo form_open($this->uri->uri_string(),array('id'=>'form_info')); ?>

       <div class="row">
        <div class="col-md-6">
          <?php $value = (isset($form) ? $form->name : ''); ?>
          <?php echo render_input('name','form_name',$value); ?>

          <?php

          if(get_option('recaptcha_secret_key') != '' && get_option('recaptcha_site_key') != ''){ ?>
          <div class="form-group">
            <label for=""><?php echo _l('form_recaptcha'); ?></label><br />
            <div class="radio radio-inline radio-danger">
              <input type="radio" name="recaptcha" id="racaptcha_0" value="0"<?php if(isset($form) && $form->recaptcha == 0 || !isset($form)){echo ' checked';} ?>>
              <label for="recaptcha_0"><?php echo _l('settings_no'); ?></label>
            </div>
            <div class="radio radio-inline radio-success">
              <input type="radio" name="recaptcha" id="recaptcha_1" value="1"<?php if(isset($form) && $form->recaptcha == 1){echo ' checked';} ?>>
              <label for="recaptcha_1"><?php echo _l('settings_yes'); ?></label>
            </div>
          </div>
          <?php } ?>
          <div class="form-group">
            <label for="active_language" class="control-label"><i class="fa fa-question-circle" data-toggle="tooltip" data-title="<?php echo _l('form_lang_validation_help'); ?>"></i> <?php echo _l('form_lang_validation'); ?></label>
            <select name="language" id="language" class="form-control selectpicker" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
              <option value=""></option>
              <?php foreach($languages as $language){ ?>
              <option value="<?php echo $language; ?>"<?php if((isset($form) && $form->language == $language) || (!isset($form) && get_option('active_language') == $language)){echo ' selected'; } ?>><?php echo ucfirst($language); ?></option>
              <?php } ?>
            </select>
          </div>
          <?php $value = (isset($form) ? $form->submit_btn_name : 'Submit'); ?>
          <?php echo render_input('submit_btn_name','form_btn_submit_text',$value); ?>

          <?php $value = (isset($form) ? $form->success_submit_msg : ''); ?>
          <?php echo render_textarea('success_submit_msg','form_success_submit_msg',$value); ?>

          <div class="checkbox checkbox-primary">
            <input type="checkbox" name="allow_duplicate" id="allow_duplicate" <?php if(isset($form) && $form->allow_duplicate == 1 || !isset($form)){echo 'checked';} ?>>
            <label for="allow_duplicate"><?php echo _l('form_allow_duplicate',_l('leads')); ?></label>
          </div>

          <div class="duplicate-settings-wrapper row<?php if(isset($form) && $form->allow_duplicate == 1 || !isset($form)){echo ' hide';} ?>">
         <div class="col-md-12">
            <hr />
         </div>
           <div class="col-md-6">
            <div class="form-group">
              <label for="track_duplicate_field"><?php echo _l('track_duplicate_by_field'); ?></label><br />
              <select class="selectpicker track_duplicate_field" data-width="100%" name="track_duplicate_field" id="track_duplicate_field" data-none-selected-text="">
                <option value=""></option>
                <?php foreach($db_fields as $field){ ?>
                <option value="<?php echo $field->name; ?>"<?php if(isset($form) && $form->track_duplicate_field == $field->name){echo ' selected';} if(isset($form) && $form->track_duplicate_field_and == $field->name){echo 'disabled';} ?>><?php echo $field->label; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
           <div class="col-md-6">
            <div class="form-group">
              <label for="track_duplicate_field_and"><?php echo _l('and_track_duplicate_by_field'); ?></label><br />
              <select class="selectpicker track_duplicate_field_and" data-width="100%" name="track_duplicate_field_and" id="track_duplicate_field_and" data-none-selected-text="">
                <option value=""></option>
                <?php foreach($db_fields as $field){ ?>
                <option value="<?php echo $field->name; ?>"<?php if(isset($form) && $form->track_duplicate_field_and == $field->name){echo ' selected';} if(isset($form) && $form->track_duplicate_field == $field->name){echo 'disabled';} ?>><?php echo $field->label; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>

<div class="col-md-12">

          <div class="checkbox checkbox-primary">
            <input type="checkbox" name="create_task_on_duplicate" id="create_task_on_duplicate" <?php if(isset($form) && $form->create_task_on_duplicate == 1){echo 'checked';} ?>>
            <label for="create_task_on_duplicate"><i class="fa fa-question-circle" data-toggle="tooltip" data-title="<?php echo _l('create_the_duplicate_form_data_as_task_help'); ?>"></i> <?php echo _l('create_the_duplicate_form_data_as_task',_l('lead_lowercase')); ?></label>
          </div>


</div>

        </div>
      </div>
      <div class="col-md-6">

        <?php
        echo render_select('lead_source',$sources,array('id','name'),'lead_import_source',(isset($form) ? $form->lead_source : get_option('leads_default_source')));
        echo render_select('lead_status',$statuses,array('id','name'),'lead_import_status',(isset($form) ? $form->lead_status : get_option('leads_default_status')));
        $selected = '';
        foreach($members as $staff){
          if(isset($form) && $form->responsible == $staff['staffid']){
            $selected = $staff['staffid'];
          }
        }
        ?>
        <?php echo render_select('responsible',$members,array('staffid',array('firstname','lastname')),'leads_import_assignee',$selected); ?>
        <hr />
        <label for="" class="control-label"><?php echo _l('notification_settings'); ?></label>
        <div class="clearfix"></div>
        <div class="checkbox checkbox-primary">
          <input type="checkbox" name="notify_lead_imported" id="notify_lead_imported" <?php if(isset($form) && $form->notify_lead_imported == 1 || !isset($form)){echo 'checked';} ?>>
          <label for="notify_lead_imported"><?php echo _l('leads_email_integration_notify_when_lead_imported'); ?></label>
        </div>
        <hr />
        <div class="radio radio-primary radio-inline">
          <input type="radio" name="notify_type" value="specific_staff" id="specific_staff" <?php if(isset($form) && $form->notify_type == 'specific_staff' || !isset($form)){echo 'checked';} ?>>
          <label for="specific_staff"><?php echo _l('specific_staff_members'); ?></label>
        </div>
        <div class="radio radio-primary radio-inline">
          <input type="radio" name="notify_type" id="roles" value="roles" <?php if(isset($form) && $form->notify_type == 'roles'){echo 'checked';} ?>>
          <label for="roles"><?php echo _l('staff_with_roles'); ?></label>
        </div>
        <div class="radio radio-primary radio-inline">
          <input type="radio" name="notify_type" id="assigned" value="assigned" <?php if(isset($form) && $form->notify_type == 'assigned'){echo 'checked';} ?>>
          <label for="assigned"><?php echo _l('notify_assigned_user'); ?></label>
        </div>

        <div class="clearfix mtop15"></div>
        <div id="specific_staff_notify" class="<?php if(isset($form) && $form->notify_type != 'specific_staff'){echo 'hide';} ?>">
          <?php
          $selected = array();
          if(isset($form) && $form->notify_type == 'specific_staff'){
            $selected = unserialize($form->notify_ids);
          }
          ?>
          <?php echo render_select('notify_ids_staff[]',$members,array('staffid',array('firstname','lastname')),'leads_email_integration_notify_staff',$selected,array('multiple'=>true)); ?>
        </div>
        <div id="role_notify" class="<?php if(isset($form) && $form->notify_type != 'roles' || !isset($form)){echo 'hide';} ?>">
          <?php
          $selected = array();
          if(isset($form) && $form->notify_type == 'roles'){
            $selected = unserialize($form->notify_ids);
          }
          ?>
          <?php echo render_select('notify_ids_roles[]',$roles,array('roleid',array('name')),'leads_email_integration_notify_roles',$selected,array('multiple'=>true)); ?>
        </div>
      </div>
    </div>
    <hr />
    <button type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
    <?php echo form_close(); ?>
    <div class="clearfix mbot15"></div>
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
  $(function(){
    var formData = <?php echo json_encode($formData); ?>;
    var buildWrap = document.querySelector('.build-wrap'),
    editing = true,
    fbOptions = {
      dataType: 'json'
    };
    if(formData && formData.length){
      fbOptions.formData = formData;
    }
    fbOptions.disableFields = ['autocomplete', 'button', 'checkbox', 'checkbox-group', 'date', 'hidden', 'number', 'radio-group', 'select', 'text', 'textarea'];
    //fbOptions.showActionButtons= false;
    fbOptions.controlPosition = 'left';
    fbOptions.controlOrder = [
    'header',
    'paragraph',
    'file',
    ];
    fbOptions.inputSets = [];
    var db_fields = <?php echo json_encode($db_fields); ?>;
    var cfields = <?php echo json_encode($cfields); ?>;
    $.each(db_fields,function(i,f){
      fbOptions.inputSets.push(f);
    });
    if(cfields && cfields.length){
      $.each(cfields,function(i,f){
       fbOptions.inputSets.push(f);
     });
    }
    $('body').on('click','.del-button',function(){
      var _field = $(this).parents('li.form-field');
      var _preview_name;
      var s = $('.cb-wrap .ui-sortable');
      if(_field.find('.prev-holder input').length > 0){
       _preview_name = _field.find('.prev-holder input').attr('name');
     } else if(_field.find('.prev-holder textarea').length > 0){
      _preview_name = _field.find('.prev-holder textarea').attr('name');
    } else if(_field.find('.prev-holder select').length > 0){
      _preview_name = _field.find('.prev-holder select').attr('name');
    }
    var pos = _preview_name.lastIndexOf('-');
    _preview_name = _preview_name.substr(0, pos);
    if(_preview_name != 'file-input'){
      var formBField =  $('li[type="'+_preview_name+'"]');
      formBField.removeClass('disabled');
    } else {
     setTimeout(function(){
      s.find('li').eq(2).removeClass('disabled');
    },40);
   }
   setTimeout(function(){
     s.sortable({cancel:'.disabled'});
     s.sortable('refresh');
   },80);
 });
    fbOptions.typeUserEvents = {
      text: {
        onadd  :function(fId){
          do_form_field_disabled(fId,'input');
        },
      },
      email: {
        onadd  :function(fId){
          do_form_field_disabled(fId,'input');
        },
      },
      color: {
        onadd  :function(fId){
          do_form_field_disabled(fId,'input');
        },
      },
      date: {
        onadd  :function(fId){
          do_form_field_disabled(fId,'input');
        },
      },
      select: {
        onadd  :function(fId){
          do_form_field_disabled(fId,'select');
        },
      },
      file: {
        onadd:function(fId){
          do_form_field_disabled(fId,'file');
        },
      },
      textarea: {
        onadd  :function(fId){
          do_form_field_disabled(fId,'textarea');
        },
      },
      'checkbox-group': {
        onadd  :function(fId){
          do_form_field_disabled(fId,'checkbox-group');
        },
      },
    }
    $('body').on('blur','.form-field:not([type="header"],[type="paragraph"]) input[name="className"]',function(){
      var className = $(this).val();
      if(className.indexOf('form-control') == -1){
        className += ' form-control';
        $(this).val(className);
      }
    });
    $('body').on('focus','.name-wrap input',function(){
      $(this).blur();
    });
    $('#allow_duplicate').on('change',function(){
      $('.duplicate-settings-wrapper').toggleClass('hide');
    });
    $('#track_duplicate_field,#track_duplicate_field_and').on('change',function(){
      var selector = ($(this).hasClass('track_duplicate_field') ? 'track_duplicate_field_and' : 'track_duplicate_field')
        $('#'+selector+' option').removeAttr('disabled',true);
        $('#'+selector+' option[value="'+$(this).val()+'"]').attr('disabled',true);
        $('#'+selector+'').selectpicker('refresh');
    });
    var formBuilder = $(buildWrap).formBuilder(fbOptions).data('formBuilder');
    $('.form-builder-save').click(function() {
      $.post(admin_url+'leads/save_form_data',{formData:formBuilder.formData,id:$('input[name="form_id"]').val()}).done(function(response){
        response = JSON.parse(response);
        if(response.success == true){
          alert_float('success',response.message);
        }
      });
    });
    _validate_form('#form_info',{
      name:'required',
      lead_source: 'required',
      lead_status: 'required',
      language:'required',
      success_submit_msg:'required',
      submit_btn_name:'required',
      responsible: {
        required: {
          depends:function(element){
            return ($('input[name="notify_type"]:checked').val() == 'assigned') ? true : false
          }
        }
      }
    });
  });

function do_form_field_disabled(fId,type){
  var _field = $(fId);
  var _preview_name;
  var s = $('.cb-wrap .ui-sortable');
  if(type == 'checkbox-group'){
    _preview_name = _field.find('input[type="checkbox"]').eq(0).attr('name');
  } else if (type == 'file'){
    setTimeout(function(){
      s.find('li').eq(2).addClass('disabled');
    },40);
  } else {
   _preview_name = _field.find(type).attr('name');
 }
 if(type != 'file'){
  var pos = _preview_name.lastIndexOf('-');
  _preview_name = _preview_name.substr(0, pos);
  $('[type="'+_preview_name+'"]:not(.form-field)').addClass('disabled');
}
setTimeout(function(){
  s.sortable({cancel:'.disabled'});
  s.sortable('refresh');
},80);
}
</script>
</body>
</html>
