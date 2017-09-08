<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Clients extends Admin_controller
{
    private $not_importable_clients_fields = array('userid', 'id', 'is_primary', 'password', 'datecreated', 'last_ip', 'last_login', 'last_password_change', 'active', 'new_pass_key', 'new_pass_key_requested', 'leadid', 'default_currency', 'profile_image', 'default_language', 'direction','show_primary_contact');
    public $pdf_zip;
    function __construct()
    {
        parent::__construct();
        $this->load->model('clients_model');
    }
    /* List all clients */
    public function index()
    {

        $data['clients_care']=$this->clients_model->get_clients(1);
        $data['clients_buy']=$this->clients_model->get_clients(2);
        $data['clients_fail']=$this->clients_model->get_clients(3);
        $this->load->view('admin/clients/manage', $data);

    }
    public function client($id)
    {
        if($this->input->post()){
            $data=$this->input->post();
            $data['time_bonus']=implode(',',$data['time_bonus']);
            $data['num_bonus']=implode(',',$data['num_bonus']);
            if($id=="")
            {
                $data['type_client']=$this->input->get('type_client');
                if($data['type_client'])
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
                    redirect(admin_url('clients/client/' . $id));
                }

            }
            else
            {
                $result=$this->clients_model->update_client($id,$data);
                if($result)
                {
                    set_alert('success','Cập nhật dữ liệu thành công');
                }
                redirect(admin_url('clients/client/' . $id));
            }
        }
        else
        {
            if($id!="")
            {
                $data['client']=$this->clients_model->get_data_clients($id);
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
                $data['get_column']=json_decode($colums->value);
                // print_r($data['get_column']);
                // exit();
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
        print_r($jenactive);
        exit();
        $this->db->where('id', $type);
        $order = $this->db->get('tblorder_table_clients')->row();
        if (!$order) {
            $array = array('id' => $type, 'value' => $jenactive);
            $this->db->insert('tblorder_table_clients', $array);
            echo $this->db->insert_id();
        } else {
            $array = array('value' => $jenactive);
            $this->db->where('id', $type);
            $this->db->update('tblorder_table_clients', $array);
        }
        echo $jenactive;
        echo 'Cập nhật thành công';
    }
    public function test() {
        $columns = new stdClass();
        $columns->client_take_care = array(
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
                'title_th'   => 'Thời gian',
                'id'         => 'time',
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
                'title_th'   => 'Yêu cầu chi tiết sản phẩm',
                'id'         => 'detail',
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
        print_r(json_encode($columns));
        exit();
    }
}
