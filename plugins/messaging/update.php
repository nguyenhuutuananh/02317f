<?php
$CI = get_instance();
$db = $CI->db;

add_main_menu_item(array(
    'name' => _lm('messaging_messages'),
    'icon' => 'fa fa-times',
    'url' => base_url('messaging/messages'),
    'id' => 'messages'
),'');