<?php
//custom field for user
add_action( 'show_user_profile', 'solaz_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'solaz_show_extra_profile_fields' );
function solaz_show_extra_profile_fields( $user ) { ?>
    <h3><?php echo esc_html__( 'Extra profile information', 'solaz' );?></h3>
    <table class="form-table">
        <tr>
            <th><label for="occupation"><?php echo esc_html__( 'Occupation', 'solaz' );?></label></th>

            <td>
                <input type="text" name="occupation" id="occupation" value="<?php echo esc_attr( get_the_author_meta( 'occupation', $user->ID ) ); ?>" class="regular-text" /><br />
                <span class="description"><?php echo esc_html__( 'Please enter your occupation.', 'solaz' );?></span>
            </td>
        </tr>
    </table>
<?php }
add_action( 'personal_options_update', 'solaz_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'solaz_save_extra_profile_fields' );

function solaz_save_extra_profile_fields( $user_id ) {

    if ( !current_user_can( 'edit_user', $user_id ) )
        return false;
    update_user_meta( $user_id, 'occupation', $_POST['occupation'] );
}
function solaz_author_box() {  ?>
    <?php if(get_the_author_meta( 'description' ) != ''):?>
        <div class="author-box">
            <div class="author_blog">
                <div class="avatar_author">
                    <?php echo get_avatar( get_the_author_meta( 'user_email' ), '101' ); ?>
                    <div class="name_author">
                        <?php the_author(); ?>
                    </div>
                    <?php if ( get_the_author_meta( 'occupation' ) ) : ?>
                    <div class="job_author">
                        <p><?php the_author_meta( 'occupation' );?></p>
                    </div>
                    <?php endif;?>
                </div>
                <div class="desc_author">
                    <p><?php the_author_meta( 'description' ); ?></p>
                </div>
            </div>
        </div>
    <?php endif;?>
    <?php
}