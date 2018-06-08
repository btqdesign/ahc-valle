<?php get_header(); ?>

<?php 
	$solaz_class = '';
	if ($solaz_sidebar_left && $solaz_sidebar_right && is_active_sidebar($solaz_sidebar_left) && is_active_sidebar($solaz_sidebar_right)){
	 	$solaz_class .= 'col-md-6 col-sm-12 col-xs-12 main-sidebar'; 
	}elseif($solaz_sidebar_left && (!$solaz_sidebar_right|| $solaz_sidebar_right=="none") && is_active_sidebar($solaz_sidebar_left)){
		$solaz_class .= 'f-right col-lg-9 col-md-9 col-sm-12 col-xs-12 main-sidebar'; 
	}elseif((!$solaz_sidebar_left || $solaz_sidebar_left=="none") && $solaz_sidebar_right && is_active_sidebar($solaz_sidebar_right)){
		$solaz_class .= 'col-lg-9 col-md-9 col-sm-12 col-xs-12 main-sidebar'; 
	}else {
		$solaz_class .= 'content-primary'; 
		if($solaz_layout == 'fullwidth'){
			$solaz_class .= ' col-md-12';
		}
	}
?>
<?php get_sidebar('left'); ?> 
	<div class="<?php echo esc_attr($solaz_class);?>">			
		<div id="primary" class="content-area <?php if ( is_page( 'Hotel Booking Search' )){echo 'search_hotel_template';} ?>">
            <?php while ( have_posts() ) : the_post(); ?>
                    <?php get_template_part( 'templates/content', 'page' ); 
                    
                    ?>

                    <?php	if ( comments_open() || get_comments_number() ) {
							comments_template();
							}
					?>
            <?php endwhile; // End of the loop. ?>
		</div><!-- End primary -->
	</div>
<?php get_sidebar('right'); ?> 
<?php get_footer(); ?>