<?php
/**
 * @package WordPress
 * @subpackage Reales
 */

if( !function_exists('reales_admin_fields') ): 
    function reales_admin_fields() {
        add_settings_section( 'reales_fields_section', __( 'Property Custom Fileds', 'realeswp' ), 'reales_fields_section_callback', 'reales_fields_settings' );
    }
endif;

if( !function_exists('reales_fields_section_callback') ): 
    function reales_fields_section_callback() { 
        wp_nonce_field('add_custom_fields_ajax_nonce', 'securityAddCustomFields', true);

        print '<h4>' . __('Add New Custom Filed', 'realeswp') . '</h4>';
        print '<table class="form-table">
            <tbody>
                <tr>
                    <th scope="row">' . __('Field name', 'realeswp') . '</th>
                    <td>
                        <input type="text" size="40" name="custom_field_name" id="custom_field_name">
                    </td>
                </tr>
                <tr>
                    <th scope="row">' . __('Field label', 'realeswp') . '</th>
                    <td>
                        <input type="text" size="40" name="custom_field_label" id="custom_field_label">
                    </td>
                </tr>
                <tr>
                    <th scope="row">' . __('Field type', 'realeswp') . '</th>
                    <td>
                        <select name="custom_field_type" id="custom_field_type">
                            <option value="text_field">' . __('Text', 'realeswp') . '</option>
                            <option value="numeric_field">' . __('Numeric', 'realeswp') . '</option>
                            <option value="date_field">' . __('Date', 'realeswp') . '</option>
                            <option value="list_field">' . __('List', 'realeswp') . '</option>
                            <option value="interval_field">' . __('Interval', 'realeswp') . '</option>
                        </select>
                        <input type="text" size="40" name="custom_list_field_items" id="custom_list_field_items" style="display: none;">
                        <p class="help" style="display: none; margin-left: 96px;">' . __('Enter the list values separated by comma.', 'realeswp') . '</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">' . __('Mandatory', 'realeswp') . '</th>
                    <td>
                        <select name="custom_field_mandatory" id="custom_field_mandatory">
                            <option value="no">' . __('No', 'realeswp') . '</option>
                            <option value="yes">' . __('Yes', 'realeswp') . '</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row">' . __('Position', 'realeswp') . '</th>
                    <td>
                        <input type="text" size="4" name="custom_field_position" id="custom_field_position" value="0">
                    </td>
                </tr>
                <tr>
                    <th scope="row">' . __('Show in search', 'realeswp') . '</th>
                    <td>
                        <select name="custom_field_search" id="custom_field_search">
                            <option value="no">' . __('No', 'realeswp') . '</option>
                            <option value="yes">' . __('Yes', 'realeswp') . '</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row">' . __('Search comparison', 'realeswp') . '</th>
                    <td>
                        <select name="custom_field_comparison" id="custom_field_comparison">
                            <option value="equal">' . __('Equal', 'realeswp') . '</option>
                            <option value="greater">' . __('Greater', 'realeswp') . '</option>
                            <option value="smaller">' . __('Smaller', 'realeswp') . '</option>
                            <option value="like">' . __('Like', 'realeswp') . '</option>
                        </select>
                    </td>
                </tr>
            </tbody>
        </table>';
        print '<p class="submit"><input type="button" name="add_fields_btn" id="add_fields_btn" class="button button-secondary" value="' . __('Add Field', 'realeswp') . '">&nbsp;&nbsp;&nbsp;<span class="fa fa-spin fa-spinner preloader"></span></p>';

        print '<h4>' . __('Custom Fields List', 'realeswp') . '</h4>';
        print '<table class="table table-hover" id="customFieldsTable">
            <thead>
                <tr>
                    <th>' . __('Field name', 'realeswp') . '</th>
                    <th>' . __('Field label', 'realeswp') . '</th>
                    <th>' . __('Field type', 'realeswp') . '</th>
                    <th>' . __('Mandatory', 'realeswp') . '</th>
                    <th>' . __('Position', 'realeswp') . '</th>
                    <th>' . __('Show in search', 'realeswp') . '</th>
                    <th>' . __('Search comparison', 'realeswp') . '</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>';

        $options = get_option( 'reales_fields_settings' );
        if(is_array($options)) {
            uasort($options, "reales_compare_position");

            foreach ($options as $key => $value) {

                // Field name and label
                print '<tr>
                    <td><input type="text" name="reales_fields_settings[' . $key . '][name]" value="' . $value['name'] . '"></td>
                    <td><input type="text" name="reales_fields_settings[' . $key . '][label]" value="' . $value['label'] . '"></td>
                    <td>
                        <select class="table-field-type" name="reales_fields_settings[' . $key . '][type]">';

                // Field type
                print '<option value="text_field"';
                if(isset($value['type']) && $value['type'] == 'text_field') {
                    print ' selected ';
                }
                print '>' . __('Text', 'realeswp') . '</option>';

                print '<option value="numeric_field"';
                if(isset($value['type']) && $value['type'] == 'numeric_field') {
                    print ' selected ';
                }
                print '>' . __('Numeric', 'realeswp') . '</option>';

                print '<option value="date_field"';
                if(isset($value['type']) && $value['type'] == 'date_field') {
                    print ' selected ';
                }
                print '>' . __('Date', 'realeswp') . '</option>';

                print '<option value="list_field"';
                if(isset($value['type']) && $value['type'] == 'list_field') {
                    print ' selected ';
                }
                print '>' . __('List', 'realeswp') . '</option>';

                print '<option value="interval_field"';
                if(isset($value['type']) && $value['type'] == 'interval_field') {
                    print ' selected ';
                }
                print '>' . __('Interval', 'realeswp') . '</option>';

                print '</select>';

                print '<input type="text" name="reales_fields_settings[' . $key . '][list]" value="' . $value['list'] . '" style="display:none;" placeholder="' . __('Comma separated values', 'realeswp') . '">';

                print '</td>';

                // Field mandatory
                print '<td>
                        <select name="reales_fields_settings[' . $key . '][mandatory]">';

                print '<option value="no"';
                if(isset($value['mandatory']) && $value['mandatory'] == 'no') {
                    print ' selected ';
                }
                print '>' . __('No', 'realeswp') . '</option>';

                print '<option value="yes"';
                if(isset($value['mandatory']) && $value['mandatory'] == 'yes') {
                    print ' selected ';
                }
                print '>' . __('Yes', 'realeswp') . '</option>';

                print '</select></td>';

                // Field position
                print '<td><input type="text" size="4" name="reales_fields_settings[' . $key . '][position]" value="' . $value['position'] . '"></td>';

                // Field show in search
                print '<td>
                        <select name="reales_fields_settings[' . $key . '][search]">';

                print '<option value="no"';
                if(isset($value['search']) && $value['search'] == 'no') {
                    print ' selected ';
                }
                print '>' . __('No', 'realeswp') . '</option>';

                print '<option value="yes"';
                if(isset($value['search']) && $value['search'] == 'yes') {
                    print ' selected ';
                }
                print '>' . __('Yes', 'realeswp') . '</option>';

                print '</select></td>';

                // Field search comparison
                print '<td>
                        <select name="reales_fields_settings[' . $key . '][comparison]">';

                print '<option value="equal"';
                if(isset($value['comparison']) && $value['comparison'] == 'equal') {
                    print ' selected ';
                }
                print '>' . __('Equal', 'realeswp') . '</option>';

                print '<option value="greater"';
                if(isset($value['comparison']) && $value['comparison'] == 'greater') {
                    print ' selected ';
                }
                print '>' . __('Greater', 'realeswp') . '</option>';

                print '<option value="smaller"';
                if(isset($value['comparison']) && $value['comparison'] == 'smaller') {
                    print ' selected ';
                }
                print '>' . __('Smaller', 'realeswp') . '</option>';

                print '<option value="like"';
                if(isset($value['comparison']) && $value['comparison'] == 'like') {
                    print ' selected ';
                }
                print '>' . __('Like', 'realeswp') . '</option>';

                print '</select></td>';

                // Field delete
                print '<td><a href="javascript:void(0);" data-row="' . $key . '" class="delete-field">' . __('Delete', 'realeswp') . ' <span class="fa fa-spin fa-spinner preloader"></span></a></td>';
                print '</tr>';
            }
        }

        print '</tbody></table>';
    }
endif;

if( !function_exists('reales_add_custom_fields') ): 
    function reales_add_custom_fields () {
        check_ajax_referer('add_custom_fields_ajax_nonce', 'security');
        $name        = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
        $label       = isset($_POST['label']) ? sanitize_text_field($_POST['label']) : '';
        $type        = isset($_POST['type']) ? sanitize_text_field($_POST['type']) : '';
        $list        = isset($_POST['list']) ? sanitize_text_field($_POST['list']) : '';
        $mandatory   = isset($_POST['mandatory']) ? sanitize_text_field($_POST['mandatory']) : '';
        $position    = isset($_POST['position']) ? sanitize_text_field($_POST['position']) : '';
        $search      = isset($_POST['search']) ? sanitize_text_field($_POST['search']) : '';
        $comparison  = isset($_POST['comparison']) ? sanitize_text_field($_POST['comparison']) : '';

        if($name == '') {
            echo json_encode(array('add'=>false, 'message'=>__('Field name is mandatory.', 'realeswp')));
            exit();
        }
        if($label == '') {
            echo json_encode(array('add'=>false, 'message'=>__('Field label is mandatory.', 'realeswp')));
            exit();
        }
        if($type == '') {
            echo json_encode(array('add'=>false, 'message'=>__('Field type is mandatory.', 'realeswp')));
            exit();
        }
        if($type != '' && $type == 'list_field' && $list == '') {
            echo json_encode(array('add'=>false, 'message'=>__('The list requires at least one element.', 'realeswp')));
            exit();
        }
        if($position == '') {
            echo json_encode(array('add'=>false, 'message'=>__('Position is mandatory.', 'realeswp')));
            exit();
        }

        $var_name = str_replace(' ', '_', trim($name));
        $var_name = sanitize_key($var_name);

        $reales_fields_settings = get_option('reales_fields_settings');

        if(!is_array($reales_fields_settings)) {
            $reales_fields_settings = array();
        }

        $reales_fields_settings[$var_name]['name']        = $name;
        $reales_fields_settings[$var_name]['label']       = $label;
        $reales_fields_settings[$var_name]['type']        = $type;
        $reales_fields_settings[$var_name]['list']        = $list;
        $reales_fields_settings[$var_name]['mandatory']   = $mandatory;
        $reales_fields_settings[$var_name]['position']    = $position;
        $reales_fields_settings[$var_name]['search']      = $search;
        $reales_fields_settings[$var_name]['comparison']  = $comparison;
        update_option('reales_fields_settings', $reales_fields_settings);

        echo json_encode(array('add'=>true));
        exit();

        die();
    }
endif;
add_action( 'wp_ajax_nopriv_reales_add_custom_fields', 'reales_add_custom_fields' );
add_action( 'wp_ajax_reales_add_custom_fields', 'reales_add_custom_fields' );

if( !function_exists('reales_delete_custom_fields') ): 
    function reales_delete_custom_fields () {
        check_ajax_referer('add_custom_fields_ajax_nonce', 'security');
        $field_name = isset($_POST['field_name']) ? sanitize_text_field($_POST['field_name']) : '';

        $reales_fields_settings = get_option('reales_fields_settings');
        unset($reales_fields_settings[$field_name]);
        update_option('reales_fields_settings', $reales_fields_settings);

        echo json_encode(array('delete'=>true));
        exit();

        die();
    }
endif;
add_action( 'wp_ajax_nopriv_reales_delete_custom_fields', 'reales_delete_custom_fields' );
add_action( 'wp_ajax_reales_delete_custom_fields', 'reales_delete_custom_fields' );

?>