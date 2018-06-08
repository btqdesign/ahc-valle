<?php

// arrowpress_product
add_shortcode('arrowpress_product', 'arrowpress_shortcode_product');
add_action('vc_build_admin_page', 'arrowpress_load_product_shortcode');
add_action('vc_after_init', 'arrowpress_load_product_shortcode');

function arrowpress_shortcode_product($atts, $content = null) {
    ob_start();
    if ($template = arrowpress_shortcode_woo_template('arrowpress_product'))
        include $template;
    return ob_get_clean();
}

function arrowpress_load_product_shortcode() {
    $custom_class = arrowpress_vc_custom_class();
    $order_by_values = arrowpress_vc_woo_order_by();
    $order_way_values = arrowpress_vc_woo_order_way();
    vc_map( array(
        'name' => "ArrowPress " . esc_html__('Product', 'arrowpress-shortcodes'),
        'base' => 'arrowpress_product',
        'category' => esc_html__('ArrowPress', 'arrowpress-shortcodes'),
        'icon' => 'arrowpress_vc_icon',
        'weight' => - 50,
        "params" => array( 
            array(
                'type' => 'textfield',
                'heading' => __( 'Title', 'arrowpress-shortcodes' ),
                'param_name' => 'title',
                'admin_label' => true
            ),
            array(
                'type' => 'textfield',
                'heading' => __( 'Per page', 'arrowpress-shortcodes' ),
                'value' => 12,
                'param_name' => 'per_page',
                'description' => __( 'The "per_page" shortcode determines how many products to show on the page', 'arrowpress-shortcodes' ),
            ),
            array(
                'type' => 'dropdown',
                'heading' => __( 'Columns', 'arrowpress-shortcodes' ),
                'param_name' => 'columns',
                'dependency' => Array('element' => 'view', 'value' => array( 'products-slider', 'grid' )),
                'std' => '4',
                'value' => arrowpress_sh_commons('products_columns')
            ),
            array(
                'type' => 'dropdown',
                'heading' => __( 'Order by', 'arrowpress-shortcodes' ),
                'param_name' => 'orderby',
                'value' => $order_by_values,
                'description' => sprintf( __( 'Select how to sort retrieved products. More at %s.', 'arrowpress-shortcodes' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
            ),
            array(
                'type' => 'dropdown',
                'heading' => __( 'Order way', 'arrowpress-shortcodes' ),
                'param_name' => 'order',
                'value' => $order_way_values,
                'description' => sprintf( __( 'Designates the ascending or descending order. More at %s.', 'arrowpress-shortcodes' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
            ),
            $custom_class
        )
    ) );

    if (!class_exists('WPBakeryShortCode_ArrowPress_Product')) {
        class WPBakeryShortCode_ArrowPress_Product extends WPBakeryShortCode {
        }
    }
}