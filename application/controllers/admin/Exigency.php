<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Exigency extends Admin_controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('exigency_model');
    }
    public function index()
    {
        if ($this->input->is_ajax_request()) {
            $this->perfex_base->get_table_data('exigency');
        }
        $data['title']="Nhu cầu";
        $this->load->view('admin/exigency/manage', $data);
    }
        public function exigency($id='')
    {
        if($this->input->post())
        {
            $name=$this->input->post('name');
            if($id!="")
            {
                $this->db->where('id',$id);
                $this->db->update('tblexigency',array('name'=>$name));
                if ($this->db->affected_rows() > 0)
                {
                    set_alert('success', "cập nhật liệu thành công");
                    redirect(admin_url('exigency'));
                }
                else
                {
                    set_alert('danger', "cập nhật dữ liệu không thành công");
                    redirect(admin_url('exigency'));
                }
            }
            else
            {
                $this->db->insert('tblexigency',array('name'=>$name));
                $id=$this->db->insert_id();
                if($id)
                {
                    set_alert('success', "Thêm dữ liệu thành công");
                    redirect(admin_url('exigency'));
                }
                else
                {
                    set_alert('danger', "thêm dữ liệu không thành công");
                    redirect(admin_url('exigency'));
                }
            }
        }
        else
        {
            if($id!="") {
                $result=$this->exigency_model->get_where('tblexigency', 'id=' . $id);
                echo json_encode($result);
            }
            else
            {
                $data['title']="Nhu cầu";
                $this->load->view('admin/exigency/manage', $data);
            }
        }

    }
    public function delete($id)
    {
        $this->db->where('id',$id);
        $result=$this->db->get('tblexigency')->row();
        $this->db->where('id',$id);
        $this->db->delete('tblexigency');
        if ($this->db->affected_rows() > 0) {
            logActivity('Xóa nhu cầu [ID:' . $id . ', Tên: ' . $result->name . ']');
            set_alert('success', "xóa dữ liệu thành công");
            redirect(admin_url('exigency'));
        }
    }
}
