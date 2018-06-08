<?php 
$solaz_settings = solaz_check_theme_options(); 

if ( defined( 'ICL_LANGUAGE_CODE' ) ) {
	$idioma = ICL_LANGUAGE_CODE;
}
else {
	$idioma = 'es';
}

if ($idioma == 'es'){
	$google_tag_manager_head = "
	<!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-W8P8X4');</script>
	<!-- End Google Tag Manager -->
	";
	
	$google_tag_manager_body = '
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-W8P8X4"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->
	';
}
else {
	$google_tag_manager_head = "
	<!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-PK97P2');</script>
	<!-- End Google Tag Manager -->
	";
	
	$google_tag_manager_body = '
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PK97P2"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->
	';
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<?php echo $google_tag_manager_head; ?>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <?php if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) :?>
        <?php if (!empty($solaz_settings['favicon'])): ?>
            <link rel="shortcut icon" href="<?php echo esc_url(str_replace(array('http:', 'https:'), '', $solaz_settings['favicon']['url'])); ?>" type="image/x-icon" />
        <?php endif; ?>
    <?php endif;?>    
    <?php wp_head(); ?>
</head>
<?php
$solaz_sidebar_left = solaz_get_sidebar_left();
$solaz_sidebar_right = solaz_get_sidebar_right();
$solaz_layout = solaz_get_layout();
$header_type = solaz_get_header_type();
$solaz_remove_space_br = solaz_get_meta_value('remove_space_br', true);
$solaz_remove_space = solaz_get_meta_value('remove_space', true);
$solaz_header_fixed = get_post_meta(get_the_ID(), 'header_fixed', true);
$header_class = '';
if($solaz_header_fixed){
    $header_class .= ' fixed-header';
}
if (is_404() ) {
    $solaz_layout .=  'wide';
}
?>
<body <?php body_class(); ?>>
	<?php echo $google_tag_manager_body; ?>
    <?php echo solaz_pre_loader();?>
	<div id="page" class="hfeed site <?php if(!$solaz_remove_space){echo 'remove_space';}?> 
                                     <?php if(!$solaz_remove_space_br){echo 'remove_space_br';}?> 
                                     <?php echo esc_attr($header_class);?>">
        <?php if (solaz_get_meta_value('show_header', true)) : ?>
            <header id="masthead" class="site-header header-v<?php echo esc_attr($header_type); ?>">
                <?php get_template_part('headers/header_' . $header_type); ?>
            </header> <!-- End masthead -->
        <?php endif; ?>
        <?php get_template_part('breadcrumb'); ?>
        <?php solaz_get_page_banner();?>
        <div id="main" class="wrapper <?php if($solaz_layout == 'fullwidth'){echo 'boxed';}?>">
        <?php if($solaz_layout == 'fullwidth') :?>
            <div class="container">
                <div class="row">         
        <?php endif;?> 
       
