<?php
/*
*  Plugin Name: WPBakery Custom Fields
*  Plugin URI: https://ofiss.com.tr/plugins/
*  Description: An extension for Visual Composer that display an community directory option
*  Author: Emre Çelebi
*  Author URI: https://emrecelebi.com
*  Version: 0.1.1
*/

vc_add_shortcode_param('dropdown_multi', 'dropdown_multi_settings_field');
function dropdown_multi_settings_field($param, $value)
{
    $param_line = '';
    $param_line .=
        '<select multiple name="' .
        esc_attr($param['param_name']) .
        '" class="wpb_vc_param_value wpb-input wpb-select ' .
        esc_attr($param['param_name']) .
        ' ' .
        esc_attr($param['type']) .
        '">';
    foreach ($param['value'] as $text_val => $val) {
        if (
            is_numeric($text_val) &&
            (is_string($val) || is_numeric($val))
        ) {
            $text_val = $val;

            $category = get_term_by( 'term_id', $val, 'product_cat' );
            $text_name = $category->name;
        }
        $text_val = __($text_val, 'js_composer');
        $text_name = __($text_name, 'js_composer');
        $selected = '';

        if (!is_array($value)) {
            $param_value_arr = explode(',', $value);
        } else {
            $param_value_arr = $value;
        }

        if ($value !== '' && in_array($val, $param_value_arr)) {
            $selected = ' selected="selected"';
        }
        $param_line .=
            '<option class="' .
            $val .
            '" value="' .
            $val .
            '"' .
            $selected .
            '>' .
            $text_name .
            '</option>';
    }
    $param_line .= '</select>';

    return $param_line;
}