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
    '2',
    '1',
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
        }

        $row[] = $_data;
    }
    // $options = icon_btn('#', 'pencil-square-o', 'btn-default', array('data-id' => $aRow['id'], 'onclick' => 'return _edit('.$aRow['id'].')'));
    // $row[]  = $options .= icon_btn('#','remove','btn-danger delete-reminder-client', array('onclick' => 'return _delete('.$aRow['id'].')'));

    $output['aaData'][] = $row;
}