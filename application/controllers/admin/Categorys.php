<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Categorys extends Admin_controller

{


    function __construct()

    {

        parent::__construct();



        $this->load->helper('form');

        $this->load->helper('url');

        $this->load->library('form_validation');

        $this->load->library('encrypt');

        $this->load->helper('cookie');


        

    }

    /* List all clients */

    public function index()
    {
        $data['title']='Quản lý danh mục';
        $this->load->view('admin/newview/categoty',$data);

    }
    public function init_relation_door_direction($type)
    {
        if ($this->input->is_ajax_request())
        {
            $this->perfex_base->get_table_data('categorys',array('type'=>$type));
        }
    }
    public function init_relation_status()
    {
        if ($this->input->is_ajax_request())
        {
            $this->perfex_base->get_table_data('categorys',array('table'=>'status'));
        }
    }
    public function add_update()
    {
        if($this->input->post()){
            $id=$this->input->post('id');
            $type=$this->input->post('type');
            $name=$this->input->post('name');
            if($id)
            {
                $this->db->where('id',$id);
                $this->db->update('tbldoor_direction',array('name'=>$name));
                if ($this->db->affected_rows() > 0)
                {
                    set_alert('success', 'Cập nhật thành công');
                    redirect(admin_url('categorys'));
                }
            }
            else
            {
                $this->db->insert('tbldoor_direction',array('name'=>$name,'type'=>$type));
                if($this->db->insert_id())
                {
                    set_alert('success', 'Thêm dữ liệu thành công');
                    redirect(admin_url('categorys'));
                }
                else
                {
                    set_alert('danger', 'Thêm dữ liệu không thành công');
                }
            }
        }
    }
    public function add_update_status()
    {
        if($this->input->post()){
            $id=$this->input->post('id');
            $type=$this->input->post('type');
            $name=$this->input->post('name');
            if($id)
            {
                $this->db->where('id',$id);
                $this->db->update('tblstatusbds',array('name'=>$name));
                if ($this->db->affected_rows() > 0)
                {
                    set_alert('success', 'Cập nhật thành công');
                    redirect(admin_url('categorys'));
                }
            }
            else
            {
                $this->db->insert('tblstatusbds',array('name'=>$name));
                if($this->db->insert_id())
                {
                    set_alert('success', 'Thêm dữ liệu thành công');
                    redirect(admin_url('categorys'));
                }
                else
                {
                    set_alert('danger', 'Thêm dữ liệu không thành công');
                }
            }
        }
    }
    public function getdata($id){
        $this->db->where('id',$id);
        echo json_encode($this->db->get('tbldoor_direction')->row());
    }
    public function getdata_status($id){
        $this->db->where('id',$id);
        echo json_encode($this->db->get('tblstatusbds')->row());
    }
    public function delete_mess()
    {

        $array_id=$this->input->post('array_id');
        $table='tbldoor_direction';
        $i=0;
        foreach($array_id as $rom)
        {
            $this->db->where('id',$rom);
            $this->db->delete($table);
            if ($this->db->affected_rows() > 0)
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
    public function delete_mess_status()
    {

        $array_id=$this->input->post('array_id');
        $table='tblstatusbds';
        $i=0;
        foreach($array_id as $rom)
        {
            $this->db->where('id',$rom);
            $this->db->delete($table);
            if ($this->db->affected_rows() > 0)
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

