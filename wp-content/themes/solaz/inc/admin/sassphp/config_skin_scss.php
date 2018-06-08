<?php 
$config = solaz_check_theme_options();
?>

//SKIN
//General
$general_bg_color: <?php echo esc_attr($config['general-bg']['background-color']) ?>;
$general_bg_image: url('<?php echo esc_attr($config['general-bg']['background-image']) ?>');
$general_bg_repeat: <?php echo esc_attr($config['general-bg']['background-repeat']) ?>;
$general_bg_position: <?php echo esc_attr($config['general-bg']['background-position']) ?>;
$general_bg_size: <?php echo esc_attr($config['general-bg']['background-size']) ?>;
$general_bg_attachment: <?php echo esc_attr($config['general-bg']['background-attachment']) ?>;
$general_font_family: <?php echo esc_attr($config['general-font']['font-family']) ?>;
$general_font_weight: <?php echo esc_attr($config['general-font']['font-weight']) ?>;
$general_font_size: <?php echo esc_attr($config['general-font']['font-size']) ?>;
$general_font_color: <?php echo esc_attr($config['general-font']['color']) ?>;
$general_line_height: <?php echo esc_attr($config['general-font']['line-height']) ?>;
$primary_color: <?php
		if(isset( $config['primary-color'] )){
			echo esc_attr($config['primary-color']) ;
		}else{
			echo '#8262b5';
		}
?>;
$highlight_color: <?php echo esc_attr($config['highlight-color']) ?>;
//Header
$header_bg: <?php echo esc_attr($config['header-bg']) ?>;
//Footer
$footer_bg: <?php echo esc_attr($config['footer-bg']) ?>;
$footer_color: <?php echo esc_attr($config['footer-color']) ?>;
//Breadcrumbs 1
$breadcrumb_bg_image: url('<?php echo esc_url(str_replace(array('http:', 'https:'), '', $config['breadcrumbs-bg']['background-image'])) ?>');
$breadcrumb_bg_repeat: <?php echo esc_attr($config['breadcrumbs-bg']['background-repeat']) ?>;
$breadcrumb_bg_position: <?php
		if(isset( $config['breadcrumbs-bg']['background-position'] )){
			echo esc_attr($config['breadcrumbs-bg']['background-position']) ;
		}else{
			echo 'left top';
		}
?>;
$breadcrumb_bg_size: <?php echo esc_attr($config['breadcrumbs-bg']['background-size']) ?>;
$breadcrumb_bg_attachment: <?php echo esc_attr($config['breadcrumbs-bg']['background-attachment']) ?>;

//Typography
$h1_font_family: <?php echo esc_attr($config['h1-font']['font-family']) ?>;
$h1_font_size: <?php echo esc_attr($config['h1-font']['font-size']) ?>;
$h1_font_color: <?php echo esc_attr($config['h1-font']['color']) ?>;
$h2_font_family: <?php echo esc_attr($config['h2-font']['font-family']) ?>;
$h2_font_size: <?php echo esc_attr($config['h2-font']['font-size']) ?>;
$h2_font_color: <?php echo esc_attr($config['h2-font']['color']) ?>;
$h3_font_family: <?php echo esc_attr($config['h3-font']['font-family']) ?>;
$h3_font_size: <?php echo esc_attr($config['h3-font']['font-size']) ?>;
$h3_font_color: <?php echo esc_attr($config['h3-font']['color']) ?>;
$h4_font_family: <?php echo esc_attr($config['h4-font']['font-family']) ?>;
$h4_font_size: <?php echo esc_attr($config['h4-font']['font-size']) ?>;
$h4_font_color: <?php echo esc_attr($config['h4-font']['color']) ?>;
$h5_font_family: <?php echo esc_attr($config['h5-font']['font-family']) ?>;
$h5_font_size: <?php echo esc_attr($config['h5-font']['font-size']) ?>;
$h5_font_color: <?php echo esc_attr($config['h5-font']['color']) ?>;
$h6_font_family: <?php echo esc_attr($config['h6-font']['font-family']) ?>;
$h6_font_size: <?php echo esc_attr($config['h6-font']['font-size']) ?>;
$h6_font_color: <?php echo esc_attr($config['h6-font']['color']) ?>;