<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//$fields = get_fields('menu_bds', array(
//    'show_on_table' => 1
//));
if(isset($type)){
    $aColumns     = array(
        '1',
        'name'
        );
    $sIndexColumn = "id";
    $sTable       = 'tbldoor_direction';


    $result  = data_tables_init($aColumns, $sIndexColumn, $sTable, array(), array('AND type='.$type), array(
        'id'
        ));
    $output  = $result['output'];
    $rResult = $result['rResult'];


    foreach ($rResult as $aRow) {
        $row = array();
        for ($i = 0; $i < count($aColumns); $i++) {
            $_data = $aRow[$aColumns[$i]];
            if($aColumns[$i] == 'name')
            {
                $_data = '<a href="javacript:void(0);" onclick="get_data('.$aRow['id'].')" id="edit_menu" data-toggle="modal" data-target="#view_door" data-id="'.$aRow['id'].'">'.$_data.'</a>';
            }
             if ($aColumns[$i] == '1')
            {
                $_data = '<div class="checkbox"><input type="checkbox" value="' . $aRow['id'] . '"><label></label></div>';
            }
            $row[] = $_data;
        }

        $output['aaData'][] = $row;
    }
}
else
{

    $aColumns     = array(
        '1',
        'name'
    );
    $sIndexColumn = "id";
    $sTable       = 'tblstatusbds';


    $result  = data_tables_init($aColumns, $sIndexColumn, $sTable, array(), array(), array(
        'id'
    ));
    $output  = $result['output'];
    $rResult = $result['rResult'];


    foreach ($rResult as $aRow) {
        $row = array();
        for ($i = 0; $i < count($aColumns); $i++) {
            $_data = $aRow[$aColumns[$i]];
            if($aColumns[$i] == 'name')
            {
                $_data = '<a href="javacript:void(0);" onclick="get_data_status('.$aRow['id'].')"  data-toggle="modal" data-target="#view_status" data-id="'.$aRow['id'].'">'.$_data.'</a>';
            }
            if ($aColumns[$i] == '1')
            {
                $_data = '<div class="checkbox"><input type="checkbox" value="' . $aRow['id'] . '"><label></label></div>';
            }
            $row[] = $_data;
        }

        $output['aaData'][] = $row;
    }
}
