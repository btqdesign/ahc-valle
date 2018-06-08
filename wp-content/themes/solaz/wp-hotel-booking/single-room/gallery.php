<?php
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/tp-hotel-booking/templates/single-product.php
 *
 * @author 		ThimPress
 * @package 	wp-hotel-booking/templates
 * @version     1.1.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $hb_room;
$galeries = $hb_room->get_galleries( false );
?>

<?php if( $galeries ): ?>
	<div class="hb_room_gallery clearfix">
		<?php foreach ( $galeries as $key => $gallery ): ?>
			<div class="gallery_room_details col-md-4 col-sm-6 col-xs-6 no-padding">
				<figure class="gallery-image">
					<div class="gallery-img">
						<?php 
							$attachment_id = get_post_thumbnail_id();
							$attachment_grid = solaz_get_attachment($attachment_id, 'solaz-gallery-grid'); 
							$attachment_grid_2 = solaz_get_attachment($attachment_id, 'solaz-blog-detail'); 
						?>
						<a class="fancybox" data-fancybox-group="gallery" href="<?php echo esc_url($gallery['src']) ?>" ><img src="<?php echo esc_url($gallery['src']); ?>" alt="img-room-details">
						</a>		
					</div>
				</figure>
			</div>	    
		<?php endforeach; ?>
	</div>
<?php endif; ?>