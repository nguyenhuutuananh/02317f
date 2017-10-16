<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Agency extends Admin_controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('agency_model');
    }
    public function index() {
        if($this->input->is_ajax_request()) {
            $this->perfex_base->get_table_data('agency');
        }
        $data['title'] = "Môi giới";
        $this->load->view('admin/agency/manage', $data);
    }
    public function get_and_update($id='') {
        $response = new stdClass();
        $response->success = false;
        $response->message = "";
        $response->data = new stdClass();
        $data = $this->input->post(); 
        if(isset($data['id']) || $id!='') {
            if($id=='') $id=$data['id'];
            unset($data['id']);
            if($this->input->post()) {
                $result = $this->agency_model->update($id, $data);
                if($result) {
                    $response->success = true;
                    $response->message = "Cập nhật môi giới thành công";
                }
            }
            else {
                $agency = $this->agency_model->get($id);
                if($agency) {
                    $response->success = true;
                    $response->message = "Lấy thông tin thành công";
                    $response->data = $agency;
                }
                else {
                    $response->message = "Không tồn tại";
                }
            }
        }
        else {
            if($this->input->post()) {
                $data = $this->input->post();
                $result = $this->agency_model->create($data);
                if($result) {
                    $response->success = true;
                    $response->message = "Tạo môi giới thành công";
                }
            }
        }

        exit(json_encode($response));
    }
    public function delete($id) {
        $response = new stdClass();
        $response->success = false;
        $response->message = "Xóa môi giới thất bại";
        $result = $this->agency_model->delete($id);
        if($result) {
            $response->success = true;
            $response->message = "Xóa môi giới thành công";
        }
        exit(json_encode($response));
    }
}