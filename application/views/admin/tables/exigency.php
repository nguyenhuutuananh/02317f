<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$aColumns = array(
'id','name'
    );

$join = array();

$where                    = array();
$filter = array();

$sIndexColumn = "id";
$sTable       = 'tblexigency';
$result       = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, array(
    ));
$output       = $result['output'];
$rResult      = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = array();

    for ($i = 0; $i < count($aColumns); $i++) {
            $_data = $aRow[ $aColumns[$i] ];
         $row[] = $_data;
    }
    $options='<a onclick="view_exigency('.$aRow['id'].')" class="btn btn-default btn-icon"  data-toggle="modal" data-target="#model_exigency"><i class="fa fa-pencil-square-o"></i></a>';
    $options .= '<a href="'.admin_url().'exigency/delete/'.$aRow['id'].'" class="btn btn-danger btn-icon _delete"><i class="fa fa-remove"></i></a>';
    $row[] = $options;
    $output['aaData'][] = $row;
}
