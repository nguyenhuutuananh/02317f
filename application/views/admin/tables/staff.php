<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$custom_fields = get_custom_fields('staff', array(
    'show_on_table' => 1
    ));
$aColumns      = array(
    'code_staff',
    'firstname',
    'email',
    '(SELECT tblroles.name FROM tblroles where tblroles.roleid=tblstaff.role) as role_name',
    '(select concat(f.firstname," ",f.lastname) from tblstaff f where tblstaff.staff_manager = f.staffid ) as staffname',
    'last_login',
    '(SELECT tblrule.name FROM tblrule where tblrule.id=tblstaff.rule) as rule_name',
//    '(SELECT tblrule.name FROM tblrule where tblrule.id=tblstaff.rule) as rule_name',
    'active'
    );
$sIndexColumn  = "staffid";
$sTable        = 'tblstaff';
$join          = array(
//    'LEFT JOIN  ON tblservices.serviceid = tbltickets.service',
);
$i             = 0;
foreach ($custom_fields as $field) {

    $select_as = 'cvalue_'.$i;
    if($field['type'] == 'date_picker') {
      $select_as = 'date_picker_cvalue_'.$i;
    }
    array_push($aColumns,'ctable_'.$i.'.value as '.$select_as);
    array_push($join, 'LEFT JOIN tblcustomfieldsvalues as ctable_' . $i . ' ON tblstaff.staffid = ctable_' . $i . '.relid AND ctable_' . $i . '.fieldto="' . $field['fieldto'] . '" AND ctable_' . $i . '.fieldid=' . $field['id']);
    $i++;
}
            // Fix for big queries. Some hosting have max_join_limit
if (count($custom_fields) > 4) {
    @$this->_instance->db->query('SET SQL_BIG_SELECTS=1');
}

$where = do_action('staff_table_sql_where',
    array()
);
if(isset($_SESSION['rule'])&& ($_SESSION['rule']!=1)) {
//    array_push($where, 'AND role=' . $_SESSION['role'] . ' and (rule >' . $_SESSION['rule'] . ' or rule=' . $_SESSION['rule'].')');
}

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, array(
    'profile_image',
    'lastname',
    'staffid',
    'role',
    'rule',
    'admin',
    '(select tblworksheet.id from tblworksheet where tblworksheet.userid = tblstaff.staffid)'
    ));

$output  = $result['output'];
$rResult = $result['rResult'];

//var_dump($rResult);die();

foreach ($rResult as $aRow) {
    $row = array();
    if(is_admin()||$_SESSION['rule']=='1'||rule_go($aRow['staffid'])) {
        for ($i = 0; $i < count($aColumns); $i++) {
            if (strpos($aColumns[$i], 'as') !== false && !isset($aRow[$aColumns[$i]])) {
                $_data = $aRow[strafter($aColumns[$i], 'as ')];
            } else {
                $_data = $aRow[$aColumns[$i]];
            }
            if ($aColumns[$i] == 'last_login') {
                if ($_data != NULL) {
                    $_data = time_ago($_data);
                } else {
                    $_data = 'Never';
                }
            } else if ($aColumns[$i] == 'active') {
                $checked = '';
                if ($aRow['active'] == 1) {
                    $checked = 'checked';
                }

                $_data = '<div class="onoffswitch">
                <input type="checkbox" data-switch-url="' . admin_url() . 'staff/change_staff_status" name="onoffswitch" class="onoffswitch-checkbox" id="c_' . $aRow['staffid'] . '" data-id="' . $aRow['staffid'] . '" ' . $checked . '>
                <label class="onoffswitch-label" for="c_' . $aRow['staffid'] . '"></label>
            </div>';

                // For exporting
                $_data .= '<span class="hide">' . ($checked == 'checked' ? _l('is_active_export') : _l('is_not_active_export')) . '</span>';
            } else if ($aColumns[$i] == 'firstname') {
                $_data = '<a href="' . admin_url('staff/profile/' . $aRow['staffid']) . '">' . staff_profile_image($aRow['staffid'], array(
                        'staff-profile-image-small'
                    )) . '</a>';
                $_data .= ' <a href="' . admin_url('staff/member/' . $aRow['staffid']) . '">' . $aRow['firstname'] . ' ' . $aRow['lastname'] . '</a>';
            } else if ($aColumns[$i] == 'code_staff') {
                $_data = ' <a href="' . admin_url('staff/member/' . $aRow['staffid']) . '">' . $aRow['code_staff'] . '</a>';
            } else if ($aColumns[$i] == 'email') {
                $_data = '<a href="mailto:' . $_data . '">' . $_data . '</a>';
            } else {
                if (strpos($aColumns[$i], 'date_picker_') !== false) {
                    $_data = _d($_data);
                }
            }
            $row[] = $_data;
        }
        $options = "";
        if($aRow['(select tblworksheet.id from tblworksheet where tblworksheet.userid = tblstaff.staffid)'] == '') {
            $options .= icon_btn('worksheet/create/' . $aRow['staffid'], 'exchange');    
        }
        $options .= icon_btn('staff/member/' . $aRow['staffid'], 'pencil-square-o');
        if (has_permission('staff', '', 'delete') && $output['iTotalRecords'] > 1 && $aRow['staffid'] != get_staff_user_id()) {
            $options .= icon_btn('#', 'remove', 'btn-danger', array(
                'onclick' => 'delete_staff_member(' . $aRow['staffid'] . '); return false;',
            ));
        }
        $row[] = $options;
        $output['aaData'][] = $row;
    }
}
