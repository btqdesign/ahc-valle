<?php
function solaz_member_meta_data() {
    return array(
        array(
            "name" => "name",
            "title" => esc_html__("Name", 'solaz'),
            "type" => "textfield"
        ),
		array(
            "name" => "mail",
            "title" => esc_html__("Email", 'solaz'),
            "type" => "textfield"
        ),
    );
}
function solaz_view_member_meta_option() {
    $meta_box = solaz_member_meta_data();
    solaz_show_meta_box($meta_box);
}

function solaz_save_member_meta_option($post_id) {
    $meta_box = solaz_member_meta_data();
    return solaz_save_meta_data( $post_id, $meta_box );
}
function solaz_add_member_metaboxes() {
    if ( function_exists('add_meta_box') ) {
        add_meta_box( 'show-meta-boxes', esc_html__('Member Information', 'solaz'), 'solaz_view_member_meta_option', 'member', 'normal', 'low' );
    }
}
add_action('add_meta_boxes', 'solaz_add_member_metaboxes');
add_action('save_post', 'solaz_save_member_meta_option');