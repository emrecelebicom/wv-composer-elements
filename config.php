<?php
/*
*  Plugin Name: WPBakery Custom Fields
*  Plugin URI: https://ofiss.com.tr/plugins/
*  Description: An extension for Visual Composer that display an community directory option
*  Author: Emre Çelebi
*  Author URI: https://emrecelebi.com
*  Version: 0.1.1
*/

define('THEME_NAME', 'layout');

define('NEW_BADGE_TITLE', tmw_get_option('opt-languages')[ pll_current_language().'-new-badge-text']);
define('SEE_MORE', tmw_get_option('opt-languages')[ pll_current_language().'-see-more']);
define('NEW_BADGE_DAY', tmw_get_option('product-badge-new-day'));
define('CURRENCY_CODE', tmw_get_option('filter-price-currency'));