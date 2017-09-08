<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$aColumns     = array(
    'name',
    'code_role',
    'type'
    );

$sIndexColumn = "roleid";
$sTable       = 'tblroles';

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable,array(),array(),array('roleid'));
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = array();
    for ($i = 0; $i < count($aColumns); $i++) {
        $_data = $aRow[$aColumns[$i]];
        if ($aColumns[$i] == 'name') {
            $role_permissions = $this->_instance->roles_model->get_role_permissions($aRow['roleid']);
            $_data            = '<a href="' . admin_url('roles/role/' . $aRow['roleid']) . '" class="mbot10 display-block">' . $_data . '</a>';
            $_data .= '<span class="mtop10 display-block">'._l('roles_total_users'). ' ' . total_rows('tblstaff', array(
                'role' => $aRow['roleid']
                )) . '</span>';
        }
        if ($aColumns[$i] == 'type') {
            if($aRow[$aColumns[$i]]==1)
            {
                $_data=  '
                              <div class="checkbox checkbox-primary no-mtop checkbox-inline">
                                  <input type="checkbox" id="type-'.$aRow['roleid'].'" name="type" data-toggle="tooltip" onchange="update_type_role('.$aRow['roleid'].')" value="1" title="Kiểu hưởng hoa hồng" checked>
                                   <label for="type" data-toggle="tooltip"></label>
                              </div>
                          ';
            }
            else
            {
                $_data=  '<div class="form-group">
                              <div class="checkbox checkbox-primary no-mtop checkbox-inline">
                                  <input type="checkbox" id="type-'.$aRow['roleid'].'" name="type" data-toggle="tooltip" onchange="update_type_role('.$aRow['roleid'].')" value="0" title="Kiểu hưởng hoa hồng">
                                   <label for="type" data-toggle="tooltip"></label>
                              </div>
                          </div>';
            }
        }
        $row[] = $_data;
    }

    $options = icon_btn('roles/role/' . $aRow['roleid'], 'pencil-square-o');
    $row[]   = $options .= icon_btn('roles/delete/' . $aRow['roleid'], 'remove', 'btn-danger _delete');

    $output['aaData'][] = $row;
}
