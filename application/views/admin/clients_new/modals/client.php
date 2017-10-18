<?php
$convert_to = $this->input->get('convert_to');
if(!is_null($convert_to)) {
    
    if($convert_to >= 2 && $convert_to >= 3) {
        redirect('admin/clients');
    }
}
?>
<!-- <a  href="<?= admin_url() ?>clients">
    <button type="button" class="btn btn-default  pull-right">
        Trở lại
    </button>
</a> -->
<!-- <h4 class="bold no-margin"><?php echo _l('Thông tin Khách hàng '); ?></h4> -->
<input type="hidden" name="userid" id="userid" value="<?=$client->userid?>" />
<div class="clearfix">
    <br />
</div>
<div class="row">
    <div class="col-md-3 col-xs-6 border-right text-center">
        <h3 class="bold"><?=number_format($total_item)?></h3>
        <span class="text-info">TỔNG SẢN PHẨM</span>
    </div>
    <div class="col-md-3 col-xs-6 border-right text-center">
        <h3 class="bold"><?=number_format($total_value)?></h3>
        <span class="text-warning">TỔNG CÔNG NỢ</span>
    </div>
    <div class="col-md-3 col-xs-6 border-right text-center">
        <h3 class="bold"><?=number_format($total_value_paid)?></h3>
        <span class="text-success">ĐÃ THANH TOÁN</span>
    </div>
    <div class="col-md-3 col-xs-6 border-right text-center">
        <h3 class="bold"><?=number_format($total_value-$total_value_paid)?></h3>
        <span class="text-danger">CHƯA THANH TOÁN</span>
    </div>
</div>
<div class="clearfix">
    <br />
</div>

<hr class="no-mbot no-border" />
<div class="row">
    <div class="additional"></div>
    <div class="col-md-12">
        <ul class="nav nav-tabs client-tabs" role="tablist">
            <li role="presentation" class="active">
                <a href="#view_project" aria-controls="view_project" role="tab" data-toggle="tab">
                    <?php echo _l('Chi tiết'); ?>
                </a>
            </li>
            <?php
                if(isset($client)) {
            ?>
            <li role="presentation" class="" <?= ($client->clientType != 'congty' ? 'style="display: none;"' : "") ?>>
                <a href="#contacts" aria-controls="contacts" role="tab" data-toggle="tab">
                    <?php echo _l('Thư ký/Trợ lý'); ?>
                </a>
            </li>

            <li role="presentation" class="">
                <a href="#task" aria-controls="task" role="tab" data-toggle="tab">
                    <?php echo _l('Lịch sử chăm sóc KH'); ?>
                </a>
            </li>
            <li role="presentation" class="">
                <a href="#items" aria-controls="task" role="tab" data-toggle="tab">
                    <?php echo _l('Lịch sử mua hàng'); ?>
                </a>
            </li>
            <li role="presentation" class="">
                <a href="#paymenthistory" aria-controls="task" role="tab" data-toggle="tab">
                    <?php echo _l('Lịch sử thanh toán'); ?>
                </a>
            </li>
            <li role="presentation" class="">
                <a href="#attachments" aria-controls="attachments" role="tab" data-toggle="tab">
                    <?php echo _l('File đính kèm'); ?>
                </a>
            </li>
            <li role="presentation" class="">
                <a href="#reminders" aria-controls="reminders" role="tab" data-toggle="tab">
                    <?php echo _l('Nhắc nhở'); ?>
                </a>
            </li>

            
            
            <?php
                }
            ?>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="view_project">
                <?php echo form_open('http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'], array('class' => 'clients-bds-form form-horizontal', 'autocomplete' => 'off')); ?>
                <div class="row">
                    <?php 
                    $convert = $this->input->get('convert');
                    if(is_null($convert)) {
                        ?>
                    <div class="col-md-12">
                        <fieldset>
                            <legend>Khách hàng</legend>
                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                    <?php
                                    $options = array(
                                        array(
                                            'id' => 'honeycomb',
                                            'value' => 'Honeycomb',
                                        ),
                                        array(
                                            'id' => 'moigioi',
                                            'value' => 'Môi giới',
                                        ),
                                    );
                                    $clientFrom = (isset($client) ? $client->clientFrom : '');
                                    echo render_inline_select('clientFrom', $options, array('id', 'value'), 'KH từ', $clientFrom);
                                    ?>
                                    <?php $value = (isset($client) ? $client->company : ''); ?>
                                    <?php echo render_inline_input('company', 'Tên Khách hàng', $value); ?>
                                    <?php $value = (isset($client) ? $client->email : ''); ?>
                                    <?php echo render_inline_input('email', 'Email', $value); ?>
                                    <?php
                                    $options = array(
                                        array(
                                            'id' => 'canhan',
                                            'value' => 'Cá nhân',
                                        ),
                                        array(
                                            'id' => 'congty',
                                            'value' => 'Công ty',
                                        ),
                                    );
                                    $clientType = (isset($client) ? $client->clientType : '');
                                    echo render_inline_select('clientType', $options, array('id', 'value'), 'Loại KH', $clientType, array(), array(), '', '', false);
                                    ?>


                                    <?php
                                        $company = array();
                                        if($client->clientType != 'congty') {
                                            $company = array('disabled' => 'disabled');
                                        }
                                    ?>
                                    <?php
                                        $value = (isset($client) ? $client->companyName : '');
                                        echo render_inline_input('companyName', 'Tên công ty', $value, 'text', $company);
                                    ?>
                                    <?php
                                        $value = (isset($client) ? $client->companyBusinessLines : '');
                                        echo render_inline_input('companyBusinessLines', 'Lĩnh vực KD', $value, 'text', $company);
                                    ?>

                                    <?php
                                        $selected = (isset($client) ? $client->idAgency : '');
                                        echo render_inline_select('idAgency', $agencies, array('id', 'agencyName'), 'Môi giới', $selected);
                                    ?>
                                    
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                    <?php $selected = (isset($client) ? $client->purpose : ''); ?>
                                    <?php echo render_inline_select('purpose', $purpose, array('id', 'name'), 'Mục đích', $selected, array()); ?>
                                    <?php $selected = (isset($client) ? $client->exigency : ''); ?>
                                    <?php echo render_inline_select('exigency', $exigency, array('id', 'name'), 'Nhu cầu', $selected, array()); ?>
                                    <?php $value = (isset($client) ? $client->phonenumber : ''); ?>
                                    <?php echo render_inline_input('phonenumber', 'Số điện thoại', $value); ?>
                                    

                                    
                                    <?php
                                        $value = (isset($client) ? $client->companyPaymentAddress : '');
                                        echo render_inline_input('companyPaymentAddress', 'Địa chỉ viết HĐ', $value, 'text', $company);
                                    ?>
                                    <?php
                                        $value = (isset($client) ? $client->companyPhoneNumber : '');
                                        echo render_inline_input('companyPhoneNumber', 'Số đt bàn', $value, 'text', $company);
                                    ?>
                                    
                                    <?php
                                        $value = (isset($client) ? $client->companyWebiste : '');
                                        echo render_inline_input('companyWebiste', 'Website', $value, 'text', $company);
                                    ?>

                                    <?php
                                        $options = array(
                                            array(
                                                'id' => 'cokhachhang',
                                                'name' => 'Khách Hàng',
                                            ),
                                            array(
                                                'id' => 'cochunha',
                                                'name' => 'Chủ nhà',
                                            ),
                                        );
                                        $selected = (isset($client) ? $client->WhatsAgencyHave : '');
                                        echo render_inline_select('WhatsAgencyHave', $options, array('id', 'name'), 'Môi giới có', $selected);
                                    ?>
                                    
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                    <?php $selected = (isset($client) ? $client->country : ''); ?>
                                    <?php echo render_inline_select('country', $countries, array('country_id', 'short_name'), 'Quốc tịch', $selected, array()); ?>
                                    <!--                                                        --><?php //$selected=( isset($client) ? $client->type_client : ''); ?>
                                    <!--                                                        --><?php //echo render_inline_select( 'type_client', array(array('id'=>1,'name'=>'Khách hàng đang quan tâm'),array('id'=>2,'name'=>'Khách hàng mua/thuê'),array('id'=>3,'name'=>'Khách hàng fail')),array('id','name'),'Loại khách hàng',$selected,array()); ?>
                                    <?php $selected = (isset($client) ? $client->source : ''); ?>
                                    <?php echo render_inline_select('source', $source, array('id', 'name'), 'Nguồn', $selected, array()); ?>
                                
                                    <?php $selected = (isset($client) ? $client->class_type : ''); ?>
                                    <?php echo render_inline_select('class_type', $class_client, array('id', 'name'), 'Level', $selected, array()); ?>
                                    <?php
                                        $value = (isset($client) ? $client->companyOfficeAddress : '');
                                        echo render_inline_input('companyOfficeAddress', 'Địa chỉ VP', $value, 'text', $company);
                                    ?>
                                    <?php
                                        $value = (isset($client) ? $client->companyTaxCode : '');
                                        echo render_inline_input('companyTaxCode', 'Mã số thuế', $value, 'text', $company);
                                    ?>
                                    <?php
                                        $value = (isset($client) ? $client->companyNote : '');
                                        echo render_inline_textarea('companyNote', 'Ghi chú', $value, $company);
                                    ?>
                                </div>
                        </fieldset>
                    </div>
                    
                    <div class="clearfix">
                    </div>
                    
                    <p class="text-dark text-uppercase" style="text-align: center;"></p>
                    <hr class="no-mtop">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <fieldset>
                            <legend>Thời gian</legend>
                            
                                <?php $value = (isset($client) ? $client->date_movein : ''); ?>
                                <?php echo render_inline_date_input('date_movein', 'Ngày move in', $value); ?>    
                                <?php $value = (isset($client) ? $client->date_tax : ''); ?>
                                <?php echo render_inline_input('date_tax', 'Thời hạn thuê', $value); ?>    
                        </fieldset>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <fieldset>
                            <legend>Tổng hợp</legend>
                            
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <?php $selected = (isset($client) ? $client->status : ''); ?>
                                <?php echo render_inline_select('status', $status, array('id', 'name'), 'Trạng thái', $selected, array()); ?>
                                <?php $selected = (isset($client) ? $client->nvgd : ''); ?>
                                <?php echo render_inline_select('nvgd', $staff, array('staffid', 'lastname'), 'Nhân viên đăng ký', $selected, array()); ?>
                                <?php $value = (isset($client) ? $client->requirements : ''); ?>
                                <?php echo render_inline_input('requirements', 'Yêu cầu khác', $value); ?>
                            </div>

                            <!-- <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                
                            </div> -->
                        </fieldset>
                    </div>
                    <div class="clearfix">
                    </div>
                    <?php
                    }
                    else if($type_client == 1 && $convert) 
                    {
                    ?>
                    <span class="text-center">
                        <a class="btn btn-primary" href="<?=admin_url('clients/client/')?><?=$client->userid?>?type_client=2&convert=true&back=1">Chuyển sang khách hàng FAIL</a>
                    </span>
                    <?php
                    }

                    if($type_client == 2 && $convert && !is_null($this->input->get('back'))) {
                        ?>
                    <span class="text-center">
                        <a class="btn btn-warning" href="<?=admin_url('clients/client/')?><?=$client->userid?>?type_client=1&convert=true">Trở lại chuyển sang khách hàng MUA/THUÊ</a>
                    </span>
                        <?php
                    }
                    ?>
                    <p class="text-dark text-uppercase" style="text-align: center;"></p>
                    <hr class="no-mtop">
                    <?php
                    if($type_client == 1 && !is_null($convert))
                    {
                    ?>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <fieldset>
                            <legend>
                            <?php
                                if(($type_client == 1 && !is_null($convert))) {
                                    ?>
                                        Thông tin sản phẩm
                                    <?php
                                }
                                else {
                                    ?>
                                        Yêu cầu khu vực dự án
                                    <?php
                                }
                            ?>
                                
                            </legend>
                            <?php
                                $province_selected = 0;
                                if(isset($client) && $type_client != 2) {
                                    $province_selected = $client->province;
                                }
                                echo render_inline_select('items[0][city]', $province, array('provinceid', 'name', 'type'), 'Tỉnh/Thành phố', $province_selected, array('onchange' => 'get_district_client(this)')); 
                            ?>
                            
                            <?php
                                if(isset($client) && $type_client != 2) {
                                    $district = get_district_from_city($province_selected);
                                    $district_selected = $client->district;
                                }
                                echo render_inline_select('items[0][district]', $district, array('districtid', 'name', 'type'), 'Quận/huyện', $district_selected, array()); 
                            ?>

                            <?php
                                if(isset($client) && $type_client != 2) {
                                    $type_bds_selected = $client->type_bds;
                                    $id_project_bds = get_project_from_type($type_bds_selected);
                                }
                                echo render_inline_select('items[0][menuBdsId]', $menu_project, array('id', 'menu_name'), 'Loại bất động sản', $type_bds_selected, array('onchange' => 'get_project(this)'));
                            ?>

                            <?php
                                if(isset($client) && $type_client != 2) {
                                    $bds_selected = $client->bds;
                                }
                                echo render_inline_select('items[0][projectBdsId]', $id_project_bds, array('id', 'project_name', 'code'), 'Dự án', $bds_selected, array()); 
                            ?>
                            <?php
                            if($type_client == 2 || ($type_client == 1 && !is_null($convert))) {
                                $type_options = array(
                                    array(
                                        'id' => 1,
                                        'value' => 'Mua'
                                    ),
                                    array(
                                        'id' => 2,
                                        'value' => 'Thuê'
                                    ),
                                );
                                echo render_inline_select('items[0][type]', $type_options, array('id', 'value'), 'Hình thức', '', array(), array(), '', '', false);
                            ?>

                            <?php
                                echo render_inline_input('items[0][price]', 'Giá');
                            ?>

                            <?php
                                $period_options = array(
                                    array(
                                        'id' => 1,
                                        'value' => '1 tháng'
                                    ),
                                    array(
                                        'id' => 2,
                                        'value' => '2 tháng'
                                    ),
                                    array(
                                        'id' => 3,
                                        'value' => '3 tháng'
                                    ),
                                    array(
                                        'id' => 4,
                                        'value' => '4 tháng'
                                    ),
                                    array(
                                        'id' => 5,
                                        'value' => '5 tháng'
                                    ),
                                    array(
                                        'id' => 6,
                                        'value' => '6 tháng'
                                    ),
                                    array(
                                        'id' => 7,
                                        'value' => '7 tháng'
                                    ),
                                    array(
                                        'id' => 8,
                                        'value' => '8 tháng'
                                    ),
                                    array(
                                        'id' => 9,
                                        'value' => '9 tháng'
                                    ),
                                    array(
                                        'id' => 10,
                                        'value' => '10 tháng'
                                    ),
                                    array(
                                        'id' => 11,
                                        'value' => '11 tháng'
                                    ),
                                    array(
                                        'id' => 12,
                                        'value' => '12 tháng'
                                    ),
                                );
                                echo render_inline_select('items[0][rentalPeriod]', $period_options, array('id', 'value'), 'Thời hạn thuê');
                            ?>
                            <?php
                                echo render_inline_date_input('items[0][dateStart]', 'Ngày mua/thuê', date('Y-m-d'));
                            ?>
                            <?php
                            }
                            ?>
                        </fieldset>
                    </div>
                    <?php
                    }
                    ?>
                    <?php
                        if(($type_client == 1 || $type_client == 3) && is_null($convert))
                        {
                    ?>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        
                        <fieldset>
                            <legend>Yêu Cầu Chi Tiết SP</legend>
                            <?php $value = (isset($client) ? $client->pn : ''); ?>
                            <?php echo render_inline_input('pn', 'Phòng ngủ', $value); ?>

                            <?php $value = (isset($client) ? $client->budget : ''); ?>
                            <?php echo render_inline_input('budget', 'Ngân sách khoản', $value); ?>
                            <?php $value = (isset($client) ? $client->area : ''); ?>
                            <?php echo render_inline_input('area', 'Diện tích', $value); ?>
                        </fieldset>
                    </div>
                    <?php
                        }
                    ?>
                    <div class="col-md-6">
                        <fieldset>
                            <legend>Các thông tin đặc trưng</legend>
                            <?php
                            if(($type_client == 1 && $convert) || ($type_client == 2 && !$convert)) {
                                $value = (isset($client) ? $client->id_contract : '');
                                echo render_inline_input('id_contract', 'Mã hợp đồng', $value);
                                
                                $value = (isset($client) ? $client->date_deal : '');
                                echo render_inline_date_input('date_deal', 'Ngày giao dịch', $value); 

                                $value = (isset($client) ? $client->expire_contract : ''); 
                                echo render_inline_date_input('expire_contract', 'Ngày HHĐ', $value); 

                                $value = (isset($client) ? $client->bonus_period : '');
                                echo render_inline_input('bonus_period', 'Hoa hồng gia hạn', $value);

                                $value = (isset($client) ? $client->note : '');
                                echo render_inline_input('note', 'Note', $value);
                            }
                            else if($type_client == 1) {
                                $value = (isset($client) ? $client->date_contact : '');
                                echo render_inline_date_input('date_contact', 'Ngày liên hệ', $value);
                            }
                            else if($type_client == 3 || ($type_client == 2 && $convert)) {
                                $value = (isset($client) ? $client->rent_project_name : '');
                                echo render_inline_input('rent_project_name', 'DA/KV đã thuê', $value);
                                
                                $value = (isset($client) ? $client->duration_of_contract_expiration : '');
                                echo render_inline_input('duration_of_contract_expiration', 'Khoảng Thời hạn HHD', $value); 

                                $value = (isset($client) ? $client->reason_fail : ''); 
                                echo render_inline_input('reason_fail', 'Lý do Fail', $value); 
                            }
                            ?>
                        </fieldset>
                    </div>
                    
                    <?php
                    if(is_null($convert)) {
                        ?>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <fieldset>
                            <legend>Đối Tác</legend>
                            <?php $selected = (isset($client) ? $client->id_partner : ''); ?>
                            <?php echo render_inline_select('id_partner', $id_partner, array('id_partner', 'name_partner'), 'Đối tác', $selected, array()); ?>
                        </fieldset>
                    </div>
                    <?php
                    }
                    ?>
                    
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <?php if (($type_client == 1 && $convert)) { ?>
                            <p class="text-dark text-uppercase" style="text-align: center;"></p>
                            <hr class="no-mtop">
                            <fieldset>
                                <legend>Hoa hồng</legend>

                                    <div class="col-md-6">
                                        <?php $value = (isset($client) ? $client->status_bonus : ''); ?>
                                        <?php echo render_inline_input('status_bonus', 'Trạng thái hoa hồng', $value); ?>
                                        <button type="button" class="btn btn-success" onclick="append_colum(this)">
                                            Thêm Đợt Thanh toán Hoa hồng
                                        </button>
                                    </div>
                                    
                                    <div class="clearfix">
                                    
                                    </div>
                                    <hr />
                                    
                                    
                                        <?php if (isset($client)) {
                                            $time_bonus = explode(',', $client->time_bonus);
                                            $num_bonus = explode(',', $client->num_bonus);
                                            ?>
                                            <?php foreach ($time_bonus as $num => $rom) { ?>
                                            <div class="col-md-3 time_bonus">
                                                <fieldset class="fieldset review_bonus_<?= $num + 1 ?>">
                                                    <legend class="legend">Đợt:<?= $num + 1 ?><a href="javacript:void(0)" class="text-danger _delete" onclick="remove_field(<?= $num + 1 ?>)"><i class="fa fa fa-times"></i></a></legend>
                                                    <div class="form-group">
                                                        <label for="time_bonus" class="control-label label-time col-sm-4">Ngày thu đợt: <?= $num + 1 ?></label>
                                                        <div class="col-sm-8">
                                                            <div class="input-group date">
                                                                <input type="text"  name="time_bonus[]" class="form-control datepicker" value="<?= $rom ?>">
                                                                <div class="input-group-addon">
                                                                    <i class="fa fa-calendar calendar-icon"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="num_bonus" class="control-label label-num col-sm-4">Đợt: <?= $num + 1 ?></label>
                                                        <div class="col-sm-8">
                                                            <input type="text"  name="num_bonus[]" class="form-control" value="<?= $num_bonus[$num] ?>">
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <?php 
                                        } ?>
                                    
                                <?php 
                                } ?>
                            </fieldset>
                            <?php 
                            } ?>
                    </div>
                </div>
                <button type="button" class="btn btn-info mtop20 only-save customer-form-submiter">
                    <?php echo _l('submit'); ?>
                </button>
                <?php echo form_close(); ?>
            </div>

            <div role="tabpanel" class="tab-pane" id="task">
                <h4 class="no-mtop bold"><?php echo _l('tasks'); ?></h4>
                <hr />
                <?php if(isset($client)){
                    init_relation_tasks_table(array( 'data-new-rel-id'=>$client->userid,'data-new-rel-type'=>'customer'));
                } ?>
            </div>

            <div role="tabpanel" class="tab-pane" id="items">
                <h4 class="no-mtop bold"><?php echo _l('Lịch sử mua hàng'); ?></h4>
                <hr />

                <?php
                    if(has_permission('projects','','view')){
                ?>
                    <a href="#" onclick="new_product(); return false;" class="btn btn-info mbot25">Thêm sản phẩm</a>
                <?php
                    }
                ?>

                <div class="clearfix">
                    <br />
                </div>

                <?php
                $table_data = array(
                    '#',
                    _l('Dự án'),
                    _l('Hình thức'),
                    _l('Giá'),
                    _l('Thời hạn thuê'),
                    _l('Ngày mua/thuê'),
                    _l('client_contract_code'),
                    _l('client_contract_startdate'),
                    _l('client_contract_expirydate'),
                    _l('actions'),
                    );
                    render_datatable($table_data,'client-items');
                ?>

                <div class="modal fade lead-modal" id="newProduct" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close btn-close-single-modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">
                                    <span class="edit-title">Khách hàng mua/thuê</span>
                                </h4>
                            </div>
                            <?php echo form_open(admin_url('clients/addProduct/' . (isset($client) ? $client->userid : "")) ,array('id'=>'id_type', 'class' => 'form-item form-horizontal')); ?>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <?php
                                        echo render_inline_input('items[0][contractCode]', _l('client_contract_code'));
                                        ?>

                                        <?php
                                        echo render_inline_date_input('items[0][contractStartDate]', _l('client_contract_startdate'));
                                        ?>

                                        <?php
                                        echo render_inline_date_input('items[0][contractExpiryDate]', _l('client_contract_expirydate'));
                                        ?>

                                        <?php
                                        echo render_inline_select('items[0][city]', $province, array('provinceid', 'name', 'type'), 'Tỉnh/Thành phố', '', array('onchange' => 'get_district_client(this)')); 
                                        ?>
                                        
                                        <?php
                                        echo render_inline_select('items[0][district]', $district, array('districtid', 'name', 'type'), 'Quận/huyện', '', array()); 
                                        ?>

                                        <?php
                                        echo render_inline_select('items[0][menuBdsId]', $menu_project, array('id', 'menu_name'), 'Loại bất động sản', '', array('onchange' => 'get_project(this)'));
                                        ?>

                                        <?php echo render_inline_select('items[0][projectBdsId]', $id_project_bds, array('id', 'project_name', 'code'), 'Dự án', '', array()); ?>
                                        <?php
                                        $type_options = array(
                                            array(
                                                'id' => 1,
                                                'value' => 'Mua'
                                            ),
                                            array(
                                                'id' => 2,
                                                'value' => 'Thuê'
                                            ),
                                        );
                                        echo render_inline_select('items[0][type]', $type_options, array('id', 'value'), 'Hình thức', '', array(), array(), '', '', false);
                                        ?>

                                        <?php
                                        echo render_inline_input('items[0][price]', 'Giá');
                                        ?>

                                        <?php
                                        $period_options = array(
                                            array(
                                                'id' => 1,
                                                'value' => '1 tháng'
                                            ),
                                            array(
                                                'id' => 2,
                                                'value' => '2 tháng'
                                            ),
                                            array(
                                                'id' => 3,
                                                'value' => '3 tháng'
                                            ),
                                            array(
                                                'id' => 4,
                                                'value' => '4 tháng'
                                            ),
                                            array(
                                                'id' => 5,
                                                'value' => '5 tháng'
                                            ),
                                            array(
                                                'id' => 6,
                                                'value' => '6 tháng'
                                            ),
                                            array(
                                                'id' => 7,
                                                'value' => '7 tháng'
                                            ),
                                            array(
                                                'id' => 8,
                                                'value' => '8 tháng'
                                            ),
                                            array(
                                                'id' => 9,
                                                'value' => '9 tháng'
                                            ),
                                            array(
                                                'id' => 10,
                                                'value' => '10 tháng'
                                            ),
                                            array(
                                                'id' => 11,
                                                'value' => '11 tháng'
                                            ),
                                            array(
                                                'id' => 12,
                                                'value' => '12 tháng'
                                            ),
                                        );
                                        echo render_inline_select('items[0][rentalPeriod]', $period_options, array('id', 'value'), 'Thời hạn thuê');
                                        ?>
                                        <?php
                                        echo render_inline_date_input('items[0][dateStart]', 'Ngày mua/thuê', date('Y-m-d'));
                                        ?>
                                    
                                    </div> 
                                </div>
                            </div>
                            <div class="modal-footer">
                                <a href="#" class="btn btn-default btn-close-single-modal"><?php echo _l('close'); ?></a>
                                <button type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
                            </div>
                            <?php echo form_close(); ?>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->

                </div><!-- /.modal -->
                <div class="modal fade lead-modal" id="viewProduct" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close btn-close-single-modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">
                                    <span class="edit-title">Khách hàng mua/thuê</span>
                                </h4>
                            </div>
                            <?php echo form_open('#', array('id' => 'id_type', 'class' => 'form-item form-horizontal')); ?>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    
                                    <?php
                                        echo render_inline_input('items[0][contractCode]', _l('client_contract_code'));
                                        ?>

                                        <?php
                                        echo render_inline_date_input('items[0][contractStartDate]', _l('client_contract_startdate'));
                                        ?>

                                        <?php
                                        echo render_inline_date_input('items[0][contractExpiryDate]', _l('client_contract_expirydate'));
                                        ?>

                                    <?php
                                    echo render_inline_select('items[0][city]', $province, array('provinceid', 'name', 'type'), 'Tỉnh/Thành phố', '', array('onchange' => 'get_district_client(this)'));
                                    ?>
                                    
                                    <?php
                                    echo render_inline_select('items[0][district]', $district, array('districtid', 'name', 'type'), 'Quận/huyện', '', array());
                                    ?>

                                    <?php
                                    echo render_inline_select('items[0][menuBdsId]', $menu_project, array('id', 'menu_name'), 'Loại bất động sản', '', array('onchange' => 'get_project(this)'));
                                    ?>

                                    <?php echo render_inline_select('items[0][projectBdsId]', $id_project_bds, array('id', 'project_name', 'code'), 'Dự án', '', array()); ?>
                                    <?php
                                    $type_options = array(
                                        array(
                                            'id' => 1,
                                            'value' => 'Mua'
                                        ),
                                        array(
                                            'id' => 2,
                                            'value' => 'Thuê'
                                        ),
                                    );
                                    echo render_inline_select('items[0][type]', $type_options, array('id', 'value'), 'Hình thức', '', array(), array(), '', '', false);
                                    ?>

                                    <?php
                                    echo render_inline_input('items[0][price]', 'Giá', '', 'text', array('onclick' => "formatNumber(this.value)"));
                                    ?>

                                    <?php
                                    $period_options = array(
                                        array(
                                            'id' => 1,
                                            'value' => '1 tháng'
                                        ),
                                        array(
                                            'id' => 2,
                                            'value' => '2 tháng'
                                        ),
                                        array(
                                            'id' => 3,
                                            'value' => '3 tháng'
                                        ),
                                        array(
                                            'id' => 4,
                                            'value' => '4 tháng'
                                        ),
                                        array(
                                            'id' => 5,
                                            'value' => '5 tháng'
                                        ),
                                        array(
                                            'id' => 6,
                                            'value' => '6 tháng'
                                        ),
                                        array(
                                            'id' => 7,
                                            'value' => '7 tháng'
                                        ),
                                        array(
                                            'id' => 8,
                                            'value' => '8 tháng'
                                        ),
                                        array(
                                            'id' => 9,
                                            'value' => '9 tháng'
                                        ),
                                        array(
                                            'id' => 10,
                                            'value' => '10 tháng'
                                        ),
                                        array(
                                            'id' => 11,
                                            'value' => '11 tháng'
                                        ),
                                        array(
                                            'id' => 12,
                                            'value' => '12 tháng'
                                        ),
                                    );
                                    echo render_inline_select('items[0][rentalPeriod]', $period_options, array('id', 'value'), 'Thời hạn thuê');
                                    ?>
                                    <?php
                                    echo render_inline_date_input('items[0][dateStart]', 'Ngày mua/thuê', date('Y-m-d'));
                                    ?>
                                    
                                    </div> 
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default btn-close-single-modal"><?php echo _l('close'); ?></button>
                            </div>
                            <?php echo form_close(); ?>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
                <div class="modal fade lead-modal" id="viewBillingPeriod" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog" style="width: 100%">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close btn-close-single-modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">
                                    <span class="edit-title">Đợt thanh toán</span>
                                </h4>
                            </div>
                            <div class="modal-body">
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default btn-close-single-modal"><?php echo _l('close'); ?></button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
            </div>
            
            <div role="tabpanel" class="tab-pane" id="paymenthistory">
                <?php if(isset($client)){ ?>
                    <h4 class="no-mtop bold"><?php echo _l('client_payments_tab'); ?></h4>
                    <hr />
                <?php
                    $table_data = array(
                        _l('STT'),
                        _l('Dự án'),
                        _l('Ngày thanh toán'),
                        _l('Số tiền'),
                        _l('Thanh toán bằng'),
                        _l('actions'),
                        );
                    render_datatable($table_data,'payment-history');
                }
                ?>
            </div>

            <div role="tabpanel" class="tab-pane" id="attachments">
                <div class="modal fade" id="customer_file_share_file_with" data-total-contacts="<?php echo count($contacts); ?>" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <button type="button" class="btn-close-single-modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><?php echo _l('share_file_with'); ?></h4>
                    </div>
                    <div class="modal-body">
                        <?php echo form_hidden('file_id'); ?>
                        <?php echo render_select('share_contacts_id[]',$contacts,array('id',array('firstname','lastname')),'customer_contacts',array(get_primary_contact_user_id($client->userid)),array('multiple'=>true),array(),'','',false); ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-close-single-modal"><?php echo _l('close'); ?></button>
                        <button type="button" class="btn btn-info" onclick="do_share_file_contacts();"><?php echo _l('confirm'); ?></button>
                    </div>
                    </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                    <h4 class="no-mtop bold"><?php echo _l('customer_attachments'); ?></h4>
                    <hr />
                    <?php if(isset($client)){ ?>
                    <?php echo form_open_multipart(admin_url('clients/upload_attachment/'.$client->userid),array('class'=>'dropzone','id'=>'client-attachments-upload')); ?>
                    <input type="file" name="file" multiple />
                    <?php echo form_close(); ?>
                    <div class="text-right mtop15">
                    <div id="dropbox-chooser"></div>
                    </div>
                    <div class="attachments">
                    <div class="table-responsive mtop25">
                        <table class="table dt-table" data-order-col="2" data-order-type="desc">
                            <thead>
                                <tr>
                                    <th width="30%"><?php echo _l('customer_attachments_file'); ?></th>
                                    <th><?php echo _l('customer_attachments_show_in_customers_area'); ?></th>
                                    <th><?php echo _l('file_date_uploaded'); ?></th>
                                    <th><?php echo _l('options'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($attachments as $type => $attachment){
                                    $download_indicator = 'id';
                                    $key_indicator = 'rel_id';
                                    $upload_path = get_upload_path_by_type($type);
                                    if($type == 'invoice'){
                                        $url = site_url() .'download/file/sales_attachment/';
                                        $download_indicator = 'attachment_key';
                                    } else if($type == 'proposal'){
                                        $url = site_url() .'download/file/sales_attachment/';
                                        $download_indicator = 'attachment_key';
                                    } else if($type == 'estimate'){
                                        $url = site_url() .'download/file/sales_attachment/';
                                        $download_indicator = 'attachment_key';
                                    } else if($type == 'contract'){
                                        $url = site_url() .'download/file/contract/';
                                    } else if($type == 'lead'){
                                        $url = site_url() .'download/file/lead_attachment/';
                                    } else if($type == 'task'){
                                        $url = site_url() .'download/file/taskattachment/';
                                    } else if($type == 'ticket'){
                                        $url = site_url() .'download/file/ticket/';
                                        $key_indicator = 'ticketid';
                                    } else if($type == 'customer'){
                                        $url = site_url() .'download/file/client/';
                                    } else if($type == 'expense'){
                                        $url = site_url() .'download/file/expense/';
                                        $download_indicator = 'rel_id';
                                    }
                                    ?>
                                    <?php foreach($attachment as $_att){
                                        ?>
                                        <tr id="tr_file_<?php echo $_att['id']; ?>">
                                            <td>
                                            <?php
                                            $path = $upload_path . $_att[$key_indicator] . '/' . $_att['file_name'];
                                            $is_image = false;
                                            if(!isset($_att['external'])) {
                                                $attachment_url = $url . $_att[$download_indicator];
                                                $is_image = is_image($path);
                                                $img_url = site_url('download/preview_image?path='.protected_file_url_by_path($path).'&type='.$_att['filetype']);
                                            } else if(isset($_att['external']) && !empty($_att['external'])){

                                                if(!empty($_att['thumbnail_link'])){
                                                    $is_image = true;
                                                    $img_url = optimize_dropbox_thumbnail($_att['thumbnail_link']);
                                                }

                                                $attachment_url = $_att['external_link'];
                                            }
                                            if($is_image){
                                                echo '<div class="preview_image">';
                                            }
                                            ?>
                                            <a href="<?php if($is_image){ echo $img_url; } else {echo $attachment_url; } ?>"<?php if($is_image){ ?> data-lightbox="customer-profile" <?php } ?> class="display-block mbot5">
                                                <?php if($is_image){ ?>
                                                <div class="table-image">
                                                    <img src="<?php echo $img_url; ?>">
                                                </div>
                                                <?php } else { ?>
                                                <i class="<?php echo get_mime_class($_att['filetype']); ?>"></i> <?php echo $_att['file_name']; ?>
                                                <?php } ?>

                                            </a>
                                            <?php if($is_image){
                                            echo '</div>';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <div class="onoffswitch"<?php if($type != 'customer'){?> data-toggle="tooltip" data-title="<?php echo _l('customer_attachments_show_notice'); ?>" <?php } ?>>
                                            <input type="checkbox" <?php if($type != 'customer'){echo 'disabled';} ?> id="<?php echo $_att['id']; ?>" data-id="<?php echo $_att['id']; ?>" class="onoffswitch-checkbox customer_file" data-switch-url="<?php echo admin_url(); ?>misc/toggle_file_visibility" <?php if(isset($_att['visible_to_customer']) && $_att['visible_to_customer'] == 1){echo 'checked';} ?>>
                                            <label class="onoffswitch-label" for="<?php echo $_att['id']; ?>"></label>
                                        </div>
                                        <?php if($type == 'customer' && $_att['visible_to_customer'] == 1){
                                            $file_visibility_message = '';
                                            $total_shares = total_rows('tblcustomerfiles_shares',array('file_id'=>$_att['id']));

                                            if($total_shares == 0){
                                                $file_visibility_message = _l('file_share_visibility_notice');
                                            } else {
                                                $share_contacts_id = get_customer_profile_file_sharing(array('file_id'=>$_att['id']));
                                                if(count($share_contacts_id) == 0){
                                                    $file_visibility_message = _l('file_share_visibility_notice');
                                                }
                                            }
                                            echo '<span class="text-warning'.(empty($file_visibility_message) || total_rows('tblcontacts',array('userid'=>$client->userid)) == 0 ? ' hide': '').'">'.$file_visibility_message.'</span>';
                                            if(isset($share_contacts_id) && count($share_contacts_id) > 0){
                                                $names = '';
                                                $contacts_selected = '';
                                                foreach($share_contacts_id as $file_share){
                                                    $names.= get_contact_full_name($file_share['contact_id']) .', ';
                                                    $contacts_selected .= $file_share['contact_id'].',';
                                                }
                                                if($contacts_selected != ''){
                                                    $contacts_selected = substr($contacts_selected,0,-1);
                                                }
                                                if($names != ''){
                                                    echo '<a href="#" onclick="do_share_file_contacts(\''.$contacts_selected.'\','.$_att['id'].'); return false;"><i class="fa fa-pencil-square-o"></i></a> ' . _l('share_file_with_show',mb_substr($names, 0,-2));
                                                }
                                            }
                                        }
                                        ?>
                                    </td>
                                    <td data-order="<?php echo $_att['dateadded']; ?>"><?php echo _dt($_att['dateadded']); ?></td>
                                    <td>
                                        <?php if(!isset($_att['external'])){ ?>
                                        <button type="button" data-toggle="modal" data-file-name="<?php echo $_att['file_name']; ?>" data-filetype="<?php echo $_att['filetype']; ?>" data-path="<?php echo $path; ?>" data-target="#send_file" class="btn btn-info btn-icon"><i class="fa fa-envelope"></i></button>
                                        <?php } else if(isset($_att['external']) && !empty($_att['external'])) {
                                            echo '<a href="'.$_att['external_link'].'" class="btn btn-info btn-icon" target="_blank"><i class="fa fa-dropbox"></i></a>';
                                        } ?>
                                        <?php if($type == 'customer'){ ?>
                                        <a href="<?php echo admin_url('clients/delete_attachment/'.$_att['rel_id'].'/'.$_att['id']); ?>"  class="btn btn-danger btn-icon _delete"><i class="fa fa-remove"></i></a>
                                        <?php } ?>
                                    </td>
                                    <?php } ?>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                    </div>
                    <?php
                    include_once(APPPATH . 'views/admin/clients/modals/send_file_modal.php');
                    } ?>
            </div>

            <div role="tabpanel" class="tab-pane" id="reminders">
                <h4 class="no-mtop bold"><?php echo _l('client_reminders_tab'); ?></h4>
                <hr />
                <?php if(isset($client)){ ?>
                <a href="#" data-toggle="modal" data-target=".reminder-modal-customer-<?php echo $client->userid; ?>" class="btn btn-info mbot25"><i class="fa fa-bell-o"></i> <?php echo _l('set_reminder'); ?></a>
                <div class="clearfix"></div>

                <?php render_datatable(array( _l( 'reminder_description'), _l( 'reminder_date'), _l( 'reminder_staff'), _l( 'reminder_is_notified'), _l( 'options'), ), 'reminders');
                $this->load->view('admin/includes/modals/reminder',array('id'=>$client->userid,'name'=>'customer','members'=>$members,'reminder_title'=>_l('set_reminder')));
                } ?>
            </div>
            <div role="tabpanel" class="tab-pane" id="contacts">
                <?php if(has_permission('customers','','create') || is_customer_admin($client->userid)){
                        $disable_new_contacts = false;
                        if(is_empty_customer_company($client->userid) && total_rows('tblcontacts',array('userid'=>$client->userid)) == 1){
                        $disable_new_contacts = true;
                    }
                    ?>
                    <div class="inline-block"<?php if($disable_new_contacts){ ?> data-toggle="tooltip" data-title="<?php echo _l('customer_contact_person_only_one_allowed'); ?>"<?php } ?>>
                        <a href="#" onclick="contact(<?php echo $client->userid; ?>); return false;" class="btn btn-info mbot25<?php if($disable_new_contacts){echo ' disabled';} ?>"><?php echo _l('new_contact'); ?></a>
                    </div>
                    <?php } ?>
                    <?php
                    $table_data = array(_l('client_firstname'),_l('client_lastname'),_l('client_email'),_l('contact_position'),_l('client_phonenumber'),_l('contact_active'));
                    $custom_fields = get_custom_fields('contacts',array('show_on_table'=>1));
                    foreach($custom_fields as $field){
                    array_push($table_data,$field['name']);
                }
                array_push($table_data,_l('options'));
                echo render_datatable($table_data,'contacts'); ?>
                
            </div>
        </div>
    </div>
</div>


<script>
    $(function() {
        // Task
        initDataTable('.table-rel-tasks','<?= admin_url() ?>tasks/init_relation_tasks/<?= $client->userid ?>/customer' , [0], [3]);
        
        // Profile
        $(document).on('click', '.customer-form-submiter', function() {
            let buttonSubmit = $(this).button('loading');
            const data = $('.customer-form-submiter').parents('form').serialize();
            $.ajax({
                url: $(this).parents('form').attr('action'),
                method: 'post',
                data,
                dataType: 'json',
            }).done(function(data) {
                if(data.success) {
                    $('.table-clients').DataTable().ajax.reload();
                    alert_float('success', data.message);
                    if(!$('#modalClient').attr('data-userid')) {
                        $('#modalClient').modal('hide');
                    }
                }
                else {
                    alert_float('danger', data.message);
                }
                buttonSubmit.button('reset');
            }).fail(() => {
                buttonSubmit.button('reset');
            });
        });

        // Attachment
        Dropzone.options.clientAttachmentsUpload = false;
        var customer_id = $('input[name="userid"]').val();
        if ($('#modalClient #client-attachments-upload').length > 0) {
        new Dropzone('#modalClient #client-attachments-upload', {
            paramName: "file",
            dictDefaultMessage:drop_files_here_to_upload,
            dictFallbackMessage:browser_not_support_drag_and_drop,
            dictRemoveFile:remove_file,
            dictFileTooBig: file_exceds_maxfile_size_in_form,
            dictMaxFilesExceeded:you_can_not_upload_any_more_files,
            maxFilesize: max_php_ini_upload_size.replace(/\D/g, ''),
            addRemoveLinks: false,
            accept: function(file, done) {
            done();
            },
            acceptedFiles: allowed_files,
            error: function(file, response) {
            alert_float('danger', response);
            },
            success: function(file, response) {
            if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                window.location.reload();
            }
            }
        });
        }

        // Reminders
        /* Custome profile reminders table */
        initDataTable('.table-reminders', admin_url + 'misc/get_reminders/' + customer_id + '/' + 'customer', [4], [4]);

        // Warning
        get_project = function(id)
        {
            jQuery.ajax({
                type: "post",
                dataType:'json',
                url: "<?= admin_url() ?>clients/get_project/"+id.value,
                data: '',
                cache: false,
                success: function (data) {
                    var option="";
                    $.each(data, function( index, value ) {
                        option=option+'<option data-subtext="'+value.code+'" value="'+value.id+'">'+value.project_name+'</option>';
                    });
                    $(id).parents('.form-group').next().find('select').html(option).selectpicker('refresh');

                }
            });
        }
        append_colum = function(buttonElement)
        {
            var time=$('.class_time').html();
            var re_num=$('input[name="num_bonus[]"]').length+1;
            let parentFieldSet = $(buttonElement).parents('fieldset');
            parentFieldSet.append('<div class="col-md-3"><fieldset class="fieldset review_bonus_'+re_num+'">'+
                                        '<legend class="legend">Đợt:'+re_num+'<a href="javacript:void(0)" class="text-danger _delete" onclick="remove_field('+re_num+')"><i class="fa fa fa-times"></i></a></legend>'+
                                            '<div class="form-group">' +
                                                '<label for="time_num" class="control-label label-time col-sm-4">Ngày thu đợt:'+re_num+'</label>' +
                                                '<div class="col-sm-8">'+
                                                '<div class="input-group date">' +
                                                    '<input type="text"  name="time_bonus[]" class="form-control datepicker" value="">' +
                                                    '<div class="input-group-addon">'+
                                                        '<i class="fa fa-calendar calendar-icon"></i>'+
                                                    '</div>' +
                                                '</div>' +
                                                '</div>' +
                                            '</div>' +
                                            '<div class="form-group review_bonus_'+re_num+'">' +
                                                '<label for="date_movein" class="control-label col-sm-4 label-num">Đợt:'+re_num+'</label>' +
                                                '<div class="col-sm-8">'+
                                                '<input type="text"  name="num_bonus[]" class="form-control" value="">'+
                                                '</div>' +
                                            '</div>'+
                                    '</fieldset></div>'
            );
            init_datepicker();

        }
        remove_field = function(key)
        {

            $('.review_bonus_'+key).parent().remove();
            var re_num=$('input[name="num_bonus[]"]').length;
            var legend=$('.legend');
            var field=$('.fieldset');
            var lable_time=$('.label-time');
            var lable_num=$('.label-num');
            console.log(legend);
            for(var i=0;i<re_num;i++)
            {
                $(field[i]).prop('class','fieldset review_bonus_'+(i+1));
                $(legend[i]).html('Đợt '+(i+1)+'<a href="javacript:void(0)" class="text-danger _delete" onclick="remove_field('+(i+1)+')"><i class="fa fa fa-times"></i></a>');
                $(lable_time[i]).html('Ngày thu tiền đợt: '+(i+1));
                $(lable_num[i]).html('Đợt: '+(i+1));
            }
        }
        get_district_client = function(id)
        {
            jQuery.ajax({
                type: "post",
                dataType:'json',
                url: "<?= admin_url() ?>clients/get_district/"+id.value,
                data: '',
                cache: false,
                success: function (data) {
                    var option="";
                    $.each(data, function( index, value ) {
                        option=option+'<option data-subtext="'+value.type+'" value="'+value.districtid+'">'+value.name+'</option>';
                    });
                    $(id).parents('.form-group').next().find('select').html(option).selectpicker('refresh');

                }
            });
        }
        $(document).on('keyup', '[name="items[0][price]"], #value, #realValue, input[name="num_bonus[]"]', (e) => {
            const current = $(e.currentTarget);
            var charCode = (e.which) ? e.which : event.keyCode
            
            // Remove grop seperate

            current.val( current.val().replace(/\D/g, '') );
            current.val(formatNumber(current.val()));
        });
        
        view_init_department = function(id)
        {
            jQuery.ajax({
                type: "post",
                url:admin_url+"clients/getProduct/<?= (isset($client) ? $client->userid : '') ?>/"+id,
                data: '',
                cache: false,
                dataType: 'json',
                success: function (data) {
                    if(data.success)
                    {
                        let item = data.data;
                        $('#viewProduct').modal('show');
                        $('#viewProduct .modal-body .col-sm-8').each((i, v) => {
                            switch(i) {
                                case 0:
                                    $(v).html("<p class='form-control-static'>"+item.contractCode+"</p>");
                                    break;
                                case 1:
                                    $(v).html("<p class='form-control-static'>"+item.contractStartDate+"</p>");
                                    break;
                                case 2:
                                    $(v).html("<p class='form-control-static'>"+item.contractExpiryDate+"</p>");
                                    break;
                                case 3:
                                    $(v).html("<p class='form-control-static'>"+item.cityName+"</p>");
                                    break;
                                case 4:
                                    $(v).html("<p class='form-control-static'>"+item.districtName+"</p>");
                                    break;
                                case 5:
                                    $(v).html("<p class='form-control-static'>"+item.menuBdsName+"</p>");
                                    break;
                                case 6:
                                    $(v).html("<p class='form-control-static'>"+item.project_name+"</p>");
                                    break;
                                case 7:
                                    $(v).html("<p class='form-control-static'>"+(item.type == 1 ? "Mua" : "Thuê")+"</p>");
                                    break;
                                case 8:
                                    $(v).html("<p class='form-control-static'>"+formatNumber(item.price)+"</p>");
                                    break;
                                case 9:
                                    $(v).html("<p class='form-control-static'>"+(item.type == 1 ? "Không" : (item.rentalPeriod + ' tháng'))+"</p>");
                                    break;
                                case 10:
                                    const d = new Date(item.dateStart);
                                    $(v).html("<p class='form-control-static'>"+d.getFullYear()+'-'+(d.getMonth()+1)+'-'+d.getDate()+"</p>");
                                    break;
                            }
                        });
                    }
                    else {
                        alert_float('danger', 'Lấy dữ liệu thất bại!');
                    }
                }
            });
        }
        new_product = function() {
            $('#newProduct').modal('show');
            jQuery('#id_type').prop('action', admin_url + 'clients/addProduct/<?= (isset($client) ? $client->userid : "") ?>');
        }
        // Billing period
        $(document).on('click', '#modalClient .btn-billingperiod', function() {
            const buttonDetail = $(this);
            buttonDetail.button('loading');
            
            $.get(admin_url + 'clients/modal_billingperiod/' + customer_id + '/' + $(this).attr('data-idproduct'), function(data) {
                $('#modalClient #viewBillingPeriod .modal-body').html('');
                $('#modalClient #viewBillingPeriod .modal-body').html(data);

                // init event
                const tableBill = initDataTable('.table-billing-period', `${admin_url}clients/getBillingPeriod/${customer_id}/${buttonDetail.attr('data-idproduct')}` , [0], [3], {}, [1, 'ASC']);
                init_selectpicker();
                init_datepicker();
                
                _validate_form('#modalClient #formAddPeriod', {
                    'datePay': 'required',
                    'value': 'required',
                }, send_data_period_form);
                
                _validate_form('#modalClient #formAddPay', {
                    'datePay': 'required',
                    'realValue': 'required',
                    'idPaymentMethod': 'required',
                }, send_data_period_form);
                $('#modalClient #viewBillingPeriod').attr('data-idproduct', buttonDetail.attr('data-idproduct'));
                // Show
                $('#modalClient #viewBillingPeriod').modal('show');
                buttonDetail.button('reset');
            }).fail(() => {
                buttonDetail.button('reset');
            });

        });

        new_period = function() {
            if(typeof $('#modalClient #formAddPeriod').validate != 'undefined') {
                $('#modalClient #formAddPeriod').validate().resetForm();
            }
            $('#modalClient #addPeriod').modal('show');
            jQuery('#modalClient #formAddPeriod').prop('action', admin_url + 'clients/addPeriod/<?= (isset($client) ? $client->userid : "") ?>/<?= $this->input->get('id') ?>');
        }
        send_data_period_form = function(form) {
            var data = $(form).serialize();
            var url = form.action;
            
            let buttonSubmit = $(form).find('button[type="submit"]').button('loading');

            $.post(url, data).done(function(response) {
                response = JSON.parse(response);
                if(response.success == true){
                    alert_float('success',response.message);
                    $('#modalClient #addPeriod').modal('hide');
                    $('#modalClient #addPayment').modal('hide');
                    $('#modalClient .table-billing-period').DataTable().ajax.reload();

                    $(form)[0].reset();
                    
                    $(form).find('input').val('');
                    $(form).find('select').val('');
                    $(form).find('select').selectpicker('refresh');
                }
                else {
                    alert_float('danger',response.message);
                }
                buttonSubmit.button('reset');
            }).fail(function() {
                alert_float('danger', 'Lỗi nhận dữ liệu!');
                buttonSubmit.button('reset');
            });
            return false;
        }
        // Items
        $(function() {
            _validate_form($('#modalClient .form-item'),{
                'items[0][contractCode]': 'required',
                'items[0][contractStartDate]': 'required',
                'items[0][contractExpiryDate]': 'required',
                'items[0][city]': 'required',
                'items[0][district]': 'required',
                'items[0][menuBdsId]': 'required',
                'items[0][projectBdsId]': 'required',
                'items[0][type]': 'required',
                'items[0][price]': 'required',
                'items[0][dateStart]': 'required',
            },send_data_form);
        });

        function send_data_form(form) {
            var data = $(form).serialize();
            var url = form.action;
            $.post(url, data).done(function(response) {
                response = JSON.parse(response);
                if(response.success == true){
                    alert_float('success',response.message);
                }
                else {
                    alert_float('danger',response.message);
                }
                $(form)[0].reset();
                
                $('.selectpicker').val('');
                $('.selectpicker').change();
                $('.selectpicker').selectpicker('refresh');

                $(form).find('.datepicker').val('<?= date('Y-m-d') ?>');
                $('.table-client-items').DataTable().ajax.reload();
                $('#newProduct').modal('hide');
            });
            return false;
        }
        initDataTable('.table-client-items', admin_url + 'clients/clientItems/' + customer_id, [0], [0]);

        // Payment
        new_payment = function(stt, paymentId){
            if(typeof $('#formAddPay').validate != 'undefined') {
                $('#formAddPay').validate().resetForm();
                $('#formAddPay #datePay').val('<?=date('Y-m-d')?>');
                let buttonSubmit = $('#formAddPay').find('button[type="submit"]').button('reset');
            }

            $('#addPayment').modal('show');
            $('#addPayment').find('.edit-title').html('Thanh toán đợt '+stt);
            jQuery('#formAddPay').prop('action', admin_url + `clients/addPayment/${customer_id}/${$('#modalClient #viewBillingPeriod').attr('data-idproduct')}/`+paymentId);
        }
        view_payment = function(stt, paymentId) {
            const htmlTableDetail = `
            <?php
            $table_data = array(
                _l('STT'),
                _l('Ngày thanh toán'),
                _l('Số tiền'),
                _l('Thanh toán bằng'),
                _l('actions'),
            );
            render_datatable($table_data, 'billing-payment');
            ?>
            `;
            $('#viewPaymentList').find('.edit-title').html('Danh sách thanh toán đợt '+stt);
            $('#viewPaymentList').find('.modal-body').html(htmlTableDetail);
            $('#viewPaymentList').modal('show');
            initDataTable('.table-billing-payment', admin_url + `clients/getPayment/${$('#modalClient #viewBillingPeriod').attr('data-idproduct')}/` + paymentId , [0], [3], {}, [1, 'DESC']);
        }

        // paymenthistory
        initDataTable('.table-payment-history', admin_url + `clients/paymentHistory/${customer_id}` , [0], [3], {}, [2, 'DESC']);
        
        // contacts
        /* Custome profile contacts table */
        var not_sortable_contacts = $('.table-contacts').find('th').length -1;
        initDataTable('.table-contacts', admin_url + 'clients/contacts/' + customer_id, [not_sortable_contacts], [not_sortable_contacts]);
        function delete_contact_profile_image(contact_id){
            $.get(admin_url+'clients/delete_contact_profile_image/'+contact_id,function(){
            $('body').find('#contact-profile-image').removeClass('hide');
            $('body').find('#contact-remove-img').addClass('hide');
            $('body').find('#contact-img').attr('src','<?php echo base_url('assets/images/user-placeholder.jpg'); ?>');
            });
            }
            function validate_contact_form() {
            _validate_form('#contact-form', {
            firstname: 'required',
            lastname: 'required',
            password: {
                required: {
                depends: function(element) {
                    var sent_set_password = $('input[name="send_set_password_email"]');
                    if ($('#contact input[name="contactid"]').val() == '' && sent_set_password.prop('checked') == false) {
                    return true;
                    }
                }
                }
            },
            email: {
                required: true,
                email: true,
                remote: {
                url: admin_url + "misc/contact_email_exists",
                type: 'post',
                data: {
                    email: function() {
                    return $('#contact input[name="email"]').val();
                    },
                    userid: function() {
                    return $('body').find('input[name="contactid"]').val();
                    }
                }
                }
            }
            }, contactFormHandler);
        }

        function contactFormHandler(form) {
            $('#contact input[name="is_primary"]').prop('disabled', false);
            var formURL = $(form).attr("action");
            var formData = $(form)[0];
            var formData = new FormData(formData);
            $.ajax({
                type: 'POST',
                data: formData,
                mimeType: "multipart/form-data",
                contentType: false,
                cache: false,
                processData: false,
                url: formURL,
                success: function(response) {
                    response = JSON.parse(response);
                    if (response.success) {
                        alert_float('success', response.message);
                    }
                    if ($.fn.DataTable.isDataTable('.table-contacts')) {
                        $('.table-contacts').DataTable().ajax.reload();
                    }
                    if (response.proposal_warning && response.proposal_warning != false) {
                        $('body').find('#contact_proposal_warning').removeClass('hide');
                        $('body').find('#contact_update_proposals_emails').attr('data-original-email', response.original_email);
                        $('#contact').animate({ scrollTop: 0 }, 800);
                    } else {
                        $('#contact').modal('hide');
                    }
                },
                fail: function(data) {
                    response = JSON.parse(error.responseText);
                    alert_float('danger', response.message);
                }
            });
            return false;
        }

        contact = function(client_id, contact_id) {
            if (typeof(contact_id) == 'undefined') {
                contact_id = '';
            }
            $.post(admin_url + 'clients/contact/' + client_id + '/' + contact_id).done(function(response) {
                $('#contact_data').html(response);
                $('#contact').modal({show:true,backdrop:'static'});
                $('body').on('shown.bs.modal', '#contact', function() {
                    var contactid = $(this).find('input[name="contactid"]').val();
                    if (contact_id == '') {
                    $('#contact').find('input[name="firstname"]').focus();
                    }
                });
                init_selectpicker();
                init_datepicker();
                custom_fields_hyperlink();
                validate_contact_form();
            }).fail(function(error) {
                var response = JSON.parse(error.responseText);
                alert_float('danger', response.message);
            });
        }
        function update_all_proposal_emails_linked_to_contact(contact_id) {
            var data = {};
            data.update = true;
            data.original_email = $('body').find('#contact_update_proposals_emails').data('original-email');
            $.post(admin_url + 'clients/update_all_proposal_emails_linked_to_customer/' + contact_id, data).done(function(response) {
                response = JSON.parse(response);
                if (response.success) {
                    alert_float('success', response.message);
                }
                $('#contact').modal('hide');
            });
        }
        function do_share_file_contacts(edit_contacts,file_id) {
            var contacts_shared_ids = $('select[name="share_contacts_id[]"]');
            if(typeof(edit_contacts) == 'undefined' && typeof(file_id) == 'undefined'){
                var contacts_shared_ids_selected = $('select[name="share_contacts_id[]"]').val();
            } else {
                var _temp = edit_contacts.toString().split(',');
                for(var cshare_id in _temp){
                contacts_shared_ids.find('option[value="'+_temp[cshare_id]+'"]').attr('selected',true);
                }
                contacts_shared_ids.selectpicker('refresh');
                $('input[name="file_id"]').val(file_id);
                $('#customer_file_share_file_with').modal('show');
                return;
            }
            var file_id = $('input[name="file_id"]').val();
            $.post(admin_url+'clients/update_file_share_visibility',{
                file_id:file_id,
                share_contacts_id:contacts_shared_ids_selected,
                customer_id:$('input[name="userid"]').val()
            }).done(function(){
            window.location.reload();
            });
        }
        function fetch_lat_long_from_google_cprofile(){
            var data = {};
            data.address = $('input[name="address"]').val();
            data.city = $('input[name="city"]').val();
            data.country = $('select[name="country"] option:selected').text();
            $('#gmaps-search-icon').removeClass('fa-google').addClass('fa-spinner fa-spin');
            $.post(admin_url+'misc/fetch_address_info_gmaps',data).done(function(data){
                data = JSON.parse(data);
                $('#gmaps-search-icon').removeClass('fa-spinner fa-spin').addClass('fa-google');
                if(data.response.status == 'OK'){
                $('input[name="latitude"]').val(data.lat);
                $('input[name="longitude"]').val(data.lng);
                } else {
                if(data.response.status == 'ZERO_RESULTS'){
                    alert_float('warning',"<?php echo _l('g_search_address_not_found'); ?>")
                } else {
                    alert_float('danger',data.response.status);
                }
                }
            });
        }
        // change client type
        $(document).on('change', '#clientType', function() {
            let currentValue = $(this).val();
            let companyElements = $(`#companyName,#companyOfficeAddress,#companyPaymentAddress,
            #companyPhoneNumber,#companyTaxCode,#companyWebiste,#companyBusinessLines,#companyNote`);
            
            if(currentValue == "canhan") {
                $('a[href="#contacts"]').parent().hide();
                companyElements.val('');
                companyElements.attr('disabled', 'disabled');
            }
            else if(currentValue == "congty") {
                $('a[href="#contacts"]').parent().show();
                companyElements.removeAttr('disabled');
            }
        });
        // delete event
        $('body').on('click', '.delete-reminder-client-payment', function() {
            var r = confirm(confirm_action_prompt);
            const thisButton = $(this);
            if (r == false) {
                return false;
            } else {
                $.get($(this).attr('href'), function(response) {
                    alert_float(response.alert_type, response.message);
                    if(response.alert_type != 'danger') {
                        $('.table-billing-payment').DataTable().ajax.reload();
                        $('.table-billing-period').DataTable().ajax.reload();
                    }
                }, 'json');
            }
            return false;
        });

    });
</script>