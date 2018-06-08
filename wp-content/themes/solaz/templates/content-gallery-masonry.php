<?php 
    $solaz_settings = solaz_check_theme_options();
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
    $author = get_the_author();
?>
  <div class="item <?php echo esc_attr($post_term_filters);?>  ">
    <figure class="gallery-image">
        <?php 
            if ( has_post_thumbnail() ) : ?>
                <div class="gallery-img">
					<?php $attachment_img = solaz_get_attachment(get_post_thumbnail_id(), 'full'); ;?>
					<a class="fancybox-thumb" data-fancybox-group="fancybox-thumb" href="<?php echo esc_url($attachment_img['src']) ?>" >
						<img width="<?php echo esc_attr($attachment_img['width']) ?>" height="<?php echo esc_attr($attachment_img['height']) ?>" src="<?php echo esc_url($attachment_img['src']) ?>" alt="<?php echo esc_html__('gallery','solaz') ?>" />
					</a>	
				</div>
            <?php endif;
        ?>
    </figure>
  </div>