<?php
$theme = wp_get_theme();
define('SOLAZ_VERSION', $theme->get('Version'));
define('SOLAZ_LIB', get_template_directory() . '/inc');
define('SOLAZ_ADMIN', SOLAZ_LIB . '/admin');
define('SOLAZ_PLUGINS', SOLAZ_LIB . '/plugins');
define('SOLAZ_FUNCTIONS', SOLAZ_LIB . '/functions');
define('SOLAZ_METABOXES', SOLAZ_FUNCTIONS . '/metaboxes');
define('SOLAZ_CSS', get_template_directory_uri() . '/css');
define('SOLAZ_JS', get_template_directory_uri() . '/js');

require_once(SOLAZ_ADMIN . '/functions.php');
require_once(SOLAZ_FUNCTIONS . '/functions.php');
require_once(SOLAZ_METABOXES . '/functions.php');
require_once(SOLAZ_PLUGINS . '/functions.php');
// Set up the content width value based on the theme's design and stylesheet.
if (!isset($content_width)) {
    $content_width = 1140;
}

if (!function_exists('solaz_setup')) {

    function solaz_setup() {
        load_theme_textdomain('solaz', get_template_directory() . '/languages');
        add_editor_style( array( 'style.css', 'style_rtl.css' ) );
        add_theme_support( 'title-tag' );
        add_theme_support('automatic-feed-links');
        add_theme_support( 'post-formats', array(
            'image', 'video', 'audio', 'quote', 'link', 'gallery',
        ) );
        // register menus
        register_nav_menus( array(
            'primary' => esc_html__('Primary Menu', 'solaz'),
        ));
        add_theme_support( 'custom-header' );
        add_theme_support( 'custom-background' );
        add_theme_support( 'post-thumbnails' );
   
        add_image_size('solaz-room-loop', 369, 277, true);   
		add_image_size('solaz-blog-grid', 760, 460, true);
		add_image_size('solaz-blog-list', 640, 500, true);
		add_image_size('solaz-blog-detail', 1170, 600, true); 
		add_image_size('solaz-gallery-grid', 512, 316, true);
    }

}
add_action('after_setup_theme', 'solaz_setup');

add_action('admin_enqueue_scripts', 'solaz_admin_scripts_css');
function solaz_admin_scripts_css() {
    if(is_rtl()){
        wp_enqueue_style('solaz_admin_rtl_css', SOLAZ_CSS . '/admin-rtl.css', false);
    }
    else{
        wp_enqueue_style('solaz_admin_css', SOLAZ_CSS . '/admin.css', false);
    }
}
add_action('admin_enqueue_scripts', 'solaz_admin_scripts_js');
function solaz_admin_scripts_js() {
    wp_register_script('solaz_admin_js', SOLAZ_JS . '/un-minify/admin.js', array('common', 'jquery', 'media-upload', 'thickbox'), SOLAZ_VERSION, true);
    wp_enqueue_script('solaz_admin_js');
}
function solaz_fonts_url() {
    $font_url = '';
    
    /*
    Translators: If there are characters in your language that are not supported
    by chosen font(s), translate this to 'off'. Do not translate into your own language.
     */
    if ( 'off' !== _x( 'on', 'Google font: on or off', 'solaz' ) ) {
        $font_url = add_query_arg( 'family', urlencode( 'Open Sans|Poppins:300,300italic,400,400italic,500,600,700italic,700&subset=latin,latin-ext' ), "//fonts.googleapis.com/css" );
    }
    return $font_url;
}

//Disable all woocommerce styles
add_filter('woocommerce_enqueue_styles', '__return_false');

function solaz_scripts_js() {
    global $solaz_settings, $wp_query;
    $cat = $wp_query->get_queried_object();
    if(isset($cat->term_id)){
    $woo_cat = $cat->term_id;
    }else{
        $woo_cat = '';
    }
    $shop_list = '';
    if ( class_exists( 'WooCommerce' ) ) {
    $shop_list = is_product_category();
    }
    $product_list_mode = get_metadata('product_cat', $woo_cat, 'list_mode_product', true);
    $header_sticky_mobile = isset($solaz_settings['header-sticky-mobile'])? $solaz_settings['header-sticky-mobile'] : '';    
    // comment reply
    if ( is_singular() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
    // Loads our main js.
    
    wp_enqueue_script('jquery-ui', get_template_directory_uri() . '/js/jquery-ui.min.js', array('jquery'), SOLAZ_VERSION, true);
    wp_enqueue_script('bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), SOLAZ_VERSION, true);
    wp_enqueue_script('image-load', get_template_directory_uri() . '/js/imagesloaded.pkgd.min.js', array(), SOLAZ_VERSION, true);
    wp_enqueue_script('isotope', get_template_directory_uri() . '/js/isotope.pkgd.min.js', array(), SOLAZ_VERSION, true);  
    wp_enqueue_script('fancybox', get_template_directory_uri() . '/js/jquery.fancybox.pack.js', array(), SOLAZ_VERSION, true);
    wp_enqueue_script('fancybox-thumbs', get_template_directory_uri() . '/js/jquery.fancybox-thumbs.js', array(), SOLAZ_VERSION, true);
    wp_enqueue_script('owlcarousel', get_template_directory_uri() . '/js/owl.carousel.min.js', array(), SOLAZ_VERSION, true);
    wp_enqueue_script('slick', get_template_directory_uri() . '/js/slick.min.js', array(), SOLAZ_VERSION, true);    
    wp_enqueue_script('countdown', get_template_directory_uri() . '/js/jquery.countdown.min.js', array(), SOLAZ_VERSION, true);
    wp_enqueue_script('scrollreveal', get_template_directory_uri() . '/js/un-minify/scrollReveal.js', array(), SOLAZ_VERSION, true);
    wp_enqueue_script('elevate-zoom', get_template_directory_uri() . '/js/un-minify/jquery.elevatezoom.js', array('jquery'), SOLAZ_VERSION, true);
    wp_enqueue_script('appear', get_template_directory_uri() . '/js/un-minify/appear.js', array('jquery'), SOLAZ_VERSION, true);   
    
    wp_enqueue_script('validate', get_template_directory_uri() . '/js/jquery.validate.min.js', array('jquery'), SOLAZ_VERSION);
    if(is_rtl()){
        wp_enqueue_script('solaz-custom-rtl', get_template_directory_uri() . '/js/un-minify/custom-rtl.js', array(), SOLAZ_VERSION, true);
    }
    else{
        wp_enqueue_script('solaz-custom', get_template_directory_uri() . '/js/un-minify/custom.js', array(), SOLAZ_VERSION, true);
    }
    wp_enqueue_script('solaz-script', get_template_directory_uri() . '/js/un-minify/functions.js', array(), SOLAZ_VERSION, true);
    if (isset($solaz_settings['js-code'])){
        wp_add_inline_script( 'solaz-script', $solaz_settings['js-code'] ); 
    }  
    wp_localize_script('solaz-script', 'solaz_params', array(
        'ajax_url' => esc_js(admin_url( 'admin-ajax.php' )),
        'ajax_loader_url' => esc_js(str_replace(array('http:', 'https'), array('', ''), SOLAZ_CSS . '/images/ajax-loader.gif')),
        'ajax_cart_added_msg' => esc_html__('A product has been added to cart.', 'solaz'),
        'ajax_compare_added_msg' => esc_html__('A product has been added to compare', 'solaz'),
        'type_product' => $product_list_mode,
        'shop_list' => $shop_list,
        'under_end_date' => $solaz_settings['under-end-date'],
        'header_sticky' => $solaz_settings['header-sticky'],
        'header_sticky_mobile' => $header_sticky_mobile,
        'request_error' => esc_js(__('The requested content cannot be loaded.<br/>Please try again later.', 'solaz')),
        'popup_close' => esc_js(__('Close', 'solaz')),
        'popup_prev' => esc_js(__('Previous', 'solaz')),
        'popup_next' => esc_js(__('Next', 'solaz')),
    ));
}
add_action('wp_enqueue_scripts', 'solaz_scripts_js'); 
function solaz_get_current_url($echo = true) {
    global $wp;
    if($echo) {
        echo esc_url(home_url(add_query_arg(array(),$wp->request)));
    } else {
        return esc_url(home_url(add_query_arg(array(),$wp->request)));
    }
}
//Defer parsing of JavaScript
function solaz_myme_types($mime_types){
    $mime_types['svg'] = 'image/svg+xml'; //Adding svg extension
    return $mime_types;
}
add_filter('upload_mimes', 'solaz_myme_types', 1, 1);