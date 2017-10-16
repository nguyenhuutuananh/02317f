<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$CI = &get_instance();

$aColumns = array(
    'id',
    'agencyName',
    'agencyPhone',
    'agencyAddress',
);

$sIndexColumn = "id";
$sTable = 'tblagencies';

$join = array(

);

$where = array(

);

$additionalSelect = array(

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

        $row[] = $_data;
    }
    $options = icon_btn('#', 'pencil-square-o', 'btn-default', array('data-id' => $aRow['id'], 'onclick' => 'return _edit('.$aRow['id'].')'));
    $row[]  = $options .= icon_btn('#','remove','btn-danger delete-reminder-client', array('onclick' => 'return _delete('.$aRow['id'].')'));

    $output['aaData'][] = $row;
}
