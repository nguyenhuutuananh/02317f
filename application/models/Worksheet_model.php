<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Worksheet_model extends CRM_Model
{
    public function createWorksheet($idStaff, $data) {    
        if(is_numeric($idStaff)) {
            $this->db->where('staffid', $idStaff);
            if($this->db->get('tblstaff')->row()) {
                $data['userid'] = $idStaff;
                $data['dateStartWork'] = to_sql_date($data['dateStartWork']);

                $this->db->insert('tblworksheet', $data);
                return $this->db->insert_id();
            }
        }
        return false;
    }
    public function createDayOff($idStaff, $data) {
        if(is_numeric($idStaff)) {
            $this->db->where('staffid', $idStaff);
            if($this->db->get('tblstaff')->row()) {
                $data['userid'] = $idStaff;
                $data['dateWorkOff'] = to_sql_date($data['dateWorkOff']);

                
                $this->db->insert('tblworksheet_dayoff', $data);
                return $this->db->insert_id();
            }
        }
        return false;
    }
    public function getWorksheet($month, $year, $idStaff='') {
        $dayOfWeek = cal_days_in_month(CAL_GREGORIAN, $month, $year); // 31        
        $minDate = "$year-$month-01 00:00:00";
        $maxDate = "$year-$month-$dayOfWeek 23:59:59";

        
        if($idStaff) {
            $this->db->where('staffid', $idStaff);
        }
        $this->db->order_by('firstname', 'desc');
        $result = $this->db->get('tblstaff')->result();
   

        $filterByUser = [];
        foreach($result as $row) {
            
            $this->db->where('dateStartWork >=', $minDate);
            $this->db->where('dateStartWork <=', $maxDate);
            $this->db->join('tblstaff', 'tblstaff.staffid = tblworksheet.userid', 'left');
            $this->db->order_by('dateStartWork', 'ASC');
            $this->db->where('userid', $row->staffid);
            
            $result_work = $this->db->get('tblworksheet')->result();

            if(!isset($filterByUser[$row->staffid])) $filterByUser[$row->staffid] = new stdClass();
            $filterByUser[$row->staffid]->info = $row;
            $filterByUser[$row->staffid]->current = $result_work;

            $this->db->where('dateStartWork <', $minDate);
            $this->db->order_by('dateStartWork', 'DESC');
            $this->db->where('userid', $row->staffid);

            $filterByUser[$row->staffid]->lastMonth = $this->db->get('tblworksheet')->row();
        
            // Dayoff

            $this->db->where('dateWorkOff >=', $minDate);
            $this->db->where('dateWorkOff <=', $maxDate);
            $this->db->where('userid', $row->staffid);
            
            $filterByUser[$row->staffid]->dayOff = $this->db->get('tblworksheet_dayoff')->result();
        }
        return $filterByUser;
    }
}