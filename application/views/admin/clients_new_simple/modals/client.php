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
                                                        if(isset($client) /*&& $type_client != 2*/) {
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

        </div>
    </div>
</div>


<script>
    $(function() {
        // init tag input
        $('#tags').tagit();

        var submitFlag = false;
        // Profile
        $(document).on('click', '.client-form-submiter', function(e) {
            if(submitFlag) return;
            submitFlag = true;

            e.stopImmediatePropagation();
            e.preventDefault();
            let buttonSubmit = $(this).button('loading');
            const data = $('.client-form-submiter').parents('form').serialize();

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