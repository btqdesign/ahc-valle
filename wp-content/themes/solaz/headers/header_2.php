<?php
$solaz_settings = solaz_check_theme_options();
?>

<div class="header-wrapper">
        <?php if (is_front_page()) : ?>
            <h1 class="header-logo">
            <?php else : ?>
                <h2 class="header-logo">
                <?php endif; ?>
                <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                    <?php
                    if ($solaz_settings['logo2'] && $solaz_settings['logo2']['url']):
                        echo '<img class="" src="' . esc_url(str_replace(array('http:', 'https:'), '', $solaz_settings['logo2']['url'])) . '" alt="' . esc_attr(get_bloginfo('name', 'display')) . '" />';
                    else:
                        bloginfo('name');
                    endif;
                    ?>
                </a>
                <?php if (is_front_page()) : ?>
            </h1>
        <?php else : ?>
            </h2>
        <?php endif; ?>
        <div class="header-center">
	        <nav id="site-navigation" class="main-navigation">
	        	<button class="btn-open btn-menu-open"><i class="fa fa-bars"></i></button>
	        		<div class="nav-sections">

						<ul class="section-nav-title hidden-md hidden-lg hidden-sm">
						  <li ><a class="tablinks menutab" href="javascript:void(0)" id="defaultOpen"><?php echo esc_html('Menu','solaz');?></a></li>
						  <li ><a class="tablinks menutab" href="javascript:void(0)"><?php echo esc_html('Account','solaz');?></a></li>						  
						</ul>
						<div id="menu" class="tabcontent">
			                <?php
			                $before_items_wrap = '';
			                $after_item_wrap = '';
			                if (has_nav_menu('primary')) {
			                    wp_nav_menu(array(
			                        'theme_location' => 'primary',
			                        'menu_class' => 'mega-menu',
			                        'items_wrap' => $before_items_wrap . '<ul id="%1$s" class="%2$s">%3$s</ul>' . $after_item_wrap,
			                        'walker' => new Solaz_Primary_Walker_Nav_Menu()
			                            )
			                    );
			                }
			                ?> 
			            </div>
			            <div id="account" class="tabcontent hidden-md hidden-sm hidden-lg">
			            <?php 
							if ( class_exists( 'WooCommerce' )) {
								$myaccount_page_id = get_option('woocommerce_myaccount_page_id');
							}else{
								$myaccount_page_id = wp_login_url();
							}
							$logout_url = wp_logout_url(get_permalink($myaccount_page_id));
							if (get_option('woocommerce_force_ssl_checkout') == 'yes') {
								$logout_url = str_replace('http:', 'https:', $logout_url);
							}
			            ?>
							<ul class="mega-menu">
								<?php if (!is_user_logged_in()): ?>
									<li class="dib customlinks"><a href="<?php echo esc_url(get_permalink($myaccount_page_id)); ?>"><?php echo esc_html__('Member Login', 'solaz') ?></a></li>
								<?php else: ?>
									<li class="dib customlinks"><a href="<?php echo esc_url($logout_url) ?>"><?php echo esc_html__('Logout', 'solaz') ?></a></li>
									<li><a href="<?php echo esc_url(get_permalink($myaccount_page_id)); ?>"><?php echo esc_html__('My Account', 'solaz') ?></a></li>											

								<?php endif; ?>									
								
							</ul>
			            </div>
	                </div>
  
		            
	        </nav>  
	        	
        </div>  
        <div class="header-right">
	        	<?php if(isset($solaz_settings['header_phone']) && $solaz_settings['header_phone'] !=''):?>
	        		<div class="link-contact display-inline-b">
	        			<a href="callto:<?php echo preg_replace('/[^A-Za-z0-9]/', '', $solaz_settings['header_phone']); ?>">
	        			<i class="pe-7s-call"></i>
	        			<?php if(isset($solaz_settings['header_phone_text']) && $solaz_settings['header_phone_text'] != ''){
							echo esc_html($solaz_settings['header_phone_text']);
	        			}?>
	        			<?php echo esc_html($solaz_settings['header_phone']);?></a>
	        		</div>
	        	<?php endif;?>
	        	<div class="header_icon display-inline-b">
		        	<?php 
			        if (isset($solaz_settings['header-minicart']) && $solaz_settings['header-minicart']) :
		            	?>
		            	<?php if(class_exists('TP_Hotel_Booking') && !is_woocommerce()) :
		            	$solaz_minicart_template = solaz_room_minicart_template();
		            	?>
		                	<div id="mini-scart" class="mini-cart"> <?php echo wp_kses($solaz_minicart_template, solaz_allow_html()); ?> </div>
		            	<?php else :?>
		            		<?php if ( class_exists( 'WooCommerce' ) ) :
			            		$solaz_minicart_template_shop = solaz_get_minicart_template();
			            		?>
			            		<div id="mini-scart" class="mini-cart"> <?php echo wp_kses($solaz_minicart_template_shop, solaz_allow_html()); ?> </div>
		            		<?php endif;?>
		            	<?php endif; ?>
		            <?php endif; ?>  	                 
		            <?php 	                
		            if ($solaz_settings['header-search']) {
		                    $solaz_search_template = solaz_get_search_form();
		                    echo '<div class="search-block-top">' .wp_kses($solaz_search_template, solaz_allow_html()) . '</div>';
		                }  
		            solaz_show_language_dropdown(); 
			        ?>  
		        </div>		        		        	    	        		        	
	        </div>      
</div>
<!-- Menu -->
