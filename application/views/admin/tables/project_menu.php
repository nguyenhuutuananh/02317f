<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$custom_fields = get_custom_fields('customers', array(

    'show_on_table' => 1

));



$aColumns     = array(
    'id',
    'code',
    'project_name',
    'status',
    'province',
    'district',
    'ward',
    'type_pn',
    'type_area',
    'door_direction',
    'fullname',
    'numberphone',
    'email',
    'furniture',
    'convenient',
    'characteristics',
    'date_filter',
    'exigency',
    'price',
    'detail_price',
    'deadline',
    'note',
    'type_bonus',
    'bonus',
    'code_tax',
    'staff_id'
    );

$sIndexColumn = "id";

$sTable       = 'tblprojectmenu';



$where = array();

$where = array('WHERE   project_parent='.$id);


$result  = data_tables_init($aColumns, $sIndexColumn,$sTable,$where,array(), array(), array(

    'id'
    
     

    ));

$output  = $result['output'];

$rResult = $result['rResult'];



foreach ($rResult as $aRow) {

    $row = array();

    for ($i = 0; $i < count($aColumns); $i++) {

        $_data = $aRow[$aColumns[$i]];

        if($aColumns[$i] == 'name')

        {

            $_data = '<a href="#" data-toggle="modal" data-target="#tax_modal" data-id="'.$aRow['id'].'">'.$_data.'</a>';

        }

         if ($aColumns[$i] == '1') 

        {

            $_data = '<div class="checkbox"><input type="checkbox" value="' . $aRow['id'] . '"><label></label></div>';

        }

         if ($aColumns[$i] == '(SELECT tblstatusbds.name FROM tblstatusbds WHERE status = tblstatusbds.id)') 

        {
        	 $_label_class = '';
                if (empty($aRow['color'])) {
                    $_label_class = 'default';
                }

          $_data = '<span class="inline-block label label-' . $_label_class . '" style="color:' . $aRow['color'] . ';border:1px solid ' . $aRow['color'] . '">' . $_data . '</span>';

        }

        $row[] = $_data;

    }



    $options = icon_btn('#' . $aRow['id'], 'pencil-square-o', 'btn-default', array(

        'data-toggle' => 'modal',

        'data-target' => '#tax_modal',

        'data-id' => $aRow['id']

        ));

    $row[]   = $options .= icon_btn('newview/deleteproject/' . $aRow['id'], 'remove', 'btn-danger _delete');



    $output['aaData'][] = $row;

}

