
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
        if($this->input->get('selectChangeYear') && $this->input->get('selectChangeMonth')) {
            $data['yearWorksheet'] = is_numeric($this->input->get('selectChangeYear')) ? $this->input->get('selectChangeYear') : date('Y');
            $data['monthWorksheet'] = is_numeric($this->input->get('selectChangeMonth')) ? $this->input->get('selectChangeMonth') : date('m');
        }
        else {
            $data['yearWorksheet'] = date('Y');
            $data['monthWorksheet'] = date('m');
        }
        
        $data['staffsWorksheet'] = $this->worksheet_model->getWorksheet($data['monthWorksheet'], $data['yearWorksheet']);
        
        $staffs = [];
        
        $data['staff_members'] = $this->staff_model->get('',1);
        
        $data['title'] = "Chấm công";
        $this->load->view('admin/worksheet/index', $data);
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
    public function modal_create() {
        $this->load->model('worksheet_model');
        if(!true_small_admin($id))
        {
            if (!has_permission('staff', '', 'view')&&!has_permission('staff', '', 'edit')&&!has_permission('staff', '', 'create')) {
                access_denied('staff');
            }
        }
        
        if($this->input->post()) {
            $data_post = $this->input->post();

            
            $idStaffs = $data_post['userid'];

            $result = new stdClass();
            
            foreach($idStaffs as $idStaff) {
                $data_post['userid'] = $idStaff;
                $result->success = $this->worksheet_model->createWorksheet($idStaff, $data_post);
            }
            
            $result->message = "Tạo thất bại!";
            if($result->success) {
                $result->message = "Tạo thành công!";
            }
            exit(json_encode($result));
        }
        
        $data['staff_members'] = $this->staff_model->get('',1);

        $data['title'] = "Tạo lịch làm việc cho nhân viên";
        
        
        $this->load->view('admin/worksheet/modals/create', $data);
    }
    public function modal_create_dayoff() {
        $this->load->model('worksheet_model');
        if(!true_small_admin($id))
        {
            if (!has_permission('staff', '', 'view')&&!has_permission('staff', '', 'edit')&&!has_permission('staff', '', 'create')) {
                access_denied('staff');
            }
        }
        
        if($this->input->post()) {
            $data_post = $this->input->post();
            
            $idStaff = $data_post['userid'];
            $result = new stdClass();
            $result->success = $this->worksheet_model->createDayOff($idStaff, $data_post);
            $result->message = "Tạo thất bại!";
            if($result->success) {
                $result->message = "Tạo thành công!";
            }
            exit(json_encode($result));
        }
        
        $data['staff_members'] = $this->staff_model->get('',1);

        $data['title'] = "Nhân viên xin nghỉ phép";
        
        
        $this->load->view('admin/worksheet/modals/createDayOff', $data);
    }
}