<?php    
//get search template
if ( ! function_exists( 'solaz_get_search_form' ) ) {
    function solaz_get_search_form() {
        $template = get_search_form(false);
        $header_type = solaz_get_header_type();    
        if(class_exists( 'WooCommerce' )) {
            $template = get_product_search_form(false);
        }
        $output = '';
        ob_start();
        ?>
                <span class="btn-search"><i class="pe-7s-search"></i></span>        
            <div class="top-search content-filter">
                <?php echo wp_kses($template,solaz_allow_html()); ?>
            </div>
        <?php
        $output .= ob_get_clean();
        return $output;
    }
}
//mini cart template
if ( class_exists( 'WooCommerce' ) ) {
    if ( ! function_exists ( 'solaz_get_minicart_template' ) ) {
        function solaz_get_minicart_template() {
            $cart_item_count = WC()->cart->cart_contents_count;
            $header_type = solaz_get_header_type();
            $output = '';
            ob_start();
            ?>

                    <a class="cart_label" href="#">
                        <i class="pe-7s-cart"></i>
                         <p class="cart_nu_count"><?php echo esc_html($cart_item_count);?></p>
                    </a>                 

                <div class="cart-block content-filter">
                    <div class="minicart_header">
                        <a class="cart_label close_mini_special">
                            <i class="pe-7s-cart"></i>
                            <p class="cart_count"><?php echo esc_html($cart_item_count);?></p>
                        </a> 
                        <div class="cart_header_info"> 
                        <h4><?php echo esc_html__("Shopping Cart","solaz");?></h4>
                        <p class="total"><span><?php echo esc_html__('Total', 'solaz'); ?>:</span> <span class="price"><?php echo WC()->cart->get_cart_subtotal(); ?></span></p>
                        </div>
                    </div>
                    <div class="widget_shopping_cart_content">
                    </div>
                </div>
            <?php
            $output .= ob_get_clean();
            return $output;
        }
    }
}

//hotel cart
if ( class_exists( 'TP_Hotel_Booking' ) ) {
    if ( ! function_exists ( 'solaz_room_minicart_template' ) ) {
        function solaz_room_minicart_template() {
            $cart_item_count = TP_Hotel_Booking::instance()->cart->cart_items_count;
            $header_type = solaz_get_header_type();
            $output = '';
            ob_start();
            ?>

                <a class="cart_label" href="#">
                    <i class="pe-7s-cart"></i>
                     <p class="cart_room_count"><?php echo esc_html($cart_item_count);?></p>
                </a>                 

                <div class="cart-block content-filter">
                    <div class="widget_room_cart_content">
                        <?php
                            $rooms = TP_Hotel_Booking::instance()->cart->get_rooms();
                        ?>
                        <?php if ( $rooms ): ?>

                            <?php foreach ( $rooms as $key => $room ): ?>

                                <?php if ( $cart_item = TP_Hotel_Booking::instance()->cart->get_cart_item( $key ) ) : ?>
                                    <?php hb_get_template( 'loop/mini-cart-loop.php', array( 'cart_id' => $key, 'room' => $room ) ); ?>
                                <?php endif; ?>

                            <?php endforeach; ?>

                            <div class="hb_mini_cart_footer">

                                <a href="<?php echo esc_url( hb_get_checkout_url() ); ?>" class="hb_button hb_checkout"><?php echo esc_html__( 'Check Out', 'solaz' ); ?></a>
                                <a href="<?php echo esc_url( hb_get_cart_url() ); ?>" class="hb_button hb_view_cart"><?php echo esc_html__( 'View Cart', 'solaz' ); ?></a>

                            </div>

                        <?php else: ?>

                            <p class="hb_mini_cart_empty"><?php echo esc_html__( 'Your cart is empty!', 'solaz' ); ?></p>

                        <?php endif; ?>
                    </div>
                </div>
            <?php
            $output .= ob_get_clean();
            return $output;
        }
    }
}

function solaz_shop_settings(){
    global $solaz_settings;
    if ( class_exists( 'WooCommerce' ) ) {
        $compare = false;
        if (class_exists('YITH_WOOCOMPARE')) {
            $compare = true;
        }
        $wishlist = false;
        if (class_exists('YITH_WCWL')) {
            $wishlist = true;
        }
        $myaccount_page_id = get_option('woocommerce_myaccount_page_id');
        $logout_url = wp_logout_url(get_permalink($myaccount_page_id));
        if (get_option('woocommerce_force_ssl_checkout') == 'yes') {
            $logout_url = str_replace('http:', 'https:', $logout_url);
        }
    $output = '';
    ob_start();
    ?>
    <div class="dib customlinks inline shop_settings">
        <a href="#" aria-expanded="false" aria-haspopup="true" data-toggle="dropdown">
            <i class="fa fa-bars" aria-hidden="true"></i>
        </a>
        <div class="dib header-profile dropdown-menu">
            <ul>
                <li><a href="<?php echo esc_url(get_permalink($myaccount_page_id)); ?>"><?php echo esc_html__('My Account', 'solaz') ?></a></li>
                <?php if ($wishlist && $solaz_settings['product-wishlist']): ?>
                    <li><a class="update-wishlist" href="<?php echo esc_url(YITH_WCWL()->get_wishlist_url()); ?>"><?php echo esc_html__('Wishlist', 'solaz') ?> <span>(<?php echo yith_wcwl_count_products(); ?>)</span></a></li>
                <?php endif; ?>
                <?php if (class_exists('YITH_WOOCOMPARE') && $solaz_settings['product-compare']) { ?>
                    <li>
                        <?php solaz_compare_toplink(); ?>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>

 <?php
        $output .= ob_get_clean();
        return $output;
    }
}
// top link myaccout
if ( ! function_exists ( 'solaz_myaccount_toplinks' ) ) {
function solaz_myaccount_toplinks() {
    $wishlist = false;
    global $solaz_settings;
    if(class_exists('YITH_WCWL')) {
        $wishlist = true;
    }
    $myaccount_page_id = get_option( 'woocommerce_myaccount_page_id' ); 
    $logout_url = wp_logout_url('my-account');
    $output = '';
    ob_start();
    ?>
    <ul>
        <li class="dib customlinks">
            <a class="current-open" href="javascript:void(0);">
                <i class="fa fa-gear"></i>
            </a>
            <div class="dib header-profile dropdown-menu content-filter">
                    <ul>
                        <li><a href="<?php echo get_permalink( $myaccount_page_id ); ?>"><?php echo esc_html__('My Account', 'solaz') ?></a></li>
                        <?php if($wishlist && $solaz_settings['product-wishlist']): ?>
                        <li><a class="update-wishlist" href="<?php echo esc_url(YITH_WCWL()->get_wishlist_url()); ?>"><?php echo esc_html__('Wishlist', 'solaz') ?> <span>(<?php echo yith_wcwl_count_products(); ?>)</span></a></li>
                        <?php endif; ?>
                        <?php if (class_exists( 'YITH_WOOCOMPARE' ) && $solaz_settings['product-compare'] ) :?>
                        <li>
                            <?php
                                solaz_compare_toplink();
                            ?>
                        </li>
                        <?php endif;?>
                        <?php if ( !is_user_logged_in() ) :?>
                        <li><a href="<?php echo esc_url(get_permalink( get_option('woocommerce_myaccount_page_id') )); ?>" title="<?php echo esc_attr__('Login / Register','solaz'); ?>"><?php echo esc_html__('Login / Register','solaz'); ?></a></li>
                        <?php else :?>
                        <li><a href="<?php echo esc_url($logout_url); ?>"><?php echo esc_html__('Logout', 'solaz') ?></a></li>
                        <?php endif; ?>
                    </ul>
            </div>
        </li>
    </ul>    
   <?php
   $output .= ob_get_clean();
    return $output;
}
}
function solaz_get_layout() {
    global $wp_query, $solaz_settings, $solaz_layout;
    $result = '';
    if (empty($solaz_layout)) {
        $result = isset($solaz_settings['layout']) ? $solaz_settings['layout'] : 'fullwidth';
        if (is_404()) {
            $result = 'fullwidth';
        } else if (is_category()) {
            $result = $solaz_settings['post-layout'];
        } else if (is_archive()) {
            if (function_exists('is_shop') && is_shop()) {
                $shop_layout = get_post_meta(wc_get_page_id('shop'), 'layout', true);
                $result = !empty($shop_layout) && $shop_layout != 'default' ? $shop_layout : $solaz_settings['shop-layout'];
            } else {
                if (is_post_type_archive('gallery')) {
                    $result = $solaz_settings['gallery-layout'];
                } 
                else if(is_post_type_archive('gallery')){
                    $result = $solaz_settings['gallery-layout']; 
                }
                else if(is_post_type_archive('pressmedia')){
                    $result = $solaz_settings['pressmedia-layout']; 
                }
                else if(is_post_type_archive('hb_room')){
                    $result = $solaz_settings['room-layout']; 
                }
                else {
                    $term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
                    if ($term) {
                        $tax_layout = get_metadata($term->taxonomy, $term->term_id, 'layout', true);
                        switch ($term->taxonomy) {
                            case 'product_cat':
                                if(!empty($tax_layout) && $tax_layout != 'default') {
                                    $result = $tax_layout;
                                } else {
                                    $result = $solaz_settings['shop-layout'];
                                }
                                break;
                            case 'product_tag':
                                $result = $solaz_settings['shop-layout'];
                                break;
                            case 'gallery_cat':
                                if(!empty($tax_layout) && $tax_layout != 'default') {
                                    $result = $tax_layout;
                                } else {
                                    $result = $solaz_settings['gallery-layout'];
                                }
                                break;
                            case 'gallery_cat':
                                $result = $solaz_settings['gallery-layout'];
                                break;
                            case 'pressmedia_cat':
                                $result = $solaz_settings['pressmedia-layout'];
                                break;        
                            case 'gallery':
                                $result = $solaz_settings['post-layout'];
                                break;
                            default:
                                $result = $solaz_settings['layout'];
                        }
                    }
                }
            }
        } else {
            if (is_singular()) {
                $single_layout = get_post_meta(get_the_id(), 'layout', true);
                if (!empty($single_layout) && $single_layout != 'default') {
                    $result = $single_layout;
                } else {
                    switch (get_post_type()) {
                        case 'gallery':
                            $result = $solaz_settings['gallery-layout'];
                            break;
                        case 'hb_room':
                            $result = $solaz_settings['single-room-layout'];
                            break;
                        case 'pressmedia':
                            $result = $solaz_settings['pressmedia-layout'];
                            break;
                        case 'product':
                            $result = $solaz_settings['single-product-layout'];
                            break;
                        case 'post':
                            $result = $solaz_settings['post-layout'];
                            break;
                        default:
                            $result = $solaz_settings['layout'];
                    }
                }
            } else {
                if (is_home() && !is_front_page()) {
                    $result = $solaz_settings['post-layout'];
                }
            }
        }
        $solaz_layout = $result;
    }    
    return $solaz_layout;
}
//get global sidebar position
function solaz_get_sidebar_position() {
    $result = '';
    global $wp_query, $solaz_settings, $solaz_sidebar_pos;
    if(empty($solaz_sidebar_pos)){
        $result = isset($solaz_settings['sidebar-position']) ? $solaz_settings['sidebar-position'] : 'none';
        if (is_404()) {
            $result = 'none';
        } else if (is_category()) {
            $cat = $wp_query->get_queried_object();
            $cat_sidebar = get_metadata('category', $cat->term_id, 'sidebar_position', true);
            if (!empty($cat_sidebar) && $cat_sidebar != 'default') {
                    $result = $cat_sidebar;
                }
            else{   
                $result = $solaz_settings['post-sidebar-position'];
            }
        } else if (is_archive()) {
            if (function_exists('is_shop') && is_shop()) {
                $shop_sidebar_position = get_post_meta(wc_get_page_id('shop'), 'sidebar_position', true);
                $result = !empty($shop_sidebar_position) && $shop_sidebar_position != 'default' ? $shop_sidebar_position : $solaz_settings['shop-sidebar-position'];
            } else {
                if (is_post_type_archive('gallery')) {
                    if(isset($solaz_settings['gallery-sidebar-position'])){
                        $result = $solaz_settings['gallery-sidebar-position'];
                    }else{
                        $result = $solaz_settings['sidebar-position'];
                    }
                }else if(is_post_type_archive('gallery')){
                    if(isset($solaz_settings['gallery-sidebar-position'])){
                        $result = $solaz_settings['gallery-sidebar-position'];                        
                    }else{
                        $result = $solaz_settings['sidebar-position'];
                    }
                }else if(is_post_type_archive('pressmedia')){
                    if(isset($solaz_settings['press-sidebar-position'])){
                        $result = $solaz_settings['press-sidebar-position'];                        
                    }else{
                        $result = $solaz_settings['sidebar-position'];
                    }
                }
                else {
                    $term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
                    if ($term) {
                        $tax_sidebar_pos = get_metadata($term->taxonomy, $term->term_id, 'sidebar_position', true);
                        switch ($term->taxonomy) {
                            case 'product_cat':
                                if(!empty($tax_sidebar_pos) && $tax_sidebar_pos != 'default') {
                                    $result = $tax_sidebar_pos;
                                } else {
                                    $result = $solaz_settings['shop-sidebar-position'];
                                }
                                break;
                            case 'product_tag':
                                $result = $solaz_settings['shop-sidebar-position'];
                                break;
                            case 'gallery_cat':
                                $result = $solaz_settings['gallery-sidebar-position'];
                                break;
                            case 'gallery_cat':
                                $result = $solaz_settings['gallery-sidebar-position'];
                                break;
                            case 'pressmedia_cat':
                                $result = $solaz_settings['press-sidebar-position'];
                                break;
                            case 'gallery_tag':
                                $result = $solaz_settings['gallery-sidebar-position'];
                                break;
                            case 'category':
                                if(!empty($tax_sidebar_pos) && $tax_sidebar_pos != 'default') {
                                    $result = $tax_sidebar_pos;
                                } else {
                                    $result = $solaz_settings['post-sidebar-position'];
                                }
                                break;
                            case 'tag':
                                    $result = $solaz_settings['post-sidebar-position'];
                                break; 
                            default:
                                $result = $solaz_settings['sidebar-position'];
                        }
                    }
                }
            }
        } else {
            if (is_singular()) {
                $single_sidebar_position = get_post_meta(get_the_id(), 'sidebar_position', true);
                if (!empty($single_sidebar_position) && $single_sidebar_position != 'default') {
                    $result = $single_sidebar_position;
                } else {
                    switch (get_post_type()) {
                        case 'gallery':
                            $result = $solaz_settings['gallery-sidebar-position'];
                            break;
                        case 'product':
                            $result = $solaz_settings['single-product-sidebar-position'];
                            break;
                        case 'gallery':
                            if(isset($solaz_settings['gallery-sidebar-position'])){
                                $result = $solaz_settings['gallery-sidebar-position'];
                            }else{
                                $result = $solaz_settings['sidebar-position'];
                            }
                            break;
                        case 'pressmedia':
                            if(isset($solaz_settings['press-sidebar-position'])){
                                $result = $solaz_settings['press-sidebar-position'];
                            }else{
                                $result = $solaz_settings['sidebar-position'];
                            }
                            break;    
                        case 'post':
                            $result = $solaz_settings['post-sidebar-position'];
                            break;
                        default:
                            $result = $solaz_settings['sidebar-position'];
                    }
                }
            } else {
                if (is_home() && !is_front_page()) {
                    $result = $solaz_settings['post-sidebar-position'];
                }
            }
        }
        $solaz_sidebar_pos = $result;
    }
    return $solaz_sidebar_pos;
}

//get global sidebar
function solaz_get_sidebar() {
    $result = '';
    global $wp_query, $solaz_settings, $solaz_sidebar;
    if(empty($solaz_sidebar)){
        $result = isset($solaz_settings['sidebar']) ? $solaz_settings['sidebar'] : 'none';
        if (is_404()) {
            $result = 'none';
        } else if (is_category()) {
            $cat = $wp_query->get_queried_object();
            $cat_sidebar = get_metadata('category', $cat->term_id, 'sidebar', true);
            if (!empty($cat_sidebar) && $cat_sidebar != 'default') {
                    $result = $cat_sidebar;
                }
            else{   
                $result = $solaz_settings['post-sidebar'];
            }
        } else if (is_archive()) {
            if (function_exists('is_shop') && is_shop()) {
                $shop_sidebar = get_post_meta(wc_get_page_id('shop'), 'sidebar', true);
                $result = !empty($shop_sidebar) && $shop_sidebar != 'default' ? $shop_sidebar : $solaz_settings['shop-sidebar'];
            } else {
                if (is_post_type_archive('gallery')) {
                    if(isset($solaz_settings['gallery-sidebar'])){
                        $result = $solaz_settings['gallery-sidebar'];  
                    }else{
                        $result = $solaz_settings['sidebar']; 
                    }  
                } else if(is_post_type_archive('gallery')){
                    if(isset($solaz_settings['gallery-sidebar'])){
                        $result = $solaz_settings['gallery-sidebar'];  
                    }else{
                        $result = $solaz_settings['sidebar']; 
                    }  
                } else if(is_post_type_archive('pressmedia')){
                    if(isset($solaz_settings['press-sidebar'])){
                        $result = $solaz_settings['press-sidebar'];  
                    }else{
                        $result = $solaz_settings['sidebar']; 
                    }  
                } else {
                    $term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
                    if ($term) {
                        $tax_sidebar = get_metadata($term->taxonomy, $term->term_id, 'sidebar', true);
                        switch ($term->taxonomy) {
                            case 'product_cat':
                                if(!empty($tax_sidebar) && $tax_sidebar != 'default') {
                                    $result = $tax_sidebar;
                                } else {
                                    $result = $solaz_settings['shop-sidebar'];
                                }
                                break;
                            case 'product_tag':
                                $result = $solaz_settings['shop-sidebar'];
                                break;
                            case 'gallery_cat':
                                if(isset($solaz_settings['gallery-sidebar'])){
                                    $result = $solaz_settings['gallery-sidebar'];
                                }else{
                                    $result = $solaz_settings['sidebar'];
                                }
                                break;
                            case 'gallery_cat':
                                if(isset($solaz_settings['gallery-sidebar'])){
                                    $result = $solaz_settings['gallery-sidebar'];
                                }else{
                                    $result = $solaz_settings['sidebar'];
                                }
                                break;
                            case 'pressmedia_cat':
                                if(isset($solaz_settings['press-sidebar'])){
                                    $result = $solaz_settings['press-sidebar'];
                                }else{
                                    $result = $solaz_settings['sidebar'];
                                }
                                break;    
                            case 'gallery_tag':
                                if(isset($solaz_settings['gallery-sidebar'])){
                                    $result = $solaz_settings['gallery-sidebar'];
                                }else{
                                    $result = $solaz_settings['sidebar'];
                                }
                                break;
                            case 'category':
                                if(!empty($tax_sidebar) && $tax_sidebar != 'default') {
                                    $result = $tax_sidebar;
                                } else {
                                    $result = $solaz_settings['post-sidebar'];
                                }
                                break;
                            case 'tag':
                                $result = $solaz_settings['post-sidebar'];
                                break; 
                            default:
                                $result = $solaz_settings['sidebar'];
                        }
                    }
                }
            }
        } else {
            if (is_singular()) {
                $single_sidebar = get_post_meta(get_the_id(), 'sidebar', true);
                if (!empty($single_sidebar) && $single_sidebar != 'default') {
                    $result = $single_sidebar;
                } else {
                    switch (get_post_type()) {
                        case 'gallery':
                            $result = $solaz_settings['gallery-sidebar'];
                            break;
                        case 'product':
                            $result = $solaz_settings['single-product-sidebar'];
                            break;
                        case 'gallery':
                            $result = $solaz_settings['gallery-sidebar'];
                            break;
                        case 'pressmedia':
                            $result = $solaz_settings['press-sidebar'];
                            break;    
                        case 'post':
                            $result = $solaz_settings['post-sidebar'];
                            break;
                        default:
                            $result = $solaz_settings['sidebar'];
                    }
                }
            } else {
                if (is_home() && !is_front_page()) {
                    $result = $solaz_settings['post-sidebar'];
                }
            }
        }
        $solaz_sidebar = $result;
    } 
    return $solaz_sidebar;   
}
function solaz_get_sidebar_left() {
    $result = '';
    global $wp_query, $solaz_settings, $solaz_sidebar_left;

    if (empty($solaz_sidebar_left)) {
        $result = isset($solaz_settings['left-sidebar']) ? $solaz_settings['left-sidebar'] : '';
        if (is_404()) {
            $result = '';
        } else if (is_category()) {
            $cat = $wp_query->get_queried_object();
            $cat_sidebar = get_metadata('category', $cat->term_id, 'left-sidebar', true);
            if (!empty($cat_sidebar) && $cat_sidebar != 'default') {
                $result = $cat_sidebar;
            }else if($cat_sidebar =='none') {
                $result = "none";
            } else {
                $result = $solaz_settings['left-post-sidebar'];
            }
        }else if (is_tag()){
            $result = $solaz_settings['left-post-sidebar'];
        }
        else if (is_search()){
            $result = $solaz_settings['left-post-sidebar'];
        }
        else if (is_archive()) {
            if (function_exists('is_shop') && is_shop()) {
                $shop_sidebar = get_post_meta(wc_get_page_id('shop'), 'left-sidebar', true);
                $result = !empty($shop_sidebar) && $shop_sidebar != 'default' ? $shop_sidebar : $solaz_settings['left-shop-sidebar'];
            } else { 
                if (is_post_type_archive('gallery')) {
                    if(isset($solaz_settings['left-gallery-sidebar'])){
                        $result = $solaz_settings['left-gallery-sidebar'];  
                    }else{
                        $result = $solaz_settings['left-sidebar']; 
                    }  
                }           
                else if (is_post_type_archive('left-casestudy')) {
                    $result = $solaz_settings['left-casestudy-sidebar'];
                } else {
                    $term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
                    if ($term) {
                        $tax_sidebar = get_metadata($term->taxonomy, $term->term_id, 'left-sidebar', true);
                        switch ($term->taxonomy) {
                            case 'product_cat':
                                if (!empty($tax_sidebar) && $tax_sidebar != 'default') {
                                    $result = $tax_sidebar;
                                }else if($tax_sidebar =='none') {
                                    $result = "none";
                                } else {
                                    $result = $solaz_settings['left-shop-sidebar'];
                                }
                                break;
                            case 'gallery_cat':
                                if (!empty($tax_sidebar) && $tax_sidebar != 'default') {
                                    $result = $tax_sidebar;
                                } else if($tax_sidebar =='none') {
                                    $result = "none";
                                }else{
                                    $result = $solaz_settings['left-gallery-sidebar'];
                                }
                                break;
                            case 'product_tag':
                                $result = $solaz_settings['left-shop-sidebar'];
                                break;
                            case 'category':
                                if (!empty($tax_sidebar) && $tax_sidebar != 'default') {
                                    $result = $tax_sidebar;
                                } else {
                                    $result = $solaz_settings['left-post-sidebar'];
                                }
                                break;
                            case 'tag':
                                $result = $solaz_settings['left-post-sidebar'];
                                break;
                            default:
                                $result = $solaz_settings['left-sidebar'];
                        }
                    }
                }
            }
        } else if(function_exists('is_plugin_active') && is_plugin_active( 'bbpress/bbpress.php' ) && is_bbpress()){
            $result = $solaz_settings['left-bb-sidebar'];   
        } else {
            if (is_singular()) {
                $single_sidebar = get_post_meta(get_the_id(), 'left-sidebar', true);
                if (!empty($single_sidebar) && $single_sidebar != 'default') {
                    $result = $single_sidebar;
                }else if($single_sidebar =='none') {
                    $result = "none";
                } else {
                    switch (get_post_type()) {
                        case 'post':
                            $result = $solaz_settings['left-post-sidebar'];
                            break;
                        case 'gallery':
                            $result = $solaz_settings['left-gallery-sidebar'];
                            break;
                        case 'product':
                            $result = $solaz_settings['left-single-product-sidebar'];
                            break;    
                        default:
                            $result = $solaz_settings['left-sidebar'];
                    }
                }
            } else {
                if (is_home() && !is_front_page()) {
                    $result = $solaz_settings['left-post-sidebar'];
                }
            }
        }
        $solaz_sidebar_left = $result;
    }
    return $solaz_sidebar_left;
}

function solaz_get_sidebar_right() {
    $result = '';
    global $wp_query, $solaz_settings, $solaz_sidebar_right;

    if (empty($solaz_sidebar_right)) {
        $result = isset($solaz_settings['right-sidebar']) ? $solaz_settings['right-sidebar'] : 'none';
        if (is_404()) {
            $result = 'none';
        }else if (is_category()) {
            $cat = $wp_query->get_queried_object();
            $cat_sidebar = get_metadata('category', $cat->term_id, 'right-sidebar', true);
            if (!empty($cat_sidebar) && $cat_sidebar != 'default') {
                $result = $cat_sidebar;
            }else if($cat_sidebar =='none') {
                $result = "none";
            } else {
                $result = $solaz_settings['right-post-sidebar'];
            }
        }else if (is_tag()){
            $result = $solaz_settings['right-post-sidebar'];
        }
        else if (is_search()){
            $result = $solaz_settings['right-post-sidebar'];
        }
        else if (is_archive()) {
            if (function_exists('is_shop') && is_shop()) {
                $shop_sidebar = get_post_meta(wc_get_page_id('shop'), 'right-sidebar', true);
                $result = !empty($shop_sidebar) && $shop_sidebar != 'default' ? $shop_sidebar : $solaz_settings['right-shop-sidebar'];
            } else { 
                if (is_post_type_archive('gallery')) {
                    if(isset($solaz_settings['right-gallery-sidebar'])){
                        $result = $solaz_settings['right-gallery-sidebar'];  
                    }else{
                        $result = $solaz_settings['right-sidebar']; 
                    }  
                }           
                else if (is_post_type_archive('right-casestudy')) {
                    $result = $solaz_settings['right-casestudy-sidebar'];
                } else {
                    $term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
                    if ($term) {
                        $tax_sidebar = get_metadata($term->taxonomy, $term->term_id, 'right-sidebar', true);
                        switch ($term->taxonomy) {
                            case 'product_cat':
                                if (!empty($tax_sidebar) && $tax_sidebar != 'default') {
                                    $result = $tax_sidebar;
                                }else if($tax_sidebar =='none') {
                                    $result = "none";
                                } else {
                                    $result = $solaz_settings['right-shop-sidebar'];
                                }
                                break;
                            case 'gallery_cat':
                                if (!empty($tax_sidebar) && $tax_sidebar != 'default') {
                                    $result = $tax_sidebar;
                                }else if($tax_sidebar =='none') {
                                    $result = "none";
                                } else {
                                    $result = $solaz_settings['right-gallery-sidebar'];
                                }
                                break;
                            case 'product_tag':
                                $result = $solaz_settings['right-shop-sidebar'];
                                break;
                            case 'category':
                                if (!empty($tax_sidebar) && $tax_sidebar != 'default') {
                                    $result = $tax_sidebar;
                                }else if($tax_sidebar =='none') {
                                    $result = "none";
                                } else {
                                    $result = $solaz_settings['right-post-sidebar'];
                                }
                                break;
                            case 'tag':
                                $result = $solaz_settings['right-post-sidebar'];
                                break;
                            default:
                                $result = $solaz_settings['right-sidebar'];
                        }
                    }
                }
            }
        } else if(function_exists('is_plugin_active') && is_plugin_active( 'bbpress/bbpress.php' ) && is_bbpress()){
            $result = $solaz_settings['right-bb-sidebar'];   
        } else {
            if (is_singular()) {
                $single_sidebar = get_post_meta(get_the_id(), 'right-sidebar', true);
                if (!empty($single_sidebar) && $single_sidebar != 'default') {
                    $result = $single_sidebar;
                }else if($single_sidebar =='none') {
                    $result = "none";
                } else {
                    switch (get_post_type()) {
                        case 'post':
                            $result = $solaz_settings['right-post-sidebar'];
                            break;
                        case 'gallery':
                            $result = $solaz_settings['right-gallery-sidebar'];
                            break;
                        case 'product':
                            $result = $solaz_settings['right-single-product-sidebar'];
                            break;    
                        default:
                            $result = $solaz_settings['right-sidebar'];
                    }
                }
            } else {
                if (is_home() && !is_front_page()) {
                    $result = $solaz_settings['right-post-sidebar'];
                }
            }
        }
        $solaz_sidebar_right = $result;
    }
    return $solaz_sidebar_right;
}
function solaz_get_header_type() {
    $result = '';
    global $solaz_settings, $wp_query, $header_type;
    if (empty($header_type)) {
        $result = isset($solaz_settings['header-type']) ? $solaz_settings['header-type'] : 1;
        if (is_category()) {
            $cat = $wp_query->get_queried_object();
            $cat_layout = get_metadata('category', $cat->term_id, 'header', true);
            if (!empty($cat_layout) && $cat_layout != 'default') {
                    $result = $cat_layout;
                }
            else{   
                $result = $solaz_settings['header-type'];
            }
        } else if (is_archive()) {
            if (function_exists('is_shop') && is_shop()) {
                $shop_layout = get_post_meta(wc_get_page_id('shop'), 'header', true);
                if(!empty($shop_layout) && $shop_layout != 'default') {
                    $result = $shop_layout;
                }
            } 
        } else {
            if (is_singular()) {
                $single_layout = get_post_meta(get_the_id(), 'header', true);
                if (!empty($single_layout) && $single_layout != 'default') {
                    $result = $single_layout;
                }
            } else {
                if (!is_home() && is_front_page()) {
                    $result = $solaz_settings['header-type'];
                } else if (is_home() && !is_front_page()) {
                    $posts_page_id = get_option( 'page_for_posts' );
                    $posts_page_layout = get_post_meta($posts_page_id, 'header', true);
                    if (!empty($posts_page_layout) && $posts_page_layout != 'default') {
                        $result = $posts_page_layout;
                    }
                }
            }
        }
        $header_type = $result;
    }
    return $header_type;
}

function solaz_get_footer_type() {
    $result = '';
    global $solaz_settings, $wp_query, $footer_type;
    if(empty($footer_type)){
        $result = isset($solaz_settings['footer-type']) ? $solaz_settings['footer-type'] : 1;
        if (is_category()) {
            $cat = $wp_query->get_queried_object();
            $cat_layout = get_metadata('category', $cat->term_id, 'footer', true);
            if (!empty($cat_layout) && $cat_layout != 'default') {
                    $result = $cat_layout;
                }
            else{   
                $result = $solaz_settings['footer-type'];
            }
        } else if (is_archive()) {
            if (function_exists('is_shop') && is_shop()) {
                $shop_layout = get_post_meta(wc_get_page_id('shop'), 'footer', true);
                if(!empty($shop_layout) && $shop_layout != 'default') {
                    $result = $shop_layout;
                }
            }
        } else {
            if (is_singular()) {
                $single_layout = get_post_meta(get_the_id(), 'footer', true);
                if (!empty($single_layout) && $single_layout != 'default') {
                    $result = $single_layout;
                }
            } else {
                if (!is_home() && is_front_page()) {
                    $result = $solaz_settings['footer-type'];
                } else if (is_home() && !is_front_page()) {
                    $posts_page_id = get_option( 'page_for_posts' );
                    $posts_page_layout = get_post_meta($posts_page_id, 'footer', true);
                    if (!empty($posts_page_layout) && $posts_page_layout != 'default') {
                        $result = $posts_page_layout;
                    }
                }
            }
        }        
        $footer_type = $result;
    }  
    return $footer_type;  
}

//get search template
if ( ! function_exists ( 'solaz_breadcrumbs' ) ) {
function solaz_breadcrumbs() {
    global $post, $wp_query, $author, $solaz_settings;

    $prepend = '';
    $before = '<li>';
    $after = '</li>';
    $home = esc_html__('Home', 'solaz');

    $shop_page_id = false;
    $shop_page = false;
    $front_page_shop = false;
    if ( defined( 'WOOCOMMERCE_VERSION' ) ) {
        $permalinks   = get_option( 'woocommerce_permalinks' );
        $shop_page_id = wc_get_page_id( 'shop' );
        $shop_page    = get_post( $shop_page_id );
        $front_page_shop = get_option( 'page_on_front' ) == wc_get_page_id( 'shop' );
    }

    // If permalinks contain the shop page in the URI prepend the breadcrumb with shop
    if ( $shop_page_id && $shop_page && strstr( $permalinks['product_base'], '/' . $shop_page->post_name ) && get_option( 'page_on_front' ) != $shop_page_id ) {
        $prepend = $before . '<a href="' . esc_url(get_permalink( $shop_page )) . '">' . $shop_page->post_title . '</a> ' . $after;
    }

    if ( ( ! is_home() && ! is_front_page() && ! ( is_post_type_archive() && $front_page_shop ) ) || is_paged() ) {
        echo '<ul class="breadcrumb">';

        if ( ! empty( $home ) ) {
            echo wp_kses($before,array('li'=>array())) . '<a class="home" href="' . apply_filters( 'woocommerce_breadcrumb_home_url', home_url('/') ) . '">' . $home . '</a>' . $after;
        }

        if ( is_home() ) {

            echo wp_kses($before,array('li'=>array())) . single_post_title('', false) . $after;

        } else if ( is_category()) {

            if ( get_option( 'show_on_front' ) == 'page' ) {
                echo wp_kses($before,array('li'=>array())) . '<a href="' . esc_url(get_permalink( get_option('page_for_posts' ) )) . '">' . get_the_title( get_option('page_for_posts', true) ) . '</a>' . $after;
            }

            $cat_obj = $wp_query->get_queried_object();
            $this_category = get_category( $cat_obj->term_id );

            echo wp_kses($before,array('li'=>array())) . single_cat_title( '', false ) . $after;

        } elseif ( is_search() ) {

            echo wp_kses($before,array('li'=>array())) . esc_html__( 'Search results for &ldquo;', 'solaz' ) . get_search_query() . '&rdquo;' . $after;

        } elseif ( is_tax('product_cat') || is_tax('portfolio_cat')) {
            echo wp_kses($prepend, solaz_allow_html());
            if ( is_tax('portfolio_cat') ) {
                $post_type = get_post_type_object( 'portfolio' );
                echo wp_kses($before,array('li'=>array())) . '<a href="' . esc_url(get_post_type_archive_link( 'portfolio' )) . '">' . $post_type->labels->singular_name . '</a>' . $after;
            }
            $current_term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

            $ancestors = array_reverse( get_ancestors( $current_term->term_id, get_query_var( 'taxonomy' ) ) );

            foreach ( $ancestors as $ancestor ) {
                $ancestor = get_term( $ancestor, get_query_var( 'taxonomy' ) );

                echo wp_kses($before,array('li'=>array())) . '<a href="' . esc_url(get_term_link( $ancestor->slug, get_query_var( 'taxonomy' ) )) . '">' . esc_html( $ancestor->name ) . '</a>' . $after;
            }

            echo wp_kses($before,array('li'=>array())) . esc_html( $current_term->name ) . $after;

        } elseif ( is_tax('product_tag') ) {

            $queried_object = $wp_query->get_queried_object();
            echo wp_kses($prepend, solaz_allow_html()). wp_kses($before,array('li'=>array())) . ' ' . esc_html__( 'Products tagged &ldquo;', 'solaz' ) . $queried_object->name . '&rdquo;' . $after;

        } elseif ( is_tax('gallery_cat') ){
            if(is_tax('gallery_cat')){
                if(isset($solaz_settings['gallery_cat_slug'])){
                    $gallery_cat_slug = $solaz_settings['gallery_cat_slug'];
                }
                else {$gallery_cat_slug = "gallery_cat"; }                 
                echo wp_kses($prepend, solaz_allow_html());

                $current_term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

                $ancestors = array_reverse( get_ancestors( $current_term->term_id, get_query_var( 'taxonomy' ) ) );

                foreach ( $ancestors as $ancestor ) {
                    $ancestor = get_term( $ancestor, get_query_var( 'taxonomy' ) );

                    echo wp_kses($before,array('li'=>array())) . '<a href="' . esc_url(get_term_link( $ancestor->slug, get_query_var( 'taxonomy' ) )) . '">' . esc_html( $ancestor->name ) . '</a>' . $after;
                }

                echo wp_kses($before,array('li'=>array())) . esc_html( $current_term->name ) . $after;
            }else{
                $queried_object = $wp_query->get_queried_object();
                    echo wp_kses($prepend, solaz_allow_html()) . wp_kses($before,array('li'=>array())) . ' ' . esc_html__( 'Recipes tagged &ldquo;', 'solaz' ) . $queried_object->name . '&rdquo;' . $after;
            }
        } elseif( is_tax('kbe_tags')){
            $queried_object = $wp_query->get_queried_object();
            echo wp_kses($prepend, solaz_allow_html()) . wp_kses($before,array('li'=>array())) . ' ' . esc_html__( 'Knowledge tagged &ldquo;', 'solaz' ) . $queried_object->name . '&rdquo;' . $after;
        }  elseif ( is_tax('kbe_taxonomy')){

            echo wp_kses($prepend, solaz_allow_html());

            $current_term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

            $ancestors = array_reverse( get_ancestors( $current_term->term_id, get_query_var( 'taxonomy' ) ) );

            foreach ( $ancestors as $ancestor ) {
                $ancestor = get_term( $ancestor, get_query_var( 'taxonomy' ) );

                echo wp_kses($before,array('li'=>array())) . '<a href="' . esc_url(get_term_link( $ancestor->slug, get_query_var( 'taxonomy' ) )) . '">' . esc_html( $ancestor->name ) . '</a>' . $after;
            }

            echo wp_kses($before,array('li'=>array())) . esc_html( $current_term->name ) . $after;
        }elseif ( is_day() ) {

            echo wp_kses($before,array('li'=>array())) . '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a>' . $delimiter . $after;
            echo wp_kses($before,array('li'=>array())) . '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a>' . $after;
            echo wp_kses($before,array('li'=>array())) . get_the_time('d') . $after;

        } elseif ( is_month() ) {

            echo wp_kses($before,array('li'=>array())) . '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a>' . $after;
            echo wp_kses($before,array('li'=>array())) . get_the_time('F') . $after;

        } elseif ( is_year() ) {

            echo wp_kses($before,array('li'=>array())) . get_the_time('Y') . $after;

        } elseif ( is_post_type_archive('product') && get_option('page_on_front') !== $shop_page_id ) {

            $_name = wc_get_page_id( 'shop' ) ? get_the_title( wc_get_page_id( 'shop' ) ) : '';

            if ( ! $_name ) {
                $product_post_type = get_post_type_object( 'product' );
                $_name = $product_post_type->labels->singular_name;
            }

            if ( is_search() ) {

                echo wp_kses($before,array('li'=>array())) . '<a href="' . get_post_type_archive_link('product') . '">' . $_name . '</a>' . esc_html__( 'Search results for &ldquo;', 'solaz' ) . get_search_query() . '&rdquo;' . $after;

            } elseif ( is_paged() ) {

                echo wp_kses($before,array('li'=>array())) . '<a href="' . get_post_type_archive_link('product') . '">' . $_name . '</a>' . $after;

            } else {

                echo wp_kses($before,array('li'=>array())) . $_name . $after;

            }

        } else if(is_post_type_archive('gallery')){
            if(isset($solaz_settings['gallery-title']) && $solaz_settings['gallery-title'] !=""){
                $post_type = get_post_type_object( get_post_type() );
                $slug = $post_type->rewrite;
                echo wp_kses($before,array('li'=>array())) . '<a href="' . get_post_type_archive_link( get_post_type() ) . '">' .force_balance_tags($solaz_settings['gallery-title']). '</a>' . $after;
            }else{
                echo wp_kses($before,array('li'=>array())) . '<a href="' . get_post_type_archive_link() . '">' . esc_html__( 'Recipes', 'solaz' ) . '</a>' . $after;
            }

                
        } elseif ( is_single() && ! is_attachment() ) {

            if ( 'product' == get_post_type() ) {

                echo wp_kses($prepend, solaz_allow_html());

                if ( $terms = wc_get_product_terms( $post->ID, 'product_cat', array( 'orderby' => 'parent', 'order' => 'DESC' ) ) ) {
                    $main_term = $terms[0];
                    $ancestors = get_ancestors( $main_term->term_id, 'product_cat' );
                    $ancestors = array_reverse( $ancestors );

                    foreach ( $ancestors as $ancestor ) {
                        $ancestor = get_term( $ancestor, 'product_cat' );

                        if ( ! is_wp_error( $ancestor ) && $ancestor ) {
                            echo wp_kses($before,array('li'=>array())) . '<a href="' . get_term_link( $ancestor ) . '">' . $ancestor->name . '</a>' . $after;
                        }
                    }

                    echo wp_kses($before,array('li'=>array())) . '<a href="' . get_term_link( $main_term ) . '">' . $main_term->name . '</a>' . $after;

                }

                echo wp_kses($before,array('li'=>array())) . get_the_title() . $after;

            } elseif ( 'post' != get_post_type() ) {
                $post_type = get_post_type_object( get_post_type() );
                $slug = $post_type->rewrite;
                echo wp_kses($before,array('li'=>array())) . '<a href="' . get_post_type_archive_link( get_post_type() ) . '">' . $post_type->labels->singular_name . '</a>' . $after;
                echo wp_kses($before,array('li'=>array())) . get_the_title() . $after;

            } else {

                if ( 'post' == get_post_type() && get_option( 'show_on_front' ) == 'page' ) {
                    echo wp_kses($before,array('li'=>array())) . '<a href="' . get_permalink( get_option('page_for_posts' ) ) . '">' . get_the_title( get_option('page_for_posts', true) ) . '</a>' . $after;
                }

                $cat = current( get_the_category() );
                if ( ( $parents = get_category_parents( $cat, TRUE, $after . $before ) ) && ! is_wp_error( $parents ) ) {
                    echo wp_kses($before,array('li'=>array())) . substr( $parents, 0, strlen($parents) - strlen($after . $before) ) . $after;
                }
                echo wp_kses($before,array('li'=>array())) . get_the_title() . $after;

            }

        } elseif ( is_404() ) {

            echo wp_kses($before,array('li'=>array())) . esc_html__( 'Error 404', 'solaz' ) . $after;

        } elseif ( ! is_single() && ! is_page() && get_post_type() != 'post' ) {

            $post_type = get_post_type_object( get_post_type() );

            if ( $post_type ) {
                echo wp_kses($before,array('li'=>array())) . $post_type->labels->singular_name . $after;
            }

        } elseif ( is_attachment() ) {

            $parent = get_post( $post->post_parent );
            $cat = get_the_category( $parent->ID );
            $cat = $cat[0];
            if ( ( $parents = get_category_parents( $cat, TRUE, $after . $before ) ) && ! is_wp_error( $parents ) ) {
                echo wp_kses($before,array('li'=>array())) . substr( $parents, 0, strlen($parents) - strlen($after . $before) ) . $after;
            }
            echo wp_kses($before,array('li'=>array())) . '<a href="' . get_permalink( $parent ) . '">' . $parent->post_title . '</a>'. $after;
            echo wp_kses($before,array('li'=>array())). get_the_title() . $after;

        } elseif ( is_page() && !$post->post_parent ) {

            echo wp_kses($before,array('li'=>array())) . get_the_title() . $after;

        } elseif ( is_page() && $post->post_parent ) {

            $parent_id  = $post->post_parent;
            $breadcrumbs = array();

            while ( $parent_id ) {
                $page = get_post( $parent_id );
                $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title( $page->ID ) . '</a>';
                $parent_id  = $page->post_parent;
            }

            $breadcrumbs = array_reverse( $breadcrumbs );

            foreach ( $breadcrumbs as $crumb ) {
                echo $before . $crumb . $after;
            }

            echo wp_kses($before,array('li'=>array())) . get_the_title() . $after;

        } elseif ( is_search() ) {

            echo wp_kses($before,array('li'=>array())) . esc_html__( 'Search results for &ldquo;', 'solaz' ) . get_search_query() . '&rdquo;' . $after;

        } elseif ( is_tag() ) {

            echo wp_kses($before,array('li'=>array())) . esc_html__( 'Posts tagged &ldquo;', 'solaz' ) . single_tag_title('', false) . '&rdquo;' . $after;

        } elseif ( is_author() ) {

            $userdata = get_userdata($author);
            echo wp_kses($before,array('li'=>array())) . esc_html__( 'Author:', 'solaz' ) . ' ' . $userdata->display_name . $after;

        }

        if ( get_query_var( 'paged' ) ) {
            echo wp_kses($before,array('li'=>array())) . '&nbsp;(' . esc_html__( 'Page', 'solaz' ) . ' ' . get_query_var( 'paged' ) . ')' . $after;
        }

        echo '</ul>';
    } else {
        if ( is_home() && !is_front_page() ) {
            echo '<ul class="breadcrumb">';

            if ( ! empty( $home ) ) {
                echo wp_kses($before,array('li'=>array())) . '<a class="home" href="' . apply_filters( 'woocommerce_breadcrumb_home_url', home_url('/') ) . '">' . $home . '</a>' . $after;

                echo wp_kses($before,array('li'=>array())) . force_balance_tags($solaz_settings['blog-title']) . $after;
            }

            echo '</ul>';
        }
    }
}
}
if ( ! function_exists ( 'solaz_page_title' ) ) {
function solaz_page_title() {

    global $solaz_settings, $post, $wp_query, $author;

    $home = esc_html__('Home', 'solaz');

    $shop_page_id = false;
    $front_page_shop = false;
    if ( defined( 'WOOCOMMERCE_VERSION' ) ) {
        $shop_page_id = wc_get_page_id( 'shop' );
        $front_page_shop = get_option( 'page_on_front' ) == wc_get_page_id( 'shop' );
    }

    if ( ( ! is_home() && ! is_front_page() && ! ( is_post_type_archive() && $front_page_shop ) ) || is_paged() ) {

        if ( is_home() ) {

        } else if ( is_category() ) {

            echo single_cat_title( '', false );

        } elseif ( is_search() ) {

            echo esc_html__( 'Search results for &ldquo;', 'solaz' ) . get_search_query() . '&rdquo;';

        } elseif ( is_tax('product_cat') || is_tax('portfolio_cat')) {

            $current_term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

            echo esc_html( $current_term->name );

        } elseif ( is_tax('gallery_cat') ) {

            $queried_object = $wp_query->get_queried_object();
            echo  $queried_object->name ;

        } elseif ( is_tax('product_tag') ) {

            $queried_object = $wp_query->get_queried_object();
            echo esc_html__( 'Products tagged &ldquo;', 'solaz' ) . $queried_object->name . '&rdquo;';

        } elseif(is_tax('kbe_tags')){
             echo esc_html__( 'Knowledge tagged &ldquo;', 'solaz' ) . get_queried_object()->name . '&rdquo;';
        } elseif(is_tax('kbe_taxonomy')){
             echo esc_html( get_queried_object()->name );
        } elseif ( is_day() ) {

            printf( esc_html__( 'Daily Archives: %s', 'solaz' ), get_the_date() );

        } elseif ( is_month() ) {

            printf( esc_html__( 'Monthly Archives: %s', 'solaz' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'solaz' ) ) );

        } elseif ( is_year() ) {

            printf( esc_html__( 'Yearly Archives: %s', 'solaz' ), get_the_date( _x( 'Y', 'yearly archives date format', 'solaz' ) ) );

        } elseif ( is_post_type_archive('product') && get_option('page_on_front') !== $shop_page_id ) {

            $_name = wc_get_page_id( 'shop' ) ? get_the_title( wc_get_page_id( 'shop' ) ) : '';

            if ( ! $_name ) {
                $product_post_type = get_post_type_object( 'product' );
                $_name = $product_post_type->labels->singular_name;
            }

            if ( is_search() ) {
                echo esc_html__( 'Search results for &ldquo;', 'solaz' ) . get_search_query() . '&rdquo;';
            } elseif ( is_paged() ) {

            } else {

                echo $_name;

            }

        } elseif ( is_post_type_archive('hb_room') ) {

            $post_type = get_post_type_object( 'hb_room' );
            echo esc_html__( 'All Rooms', 'solaz' );
		
        } elseif(is_tax('hb_room_type')|| is_tax('hb_room_capacity')){
            $queried_object = $wp_query->get_queried_object();
            echo  $queried_object->name ;
        }elseif ( is_post_type_archive('kbe_knowledgebase') ) {

            $post_type = get_post_type_object( 'kbe_knowledgebase' );
             echo esc_html__( 'Knowledge', 'solaz' );

        } else if(is_post_type_archive('gallery')){
            if(isset($solaz_settings['gallery_slug']) && $solaz_settings['gallery_slug'] !=""){
                echo force_balance_tags($solaz_settings['gallery_slug']);
            }else{
                $post_type = get_post_type_object( 'gallery' );
                echo $post_type->labels->name;
            }
                
        }else if(is_post_type_archive('pressmedia')){
            if(isset($solaz_settings['press-media-title']) && $solaz_settings['press-media-title'] !=""){
                echo force_balance_tags($solaz_settings['press-media-title']);
            }else{
                echo esc_html__( 'Press Media', 'solaz' );
            }
                
        }
        else if ( is_post_type_archive() ) {
            sprintf( esc_html__( 'Archives: %s', 'solaz' ), post_type_archive_title( '', false ) );
        } elseif ( is_single() && ! is_attachment() ) {

            if ( 'gallery' == get_post_type() ) {

                echo get_the_title();

            } else {

                echo get_the_title();

            }

        } elseif ( is_404() ) {

            echo esc_html__( 'Error 404', 'solaz' );

        } elseif ( ! is_single() && ! is_page() && get_post_type() != 'post' ) {

            $post_type = get_post_type_object( get_post_type() );

            if ( $post_type ) {
                echo $post_type->labels->singular_name;
            }

        } elseif ( is_attachment() ) {

            echo get_the_title();

        } elseif ( is_page() && !$post->post_parent ) {

            echo get_the_title();

        } elseif ( is_page() && $post->post_parent ) {

            echo get_the_title();

        } elseif ( is_search() ) {

            echo esc_html__( 'Search results for &ldquo;', 'solaz' ) . get_search_query() . '&rdquo;';

        } elseif ( is_tag() ) {

            echo esc_html__( 'Posts tagged &ldquo;', 'solaz' ) . single_tag_title('', false) . '&rdquo;';

        } elseif ( is_author() ) {

            $userdata = get_userdata($author);
            echo esc_html__( 'Author:', 'solaz' ) . ' ' . $userdata->display_name;

        }

        if ( get_query_var( 'paged' ) ) {
            echo ' (' . esc_html__( 'Page', 'solaz' ) . ' ' . get_query_var( 'paged' ) . ')';
        }
    } else {
        if ( is_home() && !is_front_page() ) {
            if ( ! empty( $home ) ) {
                echo force_balance_tags($solaz_settings['blog-title']);
            }
        }
    }
}
}
?>