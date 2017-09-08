<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$aColumns     = array(
    '1',
    'date_call',
    'note',
    'assigned'


);
$sIndexColumn = "id";
$sTable       = 'tblcall_logs';
$where        = array(
    'AND id_project_bds='.$id
);
array_push($where,' AND _delete =0');
$join         = array(
);
$result       = data_tables_init($aColumns, $sIndexColumn, $sTable,$join, $where, array(
    'id_project_bds',
    '_delete',
    'ID'
));
$output       = $result['output'];
$rResult      = $result['rResult'];
    $j=0;
    foreach ($rResult as $aRow) {
        $row = array();
        $j++;
        for ($i = 0; $i < count($aColumns); $i++) {
            $_data = $aRow[$aColumns[$i]];
            if($aColumns[$i]=='1')
            {
                $_data = '<div class="checkbox"><input type="checkbox" value="' . $aRow['ID'] . '"><label></label></div>';
            }
            if($aColumns[$i]=='assigned')
            {
                if ($aRow['assigned'] != 0) {
                    $_data = '<a data-toggle="tooltip" data-title="'.get_staff_full_name($aRow[$aColumns[$i]]).'" href="'.admin_url('profile/'.$aRow[$aColumns[$i]]).'">'.staff_profile_image($aRow[$aColumns[$i]], array(
                            'staff-profile-image-small'
                        )) .' '.get_staff_full_name($aRow[$aColumns[$i]]).'</a>';
                } else {
                    $_data = '';
                }
            }
            $row[] = $_data;
        }
        $options='<a onclick="view_update_or_add_call('.$aRow['ID'].')" class="btn btn-default btn-icon"  data-toggle="modal" data-target="#model_call_logs"><i class="fa fa-pencil-square-o"></i></a>';
            $options .= '<a onclick="delete_true('.$aRow['ID'].',\'call_logs\')" class="btn btn-danger _delete"><i class="fa fa-remove"></i></a>';
//        }
        $row[] = $options;
        $output['aaData'][] = $row;
    }

