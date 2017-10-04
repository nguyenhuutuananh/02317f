<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$aColumns     = array(
    'tblstafftasks.rel_id',
    'tblstafftasks.name',
    'tblclients.company',
    'tblclients.type_client',
);
$sIndexColumn = "id";
$sTable       = 'tblstafftasks';
$where        = array(
    'AND tblstafftasks.rel_type="customer" and (
        tblstafftasks.id in (select tblstafftaskassignees.taskid  from tblstafftaskassignees  where tblstafftaskassignees.staffid = '.$idStaff.') or 
        tblstafftasks.id in (select tblstafftasksfollowers.taskid from tblstafftasksfollowers where tblstafftasksfollowers.staffid = '.$idStaff.') or 
        tblstafftasks.id in (select tblstafftasksupporters.taskid from tblstafftasksupporters where tblstafftasksupporters.staffid = '.$idStaff.')
        )',
//    'AND id_lead="' . $rel_id . '"'
);
$join         = array(
    'LEFT JOIN tblclients  ON tblclients.userid=tblstafftasks.rel_id'
);
$result       = data_tables_init($aColumns, $sIndexColumn, $sTable,$join, $where, array(
    'tblstafftasks.id',
));
$output       = $result['output'];
$rResult      = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = array();
    for ($i = 0; $i < count($aColumns); $i++) {
        $_data = $aRow[$aColumns[$i]];
        
        if($aColumns[$i] === 'tblclients.type_client') {
            switch($_data) {
                case 1:
                $_data = "Đang chăm sóc";
                    break;
                case 2:
                $_data = "Đã mua hàng";
                    break;
                case 3:
                $_data = "FAIL";
                    break;
            }
        }
        if($aColumns[$i] == 'tblstafftasks.rel_id' || $aColumns[$i] == 'tblclients.company' || $aColumns[$i] == 'tblstafftasks.name') {
            $_data = "<a target='_blank' href='".admin_url('tasks/index/')."$aRow[id]'>{$_data}</a>";
        }
        $row[] = $_data;
    }
    
    if (is_admin()) {
        $_data = '';
        
        $row[] = $_data;

    } else {
        $row[] = '';
    }
    $output['aaData'][] = $row;
}
