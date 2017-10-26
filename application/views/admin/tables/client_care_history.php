<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$aColumns     = array(
    'tblclients.userid',
    'tblclients.company',
    'tblclients.priority',
    'tblclient_care_history.dateMeeting',
    'tblclient_care_history.status',
    'tblclient_care_history.solutions',
);
$sIndexColumn = "id";
$sTable       = 'tblclient_care_history';
$where        = array();
$join         = array(
    'RIGHT JOIN tblclients ON tblclients.userid=tblclient_care_history.idClient'
);
$result       = data_tables_init($aColumns, $sIndexColumn, $sTable,$join, $where, array(
    'tblclient_care_history.id',
));

$output       = $result['output'];
$rResult      = $result['rResult'];


$j=0;
foreach ($rResult as $aRow) {
    $row = array();
    $j++;
    for ($i = 0; $i < count($aColumns); $i++) {
        $_data = $aRow[$aColumns[$i]];
        
        // Cột đầu tiên là stt
        if($i==0) {
            $_data = $j;
        }

        $row[] = $_data;
    }
    if (is_admin()) {
        $_data = "";
        $_data .= icon_btn('#' , 'pencil-square-o', 'btn btn-default btn-edit', array('data-userid' => $aRow['tblclients.userid'], 'data-loading-text' => "<i class='fa fa-spinner fa-spin '></i>"));
        $row[] = $_data;
    } else {
        $row[] = '';
    }
    $output['aaData'][] = $row;
}
