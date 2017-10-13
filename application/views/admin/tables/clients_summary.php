<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$CI = &get_instance();

$tableClients = json_decode($CI->clients_model->get_table('tblorder_table_clients','id=1')->value);

$aColumns = array(
    'userid',
);

foreach($tableClients as $value) {
    // special column 
    switch($value->id) {
        case 'source':
            $value->id = '(select tblleadssources.name from tblleadssources where tblleadssources.id = tblclients.source)';
            break;
        case 'country':
            $value->id = '(select tblcountries.short_name from tblcountries where tblcountries.country_id = tblclients.country)';
            break;
    }
    $aColumns[] = $value->id;
}


$sIndexColumn = "userid";
$sTable = 'tblclients';

$join = array(

);

$where = array(

);

$additionalSelect = array(
    'userid',
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
        $array_staff = array('nvgd', 'dkkh');
        if($_data && in_array($aColumns[$i], $array_staff)) {
            $_data = '<a href="' . admin_url('staff/profile/' . $_data) . '">' . staff_profile_image($_data, array(
                'staff-profile-image-small'
            )) . '</a>';
        } else if ($aColumns[$i] == 'phonenumber') {
            $_data = '<a href="tel:' . $_data . '">' . $_data . '</a>';
        } else if ($aColumns[$i] == 'email') {
            $_data = '<a href="mailto:' . $_data . '">' . $_data . '</a>';
        } else if ($aColumns[$i] == 'company') {
            $_data = '<span class="clientName">' . $_data . '</span>';
        }
        else if ($aColumns[$i] == 'type_client') {
            switch($_data) {
                case '1':
                    $_data = "Khách đang quan tâm";
                    break;
                case '2':
                    $_data = "Khách đã mua";
                    break;
                case '3':
                    $_data = "Khách đã fail";
                    break;
            }
        }
        else if ($aColumns[$i] == 'clientFrom') {
            switch($_data) {
                case 'honeycomb':
                    $_data = "Honeycomb";
                    break;
                case 'moigioi':
                    $_data = "Môi giới";
                    break;
            }
        }

        $row[] = $_data;
    }
    $options = icon_btn('clients/client/'.$aRow['userid'], 'pencil-square-o', 'btn-default btn-edit-client', array('data-userid' => $aRow['userid'], 'data-loading-text' => "<i class='fa fa-spinner fa-spin '></i>"));
    $row[]  = $options .= icon_btn('clients/delete/'.$aRow['userid'],'remove','btn-danger delete-reminder-client');

    $output['aaData'][] = $row;
}
