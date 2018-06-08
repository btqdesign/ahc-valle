<?php
$solaz_settings = solaz_check_theme_options();
?>
<?php 
$footer_wrap = "";
if(!is_active_sidebar('footer2-column-1') && !is_active_sidebar('footer2-column-2') ||
   !is_active_sidebar('footer2-column-3') && !is_active_sidebar('footer2-column-4')){
	$footer_wrap = 'no-sidebar';
}
?>
<div class="footer_wrap">

		<?php
	        $cols = 0;
	        for ($i = 1; $i <= 3; $i++) {
	            if (is_active_sidebar('footer2-column-' . $i))
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
	                    $col_class[1] = 'col-sm-6 col-xs-12 col-md-6';
	                    $col_class[2] = 'col-sm-6 col-xs-12 col-md-6 fr_col2';
	                    break;
	                case 3:
	                    $col_class[1] = 'col-xs-12 col-sm-4 col-md-4';
	                    $col_class[2] = 'col-xs-12 col-sm-4 col-md-4 ';
	                    $col_class[3] = 'col-xs-12 col-sm-4 col-md-4';
	                    break;
	            }
	    ?>
		<div class="footer-office">
			<div class="container">
				<div class="row">
					<div class="col-md-4 col-sm-12 col-xs-12">
						<?php if (isset($solaz_settings['footer-copyright']) && $solaz_settings['footer-copyright']) : ?>
							<div class="bottom-footer text-center">

								 	<h2 class="footer-logo">
						                <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
						                    <?php
						                    if ($solaz_settings['logo_footer2'] && $solaz_settings['logo_footer2']['url']):
						                        echo '<img class="" src="' . esc_url(str_replace(array('http:', 'https:'), '', $solaz_settings['logo_footer2']['url'])) . '" alt="' . esc_attr(get_bloginfo('name', 'display')) . '" />';
						                    else:
						                        bloginfo('name');
						                    endif;
						                    ?>
						                </a>
						            </h2>	
									<p><?php echo force_balance_tags(wp_kses($solaz_settings['footer-copyright'],array('i'=>array('class' =>array()),
										'a'=>array(
											'href'=>array(), 
											'target' =>array()
											))
										)); ?></p>				
							
							</div>
						<?php endif;?>						
					</div>				
	            	<div class="footer-office-content fr_col2 col-lg-push-1 col-md-8 col-sm-12 col-xs-12">
	                    <?php
	                    $cols = 1;
	                    for ($i = 1; $i <= 3; $i++) {
	                        if (is_active_sidebar('footer2-column-' . $i)) {
	                            ?>
	                            <div class="<?php echo esc_attr($col_class[$cols++]) ?>">
	                                <?php dynamic_sidebar('footer2-column-' . $i); ?>
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