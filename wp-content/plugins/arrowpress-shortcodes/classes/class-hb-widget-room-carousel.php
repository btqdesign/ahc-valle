<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
/**
 * Class WPHB_Widget_Room_Carousel
 *
 * Display form for search rooms
 * @extends WP_Widget
 */
class ArrowPress_Override_Widget_Room_Carousel extends WP_Widget{
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct(
            'hb_widget_carousel', // widget base id
            __( 'HB Rooms Carousel', 'arrowpress-shortcodes' ), // name of widget
            array( 'description' => __( "Display rooms slider", 'arrowpress-shortcodes' ) ) // description widget
        );
    }

    /**
     * Display the search form in widget
     *
     * @param array $args
     * @param array $instance
     * @return void
     */
    public function widget( $args, $instance )
    {
        echo sprintf( '%s', $args['before_widget'] );
        $html = array();
        $number_rooms = isset( $atts['rooms'] ) ? (int) $atts['rooms'] : 10;

        if( $instance )
        {?>
            <?php

            $q_args = array(
                'post_type' => 'hb_room',
                'posts_per_page' => $number_rooms,
                'orderby' => 'date',
                'order' => 'DESC',
                    // 'meta_key'          => '_hb_gallery'
            );
            if (isset($instance['room_type']) && $instance['room_type'] != ''){
                $catArray = explode(',', $instance['room_type']);
                $args['tax_query'] = array(
                    array(
                        'taxonomy' => 'hb_room_type',
                        'field'    => 'slug',
                        'terms'    => $catArray,
                    ),
                );
            }
            $query = new WP_Query( $q_args );
            $sliderId = 'hotel_booking_slider_'.uniqid();
            $items = isset($instance['number']) ? (int)$instance['number'] : 4;
            $row_number = isset($instance['row_number']) ? (int)$instance['row_number'] : 1;
            ?>
            <div id="<?php echo esc_attr( $sliderId ); ?>" class="hb_room_carousel_container tp-hotel-booking">
                <?php if( isset($atts['title']) && $atts['title'] ): ?>
                    <h3><?php echo esc_html( $atts['title']  ); ?></h3>
                <?php endif; ?>
                <!--navigation-->
                <?php if( ( ! isset($atts['navigation']) || $atts['navigation'] ) && count( $query->posts ) > $items ): ?>
                    <div class="navigation owl-buttons">
                        <div class="prev"><span class="icon-9"></span></div>
                        <div class="next"><span class="icon-9"></span></div>
                    </div>
                <?php endif; ?>
                <?php if( isset($instance['text_link']) && $instance['text_link'] !== '' ): ?>
                    <div class="text_link"><a href="<?php echo get_post_type_archive_link('hb_room'); ?>"><?php echo esc_html( $instance['text_link'] ); ?></a></div>
                <?php endif; ?>
                <div class="hb_room_carousel">
                    <?php hotel_booking_room_loop_start(); ?>

                    <?php while ( $query->have_posts() ) : $query->the_post(); ?>

                        <?php hb_get_template_part( 'content', 'room' ); ?>

                    <?php endwhile; // end of the loop. ?>

                <?php hotel_booking_room_loop_end(); ?>
                    <?php wp_reset_postdata(); ?>
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
                        if(width >= 992){
                            arrowpress_hotel_booking_carousel.slick({
                                <?php if(is_rtl()) :?>
                                rtl: true,
                                <?php endif;?>
                                <?php if( $row_number != 1 && $row_number != ''):?>
                                 slidesPerRow: <?php echo esc_js( $items ); ?>,
                                 rows: <?php echo esc_js( $row_number ); ?>,
                                <?php else:?>
                                 slidesToShow: <?php echo esc_js( $items ); ?>,
                                 
                                <?php endif;?>
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
                                    slidesToScroll: 2,
                                  }
                                },
                                {
                                  breakpoint: 480,
                                  settings: {
                                    slidesToShow: 1,
                                    slidesToScroll: 1,
                                  }
                                } ]                           
                            });
                        }else{
                            arrowpress_hotel_booking_carousel.slick({
                                
                                <?php if(is_rtl()) :?>
                                rtl: true,
                                <?php endif;?>
                                slidesToShow: <?php echo esc_js( $items ); ?>,
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
                    }

                })(jQuery);
            </script>
        <?php }
        // echo do_shortcode( implode(' ', $html) );
        echo sprintf( '%s', $args['after_widget'] );
    }

    /**
     * Widget options
     * @param $instance
     */
    public function form( $instance )
    {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : '';
        $rooms = ! empty( $instance['rooms'] ) ? $instance['rooms'] : 10;
        $number = ! empty( $instance['number'] ) ? $instance['number'] : 4;
        $thumb = ! empty( $instance['image_size'] ) ? $instance['image_size'] : 'thumbnail';
        $text_link = ! empty( $instance['text_link'] ) ? $instance['text_link'] : '';
        $room_type = ! empty( $instance['room_type'] ) ? $instance['room_type'] : '';
        $price = isset($instance['price']) ? $instance['price'] : 'min';
        $row_number = ! empty( $instance['row_number'] ) ? $instance['row_number'] : 1;
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:','arrowpress-shortcodes' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'rooms' ) ); ?>"><?php _e( 'Number of rooms to show:','arrowpress-shortcodes' ); ?></label>
            <input id="<?php echo esc_attr( $this->get_field_id( 'rooms' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'rooms' ) ); ?>" type="number" value="<?php echo esc_attr( $rooms ); ?>" min="1">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php _e( 'Number of items:','arrowpress-shortcodes' ); ?></label>
            <input id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="number" value="<?php echo esc_attr( $number ); ?>" min="1">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'row_number' ) ); ?>"><?php _e( 'Number of rows:','arrowpress-shortcodes' ); ?></label>
            <input id="<?php echo esc_attr( $this->get_field_id( 'row_number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'row_number' ) ); ?>" type="number" value="<?php echo esc_attr( $row_number ); ?>" min="1">
        </p>
        <p>
            <label><?php _e( 'Navigation:','arrowpress-shortcodes' ); ?></label>
            <input id="<?php echo esc_attr( $this->get_field_id( 'nav' ) ); ?>1" name="<?php echo esc_attr( $this->get_field_name( 'nav' ) ); ?>" type="radio" value="1"<?php echo sprintf( '%s', (!isset($instance['nav']) || $instance['nav']) ? 'checked' : '' ); ?>>
            <label for="<?php echo esc_attr( $this->get_field_id( 'nav' ) ); ?>1"><?php _e('Yes', 'arrowpress-shortcodes') ?></label>
            <input id="<?php echo esc_attr( $this->get_field_id( 'nav' ) ); ?>0" name="<?php echo esc_attr( $this->get_field_name( 'nav' ) ); ?>" type="radio" value="0"<?php echo sprintf( '%s', (isset($instance['nav']) && !$instance['nav']) ? 'checked' : '' ); ?>>
            <label for="<?php echo esc_attr( $this->get_field_id( 'nav' ) ); ?>0"><?php _e('No', 'arrowpress-shortcodes') ?></label>
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'text_link' ) ); ?>"><?php _e('Text Link', 'arrowpress-shortcodes') ?></label>
            <input id="<?php echo esc_attr( $this->get_field_id( 'text_link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text_link' ) ); ?>" type="text" value="<?php echo esc_attr($text_link); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'room_type' ) ); ?>"><?php _e('Enter room type slug', 'arrowpress-shortcodes') ?></label>
            <input id="<?php echo esc_attr( $this->get_field_id( 'room_type' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'room_type' ) ); ?>" type="text" value="<?php echo esc_attr($room_type); ?>">
        </p>
        <?php
    }

    /**
     * Handle update
     *
     * @param $new_instance
     * @param $old_instance
     * @return array
     */
    public function update( $new_instance, $old_instance )
    {
        $instance = array();
        // title
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

        // rooms
        $instance['rooms'] = ( ! empty( $new_instance['rooms'] ) ) ? strip_tags( $new_instance['rooms'] ) : 10;

        // number
        $instance['number'] = ( ! empty( $new_instance['number'] ) ) ? strip_tags( $new_instance['number'] ) : 4;
        // number
        $instance['row_number'] = ( ! empty( $new_instance['row_number'] ) ) ? strip_tags( $new_instance['row_number'] ) : 1;

        // text_link
        $instance['text_link'] = ( isset( $new_instance['text_link'] ) ) ? strip_tags( $new_instance['text_link'] ) : '';
        $instance['room_type'] = ( isset( $new_instance['room_type'] ) ) ? strip_tags( $new_instance['room_type'] ) : '';
        // image_size
        // $instance['image_size'] = ( isset( $new_instance['image_size'] ) ) ? strip_tags( $new_instance['image_size'] ) : 'thumbnail';

        // nav
        $instance['nav'] = ( isset( $new_instance['nav'] ) ) ? strip_tags( $new_instance['nav'] ) : 1;

        return $instance;
    }
}