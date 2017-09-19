<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Master extends Admin_controller
{
    function __construct()
    {
        parent::__construct();
        // $this->load->model('contracts_model');
    }
    /* List all contracts */
    public function index()
    {
         // $this->perfex_base->get_table_data('master', array('master' => true));die();
        if ($this->input->is_ajax_request()) {
            $this->perfex_base->get_table_data('master', array('master' => true));
        }
        $data['title']="Chủ sở hữu";
        $this->load->view('admin/master/manage', $data);
    }
    public function init_profile()
    {
         if ($this->input->is_ajax_request()) {
            $this->perfex_base->get_table_data('master', array('master' => true,'type'=>3));
        }
    }
     public function init_company()
    {
         if ($this->input->is_ajax_request()) {
            $this->perfex_base->get_table_data('master', array('master' => true,'type'=>2));
        }
    }
       public function init_profile_company($id_project='',$type="")
       {
            if ($this->input->is_ajax_request()) {
                $this->perfex_base->get_table_data('master', array('project_id' => $id_project, 'type_master' => $type));
            }
       }
}
