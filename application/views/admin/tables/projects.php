<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$aColumns = array(
    'tblprojects.id',
    'code_project',
    'name',
    'id_menu',
    'project_created'
);

$sIndexColumn = "id";
$sTable       = 'tblprojects';

$join             = array(
);

$where  = array(' AND _delete=0');
$filter = array();

$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, $additionalSelect);
$output  = $result['output'];
$rResult = $result['rResult'];
foreach ($rResult as $aRow) {
    $row = array();
    for ($i = 0; $i < count($aColumns); $i++) {
            $_data = $aRow[$aColumns[$i]];
        if ($aColumns[$i] == 'project_created') {
            $_data = _d($_data);
        }
        else if ($aColumns[$i] == 'id_menu') {
            $_data = get_name_menu_project($aRow['id_menu']);
        } else if ($aColumns[$i] == 'name' || $aColumns[$i] == 'tblprojects.id'||$aColumns[$i] == 'code_project') {
            $_data = '<a href="javacript:void(0)" onclick="view_project('.$aRow['tblprojects.id'].')" data-toggle="modal" data-target="#add_project">' . $_data . '</a>';
        }
        $row[] = $_data;
    }
    $options = '';
    $options .= icon_btn('projects/delete/' . $aRow['tblprojects.id'], 'remove', 'btn-danger _delete');
//    }

    $row[]              = $options;
    $output['aaData'][] = $row;
}
