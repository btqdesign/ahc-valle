<?php

if ( ! class_exists( 'SN_Gallery_Metabox' ) ) :

class solaz_Gallery_Metabox {
    private $supported_post_types;
    private $metakey;

    function __construct( $metakey = null ) {

        // Set default supported post types
        $this->supported_post_types = array( 'post', '' );

        if ( $metakey ) {
            $this->metakey = $metakey;
        }
        else {
            $this->metakey = 'images_gallery';
        }

        wp_register_script( 'gallery-metabox-scripts', get_template_directory_uri() . '/inc/assets/js/gallery.metabox.js', array( 'jquery', 'jquery-ui-sortable' ) );
        // wp_register_style( 'gallery-metabox-styles', get_template_directory_uri() . '/inc/assets/css/gallery.metabox.css' );

        add_action( 'admin_enqueue_scripts', array( $this, 'solaz_gallery_metabox_enqueues' ) );
        add_action( 'add_meta_boxes', array( $this, 'solaz_gallery_add_metabox' ) );
        add_action( 'save_post', array( $this, 'solaz_gallery_metabox_save' ) );
    }

    function solaz_gallery_metabox_enqueues( $screen ) {
        if ( $screen == 'post.php' || $screen == 'post-new.php' ) {
            wp_enqueue_script( 'gallery-metabox-scripts' );
            wp_enqueue_style( 'gallery-metabox-styles' );
        }
    }

    function solaz_gallery_add_metabox( $post_type ) {
        if ( in_array( $post_type, $this->supported_post_types ) ) {
            add_meta_box(
                'gallery-metabox',
                esc_html__( 'Images Gallery', 'solaz' ),
                array( $this, 'solaz_gallery_metabox_fields' ),
                $post_type,
                'side',
                'core'
            );
        }
    }

    function solaz_gallery_metabox_fields( $post ) {
        wp_nonce_field( 'sn_gallery_metabox', 'sn_gallery_metabox_nonce' );
        $images = get_post_meta( $post->ID, $this->metakey, true ); ?>
        <div class="sn-gallery-wrap">
            <div class="sn-gallery-inner">
                <a href="#" class="button gallery-add-images"
                    title="<?php echo esc_html__( 'Add image(s) to gallery', 'solaz' ) ?>"
                    data-uploader-title="<?php echo esc_html__( 'Add image(s)', 'solaz'); ?>"
                    data-uploader-button-text="<?php echo esc_html__( 'Add image(s)', 'solaz'); ?>"><?php echo esc_html__( 'Add image(s)', 'solaz' ); ?></a>
                <ul class="images-list"><?php
                if ( $images ) :
                    foreach ( $images as $key => $value ) : $image = wp_get_attachment_image_src( $value ); ?>
                    <li>
                        <input type="hidden" name="sn-gallery-id[<?php echo esc_attr($key); ?>]" value="<?php echo esc_attr($value); ?>"/>
                        <img class="image-preview" src="<?php echo esc_url($image[0]); ?>" width="80" height="80"/>
                        <a href="#" class="change-image"
                            title="<?php echo esc_html__( 'Change image', 'solaz' ); ?>"
                            data-uploader-title="<?php echo esc_html__( 'Change image', 'solaz' ); ?>"
                            data-uploader-button-text="<?php echo esc_html__( 'Change image', 'solaz' ); ?>"><i class="dashicons dashicons-edit"></i></a>
                        <a href="#" class="remove-image" title="<?php echo esc_html__( 'Remove Image', 'solaz' ); ?>"><i class="dashicons dashicons-no"></i></a>
                    </li><?php
                    endforeach;
                endif; ?>
                </ul>
            </div>
        </div>
        <?php
    }

    function solaz_gallery_metabox_save( $post_id ) {
        
        if (    ! isset( $_POST['sn_gallery_metabox_nonce'] )
            ||  ! wp_verify_nonce( $_POST['sn_gallery_metabox_nonce'], 'sn_gallery_metabox' ) ) return;

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

        $new_meta_data = array();
        $old_meta_data = get_post_meta( $post_id, $this->metakey, true );

        if ( isset ($_POST['sn-gallery-id'] ) ) {
            $new_meta_data = $_POST['sn-gallery-id'];
        }

        if ( ! empty( $new_meta_data ) ) {
            if ( empty($old_meta_data) ) {
                add_post_meta( $post_id, $this->metakey, $new_meta_data, true );
            }
            elseif ( array_diff( $old_meta_data, $new_meta_data ) || $old_meta_data !== $new_meta_data ) {
                update_post_meta( $post_id, $this->metakey, $new_meta_data );
            }
        }
        else {
            delete_post_meta( $post_id, $this->metakey );
        }
    }
}

if ( is_admin() ) {
    add_action( 'load-post.php', 'solaz_gallery_init' );
    add_action( 'load-post-new.php', 'solaz_gallery_init' );
}

function solaz_gallery_init() {
    new solaz_Gallery_Metabox();
}

endif;