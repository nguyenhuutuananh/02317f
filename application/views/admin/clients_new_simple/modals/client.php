<?php
$convert_to = $this->input->get('convert_to');
if(!is_null($convert_to)) {
    
    if($convert_to >= 2 && $convert_to >= 3) {
        redirect('admin/clients_simple');
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
                                <?php echo render_inline_select('nvgd', $staff, array('staffid', 'lastname'), 'Nhân viên phụ trách', $selected, array()); ?>
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
                        <a class="btn btn-primary" href="<?=admin_url('clients_simple/client/')?><?=$client->userid?>?type_client=2&convert=true&back=1">Chuyển sang khách hàng FAIL</a>
                    </span>
                    <?php
                    }

                    if($type_client == 2 && $convert && !is_null($this->input->get('back'))) {
                        ?>
                    <span class="text-center">
                        <a class="btn btn-warning" href="<?=admin_url('clients_simple/client/')?><?=$client->userid?>?type_client=1&convert=true">Trở lại chuyển sang khách hàng MUA/THUÊ</a>
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

        </div>
    </div>
</div>


<script>
    $(function() {
       
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

        // Warning
        get_project = function(id)
        {
            jQuery.ajax({
                type: "post",
                dataType:'json',
                url: "<?= admin_url() ?>clients_simple/get_project/"+id.value,
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
                url: "<?= admin_url() ?>clients_simple/get_district/"+id.value,
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
                url:admin_url+"clients_simple/getProduct/<?= (isset($client) ? $client->userid : '') ?>/"+id,
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
                                    $(v).html("<p class='form-control-static'>"+item.cityName+"</p>");
                                    break;
                                case 1:
                                    $(v).html("<p class='form-control-static'>"+item.districtName+"</p>");
                                    break;
                                case 2:
                                    $(v).html("<p class='form-control-static'>"+item.menuBdsName+"</p>");
                                    break;
                                case 3:
                                    $(v).html("<p class='form-control-static'>"+item.project_name+"</p>");
                                    break;
                                case 4:
                                    $(v).html("<p class='form-control-static'>"+(item.type == 1 ? "Mua" : "Thuê")+"</p>");
                                    break;
                                case 5:
                                    $(v).html("<p class='form-control-static'>"+formatNumber(item.price)+"</p>");
                                    break;
                                case 6:
                                    $(v).html("<p class='form-control-static'>"+(item.type == 1 ? "Không" : (item.rentalPeriod + ' tháng'))+"</p>");
                                    break;
                                case 7:
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
            jQuery('#id_type').prop('action', admin_url + 'clients_simple/addProduct/<?= (isset($client) ? $client->userid : "") ?>');
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