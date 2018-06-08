<?php
/*
 Template Name: Coming soon
 */
 ?>
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
<body class="home">
<div id="primary" class="site-content">
    <div id="content" role="main">
    	<div class="page-coming-soon text-center has_overlay2">
	        <div class="container">
				<div class="row">  	
					<div class="col-md-12 col-sm-12 col-xs-12 coming-soon-container">
						<div class="coming_heading">
							<div class="logo text-center">
								<a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
									<?php
				                        if ($solaz_settings['logo-coming'] && $solaz_settings['logo-coming']['url']):
				                            echo '<img class="" src="' . esc_url(str_replace(array('http:', 'https:'), '', $solaz_settings['logo-coming']['url'])) . '" alt="' . esc_attr(get_bloginfo('name', 'display')) . '" />';
				                        else:
				                            bloginfo('name');
				                        endif;
				                    ?>
								</a>
							</div>
						</div>			
						<div class="coming-soon">
							<div class="coming-sub">
								<?php if(isset($solaz_settings['under-contr-title']) && $solaz_settings['under-contr-title'] != ''):?>
									<h3 class="title-behind"><?php echo esc_html($solaz_settings['under-contr-title']);?></h3>
								<?php endif;?>					
							</div>

							<?php if($solaz_settings['under-display-countdown'] == 1):?>
								<?php 
								if(!isset($solaz_settings['under-end-date']) || $solaz_settings['under-end-date'] == ""){
									$solaz_settings['under-end-date'] ="06/30/2017";
								}
								?>
								<?php if(isset($solaz_settings['under-end-date']) && $solaz_settings['under-end-date'] != ''):?>
								<div id="getting-started"></div>
								<?php endif;?>
							<?php endif;?>
							<div class="coming-subcribe">
								<p><?php echo esc_html__("Register now and be among the first to know more.",'solaz');?></p>
								<?php if($solaz_settings['under-mail'] == 1):?>
									<?php
										if( function_exists( 'mc4wp_show_form' ) ) {
										    mc4wp_show_form();
										}
									?>
								<?php endif;?>
							</div>
						</div>
						<div class="coming-footer">
							<?php if (isset($solaz_settings['footer-info']) && $solaz_settings['footer-info']) : ?>
								<div class="footer_info">
									<p><?php echo force_balance_tags(wp_kses($solaz_settings['footer-info'],array('i'=>array('class' =>array()),
										'a'=>array(
											'href'=>array(), 
											'target' =>array()
											))
										)); ?></p>	
								</div>
							<?php endif;?>
							<p><?php echo force_balance_tags(wp_kses($solaz_settings['footer-copyright'],array('i'=>array('class' =>array()),
								'a'=>array(
									'href'=>array(), 
									'target' =>array()
									))
								)); ?>
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
    </div><!-- #content -->
</div><!-- #primary -->
</body>
<?php wp_footer(); ?>
</html>
