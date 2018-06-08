<?php
$solaz_settings = solaz_check_theme_options();
$solaz_header_class = '';
if ( !$solaz_settings['wpml-switcher']|| !$solaz_settings['header-minicart'] || !$solaz_settings['header-search']) {
	$solaz_header_class .= ' xs-4-col';
}
?>

<div class="header-wrapper <?php echo esc_attr($solaz_header_class);?>">
	<div class="container">
	    <div class="header-top">
	    	<?php if(isset($solaz_settings['header_email']) && $solaz_settings['header_email'] !=''):?>
	    		<div class="link-contact display-inline-b">
	    			<a href="mailto:<?php echo $solaz_settings['header_email'];?>"><i class="pe-7s-mail"></i><?php echo esc_html($solaz_settings['header_email']);?></a>
	    		</div>
	    	<?php endif;?>
	    	<?php if(isset($solaz_settings['header_location']) && $solaz_settings['header_location'] !=''):?>
	    		<div class="link-contact display-inline-b">
	    			<?php if(isset($solaz_settings['header_location_url']) && $solaz_settings['header_location_url'] !=''):?>
	    				<a href="<?php echo esc_url($solaz_settings['header_location_url']);?>"><i class="pe-7s-map-marker"></i>
	    			<?php endif;?>
	    			<?php echo esc_html($solaz_settings['header_location']);?>
	    			<?php if(isset($solaz_settings['header_location_url']) && $solaz_settings['header_location_url'] !=''):?>
	    				</a>
	    			<?php endif;?>	        			
	    		</div>
	    	<?php endif;?>
	    	<div class="display-inline-b">
	        <?php if (is_front_page()) : ?>
	            <h1 class="header-logo">
	            <?php else : ?>
	                <h2 class="header-logo">
	                <?php endif; ?>
	                <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
	                    <?php
	                    if ($solaz_settings['logo3'] && $solaz_settings['logo3']['url']):
	                        echo '<img class="" src="' . esc_url(str_replace(array('http:', 'https:'), '', $solaz_settings['logo3']['url'])) . '" alt="' . esc_attr(get_bloginfo('name', 'display')) . '" />';
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
	        </div>   	
	    	<?php if(isset($solaz_settings['header_phone']) && $solaz_settings['header_phone'] !=''):?>
	        		<div class="link-contact display-inline-b f-right">
	        			<a href="callto:<?php echo preg_replace('/[^A-Za-z0-9]/', '', $solaz_settings['header_phone']); ?>"><i class="pe-7s-call"></i></a>
	        			<?php if(isset($solaz_settings['header_phone_text']) && $solaz_settings['header_phone_text'] != ''){
							echo esc_html($solaz_settings['header_phone_text']);
	        			}?>
	        			<a href="callto:<?php echo preg_replace('/[^A-Za-z0-9]/', '', $solaz_settings['header_phone']); ?>"><?php echo esc_attr($solaz_settings['header_phone']);?></a>
	        		</div>
	    	<?php endif;?>	
	    	<?php if(isset($solaz_settings['header_gallery']) && $solaz_settings['header_gallery'] !=''):?>
	    		<div class="link-contact display-inline-b f-right">
	    			<?php if(isset($solaz_settings['header_gallery_url']) && $solaz_settings['header_gallery_url'] !=''):?>
	    				<a href="<?php echo esc_url($solaz_settings['header_gallery_url']);?>"><i class="pe-7s-photo"></i>
	    			<?php endif;?>
	    			<?php echo esc_html($solaz_settings['header_gallery']);?>
	    			<?php if(isset($solaz_settings['header_gallery_url']) && $solaz_settings['header_gallery_url'] !=''):?>
	    				</a>
	    			<?php endif;?>	        			
	    		</div>
	    	<?php endif;?>	    
	        	    	        		        	
	    </div>
	</div> 
        <nav id="site-navigation" class="main-navigation">
	        <div class="container">
	        		<div class="nav-sections-2">
			        	<button class="btn-open open-menu hs2-border-tab"><i class="fa fa-bars"></i></button> 
			        	<?php if (is_front_page()) : ?>
							<h1 class="header-logo hidden-xs hidden-sm hidden-md">
							<?php else : ?>
								<h2 class="header-logo">
								<?php endif; ?>
								<a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
									<?php
									if ($solaz_settings['logo3'] && $solaz_settings['logo3']['url']):
										echo '<img class="" src="' . esc_url(str_replace(array('http:', 'https:'), '', $solaz_settings['logo3']['url'])) . '" alt="' . esc_attr(get_bloginfo('name', 'display')) . '" />';
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
						<div class="header_center_menu content-filter">
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
			        				<button class="btn-open open-account hs2-border-tab"><i class="fa fa-user" aria-hidden="true" ></i></button>														            	
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
										<ul class="mega-menu header-account  content-filter">
											<?php if (!is_user_logged_in()): ?>
												<li class="dib customlinks"><a href="<?php echo esc_url(get_permalink($myaccount_page_id)); ?>"><?php echo esc_html__('Member Login', 'solaz') ?></a></li>
											<?php else: ?>
												<li class="dib customlinks"><a href="<?php echo esc_url($logout_url) ?>"><?php echo esc_html__('Logout', 'solaz') ?></a></li>
												<li><a href="<?php echo esc_url(get_permalink($myaccount_page_id)); ?>"><?php echo esc_html__('My Account', 'solaz') ?></a></li>											

											<?php endif; ?>									
											
										</ul>
						    </div>				                
			                <div class="header_right_link">	
	        				  			                
					            <?php 
						        if (isset($solaz_settings['header-minicart']) && $solaz_settings['header-minicart']) :
					            	?>
					            	<?php if(class_exists('TP_Hotel_Booking') && !is_woocommerce()) :
					            	$solaz_minicart_template = solaz_room_minicart_template();
					            	?>
					                	<div id="mini-scart" class="mini-cart hs2-border-tab"> <?php echo wp_kses($solaz_minicart_template, solaz_allow_html()); ?> </div>
					            	<?php else :?>
					            		<?php if ( class_exists( 'WooCommerce' ) ) :
						            		$solaz_minicart_template_shop = solaz_get_minicart_template();
						            		?>
						            		<div id="mini-scart" class="mini-cart hs2-border-tab"> <?php echo wp_kses($solaz_minicart_template_shop, solaz_allow_html()); ?> </div>
					            		<?php endif;?>
					            	<?php endif; ?>
					            <?php endif; ?>      	                 
					            <?php 	                
					            if ($solaz_settings['header-search']) {
					                    $solaz_search_template = solaz_get_search_form();
					                    echo '<div class="search-block-top hs2-border-tab">' .wp_kses($solaz_search_template, solaz_allow_html()) . '</div>';
					                }  
								solaz_show_language_dropdown();  
						        ?> 
			                </div>		                
			            <!-- </div> -->

	                </div>
	   		</div>
		            
        </nav>      
</div>
<!-- Menu -->
