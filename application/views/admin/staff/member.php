<?php init_head(); ?>
<div id="wrapper">
 <div class="content">
  <div class="row">
   <?php if(isset($member)){ ?>
   <div class="col-md-12">
    <div class="panel_s">
     <div class="panel-body no-padding-bottom">
      <?php $this->load->view('admin/staff/stats'); ?>
    </div>
  </div>
</div>
<div class="member">
  <?php echo form_hidden('isedit'); ?>
  <?php echo form_hidden('memberid',$member->staffid); ?>
</div>
<?php } ?>
<?php if(isset($member)){ ?>
<div class="col-md-12">
  <div class="panel_s">
   <div class="panel-body">
     <h4 class="no-margin"><?php echo $member->firstname . ' ' . $member->lastname; ?> <a href="#" onclick="small_table_full_view(); return false;" data-placement="left" data-toggle="tooltip" data-title="<?php echo _l('toggle_full_view'); ?>" class="toggle_view pull-right">
      <i class="fa fa-expand"></i></a></h4>
    </div>
  </div>
</div>
<?php } ?>
<?php echo form_open_multipart($this->uri->uri_string(),array('class'=>'staff-form','autocomplete'=>'off')); ?>
<div class="col-md-7" id="small-table">
  <div class="panel_s">
   <div class="panel-body">

     <ul class="nav nav-tabs" role="tablist">
      <li role="presentation" class="active">
       <a href="#tab_staff_profile" aria-controls="tab_staff_profile" role="tab" data-toggle="tab">
        <?php echo _l('staff_profile_string'); ?>
      </a>
    </li>
     <li role="presentation">
       <a href="#tab_staff_contract" aria-controls="tab_staff_contract" role="tab" data-toggle="tab">
        <?php echo _l('Thông tin hợp đồng'); ?>
      </a>
    </li>
    <li role="presentation">
       <a href="#tab_staff_insurrance" aria-controls="tab_staff_insurrance" role="tab" data-toggle="tab">
        <?php echo _l('Thông tin bảo hiểm xã hội thuế'); ?>
      </a>
    </li>
    <li role="presentation">
       <a href="#tab_staff_information" aria-controls="tab_staff_information" role="tab" data-toggle="tab">
        <?php echo _l('Thông tin học vấn - kinh nghiệm'); ?>
      </a>
    </li>
        <li role="presentation">
           <a href="#tab_staff_comment" aria-controls="tab_staff_comment" role="tab" data-toggle="tab">
            <?php echo _l('Ghi chú đánh giá - nhận xét'); ?>
          </a>
        </li>
     <?php
     $_userid = get_staff_user_id();
     if((rule_go($member->staffid,$_userid)&$member->staffid!=$_userid)||(is_admin()&&$_SESSION['rule']==1)) {

     ?>
        <li role="presentation">
         <a href="#tab_staff_permissions" aria-controls="tab_staff_permissions" role="tab" data-toggle="tab">
          <?php echo _l('staff_add_edit_permissions'); ?>
        </a>
      </li>
     <?php }?>
</ul>
<div class="tab-content">

        <div role="tabpanel" class="tab-pane active" id="tab_staff_profile">

        <?php if((isset($member) && $member->profile_image == NULL) || !isset($member)){ ?>
            <div class="form-group">
                <label for="profile_image" class="profile-image"><?php echo _l('staff_edit_profile_image'); ?></label>
                <input type="file" name="profile_image" class="form-control" id="profile_image">
            </div>
            <?php } ?>
            <?php if(isset($member) && $member->profile_image != NULL){ ?>
                <div class="form-group">
                    <div class="row">
                         <div class="col-md-9">
                          <?php echo staff_profile_image($member->staffid,array('img','img-responsive','staff-profile-image-thumb'),'thumb'); ?>
                        </div>
                        <div class="col-md-3 text-right">
                          <a href="<?php echo admin_url('staff/remove_staff_profile_image/'.$member->staffid); ?>"><i class="fa fa-remove"></i></a>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="radio radio-primary radio-inline">
                <input type="radio" name="rule" value="2" onchange="review_nhanvien(this.value)" <?php if($member->rule==2) echo "checked";?>>
                <label><?php echo _l('Trưởng bộ phận'); ?></label>
            </div>

            <div class="radio radio-primary radio-inline">
                <input type="radio" name="rule" value="3" onchange="review_nhanvien(this.value)" <?php if($member->rule==3) echo "checked";?>>
                <label><?php echo _l('Trưởng phòng'); ?></label>
            </div>
            <div class="radio radio-primary radio-inline">
                <input type="radio" name="rule" value="4" onchange="review_nhanvien(this.value)" <?php if($member->rule==4) echo "checked";?>>
                <label><?php echo _l('Nhân viên'); ?></label>
            </div>
            <!--            --><?php //echo render_select('role',$roles,array('roleid','name'),'Nhân viên quản lý',$selected,array('onchange'=>'get_code_staff(this.value,'.$member->staffid.')')); ?>

            <?php
            do_action('staff_render_permissions');
            $selected = '';
            foreach($roles as $role){
                if(isset($member)){
                    if($member->role == $role['roleid']){
                        $selected = $role['roleid'];
                    }
                } else {
                    $default_staff_role = get_option('default_staff_role');
                    if($default_staff_role == $role['roleid'] ){
                        $selected = $role['roleid'];
                    }
                }
            }
            ?>
            <?php echo render_select('role',$roles,array('roleid','name'),'staff_add_edit_role',$selected,array('onchange'=>'get_code_staff(this.value,'.$member->staffid.')')); ?>
            <script>
                function get_code_staff(id,staff_id="")
                {
                    jQuery.ajax({
                        type: "post",
                        dataType: "json",
                        url: "<?=admin_url()?>staff/get_code_staff/"+id+'/'+staff_id,
                        data: '',
                        cache: false,
                        success: function (data) {
                            if(data.code_staff!="")
                            {
                                $('#code_staff').val(data.code_staff);
                            }
                        }
                    });
                    rule=$('input[name="rule"]:checked').val();
                    role=$('#role').val();
                    if(role!="")
                    {
                        jQuery.ajax({
                            type: "post",
                            url: "<?=admin_url()?>staff/get_staff_role/"+role+'/'+rule,
                            data: '',
                            cache: false,
                            success: function (data) {
                                $('#staff_manager').html(data).selectpicker('refresh');
                            }
                        });
                    }


                }
            </script>
            <script>
                function review_nhanvien(code_check)
                {
                    role=$('#role').val();
                    if(role!="")
                    {
                        jQuery.ajax({
                            type: "post",
                            url: "<?=admin_url()?>staff/get_staff_role/"+role+'/'+code_check,
                            data: '',
                            cache: false,
                            success: function (data) {
                                $('#staff_manager').html(data).selectpicker('refresh');
                            }
                        });
                    }
                    role=$('#role').val();
//                    jQuery.ajax({
//                        type: "post",
//                        dataType: "json",
//                        url: "<?//=admin_url()?>//staff/get_code_staff/"+role?>,
//                        data: '',
//                        cache: false,
//                        success: function (data) {
//                            if(data.code_staff!="")
//                            {
//                                $('#code_staff').val(data.code_staff);
//                            }
//                        }
//                    });
                }

            </script>
            <?php $selected_staff_manager = (isset($member) ? $member->staff_manager : ''); ?>
            <?php echo render_select('staff_manager',$staff_manager,array('staffid','name'),'Nhân viên quản lý',$selected_staff_manager,array()); ?>
      <?php $value = (isset($member) ? $member->code_staff : ''); ?>

    <?php echo render_input('code_staff','Mã nhân viên',$value,'text',array('readonly'=>true)); ?>
            <?php $attrs = (isset($member) ? array() : array('autofocus'=>true)); ?>
    <?php $value = (isset($member) ? $member->cmnd : ''); ?>
    <?php echo render_input('cmnd','CMND/CCCD',$value,'number',$attrs); ?><!--CMND-->
    <?php $value = ''; ?>
    <?php echo render_input('firstname','',$value,'text',array('style'=>'display:none;')); ?>
    <?php $value = (isset($member) ? $member->lastname : ''); ?>
    <?php echo render_input('lastname','staff_add_edit_firstname_staff_add_edit_lastname',$value); ?>
    <?php $value = (isset($member) ? $member->birthday : ''); ?>
    <?php echo render_date_input('birthday','ngày sinh',$value); ?><!--ngày sinh-->
      <?php $value = (isset($member) ? $member->birthplace : ''); ?>
    <?php echo render_input('birthplace','Nơi sinh',$value,'text',array('autocomplete'=>'off')); ?><!--Nơi sinh-->
      <?php $selected = (isset($member) ? $member->male : ''); ?>
    <?php echo render_select('male',array(array('id'=>"1",'name'=>"Nam"),array('id'=>"2",'name'=>"Nữ")),array('id','name'),'Giới tính',$selected,array(),array(),'','',false); ?>
      <?php $value = (isset($member) ? $member->daterange : ''); ?>
    <?php echo render_date_input('daterange','Ngày cấp',$value); ?><!--Ngày cấp-->
      <?php $value = (isset($member) ? $member->issued_where : ''); ?>
    <?php echo render_input('issued_where','Nơi cấp',$value); ?><!--Nơi cấp-->

    <?php $selected = (isset($member) ? $member->race : ''); ?>
        <?php $rage=array(
            array('id'=>"1",'name'=>"Kinh"),
            array('id'=>"2",'name'=>"Hoa"),
            array('id'=>"3",'name'=>"Thái"),
            array('id'=>"4",'name'=>"Khác")
        );
        ?>
    <?php $selected = (isset($member) ? $member->race : ''); ?>
    <?php echo render_select('race',$rage,array('id','name'),'Dân tộc',$selected,array(),array(),'','',false); ?>


        <?php $value = (isset($member) ? $member->address : ''); ?>
    <?php echo render_input('address','Địa chỉ cư trú',$value); ?><!--Địa chỉ cư trú-->

      <?php $value = (isset($member) ? $member->phonenumber : ''); ?>
    <?php echo render_input('phonenumber','Số điện thoại liên lạc 1',$value,'number'); ?><!--SDT1-->
      <?php $value = (isset($member) ? $member->numberphone_2 : ''); ?>
    <?php echo render_input('numberphone_2','Số điện thoại liên lạc 2',$value,'number'); ?><!--SDT2-->
      <?php $value = (isset($member) ? $member->address_contact : ''); ?>
    <?php echo render_input('address_contact','Địa chỉ liên hệ',$value); ?><!--Địa chỉ liên hệ-->
      <?php $value = (isset($member) ? $member->email : ''); ?>
    <?php echo render_input('email','Email cá nhân',$value,'email'); ?><!--Email cá nhân-->
      <?php $value = (isset($member) ? $member->contact_person : ''); ?>
    <?php echo render_input('contact_person','Người liên hệ khẩn cấp',$value); ?><!--Người liên hệ khẩn cấp-->
      <?php $value = (isset($member) ? $member->numberphone_contact : ''); ?>
    <?php echo render_input('numberphone_contact','Số ĐT khẩn cấp',$value,'number'); ?><!--Số ĐT khẩn cấp-->
      <?php $value = (isset($member) ? $member->blood_group : ''); ?>
    <?php echo render_input('blood_group','Nhóm máu',$value); ?><!--Nhóm máu-->
        <?php $status_marry=array(
            array('id'=>"1",'name'=>"Độc thân"),
            array('id'=>"2",'name'=>"Có gia đình")
        );
        ?>
      <?php $selected = (isset($member) ? $member->status_marry : ''); ?>
        <?php echo render_select('status_marry',$status_marry,array('id','name'),'Tình trạng hôn nhân',$selected,array(),array(),'','',false); ?><!--Tình trạng hôn nhân-->

    <div class="form-group">
    <label for="hourly_rate"><?php echo _l('staff_hourly_rate'); ?></label>
    <div class="input-group">
    <input type="text" name="hourly_rate" value="<?php if(isset($member)){echo number_format($member->hourly_rate,0,",",".");} else {echo 0;} ?>" id="hourly_rate" onkeyup="formart_money_contract('hourly_rate')" class="form-control">
    <span class="input-group-addon">
    <?php echo $base_currency->symbol; ?>
    </span>
    </div>
    </div>
    <div class="form-group">
    <label for="skype" class="control-label"><i class="fa fa-skype"></i> <?php echo _l('staff_add_edit_skype'); ?></label>
    <input type="text" class="form-control" name="skype" value="<?php if(isset($member)){echo $member->skype;} ?>">
    </div>
    <div class="form-group">
    <label for="default_language" class="control-label"><?php echo _l('localization_default_language'); ?></label>
    <select name="default_language" data-live-search="true" id="default_language" class="form-control selectpicker" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
    <option value=""><?php echo _l('system_default_string'); ?></option>
    <?php foreach(list_folders(APPPATH .'language') as $language){
    $selected = '';
    if(isset($member)){
     if($member->default_language == $language){
       $selected = 'selected';
     }
    }
    ?>
    <option value="<?php echo $language; ?>" <?php echo $selected; ?>><?php echo ucfirst($language); ?></option>
    <?php } ?>
    </select>
    </div>
    <i class="fa fa-question-circle" data-toggle="tooltip" data-title="<?php echo _l('staff_email_signature_help'); ?>"></i>
    <?php $value = (isset($member) ? $member->email_signature : ''); ?>
    <?php echo render_textarea('email_signature','settings_email_signature',$value); ?>
    <div class="form-group">
    <label for="direction"><?php echo _l('document_direction'); ?></label>
    <select class="selectpicker" data-none-selected-text="<?php echo _l('system_default_string'); ?>" data-width="100%" name="direction" id="direction">
    <option value="" <?php if(isset($member) && empty($member->direction)){echo 'selected';} ?>></option>
    <option value="ltr" <?php if(isset($member) && $member->direction == 'ltr'){echo 'selected';} ?>>LTR</option>
    <option value="rtl" <?php if(isset($member) && $member->direction == 'rtl'){echo 'selected';} ?>>RTL</option>
    </select>
    </div>
    <?php $rel_id = (isset($member) ? $member->staffid : false); ?>
    <?php echo render_custom_fields('staff',$rel_id); ?>
    <?php if (is_admin()){ ?>
    <div class="row">
    <div class="col-md-12">
    <hr />
    <div class="checkbox checkbox-primary">
    </div>
    </div>
    </div>
    <?php } ?>
    <?php if(!isset($member)){ ?>
    <?php if(total_rows('tblemailtemplates',array('slug'=>'new-staff-created','active'=>0)) == 0){ ?>
    <div class="checkbox checkbox-primary">
    <input type="checkbox" name="send_welcome_email" id="send_welcome_email" checked>
    <label for="send_welcome_email"><?php echo _l('staff_send_welcome_email'); ?></label>
    </div>
    <?php } ?>
    <?php } ?>
    <div class="clearfix form-group"></div>
    <label for="password" class="control-label"><?php echo _l('staff_add_edit_password'); ?></label>
    <div class="input-group">
    <input type="password" class="form-control password" name="password" autocomplete="off">
    <span class="input-group-addon">
    <a href="#password" class="show_password" onclick="showPassword('password'); return false;"><i class="fa fa-eye"></i></a>
    </span>
    <span class="input-group-addon">
    <a href="#" class="generate_password" onclick="generatePassword(this);return false;"><i class="fa fa-refresh"></i></a>
    </span>
    </div>
    <?php if(isset($member)){ ?>
    <p class="text-muted"><?php echo _l('staff_add_edit_password_note'); ?></p>
    <?php if($member->last_password_change != NULL){ ?>
    <?php echo _l('staff_add_edit_password_last_changed'); ?>: <?php echo time_ago($member->last_password_change); ?>
    <?php } } ?>

        </div>


        <div role="tabpanel" class="tab-pane" id="tab_staff_permissions">
            <div class="checkbox checkbox-primary">
                    <?php
                    $checked = '';
                    if(isset($member)) {
                    if($member->is_not_staff == 1){
                      $checked = ' checked';
                    }
                    }
                    ?>
                <input type="checkbox" value="1" name="is_not_staff" id="is_not_staff" <?php echo $checked; ?>>
                <label for="is_not_staff" data-toggle="tooltip"><?php echo _l('is_not_staff_member'); ?></label>
            </div>
        <?php
        $_userid = get_staff_user_id();
        if((rule_go($member->staffid,$_userid))||(is_admin()&&$_SESSION['rule']==1)) {
        ?>


                <hr />
                 <h4 class="font-medium mbot15 bold"><?php echo _l('staff_add_edit_permissions'); ?></h4>
                 <div class="table-responsive">
                   <table class="table table-bordered roles no-margin">
                    <thead>
                     <tr>
                      <th class="bold"><?php echo _l('permission'); ?></th>
                      <th class="text-center bold"><?php echo _l('permission_view'); ?> (<?php echo _l('permission_global'); ?>)</th>
                      <th class="text-center bold"><?php echo _l('permission_view_own'); ?></th>
                      <th class="text-center bold"><?php echo _l('permission_create'); ?></th>
                      <th class="text-center bold"><?php echo _l('permission_edit'); ?></th>
                      <th class="text-center text-danger bold"><?php echo _l('permission_delete'); ?></th>
                    </tr>
                  </thead>
                  <tbody>
                   <?php
//                   if(isset($member)){
//                     $is_admin = is_admin($member->staffid);
//                   }
                   $conditions = get_permission_conditions();
                   foreach($permissions as $permission){
                     $permission_condition = $conditions[$permission['shortname']];
                     ?>
                     <tr data-id="<?php echo $permission['permissionid']; ?>">
                      <td class="bold">
                       <?php

                       ?>
                       <?php echo _l($permission['name']); ?>
                     </td>
                     <td class="text-center">
                       <?php if($permission_condition['view'] == true){
                        $statement = '';
                        if(isset($is_admin) && $is_admin || isset($member) && has_permission($permission['shortname'],$member->staffid,'view_own') ){
                          $statement = 'disabled';
                        }
                        else if(isset($member) && has_permission($permission['shortname'],$member->staffid,'view')){
                          $statement = 'checked';
                        }
                        ?>
                        <?php
                        if(isset($permission_condition['help'])){
                          echo '<i class="fa fa-question-circle text-danger" data-toggle="tooltip" data-title="'.$permission_condition['help'].'"></i>';
                        }
                        ?>
                         <?php if(has_rule($permission['shortname'],$member->staffid,'view')){?>
                                <div class="checkbox">
                                 <input type="checkbox" data-can-view <?php echo $statement; ?> name="view[]" value="<?php echo $permission['permissionid']; ?>">
                                 <label></label>
                               </div>
                            <?php } ?>
                       <?php } ?>
                     </td>
                     <td class="text-center">
                      <?php if($permission_condition['view_own'] == true){
                       $statement = '';
                       if(isset($is_admin) && $is_admin || isset($member) && has_permission($permission['shortname'],$member->staffid,'view')){
                         $statement = 'disabled';
                       } else if(isset($member) && has_permission($permission['shortname'],$member->staffid,'view_own')){
                         $statement = 'checked';
                       }
                       ?>
                       <?php if(has_rule($permission['shortname'],$member->staffid,'view_own')){?>
                           <div class="checkbox">
                             <input type="checkbox" <?php echo $statement; ?> data-shortname="<?php echo $permission['shortname']; ?>" data-can-view-own name="view_own[]" value="<?php echo $permission['permissionid']; ?>">
                             <label></label>
                           </div>
                       <?php }?>
                       <?php } else if($permission['shortname'] == 'customers'){
                         echo '<i class="fa fa-question-circle mtop15" data-toggle="tooltip" data-title="'._l('permission_customers_based_on_admins').'"></i>';
                       } else if($permission['shortname'] == 'projects'){
                         echo '<i class="fa fa-question-circle mtop25" data-toggle="tooltip" data-title="'._l('permission_projects_based_on_assignee').'"></i>';
                       } else if($permission['shortname'] == 'tasks'){
                         echo '<i class="fa fa-question-circle mtop25" data-toggle="tooltip" data-title="'._l('permission_tasks_based_on_assignee').'"></i>';
                       } else if($permission['shortname'] == 'payments'){
                         echo '<i class="fa fa-question-circle mtop15" data-toggle="tooltip" data-title="'._l('permission_payments_based_on_invoices').'"></i>';
                       } ?>
                     </td>

                     <td  class="text-center">
                      <?php if($permission_condition['create'] == true){
                       $statement = '';
                       if(isset($is_admin) && $is_admin){
                         $statement = 'disabled';
                       } else if(isset($member) && has_permission($permission['shortname'],$member->staffid,'create')){
                         $statement = 'checked';
                       }
                       ?>
                            <?php if(has_rule($permission['shortname'],$member->staffid,'create')){?>
                               <div class="checkbox">
                                 <input type="checkbox" data-shortname="<?php echo $permission['shortname']; ?>" data-can-create <?php echo $statement; ?> name="create[]" value="<?php echo $permission['permissionid']; ?>">
                                 <label></label>
                               </div>
                            <?php } ?>
                       <?php } ?>
                     </td>
                     <td  class="text-center">
                      <?php if($permission_condition['edit'] == true){
                       $statement = '';
                       if(isset($is_admin) && $is_admin){
                         $statement = 'disabled';
                       } else if(isset($member) && has_permission($permission['shortname'],$member->staffid,'edit')){
                         $statement = 'checked';
                       }
                       ?>
                         <?php if(has_rule($permission['shortname'],$member->staffid,'edit')){?>
                           <div class="checkbox">
                             <input type="checkbox" data-shortname="<?php echo $permission['shortname']; ?>" data-can-edit <?php echo $statement; ?> name="edit[]" value="<?php echo $permission['permissionid']; ?>">
                             <label></label>
                           </div>
                          <?php }?>
                       <?php } ?>
                     </td>
                     <td  class="text-center">
                      <?php if($permission_condition['delete'] == true){
                       $statement = '';
                       if(isset($is_admin) && $is_admin){
                        $statement = 'disabled';
                      } else if(isset($member) && has_permission($permission['shortname'],$member->staffid,'delete')){
                        $statement = 'checked';
                      }
                      ?>
                          <?php if(has_rule($permission['shortname'],$member->staffid,'delete')){?>
                              <div class="checkbox checkbox-danger">
                                <input type="checkbox" data-shortname="<?php echo $permission['shortname']; ?>" data-can-delete <?php echo $statement; ?> name="delete[]" value="<?php echo $permission['permissionid']; ?>">
                                <label></label>
                              </div>
                          <?php } ?>
                      <?php } ?>
                    </td>
                  </tr>
                  <?php } ?>
                </tbody>
                </table>
              </div>
        <?php }?>
        </div>



        <div role="tabpanel" class="tab-pane" id="tab_staff_contract">
                <table id="table_staff_contract" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Mã Hợp đồng</th>
                            <th>Hợp đồng</th>
                            <th>Ngày bắt đầu (yyyy-mm-dd)</th>
                            <th>Ngày kết thúc (yyyy-mm-dd)</th>
                            <th><?=_l('options')?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($staff_contract)){ ?>
                            <?php foreach($staff_contract as $con){?>
                                <tr id="contract-<?=$con['id']?>">
                                    <td><input value="<?=$con['code_contract']?>" class="form-control" name="code_contract[]"></td>
                                    <td><input value="<?=$con['name_contract']?>" class="form-control" name="name_contract[]"></td>
                                    <td><input type="text" class="form-control datepicker"  name="staff_contract_date[]" value="<?=$con['date_to']?>"></td>
                                    <td><input type="text" class="form-control datepicker"  name="staff_contract_to_date[]" value="<?=$con['to_date']?>"></td>
                                    <td><a href="javacript:void(0)" onclick="delete_input_contract(<?=$con['id']?>)" class="btn btn-danger btn-icon"><i class="fa fa-remove"></i></a></td>
                                </tr>
                            <?php }?>
                        <?php }?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5"><a href="javascript:void(0)" onclick="addcolum_staff_contract()" class="btn btn-info mright5 test pull-left display-block"><i class="glyphicon glyphicon-plus"></i> Thêm</a></td>
                        </tr>
                    </tfoot>
                </table>
            <script>
                function addcolum_staff_contract()
                {
                    var sothutu=jQuery('tr').length;

                    the_new_tr="";
                    the_new_tr=the_new_tr+'<td><input class="form-control" name="code_contract[]"></td>';
                    the_new_tr=the_new_tr+'<td><input class="form-control" name="name_contract[]"></td>';
                    the_new_tr=the_new_tr+'<td><input type="text" class="form-control datepicker"  name="staff_contract_date[]"></td>';
                    the_new_tr=the_new_tr+'<td><input type="text" class="form-control datepicker"  name="staff_contract_to_date[]"></td>';
                    the_new_tr=the_new_tr+'<td><a href="javacript:void(0)" onclick="delete_tr_contract('+sothutu+')" class="btn btn-danger btn-icon"><i class="fa fa-remove"></i></a></td>';
                    $("#table_staff_contract").append("<tr class='contract_"+sothutu+"'>"+the_new_tr+"</tr>");
                }
                function delete_input_contract(id)
                {
                    $('#contract-'+id).remove();
                }
                function delete_tr_contract(id)
                {
                    $('.contract_'+id).remove();
                }
            </script>

        </div><!--Hợp đồng-->





        <div role="tabpanel" class="tab-pane" id="tab_staff_insurrance">
        <?php $value = (isset($staff_insurrance) ? $staff_insurrance->code_xh : ''); ?>
              <?php echo render_input('code_xh','Số BHXH',$value); ?><!--Số BHXH-->
            <?php $value = (isset($staff_insurrance) ? $staff_insurrance->code_yt : ''); ?>
              <?php echo render_input('code_yt','Số BHYT',$value); ?><!--Số BHYT-->

            <?php $value = (isset($staff_insurrance) ? $staff_insurrance->date_gave : ''); ?>
              <?php echo render_date_input('date_gave','Ngày đóng',$value); ?><!--Ngày đóng-->

            <?php $value = (isset($staff_insurrance) ? $staff_insurrance->level : ''); ?>
              <?php echo render_input('level','Mức đóng',$value); ?><!--Mức đóng-->

            <?php $value = (isset($staff_insurrance) ? $staff_insurrance->mts : ''); ?>
              <?php echo render_input('mts','MST',$value); ?><!--MST-->

            <?php $value = (isset($staff_insurrance) ? $staff_insurrance->date_mts : ''); ?>
              <?php echo render_date_input('date_mts','Ngày cấp MST',$value); ?><!--Ngày cấp MST-->

            <?php $value = (isset($staff_insurrance) ? $staff_insurrance->people_off_1 : ''); ?>
              <?php echo render_input('people_off_1','Người phụ thuộc 1',$value); ?><!--Người phụ thuộc 1-->

            <?php $value = (isset($staff_insurrance) ? $staff_insurrance->relation_1 : ''); ?>
              <?php echo render_input('relation_1','Quan hệ',$value); ?><!--Quan hệ-->

            <?php $value = (isset($staff_insurrance) ? $staff_insurrance->people_off_2 : ''); ?>
              <?php echo render_input('people_off_2','Người phụ thuộc 2',$value); ?><!--Người phụ thuộc 2-->

            <?php $value = (isset($staff_insurrance) ? $staff_insurrance->relation_2 : ''); ?>
              <?php echo render_input('relation_2','Quan hệ 2',$value); ?><!--Quan hệ-->

            <?php $value = (isset($staff_insurrance) ? $staff_insurrance->people_off_3 : ''); ?>
              <?php echo render_input('people_off_3','Người phụ thuộc 3',$value); ?><!--Người phụ thuộc 3-->

            <?php $value = (isset($staff_insurrance) ? $staff_insurrance->relation_3 : ''); ?>
              <?php echo render_input('relation_3','Quan hệ 3',$value); ?><!--Quan hệ-->
        </div>
        <!--Bao hiểm-->


        <div role="tabpanel" class="tab-pane" id="tab_staff_information"><!--Thông tin-->
            <table id="table_staff_information" class="table table-bordered">
                <thead>
                <tr>
                    <th>Thời gian từ (yyyy-mm-dd)</th>
                    <th>Thời gian đến (yyyy-mm-dd)</th>
                    <th>Nơi đào tạo / làm việc</th>
                    <th>Chuyên môn / Vị trí</th>
                    <th><?=_l('options')?></th>
                </tr>
                </thead>
                <tbody>
                    <?php if(isset($staff_information)){ ?>
                        <?php foreach($staff_information as $in){ ?>
                            <tr id="information-<?=$in['id']?>">
                                <td><input  class="form-control datepicker" name="staff_information_date[]" value="<?=$in['date']?>"></td>
                                <td><input  class="form-control datepicker" name="staff_information_to_date[]" value="<?=$in['to_date']?>"></td>
                                <td><input class="form-control" name="staff_information_address_job[]" value="<?=$in['address_job']?>"></td>
                                <td><input class="form-control" name="staff_information_location_work[]" value="<?=$in['location_work']?>"></td>
                                <td><a href="javacript:void(0)" onclick="delete_input_information(<?=$in['id']?>)" class="btn btn-danger btn-icon"><i class="fa fa-remove"></i></a></td>
                            </tr>
                    <?php }}?>

                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="6"><a href="javascript:void(0)" onclick="addcolum_staff_information()" class="btn btn-info mright5 test pull-left display-block"><i class="glyphicon glyphicon-plus"></i> Thêm</a></td>
                    </tr>
                </tfoot>
            </table>
            <script>
                function addcolum_staff_information()
                {
                    var sothutu=jQuery('tr').length;
                    the_new_tr="";
                    the_new_tr=the_new_tr+'<td><input class="form-control datepicker" name="staff_information_date[]"></td>';
                    the_new_tr=the_new_tr+'<td><input class="form-control datepicker" name="staff_information_to_date[]"></td>';
                    the_new_tr=the_new_tr+'<td><input class="form-control" name="staff_information_address_job[]"></td>';
                    the_new_tr=the_new_tr+'<td><input class="form-control" name="staff_information_location_work[]"></td>';
                    the_new_tr=the_new_tr+'<td><a href="javacript:void(0)" onclick="delete_tr_information('+sothutu+')" class="btn btn-danger btn-icon"><i class="fa fa-remove"></i></a></td>';
                    $("#table_staff_information").append("<tr class='information_"+sothutu+"'>"+the_new_tr+"</tr>");


                }
                function delete_input_information(id)
                {
                    $('#information-'+id).remove();
                }
                function delete_tr_information(id)
                {
                    $('.information_'+id).remove();
                }
            </script>
        </div>


        <div role="tabpanel" class="tab-pane" id="tab_staff_comment">
        <!--      -----------------------------------F - GHI CHÚ - ĐÁNH GIÁ - NHẬN XÉT----------------------->
            <?php $value = (isset($staff_comment) ? $staff_comment->comment : ''); ?>
            <?php echo render_textarea('comment','GHI CHÚ - NHẬN XÉT CỦA QUẢN LÝ',$value,array('rows'=>'10')); ?><!--GHI CHÚ - NHẬN XÉT CỦA QUẢN LÝ-->
            <?php if(is_admin()&&$_SESSION['rule']==1){
                $array=array('rows'=>'10');
            }
            else
            {
                $array=array('readonly'=>'readonly','rows'=>'10');
            }?>
                <?php $value = (isset($staff_comment) ? $staff_comment->comment_admin : ''); ?>
              <?php echo render_textarea('comment_admin','GHI CHÚ - NHẬN XÉT CỦA BGĐ',$value,$array); ?><!--GHI CHÚ - NHẬN XÉT CỦA QUẢN LÝ-->

        </div>

</div>

<button type="submit" class="btn btn-info pull-right mtop20"><?php echo _l('submit'); ?></button>
</div>
</div>
</div>
<?php echo form_close(); ?>
<?php if(isset($member)){ ?>
<div class="col-md-5 small-table-right-col">
 <div class="panel_s">

  <div class="panel-body">
    <h4 class="bold no-margin font-medium">
     <?php echo _l('staff_add_edit_notes'); ?>
   </h4>
   <hr />

   <a href="#" class="btn btn-success" onclick="slideToggle('.usernote'); return false;"><?php echo _l('new_note'); ?></a>
   <div class="clearfix"></div>
   <hr />
   <div class="mbot15 usernote hide inline-block full-width">
    <?php echo form_open(admin_url('misc/add_note/'.$member->staffid . '/staff')); ?>
    <?php echo render_textarea('description','staff_add_edit_note_description','',array('rows'=>5)); ?>
    <button class="btn btn-info pull-right mbot15"><?php echo _l('submit'); ?></button>
    <?php echo form_close(); ?>
  </div>
  <div class="clearfix"></div>
  <div class="table-responsive mtop15">
    <table class="table dt-table" data-order-col="2" data-order-type="desc">
     <thead>
      <tr>
       <th width="50%"><?php echo _l('staff_notes_table_description_heading'); ?></th>
       <th><?php echo _l('staff_notes_table_addedfrom_heading'); ?></th>
       <th><?php echo _l('staff_notes_table_dateadded_heading'); ?></th>
       <th><?php echo _l('options'); ?></th>
     </tr>
   </thead>
   <tbody>
    <?php foreach($user_notes as $note){ ?>
    <tr>
     <td width="50%">
      <div data-note-description="<?php echo $note['id']; ?>">
       <?php echo $note['description']; ?>
     </div>
     <div data-note-edit-textarea="<?php echo $note['id']; ?>" class="hide inline-block full-width">
       <textarea name="description" class="form-control" rows="4"><?php echo clear_textarea_breaks($note['description']); ?></textarea>
       <div class="text-right mtop15">
        <button type="button" class="btn btn-default" onclick="toggle_edit_note(<?php echo $note['id']; ?>);return false;"><?php echo _l('cancel'); ?></button>
        <button type="button" class="btn btn-info" onclick="edit_note(<?php echo $note['id']; ?>);"><?php echo _l('update_note'); ?></button>
      </div>
    </div>
  </td>
  <td><?php echo $note['firstname'] . ' ' . $note['lastname']; ?></td>
  <td data-order="<?php echo $note['dateadded']; ?>"><?php echo _dt($note['dateadded']); ?></td>
  <td>
    <?php if($note['addedfrom'] == get_staff_user_id() || has_permission('staff','','delete')){ ?>
    <a href="#" class="btn btn-default btn-icon" onclick="toggle_edit_note(<?php echo $note['id']; ?>);return false;"><i class="fa fa-pencil-square-o"></i></a>
    <a href="<?php echo admin_url('misc/delete_note/'.$note['id']); ?>" class="btn btn-danger btn-icon _delete"><i class="fa fa-remove"></i></a>
    <?php } ?>
  </td>
</tr>
<?php } ?>
</tbody>
</table>
</div>

</div>
</div>
</div>
<?php echo form_close(); ?>
<hr />

</div>
</div>

</div>
<?php } ?>
</div>
</div>
<?php init_tail(); ?>
<script>
 init_roles_permissions();
 $('select[name="role"]').on('change', function() {
  var roleid = $(this).val();
  init_roles_permissions(roleid, true);
});
 $('input[name="administrator"]').on('change',function(){
  var checked = $(this).prop('checked');
  if(checked == true){
   $('.roles').find('input').prop('disabled',true);
 } else {
   $('.roles').find('input').prop('disabled',false);
 }
});
 _validate_form($('.staff-form'),{
//   firstname:'required',
   lastname:'required',
   username:'required',
   cmnd:'required',
   password: {
     required: {
       depends: function(element){
         return ($('input[name="isedit"]').length == 0) ? true : false
       }
     }
   },
   email: {
     required:true,
     email:true,
     remote:{
       url: site_url + "admin/misc/staff_email_exists",
       type:'post',
       data: {
         email:function(){
           return $('input[name="email"]').val();
         },
         memberid:function(){
           return $('input[name="memberid"]').val();
         }
       }

     }
   }
 });
</script>
</body>
</html>
