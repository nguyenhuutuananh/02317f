<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Worksheet_model extends CRM_Model
{
    public function createWorksheet($idStaff, $data) {
        
        if(is_numeric($idStaff)) {
            $this->db->where('staffid', $idStaff);
            if($this->db->get('tblstaff')->row()) {
                $data['userid'] = $idStaff;
                $this->db->insert('tblworksheet', $data);
                return $this->db->insert_id();
            }
        }
        return false;
    }
    public function getWorksheet($month, $year, $idStaff='') {
        $dayOfWeek = cal_days_in_month(CAL_GREGORIAN, $month, $year); // 31        
        $minDate = "$year-$month-01 00:00:00";
        $maxDate = "$year-$month-$dayOfWeek 23:59:59";

        // $this->db->where("dateStartWork BETWEEN $minDate AND $maxDate");
        $this->db->where('dateStartWork >=', $minDate);
        $this->db->where('dateStartWork <=', $maxDate);
        $this->db->join('tblstaff', 'tblstaff.staffid = tblworksheet.userid', 'left');
        $this->db->order_by('dateStartWork', 'ASC');
        if(is_numeric($idStaff)) {
            $this->db->where('userid', $idStaff);
        }
        $result = $this->db->get('tblworksheet')->result();
        
        
        $filterByUser = new stdClass();
        foreach($result as $row) {
            $filterByUser[$row->userid]->current[] = $row;

            $this->db->where('dateStartWork <', $minDate);
            $this->db->order_by('dateStartWork', 'DESC');

            $filterByUser[$row->userid]->lastMonth = $this->db->get('tblworksheet')->row();
        }
        return $filterByUser;
    }
}