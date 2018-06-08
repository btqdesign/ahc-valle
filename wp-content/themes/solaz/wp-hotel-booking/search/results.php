<?php

if ( !defined( 'ABSPATH' ) ) {
	exit();
}

do_action( 'hb_before_search_result' );
?>
<?php
global $hb_search_rooms;
?>
<div id="hotel-booking-results">
	<?php if ( $results && !empty( $hb_search_rooms['data'] ) ): ?>
        <h2 class="title-cart"><?php esc_html_e( 'Search results', 'solaz' ); ?></h2>
		<?php hb_get_template( 'search/list.php', array( 'results' => $hb_search_rooms['data'], 'atts' => $atts ) ); ?>
        <nav class="rooms-pagination">
			<?php
			echo paginate_links( apply_filters( 'hb_pagination_args', array(
				'base'      => add_query_arg( 'hb_page', '%#%' ),
				'format'    => '',
				'prev_text' => esc_html__( 'Previous', 'solaz' ),
				'next_text' => esc_html__( 'Next', 'solaz' ),
				'total'     => $hb_search_rooms['max_num_pages'],
				'current'   => $hb_search_rooms['page'],
				'type'      => 'list',
				'end_size'  => 3,
				'mid_size'  => 3
			) ) );
			?>
        </nav>
	<?php else: ?>
        <p><?php esc_html_e( 'No room found.', 'solaz' ); ?></p>
        <p>
            <a href="<?php echo hb_get_url(); ?>"><?php esc_html_e( 'Search again!', 'solaz' ); ?></a>
        </p>
	<?php endif; ?>
</div>
