
<?php 
    $post_term_arr = get_the_terms( get_the_ID(), 'gallery_cat' );
    $post_term_filters = '';
    $post_term_names = '';

    if (is_array($post_term_arr) || is_object($post_term_arr)){
        foreach ( $post_term_arr as $post_term ) {

            $post_term_filters .= $post_term->slug . ' ';
            $post_term_names .= $post_term->name . ', ';
            if($post_term->parent!=0){
                $parent_term = get_term( $post_term->parent,'gallery_cat' );
                $post_term_filters .= $parent_term->slug . ' ';
                
            }
        }
    }

    $post_term_filters = trim( $post_term_filters );
    $post_term_names = substr( $post_term_names, 0, -2 );
    $author = get_the_author_link();
?>
<div class="item <?php echo esc_attr($post_term_filters);?>">
    <?php if ( has_post_thumbnail() ) : ?>
		<figure class="gallery-image">
			<div class="gallery-img">
				<?php 
					$attachment_id = get_post_thumbnail_id();
					$attachment_grid = solaz_get_attachment($attachment_id, 'solaz-gallery-grid'); 
					$attachment_grid_2 = solaz_get_attachment($attachment_id, 'solaz-blog-detail'); 
				?>
				<a class="fancybox-thumb" data-fancybox-group="fancybox-thumb" href="<?php echo esc_url($attachment_grid_2['src']) ?>" ><img width="<?php echo esc_attr($attachment_grid['width']) ?>" height="<?php echo esc_attr($attachment_grid['height']) ?>" src="<?php echo esc_url($attachment_grid['src']) ?>" alt="<?php echo esc_html__('gallery','solaz') ?>" /></a>	
			</div>
		</figure>   
    <?php endif;?>  
</div>