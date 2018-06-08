<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' ); ?>
<?php
global $wp_query, $woocommerce_loop;
$solaz_settings = solaz_check_theme_options();
$solaz_sidebar_left = solaz_get_sidebar_left();
$solaz_sidebar_right = solaz_get_sidebar_right();
$solaz_layout = solaz_get_layout();
$cat = $wp_query->get_queried_object();
//only for demo
if (isset($_GET['sidebar']) && $_GET['sidebar']=="none") {
    $solaz_sidebar_left = $_GET['sidebar'];
    $solaz_sidebar_right = $_GET['sidebar'];
}
//end demo
if(isset($cat->term_id)){
	$woo_cat = $cat->term_id;
}else{
	$woo_cat = '';
}
$product_list_mode = get_metadata('product_cat', $woo_cat, 'list_mode_product', true);
$product_layout = isset($solaz_settings['product-layouts']) ? $solaz_settings['product-layouts'] :'';
?>
<?php
	$class = '';
	if ($solaz_sidebar_left && $solaz_sidebar_right && is_active_sidebar($solaz_sidebar_left) && is_active_sidebar($solaz_sidebar_right)){
	 	$class .= 'col-md-6 col-sm-12 col-xs-12 main-sidebar'; 
	}elseif($solaz_sidebar_left && (!$solaz_sidebar_right|| $solaz_sidebar_right=="none") && is_active_sidebar($solaz_sidebar_left)){
		$class .= 'f-right col-lg-9 col-md-9 col-sm-12 col-xs-12 main-sidebar'; 
	}elseif((!$solaz_sidebar_left || $solaz_sidebar_left=="none") && $solaz_sidebar_right && is_active_sidebar($solaz_sidebar_right)){
		$class .= 'col-lg-9 col-md-9 col-sm-12 col-xs-12 main-sidebar'; 
	}else {
		$class .= 'content-primary'; 
		if($solaz_layout == 'fullwidth'){
			$class .= ' col-md-12';
		}
	}
	$current_page = get_query_var('paged') ? intval(get_query_var('paged')) : 1;
?>
<?php get_sidebar('left'); ?> 
	<div class="<?php echo esc_attr($class);?>">
		<?php if ( have_posts() ) : ?>
			<?php wc_print_notices(); ?>
			<?php
				/**
				 * woocommerce_archive_description hook.
				 *
				 * @hooked woocommerce_taxonomy_archive_description - 10
				 * @hooked woocommerce_product_archive_description - 10
				 */
				
				do_action( 'woocommerce_archive_description' );
			?>
	    	<?php 
	    	$category_cols = get_metadata('product_cat', $woo_cat, 'category_cols', true);
			$cols_md = 'columns-4';
			if(!is_product_category()){
			    switch ($solaz_settings['product-cols']) {
					case 1: $cols_md = ' columns-1';
			            break;
			    	case 2: $cols_md = ' columns-2';
			            break;
			        case 3: $cols_md = ' columns-3';
			            break;
			        default: $cols_md = ' columns-4';
			            break;
			    }
			} else{
			    switch ($category_cols) {
			    	case 1: $cols_md = ' columns-1';
			            break;
					case 2: $cols_md = ' columns-2';
			            break;
			        case 3: $cols_md = ' columns-3';
			            break;
			        default: $cols_md = ' columns-4';
			            break;
			    }
			}
			$terms = get_terms( 'product_cat', array(
	        'hierarchical'  => false,
	        'hide_empty'        => true,
	        'order' => 'random'
	        ) );
	    	?>
			<div class="text-center product_archives clearfix woocommerce <?php echo esc_attr($cols_md);?>">
				<div class="title_archive_product text-center animate-top">
					<h2><?php echo esc_html__('all our items', 'solaz')?></h2>
				</div>
				<?php if (($product_list_mode == "only-list")): ?>
				<?php else: ?>
					<div class="tabs-fillter">
						<ul class="nav nav-tabs btn-filter animate-top">
							<li><a class="button active" data-filter="*"><?php echo esc_html__('All','solaz'); ?></a></li>
							<?php foreach ( $terms as $term ) : ?>
							<li><a class="button" data-filter=".<?php echo esc_attr($term->slug); ?>"><?php echo esc_html($term->name); ?></a></li>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php endif;?>
				<?php if (is_array( $terms ) && count( $terms ) > 0 ) : ?>
                
                <?php endif;?>
				<?php woocommerce_product_loop_start(); ?>

					<?php woocommerce_product_subcategories(); ?>

					<?php while ( have_posts() ) : the_post(); ?>

						<?php wc_get_template_part( 'content', 'product' ); ?>

					<?php endwhile; // end of the loop. ?>

				<?php woocommerce_product_loop_end(); ?>
				<?php 
					global $solaz_settings;
				?>
				<?php if($solaz_settings['product-pagination'] == 'pagination') :?>
					<?php
						/**
						 * woocommerce_after_shop_loop hook.
						 *
						 * @hooked woocommerce_pagination - 10
						 */
						do_action( 'woocommerce_after_shop_loop' );
					?> 
				<?php else:?>	
					<?php if ($wp_query->max_num_pages > 1) : ?>
						<div class="load-more product-loadmore text-center col-md-12">
							<a class="btn btn-primary" data-paged="<?php echo esc_attr($current_page) ?>" data-totalpage="<?php echo esc_html($wp_query->max_num_pages); ?>" id="product-loadmore"> 
							<?php 
								echo esc_html__('Load More','solaz');
							?>   
							</a>
						</div>
					<?php endif; ?>
				<?php endif;?>	
			</div>


		<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

			<?php wc_get_template( 'loop/no-products-found.php' ); ?>

		<?php endif; ?>
	</div>
<?php get_sidebar('right'); ?>
<?php get_footer( 'shop' ); ?>
