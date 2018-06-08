<?php
/**
 * Other room - Show related room for single pages.
 *
 * @author 		ThimPress
 * @package 	wp-hotel-booking/Templates
 * @version     1.1.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$room = WPHB_Room::instance( get_the_ID() );
$related = $room->get_related_rooms();
$sliderId = 'hotel_booking_slider_'.uniqid();
?>
<div class="related_rooms">
<div class="container">
	<div class="row">
<?php if( $related->posts ): ?>
	<div id="<?php echo esc_attr( $sliderId ); ?>" class="hb_room_carousel_container tp-hotel-booking">
		<div class="title-single-room text-center">
            <i class="icon-8 main-color"></i>
            <h3 class="title"><?php esc_html_e( 'Other Rooms', 'solaz' ); ?></h3>
        </div>
		<?php if ( count( $related->posts ) > 3 ) : ?>
			<div class="navigation owl-buttons">
                <div class="prev"><span class="icon-9"></span></div>
                <div class="next"><span class="icon-9"></span></div>
            </div>
    	<?php endif; ?>
        <div class="text_link"><a href="<?php echo get_post_type_archive_link('hb_room'); ?>"><?php esc_html_e( 'All Rooms', 'solaz' ); ?></a></div>
    	<div class="hb_room_carousel">
		<?php hotel_booking_room_loop_start(); ?>

			<?php while ( $related->have_posts() ) : $related->the_post(); ?>

				<?php hb_get_template_part( 'content', 'room' ); ?>

			<?php endwhile; // end of the loop. ?>

		<?php hotel_booking_room_loop_end(); ?>
		</div>
	</div>

	<script type="text/javascript">
                (function($){
                    "use strict";
                    $(document).ready(room_carousel);
                    $(document).resize(room_carousel);
                    function room_carousel() {
                        var arrowpress_hotel_booking_carousel = $('#<?php echo esc_js( $sliderId ) ?> .hb_room_carousel .rooms');
                        var width = $( window ).width();
                        
                        arrowpress_hotel_booking_carousel.slick({
                            <?php if(is_rtl()) :?>
                            rtl: true,
                            <?php endif;?>
                            slidesToShow: 3,
                            nextArrow: '#<?php echo esc_js( $sliderId ); ?> .navigation .next',
                            prevArrow: '#<?php echo esc_js( $sliderId ); ?> .navigation .prev',
                            dots:false,
                            slidesToScroll: 1,
                            arrows: <?php echo esc_js( ( ! isset($atts['navigation']) || $atts['navigation'] ) ? 'true' : 'false' )  ?>,
                            responsive: [
                            {
                              breakpoint: 769,
                              settings: {
                                slidesToShow: 2,
                              }
                            },
                            {
                              breakpoint: 480,
                              settings: {
                                slidesToShow: 1,
                              }
                            } ]                           
                        });
                    }

                })(jQuery);
            </script>
<?php endif; ?>
	</div>
</div>	
</div>
