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
                <?php echo form_open('http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'], array('class' => 'form-item form-horizontal', 'autocomplete' => 'off')); ?>
                <div class="row">
                    <?php 
                    $convert = $this->input->get('convert');
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
                            echo render_inline_input('items[0][contractCode]', _l('client_contract_code'));
                            ?>

                            <?php
                            echo render_inline_date_input('items[0][contractStartDate]', _l('client_contract_startdate'));
                            ?>

                            <?php
                            echo render_inline_date_input('items[0][contractExpiryDate]', _l('client_contract_expirydate'));
                            ?>

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
                                echo render_inline_input('items[0][realPrice]', 'Giá trị dự án');
                            ?>
                            <?php
                                echo render_inline_input('items[0][price]', 'Hoa hồng');
                            ?>

                            <?php
                                $value = (isset($client) ? $client->date_tax : '');
                                echo render_inline_input('items[0][rentalPeriod]', 'Thời hạn thuê', $value);
                            ?>
                            
                            <?php
                                $value = (isset($client) ? $client->date_movein : '');
                                echo render_inline_date_input('items[0][dateStart]', 'Ngày mua/thuê', $value);
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
                            if($type_client == 1) {
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
                    
                    
                </div>
                <button type="submit" class="btn btn-info mtop20 only-save">
                    <?php echo _l('submit'); ?>
                </button>
                <?php echo form_close(); ?>
            </div>

        </div>
    </div>
</div>


<script>
var converting = false;
var send_data_convert_form = function(form) {
        if(converting) return;
        converting = true;
        var data = $(form).serialize();
        
        $.post(admin_url + 'clients/updateConvert/' + $('#modalClient #userid').val() + '?type_client=' + $('#modalClient').attr('data-typeclient'), data).done(function(response) {
            response = JSON.parse(response);
            if(response.success == true){
                alert_float('success',response.message);

            }
            else {
                alert_float('danger',response.message);
            }
            
            $('.table-clients').DataTable().ajax.reload();
            $('#modalClient').modal('hide');
            converting = false;
        }).fail(() => {
            converting = false;
        });

        return false;
    };
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
        },send_data_convert_form);
        
       $(document).on('keyup', '[name="items[0][realPrice]"], [name="items[0][price]"], #value, #realValue', (e) => {
            const current = $(e.currentTarget);
            var charCode = (e.which) ? e.which : event.keyCode
            
            // Remove grop seperate

            current.val( current.val().replace(/\D/g, '') );
            current.val(formatNumber(current.val()));
        });
    });
</script>