<?php
/**
 * The template for displaying room content in the single-room.php template
 *
 * Override this template by copying it to yourtheme/tp-hotel-booking/content-single-room.php
 *
 * @author 		ThimPress
 * @package 	wp-hotel-booking/templates
 * @version     1.1.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<div id="room-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
		/**
		 * hotel_booking_before_loop_room_summary hook
		 *
		 * @hooked hotel_booking_show_room_sale_flash - 10
		 * @hooked hotel_booking_show_room_images - 20
		 */
		do_action( 'hotel_booking_before_loop_room_item' );
		global $hb_room;
		?>

	<div class="summary entry-summary">
		<a class="grouped_elements" href="<?php the_post_thumbnail_url('solaz-blog-detail'); ?>"><i class="icon-eye"></i></a>

		<?php

			/**
			 * hotel_booking_loop_room_thumbnail hook
			 */
			do_action( 'hotel_booking_loop_room_thumbnail' );
			
		?>
		<div class="room-info">
			<?php 
				/**
				 * hotel_booking_loop_room_title hook
				 */
				do_action( 'hotel_booking_loop_room_title' );
			    $room = WPHB_Room::instance(get_the_ID());
				echo '<p>'.esc_html($room->addition_information).'</p>';
				/**
				 * hotel_booking_loop_room_price hook
				 */
				do_action( 'hotel_booking_loop_room_price' );
				
				/**
				 * hotel_booking_loop_room_price hook
				 */
				do_action( 'hotel_booking_loop_room_rating' );
			?>
		</div>
	</div><!-- .summary -->

	<?php
		/**
		 * hotel_booking_after_loop_room_item hook
		 *
		 * @hooked hotel_booking_show_room_sale_flash - 10
		 * @hooked hotel_booking_show_room_images - 20
		 */
		do_action( 'hotel_booking_after_loop_room_item' );
	?>

</div>

<?php do_action( 'hotel_booking_after_loop_room' ); ?>
