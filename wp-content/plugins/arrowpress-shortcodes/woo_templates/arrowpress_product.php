<?php

$output = $title = $per_page = $columns = $orderby = $order = $el_class = '';
extract( shortcode_atts( array(
    'title' => '',
    'per_page' => 12,
    'columns' => 4,
    'orderby' => 'date',
    'order' => 'desc',
    'el_class' => ''
), $atts ) );

$el_class = arrowpress_shortcode_extract_class( $el_class );

$output = '<div class="product-grid arrowpress-products wpb_content_element' . $el_class . '"';
$output .= '>';

if ( $title ) {
   $output .= '<h2 class="section-title">'.$title.'</h2>';
}

global $woocommerce_loop;

$woocommerce_loop['columns'] = $columns;

$output .= do_shortcode('[recent_products per_page="'.$per_page.'" columns="'.$columns.'" orderby="'.$orderby.'" order="'.$order.'"]');

$output .= '</div>';

echo $output;