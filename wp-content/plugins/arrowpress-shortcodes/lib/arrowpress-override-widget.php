<?php
add_action( 'widgets_init', 'arrowpress_override_room_carousel', 15 );
function arrowpress_override_room_carousel() {
    if ( class_exists( 'HB_Widget_Room_Carousel' ) ) {
        unregister_widget( 'HB_Widget_Room_Carousel' );
        // include ARROWPRESS_SHORTCODES_URL . '/classes/class-hb-widget-room-carousel.php';
        include ARROWPRESS_SHORTCODES_CLASSES . 'class-hb-widget-room-carousel.php';
        register_widget( 'ArrowPress_Override_Widget_Room_Carousel' );
    }
}  