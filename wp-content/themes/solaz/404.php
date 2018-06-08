<?php $solaz_settings = solaz_check_theme_options(); ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <?php if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) :?>
        <?php if (!empty($solaz_settings['favicon'])): ?>
            <link rel="shortcut icon" href="<?php echo esc_url(str_replace(array('http:', 'https:'), '', $solaz_settings['favicon']['url'])); ?>" type="image/x-icon" />
        <?php endif; ?>
    <?php endif;?>    
    <?php wp_head(); ?>
</head>
<body class="not-found">
<?php get_header(); ?>
<div id="primary" class="site-content">
    <div id="content" role="main">
		        <div class="page-404 text-center has_overlay">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-12 col-sm-12 no-padding col-xs-12 page-404-container">
						<div class="content-404">
							<div class="content-desc">
								<h1><?php echo esc_html__('404 page', 'solaz');?></h1>
								<p><?php echo esc_html__('Sorry, we couldn &rsquo; t find the page you  &rsquo; re looking for.', 'solaz');?></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
    </div><!-- #content -->
</div><!-- #primary -->
<?php get_footer(); ?>
</body>
<?php wp_footer(); ?>
</html>
