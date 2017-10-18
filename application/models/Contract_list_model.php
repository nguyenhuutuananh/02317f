<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Contract_list_model extends CRM_Model
{
    function __construct()
    {
        parent::__construct();
    }
    public function get($id="") {
        // $this->db->where('');
        if(is_numeric($id)) {
            return $this->db->where('id', $id)->get('tblclient_bds')->row();
        }
        else {
            return $this->db->get('tblclient_bds')->result();
        }
    }
}