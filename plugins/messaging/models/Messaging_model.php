<?php
class Messaging_Model extends CRM_Model {

    public function getStaffs($online = false) {
        $id = get_staff_user_id();
        $sql = "SELECT * FROM tblstaff WHERE active='1' AND staffid != '$id' ";
        if ($online) {
            $time = time() - 30;
            $sql .= " AND last_active_time > $time ";
        }
        $sql .= " ORDER BY last_active_time DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getContactStaffs($online = false) {
        $clientId = get_client_user_id();
        $query = $this->db->query("SELECT id FROM tblprojects WHERE clientid='$clientId'");
        $projects = array(0);
        foreach($query->result_array() as $row) {
            $projects[] = $row['id'];
        }
        $projects = implode(',', $projects);
        $staffs = array(0);
        $query = $this->db->query("SELECT staff_id FROM tblprojectmembers WHERE project_id IN ($projects)");
        foreach($query->result_array() as $row) {
            $staffs[] = $row['staff_id'];
        }

        $staffs = implode(',', $staffs);
        $sql = "SELECT * FROM tblstaff WHERE active='1' AND staffid IN ($staffs) ";

        if ($online) {
            $time = time() - 30;
            $sql .= " AND last_active_time > $time ";
        }
        $sql .= "ORDER BY last_active_time DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function findStaff($id) {
        $query = $this->db->query("SELECT * FROM tblstaff WHERE active='1' AND staffid='$id' LIMIT 1");
        return $query->row_array();
    }

    public function findContact($id) {
        $query = $this->db->query("SELECT * FROM tblcontacts WHERE active='1' AND id='$id' LIMIT 1");
        return $query->row_array();
    }
    public function getConversationId($uid, $userType, $create = true) {
        $loggedIn = (get_staff_user_id()) ? get_staff_user_id() : get_contact_user_id();
        $isContact = ($userType == 'staff') ? '0' : 1;
        $query = $this->db->query("SELECT * FROM tblconversations WHERE
        ((user1='$uid' AND user2='$loggedIn') OR (user1='$loggedIn' AND user2='$uid')) AND type='single' AND is_contact='$isContact'");

        $result = $query->row_array();
        $cid = '';
        if ($result)  {
            $cid = $result['id'];
        } else {
            if (!$create) return false;
            $cid = $this->addConversation($uid,'single', $isContact);
            if ($userType == 'staff') {
                $this->addConversationMember($cid, $uid);
            } else {
                $this->addConversationMember($cid, '', $uid);
            }

            if (get_staff_user_id()) {
                $this->addConversationMember($cid, $loggedIn);
            } else {
                $this->addConversationMember($cid, '', $loggedIn);
            }
        }


        return $cid;
    }

    public function addConversation($uid,$type,$isContact) {
        $loggedIn = (get_staff_user_id()) ? get_staff_user_id() : get_contact_user_id();
        $query = $this->db->query("INSERT INTO tblconversations (type,user1,user2,is_contact)VALUES('$type','$uid','$loggedIn','$isContact')");
        return $this->db->insert_id();
    }

    public function addGroup($title, $staffs) {
        $staffId = get_staff_user_id();
        $staffs[] = $staffId;
        $query = $this->db->query("INSERT INTO tblconversations (type,user1,user2,is_contact,title)VALUES('group','$staffId','','0','$title')");
        $insertId = $this->db->insert_id();
        foreach($staffs as $id) {
            $this->addConversationMember($insertId, $id);
        }
        return $insertId;
    }

    public function addGroupMembers($cid, $staffs) {
        foreach($staffs as $id) {
            $this->addConversationMember($cid, $id);
        }
    }

    public function deleteGroup($cid) {
        $this->db->query("DELETE FROM tblconversations WHERE id = '$cid'");
        $this->db->query("DELETE FROM tblconversations_members WHERE cid='$cid'");
        $this->db->query("DELETE FROM tblconversation_messages WHERE cid='$cid'");
    }

    public function getGroups() {

        $staffId = get_staff_user_id();
        $query = $this->db->query("SELECT cid FROM tblconversations_members WHERE member_id='$staffId'");
        $ids = array('0');
        foreach($query->result_array() as $row) {
            $ids[] = $row['cid'];
        }
        //return array();
        $ids = implode(',', $ids);
        $query = $this->db->query("SELECT * FROM tblconversations WHERE id IN ($ids) AND type='group'");
        $results = array();
        foreach($query->result_array() as $row) {
            $cid = $row['id'];
            $query = $this->db->query("SELECT cid FROM tblconversations_members WHERE cid='$cid'");
            $row['members'] = $query->num_rows();
            $results[] = $row;
        }
        return $results;
    }

    public function getContacts() {
        return $this->getStaffHandlingProjectsContacts();
    }

    public function getStaffHandlingProjectsContacts($online = false) {
        $id = get_staff_user_id();
        $query = $this->db->query("SELECT project_id FROM tblprojectmembers WHERE staff_id='$id'");
        $projects = array(0);

        foreach($query->result_array() as $row) {
            $projects[] = $row['project_id'];
        }

        return $this->getProjectContacts($projects, $online);
    }

    public function getProjectContacts($projects, $online = false) {
        $projects = implode(',', $projects);
        $query = $this->db->query("SELECT clientid FROM tblprojects WHERE id IN ($projects) ");
        $contacts = array();
        $clients = array(0);
        foreach($query->result_array() as $row){
            $clients[] = $row['clientid'];
        }
        $clients = implode(',', $clients);
        $query = $this->db->query("SELECT company,userid FROM tblclients WHERE userid IN ($clients)");
        foreach($query->result_array() as $row) {
            $clientId = $row['userid'];
            $sql  = "SELECT * FROM tblcontacts WHERE userid='$clientId' ";
            if ($online) {
                $time = time() - 30;
                $sql .= " AND last_active_time > $time ";
            }
            $sql .= " ORDER BY last_active_time DESC ";
            $q = $this->db->query($sql);
            //$contacts = array_merge($contacts, $q->result_array());
            foreach($q->result_array() as $r) {
                $r['company'] = $row['company'];
                $contacts[] = $r;
            }
        }

        return $contacts;
    }

    public function addConversationMember($cid, $staffid = '', $contactId = '') {
        $checkQuery = $this->db->query("SELECT cid FROM tblconversations_members WHERE cid='$cid' AND member_id='$staffid' AND contact_id='$contactId'");

        if ($checkQuery->num_rows() < 1) {
            $query = $this->db->query("INSERT INTO tblconversations_members (cid,member_id,contact_id) VALUES('$cid','$staffid','$contactId')");
        }
    }

    public function sendMessage($cid, $message,$likeit = 0) {
        $staffid =  get_staff_user_id();
        $contactId =  strtolower(get_contact_user_id());
        $photo = $this->processPhotoUpload();
        $file = $this->processFileUpload();
        $time = time();
        if ($photo or $file) $message = "";
        if ($photo) $file = '';

        $message = $this->db->escape($message);
        $query = $this->db->query("INSERT INTO tblconversation_messages(cid,member_id,contact_id,message,time_created,file_path,image_path,send_like)
        VALUES('$cid','$staffid','$contactId',$message,'$time','$file','$photo','$likeit')");
        $messageId = $this->db->insert_id();
        $log = "Chat Message [";
        $from = "From ";
        $from .= ($staffid) ? "(Staff): " : "(Client) :";
        if ($staffid) {
            $staff = $this->findStaff($staffid);
            $from .= $staff['firstname'];
        } else {
            $contact = $this->findContact($contactId);
            $from .= $contact['firstname'];
        }
        /**
         * $to  = " To ";
        $to .= ($staffid) ? "(Staff): " : "(Client) :";
        if ($staffid) {
        $contact = $this->findContact($contactId);
        $to .= $contact['firstname'];
        } else {
        $staff = $this->findStaff($staffid);
        $to .= $staff['firstname'];
        }
         */
        $log .= $from.' '.'- Message: ';
        if ($message) {
            $log .=  messaging_format_message($message);
        } elseif ($photo) {
            $log .= 'Photo - '."<a href='".base_url($photo)."'>View photo</a>";
        } elseif($file) {
            $log .= 'File attachment - '. "<a href='".base_url($file)."'>View file</a>";
        } else {
            $log .= "Like";
        }
        $log .= "]";

        logActivity($log);
        $message = $this->getMessage($messageId);
        $this->db->query("UPDATE tblconversations SET last_updated='$time' WHERE id='$cid'");

        return $message;
    }

    public function processPhotoUpload() {
        $photo = "";
        if (isset($_FILES['photo']['name']) && $_FILES['photo']['name'] != '') {
            do_action('before_upload_contact_profile_image');

            $path        = 'uploads/messaging/';
            // Get the temp file path
            $tmpFilePath = $_FILES['photo']['tmp_name'];
            // Make sure we have a filepath
            if (!empty($tmpFilePath) && $tmpFilePath != '') {
                // Getting file extension
                $path_parts         = pathinfo($_FILES["photo"]["name"]);
                $extension          = $path_parts['extension'];
                $extension = strtolower($extension);
                $allowed_extensions = array(
                    'jpg',
                    'jpeg',
                    'png',
                    'gif'
                );

                // Setup our new file path
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                    fopen($path . '/index.html', 'w');
                }
                $filename    = unique_filename($path, $_FILES["photo"]["name"]);
                $newFilePath = $path . $filename;
                // Upload the file into the company uploads dir
                if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                    $CI =& get_instance();
                    $config                   = array();
                    $config['image_library']  = 'gd2';
                    $config['source_image']   = $newFilePath;
                    $config['new_image']      = 'thumb_' . $filename;
                    $config['maintain_ratio'] = TRUE;
                    //$config['width']          = 500;
                    //$config['height']         = 500;
                    $CI->load->library('image_lib', $config);
                    $CI->image_lib->resize();
                    $CI->image_lib->clear();

                    $photo = "uploads/messaging/".$filename;
                }
            }
        }
        return $photo;
    }

    public function processFileUpload() {
        $file = "";
        if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != '') {
            do_action('before_upload_contact_profile_image');

            $path        = 'uploads/messaging/';
            // Get the temp file path
            $tmpFilePath = $_FILES['file']['tmp_name'];
            // Make sure we have a filepath
            if (!empty($tmpFilePath) && $tmpFilePath != '') {
                // Getting file extension
                $path_parts         = pathinfo($_FILES["file"]["name"]);
                $extension          = $path_parts['extension'];
                $extension = strtolower($extension);
                $allowed_extensions = array(
                    'jpg',
                    'jpeg',
                    'png',
                    'gif'
                );

                // Setup our new file path
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                    fopen($path . '/index.html', 'w');
                }
                $filename    = unique_filename($path, $_FILES["file"]["name"]);
                $newFilePath = $path . $filename;
                // Upload the file into the company uploads dir
                if (move_uploaded_file($tmpFilePath, $newFilePath)) {

                    $file = "uploads/messaging/".$filename;
                }
            }
        }
        return $file;
    }
    public function getMessage($id) {
        $query = $this->db->query("SELECT * FROM tblconversation_messages WHERE id='$id'");
        return $query->row_array();
    }

    public function getMessages($id, $start = 0) {
        $limit = 10;
        $query = $this->db->query("SELECT * FROM tblconversation_messages WHERE cid='$id' ORDER BY time_created DESC LIMIT  $limit OFFSET $start");
        return array_reverse($query->result_array());
    }

    public function markRead($id) {
        $staffId = get_staff_user_id();
        $contactId = get_contact_user_id();
        return  $this->db->query("INSERT INTO tblconversation_message_read (message_id,staff_id,contact_id)VALUES('$id','$staffId','$contactId')");
    }

    public function getMarkReadMessages() {
        $sql = "SELECT message_id FROM tblconversation_message_read WHERE ";
        if (is_staff_logged_in()) {
            $staffId = get_staff_user_id();
            $sql .= "staff_id='$staffId'";
        } else {
            $contactId = get_contact_user_id();
            $sql .= "contact_id='$contactId'";
        }
        $query = $this->db->query($sql);
        $ids = array(0);
        foreach($query->result_array() as $row) {
            $ids[] = $row['message_id'];
        }
        return $ids;
    }

    public function getAllConversationId() {
        $sql = "SELECT cid FROM tblconversations_members WHERE ";
        if (is_staff_logged_in()) {
            $staffId = get_staff_user_id();
            $sql .= "member_id='$staffId'";
        } else {
            $contactId = get_contact_user_id();
            $sql .= "contact_id='$contactId'";
        }
        $query = $this->db->query($sql);
        $ids = array(0);
        foreach($query->result_array() as $row) {
            $ids[] = $row['cid'];
        }
        return $ids;
    }

    public function countUnreadMessages() {
        $ids = implode(',', $this->getMarkReadMessages());
        $cids = implode(',', $this->getAllConversationId());
        $sql = "SELECT id FROM tblconversation_messages WHERE cid IN ($cids) AND id NOT IN ($ids) ";
        if (is_staff_logged_in()) {
            $staffId = get_staff_user_id();
            $sql .= " AND member_id != '$staffId' ";
        } else {
            $contactId = get_contact_user_id();
            $sql .= " AND contact_id != '$contactId' ";
        }

        $query = $this->db->query($sql);

        return $query->num_rows();
    }

    public function getLatestMessages($cid, $time) {
        $sql = "SELECT * FROM tblconversation_messages WHERE cid ='$cid' AND time_created > $time ";
        if (is_staff_logged_in()) {
            $staffId = get_staff_user_id();
            $sql .= " AND member_id != '$staffId' ";
        } else {
            $contactId = get_contact_user_id();
            $sql .= " AND contact_id != '$contactId' ";
        }
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getConversationLists($limit = 10, $offset = 0) {
        $cids = $this->getAllConversationId();
        $cids = implode(',', $cids);
        $query = $this->db->query("SELECT * FROM tblconversations WHERE id IN ($cids) ORDER BY last_updated DESC LIMIT {$limit} OFFSET {$offset}");

        $results = array();

        foreach($query->result_array() as $row) {


            $results[] = $this->getConversationDetail($row);

        }
        return $results;
    }

    public function getConversationDetail($row, $id = null) {
        if ($id) {
            $query = $this->db->query("SELECT * FROM tblconversations WHERE id='$id'");
            $row = $query->row_array();
        }

        $detail = array(
            'id' => $row['id'],
            'message' => $this->getLastMessage($row['id']),
            'title' => $row['title'],
            'avatar' => base_url('plugins/messaging/group-icon.png'),
            'type' => $row['type'],
            'is_contact' => $row['is_contact'],
            'time' => $row['last_updated']
        );


        if ($row['type'] == 'single') {
            $cid = $row['id'];
            $newQuery = $this->db->query("SELECT member_id,contact_id FROM tblconversations_members WHERE cid='$cid'");
            $userType = '';
            $userId = '';
            foreach($newQuery->result_array() as $row2){
                if (is_staff_logged_in()) {

                    if ($row2['member_id'] and $row2['member_id'] != get_staff_user_id() ) {
                        $userType = 'staff';
                        $userId = $row2['member_id'];
                    } elseif($row2['contact_id']) {
                        $userType = 'contact';
                        $userId = $row2['contact_id'];
                    }
                } else {
                    if ($row2['contact_id'] and $row2['contact_id'] != get_contact_user_id()) {
                        $userType = 'contact';
                        $userId = $row2['contact_id'];
                    } elseif($row2['member_id']) {
                        $userType = 'staff';
                        $userId = $row2['member_id'];
                    }
                }
            }
            if ($userType == 'staff') {
                $staff = $this->findStaff($userId);
                $detail['title'] = $staff['firstname'].' '.$staff['lastname'];
                $detail['avatar'] = messaging_get_staff_avatar($staff);
            } else {
                $contact = $this->findContact($userId);
                $detail['title'] = $contact['firstname'].' '.$contact['lastname'];
                $detail['avatar'] = messaging_get_contact_avatar($contact);
            }
        }
        return $detail;
    }

    public function getLastMessage($cid) {
        $query = $this->db->query("SELECT message,file_path,image_path,send_like FROM tblconversation_messages WHERE cid='$cid' ORDER BY time_created DESC LIMIT 1");
        return $query->row_array();
    }

    public function getOnlineCount() {
        $count = 0;

        if (is_staff_logged_in()) {
            $count = count($this->getStaffs(true));
            $count += count($this->getStaffHandlingProjectsContacts(true));
        } else {

            $count = count($this->getContactStaffs(true));

        }
        return $count;
    }

    public function updateActiveTime() {
        $time = time();
        if (is_staff_logged_in()) {
            $id = get_staff_user_id();
            $this->db->query("UPDATE tblstaff SET last_active_time = '$time' WHERE staffid='$id'");
        } else {
            $id = get_contact_user_id();
            $this->db->query("UPDATE tblcontacts SET last_active_time = '$time' WHERE id='$id'");
        }
    }
}