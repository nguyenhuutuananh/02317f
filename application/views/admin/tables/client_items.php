<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$aColumns     = array(
    'id',
    '(select tblprojectmenu.project_name from tblprojectmenu where tblprojectmenu.id=tblclient_bds.projectBdsId)',
    'type',
    'price',
    'rentalPeriod',
    'dateStart',
);
$sIndexColumn = "id";
$sTable       = 'tblclient_bds';
$where        = array(
   'AND clientId="' . $clientId . '"'
);
$join         = array(
);
$result       = data_tables_init($aColumns, $sIndexColumn, $sTable,$join, $where, array(
    'tblclient_bds.clientId',
));
$output       = $result['output'];
$rResult      = $result['rResult'];


$j=0;
foreach ($rResult as $aRow) {
    $row = array();
    $j++;
    for ($i = 0; $i < count($aColumns); $i++) {
        $_data = $aRow[$aColumns[$i]];
        
        switch($aColumns[$i]) {
            case 'dateStart':
                $_data = date('Y-m-d', strtotime($aRow['dateStart']));
                break;
            case 'rentalPeriod':
                if(is_numeric($_data))
                    $_data .= ' tháng';
                break;
            case 'type':
                if($_data == 1) {
                    $_data = 'Mua';
                    $aRow['rentalPeriod'] = "Không";
                }
                else {
                    $_data = 'Thuê';
                } 
                break;
            case 'price':
                $_data = number_format($_data); 
                break;
            case '(select tblprojectmenu.project_name from tblprojectmenu where tblprojectmenu.id=tblclient_bds.projectBdsId)':
                $_data = '<a href="#" onclick="view_init_department(' . $aRow['id'] . '); return false;">' . $_data . '</a>'; 
                break;
        }

        $row[] = $_data;
    }
    if (is_admin()) {
        // $_data = '<a href="#" class="btn btn-default btn-icon" onclick="view_init_department(' . $aRow['id'] . '); return false;"><i class="fa fa-pencil"></i> Sửa</a>';

        // $_data.= icon_btn('kind_of_warehouse/delete/'. $aRow['id'] , 'remove', 'btn-danger delete-reminder');
        $_data = "";
        $_data .= icon_btn('#' , 'bars', 'btn-primary btn-billingperiod', array('data-idproduct' => $aRow['id'], 'data-loading-text' => "<i class='fa fa-spinner fa-spin '></i>"));
        $row[] = $_data;
    } else {
        $row[] = '';
    }
    $output['aaData'][] = $row;
}
