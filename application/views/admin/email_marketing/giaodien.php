<?php     $this->load->view('admin/includes/head');
          $this->load->view('admin/includes/header');
?>

<style>
    #wrapper{
        margin: 0 0 0 0px!important;
    }
    .hide-menu{display: none;}
    .admin #side-menu, .admin #setup-menu {
        background: #e9ebef;
    }
    #side-menu li > a {
        border: 2px dashed #000;
        color: #000;
        text-transform: uppercase;
        padding: 12px 20px 12px 16px;
        font-size: 13px;
    }
    #side-menu.nav>li>a:focus, #side-menu.nav>li>a:hover {
        border-bottom: 2px dashed #000 !important;
    }
    #side-menu li .nav-second-level li a {
        padding: 7px 10px 7px 45px;
        color: #0181BB;
        text-transform: none;
        font-size: 14px;
        border: 0px;
    }
    #side-menu li{
        margin: 15px 0px;
    }
    .drop-title{
        padding: 0px;
        font-size: 25px;
        /* padding: 60px 0px 70px 0px; */
        /* margin-bottom: 25px; */
        border-radius: 50%;
        width: 200px;
        background: red;
        height: 200px;
        margin: auto;
        position: relative;
    }
    .drop-title a{
        /* background: red; */
        /* border-radius: 50%; */
        /* height: 50px; */
        color: #fff;
        /* width: 50px; */
        /* padding-top: 53px; */
        top: 69px;
        left: 10px;
    }

</style>
<div id="wrapper">
    <div class="content">
        <?php
            $menu_active       = get_option('aside_menu_active');
            $menu_active       = json_decode($menu_active);
            $menu_inactive     =get_option('aside_menu_inactive');
            $menu_inactive       = json_decode($menu_inactive);
        ?>
        <h2 class="text-center tc padding">QUẢN LÝ HỆ THỐNG KHÁCH HÀNG</h2>
        <div class="row">
            <?php include_once(APPPATH . 'views/admin/includes/alerts.php'); ?>
            <?php do_action( 'before_start_render_dashboard_content'); ?>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="drop-title text-center" style=" background: #f43737;">
                    <a href="http://192.168.1.19/02617F/admin/clients">
                        <div style="height: 100%">
                            <span style="position: relative; top: 29%;">QUẢN LÝ<br> KINH DOANH</span>
                        </div>
                    </a>
                </div>
                <aside class="sidebar">
                    <ul class="nav metis-menu" id="side-menu">

                        <?php foreach($menu_active->aside_menu_active as $key=>$value){?>
                            <?php $find=0;?>
                            <?php foreach($menu_inactive->aside_menu_inactive as $not_key=>$not_value){?>
                                <?php if($value->id==$not_value->id){$find=1;break;}?>
                            <?php }?>
                                <?php if($value->type==1&&$find==0){?>
                                    <li class="menu-item-<?=$value->id?> <?=($value->children)?' drop':''?>">
                                        <a href="<?=($value->url!='#'&&!$value->children)?admin_url().$value->url:'javascript:void(0)'?>" aria-expanded="false">
                                            <i class="<?=$value->icon?>"></i>
                                            <?=_l($value->name)?>
                                        </a>
                                        <?php if($value->children){?>
                                            <ul class="nav nav-second-level collapse" aria-expanded="false">
                                                <?php foreach($value->children as $r=>$v){?>
                                                    <li class="sub-menu-item-<?=$v->id?>">
                                                        <a href="<?=$v->url?>"><?=_l($v->name)?></a>
                                                    </li>
                                                <?php }?>
                                            </ul>
                                        <?php }?>
                                    </li>
                            <?php }?>
                        <?php }?>
                    </ul>
                </aside>
            </div>
            <div class="col-md-3">
                <div class="drop-title text-center" style=" background: #f43737;">
                    <a href="http://192.168.1.19/02617F/admin/clients">
                        <div style="height: 100%">
                            <span style="position: relative; top: 29%;">QUẢN LÝ<br> KẾ TOÁN</span>
                        </div>
                    </a>
                </div>
                <aside class="sidebar">
                    <ul class="nav metis-menu" id="side-menu">
                        <?php foreach($menu_active->aside_menu_active as $key=>$value){?>
                            <?php $find=0;?>
                            <?php foreach($menu_inactive->aside_menu_inactive as $not_key=>$not_value){?>
                                <?php if($value->id==$not_value->id){$find=1;break;}?>
                            <?php }?>
                            <?php if($value->type==2&&$find==0){?>
                                <li class="menu-item-<?=$value->id?> <?=($value->children)?' drop':''?>">
                                    <a href="<?=($value->url!='#'&&!$value->children)?admin_url().$value->url:'javascript:void(0)'?>" aria-expanded="false">
                                        <i class="<?=$value->icon?>"></i>
                                        <?=_l($value->name)?>
                                        <?=($value->children)?' <span class="fa arrow"></span>':''?>
                                    </a>
                                    <?php if($value->children){?>
                                        <ul class="nav nav-second-level collapse" aria-expanded="false">
                                            <?php foreach($value->children as $r=>$v){?>
                                                <li class="sub-menu-item-<?=$v->id?>">
                                                    <a href="<?=$v->url?>"><?=_l($v->name)?></a>
                                                </li>
                                            <?php }?>
                                        </ul>
                                    <?php }?>
                                </li>
                            <?php }?>
                        <?php }?>
                    </ul>
                </aside>
            </div>
            <div class="col-md-3">
                <div class="drop-title text-center" style=" background:#f58632;">
                    <a href="http://192.168.1.19/02617F/admin/clients">
                        <div style="height: 100%">
                            <span style="position: relative; top: 24%;">QUẢN LÝ<br>KỸ THUẬT<br>VÀ LẮP ĐẶT</span>
                        </div>
                    </a>
                </div>
                <aside class="sidebar">
                    <ul class="nav metis-menu" id="side-menu">
                        <?php foreach($menu_active->aside_menu_active as $key=>$value){?>
                            <?php $find=0;?>
                            <?php foreach($menu_inactive->aside_menu_inactive as $not_key=>$not_value){?>
                                <?php if($value->id==$not_value->id){$find=1;break;}?>
                            <?php }?>
                            <?php if($value->type==3&&$find==0){?>
                                <li class="menu-item-<?=$value->id?> <?=($value->children)?' drop':''?>">
                                    <a href="<?=($value->url!='#'&&!$value->children)?admin_url().$value->url:'javascript:void(0)'?>" aria-expanded="false">
                                        <i class="<?=$value->icon?>"></i>
                                        <?=_l($value->name)?>
                                        <?=($value->children)?' <span class="fa arrow"></span>':''?>
                                    </a>
                                    <?php if($value->children){?>
                                        <ul class="nav nav-second-level collapse" aria-expanded="false">
                                            <?php foreach($value->children as $r=>$v){?>
                                                <li class="sub-menu-item-<?=$v->id?>">
                                                    <a href="<?=$v->url?>"><?=_l($v->name)?></a>
                                                </li>
                                            <?php }?>
                                        </ul>
                                    <?php }?>
                                </li>
                            <?php }?>
                        <?php }?>
                    </ul>
                </aside>
            </div>
            <div class="col-md-3">
                <div class="drop-title text-center" style=" background:#175f96;">
                    <a href="http://192.168.1.19/02617F/admin/clients">
                        <div style="height: 100%">
                            <span style="position: relative; top: 29%;">QUẢN LÝ<br>MARKETING</span>
                        </div>
                    </a>
                </div>
                <aside class="sidebar">
                    <ul class="nav metis-menu" id="side-menu">
                        <?php foreach($menu_active->aside_menu_active as $key=>$value){?>
                            <?php $find=0;?>
                            <?php foreach($menu_inactive->aside_menu_inactive as $not_key=>$not_value){?>
                                <?php if($value->id==$not_value->id){$find=1;break;}?>
                            <?php }?>
                            <?php if($value->type==4&&$find==0){?>
                                <li class="menu-item-<?=$value->id?> <?=($value->children)?' drop':''?>">
                                    <a href="<?=($value->url!='#'&&!$value->children)?admin_url().$value->url:'javascript:void(0)'?>" aria-expanded="false">
                                        <i class="<?=$value->icon?>"></i>
                                        <?=_l($value->name)?>
                                        <?=($value->children)?' <span class="fa arrow"></span>':''?>
                                    </a>
                                    <?php if($value->children){?>
                                        <ul class="nav nav-second-level collapse" aria-expanded="false">
                                            <?php foreach($value->children as $r=>$v){?>
                                                <li class="sub-menu-item-<?=$v->id?>">
                                                    <a href="<?=$v->url?>"><?=_l($v->name)?></a>
                                                </li>
                                            <?php }?>
                                        </ul>
                                    <?php }?>
                                </li>
                            <?php }?>
                        <?php }?>
                    </ul>
                </aside>
            </div>
        </div>
    </div>
</div>
</div>
<script>
    google_api = '<?php echo $google_api_key; ?>';
    calendarIDs = '<?php echo json_encode($google_ids_calendars); ?>';
</script>
<?php init_tail(); ?>
<?php $this->load->view('admin/utilities/calendar_template'); ?>
<?php $this->load->view('admin/includes/dashboard_js'); ?>
<?php $this->load->view('admin/includes/scripts'); ?>
<script type="text/javascript">
        $('body').addClass('hide-sidebar');
</script>
<script type="text/javascript">
    $('.drop').click(function() {
        $(this).find('.nav-second-level').toggleClass('collapse');
    })
</script>
</body>
</html>
