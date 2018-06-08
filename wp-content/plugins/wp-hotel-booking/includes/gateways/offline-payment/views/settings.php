<?php
/**
 * @Author: ducnvtt
 * @Date:   2016-03-29 09:10:23
 * @Last Modified by:   ducnvtt
 * @Last Modified time: 2016-04-14 14:50:51
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

$settings = WPHB_Settings::instance();
$payment  = $settings->get( 'offline-payment' );
$payment  = wp_parse_args(
	$payment,
	array(
		'enable'        => 'off',
		'email_subject' => 'Offline payment email subject',
		'email_content' => 'Offline payment email content',
		'instruction'   => ''
	)
);

$field_name = $settings->get_field_name( 'offline-payment' );
?>
<table class="form-table">
    <tr>
        <th><?php _e( 'Enable', 'wp-hotel-booking' ); ?></th>
        <td>
            <input type="hidden" name="<?php echo esc_attr( $field_name ); ?>[enable]" value="off"/>
            <input type="checkbox"
                   name="<?php echo esc_attr( $field_name ); ?>[enable]" <?php checked( $payment['enable'] == 'on' ? 1 : 0, 1 ); ?>
                   value="on"/>
            <p class="description"><?php _e( 'Enable checkout booking via Offline payment', 'wp-hotel-booking' ); ?></p>
        </td>
    </tr>
    <tr>
        <th><?php _e( 'Instruction', 'wp-hotel-booking' ); ?></th>
        <td>

            <input type="hidden" name="<?php echo esc_attr( $field_name ); ?>[instruction]"/>
			<?php wp_editor( $payment['instruction'], 'offline-payment-instruction', array(
				'media_buttons' => false,
				'textarea_name' => 'tp_hotel_booking_offline-payment[instruction]'
			) ); ?>
            <p class="description"><?php _e( 'Information for bank transfer via Offline payment, eg: Bank account', 'wp-hotel-booking' ); ?></p>
        </td>
    </tr>
</table>