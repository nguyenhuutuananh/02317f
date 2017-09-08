<?php
defined('BASEPATH') OR exit('No direct script access allowed');

@ini_set('memory_limit', '128M');
@ini_set('max_execution_time', 240);

class Auto_update extends Admin_controller
{
    private $tmp_update_dir;
    private $tmp_dir;

    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $purchase_key   = $this->input->post('purchase_key', FALSE);
        $latest_version = $this->input->post('latest_version');

        $url = UPDATE_URL . "?purchase_key=" . $purchase_key;

        $tmp_dir = @ini_get('upload_tmp_dir');
        if (!$tmp_dir) {
            $tmp_dir = @sys_get_temp_dir();
            if (!$tmp_dir) {
                $tmp_dir = FCPATH . 'temp';
            }
        }

        $tmp_dir = rtrim($tmp_dir, '/') . '/';
        if (!is_writable($tmp_dir)) {
            header('HTTP/1.0 400');
            echo json_encode(array(
                "Temporary directory not writable - <b>$tmp_dir</b><br />Please contact your hosting provider make this directory writable. The directory needs to be writable for the update files."
            ));
            die;
        }

        $this->tmp_dir        = $tmp_dir;
        $tmp_dir              = $tmp_dir . 'v' . $latest_version . '/';
        $this->tmp_update_dir = $tmp_dir;

        if (!is_dir($tmp_dir)) {
            mkdir($tmp_dir);
            fopen($tmp_dir . 'index.html', 'w');
        }

        $zipFile = $tmp_dir . $latest_version . '.zip'; // Local Zip File Path
        do_action('before_perform_update');
        $zipResource = fopen($zipFile, "w+");

        // Get The Zip File From Server
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 300);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_FILE, $zipResource);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array(
            'base_url' => site_url(),
            'buyer_version' => $this->misc_model->get_current_db_version(),
            'user_ip' => $this->input->ip_address(),
            'server_ip' => $_SERVER['SERVER_ADDR']
        ));

        $success = curl_exec($ch);

        if (!$success) {
            $this->clean_tmp_files();
            header('HTTP/1.0 400 Bad error');
            echo json_encode(array(
                curl_error($ch)
            ));
            die;
        }
        curl_close($ch);
        $zip = new ZipArchive;
        if ($zip->open($zipFile) === TRUE) {
            if (!$zip->extractTo(FCPATH)) {
                header('HTTP/1.0 400 Bad error');
                echo json_encode(array(
                    'Failed to extract downloaded zip file'
                ));
            }
            $zip->close();

        } else {
            header('HTTP/1.0 400 Bad error');
            echo json_encode(array(
                'Failed to open downloaded zip file'
            ));
        }
        $this->clean_tmp_files();
    }
    public function database()
    {
        $db_update = $this->misc_model->upgrade_database_silent();
        if ($db_update['success'] == false) {
            header('HTTP/1.0 400 Bad error');
            echo json_encode(array(
                $db_update['message']
            ));
            die;
        }
        set_alert('success', _l('using_latest_version'));
    }
    private function clean_tmp_files()
    {
        if (is_dir($this->tmp_update_dir)) {
            if (@!delete_dir($this->tmp_update_dir)) {
                @rename($this->tmp_update_dir, $this->tmp_dir . 'delete_this_' . uniqid());
            }
        }
    }
}
