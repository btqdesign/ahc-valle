<?php
add_action( 'widgets_init', 'solaz_filter_override_woocommerce_widgets', 15 );
function solaz_filter_override_woocommerce_widgets() {
     if ( class_exists( 'WC_Widget_Price_Filter' ) ) {
         unregister_widget( 'WC_Widget_Price_Filter' );
         include get_template_directory() . '/woocommerce/classes/class-wc-widget-price-filter.php';
         register_widget( 'solaz_filter_WC_Widget_Price_Filter' );
     }
} 

