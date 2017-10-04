<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$aColumns     = array(
    'tblprojectmenu.project_name',
    'tblprofile_project.date'
);
$sIndexColumn = "id";
$sTable       = 'tblprofile_project';
$where        = array(
    'AND id_staff='. $idStaff,
//    'AND id_lead="' . $rel_id . '"'
);
$join         = array(
    'LEFT JOIN tblprojectmenu  ON tblprojectmenu.id=tblprofile_project.id_project'
);
$result       = data_tables_init($aColumns, $sIndexColumn, $sTable,$join, $where, array(
    'tblprojectmenu.id',
    'tblprojectmenu.id_menu',
));
$output       = $result['output'];
$rResult      = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = array();

    for ($i = 0; $i < count($aColumns); $i++) {
        $_data = $aRow[$aColumns[$i]];
        
        if($aColumns[$i] === 'tblprojectmenu.project_name') {
            $_data = '<a target="_blank" href="'.admin_url('newview/project/'.$aRow['id_menu'].'/'.$aRow['id'].'').'">'.$_data.'</a>';
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
