<?php
function solaz_product_meta_data(){
    return array(
        // Custom Tab Title
        "custom_tab_title" => array(
            "name" => "custom_tab_title",
            "title" => esc_html__("Custom Tab Title", 'solaz'),
            "desc" => esc_html__("Input the custom tab title.", 'solaz'),
            "type" => "textfield"
        ),
        // Content Tab Content
        "custom_tab_content" => array(
            "name" => "custom_tab_content",
            "title" => esc_html__("Custom Tab Content", 'solaz'),
            "desc" => esc_html__("Input the custom tab content.", 'solaz'),
            "type" => "editor"
        )
    );
}

function solaz_show_product_tab_meta_option() {
    $meta_box = solaz_product_meta_data();
    solaz_show_meta_box($meta_box);
}

function solaz_save_product_tab_meta_option($post_id) {
    $meta_box = solaz_product_meta_data();
    return solaz_save_meta_data($post_id, $meta_box);
}

function solaz_add_product_tab_metaboxes() {
    if (function_exists('add_meta_box')) {
        add_meta_box('view-meta-boxes', esc_html__('Custom Tab', 'solaz'), 'solaz_show_product_tab_meta_option', 'product', 'normal', 'low');
    }
}

add_action('add_meta_boxes', 'solaz_add_product_tab_metaboxes');
add_action('save_post', 'solaz_save_product_tab_meta_option');
function solaz_product_sidebar_option(){
    $solaz_sidebar_position = solaz_sidebar_position();
    $solaz_sidebars = solaz_sidebars();
    $solaz_header_layout = solaz_header_types();
    $solaz_footer_layout = solaz_footer_types();
    $solaz_layout = solaz_layouts();
    return array(
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
		'related_col' => array(
            'name'  => 'related_col',
            'type' => 'select',
            'title' => esc_html__('Related product columns', 'solaz'),
            'options' => array(
                "default" => esc_html__("Default","solaz"),
                "2" => esc_html__("2","solaz"),
                "3" => esc_html__("3","solaz"),
                "4" => esc_html__("4","solaz"),
            ),
            'default' => 'default'            
        ),
    );
}
function solaz_show_product_default_meta_option() {
    $meta_box = solaz_product_sidebar_option();
    solaz_show_meta_box($meta_box);
}


function solaz_save_product_meta_option($post_id) {
    $meta_box = solaz_product_sidebar_option();
    return solaz_save_meta_data($post_id, $meta_box);
}

function solaz_add_product_metaboxes() {
    if (function_exists('add_meta_box')) {
        add_meta_box('show-meta-boxes', esc_html__('Sidebar Options', 'solaz'), 'solaz_show_product_default_meta_option', 'product', 'side', 'low');
    }
}

add_action('add_meta_boxes', 'solaz_add_product_metaboxes');
add_action('save_post', 'solaz_save_product_meta_option');
function solaz_add_categorymeta_product_table() {
// Create Product Cat Meta
global $wpdb;
$type = 'product_cat';
$table_name = $wpdb->prefix . $type . 'meta';
$variable_name = $type . 'meta';
$wpdb->$variable_name = $table_name;

// Create Product Cat Meta Table
solaz_create_metadata_table($table_name, $type);
}
add_action( 'init', 'solaz_add_categorymeta_product_table' );
//Taxonomy
function solaz_default_product_tax_meta_data() {
    $solaz_sidebar_position = solaz_sidebar_position();
    $solaz_sidebars = solaz_sidebars();   
    $solaz_list_mode = solaz_product_type();
    $solaz_header_layout = solaz_header_types();
    $solaz_footer_layout = solaz_footer_types(); 
    return array(
        // Breadcrumbs
        'breadcrumbs' => array(
            'name' => 'breadcrumbs',
            'title' => esc_html__('Breadcrumbs', 'solaz'),
            'desc' => esc_html__('Hide breadcrumbs', 'solaz'),
            'type' => 'checkbox'
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
        'list_mode_product' => array(
            'name' => 'list_mode_product',
            'type' => 'select',
            'title' => esc_html__('List mode', 'solaz'),
            'options' => $solaz_list_mode,
            'default' => 'only-grid'
        ),
        'category_cols' => array(
            'name' => 'category_cols',
            'type' => 'select',
            'title' => esc_html__('Number of grid column', 'solaz'),
            'options' =>  
                    array(
                    "3" => esc_html__("3 columns", 'solaz'),
                    "1" => esc_html__("1 columns", 'solaz'),
                    "2" => esc_html__("2 columns", 'solaz'),
                    "4" => esc_html__("4 columns", 'solaz'),
                    "column-default" => esc_html__("Default", 'solaz'),
                    ),
            'default' => 'column-default'
        ),
    );
}

add_action( 'product_cat_add_form_fields', 'solaz_add_product_cat', 10, 2);
function solaz_add_product_cat() {
    $product_cat_meta_boxes = solaz_default_product_tax_meta_data();

    solaz_show_tax_add_meta_boxes($product_cat_meta_boxes);
}

add_action( 'product_cat_edit_form_fields', 'solaz_edit_product_cat', 10, 2);
function solaz_edit_product_cat($tag, $taxonomy) {
    $product_cat_meta_boxes = solaz_default_product_tax_meta_data();

    solaz_show_tax_edit_meta_boxes($tag, $taxonomy, $product_cat_meta_boxes);
}

add_action( 'created_term', 'solaz_save_product_cat', 10,3 );
add_action( 'edit_term', 'solaz_save_product_cat', 10,3 );

function solaz_save_product_cat($term_id, $tt_id, $taxonomy) {
    if (!$term_id) return;
    
    $product_cat_meta_boxes = solaz_default_product_tax_meta_data();
    return solaz_save_taxdata( $term_id, $tt_id, $taxonomy, $product_cat_meta_boxes );
}