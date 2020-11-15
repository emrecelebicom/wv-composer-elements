<?php
/*
*  Plugin Name: WPBakery Custom Fields
*  Plugin URI: https://ofiss.com.tr/plugins/
*  Description: An extension for Visual Composer that display an community directory option
*  Author: Emre Çelebi
*  Author URI: https://emrecelebi.com
*  Version: 0.1.1
*/

if(!defined('ABSPATH')){
     die('Silly human what are you doing here');
}

/* Elements Content */
add_action('vc_before_init', 'wpc_vc_before_init_actions');
function wpc_vc_before_init_actions(){
     include (plugin_dir_path( __FILE__ ) . 'tmw-directory-element.php');
}

/* Styles&Scripts */
function wpc_community_directory_scripts(){
     wp_enqueue_style( 'wpc_community_directory_stylesheet',  plugin_dir_url( __FILE__ ) . 'assets/css/style.css' );
}
add_action('wp_enqueue_scripts', 'wpc_community_directory_scripts');