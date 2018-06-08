<?php

// arrowpress_get_widget
add_shortcode('arrowpress_get_widget', 'arrowpress_shortcode_get_widget');
add_action('vc_build_admin_page', 'arrowpress_load_get_widget_shortcode');
add_action('vc_after_init', 'arrowpress_load_get_widget_shortcode');
function arrowpress_shortcode_get_widget($atts, $content = null) {
    ob_start();
    if ($template = arrowpress_shortcode_template('arrowpress_get_widget'))
        include $template;
    return ob_get_clean();
}

function arrowpress_load_get_widget_shortcode() {
    $custom_class = arrowpress_vc_custom_class();
    global $wp_widget_factory;
    
    // print_r($wp_widget_factory ->widgets );
    $widget_name = array();
    $widget_name[0] = esc_html__('Choose a block to display', 'arrowpress-shortcodes');
    $posts =array_keys($wp_widget_factory ->widgets);
    foreach( $posts as $_post ){
        $widget_name[$_post ] = $_post;
     
    }

    vc_map( array(
        'name' => "ArrowPress " . esc_html__('Widgets', 'arrowpress-shortcodes'),
        'base' => 'arrowpress_get_widget',
        'category' => esc_html__('ArrowPress', 'arrowpress-shortcodes'),
        'icon' => 'arrowpress_vc_icon',
        'weight' => - 50,
        "params" => array(
            array(
                "type" => "dropdown",
                "heading" => esc_html__("Widgets", 'arrowpress-shortcodes'),
                "param_name" => "widget_name",
                'value' =>  $widget_name,
                "admin_label" => true
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__("Title", 'arrowpress-shortcodes'),
                "param_name" => "title",
            ), 
            array(
                "type" => "number",
                "heading" => esc_html__("Column number", 'arrowpress-shortcodes'),
                "param_name" => "col_num",
                'dependency' => array(
                    'element' => 'widget_name',
                    'value' => 'ArrowPress_Override_Widget_Room_Carousel',
                ), 
            ),
            array(
                "type" => "number",
                "heading" => esc_html__("Row number", 'arrowpress-shortcodes'),
                "param_name" => "row_num",
                'dependency' => array(
                    'element' => 'widget_name',
                    'value' => 'ArrowPress_Override_Widget_Room_Carousel',
                ), 
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__("Text link", 'arrowpress-shortcodes'),
                "param_name" => "text_link",
                'dependency' => array(
                    'element' => 'widget_name',
                    'value' => 'ArrowPress_Override_Widget_Room_Carousel',
                ),                 
            ), 
            // array(
            //     'type' => 'checkbox',
            //     'heading' => esc_html__("Enable Navigation", "arrowpress"),
            //     'param_name' => 'nav',
            //     'std' => '',
            //     'value' => array( esc_html__( 'Yes', 'arrowpress-shortcodes' ) => 1 ),
            //     'dependency' => array(
            //         'element' => 'widget_name',
            //         'value' => 'ArrowPress_Override_Widget_Room_Carousel',
            //     ), 
            // ),            
                         
            $custom_class
        )
    ));

    if (!class_exists('WPBakeryShortCode_ArrowPress_Get_Widget')) {
        class WPBakeryShortCode_ArrowPress_Get_Widget extends WPBakeryShortCode {
        }
    }
}


