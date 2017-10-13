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
                                <a href="<?php echo admin_url('clients/import'); ?>" class="btn btn-info pull-left display-block mright5">
                                    <?php echo _l('import_customers'); ?>
                                </a>
                                    <?php } ?>
                                <a href="javacript:void(0)" data-toggle="collapse" data-target="#view_total" class="btn btn-default">
                                    <i class="fa fa-bar-chart"></i>
                                </a>
                                    <div class="visible-xs">
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="btn-group pull-right btn-with-tooltip-group _filter_data" style="display:none;" data-toggle="tooltip" data-title="<?php echo _l('filter_by'); ?>">
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
                                   
                                    <div id="view_total" class="collapse">
                                    <hr />
                                        <div class="row mbot15">
                                            <div class="col-md-12">
                                                <h3 class="text-success no-margin"><?php echo _l('customers_summary'); ?></h3>
                                            </div>
                                            <div class="col-md-3 col-xs-6 border-right">
                                                <h3 class="bold"><?php echo total_rows('tblclients',($where_summary != '' ? substr($where_summary,5) : '')); ?></h3>
                                                <span class="text-dark"><?php echo _l('customers_summary_total'); ?></span>
                                            </div>
                                            <div class="col-md-3 col-xs-6 border-right">
                                                <h3 class="bold"><?php echo total_rows('tblclients','type_client=1'.$where_summary); ?></h3>
                                                <span class="text-info">KHÁCH HÀNG ĐANG QUAN TÂM</span>
                                            </div>
                                            <div class="col-md-3 col-xs-6 border-right">
                                                <h3 class="bold"><?php echo total_rows('tblclients','type_client=2'.$where_summary); ?></h3>
                                                <span class="text-success">KHÁCH HÀNG ĐÃ THUÊ/MUA</span>
                                            </div>
                                            <div class="col-md-3 col-xs-6 border-right">
                                                <h3 class="bold"><?php echo total_rows('tblclients','type_client=3'.$where_summary); ?></h3>
                                                <span class="text-danger">KHÁCH HÀNG ĐÃ FAIL/THUÊ/MUA TỪ CÔNG TY KHÁC</span>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="_filters _hidden_inputs hidden">
                            
                        </div>
                        <div class="panel_s">
                            <div class="panel-body">
                                <a href="<?=admin_url()?>clients/modal_client/?type_client=1" class="btn btn-info mbot20 mright5 btn-new-client">
                                    Tạo mới khách hàng đang quan tâm
                                </a>
                                <a href="<?=admin_url()?>clients/modal_client/?type_client=2" class="btn btn-info mbot20 mright5 btn-new-client">
                                    Tạo mới khách hàng đã mua/thuê
                                </a>
                                <a href="<?=admin_url()?>clients/modal_client/?type_client=3" class="btn btn-info mbot20 mright5 btn-new-client">
                                    Tạo mới khách hàng đã fail
                                </a>
                                <a href="<?=admin_url()?>clients/settup_table_clients?type_client=1" class="btn btn-default mbot20 btn-icon">
                                    <i class="fa fa-cogs menu-icon"></i>
                                </a>
                                <?php
                                $table_data = array(
                                    _l('ID'),
                                );
                                foreach($table_clients as $value) {
                                    $table_data[] = $value->title_th;
                                }
                                $table_data[] = _l('actions');
                                render_datatable($table_data,'clients');
                                ?>
                            </div>
                        </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalClient" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" style="width: 70%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Thông tin khách hàng</h4>
            </div>
            <div class="modal-body">

            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div id="contact_data"></div>


<?php init_tail(); ?>
<script src="<?=base_url()?>assets/js/dataTables.fixedColumns.min.js"></script>

<?php include_once(APPPATH . 'views/admin/clients/manage_js.php');?>
<script>
var view_init_department, new_product, get_district_client, remove_field, append_colum, get_project = function() {};
// init for newpayment
var new_payment,view_payment = function() {};
// init for period
var new_period,send_data_period_form = function() {};
// init for contacts
var contact = function(){};
//format currency
function formatNumber(nStr, decSeperate=".", groupSeperate=",") {
    nStr += '';
    x = nStr.split(decSeperate);
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + groupSeperate + '$2');
    }
    return x1 + x2;
}
function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
const clientTable =  initDataTable('.table-clients', window.location.href, [], [], [], [0, 'DESC']);
$(document).on('click', '.btn-edit-client', function(e) {
    $('#modalClient .modal-body').empty();
    let buttonEdit = $(this).button('loading');
    $.get(admin_url + '/clients/modal_client/' + $(this).attr('data-userid'), function(data) {
        $('#modalClient').attr('data-userid', buttonEdit.attr('data-userid'));
        
        $('#modalClient .modal-body').html(data);
        buttonEdit.button('reset');
        init_selectpicker();
        init_datepicker();
        $('#modalClient').modal('show');
        $('td:has(".clientName")').removeAttr('style');
    });
    e.preventDefault();
});
$(document).on('click', '.btn-new-client', function(e) {
    $('#modalClient .modal-body').empty();
    let buttonNew = $(this).button('loading');
    $.get(buttonNew.attr('href'), function(data) {
        $('#modalClient .modal-body').html(data);
        
        init_selectpicker();
        init_datepicker();

        $('#modalClient').modal('show');
        $('#modalClient').removeAttr('data-userid');
        buttonNew.button('reset');
    });

    e.preventDefault();
});
$(document).on('click', '.btn-close-single-modal', function(e) {
    // console.log($(this).parents('div.modal'));
    // console.log($(this).parents('div.modal:first'));
    
    // Bug ?!
    $(this).parents('div.modal:first').modal('hide');
    $(this).parents('div.modal:first').removeClass('in');
    $(this).parents('div.modal:first').css('display', 'none');
    $(document).find('.modal-backdrop.fade.in:last').remove();
});

$(function() {
    // $(document).on('click', '.modal-backdrop.fade.in', function() {
    //     $(this).remove();
    // });
    $(document).on('click', 'td:has(".clientName")', function() {
        $('.clientName').removeAttr('style');
        $(this).attr('style', 'font-weight: bold');
        $(this).parents('tr').find('td:last-child a.btn-edit-client').trigger('click');
    });
});

$(document).ready(function(){
    setInterval(function(){
        $("#screen").load('banners.php')
    }, 2000);
});


</script>
</body>
</html>