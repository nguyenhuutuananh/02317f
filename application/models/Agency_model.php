<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Agency_model extends CRM_Model
{
    private $contact_data = array('firstname', 'lastname', 'email', 'phonenumber', 'title', 'password', 'send_set_password_email', 'donotsendwelcomeemail', 'permissions', 'direction');
    function __construct()
    {
        parent::__construct();
    }
    public function get($id) {
        if(is_numeric($id)) {
            $this->db->where('id', $id);
            $result = $this->db->get('tblagencies')->row();
            return $result;
        }
        return false;
    }
    public function create($data) {
        $this->db->insert('tblagencies', $data);
        if($this->db->affected_rows() > 0) {
            return true;
        }
        return false;
    }

    public function update($id, $data) {
        if(is_numeric($id)) {
            $this->db->where('id', $id);
            $result_update = $this->db->update('tblagencies', $data);
            if($this->db->affected_rows() > 0) {
                return true;
            }
            // Update but nothing changed
            if($result_update) {
                return true;
            }
        }
        return false;
    }
    public function delete($id) {
        if(is_numeric($id)) {
            $this->db->where('id', $id);
            $this->db->delete('tblagencies');
            if($this->db->affected_rows() > 0) {
                return true;
            }
        }
        return false;
    }
}