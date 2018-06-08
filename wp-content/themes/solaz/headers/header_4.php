<?php
$solaz_settings = solaz_check_theme_options();
?>		
		<div class="container-fluid ">
			<div class="row">
				<div class="element-header">
					<div class="col-md-6 col-sm-6 col-xs-6 text-left">
						<?php 
							$solaz_logo_header = (solaz_get_meta_value('logo_header_page') != '') ? solaz_get_meta_value('logo_header_page') : $solaz_settings['logo4']['url'];
						?>
						<?php if (is_front_page()) : ?>
							<h1 class="header-logo">
							<?php else : ?>
								<h2 class="header-logo">
								<?php endif; ?>
								<a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
									<?php
									if ($solaz_logo_header && $solaz_logo_header):
										echo '<img class="" src="' . esc_url(str_replace(array('http:', 'https:'), '', $solaz_logo_header)) . '" alt="' . esc_attr(get_bloginfo('name', 'display')) . '" />';
									else:
										echo bloginfo('name');
									endif;
									?>
								</a>
								<?php if (is_front_page()) : ?>
							</h1>
						<?php else : ?>
							</h2>
						<?php endif; ?>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-6">
						<div class="right-header">
							<?php  if (isset($solaz_settings['header4-search']) && $solaz_settings['header4-search']) {
										$solaz_search_template = solaz_get_search_form();
										echo '<div class="search-block-top">' . $solaz_search_template . '</div>';
									}
							?>						
							<div class="nav-menu">
								<button class="btn-open-menu menu-toggle"><i class="fa fa-bars"></i></button>
								<nav id="site-navigation" class="main-navigation">
									<button class="btn-close-menu"> <i class="pe-7s-close" aria-hidden="true"></i></button>
									<?php
									$solaz_before_items_wrap = '';
									$solaz_after_item_wrap = '';									
									if(has_nav_menu('primary')){                   
										wp_nav_menu(array(
											'theme_location' => 'primary',
											'menu_class' => 'mega-menu',
											'container_class' => 'h_vertical_menu',
											'items_wrap' => $solaz_before_items_wrap . '<ul id="%1$s" class="%2$s">%3$s</ul>' . $solaz_after_item_wrap,
											'walker' => new Solaz_Primary_Walker_Nav_Menu()
												)
										);
									}
									?>               
								</nav>
							</div> 
						</div>
					</div>
				</div>
			</div>
		</div>