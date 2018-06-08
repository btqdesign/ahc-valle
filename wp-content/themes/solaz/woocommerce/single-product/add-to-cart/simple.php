<?php
/**
 * Simple product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

if ( ! $product->is_purchasable() ) {
	return;
}
$solaz_settings = solaz_check_theme_options();


?>


<?php if(isset($solaz_settings['product-cart'])){
		if($solaz_settings['product-cart']){?>
			<?php if ( $product->is_in_stock() ) : ?>

				<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

				<form class="cart" method="post" enctype='multipart/form-data'>
				 	<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>
				 	<?php
				 		if ( ! $product->is_sold_individually() ) {
				 			woocommerce_quantity_input( array(
				 				'min_value'   => apply_filters( 'woocommerce_quantity_input_min', 1, $product ),
				 				'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->backorders_allowed() ? '' : $product->get_stock_quantity(), $product ),
				 				'input_value' => ( isset( $_POST['quantity'] ) ? wc_stock_amount( $_POST['quantity'] ) : 1 )
				 			) );
				 		}
				 	?>

				 	<?php 
				 		echo apply_filters( 'woocommerce_loop_add_to_cart_link',
							sprintf( '<a rel="nofollow" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" class="single_add_to_cart_button cart-btn btn button product_type_simple add_to_cart_button ajax_add_to_cart">Add to cart</a>',
								esc_url( $product->add_to_cart_url() ),
								esc_attr( isset( $quantity ) ? $quantity : 1 ),
								esc_attr( $product->get_id() ),
								esc_attr( $product->get_sku() ),
								esc_attr( isset( $class ) ? $class : 'button' ),
								esc_html( $product->add_to_cart_text() )
							),
						$product );
				 	?>

					<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
				</form>

				<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

			<?php endif; ?>
	<?php }?>
<?php }?>