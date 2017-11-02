<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Handles uploads error with translation texts
 * @param  mixed $error type of error
 * @return mixed
 */
function _perfex_upload_error($error){
    $phpFileUploadErrors = array(
        0 => _l('file_uploaded_success'),
        1 => _l('file_exceds_max_filesize'),
        2 => _l('file_exceds_maxfile_size_in_form'),
        3 => _l('file_uploaded_partially'),
        4 => _l('file_not_uploaded'),
        6 => _l('file_missing_temporary_folder'),
        7 => _l('file_failed_to_write_to_disk'),
        8 => _l('file_php_extension_blocked'),
    );

    if(isset($phpFileUploadErrors[$error]) && $error != 0){
        return $phpFileUploadErrors[$error];
    }
    return false;
}
/**
 * Newsfeed post attachments
 * @param  mixed $postid Post ID to add attachments
 * @return array  - Result values
 */
function handle_newsfeed_post_attachments($postid)
{
    if(isset($_FILES['file']) && _perfex_upload_error($_FILES['file']['error'])){
        header('HTTP/1.0 400 Bad error');
        echo _perfex_upload_error($_FILES['file']['error']);
        die;
    }
    $path = get_upload_path_by_type('newsfeed') . $postid . '/';
    $CI =& get_instance();
    if (isset($_FILES['file']['name'])) {
        do_action('before_upload_newsfeed_attachment',$postid);
        $uploaded_files = false;
        // Get the temp file path
        $tmpFilePath    = $_FILES['file']['tmp_name'];
        // Make sure we have a filepath
        if (!empty($tmpFilePath) && $tmpFilePath != '') {

            // Setup our new file path
            if (!file_exists($path)) {
                mkdir($path);
                fopen($path . 'index.html', 'w');
            }
            $filename    = unique_filename($path, $_FILES["file"]["name"]);
            $newFilePath = $path . $filename;
            // Upload the file into the temp dir
            if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                $file_uploaded = true;
                $attachment = array();
                $attachment[] = array(
                    'file_name' => $filename,
                    'filetype' => $_FILES["file"]["type"],
                    );
                $CI->misc_model->add_attachment_to_database($postid,'newsfeed_post',$attachment);
            }
        }
        if ($file_uploaded == true) {
            echo json_encode(array(
                'success' => true,
                'postid' => $postid
            ));
        } else {
            echo json_encode(array(
                'success' => false,
                'postid' => $postid
            ));
        }
    }
}
/**
 * Handles upload for project files
 * @param  mixed $project_id project id
 * @return boolean
 */
function handle_project_file_uploads($project_id)
{

    if(isset($_FILES['file']) && _perfex_upload_error($_FILES['file']['error'])){
        header('HTTP/1.0 400 Bad error');
        echo _perfex_upload_error($_FILES['file']['error']);
        die;
    }
    if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != '') {
        do_action('before_upload_project_attachment',$project_id);
        $path        = get_upload_path_by_type('project') . $project_id . '/';
        // Get the temp file path
        $tmpFilePath = $_FILES['file']['tmp_name'];
        // Make sure we have a filepath
        if (!empty($tmpFilePath) && $tmpFilePath != '') {
            // Setup our new file path

            if (!file_exists($path)) {
                mkdir($path);
                fopen($path . 'index.html', 'w');
            }
             $filename    = unique_filename($path, $_FILES["file"]["name"]);
             $newFilePath = $path . $filename;
            // Upload the file into the company uploads dir
            if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                $CI =& get_instance();
                if (is_client_logged_in()) {
                    $contact_id = get_contact_user_id();
                    $staffid = 0;
                } else {
                    $staffid = get_staff_user_id();
                    $contact_id = 0;
                }
                $data = array(
                    'project_id' => $project_id,
                    'file_name' => $filename,
                    'filetype' => $_FILES["file"]["type"],
                    'dateadded' => date('Y-m-d H:i:s'),
                    'staffid' => $staffid,
                    'contact_id' => $contact_id,
                    'subject' => $filename,
                );
                if(is_client_logged_in()){
                    $data['visible_to_customer'] = 1;
                } else {
                    $data['visible_to_customer'] = ($CI->input->post('visible_to_customer') == 'true' ? 1 : 0);
                }
                $CI->db->insert('tblprojectfiles', $data);

                $insert_id = $CI->db->insert_id();
                    if($insert_id){
                      $CI->load->model('projects_model');
                      $CI->projects_model->new_project_file_notification($insert_id,$project_id);
                    } else {
                        unlink($newFilePath);
                        return false;
                    }
                return true;
            }
        }
    }
    return false;
}
/**
 * Handle contract attachments if any
 * @param  mixed $contractid
 * @return boolean
 */
function handle_contract_attachment($id)
{

     if(isset($_FILES['file']) && _perfex_upload_error($_FILES['file']['error'])){
        header('HTTP/1.0 400 Bad error');
        echo _perfex_upload_error($_FILES['file']['error']);
        die;
    }
    if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != '') {
        do_action('before_upload_contract_attachment',$id);
        $path        = get_upload_path_by_type('contract') . $id . '/';
        // Get the temp file path
        $tmpFilePath = $_FILES['file']['tmp_name'];
        // Make sure we have a filepath
        if (!empty($tmpFilePath) && $tmpFilePath != '') {
            // Setup our new file path


            if (!file_exists($path)) {
                mkdir($path);
                fopen($path . 'index.html', 'w');
            }
            $filename    = unique_filename($path, $_FILES["file"]["name"]);
            $newFilePath = $path . $filename;
            // Upload the file into the company uploads dir
            if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                $CI =& get_instance();
                $attachment = array();
                $attachment[] = array(
                    'file_name'=>$filename,
                    'filetype'=>$_FILES["file"]["type"],
                    );
                $CI->misc_model->add_attachment_to_database($id,'contract',$attachment);
                return true;
            }
        }
    }
    return false;
}
/**
 * Handle lead attachments if any
 * @param  mixed $leadid
 * @return boolean
 */
function handle_lead_attachments($leadid,$index_name = 'file', $form_activity = false)
{

   if(isset($_FILES[$index_name]) && empty($_FILES[$index_name]['name']) && $form_activity){return;}

    if(isset($_FILES[$index_name]) && _perfex_upload_error($_FILES[$index_name]['error'])){
        header('HTTP/1.0 400 Bad error');
        echo _perfex_upload_error($_FILES[$index_name]['error']);
        die;
    }

    $CI =& get_instance();
    if (isset($_FILES[$index_name]['name']) && $_FILES[$index_name]['name'] != '') {
        do_action('before_upload_lead_attachment',$leadid);
        $path        = get_upload_path_by_type('lead') . $leadid . '/';
        // Get the temp file path
        $tmpFilePath = $_FILES[$index_name]['tmp_name'];
        // Make sure we have a filepath
        if (!empty($tmpFilePath) && $tmpFilePath != '') {
            // Setup our new file path
            if (!file_exists($path)) {
                mkdir($path);
                fopen($path . 'index.html', 'w');
            }

            $path_parts         = pathinfo($_FILES[$index_name]["name"]);
            $extension          = $path_parts['extension'];
            $extension = strtolower($extension);
            $allowed_extensions = explode(',', get_option('allowed_files'));
                // Check for all cases if this extension is allowed
            if (!in_array('.'.$extension, $allowed_extensions)) {
                return false;
            }

            $filename    = unique_filename($path, $_FILES[$index_name]["name"]);
            $newFilePath = $path . $filename;
            // Upload the file into the company uploads dir
            if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                $CI =& get_instance();
                $CI->load->model('leads_model');
                $data = array();
                $data[] = array(
                    'file_name' => $filename,
                    'filetype' => $_FILES[$index_name]["type"],
                    );
                $CI->leads_model->add_attachment_to_database($leadid,$data,false,$form_activity);
                return true;
            }
        }
    }
    return false;
}
/**
 * Check for task attachment
 * @since Version 1.0.1
 * @param  mixed $taskid
 * @return mixed           false if no attachment || array uploaded attachments
 */
function handle_tasks_attachments($taskid,$index_name = 'file',$form_activity = false)
{

   if(isset($_FILES[$index_name]) && empty($_FILES[$index_name]['name']) && $form_activity){return;}

     if(isset($_FILES[$index_name]) && _perfex_upload_error($_FILES[$index_name]['error'])){
        header('HTTP/1.0 400 Bad error');
        echo _perfex_upload_error($_FILES[$index_name]['error']);
        die;
    }

    $path           = get_upload_path_by_type('task') . $taskid . '/';
    $uploaded_files = array();
    if (isset($_FILES[$index_name]['name']) && $_FILES[$index_name]['name'] != '') {
        do_action('before_upload_task_attachment',$taskid);
        // Get the temp file path
        $tmpFilePath = $_FILES[$index_name]['tmp_name'];
        // Make sure we have a filepath
        if (!empty($tmpFilePath) && $tmpFilePath != '') {
            // Setup our new file path
            if (!file_exists($path)) {
                mkdir($path);
                fopen($path . 'index.html', 'w');
            }
              $filename    = unique_filename($path, $_FILES[$index_name]["name"]);
               $newFilePath = $path . $filename;
            // Upload the file into the temp dir
            if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                array_push($uploaded_files, array(
                    'file_name' => $filename,
                    'filetype' => $_FILES[$index_name]["type"]
                ));
            }
        }
    }
    if (count($uploaded_files) > 0) {
        return $uploaded_files;
    }
    return false;
}
/**
 * Invoice attachments
 * @since  Version 1.0.4
 * @param  mixed $invoiceid invoice ID to add attachments
 * @return array  - Result values
 */
function handle_sales_attachments($rel_id,$rel_type)
{
    if(isset($_FILES['file']) && _perfex_upload_error($_FILES['file']['error'])){
        header('HTTP/1.0 400 Bad error');
        echo _perfex_upload_error($_FILES['file']['error']);
        die;
    }

    $path = get_upload_path_by_type($rel_type) . $rel_id . '/';

    $CI =& get_instance();
    if (isset($_FILES['file']['name'])) {
        $uploaded_files = false;
        // Get the temp file path
        $tmpFilePath    = $_FILES['file']['tmp_name'];
        // Make sure we have a filepath
        if (!empty($tmpFilePath) && $tmpFilePath != '') {
            // Getting file extension
            $type        = $_FILES["file"]["type"];
            // Setup our new file path
            if (!file_exists($path)) {
                mkdir($path);
                fopen($path . 'index.html', 'w');
            }
            $filename    = unique_filename($path, $_FILES["file"]["name"]);
            $newFilePath = $path . $filename;
            // Upload the file into the temp dir
            if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                $file_uploaded = true;
                $attachment = array();
                $attachment[] = array(
                    'file_name' => $filename,
                    'filetype' => $type,
                    );
                $insert_id = $CI->misc_model->add_attachment_to_database($rel_id,$rel_type,$attachment);
                // Get the key so we can return to ajax request and show download link
                $CI->db->where('id',$insert_id);
                $_attachment = $CI->db->get('tblfiles')->row();
                $key = $_attachment->attachment_key;

                if($rel_type == 'invoice'){
                    $CI->load->model('invoices_model');
                    $CI->invoices_model->log_invoice_activity($rel_id, 'invoice_activity_added_attachment');
                } else if($rel_type == 'estimate'){
                    $CI->load->model('estimates_model');
                    $CI->estimates_model->log_estimate_activity($rel_id, 'estimate_activity_added_attachment');
                }
            }
        }
        if ($file_uploaded == true) {
            echo json_encode(array(
                'success' => true,
                'attachment_id' => $insert_id,
                'filetype' => $type,
                'rel_id'=>$rel_id,
                'file_name' => $filename,
                'key' => $key,
            ));
        } else {
            echo json_encode(array(
                'success' => false,
                'rel_id' => $rel_id,
                'file_name' => $filename
            ));
        }
    }
}
/**
 * Client attachments
 * @since  Version 1.0.4
 * @param  mixed $clientid Client ID to add attachments
 * @return array  - Result values
 */
function handle_client_attachments_upload($id,$customer_upload = false)
{
    $path = get_upload_path_by_type('customer') . $id . '/';
    $CI =& get_instance();
    if (isset($_FILES['file']['name'])) {
        do_action('before_upload_client_attachment',$id);
        // Get the temp file path
        $tmpFilePath = $_FILES['file']['tmp_name'];
        // Make sure we have a filepath
        if (!empty($tmpFilePath) && $tmpFilePath != '') {
            // Setup our new file path
            if (!file_exists($path)) {
                mkdir($path);
                fopen($path . 'index.html', 'w');
            }
            $filename    = unique_filename($path, $_FILES['file']['name']);
            $newFilePath = $path . $filename;
            // Upload the file into the temp dir
            if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                $attachment = array();
                $attachment[]= array(
                    'file_name'=>$filename,
                    'filetype'=>$_FILES["file"]["type"],
                    );

                if($customer_upload == TRUE){
                    $attachment[0]['staffid'] = 0;
                    $attachment[0]['contact_id'] = get_contact_user_id();
                    $attachment['visible_to_customer'] = 1;
                }

                $CI->misc_model->add_attachment_to_database($id,'customer',$attachment);
            }
        }
    }
}
/**
 * Handles upload for expenses receipt
 * @param  mixed $id expense id
 * @return void
 */
function handle_expense_attachments($id)
{
    if(isset($_FILES['file']) && _perfex_upload_error($_FILES['file']['error'])){
        header('HTTP/1.0 400 Bad error');
        echo _perfex_upload_error($_FILES['file']['error']);
        die;
    }
    $path = get_upload_path_by_type('expense') . $id . '/';
    $CI =& get_instance();

    if (isset($_FILES['file']['name'])) {
        do_action('before_upload_expense_attachment',$id);
        // Get the temp file path
        $tmpFilePath = $_FILES['file']['tmp_name'];
        // Make sure we have a filepath
        if (!empty($tmpFilePath) && $tmpFilePath != '') {
            // Setup our new file path
            if (!file_exists($path)) {
                mkdir($path);
                fopen($path . 'index.html', 'w');
            }
             $filename    = $_FILES["file"]["name"];
             $newFilePath = $path . $filename;
            // Upload the file into the temp dir
            if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                $attachment = array();
                $attachment[]= array(
                    'file_name'=>$filename,
                    'filetype'=>$_FILES["file"]["type"],
                    );

                $CI->misc_model->add_attachment_to_database($id,'expense',$attachment);
            }
        }
    }
}
/**
 * Check for ticket attachment after inserting ticket to database
 * @param  mixed $ticketid
 * @return mixed           false if no attachment || array uploaded attachments
 */
function handle_ticket_attachments($ticketid)
{

    $path           = get_upload_path_by_type('ticket') . $ticketid . '/';
    $uploaded_files = array();
    for ($i = 0; $i < count($_FILES['attachments']['name']); $i++) {
        do_action('before_upload_ticket_attachment',$ticketid);
        if ($i <= get_option('maximum_allowed_ticket_attachments')) {
            // Get the temp file path
            $tmpFilePath = $_FILES['attachments']['tmp_name'][$i];
            // Make sure we have a filepath
            if (!empty($tmpFilePath) && $tmpFilePath != '') {
                // Getting file extension
                $path_parts         = pathinfo($_FILES["attachments"]["name"][$i]);
                $extension          = $path_parts['extension'];
                $extension = strtolower($extension);
                $allowed_extensions = explode(',', get_option('ticket_attachments_file_extensions'));
                // Check for all cases if this extension is allowed
                if (!in_array('.'.$extension, $allowed_extensions)) {
                    continue;
                }
                // Setup our new file path
                if (!file_exists($path)) {
                    mkdir($path);
                    fopen($path . 'index.html', 'w');
                }
                 $filename    = unique_filename($path, $_FILES["attachments"]["name"][$i]);
                 $newFilePath = $path . $filename;
                // Upload the file into the temp dir
                if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                    array_push($uploaded_files, array(
                        'file_name' => $filename,
                        'filetype' => $_FILES["attachments"]["type"][$i]
                    ));
                }
            }
        }
    }
    if (count($uploaded_files) > 0) {
        return $uploaded_files;
    }
    return false;
}
/**
 * Check for company logo upload
 * @return boolean
 */
function handle_company_logo_upload()
{

   if(isset($_FILES['company_logo']) && _perfex_upload_error($_FILES['company_logo']['error'])){
        set_alert('warning',_perfex_upload_error($_FILES['company_logo']['error']));
        return false;
    }
    if (isset($_FILES['company_logo']['name']) && $_FILES['company_logo']['name'] != '') {
        do_action('before_upload_company_logo_attachment');
        $path        = get_upload_path_by_type('company');
        // Get the temp file path
        $tmpFilePath = $_FILES['company_logo']['tmp_name'];
        // Make sure we have a filepath
        if (!empty($tmpFilePath) && $tmpFilePath != '') {
            // Getting file extension
            $path_parts         = pathinfo($_FILES["company_logo"]["name"]);
            $extension          = $path_parts['extension'];
            $extension = strtolower($extension);
            $allowed_extensions = array(
                'jpg',
                'jpeg',
                'png',
                'gif'
            );
            if (!in_array($extension, $allowed_extensions)) {
                set_alert('warning', 'Image extension not allowed.');
                return false;
            }
            // Setup our new file path
            $filename    = 'logo' . '.' . $extension;
            $newFilePath = $path . $filename;
            if (!file_exists($path)) {
                mkdir($path);
                fopen($path . 'index.html', 'w');
            }
            // Upload the file into the company uploads dir
            if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                update_option('company_logo', $filename);
                return true;
            }
        }
    }
    return false;
}
/**
 * Handle company favicon upload
 * @return boolean
 */
function handle_favicon_upload()
{

    if (isset($_FILES['favicon']['name']) && $_FILES['favicon']['name'] != '') {
        do_action('before_upload_favicon_attachment');
        $path        = get_upload_path_by_type('company');
        // Get the temp file path
        $tmpFilePath = $_FILES['favicon']['tmp_name'];
        // Make sure we have a filepath
        if (!empty($tmpFilePath) && $tmpFilePath != '') {
            // Getting file extension
            $path_parts  = pathinfo($_FILES["favicon"]["name"]);
            $extension   = $path_parts['extension'];
            $extension = strtolower($extension);
            // Setup our new file path
            $filename    = 'favicon' . '.' . $extension;
            $newFilePath = $path . $filename;
            if (!file_exists($path)) {
                mkdir($path);
                fopen($path . 'index.html', 'w');
            }
            // Upload the file into the company uploads dir
            if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                update_option('favicon', $filename);
                return true;
            }
        }
    }
    return false;
}
/**
 * Check for staff profile image
 * @return boolean
 */
function handle_staff_profile_image_upload($staff_id = '')
{
    if(!is_numeric($staff_id)){
        $staff_id = get_staff_user_id();
    }
    if (isset($_FILES['profile_image']['name']) && $_FILES['profile_image']['name'] != '') {
        do_action('before_upload_staff_profile_image');
        $path        = get_upload_path_by_type('staff') . $staff_id . '/';
        // Get the temp file path
        $tmpFilePath = $_FILES['profile_image']['tmp_name'];
        // Make sure we have a filepath
        if (!empty($tmpFilePath) && $tmpFilePath != '') {
            // Getting file extension
            $path_parts         = pathinfo($_FILES["profile_image"]["name"]);
            $extension          = $path_parts['extension'];
            $extension = strtolower($extension);
            $allowed_extensions = array(
                'jpg',
                'jpeg',
                'png'
            );
            if (!in_array($extension, $allowed_extensions)) {
                set_alert('warning', _l('file_php_extension_blocked'));
                return false;
            }
            // Setup our new file path
            if (!file_exists($path)) {
                mkdir($path);
                fopen($path . '/index.html', 'w');
            }
            $filename    = unique_filename($path, $_FILES["profile_image"]["name"]);
             $newFilePath = $path . '/' . $filename;
            // Upload the file into the company uploads dir
            if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                $CI =& get_instance();
                $config                   = array();
                $config['image_library']  = 'gd2';
                $config['source_image']   = $newFilePath;
                $config['new_image']      = 'thumb_' . $filename;
                $config['maintain_ratio'] = TRUE;
                $config['width']          = 160;
                $config['height']         = 160;
                $CI->load->library('image_lib', $config);
                $CI->image_lib->resize();
                $CI->image_lib->clear();
                $config['image_library']  = 'gd2';
                $config['source_image']   = $newFilePath;
                $config['new_image']      = 'small_' . $filename;
                $config['maintain_ratio'] = TRUE;
                $config['width']          = 32;
                $config['height']         = 32;
                $CI->image_lib->initialize($config);
                $CI->image_lib->resize();
                $CI->db->where('staffid', $staff_id);
                $CI->db->update('tblstaff', array(
                    'profile_image' => $filename
                ));
                // Remove original image
                unlink($newFilePath);
                return true;
            }
        }
    }
    return false;
}

/**
 * Check for staff profile image
 * @return boolean
 */
function handle_contact_profile_image_upload($contact_id = '')
{
    if (isset($_FILES['profile_image']['name']) && $_FILES['profile_image']['name'] != '') {
        do_action('before_upload_contact_profile_image');
        if($contact_id == ''){
            $contact_id = get_contact_user_id();
        }
        $path        = get_upload_path_by_type('contact_profile_images') . $contact_id . '/';
        // Get the temp file path
        $tmpFilePath = $_FILES['profile_image']['tmp_name'];
        // Make sure we have a filepath
        if (!empty($tmpFilePath) && $tmpFilePath != '') {
            // Getting file extension
            $path_parts         = pathinfo($_FILES["profile_image"]["name"]);
            $extension          = $path_parts['extension'];
            $extension = strtolower($extension);
            $allowed_extensions = array(
                'jpg',
                'jpeg',
                'png'
            );
            if (!in_array($extension, $allowed_extensions)) {
                set_alert('warning', _l('file_php_extension_blocked'));
                return false;
            }
            // Setup our new file path
            if (!file_exists($path)) {
                mkdir($path);
                fopen($path . '/index.html', 'w');
            }
             $filename    = unique_filename($path, $_FILES["profile_image"]["name"]);
             $newFilePath = $path . $filename;
            // Upload the file into the company uploads dir
            if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                $CI =& get_instance();
                $config                   = array();
                $config['image_library']  = 'gd2';
                $config['source_image']   = $newFilePath;
                $config['new_image']      = 'thumb_' . $filename;
                $config['maintain_ratio'] = TRUE;
                $config['width']          = 160;
                $config['height']         = 160;
                $CI->load->library('image_lib', $config);
                $CI->image_lib->resize();
                $CI->image_lib->clear();
                $config['image_library']  = 'gd2';
                $config['source_image']   = $newFilePath;
                $config['new_image']      = 'small_' . $filename;
                $config['maintain_ratio'] = TRUE;
                $config['width']          = 32;
                $config['height']         = 32;
                $CI->image_lib->initialize($config);
                $CI->image_lib->resize();

                $CI->db->where('id', $contact_id);
                $CI->db->update('tblcontacts', array(
                    'profile_image' => $filename
                ));
                // Remove original image
                unlink($newFilePath);
                return true;
            }
        }
    }
    return false;
}
/**
 * Handle upload for project discussions comment
 * Function for jquery-comment plugin
 * @param  mixed $discussion_id discussion id
 * @param  mixed $post_data     additional post data from the comment
 * @param  array $insert_data   insert data to be parsed if needed
 * @return arrray
 */
function handle_project_discussion_comment_attachments($discussion_id,$post_data,$insert_data){

    if (isset($_FILES['file']['name'])) {
       do_action('before_upload_project_discussion_comment_attachment');
       $path = PROJECT_DISCUSSION_ATTACHMENT_FOLDER .$discussion_id . '/';
                 // Get the temp file path
       $tmpFilePath = $_FILES['file']['tmp_name'];
                 // Make sure we have a filepath
       if (!empty($tmpFilePath) && $tmpFilePath != '') {
                 // Setup our new file path
        if (!file_exists($path)) {
            mkdir($path);
            fopen($path . 'index.html', 'w');
        }
        $filename    = unique_filename($path, $_FILES['file']['name']);
        $newFilePath = $path . $filename;
                 // Upload the file into the temp dir
        if (move_uploaded_file($tmpFilePath, $newFilePath)) {
            $insert_data['file_name'] = $filename;

            if(isset($_FILES['file']['type'])){
                $insert_data['file_mime_type'] = $_FILES['file']['type'];
            } else {
                $insert_data['file_mime_type'] = get_mime_by_extension($filename);
            }
        }
    }
}

return $insert_data;
}

/**
 * Handle upload client avatar
 * @return boolean
 */
function handle_client_avatar_image_upload($item_id = '')
{
    if (isset($_FILES['avatar']['name']) && $_FILES['avatar']['name'] != '') {
        //do_action('before_upload_avatar_image');
        if($item_id == ''){
            // $item_id = get_contact_user_id();
            // echo "21312312";
            return false;
        }
        $path        = get_upload_path_by_type('contact_profile_images') . $item_id . '/';

        // Get the temp file path
        $tmpFilePath = $_FILES['avatar']['tmp_name'];
        // Make sure we have a filepath
        if (!empty($tmpFilePath) && $tmpFilePath != '') {
            // Getting file extension
            $path_parts         = pathinfo($_FILES["avatar"]["name"]);
            $extension          = $path_parts['extension'];
            $extension = strtolower($extension);
            $allowed_extensions = array(
                'jpg',
                'jpeg',
                'png'
            );
            if (!in_array($extension, $allowed_extensions)) {
                set_alert('warning', _l('file_php_extension_blocked'));
                return false;
            }
            // Setup our new file path
            if (!file_exists($path)) {
                mkdir($path);
                fopen($path . '/index.html', 'w');
            }
             $filename    = unique_filename($path, $_FILES["avatar"]["name"]);
             $newFilePath = $path . $filename;
            // Upload the file into the company uploads dir
            if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                $CI =& get_instance();
                $config                   = array();
                $config['image_library']  = 'gd2';
                $config['source_image']   = $newFilePath;
                $config['new_image']      = 'thumb_' . $filename;
                $config['maintain_ratio'] = TRUE;
                $config['width']          = 160;
                $config['height']         = 160;
                $CI->load->library('image_lib', $config);
                $CI->image_lib->resize();
                $CI->image_lib->clear();
                $config['image_library']  = 'gd2';
                $config['source_image']   = $newFilePath;
                $config['new_image']      = 'small_' . $filename;
                $config['maintain_ratio'] = TRUE;
                $config['width']          = 32;
                $config['height']         = 32;
                $CI->image_lib->initialize($config);
                $CI->image_lib->resize();

                $CI->db->where('userid', $item_id);
                $CI->db->update('tblclients', array(
                    'avatar' => substr($path, strpos($path,'uploads')) . $filename,
                ));
                // Remove original image
                return true;
            }
        }
    }
    return false;
}

/**
 * Function that return full path for upload based on passed type
 * @param  string $type
 * @return string
 */
function get_upload_path_by_type($type){
    switch($type){
        case 'lead':
            return LEAD_ATTACHMENTS_FOLDER;
        break;
        case 'project_bds':
            return PROJECT_BDS_ATTACHMENTS_FOLDER;
        break;
        case 'watermark':
            return WATRTMART_ATTACHMENTS_FOLDER;
        break;
        case 'expense':
            return EXPENSE_ATTACHMENTS_FOLDER;
        break;
        case 'project':
            return PROJECT_ATTACHMENTS_FOLDER;
        break;
        case 'proposal':
            return PROPOSAL_ATTACHMENTS_FOLDER;
        break;
        case 'estimate':
            return ESTIMATE_ATTACHMENTS_FOLDER;
        break;
        case 'invoice':
            return INVOICE_ATTACHMENTS_FOLDER;
        break;
        case 'task':
            return TASKS_ATTACHMENTS_FOLDER;
        break;
        case 'contract':
            return CONTRACTS_UPLOADS_FOLDER;
        break;
        case 'customer':
            return CLIENT_ATTACHMENTS_FOLDER;
        break;
        case 'staff':
        return STAFF_PROFILE_IMAGES_FOLDER;
        break;
        case 'company':
        return COMPANY_FILES_FOLDER;
        break;
        case 'ticket':
        return TICKET_ATTACHMENTS_FOLDER;
        break;
        case 'contact_profile_images':
        return CONTACT_PROFILE_IMAGES_FOLDER;
        break;
        case 'newsfeed':
        return NEWSFEED_FOLDER;
        break;
        case 'email':
        return EMAIL_FOLDER;
        break;
        default:
        return false;
    }
}
