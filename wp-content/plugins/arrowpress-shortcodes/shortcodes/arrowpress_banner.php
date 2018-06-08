<?php

add_shortcode('arrowpress_banner', 'arrowpress_shortcode_banner');
add_action('vc_build_admin_page', 'arrowpress_load_banner_shortcode');
add_action('vc_after_init', 'arrowpress_load_banner_shortcode');

function arrowpress_shortcode_banner($atts, $content = null) {
    ob_start();
    if ($template = arrowpress_shortcode_template('arrowpress_banner'))
        include $template;
    return ob_get_clean();
}

function arrowpress_load_banner_shortcode() {
    $custom_class = arrowpress_vc_custom_class();
    $animation_type = arrowpress_animation_custom();

    vc_map( array(
        'name' => "ArrowPress " . esc_html__('Banner', 'arrowpress-shortcodes'),
        'base' => 'arrowpress_banner',
        'category' => esc_html__('ArrowPress', 'arrowpress-shortcodes'),
        'icon' => 'arrowpress_vc_icon',
        'weight' => - 50,
        "params" => array(
            array(
                "type" => "dropdown",
                "heading" => esc_html__("Layout", 'arrowpress-shortcodes'),
                "param_name" => "layout",
                'std' => 'banner_style_1',
                'value' => array(
                    esc_html__('Banner type 1', 'arrowpress-shortcodes') => 'banner_style_1',
                    esc_html__('Banner type 2', 'arrowpress-shortcodes') => 'banner_style_2',
                    esc_html__('Banner type 3', 'arrowpress-shortcodes') => 'banner_style_3',
                    esc_html__('Banner type 4 (only icon and title)', 'arrowpress-shortcodes') => 'banner_style_4',
                    esc_html__('Banner type 5', 'arrowpress-shortcodes') => 'banner_style_5',
                ),
            ),                       
            array(
                'type' => 'attach_image',
                'heading' => esc_html__('Image', 'arrowpress-shortcodes'),
                'param_name' => 'image',
                'value' => '',
                'description' => esc_html__( 'Upload image.', 'arrowpress-shortcodes' ), 
                'dependency' => array(
                    'element' => 'layout',
                    'value' => array('banner_style_1','banner_style_3',
                        'banner_style_2',),
                ),                                 
            ),
        //Icon group           
            array(
                "type" => "dropdown",
                "heading" => esc_html__("Icon type", 'arrowpress-shortcodes'),
                "param_name" => "type_icon",
                'std' => 'image_icon',
                'value' => array(
                    esc_html__('Image Icon', 'arrowpress-shortcodes') => 'image_icon',
                    esc_html__('Icon library', 'arrowpress-shortcodes') => 'font_icon',
                ),
                'dependency' => array(
                    'element' => 'layout',
                    'value' => array('banner_style_1','banner_style_3','banner_style_4'),
                ),         
                'group'    => esc_html__("Icon", 'arrowpress-shortcodes'),        
            ),      
            array(
                "type" => "icon_manager",
                "class" => "",
                "heading" => __("Select Icon ","ultimate_vc"),
                "param_name" => "ult_icon",
                "value" => "",
                "description" => __("Click and select icon of your choice. If you can't find the one that suits for your purpose, you can","ultimate_vc")." <a href='admin.php?page=bsf-font-icon-manager' target='_blank'>".__('add new here','ultimate_vc')."</a>.",
                'group'    => esc_html__("Icon", 'arrowpress-shortcodes'), 
                'dependency' => array(
                    'element' => 'type_icon',
                    'value' => 'font_icon',
                ),                 
            ),                   
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Icon library', 'arrowpress-shortcodes'),
                'value' => array(
                    esc_html__('Font Awesome', 'arrowpress-shortcodes') => 'fontawesome',
                    esc_html__('Font arrowpress', 'arrowpress-shortcodes') => 'arrowpressfont',
                    esc_html__('Open Iconic', 'arrowpress-shortcodes') => 'openiconic',
                    esc_html__('Typicons', 'arrowpress-shortcodes') => 'typicons',
                    esc_html__('Entypo', 'arrowpress-shortcodes') => 'entypo',
                    esc_html__('Linecons', 'arrowpress-shortcodes') => 'linecons',
                ),
                'dependency' => array(
                    'element' => 'type_icon',
                    'value' => 'font_icon',
                ),                
                'param_name' => 'icon_type',
                'description' => esc_html__('Select icon library.', 'arrowpress-shortcodes'),
                'group'    => esc_html__("Icon", 'arrowpress-shortcodes'),       
            ),
            array(
                'type' => 'iconpicker',
                'heading' => esc_html__('Icon', 'arrowpress-shortcodes'),
                'param_name' => 'icon_arrowpressfont',
                'settings' => array(
                    'emptyIcon' => false, // default true, display an "EMPTY" icon?
                    'type' => 'pestrokefont',
                    'iconsPerPage' => 4000, // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                    'element' => 'icon_type',
                    'value' => 'pestrokefont',
                ),
                'weight' => 9,
                'description' => esc_html__('Select icon from library.', 'arrowpress-shortcodes'),
                'group'    => esc_html__("Icon", 'arrowpress-shortcodes'),       
            ),
            array(
                'type' => 'iconpicker',
                'heading' => esc_html__( 'Icon', 'arrowpress-shortcodes' ),
                'param_name' => 'icon_arrowpress',
                'settings' => array(
                    'emptyIcon' => false, // default true, display an "EMPTY" icon?
                    'type' => 'solazfont',
                    'iconsPerPage' => 4000, // default 100, how many icons per/page to display
                ),
                 'dependency' => array(
                    'element' => 'icon_type',
                    'value' => 'arrowpressfont',
                ),                
                'description' => esc_html__( 'Select icon from library.', 'arrowpress-shortcodes' ),
                'group'    => esc_html__("Icon", 'arrowpress-shortcodes'),       
            ),

            array(
                'type' => 'iconpicker',
                'heading' => esc_html__('Icon', 'arrowpress-shortcodes'),
                'param_name' => 'icon_fontawesome',
                'settings' => array(
                    'emptyIcon' => false, // default true, display an "EMPTY" icon?
                    'iconsPerPage' => 4000, // default 100, how many icons per/page to display
                ),
                 'dependency' => array(
                    'element' => 'icon_type',
                    'value' => 'fontawesome',
                ), 
                'description' => esc_html__('Select icon from library.', 'arrowpress-shortcodes'),
                'group'    => esc_html__("Icon", 'arrowpress-shortcodes'),        
            ),
            array(
                'type' => 'iconpicker',
                'heading' => esc_html__('Icon', 'arrowpress-shortcodes'),
                'param_name' => 'icon_openiconic',
                'settings' => array(
                    'emptyIcon' => false, // default true, display an "EMPTY" icon?
                    'type' => 'openiconic',
                    'iconsPerPage' => 4000, // default 100, how many icons per/page to display
                ),
                 'dependency' => array(
                    'element' => 'icon_type',
                    'value' => 'openiconic',
                ), 
                'description' => esc_html__('Select icon from library.', 'arrowpress-shortcodes'),
                'group'    => esc_html__("Icon", 'arrowpress-shortcodes'),        
            ),
            array(
                'type' => 'iconpicker',
                'heading' => esc_html__('Icon', 'arrowpress-shortcodes'),
                'param_name' => 'icon_typicons',
                'settings' => array(
                    'emptyIcon' => false, // default true, display an "EMPTY" icon?
                    'type' => 'typicons',
                    'iconsPerPage' => 4000, // default 100, how many icons per/page to display
                ),
                 'dependency' => array(
                    'element' => 'icon_type',
                    'value' => 'typicons',
                ), 
                'description' => esc_html__('Select icon from library.', 'arrowpress-shortcodes'),
                'group'    => esc_html__("Icon", 'arrowpress-shortcodes'),        
            ),
            array(
                'type' => 'iconpicker',
                'heading' => esc_html__('Icon', 'arrowpress-shortcodes'),
                'param_name' => 'icon_entypo',
                'settings' => array(
                    'emptyIcon' => false, // default true, display an "EMPTY" icon?
                    'type' => 'entypo',
                    'iconsPerPage' => 4000, // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                    'element' => 'icon_type',
                    'value' => 'entypo',
                ), 
                'description' => esc_html__('Select icon from library.', 'arrowpress-shortcodes'),
                'group'    => esc_html__("Icon", 'arrowpress-shortcodes'),        
            ),
            array(
                'type' => 'iconpicker',
                'heading' => esc_html__('Icon', 'arrowpress-shortcodes'),
                'param_name' => 'icon_linecons',
                'settings' => array(
                    'emptyIcon' => false, // default true, display an "EMPTY" icon?
                    'type' => 'linecons',
                    'iconsPerPage' => 4000, // default 100, how many icons per/page to display
                ),
                 'dependency' => array(
                    'element' => 'icon_type',
                    'value' => 'linecons',
                ), 
                'description' => esc_html__('Select icon from library.', 'arrowpress-shortcodes'),
                'group'    => esc_html__("Icon", 'arrowpress-shortcodes'),        
            ),            
            array(
                'type' => 'attach_image',
                'heading' => esc_html__('Image logo', 'arrowpress-shortcodes'),
                'param_name' => 'image_2',
                'value' => '',
                'description' => esc_html__( 'Upload image logo.', 'arrowpress-shortcodes' ),
                "dependency" => array(
                    'element' => 'type_icon',
                    'value' => array('image_icon')
                ),
                'group'    => esc_html__("Icon", 'arrowpress-shortcodes'),        
            ),
            array(
                "type" => "number",
                "heading" => esc_html__("Icon font size", 'arrowpress-shortcodes'),
                "param_name" => "icon_size",
                'dependency' => array(
                    'element' => 'type_icon',
                    'value' => 'font_icon',
                ), 
                'group'    => esc_html__("Icon", 'arrowpress-shortcodes'),     
            ), 
            array(
                "type" => "textfield",
                "heading" => esc_html__("Big Title", 'arrowpress-shortcodes'),
                "param_name" => "big_title",
                "admin_label" => true,
                "dependency" => array(
                    'element' => 'layout',
                    'value' => array('banner_style_1', 'banner_style_2', 'banner_style_3', 
                    'banner_style_4', 'banner_style_5')
                )
            ), 
            array(
                "type" => "textfield",
                "heading" => esc_html__("Small Title", 'arrowpress-shortcodes'),
                "param_name" => "small_title",
                "dependency" => array(
                    'element' => 'layout',
                    'value' => array('banner_style_1', 'banner_style_2', 'banner_style_5')
                )
            ),  
            // array(
   //              "type" => "textarea",
   //              "heading" => esc_html__("Content", 'arrowpress-shortcodes'),
   //              "param_name" => "title_content",
   //              "admin_label" => true,
            //  "dependency" => array(
   //                  'element' => 'layout',
   //                  'value' => array('banner_style_3')
   //              )
   //          ), 
            array(
                "type" => "textarea_html",
                "heading" => esc_html__("Description", 'arrowpress-shortcodes'),
                "param_name" => "content",
                "dependency" => array(
                    'element' => 'layout',
                    'value' => array('banner_style_2', 'slide','banner_style_3','banner_style_5')
                )
            ), 
            array(
                "type" => "dropdown",
                "heading" => esc_html__( "Text Align", "solaz" ),
                "param_name" => "text_align",
                'std' => 'center',
                "value" => array(
                    esc_html__('Center', 'arrowpress-shortcodes') => 'center',
                    esc_html__('Left', 'arrowpress-shortcodes') => 'left',
                    esc_html__('Right', 'arrowpress-shortcodes') => 'right',
                    ),
                "description" => esc_html__( "Select heading align.", "solaz" )
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__("Button Text", "solaz"),
                "param_name" => "btn_text",
                'value' => esc_html__( 'Shop Now', 'arrowpress-shortcodes' ),
                "dependency" => array(
                    'element' => 'layout',
                    'value' => array('banner_style_2', 'banner_style_3')
                )
            ),
            array(
                "type" => "vc_link",
                "heading" => esc_html__("Link", 'arrowpress-shortcodes'),
                "param_name" => "link",
                "dependency" => array(
                    'element' => 'layout',
                    'value' => array('banner_style_1','banner_style_2', 'banner_style_3')
                )                
            ),
        //Skin
            array(
                'type' => 'checkbox',
                'heading' => esc_html__("Enable Default Overlay", "solaz"),
                'param_name' => 'en_overlay',
                'std' => '',
                'value' => array( esc_html__( 'Yes', 'arrowpress-shortcodes' ) => 'yes' ),
                'dependency' => array(
                    'element' => 'layout',
                    'value' => array('banner_style_1'),
                ), 
                'group' => esc_html__( 'Skin','arrowpress-shortcodes' ),
            ),
            array(
                'type' => 'number',
                'heading' => esc_html__('Margin Top', 'arrowpress-shortcodes'),
                'param_name' => 'top',
                'group' => esc_html__( 'Skin','arrowpress-shortcodes' ),
                'dependency' => array(
                    'element' => 'layout',
                    'value' => array('banner_style_4'),
                ),                  
            ),
            array(
                'type' => 'number',
                'heading' => esc_html__('Left position', 'arrowpress-shortcodes'),
                'param_name' => 'left',
                'group' => esc_html__( 'Skin','arrowpress-shortcodes' ),
                'dependency' => array(
                    'element' => 'layout',
                    'value' => array('banner_style_4'),
                ),                  
            ),  

            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Background Color', 'arrowpress-shortcodes'),
                'param_name' => 'color_bg',
                'group' => esc_html__( 'Skin','arrowpress-shortcodes' ),
                'dependency' => array(
                    'element' => 'layout',
                    'value' => array('banner_style_4'),
                ),                  
            ),      
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Background Color on Hover', 'arrowpress-shortcodes'),
                'param_name' => 'bg_hover_color',
                'group' => esc_html__( 'Skin','arrowpress-shortcodes' ),
                'dependency' => array(
                    'element' => 'layout',
                    'value' => array('banner_style_4'),
                ),                  
            ),                     
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Title Color', 'arrowpress-shortcodes'),
                'param_name' => 'title_color',
                'group' => esc_html__( 'Skin','arrowpress-shortcodes' ),
            ),  
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Small title Color', 'arrowpress-shortcodes'),
                'param_name' => 'sm_title_color',
                'group' => esc_html__( 'Skin','arrowpress-shortcodes' ),
            ),   
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Text color', 'arrowpress-shortcodes'),
                'param_name' => 'text_color',
                'group' => esc_html__( 'Skin','arrowpress-shortcodes' ),
                "dependency" => array(
                    'element' => 'layout',
                    'value' => array('banner_style_2', 'banner_style_3')
                )                
            ),                                 
            $custom_class,
            array(
                'type' => 'checkbox',
                'heading' => esc_html__("Enable Animation", "solaz"),
                'param_name' => 'item_delay',
                'std' => '',
                'value' => array( esc_html__( 'Yes', 'arrowpress-shortcodes' ) => 'yes' ),
                'group' => 'Animation'
            ),
            array(
                "type" => "dropdown",
                "heading" => esc_html__( "Animation Type", "solaz" ),
                "param_name" => "animation_type",
                "value" => $animation_type,
                "description" => esc_html__( "Select Animation Style.", "solaz" ),
                'dependency' => array(
                    'element' => 'item_delay',
                    'value' => 'yes',
                ),
                'group' => 'Animation'
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => esc_html__("Animation Delay", "solaz"),
                "description" => esc_html__( "Enter Animation Delay.", "solaz" ),
                'dependency' => array(
                    'element' => 'item_delay',
                    'value' => 'yes',
                ),
                "param_name" => "animation_delay",
                "value" => 500,
                'group' => 'Animation'
            ),
            array(
                'type' => 'css_editor',
                'heading' => esc_html__( 'CSS box', 'arrowpress-shortcodes' ),
                'param_name' => 'css',
                'group' => esc_html__( 'Design Options', 'arrowpress-shortcodes' ),
            ),
        )
    ) );
    if (!class_exists('WPBakeryShortCode_ArrowPress_Banner')) {
        class WPBakeryShortCode_ArrowPress_Banner extends WPBakeryShortCode {
        }
    }
}