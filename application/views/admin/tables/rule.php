<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$aColumns     = array(
    'tblrule.id',
    'tblrule.name',
    'tblrule.content',
    'tblrule.color'

);
$sIndexColumn = "id";
$sTable       = 'tblrule';
$where        = array(
);
$join         = array(
);
$result       = data_tables_init($aColumns, $sIndexColumn, $sTable,$join, $where, array(
));
$output       = $result['output'];
$rResult      = $result['rResult'];
$j=0;
foreach ($rResult as $aRow) {
    $row = array();
    $j++;
    for ($i = 0; $i < count($aColumns); $i++) {
        $_data = $aRow[$aColumns[$i]];
        if($aColumns[$i]=='tblrule.color')
        {
            $_data="<div style='background-color: ".$aRow[$aColumns[$i]].";height:35px;width:100%;'>                        </div>";
        }
        $row[] = $_data;
    }
    $output['aaData'][] = $row;
}
