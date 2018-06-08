<?php 
require_once(SOLAZ_METABOXES . '/default_options.php');
require_once(SOLAZ_METABOXES . '/page.php');
require_once(SOLAZ_METABOXES . '/member.php');
require_once(SOLAZ_METABOXES . '/post.php');
require_once(SOLAZ_METABOXES . '/products.php');
require_once(SOLAZ_METABOXES . '/gallery.php');
require_once(SOLAZ_METABOXES . '/related_post.php');
require_once(SOLAZ_METABOXES . '/testimonial.php');
require_once(SOLAZ_METABOXES . '/portfolio.php');
require_once(SOLAZ_METABOXES . '/user-profile.php');
if(function_exists('is_plugin_active') && is_plugin_active('wp-hotel-booking/wp-hotel-booking.php')){
    require_once(SOLAZ_METABOXES . '/room.php');
}

function solaz_post_gallery_related(){
$gallery_related = get_post_meta(get_the_ID(), 'related_entries', true);
$output = '';
ob_start();
?>
    <?php if (is_array($gallery_related)) : ?>
        <?php if (count($gallery_related) > 0) : ?>
            <div class="mad_section_bg1 gallery_related">
                <h2 class="align_center"><?php echo esc_html__('Related Projects','solaz' );?></h2>
                <div class="container extra">
                    <div class="carousel_type_4">
                        <div class="owl-carousel" data-max-items="4">
                            <?php foreach ($gallery_related as $key => $entry) : ?>
                            <div>
                                <div class="item_wrapper">
                                    <?php
                                    $post_term_arr = get_the_terms($entry, 'gallery_cat');

                                    $post_term_names = '';

                                    foreach ($post_term_arr as $post_term) {
                                        $post_term_names .= $post_term->name . ', ';
                                    }
                                    $post_term_names = substr($post_term_names, 0, -2);
                                    ?>
                                    <?php if (has_post_thumbnail($entry)) : ?>
                                    <figure>
                                        <?php $image = get_the_post_thumbnail($entry, 'solaz_gallery'); 
                                        $attachment_url = wp_get_attachment_url(get_post_thumbnail_id($entry)); 
                                        ?>
                                        <div class="post_image plus_link">
                                          <?php echo wp_kses($image,array(
                                              'img' =>  array(
                                                'width' => array(),
                                                'height'  => array(),
                                                'src' => array(),
                                                'class' => array(),
                                                'alt' => array(),
                                                'id' => array(),
                                                )
                                            )); ?>
                                          <div class="curtain two_items">
                                            <a href="<?php echo esc_url($attachment_url) ?>" class="gallery" rel="category"></a>
                                            <a href="<?php echo esc_url(get_permalink($entry)); ?>" class="link" rel="category"></a>
                                          </div> 
                                        </div>
                                    </figure>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>    
            </div>
        <?php endif; ?>
    <?php endif; ?>
<?php
$output .= ob_get_clean();
return $output;
}
function solaz_sidebars() {
    global $wp_registered_sidebars;

    $sidebar_options = array();
    $sidebar_options['default'] = esc_html__('Default sidebar', 'solaz');
    $sidebar_options['none'] = esc_html__('None', 'solaz');
    if (!empty($wp_registered_sidebars)) {
        foreach ($wp_registered_sidebars as $sidebar) {
            $sidebar_options[$sidebar['id']] = $sidebar['name'];
        }
    }
    return $sidebar_options;
}
function solaz_metabox_template($meta_boxes) {
    global $post;
    $output = '';
    ob_start();
    foreach ($meta_boxes as $meta_box):
        $name = isset($meta_box['name']) ? $meta_box['name'] : '';
        $title = isset($meta_box['title']) ? $meta_box['title'] : '';
        $desc = isset($meta_box['desc']) ? $meta_box['desc'] : '';
        $default = isset($meta_box['default']) ? $meta_box['default'] : '';
        $type = isset($meta_box['type']) ? $meta_box['type'] : '';
        $options = isset($meta_box['options']) ? $meta_box['options'] : '';
        $display_condition = isset($meta_box['display_condition']) ? $meta_box['display_condition'] : '';
        $status = isset($meta_box['status']) ? $meta_box['status'] : '';
        $group = isset($meta_box['group']) ? $meta_box['group'] : '';
        $number_after = isset($meta_box['number_after']) ? $meta_box['number_after'] : '';
        $meta_box_value = get_post_meta($post->ID, $name, true);

        if ($meta_box_value == "")
            $meta_box_value = $default;

        echo '<input type="hidden" name="' . $name . '_noncename" id="' . $name . '_noncename" value="' . wp_create_nonce(plugin_basename(__FILE__)) . '" />';
        $format_type ="";
        if ( get_post_type() == "post" ) {
            $format_type =  $display_condition.' format-type';
        }
        ?>
        <?php if ($type == "text") : ?>
            <div class="metabox <?php echo esc_attr($format_type); ?> <?php echo esc_attr($group); ?>">
                <h3><?php echo esc_html($title) ?></h3>
                <div class="metainner">
                    <div class="box-option">
                        <input type="text" id="<?php echo esc_attr($name) ?>" name="<?php echo esc_attr($name) ?>" value="<?php echo stripslashes($meta_box_value) ?>" size="50%" />
                    </div>
                    <div class="box-info"><label for="<?php echo esc_attr($name) ?>"><?php echo esc_html($desc)?></label></div>
                </div>
            </div>
        <?php endif; ?>
        <?php if ($type == "textfield") : ?>
            <div class="metabox <?php echo esc_attr($group);?> <?php echo esc_attr($format_type); ?>">
                <h3><?php echo esc_html($title) ?></h3>
                <div class="metainner">
                    <div class="box-option">
                        <input type="text" id="<?php echo esc_attr($name) ?>" name="<?php echo esc_attr($name) ?>" value="<?php echo stripslashes($meta_box_value) ?>" size="50%" />
                    </div>
                    <?php if($desc != ''):?>
                        <div class="box-info"><label for="<?php echo esc_attr($name) ?>"><?php echo esc_html($desc) ?></label></div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
        <?php if ($type == "number") : ?>
            <div class="metabox <?php echo esc_attr($group);?>">
                <h3><?php echo esc_html($title) ?></h3>
                <div class="metainner">
                    <div class="box-option">
                        <input type="number" id="<?php echo esc_attr($name) ?>" name="<?php echo esc_attr($name) ?>" value="<?php echo stripslashes($meta_box_value) ?>" size="50%" />
                        <p class="number_after"><?php echo esc_html($number_after); ?></p>
                    </div>
                    <div class="box-info"><label for="<?php echo esc_attr($name) ?>"><?php echo esc_html($desc) ?></label></div>
                </div>
            </div>
        <?php endif; ?>       
        <?php if ($type == "select") : ?>
            <div class="metabox <?php echo esc_attr($group);?>">
                <h3><?php echo esc_html($title) ?></h3>
                <div class="metainner">
                    <div class="box-option">
                        <select name="<?php echo esc_attr($name) ?>" id="<?php echo esc_attr($name) ?>">
                            <?php if (is_array($options)) : ?>
                                <?php foreach ($options as $key => $value) : ?>
                                    <option value="<?php echo esc_attr($key) ?>"<?php echo ($meta_box_value == $key ? ' selected="selected"' : '') ?>>
                                        <?php echo esc_html( $value ); ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif ?>
                        </select>
                    </div>
                    <div class="box-info"><label for="<?php echo esc_attr($name) ?>"><?php echo esc_html($desc) ?></label></div>
                </div>
            </div>
        <?php endif; ?>
        <?php if ($type == "upload") : ?>
            <div class="metabox">
                <h3><?php echo esc_html($title) ?></h3>
                <div class="metainner">
                    <div class="box-option">
                        <label for='upload_image'>
                            <input value="<?php echo stripslashes($meta_box_value) ?>" type="text" name="<?php echo esc_attr($name) ?>"  id="<?php echo esc_attr($name) ?>" size="50%" />
                            <br/>
                            <input class="button_upload_image button" id="<?php echo esc_attr($name) ?>" type="button" value="<?php echo esc_html__('Upload File', 'solaz') ?>" />&nbsp;
                            <input class="button_remove_image button" id="<?php echo esc_attr($name) ?>" type="button" value="<?php echo esc_html__('Remove File', 'solaz') ?>" />
                        </label>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php if ($type == "editor") : ?>
            <div class="metabox">
                <h3 style="float:none;"><?php echo esc_html($title) ?></h3>
                <div class="metainner">
                    <div class="box-option">
                        <?php wp_editor($meta_box_value, $name) ?>
                    </div>
                    <div class="box-info"><label for="<?php echo esc_attr($name) ?>"><?php echo esc_html($desc) ?></label></div>
                </div>
            </div>
        <?php endif; ?>
        <?php if ($type == "textarea") : ?>
            <div class="metabox <?php echo esc_attr($format_type); ?>">
                <h3><?php echo esc_html($title) ?></h3>
                <div class="metainner">
                    <div class="box-option">
                        <textarea id="<?php echo esc_attr($name) ?>" name="<?php echo esc_attr($name) ?>"><?php echo stripslashes($meta_box_value) ?></textarea>
                    </div>
                    <div class="box-info"><label for="<?php echo esc_attr($name) ?>"><?php echo esc_html($desc) ?></label></div>
                </div>
            </div>
        <?php endif; ?>
        <?php if (($type == 'radio')) : ?>
            <div class="metabox">
                <h3><?php echo esc_html($title) ?></h3>
                <div class="metainner">
                    <div class="box-option radio">
                        <?php foreach ($options as $key => $value) : ?>
                            <input type="radio" id="<?php echo esc_attr($name) ?>_<?php echo esc_attr($key) ?>" name="<?php echo esc_attr($name) ?>" value="<?php echo esc_attr($key) ?>"
                                   <?php echo (isset($meta_box_value) && ($meta_box_value == $key) ? ' checked="checked"' : '') ?>/>
                            <label for="<?php echo esc_attr($name) ?>_<?php echo esc_attr($key) ?>"><?php echo esc_html( $value ); ?></label>
                        <?php endforeach; ?>
                        <br>
                    </div>
                    <div class="box-info"><label for="<?php echo esc_attr($name) ?>"><?php echo esc_html($desc) ?></label></div>
                </div>
            </div>
        <?php endif; ?>
        <?php if ($type == "checkbox") : ?>
            <?php
            if ($meta_box_value == $name) {
                $checked = "checked=\"checked\"";
            } else {
                $checked = "";
            }
            ?>
            <div class="metabox">
                <h3><?php echo esc_html($title) ?></h3>
                <div class="metainner">
                    <div class="box-option checkbox">
                        <label><input type="checkbox" name="<?php echo esc_attr($name) ?>" value="<?php echo esc_attr($name) ?>" <?php echo esc_attr($checked) ?>/> <?php echo esc_html($desc) ?></label>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php if (($type == 'multi_checkbox') && (!empty($options))) : ?>
            <div class="metabox">
                <h3><?php echo esc_html($title) ?></h3>
                <div class="metainner">
                    <div class="box-option radio">
                        <?php foreach ($options as $key => $value) : ?>
                            <input type="checkbox" id="<?php echo esc_attr($name) ?>_<?php echo esc_attr($key) ?>" name="<?php echo esc_attr($name) ?>[]" value="<?php echo esc_attr($key) ?>" <?php echo (isset($meta_box_value) && in_array($key, explode(',', $meta_box_value))) ? ' checked="checked"' : '' ?>/><label for="<?php echo esc_attr($name) ?>_<?php echo esc_attr($key) ?>"> <?php echo esc_html( $value ); ?> </label>
                        <?php endforeach; ?>
                    </div>
                    <div class="box-info"><label for="<?php echo esc_attr($name) ?>"><?php echo esc_html($desc) ?></label></div>
                </div>
            </div>
        <?php endif; ?>
        <?php if ($type == "color") : // color ?>
            <div class="metabox" >
                <h3><?php echo esc_html($title) ?></h3>
                <div class="metainner">
                    <div class="box-option arp-meta-color">
                        <input type="text" id="<?php echo esc_attr($name) ?>" name="<?php echo esc_attr($name) ?>" value="<?php echo stripslashes($meta_box_value) ?>" size="50%" class="arp-color-field" />
                        <label class="arp-transparency-check" for="<?php echo esc_attr($name) ?>-transparency"><input type="checkbox" value="1" id="<?php echo esc_attr($name) ?>-transparency" class="checkbox arp-color-transparency"<?php if ($meta_box_value == 'transparent') echo ' checked="checked"' ?>> <?php echo esc_html__('Transparent', 'solaz') ?></label>
                    </div>
                    <div class="box-info"><label for="<?php echo esc_attr($name) ?>"><?php echo esc_html($desc) ?></label></div>
                </div>
            </div>
        <?php endif; ?>
        <?php if ($type == 'skin') : ?> 
            <div class="metabox  <?php echo ($status != '') ? esc_attr($status): ''?>" <?php if($status != ''){ ?>data-require="<?php echo esc_attr($require)?>" <?php }?> data-name="<?php echo esc_attr($name)?>">
                <h3><?php echo esc_html($title) ?></h3>
                <div class="metainner">
                    <div class="box-option skin">
                        <ul class="list-inline list-color">
                            <?php foreach ($options as $option) : ?>
                                <li class="<?php echo esc_attr($option); ?><?php echo (isset($meta_box_value) && $meta_box_value == $option) ? ' selected': '' ?>" data-name="<?php echo esc_attr($option); ?>"><a href="#"></a></li>
                            <?php endforeach; ?>
                        </ul>
                        <input type="hidden" name="<?php echo esc_attr($name)?>" value="<?php echo (isset($meta_box_value) && $meta_box_value !='') ? esc_attr($meta_box_value): esc_attr($default) ?>"/>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; //end loop $meta_boxes ?>
    <?php
    $output .= ob_get_clean();
    return $output;
}

function solaz_show_meta_box($meta_boxes) {
    if (count($meta_boxes)) :
        $metabox_template = solaz_metabox_template($meta_boxes);
        echo '<div class="postoptions">'.$metabox_template.'</div>'; //end div class postoptions
    endif;
}

function solaz_save_meta_data($post_id, $meta_boxes) {
    global $post;
    if (!isset($meta_boxes) || empty($meta_boxes))
        return;

    foreach ($meta_boxes as $meta_box) {

        extract(shortcode_atts(array(
            "name" => '',
            "title" => '',
            "desc" => '',
            "type" => '',
            "default" => '',
            "options" => ''
                        ), $meta_box));

        if (!isset($_POST[$name . '_noncename']))
            return $post_id;

        if (!wp_verify_nonce($_POST[$name . '_noncename'], plugin_basename(__FILE__))) {
            return $post_id;
        }

        if ('page' == $_POST['post_type']) {
            if (!current_user_can('edit_page', $post_id))
                return $post_id;
        } else {
            if (!current_user_can('edit_post', $post_id))
                return $post_id;
        }

        $meta_box_value = get_post_meta($post_id, $name, true);

        if (!isset($_POST[$name])) {
            delete_post_meta($post_id, $name, $meta_box_value);
            continue;
        }

        $data = $_POST[$name];

        if (is_array($data))
            $data = implode(',', $data);

        if (!$meta_box_value && !$data)
            add_post_meta($post_id, $name, $data, true);
        elseif ($data != $meta_box_value)
            update_post_meta($post_id, $name, $data);
        elseif (!$data)
            delete_post_meta($post_id, $name, $meta_box_value);
    }
}

function solaz_use_default_meta() {
    global $wp_query;

    $value = '';

    if (is_category()) {
        $cat = $wp_query->get_queried_object();
        $value = get_metadata('category', $cat->term_id, 'default', true);
    } else if (is_archive()) {
        if (function_exists('is_shop') && is_shop()) {
            $value = get_post_meta(wc_get_page_id('shop'), 'default', true);
        } else {
            $term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
            if ($term) {
                $value = get_metadata($term->taxonomy, $term->term_id, 'default', true);
            }
        }
    } else {
        if (is_singular()) {
            $value = get_post_meta(get_the_ID(), 'default', true);
        }
    }

    return ($value != 'default') ? true : false;
}

function solaz_get_meta_value($meta_key, $boolean = false) {
    global $wp_query, $solaz_settings;

    $value = '';

    if (is_category()) {
        $cat = $wp_query->get_queried_object();
        $value = get_metadata('category', $cat->term_id, $meta_key, true);
    } else if (is_archive()) {
        if (function_exists('is_shop') && is_shop())  {
            $value = get_post_meta(wc_get_page_id( 'shop' ), $meta_key, true);
        } else {
            $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
            if ($term) {
                $value = get_metadata($term->taxonomy, $term->term_id, $meta_key, true);
            }
        }
    } else {
        if (is_singular()) {
            $value = get_post_meta(get_the_id(), $meta_key, true);
        } else {
            if (!is_home() && is_front_page()) {
                if (isset($solaz_settings[$meta_key]))
                    $value = $solaz_settings[$meta_key];
            } else if (is_home() && !is_front_page()) {
                if (isset($solaz_settings['blog-'.$meta_key]))
                    $value = $solaz_settings['blog-'.$meta_key];
            } else if (is_home() || is_front_page()) {
                if (isset($solaz_settings[$meta_key]))
                    $value = $solaz_settings[$meta_key];
            }
        }
    }

    if ($boolean) {
        $value = ($value != $meta_key) ? true : false;
    }

    return $value;
}
// Show Taxonomy Add Meta Boxes
function solaz_show_tax_add_meta_boxes($meta_boxes) {
    if (!isset($meta_boxes) || empty($meta_boxes))
        return;

    foreach ($meta_boxes as $meta_box) {
        solaz_show_tax_add_meta_box($meta_box);
    }
}

// Show Taxonomy Add Meta Box
function solaz_show_tax_add_meta_box($meta_box) {

    extract(shortcode_atts(array(
        "name" => '',
        "title" => '',
        "desc" => '',
        "type" => '',
        "default" => '',
        "options" => ''
    ), $meta_box));

    ?>

    <input type="hidden" name="<?php echo esc_attr($name) ?>_noncename" id="<?php echo esc_attr($name) ?>_noncename"
        value="<?php echo wp_create_nonce( plugin_basename(__FILE__) ) ?>" />

    <?php

    if ($type == "text") : // text ?>
        <div class="form-field">
            <label for="<?php echo esc_attr($name) ?>"><?php echo esc_html($title) ?></label>
            <input type="text" id="<?php echo esc_attr($name) ?>" name="<?php echo esc_attr($name) ?>" />
            <?php if ($desc) : ?><p><?php echo esc_html($desc) ?></p><?php endif; ?>
        </div>
    <?php endif;

    if ($type == "select") : // select ?>
        <div class="form-field">
            <label for="<?php echo esc_attr($name) ?>"><?php echo esc_html($title) ?></label>
            <select name="<?php echo esc_attr($name) ?>" id="<?php echo esc_attr($name) ?>">
                <?php if (is_array($options)) :
                    foreach ($options as $key => $value) : ?>
                        <option value="<?php echo esc_attr($key) ?>"><?php echo esc_html( $value ); ?></option>
                    <?php endforeach;
                endif; ?>
            </select>
            <?php if ($desc) : ?><p><?php echo esc_html($desc) ?></p><?php endif; ?>
        </div>
    <?php endif;

    if ($type == "upload") : // upload image ?>
        <div class="form-field">
            <label for="<?php echo esc_attr($name) ?>"><?php echo esc_html($title) ?></label>
            <label for='upload_image'>
                <input style="margin-bottom:5px;" type="text" name="<?php echo esc_attr($name) ?>"  id="<?php echo esc_attr($name) ?>" /><br/>
                <button class="button_upload_image button" id="<?php echo esc_attr($name) ?>"><?php echo esc_html__('Upload Image', 'solaz') ?></button>
                <button class="button_remove_image button" id="<?php echo esc_attr($name) ?>"><?php echo esc_html__('Remove Image', 'solaz') ?></button>
            </label>
            <?php if ($desc) : ?><p><?php echo esc_html($desc) ?></p><?php endif; ?>
        </div>
    <?php endif; 

    if ($type == "editor") : // editor ?>
        <div class="form-field">
            <label for="<?php echo esc_attr($name) ?>"><?php echo esc_html($title) ?></label>
            <?php wp_editor( '', $name ) ?>
            <?php if ($desc) : ?><p><?php echo esc_html($desc) ?></p><?php endif; ?>
        </div>
    <?php endif;

    if ($type == "textarea") : // textarea ?>
        <div class="form-field">
            <label for="<?php echo esc_attr($name) ?>"><?php echo esc_html($title) ?></label>
            <textarea id="<?php echo esc_attr($name) ?>" name="<?php echo esc_attr($name) ?>"></textarea>
            <?php if ($desc) : ?><p><?php echo esc_html($desc) ?></p><?php endif; ?>
        </div>
    <?php endif;

    if (($type == 'radio') && (!empty($options))) : // radio buttons ?>
        <div class="form-field">
            <label for="<?php echo esc_attr($name) ?>"><?php echo esc_html($title) ?></label>
            <?php foreach ($options as $key => $value) : ?>
                <input style="display:inline-block; width:auto;" type="radio" id="<?php echo esc_attr($name) ?>_<?php echo esc_attr($key) ?>" name="<?php echo esc_attr($name) ?>"  value="<?php echo esc_attr($key) ?>"/>
                <label style="display:inline-block" for="<?php echo esc_attr($name) ?>_<?php echo esc_attr($key) ?>"><?php echo esc_html( $value ); ?></label>
            <?php endforeach; ?>
            <?php if ($desc) : ?><p><?php echo esc_html($desc) ?></p><?php endif; ?>
        </div>
    <?php endif;

    if ($type == "checkbox") : // checkbox ?>
        <div class="form-field">
            <label for="<?php echo esc_attr($name) ?>"><?php echo esc_html($title) ?></label>
            <label><input style="display:inline-block; width:auto;" type="checkbox" name="<?php echo esc_attr($name) ?>" value="<?php echo esc_attr($name) ?>" /> <?php echo esc_html($desc) ?></label>
        </div>
    <?php endif;

    if (($type == 'multi_checkbox') && (!empty($options))) : // radio buttons ?>
        <div class="form-field">
            <label for="<?php echo esc_attr($name) ?>"><?php echo esc_html($title) ?></label>
            <?php foreach ($options as $key => $value) : ?>
                <input style="display:inline-block; width:auto;" type="checkbox" id="<?php echo esc_attr($name) ?>_<?php echo esc_attr($key) ?>" name="<?php echo esc_attr($name) ?>[]" value="<?php echo esc_attr($key) ?>" />
                <label style="display:inline-block" for="<?php echo esc_attr($name) ?>_<?php echo esc_attr($key) ?>"><?php echo esc_html( $value ); ?></label>
            <?php endforeach; ?>
            <?php if ($desc) : ?><p><?php echo esc_html($desc) ?></p><?php endif; ?>
        </div>
    <?php endif;
}

// Show Taxonomy Add Meta Boxes
function solaz_show_tax_edit_meta_boxes($tag, $taxonomy, $meta_boxes) {
    if (!isset($meta_boxes) || empty($meta_boxes))
        return;

    foreach ($meta_boxes as $meta_box) {
        solaz_show_tax_edit_meta_box($tag, $taxonomy, $meta_box);
    }
}

// Show Taxonomy Add Meta Box
function solaz_show_tax_edit_meta_box($tag, $taxonomy, $meta_box) {

    extract(shortcode_atts(array(
        "name" => '',
        "title" => '',
        "desc" => '',
        "type" => '',
        "default" => '',
        "options" => ''
    ), $meta_box));

    ?>

    <input type="hidden" name="<?php echo esc_attr($name) ?>_noncename" id="<?php echo esc_attr($name) ?>_noncename" 
        value="<?php echo wp_create_nonce( plugin_basename(__FILE__) ) ?>" />

    <?php
    $meta_box_value = get_metadata($tag->taxonomy, $tag->term_id, $name, true);

    if ($meta_box_value == "")
        $meta_box_value = $default;

    if ($type == "text") : // text ?>
        <tr class="form-field">
            <th scope="row" valign="top"><label for="<?php echo esc_attr($name) ?>"><?php echo esc_html($title) ?></label></th>
            <td>
                <input type="text" id="<?php echo esc_attr($name) ?>" name="<?php echo esc_attr($name) ?>" value="<?php echo stripslashes($meta_box_value) ?>" size="50%" />
                <?php if ($desc) : ?><p class="description"><?php echo esc_html($desc) ?></p><?php endif; ?>
            </td>
        </tr>
    <?php endif;

    if ($type == "select") : // select ?>
        <tr class="form-field">
            <th scope="row" valign="top"><label for="<?php echo esc_attr($name) ?>"><?php echo esc_html($title) ?></label></th>
            <td>
                <select name="<?php echo esc_attr($name) ?>" id="<?php echo esc_attr($name) ?>">
                    <?php if (is_array($options)) :
                        foreach ($options as $key => $value) : ?>
                            <option value="<?php echo esc_attr($key) ?>"<?php echo $meta_box_value == $key ? ' selected="selected"' : '' ?>><?php echo esc_html( $value ); ?></option>
                        <?php endforeach;
                    endif; ?>
                </select>
                <?php if ($desc) : ?><p class="description"><?php echo esc_html($desc) ?></p><?php endif; ?>
            </td>
        </tr>
    <?php endif; 

    if ($type == "upload") : // upload image ?>
        <tr class="form-field">
            <th scope="row" valign="top"><label for="<?php echo esc_attr($name) ?>"><?php echo esc_html($title) ?></label></th>
            <td>
                <label for='upload_image'>
                    <input style="margin-bottom:5px;" value="<?php echo stripslashes($meta_box_value) ?>" type="text" name="<?php echo esc_attr($name) ?>"  id="<?php echo esc_attr($name) ?>" size="50%" />
                    <br/>
                    <button class="button_upload_image button" id="<?php echo esc_attr($name) ?>"><?php echo esc_html__('Upload Image', 'solaz') ?></button>
                    <button class="button_remove_image button" id="<?php echo esc_attr($name) ?>"><?php echo esc_html__('Remove Image', 'solaz') ?></button>
                </label>
                <?php if ($desc) : ?><p class="description"><?php echo esc_html($desc) ?></p><?php endif; ?>
            </td>
        </tr>
    <?php endif; 

    if ($type == "editor") : // editor ?>
        <tr class="form-field">
            <th colspan="2" scope="row" valign="top"><label for="<?php echo esc_attr($name) ?>"><?php echo esc_html($title) ?></label></th>
        <tr>
            <td colspan="2">
                <?php wp_editor( $meta_box_value, $name ) ?>
                <?php if ($desc) : ?><p class="description"><?php echo esc_html($desc) ?></p><?php endif; ?>
            </td>
        </tr>
    <?php endif;

    if ($type == "textarea") : // textarea ?>
        <tr class="form-field">
            <th scope="row" valign="top"><label for="<?php echo esc_attr($name) ?>"><?php echo esc_html($title) ?></label></th>
            <td>
                <textarea id="<?php echo esc_attr($name) ?>" name="<?php echo esc_attr($name) ?>"><?php echo stripslashes($meta_box_value) ?></textarea>
                <?php if ($desc) : ?><p class="description"><?php echo esc_html($desc) ?></p><?php endif; ?>
            </td>
        </tr>
    <?php endif;

    if (($type == 'radio') && (!empty($options))) : // radio buttons ?>
        <tr class="form-field">
            <th scope="row" valign="top"><label for="<?php echo esc_attr($name) ?>"><?php echo esc_html($title) ?></label></th>
            <td>
                <?php foreach ($options as $key => $value) : ?>
                    <input style="display:inline-block; width:auto;" type="radio" id="<?php echo esc_attr($name) ?>_<?php echo esc_attr($key) ?>" name="<?php echo esc_attr($name) ?>"  value="<?php echo esc_attr($key) ?>"
                        <?php echo (isset($meta_box_value) && ($meta_box_value == $key) ? ' checked="checked"' : '') ?>/>
                    <label for="<?php echo esc_attr($name) ?>_<?php echo esc_attr($key) ?>"><?php echo esc_html( $value ); ?></label>
                <?php endforeach; ?>
                <?php if ($desc) : ?><p class="description"><?php echo esc_html($desc) ?></p><?php endif; ?>
            </td>
        </tr>
    <?php endif; 

    if ($type == "checkbox") :  // checkbox ?>
        <?php if ( $meta_box_value == $name ) {
            $checked = "checked=\"checked\"";
        } else {
            $checked = "";
        } ?>
        <tr class="form-field">
            <th scope="row" valign="top"><label for="<?php echo esc_attr($name) ?>"><?php echo esc_html($title) ?></label></th>
            <td>
                <label><input style="display:inline-block; width:auto;" type="checkbox" name="<?php echo esc_attr($name) ?>" value="<?php echo esc_attr($name) ?>" <?php echo esc_attr($checked) ?> /> <?php echo esc_html($desc) ?></label>
            </td>
        </tr>
    <?php endif;

    if (($type == 'multi_checkbox') && (!empty($options))) : // radio buttons ?>
        <tr class="form-field">
            <th scope="row" valign="top"><label for="<?php echo esc_attr($name) ?>"><?php echo esc_html($title) ?></label></th>
            <td>
                <?php foreach ($options as $key => $value) : ?>
                    <input style="display:inline-block; width:auto;" type="checkbox" id="<?php echo esc_attr($name) ?>_<?php echo esc_attr($key) ?>" name="<?php echo esc_attr($name) ?>[]" value="<?php echo esc_attr($key) ?>" <?php echo ((isset($meta_box_value) && in_array($key, explode(',', $meta_box_value))) ? ' checked="checked"' : '') ?>/>
                    <label for="<?php echo esc_attr($name) ?>_<?php echo esc_attr($key) ?>"> <?php echo esc_html( $value ); ?></label>
                <?php endforeach; ?>
                <?php if ($desc) : ?><p class="description"><?php echo esc_html($desc) ?></p><?php endif; ?>
            </td>
        </tr>
    <?php endif;
}

// Save Tax Data
function solaz_save_taxdata( $term_id, $tt_id, $taxonomy, $meta_boxes ) {
    if (!isset($meta_boxes) || empty($meta_boxes))
        return;

    foreach ($meta_boxes as $meta_box) {

        extract(shortcode_atts(array(
            "name" => '',
            "title" => '',
            "desc" => '',
            "type" => '',
            "default" => '',
            "options" => ''
        ), $meta_box));

        if ( !isset($_POST[$name.'_noncename']))
            return;

        if ( !wp_verify_nonce( $_POST[$name.'_noncename'], plugin_basename(__FILE__) ) ) {
            return;
        }

        $meta_box_value = get_metadata($taxonomy, $term_id, $name, true);

        if (!isset($_POST[$name])) {
            delete_metadata($taxonomy, $term_id, $name, $meta_box_value);
            continue;
        }

        $data = $_POST[$name];

        if (is_array($data))
            $data = implode(',', $data);

        if (!$meta_box_value && !$data)
            add_metadata($taxonomy, $term_id, $name, $data, true);
        elseif ($data != $meta_box_value)
            update_metadata($taxonomy, $term_id, $name, $data);
        elseif (!$data)
            delete_metadata($taxonomy, $term_id, $name, $meta_box_value);
    }
}

// Create Meta Table
function solaz_create_metadata_table($table_name, $type) {
    global $wpdb;

    if (!empty ($wpdb->charset))
        $charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset}";
    if (!empty ($wpdb->collate))
        $charset_collate .= " COLLATE {$wpdb->collate}";

    if ( get_option( 'solaz_'.$table_name ) )
        return false;

    if (!$wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
        $sql = "CREATE TABLE {$table_name} (
            meta_id bigint(20) NOT NULL AUTO_INCREMENT,
            {$type}_id bigint(20) NOT NULL default 0,
            meta_key varchar(255) DEFAULT NULL,
            meta_value longtext DEFAULT NULL,
            UNIQUE KEY meta_id (meta_id)
        ) {$charset_collate};";
        $wpdb->query($sql);
        update_option( 'solaz_'.$table_name, true );
    }

    return true;
}
function solaz_meta_page_assets(){
    wp_enqueue_script( 'solaz-metabox', get_template_directory_uri() . '/inc/functions/metaboxes/js/metabox.js', array('jquery'), SOLAZ_VERSION, true); 
    wp_enqueue_style("solaz-page-metabox-style",get_template_directory_uri().'/inc/functions/metaboxes/css/metabox.css?ver=' . SOLAZ_VERSION);
}
add_action('admin_enqueue_scripts', 'solaz_meta_page_assets' );
?>