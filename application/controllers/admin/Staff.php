<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Staff extends Admin_controller
{
    function __construct()
    {
        parent::__construct();
    }
    /* List all staff members */
    public function index()
    {
        if (!has_permission('staff', '', 'view')) {
            access_denied('staff');
        }
        if ($this->input->is_ajax_request()) {
            $this->perfex_base->get_table_data('staff');
        }
        $data['staff_members'] = $this->staff_model->get('',1);
        $data['title'] = _l('staff_members');
        $this->load->view('admin/staff/manage', $data);
    }
    public function get_bds($idStaff)
    {
        if (!has_permission('staff', '', 'view')) {
            access_denied('staff');
        }
        if ($this->input->is_ajax_request()) {
            $this->perfex_base->get_table_data('staff_projects_bds', array(
                'idStaff' => $idStaff,
            ));
        }
    }
    public function get_clients($idStaff)
    {
        if (!has_permission('staff', '', 'view')) {
            access_denied('staff');
        }
        if ($this->input->is_ajax_request()) {
            $this->perfex_base->get_table_data('staff_clients', array(
                'idStaff' => $idStaff,
            ));
        }
    }
    /* Add new staff member or edit existing */
    public function member($id = '')
    {
        if(!true_small_admin($id))
        {
            if (!has_permission('staff', '', 'view')&&!has_permission('staff', '', 'edit')&&!has_permission('staff', '', 'create')) {
                access_denied('staff');
            }
        }

        $this->load->model('departments_model');
        if ($this->input->post()) {
            $data = $this->input->post();
            $data['hourly_rate'] = str_replace('.','',$data['hourly_rate']);
            $data['email_signature'] = $this->input->post('email_signature',FALSE);

            if ($id == '') {
                if (!has_permission('staff', '', 'create')) {
                    access_denied('staff');
                }
                $id = $this->staff_model->add($data);
                if ($id) {
                    handle_staff_profile_image_upload($id);
                    set_alert('success', _l('added_successfuly', _l('staff_member')));
                    redirect(admin_url('staff'));
                }
            } else {
                if (!has_permission('staff', '', 'edit')) {
                    access_denied('staff');
                }
                handle_staff_profile_image_upload($id);
                if($_SESSION['rule']!=1)
                {
                    $_userid = get_staff_user_id();
                    if($id==$_userid)
                    {
                        $data['primary']='true';
                    }
                }
                $response = $this->staff_model->update($data, $id);

                if(is_array($response)){
                    if(isset($response['cant_remove_main_admin'])){
                        set_alert('warning', _l('staff_cant_remove_main_admin'));
                    } else if(isset($response['cant_remove_yourself_from_admin'])){
                        set_alert('warning', _l('staff_cant_remove_yourself_from_admin'));
                    }
                } elseif ($response == true) {
                   set_alert('success', _l('updated_successfuly', _l('staff_member')));
               }
               redirect(admin_url('staff/member/' . $id));
            }
        }

        if ($id == '') {
            $title = _l('add_new', _l('staff_member_lowercase'));
        } else {
            $member                    = $this->staff_model->get($id);
            if(!$member){
                blank_page('Staff Member Not Found','danger');
            }
            $data['member']            = $member;
            $data['staff_manager']=$this->load_rule_manager($member->rule,$member->role);//
            $title                     = $member->firstname . ' ' . $member->lastname;
            $data['staff_permissions'] = $this->roles_model->get_staff_permissions($id);//
            $data['staff_departments'] = $this->departments_model->get_staff_departments($member->staffid);//
            $data['staff_insurrance']=$this->staff_model->get_insurrance($id);
            $data['staff_contract']=$this->staff_model->get_contract($id);//
            $data['staff_information']=$this->staff_model->get_information($id);//
            $data['staff_comment']=$this->staff_model->get_comment($id);//

            $ts_filter_data = array();
            if($this->input->get('filter')){
                if($this->input->get('range') != 'period'){
                    $ts_filter_data[$this->input->get('range')] = true;
                } else {
                    $ts_filter_data['period-from'] = $this->input->get('period-from');
                    $ts_filter_data['period-to'] = $this->input->get('period-to');
                }
            } else {
                $ts_filter_data['this_month'] = true;
            }

            $data['logged_time'] = $this->staff_model->get_logged_time_data($id,$ts_filter_data);
            $data['timesheets'] = $data['logged_time']['timesheets'];


        }
        $this->load->model('currencies_model');
        $data['base_currency'] = $this->currencies_model->get_base_currency();

        $data['roles']       = $this->roles_model->get();
//        var_dump($data['member'] );die();
        $data['permissions'] = $this->roles_model->get_permissions();
        $data['user_notes'] = $this->misc_model->get_notes($id, 'staff');
        $data['departments'] = $this->departments_model->get();
        $data['title']       = $title;
        $this->load->view('admin/staff/member', $data);
    }

   public function get_code_staff($id,$idstaff="")
   {
      $code= $this->staff_model->get_code_staff($id,$idstaff);
       echo json_encode(array('code_staff'=>$code));
   }
    public function load_rule_manager($rule,$role)
    {
        $this->db->select('CONCAT(firstname," ",lastname) as name,staffid');
        $this->db->where('role=' . $role);
        $this->db->where('rule', ($rule - 1));
        $this->db->where('staff_manager',get_staff_user_id());
        return $this->db->get('tblstaff')->result_array();
    }


    public function change_language($lang = ''){
        $lang = do_action('before_staff_change_language',$lang);
        $this->db->where('staffid',get_staff_user_id());
        $this->db->update('tblstaff',array('default_language'=>$lang));
        if(isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])) {
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            redirect(admin_url());
        }
    }
    public function get_staff_role($idrole="",$idrule="")
    {

        if($idrule>2) {
            $this->db->where('role=' . $idrole);
            $this->db->where('rule', ($idrule - 1));
            $staff = $this->db->get('tblstaff')->result_array();
        }
        else
        {
            $this->db->where('rule', ($idrule - 1));
            $staff = $this->db->get('tblstaff')->result_array();
        }
        $option = "<option></option>";
        foreach ($staff as $rom) {
            $option = $option . "<option value='" . $rom['staffid'] . "'>" . $rom['firstname'] . " " . $rom['lastname'] . "</option>";
        }
        echo $option;
    }
    public function timesheets(){

        $data['view_all'] = false;
        if(is_admin() && $this->input->get('view') == 'all'){
            $data['staff_members_with_timesheets'] = $this->db->query('SELECT DISTINCT staff_id FROM tbltaskstimers WHERE staff_id !='.get_staff_user_id())->result_array();
            $data['view_all'] = true;
        }

        if($this->input->is_ajax_request()){
            $this->perfex_base->get_table_data('staff_timesheets',array('view_all'=>$data['view_all']));
        }

        if($data['view_all'] == false){
            unset($data['view_all']);
        }
        $data['chart_js_assets']   = true;
        $data['logged_time'] = $this->staff_model->get_logged_time_data(get_staff_user_id());
        $data['title'] = '';

        $projects = array();

        $projects_where = array();

        if(!has_permission('projects','','create')){
            $projects_where = '';
            $projects_where .= 'tblprojects.id IN (SELECT project_id FROM tblprojectmembers WHERE staff_id=' . get_staff_user_id() .')';
        }

        $data['projects'] =  $this->projects_model->get('',$projects_where);


        $this->load->view('admin/staff/timesheets',$data);

    }
    public function delete(){
        if(has_permission('staff','','delete')){
            $success = $this->staff_model->delete($this->input->post('id'),$this->input->post('transfer_data_to'));
            if($success){
                set_alert('success',_l('deleted',_l('staff_member')));
            }
        }
        redirect(admin_url('staff'));
    }
    /* When staff edit his profile */
    public function edit_profile()
    {
        if ($this->input->post()) {
            handle_staff_profile_image_upload();
            $data = $this->input->post();
            // Dont do XSS clean here.
            $data['email_signature'] = $data['email_signature'] = $this->input->post('email_signature',FALSE);

            $success = $this->staff_model->update_profile($data, get_staff_user_id());
            if ($success) {
                set_alert('success', _l('staff_profile_updated'));
            }
            redirect(admin_url('staff/edit_profile/' . get_staff_user_id()));
        }
        $member = $this->staff_model->get(get_staff_user_id());
        $this->load->model('departments_model');
        $data['member']            = $member;
        $data['departments']       = $this->departments_model->get();
        $data['staff_departments'] = $this->departments_model->get_staff_departments($member->staffid);
        $data['title']             = $member->firstname . ' ' . $member->lastname;
        $this->load->view('admin/staff/profile', $data);
    }
    /* Remove staff profile image / ajax */
    public function remove_staff_profile_image($id = '')
    {
        $staff_id = get_staff_user_id();
        if(is_numeric($id) && (has_permission('staff','','create') || has_permission('staff','','edot'))){
            $staff_id = $id;
        }
        do_action('before_remove_staff_profile_image');
        $member = $this->staff_model->get($staff_id);
        if (file_exists(get_upload_path_by_type('staff') . $staff_id)) {
            delete_dir(get_upload_path_by_type('staff') . $staff_id);
        }
        $this->db->where('staffid', $staff_id);
        $this->db->update('tblstaff', array(
            'profile_image' => NULL
        ));

        if(!is_numeric($id)){
            redirect(admin_url('staff/edit_profile/' .$staff_id));
        } else {
            redirect(admin_url('staff/member/' . $staff_id));
        }
    }
    /* When staff change his password */
    public function change_password_profile()
    {
        if ($this->input->post()) {
            $response = $this->staff_model->change_password($this->input->post(), get_staff_user_id());
            if (is_array($response) && isset($response[0]['passwordnotmatch'])) {
                set_alert('danger', _l('staff_old_password_incorect'));
            } else {
                if ($response == true) {
                    set_alert('success', _l('staff_password_changed'));
                } else {
                    set_alert('warning', _l('staff_problem_changing_password'));
                }
            }
            redirect(admin_url('staff/edit_profile'));
        }
    }
    /* View public profile. If id passed view profile by staff id else current user*/
    public function profile($id = '')
    {
        if ($id == '') {
            $id = get_staff_user_id();
        }

        do_action('staff_profile_access',$id);

        $data['logged_time'] = $this->staff_model->get_logged_time_data($id);
        $data['staff_p'] = $this->staff_model->get($id);

        if(!$data['staff_p']){
            blank_page('Staff Member Not Found','danger');
        }

        $this->load->model('departments_model');
        $data['staff_departments'] = $this->departments_model->get_staff_departments($data['staff_p']->staffid);
        $data['departments']       = $this->departments_model->get();
        $data['title']             = _l('staff_profile_string') . ' - ' . $data['staff_p']->firstname . ' ' . $data['staff_p']->lastname;
        // notifications
        $total_notifications       = total_rows('tblnotifications', array(
            'touserid' => get_staff_user_id()
        ));
        $data['total_pages']       = ceil($total_notifications / $this->misc_model->notifications_limit);
        $this->load->view('admin/staff/myprofile', $data);
    }
    /* Change status to staff active or inactive / ajax */
    public function change_staff_status($id, $status)
    {
        if (has_permission('staff', '', 'edit')) {
            if ($this->input->is_ajax_request()) {
                $this->staff_model->change_staff_status($id, $status);
            }
        }
    }
    /* Logged in staff notifications*/
    public function notifications()
    {
        $this->load->model('misc_model');
        if ($this->input->post()) {
            echo json_encode($this->misc_model->get_all_user_notifications($this->input->post('page')));
            die;
        }
    }
}
