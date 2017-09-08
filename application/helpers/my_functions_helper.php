<?php
    add_action('after_render_single_aside_menu','my_custom_menu_items');
    add_action('after_render_single_aside_menu','my_custom_menu_items1');

function my_custom_menu_items1($order){
    if($order == 3){
        echo '<li><a href="'.admin_url('newview').'"><i class="fa fa-balance-scale menu-icon" aria-hidden="true"></i>Danh sách loại BĐS</a></li>';
      
    }
}
function my_custom_menu_items($order){
    if($order == 11){
        echo '<li>';
        echo '<a href="#" aria-expanded="false"><i class="fa fa-balance-scale menu-icon"></i>
            marketing<span class="fa arrow"></span>
            </a>';

        echo '<ul class="nav nav-second-level collapse" aria-expanded="false">
              <li><a href="'.admin_url('clients/mail').'">Mail marketing</a></li>
              <li><a href="'.admin_url('clients/sms').'">SMS marketing</a></
              <li><a href="'.admin_url('surveys').'">Khảo sát</a></li>
              <li><a href="'.admin_url('goals').'">Theo dõi mục tiêu</a></li>
             </ul>';
        echo '</li>';
    }
}

?>