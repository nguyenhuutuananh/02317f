<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Client_care_history_model extends CRM_Model
{
    function __construct() {
        parent::__construct();
        // Call new model functions using handle to main CI object
    }
    public function getActivities($idClient) {
        $this->db->where('idClient', $idClient);
        return $this->db->get('tblclient_care_history')->result();
    }
    public function saveActivity($idClient, $data) {
        $data['idClient'] = $idClient;
        if($this->db->insert('tblclient_care_history', $data)) {
            return $this->db->affected_rows() > 0;
        }
        return false;
    }
}