<?php 
    $solaz_settings = solaz_check_theme_options();
    $solaz_post_layout = isset($solaz_settings['post-layout-version']) ? $solaz_settings['post-layout-version'] :'';
    $solaz_post_columns = isset($solaz_settings['post-layout-columns']) ? $solaz_settings['post-layout-columns'] :'';
    if (is_category()){
        $category = get_category( get_query_var( 'cat' ) );
        $cat_id = $category->cat_ID;
        if(get_metadata('category', $cat_id, 'blog_layout', true) != 'default'){
            $solaz_post_layout = get_metadata('category', $cat_id, 'blog_layout', true);
            $solaz_post_columns = get_metadata('category', $cat_id, 'blog_columns', true);
        }
    }
    $solaz_skin = get_post_meta(get_the_ID(),'skin',true);
	$solaz_class = '';
	$solaz_class_columns = '';
	if($solaz_post_layout == 'masonry'){
		$solaz_class = ' blog-masonry';
	}
	else if($solaz_post_layout == 'list'){
		$solaz_class = ' blog-list';
	}else{
		$solaz_class = ' blog-grid';
	}
	
	if($solaz_post_columns == '1'){
		$solaz_class_columns = 'col-md-12 col-sm-12 col-xs-12';
	}else if($solaz_post_columns == '2'){
		$solaz_class_columns = 'col-md-6 col-sm-6 col-xs-12';
	}else if($solaz_post_columns == '4'){
		$solaz_class_columns = 'col-md-3 col-sm-6 col-xs-12';
	}else{
		$solaz_class_columns = 'col-md-4 col-sm-6 col-xs-12';
	}
    $solaz_current_page = get_query_var('paged') ? intval(get_query_var('paged')) : 1;
?>
<div class="row blog-entries-wrap grid-isotope <?php echo esc_attr($solaz_class); ?>">
	<?php while (have_posts()) : the_post(); ?>
		<div class="grid-item <?php echo esc_attr($solaz_class_columns); ?>">
			<div class="blog-content">
				<div class="blog-item animate-top">
					<?php solaz_get_post_media(); ?>
					<div class="blog-post-info">
						<?php if(get_the_title() != ''):?>
						<div class="blog-post-title">
							<div class="post-name">
							    <a href="<?php the_permalink(); ?>"><?php the_title(); ?>
									<?php  if ( is_sticky() && is_home() && ! is_paged() ):?>
									 <span class="sticky_post"><?php echo esc_html__('Featured', 'solaz')?></span>
									<?php endif;?>          
								</a>                                     
							</div>					
						</div>
						<?php endif;?>
						<?php if ($solaz_post_layout == "list"): ?>
						<div class="blog-info">
							<div class="info blog-date">
								<i class="fa fa-calendar-o" aria-hidden="true"></i><a href="<?php the_permalink(); ?>"><?php echo get_the_date(); ?></a>
							</div>							
							<?php $author_id= $post->post_author;?>
							<div class="info info-cat">
								<?php echo get_the_term_list($post->ID,'category', '<i class="fa fa-folder-o"></i> ', ',  ' ); ?>
							</div>
							<div class="info info-tag">
								<?php echo get_the_tag_list('<i class="fa fa-tag"></i> ',', ',''); ?>
							</div>
						</div>	
						<?php else: ?>					
						<div class="blog-date">
							<p class="date"><a href="<?php the_permalink(); ?>"><?php echo get_the_date(); ?></a></p>
						</div>
						<?php endif; ?>
						<?php if ($solaz_post_layout == "list"): ?>
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
	<div class="col-md-12 col-sm-12 col-xs-12 animate-top">
		<?php if ($wp_query->max_num_pages > 1) : ?>
			<div class="load-more text-center">
				<a data-paged="<?php echo esc_attr($solaz_current_page) ?>" data-totalpage="<?php echo esc_attr($wp_query->max_num_pages) ?>" id="blog-loadmore" class="btn btn-primary"><?php echo esc_html__('View More', 'solaz') ?> </a>
			</div>
		<?php endif; ?>
	</div>
</div>
