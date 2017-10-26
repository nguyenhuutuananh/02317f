<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Clients extends Admin_controller
{
    // init orgin table heads
    private $clientTakeCareColumns, $clientBuyColumns, $clientFailColumns;
    
    private $not_importable_clients_fields = array('userid', 'id', 'is_primary', 'password', 'datecreated', 'last_ip', 'last_login', 'last_password_change', 'active', 'new_pass_key', 'new_pass_key_requested', 'leadid', 'default_currency', 'profile_image', 'default_language', 'direction','show_primary_contact');
    public $pdf_zip;
    function __construct()
    {
        parent::__construct();
        $this->load->model('clients_model');
        $this->load->model('client_care_history_model');
        $this->clientTakeCareColumns = array(
            (object)array(
                'title_th'   => 'Ngày liên hệ',
                'id'         => 'date_contact',
                'childs' => [],
            ),
            (object)array(
                'title_th'   => 'Nguồn',
                'id'         => 'source_name',
                'childs' => [],
            ),
            (object)array(
                'title_th'   => 'Đối tác',
                'id'         => 'partner',
                'childs' => [
                    (object)array(
                        'title_th' => 'Phân loại Đối tác',
                        'id'       => 'id_partner',
                    ),
                    (object)array(
                        'title_th' => 'Họ Tên(Đối tác)',
                        'id'       => 'name_partner',
                    ),
                    (object)array(
                        'title_th' => 'Số điện thoại(Đối tác)',
                        'id'       => 'phone_partner',
                    ),
                    (object)array(
                        'title_th' => 'Email(Đối tác)',
                        'id'       => 'email_partner',
                    ),
                ],
            ),
            (object)array(
                'title_th'   => 'Khách hàng',
                'id'         => 'clients',
                'childs' => [
                    (object)array(
                        'title_th' => 'Tên khách hàng',
                        'id'       => 'company',
                    ),
                    (object)array(
                        'title_th' => 'Số điện thoại(KH)',
                        'id'       => 'phonenumber',
                    ),
                    (object)array(
                        'title_th' => 'Email(KH)',
                        'id'       => 'email',
                    ),
                    (object)array(
                        'title_th' => 'Quốc tịch',
                        'id'       => 'name_country',
                    ),
                ],
            ),
            (object)array(
                'title_th'   => 'Yêu cầu khu vực/DA',
                'id'         => 'area',
                'childs' => [
                    (object)array(
                        'title_th' => 'Loại bds',
                        'id'       => 'name_menu_bds',
                    ),
                    (object)array(
                        'title_th' => 'Quận khu vực',
                        'id'       => 'province_name',
                    ),
                    (object)array(
                        'title_th' => 'DA',
                        'id'       => 'name_bds',
                    ),
                ],
            ),
            (object)array(
                'title_th'   => 'Yêu cầu chi tiết sản phẩm',
                'id'         => 'detail',
                'childs' => [
                    (object)array(
                        'title_th' => 'PN',
                        'id'       => 'pn',
                    ),
                    (object)array(
                        'title_th' => 'DT',
                        'id'       => 'area',
                    ),
                    (object)array(
                        'title_th' => 'Ngân sách khoản',
                        'id'       => 'budget',
                    ),
                ],
            ),
            (object)array(
                'title_th'   => 'Thời gian',
                'id'         => 'time',
                'childs' => [
                    (object)array(
                        'title_th' => 'Ngày move in',
                        'id'       => 'date_movein',
                    ),
                    (object)array(
                        'title_th' => 'Thời gian thuê',
                        'id'       => 'date_tax',
                    ),
                ],
            ),
            (object)array(
                'title_th'   => 'Loại khách hàng',
                'id'         => 'class_client_name',
                'childs' => [],
            ),
            (object)array(
                'title_th'   => 'Nhu cầu',
                'id'         => 'name_exigency',
                'childs' => [],
            ),
            (object)array(
                'title_th'   => 'Mục đích',
                'id'         => 'name_purpose',
                'childs' => [],
            ),
            (object)array(
                'title_th'   => 'Yêu cầu khác',
                'id'         => 'requirements',
                'childs' => [],
            ),
            (object)array(
                'title_th'   => 'Trạng thái',
                'id'         => 'name_status',
                'childs' => [],
            ),
            (object)array(
                'title_th'   => 'NV GD',
                'id'         => 'nvgd',
                'childs' => [],
            ),
            (object)array(
                'title_th'   => 'DK SP',
                'id'         => 'dksp',
                'childs' => [],
            ),
            (object)array(
                'title_th'   => 'ĐK khách hàng',
                'id'         => 'dkkh',
                'childs' => [],
            ),
        );
        $this->clientBuyColumns = array(
            (object)array(
                'title_th'   => 'Mã HĐ',
                'id'         => 'id_contract',
                'childs' => [],
            ),
            (object)array(
                'title_th'   => 'Ngày GD',
                'id'         => 'date_deal',
                'childs' => [],
            ),
            (object)array(
                'title_th'   => 'Nguồn',
                'id'         => 'source_name',
                'childs' => [],
            ),
            (object)array(
                'title_th'   => 'Đối tác',
                'id'         => 'partner',
                'childs' => [
                    (object)array(
                        'title_th' => 'Phân loại Đối tác',
                        'id'       => 'id_partner',
                    ),
                    (object)array(
                        'title_th' => 'Họ Tên(Đối tác)',
                        'id'       => 'name_partner',
                    ),
                    (object)array(
                        'title_th' => 'Số điện thoại(Đối tác)',
                        'id'       => 'phone_partner',
                    ),
                    (object)array(
                        'title_th' => 'Email(Đối tác)',
                        'id'       => 'email_partner',
                    ),
                ],
            ),
            (object)array(
                'title_th'   => 'Loại khách hàng',
                'id'         => 'class_client_name',
                'childs' => [],
            ),

            (object)array(
                'title_th'   => 'Nhu cầu',
                'id'         => 'name_exigency',
                'childs' => [],
            ),

            (object)array(
                'title_th'   => 'Thông tin SP',
                'id'         => 'area',
                'childs' => [
                    (object)array(
                        'title_th' => 'Loại bds',
                        'id'       => 'name_menu_bds',
                    ),
                    (object)array(
                        'title_th' => 'Quận khu vực',
                        'id'       => 'province_name',
                    ),
                    (object)array(
                        'title_th' => 'DA',
                        'id'       => 'name_bds',
                    ),
                    (object)array(
                        'title_th' => 'ĐC',
                        'id'       => 'address',
                    ),
                ],
            ),
            (object)array(
                'title_th'   => 'Đối tác',
                'id'         => 'partner',
                'childs' => [
                    (object)array(
                        'title_th' => 'Phân loại Đối tác',
                        'id'       => 'id_partner',
                    ),
                    (object)array(
                        'title_th' => 'Họ Tên(Đối tác)',
                        'id'       => 'name_partner',
                    ),
                    (object)array(
                        'title_th' => 'Số điện thoại(Đối tác)',
                        'id'       => 'phone_partner',
                    ),
                    (object)array(
                        'title_th' => 'Email(Đối tác)',
                        'id'       => 'email_partner',
                    ),
                ],
            ),
            
            (object)array(
                'title_th'   => 'Khách hàng',
                'id'         => 'clients',
                'childs' => [
                    (object)array(
                        'title_th' => 'Tên khách hàng',
                        'id'       => 'company',
                    ),
                    (object)array(
                        'title_th' => 'Số điện thoại(KH)',
                        'id'       => 'phonenumber',
                    ),
                    (object)array(
                        'title_th' => 'Email(KH)',
                        'id'       => 'email',
                    ),
                    (object)array(
                        'title_th' => 'Quốc tịch',
                        'id'       => 'name_country',
                    ),
                ],
            ),
            // Chủ nhà
            (object)array(
                'title_th'   => 'Chủ nhà',
                'id'         => 'owner',
                'childs' => [
                    (object)array(
                        'title_th' => 'Tên chủ nhà',
                        'id'       => 'master_name',
                    ),
                    (object)array(
                        'title_th' => 'Số điện thoại',
                        'id'       => 'master_phonenumber',
                    ),
                    (object)array(
                        'title_th' => 'Email',
                        'id'       => 'master_email',
                    ),
                ],
            ),
            (object)array(
                'title_th'   => 'Trạng thái',
                'id'         => 'status',
                'childs' => [],
            ),

            // Hoa hồng
            (object)array(
                'title_th'   => 'Hoa hồng',
                'id'         => 'commission',
                'childs' => [
                    (object)array(
                        'title_th' => 'Trạng thái hoa hồng',
                        'id'       => 'status_bonus',
                    ),
                ],
            ),
            
            (object)array(
                'title_th'   => 'Thời gian',
                'id'         => 'time',
                'childs' => [
                    (object)array(
                        'title_th' => 'Ngày move in',
                        'id'       => 'date_movein',
                    ),
                    (object)array(
                        'title_th' => 'Thời gian thuê',
                        'id'       => 'date_tax',
                    ),
                ],
            ),

            (object)array(
                'title_th'   => 'Ngày HHĐ',
                'id'         => 'expire_contract',
                'childs' => [],
            ),

            (object)array(
                'title_th'   => 'Hoa hồng gia hạn',
                'id'         => 'bonus_period',
                'childs' => [],
            ),
            (object)array(
                'title_th'   => 'Note',
                'id'         => 'note',
                'childs' => [],
            ),

            (object)array(
                'title_th'   => 'NV GD',
                'id'         => 'nvgd',
                'childs' => [],
            ),
            (object)array(
                'title_th'   => 'DK SP',
                'id'         => 'dksp',
                'childs' => [],
            ),
            (object)array(
                'title_th'   => 'ĐK Khách khàng',
                'id'         => 'dkkh',
                'childs' => [],
            ),

        );
        $this->clientFailColumns = array(
            (object)array(
                'title_th'   => 'Ngày liên hệ',
                'id'         => 'date_contact',
                'childs' => [],
            ),
            (object)array(
                'title_th'   => 'Nguồn',
                'id'         => 'source_name',
                'childs' => [],
            ),
            (object)array(
                'title_th'   => 'Đối tác',
                'id'         => 'partner',
                'childs' => [
                    (object)array(
                        'title_th' => 'Phân loại Đối tác',
                        'id'       => 'id_partner',
                    ),
                    (object)array(
                        'title_th' => 'Họ Tên(Đối tác)',
                        'id'       => 'name_partner',
                    ),
                    (object)array(
                        'title_th' => 'Số điện thoại(Đối tác)',
                        'id'       => 'phone_partner',
                    ),
                    (object)array(
                        'title_th' => 'Email(Đối tác)',
                        'id'       => 'email_partner',
                    ),
                ],
            ),
            (object)array(
                'title_th'   => 'Khách hàng',
                'id'         => 'clients',
                'childs' => [
                    (object)array(
                        'title_th' => 'Tên khách hàng',
                        'id'       => 'company',
                    ),
                    (object)array(
                        'title_th' => 'Số điện thoại(KH)',
                        'id'       => 'phonenumber',
                    ),
                    (object)array(
                        'title_th' => 'Email(KH)',
                        'id'       => 'email',
                    ),
                    (object)array(
                        'title_th' => 'Quốc tịch',
                        'id'       => 'name_country',
                    ),
                ],
            ),
            (object)array(
                'title_th'   => 'Loại khách hàng',
                'id'         => 'class_client_name',
                'childs' => [],
            ),
            (object)array(
                'title_th'   => 'Nhu cầu',
                'id'         => 'name_exigency',
                'childs' => [],
            ),
            (object)array(
                'title_th'   => 'Mục đích',
                'id'         => 'name_purpose',
                'childs' => [],
            ),
            (object)array(
                'title_th'   => 'Yêu cầu khu vực/DA',
                'id'         => 'area',
                'childs' => [
                    (object)array(
                        'title_th' => 'Loại bds',
                        'id'       => 'name_menu_bds',
                    ),
                    (object)array(
                        'title_th' => 'Quận khu vực',
                        'id'       => 'province_name',
                    ),
                    (object)array(
                        'title_th' => 'DA',
                        'id'       => 'name_bds',
                    ),
                ],
            ),
            (object)array(
                'title_th'   => 'Yêu cầu chi tiết sản phẩm',
                'id'         => 'detail',
                'childs' => [
                    (object)array(
                        'title_th' => 'PN',
                        'id'       => 'pn',
                    ),
                    (object)array(
                        'title_th' => 'DT',
                        'id'       => 'area',
                    ),
                    (object)array(
                        'title_th' => 'Ngân sách khoản',
                        'id'       => 'budget',
                    ),
                ],
            ),
            (object)array(
                'title_th'   => 'Thời gian',
                'id'         => 'time',
                'childs' => [
                    (object)array(
                        'title_th' => 'Ngày move in',
                        'id'       => 'date_movein',
                    ),
                    (object)array(
                        'title_th' => 'Thời gian thuê',
                        'id'       => 'date_tax',
                    ),
                ],
            ),            
            (object)array(
                'title_th'   => 'Yêu cầu khác',
                'id'         => 'requirements',
                'childs' => [],
            ),
            (object)array(
                'title_th'   => 'Trạng thái',
                'id'         => 'name_status',
                'childs' => [],
            ),

            // DA/KV đã thuê , khoảng thời hạn HHĐ, Lý do fail
            (object)array(
                'title_th'   => 'DA/KV đã thuê',
                'id'         => 'rent_project_name',
                'childs' => [],
            ),
            (object)array(
                'title_th'   => 'Khoảng thời hạn HHĐ',
                'id'         => 'duration_of_contract_expiration',
                'childs' => [],
            ),
            (object)array(
                'title_th'   => 'Lý do fail',
                'id'         => 'reason_fail',
                'childs' => [],
            ),

            (object)array(
                'title_th'   => 'NV GD',
                'id'         => 'nvgd',
                'childs' => [],
            ),
            (object)array(
                'title_th'   => 'DK SP',
                'id'         => 'dksp',
                'childs' => [],
            ),
            (object)array(
                'title_th'   => 'ĐK khách hàng',
                'id'         => 'dkkh',
                'childs' => [],
            ),
        );

        $this->clientColumns = array(
            (object)array(
                'title_th'   => 'KH từ',
                'id'         => 'clientFrom',
            ),
            (object)array(
                'title_th'   => 'Tên KH',
                'id'         => 'company',
            ),
            (object)array(
                'title_th'   => 'Nguồn',
                'id'         => 'source',
            ),
            (object)array(
                'title_th'   => 'Số đt',
                'id'         => 'phonenumber',
            ),
            (object)array(
                'title_th'   => 'Email',
                'id'         => 'email',
            ),
            (object)array(
                'title_th'   => 'Quốc tịch',
                'id'         => 'country',
            ),
            (object)array(
                'title_th'   => 'Tình trạng',
                'id'         => 'type_client',
            ),
            (object)array(
                'title_th'   => 'NV đăng ký KH',
                'id'         => 'dkkh',
            ),
            (object)array(
                'title_th'   => 'NV phụ trách KH',
                'id'         => 'nvgd',
            ),
            (object)array(
                'title_th'   => 'Ngày đăng ký',
                'id'         => 'datecreated',
            ),
        );
    }
    /* List all clients */
    public function index($id="")
    {
        if($this->input->is_ajax_request()) {
            $this->perfex_base->get_table_data('clients_summary');
        }
        $data['clients_care'] = $this->clients_model->get_clients(1);
        $data['clients_buy']  = $this->clients_model->get_clients(2);
        $data['clients_fail'] = $this->clients_model->get_clients(3);

        $data['table_clients'] = json_decode($this->clients_model->get_table('tblorder_table_clients','id=1')->value);

        $data['table_heads_clients_care'] = json_decode($this->clients_model->get_table('tblorder_table_clients','id=1')->value);
        $data['table_heads_clients_buy'] = json_decode($this->clients_model->get_table('tblorder_table_clients', 'id=2')->value);
        $data['table_heads_clients_fail'] = json_decode($this->clients_model->get_table('tblorder_table_clients','id=3')->value);
        // $data['table_heads'] = $this->clientTakeCareColumns;

        $data['autoOpenId'] = $id;
        
        $data['title'] = "Khách hàng";
        $this->load->view('admin/clients_new/manage', $data);
    }
    public function client($id)
    { 
        $data['type_client']=$this->input->get('type_client');
        
        if (!$this->input->get('group')) {
            $group = 'profile';
        } else {
            $group = $this->input->get('group');
        }
        
        if($group == 'items' && $this->input->is_ajax_request()) {
            $this->perfex_base->get_table_data('client_items', array(
                'clientId' => $id,
            ));
        }

        if($this->input->post()){
            $data = $this->input->post();
            // print_r($data);
            // exit();
            if(isset($data['time_bonus'])) {

            }
            // $data['time_bonus']=implode(',',$data['time_bonus']);
            // $data['num_bonus']=implode(',',$data['num_bonus']);
            $data['type_client']=$this->input->get('type_client');
            if($id=="")
            {
                if($data['type_client'] >= 1)
                {
                    // $data['datecreated']=date('Y-m-d');
                    $id=$this->clients_model->add_client($data);
                    if($id)
                    {
                        set_alert('success','thêm thành công');
                    }
                    else
                    {
                        set_alert('danger','Thêm không thành công');
                    }
                    
                    redirect(admin_url('clients/client/' . $id . '?type_client=' . $data['type_client']));
                }
            }
            else
            {
                if(!is_null($this->input->get('type_client')) && !is_null($this->input->get('convert'))) {
                    $data['type_client'] = $this->input->get('type_client')+1;
                }
                $result=$this->clients_model->update_client($id,$data);
                if($result)
                {
                    set_alert('success','Cập nhật dữ liệu thành công');
                }
                redirect(admin_url('clients/client/' . $id . '?type_client=' . $data['type_client']));
            }
        }
        else
        {
            if($id!="")
            {
                $data['client'] = $this->clients_model->get_data_clients($id);
                // print_r($data['client']);
                // exit();
                if($data['client']) {
                    if($group == 'profile') {
                        if(!$data['type_client']) {
                            redirect(admin_url('clients/client/' . $id . '?type_client=' . $data['client']->type_client));
                        }
                    }

                    if($group == 'billingperiod') {
                        $idItem = $this->input->get('id');
                        if(!is_null($this->input->get('id'))) {
                            $result = $this->clients_model->get_period($id, $this->input->get('id'));
                            if($result) {
                                $data['period'] = $result;
                                $data['total_period'] = $this->clients_model->count_period($id, $idItem);
                            }
                            else
                            {
                                redirect(admin_url('clients/client/' . $id . '?type_client=' . $data['client']->type_client));    
                            }
                        }
                        else {
                            redirect(admin_url('clients/client/' . $id . '?type_client=' . $data['client']->type_client));
                        }
                    }
                    $data['total_item'] = $this->clients_model->count_items($id);
                    $data['total_value'] = $this->clients_model->sum_item_value($id, $idItem);
                    $data['total_value_paid'] = $this->clients_model->sum_item_paid_value($id, $idItem);
                    $data['attachments']   = $this->clients_model->get_all_customer_attachments($id);
                    $data['staff']           = $this->staff_model->get('', 1);
                    // Get all active staff members (used to add reminder)
                    $this->load->model('staff_model');
                    $data['members'] = $this->staff_model->get('', 1);
                    // print_r($data['attachments']);
                    // exit();
                }
            }
            else
            {
                $data['type_client']=$this->input->get('type_client');
                if(!$data['type_client'])
                {
                    set_alert('danger','Đường dẩn không tồn tại');
                    redirect(admin_url('clients'));
                }
            }
            
            
            $data['group']  = $group;
            $data['groups'] = $this->clients_model->get_groups();

            $data['title']='Khách hàng';
            $data['countries']=$this->clients_model->get_table_array('tblcountries');
            $data['exigency']=$this->clients_model->get_table_array('tblexigency');
            $data['purpose']=$this->clients_model->get_table_array('tblpurpose');
            $data['source']=$this->clients_model->get_table_array('tblleadssources');
            $data['menu_project']=$this->clients_model->get_table_array('tblmenubds');
            $data['province']=$this->clients_model->get_table_array('province');
            $data['staff']=$this->clients_model->get_table_array_where('tblstaff','_delete!=1');
            $data['status']=$this->clients_model->get_table_array('tblstatus');
            $data['id_partner']=$this->clients_model->get_table_array_where('tblpartner',array('_delete!=' => '1', 'status' => 3));
            
            $data['class_client']=$this->clients_model->get_table_array('tblclass_client');
            
            $this->load->view('admin/clients/client', $data);
        }
    }
    public function activityClient($id) {
        if($this->input->post()) {
            $result = new stdClass();
            $result->success = false;
            $result->message = 'Tạo thất bại!';
            $data = $this->input->post();
            
            if($this->client_care_history_model->saveActivity($id, $data)) {
                $result->success = true;
                $result->message = 'Tạo thành công!';
            }
            exit(json_encode($result));
        }
        exit(json_encode($this->client_care_history_model->getActivities($id)));
    }
    public function modal_client($id) {
        $data['type_client']=$this->input->get('type_client');
        if (!$this->input->get('group')) {
            $group = 'profile';
        } else {
            $group = $this->input->get('group');
        }
        if($group == 'items' && $this->input->is_ajax_request()) {
            $this->perfex_base->get_table_data('client_items', array(
                'clientId' => $id,
            ));
        }

        // Xử lý dữ liệu ajax
        if($this->input->post()){
            $data = $this->input->post();

            if(isset($data['time_bonus'])) {

            }
            // $data['time_bonus']=implode(',',$data['time_bonus']);
            // $data['num_bonus']=implode(',',$data['num_bonus']);
            $data['type_client']=$this->input->get('type_client');
            if($id=="")
            {
                if($data['type_client'] >= 1)
                {
                    // $data['datecreated']=date('Y-m-d');
                    
                    $id=$this->clients_model->add_client($data);
                    $response = new stdClass();
                    if($id)
                    {
                        $response->success = true;
                        $response->message = 'thêm thành công';
                    }
                    else
                    {
                        $response->success = false;
                        $response->message = 'thêm không thành công';
                    }
                    exit(json_encode($response));
                    //redirect(admin_url('clients/client/' . $id . '?type_client=' . $data['type_client']));
                }
                
            }
            else
            {
                if(trim($data['type_client']) == '') {
                    unset($data['type_client']);
                }
                
                if(!is_null($this->input->get('type_client')) && !is_null($this->input->get('convert'))) {
                    $data['type_client'] = $this->input->get('type_client')+1;
                }
                
                $result=$this->clients_model->update_client($id,$data);
                
                if($result)
                {
                    $response->success = true;
                    $response->message = 'Cập nhật dữ liệu thành công';
                }
                else
                {
                    $response->success = false;
                    $response->message = 'Cập nhật dữ liệu không thành công';
                }
                exit(json_encode($response));
                
                // redirect(admin_url('clients/client/' . $id . '?type_client=' . $data['type_client']));
            }
        }


        if($id!="")
        {
            $data['client'] = $this->clients_model->get_data_clients($id);
            if(!$data['type_client']) {
                $data['type_client'] = $data['client']->type_client;
            }
            // print_r($data['client']);
            // exit();
            
            if($data['client']) {
                if($group == 'profile') {
                    
                }

                if($group == 'billingperiod') {
                    $idItem = $this->input->get('id');
                    if(!is_null($this->input->get('id'))) {
                        $result = $this->clients_model->get_period($id, $this->input->get('id'));
                        if($result) {
                            $data['period'] = $result;
                            $data['total_period'] = $this->clients_model->count_period($id, $idItem);
                        }
                        else
                        {
                            redirect(admin_url('clients/client/' . $id . '?type_client=' . $data['client']->type_client));    
                        }
                    }
                    else {
                        redirect(admin_url('clients/client/' . $id . '?type_client=' . $data['client']->type_client));
                    }
                }
                $data['total_item'] = $this->clients_model->count_items($id);
                $data['total_value'] = $this->clients_model->sum_item_value($id, $idItem);
                $data['total_value_paid'] = $this->clients_model->sum_item_paid_value($id, $idItem);
                $data['attachments']   = $this->clients_model->get_all_customer_attachments($id);
                $data['staff']           = $this->staff_model->get('', 1);
                // Get all active staff members (used to add reminder)
                $this->load->model('staff_model');
                $data['members'] = $this->staff_model->get('', 1);
                // print_r($data['attachments']);
                // exit();
            }
        }
        else
        {
            $data['type_client'] = $this->input->get('type_client');
            if(!$data['type_client'])
            {
                exit('Đường dẩn không tồn tại');
            }
        }

        $data['group']  = $group;
        $data['groups'] = $this->clients_model->get_groups();

        
        $data['title']='Khách hàng';
        $data['countries']=$this->clients_model->get_table_array('tblcountries');
        $data['exigency']=$this->clients_model->get_table_array('tblexigency');
        $data['purpose']=$this->clients_model->get_table_array('tblpurpose');
        $data['source']=$this->clients_model->get_table_array('tblleadssources');
        $data['menu_project']=$this->clients_model->get_table_array('tblmenubds');
        $data['province']=$this->clients_model->get_table_array('province');
        $data['staff']=$this->clients_model->get_table_array_where('tblstaff','_delete!=1');
        $data['status']=$this->clients_model->get_table_array('tblstatus');
        $data['agencies']=$this->clients_model->get_table_array('tblagencies');
        $data['id_partner']=$this->clients_model->get_table_array_where('tblpartner',array('_delete!=' => '1', 'status' => 3));
        
        $data['class_client']=$this->clients_model->get_table_array('tblclass_client');
        if(is_null($this->input->get('convert'))) {
            exit($this->load->view('admin/clients_new/modals/client', $data, true));
        }
        else {
            exit($this->load->view('admin/clients_new/modals/convert', $data, true));
        }
    }
    public function updateAvatar($idClient) {
        $result = new stdClass();
        $result->success = handle_client_avatar_image_upload($idClient);
        exit(json_encode($result));
    }
    public function updateConvert($id) {
        $response = new stdClass();
        $response->success = false;
        $response->message = 'Chuyển thất bại';
        $data = $this->input->post();
        
        $items = $data['items'];
        unset($data['items']);

        // Format date
        if(isset($data['date_movein'])) {
            $data['date_movein'] = to_sql_date($data['date_movein']);
        }
        if(isset($data['date_deal'])) {
            $data['date_deal'] = to_sql_date($data['date_deal']);
        }
        if(isset($data['expire_contract'])) {
            $data['expire_contract'] = to_sql_date($data['expire_contract']);
        }
        if(isset($data['date_movein'])) {
            $data['date_movein'] = to_sql_date($data['date_movein']);
        }

        if($data) {
            $client = $this->clients_model->get_data_clients($id);
            if($client) {
                $this->db->where('userid', $client->userid);
                $data['type_client'] = $this->input->get('type_client')+1;
                $this->db->update('tblclients', $data);
                if($this->db->affected_rows() > 0) {
                    $response->success = true;
                    $response->message = 'Chuyển thành công';
                    $this->clients_model->add_item($client->userid, $items[0]);
                }
            }
        }
        exit(json_encode($response));
    }
    public function modal_billingperiod($idClient, $idProduct) {
        $data['client'] = $this->clients_model->get_data_clients($idClient);
        $data['staff']=$this->clients_model->get_table_array_where('tblstaff','_delete!=1');
        
        $result = $this->clients_model->get_period($idClient, $idProduct);
        if($result) {
            $data['period'] = $result;
            $data['total_period'] = $this->clients_model->count_period($idClient, $idProduct);

            $data['total_item'] = $this->clients_model->count_items($idClient);
            $data['total_value'] = $this->clients_model->sum_item_value($idClient, $idProduct);
            $data['total_value_paid'] = $this->clients_model->sum_item_paid_value($idClient, $idProduct);
        }
        else
        {
            exit('Trang không tồn tại');
        }
        exit($this->load->view('admin/clients_new/modals/billingperiod', $data, true));
    }
    public function clientItems($id) {
        $this->perfex_base->get_table_data('client_items', array(
            'clientId' => $id,
        ));
    }
    public function get_project($id)
    {
        $result=$this->clients_model->get_project($id);

        echo json_encode($result);
    }
    public function get_district($id)
    {
        $result=$this->clients_model->get_district($id);

        echo json_encode($result);
    }
    public function settup_table_clients()
    {
        
        $type=$this->input->get('type_client');
        if($type)
        {
            $data['type']=$type;
            $data['title']="Cài đặt bảng khách hàng";
            $this->db->where('id',$type);
            $colums=$this->db->get('tblorder_table_clients')->row();
            if($colums)
            {
                $data['get_column'] = json_decode($colums->value);
                $data['table_heads'] = json_decode($colums->value);
                if($data['table_heads'] == null)
                    $data['table_heads'] = array();
                // var_dump($data['table_heads']);
                // exit();
                if($type == 1)
                    $data['origin_table_heads'] = $this->clientColumns;
                
            }
            $this->load->view('admin/clients/setup_table_clients',$data);
        }
        else
        {
            redirect(admin_url('clients/client'));
        }
    }
    public function update_order_table()
    {
        $type = $this->input->post('type');
        $active = $this->input->post('active');
        $jenactive = json_encode($active);
        

        $new_column = array();
        if($type==1) {
            foreach($this->clientColumns as $key=>$item) {
                $this->clientColumns[$key] = (array)$this->clientColumns[$key];
            }
            foreach($active as $active_menu) {
                $key = array_search($active_menu['id'], array_column($this->clientColumns, 'id'));
                if($key !== false) {
                    $new_column[] = $this->clientColumns[$key];
                }
            }
        }
        
        $this->db->where('id', $type);
        $order = $this->db->get('tblorder_table_clients')->row();
        if (!$order) {
            $array = array('value' => json_encode($new_column));
            $this->db->insert('tblorder_table_clients', $array);
            echo $this->db->insert_id();
        } else {
            $array = array('value' => json_encode($new_column));
            $this->db->where('id', $type);
            $this->db->update('tblorder_table_clients', $array);
        }
        echo 'Cập nhật thành công';
    }
    public function getProduct($idClient, $id) {
        $result = new stdClass();
        $result->success = false;
        $result->data = '';
        
        $item =  $this->clients_model->get_item($idClient, $id);
        if($item) {
            $result->success = true;
            $result->data = $item;
        }
        exit(json_encode($result));
    }
    public function addProduct($idClient) {
        $client = $this->clients_model->get_data_clients($idClient);
        $success = false;
        $message = "Thêm thất bại!";
        $data = $this->input->post();
        if($client && $data) {
            $data['items'][0]['price'] = preg_replace('/\D/', '', $data['items'][0]['price']);
            $data['items'][0]['commissionPartner'] = preg_replace('/\D/', '', $data['items'][0]['commissionPartner']);
            $data['items'][0]['realPrice'] = preg_replace('/\D/', '', $data['items'][0]['realPrice']);
            $result = $this->clients_model->add_item($idClient, $data['items'][0]);
            if($result) {
                $success = true;
                $message = "Thêm thành công!";
            }
        }
        exit(json_encode(array(
            'success' => $success,
            'message' => $message
        )));
    }
    public function delete($idClient) {
        if(!has_permission('customers', '', 'view')) {
            if ($id != '' && !is_customer_admin($id)) {
                access_denied('customers');
            }
        }
        $response = new stdClass();
        $response->alert_type = 'danger';
        $response->message = "Xóa thất bại";
        if($this->clients_model->delete($idClient)) {
            $response->alert_type = 'success';
            $response->message = "Xóa thành công";
        }
        exit(json_encode($response));
    }

    // Billing period
    public function addPeriod($idClient, $idProduct) {
        $success = false;
        $message = "Thêm thất bại!";
        $data = $this->input->post();
        if($data) {
            $data['status'] = 0;
            $data['value'] = preg_replace('/\D/', '', $data['value']);
            $result = $this->clients_model->add_period($idClient, $idProduct, $data);
            if($result) {
                $success = true;
                $message = "Thêm thành công!";
            }
        }
        exit(json_encode(array(
            'success' => $success,
            'message' => $message
        )));
    }
    public function getBillingPeriod($idClient, $idProduct)
    {
        $this->perfex_base->get_table_data('client_item_billing_period', array(
            'clientId' => $idClient,
            'idProduct' => $idProduct,
        ));
    }
    
    public function addPayment($idClient, $idProduct, $idClientBdsPayment) {
        $success = false;
        $message = "Thêm thất bại!";
        $data = $this->input->post();
        if($data) {
            $data['realValue'] = preg_replace('/\D/', '', $data['realValue']);
            
            $result = $this->clients_model->add_payment($idClient, $idProduct, $idClientBdsPayment, $data);
            if($result) {
                $success = true;
                $message = "Thêm thành công!";
            }
        }
        exit(json_encode(array(
            'success' => $success,
            'message' => $message
        )));
    }
    public function getPayment($idClientBds, $idPayment)
    {
        $this->perfex_base->get_table_data('client_item_billing_period_payment', array(
            'idClientBds' => $idClientBds,
            'idPayment' => $idPayment,
        ));
    }
    public function deletePayment($idClientBds, $idPayment, $idPaymentDetail)
    {
        if(!has_permission('customers', '', 'view')) {
            if ($id != '' && !is_customer_admin($id)) {
                access_denied('customers');
            }
        }
        $response = new stdClass();
        $response->alert_type = 'danger';
        $response->message = "Xóa thất bại";

        
        if($this->clients_model->deletePayment($idClientBds, $idPayment, $idPaymentDetail)) {
            $response->alert_type = 'success';
            $response->message = "Xóa thành công";
        }
        exit(json_encode($response));

        
        
    }
    public function paymentHistory($idClient) {
        if(!has_permission('customers', '', 'view')) {
            if ($id != '' && !is_customer_admin($id)) {
                access_denied('customers');
            }
        }
        $this->perfex_base->get_table_data('client_payment', array(
            'idClient' => $idClient,
        ));
    }
    /**
     * Attachment
     *
     */
    public function upload_attachment($id)
    {
        handle_client_attachments_upload($id);
    }
    public function add_external_attachment()
    {
        if ($this->input->post()) {
            $this->misc_model->add_attachment_to_database($this->input->post('clientid'), 'customer', $this->input->post('files'), $this->input->post('external'));
        }
    }
    public function delete_attachment($customer_id, $id)
    {
        if (has_permission('customers', '', 'delete') || is_customer_admin($customer_id)) {
            $this->clients_model->delete_attachment($id);
        }
        redirect($_SERVER['HTTP_REFERER']);
    }
    // Contacts
    public function contact($customer_id, $contact_id = '')
    {
        if (!has_permission('customers', '', 'view')) {
            if (!is_customer_admin($customer_id)) {
                echo _l('access_denied');
                die;
            }
        }
        $data['customer_id'] = $customer_id;
        $data['contactid']   = $contact_id;
        if ($this->input->post()) {
            $data = $this->input->post();
            unset($data['contactid']);
            if ($contact_id == '') {
                if (!has_permission('customers', '', 'create')) {
                    if (!is_customer_admin($customer_id)) {
                        header('HTTP/1.0 400 Bad error');
                        echo json_encode(array(
                            'success' => false,
                            'message' => _l('access_denied')
                        ));
                        die;
                    }
                }
                $id      = $this->clients_model->add_contact($data, $customer_id);
                $message = '';
                $success = false;
                if ($id) {
                    handle_contact_profile_image_upload($id);
                    $success = true;
                    $message = _l('added_successfuly', _l('contact'));
                }
                echo json_encode(array(
                    'success' => $success,
                    'message' => $message
                ));
                die;
            } else {
                if (!has_permission('customers', '', 'edit')) {
                    if (!is_customer_admin($customer_id)) {
                        header('HTTP/1.0 400 Bad error');
                        echo json_encode(array(
                            'success' => false,
                            'message' => _l('access_denied')
                        ));
                        die;
                    }
                }
                $original_contact = $this->clients_model->get_contact($contact_id);
                $success          = $this->clients_model->update_contact($data, $contact_id);
                $message          = '';
                $proposal_warning = false;
                $original_email   = '';
                $updated          = false;
                if (is_array($success)) {
                    if (isset($success['set_password_email_sent'])) {
                        $message = _l('set_password_email_sent_to_client');
                    } else if (isset($success['set_password_email_sent_and_profile_updated'])) {
                        $updated = true;
                        $message = _l('set_password_email_sent_to_client_and_profile_updated');
                    }
                } else {
                    if ($success == true) {
                        $updated = true;
                        $message = _l('updated_successfuly', _l('contact'));
                    }
                }
                if (handle_contact_profile_image_upload($contact_id) && !$updated) {
                    $message = _l('updated_successfuly', _l('contact'));
                    $success = true;
                }
                if ($updated == true) {
                    $contact = $this->clients_model->get_contact($contact_id);
                    if (total_rows('tblproposals', array(
                        'rel_type' => 'customer',
                        'rel_id' => $contact->userid,
                        'email' => $original_contact->email
                    )) > 0 && ($original_contact->email != $contact->email)) {
                        $proposal_warning = true;
                        $original_email   = $original_contact->email;
                    }
                }
                echo json_encode(array(
                    'success' => $success,
                    'proposal_warning' => $proposal_warning,
                    'message' => $message,
                    'original_email' => $original_email
                ));
                die;
            }
        }
        if ($contact_id == '') {
            $title = _l('add_new', _l('contact_lowercase'));
        } else {
            $data['contact'] = $this->clients_model->get_contact($contact_id);

            if (!$data['contact']) {
                header('HTTP/1.0 400 Bad error');
                echo json_encode(array(
                    'success' => false,
                    'message' => 'Contact Not Found'
                ));
                die;
            }
            $title = $data['contact']->firstname . ' ' . $data['contact']->lastname;
        }

        $data['customer_permissions'] = $this->perfex_base->get_contact_permissions();
        $data['title']                = $title;
        $this->load->view('admin/clients/modals/contact', $data);
    }
    public function update_file_share_visibility()
    {
        if ($this->input->post()) {

            $file_id           = $this->input->post('file_id');
            $share_contacts_id = array();

            if ($this->input->post('share_contacts_id')) {
                $share_contacts_id = $this->input->post('share_contacts_id');
            }

            $this->db->where('file_id', $file_id);
            $this->db->delete('tblcustomerfiles_shares');

            foreach ($share_contacts_id as $share_contact_id) {
                $this->db->insert('tblcustomerfiles_shares', array(
                    'file_id' => $file_id,
                    'contact_id' => $share_contact_id
                ));
            }

        }
    }
    public function delete_contact_profile_image($contact_id)
    {
        do_action('before_remove_contact_profile_image');
        if (file_exists(get_upload_path_by_type('contact_profile_images') . $contact_id)) {
            delete_dir(get_upload_path_by_type('contact_profile_images') . $contact_id);
        }
        $this->db->where('id', $contact_id);
        $this->db->update('tblcontacts', array(
            'profile_image' => NULL
        ));
    }
    public function mark_as_active($id)
    {
        $this->db->where('userid', $id);
        $this->db->update('tblclients', array(
            'active' => 1
        ));
        redirect(admin_url('clients/client/' . $id));
    }
    public function update_all_proposal_emails_linked_to_customer($contact_id)
    {

        $success = false;
        $email   = '';
        if ($this->input->post('update')) {
            $this->load->model('proposals_model');

            $this->db->select('email,userid');
            $this->db->where('id', $contact_id);
            $contact = $this->db->get('tblcontacts')->row();

            $proposals     = $this->proposals_model->get('', array(
                'rel_type' => 'customer',
                'rel_id' => $contact->userid,
                'email' => $this->input->post('original_email')
            ));
            $affected_rows = 0;

            foreach ($proposals as $proposal) {
                $this->db->where('id', $proposal['id']);
                $this->db->update('tblproposals', array(
                    'email' => $contact->email
                ));
                if ($this->db->affected_rows() > 0) {
                    $affected_rows++;
                }
            }

            if ($affected_rows > 0) {
                $success = true;
            }

        }
        echo json_encode(array(
            'success' => $success,
            'message' => _l('proposals_emails_updated', array(
                _l('contact_lowercase'),
                $contact->email
            ))
        ));
    }
    public function delete_contact($customer_id, $id)
    {
        if (!has_permission('customers', '', 'delete')) {
            if (!is_customer_admin($customer_id)) {
                access_denied('customers');
            }
        }

        $this->clients_model->delete_contact($id);
        redirect(admin_url('clients/client/' . $customer_id . '?tab=contacts'));
    }
    public function contacts($client_id)
    {
        $this->perfex_base->get_table_data('contacts', array(
            'client_id' => $client_id
        ));
    }

}
