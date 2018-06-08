<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit();
}
$check_in_date = current_time( 'timestamp', 1 );
if(hb_get_request( 'check_in_date' )){
   $check_in_date = hb_get_request( 'check_in_date' ); 
}
$check_out_date = current_time( 'timestamp', 1 );
if(hb_get_request( 'check_out_date' )){
$check_out_date = hb_get_request( 'check_out_date' );
}
$adults = hb_get_request( 'adults', 0 );
$max_child = hb_get_request( 'max_child', 0 );
$uniqid = uniqid();

?>
<div id="hotel-booking-search-<?php echo uniqid(); ?>" class="hotel-booking-search">
<?php
    // display title widget or shortcode
    $atts = array();
    if( $args && isset($args['atts']) )
        $atts = $args['atts'];
    if ( !isset($atts['show_title']) || strtolower($atts['show_title']) === 'true' ):
?>
<?php endif; ?>
    <form name="hb-search-form" action="<?php echo esc_attr( $search_page ); ?>" class="hb-search-form-<?php echo esc_attr( $uniqid ) ?>">
        <ul class="hb-form-table">
            <li class="hb-form-field">
                <?php 
                $current_date = current_time( 'timestamp', 1 );
                ?>
                <?php hb_render_label_shortcode( $atts, 'show_label', esc_html__( 'Arrival Date', 'solaz' ), 'true'); ?>
        
                <div class="hb-form-field-input hb_input_field">
                    <div class="date choosing-block">
                        <span class="month"><?php echo esc_html(date( 'M', $current_date)); ?></span>
                        <h2 class="day"><?php echo esc_html(date( 'd', $current_date)); ?></h2>
                        <a href="#" class="next-day btn_prev"><i class="icon-12" aria-hidden="true"></i></a>
                        <a href="#" class="previous-day  btn_next"><i class="icon-12" aria-hidden="true"></i></a>                        
                        <input type="text" name="check_in_date" id="check_in_date_<?php echo esc_attr( $uniqid ) ?>" class="hb_input_date_check" value="<?php if ( is_page( 'Hotel Booking Search' )){echo esc_attr__('Arrival Date','solaz'); } else {echo esc_attr( $check_in_date );} ?>" placeholder="<?php echo esc_attr(date( 'Y-m-d H:i:s', $current_date)); ?>" />
                    </div>                                     
                </div>

            </li>

            <li class="hb-form-field">
                <?php hb_render_label_shortcode( $atts, 'show_label', esc_html__( 'Departure Date', 'solaz' ), 'true'); ?>
                <div class="hb-form-field-input hb_input_field">
                    <div class="date choosing-block checkout">
                        <span class="month checkout"></span>
                        <h2 class="day checkout"></h2>
                        <a href="#" class="next-day btn_prev checkout"><i class="icon-12" aria-hidden="true"></i></a>
                        <a href="#" class="previous-day btn_next checkout"><i class="icon-12" aria-hidden="true"></i></a>                        
                        <input type="text" name="check_out_date" id="check_out_date_<?php echo esc_attr( $uniqid ) ?>" class="hb_input_date_check" value="<?php if ( is_page( 'Hotel Booking Search' )){echo esc_html_e( 'Departure Date', 'solaz'); }else {echo esc_attr( $check_out_date );} ?>" placeholder="<?php esc_html_e( 'Departure Date', 'solaz' ); ?>" />
                    </div>                                     
                </div>
            </li>
            <li class="hb-form-field smaller_width display_i_widget">
                <?php hb_render_label_shortcode( $atts, 'show_label',  esc_html__( 'Adults', 'solaz' ), 'true' ); ?>
                <div class="hb-form-field-input">
                    <div class="choosing-block choosing-block-adults">
                        <?php
                        hb_dropdown_numbers(
                            array(
                                'name'      => 'adults_capacity',
                                'min'       => 1,
                                'class'    => 'select_slider',
                                'max'       => hb_get_max_capacity_of_rooms(),
                                'selected'  => $adults,
                                'option_none_value' => 0,
                                'options'   => hb_get_capacity_of_rooms()
                            )
                        );
                        ?> 
                        <a href="#" class="next_adults btn_prev"><i class="icon-12" aria-hidden="true"></i></a>
                        <a href="#" class="prev_adults btn_next"><i class="icon-12" aria-hidden="true"></i></a>                              
                    </div>   
                </div>
            </li>
            <li class="hb-form-field smaller_width">
                <?php hb_render_label_shortcode( $atts, 'show_label', esc_html__( 'Children', 'solaz' ), 'true'); ?>
                <div class="hb-form-field-input">
                    <div class="choosing-block choosing-block-child">
                        <?php
                        hb_dropdown_numbers(
                            array(
                                'class'    => 'select_slider',
                                'name'      => 'max_child',
                                'min'   => 0,
                                'max'   => hb_get_max_child_of_rooms(),
                                //'show_option_none'  => 0,
                                'option_none_value' => 0,
                                'selected'  => $max_child
                            )
                        );
                        ?>
                        <a href="#" class="next_child btn_prev"><i class="icon-12" aria-hidden="true"></i></a>
                        <a href="#" class="prev_child btn_next"><i class="icon-12" aria-hidden="true"></i></a>                               
                    </div>                              
                </div>
            </li>
        </ul>
        <?php wp_nonce_field( 'hb_search_nonce_action', 'nonce' ); ?>
        <input type="hidden" name="hotel-booking" value="results" />
        <input type="hidden" name="action" value="hotel_booking_parse_search_params" />
        <p class="hb-submit">
            <span><?php echo esc_html__('Reservation assistance available 24 hours','solaz');?></span>
           <button type="submit"> <i class="icon-arrow-right"></i><span><?php esc_html_e( ' Book Room', 'solaz' ); ?></span></button>
        </p>
    </form>
</div>