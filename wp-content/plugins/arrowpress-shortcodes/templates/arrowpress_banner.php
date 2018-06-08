<?php
$output = $image = $btn_text = $btn_layout = $type_icon = $text_align = $layout = $small_title = $big_title = $link = $el_class = $bg_hover_color = $icon_size= $title_color = $sm_title_color = $text_color = $overlay_bg= $color_bg= $top= $left = $en_overlay= '';
extract(shortcode_atts(array(
	'layout' => 'banner_style_1',
	'image' => '',
	'image_2' => '',
	'text_align' => 'center',
	'small_title' => '',
	'big_title' => '',
	'title_color' => '',
	'sm_title_color' => '',
	'bg_hover_color' => '',
	'top' => '',
	'left' => '',
	'text_color' => '',
	'overlay_bg' => '',
	'color_bg' => '',
	'title_content' => '',
	'type_icon'	=> '',
    'icon_arrowpressfont' => '',
    'icon_linecons' => '',
    'icon_fontawesome' => '',
    'icon_openiconic' => '',
    'icon_typicons' => '',
    'icon_arrowpress' => '',
    'icon_entypo' => '',
	'btn_layout' => 'btn_layout_1',
    'btn_text' => __('Shop Now', 'arrowpress'),
    'link' => '#',
    'icon_size' => '',
    'item_delay' => '',
    'en_overlay' => '',
    'animation_type' => '',
    'animation_delay' => 500,
    'ult_icon' => '',
    'el_class' => ''
                ), $atts));
$href = vc_build_link($link);
$icon_class = "";
if($ult_icon!=''){
	$icon_class= $ult_icon;
}else{
	if (!empty($icon_arrowpress)) {
	    $icon_class = $icon_arrowpress;
	} elseif (!empty($icon_fontawesome)) {
	    $icon_class = $icon_fontawesome;
	} elseif (!empty($icon_openiconic)) {
	    $icon_class = $icon_openiconic;
	} elseif (!empty($icon_typicons)) {
	    $icon_class = $icon_typicons;
	} elseif (!empty($icon_entypo)) {
	    $icon_class = $icon_entypo;
	} elseif (!empty($icon_linecons)) {
	    $icon_class = $icon_linecons;
	}elseif (!empty($icon_arrowpressfont)) {
	    $icon_class = $icon_arrowpressfont;
	}
}

$bgImage = wp_get_attachment_url($image);
$bgImage_2 = wp_get_attachment_url($image_2);
$el_class = arrowpress_shortcode_extract_class($el_class);
$id =  'arp_banner-'.wp_rand();
$output = '<div class="banner-container ' . esc_html($el_class).'" id="'.esc_html($id).'"';
$output .= '>';

/**
 * Style inline
 **/
	$title_style_inline = $sm_style_i = $text_style_i = $bg_style_4='';
	if($title_color != ''){
		$title_style_inline = 'style ="color: '.esc_attr($title_color).'"';
	}
	if($sm_title_color != ''){
		$sm_style_i = 'style ="color: '.esc_attr($sm_title_color).'"';
	}
	if($text_color != ''){
		$text_style_i = 'style ="color: '.esc_attr($text_color).'"';
	}
	if($color_bg !=''){
		$bg_style_4 = 'style ="background: '.esc_attr($color_bg).'"';
	}
	if($icon_size != ''){
		$data_i_size ='style="font-size:'.$icon_size.'px;';
		if($left){
			$data_i_size .='left:'.$left.'px;';
		}
		if($top){
			$data_i_size .= 'margin-top:'.$top.'px;';
		}
		$data_i_size .='"';
	}else{
		$data_i_size ='style="';
		if($left){
			$data_i_size .='left:'.$left.'px;';
		}
		if($top){
			$data_i_size .= 'margin-top:'.$top.'px;';
		}
		$data_i_size .='"';
	}
ob_start();
?> 
<?php if($layout == 'banner_style_1') :?>   
	<div class="banner-content banner-type0  
		<?php if($text_align == 'center'){echo 'text-center';}?>
		<?php if($text_align == 'left'){echo 'text-left';}?>
		<?php if($text_align == 'right'){echo 'text-right';}?> 
		<?php if($en_overlay == 'yes'){echo 'en_overlay';} ?>
		<?php if($item_delay == 'yes'){echo 'animated animated_custom';} ?>" data-animation-delay="<?php echo $animation_delay; ?>" data-animation="<?php echo $animation_type; ?>">
		<div class="img-banner">
			<?php if($bgImage):?>
				<a href="<?php echo esc_url($href['url']); ?>">
				<img src="<?php echo esc_url($bgImage);?>" alt="img">
				</a>
			<?php endif;?>
		</div>
		<div class="banner-desc">
			<?php if($type_icon!='font_icon'):?>
				<?php if($bgImage_2):?>
					<img src="<?php echo esc_url($bgImage_2);?>" alt="img">
				<?php endif;?>	
			<?php elseif($icon_class != ''):?>
				<div class="banner_icon" <?php echo $data_i_size;?>>
					<i class="<?php echo $icon_class; ?>"></i>					
				</div>
			<?php endif;?>	
			<?php if($big_title != '') :?>
				<h3 <?php echo $title_style_inline;?>><?php echo esc_html($big_title); ?></h3>
			<?php endif; ?>	
			<div class="hide-content transition display-onhover animated animated_custom">
				<?php if($small_title != '') :?>
					<p <?php echo $sm_style_i;?>><?php echo esc_html($small_title); ?></p>
				<?php endif; ?>										
			</div>	
		</div>
	</div>
<?php elseif($layout == 'banner_style_2'): ?>
	<div class="banner-content banner-type-2 
		<?php if(!$bgImage){echo 'b_without_image';}?> 
		<?php if($text_align == 'center'){echo 'text-center';}?>
		<?php if($text_align == 'left'){echo 'text-left';}?>
		<?php if($text_align == 'right'){echo 'text-right';}?> 
		<?php if($item_delay == 'yes'){echo 'animated animated_custom';} ?>" data-animation-delay="<?php echo $animation_delay; ?>" data-animation="<?php echo $animation_type; ?>">
		<div class="img-banner">
			<?php if($bgImage):?>
				<img src="<?php echo esc_url($bgImage);?>" alt="img">
			<?php endif;?>
		</div>
		<div class="banner-desc " <?php echo $text_style_i;?>>
			<?php if($small_title != '') :?>
				<h5 <?php echo $sm_style_i;?>><?php echo esc_html($small_title); ?></h5>
			<?php endif; ?>			
			<?php if($big_title != '') :?>
				<h2 <?php echo $title_style_inline;?>><?php echo esc_html($big_title); ?></h2>
			<?php endif; ?>		
			<?php 
				echo wpb_js_remove_wpautop(do_shortcode($content), true);
			?>		
			<?php if($btn_text == '') :?>
			<?php else: ?>
				<div class="btn-banner">
					<a href="<?php echo esc_url($href['url']); ?>" class="btn  btn-default">
					   <?php echo esc_html($btn_text); ?>
					</a>
				</div>
			<?php endif; ?>
		</div>
	</div>
<?php elseif($layout == 'banner_style_3'): ?>
	<div class="banner-content banner-type-3  
		<?php if($text_align == 'center'){echo 'text-center';}?>
		<?php if($text_align == 'left'){echo 'text-left';}?>
		<?php if($text_align == 'right'){echo 'text-right';}?> 
		<?php if($item_delay == 'yes'){echo 'animated animated_custom';} ?>" data-animation-delay="<?php echo $animation_delay; ?>" data-animation="<?php echo $animation_type; ?>">
		<div class="img-banner">
			<?php if($bgImage):?>
				<img src="<?php echo esc_url($bgImage);?>" alt="img">
			<?php endif;?>
		</div>
		<div class="banner-desc " <?php echo $text_style_i;?>>
			<?php if($type_icon!='font_icon'):?>
				<?php if($bgImage_2):?>
					<img src="<?php echo esc_url($bgImage_2);?>" alt="img">
				<?php endif;?>	
			<?php elseif($icon_class != ''):?>
				<div class="banner_icon"   <?php echo $data_i_size;?>>
					<i class="<?php echo $icon_class; ?>"></i>					
				</div>
			<?php endif;?>			
			<?php if($big_title != '') :?>
				<h3 <?php echo $title_style_inline;?>><?php echo esc_html($big_title); ?></h3>
			<?php endif; ?>	
			<div class="hide-content transition display-onhover animated animated_custom">			
			<?php if($small_title != '') :?>
				<h5 <?php echo $sm_style_i;?>><?php echo esc_html($small_title); ?></h5>
			<?php endif; ?>	
			<?php 
				echo wpb_js_remove_wpautop(do_shortcode($content), true);
			?>	
			</div>	
			
		</div>
		<?php if($btn_text == '') :?>
		<?php else: ?>
			<div class="btn-banner">
				<a href="<?php echo esc_url($href['url']); ?>" class="btn  btn-primary">
				   <?php echo esc_html($btn_text); ?>
				</a>
			</div>
		<?php endif; ?>		
	</div>
<?php elseif($layout == 'banner_style_4'):?>
	<div class="banner-content banner-style-4  
		<?php if($text_align == 'center'){echo 'text-center';}?>
		<?php if($text_align == 'left'){echo 'text-left';}?>
		<?php if($text_align == 'right'){echo 'text-right';}?> 
		<?php if($item_delay == 'yes'){echo 'animated animated_custom';} ?>" 
		<?php if($bg_hover_color != ''){echo 'data-hover-color="'.esc_attr($bg_hover_color).'"';}?> data-animation-delay="<?php echo $animation_delay; ?>" data-animation="<?php echo $animation_type; ?>" <?php echo $bg_style_4;?>>
			<?php if($bg_hover_color != ''):?>
				<style type="text/css">
					#<?php echo $id;?> .banner-style-4.banner-content:before{
						background: <?php echo esc_attr($bg_hover_color);?>;
					}
				</style>
			<?php endif;?>		
			<div class="service-content" >	
				<?php if($type_icon!='font_icon'):?>
					<?php if($bgImage_2):?>
						<div class="abs_icon">
							<img src="<?php echo esc_url($bgImage_2);?>" alt="img">
						</div>
					<?php endif;?>	
				<?php elseif($icon_class != ''):?>
					<div class="banner_icon abs_icon "  <?php echo $data_i_size;?>>
						<i class="<?php echo $icon_class; ?>"></i>					
					</div>
				<?php endif;?>	
				<?php if($big_title != '') :?>
					<h3 <?php echo $title_style_inline;?>><?php echo esc_html($big_title); ?></h3>
				<?php endif; ?>									
			</div>			
	</div>
<?php elseif($layout == 'banner_style_5'): ?>
	<div class="banner-content banner-type-5  
		<?php if($text_align == 'center'){echo 'text-center';}?>
		<?php if($text_align == 'left'){echo 'text-left';}?>
		<?php if($text_align == 'right'){echo 'text-right';}?> 
		<?php if($item_delay == 'yes'){echo 'animated animated_custom';} ?>" data-animation-delay="<?php echo $animation_delay; ?>" data-animation="<?php echo $animation_type; ?>">
		<div class="banner-desc " <?php echo $text_style_i;?>>
			<?php if($big_title != '') :?>
				<h2 <?php echo $title_style_inline;?>><?php echo esc_html($big_title); ?></h2>
			<?php endif; ?>		
			<?php if($small_title != '') :?>
				<h4 <?php echo $sm_style_i;?>><?php echo esc_html($small_title); ?></h4>
			<?php endif; ?>		
			<?php 
				echo wpb_js_remove_wpautop(do_shortcode($content), true);
			?>	
		</div>
	</div>
<?php else: ?>
	<div class="banner-content   
		<?php if($text_align == 'center'){echo 'text-center';}?>
		<?php if($text_align == 'left'){echo 'text-left';}?>
		<?php if($text_align == 'right'){echo 'text-right';}?> 
		<?php if($item_delay == 'yes'){echo 'animated animated_custom';} ?>" data-animation-delay="<?php echo $animation_delay; ?>" data-animation="<?php echo $animation_type; ?>">
		<div class="img-banner">
			<?php if($bgImage):?>
				<a href="<?php echo esc_url($href['url']); ?>">
				<img src="<?php echo esc_url($bgImage);?>" alt="img">
				</a>
			<?php endif;?>
		</div>
		<div class="banner-desc">
			<?php if($type_icon!='font_icon'):?>
				<?php if($bgImage_2):?>
					<img src="<?php echo esc_url($bgImage_2);?>" alt="img">
				<?php endif;?>	
			<?php elseif($icon_class != ''):?>
				<div class="banner_icon "  <?php echo $data_i_size;?>>
					<i class="<?php echo $icon_class; ?>"></i>					
				</div>
			<?php endif;?>	
			<?php if($big_title != '') :?>
				<h3 <?php echo $title_style_inline;?>><?php echo esc_html($big_title); ?></h3>
			<?php endif; ?>	
			<div class="hide-content transition display-onhover animated animated_custom">
				<?php if($small_title != '') :?>
					<p <?php echo $sm_style_i;?>><?php echo esc_html($small_title); ?></p>
				<?php endif; ?>										
			</div>	
		</div>
	</div>

<?php endif; ?>
<?php
$output .= ob_get_clean();
$output .= '</div>' . arrowpress_shortcode_end_block_comment('arrowpress_banner') . "\n";

echo $output;


wp_reset_postdata();