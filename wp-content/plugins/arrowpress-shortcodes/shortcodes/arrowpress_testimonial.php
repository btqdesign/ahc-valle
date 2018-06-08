<?php

// arrowpress_testimonial
add_shortcode('arrowpress_testimonial', 'arrowpress_shortcode_testimonial');
add_action('vc_build_admin_page', 'arrowpress_load_testimonial_shortcode');
add_action('vc_after_init', 'arrowpress_load_testimonial_shortcode');

function arrowpress_shortcode_testimonial($atts, $content = null) {
    ob_start();
    if ($template = arrowpress_shortcode_template('arrowpress_testimonial'))
        include $template;
    return ob_get_clean();
}

function arrowpress_load_testimonial_shortcode() {
    $animation_type = arrowpress_vc_animation_type();
    $custom_class = arrowpress_vc_custom_class();

    vc_map( array(
        'name' => "ArrowPress" . esc_html__(' Testimonial', 'arrowpress-shortcodes'),
        'base' => 'arrowpress_testimonial',
        'category' => esc_html__('ArrowPress', 'arrowpress-shortcodes'),
        'icon' => 'arrowpress_vc_icon',
        'weight' => - 50,
        "params" => array(
            array(
                "type" => "textfield",
                "heading" => esc_html__("Name", 'arrowpress-shortcodes'),
                "param_name" => "name_author",
                "admin_label" => true,
            ),
            array(
                "type" => "textarea",
                "heading" => esc_html__("Description", "arrowpress"),
                "param_name" => "description",
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__("Additional Information", 'arrowpress-shortcodes'),
                "param_name" => "info",
            ),
            array(
                'type' => 'attach_image',
                'heading' => esc_html__('Image', 'arrowpress-shortcodes'),
                'param_name' => 'image',
                'value' => '',
                'description' => esc_html__( 'Upload image.', 'arrowpress-shortcodes' ),
            ),
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Title Color', 'arrowpress-shortcodes'),
                'param_name' => 'title_color',
                'admin_label' => true,
                'group' => esc_html__( 'Skin','arrowpress-shortcodes' ),
            ),
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Description Color', 'arrowpress-shortcodes'),
                'param_name' => 'desc_color',
                'admin_label' => true,
                'group' => esc_html__( 'Skin','arrowpress-shortcodes' ),
            ),
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Additional Information Color', 'arrowpress-shortcodes'),
                'param_name' => 'info_color',
                'admin_label' => true,
                'group' => esc_html__( 'Skin','arrowpress-shortcodes' ),
            ),
            $custom_class,
            array(
                'type' => 'css_editor',
                'heading' => esc_html__( 'Css','arrowpress-shortcodes' ),
                'param_name' => 'css',
                'group' => esc_html__( 'Design Option','arrowpress-shortcodes' ),
            )
        )
    ) );

    if (!class_exists('WPBakeryShortCode_ArrowPress_Testimonial')) {
        class WPBakeryShortCode_ArrowPress_Testimonial extends WPBakeryShortCode {
        }
    }
}