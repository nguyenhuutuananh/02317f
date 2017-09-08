<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$custom_fields = get_custom_fields('customers', array(
    'show_on_table' => 1
));
if($type_master=='0')
{
    $aColumns     = array(
        '1',
        'code_master',
        'name',
        'relation',
        'state',
        'vocative',
        'birthday',
        'CMND',
        'phonenumber',
        'email_master',
        'TNCN',
        'address',
        'address_permanent',
        'company',
        'position',
        'hear',
        'hobby',
        'facebook'

    );
}
else
{
    $aColumns     = array(
        '1',
        'code_master',
        'name',
        'relation',
        'state',
        'vocative',
        'birthday',
        'CMND',
        'phonenumber',
        'email_master',
        'TNCN',
        'address',
        'address_permanent',
        'company',
        'position',
        'hear',
        'hobby',
        'facebook'

    );
}

$sIndexColumn = "id";
$sTable       = 'tblmaster_bds';
if($type_master==0)
{
    $where        ="AND idproject = ".$project_id." AND _delete=0 AND (type_master= ".$type_master." or type_master=3)";
}
else
{
    $where        ="AND idproject = ".$project_id." AND _delete=0 AND type_master= ".$type_master;
}

//$where        ="AND idproject = ".$project_id." AND _delete=0";
$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, array(), array($where), array(
    'id',
    'view',
    'type_master',
    'idproject',
    '_delete'
));
$output  = $result['output'];
$rResult = $result['rResult'];
//var_dump($rResult);die();
foreach ($rResult as $aRow) {
    $__data="";
    $row = array();
    for ($i = 0; $i < count($aColumns); $i++) {
        $_data = $aRow[$aColumns[$i]];
        if($aColumns[$i]=='1')
        {
            $_data = '<div class="checkbox"><input type="checkbox" value="' . $aRow['id'] . '"><label></label></div>';
        }
        if($aColumns[$i] == 'code_master')
        {
            if($type_master==0)
            {
                $_data = '<a href="#" id="edit_menu" data-toggle="modal" onclick="view_update_or_add('.$aRow['id'].',0)" data-target="#view_master" data-id="'.$aRow['id'].'">'.$_data.'</a>';
            }
            else
            {
                $_data = '<a href="#" id="edit_menu" data-toggle="modal" onclick="view_update_or_add('.$aRow['id'].',1)" data-target="#view_master" data-id="'.$aRow['id'].'">'.$_data.'</a>';
            }
        }
        if($aColumns[$i]=='vocative')
        {
            if($aRow[$aColumns[$i]]==1)
            {
                $_data='Mr';
            }
            else
            {
                if($aRow[$aColumns[$i]]==2)
                {
                    $_data='Ms';
                }
                else
                {
                    $_data='';
                }
            }

        }
        if($aColumns[$i]=='name')
        {
            if($type_master==0)
            {
                $_data = '<a href="#" id="edit_menu" onclick="view_update_or_add('.$aRow['id'].',0)" data-toggle="modal" data-target="#view_master" data-id="'.$aRow['id'].'">'.$_data.'</a>';
            }
            else
            {
                $_data = '<a href="#" id="edit_menu" onclick="view_update_or_add('.$aRow['id'].',1)" data-toggle="modal" data-target="#view_master" data-id="'.$aRow['id'].'">'.$_data.'</a>';
            }
        }
        if($aColumns[$i]=='phonenumber')
        {
            $phone=explode(',',$aRow['phonenumber']);
            $_data="";
            foreach($phone as $r)
            {
                $_data=$_data.'<span class="label label-default mleft5 inline-block">'.$r.'</span>';
            }

        }
        if(isset($aRow['view'])){
            if($aRow['view']==1){
                if($aRow['type_master']==0||$aRow['type_master']==1)
                {
                    $row['DT_RowClass'] = 'alert-danger';
                }
                else
                {
                    $row['DT_RowClass'] = 'alert-info';
                }
            }
            else
            {
                if($aRow['type_master']==0||$aRow['type_master']==1)
                {
                }
                else
                {
                    $row['DT_RowClass'] = 'alert-success';
                }
            }
        }
        $row[] = $_data;
    }

        if($aRow['view']==1)
        {
            $__data = 'glyphicon glyphicon-eye-open';
        }
        else
        {
            $__data = 'glyphicon glyphicon-eye-close';
        }
        if($aRow['type_master']=='0'||$aRow['type_master']=='1')
        {
            $icon='	glyphicon glyphicon-star-empty';
        }
        else
        {
            $icon='glyphicon glyphicon-star';
        }
    $options="";
    if($aRow['type_master']==0||$aRow['type_master']==3)
    {
        $options .= '<a onclick="onchange_type('.$aRow['id'].','.$aRow['type_master'].')" class="btn"><i class="'.$icon.'"></i></a>';
    }
    $options .= '<a onclick="onchange_status('.$aRow['id'].','.$aRow['view'].')" class="btn"><i class="'.$__data.'"></i></a>';

    $options .= '<a onclick="delete_true('.$aRow['id'].',\'master_bds\')" class="btn btn-danger _delete"><i class="fa fa-remove"></i></a>';

    $row[]   = $options;
    $output['aaData'][] = $row;
}

