<?php

function solaz_iconpicker_type_pestrokefont( $icons ) {
    $pestrokefont_icons = array(
        array( 'pe-7s-back-2' => 'Back 2' ),
        array( 'pe-7s-next-2' => 'Next 2'),
        array( 'pe-7s-piggy' => 'Piggy' ),
        array( 'pe-7s-gift' => 'Gift' ),
        array( 'pe-7s-arc' => 'Archor' ),
        array( 'pe-7s-plane' => 'Plane' ),
        array( 'pe-7s-help2' => 'Help' ),
        array( 'pe-7s-clock' => 'Clock' ),
        array( 'pe-7s-junk' => 'Junk' ),
        array( 'pe-7s-edit' => 'Edit' ),
        array( 'pe-7s-download' => 'Download' ),
        array( 'pe-7s-config' => 'Config' ),
        array( 'pe-7s-drop' => 'Drop' ),
        array( 'pe-7s-refresh' => 'Refresh' ),
        array( 'pe-7s-album' => 'Album' ),
        array( 'pe-7s-diamond' => 'Diamond' ),
        array( 'pe-7s-door-lock' => 'Door lock' ),
        array( 'pe-7s-photo' => 'Photo' ),
        array( 'pe-7s-settings' => 'Settings' ),
        array( 'pe-7s-volume' => 'Volumn' ),
        array( 'pe-7s-users' => 'Users' ),
        array( 'pe-7s-tools' => 'Tools' ),
        array( 'pe-7s-star' => 'Star' ),
        array( 'pe-7s-like2' => 'Like' ),
        array( 'pe-7s-map-2' => 'Map 2' ),
        array( 'pe-7s-call' => 'Call' ),
        array( 'pe-7s-mail' => 'Mail' ),
        array( 'pe-7s-way' => 'Way' ),
        array( 'pe-7s-edit' => 'Edit' ),
        array( 'pe-7s-drop' => 'Drop' ),
        array( 'pe-7s-download' => 'Download' ),
        array( 'pe-7s-config' => 'Config' ),
        array( 'pe-7s-junk' => 'Junk' ),
        array( 'pe-7s-magic-wand' => 'Magic' ),
        array( 'pe-7s-like' => 'Like' ),
        array( 'pe-7s-cup' => 'Cup' ),
        array( 'pe-7s-cash' => 'Cash' ),
        array( 'pe-7s-target' => 'Target' ),
    );

    return array_merge( $icons, $pestrokefont_icons );
}

add_filter( 'vc_iconpicker-type-pestrokefont', 'solaz_iconpicker_type_pestrokefont' );
function solaz_iconpicker_type_solazfont( $icons ) {
    $solazfont_icons = array(
        array( 'icon-1' => '' ),
        array( 'icon-2' => '' ),
        array( 'icon-3' => '' ),
        array( 'icon-4' => '' ),
        array( 'icon-5' => '' ),
        array( 'icon-6' => '' ),
        array( 'icon-7' => '' ),
        array( 'icon-8' => '' ),
        array( 'icon-9' => '' ),
        array( 'icon-10' => '' ),
        array( 'icon-11' => '' ),
        array( 'icon-12' => '' ),
        array('icon-arrow-right' => ''),
        array( 'icon-eye' => ''),
    );
    return array_merge( $icons, $solazfont_icons );
}
add_filter( 'vc_iconpicker-type-solazfont', 'solaz_iconpicker_type_solazfont' );
function solaz_vc_icon() {
    $attributes = array(
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Icon library', 'solaz'),
            'value' => array(
                esc_html__('Font Awesome', 'solaz') => 'fontawesome',
                esc_html__('Stroke Icons 7', 'solaz') => 'pestrokefont',
                esc_html__('Solaz Icon', 'solaz') => 'solazfont',
                esc_html__('Open Iconic', 'solaz') => 'openiconic',
                esc_html__('Typicons', 'solaz') => 'typicons',
                esc_html__('Entypo', 'solaz') => 'entypo',
                esc_html__('Linecons', 'solaz') => 'linecons',
            ),
            'admin_label' => true,
            'param_name' => 'type',
            'weight' => 10,
            'description' => esc_html__('Select icon library.', 'solaz'),
        ),
        array(
            'type' => 'iconpicker',
            'heading' => esc_html__('Icon', 'solaz'),
            'param_name' => 'icon_pestrokefont',
            'settings' => array(
                'emptyIcon' => false, // default true, display an "EMPTY" icon?
                'type' => 'pestrokefont',
                'iconsPerPage' => 4000, // default 100, how many icons per/page to display
            ),
            'dependency' => array(
                'element' => 'type',
                'value' => 'pestrokefont',
            ),
            'weight' => 9,
            'description' => esc_html__('Select icon from library.', 'solaz'),
        ),
        array(
            'type' => 'iconpicker',
            'heading' => esc_html__('Icon', 'solaz'),
            'param_name' => 'icon_solazfont',
            'settings' => array(
                'emptyIcon' => false, // default true, display an "EMPTY" icon?
                'type' => 'solazfont',
                'iconsPerPage' => 4000, // default 100, how many icons per/page to display
            ),
            'dependency' => array(
                'element' => 'type',
                'value' => 'solazfont',
            ),
            'weight' => 9,
            'description' => esc_html__('Select icon from library.', 'solaz'),
        ),
        array(
            'type' => 'iconpicker',
            'heading' => esc_html__('Icon', 'solaz'),
            'param_name' => 'icon_fontawesome',
            'value' => 'fa fa-adjust', // default value to backend editor admin_label
            'settings' => array(
                'emptyIcon' => false,
                // default true, display an "EMPTY" icon?
                'iconsPerPage' => 4000,
            // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
            ),
            'dependency' => array(
                'element' => 'type',
                'value' => 'fontawesome',
            ),
            'description' => esc_html__('Select icon from library.', 'solaz'),
        ),
        array(
            'type' => 'iconpicker',
            'heading' => esc_html__('Icon', 'solaz'),
            'param_name' => 'icon_openiconic',
            'value' => 'vc-oi vc-oi-dial', // default value to backend editor admin_label
            'settings' => array(
                'emptyIcon' => false, // default true, display an "EMPTY" icon?
                'type' => 'openiconic',
                'iconsPerPage' => 4000, // default 100, how many icons per/page to display
            ),
            'dependency' => array(
                'element' => 'type',
                'value' => 'openiconic',
            ),
            'description' => esc_html__('Select icon from library.', 'solaz'),
        ),
        array(
            'type' => 'iconpicker',
            'heading' => esc_html__('Icon', 'solaz'),
            'param_name' => 'icon_typicons',
            'value' => 'typcn typcn-adjust-brightness', // default value to backend editor admin_label
            'settings' => array(
                'emptyIcon' => false, // default true, display an "EMPTY" icon?
                'type' => 'typicons',
                'iconsPerPage' => 4000, // default 100, how many icons per/page to display
            ),
            'dependency' => array(
                'element' => 'type',
                'value' => 'typicons',
            ),
            'description' => esc_html__('Select icon from library.', 'solaz'),
        ),
        array(
            'type' => 'iconpicker',
            'heading' => esc_html__('Icon', 'solaz'),
            'param_name' => 'icon_entypo',
            'value' => 'entypo-icon entypo-icon-note', // default value to backend editor admin_label
            'settings' => array(
                'emptyIcon' => false, // default true, display an "EMPTY" icon?
                'type' => 'entypo',
                'iconsPerPage' => 4000, // default 100, how many icons per/page to display
            ),
            'dependency' => array(
                'element' => 'type',
                'value' => 'entypo',
            ),
        ),
        array(
            'type' => 'iconpicker',
            'heading' => esc_html__('Icon', 'solaz'),
            'param_name' => 'icon_linecons',
            'value' => 'vc_li vc_li-heart', // default value to backend editor admin_label
            'settings' => array(
                'emptyIcon' => false, // default true, display an "EMPTY" icon?
                'type' => 'linecons',
                'iconsPerPage' => 4000, // default 100, how many icons per/page to display
            ),
            'dependency' => array(
                'element' => 'type',
                'value' => 'linecons',
            ),
            'description' => esc_html__('Select icon from library.', 'solaz'),
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Icon alignment', 'solaz' ),
            'param_name' => 'align',
            'value' => array(
                esc_html__( 'Left', 'solaz' ) => 'left',
                esc_html__( 'Right', 'solaz' ) => 'right',
                esc_html__( 'Center', 'solaz' ) => 'center',
                esc_html__( 'Inline', 'solaz' ) => 'inline',
            ),
            'description' => esc_html__( 'Select icon alignment.', 'solaz' ),
             "group"     => "Icon Style",
        ),
        array(
            'type' => 'number',
            'heading' => esc_html__( 'Size', 'solaz' ),
            'param_name' => 'size',
            "value" => "14",
            'description' => esc_html__( 'Icon size (px)', 'solaz' ),
             "group"     => "Icon Style",
        ),
        array(
            "type" => "dropdown",
            "class" => "",
            "heading" => esc_html__("Border Style", "solaz"),
            "param_name" => "icon_border_style",
            "value" => array(
                esc_html__("None","solaz") => "none",
                esc_html__("Solid","solaz")   => "solid",
                esc_html__("Dashed","solaz") => "dashed",
                esc_html__("Dotted","solaz") => "dotted",
                esc_html__("Double","solaz") => "double",
                esc_html__("Inset","solaz") => "inset",
                esc_html__("Outset","solaz") => "outset",
            ),
            "description" => esc_html__("Select the border style for icon.","solaz"),
            "dependency" => Array("element" => "background_style", "value" => array("rounded-outline","boxed-outline", "rounded-less-outline")),
            "group"     => "Icon Style",
        ),
        array(
            'type' => 'checkbox',
            'heading' => esc_html__( 'Enable hover state for icon', 'solaz' ),
            'param_name' => 'icon_hover',
            'value' => true,
             "group"     => "Icon Style",
        ),
        array(
            "type" => "textarea_html",
            "holder" => "div",
            "class" => "",
            "heading" => esc_html__( "Content", "solaz" ),
            "param_name" => "content", // Important: Only one textarea_html param per content element allowed and it should have "content" as a "param_name"
            "description" => esc_html__( "Enter your content.", "solaz" ),
            'group' => esc_html__( 'Content', 'solaz' )
        )
    );

    vc_add_params('vc_icon', $attributes);

}

add_action('vc_before_init', 'solaz_vc_icon');

function solaz_vc_column() {
    $attributes = array(
        array(
            'type' => 'checkbox',
            'heading' => esc_html__("Add overlay background", "solaz"),
            'param_name' => 'overlay',
            'value' => array( esc_html__( 'Yes', 'solaz' ) => 'yes' ),
            'weight' => 5,
        ),
        array(
            'type' => 'checkbox',
            'heading' => esc_html__("Align inside element center horizontally and vertically", "solaz"),
            'param_name' => 'center_element',
            'value' => array( esc_html__( 'Yes', 'solaz' ) => 'yes' ),
            'weight' => 5,
        ),        
    );
    vc_add_params('vc_column', $attributes); 
}
add_action('vc_before_init', 'solaz_vc_column'); 
function solaz_vc_row() {
    $attributes = array(
        array(
            'type' => 'checkbox',
            'heading' => esc_html__("Wrap inside column in container", "solaz"),
            'param_name' => 'wrap_container',
            'value' => array( esc_html__( 'Yes', 'solaz' ) => 'yes' ),
            'weight' => 5,
        ),
        array(
            'type' => 'checkbox',
            'heading' => esc_html__("Hide background in mobile", "solaz"),
            'param_name' => 'hide_bg_mobile',
            'value' => array( esc_html__( 'Yes', 'solaz' ) => 'yes' ),
            'weight' => 5,
        ),
    );
    vc_add_params('vc_row', $attributes); 
}
add_action('vc_before_init', 'solaz_vc_row'); 
function solaz_vc_row_inner() {
    $attributes = array(
        array(
            'type' => 'checkbox',
            'heading' => esc_html__("Wrap inside column in container", "solaz"),
            'param_name' => 'wrap_container',
            'value' => array( esc_html__( 'Yes', 'solaz' ) => 'yes' ),
            'weight' => 5,
        ),
    );
    vc_add_params('vc_row_inner', $attributes); 
}
add_action('vc_before_init', 'solaz_vc_row_inner'); 

function solaz_vc_gallery() {
    $attributes = array(
        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Number of columns', 'solaz' ),
            'param_name' => 'col_num',
            'value' => array(
                esc_html__( 'Default', 'solaz' ) => 'default',
                esc_html__( '2', 'solaz' ) => '2',
                esc_html__( '3', 'solaz' ) => '3',
                esc_html__( '4', 'solaz' ) => '4',
                esc_html__( '5', 'solaz' ) => '5',
            ),
            'description' => esc_html__( 'Select number of columns to display images.', 'solaz' ),
             "group"     => esc_html__( "Column numbers", 'solaz' ),
            'dependency' => array(
                'element' => 'type',
                'value' => 'image_grid',
            ),
        ),
    );

    vc_add_params('vc_gallery', $attributes);

}

add_action('vc_before_init', 'solaz_vc_gallery');



