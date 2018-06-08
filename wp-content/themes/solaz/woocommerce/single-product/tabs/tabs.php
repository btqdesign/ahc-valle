<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 * @see woocommerce_default_product_tabs()
 */
$tabs = apply_filters( 'woocommerce_product_tabs', array() );

if ( ! empty( $tabs ) ) : ?>
<?php
    global $post, $product;
    $custom_tab_title = get_post_meta(get_the_id(), 'custom_tab_title', true);
    $custom_tab_content = get_post_meta(get_the_id(), 'custom_tab_content', true);
    $tag_count = sizeof( get_the_terms( $post->ID, 'product_tag' ) );
    $tag_condition = get_the_terms( $post->ID, 'product_tag' );
?>
<div class="product-tab">
	<div class="woocommerce-tabs wc-tabs-wrapper">
		<ul class="nav nav-tabs tabs wc-tabs">
			<?php foreach ( $tabs as $key => $tab ) : ?>
				<li class="<?php echo esc_attr( $key ); ?>_tab">
					<a href="#tab-<?php echo esc_attr( $key ); ?>"><?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', esc_html( $tab['title'] ), $key ); ?></a>
				</li>
			<?php endforeach; ?>
            <?php if($tag_condition) :?>
                <li  class="tab-custom1_tab"><a href="#tab-custom1"><?php echo esc_html__('Tags', 'solaz') ?></a></li>                
            <?php endif;?>
            <?php if ($custom_tab_title && $custom_tab_content) : ?>
                <li  class="tab-custom1_tab"><a href="#tab-custom2"><?php echo force_balance_tags($custom_tab_title) ?></a></li>
            <?php endif; ?>
		</ul>
        <div class="tab-content">
    		<?php foreach ( $tabs as $key => $tab ) : ?>
    			<div class="panel entry-content wc-tab" id="tab-<?php echo esc_attr( $key ); ?>">
    				<?php call_user_func( $tab['callback'], $key, $tab ); ?>
    			</div>
    		<?php endforeach; ?>
            <?php if($tag_condition) :?>
                <div class="panel entry-content" id="tab-custom1">
                <?php echo wc_get_product_tag_list( $product->get_id(), ', ', '<span class="tagged_as">' . _n( 'Tag:', 'Tags:', count( $product->get_tag_ids() ), 'solaz' ) . ' ', '</span>' ); ?>
                </div>
            <?php endif; ?>    
            <?php if ($custom_tab_title && $custom_tab_content) : ?>
                <div class="panel entry-content" id="tab-custom2">
                    <?php echo wpautop(do_shortcode($custom_tab_content)) ?>
                </div>
            <?php endif; ?>
        </div>
	</div>
</div>
<?php endif; ?>
