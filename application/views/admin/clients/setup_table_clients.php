<?php init_head(); ?>
<style>
    .dd3-empty{
        background-color: #f1f1f1;
    }
</style>

<?php
if($type >= 1 && $type <= 3)
{
    $columns = isset($table_heads) ? $table_heads : array();
}
?>

<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body _buttons">
                        <a href="#" onclick="save_menu();return false;" class="btn btn-info">Lưu bảng </a>
                        <div class="pull-right">
                            <a href="<?=admin_url('clients')?>" class="btn btn-default">Trở lại </a>
                        </div>
                        
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
                                    <?php
                                    if(count($columns) > 0) {
                                        foreach($columns as $column) {
                                    ?>
                                    <li onclick="dichuyen(this)" class="dd-item dd3-item main" data-id="<?=$column->id?>">
                                        <div class="dd-handle dd3-handle"></div>
                                        <div class="dd3-content"><?=$column->title_th?></div>
                                    </li>
                                    <?php
                                        }
                                    }
                                    ?>
                                </ol>
                            </div>
                        </div>
                        <div class="col-md-6 border-right">
                            <h4 class="bold"><?php echo _l('inactive_menu_items'); ?></h4>
                            <hr />
                            <div class="dd inactive">
                                <ol class="dd-list">
                                    <?php
                                    if(isset($origin_table_heads) && count($origin_table_heads) > 0) {
                                        $temp_columns = $columns;
                                        foreach($temp_columns as $key=>$item) {
                                            $temp_columns[$key] = (array)$temp_columns[$key];
                                        }
                
                                        foreach($origin_table_heads as $key=>$column) {
                                            if(count($columns) == 0 || array_search($column->id, array_column($temp_columns, 'id')) === false) {
                                    ?>
                                    <li onclick="dichuyen(this)" class="dd-item dd3-item main" data-id="<?=$column->id?>">
                                        <div class="dd-handle dd3-handle"></div>
                                        <div class="dd3-content"><?=$column->title_th?></div>
                                    </li>
                                    <?php
                                            }
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
            maxDepth: 1
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
        $.post(admin_url + 'clients/update_order_table', data).done(function(result) {
            console.log(result);
            alert_float('success', result);
        });

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
