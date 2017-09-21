<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$aColumns     = array(
    'tblclient_bds_payment_details.id',
    '(select tblprojectmenu.project_name from tblprojectmenu where tblprojectmenu.id = (select tblclient_bds.projectBdsId from tblclient_bds where tblclient_bds.id = tblclient_bds_payment.idClientBds))',
    'tblclient_bds_payment_details.datePay',
    'tblclient_bds_payment_details.realValue',
    '(select tblinvoicepaymentsmodes.name from tblinvoicepaymentsmodes where tblinvoicepaymentsmodes.id = tblclient_bds_payment_details.idPaymentMethod)',
);
$sIndexColumn = "id";
$sTable       = 'tblclient_bds_payment_details';
$where        = array(
   'AND tblclient_bds_payment_details.idClientBdsPayment IN (select tblclient_bds_payment.id from tblclient_bds_payment where tblclient_bds_payment.idClientBds in (select tblclient_bds.id from tblclient_bds where tblclient_bds.clientId = '.$idClient.'))',
);

$join         = array(
    'LEFT JOIN tblclient_bds_payment ON tblclient_bds_payment.id = tblclient_bds_payment_details.idClientBdsPayment',
);

$order_by = 'order by tblclient_bds_payment_details.datePay asc';

$result       = data_tables_init($aColumns, $sIndexColumn, $sTable,$join, $where, array(
    'tblclient_bds_payment_details.id',
    '(select tblclient_bds_payment.idClientBds from tblclient_bds_payment where tblclient_bds_payment.id=tblclient_bds_payment_details.idClientBdsPayment)',
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
            case '(select tblprojectmenu.project_name from tblprojectmenu where tblprojectmenu.id = (select tblclient_bds.projectBdsId from tblclient_bds where tblclient_bds.id = tblclient_bds_payment.idClientBds))':
                $_data = '<a href="#" onclick="view_init_department(' . $aRow['(select tblclient_bds_payment.idClientBds from tblclient_bds_payment where tblclient_bds_payment.id=tblclient_bds_payment_details.idClientBdsPayment)'] . '); return false;">' . $_data . '</a>';
                break;
            case 'tblclient_bds_payment_details.id':
                $_data = $count_period;
                break;
            case 'tblclient_bds_payment_details.datePay':
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
            case 'tblclient_bds_payment_details.realValue':
                $_data = number_format($_data); 
                break;
            
        }

        $row[] = $_data;
    }
    if (is_admin()) {
        // $_data = '<a href="#" class="btn btn-default btn-icon" onclick="view_init_department(' . $aRow['id'] . '); return false;"><i class="fa fa-pencil"></i> Sửa</a>';

        // $_data.= icon_btn('kind_of_warehouse/delete/'. $aRow['id'] , 'remove', 'btn-danger delete-reminder');
        $_data = "";
        
        $row[] = $_data;


    } else {
        $row[] = '';
    }
    $output['aaData'][] = $row;
}
