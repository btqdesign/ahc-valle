<?php

if ( !defined( 'ABSPATH' ) ) {
	exit();
}

$cart = WP_Hotel_Booking::instance()->cart;
global $hb_settings;

do_action( 'hotel_booking_before_checkout_form' );

?>

    <div id="hotel-booking-payment">

        <form name="hb-payment-form" id="hb-payment-form" method="post" action="<?php echo isset( $search_page ) ? $search_page : ''; ?>">
            <h2 class="title-cart"><?php esc_html_e( 'Booking Rooms', 'solaz' ); ?></h2>
            <table class="hb_table">
                <thead>
                <th class="hb_room_type"><?php esc_html_e( 'Room type', 'solaz' ); ?></th>
                <th class="hb_capacity"><?php esc_html_e( 'Capacity', 'solaz' ); ?></th>
                <th class="hb_quantity"><?php esc_html_e( 'Quantity', 'solaz' ); ?></th>
                <th class="hb_check_in"><?php esc_html_e( 'Check - in', 'solaz' ); ?></th>
                <th class="hb_check_out"><?php esc_html_e( 'Check - out', 'solaz' ); ?></th>
                <th class="hb_night"><?php esc_html_e( 'Night', 'solaz' ); ?></th>
                <th class="hb_gross_total"><?php esc_html_e( 'Gross Total', 'solaz' ); ?></th>
                </thead>
				<?php if ( $rooms = $cart->get_rooms() ): ?>
					<?php foreach ( $rooms as $cart_id => $room ): ?>
						<?php
						if ( ( $num_of_rooms = (int) $room->get_data( 'quantity' ) ) == 0 ) continue;
						$cart_extra = WP_Hotel_Booking::instance()->cart->get_extra_packages( $cart_id );
						$sub_total  = $room->get_total( $room->check_in_date, $room->check_out_date, $num_of_rooms, false );
						?>
                        <tr class="hb_checkout_item" data-cart-id="<?php echo esc_attr( $cart_id ); ?>">
                            <td data-title="<?php esc_html_e( 'Room type', 'solaz' ); ?>" class="hb_room_type"<?php echo defined( 'TP_HB_EXTRA' ) && $cart_extra ? ' rowspan="' . ( count( $cart_extra ) + 2 ) . '"' : '' ?>>
                                <a href="<?php echo esc_url( get_permalink( $room->ID ) ); ?>"><?php echo esc_html( $room->name ); ?><?php printf( '%s', $room->capacity_title ? ' (' . $room->capacity_title . ')' : '' ); ?></a>
                            </td>
                            <td data-title="<?php esc_html_e( 'Capacity', 'solaz' ); ?>" class="hb_capacity"><?php echo sprintf( _n( '%d adult', '%d adults', $room->capacity, 'solaz' ), $room->capacity ); ?> </td>
                            <td data-title="<?php esc_html_e( 'Quantity', 'solaz' ); ?>" class="hb_quantity"><?php printf( '%s', $num_of_rooms ); ?></td>
                            <td data-title="<?php esc_html_e( 'Check - in', 'solaz' ); ?>" class="hb_check_in"><?php echo date_i18n( hb_get_date_format(), strtotime( $room->get_data( 'check_in_date' ) ) ) ?></td>
                            <td data-title="<?php esc_html_e( 'Check - out', 'solaz' ); ?>" class="hb_check_out"><?php echo date_i18n( hb_get_date_format(), strtotime( $room->get_data( 'check_out_date' ) ) ) ?></td>
                            <td data-title="<?php esc_html_e( 'Night', 'solaz' ); ?>" class="hb_night"><?php echo hb_count_nights_two_dates( $room->get_data( 'check_out_date' ), $room->get_data( 'check_in_date' ) ) ?></td>
                            <td data-title="<?php esc_html_e( 'Gross Total', 'solaz' ); ?>" class="hb_gross_total">
								<?php echo hb_format_price( $room->total ); ?>
                            </td>
                        </tr>
						<?php do_action( 'hotel_booking_cart_after_item', $room, $cart_id ); ?>
					<?php endforeach; ?>
				<?php endif; ?>

				<?php do_action( 'hotel_booking_before_cart_total' ); ?>

                <tr class="hb_sub_total">
                    <td colspan="8"><?php esc_html_e( 'Sub Total', 'solaz' ); ?>
                        <span class="hb-align-right hb_sub_total_value">
                        <?php echo hb_format_price( $cart->sub_total ); ?>
                    </span>
                    </td>
                </tr>

				<?php if ( $tax = hb_get_tax_settings() ) { ?>
                    <tr class="hb_advance_tax">
                        <td colspan="8">
							<?php esc_html_e( 'Tax', 'solaz' ); ?>
							<?php if ( $tax < 0 ) { ?>
                                <span><?php printf( esc_html__( '(price including tax)', 'solaz' ) ); ?></span>
							<?php } ?>
                            <span class="hb-align-right"><?php echo apply_filters( 'hotel_booking_cart_tax_display', hb_format_price( $cart->total - $cart->sub_total ) ); // abs( $tax * 100 ) . '%' ?></span>
                        </td>
                    </tr>
				<?php } ?>

                <tr class="hb_advance_grand_total">
                    <td colspan="8">
						<?php esc_html_e( 'Grand Total', 'solaz' ); ?>
                        <span class="hb-align-right hb_grand_total_value"><?php echo hb_format_price( $cart->total ); ?></span>
                    </td>
                </tr>
				<?php if ( $advance_payment = $cart->advance_payment ) { ?>
                    <tr class="hb_advance_payment">
                        <td colspan="8">
							<?php printf( esc_html__( 'Advance Payment (%s%% of Grand Total)', 'solaz' ), hb_get_advance_payment() ); ?>
                            <span class="hb-align-right hb_advance_payment_value"><?php echo hb_format_price( $advance_payment ); ?></span>
                        </td>
                    </tr>
					<?php if ( hb_get_advance_payment() < 100 ) { ?>
                        <tr class="hb_payment_all">
                            <td colspan="8" class="hb-align-right">
                                <label class="hb-align-right">
                                    <input type="checkbox" name="pay_all" />
									<?php esc_html_e( 'I want to pay all', 'solaz' ); ?>
                                </label>
                            </td>
                        </tr>
					<?php } ?>
				<?php } ?>

            </table>

			<?php if ( !is_user_logged_in() && !hb_settings()->get( 'guest_checkout' ) && get_option( 'users_can_register' ) ) : ?>

				<?php printf( esc_html__( 'You have to <strong><a href="%s">login</a></strong> or <strong><a href="%s">register</a></strong> to checkout.', 'solaz' ), wp_login_url( hb_get_checkout_url() ), wp_registration_url() ) ?>

			<?php else : ?>

				<?php hb_get_template( 'checkout/customer.php', array( 'customer' => $customer ) ); ?>
				<?php hb_get_template( 'checkout/payment-method.php', array( 'customer' => $customer ) ); ?>
				<?php hb_get_template( 'checkout/addition-information.php' ); ?>
				<?php wp_nonce_field( 'hb_customer_place_order', 'hb_customer_place_order_field' ); ?>

                <input type="hidden" name="hotel-booking" value="place_order" />
                <input type="hidden" name="action" value="hotel_booking_place_order" />
                <input type="hidden" name="total_advance" value="<?php echo esc_attr( $cart->advance_payment ? $cart->advance_payment : $cart->total ); ?>" />
                <input type="hidden" name="total_price" value="<?php echo esc_attr( $cart->total ); ?>" />
                <input type="hidden" name="currency" value="<?php echo esc_attr( hb_get_currency() ) ?>">
				<?php if ( $tos_page_id = hb_get_page_id( 'terms' ) ) { ?>
                    <p>
                        <label>
                            <input type="checkbox" name="tos" value="1" />
							<?php printf( esc_html__( 'I agree with ', 'solaz' ) . '<a href="%s" target="_blank">%s</a>', get_permalink( $tos_page_id ), get_the_title( $tos_page_id ) ); ?>
                            <span class="hb-required">*</span>
                        </label>
                    </p>
				<?php } ?>
                <p>
                    <button type="submit" class="hb_button"><?php esc_html_e( 'Check out', 'solaz' ); ?></button>
                </p>

			<?php endif; ?>
        </form>
    </div>

<?php do_action( 'hotel_booking_after_checkout_form' ); ?>