<?php
function solaz_show_room_default_meta_option() {
    $meta_box = solaz_default_meta_data();
    solaz_show_meta_box($meta_box);
}
function solaz_save_room_default_meta_option($post_id) {
    $meta_box = solaz_default_meta_data();
    return solaz_save_meta_data($post_id, $meta_box);
}
function solaz_add_room_metaboxes() {
    if ( function_exists('add_meta_box') ) {
        add_meta_box('view-meta-boxes', esc_html__('Layout Options', 'solaz'), 'solaz_show_room_default_meta_option', 'hb_room', 'normal', 'low');
    }
}
add_action('add_meta_boxes', 'solaz_add_room_metaboxes');
add_action('save_post', 'solaz_save_room_default_meta_option');