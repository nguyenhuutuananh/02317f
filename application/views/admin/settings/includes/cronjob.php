<p class="well">
  <span class="bold text-info">CRON COMMAND: wget -q -O- <?php echo site_url('cron/index'); ?></span><br />
  <?php if(is_admin()){ ?>
  <a href="<?php echo admin_url('misc/run_cron_manually'); ?>">Run Cron Manually</a><br />
  <?php } ?>
</p>
<ul class="nav nav-tabs" role="tablist">
  <li role="presentation" class="active">
    <a href="#set_invoice" aria-controls="set_invoice" role="tab" data-toggle="tab"><?php echo _l('settings_sales_cron_invoice_heading'); ?></a>
  </li>
  <li role="presentation">
    <a href="#estimates" aria-controls="estimates" role="tab" data-toggle="tab"><?php echo _l('estimates'); ?></a>
  </li>
  <li role="presentation">
    <a href="#proposals" aria-controls="proposals" role="tab" data-toggle="tab"><?php echo _l('proposals'); ?></a>
  </li>
  <li role="presentation">
    <a href="#contracts" aria-controls="contracts" role="tab" data-toggle="tab"><?php echo _l('contracts'); ?></a>
  </li>
  <li role="presentation">
    <a href="#tasks" aria-controls="tasks" role="tab" data-toggle="tab"><?php echo _l('tasks'); ?></a>
  </li>
  <li role="presentation">
    <a href="#tickets" aria-controls="tickets" role="tab" data-toggle="tab"><?php echo _l('tickets'); ?></a>
  </li>
  <li role="presentation">
    <a href="#surveys" aria-controls="surveys" role="tab" data-toggle="tab"><?php echo _l('settings_cron_surveys'); ?></a>
  </li>
</ul>

<div class="tab-content">
  <div role="tabpanel" class="tab-pane active" id="set_invoice">
    <i class="fa fa-question-circle" data-toggle="tooltip" data-title="<?php echo _l('settings_cron_send_overdue_reminder_tooltip'); ?>"></i>
    <?php render_yes_no_option('cron_send_invoice_overdue_reminder','settings_cron_send_overdue_reminder'); ?>
    <hr />
    <?php echo render_input('settings[automatically_send_invoice_overdue_reminder_after]','automatically_send_invoice_overdue_reminder_after',get_option('automatically_send_invoice_overdue_reminder_after'),'number'); ?>
    <hr />
    <?php echo render_input('settings[automatically_resend_invoice_overdue_reminder_after]','automatically_resend_invoice_overdue_reminder_after',get_option('automatically_resend_invoice_overdue_reminder_after'),'number'); ?>
    <hr />
    <i class="fa fa-question-circle" data-toggle="tooltip" data-title="<?php echo _l('invoices_create_invoice_from_recurring_only_on_paid_invoices_tooltip'); ?>"></i>
    <?php render_yes_no_option('create_invoice_from_recurring_only_on_paid_invoices','invoices_create_invoice_from_recurring_only_on_paid_invoices'); ?>
    <hr />
    <?php render_yes_no_option('send_renewed_invoice_from_recurring_to_email','send_renewed_invoice_from_recurring_to_email'); ?>
    <hr />
    <i class="fa fa-question-circle" data-toggle="tooltip" data-title="<?php echo _l('inv_hour_of_day_perform_auto_operations_help'); ?>"></i>
    <?php echo render_input('settings[invoice_auto_operations_hour]','hour_of_day_perform_auto_operations',get_option('invoice_auto_operations_hour'),'number',array('data-toggle'=>'tooltip','data-title'=>_l('hour_of_day_perform_auto_operations_format'))); ?>
  </div>
  <div role="tabpanel" class="tab-pane" id="tasks">
   <?php echo render_input('settings[tasks_reminder_notification_before]','tasks_reminder_notification_before',get_option('tasks_reminder_notification_before'),'number',array('data-toggle'=>'tooltip','title'=>'tasks_reminder_notification_before_help')); ?>
 </div>
 <div role="tabpanel" class="tab-pane" id="contracts">
   <?php echo render_input('settings[contract_expiration_before]','settings_reminders_contracts',get_option('contract_expiration_before'),'number',array('data-toggle'=>'tooltip','title'=>'settings_reminders_contracts_tooltip')); ?>
 </div>
 <div role="tabpanel" class="tab-pane" id="tickets">
  <i class="fa fa-question-circle" data-toggle="tooltip" data-title="<?php echo _l('auto_close_tickets_disable'); ?>"></i>
  <?php echo render_input('settings[autoclose_tickets_after]','auto_close_ticket_after',get_option('autoclose_tickets_after'),'number'); ?>
</div>
<div role="tabpanel" class="tab-pane" id="estimates">
 <?php render_yes_no_option('estimate_expiry_reminder_enabled','expiry_reminder_enabled'); ?>
 <hr />
 <?php echo render_input('settings[send_estimate_expiry_reminder_before]','send_expiry_reminder_before',get_option('send_estimate_expiry_reminder_before'),'number'); ?>
</div>
<div role="tabpanel" class="tab-pane" id="proposals">
 <?php render_yes_no_option('proposal_expiry_reminder_enabled','expiry_reminder_enabled'); ?>
 <hr />
 <?php echo render_input('settings[send_proposal_expiry_reminder_before]','send_expiry_reminder_before',get_option('send_proposal_expiry_reminder_before'),'number'); ?>
</div>
<div role="tabpanel" class="tab-pane" id="surveys">
  <?php echo render_input('settings[survey_send_emails_per_cron_run]','settings_survey_send_emails_per_cron_run',get_option('survey_send_emails_per_cron_run'),'number',array('data-toggle'=>'tooltip','title'=>'settings_survey_send_emails_per_cron_run_tooltip')); ?>

</div>
</div>


