<?php
defined('BASEPATH') OR exit('No direct script access allowed');
define('EMAIL_TEMPLATE_SEND', true);
class Exigency_model extends CRM_Model
{
    function __construct()
    {
        parent::__construct();
    }

    /**
     * @param  string
     * @return array
     * Get email template by type
     */
    public function get_where($table,$where = "")
    {
        if($where!="") {
            $this->db->where($where);
        }
        return $this->db->get($table)->result_array();
    }
}
