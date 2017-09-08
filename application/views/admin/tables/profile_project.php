<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$aColumns     = array(
    'date',
    'id_staff',
    'addedfrom'


);
$sIndexColumn = "id";
$sTable       = 'tblprofile_project';
$where        = array(
);
array_push($where,' AND id_project='.$project_id);
$join         = array();

$join = array();
array_push($join, 'JOIN tblprojectmenu ON tblprojectmenu.id=tblprofile_project.id_project AND tblprofile_project.id_project='.$project_id);

$result       = data_tables_init($aColumns, $sIndexColumn, $sTable,$join, $where, array(
        'tblprofile_project.id',
        'tblprofile_project.id_project',
));
$output       = $result['output'];
$rResult      = $result['rResult'];
    $j=0;
    foreach ($rResult as $aRow) {
        $row = array();
        $j++;
        for ($i = 0; $i < count($aColumns); $i++) {
            $_data = $aRow[$aColumns[$i]];
            if($aColumns[$i]=='date')
            {
                $_data=_d($aRow[$aColumns[$i]]);
            }
            if($aColumns[$i]=='id_staff'||$aColumns[$i]=='addedfrom')
            {
                if ($aRow['id_staff'] != 0) {
                    $_data = '<a data-toggle="tooltip" data-title="'.get_staff_full_name($aRow[$aColumns[$i]]).'" href="'.admin_url('profile/'.$aRow[$aColumns[$i]]).'">'.staff_profile_image($aRow[$aColumns[$i]], array(
                            'staff-profile-image-small'
                        )) .' '.get_staff_full_name($aRow[$aColumns[$i]]).'</a>';
                } else {
                    $_data = '';
                }
                if ($aRow['addedfrom'] != 0) {
                    $_data = '<a data-toggle="tooltip" data-title="'.get_staff_full_name($aRow[$aColumns[$i]]).'" href="'.admin_url('profile/'.$aRow[$aColumns[$i]]).'">'.staff_profile_image($aRow[$aColumns[$i]], array(
                            'staff-profile-image-small'
                        )) .' '.get_staff_full_name($aRow[$aColumns[$i]]).'</a>';
                } else {
                    $_data = '';
                }
            }
            $row[] = $_data;
        }
        $options= '<a onclick="delete_profile('.$aRow['id'].')" class="btn btn-danger _delete"><i class="fa fa-remove"></i></a>';
        $row[]=$options;
        $output['aaData'][] = $row;
    }

