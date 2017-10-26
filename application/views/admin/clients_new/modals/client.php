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

<style>
    fieldset 
    {
        border: 1px solid #ddd !important;
        margin: 5px 0px;
        
        xmin-width: 0;
        padding: 10px;       
        position: relative;
        border-radius:4px;
        background-color:#f5f5f5;
        padding-left:10px!important;
    }   
    
    legend
    {
        font-size:14px;
        font-weight:bold;
        margin-bottom: 0px; 
        width: 35%; 
        border: 1px solid #ddd;
        border-radius: 4px; 
        padding: 5px 5px 5px 10px; 
        background-color: #ffffff;
    }
    ul.tagit {
        margin: 5px;
        background-color: white;
        border: 1px solid black !important;
    }
</style>

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
            <li role="presentation" class="">
                <a href="#contacts" aria-controls="contacts" role="tab" data-toggle="tab">
                    <?php echo _l('Liên hệ'); ?>
                </a>
            </li>
            
            <li role="presentation" class="">
                <a href="#permission" aria-controls="permission" role="tab" data-toggle="tab">
                    <?php echo _l('Phân quyền'); ?>
                </a>
            </li>
            
            <li role="presentation" class="">
                <a href="#clientHistory" aria-controls="clientHistory" role="tab" data-toggle="tab">
                    <?php echo _l('Nhật ký khách hàng'); ?>
                </a>
            </li>

            <li role="presentation" class="">
                <a href="#task" aria-controls="task" role="tab" data-toggle="tab">
                    <?php echo _l('Lịch sử chăm sóc KH'); ?>
                </a>
            </li>
            <?php
                    if($client->type_client != 1) {
            ?>
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
            
            <?php
                }
            ?>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="view_project">
                <?php echo form_open_multipart('http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'], array('class' => 'clients-bds-form form-horizontal', 'autocomplete' => 'off')); ?>
                
                
                <table class="table table-single-client table-bordered">
                    <tbody>
                        <tr>
                            <td colspan="2" style="background-color: #b3d7f5;">
                                <b>KHÁCH HÀNG <?=(isset($client) ? "(MÃ KH: ".$client->userid.")" : "")?></b>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <fieldset>
                                    <legend>Khách hàng</legend>
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

                                    <?php 
                                        $value = (isset($client) ? $client->phonenumber : ''); 
                                        echo render_inline_input('phonenumber', 'Số điện thoại', $value); 
                                    ?>
                                    <?php 
                                        $value = (isset($client) ? $client->email : '');
                                        echo render_inline_input('email', 'Email', $value); 
                                    ?>
                                    <?php 
                                        $selected = (isset($client) ? $client->country : '');
                                        echo render_inline_select('country', $countries, array('country_id', 'short_name'), 'Quốc tịch', $selected, array()); 
                                    ?>
                                    <?php
                                    $options = array(
                                        array(
                                            'id' => 'nam',
                                            'value' => 'Nam',
                                        ),
                                        array(
                                            'id' => 'nu',
                                            'value' => 'Nữ',
                                        ),
                                    );
                                    $gender = (isset($client) ? $client->gender : '');
                                    echo render_inline_select('gender', $options, array('id', 'value'), 'Giới tính', $gender, array(), array(), '', '', false);
                                    ?>
                                    <?php 
                                        $value = (isset($client) ? $client->career : ''); 
                                        echo render_inline_input('career', 'Ngành nghề', $value); 
                                    ?>
                                    <?php 
                                        $value = (isset($client) ? $client->position : ''); 
                                        echo render_inline_input('position', 'Chức vụ', $value); 
                                    ?>
                                    <?php 
                                        $value = (isset($client) ? $client->hobbies : ''); 
                                        echo render_inline_input('hobbies', 'Sở thích', $value); 
                                    ?>
                                    <?php 
                                        $value = (isset($client) ? $client->dateOfBirth : ''); 
                                        echo render_inline_date_input('dateOfBirth', 'Ngày sinh', $value); 
                                    ?>
                                    <?php 
                                        $value = (isset($client) ? $client->maritalStatus : ''); 
                                        echo render_inline_input('maritalStatus', 'Tình trạng hôn nhân', $value); 
                                    ?>
                                    <?php 
                                        $value = (isset($client) ? $client->facebook : ''); 
                                        echo render_inline_input('facebook', 'Facebook', $value); 
                                    ?>
                                    <?php 
                                        $value = (isset($client) ? $client->relationship : ''); 
                                        echo render_inline_input('relationship', 'Quan hệ', $value); 
                                    ?>
                                    <?php
                                    if(isset($client)) {
                                    ?>
                                    <div class="form-group text-center">
                                        <label for="avatar" class="col-sm-4 control-label profile-image"><?php echo _l('Hình đại diện'); ?></label>
                                        <div class="col-sm-8">
                                        <input size="10" type="file" onchange="readURL(this, '#avatar_view');"  class="form-control" id="avatar" />
                                        </div>
                                        
                                        <img id="avatar_view" src="<?php echo (isset($client) && file_exists($client->avatar) ? base_url($client->avatar) : base_url('assets/images/preview_no_available.jpg')) ?>" style="max-width: 100px;"/>
                                    </div>
                                    <script type="text/javascript">
                                        function readURL(input, output_img) {
                                            if (input.files && input.files[0]) {
                                                var reader = new FileReader();
                                                reader.onload = function (e) {
                                                    $(output_img)
                                                        .attr('src', e.target.result)
                                                        .width(100);
                                                };

                                                reader.readAsDataURL(input.files[0]);
                                                var data = new FormData();
                                                data.append('avatar', input.files[0]);

                                                jQuery.ajax({
                                                    url: admin_url+'clients/updateAvatar/<?=$client->userid?>',
                                                    data: data,
                                                    cache: false,
                                                    contentType: false,
                                                    processData: false,
                                                    method: 'POST',
                                                    dataType: 'json',
                                                    success: function(data){
                                                        if(data.success) {
                                                            alert_float('success', 'Cập nhật ảnh đại diện thành công!');
                                                        }
                                                        else {
                                                            alert_float('danger', 'Cập nhật ảnh đại diện thất bại!');
                                                        }
                                                    }
                                                });
                                            }
                                        }
                                    </script>
                                    <?php 
                                    }
                                    ?>
                                </fieldset>
                            </td>
                            <td>
                                <fieldset>
                                    <legend>Công ty</legend>
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
                                        $value = (isset($client) ? $client->companyOfficeAddress : '');
                                        echo render_inline_input('companyOfficeAddress', 'Địa chỉ VP', $value, 'text', $company);
                                    ?>
                                    
                                    <?php
                                        $value = (isset($client) ? $client->companyPhoneNumber : '');
                                        echo render_inline_input('companyPhoneNumber', 'Số đt bàn', $value, 'text', $company);
                                    ?>
                                    
                                    <?php
                                        $value = (isset($client) ? $client->companyPaymentAddress : '');
                                        echo render_inline_input('companyPaymentAddress', 'Địa chỉ viết HĐ', $value, 'text', $company);
                                    ?>
                                    <?php
                                        $value = (isset($client) ? $client->companyTaxCode : '');
                                        echo render_inline_input('companyTaxCode', 'Mã số thuế', $value, 'text', $company);
                                    ?>
                                    <?php
                                        $value = (isset($client) ? $client->companyWebiste : '');
                                        echo render_inline_input('companyWebiste', 'Website', $value, 'text', $company);
                                    ?>
                                    <?php
                                        $value = (isset($client) ? $client->companyBusinessLines : '');
                                        echo render_inline_input('companyBusinessLines', 'Lĩnh vực KD', $value, 'text', $company);
                                    ?>
                                    <?php
                                        $value = (isset($client) ? $client->companyNote : '');
                                        $companyNote = $company;
                                        $companyNote['rows'] = 10;
                                        echo render_inline_textarea('companyNote', 'Ghi chú', $value, $companyNote);
                                    ?>
                                </fieldset>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <fieldset>
                                    <legend>Phân loại khách hàng</legend>
                                    <?php $selected = (isset($client) ? $client->source : ''); ?>
                                    <?php echo render_inline_select('source', $source, array('id', 'name'), 'Nguồn', $selected, array()); ?>
                                    <?php 
                                        $options = array(
                                            array(
                                                'id' => 5,
                                                'value' => 5,
                                            ),
                                            array(
                                                'id' => 4,
                                                'value' => 4,
                                            ),
                                            array(
                                                'id' => 3,
                                                'value' => 3,
                                            ),
                                            array(
                                                'id' => 2,
                                                'value' => 2,
                                            ),
                                            array(
                                                'id' => 1,
                                                'value' => 1,
                                            ),
                                        );
                                        $selected = (isset($client) ? $client->priority : '');
                                        echo render_inline_select('priority', $options, array('id', 'value'), 'Mức độ ưu tiên', $selected, array(), array(), '', '', false);
                                    ?>
                                    <?php $selected = (isset($client) ? $client->class_type : ''); ?>
                                    <?php echo render_inline_select('class_type', $class_client, array('id', 'name'), 'Dạng KH', $selected, array()); ?>
                                    
                                    <!-- Undone: , Số lần giao dịch -->
                                    <?php 
                                        $options = array(
                                            array(
                                                'id' => 'dienthoai',
                                                'value' => 'Điện thoại',
                                            ),
                                            array(
                                                'id' => 'viber',
                                                'value' => 'Viber',
                                            ),
                                            array(
                                                'id' => 'sms',
                                                'value' => 'SMS',
                                            ),
                                            array(
                                                'id' => 'facebook',
                                                'value' => 'Facebook',
                                            ),
                                            array(
                                                'id' => 'whatsapp',
                                                'value' => 'Whatsapp',
                                            ),
                                            array(
                                                'id' => 'khac',
                                                'value' => 'Khác',
                                            ),
                                        );
                                        $selected = (isset($client) ? $client->contactBy : '');
                                        echo render_inline_select('contactBy', $options, array('id', 'value'), 'Hành vi liên hệ', $selected);
                                    ?>
                                </fieldset>        
                            </td>
                            <td>
                                <fieldset>
                                        <legend>Nhận xét KH</legend>
                                        <textarea style="width: 100%;border: none;" rows="10" name=""><?=(isset($client) ? $client->review : '')?></textarea>
                                </fieldset>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="background-color: #d0d3d6;">
                                <b>NHU CẦU KHÁCH HÀNG</b>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <table class="table">
                                    <tr>
                                        <td>
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
                                                <?php $selected = (isset($client) ? $client->purpose : ''); ?>
                                                <?php echo render_inline_select('purpose', $purpose, array('id', 'name'), 'Mục đích', $selected, array()); ?>
                                                
                                                <?php
                                                    if(isset($client) && $type_client != 2) {
                                                        $type_bds_selected = $client->type_bds;
                                                        $id_project_bds = get_project_from_type($type_bds_selected);
                                                    }
                                                    echo render_inline_select('type_bds', $menu_project, array('id', 'menu_name'), 'Loại bất động sản', $type_bds_selected, array('onchange' => 'get_project(this)'));
                                                ?>

                                                <?php
                                                    $province_selected = 0;
                                                    if(isset($client) /*&& $type_client != 2*/) {
                                                        $province_selected = $client->province;
                                                    }
                                                    echo render_inline_select('province', $province, array('provinceid', 'name', 'type'), 'Tỉnh/Thành phố', $province_selected, array('onchange' => 'get_district_client(this)')); 
                                                ?>
                                                
                                                <?php
                                                    if(isset($client) /*&& $type_client != 2*/) {
                                                        $district = get_district_from_city($province_selected);
                                                        $district_selected = $client->district;
                                                    }
                                                    echo render_inline_select('district', $district, array('districtid', 'name', 'type'), 'Quận/huyện', $district_selected, array()); 
                                                ?>

                                                <?php
                                                    if(isset($client) /*&& $type_client != 2*/) {
                                                        $bds_selected = $client->bds;
                                                    }
                                                    echo render_inline_select('bds', $id_project_bds, array('id', 'project_name', 'code'), 'Dự án', $bds_selected, array()); 
                                                ?>
                                                <?php
                                                // if($type_client == 2) {
                                                //     $type_options = array(
                                                //         array(
                                                //             'id' => 1,
                                                //             'value' => 'Mua'
                                                //         ),
                                                //         array(
                                                //             'id' => 2,
                                                //             'value' => 'Thuê'
                                                //         ),
                                                //     );
                                                //     echo render_inline_select('', $type_options, array('id', 'value'), 'Hình thức', '', array(), array(), '', '', false);
                                                // }
                                                ?>
                                            </fieldset>
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
                                            <fieldset>
                                                <legend>Yêu cầu khác</legend>
                                                <?php $value = (isset($client) ? $client->requirements : ''); ?>
                                                <input style="width: 100%" type="text" name="requirements" id="requirements" value="<?=$value?>" />

                                            </fieldset>
                                        </td>

                                        <td>
                                            <fieldset>
                                                <legend>Thuê</legend>
                                                <?php
                                                    $attribute_rent = array();
                                                    if($type_client != 2) {
                                                        $attribute_rent['disabled'] = 'disabled';
                                                    }
                                                ?>
                                                <?php
                                                    $value = (isset($client) ? $client->date_movein : '');
                                                    echo render_inline_date_input('date_movein', 'Ngày dọn vào', $value, 'text', $attribute_rent);
                                                ?>
                                                <?php
                                                    $value = (isset($client) ? $client->date_tax : '');
                                                    echo render_inline_input('date_tax', 'Thời hạn thuê', $value, 'text', $attribute_rent);
                                                ?>
                                                
                                            </fieldset>
                                        </td>

                                        <td style="width: 33%">
                                            <fieldset>
                                                <div class="col-md-12">
                                                    <?php $selected = (isset($client) ? $client->status : ''); ?>
                                                    <?php echo render_inline_select('status', $status, array('id', 'name'), 'Trạng thái', $selected, array()); ?>
                                                    <?php
                                                        $value = (isset($client) ? $client->date_contact : '');
                                                        echo render_inline_date_input('date_contact', 'Ngày liên hệ', $value);
                                                    ?>
                                                    <?php
                                                        $mobilephone_text = ( isset($client) ? $client->tags : "");
                                                    ?>
                                                    <div class="form-group">
                                                        <label for="tags" class="control-label"><i class="fa fa-tag" aria-hidden="true"></i> 
                                                        <?php echo _l('Tag'); ?></label>
                                                        <input type="text" value="<?=$mobilephone_text?>" id="tags" name="tags" data-role="tagsinput">
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </td>
                                    </tr>
                                </table>
                                
                                

                                
                            </td>
                        </tr>
                    </tbody>
                </table>
                <button type="button" class="btn btn-info mtop20 only-save client-form-submiter">
                    <?php echo _l('submit'); ?>
                </button>
                <?php echo form_close(); ?>
            </div>
            <div role="tabpanel" class="tab-pane" id="clientHistory">
                <h4 class="no-mtop bold"><?php echo _l('home_project_activity'); ?></h4>
                <hr />
                <div class="row">
                    
                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                    <?php
                        echo render_date_input('dateMeeting', 'Ngày', _l(date("Y/m/d H:i:s")));
                    ?>
                    </div>

                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                    <?php
                        echo render_textarea('status', 'Tình hình khách hàng');
                    ?>
                    </div>

                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                    <?php
                        echo render_textarea('solutions', 'Hướng giải quyết');
                    ?>
                    </div>

                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                        <button class="btn btn-primary" id="btnSave" type="button">Lưu <br /><kbd><kbd>CTRL</kbd> + <kbd>S</kbd></kbd></button>
                    </div>                    
                </div>
                <hr />
                <style type="text/css">
                    .well {
                        padding: 10px;
                    }
                </style>
                <div class="activity-feed">
                    
                </div>
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
                    _l('Hoa hồng'),
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
                                        echo render_inline_input('items[0][realPrice]', 'Giá trị dự án');
                                        ?>

                                        <?php
                                        echo  render_inline_input('items[0][price]', 'Hoa hồng');
                                        ?>
                                        <?php
                                            $selected = (isset($client) ? $client->id_partner : '');
                                            echo render_inline_select('items[0][id_partner]', $id_partner, array('id_partner', 'name_partner'), 'Môi giới', $selected);
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
                                            echo render_inline_select('items[0][WhatsAgencyHave]', $options, array('id', 'name'), 'Môi giới có', $selected);
                                        ?>
                                        <?php
                                        echo  render_inline_input('items[0][commissionPartner]', 'Hoa hồng cho môi giới');
                                        ?>
                                        <?php
                                        $value = (isset($client) ? $client->date_tax : '');
                                        echo render_inline_input('items[0][rentalPeriod]', 'Thời hạn thuê', $value);
                                        ?>
                                        <?php
                                        $value = (isset($client) ? $client->date_movein : '');
                                        echo render_inline_date_input('items[0][dateStart]', 'Ngày mua/thuê', $value);
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
                                        echo render_inline_input('items[0][realPrice]', 'Giá trị dự án');
                                        ?>

                                        <?php
                                        echo  render_inline_input('items[0][price]', 'Hoa hồng');
                                        ?>
                                        <?php
                                            $selected = (isset($client) ? $client->id_partner : '');
                                            echo render_inline_select('items[0][id_partner]', $id_partner, array('id_partner', 'name_partner'), 'Môi giới', $selected);
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
                                            echo render_inline_select('items[0][WhatsAgencyHave]', $options, array('id', 'name'), 'Môi giới có', $selected);
                                        ?>
                                            <?php
                                            echo  render_inline_input('items[0][commissionPartner]', 'Hoa hồng cho môi giới');
                                            ?>
                                        <?php
                                        $value = (isset($client) ? $client->date_tax : '');
                                        echo render_inline_input('items[0][rentalPeriod]', 'Thời hạn thuê', $value);
                                        ?>
                                        <?php
                                        $value = (isset($client) ? $client->date_movein : '');
                                        echo render_inline_date_input('items[0][dateStart]', 'Ngày mua/thuê', $value);
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
        // init tag input
        $('#tags').tagit();

        // Task
        initDataTable('.table-rel-tasks','<?= admin_url() ?>tasks/init_relation_tasks/<?= $client->userid ?>/customer' , [0], [3]);
        var submitFlag = false;
        // Profile
        $(document).on('click', '.client-form-submiter', function(e) {
            if(submitFlag) return;
            submitFlag = true;

            e.stopImmediatePropagation();
            e.preventDefault();
            let buttonSubmit = $(this).button('loading');
            const data = $('.client-form-submiter').parents('form').serialize();

            jQuery.each(jQuery('#avatar')[0].files, function(i, file) {
                data.append('file-'+i, file);
            });

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
                    else {
                        setTimeout(() => {
                            buttonSubmit.button('reset');
                            submitFlag = false;
                        }, 2000);
                    }
                }
                else {
                    alert_float('danger', data.message);
                    setTimeout(() => {
                        buttonSubmit.button('reset');
                        submitFlag = false;
                    }, 2000);
                }
                
                
            }).fail(() => {
                setTimeout(() => {
                    buttonSubmit.button('reset');
                    submitFlag = false;
                }, 2000);
            });
        });

        <?php
            if($client) {
        ?>
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

        // client care history
        $.ajax({
            url: admin_url + 'clients/activityClient/<?=(isset($client) ? $client->userid : '')?>',
            method: 'GET',
            dataType: 'json',
        }).done((data) => {
            data.forEach((obj) => {
                $('.activity-feed').prepend(`
                        <div class="feed-item">
                            <div class="date text text-primary">
                                <a data-toggle="tooltip" data-title="<?=get_staff_full_name(isset($client) ? $client->userid : '')?>" href="<?=admin_url('profile/' . isset($client) ? $client->userid : '')?>">
                                <?=staff_profile_image(isset($client) ? $client->userid : '', array('staff-profile-image-small')) . ' ' . get_staff_full_name(isset($client) ? $client->userid : '')?></a>
                                
                                <span class="badge">${obj.dateMeeting}</span> <a href="#" style="color: red;font-size: 13px"><i class="fa fa-times"></i></a>
                            </div>
                            <div class="text">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5>Tình hình khách hàng: </h5>
                                        <p class="bold no-mbot well">
                                        <button type="button" class="btn btn-info"><i class="fa fa-pencil-square-o"></i></button>
                                            ${obj.status}
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <h5>Hướng giải quyết:</h5> 
                                        <p class="bold no-mbot well">
                                            ${obj.solutions}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `);
            });
            $('#clientHistory [data-toggle="tooltip"]').tooltip(); 
        });
        let inSaveProcess = false;
        $(document).on('click', '#btnSave', function() {
            if(inSaveProcess) return;
            console.log(inSaveProcess);
            inSaveProcess = true;
            let saveButton = $(this);
            let dateMeeting = $('#clientHistory #dateMeeting');
            let historyStatus = $('#clientHistory #status');
            let historySolutions = $('#clientHistory #solutions');
            
            if(dateMeeting.val().trim() == '') {
                alert_float('danger', 'Vui lòng chọn ngày');
                dateMeeting.focus();
                // Clear Float message
                setTimeout(()=>{
                    $('#alert_float_1').remove();
                }, 2000);
                return;
            }
            
            // disable all element
            dateMeeting.attr('disabled', 'disabled');
            historyStatus.attr('disabled', 'disabled');
            historySolutions.attr('disabled', 'disabled');
            saveButton.button('loading');

            // Ajax 
            $.ajax({
                url: admin_url + 'clients/activityClient/<?=(isset($client) ? $client->userid : '')?>',
                data: {dateMeeting: dateMeeting.val(), status: historyStatus.val(), solutions: historySolutions.val()},
                dataType: 'json',
                method: 'POST',
            }).done((data) => {
                if(data.success) {
                    $('.activity-feed').prepend(`
                        <div class="feed-item">
                            <div class="date text text-primary">
                                <a data-toggle="tooltip" title="<?=get_staff_full_name(isset($client) ? $client->userid : '')?>" href="<?=admin_url('profile/' . isset($client) ? $client->userid : '')?>">
                                <?=staff_profile_image(isset($client) ? $client->userid : '', array('staff-profile-image-small'), 'small', array('alt' => get_staff_full_name(isset($client) ? $client->userid : '') ))?></a>
                                
                                <span class="badge">${dateMeeting.val()}</span>
                            </div>
                            <div class="text">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5>Tình hình khách hàng:</h5>
                                        <p class="bold no-mbot well">
                                            ${historyStatus.val()}
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <h5>Hướng giải quyết:</h5> 
                                        <p class="bold no-mbot well">
                                            ${historySolutions.val()}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `);
                    dateMeeting.val('<?=_l(date("Y/m/d H:i:s"))?>');
                    alert_float('success', data.message);
                }
                else {
                    alert_float('danger', data.message);
                }
                $('#clientHistory [data-toggle="tooltip"]').tooltip(); 
            })
            .fail(() => {

            })
            .always(() => {
                dateMeeting.removeAttr('disabled');
                historyStatus.removeAttr('disabled');
                historySolutions.removeAttr('disabled');

                historyStatus.val('');
                historySolutions.val('');

                setTimeout(() => {
                    saveButton.button('reset');
                    inSaveProcess = false;
                }, 2000);
            });
        });
        $(document).on('keydown', function(e) {
            if(e.key == 's' && e.ctrlKey == true) {
                e.preventDefault();
                e.stopPropagation();
                $('#btnSave').trigger('click');
            }
            
        });

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
                    console.log($('#items[0][projectBdsId], #bds'));
                    $('[name="items[0][projectBdsId]"], #bds').html(option).selectpicker('refresh');

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
                    $('#district').html(option).selectpicker('refresh');

                }
            });
        }
        $(document).on('keyup', '[name="items[0][commissionPartner]"], [name="items[0][realPrice]"], [name="items[0][price]"], #value, #realValue', (e) => {
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
                                    $(v).html("<p class='form-control-static'>"+formatNumber(item.realPrice)+"</p>");
                                    break;
                                case 9:
                                    $(v).html("<p class='form-control-static'>"+formatNumber(item.price)+"</p>");
                                    break;
                                case 10:
                                    $(v).html("<p class='form-control-static'>"+item.name_partner+"</p>");
                                    break; 
                                case 11:
                                    $(v).html("<p class='form-control-static'>"+(item.WhatsAgencyHave == 'cokhachhang' ? "Có khách hàng" : (item.WhatsAgencyHave == 'cochunha' ? "Có chủ nhà" : ""))+"</p>");
                                    break;
                                case 12:
                                    $(v).html("<p class='form-control-static'>"+formatNumber(item.commissionPartner)+"</p>");
                                    break;
                                case 13:
                                    $(v).html("<p class='form-control-static'>"+(item.type == 1 ? "Không" : (item.rentalPeriod + ' tháng'))+"</p>");
                                    break;
                                case 14:
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
                
                setTimeout(() => {
                    buttonDetail.button('reset');
                }, 2000);
            }).fail(() => {
                setTimeout(() => {
                    buttonDetail.button('reset');
                }, 2000);
            });

        });

        new_period = function() {
            if(typeof $('#modalClient #formAddPeriod').validate != 'undefined') {
                $('#modalClient #formAddPeriod').validate().resetForm();
            }
            $('#modalClient #addPeriod').modal('show');
            jQuery('#modalClient #formAddPeriod').prop('action', admin_url + 'clients/addPeriod/<?= (isset($client) ? $client->userid : "") ?>/' + $('#viewBillingPeriod').attr('data-idproduct'));
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
                
                setTimeout(() => {
                    buttonSubmit.button('reset');
                }, 2000);
            }).fail(function() {
                alert_float('danger', 'Lỗi nhận dữ liệu!');
                setTimeout(() => {
                    buttonSubmit.button('reset');
                }, 2000);
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

                $(form).find('.datepicker').val('');
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
                $('#formAddPay #datePay').val('');
                let buttonSubmit = $('#formAddPay').find('button[type="submit"]');
                setTimeout(() => {
                    buttonSubmit.button('reset');
                }, 2000);
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
                _l('Nhân viên nhận'),
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
                
                // 
                let fieldsetPartner = $('[for="id_partner"]').text('Môi giới').parents('fieldset');

                fieldsetPartner.find('legend').text('Môi giới');
                fieldsetPartner.find('[for="WhatsAgencyHave"]').text('Môi giới có');

                // $('a[href="#contacts"]').parent().hide();
                companyElements.val('');
                companyElements.attr('disabled', 'disabled');
            }
            else if(currentValue == "congty") {

                // 
                let fieldsetPartner = $('[for="id_partner"]').text('Thư ký/trợ lý').parents('fieldset');

                fieldsetPartner.find('legend').text('Thư ký/trợ lý');
                fieldsetPartner.find('[for="WhatsAgencyHave"]').text('Thư ký/trợ lý có');

                // $('a[href="#contacts"]').parent().show();
                companyElements.removeAttr('disabled');
            }
        });
        $('#clientType').trigger('change');
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
    <?php } ?>
    });
</script>