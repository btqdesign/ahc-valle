<?php
function solaz_testimonial_meta_data() {
    return array(
        array(
            "name" => "tes_name",
            "title" => esc_html__("Name", 'solaz'),
            "type" => "textfield"
        ), 
        array(
            "name" => "address",
            "title" => esc_html__("Address", 'solaz'),
            "type" => "textfield"
        ),
		array(
            "name" => "occupation",
            "title" => esc_html__("Occupation", 'solaz'),
            "type" => "textfield"
        ),  
    );
}
function solaz_view_testimonial_meta_option() {
    $meta_box = solaz_testimonial_meta_data();
    solaz_show_meta_box($meta_box);
}

function solaz_save_testimonial_meta_option($post_id) {
    $meta_box = solaz_testimonial_meta_data();
    return solaz_save_meta_data( $post_id, $meta_box );
}
function solaz_add_testimonial_metaboxes() {
    if ( function_exists('add_meta_box') ) {
        add_meta_box( 'show-meta-boxes', esc_html__('Information', 'solaz'), 'solaz_view_testimonial_meta_option', 'testimonial', 'normal', 'low' );
    }
}
add_action('add_meta_boxes', 'solaz_add_testimonial_metaboxes');
add_action('save_post', 'solaz_save_testimonial_meta_option');