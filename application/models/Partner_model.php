<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Partner_model extends CRM_Model
{
    function __construct()
    {
        parent::__construct();
    }
    public function add($data)
    {
        $tags=$data['tag_partner'];
        unset($data['tag_partner']);
        $this->db->insert('tblpartner',$data);

        $id= $this->db->insert_id();
        if($id)
        {
            if($tags){
                handle_tags_partner_save($tags,$id);
            }
            logActivity('Thêm đối tác ['.$id.'] bởi '.get_staff_user_id().'['.get_staff_full_name(get_staff_user_id()).']');
            return $id;
        }
    }
    public function update($id,$data)
    {
        $tags=$data['tag_partner'];
        unset($data['tag_partner']);
        $this->db->where('id_partner',$id);
        $this->db->update('tblpartner',$data);
        if($tags){
            handle_tags_partner_save($tags,$id);
        }
        if ($this->db->affected_rows() > 0) {
            logActivity('Cập nhật đối tác ['.$id.'] bởi '.get_staff_user_id().'['.get_staff_full_name(get_staff_user_id()).']');
            return true;
        }
    }
    public function get_partner($id)
    {
        $this->db->where('id_partner',$id);
        return $this->db->get('tblpartner')->row();
    }
    public function _delete($id)
    {
        $data=array('_delete'=>1,'date_delete'=>date('Y-m-d H:i:s'));
        $this->db->where('id_partner',$id);
        $this->db->update('tblpartner',$data);
        if ($this->db->affected_rows() > 0) {
            logActivity('Xóa đối tác ['.$id.'] bởi '.get_staff_user_id().'['.get_staff_full_name(get_staff_user_id()).']');
            return true;
        }
    }
}