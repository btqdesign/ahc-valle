<?php

if ( !defined( 'ABSPATH' ) ) {
	exit();
}

?>

<h2 class="title-cart"><?php esc_html_e( 'Customer Details', 'solaz' ); ?></h3>
<div class="hb-customer clearfix">
	<?php hb_get_template( 'checkout/customer-existing.php', array( 'customer' => $customer ) ); ?>
	<?php hb_get_template( 'checkout/customer-new.php', array( 'customer' => $customer ) ); ?>
</div>
<div class="hb-col-margin"></div>
