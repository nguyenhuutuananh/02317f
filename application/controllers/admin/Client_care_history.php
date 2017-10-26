<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Client_care_history extends Admin_controller
{
    function __construct() {
        parent::__construct();
        $this->load->model('client_care_history_model');
    }
    public function index() {
        if($this->input->is_ajax_request()) {
            $this->perfex_base->get_table_data('client_care_history');
        }
        // $clients = $this->client_care_history_model->get_data_clients(53);

        $data['title'] = 'Lịch sử chăm sóc khách hàng';
        $this->load->view('admin/client_care_history/manage', $data);
    }
}