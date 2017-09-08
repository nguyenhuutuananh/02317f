<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$aColumns     = array(
    '1',
    'name_partner',
    'phone_partner',
    'email_partner',
    'company_partner',
    'date',
    '(SELECT GROUP_CONCAT(name SEPARATOR ",") FROM tbltag_partner_in JOIN tbltag_partner ON tbltag_partner_in.tag_id = tbltag_partner.id WHERE tbltag_partner_in.id = id_partner) as tags',
    'addedfrom'


);
$sIndexColumn = "id_partner";
$sTable       = 'tblpartner';
$where        = array(
);
array_push($where,'AND status='.$status);
array_push($where,'AND _delete=0');
$join         = array();

$join = array();
$result       = data_tables_init($aColumns, $sIndexColumn, $sTable,$join, $where, array(
        'status',
        'id_partner'
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
                $_data = '<div class="checkbox"><input type="checkbox" value="' . $aRow['id_partner'] . '"><label></label></div>';
            }
            if($aColumns[$i]=='name_partner')
            {
                $_data='<a href="javacript:void(0)" data-toggle="modal" data-target="#add_data" onclick="get_data('.$aRow['id_partner'].')" >'.$aRow['name_partner'].'</a>';
            }
            if($aColumns[$i]=='date')
            {
                $_data=_d($aRow['date']);
            }
            if($i == 6) {
                $_data = render_tags($aRow['tags']);
            }
            if($aColumns[$i]=='addedfrom')
            {
                if ($aRow['addedfrom'] != 0) {
                    $_data = '<a data-toggle="tooltip" data-title="'.get_staff_full_name($aRow[$aColumns[$i]]).'" href="'.admin_url('profile/'.$aRow[$aColumns[$i]]).'">'.staff_profile_image($aRow[$aColumns[$i]], array(
                            'staff-profile-image-small'
                        )) .' '.get_staff_full_name($aRow[$aColumns[$i]]).'</a>';
                }
                else {
                    $_data = '';
                }
            }
            $row[] = $_data;
        }
        $options='<a href="javacript:void(0)" class="btn btn-danger _delete btn-icon" onclick="_delete('. $aRow['id_partner'].')"><i class="fa fa-remove"></i></a>';
        $row[]=$options;
        $output['aaData'][] = $row;
    }

