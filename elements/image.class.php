<?php
/*
*  Plugin Name: WPBakery Custom Fields
*  Plugin URI: https://ofiss.com.tr/plugins/
*  Description: An extension for Visual Composer that display an community directory option
*  Author: Emre Çelebi
*  Author URI: https://emrecelebi.com
*  Version: 0.1.1
*/

class image
{

    /* Picture Element */
    function view($group, $holder, $heading, $param, $class){

        return [
            /* Default Items */
            'type' => 'attach_image',

            /* Element Group */
            'group' => $group,

            /* Element Holder Key */
            'holder' => $holder,

            /* Element Header */
            'heading' => $heading,

            /* Element Param Name */
            'param_name' => $param,

            /* Element Classname */
            'class' => $class
        ];

    }
}