<?php
// push your child theme functions here
function solaz_parent_btq_scripts() {
	wp_enqueue_style( 'solaz-parent-style', get_template_directory_uri() . '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'solaz_parent_btq_scripts' );

function solaz_child_scripts() {
    wp_enqueue_style( 'solaz-child-style', get_stylesheet_directory_uri() . '/style.css', 'solaz-parent-style');
}
add_action( 'wp_enqueue_scripts', 'solaz_child_scripts', 1000);

add_filter('final_output', function($output) {
    // Soporte HTTPS
    $output = str_replace('http:', 'https:', $output);
    $output = str_replace('https://schemas.xmlsoap.org', 'http://schemas.xmlsoap.org', $output);
    $output = str_replace('https://docs.oasisopen.org', 'http://docs.oasisopen.org', $output);
    return $output;
});

add_action( 'after_setup_theme', 'btq_menu' );
function btq_menu() {
  register_nav_menu( 'btq-menu', __( 'BTQ Menu', 'btq-menu' ) );
  register_nav_menu( 'btq-menu-terraza', __( 'BTQ Menu terraza', 'btq-menu-terraza' ) );
  register_nav_menu( 'btq-menu-banquete', __( 'BTQ Menu banquete', 'btq-menu-banquete' ) );
  register_nav_menu( 'btq-menu-en', __( 'BTQ Menu en', 'btq-menu-en' ) );
}

add_action( 'vc_before_init', 'btq_mailchimp_tag' );
function btq_mailchimp_tag() {
	vc_map(array(
		'name'     => __( 'BTQ Mailchimp tag', 'btq-booking-tc' ),
		'base'     => 'btq-mailchimp-tag',
		'class'    => '',
		'category' => __( 'Content', 'btq-mailchimp-tag'),
		'icon'     => 'icon-wpb-toggle-small-expand'
		//'icon'     => plugins_url( 'assets/images/iconos' . DIRECTORY_SEPARATOR . 'btqdesign-logo.png', __FILE__ )
	));
}

add_shortcode( 'btq-mailchimp-tag', 'btq_mailchimp_tag_shortcode' );
function btq_mailchimp_tag_shortcode() {
	$out = '';
	return $out;
}