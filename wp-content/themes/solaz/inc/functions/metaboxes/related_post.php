<?php
if ( ! class_exists( 'solaz_Related_Posts' ) ) :

class solaz_Related_Posts {

    private $supported_post_types;
    private $metakey;

    function __construct(){

        // Set default supported post types
        $this->supported_post_types = array( '' );

        // if ( $metakey ) {
        //     $this->metakey = $metakey;
        // }
        // else {
            $this->metakey = 'related_entries';
        //}

        wp_register_script( 'jquery-select2', get_template_directory_uri() . '/inc/assets/js/select2.min.js', array( 'jquery' ) );
        wp_register_script( 'related-metabox-scripts', get_template_directory_uri() . '/inc/assets/js/related.metabox.js', array( 'jquery', 'jquery-select2' ) );
        wp_register_style( 'style-select2', get_template_directory_uri() . '/inc/assets/css/select2.min.css' );

        add_action( 'admin_enqueue_scripts', array( $this, 'solaz_related_metabox_enqueues' ) );
        add_action( 'add_meta_boxes', array( $this, 'solaz_related_add_metabox' ) );
        add_action( 'save_post', array( $this, 'solaz_related_metabox_save' ) );
    }

    function solaz_related_metabox_enqueues( $screen ) {
        if ( $screen == 'post.php' || $screen == 'post-new.php' ) {
            wp_enqueue_script( 'jquery-select2' );
            wp_enqueue_script( 'related-metabox-scripts' );
            wp_enqueue_style( 'style-select2' );
        }
    }

    function solaz_related_add_metabox( $post_type ) {
        if ( in_array( $post_type, $this->supported_post_types ) ) {
            add_meta_box(
                'related-metabox',
                esc_html__( 'Related post', 'solaz' ),
                array( $this, 'solaz_related_metabox_fields' ),
                $post_type,
                'side',
                'default'
            );
        }
    }

    function solaz_related_metabox_fields( $post ) {
        wp_nonce_field( 'sn_related_metabox', 'sn_related_metabox_nonce' );
        $post_ids = get_post_meta( $post->ID, $this->metakey, true );

        if ( ! is_array( $post_ids ) ) {
            $post_ids = array();
        }

        $query_posts = new WP_Query;
        $post_obj_array = $query_posts->query(
            array(
                'post_type'         => 'gallery',
                'post_status'       => 'publish',
                'pagination'        => false,
                'posts_per_page'    => '-1',
                'post__not_in'      => array( $post->ID ),
            )
        );
        if ( count( $post_obj_array ) > 1) : ?>
        <select id="related-post-select" name="related-post-ids[]" multiple="multiple"><?php
            foreach ( $post_obj_array as $key => $post_obj ) : ?>
            <option value="<?php echo $post_obj->ID; ?>"<?php echo ( in_array( $post_obj->ID, $post_ids) ) ? ' selected="selected"' : ''; ?>><?php echo $post_obj->post_title; ?></option>
            <?php
            endforeach; ?>
        </select><?php
        endif; 
    }

    function solaz_related_metabox_save( $post_id ) {
        
        if (    ! isset( $_POST['sn_related_metabox_nonce'] )
            ||  ! wp_verify_nonce( $_POST['sn_related_metabox_nonce'], 'sn_related_metabox' )
            ||  ! current_user_can( 'edit_post', $post_id ) ) return;

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

        $new_meta_data = array();
        $old_meta_data = get_post_meta( $post_id, $this->metakey, true );

        if ( isset ($_POST['related-post-ids'] ) ) {
            $new_meta_data = $_POST['related-post-ids'];
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
    add_action( 'load-post.php', 'solaz_sn_related_init' );
    add_action( 'load-post-new.php', 'solaz_sn_related_init' );
}

function solaz_sn_related_init() {
    new solaz_Related_Posts();
}

endif;
?>