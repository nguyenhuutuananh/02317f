<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Messaging extends CRM_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('authentication_model');
        $this->authentication_model->autologin();
        if (is_staff_logged_in()) {
            load_admin_language();
        } else {
            load_client_language();
        }
        $this->load->model('Messaging_model');
        $this->load->model('payment_modes_model');
        $this->load->model('settings_model');
    }
    public function index() {

    }

    public function messages() {
        $data['title'] = lm("messaging_messages");
        $data['cid'] = $this->input->get('cid');
        $this->load->view('messaging_messages_index', $data);
    }

    public function settings() {
        if (!has_permission('settings', '', 'view')) {
            access_denied('settings');
        }
   //     exit($this->load->view('message_settings_page', '', true));
        if ($this->input->post()) {
            if (!has_permission('settings', '', 'edit')) {
                access_denied('settings');
            }
            $logo_uploaded    = (handle_company_logo_upload() ? true : false);
            $favicon_uploaded = (handle_favicon_upload() ? true : false);

            $post_data = $this->input->post(NULL, FALSE);
            $success   = $this->settings_model->update($post_data);
            if ($success > 0) {
                set_alert('success', _l('settings_updated'));
            }

            if ($logo_uploaded || $favicon_uploaded) {
                set_debug_alert(_l('logo_favicon_changed_notice'));
            }

            // Do hard refresh on general for the logo
            if ($this->input->get('group') == 'general') {
                redirect(admin_url('settings?group=' . $this->input->get('group')), 'refresh');
            } else {
                redirect(base_url('messaging/settings'));
            }
        }
        $this->load->model('taxes_model');
        $this->load->model('tickets_model');
        $this->load->model('leads_model');
        $data['taxes']                                   = $this->taxes_model->get();
        $data['ticket_priorities']                       = $this->tickets_model->get_priority();
        $data['ticket_priorities']['callback_translate'] = 'ticket_priority_translate';
        $data['roles']                                   = $this->roles_model->get();
        $data['leads_sources']                           = $this->leads_model->get_source();
        $data['leads_statuses']                          = $this->leads_model->get_status();
        $data['title']                                   = _l('options');
        if (!$this->input->get('group') || ($this->input->get('group') == 'update' && !is_admin())) {
            $view = 'general';
        } else {
            $view = $this->input->get('group');
        }
        if ($view == 'update') {
            if (!extension_loaded('curl')) {
                $data['update_errors'][] = 'CURL Extension not enabled';
                $data['latest_version']  = 0;
                $data['update_info']     = json_decode("");
            } else {
                $data['update_info'] = $this->misc_model->get_update_info();
                if (strpos($data['update_info'], 'Curl Error -') !== FALSE) {
                    $data['update_errors'][] = $data['update_info'];
                    $data['latest_version']  = 0;
                    $data['update_info']     = json_decode("");
                } else {
                    $data['update_info']    = json_decode($data['update_info']);
                    $data['latest_version'] = $data['update_info']->latest_version;
                    $data['update_errors']  = array();
                }
            }

            if (!extension_loaded('zip')) {
                $data['update_errors'][] = 'ZIP Extension not enabled';
            }

            $data['current_version'] = $this->db->get('tblmigrations')->row()->version;
        }

        $data['contacts_permissions'] = $this->perfex_base->get_contact_permissions();
        $this->load->library('pdf');
        $data['payment_gateways'] = $this->payment_modes_model->get_online_payment_modes(true);
        $data['group']            = $this->input->get('group');
        $data['group_view']       = $this->load->view('message_settings_page', $data, true);
        $this->load->view('admin/settings/all', $data);
    }
    public function addstaff() {
        $cid = $this->input->post("cid");
        $staffs = $this->input->post("staffs");

        $this->Messaging_model->addGroupMembers($cid, $staffs);
    }

    public function loademoticons() {
        echo $this->load->view("messaging_emoticons", '', true);
    }

    public function deletegroup() {
        $cid = $this->input->post("cid");
        $this->Messaging_model->deleteGroup($cid);
    }

    public function load_more_messages() {
        $cid = $this->input->get("cid");
        $offset = $this->input->get("offset");
        $newOffset = $offset + 10;
        $results = "";
        foreach($this->Messaging_model->getMessages($cid, $newOffset) as $message) {
            $results .= $this->load->view("messaging_each_chat", array('message' => $message), true);
        }
        echo json_encode(array(
            'offset' => $newOffset,
            'result' => $results
        ));

    }

    public function load_message() {
        $title = $this->input->get('title');
        $cid = $this->input->get('cid');
        $type = $this->input->get('type');
        $userType = $this->input->get('user_type');
        $canDelete = $this->input->get('can_delete');

        echo $this->load->view("messaging_load_main_messages", array(
            'title' => $title,
            'cid' => $cid,
            'type' => $type,
            'userType' => $userType,
            'canDelete' => $canDelete
        ), true);
    }
    public function send() {
        $uid = $this->input->post('uid');
        $cid = $this->input->post("cid");
        $userType = $this->input->post("user_type");
        $message = $this->input->post("message");
        $likeIt = ($this->input->post("like")) ? 1 : 0;

        if (empty($cid)) {
            $cid = $this->Messaging_model->getConversationId($uid, $userType);
        }

        $message = $this->Messaging_model->sendMessage($cid, $message, $likeIt);
        $message =  $this->load->view("messaging_each_chat", array('message' => $message), true);
        echo  json_encode(array(
            'cid' => $cid,
            'message' => $message
        ));
    }

    public function send_new_message() {
        $message = $this->input->post("message");
        $to = $this->input->post('to');
        //$userType = (preg_match('#staff_#', $to)) ? 'staff' : 'contact';
        list($userType, $uid) = explode('_', $to);
        $cid = $this->Messaging_model->getConversationId($uid, $userType);
        $message = $this->Messaging_model->sendMessage($cid, $message, 0);
        echo json_encode(array(
            'link' => base_url('messaging/messages?cid='.$cid),
            'message' => lm('messaging_message_sent_success')
        ));
    }

    public function preload() {
        $uid = $this->input->get('uid');
        $cid = $this->input->get("cid");
        $userType = $this->input->get("user_type");
        if (empty($cid)) {
            $cid = $this->Messaging_model->getConversationId($uid, $userType, false);
        }

        if (!$cid) exit('');
        $results = "";
        foreach($this->Messaging_model->getMessages($cid) as $message) {
            $results .= $this->load->view("messaging_each_chat", array('message' => $message), true);
        }
        echo json_encode(array(
            'cid' => $cid,
            'result' => $results
        ));
    }

    function add_group() {
        $title = $this->input->post("title");
        $staffs = $this->input->post("staffs");
        if (empty($title)) exit('');
        $this->Messaging_model->addGroup($title, $staffs);

        echo $this->load->view("messaging_list_groups", array('groups' => $this->Messaging_model->getGroups()), true);
    }
    function dropdown() {
        echo $this->load->view("messaging_list_conversations", array('conversations' => $this->Messaging_model->getConversationLists()), true);
    }
    public function check() {
        $cids = $this->input->get("cids");
        $lastCheckTime = $this->input->get('last_time');
        if ($lastCheckTime == '') $lastCheckTime = time();
        $result = array(
            'staffs' => "",
            "contacts" => "",
            "groups" => "",
            'online_count' => $this->Messaging_model->getOnlineCount(),
            'unread_messages' => $this->Messaging_model->countUnreadMessages(),
            "chat_boxes" => array(),
            'lastcheck' => time()
        );

        $staffs = array();

        $cids = explode(',', $cids);

        foreach($cids as $cid) {
            $lastestMessages = $this->Messaging_model->getLatestMessages($cid, $lastCheckTime);

            if($lastestMessages) {
                $chatMessages = "";
                foreach($lastestMessages as $message) {
                    $chatMessages .= $this->load->view("messaging_each_chat", array('message' => $message), true);
                }
                $result['chat_boxes'][$cid] = $chatMessages;
            }
        }

        if (is_staff_logged_in()) {

            $staffs = $this->Messaging_model->getStaffs();
        } else {
            $staffs = $this->Messaging_model->getContactStaffs();
        }

        $result['staffs'] = $this->load->view("messaging_list_staffs", array('staffs' => $staffs), true);
        if (is_staff_logged_in()) {
            $result['groups'] = $this->load->view("messaging_list_groups", array('groups' => $this->Messaging_model->getGroups()), true);
            $result['contacts'] =  $this->load->view("messaging_list_contacts", array('contacts' => $this->Messaging_model->getContacts()), true);
        }
        $this->Messaging_model->updateActiveTime();
        echo json_encode($result);
    }
    
    public function install() {
        $basePath = messaging_get_base_path();
        $installfile = $basePath.'/install.php';
        if (!file_exists($installfile)) exit("PERMISSION DENIED");
        include($installfile);
        exit("Messaging installation done");
    }
    
    public function update() {
        $basePath = messaging_get_base_path();
        $updatefile = $basePath.'/update.php';
        if (!file_exists($updatefile)) exit("PERMISSION DENIED");
        include($updatefile);
        exit("Messaging update done!!!");
    }
}