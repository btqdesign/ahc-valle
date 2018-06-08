<?php
function solaz_page_meta_data() {
    $solaz_skin = array('color-1', 'color-2', 'color-3', 'color-4', 'color-5', 'color-6', 'color-7','color-8', 'color-9');  
    
    return array(
        'header_fixed' => array(
            'name' => 'header_fixed',
            'title' => esc_html__('Header Fixed', 'solaz'),
            'type' => 'checkbox'
        ),
        'header_bg' => array(
            'name' => 'header_bg',
            'title' => esc_html__('Header Background', 'solaz'),
            'desc' => esc_html__("You should input hex color(ex: #e1e1e1).", 'solaz'),
            'type' => 'color',
        ),  

        'footer_bg' => array(
            'name' => 'footer_bg',
            'title' => esc_html__('Footer Background', 'solaz'),
            'desc' => esc_html__("You should input hex color(ex: #e1e1e1).", 'solaz'),
            'type' => 'color',
        ),
        "logo_footer_page"=> array(
            "name" => "logo_footer_page",
            "title" => esc_html__("Logo footer for page", 'solaz'),
            'desc' => esc_html__("Upload logo footer only page", 'solaz'),
            "type" => "upload"
        ),
        'footer_text_color' => array(
            'name' => 'footer_text_color',
            'title' => esc_html__('Footer Text Color', 'solaz'),
            'desc' => esc_html__("You should input hex color(ex: #000000) or 'transparent'.", 'solaz'),
            'type' => 'color',
        ),
    );
}
function solaz_view_page_meta_option() {
    $meta_box = solaz_page_meta_data();
    solaz_show_meta_box($meta_box);
}
function solaz_save_page2_meta_option($post_id) {
    $meta_box = solaz_page_meta_data();
    return solaz_save_meta_data($post_id, $meta_box);
}
function solaz_show_page_meta_option() {
    $meta_box = solaz_default_meta_data();
    solaz_show_meta_box($meta_box);
}
function solaz_save_page_meta_option($post_id) {
    $meta_box = solaz_default_meta_data();
    return solaz_save_meta_data($post_id, $meta_box);
}

function solaz_add_page_metaboxes() {
    if (function_exists('add_meta_box')) {
        add_meta_box('view-meta-boxes', esc_html__('Layout Options', 'solaz'), 'solaz_show_page_meta_option', 'page', 'side', 'low');
        add_meta_box('view-skin-boxes', esc_html__('Skin Options', 'solaz'), 'solaz_view_page_meta_option', 'page', 'normal', 'low');        
    }
}
add_action('add_meta_boxes', 'solaz_add_page_metaboxes');
add_action('save_post', 'solaz_save_page_meta_option');
add_action('save_post', 'solaz_save_page2_meta_option');
 