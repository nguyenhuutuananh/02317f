<?php
header('Content-Type: text/html; charset=utf-8');
defined('BASEPATH') OR exit('No direct script access allowed');
class Partner extends Admin_controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('partner_model');
    }
    public function index()
    {
        $type = 0;
        if($this->input->get('type'))
        {
            $type = $this->input->get('type');
        }
        $data['title']    = _l('Danh sách môi giới chuyên dự án');
        if($type==1) {
            $data['title']    = _l('Danh sách môi giới không hợp tác');
        }
        else if($type==3) {
            $data['title']    = _l('Danh sách môi giới giao dịch thành công');
        }
        $data['type'] = $type;
        $this->load->view('admin/partner/managa', $data);
    }
    public function init_relation_partner_project($status="")
    {
        if ($this->input->is_ajax_request()) {
            $this->perfex_base->get_table_data('partner', array(
                'status' => $status,
            ));
        }
    }
    public function import_partner()
    {
        if ($this->input->is_ajax_request()) {
            require_once(APPPATH . 'third_party/Excel_reader/php-excel-reader/excel_reader2.php');
            require_once(APPPATH . 'third_party/Excel_reader/SpreadsheetReader.php');
            if (isset($_FILES["file_csv"])) {
                $filename = uniqid() . '_' . $_FILES["file_csv"]["name"];
                $temp_url = TEMP_FOLDER . $filename;
                if (move_uploaded_file($_FILES["file_csv"]["tmp_name"], $temp_url)) {
                    try {
                        $xls_emails = new SpreadsheetReader($temp_url);
                    }
                    catch (Exception $e) {
                        die('Error loading file "' . pathinfo($temp_url, PATHINFO_BASENAME) . '": ' . $e->getMessage());
                    }
                    $array_colum="";
                    foreach ($xls_emails as $colum=> $value) {
                        foreach($value as $num=> $rom)
                        {
                            $array_colum[$colum][]=$rom;
                        }
                    }

                    $data=array();
                    $array_row=array('name_partner','phone_partner','email_partner','company_partner','date','status');
                    foreach ($xls_emails as $colum=> $value) {
                        foreach ($value as $r=> $lrow) {
                            $data[$array_row[$r]]=$lrow;
                        }
                        if($data['date']!="")
                        {
                            $data['date'] = date("Y-m-d", strtotime($data['date']));
                        }
                        else
                        {
                            $data['date'] = date("Y-m-d");
                        }
                        $data['addedfrom'] = get_staff_user_id();
                        $this->partner_model->add($data) ;
                    }
                    echo json_encode(array('success' => true,'message' => 'thêm dữ liệu thành công'));


                }
                else
                {
                    echo json_encode(array('success' => false,'message' => 'thêm dữ liệu không thành công'));
                }
            }
            else
            {
                echo json_encode(array('success' => false,'message' => 'Không tìm thấy file'));
            }
        }
    }

    public function update()
    {
        if($this->input->post())
        {
            $data=$this->input->post();
            $id=$data['id'];
            if($data['status']==2)
            {
                $data['status']=0;
            }
            unset($data['id']);

            if($id=="")
            {
                $data['date']=date('Y-m-d');
                $data['addedfrom']=get_staff_user_id();
                $success=$this->partner_model->add($data);

                if($success)
                {
                    echo json_encode(array('success' => true,'message' => 'thêm dữ liệu thành công'));
                }
                else
                {
                    echo json_encode(array('success' => false,'message' => 'thêm dữ liệu không thành công'));
                }
            }
            else
            {

                $success=$this->partner_model->update($id,$data);
                if($success)
                {
                    echo json_encode(array('success' => true,'message' => 'cập nhật dữ liệu thành công'));
                }
                else
                {
                    echo json_encode(array('success' => false,'message' => 'cập nhật dữ liệu không thành công'));
                }
            }
        }
    }
    public function get_partner($id)
    {

        if($id!="")
        {
           $result= $this->partner_model->get_partner($id);
            $result->tag=get_tags_partner_in($result->id_partner);
            echo json_encode($result);
        }
    }
    public function delete_partner($id)
    {
        $result=$this->partner_model->_delete($id);
        if($result)
        {
            echo json_encode(array('success' => true,'message' => 'Xóa dữ liệu thành công'));
        }
        else
        {
            echo json_encode(array('success' => false,'message' => 'Xóa không thành công'));
        }
    }
    public function delete_mess_partner()
    {
        $array_id=$this->input->post('array_id');
        $i=0;
        foreach($array_id as $rom)
        {
            $result=$this->partner_model->_delete($rom);
            if($result)
            {
                $i++;
            }
        }
        if($i>0)
        {
            echo json_encode(array('success' => true,'message' => 'Xóa ' .$i.' dữ liệu thành công'));
        }
        else
        {
            echo json_encode(array('success' => false,'message' => 'Không dữ liệu nào được xóa'));
        }
    }



}
