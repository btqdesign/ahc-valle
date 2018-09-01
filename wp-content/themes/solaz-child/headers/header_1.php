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
                    if ($solaz_settings['logo'] && $solaz_settings['logo']['url']):
                        echo '<img class="" src="' . esc_url(str_replace(array('http:', 'https:'), '', $solaz_settings['logo']['url'])) . '" alt="' . esc_attr(get_bloginfo('name', 'display')) . '" />';
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
        <div class="header-right">
	        <nav id="site-navigation" class="main-navigation">
	        	<button onclick="openNav()" class="btn-open"><i class="fa fa-bars"></i></button>
	        		<div class="nav-sections">

						<ul class="section-nav-title hidden-md hidden-lg hidden-sm">
						  <li ><a class="tablinks" href="javascript:void(0)" onclick="menu_tab(event, 'menu')" id="defaultOpen"><?php echo esc_html('Menu','solaz');?></a></li>
						  <li ><a class="tablinks" href="javascript:void(0)" onclick="menu_tab(event, 'account')" ><?php echo esc_html('Account','solaz');?></a></li>						  
						</ul>
						<div id="menu" class="tabcontent">
			                <?php
			                $before_items_wrap = '';
			                $after_item_wrap = '';
							if( function_exists( 'ubermenu' ) ){
							  ubermenu( 'main' , array( 'theme_location' => 'primary' ) ); 
							}else{
				                if (has_nav_menu('primary')) {
				                    wp_nav_menu(array(
				                        'theme_location' => 'primary',
				                        'menu_class' => 'mega-menu',
				                        'items_wrap' => $before_items_wrap . '<ul id="%1$s" class="%2$s">%3$s</ul>' . $after_item_wrap,
				                        'walker' => new Solaz_Primary_Walker_Nav_Menu()
				                            )
				                    );
				                }
				            }
			                ?>
			                <div class="menu-main_menu-container btq-book-now">
				                <ul id="menu-main_menu" class="mega-menu">
					                <li id="menu-item-6362" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home menu-item-6362"><a href="https://secure.internetpower.com.mx/portals/ValleDeMexico/Hotel/HotelDescription.aspx?CheckIn=20180902&CheckOut=20180903&PropertyNumber=6422&Provider=0&Rooms=1&AccessCode=WEBPAGE&Currency=MXN">Book Now</a></li>
								</ul>
							</div>
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
	            <?php
	            solaz_show_language_dropdown();  
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

		        ?>    
		            
	        </nav>  
	        <div class="header-bottom">
				<?php /*
	        	<?php if(isset($solaz_settings['header_email']) && $solaz_settings['header_email'] !=''):?>
	        		<div class="link-contact display-inline-b">
	        			<a href="mailto:<?php echo $solaz_settings['header_email'];?>"><?php echo esc_html($solaz_settings['header_email']);?></a>
	        		</div>
	        	<?php endif;?>
	        	<?php if(isset($solaz_settings['header_location']) && $solaz_settings['header_location'] !=''):?>
	        		<div class="link-contact display-inline-b">
	        			<?php if(isset($solaz_settings['header_location_url']) && $solaz_settings['header_location_url'] !=''):?>
	        				<a href="<?php echo esc_url($solaz_settings['header_location_url']);?>">
	        			<?php endif;?>
	        			<?php echo esc_html($solaz_settings['header_location']);?>
	        			<?php if(isset($solaz_settings['header_location_url']) && $solaz_settings['header_location_url'] !=''):?>
	        				</a>
	        			<?php endif;?>	        			
	        		</div>
	        	<?php endif;?>
	        	<?php if(isset($solaz_settings['header_phone']) && $solaz_settings['header_phone'] !=''):?>
	        		<div class="link-contact display-inline-b">
	        			<a href="callto:<?php echo preg_replace('/[^A-Za-z0-9]/', '', $solaz_settings['header_phone']); ?>"></a>
	        			<?php if(isset($solaz_settings['header_phone_text']) && $solaz_settings['header_phone_text'] != ''){
							echo esc_html($solaz_settings['header_phone_text']);
	        			}?>
	        			<?php ?>
	        			<a href="callto:<?php echo preg_replace('/[^A-Za-z0-9]/', '', $solaz_settings['header_phone']); ?>"><?php echo esc_attr($solaz_settings['header_phone']);?></a>
	        		</div>
	        	<?php endif;?>	
	        	<?php if(isset($solaz_settings['header_gallery']) && $solaz_settings['header_gallery'] !=''):?>
	        		<div class="link-contact display-inline-b">
	        			<?php if(isset($solaz_settings['header_gallery_url']) && $solaz_settings['header_gallery_url'] !=''):?>
	        				<a href="<?php echo esc_url($solaz_settings['header_gallery_url']);?>">
	        			<?php endif;?>
	        			<?php echo esc_html($solaz_settings['header_gallery']);?>
	        			<?php if(isset($solaz_settings['header_gallery_url']) && $solaz_settings['header_gallery_url'] !=''):?>
	        				</a>
	        			<?php endif;?>	        			
	        		</div>
	        	<?php endif;?>
		        	<?php if (class_exists('WP_Hotel_Booking')):?>	    
			        	<?php if(isset($solaz_settings['header_book_text']) && $solaz_settings['header_book_text'] !=''):?>
			        		<?php $solaz_settings['header_book_link'] = (isset($solaz_settings['header_book_link']) && $solaz_settings['header_book_link']!='')? $solaz_settings['header_book_link']:'reservation-form';?>
			        		<div class="link-contact f_right main-bg display-inline-b">
			        			<?php if ( function_exists('icl_object_id') ) :?>	
								<a class="" target="_blank" href="<?php echo $solaz_settings['header_book_link'];?>">
									<?php echo esc_html($solaz_settings['header_book_text']);?>
								</a>
								<?php else:?>
								<a class="" target="_blank" href="<?php echo $solaz_settings['header_book_link'];?>">
									<?php echo esc_html($solaz_settings['header_book_text']);?>
								</a>								
								<?php endif;?>
			        		</div>
			        	<?php endif;?>	
					<?php endif;?>
				*/ ?>
				<?php

					$wpml_current_language = apply_filters( 'wpml_current_language', NULL );
					if (!empty($wpml_current_language)){
						$language = $wpml_current_language;
					}
					elseif ( defined( 'ICL_LANGUAGE_CODE' ) ) {
						$language = ICL_LANGUAGE_CODE;
					}
					else {
						$language = 'es';
					}

					$post_slug = get_post_field('post_name', get_post());
					if ($post_slug == 'la-terraza'){
						if (has_nav_menu('btq-menu-terraza')) {
							wp_nav_menu(array(
								'theme_location' => 'btq-menu-terraza',
								'menu_class' => 'btq-menu',
								'items_wrap' => $before_items_wrap . '<ul id="%1$s" class="%2$s">%3$s</ul>' . $after_item_wrap,
								'walker' => new Solaz_Primary_Walker_Nav_Menu()
							));
						}
					}
					elseif($post_slug == 'banquetes'){
						if (has_nav_menu('btq-menu-banquete')) {
							wp_nav_menu(array(
								'theme_location' => 'btq-menu-banquete',
								'menu_class' => 'btq-menu',
								'items_wrap' => $before_items_wrap . '<ul id="%1$s" class="%2$s">%3$s</ul>' . $after_item_wrap,
								'walker' => new Solaz_Primary_Walker_Nav_Menu()
							));
						}
					}
					elseif($language == 'en'){
						if (has_nav_menu('btq-menu-en')) {
							wp_nav_menu(array(
								'theme_location' => 'btq-menu-en',
								'menu_class' => 'btq-menu',
								'items_wrap' => $before_items_wrap . '<ul id="%1$s" class="%2$s">%3$s</ul>' . $after_item_wrap,
								'walker' => new Solaz_Primary_Walker_Nav_Menu()
							));
						}
					}
					else{
						if (has_nav_menu('btq-menu')) {
							wp_nav_menu(array(
								'theme_location' => 'btq-menu',
								'menu_class' => 'btq-menu',
								'items_wrap' => $before_items_wrap . '<ul id="%1$s" class="%2$s">%3$s</ul>' . $after_item_wrap,
								'walker' => new Solaz_Primary_Walker_Nav_Menu()
							));
						}
					}

				
				?>	
				    <?php if (class_exists('WP_Hotel_Booking')):?>	    
			        	<?php if(isset($solaz_settings['header_book_text']) && $solaz_settings['header_book_text'] !=''):?>
			        		<?php $solaz_settings['header_book_link'] = (isset($solaz_settings['header_book_link']) && $solaz_settings['header_book_link']!='')? $solaz_settings['header_book_link']:'hola';?>
			        		<div class="link-contact f_right main-bg display-inline-b">
			        			<?php if ($language == 'es'):?>	
								<a class="" target="_blank" href="https://secure.internetpower.com.mx/portals/ValleDeMexico/Hotel/HotelDescription.aspx?CheckIn=20180902&CheckOut=20180903&PropertyNumber=6422&Provider=0&Rooms=1&AccessCode=WEBPAGE&Currency=MXN">Reservar Ahora</a>
								<?php else:?>
								<a class="" target="_blank" href="https://secure.internetpower.com.mx/portals/ValleDeMexico/Hotel/HotelDescription.aspx?PropertyNumber=6422&Provider=0">Book Now</a>
								</a>	
															
								<?php endif;?>
			        		</div>
			        	<?php endif;?>	
					<?php endif;?>	        		        	
	        </div>      	
        </div>  
</div>
<!-- Menu -->
