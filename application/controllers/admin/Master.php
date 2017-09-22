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
    public function init_profile($id_project='', $parent='')
    {
         if ($this->input->is_ajax_request()) {
            $variables = array(
                'master' => true,
                'type'=>3,
                'manage' => true,
            );
            if($parent!='' && $id_project!='') {
                $variables['project_id'] = $id_project; 
                $variables['master'] = false;
                $variables['type_master'] = 0;
                $variables['type'] = $parent;
            }
            $this->perfex_base->get_table_data('master', $variables);
        }
    }
     public function init_company($id_project='', $parent='')
    {
         if ($this->input->is_ajax_request()) {
            $variables = array(
               'master' => true,
               'type'=>2,
            );
            if($id_project!='' && $parent != '') {
                $variables['manage'] = true;
            }
            $this->perfex_base->get_table_data('master', $variables);
        }
    }
       public function init_profile_company($id_project='',$type="")
       {
            if ($this->input->is_ajax_request()) {
                $this->perfex_base->get_table_data('master', array(
                    'project_id' => $id_project, 
                    'type_master' => $type,
                    'manage' => true,
                ));
            }
       }
}
