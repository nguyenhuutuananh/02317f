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
    }
    /* List all clients */
    public function index()
    {
        $data['clients_care'] = $this->clients_model->get_clients(1);
        $data['clients_buy']  = $this->clients_model->get_clients(2);
        $data['clients_fail'] = $this->clients_model->get_clients(3);


        $data['table_heads_clients_care'] = json_decode($this->clients_model->get_table('tblorder_table_clients','id=1')->value);
        $data['table_heads_clients_buy'] = json_decode($this->clients_model->get_table('tblorder_table_clients', 'id=2')->value);
        $data['table_heads_clients_fail'] = json_decode($this->clients_model->get_table('tblorder_table_clients','id=3')->value);
        // $data['table_heads'] = $this->clientTakeCareColumns;

        $this->load->view('admin/clients/manage', $data);

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
            $data['time_bonus']=implode(',',$data['time_bonus']);
            $data['num_bonus']=implode(',',$data['num_bonus']);
            $data['type_client']=$this->input->get('type_client');
            if($id=="")
            {
                if($data['type_client'] >= 1)
                {
                    $data['datecreated']=date('Y-m-d');
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
            $data['id_partner']=$this->clients_model->get_table_array_where('tblpartner','_delete!=1');
            $data['class_client']=$this->clients_model->get_table_array('tblclass_client');
            
            $this->load->view('admin/clients/client', $data);
        }
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
                    $data['origin_table_heads'] = $this->clientTakeCareColumns;
                else if($type == 2) {
                    $data['origin_table_heads'] = $this->clientBuyColumns;
                }
                else if($type == 3) {
                    $data['origin_table_heads'] = $this->clientFailColumns;
                }
                
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
            foreach($this->clientTakeCareColumns as $key=>$item) {
                $this->clientTakeCareColumns[$key] = (array)$this->clientTakeCareColumns[$key];
            }
            foreach($active as $active_menu) {
                $key = array_search($active_menu['id'], array_column($this->clientTakeCareColumns, 'id'));
                if($key !== false) {
                    $new_column[] = $this->clientTakeCareColumns[$key];
                }
            }
        }
        else if($type==2) {
            foreach($this->clientBuyColumns as $key=>$item) {
                $this->clientBuyColumns[$key] = (array)$this->clientBuyColumns[$key];
            }
            foreach($active as $active_menu) {
                $key = array_search($active_menu['id'], array_column($this->clientBuyColumns, 'id'));
                if($key !== false) {
                    $new_column[] = $this->clientBuyColumns[$key];
                }
            }
        }
        else if($type==3) {
            foreach($this->clientFailColumns as $key=>$item) {
                $this->clientFailColumns[$key] = (array)$this->clientFailColumns[$key];
            }
            foreach($active as $active_menu) {
                $key = array_search($active_menu['id'], array_column($this->clientFailColumns, 'id'));
                if($key !== false) {
                    $new_column[] = $this->clientFailColumns[$key];
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
        if (!has_permission('customers', '', 'view')) {
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
}
