<?php

/*
  Plugin Name: ArrowPress Shortcodes
  Plugin URI:
  Description: Shortcodes for ArrowPress Theme.
  Version: 1.0.0
  Author: ArrowPress
  Author URI:
 */

// don't load directly
if (!defined('ABSPATH'))
    die('-1');

define('ARROWPRESS_SHORTCODES_URL', plugin_dir_url(__FILE__));
define('ARROWPRESS_SHORTCODES_PATH', dirname(__FILE__) . '/shortcodes/');
define('ARROWPRESS_SHORTCODES_LIB', dirname(__FILE__) . '/lib/');
define('ARROWPRESS_SHORTCODES_TEMPLATES', dirname(__FILE__) . '/templates/');
define('ARROWPRESS_SHORTCODES_WOO_PATH', dirname(__FILE__) . '/woo_shortcodes/');
define('ARROWPRESS_SHORTCODES_WOO_TEMPLATES', dirname(__FILE__) . '/woo_templates/');
define('ARROWPRESS_SHORTCODES_CLASSES', dirname(__FILE__) . '/classes/');
class ArrowPressShortcodesClass {

    private $shortcodes = array("arrowpress_static_block","arrowpress_banner", "arrowpress_container", "arrowpress_get_widget", "arrowpress_testimonial", "arrowpress_gallery", "arrowpress_instagram_feed" );
    private $woo_shortcodes =array("arrowpress_product");
    function __construct() {

        // Load text domain
        add_action('plugins_loaded', array($this, 'loadTextDomain'));
        // Init plugins
        add_action('init', array($this, 'initPlugin'));

        $this->addShortcodes();
        add_filter('the_content', array($this, 'formatShortcodes'));
        add_filter('widget_text', array($this, 'formatShortcodes'));
        add_action('vc_base_register_front_css',  array($this,'arrowpress_iconpicker_base_register_css'));
        add_action('vc_base_register_admin_css', array($this,'arrowpress_iconpicker_base_register_css'));
        add_action('vc_backend_editor_enqueue_js_css', array($this,'arrowpress_iconpicker_editor_jscss'));
        add_action('vc_frontend_editor_enqueue_js_css', array($this,'arrowpress_iconpicker_editor_jscss'));
    }

    // Init plugins
    function initPlugin() {
        $this->addTinyMCEButtons();
    }

    // load plugin text domain
    function loadTextDomain() {
        load_plugin_textdomain('arrowpress-shortcodes', false, dirname(__FILE__) . '/languages/');
    }

    // Add buttons to tinyMCE
    function addTinyMCEButtons() {
        if (!current_user_can('edit_posts') && !current_user_can('edit_pages'))
            return;

        if (get_user_option('rich_editing') == 'true') {
            add_filter('mce_buttons', array(&$this, 'registerTinyMCEButtons'));
        }
    }

    function registerTinyMCEButtons($buttons) {
        array_push($buttons, "arrowpress_shortcodes_button");
        return $buttons;
    }

    // Add shortcodes
    function addShortcodes() {
        require_once(ARROWPRESS_SHORTCODES_LIB . 'functions.php');
        require_once(ARROWPRESS_SHORTCODES_LIB . 'arrowpress-post-type.php');
        require_once(ARROWPRESS_SHORTCODES_LIB . 'arrowpress-override-widget.php');
        foreach ($this->shortcodes as $shortcode) {
            require_once(ARROWPRESS_SHORTCODES_PATH . $shortcode . '.php');
        }
        if (  function_exists('is_plugin_active') && is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
            foreach ($this->woo_shortcodes as $woo_shortcode) {
                require_once(ARROWPRESS_SHORTCODES_WOO_PATH . $woo_shortcode . '.php');
            }
            if (function_exists('is_plugin_active') && is_plugin_active( 'yith-woocommerce-brands-add-on/init.php' )) {
                require_once(ARROWPRESS_SHORTCODES_WOO_PATH . 'arrowpress_brands' . '.php');
            }
        }

        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    }

    // Format shortcodes content
    function formatShortcodes($content) {
        $block = join("|", $this->shortcodes);
        // opening tag
        $content = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/", "[$2$3]", $content);
        // closing tag
        $content = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)/", "[/$2]", $content);

        return $content;
    }
    function arrowpress_iconpicker_base_register_css() {
        wp_register_style('pestrokefont', ARROWPRESS_SHORTCODES_URL  . 'assets/css/pe-icon-7-stroke.css', false, '1.0', 'screen');
        wp_register_style('arrowpressfont', get_template_directory_uri()  . '/css/icomoon.css', false, '1.0', 'screen');
    }

    function arrowpress_iconpicker_editor_jscss() {
        wp_enqueue_style('pestrokefont');
        wp_enqueue_style('arrowpressfont');
    }


}

// Finally initialize code
new ArrowPressShortcodesClass();
