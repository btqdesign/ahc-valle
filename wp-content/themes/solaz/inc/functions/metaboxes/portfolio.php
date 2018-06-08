<?php
function solaz_gallery_meta_data() {
    return array(
        "status" => array(
            "name" => "status",
            "type" => "text",
            "default" => esc_html__("Completed","solaz"),
        ),       
    );
}
function solaz_view_gallery_meta_option() {
    $meta_box = solaz_gallery_meta_data();
    solaz_show_meta_box($meta_box);
}
function solaz_save_gallery_meta_option($post_id) {
    $meta_box = solaz_gallery_meta_data();
    return solaz_save_meta_data($post_id, $meta_box);
}
function solaz_add_gallery_metaboxes() {
    if (function_exists('add_meta_box')) {
      
    }
}

add_action('add_meta_boxes', 'solaz_add_gallery_metaboxes');
add_action('save_post', 'solaz_save_gallery_meta_option');
function solaz_add_categorymeta_gallery_table() {
// Create Gallery Cat Meta
global $wpdb;
$type = 'gallery_cat';
$table_name = $wpdb->prefix . $type . 'meta';
$variable_name = $type . 'meta';
$wpdb->$variable_name = $table_name;

// Create Gallery Cat Meta Table
solaz_create_metadata_table($table_name, $type);
}
add_action( 'init', 'solaz_add_categorymeta_gallery_table' );
//Taxonomy
function solaz_default_gallery_tax_meta_data() {
    $solaz_layout = solaz_layouts();
    $solaz_sidebar_position = solaz_sidebar_position();
    $solaz_sidebars = solaz_sidebars();   
    $solaz_header_layout = solaz_header_types();
    $solaz_footer_layout = solaz_footer_types(); 
    $gallery_style= solaz_page_gallery_layouts();
    $gallery_style['default'] ='Default';
    $gallery_cols = solaz_gallery_columns();
    $gallery_cols['default'] ='Default';
    return array(
                // layout
        'layout' => array(
            'name' => 'layout',
            'title' => esc_html__('Layout', 'solaz'),
            'type' => 'select',
            'options' => $solaz_layout,
            'default' => 'default'
        ),
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
        'gallery-style-version' => array(
            'name' => 'gallery-style-version',
            'type' => 'select',
            'title' => esc_html__('Gallery Layouts', 'solaz'),
            'options' => $gallery_style,
            'default' => 'default'
        ),
        'gallery-loadmore-style' => array(
            'name'  => 'gallery-loadmore-style',
            'type'  => 'select',
            'title' => esc_html__('Gallery loadmore style','solaz'),
            'options'   => array(
                                'default' => esc_html__('Default','solaz'),
                                '1' => esc_html__('Button style 1','solaz'),
                                '2' => esc_html__('Button style 2','solaz'),
                                ),
            'default' => 'default',
        ),
        'gallery-cols' => array(
            'name' => 'gallery-cols',
            'type' => 'select',
            'title' => esc_html__('Gallery columns', 'solaz'),
            'options' => $gallery_cols,
            'default' => 'default'
        ),        
        

        // 'category_column' => array(
        //     'name' => 'category_column',
        //     'type' => 'select',
        //     'title' => esc_html__('Number of grid column', 'solaz'),
        //     'options' =>  
        //             array(
        //             "2" => esc_html__("2 columns", 'solaz'),
        //             "3" => esc_html__("3 columns", 'solaz'),
        //             "4" => esc_html__("4 columns", 'solaz'),
        //             "column-default" => esc_html__("Default", 'solaz'),
        //             ),
        //     'default' => 'column-default'
        // ),
    );
}

add_action( 'gallery_cat_add_form_fields', 'solaz_add_gallery_cat', 10, 2);
function solaz_add_gallery_cat() {
    $gallery_cat_meta_boxes = solaz_default_gallery_tax_meta_data();

    solaz_show_tax_add_meta_boxes($gallery_cat_meta_boxes);
}

add_action( 'gallery_cat_edit_form_fields', 'solaz_edit_gallery_cat', 10, 2);
function solaz_edit_gallery_cat($tag, $taxonomy) {
    $gallery_cat_meta_boxes = solaz_default_gallery_tax_meta_data();

    solaz_show_tax_edit_meta_boxes($tag, $taxonomy, $gallery_cat_meta_boxes);
}

add_action( 'created_term', 'solaz_save_gallery_cat', 10,3 );
add_action( 'edit_term', 'solaz_save_gallery_cat', 10,3 );

function solaz_save_gallery_cat($term_id, $tt_id, $taxonomy) {
    if (!$term_id) return;
    
    $gallery_cat_meta_boxes = solaz_default_gallery_tax_meta_data();
    return solaz_save_taxdata( $term_id, $tt_id, $taxonomy, $gallery_cat_meta_boxes );
}