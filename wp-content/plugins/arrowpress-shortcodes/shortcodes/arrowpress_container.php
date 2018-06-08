<?php

// arrowpress Container
add_shortcode('arrowpress_container', 'arrowpress_shortcode_container');
add_action('vc_build_admin_page', 'arrowpress_load_container_shortcode');
add_action('vc_after_init', 'arrowpress_load_container_shortcode');

function arrowpress_shortcode_container($atts, $content = null) {
    ob_start();
    if ($template = arrowpress_shortcode_template('arrowpress_container'))
        include $template;
    return ob_get_clean();
}

function arrowpress_load_container_shortcode() {
    $custom_class = arrowpress_vc_custom_class();
    vc_map( array(
        "name" => "ArrowPress " . esc_html__("Container", 'arrowpress-shortcodes'),
        "base" => "arrowpress_container",
        "category" => esc_html__("ArrowPress", 'arrowpress-shortcodes'),
        "icon" => "arrowpress_vc_container",
        'is_container' => true,
        'weight' => - 50,
        "show_settings_on_create" => false,
        'js_view' => 'VcColumnView',
        "params" => array(
            array(
                "type" => "dropdown",
                "heading" => esc_html__("Container Type", 'arrowpress-shortcodes'),
                "param_name" => "container_type",
                'std' => 1,
                'value' => array(
                    esc_html__('Default Container', 'arrowpress-shortcodes') => '1',
                    esc_html__('Container Fluid', 'arrowpress-shortcodes') => '2',
                    esc_html__('Bigger Container', 'arrowpress-shortcodes') => '3',
                ),
            ),
            array(
                'type' => 'checkbox',
                'heading' => esc_html__("Item delay", "arrowpress"),
                'param_name' => 'item_delay',
                'value' => array( esc_html__( 'Yes', 'arrowpress-shortcodes' ) => 'yes' )
            ),
            $custom_class
        )
    ) );

    if (!class_exists('WPBakeryShortCode_ArrowPress_Container')) {
        class WPBakeryShortCode_ArrowPress_Container extends WPBakeryShortCodesContainer {
        }
    }
}