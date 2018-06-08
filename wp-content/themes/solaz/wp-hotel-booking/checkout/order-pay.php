<?php

if ( !defined( 'ABSPATH' ) ) {
	exit();
}

?>
<?php $book = HB_Booking::instance( $booking_id ); ?>

<?php $currency_symbol = hb_get_currency_symbol( $book->currency ); ?>

<?php if ( $book->get_status() !== 'completed' ): ?>
	<?php do_action( 'hotel_booking_order_pay_before' ); ?>
    <h3><?php printf( esc_html__( 'Booking ID: %s', 'solaz' ), hb_format_order_number( $booking_id ) ) ?></h3>
    <p>
        <strong><?php echo esc_html__( 'Payment status: ', 'solaz' ) ?></strong>
		<?php printf( '%s', ucfirst( $book->get_status() ) ) ?>
    </p>
    <p>
        <strong><?php echo esc_html__( 'Booking Date: ', 'solaz' ) ?></strong>
		<?php printf( '%s', get_the_date( '', $book->id ) ) ?>
    </p>
    <p>
        <strong><?php echo esc_html__( 'Payment Method: ', 'solaz' ) ?></strong>
		<?php printf( '%s', $book->method_title ) ?>
    </p>
    <p>
        <strong><?php echo esc_html__( 'Total: ', 'solaz' ) ?></strong>
		<?php printf( '%s', hb_format_price( hb_booking_total( $booking_id ), $currency_symbol ) ) ?>
    </p>
    <p>
        <strong><?php echo esc_html__( 'Advance Payment: ', 'solaz' ) ?></strong>
		<?php printf( '%s', hb_format_price( $book->advance_payment, $currency_symbol ) ) ?>
    </p>
	<?php do_action( 'hotel_booking_order_pay_after' ); ?>
    <!--_hb_advance_payment-->
<?php else: ?>

    <h3><?php printf( esc_html__( '%s was pay completed', 'solaz' ), $book->get_booking_number() ) ?></h3>

<?php endif; ?>