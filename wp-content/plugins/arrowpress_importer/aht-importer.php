<?php
/*
Plugin Name: ArrowPress Importer
Plugin URI: 
Description: Import Demo Content For Theme
Version: 1.0.0
Author: ArrowPress
Author URI: 
*/


add_action('admin_menu', 'aht_add_demo_import_page');

if ( ! function_exists('aht_add_demo_import_page'))
{
	function aht_add_demo_import_page()
	{
		add_theme_page( esc_html__( 'Import Demos', 'solaz' ) , esc_html__( 'Import Demos', 'solaz' ) , 'manage_options' , 'aht_demo_import' , 'aht_demo_import' );
	}
}
function aht_demo_types() {
    return array(
        'home_1' => array('alt' => esc_html__('Home 1', 'solaz'), 'img' => plugin_dir_url( __FILE__ ) . '/assets/images/home_1.jpg'),
        'home_2' => array('alt' => esc_html__('Home 2', 'solaz'), 'img' => plugin_dir_url( __FILE__ ) . '/assets/images/home_2.jpg'),
        'home_3' => array('alt' => esc_html__('Home 3', 'solaz'), 'img' => plugin_dir_url( __FILE__ ) . '/assets/images/home_3.jpg'),
        'home_4' => array('alt' => esc_html__('Home 4', 'solaz'), 'img' => plugin_dir_url( __FILE__ ) . '/assets/images/home_4.jpg'),
    );
}
function aht_import_widgets( $widget_data ) {
    $json_data = $widget_data;
    $json_data = json_decode( $json_data, true );

    $sidebar_data = $json_data[0];
    $widget_data  = $json_data[1];

    foreach ($widget_data as $widget_data_title => $widget_data_value) {
        $widgets[$widget_data_title] = '';
        foreach ($widget_data_value as $widget_data_key => $widget_data_array) {
            if (is_int($widget_data_key)) {
                if($widget_data_title == 'nav_menu') {
                    if($widget_data_key == 1) {
                        $sidebar_menu = wp_get_nav_menu_object('Main menu');
                        if($sidebar_menu->term_id) {
                            $widget_data[$widget_data_title][$widget_data_key]['nav_menu'] = $sidebar_menu->term_id;     
                        }
                    }
                }
                $widgets[$widget_data_title][$widget_data_key] = 'on';
            }
        }
    }
    unset( $widgets[""] );

    foreach ( $sidebar_data as $title => $sidebar ) {
        $count = count( $sidebar );
        for ( $i = 0; $i < $count; $i ++ ) {
            $widget               = array();
            $widget['type']       = trim( substr( $sidebar[ $i ], 0, strrpos( $sidebar[ $i ], '-' ) ) );
            $widget['type-index'] = trim( substr( $sidebar[ $i ], strrpos( $sidebar[ $i ], '-' ) + 1 ) );
            if ( ! isset( $widgets[ $widget['type'] ][ $widget['type-index'] ] ) ) {
                unset( $sidebar_data[ $title ][ $i ] );
            }
        }
        $sidebar_data[ $title ] = array_values( $sidebar_data[ $title ] );
    }

    foreach ( $widgets as $widget_title => $widget_value ) {
        foreach ( $widget_value as $widget_key => $widget_value ) {
            $widgets[ $widget_title ][ $widget_key ] = $widget_data[ $widget_title ][ $widget_key ];
        }
    }

    $sidebar_data = array( array_filter( $sidebar_data ), $widgets );

    aht_widget_parse_import_data( $sidebar_data );
}
function aht_widget_parse_import_data( $import_array ) {
    global $wp_registered_sidebars;
    $sidebars_data    = $import_array[0];
    $widget_data      = $import_array[1];
    $current_sidebars = get_option( 'sidebars_widgets' );
    $new_widgets      = array();

    foreach ( $sidebars_data as $import_sidebar => $import_widgets ) :

        foreach ( $import_widgets as $import_widget ) :
            //if the sidebar exists
            if ( isset( $wp_registered_sidebars[ $import_sidebar ] ) ) :
                $title               = trim( substr( $import_widget, 0, strrpos( $import_widget, '-' ) ) );
                $index               = trim( substr( $import_widget, strrpos( $import_widget, '-' ) + 1 ) );
                $current_widget_data = get_option( 'widget_' . $title );
                $new_widget_name     = aht_get_new_widget_name( $title, $index );
                $new_index           = trim( substr( $new_widget_name, strrpos( $new_widget_name, '-' ) + 1 ) );

                if ( ! empty( $new_widgets[ $title ] ) && is_array( $new_widgets[ $title ] ) ) {
                    while ( array_key_exists( $new_index, $new_widgets[ $title ] ) ) {
                        $new_index ++;
                    }
                }
                $current_sidebars[ $import_sidebar ][] = $title . '-' . $new_index;
                if ( array_key_exists( $title, $new_widgets ) ) {
                    $new_widgets[ $title ][ $new_index ] = $widget_data[ $title ][ $index ];
                    $multiwidget                         = $new_widgets[ $title ]['_multiwidget'];
                    unset( $new_widgets[ $title ]['_multiwidget'] );
                    $new_widgets[ $title ]['_multiwidget'] = $multiwidget;
                } else {
                    $current_widget_data[ $new_index ] = $widget_data[ $title ][ $index ];
                    $current_multiwidget               = isset( $current_widget_data['_multiwidget'] ) ? $current_widget_data['_multiwidget'] : false;
                    $new_multiwidget                   = isset( $widget_data[ $title ]['_multiwidget'] ) ? $widget_data[ $title ]['_multiwidget'] : false;
                    $multiwidget                       = ( $current_multiwidget != $new_multiwidget ) ? $current_multiwidget : 1;
                    unset( $current_widget_data['_multiwidget'] );
                    $current_widget_data['_multiwidget'] = $multiwidget;
                    $new_widgets[ $title ]               = $current_widget_data;
                }

            endif;
        endforeach;
    endforeach;

    if ( isset( $new_widgets ) && isset( $current_sidebars ) ) {
        update_option( 'sidebars_widgets', $current_sidebars );

        foreach ( $new_widgets as $title => $content ) {
            update_option( 'widget_' . $title, $content );
        }

        return true;
    }

    return false;
}

function aht_get_new_widget_name( $widget_name, $widget_index ) {
    $current_sidebars = get_option( 'sidebars_widgets' );
    $all_widget_array = array();
    foreach ( $current_sidebars as $sidebar => $widgets ) {
        if ( ! empty( $widgets ) && is_array( $widgets ) && $sidebar != 'wp_inactive_widgets' ) {
            foreach ( $widgets as $widget ) {
                $all_widget_array[] = $widget;
            }
        }
    }
    while ( in_array( $widget_name . '-' . $widget_index, $all_widget_array ) ) {
        $widget_index ++;
    }
    $new_widget_name = $widget_name . '-' . $widget_index;

    return $new_widget_name;
}
if ( !function_exists('aht_demo_import'))
{
	function aht_demo_import()
	{
		?>
		<div class="aht_message content" style="display:none;">
			<img src="<?php echo plugin_dir_url( __FILE__ ) ?>assets/images/spinner.gif" alt="spinner">
			<h1 class="aht_message_title"><?php esc_html_e('Importing Demo Content...', 'solaz'); ?></h1>
			<p class="aht_message_text"><?php esc_html_e('Duration of demo content importing depends on your server speed.', 'solaz'); ?></p>
		</div>

		<div class="aht_message success" style="display:none;">
			<p class="aht_message_text"><?php echo wp_kses( sprintf(__('Congratulations and enjoy <a href="%s" target="_blank">your website</a> now!', 'solaz'), esc_url( home_url() )), array( 'a' => array( 'href' => array(), 'target' => array() ) ) ); ?></p>
		</div>

		<form class="aht_importer" id="import_demo_data_form" action="?page=aht_demo_import" method="post">

			<div class="aht_importer_options">

				<div class="aht_importer_note">
					<strong><?php esc_html_e('Before installing the demo content, please NOTE:', 'solaz'); ?></strong>
					<p class="about-description"><?php echo esc_html__( 'If Demo not contains revolution slider. You need select slider when edit page in sidebar page. NOTE: Make sure to read.', 'solaz' ); ?><a href="http://demo.arrowpress.net/solaz-gui/#toc15" target="_blank" ><?php echo esc_html__(' our demo installation guide','solaz')?></a>  <?php echo esc_html__('before importing demo','solaz')?></p>
        		<p class="about-description"><?php echo esc_html__( 'You need to install the first dummy content before importing home page.', 'solaz' ); ?></p>
				</div>
				<p>
					<strong style="font-size:25px;margin-top:15px;"><?php esc_html_e('Choose a demo template to import:', 'solaz'); ?></strong>
				</p>
				<?php 
					$demos = aht_demo_types();
				?>
				<div class="aht_demo_import_choices">
                    <div class="title_base_dummy_content">
                        <h3>Import base dummy content</h3>
                    </div>
					<div class="base_dummy_content">
                        <p>Start working with our template by installing base demo content. Then you will get the opportunity to install the Home Page from the provided below list.</p>
						<img width="300" height="250" src="<?php echo plugin_dir_url( __FILE__ ) ?>assets/images/dummy-content.jpg" />
						<div class="aht_choice_radio_button">
							<input type="radio" name="demo_template" value="dummy-content" checked="1"/>
							<?php esc_html_e('Dummy Content (Required)', 'solaz'); ?>
						</div>
					</div>
                    <div class="title_base_dummy_content">
                        <h3>Import demo versions</h3>
                    </div>
					<?php foreach ( $demos as $demo => $demo_details) : ?>
					<label>
						<img width="230" height="200" src="<?php echo esc_url($demo_details['img']); ?>" />
						<div class="aht_choice_radio_button">
							<input type="radio" name="demo_template" value="<?php echo esc_attr($demo); ?>"/>
							<?php echo esc_html($demo_details['alt']); ?>
						</div>
					</label>
					<?php endforeach;?>
				</div>
				<p class="aht_demo_button_align">
					<input class="button-primary size_big" type="submit" value="Import Content" id="import_demo_data">
				</p>
			</div>

		</form>
		<script type="text/javascript">
			jQuery(document).ready(function() {
				jQuery('#import_demo_data_form').on('submit', function() {
					jQuery("html, body").animate({
						scrollTop: 0
					}, {
						duration: 300
					});
					jQuery('.aht_importer').slideUp(null, function(){
						jQuery('.aht_message.content').slideDown();
					});

					// Importing Content
					jQuery.ajax({
						type: 'POST',
						url: '<?php echo admin_url('admin-ajax.php'); ?>',
						data: jQuery(this).serialize()+'&action=aht_demo_import_content',
						success: function(){

							jQuery('.aht_message.content').slideUp();
							jQuery('.aht_message.success').slideDown();

						}
					});
					return false;
				});
			});
		</script>
		<?php
	}

	// Content Import
	function aht_demo_import_content() {
		
		$chosen_template = 'dummy-content';
		$demo_content = 'dummy-content';
		
		if(!empty($_POST['demo_template'])){
			$chosen_template = $_POST['demo_template'];
		}

		if($chosen_template == 'home_1') {
			$demo_content = 'home_1';
		}

        if($chosen_template == 'home_2') {
            $demo_content = 'home_2';
        }

		if($chosen_template == 'home_3') {
			$demo_content = 'home_3';
		}

		if($chosen_template == 'home_4') {
			$demo_content = 'home_4';
		}
		
		update_option('aht_chosen_template', $chosen_template);
		

		set_time_limit( 0 );

		if ( ! defined( 'WP_LOAD_IMPORTERS' ) ) {
			define( 'WP_LOAD_IMPORTERS', true );
		}

		require_once( 'wordpress-importer/wordpress-importer.php' );

		$wp_import                    = new WP_Import();
		$wp_import->fetch_attachments = true;

		ob_start();
		$wp_import->import( plugin_dir_path( __FILE__ ) . '/data/'.$demo_content.'/content.xml' );
		ob_end_clean();

		global $wp_filesystem;

        if ( empty( $wp_filesystem ) ) {
            require_once ABSPATH . '/wp-admin/includes/file.php';
            WP_Filesystem();
        }

        $locations = get_theme_mod( 'nav_menu_locations' );
        $menus = wp_get_nav_menus();

        if ($menus) {
            foreach ($menus as $menu) {
                if ($menu->name == 'Main menu') {
                    $locations['primary'] = $menu->term_id;
                }
            }
        }

        set_theme_mod( 'nav_menu_locations', $locations );

        update_option( 'show_on_front', 'page' );

        $chosen_template = 'dummy-content';

        $chosen_template = get_option('aht_chosen_template');

        // Main Content
        if($chosen_template == 'dummy-content') {
            /*Widgets*/
            $widgets_file = plugin_dir_path( __FILE__ ) . '/data/dummy-content/widget_data.json';
            if ( file_exists( $widgets_file ) ) {
                $encode_widgets_array = $wp_filesystem->get_contents( $widgets_file );
                aht_import_widgets( $encode_widgets_array );
            }

            $blog_page = get_page_by_title( 'Blog' );
            if ( isset( $blog_page->ID ) ) {
                update_option( 'page_for_posts', $blog_page->ID );
            }

            if ( class_exists( 'RevSlider' ) ) {
                $main_slider = plugin_dir_path( __FILE__ ) . '/data/home_1/home1.zip';

                if ( file_exists( $main_slider ) ) {
                    $slider = new RevSlider();
                    $slider->importSliderFromPost( true, true, $main_slider );
                }

                $main_slider = plugin_dir_path( __FILE__ ) . '/data/home_2/home2.zip';

                if ( file_exists( $main_slider ) ) {
                    $slider = new RevSlider();
                    $slider->importSliderFromPost( true, true, $main_slider );
                }

                $main_slider = plugin_dir_path( __FILE__ ) . '/data/home_3/home3.zip';

                if ( file_exists( $main_slider ) ) {
                    $slider = new RevSlider();
                    $slider->importSliderFromPost( true, true, $main_slider );
                }

                $main_slider = plugin_dir_path( __FILE__ ) . '/data/home_4/home4.zip';

                if ( file_exists( $main_slider ) ) {
                    $slider = new RevSlider();
                    $slider->importSliderFromPost( true, true, $main_slider );
                }
            }
        }

        // Home 1
        if($chosen_template == 'home_1') {
            //Theme Options    
            ob_start();
            include('data/home_1/theme_options.php');
            $theme_options = ob_get_clean();

            $options = json_decode($theme_options, true);
            $redux = ReduxFrameworkInstances::get_instance('solaz_settings');
            $redux->set_options($options);
            solaz_save_theme_settings();
            //front page
            $front_page = get_page_by_title( 'Home 1' );
            if ( isset( $front_page->ID ) ) {
                update_option( 'page_on_front', $front_page->ID );
            }

            $blog_page = get_page_by_title( 'Blog' );
            if ( isset( $blog_page->ID ) ) {
                update_option( 'page_for_posts', $blog_page->ID );
            }
        }
        // Home 2
        if($chosen_template == 'home_2') {
            //Theme Options    
            ob_start();
            include('data/home_2/theme_options.php');
            $theme_options = ob_get_clean();

            $options = json_decode($theme_options, true);
            $redux = ReduxFrameworkInstances::get_instance('solaz_settings');
            $redux->set_options($options);
            solaz_save_theme_settings();
            //front page
            $front_page = get_page_by_title( 'Home 2' );
            if ( isset( $front_page->ID ) ) {
                update_option( 'page_on_front', $front_page->ID );
            }

            $blog_page = get_page_by_title( 'Blog' );
            if ( isset( $blog_page->ID ) ) {
                update_option( 'page_for_posts', $blog_page->ID );
            }
        }
        // Home 1
        if($chosen_template == 'home_3') {
            //Theme Options    
            ob_start();
            include('data/home_3/theme_options.php');
            $theme_options = ob_get_clean();

            $options = json_decode($theme_options, true);
            $redux = ReduxFrameworkInstances::get_instance('solaz_settings');
            $redux->set_options($options);
            solaz_save_theme_settings();
            //front page
            $front_page = get_page_by_title( 'Home 3' );
            if ( isset( $front_page->ID ) ) {
                update_option( 'page_on_front', $front_page->ID );
            }

            $blog_page = get_page_by_title( 'Blog' );
            if ( isset( $blog_page->ID ) ) {
                update_option( 'page_for_posts', $blog_page->ID );
            }
        }
        // Home 4
        if($chosen_template == 'home_4') {
            //Theme Options    
            ob_start();
            include('data/home_4/theme_options.php');
            $theme_options = ob_get_clean();

            $options = json_decode($theme_options, true);
            $redux = ReduxFrameworkInstances::get_instance('solaz_settings');
            $redux->set_options($options);
            solaz_save_theme_settings();
            //front page
            $front_page = get_page_by_title( 'Home 4' );
            if ( isset( $front_page->ID ) ) {
                update_option( 'page_on_front', $front_page->ID );
            }

            $blog_page = get_page_by_title( 'Blog' );
            if ( isset( $blog_page->ID ) ) {
                update_option( 'page_for_posts', $blog_page->ID );
            }
        }

        

		echo 'done';
		die();

	}

	add_action( 'wp_ajax_aht_demo_import_content', 'aht_demo_import_content' );

}