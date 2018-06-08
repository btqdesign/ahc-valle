<?php
require_once(SOLAZ_FUNCTIONS . '/config_options.php');
require_once(SOLAZ_FUNCTIONS . '/vc_functions.php');
require_once(SOLAZ_FUNCTIONS . '/sidebars.php');
require_once(SOLAZ_FUNCTIONS . '/layout.php');
require_once(SOLAZ_FUNCTIONS . '/menus.php');
require_once(SOLAZ_FUNCTIONS . '/gallery_like_count.php');
if (class_exists('Woocommerce')) {
    require_once(SOLAZ_FUNCTIONS . '/woocommerce.php');
	require_once(SOLAZ_FUNCTIONS . '/widgets/solaz_override_woocommerce.php');  
}
require_once(SOLAZ_FUNCTIONS . '/wpml.php');
add_action( 'wp_ajax_solaz_ajax_load_more', 'solaz_ajax_load_more' );
add_action( 'wp_ajax_nopriv_solaz_ajax_load_more', 'solaz_ajax_load_more' );
function solaz_ajax_load_more(){
    $solaz_perpage = $_POST['solaz_perpage'];
    $solaz_currentpage = $_POST['solaz_currentpage'];
    $args = array(
        'post_type' => 'gallery' ,
        'post_status' => 'publish',
        'posts_per_page' => (int)$solaz_perpage,
        'paged' => (int)$solaz_currentpage + 1,
    );
    $rquery = new Wp_Query( $args );
    if ( $rquery->have_posts() ) :
                    while ( $rquery->have_posts() ) : $rquery->the_post();
                ?>
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
                <?php
                    endwhile;
                    wp_reset_postdata();
                endif;
}
add_action( 'template_redirect', 'solaz_redirect_gallery' );
function solaz_redirect_gallery() {
  $queried_post_type = get_query_var('post_type');
  if ( is_single() && 'gallery' ==  $queried_post_type ) {
    wp_redirect( home_url( '/' ), 301 );
    exit;
  }
}
//preloader
function solaz_pre_loader() { 
    global $solaz_settings;
    if(isset($solaz_settings['preload']) && $solaz_settings['preload'] =='enable'){
        ob_start();
?>
    <div class="preloader">
        <div class="loader">
          <span class="sq"></span>
          <span class="sq"></span>
          <span class="sq"></span>
          <span class="sq"></span>
        </div>  
    </div>
<?php
        return ob_get_clean();
    }else{ 
        ?>
        <div id="pre-loader">
        </div>
        <?php
     }
}
//search filter
if ( !is_admin() ) {
    function solaz_searchfilter($query) {
        if ($query->is_search && !is_admin() && $query->get( 'post_type' ) != 'kbe_knowledgebase' && $query->get( 'post_type' ) != 'product') {
        $query->set('post_type',array('post','recipe'));
        }
        return $query;
    }
    add_filter('pre_get_posts','solaz_searchfilter');
}
//back to top
add_action( 'wp_footer', 'solaz_back_to_top' );
function solaz_back_to_top() {
echo '<a class="scroll-to-top"><i class="fa fa-angle-up"></i></a>';
}
add_action( 'wp_footer', 'solaz_overlay' );
function solaz_overlay() {
echo '<div class="overlay"></div>';
}
function solaz_get_post_media(){ 
    global $solaz_settings;
    $gallery = get_post_meta(get_the_ID(), 'images_gallery', true);
    $post_layout = isset($solaz_settings['post-layout-version']) ? $solaz_settings['post-layout-version'] :'';
    if (is_category()){
        $category = get_category( get_query_var( 'cat' ) );
        $cat_id = $category->cat_ID;
        if(get_metadata('category', $cat_id, 'blog_layout', true) != 'default'){
            $post_layout = get_metadata('category', $cat_id, 'blog_layout', true);
        }
    }
    ?> 
    <?php if ( get_post_format() == 'video' ||  get_post_format() == 'audio') : ?>
        <?php $video = get_post_meta(get_the_ID(), 'video_code', true); ?>
            <?php if ($video && $video != ''): ?>
                <div class="align_left">
                    <div class="blog-video">

                            <?php if(get_post_format() == 'video'){
                                echo '<div class="iframe_video_container">';
                            }
                            ?>                    
                                <?php if (strpos($video,'iframe') !== false):?>
                                    <?php echo wp_kses($video,array(
                                      'iframe' => array(
                                        'height' => array(),
                                        'frameborder' => array(),
                                        'style' => array(),
                                        'src' => array(),
                                        'allowfullscreen' => array(),
                                        )
                                    )); ?>                            
                                <?php else: ?>
                                    <iframe src="<?php echo esc_url(is_ssl() ? str_replace( 'http://', 'https://', $video ) : $video); ?> " width="100%" <?php if(get_post_format() == 'video'){echo 'height="400"';}?>></iframe>
                                <?php endif;?>
                            <?php if(get_post_format() == 'video'){
                                echo '</div>';
                            }
                            ?>                 
                    </div>
                </div>
        <?php endif; ?>
    <?php elseif(has_post_format('gallery')): ?>
        <?php if (is_array($gallery) && count($gallery) > 1) : ?>   
            <?php if(is_singular()):?>
                <div class="blog-gallery arrows-custom"> 
                    <?php
                    $index = 0;
                    foreach ($gallery as $key => $value) :
                        $image_detail = wp_get_attachment_image_src($value, 'solaz-blog-detail');
                        $alt = get_post_meta($value, '_wp_attachment_image_alt', true);
                            echo '<div class="img-gallery">
                                <div class="blog-img">
                                    <img src="' . esc_url($image_detail[0]) . '" alt="gallery-blog" class="gallery-img" />
                                </div>
                            </div>';
                        $index++;
                    endforeach;
                    ?>
                </div> 
            <?php else: ?>   
                <div class="blog-gallery align_left arrows-custom"> 
                    <?php
                    $index = 0;
                    foreach ($gallery as $key => $value) :
                        $image_grid = wp_get_attachment_image_src($value, 'solaz-blog-grid');
                        $image_detail = wp_get_attachment_image_src($value, 'solaz-blog-detail');
                        $image_list = wp_get_attachment_image_src($value, 'solaz-blog-list');
                        $alt = get_post_meta($value, '_wp_attachment_image_alt', true);
                        if ($post_layout == "list"){
                            echo '<div class="img-gallery">
                                <div class="blog-img">
                                    <a class="fancybox-thumb" data-fancybox-group="fancybox-thumb" href="' . esc_url($image_detail[0]) . '"><img src="' . esc_url($image_list[0]) . '" alt="gallery-blog" class="gallery-img" /></a>
                                </div>
                            </div>';
                        }else{
                            echo '<div class="img-gallery">
                                <div class="blog-img">
                                    <a class="fancybox-thumb" data-fancybox-group="fancybox-thumb" href="' . esc_url($image_detail[0]) . '"><img src="' . esc_url($image_grid[0]) . '" alt="gallery-blog" class="gallery-img" /></a>
                                </div>
                            </div>';
                        }
                        
                        $index++;
                    endforeach;
                    ?>
                </div>
            <?php endif; ?> 
        <?php else: ?>
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
                        <a class="fancybox-thumb" data-fancybox-group="fancybox-thumb" href="<?php echo esc_url($attachment_grid_2['src']) ?>"><img width="<?php echo esc_attr($attachment_grid['width']) ?>" height="<?php echo esc_attr($attachment_grid['height']) ?>" src="<?php echo esc_url($attachment_grid['src']) ?>" alt="<?php echo esc_attr($attachment_grid['alt']) ?>" /></a>  
                    <?php elseif ($post_layout == "list"):?>
                        <a class="fancybox-thumb" data-fancybox-group="fancybox-thumb" href="<?php echo esc_url($attachment_grid_2['src']) ?>"><img width="<?php echo esc_attr($attachment_img_list['width']) ?>" height="<?php echo esc_attr($attachment_img_list['height']) ?>" src="<?php echo esc_url($attachment_img_list['src']) ?>" alt="<?php echo esc_attr($attachment_img_list['alt']) ?>" /></a>  
                    <?php else :?>
                        <a class="fancybox-thumb" data-fancybox-group="fancybox-thumb" href="<?php echo esc_url($attachment_grid_2['src']) ?>"><img width="<?php echo esc_attr($attachment_img_full['width']) ?>" height="<?php echo esc_attr($attachment_img_full['height']) ?>" src="<?php echo esc_url($attachment_img_full['src']) ?>" alt="<?php echo esc_attr($attachment_img_full['alt']) ?>" /></a>  
                    <?php endif;?>
                </div> 
            <?php endif;?>
        <?php endif; ?>
    <?php elseif(has_post_format('link')):?>
        <?php 
            $link = get_post_meta(get_the_ID(), 'link_code', true); 
            $link_title = get_post_meta(get_the_ID(), 'link_title', true);
        ?>
        <?php if(is_singular()):?>
            <?php if($link && $link != ''):?>
                <figure>
                    <a class="post_link" href="<?php echo esc_url(is_ssl() ? str_replace( 'http://', 'https://', $link ) : $link);?>">
                        <i class="pe-7s-link"></i>
                        <?php if($link_title && $link_title != ''):?>
                            <span><?php echo wp_kses($link_title,array());?></span>
                        <?php endif;?> 
                    </a>
                </figure>
            <?php endif;?> 
        <?php else: ?>
            <?php if ($post_layout == "grid"): ?>
                <div class="blog-img">
                    <?php 
                        $attachment_id = get_post_thumbnail_id();
                        $attachment_grid = solaz_get_attachment($attachment_id, 'solaz-blog-grid'); 
                        $attachment_grid_2 = solaz_get_attachment($attachment_id, 'solaz-blog-detail'); 
                    ?>
                    <a class="fancybox-thumb" data-fancybox-group="fancybox-thumb" href="<?php echo esc_url($attachment_grid_2['src']) ?>"><img width="<?php echo esc_attr($attachment_grid['width']) ?>" height="<?php echo esc_attr($attachment_grid['height']) ?>" src="<?php echo esc_url($attachment_grid['src']) ?>" alt="<?php echo esc_attr($attachment_grid['alt']) ?>" /></a>  
                </div>
            <?php else: ?>
                <?php if($link && $link != ''):?>
                    <figure>
                        <a class="post_link" href="<?php echo esc_url(is_ssl() ? str_replace( 'http://', 'https://', $link ) : $link);?>">
                            <i class="pe-7s-link"></i>
                            <?php if($link_title && $link_title != ''):?>
                                <span><?php echo wp_kses($link_title,array());?></span>
                            <?php endif;?> 
                        </a>
                    </figure>
                <?php endif;?>
            <?php endif; ?>  
        <?php endif; ?>  
    <?php elseif(has_post_format('quote')):?>
        <?php 
            $quote = get_post_meta(get_the_ID(), 'quote_code', true); 
            $quote_author = get_post_meta(get_the_ID(), 'quote_author', true); 
        ?>
        <?php if(is_singular()):?>
            <div class="blog-img">
                <?php 
                    $attachment_id = get_post_thumbnail_id();
                    $image_detail = solaz_get_attachment($attachment_id, 'solaz-blog-detail'); 
                ?>
                <img width="<?php echo esc_attr($image_detail['width']) ?>" height="<?php echo esc_attr($image_detail['height']) ?>" src="<?php echo esc_url($image_detail['src']) ?>" alt="<?php echo esc_attr($image_detail['alt']) ?>" />
            </div>
            <?php if($quote && $quote != ''):?>
                <figure>
                    <div class="quote_section">
                        <blockquote class="var3">
                            <?php echo wp_kses($quote,array());?>
                        </blockquote>
                        <?php if($quote_author && $quote_author != ''):?>
                            <div class="author_info">- <?php echo  wp_kses($quote_author,array());?></div>
                        <?php endif;?> 
                    </div>
                </figure>
            <?php endif;?>  
        <?php else: ?>
            <?php if ($post_layout == "grid"): ?>
                <div class="blog-img">
                    <?php 
                        $attachment_id = get_post_thumbnail_id();
                        $attachment_grid = solaz_get_attachment($attachment_id, 'solaz-blog-grid'); 
                        $attachment_grid_2 = solaz_get_attachment($attachment_id, 'solaz-blog-detail'); 
                    ?>
                    <a class="fancybox-thumb" data-fancybox-group="fancybox-thumb" href="<?php echo esc_url($attachment_grid_2['src']) ?>"><img width="<?php echo esc_attr($attachment_grid['width']) ?>" height="<?php echo esc_attr($attachment_grid['height']) ?>" src="<?php echo esc_url($attachment_grid['src']) ?>" alt="<?php echo esc_attr($attachment_grid['alt']) ?>" /></a>  
                </div>
            <?php else: ?>
                <?php if($quote && $quote != ''):?>
                    <figure>
                        <div class="quote_section">
                            <blockquote class="var3">
                                <?php echo wp_kses($quote,array());?>
                            </blockquote>
                            <?php if($quote_author && $quote_author != ''):?>
                                <div class="author_info">- <?php echo  wp_kses($quote_author,array());?></div>
                            <?php endif;?> 
                        </div>
                    </figure>
                <?php endif;?>  
            <?php endif; ?>  
        <?php endif; ?>  
    <?php else: ?>
        <?php if (has_post_thumbnail()): ?>
             <?php if(is_singular()):?>
                <div class="blog-img">
                    <?php 
                        $attachment_id = get_post_thumbnail_id();
                        $image_detail = solaz_get_attachment($attachment_id, 'solaz-blog-detail'); 
                    ?>
                    <img width="<?php echo esc_attr($image_detail['width']) ?>" height="<?php echo esc_attr($image_detail['height']) ?>" src="<?php echo esc_url($image_detail['src']) ?>" alt="<?php echo esc_attr($image_detail['alt']) ?>" />
                </div>
            <?php else: ?>
                <div class="blog-img">
                    <?php 
                        $attachment_id = get_post_thumbnail_id();
                        $attachment_grid = solaz_get_attachment($attachment_id, 'solaz-blog-grid'); 
                        $attachment_img_list = solaz_get_attachment($attachment_id, 'solaz-blog-list'); 
                        $attachment_img_full = solaz_get_attachment($attachment_id, 'full'); 
                        $attachment_grid_2 = solaz_get_attachment($attachment_id, 'solaz-blog-detail'); 
                    ?>
                    <?php if ($post_layout == "grid"): ?>
                        <a class="fancybox-thumb" data-fancybox-group="fancybox-thumb" href="<?php echo esc_url($attachment_grid_2['src']) ?>"><img width="<?php echo esc_attr($attachment_grid['width']) ?>" height="<?php echo esc_attr($attachment_grid['height']) ?>" src="<?php echo esc_url($attachment_grid['src']) ?>" alt="<?php echo esc_attr($attachment_grid['alt']) ?>" /></a>  
                    <?php elseif ($post_layout == "list"):?>
                        <a class="fancybox-thumb" data-fancybox-group="fancybox-thumb" href="<?php echo esc_url($attachment_grid_2['src']) ?>"><img width="<?php echo esc_attr($attachment_img_list['width']) ?>" height="<?php echo esc_attr($attachment_img_list['height']) ?>" src="<?php echo esc_url($attachment_img_list['src']) ?>" alt="<?php echo esc_attr($attachment_img_list['alt']) ?>" /></a>  
                    <?php else :?>
                        <a class="fancybox-thumb" data-fancybox-group="fancybox-thumb" href="<?php echo esc_url($attachment_grid_2['src']) ?>"><img width="<?php echo esc_attr($attachment_img_full['width']) ?>" height="<?php echo esc_attr($attachment_img_full['height']) ?>" src="<?php echo esc_url($attachment_img_full['src']) ?>" alt="<?php echo esc_attr($attachment_img_full['alt']) ?>" /></a>  
                    <?php endif;?>
                </div>
            <?php endif;?>
        <?php endif;?>
    <?php endif; 
}
function solaz_gallery_posts_per_page( $query ) {
    global $solaz_settings;
    if(isset($solaz_settings['gallery_per_page']) && $solaz_settings['gallery_per_page'] != ''){
          if ( !is_admin() && $query->is_main_query() && (is_post_type_archive( 'gallery' ) || is_tax() )) {
            $query->set( 'posts_per_page', $solaz_settings['gallery_per_page'] );
          }
    }else{
        if ( !is_admin() && $query->is_main_query() && (is_post_type_archive( 'gallery' ) || is_tax() )) {
            $query->set( 'posts_per_page',  '8');
        }
    }
}
add_action( 'pre_get_posts', 'solaz_gallery_posts_per_page' );

function solaz_set_post_views($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
function solaz_get_attachment( $attachment_id, $size = 'full' ) {
    if (!$attachment_id)
        return false;
    $attachment = get_post( $attachment_id );
    $image = wp_get_attachment_image_src($attachment_id, $size);

    if (!$attachment)
        return false;

    return array(
        'alt' => esc_attr(get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true )),
        'caption' => esc_attr($attachment->post_excerpt),
        'description' => force_balance_tags($attachment->post_content),
        'href' => get_permalink( $attachment->ID ),
        'src' => esc_url($image[0]),
        'title' => esc_attr($attachment->post_title),
        'width' => esc_attr($image[1]),
        'height' => esc_attr($image[2])
    );
}
function get_image( $size = 'solaz_product_thumbnail', $attr = array() ) {
    if ( has_post_thumbnail( $this->id ) ) {
      $image = get_the_post_thumbnail( $this->id, $size, $attr );
    } elseif ( ( $parent_id = wp_get_post_parent_id( $this->id ) ) && has_post_thumbnail( $parent_id ) ) {
      $image = get_the_post_thumbnail( $parent_id, $size, $attr );
    } else {
      $image = wc_placeholder_img( $size );
    }
    return $image;
}
function solaz_pagination($max_num_pages = null) {
    global $wp_query, $wp_rewrite;

    $max_num_pages = ($max_num_pages) ? $max_num_pages : $wp_query->max_num_pages;

    // Don't print empty markup if there's only one page.
    if ($max_num_pages < 2) {
        return;
    }

    $paged = get_query_var('paged') ? intval(get_query_var('paged')) : 1;
    $pagenum_link = html_entity_decode(get_pagenum_link());
    $query_args = array();
    $url_parts = explode('?', $pagenum_link);

    if (isset($url_parts[1])) {
        wp_parse_str($url_parts[1], $query_args);
    }

    $pagenum_link = remove_query_arg(array_keys($query_args), $pagenum_link);
    $pagenum_link = trailingslashit($pagenum_link) . '%_%';

    $format = $wp_rewrite->using_index_permalinks() && !strpos($pagenum_link, 'index.php') ? 'index.php/' : '';
    $format .= $wp_rewrite->using_permalinks() ? user_trailingslashit($wp_rewrite->pagination_base . '/%#%', 'paged') : '?paged=%#%';

    // Set up paginated links.
    $links = paginate_links(array(
        'base' => $pagenum_link,
        'format' => $format,
        'total' => $max_num_pages,
        'current' => $paged,
        'end_size' => 1,
        'mid_size' => 1,
        'prev_next' => True,
        'prev_text' => '<i class="fa fa-long-arrow-left"></i>',
        'next_text' => '<i class="fa fa-long-arrow-right"></i>',
        'type' => 'list'
            ));

    if ($links) :
        ?>
        <nav class="pagination">
            <?php echo wp_kses($links, solaz_allow_html()); ?>        
        </nav>
        <?php
    endif;
}
function solaz_get_banner_block(){
    global $post, $solaz_settings;
    $static = ""; 
    if((get_post_meta($post->ID,'block_bottom',true) != 'default')){
        $static = get_post_meta($post->ID,'block_bottom',true) != "" ? get_post_meta($post->ID,'block_bottom',true) :"";
    }
    if($static != ''){      
        $block = get_post($static);
        $post_content = $block->post_content;
        $hide_static = solaz_get_meta_value('hide_static', true);
        if($hide_static){
            echo apply_filters('the_content', get_post_field('post_content', $static));
        }
    }
}
function solaz_get_excerpt($limit = 45) {

    if (!$limit) {
        $limit = 45;
    }

    $allowed_html =array(
        'a' => array(
            'href' => array(),
            'title' => array()
        ),
        'ul' => array(),
        'li'  => array(),
        'ol'  => array(),
        'iframe' => array(
            'src' => true,
            'width' => true,
            'height' => true,
            'align' => true,
            'class' => true,
            'name' => true,
            'id' => true,
            'frameborder' => true,
            'seamless' => true,
            'srcdoc' => true,
            'sandbox' => true,
            'allowfullscreen' => true
        ),
        'blockquote'  => array(),
        'embed' => array(
                'width' => array(),
                'height' => array(),
                ),
        'br' => array(),
        'img' => array(
            'alt' => array(),
            'src' => array(),
            'width' => array(),
            'height' =>array(), 
            'id' => array(),
            'style' => array(),
            'class' => array(),
            ),
        'audio' => array(
            'src' => true,
            'width' => true,
            'height' => true,
            'align' => true,
            'class' => true,
            'name' => true,
            'id' => true,
            'preload' => true,
            'style' => true,
            'controls' => true,
        ),
        'source' => array(
            'src' => true,
            'width' => true,
            'height' => true,
            'align' => true,
            'class' => true,
            'name' => true,
            'id' => true,
            'type' => true,
        ),
        'p'  => array(
            'style' => true,
            'class' => true,
            'id' => true,),
        'em' => array(),
        'strong' => array(),
    );

    if (has_excerpt()) {
        $content =  wp_kses(strip_shortcodes(get_the_excerpt()), $allowed_html) ;
    } else {
        $content = get_the_content( );
        $content = apply_filters( 'the_content', $content );
        $content = str_replace( ']]>', ']]&gt;', $content );
        $content =  wp_kses(strip_shortcodes($content), $allowed_html) ;
    }

    $content = explode(' ', $content, $limit);

    if (count($content) >= $limit) {
        array_pop($content);
            $content = implode(" ",$content).'<a href="'.get_the_permalink().'" class="blog-readmore"><i class="fa fa-caret-right"></i>&nbsp;'.esc_html__(' Read More', 'solaz').'</a>';
    } else {
        $content = implode(" ",$content);
    }

    return $content;
}
function solaz_latest_tweets_date( $created_at ){
   $date = DateTime::createFromFormat('D M d H:i:s O Y', $created_at ); 
    return sprintf( '%s ' . esc_html__( 'ago', 'solaz' ), human_time_diff( $date->format('U') ) );
}
function solaz_comment_nav() {
    if (get_comment_pages_count() > 1 && get_option('page_comments')) :
        ?>
        <nav class="navigation comment-navigation" role="navigation">
            <div class="comment-nav-links">
        <?php
        if ($prev_link = get_previous_comments_link(__('Older', 'solaz'))) :
            printf('<div class="comment-nav-previous">%s</div>', $prev_link);
        endif;

        if ($next_link = get_next_comments_link(__('Newer', 'solaz'))) :
            printf('<div class="comment-nav-next">%s</div>', $next_link);
        endif;
        ?>
            </div>
        </nav>
        <?php
    endif;
}
function solaz_comment_body_template($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    extract($args, EXTR_SKIP);

    if ('div' == $args['style']) {
        $tag = 'div';
        $add_below = 'comment';
    } else {
        $tag = 'li';
        $add_below = 'div-comment';
    }
    ?>
    <<?php echo esc_html($tag) ?> <?php comment_class(empty($args['has_children']) ? 'profile-content ' : 'parent profile-content' ) ?> id="comment-<?php comment_ID() ?>">
    <?php if ('div' != $args['style']) : ?>
        <div id="div-comment-<?php comment_ID() ?>" class="comment-body">
    <?php endif; ?>
        <?php if(get_avatar($comment, $args['avatar_size']) != ''):?>
            <div class="comment-author vcard profile-top">

                <?php if ($args['avatar_size'] != 0) echo get_avatar($comment, $args['avatar_size']); ?>    
            </div>
        <?php endif;?>

            <div class="profile-bottom">
                <?php if ($comment->comment_approved == '0') : ?>
                    <em class="comment-awaiting-moderation"><?php echo esc_html__('Your comment is awaiting moderation.', 'solaz'); ?></em>
                    <br />
                <?php endif; ?>
                <div class="comment-content profile-desc">
                    <?php comment_text(); ?>
                </div>
                <div class="comment-bottom">
                    <div class="profile-name"><?php printf(esc_html__('%s','solaz'), get_comment_author_link()); ?>
                    </div>
                    <div class="info-right">
                        <div class="date-cmt">
                            <i class="pe-7s-clock"></i> 
                            <?php
                            printf(esc_html__('%1$s', 'solaz'), get_comment_date());
                            ?>
                        </div>
                        <div class="links-info">
                            <?php if($depth<$args['max_depth']): ?>
                            <div class="info">
                                <?php comment_reply_link(array_merge($args, array('reply_text'=>'<i class="fa fa-reply"></i>'.esc_html__('Reply', 'solaz'),'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php if ('div' != $args['style']) : ?>
                    </div>
                <?php endif; ?>
            </div>
                <?php

}
add_filter('comment_reply_link', 'solaz_reply_link_class');
function solaz_reply_link_class($solaz_class){
    $solaz_class = str_replace("class='comment-reply-link", "class='", $solaz_class);
    return $solaz_class;
}

add_action( 'comment_form', 'solaz_comment_submit' );
function solaz_comment_submit( $post_id ) {
    if (get_post_type() !== 'product'){
        echo '<div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="comment-submit">
                        <button type="submit" class="submit btn btn-primary" > '.esc_html__('Send a comment', 'solaz').'   
                        </button>    
                    </div>
                </div>';
        }
}


add_filter('latest_tweets_render_date', 'solaz_latest_tweets_date', 10 , 1 );
function solaz_latest_tweets_hook( $html, $date, $link, array $tweet ){
    $output ='';
    $output .= '<div class="twitter-tweet"><i class="fa fa-twitter"></i><div class="tweet-text">'.$html.'<p class="my-date">'.$date.'</p></div>';
    
    $output .= ' </div>';
    return $output;
    // echo "<pre>";
    // print_r($tweet);
    // exit;
}
add_filter('latest_tweets_render_tweet', 'solaz_latest_tweets_hook', 10, 4 );
//allow html in widget title
function solaz_change_widget_title($title)
{
    //convert square brackets to angle brackets
    $title = str_replace('[', '<', $title);
    $title = str_replace(']', '>', $title);

    //strip tags other than the allowed set
    $title = strip_tags($title, '<a><blink><br><span>');
    return $title;
}
add_filter('widget_title', 'solaz_change_widget_title');
function solaz_custom_excerpt_length( $length ) {
    return 50;
}
add_filter( 'excerpt_length', 'solaz_custom_excerpt_length', 999 );

function solaz_maintenance_mode(){
    global $solaz_settings;
    if(isset($solaz_settings['under-contr-mode']) && $solaz_settings['under-contr-mode'] ==1){
        if(!current_user_can('edit_themes') || !is_user_logged_in()){
            wp_die(get_template_part('comming-soon'));
        }
    }
}
add_action('get_header', 'solaz_maintenance_mode');

add_filter('wp_list_categories', 'solaz_cat_count_span');
function solaz_cat_count_span($links) {
    $links = str_replace('</a> (', '<span> (', $links);
    $links = str_replace(')', ')</span></a>', $links);
    return $links;
}
function solaz_move_comment_field_to_bottom( $fields ) {
    $comment_field = $fields['comment'];
    unset( $fields['comment'] );
    $fields['comment'] = $comment_field;
    return $fields;
}
add_filter( 'comment_form_fields', 'solaz_move_comment_field_to_bottom' );

function solaz_allow_html(){
    return array(
        'form'=>array(
            'role' => array(),
            'method'=> array(),
            'class'=> array(),
            'action'=>array(),
            'id'=>array(),
            ),
        'input' => array(
            'type' => array(),
            'name'=> array(),
            'class'=> array(),
            'title'=>array(),
            'id'=>array(), 
            'value'=> array(), 
            'placeholder'=>array(),                          
            ),
        'button' => array(
            'type' => array(),
            'name'=> array(),
            'class'=> array(),
            'title'=>array(),
            'id'=>array(),                            
            ),                        
        'div'=>array(
            'class'=> array(),
            ),
        'h4'=>array(
            'class'=> array(),
            ),
        'a'=>array(
            'class'=> array(),
            'href'=>array(),
            'title' => array(),
            'onclick' => array(),
            'aria-expanded' => array(),
            'aria-haspopup' => array(),
            'data-toggle' => array(),
            ),
        'img'=>array(
            'src'=> array(),
            'alt'=>array(),
            'class' => array(),
            ),
        'i' => array(
            'class'=> array(),
        ),
        'p' => array(
            'class'=> array(),
        ), 
        'span' => array(
            'class'=> array(),
            'onclick' => array(),
            'style' => array(),
        ), 
        'strong' => array(
            'class'=> array(),
        ),  
        'ul' => array(
            'class'=> array(),
        ),  
        'li' => array(
            'class'=> array(),
        ), 
        'del' => array(),
        'ins' => array(),

    );
}
function solaz_get_page_banner() {
    global $wp_query, $header_type;
    $cat = $wp_query->get_queried_object();
    $show_slider = get_post_meta(get_the_ID(), 'show_slider', true);
    $slider_category = get_post_meta(get_the_ID(), 'category_slider', true);
    $output = '';
    ob_start();
    ?>
    <?php if($show_slider) :?>
        <div class="main-slider">
          <?php echo do_shortcode( '[rev_slider alias=' . $slider_category . ']' ); ?>
        </div>
    <?php endif;?>
    <?php
    $output .= ob_get_clean();
    echo $output;
}
add_action( "customize_register", "solaz_customize_register" );
function solaz_customize_register( $wp_customize ) {
     //=============================================================
     // Remove header image and widgets option from theme customizer
     //=============================================================
     $wp_customize->remove_control("header_image");

     //=============================================================
     // Remove Colors, Background image, and Static front page 
     // option from theme customizer     
     //=============================================================
     $wp_customize->remove_section("colors");
     $wp_customize->remove_section("background_image");
     $wp_customize->remove_section("static_front_page");
}
?>
