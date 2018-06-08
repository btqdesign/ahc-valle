<?php
$output = $item_delay = $el_class = '';
extract(shortcode_atts(array(
	'container_type' => '',
    'item_delay' => '',
    'el_class' => ''
), $atts));
$count_item = 0.2; 
$animation_delay = '';
if($item_delay) {
    $animation_delay = ' data-sr="wait '. $count_item .'s"';  
}
$count_item += 0.2;
$el_class = arrowpress_shortcode_extract_class( $el_class );
if($container_type == '2'){
	$layout_class = 'container-fluid';
}
else if($container_type == '3'){
	$layout_class = 'container-fluid bigger-container';
}
else{
	$layout_class = 'container';
}
$output = '<div class="arrowpress-container ' . $layout_class . ' ' . $el_class . '"';
if ($animation_delay)
    $output .= ''.$animation_delay.'';
$output .= '>';
$output .= do_shortcode($content);
$output .= '</div>' . arrowpress_shortcode_end_block_comment( 'arrowpress_container' ) . "\n";

echo $output;