<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body _buttons">
                        <a href="#" onclick="save_menu();return false;" class="btn btn-info"><?php echo _l('utilities_menu_save'); ?></a>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <?php
                        $colum=array('code'=>'Mã sản phẩm','province_name'=>'Thành phố','district_name'=>'Quận/Huyện','type_pn'=>'Phòng ngủ',
                            'door_direction_name'=>'Hướng cửa',
                            'fullname'=>'Tên Khách hàng','numberphone'=>'Số điện thoại','email'=>'Email','furniture_name'=>'đồ nội thất',
                            'convenient'=>'Tiện nghĩ','characteristics'=>'Đặc điểm sản phẩm','date_update'=>'Ngày lọc',
                            'exigency_name'=>'Nhu cầu','price'=>'Giá(VND)','cost'=>'Giá(USD)','status'=>'Tình trạng',
                            'detail_price'=>'Giá Gồm','deadline'=>'Thời gian thuê','code_tax'=>'Mã thuế','staff_id'=>'Nhân viên tạo','bonus'=>'Bonus','note'=>'Ghi chú','tag'=>'Thẻ');
                        $colum_2=array();
                        if(count($render_colum)>0){
                            foreach($render_colum as $rom){
                                $colum_2[$rom['id_input'].'_'.$rom['id_field']]=$rom['name'];
                            }
                        }
                        $get_colum=array_merge($colum,$colum_2);
                        $order_colums= json_decode($order_colum->active);
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
                                    if(count($render_colum)==0)
                                                                        {
                                         echo '<li class="dd-item dd3-empty"></li>';
                                    }
                                    foreach($get_colum as $rom=> $item){
                                        ?>
                                        <?php foreach($order_colums as $r){?>
                                            <?php if($rom==$r->id){?>
                                                <li class="dd-item dd3-item main" data-id="<?php echo $rom; ?>" data-permission="<?php echo $item; ?>">
                                                    <div class="dd-handle dd3-handle"></div>
                                                    <div class="dd3-content"><?php echo _l($item); ?>
                                                        <a href="#" class="text-muted toggle-menu-options main-item-options pull-right"><i class="fa fa-cog"></i></a>
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
                                        <?php if(count($render_colum)==0){ ?>
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
                                                <li class="dd-item dd3-empty"></li>
                                                <li class="dd-item dd3-item main" data-id="<?php echo $rom; ?>" data-permission="<?php echo $item; ?>">
                                                    <div class="dd-handle dd3-handle"></div>
                                                    <div class="dd3-content"><?php echo _l($item);; ?>
                                                        <a href="#" class="text-muted toggle-menu-options main-item-options pull-right"><i class="fa fa-cog"></i></a>
                                                    </div>
                                                </li>
                                            <?php }?>
                                            <?php $i++; } ?>
                                        </ol>
                                    </div>

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
        data.id_menu=<?=$id_menu?>;
        $.post(admin_url + 'newview/update_order_table', data).done(function(result) {
            alert_float('success', result);
        })

    }
</script>
</body>
</html>
