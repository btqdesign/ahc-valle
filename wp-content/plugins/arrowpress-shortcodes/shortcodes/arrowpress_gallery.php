<?php

// foodfarm_gallery
add_shortcode('arrowpress_gallery', 'arrowpress_shortcode_gallery');
add_action('vc_build_admin_page', 'arrowpress_load_gallery_shortcode');
add_action('vc_after_init', 'arrowpress_load_gallery_shortcode');

function arrowpress_shortcode_gallery($atts, $content = null) {
    ob_start();
    if ($template = arrowpress_shortcode_template('arrowpress_gallery'))
        include $template;
    return ob_get_clean();
}

function arrowpress_load_gallery_shortcode() {
    $custom_class = arrowpress_vc_custom_class();
    $order_by_values = arrowpress_vc_woo_order_by();
    $order_way_values = arrowpress_vc_woo_order_way();
    vc_map( array(
        'name' => "ArrowPress " . esc_html__('Gallery', 'arrowpress-shortcodes'),
        'base' => 'arrowpress_gallery',
        'category' => esc_html__('ArrowPress', 'arrowpress-shortcodes'),
        'icon' => 'arrowpress_vc_icon',
        'weight' => - 50,
        "params" => array(
            array(
                "type" => "dropdown",
                "heading" => esc_html__("Layout", 'arrowpress-shortcodes'),
                "param_name" => "layout",
                'std' => 'layout_1',
                'value' => array(
                    esc_html__('Grid', 'arrowpress-shortcodes') => 'grid',
                    esc_html__('Masonry', 'arrowpress-shortcodes') => 'masonry',
                ),
            ),            
            array(
                "type" => "textfield",
                "heading" => esc_html__("Number of gallery to show", 'arrowpress-shortcodes'),
                "param_name" => "number",
                "value" => "8",
                "admin_label" => true
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__("Category IDs", 'arrowpress-shortcodes'),
                "description" => esc_html__("comma separated list of category ids", 'arrowpress-shortcodes'),
                "param_name" => "cat",
                "admin_label" => true
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__( 'Order way', 'arrowpress-shortcodes' ),
                'param_name' => 'order',
                'value' => $order_way_values,
                'description' => sprintf( esc_html__( 'Designates the ascending or descending order. More at %s.', 'arrowpress-shortcodes' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
            ),

            array(
                "type" => "dropdown",
                "heading" => esc_html__("Gallery Columns", 'arrowpress-shortcodes'),
                "param_name" => "columns",
                'std' => 3,
                'value' => array(
                    esc_html__('2 Columns', 'arrowpress-shortcodes') => '2',
                    esc_html__('3 Columns', 'arrowpress-shortcodes') => '3',
                    esc_html__('4 Columns', 'arrowpress-shortcodes') => '4',
                ),
            ),
            array(
                "type" => "checkbox",
                "heading" => esc_html__("Show load more", 'arrowpress-shortcodes'),
                "param_name" => "show_viewmore",
                'value' => array(esc_html__('Yes', 'arrowpress-shortcodes') => 'yes')
            ),
            array(
                "type" => "checkbox",
                "heading" => esc_html__("Hide empty categories", 'arrowpress-shortcodes'),
                "param_name" => "hide_empty",
                'value' => array(esc_html__('Yes', 'arrowpress-shortcodes') => 'yes'),
                'std' => 'yes',
            ),            
            array(
                "type" => "dropdown",
                "heading" => esc_html__("Display category filter", 'arrowpress-shortcodes'),
                "param_name" => "display_filter",
                'std' => 'no',
                'value' => array(
                    esc_html__('Yes', 'arrowpress-shortcodes') => 'yes',
                    esc_html__('No', 'arrowpress-shortcodes') => 'no',
                ),

            ),             
            array(
                'type' => 'checkbox',
                'heading' => esc_html__("Item delay", 'arrowpress-shortcodes'),
                'param_name' => 'item_delay',
                'std' => 'yes',
                'value' => array( esc_html__( 'Yes', 'arrowpress-shortcodes' ) => 'yes' )
            ),
            $custom_class
        )
    ) );

    if (!class_exists('WPBakeryShortCode_Arrowpress_Gallery')) {
        class WPBakeryShortCode_Arrowpress_Gallery extends WPBakeryShortCode {
        }
    }
}