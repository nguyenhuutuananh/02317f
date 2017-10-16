<?php
$CI = get_instance();
$CI->load->add_package_path(messaging_get_base_path());



add_action("perfex_init", "messaging_init");
add_action("app_admin_head", "messaging_add_head_components");
//for customer
add_action("app_customers_head", "messaging_add_head_components");
add_action("after_js_scripts_render", "messaging_add_templates");
add_action("customers_after_js_scripts_load", "messaging_customer_add_templates");
add_action("after_js_scripts_render", "message_add_footer_component");
add_action("customers_after_js_scripts_load", "message_customer_add_footer_component");
add_action("customers_after_js_scripts_load", "message_add_customer_footer_component");
add_action("after_render_top_search", "messaging_add_messaging_icon");
add_action("after_load_client_language", "messaging_add_translations");
add_action("after_load_admin_language", "messaging_add_translations");

function messaging_init() {
    $CI = get_instance();


}
function messaging_add_translations($language) {
    $CI =& get_instance();
    //exit($language);

    return $language;
}
function messaging_get_base_path() {
    return str_replace("application".DIRECTORY_SEPARATOR, "", APPPATH).'plugins/messaging';
}
function messaging_add_messaging_icon() {
    $CI = &get_instance();
    echo $CI->load->view("messaging_chat_notification", "", true);
}
function message_add_customer_footer_component() {
    if (is_client_logged_in()) {
        $CI = &get_instance();
        echo "<div id='customer-chat-notification'>".$CI->load->view("messaging_chat_notification", "", true).'</div>';
    }
}
function messaging_add_head_components() {
    $CI = get_instance();
    $CI->lang->load("messaging","", false);
    echo '<link href="'.base_url('plugins/messaging/style.css').'" rel="stylesheet">';
}

function message_customer_add_footer_component() {
    if (is_client_logged_in()) {
        echo '<script src="'.base_url('plugins/messaging/jquery-ui.min.js').'"></script>';
        echo '<script src="'.base_url('plugins/messaging/script.js').'"></script>';
    }
}
function message_add_footer_component() {
   if (is_staff_logged_in() or is_client_logged_in()) {

       echo '<script src="'.base_url('plugins/messaging/script.js').'"></script>';
   }
}

function messaging_add_templates() {
    $CI = &get_instance();
    $CI->load->model('Messaging_model');
    if (is_staff_logged_in())echo $CI->load->view("messaging_chat_box", "", true);
}

function messaging_customer_add_templates() {
    $CI = &get_instance();
    if (is_client_logged_in())echo $CI->load->view("messaging_chat_box", "", true);
}

function messaging_get_staff_avatar($staff, $type = "small") {
    $url = base_url('assets/images/user-placeholder.jpg');
    if ($staff['profile_image']) {

        $url = base_url('uploads/staff_profile_images/' . $staff['staffid'] . '/' . $type . '_' . $staff['profile_image']);
    }
    return $url;
}
function messaging_get_contact_avatar($staff, $type = "small") {
    $url = base_url('assets/images/user-placeholder.jpg');
    if ($staff['profile_image']) {
        $url = base_url('uploads/client_profile_images/' . $staff['id'] . '/' . $type . '_' . $staff['profile_image']);
    }
    return $url;
}
function messaging_get_chat_avatar($message) {
    $CI = &get_instance();
    if ($message['member_id']) {
        return messaging_get_staff_avatar($CI->Messaging_model->findStaff($message['member_id']));
    } else {
        return messaging_get_contact_avatar($CI->Messaging_model->findContact($message['contact_id']));
    }
}
function is_chat_message_owner($message) {
    if (get_staff_user_id()) {
        if ($message['member_id'] == get_staff_user_id()) return true;
     } else {
        if ($message['contact_id'] == get_contact_user_id()) return true;
    }
    return false;
}
function lm($lang) {
    $CI = &get_instance();
    $language = get_option('active_language');
    if (is_staff_logged_in()) {
        $staff_language = get_staff_default_language();
        $language = $staff_language;
    } else {
        if (is_client_logged_in()) {
            $client_language = get_client_default_language();
            $language = $client_language;
        }
    }
    $CI->lang->load('messaging_lang', $language);
    return $CI->lang->line($lang);
}
function _lm($lang) {
    echo  lm($lang);
}


function messaging_mark_message_read($id) {
    $CI = get_instance();
    return $CI->Messaging_model->markRead($id);
}

function messaging_user_is_online($user) {
    $time = time() - 30;
    return ($user['last_active_time'] > $time);
}

function messaging_format_time($time) {
    return date('D M o g:ia', $time);
}
function messaging_format_message($message) {
    $emoticons = array(
        ':‑)' => base_url('plugins/messaging/emoticons/happy.png'),
        ':‑c' => base_url('plugins/messaging/emoticons/angry.png'),
        '%‑)' => base_url('plugins/messaging/emoticons/confused.png'),
        ":-‑(" => base_url('plugins/messaging/emoticons/crying.png'),
        ':*' => base_url('plugins/messaging/emoticons/in-love.png'),
        ':-*' => base_url('plugins/messaging/emoticons/kissing.png'),
        ':‑(' => base_url('plugins/messaging/emoticons/sad.png'),
        ':‑O' => base_url('plugins/messaging/emoticons/surprised.png'),
        ':‑P' => base_url('plugins/messaging/emoticons/tongue-out.png'),
        ":-‑)" => base_url('plugins/messaging/emoticons/unhappy.png'),

    );
    foreach($emoticons as $symbol => $image) {
        $message = str_replace($symbol, "<img src='$image'/>", $message);
    }
    return $message;
}

function messaging_can_create_group() {
    if (!is_staff_logged_in()) return false;
    $staffId = get_staff_user_id();
    $option = get_option('messaging_can_create_group');
    if ($option == 1) return true;
    $CI = &get_instance();
    $query = $CI->db->query("SELECT * FROM tblstaff WHERE active='1' AND staffid='$staffId' LIMIT 1");
    $staff = $query->row_array();
    if ($staff['admin'] !=1) return false;
    return true;
}