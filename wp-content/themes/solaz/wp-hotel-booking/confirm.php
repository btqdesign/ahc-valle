<?php
/**
 * Confirm plugin actions
 *
 * Override this template by copying it to yourtheme/tp-hotel-booking/confirm.php
 *
 * @author        ThimPress
 * @package       wp-hotel-booking/templates
 * @version       1.6
 */

if ( !defined( 'ABSPATH' ) ) {
	exit();
}
?>
<div id="hotel-booking-confirm">
    <form name="hb-search-form">
        <input type="hidden" name="hotel-booking" value="complete">
        <p>
            <button type="submit"><?php echo esc_html__( 'Finish', 'solaz' ); ?></button>
        </p>
    </form>
</div>