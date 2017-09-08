<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Field extends Admin_controller

{

    private $not_importable_clients_fields = array('userid', 'id', 'is_primary', 'password', 'datecreated', 'last_ip', 'last_login', 'last_password_change', 'active', 'new_pass_key', 'new_pass_key_requested', 'leadid', 'default_currency', 'profile_image', 'default_language', 'direction','show_primary_contact');

    public $pdf_zip;

    function __construct()

    {

        parent::__construct();



        $this->load->helper('form');

        $this->load->helper('url');

        $this->load->library('form_validation');

        $this->load->library('encrypt');

        $this->load->model('field_model');

        

    }
    public function index()
    {

        if ($this->input->is_ajax_request())
        {
            $this->perfex_base->get_table_data('field');
        }
        $data['title']='Field tùy chỉnh';
        $this->load->view('admin/field_bds/managa',$data);

    }
    public function field($id="")
    {
        if($this->input->post())
        {
            $data=$this->input->post();
            if($data['required']=='on')
            {
                $data['required']=1;
            }
            if($id=="")
            {
                $success=$this->field_model->add($data);
                if($success)
                {
                    echo json_encode(array('success' => true,'message' => 'thêm trường thành công'));
                }
                else
                {
                    echo json_encode(array('success' => false,'message' => 'thêm trường bị lỗi'));
                }
            }
            else
            {
                $success=$this->field_model->update($id,$data);
                if($success)
                {
                    echo json_encode(array('success' => true,'message' => 'cập nhật trường thành công'));
                }
                else
                {
                    echo json_encode(array('success' => false,'message' => 'cập trường bị lỗi'));
                }
            }

        }
    }
    public function get_data_field($id)
    {
        $this->db->where('id',$id);
        $field=$this->db->get('tbfield_bds')->row();
        echo json_encode($field);
    }
}

