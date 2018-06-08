<?php

// arrowpress instagram feed
add_shortcode('arrowpress_instagram_feed', 'arrowpress_shortcode_instagram_feed');
add_action('vc_build_admin_page', 'arrowpress_load_instagram_feed_shortcode');
add_action('vc_after_init', 'arrowpress_load_instagram_feed_shortcode');

function arrowpress_shortcode_instagram_feed($atts, $content = null) {
    ob_start();
    if ($template = arrowpress_shortcode_template('arrowpress_instagram_feed'))
        include $template;
    return ob_get_clean();
}

function arrowpress_load_instagram_feed_shortcode() {
    $custom_class = arrowpress_vc_custom_class();
    vc_map( array(
        'name' => "Arrowpress " . esc_html__('Instagram Feed', 'arrowpress-shortcodes'),
        'base' => 'arrowpress_instagram_feed',
        'category' => esc_html__('ArrowPress', 'arrowpress-shortcodes'),
        'icon' => 'arrowpress_vc_icon',
        'weight' => - 50,
        "params" => array(
            array(
                "type" => "textfield",
                "heading" => esc_html__("Per page", 'arrowpress-shortcodes'),
                "param_name" => "per_page",
                "value" => esc_html__("12", 'arrowpress-shortcodes'),
                'description' => esc_html__('This field  determines how many blogs to show on the page', 'arrowpress-shortcodes')
            ),
            $custom_class
        )
    ) );

    if (!class_exists('WPBakeryShortCode_Arrowpress_Instagram_Feed')) {
        class WPBakeryShortCode_Arrowpress_Instagram_Feed extends WPBakeryShortCode {
        }
    }
}