<?php
$solaz_settings = solaz_check_theme_options();
?>
<div class="footer_wrap">

	<?php if (isset($solaz_settings['footer-copyright']) && $solaz_settings['footer-copyright']) : ?>
		<div class="bottom-footer text-center">
			<div class="container">	
			 	<h2 class="footer-logo">
	                <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
	                	<?php 
	                		$logo_footer = (solaz_get_meta_value('logo_footer_page') != '') ? solaz_get_meta_value('logo_footer_page') : $solaz_settings['logo_footer3']['url'];
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
		<?php
	        $cols = 0;
	        for ($i = 1; $i <= 2; $i++) {
	            if (is_active_sidebar('footer3-column-' . $i))
	                $cols++;
	        }
        ?>
		<?php
	        if ($cols) :
	            $col_class = array();
	            switch ($cols) {
	                case 1:
	                    $col_class[1] = 'col-sm-12';
	                    break;
	                case 2:
	                    $col_class[1] = 'col-sm-8 col-xs-12 col-md-8';
	                    $col_class[2] = 'col-sm-4 col-xs-12 col-md-4 text-right xs_t_left';
	                    break;
	            }
	    ?>
		<div class="footer-bottom">
			<div class="container">
				<div class="row">
	            	<div class="footer-office-content">
	                    <?php
	                    $cols = 1;
	                    for ($i = 1; $i <= 2; $i++) {
	                        if (is_active_sidebar('footer3-column-' . $i)) {
	                            ?>
	                            <div class="<?php echo esc_attr($col_class[$cols++]) ?>">
	                                <?php dynamic_sidebar('footer3-column-' . $i); ?>
	                            </div>
	                            <?php
	                        }
	                    }
	                    ?>
	                </div>    								
        		</div>
       		</div>
		</div>
       <?php endif; ?>
</div>
