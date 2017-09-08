<!-- Copy Project -->
<div class="modal fade" id="pre_invoice_project_settings" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    <?php echo _l('invoice_project_info'); ?>
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php
                            if(!$this->projects_model->timers_started_for_project($project_id,array('billable'=>1,'billed'=>0,'startdate <='=>date('Y-m-d')),array('end_time'=>NULL))){ ?>
                        <div class="row">
                            <div class="col-md-10">
                                <div class="radio radio-primary">
                                    <input type="radio" <?php if($billing_type == 3){echo 'disabled';}else{echo 'checked';}?> name="invoice_data_type" value="single_line" id="single_line">
                                    <label for="single_line"><?php echo _l('invoice_project_data_single_line'); ?></label>
                                </div>
                            </div>
                            <div class="col-md-2 mtop10 text-right">
                                <a href="#" class="text-muted" data-toggle="popover" data-placement="bottom" data-content="<b><?php echo _l('invoice_project_item_name_data'); ?>:</b> <?php echo _l('invoice_project_project_name_data'); ?><br /><b><?php echo _l('invoice_project_description_data'); ?>:</b> <?php echo _l('invoice_project_all_tasks_total_logged_time'); ?>" data-html="true"><i class="fa fa-question-circle"></i></a>
                            </div>
                            <div class="col-md-10">
                                <div class="radio radio-primary">
                                    <input type="radio" name="invoice_data_type" <?php if($billing_type == 3){echo 'checked';} if($billing_type == 1){echo 'disabled';} ?>  value="task_per_item" id="task_per_item">
                                    <label for="task_per_item"><?php echo _l('invoice_project_data_task_per_item'); ?></label>
                                </div>
                            </div>
                            <div class="col-md-2 mtop10 text-right">
                                <a href="#" class="text-muted" data-toggle="popover" data-placement="bottom" data-content="<b><?php echo _l('invoice_project_item_name_data'); ?>:</b> <?php echo _l('invoice_project_projectname_taskname'); ?><br /><b><?php echo _l('invoice_project_description_data'); ?>:</b> <?php echo _l('invoice_project_total_logged_time_data'); ?>" data-html="true"><i class="fa fa-question-circle"></i></a>
                            </div>
                            <div class="col-md-10">
                                <div class="radio radio-primary">
                                    <input type="radio" name="invoice_data_type" <?php if($billing_type == 1){echo 'disabled';} ?> value="timesheets_individualy" id="timesheets_individualy">
                                    <label for="timesheets_individualy"><?php echo _l('invoice_project_data_timesheets_individualy'); ?></label>
                                </div>
                            </div>
                            <div class="col-md-2 mtop10 text-right">
                                <a href="#" class="text-muted" data-toggle="popover" data-placement="bottom" data-content="<b><?php echo _l('invoice_project_item_name_data'); ?>:</b> <?php echo _l('invoice_project_projectname_taskname'); ?><br /><b><?php echo _l('invoice_project_description_data'); ?>:</b> <?php echo _l('invoice_project_timesheet_indivudualy_data'); ?>" data-html="true"><i class="fa fa-question-circle"></i></a>
                            </div>
                        </div>
                        <?php if(total_rows('tblstafftasks',array('rel_id'=>$project_id,'rel_type'=>'project','startdate >'=>date('Y-m-d'))) > 0){ ?>
                        <p class="text-info mtop10"><?php echo _l('invoice_project_start_date_tasks_not_passed'); ?></p>
                        <?php } ?>
                        <?php if(count($billable_tasks) == 0 && count($not_billable_tasks) == 0 && count($expenses) == 0){ ?>
                        <p class="text-danger"><?php echo _l('invoice_project_nothing_to_bill'); ?></p>
                        <?php } else { ?>
                        <hr />
                        <a href="#" onclick="slideToggle('#tasks_who_will_be_billed'); return false;"><b><?php echo _l('invoice_project_see_billed_tasks'); ?></b></a>
                        <div style="display:none;" id="tasks_who_will_be_billed">
                            <div class="checkbox">
                                <input type="checkbox" id="project_invoice_select_all_tasks" class="invoice_select_all_tasks">
                                <label for="project_invoice_select_all_tasks"><?php echo _l('project_invoice_select_all_tasks'); ?></label>
                            </div>
                            <hr />
                            <?php foreach($billable_tasks as $task){
                                if($task['status'] != 5){$not_finished_tasks_found = true;}
                                ?>
                            <div class="checkbox checkbox-primary">
                                <input type="checkbox" name="tasks[]" value="<?php echo $task['id']; ?>" checked id="<?php echo $task['id']; ?>">
                                <label class="inline-block full-width" for="<?php echo $task['id']; ?>"><?php echo $task['name']; ?> <?php if(total_rows('tbltaskstimers',array('task_id'=>$task['id'])) == 0){echo '<small class="text-danger">'._l('project_invoice_task_no_timers_found').'</small>';}; ?><small class="pull-right valign"><?php echo format_task_status($task['status']); ?></small></label>
                            </div>
                            <?php } ?>
                            <?php foreach($not_billable_tasks as $task){ ?>
                            <div class="checkbox checkbox-primary">
                                <input type="checkbox" name="tasks[]"  value="<?php echo $task['id']; ?>" id="<?php echo $task['id']; ?>">
                                <label for="<?php echo $task['id']; ?>"><?php echo $task['name']; ?> <small><?php echo _l('invoice_project_tasks_not_started',_d($task['startdate'])); ?></small></label>
                            </div>
                            <?php } ?>
                        </div>
                        <?php
                        if(count($expenses) > 0){ ?>
                         <br /><a href="#" onclick="slideToggle('#expenses_who_will_be_billed'); return false;"><span class="bold">
                         <?php echo _l('invoice_project_see_billed_expenses'); ?>
                         </span></a>
                           <div style="display:none;" id="expenses_who_will_be_billed">
                              <div class="checkbox">
                            <input type="checkbox" id="project_invoice_select_all_expenses" class="invoice_select_all_expenses">
                                <label for="project_invoice_select_all_expenses"><?php echo _l('project_invoice_select_all_expenses'); ?></label>
                            </div>
                            <hr />
                           <?php foreach($expenses as $data){
                            $expense = $this->expenses_model->get($data['id']);
                            $total = $expense->amount;
                            if($expense->tax != 0){
                                $_total = ($total / 100 * $expense->taxrate);
                                $total += $_total;
                            }
                            ?>
                            <div class="checkbox checkbox-primary">
                             <input type="checkbox" name="expenses[]" checked value="<?php echo $expense->expenseid; ?>" id="expense_<?php echo $expense->expenseid; ?>">
                            <label for="expense_<?php echo $expense->expenseid; ?>">
                            <?php echo $expense->category_name; ?> - <?php echo format_money($total,$expense->currency_data->symbol); ?>
                            </label>
                            </div>
                            <?php } ?>
                           </div>
                        <?php } ?>
                        <?php if(isset($not_finished_tasks_found)){ ?>
                        <hr />
                        <p class="text-danger"><?php echo _l('invoice_project_all_billable_tasks_marked_as_finished'); ?></p>
                        <?php } ?>
                        <?php } ?>
                        <?php } else { $timers_started = true; ?>
                        <p class="text-danger text-center">
                            <?php echo _l('project_invoice_timers_started'); ?>
                        </p>
                        <hr />
                        <div class="col-md-6 text-center">
                            <a href="#" onclick="mass_stop_timers(true);return false;" class="btn btn-default"><?php echo _l('invoice_project_stop_billabe_timers_only'); ?></a>
                        </div>
                        <div class="col-md-6 text-center">
                            <a href="#" onclick="mass_stop_timers(false);return false;" class="btn btn-danger"><?php echo _l('invoice_project_stop_all_timers'); ?></a>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
                <?php if(!isset($timers_started)){ ?>
                <button type="submit" class="btn btn-info" onclick="invoice_project(<?php echo $project_id; ?>)"><?php echo _l('invoice_project'); ?></button>
                <?php } ?>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!-- Copy Project end -->
