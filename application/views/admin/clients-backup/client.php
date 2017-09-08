<?php init_head(); ?>
<div id="wrapper" class="customer_profile">
 <div class="content">
   <div class="row">
    <div class="col-md-12">
    <?php if(isset($client) && $client->active == 0){ ?>
    <div class="alert alert-warning">
        <?php echo _l('customer_inactive_message'); ?>
        <br />
        <a href="<?php echo admin_url('clients/mark_as_active/'.$client->userid); ?>"><?php echo _l('mark_as_active'); ?></a>
    </div>
    <?php } ?>
    <?php if(isset($client) && $client->leadid != NULL){ ?>
    <div class="alert alert-info">
     <a href="#" onclick="init_lead(<?php echo $client->leadid; ?>); return false;"><?php echo _l('customer_from_lead',_l('lead')); ?></a>
   </div>
   <?php } ?>
   <?php if(isset($client) && (!has_permission('customers','','view') && is_customer_admin($client->userid))){?>
   <div class="alert alert-info">
     <?php echo _l('customer_admin_login_as_client_message',get_staff_full_name(get_staff_user_id())); ?>
   </div>
   <?php } ?>
   </div>
   <?php if(isset($client)){ ?>
   <div class="col-md-3">
     <div class="panel_s">
       <div class="panel-body">
        <?php if(has_permission('customers','','delete') || is_admin()){ ?>
        <div class="btn-group pull-left mright10">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="caret"></span>
          </a>
          <ul class="dropdown-menu dropdown-menu-left">
            <?php if(is_admin()){ ?>
            <li>
              <a href="<?php echo admin_url('clients/login_as_client/'.$client->userid); ?>" target="_blank">
                <i class="fa fa-share-square-o"></i> <?php echo _l('login_as_client'); ?>
              </a>
            </li>
            <?php } ?>
            <?php if(has_permission('customers','','delete')){ ?>
            <li>
              <a href="<?php echo admin_url('clients/delete/'.$client->userid); ?>" class="text-danger delete-text _delete" data-toggle="tooltip" data-title="<?php echo _l('client_delete_tooltip'); ?>" data-placement="bottom"><i class="fa fa-remove"></i> <?php echo _l('delete'); ?>
              </a>
            </li>
            <?php } ?>
          </ul>
        </div>
        <?php } ?>
        <h4 class="customer-heading-profile bold"><?php echo $title; ?></h4>
        <?php $this->load->view('admin/clients/tabs'); ?>
      </div>
    </div>
  </div>
  <?php } ?>
  <div class="col-md-<?php if(isset($client)){echo 9;} else {echo 12;} ?>">
   <div class="panel_s">
     <div class="panel-body">
      <?php if(isset($client)){ ?>
      <?php echo form_hidden( 'isedit'); ?>
      <?php echo form_hidden( 'userid',$client->userid); ?>
      <div class="clearfix"></div>
      <?php } ?>
      <div>
       <div class="tab-content">
        <?php $this->load->view('admin/clients/groups/'.$group); ?>
      </div>
    </div>
  </div>
</div>
</div>
</div>
</div>
</div>
<?php init_tail(); ?>
<?php if(isset($client)){ ?>
<script>
 init_rel_tasks_table(<?php echo $client->userid; ?>,'customer');
</script>
<?php } ?>
<?php if(!empty($google_api_key) && !empty($client->latitude) && !empty($client->longitude)){ ?>
<script>
 var latitude = '<?php echo $client->latitude; ?>';
 var longitude = '<?php echo $client->longitude; ?>';
 var marker = '<?php echo $client->company; ?>';
</script>
<?php echo app_script('assets/js','map.js'); ?>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo $google_api_key; ?>&callback=initMap"></script>
<?php } ?>
<?php $this->load->view('admin/clients/client_js'); ?>
</body>
</html>
