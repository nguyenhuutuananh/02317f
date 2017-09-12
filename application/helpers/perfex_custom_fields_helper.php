<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Render custom fields for particular area
 * @param  string  $belongs_to
 * @param  int $rel_id
 * @param  array   $where
 * @return string
 */
function render_custom_fields($belongs_to, $rel_id = false, $where = array())
{
    $CI =& get_instance();
    $CI->db->where('active', 1);
    $CI->db->where('fieldto', $belongs_to);
    if (count($where) > 0) {
        $CI->db->where($where);
    }
    $CI->db->order_by('field_order', 'asc');
    $fields      = $CI->db->get('tblcustomfields')->result_array();
    $fields_html = '';

    $is_admin = is_admin();
    if (count($fields)) {
        $fields_html .= '<div class="row">';
        foreach ($fields as $field) {

            if ($field['only_admin'] == 1 && !$is_admin) {
                continue;
            }

            $field['name'] = _l('cf_translate_' . $field['slug'],'',false) != 'cf_translate_' . $field['slug'] ? _l('cf_translate_' . $field['slug'],'',false) : $field['name'];

            $value = '';
            if ($field['bs_column'] == '' || $field['bs_column'] == 0) {
                $field['bs_column'] = 12;
            }

            $fields_html .= '<div class="col-md-' . $field['bs_column'] . '">';
            if ($is_admin) {
                $fields_html .= '<a href="' . admin_url('custom_fields/field/' . $field['id']) . '" target="_blank" class="custom-field-inline-edit-link"><i class="fa fa-pencil-square-o"></i></a>';
            }
            if ($rel_id !== false) {
                $value = get_custom_field_value($rel_id, $field['id'], $belongs_to, false);
            }

            $_input_attrs = array();
            if ($field['required'] == 1) {
                $_input_attrs['data-custom-field-required'] = true;
            }

            if ($field['disalow_client_to_edit'] == 1 && is_client_logged_in()) {
                $_input_attrs['disabled'] = true;
            }
            $_input_attrs['data-fieldto'] = $field['fieldto'];
            $_input_attrs['data-fieldid'] = $field['id'];

            $field_name = ucfirst($field['name']);
            if ($field['type'] == 'input') {
                $fields_html .= render_input('custom_fields[' . $field['fieldto'] . '][' . $field['id'] . ']', $field_name, $value, 'text', $_input_attrs);
            } else if ($field['type'] == 'date_picker') {
                $fields_html .= render_date_input('custom_fields[' . $field['fieldto'] . '][' . $field['id'] . ']', $field_name, _d($value), $_input_attrs);
            } else if ($field['type'] == 'textarea') {
                $fields_html .= render_textarea('custom_fields[' . $field['fieldto'] . '][' . $field['id'] . ']', $field_name, $value, $_input_attrs);
            } else if ($field['type'] == 'colorpicker') {
                $fields_html .= render_color_picker('custom_fields[' . $field['fieldto'] . '][' . $field['id'] . ']', $field_name, $value, $_input_attrs);
            } else if ($field['type'] == 'select') {
                $_select_attrs = array();
                $select_attrs  = '';
                if ($field['required'] == 1) {
                    $_select_attrs['data-custom-field-required'] = true;
                }
                if ($field['disalow_client_to_edit'] == 1 && is_client_logged_in()) {
                    $_select_attrs['disabled'] = true;
                }
                $_select_attrs['data-fieldto'] = $field['fieldto'];
                $_select_attrs['data-fieldid'] = $field['id'];
                foreach ($_select_attrs as $key => $val) {
                    $select_attrs .= $key . '=' . '"' . $val . '" ';
                }

                $fields_html .= '<div class="form-group">';
                $fields_html .= '<label for="custom_fields[' . $field['fieldto'] . '][' . $field['id'] . ']">' . $field_name . '</label>';
                $fields_html .= '<select ' . $select_attrs . ' name="custom_fields[' . $field['fieldto'] . '][' . $field['id'] . ']" class="selectpicker form-control" data-width="100%" data-none-selected-text="' . _l('dropdown_non_selected_tex') . '"  data-live-search="true">';
                $fields_html .= '<option value=""></option>';
                $options = explode(',', $field['options']);
                foreach ($options as $option) {
                    $option   = trim($option);
                    $selected = '';
                    if ($option == $value) {
                        $selected = ' selected';
                    }
                    $fields_html .= '<option value="' . $option . '"' . $selected . '' . set_select('custom_fields[' . $field['fieldto'] . '][' . $field['id'] . ']', $option) . '>' . $option . '</option>';
                }
                $fields_html .= '</select>';
                $fields_html .= '</div>';
            } else if ($field['type'] == 'checkbox') {
                $fields_html .= '<div class="form-group chk">';
                $fields_html .= '<br /><label class="control-label" for="custom_fields[' . $field['fieldto'] . '][' . $field['id'] . '][]">' . $field_name . '</label>';
                $options = explode(',', $field['options']);
                $value   = explode(',', $value);

                foreach ($options as $option) {
                    $checked = '';
                    // Replace double quotes with single.
                    $option  = preg_replace('/"/', '', $option);
                    $option  = trim($option);
                    foreach ($value as $v) {
                        $v = trim($v);
                        if ($v == $option) {
                            $checked = 'checked';
                        }
                    }

                    $_chk_attrs                 = array();
                    $chk_attrs                  = '';
                    $_chk_attrs['data-fieldto'] = $field['fieldto'];
                    $_chk_attrs['data-fieldid'] = $field['id'];

                    if ($field['required'] == 1) {
                        $_chk_attrs['data-custom-field-required'] = true;
                    }

                    if ($field['disalow_client_to_edit'] == 1 && is_client_logged_in()) {
                        $_chk_attrs['disabled'] = true;
                    }
                    foreach ($_chk_attrs as $key => $val) {
                        $chk_attrs .= $key . '=' . '"' . $val . '" ';
                    }

                    $fields_html .= '<div class="checkbox">';
                    $fields_html .= '<input class="custom_field_checkbox" ' . $chk_attrs . ' ' . set_checkbox('custom_fields[' . $field['fieldto'] . '][' . $field['id'] . '][]', $option) . ' ' . $checked . ' value="' . $option . '" id="cfc_' . $field['id'] . '_' . slug_it($option) . '" type="checkbox" name="custom_fields[' . $field['fieldto'] . '][' . $field['id'] . '][]">';

                    $fields_html .= '<label for="cfc_' . $field['id'] . '_' . slug_it($option) . '">' . $option . '</label>';
                    $fields_html .= '<input type="hidden" name="custom_fields[' . $field['fieldto'] . '][' . $field['id'] . '][]" value="cfk_hidden">';
                    $fields_html .= '</div>';
                }
                $fields_html .= '</div>';
            } else if ($field['type'] == 'link') {

                $fields_html .= '<div class="form-group cf-hyperlink" data-fieldto="' . $field['fieldto'] . '" data-field-id="' . $field['id'] . '" data-value="' . htmlspecialchars($value) . '" data-field-name="' . htmlspecialchars($field_name) . '">';
                $fields_html .= '<label class="control-label" for="custom_fields[' . $field['fieldto'] . '][' . $field['id'] . ']">' . $field_name . '</label></br>';

                $fields_html .= '<a id="custom_fields_' . $field['fieldto'] . '_' . $field['id'] . '_popover" type="button" href="javascript:">' . _l('cf_translate_input_link_tip') . '</a>';

                $fields_html .= '<input type="hidden" ' . ($field['required'] == 1 ? 'data-custom-field-required="1"' : '') . ' value="" id="custom_fields[' . $field['fieldto'] . '][' . $field['id'] . ']" name="custom_fields[' . $field['fieldto'] . '][' . $field['id'] . ']">';

                $field_template = '';
                $field_template .= '<div id="custom_fields_' . $field['fieldto'] . '_' . $field['id'] . '_popover-content" class="hide cfh-field-popover-template"><div class="form-group">';
                $field_template .= '<div class="row"><div class="col-md-12"><label class="control-label" for="custom_fields_' . $field['fieldto'] . '_' . $field['id'] . '_title">' . _l('cf_translate_input_link_title') . '</label>';
                $field_template .= '<input type="text"' . ($field['disalow_client_to_edit'] == 1 && is_client_logged_in() ? " disabled=\"true\" " : ' ') . 'id="custom_fields_' . $field['fieldto'] . '_' . $field['id'] . '_title" value="" class="form-control">';
                $field_template .= '</div>';
                $field_template .= '</div>';
                $field_template .= '</div>';
                $field_template .= '<div class="form-group">';
                $field_template .= '<div class="row">';
                $field_template .= '<div class="col-md-12">';
                $field_template .= '<label class="control-label" for="custom_fields_' . $field['fieldto'] . '_' . $field['id'] . '_link">' . _l('cf_translate_input_link_url') . '</label>';
                $field_template .= '<input type="text"' . ($field['disalow_client_to_edit'] == 1 && is_client_logged_in() ? " disabled=\"true\" " : ' ') . 'id="custom_fields_' . $field['fieldto'] . '_' . $field['id'] . '_link" value="" class="form-control">';
                $field_template .= '</div>';
                $field_template .= '</div>';
                $field_template .= '</div>';
                $field_template .= '<div class="row">';
                $field_template .= '<div class="col-md-6">';
                $field_template .= '<button type="button" id="custom_fields_' . $field['fieldto'] . '_' . $field['id'] . '_btn-cancel" class="btn btn-default btn-md pull-left" value="">' . _l('cancel') . '</button>';
                $field_template .= '</div>';
                $field_template .= '<div class="col-md-6">';
                $field_template .= '<button type="button" id="custom_fields_' . $field['fieldto'] . '_' . $field['id'] . '_btn-save" class="btn btn-info btn-md pull-right" value="">' . _l('apply') . '</button>';
                $field_template .= '</div>';
                $field_template .= '</div>';
                $fields_html .= '<script>';
                $fields_html .= 'cfh_popover_templates[\'' . $field['id'] . '\'] = \'' . $field_template . '\';';
                $fields_html .= '</script>';
                $fields_html .= '</div>';
            }

            $name = 'custom_fields[' . $field['fieldto'] . '][' . $field['id'] . ']';
            if ($field['type'] == 'checkbox') {
                $name .= '[]';
            }

            $fields_html .= form_error($name);
            // Close column
            $fields_html .= '</div>';

        }
        // close row
        $fields_html .= '</div>';
    }

    return $fields_html;
}

/**
 * Get custom fields
 * @param  [type]  $field_to
 * @param  array   $where
 * @param  boolean $exclude_only_admin
 * @return array
 */
function get_custom_fields($field_to, $where = array(), $exclude_only_admin = false)
{
    $is_admin = is_admin();
    $CI =& get_instance();
    $CI->db->where('fieldto', $field_to);
    if (count($where) > 0) {
        $CI->db->where($where);
    }
    if (!$is_admin || $exclude_only_admin == TRUE) {
        $CI->db->where('only_admin', 0);
    }
    $CI->db->where('active', 1);
    $CI->db->order_by('field_order', 'asc');

    $results = $CI->db->get('tblcustomfields')->result_array();


    foreach ($results as $key => $result) {
        $results[$key]['name'] = _l('cf_translate_' . $result['slug'],'',false) != 'cf_translate_' . $result['slug'] ? _l('cf_translate_' . $result['slug'],'',false) : $result['name'];
    }

    return $results;
    
}
/**
 * Get custom field value
 * @param  mixed $rel_id   the main ID from the table
 * @param  mixed $field_id field id
 * @param  string $field_to belongs to ex.leads,customers,staff
 * @param  string $format format date values
 * @return string
 */
function get_custom_field_value($rel_id, $field_id, $field_to, $format = true)
{
    $CI =& get_instance();
    $CI->db->where('relid', $rel_id);
    $CI->db->where('fieldid', $field_id);
    $CI->db->where('fieldto', $field_to);
    $row    = $CI->db->get('tblcustomfieldsvalues')->row();
    $result = '';
    if ($row) {

        $result = $row->value;
        if ($format == true) {
            $CI->db->where('id', $field_id);
            $_row = $CI->db->get('tblcustomfields')->row();
            if ($_row->type == 'date_picker') {
                $result = _d($result);
            }
        }
    }
    return $result;
}
/**
 * Check for custom fields, update on $_POST
 * @param  mixed $rel_id        the main ID from the table
 * @param  array $custom_fields all custom fields with id and values
 * @return boolean
 */
function handle_custom_fields_post($rel_id, $custom_fields)
{
    $affectedRows = 0;
    $CI =& get_instance();

    foreach ($custom_fields as $key => $fields) {
        foreach ($fields as $field_id => $field_value) {

            $CI->db->where('relid', $rel_id);
            $CI->db->where('fieldid', $field_id);
            $CI->db->where('fieldto', $key);
            $row = $CI->db->get('tblcustomfieldsvalues')->row();
            // Make necessary checkings for fields
            $CI->db->where('id', $field_id);
            $field_checker = $CI->db->get('tblcustomfields')->row();
            if ($field_checker->type == 'date_picker') {
                $field_value = to_sql_date($field_value);
            } else if ($field_checker->type == 'textarea') {
                $field_value = nl2br($field_value);
            } else if ($field_checker->type == 'checkbox') {
                if ($field_checker->disalow_client_to_edit == 1 && is_client_logged_in()) {
                    continue;
                }
                if (is_array($field_value)) {
                    $v = 0;
                    foreach ($field_value as $chk) {
                        if ($chk == 'cfk_hidden') {
                            unset($field_value[$v]);
                        }
                        $v++;
                    }
                    $field_value = implode(', ', $field_value);
                }
            }
            if ($row) {
                $CI->db->where('id', $row->id);
                $CI->db->update('tblcustomfieldsvalues', array(
                    'value' => $field_value
                ));
                if ($CI->db->affected_rows() > 0) {
                    $affectedRows++;
                }
            } else {
                if ($field_value != '') {
                    $CI->db->insert('tblcustomfieldsvalues', array(
                        'relid' => $rel_id,
                        'fieldid' => $field_id,
                        'fieldto' => $key,
                        'value' => $field_value
                    ));
                    $insert_id = $CI->db->insert_id();
                    if ($insert_id) {
                        $affectedRows++;
                    }
                }
            }
        }
    }
    if ($affectedRows > 0) {
        return true;
    }
    return false;
}
/**
 * Get manually added company custom fields
 * @since Version 1.0.4
 * @return array
 */
function get_company_custom_fields()
{
    $fields = get_custom_fields('company');
    $i      = 0;
    foreach ($fields as $field) {
        $fields[$i]['label'] = $field['name'];
        $fields[$i]['value'] = get_custom_field_value(0, $field['id'], 'company');
        $i++;
    }
    return $fields;
}
/**
 * Function used for JS to render custom field hyperlink
 * @return stirng
 */
function get_custom_fields_hyperlink_js_function()
{
    ob_start();
?>
    <script>
        function custom_fields_hyperlink(){
         var cf_hyperlink = $('body').find('.cf-hyperlink');
         $.each(cf_hyperlink,function(){
            var cfh_wrapper = $(this);
            var cfh_field_to = cfh_wrapper.attr('data-fieldto');
            var cfh_field_id = cfh_wrapper.attr('data-field-id');
            var textEl = $('body').find('#custom_fields_'+cfh_field_to+'_'+cfh_field_id+'_popover');
            var hiddenField = $("#custom_fields\\\["+cfh_field_to+"\\\]\\\["+cfh_field_id+"\\\]");
            var cfh_value = cfh_wrapper.attr('data-value');
            hiddenField.val(cfh_value);
            if($(hiddenField.val()).html() != ''){
                textEl.html($(hiddenField.val()).html());
            }
            var cfh_field_name = cfh_wrapper.attr('data-field-name');
            textEl.popover({
                html: true,
                trigger: "manual",
                placement: "top",
                title:cfh_field_name,
                content:function(){
                    return $(cfh_popover_templates[cfh_field_id]).html();
                }
            }).on("click", function(e){
                var $popup = $(this);
                $popup.popover("toggle");
                var titleField = $("#custom_fields_"+cfh_field_to+"_"+cfh_field_id+"_title");
                var urlField = $("#custom_fields_"+cfh_field_to+"_"+cfh_field_id+"_link");
                var ttl = $(hiddenField.val()).html();
                var cfUrl = $(hiddenField.val()).attr("href");
                titleField.val(ttl);
                urlField.val(cfUrl);
                $("#custom_fields_"+cfh_field_to+"_"+cfh_field_id+"_btn-save").click(function(){
                    hiddenField.val((urlField.val() != '' ? '<a href="'+urlField.val()+'" target="_blank">' + titleField.val() + '</a>' : ''));
                    textEl.html(titleField.val() == "" ? cf_translate_input_link_tip : titleField.val());
                    $popup.popover("toggle");
                });
                $("#custom_fields_"+cfh_field_to+"_"+cfh_field_id+"_btn-cancel").click(function(){
                    if(urlField.val() == ''){
                        hiddenField.val('');
                    }
                    $popup.popover("toggle");
                });
            });
        });
     }
 </script>
 <?php
    $contents = ob_get_contents();
    ob_end_clean();
    return $contents;
}


//Cong
function get_fields($table,$where = array())
{
    $CI =& get_instance();
    $CI->db->where('_table',$table);
    if (count($where) > 0) {
        $CI->db->where($where);
    }
    $CI->db->order_by('field_order', 'asc');

    $results = $CI->db->get('tbfield_bds')->result_array();


    foreach ($results as $key => $result) {
        $results[$key]['name'] =$result['name'];
    }

    return $results;

}
function get_field_value($field_id, $colum_id, $field_to="", $format = true)
{
    $CI =& get_instance();
    $CI->db->where('field_id', $field_id );
    $CI->db->where('colum_id', $colum_id);
    $row    = $CI->db->get('tblfieldvalue_bds')->row();
    $result = '';
    if ($row) {

        $result = $row->value;
        if ($format == true) {
            $CI->db->where('id', $field_id);
            $CI->db->where('_table', $field_to);
            $_row = $CI->db->get('tbfield_bds')->row();
            if ($_row->type == 'date_picker') {
                $result = _d($result);
            }
        }
    }
    return $result;
}

function insert_field($id,$data)
{
    $CI =& get_instance();
    $affected=0;
    foreach($data as $rom=>$value)
    {
        $CI->db->where('colum_id',$id);
        $CI->db->where('field_id',$rom);
        $result=$CI->db->get('tblfieldvalue_bds')->row();
        if(!$result)
        {
            $CI->db->insert('tblfieldvalue_bds',array('colum_id'=>$id,'field_id'=>$rom,'value'=>$value));
            $insert_id = $CI->db->insert_id();


        }
        else
        {
            $CI->db->where('colum_id',$id);
            $CI->db->where('field_id',$rom);
            $CI->db->update('tblfieldvalue_bds',array('value'=>$value));
        }
    }
        return true;
}

function render_fields($belongs_to, $rel_id = false, $where = array(),$where_in=array())
{
    $CI =& get_instance();
    $CI->db->select('tbfield_bds.*,tblfieldvalue_bds.colum_id as id_colum');
    $CI->db->where('_table', $belongs_to);
    if (count($where) > 0) {
        $CI->db->where($where);
    }
    if(count($where_in) > 0)
    {
        $CI->db->where_in('id',$where_in);
    }
    $CI->db->join('tblfieldvalue_bds','tblfieldvalue_bds.field_id=tbfield_bds.id','left');
    $CI->db->order_by('field_order', 'asc');
    $fields      = $CI->db->get('tbfield_bds')->result_array();
    $fields_html = '';

    $is_admin = is_admin();
    if (count($fields)) {
        $fields_html .= '<div class="row">';
        foreach ($fields as $field) {

            $field['name'] = _l('cf_translate_' . $field['slug'],'',false) != 'cf_translate_' . $field['slug'] ? _l('cf_translate_' . $field['slug'],'',false) : $field['name'];

            $value = '';
            if ($field['bs_column'] == '' || $field['bs_column'] == 0) {
                $field['bs_column'] = 12;
            }

            $fields_html .= '<div class="col-md-' . $field['bs_column'] . '">';
            if ($is_admin) {
//                $fields_html .= '<a href="' . admin_url('custom_fields/field/' . $field['id']) . '" target="_blank" class="custom-field-inline-edit-link"><i class="fa fa-pencil-square-o"></i></a>';
            }
            if ($rel_id !== false) {
                $value = get_field_value($field['id'],$field['id_colum'],'', false);
            }

            $_input_attrs = array();
            if ($field['required'] == 1) {
                $_input_attrs['data-custom-field-required'] = true;
            }

            $field_name = ucfirst($field['name']);
            if ($field['type'] == 'input') {
                $fields_html .= '<div class="form-group"><label for="'.$field['id_field'].'_'. $field['id'].'" class="control-label">'.$field_name.'</label><input type="text" id="'.$field['id_field'].'_'. $field['id'].'" name="'.'fields[' . $field['_table'] . '][' . $field['id'] . ']'.'" class="form-control" value="'.$value.'"></div>';
            }
            $name = 'fields[' . $field['_table'] . '][' . $field['id'] . ']';
            if ($field['type'] == 'checkbox') {
                $name .= '[]';
            }

            $fields_html .= form_error($name);
            $fields_html .='</div>';

        }
        $fields_html .= '</div>';
    }

    return $fields_html;
}
function render_one_fields($belongs_to, $rel_id = false, $where = array(),$delete=true,$cokkie=false)
{
    $CI =& get_instance();
    $CI->db->where('_table', $belongs_to);
    if (count($where) > 0) {
        $CI->db->where($where);
    }
    $CI->db->order_by('field_order', 'asc');
    $fields      = $CI->db->get('tbfield_bds')->result_array();
    $fields_html = '';

    $is_admin = is_admin();
    if (count($fields)) {
        $fields_html .= '';
        foreach ($fields as $field) {

            $field['name'] = _l('cf_translate_' . $field['slug'],'',false) != 'cf_translate_' . $field['slug'] ? _l('cf_translate_' . $field['slug'],'',false) : $field['name'];

            $value = '';
            if ($field['bs_column'] == '' || $field['bs_column'] == 0) {
                $field['bs_column'] = 12;
            }

            $fields_html .= '<div class="col-md-' . $field['bs_column'] .' ' .$field['id_field'].'_'. $field['id'].'">';
            if ($is_admin) {
//                $fields_html .= '<a href="' . admin_url('custom_fields/field/' . $field['id']) . '" target="_blank" class="custom-field-inline-edit-link"><i class="fa fa-pencil-square-o"></i></a>';
            }
            if ($rel_id !== false) {
                $value = get_field_value($rel_id, $field['id'], $belongs_to, false);
            }
            else
            {
                if($cokkie!==false)
                {
                    $value=$cokkie;
                }
            }

            $_input_attrs = array();
            if ($field['required'] == 1) {
                $_input_attrs['data-custom-field-required'] = true;
            }

            $field_name = ucfirst($field['name']);
            if ($field['type'] == 'input') {
                if($cokkie!==false){
                    $fields_html .= '<div class="form-group"><input type="text" id="'.$field['id_field'].'_'. $field['id'].'" name="'.$field['id_field'].'_'. $field['id'].'" class="form-control" placeholder="'.$field['name'].'" value="'.$value.'"></div>';
                }
                else
                    {
                    $fields_html .= '<div class="form-group"><input type="text" id="'.$field['id_field'].'_'. $field['id'].'" name="'.'fields[' . $field['_table'] . '][' . $field['id'] . ']'.'" class="form-control" placeholder="'.$field['name'].'" value=""></div>';
                }
            }
            $name = 'fields[' . $field['_table'] . '][' . $field['id'] . ']';
            if ($field['type'] == 'checkbox') {
                $name .= '[]';
            }

            $fields_html .= form_error($name);
            $fields_html .= '</div>';

        }
    }

    return $fields_html;
}



function insert_row_menu_field($id_menu,$data_table,$data_from)
{
    $CI =& get_instance();
    $CI->db->where('id_menu',$id_menu);
    $CI->db->update('tblrow_menu_bds',array('fields_table'=>0,'fields_from'=>0));
    foreach($data_from as $r=>$v) {
        if($v=='on') $v=1;else $v=0;
        $CI->db->where('id_field',$r);
        $CI->db->where('id_menu',$id_menu);
        $result=$CI->db->get('tblrow_menu_bds')->row();

        if($result)
        {
            $CI->db->where('id_field',$r);
            $CI->db->where('id_menu',$id_menu);
            $CI->db->update('tblrow_menu_bds',array('fields_from'=>$v));
        }
        else
        {
            $CI->db->insert('tblrow_menu_bds',array('id_field'=>$r,'id_menu'=>$id_menu,'fields_from'=>$v));
        }
    }
    foreach($data_table as $r_t=>$v_t) {
        if($v_t=='on') $v_t=1;else $v_t=0;
        $CI->db->where('id_field',$r_t);
        $CI->db->where('id_menu',$id_menu);
        $result=$CI->db->get('tblrow_menu_bds')->row();
        if($result)
        {
            $CI->db->where('id_field',$r_t);
            $CI->db->where('id_menu',$id_menu);
            $CI->db->update('tblrow_menu_bds',array('fields_table'=>$v_t));
        }
        else
        {

            $CI->db->insert('tblrow_menu_bds',array('id_field'=>$r_t,'id_menu'=>$id_menu,'fields_table'=>$v_t));
        }
    }
    return true;
}





function render_fields_row($table,$id_menu,$id_colum="", $where = array(),$col='',$class_lable='',$class_div='')
{
    $CI =& get_instance();
    $CI->db->select('tbfield_bds.*');
    $CI->db->join('tblrow_menu_bds','tblrow_menu_bds.id_field=tbfield_bds.id and tblrow_menu_bds.id_menu='.$id_menu);
    $CI->db->where('tbfield_bds._table', $table);
    if (count($where) > 0) {
        foreach($where as $w)
        {
            $CI->db->where($w);
        }
    }
    $CI->db->order_by('tbfield_bds.field_order', 'asc');
    $fields      = $CI->db->get('tbfield_bds')->result_array();
//    return var_dump($fields);
    $fields_html = '';

    $is_admin = is_admin();
    if (count($fields)) {
        $fields_html .= '';
        foreach ($fields as $field) {

            $field['name'] = _l('cf_translate_' . $field['slug'],'',false) != 'cf_translate_' . $field['slug'] ? _l('cf_translate_' . $field['slug'],'',false) : $field['name'];

            $value = '';
            if($col=="")
            {
                if ($field['bs_column'] == '' || $field['bs_column'] == 0) {
                    $field['bs_column'] = 12;
                }
            }
            else
            {
                $field['bs_column'] = $col;
            }

            $fields_html .= '<div class="col-md-' . $field['bs_column'] . '">';
            if($id_colum!="")
            {
                $value = get_field_value($field['id'],$id_colum,'', false);
            }

            $_input_attrs = array();
            if ($field['required'] == 1) {
                $_input_attrs['data-custom-field-required'] = true;
            }

            $field_name = ucfirst($field['name']);
            if ($field['type'] == 'input') {
                $fields_html .= '<div class="form-group '.$class_div.'"><label for="'.$field['id_field'].'_'. $field['id'].'" class="control-label '.$class_lable.'">'.$field_name.'</label><input type="text" id="'.$field['id_field'].'_'. $field['id'].'" name="'.'fields[' . $field['_table'] . '][' . $field['id'] . ']'.'" class="form-control" value="'.$value.'"></div>';
            }

            $name = 'fields[' . $field['_table'] . '][' . $field['id'] . ']';
            if ($field['type'] == 'checkbox') {
                $name .= '[]';
            }

            $fields_html .= form_error($name);
            // Close column
            $fields_html .='</div>';

        }
        // close row
//        $fields_html .= '</div>';
    }

    return $fields_html;
}

