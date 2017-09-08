<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//$fields = get_fields('menu_bds', array(
//    'show_on_table' => 1
//));
$aColumns     = array(
    '1',
    'menu_name'
    );
$sIndexColumn = "id";
$sTable       = 'tblmenubds';


$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, array(), array(), array(
    'id'
    ));
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = array();
    for ($i = 0; $i < count($aColumns); $i++) {
        $_data = $aRow[$aColumns[$i]];
        if($aColumns[$i] == 'menu_name')
        {
            $_data = '<a href="javacript:void(0);" onclick="get_data('.$aRow['id'].')" id="edit_menu" data-toggle="modal" data-target="#view_render" data-id="'.$aRow['id'].'">'.$_data.'</a>';
        }
         if ($aColumns[$i] == '1') 
        {
            $_data = '<div class="checkbox"><input type="checkbox" value="' . $aRow['id'] . '"><label></label></div>';
        }
        $row[] = $_data;
    }
//    foreach($fields as $rom)
//    {
//            $row[]= get_field_value($rom['id'],$aRow['id'],'menu_bds');
//    }

    $options = '<a href="'.admin_url().'newview/setup_table/' . $aRow['id'].'" class="btn btn-default btn-icon"><i class="fa fa-cogs menu-icon"></i></a>';
    $row[]   = $options .= icon_btn('newview/delete/' . $aRow['id'], 'remove', 'btn-danger _delete');

    $output['aaData'][] = $row;
}
