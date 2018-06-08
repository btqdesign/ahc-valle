<?php
function solaz_post_meta_data() {
    return array( 
        "highlight" => array(
            "name" => "highlight",
            "title" => esc_html__("Short Description", 'solaz'),
            "desc" => esc_html__("Content", 'solaz'),
            "type" => "editor"
        ),
    );
}
function solaz_post_format(){
    return array(
        "video_code" => array(
            "name" => "video_code",
            "title" => esc_html__("Video & Audio Embed Code", 'solaz'),
            "desc" => esc_html__('Enter the embed link (Youtube or Vimeo). ', 'solaz'),
            "type" => "textarea",
            'display_condition' => 'post-type-video', 
        ),
        "link_code" => array(
            "name" => "link_code",
            "title" => esc_html__("Link", 'solaz'),
            "desc" => esc_html__('Enter link. ', 'solaz'),
            "type" => "textfield",
            'display_condition' => 'post-type-link', 
        ),
        "link_title" => array(
            "name" => "link_title",
            "title" => esc_html__("Link title", 'solaz'),
            "desc" => esc_html__('Enter link title. ', 'solaz'),
            "type" => "textfield",
            'display_condition' => 'post-type-link', 
        ),
        "quote_code" => array(
            "name" => "quote_code",
            "title" => esc_html__("Quote", 'solaz'),
            "desc" => esc_html__('Enter quote. ', 'solaz'),
            "type" => "textarea",
            'display_condition' => 'post-type-quote', 
        ),
        "quote_author" => array(
            "name" => "quote_author",
            "title" => esc_html__("Quote author", 'solaz'),
            "desc" => esc_html__('Enter quote author. ', 'solaz'),
            "type" => "textfield",
            'display_condition' => 'post-type-quote', 
        ),
    );
}
function solaz_view_post_meta_option() {
    $meta_box = solaz_post_meta_data();
    solaz_show_meta_box($meta_box);
}
function solaz_view_post_format_meta_option() {
    $meta_box = solaz_post_format();
    solaz_show_meta_box($meta_box);
}

function solaz_show_post_meta_option() {
    $meta_box = solaz_default_meta_data();
    solaz_show_meta_box($meta_box);
}
function solaz_save_post2_meta_option($post_id) {
    $meta_box_post = solaz_post_meta_data();
    $meta_box_format = solaz_post_format();
    $meta_box = array_merge($meta_box_post,$meta_box_format); 
    return solaz_save_meta_data($post_id, $meta_box);
}
function solaz_save_post_meta_option($post_id) {
    $meta_box = solaz_default_meta_data();
    return solaz_save_meta_data($post_id, $meta_box);
}

function solaz_add_post_metaboxes() {
    if (function_exists('add_meta_box')) {
        add_meta_box('view-format-boxes', esc_html__('Post Format', 'solaz'), 'solaz_view_post_format_meta_option', 'post', 'normal', 'low');        
        add_meta_box('show-meta-boxes', esc_html__('Blog Options', 'solaz'), 'solaz_view_post_meta_option', 'post', 'normal', 'low');
        add_meta_box('view-meta-boxes', esc_html__('Layout Options', 'solaz'), 'solaz_show_post_meta_option', 'post', 'normal', 'low');
    }
}

add_action('add_meta_boxes', 'solaz_add_post_metaboxes');
add_action('save_post', 'solaz_save_post_meta_option');
add_action('save_post', 'solaz_save_post2_meta_option');

function solaz_default_post_tax_meta_data() {
    $solaz_sidebar_position = solaz_sidebar_position();
    $solaz_sidebars = solaz_sidebars();
    $solaz_header_layout = solaz_header_types();
    $solaz_blog_layout = solaz_page_blog_layouts();
    $solaz_blog_columns = solaz_page_blog_columns();
    $solaz_blog_layout['default']= esc_html__('Default','solaz');
    return array(
        // Breadcrumbs
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
        'blog_layout' => array(
            'name' => 'blog_layout',
            'title' => esc_html__('Blog layout', 'solaz'),
            'desc' => esc_html__('Select blog layout', 'solaz'),
            'type' => 'select',
            'options' => $solaz_blog_layout,
            'default' => 'default'            
        ),
		'blog_columns' => array(
            'name' => 'blog_columns',
            'title' => esc_html__('Blog columns', 'solaz'),
            'desc' => esc_html__('Select blog columns', 'solaz'),
            'type' => 'select',
            'options' => $solaz_blog_columns,
            'default' => 'default'            
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
    );
}
//category taxonomy
function solaz_add_categorymeta_table() {
    // Create Product Cat Meta
    global $wpdb;
    $type = 'category';
    $table_name = $wpdb->prefix . $type . 'meta';
    $variable_name = $type . 'meta';
    $wpdb->$variable_name = $table_name;

    // Create Category Meta Table
    solaz_create_metadata_table($table_name, $type);
}
add_action( 'init', 'solaz_add_categorymeta_table' );

// category meta
add_action( 'category_add_form_fields', 'solaz_add_category', 10, 2);
function solaz_add_category() {
    $category_meta_boxes = solaz_default_post_tax_meta_data();
    solaz_show_tax_add_meta_boxes($category_meta_boxes);
}

add_action( 'category_edit_form_fields', 'solaz_edit_category', 10, 2);
function solaz_edit_category($tag, $taxonomy) {
    $category_meta_boxes = solaz_default_post_tax_meta_data();
    solaz_show_tax_edit_meta_boxes($tag, $taxonomy, $category_meta_boxes);
}

add_action( 'created_term', 'solaz_save_category', 10,3 );
add_action( 'edit_term', 'solaz_save_category', 10,3 );
function solaz_save_category($term_id, $tt_id, $taxonomy) {
    if (!$term_id) return;
    
    $category_meta_boxes = solaz_default_post_tax_meta_data();
    return solaz_save_taxdata( $term_id, $tt_id, $taxonomy, $category_meta_boxes );
}



 