<?php

if ( !defined( 'ABSPATH' ) ) {
	exit();
}

?>
<?php if ( !is_user_logged_in() ) : ?>

    <div class="hb-order-existing-customer" data-label="<?php esc_attr_e( '-Or-', 'solaz' ); ?>">
        <div class="hb-col-padding hb-col-border">
            <h4 class="titlesub-cart"><?php esc_html_e( 'Existing customer?', 'solaz' ); ?></h4>
            <ul class="hb-form-table">
                <li class="hb-form-field">
                    <label class="hb-form-field-label"><?php esc_html_e( 'Email', 'solaz' ); ?></label>
                    <div class="hb-form-field-input">
                        <input type="email" name="existing-customer-email" value="<?php echo esc_attr( WP_Hotel_Booking::instance()->cart->customer_email ); ?>" placeholder="<?php _e( 'Your email here', 'solaz' ); ?>" />
                    </div>
                </li>
                <li>
                    <button type="button" id="fetch-customer-info"><?php esc_html_e( 'Apply', 'solaz' ); ?></button>
                </li>
            </ul>
        </div>
    </div>

<?php endif; ?>