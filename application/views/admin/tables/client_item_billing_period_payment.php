<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$aColumns     = array(
    'id',
    'datePay',
    'realValue',
    '(select tblinvoicepaymentsmodes.name from tblinvoicepaymentsmodes where tblinvoicepaymentsmodes.id = tblclient_bds_payment_details.idPaymentMethod)',
);
$sIndexColumn = "id";
$sTable       = 'tblclient_bds_payment_details';
$where        = array(
   'AND tblclient_bds_payment_details.idClientBdsPayment=' . $idPayment . '',
);
$join         = array(
);

$order_by = 'order by tblclient_bds_payment_details.datePay asc';
// print_r($aColumns);
// exit();

$result       = data_tables_init($aColumns, $sIndexColumn, $sTable,$join, $where, array(
    'tblclient_bds_payment_details.id',
    '(select tblclient_bds_payment.status from tblclient_bds_payment where tblclient_bds_payment.id = tblclient_bds_payment_details.idClientBdsPayment)'
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
            case 'realValue':
                $_data = number_format($_data); 
                break;
            
        }

        $row[] = $_data;
    }
    if (is_admin()) {
        // $_data = '<a href="#" class="btn btn-default btn-icon" onclick="view_init_department(' . $aRow['id'] . '); return false;"><i class="fa fa-pencil"></i> Sửa</a>';

        // $_data.= icon_btn('kind_of_warehouse/delete/'. $aRow['id'] , 'remove', 'btn-danger delete-reminder');
        $_data = "";
        if($aRow['(select tblclient_bds_payment.status from tblclient_bds_payment where tblclient_bds_payment.id = tblclient_bds_payment_details.idClientBdsPayment)'] != 1)
        {
            $_data .= icon_btn('clients/deletePayment/' . $idClientBds . '/' . $idPayment . '/' . $aRow['id'] , 'times', 'btn-danger delete-reminder-client-payment');
        }
        
        $row[] = $_data;


    } else {
        $row[] = '';
    }
    $output['aaData'][] = $row;
}
