<?php
if ( !defined( 'ABSPATH' ) ) {
	exit();
}
?>
<div class="hb-order-new-customer" id="hb-order-new-customer">
    <div class="hb-col-padding hb-col-border">
        <h4 class="titlesub-cart"><?php esc_html_e( 'New Customer', 'solaz' ); ?></h4>
        <ul class="hb-form-table col-2 left">
            <li class="hb-form-field">
                <label class="hb-form-field-label"><?php esc_html_e( 'Title', 'solaz' ); ?>
                    <span class="hb-required">*</span> </label>

                <div class="hb-form-field-input">
					<?php hb_dropdown_titles( array( 'selected' => $customer->title ) ); ?>
                </div>
            </li>
            <li class="hb-form-field">
                <label class="hb-form-field-label"><?php esc_html_e( 'First name', 'solaz' ); ?>
                    <span class="hb-required">*</span></label>

                <div class="hb-form-field-input">
                    <input type="text" name="first_name" value="<?php echo esc_attr( $customer->first_name ); ?>" placeholder="<?php _e( 'First name', 'solaz' ); ?>" />
                </div>
            </li>
            <li class="hb-form-field">
                <label class="hb-form-field-label"><?php esc_html_e( 'Last name', 'solaz' ); ?>
                    <span class="hb-required">*</span></label>

                <div class="hb-form-field-input">
                    <input type="text" name="last_name" value="<?php echo esc_attr( $customer->last_name ); ?>" placeholder="<?php _e( 'Last name', 'solaz' ); ?>" required />
                </div>
            </li>
            <li class="hb-form-field">
                <label class="hb-form-field-label"><?php esc_html_e( 'Address', 'solaz' ); ?>
                    <span class="hb-required">*</span></label>

                <div class="hb-form-field-input">
                    <input type="text" name="address" value="<?php echo esc_attr( $customer->address ); ?>" placeholder="<?php _e( 'Address', 'solaz' ); ?>" />
                </div>
            </li>
            <li class="hb-form-field">
                <label class="hb-form-field-label"><?php esc_html_e( 'City', 'solaz' ); ?>
                    <span class="hb-required">*</span></label>

                <div class="hb-form-field-input">
                    <input type="text" name="city" value="<?php echo esc_attr( $customer->city ); ?>" placeholder="<?php _e( 'City', 'solaz' ); ?>" />
                </div>
            </li>
            <li class="hb-form-field">
                <label class="hb-form-field-label"><?php esc_html_e( 'State', 'solaz' ); ?>
                    <span class="hb-required">*</span></label>

                <div class="hb-form-field-input">
                    <input type="text" name="state" value="<?php echo esc_attr( $customer->state ); ?>" placeholder="<?php _e( 'State', 'solaz' ); ?>" />
                </div>
            </li>
        </ul>
        <ul class="hb-form-table col-2 right">
            <li class="hb-form-field">
                <label class="hb-form-field-label"><?php esc_html_e( 'Postal Code', 'solaz' ); ?>
                    <span class="hb-required">*</span></label>

                <div class="hb-form-field-input">
                    <input type="text" name="postal_code" value="<?php echo esc_attr( $customer->postal_code ); ?>" placeholder="<?php _e( 'Postal code', 'solaz' ); ?>" />
                </div>
            </li>
            <li class="hb-form-field">
                <label class="hb-form-field-label"><?php esc_html_e( 'Country', 'solaz' ); ?>
                    <span class="hb-required">*</span></label>

                <div class="hb-form-field-input">
					<?php hb_dropdown_countries( array( 'name' => 'country', 'show_option_none' => esc_html__( 'Country', 'solaz' ), 'selected' => $customer->country ) ); ?>
                </div>
            </li>
            <li class="hb-form-field">
                <label class="hb-form-field-label"><?php esc_html_e( 'Phone', 'solaz' ); ?>
                    <span class="hb-required">*</span></label>

                <div class="hb-form-field-input">
                    <input type="text" name="phone" value="<?php echo esc_attr( $customer->phone ); ?>" placeholder="<?php _e( 'Phone Number', 'solaz' ); ?>" />
                </div>
            </li>
            <li class="hb-form-field">
                <label class="hb-form-field-label"><?php esc_html_e( 'Email', 'solaz' ); ?>
                    <span class="hb-required">*</span></label>

                <div class="hb-form-field-input">
                    <input type="email" name="email" value="<?php echo esc_attr( $customer->email ); ?>" placeholder="<?php _e( 'Email address', 'solaz' ); ?>" />
                </div>
            </li>
            <li class="hb-form-field">
                <label class="hb-form-field-label"><?php esc_html_e( 'Fax', 'solaz' ); ?></label>

                <div class="hb-form-field-input">
                    <input type="text" name="fax" value="<?php echo esc_attr( $customer->fax ); ?>" placeholder="<?php _e( 'Fax', 'solaz' ); ?>" />
                </div>
            </li>
        </ul>
        <input type="hidden" name="existing-customer-id" value="" />
    </div>
</div>