<div id="task">
    <!-- View task -->

    <div class="task-info pull-left">
        <h5 class="no-margin"><i class="fa pull-left fa-bolt"></i> <?php echo _l('task_single_priority'); ?>: <?php echo task_priority($view_task->priority); ?></h5>
    </div>
    <div class="text-success mleft10 task-info pull-left">
        <h5 class="no-margin"><i class="fa pull-left fa-margin"></i> <?php echo _l('task_single_start_date'); ?>: <?php echo _d($view_task->startdate); ?></h5>
    </div>
    <div class="mleft10 task-info pull-left <?php if(!$view_task->status != 5){echo ' text-danger'; }else{echo 'text-info';} ?><?php if(!$view_task->duedate){ echo ' hide';} ?>">
        <h5 class="no-margin"><i class="fa pull-left fa-calendar"></i> <?php echo _l('task_single_due_date'); ?>: <?php echo _d($view_task->duedate); ?></h5>
    </div>
    <?php if($view_task->status == 5){ ?>
    <div class="mleft10 pull-left task-info text-success">
        <h5 class="no-margin"><i class="fa pull-left fa-check"></i> <?php echo _l('task_single_finished'); ?>: <?php echo _d($view_task->datefinished); ?></h5>
    </div>
    <?php } ?>
    <div class="pull-right mtop5">
        <?php echo format_task_status($view_task->status); ?>
    </div>
    <div class="clearfix"></div>
    <hr class="no-mtop"/>
    <h3 class="no-margin"><?php echo $view_task->name; ?></h3>
    <?php if($project->settings->view_task_total_logged_time == 1){ ?>
    <p class="no-margin text-success"><?php echo _l('task_total_logged_time'); ?>
        <?php echo seconds_to_time_format($this->tasks_model->calc_task_total_time($view_task->id)); ?>
    </p>
    <?php } ?>

    <div class="clearfix"></div>
    <?php if($view_task->billed == 1){
        echo '<p class="text-success no-margin">'._l('task_is_billed',format_invoice_number($view_task->invoice_id)). '</p>';
    } ?>
    <hr />
    <div class="row mbot30">
        <div class="col-md-3">
            <i class="fa fa-users"></i> <span class="bold"><?php echo _l('task_single_assignees'); ?></span>
        </div>
        <div class="col-md-9" id="assignees">
            <?php
            $_assignees = '';
            foreach ($view_task->assignees as $assignee) {
             $_assignees .= '
             <div data-toggle="tooltip" class="pull-left mleft5 task-user" data-title="'.get_staff_full_name($assignee['assigneeid']).'">'
               .staff_profile_image($assignee['assigneeid'], array(
                 'staff-profile-image-small'
                 )) .'</div>';
           }
           if ($_assignees == '') {
               $_assignees = '<div class="task-connectors-no-indicator display-block">'._l('task_no_assignees').'</div>';
           }
           echo $_assignees;
           ?>
       </div>
   </div>
   <?php if($project->settings->view_task_checklist_items == 1){ ?>
   <?php if(count($view_task->checklist_items) > 0){ ?>
   <hr />
   <h4 class="bold mbot15"><?php echo _l('task_checklist_items'); ?></h4>
   <?php } ?>
   <?php foreach($view_task->checklist_items as $list){ ?>
   <p class="<?php if($list['finished'] == 1){echo 'line-throught';} ?>">
    <span class="task-checklist-indicator <?php if($list['finished'] == 1){echo 'text-success';} else{echo 'text-muted';} ?>"><i class="fa fa-check"></i></span>&nbsp;
    <?php echo $list['description']; ?>
</p>
<?php } ?>
<?php } ?>
<?php
$custom_fields = get_custom_fields('tasks',array('show_on_client_portal'=>1));
if(count($custom_fields) > 0){ ?>
<div class="row">
    <?php foreach($custom_fields as $field){ ?>
    <?php $value = get_custom_field_value($task->id,$field['id'],'tasks');
    if($value == ''){continue;} $custom_fields_found = true;?>
    <div class="col-md-9">
        <span class="bold"><?php echo ucfirst($field['name']); ?></span>
        <br />
        <div class="text-left">
            <?php echo $value; ?>
        </div>
    </div>
    <?php } ?>
    <?php
    // Add separator if custom fields found for output
    if(isset($custom_fields_found)){?>
    <div class="clearfix"></div>
    <hr />
    <?php } ?>
</div>
<?php } ?>
<?php if($project->settings->view_task_attachments == 1){ ?>
<?php if(count($view_task->attachments) > 0){ ?>
<hr />
<div class="row">
    <div class="col-md-12">
        <h4 class="bold font-medium"><?php echo _l('task_view_attachments'); ?></h4>
        <div class="row">
            <?php foreach($view_task->attachments as $attachment){ ?>
            <div class="col-md-4">
               <ul class="list-unstyled">
                <li class="mbot10 task-attachment">
                    <div class="mbot10 pull-right task-attachment-user">
                       <?php
                       if($attachment['staffid'] != 0){
                        echo get_staff_full_name($attachment['staffid']);
                    } else {
                        echo get_contact_full_name($attachment['contact_id']);
                    }
                    ?>
                    <?php if(get_option('allow_contact_to_delete_files') == 1 && $attachment['contact_id'] == get_contact_user_id()){ ?>
                    <a href="<?php echo site_url('clients/delete_file/'.$attachment['id'].'/task?project_id='.$project->id); ?>" class="text-danger _delete pull-right"><i class="fa fa-remove"></i></a>
                    <?php } ?>
                </div>
                <?php
                $is_image = false;
                $path = get_upload_path_by_type('task') . $view_task->id . '/'. $attachment['file_name'];
                $href_url = site_url('download/file/taskattachment/'. $attachment['id']);

                if(empty($attachment['external'])){
                    $is_image = is_image($path);
                    $img_url = site_url('download/preview_image?path='.protected_file_url_by_path($path).'&type='.$attachment['filetype']);
                } else if(!empty($attachment['thumbnail_link']) || !empty($attachment['external'])){
                    if(!empty($attachment['thumbnail_link'])){
                        $is_image = true;
                        $img_url = optimize_dropbox_thumbnail($attachment['thumbnail_link']);
                    }
                    $href_url = $attachment['external_link'];
                }
                if($is_image){
                    echo '<div class="preview_image">';
                }

                ?>
                <a href="<?php echo $href_url; ?>" class="pull-left">
                    <?php if($is_image){ ?>
                    <img src="<?php echo $img_url; ?>" class="img img-responsive">
                    <?php } else { ?>
                    <i class="<?php echo get_mime_class($attachment['filetype']); ?>"></i> <?php echo $attachment['file_name']; ?>
                    <?php } ?>
                </a>

                <?php if($is_image){
                    echo '</div>';
                }
                ?>
                <div class="clearfix"></div>
            </li>
        </ul>
    </div>
    <?php } ?>
</div>
</div>
</div>
<?php } ?>
<?php } ?>
<?php if(!empty($view_task->description)){ ?>
<hr />
<h4 class="bold"><?php echo _l('task_view_description'); ?></h4>
<?php echo $view_task->description; ?>
<?php } ?>

<?php if($project->settings->upload_files == 1){ ?>
<hr />
<?php echo form_open_multipart(site_url('clients/project/'.$project->id),array('class'=>'dropzone mtop15','id'=>'task-file-upload')); ?>
<input type="file" name="file" multiple class="hide"/>
<input type="hidden" name="task_id" value="<?php echo $view_task->id; ?>" class="hide"/>
<?php echo form_close(); ?>
<?php if(get_option('dropbox_app_key') != ''){ ?>
<div class="text-right mtop15">
    <div id="dropbox-chooser-task"></div>
</div>
<?php } ?>
<?php } ?>
<?php if($project->settings->view_task_comments == 1){ ?>
<hr />
<h4 class="bold mbot15"><?php echo _l('task_view_comments'); ?></h4>
<?php
if(count($view_task->comments) > 0){
  echo '<div id="task-comments">';
  foreach($view_task->comments as $comment){ ?>
  <div class="mbot10 mtop10" data-commentid="<?php echo $comment['id']; ?>">
    <?php if($comment['staffid'] != 0){ ?>
    <?php echo staff_profile_image($comment['staffid'], array(
        'staff-profile-image-small',
        'media-object img-circle pull-left mright10'
        )); ?>
        <?php } else { ?>
        <img src="<?php echo contact_profile_image_url($comment['contact_id']); ?>" class="client-profile-image-small media-object img-circle pull-left mright10">
        <?php } ?>
        <div class="media-body">
            <?php if($comment['staffid'] != 0){ ?>
            <span class="bold"><?php echo get_staff_full_name($comment['staffid']); ?></span><br />
            <?php } else { ?>
            <span class="pull-left bold">
                <?php echo get_contact_full_name($comment['contact_id']); ?></span>
                <br />
                <?php } ?>
                <?php if($comment['contact_id'] != 0){ ?>
                <?php
                $comment_added = strtotime($comment['dateadded']);
                $minus_1_hour = strtotime('-1 hours');
                if(get_option('client_staff_add_edit_delete_task_comments_first_hour') == 0 || (get_option('client_staff_add_edit_delete_task_comments_first_hour') == 1 && $comment_added >= $minus_1_hour)){ ?>
                <a href="#" onclick="remove_task_comment(<?php echo $comment['id']; ?>); return false;" class="pull-right">
                    <i class="fa fa-times text-danger"></i>
                </a>
                <a href="#" onclick="edit_task_comment(<?php echo $comment['id']; ?>); return false;" class="pull-right mright5">
                    <i class="fa fa-pencil-square-o"></i>
                </a>
                <div data-edit-comment="<?php echo $comment['id']; ?>" class="hide">
                    <textarea rows="5" class="form-control mtop10 mbot10"><?php echo clear_textarea_breaks($comment['content']); ?></textarea>
                    <button type="button" class="btn btn-info pull-right" onclick="save_edited_comment(<?php echo $comment['id']; ?>)">
                        <?php echo _l('submit'); ?>
                    </button>
                    <button type="button" class="btn btn-default pull-right mright5" onclick="cancel_edit_comment(<?php echo $comment['id']; ?>)">
                        <?php echo _l('cancel'); ?>
                    </button>
                </div>
                <?php } ?>
                <?php } ?>
                <div class="comment-content" data-comment-content="<?php echo $comment['id'] ;?>"><?php echo check_for_links($comment['content']); ?></div>
                <br />
                <small class="mtop10 text-muted"><?php echo _dt($comment['dateadded']); ?></small>
            </div>
            <hr />
        </div>
        <?php } }
        if($project->settings->comment_on_tasks == 1){
          echo form_open($this->uri->uri_string());
          echo form_hidden('action','new_task_comment');
          echo form_hidden('taskid',$view_task->id);
          ?>
          <textarea name="content" rows="5" class="form-control mtop15"></textarea>
          <button type="submit" class="btn btn-info mtop10 pull-right" data-loading-text="<?php echo _l('wait_text'); ?>" autocomplete="off"><?php echo _l('task_single_add_new_comment'); ?></button>
          <div class="clearfix"></div>
          <?php echo form_close(); } ?>
      </div>
      <?php } ?>
  </div>

