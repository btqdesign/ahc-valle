<?php
$output  = $number = $first_title = $last_title = $item_delay =  $el_class = '';
extract(shortcode_atts(array(
    'first_title' =>'Our',
    'last_title' => 'Gallery',
    'icon_title' => 'icon_1',
    'number' => 6,
    'cat' => '',
    'order' => 'desc',
    'layout' => 'grid',
    'columns' => 3,
    'show_viewmore' => '',
    'item_delay' => 'yes',
    'el_class' => '',
    'display_filter' => '',
    'hide_empty' => 'yes',
), $atts));
if ( get_query_var('paged') ) {
    $paged = get_query_var('paged');
} elseif ( get_query_var('page') ) {
    $paged = get_query_var('page');
} else {
    $paged = 1;
}
$hide_empty_value = $hide_empty?true:false;
$current_page = get_query_var('paged') ? intval(get_query_var('paged')) : 1;
$args = array(
    'post_type' => 'gallery',
    'post_status' => 'publish',
    'ignore_sticky_posts' => 1,
    'posts_per_page' => $number,
    'paged' => $paged,
    'order' => $order,
    'orderby' => 'date',
);
$catArray = explode(',', $cat);
if ($cat){
    $args['tax_query'] = array(
        array(
            'taxonomy' => 'gallery_cat',
            'field'    => 'term_id',
            'terms'    => $catArray,
        ),
    );
}
$taxonomy_names = get_object_taxonomies( 'gallery' );
    if ( is_array( $taxonomy_names ) && count( $taxonomy_names ) > 0  && in_array( 'gallery_cat', $taxonomy_names ) ) {
        if($cat){
            $terms = get_terms( 'gallery_cat', array(
            'parent' => $cat, 
            'hide_empty' => $hide_empty_value,
            ) );
        }else{
            $terms = get_terms(array(
                'taxonomy' => 'gallery_cat',
                'hide_empty' => $hide_empty_value,
                'parent'  => 0, 
                'hierarchical' => false, 
            ) );          
        }
    }
$string1='';
if($cat && $cat!=''){
  $string = str_replace(' ', '', $cat);
  $string1 = str_replace(',', '', $string);  
}
$id =  'arrowpress_gallery-'.$string1;
query_posts($args);
global $wp_query;
$el_class = arrowpress_shortcode_extract_class( $el_class );
$output = '<div class="our-gallery-sc ' . $el_class . '"';
$output .= '>';
ob_start();
if(isset($columns)){
   $col_class=" col-".$columns;
}
?>
<?php 
    $count_item = 0.2; 
    $animation_delay = '';
    if($item_delay) {
        $animation_delay = ' data-sr="wait '. $count_item .'s"';  
    }
    $count_item += 0.2;
?>
<?php if (have_posts()) : ?>
            <?php if($display_filter=='yes'):?>
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
            <?php endif;?>
            <div class="tabs_sort">
                <div id="<?php echo $id;?>" class="gallery-entries-wrapsc isotope clearfix <?php echo esc_attr($col_class);?>">   
                    <?php while (have_posts()) : the_post(); ?>
                        <?php if($layout == 'masonry'):?>
                            <?php get_template_part('templates/content', 'gallery-masonry'); ?>                                     
                        <?php else:?>
                            <?php get_template_part('templates/content', 'gallery-grid'); ?><?php endif;?>
                    <?php endwhile; ?>
                </div>  
            </div> 

            <?php if($show_viewmore) :?>
                <div <?php echo $animation_delay; ?> >
                    <?php if ($wp_query->max_num_pages > 1) : ?>
                        <div class="load-more text-center">
                            <a data-paged="<?php echo esc_attr($current_page) ?>" data-totalpage="<?php echo esc_attr($wp_query->max_num_pages) ?>" id="gallery-loadmoresc" class="btn btn-default gallery_loadmore_btn"><?php echo esc_html__('Load More', 'arrowpress-shortcodes') ?> </a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif;?>  
<?php endif;?>
<?php
    $output .= ob_get_clean();

    $output .= '</div>' . arrowpress_shortcode_end_block_comment( 'arrowpress_gallery' ) . "\n";

    echo $output;

wp_reset_query(); ?>