<?php
$output =  $el_class = $title = $widget_name = $nav= $col_num= $text_link= $row_num='';
extract(shortcode_atts(array(
    'widget_name' =>'',
    'title' => '',
    'el_class' => '',
    'nav' => 1,
    'col_num' => '',
    'row_num' => '',
    'text_link' => '',
), $atts));
if (class_exists('WP_Hotel_Booking')){
    if($widget_name == 'ArrowPress_Override_Widget_Room_Carousel'){
    	$instance = array(
        	'title' => $title,
        	'number' => $col_num,
        	'nav' => 1,
        	'row_number' => $row_num,
        	'text_link' => $text_link,
        );	
    }else{
    	$instance = array(
        	'title' => $title,
        );	
    }    
$el_class = arrowpress_shortcode_extract_class($el_class);
echo "<div class='solaz_get_widget".esc_attr($el_class)."'>";
the_widget( $widget_name, $instance); 
echo "</div>";
}

wp_reset_postdata();