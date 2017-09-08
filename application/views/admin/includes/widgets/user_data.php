  <div class="panel_s user-data">
   <div class="panel-body home-activity">
     <ul class="nav nav-tabs" role="tablist">
      <li role="presentation" class="active">
        <a href="#home_tab_tasks" aria-controls="home_tab_tasks" role="tab" data-toggle="tab">
          <i class="fa fa-tasks menu-icon text-info"></i><?php echo _l('home_my_tasks'); ?>
        </a>
      </li>
      <li role="presentation">
        <a href="#home_my_projects" onclick="init_table_staff_projects(true);" aria-controls="home_my_projects" role="tab" data-toggle="tab">
          <i class="fa fa-bars menu-icon text-info"></i><?php echo _l('home_my_projects'); ?>
        </a>
      </li>
      <?php if((get_option('access_tickets_to_none_staff_members') == 1 && !is_staff_member()) || is_staff_member()){ ?>
      <li role="presentation">
        <a href="#home_tab_tickets" onclick="init_table_tickets(true);" aria-controls="home_tab_tickets" role="tab" data-toggle="tab">
          <i class="fa fa-ticket menu-icon text-info"></i><?php echo _l('home_tickets'); ?>
        </a>
      </li>
      <?php } ?>
      <?php if(is_staff_member()){ ?>
      <li role="presentation">
        <a href="#home_announcements" onclick="init_table_announcements(true);" aria-controls="home_announcements" role="tab" data-toggle="tab">
         <i class="fa fa-bullhorn menu-icon text-info"></i><?php echo _l('home_announcements'); ?>
          <?php if($total_undismissed_announcements != 0){ echo '<span class="badge">'.$total_undismissed_announcements.'</span>';} ?>
        </a>
      </li>
      <?php } ?>
      <?php if(is_admin()){ ?>
      <li role="presentation">
        <a href="#home_tab_activity" aria-controls="home_tab_activity" role="tab" data-toggle="tab">
          <i class="fa fa-window-maximize menu-icon text-info"></i><?php echo _l('home_latest_activity'); ?>
        </a>
      </li>
      <?php } ?>
    </ul>
    <div class="tab-content">
     <div role="tabpanel" class="tab-pane active" id="home_tab_tasks">
      <a href="<?php echo admin_url('tasks/list_tasks'); ?>" class="mbot20 inline-block full-width"><?php echo _l('home_widget_view_all'); ?></a>
      <div class="clearfix"></div>
      <div class="_hidden_inputs _filters _tasks_filters">
        <?php
        echo form_hidden('my_tasks',true);
        foreach($task_statuses as $status){
          $val = 'true';
          if($status == 5){
            $val = '';
          }
          echo form_hidden('task_status_'.$status,$val);
        }
        ?>
      </div>
      <?php $this->load->view('admin/tasks/_table'); ?>
    </div>
    <?php if((get_option('access_tickets_to_none_staff_members') == 1 && !is_staff_member()) || is_staff_member()){ ?>
    <div role="tabpanel" class="tab-pane" id="home_tab_tickets">
     <a href="<?php echo admin_url('tickets'); ?>" class="mbot20 inline-block full-width"><?php echo _l('home_widget_view_all'); ?></a>
     <div class="clearfix"></div>
     <div class="_filters _hidden_inputs hidden tickets_filters">
       <?php
           // On home only show on hold, open and in progress
       echo form_hidden('ticket_status_1',true);
       echo form_hidden('ticket_status_2',true);
       echo form_hidden('ticket_status_4',true);
       ?>
     </div>
     <?php echo AdminTicketsTableStructure(); ?>
   </div>
   <?php } ?>
   <div role="tabpanel" class="tab-pane" id="home_my_projects">
    <a href="<?php echo admin_url('projects'); ?>" class="mbot20 inline-block full-width"><?php echo _l('home_widget_view_all'); ?></a>
    <div class="clearfix"></div>
    <?php render_datatable(array(
      _l('project_name'),
      _l('project_start_date'),
      _l('project_deadline'),
      _l('project_status'),
      ),'staff-projects'); ?>
    </div>
    <?php if(is_staff_member()){ ?>
    <div role="tabpanel" class="tab-pane" id="home_announcements">
      <?php if(is_admin()){ ?>
      <a href="<?php echo admin_url('announcements'); ?>" class="mbot20 inline-block full-width"><?php echo _l('home_widget_view_all'); ?></a>
      <div class="clearfix"></div>
      <?php } ?>
      <?php render_datatable(array(_l('announcement_name'),_l('announcement_date_list'),_l('options')),'announcements'); ?>
    </div>
    <?php } ?>
    <?php if(is_admin()){ ?>
    <div role="tabpanel" class="tab-pane" id="home_tab_activity">
      <a href="<?php echo admin_url('utilities/activity_log'); ?>" class="mbot20 inline-block full-width"><?php echo _l('home_widget_view_all'); ?></a>
      <div class="clearfix"></div>
      <div class="activity-feed">
       <?php foreach($activity_log as $log){ ?>
       <div class="feed-item">
         <div class="date"><?php echo time_ago($log['date']); ?></div>
         <div class="text">
           <?php echo $log['staffid']; ?><br />
           <?php echo $log['description']; ?></div>
         </div>
         <?php } ?>
       </div>
     </div>
     <?php } ?>
   </div>
 </div>
</div>

