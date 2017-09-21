<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$aColumns     = array(
    'id',
    'datePay',
    'value',
    '(select sum(tblclient_bds_payment_details.realValue) as paid from tblclient_bds_payment_details where tblclient_bds_payment_details.idClientBdsPayment = tblclient_bds_payment.id) as paid',
    'value as value2',
    'status',
);
$sIndexColumn = "id";
$sTable       = 'tblclient_bds_payment';
$where        = array(
   'AND (select tblclient_bds.clientId from tblclient_bds where tblclient_bds_payment.idClientBds = tblclient_bds.id) = ' . $clientId . '',
   'AND idClientBds=' . $idProduct . '',
);
$join         = array(
);

$order_by = 'order by tblclient_bds_payment.datePay asc';
// print_r($where);
// exit();

$result       = data_tables_init($aColumns, $sIndexColumn, $sTable,$join, $where, array(
    'tblclient_bds_payment.id',
), $order_by);
$output       = $result['output'];
$rResult      = $result['rResult'];


$j=0;
$count_period = 0;
foreach ($rResult as $aRow) {
    $count_period++;
    $row = array();
    $j++;
    for ($i = 0; $i < count($aColumns); $i++) {
        $_data = $aRow[$aColumns[$i]];
        
        switch($aColumns[$i]) {
            case 'id':
                $_data = $count_period;
                break;
            case 'datePay':
                $_data = date('Y-m-d', strtotime($_data));
                break;
            case 'status':
                if($_data == 0) {
                    $_data = 'Chưa nhận';
                }
                else if($_data == 1)
                {
                    $_data = 'Đã nhận đủ';
                }
                else {
                    $_data = 'Chưa nhận đủ';
                } 
                break;
            case 'value':
                $_data = number_format($_data); 
                break;
            case '(select sum(tblclient_bds_payment_details.realValue) as paid from tblclient_bds_payment_details where tblclient_bds_payment_details.idClientBdsPayment = tblclient_bds_payment.id) as paid':
                $_data = $aRow['paid'];
                $_data = number_format($_data); 
                break;
            case 'value as value2':
                $_data = $aRow['value']-$aRow['paid'];
                $_data = number_format($_data); 
                break;
        }

        $row[] = $_data;
    }
    if (is_admin()) {
        // $_data = '<a href="#" class="btn btn-default btn-icon" onclick="view_init_department(' . $aRow['id'] . '); return false;"><i class="fa fa-pencil"></i> Sửa</a>';

        // $_data.= icon_btn('kind_of_warehouse/delete/'. $aRow['id'] , 'remove', 'btn-danger delete-reminder');
        $_data = "";
        if($aRow['status'] != 1) {
            $_data .= icon_btn('#' , 'credit-card', 'btn-success', array('onclick' => 'new_payment('.$count_period.', '.$aRow['id'].'); return false;'));
        }
        
        $_data .= icon_btn('#' , 'university', 'btn-info', array('onclick' => 'view_payment('.$count_period.', '.$aRow['id'].'); return false;'));
        $row[] = $_data;


    } else {
        $row[] = '';
    }
    $output['aaData'][] = $row;
}
