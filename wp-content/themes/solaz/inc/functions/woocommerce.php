<?php
//remove action
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5); 
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20); 
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail',10 ); 
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
//add action
add_action( 'woocommerce_shop_loop_item_title', 'solaz_template_title_custom', 10 );
add_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 12);
add_action('init', 'woocommerce_clear_cart_url');
add_action( 'woocommerce_before_shop_loop_item_title', 'solaz_template_loop_product_thumbnail',10 ); 
add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 40);
add_action('woocommerce_after_shop_loop_item_title', 'solaz_woocommerce_single_excerpt', 40);

add_action('woocommerce_template_single_add_to_cart','solaz_wishlist_custom', 30);
add_action( 'woocommerce_single_product_summary', 'solaz_sharing', 52 );

add_action('woocommerce_list_shop_loop_custom', 'woocommerce_template_loop_add_to_cart', 10);
add_action('woocommerce_list_shop_loop_custom','solaz_wishlist_custom', 20);

//add filter
add_filter('loop_shop_per_page', 'solaz_product_shop_per_page', 20);
add_filter( 'gettext', 'solaz_sort_change', 20, 3 );
add_filter('woocommerce_add_to_cart_fragments', 'solaz_woocommerce_header_add_to_cart_fragment');
add_filter( 'woocommerce_billing_fields' , 'solaz_override_billing_fields' );
add_filter( 'woocommerce_shipping_fields' , 'solaz_override_shipping_fields' );
add_filter('woocommerce_checkout_fields', 'solaz_custom_override_checkout_fields');
add_filter("woocommerce_checkout_fields", "solaz_order_fields");
add_filter("woocommerce_checkout_fields", "solaz_order_shipping_fields");
add_action( 'after_setup_theme', 'solaz_woocommerce_support' );
//Functions
add_filter('woocommerce_product_get_rating_html', 'solaz_get_rating_html', 10, 2);
function solaz_get_rating_html($rating_html, $rating) {
  if ( $rating > 0 ) {
    $title = sprintf( esc_html__( 'Rated %s out of 5', 'solaz' ), $rating );
  } else {
    $title = 'Not yet rated';
    $rating = 0;
  }

  $rating_html  = '<div class="star-rating" title="' . $title . '">';
  $rating_html .= '<span style="width:' . ( ( $rating / 5 ) * 100 ) . '%"><strong class="rating">' . $rating . '</strong> ' . esc_html__( 'out of 5', 'solaz' ) . '</span>';
  $rating_html .= '</div>';

  return $rating_html;
}
function solaz_woocommerce_support() {
    add_theme_support( 'woocommerce' );
}

function solaz_template_loop_product_thumbnail() {
    global $product;
    $second_image = '';
    $attachment_ids = $product->get_gallery_image_ids();
    if (count($attachment_ids) && isset($attachment_ids[0])) {
            $second_image = wp_get_attachment_image($attachment_ids[0], 'shop_catalog');
    }
    ?>
    <?php if ($second_image != ''): ?>
    <a class="product-image-hover" href="<?php the_permalink(); ?>">
        <?php echo  woocommerce_get_product_thumbnail(); ?>   
        <div class="img-base">  
            <?php echo wp_kses($second_image ,array(
                              'img' =>  array(
                                'width' => array(),
                                'height'  => array(),
                                'src' => array(),
                                'class' => array(),
                                'alt' => array(),
                                'id' => array(),
                                )
                            ));?>    
        </div>   
    </a>
    <?php else:?>
        <a href="<?php the_permalink(); ?>">
            <?php echo  woocommerce_get_product_thumbnail(); ?>
        </a>
    <?php endif; ?>
    <?php
}
function solaz_product_image(){
    global $post, $product, $woocommerce;
?>
    <div class="images">
        <?php
            if ( has_post_thumbnail() ) {
                $attachment_count = count( $product->get_gallery_image_ids() );
                $gallery          = $attachment_count > 0 ? '[product-gallery]' : '';
                $props            = wc_get_product_attachment_props( get_post_thumbnail_id(), $post );
                $image            = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array(
                    'title'  => $props['title'],
                    'alt'    => $props['alt'],
                    'data-zoom-image' => $image_link,
                    'class' => 'gallery-img zoom',    
                ) );
                echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" itemprop="image" class="woocommerce-main-image zoom" title="%s" data-rel="prettyPhoto' . $gallery . '">%s</a>', $props['url'], $props['caption'], $image ), $post->ID );
            } else {
                echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="%s" />', wc_placeholder_img_src(), esc_html__( 'Placeholder', 'solaz' ) ), $post->ID );
            }

        ?>
    </div>
    <?php 
        $attachment_ids = $product->get_gallery_image_ids();

        if ( $attachment_ids ) {
            $loop       = 0;
            $columns    = apply_filters( 'woocommerce_product_thumbnails_columns', 3 );
            ?>
            <div data-max-items="4" class="owl-prd-thumbnail thumbnails <?php echo 'columns-' . $columns; ?>"><?php

                foreach ( $attachment_ids as $attachment_id ) {

                    $classes = array( 'zoom' );

                    if ( $loop === 0 || $loop % $columns === 0 )
                        $classes[] = 'first';

                    if ( ( $loop + 1 ) % $columns === 0 )
                        $classes[] = 'last';

                    $image_link = wp_get_attachment_url( $attachment_id );

                    if ( ! $image_link )
                        continue;

                    $image_title    = esc_attr( get_the_title( $attachment_id ) );
                    $image_caption  = esc_attr( get_post_field( 'post_excerpt', $attachment_id ) );

                    $image       = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ), 0, $attr = array(
                        'title' => $image_title,
                        'alt'   => $image_title
                        ) );

                    $image_class = esc_attr( implode( ' ', $classes ) );

                    echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<a href="%s" class="%s" title="%s" data-image="'.$image_link.'" data-image-zoom="'.$image_link.'">%s</a>', $image_link, $image_class, $image_caption, $image ), $attachment_id, $post->ID, $image_class );

                    $loop++;
                }

            ?></div>
            <?php
        }
    ?>
    <?php
}

function solaz_sharing(){
    global $solaz_settings;
    if(isset($solaz_settings['product-share']) && $solaz_settings['product-share']):?>
        <div class="product-share">
        <?php echo '<h5>'.esc_html__('Share this:','solaz').'</h5>'; ?>  
        <a href="http://www.facebook.com/sharer.php?u=<?php echo urlencode(get_the_permalink()); ?>" target="_blank"><i class="fa fa-facebook"></i></a>
        <a href="https://twitter.com/share?url=<?php echo urlencode(get_the_permalink()); ?>&amp;text=<?php echo urlencode(get_the_title()); ?>" target="_blank"><i class="fa fa-twitter"></i></a>
        <a href="https://pinterest.com/pin/create/button/?url=<?php echo urlencode(get_the_permalink()); ?>&media=<?php echo urlencode(wp_get_attachment_url( get_post_thumbnail_id() )); ?>&description=<?php echo urlencode(get_the_title()); ?>" target="_blank"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a>  
        <a href="https://plus.google.com/share?url=<?php echo urlencode(get_the_permalink()); ?>" target="_blank">
            <i class="fa fa-google-plus"></i>
        </a>
        </div>
    <?php endif;
}
function solaz_wishlist_custom(){
    global $solaz_settings;
	?>
	<?php if (class_exists('YITH_WCWL') && isset($solaz_settings['product-wishlist']) && $solaz_settings['product-wishlist']) :?>
	<div class="add-to wishlist-btn">
			<?php    
				echo do_shortcode('[yith_wcwl_add_to_wishlist]');
			?>
	</div>
	<?php endif;?>
	<?php
}
function solaz_template_title_custom() {
    ?>
    <h3><a href="<?php the_permalink(); ?>" class="product-name"><?php the_title(); ?></a></h3
    <?php
}
function solaz_woocommerce_single_excerpt() {
    global $post;

    if ( ! $post->post_excerpt ) {
        return;
    }
    ?>
    <div class="desc">
        <?php echo apply_filters( 'woocommerce_short_description', $post->post_excerpt ) ?> 
    </div>
    <?php
}
function solaz_product_shop_per_page() {
    global $solaz_settings;
    parse_str($_SERVER['QUERY_STRING'], $params);

    // replace it with theme option
    if ($solaz_settings['category-item']) {
        $per_page = explode(',', $solaz_settings['category-item']);
    } else {
        $per_page = explode(',', '8,16,24');
    }

    $item_count = !empty($params['count']) ? $params['count'] : $per_page[0];

    return $item_count;
}
function solaz_order_fields($fields) {
    $order = array(
        "billing_country",
        "billing_state",
        "billing_first_name", 
        "billing_last_name", 
        "billing_company", 
        "billing_address_1", 
        "billing_address_2",
        "billing_city",   
        "billing_postcode",       
        "billing_email", 
        "billing_phone",
    );
    foreach($order as $field)
    {
        $ordered_fields[$field] = $fields["billing"][$field];
    }

    $fields["billing"] = $ordered_fields;
    return $fields;

}
function solaz_order_shipping_fields($fields) {
    $order = array(
        "shipping_country",
        "shipping_state",
        "shipping_first_name", 
        "shipping_last_name", 
        "shipping_company", 
        "shipping_address_1",
        "shipping_address_2",
        "shipping_city",        
        "shipping_postcode",
        "shipping_phone",       
        "shipping_email",        
    );
    foreach($order as $field)
    {
        $ordered_fields[$field] = $fields["shipping"][$field];
    }

    $fields["shipping"] = $ordered_fields;
    return $fields;

}
function solaz_woocommerce_product_add_to_cart_text() {
    global $product;
    
    $product_type = $product->product_type;
    
    switch ( $product_type ) {
        case 'external':
            return esc_html__( 'Buy product', 'solaz' );
        break;
        case 'grouped':
            return esc_html__( 'View products', 'solaz' );
        break;
        case 'simple':
            return esc_html__( 'Add to cart', 'solaz' );
        break;
        case 'variable':
            return esc_html__( 'Select options', 'solaz' );
        break;
        default:
            return esc_html__( 'Read more', 'solaz' );
    }
    
}
//update cart items on minicart
function solaz_woocommerce_header_add_to_cart_fragment($fragments) {
    $_cartQty = WC()->cart->cart_contents_count;
    $fragments['#mini-scart .cart_count'] = '<p class="cart_count">' . $_cartQty . '</p>';
    $fragments['#mini-scart .cart_nu_count'] = '<p class="cart_nu_count">' . $_cartQty . '</p>';
    
    return $fragments;
}

// check for empty-cart get param to clear the cart
function woocommerce_clear_cart_url() {
    global $woocommerce;
    if (isset($_GET['empty-cart'])) {
        $woocommerce->cart->empty_cart();
    }
}
function solaz_override_billing_fields( $fields ) {
  $fields['billing_first_name'] = array(
        'label' => esc_html__('First Name','solaz'),
        'placeholder' => _x('First Name *', 'placeholder', 'solaz'),
        'required' => true,
    );
    $fields['billing_last_name'] = array(
        'label' => esc_html__('Last Name','solaz'),
        'placeholder' => _x('Last Name *', 'placeholder', 'solaz'),
        'required' => true,
    );
  $fields['billing_company'] = array(
        'label' => esc_html__('Company name','solaz'),
        'placeholder' => _x('Company Name', 'placeholder', 'solaz'),
        'required' => false,
    );
  $fields['billing_email'] = array(
        'label' => 'Email',
        'placeholder' => _x('E-mail *', 'placeholder', 'solaz'),
        'required' => true,
    );
  $fields['billing_phone'] = array(
        'label' => 'Phone',
        'placeholder' => _x('Phone *', 'placeholder', 'solaz'),
        'required' => true,
    );
  $fields['billing_address_1'] = array(
        'label' => 'Address',
        'placeholder' => _x('Address', 'placeholder', 'solaz'),
        'required' => false,
    );
  $fields['billing_address_2'] = array(
        'label' => esc_html__('Apartment, suite, unit etc. (optional)','solaz'),
        'placeholder' => _x('Apartment, suite, unit etc. (optional)', 'placeholder', 'solaz'),
        'required' => false,
    );
  $fields['billing_postcode'] = array(
        'label' => esc_html__('Postcode / Zip','solaz'),
        'placeholder' => _x('Postcode / Zip *', 'placeholder', 'solaz'),
        'required' => true,
    );
  $fields['billing_city'] = array(
        'label' => esc_html__('Town / City','solaz'),
        'placeholder' => _x('Town / City *', 'placeholder', 'solaz'),
        'required' => true,
    );
  $fields['billing_phone'] = array(
        'label' => esc_html__('Phone','solaz'),
        'placeholder' => _x('Phone *', 'placeholder', 'solaz'),
        'required' => true,
    );
  $fields['billing']['billing_state'] = array(
        'label' => esc_html__('State / County','solaz'),
        'placeholder' => _x('State / County', 'placeholder', 'solaz'),
        'required' => false,
    );
  return $fields;
}

function solaz_override_shipping_fields( $fields ) {
  $fields['shipping_first_name'] = array(
        'label' => esc_html__('First Name','solaz'),
        'placeholder' => _x('First Name *', 'placeholder', 'solaz'),
        'required' => true,
    );
    $fields['shipping_last_name'] = array(
        'label' => esc_html__('Last Name','solaz'),
        'placeholder' => _x('Last Name *', 'placeholder', 'solaz'),
        'required' => true,
    );
  $fields['shipping_company'] = array(
        'label' => esc_html__('Company name','solaz'),
        'placeholder' => _x('Company Name', 'placeholder', 'solaz'),
        'required' => false,
    );
  $fields['shipping_email'] = array(
        'label' => 'Email',
        'placeholder' => _x('E-mail *', 'placeholder', 'solaz'),
        'required' => true,
    );
  $fields['shipping_phone'] = array(
        'label' => 'Phone',
        'placeholder' => _x('Phone *', 'placeholder', 'solaz'),
        'required' => true,
    );
  $fields['shipping_address_1'] = array(
        'label' => 'Address',
        'placeholder' => _x('Address *', 'placeholder', 'solaz'),
        'required' => true,
    );
  $fields['shipping_address_2'] = array(
        'label' => esc_html__('Apartment, suite, unit etc. (optional)','solaz'),
        'placeholder' => _x('Apartment, suite, unit etc. (optional)', 'placeholder', 'solaz'),
        'required' => false,
    );
  $fields['shipping_postcode'] = array(
        'label' => esc_html__('Postcode / Zip','solaz'),
        'placeholder' => _x('Postcode / Zip *', 'placeholder', 'solaz'),
        'required' => true,
    );
  $fields['shipping_city'] = array(
        'label' => esc_html__('Town / City','solaz'),
        'placeholder' => _x('Town / City *', 'placeholder', 'solaz'),
        'required' => true,
    );
  $fields['shipping_phone'] = array(
        'label' => esc_html__('Phone','solaz'),
        'placeholder' => _x('Phone *', 'placeholder', 'solaz'),
        'required' => true,
    );
  $fields['shipping_state'] = array(
        'label' => esc_html__('State / County ','solaz'),
        'placeholder' => _x('State / County ', 'placeholder', 'solaz'),
        'required' => false,
    );
  return $fields;
}
function solaz_custom_override_checkout_fields($fields) {

    $fields['billing']['billing_first_name'] = array(
        'label' => esc_html__('First Name','solaz'),
        'placeholder' => _x('First Name *', 'placeholder', 'solaz'),
        'required' => true,
    );
    $fields['billing']['billing_last_name'] = array(
        'label' => esc_html__('Last Name','solaz'),
        'placeholder' => _x('Last Name *', 'placeholder', 'solaz'),
        'required' => true,
    );
    $fields['billing']['billing_company'] = array(
        'label' => '',
        'placeholder' => _x('Company Name', 'placeholder', 'solaz'),
        'required' => false,
        'class'     => array('form-row-wide'),
    );
    $fields['billing']['billing_address_1'] = array(
        'label' => '',
        'placeholder' => _x('Address', 'placeholder', 'solaz'),
        'required' => false,
        'class'     => array('form-row-wide'),
    );
    $fields['billing']['billing_address_2'] = array(
        'label' => '',
        'placeholder' => _x('Enter Your Apartment', 'placeholder', 'solaz'),
        'required' => false,
    );
    $fields['billing']['billing_city'] = array(
        'label' => esc_html__('City','solaz'),
        'placeholder' => _x('City *', 'placeholder', 'solaz'),
        'required' => true,
    );
    $fields['billing']['billing_postcode'] = array(
        'label' => esc_html__('Postcode / Zip','solaz'),
        'placeholder' => _x('Postcode / Zip *', 'placeholder', 'solaz'),
        'required' => true,
        'value' => '',
    );
    $fields['billing']['billing_email'] = array(
        'label' => esc_html__('Email Address','solaz'),
        'placeholder' => _x('E-mail *', 'placeholder', 'solaz'),
        'required' => true,
    );
    $fields['billing']['billing_phone'] = array(
        'label' => esc_html__('Phone','solaz'),
        'placeholder' => _x('Phone *', 'placeholder', 'solaz'),
        'required' => true,
    );
    $fields['billing']['billing_state'] = array(
        'label' => esc_html__('State / County','solaz'),
        'placeholder' => _x('State / County', 'placeholder', 'solaz'),
        'required' => false,
    );
    $fields['shipping']['shipping_phone'] = array(
        'label' => esc_html__('Phone','solaz'),
        'placeholder'   => _x('Phone Number *', 'placeholder', 'solaz'),
        'required'  => true,
     );
    $fields['shipping']['shipping_first_name'] = array(
        'label' => esc_html__('First Name','solaz'),
        'placeholder' => _x('First Name *', 'placeholder', 'solaz'),
        'required' => true,
    );
    $fields['shipping']['shipping_last_name'] = array(
        'label' => esc_html__('Last Name','solaz'),
        'placeholder' => _x('Last Name *', 'placeholder', 'solaz'),
        'required' => true,
    );
    $fields['shipping']['shipping_company'] = array(
        'label' => esc_html__('Company Name','solaz'),
        'placeholder' => _x('Company Name', 'placeholder', 'solaz'),
        'required' => false,
        'class'     => array('form-row-wide'),
    );
    $fields['shipping']['shipping_city'] = array(
        'label' => esc_html__('City','solaz'),
        'placeholder' => _x('City *', 'placeholder', 'solaz'),
        'required' => true,
    );
    $fields['shipping']['shipping_state'] = array(
        'label' => esc_html__('Enter State/Country','solaz'),
        'placeholder' => _x('Enter State/Country', 'placeholder', 'solaz'),
        'required' => false,
    );
    $fields['shipping']['shipping_email'] = array(
        'label' => esc_html__('Email Address','solaz'),
        'placeholder' => _x('E-mail *', 'placeholder', 'solaz'),
        'required' => true,
    );
    $fields['shipping']['shipping_postcode'] = array(
        'label' => esc_html__('Postcode / Zip','solaz'),
        'placeholder' => _x('Postal Code *', 'placeholder', 'solaz'),
        'required' => true,
    );
    $fields['shipping']['shipping_address_1'] = array(
        'label' => esc_html__('Adress','solaz'),
        'placeholder' => _x('Address *', 'placeholder', 'solaz'),
        'required' => true,
        'class'     => array('form-row-wide'),
    );
    $fields['order']['order_comments'] = array(
        'label' => esc_html__('Order notes','solaz'),
        'placeholder' => _x('Order Notes', 'placeholder', 'solaz'),
        'required' => false,
        'type' => 'textarea',
        'class'     => array('form-row-wide'),
    );
    

    return $fields;
}
function solaz_sort_change( $translated_text, $text, $domain ) {

    if ( is_woocommerce() ) {

        switch ( $translated_text ) {
            case 'Sort by popularity' :

                $translated_text = esc_html__( 'Popularity', 'solaz' );
                break;
            case 'Sort by average rating' :

                $translated_text = esc_html__( 'Average rating', 'solaz' );
                break;    
            case 'Sort by newness' :

                $translated_text = esc_html__( 'Newest', 'solaz' );
                break;
            case 'Sort by price: low to high' :

                $translated_text = esc_html__( 'Low to high', 'solaz' );
                break;    
            case 'Sort by price: high to low' :

                $translated_text = esc_html__( 'High to low', 'solaz' );
                break;    
        }

    }

    return $translated_text;
} 
