<?php
add_action('widgets_init', 'solaz_register_sidebars');

function solaz_register_sidebars() {
    
    register_sidebar(array(
        'name' => esc_html__('General Sidebar', 'solaz'),
        'id' => 'general-sidebar',
        'before_widget' => '<aside id="%1$s" class="widget general-sidebar %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<h3 class="widget-title widget-title-border"><span>',
        'after_title' => '</span></h3>',
    ));
    
    register_sidebar( array(
        'name' => esc_html__('Blog Sidebar', 'solaz'),
        'id' => 'blog-sidebar',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<h3 class="widget-title widget-title-border"><span>',
        'after_title' => '</span></h3>',
    ) );
    register_sidebar(array(
        'name' => esc_html__('Footer 2 Widget 1', 'solaz'),
        'id' => 'footer2-column-1',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<h4 class="footer-title">',
        'after_title' => '</h4> ',
    ));

    register_sidebar(array(
        'name' => esc_html__('Footer 2 Widget 2', 'solaz'),
        'id' => 'footer2-column-2',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<h4 class="footer-title">',
        'after_title' => '</h4>',
    ));

    register_sidebar(array(
        'name' => esc_html__('Footer 2 Widget 3', 'solaz'),
        'id' => 'footer2-column-3',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<h4 class="footer-title">',
        'after_title' => '</h4>',
    )); 
    register_sidebar(array(
        'name' => esc_html__('Footer3 Widget 1', 'solaz'),
        'id' => 'footer3-column-1',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<h4 class="footer-title">',
        'after_title' => '</h4>',
    ));

    register_sidebar(array(
        'name' => esc_html__('Footer3 Widget 2', 'solaz'),
        'id' => 'footer3-column-2',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<h4 class="footer-title">',
        'after_title' => '</h4>',
    )); 
    if (class_exists('Woocommerce')) {

        register_sidebar(array(
            'name' => esc_html__('Shop Sidebar', 'solaz'),
            'id' => 'shop-sidebar',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => "</aside>",
            'before_title' => '<h3 class="widget-title widget-title-border"><span>',
            'after_title' => '</span></h3>',
        ));

        register_sidebar(array(
            'name' => esc_html__('Single Product Sidebar', 'solaz'),
            'id' => 'single-product-sidebar',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => "</aside>",
            'before_title' => '<h3 class="widget-title widget-title-border"><span>',
            'after_title' => '</span></h3>',
        ));
    }
    if (class_exists('WP_Hotel_Booking')) {

        register_sidebar(array(
            'name' => esc_html__('ArrowPress Room Sidebar', 'solaz'),
            'id' => 'room-sidebar',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => "</aside>",
            'before_title' => '<h3 class="widget-title widget-title-border"><span>',
            'after_title' => '</span></h3>',
        ));
    }
}