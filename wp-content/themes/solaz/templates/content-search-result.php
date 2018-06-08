<?php 
    $solaz_settings = solaz_check_theme_options();
    $post_layout = isset($solaz_settings['post-layout-version']) ? $solaz_settings['post-layout-version'] :'';
    $post_columns = isset($solaz_settings['post-layout-columns']) ? $solaz_settings['post-layout-columns'] :'';
    if (is_category()){
        $category = get_category( get_query_var( 'cat' ) );
        $cat_id = $category->cat_ID;
        if(get_metadata('category', $cat_id, 'blog_layout', true) != 'default'){
            $post_layout = get_metadata('category', $cat_id, 'blog_layout', true);
            $post_columns = get_metadata('category', $cat_id, 'blog_columns', true);
        }
    }
    $solaz_skin = get_post_meta(get_the_ID(),'skin',true);
	$solaz_class = '';
	$solaz_class_columns = '';
	if($post_layout == 'masonry'){
		$solaz_class = ' blog-masonry isotope';
	}
	else if($post_layout == 'list'){
		$solaz_class = ' blog-list';
	}else{
		$solaz_class = ' blog-grid';
	}
	
	if($post_columns == '1'){
		$solaz_class_columns = 'col-md-12 col-sm-12 col-xs-12';
	}else if($post_columns == '2'){
		$solaz_class_columns = 'col-md-6 col-sm-6 col-xs-12';
	}
	else if($post_columns == '3'){
		$solaz_class_columns = 'col-md-4 col-sm-4 col-xs-12';
	}else{
		$solaz_class_columns = 'col-md-3 col-sm-6 col-xs-12';
	}
    $current_page = get_query_var('paged') ? intval(get_query_var('paged')) : 1;
?>
<div class="row blog-entries-wrap grid-isotope <?php echo esc_attr($solaz_class); ?>">
	<?php while (have_posts()) : the_post(); ?>
		<div class="grid-item <?php echo esc_attr($solaz_class_columns); ?>">
			<div class="blog-content">
				<div class="blog-item">
					<?php if (has_post_thumbnail()): ?>
						<div class="blog-img">
							<?php 
								$attachment_id = get_post_thumbnail_id();
								$attachment_grid = solaz_get_attachment($attachment_id, 'solaz-blog-grid'); 
								$attachment_img_list = solaz_get_attachment($attachment_id, 'solaz-blog-list'); 
								$attachment_img_full = solaz_get_attachment($attachment_id, 'full'); 
								$attachment_grid_2 = solaz_get_attachment($attachment_id, 'solaz-blog-detail'); 
							?>
							<?php if ($post_layout == "grid"): ?>
								<a class="fancybox" data-fancybox-group="gallery" href="<?php echo esc_url($attachment_grid_2['src']) ?>" alt="<?php echo esc_attr($attachment_grid_2['alt']) ?>"><img width="<?php echo esc_attr($attachment_grid['width']) ?>" height="<?php echo esc_attr($attachment_grid['height']) ?>" src="<?php echo esc_url($attachment_grid['src']) ?>" alt="<?php echo esc_attr($attachment_grid['alt']) ?>" /></a>	
							<?php elseif ($post_layout == "list"):?>
								<a class="fancybox" data-fancybox-group="gallery" href="<?php echo esc_url($attachment_grid_2['src']) ?>" alt="<?php echo esc_attr($attachment_grid_2['alt']) ?>"><img width="<?php echo esc_attr($attachment_img_list['width']) ?>" height="<?php echo esc_attr($attachment_img_list['height']) ?>" src="<?php echo esc_url($attachment_img_list['src']) ?>" alt="<?php echo esc_attr($attachment_img_list['alt']) ?>" /></a>	
							<?php else :?>
								<a class="fancybox" data-fancybox-group="gallery" href="<?php echo esc_url($attachment_grid_2['src']) ?>" alt="<?php echo esc_attr($attachment_grid_2['alt']) ?>"><img width="<?php echo esc_attr($attachment_img_full['width']) ?>" height="<?php echo esc_attr($attachment_img_full['height']) ?>" src="<?php echo esc_url($attachment_img_full['src']) ?>" alt="<?php echo esc_attr($attachment_img_full['alt']) ?>" /></a>	
							<?php endif;?>
						</div>
					<?php endif;?>
					<div class="blog-post-info">
						<div class="blog-post-title">
							<div class="post-name">
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>	                            								
							</div>						
						</div>
						<div class="blog-date">
							<p class="date"><?php echo get_the_date(); ?></p>
						</div>
						<?php if ($post_layout == "list"): ?>
							<div class="blog_post_desc">
								<?php 
								$solaz_settings = solaz_check_theme_options();
								if (get_post_meta(get_the_ID(),'highlight',true) != "") : ?>                            
									<p><?php echo get_post_meta(get_the_ID(),'highlight',true);?></p>
								<?php else:?>
									<?php
									echo '<div class="entry-content">';
									the_content();
									wp_link_pages( array(
										'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'solaz' ) . '</span>',
										'after'       => '</div>',
										'link_before' => '<span>',
										'link_after'  => '</span>',
										'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'solaz' ) . ' </span>%',
										'separator'   => '<span class="screen-reader-text">, </span>',
									) );
									echo '</div>';
									?>
								<?php endif; ?>
								<div class="read-more">
									<a href="<?php the_permalink(); ?>"> <?php echo esc_html('Read more', 'solaz'); ?> <i class="fa fa-angle-double-right"></i></a>
								</div>
							</div>
						<?php endif; ?>
					</div>	
				</div>
			</div>
		</div>
	<?php endwhile; ?>
</div>
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<?php if ($wp_query->max_num_pages > 1) : ?>
			<div class="load-more text-center">
				<a data-paged="<?php echo esc_attr($current_page) ?>" data-totalpage="<?php echo esc_attr($wp_query->max_num_pages) ?>" id="blog-loadmore" class="btn btn-primary"><?php echo esc_html__('View More', 'solaz') ?> </a>
			</div>
		<?php endif; ?>
	</div>
</div>
