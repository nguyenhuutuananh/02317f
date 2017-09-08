<?php init_head(); ?>
<style>
    .dd3-empty{
        background-color: #f1f1f1;
    }
</style>

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
                    <?php if(!$get_colum){?>
                        <div class="panel-body">
                        <?php
                        if($get_colum)
                        {
                            $get_colum=(array)json_decode($get_colum);
                        }
                        else{
                            $get_colum=array();
                        }
                        if($type==1)
                        {
                            $colum=array(
                                'date_contact'=>'Ngày liên hệ',
                                'source_name'=>'Nguồn',
                                'partner'=>array("title_th"=>'Đối tác','id_partner'=>'Phân loại Đối tác','name_partner'=>'Họ Tên(Đối tác)','phone_partner'=>'Số điện thoại(Đối tác)','email_partner'=>'Email(Đối tác)'),
                                'clients'=>array("title_th"=>'Khách hàng','company'=>'Tên khách hàng','phonenumber'=>'Số điện thoại(KH)','email'=>'Email(KH)','name_country'=>'Quốc tịch'),
                                'area'=>array("title_th"=>'Yêu cầu khu vực/DA','name_menu_bds'=>'Loại bds','province_name'=>'Quận khu vực','name_bds'=>'DA'),
                                'time'=>array("title_th"=>"Thời gian","date_movein"=>"Ngày move in","date_tax"=>"Thời gian thuê"),
                                'detail'=>array("title_th"=>'Yêu cầu chi tiết sản phẩm','pn'=>'PN','area'=>'DT','budget'=>'Ngân sách khoản'),
                                'class_client_name'=>'Loại khách hàng',
                                'name_exigency'=>'Nhu cầu',
                                'name_purpose'=>'Mục đích',
                                'requirements'=>'Yêu cầu khác',
                                'name_status'=>'Trạng thái',
                                'nvgd'=>'NV GD',
                                'dksp'=>'DK SP',
                                'dkkh'=>'ĐK khách hàng'
                            );
                        }
                        ?>
                        <div class="clearfix"></div>
                        <div class="row">
                            <div class="col-md-6 border-right">
                                <h4 class="bold">Các Mục hiển thị trên bảng</h4>
                                <hr />
                                <div class="dd active">
                                    <?php
                                    $i = 1;
                                    echo '<ol class="dd-list">';
                                    if(count($colum)==0)
                                                                        {
                                         echo '<li class="dd-item dd3-empty"></li>';
                                    }
                                    foreach($get_colum as $rom=> $item){
                                        ?>
                                        <?php foreach($colum as $r){?>
                                            <?php $value_th_array=(array)$item->permission;?>
                                            <?php if(count($value_th_array)>1){?>
                                                <?php if($value_th_array['title_th']==$r['title_th']){?>
                                                    <li  class="dd-item dd3-item main" data-id="\<?=json_encode($item->permission); ?>" data-permission="<?php echo $item; ?>">
                                                        <div class="dd-handle dd3-handle"></div>
                                                        <div class="dd3-content"><?php echo $r['title_th'] ?>
                                                            <a href="#" class="text-muted toggle-menu-options main-item-options pull-right">
                                                            </a>
                                                        </div>
                                                    </li>
                                                <?php }?>
                                            <?php } else {?>
                                                <?php if($item->permission==$r){?>
                                                    <li  class="dd-item dd3-item main" data-id="<?php echo $rom; ?>" data-permission="<?php echo $item; ?>">
                                                        <div class="dd-handle dd3-handle"></div>
                                                        <div class="dd3-content"><?php echo $r ?>
                                                            <a href="#" class="text-muted toggle-menu-options main-item-options pull-right">
                                                            </a>
                                                        </div>
                                                    </li>
                                                <?php }?>
                                            <?php }?>
                                        <?php }?>
                                        <?php $i++; } ?>
                                    </ol>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h4 class="bold">Các Mục không hiển thị trên bảng</h4>
                                <hr />
                                    <div class="dd inactive">
                                        <?php
                                        $i = 1;
                                        echo '<ol class="dd-list">'; ?>
                                        <?php if(count($get_colum)==0){ ?>
                                            <li class="dd-item dd3-empty"></li>
                                        <?php } ?>
                                        <?php
                                        foreach($get_colum as $rom=> $item){
                                            $i=0;
                                            ?>
                                            <?php foreach($order_colums as $r){?>
                                                <?php if($rom==$r->id){
                                                    $i=1;
                                                }?>
                                            <?php }?>
                                            <?php if($i==0){?>
                                                <li class="dd-item dd3-item main" data-id="<?php echo $rom; ?>" data-permission="<?php echo $item; ?>">
                                                    <div class="dd-handle dd3-handle"></div>
                                                    <div class="dd3-content"><?php echo _l($item);; ?>
                                                        <a href="#" class="text-muted toggle-menu-options main-item-options pull-right"></a>
                                                    </div>
                                                </li>
                                            <?php }?>
                                            <?php $i++; } ?>
                                        </ol>
                                    </div>

                            </div>
                        </div>
                    </div>
                    <?php }
                    else
                    {
                    ?>
                        <div class="panel-body">
                            <?php
                               if($type==1)
                                {
                                    $colum=array(
                                        'date_contact'=>'Ngày liên hệ',
                                        'source_name'=>'Nguồn',
                                        'partner'=>array("title_th"=>'Đối tác','id_partner'=>'Phân loại Đối tác','name_partner'=>'Họ Tên(Đối tác)','phone_partner'=>'Số điện thoại(Đối tác)','email_partner'=>'Email(Đối tác)'),
                                        'clients'=>array("title_th"=>'Khách hàng','company'=>'Tên khách hàng','phonenumber'=>'Số điện thoại(KH)','email'=>'Email(KH)','name_country'=>'Quốc tịch'),
                                        'area'=>array("title_th"=>'Yêu cầu khu vực/DA','name_menu_bds'=>'Loại bds','province_name'=>'Quận khu vực','name_bds'=>'DA'),
                                        'time'=>array("title_th"=>"Thời gian","date_movein"=>"Ngày move in","date_tax"=>"Thời gian thuê"),
                                        'detail'=>array("title_th"=>'Yêu cầu chi tiết sản phẩm','pn'=>'PN','area'=>'DT','budget'=>'Ngân sách khoản'),
                                        'class_client_name'=>'Loại khách hàng',
                                        'name_exigency'=>'Nhu cầu',
                                        'name_purpose'=>'Mục đích',
                                        'requirements'=>'Yêu cầu khác',
                                        'name_status'=>'Trạng thái',
                                        'nvgd'=>'NV GD',
                                        'dksp'=>'DK SP',
                                        'dkkh'=>'ĐK khách hàng'
                                    );
                                }
                            ?>
                            <?php
                            $colum_2=array();
                            if($order_colums)
                            {
                                $order_colums=json_decode($order_colums);
                            }
                            else
                            {
                                $order_colums=$colum;
                            }
                            $order_colums= json_decode($get_colum);
                            $get_colum=$colum;
                            ?>
                            <div class="clearfix"></div>
                            <div class="row">
                                <div class="col-md-6 border-right">
                                    <h4 class="bold">Các Mục hiển thị trên bảng</h4>
                                    <hr />
                                    <div class="dd active">
                                        <?php
                                        $i = 1;
                                        echo '<ol class="dd-list">';
                                        {
                                            echo '<li class="dd-item dd3-empty"></li>';
                                        }
                                        foreach($order_colums as $r){
                                            ?>
                                            <?php foreach($get_colum as $rom=> $item){?>
                                                <?php if($rom==$r){?>
                                                    <li class="dd-item dd3-item main" onclick="dichuyen(this)" data-id="<?php echo $rom; ?>" data-permission="<?php echo $item; ?>">
                                                        <div class="dd-handle dd3-handle"></div>
                                                        <div class="dd3-content"><?php echo _l($item); ?>
                                                            <a href="#" class="text-muted toggle-menu-options main-item-options pull-right"></a>
                                                        </div>
                                                    </li>
                                                <?php }?>
                                            <?php }?>
                                            <?php $i++; } ?>
                                        </ol>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h4 class="bold">Các Mục không hiển thị trên bảng</h4>
                                    <hr />
                                    <div class="dd inactive">
                                        <?php
                                        $i = 1;
                                        echo '<ol class="dd-list">'; ?>
                                        <?php if(count($render_colum)!=0){ ?>
                                            <li class="dd-item dd3-empty"></li>
                                        <?php } ?>
                                        <?php
                                        foreach($get_colum as $rom=> $item){
                                            $i=0;
                                            ?>
                                            <?php foreach($order_colums as $r){?>
                                                <?php if($rom==$r->id){
                                                    $i=1;
                                                }?>
                                            <?php }?>
                                            <?php if($i==0){?>
                                                <li class="dd-item dd3-item main" onclick="dichuyen(this)" data-id="<?php echo $rom; ?>" data-permission='<?php if(!is_array($item)) echo $item; else echo \json_encode($item); ?>'>
                                                    <div class="dd-handle dd3-handle"></div>
                                                    <div class="dd3-content"><?php if(!is_array($item)) echo _l($item); else echo _l($item['title_th']);?>
                                                        <a href="#" class="text-muted toggle-menu-options main-item-options pull-right"></a>
                                                    </div>
                                                </li>
                                            <?php }?>
                                            <?php $i++; } ?>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                    <?php }?>
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