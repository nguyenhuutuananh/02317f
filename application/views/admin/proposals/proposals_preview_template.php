<?php echo form_hidden('_attachment_sale_id',$proposal->id); ?>
<?php echo form_hidden('_attachment_sale_type','proposal'); ?>
<div class="panel_s">
   <div class="panel-body">
      <ul class="nav nav-tabs" role="tablist">
         <li role="presentation" class="active">
            <a href="#tab_proposal" aria-controls="tab_proposal" role="tab" data-toggle="tab">
               <?php echo _l('proposal'); ?>
            </a>
         </li>
         <?php if(isset($proposal)){ ?>
         <li role="presentation">
            <a href="#tab_comments" aria-controls="tab_comments" role="tab" data-toggle="tab">
               <?php echo _l('proposal_comments'); ?>
            </a>
         </li>
         <li role="presentation">
            <a href="#tab_reminders" aria-controls="tab_reminders" role="tab" data-toggle="tab">
               <?php echo _l('estimate_reminders'); ?>
            </a>
         </li>
         <li role="presentation">
            <a href="#tab_tasks" aria-controls="tab_tasks" role="tab" data-toggle="tab">
               <?php echo _l('tasks'); ?>
            </a>
         </li>
         <li role="presentation">
            <a href="#tab_views" aria-controls="tab_views" role="tab" data-toggle="tab">
               <?php echo _l('view_tracking'); ?>
            </a>
         </li>
         <li role="presentation">
          <a href="#" onclick="small_table_full_view(); return false;" data-toggle="tooltip" data-title="<?php echo _l('toggle_full_view'); ?>" class="toggle_view">
            <i class="fa fa-expand"></i></a>
         </li>
         <?php } ?>
      </ul>
      <div class="row">
         <div class="col-md-3">
            <?php echo format_proposal_status($proposal->status,'pull-left mright5 mtop5'); ?>
         </div>
         <div class="col-md-9 text-right _buttons proposal_buttons">
            <?php if(has_permission('proposals','','edit')){ ?>
            <a href="<?php echo admin_url('proposals/proposal/'.$proposal->id); ?>" data-placement="left" data-toggle="tooltip" title="<?php echo _l('proposal_edit'); ?>" class="btn btn-default btn-with-tooltip" data-placement="bottom"><i class="fa fa-pencil-square-o"></i></a>
            <?php } ?>
            <a href="<?php echo admin_url('proposals/pdf/'.$proposal->id.'?print=true'); ?>" target="_blank" class="btn btn-default btn-with-tooltip" data-toggle="tooltip" title="<?php echo _l('print'); ?>" data-placement="bottom"><i class="fa fa-print"></i></a>
            <a href="<?php echo admin_url('proposals/pdf/'.$proposal->id); ?>" class="btn btn-default btn-with-tooltip" data-toggle="tooltip" title="<?php echo _l('proposal_pdf'); ?>" data-placement="bottom"><i class="fa fa-file-pdf-o"></i></a>
            <a href="#" class="btn btn-default btn-with-tooltip" data-target="#proposal_send_to_customer" data-toggle="modal"><span data-toggle="tooltip" class="btn-with-tooltip" data-title="<?php echo _l('proposal_send_to_email'); ?>" data-placement="bottom"><i class="fa fa-envelope"></i></span></a>
            <div class="btn-group ">
               <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <?php echo _l('more'); ?> <span class="caret"></span>
               </button>
               <ul class="dropdown-menu dropdown-menu-right">
                  <li>
                     <a href="<?php echo site_url('viewproposal/'.$proposal->id .'/'.$proposal->hash); ?>" target="_blank"><?php echo _l('proposal_view'); ?></a>
                  </li>
                  <?php if($proposal->open_till != NULL && date('Y-m-d') < $proposal->open_till && ($proposal->status == 4 || $proposal->status == 1)) { ?>
                  <li>
                     <a href="<?php echo admin_url('proposals/send_expiry_reminder/'.$proposal->id); ?>"><?php echo _l('send_expiry_reminder'); ?></a>
                  </li>
                  <?php } ?>
                  <li>
                     <a href="#" data-toggle="modal" data-target="#sales_attach_file"><?php echo _l('invoice_attach_file'); ?></a>
                  </li>
                  <?php if(has_permission('proposals','','create')){ ?>
                  <li>
                     <a href="<?php echo admin_url() . 'proposals/copy/'.$proposal->id; ?>"><?php echo _l('proposal_copy'); ?></a>
                  </li>
                  <?php } ?>
                  <?php if($proposal->estimate_id == NULL && $proposal->invoice_id == NULL){ ?>
                  <?php foreach($proposal_statuses as $status){
                     if(has_permission('proposals','','edit')){
                        if($proposal->status != $status){ ?>
                        <li>
                           <a href="<?php echo admin_url() . 'proposals/mark_action_status/'.$status.'/'.$proposal->id; ?>"><?php echo _l('proposal_mark_as',format_proposal_status($status,'',false)); ?></a>
                        </li>
                        <?php
                     } } }?>
                     <?php } ?>
                     <?php if(has_permission('proposals','','delete')){ ?>
                     <li>
                        <a href="<?php echo admin_url() . 'proposals/delete/'.$proposal->id; ?>" class="text-danger delete-text _delete"><?php echo _l('proposal_delete'); ?></a>
                     </li>
                     <?php } ?>
                  </ul>
               </div>
               <?php if($proposal->estimate_id == NULL && $proposal->invoice_id == NULL){ ?>
               <?php if(has_permission('estimates','','create') || has_permission('invoices','','create')){ ?>
               <div class="btn-group">
                  <button type="button" class="btn btn-success dropdown-toggle<?php if($proposal->rel_type == 'customer' && total_rows('tblclients',array('active'=>0,'userid'=>$proposal->rel_id)) > 0){echo ' disabled';} ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     <?php echo _l('proposal_convert'); ?> <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-right">
                     <?php
                     $disable_convert = false;
                     $not_related = false;

                     if($proposal->rel_type == 'lead'){
                      if(total_rows('tblclients',array('leadid'=>$proposal->rel_id)) == 0){
                       $disable_convert = true;
                       $help_text = 'proposal_convert_to_lead_disabled_help';
                    }
                 } else if(empty($proposal->rel_type)){
                    $disable_convert = true;
                    $help_text = 'proposal_convert_not_related_help';
                 }
                 ?>
                 <?php if(has_permission('estimates','','create')){ ?>
                 <li <?php if($disable_convert){ echo 'data-toggle="tooltip" title="'._l($help_text,_l('proposal_convert_estimate')).'"';} ?>><a href="#" <?php if($disable_convert){ echo 'style="cursor:not-allowed;" onclick="return false;"';} else {echo 'data-template="estimate" onclick="convert_template(this); return false;"';} ?>><?php echo _l('proposal_convert_estimate'); ?></a></li>
                 <?php } ?>
                 <?php if(has_permission('invoices','','create')){ ?>
                 <li <?php if($disable_convert){ echo 'data-toggle="tooltip" title="'._l($help_text,_l('proposal_convert_invoice')).'"';} ?>><a href="#" <?php if($disable_convert){ echo 'style="cursor:not-allowed;" onclick="return false;"';} else {echo 'data-template="invoice" onclick="convert_template(this); return false;"';} ?>><?php echo _l('proposal_convert_invoice'); ?></a></li>
                 <?php } ?>
              </ul>
           </div>
           <?php } ?>
           <?php } else {
            if($proposal->estimate_id != NULL){
             echo '<a href="'.admin_url('estimates/list_estimates/'.$proposal->estimate_id).'" class="btn btn-info">'.format_estimate_number($proposal->estimate_id).'</a>';
          } else {
           echo '<a href="'.admin_url('invoices/list_invoices/'.$proposal->invoice_id).'" class="btn btn-info">'.format_invoice_number($proposal->invoice_id).'</a>';
        }
     } ?>
  </div>
</div>
<div class="clearfix"></div>
<hr />
<div class="row">
   <div class="col-md-12">
      <div class="tab-content">
         <div role="tabpanel" class="tab-pane active" id="tab_proposal">
            <div class="row mtop10">
               <div class="col-md-6">
                  <h4 class="bold">
                     <?php
                     $tags = get_tags_in($proposal->id,'proposal');
                     if(count($tags) > 0){
                        echo '<i class="fa fa-tag" aria-hidden="true" data-toggle="tooltip" data-title="'.implode(', ',$tags).'"></i>';
                     }
                     ?>
                     <a href="<?php echo admin_url('proposals/proposal/'.$proposal->id); ?>"><?php echo format_proposal_number($proposal->id); ?></a></h4>
                     <h5 class="bold mbot15 font-medium"><a href="<?php echo admin_url('proposals/proposal/'.$proposal->id); ?>"><?php echo $proposal->subject; ?></a></h5>
                     <address>
                        <span class="bold"><a href="<?php echo admin_url('settings?group=company'); ?>" target="_blank"><?php echo get_option('invoice_company_name'); ?></span></a><br>
                        <?php echo get_option('invoice_company_address'); ?><br>
                        <?php echo get_option('invoice_company_city'); ?>, <?php echo get_option('invoice_company_country_code'); ?> <?php echo get_option('invoice_company_postal_code'); ?><br>
                        <?php if(get_option('invoice_company_phonenumber') != ''){ ?>
                        <?php echo get_option('invoice_company_phonenumber'); ?><br />
                        <?php } ?>
                        <?php if(get_option('company_vat') != ''){ ?>
                        <?php echo _l('company_vat_number').': '. get_option('company_vat'); ?><br />
                        <?php } ?>
                        <?php
                              // check for company custom fields
                        $custom_company_fields = get_company_custom_fields();
                        foreach($custom_company_fields as $field){
                           echo $field['label'] . ': ' . $field['value'] . '<br />';
                        }
                        ?>
                     </address>
                  </div>
                  <div class="col-md-6 text-right">
                     <address>
                        <span class="bold"><?php echo _l('proposal_to'); ?>:</span><br />
                        <?php
                        if($proposal->rel_type == 'lead'){
                         echo '<a href="#" onclick="init_lead('.$proposal->rel_id.'); return false;" data-toggle="tooltip" data-title="'._l('lead').'">'.$proposal->proposal_to.'</a><br />';
                      } else if($proposal->rel_type == 'customer'){
                         echo '<a href="'.admin_url('clients/client/'.$proposal->rel_id).'" data-toggle="tooltip" data-title="'._l('client').'">'.$proposal->proposal_to.'</a><br />';
                      }
                      if(!empty($proposal->address)){
                        echo $proposal->address . '<br />';
                     }
                     if(!empty($proposal->city)){
                        echo $proposal->city;
                     }
                     if(!empty($proposal->state)){
                        echo ', '.$proposal->state;
                     }
                     $country = get_country_short_name($proposal->country);
                     if(!empty($country)){
                        echo '<br />'.$country;
                     }
                     if(!empty($proposal->zip)){
                        echo ', '.$proposal->zip;
                     }
                     if(!empty($proposal->email)){
                        echo '<br /><a href="mailto:'.$proposal->email.'">' . $proposal->email . '</a><br />';
                     }
                     if(!empty($proposal->phone)){
                        echo '<a href="tel:'.$proposal->phone.'">'.$proposal->phone.'</a>';
                     }
                     ?>
                  </address>
                  <?php
                  $custom_fields = get_custom_fields('proposal');
                  foreach($custom_fields as $field){ ?>
                  <?php $value = get_custom_field_value($proposal->id,$field['id'],'proposal');
                  if($value == ''){continue;} ?>
                  <br /> <span class="bold"><?php echo ucfirst($field['name']); ?>: </span><?php echo $value; ?>
                  <?php } ?>
               </div>
            </div>
            <hr />
            <?php
            if(count($proposal->attachments) > 0){ ?>
            <p class="bold"><?php echo _l('proposal_files'); ?></p>
            <?php foreach($proposal->attachments as $attachment){
              $attachment_url = site_url('download/file/sales_attachment/'.$attachment['attachment_key']);
              if(!empty($attachment['external'])){
                 $attachment_url = $attachment['external_link'];
              }
              ?>
              <div class="mbot15 row" data-attachment-id="<?php echo $attachment['id']; ?>">
               <div class="col-md-8">
                  <div class="pull-left"><i class="<?php echo get_mime_class($attachment['filetype']); ?>"></i></div>
                  <a href="<?php echo $attachment_url; ?>" target="_blank"><?php echo $attachment['file_name']; ?></a>
                  <br />
                  <small class="text-muted"> <?php echo $attachment['filetype']; ?></small>
               </div>
               <div class="col-md-4 text-right">
                  <?php if($attachment['visible_to_customer'] == 0){
                     $icon = 'fa-toggle-off';
                     $tooltip = _l('show_to_customer');
                  } else {
                     $icon = 'fa-toggle-on';
                     $tooltip = _l('hide_from_customer');
                  }
                  ?>
                  <a href="#" data-toggle="tooltip" onclick="toggle_file_visibility(<?php echo $attachment['id']; ?>,<?php echo $proposal->id; ?>,this); return false;" data-title="<?php echo $tooltip; ?>"><i class="fa <?php echo $icon; ?>" aria-hidden="true"></i></a>
                  <?php if($attachment['staffid'] == get_staff_user_id() || is_admin()){ ?>
                  <a href="#" class="text-danger" onclick="delete_proposal_attachment(<?php echo $attachment['id']; ?>); return false;"><i class="fa fa-times"></i></a>
                  <?php } ?>
               </div>
            </div>
            <?php } ?>
            <?php } ?>
            <div class="clearfix"></div>
            <?php if(isset($proposal_merge_fields)){ ?>
            <p class="bold"><a href="#" onclick="slideToggle('.avilable_merge_fields'); return false;"><?php echo _l('available_merge_fields'); ?></a></p>
            <div class="hide avilable_merge_fields mtop15">
               <div class="row">
                  <div class="col-md-12">
                     <ul class="list-group">
                        <?php foreach($proposal_merge_fields as $field){
                           foreach($field as $f){
                             echo '<li class="list-group-item"><b>'.$f['name'].'</b> <a href="#" class="pull-right" onclick="insert_proposal_merge_field(this); return false;">'.$f['key'].'</a></li>';
                          }
                       } ?>
                    </ul>
                 </div>
              </div>
           </div>
           <?php } ?>
           <div class="editable proposal tc-content" id="proposal_content_area" style="border:1px solid #f0f0f0;">
            <?php if(empty($proposal->content)){
               echo '<span class="text-danger text-uppercase mtop15 editor-add-content-notice"> ' . _l('click_to_add_content') . '</span>';
            } else {
               echo $proposal->content;
            }
            ?>
         </div>
      </div>
      <div role="tabpanel" class="tab-pane" id="tab_comments">
         <div class="row proposal-comments mtop15">
            <div class="col-md-12">
               <div id="proposal-comments"></div>
               <div class="clearfix"></div>
               <textarea name="content" id="comment" rows="8" class="form-control mtop15 proposal-comment"></textarea>
               <button type="button" class="btn btn-info mtop10 pull-right" onclick="add_proposal_comment();"><?php echo _l('proposal_add_comment'); ?></button>
            </div>
         </div>
      </div>
      <div role="tabpanel" class="tab-pane" id="tab_tasks">
         <?php init_relation_tasks_table(array( 'data-new-rel-id'=>$proposal->id,'data-new-rel-type'=>'proposal')); ?>
      </div>
      <div role="tabpanel" class="tab-pane" id="tab_reminders">
         <a href="#" data-toggle="modal" class="btn btn-info btn-xs" data-target=".reminder-modal-proposal-<?php echo $proposal->id; ?>"><i class="fa fa-bell-o"></i> <?php echo _l('proposal_set_reminder_title'); ?></a>
         <hr />
         <?php render_datatable(array( _l( 'reminder_description'), _l( 'reminder_date'), _l( 'reminder_staff'), _l( 'reminder_is_notified'), _l( 'options'), ), 'reminders'); ?>
         <?php $this->load->view('admin/includes/modals/reminder',array('id'=>$proposal->id,'name'=>'proposal','members'=>$members,'reminder_title'=>_l('proposal_set_reminder_title'))); ?>
      </div>
      <div role="tabpanel" class="tab-pane ptop10" id="tab_views">
         <?php
         $views_activity = get_views_tracking('proposal',$proposal->id);
         foreach($views_activity as $activity){ ?>
         <p class="text-success no-margin">
            <?php echo _l('view_date') . ': ' . _dt($activity['date']); ?>
         </p>
         <p class="text-muted">
            <?php echo _l('view_ip') . ': ' . $activity['view_ip']; ?>
         </p>
         <hr />
         <?php } ?>
      </div>
   </div>
</div>
</div>
</div>
</div>
<?php $this->load->view('admin/proposals/send_proposal_to_email_template'); ?>
<script>
   init_btn_with_tooltips();
   init_datepicker();
   init_selectpicker();
   init_form_reminder();
     // defined in manage proposals
     proposal_id = '<?php echo $proposal->id; ?>';
     init_rel_tasks_table(<?php echo $proposal->id; ?>,'proposal');
     initDataTable('.table-reminders', admin_url + 'misc/get_reminders/' + <?php echo $proposal->id ;?> + '/' + 'proposal', [4], [4]);
     init_proposal_editor();
     get_proposal_comments();
  </script>
