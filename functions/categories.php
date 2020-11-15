<?php
/*
*  Plugin Name: WPBakery Custom Fields
*  Plugin URI: https://ofiss.com.tr/plugins/
*  Description: An extension for Visual Composer that display an community directory option
*  Author: Emre Çelebi
*  Author URI: https://emrecelebi.com
*  Version: 0.1.1
*/

$product_categories = [];
$categroies = get_terms([
    'taxonomy' => 'product_cat',
    'hide_empty' => false,
]);

foreach ($categroies as $item) {
    array_push($product_categories, $item->term_id);
}