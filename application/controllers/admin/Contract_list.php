<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contract_list extends Admin_controller {
    function __construct()
    {
        parent::__construct();
        $this->load->model('contract_list_model');
    }

    public function index() {
        if($this->input->is_ajax_request()) {
            $this->perfex_base->get_table_data('contract_list');
        }
        $data['title'] = "Kho hợp đồng";
        $this->load->view('admin/contract_list/manage', $data);
    }
}