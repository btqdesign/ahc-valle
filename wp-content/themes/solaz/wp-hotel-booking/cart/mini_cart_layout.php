<?php

if ( !defined( 'ABSPATH' ) ) {
	exit();
}

?>
<script type="text/html" id="tmpl-hb-minicart-item">
    <div class="hb_mini_cart_item active" data-cart-id="{{ data.cart_id }}">

        <div class="hb_mini_cart_top">

            <h4 class="hb_title"><a href="{{{ data.permalink }}}">{{ data.name }}</a></h4>
            <span class="hb_mini_cart_remove"><i class="fa fa-times"></i></span>

        </div>

        <div class="hb_mini_cart_number">

            <label><?php esc_html_e( 'Quantity: ', 'solaz' ); ?></label>
            <span>{{ data.quantity }}</span>

        </div>

        <div class="hb_mini_cart_price">

            <label><?php esc_html_e( 'Price: ', 'solaz' ); ?></label>
            <span>{{{ data.total }}}</span>

        </div>
    </div>
</script>
<script type="text/html" id="tmpl-hb-minicart-footer">
    <div class="hb_mini_cart_footer buttons">

        <a href="<?php echo hb_get_checkout_url() ?>" class="hb_button hb_checkout button"><?php esc_html_e( 'Check Out', 'solaz' ); ?></a>
        <a href="<?php echo hb_get_cart_url(); ?>" class="hb_button hb_view_cart button"><?php esc_html_e( 'View Cart', 'solaz' ); ?></a>

    </div>
</script>
<script type="text/html" id="tmpl-hb-minicart-empty">
    <p class="hb_mini_cart_empty"><?php esc_html_e( 'Your cart is empty!', 'solaz' ); ?></p>
</script>