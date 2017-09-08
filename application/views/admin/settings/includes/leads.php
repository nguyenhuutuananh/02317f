    <?php echo render_input('settings[leads_kanban_limit]','settings_leads_kanban_limit',get_option('leads_kanban_limit'),'number'); ?>
       <hr />
       <?php echo render_select('settings[leads_default_status]',$leads_statuses,array('id','name'),'leads_default_status',get_option('leads_default_status')); ?>
       <br />
       <?php echo render_select('settings[leads_default_source]',$leads_sources,array('id','name'),'leads_default_source',get_option('leads_default_source')); ?>
       <hr />
       <i class="fa fa-question-circle" data-toggle="tooltip" data-title="<?php echo _l('auto_assign_customer_admin_after_lead_convert_help'); ?>"></i>
       <?php render_yes_no_option('auto_assign_customer_admin_after_lead_convert','auto_assign_customer_admin_after_lead_convert'); ?>
       <hr />
       <div class="row">
        <div class="col-md-7">
          <label for="defaut_leads_kanban_sort" class="control-label"><?php echo _l('defaut_leads_kanban_sort'); ?></label>
          <select name="settings[defaut_leads_kanban_sort]" id="defaut_leads_kanban_sort" class="selectpicker" data-width="100%" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
            <option value=""></option>
            <option value="dateadded" <?php if(get_option('defaut_leads_kanban_sort') == 'dateadded'){echo 'selected'; }?>><?php echo _l('leads_sort_by_datecreated'); ?></option>
            <option value="leadorder" <?php if(get_option('defaut_leads_kanban_sort') == 'leadorder'){echo 'selected'; }?>><?php echo _l('leads_sort_by_kanban_order'); ?></option>
            <option value="lastcontact" <?php if(get_option('defaut_leads_kanban_sort') == 'lastcontact'){echo 'selected'; }?>><?php echo _l('leads_sort_by_lastcontact'); ?></option>
          </select>
        </div>
        <div class="col-md-5">
         <div class="mtop30 text-right">
          <div class="radio radio-inline radio-primary">
            <input type="radio" id="k_desc" name="settings[defaut_leads_kanban_sort_type]" value="asc" <?php if(get_option('defaut_leads_kanban_sort_type') == 'asc'){echo 'checked';} ?>>
            <label for="k_desc"><?php echo _l('order_ascending'); ?></label>
          </div>
          <div class="radio radio-inline radio-primary">
            <input type="radio" id="k_asc" name="settings[defaut_leads_kanban_sort_type]" value="desc" <?php if(get_option('defaut_leads_kanban_sort_type') == 'desc'){echo 'checked';} ?>>
            <label for="k_asc"><?php echo _l('order_descending'); ?></label>
          </div>
        </div>
      </div>
      <div class="clearfix"></div>
    </div>
    <hr />
    <?php echo render_yes_no_option('lead_lock_after_convert_to_customer','lead_lock_after_convert_to_customer'); ?>
