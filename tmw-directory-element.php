<?php
/*
*  Plugin Name: WPBakery Custom Fields
*  Plugin URI: https://ofiss.com.tr/plugins/
*  Description: An extension for Visual Composer that display an community directory option
*  Author: Emre Çelebi
*  Author URI: https://emrecelebi.com
*  Version: 0.1.1
*/

if (!defined('ABSPATH')) {
    die('Silly human what are you doing here');
}

if (!class_exists('vcInfoBox')) {
    class vcInfoBox
    {
        /* Main constructor */
        public function __construct()
        {
            // Registers the shortcode in WordPress
            add_shortcode('info-box-shortcode', ['vcInfoBox', 'output']);

            // Map shortcode to Visual Composer
            if (function_exists('vc_lean_map')) {
                vc_lean_map('info-box-shortcode', ['vcInfoBox', 'map']);
            }

            /* Multiple Dropdown Functions */
            require_once plugin_dir_path(__FILE__) . 'functions/dropdown-multiple.php';

            /* Configurations */
            require_once plugin_dir_path( __FILE__ ) . "config.php";

        }

        /* Map shortcode to VC */

        public static function map()
        {
            /* Categories Function */
            require_once plugin_dir_path(__FILE__) . 'functions/categories.php';

            /* Elements */
            require_once plugin_dir_path(__FILE__) . 'elements/elements.class.php';
            $element = new element();

            return [
                'name' => esc_html__('All Products', 'text-domain'),
                'description' => esc_html__('Listing products sections', 'text-domain'),
                'base' => 'vc_infobox',
                'category' => __('Elements', 'text-domain'),
                'icon' => plugin_dir_path(__FILE__) . 'assets/img/products.png',
                'params' => [

                    $element->textbox->view(
                        'Title',
                        'h3',
                        'Title',
                        'title',
                        '',
                        'element_text'
                    ),

                    $element->textbox->view(
                        'Title',
                        'h3',
                        'Description',
                        'description',
                        '',
                        'element_text'
                    ),

                    $element->textarea->view(
                        'Title',
                        'div',
                        'Content',
                        'content',
                        '',
                        'element_textarea'
                    ),

                    $element->dropdown->view(
                        'Products',
                        'Product Categories',
                        'selected_categories',
                        $product_categories,
                        '',
                        'Showing product categories.',
                        'element_dropdown_multiple',
                        true
                    ),

                    $element->dropdown->view(
                        'Products',
                        'Exlude Product Categories',
                        'exlude_categories',
                        $product_categories,
                        '',
                        'Showing product categories.',
                        'element_dropdown_multiple',
                        true
                    ),

                    $element->dropdown->view(
                        'Products',
                        'View Products',
                        'view_products',
                        [
                            'All Products' => 'all',
                            'New Products' => 'new',
                            'Discounted Products' => 'discounted',
                            'Popular Products' => 'popular',
                        ],
                        'all',
                        'Choose special products.',
                        'element_dropdown',
                        false
                    ),

                    $element->textbox->view(
                        'Products',
                        'h3',
                        'Limit',
                        'limit',
                        '12',
                        'element_text'
                    ),

                    $element->dropdown->view(
                        'Products',
                        'OrderBy',
                        'orderby',
                        [
                            'id' => 'id',
                            'name' => 'name',
                            'date' => 'date',
                        ],
                        'id',
                        'Choose order selection.',
                        'element_dropdown',
                        false
                    ),

                    $element->dropdown->view(
                        'Products',
                        'Order',
                        'order',
                        [
                            'asc' => 'asc',
                            'desc' => 'desc',
                        ],
                        'desc',
                        'Choose order status.',
                        'element_dropdown',
                        false
                    ),

                    $element->image->view(
                        'Advert',
                        'img',
                        'Advert Image',
                        'advert_image',
                        ''
                    ),

                    $element->textbox->view(
                        'Advert',
                        'h3',
                        'Advert URI',
                        'advert_uri',
                        '',
                        'element_text'
                    ),

                    $element->textbox->view(
                        'Advert',
                        'h3',
                        'Advert Order',
                        'advert_order',
                        '',
                        'element_text'
                    ),

                ],
            ];
        }

        /* Shortcode output */
        public static function output($atts, $content = null)
        {
            extract(
                shortcode_atts(
                    [
                        'title' => '',
                        'limit' => '',
                        'selected_categories' => [],
                        'exlude_categories' => [],
                        'view-products' => '',
                        'order' => '',
                        'orderby' => '',
                        'advert_image' => 'advert_image',
                        'advert_url' => '',
                        'advert_order' => ''
                    ],
                    $atts
                )
            );

            $selected_categories = $selected_categories ? explode(',', $selected_categories) : null;
            $exlude_categories = $exlude_categories ? explode(',', $exlude_categories) : null;

            $params = [
                'post_status' => 'publish',
                'posts_per_page' => (int) (!$limit ? '12' : $limit),
                'post_type' => ['product', 'product_variation'],
                'orderby' => !$orderby ? 'id' : $orderby,
                'order' => !$order ? 'desc' : $order,
                'tax_query' => array(
                    'relation' => 'AND',
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'term_id',
                        'terms' => $selected_categories,
                        'operator' => 'IN',
                    ),
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'term_id',
                        'terms' => $exlude_categories,
                        'operator' => 'NOT IN',
                    ),
                )
            ];

            /* Theme Layout */
            require_once plugin_dir_path(__FILE__) . "view/".THEME_NAME."/".THEME_NAME.".php";
            $layout = new Layout();

            return $layout->view($title, $params, $atts);



        }
    }
}
new vcInfoBox();
