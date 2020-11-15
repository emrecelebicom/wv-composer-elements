<?php
/*
*  Plugin Name: WPBakery Custom Fields
*  Plugin URI: https://ofiss.com.tr/plugins/
*  Description: An extension for Visual Composer that display an community directory option
*  Author: Emre Çelebi
*  Author URI: https://emrecelebi.com
*  Version: 0.1.1
*/

class dropdown
{

    /* Dropdown Element */
    function view($group, $heading, $param, $value, $selected, $description, $class, $is_multiple){

        return [

            /* Default Items */
            'type' => $is_multiple ? 'dropdown_multi' : 'dropdown',

            /* Element Group */
            'group' => $group,

            /* Element Header */
            'heading' => $heading,

            /* Element Param Name */
            'param_name' => $param,

            /* Element Value */
            'value' => $value,

            /* Element Selected */
            'std' => $selected,

            /* Element Description */
            'description' => $description,

            /* Element Classname */
            'class' => $class

        ];
    }
}