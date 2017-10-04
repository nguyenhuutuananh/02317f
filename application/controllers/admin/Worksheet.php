
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Worksheet extends Admin_Controller {
    public function index() {
        if(!true_small_admin($id))
        {
            if (!has_permission('staff', '', 'view')&&!has_permission('staff', '', 'edit')&&!has_permission('staff', '', 'create')) {
                access_denied('staff');
            }
        }

        $this->load->model('worksheet_model');

        $data['staffsWorksheet'] = $this->worksheet_model->getWorksheet(date('m'), date('Y'));
        
        $staffs = [];
        
        $data['staff_members'] = $this->staff_model->get('',1);
        
        $data['title'] = "Chấm công";
        $this->load->view('admin/worksheet/monthly', $data);
    }
    public function create($idStaff) {
        $this->load->model('worksheet_model');
        if(!true_small_admin($id))
        {
            if (!has_permission('staff', '', 'view')&&!has_permission('staff', '', 'edit')&&!has_permission('staff', '', 'create')) {
                access_denied('staff');
            }
        }
        $member                    = $this->staff_model->get($idStaff);
        if(!$member){
            blank_page('Staff Member Not Found','danger');
        }
        $data['title'] = "Tạo lịch làm việc cho nhân viên";
        
        if($this->input->post()) {
            $data_post = $this->input->post();
            $this->worksheet_model->createWorksheet($idStaff, $data_post);
        }
        
        $this->load->view('admin/worksheet/create', $data);
    }
}