<?php
$solaz_settings = solaz_check_theme_options();
?>

<?php if (isset($solaz_settings['footer-copyright']) && $solaz_settings['footer-copyright']) : ?>
	<div class="bottom-footer text-center">
		<div class="container">	
		 	<h2 class="footer-logo">
                <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                	<?php 
                		$logo_footer = (solaz_get_meta_value('logo_footer_page') != '') ? solaz_get_meta_value('logo_footer_page') : $solaz_settings['logo_footer1']['url'];
                	?>                
                    <?php
                    if (isset($logo_footer) && $logo_footer != ''):
                        echo '<img class="" src="' . esc_url(str_replace(array('http:', 'https:'), '', $logo_footer)) . '" alt="' . esc_attr(get_bloginfo('name', 'display')) . '" />';
                    else:
                        bloginfo('name');
                    endif;
                    ?>
                </a>
            </h2>	
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
				)); ?></p>				
	
		</div>
	</div>
<?php endif;?>