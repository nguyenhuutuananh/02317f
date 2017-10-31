<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$CI = &get_instance();

$aColumns = array(
    'id',
    'contractStartDate',
    'contractExpiryDate',
    'type',
    'contractCode',
    '1',
    '(select tblprojectmenu.code from tblprojectmenu where tblprojectmenu.id=tblclient_bds.projectBdsId)',
    '(select tblclients.company from tblclients where tblclients.userid=tblclient_bds.clientId)',
    '(select tblclients.dkkh from tblclients where tblclients.userid=tblclient_bds.clientId)',
    '(select tblclients.clientType from tblclients where tblclients.userid=tblclient_bds.clientId)',
    'id_partner',
    'price',
    'commissionPartner',
    'otherCosts',
    'noteOtherCosts',
    '(select sum(tblclient_bds_payment_details.realValue) from tblclient_bds_payment_details where tblclient_bds_payment_details.idClientBdsPayment in (select tblclient_bds_payment.id from tblclient_bds_payment where tblclient_bds_payment.idClientBds = tblclient_bds.id)) as DaNhan',
);

$sIndexColumn = "id";
$sTable = 'tblclient_bds';

$join = array(

);

$where = array(

);

$additionalSelect = array(
    'projectBdsId',
    'menuBdsId',
    'clientId',
    '(select tblclients.dkkh from tblclients where tblclients.userid=tblclient_bds.clientId)',
);

$result = data_tables_init($aColumns,$sIndexColumn,$sTable, $join, $where, $additionalSelect);
$output = $result['output'];
$rResult = $result['rResult'];

foreach ( $rResult as $aRow )
{
    $row = array();
    for ( $i=0 ; $i<count($aColumns) ; $i++ )
    {
        $_data = $aRow[$aColumns[$i]];

        switch($aColumns[$i]) {
            case 'dateStart':
            case 'contractStartDate':
            case 'contractExpiryDate':
                if($_data != "0000-00-00 00:00:00") {
                    $_data = _d($_data);
                }
                else {
                    $_data = "";
                }
                
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
            case 'commissionPartner':
                $_data = number_format($_data); 
                break;
            case '(select tblprojectmenu.code from tblprojectmenu where tblprojectmenu.id=tblclient_bds.projectBdsId)':
                $_data = '<a href="'.admin_url().'newview/project/'.$aRow['menuBdsId'].'/'.$aRow['projectBdsId'].'" target="_blank" onclick="">' . $_data . '</a>'; 
                break;
            case '(select tblclients.company from tblclients where tblclients.userid=tblclient_bds.clientId)':
                $_data = '<a href="'.admin_url() . 'clients/index/'. $aRow['clientId'] .'" target="_blank">'.$_data.'</a>';
                break;
            case '(select tblclients.clientType from tblclients where tblclients.userid=tblclient_bds.clientId)':
                if($_data == 'canhan') {
                    $_data = 'Cá nhân';
                }
                else if($_data == 'congty') {
                    $_data = "Công ty";
                }
                break;
            case '(select tblclients.dkkh from tblclients where tblclients.userid=tblclient_bds.clientId)':
                $_data = '<a target="_blank" data-toggle="tooltip" title="'.get_staff_full_name($_data).'" href="' . admin_url('staff/profile/' . $_data) . '">' . staff_profile_image($_data, array(
                        'staff-profile-image-small'
                    )) . '</a>';
                break;
            case 'id_partner':
                $_data = '<a target="_blank" href="'.admin_url() . 'partner/index/'.$_data.'">'.get_partner_full_name($_data).'</a>';
                break;
        }
        // Không thể dùng switch vì truy vấn lồng
        if($i == 15) {
            $_data = number_format($aRow['DaNhan']);
        }
        $row[] = $_data;
    }
    $options = icon_btn('#', 'list', 'btn-default btn-billingperiod', array('data-idproduct' => $aRow['id'], 'data-idclient' => $aRow['clientId']));
    $row[] = $options;
    // $row[]  = $options .= icon_btn('#','remove','btn-danger delete-reminder-client', array('onclick' => 'return _delete('.$aRow['id'].')'));

    $output['aaData'][] = $row;
}