<?php init_head(); ?>
<style>
    .dd3-empty{
        background-color: #f1f1f1;
    }
</style>

<?php
if($type==1)
{
   $colum = array(
        'date_contact'=>'Ngày liên hệ',
        'source_name'=>'Nguồn',
        'partner'=> array(
             "title_th"   => 'Đối tác',
             'id_partner' => 'Phân loại Đối tác',
             'name_partner'=>'Họ Tên(Đối tác)',
             'phone_partner'=>'Số điện thoại(Đối tác)',
             'email_partner'=>'Email(Đối tác)'
        ),
         'clients' => array(
             "title_th"=>'Khách hàng',
             'company'=>'Tên khách hàng',
             'phonenumber'=>'Số điện thoại(KH)',
             'email'=>'Email(KH)',
             'name_country'=>'Quốc tịch'
        ),
         'area'=>array(
             "title_th" => 'Yêu cầu khu vực/DA',
             'name_menu_bds' => 'Loại bds'
             ,'province_name' => 'Quận khu vực',
             'name_bds'=>'DA'
            ),
         'time' => array(
             "title_th" => "Thời gian",
             "date_movein" => "Ngày move in",
             "date_tax"=>"Thời gian thuê"
            ),
         'detail'=>array(
             "title_th" => 'Yêu cầu chi tiết sản phẩm',
             'pn'=>'PN',
             'area'=>'DT',
             'budget'=>'Ngân sách khoản'
            ),
         'class_client_name'=>'Loại khách hàng',
         'name_exigency'=>'Nhu cầu',
         'name_purpose'=>'Mục đích',
         'requirements'=>'Yêu cầu khác',
         'name_status'=>'Trạng thái',
         'nvgd'=>'NV GD',
         'dksp'=>'DK SP',
         'dkkh'=>'ĐK khách hàng'
    );
    $columns = new stdClass();
    $columns->client_take_care = array(
        (object)array(
            'title_th'   => 'Ngày liên hệ',
            'id'         => 'date_contact',
            'childs' => [],
        ),
        (object)array(
            'title_th'   => 'Nguồn',
            'id'         => 'source_name',
            'childs' => [],
        ),
        (object)array(
            'title_th'   => 'Đối tác',
            'id'         => 'partner',
            'childs' => [
                (object)array(
                    'title_th' => 'Phân loại Đối tác',
                    'id'       => 'id_partner',
                ),
                (object)array(
                    'title_th' => 'Họ Tên(Đối tác)',
                    'id'       => 'name_partner',
                ),
                (object)array(
                    'title_th' => 'Số điện thoại(Đối tác)',
                    'id'       => 'phone_partner',
                ),
                (object)array(
                    'title_th' => 'Email(Đối tác)',
                    'id'       => 'email_partner',
                ),
            ],
        ),
        (object)array(
            'title_th'   => 'Khách hàng',
            'id'         => 'clients',
            'childs' => [
                (object)array(
                    'title_th' => 'Tên khách hàng',
                    'id'       => 'company',
                ),
                (object)array(
                    'title_th' => 'Số điện thoại(KH)',
                    'id'       => 'phonenumber',
                ),
                (object)array(
                    'title_th' => 'Email(KH)',
                    'id'       => 'email',
                ),
                (object)array(
                    'title_th' => 'Quốc tịch',
                    'id'       => 'name_country',
                ),
            ],
        ),
        (object)array(
            'title_th'   => 'Yêu cầu khu vực/DA',
            'id'         => 'area',
            'childs' => [
                (object)array(
                    'title_th' => 'Loại bds',
                    'id'       => 'name_menu_bds',
                ),
                (object)array(
                    'title_th' => 'Quận khu vực',
                    'id'       => 'province_name',
                ),
                (object)array(
                    'title_th' => 'DA',
                    'id'       => 'name_bds',
                ),
            ],
        ),
        (object)array(
            'title_th'   => 'Thời gian',
            'id'         => 'time',
            'childs' => [
                (object)array(
                    'title_th' => 'PN',
                    'id'       => 'pn',
                ),
                (object)array(
                    'title_th' => 'DT',
                    'id'       => 'area',
                ),
                (object)array(
                    'title_th' => 'Ngân sách khoản',
                    'id'       => 'budget',
                ),
            ],
        ),
        (object)array(
            'title_th'   => 'Yêu cầu chi tiết sản phẩm',
            'id'         => 'detail',
            'childs' => [
                (object)array(
                    'title_th' => 'Ngày move in',
                    'id'       => 'date_movein',
                ),
                (object)array(
                    'title_th' => 'Thời gian thuê',
                    'id'       => 'date_tax',
                ),
            ],
        ),
        (object)array(
            'title_th'   => 'Loại khách hàng',
            'id'         => 'class_client_name',
            'childs' => [],
        ),
        (object)array(
            'title_th'   => 'Nhu cầu',
            'id'         => 'name_exigency',
            'childs' => [],
        ),
        (object)array(
            'title_th'   => 'Mục đích',
            'id'         => 'name_purpose',
            'childs' => [],
        ),
        (object)array(
            'title_th'   => 'Yêu cầu khác',
            'id'         => 'requirements',
            'childs' => [],
        ),
        (object)array(
            'title_th'   => 'Trạng thái',
            'id'         => 'name_status',
            'childs' => [],
        ),
        (object)array(
            'title_th'   => 'NV GD',
            'id'         => 'nvgd',
            'childs' => [],
        ),
        (object)array(
            'title_th'   => 'DK SP',
            'id'         => 'dksp',
            'childs' => [],
        ),
        (object)array(
            'title_th'   => 'ĐK khách hàng',
            'id'         => 'dkkh',
            'childs' => [],
        ),
    );
    print_r($columns);
    exit();
}
?>

<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body _buttons">
                        <a href="#" onclick="save_menu();return false;" class="btn btn-info">Lưu bảng </a>
                        <a href="<?=admin_url()?>newview/rename_table" class="btn btn-info">Đổi tên bảng</a>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-md-6 border-right">
                            <h4 class="bold"><?php echo _l('active_menu_items'); ?></h4>
                            <hr />
                            <div class="dd active">
                                <ol class="dd-list">
                                    <?php if(count($get_column) == 0) { ?>
                                        <li class="dd-item dd3-empty"></li>
                                    <?php
                                    } else {
                                        foreach($get_column as $key => $item) {
                                    ?>
                                    <li class="dd-item dd3-item main" data-id="<?php echo $key; ?>" data-permission="<?php echo str_replace('"', "'", json_encode($item)); ?>">
                                        <div class="dd-handle dd3-handle"></div>
                                        <div class="dd3-content"><?php echo $ten; ?>
                                            <!-- <a href="#" class="text-muted toggle-menu-options main-item-options pull-right"><i class="fa fa-cog"></i></a> -->
                                        </div>
                                    </li>
                                    <?php
                                        }
                                    }
                                    ?>
                                    
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
<script src="<?php echo base_url(); ?>assets/plugins/jquery-nestable/jquery.nestable.js"></script>
<link href="<?php echo base_url(); ?>assets/plugins/font-awesome-icon-picker/css/fontawesome-iconpicker.min.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>assets/plugins/font-awesome-icon-picker/js/fontawesome-iconpicker.min.js"></script>
<script>
    $(function(){
        _formatMenuIconInput();
        $('.dd').nestable({
            maxDepth: 2
        });
        $('.toggle-menu-options').on('click', function(e) {
            e.preventDefault();
            menu_id = $(this).parents('li').data('id');
            if ($(this).hasClass('main-item-options')) {
                $(this).parents('li').find('.main-item-options[data-menu-options="' + menu_id + '"]').slideToggle();
            } else {
                $(this).parents('li').find('.sub-item-options[data-menu-options="' + menu_id + '"]').slideToggle();
            }
        });

        $('.icon-picker').iconpicker()
            .on({'iconpickerSetSourceValue': function(e){
                _formatMenuIconInput(e);
            }})
    });


    function save_menu() {
        var items = $('.dd.active').find('li.main');
        $.each(items, function() {
            var main_menu = $(this);
            var name = $(this).find('.main-item-options input.main-item-name').val();
            var url = $(this).find('.main-item-options input.main-item-url').val();
            var icon = $(this).find('.main-item-icon').val();
            main_menu.data('name', name);
            main_menu.data('url', url);
//            main_menu.data('permission', $(this).data('permission'));
            main_menu.data('icon', icon);

        });

        var sub_items = $('.dd.active li.sub-items');
        $.each(sub_items, function() {
            var sub_item = $(this);
            var name = $(this).find('.sub-item-options input.sub-item-name').val();
            var url = $(this).find('.sub-item-options input.sub-item-url').val();
            var icon = $(this).find('.main-item-icon').val();
            sub_item.data('name', name);
            sub_item.data('url', url);
//            sub_item.data('permission', $(this).data('permission'));
            sub_item.data('icon', icon);
        });

        var setup_menu_active = $('.dd.active').nestable('serialize');
        /* Inactive */
        var items_inactive = $('.dd.inactive').find('li.main');
        $.each(items_inactive, function() {
            var main_menu = $(this);
            var name = $(this).find('.main-item-options input.main-item-name').val();
            var url = $(this).find('.main-item-options input.main-item-url').val();
            var icon = $(this).find('.main-item-icon').val();
            main_menu.data('name', name);
            main_menu.data('url', url);
//            main_menu.data('permission', $(this).data('permission'));
            main_menu.data('icon', icon);

        });

        var sub_items = $('.dd.inactive li.sub-items');
        $.each(sub_items, function() {
            var sub_item = $(this);
            var name = $(this).find('.sub-item-options input.sub-item-name').val();
            var url = $(this).find('.sub-item-options input.sub-item-url').val();
            var icon = $(this).find('.main-item-icon').val();
            sub_item.data('name', name);
            sub_item.data('url', url);
//            sub_item.data('permission', $(this).data('permission'));
            sub_item.data('icon', icon);
        });

        var setup_menu_inactive = $('.dd.inactive').nestable('serialize');
        var data = {};
        data.active = setup_menu_active;
        data.inactive = setup_menu_inactive;
        data.type=<?=$type?>;
        console.log(data.inactive);
        $.post(admin_url + 'clients/update_order_table', data).done(function(result) {
            console.log(result);
            alert_float('success', result);
        })

    }

    function chuyenright()
    {
       var li_dd= $('.dd.active .dd-item.dd3-item.main');
        $('.dd.inactive ol').append(li_dd[0]);
    }
    function chuyenleft()
    {
       var li_dd= $('.dd.inactive .dd-item.dd3-item.main');
        $('.dd.active ol').append(li_dd[0]);
    }
    function dichuyen(_this)
    {
        var kiemtra=$('.dd.active').find(_this);
        if(kiemtra.length>0)
        {
            $('.dd.inactive ol').append(kiemtra);
        }
        else
        {
            var kiemtra2=$('.dd.inactive').find(_this);
            if(kiemtra2.length>0)
            {
                $('.dd.active ol').append(kiemtra2);
            }
        }

    }
</script>
</body>
</html>
