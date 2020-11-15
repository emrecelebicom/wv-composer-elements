<?php
/*
*  Plugin Name: WPBakery Custom Fields
*  Plugin URI: https://ofiss.com.tr/plugins/
*  Description: An extension for Visual Composer that display an community directory option
*  Author: Emre Çelebi
*  Author URI: https://emrecelebi.com
*  Version: 0.1.1
*/

class Layout{

    function view($title, $params, $atts)
    {

        $list = $this->get($params, $atts);

        return "
            <div class=\"container-fluid\">
            
                <div class=\"row products-header\">
                    <div class=\"col-xl-8 col-md-8 col-sm-8 col-8\">
                        " . $title . "
                    </div>
                    <div class=\"col-xl-4 col-md-4 col-sm-4 col-4 text-right\">
                        <a href=\"javascript:;\" class=\"btn\">".SEE_MORE."</a>
                    </div>
                </div>
                
                <div class=\"row products-body\">
                    ". $list ."
                </div>
                
            </div>
        ";
    }

    /* Products Get */
    function get($params, $atts)
    {

        $query = new WP_Query($params);

        if ($query->have_posts()):

            /* Advert */
            $order_key = 1;
            $advert_order = !$atts['advert_order'] ? 0 : (int) $atts['advert_order'];

            while ($query->have_posts()):
                $query->the_post();

                $product = new WC_Product(get_the_ID());

                if($advert_order != $order_key) {

                    /* Output */
                    $output .=
                        "
                        <div class=\"col-xl-3 col-md-6 col-sm-6 col-6 product-area\">
                            <div class=\"product-item\">
                                <a href=\"" .
                                    esc_url(get_permalink()) .
                                    "\">
                                    <div class=\"img-area\">".$this->image($query, 'medium')."</div>
                                    <div class=\"text-area\">
                                        <span class=\"delivery free\">Free delivery</span>
                                        <h3>" . get_the_title() . "</h3>
                                        <div class=\"price-area only-one-price\">
                                        " . $this->price($product) . "
                                        </div>
                                    </div>
                                </a>
                                ".$this->badge($product, "info")."
                                <div class=\"favorites\"><img src=\"ets/img/icons/red-favorites-icon.svg\" alt=\"\" width=\"20\"></div>
            
                            </div>
                        </div>
                        ";

                }else{

                    /* Output Advert */
                    $image = wp_get_attachment_image_src($atts['advert_image'], 'large');

                    $output .= "
                        <div class=\"col-xl-3 col-md-6 col-sm-6 col-6 product-area\">
                            <div class=\"product-item\">
                                <a href=\"".$atts['advert_url']."\">
                                    <div class=\"img-area adver-area\">
                                        <img src=\"".$image[0]."\" alt=\"\">
                                    </div>
                                </a>
                            </div>
                        </div>
                    ";

                }

                $order_key++;
            endwhile;

            wp_reset_postdata();

            return $output;
        else:
            _e('No Products');
        endif;
    }


    /* Product Image */
    function image($query, $size)
    {
        /* Product Image */
        $image = get_the_post_thumbnail(
            $query->post->ID,
            $size
        );

        return $image;
    }


    /* New Badge */
    function badge($item, $classname)
    {
        $created = strtotime( $item->get_date_created() );
        if ( ( time() - ( 60 * 60 * 24 * NEW_BADGE_DAY ) ) < $created ) {

            if($classname) $html_class = " class=\"".$classname."\"";

            return "
                <span".$html_class.">
                    ". esc_html__(NEW_BADGE_TITLE, 'woocommerce') ."
                </span>
            ";
        }
    }



    function price($item)
    {

        if(!empty($item->get_regular_price()) && !empty($item->get_sale_price())) {

            $regular_price = explode('.', $item->get_regular_price());
            $sale_price = explode('.', $item->get_sale_price());

            $percent = ($item->get_regular_price() - $item->get_sale_price()) / ($item->get_regular_price() / 100);
            $percent = number_format($percent, 0, ',', ' ');

            return "
                <span class=\"percent\">%" . $percent . "</span>
                
                <span class=\"price discount\">" . $regular_price[0] . '<small>,' .($regular_price[1] ? $regular_price[1] : '00') . " ".CURRENCY_CODE."</small></span>
                
                <span class=\"price\">" . $sale_price[0] . '<small>,' . ($sale_price[1] ? $sale_price[1] : '00') . " ".CURRENCY_CODE."</small></span>
            ";

        } else {

            $sale_price = explode('.', $item->get_price());

            return "
                <span class=\"price\">" . $sale_price[0] . '<small>,' . ($sale_price[1] ? $sale_price[1] : '00') . " ".CURRENCY_CODE."</small></span>
            ";

        }
    }

}