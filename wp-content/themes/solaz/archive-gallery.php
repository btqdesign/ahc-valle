<?php get_header(); 
	$current_page = get_query_var('paged') ? intval(get_query_var('paged')) : 1;
	$taxonomy_names = get_object_taxonomies( 'gallery' );
	if ( is_array( $taxonomy_names ) && count( $taxonomy_names ) > 0  && in_array( 'gallery_cat', $taxonomy_names ) ) {
	    $terms = get_terms( 'gallery_cat', array(
	        'hide_empty'        => false,
	        'parent'		=> 0,
	        ) );
	}
?>
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
<?php
$solaz_gallery_layout = isset($solaz_settings['gallery-style-version']) ? $solaz_settings['gallery-style-version'] :'';
$solaz_style_class="";
if($solaz_gallery_layout == '2'){
	$solaz_style_class = ' gallery-masonry';
}else{
	$solaz_style_class = ' gallery-grid';
}
$solaz_col_class=" col-3";

if(isset($solaz_settings['gallery-cols'])){
   $solaz_col_class=" col-".$solaz_settings['gallery-cols'];
}
$btn = "";
if(isset($solaz_settings['gallery-loadmore-style']) && $solaz_settings['gallery-loadmore-style'] =='2'){
	$btn = ' btn-default';
}
?>		
<?php get_sidebar('left'); ?> 	
		<div class="<?php echo esc_attr($solaz_class);?>">
			<div id="primary" class="content-area">
	            <?php if (have_posts()): ?>   
					<div class="gallery-container">
						<?php $page_title = solaz_get_meta_value('page_title', true); ?>
						<?php if($page_title) :?>
							<div class="page-title text-center"><h3><?php solaz_page_title(); ?></h3></div>
						<?php endif;?>
						<?php if (is_array( $terms ) && count( $terms ) > 0 ) : ?>
							<div id="options">
								<div id="filters" class="button-group js-radio-button-group text-center">
									<button class="is-checked" data-filter="*"><?php echo esc_html__('All','solaz'); ?></button> 
								  
									<?php foreach ( $terms as $key => $term ) : ?> 
										
										<button data-filter=".<?php echo esc_attr($term->slug); ?>"><?php echo esc_html($term->name); ?></button>
									   
									<?php endforeach;?>  
								</div>
							</div> 
						<?php endif;?> 
						<div class="tabs_sort">
							<div class="gallery-entries-wrap isotope clearfix <?php echo esc_attr($solaz_col_class).esc_attr($solaz_style_class);?>">   
								<?php while (have_posts()) : the_post(); ?>
									<?php if($solaz_gallery_layout == '2'):?>
										<?php get_template_part('templates/content', 'gallery-masonry'); ?>				             			
									<?php else:?>
										<?php get_template_part('templates/content', 'gallery-grid'); ?><?php endif;?>
								<?php endwhile; ?>
							</div>  
						</div> 
						<?php if ($wp_query->max_num_pages > 1) : ?>
							<div class="load-more text-center">
								<a data-paged="<?php echo esc_attr($current_page) ?>" data-totalpage="<?php echo esc_attr($wp_query->max_num_pages) ?>" id="gallery-loadmore" class="btn <?php echo esc_attr($btn);?>"><?php echo esc_html__('Load More', 'solaz') ?> </a>
							</div>
						<?php endif; ?>
					</div>
	            <?php else: ?> 
	                 <?php get_template_part('content', 'none'); ?>
	            <?php endif; ?>
			</div><!-- #primary -->
		</div>
<?php get_sidebar('right'); ?> 
<?php get_footer(); ?>