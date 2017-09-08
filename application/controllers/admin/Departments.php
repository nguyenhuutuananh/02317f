<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Departments extends Admin_controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('departments_model');
        if (!is_admin()) {
            access_denied('Departments');
        }
    }
    /* List all departments */
    public function index()
    {
        if ($this->input->is_ajax_request()) {
            $this->perfex_base->get_table_data('departments');
        }
        $data['title'] = _l('departments');
        $this->load->view('admin/departments/manage', $data);
    }
    /* Edit or add new department */
    public function department($id = '')
    {
        if ($this->input->post()) {
            $message = '';
            if (!$this->input->post('id')) {
                $id = $this->departments_model->add($this->input->post(NULL, FALSE));
                if ($id) {
                    $success = true;
                    $message = _l('added_successfuly', _l('department'));
                }
                echo json_encode(array(
                    'success' => $success,
                    'message' => $message
                ));
            } else {
                $data = $this->input->post(NULL, FALSE);
                $id   = $data['id'];
                unset($data['id']);
                $success = $this->departments_model->update($data, $id);
                if ($success) {
                    $message = _l('updated_successfuly', _l('department'));
                }
                echo json_encode(array(
                    'success' => $success,
                    'message' => $message
                ));
            }
            die;
        }
    }
    /* Delete department from database */
    public function delete($id)
    {
        if (!$id) {
            redirect(admin_url('departments'));
        }
        $response = $this->departments_model->delete($id);
        if (is_array($response) && isset($response['referenced'])) {
            set_alert('warning', _l('is_referenced', _l('department_lowercase')));
        } else if ($response == true) {
            set_alert('success', _l('deleted', _l('department')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('department_lowercase')));
        }
        redirect(admin_url('departments'));
    }
    public function email_exists()
    {
        // First we need to check if the email is the same
        $departmentid = $this->input->post('departmentid');
        if ($departmentid) {
            $this->db->where('departmentid', $departmentid);
            $_current_email = $this->db->get('tbldepartments')->row();
            if ($_current_email->email == $this->input->post('email')) {
                echo json_encode(true);
                die();
            }
        }
        $exists = total_rows('tbldepartments', array(
            'email' => $this->input->post('email')
        ));
        if ($exists > 0) {
            echo 'false';
        } else {
            echo 'true';
        }
    }

    public function test_imap_connection()
    {
        $email         = $this->input->post('email');
        $password      = $this->input->post('password');
        $host          = $this->input->post('host');
        $imap_username = $this->input->post('username');
        if ($this->input->post('encryption')) {
            $encryption = $this->input->post('encryption');
        } else {
            $encryption = '';
        }
        require_once(APPPATH . 'third_party/php-imap/Imap.php');
        $mailbox = $host;
        if ($imap_username != '') {
            $username = $imap_username;
        } else {
            $username = $email;
        }
        $username   = $email;
        $password   = $password;
        $encryption = $encryption;
        // open connection
        $imap       = new Imap($mailbox, $username, $password, $encryption);
        if ($imap->isConnected() === true) {
            echo json_encode(array(
                'alert_type' => 'success',
                'message' => _l('lead_email_connection_ok')
            ));
        } else {
            echo json_encode(array(
                'alert_type' => 'warning',
                'message' => $imap->getError()
            ));
        }
    }
}
