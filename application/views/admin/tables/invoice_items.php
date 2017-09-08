
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$aColumns     = array(
    'description',
    'long_description',
    'rate',
    'tax',
    'unit',
    'tblitems_groups.name',
     // '(SELECT  GROUP_CONCAT(name) FROM district LEFT JOIN tblitems ON tblitems.district_id = district.districtid WHERE districtid = tblitems.district_id)'
    '(SELECT (CONCAT(province.name," - ",district.name)) FROM district LEFT JOIN province ON district.provinceid = province.provinceid WHERE district_id = district.districtid)'
    );
// var_dump($aColumns);die;
$sIndexColumn = "id";
$sTable       = 'tblitems';


$join             = array(
    'LEFT JOIN tbltaxes ON tbltaxes.id = tblitems.tax',     
    'LEFT JOIN tblitems_groups ON tblitems_groups.id = tblitems.group_id',
    // 'LEFT JOIN district ON district.districtid = tblitems.district_id'
    );
$additionalSelect = array(
    'tblitems.id',
    'tbltaxes.name', 
    'taxrate',
    'group_id',
    'tblitems.district_id',
    'tblitems.provinceid',
    'tblitems.landtypeid',
    );
$result           = data_tables_init($aColumns, $sIndexColumn, $sTable ,$join, array(), $additionalSelect);
$output           = $result['output'];
$rResult          = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = array();
    for ($i = 0; $i < count($aColumns); $i++) {
        $_data = $aRow[$aColumns[$i]];

        if ($aColumns[$i] == 'tax') {
            if (!$aRow['taxrate']) {
                $aRow['taxrate'] = 0;
            }
            $_data = '<span data-toggle="tooltip" data-unit="'.$aRow['unit'].'" title="' . $aRow['name'] . '" data-taxid="' . $aRow['tax'] . '">' . $aRow['taxrate'] . '%' . '</span>';
        } else if($aColumns[$i] == 'description'){
            $_data = '<a href="#" data-toggle="modal" data-group-id="'.$aRow['group_id'].'" data-target="#sales_item_modal" data-id="'.$aRow['id'].'">'.$_data.'</a>';
        }

        $row[] = $_data;
    }
    $options = '';
    if(has_permission('items','','edit')){
        $options .= icon_btn('#' . $aRow['id'], 'pencil-square-o', 'btn-default', array(
            'data-toggle' => 'modal',
            'data-target' => '#sales_item_modal',
            'data-id' => $aRow['id'],
            'data-long_description' => $aRow['long_description'],
            'data-district_id' => $aRow['district_id'],
            'data-taxrate' => $aRow['rate'],
            'data-tax' =>$aRow['tax'],
            'data-unit' => $aRow['unit'],
            'data-group-id' => $aRow['group_id'],
            'data-provinceid' => $aRow['provinceid'],
            'data-landtypeid' => $aRow['landtypeid'],
            ));
    }
    if(has_permission('items','','delete')){
       $options .= icon_btn('invoice_items/delete/' . $aRow['id'], 'remove', 'btn-danger _delete');
   }
   $row[] = $options;

   $output['aaData'][] = $row;

}
