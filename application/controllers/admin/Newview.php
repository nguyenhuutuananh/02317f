<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Newview extends Admin_controller

{

    private $not_importable_clients_fields = array('userid', 'id', 'is_primary', 'password', 'datecreated', 'last_ip', 'last_login', 'last_password_change', 'active', 'new_pass_key', 'new_pass_key_requested', 'leadid', 'default_currency', 'profile_image', 'default_language', 'direction', 'show_primary_contact');

    public $pdf_zip;

    function __construct()

    {

        parent::__construct();


        $this->load->helper('form');

        $this->load->helper('url');

        $this->load->library('form_validation');

        $this->load->library('encrypt');

        $this->load->model('newview_model');

        $this->load->model('projectmenu_model');
        $this->load->helper('cookie');


    }

    /* List all clients */

    public function index()

    {
//        $this->perfex_base->get_table_data('category');
        if ($this->input->is_ajax_request()) {

            $this->perfex_base->get_table_data('category');

        }
        $data['exigency'] = $this->newview_model->get_table('tblexigency');


        $data['title'] = 'Danh sách các loại bất động sản';

        $data['menu'] = $this->newview_model->get_menu();
        $data['field'] = $this->newview_model->get_table_where('tbfield_bds', '_table="menu_bds"');


        $this->load->view('admin/newview/new_view', $data);

    }

    public function get_render()
    {
        if ($this->input->post()) {
            $data = $this->input->post();
            $_data = $data['get']['menu_bds'];
            $return_array = array();
            foreach ($_data as $rom => $value) {
                if ($value == 'on') {
                    $this->db->where('id', $rom);
                    $info = $this->db->get('tbfield_bds')->row();
                    $return_array[] = array('id' => $rom, 'id_field' => $info->id_field, 'data' => render_one_fields('menu_bds', '', array('id' => $rom)));
                }
            }
            echo json_encode($return_array);
        }
    }

    public function get_menubds($id = "")
    {
        $this->db->where('id', $id);
        $result = $this->db->get('tblmenubds')->row();
        echo json_encode($result);
    }

    public function update_menu_bds($id)
    {
        $name_menu = $this->input->post('Menu_name');
        $result = $this->newview_model->update_menu_bds($id, array('menu_name' => $name_menu));
        if ($result) {
            set_alert('success', _l('Cập nhật thành công'));
            redirect(admin_url('newview'));
        } else {
            set_alert('success', _l('Cập nhật không thành công'));
            redirect(admin_url('newview'));
        }
    }

    public function add($id = '')
    {
        if ($this->input->post()) {
            if ($id == "") {
                $_data = $this->input->post();
                $field_table = $_data['fields_table']['menu_bds'];
                $field_from = $_data['fields_form']['menu_bds'];

                $data['menu_name'] = $this->input->post('Menu_name');
                $data['menu_chil'] = $this->input->post('menu_chil');
                $data['menu_chil'] = implode(',', $data['menu_chil']);
                $data['district_from'] = $this->input->post('district_from');
                $data['district_table'] = $this->input->post('district_table');
                $data['province_from'] = $this->input->post('province_from');
                $data['province_table'] = $this->input->post('province_table');
                $this->db->insert('tblmenubds', $data);
                $id = $this->db->insert_id();
                if ($id) {
                    insert_row_menu_field($id, $field_from, $field_table);
                    echo json_encode(array(
                        'success' => true,
                        'message' => 'Thêm thành công'
                    ));

                } else {
                    echo json_encode(array(
                        'success' => false,
                        'message' => 'Thêm không thành công'
                    ));
                }
            } else {
                $_data = $this->input->post();
                $field_table = $_data['fields_table']['menu_bds'];
                $field_from = $_data['fields_form']['menu_bds'];

                $data['menu_chil'] = $this->input->post('menu_chil');
                $data['menu_chil'] = implode(',', $data['menu_chil']);
                $data['menu_name'] = $this->input->post('Menu_name');
                $data['district_from'] = $this->input->post('district_from');
                $data['district_table'] = $this->input->post('district_table');
                $data['province_from'] = $this->input->post('province_from');
                $data['province_table'] = $this->input->post('province_table');
                $name_menu = $this->input->post('Menu_name');
                $result = $this->newview_model->update_menu_bds($id, $data);
                insert_row_menu_field($id, $field_table, $field_from);
                echo json_encode(array(
                    'success' => true,
                    'message' => 'cập nhật thành công'
                ));
            }

        }


    }

    function get_menu($id)
    {
        $this->db->where('id', $id);
        $result = $this->db->get('tblmenubds')->row();
        $this->db->where('id_menu', $id);
        $this->db->join('tbfield_bds', 'tbfield_bds.id=tblrow_menu_bds.id_field', 'left');
        $result_2 = $this->db->get('tblrow_menu_bds')->result_array();
        echo json_encode(array($result_2, $result));
    }

    function get_row_menu_bds()
    {
    }


    public function addchil($id = false)

    {


        if ($this->input->post()) {


            $data['parent_id'] = $this->input->post('parent_id');

            $a = $this->db->get_where('tblmenubds', array('id' => $data['parent_id']))->row();


            $data['Menu_name'] = $a->menu_name;


            $data['menu_chil'] = $this->input->post('menu_chil');

            $this->db->insert('tblmenubds', $data);

            $id = $this->db->insert_id();


            if ($id) {

                set_alert('success', _l('new_ticket_added_succesfuly', $id));

                redirect(admin_url('newview'));

            }

        }


        $data['bodyclass'] = 'ticket';

        $data['title'] = _l('new_ticket');

        $this->load->view('admin/newview/new_view', $data);


    }


    function delete_true($id)
    {
        $table = $this->input->post('table');
        $table = 'tbl' . $table;
        $result = $this->newview_model->_delete($id, $table);
        if ($table == 'tblcall_logs') {
            $mes = "Nhật ký cuộc gọi";
            $v_id = 'ID';
            $p_id = 'id_project_bds';
        } else {
            if ($table == 'tblmaster_bds') {
                $mes = "Chủ sở hữu";
                $v_id = 'id';
                $p_id = 'idproject';
            }
        }
        if ($result) {
            $this->db->where($v_id, $id);
            $re = $this->db->get($table)->row();
            $this->update_date($re->$p_id);
            $this->active_log_bds($re->$p_id, 'Xóa  ' . $mes . '[ID: ' . $id . '] bởi[' . get_staff_user_id() . ': ' . get_staff_full_name(get_staff_user_id()) . ']');
            echo json_encode(array('success' => true, 'message' => 'Xóa  dữ liệu thành công'));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Không dữ liệu nào được xóa'));
        }
    }

    function delete_profile($id)
    {
        $result = $this->newview_model->delete_profile($id);
        if ($result) {
            $this->db->where('id', $id);
            $view = $this->db->get('tblprofile_project')->row();
            $this->update_date($view->id_project);
            $this->active_log_bds($view->id_project, 'Xóa người quản trị  [ID: ' . $view->id_staff . '(' . get_staff_full_name($view->id_staff) . ')]' . 'bởi[' . get_staff_user_id() . ': ' . get_staff_full_name(get_staff_user_id()) . ']');

            echo json_encode(array('success' => true, 'message' => 'Xóa  dữ liệu thành công'));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Không dữ liệu nào được xóa'));
        }
    }


    public function delete($id)

    {

        if (!$id) {

            redirect(admin_url('newview'));

        }


        $response = $this->newview_model->delete($id);


        if (is_array($response) && isset($response['referenced'])) {

            set_alert('warning', _l('is_referenced', _l('tax_lowercase')));

        } else if ($response == true) {

            set_alert('success', _l('deleted', 'Danh mục'));

        } else {

            set_alert('warning', _l('problem_deleting', _l('tax_lowercase')));

        }


        redirect(admin_url('newview'));

    }


    public function active_log_bds($id_project, $name)
    {
        $this->db->insert('tbllog_bds', array('id_project' => $id_project, 'name' => $name, 'date' => date('Y-m-d H:i:s'), 'staffid' => get_staff_user_id()));
    }

    public function init_relation_logs($id = "")
    {
        if ($this->input->is_ajax_request()) {
            $this->perfex_base->get_table_data('call_logs_relations', array(
                'id' => $id,
            ));
        }
    }

    public function init_relation_master_bds($id = "", $type = "")
    {
        if ($this->input->is_ajax_request()) {
            $this->perfex_base->get_table_data('master', array('project_id' => $id, 'type_master' => $type));
        }
    }

    public function init_relation_take($id = "")
    {
        if ($this->input->is_ajax_request()) {
            $this->perfex_base->get_table_data('profile_project', array('project_id' => $id));
        }
    }

    public function get_code_project($id)
    {
        $this->db->where('id', $id);
        $result = $this->db->get('tblprojects')->row();
        $this->db->select('count(project) as count');
        $this->db->where('project', $id);
        $count = $this->db->get('tblprojectmenu')->row();
        echo json_encode(array('code' => $result->code_project . '-' . ($count->count + 1)));
    }

    public function project($id_menu = "", $id = "")
    {
        if ($this->input->post()) {

            $data = $this->input->post();
            $_data = $data['fields']['menu_bds'];
            unset($data['fields']);

            $type_deadline = $data['type_deadline'];
            if ($type_deadline == 3) {
                $data['deadline'] = $data['lo_deadtime'];
            } else if ($type_deadline == 4) {
                $data['deadline'] = $data['to_deadtime'];
            } else {
                $data['deadline'] = "";
            }
            unset($data['lo_deadtime']);
            unset($data['to_deadtime']);


            $data['date_update'] = date('Y-m-d');
            unset($data['DataTables_Table_0_length']);
            $data['cost'] = str_replace('.', '', $data['cost']);
            $data['price'] = str_replace('.', '', $data['price']);
            $data['date_update'] = date('Y-m-d');
            if ($id == "") {
                $data['staff_id'] = get_staff_user_id();
                $data_exigency = $data['exigency'];
                unset($data['exigency']);
                $success = $this->newview_model->add($data);
                if ($success) {
                    $this->newview_model->add_exigency($success, $data_exigency);
                    $this->newview_model->add_field_value($success, $_data);
                    set_alert('success', _l('Thêm thành công dự án bất động sản'));
                    redirect(admin_url('newview/project/' . $data['id_menu'] . '/' . $success));
                } else {
                    set_alert('danger', _l('Lổi trong quá trình thêm dự án bất động sản'));
                    redirect(admin_url('newview/project/' . $id_menu));
                }
            } else {
                $data_exigency = $data['exigency'];
                unset($data['exigency']);
                unset($_data['exigency']);
                $data['date_update'] = date('Y-m-d');
                $success = $this->newview_model->update($id, $data);
                $result = $this->newview_model->add_field_value($id, $_data);
                $tags = $data['tags'];
                handle_tags_save($tags, $id, 'project_bds');
                $ex = $this->newview_model->update_exigency($id, $data_exigency);
                if ($success || $result || $ex) {
                    $data['staff_id'] = get_staff_user_id();
                    set_alert('success', _l('Cập nhật thành công dự án bất động sản'));
                    $this->active_log_bds($id, 'Cập nhật bất động sản ' . $id . ' bởi[' . get_staff_user_id() . ': ' . get_staff_full_name(get_staff_user_id()) . ']');
                    redirect(admin_url('newview/indexproject/' . $data['id_menu']));
                }
            }

        } else {
            $data['id_menu'] = $this->newview_model->getmenu($id_menu);
            $id_project = $this->input->get('project');
            if ($id_project != "") {
                $data['id_project'] = $id_project;
            } else {
                $data['id_project'] = false;
            }
            if ($data['id_menu']) {
                if ($id == "") {
                    $data['title'] = "Thêm Bất động sản";
                    $data['s_project'] = $this->newview_model->get_table_where('tblprojects', '_delete=0 and id_menu=' . $id_menu);
                    $data['province'] = $this->newview_model->get_table('province');
                    $data['door_direction'] = $this->newview_model->get_table_where('tbldoor_direction', 'type=0');
                    $data['furniture'] = $this->newview_model->get_table_where('tbldoor_direction', 'type=1');
                    $data['id_menu'] = $this->newview_model->getmenu($id_menu);
                    $data['bds_field'] = $this->newview_model->get_field($id_menu);
                    $data['exigency'] = $this->newview_model->get_exigency_menu($id, $data['id_menu']->menu_chil);
                    $data['status'] = $this->newview_model->getstatus();
                } else {
                    $data['project'] = $this->newview_model->get_projectmenu($id);
                    if ($data['project']) {
                        $data['s_project'] = $this->newview_model->get_table_where('tblprojects', '_delete=0 and id_menu=' . $id_menu);
                        $data['province'] = $this->newview_model->get_table('province');
                        $data['district'] = $this->newview_model->get_table_where('district', 'provinceid="' . $data['project']->province . '"');
                        $data['door_direction'] = $this->newview_model->get_table_where('tbldoor_direction', 'type=0');
                        $data['furniture'] = $this->newview_model->get_table_where('tbldoor_direction', 'type=1');
                        $data['id_menu'] = $this->newview_model->getmenu($id_menu);
                        $data['exigency'] = $this->newview_model->get_exigency_menu($id, $data['id_menu']->menu_chil);
                        $data['title'] = "Cập nhật Bất động sản";
                        $data['id_bds'] = $id;
                        $data['images_project'] = $this->newview_model->get_table_where('tblfile_bds', 'id_project=' . $id . ' and type=1');
                        $data['video_project'] = $this->newview_model->get_table_where('tblfile_bds', 'id_project=' . $id . ' and type=0');
                        $data['log_bds'] = $this->newview_model->get_table_where_order('tbllog_bds', 'id_project=' . $id, 'date', 'desc');
                        $data['customer'] = $this->newview_model->get_table_staff('tblprofile_project.id_project=' . $id);
                        $data['staff'] = $this->newview_model->get_table_staff_fullname('active=1');
                        $data['cus_exigency'] = $this->newview_model->get_table_where('tblproject_exigency', 'id_project= ' . $id);
                        $data['type_master'] = $this->newview_model->get_table_where('tblmaster_bds', 'idproject= ' . $id . ' and _delete=0 and type_master=1');
                        $data['status'] = $this->newview_model->getstatus();
                    } else {
                        blank_page(_l('Không tìm thấy bất động sản'), 'danger');
                    }
                }
            } else {
                blank_page(_l('Không tìm thấy bất động sản'), 'danger');
            }
        }
        $data['lightbox_assets'] = true;
        $this->load->view('admin/newview/project', $data);
    }

    public function delete_project($id, $id_menu, $type = "")
    {
        if ($id != "") {
            $project = $this->input->get('project');
            if ($project) {
                $view_project = $id_menu . '?project=' . $project;
            } else {
                $view_project = $id_menu;
            }
            if ($type == "") {
                $response = $this->newview_model->delete_project($id);
                set_alert('success', 'Xóa bất động sản thành công');
                redirect(admin_url() . 'newview/indexproject/' . $view_project);
            } else {
                $this->db->where('id_project', $id);
                $this->db->where('id_exigency', $type);
                $this->db->delete('tblproject_exigency');
                if ($this->db->affected_rows() > 0) {
                    set_alert('success', 'Xóa bất động sản thành công');
                }
                redirect(admin_url() . 'newview/indexproject/' . $view_project);
            }
        }
    }

    public function sendemail()
    {
        $email = $this->input->post('email');
        $theme = $this->input->post('theme');
        $images_send = $this->input->post('images_send');
        $description = $this->input->post('description');
        $to_email_cc = $this->input->post('to_email_cc');
        $to_email_bc = $this->input->post('to_email_bc');
        $watermark=$this->input->post('watermark');
        $sender_email = 'lechicong128@gmail.com';
        $password = 'lechicong';
        include APPPATH . 'third_party/PHPMailer_5.2.0/class.phpmailer.php';
        $mail = new PHPMailer;
        $mail->CharSet = 'UTF-8';
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = $sender_email;                 // SMTP username
        $mail->Password = $password;                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;
        $mail->setFrom($sender_email, 'CRM');
        if ($email != "" || $to_email_cc != "" || $to_email_bc != "") {
            $email = explode(',', $email);
            foreach ($email as $rom) {
                if ($rom != "") {
                    $mail->addAddress($rom);
                }
            }
            $to_email_cc = explode(',', $to_email_cc);
            foreach ($to_email_cc as $rom_cc) {
                if ($rom_cc) {
                    $mail->addCC($rom_cc);
                }

            }
            $to_email_bc = explode(',', $to_email_bc);
            foreach ($to_email_bc as $rom_bc) {
                if ($rom_cc != "") {
                    $mail->addBCC($rom_bc);
                }
            }
            if ($images_send != "") {
                $name_file = explode(',', $images_send);
                if(!$watermark)
                {
                    foreach ($name_file as $file) {
                        if ($file != "") {
                            $mail->addStringAttachment(file_get_contents(get_upload_path_by_type('project_bds') . $file), $file);
                        }
                    }
                }
                else
                {
                    if($watermark==1)
                    {
                        $this->upload_file_watermark($name_file,'setting_watermark_images');
                        foreach ($name_file as $file) {
                            if ($file != "") {
                                $mail->addStringAttachment(file_get_contents(get_upload_path_by_type('watermark') . $file), $file);
                            }
                        }

                    }
                    else
                        if($watermark==2)
                        {
                            $this->upload_file_watermark($name_file,'setting_watermark_text');
                            foreach ($name_file as $file) {
                                if ($file != "") {
                                    $mail->addStringAttachment(file_get_contents(get_upload_path_by_type('watermark') . $file), $file);
                                }
                            }
                        }
                }
            }
//            $id_log=$this->email_marketing_model->log_sent_email($data['email'],$data['email_to_bc'],$data['email_to_cc'],$subject,$message,$data['file_send'],$template);
            $mail->addReplyTo($sender_email, 'Information');
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $theme;
//                    $mail->Body = $message.$this->javacript();
            $mail->Body = $description;
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
            if (!$mail->send()) {
                echo json_encode(array('danger' => true, 'message' => 'Message could not be sent!. <br>' . 'Mailer Error: ' . $mail->ErrorInfo));
            } else {
                echo json_encode(array('success' => true, 'message' => 'Message has been sent'));
            }
        }
    }

    public function setting_tb()
    {
        set_alert('warning', 'Cần phải cài đặt hiển thị bảng');
        redirect(admin_url('newview'));
    }

    public function get_district($id)
    {
        $this->db->where('provinceid', $id);
        $result = $this->db->get('district')->result_array();
        echo json_encode($result);

    }

    public function get_video($id)
    {
        $this->db->where('id', $id);
        echo json_encode($this->db->get('tblfile_bds')->row_array());
    }

    public function get_master($id = "")
    {
        $this->db->where('id', $id);
        echo json_encode($this->db->get('tblmaster_bds')->row_array());
    }
    public function update_master($id = "")
    {
        if ($this->input->post()) {
            $data = $this->input->post();
            if ($id != "") {
                $this->db->where('id', $id);
                $_data = $this->db->get('tblmaster_bds')->row();
                unset($data['code_master']);
                $this->db->where('id', $id);
                $this->db->update('tblmaster_bds', $data);

                $this->db->where('code_master',$_data->code_master);
                $this->db->update('tblmaster_bds', $data);
                if ($this->db->affected_rows() > 0) {
                    $this->update_date($_data->idproject);
                    $this->active_log_bds($_data->idproject, 'Cập nhật chủ sở hữu [' . $id . '] bởi[' . get_staff_user_id() . ': ' . get_staff_full_name(get_staff_user_id()) . ']');
                    logActivity('Cập nhật chủ sở hữu  [ID: ' . $id . '] bởi' . get_staff_user_id());
                    echo json_encode(array(
                        'success' => true,
                        'message' => 'Cập nhật thành công'
                    ));
                } else {
                    echo json_encode(array(
                        'success' => false,
                        'message' => 'Cập nhật không thành công'
                    ));
                }

            }
            else
            {

                    $this->db->where('idproject',$data['idproject']);
                    if($data['type_master']==1)
                    {
                        $this->db->where('type_master',2);
                    }
                    if($data['type_master']==0)
                    {
                        $this->db->where('type_master',3);
                    }
                    $this->db->where('_delete',0);
                    $code_master=$this->db->get('tblmaster_bds')->row();
                    if($code_master)
                    {

                        if($data['type_master']!=1)
                        {
                            if($code_master->type_master==='3')
                            {
                                $data['type_master']=0;
                            }
                            if($code_master->type_master==='2')
                            {
                                $data['type_master']=1;
                            }
                        }
                        $data['code_master'] = $code_master->code_master;
                    }
                    else
                    {
                        if($data['type_master']==0)
                        {
                            $data['type_master']=3;
                        }
                        if($data['code_master']=="")
                        {
                            $data['code_master'] = 'O' . ($this->newview_model->getcode_master()+1);
                        }
                    }
                $this->db->insert('tblmaster_bds', $data);
                $id=$this->db->insert_id();
                unset($data['type_master']);
                unset($data['code_master']);
                unset($data['view']);
                if ($this->db->affected_rows() > 0) {
                    $this->db->where('code_master',$data['code_master']);
                    $this->db->where('idproject!='.$data['idproject']);
                    $this->db->where('type_master',3);
                    $this->db->or_where('type_master',2);
                    $this->db->update('tblmaster_bds', $data);
                    $this->update_date($data['idproject']);
                    logActivity('Thêm chủ sở hữu [ID: ' . $id . ', ' . $data['firstname'] . ' ' . $data['lastname'] . ']');

                    echo json_encode(array(
                        'success' => true,
                        'message' => 'Thêm chủ sở hữu thành công'
                    ));
                } else {
                    echo json_encode(array(
                        'success' => false,
                        'message' => 'Thêm chủ sở hữu không thành công'
                    ));
                }
            }
        }

    }

    public function update_master_company($id = "")
    {
        if ($this->input->post()) {
            $data = $this->input->post();
            if ($id != "") {
                $this->db->where('id', $id);
                $_data = $this->db->get('tblmaster_bds')->row();
                $this->db->where('id', $id);
                $this->db->update('tblmaster_bds', $data);
                if ($this->db->affected_rows() > 0) {
                    $this->update_date($_data->idproject);
                    $this->active_log_bds($_data->idproject, 'Cập nhật chủ sở hữu [' . $id . '] bởi[' . get_staff_user_id() . ': ' . get_staff_full_name(get_staff_user_id()) . ']');
                    logActivity('Cập nhật chủ sở hữu  [ID: ' . $id . '] bởi' . get_staff_user_id());
                    echo json_encode(array(
                        'success' => true,
                        'message' => 'Cập nhật thành công'
                    ));
                } else {
                    echo json_encode(array(
                        'success' => false,
                        'message' => 'Cập nhật không thành công'

                    ));
                }

            }
            else {
                if($data['code_master']=="")
                {
                    $data['code_master'] = 'O' . ($this->newview_model->getcode_master()+1);
                }
                $data['type_master'] = '2';
                $this->db->insert('tblmaster_bds', $data);
                if ($this->db->affected_rows() > 0) {
                    $this->update_date($data['idproject']);
                    logActivity('Thêm chủ sở hữu [ID: ' . $id . ', ' . $data['firstname'] . ' ' . $data['lastname'] . ']');
                    echo json_encode(array(
                        'success' => true,
                        'message' => 'Thêm chủ sở hữu thành công'
                    ));
                } else {
                    echo json_encode(array(
                        'success' => false,
                        'message' => 'Thêm chủ sở hữu không thành công'
                    ));
                }
            }
        }

    }

    public function update_call_logs($id = "")
    {
        if ($this->input->post()) {
            $data = $this->input->post();
            if ($id != "") {
                $this->db->where('id', $id);
                $_data = $this->db->get('tblcall_logs')->row();
                $this->db->where('id', $id);
                $this->db->update('tblcall_logs', $data);
                if ($this->db->affected_rows() > 0) {
                    $this->update_date($_data->idproject);
                    $this->active_log_bds($_data->idproject, 'Cập nhật Nhật ký cuộc gọi của [' . get_staff_full_name($_data->assigned) . '] bởi[' . get_staff_user_id() . ': ' . get_staff_full_name(get_staff_user_id()) . ']');
                    logActivity('Cập nhật Nhật ký cuộc gọi  [ID: ' . $id . '] bởi' . get_staff_user_id());
                    echo json_encode(array(
                        'success' => true,
                        'message' => 'Cập nhật thành công'
                    ));
                } else {
                    echo json_encode(array(
                        'success' => false,
                        'message' => 'Cập nhật không thành công'

                    ));
                }

            } else {
                $data['assigned'] = get_staff_user_id();
                $this->db->insert('tblcall_logs', $data);
                if ($this->db->affected_rows() > 0) {
                    $this->db->where('id', $data['id_project_bds']);
                    $this->db->update('tblprojectmenu', array('date_update' => date('Y-m-d')));
                    logActivity('Thêm nhật ký cuộc gọi [ID: ' . $id . '] bởi [' . get_staff_user_id() . ': ' . get_staff_full_name(get_staff_user_id()) . ']');
                    echo json_encode(array(
                        'success' => true,
                        'message' => 'Thêm nhật ký cuộc gọi thành công'
                    ));
                } else {
                    echo json_encode(array(
                        'success' => false,
                        'message' => 'Thêm nhật ký cuộc gọi không thành công'
                    ));
                }
            }
        }

    }

    public function update_date($idproject)
    {
        $this->db->where('id', $idproject);
        $this->db->update('tblprojectmenu', array('date_update' => date('Y-m-d')));
    }

    public function update_profile()
    {
        if ($this->input->post()) {
            $data = $this->input->post();
            $__data['id_project'] = $data['id_project'];
            $this->db->where('id_project', $data['id_project']);
            $_data = $this->db->get('tblprofile_project')->result_array();
            $id_staff = $data['customer'];
            $this->db->delete('tblprofile_project', array('id_project' => $data['id_project']));
            $_sarray = array();
            foreach ($_data as $r) {
                $_sarray[] = $r['id_staff'];
            }
            $kt_array = array();

            foreach ($id_staff as $rom) {
                if (in_array($rom, $_sarray) === true) {
                    foreach ($_data as $time) {
                        if ($time['id_staff'] === $rom) {
                            $__data['date'] = $time['date'];
                            $__data['addedfrom'] = $time['addedfrom'];
                        }
                    }
                    $__data['id_staff'] = $rom;
                    $this->db->insert('tblprofile_project', $__data);
                } else {
                    $__data['addedfrom'] = get_staff_user_id();
                    $__data['date'] = date('Y-m-d H:i:s');
                    $__data['id_staff'] = $rom;
                    $this->db->insert('tblprofile_project', $__data);
                }
            }
            if ($this->db->affected_rows() > 0) {
                $this->update_date($__data['id_project']);
                $this->active_log_bds($__data['id_project'], 'Cập nhật gười quản trị cho bất động sản của [ID: ' . $__data['id_project'] . '] bởi[' . get_staff_user_id() . ': ' . get_staff_full_name(get_staff_user_id()) . ']');
                logActivity('Cập nhật Người quản trị cho bất động sản  [ID: ' . $__data['id_project'] . '] bởi' . get_staff_user_id());
                echo json_encode(array(
                    'success' => true,
                    'message' => 'Cập nhật thành công'

                ));
            } else {
                echo json_encode(array(
                    'success' => false,
                    'message' => 'Cập nhật không thành công'

                ));
            }
        }
    }

    public function setup_table($id)
    {
        $data['render_colum'] = $this->newview_model->get_colum($id);
        $data['order_colum'] = $this->newview_model->get_order_colum($id);
        $data['name_colum'] = $this->newview_model->get_table('tblname_colum');
        $data['id_menu'] = $id;
        $data['title'] = 'Sắp xếp bảng';
        $this->load->view('admin/newview/setup_table', $data);
    }

    public function rename_table($id)
    {
        $data['render_colum'] = $this->newview_model->get_colum($id);
        $data['name_colum'] = $this->newview_model->get_table('tblname_colum');
        $data['id_menu'] = $id;
        $data['title'] = 'Đổi tên bảng';
        $this->load->view('admin/field_bds/rename_table', $data);
    }

    public function get_option()
    {
        $name_colum = $this->input->post('colum');
        $not_id = $this->input->post('not_id');
        $id_pro = $this->input->post('id_pro');
        if ($name_colum == "province_name") {
            $result = $this->newview_model->get_table_where('province', 'provinceid!=' . $not_id);
            echo json_encode($result);
        } else {
            if ($name_colum == "district_name") {
                $result = $this->newview_model->get_table_where('district', 'provinceid = ' . $id_pro);
                echo json_encode($result);
            } else {
                if ($name_colum == "door_direction_name") {
                    $result = $this->newview_model->get_table_where('tbldoor_direction', 'type=0 and id!=' . $not_id);
                    echo json_encode($result);

                } else
                    if ($name_colum == "furniture_name") {
                        $result = $this->newview_model->get_table_where('tbldoor_direction', 'type=1 and id!=' . $not_id);
                        echo json_encode($result);
                    } else if ($name_colum == "status") {
                        $result = $this->newview_model->get_table('tblstatusbds');
                        echo json_encode($result);
                    }
            }
        }
    }

    public function update_data()
    {
        $id_menu = $this->input->post('id_menu');
        $id = $this->input->post('id');
        $name_colum = $this->input->post('colum');
        $field = $this->input->post('field');
        $value = $this->input->post('value');
        if ($field) {
            $this->db->select('tbfield_bds.*');
            $this->db->join('tblfieldvalue_bds', 'tblfieldvalue_bds.field_id=tbfield_bds.id');
            $this->db->where('tblfieldvalue_bds.colum_id', $id);
            $this->db->where('tbfield_bds.id_field', $field);
            $get_value = $this->db->get('tbfield_bds')->row();
            if ($get_value) {
                $this->db->where('field_id', $get_value->id);
                $this->db->where('colum_id', $id);
                $this->db->update('tblfieldvalue_bds', array('value' => $value));
                if ($this->db->affected_rows() > 0) {
                    echo json_encode(array('success' => true, 'message' => 'Cập nhật thành công'));
                }
            } else {
                $this->db->where('id_field', $field);
                $get_value = $this->db->get('tbfield_bds')->row();
                $this->db->insert('tblfieldvalue_bds', array('field_id' => $get_value->id, 'colum_id' => $id, 'value' => $value));
                $true_id = $this->db->insert_id();
                if ($true_id) {
                    echo json_encode(array('success' => true, 'message' => 'Cập nhật thành công'));
                }

            }
        } else {
            if ($name_colum != "province_name" && $name_colum != "district_name" && $name_colum != "door_direction_name" && $name_colum != "furniture_name") {
                $this->db->where('id', $id);
                $this->db->update('tblprojectmenu', array($name_colum => $value));
                if ($this->db->affected_rows() > 0) {
                    echo json_encode(array('success' => true, 'message' => 'Cập nhật thành công'));
                }
            } else {
                if ($name_colum == "province_name") {
                    $this->db->where('id', $id);
                    $this->db->update('tblprojectmenu', array('province' => $value, 'district' => 0));
                    if ($this->db->affected_rows() > 0) {
                        echo json_encode(array('success' => true, 'message' => 'Cập nhật thành công'));
                    }
                } else {
                    if ($name_colum == "district_name") {
                        $this->db->where('id', $id);
                        $this->db->update('tblprojectmenu', array('district' => $value));
                        if ($this->db->affected_rows() > 0) {
                            echo json_encode(array('success' => true, 'message' => 'Cập nhật thành công'));
                        }
                    } else {
                        if ($name_colum == "door_direction_name") {
                            $this->db->where('id', $id);
                            $this->db->update('tblprojectmenu', array('door_direction' => $value));
                            if ($this->db->affected_rows() > 0) {
                                echo json_encode(array('success' => true, 'message' => 'Cập nhật thành công'));
                            }
                        } else
                            if ($name_colum == "furniture_name") {
                                $this->db->where('id', $id);
                                $this->db->update('tblprojectmenu', array('furniture' => $value));
                                if ($this->db->affected_rows() > 0) {
                                    echo json_encode(array('success' => true, 'message' => 'Cập nhật thành công'));
                                }
                            }
                    }
                }
            }
        }
    }

    public function update_order_table()
    {
        $id_menu = $this->input->post('id_menu');
        $active = $this->input->post('active');
        $jenactive = json_encode($active);
//        var_dump($active);die();
        $this->db->where('id_menu', $id_menu);
        $order = $this->db->get('tblorder_table')->row();
//        var_dump($order);
        if (!$order) {
            $array = array('id_menu' => $id_menu, 'active' => $jenactive);
            $this->db->insert('tblorder_table', $array);
            echo $this->db->insert_id();
        } else {
            $array = array('active' => $jenactive);
            $this->db->where('id_menu', $id_menu);
            $this->db->update('tblorder_table', $array);
        }
        echo 'Cập nhật thành công';
    }

    public function get_one_table_call($id)
    {
        $this->db->where('id', $id);
        $result = $this->db->get('tblcall_logs')->row();
        echo json_encode($result);

    }

    public function get_one_table_profile($id)
    {
        $this->db->where('id', $id);
        $result = $this->db->get('tblprofile_project')->row();
        echo json_encode($result);

    }

    public function update_view_master($id, $status)
    {
        $this->db->where('id', $id);
        $_data = $this->db->get('tblmaster_bds')->row();
        if ($status == 1) {
            $this->db->update('tblmaster_bds', array('view' => 0));
            if ($this->db->affected_rows() > 0) {
                $this->active_log_bds($_data->idproject, 'Chuyển trạng thái chủ sở hữu [' . $id . '] là chủ sở hữu phụ  bởi[' . get_staff_user_id() . ': ' . get_staff_full_name(get_staff_user_id()) . ']');
                logActivity('[ID: ' . $id . '] được xóa khỏi chủ sở hữu chính');
                echo "true";
            }
        } else {
            $this->db->where('id', $id);
            $resu = $this->db->get('tblmaster_bds')->row();
            $this->db->where('idproject', $resu->idproject);
            $this->db->update('tblmaster_bds', array('view' => 0));
            $this->db->where('id', $id);
            $this->db->update('tblmaster_bds', array('view' => 1));
            if ($this->db->affected_rows() > 0) {
                $this->active_log_bds($_data->idproject, 'Chuyển trạng thái chủ sở hữu [' . $id . '] là chủ sở hữu chính bởi[' . get_staff_user_id() . ': ' . get_staff_full_name(get_staff_user_id()) . ']');
                logActivity('cập nhật chủ sở hữu [ID: ' . $id . '] thành chử sở hữu chính');
                echo "true";
            }
        }
    }
    public function update_type_master($id, $type)
    {
        $this->db->where('id',$id);
        $master=$this->db->get('tblmaster_bds')->row();
        if($type==0)
        {
            $untype=3;
        }
        else
        {
            $untype=0;
        }
        if($master)
        {
            $this->db->where('id',$id);
            $this->db->where('idproject',$master->idproject);
            $update_master=$this->db->update('tblmaster_bds',array('type_master'=>$untype));
            if ($this->db->affected_rows() > 0) {
                $this->db->where('id!='.$id);
                $this->db->where('idproject',$master->idproject);
                $this->db->update('tblmaster_bds',array('type_master'=>$type));
                if ($this->db->affected_rows() > 0) {
                    echo json_encode(array('success' => true, 'message' => 'Chuyển trạng thái thành công'));
                }
                else
                {
                    echo json_encode(array('success' => false, 'message' => 'Chuyển trạng không thái thành công'));
                }
            }
            else
            {
                echo json_encode(array('success' => false, 'message' => 'Chuyển trạng không thái thành công'));
            }
        }
    }

    public function status_project()
    {
        $id = $this->input->post('id');
        $id_project = $this->input->post('id_project');
        if ($id != "") {
            $this->db->where('id', $id_project);
            $resu = $this->db->get('tblprojectmenu')->row();
            $this->db->where('id', $resu->exigency);
            $ex = $this->db->get('tblexigency')->row();
            $this->db->where('id', $id_project);

            $this->db->where('id_exigency', $id);
            $this->db->where('id_project', $id_project);
            $pro_ex = $this->db->get('tblproject_exigency')->row();
            if ($pro_ex) {
                $success = $this->db->update('tblproject_exigency', array('id_exigency' => $id));
            } else {
                $this->db->insert('tblproject_exigency', array('id_exigency' => $id, 'id_project' => $id_project, 'addedfrom' => get_staff_user_id()));
            }


            if ($this->db->affected_rows() > 0) {
                logActivity('Thêm trạng thái bất động sản [ID: ' . $id_project . ']');
                $this->active_log_bds($id_project, 'Chuyển trạng thái sản phẩm  ' . $ex->name . '[' . $id_project . '] bởi[' . get_staff_user_id() . ': ' . get_staff_full_name(get_staff_user_id()) . ']');
                echo json_encode(array('success' => true, 'message' => 'Chuyển trạng thái thành công'));
            }
        }
    }

    public function delete_mess()
    {

        $array_id = $this->input->post('array_id');
        $table = $this->input->post('table');
        $table = 'tbl' . $table;
        $mes = "";
        $v_id = "";
        if ($table == 'tblcall_logs') {
            $mes = "Nhật ký cuộc gọi";
            $v_id = 'ID';
            $p_id = 'id_project_bds';
        } else {
            if ($table == 'tblmaster_bds') {
                $mes = "Chủ sở hữu";
                $v_id = 'id';
                $p_id = 'idproject';
            }
        }
        $i = 0;
        foreach ($array_id as $rom) {
            $result = $this->newview_model->_delete($rom, $table);
            if ($result) {
                $i++;
                $this->db->where($v_id, $rom);
                $view = $this->db->get($table)->row();
                $this->active_log_bds($view->$p_id, 'Xóa dữ liệu ' . $mes . '[ID: ' . $rom . ']' . 'bởi[' . get_staff_user_id() . ': ' . get_staff_full_name(get_staff_user_id()) . ']');
            }
        }
        if ($i > 0) {
            echo json_encode(array('success' => true, 'message' => 'Xóa ' . $i . ' dữ liệu thành công'));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Không dữ liệu nào được xóa'));
        }
    }

    public function upload_file_watermark($images=array(),$name="")
    {
//        $images=array('1.jpg','2.jpg','3.jpg');
//        $name='setting_watermark_text';
        $this->db->where('name',$name);
        $option=$this->db->get('tbloptions')->row();
        $value=json_decode($option->value);
        if($name=='setting_watermark_images')
        {
            foreach($images as $rom)
            {
                copy('./uploads/project_bds/'.$rom,"./uploads/watermark/".$rom);
                unset($config);
                $this->load->library("image_lib");
                $this->image_lib->resize();
                $this->image_lib->clear();
                $config['source_image'] = './uploads/watermark/'.$rom;
                $config['create_thumb'] = FALSE;
                $config['wm_type'] = 'overlay';
                $config['wm_overlay_path'] = './'.$value->img_logo;
                $config['wm_vrt_alignment'] = $value->vitri;
                $config['wm_hor_alignment'] = $value->canhvitri;
                $config['wm_padding'] = '0';
                $config['wm_opacity'] =  $value->opacity;
                $this->image_lib->initialize($config);
                $this->image_lib->watermark();
            }
        }
        else
        {
            foreach($images as $rom)
            {
                copy('./uploads/project_bds/'.$rom,"./uploads/watermark/".$rom);
                unset($config);
                $this->load->library("image_lib");
                $this->image_lib->resize();
                $this->image_lib->clear();
                $config['source_image'] = './uploads/watermark/'.$rom;
                $config['wm_text'] = $value->text;
                $config['wm_type'] = 'text';
                $config['wm_font_size'] = $value->fontsize;
                $config['wm_font_color'] = $value->color;
                $config['wm_vrt_alignment'] = $value->vitri;
                $config['wm_hor_alignment'] = $value->canhvitri;
                $config['wm_padding'] = '0';
                $this->image_lib->initialize($config);
                $this->image_lib->watermark();
            }
        }
    }
    public function upload_file($id)
    {
        $path = get_upload_path_by_type('project_bds');
        if (isset($_FILES['file']['name'])) {
            // Get the temp file path
            $tmpFilePath = $_FILES['file']['tmp_name'];
            // Make sure we have a filepath
            if (!empty($tmpFilePath) && $tmpFilePath != '') {
                // Setup our new file path
                if (!file_exists($path)) {
                    mkdir($path);
                    fopen($path . 'index.html', 'w');
                }
                $filename = unique_filename($path, $_FILES['file']['name']);
                $newFilePath = $path . $filename;
                // Upload the file into the temp dir
                if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                    $attachment = array();
                    $attachment[] = array(
                        'file_name' => $filename,
                        'filetype' => $_FILES["file"]["type"],
                    );

                }
//                echo $filename;
                if ($filename) {
                    $data['type'] = 1;
                    $data['id_project'] = $id;
                    $data['file'] = $filename;
                    $success = $this->newview_model->insertfile($data);
                    $this->active_log_bds($id, 'Upload file ' . $filename . ' bởi[' . get_staff_user_id() . ': ' . get_staff_full_name(get_staff_user_id()) . ']');
                    $this->update_date($data['id_project']);
                }
                echo json_encode(array('filename' => $filename, 'file_id' => $success));

            }
        }
    }
    public function upload_file_logo()
    {
        $path = './uploads/watermark/';
        if (isset($_FILES['file']['name'])) {
            // Get the temp file path
            $tmpFilePath = $_FILES['file']['tmp_name'];
            // Make sure we have a filepath
            if (!empty($tmpFilePath) && $tmpFilePath != '') {
                // Setup our new file path
                if (!file_exists($path)) {
                    mkdir($path);
                    fopen($path . 'index.html', 'w');
                }
                $filename = unique_filename($path, $_FILES['file']['name']);
                $newFilePath = $path . $filename;
                // Upload the file into the temp dir
                if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                    $attachment = array();
                    $attachment[] = array(
                        'file_name' => $filename,
                        'filetype' => $_FILES["file"]["type"],
                    );

                }
                echo json_encode(array('filename' => $filename));


            }
        }
    }

    public function setting_images($type)
    {
        if($type==0){
            $text=$this->input->post('text');
            $color=$this->input->post('color');
            $vitri=$this->input->post('vitri');
            $canhvitri=$this->input->post('canhvitri');
            $fontsize=$this->input->post('fontsize');
            $array=array('text'=>$text,'color'=>$color,'vitri'=>$vitri,'canhvitri'=>$canhvitri,'fontsize'=>$fontsize);
            $data=json_encode($array);
            $this->db->where('name','setting_watermark_text');
            $this->db->update('tbloptions',array('value'=>$data));
            if ($this->db->affected_rows() > 0) {
                echo json_encode(array('success' => true, 'message' => 'cập nhật thành công'));
            }
        }
        else
        {
            $height=$this->input->post('height');
            $width=$this->input->post('width');
            $vitri=$this->input->post('vitri');
            $canhvitri=$this->input->post('canhvitri');
            $opacity=$this->input->post('opacity');
            $logo=$this->input->post('img_logo');
            $array=array('height'=>$height,'width'=>$width,'vitri'=>$vitri,'canhvitri'=>$canhvitri,'opacity'=>$opacity,'img_logo'=>$logo);
            $data=json_encode($array);
            $this->db->where('name','setting_watermark_images');
            $this->db->update('tbloptions',array('value'=>$data));
            if ($this->db->affected_rows() > 0) {
                echo json_encode(array('success' => true, 'message' => 'cập nhật thành công'));
            }
        }
    }

    public function upload_file_master($id)
    {
        $path = get_upload_path_by_type('project_bds');
        if (isset($_FILES['file']['name'])) {
            $tmpFilePath = $_FILES['file']['tmp_name'];
            if (!empty($tmpFilePath) && $tmpFilePath != '') {
                if (!file_exists($path)) {
                    mkdir($path);
                    fopen($path . 'index.html', 'w');
                }
                $filename = unique_filename($path, $_FILES['file']['name']);
                $newFilePath = $path . $filename;
                if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                    $attachment = array();
                    $attachment[] = array(
                        'file_name' => $filename,
                        'filetype' => $_FILES["file"]["type"],
                    );

                }
                echo $filename;

            }
        }
    }

    public function delete_file($id)
    {
        $this->db->where('id', $id);
        $data = $this->db->get('tblfile_bds')->row();

        $this->db->where('id', $id);
        $this->db->delete('tblfile_bds');
        if ($this->db->affected_rows() > 0) {
            $this->update_date($data->id_project);
            logActivity('Deleted images [ID: ' . $id . ']');
            $this->active_log_bds($data->id_project, 'Xóa file [' . $id . '] bởi[' . get_staff_user_id() . ': ' . get_staff_full_name(get_staff_user_id()) . ']');
            echo json_encode(array('success' => true, 'message' => 'xóa hình ảnh thành công'));
        }
    }

    public function delete_check_file($id_project)
    {
        $allfile=$this->input->post('file_delete');
        $array_file=explode(',',$allfile);
        foreach($array_file as $file)
        {
            $this->db->where('file', $file);
            $this->db->delete('tblfile_bds');

        }
        if ($this->db->affected_rows() > 0) {
            $this->update_date($id_project);
            logActivity('Deleted images '.$allfile.' to '.$id_project);
            $this->active_log_bds($id_project, 'Xóa nhiều file [' . $allfile . '] bởi[' . get_staff_user_id() . ': ' . get_staff_full_name(get_staff_user_id()) . ']');
            echo json_encode(array('success' => true, 'message' => 'xóa hình ảnh thành công'));
        }

    }

    public function upload_video($id)
    {
        if ($this->input->post()) {
            $data = $this->input->post();
            $data['type'] = 0;
            $data['id_project'] = $id;
            $data['file'] = html_entity_decode($data['file']);
            $success = $this->newview_model->insertfile($data);
            if ($success) {
                echo json_encode(array('file' => $data['file'], 'id' => $success, 'name' => $data['name'], 'success' => true, 'message' => 'Thêm video thành công'));
                $this->active_log_bds($id, 'Thêm video mới ' . $success . ' bởi[' . get_staff_user_id() . ': ' . get_staff_full_name(get_staff_user_id()) . ']');
                $this->update_date($data['id_project']);
            } else {
                echo json_encode(array('success' => true, 'message' => $success));
            }

        }
    }

    public function delete_file_master(){
        $val=$this->input->post('val');
        $allval=$this->input->post('allval');
        $reval=str_replace($val,'',$allval);
        $reval=str_replace(',,',',',$reval);
        $reva=trim($reval,',');
        echo $reva;

    }
    public function setcokki($id)
    {

        $where=array();
        $where_field=array();
        $_where=array();
        $pricestart=$this->input->post('pricestart');
        $priceend=$this->input->post('priceend');

        if($pricestart&&$priceend){
            $where[]='price BETWEEN "'.$pricestart .'" and "'.$priceend.'"';
            $_where['pricestart']=$pricestart;
            $_where['priceend']=$priceend;
        }

        $hhdstart=$this->input->post('hhdstart');
        $hhdend=$this->input->post('hhdend');
        if($hhdstart&&$hhdend)
        {
            $where[]='expires BETWEEN "'.$hhdstart .'" and "'.$hhdend.'"';
            $_where['hhdstart']=$hhdstart;
            $_where['hhdend']=$hhdend;
        }

        $pnstart=$this->input->post('pnstart');
        $pnend=$this->input->post('pnend');
        if($pnstart&&$pnend)
        {
            $where[] = 'type_pn BETWEEN "' . $pnstart . '" and "' . $pnend.'"';
            $_where['pnstart']=$pnstart;
            $_where['pnend']=$pnend;
        }

        $laustart=$this->input->post('laustart');
        $lauend=$this->input->post('lauend');
        if($laustart&&$lauend)
        {
            $where_field[]='field_id=3  and  CAST(value  AS INT) BETWEEN '.$laustart .' and '.$lauend;
            $_where['lauend']=$lauend;
            $_where['laustart']=$laustart;
        }

        $canstart=$this->input->post('canstart');
        $canend=$this->input->post('canend');
        if($canstart&&$canend) {
            $where_field[] = 'field_id=4  and  CAST(value  AS INT) BETWEEN ' . $canstart . ' and ' . $canend;
            $_where['canend']=$canend;
            $_where['canstart']=$canstart;
        }

        $convenientstart=$this->input->post('convenientstart');
        $convenientend=$this->input->post('convenientend');
        if($convenientstart&&$convenientend)
        {
            $where[]='convenient BETWEEN "'.$convenientstart .'" and "'.$convenientend.'"';
            $_where['convenientstart']=$convenientstart;
            $_where['convenientend']=$convenientend;
        }

        $furniture_fill=$this->input->post('furniture_fill');
        if($furniture_fill)
        {
            $where['furniture']=json_encode($furniture_fill);
            $_where['furniture_fill']=json_encode($furniture_fill);
        }

        $district_fill=$this->input->post('district_fill');
        if($district_fill){
            $where['district']=json_encode($district_fill);
            $_where['district_fill']=json_encode($district_fill);
        }
        delete_cookie('where_'.$id);
        delete_cookie('where_field_'.$id);
        if($where!=array())
        {
            set_cookie(array(
                'name' => 'where_'.$id,
                'value' => json_encode($where),
                'expire' => 60 * 60 * 24 * 31 * 2
            ));
        }
        if($_where!=array())
        {
            set_cookie(array(
                'name' => '_where_'.$id,
                'value' => json_encode($_where),
                'expire' => 60 * 60 * 24 * 31 * 2
            ));
        }
        if($where_field!=array())
        {
            set_cookie(array(
                'name' => 'where_field_'.$id,
                'value' => json_encode($where_field),
                'expire' => 60 * 60 * 24 * 31 * 2
            ));
        }
    }
    public function indexproject($id="")
    {
        $id_project=$this->input->get('project');
        $data['menu']         = $this->newview_model->getmenu($id);
        if($id_project!="")
        {
            $data['id_project']=$id_project;
        }
        else
        {
            $data['id_project']=false;
        }

        $data['price']         = $this->newview_model->getprice();
        $data['status']         = $this->newview_model->getstatus();
        $data['exigency']         = $this->newview_model->get_exigency_menu($id,$data['menu']->menu_chil);
        $data['id']=$id;
        $data['status_project']=$this->newview_model->get_status_project($id,$id_project);
        $data['title']=$data['menu']->menu_name;
        $data['province_name']=$this->newview_model->get_data_join('tblprojectmenu','province','province.provinceid=tblprojectmenu.province and id_menu="'.$id.'"','DISTINCT(province.provinceid), province.*');
        
        $data['district_name']=$this->newview_model->get_data_join('tblprojectmenu','district','district.districtid=tblprojectmenu.district and id_menu="'.$id.'"','DISTINCT(district.districtid),district.*');
        $data['door_direction_name']=$this->newview_model->get_data_join('tblprojectmenu','tbldoor_direction','tbldoor_direction.id=tblprojectmenu.door_direction and tbldoor_direction.type=0 and id_menu='.$id,'DISTINCT(tbldoor_direction.id),tbldoor_direction.*');
        $data['furniture']=$this->newview_model->get_data_join('tblprojectmenu','tbldoor_direction','tbldoor_direction.id=tblprojectmenu.furniture and tbldoor_direction.type=1 and id_menu='.$id,'DISTINCT(tbldoor_direction.id), tbldoor_direction.*');
        $data['type_bonus']=array(array('id'=>'1','name'=>'Hưởng %'),array('id'=>'2','name'=>'Tiền'));
        $data['province']=$this->newview_model->get_table('province');
        $data['district']=$this->newview_model->get_table('district');
        $data['door_direction']=$this->newview_model->get_table_where('tbldoor_direction','type=0');
        $data['furniture']=$this->newview_model->get_table_where('tbldoor_direction','type=1');
        $data['status']=$this->newview_model->get_table('tblstatusbds');

        $data['render_colum']=$this->newview_model->get_colum($id);
        $data['order_colum']=$this->newview_model->get_order_colum($id);
        $data['lightbox_assets'] = true;

        $this->load->view('admin/newview/project_view',$data);

    }

    public function save_input()
    {
        $name=$this->input->post('name');
        $value=$this->input->post('value');
        $menu_id=$this->input->post('menu_id');
        $array=array($name=>$value);
        if($_COOKIE[$menu_id])
        {
           $data_array= array_merge((array)json_decode($_COOKIE[$menu_id]),$array);

        }
        else
        {
            $data_array=$array;
        }
        delete_cookie($menu_id);
        set_cookie(array(
            'name' => $menu_id,
            'value' => json_encode($data_array),
            'expire' => 60 * 60 * 24 * 31 * 2
        ));
    }
    public function delete_input()
    {
        $menu_id=$this->input->post('menu_id');
        delete_cookie($menu_id);
    }
    public function delete_fill()
    {
        $menu_id=$this->input->post('menu_id');
        delete_cookie('where_'.$menu_id);
        delete_cookie('_where_'.$menu_id);
        delete_cookie('where_field_'.$menu_id);
    }

    public function getdata_master()
    {
        $phone= $this->input->post('numphone');
        $type= $this->input->post('type_master');
        $result=array();
        if($phone!="")
        {
            $result=$this->newview_model->getdata_master($phone,$type);
        }
        echo json_encode($result);
    }
    public function getdata_master_tax()
    {
        $tax= $this->input->post('tax');
        $result=array();
        if($tax!="")
        {
            $result=$this->newview_model->getdata_master_tax($tax);
        }
        echo json_encode($result);
    }
    public function get_data_master()
    {
        $id= $this->input->post('id');
        if($id!="")
        {
            $result=$this->newview_model->get_table_where_id('tblmaster_bds','id='.$id);
        }
        echo json_encode($result);
    }


    public function deleteproject($id)

    {



        if (!$id) 

        {

            redirect(admin_url('newview/indexproject'));

        }

         

        $response = $this->projectmenu_model->delete($id);

       

        if (is_array($response) && isset($response['referenced'])) {

            set_alert('warning', _l('is_referenced', _l('tax_lowercase')));

        } else if ($response == true) {

            set_alert('success', _l('deleted', 'Dự án'));

        } else {

            set_alert('warning', _l('problem_deleting', _l('tax_lowercase')));

        }

       

        redirect(admin_url('newview/indexproject/'.$response->project));

    }




    public function import()

    {

        $simulate_data  = array();

        $total_imported = 0;

        if ($this->input->post()) {

            if (isset($_FILES['file_csv']['name']) && $_FILES['file_csv']['name'] != '') {

                // Get the temp file path

                $tmpFilePath = $_FILES['file_csv']['tmp_name'];

                // Make sure we have a filepath

                if (!empty($tmpFilePath) && $tmpFilePath != '') {

                    // Setup our new file path

                    $newFilePath = TEMP_FOLDER . $_FILES['file_csv']['name'];

                    if (!file_exists(TEMP_FOLDER)) {

                        mkdir(TEMP_FOLDER, 777);

                    }

                    if (move_uploaded_file($tmpFilePath, $newFilePath)) {

                        $import_result = true;

                        $fd            = fopen($newFilePath, 'r');

                        $rows          = array();

                        while ($row = fgetcsv($fd)) {

                            $rows[] = $row;

                        }

                        fclose($fd);

                        $data['total_rows_post'] = count($rows);

                        if (count($rows) <= 1) {

                            set_alert('warning', 'Not enought rows for importing');

                            redirect(admin_url('newview/import'));

                        }



                        unset($rows[0]);

                        if ($this->input->post('simulate')) {

                            if (count($rows) > 500) {

                                set_alert('warning', 'Recommended splitting the CSV file into smaller files. Our recomendation is 500 row, your CSV file has ' . count($rows));

                            }

                        }

                        $db_temp_fields = $this->db->list_fields('tblprojectmenu');

                        $db_fields      = array();

                        foreach ($db_temp_fields as $field) {

                            if (in_array($field, $this->not_importable_leads_fields)) {

                                continue;

                            }

                            $db_fields[] = $field;

                        }

                        $custom_fields = get_custom_fields('leads');

                        $_row_simulate = 0;

                        foreach ($rows as $row) {

                            // do for db fields

                            $insert = array();

                            for ($i = 0; $i < count($db_fields); $i++) {

                                // Avoid errors on nema field. is required in database

                                if ($db_fields[$i] == 'name' && $row[$i] == '') {

                                    $row[$i] = '/';

                                } else if ($db_fields[$i] == 'country') {

                                    if ($row[$i] != '') {

                                        $this->db->where('iso2', $row[$i]);

                                        $this->db->or_where('short_name', $row[$i]);

                                        $this->db->or_where('long_name', $row[$i]);

                                        $country = $this->db->get('tblcountries')->row();

                                        if ($country) {

                                            $row[$i] = $country->country_id;

                                        } else {

                                            $row[$i] = 0;

                                        }

                                    } else {

                                        $row[$i] = 0;

                                    }

                                }

                                $insert[$db_fields[$i]] = $row[$i];

                            }

                            if (count($insert) > 0) {

                                $total_imported++;

                                $insert['dateadded']   = date('Y-m-d H:i:s');

                                $insert['addedfrom']   = get_staff_user_id();

                                $insert['lastcontact'] = NULL;

                                $insert['status']      = $this->input->post('status');

                                $insert['source']      = $this->input->post('source');

                                if ($this->input->post('responsible')) {

                                    $insert['assigned'] = $this->input->post('responsible');

                                }

                                if (!$this->input->post('simulate')) {

                                    $this->db->insert('tblprojectmenu', $insert);

                                    $leadid = $this->db->insert_id();

                                } else {

                                    if ($insert['country'] != 0) {

                                        $insert['country'] = get_country_short_name($insert['country']);

                                    }

                                    $simulate_data[$_row_simulate] = $insert;

                                    $leadid                        = true;

                                }

                                if ($leadid) {

                                    $insert = array();

                                    foreach ($custom_fields as $field) {

                                        if (!$this->input->post('simulate')) {

                                            if ($row[$i] != '') {

                                                $this->db->insert('tblcustomfieldsvalues', array(

                                                    'relid' => $leadid,

                                                    'fieldid' => $field['id'],

                                                    'value' => $row[$i],

                                                    'fieldto' => 'leads'

                                                ));

                                            }

                                        } else {

                                            $simulate_data[$_row_simulate][$field['name']] = $row[$i];

                                        }

                                        $i++;

                                    }

                                }

                            }

                            $_row_simulate++;

                            if ($this->input->post('simulate') && $_row_simulate >= 100) {

                                break;

                            }

                        }

                        unlink($newFilePath);

                    }

                } else {

                    set_alert('warning', _l('import_upload_failed'));

                }

            }

        }

        $data['statuses'] = $this->leads_model->get_status();

        $data['sources']  = $this->leads_model->get_source();



        $data['members'] = $this->staff_model->get('', 1);

        if (count($simulate_data) > 0) {

            $data['simulate'] = $simulate_data;

        }

        if (isset($import_result)) {

            set_alert('success', _l('import_total_imported', $total_imported));

        }



        $data['not_importable'] = $this->not_importable_leads_fields;

        $data['title']          = 'Import';

        $this->load->view('admin/newview/import', $data);

    }























    /* Edit client or add new client*/

    public function client($id = '')

    {

        if (!has_permission('customers', '', 'view')) {

            if ($id != '' && !is_customer_admin($id)) {

                access_denied('customers');

            }

        }

        if ($this->input->post() && !$this->input->is_ajax_request()) {

            if ($id == '') {

                if (!has_permission('customers', '', 'create')) {

                    access_denied('customers');

                }

                $data                 = $this->input->post();

                $save_and_add_contact = false;

                if (isset($data['save_and_add_contact'])) {

                    unset($data['save_and_add_contact']);

                    $save_and_add_contact = true;

                }

                $id = $this->clients_model->add($data);

                if (!has_permission('customers', '', 'view')) {

                    $assign['customer_admins']   = array();

                    $assign['customer_admins'][] = get_staff_user_id();

                    $this->clients_model->assign_admins($assign, $id);

                }

                if ($id) {

                    set_alert('success', _l('added_successfuly', _l('client')));

                    if ($save_and_add_contact == false) {

                        redirect(admin_url('clients/client/' . $id));

                    } else {

                        redirect(admin_url('clients/client/' . $id . '?new_contact=true'));

                    }

                }

            } else {

                if (!has_permission('customers', '', 'edit')) {

                    if (!is_customer_admin($id)) {

                        access_denied('customers');

                    }

                }

                $success = $this->clients_model->update($this->input->post(), $id);

                if ($success == true) {

                    set_alert('success', _l('updated_successfuly', _l('client')));

                }

                redirect(admin_url('clients/client/' . $id));

            }

        }

        if ($id == '') {

            $title = _l('add_new', _l('client_lowercase'));

        } else {

            $client = $this->clients_model->get($id);

            if (!$client) {

                blank_page('Client Not Found');

            }



            $data['lightbox_assets'] = true;

            $this->load->model('staff_model');

            $data['staff']           = $this->staff_model->get('', 1);

            $data['customer_admins'] = $this->clients_model->get_admins($id);

            $this->load->model('payment_modes_model');

            $data['payment_modes'] = $this->payment_modes_model->get();



            $data['attachments']   = $this->clients_model->get_all_customer_attachments($id);



            $data['category'] = $this->clients_model->get_categori();

            // var_dump($data['category'] );die;

            $data['client']        = $client;

            $title                 = $client->company;

            // Get all active staff members (used to add reminder)

            $this->load->model('staff_model');

            $data['members'] = $this->staff_model->get('', 1);

            if ($this->input->is_ajax_request()) {

                $this->perfex_base->get_table_data('tickets', array(

                    'userid' => $id

                ));

            }

            $data['customer_groups'] = $this->clients_model->get_customer_groups($id);



            $this->load->model('estimates_model');

            $data['estimate_statuses'] = $this->estimates_model->get_statuses();



            $this->load->model('invoices_model');

            $data['invoice_statuses'] = $this->invoices_model->get_statuses();



            if (!empty($data['client']->company)) {

                // Check if is realy empty client company so we can set this field to empty

                // The query where fetch the client auto populate firstname and lastname if company is empty

                if (is_empty_customer_company($data['client']->userid)) {

                    $data['client']->company = '';

                }

            }

        }

        if (!$this->input->get('group')) {

            $group = 'profile';

        } else {

            $group = $this->input->get('group');

        }

        $data['group']  = $group;

        $data['groups'] = $this->clients_model->get_groups();

        $this->load->model('currencies_model');

        $data['currencies'] = $this->currencies_model->get();

        $data['user_notes'] = $this->misc_model->get_notes($id, 'customer');

        $data['bodyclass'] = 'customer-profile';

        $this->load->model('projects_model');

        $data['project_statuses'] = $this->projects_model->get_project_statuses();

        $data['contacts']         = $this->clients_model->get_contacts($id);

        $data['title'] = $title;

        $this->load->view('admin/clients/client', $data);

    }

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



    public function assign_admins($id)

    {

        if (!has_permission('customers', '', 'create') && !has_permission('customers', '', 'edit')) {

            access_denied('customers');

        }

        $success = $this->clients_model->assign_admins($this->input->post(), $id);

        if ($success == true) {

            set_alert('success', _l('updated_successfuly', _l('client')));

        }



        redirect(admin_url('clients/client/' . $id . '?tab=customer_admins'));



    }



    public function delete_customer_admin($customer_id,$staff_id){



        if (!has_permission('customers', '', 'create') && !has_permission('customers', '', 'edit')) {

            access_denied('customers');

        }



        $this->db->where('customer_id',$customer_id);

        $this->db->where('staff_id',$staff_id);

        $this->db->delete('tblcustomeradmins');

        redirect(admin_url('clients/client/'.$customer_id).'?tab=customer_admins');

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

    public function upload_attachment($id)

    {



       if($_POST['one'] ==0)

       {

         set_alert('danger', 'Vui lòng chọn danh mục trước khi upload');             

       }

       else

       {

           handle_client_attachments_upload($id);

        }    

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

    /* Delete client */

    // public function delete($id)

    // {

    //     if (!has_permission('customers', '', 'delete')) {

    //         access_denied('customers');

    //     }

    //     if (!$id) {

    //         redirect(admin_url('clients'));

    //     }

    //     $response = $this->clients_model->delete($id);

    //     if (is_array($response) && isset($response['referenced'])) {

    //         set_alert('warning', _l('client_delete_invoices_warning'));

    //     } else if ($response == true) {

    //         set_alert('success', _l('deleted', _l('client')));

    //     } else {

    //         set_alert('warning', _l('problem_deleting', _l('client_lowercase')));

    //     }

    //     redirect(admin_url('clients'));

    // }

    /* Staff can login as client */

    public function login_as_client($id)

    {

        if (is_admin()) {

            $this->clients_model->login_as_client($id);

        }

        do_action('after_contact_login');

        redirect(site_url());

    }

    public function get_customer_billing_and_shipping_details($id)

    {

        echo json_encode($this->clients_model->get_customer_billing_and_shipping_details($id));



    }

    /* Change client status / active / inactive */

    public function change_contact_status($id, $status)

    {

        if (has_permission('customers', '', 'edit')) {

            if ($this->input->is_ajax_request()) {

                $this->clients_model->change_contact_status($id, $status);

            }

        }

    }

    /* Change client status / active / inactive */

    public function change_client_status($id, $status)

    {



        if ($this->input->is_ajax_request()) {

            $this->clients_model->change_client_status($id, $status);

        }



    }

    /* Since version 1.0.2 zip client invoices */

    public function zip_invoices($id)

    {

        $has_permission_view = has_permission('invoices', '', 'view');

        if (!$has_permission_view && !has_permission('invoices', '', 'view_own')) {

            access_denied('Zip Customer Invoices');

        }

        if ($this->input->post()) {

            $status        = $this->input->post('invoice_zip_status');

            $zip_file_name = $this->input->post('file_name');

            if ($this->input->post('zip-to') && $this->input->post('zip-from')) {

                $from_date = to_sql_date($this->input->post('zip-from'));

                $to_date   = to_sql_date($this->input->post('zip-to'));

                if ($from_date == $to_date) {

                    $this->db->where('date', $from_date);

                } else {

                    $this->db->where('date BETWEEN "' . $from_date . '" AND "' . $to_date . '"');

                }

            }

            $this->db->select('id');

            $this->db->from('tblinvoices');

            if ($status != 'all') {

                $this->db->where('status', $status);

            }

            $this->db->where('clientid', $id);

            $this->db->order_by('number,YEAR(date)', 'desc');



            if (!$has_permission_view) {

                $this->db->where('addedfrom', get_staff_user_id());

            }



            $invoices = $this->db->get()->result_array();

            $this->load->model('invoices_model');

            $this->load->helper('file');

            if (!is_really_writable(TEMP_FOLDER)) {

                show_error('/temp folder is not writable. You need to change the permissions to 755');

            }

            $dir = TEMP_FOLDER . $zip_file_name;

            if (is_dir($dir)) {

                delete_dir($dir);

            }

            if (count($invoices) == 0) {

                set_alert('warning', _l('client_zip_no_data_found', _l('invoices')));

                redirect(admin_url('clients/client/' . $id . '?group=invoices'));

            }

            mkdir($dir, 0777);

            foreach ($invoices as $invoice) {

                $invoice_data    = $this->invoices_model->get($invoice['id']);

                $this->pdf_zip   = invoice_pdf($invoice_data);

                $_temp_file_name = slug_it(format_invoice_number($invoice_data->id));

                $file_name       = $dir . '/' . strtoupper($_temp_file_name);

                $this->pdf_zip->Output($file_name . '.pdf', 'F');

            }

            $this->load->library('zip');

            // Read the invoices

            $this->zip->read_dir($dir, false);

            // Delete the temp directory for the client

            delete_dir($dir);

            $this->zip->download(slug_it(get_option('companyname')) . '-invoices-' . $zip_file_name . '.zip');

            $this->zip->clear_data();

        }

    }

    /* Since version 1.0.2 zip client invoices */

    public function zip_estimates($id)

    {

        $has_permission_view = has_permission('estimates', '', 'view');

        if (!$has_permission_view && !has_permission('estimates', '', 'view_own')) {

            access_denied('Zip Customer Estimates');

        }





        if ($this->input->post()) {

            $status        = $this->input->post('estimate_zip_status');

            $zip_file_name = $this->input->post('file_name');

            if ($this->input->post('zip-to') && $this->input->post('zip-from')) {

                $from_date = to_sql_date($this->input->post('zip-from'));

                $to_date   = to_sql_date($this->input->post('zip-to'));

                if ($from_date == $to_date) {

                    $this->db->where('date', $from_date);

                } else {

                    $this->db->where('date BETWEEN "' . $from_date . '" AND "' . $to_date . '"');

                }

            }

            $this->db->select('id');

            $this->db->from('tblestimates');

            if ($status != 'all') {

                $this->db->where('status', $status);

            }

            if (!$has_permission_view) {

                $this->db->where('addedfrom', get_staff_user_id());

            }

            $this->db->where('clientid', $id);

            $this->db->order_by('number,YEAR(date)', 'desc');

            $estimates = $this->db->get()->result_array();

            $this->load->helper('file');

            if (!is_really_writable(TEMP_FOLDER)) {

                show_error('/temp folder is not writable. You need to change the permissions to 777');

            }

            $this->load->model('estimates_model');

            $dir = TEMP_FOLDER . $zip_file_name;

            if (is_dir($dir)) {

                delete_dir($dir);

            }

            if (count($estimates) == 0) {

                set_alert('warning', _l('client_zip_no_data_found', _l('estimates')));

                redirect(admin_url('clients/client/' . $id . '?group=estimates'));

            }

            mkdir($dir, 0777);

            foreach ($estimates as $estimate) {

                $estimate_data   = $this->estimates_model->get($estimate['id']);

                $this->pdf_zip   = estimate_pdf($estimate_data);

                $_temp_file_name = slug_it(format_estimate_number($estimate_data->id));

                $file_name       = $dir . '/' . strtoupper($_temp_file_name);

                $this->pdf_zip->Output($file_name . '.pdf', 'F');

            }

            $this->load->library('zip');

            // Read the invoices

            $this->zip->read_dir($dir, false);

            // Delete the temp directory for the client

            delete_dir($dir);

            $this->zip->download(slug_it(get_option('companyname')) . '-estimates-' . $zip_file_name . '.zip');

            $this->zip->clear_data();

        }

    }

    public function zip_payments($id)

    {

        if (!$id) {

            die('No user id');

        }



        $has_permission_view = has_permission('payments', '', 'view');

        if (!$has_permission_view && !has_permission('invoices', '', 'view_own')) {

            access_denied('Zip Customer Payments');

        }



        if ($this->input->post('zip-to') && $this->input->post('zip-from')) {

            $from_date = to_sql_date($this->input->post('zip-from'));

            $to_date   = to_sql_date($this->input->post('zip-to'));

            if ($from_date == $to_date) {

                $this->db->where('tblinvoicepaymentrecords.date', $from_date);

            } else {

                $this->db->where('tblinvoicepaymentrecords.date BETWEEN "' . $from_date . '" AND "' . $to_date . '"');

            }

        }

        $this->db->select('tblinvoicepaymentrecords.id as paymentid');

        $this->db->from('tblinvoicepaymentrecords');

        $this->db->where('tblclients.userid', $id);

        if (!$has_permission_view) {

            $this->db->where('invoiceid IN (SELECT id FROM tblinvoices WHERE addedfrom=' . get_staff_user_id() . ')');

        }

        $this->db->join('tblinvoices', 'tblinvoices.id = tblinvoicepaymentrecords.invoiceid', 'left');

        $this->db->join('tblclients', 'tblclients.userid = tblinvoices.clientid', 'left');

        if ($this->input->post('paymentmode')) {

            $this->db->where('paymentmode', $this->input->post('paymentmode'));

        }

        $payments      = $this->db->get()->result_array();

        $zip_file_name = $this->input->post('file_name');

        $this->load->helper('file');

        if (!is_really_writable(TEMP_FOLDER)) {

            show_error('/temp folder is not writable. You need to change the permissions to 777');

        }

        $dir = TEMP_FOLDER . $zip_file_name;

        if (is_dir($dir)) {

            delete_dir($dir);

        }

        if (count($payments) == 0) {

            set_alert('warning', _l('client_zip_no_data_found', _l('payments')));

            redirect(admin_url('clients/client/' . $id . '?group=payments'));

        }

        mkdir($dir, 0777);

        $this->load->model('payments_model');

        $this->load->model('invoices_model');

        foreach ($payments as $payment) {

            $payment_data               = $this->payments_model->get($payment['paymentid']);

            $payment_data->invoice_data = $this->invoices_model->get($payment_data->invoiceid);

            $this->pdf_zip              = payment_pdf($payment_data);

            $file_name                  = $dir;

            $file_name .= '/' . strtoupper(_l('payment'));

            $file_name .= '-' . strtoupper($payment_data->paymentid) . '.pdf';

            $this->pdf_zip->Output($file_name, 'F');

        }

        $this->load->library('zip');

        // Read the invoices

        $this->zip->read_dir($dir, false);

        // Delete the temp directory for the client

        delete_dir($dir);

        $this->zip->download(slug_it(get_option('companyname')) . '-payments-' . $zip_file_name . '.zip');

        $this->zip->clear_data();

    }

    public function groups()

    {

        if (!is_admin()) {

            access_denied('Customer Groups');

        }

        if ($this->input->is_ajax_request()) {

            $this->perfex_base->get_table_data('customers_groups');

        }

        $data['title'] = _l('customer_groups');

        $this->load->view('admin/clients/groups_manage', $data);

    }

    public function group()

    {

        if ($this->input->is_ajax_request()) {

            $data = $this->input->post();

            if ($data['id'] == '') {

                $success = $this->clients_model->add_group($data);

                $message = '';

                if ($success == true) {

                    $message = _l('added_successfuly', _l('customer_group'));

                }

                echo json_encode(array(

                    'success' => $success,

                    'message' => $message

                ));

            } else {

                $success = $this->clients_model->edit_group($data);

                $message = '';

                if ($success == true) {

                    $message = _l('updated_successfuly', _l('customer_group'));

                }

                echo json_encode(array(

                    'success' => $success,

                    'message' => $message

                ));

            }

        }

    }

    public function delete_group($id)

    {

        if (!is_admin()) {

            access_denied('Delete Customer Group');

        }

        if (!$id) {

            redirect(admin_url('clients/groups'));

        }

        $response = $this->clients_model->delete_group($id);

        if ($response == true) {

            set_alert('success', _l('deleted', _l('customer_group')));

        } else {

            set_alert('warning', _l('problem_deleting', _l('customer_group_lowercase')));

        }

        redirect(admin_url('clients/groups'));

    }



    public function bulk_action()

    {

        do_action('before_do_bulk_action_for_customers');

        $total_deleted = 0;

        if ($this->input->post()) {

            $ids    = $this->input->post('ids');

            $groups = $this->input->post('groups');



            if (is_array($ids)) {

                foreach ($ids as $id) {

                    if ($this->input->post('mass_delete')) {

                        if ($this->clients_model->delete($id)) {

                            $total_deleted++;

                        }

                    } else {



                        if (!is_array($groups)) {

                            $groups = false;

                        }

                        $this->clients_model->handle_update_groups($id, $groups);

                    }

                }

            }

        }



        if ($this->input->post('mass_delete')) {

            set_alert('success', _l('total_clients_deleted', $total_deleted));

        }

    }


}

