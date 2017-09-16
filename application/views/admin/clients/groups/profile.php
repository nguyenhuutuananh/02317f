<?php
$convert_to = $this->input->get('convert_to');
if(!is_null($convert_to)) {
    
    if($convert_to >= 2 && $convert_to >= 3) {
        redirect('admin/clients');
    }
}
?>
<a  href="<?= admin_url() ?>clients">
    <button type="button" class="btn btn-default  pull-right">
        Trở lại
    </button>
</a>
<h4 class="bold no-margin"><?php echo _l('Thông tin Khách hàng '); ?></h4>

<hr class="no-mbot no-border" />
<div class="row">
    <div class="additional"></div>
    <div class="col-md-12">
        <ul class="nav nav-tabs profile-tabs" role="tablist">
            <li role="presentation" class="active">
                <a href="#view_client" aria-controls="view_project" role="tab" data-toggle="tab">
                    <?php echo _l('Chi tiết'); ?>
                </a>
            </li>
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
                                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                        <?php $value = (isset($client) ? $client->company : ''); ?>
                                        <?php echo render_inline_input('company', 'Tên Khách hàng', $value); ?>
                                        <?php $value = (isset($client) ? $client->email : ''); ?>
                                        <?php echo render_inline_input('email', 'Email', $value); ?>
                                        <?php $selected = (isset($client) ? $client->exigency : ''); ?>
                                        <?php echo render_inline_select('exigency', $exigency, array('id', 'name'), 'Nhu cầu', $selected, array()); ?>
                                    </div>
                                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                        <?php $selected = (isset($client) ? $client->purpose : ''); ?>
                                        <?php echo render_inline_select('purpose', $purpose, array('id', 'name'), 'Mục đích', $selected, array()); ?>
                                        <?php $value = (isset($client) ? $client->phonenumber : ''); ?>
                                        <?php echo render_inline_input('phonenumber', 'Số điện thoại', $value); ?>
                                    </div>
                                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                        <?php $selected = (isset($client) ? $client->country : ''); ?>
                                        <?php echo render_inline_select('country', $countries, array('country_id', 'short_name'), 'Quốc tịch', $selected, array()); ?>
                                        <!--                                                        --><?php //$selected=( isset($client) ? $client->type_client : ''); ?>
                                        <!--                                                        --><?php //echo render_inline_select( 'type_client', array(array('id'=>1,'name'=>'Khách hàng đang quan tâm'),array('id'=>2,'name'=>'Khách hàng mua/thuê'),array('id'=>3,'name'=>'Khách hàng fail')),array('id','name'),'Loại khách hàng',$selected,array()); ?>
                                        <?php $selected = (isset($client) ? $client->source : ''); ?>
                                        <?php echo render_inline_select('source', $source, array('id', 'name'), 'Nguồn', $selected, array()); ?>
                                    </div>

                                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                        <?php $selected = (isset($client) ? $client->class_type : ''); ?>
                                        <?php echo render_inline_select('class_type', $class_client, array('id', 'name'), 'Loại khách hàng', $selected, array()); ?>
                                        
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
                                
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    <?php $selected = (isset($client) ? $client->status : ''); ?>
                                    <?php echo render_inline_select('status', $status, array('id', 'name'), 'Trạng thái', $selected, array()); ?>
                                    <?php $selected = (isset($client) ? $client->nvgd : ''); ?>
                                    <?php echo render_inline_select('nvgd', $staff, array('staffid', 'lastname'), 'Nhân viên giám định', $selected, array()); ?>
                                </div>

                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    <?php $value = (isset($client) ? $client->requirements : ''); ?>
                                    <?php echo render_inline_input('requirements', 'Yêu cầu khác', $value); ?>
                                </div>
                            </fieldset>
                        </div>
                        <div class="clearfix">
                        </div>
                        <?php
                        }
                        ?>
                        <p class="text-dark text-uppercase" style="text-align: center;"></p>
                        <hr class="no-mtop">
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <fieldset>
                                <legend>
                                <?php
                                    if($type_client != 2) {
                                        ?>
                                            Yêu cầu khu vực dự án    
                                        <?php
                                    }
                                    else {
                                        ?>
                                            Thông tin sản phẩm
                                        <?php
                                    }
                                ?>
                                    
                                </legend>
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
                                
                            </fieldset>
                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <?php
                                if($type_client == 1 || $type_client == 3)
                                {
                            ?>
                            <fieldset>
                                <legend>Yêu Cầu Chi Tiết SP</legend>
                                <?php $value = (isset($client) ? $client->pn : ''); ?>
                                <?php echo render_inline_input('pn', 'Phòng ngủ', $value); ?>

                                <?php $value = (isset($client) ? $client->budget : ''); ?>
                                <?php echo render_inline_input('budget', 'Ngân sách khoản', $value); ?>
                                <?php $value = (isset($client) ? $client->area : ''); ?>
                                <?php echo render_inline_input('area', 'Diện tích', $value); ?>
                            </fieldset>
                            <?php
                                }
                            ?>
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
                        
                        
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <?php if ( ($type_client == 2 && !$convert) || ($type_client == 1 && $convert)) { ?>
                                <p class="text-dark text-uppercase" style="text-align: center;"></p>
                                <hr class="no-mtop">
                                <fieldset>
                                    <legend>Hoa hồng</legend>

                                        <div class="col-md-6">
                                            <?php $value = (isset($client) ? $client->status_bonus : ''); ?>
                                            <?php echo render_inline_input('status_bonus', 'Trạng thái hoa hồng', $value); ?>
                                            <button type="button" class="btn btn-success" onclick="append_colum()">
                                                Thêm Đợt Thanh toán Hoa hồng
                                            </button>
                                        </div>
                                        
                                        <div class="clearfix">
                                        
                                        </div>
                                        
                                        <hr />
                                        
                                        <div class="col-md-3 time_bonus">
                                            <?php if (isset($client)) {
                                                $time_bonus = explode(',', $client->time_bonus);
                                                $num_bonus = explode(',', $client->num_bonus);
                                                ?>
                                                <?php foreach ($time_bonus as $num => $rom) { ?>
                                                    <fieldset class="fieldset review_bonus_<?= $num + 1 ?>">
                                                        <legend class="legend">Đợt: <?= $num + 1 ?>  <a href="javacript:void(0)" class="text-danger _delete" onclick="remove_field(<?= $num + 1 ?>)"><i class="fa fa fa-times"></i></a></legend>
                                                        <div class="form-group">
                                                            <label for="time_bonus" class="control-label label-time">Ngày thu tiền đợt: <?= $num + 1 ?></label>
                                                            <div class="input-group date">
                                                                <input type="text"  name="time_bonus[]" class="form-control datepicker" value="<?= $rom ?>">
                                                                <div class="input-group-addon">
                                                                    <i class="fa fa-calendar calendar-icon"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="num_bonus" class="control-label label-num">Đợt: <?= $num + 1 ?></label>
                                                            <input type="text"  name="num_bonus[]" class="form-control" value="<?= $num_bonus[$num] ?>">
                                                        </div>
                                                    </fieldset>


                                                <?php 
                                            } ?>
                                        </div>
                                    <?php 
                                    } ?>
                                </fieldset>
                                <?php 
                                } ?>
                        </div>
                        

                    </div>
                <div>
                    <button class="btn btn-info mtop20 only-save customer-form-submiter">
                        <?php echo _l('submit'); ?>
                    </button>
                </div>
                    <?php echo form_close(); ?>
            </div>

        </div>
    </div>
</div>