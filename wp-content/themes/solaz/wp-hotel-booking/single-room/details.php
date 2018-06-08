<?php
    if ( ! defined( 'ABSPATH' ) ) {
        exit();
    }

    $room = WPHB_Room::instance(get_the_ID());
    ob_start();
    the_content();
    $content = ob_get_clean();

    $tabsInfo = array();
    $tabsInfo[] = array(
            'id'        => 'hb_room_description',
            'title'     => esc_html__( '', 'solaz' ),
            'content'   => $content
        );
    //$tabsInfo[] = array(
            //'id'        => 'hb_room_additinal',
            //'title'     => esc_html__( 'Additional Information', 'solaz' ),
           // 'content'   => $room->addition_information
        //);
    $tabs = apply_filters( 'hotel_booking_single_room_infomation_tabs', $tabsInfo );
    // prepend after li tabs single
    do_action( 'hotel_booking_before_single_room_infomation' );
?>
        <div class="hb_single_room_details">
            <?php
            // append after li tabs single
            do_action( 'hotel_booking_after_single_room_infomation' ); ?>

            <div class="hb_single_room_content text-center">

                <?php foreach ( $tabs as $key => $tab ): ?>
                    <div class="<?php echo $tab['id'];?>">
                        <div class="title-single-room text-center">
                            <i class="icon-8 main-color"></i>
                            <h3>
                            <?php do_action('hotel_booking_single_room_before_tabs_' . $tab['id']); ?>
                                <?php printf( '%s', $tab['title'] ) ?>
                            <?php do_action('hotel_booking_single_room_after_tabs_' . $tab['id']); ?>
                            </h3>
                        </div>
                        <div id="<?php echo esc_attr( $tab['id'] ) ?>" class="hb_single_room_details">
                            <?php do_action( 'hotel_booking_single_room_before_tabs_content_' . $tab['id'] );  ?>

                            <?php printf( '%s', $tab['content'] ); ?>

                            <?php do_action( 'hotel_booking_single_room_after_tabs_content_' . $tab['id'] );  ?>
                        </div>
                    </div>    

                <?php endforeach; ?>
            </div>

        </div>   
