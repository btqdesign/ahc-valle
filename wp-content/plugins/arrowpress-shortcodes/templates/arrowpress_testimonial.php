<?php
$output = $css = $el_class = '';
extract(shortcode_atts(array(
    'tes_style' => 'style1',
    'name_author' => '',
    'description' => '',
    'image' => '',
    'info' => '',
    'info_color' => '',
    'title_color' => '',
    'desc_color' => '',
    'el_class' => '',
    'css' => '',
), $atts));
$bgImage = wp_get_attachment_url($image);
$el_class = arrowpress_shortcode_extract_class( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), 'arrowpress_testimonial', $atts );
$output .= '<div class="testimonial-container ' . esc_html($el_class) . esc_html($css_class ). '">';
ob_start();
?>  
<?php if($tes_style == 'style1') :?>      
<div class="item_testimonial text-center">
		<img src="<?php echo esc_url($bgImage);?>" alt="img-testimonial"/>	
		<div class="caption_testimonial"> 
			<p class="item-desc"
			<?php if($desc_color != ''):?>
	                style="color: <?php echo $desc_color;?>"
	            <?php endif;?>
			><?php echo $description;?></p>
			<div class="tes_name">
				<h4 <?php if($title_color != ''):?>
		            style="color: <?php echo $title_color;?>"
		        <?php endif;?>
		    	><?php echo $name_author; ?></h4> 			
			</div>	
			<p <?php if($info_color != ''):?>
	            style="color: <?php echo $info_color;?>"
	        <?php endif;?>
	    	><?php echo $info; ?></p> 						
		</div>
</div>
<?php endif;?>
<?php
$output .= ob_get_clean();

$output .= '</div>' . arrowpress_shortcode_end_block_comment( 'arrowpress_testimonial' ) . "\n";
echo $output;


wp_reset_postdata();

