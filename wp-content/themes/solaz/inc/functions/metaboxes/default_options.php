<?php

function solaz_default_meta_data() {
    $solaz_layout = solaz_layouts();
    $solaz_sidebar_position = solaz_sidebar_position();
    $solaz_sidebars = solaz_sidebars();
    $solaz_header_layout = solaz_header_types();
    $solaz_footer_layout = solaz_footer_types();
    $solaz_popup_layout = solaz_popup_layouts();
    $solaz_block_name = solaz_get_block_name();
    $solaz_block_name['default'] ='default';
    $solaz_slider = solaz_rev_sliders_in_array();
    return array(
        // header
        'header' => array(
            'name' => 'header',
            'title' => esc_html__('Header Layout', 'solaz'),
            'type' => 'select',
            'options' => $solaz_header_layout,
            'default' => 'default'
        ),
        //footer
        'footer' => array(
            'name' => 'footer',
            'title' => esc_html__('Footer Layout', 'solaz'),
            'type' => 'select',
            'options' => $solaz_footer_layout,
            'default' => 'default'
        ),  
        "breadcrumbs_bg"=> array(
            "name" => "breadcrumbs_bg",
            "title" => esc_html__("Breadcrumbs Background", 'solaz'),
            'desc' => esc_html__("Upload breadcrumbs background", "solaz"),
            "type" => "upload"
        ), 
        "breadcrumbs_color"=> array(
            "name" => "breadcrumbs_color",
            "title" => esc_html__("Breadcrumbs Color", 'solaz'),
            "type" => "color"
        ),               
        'page_title' => array(
            'name' => 'page_title',
            'title' => esc_html__('Page Title', 'solaz'),
            'desc' => esc_html__('Hide Page Title', 'solaz'),
            'type' => 'checkbox'
        ),
        'show_header' => array(
            'name' => 'show_header',
            'title' => esc_html__('Header', 'solaz'),
            'desc' => esc_html__('Hide header', 'solaz'),
            'type' => 'checkbox'
        ),
        //  Show Footer
        'show_footer' => array(
            'name' => 'show_footer',
            'title' => esc_html__('Footer', 'solaz'),
            'desc' => esc_html__('Hide footer', 'solaz'),
            'type' => 'checkbox'
        ),
        //sidebar position
        'left-sidebar' => array(
            'name' => 'left-sidebar',
            'type' => 'select',
            'title' => esc_html__('Left Sidebar', 'solaz'),
            'options' => $solaz_sidebars,
            'default' => 'default'
        ),
        'right-sidebar' => array(
            'name' => 'right-sidebar',
            'type' => 'select',
            'title' => esc_html__('Right Sidebar', 'solaz'),
            'options' => $solaz_sidebars,
            'default' => 'default'
        ),
        // layout
        'layout' => array(
            'name' => 'layout',
            'title' => esc_html__('Layout', 'solaz'),
            'type' => 'select',
            'options' => $solaz_layout,
            'default' => 'default'
        ),
        'hide_f_info' => array(
            'name' => 'hide_f_info',
            'title' => esc_html__('Hide footer info', 'solaz'),
            'desc' => esc_html__('Hide footer info', 'solaz'),
            'type' => 'checkbox'
        ), 
        'remove_space_br' => array(
            'name' => 'remove_space_br',
            'title' => esc_html__('Remove top space', 'solaz'),
            'desc' => esc_html__('Remove top space', 'solaz'),
            'type' => 'checkbox'
        ),   
        'remove_space' => array(
            'name' => 'remove_space',
            'title' => esc_html__('Remove bottom space', 'solaz'),
            'desc' => esc_html__('Remove bottom space', 'solaz'),
            'type' => 'checkbox'
        ), 
        'show_slider' => array(
            'name' => 'show_slider',
            'title' => esc_html__('Show Revolution Slider', 'solaz'),
            'desc' => esc_html__('Enable Slider', 'solaz'),
            'type' => 'checkbox'
        ), 
        'category_slider' => array(
            'name' => 'category_slider',
            'title' => esc_html__('Select Revolution Slider', 'solaz'),
            'desc' => esc_html__('Slider will show if you show revolution slider', 'solaz'),
            'type' => 'select',
            'options' => $solaz_slider,
            'default' => 'default'
        ),        
    );
}

