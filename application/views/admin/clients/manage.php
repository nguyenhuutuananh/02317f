<?php init_head(); ?>
<style>
    th input {
        min-width: 150px;
    }
    .view_people {
        background-color: aliceblue!important;
    }
    .bootstrap-select {
        min-width: 160px!important;
    }
</style>

<style type="text/css"> 
    .select-div{
        position: relative;
        top: 9px;
    }
    select {
        min-width: 130px!important;
    }
    .col-sm-5{
        margin-top: 40px!important;
    }
    .col-sm-7{
        margin-top: 40px!important;
    }
    .DTFC_LeftBodyWrapper{
        background-color: white!important;
    }
    .DTFC_LeftHeadWrapper{
        background-color: white!important;
    }
    .view_people {
        background-color: aliceblue!important;
    }
    .bootstrap-select {
        min-width: 160px!important;
    }
    th, td { white-space: nowrap !important; }
</style>
<link href="<?=base_url()?>assets/css/fixedColumns.dataTables.min.css" rel="stylesheet">
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="_buttons">
                            <?php if (has_permission('customers','','create')) { ?>
                            <a href="<?php echo admin_url('clients/client'); ?>" onclick="openWin()" class="btn btn-info mright5 test pull-left display-block">
                                <?php echo _l('new_client'); ?></a>
                                <a href="<?php echo admin_url('clients/import'); ?>" class="btn btn-info pull-left display-block mright5">
                                    <?php echo _l('import_customers'); ?></a>
                                    <?php } ?>
                                    <div class="visible-xs">
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="btn-group pull-right btn-with-tooltip-group _filter_data" data-toggle="tooltip" data-title="<?php echo _l('filter_by'); ?>">
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-filter" aria-hidden="true"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-left" style="width:300px;">
                                            <li class="active"><a href="#" data-cview="all" onclick="dt_custom_view('','.table-clients',''); return false;"><?php echo _l('customers_sort_all'); ?></a></li>
                                            <li class="divider"></li>
                                            <?php if(count($groups) > 0){ ?>
                                            <li class="dropdown-submenu pull-left groups">
                                                <a href="#" tabindex="-1"><?php echo _l('customer_groups'); ?></a>
                                                <ul class="dropdown-menu dropdown-menu-left">
                                                    <?php foreach($groups as $group){ ?>
                                                    <li><a href="#" data-cview="customer_group_<?php echo $group['id']; ?>" onclick="dt_custom_view('customer_group_<?php echo $group['id']; ?>','.table-clients','customer_group_<?php echo $group['id']; ?>'); return false;"><?php echo $group['name']; ?></a></li>
                                                    <?php } ?>
                                                </ul>
                                            </li>
                                            <div class="clearfix"></div>
                                            <li class="divider"></li>
                                            <?php } ?>
                                            <li class="dropdown-submenu pull-left invoice">
                                                <a href="#" tabindex="-1"><?php echo _l('invoices'); ?></a>
                                                <ul class="dropdown-menu dropdown-menu-left">
                                                    <?php foreach($invoice_statuses as $status){ ?>
                                                    <li>
                                                        <a href="#" data-cview="invoices_<?php echo $status; ?>" data-cview="1" onclick="dt_custom_view('invoices_<?php echo $status; ?>','.table-clients','invoices_<?php echo $status; ?>'); return false;"><?php echo _l('customer_have_invoices_by',format_invoice_status($status,'',false)); ?></a>
                                                    </li>
                                                    <?php } ?>
                                                </ul>
                                            </li>
                                            <div class="clearfix"></div>
                                            <li class="divider"></li>
                                            <li class="dropdown-submenu pull-left estimate">
                                                <a href="#" tabindex="-1"><?php echo _l('estimates'); ?></a>
                                                <ul class="dropdown-menu dropdown-menu-left">
                                                    <?php foreach($estimate_statuses as $status){ ?>
                                                    <li>
                                                        <a href="#" data-cview="estimates_<?php echo $status; ?>" onclick="dt_custom_view('estimates_<?php echo $status; ?>','.table-clients','estimates_<?php echo $status; ?>'); return false;">
                                                            <?php echo _l('customer_have_estimates_by',format_estimate_status($status,'',false)); ?>
                                                        </a>
                                                    </li>
                                                    <?php } ?>
                                                </ul>
                                            </li>
                                            <div class="clearfix"></div>
                                            <li class="divider"></li>
                                            <li class="dropdown-submenu pull-left project">
                                                <a href="#" tabindex="-1"><?php echo _l('projects'); ?></a>
                                                <ul class="dropdown-menu dropdown-menu-left">
                                                    <?php foreach($project_statuses as $status){ ?>
                                                    <li>
                                                        <a href="#" data-cview="projects_<?php echo $status; ?>" onclick="dt_custom_view('projects_<?php echo $status; ?>','.table-clients','projects_<?php echo $status; ?>'); return false;">
                                                            <?php echo _l('customer_have_projects_by',_l('project_status_'.$status)); ?>
                                                        </a>
                                                    </li>
                                                    <?php } ?>
                                                </ul>
                                            </li>
                                            <div class="clearfix"></div>
                                            <li class="divider"></li>
                                            <li class="dropdown-submenu pull-left proposal">
                                                <a href="#" tabindex="-1"><?php echo _l('proposals'); ?></a>
                                                <ul class="dropdown-menu dropdown-menu-left">
                                                    <?php foreach($proposal_statuses as $status){ ?>
                                                    <li>
                                                        <a href="#" data-cview="proposals_<?php echo $status; ?>" onclick="dt_custom_view('proposals_<?php echo $status; ?>','.table-clients','proposals_<?php echo $status; ?>'); return false;">
                                                            <?php echo _l('customer_have_proposals_by',format_proposal_status($status,'',false)); ?>
                                                        </a>
                                                    </li>
                                                    <?php } ?>
                                                </ul>
                                            </li>
                                            <div class="clearfix"></div>
                                            <?php if(count($contract_types) > 0) { ?>
                                            <li class="divider"></li>
                                            <li class="dropdown-submenu pull-left contract_types">
                                                <a href="#" tabindex="-1"><?php echo _l('contract_types'); ?></a>
                                                <ul class="dropdown-menu dropdown-menu-left">
                                                    <?php foreach($contract_types as $type){ ?>
                                                    <li>
                                                        <a href="#" data-cview="contract_type_<?php echo $type['id']; ?>" onclick="dt_custom_view('contract_type_<?php echo $type['id']; ?>','.table-clients','contract_type_<?php echo $type['id']; ?>'); return false;">
                                                            <?php echo _l('customer_have_contracts_by_type',$type['name']); ?>
                                                        </a>
                                                    </li>
                                                    <?php } ?>
                                                </ul>
                                            </li>
                                            <?php } ?>
                                            <?php if(count($customer_admins) > 0 && (has_permission('customers','','create') || has_permission('customers','','edit'))){ ?>
                                            <li class="divider"></li>
                                            <li class="dropdown-submenu pull-left responsible_admin">
                                                <a href="#" tabindex="-1"><?php echo _l('responsible_admin'); ?></a>
                                                <ul class="dropdown-menu dropdown-menu-left">
                                                    <?php foreach($customer_admins as $cadmin){ ?>
                                                    <li>
                                                        <a href="#" data-cview="responsible_admin_<?php echo $cadmin['staff_id']; ?>" onclick="dt_custom_view('responsible_admin_<?php echo $cadmin['staff_id']; ?>','.table-clients','responsible_admin_<?php echo $cadmin['staff_id']; ?>'); return false;">
                                                            <?php echo get_staff_full_name($cadmin['staff_id']); ?>
                                                        </a>
                                                    </li>
                                                    <?php } ?>
                                                </ul>
                                            </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <?php if(has_permission('customers','','view') || have_assigned_customers()) {
                                    $where_summary = '';
                                    if(!has_permission('customers','','view')){
                                        $where_summary = ' AND userid IN (SELECT customer_id FROM tblcustomeradmins WHERE staff_id='.get_staff_user_id().')';
                                    }
                                    ?>
                                    <hr />
                                    <div class="row mbot15">
                                        <div class="col-md-12">
                                            <h3 class="text-success no-margin"><?php echo _l('customers_summary'); ?></h3>
                                        </div>
                                        <div class="col-md-2 col-xs-6 border-right">
                                            <h3 class="bold"><?php echo total_rows('tblclients',($where_summary != '' ? substr($where_summary,5) : '')); ?></h3>
                                            <span class="text-dark"><?php echo _l('customers_summary_total'); ?></span>
                                        </div>
                                        <div class="col-md-2 col-xs-6 border-right">
                                            <h3 class="bold"><?php echo total_rows('tblclients','active=1'.$where_summary); ?></h3>
                                            <span class="text-success"><?php echo _l('active_customers'); ?></span>
                                        </div>
                                        <div class="col-md-2 col-xs-6 border-right">
                                            <h3 class="bold"><?php echo total_rows('tblclients','active=0'.$where_summary); ?></h3>
                                            <span class="text-danger"><?php echo _l('inactive_active_customers'); ?></span>
                                        </div>
                                        <div class="col-md-2 col-xs-6 border-right">
                                            <h3 class="bold"><?php echo total_rows('tblcontacts','active=1'.$where_summary); ?></h3>
                                            <span class="text-info"><?php echo _l('customers_summary_active'); ?></span>
                                        </div>
                                        <div class="col-md-2  col-xs-6 border-right">
                                            <h3 class="bold"><?php echo total_rows('tblcontacts','active=0'.$where_summary); ?></h3>
                                            <span class="text-danger"><?php echo _l('customers_summary_inactive'); ?></span>
                                        </div>
                                        <div class="col-md-2 col-xs-6">
                                            <h3 class="bold"><?php echo total_rows('tblcontacts','last_login LIKE "'.date('Y-m-d').'%"'.$where_summary); ?></h3>
                                            <span class="text-muted"><?php echo _l('customers_summary_logged_in_today'); ?></span>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="_filters _hidden_inputs hidden">
                            <?php
                             foreach($groups as $group){
                                 echo form_hidden('customer_group_'.$group['id']);
                             }
                             foreach($contract_types as $type){
                                 echo form_hidden('contract_type_'.$type['id']);
                             }
                             foreach($invoice_statuses as $status){
                                 echo form_hidden('invoices_'.$status);
                             }
                             foreach($estimate_statuses as $status){
                                 echo form_hidden('estimates_'.$status);
                             }
                             foreach($project_statuses as $status){
                                echo form_hidden('projects_'.$status);
                            }
                            foreach($proposal_statuses as $status){
                                echo form_hidden('proposals_'.$status);
                            }
                            foreach($customer_admins as $cadmin){
                                echo form_hidden('responsible_admin_'.$cadmin['staff_id']);
                            }
                            ?>
                        </div>
                        <div class="panel_s">
                            <div class="panel-body">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a data-toggle="tab" href="#take_care">Đang quan tâm</a></li>
                                    <li><a data-toggle="tab" href="#buy_bds">Thuê/mua</a></li>
                                    <li><a data-toggle="tab" href="#fail_bds">FAIL/Đã thuê mua từ công ty khác</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div id="take_care" class="tab-pane fade in active">
                                        <a href="<?=admin_url()?>clients/client/?type_client=1" class="btn btn-info mbot20 mright5">
                                            Khách hàng mới
                                        </a>
                                        <a href="<?=admin_url()?>clients/settup_table_clients?type_client=1" class="btn btn-default mbot20 btn-icon">
                                            <i class="fa fa-cogs menu-icon"></i>
                                        </a>
                                        <?php include_once(APPPATH . 'views/admin/clients/table_clients/clients_care.php');?>
                                    </div>
                                    <div id="buy_bds" class="tab-pane fade">
                                        <a href="<?=admin_url()?>clients/client/?type_client=2" class="btn btn-info mbot20 mright5">
                                            Khách hàng mới
                                        </a>
                                        <a href="<?=admin_url()?>clients/settup_table_clients?type_client=2" class="btn btn-default mbot20 btn-icon">
                                            <i class="fa fa-cogs menu-icon"></i>
                                        </a>
                                        <?php include_once(APPPATH . 'views/admin/clients/table_clients/clients_buy.php');?>
                                    </div>
                                    <div id="fail_bds" class="tab-pane fade">
                                        <a href="<?=admin_url()?>clients/client/?type_client=3" class="btn btn-info mbot20 mright5">
                                            Khách hàng mới
                                        </a>
                                        <a href="<?=admin_url()?>clients/settup_table_clients?type_client=3" class="btn btn-default mbot20 btn-icon">
                                            <i class="fa fa-cogs menu-icon"></i>
                                        </a>
                                        <?php include_once(APPPATH . 'views/admin/clients/table_clients/clients_fail.php');?>
                                    </div>
                                </div>
                            </div>
                        </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
<script src="<?=base_url()?>assets/js/dataTables.fixedColumns.min.js"></script>

<?php include_once(APPPATH . 'views/admin/clients/manage_js.php');?>
<script>
    var CustomersServerParams = {};
    $.each($('._hidden_inputs._filters input'),function(){
     CustomersServerParams[$(this).attr('name')] = '[name="'+$(this).attr('name')+'"]';
 });
    var headers_clients = $('.table-clients').find('th');
    var not_sortable_clients = (headers_clients.length - 1);
    initDataTable('.table-clients', window.location.href, [not_sortable_clients,0], [not_sortable_clients,0], CustomersServerParams,<?php echo do_action('customers_table_default_order',json_encode(array(1,'ASC'))); ?>);

    function customers_bulk_action(event) {
        var r = confirm(confirm_action_prompt);
        if (r == false) {
            return false;
        } else {
            var mass_delete = $('#mass_delete').prop('checked');
            var ids = [];
            var data = {};
            if(mass_delete == false || typeof(mass_delete) == 'undefined'){
                data.groups = $('select[name="move_to_groups_customers_bulk[]"]').selectpicker('val');
                if (data.groups.length == 0) {
                    data.groups = 'remove_all';
                }
            }
            else {
                data.mass_delete = true;
            }
            var rows = $('.table-clients').find('tbody tr');
            $.each(rows, function() {
                var checkbox = $($(this).find('td').eq(0)).find('input');
                if (checkbox.prop('checked') == true) {
                    ids.push(checkbox.val());
                }
            });
            data.ids = ids;
            $(event).addClass('disabled');
            setTimeout(function(){
              $.post(admin_url + 'clients/bulk_action', data).done(function() {
                 window.location.reload();
             });
          },50);
        }
    }

   $(document).ready(function(){
setInterval(function(){
$("#screen").load('banners.php')
}, 2000);
});


</script>
</body>
</html>
