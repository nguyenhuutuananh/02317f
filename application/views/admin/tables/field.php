<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$aColumns     = array(
    'id',
    'name',
    'type',
    'id_field'
    );
$sIndexColumn = "id";
$sTable       = 'tbfield_bds';

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = array();
    for ($i = 0; $i < count($aColumns); $i++) {
        $_data = $aRow[$aColumns[$i]];
        if ($aColumns[$i] == 'name' || $aColumns[$i] == 'id') {
            $_data = '<a onclick="get_view_file('.$aRow['id'].')" data-toggle="modal" data-target="#view_add">'.$_data.'</a>';
        }
        $row[] = $_data;
    }

    $options = '<a class="btn btn-default btn-icon" onclick="get_view_file("'.$aColumns[$id].'")" data-toggle="modal" data-target="#view_add"><i class="fa fa-pencil-square-o"></i></a>';
    $row[]   = $options .= icon_btn('custom_fields/delete/' . $aRow['id'], 'remove', 'btn-danger _delete');

    $output['aaData'][] = $row;
}
