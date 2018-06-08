<?php

if (!class_exists('ReduxFramework') && file_exists(SOLAZ_ADMIN . '/ReduxCore/framework.php')) {
    require_once( SOLAZ_ADMIN . '/ReduxCore/framework.php' );
}

require_once( SOLAZ_ADMIN . '/settings/settings.php' );
require_once( SOLAZ_ADMIN . '/settings/save_settings.php' );

function solaz_check_theme_options() {
    // check default options
    global $solaz_settings;
    if(!get_option('solaz_settings')) {
        ob_start();
        include(SOLAZ_PLUGINS . '/theme_options.php');
        $options = ob_get_clean();
        $solaz_default_settings = json_decode($options, true);
        if (is_array($solaz_default_settings) || is_object($solaz_default_settings))
        {
            foreach ($solaz_default_settings as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $key1 => $value1) {
                        if (!isset($solaz_settings[$key][$key1]) || !$solaz_settings[$key][$key1]) {
                            $solaz_settings[$key][$key1] = $solaz_default_settings[$key][$key1];
                        }
                    }
                } else {
                    if (!isset($solaz_settings[$key])) {
                        $solaz_settings[$key] = $solaz_default_settings[$key];
                    }
                }
            }
        }
    }

    return $solaz_settings;
}

if(!class_exists('ReduxFramework')) {
    solaz_check_theme_options();
}
//get theme layout options
function solaz_layouts() {
    return array(
        'default' => esc_html__('Default Layout', 'solaz'),
        'wide' => esc_html__('Wide', 'solaz'),
        'fullwidth' => esc_html__('Full width', 'solaz'),
    );
}
//solaz block
function solaz_block(){
    $block_options = array();
    $args = array(
        'numberposts'       => -1,
        'post_type'         => 'block',
        'post_status'       => 'publish',
    );
    $posts = get_posts($args);
    foreach( $posts as $_post ){
        $block_options[$_post->ID] = $_post->post_title;
    }
    return $block_options;
}
//get theme sidebar position options
function solaz_sidebar_position() {
    return array(
        'default' => esc_html__('Default Position', 'solaz'),
        'left-sidebar' => esc_html__('Left', 'solaz'),
        'right-sidebar' => esc_html__('Right', 'solaz'),
        'none' => esc_html__('None', 'solaz')
    );
}
function solaz_rev_sliders_in_array(){
    if (class_exists('RevSlider')) {
        $theslider     = new RevSlider();
        $arrSliders = $theslider->getArrSliders();
        $arrA     = array();
        $arrT     = array();
        foreach($arrSliders as $slider){
            $arrA[]     = $slider->getAlias();
            $arrT[]     = $slider->getTitle();
        }
        if($arrA && $arrT){
            $result = array_combine($arrA, $arrT);
        }
        else
        {
            $result = false;
        }
        return $result;
    }
}
//Solaz popup
function solaz_popup_layouts() {
    return array(
        'default' => esc_html__('Default Popup', 'solaz'),
        '1' => esc_html__("Popup ", 'solaz'),
    );
}
function solaz_header_types() {
    return array(
        'default' => esc_html__('Default Header', 'solaz'),
        '1' => esc_html__('Header Type 1', 'solaz'),
        '2' => esc_html__('Header Type 2', 'solaz'),
        '3' => esc_html__('Header Type 3', 'solaz'),
        '4' => esc_html__('Header Type 4', 'solaz'),
    );
}
function solaz_list_menu(){
    $menus = get_terms('nav_menu');
    $menu_list =array();
    foreach($menus as $menu){
      $menu_list[$menu->term_id] =  $menu->name . "";
    } 
    return $menu_list;
}
function solaz_footer_types() {
    return array(
        'default' => esc_html__('Default Footer', 'solaz'),
        '1' => esc_html__('Footer Type 1', 'solaz'),
        '2' => esc_html__('Footer Type 2', 'solaz'),
        '3' => esc_html__('Footer Type 3', 'solaz'),
    );
}
function solaz_page_blog_layouts(){
    return array(
        "grid" => esc_html__("Grid", 'solaz'),
        "list" => esc_html__("List", 'solaz'),
        "masonry" => esc_html__("Masonry", 'solaz'),
    );
}
function solaz_page_blog_columns(){
    return array(
        "3" => esc_html__("3 Columns", 'solaz'),
		"1" => esc_html__("1 Column", 'solaz'),
        "2" => esc_html__("2 Columns", 'solaz'),
        "4" => esc_html__("4 Columns", 'solaz'),
    );
}
function solaz_single_room_layouts(){
    return array(
        "3" => esc_html__("3 Columns", 'solaz'),
        "2" => esc_html__("2 Columns", 'solaz'),
        "4" => esc_html__("4 Columns", 'solaz'),
    );
}
function solaz_get_breadcrumbs_type(){
    return array(
        "type-1" => esc_html__("Type 1", 'solaz'),
        "type-2" => esc_html__("Type 2", 'solaz'),
        "type-3" => esc_html__("Type 3", 'solaz'),
        "type-4" => esc_html__("Type 4", 'solaz'),
    );
}
function solaz_product_columns() {
    return array(
		"4" => esc_html__("4", 'solaz'),
		"3" => esc_html__("3", 'solaz'),
		"2" => esc_html__("2", 'solaz'),
		"1" => esc_html__("1", 'solaz'), 
    );
}
function solaz_product_type() {
    return array(
        "only-grid" => esc_html__("Grid", 'solaz'),
        "only-list" => esc_html__("List", 'solaz'),
        //"grid-default" => esc_html__("Grid (default) / List", 'solaz'),
        //"list-default" => esc_html__("List (default) / Grid", 'solaz'),
    );
}
function solaz_blog_columns() {
    return array(
        "2" => esc_html__("2", 'solaz'),
        "3" => esc_html__("3", 'solaz'),
        "4" => esc_html__("4", 'solaz'),
    );
}
function solaz_gallery_columns() {
    return array(
        "3" => esc_html__("3", 'solaz'),
        "2" => esc_html__("2", 'solaz'),
        "4" => esc_html__("4", 'solaz'),
        "5" => esc_html__("5", 'solaz'),
    );
}
function solaz_page_gallery_layouts(){
    return array(
        "1" => esc_html__("Grid", 'solaz'),
        "2" => esc_html__("Masonry", 'solaz'),
    );
}
function solaz_pagination_types(){
    return array(
        "pagination" => esc_html__("Pagination", 'solaz'),
        "loadmore" => esc_html__("Loadmore", 'solaz'),
    );
}
function solaz_get_block_name(){
    $block_options = array();
    $args = array(
        'numberposts'       => -1,
        'post_type'         => 'block',
        'post_status'       => 'publish',
    );
    $posts = get_posts($args);
    foreach( $posts as $_post ){
        $block_options[$_post->ID] = $_post->post_title;

    }
    return $block_options;
}