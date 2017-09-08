<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Field_model extends CRM_Model
{
    function __construct()
    {
        parent::__construct();
    }
    /**
     * With this function staff can login as client in the clients area
     * @param  mixed $id client id
     */
    public function add($data)
    {
        $this->db->insert('tbfield_bds', $data);
        $userid = $this->db->insert_id();
        if ($userid) {
           return $userid;
        }
        return false;
    }
    public function update($id,$data)
    {
        $this->db->where('id',$id);
        $this->db->update('tbfield_bds',$data);

        if ($this->db->affected_rows() > 0) {
            return true;
        }

        return false;
    }
    public function get_data()
    {
        return $this->db->get('tbfield_bds')->result_array();
    }
}
