<?php

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

            vc_add_shortcode_param(
                'dropdown_multi',
                'dropdown_multi_settings_field'
            );
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
        }

        /* Map shortcode to VC */

        //This is an array of all your settings which become the shortcode attributes ($atts) for the output.

        public static function map()
        {
            $product_categories = [];
            $categroies = get_terms([
                'taxonomy' => 'product_cat',
                'hide_empty' => false,
            ]);

            foreach ($categroies as $item) {
                array_push($product_categories, $item->term_id);
            }

            return [
                'name' => esc_html__('Products', 'text-domain'),
                'description' => esc_html__('Listing Products', 'text-domain'),
                'base' => 'vc_infobox',
                'category' => __('TMW Elements', 'text-domain'),
                'icon' => plugin_dir_path(__FILE__) . 'assets/img/products.png',
                'params' => [
                    [
                        'type' => 'textfield',
                        'holder' => 'h3',
                        'class' => 'title-class',
                        'heading' => __('Title', 'text-domain'),
                        'param_name' => 'title',
                        'value' => __('', 'text-domain'),
                        'admin_label' => false,
                        'weight' => 0,
                        'group' => 'Title',
                    ],

                    [
                        'type' => 'textfield',
                        'holder' => 'h3',
                        'class' => 'description-class',
                        'heading' => __('Description', 'text-domain'),
                        'param_name' => 'description',
                        'value' => __('', 'text-domain'),
                        'admin_label' => false,
                        'weight' => 0,
                        'group' => 'Title',
                    ],

                    [
                        'type' => 'textarea_html',
                        'holder' => 'div',
                        'class' => 'wpc-text-class',
                        'heading' => __('Content', 'text-domain'),
                        'param_name' => 'content',
                        'value' => __('', 'text-domain'),
                        'description' => __(
                            'To add link highlight text or url and click the chain to apply hyperlink',
                            'text-domain'
                        ),
                        // 'admin_label' => false,
                        // 'weight' => 0,
                        'group' => 'Title',
                    ],

                    [
                        'type' => 'dropdown_multi',
                        'heading' => __('Product Categroies', 'text-domain'),
                        'param_name' => 'selected_categories',
                        'admin_label' => true,
                        'value' => $product_categories,
                        'std' => '',
                        'description' => __('Showing product categories'),
                        'group' => 'Products',
                    ],

                    [
                        'type' => 'dropdown_multi',
                        'heading' => __('Exlude Product Categroies', 'text-domain'),
                        'param_name' => 'exlude_categories',
                        'admin_label' => true,
                        'value' => $product_categories,
                        'std' => '',
                        'description' => __('Showing product categories'),
                        'group' => 'Products',
                    ],
                    [
                        'type' => 'textfield',
                        'holder' => 'h3',
                        'class' => 'limit-class',
                        'heading' => __('Limit', 'get-products', 'text-domain'),
                        'param_name' => 'limit',
                        'value' => __('12', 'text-domain'),
                        'admin_label' => false,
                        'weight' => 0,
                        'group' => 'Products',
                    ],
                    [
                        'type' => 'dropdown',
                        'heading' => __('OrderBy', 'text-domain'),
                        'param_name' => 'orderby',
                        'admin_label' => true,
                        'value' => [
                            'id' => 'id',
                            'name' => 'name',
                            'date' => 'date',
                        ],
                        'std' => 'id',
                        'description' => __('Choose order selection'),
                        'group' => 'Products',
                    ],
                    [
                        'type' => 'dropdown',
                        'heading' => __('Order Status', 'text-domain'),
                        'param_name' => 'order',
                        'admin_label' => true,
                        'value' => [
                            'asc' => 'asc',
                            'desc' => 'desc',
                        ],
                        'std' => 'asc',
                        'description' => __('Choose order status'),
                        'group' => 'Products',
                    ],

                    [
                        'type' => 'attach_image',
                        'holder' => 'img',
                        'heading' => __('Advert Image', 'text-domain'),
                        'param_name' => 'advert_image',
                        // 'value' => __( 'Default value', 'text-domain' ),
                        'admin_label' => false,
                        'weight' => 0,
                        'group' => 'Advert',
                    ],

                    [
                        'type' => 'textfield',
                        'holder' => 'h3',
                        'class' => 'advert-url-class',
                        'heading' => __('Advert URL', 'text-domain'),
                        'param_name' => 'advert_url',
                        'value' => __('', 'text-domain'),
                        'admin_label' => false,
                        'weight' => 0,
                        'group' => 'Advert',
                    ],

                    [
                        'type' => 'textfield',
                        'holder' => 'h3',
                        'class' => 'advert-order-class',
                        'heading' => __('Advert Order', 'text-domain'),
                        'param_name' => 'advert_order',
                        'value' => __('', 'text-domain'),
                        'admin_label' => false,
                        'weight' => 0,
                        'group' => 'Advert',
                    ],
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
                        'order' => '',
                        'orderby' => '',
                        'advert_image' => 'advert_image',
                        'advert_url' => '',
                        'advert_order' => ''
                    ],
                    $atts
                )
            );

            $advert_img = wp_get_attachment_image_src($advert_image, 'large');

            $selected_categories = explode(',', $selected_categories);
            $exlude_categories = explode(',', $exlude_categories);

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

            $wc_query = new WP_Query($params);

            $output = "<div class=\"container-fluid\">";

            $output .=
                "
            <div class=\"row products-header\">
                <div class=\"col-xl-8 col-md-8 col-sm-8 col-8\">
                    " .
                $title .
                "
                </div>
                <div class=\"col-xl-4 col-md-4 col-sm-4 col-4 text-right\">
                    <a href=\"javascript:;\" class=\"btn\">See more</a>
                </div>
            </div>
            ";

            $output .= "<div class=\"row products-body\">";

            if ($wc_query->have_posts()):

                $order = 1;
                $advert_order = !$advert_order ? 4 : $advert_order;

                while ($wc_query->have_posts()):
                    $wc_query->the_post();

                    $product = new WC_Product(get_the_ID());

                    /* Product Image */
                    $image = get_the_post_thumbnail(
                        $wc_query->post->ID,
                        'medium'
                    );

                    /* New Product */
                    $news_days = 30;
                    $created = strtotime( $product->get_date_created() );
                    if ( ( time() - ( 60 * 60 * 24 * $news_days ) ) < $created ) {
                        $new_product = "<div class=\"info\">".esc_html__( 'New', 'woocommerce' )."</div>";
                    }

                    /* Product Price */
                    if (
                        !empty($product->get_regular_price()) and
                        !empty($product->get_sale_price())
                    ) {
                        $regular_price = explode(
                            '.',
                            $product->get_regular_price()
                        );
                        $sale_price = explode('.', $product->get_sale_price());

                        $percent =
                            ($product->get_regular_price() -
                                $product->get_sale_price()) /
                            ($product->get_regular_price() / 100);

                        $price =
                            "
                            <span class=\"percent\">%" .
                            $percent .
                            "</span>
                            <span class=\"price discount\">" .
                            $regular_price[0] .
                            '<small>,' .
                            ($regular_price[1] ? $regular_price[1] : '00') .
                            " &#8380;</small></span>
                        <span class=\"price\">" .
                            $sale_price[0] .
                            '<small>,' .
                            ($sale_price[1] ? $sale_price[1] : '00') .
                            " &#8380;</small></span>
                        ";
                    } else {
                        $sale_price = explode('.', $product->get_price());
                        $price =
                            "
                            <span class=\"price\">" .
                            $sale_price[0] .
                            '<small>,' .
                            ($sale_price[1] ? $sale_price[1] : '00') .
                            "&#8380; </small></span>
                        ";
                    }

                    if($advert_order != $order) {

                        /* Output */
                        $output .=
                            "
            <div class=\"col-xl-3 col-md-6 col-sm-6 col-6 product-area\">
                <div class=\"product-item\">
                    <a href=\"" .
                            esc_url(get_permalink()) .
                            "\">
                        <div class=\"img-area\">
                            <img src=\"" .
                            $image .
                            "\" alt=\"\">
                        </div>
                        <div class=\"text-area\">
                            <span class=\"delivery free\">Free delivery</span>
                            <h3>" .
                            get_the_title() .
                            "</h3>
                            <div class=\"price-area only-one-price\">
                            " .
                            $price .
                            "
                            </div>
                        </div>
                    </a>
                    ".$new_product."
                    <div class=\"favorites\"><img src=\"ets/img/icons/red-favorites-icon.svg\" alt=\"\" width=\"20\"></div>

                </div>
            </div>
            ";
                    }else{

                        /* Output Advert */
                        $output .= "
                            <div class=\"col-xl-3 col-md-6 col-sm-6 col-6 product-area\">
                                <div class=\"product-item\">
                                    <a href=\"".$advert_url."\">
                                        <div class=\"img-area adver-area\">
                                            <img src=\"".$advert_img[0]."\" alt=\"\">
                                        </div>
                                    </a>
                                </div>
                            </div>
                        ";

                    }


                endwhile;

                wp_reset_postdata();
            else:
                //_e('No Products');
            endif;

            $output .= '</div>';

            $output .= '</div>';

            return $output;
        }
    }
}
new vcInfoBox();
